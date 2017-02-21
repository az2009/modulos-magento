<?php
class Jbp_Ouibounce_Model_Ouibounce extends Mage_Core_Model_Abstract {

    protected function _construct(){
        parent::_construct();
        $this->_init('jbp_ouibounce/ouibounce');
    }


    public function registerData($data){

        try{

            if($data['motivo'] == 'valor_frete'){
                $this->setData('valor_frete_ouibounce', 1);
            }

            if($data['motivo'] == 'preco_caro'){
                $this->setData('preco_caro_ouibounce', 1);
            }

            if($data['motivo'] == 'encontrou_problema'){
                $this->setData('encontrou_problema_ouibounce', 1);
                $this->setSendEmail($data);

            }

            $this->save();

            return true;

        }catch(Mage_Core_Exception $e){
            Mage::log($e->getMessage(), null, 'system.log', true);
            return false;
        }

    }

    public function setSendEmail($data){
        if(!empty($data['problema']) && !empty($data['email_customer'])){

            Mage::helper('jbp_ouibounce')->sendTemp($data);

        }
    }

}