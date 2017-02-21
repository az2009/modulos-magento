<?php
class Jbp_Api_Model_Observer {
    
    public function hasStockErp($observer){
        $sku = [];
        
        $order = $observer->getEvent()->getOrder();
        foreach ($order->getAllItems() as $item)
             $sku[] = $item->getSku();
        try{
            $response = $this->_getApi()
                             ->get('products/isStock', $sku)
                             ->getBody();            
            if($response !== true)
                 Mage::throwException('produtos fora de estoque');           
        }catch(Exception $e){
            Mage::throwException('não foi possível finalizar o pedido');
            Mage::log($e->getMessage());
        }        
        return $this;
    }
    
    protected function _getApi(){
        return Mage::getSingleton('jbp_api/api');
    }
    
}