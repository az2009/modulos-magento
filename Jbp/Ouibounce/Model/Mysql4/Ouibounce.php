<?php
class Jbp_Ouibounce_Model_Mysql4_Ouibounce extends Mage_Core_Model_Mysql4_Abstract{

    protected function _construct(){
        $this->_init('jbp_ouibounce/ouibounce', 'id_ouibounce');
    }

}