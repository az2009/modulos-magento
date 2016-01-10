<?php 

	class Jefferson_Cartabandoned_Adminhtml_AbandonedController  extends Mage_Adminhtml_Controller_action {
		
		/**
		 *  Carrega o layout		 
		 */
		
		public function indexAction(){
			$this->_initAction()
				 ->renderLayout();
		}

		/**
		 *  Inicia a criação do layout
		 */
		 
		protected function _initAction() {
			$this->loadLayout()
			->_setActiveMenu('newsletter/cartabandoned')
			->_addBreadcrumb(Mage::helper('cartabandoned')->__('Abandoned Cart'));					
			return $this;
		}
		
		/**
		 * 	Executa o disparo dos e-mails e pega os carrinhos abandonados
		 */
		
		public function massEnviarAction(){
			
			/*Pega os carrinhos marcados para enviar e-mail*/
				$post = $this->getRequest()->getPost('cartabandoned');
                
    			$block = $this->getLayout()
    			             ->createBlock('cartabandoned/frontend_disparo')
                             ->setData($post)
    			             ->execDisparo();
                
                /*Redireciona para a tela do grid*/ 
                    $this->_redirect('*/*/index');

		}
		
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	