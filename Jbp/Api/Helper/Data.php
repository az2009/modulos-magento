<?php
class Jbp_Api_Helper_Data extends Mage_Core_Helper_Abstract {
    
    public function getUri(){
        $config = Mage::getStoreConfig('jbp_api/config/uri_request');
        return $config;
    }
    
    public function getDefaultTimeOut(){
        $config = Mage::getStoreConfig('jbp_api/config/default_time_out');
        return $config;
    }
    
    public function getUserPass(){
        $config = Mage::getStoreConfig('jbp_api/config/user_pass');
        return $config;
    }
    
    public function getUserName(){
        $config = Mage::getStoreConfig('jbp_api/config/user_name');
        return $config;
    }
    
    public function getToken(){
        $config = Mage::getStoreConfig('jbp_api/config/token');
        return $config;
    }
    
    public function prepareBody($type, $data){
        if(empty($data))
            return false;
        $type = trim(strtoupper($type));
        $body = null;        
        switch($type){
            case 'APPLICATION/JSON':
                $body = Mage::helper('core')->jsonDecode($data);
                if(is_array($body) && $body)
                    $body = new Varien_Object($body);
            break;
            
            case 'APPLICATION/XML':
                $assoc = simplexml_load_string($data);
                $body  = Mage::helper('core')->xmlToAssoc($assoc);                
            break;
            
            default:
                $body = $data;
            break;
        }        
        return $body;
    }
    
}