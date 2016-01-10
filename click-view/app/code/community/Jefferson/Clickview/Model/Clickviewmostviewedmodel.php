<?php

/**
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
	class Jefferson_Clickview_Model_Clickviewmostviewedmodel extends Mage_Core_Model_Abstract {
		
		protected function _construct()
	    {
	        $this->_init('clickview/clickviewmostviewedmodel');
	    } 
	    
	    /**
	     * Get the products viewed
	     * @param $num int
	     * @param Array
	    */
	    
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
	        
	        	Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
	        	Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
	 
	        return $products;
	    }
	    
	    
	}
?>