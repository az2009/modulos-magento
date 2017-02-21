<?php
class Jbp_Ouibounce_Model_Mysql4_Ouibounce_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('jbp_ouibounce/ouibounce');
    }
}