<?php
	class Jefferson_Cartabandoned_Helper_Data extends Mage_Core_Helper_Abstract {


		/**
		 * Efetua o disparo do e-mail
		 * @param array $param
		 * @return boolean
		 */

		public function sendMail($param = Array()){

			//Pega o id da loja
				$storeId = Mage::app()->getStore()->getStoreId();

	    	try{
		    	//Carrega o template para envio
		    		$emailTemplate = Mage::getModel('core/email_template')->loadDefault('cartabandoned_email_template');

				//Pega o nome de identificação da loja /E-mail Geral
					$senderName = Mage::getStoreConfig('trans_email/ident_general/name');

				//Pega o e-mail de identificação da loja /E-mail Geral
					$senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

				//Variáveis do template de e-mail
					$emailTemplateVariables = array(
						'customer_name'  => $param['customer_name'],
						'customer_email' => $param['customer_email'],
						'link'  		 => $param['link'],
						'html'			 => $param['html'],
						'grand_total'	 => $param['grand_total'],
						'subtotal'	 	 => $param['subtotal'],
						'discount'		 => $param['discount'],
						'linkOpen'		 => $param['linkOpen'],
					    'subject'		 => Mage::getStoreConfig('cartabandoned_options/cartabandoned_general/cartabandoned_subject_fila')
						);

					/*Verifica se a qty e o cupom estão sendo informados*/
						if(!empty($param['cupom']) && !empty($param['cupom_qty'])){
							$emailTemplateVariables['cupom'] 	 = $param['cupom'];
							$emailTemplateVariables['cupom_qty'] = $param['cupom_qty'];
						}

				//Setando as variáveis personalizadas no template
					$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);

				/*Renderiza o template e lança na tela*/
                    //echo $processedTemplate;

				//Pega o e-mail geral da loja
					$emailTemplate->setSenderEmail(Mage::getStoreConfig('trans_email/ident_general/email', $storeId));

				//Pega o nome do e-mail geral da loja
					$emailTemplate->setSenderName(Mage::getStoreConfig('trans_email/ident_general/name', $storeId));

				//Seta o tipo de dados
					$emailTemplate->setType('html');

				//Executa o envio
					$senddv = $emailTemplate->send($emailTemplateVariables['customer_email'], $emailTemplateVariables['customer_name'], $emailTemplateVariables);

					if($senddv === true){
						return true;
					}
					   Mage::log(Mage::helper('cartabandoned')->__('Unable to send to the following recipient: '.$mailCustomer));
					   return false;
			}catch(Exception $e){
				throw new exception($e->getMessage());
				return false;
			}
	    }


	    /**
	     * Gera a chave de autenticação
	     * @param string $emailCustomer
	     * @param string $idCustomer
	     * @return string
	    */

	    public function generateKey($emailCustomer,$idCustomer){
	    	$key = md5($emailCustomer.$idCustomer);
	    	return $key;
	    }

	    /**
	     * Ocasiona um redirecionamento para a url informada
	     * @param string $msg
	     * @param string $url
	     * @param string $type
	    */

	    public function setMsgRedirect($msg, $url, $type = null){
	        if($type == 'error' || $type == null){

	            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cartabandoned')->__($msg));
    	    	Mage::app()->getResponse()->setRedirect(Mage::getUrl($url))->sendResponse();

	        }else if($type == 'success'){
	            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cartabandoned')->__($msg));
	            Mage::app()->getResponse()->setRedirect(Mage::getUrl($url))->sendResponse();
	        }
	    }

	    /**
		 * Monta um html com os itens do carrinho
		 * @param array $data
		 * @return string
		 */

	    public function mountLinesCart($data){
			if($data){

			    unset($x);

				$x=0; foreach($data as $p){

				    if($x == 0):
				        $html .= "<tr class='teste_$x'>";
				        $x=1;
				    endif;

    					$html .="<td align='center' width='200' style='text-align: left;'>
    					           <div style='margin: 0 auto;width:200px;'>
    					               <img src='".$p['image']."' alt='".$p['name']."' title='".$p['name']."' />
        						       <h2 style='color: #ff6447; font-size: 15px;font-family:Arial; font-style:normal;margin: 5px 0;width: 200px;text-align: left;'>".$p['name']."</h2>
        						       <h3 style='color: #56834A;font-weight: 100;font-family:Arial; font-style:normal;margin: 5px 0;font-size: 15px;width: 200px;text-align: left;'>".$p['price']."</h3>
        						        <a href='{{var link}}'>
            				                <h4 style='background: #56834A;width: 100px;border-radius: 5px;color: #fff;text-align: center;float:left; text-transform: uppercase;font-weight: 400;font-family:Arial; font-style:normal;font-size: 15px; margin: 5px 0 50px 0;'>".$this->__('BUY')."</h4>
        						        </a>
        						   </div>
        						 </td>";

    				if($x == 3):
    					$html .= "</tr>";
    				    $x= -1;
    				endif;

				$x++; }

				unset($x);
				return $html;
			}
		}

		/**
		 * Pega a data e hora
		 * @return string
		 */

		public function getDateTimeCurrent(){
			$dateTime = date('Y-m-d H:i:s', Mage::getModel('core/date')->timestamp(time()));
			return $dateTime;
		}

		/**
		 * Lança as mensagens de erros na tela
		 * @param array $x
         * @param array $y
         * @return mixed
		 */

		public function deployError($x, $y){
			if(count($x) != 0){
				return Mage::getSingleton('core/session')->addError(
						Mage::helper('cartabandoned')->__('Unable to send alert to the following recipients: '.implode(',',$x))
 				);
			}

			if(count($y) != 0){
				return Mage::getSingleton('core/session')->addSuccess(
						Mage::helper('cartabandoned')->__('The email has been sent to the following recipients: '.implode(',',$y))
 				);
			}
		}

        /**
         * Retorna a configuração do intervalo da execução da fila
         * @return int
         */

        public function getTimeIntervalFila(){
            $config = (int)Mage::getStoreConfig('cartabandoned_options/cartabandoned_general/cartabandoned_time_interval_fila');
            return $config;
        }

        /**
         * Retorna a configuração do intervalo da execução do envio entre um e-mail e outro
         * @return string
         */

        public function getTimeEnvio(){
            $config = (int)Mage::getStoreConfig('cartabandoned_options/cartabandoned_general/cartabandoned_time_envio');
            return $config;
        }

        /**
         * Verifica se esta dentro do tempo de envio
         * @return boolean
         */

        public function checkLastSend(){

            $model          = Mage::getModel('cartabandoned/filaenvio');

            $interval       = '+'.self::getTimeIntervalFila().'hours';
            $dateCurrent    = self::getDateTimeCurrent();
            $dateLastSend   = $model->getLastFila();

			if($dateLastSend){
	            if(strtotime($dateCurrent) >= strtotime($dateLastSend.$interval)){
	                return true;
	            }
	                return false;
			}
				return true;
        }

	}































