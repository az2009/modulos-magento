<?php
class Jbp_RulesPromotion_Model_Observer_AdminhtmlBlockSalesruleActionsPrepareform
{
    public function addOptionToAction($observer)
    {
        /** @var Varien_Data_Form $form*/
        $form = $observer->getEvent()->getForm();

        /** @var Varien_Data_Form_Element_Select $simpleAction*/
        $simpleAction = $form->getElement('simple_action');
        $options = $simpleAction->getOptions();
        $options = array(Jbp_RulesPromotion_Helper_Data::BUY_X_PAY_Y_ACTION => Mage::helper('salesrule')->__('Buy X Pay (Y)'));
        $simpleAction->addElementValues($options);

        return $this;
    }
}