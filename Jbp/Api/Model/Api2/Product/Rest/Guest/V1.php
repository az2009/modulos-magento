<?php
class Jbp_Api_Model_Api2_Product_Rest_Guest_V1 extends Mage_Api2_Model_Resource{
    
    public function _retrieve()
    {
        $param = $this->getRequest()->getParam('id');
        
        $product = Mage::getModel('catalog/product')->load($param);
        
        return Mage::helper('core')->jsonEncode($product->getData());
        
    }
    
    
    public function _retrieveCollection()
    {
        $result = array();        
        $products = Mage::getResourceModel('catalog/product_collection')
                        ->addAttributeToSelect(array('name'));        
        foreach($products as $k){
            array_push($result, $k->getData());
        }                       
        return $result;
    }
    
}