<?php 
    class Jefferson_Cartabandoned_Block_Adminhtml_Abandonedreport_Grid_Renderer_Option 
        extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
        
        
        
        public function render(Varien_Object $row){
			 return $this->_getValue($row);			
		}
    		
    	protected function _getValue(Varien_Object $row){
    		
    		$collection = Mage::getModel('cartabandoned/filaenvio')
    		      ->load($row->getData('id_fila_envio'));
    		      
        		
    		if($collection->getData('status') == '1'){
    		    
    		    return Mage::helper('cartabandoned')->__("Executando");
    		    
    		}else if($collection->getData('status') == '2'){
    		    
    		    return Mage::helper('cartabandoned')->__("Finalizado");
    		    
    		}
    		
    	}
        
        
        
        
        
    }
