<?php

class Ei_Creditpoint_Model_Mysql4_Creditpoint_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('creditpoint/creditpoint');
    }

    public function addCustomFilter($customerId) {

        $sortByCustomer = 'customer_id = ?';
        $sortByOrder = 'order_id DESC';
        $filteredResult = $this->getSelect()->where($sortByCustomer, $customerId)->order(new Zend_Db_Expr($sortByOrder));
        return $filteredResult;
    }

}
