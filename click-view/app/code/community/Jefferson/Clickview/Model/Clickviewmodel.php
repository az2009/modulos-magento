<?php

/**
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

	class Jefferson_Clickview_Model_Clickviewmodel extends Mage_Core_Model_Abstract {
			
			
			
			protected function _construct()
		    {
		        $this->_init('clickview/clickviewmodel');
		    } 
		    
		    
		    /**
		     * Handle the products in a given category
		     * 
		     * @param int $entity_id
		     * @param int $categoryCurrent
		     * @param int $limit
		     * return Array
		    */
		    public function getDataProducts($entity_id, $categoryCurrent, $limit){
				
				$storeId   = Mage::app()->getStore()->getId();
				$_products = Mage::getSingleton('catalog/product')
									->getCollection()
									->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
									->addAttributeToSelect('*')
									// ->addAttributeToFilter('set_promotion', array('in'=>"1"))
									
									->addFieldToFilter(array(
					        				array('attribute'=>'entity_id','nin'=> $entity_id),
									))
									
									->addFieldToFilter(array(
					        				array('attribute'=>'category_id','in'=>  array($categoryCurrent)),
									))
									
									->setStoreId($storeId)
									->setPageSize($limit);
									$_products->getSelect()->group('e.entity_id');	
				
				Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($_products);
		        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($_products);

				
				$_products->getSelect()->order('RAND()');
				
				
				foreach($_products as $item);
				
				if ($item) 
				{
					return $_products;
					
				}else{
					return false;
				}
			}
			
			/**
			*Returns the name of a category
			* 
			*@param int $category
			*return String
			*/
			public function getCategoryName($category)
		    {
		       $storeId = (int)Mage::app()->getStore()->getId();
		       $this->category = Mage::getSingleton('catalog/category')
		       ->setStoreId($storeId)
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
			
			
			/**
			*Take the categories of a product
			* 
			*@param int $id
			*return string
			*/
			public function getCategoryProducts($id){
				
				$storeId   = Mage::app()->getStore()->getId();
				$_products = Mage::getSingleton('catalog/product')
				->setStoreId($storeId)
				->load($id);
				$_category = $_products->getCategoryIds();
				
				return implode(',',$_category);
			}
			
			/**
			*Get the data of the current products
			* 
			*@param int $id
			*return Object
			*/
			public function getDataProductCurrent($id){
				$storeId = (int)Mage::app()->getStore()->getId();
				$_products = Mage::getSingleton('catalog/product')
				->setStoreID($storeId)
				->load($id);
				return $_products;
			}
			
			
			/**
			*Get a product related products
			* 
			*@param int $id
			*return Array
			* 
			* Obs:This method is not being used in this module
			*/
			public function getDataProductsRelated($id){
				$_products = self::getDataProductCurrent($id);
				return $_products->getRelatedProductIds();
				
			}
			
	}
?>