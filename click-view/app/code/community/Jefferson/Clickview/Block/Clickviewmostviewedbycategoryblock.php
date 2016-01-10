<?php


/**
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
 
 class Jefferson_Clickview_Block_Clickviewmostviewedbycategoryblock extends Mage_Catalog_Block_Product_List {
 	
 	protected $cat  = null;
 	protected $html = null;
 	
 	public function getMostViewedByCategory($num,$cat){
 		return Mage::getSingleton('clickview/clickviewmostviewedbycategorymodel')->getMostViewedByCategory($num,$cat);
 	}
 	
 	public function getCategoryMostViewed(){
 		
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
 	
 	public function getCategoryAllowed(){
 		$cat = explode(',', Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_category_allowed'));
 		return $cat;
 	}
 	
 	public function getUrlControllerMostViewedByCategory(){
 		echo Mage::getUrl()."clickview/index/getmostviewedbycategory";
 	}
 	
 	public function getBestsellerProductsByCategory($num,$cat){
 		return Mage::getSingleton('clickview/clickviewbestsellerbycategorymodel')->getBestsellerProductsByCategory($num,$cat);
 	}
 	
 	public function getUrlControllerBestSellerByCategory(){
 		echo Mage::getUrl()."clickview/index/getbestsellerbycategory";
 	}
 	
 	
 	public function getCatDefault(){
 		return $catDefault = Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_category_default');
 		return $catDefault;
 	}
 	
 	
 	public function getMinSlides(){
 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_category_minslider'));
 	}
 	
 	public function getMaxSlides(){
 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_category_maxslider'));
 	}
 	
 	public function getSlideWidth(){
 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_category_slidewidth'));
 	}
 	
 	public function getSlideMargin(){
 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_category_slidewidth'));
 	}
 	
 	public function getMostViewedByCatImgSize(){
 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_img_size'));
 	}
 	
 	public function getMostViewedByCatRow(){
 		return Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_click_number_rows');
 	}
	
	public function getMostViewedByCatMode(){
		return Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_slide_mode');
	}
	
	public function getMostViewedByCatEnabled(){
		return Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_click_enabled');
	}
		
 }
 
?>