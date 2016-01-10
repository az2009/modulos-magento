<?php

class Ei_Creditpoint_RW_Adminhtml_Block_Sales_Order_Creditmemo_Totals extends Mage_Adminhtml_Block_Sales_Order_Creditmemo_Totals
{

    protected function _initTotals()
    {
        parent::_initTotals();

        //Retrieve Creditpoint Amount from sales_flat_order table order wise
        $creditPointAmount = $this->getSource()->getCreditpointAmount();
        $creditPoints = number_format(Mage::getModel('creditpoint/creditpoint')->load($this->getSource()->getOrderId(), 'order_id')->getAppliedCreditPoint());

        if($creditPointAmount > 0){

            $this->addTotalBefore(new Varien_Object(array(
                'code'        => Mage::helper('creditpoint')->getCode(),
                'value'       => '-'.$creditPointAmount,
                'base_value'  => '-'.$creditPointAmount,
                'strong'      => false,
                'label'       => Mage::helper('creditpoint')->getCreditPointLabel($creditPoints),
                ), array('shipping', 'tax')));
        }

        return $this;
    }

}


?>