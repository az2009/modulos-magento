<?php
	class Jefferson_Cartabandoned_Block_Adminhtml_Abandoned extends Mage_Adminhtml_Block_Widget_Grid_Container
	{
		
	  public function __construct(){
	  	
	  	//Nome do controller
		    $this->_controller = 'adminhtml_abandoned';
		    
		//Nome do módulo    
		    $this->_blockGroup = 'cartabandoned';
		
		//Label do cabeçalho da página    
		    $this->_headerText = Mage::helper('cartabandoned')->__('List customers cart abandoned');
		
		//Herdando o construtor     
		    parent::__construct();

		//Adicionando um button de atalho para os relatórios    
            $this->addButton('relatorio', array(
                'label'     => Mage::helper('cartabandoned')->__('Repor'),
                'onclick'   => "setLocation('".$this->getUrl("*/adminhtml_abandonedreport/")."')",
                'class'     => 'rebuild',
            ));
            
		    $this->_removeButton('save');
	        $this->_removeButton('add');
	        $this->_removeButton('reset');
	        $this->_removeButton('delete');
	  }
	  
	  
	}