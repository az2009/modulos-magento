<?php
class Jbp_Ouibounce_Block_Ouibounce extends Mage_Core_Block_Template {

    public function getCupom(){
        return $this->_helper()->getCupom();
    }

    public function getQtyDiscount(){
        return $this->_helper()->getQtyDiscount();
    }

    public function _helper(){
        return Mage::helper('jbp_ouibounce');
    }

}