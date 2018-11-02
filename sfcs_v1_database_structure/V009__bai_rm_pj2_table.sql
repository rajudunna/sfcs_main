/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_rm_pj2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_rm_pj2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_rm_pj2`;

/*Table structure for table `manual_form` */

DROP TABLE IF EXISTS `manual_form`;

CREATE TABLE `manual_form` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `buyer` varchar(100) NOT NULL,
  `style` varchar(50) NOT NULL,
  `schedule` varchar(30) NOT NULL,
  `color` varchar(300) NOT NULL,
  `item` text NOT NULL,
  `reason` text NOT NULL,
  `qty` varchar(30) NOT NULL,
  `req_from` varchar(30) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `app_by` varchar(30) NOT NULL,
  `app_date` datetime NOT NULL,
  `issue_closed` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `comm_status` int(11) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `category` int(11) NOT NULL COMMENT '1) fabric 2) accessories',
  `spoc` varchar(30) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`style`,`schedule`,`color`),
  KEY `NewIndex2` (`schedule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `mrn_out_allocation` */

DROP TABLE IF EXISTS `mrn_out_allocation`;

CREATE TABLE `mrn_out_allocation` (
  `tid` double NOT NULL AUTO_INCREMENT COMMENT 'Transaction ID',
  `mrn_tid` double DEFAULT NULL COMMENT 'MRN Transaction ID',
  `lable_id` varchar(255) DEFAULT NULL COMMENT 'Lable ID',
  `lot_no` varchar(300) DEFAULT NULL COMMENT 'LOT Number',
  `iss_qty` double DEFAULT NULL COMMENT 'Issued Quantity',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Log Time of issuing',
  `updated_user` varchar(100) DEFAULT NULL COMMENT 'Log user details of material issuing',
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`mrn_tid`,`lable_id`,`lot_no`),
  KEY `NewIndex2` (`lable_id`),
  KEY `NewIndex3` (`lot_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mrn_reason_db` */

DROP TABLE IF EXISTS `mrn_reason_db`;

CREATE TABLE `mrn_reason_db` (
  `reason_tid` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'Reason ID',
  `reason_code` varchar(10) NOT NULL COMMENT 'Reason Code',
  `reason_desc` varchar(100) NOT NULL COMMENT 'Reason Description',
  `reason_order` smallint(6) NOT NULL COMMENT 'Reason Order',
  `status` smallint(6) NOT NULL COMMENT 'Status 1. Deactive 2. Active',
  PRIMARY KEY (`reason_tid`),
  KEY `NewIndex1` (`reason_code`),
  KEY `NewIndex2` (`reason_desc`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `mrn_track` */

DROP TABLE IF EXISTS `mrn_track`;

CREATE TABLE `mrn_track` (
  `style` varchar(30) NOT NULL COMMENT 'Style No',
  `schedule` varchar(30) NOT NULL COMMENT 'Schedule No',
  `color` varchar(200) NOT NULL COMMENT 'Color',
  `product` varchar(10) NOT NULL COMMENT 'Product code name',
  `item_code` varchar(100) NOT NULL COMMENT 'item name',
  `item_desc` varchar(300) NOT NULL COMMENT 'Item Description',
  `co_ref` varchar(50) NOT NULL COMMENT 'CO number',
  `unit_cost` float NOT NULL COMMENT 'cost',
  `uom` varchar(10) NOT NULL COMMENT 'Unit id measure',
  `req_qty` float NOT NULL COMMENT 'Requested Quantity',
  `avail_qty` float NOT NULL COMMENT 'Available Quantity',
  `issued_qty` float NOT NULL COMMENT 'Issued Quantity',
  `status` smallint(6) NOT NULL COMMENT '1-Request; 2-Approved; 3-Rejected; 4-Informed/On Progress; 5-Sourcing Updated; 6-Canceled; 7-Doc Printed, 8-Doc Issued, 9-Doc Closed',
  `req_user` varchar(50) NOT NULL COMMENT 'Requested User',
  `section` smallint(6) NOT NULL COMMENT 'Section Number',
  `app_by` varchar(50) NOT NULL COMMENT 'Approved By',
  `updated_by` varchar(50) NOT NULL COMMENT 'Updated by',
  `issued_by` varchar(50) NOT NULL COMMENT 'Issued By',
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
  `rand_track_id` int(11) NOT NULL COMMENT 'Random Number',
  `req_date` datetime NOT NULL COMMENT 'Request date',
  `app_date` datetime NOT NULL COMMENT 'Approve Date',
  `updated_date` datetime NOT NULL COMMENT 'Update Date',
  `issued_date` datetime NOT NULL COMMENT 'Issued Date',
  `reason_code` smallint(6) NOT NULL COMMENT 'Reason Code',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `batch_ref` varchar(50) DEFAULT NULL COMMENT 'To Track Batch Ref Details For Tracking The Issued Qty Of a Batch',
  PRIMARY KEY (`tid`),
  KEY `request_date` (`req_date`),
  KEY `NewIndex1` (`style`,`schedule`,`color`),
  KEY `NewIndex2` (`schedule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `remarks_log` */

DROP TABLE IF EXISTS `remarks_log`;

CREATE TABLE `remarks_log` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `username` varchar(45) NOT NULL,
  `date` datetime NOT NULL,
  `level` varchar(45) NOT NULL,
  PRIMARY KEY (`sno`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
