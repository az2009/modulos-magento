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

class Jefferson_Clickview_Model_System_Config_Source_Categorybestsellerbycategory extends Mage_Adminhtml_Model_System_Config_Source_Category
{	
	
	protected function _construct()
    {
        $this->_init('clickview/system_config_source_Categorybestsellerbycategory');
    } 
	
	
    public function toOptionArray($addEmpty = true)
    {	
    	
    	$catAllowed = self::getCategoryAllowed();
    	$options 	= array();
    	$storeId    = Mage::app()->getStore()->getId();
        $collection = Mage::getModel('catalog/category')
        ->getCollection()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('entity_id', array('in' => $catAllowed))
        ->setStoreId($storeId);
	    
		foreach($collection as $category){
            if($category->getName() != 'Root Catalog'){
                $options[] = array(
                   'label' => $category->getName(),
                   'value' => $category->getId()
                );
            }
        }
        return $options;
    }
    
    public function getCategoryAllowed(){
 		$cat = explode(',', Mage::getStoreConfig('clickview_by_category/clickview_best_seller_by_category/clickview_category_allowed'));
 		return $cat;
 	}
 	
}


?>