<?php


/**
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
 
 class Jefferson_Clickview_Block_Clickviewbestsellersblock extends Mage_Catalog_Block_Product_List {
 	
 	public function getBestsellerProducts($num){
 		return Mage::getSingleton('clickview/clickviewbestsellersmodel')->getBestsellerProducts($num);
 	}
 	
 	public function getClickCountRows(){
		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_best_seller/clickview_best_seller_general/clickview_click_number_rows'));
	}
	
	public function getClickEnabled(){
		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_best_seller/clickview_best_seller_general/clickview_click_enabled'));
	}
	
	public function getClickImgSize(){
		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_best_seller/clickview_best_seller_general/clickview_img_size'));
	}
 		
 }
 
?>