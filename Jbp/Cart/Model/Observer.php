<?php
class Jbp_Cart_Model_Observer
{

    protected $newCart = [];
    protected $allItems = [];
    
    const LIMIT_CART = 100;
 
    public function explodeCartOrder($observer){
        $result = array();
        try{
            $this->generated();                        
            foreach($this->newCart as $cart){
                $service = Mage::getModel('sales/service_quote', $cart);
                $service->submitAll();
                $increment_id = $service->getOrder()->getRealOrderId();
                Mage::getSingleton('checkout/session')->clear();
                Mage::getSingleton('checkout/session')->setLastOrderId($service->getOrder()->getId());
                $url = Mage::getUrl('checkout/onepage/success');
                $result['success'] = true;
                $result['error']   = false;
                $result['redirect'] = $url;
            }
        }catch(Exception $e){
            Mage::log($e->getMessage());
            echo $e->getMessage();
            $result['success']  = false;
            $result['error']    = true;
            $result['error_messages'] = $this->__('There was an error processing your order. Please contact us or try again later.');
        }                   
        $this->_setRedirect($result);
        exit();            
    }
    
    /**
     * redireciona para a página de sucesso
     */
    protected function _setRedirect($result){               
        $response = Mage::app()->getResponse();
        $response->setHeader('Content-type', 'application/json', true);
        $response->setBody(Mage::helper('core')->jsonEncode($result));
        return $response->sendResponse();
    }
    
    /**
     * - gera um novo carrinho
     *   - adiciona os itens ao carrinho
     */
    protected function generated(){
        //checkout/session atual
        $quoteSession = $this->_getQuoteOrig();
    
        //quantidade atual total do carrinho
        $qtyTotalCart = $quoteSession->getData('items_qty');
    
        //verifica se a quantidade de produtos no carrinho é maior do que o limite
        if($qtyTotalCart > self::LIMIT_CART){
    
            $convertQuoteObj = Mage::getSingleton('sales/convert_quote');
    
            //adiciona os itens no carrinho
            $x=0;$this->allItems = $quoteSession->getAllItems();
            while($x < count($this->allItems)){
                $item = $this->allItems[$x];
                $quote = $this->_getCurrentQuote();
                unset($item['item_id']);
                $this->explodeItem($item, $quote);
                $x++;}
    
                foreach($this->newCart as $cart)
                    if($cart instanceof Mage_Sales_Model_Quote)
                        $this->saveQuote($cart);
        }
    }
    
    /**
     * divide o item para completar a quantidade máxima do carrinho
     * @param unknown $item
     * @param unknown $qty
     */
    protected function explodeItem(Mage_Sales_Model_Quote_Item $item, Mage_Sales_Model_Quote $quote){
    
        $objQuote = Mage::getModel('sales/quote');
        $quote = Mage::getModel('sales/quote')->load($quote->getId());
    
        /* caso a quantidade do carrinho atual somado com a qty do item a ser adicionado couber no carrinho atual
         * adiciona
         */
        if(($quote->getData('items_qty') + $item->getQty()) < self::LIMIT_CART){
            $quote = Mage::getModel('sales/quote')->load($quote->getId());
            $quote->addItem($item);
            $quote->collectTotals()->save();
            return true;
        }
    
        /*verifica se o carrinho esta cheio e se o item a ser adicionado é menor que o limite
         * se sim gera um novo carrinho e adiciona o item
         */
        if(($quote->getData('items_qty') == self::LIMIT_CART)
            && ($item->getQty() <= self::LIMIT_CART)){
                $quote = $this->_getCurrentQuote();
                $quote = Mage::getModel('sales/quote')->load($quote->getId());
                $quote->addItem($item);
                $quote->collectTotals()->save();
                return true;
        }
    
        /*
         * verifica se a quantidade do item a ser adicionado é maior que o limite
         * se sim subtrai o limite menos a quantidade do carrihno
         * se retornar 0 quantidade recebe o limita máximo
         * else quantidade recebe o a quantidade a ser adicionada
         */
        if($item->getQty() > self::LIMIT_CART){
            $qty = self::LIMIT_CART - $quote->getData('items_qty');
            if($qty == 0)
                $qty = self::LIMIT_CART;
        }else{
            $qty = $item->getQty();
        }
    
        //multiplica por -1 para tornar o valor inteiro
        if($qty < 0) $qty = $qty * (-1);
    
        //quantidade a ser adicionada ao próximo carrinho
        $rest = ($item->getQty() - $qty);
        if($rest < 0) $rest = $rest * (-1);
    
        //clona o objeto do item e seta a quantidade para preencher o carrinho
        $newItem = clone $item;
        $newItem->setQty($qty);
    
        $quote = Mage::getModel('sales/quote')->load($quote->getId());
    
        /* soma a quantidade do carrinho mais a quantidade a ser adicionada
         * se o resultado for maior que o limite gera um novo carrinho para adicionar o
         * item com a quantidade dentro dos limites
         */
        if($quote->getData('items_qty') + $newItem->getQty() > self::LIMIT_CART){
            $quote = $this->_getCurrentQuote();
            $quote = Mage::getModel('sales/quote')->load($quote->getId());
        }
    
        //adiciona o clone com a quantidade atualizada para o carrinho
        $quote->addItem($newItem);
        $quote->collectTotals()->save();
    
    
        //seta no objeto atual a quantidade restante para o próximo carrinho
        if($rest > 0)
            $item->setQty($rest);
    
            //verifica se o carrinho esta cheio e se o item a ser adicionado é menor que o limite e se existe resto de qty a ser adicionado
            if(($quote->getData('items_qty') == self::LIMIT_CART)
                && ($item->getQty() <= self::LIMIT_CART) && $rest > 0){
                    $quote = $this->_getCurrentQuote();
                    $quote = Mage::getModel('sales/quote')->load($quote->getId());
                    $quote->addItem($item);
                    $quote->collectTotals()->save();
            }elseif($rest > 0){
                self::explodeItem($item, $quote);
            }
            return true;
    }
    
    /**
     * retorna o próximo item do laço
     * @param unknown $current
     * @return unknown
     */
    protected function nextItem($current){
        $pos  = $current + 1;
        if(array_key_exists($pos, $this->allItems))
            return $this->allItems[$pos];
            return false;
    }
    
    /**
     * Instancia um novo carrinho
     * caso o atual esteja dentro do limite ou
     * não exista carrinho criado
     * $posCurrent posição atual do laço
     * @return Mage_Sales_Model_Quote
     */
    protected function _getCurrentQuote(){
    
        if(count($this->newCart))
            $x=0;
             
            foreach($this->newCart as $cart){
                $cart = Mage::getModel('sales/quote')->load($cart->getId());
                if($cart instanceof Mage_Sales_Model_Quote
                    && $cart->getData('items_qty') < self::LIMIT_CART)
                {
                    return $cart;
                }
                elseif(! $cart instanceof Mage_Sales_Model_Quote)
                {
                    unset($this->newCart[$x]);
                }
                $x++;
            }
    
            $this->newCart[] = $this->_getQuote();
            return end($this->newCart);
    }
    
    /**
     * retorna uma nova instancia do quote
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote(){
        $quote = Mage::getModel('sales/quote')
        ->setStoreId(Mage::app()->getStore()->getId())
        ->assignCustomer($this->_getCustomer());;
        $quote->setIsActive(true);
        $quote->setCustomer($this->_getCustomer());
        $quote->save();
        return $quote;
    }
    
    /**
     * retorna o quote checkout/session
     * @return Mage_Checkout_Model_Session
     */
    protected function _getQuoteOrig(){
        return $this->_getCheckout()->getQuote();
    }
    
    /**
     * retorna a sessão atual do checkout
     * @return Mage_Checkout_Model_Session
     */
    protected function _getCheckout(){
        return Mage::getSingleton('checkout/session');
    }
    
    /**
     * retorna o usuário da sessão checkout session e
     * retorna uma instancia do customer/customer
     * @return Mage_Customer_Model_Customer
     */
    protected function _getCustomer(){
        $customerId = (int)$this->_getQuoteOrig()->getCustomerId();
        if(!$customerId)
            Mage::throwException('cliente_nao_encontrado');
            $customer = Mage::getModel('customer/customer')->load($customerId);
            return $customer;
    }
    
    /**
     * retorna o método de envio da sessão
     * @return unknown
     */
    protected function _getShippingMethod(){
        $shippingMethod = $this->_getQuoteOrig()
        ->getShippingAddress()
        ->getShippingMethod();
        if(empty($shippingMethod))
            Mage::throwException('metodo_envio_invalido');
            return $shippingMethod;
    }
    
    /**
     * retorna o método de pagamento da sessão
     * @return unknown
     */
    protected function _getPaymentMethod(){
        $paymentMethod = $this->_getQuoteOrig()
        ->getPayment()
        ->getMethod();
        if(empty($paymentMethod))
            Mage::throwException('metodo_pagamento_invalido');
            return $paymentMethod;
    }
    
    /**
     *
     * @return unknown
     */
    protected function _getShippingAddress(){
        $address = $this->_getHelper()->setShippingAddress();
        return $address;
    }
    
    /**
     *
     * @return array
     */
    protected function _getBillingAddress(){
        $address = $this->_getHelper()->setBillingAddress();
        return $address;
    }
    
    /**
     * seta os dados do quote
     *  - endereço de envio
     *  - endereço de cobrança
     *  - método de pagamento
     *  - método de envio
     * salva o quote
     * @param Mage_Sales_Model_Quote $quote
     */
    protected function saveQuote(Mage_Sales_Model_Quote $quote){
    
        //setando o endereço de cobrança
        $billingAddress  = $quote->getBillingAddress()->addData($this->_getBillingAddress());
    
        //setando o endereço de envio
        $shippingAddress = $quote->getShippingAddress()->addData($this->_getShippingAddress());
    
        //setando o método de pagamento e envio e salva o quote
        $shippingAddress->setCollectShippingRates(true)
        ->collectShippingRates()
        ->setShippingMethod($this->_getShippingMethod())
        ->setPaymentMethod($this->_getPaymentMethod());
    
        $quote->getPayment()->importData(array('method' => $this->_getPaymentMethod()));
    
        $quote->collectTotals()->save();
    
        return $quote->save();
    }
    
    protected function _getHelper(){
        return Mage::helper('cart/order');
    }
    
    
}

