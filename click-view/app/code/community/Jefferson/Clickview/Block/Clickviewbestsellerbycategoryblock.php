<?php


/**
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
 
 class Jefferson_Clickview_Block_Clickviewbestsellerbycategoryblock extends Mage_Catalog_Block_Product_List {
 	
 	protected $cat  = null;
 	protected $html = null;
 	
 	/**
 	 * Get category allowed bests seller
 	 * 
 	 */
	 	public function getCategoryBestSeller(){
	 		
	 		$storeId    = Mage::app()->getStore()->getId();
	 		
	 		$catAllowed = self::getCategoryAllowed();
	 		
	 		$catDefault	= self::getCatDefault();
	 		
	 		$this->cat  = Mage::getSingleton('catalog/category')
	 						->getCollection()
	 						->addAttributeToSelect('*')
	 						->setStoreId($storeId)
	 						->addAttributeToFilter('entity_id', array('in' => $catAllowed));
	 		
	 		foreach($this->cat as $i){
	 			if($i->getId() == $catDefault){
	 				$this->html .=  "<option  value='".$i->getId()."' selected='selected' >".$i->getName()."</option>";
	 			}else{
	 				$this->html .=  "<option  value='".$i->getId()."'>".$i->getName()."</option>";
	 			}
	 		}
	 		
	 		return $this->html;
	 	}
	 	
 	
 	/**
 	 * Get the products by category
 	 * 
 	 */
	 	public function getBestsellerProductsByCategory($num,$cat){
	 		return Mage::getSingleton('clickview/clickviewbestsellerbycategorymodel')->getBestsellerProductsByCategory($num,$cat);
	 	}
 	
 	/**
 	 * Get url controller
 	 */
	 	public function getUrlControllerBestSellerByCategory(){
	 		echo Mage::getUrl()."clickview/index/getbestsellerbycategory";
	 	}
	 	
	 /**
	  * Get the best selling function settings	
	  * 
	  */
	 
	 	public function getCategoryAllowed(){
	 		$cat = explode(',', Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_category_allowed'));
	 		return $cat;
	 	}
	 	public function getCatDefault(){
	 		return $catDefault = Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_category_default');
	 		return $catDefault;
	 	}
 	
	 	public function getMinSlides(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_category_minslider'));
	 	}
	 	
	 	public function getMaxSlides(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_category_maxslider'));
	 	}
	 	
	 	public function getSlideWidth(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_category_slidewidth'));
	 	}
	 	
	 	public function getSlideMargin(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_category_slidewidth'));
	 	}
	 	
	 	public function getBestSellerByCatImgSize(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_img_size'));
	 	}
	 	
	 	public function getBestSellerByCatRow(){
	 		return Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_click_number_rows');
	 	}
		
		public function getBestSellerByCatMode(){
			return Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_slide_mode');
		}
		
		public function getBestSellerByCatEnabled(){
			return Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_click_enabled');
		}
		
 }
 
?>