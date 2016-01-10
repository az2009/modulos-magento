<?php

    /*
     * @category   Mage
     * @package    Inic_Creditpayment
     */

    $installer = $this;
    $installer->startSetup();

    $installer->addAttribute('customer', 'credit_point', array(
        'label'         => 'Credit Point',
        'visible'       => 1,
        'type'          => 'decimal',
        'required'      => 0,
        'position'      => 2,
        'sort_order'    => 200
    ));


    $installer->run("
      -- DROP TABLE IF EXISTS {$this->getTable('customer_credit_point')};

      CREATE TABLE `{$this->getTable('customer_credit_point')}` (
      `id` INT(10) unsigned NOT NULL auto_increment,
      `customer_id` INT(10) NOT NULL,
      `order_id` INT(10) NOT NULL,
      `applied_credit_point` DECIMAL(12,2) NOT NULL,
      `applied_credit_point_price` DECIMAL(12,2) NOT NULL,
      `earned_credit_point` DECIMAL(12,2) NOT NULL,
      `order_refund` INT(10) NOT NULL,
      `created_time` timestamp NULL,
      `info_comments` VARCHAR(1000),
       PRIMARY KEY  (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");


    $customerattrubute = Mage::getModel('customer/attribute')->loadByCode('customer', 'credit_point');
    $forms=array('adminhtml_customer'); // //to make the attribute can be created in backend only
    $customerattrubute->setData('used_in_forms', $forms);
    $customerattrubute->save();

    $installer->endSetup();