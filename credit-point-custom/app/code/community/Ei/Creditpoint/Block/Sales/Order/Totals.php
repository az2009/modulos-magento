<?php

class Ei_Creditpoint_Block_Sales_Order_Totals extends Mage_Sales_Block_Order_Totals
{

    protected function _initTotals()
    {
        parent::_initTotals();
        if((float) $this->getOrder()->getBaseCreditpointAmount()){
        $source = $this->getSource();
        $creditPoints = number_format(Mage::getModel('creditpoint/creditpoint')->load($source->getEntityId(), 'order_id')->getAppliedCreditPoint());
        $value = '-'.$source->getCreditpointAmount();

        $this->addTotalBefore(new Varien_Object(array(
                'code'      => Mage::helper('creditpoint')->getCode(),
                'strong'    => false,
                'label'     => Mage::helper('creditpoint')->getCreditPointLabel($creditPoints),
                'value'     => $source instanceof Mage_Sales_Model_Order_Creditmemo ? - $value : $value )));
        }

        return $this;
    }

}


?>