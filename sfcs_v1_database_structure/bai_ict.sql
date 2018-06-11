/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_ict
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_ict` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_ict`;

/*Table structure for table `bai_ict_services` */

DROP TABLE IF EXISTS `bai_ict_services`;

CREATE TABLE `bai_ict_services` (
  `service_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `service_title` varchar(200) NOT NULL,
  `service_ip` varchar(100) NOT NULL,
  `service_status` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;

/*Table structure for table `bai_login_db` */

DROP TABLE IF EXISTS `bai_login_db`;

CREATE TABLE `bai_login_db` (
  `user_login` varchar(30) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `feedback` int(11) DEFAULT NULL,
  `feedback_res` text,
  `uid` int(11) NOT NULL,
  `location_id` int(11) NOT NULL COMMENT 'Location Identity : 0- ALL, 1-BAI1, 2-BAI2',
  `slno` int(11) NOT NULL AUTO_INCREMENT,
  `last_access` datetime NOT NULL COMMENT 'Last Access Time',
  `user_facility` varchar(5) NOT NULL COMMENT 'Facility Code',
  PRIMARY KEY (`user_login`),
  UNIQUE KEY `slno` (`slno`),
  KEY `user_login` (`user_login`),
  KEY `user_login_2` (`user_login`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=268 DEFAULT CHARSET=latin1;

/*Table structure for table `cctv_approval` */

DROP TABLE IF EXISTS `cctv_approval`;

CREATE TABLE `cctv_approval` (
  `year` int(11) NOT NULL COMMENT 'Year Number',
  `week` int(11) NOT NULL COMMENT 'Week Number',
  `month` int(11) NOT NULL COMMENT 'Month number',
  `approve_1` varchar(32) NOT NULL COMMENT '1st Approved by ICT',
  `approve_2` varchar(32) NOT NULL COMMENT '2nd approved by Compliance',
  `approve_3` varchar(32) NOT NULL COMMENT '3rd approved by HR',
  `log_time_1` datetime NOT NULL COMMENT '1st level approval time',
  `log_time_2` datetime NOT NULL COMMENT '2nd level approval time',
  `log_time_3` datetime NOT NULL COMMENT '3rd level approval time',
  `reject_by` varchar(32) NOT NULL COMMENT 'Rejected by',
  `reject_time` datetime NOT NULL COMMENT 'Rejected time',
  `remark` varchar(50) NOT NULL COMMENT 'Remark',
  PRIMARY KEY (`year`,`week`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cctv_check_list` */

DROP TABLE IF EXISTS `cctv_check_list`;

CREATE TABLE `cctv_check_list` (
  `tid` varchar(100) NOT NULL,
  `location_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `week_id` int(11) NOT NULL,
  `camera_available` int(11) NOT NULL,
  `rotation` int(11) NOT NULL,
  `zoom_stat` int(11) NOT NULL,
  `cable_stat` int(11) NOT NULL,
  `power_stat` int(11) NOT NULL,
  `cam_acc` int(11) NOT NULL,
  `visibility` int(11) NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `last_up` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `network` int(11) DEFAULT NULL,
  `backup` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cctv_mod_list` */

DROP TABLE IF EXISTS `cctv_mod_list`;

CREATE TABLE `cctv_mod_list` (
  `mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_name` varchar(100) NOT NULL,
  `mod_location` varchar(100) NOT NULL,
  `mod_status` varchar(20) NOT NULL,
  `cat_type` varchar(10) NOT NULL COMMENT 'To check type of equipment (Blank-Cam, 2-DVR, 3-Screen)',
  `with_effect` date NOT NULL,
  PRIMARY KEY (`mod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `Sno` int(11) NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `Name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` longtext NOT NULL,
  `IP` varchar(50) NOT NULL,
  PRIMARY KEY (`Sno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ict_preven_maint_check_list` */

DROP TABLE IF EXISTS `ict_preven_maint_check_list`;

CREATE TABLE `ict_preven_maint_check_list` (
  `srl_no` int(8) NOT NULL AUTO_INCREMENT,
  `machine_type` varchar(50) DEFAULT NULL,
  `model_no` varchar(50) DEFAULT NULL,
  `serial_no` varchar(20) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `key_board` varchar(20) DEFAULT NULL,
  `mouse` varchar(20) DEFAULT NULL,
  `monitor` varchar(20) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `check_list` varchar(300) DEFAULT NULL,
  `host_name` varchar(50) DEFAULT NULL,
  `verified_by` varchar(50) DEFAULT NULL,
  `check_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`srl_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `menu_index` */

DROP TABLE IF EXISTS `menu_index`;

CREATE TABLE `menu_index` (
  `list_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parent_list_id` int(11) DEFAULT NULL,
  `list_title` varchar(300) NOT NULL,
  `list_desc` text NOT NULL COMMENT 'link',
  `status` tinyint(4) NOT NULL COMMENT 'to show link or not 0-yes, 1-no',
  `link` smallint(6) NOT NULL COMMENT '0-yes; 1-no, to show line as link',
  `priority` smallint(6) NOT NULL COMMENT 'to give an order',
  `team` smallint(6) NOT NULL COMMENT 'Authorised members',
  `auth_members` varchar(200) NOT NULL,
  `help_tip` varchar(100) NOT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Manufacturing Menu Details';

/*Table structure for table `mobile_bill_track_1313` */

DROP TABLE IF EXISTS `mobile_bill_track_1313`;

CREATE TABLE `mobile_bill_track_1313` (
  `tid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phn_no` varchar(30) DEFAULT NULL,
  `bill_val` float DEFAULT NULL,
  `personal_val` float DEFAULT NULL,
  `last_up` datetime DEFAULT NULL,
  `bill_month` varchar(45) DEFAULT NULL,
  `con_type` varchar(45) DEFAULT NULL,
  `remark` varchar(45) DEFAULT NULL,
  `lock` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mobile_current_user_list` */

DROP TABLE IF EXISTS `mobile_current_user_list`;

CREATE TABLE `mobile_current_user_list` (
  `m_id` int(5) NOT NULL AUTO_INCREMENT,
  `mobile_no` varchar(15) NOT NULL,
  `sim_no` varchar(20) DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `con_type` varchar(3) DEFAULT NULL,
  `tid_ref` int(5) DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `mobile_issue_track` */

DROP TABLE IF EXISTS `mobile_issue_track`;

CREATE TABLE `mobile_issue_track` (
  `tid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mobile_no` varchar(10) DEFAULT NULL,
  `call_name` varchar(100) DEFAULT NULL,
  `full_name` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `emp_no` varchar(15) DEFAULT NULL,
  `dept` varchar(100) DEFAULT NULL,
  `sup_email` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `isd_clime` varchar(45) DEFAULT NULL,
  `internet` varchar(45) DEFAULT NULL COMMENT 'Personal and officaial',
  `limit_val` varchar(45) DEFAULT NULL,
  `data` varchar(45) DEFAULT NULL,
  `IR` varchar(45) DEFAULT NULL COMMENT 'International Roaming',
  `con_type` varchar(45) DEFAULT NULL,
  `sim_no` varchar(45) DEFAULT NULL,
  `issued_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `request_date` varchar(45) DEFAULT NULL,
  `req_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `printer_user_log` */

DROP TABLE IF EXISTS `printer_user_log`;

CREATE TABLE `printer_user_log` (
  `dept_name` varchar(100) NOT NULL,
  `dept_id` varchar(10) NOT NULL,
  `old_pwd` varchar(10) NOT NULL,
  `new_pwd` varchar(10) NOT NULL,
  `hod_id_bai1` varchar(50) NOT NULL,
  `hod_id_bai2` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `report_alert_track` */

DROP TABLE IF EXISTS `report_alert_track`;

CREATE TABLE `report_alert_track` (
  `report` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
