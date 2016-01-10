<?php

class HM_EasyBanner_Block_Adminhtml_Banneritem_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('easybanneritem_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('easybanner')->__('Banner Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('easybanner')->__('Item Information'),
          'title'     => Mage::helper('easybanner')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('easybanner/adminhtml_banneritem_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}