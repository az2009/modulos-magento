<?php

class HM_EasyBanner_Block_Adminhtml_Banneritem_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'easybanner';
        $this->_controller = 'adminhtml_banneritem';
        
        $this->_updateButton('save', 'label', Mage::helper('easybanner')->__('Save Banner Item'));
        $this->_updateButton('delete', 'label', Mage::helper('easybanner')->__('Delete Banner Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('easybanner_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'easybanner_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'easybanner_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('easybanneritem_data') && Mage::registry('easybanneritem_data')->getId() ) {
            return Mage::helper('easybanner')->__("Edit Banner Item '%s'", $this->htmlEscape(Mage::registry('easybanneritem_data')->getTitle()));
        } else {
            return Mage::helper('easybanner')->__('Add Banner Item');
        }
    }
}