<?php
    class Ei_Creditpoint_Block_Adminhtml_Manage_Grid_Renderer_Creditprice
        extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

        public function render(Varien_Object $row){
            return $this->_getValue($row);

        }

        protected function _getValue(Varien_Object $row){

            $currentCurrency = Mage::helper('creditpoint')->getCurrentCurrencySymbol();

            $currentPointAmount = $currentCurrency.' '.number_format(Mage::helper('creditpoint')->getPointCurrencyAmount($row->getData('credit_rest')), 2, '.', '');

            return $currentPointAmount;
        }

    }

?>