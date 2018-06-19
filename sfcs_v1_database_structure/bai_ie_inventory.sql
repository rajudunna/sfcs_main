/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_ie_inventory
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_ie_inventory` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_ie_inventory`;

/*Table structure for table `bai_dep_db` */

DROP TABLE IF EXISTS `bai_dep_db`;

CREATE TABLE `bai_dep_db` (
  `bai_dep_id` int(11) NOT NULL AUTO_INCREMENT,
  `bai_dep_name` varchar(100) NOT NULL,
  `bai_dep_des` varchar(100) NOT NULL,
  `bai_remarks` varchar(200) NOT NULL,
  `bai_dep_stat` varchar(20) NOT NULL,
  PRIMARY KEY (`bai_dep_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_store_items` */

DROP TABLE IF EXISTS `bai_store_items`;

CREATE TABLE `bai_store_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_des` varchar(200) NOT NULL,
  `item_brand` varchar(200) NOT NULL,
  `item_dim` varchar(200) NOT NULL,
  `item_color` varchar(200) NOT NULL,
  `item_rpi` float NOT NULL,
  `item_rol` int(11) NOT NULL,
  `item_cat` varchar(50) NOT NULL,
  `item_lastup` datetime NOT NULL,
  `item_remarks` varchar(200) NOT NULL,
  `item_status` varchar(20) NOT NULL,
  `item_rpi_current` float NOT NULL,
  `item_inbalance` int(11) NOT NULL,
  `item_outbalance` int(11) NOT NULL,
  `item_blastup` datetime NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_store_tran_log` */

DROP TABLE IF EXISTS `bai_store_tran_log`;

CREATE TABLE `bai_store_tran_log` (
  `trn_id` int(11) NOT NULL AUTO_INCREMENT,
  `trn_date` date NOT NULL,
  `trn_type` varchar(200) NOT NULL,
  `trn_party_id` int(11) NOT NULL,
  `trn_ref1` varchar(100) NOT NULL,
  `trn_ref1_date` date NOT NULL,
  `trn_ref2` varchar(100) NOT NULL,
  `trn_ref2_date` date NOT NULL,
  `trn_inv_item_id` int(11) NOT NULL,
  `trn_inv_qty` int(11) NOT NULL,
  `trn_rpi` float NOT NULL,
  `item_balance` int(11) NOT NULL,
  `trn_remarks` varchar(200) NOT NULL,
  `trn_lastup` datetime NOT NULL,
  `reference` varchar(200) NOT NULL,
  PRIMARY KEY (`trn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_sup_db` */

DROP TABLE IF EXISTS `bai_sup_db`;

CREATE TABLE `bai_sup_db` (
  `sup_id` int(11) NOT NULL AUTO_INCREMENT,
  `sup_name` varchar(100) NOT NULL,
  `sup_add` varchar(300) NOT NULL,
  `sup_stat` varchar(20) NOT NULL,
  `sup_remarks` varchar(200) NOT NULL,
  PRIMARY KEY (`sup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hire_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `login_info` */

DROP TABLE IF EXISTS `login_info`;

CREATE TABLE `login_info` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `mate_columns` */

DROP TABLE IF EXISTS `mate_columns`;

CREATE TABLE `mate_columns` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mate_user_id` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `mate_var_prefix` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mate_column` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `hidden` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `order_num` mediumint(4) unsigned NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mate_user_id` (`mate_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `members` */

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `level` int(11) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `order_db` */

DROP TABLE IF EXISTS `order_db`;

CREATE TABLE `order_db` (
  `order_id` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `item_code` varchar(200) NOT NULL,
  `sondate` int(11) NOT NULL,
  `orderqty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
