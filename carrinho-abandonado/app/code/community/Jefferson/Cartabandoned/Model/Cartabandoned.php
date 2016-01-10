<?php 
	
class Jefferson_Cartabandoned_Model_Cartabandoned extends Mage_Core_Model_Abstract {
	
    private $key;
    private $idCustomer;
	
	protected function _construct(){		
		parent::_construct();
		$this->_init('cartabandoned/cartabandoned');		
	}
	
    /**
     * Grava os dados da chave de login no banco
    */
    
    public function setKeyData(){
    	
    	$data = self::getKeyData();
    	
    	if($data['result'] == false){   
    	    $collection = Mage::getModel('cartabandoned/cartabandoned'); 	
	    	$collection->setData('id_customer_cart_abandonedj', $this->idCustomer)
        	    	   ->setData('key_cart_abandonedj', $this->key)
        	    	   ->save();	    	
    	}
    	
    }
    
    /**
     * Efetua o login através do id do usuário
     * @return array
    */
    
    public function loginCustomer(){
	
		$session = Mage::getSingleton('customer/session');
		
        try {
            
        	if(!$session->isLoggedIn()){
        		
	            $session->loginById($this->idCustomer);
				
				if($session->getCustomer()->getId()){
					$data = true;
				}else{
					$data = false;
				}
        	}else{
        		$data = true;        		
        	}
				
			return $data;
			
        } catch (Mage_Core_Exception $e) {
    		return false;
        }
		
    }
    
    
    /**
     * Verifica se a chave existe no banco
     * @return array
    */
    
    public function getKeyData(){
        $collection = Mage::getModel('cartabandoned/cartabandoned')
                           ->getCollection()
		    			   ->addFieldToFilter('key_cart_abandonedj', $this->key);
		    			
		foreach($collection as $data);    			
		
    	if($collection->count() > 0){
    		$data = array(
		    			'result' => true,
		    			'id'	 => $data->getData('id_customer_cart_abandonedj')
		    			); 	
    	}else{
    		$data = array('result' => false);
    	}		
    	
    	return $data;
    }
    
    
	/**
	 * Métodos SET & GET
	*/
	
	public function __get($propriedade){
		return $this->$propriedade;
	}
	
	public function __set($propriedade, $valor){
		$this->$propriedade = $valor;
	}

	
}