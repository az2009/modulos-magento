<?php 

$installer = $this;
$installer->startSetup();
$installer->run("
    
ALTER TABLE `".$this->getTable('sales/order')."` ADD `creditpoint_amount` DECIMAL (10,2) NOT NULL;
ALTER TABLE `".$this->getTable('sales/order')."` ADD `base_creditpoint_amount` DECIMAL (10,2) NOT NULL;

ALTER TABLE `".$this->getTable('sales/quote_address')."` ADD `creditpoint_amount` DECIMAL (10,2) NOT NULL;
ALTER TABLE `".$this->getTable('sales/quote_address')."` ADD `base_creditpoint_amount` DECIMAL (10,2) NOT NULL;

ALTER TABLE `".$this->getTable('sales/order')."` ADD `creditpoint_amount_invoiced` DECIMAL (10,2) NOT NULL;
ALTER TABLE `".$this->getTable('sales/order')."` ADD `base_creditpoint_amount_invoiced` DECIMAL (10,2) NOT NULL;
    
ALTER TABLE `".$this->getTable('sales/invoice')."` ADD `creditpoint_amount` DECIMAL (10,2) NOT NULL;
ALTER TABLE `".$this->getTable('sales/invoice')."` ADD `base_creditpoint_amount` DECIMAL (10,2) NOT NULL;
    
ALTER TABLE `".$this->getTable('sales/order')."` ADD `creditpoint_amount_refunded` DECIMAL (10,2) NOT NULL;
ALTER TABLE `".$this->getTable('sales/order')."` ADD `base_creditpoint_amount_refunded` DECIMAL (10,2) NOT NULL;
    
ALTER TABLE `".$this->getTable('sales/creditmemo')."` ADD `creditpoint_amount` DECIMAL (10,2) NOT NULL;
ALTER TABLE `".$this->getTable('sales/creditmemo')."` ADD `base_creditpoint_amount` DECIMAL (10,2) NOT NULL;
    
");	

$installer->endSetup();


?>