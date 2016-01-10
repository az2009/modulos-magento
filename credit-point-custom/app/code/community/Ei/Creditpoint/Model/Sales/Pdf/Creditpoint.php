<?php

class Ei_Creditpoint_Model_Sales_Pdf_Creditpoint extends Mage_Sales_Model_Order_Pdf_Total_Default
{

    /**
    * Get Total amount from source
    *
    * @return float
    */
    public function getCreditpointAmt()
    {
        //we can use $this->getSource()->getCreditpointAmount() but it will return without formatted price.
        //below code should get you the formatted price amount. This is taken directly from the original getTotalsForDisplay code
        
        return $this->getOrder()->formatPriceTxt($this->getAmount());
    }


    public function getTotalsForDisplay()
    {
        parent::getTotalsForDisplay();
        // getAmount is defined in the parent class and should read
        // the value from the defined source_field in config.xml
        $creditPointAmount = $this->getCreditpointAmt();
        $creditPoints = number_format(Mage::getModel('creditpoint/creditpoint')->load($this->getOrder()->getEntityId(), 'order_id')->getAppliedCreditPoint());
        
        $label    =  Mage::helper('creditpoint')->getCreditPointLabel($creditPoints);        
        $fontSize =  $this->getFontSize() ? $this->getFontSize() : 7;
        $total = array(
            'amount'    => '-'.$creditPointAmount,
            'label'     => $label,
            'font_size' => $fontSize
        );
        return array($total);
    }

}