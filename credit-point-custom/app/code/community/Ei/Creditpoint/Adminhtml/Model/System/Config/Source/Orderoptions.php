<?php


/**
 * Order options
 *
 */
class Ei_Creditpoint_Adminhtml_Model_System_Config_Source_Orderoptions
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            //array('value' => '', 'label'=>Mage::helper('adminhtml')->__('Please Select')),
            array('value' => 'processing', 'label'=>Mage::helper('adminhtml')->__('Processing')),
            array('value' => 'complete', 'label'=>Mage::helper('adminhtml')->__('Complete')),
            array('value' => 'closed', 'label'=>Mage::helper('adminhtml')->__('Closed')),
        );
    }

}