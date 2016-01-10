<?php
/**
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

	class Jefferson_Clickview_Model_Observer {
		
		protected $name = 'IDPRODUCT';
		protected $id   = null;
		
		/**
		 * Get the id of the clicked product and called the method that the arrow product id in the cookie
		 * 
		 * @param $observer type Varien_Event_Observer
		**/
		public function setExecuteClickview(Varien_Event_Observer $observer){
			$this->id = $observer->getProduct()->getId();
			self::setCookie($this->name, $this->id);
		}
		
		/**
		 * Writes the product id in the cookie
		 * 
		 * @param $name String
		 * @param $value
		**/
		public function setCookie($name, $value){
			return Mage::getSingleton('core/cookie')->set($name, $value);
		}
		
		
		/**
		 * Get cookie data reported
		 * 
		 * @param $name String
		**/
		
		public function getCookie($name){
			return Mage::getSingleton('core/cookie')->get($name);
		}
		
		
		
	}
?>