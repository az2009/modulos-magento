<?php

/**
 * @category    Jefferson
 * @package     Jefferson_Clickiew
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

class Jefferson_Clickview_Model_System_Config_Source_Mode extends Mage_Adminhtml_Model_System_Config_Source_Category
{	
	
	protected function _construct()
    {
        $this->_init('clickview/system_config_source_mode');
    } 
	
	
    public function toOptionArray($addEmpty = true)
    {
    	$options = array(
    		'horizontal' => 'Horizontal', 
    		'fade' => 'Fade'
    		);
    	return $options;
    }
}


?>