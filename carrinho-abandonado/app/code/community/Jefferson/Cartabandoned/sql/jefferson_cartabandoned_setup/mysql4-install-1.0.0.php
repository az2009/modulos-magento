<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    DROP TABLE IF EXISTS {$installer->getTable('cartabandoned/cartabandoned')};
    CREATE TABLE {$installer->getTable('cartabandoned/cartabandoned')}
    (
            id_cart_abandonedj INT AUTO_INCREMENT NOT NULL,
            id_customer_cart_abandonedj INT NOT NULL,
            key_cart_abandonedj VARCHAR(500) NOT NULL,
            PRIMARY KEY (id_cart_abandonedj)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    DROP TABLE IF EXISTS {$installer->getTable('cartabandoned/filaenvio')};
    CREATE TABLE {$installer->getTable('cartabandoned/filaenvio')}
    (
            id_fila_envio INT NOT NULL AUTO_INCREMENT,
            data_envio_fila_envio DATETIME NOT NULL,
            qty_cart INT NOT NULL,
            status CHAR(1) NOT NULL DEFAULT 1,
            end_envio DATETIME NOT NULL,
            PRIMARY KEY (id_fila_envio)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    DROP TABLE IF EXISTS {$installer->getTable('cartabandoned/itemenvio')};
    CREATE TABLE {$installer->getTable('cartabandoned/itemenvio')}
    (
        id_item_envio INT NOT NULL AUTO_INCREMENT,
        id_fila_envio_item_envio INT NOT NULL,
        id_customer INT NOT NULL,
        email_customer VARCHAR(500) NOT NULL,
        data_envio_item_envio DATETIME NOT NULL,
        click VARCHAR(10) NOT NULL DEFAULT 'Não',
        open VARCHAR(10) NOT NULL DEFAULT 'Não',
        PRIMARY KEY (id_item_envio)

    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();