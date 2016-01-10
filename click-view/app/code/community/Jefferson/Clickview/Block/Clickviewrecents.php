<?php
	class Jefferson_Clickview_Block_Clickviewrecents extends Mage_Reports_Block_Product_Viewed {
		
		public function getClickEnabled(){
			return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_click_recents/clickview_general/clickview_click_enabled'));
		}
		
		public function getClickImgSize(){
			return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_click_recents/clickview_click_recents_general/clickview_img_size'));
		}

	}
?>