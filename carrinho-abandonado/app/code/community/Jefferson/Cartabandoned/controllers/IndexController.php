<?php
	class Jefferson_Cartabandoned_IndexController extends Mage_Core_Controller_Front_Action {

		/**
		 * 	Executa o disparo dos e-mails e pega os carrinhos abandonados
		*/

		public function indexAction(){}

		/**
		 * Atualiza o status do email aberto para Visualizado
		 */

		public function setOpenMailAction(){
			$model 		= Mage::getModel('cartabandoned/itemenvio');
			$model->key = $this->getRequest()->getParam('key');
			$model->setOpenMail();
		}

		/**
		 * Efetua o login do usuário e redireciona para o carrinho
		 */

		public function execLoginAction(){

			$key 	     = $this->getRequest()->getParam('key');

			$id		     = (int)$this->getRequest()->getParam('id');

			$discount    = (int)$this->getRequest()->getParam('discount');

			$model       = Mage::getModel('cartabandoned/cartabandoned');

			$helper      = Mage::helper('cartabandoned');

			$model->key  = $key;

			$checkKey    = $model->getKeyData();

    			if($checkKey['result'] == true){

    				$model->idCustomer = $checkKey['id'];

    				if($model->loginCustomer() == true){

    					$modelClick = Mage::getModel('cartabandoned/itemenvio');

    					$modelClick->idClick = $id;

    					$modelClick->setClickMail();

    					if($discount == 1) {
    						$coupon = Mage::getStoreConfig('cartabandoned_options/cartabandoned_general/cartabandoned_info_coupon');
    						$this->_forward('couponPost','cart','checkout',array('coupon_code' => $coupon));

    					}else{
    						$this->_redirect('checkout/cart/');
    					}

    				}else{
    						$helper->setMsgRedirect('Failed to login', 'customer/login/');
    				}

    			}else{
    				$helper->setMsgRedirect('Cart not found', '');
    			}

		}

	}











