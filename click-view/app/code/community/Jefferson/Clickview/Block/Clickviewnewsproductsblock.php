<?php


/**
 * 
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
 
 class Jefferson_Clickview_Block_Clickviewnewsproductsblock extends Mage_Catalog_Block_Product_List {
 		
 		
 		/**
 		 * Get the new products by category
 		 * 
 		 * @param $num int
 		 * @param $cat int
 		*/
 		
 		public function getNewsProductCollectionByCategory($num, $cat)
	    {
	        $todayStartOfDayDate  = Mage::app()->getLocale()->date()
	            ->setTime('00:00:00')
	            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
	
	        $todayEndOfDayDate  = Mage::app()->getLocale()->date()
	            ->setTime('23:59:59')
	            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
	
	        $collection = Mage::getResourceModel('catalog/product_collection');
	        $collection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
			
			$category = Mage::getSingleton('catalog/category')
		        ->setStoreId(Mage::app()->getStore()->getId())
		        ->load($cat);
	
	        $collection = $this->_addProductAttributesAndPrices($collection)
	            ->addStoreFilter()
	            ->addCategoryFilter($category)
	            ->addAttributeToFilter('news_from_date', array('or'=> array(
	                0 => array('date' => true, 'to' => $todayEndOfDayDate),
	                1 => array('is' => new Zend_Db_Expr('null')))
	            ), 'left')
	            ->addAttributeToFilter('news_to_date', array('or'=> array(
	                0 => array('date' => true, 'from' => $todayStartOfDayDate),
	                1 => array('is' => new Zend_Db_Expr('null')))
	            ), 'left')
	            ->addAttributeToFilter(
	                array(
	                    array('attribute' => 'news_from_date', 'is'=>new Zend_Db_Expr('not null')),
	                    array('attribute' => 'news_to_date', 'is'=>new Zend_Db_Expr('not null'))
	                    )
	              )
	            ->addAttributeToSort('news_from_date', 'desc')
	            ->setPageSize($num)
	            ->setCurPage(1)
	        ;
	
	        return $collection;
	        
	    }
	    
		public function getCategoryNewProduct(){
	 		
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
		
	    public function getUrlControllerNewsProductsByCategory(){
	 		echo Mage::getUrl()."clickview/index/getproductsnewsbycategory";
	 	}
	 	
	 	public function getUrlControllerAllProductsPromotion(){
	 		echo Mage::getUrl()."clickview/index/getallproductspromotion";
	 	}
	 	
	 	
	 	
	 	public function getAllProductsPromotion($num, $cat){
	 					
	        $todayStartOfDayDate  = Mage::app()->getLocale()->date()
						            ->setTime('00:00:00')
						            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
						
						        $todayEndOfDayDate  = Mage::app()->getLocale()->date()
						            ->setTime('23:59:59')
						            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
								
					 		    $category = Mage::getSingleton('catalog/category')
										        ->setStoreId(Mage::app()->getStore()->getId())
										        ->load($cat);

								
			
			$_products = Mage::getSingleton('catalog/product')
							->getCollection()
							->addAttributeToSelect('*')
							->addAttributeToFilter(
								'special_price', array('notnull' => true)
								)
				            ->addAttributeToFilter('special_from_date', array('or'=> array(
				                0 => array('date' => true, 'to' => $todayEndOfDayDate),
				                1 => array('is' => new Zend_Db_Expr('null')))
				            ), 'left')
				            ->addAttributeToFilter('special_to_date', array('or'=> array(
				                0 => array('date' => true, 'from' => $todayStartOfDayDate),
				                1 => array('is' => new Zend_Db_Expr('null')))
				            ), 'left')
				            ->addAttributeToFilter(
				                array(
				                    array('attribute' => 'special_from_date', 'is'=>new Zend_Db_Expr('not null')),
				                    array('attribute' => 'special_to_date', 'is'=>new Zend_Db_Expr('not null'))
				                    )
				              )
				            ->addCategoryFilter($category)
				            ->addAttributeToSort('special_from_date', 'desc')	
				            ->setStoreId(Mage::app()->getStore()->getId())
				            ->setPageSize($num);
			
			$_products->getSelect()->order('RAND()');			
			
			return $_products;
							
	 	}
	 	
	 	
	 	/**
	 	 * Get products with discount
	 	*/
	 	public function getProductsDiscount($num){
	 		
	 		$cat = @implode(',',Mage::getModel('clickview/system_config_source_category')->toOptionArray());
	 		
	 		$_products = self::getAllProductsPromotion($num, $cat);
	 		
	 		return $_products;
	 		
	 	}
	 	
	 	/**
	 	 * Calculates the percentage of discount
	 	 * 
	 	 * @param $val1 double
	 	 * @param $val2 double
	 	*/
	 	
	 	public function getPerc($val1, $val2){
	 		return Mage::helper('clickview')->calcPerc($val1, $val2);
	 	}
		
		/**
	  * Get the best selling function settings	
	  * 
	  */
	 
	 	public function getCategoryAllowed(){
	 		$cat = explode(',', Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_category_allowed'));
	 		return $cat;
	 	}
	 	public function getCatDefault(){
	 		return $catDefault = Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_category_default');
	 		return $catDefault;
	 	}
 	
	 	public function getMinSlides(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_category_minslider'));
	 	}
	 	
	 	public function getMaxSlides(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_category_maxslider'));
	 	}
	 	
	 	public function getSlideWidth(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_category_slidewidth'));
	 	}
	 	
	 	public function getSlideMargin(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_category_slidewidth'));
	 	}
	 	
	 	public function getNewProductByCatImgSize(){
	 		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_img_size'));
	 	}
	 	
	 	public function getNewProductByCatRow(){
	 		return Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_click_number_rows');
	 	}
		
		public function getNewProductByCatMode(){
			return Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_slide_mode');
		}
		
		public function getNewProductByCatEnabled(){
			return Mage::getStoreConfig('clickview_by_category/clickview_news_products_by_category/clickview_click_enabled');
		}
		
		public function getDiscountImgSize(){
			return Mage::getStoreConfig('clickview_product_discount/clickview_products_discount_general/clickview_img_size');
		}
		
		public function getDiscountRows(){
			return Mage::getStoreConfig('clickview_product_discount/clickview_products_discount_general/clickview_click_number_rows');
		}
		
			 	
 }
 
 ?>
 	