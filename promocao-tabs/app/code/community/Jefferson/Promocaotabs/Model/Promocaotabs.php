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
 * @package     Jefferson_Promocaotabs
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

	class Jefferson_Promocaotabs_Model_Promocaotabs extends Mage_Core_Model_Abstract {
		
			protected $_product = null;
			protected $categoryCurrent = null;
			protected $category = null;
			protected $item = null;
			
			
			protected function _construct()
		    {
		        $this->_init('promocaotabs/promocaotabs');
		    } 
		    
			
			public function getDataProducts($categoryCurrent){
				
				$storeId = Mage::app()->getStore()->getStoreId();
				
				$this->_product = Mage::getSingleton('catalog/product')
				->getCollection()
				->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
				->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
				->addFieldToFilter(array(
					        		array('attribute'=>'set_promotion','in'=> '1'),
					        		))
				->addFieldToFilter(array(
					        		array('attribute'=>'category_id','in'=> array($categoryCurrent)),
					        		))	        		
				->addStoreFilter($storeId);
				
				$this->_product->getSelect()->group('e.entity_id');
				
				foreach($this->_product as $this->item);
				
				if ($this->item) 
				{
					return $this->_product;
					
				}else{
					return false;
				}
				
			}
			
			
			public function getCategoryName($category)
		    {
		        
		       $this->category = Mage::getSingleton('catalog/category')
		       ->load($category);
				$cat = $this->category->getTitleCustomTabs();
				if(!empty($cat)){
					echo $this->category->getTitleCustomTabs();
				}
				else
				{
					echo $this->category->getName();
				}
				
			}
		
	}
?>