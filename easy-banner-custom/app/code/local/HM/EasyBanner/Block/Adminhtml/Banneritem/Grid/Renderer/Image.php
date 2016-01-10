<?php
	
	class HM_EasyBanner_Block_Adminhtml_Banneritem_Grid_Renderer_Image
	extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
		
		public function render(Varien_Object $row){
			 return $this->_getValue($row);
			
		}
		
		protected function _getValue(Varien_Object $row){
			$path = $row->getData('image');
			$urlStore = Mage::getStoreConfig(Mage_Core_Model_Url::XML_PATH_SECURE_URL);
			$image = "<img src='".$urlStore."media/$path' alt='' title='' width='150px' height='50px' />";
			
			return $image;
		}
		
	}
