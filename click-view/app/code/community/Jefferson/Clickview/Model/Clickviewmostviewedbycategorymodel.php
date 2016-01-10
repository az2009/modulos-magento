<?php

	class Jefferson_Clickview_Model_Clickviewmostviewedbycategorymodel extends Mage_Core_Model_Abstract {
		
		protected function _construct()
	    {
	        $this->_init('clickview/clickviewmostviewedbycategorymodel');
	    } 
	    
	    /**
	     * Get the most viewed products by category
	     * 
	     * @param $num int
	     * @param $cat int
	    */
	    
	    public function getMostViewedByCategory($num,$cat){
		    $storeId    = Mage::app()->getStore()->getId();
		    $today = time();
			$last  = $today - (60*60*24*30);
		 
			$fromDate = date("Y-m-d", $last);
			$toDate = date("Y-m-d", $today);
		    
		    $category = Mage::getSingleton('catalog/category')
		        ->setStoreId(Mage::app()->getStore()->getId())
		        ->load($cat);
		    
	        $products = Mage::getResourceModel('reports/product_collection')
	            ->addAttributeToSelect('*')
	            ->addCategoryFilter($category)
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
	    
	    
	}
?>