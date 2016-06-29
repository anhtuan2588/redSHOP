<?php
/**
 * @package     Aesir.Backend
 * @subpackage  Layouts
 *
 * @copyright   Copyright (C) 2008 - 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die;


$app = JFactory::getApplication();
$doc = new RedshopHelperDocument;

// Disable template shit
$doc->disableStylesheet('administrator/templates/isis/css/template.css');
$doc->disableStylesheet('media/com_reditem/css/reditem.backend.min.css');
$doc->disableScript('administrator/templates/isis/js/template.js');

// We will apply our own searchtools styles
$doc->disableStylesheet('media/redcore/lib/jquery-searchtools/jquery.searchtools.css');
$doc->disableStylesheet('media/redcore/lib/jquery-searchtools/jquery.searchtools.min.css');
$doc->disableStylesheet('media/redcore/css/lib/chosen.min.css');
$doc->disableStylesheet('media/redcore/css/lib/chosen.css');

// Disable redCORE things
$doc->disableScript('media/redcore/js/lib/jquery.min.js');
$doc->disableScript('media/redcore/js/lib/jquery-migrate.min.js');
$doc->disableScript('media/redcore/js/lib/jquery-noconflict.js');
$doc->disableScript('media/redcore/js/lib/bootstrap.min.js');
$doc->disableScript('media/redcore/lib/bootstrap/js/bootstrap.min.js');
$doc->disableScript('media/redcore/lib/jquery.min.js');
$doc->disableScript('media/redcore/lib/jquery-migrate.min.js');
$doc->disableScript('media/redcore/lib/jquery-noconflict.js');
$doc->disableScript('media/redcore/lib/bootstrap.min.js');
$doc->disableScript('media/redcore/lib/bootstrap/js/bootstrap.min.js');

// Disable core things
/*$doc->disableScript('media/jui/js/jquery.min.js');
$doc->disableScript('media/jui/js/jquery-noconflict.js');
$doc->disableScript('media/jui/js/jquery-migrate.min.js');
$doc->disableScript('media/jui/js/bootstrap.min.js');
$doc->disableScript('media/system/js/mootools-core.js');
$doc->disableScript('media/system/js/mootools-more.js');
$doc->disableScript('media/system/js/modal.js');*/