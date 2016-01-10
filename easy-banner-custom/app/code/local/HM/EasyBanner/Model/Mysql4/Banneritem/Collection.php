<?php

class HM_EasyBanner_Model_Mysql4_Banneritem_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('easybanner/banneritem');
    }
}