<?php
/**
 * Created by PhpStorm.
 * User: nhung nguyen
 * Date: 5/25/2017
 * Time: 3:51 PM
 */

namespace AcceptanceTester;


class ConfigurationManageJoomla3Steps extends AdminManagerJoomla3Steps
{
    public function featureUsedStockRoom()
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$featureSetting);
        $I->waitForElement(\ConfigurationManageJ3Page::$ratingTab, 60);
        $I->waitForElement(\ConfigurationManageJ3Page::$stockRoomTab, 60);
        $I->click(\ConfigurationManageJ3Page::$stockRoomYes);
        $I->click(\ConfigurationManageJ3Page::$buttonSave);
    }

    public function featureOffStockRoom()
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$featureSetting);
        $I->waitForElement(\ConfigurationManageJ3Page::$ratingTab, 60);
        $I->waitForElement(\ConfigurationManageJ3Page::$stockRoomTab, 60);
        $I->click(\ConfigurationManageJ3Page::$stockRoomNo);
        $I->click(\ConfigurationManageJ3Page::$buttonSave);
    }


    public function featureEditInLineYes()
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$featureSetting);
        $I->waitForElement(\ConfigurationManageJ3Page::$editInline, 60);
        $I->waitForElement(\ConfigurationManageJ3Page::$stockRoomTab, 60);
        $I->click(\ConfigurationManageJ3Page::$eidtInLineYes);
        $I->click(\ConfigurationManageJ3Page::$buttonSave);
    }

    public function featureEditInLineNo()
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$featureSetting);
        $I->waitForElement(\ConfigurationManageJ3Page::$editInline, 60);
        $I->waitForElement(\ConfigurationManageJ3Page::$stockRoomTab, 60);
        $I->click(\ConfigurationManageJ3Page::$editInLineNo);
        $I->click(\ConfigurationManageJ3Page::$buttonSave);
    }

    public function featureComparisonNo()
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$featureSetting);
        $I->waitForElement(\ConfigurationManageJ3Page::$comparisonTab, 60);
        $I->waitForElement(\ConfigurationManageJ3Page::$stockRoomTab, 60);
        $I->click(\ConfigurationManageJ3Page::$comparisonNo);
        $I->click(\ConfigurationManageJ3Page::$buttonSave);
    }

    public function featureComparisonYes()
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$featureSetting);
        $I->waitForElement(\ConfigurationManageJ3Page::$comparisonTab, 60);
        $I->waitForElement(\ConfigurationManageJ3Page::$stockRoomTab, 60);
        $I->click(\ConfigurationManageJ3Page::$comparisonYes);
        $I->click(\ConfigurationManageJ3Page::$buttonSave);
    }


    //Price

    public function featurePriceNo()
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$price);
        $I->waitForElement(\ConfigurationManageJ3Page::$priceTab, 60);
        $I->click(\ConfigurationManageJ3Page::$showPriceNo);
        $I->click(\ConfigurationManageJ3Page::$buttonSave);
    }

    public function featurePriceYes()
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$price);
        $I->waitForElement(\ConfigurationManageJ3Page::$priceTab, 60);
        $I->click(\ConfigurationManageJ3Page::$showPriceYes);
        $I->click(\ConfigurationManageJ3Page::$buttonSave);
    }

    /**
     * @param $country
     * @param $state
     * @param $vatDefault
     * @param $vatCalculation
     * @param $vatAfter
     * @param $calculationBase
     * @param $vatNumber
     */
    public function setupVAT($country, $state, $vatDefault, $vatCalculation, $vatAfter, $vatNumber, $calculationBase, $requiVAT)
    {
        $I = $this;
        $I->amOnPage(\ConfigurationManageJ3Page::$URL);
        $I->click(\ConfigurationManageJ3Page::$price);

        $I->click(\ConfigurationManageJ3Page::$countryPrice);
        $I->waitForElement(\ConfigurationManageJ3Page::$countrySearchPrice, 5);
        $I->fillField(\ConfigurationManageJ3Page::$countrySearchPrice, $country);
        $userConfigurationPage = new \ConfigurationManageJ3Page();
        $I->waitForElement($userConfigurationPage->returnChoice($country));
        $I->click($userConfigurationPage->returnChoice($country));

        //get state
        $I->click(\ConfigurationManageJ3Page::$statePrice);
        $I->waitForElement(\ConfigurationManageJ3Page::$stateSearchPrice, 5);
        $I->fillField(\ConfigurationManageJ3Page::$stateSearchPrice, $state);
        $I->waitForElement($userConfigurationPage->returnChoice($state));
        $I->click($userConfigurationPage->returnChoice($state));

        //get default vat
        $I->click(\ConfigurationManageJ3Page::$vatGroup);
        $I->waitForElement(\ConfigurationManageJ3Page::$vatSearchGroup, 5);
        $I->fillField(\ConfigurationManageJ3Page::$vatSearchGroup, $vatDefault);
        $I->waitForElement($userConfigurationPage->returnChoice($vatDefault));
        $I->pressKey(\ConfigurationManageJ3Page::$vatGroup, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN, \Facebook\WebDriver\WebDriverKeys::ENTER);

        //get vat base on
        $I->click(\ConfigurationManageJ3Page::$vatDefaultBase);
        $I->waitForElement(\ConfigurationManageJ3Page::$vatSearchDefaultBase, 5);
        $I->fillField(\ConfigurationManageJ3Page::$vatSearchDefaultBase, $vatCalculation);
        $I->waitForElement($userConfigurationPage->returnChoice($vatCalculation));
        $I->pressKey(\ConfigurationManageJ3Page::$vatDefaultBase, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN, \Facebook\WebDriver\WebDriverKeys::ENTER);

        //apply vat on discount
        switch ($vatAfter) {
            case 'after':
                $I->click(\ConfigurationManageJ3Page::$applyDiscountAfter);
                break;
            case 'before':
                $I->click(\ConfigurationManageJ3Page::$applyDiscountBefore);
                break;
        }

        // value after discount
        $I->fillField(\ConfigurationManageJ3Page::$vatAfterDiscount, $vatNumber);

        //get value calculation based on
        switch ($calculationBase) {
            case 'billing':
                $I->click(\ConfigurationManageJ3Page::$calculationBaseBilling);
                break;
            case 'shipping':
                $I->click(\ConfigurationManageJ3Page::$calculationBaseShipping);
                break;
        }

        //get requi vat yesno

        switch ($requiVAT) {
            case 'yes':
                $I->click(\ConfigurationManageJ3Page::$vatNumberYes);
                break;
            case 'no':
                $I->click(\ConfigurationManageJ3Page::$vatNumberNo);
                break;
        }

        $I->click(\ConfigurationManageJ3Page::$buttonSave);
        $I->see(\ConfigurationManageJ3Page::$namePage, \ConfigurationManageJ3Page::$selectorPageTitle);

    }

}