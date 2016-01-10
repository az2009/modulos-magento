<?php
	class Jefferson_Cartabandoned_Block_Adminhtml_Abandoned_Grid extends Mage_Adminhtml_Block_Report_Shopcart_Abandoned_Grid{
		
		/**
		 * Inicia o grid
		 * @param id do Grid
		 * @param primary key da tabela
		 * @param ordem
		*/
		public function __construct(){
	      parent::__construct();
	      $this->setId('CartAbandonedGrid');
	      $this->setDefaultDir('ASC');
	      $this->setSaveParametersInSession(true);	      
	    }
	    
	    protected function _prepareColumns(){
	    	$this->addColumn('entity_id', array(
	    			'header'    => Mage::helper('cartabandoned')->__('ID'),
	    			'align'     => 'center',
	    			'width'     => '50px',
	    			'index'     => 'entity_id',
	    			'type'  	=> 'number',
	    	));
	    	return parent::_prepareColumns();	    	
	    }
	    
	    protected function _prepareMassaction(){
	    	$this->setMassactionIdField('id');
	    	$this->getMassactionBlock()->setFormFieldName('cartabandoned');
	    	$this->getMassactionBlock()->addItem('Enviar', array(
	    			'label'    => Mage::helper('cartabandoned')->__('Send'),
	    			'url'      => $this->getUrl('*/*/massEnviar'),
	    			'confirm'  => Mage::helper('cartabandoned')->__('Are you sure?')
	    	));
	    	 
	    }
	    
	    public function getRowUrl($row)        {
            return $this->getUrl('adminhtml/customer/edit', array('id'=>$row->getCustomerId(), 'active_tab'=>'cart'));
        }
  		
	}
?>