<?php

/**
 * Elastera_AmastyLesti Observer
 *
 * @category  Elastera
 * @package   Elastera_AmastyLesti
 * @author    Simon, Mark <mark@elastera.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 */
class Elastera_AmastyLesti_Model_Observer
{

    public function collectParameters(Varien_Event_Observer $observer)
    {
        // Check if amasty shopby is installed.
        if (!Mage::helper('core')->isModuleEnabled('Amasty_Shopby')) {
            return;
        }

        // Get the attributes (that were remove from URL)
        $amastyAttributes = Mage::helper('amshopby/attributes');
        $additionalParameters = $amastyAttributes->getRequestedFilterCodes();
        if (empty($amastyAttributes)) {
            return;
        }

        // Get the parameters, that lesti collected so far.
        /** @var Varien_Object $parametersObject */
        $parametersObject = $observer->getData('parameters');
        $parameters = $parametersObject->getData('value');

        // Add all selected amasty filters to the parameter list
        foreach ($additionalParameters as $key => $value) {
            $parameters['amasty_'.$key] = $value;
        }
        $parametersObject->setValue($parameters);
    }

}
