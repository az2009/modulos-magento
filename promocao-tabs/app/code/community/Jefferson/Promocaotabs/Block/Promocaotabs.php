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
	class Jefferson_Promocaotabs_Block_Promocaotabs extends Mage_Catalog_Block_Product_List {
		
		public function getProducts($categoryCurrent){
			 return Mage::getModel('promocaotabs/promocaotabs')->getDataProducts($categoryCurrent);
		}
		
		public function getCategoryName($category){
			 	
			 return Mage::getModel('promocaotabs/promocaotabs')->getCategoryName($category);
			 
		}
		
		public function getCatsArray(){
			 return Jefferson_Promocaotabs_Helper_Data::formatCategory();
		}
		
		public function getImgSize(){
		
			$img_size = preg_replace("/[^0-9]/", "", Mage::getStoreConfig('catalog/jefferson_promocaotabs/img_size'));
			
			if(!empty($img_size)){
				
				return $img_size;
				
			}else{
				
				return "250";
			}
		}
		
		public function getCategoryQty(){
			return  Mage::getStoreConfig('catalog/jefferson_promocaotabs/category_qty');
		}
		
		public function getActive(){
			return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('catalog/jefferson_promocaotabs/enable'));
		}
		
		public function getPerc($val1, $val2){
			
			$active = Mage::getStoreConfig('catalog/jefferson_promocaotabs/overview_perc');
			
			if($active == 1){
				return Jefferson_Promocao_Helper_Data::calcPerc($val1, $val2);
			}
				
		}
			
	}

?>