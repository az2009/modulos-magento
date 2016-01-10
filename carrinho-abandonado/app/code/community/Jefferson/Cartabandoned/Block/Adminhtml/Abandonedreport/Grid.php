<?php
	class Jefferson_Cartabandoned_Block_Adminhtml_Abandonedreport_Grid extends Mage_Adminhtml_Block_Widget_Grid{
		
		/**
		 * Inicia o grid
		 * @param id do Grid
		 * @param primary key da tabela
		 * @param ordem
		*/
		public function __construct(){
	      parent::__construct();
	      $this->setId('CartAbandonedreportGrid');
	      $this->setDefaultSort('id_fila_envio');
	      $this->setDefaultDir('DESC');
	      $this->setSaveParametersInSession(true);	      
	    }

        /**
         * Collection dos dados
         * Apenas chamar a collection do módulo
        */
        
        protected function _prepareCollection(){
            
           $collection = Mage::getModel('cartabandoned/filaenvio')
                            ->getCollection()
                            ->addFieldToSelect('*');
                            
                            
           $this->setCollection($collection);
           return parent::_prepareCollection();
           
        }
	    
	    protected function _prepareColumns(){
	        
	    	$this->addColumn('id_fila_envio', array(
	    			'header'    => Mage::helper('cartabandoned')->__('ID'),
	    			'align'     => 'center',
	    			'width'     => '50px',
	    			'index'     => 'id_fila_envio',
	    			'type'  	=> 'number',
	    	));
            
            $this->addColumn('data_envio_fila_envio', array(
                    'header'    => Mage::helper('cartabandoned')->__('Date'),
                    'align'     => 'center',
                    'width'     => '50px',
                    'index'     => 'data_envio_fila_envio',
                    'type'      => 'datetime',
            ));
            
            
            $this->addColumn('status', array(
                'header'    => Mage::helper('cartabandoned')->__('Status'),
                'align'     => 'center',
                'width'     => '50px',
                'index'     => 'status',
                'type'      => 'options',
                'filter'    => false,
                'renderer'  =>  'Jefferson_Cartabandoned_Block_Adminhtml_Abandonedreport_Grid_Renderer_Option',                
            ));
            
            $this->addColumn('action', array(
                'header'    =>  Mage::helper('cartabandoned')->__('Show'),
                'align'     => 'center',
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
                'renderer'  =>  'Jefferson_Cartabandoned_Block_Adminhtml_Abandonedreport_Grid_Renderer_Action'
            ));
            
	    	return parent::_prepareColumns();	    	
	    }
	    
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	