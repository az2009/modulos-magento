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
 * @package     Jefferson_Promocao
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

	class Jefferson_Promocao_Model_Promocao extends Mage_Core_Model_Abstract {
		
			protected $_product = null;
			protected $categoryCurrent = null;
			
			
			protected function _construct()
		    {
		        $this->_init('promocao/promocao');
		        self::getCategoryCurrent();
		    } 
		    
			public function getCategoryCurrent(){
				$this->categoryCurrent =  Mage::registry('current_category')->getId();
				return $this->categoryCurrent;
			}
			
			public function getDataProducts(){
				$todayStartOfDayDate  = Mage::app()->getLocale()->date()
					->setTime('00:00:00')
					->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

				$todayEndOfDayDate  = Mage::app()->getLocale()->date()
					->setTime('23:59:59')
					->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

				$storeId = Mage::app()->getStore()->getStoreId();
				
				$category = Mage::getSingleton('catalog/category')
					        ->setStoreId($storeId)
					        ->load($this->categoryCurrent);
					        
				$this->_product = Mage::getModel('catalog/product')
				->getCollection()
				->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
				->addFieldToFilter(array(
					        		array('attribute'=>'set_promotion','in'=> '1'),
					        		))
				->addFieldToFilter(array(
					        				array('attribute'=>'special_price','neq'=> ''),
							))
						
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
		        ->addStoreFilter($storeId);
		        
		        $this->_product->getSelect()->group('e.entity_id');
				
				foreach($this->_product as $item);
				
				if ($item) 
				{
					return $this->_product;
					
				}else{
					return false;
				}
				
			}
		
		
	}
?>