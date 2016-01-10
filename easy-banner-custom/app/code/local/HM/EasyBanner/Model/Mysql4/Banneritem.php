<?php

class HM_EasyBanner_Model_Mysql4_Banneritem extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the easybanner_id refers to the key field in your database table.
        $this->_init('easybanner/banneritem', 'banner_item_id');
    }
}