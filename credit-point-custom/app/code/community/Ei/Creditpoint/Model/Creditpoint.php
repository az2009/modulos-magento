<?php

class Ei_Creditpoint_Model_Creditpoint extends Mage_Core_Model_Abstract
{
    public function _construct(){
         parent::_construct();
         $this->_init('creditpoint/creditpoint');
    }

    public function cancelledItem($args = Array()){

        try{

            $customerCreditPoints = Mage::getSingleton('customer/customer')->load($args['customer_id'])->getCreditPoint();

            $revisedCreditPoints = (int)$customerCreditPoints - $args['earned_credit_point'];

            $creditModel = Mage::getSingleton('creditpoint/creditpoint')
                                ->setCustomerId($args['customer_id'])
                                ->setOrderId(-999)
                                ->setOrderRefund(1)
                                ->setAppliedCreditPoint($args['earned_credit_point'])
                                ->setCreatedTime(now())
                                ->setInfoComments($args['info_comments'])
                                ->save();

            $customerData = Mage::getSingleton('customer/customer')->load($args['customer_id'])->setCreditPoint($revisedCreditPoints)->save();
            return true;
        }catch(Exception $e){
            Mage::log($e->getMessage());
            Mage::getSingleton('adminhtml/session')->addError($this->__('Fail apply point, check the log'));
            return false;
        }

    }

    public function addCreditItem($args = Array()){

        try{

            $customerCreditPoints = Mage::getSingleton('customer/customer')->load($args['customer_id'])->getCreditPoint();

            $revisedCreditPoints = (int)$customerCreditPoints + $args['earned_credit_point'];

            $creditModel = Mage::getSingleton('creditpoint/creditpoint')
            ->setCustomerId($args['customer_id'])
            ->setOrderId(-999)
            ->setOrderRefund(0)
            ->setEarnedCreditPoint($args['earned_credit_point'])
            ->setCreatedTime(now())
            ->setInfoComments($args['info_comments'])
            ->save();

            $customerData = Mage::getSingleton('customer/customer')->load($args['customer_id'])->setCreditPoint($revisedCreditPoints)->save();
            return true;
        }catch(Exception $e){
            Mage::log($e->getMessage());
            Mage::getSingleton('adminhtml/session')->addError($this->__('Fail apply point, check the log'));
            return false;
        }

    }
}
