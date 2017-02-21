<?php
class Jbp_Api_Model_Api{
    
    protected $_client      = null;    
    protected $_uri         = null;
    protected $_response    = null;
    
    /**
     * inicia o objeto da classe Varien_Http_Client
     */
    public function __construct(){
        $this->_uri = $this->_getHelper()->getUri();
        $this->initClient();
    }
    
    /**
     * inicia uma instancia da classe Varien_Http_Client
     * @return Jbp_Api_Model_Api
     */
    public function initClient(){
        $this->_client = new Varien_Http_Client(
                                $this->_uri, 
                                ['timeout' => (int)$this->_getHelper()->getDefaultTimeOut()]
                            );
        return $this;
    }
    
    /**
     * executa uma requisição via post
     * @example 
     *      path = req/example
     *      data = ['key' => value]
     * @param string $path
     * @param array $data
     * @return Jbp_Api_Model_Api
     */
    public function post($path, Array $data){
        if($data)
            $this->_client->setParameterPost($data);
        $this->_client->setUri($this->_uri . DS . $path);
        $this->_response = $this->_client->request(Zend_Http_Client::POST);
        return $this;
    }
    
    /**
     * executa uma requisição via get
     * @example
     *      path = req/example
     *      data = ['key' => value]
     * @param string $path
     * @param array $data
     * @return Jbp_Api_Model_Api
     */    
    public function get($path, Array $data){
        if($data)
            $this->_client->setParameterGet($data);
            $this->_client->setUri($this->_uri . DS . $path);
            $this->_response = $this->_client->request(Zend_Http_Client::GET);
        return $this;
    }
    
    /**
     * executa uma requisição via post|get
     * @example
     *      method = post|get
     *      path   = req/example
     *      data   = ['key' => value]
     * @param string $path
     * @param array $data
     * @return Jbp_Api_Model_Api
     */
    public function request($method, $path, Array $data){
        $method = strtoupper(trim($method));
        if($method === Zend_Http_Client::GET){
            $method = Zend_Http_Client::GET;
            if($data)
                $this->_client->setParameterGet($data);
        }elseif($method === Zend_Http_Client::POST){
            $method = Zend_Http_Client::POST;
            if($data)
                $this->_client->setParameterPost($data);
        }else{return false;}
        $this->_client->setUri($this->_uri . DS . $path);            
        $this->_response = $this->_client->request($method);        
        return $this;
    }
    
    
    /**
     * Retorna a instancia da classe Varien_Http_Client criada no construtor da classe 
     * @return Varien_Http_Client
     */
    public function getClient(){
        return $this->_client;
    }
    
    /**
     * retorna o response da request
     * @return mixed
     */
    public function getBody(){
        $type = $this->_response->getHeader('content-type');
        $body = $this->_response->getBody();        
        $body = $this->_getHelper()->prepareBody($type, $body);
        return $body;
    }
    
    /**
     * retorna o cabeçalho da última requisição
     */
    public function getHeaders(){
        return $this->_response->getHeaders();
    }
    
    /**
     * retorna o response retornado pela ultima requisição
     */
    public function getResponse(){
        return $this->_response;
    }
    
    /**
     * retorna uma instancia da helper do módulo
     * @return Jbp_Api_Helper_Data
     */
    public function _getHelper(){
        return Mage::helper('jbp_api');
    } 
    
    
}