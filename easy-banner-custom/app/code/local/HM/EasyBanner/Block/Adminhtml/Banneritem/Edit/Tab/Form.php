<?php

class HM_EasyBanner_Block_Adminhtml_Banneritem_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('easybanneritem_form', array('legend'=>Mage::helper('easybanner')->__('Banner Item information')));
     
	  $banners = array(''=>'-- Select Banner --');
	  $collection = Mage::getModel('easybanner/banner')->getCollection();
	  foreach ($collection as $banner) {
		 $banners[$banner->getId()] = $banner->getTitle();
	  }

// 	  $fieldset->addField('contact_us', 'label', array(
// 	  		'name'      => 'contact_us',
// 	  		'disabled'  => true,
// 	  		'after_element_html' => '<div style="width: 700px; float:left;margin-left: -205px;"><span>Want more attractive sliders? Check out
// <strong>
// <a target="_blank" href="http://www.mage-world.com/easy-banner-magento-banner-extension.html">Easy Banner</a>
// </strong>
//  with 7 supported sliders and
// <strong>
// <a target="_blank" href="http://www.mage-world.com/easy-banner-pro-slider-magento-banner-extension.html">Easy Banner Pro</a>
// </strong>
// with 13 supported sliders.</span></div><br/>',
// 	  ));
	  
	  $fieldset->addField('banner_id', 'select', array(
          'label'     => Mage::helper('easybanner')->__('Banner'),
          'name'      => 'banner_id',
          'required'  => true,
          'values'    => $banners,
      ));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('easybanner')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      
	  $fieldset->addField('banner_order', 'text', array(
          'label'     => Mage::helper('easybanner')->__('Posição do banner'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'banner_order',
      ));
      
      $fieldset->addField('image', 'image', array(
          'label'     => Mage::helper('easybanner')->__('Imagem do banner'),
          'required'  => false,
          'name'      => 'image',
	  ));

   //   $fieldset->addField('image_url', 'text', array(
   //       'label'     => Mage::helper('easybanner')->__('Image Url'),
   //       'required'  => false,
   //       'name'      => 'image_url',
	  //));

   //   $fieldset->addField('thumb_image', 'image', array(
   //       'label'     => Mage::helper('easybanner')->__('Thumnail Image'),
   //       'required'  => false,
   //       'name'      => 'thumb_image',
	  //));

   //   $fieldset->addField('thumb_image_url', 'text', array(
   //       'label'     => Mage::helper('easybanner')->__('Thumnail Url'),
   //       'required'  => false,
   //       'name'      => 'thumb_image_url',
	  //));
		
      $fieldset->addField('link_url', 'text', array(
          'label'     => Mage::helper('easybanner')->__('Link Url'),
          'required'  => false,
          'name'      => 'link_url',
	  ));
		
	  $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('easybanner')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('easybanner')->__('Habilitado'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('easybanner')->__('Desabilitado'),
              ),
          ),
      ));
      $outputFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);	
      $fieldset->addField('item_active_from', 'date', array(
          'label'     => Mage::helper('easybanner')->__('De'),
          'required'  => false,
          'name'      => 'item_active_from',
		'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
		'format' => $outputFormat,
		'time' => true, 
      ));
	 $fieldset->addField('item_active_to', 'date', array(
          'label'     => Mage::helper('easybanner')->__('Para'),
          'required'  => false,
          'name'      => 'item_active_to',
		'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
		'format' => $outputFormat,
		'time' => true, 
      )); 

      //$fieldset->addField('content', 'editor', array(
      //    'name'      => 'content',
      //    'label'     => Mage::helper('easybanner')->__('Content'),
      //    'title'     => Mage::helper('easybanner')->__('Content'),
      //    'style'     => 'width:600px; height:300px;',
      //    'wysiwyg'   => false,
      //    'required'  => false,
      //));
          
     
      if ( Mage::getSingleton('adminhtml/session')->getEasyBannerItemData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEasyBannerItemData());
          Mage::getSingleton('adminhtml/session')->setEasyBannerItemData(null);
      } elseif ( Mage::registry('easybanneritem_data') ) {
          $form->setValues(Mage::registry('easybanneritem_data')->getData());
      }
      return parent::_prepareForm();
  }
}