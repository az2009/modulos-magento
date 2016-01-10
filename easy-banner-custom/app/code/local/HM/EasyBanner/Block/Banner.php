<?php
class HM_EasyBanner_Block_Banner extends Mage_Core_Block_Template
{
	protected $_banner = false;

	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getBanner()     
     { 
		if (!$this->_banner) {

			//$banner_id = $this->getData('id');
			$banner_id = $this->getBannerId();
			if ($banner_id) {
				$banner = Mage::getModel('easybanner/banner')->load($banner_id);
				//var_dump($banner);	exit;
				if ($banner->getId()==0) {
					$banner = Mage::getModel('easybanner/banner')->load($banner_id, 'identifier');
				}	;	
				if($this->inActiveTime($banner->getActiveFrom(),$banner->getActiveTo()))
				$this->_banner = $banner;
			}
		}
        return $this->_banner;       
    }

	public function isVisible() {
		return $this->getBanner() && $this->getBanner()->getStatus();
	}
	public function inActiveTime($from,$to) {
		return Mage::app()->getLocale()->isStoreDateInInterval(null, $from, $to);		
	}
	public function getBannerItems() {
		if ($this->isVisible()) {
			$banner = $this->getBanner();
	
			$collection = Mage::getModel('easybanner/banneritem')->getCollection()
				->addFieldToFilter('status', true)
				->addFieldToFilter('banner_id', $banner->getId())
				->setOrder('banner_order','ASC');
			return $collection;
		}
		return false;
	}
}