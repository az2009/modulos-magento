<?php

class Ei_Creditpoint_Block_Creditpoint extends Mage_Core_Block_Template{
    
    
        public function __construct()
	{
		parent::__construct();
		$collection = Mage::getModel('creditpoint/creditpoint')->getCollection();
                $customerId = Mage::helper('creditpoint')->getCurrentCustomerId();
                $collection->addCustomFilter($customerId);
		$this->setCollection($collection);
	}
        
        
	protected function _prepareLayout()
	{
		parent::_prepareLayout();

		$pager = $this->getLayout()->createBlock('page/html_pager', 'creditpoint.pager');
		$pager->setAvailableLimit(array(10=>10,20=>20,50=>50,'all'=>'all'));
		$pager->setCollection($this->getCollection());                
		$this->setChild('pager', $pager);
		$this->getCollection()->load();
		return $this;
	}

	public function getPagerHtml()
	{
            return $this->getChildHtml('pager');
	}
        
}
