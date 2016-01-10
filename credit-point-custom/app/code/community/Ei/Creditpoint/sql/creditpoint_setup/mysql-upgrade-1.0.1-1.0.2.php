<?php

$installer = $this;
$installer->startSetup();
$installer->run("
    CREATE VIEW TESTE AS SELECT  `customer_id` , SUM(  `earned_credit_point` ) - SUM(  `applied_credit_point` ) AS  `credit_rest`
    FROM  `customer_credit_point`
    WHERE  `order_refund` =1
    AND  `order_id` = -999
    OR  `order_refund` =0
    GROUP BY  `customer_id`
    ");
$installer->endSetup();


?>