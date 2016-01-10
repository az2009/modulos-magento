<?php
	class Jefferson_Clickview_Model_Clickviewbestsellersmodel extends Mage_Core_Model_Abstract {
		
		protected function _construct()
	    {
	        $this->_init('clickview/clickviewbestsellersmodel');
	    } 
		
		/**
		 * Get the best-selling products
		 * @param $num int
		 * return Array
		*/
		public function getBestsellerProducts($num)
	    {
	        $storeId = (int) Mage::app()->getStore()->getId();
	 
	        // Date
	        
	        $toDate 	= date('y-m-d');
	        $fromDate 	= date('y-m-1');
	 
	        $collection = Mage::getResourceModel('catalog/product_collection')
	            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
	            ->addStoreFilter()
	            ->addPriceData()
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