<?php


/**
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
 
 class Jefferson_Clickview_Block_Clickviewblock extends Mage_Catalog_Block_Product_List {
		
		/**
		* Take the methods of model
		* 
		* Jefferson_Clickview_Model_Observer
		* Jefferson_Clickview_Model_Clickviewmodel
		*/
		
		protected $obj 	  = null;
		protected $objObs = null;
		
		public function _construct(){
			$this->obj 	  = Mage::getSingleton('clickview/clickviewmodel');
			$this->objObs = Mage::getSingleton('clickview/observer');
		}
		
		public function getCookie(){
			return $this->objObs->getCookie('IDPRODUCT');
		}
		
		public function getCategoryProducts($id){
			return $this->obj->getCategoryProducts($id);
		}
		
		public function getCategoryName($category){
			return $this->obj->getCategoryName($category);
		}
		
		public function getDataProducts($entity_id, $categoryCurrent, $limit){
			return $this->obj->getDataProducts($entity_id, $categoryCurrent, $limit);
		}
		
		public function getDataProductCurrent($id){
			return $this->obj->getDataProductCurrent($id);
		}
		
		public function getDataProductSingle($id){
			return $this->obj->getDataProductSingle($id);
		}
		
		public function getDataProductsRelated($id){
			return $this->obj->getDataProductsRelated($id);
		}
		
		public function getClickCountRows(){
			return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_options/clickview_general/clickview_click_number_rows'));
		}
		
		public function getClickEnabled(){
			return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_options/clickview_general/clickview_click_enabled'));
		}
		
		public function getClickImgSize(){
			return preg_replace("/[^0-9]/", "", Mage::getStoreConfig('clickview_options/clickview_general/clickview_img_size'));
		}
				
 }
	
?>