<?php
	class Jefferson_Clickview_Model_Clickviewbestsellerbycategorymodel extends Mage_Core_Model_Abstract {
		
		protected function _construct()
	    {
	        $this->_init('clickview/clickviewbestsellerbycategorymodel');
	    } 
		
		/**
		 * Get the best selling products by category
		 * 
		 * @param $num int
		 * @param $cat int
		*/
		
		public function getBestsellerProductsByCategory($num,$cat)
	    {
	        $storeId = (int) Mage::app()->getStore()->getId();
	 	    $today = time();
			$last  = $today - (60*60*24*30);
		 
			$fromDate = date("Y-m-d", $last);
			$toDate = date("Y-m-d", $today);
	 
 		    $category = Mage::getSingleton('catalog/category')
					        ->setStoreId($storeId)
					        ->load($cat);

	 		
	        $collection = Mage::getResourceModel('catalog/product_collection')
	            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
	            ->addStoreFilter()
	            ->addPriceData()
	            ->addCategoryFilter($category)
	            ->addTaxPercents()
	            ->addUrlRewrite()
	            ->setPageSize($num);
	 
	        $collection->getSelect()
	            ->joinLeft(
	                array('aggregation' => $collection->getResource()->getTable('sales/bestsellers_aggregated_monthly')),
	                "e.entity_id = aggregation.product_id AND aggregation.store_id={$storeId} AND aggregation.period BETWEEN '{$fromDate}' AND '{$toDate}'",
	                array('SUM(aggregation.qty_ordered) AS sold_quantity')
	            )
	            ->group('e.entity_id')
	            ->order(array('sold_quantity DESC', 'e.created_at'));
	 
	        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
	        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
	 
	        return $collection;
	    }
		
	}

?>