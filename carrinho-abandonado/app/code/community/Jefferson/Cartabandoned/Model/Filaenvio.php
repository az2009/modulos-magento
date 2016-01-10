<?php 	


	class Jefferson_Cartabandoned_Model_Filaenvio extends Mage_Core_Model_Abstract {
		
        private $qtyCart;
        private $idFila;
        
		protected function _construct(){
			parent::_construct();
			$this->_init('cartabandoned/filaenvio');
		}
		
		
		/**
		 * Registra a data de envio da disparo
		 *  @return array 
		 */
		public function setFila(){			
			$helper = Mage::helper('cartabandoned');	
			$collection = Mage::getModel('cartabandoned/filaenvio')			
			                  ->setData('data_envio_fila_envio', $helper->getDateTimeCurrent())
                              ->setData('qty_cart', $this->qtyCart);
			
			return $collection->save();
			
		}
		
        /**
         * Registra o fim do envio da fila
         * @return array
         */
        public function setFilaEnd(){
            $collection = Mage::getModel('cartabandoned/filaenvio')->load($this->idFila)         
                              ->setData('status', '2')
                              ->setData('end_envio', Mage::helper('cartabandoned')->getDateTimeCurrent());
            
            return $collection->save();            
        }
        
        /**
         * Pega o últmo envio
         * @return mixed 
         */
         
         public function getLastFila(){
             $collection = Mage::getModel('cartabandoned/filaenvio')
                                ->getCollection()
                                ->addFieldToSelect('*');
             
			 if(count($collection->getData()) > 0){
	             foreach($collection as $item){
	                 $id = $item->getData('end_envio');
	             }             
				 
	             return $id;
			 }else{
			 	return true;
			 }                        
         }
        
		/**
		 * Verifica se existe uma fila em execução
		 * @return boolean 
		 */
		 
		 public function checkExistFila(){
		 	$collection = Mage::getModel('cartabandoned/filaenvio')
							  ->getCollection()
							  ->addFieldToSelect('*')
							  ->addFieldToFilter('status', '1');
			
			if(count($collection->getData()) > 0){
				return true;
			}else{
				return false;
			}			
										
		 }
		 
		 /**
		  * Verifica se a última fila foi parada a força
		  * @param string $id
		  * @return boolean
		  */
		 
		 public function checkExistFilaById($id){
		     $collection = Mage::getModel('cartabandoned/filaenvio')->load($id);
		     	
		     if($collection->getData('status') == '2'){
		         return true;
		     }else{
		         return false;
		     }
		 
		 }
		
		/**
		 * Finaliza todas as filas de envio em execução
		 * @return boolean
		 */ 
		 
		 public function stopFila(){
		     $collection = Mage::getModel('cartabandoned/filaenvio')
                		     ->getCollection()
                		     ->addFieldToSelect('*')
                		     ->addFieldToFilter('status', '1');
		     	
		     if(count($collection->getData()) > 0){
		         
		         foreach ($collection as $data){
		             $id = $data->getData('id_fila_envio');
		              
		             Mage::getModel('cartabandoned/filaenvio')
		                  ->load($id)
		                  ->setData('status','2')
		                  ->save();
		         }		         
		         return true;
		         exit;		         
		     }else{
		         return false;
		         exit;
		     }
		 }
		 
		 
		 
		 
		/**
		 * Métodos SET & GET
		 */
		
		 public function __get($propriedade){
			return $this->$propriedade;
		 }
		
		 public function __set($propriedade, $valor){
			$this->$propriedade = $valor;
		 }
		
        
        
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	