<?php

/**
 * 
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * @category    Jefferson
 * @package     Jefferson_Promocaotabs
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
	
	
	$installer = Mage::getResourceModel('catalog/setup', 'core_setup');
	
	$installer->startSetup();
	
	$installer->addAttribute('catalog_product', 'set_promotion', array(
	  'type'              => 'int',
	  'backend'           => '',
	  'frontend'          => '',
	  'label'             => 'Colocar na promoção',
	  'input'             => 'boolean',
	  'note'     		  => "select yes no",
	  'class'             => '',
	  'source'            => '',
	  'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	  'visible'           => true,
	  'required'          => false,
	  'user_defined'      => false,
	  'default'           => '',
	  'searchable'        => false,
	  'filterable'        => false,
	  'comparable'        => false,
	  'visible_on_front'  => false,
	  'unique'            => false,
	  'group'             => 'General',
	));
	
	
	$installer->addAttribute(Mage_Catalog_Model_Category::ENTITY, 'title_custom_tabs', array(
	    'group'         => 'General',
	    'input'         => 'text',
	    'type'          => 'text',
	    'label'         => 'Título personalizado para a categoria na tabs',
	    'backend'       => '',
	    'visible'       => true,
	    'required'      => false,
	    'visible_on_front' => true,
	    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	));
	
	$installer->endSetup(); 

?>