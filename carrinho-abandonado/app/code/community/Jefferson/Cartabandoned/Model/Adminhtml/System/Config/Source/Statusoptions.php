<?php
	class Jefferson_Cartabandoned_Model_Adminhtml_System_Config_Source_Statusoptions
	    extends Mage_Adminhtml_Model_System_Config_Source_Category {
		
		protected function _construct(){
	        $this->_init('cartabandoned/adminhtml_system_config_source_statusoptions');
	    } 
	    
	    public function toOptionArray($addEmpty = true)
	    {
	    	$options = array();
	    	
	        $options = array(
	        		'01 Mês' => '01 Mês',
	        		'01 Semana' => '01 Semana',
	        		'15 Quinzenal' => '15 Quinzenal'
	        );
			
	        return $options;
	    }
		
	}
?>