<?php
    class Ei_Creditpoint_Block_Adminhtml_Manage extends Mage_Adminhtml_Block_Widget_Grid_Container {

        public function __construct(){

            //Nome do controller
            $this->_controller = 'adminhtml_manage';

            //Nome do módulo
            $this->_blockGroup = 'creditpoint';

            //Label do cabeçalho da página
            $this->_headerText = Mage::helper('creditpoint')->__('Manage Reward Point');

            //Herdando o construtor
            parent::__construct();

            $this->_removeButton('save');
            $this->_removeButton('add');
            $this->_removeButton('reset');
            $this->_removeButton('delete');
        }

    }

?>