
CREATE TABLE IF NOT EXISTS `cart_abandonedj` (
  `id_cart_abandonedj` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer_cart_abandonedj` varchar(500) NOT NULL,
  `key_cart_abandonedj` varchar(500) NOT NULL,
  PRIMARY KEY (`id_cart_abandonedj`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;


CREATE TABLE IF NOT EXISTS `cart_abandonedj_fila_envio` (
  `id_fila_envio` int(11) NOT NULL AUTO_INCREMENT,
  `data_envio_fila_envio` datetime NOT NULL,
  `qty_cart` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `end_envio` datetime NOT NULL,
  PRIMARY KEY (`id_fila_envio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;



CREATE TABLE IF NOT EXISTS `cart_abandonedj_item_envio` (
  `id_item_envio` int(11) NOT NULL AUTO_INCREMENT,
  `id_fila_envio_item_envio` varchar(500) NOT NULL,
  `id_customer` varchar(500) NOT NULL,
  `email_customer` varchar(500) NOT NULL,
  `data_envio_item_envio` datetime NOT NULL,
  `click` varchar(10) NOT NULL DEFAULT 'Não',
  `open` varchar(10) NOT NULL DEFAULT 'Não',
  PRIMARY KEY (`id_item_envio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;



CREATE TABLE IF NOT EXISTS `customer_credit_point` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `applied_credit_point` decimal(12,2) NOT NULL,
  `applied_credit_point_price` decimal(12,2) NOT NULL,
  `earned_credit_point` decimal(12,2) NOT NULL,
  `order_refund` int(10) NOT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `info_comments` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;


CREATE TABLE IF NOT EXISTS `customer_credit_point_rest` (
`customer_id` int(10)
,`credit_rest` decimal(35,2)
);


CREATE TABLE IF NOT EXISTS `easy_banner` (
  `banner_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `show_title` smallint(6) NOT NULL DEFAULT '0',
  `content` text,
  `width` int(11) unsigned DEFAULT NULL,
  `height` int(11) unsigned DEFAULT NULL,
  `delay` int(11) unsigned DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `active_from` datetime DEFAULT NULL,
  `active_to` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `auto_play` smallint(6) NOT NULL DEFAULT '2',
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



CREATE TABLE IF NOT EXISTS `easy_banner_item` (
  `banner_item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `image_url` varchar(512) NOT NULL DEFAULT '',
  `thumb_image` varchar(255) NOT NULL DEFAULT '',
  `thumb_image_url` varchar(512) NOT NULL DEFAULT '',
  `content` text,
  `link_url` varchar(512) NOT NULL DEFAULT '#',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `item_active_from` datetime DEFAULT NULL,
  `item_active_to` datetime DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `banner_order` int(11) DEFAULT '0',
  PRIMARY KEY (`banner_item_id`),
  KEY `FK_EASY_BANNER_ITEM` (`banner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


DROP TABLE IF EXISTS `customer_credit_point_rest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`uniusdesenvolvim`@`localhost` SQL SECURITY DEFINER VIEW `customer_credit_point_rest` AS select `customer_credit_point`.`customer_id` AS `customer_id`,(sum(`customer_credit_point`.`earned_credit_point`) - sum(`customer_credit_point`.`applied_credit_point`)) AS `credit_rest` from `customer_credit_point` where (((`customer_credit_point`.`order_refund` = 1) and (`customer_credit_point`.`order_id` = -(999))) or (`customer_credit_point`.`order_refund` = 0)) group by `customer_credit_point`.`customer_id`;

ALTER TABLE `easy_banner_item`
  ADD CONSTRAINT `FK_EASY_BANNER_ITEM` FOREIGN KEY (`banner_id`) REFERENCES `easy_banner` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE;
