<?php


/**
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
 
 class Jefferson_Clickview_Block_Clickviewmostviewedblock extends Mage_Catalog_Block_Product_Abstract {
 	
  public function getMostViewed($num){
		    $storeId    = Mage::app()->getStore()->getId();
		    
		    $today = time();
			$last  = $today - (60*60*24*30);
		 
			$fromDate = date("Y-m-d", $last);
			$toDate = date("Y-m-d", $today);
		    
		    $products = Mage::getResourceModel('reports/product_collection')
	            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
	            ->setStoreId($storeId)
	            ->addStoreFilter($storeId)
	            ->addViewsCount($fromDate, $toDate)
	            ->setOrder('views_count', 'desc')
	            ->setPageSize($num);
	        
	        $productFlatData = Mage::getStoreConfig('catalog/frontend/flat_catalog_product');
			if($productFlatData == "1")
			{
				$products->getSelect()->joinLeft(
			array('flat' => 'catalog_product_flat_'.$storeId),
		                "(e.entity_id = flat.entity_id ) ",
		                array(
		                   'flat.name AS name','flat.small_image AS small_image','flat.price AS price','flat.special_price as special_price','flat.special_from_date AS special_from_date','flat.special_to_date AS special_to_date'
						)
		        );
			}
	        	Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
	        	Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
	 
	        	return $products;
	    }
 	
 	public function getClickCountRows(){
		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_most_views/clickview_most_views_general/clickview_click_number_rows'));
	}
	
	public function getClickEnabled(){
		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_most_views/clickview_most_views_general/clickview_click_enabled'));
	}
	
	public function getClickImgSize(){
		return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_most_views/clickview_most_views_general/clickview_img_size'));
	}

 	
 	
 	
 }
 
?>