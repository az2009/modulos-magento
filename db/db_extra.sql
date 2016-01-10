-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tempo de Geração: 10/01/2016 às 20:51
-- Versão do servidor: 5.5.47-cll
-- Versão do PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `uniusdes_quiteste`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cart_abandonedj`
--

CREATE TABLE IF NOT EXISTS `cart_abandonedj` (
  `id_cart_abandonedj` int(11) NOT NULL AUTO_INCREMENT,
  `id_customer_cart_abandonedj` varchar(500) NOT NULL,
  `key_cart_abandonedj` varchar(500) NOT NULL,
  PRIMARY KEY (`id_cart_abandonedj`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Fazendo dump de dados para tabela `cart_abandonedj`
--

INSERT INTO `cart_abandonedj` (`id_cart_abandonedj`, `id_customer_cart_abandonedj`, `key_cart_abandonedj`) VALUES
(4, '85', 'f0e0113b07a205bccda3d5bdb8736581'),
(5, '59', 'e750aed2bd1f7d99ac2bc9b453789744'),
(6, '73', 'b8ae49abe97b93f63d2f72dae76a3253');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cart_abandonedj_fila_envio`
--

CREATE TABLE IF NOT EXISTS `cart_abandonedj_fila_envio` (
  `id_fila_envio` int(11) NOT NULL AUTO_INCREMENT,
  `data_envio_fila_envio` datetime NOT NULL,
  `qty_cart` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `end_envio` datetime NOT NULL,
  PRIMARY KEY (`id_fila_envio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Fazendo dump de dados para tabela `cart_abandonedj_fila_envio`
--

INSERT INTO `cart_abandonedj_fila_envio` (`id_fila_envio`, `data_envio_fila_envio`, `qty_cart`, `status`, `end_envio`) VALUES
(9, '2015-11-05 04:08:02', '3', '2', '2015-11-05 04:08:06'),
(8, '2015-11-05 04:07:02', '3', '2', '2015-11-05 04:07:07'),
(7, '2015-11-04 18:22:50', '3', '2', '2015-11-04 18:22:52'),
(6, '2015-11-04 16:06:02', '3', '2', '2015-11-04 16:06:07'),
(10, '2015-11-05 04:09:02', '3', '2', '2015-11-05 04:09:06');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cart_abandonedj_item_envio`
--

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

--
-- Fazendo dump de dados para tabela `cart_abandonedj_item_envio`
--

INSERT INTO `cart_abandonedj_item_envio` (`id_item_envio`, `id_fila_envio_item_envio`, `id_customer`, `email_customer`, `data_envio_item_envio`, `click`, `open`) VALUES
(12, '8', '4', 'jefferson.b.porto@gmail.com', '2015-11-05 04:07:03', 'Não', 'Sim'),
(8, '6', '4', 'jefferson.b.porto@gmail.com', '2015-11-04 16:06:03', 'Não', 'Sim'),
(9, '6', '3', 'jefferson.porto@ymail.com', '2015-11-04 16:06:04', 'Não', 'Sim'),
(10, '6', '2', 'jefferson@unius.com.br', '2015-11-04 16:06:06', 'Não', 'Sim'),
(11, '7', '2', 'jefferson@unius.com.br', '2015-11-04 18:22:50', 'Sim', 'Sim'),
(13, '8', '3', 'jefferson.porto@ymail.com', '2015-11-05 04:07:04', 'Não', 'Sim'),
(14, '8', '2', 'jefferson@unius.com.br', '2015-11-05 04:07:06', 'Não', 'Não'),
(15, '9', '4', 'jefferson.b.porto@gmail.com', '2015-11-05 04:08:02', 'Não', 'Sim'),
(16, '9', '3', 'jefferson.porto@ymail.com', '2015-11-05 04:08:03', 'Não', 'Sim'),
(17, '9', '2', 'jefferson@unius.com.br', '2015-11-05 04:08:05', 'Não', 'Não'),
(18, '10', '4', 'jefferson.b.porto@gmail.com', '2015-11-05 04:09:02', 'Não', 'Sim'),
(19, '10', '3', 'jefferson.porto@ymail.com', '2015-11-05 04:09:04', 'Não', 'Sim'),
(20, '10', '2', 'jefferson@unius.com.br', '2015-11-05 04:09:05', 'Não', 'Sim');

-- --------------------------------------------------------

--
-- Estrutura para tabela `customer_credit_point`
--

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

--
-- Fazendo dump de dados para tabela `customer_credit_point`
--

INSERT INTO `customer_credit_point` (`id`, `customer_id`, `order_id`, `applied_credit_point`, `applied_credit_point_price`, `earned_credit_point`, `order_refund`, `created_time`, `info_comments`) VALUES
(2, 59, 492, '0.00', '0.00', '2600.00', 0, '2015-12-21 07:36:07', NULL),
(3, 59, -999, '1.00', '0.00', '0.00', 1, '2015-12-21 07:37:15', 'Admin2'),
(4, 59, 493, '32.00', '3.00', '2300.00', 0, '2015-12-21 07:44:02', NULL),
(5, 59, 494, '97.00', '10.00', '0.00', 0, '2015-12-21 07:46:19', NULL),
(6, 59, -999, '10.00', '0.00', '0.00', 1, '2015-12-21 07:46:51', 'Admin'),
(7, 85, 495, '0.00', '0.00', '2000.00', 1, '2015-12-21 07:51:05', NULL),
(8, 85, -999, '10.00', '0.00', '0.00', 1, '2015-12-21 07:52:29', 'Admin'),
(9, 85, 496, '149.00', '15.00', '400.00', 0, '2015-12-21 07:59:02', NULL),
(10, 59, -999, '4760.00', '0.00', '0.00', 1, '2015-12-21 08:30:34', 'Admin'),
(11, 59, 497, '0.00', '0.00', '2600.00', 0, '2015-12-21 08:31:40', NULL),
(12, 59, -999, '0.00', '0.00', '10.00', 0, '2015-12-21 08:55:18', 'Admin'),
(13, 59, -999, '0.00', '0.00', '90.00', 0, '2015-12-21 08:57:16', 'Admin'),
(14, 59, -999, '5.00', '0.00', '0.00', 1, '2015-12-21 08:59:21', 'Admin'),
(15, 59, 498, '1335.00', '134.00', '1600.00', 0, '2015-12-21 09:05:07', NULL),
(16, 85, -999, '0.00', '0.00', '10.00', 0, '2015-12-21 09:06:48', 'Admin'),
(17, 85, -999, '0.00', '0.00', '5.00', 0, '2015-12-21 09:21:30', 'Admin');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `customer_credit_point_rest`
--
CREATE TABLE IF NOT EXISTS `customer_credit_point_rest` (
`customer_id` int(10)
,`credit_rest` decimal(35,2)
);
-- --------------------------------------------------------

--
-- Estrutura para tabela `easy_banner`
--

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

--
-- Fazendo dump de dados para tabela `easy_banner`
--

INSERT INTO `easy_banner` (`banner_id`, `identifier`, `title`, `show_title`, `content`, `width`, `height`, `delay`, `status`, `active_from`, `active_to`, `created_time`, `update_time`, `auto_play`) VALUES
(1, 'bannerHome', 'Banner Home', 2, NULL, 100, 100, 500, 1, '2015-08-01 13:17:00', '2015-08-30 13:17:00', '2015-08-24 17:02:51', '2015-08-24 17:02:51', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `easy_banner_item`
--

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

--
-- Fazendo dump de dados para tabela `easy_banner_item`
--

INSERT INTO `easy_banner_item` (`banner_item_id`, `banner_id`, `title`, `image`, `image_url`, `thumb_image`, `thumb_image_url`, `content`, `link_url`, `status`, `item_active_from`, `item_active_to`, `created_time`, `update_time`, `banner_order`) VALUES
(1, 1, 'fbdfbd', 'easybanner/19-08_1.jpg', '#', '', '#', NULL, '#', 1, '2015-08-01 14:27:00', '2015-08-31 14:27:00', '2015-08-24 17:45:48', '2015-08-24 17:45:48', 1),
(2, 1, 'ngfngf', 'easybanner/19-08.jpg', '', '', '', NULL, '', 1, '2015-08-24 00:00:00', '2015-08-24 00:00:00', '2015-08-24 17:55:03', '2015-08-24 17:55:03', 2);

-- --------------------------------------------------------

--
-- Estrutura para view `customer_credit_point_rest`
--
DROP TABLE IF EXISTS `customer_credit_point_rest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`uniusdesenvolvim`@`localhost` SQL SECURITY DEFINER VIEW `customer_credit_point_rest` AS select `customer_credit_point`.`customer_id` AS `customer_id`,(sum(`customer_credit_point`.`earned_credit_point`) - sum(`customer_credit_point`.`applied_credit_point`)) AS `credit_rest` from `customer_credit_point` where (((`customer_credit_point`.`order_refund` = 1) and (`customer_credit_point`.`order_id` = -(999))) or (`customer_credit_point`.`order_refund` = 0)) group by `customer_credit_point`.`customer_id`;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `easy_banner_item`
--
ALTER TABLE `easy_banner_item`
  ADD CONSTRAINT `FK_EASY_BANNER_ITEM` FOREIGN KEY (`banner_id`) REFERENCES `easy_banner` (`banner_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
