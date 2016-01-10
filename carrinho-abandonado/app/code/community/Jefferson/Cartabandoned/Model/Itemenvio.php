<?php 
	
	class Jefferson_Cartabandoned_Model_Itemenvio extends Mage_Core_Model_Abstract {
		
		private $idFilaEnvio;
		private $emailCustomer;
		private $idCustomer;
		private $model;
		private $helper;
		private $key;
		private $id;
		private $idClick;
		
		protected function _construct(){
			parent::_construct();
			$this->_init('cartabandoned/itemenvio');
			$this->helper = Mage::helper('cartabandoned');
		}

		/**
		 * Grava na tabela o e-mail do usuários que foi disparado o envio
		 * @return object
		 */
				
		public function setItemEnvio(){
			$collection = Mage::getModel('cartabandoned/itemenvio');
			$collection->setData('id_fila_envio_item_envio',  $this->idFilaEnvio)
        			   ->setData('data_envio_item_envio', 	$this->helper->getDateTimeCurrent())
        			   ->setData('email_customer', 	  		$this->emailCustomer)
        			   ->setData('id_customer', 	  			$this->idCustomer);
			
			return $collection->save();
			
		}
		
		/**
		 * Deleta da tabela de rela tório o e-mail do usuário que ocorreu falha no envio  
		 */
		 
		public function deleteItemEnvio($id){
		    Mage::getModel('cartabandoned/itemenvio')->load($id)->delete();
		}
		
		/**
		 * Atualiza o status Abriu/Não abriu do item enviado  
		 * Evento chamado quando o usuário abri o e-mail
		 */
		 
		public function setOpenMail(){
		    $collection = Mage::getModel('cartabandoned/itemenvio')->load($this->key);
		    if(count($collection->getData()) > 0){
		        $collection->setData('open','Sim')->save();
		    }                                                    			   			
		}
		
		/**
		 * Registra o click do e-mail que foi clicado
		 */
		
		public function setClickMail(){
		    $collection = Mage::getModel('cartabandoned/itemenvio')->load($this->idClick);
			if(count($collection->getData()) > 0){
                $collection->setData('click','Sim')->save();             
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