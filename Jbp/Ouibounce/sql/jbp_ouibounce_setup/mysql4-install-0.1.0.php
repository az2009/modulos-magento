<?php
$installer = $this;
$installer->startSetup();
$installer->run("
    DROP TABLE IF EXISTS {$installer->getTable('jbp_ouibounce/ouibounce')};
    CREATE TABLE {$installer->getTable('jbp_ouibounce/ouibounce')}
    (
            id_ouibounce INT AUTO_INCREMENT NOT NULL,
            preco_caro_ouibounce INT(11) NOT NULL DEFAULT 0,
            encontrou_problema_ouibounce INT(11) NOT NULL DEFAULT 0,
            valor_frete_ouibounce INT(11) NOT NULL DEFAULT 0,
            PRIMARY KEY(id_ouibounce)

    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
$installer->endSetup();