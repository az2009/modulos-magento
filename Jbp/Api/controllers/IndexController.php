<?php
class Jbp_Api_IndexController extends Mage_Core_Controller_Front_Action {
    
    public function testeAction(){
        
    }
    
    public function indexAction(){
        try{
            
            //retornando uma instancia de Varien_Http_Client
            var_dump($response = $this->_getApi()
                ->post('example/sample',['key1' => 'value1','key2' => 'value2',])
                ->getClient());
                
            //retornando uma instancia de Zend_Uri_Http 
            var_dump($response = $this->_getApi()
                ->post('teste.php',['key1' => 'value1','key2' => 'value2',])
                ->getClient()
                ->getUri());
            
            //retornando o body da requisição
            var_dump($response = $this->_getApi()
                ->get('teste.php',['key1' => 'value1','key2' => 'value2',])
                ->getBody());
            
            //retornando os cabelhos das requisições
            var_dump($response = $this->_getApi()
                ->get('teste.php',['key1' => 'value1','key2' => 'value2',])
                ->getHeaders());
            
            //retornando o response da requisição
            var_dump($response = $this->_getApi()
                ->get('teste.php',['key1' => 'value1','key2' => 'value2',])
                ->getResponse());
            
            
        }catch (Exception $e){
            Mage::log($e->getMessage());
        }        
    }
    
    protected function _getApi(){
        return Mage::getSingleton('jbp_api/api');
    }
    
}