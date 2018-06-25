/*
SQLyog Job Agent Version 8.4 Copyright(c) Webyog Softworks Pvt. Ltd. All Rights Reserved.


MySQL - 5.5.5-10.1.28-MariaDB : Database - bai_pro4
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Database structure for database `bai_pro4` */

CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro4` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_pro4`;

/*Table structure for table `fastreact_plan` */

DROP TABLE IF EXISTS `fastreact_plan`;

CREATE TABLE `fastreact_plan` (
  `group_code` varchar(20) NOT NULL COMMENT 'Style Name',
  `module` varchar(8) NOT NULL COMMENT 'Module No\r\n',
  `style` varchar(130) NOT NULL COMMENT 'Style Id\r\n',
  `order_code` varchar(300) NOT NULL COMMENT 'Order Tid \r\n',
  `color` varchar(200) NOT NULL COMMENT 'Color Name\r\n',
  `smv` double NOT NULL COMMENT 'SMV\r\n',
  `delivery_date` date NOT NULL COMMENT 'Exfactory Date\r\n',
  `schedule` varchar(300) NOT NULL COMMENT 'Schedule No\r\n',
  `production_date` date NOT NULL COMMENT 'Production Statr Date\r\n',
  `qty` double NOT NULL COMMENT 'Order Qty\r\n',
  `tid` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Trace id\r\n',
  `week_code` int(11) NOT NULL COMMENT 'Week No\r\n',
  `status` int(11) NOT NULL COMMENT 'Status\r\n',
  PRIMARY KEY (`tid`),
  KEY `style` (`schedule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `job_shipment_plan_man_up` */

DROP TABLE IF EXISTS `job_shipment_plan_man_up`;

CREATE TABLE `job_shipment_plan_man_up` (
  `DELIVERY_NO` varchar(30) NOT NULL,
  `SCHEDULE_NO` varchar(30) NOT NULL,
  `ORD_QTY` varchar(30) NOT NULL,
  `FOB_PRICE_PER_PIECE` varchar(30) NOT NULL,
  `CM_VALUE` varchar(30) NOT NULL,
  `EX_FACTORY_DATE` varchar(30) NOT NULL,
  `ORDER_NO` varchar(10) NOT NULL,
  `STYLE` varchar(15) NOT NULL,
  `SIZE` varchar(15) NOT NULL,
  `Z_FEATURE` varchar(15) NOT NULL,
  `DEL_STATUS` varchar(2) NOT NULL,
  `MODE` varchar(3) NOT NULL,
  `PACKING_METHOD` varchar(3) NOT NULL,
  `MPO` varchar(30) NOT NULL,
  `CPO` varchar(30) NOT NULL,
  `COLOR` varchar(30) NOT NULL,
  `BUYER` varchar(36) NOT NULL,
  `PRODUCT` varchar(40) NOT NULL,
  `BUYER_DIVISION` varchar(40) NOT NULL,
  `DESTINATION` varchar(6) NOT NULL,
  `A` varchar(3) NOT NULL DEFAULT '0',
  `B` varchar(3) NOT NULL DEFAULT '0',
  `C` varchar(3) NOT NULL DEFAULT '0',
  `D` varchar(3) NOT NULL DEFAULT '0',
  `E` varchar(3) NOT NULL DEFAULT '0',
  `F` varchar(3) NOT NULL DEFAULT '0',
  `G` varchar(3) NOT NULL DEFAULT '0',
  `H` varchar(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

/*Table structure for table `query_edit_log` */

DROP TABLE IF EXISTS `query_edit_log`;

CREATE TABLE `query_edit_log` (
  `log_id` int(6) NOT NULL AUTO_INCREMENT,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `query_executed` text NOT NULL,
  `user_name` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `shipfast_sum` */

DROP TABLE IF EXISTS `shipfast_sum`;

CREATE TABLE `shipfast_sum` (
  `shipment_plan_id` int(11) NOT NULL,
  `fastreact_plan_id` int(11) NOT NULL,
  `size_xs` int(11) NOT NULL,
  `size_s` int(11) NOT NULL,
  `size_m` int(11) NOT NULL,
  `size_l` int(11) NOT NULL,
  `size_xl` int(11) NOT NULL,
  `size_xxl` int(11) NOT NULL,
  `size_xxxl` int(11) NOT NULL,
  `size_s01` int(11) NOT NULL,
  `size_s02` int(11) NOT NULL,
  `size_s03` int(11) NOT NULL,
  `size_s04` int(11) NOT NULL,
  `size_s05` int(11) NOT NULL,
  `size_s06` int(11) NOT NULL,
  `size_s07` int(11) NOT NULL,
  `size_s08` int(11) NOT NULL,
  `size_s09` int(11) NOT NULL,
  `size_s10` int(11) NOT NULL,
  `size_s11` int(11) NOT NULL,
  `size_s12` int(11) NOT NULL,
  `size_s13` int(11) NOT NULL,
  `size_s14` int(11) NOT NULL,
  `size_s15` int(11) NOT NULL,
  `size_s16` int(11) NOT NULL,
  `size_s17` int(11) NOT NULL,
  `size_s18` int(11) NOT NULL,
  `size_s19` int(11) NOT NULL,
  `size_s20` int(11) NOT NULL,
  `size_s21` int(11) NOT NULL,
  `size_s22` int(11) NOT NULL,
  `size_s23` int(11) NOT NULL,
  `size_s24` int(11) NOT NULL,
  `size_s25` int(11) NOT NULL,
  `size_s26` int(11) NOT NULL,
  `size_s27` int(11) NOT NULL,
  `size_s28` int(11) NOT NULL,
  `size_s29` int(11) NOT NULL,
  `size_s30` int(11) NOT NULL,
  `size_s31` int(11) NOT NULL,
  `size_s32` int(11) NOT NULL,
  `size_s33` int(11) NOT NULL,
  `size_s34` int(11) NOT NULL,
  `size_s35` int(11) NOT NULL,
  `size_s36` int(11) NOT NULL,
  `size_s37` int(11) NOT NULL,
  `size_s38` int(11) NOT NULL,
  `size_s39` int(11) NOT NULL,
  `size_s40` int(11) NOT NULL,
  `size_s41` int(11) NOT NULL,
  `size_s42` int(11) NOT NULL,
  `size_s43` int(11) NOT NULL,
  `size_s44` int(11) NOT NULL,
  `size_s45` int(11) NOT NULL,
  `size_s46` int(11) NOT NULL,
  `size_s47` int(11) NOT NULL,
  `size_s48` int(11) NOT NULL,
  `size_s49` int(11) NOT NULL,
  `size_s50` int(11) NOT NULL,
  `plan_start_date` date NOT NULL,
  `plan_comp_date` date NOT NULL,
  `size_comp_xs` int(11) NOT NULL,
  `size_comp_s` int(11) NOT NULL,
  `size_comp_m` int(11) NOT NULL,
  `size_comp_l` int(11) NOT NULL,
  `size_comp_xl` int(11) NOT NULL,
  `size_comp_xxl` int(11) NOT NULL,
  `size_comp_xxxl` int(11) NOT NULL,
  `size_comp_s01` int(11) NOT NULL COMMENT 'Shipment Size s01',
  `size_comp_s02` int(11) NOT NULL COMMENT 'Shipment Size s02',
  `size_comp_s03` int(11) NOT NULL COMMENT 'Shipment Size s03',
  `size_comp_s04` int(11) NOT NULL COMMENT 'Shipment Size s04',
  `size_comp_s05` int(11) NOT NULL COMMENT 'Shipment Size s05',
  `size_comp_s06` int(11) NOT NULL COMMENT 'Shipment Size s06',
  `size_comp_s07` int(11) NOT NULL COMMENT 'Shipment Size s07',
  `size_comp_s08` int(11) NOT NULL COMMENT 'Shipment Size s08',
  `size_comp_s09` int(11) NOT NULL COMMENT 'Shipment Size s09',
  `size_comp_s10` int(11) NOT NULL COMMENT 'Shipment Size s10',
  `size_comp_s11` int(11) NOT NULL COMMENT 'Shipment Size s11',
  `size_comp_s12` int(11) NOT NULL COMMENT 'Shipment Size s12',
  `size_comp_s13` int(11) NOT NULL COMMENT 'Shipment Size s13',
  `size_comp_s14` int(11) NOT NULL COMMENT 'Shipment Size s14',
  `size_comp_s15` int(11) NOT NULL COMMENT 'Shipment Size s15',
  `size_comp_s16` int(11) NOT NULL COMMENT 'Shipment Size s16',
  `size_comp_s17` int(11) NOT NULL COMMENT 'Shipment Size s17',
  `size_comp_s18` int(11) NOT NULL COMMENT 'Shipment Size s18',
  `size_comp_s19` int(11) NOT NULL COMMENT 'Shipment Size s19',
  `size_comp_s20` int(11) NOT NULL COMMENT 'Shipment Size s20',
  `size_comp_s21` int(11) NOT NULL COMMENT 'Shipment Size s21',
  `size_comp_s22` int(11) NOT NULL COMMENT 'Shipment Size s22',
  `size_comp_s23` int(11) NOT NULL COMMENT 'Shipment Size s23',
  `size_comp_s24` int(11) NOT NULL COMMENT 'Shipment Size s24',
  `size_comp_s25` int(11) NOT NULL COMMENT 'Shipment Size s25',
  `size_comp_s26` int(11) NOT NULL COMMENT 'Shipment Size s26',
  `size_comp_s27` int(11) NOT NULL COMMENT 'Shipment Size s27',
  `size_comp_s28` int(11) NOT NULL COMMENT 'Shipment Size s28',
  `size_comp_s29` int(11) NOT NULL COMMENT 'Shipment Size s29',
  `size_comp_s30` int(11) NOT NULL COMMENT 'Shipment Size s30',
  `size_comp_s31` int(11) NOT NULL COMMENT 'Shipment Size s31',
  `size_comp_s32` int(11) NOT NULL COMMENT 'Shipment Size s32',
  `size_comp_s33` int(11) NOT NULL COMMENT 'Shipment Size s33',
  `size_comp_s34` int(11) NOT NULL COMMENT 'Shipment Size s34',
  `size_comp_s35` int(11) NOT NULL COMMENT 'Shipment Size s35',
  `size_comp_s36` int(11) NOT NULL COMMENT 'Shipment Size s36',
  `size_comp_s37` int(11) NOT NULL COMMENT 'Shipment Size s37',
  `size_comp_s38` int(11) NOT NULL COMMENT 'Shipment Size s38',
  `size_comp_s39` int(11) NOT NULL COMMENT 'Shipment Size s39',
  `size_comp_s40` int(11) NOT NULL COMMENT 'Shipment Size s40',
  `size_comp_s41` int(11) NOT NULL COMMENT 'Shipment Size s41',
  `size_comp_s42` int(11) NOT NULL COMMENT 'Shipment Size s42',
  `size_comp_s43` int(11) NOT NULL COMMENT 'Shipment Size s43',
  `size_comp_s44` int(11) NOT NULL COMMENT 'Shipment Size s44',
  `size_comp_s45` int(11) NOT NULL COMMENT 'Shipment Size s45',
  `size_comp_s46` int(11) NOT NULL COMMENT 'Shipment Size s46',
  `size_comp_s47` int(11) NOT NULL COMMENT 'Shipment Size s47',
  `size_comp_s48` int(11) NOT NULL COMMENT 'Shipment Size s48',
  `size_comp_s49` int(11) NOT NULL COMMENT 'Shipment Size s49',
  `size_comp_s50` int(11) NOT NULL COMMENT 'Shipment Size s50',
  `plan_sec1` int(11) NOT NULL,
  `plan_sec2` int(11) NOT NULL,
  `plan_sec3` int(11) NOT NULL,
  `plan_sec4` int(11) NOT NULL,
  `plan_sec5` int(11) NOT NULL,
  `plan_sec6` int(11) NOT NULL,
  `plan_sec7` int(11) NOT NULL,
  `plan_sec8` int(11) NOT NULL,
  `plan_sec9` int(11) NOT NULL,
  `actu_sec1` int(11) NOT NULL,
  `actu_sec2` int(11) NOT NULL,
  `actu_sec3` int(11) NOT NULL,
  `actu_sec4` int(11) NOT NULL,
  `actu_sec5` int(11) NOT NULL,
  `actu_sec6` int(11) NOT NULL,
  `actu_sec7` int(11) NOT NULL,
  `actu_sec8` int(11) NOT NULL,
  `actu_sec9` int(11) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `remarks` text NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`shipment_plan_id`,`fastreact_plan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan` */

DROP TABLE IF EXISTS `shipment_plan`;

CREATE TABLE `shipment_plan` (
  `order_no` varchar(10) NOT NULL,
  `delivery_no` varchar(10) NOT NULL,
  `del_status` varchar(2) NOT NULL,
  `mpo` varchar(30) NOT NULL,
  `cpo` varchar(30) NOT NULL,
  `buyer` varchar(36) NOT NULL,
  `product` varchar(40) NOT NULL,
  `buyer_division` varchar(40) NOT NULL,
  `style` varchar(15) NOT NULL,
  `schedule_no` varchar(15) NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(15) NOT NULL,
  `z_feature` varchar(15) NOT NULL,
  `ord_qty` bigint(20) NOT NULL,
  `ex_factory_date` date NOT NULL,
  `mode` varchar(5) NOT NULL,
  `destination` varchar(10) NOT NULL,
  `packing_method` varchar(6) NOT NULL,
  `fob_price_per_piece` float NOT NULL,
  `cm_value` float NOT NULL,
  `ssc_code` varchar(150) NOT NULL,
  `ship_tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `week_code` tinyint(11) NOT NULL,
  `status` tinyint(11) NOT NULL,
  `ssc_code_new` varchar(200) NOT NULL,
  `order_embl_a` tinyint(11) NOT NULL,
  `order_embl_b` tinyint(11) NOT NULL,
  `order_embl_c` tinyint(11) NOT NULL,
  `order_embl_d` tinyint(11) NOT NULL,
  `order_embl_e` tinyint(11) NOT NULL,
  `order_embl_f` tinyint(11) NOT NULL,
  `order_embl_g` tinyint(11) NOT NULL,
  `order_embl_h` tinyint(11) NOT NULL,
  `ssc_code_week_plan` varchar(250) DEFAULT NULL,
  `cw_check` smallint(6) NOT NULL,
  PRIMARY KEY (`ship_tid`),
  UNIQUE KEY `ssc_code_week_plan` (`ssc_code_week_plan`),
  KEY `schedule_no` (`schedule_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan_archive` */

DROP TABLE IF EXISTS `shipment_plan_archive`;

CREATE TABLE `shipment_plan_archive` (
  `order_no` varchar(10) NOT NULL,
  `delivery_no` varchar(10) NOT NULL,
  `del_status` varchar(2) NOT NULL,
  `mpo` varchar(30) NOT NULL,
  `cpo` varchar(30) NOT NULL,
  `buyer` varchar(36) NOT NULL,
  `product` varchar(40) NOT NULL,
  `buyer_division` varchar(40) NOT NULL,
  `style` varchar(15) NOT NULL,
  `schedule_no` varchar(15) NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(15) NOT NULL,
  `z_feature` varchar(15) NOT NULL,
  `ord_qty` bigint(20) NOT NULL,
  `ex_factory_date` date NOT NULL,
  `mode` varchar(5) NOT NULL,
  `destination` varchar(10) NOT NULL,
  `packing_method` varchar(6) NOT NULL,
  `fob_price_per_piece` float NOT NULL,
  `cm_value` float NOT NULL,
  `ssc_code` varchar(150) NOT NULL,
  `ship_tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `week_code` tinyint(11) NOT NULL,
  `status` tinyint(11) NOT NULL,
  `ssc_code_new` varchar(200) NOT NULL,
  `order_embl_a` tinyint(11) NOT NULL,
  `order_embl_b` tinyint(11) NOT NULL,
  `order_embl_c` tinyint(11) NOT NULL,
  `order_embl_d` tinyint(11) NOT NULL,
  `order_embl_e` tinyint(11) NOT NULL,
  `order_embl_f` tinyint(11) NOT NULL,
  `order_embl_g` tinyint(11) NOT NULL,
  `order_embl_h` tinyint(11) NOT NULL,
  `ssc_code_week_plan` varchar(250) DEFAULT NULL,
  `cw_check` smallint(6) NOT NULL,
  PRIMARY KEY (`ship_tid`),
  UNIQUE KEY `ssc_code_week_plan` (`ssc_code_week_plan`),
  KEY `schedule_no` (`schedule_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan_ref_view` */

DROP TABLE IF EXISTS `shipment_plan_ref_view`;

CREATE TABLE `shipment_plan_ref_view` (
  `order_no` varchar(30) DEFAULT NULL,
  `delivery_no` varchar(30) DEFAULT NULL,
  `del_status` varchar(6) DEFAULT NULL,
  `mpo` varchar(90) DEFAULT NULL,
  `cpo` varchar(90) DEFAULT NULL,
  `buyer` varchar(108) DEFAULT NULL,
  `product` varchar(120) DEFAULT NULL,
  `buyer_division` varchar(120) DEFAULT NULL,
  `style` varchar(45) DEFAULT NULL,
  `schedule_no` varchar(45) DEFAULT NULL,
  `color` varchar(150) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `z_feature` varchar(45) DEFAULT NULL,
  `ord_qty` double DEFAULT NULL,
  `ex_factory_date` date DEFAULT NULL,
  `mode` varchar(15) DEFAULT NULL,
  `destination` varchar(30) DEFAULT NULL,
  `packing_method` varchar(18) DEFAULT NULL,
  `fob_price_per_piece` float DEFAULT NULL,
  `cm_value` float DEFAULT NULL,
  `ssc_code` varchar(450) DEFAULT NULL,
  `ship_tid` double DEFAULT NULL,
  `week_code` tinyint(11) DEFAULT NULL,
  `status` tinyint(11) DEFAULT NULL,
  `ssc_code_new` varchar(600) DEFAULT NULL,
  `order_embl_a` tinyint(11) DEFAULT NULL,
  `order_embl_b` tinyint(11) DEFAULT NULL,
  `order_embl_c` tinyint(11) DEFAULT NULL,
  `order_embl_d` tinyint(11) DEFAULT NULL,
  `order_embl_e` tinyint(11) DEFAULT NULL,
  `order_embl_f` tinyint(11) DEFAULT NULL,
  `order_embl_g` tinyint(11) DEFAULT NULL,
  `order_embl_h` tinyint(11) DEFAULT NULL,
  `ord_qty_new` decimal(42,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `week_del_log` */

DROP TABLE IF EXISTS `week_del_log`;

CREATE TABLE `week_del_log` (
  `ex_fact` date NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ship_tid` int(11) NOT NULL,
  `ref_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `week_delivery_plan` */

DROP TABLE IF EXISTS `week_delivery_plan`;

CREATE TABLE `week_delivery_plan` (
  `shipment_plan_id` int(11) NOT NULL,
  `fastreact_plan_id` int(11) NOT NULL,
  `size_xs` mediumint(9) NOT NULL,
  `size_s` mediumint(9) NOT NULL,
  `size_m` mediumint(9) NOT NULL,
  `size_l` mediumint(9) NOT NULL,
  `size_xl` mediumint(9) NOT NULL,
  `size_xxl` mediumint(9) NOT NULL,
  `size_xxxl` mediumint(9) NOT NULL,
  `size_s01` int(11) NOT NULL,
  `size_s02` int(11) NOT NULL,
  `size_s03` int(11) NOT NULL,
  `size_s04` int(11) NOT NULL,
  `size_s05` int(11) NOT NULL,
  `size_s06` mediumint(9) NOT NULL,
  `size_s07` int(11) NOT NULL,
  `size_s08` mediumint(9) NOT NULL,
  `size_s09` int(11) NOT NULL,
  `size_s10` mediumint(9) NOT NULL,
  `size_s11` int(11) NOT NULL,
  `size_s12` mediumint(9) NOT NULL,
  `size_s13` int(11) NOT NULL,
  `size_s14` mediumint(9) NOT NULL,
  `size_s15` int(11) NOT NULL,
  `size_s16` mediumint(9) NOT NULL,
  `size_s17` int(11) NOT NULL,
  `size_s18` mediumint(9) NOT NULL,
  `size_s19` int(11) NOT NULL,
  `size_s20` mediumint(9) NOT NULL,
  `size_s21` int(11) NOT NULL,
  `size_s22` mediumint(9) NOT NULL,
  `size_s23` int(11) NOT NULL,
  `size_s24` mediumint(9) NOT NULL,
  `size_s25` int(11) NOT NULL,
  `size_s26` mediumint(9) NOT NULL,
  `size_s27` int(11) NOT NULL,
  `size_s28` mediumint(9) NOT NULL,
  `size_s29` int(11) NOT NULL,
  `size_s30` mediumint(9) NOT NULL,
  `size_s31` int(11) NOT NULL,
  `size_s32` int(11) NOT NULL,
  `size_s33` int(11) NOT NULL,
  `size_s34` int(11) NOT NULL,
  `size_s35` int(11) NOT NULL,
  `size_s36` int(11) NOT NULL,
  `size_s37` int(11) NOT NULL,
  `size_s38` int(11) NOT NULL,
  `size_s39` int(11) NOT NULL,
  `size_s40` int(11) NOT NULL,
  `size_s41` int(11) NOT NULL,
  `size_s42` int(11) NOT NULL,
  `size_s43` int(11) NOT NULL,
  `size_s44` int(11) NOT NULL,
  `size_s45` int(11) NOT NULL,
  `size_s46` int(11) NOT NULL,
  `size_s47` int(11) NOT NULL,
  `size_s48` int(11) NOT NULL,
  `size_s49` int(11) NOT NULL,
  `size_s50` int(11) NOT NULL,
  `plan_start_date` date NOT NULL,
  `plan_comp_date` date NOT NULL,
  `size_comp_xs` mediumint(9) NOT NULL,
  `size_comp_s` mediumint(9) NOT NULL,
  `size_comp_m` mediumint(9) NOT NULL,
  `size_comp_l` mediumint(9) NOT NULL,
  `size_comp_xl` mediumint(9) NOT NULL,
  `size_comp_xxl` mediumint(9) NOT NULL,
  `size_comp_xxxl` mediumint(9) NOT NULL,
  `size_comp_s01` mediumint(9) NOT NULL COMMENT 'Size s01',
  `size_comp_s02` mediumint(9) NOT NULL COMMENT 'Size s02',
  `size_comp_s03` mediumint(9) NOT NULL COMMENT 'Size s03',
  `size_comp_s04` mediumint(9) NOT NULL COMMENT 'Size s04',
  `size_comp_s05` mediumint(9) NOT NULL COMMENT 'Size s05',
  `size_comp_s06` mediumint(9) NOT NULL COMMENT 'Size s06',
  `size_comp_s07` mediumint(9) NOT NULL COMMENT 'Size s07',
  `size_comp_s08` mediumint(9) NOT NULL COMMENT 'Size s08',
  `size_comp_s09` mediumint(9) NOT NULL COMMENT 'Size s09',
  `size_comp_s10` mediumint(9) NOT NULL COMMENT 'Size s10',
  `size_comp_s11` mediumint(9) NOT NULL COMMENT 'Size s11',
  `size_comp_s12` mediumint(9) NOT NULL COMMENT 'Size s12',
  `size_comp_s13` mediumint(9) NOT NULL COMMENT 'Size s13',
  `size_comp_s14` mediumint(9) NOT NULL COMMENT 'Size s14',
  `size_comp_s15` mediumint(9) NOT NULL COMMENT 'Size s15',
  `size_comp_s16` mediumint(9) NOT NULL COMMENT 'Size s16',
  `size_comp_s17` mediumint(9) NOT NULL COMMENT 'Size s17',
  `size_comp_s18` mediumint(9) NOT NULL COMMENT 'Size s18',
  `size_comp_s19` mediumint(9) NOT NULL COMMENT 'Size s19',
  `size_comp_s20` mediumint(9) NOT NULL COMMENT 'Size s20',
  `size_comp_s21` mediumint(9) NOT NULL COMMENT 'Size s21',
  `size_comp_s22` mediumint(9) NOT NULL COMMENT 'Size s22',
  `size_comp_s23` mediumint(9) NOT NULL COMMENT 'Size s23',
  `size_comp_s24` mediumint(9) NOT NULL COMMENT 'Size s24',
  `size_comp_s25` mediumint(9) NOT NULL COMMENT 'Size s25',
  `size_comp_s26` mediumint(9) NOT NULL COMMENT 'Size s26',
  `size_comp_s27` mediumint(9) NOT NULL COMMENT 'Size s27',
  `size_comp_s28` mediumint(9) NOT NULL COMMENT 'Size s28',
  `size_comp_s29` mediumint(9) NOT NULL COMMENT 'Size s29',
  `size_comp_s30` mediumint(9) NOT NULL COMMENT 'Size s30',
  `size_comp_s31` mediumint(9) NOT NULL COMMENT 'Size s31',
  `size_comp_s32` mediumint(9) NOT NULL COMMENT 'Size s32',
  `size_comp_s33` mediumint(9) NOT NULL COMMENT 'Size s33',
  `size_comp_s34` mediumint(9) NOT NULL COMMENT 'Size s34',
  `size_comp_s35` mediumint(9) NOT NULL COMMENT 'Size s35',
  `size_comp_s36` mediumint(9) NOT NULL COMMENT 'Size s36',
  `size_comp_s37` mediumint(9) NOT NULL COMMENT 'Size s37',
  `size_comp_s38` mediumint(9) NOT NULL COMMENT 'Size s38',
  `size_comp_s39` mediumint(9) NOT NULL COMMENT 'Size s39',
  `size_comp_s40` mediumint(9) NOT NULL COMMENT 'Size s40',
  `size_comp_s41` mediumint(9) NOT NULL COMMENT 'Size s41',
  `size_comp_s42` mediumint(9) NOT NULL COMMENT 'Size s42',
  `size_comp_s43` mediumint(9) NOT NULL COMMENT 'Size s43',
  `size_comp_s44` mediumint(9) NOT NULL COMMENT 'Size s44',
  `size_comp_s45` mediumint(9) NOT NULL COMMENT 'Size s45',
  `size_comp_s46` mediumint(9) NOT NULL COMMENT 'Size s46',
  `size_comp_s47` mediumint(9) NOT NULL COMMENT 'Size s47',
  `size_comp_s48` mediumint(9) NOT NULL COMMENT 'Size s48',
  `size_comp_s49` mediumint(9) NOT NULL COMMENT 'Size s49',
  `size_comp_s50` mediumint(9) NOT NULL COMMENT 'Size s50',
  `plan_sec1` mediumint(9) NOT NULL,
  `plan_sec2` mediumint(9) NOT NULL,
  `plan_sec3` mediumint(9) NOT NULL,
  `plan_sec4` mediumint(9) NOT NULL,
  `plan_sec5` mediumint(9) NOT NULL,
  `plan_sec6` mediumint(9) NOT NULL,
  `plan_sec7` mediumint(9) NOT NULL,
  `plan_sec8` mediumint(9) NOT NULL,
  `plan_sec9` mediumint(9) NOT NULL,
  `actu_sec1` mediumint(9) NOT NULL,
  `actu_sec2` mediumint(9) NOT NULL,
  `actu_sec3` mediumint(9) NOT NULL,
  `actu_sec4` mediumint(9) NOT NULL,
  `actu_sec5` mediumint(9) NOT NULL,
  `actu_sec6` mediumint(9) NOT NULL,
  `actu_sec7` mediumint(9) NOT NULL,
  `actu_sec8` mediumint(9) NOT NULL,
  `actu_sec9` mediumint(9) NOT NULL,
  `tid` mediumint(9) NOT NULL,
  `remarks` text NOT NULL COMMENT 'Planner Remarks^Packing Remarks^Commitments (ABC)',
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `rev_exfactory` date DEFAULT NULL,
  `rev_emb_status` varchar(100) DEFAULT NULL,
  `act_cut` mediumint(9) NOT NULL,
  `act_in` mediumint(9) NOT NULL,
  `act_fca` mediumint(9) NOT NULL,
  `act_mca` mediumint(9) NOT NULL,
  `act_fg` mediumint(9) NOT NULL,
  `cart_pending` mediumint(9) NOT NULL,
  `priority` mediumint(9) NOT NULL,
  `original_order_qty` mediumint(9) NOT NULL,
  `rev_mode` varchar(30) NOT NULL,
  `act_ship` mediumint(9) NOT NULL,
  `act_exfact` date NOT NULL,
  `act_rej` int(11) NOT NULL COMMENT 'actual rejections',
  PRIMARY KEY (`ref_id`),
  KEY `shipment_plan_id` (`shipment_plan_id`,`fastreact_plan_id`,`tid`,`ref_id`),
  KEY `new` (`shipment_plan_id`,`fastreact_plan_id`,`rev_exfactory`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `week_delivery_plan_archive` */

DROP TABLE IF EXISTS `week_delivery_plan_archive`;

CREATE TABLE `week_delivery_plan_archive` (
  `shipment_plan_id` int(11) NOT NULL,
  `fastreact_plan_id` int(11) NOT NULL,
  `size_xs` mediumint(9) NOT NULL,
  `size_s` mediumint(9) NOT NULL,
  `size_m` mediumint(9) NOT NULL,
  `size_l` mediumint(9) NOT NULL,
  `size_xl` mediumint(9) NOT NULL,
  `size_xxl` mediumint(9) NOT NULL,
  `size_xxxl` mediumint(9) NOT NULL,
  `size_s01` int(11) NOT NULL,
  `size_s02` int(11) NOT NULL,
  `size_s03` int(11) NOT NULL,
  `size_s04` int(11) NOT NULL,
  `size_s05` int(11) NOT NULL,
  `size_s06` mediumint(9) NOT NULL,
  `size_s07` int(11) NOT NULL,
  `size_s08` mediumint(9) NOT NULL,
  `size_s09` int(11) NOT NULL,
  `size_s10` mediumint(9) NOT NULL,
  `size_s11` int(11) NOT NULL,
  `size_s12` mediumint(9) NOT NULL,
  `size_s13` int(11) NOT NULL,
  `size_s14` mediumint(9) NOT NULL,
  `size_s15` int(11) NOT NULL,
  `size_s16` mediumint(9) NOT NULL,
  `size_s17` int(11) NOT NULL,
  `size_s18` mediumint(9) NOT NULL,
  `size_s19` int(11) NOT NULL,
  `size_s20` mediumint(9) NOT NULL,
  `size_s21` int(11) NOT NULL,
  `size_s22` mediumint(9) NOT NULL,
  `size_s23` int(11) NOT NULL,
  `size_s24` mediumint(9) NOT NULL,
  `size_s25` int(11) NOT NULL,
  `size_s26` mediumint(9) NOT NULL,
  `size_s27` int(11) NOT NULL,
  `size_s28` mediumint(9) NOT NULL,
  `size_s29` int(11) NOT NULL,
  `size_s30` mediumint(9) NOT NULL,
  `size_s31` int(11) NOT NULL,
  `size_s32` int(11) NOT NULL,
  `size_s33` int(11) NOT NULL,
  `size_s34` int(11) NOT NULL,
  `size_s35` int(11) NOT NULL,
  `size_s36` int(11) NOT NULL,
  `size_s37` int(11) NOT NULL,
  `size_s38` int(11) NOT NULL,
  `size_s39` int(11) NOT NULL,
  `size_s40` int(11) NOT NULL,
  `size_s41` int(11) NOT NULL,
  `size_s42` int(11) NOT NULL,
  `size_s43` int(11) NOT NULL,
  `size_s44` int(11) NOT NULL,
  `size_s45` int(11) NOT NULL,
  `size_s46` int(11) NOT NULL,
  `size_s47` int(11) NOT NULL,
  `size_s48` int(11) NOT NULL,
  `size_s49` int(11) NOT NULL,
  `size_s50` int(11) NOT NULL,
  `plan_start_date` date NOT NULL,
  `plan_comp_date` date NOT NULL,
  `size_comp_xs` mediumint(9) NOT NULL,
  `size_comp_s` mediumint(9) NOT NULL,
  `size_comp_m` mediumint(9) NOT NULL,
  `size_comp_l` mediumint(9) NOT NULL,
  `size_comp_xl` mediumint(9) NOT NULL,
  `size_comp_xxl` mediumint(9) NOT NULL,
  `size_comp_xxxl` mediumint(9) NOT NULL,
  `size_comp_s01` mediumint(9) NOT NULL COMMENT 'Size s01',
  `size_comp_s02` mediumint(9) NOT NULL COMMENT 'Size s02',
  `size_comp_s03` mediumint(9) NOT NULL COMMENT 'Size s03',
  `size_comp_s04` mediumint(9) NOT NULL COMMENT 'Size s04',
  `size_comp_s05` mediumint(9) NOT NULL COMMENT 'Size s05',
  `size_comp_s06` mediumint(9) NOT NULL COMMENT 'Size s06',
  `size_comp_s07` mediumint(9) NOT NULL COMMENT 'Size s07',
  `size_comp_s08` mediumint(9) NOT NULL COMMENT 'Size s08',
  `size_comp_s09` mediumint(9) NOT NULL COMMENT 'Size s09',
  `size_comp_s10` mediumint(9) NOT NULL COMMENT 'Size s10',
  `size_comp_s11` mediumint(9) NOT NULL COMMENT 'Size s11',
  `size_comp_s12` mediumint(9) NOT NULL COMMENT 'Size s12',
  `size_comp_s13` mediumint(9) NOT NULL COMMENT 'Size s13',
  `size_comp_s14` mediumint(9) NOT NULL COMMENT 'Size s14',
  `size_comp_s15` mediumint(9) NOT NULL COMMENT 'Size s15',
  `size_comp_s16` mediumint(9) NOT NULL COMMENT 'Size s16',
  `size_comp_s17` mediumint(9) NOT NULL COMMENT 'Size s17',
  `size_comp_s18` mediumint(9) NOT NULL COMMENT 'Size s18',
  `size_comp_s19` mediumint(9) NOT NULL COMMENT 'Size s19',
  `size_comp_s20` mediumint(9) NOT NULL COMMENT 'Size s20',
  `size_comp_s21` mediumint(9) NOT NULL COMMENT 'Size s21',
  `size_comp_s22` mediumint(9) NOT NULL COMMENT 'Size s22',
  `size_comp_s23` mediumint(9) NOT NULL COMMENT 'Size s23',
  `size_comp_s24` mediumint(9) NOT NULL COMMENT 'Size s24',
  `size_comp_s25` mediumint(9) NOT NULL COMMENT 'Size s25',
  `size_comp_s26` mediumint(9) NOT NULL COMMENT 'Size s26',
  `size_comp_s27` mediumint(9) NOT NULL COMMENT 'Size s27',
  `size_comp_s28` mediumint(9) NOT NULL COMMENT 'Size s28',
  `size_comp_s29` mediumint(9) NOT NULL COMMENT 'Size s29',
  `size_comp_s30` mediumint(9) NOT NULL COMMENT 'Size s30',
  `size_comp_s31` mediumint(9) NOT NULL COMMENT 'Size s31',
  `size_comp_s32` mediumint(9) NOT NULL COMMENT 'Size s32',
  `size_comp_s33` mediumint(9) NOT NULL COMMENT 'Size s33',
  `size_comp_s34` mediumint(9) NOT NULL COMMENT 'Size s34',
  `size_comp_s35` mediumint(9) NOT NULL COMMENT 'Size s35',
  `size_comp_s36` mediumint(9) NOT NULL COMMENT 'Size s36',
  `size_comp_s37` mediumint(9) NOT NULL COMMENT 'Size s37',
  `size_comp_s38` mediumint(9) NOT NULL COMMENT 'Size s38',
  `size_comp_s39` mediumint(9) NOT NULL COMMENT 'Size s39',
  `size_comp_s40` mediumint(9) NOT NULL COMMENT 'Size s40',
  `size_comp_s41` mediumint(9) NOT NULL COMMENT 'Size s41',
  `size_comp_s42` mediumint(9) NOT NULL COMMENT 'Size s42',
  `size_comp_s43` mediumint(9) NOT NULL COMMENT 'Size s43',
  `size_comp_s44` mediumint(9) NOT NULL COMMENT 'Size s44',
  `size_comp_s45` mediumint(9) NOT NULL COMMENT 'Size s45',
  `size_comp_s46` mediumint(9) NOT NULL COMMENT 'Size s46',
  `size_comp_s47` mediumint(9) NOT NULL COMMENT 'Size s47',
  `size_comp_s48` mediumint(9) NOT NULL COMMENT 'Size s48',
  `size_comp_s49` mediumint(9) NOT NULL COMMENT 'Size s49',
  `size_comp_s50` mediumint(9) NOT NULL COMMENT 'Size s50',
  `plan_sec1` mediumint(9) NOT NULL,
  `plan_sec2` mediumint(9) NOT NULL,
  `plan_sec3` mediumint(9) NOT NULL,
  `plan_sec4` mediumint(9) NOT NULL,
  `plan_sec5` mediumint(9) NOT NULL,
  `plan_sec6` mediumint(9) NOT NULL,
  `plan_sec7` mediumint(9) NOT NULL,
  `plan_sec8` mediumint(9) NOT NULL,
  `plan_sec9` mediumint(9) NOT NULL,
  `actu_sec1` mediumint(9) NOT NULL,
  `actu_sec2` mediumint(9) NOT NULL,
  `actu_sec3` mediumint(9) NOT NULL,
  `actu_sec4` mediumint(9) NOT NULL,
  `actu_sec5` mediumint(9) NOT NULL,
  `actu_sec6` mediumint(9) NOT NULL,
  `actu_sec7` mediumint(9) NOT NULL,
  `actu_sec8` mediumint(9) NOT NULL,
  `actu_sec9` mediumint(9) NOT NULL,
  `tid` mediumint(9) NOT NULL,
  `remarks` text NOT NULL COMMENT 'Planner Remarks^Packing Remarks^Commitments (ABC)',
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `rev_exfactory` date DEFAULT NULL,
  `rev_emb_status` varchar(100) DEFAULT NULL,
  `act_cut` mediumint(9) NOT NULL,
  `act_in` mediumint(9) NOT NULL,
  `act_fca` mediumint(9) NOT NULL,
  `act_mca` mediumint(9) NOT NULL,
  `act_fg` mediumint(9) NOT NULL,
  `cart_pending` mediumint(9) NOT NULL,
  `priority` mediumint(9) NOT NULL,
  `original_order_qty` mediumint(9) NOT NULL,
  `rev_mode` varchar(30) NOT NULL,
  `act_ship` mediumint(9) NOT NULL,
  `act_exfact` date NOT NULL,
  `act_rej` int(11) NOT NULL COMMENT 'To update actual rejections',
  PRIMARY KEY (`ref_id`),
  KEY `shipment_plan_id` (`shipment_plan_id`,`fastreact_plan_id`,`tid`,`ref_id`),
  KEY `new` (`shipment_plan_id`,`fastreact_plan_id`,`rev_exfactory`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `week_delivery_plan_ref_temp` */

DROP TABLE IF EXISTS `week_delivery_plan_ref_temp`;

CREATE TABLE `week_delivery_plan_ref_temp` (
  `ship_tid` double DEFAULT NULL,
  `tid` int(11) DEFAULT NULL,
  `buyer_division` varchar(120) DEFAULT NULL,
  `schedule_no` varchar(45) DEFAULT NULL,
  `color` varchar(150) DEFAULT NULL,
  `style` varchar(45) DEFAULT NULL,
  `ord_qty_new` int(11) DEFAULT NULL,
  `ord_qty_new_old` decimal(42,0) DEFAULT NULL,
  `m3_ship_plan_ex_fact` date DEFAULT NULL,
  `ex_factory_date` date DEFAULT NULL,
  `rev_exfactory` date DEFAULT NULL,
  `ex_factory_date_new` date DEFAULT NULL,
  `output` double DEFAULT NULL,
  `act_cut` int(11) DEFAULT NULL,
  `act_in` int(11) DEFAULT NULL,
  `act_fca` int(11) DEFAULT NULL,
  `act_mca` int(11) DEFAULT NULL,
  `act_fg` int(11) DEFAULT NULL,
  `act_ship` int(11) DEFAULT NULL,
  `cart_pending` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `ref_id` double DEFAULT NULL,
  `act_exfact` date DEFAULT NULL,
  `act_rej` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `week_delivery_plan_temp` */

DROP TABLE IF EXISTS `week_delivery_plan_temp`;

CREATE TABLE `week_delivery_plan_temp` (
  `shipment_plan_id` int(11) NOT NULL,
  `fastreact_plan_id` int(11) NOT NULL,
  `size_xs` mediumint(9) NOT NULL,
  `size_s` mediumint(9) NOT NULL,
  `size_m` mediumint(9) NOT NULL,
  `size_l` mediumint(9) NOT NULL,
  `size_xl` mediumint(9) NOT NULL,
  `size_xxl` mediumint(9) NOT NULL,
  `size_xxxl` mediumint(9) NOT NULL,
  `size_s01` int(11) NOT NULL,
  `size_s02` int(11) NOT NULL,
  `size_s03` int(11) NOT NULL,
  `size_s04` int(11) NOT NULL,
  `size_s05` int(11) NOT NULL,
  `size_s06` mediumint(9) NOT NULL,
  `size_s07` int(11) NOT NULL,
  `size_s08` mediumint(9) NOT NULL,
  `size_s09` int(11) NOT NULL,
  `size_s10` mediumint(9) NOT NULL,
  `size_s11` int(11) NOT NULL,
  `size_s12` mediumint(9) NOT NULL,
  `size_s13` int(11) NOT NULL,
  `size_s14` mediumint(9) NOT NULL,
  `size_s15` int(11) NOT NULL,
  `size_s16` mediumint(9) NOT NULL,
  `size_s17` int(11) NOT NULL,
  `size_s18` mediumint(9) NOT NULL,
  `size_s19` int(11) NOT NULL,
  `size_s20` mediumint(9) NOT NULL,
  `size_s21` int(11) NOT NULL,
  `size_s22` mediumint(9) NOT NULL,
  `size_s23` int(11) NOT NULL,
  `size_s24` mediumint(9) NOT NULL,
  `size_s25` int(11) NOT NULL,
  `size_s26` mediumint(9) NOT NULL,
  `size_s27` int(11) NOT NULL,
  `size_s28` mediumint(9) NOT NULL,
  `size_s29` int(11) NOT NULL,
  `size_s30` mediumint(9) NOT NULL,
  `size_s31` int(11) NOT NULL,
  `size_s32` int(11) NOT NULL,
  `size_s33` int(11) NOT NULL,
  `size_s34` int(11) NOT NULL,
  `size_s35` int(11) NOT NULL,
  `size_s36` int(11) NOT NULL,
  `size_s37` int(11) NOT NULL,
  `size_s38` int(11) NOT NULL,
  `size_s39` int(11) NOT NULL,
  `size_s40` int(11) NOT NULL,
  `size_s41` int(11) NOT NULL,
  `size_s42` int(11) NOT NULL,
  `size_s43` int(11) NOT NULL,
  `size_s44` int(11) NOT NULL,
  `size_s45` int(11) NOT NULL,
  `size_s46` int(11) NOT NULL,
  `size_s47` int(11) NOT NULL,
  `size_s48` int(11) NOT NULL,
  `size_s49` int(11) NOT NULL,
  `size_s50` int(11) NOT NULL,
  `plan_start_date` date NOT NULL,
  `plan_comp_date` date NOT NULL,
  `size_comp_xs` mediumint(9) NOT NULL,
  `size_comp_s` mediumint(9) NOT NULL,
  `size_comp_m` mediumint(9) NOT NULL,
  `size_comp_l` mediumint(9) NOT NULL,
  `size_comp_xl` mediumint(9) NOT NULL,
  `size_comp_xxl` mediumint(9) NOT NULL,
  `size_comp_xxxl` mediumint(9) NOT NULL,
  `size_comp_s01` mediumint(9) NOT NULL COMMENT 'Size s01',
  `size_comp_s02` mediumint(9) NOT NULL COMMENT 'Size s02',
  `size_comp_s03` mediumint(9) NOT NULL COMMENT 'Size s03',
  `size_comp_s04` mediumint(9) NOT NULL COMMENT 'Size s04',
  `size_comp_s05` mediumint(9) NOT NULL COMMENT 'Size s05',
  `size_comp_s06` mediumint(9) NOT NULL COMMENT 'Size s06',
  `size_comp_s07` mediumint(9) NOT NULL COMMENT 'Size s07',
  `size_comp_s08` mediumint(9) NOT NULL COMMENT 'Size s08',
  `size_comp_s09` mediumint(9) NOT NULL COMMENT 'Size s09',
  `size_comp_s10` mediumint(9) NOT NULL COMMENT 'Size s10',
  `size_comp_s11` mediumint(9) NOT NULL COMMENT 'Size s11',
  `size_comp_s12` mediumint(9) NOT NULL COMMENT 'Size s12',
  `size_comp_s13` mediumint(9) NOT NULL COMMENT 'Size s13',
  `size_comp_s14` mediumint(9) NOT NULL COMMENT 'Size s14',
  `size_comp_s15` mediumint(9) NOT NULL COMMENT 'Size s15',
  `size_comp_s16` mediumint(9) NOT NULL COMMENT 'Size s16',
  `size_comp_s17` mediumint(9) NOT NULL COMMENT 'Size s17',
  `size_comp_s18` mediumint(9) NOT NULL COMMENT 'Size s18',
  `size_comp_s19` mediumint(9) NOT NULL COMMENT 'Size s19',
  `size_comp_s20` mediumint(9) NOT NULL COMMENT 'Size s20',
  `size_comp_s21` mediumint(9) NOT NULL COMMENT 'Size s21',
  `size_comp_s22` mediumint(9) NOT NULL COMMENT 'Size s22',
  `size_comp_s23` mediumint(9) NOT NULL COMMENT 'Size s23',
  `size_comp_s24` mediumint(9) NOT NULL COMMENT 'Size s24',
  `size_comp_s25` mediumint(9) NOT NULL COMMENT 'Size s25',
  `size_comp_s26` mediumint(9) NOT NULL COMMENT 'Size s26',
  `size_comp_s27` mediumint(9) NOT NULL COMMENT 'Size s27',
  `size_comp_s28` mediumint(9) NOT NULL COMMENT 'Size s28',
  `size_comp_s29` mediumint(9) NOT NULL COMMENT 'Size s29',
  `size_comp_s30` mediumint(9) NOT NULL COMMENT 'Size s30',
  `size_comp_s31` mediumint(9) NOT NULL COMMENT 'Size s31',
  `size_comp_s32` mediumint(9) NOT NULL COMMENT 'Size s32',
  `size_comp_s33` mediumint(9) NOT NULL COMMENT 'Size s33',
  `size_comp_s34` mediumint(9) NOT NULL COMMENT 'Size s34',
  `size_comp_s35` mediumint(9) NOT NULL COMMENT 'Size s35',
  `size_comp_s36` mediumint(9) NOT NULL COMMENT 'Size s36',
  `size_comp_s37` mediumint(9) NOT NULL COMMENT 'Size s37',
  `size_comp_s38` mediumint(9) NOT NULL COMMENT 'Size s38',
  `size_comp_s39` mediumint(9) NOT NULL COMMENT 'Size s39',
  `size_comp_s40` mediumint(9) NOT NULL COMMENT 'Size s40',
  `size_comp_s41` mediumint(9) NOT NULL COMMENT 'Size s41',
  `size_comp_s42` mediumint(9) NOT NULL COMMENT 'Size s42',
  `size_comp_s43` mediumint(9) NOT NULL COMMENT 'Size s43',
  `size_comp_s44` mediumint(9) NOT NULL COMMENT 'Size s44',
  `size_comp_s45` mediumint(9) NOT NULL COMMENT 'Size s45',
  `size_comp_s46` mediumint(9) NOT NULL COMMENT 'Size s46',
  `size_comp_s47` mediumint(9) NOT NULL COMMENT 'Size s47',
  `size_comp_s48` mediumint(9) NOT NULL COMMENT 'Size s48',
  `size_comp_s49` mediumint(9) NOT NULL COMMENT 'Size s49',
  `size_comp_s50` mediumint(9) NOT NULL COMMENT 'Size s50',
  `plan_sec1` mediumint(9) NOT NULL,
  `plan_sec2` mediumint(9) NOT NULL,
  `plan_sec3` mediumint(9) NOT NULL,
  `plan_sec4` mediumint(9) NOT NULL,
  `plan_sec5` mediumint(9) NOT NULL,
  `plan_sec6` mediumint(9) NOT NULL,
  `plan_sec7` mediumint(9) NOT NULL,
  `plan_sec8` mediumint(9) NOT NULL,
  `plan_sec9` mediumint(9) NOT NULL,
  `actu_sec1` mediumint(9) NOT NULL,
  `actu_sec2` mediumint(9) NOT NULL,
  `actu_sec3` mediumint(9) NOT NULL,
  `actu_sec4` mediumint(9) NOT NULL,
  `actu_sec5` mediumint(9) NOT NULL,
  `actu_sec6` mediumint(9) NOT NULL,
  `actu_sec7` mediumint(9) NOT NULL,
  `actu_sec8` mediumint(9) NOT NULL,
  `actu_sec9` mediumint(9) NOT NULL,
  `tid` mediumint(9) NOT NULL,
  `remarks` text NOT NULL COMMENT 'Planner Remarks^Packing Remarks^Commitments (ABC)',
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `rev_exfactory` date DEFAULT NULL,
  `rev_emb_status` varchar(100) DEFAULT NULL,
  `act_cut` mediumint(9) NOT NULL,
  `act_in` mediumint(9) NOT NULL,
  `act_fca` mediumint(9) NOT NULL,
  `act_mca` mediumint(9) NOT NULL,
  `act_fg` mediumint(9) NOT NULL,
  `cart_pending` mediumint(9) NOT NULL,
  `priority` mediumint(9) NOT NULL,
  `original_order_qty` mediumint(9) NOT NULL,
  `rev_mode` varchar(30) NOT NULL,
  `act_ship` mediumint(9) NOT NULL,
  `act_exfact` date NOT NULL,
  `act_rej` int(11) NOT NULL COMMENT 'actual rejections',
  PRIMARY KEY (`ref_id`),
  KEY `shipment_plan_id` (`shipment_plan_id`,`fastreact_plan_id`,`tid`,`ref_id`),
  KEY `new` (`shipment_plan_id`,`fastreact_plan_id`,`rev_exfactory`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `weekly_cap_reasons` */

DROP TABLE IF EXISTS `weekly_cap_reasons`;

CREATE TABLE `weekly_cap_reasons` (
  `sno` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `reason` varchar(50) NOT NULL COMMENT 'Planning Remarks',
  `color_code` varchar(10) NOT NULL COMMENT 'Color Identification Of Reason',
  `category` int(11) NOT NULL COMMENT '1-Planning',
  PRIMARY KEY (`sno`),
  UNIQUE KEY `Reason` (`reason`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `weekly_delivery_plan_remarks` */

DROP TABLE IF EXISTS `weekly_delivery_plan_remarks`;

CREATE TABLE `weekly_delivery_plan_remarks` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `schedule_no` varchar(25) DEFAULT NULL,
  `color_des` varchar(50) DEFAULT NULL,
  `size_ref` varchar(10) DEFAULT NULL,
  `ref_id` varchar(15) DEFAULT NULL,
  `planning_remarks` int(11) DEFAULT NULL,
  `commitments` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `ex_factory_date` date DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `weekly_delivery_status_finishing` */

DROP TABLE IF EXISTS `weekly_delivery_status_finishing`;

CREATE TABLE `weekly_delivery_status_finishing` (
  `tid` double NOT NULL,
  `tran_tid` double NOT NULL,
  `buyer` varchar(50) NOT NULL,
  `style` varchar(50) NOT NULL,
  `schedule` double NOT NULL,
  `color` varchar(100) NOT NULL,
  `low_status` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `ex_fact` date NOT NULL,
  `log_time` longtext NOT NULL,
  `offered_status` tinytext NOT NULL,
  `dispatch_status` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Function  structure for function  `uExtractNumberFromString` */

/*!50003 DROP FUNCTION IF EXISTS `uExtractNumberFromString` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `uExtractNumberFromString`(in_string VARCHAR(50)) RETURNS varchar(30) CHARSET latin1
    DETERMINISTIC
BEGIN
    
DECLARE ctrNumber VARCHAR(50);
DECLARE finNumber VARCHAR(50) DEFAULT ' ';
DECLARE sChar VARCHAR(2);
DECLARE inti INTEGER DEFAULT 1;
DECLARE chk INTEGER DEFAULT 0;
IF LENGTH(in_string) > 0 THEN
myloop: WHILE(inti <= LENGTH(in_string)) DO
    SET sChar= SUBSTRING(in_string,inti,1);
    SET ctrNumber= FIND_IN_SET(sChar,'0,1,2,3,4,5,6,7,8,9');
    IF ctrNumber > 0 THEN
       SET finNumber=CONCAT(finNumber,sChar);
    ELSE
       SET finNumber=CONCAT(finNumber,'');
       SET chk=chk+1;
    END IF;
    
    IF chk>=2 then
	LEAVE myloop;
    END IF;
	    
    SET inti=inti+1;
END WHILE;
if finNumber=0 then
RETURN in_string;
else
RETURN CAST(finNumber AS SIGNED INTEGER) ;
END IF;
ELSE
  RETURN 0;
END IF;
    END */$$
DELIMITER ;

/*Table structure for table `bai_cut_to_ship_ref` */

DROP TABLE IF EXISTS `bai_cut_to_ship_ref`;

/*!50001 DROP VIEW IF EXISTS `bai_cut_to_ship_ref` */;
/*!50001 DROP TABLE IF EXISTS `bai_cut_to_ship_ref` */;

/*!50001 CREATE TABLE  `bai_cut_to_ship_ref`(
 `ship_tid` bigint(20) ,
 `tid` mediumint(9) ,
 `buyer_division` varchar(40) ,
 `ssc_code_new` varchar(200) ,
 `schedule_no` varchar(15) ,
 `color` varchar(50) ,
 `style` varchar(15) ,
 `ord_qty_new` mediumint(9) ,
 `ord_qty_new_old` decimal(41,0) ,
 `m3_ship_plan_ex_fact` date ,
 `ex_factory_date` date ,
 `rev_exfactory` date ,
 `ex_factory_date_new` date ,
 `output` bigint(17) ,
 `sections` varchar(14) ,
 `act_cut` mediumint(9) ,
 `act_in` mediumint(9) ,
 `act_fca` mediumint(9) ,
 `act_mca` mediumint(9) ,
 `act_fg` mediumint(9) ,
 `cart_pending` mediumint(9) ,
 `priority` mediumint(9) ,
 `ref_id` int(11) 
)*/;

/*Table structure for table `delivery_report_p1` */

DROP TABLE IF EXISTS `delivery_report_p1`;

/*!50001 DROP VIEW IF EXISTS `delivery_report_p1` */;
/*!50001 DROP TABLE IF EXISTS `delivery_report_p1` */;

/*!50001 CREATE TABLE  `delivery_report_p1`(
 `buyer_division` varchar(40) ,
 `mpo` varchar(30) ,
 `cpo` varchar(30) ,
 `order_no` varchar(10) ,
 `style` varchar(15) ,
 `schedule_no` varchar(15) ,
 `color` varchar(50) ,
 `ex_factory_date` date ,
 `MODE` varchar(5) ,
 `ssc_code` varchar(150) ,
 `embl_status` varchar(88) ,
 `xs` decimal(41,0) ,
 `s` decimal(41,0) ,
 `m` decimal(41,0) ,
 `l` decimal(41,0) ,
 `xl` decimal(41,0) ,
 `xxl` decimal(41,0) ,
 `xxxl` decimal(41,0) ,
 `s01` decimal(41,0) ,
 `s02` decimal(41,0) ,
 `s03` decimal(41,0) ,
 `s04` decimal(41,0) ,
 `s05` decimal(41,0) ,
 `s06` decimal(41,0) ,
 `s07` decimal(41,0) ,
 `s08` decimal(41,0) ,
 `s09` decimal(41,0) ,
 `s10` decimal(41,0) ,
 `s11` decimal(41,0) ,
 `s12` decimal(41,0) ,
 `s13` decimal(41,0) ,
 `s14` decimal(41,0) ,
 `s15` decimal(41,0) ,
 `s16` decimal(41,0) ,
 `s17` decimal(41,0) ,
 `s18` decimal(41,0) ,
 `s19` decimal(41,0) ,
 `s20` decimal(41,0) ,
 `s21` decimal(41,0) ,
 `s22` decimal(41,0) ,
 `s23` decimal(41,0) ,
 `s24` decimal(41,0) ,
 `s25` decimal(41,0) ,
 `s26` decimal(41,0) ,
 `s27` decimal(41,0) ,
 `s28` decimal(41,0) ,
 `s29` decimal(41,0) ,
 `s30` decimal(41,0) ,
 `s31` decimal(41,0) ,
 `s32` decimal(41,0) ,
 `s33` decimal(41,0) ,
 `s34` decimal(41,0) ,
 `s35` decimal(41,0) ,
 `s36` decimal(41,0) ,
 `s37` decimal(41,0) ,
 `s38` decimal(41,0) ,
 `s39` decimal(41,0) ,
 `s40` decimal(41,0) ,
 `s41` decimal(41,0) ,
 `s42` decimal(41,0) ,
 `s43` decimal(41,0) ,
 `s44` decimal(41,0) ,
 `s45` decimal(41,0) ,
 `s46` decimal(41,0) ,
 `s47` decimal(41,0) ,
 `s48` decimal(41,0) ,
 `s49` decimal(41,0) ,
 `s50` decimal(41,0) 
)*/;

/*Table structure for table `fastreact_plan_summary` */

DROP TABLE IF EXISTS `fastreact_plan_summary`;

/*!50001 DROP VIEW IF EXISTS `fastreact_plan_summary` */;
/*!50001 DROP TABLE IF EXISTS `fastreact_plan_summary` */;

/*!50001 CREATE TABLE  `fastreact_plan_summary`(
 `group_code` varchar(20) ,
 `module` varchar(8) ,
 `style` varchar(130) ,
 `order_code` varchar(300) ,
 `color` varchar(200) ,
 `smv` double ,
 `delivery_date` date ,
 `schedule` varchar(300) ,
 `production_date` date ,
 `qty` double ,
 `tid` bigint(20) ,
 `week_code` int(11) ,
 `status` int(11) ,
 `execution` text ,
 `production_start` date 
)*/;

/*Table structure for table `shipment_plan_ref` */

DROP TABLE IF EXISTS `shipment_plan_ref`;

/*!50001 DROP VIEW IF EXISTS `shipment_plan_ref` */;
/*!50001 DROP TABLE IF EXISTS `shipment_plan_ref` */;

/*!50001 CREATE TABLE  `shipment_plan_ref`(
 `order_no` varchar(10) ,
 `delivery_no` varchar(10) ,
 `del_status` varchar(2) ,
 `mpo` varchar(30) ,
 `cpo` varchar(30) ,
 `buyer` varchar(36) ,
 `product` varchar(40) ,
 `buyer_division` varchar(40) ,
 `style` varchar(15) ,
 `schedule_no` varchar(15) ,
 `color` varchar(50) ,
 `size` varchar(15) ,
 `z_feature` varchar(15) ,
 `ord_qty` bigint(20) ,
 `ex_factory_date` date ,
 `mode` varchar(5) ,
 `destination` varchar(10) ,
 `packing_method` varchar(6) ,
 `fob_price_per_piece` float ,
 `cm_value` float ,
 `ssc_code` varchar(150) ,
 `ship_tid` bigint(20) ,
 `week_code` tinyint(11) ,
 `status` tinyint(11) ,
 `ssc_code_new` varchar(200) ,
 `order_embl_a` tinyint(11) ,
 `order_embl_b` tinyint(11) ,
 `order_embl_c` tinyint(11) ,
 `order_embl_d` tinyint(11) ,
 `order_embl_e` tinyint(11) ,
 `order_embl_f` tinyint(11) ,
 `order_embl_g` tinyint(11) ,
 `order_embl_h` tinyint(11) ,
 `ord_qty_new` decimal(41,0) 
)*/;

/*Table structure for table `week_delivery_plan_ref` */

DROP TABLE IF EXISTS `week_delivery_plan_ref`;

/*!50001 DROP VIEW IF EXISTS `week_delivery_plan_ref` */;
/*!50001 DROP TABLE IF EXISTS `week_delivery_plan_ref` */;

/*!50001 CREATE TABLE  `week_delivery_plan_ref`(
 `ship_tid` bigint(20) ,
 `tid` mediumint(9) ,
 `buyer_division` varchar(40) ,
 `schedule_no` varchar(15) ,
 `color` varchar(50) ,
 `style` varchar(15) ,
 `ord_qty_new` mediumint(9) ,
 `ord_qty_new_old` decimal(41,0) ,
 `m3_ship_plan_ex_fact` date ,
 `ex_factory_date` date ,
 `rev_exfactory` date ,
 `ex_factory_date_new` date ,
 `output` bigint(17) ,
 `act_cut` mediumint(9) ,
 `act_in` mediumint(9) ,
 `act_fca` mediumint(9) ,
 `act_mca` mediumint(9) ,
 `act_fg` mediumint(9) ,
 `act_ship` mediumint(9) ,
 `cart_pending` mediumint(9) ,
 `priority` mediumint(9) ,
 `ref_id` int(11) ,
 `act_exfact` date ,
 `act_rej` int(11) 
)*/;

/*View structure for view bai_cut_to_ship_ref */

/*!50001 DROP TABLE IF EXISTS `bai_cut_to_ship_ref` */;
/*!50001 DROP VIEW IF EXISTS `bai_cut_to_ship_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bai_cut_to_ship_ref` AS (select `shipment_plan_ref`.`ship_tid` AS `ship_tid`,`week_delivery_plan`.`tid` AS `tid`,`shipment_plan_ref`.`buyer_division` AS `buyer_division`,`shipment_plan_ref`.`ssc_code_new` AS `ssc_code_new`,`shipment_plan_ref`.`schedule_no` AS `schedule_no`,`shipment_plan_ref`.`color` AS `color`,`shipment_plan_ref`.`style` AS `style`,`week_delivery_plan`.`original_order_qty` AS `ord_qty_new`,`shipment_plan_ref`.`ord_qty_new` AS `ord_qty_new_old`,`shipment_plan_ref`.`ex_factory_date` AS `m3_ship_plan_ex_fact`,`week_delivery_plan`.`act_exfact` AS `ex_factory_date`,`week_delivery_plan`.`rev_exfactory` AS `rev_exfactory`,if((`week_delivery_plan`.`rev_exfactory` = '0000-00-00'),`week_delivery_plan`.`act_exfact`,`week_delivery_plan`.`rev_exfactory`) AS `ex_factory_date_new`,((((((((`week_delivery_plan`.`actu_sec1` + `week_delivery_plan`.`actu_sec2`) + `week_delivery_plan`.`actu_sec3`) + `week_delivery_plan`.`actu_sec4`) + `week_delivery_plan`.`actu_sec5`) + `week_delivery_plan`.`actu_sec6`) + `week_delivery_plan`.`actu_sec7`) + `week_delivery_plan`.`actu_sec8`) + `week_delivery_plan`.`actu_sec9`) AS `output`,concat(if((`week_delivery_plan`.`actu_sec1` > 0),'1,',''),if((`week_delivery_plan`.`actu_sec2` > 0),'2,',''),if((`week_delivery_plan`.`actu_sec3` > 0),'3,',''),if((`week_delivery_plan`.`actu_sec4` > 0),'4,',''),if((`week_delivery_plan`.`actu_sec5` > 0),'5,',''),if((`week_delivery_plan`.`actu_sec6` > 0),'6,',''),if((`week_delivery_plan`.`actu_sec7` > 0),'7,','')) AS `sections`,`week_delivery_plan`.`act_cut` AS `act_cut`,`week_delivery_plan`.`act_in` AS `act_in`,`week_delivery_plan`.`act_fca` AS `act_fca`,`week_delivery_plan`.`act_mca` AS `act_mca`,`week_delivery_plan`.`act_fg` AS `act_fg`,`week_delivery_plan`.`cart_pending` AS `cart_pending`,`week_delivery_plan`.`priority` AS `priority`,`week_delivery_plan`.`ref_id` AS `ref_id` from (`week_delivery_plan` left join `shipment_plan_ref` on((`week_delivery_plan`.`shipment_plan_id` = `shipment_plan_ref`.`ship_tid`)))) */;

/*View structure for view delivery_report_p1 */

/*!50001 DROP TABLE IF EXISTS `delivery_report_p1` */;
/*!50001 DROP VIEW IF EXISTS `delivery_report_p1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `delivery_report_p1` AS (select `shipment_plan`.`buyer_division` AS `buyer_division`,`shipment_plan`.`mpo` AS `mpo`,`shipment_plan`.`cpo` AS `cpo`,`shipment_plan`.`order_no` AS `order_no`,`shipment_plan`.`style` AS `style`,`shipment_plan`.`schedule_no` AS `schedule_no`,`shipment_plan`.`color` AS `color`,`shipment_plan`.`ex_factory_date` AS `ex_factory_date`,`shipment_plan`.`mode` AS `MODE`,`shipment_plan`.`ssc_code` AS `ssc_code`,concat(`shipment_plan`.`order_embl_a`,`shipment_plan`.`order_embl_b`,`shipment_plan`.`order_embl_c`,`shipment_plan`.`order_embl_d`,`shipment_plan`.`order_embl_e`,`shipment_plan`.`order_embl_f`,`shipment_plan`.`order_embl_g`,`shipment_plan`.`order_embl_h`) AS `embl_status`,sum(if((`shipment_plan`.`size` = 'size_xs'),`shipment_plan`.`ord_qty`,0)) AS `xs`,sum(if((`shipment_plan`.`size` = 'size_s'),`shipment_plan`.`ord_qty`,0)) AS `s`,sum(if((`shipment_plan`.`size` = 'size_m'),`shipment_plan`.`ord_qty`,0)) AS `m`,sum(if((`shipment_plan`.`size` = 'size_l'),`shipment_plan`.`ord_qty`,0)) AS `l`,sum(if((`shipment_plan`.`size` = 'size_xl'),`shipment_plan`.`ord_qty`,0)) AS `xl`,sum(if((`shipment_plan`.`size` = 'size_xxl'),`shipment_plan`.`ord_qty`,0)) AS `xxl`,sum(if((`shipment_plan`.`size` = 'size_xxxl'),`shipment_plan`.`ord_qty`,0)) AS `xxxl`,sum(if((`shipment_plan`.`size` = 'size_s01'),`shipment_plan`.`ord_qty`,0)) AS `s01`,sum(if((`shipment_plan`.`size` = 'size_s02'),`shipment_plan`.`ord_qty`,0)) AS `s02`,sum(if((`shipment_plan`.`size` = 'size_s03'),`shipment_plan`.`ord_qty`,0)) AS `s03`,sum(if((`shipment_plan`.`size` = 'size_s04'),`shipment_plan`.`ord_qty`,0)) AS `s04`,sum(if((`shipment_plan`.`size` = 'size_s05'),`shipment_plan`.`ord_qty`,0)) AS `s05`,sum(if((`shipment_plan`.`size` = 'size_s06'),`shipment_plan`.`ord_qty`,0)) AS `s06`,sum(if((`shipment_plan`.`size` = 'size_s07'),`shipment_plan`.`ord_qty`,0)) AS `s07`,sum(if((`shipment_plan`.`size` = 'size_s08'),`shipment_plan`.`ord_qty`,0)) AS `s08`,sum(if((`shipment_plan`.`size` = 'size_s09'),`shipment_plan`.`ord_qty`,0)) AS `s09`,sum(if((`shipment_plan`.`size` = 'size_s10'),`shipment_plan`.`ord_qty`,0)) AS `s10`,sum(if((`shipment_plan`.`size` = 'size_s11'),`shipment_plan`.`ord_qty`,0)) AS `s11`,sum(if((`shipment_plan`.`size` = 'size_s12'),`shipment_plan`.`ord_qty`,0)) AS `s12`,sum(if((`shipment_plan`.`size` = 'size_s13'),`shipment_plan`.`ord_qty`,0)) AS `s13`,sum(if((`shipment_plan`.`size` = 'size_s14'),`shipment_plan`.`ord_qty`,0)) AS `s14`,sum(if((`shipment_plan`.`size` = 'size_s15'),`shipment_plan`.`ord_qty`,0)) AS `s15`,sum(if((`shipment_plan`.`size` = 'size_s16'),`shipment_plan`.`ord_qty`,0)) AS `s16`,sum(if((`shipment_plan`.`size` = 'size_s17'),`shipment_plan`.`ord_qty`,0)) AS `s17`,sum(if((`shipment_plan`.`size` = 'size_s18'),`shipment_plan`.`ord_qty`,0)) AS `s18`,sum(if((`shipment_plan`.`size` = 'size_s19'),`shipment_plan`.`ord_qty`,0)) AS `s19`,sum(if((`shipment_plan`.`size` = 'size_s20'),`shipment_plan`.`ord_qty`,0)) AS `s20`,sum(if((`shipment_plan`.`size` = 'size_s21'),`shipment_plan`.`ord_qty`,0)) AS `s21`,sum(if((`shipment_plan`.`size` = 'size_s22'),`shipment_plan`.`ord_qty`,0)) AS `s22`,sum(if((`shipment_plan`.`size` = 'size_s23'),`shipment_plan`.`ord_qty`,0)) AS `s23`,sum(if((`shipment_plan`.`size` = 'size_s24'),`shipment_plan`.`ord_qty`,0)) AS `s24`,sum(if((`shipment_plan`.`size` = 'size_s25'),`shipment_plan`.`ord_qty`,0)) AS `s25`,sum(if((`shipment_plan`.`size` = 'size_s26'),`shipment_plan`.`ord_qty`,0)) AS `s26`,sum(if((`shipment_plan`.`size` = 'size_s27'),`shipment_plan`.`ord_qty`,0)) AS `s27`,sum(if((`shipment_plan`.`size` = 'size_s28'),`shipment_plan`.`ord_qty`,0)) AS `s28`,sum(if((`shipment_plan`.`size` = 'size_s29'),`shipment_plan`.`ord_qty`,0)) AS `s29`,sum(if((`shipment_plan`.`size` = 'size_s30'),`shipment_plan`.`ord_qty`,0)) AS `s30`,sum(if((`shipment_plan`.`size` = 'size_s31'),`shipment_plan`.`ord_qty`,0)) AS `s31`,sum(if((`shipment_plan`.`size` = 'size_s32'),`shipment_plan`.`ord_qty`,0)) AS `s32`,sum(if((`shipment_plan`.`size` = 'size_s33'),`shipment_plan`.`ord_qty`,0)) AS `s33`,sum(if((`shipment_plan`.`size` = 'size_s34'),`shipment_plan`.`ord_qty`,0)) AS `s34`,sum(if((`shipment_plan`.`size` = 'size_s35'),`shipment_plan`.`ord_qty`,0)) AS `s35`,sum(if((`shipment_plan`.`size` = 'size_s36'),`shipment_plan`.`ord_qty`,0)) AS `s36`,sum(if((`shipment_plan`.`size` = 'size_s37'),`shipment_plan`.`ord_qty`,0)) AS `s37`,sum(if((`shipment_plan`.`size` = 'size_s38'),`shipment_plan`.`ord_qty`,0)) AS `s38`,sum(if((`shipment_plan`.`size` = 'size_s39'),`shipment_plan`.`ord_qty`,0)) AS `s39`,sum(if((`shipment_plan`.`size` = 'size_s40'),`shipment_plan`.`ord_qty`,0)) AS `s40`,sum(if((`shipment_plan`.`size` = 'size_s41'),`shipment_plan`.`ord_qty`,0)) AS `s41`,sum(if((`shipment_plan`.`size` = 'size_s42'),`shipment_plan`.`ord_qty`,0)) AS `s42`,sum(if((`shipment_plan`.`size` = 'size_s43'),`shipment_plan`.`ord_qty`,0)) AS `s43`,sum(if((`shipment_plan`.`size` = 'size_s44'),`shipment_plan`.`ord_qty`,0)) AS `s44`,sum(if((`shipment_plan`.`size` = 'size_s45'),`shipment_plan`.`ord_qty`,0)) AS `s45`,sum(if((`shipment_plan`.`size` = 'size_s46'),`shipment_plan`.`ord_qty`,0)) AS `s46`,sum(if((`shipment_plan`.`size` = 'size_s47'),`shipment_plan`.`ord_qty`,0)) AS `s47`,sum(if((`shipment_plan`.`size` = 'size_s48'),`shipment_plan`.`ord_qty`,0)) AS `s48`,sum(if((`shipment_plan`.`size` = 'size_s49'),`shipment_plan`.`ord_qty`,0)) AS `s49`,sum(if((`shipment_plan`.`size` = 'size_s50'),`shipment_plan`.`ord_qty`,0)) AS `s50` from `shipment_plan` where ((left(`shipment_plan`.`style`,1) in ('K','P','L','O','D','M')) and `shipment_plan`.`schedule_no` in (select distinct `fastreact_plan`.`schedule` AS `SCHEDULE` from `fastreact_plan`)) group by `shipment_plan`.`ssc_code`) */;

/*View structure for view fastreact_plan_summary */

/*!50001 DROP TABLE IF EXISTS `fastreact_plan_summary` */;
/*!50001 DROP VIEW IF EXISTS `fastreact_plan_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fastreact_plan_summary` AS (select `fastreact_plan`.`group_code` AS `group_code`,`fastreact_plan`.`module` AS `module`,`fastreact_plan`.`style` AS `style`,`fastreact_plan`.`order_code` AS `order_code`,`fastreact_plan`.`color` AS `color`,`fastreact_plan`.`smv` AS `smv`,`fastreact_plan`.`delivery_date` AS `delivery_date`,`fastreact_plan`.`schedule` AS `schedule`,`fastreact_plan`.`production_date` AS `production_date`,`fastreact_plan`.`qty` AS `qty`,`fastreact_plan`.`tid` AS `tid`,`fastreact_plan`.`week_code` AS `week_code`,`fastreact_plan`.`status` AS `status`,group_concat(distinct `fastreact_plan`.`module` order by `fastreact_plan`.`module` ASC separator ',') AS `execution`,min(`fastreact_plan`.`production_date`) AS `production_start` from `fastreact_plan` group by `fastreact_plan`.`schedule`) */;

/*View structure for view shipment_plan_ref */

/*!50001 DROP TABLE IF EXISTS `shipment_plan_ref` */;
/*!50001 DROP VIEW IF EXISTS `shipment_plan_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `shipment_plan_ref` AS (select `shipment_plan`.`order_no` AS `order_no`,`shipment_plan`.`delivery_no` AS `delivery_no`,`shipment_plan`.`del_status` AS `del_status`,`shipment_plan`.`mpo` AS `mpo`,`shipment_plan`.`cpo` AS `cpo`,`shipment_plan`.`buyer` AS `buyer`,`shipment_plan`.`product` AS `product`,`shipment_plan`.`buyer_division` AS `buyer_division`,`shipment_plan`.`style` AS `style`,`shipment_plan`.`schedule_no` AS `schedule_no`,`shipment_plan`.`color` AS `color`,`shipment_plan`.`size` AS `size`,`shipment_plan`.`z_feature` AS `z_feature`,`shipment_plan`.`ord_qty` AS `ord_qty`,`shipment_plan`.`ex_factory_date` AS `ex_factory_date`,`shipment_plan`.`mode` AS `mode`,`shipment_plan`.`destination` AS `destination`,`shipment_plan`.`packing_method` AS `packing_method`,`shipment_plan`.`fob_price_per_piece` AS `fob_price_per_piece`,`shipment_plan`.`cm_value` AS `cm_value`,`shipment_plan`.`ssc_code` AS `ssc_code`,`shipment_plan`.`ship_tid` AS `ship_tid`,`shipment_plan`.`week_code` AS `week_code`,`shipment_plan`.`status` AS `status`,`shipment_plan`.`ssc_code_new` AS `ssc_code_new`,`shipment_plan`.`order_embl_a` AS `order_embl_a`,`shipment_plan`.`order_embl_b` AS `order_embl_b`,`shipment_plan`.`order_embl_c` AS `order_embl_c`,`shipment_plan`.`order_embl_d` AS `order_embl_d`,`shipment_plan`.`order_embl_e` AS `order_embl_e`,`shipment_plan`.`order_embl_f` AS `order_embl_f`,`shipment_plan`.`order_embl_g` AS `order_embl_g`,`shipment_plan`.`order_embl_h` AS `order_embl_h`,sum(`shipment_plan`.`ord_qty`) AS `ord_qty_new` from `shipment_plan` group by concat(`shipment_plan`.`ssc_code_new`,`shipment_plan`.`delivery_no`,`shipment_plan`.`cw_check`)) */;

/*View structure for view week_delivery_plan_ref */

/*!50001 DROP TABLE IF EXISTS `week_delivery_plan_ref` */;
/*!50001 DROP VIEW IF EXISTS `week_delivery_plan_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `week_delivery_plan_ref` AS (select `shipment_plan_ref`.`ship_tid` AS `ship_tid`,`week_delivery_plan`.`tid` AS `tid`,`shipment_plan_ref`.`buyer_division` AS `buyer_division`,`shipment_plan_ref`.`schedule_no` AS `schedule_no`,`shipment_plan_ref`.`color` AS `color`,`shipment_plan_ref`.`style` AS `style`,`week_delivery_plan`.`original_order_qty` AS `ord_qty_new`,`shipment_plan_ref`.`ord_qty_new` AS `ord_qty_new_old`,`shipment_plan_ref`.`ex_factory_date` AS `m3_ship_plan_ex_fact`,`shipment_plan_ref`.`ex_factory_date` AS `ex_factory_date`,`week_delivery_plan`.`rev_exfactory` AS `rev_exfactory`,if((`week_delivery_plan`.`rev_exfactory` = '0000-00-00'),`week_delivery_plan`.`act_exfact`,`week_delivery_plan`.`rev_exfactory`) AS `ex_factory_date_new`,((((((((`week_delivery_plan`.`actu_sec1` + `week_delivery_plan`.`actu_sec2`) + `week_delivery_plan`.`actu_sec3`) + `week_delivery_plan`.`actu_sec4`) + `week_delivery_plan`.`actu_sec5`) + `week_delivery_plan`.`actu_sec6`) + `week_delivery_plan`.`actu_sec7`) + `week_delivery_plan`.`actu_sec8`) + `week_delivery_plan`.`actu_sec9`) AS `output`,`week_delivery_plan`.`act_cut` AS `act_cut`,`week_delivery_plan`.`act_in` AS `act_in`,`week_delivery_plan`.`act_fca` AS `act_fca`,`week_delivery_plan`.`act_mca` AS `act_mca`,`week_delivery_plan`.`act_fg` AS `act_fg`,`week_delivery_plan`.`act_ship` AS `act_ship`,`week_delivery_plan`.`cart_pending` AS `cart_pending`,`week_delivery_plan`.`priority` AS `priority`,`week_delivery_plan`.`ref_id` AS `ref_id`,`week_delivery_plan`.`act_exfact` AS `act_exfact`,`week_delivery_plan`.`act_rej` AS `act_rej` from (`week_delivery_plan` left join `shipment_plan_ref` on((`week_delivery_plan`.`shipment_plan_id` = `shipment_plan_ref`.`ship_tid`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
