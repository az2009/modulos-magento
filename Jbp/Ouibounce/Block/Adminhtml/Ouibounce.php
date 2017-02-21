<?php
class Jbp_Ouibounce_Block_Adminhtml_Ouibounce extends Mage_Adminhtml_Block_Template {

    public function getByPreco(){
        $collection = Mage::getModel('jbp_ouibounce/ouibounce')
                            ->getCollection()
                            ->addFieldToSelect('preco_caro_ouibounce')
                            ->addFieldToFilter('preco_caro_ouibounce', array('gt' => 0));

        return $collection->getSize();
    }

    public function getByDificuldade(){
        $collection = Mage::getModel('jbp_ouibounce/ouibounce')
        ->getCollection()
        ->addFieldToSelect('encontrou_problema_ouibounce')
        ->addFieldToFilter('encontrou_problema_ouibounce', array('gt' => 0));

        return $collection->getSize();
    }

    public function getByFrete(){
        $collection = Mage::getModel('jbp_ouibounce/ouibounce')
        ->getCollection()
        ->addFieldToSelect('valor_frete_ouibounce')
        ->addFieldToFilter('valor_frete_ouibounce', array('gt' => 0));

        return $collection->getSize();
    }
}