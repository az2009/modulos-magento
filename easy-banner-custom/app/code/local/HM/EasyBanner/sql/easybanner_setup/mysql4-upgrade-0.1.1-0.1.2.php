<?php
$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('easy_banner_item')} ADD `banner_order` int(11) default 0;
ALTER TABLE {$this->getTable('easy_banner')} ADD `auto_play` smallint(6) NOT NULL default 2;
");
$installer->endSetup();
?>