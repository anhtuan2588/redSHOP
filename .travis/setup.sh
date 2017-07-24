#!/bin/bash
set -ev

if [ "${ACCEPTANCE}" = "false" ]; then
	git submodule update --init --recursive

	# Following line uses a bot account to authenticate in github and make composer stable and faster, see https://redweb.atlassian.net/wiki/pages/viewpage.action?pageId=46694753
	composer config -g github-oauth.github.com "${GITHUB_TOKEN}"
	composer global require hirak/prestissimo
	composer install --prefer-dist
	composer install --working-dir ./libraries/redshop --ansi
else
	npm install -g gulp-cli

	# forcing localhost to be the 1st alias of 127.0.0.1 in /etc/hosts (https://github.com/seleniumhq/selenium/issues/2074)
	sudo sed -i '1s/^/127.0.0.1 localhost\n/' /etc/hosts

	# sudo apt-get update -qq
  	# sudo apt-get install --yes --force-yes apache2 libapache2-mod-fastcgi

	sudo mkdir $(pwd)/.run
	phpversionname="$(phpenv version-name)"
	file="/home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.conf"
	sudo cp /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.conf.default /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.conf
	if [ -f /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.d/www.conf.default ]; then
		sudo cp /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.d/www.conf.default /home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.d/www.conf
		file=/home/$USER/.phpenv/versions/$phpversionname/etc/php-fpm.d/www.conf
	fi;
	sudo sed -e "s,listen = 127.0.0.1:9000,listen = /tmp/php${phpversionname:0:1}-fpm.sock,g" --in-place $file
	sudo sed -e "s,;listen.owner = nobody,listen.owner = $USER,g" --in-place $file
	sudo sed -e "s,;listen.group = nobody,listen.group = $USER,g" --in-place $file
	sudo sed -e "s,;listen.mode = 0660,listen.mode = 0666,g" --in-place $file
	sudo sed -e "s,user = nobody,;user = $USER,g" --in-place $file
	sudo sed -e "s,group = nobody,;group = $USER,g" --in-place $file
	sudo sudo a2enmod rewrite actions fastcgi alias
	echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$phpversionname/etc/php.ini
	~/.phpenv/versions/$(phpenv version-name)/sbin/php-fpm
	sudo a2dissite 000-default.conf
	sudo cp -f ./tests/travis-ci-apache.conf /etc/apache2/sites-available/000-default.conf
	sudo sed -e "s?%TRAVIS_BUILD_DIR%?$(pwd)?g" --in-place /etc/apache2/sites-available/000-default.conf
	sudo sed -e "s?%PHPVERSION%?${TRAVIS_PHP_VERSION:0:1}?g" --in-place /etc/apache2/sites-available/000-default.conf
	sudo a2ensite 000-default.conf
	sudo service apache2 restart

	# XVFB
	sh -e /etc/init.d/xvfb start
	sleep 3
	# Window manager
	sudo apt-get install fluxbox -y --force-yes
	fluxbox &
	sleep 3 # give fluxbox some time to start

	# Install redSHOP Library composer
	# composer config -g github-oauth.github.com "${GITHUB_TOKEN}"
	# composer global require hirak/prestissimo

	cd libraries/redshop
	composer install --prefer-dist

	cd ../../plugins/redshop_pdf/tcpdf/helper
	composer install --prefer-dist

	cd ../../../..
	composer install --prefer-dist

	# Gulp packages
	npm install
	mv gulp-config.sample.json gulp-config.json
	gulp release --skip-version
fi