<?php
class Ei_Creditpoint_Model_Sales_Quote_Address_Total_Creditpoint extends Mage_Sales_Model_Quote_Address_Total_Abstract{

        protected $CreditPointCode = '';
	protected $EstimateCredit  = '';

	public function __construct(){

                $this->moduleStatus = Mage::helper('creditpoint')->getModuleStatus();
                $this->minCreditConfig  = Mage::helper('creditpoint')->getMinimumCredit();
                $this->creditPoints    = Mage::helper('creditpoint')->getCustomerCreditPointsAssigned();
		$this->CreditPointCode = Mage::helper('creditpoint')->getCode();
		$this->EstimateCredit  = Mage::getSingleton('core/session')->getEstimateCredit();
                $this->PointsRedeem  = Mage::getSingleton('core/session')->getPointsRedeem();
                $this->PointsPrice  = Mage::getSingleton('core/session')->getPointsPrice();
	}

        //In function collect() you can add whatever amount you want to the order totals
	public function collect(Mage_Sales_Model_Quote_Address $address)
	{

		parent::collect($address);

		$this->_setAmount(0);
		$this->_setBaseAmount(0);

		$items = $this->_getAddressItems($address);
		if (!count($items)) {
			return $this; //this makes only address type shipping to come through
		}

		$quote = $address->getQuote();

                //check if module enabled, mincredit < credit assigned and creditpoint redeemed only then display in grand_total block
		if( ($this->CreditPointCode == $this->EstimateCredit) && ($this->moduleStatus == 1) && ($this->minCreditConfig < $this->creditPoints) ){

                $exist_amount = $quote->getCreditpointAmount();
                $creditPointPrice = Mage::helper('creditpoint')->getPrice($this->PointsRedeem);
                $balance = $creditPointPrice - $exist_amount;

		$address->setCreditpointAmount($balance);
		$address->setBaseCreditpointAmount($balance);

		$quote->setCreditpointAmount($balance);

		$address->setGrandTotal($address->getGrandTotal() - $address->getCreditpointAmount());
                $address->setBaseGrandTotal($address->getBaseGrandTotal() - $address->getBaseCreditpointAmount());
            }

	}

        //The function fetch() is used for display purposes
	public function fetch(Mage_Sales_Model_Quote_Address $address)
	{
                //check if module enabled, mincredit < credit assigned and creditpoint redeemed only then display in grand_total block
                if(($this->CreditPointCode == $this->EstimateCredit) && ($this->moduleStatus == 1) && ($this->minCreditConfig < $this->creditPoints)){

                $amount = $address->getCreditpointAmount();
		$address->addTotal(array(
				'code'  => Mage::helper('creditpoint')->getCode(),
				'title' => Mage::helper('creditpoint')->__('Points Redeem ('.$this->PointsRedeem.'&nbsp;points)'),
				'value' => '-'.$amount
		));

                return $this;
            }

	}
}