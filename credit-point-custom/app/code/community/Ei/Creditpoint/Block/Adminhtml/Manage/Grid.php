<?php

    class Ei_Creditpoint_Block_Adminhtml_Manage_Grid extends Mage_Adminhtml_Block_Widget_Grid {

        public function __construct()
        {
            parent::__construct();
            $this->setId('creditpointGrid');
            $this->setDefaultSort('id');
            $this->setDefaultDir('ASC');
            $this->setSaveParametersInSession(true);
        }

        protected function _prepareCollection()
        {

            $collection = Mage::getModel('creditpoint/creditpoint')
                                ->getCollection()
                                ->addFieldToSelect('*');

            $collection->getSelect()
                 	   ->join('customer_entity' , '(customer_entity.entity_id = main_table.customer_id)', array('*'))
                 	   ->join('customer_entity_varchar' , '(customer_entity_varchar.entity_id  = customer_entity.entity_id)', array('*'))
                       ->join('customer_credit_point_rest' , '(customer_entity_varchar.entity_id  = customer_credit_point_rest.customer_id)', array('*'));

            $collection->getSelect()->group('main_table.customer_id');

            $collection->setOrder('main_table.id','DESC');

            $this->setCollection($collection);
            return parent::_prepareCollection();
        }


        protected function _prepareColumns()
        {
            $this->addColumn('id', array(
                'header'    => Mage::helper('creditpoint')->__('ID'),
                'align'     => 'center',
                'width'     => '50px',
                'index'     => 'id',
                'type'  	  => 'number',
            ));

            $this->addColumn('email', array(
                'header'    => Mage::helper('creditpoint')->__('E-mail'),
                'align'     => 'center',
                'width'     => '50px',
                'index'     => 'email',
                'type'  	=> 'text',
            ));

            $this->addColumn('credit_rest', array(
                'header'    => Mage::helper('creditpoint')->__('Credit Rest Points'),
                'align'     => 'center',
                'width'     => '50px',
                'index'     => 'credit_rest',
                'type'  	=> 'text',
            ));

            $this->addColumn('credit_rest_price', array(
                'header'    => Mage::helper('creditpoint')->__('Credit Rest Price'),
                'align'     => 'center',
                'width'     => '50px',
                'index'     => 'credit_rest_price',
                'type'  	=> 'text',
                'filter'    => false,
                'renderer'  => 'Ei_Creditpoint_Block_Adminhtml_Manage_Grid_Renderer_Creditprice'
            ));

 			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));

 			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

 			return parent::_prepareColumns();
        }

        public function getRowUrl($row)        {
            return $this->getUrl('adminhtml/customer/edit', array('id'=>$row->getCustomerId(), 'active_tab'=>'customer_edit_tab_creditpointhistory'));
        }

    }

?>