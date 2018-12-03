/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_pro
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*USE `bai_pro`;*/

/*Table structure for table `bai_bac` */

DROP TABLE IF EXISTS `bai_pro`.`bai_bac`;

CREATE TABLE `bai_pro`.`bai_bac` (
  `log_no` varchar(8) NOT NULL,
  `log_sec` int(11) NOT NULL,
  `log_Qty` int(11) NOT NULL,
  `log_lastup` datetime NOT NULL,
  `log_date` date NOT NULL,
  `log_shift` varchar(5) NOT NULL,
  `log_style` varchar(20) NOT NULL,
  `log_remarks` varchar(200) NOT NULL,
  `log_stat` varchar(20) NOT NULL,
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`),
  KEY `log_no` (`log_no`),
  KEY `log_no_2` (`log_no`,`log_sec`,`log_lastup`,`log_date`,`log_shift`,`log_style`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_log` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log`;

CREATE TABLE `bai_pro`.`bai_log` (
  `tid` bigint(11) NOT NULL AUTO_INCREMENT,
  `bac_no` varchar(8) NOT NULL,
  `bac_sec` tinyint(1) unsigned NOT NULL,
  `bac_Qty` smallint(5) NOT NULL,
  `bac_lastup` datetime NOT NULL,
  `bac_date` date NOT NULL,
  `bac_shift` varchar(3) NOT NULL,
  `bac_style` varchar(19) NOT NULL,
  `bac_remarks` tinytext NOT NULL,
  `bac_stat` char(6) NOT NULL,
  `log_time` datetime NOT NULL,
  `division` varchar(7) NOT NULL,
  `buyer` tinytext NOT NULL,
  `delivery` bigint(11) NOT NULL,
  `size_xs` smallint(5) NOT NULL,
  `size_s` smallint(4) NOT NULL,
  `size_m` smallint(4) NOT NULL,
  `size_l` smallint(4) NOT NULL,
  `size_xl` smallint(4) NOT NULL,
  `size_xxl` smallint(3) NOT NULL,
  `size_xxxl` smallint(3) NOT NULL,
  `color` tinytext NOT NULL,
  `loguser` varchar(30) NOT NULL,
  `ims_doc_no` int(10) unsigned NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `smv` float NOT NULL,
  `ims_table_name` varchar(14) NOT NULL,
  `ims_tid` mediumint(5) unsigned NOT NULL,
  `ims_pro_ref` varchar(500) DEFAULT NULL COMMENT 'bundle,Op concat unique(bai_pro_ref)',
  `size_s01` smallint(4) NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) NOT NULL COMMENT 'Output Qty of size s02',
  `size_s03` smallint(4) NOT NULL COMMENT 'Output Qty of size \n\ns03',
  `size_s04` smallint(4) NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) NOT NULL COMMENT 'Output Qty of size s06',
  `size_s07` smallint(4) NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) NOT NULL COMMENT 'Output Qty of size s09',
  `size_s10` smallint(4) NOT NULL COMMENT 'Output Qty of size s10',
  `size_s11` smallint(4) NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) NOT NULL COMMENT 'Output Qty of size s13',
  `size_s14` smallint(4) NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) NOT NULL COMMENT 'Output Qty of size s16',
  `size_s17` smallint(4) NOT NULL COMMENT 'Output Qty of size s17',
  `size_s18` smallint(4) NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) NOT NULL COMMENT 'Output Qty of size s20',
  `size_s21` smallint(4) NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) NOT NULL COMMENT 'Output Qty of size s23',
  `size_s24` smallint(4) NOT NULL COMMENT 'Output Qty of size s24',
  `size_s25` smallint(4) NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) NOT NULL COMMENT 'Output Qty of size s27',
  `size_s28` smallint(4) NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) NOT NULL COMMENT 'Output Qty of size s30',
  `size_s31` smallint(4) NOT NULL COMMENT 'Output Qty of size s31',
  `size_s32` smallint(4) NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) NOT NULL COMMENT 'Output Qty of size s34',
  `size_s35` smallint(4) NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) NOT NULL COMMENT 'Output Qty of size s37',
  `size_s38` smallint(4) NOT NULL COMMENT 'Output Qty of size s38',
  `size_s39` smallint(4) NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) NOT NULL COMMENT 'Output Qty of size s41',
  `size_s42` smallint(4) NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) NOT NULL COMMENT 'Output Qty of size s44',
  `size_s45` smallint(4) NOT NULL COMMENT 'Output Qty of size s45',
  `size_s46` smallint(4) NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) NOT NULL COMMENT 'Output Qty of size s48',
  `size_s49` smallint(4) NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) NOT NULL COMMENT 'Output Qty of size s50',
  `jobno` smallint(4) NOT NULL,
  `ope_code` int(10) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`),
  KEY `ims_doc_no` (`ims_doc_no`),
  KEY `orders` (`delivery`)
) ENGINE=MyISAM AUTO_INCREMENT=42919 DEFAULT CHARSET=latin1;

/*Table structure for table `bai_log_backup` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log_backup`;

CREATE TABLE `bai_pro`.`bai_log_backup` (
  `tid` bigint(11) NOT NULL AUTO_INCREMENT,
  `bac_no` varchar(8) NOT NULL,
  `bac_sec` tinyint(1) unsigned NOT NULL,
  `bac_Qty` smallint(5) NOT NULL,
  `bac_lastup` datetime NOT NULL,
  `bac_date` date NOT NULL,
  `bac_shift` varchar(3) NOT NULL,
  `bac_style` varchar(19) NOT NULL,
  `bac_remarks` tinytext NOT NULL,
  `bac_stat` char(6) NOT NULL,
  `log_time` datetime NOT NULL,
  `division` varchar(7) NOT NULL,
  `buyer` tinytext NOT NULL,
  `delivery` bigint(11) NOT NULL,
  `size_xs` smallint(5) NOT NULL,
  `size_s` smallint(4) NOT NULL,
  `size_m` smallint(4) NOT NULL,
  `size_l` smallint(4) NOT NULL,
  `size_xl` smallint(4) NOT NULL,
  `size_xxl` smallint(3) NOT NULL,
  `size_xxxl` smallint(3) NOT NULL,
  `color` tinytext NOT NULL,
  `loguser` varchar(30) NOT NULL,
  `ims_doc_no` int(10) unsigned NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `smv` float NOT NULL,
  `ims_table_name` varchar(14) NOT NULL,
  `ims_tid` mediumint(5) unsigned NOT NULL,
  `ims_pro_ref` varchar(500) DEFAULT NULL COMMENT 'bundle,Op concat unique(bai_pro_ref)',
  `size_s01` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s02',
  `size_s03` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size \n\ns03',
  `size_s04` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s06',
  `size_s07` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s09',
  `size_s10` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s10',
  `size_s11` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s13',
  `size_s14` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s16',
  `size_s17` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s17',
  `size_s18` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s20',
  `size_s21` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s23',
  `size_s24` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s24',
  `size_s25` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s27',
  `size_s28` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s30',
  `size_s31` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s31',
  `size_s32` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s34',
  `size_s35` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s37',
  `size_s38` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s38',
  `size_s39` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s41',
  `size_s42` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s44',
  `size_s45` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s45',
  `size_s46` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s48',
  `size_s49` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s50',
  `jobno` smallint(4) NOT NULL,
  `ope_code` int(10) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`),
  KEY `ims_doc_no` (`ims_doc_no`),
  KEY `orders` (`delivery`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_log_buf` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log_buf`;

CREATE TABLE `bai_pro`.`bai_log_buf` (
  `tid` bigint(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `bac_no` varchar(8) NOT NULL COMMENT 'Module No',
  `bac_sec` tinyint(1) unsigned NOT NULL COMMENT 'Section',
  `bac_Qty` smallint(5) NOT NULL COMMENT 'Output Qty',
  `bac_lastup` datetime NOT NULL COMMENT 'Last Output Updated time',
  `bac_date` date NOT NULL COMMENT 'Output Updated Date',
  `bac_shift` varchar(3) NOT NULL COMMENT 'Shift',
  `bac_style` varchar(19) NOT NULL COMMENT 'Style ',
  `bac_remarks` tinytext NOT NULL COMMENT 'Remarks',
  `bac_stat` char(6) NOT NULL COMMENT 'Module Status',
  `log_time` datetime NOT NULL COMMENT 'Output Reporting Time',
  `division` varchar(7) NOT NULL,
  `buyer` tinytext NOT NULL COMMENT 'Buyer Name',
  `delivery` bigint(11) NOT NULL COMMENT 'Schedule No',
  `size_xs` smallint(5) NOT NULL COMMENT 'Output Qty of xs',
  `size_s` smallint(4) NOT NULL COMMENT 'Output Qty of s',
  `size_m` smallint(4) NOT NULL COMMENT 'Output Qty of m',
  `size_l` smallint(4) NOT NULL COMMENT 'Output Qty of l',
  `size_xl` smallint(4) NOT NULL COMMENT 'Output Qty of xl',
  `size_xxl` smallint(3) NOT NULL COMMENT 'Output Qty of xxl',
  `size_xxxl` smallint(3) NOT NULL COMMENT 'Output Qty of xxxl',
  `color` varchar(500) NOT NULL COMMENT 'Color',
  `loguser` varchar(30) NOT NULL COMMENT 'Updated User',
  `ims_doc_no` int(10) unsigned NOT NULL COMMENT 'Docket No',
  `couple` tinyint(1) unsigned NOT NULL COMMENT 'Couple Module No',
  `nop` tinyint(2) unsigned NOT NULL COMMENT 'No of Operators',
  `smv` float NOT NULL COMMENT 'SMV',
  `ims_table_name` varchar(14) NOT NULL,
  `ims_tid` mediumint(5) unsigned NOT NULL COMMENT 'IMS unique id',
  `size_s01` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s02',
  `size_s03` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s03',
  `size_s04` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s06',
  `size_s07` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s09',
  `size_s10` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s10',
  `size_s11` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s13',
  `size_s14` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s16',
  `size_s17` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s17',
  `size_s18` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s20',
  `size_s21` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s23',
  `size_s24` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s24',
  `size_s25` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s27',
  `size_s28` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s30',
  `size_s31` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s31',
  `size_s32` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s34',
  `size_s35` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s37',
  `size_s38` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s38',
  `size_s39` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s41',
  `size_s42` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s44',
  `size_s45` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s45',
  `size_s46` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s48',
  `size_s49` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s50',
  `ims_pro_ref` varchar(500) NOT NULL,
  `jobno` varchar(25) NOT NULL COMMENT 'jobno',
  `ope_code` int(10) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `ims_doc_no` (`ims_doc_no`),
  KEY `bcip_sch_attain` (`bac_date`,`bac_no`,`delivery`,`color`(300))
) ENGINE=MyISAM AUTO_INCREMENT=42920 DEFAULT CHARSET=latin1;

/*Table structure for table `bai_log_buf_new_v1` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log_buf_new_v1`;

CREATE TABLE `bai_pro`.`bai_log_buf_new_v1` (
  `tid` bigint(11) NOT NULL AUTO_INCREMENT,
  `bac_no` varchar(8) NOT NULL,
  `bac_sec` tinyint(1) unsigned NOT NULL,
  `bac_Qty` smallint(4) unsigned NOT NULL,
  `bac_lastup` datetime NOT NULL,
  `bac_date` date NOT NULL,
  `bac_shift` char(1) NOT NULL,
  `bac_style` varchar(19) NOT NULL,
  `bac_remarks` char(0) NOT NULL,
  `bac_stat` char(0) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `division` tinytext NOT NULL,
  `buyer` tinytext NOT NULL,
  `delivery` bigint(11) unsigned NOT NULL,
  `size_xs` smallint(4) unsigned NOT NULL,
  `size_s` smallint(4) unsigned NOT NULL,
  `size_m` smallint(4) unsigned NOT NULL,
  `size_l` smallint(4) unsigned NOT NULL,
  `size_xl` smallint(3) unsigned NOT NULL,
  `size_xxl` tinyint(1) unsigned NOT NULL,
  `size_xxxl` tinyint(1) unsigned NOT NULL,
  `color` tinytext NOT NULL,
  `loguser` varchar(30) NOT NULL,
  `ims_doc_no` int(10) unsigned NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `smv` float NOT NULL,
  `ims_table_name` char(0) NOT NULL,
  `ims_tid` tinyint(1) unsigned NOT NULL,
  `size_s01` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s02',
  `size_s03` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s03',
  `size_s04` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s06',
  `size_s07` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s09',
  `size_s10` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s10',
  `size_s11` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s13',
  `size_s14` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s16',
  `size_s17` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s17',
  `size_s18` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s20',
  `size_s21` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s23',
  `size_s24` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s24',
  `size_s25` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s27',
  `size_s28` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s30',
  `size_s31` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s31',
  `size_s32` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s34',
  `size_s35` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s37',
  `size_s38` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s38',
  `size_s39` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s41',
  `size_s42` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s44',
  `size_s45` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s45',
  `size_s46` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s48',
  `size_s49` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s50',
  `jobno` varchar(25) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_log_buf_temp` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log_buf_temp`;

CREATE TABLE `bai_pro`.`bai_log_buf_temp` (
  `tid` bigint(11) NOT NULL AUTO_INCREMENT,
  `bac_no` varchar(8) NOT NULL,
  `bac_sec` tinyint(1) unsigned NOT NULL,
  `bac_Qty` smallint(4) unsigned NOT NULL,
  `bac_lastup` datetime NOT NULL,
  `bac_date` date NOT NULL,
  `bac_shift` char(1) NOT NULL,
  `bac_style` varchar(19) NOT NULL,
  `bac_remarks` char(3) NOT NULL,
  `bac_stat` char(6) NOT NULL,
  `log_time` datetime NOT NULL,
  `division` tinytext NOT NULL,
  `buyer` tinytext NOT NULL,
  `delivery` bigint(11) unsigned NOT NULL,
  `size_xs` smallint(4) unsigned NOT NULL,
  `size_s` smallint(4) unsigned NOT NULL,
  `size_m` smallint(4) unsigned NOT NULL,
  `size_l` smallint(4) unsigned NOT NULL,
  `size_xl` smallint(3) unsigned NOT NULL,
  `size_xxl` tinyint(2) unsigned NOT NULL,
  `size_xxxl` tinyint(1) unsigned NOT NULL,
  `color` tinytext NOT NULL,
  `loguser` varchar(30) NOT NULL,
  `ims_doc_no` int(10) unsigned NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `smv` float NOT NULL,
  `ims_table_name` char(7) NOT NULL,
  `ims_tid` mediumint(5) unsigned NOT NULL,
  `size_s01` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) unsigned NOT NULL COMMENT 'Output Qty \n\nof size s02',
  `size_s03` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s03',
  `size_s04` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s06',
  `size_s07` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s09',
  `size_s10` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s10',
  `size_s11` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s13',
  `size_s14` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s16',
  `size_s17` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s17',
  `size_s18` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s20',
  `size_s21` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s23',
  `size_s24` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s24',
  `size_s25` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s27',
  `size_s28` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s30',
  `size_s31` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s31',
  `size_s32` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s34',
  `size_s35` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s37',
  `size_s38` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s38',
  `size_s39` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s41',
  `size_s42` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s44',
  `size_s45` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s45',
  `size_s46` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s48',
  `size_s49` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s50',
  `ims_pro_ref` varchar(500) NOT NULL,
  `jobno` varchar(25) NOT NULL COMMENT 'jobno',
  PRIMARY KEY (`tid`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_log_buf_temp2` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log_buf_temp2`;

CREATE TABLE `bai_pro`.`bai_log_buf_temp2` (
  `tid` bigint(11) NOT NULL AUTO_INCREMENT,
  `bac_no` varchar(8) NOT NULL,
  `bac_sec` tinyint(1) unsigned NOT NULL,
  `bac_Qty` smallint(4) unsigned NOT NULL,
  `bac_lastup` datetime NOT NULL,
  `bac_date` date NOT NULL,
  `bac_shift` enum('A') NOT NULL,
  `bac_style` varchar(19) NOT NULL,
  `bac_remarks` char(3) NOT NULL,
  `bac_stat` char(6) NOT NULL,
  `log_time` datetime NOT NULL,
  `division` tinytext NOT NULL,
  `buyer` tinytext NOT NULL,
  `delivery` smallint(5) unsigned NOT NULL,
  `size_xs` smallint(4) unsigned NOT NULL,
  `size_s` smallint(4) unsigned NOT NULL,
  `size_m` smallint(4) unsigned NOT NULL,
  `size_l` smallint(4) unsigned NOT NULL,
  `size_xl` smallint(3) unsigned NOT NULL,
  `size_xxl` tinyint(2) unsigned NOT NULL,
  `size_xxxl` tinyint(1) unsigned NOT NULL,
  `color` tinytext NOT NULL,
  `loguser` varchar(30) NOT NULL,
  `ims_doc_no` int(10) unsigned NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `smv` float NOT NULL,
  `ims_table_name` char(7) NOT NULL,
  `ims_tid` mediumint(5) unsigned NOT NULL,
  `size_s01` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) unsigned NOT NULL COMMENT 'Output \n\nQty of size s02',
  `size_s03` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s03',
  `size_s04` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s06',
  `size_s07` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s09',
  `size_s10` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s10',
  `size_s11` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s13',
  `size_s14` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s16',
  `size_s17` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s17',
  `size_s18` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s20',
  `size_s21` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s23',
  `size_s24` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s24',
  `size_s25` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s27',
  `size_s28` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s30',
  `size_s31` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s31',
  `size_s32` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s34',
  `size_s35` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s37',
  `size_s38` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s38',
  `size_s39` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s41',
  `size_s42` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s44',
  `size_s45` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s45',
  `size_s46` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s48',
  `size_s49` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s50',
  `ims_pro_ref` varchar(500) NOT NULL,
  `jobno` varchar(25) NOT NULL COMMENT 'jobno',
  PRIMARY KEY (`tid`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_log_deleted` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log_deleted`;

CREATE TABLE `bai_pro`.`bai_log_deleted` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `bac_no` varchar(8) NOT NULL,
  `bac_sec` tinyint(1) unsigned NOT NULL,
  `bac_Qty` smallint(4) unsigned NOT NULL,
  `bac_lastup` datetime NOT NULL,
  `bac_date` date NOT NULL,
  `bac_shift` char(1) NOT NULL,
  `bac_style` varchar(19) NOT NULL,
  `bac_remarks` tinytext NOT NULL,
  `bac_stat` char(6) NOT NULL,
  `log_time` datetime NOT NULL,
  `division` tinytext NOT NULL,
  `buyer` tinytext NOT NULL,
  `delivery` bigint(11) NOT NULL,
  `size_xs` smallint(4) unsigned NOT NULL,
  `size_s` smallint(4) unsigned NOT NULL,
  `size_m` smallint(4) unsigned NOT NULL,
  `size_l` smallint(4) unsigned NOT NULL,
  `size_xl` smallint(3) unsigned NOT NULL,
  `size_xxl` tinyint(3) unsigned NOT NULL,
  `size_xxxl` tinyint(2) unsigned NOT NULL,
  `color` tinytext NOT NULL,
  `loguser` varchar(30) NOT NULL,
  `ims_doc_no` int(10) unsigned NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `smv` float NOT NULL,
  `ims_table_name` char(7) NOT NULL,
  `ims_tid` mediumint(5) unsigned NOT NULL,
  `size_s01` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) unsigned NOT NULL COMMENT 'Output \n\nQty of size s02',
  `size_s03` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s03',
  `size_s04` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s06',
  `size_s07` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s09',
  `size_s10` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s10',
  `size_s11` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s13',
  `size_s14` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s16',
  `size_s17` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s17',
  `size_s18` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s20',
  `size_s21` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s23',
  `size_s24` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s24',
  `size_s25` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s27',
  `size_s28` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s30',
  `size_s31` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s31',
  `size_s32` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s34',
  `size_s35` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s37',
  `size_s38` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s38',
  `size_s39` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s41',
  `size_s42` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s44',
  `size_s45` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s45',
  `size_s46` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s48',
  `size_s49` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s50',
  PRIMARY KEY (`tid`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_log_new_v1` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log_new_v1`;

CREATE TABLE `bai_pro`.`bai_log_new_v1` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` mediumint(7) unsigned NOT NULL,
  `module` varchar(8) NOT NULL,
  `team` char(1) NOT NULL,
  `rep_time` datetime NOT NULL,
  `updated_by` char(0) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `cart_id` (`cart_id`),
  UNIQUE KEY `cart_id_2` (`cart_id`),
  UNIQUE KEY `cart_id_3` (`cart_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_quality_log` */

DROP TABLE IF EXISTS `bai_pro`.`bai_quality_log`;

CREATE TABLE `bai_pro`.`bai_quality_log` (
  `tid` bigint(11) NOT NULL AUTO_INCREMENT,
  `bac_no` varchar(8) NOT NULL,
  `bac_sec` tinyint(1) unsigned NOT NULL,
  `bac_Qty` smallint(5) NOT NULL,
  `bac_lastup` datetime NOT NULL,
  `bac_date` date NOT NULL,
  `bac_shift` varchar(3) NOT NULL,
  `bac_style` varchar(19) NOT NULL,
  `bac_remarks` tinytext NOT NULL,
  `log_time` datetime NOT NULL,
  `buyer` tinytext NOT NULL,
  `delivery` varchar(15) NOT NULL,
  `color` tinytext NOT NULL,
  `loguser` varchar(30) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `bac_date` (`bac_date`,`bac_no`,`bac_lastup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_trim_log` */

DROP TABLE IF EXISTS `bai_pro`.`bai_trim_log`;

CREATE TABLE `bai_pro`.`bai_trim_log` (
  `tid` bigint(11) NOT NULL AUTO_INCREMENT,
  `bac_no` varchar(8) NOT NULL,
  `bac_sec` tinyint(1) unsigned NOT NULL,
  `bac_Qty` smallint(5) NOT NULL,
  `bac_lastup` datetime NOT NULL,
  `bac_date` date NOT NULL,
  `bac_shift` varchar(3) NOT NULL,
  `bac_style` varchar(19) NOT NULL,
  `bac_remarks` tinytext NOT NULL,
  `log_time` datetime NOT NULL,
  `buyer` tinytext NOT NULL,
  `delivery` varchar(15) NOT NULL,
  `color` tinytext NOT NULL,
  `loguser` varchar(30) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `bac_no2` (`bac_no`,`bac_sec`,`bac_lastup`),
  KEY `bac_no` (`bac_no`,`bac_sec`,`bac_lastup`,`bac_date`,`bac_shift`,`bac_style`),
  KEY `bac_date` (`bac_date`,`bac_no`,`bac_lastup`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `down_deps` */

DROP TABLE IF EXISTS `bai_pro`.`down_deps`;

CREATE TABLE `bai_pro`.`down_deps` (
  `dep_id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(200) NOT NULL,
  PRIMARY KEY (`dep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

/*Table structure for table `down_log` */

DROP TABLE IF EXISTS `bai_pro`.`down_log`;

CREATE TABLE `bai_pro`.`down_log` (
  `mod_no` varchar(8) NOT NULL,
  `date` date NOT NULL,
  `department` tinyint(2) unsigned NOT NULL,
  `remarks` tinytext NOT NULL,
  `style` varchar(13) NOT NULL,
  `dtime` float NOT NULL,
  `lastup` datetime NOT NULL,
  `shift` varchar(8) NOT NULL,
  `section` char(1) NOT NULL,
  `customer` varchar(12) NOT NULL,
  `schedule` varchar(11) NOT NULL,
  `source` tinyint(1) unsigned NOT NULL,
  `capture` tinyint(1) unsigned NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `plan_eff` int(11) NOT NULL DEFAULT 0,
  `nop` int(11) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `reason_code` int(11) NOT NULL,
  `updated_by` varchar(15) NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0- insert row,1- inserted in BEL DB',
  PRIMARY KEY (`tid`),
  KEY `mod_no` (`mod_no`,`date`,`department`,`style`,`lastup`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `down_log_changes` */

DROP TABLE IF EXISTS `bai_pro`.`down_log_changes`;

CREATE TABLE `bai_pro`.`down_log_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid_ref` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `operation` varchar(45) NOT NULL,
  `log_time` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `down_log_deleted` */

DROP TABLE IF EXISTS `bai_pro`.`down_log_deleted`;

CREATE TABLE `bai_pro`.`down_log_deleted` (
  `mod_no` varchar(8) NOT NULL,
  `date` date NOT NULL,
  `department` tinyint(2) unsigned NOT NULL,
  `remarks` tinytext NOT NULL,
  `style` varchar(13) NOT NULL,
  `dtime` float NOT NULL,
  `lastup` datetime NOT NULL,
  `shift` varchar(8) NOT NULL,
  `section` char(1) NOT NULL,
  `customer` varchar(12) NOT NULL,
  `schedule` varchar(11) NOT NULL,
  `source` tinyint(1) unsigned NOT NULL,
  `capture` tinyint(1) unsigned NOT NULL,
  `tid` int(11) NOT NULL,
  `plan_eff` int(11) NOT NULL DEFAULT 0,
  `nop` int(11) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `reason_code` int(11) NOT NULL,
  `updated_by` varchar(15) NOT NULL,
  `flag` tinyint(4) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `mod_no` (`mod_no`,`date`,`department`,`style`,`lastup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `down_log_temp` */

DROP TABLE IF EXISTS `bai_pro`.`down_log_temp`;

CREATE TABLE `bai_pro`.`down_log_temp` (
  `mod_no` tinyint(2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `department` tinyint(2) DEFAULT NULL,
  `remarks` blob DEFAULT NULL,
  `style` varchar(39) DEFAULT NULL,
  `dtime` float DEFAULT NULL,
  `lastup` datetime DEFAULT NULL,
  `shift` varchar(24) DEFAULT NULL,
  `section` varchar(3) DEFAULT NULL,
  `customer` varchar(12) DEFAULT NULL,
  `schedule` varchar(15) DEFAULT NULL,
  `source` tinyint(1) DEFAULT NULL,
  `capture` tinyint(1) DEFAULT NULL,
  `tid` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `down_reason` */

DROP TABLE IF EXISTS `bai_pro`.`down_reason`;

CREATE TABLE `bai_pro`.`down_reason` (
  `sno` double NOT NULL AUTO_INCREMENT,
  `dep_id` double NOT NULL DEFAULT 0,
  `down_machine` varchar(75) NOT NULL,
  `down_problem` varchar(75) NOT NULL,
  `down_reason` varchar(75) NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=410 DEFAULT CHARSET=latin1;

/*Table structure for table `grand_rep` */

DROP TABLE IF EXISTS `bai_pro`.`grand_rep`;

CREATE TABLE `bai_pro`.`grand_rep` (
  `date` date NOT NULL,
  `module` varchar(8) NOT NULL,
  `shift` varchar(3) NOT NULL,
  `section` tinyint(1) unsigned NOT NULL,
  `plan_out` float(11,0) NOT NULL,
  `act_out` smallint(4) unsigned NOT NULL,
  `plan_clh` float(11,2) NOT NULL,
  `act_clh` float(11,2) NOT NULL,
  `plan_sth` float(11,2) NOT NULL,
  `act_sth` float(11,2) NOT NULL,
  `tid` varchar(17) NOT NULL,
  `styles` varchar(26) NOT NULL,
  `buyer` varchar(50) NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `smv` float NOT NULL,
  `days` tinyint(1) unsigned NOT NULL,
  `max_style` varchar(50) NOT NULL,
  `max_out` smallint(4) unsigned NOT NULL,
  `jumpers` tinyint(1) unsigned NOT NULL,
  `absents` tinyint(1) unsigned NOT NULL,
  `others` varchar(14) NOT NULL COMMENT 'lace/quality/packing',
  `incentive` smallint(3) unsigned NOT NULL,
  `incentive_amount` smallint(6) NOT NULL,
  `rework_qty` int(11) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `date` (`date`),
  KEY `module_shift` (`date`,`module`,`shift`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `grand_rep_temp` */

DROP TABLE IF EXISTS `bai_pro`.`grand_rep_temp`;

CREATE TABLE `bai_pro`.`grand_rep_temp` (
  `date` date NOT NULL,
  `module` varchar(8) NOT NULL,
  `shift` varchar(3) NOT NULL,
  `section` tinyint(1) unsigned NOT NULL,
  `plan_out` float NOT NULL,
  `act_out` smallint(4) unsigned NOT NULL,
  `plan_clh` float NOT NULL,
  `act_clh` float NOT NULL,
  `plan_sth` float NOT NULL,
  `act_sth` float NOT NULL,
  `tid` varchar(17) NOT NULL,
  `styles` varchar(26) NOT NULL,
  `buyer` varchar(50) NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `smv` float NOT NULL,
  `days` tinyint(1) unsigned NOT NULL,
  `max_style` varchar(50) NOT NULL,
  `max_out` smallint(4) unsigned NOT NULL,
  `jumpers` tinyint(1) unsigned NOT NULL,
  `absents` tinyint(1) unsigned NOT NULL,
  `others` varchar(14) NOT NULL COMMENT 'lace/quality/packing',
  `incentive` smallint(3) unsigned NOT NULL,
  `incentive_amount` smallint(6) NOT NULL,
  `rework_qty` int(11) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `incentive_criteria` */

DROP TABLE IF EXISTS `bai_pro`.`incentive_criteria`;

CREATE TABLE `bai_pro`.`incentive_criteria` (
  `code` char(13) NOT NULL,
  `style` char(5) NOT NULL,
  `operators_match` tinyint(2) unsigned NOT NULL,
  `operation` char(4) NOT NULL,
  `additions` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `incentive_date_emp_cap` */

DROP TABLE IF EXISTS `bai_pro`.`incentive_date_emp_cap`;

CREATE TABLE `bai_pro`.`incentive_date_emp_cap` (
  `tid` varchar(300) NOT NULL,
  `module` varchar(30) NOT NULL,
  `team` varchar(15) NOT NULL,
  `emp_id` varchar(150) NOT NULL,
  `cader` varchar(600) NOT NULL,
  `amount` double NOT NULL,
  `inc_date` date NOT NULL,
  `payroll_month_year` varchar(300) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `log_user` varchar(300) NOT NULL,
  `status` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `incentive_date_emp_cap_summary` */

DROP TABLE IF EXISTS `bai_pro`.`incentive_date_emp_cap_summary`;

CREATE TABLE `bai_pro`.`incentive_date_emp_cap_summary` (
  `tid` varchar(300) NOT NULL,
  `module` varchar(270) DEFAULT NULL,
  `team` varchar(135) DEFAULT NULL,
  `emp_id` varchar(1350) DEFAULT NULL,
  `cader` varchar(5400) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `inc_date` date DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `log_user` varchar(2700) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `incentive_ladder` */

DROP TABLE IF EXISTS `bai_pro`.`incentive_ladder`;

CREATE TABLE `bai_pro`.`incentive_ladder` (
  `incent_code` varchar(30) NOT NULL,
  `module` varchar(8) NOT NULL,
  `style` tinytext NOT NULL,
  `plan_pcs` int(11) unsigned NOT NULL,
  `incent_per_hr` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `team` char(2) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`incent_code`),
  KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `incentive_module_status` */

DROP TABLE IF EXISTS `bai_pro`.`incentive_module_status`;

CREATE TABLE `bai_pro`.`incentive_module_status` (
  `tid` varchar(150) NOT NULL,
  `STATUS` double DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `incentive_process_daily_log` */

DROP TABLE IF EXISTS `bai_pro`.`incentive_process_daily_log`;

CREATE TABLE `bai_pro`.`incentive_process_daily_log` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `year` varchar(5) DEFAULT NULL,
  `month` varchar(5) DEFAULT NULL,
  `shift` varchar(3) DEFAULT NULL,
  `module` varchar(5) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime NOT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `incentive_process_daily_log_b` */

DROP TABLE IF EXISTS `bai_pro`.`incentive_process_daily_log_b`;

CREATE TABLE `bai_pro`.`incentive_process_daily_log_b` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `year` varchar(5) DEFAULT NULL,
  `month` varchar(5) DEFAULT NULL,
  `shift` varchar(3) DEFAULT NULL,
  `module` varchar(5) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime NOT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `incentive_process_log` */

DROP TABLE IF EXISTS `bai_pro`.`incentive_process_log`;

CREATE TABLE `bai_pro`.`incentive_process_log` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `team` varchar(3) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `incetive_emp_payroll` */

DROP TABLE IF EXISTS `bai_pro`.`incetive_emp_payroll`;

CREATE TABLE `bai_pro`.`incetive_emp_payroll` (
  `tid` varchar(105) NOT NULL,
  `module` double DEFAULT NULL,
  `team` varchar(12) DEFAULT NULL,
  `emp_id` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `month_year` varchar(60) DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `log_user` varchar(150) DEFAULT NULL,
  `status` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `jumper_allocation` */

DROP TABLE IF EXISTS `bai_pro`.`jumper_allocation`;

CREATE TABLE `bai_pro`.`jumper_allocation` (
  `date` date DEFAULT NULL,
  `tid` varchar(20) NOT NULL,
  `jumper_allocation` varchar(100) DEFAULT NULL,
  `module` tinyint(4) DEFAULT NULL,
  `section` tinyint(4) DEFAULT NULL,
  `team` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `layout_db` */

DROP TABLE IF EXISTS `bai_pro`.`layout_db`;

CREATE TABLE `bai_pro`.`layout_db` (
  `tid` char(14) NOT NULL,
  `sec` tinyint(1) unsigned NOT NULL,
  `shift` char(1) NOT NULL,
  `oprs` tinyint(3) unsigned NOT NULL,
  `abs_app` tinyint(2) unsigned NOT NULL,
  `abs_unapp` tinyint(2) unsigned NOT NULL,
  `turnover` tinyint(2) unsigned NOT NULL,
  `add_sub` tinyint(3) NOT NULL,
  `jumpers` tinyint(2) unsigned NOT NULL,
  `plan_pcs` mediumint(6) unsigned NOT NULL,
  `pro_sth` smallint(4) unsigned NOT NULL,
  `pro_downtime` smallint(4) unsigned NOT NULL,
  `date` date NOT NULL,
  `remarks` tinytext NOT NULL,
  `act_oprs` tinyint(3) unsigned DEFAULT NULL,
  `lay_pln_ie` tinyint(3) DEFAULT NULL,
  `pln_pcs_hr` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `sec` (`sec`,`shift`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `mate_columns` */

DROP TABLE IF EXISTS `bai_pro`.`mate_columns`;

CREATE TABLE `bai_pro`.`mate_columns` (
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

DROP TABLE IF EXISTS `bai_pro`.`members`;

CREATE TABLE `bai_pro`.`members` (
  `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `level` int(11) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `model_line` */

DROP TABLE IF EXISTS `bai_pro`.`model_line`;

CREATE TABLE `bai_pro`.`model_line` (
  `tid` int(11) NOT NULL,
  `module` varchar(10) DEFAULT NULL,
  `date` varchar(15) DEFAULT NULL,
  `base_eff` int(11) DEFAULT NULL,
  `target_eff` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `output_del_reason` */

DROP TABLE IF EXISTS `bai_pro`.`output_del_reason`;

CREATE TABLE `bai_pro`.`output_del_reason` (
  `sid` double NOT NULL,
  `reason` varchar(300) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_atten` */

DROP TABLE IF EXISTS `bai_pro`.`pro_atten`;

CREATE TABLE `bai_pro`.`pro_atten` (
  `atten_id` varchar(20) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `avail_A` tinyint(2) unsigned NOT NULL,
  `avail_B` tinyint(2) unsigned NOT NULL,
  `avail_C` tinyint(2) unsigned NOT NULL,
  `avail_G` tinyint(2) unsigned NOT NULL,
  `jumpers` tinyint(2) unsigned NOT NULL,
  `absent_A` tinyint(2) unsigned NOT NULL,
  `absent_B` tinyint(2) unsigned NOT NULL,
  `absent_C` tinyint(2) unsigned NOT NULL,
  `absent_G` tinyint(2) unsigned NOT NULL,
  `module` varchar(10) NOT NULL,
  `remarks` char(0) NOT NULL,
  PRIMARY KEY (`atten_id`),
  UNIQUE KEY `date_module` (`date`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_mod` */

DROP TABLE IF EXISTS `bai_pro`.`pro_mod`;

CREATE TABLE `bai_pro`.`pro_mod` (
  `ref_id` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mod_no` varchar(8) NOT NULL,
  `mod_sec` tinyint(1) unsigned NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_shift` char(1) NOT NULL,
  `mod_style` varchar(19) NOT NULL,
  `mod_remarks` tinytext NOT NULL,
  `mod_lqty` smallint(5) NOT NULL,
  `mod_lupdate` datetime NOT NULL,
  `mod_stat` char(6) NOT NULL,
  `division` varchar(5) NOT NULL,
  `color` tinytext NOT NULL,
  `buyer` varchar(7) NOT NULL,
  `delivery` varchar(11) NOT NULL,
  `size_xs` tinyint(1) unsigned NOT NULL,
  `size_s` tinyint(1) unsigned NOT NULL,
  `size_m` tinyint(1) unsigned NOT NULL,
  `size_l` tinyint(1) unsigned NOT NULL,
  `size_xl` tinyint(1) unsigned NOT NULL,
  `size_xxl` tinyint(1) unsigned NOT NULL,
  `size_xxxl` tinyint(1) unsigned NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `size_s01` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s02',
  `size_s03` smallint(4) unsigned NOT NULL COMMENT 'Output Qty \n\nof size s03',
  `size_s04` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s06',
  `size_s07` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s09',
  `size_s10` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s10',
  `size_s11` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s13',
  `size_s14` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s16',
  `size_s17` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s17',
  `size_s18` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s20',
  `size_s21` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s23',
  `size_s24` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s24',
  `size_s25` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s27',
  `size_s28` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s30',
  `size_s31` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s31',
  `size_s32` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s34',
  `size_s35` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s37',
  `size_s38` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s38',
  `size_s39` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s41',
  `size_s42` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s44',
  `size_s45` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of \n\nsize s45',
  `size_s46` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s48',
  `size_s49` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s50',
  PRIMARY KEY (`ref_id`),
  KEY `mod_no` (`mod_no`,`mod_sec`,`mod_date`,`mod_shift`,`mod_style`,`mod_lupdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `pro_mod_today` */

DROP TABLE IF EXISTS `bai_pro`.`pro_mod_today`;

CREATE TABLE `bai_pro`.`pro_mod_today` (
  `ref_id` varchar(50) NOT NULL,
  `mod_no` varchar(8) NOT NULL,
  `mod_sec` tinyint(1) unsigned NOT NULL,
  `mod_date` datetime NOT NULL,
  `mod_shift` char(1) NOT NULL,
  `mod_style` char(5) NOT NULL,
  `mod_remarks` char(3) NOT NULL,
  `mod_lqty` tinyint(1) unsigned NOT NULL,
  `mod_lupdate` datetime NOT NULL,
  `mod_stat` char(6) NOT NULL,
  `division` char(0) NOT NULL,
  `color` tinytext NOT NULL,
  `buyer` char(7) NOT NULL,
  `delivery` smallint(5) unsigned NOT NULL,
  `size_xs` tinyint(1) unsigned NOT NULL,
  `size_s` tinyint(1) unsigned NOT NULL,
  `size_m` tinyint(1) unsigned NOT NULL,
  `size_l` tinyint(1) unsigned NOT NULL,
  `size_xl` tinyint(1) unsigned NOT NULL,
  `size_xxl` tinyint(1) unsigned NOT NULL,
  `size_xxxl` tinyint(1) unsigned NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `size_s01` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s01',
  `size_s02` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s02',
  `size_s03` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size \n\ns03',
  `size_s04` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s04',
  `size_s05` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s05',
  `size_s06` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s06',
  `size_s07` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s07',
  `size_s08` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s08',
  `size_s09` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s09',
  `size_s10` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s10',
  `size_s11` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s11',
  `size_s12` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s12',
  `size_s13` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s13',
  `size_s14` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s14',
  `size_s15` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s15',
  `size_s16` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s16',
  `size_s17` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s17',
  `size_s18` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s18',
  `size_s19` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s19',
  `size_s20` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s20',
  `size_s21` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s21',
  `size_s22` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s22',
  `size_s23` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s23',
  `size_s24` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s24',
  `size_s25` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s25',
  `size_s26` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s26',
  `size_s27` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s27',
  `size_s28` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s28',
  `size_s29` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s29',
  `size_s30` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s30',
  `size_s31` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s31',
  `size_s32` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s32',
  `size_s33` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s33',
  `size_s34` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s34',
  `size_s35` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s35',
  `size_s36` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s36',
  `size_s37` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s37',
  `size_s38` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s38',
  `size_s39` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s39',
  `size_s40` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s40',
  `size_s41` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s41',
  `size_s42` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s42',
  `size_s43` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s43',
  `size_s44` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s44',
  `size_s45` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s45',
  `size_s46` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s46',
  `size_s47` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s47',
  `size_s48` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s48',
  `size_s49` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s49',
  `size_s50` smallint(4) unsigned NOT NULL COMMENT 'Output Qty of size s50',
  PRIMARY KEY (`ref_id`),
  KEY `mod_no` (`mod_no`,`mod_sec`,`mod_date`,`mod_shift`,`mod_style`,`mod_lupdate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_plan` */

DROP TABLE IF EXISTS `bai_pro`.`pro_plan`;

CREATE TABLE `bai_pro`.`pro_plan` (
  `plan_tag` varchar(19) NOT NULL,
  `date` date NOT NULL COMMENT 'Date',
  `mod_no` varchar(8) NOT NULL COMMENT 'Module No',
  `shift` char(2) NOT NULL COMMENT 'Shift',
  `plan_eff` float NOT NULL COMMENT 'Plan Efficiency',
  `plan_pro` float NOT NULL COMMENT 'Production Plan Qty',
  `remarks` varchar(52) NOT NULL COMMENT 'Remarks',
  `sec_no` tinyint(1) unsigned NOT NULL COMMENT 'Section No',
  `act_hours` float NOT NULL COMMENT 'Actual Hours',
  `couple` tinyint(1) unsigned NOT NULL COMMENT 'Couple Module',
  `fix_nop` int(11) NOT NULL COMMENT 'Fixed NOP',
  `plan_clh` float(11,2) NOT NULL COMMENT 'Plan Clock',
  `plan_sah` float(11,2) NOT NULL COMMENT 'Plan SAH',
  `plan_eff_ex` float(11,2) NOT NULL,
  PRIMARY KEY (`plan_tag`),
  KEY `date` (`date`,`mod_no`,`shift`,`sec_no`),
  KEY `date_key` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `pro_plan_today` */

DROP TABLE IF EXISTS `bai_pro`.`pro_plan_today`;

CREATE TABLE `bai_pro`.`pro_plan_today` (
  `plan_tag` varchar(50) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `mod_no` varchar(8) NOT NULL,
  `shift` char(1) NOT NULL,
  `plan_eff` tinyint(3) unsigned NOT NULL,
  `plan_pro` smallint(4) unsigned NOT NULL,
  `remarks` char(3) NOT NULL,
  `sec_no` tinyint(1) unsigned NOT NULL,
  `act_hours` float NOT NULL,
  `couple` tinyint(1) unsigned NOT NULL,
  `fix_nop` int(11) NOT NULL COMMENT 'Fixed NOP',
  `plan_clh` float(11,2) NOT NULL COMMENT 'Plan Clock',
  `plan_sah` float(11,2) NOT NULL COMMENT 'Plan SAH',
  `plan_eff_ex` float(11,2) NOT NULL,
  PRIMARY KEY (`plan_tag`),
  KEY `date` (`date`,`mod_no`,`shift`,`sec_no`),
  KEY `date_key` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_quality` */

DROP TABLE IF EXISTS `bai_pro`.`pro_quality`;

CREATE TABLE `bai_pro`.`pro_quality` (
  `quality_id` char(30) NOT NULL,
  `module` varchar(8) NOT NULL,
  `date` date NOT NULL,
  `rew_A` int(11) NOT NULL,
  `rew_B` int(11) NOT NULL,
  `auf_A` int(10) unsigned NOT NULL,
  `auf_B` int(10) unsigned NOT NULL,
  PRIMARY KEY (`quality_id`),
  KEY `module` (`module`,`date`),
  KEY `date_key` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pro_sec_db` */

DROP TABLE IF EXISTS `bai_pro`.`pro_sec_db`;

CREATE TABLE `bai_pro`.`pro_sec_db` (
  `sec_no` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `sec_head` varchar(15) NOT NULL,
  `sec_team` char(0) DEFAULT NULL,
  PRIMARY KEY (`sec_no`),
  KEY `sec_no` (`sec_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `pro_style` */

DROP TABLE IF EXISTS `bai_pro`.`pro_style`;

CREATE TABLE `bai_pro`.`pro_style` (
  `sno` varchar(30) NOT NULL COMMENT 'Serial No',
  `style` varchar(25) NOT NULL COMMENT 'Style ID',
  `smv` float NOT NULL COMMENT 'SMV',
  `nop` tinyint(2) unsigned NOT NULL COMMENT 'NOP',
  `date` date NOT NULL COMMENT 'Log Date',
  `remarks` varchar(4) NOT NULL COMMENT 'Remarks',
  `buyer` varchar(12) DEFAULT NULL COMMENT 'Buyer',
  `nop1` tinyint(2) unsigned NOT NULL COMMENT 'NOP1',
  `nop2` tinyint(2) unsigned NOT NULL COMMENT 'NOP2',
  `nop3` tinyint(2) unsigned NOT NULL COMMENT 'NOP3',
  `nop4` tinyint(2) unsigned NOT NULL COMMENT 'NOP4',
  `nop5` tinyint(1) unsigned NOT NULL COMMENT 'NOP5',
  `movex_styles_db` text NOT NULL COMMENT 'Style Names for Style ID',
  `smv1` float NOT NULL COMMENT 'SMV1',
  `smv2` float NOT NULL COMMENT 'SMV2',
  `smv3` float NOT NULL COMMENT 'SMV3',
  `smv4` float NOT NULL COMMENT 'SMV4',
  `smv5` float unsigned NOT NULL COMMENT 'SMV5',
  `days` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`sno`),
  KEY `style` (`style`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `pro_style_today` */

DROP TABLE IF EXISTS `bai_pro`.`pro_style_today`;

CREATE TABLE `bai_pro`.`pro_style_today` (
  `sno` varchar(25) NOT NULL,
  `style` varchar(15) NOT NULL,
  `smv` float NOT NULL,
  `nop` tinyint(2) unsigned NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(4) NOT NULL,
  `buyer` varchar(12) NOT NULL,
  `nop1` tinyint(2) unsigned NOT NULL,
  `nop2` tinyint(2) unsigned NOT NULL,
  `nop3` tinyint(2) unsigned NOT NULL,
  `nop4` tinyint(2) unsigned NOT NULL,
  `nop5` tinyint(1) unsigned NOT NULL,
  `movex_styles_db` text NOT NULL,
  `smv1` float NOT NULL,
  `smv2` float NOT NULL,
  `smv3` float NOT NULL,
  `smv4` float NOT NULL,
  `smv5` float unsigned NOT NULL,
  `days` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`sno`),
  KEY `style` (`style`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `schedule_log` */

DROP TABLE IF EXISTS `bai_pro`.`schedule_log`;

CREATE TABLE `bai_pro`.`schedule_log` (
  `delivery` bigint(11) NOT NULL,
  `bac_qty` decimal(27,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_freez_plan_log` */

DROP TABLE IF EXISTS `bai_pro`.`tbl_freez_plan_log`;

CREATE TABLE `bai_pro`.`tbl_freez_plan_log` (
  `plan_tag` varchar(50) NOT NULL DEFAULT '' COMMENT 'date+module+shift',
  `date` date NOT NULL,
  `mod_no` varchar(8) NOT NULL,
  `shift` char(1) NOT NULL,
  `plan_eff` tinyint(3) unsigned NOT NULL,
  `plan_pro` smallint(4) unsigned NOT NULL,
  `sec_no` tinyint(1) unsigned NOT NULL,
  `plan_clh` float(11,2) NOT NULL COMMENT 'Plan Clock',
  `plan_sah` float(11,2) NOT NULL COMMENT 'Plan SAH',
  PRIMARY KEY (`plan_tag`),
  KEY `date` (`date`,`mod_no`,`shift`,`sec_no`),
  KEY `date_key` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This is the main table 4m which freezed plan will be loaded';

/*Table structure for table `tbl_freez_plan_tmp` */

DROP TABLE IF EXISTS `bai_pro`.`tbl_freez_plan_tmp`;

CREATE TABLE `bai_pro`.`tbl_freez_plan_tmp` (
  `plan_tag` varchar(50) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `mod_no` varchar(8) NOT NULL,
  `shift` char(1) NOT NULL,
  `plan_eff` tinyint(3) unsigned NOT NULL,
  `plan_pro` smallint(4) unsigned NOT NULL,
  `sec_no` tinyint(1) unsigned NOT NULL,
  `plan_clh` float(11,2) NOT NULL COMMENT 'Plan Clock',
  `plan_sah` float(11,2) NOT NULL COMMENT 'Plan SAH',
  PRIMARY KEY (`plan_tag`),
  KEY `date` (`date`,`mod_no`,`shift`,`sec_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This is the temp file where plan resides till confimed.';

/*Table structure for table `tbl_freez_plan_track` */

DROP TABLE IF EXISTS `bai_pro`.`tbl_freez_plan_track`;

CREATE TABLE `bai_pro`.`tbl_freez_plan_track` (
  `yer_mon` date NOT NULL,
  `verified_by` varchar(50) DEFAULT NULL,
  `verified_on` datetime DEFAULT NULL,
  `confirmed_by` varchar(50) DEFAULT NULL,
  `confirmed_on` datetime DEFAULT NULL,
  `track_status` int(11) NOT NULL DEFAULT 0 COMMENT '0-New, 1- Verified, 2-Confirmed',
  PRIMARY KEY (`yer_mon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table is to track upload, confirmed transaction details';

/*Table structure for table `tbl_freez_plan_upload` */

DROP TABLE IF EXISTS `bai_pro`.`tbl_freez_plan_upload`;

CREATE TABLE `bai_pro`.`tbl_freez_plan_upload` (
  `module` varchar(5) DEFAULT NULL,
  `shift` varchar(3) DEFAULT NULL,
  `value_type` varchar(30) DEFAULT NULL COMMENT 'PP_PCS; SAH_HRS; PEF_PER',
  `d_1` float DEFAULT NULL COMMENT 'Date',
  `d_2` float DEFAULT NULL,
  `d_3` float DEFAULT NULL,
  `d_4` float DEFAULT NULL,
  `d_5` float DEFAULT NULL,
  `d_6` float DEFAULT NULL,
  `d_7` float DEFAULT NULL,
  `d_8` float DEFAULT NULL,
  `d_9` float DEFAULT NULL,
  `d_10` float DEFAULT NULL,
  `d_11` float DEFAULT NULL,
  `d_12` float DEFAULT NULL,
  `d_13` float DEFAULT NULL,
  `d_14` float DEFAULT NULL,
  `d_15` float DEFAULT NULL,
  `d_16` float DEFAULT NULL,
  `d_17` float DEFAULT NULL,
  `d_18` float DEFAULT NULL,
  `d_19` float DEFAULT NULL,
  `d_20` float DEFAULT NULL,
  `d_21` float DEFAULT NULL,
  `d_22` float DEFAULT NULL,
  `d_23` float DEFAULT NULL,
  `d_24` float DEFAULT NULL,
  `d_25` float DEFAULT NULL,
  `d_26` float DEFAULT NULL,
  `d_27` float DEFAULT NULL,
  `d_28` float DEFAULT NULL,
  `d_29` float DEFAULT NULL,
  `d_30` float DEFAULT NULL,
  `d_31` float DEFAULT NULL,
  KEY `module_shift` (`module`,`shift`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='uploaded csv files will be dumped initially here.';

/*Table structure for table `unit_db` */

DROP TABLE IF EXISTS `bai_pro`.`unit_db`;

CREATE TABLE `bai_pro`.`unit_db` (
  `unit_id` varchar(100) DEFAULT NULL,
  `unit_desc` varchar(100) DEFAULT NULL,
  `unit_members` varchar(100) DEFAULT NULL,
  `sno` int(11) NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
