<?php
class Jbp_Api_Model_Api2_Customer_Rest_Guest_V1 extends Mage_Api2_Model_Resource{
    
    /**
     * retorna um vetor
     * {@inheritDoc}
     * @see Mage_Api2_Model_Resource::_retrieve()
     */
    public function _retrieve()
    {
        $param = $this->getRequest()->getParam('id');        
        $product = Mage::getModel('customer/customer')->load($param);
        
        //lançando um erro fatal
            //$this->_critical('pau');
        
        return $product->getData();        
    }
    
    /**
     * retorna uma matriz
     * {@inheritDoc}
     * @see Mage_Api2_Model_Resource::_retrieveCollection()
     */
    public function _retrieveCollection()
    {
        $result = array();        
        $products = Mage::getResourceModel('customer/customer_collection')
                        ->addAttributeToSelect('*');        
        foreach($products as $k){
            array_push($result, $k->getData());
        }                       
        return $result;
    }
    
    public function _update($data){}
    
    public function _create($data){}
    
    public function _delete($data){}
    
}