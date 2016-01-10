<?php

class HM_EasyBanner_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('easybanner_form', array('legend'=>Mage::helper('easybanner')->__('Banner information')));
     
      $fieldset->addField('contact_us', 'label', array(
      		'name'      => 'contact_us',
      		'disabled'  => true,
      		'after_element_html' => '<div style="width: 700px; float:left;margin-left: -205px;"><span>Want more attractive sliders? Check out
<strong>
<a target="_blank" href="http://www.mage-world.com/easy-banner-magento-banner-extension.html">Easy Banner</a>
</strong>
 with 7 supported sliders and
<strong>
<a target="_blank" href="http://www.mage-world.com/easy-banner-pro-slider-magento-banner-extension.html">Easy Banner Pro</a>
</strong>
with 13 supported sliders.</span></div>',
      ));
      
      $fieldset->addField('identifier', 'text', array(
          'label'     => Mage::helper('easybanner')->__('Identifier'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'identifier',
      ));

	  $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('easybanner')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

	  $fieldset->addField('show_title', 'select', array(
          'label'     => Mage::helper('easybanner')->__('Show Title'),
          'name'      => 'show_title',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('easybanner')->__('Yes'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('easybanner')->__('No'),
              ),
          ),
      ));
		
      $fieldset->addField('width', 'text', array(
          'label'     => Mage::helper('easybanner')->__('Width (px)'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'width',
      ));

      $fieldset->addField('height', 'text', array(
          'label'     => Mage::helper('easybanner')->__('Height (px)'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'height',
      ));
	
      $fieldset->addField('delay', 'text', array(
          'label'     => Mage::helper('easybanner')->__('Delay (ms)'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'delay',
      ));

	$outputFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);	
      $fieldset->addField('active_from', 'date', array(
          'label'     => Mage::helper('easybanner')->__('Active From'),
          'required'  => false,
          'name'      => 'active_from',
		'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
		'format' => $outputFormat,
		'time' => true, 
      ));
	 $fieldset->addField('active_to', 'date', array(
          'label'     => Mage::helper('easybanner')->__('Active To'),
          'required'  => false,
          'name'      => 'active_to',
		'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
		'format' => $outputFormat,
		'time' => true, 
      ));

	 $fieldset->addField('auto_play', 'select', array(
          'label'     => Mage::helper('easybanner')->__('Auto Play(Only for picachoose temp)'),
          'name'      => 'auto_play',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('easybanner')->__('Yes'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('easybanner')->__('No'),
              ),
          ),
      ));
		
	  $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('easybanner')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('easybanner')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('easybanner')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('easybanner')->__('Content'),
          'title'     => Mage::helper('easybanner')->__('Content'),
          'style'     => 'width:600px; height:300px;',
          'wysiwyg'   => false,
          'required'  => false,
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getEasyBannerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEasyBannerData());
          Mage::getSingleton('adminhtml/session')->setEasyBannerData(null);
      } elseif ( Mage::registry('easybanner_data') ) {
          $form->setValues(Mage::registry('easybanner_data')->getData());
      }
      return parent::_prepareForm();
  }
}