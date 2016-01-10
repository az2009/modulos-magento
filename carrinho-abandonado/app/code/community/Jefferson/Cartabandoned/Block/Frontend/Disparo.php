<?php
    class Jefferson_Cartabandoned_Block_Frontend_Disparo extends Mage_Core_Block_Abstract {

        private $item;
        private $data;
        private $grand_total;
        private $subtotal;
        private $discount;
        private $idFila;
        private $modelItem;
        private $qtyCart;


        /**
         *  Inicia o disparo dos e-mails
         *  @return mixed
         */

        public function execDisparo(){

            /*Pega os carrinhos marcados para enviar e-mail*/
                $post = $this->getData();

            /*Instâncias*/
                $model           = Mage::getModel('cartabandoned/cartabandoned');
                $helper          = Mage::helper('cartabandoned');
                $collection      = Mage::getResourceModel('reports/quote_collection')
									   ->addFieldToFilter('main_table.items_qty', array('gt' => 0 ));
                $product         = Mage::getModel('catalog/product');
                $this->modelItem = Mage::getModel('cartabandoned/itemenvio');
                $modelFila       = Mage::getModel('cartabandoned/filaenvio');


			     /*Verifica se tem alguma fila sendo executada*/
    				if($modelFila->checkExistFila()){

    					if(count($post) > 0){
    						Mage::getSingleton('core/session')
    									->addError(Mage::helper('cartabandoned')
    											        ->__("There's a line running, wait for this queue is over to start a new line."));
    					}

    					return;
    					exit;
    				}

                /*Verifica se a requisição vem do painel ou cron*/
    				if(!count($post) > 0){

    				    /*Se a requisição vier do CRON verifica se o próximo envio pode ser executado de acordo com o tempo configurado*/
                            if(!$helper->checkLastSend()){
                                //echo "Ainda não";
                                return;
                                exit;
                            }else{
                                //echo "agora sim";
                            }
                    }

            /*Filtrando os carrinhos abandonadoas da loja*/
                $collection->setOrder('entity_id','DESC');
                $collection->prepareForAbandonedReport(Mage::app()->getStore()->getStoreId());


            /*Verifica se a requisição vem por um Cron ou Admin*/
                if(count($post) > 0){

                	/*Filtrando os resultados que vieram via post*/
                    	$collection->addFieldToFilter('main_table.entity_id', array('in' => $post));
                }

            /*Pegando a quantidade de carrinhos abandonados antes do envio*/
                $modelFila->qtyCart = count(Mage::getResourceModel('reports/quote_collection')
                                       ->prepareForAbandonedReport(Mage::app()->getStore()->getStoreId())
									   ->addFieldToFilter('main_table.items_qty', array('gt' => 0 ))
                                       ->getData());



			/*Verifica se tem carrinho abandonado*/
				if(!$modelFila->qtyCart > 0 ){
					//echo "<br />sem carrinho";

					/*Verifica se a requisição vem do painel*/
						if(count($post) > 0){

						    /*Lançando mensagem de erro para o painel*/
    							Mage::getSingleton('core/session')
    								->addError(Mage::helper('cartabandoned')
    										->__('Not found abandoned cart'));
						}

					return;
					exit;
				}

            /*Grava a fila que esta sendo iniciada e pega o id retornado*/
                $this->idFila       = $modelFila->setFila()->getData('id_fila_envio');

            /*Correndo os usuários dos carrinhos abandonados*/
                $tt = 0;foreach($collection as $this->item){

                    /*Verifica se a fila corrente foi parada a força*/
                        if(Mage::getModel('cartabandoned/filaenvio')->checkExistFilaById($this->idFila)){
                                continue 1;
                        }

                        /*Zera as variáveis para carregar o próximo carrinho*/
                            unset($html);
                            unset($listProducts);


                        /*Pega a quantidade de carrinho abandonado*/
                            $this->qtyCart = $this->item->getData();

                        /*Método que pega os itens do carrinho do usuário corrente*/
                            foreach($this->item->getAllVisibleItems() as $i){

                                /*Carregando o produto corrente*/
                                    $product->load($i->getProductId());

                                    try{
                                        $img = (string)Mage::helper('catalog/image')->init($product, 'small_image')->keepFrame(true)->resize(150,100);
                                    }catch(Exception $e){
                                        $img = '';
                                    }

                                /*Populando o array com os parametros do item corrente*/
                                    $listProducts[] = array(
                                            'name'  => $i->getName(),
                                            'price' => Mage::helper('core')->currency($i->getPrice(), true, false),
                                            'image' => $img,
                                            'qty'   => $i->getQty(),
                                            'total' => Mage::helper('core')->currency($i->getData('base_row_total_incl_tax'), true, false),
                                    );

                            }

                        /*Calcula o desconto do carrinho*/
                            $ds = ($this->item->getData('base_subtotal') - $this->item->getData('grand_total'));

                        //Pegando as variaveis do carrinho
                            $this->grand_total = Mage::helper('core')->currency($this->item->getData('grand_total'), true, false);
                            $this->subtotal    = Mage::helper('core')->currency($this->item->getData('base_subtotal'), true, false);
                            $this->discount    = Mage::helper('core')->currency($ds, true, false);

                        /*Método que monta as linhas do carrinho com os itens*/
                            $html = $helper->mountLinesCart($listProducts);

                        /*Chamando o método que gera a chave de autenticação*/
                            $key  = $helper->generateKey($this->item->getEmail(), $this->item->getCustomerId());

                        /*Atribuindo os valores aos objetos da classe Itemenvio*/
                            $this->modelItem->idFilaEnvio       = $this->idFila;
                            $this->modelItem->emailCustomer     = $this->item->getEmail();
                            $this->modelItem->idCustomer        = $this->item->getId();

                        /*Gravando os itens enviados na tabela de relatório e pegando o id*/
                            $idOpen                             = $this->modelItem->setItemEnvio()->getData('id_item_envio');

                        /*Pegando as configurações do desconto*/
                            $discountEnable     = Mage::getStoreConfig('cartabandoned_options/cartabandoned_general/cartabandoned_discount_enabled');
                            $discountInfoCoupon = Mage::getStoreConfig('cartabandoned_options/cartabandoned_general/cartabandoned_info_coupon');
                            $discountInfoQty    = Mage::getStoreConfig('cartabandoned_options/cartabandoned_general/cartabandoned_info_qty_coupon');

                        /*Retorna uma determinada url dependendo se tem cupom*/
                            if($discountEnable == '1' && !empty($discountInfoCoupon)){
                                $url = Mage::getUrl('cartabandonedj/index/execlogin/id/'.$idOpen.'/key/'.$key.'/discount/1');
                            }else{
                                $url = Mage::getUrl('cartabandonedj/index/execlogin/id/'.$idOpen.'/key/'.$key);
                            }


                        /*Passando as variaveis a serem utilizados no e-mail*/
                            $args = array(
                                    'customer_name'  => $this->item->getCustomerName(),
                                    'customer_email' => $this->item->getEmail(),
                                    'link'           => $url,
                                    'html'           => $html,
                                    'grand_total'    => $this->grand_total,
                                    'subtotal'       => $this->subtotal,
                                    'discount'       => $this->discount,
                                    'linkOpen'       => Mage::getUrl('cartabandonedj/index/setopenmail/key/'.$idOpen)

                            );

                        /*Se tiver desconto seta as variaveis de cupom no template de email*/
                            if($discountEnable == 1 && !empty($discountInfoCoupon)){
                                $args['cupom']     = $discountInfoCoupon;
                                $args['cupom_qty'] = $discountInfoQty;
                            }

                        /*Verifica se tem os argumentos mínimos para criar o template html*/
                            if(!empty($args['customer_name']) && !empty($args['customer_email']) && !empty($args['link'])){

                                /*Populando o objeto do método setKeyData*/
                                    $model->key         =  $key;
                                    $model->idCustomer  =  $this->item->getCustomerId();

                                /*Método que grava a chave de autenticação quando o usuário clicar no link*/
                                    $model->setKeyData();

                                /*Disparando o e-mail*/
                                    $send = $helper->sendMail($args);

                                /*Verifica se o e-mail foi enviado com sucesso*/
                                    if($send === true){
                                        $y[] = $this->item->getEmail();
                                    }else{
                                        $x[] = $this->item->getEmail();

                                    /*Deleta o item enviado da tabela caso ocorra falha no envio do mesmo*/
                                        $this->modelItem->id = $idOpen;
                                        $this->modelItem->deleteItemEnvio();

                                    }
                            }

                        /*Executa o disparo a cada X segundo*/

                            //Fecha a conexão antes de colocar o server para dormir
                                Mage::getSingleton('core/resource')->getConnection('core_read')->closeConnection();
                            sleep((int)$helper->getTimeEnvio());

            }

            if(count($post) > 0){
                /*Lança na tela o alert se houve erro e e-mails enviados com sucesso*/
                    $helper->deployError($x, $y);
            }


            /**
             * Registra o fim da fila corrente
             */

            $modelFila->idFila = $this->idFila;
            $modelFila->setFilaEnd();

        }


























    }
