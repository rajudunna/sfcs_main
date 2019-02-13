/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_pro3
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro3` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_pro3`;

/*Table structure for table `act_cut_issue_status` */

DROP TABLE IF EXISTS `bai_pro3`.`act_cut_issue_status`;

CREATE TABLE `bai_pro3`.`act_cut_issue_status` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Date of Issue',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `mod_no` varchar(8) NOT NULL COMMENT 'Module',
  `shift` varchar(20) NOT NULL COMMENT 'Shift',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Log Time',
  PRIMARY KEY (`doc_no`),
  KEY `cut date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track cut job issue status.';

/*Table structure for table `act_cut_issue_status_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`act_cut_issue_status_archive`;

CREATE TABLE `bai_pro3`.`act_cut_issue_status_archive` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Date of Issue',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `mod_no` varchar(8) NOT NULL COMMENT 'Module',
  `shift` varchar(20) NOT NULL COMMENT 'Shift',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Log Time',
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `act_cut_status` */

DROP TABLE IF EXISTS `bai_pro3`.`act_cut_status`;

CREATE TABLE `bai_pro3`.`act_cut_status` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Cut Completed/Reported Date',
  `section` int(11) NOT NULL COMMENT 'Cut Exceuted Section',
  `shift` varchar(10) NOT NULL COMMENT 'Shift',
  `fab_received` float NOT NULL COMMENT 'Fabric Received Qty from RM',
  `fab_returned` float NOT NULL COMMENT 'Fabric Returned Qty to RM',
  `damages` float NOT NULL COMMENT 'Fabric Damage details',
  `shortages` float NOT NULL COMMENT 'Fabric Shortage Details',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Log Time',
  `bundle_loc` varchar(200) DEFAULT NULL COMMENT 'Bundle location',
  `leader_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`doc_no`),
  KEY `cut date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track actual cut completion status.';

/*Table structure for table `act_cut_status_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`act_cut_status_archive`;

CREATE TABLE `bai_pro3`.`act_cut_status_archive` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Cut Completed/Reported Date',
  `section` int(11) NOT NULL COMMENT 'Cut Exceuted Section',
  `shift` varchar(10) NOT NULL COMMENT 'Shift',
  `fab_received` float NOT NULL COMMENT 'Fabric Received Qty from RM',
  `fab_returned` float NOT NULL COMMENT 'Fabric Returned Qty to RM',
  `damages` float NOT NULL COMMENT 'Fabric Damage details',
  `shortages` float NOT NULL COMMENT 'Fabric Shortage Details',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Log Time',
  `bundle_loc` varchar(200) DEFAULT NULL COMMENT 'Bundle Location',
  `leader_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `act_cut_status_recut_v2` */

DROP TABLE IF EXISTS `bai_pro3`.`act_cut_status_recut_v2`;

CREATE TABLE `bai_pro3`.`act_cut_status_recut_v2` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Cut Completed/Reported Date',
  `section` int(11) NOT NULL COMMENT 'Cut Exceuted Section',
  `shift` varchar(10) NOT NULL COMMENT 'Shift',
  `fab_received` float NOT NULL COMMENT 'Fabric Received Qty from RM',
  `fab_returned` float NOT NULL COMMENT 'Fabric Returned Qty to RM',
  `damages` float NOT NULL COMMENT 'Fabric Damage details',
  `shortages` float NOT NULL COMMENT 'Fabric Shortage Details',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Log Time',
  `leader_name` varchar(100) DEFAULT NULL COMMENT 'Team Leader',
  PRIMARY KEY (`doc_no`),
  KEY `cut date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track recut cut job status.';

/*Table structure for table `act_cut_status_recut_v2_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`act_cut_status_recut_v2_archive`;

CREATE TABLE `bai_pro3`.`act_cut_status_recut_v2_archive` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Cut Completed/Reported Date',
  `section` int(11) NOT NULL COMMENT 'Cut Exceuted Section',
  `shift` varchar(10) NOT NULL COMMENT 'Shift',
  `fab_received` float NOT NULL COMMENT 'Fabric Received Qty from RM',
  `fab_returned` float NOT NULL COMMENT 'Fabric Returned Qty to RM',
  `damages` float NOT NULL COMMENT 'Fabric Damage details',
  `shortages` float NOT NULL COMMENT 'Fabric Shortage Details',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Log Time',
  `leader_name` varchar(100) DEFAULT NULL COMMENT 'Team Leader',
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `act_line_issue_status` */

DROP TABLE IF EXISTS `bai_pro3`.`act_line_issue_status`;

CREATE TABLE `bai_pro3`.`act_line_issue_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input_job_random` varchar(20) DEFAULT NULL,
  `input_job_no` int(11) DEFAULT NULL,
  `module` varchar(5) DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `act_line_issue_status_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`act_line_issue_status_archive`;

CREATE TABLE `bai_pro3`.`act_line_issue_status_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input_job_random` varchar(20) DEFAULT NULL,
  `input_job_no` int(11) DEFAULT NULL,
  `module` varchar(5) DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `allocate_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`allocate_stat_log`;

CREATE TABLE `bai_pro3`.`allocate_stat_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique Allocation (Ratio) TID',
  `date` date NOT NULL COMMENT 'Date',
  `cat_ref` int(11) NOT NULL COMMENT 'Category Reference',
  `cuttable_ref` int(11) NOT NULL COMMENT 'Cuttable Reference',
  `order_tid` varchar(200) NOT NULL COMMENT 'Order Transaction ID',
  `ratio` int(11) NOT NULL COMMENT 'Ratio Number',
  `cut_count` int(11) NOT NULL COMMENT 'Cut \n\nCount',
  `pliespercut` int(11) NOT NULL COMMENT 'Max Plies per Cut',
  `allocate_xs` int(11) NOT NULL COMMENT 'XS Ratio for a Cut Plies',
  `allocate_s` int(11) NOT NULL COMMENT 'S Ratio for a Cut Plies',
  `allocate_m` int(11) NOT NULL COMMENT 'XS Ratio for a Cut Plies',
  `allocate_l` int(11) NOT NULL COMMENT 'M Ratio for a Cut Plies',
  `allocate_xl` int(11) NOT NULL COMMENT 'L Ratio for a Cut Plies',
  `allocate_xxl` int(11) NOT NULL COMMENT 'XL Ratio for a Cut Plies',
  `allocate_xxxl` int(11) NOT NULL COMMENT 'XXXL Ratio for a Cut Plies',
  `plies` int(11) NOT NULL COMMENT 'Total Plies for Ration',
  `lastup` datetime NOT NULL COMMENT 'Last updated Log',
  `remarks` varchar(500) NOT NULL COMMENT 'Remarks',
  `mk_status` int(11) DEFAULT NULL COMMENT 'Marker Update Status',
  `allocate_s01` int(11) NOT NULL COMMENT 's01 Ratio for a Cut Plies',
  `allocate_s02` int(11) NOT NULL COMMENT 's02 Ratio for a Cut Plies',
  `allocate_s03` int(11) NOT NULL COMMENT 's03 Ratio for a Cut Plies',
  `allocate_s04` int(11) NOT NULL COMMENT 's04 Ratio for a Cut Plies',
  `allocate_s05` int(11) NOT NULL COMMENT 's05 Ratio for a Cut Plies',
  `allocate_s06` int(11) NOT NULL COMMENT 's06 Ratio for a Cut Plies',
  `allocate_s07` int(11) NOT NULL COMMENT 's07 Ratio for a Cut Plies',
  `allocate_s08` int(11) NOT NULL COMMENT 's08 Ratio \n\nfor a Cut Plies',
  `allocate_s09` int(11) NOT NULL COMMENT 's09 Ratio for a Cut Plies',
  `allocate_s10` int(11) NOT NULL COMMENT 's10 Ratio for a Cut \n\nPlies',
  `allocate_s11` int(11) NOT NULL COMMENT 's11 Ratio for a Cut Plies',
  `allocate_s12` int(11) NOT NULL COMMENT 's12 Ratio for a Cut Plies',
  `allocate_s13` int(11) NOT NULL COMMENT 's13 Ratio for a Cut Plies',
  `allocate_s14` int(11) NOT NULL COMMENT 's14 Ratio for a Cut Plies',
  `allocate_s15` int(11) NOT NULL COMMENT 's15 Ratio for a Cut Plies',
  `allocate_s16` int(11) NOT NULL COMMENT 's16 Ratio for a Cut Plies',
  `allocate_s17` int(11) NOT NULL COMMENT 's17 Ratio for a Cut Plies',
  `allocate_s18` int(11) NOT NULL COMMENT 's18 Ratio for a Cut Plies',
  `allocate_s19` int(11) NOT NULL COMMENT 's19 Ratio for a Cut Plies',
  `allocate_s20` int(11) NOT NULL COMMENT 's20 Ratio for a Cut Plies',
  `allocate_s21` int(11) NOT NULL COMMENT 's21 Ratio for a Cut Plies',
  `allocate_s22` int(11) NOT NULL COMMENT 's22 Ratio for a Cut Plies',
  `allocate_s23` int(11) NOT NULL COMMENT 's23 Ratio for a Cut Plies',
  `allocate_s24` int(11) NOT NULL COMMENT 's24 Ratio for a Cut Plies',
  `allocate_s25` int(11) NOT NULL COMMENT 's25 Ratio for a Cut Plies',
  `allocate_s26` int(11) NOT NULL COMMENT 's26 Ratio for a Cut Plies',
  `allocate_s27` int(11) NOT NULL COMMENT 's27 Ratio for a Cut Plies',
  `allocate_s28` int(11) NOT NULL COMMENT 's28 Ratio for a Cut Plies',
  `allocate_s29` int(11) NOT NULL COMMENT 's29 Ratio for a Cut Plies',
  `allocate_s30` int(11) NOT NULL COMMENT 's30 Ratio for a Cut Plies',
  `allocate_s31` int(11) NOT NULL COMMENT 's31 Ratio for a Cut Plies',
  `allocate_s32` int(11) NOT NULL COMMENT 's32 Ratio for a Cut Plies',
  `allocate_s33` int(11) NOT NULL COMMENT 's33 Ratio for a Cut Plies',
  `allocate_s34` int(11) NOT NULL COMMENT 's34 Ratio for a Cut Plies',
  `allocate_s35` int(11) NOT NULL COMMENT 's35 Ratio for a Cut Plies',
  `allocate_s36` int(11) NOT NULL COMMENT 's36 Ratio for a Cut Plies',
  `allocate_s37` int(11) NOT NULL COMMENT 's37 Ratio for a Cut Plies',
  `allocate_s38` int(11) NOT NULL COMMENT 's38 Ratio for a Cut Plies',
  `allocate_s39` int(11) NOT NULL COMMENT 's39 Ratio for a Cut Plies',
  `allocate_s40` int(11) NOT NULL COMMENT 's40 Ratio for a Cut Plies',
  `allocate_s41` int(11) NOT NULL COMMENT 's41 Ratio for a Cut Plies',
  `allocate_s42` int(11) NOT NULL COMMENT 's42 Ratio for a Cut Plies',
  `allocate_s43` int(11) NOT NULL COMMENT 's43 Ratio for a Cut Plies',
  `allocate_s44` int(11) NOT NULL COMMENT 's44 Ratio for a Cut Plies',
  `allocate_s45` int(11) NOT NULL COMMENT 's45 Ratio for a Cut Plies',
  `allocate_s46` int(11) NOT NULL COMMENT 's46 Ratio for a Cut Plies',
  `allocate_s47` int(11) NOT NULL COMMENT 's47 Ratio for a Cut Plies',
  `allocate_s48` int(11) NOT NULL COMMENT 's48 Ratio for a Cut Plies',
  `allocate_s49` int(11) NOT NULL COMMENT 's49 Ratio for a Cut Plies',
  `allocate_s50` int(11) NOT NULL COMMENT 's50 Ratio for a Cut Plies',
  `doc_remarks` varchar(25) DEFAULT NULL,
  `extra_plies` int(11) DEFAULT NULL COMMENT 'Extra Plies Of the Cut',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `Unique` (`cat_ref`,`cuttable_ref`,`order_tid`,`ratio`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='To track ration detail of cut job';

/*Table structure for table `allocate_stat_log_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`allocate_stat_log_archive`;

CREATE TABLE `bai_pro3`.`allocate_stat_log_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique Allocation (Ratio) TID',
  `date` date NOT NULL COMMENT 'Date',
  `cat_ref` int(11) NOT NULL COMMENT 'Category Reference',
  `cuttable_ref` int(11) NOT NULL COMMENT 'Cuttable Reference',
  `order_tid` varchar(200) NOT NULL COMMENT 'Order Transaction ID',
  `ratio` int(11) NOT NULL COMMENT 'Ratio Number',
  `cut_count` int(11) NOT NULL COMMENT 'Cut Count',
  `pliespercut` int(11) NOT NULL COMMENT 'Max Plies per Cut',
  `allocate_xs` int(11) NOT NULL,
  `allocate_s` int(11) NOT NULL,
  `allocate_m` int(11) NOT NULL,
  `allocate_l` int(11) NOT NULL,
  `allocate_xl` int(11) NOT NULL,
  `allocate_xxl` int(11) NOT NULL,
  `allocate_xxxl` int(11) NOT NULL,
  `plies` int(11) NOT NULL COMMENT 'Total Plies for Ration',
  `lastup` datetime NOT NULL COMMENT 'Last updated \n\nLog',
  `remarks` varchar(500) NOT NULL COMMENT 'Remarks',
  `mk_status` int(11) DEFAULT NULL COMMENT 'Marker Update Status',
  `allocate_s01` int(11) NOT NULL COMMENT 's01 Ratio for a Cut Plies',
  `allocate_s02` int(11) NOT NULL COMMENT 's02 Ratio for a Cut Plies',
  `allocate_s03` int(11) NOT NULL COMMENT 's03 Ratio for a Cut Plies',
  `allocate_s04` int(11) NOT NULL COMMENT 's04 Ratio for a Cut Plies',
  `allocate_s05` int(11) NOT NULL COMMENT 's05 Ratio for a Cut Plies',
  `allocate_s06` int(11) NOT NULL COMMENT 's06 Ratio for a Cut Plies',
  `allocate_s07` int(11) NOT NULL COMMENT 's07 Ratio for a Cut Plies',
  `allocate_s08` int(11) NOT NULL COMMENT 's08 Ratio for a Cut Plies',
  `allocate_s09` int(11) NOT NULL COMMENT 's09 Ratio \n\nfor a Cut Plies',
  `allocate_s10` int(11) NOT NULL COMMENT 's10 Ratio for a Cut Plies',
  `allocate_s11` int(11) NOT NULL COMMENT 's11 Ratio for a Cut \n\nPlies',
  `allocate_s12` int(11) NOT NULL COMMENT 's12 Ratio for a Cut Plies',
  `allocate_s13` int(11) NOT NULL COMMENT 's13 Ratio for a Cut Plies',
  `allocate_s14` int(11) NOT NULL COMMENT 's14 Ratio for a Cut Plies',
  `allocate_s15` int(11) NOT NULL COMMENT 's15 Ratio for a Cut Plies',
  `allocate_s16` int(11) NOT NULL COMMENT 's16 Ratio for a Cut Plies',
  `allocate_s17` int(11) NOT NULL COMMENT 's17 Ratio for a Cut Plies',
  `allocate_s18` int(11) NOT NULL COMMENT 's18 Ratio for a Cut Plies',
  `allocate_s19` int(11) NOT NULL COMMENT 's19 Ratio for a Cut Plies',
  `allocate_s20` int(11) NOT NULL COMMENT 's20 Ratio for a Cut Plies',
  `allocate_s21` int(11) NOT NULL COMMENT 's21 Ratio for a Cut Plies',
  `allocate_s22` int(11) NOT NULL COMMENT 's22 Ratio for a Cut Plies',
  `allocate_s23` int(11) NOT NULL COMMENT 's23 Ratio for a Cut Plies',
  `allocate_s24` int(11) NOT NULL COMMENT 's24 Ratio for a Cut Plies',
  `allocate_s25` int(11) NOT NULL COMMENT 's25 Ratio for a Cut Plies',
  `allocate_s26` int(11) NOT NULL COMMENT 's26 Ratio for a Cut Plies',
  `allocate_s27` int(11) NOT NULL COMMENT 's27 Ratio for a Cut Plies',
  `allocate_s28` int(11) NOT NULL COMMENT 's28 Ratio for a Cut Plies',
  `allocate_s29` int(11) NOT NULL COMMENT 's29 Ratio for a Cut Plies',
  `allocate_s30` int(11) NOT NULL COMMENT 's30 Ratio for a Cut Plies',
  `allocate_s31` int(11) NOT NULL COMMENT 's31 Ratio for a Cut Plies',
  `allocate_s32` int(11) NOT NULL COMMENT 's32 Ratio for a Cut Plies',
  `allocate_s33` int(11) NOT NULL COMMENT 's33 Ratio for a Cut Plies',
  `allocate_s34` int(11) NOT NULL COMMENT 's34 Ratio for a Cut Plies',
  `allocate_s35` int(11) NOT NULL COMMENT 's35 Ratio for a Cut Plies',
  `allocate_s36` int(11) NOT NULL COMMENT 's36 Ratio for a Cut Plies',
  `allocate_s37` int(11) NOT NULL COMMENT 's37 Ratio for a Cut Plies',
  `allocate_s38` int(11) NOT NULL COMMENT 's38 Ratio for a Cut Plies',
  `allocate_s39` int(11) NOT NULL COMMENT 's39 Ratio for a Cut Plies',
  `allocate_s40` int(11) NOT NULL COMMENT 's40 Ratio for a Cut Plies',
  `allocate_s41` int(11) NOT NULL COMMENT 's41 Ratio for a Cut Plies',
  `allocate_s42` int(11) NOT NULL COMMENT 's42 Ratio for a Cut Plies',
  `allocate_s43` int(11) NOT NULL COMMENT 's43 Ratio for a Cut Plies',
  `allocate_s44` int(11) NOT NULL COMMENT 's44 Ratio for a Cut Plies',
  `allocate_s45` int(11) NOT NULL COMMENT 's45 Ratio for a Cut Plies',
  `allocate_s46` int(11) NOT NULL COMMENT 's46 Ratio for a Cut Plies',
  `allocate_s47` int(11) NOT NULL COMMENT 's47 Ratio for a Cut Plies',
  `allocate_s48` int(11) NOT NULL COMMENT 's48 Ratio for a Cut Plies',
  `allocate_s49` int(11) NOT NULL COMMENT 's49 Ratio for a Cut Plies',
  `allocate_s50` int(11) NOT NULL COMMENT 's50 Ratio for a Cut Plies',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `unique` (`cat_ref`,`cuttable_ref`,`order_tid`,`ratio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `allocate_stat_log_delete` */

DROP TABLE IF EXISTS `bai_pro3`.`allocate_stat_log_delete`;

CREATE TABLE `bai_pro3`.`allocate_stat_log_delete` (
  `tid` int(11) NOT NULL,
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cuttable_ref` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `ratio` int(11) NOT NULL,
  `cut_count` int(11) NOT NULL,
  `pliespercut` int(11) NOT NULL,
  `allocate_xs` int(11) NOT NULL,
  `allocate_s` int(11) NOT NULL,
  `allocate_m` int(11) NOT NULL,
  `allocate_l` int(11) NOT NULL,
  `allocate_xl` int(11) NOT NULL,
  `allocate_xxl` int(11) NOT NULL,
  `allocate_xxxl` int(11) NOT NULL,
  `plies` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `mk_status` int(11) DEFAULT NULL,
  `allocate_s06` int(11) NOT NULL,
  `allocate_s08` int(11) NOT NULL,
  `allocate_s10` int(11) NOT NULL,
  `allocate_s12` int(11) NOT NULL,
  `allocate_s14` int(11) NOT NULL,
  `allocate_s16` int(11) NOT NULL,
  `allocate_s18` int(11) NOT NULL,
  `allocate_s20` int(11) NOT NULL,
  `allocate_s22` int(11) NOT NULL,
  `allocate_s24` int(11) NOT NULL,
  `allocate_s26` int(11) NOT NULL,
  `allocate_s28` int(11) NOT NULL,
  `allocate_s30` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `d_time` datetime DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `aql_auditor_list` */

DROP TABLE IF EXISTS `bai_pro3`.`aql_auditor_list`;

CREATE TABLE `bai_pro3`.`aql_auditor_list` (
  `login_id` varchar(15) NOT NULL COMMENT 'Employee ID',
  `section_list` varchar(10) NOT NULL COMMENT 'Section List',
  `module_list` varchar(100) NOT NULL COMMENT 'Module List',
  `department_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Department Category',
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `aql_track_log` */

DROP TABLE IF EXISTS `bai_pro3`.`aql_track_log`;

CREATE TABLE `bai_pro3`.`aql_track_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction ID',
  `date` date NOT NULL COMMENT 'Date',
  `section` int(10) NOT NULL COMMENT 'Section',
  `module` varchar(10) NOT NULL COMMENT 'Module',
  `carton_id` int(11) NOT NULL COMMENT 'Carton ID',
  `carton_status` int(5) NOT NULL COMMENT 'Carton Status 1. AQL Fail, 2. RE-Offered, 3. AQL Pass',
  `host_name` varchar(50) NOT NULL COMMENT 'Host Name',
  `log_name` varchar(50) NOT NULL COMMENT 'User Login ID',
  `shift` varchar(5) NOT NULL COMMENT 'Shift',
  `log_time` datetime NOT NULL COMMENT 'Log Time',
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`tid`,`carton_id`,`carton_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `audit_fail_db` */

DROP TABLE IF EXISTS `bai_pro3`.`audit_fail_db`;

CREATE TABLE `bai_pro3`.`audit_fail_db` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking ID',
  `style` varchar(50) DEFAULT NULL COMMENT 'Order Style',
  `schedule` int(11) DEFAULT NULL COMMENT 'Order Schedule',
  `size` varchar(10) DEFAULT NULL COMMENT 'Size',
  `pcs` int(11) NOT NULL COMMENT 'Quantity',
  `lastup` timestamp NULL DEFAULT current_timestamp() COMMENT 'Log Time',
  `remarks` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `tran_type` int(11) DEFAULT NULL COMMENT 'Transaction Mode',
  `fail_reason` int(11) DEFAULT NULL COMMENT 'Reason for Rejection',
  `done_by` varchar(50) DEFAULT NULL COMMENT 'Updated User Name',
  `color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule` (`schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track MCA fail details';

/*Table structure for table `audit_fail_db_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`audit_fail_db_archive`;

CREATE TABLE `bai_pro3`.`audit_fail_db_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking ID',
  `style` varchar(50) DEFAULT NULL COMMENT 'Order Style',
  `schedule` int(11) DEFAULT NULL COMMENT 'Order Schedule',
  `size` varchar(10) DEFAULT NULL COMMENT 'Size',
  `pcs` int(11) NOT NULL COMMENT 'Quantity',
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Log Time',
  `remarks` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `tran_type` int(11) DEFAULT NULL COMMENT 'Transaction Mode',
  `fail_reason` int(11) DEFAULT NULL COMMENT 'Reason for Rejection',
  `done_by` varchar(50) DEFAULT NULL COMMENT 'Updated User Name',
  `color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule` (`schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track MCA fail details';

/*Table structure for table `audit_ref` */

DROP TABLE IF EXISTS `bai_pro3`.`audit_ref`;

CREATE TABLE `bai_pro3`.`audit_ref` (
  `audit_ref` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking ID',
  `reason` varchar(200) NOT NULL COMMENT 'Reason for rejection',
  `rej_code` varchar(30) NOT NULL COMMENT 'Rejection Code',
  `category` varchar(50) NOT NULL COMMENT 'Category',
  `status` tinyint(1) NOT NULL COMMENT 'Status to filter in list',
  PRIMARY KEY (`audit_ref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Matrix to refer while updating FCA details';

/*Table structure for table `bai_emb_db` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_emb_db`;

CREATE TABLE `bai_pro3`.`bai_emb_db` (
  `emb_tid` int(11) NOT NULL AUTO_INCREMENT,
  `emb_code` varchar(200) NOT NULL,
  `buyer` varchar(100) NOT NULL,
  `season` varchar(100) NOT NULL,
  `schedule` varchar(30) NOT NULL,
  `gmt_style` varchar(50) NOT NULL,
  `psd` varchar(10) NOT NULL,
  `del_date` varchar(10) NOT NULL,
  `co_no` varchar(50) NOT NULL,
  `mo_type` varchar(50) NOT NULL,
  `mo_no` varchar(50) NOT NULL,
  `gmt_color` varchar(100) NOT NULL,
  `zfeature` varchar(5) NOT NULL,
  `mf_gqty` varchar(30) NOT NULL,
  `prtemb_item_code` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `color_size` varchar(400) NOT NULL,
  `requirement` varchar(20) NOT NULL,
  `wastage` varchar(10) NOT NULL,
  `op_desc` varchar(300) NOT NULL,
  `supplier` varchar(200) NOT NULL,
  `po_no` varchar(50) NOT NULL,
  `po_supplier` varchar(100) NOT NULL,
  `po_qty` varchar(30) NOT NULL,
  `l_stat` varchar(5) NOT NULL,
  `h_stat` varchar(5) NOT NULL,
  PRIMARY KEY (`emb_tid`),
  UNIQUE KEY `emb_code` (`emb_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Clone of M3 embellishment table';

/*Table structure for table `bai_emb_excess_db` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_emb_excess_db`;

CREATE TABLE `bai_pro3`.`bai_emb_excess_db` (
  `qms_tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction Id',
  `qms_style` varchar(30) NOT NULL COMMENT 'Style',
  `qms_schedule` varchar(20) NOT NULL COMMENT 'Schedule',
  `qms_color` varchar(150) NOT NULL COMMENT 'Color',
  `log_user` varchar(15) NOT NULL COMMENT 'Updated user',
  `log_date` date NOT NULL COMMENT 'Log date',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Log Time',
  `issued_by` varchar(30) NOT NULL COMMENT 'Good panels issued by',
  `qms_size` varchar(5) NOT NULL COMMENT 'Size',
  `qms_qty` smallint(6) NOT NULL COMMENT 'Qunatity',
  `qms_tran_type` smallint(6) NOT NULL COMMENT '0-Sent, 1-Received',
  `remarks` text NOT NULL COMMENT 'Remarks updation / Docket',
  `ref1` varchar(500) NOT NULL,
  `doc_no` varchar(20) NOT NULL COMMENT 'Docket_Reference',
  `location_id` varchar(30) NOT NULL COMMENT 'FK_Location map ID',
  PRIMARY KEY (`qms_tid`),
  KEY `qms_tran_type` (`qms_tran_type`),
  KEY `qms_color` (`qms_schedule`,`qms_color`),
  KEY `qms_size` (`qms_style`,`qms_size`),
  KEY `sscs` (`qms_style`,`qms_schedule`,`qms_color`,`qms_size`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To update quality/rejection details';

/*Table structure for table `bai_mod_db` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_mod_db`;

CREATE TABLE `bai_pro3`.`bai_mod_db` (
  `mod_id` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db`;

CREATE TABLE `bai_pro3`.`bai_orders_db` (
  `order_tid` varchar(200) NOT NULL COMMENT 'It''s a combination of style, schedule, color',
  `order_date` date NOT NULL COMMENT 'exfactory data',
  `order_upload_date` date NOT NULL COMMENT 'Order details uploaded date',
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL COMMENT 'Buyer Division',
  `order_style_no` varchar(60) NOT NULL COMMENT 'Style No',
  `order_del_no` varchar(60) NOT NULL COMMENT 'Schedule No',
  `order_col_des` varchar(150) NOT NULL COMMENT 'Color ',
  `order_col_code` varchar(100) NOT NULL COMMENT 'Dummy Filed',
  `order_s_xs` int(50) NOT NULL COMMENT 'Order qty of xs',
  `order_s_s` int(50) NOT NULL COMMENT 'Order qty of s',
  `order_s_m` int(50) NOT NULL COMMENT 'Order qty of m',
  `order_s_l` int(50) NOT NULL COMMENT 'Order qty of l',
  `order_s_xl` int(50) NOT NULL COMMENT 'Order qty of xl',
  `order_s_xxl` int(50) NOT NULL COMMENT 'Order qty of xxl',
  `order_s_xxxl` int(50) NOT NULL COMMENT 'Order qty of xxxl',
  `order_cat_stat` varchar(20) NOT NULL COMMENT 'dummy field',
  `order_cut_stat` varchar(20) NOT NULL COMMENT 'Cutting \n\nStatus',
  `order_ratio_stat` varchar(20) NOT NULL COMMENT 'Serial Number shows as clubbed.',
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL COMMENT 'Purchase Order',
  `order_no` varchar(100) NOT NULL COMMENT 'To track extra shipment (1) - manual ord qty modification',
  `old_order_s_xs` int(11) NOT NULL COMMENT 'Old Order qty of \n\nxs',
  `old_order_s_s` int(11) NOT NULL COMMENT 'Old Order qty of s',
  `old_order_s_m` int(11) NOT NULL COMMENT 'Old Order qty of m',
  `old_order_s_l` int(11) NOT NULL COMMENT 'Old Order qty of l',
  `old_order_s_xl` int(11) NOT NULL COMMENT 'Old Order qty of xl',
  `old_order_s_xxl` int(11) NOT NULL COMMENT 'Old Order qty of xxl',
  `old_order_s_xxxl` int(11) NOT NULL COMMENT 'Old Order qty of xxxl',
  `color_code` int(11) NOT NULL DEFAULT 0 COMMENT 'Color Code(Number Format)',
  `order_joins` varchar(500) NOT NULL DEFAULT '0' COMMENT 'To track \n\njoin schedules',
  `order_s_s01` int(11) NOT NULL COMMENT 'Order qty of size s01',
  `order_s_s02` int(11) NOT NULL COMMENT 'Order qty of size s02',
  `order_s_s03` int(11) NOT NULL COMMENT 'Order qty of size s03',
  `order_s_s04` int(11) NOT NULL COMMENT 'Order qty of size s04',
  `order_s_s05` int(11) NOT NULL COMMENT 'Order qty of size s05',
  `order_s_s06` int(11) NOT NULL COMMENT 'Order qty of size s06',
  `order_s_s07` int(11) NOT NULL COMMENT 'Order qty of size s07',
  `order_s_s08` int(11) NOT NULL COMMENT 'Order qty of size s08',
  `order_s_s09` int(11) NOT NULL COMMENT 'Order qty \n\nof size s09',
  `order_s_s10` int(11) NOT NULL COMMENT 'Order qty of size s10',
  `order_s_s11` int(11) NOT NULL COMMENT 'Order qty of size s11',
  `order_s_s12` int(11) NOT NULL COMMENT 'Order qty of size s12',
  `order_s_s13` int(11) NOT NULL COMMENT 'Order qty of size s13',
  `order_s_s14` int(11) NOT NULL COMMENT 'Order qty of size s14',
  `order_s_s15` int(11) NOT NULL COMMENT 'Order qty of size s15',
  `order_s_s16` int(11) NOT NULL COMMENT 'Order qty of size s16',
  `order_s_s17` int(11) NOT NULL COMMENT 'Order qty of size s17',
  `order_s_s18` int(11) NOT NULL COMMENT 'Order qty \n\nof size s18',
  `order_s_s19` int(11) NOT NULL COMMENT 'Order qty of size s19',
  `order_s_s20` int(11) NOT NULL COMMENT 'Order qty of size s20',
  `order_s_s21` int(11) NOT NULL COMMENT 'Order qty of size s21',
  `order_s_s22` int(11) NOT NULL COMMENT 'Order qty of size s22',
  `order_s_s23` int(11) NOT NULL COMMENT 'Order qty of size s23',
  `order_s_s24` int(11) NOT NULL COMMENT 'Order qty of size s24',
  `order_s_s25` int(11) NOT NULL COMMENT 'Order qty of size s25',
  `order_s_s26` int(11) NOT NULL COMMENT 'Order qty of size s26',
  `order_s_s27` int(11) NOT NULL COMMENT 'Order qty \n\nof size s27',
  `order_s_s28` int(11) NOT NULL COMMENT 'Order qty of size s28',
  `order_s_s29` int(11) NOT NULL COMMENT 'Order qty of size s29',
  `order_s_s30` int(11) NOT NULL COMMENT 'Order qty of size s30',
  `order_s_s31` int(11) NOT NULL COMMENT 'Order qty of size s31',
  `order_s_s32` int(11) NOT NULL COMMENT 'Order qty of size s32',
  `order_s_s33` int(11) NOT NULL COMMENT 'Order qty of size s33',
  `order_s_s34` int(11) NOT NULL COMMENT 'Order qty of size s34',
  `order_s_s35` int(11) NOT NULL COMMENT 'Order qty of size s35',
  `order_s_s36` int(11) NOT NULL COMMENT 'Order qty \n\nof size s36',
  `order_s_s37` int(11) NOT NULL COMMENT 'Order qty of size s37',
  `order_s_s38` int(11) NOT NULL COMMENT 'Order qty of size s38',
  `order_s_s39` int(11) NOT NULL COMMENT 'Order qty of size s39',
  `order_s_s40` int(11) NOT NULL COMMENT 'Order qty of size s40',
  `order_s_s41` int(11) NOT NULL COMMENT 'Order qty of size s41',
  `order_s_s42` int(11) NOT NULL COMMENT 'Order qty of size s42',
  `order_s_s43` int(11) NOT NULL COMMENT 'Order qty of size s43',
  `order_s_s44` int(11) NOT NULL COMMENT 'Order qty of size s44',
  `order_s_s45` int(11) NOT NULL COMMENT 'Order qty \n\nof size s45',
  `order_s_s46` int(11) NOT NULL COMMENT 'Order qty of size s46',
  `order_s_s47` int(11) NOT NULL COMMENT 'Order qty of size s47',
  `order_s_s48` int(11) NOT NULL COMMENT 'Order qty of size s48',
  `order_s_s49` int(11) NOT NULL COMMENT 'Order qty of size s49',
  `order_s_s50` int(11) NOT NULL COMMENT 'Order qty of size s50',
  `old_order_s_s01` int(11) NOT NULL COMMENT 'Old Order qty of size s01',
  `old_order_s_s02` int(11) NOT NULL COMMENT 'Old Order qty of size s02',
  `old_order_s_s03` int(11) NOT NULL COMMENT 'Old Order qty of size s03',
  `old_order_s_s04` int(11) NOT NULL COMMENT 'Old Order qty of size s04',
  `old_order_s_s05` int(11) NOT NULL COMMENT 'Old Order qty of size s05',
  `old_order_s_s06` int(11) NOT NULL COMMENT 'Old Order qty of size s06',
  `old_order_s_s07` int(11) NOT NULL COMMENT 'Old Order qty of size s07',
  `old_order_s_s08` int(11) NOT NULL COMMENT 'Old Order qty of size s08',
  `old_order_s_s09` int(11) NOT NULL COMMENT 'Old Order qty of size s09',
  `old_order_s_s10` int(11) NOT NULL COMMENT 'Old Order qty of size s10',
  `old_order_s_s11` int(11) NOT NULL COMMENT 'Old Order qty of size s11',
  `old_order_s_s12` int(11) NOT NULL COMMENT 'Old Order qty of size s12',
  `old_order_s_s13` int(11) NOT NULL COMMENT 'Old Order qty of size s13',
  `old_order_s_s14` int(11) NOT NULL COMMENT 'Old Order qty of size s14',
  `old_order_s_s15` int(11) NOT NULL COMMENT 'Old Order qty of size s15',
  `old_order_s_s16` int(11) NOT NULL COMMENT 'Old Order qty of size s16',
  `old_order_s_s17` int(11) NOT NULL COMMENT 'Old Order qty of size s17',
  `old_order_s_s18` int(11) NOT NULL COMMENT 'Old Order qty of size s18',
  `old_order_s_s19` int(11) NOT NULL COMMENT 'Old Order qty of size s19',
  `old_order_s_s20` int(11) NOT NULL COMMENT 'Old Order qty of size s20',
  `old_order_s_s21` int(11) NOT NULL COMMENT 'Old Order qty of size s21',
  `old_order_s_s22` int(11) NOT NULL COMMENT 'Old Order qty of size s22',
  `old_order_s_s23` int(11) NOT NULL COMMENT 'Old Order qty of size s23',
  `old_order_s_s24` int(11) NOT NULL COMMENT 'Old Order qty of size s24',
  `old_order_s_s25` int(11) NOT NULL COMMENT 'Old Order qty of size s25',
  `old_order_s_s26` int(11) NOT NULL COMMENT 'Old Order qty of size s26',
  `old_order_s_s27` int(11) NOT NULL COMMENT 'Old Order qty of size s27',
  `old_order_s_s28` int(11) NOT NULL COMMENT 'Old Order qty of size s28',
  `old_order_s_s29` int(11) NOT NULL COMMENT 'Old Order qty of size s29',
  `old_order_s_s30` int(11) NOT NULL COMMENT 'Old Order qty of size s30',
  `old_order_s_s31` int(11) NOT NULL COMMENT 'Old Order qty of size s31',
  `old_order_s_s32` int(11) NOT NULL COMMENT 'Old Order qty of size s32',
  `old_order_s_s33` int(11) NOT NULL COMMENT 'Old Order qty of size s33',
  `old_order_s_s34` int(11) NOT NULL COMMENT 'Old Order qty of size s34',
  `old_order_s_s35` int(11) NOT NULL COMMENT 'Old Order qty of size s35',
  `old_order_s_s36` int(11) NOT NULL COMMENT 'Old Order qty of size s36',
  `old_order_s_s37` int(11) NOT NULL COMMENT 'Old Order qty of size s37',
  `old_order_s_s38` int(11) NOT NULL COMMENT 'Old Order qty of size s38',
  `old_order_s_s39` int(11) NOT NULL COMMENT 'Old Order qty of size s39',
  `old_order_s_s40` int(11) NOT NULL COMMENT 'Old Order qty of size s40',
  `old_order_s_s41` int(11) NOT NULL COMMENT 'Old Order qty of size s41',
  `old_order_s_s42` int(11) NOT NULL COMMENT 'Old Order qty of size s42',
  `old_order_s_s43` int(11) NOT NULL COMMENT 'Old Order qty of size s43',
  `old_order_s_s44` int(11) NOT NULL COMMENT 'Old Order qty of size s44',
  `old_order_s_s45` int(11) NOT NULL COMMENT 'Old Order qty of size s45',
  `old_order_s_s46` int(11) NOT NULL COMMENT 'Old Order qty of size s46',
  `old_order_s_s47` int(11) NOT NULL COMMENT 'Old Order qty of size s47',
  `old_order_s_s48` int(11) NOT NULL COMMENT 'Old Order qty of size s48',
  `old_order_s_s49` int(11) NOT NULL COMMENT 'Old Order qty of size s49',
  `old_order_s_s50` int(11) NOT NULL COMMENT 'Old Order qty of size s50',
  `packing_method` varchar(12) NOT NULL COMMENT 'Packing Method',
  `style_id` varchar(20) NOT NULL COMMENT 'User defined style id',
  `carton_id` int(11) NOT NULL COMMENT 'Standard Carton quantity reference ID',
  `carton_print_status` int(11) DEFAULT NULL COMMENT 'Status to track packing list print or not',
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL \n\n- NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL COMMENT 'Trim card \n\npath',
  `trim_status` int(11) DEFAULT NULL COMMENT 'Trim card status',
  `fsp_time_line` varchar(500) NOT NULL COMMENT 'FSP remarks',
  `fsp_last_up` datetime NOT NULL COMMENT 'FSP last updated log',
  `order_embl_a` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_b` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_c` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_d` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_e` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_f` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_g` int(11) NOT NULL,
  `order_embl_h` int(11) NOT NULL,
  `act_cut` int(11) NOT NULL COMMENT 'Actual cut quantity',
  `act_in` int(11) NOT NULL COMMENT 'Actual input \n\nquantity',
  `act_fca` int(11) NOT NULL COMMENT 'FCA completed quantity',
  `act_mca` int(11) NOT NULL COMMENT 'MCA completed quantity',
  `act_fg` int(11) NOT NULL COMMENT 'FG status',
  `cart_pending` int(11) NOT NULL COMMENT 'Carton pending count',
  `priority` int(11) NOT NULL COMMENT 'Priority based on the process',
  `act_ship` int(11) NOT NULL COMMENT 'Actual Ship Qty',
  `output` int(11) NOT NULL COMMENT 'Hourly Output \n\nUpdate',
  `act_rej` int(11) NOT NULL COMMENT 'Actual Rejections',
  `title_size_s01` varchar(20) NOT NULL COMMENT ' SIZE s01 Title FIELD',
  `title_size_s02` varchar(20) NOT NULL COMMENT ' SIZE s02 Title FIELD',
  `title_size_s03` varchar(20) NOT NULL COMMENT ' SIZE s03 Title FIELD',
  `title_size_s04` varchar(20) NOT NULL COMMENT ' SIZE s04 Title FIELD',
  `title_size_s05` varchar(20) NOT NULL COMMENT ' SIZE s05 Title FIELD',
  `title_size_s06` varchar(20) NOT NULL COMMENT ' SIZE s06 Title FIELD',
  `title_size_s07` varchar(20) NOT NULL COMMENT ' SIZE s07 Title FIELD',
  `title_size_s08` varchar(20) NOT NULL COMMENT ' SIZE s08 Title FIELD',
  `title_size_s09` varchar(20) NOT NULL COMMENT ' SIZE s09 Title FIELD',
  `title_size_s10` varchar(20) NOT NULL COMMENT ' SIZE s10 Title FIELD',
  `title_size_s11` varchar(20) NOT NULL COMMENT ' SIZE s11 Title FIELD',
  `title_size_s12` varchar(20) NOT NULL COMMENT ' SIZE s12 Title FIELD',
  `title_size_s13` varchar(20) NOT NULL COMMENT ' SIZE s13 Title FIELD',
  `title_size_s14` varchar(20) NOT NULL COMMENT ' SIZE s14 Title FIELD',
  `title_size_s15` varchar(20) NOT NULL COMMENT ' SIZE s15 Title FIELD',
  `title_size_s16` varchar(20) NOT NULL COMMENT ' SIZE s16 Title FIELD',
  `title_size_s17` varchar(20) NOT NULL COMMENT ' SIZE s17 Title FIELD',
  `title_size_s18` varchar(20) NOT NULL COMMENT ' SIZE s18 Title FIELD',
  `title_size_s19` varchar(20) NOT NULL COMMENT ' SIZE s19 Title FIELD',
  `title_size_s20` varchar(20) NOT NULL COMMENT ' SIZE s20 Title FIELD',
  `title_size_s21` varchar(20) NOT NULL COMMENT ' SIZE s21 Title FIELD',
  `title_size_s22` varchar(20) NOT NULL COMMENT ' SIZE s22 Title FIELD',
  `title_size_s23` varchar(20) NOT NULL COMMENT ' SIZE s23 Title FIELD',
  `title_size_s24` varchar(20) NOT NULL COMMENT ' SIZE s24 Title FIELD',
  `title_size_s25` varchar(20) NOT NULL COMMENT ' SIZE s25 Title FIELD',
  `title_size_s26` varchar(20) NOT NULL COMMENT ' SIZE s26 Title FIELD',
  `title_size_s27` varchar(20) NOT NULL COMMENT ' SIZE s27 Title FIELD',
  `title_size_s28` varchar(20) NOT NULL COMMENT ' SIZE s28 Title FIELD',
  `title_size_s29` varchar(20) NOT NULL COMMENT ' SIZE s29 Title FIELD',
  `title_size_s30` varchar(20) NOT NULL COMMENT ' SIZE s30 Title FIELD',
  `title_size_s31` varchar(20) NOT NULL COMMENT ' SIZE s31 Title FIELD',
  `title_size_s32` varchar(20) NOT NULL COMMENT ' SIZE s32 Title FIELD',
  `title_size_s33` varchar(20) NOT NULL COMMENT ' SIZE s33 Title FIELD',
  `title_size_s34` varchar(20) NOT NULL COMMENT ' SIZE s34 Title FIELD',
  `title_size_s35` varchar(20) NOT NULL COMMENT ' SIZE s35 Title FIELD',
  `title_size_s36` varchar(20) NOT NULL COMMENT ' SIZE s36 Title FIELD',
  `title_size_s37` varchar(20) NOT NULL COMMENT ' SIZE s37 Title FIELD',
  `title_size_s38` varchar(20) NOT NULL COMMENT ' SIZE s38 Title FIELD',
  `title_size_s39` varchar(20) NOT NULL COMMENT ' SIZE s39 Title FIELD',
  `title_size_s40` varchar(20) NOT NULL COMMENT ' SIZE s40 Title FIELD',
  `title_size_s41` varchar(20) NOT NULL COMMENT ' SIZE s41 Title FIELD',
  `title_size_s42` varchar(20) NOT NULL COMMENT ' SIZE s42 Title FIELD',
  `title_size_s43` varchar(20) NOT NULL COMMENT ' SIZE s43 Title FIELD',
  `title_size_s44` varchar(20) NOT NULL COMMENT ' SIZE s44 Title FIELD',
  `title_size_s45` varchar(20) NOT NULL COMMENT ' SIZE s45 Title FIELD',
  `title_size_s46` varchar(20) NOT NULL COMMENT ' SIZE s46 Title FIELD',
  `title_size_s47` varchar(20) NOT NULL COMMENT ' SIZE s47 Title FIELD',
  `title_size_s48` varchar(20) NOT NULL COMMENT ' SIZE s48 Title FIELD',
  `title_size_s49` varchar(20) NOT NULL COMMENT ' SIZE s49 Title FIELD',
  `title_size_s50` varchar(20) NOT NULL COMMENT ' SIZE s50 Title FIELD',
  `title_flag` int(11) NOT NULL DEFAULT 0 COMMENT 'Title Flag',
  `title_size_xs` varchar(20) NOT NULL,
  `title_size_s` varchar(20) NOT NULL,
  `title_size_m` varchar(20) NOT NULL,
  `title_size_l` varchar(20) NOT NULL,
  `title_size_xl` varchar(20) NOT NULL,
  `title_size_xxl` varchar(20) NOT NULL,
  `title_size_xxxl` varchar(20) NOT NULL,
  `smv` float(11,2) NOT NULL COMMENT 'SMV Value',
  `smo` int(11) DEFAULT NULL COMMENT 'SMO Value',
  `destination` varchar(10) DEFAULT NULL,
  `bts_status` int(11) NOT NULL DEFAULT 0,
  `zfeature` varchar(15) DEFAULT NULL COMMENT 'Country Block',
  `ratio_packing_method` varchar(45) DEFAULT NULL COMMENT 'Ratio Packing Method 1.Single: Single \n\nSize Multiple Colours Ratio Packing, 2.Multiple: Multiple Sizes Multiple Colours Ratio Packing',
  `co_no` varchar(25) DEFAULT NULL COMMENT 'customer order number',
  `vpo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Order details for CMS and other applications';

/*Table structure for table `bai_orders_db_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_archive`;

CREATE TABLE `bai_pro3`.`bai_orders_db_archive` (
  `order_tid` varchar(200) NOT NULL,
  `order_date` date NOT NULL,
  `order_upload_date` date NOT NULL,
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL,
  `order_style_no` varchar(60) NOT NULL,
  `order_del_no` varchar(60) NOT NULL,
  `order_col_des` varchar(150) NOT NULL,
  `order_col_code` varchar(100) NOT NULL,
  `order_s_xs` int(50) NOT NULL,
  `order_s_s` int(50) NOT NULL,
  `order_s_m` int(50) NOT NULL,
  `order_s_l` int(50) NOT NULL,
  `order_s_xl` int(50) NOT NULL,
  `order_s_xxl` int(50) NOT NULL,
  `order_s_xxxl` int(50) NOT NULL,
  `order_cat_stat` varchar(20) NOT NULL,
  `order_cut_stat` varchar(20) NOT NULL,
  `order_ratio_stat` varchar(20) NOT NULL COMMENT 'Serial Number shows as clubbed.',
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL,
  `order_no` varchar(100) NOT NULL COMMENT 'To track \n\nextra shipment (1) - manual ord qty modification',
  `old_order_s_xs` int(11) NOT NULL,
  `old_order_s_s` int(11) NOT NULL,
  `old_order_s_m` int(11) NOT NULL,
  `old_order_s_l` int(11) NOT NULL,
  `old_order_s_xl` int(11) NOT NULL,
  `old_order_s_xxl` int(11) NOT NULL,
  `old_order_s_xxxl` int(11) NOT NULL,
  `color_code` int(11) DEFAULT NULL,
  `order_joins` varchar(500) NOT NULL DEFAULT '0' COMMENT 'To track join schedules',
  `order_s_s01` int(11) NOT NULL COMMENT 'Order qty of size s01',
  `order_s_s02` int(11) NOT NULL COMMENT 'Order qty of size s02',
  `order_s_s03` int(11) NOT NULL COMMENT 'Order qty of size s03',
  `order_s_s04` int(11) NOT NULL COMMENT 'Order qty of size s04',
  `order_s_s05` int(11) NOT NULL COMMENT 'Order qty \n\nof size s05',
  `order_s_s06` int(11) NOT NULL COMMENT 'Order qty of size s06',
  `order_s_s07` int(11) NOT NULL COMMENT 'Order qty of size s07',
  `order_s_s08` int(11) NOT NULL COMMENT 'Order qty of size s08',
  `order_s_s09` int(11) NOT NULL COMMENT 'Order qty of size s09',
  `order_s_s10` int(11) NOT NULL COMMENT 'Order qty of size s10',
  `order_s_s11` int(11) NOT NULL COMMENT 'Order qty of size s11',
  `order_s_s12` int(11) NOT NULL COMMENT 'Order qty of size s12',
  `order_s_s13` int(11) NOT NULL COMMENT 'Order qty of size s13',
  `order_s_s14` int(11) NOT NULL COMMENT 'Order qty \n\nof size s14',
  `order_s_s15` int(11) NOT NULL COMMENT 'Order qty of size s15',
  `order_s_s16` int(11) NOT NULL COMMENT 'Order qty of size s16',
  `order_s_s17` int(11) NOT NULL COMMENT 'Order qty of size s17',
  `order_s_s18` int(11) NOT NULL COMMENT 'Order qty of size s18',
  `order_s_s19` int(11) NOT NULL COMMENT 'Order qty of size s19',
  `order_s_s20` int(11) NOT NULL COMMENT 'Order qty of size s20',
  `order_s_s21` int(11) NOT NULL COMMENT 'Order qty of size s21',
  `order_s_s22` int(11) NOT NULL COMMENT 'Order qty of size s22',
  `order_s_s23` int(11) NOT NULL COMMENT 'Order qty \n\nof size s23',
  `order_s_s24` int(11) NOT NULL COMMENT 'Order qty of size s24',
  `order_s_s25` int(11) NOT NULL COMMENT 'Order qty of size s25',
  `order_s_s26` int(11) NOT NULL COMMENT 'Order qty of size s26',
  `order_s_s27` int(11) NOT NULL COMMENT 'Order qty of size s27',
  `order_s_s28` int(11) NOT NULL COMMENT 'Order qty of size s28',
  `order_s_s29` int(11) NOT NULL COMMENT 'Order qty of size s29',
  `order_s_s30` int(11) NOT NULL COMMENT 'Order qty of size s30',
  `order_s_s31` int(11) NOT NULL COMMENT 'Order qty of size s31',
  `order_s_s32` int(11) NOT NULL COMMENT 'Order qty \n\nof size s32',
  `order_s_s33` int(11) NOT NULL COMMENT 'Order qty of size s33',
  `order_s_s34` int(11) NOT NULL COMMENT 'Order qty of size s34',
  `order_s_s35` int(11) NOT NULL COMMENT 'Order qty of size s35',
  `order_s_s36` int(11) NOT NULL COMMENT 'Order qty of size s36',
  `order_s_s37` int(11) NOT NULL COMMENT 'Order qty of size s37',
  `order_s_s38` int(11) NOT NULL COMMENT 'Order qty of size s38',
  `order_s_s39` int(11) NOT NULL COMMENT 'Order qty of size s39',
  `order_s_s40` int(11) NOT NULL COMMENT 'Order qty of size s40',
  `order_s_s41` int(11) NOT NULL COMMENT 'Order qty \n\nof size s41',
  `order_s_s42` int(11) NOT NULL COMMENT 'Order qty of size s42',
  `order_s_s43` int(11) NOT NULL COMMENT 'Order qty of size s43',
  `order_s_s44` int(11) NOT NULL COMMENT 'Order qty of size s44',
  `order_s_s45` int(11) NOT NULL COMMENT 'Order qty of size s45',
  `order_s_s46` int(11) NOT NULL COMMENT 'Order qty of size s46',
  `order_s_s47` int(11) NOT NULL COMMENT 'Order qty of size s47',
  `order_s_s48` int(11) NOT NULL COMMENT 'Order qty of size s48',
  `order_s_s49` int(11) NOT NULL COMMENT 'Order qty of size s49',
  `order_s_s50` int(11) NOT NULL COMMENT 'Order qty \n\nof size s50',
  `old_order_s_s01` int(11) NOT NULL COMMENT 'Old Order qty of size s01',
  `old_order_s_s02` int(11) NOT NULL COMMENT 'Old Order qty of \n\nsize s02',
  `old_order_s_s03` int(11) NOT NULL COMMENT 'Old Order qty of size s03',
  `old_order_s_s04` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns04',
  `old_order_s_s05` int(11) NOT NULL COMMENT 'Old Order qty of size s05',
  `old_order_s_s06` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns06',
  `old_order_s_s07` int(11) NOT NULL COMMENT 'Old Order qty of size s07',
  `old_order_s_s08` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns08',
  `old_order_s_s09` int(11) NOT NULL COMMENT 'Old Order qty of size s09',
  `old_order_s_s10` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns10',
  `old_order_s_s11` int(11) NOT NULL COMMENT 'Old Order qty of size s11',
  `old_order_s_s12` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns12',
  `old_order_s_s13` int(11) NOT NULL COMMENT 'Old Order qty of size s13',
  `old_order_s_s14` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns14',
  `old_order_s_s15` int(11) NOT NULL COMMENT 'Old Order qty of size s15',
  `old_order_s_s16` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns16',
  `old_order_s_s17` int(11) NOT NULL COMMENT 'Old Order qty of size s17',
  `old_order_s_s18` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns18',
  `old_order_s_s19` int(11) NOT NULL COMMENT 'Old Order qty of size s19',
  `old_order_s_s20` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns20',
  `old_order_s_s21` int(11) NOT NULL COMMENT 'Old Order qty of size s21',
  `old_order_s_s22` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns22',
  `old_order_s_s23` int(11) NOT NULL COMMENT 'Old Order qty of size s23',
  `old_order_s_s24` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns24',
  `old_order_s_s25` int(11) NOT NULL COMMENT 'Old Order qty of size s25',
  `old_order_s_s26` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns26',
  `old_order_s_s27` int(11) NOT NULL COMMENT 'Old Order qty of size s27',
  `old_order_s_s28` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns28',
  `old_order_s_s29` int(11) NOT NULL COMMENT 'Old Order qty of size s29',
  `old_order_s_s30` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns30',
  `old_order_s_s31` int(11) NOT NULL COMMENT 'Old Order qty of size s31',
  `old_order_s_s32` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns32',
  `old_order_s_s33` int(11) NOT NULL COMMENT 'Old Order qty of size s33',
  `old_order_s_s34` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns34',
  `old_order_s_s35` int(11) NOT NULL COMMENT 'Old Order qty of size s35',
  `old_order_s_s36` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns36',
  `old_order_s_s37` int(11) NOT NULL COMMENT 'Old Order qty of size s37',
  `old_order_s_s38` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns38',
  `old_order_s_s39` int(11) NOT NULL COMMENT 'Old Order qty of size s39',
  `old_order_s_s40` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns40',
  `old_order_s_s41` int(11) NOT NULL COMMENT 'Old Order qty of size s41',
  `old_order_s_s42` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns42',
  `old_order_s_s43` int(11) NOT NULL COMMENT 'Old Order qty of size s43',
  `old_order_s_s44` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns44',
  `old_order_s_s45` int(11) NOT NULL COMMENT 'Old Order qty of size s45',
  `old_order_s_s46` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns46',
  `old_order_s_s47` int(11) NOT NULL COMMENT 'Old Order qty of size s47',
  `old_order_s_s48` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns48',
  `old_order_s_s49` int(11) NOT NULL COMMENT 'Old Order qty of size s49',
  `old_order_s_s50` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns50',
  `packing_method` varchar(12) NOT NULL COMMENT 'Packing Method',
  `style_id` varchar(20) NOT NULL COMMENT 'User defined style id',
  `carton_id` int(11) NOT NULL COMMENT 'Standard Carton quantity reference ID',
  `carton_print_status` int(11) DEFAULT NULL COMMENT 'Status to track \n\npacking list print or not',
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL COMMENT 'Trim card path',
  `trim_status` int(11) DEFAULT NULL COMMENT 'Trim card status',
  `fsp_time_line` varchar(500) NOT NULL COMMENT 'FSP remarks',
  `fsp_last_up` datetime NOT NULL COMMENT 'FSP last updated log',
  `order_embl_a` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_b` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_c` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_d` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_e` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_f` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_g` int(11) NOT NULL,
  `order_embl_h` int(11) NOT NULL,
  `act_cut` int(11) NOT NULL COMMENT 'Actual cut quantity',
  `act_in` int(11) NOT NULL COMMENT 'Actual input quantity',
  `act_fca` int(11) NOT NULL COMMENT 'FCA completed quantity',
  `act_mca` int(11) NOT NULL COMMENT 'MCA completed quantity',
  `act_fg` int(11) NOT NULL COMMENT 'FG \n\nstatus',
  `cart_pending` int(11) NOT NULL COMMENT 'Carton pending count',
  `priority` int(11) NOT NULL COMMENT 'Priority based on the process',
  `act_ship` int(11) NOT NULL COMMENT 'Actual Ship Qty',
  `output` int(11) NOT NULL COMMENT 'Hourly Output Update',
  `act_rej` int(11) NOT NULL COMMENT 'Actual Rejections',
  `title_size_s01` varchar(20) NOT NULL COMMENT ' SIZE s01 Title FIELD',
  `title_size_s02` varchar(20) NOT NULL COMMENT ' \n\nSIZE s02 Title FIELD',
  `title_size_s03` varchar(20) NOT NULL COMMENT ' SIZE s03 Title FIELD',
  `title_size_s04` varchar(20) NOT NULL COMMENT ' SIZE \n\ns04 Title FIELD',
  `title_size_s05` varchar(20) NOT NULL COMMENT ' SIZE s05 Title FIELD',
  `title_size_s06` varchar(20) NOT NULL COMMENT ' SIZE s06 \n\nTitle FIELD',
  `title_size_s07` varchar(20) NOT NULL COMMENT ' SIZE s07 Title FIELD',
  `title_size_s08` varchar(20) NOT NULL COMMENT ' SIZE s08 Title \n\nFIELD',
  `title_size_s09` varchar(20) NOT NULL COMMENT ' SIZE s09 Title FIELD',
  `title_size_s10` varchar(20) NOT NULL COMMENT ' SIZE s10 Title \n\nFIELD',
  `title_size_s11` varchar(20) NOT NULL COMMENT ' SIZE s11 Title FIELD',
  `title_size_s12` varchar(20) NOT NULL COMMENT ' SIZE s12 Title \n\nFIELD',
  `title_size_s13` varchar(20) NOT NULL COMMENT ' SIZE s13 Title FIELD',
  `title_size_s14` varchar(20) NOT NULL COMMENT ' SIZE s14 Title \n\nFIELD',
  `title_size_s15` varchar(20) NOT NULL COMMENT ' SIZE s15 Title FIELD',
  `title_size_s16` varchar(20) NOT NULL COMMENT ' SIZE s16 Title \n\nFIELD',
  `title_size_s17` varchar(20) NOT NULL COMMENT ' SIZE s17 Title FIELD',
  `title_size_s18` varchar(20) NOT NULL COMMENT ' SIZE s18 Title \n\nFIELD',
  `title_size_s19` varchar(20) NOT NULL COMMENT ' SIZE s19 Title FIELD',
  `title_size_s20` varchar(20) NOT NULL COMMENT ' SIZE s20 Title \n\nFIELD',
  `title_size_s21` varchar(20) NOT NULL COMMENT ' SIZE s21 Title FIELD',
  `title_size_s22` varchar(20) NOT NULL COMMENT ' SIZE s22 Title \n\nFIELD',
  `title_size_s23` varchar(20) NOT NULL COMMENT ' SIZE s23 Title FIELD',
  `title_size_s24` varchar(20) NOT NULL COMMENT ' SIZE s24 Title \n\nFIELD',
  `title_size_s25` varchar(20) NOT NULL COMMENT ' SIZE s25 Title FIELD',
  `title_size_s26` varchar(20) NOT NULL COMMENT ' SIZE s26 Title \n\nFIELD',
  `title_size_s27` varchar(20) NOT NULL COMMENT ' SIZE s27 Title FIELD',
  `title_size_s28` varchar(20) NOT NULL COMMENT ' SIZE s28 Title \n\nFIELD',
  `title_size_s29` varchar(20) NOT NULL COMMENT ' SIZE s29 Title FIELD',
  `title_size_s30` varchar(20) NOT NULL COMMENT ' SIZE s30 Title \n\nFIELD',
  `title_size_s31` varchar(20) NOT NULL COMMENT ' SIZE s31 Title FIELD',
  `title_size_s32` varchar(20) NOT NULL COMMENT ' SIZE s32 Title \n\nFIELD',
  `title_size_s33` varchar(20) NOT NULL COMMENT ' SIZE s33 Title FIELD',
  `title_size_s34` varchar(20) NOT NULL COMMENT ' SIZE s34 Title \n\nFIELD',
  `title_size_s35` varchar(20) NOT NULL COMMENT ' SIZE s35 Title FIELD',
  `title_size_s36` varchar(20) NOT NULL COMMENT ' SIZE s36 Title \n\nFIELD',
  `title_size_s37` varchar(20) NOT NULL COMMENT ' SIZE s37 Title FIELD',
  `title_size_s38` varchar(20) NOT NULL COMMENT ' SIZE s38 Title \n\nFIELD',
  `title_size_s39` varchar(20) NOT NULL COMMENT ' SIZE s39 Title FIELD',
  `title_size_s40` varchar(20) NOT NULL COMMENT ' SIZE s40 Title \n\nFIELD',
  `title_size_s41` varchar(20) NOT NULL COMMENT ' SIZE s41 Title FIELD',
  `title_size_s42` varchar(20) NOT NULL COMMENT ' SIZE s42 Title \n\nFIELD',
  `title_size_s43` varchar(20) NOT NULL COMMENT ' SIZE s43 Title FIELD',
  `title_size_s44` varchar(20) NOT NULL COMMENT ' SIZE s44 Title \n\nFIELD',
  `title_size_s45` varchar(20) NOT NULL COMMENT ' SIZE s45 Title FIELD',
  `title_size_s46` varchar(20) NOT NULL COMMENT ' SIZE s46 Title \n\nFIELD',
  `title_size_s47` varchar(20) NOT NULL COMMENT ' SIZE s47 Title FIELD',
  `title_size_s48` varchar(20) NOT NULL COMMENT ' SIZE s48 Title \n\nFIELD',
  `title_size_s49` varchar(20) NOT NULL COMMENT ' SIZE s49 Title FIELD',
  `title_size_s50` varchar(20) NOT NULL COMMENT ' SIZE s50 Title \n\nFIELD',
  `title_flag` int(11) NOT NULL DEFAULT 0 COMMENT 'Title Flag',
  `title_size_xs` varchar(20) NOT NULL,
  `title_size_s` varchar(20) NOT NULL,
  `title_size_m` varchar(20) NOT NULL,
  `title_size_l` varchar(20) NOT NULL,
  `title_size_xl` varchar(20) NOT NULL,
  `title_size_xxl` varchar(20) NOT NULL,
  `title_size_xxxl` varchar(20) NOT NULL,
  `smv` float(11,2) NOT NULL COMMENT 'SMV Value',
  `smo` int(11) DEFAULT NULL COMMENT 'SMO Value',
  `destination` varchar(10) DEFAULT NULL,
  `bts_status` int(11) DEFAULT NULL,
  `zfeature` varchar(8) DEFAULT NULL,
  `ratio_packing_method` varchar(45) NOT NULL COMMENT 'Ratio Packing Method 1.Single: Single Size Multiple Colours Ratio Packing, 2.Multiple: \n\nMultiple Sizes Multiple Colours Ratio Packing',
  PRIMARY KEY (`order_tid`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_archive2` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_archive2`;

CREATE TABLE `bai_pro3`.`bai_orders_db_archive2` (
  `order_tid` varchar(200) NOT NULL,
  `order_date` date NOT NULL,
  `order_upload_date` date NOT NULL,
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL,
  `order_style_no` varchar(60) NOT NULL,
  `order_del_no` varchar(60) NOT NULL,
  `order_col_des` varchar(150) NOT NULL,
  `order_col_code` varchar(100) NOT NULL,
  `order_s_xs` int(50) NOT NULL,
  `order_s_s` int(50) NOT NULL,
  `order_s_m` int(50) NOT NULL,
  `order_s_l` int(50) NOT NULL,
  `order_s_xl` int(50) NOT NULL,
  `order_s_xxl` int(50) NOT NULL,
  `order_s_xxxl` int(50) NOT NULL,
  `order_cat_stat` varchar(20) NOT NULL,
  `order_cut_stat` varchar(20) NOT NULL,
  `order_ratio_stat` varchar(20) NOT NULL COMMENT 'Serial Number shows as clubbed.',
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL,
  `order_no` varchar(100) NOT NULL COMMENT 'To track extra shipment (1) - manual ord qty modification',
  `old_order_s_xs` int(11) NOT NULL,
  `old_order_s_s` int(11) NOT NULL,
  `old_order_s_m` int(11) NOT NULL,
  `old_order_s_l` int(11) NOT NULL,
  `old_order_s_xl` int(11) NOT NULL,
  `old_order_s_xxl` int(11) NOT NULL,
  `old_order_s_xxxl` int(11) NOT NULL,
  `color_code` int(11) DEFAULT NULL,
  `order_joins` varchar(500) NOT NULL DEFAULT '0' COMMENT 'To track join schedules',
  `order_s_s06` int(11) NOT NULL,
  `order_s_s08` int(11) NOT NULL,
  `order_s_s10` int(11) NOT NULL,
  `order_s_s12` int(11) NOT NULL,
  `order_s_s14` int(11) NOT NULL,
  `order_s_s16` int(11) NOT NULL,
  `order_s_s18` int(11) NOT NULL,
  `order_s_s20` int(11) NOT NULL,
  `order_s_s22` int(11) NOT NULL,
  `order_s_s24` int(11) NOT NULL,
  `order_s_s26` int(11) NOT NULL,
  `order_s_s28` int(11) NOT NULL,
  `order_s_s30` int(11) NOT NULL,
  `old_order_s_s06` int(11) NOT NULL,
  `old_order_s_s08` int(11) NOT NULL,
  `old_order_s_s10` int(11) NOT NULL,
  `old_order_s_s12` int(11) NOT NULL,
  `old_order_s_s14` int(11) NOT NULL,
  `old_order_s_s16` int(11) NOT NULL,
  `old_order_s_s18` int(11) NOT NULL,
  `old_order_s_s20` int(11) NOT NULL,
  `old_order_s_s22` int(11) NOT NULL,
  `old_order_s_s24` int(11) NOT NULL,
  `old_order_s_s26` int(11) NOT NULL,
  `old_order_s_s28` int(11) NOT NULL,
  `old_order_s_s30` int(11) NOT NULL,
  `packing_method` varchar(12) NOT NULL COMMENT 'Packing Method',
  `style_id` varchar(20) NOT NULL COMMENT 'User defined style id',
  `carton_id` int(11) NOT NULL COMMENT 'Standard Carton quantity reference ID',
  `carton_print_status` int(11) DEFAULT NULL COMMENT 'Status to track packing list print or not',
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL COMMENT 'Trim card path',
  `trim_status` int(11) DEFAULT NULL COMMENT 'Trim card status',
  `fsp_time_line` varchar(500) NOT NULL COMMENT 'FSP remarks',
  `fsp_last_up` datetime NOT NULL COMMENT 'FSP last updated log',
  `order_embl_a` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_b` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_c` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_d` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_e` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_f` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_g` int(11) NOT NULL,
  `order_embl_h` int(11) NOT NULL,
  `act_cut` int(11) NOT NULL COMMENT 'Actual cut quantity',
  `act_in` int(11) NOT NULL COMMENT 'Actual input quantity',
  `act_fca` int(11) NOT NULL COMMENT 'FCA completed quantity',
  `act_mca` int(11) NOT NULL COMMENT 'MCA completed quantity',
  `act_fg` int(11) NOT NULL COMMENT 'FG status',
  `cart_pending` int(11) NOT NULL COMMENT 'Carton pending count',
  `priority` int(11) NOT NULL COMMENT 'Priority based on the process',
  `act_ship` int(11) NOT NULL COMMENT 'Actual Ship Qty',
  `output` int(11) NOT NULL COMMENT 'Hourly Output Update',
  `act_rej` int(11) NOT NULL,
  `destination` varchar(20) NOT NULL,
  `vpo` varchar(20) DEFAULT NULL,
  `smv` float DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_club` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_club`;

CREATE TABLE `bai_pro3`.`bai_orders_db_club` (
  `order_tid` varchar(200) NOT NULL COMMENT 'It''s a combination of style, schedule, color',
  `order_date` date NOT NULL COMMENT 'exfactory data',
  `order_upload_date` date NOT NULL COMMENT 'Order details uploaded date',
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL COMMENT 'Buyer Division',
  `order_style_no` varchar(60) NOT NULL COMMENT 'Style No',
  `order_del_no` varchar(60) NOT NULL COMMENT 'Schedule No',
  `order_col_des` varchar(150) NOT NULL COMMENT 'Color ',
  `order_col_code` varchar(100) NOT NULL COMMENT 'Dummy Filed',
  `order_s_xs` int(50) NOT NULL COMMENT 'Order qty of xs',
  `order_s_s` int(50) NOT NULL COMMENT 'Order qty of s',
  `order_s_m` int(50) NOT NULL COMMENT 'Order qty of m',
  `order_s_l` int(50) NOT NULL COMMENT 'Order qty of l',
  `order_s_xl` int(50) NOT NULL COMMENT 'Order qty of xl',
  `order_s_xxl` int(50) NOT NULL COMMENT 'Order qty of xxl',
  `order_s_xxxl` int(50) NOT NULL COMMENT 'Order qty of xxxl',
  `order_cat_stat` varchar(20) NOT NULL COMMENT 'dummy field',
  `order_cut_stat` varchar(20) NOT NULL COMMENT 'Cutting \n\nStatus',
  `order_ratio_stat` varchar(20) NOT NULL COMMENT 'Serial Number shows as clubbed.',
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL COMMENT 'Purchase Order',
  `order_no` varchar(100) NOT NULL COMMENT 'To track extra shipment (1) - manual ord qty modification',
  `old_order_s_xs` int(11) NOT NULL COMMENT 'Old Order qty of \n\nxs',
  `old_order_s_s` int(11) NOT NULL COMMENT 'Old Order qty of s',
  `old_order_s_m` int(11) NOT NULL COMMENT 'Old Order qty of m',
  `old_order_s_l` int(11) NOT NULL COMMENT 'Old Order qty of l',
  `old_order_s_xl` int(11) NOT NULL COMMENT 'Old Order qty of xl',
  `old_order_s_xxl` int(11) NOT NULL COMMENT 'Old Order qty of xxl',
  `old_order_s_xxxl` int(11) NOT NULL COMMENT 'Old Order qty of xxxl',
  `color_code` int(11) NOT NULL DEFAULT 0 COMMENT 'Color Code(Number Format)',
  `order_joins` varchar(500) NOT NULL DEFAULT '0' COMMENT 'To track \n\njoin schedules',
  `order_s_s01` int(11) NOT NULL COMMENT 'Order qty of size s01',
  `order_s_s02` int(11) NOT NULL COMMENT 'Order qty of size s02',
  `order_s_s03` int(11) NOT NULL COMMENT 'Order qty of size s03',
  `order_s_s04` int(11) NOT NULL COMMENT 'Order qty of size s04',
  `order_s_s05` int(11) NOT NULL COMMENT 'Order qty of size s05',
  `order_s_s06` int(11) NOT NULL COMMENT 'Order qty of size s06',
  `order_s_s07` int(11) NOT NULL COMMENT 'Order qty of size s07',
  `order_s_s08` int(11) NOT NULL COMMENT 'Order qty of size s08',
  `order_s_s09` int(11) NOT NULL COMMENT 'Order qty \n\nof size s09',
  `order_s_s10` int(11) NOT NULL COMMENT 'Order qty of size s10',
  `order_s_s11` int(11) NOT NULL COMMENT 'Order qty of size s11',
  `order_s_s12` int(11) NOT NULL COMMENT 'Order qty of size s12',
  `order_s_s13` int(11) NOT NULL COMMENT 'Order qty of size s13',
  `order_s_s14` int(11) NOT NULL COMMENT 'Order qty of size s14',
  `order_s_s15` int(11) NOT NULL COMMENT 'Order qty of size s15',
  `order_s_s16` int(11) NOT NULL COMMENT 'Order qty of size s16',
  `order_s_s17` int(11) NOT NULL COMMENT 'Order qty of size s17',
  `order_s_s18` int(11) NOT NULL COMMENT 'Order qty \n\nof size s18',
  `order_s_s19` int(11) NOT NULL COMMENT 'Order qty of size s19',
  `order_s_s20` int(11) NOT NULL COMMENT 'Order qty of size s20',
  `order_s_s21` int(11) NOT NULL COMMENT 'Order qty of size s21',
  `order_s_s22` int(11) NOT NULL COMMENT 'Order qty of size s22',
  `order_s_s23` int(11) NOT NULL COMMENT 'Order qty of size s23',
  `order_s_s24` int(11) NOT NULL COMMENT 'Order qty of size s24',
  `order_s_s25` int(11) NOT NULL COMMENT 'Order qty of size s25',
  `order_s_s26` int(11) NOT NULL COMMENT 'Order qty of size s26',
  `order_s_s27` int(11) NOT NULL COMMENT 'Order qty \n\nof size s27',
  `order_s_s28` int(11) NOT NULL COMMENT 'Order qty of size s28',
  `order_s_s29` int(11) NOT NULL COMMENT 'Order qty of size s29',
  `order_s_s30` int(11) NOT NULL COMMENT 'Order qty of size s30',
  `order_s_s31` int(11) NOT NULL COMMENT 'Order qty of size s31',
  `order_s_s32` int(11) NOT NULL COMMENT 'Order qty of size s32',
  `order_s_s33` int(11) NOT NULL COMMENT 'Order qty of size s33',
  `order_s_s34` int(11) NOT NULL COMMENT 'Order qty of size s34',
  `order_s_s35` int(11) NOT NULL COMMENT 'Order qty of size s35',
  `order_s_s36` int(11) NOT NULL COMMENT 'Order qty \n\nof size s36',
  `order_s_s37` int(11) NOT NULL COMMENT 'Order qty of size s37',
  `order_s_s38` int(11) NOT NULL COMMENT 'Order qty of size s38',
  `order_s_s39` int(11) NOT NULL COMMENT 'Order qty of size s39',
  `order_s_s40` int(11) NOT NULL COMMENT 'Order qty of size s40',
  `order_s_s41` int(11) NOT NULL COMMENT 'Order qty of size s41',
  `order_s_s42` int(11) NOT NULL COMMENT 'Order qty of size s42',
  `order_s_s43` int(11) NOT NULL COMMENT 'Order qty of size s43',
  `order_s_s44` int(11) NOT NULL COMMENT 'Order qty of size s44',
  `order_s_s45` int(11) NOT NULL COMMENT 'Order qty \n\nof size s45',
  `order_s_s46` int(11) NOT NULL COMMENT 'Order qty of size s46',
  `order_s_s47` int(11) NOT NULL COMMENT 'Order qty of size s47',
  `order_s_s48` int(11) NOT NULL COMMENT 'Order qty of size s48',
  `order_s_s49` int(11) NOT NULL COMMENT 'Order qty of size s49',
  `order_s_s50` int(11) NOT NULL COMMENT 'Order qty of size s50',
  `old_order_s_s01` int(11) NOT NULL COMMENT 'Old Order qty of size s01',
  `old_order_s_s02` int(11) NOT NULL COMMENT 'Old Order qty of size s02',
  `old_order_s_s03` int(11) NOT NULL COMMENT 'Old Order qty of size s03',
  `old_order_s_s04` int(11) NOT NULL COMMENT 'Old Order qty of size s04',
  `old_order_s_s05` int(11) NOT NULL COMMENT 'Old Order qty of size s05',
  `old_order_s_s06` int(11) NOT NULL COMMENT 'Old Order qty of size s06',
  `old_order_s_s07` int(11) NOT NULL COMMENT 'Old Order qty of size s07',
  `old_order_s_s08` int(11) NOT NULL COMMENT 'Old Order qty of size s08',
  `old_order_s_s09` int(11) NOT NULL COMMENT 'Old Order qty of size s09',
  `old_order_s_s10` int(11) NOT NULL COMMENT 'Old Order qty of size s10',
  `old_order_s_s11` int(11) NOT NULL COMMENT 'Old Order qty of size s11',
  `old_order_s_s12` int(11) NOT NULL COMMENT 'Old Order qty of size s12',
  `old_order_s_s13` int(11) NOT NULL COMMENT 'Old Order qty of size s13',
  `old_order_s_s14` int(11) NOT NULL COMMENT 'Old Order qty of size s14',
  `old_order_s_s15` int(11) NOT NULL COMMENT 'Old Order qty of size s15',
  `old_order_s_s16` int(11) NOT NULL COMMENT 'Old Order qty of size s16',
  `old_order_s_s17` int(11) NOT NULL COMMENT 'Old Order qty of size s17',
  `old_order_s_s18` int(11) NOT NULL COMMENT 'Old Order qty of size s18',
  `old_order_s_s19` int(11) NOT NULL COMMENT 'Old Order qty of size s19',
  `old_order_s_s20` int(11) NOT NULL COMMENT 'Old Order qty of size s20',
  `old_order_s_s21` int(11) NOT NULL COMMENT 'Old Order qty of size s21',
  `old_order_s_s22` int(11) NOT NULL COMMENT 'Old Order qty of size s22',
  `old_order_s_s23` int(11) NOT NULL COMMENT 'Old Order qty of size s23',
  `old_order_s_s24` int(11) NOT NULL COMMENT 'Old Order qty of size s24',
  `old_order_s_s25` int(11) NOT NULL COMMENT 'Old Order qty of size s25',
  `old_order_s_s26` int(11) NOT NULL COMMENT 'Old Order qty of size s26',
  `old_order_s_s27` int(11) NOT NULL COMMENT 'Old Order qty of size s27',
  `old_order_s_s28` int(11) NOT NULL COMMENT 'Old Order qty of size s28',
  `old_order_s_s29` int(11) NOT NULL COMMENT 'Old Order qty of size s29',
  `old_order_s_s30` int(11) NOT NULL COMMENT 'Old Order qty of size s30',
  `old_order_s_s31` int(11) NOT NULL COMMENT 'Old Order qty of size s31',
  `old_order_s_s32` int(11) NOT NULL COMMENT 'Old Order qty of size s32',
  `old_order_s_s33` int(11) NOT NULL COMMENT 'Old Order qty of size s33',
  `old_order_s_s34` int(11) NOT NULL COMMENT 'Old Order qty of size s34',
  `old_order_s_s35` int(11) NOT NULL COMMENT 'Old Order qty of size s35',
  `old_order_s_s36` int(11) NOT NULL COMMENT 'Old Order qty of size s36',
  `old_order_s_s37` int(11) NOT NULL COMMENT 'Old Order qty of size s37',
  `old_order_s_s38` int(11) NOT NULL COMMENT 'Old Order qty of size s38',
  `old_order_s_s39` int(11) NOT NULL COMMENT 'Old Order qty of size s39',
  `old_order_s_s40` int(11) NOT NULL COMMENT 'Old Order qty of size s40',
  `old_order_s_s41` int(11) NOT NULL COMMENT 'Old Order qty of size s41',
  `old_order_s_s42` int(11) NOT NULL COMMENT 'Old Order qty of size s42',
  `old_order_s_s43` int(11) NOT NULL COMMENT 'Old Order qty of size s43',
  `old_order_s_s44` int(11) NOT NULL COMMENT 'Old Order qty of size s44',
  `old_order_s_s45` int(11) NOT NULL COMMENT 'Old Order qty of size s45',
  `old_order_s_s46` int(11) NOT NULL COMMENT 'Old Order qty of size s46',
  `old_order_s_s47` int(11) NOT NULL COMMENT 'Old Order qty of size s47',
  `old_order_s_s48` int(11) NOT NULL COMMENT 'Old Order qty of size s48',
  `old_order_s_s49` int(11) NOT NULL COMMENT 'Old Order qty of size s49',
  `old_order_s_s50` int(11) NOT NULL COMMENT 'Old Order qty of size s50',
  `packing_method` varchar(12) NOT NULL COMMENT 'Packing Method',
  `style_id` varchar(20) NOT NULL COMMENT 'User defined style id',
  `carton_id` int(11) NOT NULL COMMENT 'Standard Carton quantity reference ID',
  `carton_print_status` int(11) DEFAULT NULL COMMENT 'Status to track packing list print or not',
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL \n\n- NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL COMMENT 'Trim card \n\npath',
  `trim_status` int(11) DEFAULT NULL COMMENT 'Trim card status',
  `fsp_time_line` varchar(500) NOT NULL COMMENT 'FSP remarks',
  `fsp_last_up` datetime NOT NULL COMMENT 'FSP last updated log',
  `order_embl_a` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_b` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_c` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_d` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_e` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_f` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_g` int(11) NOT NULL,
  `order_embl_h` int(11) NOT NULL,
  `act_cut` int(11) NOT NULL COMMENT 'Actual cut quantity',
  `act_in` int(11) NOT NULL COMMENT 'Actual input \n\nquantity',
  `act_fca` int(11) NOT NULL COMMENT 'FCA completed quantity',
  `act_mca` int(11) NOT NULL COMMENT 'MCA completed quantity',
  `act_fg` int(11) NOT NULL COMMENT 'FG status',
  `cart_pending` int(11) NOT NULL COMMENT 'Carton pending count',
  `priority` int(11) NOT NULL COMMENT 'Priority based on the process',
  `act_ship` int(11) NOT NULL COMMENT 'Actual Ship Qty',
  `output` int(11) NOT NULL COMMENT 'Hourly Output \n\nUpdate',
  `act_rej` int(11) NOT NULL COMMENT 'Actual Rejections',
  `title_size_s01` varchar(20) NOT NULL COMMENT ' SIZE s01 Title FIELD',
  `title_size_s02` varchar(20) NOT NULL COMMENT ' SIZE s02 Title FIELD',
  `title_size_s03` varchar(20) NOT NULL COMMENT ' SIZE s03 Title FIELD',
  `title_size_s04` varchar(20) NOT NULL COMMENT ' SIZE s04 Title FIELD',
  `title_size_s05` varchar(20) NOT NULL COMMENT ' SIZE s05 Title FIELD',
  `title_size_s06` varchar(20) NOT NULL COMMENT ' SIZE s06 Title FIELD',
  `title_size_s07` varchar(20) NOT NULL COMMENT ' SIZE s07 Title FIELD',
  `title_size_s08` varchar(20) NOT NULL COMMENT ' SIZE s08 Title FIELD',
  `title_size_s09` varchar(20) NOT NULL COMMENT ' SIZE s09 Title FIELD',
  `title_size_s10` varchar(20) NOT NULL COMMENT ' SIZE s10 Title FIELD',
  `title_size_s11` varchar(20) NOT NULL COMMENT ' SIZE s11 Title FIELD',
  `title_size_s12` varchar(20) NOT NULL COMMENT ' SIZE s12 Title FIELD',
  `title_size_s13` varchar(20) NOT NULL COMMENT ' SIZE s13 Title FIELD',
  `title_size_s14` varchar(20) NOT NULL COMMENT ' SIZE s14 Title FIELD',
  `title_size_s15` varchar(20) NOT NULL COMMENT ' SIZE s15 Title FIELD',
  `title_size_s16` varchar(20) NOT NULL COMMENT ' SIZE s16 Title FIELD',
  `title_size_s17` varchar(20) NOT NULL COMMENT ' SIZE s17 Title FIELD',
  `title_size_s18` varchar(20) NOT NULL COMMENT ' SIZE s18 Title FIELD',
  `title_size_s19` varchar(20) NOT NULL COMMENT ' SIZE s19 Title FIELD',
  `title_size_s20` varchar(20) NOT NULL COMMENT ' SIZE s20 Title FIELD',
  `title_size_s21` varchar(20) NOT NULL COMMENT ' SIZE s21 Title FIELD',
  `title_size_s22` varchar(20) NOT NULL COMMENT ' SIZE s22 Title FIELD',
  `title_size_s23` varchar(20) NOT NULL COMMENT ' SIZE s23 Title FIELD',
  `title_size_s24` varchar(20) NOT NULL COMMENT ' SIZE s24 Title FIELD',
  `title_size_s25` varchar(20) NOT NULL COMMENT ' SIZE s25 Title FIELD',
  `title_size_s26` varchar(20) NOT NULL COMMENT ' SIZE s26 Title FIELD',
  `title_size_s27` varchar(20) NOT NULL COMMENT ' SIZE s27 Title FIELD',
  `title_size_s28` varchar(20) NOT NULL COMMENT ' SIZE s28 Title FIELD',
  `title_size_s29` varchar(20) NOT NULL COMMENT ' SIZE s29 Title FIELD',
  `title_size_s30` varchar(20) NOT NULL COMMENT ' SIZE s30 Title FIELD',
  `title_size_s31` varchar(20) NOT NULL COMMENT ' SIZE s31 Title FIELD',
  `title_size_s32` varchar(20) NOT NULL COMMENT ' SIZE s32 Title FIELD',
  `title_size_s33` varchar(20) NOT NULL COMMENT ' SIZE s33 Title FIELD',
  `title_size_s34` varchar(20) NOT NULL COMMENT ' SIZE s34 Title FIELD',
  `title_size_s35` varchar(20) NOT NULL COMMENT ' SIZE s35 Title FIELD',
  `title_size_s36` varchar(20) NOT NULL COMMENT ' SIZE s36 Title FIELD',
  `title_size_s37` varchar(20) NOT NULL COMMENT ' SIZE s37 Title FIELD',
  `title_size_s38` varchar(20) NOT NULL COMMENT ' SIZE s38 Title FIELD',
  `title_size_s39` varchar(20) NOT NULL COMMENT ' SIZE s39 Title FIELD',
  `title_size_s40` varchar(20) NOT NULL COMMENT ' SIZE s40 Title FIELD',
  `title_size_s41` varchar(20) NOT NULL COMMENT ' SIZE s41 Title FIELD',
  `title_size_s42` varchar(20) NOT NULL COMMENT ' SIZE s42 Title FIELD',
  `title_size_s43` varchar(20) NOT NULL COMMENT ' SIZE s43 Title FIELD',
  `title_size_s44` varchar(20) NOT NULL COMMENT ' SIZE s44 Title FIELD',
  `title_size_s45` varchar(20) NOT NULL COMMENT ' SIZE s45 Title FIELD',
  `title_size_s46` varchar(20) NOT NULL COMMENT ' SIZE s46 Title FIELD',
  `title_size_s47` varchar(20) NOT NULL COMMENT ' SIZE s47 Title FIELD',
  `title_size_s48` varchar(20) NOT NULL COMMENT ' SIZE s48 Title FIELD',
  `title_size_s49` varchar(20) NOT NULL COMMENT ' SIZE s49 Title FIELD',
  `title_size_s50` varchar(20) NOT NULL COMMENT ' SIZE s50 Title FIELD',
  `title_flag` int(11) NOT NULL DEFAULT 0 COMMENT 'Title Flag',
  `title_size_xs` varchar(20) NOT NULL,
  `title_size_s` varchar(20) NOT NULL,
  `title_size_m` varchar(20) NOT NULL,
  `title_size_l` varchar(20) NOT NULL,
  `title_size_xl` varchar(20) NOT NULL,
  `title_size_xxl` varchar(20) NOT NULL,
  `title_size_xxxl` varchar(20) NOT NULL,
  `smv` float(11,2) NOT NULL COMMENT 'SMV Value',
  `smo` int(11) DEFAULT NULL COMMENT 'SMO Value',
  `destination` varchar(10) DEFAULT NULL,
  `bts_status` int(11) NOT NULL DEFAULT 0,
  `zfeature` varchar(15) DEFAULT NULL COMMENT 'Country Block',
  `ratio_packing_method` varchar(45) DEFAULT NULL COMMENT 'Ratio Packing Method 1.Single: Single \n\nSize Multiple Colours Ratio Packing, 2.Multiple: Multiple Sizes Multiple Colours Ratio Packing',
  `co_no` varchar(25) DEFAULT NULL COMMENT 'customer order number',
  `vpo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Order details for CMS and other applications';

/*Table structure for table `bai_orders_db_club_confirm` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_club_confirm`;

CREATE TABLE `bai_pro3`.`bai_orders_db_club_confirm` (
  `order_tid` varchar(200) NOT NULL COMMENT 'It''s a combination of style, schedule, color',
  `order_date` date NOT NULL COMMENT 'exfactory data',
  `order_upload_date` date NOT NULL COMMENT 'Order details uploaded date',
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL COMMENT 'Buyer Division',
  `order_style_no` varchar(60) NOT NULL COMMENT 'Style No',
  `order_del_no` varchar(60) NOT NULL COMMENT 'Schedule No',
  `order_col_des` varchar(150) NOT NULL COMMENT 'Color ',
  `order_col_code` varchar(100) NOT NULL COMMENT 'Dummy Filed',
  `order_s_xs` int(50) NOT NULL COMMENT 'Order qty of xs',
  `order_s_s` int(50) NOT NULL COMMENT 'Order qty of s',
  `order_s_m` int(50) NOT NULL COMMENT 'Order qty of m',
  `order_s_l` int(50) NOT NULL COMMENT 'Order qty of l',
  `order_s_xl` int(50) NOT NULL COMMENT 'Order qty of xl',
  `order_s_xxl` int(50) NOT NULL COMMENT 'Order qty of xxl',
  `order_s_xxxl` int(50) NOT NULL COMMENT 'Order qty of xxxl',
  `order_cat_stat` varchar(20) NOT NULL COMMENT 'dummy field',
  `order_cut_stat` varchar(20) NOT NULL COMMENT 'Cutting \n\nStatus',
  `order_ratio_stat` varchar(20) NOT NULL COMMENT 'Serial Number shows as clubbed.',
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL COMMENT 'Purchase Order',
  `order_no` varchar(100) NOT NULL COMMENT 'To track extra shipment (1) - manual ord qty modification',
  `old_order_s_xs` int(11) NOT NULL COMMENT 'Old Order qty of \n\nxs',
  `old_order_s_s` int(11) NOT NULL COMMENT 'Old Order qty of s',
  `old_order_s_m` int(11) NOT NULL COMMENT 'Old Order qty of m',
  `old_order_s_l` int(11) NOT NULL COMMENT 'Old Order qty of l',
  `old_order_s_xl` int(11) NOT NULL COMMENT 'Old Order qty of xl',
  `old_order_s_xxl` int(11) NOT NULL COMMENT 'Old Order qty of xxl',
  `old_order_s_xxxl` int(11) NOT NULL COMMENT 'Old Order qty of xxxl',
  `color_code` int(11) NOT NULL DEFAULT 0 COMMENT 'Color Code(Number Format)',
  `order_joins` varchar(500) NOT NULL DEFAULT '0' COMMENT 'To track \n\njoin schedules',
  `order_s_s01` int(11) NOT NULL COMMENT 'Order qty of size s01',
  `order_s_s02` int(11) NOT NULL COMMENT 'Order qty of size s02',
  `order_s_s03` int(11) NOT NULL COMMENT 'Order qty of size s03',
  `order_s_s04` int(11) NOT NULL COMMENT 'Order qty of size s04',
  `order_s_s05` int(11) NOT NULL COMMENT 'Order qty of size s05',
  `order_s_s06` int(11) NOT NULL COMMENT 'Order qty of size s06',
  `order_s_s07` int(11) NOT NULL COMMENT 'Order qty of size s07',
  `order_s_s08` int(11) NOT NULL COMMENT 'Order qty of size s08',
  `order_s_s09` int(11) NOT NULL COMMENT 'Order qty \n\nof size s09',
  `order_s_s10` int(11) NOT NULL COMMENT 'Order qty of size s10',
  `order_s_s11` int(11) NOT NULL COMMENT 'Order qty of size s11',
  `order_s_s12` int(11) NOT NULL COMMENT 'Order qty of size s12',
  `order_s_s13` int(11) NOT NULL COMMENT 'Order qty of size s13',
  `order_s_s14` int(11) NOT NULL COMMENT 'Order qty of size s14',
  `order_s_s15` int(11) NOT NULL COMMENT 'Order qty of size s15',
  `order_s_s16` int(11) NOT NULL COMMENT 'Order qty of size s16',
  `order_s_s17` int(11) NOT NULL COMMENT 'Order qty of size s17',
  `order_s_s18` int(11) NOT NULL COMMENT 'Order qty \n\nof size s18',
  `order_s_s19` int(11) NOT NULL COMMENT 'Order qty of size s19',
  `order_s_s20` int(11) NOT NULL COMMENT 'Order qty of size s20',
  `order_s_s21` int(11) NOT NULL COMMENT 'Order qty of size s21',
  `order_s_s22` int(11) NOT NULL COMMENT 'Order qty of size s22',
  `order_s_s23` int(11) NOT NULL COMMENT 'Order qty of size s23',
  `order_s_s24` int(11) NOT NULL COMMENT 'Order qty of size s24',
  `order_s_s25` int(11) NOT NULL COMMENT 'Order qty of size s25',
  `order_s_s26` int(11) NOT NULL COMMENT 'Order qty of size s26',
  `order_s_s27` int(11) NOT NULL COMMENT 'Order qty \n\nof size s27',
  `order_s_s28` int(11) NOT NULL COMMENT 'Order qty of size s28',
  `order_s_s29` int(11) NOT NULL COMMENT 'Order qty of size s29',
  `order_s_s30` int(11) NOT NULL COMMENT 'Order qty of size s30',
  `order_s_s31` int(11) NOT NULL COMMENT 'Order qty of size s31',
  `order_s_s32` int(11) NOT NULL COMMENT 'Order qty of size s32',
  `order_s_s33` int(11) NOT NULL COMMENT 'Order qty of size s33',
  `order_s_s34` int(11) NOT NULL COMMENT 'Order qty of size s34',
  `order_s_s35` int(11) NOT NULL COMMENT 'Order qty of size s35',
  `order_s_s36` int(11) NOT NULL COMMENT 'Order qty \n\nof size s36',
  `order_s_s37` int(11) NOT NULL COMMENT 'Order qty of size s37',
  `order_s_s38` int(11) NOT NULL COMMENT 'Order qty of size s38',
  `order_s_s39` int(11) NOT NULL COMMENT 'Order qty of size s39',
  `order_s_s40` int(11) NOT NULL COMMENT 'Order qty of size s40',
  `order_s_s41` int(11) NOT NULL COMMENT 'Order qty of size s41',
  `order_s_s42` int(11) NOT NULL COMMENT 'Order qty of size s42',
  `order_s_s43` int(11) NOT NULL COMMENT 'Order qty of size s43',
  `order_s_s44` int(11) NOT NULL COMMENT 'Order qty of size s44',
  `order_s_s45` int(11) NOT NULL COMMENT 'Order qty \n\nof size s45',
  `order_s_s46` int(11) NOT NULL COMMENT 'Order qty of size s46',
  `order_s_s47` int(11) NOT NULL COMMENT 'Order qty of size s47',
  `order_s_s48` int(11) NOT NULL COMMENT 'Order qty of size s48',
  `order_s_s49` int(11) NOT NULL COMMENT 'Order qty of size s49',
  `order_s_s50` int(11) NOT NULL COMMENT 'Order qty of size s50',
  `old_order_s_s01` int(11) NOT NULL COMMENT 'Old Order qty of size s01',
  `old_order_s_s02` int(11) NOT NULL COMMENT 'Old Order qty of size s02',
  `old_order_s_s03` int(11) NOT NULL COMMENT 'Old Order qty of size s03',
  `old_order_s_s04` int(11) NOT NULL COMMENT 'Old Order qty of size s04',
  `old_order_s_s05` int(11) NOT NULL COMMENT 'Old Order qty of size s05',
  `old_order_s_s06` int(11) NOT NULL COMMENT 'Old Order qty of size s06',
  `old_order_s_s07` int(11) NOT NULL COMMENT 'Old Order qty of size s07',
  `old_order_s_s08` int(11) NOT NULL COMMENT 'Old Order qty of size s08',
  `old_order_s_s09` int(11) NOT NULL COMMENT 'Old Order qty of size s09',
  `old_order_s_s10` int(11) NOT NULL COMMENT 'Old Order qty of size s10',
  `old_order_s_s11` int(11) NOT NULL COMMENT 'Old Order qty of size s11',
  `old_order_s_s12` int(11) NOT NULL COMMENT 'Old Order qty of size s12',
  `old_order_s_s13` int(11) NOT NULL COMMENT 'Old Order qty of size s13',
  `old_order_s_s14` int(11) NOT NULL COMMENT 'Old Order qty of size s14',
  `old_order_s_s15` int(11) NOT NULL COMMENT 'Old Order qty of size s15',
  `old_order_s_s16` int(11) NOT NULL COMMENT 'Old Order qty of size s16',
  `old_order_s_s17` int(11) NOT NULL COMMENT 'Old Order qty of size s17',
  `old_order_s_s18` int(11) NOT NULL COMMENT 'Old Order qty of size s18',
  `old_order_s_s19` int(11) NOT NULL COMMENT 'Old Order qty of size s19',
  `old_order_s_s20` int(11) NOT NULL COMMENT 'Old Order qty of size s20',
  `old_order_s_s21` int(11) NOT NULL COMMENT 'Old Order qty of size s21',
  `old_order_s_s22` int(11) NOT NULL COMMENT 'Old Order qty of size s22',
  `old_order_s_s23` int(11) NOT NULL COMMENT 'Old Order qty of size s23',
  `old_order_s_s24` int(11) NOT NULL COMMENT 'Old Order qty of size s24',
  `old_order_s_s25` int(11) NOT NULL COMMENT 'Old Order qty of size s25',
  `old_order_s_s26` int(11) NOT NULL COMMENT 'Old Order qty of size s26',
  `old_order_s_s27` int(11) NOT NULL COMMENT 'Old Order qty of size s27',
  `old_order_s_s28` int(11) NOT NULL COMMENT 'Old Order qty of size s28',
  `old_order_s_s29` int(11) NOT NULL COMMENT 'Old Order qty of size s29',
  `old_order_s_s30` int(11) NOT NULL COMMENT 'Old Order qty of size s30',
  `old_order_s_s31` int(11) NOT NULL COMMENT 'Old Order qty of size s31',
  `old_order_s_s32` int(11) NOT NULL COMMENT 'Old Order qty of size s32',
  `old_order_s_s33` int(11) NOT NULL COMMENT 'Old Order qty of size s33',
  `old_order_s_s34` int(11) NOT NULL COMMENT 'Old Order qty of size s34',
  `old_order_s_s35` int(11) NOT NULL COMMENT 'Old Order qty of size s35',
  `old_order_s_s36` int(11) NOT NULL COMMENT 'Old Order qty of size s36',
  `old_order_s_s37` int(11) NOT NULL COMMENT 'Old Order qty of size s37',
  `old_order_s_s38` int(11) NOT NULL COMMENT 'Old Order qty of size s38',
  `old_order_s_s39` int(11) NOT NULL COMMENT 'Old Order qty of size s39',
  `old_order_s_s40` int(11) NOT NULL COMMENT 'Old Order qty of size s40',
  `old_order_s_s41` int(11) NOT NULL COMMENT 'Old Order qty of size s41',
  `old_order_s_s42` int(11) NOT NULL COMMENT 'Old Order qty of size s42',
  `old_order_s_s43` int(11) NOT NULL COMMENT 'Old Order qty of size s43',
  `old_order_s_s44` int(11) NOT NULL COMMENT 'Old Order qty of size s44',
  `old_order_s_s45` int(11) NOT NULL COMMENT 'Old Order qty of size s45',
  `old_order_s_s46` int(11) NOT NULL COMMENT 'Old Order qty of size s46',
  `old_order_s_s47` int(11) NOT NULL COMMENT 'Old Order qty of size s47',
  `old_order_s_s48` int(11) NOT NULL COMMENT 'Old Order qty of size s48',
  `old_order_s_s49` int(11) NOT NULL COMMENT 'Old Order qty of size s49',
  `old_order_s_s50` int(11) NOT NULL COMMENT 'Old Order qty of size s50',
  `packing_method` varchar(12) NOT NULL COMMENT 'Packing Method',
  `style_id` varchar(20) NOT NULL COMMENT 'User defined style id',
  `carton_id` int(11) NOT NULL COMMENT 'Standard Carton quantity reference ID',
  `carton_print_status` int(11) DEFAULT NULL COMMENT 'Status to track packing list print or not',
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL \n\n- NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL COMMENT 'Trim card \n\npath',
  `trim_status` int(11) DEFAULT NULL COMMENT 'Trim card status',
  `fsp_time_line` varchar(500) NOT NULL COMMENT 'FSP remarks',
  `fsp_last_up` datetime NOT NULL COMMENT 'FSP last updated log',
  `order_embl_a` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_b` int(11) NOT NULL COMMENT 'Panel Form',
  `order_embl_c` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_d` int(11) NOT NULL COMMENT 'Semi Garment',
  `order_embl_e` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_f` int(11) NOT NULL COMMENT 'Garment Form',
  `order_embl_g` int(11) NOT NULL,
  `order_embl_h` int(11) NOT NULL,
  `act_cut` int(11) NOT NULL COMMENT 'Actual cut quantity',
  `act_in` int(11) NOT NULL COMMENT 'Actual input \n\nquantity',
  `act_fca` int(11) NOT NULL COMMENT 'FCA completed quantity',
  `act_mca` int(11) NOT NULL COMMENT 'MCA completed quantity',
  `act_fg` int(11) NOT NULL COMMENT 'FG status',
  `cart_pending` int(11) NOT NULL COMMENT 'Carton pending count',
  `priority` int(11) NOT NULL COMMENT 'Priority based on the process',
  `act_ship` int(11) NOT NULL COMMENT 'Actual Ship Qty',
  `output` int(11) NOT NULL COMMENT 'Hourly Output \n\nUpdate',
  `act_rej` int(11) NOT NULL COMMENT 'Actual Rejections',
  `title_size_s01` varchar(20) NOT NULL COMMENT ' SIZE s01 Title FIELD',
  `title_size_s02` varchar(20) NOT NULL COMMENT ' SIZE s02 Title FIELD',
  `title_size_s03` varchar(20) NOT NULL COMMENT ' SIZE s03 Title FIELD',
  `title_size_s04` varchar(20) NOT NULL COMMENT ' SIZE s04 Title FIELD',
  `title_size_s05` varchar(20) NOT NULL COMMENT ' SIZE s05 Title FIELD',
  `title_size_s06` varchar(20) NOT NULL COMMENT ' SIZE s06 Title FIELD',
  `title_size_s07` varchar(20) NOT NULL COMMENT ' SIZE s07 Title FIELD',
  `title_size_s08` varchar(20) NOT NULL COMMENT ' SIZE s08 Title FIELD',
  `title_size_s09` varchar(20) NOT NULL COMMENT ' SIZE s09 Title FIELD',
  `title_size_s10` varchar(20) NOT NULL COMMENT ' SIZE s10 Title FIELD',
  `title_size_s11` varchar(20) NOT NULL COMMENT ' SIZE s11 Title FIELD',
  `title_size_s12` varchar(20) NOT NULL COMMENT ' SIZE s12 Title FIELD',
  `title_size_s13` varchar(20) NOT NULL COMMENT ' SIZE s13 Title FIELD',
  `title_size_s14` varchar(20) NOT NULL COMMENT ' SIZE s14 Title FIELD',
  `title_size_s15` varchar(20) NOT NULL COMMENT ' SIZE s15 Title FIELD',
  `title_size_s16` varchar(20) NOT NULL COMMENT ' SIZE s16 Title FIELD',
  `title_size_s17` varchar(20) NOT NULL COMMENT ' SIZE s17 Title FIELD',
  `title_size_s18` varchar(20) NOT NULL COMMENT ' SIZE s18 Title FIELD',
  `title_size_s19` varchar(20) NOT NULL COMMENT ' SIZE s19 Title FIELD',
  `title_size_s20` varchar(20) NOT NULL COMMENT ' SIZE s20 Title FIELD',
  `title_size_s21` varchar(20) NOT NULL COMMENT ' SIZE s21 Title FIELD',
  `title_size_s22` varchar(20) NOT NULL COMMENT ' SIZE s22 Title FIELD',
  `title_size_s23` varchar(20) NOT NULL COMMENT ' SIZE s23 Title FIELD',
  `title_size_s24` varchar(20) NOT NULL COMMENT ' SIZE s24 Title FIELD',
  `title_size_s25` varchar(20) NOT NULL COMMENT ' SIZE s25 Title FIELD',
  `title_size_s26` varchar(20) NOT NULL COMMENT ' SIZE s26 Title FIELD',
  `title_size_s27` varchar(20) NOT NULL COMMENT ' SIZE s27 Title FIELD',
  `title_size_s28` varchar(20) NOT NULL COMMENT ' SIZE s28 Title FIELD',
  `title_size_s29` varchar(20) NOT NULL COMMENT ' SIZE s29 Title FIELD',
  `title_size_s30` varchar(20) NOT NULL COMMENT ' SIZE s30 Title FIELD',
  `title_size_s31` varchar(20) NOT NULL COMMENT ' SIZE s31 Title FIELD',
  `title_size_s32` varchar(20) NOT NULL COMMENT ' SIZE s32 Title FIELD',
  `title_size_s33` varchar(20) NOT NULL COMMENT ' SIZE s33 Title FIELD',
  `title_size_s34` varchar(20) NOT NULL COMMENT ' SIZE s34 Title FIELD',
  `title_size_s35` varchar(20) NOT NULL COMMENT ' SIZE s35 Title FIELD',
  `title_size_s36` varchar(20) NOT NULL COMMENT ' SIZE s36 Title FIELD',
  `title_size_s37` varchar(20) NOT NULL COMMENT ' SIZE s37 Title FIELD',
  `title_size_s38` varchar(20) NOT NULL COMMENT ' SIZE s38 Title FIELD',
  `title_size_s39` varchar(20) NOT NULL COMMENT ' SIZE s39 Title FIELD',
  `title_size_s40` varchar(20) NOT NULL COMMENT ' SIZE s40 Title FIELD',
  `title_size_s41` varchar(20) NOT NULL COMMENT ' SIZE s41 Title FIELD',
  `title_size_s42` varchar(20) NOT NULL COMMENT ' SIZE s42 Title FIELD',
  `title_size_s43` varchar(20) NOT NULL COMMENT ' SIZE s43 Title FIELD',
  `title_size_s44` varchar(20) NOT NULL COMMENT ' SIZE s44 Title FIELD',
  `title_size_s45` varchar(20) NOT NULL COMMENT ' SIZE s45 Title FIELD',
  `title_size_s46` varchar(20) NOT NULL COMMENT ' SIZE s46 Title FIELD',
  `title_size_s47` varchar(20) NOT NULL COMMENT ' SIZE s47 Title FIELD',
  `title_size_s48` varchar(20) NOT NULL COMMENT ' SIZE s48 Title FIELD',
  `title_size_s49` varchar(20) NOT NULL COMMENT ' SIZE s49 Title FIELD',
  `title_size_s50` varchar(20) NOT NULL COMMENT ' SIZE s50 Title FIELD',
  `title_flag` int(11) NOT NULL DEFAULT 0 COMMENT 'Title Flag',
  `title_size_xs` varchar(20) NOT NULL,
  `title_size_s` varchar(20) NOT NULL,
  `title_size_m` varchar(20) NOT NULL,
  `title_size_l` varchar(20) NOT NULL,
  `title_size_xl` varchar(20) NOT NULL,
  `title_size_xxl` varchar(20) NOT NULL,
  `title_size_xxxl` varchar(20) NOT NULL,
  `smv` float(11,2) NOT NULL COMMENT 'SMV Value',
  `smo` int(11) DEFAULT NULL COMMENT 'SMO Value',
  `destination` varchar(10) DEFAULT NULL,
  `bts_status` int(11) NOT NULL DEFAULT 0,
  `zfeature` varchar(15) DEFAULT NULL COMMENT 'Country Block',
  `ratio_packing_method` varchar(45) NOT NULL COMMENT 'Ratio Packing Method 1.Single: Single \n\nSize Multiple Colours Ratio Packing, 2.Multiple: Multiple Sizes Multiple Colours Ratio Packing',
  `co_no` varchar(25) DEFAULT NULL COMMENT 'customer order number',
  `vpo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Order details for CMS and other applications';

/*Table structure for table `bai_orders_db_confirm` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_confirm`;

CREATE TABLE `bai_pro3`.`bai_orders_db_confirm` (
  `order_tid` varchar(200) NOT NULL,
  `order_date` date NOT NULL,
  `order_upload_date` date NOT NULL,
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL,
  `order_style_no` varchar(60) NOT NULL,
  `order_del_no` varchar(60) NOT NULL,
  `order_col_des` varchar(150) NOT NULL,
  `order_col_code` varchar(100) NOT NULL,
  `order_s_xs` int(50) NOT NULL,
  `order_s_s` int(50) NOT NULL,
  `order_s_m` int(50) NOT NULL,
  `order_s_l` int(50) NOT NULL,
  `order_s_xl` int(50) NOT NULL,
  `order_s_xxl` int(50) NOT NULL,
  `order_s_xxxl` int(50) NOT NULL,
  `order_cat_stat` varchar(20) NOT NULL,
  `order_cut_stat` varchar(20) NOT NULL,
  `order_ratio_stat` varchar(20) NOT NULL,
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `old_order_s_xs` int(11) NOT NULL,
  `old_order_s_s` int(11) NOT NULL,
  `old_order_s_m` int(11) NOT NULL,
  `old_order_s_l` int(11) NOT NULL,
  `old_order_s_xl` int(11) NOT NULL,
  `old_order_s_xxl` int(11) NOT NULL,
  `old_order_s_xxxl` int(11) NOT NULL,
  `color_code` int(11) DEFAULT NULL,
  `order_joins` varchar(500) NOT NULL DEFAULT '0',
  `order_s_s01` int(11) NOT NULL COMMENT 'Order qty of size s01',
  `order_s_s02` int(11) NOT NULL COMMENT 'Order qty of size s02',
  `order_s_s03` int(11) NOT NULL COMMENT 'Order qty of size s03',
  `order_s_s04` int(11) NOT NULL COMMENT 'Order qty of size s04',
  `order_s_s05` int(11) NOT NULL COMMENT 'Order qty \n\nof size s05',
  `order_s_s06` int(11) NOT NULL COMMENT 'Order qty of size s06',
  `order_s_s07` int(11) NOT NULL COMMENT 'Order qty of size s07',
  `order_s_s08` int(11) NOT NULL COMMENT 'Order qty of size s08',
  `order_s_s09` int(11) NOT NULL COMMENT 'Order qty of size s09',
  `order_s_s10` int(11) NOT NULL COMMENT 'Order qty of size s10',
  `order_s_s11` int(11) NOT NULL COMMENT 'Order qty of size s11',
  `order_s_s12` int(11) NOT NULL COMMENT 'Order qty of size s12',
  `order_s_s13` int(11) NOT NULL COMMENT 'Order qty of size s13',
  `order_s_s14` int(11) NOT NULL COMMENT 'Order qty \n\nof size s14',
  `order_s_s15` int(11) NOT NULL COMMENT 'Order qty of size s15',
  `order_s_s16` int(11) NOT NULL COMMENT 'Order qty of size s16',
  `order_s_s17` int(11) NOT NULL COMMENT 'Order qty of size s17',
  `order_s_s18` int(11) NOT NULL COMMENT 'Order qty of size s18',
  `order_s_s19` int(11) NOT NULL COMMENT 'Order qty of size s19',
  `order_s_s20` int(11) NOT NULL COMMENT 'Order qty of size s20',
  `order_s_s21` int(11) NOT NULL COMMENT 'Order qty of size s21',
  `order_s_s22` int(11) NOT NULL COMMENT 'Order qty of size s22',
  `order_s_s23` int(11) NOT NULL COMMENT 'Order qty \n\nof size s23',
  `order_s_s24` int(11) NOT NULL COMMENT 'Order qty of size s24',
  `order_s_s25` int(11) NOT NULL COMMENT 'Order qty of size s25',
  `order_s_s26` int(11) NOT NULL COMMENT 'Order qty of size s26',
  `order_s_s27` int(11) NOT NULL COMMENT 'Order qty of size s27',
  `order_s_s28` int(11) NOT NULL COMMENT 'Order qty of size s28',
  `order_s_s29` int(11) NOT NULL COMMENT 'Order qty of size s29',
  `order_s_s30` int(11) NOT NULL COMMENT 'Order qty of size s30',
  `order_s_s31` int(11) NOT NULL COMMENT 'Order qty of size s31',
  `order_s_s32` int(11) NOT NULL COMMENT 'Order qty \n\nof size s32',
  `order_s_s33` int(11) NOT NULL COMMENT 'Order qty of size s33',
  `order_s_s34` int(11) NOT NULL COMMENT 'Order qty of size s34',
  `order_s_s35` int(11) NOT NULL COMMENT 'Order qty of size s35',
  `order_s_s36` int(11) NOT NULL COMMENT 'Order qty of size s36',
  `order_s_s37` int(11) NOT NULL COMMENT 'Order qty of size s37',
  `order_s_s38` int(11) NOT NULL COMMENT 'Order qty of size s38',
  `order_s_s39` int(11) NOT NULL COMMENT 'Order qty of size s39',
  `order_s_s40` int(11) NOT NULL COMMENT 'Order qty of size s40',
  `order_s_s41` int(11) NOT NULL COMMENT 'Order qty \n\nof size s41',
  `order_s_s42` int(11) NOT NULL COMMENT 'Order qty of size s42',
  `order_s_s43` int(11) NOT NULL COMMENT 'Order qty of size s43',
  `order_s_s44` int(11) NOT NULL COMMENT 'Order qty of size s44',
  `order_s_s45` int(11) NOT NULL COMMENT 'Order qty of size s45',
  `order_s_s46` int(11) NOT NULL COMMENT 'Order qty of size s46',
  `order_s_s47` int(11) NOT NULL COMMENT 'Order qty of size s47',
  `order_s_s48` int(11) NOT NULL COMMENT 'Order qty of size s48',
  `order_s_s49` int(11) NOT NULL COMMENT 'Order qty of size s49',
  `order_s_s50` int(11) NOT NULL COMMENT 'Order qty \n\nof size s50',
  `old_order_s_s01` int(11) NOT NULL COMMENT 'Old Order qty of size s01',
  `old_order_s_s02` int(11) NOT NULL COMMENT 'Old Order qty of \n\nsize s02',
  `old_order_s_s03` int(11) NOT NULL COMMENT 'Old Order qty of size s03',
  `old_order_s_s04` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns04',
  `old_order_s_s05` int(11) NOT NULL COMMENT 'Old Order qty of size s05',
  `old_order_s_s06` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns06',
  `old_order_s_s07` int(11) NOT NULL COMMENT 'Old Order qty of size s07',
  `old_order_s_s08` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns08',
  `old_order_s_s09` int(11) NOT NULL COMMENT 'Old Order qty of size s09',
  `old_order_s_s10` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns10',
  `old_order_s_s11` int(11) NOT NULL COMMENT 'Old Order qty of size s11',
  `old_order_s_s12` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns12',
  `old_order_s_s13` int(11) NOT NULL COMMENT 'Old Order qty of size s13',
  `old_order_s_s14` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns14',
  `old_order_s_s15` int(11) NOT NULL COMMENT 'Old Order qty of size s15',
  `old_order_s_s16` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns16',
  `old_order_s_s17` int(11) NOT NULL COMMENT 'Old Order qty of size s17',
  `old_order_s_s18` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns18',
  `old_order_s_s19` int(11) NOT NULL COMMENT 'Old Order qty of size s19',
  `old_order_s_s20` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns20',
  `old_order_s_s21` int(11) NOT NULL COMMENT 'Old Order qty of size s21',
  `old_order_s_s22` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns22',
  `old_order_s_s23` int(11) NOT NULL COMMENT 'Old Order qty of size s23',
  `old_order_s_s24` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns24',
  `old_order_s_s25` int(11) NOT NULL COMMENT 'Old Order qty of size s25',
  `old_order_s_s26` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns26',
  `old_order_s_s27` int(11) NOT NULL COMMENT 'Old Order qty of size s27',
  `old_order_s_s28` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns28',
  `old_order_s_s29` int(11) NOT NULL COMMENT 'Old Order qty of size s29',
  `old_order_s_s30` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns30',
  `old_order_s_s31` int(11) NOT NULL COMMENT 'Old Order qty of size s31',
  `old_order_s_s32` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns32',
  `old_order_s_s33` int(11) NOT NULL COMMENT 'Old Order qty of size s33',
  `old_order_s_s34` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns34',
  `old_order_s_s35` int(11) NOT NULL COMMENT 'Old Order qty of size s35',
  `old_order_s_s36` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns36',
  `old_order_s_s37` int(11) NOT NULL COMMENT 'Old Order qty of size s37',
  `old_order_s_s38` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns38',
  `old_order_s_s39` int(11) NOT NULL COMMENT 'Old Order qty of size s39',
  `old_order_s_s40` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns40',
  `old_order_s_s41` int(11) NOT NULL COMMENT 'Old Order qty of size s41',
  `old_order_s_s42` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns42',
  `old_order_s_s43` int(11) NOT NULL COMMENT 'Old Order qty of size s43',
  `old_order_s_s44` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns44',
  `old_order_s_s45` int(11) NOT NULL COMMENT 'Old Order qty of size s45',
  `old_order_s_s46` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns46',
  `old_order_s_s47` int(11) NOT NULL COMMENT 'Old Order qty of size s47',
  `old_order_s_s48` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns48',
  `old_order_s_s49` int(11) NOT NULL COMMENT 'Old Order qty of size s49',
  `old_order_s_s50` int(11) NOT NULL COMMENT 'Old Order qty of size \n\ns50',
  `packing_method` varchar(12) NOT NULL,
  `style_id` varchar(20) NOT NULL,
  `carton_id` int(11) NOT NULL,
  `carton_print_status` int(11) DEFAULT NULL,
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL,
  `trim_status` int(11) DEFAULT NULL,
  `fsp_time_line` varchar(500) NOT NULL,
  `fsp_last_up` datetime NOT NULL,
  `order_embl_a` int(11) NOT NULL,
  `order_embl_b` int(11) NOT NULL,
  `order_embl_c` int(11) NOT NULL,
  `order_embl_d` int(11) NOT NULL,
  `order_embl_e` int(11) NOT NULL,
  `order_embl_f` int(11) NOT NULL,
  `order_embl_g` int(11) NOT NULL,
  `order_embl_h` int(11) NOT NULL,
  `act_cut` int(11) NOT NULL,
  `act_in` int(11) NOT NULL,
  `act_fca` int(11) NOT NULL,
  `act_mca` int(11) NOT NULL,
  `act_fg` int(11) NOT NULL,
  `cart_pending` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `act_ship` int(11) NOT NULL,
  `output` int(11) NOT NULL,
  `act_rej` int(11) NOT NULL COMMENT 'Actual Rejections',
  `title_size_s01` varchar(20) NOT NULL COMMENT ' SIZE \n\ns01 Title FIELD',
  `title_size_s02` varchar(20) NOT NULL COMMENT ' SIZE s02 Title FIELD',
  `title_size_s03` varchar(20) NOT NULL COMMENT ' SIZE s03 \n\nTitle FIELD',
  `title_size_s04` varchar(20) NOT NULL COMMENT ' SIZE s04 Title FIELD',
  `title_size_s05` varchar(20) NOT NULL COMMENT ' SIZE s05 Title \n\nFIELD',
  `title_size_s06` varchar(20) NOT NULL COMMENT ' SIZE s06 Title FIELD',
  `title_size_s07` varchar(20) NOT NULL COMMENT ' SIZE s07 Title \n\nFIELD',
  `title_size_s08` varchar(20) NOT NULL COMMENT ' SIZE s08 Title FIELD',
  `title_size_s09` varchar(20) NOT NULL COMMENT ' SIZE s09 Title \n\nFIELD',
  `title_size_s10` varchar(20) NOT NULL COMMENT ' SIZE s10 Title FIELD',
  `title_size_s11` varchar(20) NOT NULL COMMENT ' SIZE s11 Title \n\nFIELD',
  `title_size_s12` varchar(20) NOT NULL COMMENT ' SIZE s12 Title FIELD',
  `title_size_s13` varchar(20) NOT NULL COMMENT ' SIZE s13 Title \n\nFIELD',
  `title_size_s14` varchar(20) NOT NULL COMMENT ' SIZE s14 Title FIELD',
  `title_size_s15` varchar(20) NOT NULL COMMENT ' SIZE s15 Title \n\nFIELD',
  `title_size_s16` varchar(20) NOT NULL COMMENT ' SIZE s16 Title FIELD',
  `title_size_s17` varchar(20) NOT NULL COMMENT ' SIZE s17 Title \n\nFIELD',
  `title_size_s18` varchar(20) NOT NULL COMMENT ' SIZE s18 Title FIELD',
  `title_size_s19` varchar(20) NOT NULL COMMENT ' SIZE s19 Title \n\nFIELD',
  `title_size_s20` varchar(20) NOT NULL COMMENT ' SIZE s20 Title FIELD',
  `title_size_s21` varchar(20) NOT NULL COMMENT ' SIZE s21 Title \n\nFIELD',
  `title_size_s22` varchar(20) NOT NULL COMMENT ' SIZE s22 Title FIELD',
  `title_size_s23` varchar(20) NOT NULL COMMENT ' SIZE s23 Title \n\nFIELD',
  `title_size_s24` varchar(20) NOT NULL COMMENT ' SIZE s24 Title FIELD',
  `title_size_s25` varchar(20) NOT NULL COMMENT ' SIZE s25 Title \n\nFIELD',
  `title_size_s26` varchar(20) NOT NULL COMMENT ' SIZE s26 Title FIELD',
  `title_size_s27` varchar(20) NOT NULL COMMENT ' SIZE s27 Title \n\nFIELD',
  `title_size_s28` varchar(20) NOT NULL COMMENT ' SIZE s28 Title FIELD',
  `title_size_s29` varchar(20) NOT NULL COMMENT ' SIZE s29 Title \n\nFIELD',
  `title_size_s30` varchar(20) NOT NULL COMMENT ' SIZE s30 Title FIELD',
  `title_size_s31` varchar(20) NOT NULL COMMENT ' SIZE s31 Title \n\nFIELD',
  `title_size_s32` varchar(20) NOT NULL COMMENT ' SIZE s32 Title FIELD',
  `title_size_s33` varchar(20) NOT NULL COMMENT ' SIZE s33 Title \n\nFIELD',
  `title_size_s34` varchar(20) NOT NULL COMMENT ' SIZE s34 Title FIELD',
  `title_size_s35` varchar(20) NOT NULL COMMENT ' SIZE s35 Title \n\nFIELD',
  `title_size_s36` varchar(20) NOT NULL COMMENT ' SIZE s36 Title FIELD',
  `title_size_s37` varchar(20) NOT NULL COMMENT ' SIZE s37 Title \n\nFIELD',
  `title_size_s38` varchar(20) NOT NULL COMMENT ' SIZE s38 Title FIELD',
  `title_size_s39` varchar(20) NOT NULL COMMENT ' SIZE s39 Title \n\nFIELD',
  `title_size_s40` varchar(20) NOT NULL COMMENT ' SIZE s40 Title FIELD',
  `title_size_s41` varchar(20) NOT NULL COMMENT ' SIZE s41 Title \n\nFIELD',
  `title_size_s42` varchar(20) NOT NULL COMMENT ' SIZE s42 Title FIELD',
  `title_size_s43` varchar(20) NOT NULL COMMENT ' SIZE s43 Title \n\nFIELD',
  `title_size_s44` varchar(20) NOT NULL COMMENT ' SIZE s44 Title FIELD',
  `title_size_s45` varchar(20) NOT NULL COMMENT ' SIZE s45 Title \n\nFIELD',
  `title_size_s46` varchar(20) NOT NULL COMMENT ' SIZE s46 Title FIELD',
  `title_size_s47` varchar(20) NOT NULL COMMENT ' SIZE s47 Title \n\nFIELD',
  `title_size_s48` varchar(20) NOT NULL COMMENT ' SIZE s48 Title FIELD',
  `title_size_s49` varchar(20) NOT NULL COMMENT ' SIZE s49 Title \n\nFIELD',
  `title_size_s50` varchar(20) NOT NULL COMMENT ' SIZE s50 Title FIELD',
  `title_flag` int(11) NOT NULL DEFAULT 0 COMMENT 'Title Flag',
  `title_size_xs` varchar(20) NOT NULL,
  `title_size_s` varchar(20) NOT NULL,
  `title_size_m` varchar(20) NOT NULL,
  `title_size_l` varchar(20) NOT NULL,
  `title_size_xl` varchar(20) NOT NULL,
  `title_size_xxl` varchar(20) NOT NULL,
  `title_size_xxxl` varchar(20) NOT NULL,
  `smv` float(11,2) NOT NULL COMMENT 'SMV Value',
  `smo` int(11) DEFAULT NULL COMMENT 'SMO Value',
  `destination` varchar(10) DEFAULT NULL,
  `bts_status` int(11) NOT NULL DEFAULT 0,
  `zfeature` varchar(15) DEFAULT NULL COMMENT 'Country Block',
  `ratio_packing_method` varchar(45) DEFAULT NULL COMMENT 'Ratio Packing Method 1.Single: Single \n\nSize Multiple Colours Ratio Packing, 2.Multiple: Multiple Sizes Multiple Colours Ratio Packing',
  `co_no` varchar(25) DEFAULT NULL COMMENT 'customer order number',
  `vpo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_style_no1` (`order_style_no`,`order_del_no`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_del_no` (`order_del_no`),
  KEY `order_tid_ref` (`order_tid`),
  KEY `order_del_no_2` (`order_del_no`,`order_col_des`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Backup of bai_orders_db to track process \n\nconfirmed orders';

/*Table structure for table `bai_orders_db_confirm_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_confirm_archive`;

CREATE TABLE `bai_pro3`.`bai_orders_db_confirm_archive` (
  `order_tid` varchar(200) NOT NULL,
  `order_date` date NOT NULL,
  `order_upload_date` date NOT NULL,
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL,
  `order_style_no` varchar(60) NOT NULL,
  `order_del_no` varchar(60) NOT NULL,
  `order_col_des` varchar(150) NOT NULL,
  `order_col_code` varchar(100) NOT NULL,
  `order_s_xs` int(50) NOT NULL,
  `order_s_s` int(50) NOT NULL,
  `order_s_m` int(50) NOT NULL,
  `order_s_l` int(50) NOT NULL,
  `order_s_xl` int(50) NOT NULL,
  `order_s_xxl` int(50) NOT NULL,
  `order_s_xxxl` int(50) NOT NULL,
  `order_cat_stat` varchar(20) NOT NULL,
  `order_cut_stat` varchar(20) NOT NULL,
  `order_ratio_stat` varchar(20) NOT NULL,
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `old_order_s_xs` int(11) NOT NULL,
  `old_order_s_s` int(11) NOT NULL,
  `old_order_s_m` int(11) NOT NULL,
  `old_order_s_l` int(11) NOT NULL,
  `old_order_s_xl` int(11) NOT NULL,
  `old_order_s_xxl` int(11) NOT NULL,
  `old_order_s_xxxl` int(11) NOT NULL,
  `color_code` int(11) DEFAULT NULL,
  `order_joins` varchar(500) NOT NULL DEFAULT '0',
  `order_s_s01` int(11) NOT NULL COMMENT 'Order qty of size s01',
  `order_s_s02` int(11) NOT NULL COMMENT 'Order qty of size s02',
  `order_s_s03` int(11) NOT NULL COMMENT 'Order qty of size s03',
  `order_s_s04` int(11) NOT NULL COMMENT 'Order qty of size s04',
  `order_s_s05` int(11) NOT NULL COMMENT 'Order qty of size s05',
  `order_s_s06` int(11) NOT NULL COMMENT 'Order qty of size s06',
  `order_s_s07` int(11) NOT NULL COMMENT 'Order qty of size s07',
  `order_s_s08` int(11) NOT NULL COMMENT 'Order qty of size s08',
  `order_s_s09` int(11) NOT NULL COMMENT 'Order qty \n\nof size s09',
  `order_s_s10` int(11) NOT NULL COMMENT 'Order qty of size s10',
  `order_s_s11` int(11) NOT NULL COMMENT 'Order qty of size s11',
  `order_s_s12` int(11) NOT NULL COMMENT 'Order qty of size s12',
  `order_s_s13` int(11) NOT NULL COMMENT 'Order qty of size s13',
  `order_s_s14` int(11) NOT NULL COMMENT 'Order qty of size s14',
  `order_s_s15` int(11) NOT NULL COMMENT 'Order qty of size s15',
  `order_s_s16` int(11) NOT NULL COMMENT 'Order qty of size s16',
  `order_s_s17` int(11) NOT NULL COMMENT 'Order qty of size s17',
  `order_s_s18` int(11) NOT NULL COMMENT 'Order qty \n\nof size s18',
  `order_s_s19` int(11) NOT NULL COMMENT 'Order qty of size s19',
  `order_s_s20` int(11) NOT NULL COMMENT 'Order qty of size s20',
  `order_s_s21` int(11) NOT NULL COMMENT 'Order qty of size s21',
  `order_s_s22` int(11) NOT NULL COMMENT 'Order qty of size s22',
  `order_s_s23` int(11) NOT NULL COMMENT 'Order qty of size s23',
  `order_s_s24` int(11) NOT NULL COMMENT 'Order qty of size s24',
  `order_s_s25` int(11) NOT NULL COMMENT 'Order qty of size s25',
  `order_s_s26` int(11) NOT NULL COMMENT 'Order qty of size s26',
  `order_s_s27` int(11) NOT NULL COMMENT 'Order qty \n\nof size s27',
  `order_s_s28` int(11) NOT NULL COMMENT 'Order qty of size s28',
  `order_s_s29` int(11) NOT NULL COMMENT 'Order qty of size s29',
  `order_s_s30` int(11) NOT NULL COMMENT 'Order qty of size s30',
  `order_s_s31` int(11) NOT NULL COMMENT 'Order qty of size s31',
  `order_s_s32` int(11) NOT NULL COMMENT 'Order qty of size s32',
  `order_s_s33` int(11) NOT NULL COMMENT 'Order qty of size s33',
  `order_s_s34` int(11) NOT NULL COMMENT 'Order qty of size s34',
  `order_s_s35` int(11) NOT NULL COMMENT 'Order qty of size s35',
  `order_s_s36` int(11) NOT NULL COMMENT 'Order qty \n\nof size s36',
  `order_s_s37` int(11) NOT NULL COMMENT 'Order qty of size s37',
  `order_s_s38` int(11) NOT NULL COMMENT 'Order qty of size s38',
  `order_s_s39` int(11) NOT NULL COMMENT 'Order qty of size s39',
  `order_s_s40` int(11) NOT NULL COMMENT 'Order qty of size s40',
  `order_s_s41` int(11) NOT NULL COMMENT 'Order qty of size s41',
  `order_s_s42` int(11) NOT NULL COMMENT 'Order qty of size s42',
  `order_s_s43` int(11) NOT NULL COMMENT 'Order qty of size s43',
  `order_s_s44` int(11) NOT NULL COMMENT 'Order qty of size s44',
  `order_s_s45` int(11) NOT NULL COMMENT 'Order qty \n\nof size s45',
  `order_s_s46` int(11) NOT NULL COMMENT 'Order qty of size s46',
  `order_s_s47` int(11) NOT NULL COMMENT 'Order qty of size s47',
  `order_s_s48` int(11) NOT NULL COMMENT 'Order qty of size s48',
  `order_s_s49` int(11) NOT NULL COMMENT 'Order qty of size s49',
  `order_s_s50` int(11) NOT NULL COMMENT 'Order qty of size s50',
  `old_order_s_s01` int(11) NOT NULL COMMENT 'Old Order qty of size s01',
  `old_order_s_s02` int(11) NOT NULL COMMENT 'Old Order qty of size s02',
  `old_order_s_s03` int(11) NOT NULL COMMENT 'Old Order qty of size s03',
  `old_order_s_s04` int(11) NOT NULL COMMENT 'Old Order qty of size s04',
  `old_order_s_s05` int(11) NOT NULL COMMENT 'Old Order qty of size s05',
  `old_order_s_s06` int(11) NOT NULL COMMENT 'Old Order qty of size s06',
  `old_order_s_s07` int(11) NOT NULL COMMENT 'Old Order qty of size s07',
  `old_order_s_s08` int(11) NOT NULL COMMENT 'Old Order qty of size s08',
  `old_order_s_s09` int(11) NOT NULL COMMENT 'Old Order qty of size s09',
  `old_order_s_s10` int(11) NOT NULL COMMENT 'Old Order qty of size s10',
  `old_order_s_s11` int(11) NOT NULL COMMENT 'Old Order qty of size s11',
  `old_order_s_s12` int(11) NOT NULL COMMENT 'Old Order qty of size s12',
  `old_order_s_s13` int(11) NOT NULL COMMENT 'Old Order qty of size s13',
  `old_order_s_s14` int(11) NOT NULL COMMENT 'Old Order qty of size s14',
  `old_order_s_s15` int(11) NOT NULL COMMENT 'Old Order qty of size s15',
  `old_order_s_s16` int(11) NOT NULL COMMENT 'Old Order qty of size s16',
  `old_order_s_s17` int(11) NOT NULL COMMENT 'Old Order qty of size s17',
  `old_order_s_s18` int(11) NOT NULL COMMENT 'Old Order qty of size s18',
  `old_order_s_s19` int(11) NOT NULL COMMENT 'Old Order qty of size s19',
  `old_order_s_s20` int(11) NOT NULL COMMENT 'Old Order qty of size s20',
  `old_order_s_s21` int(11) NOT NULL COMMENT 'Old Order qty of size s21',
  `old_order_s_s22` int(11) NOT NULL COMMENT 'Old Order qty of size s22',
  `old_order_s_s23` int(11) NOT NULL COMMENT 'Old Order qty of size s23',
  `old_order_s_s24` int(11) NOT NULL COMMENT 'Old Order qty of size s24',
  `old_order_s_s25` int(11) NOT NULL COMMENT 'Old Order qty of size s25',
  `old_order_s_s26` int(11) NOT NULL COMMENT 'Old Order qty of size s26',
  `old_order_s_s27` int(11) NOT NULL COMMENT 'Old Order qty of size s27',
  `old_order_s_s28` int(11) NOT NULL COMMENT 'Old Order qty of size s28',
  `old_order_s_s29` int(11) NOT NULL COMMENT 'Old Order qty of size s29',
  `old_order_s_s30` int(11) NOT NULL COMMENT 'Old Order qty of size s30',
  `old_order_s_s31` int(11) NOT NULL COMMENT 'Old Order qty of size s31',
  `old_order_s_s32` int(11) NOT NULL COMMENT 'Old Order qty of size s32',
  `old_order_s_s33` int(11) NOT NULL COMMENT 'Old Order qty of size s33',
  `old_order_s_s34` int(11) NOT NULL COMMENT 'Old Order qty of size s34',
  `old_order_s_s35` int(11) NOT NULL COMMENT 'Old Order qty of size s35',
  `old_order_s_s36` int(11) NOT NULL COMMENT 'Old Order qty of size s36',
  `old_order_s_s37` int(11) NOT NULL COMMENT 'Old Order qty of size s37',
  `old_order_s_s38` int(11) NOT NULL COMMENT 'Old Order qty of size s38',
  `old_order_s_s39` int(11) NOT NULL COMMENT 'Old Order qty of size s39',
  `old_order_s_s40` int(11) NOT NULL COMMENT 'Old Order qty of size s40',
  `old_order_s_s41` int(11) NOT NULL COMMENT 'Old Order qty of size s41',
  `old_order_s_s42` int(11) NOT NULL COMMENT 'Old Order qty of size s42',
  `old_order_s_s43` int(11) NOT NULL COMMENT 'Old Order qty of size s43',
  `old_order_s_s44` int(11) NOT NULL COMMENT 'Old Order qty of size s44',
  `old_order_s_s45` int(11) NOT NULL COMMENT 'Old Order qty of size s45',
  `old_order_s_s46` int(11) NOT NULL COMMENT 'Old Order qty of size s46',
  `old_order_s_s47` int(11) NOT NULL COMMENT 'Old Order qty of size s47',
  `old_order_s_s48` int(11) NOT NULL COMMENT 'Old Order qty of size s48',
  `old_order_s_s49` int(11) NOT NULL COMMENT 'Old Order qty of size s49',
  `old_order_s_s50` int(11) NOT NULL COMMENT 'Old Order qty of size s50',
  `packing_method` varchar(12) NOT NULL,
  `style_id` varchar(20) NOT NULL,
  `carton_id` int(11) NOT NULL,
  `carton_print_status` int(11) DEFAULT NULL,
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL - NOT \n\nUpdated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL,
  `trim_status` int(11) DEFAULT NULL,
  `fsp_time_line` varchar(500) NOT NULL,
  `fsp_last_up` datetime NOT NULL,
  `order_embl_a` int(11) NOT NULL,
  `order_embl_b` int(11) NOT NULL,
  `order_embl_c` int(11) NOT NULL,
  `order_embl_d` int(11) NOT NULL,
  `order_embl_e` int(11) NOT NULL,
  `order_embl_f` int(11) NOT NULL,
  `order_embl_g` int(11) NOT NULL,
  `order_embl_h` int(11) NOT NULL,
  `act_cut` int(11) NOT NULL,
  `act_in` int(11) NOT NULL,
  `act_fca` int(11) NOT NULL,
  `act_mca` int(11) NOT NULL,
  `act_fg` int(11) NOT NULL,
  `cart_pending` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `act_ship` int(11) NOT NULL,
  `output` int(11) NOT NULL,
  `act_rej` int(11) unsigned zerofill NOT NULL COMMENT 'Actual Rejections',
  `title_size_s01` varchar(20) NOT NULL COMMENT ' SIZE s01 Title FIELD',
  `title_size_s02` varchar(20) NOT NULL COMMENT ' SIZE s02 Title FIELD',
  `title_size_s03` varchar(20) NOT NULL COMMENT ' SIZE s03 Title FIELD',
  `title_size_s04` varchar(20) NOT NULL COMMENT ' SIZE s04 Title FIELD',
  `title_size_s05` varchar(20) NOT NULL COMMENT ' SIZE s05 Title FIELD',
  `title_size_s06` varchar(20) NOT NULL COMMENT ' SIZE s06 Title FIELD',
  `title_size_s07` varchar(20) NOT NULL COMMENT ' SIZE s07 Title FIELD',
  `title_size_s08` varchar(20) NOT NULL COMMENT ' SIZE s08 Title FIELD',
  `title_size_s09` varchar(20) NOT NULL COMMENT ' SIZE s09 Title FIELD',
  `title_size_s10` varchar(20) NOT NULL COMMENT ' SIZE s10 Title FIELD',
  `title_size_s11` varchar(20) NOT NULL COMMENT ' SIZE s11 Title FIELD',
  `title_size_s12` varchar(20) NOT NULL COMMENT ' SIZE s12 Title FIELD',
  `title_size_s13` varchar(20) NOT NULL COMMENT ' SIZE s13 Title FIELD',
  `title_size_s14` varchar(20) NOT NULL COMMENT ' SIZE s14 Title FIELD',
  `title_size_s15` varchar(20) NOT NULL COMMENT ' SIZE s15 Title FIELD',
  `title_size_s16` varchar(20) NOT NULL COMMENT ' SIZE s16 Title FIELD',
  `title_size_s17` varchar(20) NOT NULL COMMENT ' SIZE s17 Title FIELD',
  `title_size_s18` varchar(20) NOT NULL COMMENT ' SIZE s18 Title FIELD',
  `title_size_s19` varchar(20) NOT NULL COMMENT ' SIZE s19 Title FIELD',
  `title_size_s20` varchar(20) NOT NULL COMMENT ' SIZE s20 Title FIELD',
  `title_size_s21` varchar(20) NOT NULL COMMENT ' SIZE s21 Title FIELD',
  `title_size_s22` varchar(20) NOT NULL COMMENT ' SIZE s22 Title FIELD',
  `title_size_s23` varchar(20) NOT NULL COMMENT ' SIZE s23 Title FIELD',
  `title_size_s24` varchar(20) NOT NULL COMMENT ' SIZE s24 Title FIELD',
  `title_size_s25` varchar(20) NOT NULL COMMENT ' SIZE s25 Title FIELD',
  `title_size_s26` varchar(20) NOT NULL COMMENT ' SIZE s26 Title FIELD',
  `title_size_s27` varchar(20) NOT NULL COMMENT ' SIZE s27 Title FIELD',
  `title_size_s28` varchar(20) NOT NULL COMMENT ' SIZE s28 Title FIELD',
  `title_size_s29` varchar(20) NOT NULL COMMENT ' SIZE s29 Title FIELD',
  `title_size_s30` varchar(20) NOT NULL COMMENT ' SIZE s30 Title FIELD',
  `title_size_s31` varchar(20) NOT NULL COMMENT ' SIZE s31 Title FIELD',
  `title_size_s32` varchar(20) NOT NULL COMMENT ' SIZE s32 Title FIELD',
  `title_size_s33` varchar(20) NOT NULL COMMENT ' SIZE s33 Title FIELD',
  `title_size_s34` varchar(20) NOT NULL COMMENT ' SIZE s34 Title FIELD',
  `title_size_s35` varchar(20) NOT NULL COMMENT ' SIZE s35 Title FIELD',
  `title_size_s36` varchar(20) NOT NULL COMMENT ' SIZE s36 Title FIELD',
  `title_size_s37` varchar(20) NOT NULL COMMENT ' SIZE s37 Title FIELD',
  `title_size_s38` varchar(20) NOT NULL COMMENT ' SIZE s38 Title FIELD',
  `title_size_s39` varchar(20) NOT NULL COMMENT ' SIZE s39 Title FIELD',
  `title_size_s40` varchar(20) NOT NULL COMMENT ' SIZE s40 Title FIELD',
  `title_size_s41` varchar(20) NOT NULL COMMENT ' SIZE s41 Title FIELD',
  `title_size_s42` varchar(20) NOT NULL COMMENT ' SIZE s42 Title FIELD',
  `title_size_s43` varchar(20) NOT NULL COMMENT ' SIZE s43 Title FIELD',
  `title_size_s44` varchar(20) NOT NULL COMMENT ' SIZE s44 Title FIELD',
  `title_size_s45` varchar(20) NOT NULL COMMENT ' SIZE s45 Title FIELD',
  `title_size_s46` varchar(20) NOT NULL COMMENT ' SIZE s46 Title FIELD',
  `title_size_s47` varchar(20) NOT NULL COMMENT ' SIZE s47 Title FIELD',
  `title_size_s48` varchar(20) NOT NULL COMMENT ' SIZE s48 Title FIELD',
  `title_size_s49` varchar(20) NOT NULL COMMENT ' SIZE s49 Title FIELD',
  `title_size_s50` varchar(20) NOT NULL COMMENT ' SIZE s50 Title FIELD',
  `title_flag` int(11) NOT NULL DEFAULT 0 COMMENT 'Title Flag',
  `title_size_xs` varchar(20) NOT NULL,
  `title_size_s` varchar(20) NOT NULL,
  `title_size_m` varchar(20) NOT NULL,
  `title_size_l` varchar(20) NOT NULL,
  `title_size_xl` varchar(20) NOT NULL,
  `title_size_xxl` varchar(20) NOT NULL,
  `title_size_xxxl` varchar(20) NOT NULL,
  `smv` float(11,2) NOT NULL COMMENT 'SMV Value',
  `smo` int(11) DEFAULT NULL COMMENT 'SMO Value',
  `destination` varchar(10) DEFAULT NULL,
  `bts_status` int(11) DEFAULT NULL,
  `zfeature` varchar(8) DEFAULT NULL,
  `ratio_packing_method` varchar(45) NOT NULL COMMENT 'Ratio Packing \n\nMethod 1.Single: Single Size Multiple Colours Ratio Packing, 2.Multiple: Multiple Sizes Multiple Colours Ratio Packing',
  `co_no` varchar(25) DEFAULT NULL COMMENT 'customer order number',
  PRIMARY KEY (`order_tid`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_confirm_archive2` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_confirm_archive2`;

CREATE TABLE `bai_pro3`.`bai_orders_db_confirm_archive2` (
  `order_tid` varchar(200) NOT NULL,
  `order_date` date NOT NULL,
  `order_upload_date` date NOT NULL,
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL,
  `order_style_no` varchar(60) NOT NULL,
  `order_del_no` varchar(60) NOT NULL,
  `order_col_des` varchar(150) NOT NULL,
  `order_col_code` varchar(100) NOT NULL,
  `order_s_xs` int(50) NOT NULL,
  `order_s_s` int(50) NOT NULL,
  `order_s_m` int(50) NOT NULL,
  `order_s_l` int(50) NOT NULL,
  `order_s_xl` int(50) NOT NULL,
  `order_s_xxl` int(50) NOT NULL,
  `order_s_xxxl` int(50) NOT NULL,
  `order_cat_stat` varchar(20) NOT NULL,
  `order_cut_stat` varchar(20) NOT NULL,
  `order_ratio_stat` varchar(20) NOT NULL,
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `old_order_s_xs` int(11) NOT NULL,
  `old_order_s_s` int(11) NOT NULL,
  `old_order_s_m` int(11) NOT NULL,
  `old_order_s_l` int(11) NOT NULL,
  `old_order_s_xl` int(11) NOT NULL,
  `old_order_s_xxl` int(11) NOT NULL,
  `old_order_s_xxxl` int(11) NOT NULL,
  `color_code` int(11) DEFAULT NULL,
  `order_joins` varchar(500) NOT NULL DEFAULT '0',
  `order_s_s06` int(11) NOT NULL,
  `order_s_s08` int(11) NOT NULL,
  `order_s_s10` int(11) NOT NULL,
  `order_s_s12` int(11) NOT NULL,
  `order_s_s14` int(11) NOT NULL,
  `order_s_s16` int(11) NOT NULL,
  `order_s_s18` int(11) NOT NULL,
  `order_s_s20` int(11) NOT NULL,
  `order_s_s22` int(11) NOT NULL,
  `order_s_s24` int(11) NOT NULL,
  `order_s_s26` int(11) NOT NULL,
  `order_s_s28` int(11) NOT NULL,
  `order_s_s30` int(11) NOT NULL,
  `old_order_s_s06` int(11) NOT NULL,
  `old_order_s_s08` int(11) NOT NULL,
  `old_order_s_s10` int(11) NOT NULL,
  `old_order_s_s12` int(11) NOT NULL,
  `old_order_s_s14` int(11) NOT NULL,
  `old_order_s_s16` int(11) NOT NULL,
  `old_order_s_s18` int(11) NOT NULL,
  `old_order_s_s20` int(11) NOT NULL,
  `old_order_s_s22` int(11) NOT NULL,
  `old_order_s_s24` int(11) NOT NULL,
  `old_order_s_s26` int(11) NOT NULL,
  `old_order_s_s28` int(11) NOT NULL,
  `old_order_s_s30` int(11) NOT NULL,
  `packing_method` varchar(12) NOT NULL,
  `style_id` varchar(20) NOT NULL,
  `carton_id` int(11) NOT NULL,
  `carton_print_status` int(11) DEFAULT NULL,
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL,
  `trim_status` int(11) DEFAULT NULL,
  `fsp_time_line` varchar(500) NOT NULL,
  `fsp_last_up` datetime NOT NULL,
  `order_embl_a` int(11) NOT NULL DEFAULT 0,
  `order_embl_b` int(11) NOT NULL DEFAULT 0,
  `order_embl_c` int(11) NOT NULL DEFAULT 0,
  `order_embl_d` int(11) NOT NULL DEFAULT 0,
  `order_embl_e` int(11) NOT NULL DEFAULT 0,
  `order_embl_f` int(11) NOT NULL DEFAULT 0,
  `order_embl_g` int(11) NOT NULL DEFAULT 0,
  `order_embl_h` int(11) NOT NULL DEFAULT 0,
  `act_cut` int(11) NOT NULL,
  `act_in` int(11) NOT NULL,
  `act_fca` int(11) NOT NULL,
  `act_mca` int(11) NOT NULL,
  `act_fg` int(11) NOT NULL,
  `cart_pending` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `act_ship` int(11) NOT NULL,
  `output` int(11) NOT NULL,
  `act_rej` int(11) NOT NULL,
  `destination` varchar(20) NOT NULL,
  `vpo` varchar(20) DEFAULT NULL,
  `smv` float DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_del_no` (`order_del_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Backup of bai_orders_db to track process confirmed orders';

/*Table structure for table `bai_orders_db_confirm_mo` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_confirm_mo`;

CREATE TABLE `bai_pro3`.`bai_orders_db_confirm_mo` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `order_upload_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_style_no` varchar(180) DEFAULT NULL,
  `order_del_no` varchar(180) DEFAULT NULL,
  `order_col_des` varchar(450) DEFAULT NULL,
  `sfcs_size` varchar(150) DEFAULT NULL,
  `m_size` varchar(75) DEFAULT NULL COMMENT 'm3 size',
  `mo_qty` int(11) DEFAULT NULL COMMENT 'order qty',
  `fill_qty` int(11) DEFAULT 0 COMMENT 'filled qty',
  `rej_pcs` int(11) DEFAULT 0 COMMENT 'rejection pcs',
  `sfcs_ops` varchar(75) DEFAULT NULL COMMENT 'sfcs operation',
  `m_ops` varchar(75) DEFAULT NULL COMMENT 'm3 operation code',
  `zfeature_desc` varchar(75) DEFAULT NULL COMMENT 'validate with this description',
  `mo_number` varchar(75) DEFAULT NULL COMMENT 'mo number',
  `destination` varchar(30) DEFAULT NULL COMMENT 'destination',
  `zfeature` varchar(45) DEFAULT NULL COMMENT 'Country Block',
  `co_no` varchar(75) DEFAULT NULL COMMENT 'customer order number',
  `mpo_no` varchar(75) DEFAULT NULL COMMENT 'manufacture order',
  `vpo_no` varchar(75) DEFAULT NULL,
  `order_no` int(10) DEFAULT 0 COMMENT '1- is last , 0 - order',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique id` (`m_ops`,`mo_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_confirm_uniqlo` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_confirm_uniqlo`;

CREATE TABLE `bai_pro3`.`bai_orders_db_confirm_uniqlo` (
  `order_tid` varchar(200) NOT NULL,
  `order_date` date NOT NULL,
  `order_upload_date` date NOT NULL,
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL,
  `order_style_no` varchar(60) NOT NULL,
  `order_del_no` varchar(60) NOT NULL,
  `order_col_des` varchar(150) NOT NULL,
  `order_col_code` varchar(100) NOT NULL,
  `order_s_xs` int(50) NOT NULL,
  `order_s_s` int(50) NOT NULL,
  `order_s_m` int(50) NOT NULL,
  `order_s_l` int(50) NOT NULL,
  `order_s_xl` int(50) NOT NULL,
  `order_s_xxl` int(50) NOT NULL,
  `order_s_xxxl` int(50) NOT NULL,
  `order_cat_stat` varchar(20) NOT NULL,
  `order_cut_stat` varchar(20) NOT NULL,
  `order_ratio_stat` varchar(20) NOT NULL,
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `old_order_s_xs` int(11) NOT NULL,
  `old_order_s_s` int(11) NOT NULL,
  `old_order_s_m` int(11) NOT NULL,
  `old_order_s_l` int(11) NOT NULL,
  `old_order_s_xl` int(11) NOT NULL,
  `old_order_s_xxl` int(11) NOT NULL,
  `old_order_s_xxxl` int(11) NOT NULL,
  `color_code` int(11) DEFAULT NULL,
  `order_joins` varchar(500) NOT NULL DEFAULT '0',
  `order_s_s06` int(11) NOT NULL,
  `order_s_s08` int(11) NOT NULL,
  `order_s_s10` int(11) NOT NULL,
  `order_s_s12` int(11) NOT NULL,
  `order_s_s14` int(11) NOT NULL,
  `order_s_s16` int(11) NOT NULL,
  `order_s_s18` int(11) NOT NULL,
  `order_s_s20` int(11) NOT NULL,
  `order_s_s22` int(11) NOT NULL,
  `order_s_s24` int(11) NOT NULL,
  `order_s_s26` int(11) NOT NULL,
  `order_s_s28` int(11) NOT NULL,
  `order_s_s30` int(11) NOT NULL,
  `old_order_s_s06` int(11) NOT NULL,
  `old_order_s_s08` int(11) NOT NULL,
  `old_order_s_s10` int(11) NOT NULL,
  `old_order_s_s12` int(11) NOT NULL,
  `old_order_s_s14` int(11) NOT NULL,
  `old_order_s_s16` int(11) NOT NULL,
  `old_order_s_s18` int(11) NOT NULL,
  `old_order_s_s20` int(11) NOT NULL,
  `old_order_s_s22` int(11) NOT NULL,
  `old_order_s_s24` int(11) NOT NULL,
  `old_order_s_s26` int(11) NOT NULL,
  `old_order_s_s28` int(11) NOT NULL,
  `old_order_s_s30` int(11) NOT NULL,
  `packing_method` varchar(12) NOT NULL,
  `style_id` varchar(20) NOT NULL,
  `carton_id` int(11) NOT NULL,
  `carton_print_status` int(11) DEFAULT NULL,
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL,
  `trim_status` int(11) DEFAULT NULL,
  `fsp_time_line` varchar(500) NOT NULL,
  `fsp_last_up` datetime NOT NULL,
  `order_embl_a` int(11) NOT NULL DEFAULT 0,
  `order_embl_b` int(11) NOT NULL DEFAULT 0,
  `order_embl_c` int(11) NOT NULL DEFAULT 0,
  `order_embl_d` int(11) NOT NULL DEFAULT 0,
  `order_embl_e` int(11) NOT NULL DEFAULT 0,
  `order_embl_f` int(11) NOT NULL DEFAULT 0,
  `order_embl_g` int(11) NOT NULL DEFAULT 0,
  `order_embl_h` int(11) NOT NULL DEFAULT 0,
  `act_cut` int(11) NOT NULL,
  `act_in` int(11) NOT NULL,
  `act_fca` int(11) NOT NULL,
  `act_mca` int(11) NOT NULL,
  `act_fg` int(11) NOT NULL,
  `cart_pending` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `act_ship` int(11) NOT NULL,
  `output` int(11) NOT NULL,
  `act_rej` int(11) NOT NULL,
  `destination` varchar(20) NOT NULL,
  `vpo` varchar(20) DEFAULT NULL,
  `grp_name` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_del_no` (`order_del_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Backup of bai_orders_db to track process confirmed orders';

/*Table structure for table `bai_orders_db_delete` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_delete`;

CREATE TABLE `bai_pro3`.`bai_orders_db_delete` (
  `order_tid` varchar(200) NOT NULL,
  `order_date` date NOT NULL,
  `order_upload_date` date NOT NULL,
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(60) NOT NULL,
  `order_style_no` varchar(60) NOT NULL,
  `order_del_no` varchar(60) NOT NULL,
  `order_col_des` varchar(150) NOT NULL,
  `order_col_code` varchar(100) NOT NULL,
  `order_s_xs` int(50) NOT NULL,
  `order_s_s` int(50) NOT NULL,
  `order_s_m` int(50) NOT NULL,
  `order_s_l` int(50) NOT NULL,
  `order_s_xl` int(50) NOT NULL,
  `order_s_xxl` int(50) NOT NULL,
  `order_s_xxxl` int(50) NOT NULL,
  `order_cat_stat` varchar(20) NOT NULL,
  `order_cut_stat` varchar(20) NOT NULL,
  `order_ratio_stat` varchar(20) NOT NULL,
  `order_cad_stat` varchar(20) NOT NULL,
  `order_stat` varchar(20) NOT NULL,
  `Order_remarks` varchar(250) NOT NULL,
  `order_po_no` varchar(100) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `old_order_s_xs` int(11) NOT NULL,
  `old_order_s_s` int(11) NOT NULL,
  `old_order_s_m` int(11) NOT NULL,
  `old_order_s_l` int(11) NOT NULL,
  `old_order_s_xl` int(11) NOT NULL,
  `old_order_s_xxl` int(11) NOT NULL,
  `old_order_s_xxxl` int(11) NOT NULL,
  `color_code` int(11) DEFAULT NULL,
  `order_joins` varchar(500) NOT NULL DEFAULT '0',
  `order_s_s06` int(11) NOT NULL,
  `order_s_s08` int(11) NOT NULL,
  `order_s_s10` int(11) NOT NULL,
  `order_s_s12` int(11) NOT NULL,
  `order_s_s14` int(11) NOT NULL,
  `order_s_s16` int(11) NOT NULL,
  `order_s_s18` int(11) NOT NULL,
  `order_s_s20` int(11) NOT NULL,
  `order_s_s22` int(11) NOT NULL,
  `order_s_s24` int(11) NOT NULL,
  `order_s_s26` int(11) NOT NULL,
  `order_s_s28` int(11) NOT NULL,
  `order_s_s30` int(11) NOT NULL,
  `old_order_s_s06` int(11) NOT NULL,
  `old_order_s_s08` int(11) NOT NULL,
  `old_order_s_s10` int(11) NOT NULL,
  `old_order_s_s12` int(11) NOT NULL,
  `old_order_s_s14` int(11) NOT NULL,
  `old_order_s_s16` int(11) NOT NULL,
  `old_order_s_s18` int(11) NOT NULL,
  `old_order_s_s20` int(11) NOT NULL,
  `old_order_s_s22` int(11) NOT NULL,
  `old_order_s_s24` int(11) NOT NULL,
  `old_order_s_s26` int(11) NOT NULL,
  `old_order_s_s28` int(11) NOT NULL,
  `old_order_s_s30` int(11) NOT NULL,
  `packing_method` varchar(12) NOT NULL,
  `style_id` varchar(20) NOT NULL,
  `carton_id` int(11) NOT NULL,
  `carton_print_status` int(11) DEFAULT NULL,
  `ft_status` int(11) DEFAULT NULL COMMENT 'Fabric_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `pt_status` int(11) DEFAULT NULL COMMENT 'Packing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `trim_cards` varchar(100) DEFAULT NULL,
  `trim_status` int(11) DEFAULT NULL,
  `fsp_time_line` varchar(500) NOT NULL,
  `fsp_last_up` datetime NOT NULL,
  `order_embl_a` int(11) NOT NULL,
  `order_embl_b` int(11) NOT NULL,
  `order_embl_c` int(11) NOT NULL,
  `order_embl_d` int(11) NOT NULL,
  `order_embl_e` int(11) NOT NULL,
  `order_embl_f` int(11) NOT NULL,
  `order_embl_g` int(11) NOT NULL,
  `order_embl_h` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `d_time` datetime DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_mo` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_mo`;

CREATE TABLE `bai_pro3`.`bai_orders_db_mo` (
  `order_upload_date` datetime NOT NULL,
  `order_style_no` varchar(60) NOT NULL,
  `order_del_no` varchar(60) NOT NULL,
  `order_col_des` varchar(150) NOT NULL,
  `sfcs_size` varchar(50) NOT NULL,
  `m_size` varchar(25) DEFAULT NULL COMMENT 'm3 size',
  `mo_qty` int(11) DEFAULT NULL COMMENT 'order qty',
  `fill_qty` int(11) DEFAULT NULL COMMENT 'filled qty',
  `sfcs_ops` varchar(25) DEFAULT NULL COMMENT 'sfcs operation',
  `m_ops` varchar(25) DEFAULT NULL COMMENT 'm3 operation code',
  `mo_number` varchar(25) NOT NULL COMMENT 'mo number',
  `destination` varchar(10) DEFAULT NULL COMMENT 'destination',
  `zfeature` varchar(15) DEFAULT NULL COMMENT 'Country Block',
  `cpo_no` varchar(25) DEFAULT NULL COMMENT 'customer order number',
  `mpo_no` varchar(25) DEFAULT NULL COMMENT 'manufacture order',
  `vpo_no` varchar(25) DEFAULT NULL,
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_del_no` (`order_del_no`),
  KEY `order_tid` (`order_style_no`,`order_del_no`,`order_col_des`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_remarks` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_remarks`;

CREATE TABLE `bai_pro3`.`bai_orders_db_remarks` (
  `order_tid` varchar(300) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL COMMENT 'Special Remarks for Lay Plan',
  `binding_con` double NOT NULL,
  PRIMARY KEY (`order_tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To add additional comments for Layplan';

/*Table structure for table `bai_orders_db_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_temp`;

CREATE TABLE `bai_pro3`.`bai_orders_db_temp` (
  `order_tid` varchar(1800) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_upload_date` date DEFAULT NULL,
  `order_last_mod_date` date DEFAULT NULL,
  `order_last_upload_date` date DEFAULT NULL,
  `order_div` varchar(540) DEFAULT NULL,
  `order_style_no` varchar(540) DEFAULT NULL,
  `order_del_no` varchar(540) DEFAULT NULL,
  `order_col_des` varchar(1350) DEFAULT NULL,
  `order_col_code` varchar(900) DEFAULT NULL,
  `order_s_xs` int(50) DEFAULT NULL,
  `order_s_s` int(50) DEFAULT NULL,
  `order_s_m` int(50) DEFAULT NULL,
  `order_s_l` int(50) DEFAULT NULL,
  `order_s_xl` int(50) DEFAULT NULL,
  `order_s_xxl` int(50) DEFAULT NULL,
  `order_s_xxxl` int(50) DEFAULT NULL,
  `order_cat_stat` varchar(180) DEFAULT NULL,
  `order_cut_stat` varchar(180) DEFAULT NULL,
  `order_ratio_stat` varchar(180) DEFAULT NULL,
  `order_cad_stat` varchar(180) DEFAULT NULL,
  `order_stat` varchar(180) DEFAULT NULL,
  `Order_remarks` varchar(2250) DEFAULT NULL,
  `order_po_no` varchar(900) DEFAULT NULL,
  `order_no` varchar(900) DEFAULT NULL,
  `old_order_s_xs` int(11) DEFAULT NULL,
  `old_order_s_s` int(11) DEFAULT NULL,
  `old_order_s_m` int(11) DEFAULT NULL,
  `old_order_s_l` int(11) DEFAULT NULL,
  `old_order_s_xl` int(11) DEFAULT NULL,
  `old_order_s_xxl` int(11) DEFAULT NULL,
  `old_order_s_xxxl` int(11) DEFAULT NULL,
  `color_code` int(11) DEFAULT NULL,
  `order_joins` varchar(4500) DEFAULT NULL,
  `order_s_s01` int(11) DEFAULT NULL,
  `order_s_s02` int(11) DEFAULT NULL,
  `order_s_s03` int(11) DEFAULT NULL,
  `order_s_s04` int(11) DEFAULT NULL,
  `order_s_s05` int(11) DEFAULT NULL,
  `order_s_s06` int(11) DEFAULT NULL,
  `order_s_s07` int(11) DEFAULT NULL,
  `order_s_s08` int(11) DEFAULT NULL,
  `order_s_s09` int(11) DEFAULT NULL,
  `order_s_s10` int(11) DEFAULT NULL,
  `order_s_s11` int(11) DEFAULT NULL,
  `order_s_s12` int(11) DEFAULT NULL,
  `order_s_s13` int(11) DEFAULT NULL,
  `order_s_s14` int(11) DEFAULT NULL,
  `order_s_s15` int(11) DEFAULT NULL,
  `order_s_s16` int(11) DEFAULT NULL,
  `order_s_s17` int(11) DEFAULT NULL,
  `order_s_s18` int(11) DEFAULT NULL,
  `order_s_s19` int(11) DEFAULT NULL,
  `order_s_s20` int(11) DEFAULT NULL,
  `order_s_s21` int(11) DEFAULT NULL,
  `order_s_s22` int(11) DEFAULT NULL,
  `order_s_s23` int(11) DEFAULT NULL,
  `order_s_s24` int(11) DEFAULT NULL,
  `order_s_s25` int(11) DEFAULT NULL,
  `order_s_s26` int(11) DEFAULT NULL,
  `order_s_s27` int(11) DEFAULT NULL,
  `order_s_s28` int(11) DEFAULT NULL,
  `order_s_s29` int(11) DEFAULT NULL,
  `order_s_s30` int(11) DEFAULT NULL,
  `order_s_s31` int(11) DEFAULT NULL,
  `order_s_s32` int(11) DEFAULT NULL,
  `order_s_s33` int(11) DEFAULT NULL,
  `order_s_s34` int(11) DEFAULT NULL,
  `order_s_s35` int(11) DEFAULT NULL,
  `order_s_s36` int(11) DEFAULT NULL,
  `order_s_s37` int(11) DEFAULT NULL,
  `order_s_s38` int(11) DEFAULT NULL,
  `order_s_s39` int(11) DEFAULT NULL,
  `order_s_s40` int(11) DEFAULT NULL,
  `order_s_s41` int(11) DEFAULT NULL,
  `order_s_s42` int(11) DEFAULT NULL,
  `order_s_s43` int(11) DEFAULT NULL,
  `order_s_s44` int(11) DEFAULT NULL,
  `order_s_s45` int(11) DEFAULT NULL,
  `order_s_s46` int(11) DEFAULT NULL,
  `order_s_s47` int(11) DEFAULT NULL,
  `order_s_s48` int(11) DEFAULT NULL,
  `order_s_s49` int(11) DEFAULT NULL,
  `order_s_s50` int(11) DEFAULT NULL,
  `old_order_s_s01` int(11) DEFAULT NULL,
  `old_order_s_s02` int(11) DEFAULT NULL,
  `old_order_s_s03` int(11) DEFAULT NULL,
  `old_order_s_s04` int(11) DEFAULT NULL,
  `old_order_s_s05` int(11) DEFAULT NULL,
  `old_order_s_s06` int(11) DEFAULT NULL,
  `old_order_s_s07` int(11) DEFAULT NULL,
  `old_order_s_s08` int(11) DEFAULT NULL,
  `old_order_s_s09` int(11) DEFAULT NULL,
  `old_order_s_s10` int(11) DEFAULT NULL,
  `old_order_s_s11` int(11) DEFAULT NULL,
  `old_order_s_s12` int(11) DEFAULT NULL,
  `old_order_s_s13` int(11) DEFAULT NULL,
  `old_order_s_s14` int(11) DEFAULT NULL,
  `old_order_s_s15` int(11) DEFAULT NULL,
  `old_order_s_s16` int(11) DEFAULT NULL,
  `old_order_s_s17` int(11) DEFAULT NULL,
  `old_order_s_s18` int(11) DEFAULT NULL,
  `old_order_s_s19` int(11) DEFAULT NULL,
  `old_order_s_s20` int(11) DEFAULT NULL,
  `old_order_s_s21` int(11) DEFAULT NULL,
  `old_order_s_s22` int(11) DEFAULT NULL,
  `old_order_s_s23` int(11) DEFAULT NULL,
  `old_order_s_s24` int(11) DEFAULT NULL,
  `old_order_s_s25` int(11) DEFAULT NULL,
  `old_order_s_s26` int(11) DEFAULT NULL,
  `old_order_s_s27` int(11) DEFAULT NULL,
  `old_order_s_s28` int(11) DEFAULT NULL,
  `old_order_s_s29` int(11) DEFAULT NULL,
  `old_order_s_s30` int(11) DEFAULT NULL,
  `old_order_s_s31` int(11) DEFAULT NULL,
  `old_order_s_s32` int(11) DEFAULT NULL,
  `old_order_s_s33` int(11) DEFAULT NULL,
  `old_order_s_s34` int(11) DEFAULT NULL,
  `old_order_s_s35` int(11) DEFAULT NULL,
  `old_order_s_s36` int(11) DEFAULT NULL,
  `old_order_s_s37` int(11) DEFAULT NULL,
  `old_order_s_s38` int(11) DEFAULT NULL,
  `old_order_s_s39` int(11) DEFAULT NULL,
  `old_order_s_s40` int(11) DEFAULT NULL,
  `old_order_s_s41` int(11) DEFAULT NULL,
  `old_order_s_s42` int(11) DEFAULT NULL,
  `old_order_s_s43` int(11) DEFAULT NULL,
  `old_order_s_s44` int(11) DEFAULT NULL,
  `old_order_s_s45` int(11) DEFAULT NULL,
  `old_order_s_s46` int(11) DEFAULT NULL,
  `old_order_s_s47` int(11) DEFAULT NULL,
  `old_order_s_s48` int(11) DEFAULT NULL,
  `old_order_s_s49` int(11) DEFAULT NULL,
  `old_order_s_s50` int(11) DEFAULT NULL,
  `packing_method` varchar(108) DEFAULT NULL,
  `style_id` varchar(180) DEFAULT NULL,
  `carton_id` int(11) DEFAULT NULL,
  `carton_print_status` int(11) DEFAULT NULL,
  `ft_status` int(11) DEFAULT NULL,
  `st_status` int(11) DEFAULT NULL,
  `pt_status` int(11) DEFAULT NULL,
  `trim_cards` varchar(900) DEFAULT NULL,
  `trim_status` int(11) DEFAULT NULL,
  `fsp_time_line` varchar(4500) DEFAULT NULL,
  `fsp_last_up` datetime DEFAULT NULL,
  `order_embl_a` int(11) DEFAULT NULL,
  `order_embl_b` int(11) DEFAULT NULL,
  `order_embl_c` int(11) DEFAULT NULL,
  `order_embl_d` int(11) DEFAULT NULL,
  `order_embl_e` int(11) DEFAULT NULL,
  `order_embl_f` int(11) DEFAULT NULL,
  `order_embl_g` int(11) DEFAULT NULL,
  `order_embl_h` int(11) DEFAULT NULL,
  `act_cut` int(11) DEFAULT NULL,
  `act_in` int(11) DEFAULT NULL,
  `act_fca` int(11) DEFAULT NULL,
  `act_mca` int(11) DEFAULT NULL,
  `act_fg` int(11) DEFAULT NULL,
  `cart_pending` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `act_ship` int(11) DEFAULT NULL,
  `output` int(11) DEFAULT NULL,
  `act_rej` int(11) DEFAULT NULL,
  `title_size_s01` varchar(180) DEFAULT NULL,
  `title_size_s02` varchar(180) DEFAULT NULL,
  `title_size_s03` varchar(180) DEFAULT NULL,
  `title_size_s04` varchar(180) DEFAULT NULL,
  `title_size_s05` varchar(180) DEFAULT NULL,
  `title_size_s06` varchar(180) DEFAULT NULL,
  `title_size_s07` varchar(180) DEFAULT NULL,
  `title_size_s08` varchar(180) DEFAULT NULL,
  `title_size_s09` varchar(180) DEFAULT NULL,
  `title_size_s10` varchar(180) DEFAULT NULL,
  `title_size_s11` varchar(180) DEFAULT NULL,
  `title_size_s12` varchar(180) DEFAULT NULL,
  `title_size_s13` varchar(180) DEFAULT NULL,
  `title_size_s14` varchar(180) DEFAULT NULL,
  `title_size_s15` varchar(180) DEFAULT NULL,
  `title_size_s16` varchar(180) DEFAULT NULL,
  `title_size_s17` varchar(180) DEFAULT NULL,
  `title_size_s18` varchar(180) DEFAULT NULL,
  `title_size_s19` varchar(180) DEFAULT NULL,
  `title_size_s20` varchar(180) DEFAULT NULL,
  `title_size_s21` varchar(180) DEFAULT NULL,
  `title_size_s22` varchar(180) DEFAULT NULL,
  `title_size_s23` varchar(180) DEFAULT NULL,
  `title_size_s24` varchar(180) DEFAULT NULL,
  `title_size_s25` varchar(180) DEFAULT NULL,
  `title_size_s26` varchar(180) DEFAULT NULL,
  `title_size_s27` varchar(180) DEFAULT NULL,
  `title_size_s28` varchar(180) DEFAULT NULL,
  `title_size_s29` varchar(180) DEFAULT NULL,
  `title_size_s30` varchar(180) DEFAULT NULL,
  `title_size_s31` varchar(180) DEFAULT NULL,
  `title_size_s32` varchar(180) DEFAULT NULL,
  `title_size_s33` varchar(180) DEFAULT NULL,
  `title_size_s34` varchar(180) DEFAULT NULL,
  `title_size_s35` varchar(180) DEFAULT NULL,
  `title_size_s36` varchar(180) DEFAULT NULL,
  `title_size_s37` varchar(180) DEFAULT NULL,
  `title_size_s38` varchar(180) DEFAULT NULL,
  `title_size_s39` varchar(180) DEFAULT NULL,
  `title_size_s40` varchar(180) DEFAULT NULL,
  `title_size_s41` varchar(180) DEFAULT NULL,
  `title_size_s42` varchar(180) DEFAULT NULL,
  `title_size_s43` varchar(180) DEFAULT NULL,
  `title_size_s44` varchar(180) DEFAULT NULL,
  `title_size_s45` varchar(180) DEFAULT NULL,
  `title_size_s46` varchar(180) DEFAULT NULL,
  `title_size_s47` varchar(180) DEFAULT NULL,
  `title_size_s48` varchar(180) DEFAULT NULL,
  `title_size_s49` varchar(180) DEFAULT NULL,
  `title_size_s50` varchar(180) DEFAULT NULL,
  `title_flag` int(11) DEFAULT NULL,
  `title_size_xs` varchar(180) DEFAULT NULL,
  `title_size_s` varchar(180) DEFAULT NULL,
  `title_size_m` varchar(180) DEFAULT NULL,
  `title_size_l` varchar(180) DEFAULT NULL,
  `title_size_xl` varchar(180) DEFAULT NULL,
  `title_size_xxl` varchar(180) DEFAULT NULL,
  `title_size_xxxl` varchar(180) DEFAULT NULL,
  `smv` float DEFAULT NULL,
  `smo` int(11) DEFAULT NULL,
  `destination` varchar(90) DEFAULT NULL,
  `bts_status` int(11) DEFAULT NULL,
  `zfeature` varchar(135) DEFAULT NULL,
  `ratio_packing_method` varchar(405) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_temp_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_temp_archive`;

CREATE TABLE `bai_pro3`.`bai_orders_db_temp_archive` (
  `order_tid` varchar(600) NOT NULL,
  `order_date` date NOT NULL,
  `order_upload_date` date NOT NULL,
  `order_last_mod_date` date NOT NULL,
  `order_last_upload_date` date NOT NULL,
  `order_div` varchar(180) NOT NULL,
  `order_style_no` varchar(180) NOT NULL,
  `order_del_no` varchar(180) NOT NULL,
  `order_col_des` varchar(450) NOT NULL,
  `order_col_code` varchar(300) NOT NULL,
  `order_s_xs` double NOT NULL,
  `order_s_s` double NOT NULL,
  `order_s_m` double NOT NULL,
  `order_s_l` double NOT NULL,
  `order_s_xl` double NOT NULL,
  `order_s_xxl` double NOT NULL,
  `order_s_xxxl` double NOT NULL,
  `order_cat_stat` varchar(60) NOT NULL,
  `order_cut_stat` varchar(60) NOT NULL,
  `order_ratio_stat` varchar(60) NOT NULL,
  `order_cad_stat` varchar(60) NOT NULL,
  `order_stat` varchar(60) NOT NULL,
  `Order_remarks` varchar(750) NOT NULL,
  `order_po_no` varchar(300) NOT NULL,
  `order_no` varchar(300) NOT NULL,
  `old_order_s_xs` double NOT NULL,
  `old_order_s_s` double NOT NULL,
  `old_order_s_m` double NOT NULL,
  `old_order_s_l` double NOT NULL,
  `old_order_s_xl` double NOT NULL,
  `old_order_s_xxl` double NOT NULL,
  `old_order_s_xxxl` double NOT NULL,
  `color_code` double DEFAULT NULL,
  `order_joins` varchar(1500) NOT NULL,
  `order_s_s06` double NOT NULL,
  `order_s_s08` double NOT NULL,
  `order_s_s10` double NOT NULL,
  `order_s_s12` double NOT NULL,
  `order_s_s14` double NOT NULL,
  `order_s_s16` double NOT NULL,
  `order_s_s18` double NOT NULL,
  `order_s_s20` double NOT NULL,
  `order_s_s22` double NOT NULL,
  `order_s_s24` double NOT NULL,
  `order_s_s26` double NOT NULL,
  `order_s_s28` double NOT NULL,
  `order_s_s30` double NOT NULL,
  `old_order_s_s06` double NOT NULL,
  `old_order_s_s08` double NOT NULL,
  `old_order_s_s10` double NOT NULL,
  `old_order_s_s12` double NOT NULL,
  `old_order_s_s14` double NOT NULL,
  `old_order_s_s16` double NOT NULL,
  `old_order_s_s18` double NOT NULL,
  `old_order_s_s20` double NOT NULL,
  `old_order_s_s22` double NOT NULL,
  `old_order_s_s24` double NOT NULL,
  `old_order_s_s26` double NOT NULL,
  `old_order_s_s28` double NOT NULL,
  `old_order_s_s30` double NOT NULL,
  `packing_method` varchar(36) NOT NULL,
  `style_id` varchar(60) NOT NULL,
  `carton_id` double NOT NULL,
  `carton_print_status` double NOT NULL,
  `ft_status` double DEFAULT NULL,
  `st_status` double DEFAULT NULL,
  `pt_status` double DEFAULT NULL,
  `trim_cards` varchar(300) DEFAULT NULL,
  `trim_status` double DEFAULT NULL,
  `fsp_time_line` varchar(1500) NOT NULL,
  `fsp_last_up` datetime NOT NULL,
  `order_embl_a` double NOT NULL,
  `order_embl_b` double NOT NULL,
  `order_embl_c` double NOT NULL,
  `order_embl_d` double NOT NULL,
  `order_embl_e` double NOT NULL,
  `order_embl_f` double NOT NULL,
  `order_embl_g` double NOT NULL,
  `order_embl_h` double NOT NULL,
  `act_cut` double NOT NULL,
  `act_in` double NOT NULL,
  `act_fca` double NOT NULL,
  `act_mca` double NOT NULL,
  `act_fg` double NOT NULL,
  `cart_pending` double NOT NULL,
  `priority` double NOT NULL,
  `act_ship` double NOT NULL,
  `output` double NOT NULL,
  `act_rej` double DEFAULT NULL,
  `destination` varchar(60) NOT NULL,
  `vpo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`order_tid`,`destination`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_temp_confirm` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_orders_db_temp_confirm`;

CREATE TABLE `bai_pro3`.`bai_orders_db_temp_confirm` (
  `order_tid` varchar(200) NOT NULL,
  `order_date` date DEFAULT NULL,
  `order_upload_date` date DEFAULT NULL,
  `order_last_mod_date` date DEFAULT NULL,
  `order_last_upload_date` date DEFAULT NULL,
  `order_div` varchar(540) DEFAULT NULL,
  `order_style_no` varchar(540) DEFAULT NULL,
  `order_del_no` varchar(540) DEFAULT NULL,
  `order_col_des` varchar(1350) DEFAULT NULL,
  `order_col_code` varchar(900) DEFAULT NULL,
  `order_s_xs` double DEFAULT NULL,
  `order_s_s` double DEFAULT NULL,
  `order_s_m` double DEFAULT NULL,
  `order_s_l` double DEFAULT NULL,
  `order_s_xl` double DEFAULT NULL,
  `order_s_xxl` double DEFAULT NULL,
  `order_s_xxxl` double DEFAULT NULL,
  `order_cat_stat` varchar(180) DEFAULT NULL,
  `order_cut_stat` varchar(180) DEFAULT NULL,
  `order_ratio_stat` varchar(180) DEFAULT NULL,
  `order_cad_stat` varchar(180) DEFAULT NULL,
  `order_stat` varchar(180) DEFAULT NULL,
  `Order_remarks` varchar(2250) DEFAULT NULL,
  `order_po_no` varchar(900) DEFAULT NULL,
  `order_no` varchar(900) DEFAULT NULL,
  `old_order_s_xs` double DEFAULT NULL,
  `old_order_s_s` double DEFAULT NULL,
  `old_order_s_m` double DEFAULT NULL,
  `old_order_s_l` double DEFAULT NULL,
  `old_order_s_xl` double DEFAULT NULL,
  `old_order_s_xxl` double DEFAULT NULL,
  `old_order_s_xxxl` double DEFAULT NULL,
  `color_code` double DEFAULT NULL,
  `order_joins` varchar(4500) DEFAULT NULL,
  `order_s_s06` double DEFAULT NULL,
  `order_s_s08` double DEFAULT NULL,
  `order_s_s10` double DEFAULT NULL,
  `order_s_s12` double DEFAULT NULL,
  `order_s_s14` double DEFAULT NULL,
  `order_s_s16` double DEFAULT NULL,
  `order_s_s18` double DEFAULT NULL,
  `order_s_s20` double DEFAULT NULL,
  `order_s_s22` double DEFAULT NULL,
  `order_s_s24` double DEFAULT NULL,
  `order_s_s26` double DEFAULT NULL,
  `order_s_s28` double DEFAULT NULL,
  `order_s_s30` double DEFAULT NULL,
  `old_order_s_s06` double DEFAULT NULL,
  `old_order_s_s08` double DEFAULT NULL,
  `old_order_s_s10` double DEFAULT NULL,
  `old_order_s_s12` double DEFAULT NULL,
  `old_order_s_s14` double DEFAULT NULL,
  `old_order_s_s16` double DEFAULT NULL,
  `old_order_s_s18` double DEFAULT NULL,
  `old_order_s_s20` double DEFAULT NULL,
  `old_order_s_s22` double DEFAULT NULL,
  `old_order_s_s24` double DEFAULT NULL,
  `old_order_s_s26` double DEFAULT NULL,
  `old_order_s_s28` double DEFAULT NULL,
  `old_order_s_s30` double DEFAULT NULL,
  `packing_method` varchar(108) DEFAULT NULL,
  `style_id` varchar(180) DEFAULT NULL,
  `carton_id` double DEFAULT NULL,
  `carton_print_status` double DEFAULT NULL,
  `ft_status` double DEFAULT NULL,
  `st_status` double DEFAULT NULL,
  `pt_status` double DEFAULT NULL,
  `trim_cards` varchar(900) DEFAULT NULL,
  `trim_status` double DEFAULT NULL,
  `fsp_time_line` varchar(4500) DEFAULT NULL,
  `fsp_last_up` datetime DEFAULT NULL,
  `order_embl_a` double DEFAULT NULL,
  `order_embl_b` double DEFAULT NULL,
  `order_embl_c` double DEFAULT NULL,
  `order_embl_d` double DEFAULT NULL,
  `order_embl_e` double DEFAULT NULL,
  `order_embl_f` double DEFAULT NULL,
  `order_embl_g` double DEFAULT NULL,
  `order_embl_h` double DEFAULT NULL,
  `act_cut` double DEFAULT NULL,
  `act_in` double DEFAULT NULL,
  `act_fca` double DEFAULT NULL,
  `act_mca` double DEFAULT NULL,
  `act_fg` double DEFAULT NULL,
  `cart_pending` double DEFAULT NULL,
  `priority` double DEFAULT NULL,
  `act_ship` double DEFAULT NULL,
  `output` double DEFAULT NULL,
  `act_rej` double DEFAULT NULL,
  `destination` varchar(10) NOT NULL,
  PRIMARY KEY (`order_tid`,`destination`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_db` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_db`;

CREATE TABLE `bai_pro3`.`bai_qms_db` (
  `qms_tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction Id',
  `qms_style` varchar(30) NOT NULL COMMENT 'Style',
  `qms_schedule` varchar(20) NOT NULL COMMENT 'Schedule',
  `qms_color` varchar(150) NOT NULL COMMENT 'Color',
  `qms_remarks` varchar(20) NOT NULL COMMENT 'Remarks',
  `bundle_no` int(20) DEFAULT NULL COMMENT 'Bundle Number',
  `log_user` varchar(15) NOT NULL COMMENT 'Updated user',
  `log_date` date NOT NULL COMMENT 'Log date',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Log Time',
  `issued_by` varchar(30) NOT NULL COMMENT 'Good panels issued by',
  `qms_size` varchar(5) NOT NULL COMMENT 'Size',
  `qms_qty` smallint(6) NOT NULL COMMENT 'Qunatity',
  `qms_tran_type` smallint(6) NOT NULL COMMENT 'Trasaction type - 1-Good Panel 2- Replaced 3- Rejected 4- Sample Room 5- Good Garments 6-recut raised 7-Disposed (Actual-Panel&Garment) 8-Sent to customer 9- actual Recut 10-Transfer Sent 11-Transfer Received 12-Reserved for Destroy 13-Destroyed Panels (Internal)',
  `remarks` text NOT NULL COMMENT 'Remarks updation / Docket',
  `ref1` varchar(500) NOT NULL,
  `doc_no` varchar(20) NOT NULL COMMENT 'Docket_Reference',
  `location_id` varchar(30) NOT NULL COMMENT 'FK_Location map ID',
  `input_job_no` varchar(50) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`qms_tid`),
  KEY `sscs` (`qms_style`,`qms_schedule`,`qms_color`,`qms_size`),
  KEY `qms_size` (`qms_style`,`qms_size`),
  KEY `qms_color` (`qms_schedule`,`qms_color`),
  KEY `qms_tran_type` (`qms_tran_type`),
  KEY `ref1` (`qms_tran_type`,`ref1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To update quality/rejection details';

/*Table structure for table `bai_qms_db_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_db_archive`;

CREATE TABLE `bai_pro3`.`bai_qms_db_archive` (
  `qms_tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction Id',
  `qms_style` varchar(30) NOT NULL,
  `qms_schedule` varchar(20) NOT NULL,
  `qms_color` varchar(150) NOT NULL,
  `qms_remarks` varchar(50) NOT NULL,
  `bundle_no` int(50) DEFAULT NULL COMMENT 'Bundle Number',
  `log_user` varchar(15) NOT NULL COMMENT 'Updated user',
  `log_date` date NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `issued_by` varchar(30) NOT NULL COMMENT 'Good panels issued by',
  `qms_size` varchar(5) NOT NULL,
  `qms_qty` smallint(6) NOT NULL,
  `qms_tran_type` smallint(6) NOT NULL COMMENT 'Trasaction type - 1-Good Panel 2- Replaced 3- Rejected 4- Sample Room 5- Good Garments 6-recut raised 7-Dispatched 8-Sent to customer 9- actual Recut',
  `remarks` text NOT NULL COMMENT 'Remarks updation / Docket',
  `ref1` varchar(500) NOT NULL,
  `doc_no` varchar(20) NOT NULL COMMENT 'Docket_Reference',
  `input_job_no` varchar(50) NOT NULL,
  `location_id` varchar(30) NOT NULL COMMENT 'FK_Location map ID',
  `operation_id` int(30) NOT NULL,
  PRIMARY KEY (`qms_tid`),
  KEY `qms_color` (`qms_schedule`,`qms_color`),
  KEY `qms_size` (`qms_style`,`qms_size`),
  KEY `qms_tran_type` (`qms_tran_type`),
  KEY `sscs` (`qms_style`,`qms_schedule`,`qms_color`,`qms_size`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To update quality/rejection details';

/*Table structure for table `bai_qms_db_deleted` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_db_deleted`;

CREATE TABLE `bai_pro3`.`bai_qms_db_deleted` (
  `qms_tid` int(11) NOT NULL AUTO_INCREMENT,
  `qms_style` varchar(30) NOT NULL,
  `qms_schedule` varchar(20) NOT NULL,
  `qms_color` varchar(150) NOT NULL,
  `qms_remarks` varchar(20) DEFAULT NULL,
  `bundle_no` int(20) DEFAULT NULL,
  `log_user` varchar(15) NOT NULL,
  `log_date` date NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `issued_by` varchar(30) NOT NULL,
  `qms_size` varchar(5) NOT NULL,
  `qms_qty` smallint(6) NOT NULL,
  `qms_tran_type` smallint(6) NOT NULL,
  `remarks` text NOT NULL,
  `ref1` varchar(500) NOT NULL,
  `doc_no` varchar(20) NOT NULL COMMENT 'Docket_Reference',
  `location_id` varchar(30) NOT NULL COMMENT 'FK_Location map ID',
  `input_job_no` varchar(15) DEFAULT NULL,
  `operation_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`qms_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track deleted Trans of QMS table';

/*Table structure for table `bai_qms_db_reason_track` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_db_reason_track`;

CREATE TABLE `bai_pro3`.`bai_qms_db_reason_track` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `qms_tid` double DEFAULT NULL,
  `qms_reason` double DEFAULT NULL,
  `qms_qty` double DEFAULT NULL,
  `supplier` varchar(100) NOT NULL,
  `log_date` date NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_destroy_log` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_destroy_log`;

CREATE TABLE `bai_pro3`.`bai_qms_destroy_log` (
  `qms_des_note_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Destroy Note Number',
  `qms_des_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qms_log_user` varchar(30) NOT NULL,
  `mer_month_year` varchar(25) DEFAULT NULL,
  `mer_remarks` varchar(100) DEFAULT NULL COMMENT 'To Track Remarks of Relevant MER Packing List',
  PRIMARY KEY (`qms_des_note_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_location_db` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_location_db`;

CREATE TABLE `bai_pro3`.`bai_qms_location_db` (
  `q_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `qms_location_id` varchar(11) NOT NULL COMMENT 'Location ID',
  `qms_location` varchar(30) NOT NULL COMMENT 'Location of carton/container',
  `qms_location_cap` int(11) NOT NULL COMMENT 'Capacity of carton/container',
  `qms_cur_qty` int(11) NOT NULL COMMENT 'Current Quantity',
  `active_status` tinyint(4) NOT NULL COMMENT '0-Active, 1-Inactive',
  `location_type` int(11) NOT NULL COMMENT '0-Normal Location, 1-Reserve for Destroy',
  `order_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`q_id`),
  UNIQUE KEY `UNIQUE` (`qms_location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_rejection_reason` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_rejection_reason`;

CREATE TABLE `bai_pro3`.`bai_qms_rejection_reason` (
  `sno` double NOT NULL AUTO_INCREMENT,
  `reason_cat` varchar(150) DEFAULT NULL,
  `reason_desc` varchar(150) DEFAULT NULL,
  `reason_code` double DEFAULT NULL,
  `reason_order` double DEFAULT NULL,
  `form_type` varchar(5) DEFAULT NULL,
  `m3_reason_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_transfers_log` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_transfers_log`;

CREATE TABLE `bai_pro3`.`bai_qms_transfers_log` (
  `traf_tran_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Transfer Transaction ID',
  `style` varchar(30) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `source_sch` varchar(30) DEFAULT NULL,
  `desti_sch` varchar(30) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `req_qty` int(11) DEFAULT NULL,
  `issued_qty` int(11) DEFAULT NULL,
  `module` varchar(5) DEFAULT NULL,
  `team` varchar(5) DEFAULT NULL,
  `app_by` varchar(30) DEFAULT NULL,
  `app_time` datetime DEFAULT NULL,
  `req_by` varchar(30) DEFAULT NULL,
  `req_time` datetime DEFAULT NULL,
  `issue_by` varchar(30) DEFAULT NULL,
  `issue_time` datetime DEFAULT NULL,
  `cancel_by` varchar(30) DEFAULT NULL,
  `cancel_time` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1- Requested, 2- Approved, 3- Canceled, 4-Issued\r\n',
  `log_time` timestamp NULL DEFAULT NULL,
  `reason` int(11) DEFAULT NULL COMMENT 'Reason Codes: 1- Panel Missing in Production, 2- Extra Shipping',
  PRIMARY KEY (`traf_tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bal_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`bal_stat_log`;

CREATE TABLE `bai_pro3`.`bal_stat_log` (
  `bal_order_tid` varchar(200) NOT NULL,
  `bal_s_xs` int(50) NOT NULL,
  `bal_s_s` int(50) NOT NULL,
  `bal_s_m` int(50) NOT NULL,
  `bal_s_l` int(50) NOT NULL,
  `bal_s_xl` int(50) NOT NULL,
  `bal_s_xxl` int(50) NOT NULL,
  `bal_s_xxxl` int(50) NOT NULL,
  `bal_up_date` datetime NOT NULL,
  `bal_remarks` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `btable` */

DROP TABLE IF EXISTS `bai_pro3`.`btable`;

CREATE TABLE `bai_pro3`.`btable` (
  `bid` varchar(75) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `budget_2014_2015` */

DROP TABLE IF EXISTS `bai_pro3`.`budget_2014_2015`;

CREATE TABLE `bai_pro3`.`budget_2014_2015` (
  `tid` varchar(300) NOT NULL,
  `dep_id` double NOT NULL,
  `item_id` double NOT NULL,
  `jan_req` double NOT NULL,
  `feb_req` double NOT NULL,
  `mar_req` double NOT NULL,
  `apr_req` double NOT NULL,
  `may_req` double NOT NULL,
  `jun_req` double NOT NULL,
  `jul_req` double NOT NULL,
  `aug_req` double NOT NULL,
  `sep_req` double NOT NULL,
  `oct_req` double NOT NULL,
  `nov_req` double NOT NULL,
  `dec_req` double NOT NULL,
  `status` double NOT NULL,
  `jan_con` double NOT NULL,
  `feb_con` double NOT NULL,
  `mar_con` double NOT NULL,
  `apr_con` double NOT NULL,
  `may_con` double NOT NULL,
  `jun_con` double NOT NULL,
  `jul_con` double NOT NULL,
  `aug_con` double NOT NULL,
  `sep_con` double NOT NULL,
  `oct_con` double NOT NULL,
  `nov_con` double NOT NULL,
  `dec_con` double NOT NULL,
  `jan_alc` double NOT NULL,
  `feb_alc` double NOT NULL,
  `mar_alc` double NOT NULL,
  `apr_alc` double NOT NULL,
  `may_alc` double NOT NULL,
  `jun_alc` double NOT NULL,
  `jul_alc` double NOT NULL,
  `aug_alc` double NOT NULL,
  `sep_alc` double NOT NULL,
  `oct_alc` double NOT NULL,
  `nov_alc` double NOT NULL,
  `dec_alc` double NOT NULL,
  `jan_ext` double NOT NULL,
  `feb_ext` double NOT NULL,
  `mar_ext` double NOT NULL,
  `apr_ext` double NOT NULL,
  `may_ext` double NOT NULL,
  `jun_ext` double NOT NULL,
  `jul_ext` double NOT NULL,
  `aug_ext` double NOT NULL,
  `sep_ext` double NOT NULL,
  `oct_ext` double NOT NULL,
  `nov_ext` double NOT NULL,
  `dec_ext` double NOT NULL,
  `jan_utl` double NOT NULL,
  `feb_utl` double NOT NULL,
  `mar_utl` double NOT NULL,
  `apr_utl` double NOT NULL,
  `may_utl` double NOT NULL,
  `jun_utl` double NOT NULL,
  `jul_utl` double NOT NULL,
  `aug_utl` double NOT NULL,
  `sep_utl` double NOT NULL,
  `oct_utl` double NOT NULL,
  `nov_utl` double NOT NULL,
  `dec_utl` double NOT NULL,
  `jan_enh` double NOT NULL,
  `feb_enh` double NOT NULL,
  `mar_enh` double NOT NULL,
  `apr_enh` double NOT NULL,
  `may_enh` double NOT NULL,
  `jun_enh` double NOT NULL,
  `jul_enh` double NOT NULL,
  `aug_enh` double NOT NULL,
  `sep_enh` double NOT NULL,
  `oct_enh` double NOT NULL,
  `nov_enh` double NOT NULL,
  `dec_enh` double NOT NULL,
  `jan_ned` double NOT NULL,
  `feb_ned` double NOT NULL,
  `mar_ned` double NOT NULL,
  `apr_ned` double NOT NULL,
  `may_ned` double NOT NULL,
  `jun_ned` double NOT NULL,
  `jul_ned` double NOT NULL,
  `aug_ned` double NOT NULL,
  `sep_ned` double NOT NULL,
  `oct_ned` double NOT NULL,
  `nov_ned` double NOT NULL,
  `dec_ned` double NOT NULL,
  `budget_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `buyer_style` */

DROP TABLE IF EXISTS `bai_pro3`.`buyer_style`;

CREATE TABLE `bai_pro3`.`buyer_style` (
  `buyer_id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_name` varchar(20) DEFAULT NULL,
  `buyer_identity` varchar(20) DEFAULT NULL,
  `user_list` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Active,0-Inactive',
  `buyer` varchar(45) DEFAULT NULL COMMENT 'actual name of the buyer, PINK as VS PINK',
  PRIMARY KEY (`buyer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `buyer_users` */

DROP TABLE IF EXISTS `bai_pro3`.`buyer_users`;

CREATE TABLE `bai_pro3`.`buyer_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `users` text DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `carton_qty_chart` */

DROP TABLE IF EXISTS `bai_pro3`.`carton_qty_chart`;

CREATE TABLE `bai_pro3`.`carton_qty_chart` (
  `user_style` varchar(50) DEFAULT NULL COMMENT 'User Defined Style',
  `buyer` varchar(50) DEFAULT NULL,
  `buyer_identity` varchar(50) DEFAULT NULL COMMENT 'L & O for VS Logo; P & K for VS Pink;  M for M&S; D for DIM',
  `packing_method` varchar(50) DEFAULT NULL COMMENT 'Packing Method (Assortment Reference)',
  `xs` int(11) DEFAULT 0,
  `s` int(11) DEFAULT 0,
  `m` int(11) DEFAULT 0,
  `l` int(11) DEFAULT 0,
  `xl` int(11) DEFAULT 0,
  `xxl` int(11) DEFAULT 0,
  `xxxl` int(11) DEFAULT 0,
  `s01` int(11) DEFAULT 0 COMMENT 'carton \n\nqty of size s01',
  `s02` int(11) DEFAULT 0 COMMENT 'carton qty of size s02',
  `s03` int(11) DEFAULT 0 COMMENT 'carton qty of size s03',
  `s04` int(11) DEFAULT 0 COMMENT 'carton qty of size s04',
  `s05` int(11) DEFAULT 0 COMMENT 'carton qty of size s05',
  `s06` int(11) DEFAULT 0 COMMENT 'carton qty of size s06',
  `s07` int(11) DEFAULT 0 COMMENT 'carton qty of size s07',
  `s08` int(11) DEFAULT 0 COMMENT 'carton qty of size s08',
  `s09` int(11) DEFAULT 0 COMMENT 'carton qty of size s09',
  `s10` int(11) DEFAULT 0 COMMENT 'carton qty of size s10',
  `s11` int(11) DEFAULT 0 COMMENT 'carton qty of size s11',
  `s12` int(11) DEFAULT 0 COMMENT 'carton qty of size s12',
  `s13` int(11) DEFAULT 0 COMMENT 'carton qty of size \n\ns13',
  `s14` int(11) DEFAULT 0 COMMENT 'carton qty of size s14',
  `s15` int(11) DEFAULT 0 COMMENT 'carton qty of size s15',
  `s16` int(11) DEFAULT 0 COMMENT 'carton qty of size s16',
  `s17` int(11) DEFAULT 0 COMMENT 'carton qty of size s17',
  `s18` int(11) DEFAULT 0 COMMENT 'carton qty of \n\nsize s18',
  `s19` int(11) DEFAULT 0 COMMENT 'carton qty of size s19',
  `s20` int(11) DEFAULT 0 COMMENT 'carton qty of size s20',
  `s21` int(11) DEFAULT 0 COMMENT 'carton qty of size s21',
  `s22` int(11) DEFAULT 0 COMMENT 'carton qty of size s22',
  `s23` int(11) DEFAULT 0 COMMENT 'carton \n\nqty of size s23',
  `s24` int(11) DEFAULT 0 COMMENT 'carton qty of size s24',
  `s25` int(11) DEFAULT 0 COMMENT 'carton qty of size s25',
  `s26` int(11) DEFAULT 0 COMMENT 'carton qty of size s26',
  `s27` int(11) DEFAULT 0 COMMENT 'carton qty of size s27',
  `s28` int(11) DEFAULT 0 COMMENT 'carton qty of size s28',
  `s29` int(11) DEFAULT 0 COMMENT 'carton qty of size s29',
  `s30` int(11) DEFAULT 0 COMMENT 'carton qty of size s30',
  `s31` int(11) DEFAULT 0 COMMENT 'carton qty of size s31',
  `s32` int(11) DEFAULT 0 COMMENT 'carton qty of size s32',
  `s33` int(11) DEFAULT 0 COMMENT 'carton qty of size s33',
  `s34` int(11) DEFAULT 0 COMMENT 'carton qty of size s34',
  `s35` int(11) DEFAULT 0 COMMENT 'carton qty of size \n\ns35',
  `s36` int(11) DEFAULT 0 COMMENT 'carton qty of size s36',
  `s37` int(11) DEFAULT 0 COMMENT 'carton qty of size s37',
  `s38` int(11) DEFAULT 0 COMMENT 'carton qty of size s38',
  `s39` int(11) DEFAULT 0 COMMENT 'carton qty of size s39',
  `s40` int(11) DEFAULT 0 COMMENT 'carton qty of \n\nsize s40',
  `s41` int(11) DEFAULT 0 COMMENT 'carton qty of size s41',
  `s42` int(11) DEFAULT 0 COMMENT 'carton qty of size s42',
  `s43` int(11) DEFAULT 0 COMMENT 'carton qty of size s43',
  `s44` int(11) DEFAULT 0 COMMENT 'carton qty of size s44',
  `s45` int(11) DEFAULT 0 COMMENT 'carton \n\nqty of size s45',
  `s46` int(11) DEFAULT 0 COMMENT 'carton qty of size s46',
  `s47` int(11) DEFAULT 0 COMMENT 'carton qty of size s47',
  `s48` int(11) DEFAULT 0 COMMENT 'carton qty of size s48',
  `s49` int(11) DEFAULT 0 COMMENT 'carton qty of size s49',
  `s50` int(11) DEFAULT 0 COMMENT 'carton qty of size s50',
  `remarks` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking \n\nID',
  `status` int(10) unsigned zerofill DEFAULT NULL COMMENT '0-active , 1- inactive',
  `track_qty` int(11) DEFAULT NULL COMMENT 'for M&S \n\nTracking Label Qty',
  `srp_qty` int(11) DEFAULT NULL,
  `user_schedule` varchar(45) NOT NULL COMMENT 'schedule number',
  `pack_methods` varchar(50) NOT NULL COMMENT 'Packing Methods',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Matrix \n\nto refer standard carton qty';

/*Table structure for table `carton_weight_chart` */

DROP TABLE IF EXISTS `bai_pro3`.`carton_weight_chart`;

CREATE TABLE `bai_pro3`.`carton_weight_chart` (
  `user_style` varchar(50) NOT NULL COMMENT 'User Defined Style',
  `buyer` varchar(50) NOT NULL,
  `buyer_identity` varchar(50) NOT NULL COMMENT 'L & O for VS Logo; P & K for VS Pink;  M for M&S; D for DIM',
  `style_description` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `carton_dimension` varchar(100) NOT NULL,
  `packing_method` varchar(50) NOT NULL COMMENT 'Packing \n\nMethod (Assortment Reference)',
  `xs` float NOT NULL DEFAULT 0,
  `s` float NOT NULL DEFAULT 0,
  `m` float NOT NULL DEFAULT 0,
  `l` float NOT NULL DEFAULT 0,
  `xl` float NOT NULL DEFAULT 0,
  `xxl` float NOT NULL DEFAULT 0,
  `xxxl` float NOT NULL DEFAULT 0,
  `s01` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s01',
  `s02` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s02',
  `s03` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s03',
  `s04` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s04',
  `s05` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s05',
  `s06` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s06',
  `s07` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s07',
  `s08` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s08',
  `s09` float NOT NULL DEFAULT 0 COMMENT 'carton \n\nweight of size s09',
  `s10` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s10',
  `s11` float NOT NULL DEFAULT 0 COMMENT 'carton weight \n\nof size s11',
  `s12` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s12',
  `s13` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size \n\ns13',
  `s14` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s14',
  `s15` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s15',
  `s16` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s16',
  `s17` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s17',
  `s18` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s18',
  `s19` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s19',
  `s20` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s20',
  `s21` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s21',
  `s22` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s22',
  `s23` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s23',
  `s24` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s24',
  `s25` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s25',
  `s26` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s26',
  `s27` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s27',
  `s28` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s28',
  `s29` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s29',
  `s30` float NOT NULL DEFAULT 0 COMMENT 'carton \n\nweight of size s30',
  `s31` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s31',
  `s32` float NOT NULL DEFAULT 0 COMMENT 'carton weight \n\nof size s32',
  `s33` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s33',
  `s34` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size \n\ns34',
  `s35` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s35',
  `s36` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s36',
  `s37` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s37',
  `s38` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s38',
  `s39` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s39',
  `s40` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s40',
  `s41` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s41',
  `s42` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s42',
  `s43` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s43',
  `s44` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s44',
  `s45` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s45',
  `s46` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s46',
  `s47` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s47',
  `s48` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s48',
  `s49` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s49',
  `s50` float NOT NULL DEFAULT 0 COMMENT 'carton weight of size s50',
  `remarks` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking ID',
  `status` int(10) NOT NULL COMMENT '0-active , 1- inactive',
  `track_qty` int(11) NOT NULL COMMENT 'for M&S Tracking Label Qty',
  `user_schedule` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `cat_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`cat_stat_log`;

CREATE TABLE `bai_pro3`.`cat_stat_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `order_tid` varchar(200) NOT NULL COMMENT 'Style-Schedule-Color',
  `order_tid2` varchar(200) NOT NULL COMMENT 'order_tid+Item Code',
  `date` date NOT NULL,
  `category` varchar(50) NOT NULL COMMENT 'User defined category',
  `purwidth` float NOT NULL COMMENT 'Purchase Width',
  `gmtway` varchar(100) NOT NULL COMMENT 'Garment Way',
  `catyy` double NOT NULL COMMENT 'Category YY  (Order YY)',
  `status` varchar(50) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `fab_des` varchar(200) NOT NULL COMMENT 'Fabric Description',
  `Waist_yy` double NOT NULL COMMENT 'Waist YY',
  `Leg_yy` double NOT NULL COMMENT 'Leg YY',
  `compo_no` varchar(200) NOT NULL COMMENT 'Fabric Code',
  `mo_status` varchar(200) NOT NULL COMMENT 'MO status',
  `strip_match` varchar(10) NOT NULL COMMENT 'Strip Matching ',
  `gusset_sep` varchar(10) NOT NULL COMMENT 'Gusset Separation',
  `patt_ver` varchar(10) NOT NULL COMMENT 'Pattern Version',
  `col_des` varchar(200) NOT NULL COMMENT 'Color Description',
  `clubbing` smallint(6) NOT NULL COMMENT 'To track color clubbing',
  `inserted_time` datetime NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `binding_consumption` double NOT NULL DEFAULT 0 COMMENT 'Binding Consumption',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `order_tid2` (`order_tid2`),
  UNIQUE KEY `tid` (`tid`,`order_tid`,`category`),
  KEY `clubbing` (`clubbing`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='To maintain order details (categories) to prepare Lay Plan';

/*Table structure for table `cat_stat_log_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`cat_stat_log_archive`;

CREATE TABLE `bai_pro3`.`cat_stat_log_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `order_tid` varchar(200) NOT NULL COMMENT 'Style-Schedule-Color',
  `order_tid2` varchar(200) NOT NULL COMMENT 'order_tid+Item Code',
  `date` date NOT NULL,
  `category` varchar(50) NOT NULL COMMENT 'User defined category',
  `purwidth` float NOT NULL COMMENT 'Purchase Width',
  `gmtway` varchar(100) NOT NULL COMMENT 'Garment Way',
  `catyy` double NOT NULL COMMENT 'Category YY  (Order YY)',
  `status` varchar(50) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `fab_des` varchar(200) NOT NULL COMMENT 'Fabric Description',
  `Waist_yy` double NOT NULL COMMENT 'Waist YY',
  `Leg_yy` double NOT NULL COMMENT 'Leg YY',
  `compo_no` varchar(200) NOT NULL COMMENT 'Fabric Code',
  `mo_status` varchar(200) NOT NULL COMMENT 'MO status',
  `strip_match` varchar(10) NOT NULL COMMENT 'Strip Matching ',
  `gusset_sep` varchar(10) NOT NULL COMMENT 'Gusset Separation',
  `patt_ver` varchar(10) NOT NULL COMMENT 'Pattern Version',
  `col_des` varchar(200) NOT NULL COMMENT 'Color Description',
  `clubbing` smallint(6) NOT NULL COMMENT 'To track color clubbing',
  `inserted_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `binding_consumption` double NOT NULL DEFAULT 0 COMMENT 'Binding Consumption',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `order_tid2` (`order_tid2`),
  KEY `tid` (`tid`,`order_tid`,`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To maintain order details (categories) to prepare Lay Plan';

/*Table structure for table `color_db` */

DROP TABLE IF EXISTS `bai_pro3`.`color_db`;

CREATE TABLE `bai_pro3`.`color_db` (
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`color`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `cuttable_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`cuttable_stat_log`;

CREATE TABLE `bai_pro3`.`cuttable_stat_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `order_tid` varchar(200) NOT NULL COMMENT 'Order TID Reference',
  `date` date NOT NULL COMMENT 'Date',
  `cat_id` int(11) NOT NULL COMMENT 'Category ID Reference',
  `cuttable_s_xs` int(11) NOT NULL COMMENT 'XS \n\nCuttable Qty',
  `cuttable_s_s` int(11) NOT NULL COMMENT 'S Cuttable Qty',
  `cuttable_s_m` int(11) NOT NULL COMMENT 'M Cuttable Qty',
  `cuttable_s_l` int(11) NOT NULL COMMENT 'L Cuttable Qty',
  `cuttable_s_xl` int(11) NOT NULL COMMENT 'XL Cuttable Qty',
  `cuttable_s_xxl` int(11) NOT NULL COMMENT 'XXL Cuttable Qty',
  `cuttable_s_xxxl` int(11) NOT NULL COMMENT 'XXXL Cuttable Qty',
  `lastup` datetime NOT NULL COMMENT 'Last \n\nupdated time',
  `remarks` varchar(500) NOT NULL COMMENT 'Remarks',
  `cuttable_percent` float NOT NULL COMMENT 'Cutting Excess Percentage',
  `cuttable_s_s01` int(11) NOT NULL COMMENT 's01 Cuttable Qty',
  `cuttable_s_s02` int(11) NOT NULL COMMENT 's02 Cuttable Qty',
  `cuttable_s_s03` int(11) NOT NULL COMMENT 's03 Cuttable Qty',
  `cuttable_s_s04` int(11) NOT NULL COMMENT 's04 Cuttable Qty',
  `cuttable_s_s05` int(11) NOT NULL COMMENT 's05 \n\nCuttable Qty',
  `cuttable_s_s06` int(11) NOT NULL COMMENT 's06 Cuttable Qty',
  `cuttable_s_s07` int(11) NOT NULL COMMENT 's07 Cuttable Qty',
  `cuttable_s_s08` int(11) NOT NULL COMMENT 's08 Cuttable Qty',
  `cuttable_s_s09` int(11) NOT NULL COMMENT 's09 Cuttable Qty',
  `cuttable_s_s10` int(11) NOT NULL COMMENT 's10 Cuttable Qty',
  `cuttable_s_s11` int(11) NOT NULL COMMENT 's11 Cuttable Qty',
  `cuttable_s_s12` int(11) NOT NULL COMMENT 's12 \n\nCuttable Qty',
  `cuttable_s_s13` int(11) NOT NULL COMMENT 's13 Cuttable Qty',
  `cuttable_s_s14` int(11) NOT NULL COMMENT 's14 Cuttable Qty',
  `cuttable_s_s15` int(11) NOT NULL COMMENT 's15 Cuttable Qty',
  `cuttable_s_s16` int(11) NOT NULL COMMENT 's16 Cuttable Qty',
  `cuttable_s_s17` int(11) NOT NULL COMMENT 's17 Cuttable Qty',
  `cuttable_s_s18` int(11) NOT NULL COMMENT 's18 Cuttable Qty',
  `cuttable_s_s19` int(11) NOT NULL COMMENT 's19 \n\nCuttable Qty',
  `cuttable_s_s20` int(11) NOT NULL COMMENT 's20 Cuttable Qty',
  `cuttable_s_s21` int(11) NOT NULL COMMENT 's21 Cuttable Qty',
  `cuttable_s_s22` int(11) NOT NULL COMMENT 's22 Cuttable Qty',
  `cuttable_s_s23` int(11) NOT NULL COMMENT 's23 Cuttable Qty',
  `cuttable_s_s24` int(11) NOT NULL COMMENT 's24 Cuttable Qty',
  `cuttable_s_s25` int(11) NOT NULL COMMENT 's25 Cuttable Qty',
  `cuttable_s_s26` int(11) NOT NULL COMMENT 's26 \n\nCuttable Qty',
  `cuttable_s_s27` int(11) NOT NULL COMMENT 's27 Cuttable Qty',
  `cuttable_s_s28` int(11) NOT NULL COMMENT 's28 Cuttable Qty',
  `cuttable_s_s29` int(11) NOT NULL COMMENT 's29 Cuttable Qty',
  `cuttable_s_s30` int(11) NOT NULL COMMENT 's30 Cuttable Qty',
  `cuttable_s_s31` int(11) NOT NULL COMMENT 's31 Cuttable Qty',
  `cuttable_s_s32` int(11) NOT NULL COMMENT 's32 Cuttable Qty',
  `cuttable_s_s33` int(11) NOT NULL COMMENT 's33 \n\nCuttable Qty',
  `cuttable_s_s34` int(11) NOT NULL COMMENT 's34 Cuttable Qty',
  `cuttable_s_s35` int(11) NOT NULL COMMENT 's35 Cuttable Qty',
  `cuttable_s_s36` int(11) NOT NULL COMMENT 's36 Cuttable Qty',
  `cuttable_s_s37` int(11) NOT NULL COMMENT 's37 Cuttable Qty',
  `cuttable_s_s38` int(11) NOT NULL COMMENT 's38 Cuttable Qty',
  `cuttable_s_s39` int(11) NOT NULL COMMENT 's39 Cuttable Qty',
  `cuttable_s_s40` int(11) NOT NULL COMMENT 's40 \n\nCuttable Qty',
  `cuttable_s_s41` int(11) NOT NULL COMMENT 's41 Cuttable Qty',
  `cuttable_s_s42` int(11) NOT NULL COMMENT 's42 Cuttable Qty',
  `cuttable_s_s43` int(11) NOT NULL COMMENT 's43 Cuttable Qty',
  `cuttable_s_s44` int(11) NOT NULL COMMENT 's44 Cuttable Qty',
  `cuttable_s_s45` int(11) NOT NULL COMMENT 's45 Cuttable Qty',
  `cuttable_s_s46` int(11) NOT NULL COMMENT 's46 Cuttable Qty',
  `cuttable_s_s47` int(11) NOT NULL COMMENT 's47 \n\nCuttable Qty',
  `cuttable_s_s48` int(11) NOT NULL COMMENT 's48 Cuttable Qty',
  `cuttable_s_s49` int(11) NOT NULL COMMENT 's49 Cuttable Qty',
  `cuttable_s_s50` int(11) NOT NULL COMMENT 's50 Cuttable Qty',
  `cuttable_wastage` varchar(11) NOT NULL COMMENT 'cuttable wastage',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `order_tid` (`order_tid`,`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='To track actual cuttable % on order quantities';

/*Table structure for table `cuttable_stat_log_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`cuttable_stat_log_archive`;

CREATE TABLE `bai_pro3`.`cuttable_stat_log_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `order_tid` varchar(200) NOT NULL COMMENT 'Order TID \n\nReference',
  `date` date NOT NULL,
  `cat_id` int(11) NOT NULL COMMENT 'Category ID Reference',
  `cuttable_s_xs` int(11) NOT NULL,
  `cuttable_s_s` int(11) NOT NULL,
  `cuttable_s_m` int(11) NOT NULL,
  `cuttable_s_l` int(11) NOT NULL,
  `cuttable_s_xl` int(11) NOT NULL,
  `cuttable_s_xxl` int(11) NOT NULL,
  `cuttable_s_xxxl` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `cuttable_percent` float NOT NULL,
  `cuttable_s_s01` int(11) NOT NULL COMMENT 's01 Cuttable Qty',
  `cuttable_s_s02` int(11) NOT NULL COMMENT 's02 Cuttable Qty',
  `cuttable_s_s03` int(11) NOT NULL COMMENT 's03 Cuttable Qty',
  `cuttable_s_s04` int(11) NOT NULL COMMENT 's04 Cuttable Qty',
  `cuttable_s_s05` int(11) NOT NULL COMMENT 's05 \n\nCuttable Qty',
  `cuttable_s_s06` int(11) NOT NULL COMMENT 's06 Cuttable Qty',
  `cuttable_s_s07` int(11) NOT NULL COMMENT 's07 Cuttable Qty',
  `cuttable_s_s08` int(11) NOT NULL COMMENT 's08 Cuttable Qty',
  `cuttable_s_s09` int(11) NOT NULL COMMENT 's09 Cuttable Qty',
  `cuttable_s_s10` int(11) NOT NULL COMMENT 's10 Cuttable Qty',
  `cuttable_s_s11` int(11) NOT NULL COMMENT 's11 Cuttable Qty',
  `cuttable_s_s12` int(11) NOT NULL COMMENT 's12 \n\nCuttable Qty',
  `cuttable_s_s13` int(11) NOT NULL COMMENT 's13 Cuttable Qty',
  `cuttable_s_s14` int(11) NOT NULL COMMENT 's14 Cuttable Qty',
  `cuttable_s_s15` int(11) NOT NULL COMMENT 's15 Cuttable Qty',
  `cuttable_s_s16` int(11) NOT NULL COMMENT 's16 Cuttable Qty',
  `cuttable_s_s17` int(11) NOT NULL COMMENT 's17 Cuttable Qty',
  `cuttable_s_s18` int(11) NOT NULL COMMENT 's18 Cuttable Qty',
  `cuttable_s_s19` int(11) NOT NULL COMMENT 's19 \n\nCuttable Qty',
  `cuttable_s_s20` int(11) NOT NULL COMMENT 's20 Cuttable Qty',
  `cuttable_s_s21` int(11) NOT NULL COMMENT 's21 Cuttable Qty',
  `cuttable_s_s22` int(11) NOT NULL COMMENT 's22 Cuttable Qty',
  `cuttable_s_s23` int(11) NOT NULL COMMENT 's23 Cuttable Qty',
  `cuttable_s_s24` int(11) NOT NULL COMMENT 's24 Cuttable Qty',
  `cuttable_s_s25` int(11) NOT NULL COMMENT 's25 Cuttable Qty',
  `cuttable_s_s26` int(11) NOT NULL COMMENT 's26 \n\nCuttable Qty',
  `cuttable_s_s27` int(11) NOT NULL COMMENT 's27 Cuttable Qty',
  `cuttable_s_s28` int(11) NOT NULL COMMENT 's28 Cuttable Qty',
  `cuttable_s_s29` int(11) NOT NULL COMMENT 's29 Cuttable Qty',
  `cuttable_s_s30` int(11) NOT NULL COMMENT 's30 Cuttable Qty',
  `cuttable_s_s31` int(11) NOT NULL COMMENT 's31 Cuttable Qty',
  `cuttable_s_s32` int(11) NOT NULL COMMENT 's32 Cuttable Qty',
  `cuttable_s_s33` int(11) NOT NULL COMMENT 's33 \n\nCuttable Qty',
  `cuttable_s_s34` int(11) NOT NULL COMMENT 's34 Cuttable Qty',
  `cuttable_s_s35` int(11) NOT NULL COMMENT 's35 Cuttable Qty',
  `cuttable_s_s36` int(11) NOT NULL COMMENT 's36 Cuttable Qty',
  `cuttable_s_s37` int(11) NOT NULL COMMENT 's37 Cuttable Qty',
  `cuttable_s_s38` int(11) NOT NULL COMMENT 's38 Cuttable Qty',
  `cuttable_s_s39` int(11) NOT NULL COMMENT 's39 Cuttable Qty',
  `cuttable_s_s40` int(11) NOT NULL COMMENT 's40 \n\nCuttable Qty',
  `cuttable_s_s41` int(11) NOT NULL COMMENT 's41 Cuttable Qty',
  `cuttable_s_s42` int(11) NOT NULL COMMENT 's42 Cuttable Qty',
  `cuttable_s_s43` int(11) NOT NULL COMMENT 's43 Cuttable Qty',
  `cuttable_s_s44` int(11) NOT NULL COMMENT 's44 Cuttable Qty',
  `cuttable_s_s45` int(11) NOT NULL COMMENT 's45 Cuttable Qty',
  `cuttable_s_s46` int(11) NOT NULL COMMENT 's46 Cuttable Qty',
  `cuttable_s_s47` int(11) NOT NULL COMMENT 's47 \n\nCuttable Qty',
  `cuttable_s_s48` int(11) NOT NULL COMMENT 's48 Cuttable Qty',
  `cuttable_s_s49` int(11) NOT NULL COMMENT 's49 Cuttable Qty',
  `cuttable_s_s50` int(11) NOT NULL COMMENT 's50 Cuttable Qty',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track actual cuttable % on order quantities';

/*Table structure for table `cuttable_stat_log_delete` */

DROP TABLE IF EXISTS `bai_pro3`.`cuttable_stat_log_delete`;

CREATE TABLE `bai_pro3`.`cuttable_stat_log_delete` (
  `tid` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `cat_id` int(11) NOT NULL,
  `cuttable_s_xs` int(11) NOT NULL,
  `cuttable_s_s` int(11) NOT NULL,
  `cuttable_s_m` int(11) NOT NULL,
  `cuttable_s_l` int(11) NOT NULL,
  `cuttable_s_xl` int(11) NOT NULL,
  `cuttable_s_xxl` int(11) NOT NULL,
  `cuttable_s_xxxl` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `cuttable_percent` float NOT NULL,
  `cuttable_s_s06` int(11) NOT NULL,
  `cuttable_s_s08` int(11) NOT NULL,
  `cuttable_s_s10` int(11) NOT NULL,
  `cuttable_s_s12` int(11) NOT NULL,
  `cuttable_s_s14` int(11) NOT NULL,
  `cuttable_s_s16` int(11) NOT NULL,
  `cuttable_s_s18` int(11) NOT NULL,
  `cuttable_s_s20` int(11) NOT NULL,
  `cuttable_s_s22` int(11) NOT NULL,
  `cuttable_s_s24` int(11) NOT NULL,
  `cuttable_s_s26` int(11) NOT NULL,
  `cuttable_s_s28` int(11) NOT NULL,
  `cuttable_s_s30` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `d_time` datetime DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cutting_plan_modules` */

DROP TABLE IF EXISTS `bai_pro3`.`cutting_plan_modules`;

CREATE TABLE `bai_pro3`.`cutting_plan_modules` (
  `module_id` varchar(24) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `power_user` varchar(90) DEFAULT NULL,
  `lastup` timestamp NULL DEFAULT NULL,
  `buyer_div` varchar(45) DEFAULT NULL,
  `ims_priority_boxes` double DEFAULT NULL,
  KEY `module_section` (`module_id`,`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `db_update_log` */

DROP TABLE IF EXISTS `bai_pro3`.`db_update_log`;

CREATE TABLE `bai_pro3`.`db_update_log` (
  `date` date NOT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `operation` varchar(100) NOT NULL,
  `lupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track schedule updation status';

/*Table structure for table `delivery_schedule_delete_log` */

DROP TABLE IF EXISTS `bai_pro3`.`delivery_schedule_delete_log`;

CREATE TABLE `bai_pro3`.`delivery_schedule_delete_log` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'delete transaction ID',
  `schedule` varchar(20) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `date_time` datetime NOT NULL,
  `username` varchar(100) NOT NULL,
  `deleted_user` varchar(20) NOT NULL,
  `del_time` datetime NOT NULL,
  UNIQUE KEY `d_id` (`d_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `disp_db` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_db`;

CREATE TABLE `bai_pro3`.`disp_db` (
  `create_date` date DEFAULT NULL,
  `disp_note_no` int(11) NOT NULL AUTO_INCREMENT,
  `party` int(11) DEFAULT NULL,
  `vehicle_no` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `exit_date` datetime DEFAULT NULL COMMENT 'Actual Exit Time',
  `mode` int(11) DEFAULT NULL COMMENT 'Shipment Mode 1-Air, 2-Sea, 3-Road, 4-Courier',
  `seal_no` varchar(30) DEFAULT NULL COMMENT 'Vehicle Seal Details',
  `prepared_by` varchar(30) DEFAULT NULL,
  `approved_by` varchar(30) DEFAULT NULL,
  `dispatched_by` varchar(30) DEFAULT NULL,
  `prepared_time` datetime DEFAULT NULL,
  `approved_time` datetime DEFAULT NULL,
  PRIMARY KEY (`disp_note_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track dispatch details';

/*Table structure for table `disp_mix_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_mix_temp`;

CREATE TABLE `bai_pro3`.`disp_mix_temp` (
  `order_del_no` varchar(100) NOT NULL,
  `order_style_no` varchar(100) NOT NULL,
  `order_col_des` varchar(250) NOT NULL,
  `total` int(11) NOT NULL,
  `scanned` int(11) NOT NULL,
  `unscanned` int(11) NOT NULL,
  `app` int(11) NOT NULL,
  `fail` int(11) NOT NULL,
  `audit_pending` int(11) NOT NULL,
  `fca_app` int(11) NOT NULL,
  `fca_fail` int(11) NOT NULL,
  `fca_audit_pending` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `doc_loc_mapping` */

DROP TABLE IF EXISTS `bai_pro3`.`doc_loc_mapping`;

CREATE TABLE `bai_pro3`.`doc_loc_mapping` (
  `doc_loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_id` int(11) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `pcsqty` int(11) DEFAULT NULL,
  `bundlesqty` int(11) DEFAULT NULL,
  `pliesqty` int(11) DEFAULT NULL,
  PRIMARY KEY (`doc_loc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `doc_shade_info` */

DROP TABLE IF EXISTS `bai_pro3`.`doc_shade_info`;

CREATE TABLE `bai_pro3`.`doc_shade_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shade` varchar(255) DEFAULT NULL,
  `plies` int(11) DEFAULT NULL,
  `doc_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_no` (`doc_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `bai_pro3`.`employees`;

CREATE TABLE `bai_pro3`.`employees` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hire_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `fabric_priorities` */

DROP TABLE IF EXISTS `bai_pro3`.`fabric_priorities`;

CREATE TABLE `bai_pro3`.`fabric_priorities` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(50) NOT NULL,
  `req_time` datetime NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `log_user` varchar(50) NOT NULL,
  `section` int(11) NOT NULL DEFAULT 0,
  `module` varchar(8) NOT NULL DEFAULT '0',
  `issued_time` datetime NOT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` int(11) NOT NULL DEFAULT 0,
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`),
  KEY `doc_ref` (`doc_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `fabric_priorities_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`fabric_priorities_archive`;

CREATE TABLE `bai_pro3`.`fabric_priorities_archive` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(50) NOT NULL,
  `req_time` datetime NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `log_user` varchar(50) NOT NULL,
  `section` int(11) NOT NULL DEFAULT 0,
  `module` varchar(10) NOT NULL DEFAULT '0',
  `issued_time` datetime NOT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_log_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` int(11) NOT NULL DEFAULT 0,
  `tran_id` int(11) NOT NULL DEFAULT 0,
  KEY `doc_ref` (`doc_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `fabric_priorities_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`fabric_priorities_backup`;

CREATE TABLE `bai_pro3`.`fabric_priorities_backup` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(50) NOT NULL,
  `req_time` datetime NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `log_user` varchar(50) NOT NULL,
  `section` int(11) NOT NULL DEFAULT 0,
  `module` varchar(8) NOT NULL DEFAULT '0',
  `issued_time` datetime NOT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` int(11) NOT NULL DEFAULT 0,
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `fabric_priorities_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`fabric_priorities_temp`;

CREATE TABLE `bai_pro3`.`fabric_priorities_temp` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(150) DEFAULT NULL,
  `req_time` datetime DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `log_user` varchar(150) DEFAULT NULL,
  `section` double DEFAULT NULL,
  `module` double DEFAULT NULL,
  `issued_time` datetime DEFAULT NULL,
  `trims_req_time` datetime DEFAULT NULL,
  `trims_issued_time` datetime DEFAULT NULL,
  `trims_status` int(11) DEFAULT NULL,
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `fca_audit_fail_db` */

DROP TABLE IF EXISTS `bai_pro3`.`fca_audit_fail_db`;

CREATE TABLE `bai_pro3`.`fca_audit_fail_db` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(50) NOT NULL,
  `schedule` int(11) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `pcs` int(11) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(100) DEFAULT NULL,
  `tran_type` int(11) DEFAULT NULL COMMENT 'Transaction Type',
  `fail_reason` varchar(50) NOT NULL COMMENT 'Reason for Fail',
  `done_by` varchar(50) NOT NULL,
  `color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule` (`schedule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track FCA fail details';

/*Table structure for table `fca_audit_fail_db_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`fca_audit_fail_db_archive`;

CREATE TABLE `bai_pro3`.`fca_audit_fail_db_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(50) NOT NULL,
  `schedule` int(11) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `pcs` int(11) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(100) DEFAULT NULL,
  `tran_type` int(11) DEFAULT NULL COMMENT 'Transaction Type',
  `fail_reason` varchar(50) NOT NULL COMMENT 'Reason for Fail',
  `done_by` varchar(50) NOT NULL,
  `color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track FCA fail details';

/*Table structure for table `fg_quality_returns` */

DROP TABLE IF EXISTS `bai_pro3`.`fg_quality_returns`;

CREATE TABLE `bai_pro3`.`fg_quality_returns` (
  `ret_trna_tid` int(11) DEFAULT NULL,
  `carton_id` int(11) DEFAULT NULL,
  `carton_doc_ref` varchar(300) DEFAULT NULL,
  `ret_by` varchar(30) DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` varchar(100) DEFAULT NULL COMMENT 'Reason for return',
  `received_by` varchar(100) DEFAULT NULL COMMENT 'Receiving Party'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `history_store` */

DROP TABLE IF EXISTS `bai_pro3`.`history_store`;

CREATE TABLE `bai_pro3`.`history_store` (
  `timemark` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `table_name` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `pk_date_src` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `pk_date_dest` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `record_state` int(11) NOT NULL,
  PRIMARY KEY (`table_name`(100),`pk_date_dest`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ims_exceptions` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_exceptions`;

CREATE TABLE `bai_pro3`.`ims_exceptions` (
  `ims_tid` bigint(20) NOT NULL COMMENT 'IMS TID',
  `ims_rand_track` varchar(200) NOT NULL COMMENT 'IMS Random Track',
  `req_date` datetime NOT NULL COMMENT 'Req Date',
  `req_remarks` varchar(300) NOT NULL COMMENT 'Reason for request',
  `alloted_rand_track` varchar(200) NOT NULL COMMENT 'Alloted Random Track',
  `module` varchar(8) NOT NULL COMMENT 'Module',
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To update request against pendings.';

/*Table structure for table `ims_log` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log`;

CREATE TABLE `bai_pro3`.`ims_log` (
  `ims_date` date NOT NULL COMMENT 'Input date',
  `ims_cid` int(11) NOT NULL COMMENT 'Category Reference',
  `ims_doc_no` int(11) NOT NULL COMMENT 'Docket Reference',
  `ims_mod_no` varchar(8) NOT NULL COMMENT 'Module Number',
  `ims_shift` varchar(10) NOT NULL COMMENT 'Shift',
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0 COMMENT 'Input Quantity',
  `ims_pro_qty` int(11) NOT NULL DEFAULT 0 COMMENT 'Output Quantity',
  `ims_status` varchar(10) NOT NULL COMMENT 'Status - DONE for completion',
  `bai_pro_ref` varchar(500) NOT NULL COMMENT 'Production log tracking references',
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Last updated time stamp',
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Reference ID',
  `rand_track` bigint(20) NOT NULL COMMENT 'Random track reference',
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  `input_job_rand_no_ref` varchar(50) NOT NULL COMMENT 'reference of input job random #',
  `input_job_no_ref` int(20) NOT NULL COMMENT 'reference of input job number',
  `destination` varchar(10) NOT NULL COMMENT 'destination',
  `pac_tid` int(11) NOT NULL COMMENT 'TID of the pac_stat_log table',
  `operation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `Unique key` (`ims_remarks`,`pac_tid`,`operation_id`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`),
  KEY `ims_schedule` (`ims_schedule`,`ims_color`,`ims_size`),
  KEY `input_job` (`input_job_rand_no_ref`,`input_job_no_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Table to track IMS';

/*Table structure for table `ims_log_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_backup`;

CREATE TABLE `bai_pro3`.`ims_log_backup` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` varchar(40) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  `input_job_rand_no_ref` varchar(255) NOT NULL,
  `input_job_no_ref` int(11) NOT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `pac_tid` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`),
  KEY `ims_doc_no` (`ims_doc_no`,`ims_size`),
  KEY `ims_schedule` (`ims_schedule`,`ims_color`,`ims_size`),
  KEY `unique_key` (`ims_remarks`,`pac_tid`,`operation_id`),
  KEY `bundle_number` (`bai_pro_ref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Clone of IMS_LOG to backup completed WIP entries.';

/*Table structure for table `ims_log_backup_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_backup_archive`;

CREATE TABLE `bai_pro3`.`ims_log_backup_archive` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(10) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  `input_job_rand_no_ref` varchar(30) NOT NULL,
  `input_job_no_ref` int(11) NOT NULL,
  `destination` varchar(20) DEFAULT NULL,
  `pac_tid` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `ims_schedule` (`ims_schedule`),
  KEY `input_job_no_ref` (`input_job_no_ref`),
  KEY `pac_tid` (`pac_tid`),
  KEY `ims_doc_no` (`ims_doc_no`),
  KEY `ims_size` (`ims_size`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ims_log_backup_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_backup_backup`;

CREATE TABLE `bai_pro3`.`ims_log_backup_backup` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(20) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`),
  KEY `ims_doc_no` (`ims_doc_no`,`ims_size`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Backup of IMS_LOG and IMS_LOG_Backup taking after shipment';

/*Table structure for table `ims_log_bc` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_bc`;

CREATE TABLE `bai_pro3`.`ims_log_bc` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(500) NOT NULL,
  `ims_schedule` varchar(500) NOT NULL,
  `ims_color` varchar(500) NOT NULL,
  `tid` int(11) NOT NULL,
  `tid_ref` int(11) NOT NULL AUTO_INCREMENT,
  `rand_track` int(11) NOT NULL,
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  PRIMARY KEY (`tid_ref`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Clone of IMS_log for deleted entries.';

/*Table structure for table `ims_log_copy` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_copy`;

CREATE TABLE `bai_pro3`.`ims_log_copy` (
  `ims_date` date NOT NULL COMMENT 'Input date',
  `ims_cid` int(11) NOT NULL COMMENT 'Category Reference',
  `ims_doc_no` int(11) NOT NULL COMMENT 'Docket Reference',
  `ims_mod_no` varchar(10) NOT NULL COMMENT 'Module Number',
  `ims_shift` varchar(10) NOT NULL COMMENT 'Shift',
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0 COMMENT 'Input Quantity',
  `ims_pro_qty` int(11) NOT NULL COMMENT 'Output Quantity',
  `ims_status` varchar(10) NOT NULL COMMENT 'Status - DONE for completion',
  `bai_pro_ref` varchar(500) NOT NULL COMMENT 'Production log tracking references',
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Last updated time stamp',
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Reference ID',
  `rand_track` bigint(20) NOT NULL COMMENT 'Random track reference',
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  `input_job_rand_no_ref` varchar(30) NOT NULL COMMENT 'reference of input job random #',
  `input_job_no_ref` int(11) NOT NULL COMMENT 'reference of input job number',
  `destination` varchar(20) NOT NULL COMMENT 'Destination',
  `pac_tid` int(11) NOT NULL COMMENT 'TID of the pac_stat_log table',
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`),
  KEY `ims_schedule` (`ims_schedule`,`ims_color`,`ims_size`),
  KEY `input_job_rand_no_ref` (`input_job_rand_no_ref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ims_log_ems` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_ems`;

CREATE TABLE `bai_pro3`.`ims_log_ems` (
  `ims_date` date NOT NULL COMMENT 'Input date',
  `ims_cid` int(11) NOT NULL COMMENT 'Category Reference',
  `ims_doc_no` int(11) NOT NULL COMMENT 'Docket Reference',
  `ims_mod_no` varchar(8) NOT NULL COMMENT 'Module Number',
  `ims_shift` varchar(10) NOT NULL COMMENT 'Shift',
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0 COMMENT 'Input Quantity',
  `ims_pro_qty` int(11) NOT NULL COMMENT 'Output Quantity',
  `ims_status` varchar(10) NOT NULL COMMENT 'Status - DONE for completion',
  `bai_pro_ref` varchar(500) NOT NULL COMMENT 'Production log tracking references',
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Last updated time stamp',
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Reference ID',
  `rand_track` bigint(20) NOT NULL COMMENT 'Random track reference',
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`),
  KEY `ims_schedule` (`ims_schedule`,`ims_color`,`ims_size`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table to track IMS';

/*Table structure for table `ims_log_packing` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_packing`;

CREATE TABLE `bai_pro3`.`ims_log_packing` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `ims_pro_qty_cumm` int(11) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`),
  KEY `ims_doc_no` (`ims_doc_no`,`ims_size`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Clone of IMS_log to pool required data for Carton Scanning';

/*Table structure for table `ims_log_packing_v3` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_packing_v3`;

CREATE TABLE `bai_pro3`.`ims_log_packing_v3` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `ims_pro_qty_cumm` int(11) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `ims_doc_no` (`ims_doc_no`,`ims_size`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Clone of IMS_log to pool required data for Carton Scanning';

/*Table structure for table `ims_log_packing_v3_ber_databasesvc` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_packing_v3_ber_databasesvc`;

CREATE TABLE `bai_pro3`.`ims_log_packing_v3_ber_databasesvc` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` decimal(32,0) DEFAULT NULL,
  `ims_pro_qty` decimal(32,0) DEFAULT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` varchar(40) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `ims_pro_qty_cumm` decimal(32,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ims_log_packing_v3_sfcsproject1` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_packing_v3_sfcsproject1`;

CREATE TABLE `bai_pro3`.`ims_log_packing_v3_sfcsproject1` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` decimal(32,0) DEFAULT NULL,
  `ims_pro_qty` decimal(32,0) DEFAULT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` varchar(40) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `ims_pro_qty_cumm` decimal(32,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ims_log_test` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_test`;

CREATE TABLE `bai_pro3`.`ims_log_test` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(10) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  `input_job_rand_no_ref` varchar(30) NOT NULL,
  `input_job_no_ref` int(11) NOT NULL,
  `destination` varchar(20) DEFAULT NULL,
  `pac_tid` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `ims_schedule` (`ims_schedule`),
  KEY `input_job_no_ref` (`input_job_no_ref`),
  KEY `pac_tid` (`pac_tid`),
  KEY `ims_doc_no` (`ims_doc_no`),
  KEY `ims_size` (`ims_size`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ims_log_test_back` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_test_back`;

CREATE TABLE `bai_pro3`.`ims_log_test_back` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(10) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT 0,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  `input_job_rand_no_ref` varchar(30) NOT NULL,
  `input_job_no_ref` int(11) NOT NULL,
  `destination` varchar(20) DEFAULT NULL,
  `pac_tid` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `ims_schedule` (`ims_schedule`),
  KEY `input_job_no_ref` (`input_job_no_ref`),
  KEY `pac_tid` (`pac_tid`),
  KEY `ims_doc_no` (`ims_doc_no`),
  KEY `ims_size` (`ims_size`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ims_sp_db` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_sp_db`;

CREATE TABLE `bai_pro3`.`ims_sp_db` (
  `ims_sp_tid` int(11) NOT NULL AUTO_INCREMENT,
  `req_user` varchar(30) DEFAULT NULL COMMENT 'Requested User (Computer Login)',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL COMMENT 'Reason for requesting new block',
  `module` varchar(8) DEFAULT NULL COMMENT 'Module Requested',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Status - 0-Req, 1-Utilized',
  PRIMARY KEY (`ims_sp_tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='This table to give special access to update input in IMS';

/*Table structure for table `inputjob_delete_log` */

DROP TABLE IF EXISTS `bai_pro3`.`inputjob_delete_log`;

CREATE TABLE `bai_pro3`.`inputjob_delete_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(150) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` varchar(765) DEFAULT NULL,
  `schedule` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `job_shipment_plan_man_up` */

DROP TABLE IF EXISTS `bai_pro3`.`job_shipment_plan_man_up`;

CREATE TABLE `bai_pro3`.`job_shipment_plan_man_up` (
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

/*Table structure for table `jobs_movement_track` */

DROP TABLE IF EXISTS `bai_pro3`.`jobs_movement_track`;

CREATE TABLE `bai_pro3`.`jobs_movement_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` int(11) DEFAULT NULL,
  `schedule_no` int(11) DEFAULT NULL,
  `input_job_no` varchar(20) DEFAULT NULL,
  `input_job_no_random` varchar(20) DEFAULT NULL,
  `from_module` varchar(20) DEFAULT NULL,
  `to_module` varchar(20) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `jobsheet_users` */

DROP TABLE IF EXISTS `bai_pro3`.`jobsheet_users`;

CREATE TABLE `bai_pro3`.`jobsheet_users` (
  `username` varchar(135) DEFAULT NULL,
  `password` varchar(135) DEFAULT NULL,
  `lines` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `kpi_db` */

DROP TABLE IF EXISTS `bai_pro3`.`kpi_db`;

CREATE TABLE `bai_pro3`.`kpi_db` (
  `tid` varchar(200) NOT NULL,
  `date` date DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  `shift` varchar(5) DEFAULT NULL,
  `abs` float NOT NULL COMMENT 'Absenteeism',
  `aud` float NOT NULL COMMENT 'Audit Fail %',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To maintain cutting KPI';

/*Table structure for table `kpi_ref` */

DROP TABLE IF EXISTS `bai_pro3`.`kpi_ref`;

CREATE TABLE `bai_pro3`.`kpi_ref` (
  `category` varchar(50) DEFAULT NULL,
  `fixed` double DEFAULT NULL,
  `point_r1` double DEFAULT NULL,
  `point_r2` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Reference for Cutting Team KPI Metrics';

/*Table structure for table `lay_plan_delete_track` */

DROP TABLE IF EXISTS `bai_pro3`.`lay_plan_delete_track`;

CREATE TABLE `bai_pro3`.`lay_plan_delete_track` (
  `tid` varchar(150) NOT NULL,
  `schedule_no` varchar(45) DEFAULT NULL,
  `col_desc` varchar(150) DEFAULT NULL,
  `reason` varchar(450) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `line_forecast` */

DROP TABLE IF EXISTS `bai_pro3`.`line_forecast`;

CREATE TABLE `bai_pro3`.`line_forecast` (
  `forcast_id` varchar(55) NOT NULL,
  `module` varchar(45) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  PRIMARY KEY (`forcast_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `line_reason` */

DROP TABLE IF EXISTS `bai_pro3`.`line_reason`;

CREATE TABLE `bai_pro3`.`line_reason` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `reason_name` varchar(500) DEFAULT NULL COMMENT 'Reason',
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `locations` */

DROP TABLE IF EXISTS `bai_pro3`.`locations`;

CREATE TABLE `bai_pro3`.`locations` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `filled_qty` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `catagory` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`loc_id`),
  UNIQUE KEY `location` (`loc_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `log_rm_ready_in_pool` */

DROP TABLE IF EXISTS `bai_pro3`.`log_rm_ready_in_pool`;

CREATE TABLE `bai_pro3`.`log_rm_ready_in_pool` (
  `d_id` double DEFAULT NULL,
  `doc_no` double DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `login_info` */

DROP TABLE IF EXISTS `bai_pro3`.`login_info`;

CREATE TABLE `bai_pro3`.`login_info` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `account_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `m3_bulk_or_lay_reported` */

DROP TABLE IF EXISTS `bai_pro3`.`m3_bulk_or_lay_reported`;

CREATE TABLE `bai_pro3`.`m3_bulk_or_lay_reported` (
  `order_tid` varchar(500) NOT NULL COMMENT 'To track M3 OR reported schedule',
  `log_user` varchar(50) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`order_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `m3_offline_dispatch` */

DROP TABLE IF EXISTS `bai_pro3`.`m3_offline_dispatch`;

CREATE TABLE `bai_pro3`.`m3_offline_dispatch` (
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `style` varchar(50) NOT NULL,
  `schedule` varchar(30) NOT NULL,
  `color` varchar(250) NOT NULL,
  `size` varchar(30) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `cut_qty` int(11) NOT NULL,
  `input_qty` int(11) NOT NULL,
  `out_qty` int(11) NOT NULL,
  `fg_qty` int(11) NOT NULL,
  `fca_qty` int(11) NOT NULL,
  `ship_qty` int(11) NOT NULL,
  `report_qty` int(11) NOT NULL,
  `log_user` varchar(30) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `exist_report_qty` int(11) NOT NULL COMMENT 'Already Reported Qty',
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `maker_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`maker_stat_log`;

CREATE TABLE `bai_pro3`.`maker_stat_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL COMMENT 'Category Reference',
  `cuttable_ref` int(11) NOT NULL COMMENT 'Cuttable % Reference',
  `allocate_ref` int(11) NOT NULL COMMENT 'Ratio Reference',
  `order_tid` varchar(200) NOT NULL,
  `mklength` float NOT NULL COMMENT 'Marker Length',
  `mkeff` float NOT NULL COMMENT 'Marker Efficiency',
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `mk_ver` varchar(50) NOT NULL COMMENT 'Marker Version',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `unique_key` (`cat_ref`,`cuttable_ref`,`allocate_ref`,`order_tid`),
  KEY `allocate_ref` (`allocate_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='To track marker details';

/*Table structure for table `maker_stat_log_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`maker_stat_log_archive`;

CREATE TABLE `bai_pro3`.`maker_stat_log_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL COMMENT 'Category Reference',
  `cuttable_ref` int(11) NOT NULL COMMENT 'Cuttable % Reference',
  `allocate_ref` int(11) NOT NULL COMMENT 'Ratio Reference',
  `order_tid` varchar(200) NOT NULL,
  `mklength` float NOT NULL COMMENT 'Marker Length',
  `mkeff` float NOT NULL COMMENT 'Marker Efficiency',
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `mk_ver` varchar(50) NOT NULL COMMENT 'Marker Version',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `maker_stat_log_delete` */

DROP TABLE IF EXISTS `bai_pro3`.`maker_stat_log_delete`;

CREATE TABLE `bai_pro3`.`maker_stat_log_delete` (
  `tid` int(11) NOT NULL,
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cuttable_ref` int(11) NOT NULL,
  `allocate_ref` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `mklength` float NOT NULL,
  `mkeff` float NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `mk_ver` varchar(50) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `d_time` datetime DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `marker_ref_matrix` */

DROP TABLE IF EXISTS `bai_pro3`.`marker_ref_matrix`;

CREATE TABLE `bai_pro3`.`marker_ref_matrix` (
  `marker_ref_tid` varchar(20) NOT NULL COMMENT 'marker_ref_id+width',
  `marker_width` varchar(5) NOT NULL,
  `marker_length` varchar(10) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `marker_ref` int(11) NOT NULL COMMENT 'marker_ref_id from table',
  `cat_ref` int(11) NOT NULL COMMENT 'Category_ref_id from table',
  `allocate_ref` int(11) NOT NULL,
  `style_code` varchar(10) NOT NULL,
  `buyer_code` varchar(3) NOT NULL,
  `pat_ver` varchar(15) NOT NULL,
  `xs` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `l` int(11) NOT NULL,
  `xl` int(11) NOT NULL,
  `xxl` int(11) NOT NULL,
  `xxxl` int(11) NOT NULL,
  `s01` int(11) NOT NULL COMMENT 'marker qty of size s01',
  `s02` int(11) NOT NULL COMMENT 'marker qty of size s02',
  `s03` int(11) NOT NULL COMMENT 'marker qty of size \n\ns03',
  `s04` int(11) NOT NULL COMMENT 'marker qty of size s04',
  `s05` int(11) NOT NULL COMMENT 'marker qty of size s05',
  `s06` int(11) NOT NULL COMMENT 'marker qty of size s06',
  `s07` int(11) NOT NULL COMMENT 'marker qty of size s07',
  `s08` int(11) NOT NULL COMMENT 'marker qty of size s08',
  `s09` int(11) NOT NULL COMMENT 'marker qty of size s09',
  `s10` int(11) NOT NULL COMMENT 'marker qty of size s10',
  `s11` int(11) NOT NULL COMMENT 'marker qty of size s11',
  `s12` int(11) NOT NULL COMMENT 'marker qty of size s12',
  `s13` int(11) NOT NULL COMMENT 'marker qty of size s13',
  `s14` int(11) NOT NULL COMMENT 'marker qty of size s14',
  `s15` int(11) NOT NULL COMMENT 'marker qty of size s15',
  `s16` int(11) NOT NULL COMMENT 'marker \n\nqty of size s16',
  `s17` int(11) NOT NULL COMMENT 'marker qty of size s17',
  `s18` int(11) NOT NULL COMMENT 'marker qty of size s18',
  `s19` int(11) NOT NULL COMMENT 'marker qty of size s19',
  `s20` int(11) NOT NULL COMMENT 'marker qty of size s20',
  `s21` int(11) NOT NULL COMMENT 'marker qty of size \n\ns21',
  `s22` int(11) NOT NULL COMMENT 'marker qty of size s22',
  `s23` int(11) NOT NULL COMMENT 'marker qty of size s23',
  `s24` int(11) NOT NULL COMMENT 'marker qty of size s24',
  `s25` int(11) NOT NULL COMMENT 'marker qty of size s25',
  `s26` int(11) NOT NULL COMMENT 'marker qty of size s26',
  `s27` int(11) NOT NULL COMMENT 'marker qty of size s27',
  `s28` int(11) NOT NULL COMMENT 'marker qty of size s28',
  `s29` int(11) NOT NULL COMMENT 'marker qty of size s29',
  `s30` int(11) NOT NULL COMMENT 'marker qty of size s30',
  `s31` int(11) NOT NULL COMMENT 'marker qty of size s31',
  `s32` int(11) NOT NULL COMMENT 'marker qty of size s32',
  `s33` int(11) NOT NULL COMMENT 'marker qty of size s33',
  `s34` int(11) NOT NULL COMMENT 'marker \n\nqty of size s34',
  `s35` int(11) NOT NULL COMMENT 'marker qty of size s35',
  `s36` int(11) NOT NULL COMMENT 'marker qty of size s36',
  `s37` int(11) NOT NULL COMMENT 'marker qty of size s37',
  `s38` int(11) NOT NULL COMMENT 'marker qty of size s38',
  `s39` int(11) NOT NULL COMMENT 'marker qty of size \n\ns39',
  `s40` int(11) NOT NULL COMMENT 'marker qty of size s40',
  `s41` int(11) NOT NULL COMMENT 'marker qty of size s41',
  `s42` int(11) NOT NULL COMMENT 'marker qty of size s42',
  `s43` int(11) NOT NULL COMMENT 'marker qty of size s43',
  `s44` int(11) NOT NULL COMMENT 'marker qty of size s44',
  `s45` int(11) NOT NULL COMMENT 'marker qty of size s45',
  `s46` int(11) NOT NULL COMMENT 'marker qty of size s46',
  `s47` int(11) NOT NULL COMMENT 'marker qty of size s47',
  `s48` int(11) NOT NULL COMMENT 'marker qty of size s48',
  `s49` int(11) NOT NULL COMMENT 'marker qty of size s49',
  `s50` int(11) NOT NULL COMMENT 'marker qty of size s50',
  `title_size_s01` varchar(20) DEFAULT NULL COMMENT ' SIZE s01 Title FIELD',
  `title_size_s02` varchar(20) DEFAULT NULL COMMENT ' SIZE s02 Title FIELD',
  `title_size_s03` varchar(20) DEFAULT NULL COMMENT ' SIZE s03 Title FIELD',
  `title_size_s04` varchar(20) DEFAULT NULL COMMENT ' SIZE s04 Title FIELD',
  `title_size_s05` varchar(20) DEFAULT NULL COMMENT ' SIZE s05 Title \n\nFIELD',
  `title_size_s06` varchar(20) DEFAULT NULL COMMENT ' SIZE s06 Title FIELD',
  `title_size_s07` varchar(20) DEFAULT NULL COMMENT ' SIZE s07 \n\nTitle FIELD',
  `title_size_s08` varchar(20) DEFAULT NULL COMMENT ' SIZE s08 Title FIELD',
  `title_size_s09` varchar(20) DEFAULT NULL COMMENT ' SIZE \n\ns09 Title FIELD',
  `title_size_s10` varchar(20) DEFAULT NULL COMMENT ' SIZE s10 Title FIELD',
  `title_size_s11` varchar(20) DEFAULT NULL COMMENT ' \n\nSIZE s11 Title FIELD',
  `title_size_s12` varchar(20) DEFAULT NULL COMMENT ' SIZE s12 Title FIELD',
  `title_size_s13` varchar(20) DEFAULT NULL COMMENT ' SIZE s13 Title FIELD',
  `title_size_s14` varchar(20) DEFAULT NULL COMMENT ' SIZE s14 Title FIELD',
  `title_size_s15` varchar(20) DEFAULT NULL COMMENT ' SIZE s15 Title FIELD',
  `title_size_s16` varchar(20) DEFAULT NULL COMMENT ' SIZE s16 Title FIELD',
  `title_size_s17` varchar(20) DEFAULT NULL COMMENT ' SIZE s17 Title FIELD',
  `title_size_s18` varchar(20) DEFAULT NULL COMMENT ' SIZE s18 Title FIELD',
  `title_size_s19` varchar(20) DEFAULT NULL COMMENT ' SIZE s19 Title FIELD',
  `title_size_s20` varchar(20) DEFAULT NULL COMMENT ' SIZE s20 Title FIELD',
  `title_size_s21` varchar(20) DEFAULT NULL COMMENT ' SIZE s21 Title FIELD',
  `title_size_s22` varchar(20) DEFAULT NULL COMMENT ' SIZE s22 Title FIELD',
  `title_size_s23` varchar(20) DEFAULT NULL COMMENT ' SIZE s23 Title FIELD',
  `title_size_s24` varchar(20) DEFAULT NULL COMMENT ' SIZE s24 Title FIELD',
  `title_size_s25` varchar(20) DEFAULT NULL COMMENT ' SIZE s25 Title FIELD',
  `title_size_s26` varchar(20) DEFAULT NULL COMMENT ' SIZE s26 Title \n\nFIELD',
  `title_size_s27` varchar(20) DEFAULT NULL COMMENT ' SIZE s27 Title FIELD',
  `title_size_s28` varchar(20) DEFAULT NULL COMMENT ' SIZE s28 \n\nTitle FIELD',
  `title_size_s29` varchar(20) DEFAULT NULL COMMENT ' SIZE s29 Title FIELD',
  `title_size_s30` varchar(20) DEFAULT NULL COMMENT ' SIZE \n\ns30 Title FIELD',
  `title_size_s31` varchar(20) DEFAULT NULL COMMENT ' SIZE s31 Title FIELD',
  `title_size_s32` varchar(20) DEFAULT NULL COMMENT ' \n\nSIZE s32 Title FIELD',
  `title_size_s33` varchar(20) DEFAULT NULL COMMENT ' SIZE s33 Title FIELD',
  `title_size_s34` varchar(20) DEFAULT NULL COMMENT ' SIZE s34 Title FIELD',
  `title_size_s35` varchar(20) DEFAULT NULL COMMENT ' SIZE s35 Title FIELD',
  `title_size_s36` varchar(20) DEFAULT NULL COMMENT ' SIZE s36 Title FIELD',
  `title_size_s37` varchar(20) DEFAULT NULL COMMENT ' SIZE s37 Title FIELD',
  `title_size_s38` varchar(20) DEFAULT NULL COMMENT ' SIZE s38 Title FIELD',
  `title_size_s39` varchar(20) DEFAULT NULL COMMENT ' SIZE s39 Title FIELD',
  `title_size_s40` varchar(20) DEFAULT NULL COMMENT ' SIZE s40 Title FIELD',
  `title_size_s41` varchar(20) DEFAULT NULL COMMENT ' SIZE s41 Title FIELD',
  `title_size_s42` varchar(20) DEFAULT NULL COMMENT ' SIZE s42 Title FIELD',
  `title_size_s43` varchar(20) DEFAULT NULL COMMENT ' SIZE s43 Title FIELD',
  `title_size_s44` varchar(20) DEFAULT NULL COMMENT ' SIZE s44 Title FIELD',
  `title_size_s45` varchar(20) DEFAULT NULL COMMENT ' SIZE s45 Title FIELD',
  `title_size_s46` varchar(20) DEFAULT NULL COMMENT ' SIZE s46 Title FIELD',
  `title_size_s47` varchar(20) DEFAULT NULL COMMENT ' SIZE s47 Title \n\nFIELD',
  `title_size_s48` varchar(20) DEFAULT NULL COMMENT ' SIZE s48 Title FIELD',
  `title_size_s49` varchar(20) DEFAULT NULL COMMENT ' SIZE s49 \n\nTitle FIELD',
  `title_size_s50` varchar(20) DEFAULT NULL COMMENT ' SIZE s50 Title FIELD',
  `title_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`marker_ref_tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `marker_ref_matrix_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`marker_ref_matrix_archive`;

CREATE TABLE `bai_pro3`.`marker_ref_matrix_archive` (
  `marker_ref_tid` varchar(20) NOT NULL COMMENT 'marker_ref_id+width',
  `marker_width` varchar(5) NOT NULL,
  `marker_length` varchar(10) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `marker_ref` int(11) NOT NULL COMMENT 'marker_ref_id from table',
  `cat_ref` int(11) NOT NULL COMMENT 'Category_ref_id from table',
  `allocate_ref` int(11) NOT NULL,
  `style_code` varchar(10) NOT NULL,
  `buyer_code` varchar(3) NOT NULL,
  `pat_ver` varchar(15) NOT NULL,
  `xs` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `l` int(11) NOT NULL,
  `xl` int(11) NOT NULL,
  `xxl` int(11) NOT NULL,
  `xxxl` int(11) NOT NULL,
  `s01` int(11) NOT NULL COMMENT 'marker qty of size s01',
  `s02` int(11) NOT NULL COMMENT 'marker qty of size s02',
  `s03` int(11) NOT NULL COMMENT 'marker qty of \n\nsize s03',
  `s04` int(11) NOT NULL COMMENT 'marker qty of size s04',
  `s05` int(11) NOT NULL COMMENT 'marker qty of size s05',
  `s06` int(11) NOT NULL COMMENT 'marker qty of size s06',
  `s07` int(11) NOT NULL COMMENT 'marker qty of size s07',
  `s08` int(11) NOT NULL COMMENT 'marker qty of size s08',
  `s09` int(11) NOT NULL COMMENT 'marker qty of size s09',
  `s10` int(11) NOT NULL COMMENT 'marker qty of size s10',
  `s11` int(11) NOT NULL COMMENT 'marker qty of size s11',
  `s12` int(11) NOT NULL COMMENT 'marker qty of size s12',
  `s13` int(11) NOT NULL COMMENT 'marker qty of size s13',
  `s14` int(11) NOT NULL COMMENT 'marker qty of size s14',
  `s15` int(11) NOT NULL COMMENT 'marker qty of size s15',
  `s16` int(11) NOT NULL COMMENT 'marker \n\nqty of size s16',
  `s17` int(11) NOT NULL COMMENT 'marker qty of size s17',
  `s18` int(11) NOT NULL COMMENT 'marker qty of size s18',
  `s19` int(11) NOT NULL COMMENT 'marker qty of size s19',
  `s20` int(11) NOT NULL COMMENT 'marker qty of size s20',
  `s21` int(11) NOT NULL COMMENT 'marker qty of size \n\ns21',
  `s22` int(11) NOT NULL COMMENT 'marker qty of size s22',
  `s23` int(11) NOT NULL COMMENT 'marker qty of size s23',
  `s24` int(11) NOT NULL COMMENT 'marker qty of size s24',
  `s25` int(11) NOT NULL COMMENT 'marker qty of size s25',
  `s26` int(11) NOT NULL COMMENT 'marker qty of size s26',
  `s27` int(11) NOT NULL COMMENT 'marker qty of size s27',
  `s28` int(11) NOT NULL COMMENT 'marker qty of size s28',
  `s29` int(11) NOT NULL COMMENT 'marker qty of size s29',
  `s30` int(11) NOT NULL COMMENT 'marker qty of size s30',
  `s31` int(11) NOT NULL COMMENT 'marker qty of size s31',
  `s32` int(11) NOT NULL COMMENT 'marker qty of size s32',
  `s33` int(11) NOT NULL COMMENT 'marker qty of size s33',
  `s34` int(11) NOT NULL COMMENT 'marker \n\nqty of size s34',
  `s35` int(11) NOT NULL COMMENT 'marker qty of size s35',
  `s36` int(11) NOT NULL COMMENT 'marker qty of size s36',
  `s37` int(11) NOT NULL COMMENT 'marker qty of size s37',
  `s38` int(11) NOT NULL COMMENT 'marker qty of size s38',
  `s39` int(11) NOT NULL COMMENT 'marker qty of size \n\ns39',
  `s40` int(11) NOT NULL COMMENT 'marker qty of size s40',
  `s41` int(11) NOT NULL COMMENT 'marker qty of size s41',
  `s42` int(11) NOT NULL COMMENT 'marker qty of size s42',
  `s43` int(11) NOT NULL COMMENT 'marker qty of size s43',
  `s44` int(11) NOT NULL COMMENT 'marker qty of size s44',
  `s45` int(11) NOT NULL COMMENT 'marker qty of size s45',
  `s46` int(11) NOT NULL COMMENT 'marker qty of size s46',
  `s47` int(11) NOT NULL COMMENT 'marker qty of size s47',
  `s48` int(11) NOT NULL COMMENT 'marker qty of size s48',
  `s49` int(11) NOT NULL COMMENT 'marker qty of size s49',
  `s50` int(11) NOT NULL COMMENT 'marker qty of size s50',
  `title_size_s01` varchar(20) DEFAULT NULL COMMENT ' SIZE s01 Title FIELD',
  `title_size_s02` varchar(20) DEFAULT NULL COMMENT ' SIZE s02 Title FIELD',
  `title_size_s03` varchar(20) DEFAULT NULL COMMENT ' SIZE s03 Title FIELD',
  `title_size_s04` varchar(20) DEFAULT NULL COMMENT ' SIZE s04 Title FIELD',
  `title_size_s05` varchar(20) DEFAULT NULL COMMENT ' SIZE s05 Title \n\nFIELD',
  `title_size_s06` varchar(20) DEFAULT NULL COMMENT ' SIZE s06 Title FIELD',
  `title_size_s07` varchar(20) DEFAULT NULL COMMENT ' SIZE s07 \n\nTitle FIELD',
  `title_size_s08` varchar(20) DEFAULT NULL COMMENT ' SIZE s08 Title FIELD',
  `title_size_s09` varchar(20) DEFAULT NULL COMMENT ' SIZE \n\ns09 Title FIELD',
  `title_size_s10` varchar(20) DEFAULT NULL COMMENT ' SIZE s10 Title FIELD',
  `title_size_s11` varchar(20) DEFAULT NULL COMMENT ' \n\nSIZE s11 Title FIELD',
  `title_size_s12` varchar(20) DEFAULT NULL COMMENT ' SIZE s12 Title FIELD',
  `title_size_s13` varchar(20) DEFAULT NULL COMMENT ' SIZE s13 Title FIELD',
  `title_size_s14` varchar(20) DEFAULT NULL COMMENT ' SIZE s14 Title FIELD',
  `title_size_s15` varchar(20) DEFAULT NULL COMMENT ' SIZE s15 Title FIELD',
  `title_size_s16` varchar(20) DEFAULT NULL COMMENT ' SIZE s16 Title FIELD',
  `title_size_s17` varchar(20) DEFAULT NULL COMMENT ' SIZE s17 Title FIELD',
  `title_size_s18` varchar(20) DEFAULT NULL COMMENT ' SIZE s18 Title FIELD',
  `title_size_s19` varchar(20) DEFAULT NULL COMMENT ' SIZE s19 Title FIELD',
  `title_size_s20` varchar(20) DEFAULT NULL COMMENT ' SIZE s20 Title FIELD',
  `title_size_s21` varchar(20) DEFAULT NULL COMMENT ' SIZE s21 Title FIELD',
  `title_size_s22` varchar(20) DEFAULT NULL COMMENT ' SIZE s22 Title FIELD',
  `title_size_s23` varchar(20) DEFAULT NULL COMMENT ' SIZE s23 Title FIELD',
  `title_size_s24` varchar(20) DEFAULT NULL COMMENT ' SIZE s24 Title FIELD',
  `title_size_s25` varchar(20) DEFAULT NULL COMMENT ' SIZE s25 Title FIELD',
  `title_size_s26` varchar(20) DEFAULT NULL COMMENT ' SIZE s26 Title \n\nFIELD',
  `title_size_s27` varchar(20) DEFAULT NULL COMMENT ' SIZE s27 Title FIELD',
  `title_size_s28` varchar(20) DEFAULT NULL COMMENT ' SIZE s28 \n\nTitle FIELD',
  `title_size_s29` varchar(20) DEFAULT NULL COMMENT ' SIZE s29 Title FIELD',
  `title_size_s30` varchar(20) DEFAULT NULL COMMENT ' SIZE \n\ns30 Title FIELD',
  `title_size_s31` varchar(20) DEFAULT NULL COMMENT ' SIZE s31 Title FIELD',
  `title_size_s32` varchar(20) DEFAULT NULL COMMENT ' \n\nSIZE s32 Title FIELD',
  `title_size_s33` varchar(20) DEFAULT NULL COMMENT ' SIZE s33 Title FIELD',
  `title_size_s34` varchar(20) DEFAULT NULL COMMENT ' SIZE s34 Title FIELD',
  `title_size_s35` varchar(20) DEFAULT NULL COMMENT ' SIZE s35 Title FIELD',
  `title_size_s36` varchar(20) DEFAULT NULL COMMENT ' SIZE s36 Title FIELD',
  `title_size_s37` varchar(20) DEFAULT NULL COMMENT ' SIZE s37 Title FIELD',
  `title_size_s38` varchar(20) DEFAULT NULL COMMENT ' SIZE s38 Title FIELD',
  `title_size_s39` varchar(20) DEFAULT NULL COMMENT ' SIZE s39 Title FIELD',
  `title_size_s40` varchar(20) DEFAULT NULL COMMENT ' SIZE s40 Title FIELD',
  `title_size_s41` varchar(20) DEFAULT NULL COMMENT ' SIZE s41 Title FIELD',
  `title_size_s42` varchar(20) DEFAULT NULL COMMENT ' SIZE s42 Title FIELD',
  `title_size_s43` varchar(20) DEFAULT NULL COMMENT ' SIZE s43 Title FIELD',
  `title_size_s44` varchar(20) DEFAULT NULL COMMENT ' SIZE s44 Title FIELD',
  `title_size_s45` varchar(20) DEFAULT NULL COMMENT ' SIZE s45 Title FIELD',
  `title_size_s46` varchar(20) DEFAULT NULL COMMENT ' SIZE s46 Title FIELD',
  `title_size_s47` varchar(20) DEFAULT NULL COMMENT ' SIZE s47 Title \n\nFIELD',
  `title_size_s48` varchar(20) DEFAULT NULL COMMENT ' SIZE s48 Title FIELD',
  `title_size_s49` varchar(20) DEFAULT NULL COMMENT ' SIZE s49 \n\nTitle FIELD',
  `title_size_s50` varchar(20) DEFAULT NULL COMMENT ' SIZE s50 Title FIELD',
  `title_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`marker_ref_tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `mate_columns` */

DROP TABLE IF EXISTS `bai_pro3`.`mate_columns`;

CREATE TABLE `bai_pro3`.`mate_columns` (
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

DROP TABLE IF EXISTS `bai_pro3`.`members`;

CREATE TABLE `bai_pro3`.`members` (
  `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Login details for CMS';

/*Table structure for table `menu_index` */

DROP TABLE IF EXISTS `bai_pro3`.`menu_index`;

CREATE TABLE `bai_pro3`.`menu_index` (
  `list_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parent_list_id` int(11) DEFAULT NULL,
  `list_title` varchar(300) NOT NULL,
  `list_desc` text NOT NULL COMMENT 'link',
  `status` tinyint(4) NOT NULL COMMENT 'to show link or not 0-yes, 1-no',
  `link` smallint(6) NOT NULL COMMENT '0-yes; 1-no, to show line as link',
  `priority` smallint(6) NOT NULL COMMENT 'to give an order',
  `team` smallint(6) NOT NULL COMMENT 'Authorised members',
  `auth_members` text NOT NULL,
  `help_tip` varchar(100) NOT NULL,
  `command` varchar(30) NOT NULL COMMENT 'Shortcut Commands',
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Manufacturing Menu Details';

/*Table structure for table `menu_index_1` */

DROP TABLE IF EXISTS `bai_pro3`.`menu_index_1`;

CREATE TABLE `bai_pro3`.`menu_index_1` (
  `list_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parent_list_id` int(11) DEFAULT NULL,
  `list_title` varchar(300) NOT NULL,
  `list_desc` text NOT NULL COMMENT 'link',
  `status` tinyint(4) NOT NULL COMMENT 'to show link or not 0-yes, 1-no',
  `link` smallint(6) NOT NULL COMMENT '0-yes; 1-no, to show line as link',
  `priority` smallint(6) NOT NULL COMMENT 'to give an order',
  `team` smallint(6) NOT NULL COMMENT 'Authorised members',
  `auth_members` text NOT NULL,
  `help_tip` varchar(100) NOT NULL,
  `command` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Manufacturing Menu Details';

/*Table structure for table `menu_index_old` */

DROP TABLE IF EXISTS `bai_pro3`.`menu_index_old`;

CREATE TABLE `bai_pro3`.`menu_index_old` (
  `list_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `parent_list_id` int(11) DEFAULT NULL,
  `list_title` varchar(300) NOT NULL,
  `list_desc` text NOT NULL COMMENT 'link',
  `status` tinyint(4) NOT NULL COMMENT 'to show link or not 0-yes, 1-no',
  `link` smallint(6) NOT NULL COMMENT '0-yes; 1-no, to show line as link',
  `priority` smallint(6) NOT NULL COMMENT 'to give an order',
  `team` smallint(6) NOT NULL COMMENT 'Authorised members',
  `auth_members` text NOT NULL,
  `help_tip` varchar(100) NOT NULL,
  `command` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Manufacturing Menu Details';

/*Table structure for table `mix_temp_desti` */

DROP TABLE IF EXISTS `bai_pro3`.`mix_temp_desti`;

CREATE TABLE `bai_pro3`.`mix_temp_desti` (
  `mix_tid` smallint(6) NOT NULL AUTO_INCREMENT,
  `allo_new_ref` int(11) NOT NULL COMMENT 'doc_no of source',
  `cat_ref` int(11) NOT NULL,
  `cutt_ref` int(11) NOT NULL,
  `mk_ref` int(11) NOT NULL,
  `size` varchar(30) NOT NULL,
  `qty` int(11) NOT NULL,
  `order_tid` varchar(500) NOT NULL,
  `order_del_no` varchar(20) NOT NULL,
  `order_col_des` varchar(255) NOT NULL,
  `destination` varchar(10) DEFAULT NULL,
  `plies` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL,
  `cutno` int(10) NOT NULL,
  PRIMARY KEY (`mix_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='For Temp table for Order Mixing (for Job Level)';

/*Table structure for table `mix_temp_source` */

DROP TABLE IF EXISTS `bai_pro3`.`mix_temp_source`;

CREATE TABLE `bai_pro3`.`mix_temp_source` (
  `mix_tid` smallint(6) NOT NULL AUTO_INCREMENT,
  `doc_no` int(11) NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cutt_ref` int(11) NOT NULL,
  `mk_ref` int(11) NOT NULL,
  `size` varchar(30) NOT NULL,
  `qty` int(11) NOT NULL,
  `plies` int(11) NOT NULL,
  `cutno` int(10) NOT NULL,
  PRIMARY KEY (`mix_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='For Temp table for Order Mixing (for Job Level)';

/*Table structure for table `mod_back_color` */

DROP TABLE IF EXISTS `bai_pro3`.`mod_back_color`;

CREATE TABLE `bai_pro3`.`mod_back_color` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `mod_no` varchar(5) DEFAULT NULL COMMENT 'Module number',
  `back_color` varchar(20) DEFAULT NULL COMMENT 'background color',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `order_plan` */

DROP TABLE IF EXISTS `bai_pro3`.`order_plan`;

CREATE TABLE `bai_pro3`.`order_plan` (
  `schedule_no` bigint(11) NOT NULL,
  `mo_status` varchar(2) NOT NULL,
  `style_no` varchar(200) NOT NULL,
  `color` varchar(200) NOT NULL,
  `size_code` varchar(10) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `compo_no` varchar(400) NOT NULL,
  `item_des` varchar(200) NOT NULL,
  `order_yy` double NOT NULL,
  `col_des` varchar(200) NOT NULL,
  `material_sequence` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Temp table to update Category details from M3';

/*Table structure for table `orders_club_schedule` */

DROP TABLE IF EXISTS `bai_pro3`.`orders_club_schedule`;

CREATE TABLE `bai_pro3`.`orders_club_schedule` (
  `order_del_no` varchar(10) DEFAULT NULL,
  `order_col_des` varchar(50) DEFAULT NULL,
  `destination` varchar(10) DEFAULT NULL,
  `size_code` varchar(500) DEFAULT NULL,
  `orginal_size_code` varchar(500) DEFAULT NULL,
  `order_qty` varchar(500) DEFAULT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `orders_cut_split_db` */

DROP TABLE IF EXISTS `bai_pro3`.`orders_cut_split_db`;

CREATE TABLE `bai_pro3`.`orders_cut_split_db` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style_no` varchar(25) DEFAULT NULL,
  `schedule_no` varchar(25) DEFAULT NULL,
  `color_name` varchar(50) DEFAULT NULL,
  `size_ref` varchar(10) DEFAULT NULL,
  `size_qty` int(11) DEFAULT NULL,
  `destination` varchar(10) DEFAULT NULL,
  `tran_type` int(11) DEFAULT NULL,
  `club_schedule` varchar(25) DEFAULT NULL,
  `cutno` int(11) DEFAULT NULL,
  `doc_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `pac_sawing_out` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_sawing_out`;

CREATE TABLE `bai_pro3`.`pac_sawing_out` (
  `tid` int(100) NOT NULL AUTO_INCREMENT,
  `input_job_random` varchar(50) DEFAULT NULL,
  `input_job_number` varchar(44) DEFAULT NULL,
  `doc_no` varchar(30) DEFAULT NULL,
  `order_tid` text DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `qty` int(20) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `outs` varchar(50) DEFAULT NULL,
  `packs` varchar(50) DEFAULT NULL,
  `style` varchar(45) DEFAULT NULL,
  `schedule` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `scan_date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pac_sawing_out_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_sawing_out_archive`;

CREATE TABLE `bai_pro3`.`bai_pro3`.`pac_sawing_out_archive` (
  `tid` int(100) NOT NULL AUTO_INCREMENT,
  `input_job_random` varchar(50) DEFAULT NULL,
  `input_job_number` varchar(44) DEFAULT NULL,
  `doc_no` varchar(30) DEFAULT NULL,
  `order_tid` text DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `qty` int(20) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `outs` varchar(50) DEFAULT NULL,
  `packs` varchar(50) DEFAULT NULL,
  `style` varchar(45) DEFAULT NULL,
  `schedule` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `scan_date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `pac_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log`;

CREATE TABLE `bai_pro3`.`pac_stat_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(10) DEFAULT NULL,
  `carton_no` smallint(5) unsigned DEFAULT NULL,
  `carton_mode` char(1) DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(1000) DEFAULT NULL,
  `container` smallint(7) unsigned DEFAULT NULL,
  `disp_carton_no` tinyint(2) unsigned DEFAULT NULL,
  `disp_id` tinyint(2) unsigned DEFAULT NULL,
  `audit_status` char(7) DEFAULT NULL,
  `scan_date` datetime DEFAULT NULL,
  `scan_user` varchar(50) DEFAULT NULL,
  `input_job_random` varchar(75) DEFAULT NULL,
  `input_job_number` varchar(75) DEFAULT NULL,
  `order_tid` varchar(75) DEFAULT NULL,
  `module` varchar(15) DEFAULT NULL,
  `style` varchar(25) DEFAULT NULL,
  `schedule` varchar(25) DEFAULT NULL,
  `color` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `doc_no` (`doc_no`),
  KEY `doc_no_ref` (`tid`,`doc_no`,`size_code`),
  KEY `status` (`status`),
  KEY `carton_act_qty` (`carton_act_qty`),
  KEY `size_code` (`size_code`),
  KEY `tid` (`tid`),
  KEY `input_job` (`input_job_random`,`input_job_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Carton details table';

/*Table structure for table `pac_stat_log_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_backup`;

CREATE TABLE `bai_pro3`.`pac_stat_log_backup` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL COMMENT 'F-Full/P-Partial',
  `carton_act_qty` int(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `container` int(11) DEFAULT NULL,
  `disp_carton_no` int(11) DEFAULT NULL COMMENT 'to capture pending cartons',
  `disp_id` int(11) DEFAULT NULL COMMENT 'to capture failed events',
  `audit_status` int(11) DEFAULT NULL COMMENT '0- OK, 1- Not OK ',
  `scan_date` datetime DEFAULT NULL,
  `scan_user` varchar(50) DEFAULT NULL,
  `input_job_random` varchar(75) DEFAULT NULL,
  `input_job_number` varchar(75) DEFAULT NULL,
  `order_tid` varchar(75) DEFAULT NULL,
  `module` varchar(15) DEFAULT NULL,
  `style` varchar(25) DEFAULT NULL,
  `schedule` varchar(25) DEFAULT NULL,
  `color` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Clone of Pac_Stat_Log for system backup after shipment';

/*Table structure for table `pac_stat_log_deleted` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_deleted`;

CREATE TABLE `bai_pro3`.`pac_stat_log_deleted` (
  `tid` int(11) NOT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL COMMENT 'F-Full/P-Partial',
  `carton_act_qty` int(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NULL DEFAULT current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `container` int(11) DEFAULT NULL,
  `disp_carton_no` int(11) DEFAULT NULL,
  `disp_id` int(11) DEFAULT NULL,
  `audit_status` int(11) DEFAULT NULL,
  `scan_date` datetime DEFAULT NULL,
  `scan_user` varchar(50) DEFAULT NULL,
  `input_job_random` varchar(75) DEFAULT NULL,
  `input_job_number` varchar(75) DEFAULT NULL,
  `order_tid` varchar(75) DEFAULT NULL,
  `module` varchar(15) DEFAULT NULL,
  `style` varchar(25) DEFAULT NULL,
  `schedule` varchar(25) DEFAULT NULL,
  `color` varbinary(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Clone of Pac_Stat_Log to track deleted carton details';

/*Table structure for table `pac_stat_log_input_job` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_input_job`;

CREATE TABLE `bai_pro3`.`pac_stat_log_input_job` (
  `tid` double NOT NULL AUTO_INCREMENT,
  `doc_no` double DEFAULT NULL,
  `size_code` varchar(30) DEFAULT NULL,
  `carton_act_qty` int(11) DEFAULT NULL,
  `status` varchar(24) DEFAULT NULL,
  `doc_no_ref` varchar(900) DEFAULT NULL,
  `input_job_no` varchar(255) DEFAULT NULL,
  `input_job_no_random` varchar(90) DEFAULT NULL,
  `destination` varchar(30) DEFAULT NULL,
  `packing_mode` int(11) unsigned DEFAULT NULL,
  `old_size` varchar(10) DEFAULT NULL,
  `doc_type` varchar(10) DEFAULT 'N' COMMENT 'N=Normal, R=Recut',
  `type_of_sewing` int(3) DEFAULT 1 COMMENT '1- Normal, 2- Excess',
  PRIMARY KEY (`tid`),
  KEY `doc_no` (`doc_no`),
  KEY `inputjob_no` (`input_job_no`,`input_job_no_random`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `pac_stat_log_new` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_new`;

CREATE TABLE `bai_pro3`.`pac_stat_log_new` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(10) DEFAULT NULL,
  `carton_no` smallint(5) unsigned DEFAULT NULL,
  `carton_mode` char(1) DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `container` smallint(7) unsigned DEFAULT NULL,
  `disp_carton_no` tinyint(2) unsigned DEFAULT NULL,
  `disp_id` tinyint(2) unsigned DEFAULT NULL,
  `audit_status` char(7) DEFAULT NULL,
  `input_job_no` smallint(5) unsigned DEFAULT NULL,
  `input_job_no_random` varchar(30) DEFAULT NULL,
  `destination` varchar(10) NOT NULL,
  `style` varchar(20) DEFAULT NULL,
  `schedule` varchar(20) DEFAULT NULL,
  `color` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `carton_act_qty` (`carton_act_qty`),
  KEY `doc_no` (`doc_no`),
  KEY `doc_no_ref` (`tid`,`doc_no`,`size_code`),
  KEY `size_code` (`size_code`),
  KEY `status` (`status`),
  KEY `tid` (`tid`),
  KEY `input_job_no_random` (`input_job_no_random`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Carton details table';

/*Table structure for table `pac_stat_log_new_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_new_archive`;

CREATE TABLE `bai_pro3`.`pac_stat_log_new_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(10) DEFAULT NULL,
  `carton_no` smallint(5) unsigned DEFAULT NULL,
  `carton_mode` char(1) DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `container` smallint(7) unsigned DEFAULT NULL,
  `disp_carton_no` tinyint(2) unsigned DEFAULT NULL,
  `disp_id` tinyint(2) unsigned DEFAULT NULL,
  `audit_status` char(7) DEFAULT NULL,
  `input_job_no` smallint(5) unsigned DEFAULT NULL,
  `input_job_no_random` varchar(30) DEFAULT NULL,
  `destination` varchar(10) NOT NULL,
  `style` varchar(20) DEFAULT NULL,
  `schedule` varchar(20) DEFAULT NULL,
  `color` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `carton_act_qty` (`carton_act_qty`),
  KEY `doc_no` (`doc_no`),
  KEY `doc_no_ref` (`tid`,`doc_no`,`size_code`),
  KEY `size_code` (`size_code`),
  KEY `status` (`status`),
  KEY `tid` (`tid`),
  KEY `input_job_no_random` (`input_job_no_random`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Carton details table';

/*Table structure for table `pac_stat_log_partial` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_partial`;

CREATE TABLE `bai_pro3`.`pac_stat_log_partial` (
  `carton_id` bigint(20) NOT NULL,
  `partial_qty` int(11) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track split label details';

/*Table structure for table `pac_stat_log_sch_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_sch_temp`;

CREATE TABLE `bai_pro3`.`pac_stat_log_sch_temp` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL COMMENT 'F-Full/P-Partial',
  `carton_act_qty` int(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Temp table for packing summary';

/*Table structure for table `pack_methods` */

DROP TABLE IF EXISTS `bai_pro3`.`pack_methods`;

CREATE TABLE `bai_pro3`.`pack_methods` (
  `pack_id` int(11) NOT NULL AUTO_INCREMENT,
  `pack_method_name` varchar(255) DEFAULT NULL,
  `status` char(11) DEFAULT NULL,
  PRIMARY KEY (`pack_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `packing_dashboard_alert_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_dashboard_alert_temp`;

CREATE TABLE `bai_pro3`.`packing_dashboard_alert_temp` (
  `tid` int(11) DEFAULT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL,
  `carton_act_qty` decimal(10,0) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `ims_style` varchar(100) DEFAULT NULL,
  `ims_schedule` varchar(50) DEFAULT NULL,
  `ims_color` varchar(300) DEFAULT NULL,
  `input_date` date DEFAULT NULL,
  `ims_pro_qty` decimal(10,0) DEFAULT NULL,
  `ims_mod_no` varchar(8) DEFAULT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `packing_dashboard_pop_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_dashboard_pop_temp`;

CREATE TABLE `bai_pro3`.`packing_dashboard_pop_temp` (
  `tid` int(11) DEFAULT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL,
  `carton_act_qty` decimal(10,0) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `ims_style` varchar(100) DEFAULT NULL,
  `ims_schedule` varchar(50) DEFAULT NULL,
  `ims_color` varchar(300) DEFAULT NULL,
  `input_date` date DEFAULT NULL,
  `ims_pro_qty` decimal(10,0) DEFAULT NULL,
  `ims_mod_no` varchar(8) DEFAULT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `packing_dashboard_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_dashboard_temp`;

CREATE TABLE `bai_pro3`.`packing_dashboard_temp` (
  `tid` int(11) DEFAULT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL,
  `carton_act_qty` decimal(10,0) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `ims_style` varchar(100) DEFAULT NULL,
  `ims_schedule` varchar(50) DEFAULT NULL,
  `ims_color` varchar(300) DEFAULT NULL,
  `input_date` date DEFAULT NULL,
  `ims_pro_qty` decimal(10,0) DEFAULT NULL,
  `ims_mod_no` varchar(8) DEFAULT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Temp table for packing summary';

/*Table structure for table `packing_summary_tmp` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary_tmp`;

CREATE TABLE `bai_pro3`.`packing_summary_tmp` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `tid` int(11) NOT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `container` int(11) DEFAULT NULL,
  `disp_carton_no` int(11) DEFAULT NULL,
  `disp_id` int(11) DEFAULT NULL,
  `carton_act_qty` int(50) DEFAULT NULL,
  `audit_status` int(11) DEFAULT NULL,
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `acutno` int(11) DEFAULT NULL,
  KEY `doc_no` (`doc_no`,`size_code`,`order_style_no`,`order_del_no`,`order_col_des`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Temp table for packing summary';

/*Table structure for table `packing_summary_tmp_v1` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary_tmp_v1`;

CREATE TABLE `bai_pro3`.`packing_summary_tmp_v1` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `tid` int(11) NOT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `container` int(11) DEFAULT NULL,
  `disp_carton_no` int(11) DEFAULT NULL,
  `disp_id` int(11) DEFAULT NULL,
  `carton_act_qty` int(50) DEFAULT NULL,
  `audit_status` int(11) DEFAULT NULL,
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `acutno` smallint(6) DEFAULT NULL,
  KEY `doc_no` (`doc_no`,`size_code`,`order_style_no`,`order_del_no`,`order_col_des`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Temp table for packing summary';

/*Table structure for table `packing_summary_tmp_v3` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary_tmp_v3`;

CREATE TABLE `bai_pro3`.`packing_summary_tmp_v3` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `tid` int(11) NOT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `container` int(11) DEFAULT NULL,
  `disp_carton_no` int(11) DEFAULT NULL,
  `disp_id` int(11) DEFAULT NULL,
  `carton_act_qty` int(50) DEFAULT NULL,
  `audit_status` int(11) DEFAULT NULL,
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `acutno` smallint(6) DEFAULT NULL,
  KEY `doc_no` (`doc_no`,`size_code`,`order_style_no`,`order_del_no`,`order_col_des`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Temp table for packing summary';

/*Table structure for table `packing_summary_tmp_v3_ber_databasesvc` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary_tmp_v3_ber_databasesvc`;

CREATE TABLE `bai_pro3`.`packing_summary_tmp_v3_ber_databasesvc` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(1000) DEFAULT NULL,
  `tid` int(11) NOT NULL DEFAULT 0,
  `size_code` varchar(10) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `container` smallint(7) unsigned DEFAULT NULL,
  `disp_carton_no` tinyint(2) unsigned DEFAULT NULL,
  `disp_id` tinyint(2) unsigned DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `audit_status` char(7) DEFAULT NULL,
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `acutno` int(11) DEFAULT NULL COMMENT 'Actual Cutno\r\n'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `packing_summary_tmp_v3_sfcsproject1` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary_tmp_v3_sfcsproject1`;

CREATE TABLE `bai_pro3`.`packing_summary_tmp_v3_sfcsproject1` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(1000) DEFAULT NULL,
  `tid` int(11) NOT NULL DEFAULT 0,
  `size_code` varchar(10) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `container` smallint(7) unsigned DEFAULT NULL,
  `disp_carton_no` tinyint(2) unsigned DEFAULT NULL,
  `disp_id` tinyint(2) unsigned DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `audit_status` char(7) DEFAULT NULL,
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `acutno` int(11) DEFAULT NULL COMMENT 'Actual Cutno\r\n'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `party_db` */

DROP TABLE IF EXISTS `bai_pro3`.`party_db`;

CREATE TABLE `bai_pro3`.`party_db` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `party_details` varchar(500) NOT NULL,
  `order_no` int(11) NOT NULL,
  `party_name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_cutting_table` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_cutting_table`;

CREATE TABLE `bai_pro3`.`plan_cutting_table` (
  `tbl_id` int(11) NOT NULL,
  `doc_no` varchar(50) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `fabric_status` int(11) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`doc_no`),
  KEY `track_id` (`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_cutting_table_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_cutting_table_archive`;

CREATE TABLE `bai_pro3`.`plan_cutting_table_archive` (
  `tbl_id` int(11) NOT NULL,
  `doc_no` varchar(50) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `fabric_status` int(11) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`doc_no`),
  KEY `track_id` (`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard`;

CREATE TABLE `bai_pro3`.`plan_dashboard` (
  `module` varchar(8) DEFAULT NULL COMMENT 'Module No\r\n',
  `doc_no` int(11) NOT NULL COMMENT 'Docket No\r\n',
  `priority` int(11) DEFAULT NULL COMMENT 'Priority\r\n',
  `fabric_status` int(11) DEFAULT NULL COMMENT 'Fabric Issue Status\r\n',
  `log_time` datetime NOT NULL COMMENT 'Updating time\r\n',
  `track_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracing Id\r\n',
  `cutting_table_location` int(11) DEFAULT NULL,
  `shift` varchar(5) DEFAULT NULL,
  `cut_date` date DEFAULT NULL,
  PRIMARY KEY (`doc_no`),
  UNIQUE KEY `track_id` (`track_id`),
  KEY `module` (`module`),
  KEY `doc_no` (`doc_no`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_change_log` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard_change_log`;

CREATE TABLE `bai_pro3`.`plan_dashboard_change_log` (
  `doc_no` bigint(20) DEFAULT NULL,
  `record_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `record_user` varchar(100) DEFAULT NULL,
  `record_comment` text DEFAULT NULL,
  KEY `doc_no` (`doc_no`),
  KEY `record_user` (`record_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_deleted` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard_deleted`;

CREATE TABLE `bai_pro3`.`plan_dashboard_deleted` (
  `module` varchar(10) DEFAULT NULL COMMENT 'Module No\r\n',
  `doc_no` varchar(50) NOT NULL COMMENT 'Docket No\r\n',
  `priority` int(11) DEFAULT NULL COMMENT 'Priority\r\n',
  `fabric_status` int(11) DEFAULT NULL COMMENT 'Fabric Issue Status\r\n',
  `log_time` datetime NOT NULL COMMENT 'Updating time\r\n',
  `track_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracing Id\r\n',
  PRIMARY KEY (`doc_no`),
  UNIQUE KEY `track_id` (`track_id`),
  KEY `doc_no` (`doc_no`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard_input`;

CREATE TABLE `bai_pro3`.`plan_dashboard_input` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) DEFAULT NULL,
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  PRIMARY KEY (`input_job_no_random_ref`),
  UNIQUE KEY `unique_key` (`input_job_no_random_ref`),
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input1` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard_input1`;

CREATE TABLE `bai_pro3`.`plan_dashboard_input1` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) NOT NULL DEFAULT '',
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  PRIMARY KEY (`input_job_no_random_ref`),
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`),
  KEY `plan_dashboard_input_jobnoref` (`input_job_no_random_ref`,`input_module`,`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard_input_archive`;

CREATE TABLE `bai_pro3`.`plan_dashboard_input_archive` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) DEFAULT NULL,
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  PRIMARY KEY (`input_job_no_random_ref`),
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard_input_backup`;

CREATE TABLE `bai_pro3`.`plan_dashboard_input_backup` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) DEFAULT NULL,
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input_copy` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard_input_copy`;

CREATE TABLE `bai_pro3`.`plan_dashboard_input_copy` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) DEFAULT NULL,
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  PRIMARY KEY (`input_job_no_random_ref`),
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input_deleted` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dashboard_input_deleted`;

CREATE TABLE `bai_pro3`.`plan_dashboard_input_deleted` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) NOT NULL DEFAULT '',
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  `deleted_time` datetime NOT NULL COMMENT 'Deleted time',
  `deleted_user` varchar(30) NOT NULL COMMENT 'Deleted by user name',
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`),
  KEY `plan_dashboard_input_jobnoref` (`input_job_no_random_ref`,`input_module`,`track_id`),
  KEY `input_job_no_random_ref` (`input_job_no_random_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_doc_summ_input_sfcsproject1` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_doc_summ_input_sfcsproject1`;

CREATE TABLE `bai_pro3`.`plan_doc_summ_input_sfcsproject1` (
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `act_cut_status` varchar(50) DEFAULT NULL,
  `doc_no` int(11) DEFAULT NULL COMMENT 'Docket No\r\n',
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `total` decimal(32,0) DEFAULT NULL,
  `acutno` varchar(255) DEFAULT NULL,
  `color_code` blob DEFAULT NULL,
  `input_job_no` varchar(255) DEFAULT NULL,
  `input_job_no_random` varchar(90) DEFAULT NULL,
  `input_job_no_random_ref` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `plan_modules` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_modules`;

CREATE TABLE `bai_pro3`.`plan_modules` (
  `module_id` varchar(8) NOT NULL,
  `section_id` smallint(6) NOT NULL,
  `power_user` varchar(30) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `buyer_div` varchar(15) NOT NULL,
  `ims_priority_boxes` int(11) NOT NULL,
  `table_tid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`table_tid`),
  KEY `NewIndex1` (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`plandoc_stat_log`;

CREATE TABLE `bai_pro3`.`plandoc_stat_log` (
  `date` date NOT NULL COMMENT 'Log date\r\n',
  `cat_ref` int(11) NOT NULL COMMENT 'Category Reference \r\n',
  `cuttable_ref` int(11) NOT NULL COMMENT 'Cuttable Reference\r\n',
  `allocate_ref` int(11) NOT NULL COMMENT 'Allocation Reference \r\n',
  `mk_ref` int(11) NOT NULL COMMENT 'Marker Reference\r\n',
  `order_tid` varchar(200) NOT NULL COMMENT 'Combination of Style, Schedule, Color\r\n',
  `pcutno` int(11) NOT NULL COMMENT 'Plan Cut No\r\n',
  `ratio` int(11) NOT NULL COMMENT 'Ratio No\r\n',
  `p_xs` int(11) NOT NULL COMMENT 'XS Plan Plies\r\n\n\n',
  `p_s` int(11) NOT NULL COMMENT 'S Plan Plies\r\n',
  `p_m` int(11) NOT NULL COMMENT 'M Plan Plies\r\n',
  `p_l` int(11) NOT NULL COMMENT 'L \n\nPlan Plies\r\n',
  `p_xl` int(11) NOT NULL COMMENT 'XL Plan Plies\r\n',
  `p_xxl` int(11) NOT NULL COMMENT 'XXL Plan Plies\r\n',
  `p_xxxl` int(11) NOT NULL COMMENT 'XXXL Plan Plies\r\n',
  `p_plies` int(11) NOT NULL COMMENT 'Total Plan Plies\r\n',
  `doc_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Docket No\r\n',
  `acutno` int(11) NOT NULL COMMENT 'Actual Cutno\r\n',
  `a_xs` int(11) NOT NULL COMMENT 'XS Actual Plies\r\n',
  `a_s` int(11) NOT NULL COMMENT 'S Actual Plies\r\n',
  `a_m` int(11) NOT NULL COMMENT 'M Actual Plies\r\n',
  `a_l` int(11) NOT NULL COMMENT 'L Actual \n\nPlies\r\n',
  `a_xl` int(11) NOT NULL COMMENT 'XL Actual Plies\r\n',
  `a_xxl` int(11) NOT NULL COMMENT 'XXL Actual Plies\r\n',
  `a_xxxl` int(11) NOT NULL COMMENT 'XXXL Actual Plies\r\n',
  `a_plies` int(11) NOT NULL COMMENT 'Actula Total Plies\r\n',
  `lastup` datetime NOT NULL COMMENT 'Last \n\nUpdated\r\n',
  `remarks` varchar(500) NOT NULL COMMENT 'Remarks\r\n',
  `act_cut_status` varchar(50) NOT NULL COMMENT 'Cutting Status\r\n',
  `act_cut_issue_status` varchar(50) NOT NULL COMMENT 'Input Issue Status\r\n',
  `pcutdocid` varchar(200) NOT NULL,
  `print_status` date DEFAULT NULL COMMENT 'Docket Print Status\r\n',
  `a_s01` int(11) NOT NULL COMMENT 's01 Actual Plies',
  `a_s02` int(11) NOT NULL COMMENT 's02 Actual \n\nPlies',
  `a_s03` int(11) NOT NULL COMMENT 's03 Actual Plies',
  `a_s04` int(11) NOT NULL COMMENT 's04 Actual Plies',
  `a_s05` int(11) NOT NULL COMMENT 's05 Actual Plies',
  `a_s06` int(11) NOT NULL COMMENT 's06 Actual Plies',
  `a_s07` int(11) NOT NULL COMMENT 's07 Actual Plies',
  `a_s08` int(11) NOT NULL COMMENT 's08 Actual Plies',
  `a_s09` int(11) NOT NULL COMMENT 's09 Actual Plies',
  `a_s10` int(11) NOT NULL COMMENT 's10 Actual Plies',
  `a_s11` int(11) NOT NULL COMMENT 's11 Actual Plies',
  `a_s12` int(11) NOT NULL COMMENT 's12 Actual Plies',
  `a_s13` int(11) NOT NULL COMMENT 's13 Actual \n\nPlies',
  `a_s14` int(11) NOT NULL COMMENT 's14 Actual Plies',
  `a_s15` int(11) NOT NULL COMMENT 's15 Actual Plies',
  `a_s16` int(11) NOT NULL COMMENT 's16 Actual Plies',
  `a_s17` int(11) NOT NULL COMMENT 's17 Actual Plies',
  `a_s18` int(11) NOT NULL COMMENT 's18 Actual Plies',
  `a_s19` int(11) NOT NULL COMMENT 's19 Actual Plies',
  `a_s20` int(11) NOT NULL COMMENT 's20 Actual Plies',
  `a_s21` int(11) NOT NULL COMMENT 's21 Actual Plies',
  `a_s22` int(11) NOT NULL COMMENT 's22 Actual Plies',
  `a_s23` int(11) NOT NULL COMMENT 's23 Actual Plies',
  `a_s24` int(11) NOT NULL COMMENT 's24 Actual \n\nPlies',
  `a_s25` int(11) NOT NULL COMMENT 's25 Actual Plies',
  `a_s26` int(11) NOT NULL COMMENT 's26 Actual Plies',
  `a_s27` int(11) NOT NULL COMMENT 's27 Actual Plies',
  `a_s28` int(11) NOT NULL COMMENT 's28 Actual Plies',
  `a_s29` int(11) NOT NULL COMMENT 's29 Actual Plies',
  `a_s30` int(11) NOT NULL COMMENT 's30 Actual Plies',
  `a_s31` int(11) NOT NULL COMMENT 's31 Actual Plies',
  `a_s32` int(11) NOT NULL COMMENT 's32 Actual Plies',
  `a_s33` int(11) NOT NULL COMMENT 's33 Actual Plies',
  `a_s34` int(11) NOT NULL COMMENT 's34 Actual Plies',
  `a_s35` int(11) NOT NULL COMMENT 's35 Actual \n\nPlies',
  `a_s36` int(11) NOT NULL COMMENT 's36 Actual Plies',
  `a_s37` int(11) NOT NULL COMMENT 's37 Actual Plies',
  `a_s38` int(11) NOT NULL COMMENT 's38 Actual Plies',
  `a_s39` int(11) NOT NULL COMMENT 's39 Actual Plies',
  `a_s40` int(11) NOT NULL COMMENT 's40 Actual Plies',
  `a_s41` int(11) NOT NULL COMMENT 's41 Actual Plies',
  `a_s42` int(11) NOT NULL COMMENT 's42 Actual Plies',
  `a_s43` int(11) NOT NULL COMMENT 's43 Actual Plies',
  `a_s44` int(11) NOT NULL COMMENT 's44 Actual Plies',
  `a_s45` int(11) NOT NULL COMMENT 's45 Actual Plies',
  `a_s46` int(11) NOT NULL COMMENT 's46 Actual \n\nPlies',
  `a_s47` int(11) NOT NULL COMMENT 's47 Actual Plies',
  `a_s48` int(11) NOT NULL COMMENT 's48 Actual Plies',
  `a_s49` int(11) NOT NULL COMMENT 's49 Actual Plies',
  `a_s50` int(11) NOT NULL COMMENT 's50 Actual Plies',
  `p_s01` int(11) NOT NULL COMMENT 's01 Plan Plies',
  `p_s02` int(11) NOT NULL COMMENT 's02 Plan Plies',
  `p_s03` int(11) NOT NULL COMMENT 's03 Plan Plies',
  `p_s04` int(11) NOT NULL COMMENT 's04 Plan Plies',
  `p_s05` int(11) NOT NULL COMMENT 's05 Plan Plies',
  `p_s06` int(11) NOT NULL COMMENT 's06 Plan Plies',
  `p_s07` int(11) NOT NULL COMMENT 's07 Plan Plies',
  `p_s08` int(11) NOT NULL COMMENT 's08 Plan Plies',
  `p_s09` int(11) NOT NULL COMMENT 's09 Plan Plies',
  `p_s10` int(11) NOT NULL COMMENT 's10 Plan \n\nPlies',
  `p_s11` int(11) NOT NULL COMMENT 's11 Plan Plies',
  `p_s12` int(11) NOT NULL COMMENT 's12 Plan Plies',
  `p_s13` int(11) NOT NULL COMMENT 's13 Plan Plies',
  `p_s14` int(11) NOT NULL COMMENT 's14 Plan Plies',
  `p_s15` int(11) NOT NULL COMMENT 's15 Plan Plies',
  `p_s16` int(11) NOT NULL COMMENT 's16 Plan Plies',
  `p_s17` int(11) NOT NULL COMMENT 's17 Plan Plies',
  `p_s18` int(11) NOT NULL COMMENT 's18 Plan Plies',
  `p_s19` int(11) NOT NULL COMMENT 's19 Plan Plies',
  `p_s20` int(11) NOT NULL COMMENT 's20 Plan Plies',
  `p_s21` int(11) NOT NULL COMMENT 's21 Plan Plies',
  `p_s22` int(11) NOT NULL COMMENT 's22 Plan Plies',
  `p_s23` int(11) NOT NULL COMMENT 's23 Plan Plies',
  `p_s24` int(11) NOT NULL COMMENT 's24 Plan Plies',
  `p_s25` int(11) NOT NULL COMMENT 's25 Plan Plies',
  `p_s26` int(11) NOT NULL COMMENT 's26 Plan Plies',
  `p_s27` int(11) NOT NULL COMMENT 's27 Plan \n\nPlies',
  `p_s28` int(11) NOT NULL COMMENT 's28 Plan Plies',
  `p_s29` int(11) NOT NULL COMMENT 's29 Plan Plies',
  `p_s30` int(11) NOT NULL COMMENT 's30 Plan Plies',
  `p_s31` int(11) NOT NULL COMMENT 's31 Plan Plies',
  `p_s32` int(11) NOT NULL COMMENT 's32 Plan Plies',
  `p_s33` int(11) NOT NULL COMMENT 's33 Plan Plies',
  `p_s34` int(11) NOT NULL COMMENT 's34 Plan Plies',
  `p_s35` int(11) NOT NULL COMMENT 's35 Plan Plies',
  `p_s36` int(11) NOT NULL COMMENT 's36 Plan Plies',
  `p_s37` int(11) NOT NULL COMMENT 's37 Plan Plies',
  `p_s38` int(11) NOT NULL COMMENT 's38 Plan Plies',
  `p_s39` int(11) NOT NULL COMMENT 's39 Plan Plies',
  `p_s40` int(11) NOT NULL COMMENT 's40 Plan Plies',
  `p_s41` int(11) NOT NULL COMMENT 's41 Plan Plies',
  `p_s42` int(11) NOT NULL COMMENT 's42 Plan Plies',
  `p_s43` int(11) NOT NULL COMMENT 's43 Plan Plies',
  `p_s44` int(11) NOT NULL COMMENT 's44 Plan \n\nPlies',
  `p_s45` int(11) NOT NULL COMMENT 's45 Plan Plies',
  `p_s46` int(11) NOT NULL COMMENT 's46 Plan Plies',
  `p_s47` int(11) NOT NULL COMMENT 's47 Plan Plies',
  `p_s48` int(11) NOT NULL COMMENT 's48 Plan Plies',
  `p_s49` int(11) NOT NULL COMMENT 's49 Plan Plies',
  `p_s50` int(11) NOT NULL COMMENT 's50 Plan Plies',
  `rm_date` datetime DEFAULT NULL COMMENT 'RM update date\r\n',
  `cut_inp_temp` int(11) DEFAULT NULL COMMENT 'Cutting \n\nPartial Input Status\r\n',
  `plan_module` varchar(8) DEFAULT NULL COMMENT 'Planned Module\r\n',
  `fabric_status` smallint(6) NOT NULL COMMENT 'Fabric Issue Status\r\n',
  `plan_lot_ref` text NOT NULL COMMENT 'Issued Lot details\r\n',
  `log_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Last Updated',
  `destination` varchar(11) DEFAULT NULL,
  `org_doc_no` int(11) DEFAULT 0,
  `org_plies` int(11) DEFAULT 0,
  `act_movement_status` varchar(25) DEFAULT NULL,
  `docket_printed_person` varchar(20) NOT NULL,
  PRIMARY KEY (`doc_no`),
  UNIQUE KEY `unique_key` (`cat_ref`,`pcutno`,`ratio`),
  KEY `date` (`date`,`cat_ref`,`p_plies`,`a_plies`),
  KEY `order_tid` (`order_tid`),
  KEY `act_cut_issue_status` (`act_cut_issue_status`),
  KEY `act_cut_issue_status1` (`act_cut_status`),
  KEY `act_cut_status` (`act_cut_status`,`act_cut_issue_status`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`),
  KEY `doc_no_ref` (`doc_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`plandoc_stat_log_archive`;

CREATE TABLE `bai_pro3`.`plandoc_stat_log_archive` (
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cuttable_ref` int(11) NOT NULL,
  `allocate_ref` int(11) NOT NULL,
  `mk_ref` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `pcutno` int(11) NOT NULL,
  `ratio` int(11) NOT NULL,
  `p_xs` int(11) NOT NULL,
  `p_s` int(11) NOT NULL,
  `p_m` int(11) NOT NULL,
  `p_l` int(11) NOT NULL,
  `p_xl` int(11) NOT NULL,
  `p_xxl` int(11) NOT NULL,
  `p_xxxl` int(11) NOT NULL,
  `p_plies` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL AUTO_INCREMENT,
  `acutno` int(11) NOT NULL,
  `a_xs` int(11) NOT NULL,
  `a_s` int(11) NOT NULL,
  `a_m` int(11) NOT NULL,
  `a_l` int(11) NOT NULL,
  `a_xl` int(11) NOT NULL,
  `a_xxl` int(11) NOT NULL,
  `a_xxxl` int(11) NOT NULL,
  `a_plies` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `act_cut_status` varchar(50) NOT NULL,
  `act_cut_issue_status` varchar(50) NOT NULL,
  `pcutdocid` varchar(200) NOT NULL,
  `print_status` date DEFAULT NULL,
  `a_s01` int(11) NOT NULL COMMENT 's01 Actual Plies',
  `a_s02` int(11) NOT NULL COMMENT 's02 Actual Plies',
  `a_s03` int(11) NOT NULL COMMENT 's03 Actual Plies',
  `a_s04` int(11) NOT NULL COMMENT 's04 Actual Plies',
  `a_s05` int(11) NOT NULL COMMENT 's05 Actual Plies',
  `a_s06` int(11) NOT NULL COMMENT 's06 Actual \n\nPlies',
  `a_s07` int(11) NOT NULL COMMENT 's07 Actual Plies',
  `a_s08` int(11) NOT NULL COMMENT 's08 Actual Plies',
  `a_s09` int(11) NOT NULL COMMENT 's09 Actual Plies',
  `a_s10` int(11) NOT NULL COMMENT 's10 Actual Plies',
  `a_s11` int(11) NOT NULL COMMENT 's11 Actual Plies',
  `a_s12` int(11) NOT NULL COMMENT 's12 Actual Plies',
  `a_s13` int(11) NOT NULL COMMENT 's13 Actual Plies',
  `a_s14` int(11) NOT NULL COMMENT 's14 Actual Plies',
  `a_s15` int(11) NOT NULL COMMENT 's15 Actual Plies',
  `a_s16` int(11) NOT NULL COMMENT 's16 Actual Plies',
  `a_s17` int(11) NOT NULL COMMENT 's17 Actual \n\nPlies',
  `a_s18` int(11) NOT NULL COMMENT 's18 Actual Plies',
  `a_s19` int(11) NOT NULL COMMENT 's19 Actual Plies',
  `a_s20` int(11) NOT NULL COMMENT 's20 Actual Plies',
  `a_s21` int(11) NOT NULL COMMENT 's21 Actual Plies',
  `a_s22` int(11) NOT NULL COMMENT 's22 Actual Plies',
  `a_s23` int(11) NOT NULL COMMENT 's23 Actual Plies',
  `a_s24` int(11) NOT NULL COMMENT 's24 Actual Plies',
  `a_s25` int(11) NOT NULL COMMENT 's25 Actual Plies',
  `a_s26` int(11) NOT NULL COMMENT 's26 Actual Plies',
  `a_s27` int(11) NOT NULL COMMENT 's27 Actual Plies',
  `a_s28` int(11) NOT NULL COMMENT 's28 Actual \n\nPlies',
  `a_s29` int(11) NOT NULL COMMENT 's29 Actual Plies',
  `a_s30` int(11) NOT NULL COMMENT 's30 Actual Plies',
  `a_s31` int(11) NOT NULL COMMENT 's31 Actual Plies',
  `a_s32` int(11) NOT NULL COMMENT 's32 Actual Plies',
  `a_s33` int(11) NOT NULL COMMENT 's33 Actual Plies',
  `a_s34` int(11) NOT NULL COMMENT 's34 Actual Plies',
  `a_s35` int(11) NOT NULL COMMENT 's35 Actual Plies',
  `a_s36` int(11) NOT NULL COMMENT 's36 Actual Plies',
  `a_s37` int(11) NOT NULL COMMENT 's37 Actual Plies',
  `a_s38` int(11) NOT NULL COMMENT 's38 Actual Plies',
  `a_s39` int(11) NOT NULL COMMENT 's39 Actual \n\nPlies',
  `a_s40` int(11) NOT NULL COMMENT 's40 Actual Plies',
  `a_s41` int(11) NOT NULL COMMENT 's41 Actual Plies',
  `a_s42` int(11) NOT NULL COMMENT 's42 Actual Plies',
  `a_s43` int(11) NOT NULL COMMENT 's43 Actual Plies',
  `a_s44` int(11) NOT NULL COMMENT 's44 Actual Plies',
  `a_s45` int(11) NOT NULL COMMENT 's45 Actual Plies',
  `a_s46` int(11) NOT NULL COMMENT 's46 Actual Plies',
  `a_s47` int(11) NOT NULL COMMENT 's47 Actual Plies',
  `a_s48` int(11) NOT NULL COMMENT 's48 Actual Plies',
  `a_s49` int(11) NOT NULL COMMENT 's49 Actual Plies',
  `a_s50` int(11) NOT NULL COMMENT 's50 Actual \n\nPlies',
  `p_s01` int(11) NOT NULL COMMENT 's01 Plan Plies',
  `p_s02` int(11) NOT NULL COMMENT 's02 Plan Plies',
  `p_s03` int(11) NOT NULL COMMENT 's03 Plan Plies',
  `p_s04` int(11) NOT NULL COMMENT 's04 Plan Plies',
  `p_s05` int(11) NOT NULL COMMENT 's05 Plan Plies',
  `p_s06` int(11) NOT NULL COMMENT 's06 Plan Plies',
  `p_s07` int(11) NOT NULL COMMENT 's07 Plan Plies',
  `p_s08` int(11) NOT NULL COMMENT 's08 Plan Plies',
  `p_s09` int(11) NOT NULL COMMENT 's09 Plan Plies',
  `p_s10` int(11) NOT NULL COMMENT 's10 Plan Plies',
  `p_s11` int(11) NOT NULL COMMENT 's11 Plan Plies',
  `p_s12` int(11) NOT NULL COMMENT 's12 Plan Plies',
  `p_s13` int(11) NOT NULL COMMENT 's13 Plan Plies',
  `p_s14` int(11) NOT NULL COMMENT 's14 Plan Plies',
  `p_s15` int(11) NOT NULL COMMENT 's15 Plan Plies',
  `p_s16` int(11) NOT NULL COMMENT 's16 Plan Plies',
  `p_s17` int(11) NOT NULL COMMENT 's17 Plan \n\nPlies',
  `p_s18` int(11) NOT NULL COMMENT 's18 Plan Plies',
  `p_s19` int(11) NOT NULL COMMENT 's19 Plan Plies',
  `p_s20` int(11) NOT NULL COMMENT 's20 Plan Plies',
  `p_s21` int(11) NOT NULL COMMENT 's21 Plan Plies',
  `p_s22` int(11) NOT NULL COMMENT 's22 Plan Plies',
  `p_s23` int(11) NOT NULL COMMENT 's23 Plan Plies',
  `p_s24` int(11) NOT NULL COMMENT 's24 Plan Plies',
  `p_s25` int(11) NOT NULL COMMENT 's25 Plan Plies',
  `p_s26` int(11) NOT NULL COMMENT 's26 Plan Plies',
  `p_s27` int(11) NOT NULL COMMENT 's27 Plan Plies',
  `p_s28` int(11) NOT NULL COMMENT 's28 Plan Plies',
  `p_s29` int(11) NOT NULL COMMENT 's29 Plan Plies',
  `p_s30` int(11) NOT NULL COMMENT 's30 Plan Plies',
  `p_s31` int(11) NOT NULL COMMENT 's31 Plan Plies',
  `p_s32` int(11) NOT NULL COMMENT 's32 Plan Plies',
  `p_s33` int(11) NOT NULL COMMENT 's33 Plan Plies',
  `p_s34` int(11) NOT NULL COMMENT 's34 Plan \n\nPlies',
  `p_s35` int(11) NOT NULL COMMENT 's35 Plan Plies',
  `p_s36` int(11) NOT NULL COMMENT 's36 Plan Plies',
  `p_s37` int(11) NOT NULL COMMENT 's37 Plan Plies',
  `p_s38` int(11) NOT NULL COMMENT 's38 Plan Plies',
  `p_s39` int(11) NOT NULL COMMENT 's39 Plan Plies',
  `p_s40` int(11) NOT NULL COMMENT 's40 Plan Plies',
  `p_s41` int(11) NOT NULL COMMENT 's41 Plan Plies',
  `p_s42` int(11) NOT NULL COMMENT 's42 Plan Plies',
  `p_s43` int(11) NOT NULL COMMENT 's43 Plan Plies',
  `p_s44` int(11) NOT NULL COMMENT 's44 Plan Plies',
  `p_s45` int(11) NOT NULL COMMENT 's45 Plan Plies',
  `p_s46` int(11) NOT NULL COMMENT 's46 Plan Plies',
  `p_s47` int(11) NOT NULL COMMENT 's47 Plan Plies',
  `p_s48` int(11) NOT NULL COMMENT 's48 Plan Plies',
  `p_s49` int(11) NOT NULL COMMENT 's49 Plan Plies',
  `p_s50` int(11) NOT NULL COMMENT 's50 Plan Plies',
  `rm_date` datetime DEFAULT NULL,
  `cut_inp_temp` int(11) DEFAULT NULL,
  `plan_module` varchar(8) DEFAULT NULL,
  `fabric_status` smallint(6) NOT NULL,
  `plan_lot_ref` text NOT NULL,
  `log_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log_archive2` */

DROP TABLE IF EXISTS `bai_pro3`.`plandoc_stat_log_archive2`;

CREATE TABLE `bai_pro3`.`plandoc_stat_log_archive2` (
  `date` date NOT NULL COMMENT 'Log date\r\n',
  `cat_ref` int(11) NOT NULL COMMENT 'Category Reference \r\n',
  `cuttable_ref` int(11) NOT NULL COMMENT 'Cuttable Reference\r\n',
  `allocate_ref` int(11) NOT NULL COMMENT 'Allocation Reference \r\n',
  `mk_ref` int(11) NOT NULL COMMENT 'Marker Reference\r\n',
  `order_tid` varchar(200) NOT NULL COMMENT 'Combination of Style, Schedule, Color\r\n',
  `pcutno` int(11) NOT NULL COMMENT 'Plan Cut No\r\n',
  `ratio` int(11) NOT NULL COMMENT 'Ratio No\r\n',
  `p_xs` int(11) NOT NULL COMMENT 'XS Plan Plies\r\n',
  `p_s` int(11) NOT NULL COMMENT 'S Plan Plies\r\n',
  `p_m` int(11) NOT NULL COMMENT 'M Plan Plies\r\n',
  `p_l` int(11) NOT NULL COMMENT 'L Plan Plies\r\n',
  `p_xl` int(11) NOT NULL COMMENT 'XL Plan Plies\r\n',
  `p_xxl` int(11) NOT NULL COMMENT 'XXL Plan Plies\r\n',
  `p_xxxl` int(11) NOT NULL COMMENT 'XXXL Plan Plies\r\n',
  `p_plies` int(11) NOT NULL COMMENT 'Total Plan Plies\r\n',
  `doc_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Docket No\r\n',
  `acutno` int(11) NOT NULL COMMENT 'Actual Cutno\r\n',
  `a_xs` int(11) NOT NULL COMMENT 'XS Actual Plies\r\n',
  `a_s` int(11) NOT NULL COMMENT 'S Actual Plies\r\n',
  `a_m` int(11) NOT NULL COMMENT 'M Actual Plies\r\n',
  `a_l` int(11) NOT NULL COMMENT 'L Actual Plies\r\n',
  `a_xl` int(11) NOT NULL COMMENT 'XL Actual Plies\r\n',
  `a_xxl` int(11) NOT NULL COMMENT 'XXL Actual Plies\r\n',
  `a_xxxl` int(11) NOT NULL COMMENT 'XXXL Actual Plies\r\n',
  `a_plies` int(11) NOT NULL COMMENT 'Actula Total Plies\r\n',
  `lastup` datetime NOT NULL COMMENT 'Last Updated\r\n',
  `remarks` varchar(500) NOT NULL COMMENT 'Remarks\r\n',
  `act_cut_status` varchar(50) NOT NULL COMMENT 'Cutting Status\r\n',
  `act_cut_issue_status` varchar(50) NOT NULL COMMENT 'Input Issue Status\r\n',
  `pcutdocid` varchar(200) NOT NULL,
  `print_status` date DEFAULT NULL COMMENT 'Docket Print Status\r\n',
  `a_s06` int(11) NOT NULL COMMENT 'S06 Actual Plies\r\n',
  `a_s08` int(11) NOT NULL COMMENT 'S08 Actual Plies\r\n',
  `a_s10` int(11) NOT NULL COMMENT 'S10 Actual Plies\r\n',
  `a_s12` int(11) NOT NULL COMMENT 'S12 Actual Plies\r\n',
  `a_s14` int(11) NOT NULL COMMENT 'S14 Actual Plies\r\n',
  `a_s16` int(11) NOT NULL COMMENT 'S16 Actual Plies\r\n',
  `a_s18` int(11) NOT NULL COMMENT 'S18 Actual Plies\r\n',
  `a_s20` int(11) NOT NULL COMMENT 'S20 Actual Plies\r\n',
  `a_s22` int(11) NOT NULL COMMENT 'S22 Actual Plies\r\n',
  `a_s24` int(11) NOT NULL COMMENT 'S24 Actual Plies\r\n',
  `a_s26` int(11) NOT NULL COMMENT 'S26 Actual Plies\r\n',
  `a_s28` int(11) NOT NULL COMMENT 'S28 Actual Plies\r\n',
  `a_s30` int(11) NOT NULL COMMENT 'S30 Actual Plies\r\n',
  `p_s06` int(11) NOT NULL COMMENT 'S06 Plan Plies\r\n',
  `p_s08` int(11) NOT NULL COMMENT 'S08 Plan Plies\r\n',
  `p_s10` int(11) NOT NULL COMMENT 'S10 Plan Plies\r\n',
  `p_s12` int(11) NOT NULL COMMENT 'S12 Plan Plies\r\n',
  `p_s14` int(11) NOT NULL COMMENT 'S14 Plan Plies\r\n',
  `p_s16` int(11) NOT NULL COMMENT 'S16 Plan Plies\r\n',
  `p_s18` int(11) NOT NULL COMMENT 'S18 Plan Plies\r\n',
  `p_s20` int(11) NOT NULL COMMENT 'S20 Plan Plies\r\n',
  `p_s22` int(11) NOT NULL COMMENT 'S22 Plan Plies\r\n',
  `p_s24` int(11) NOT NULL COMMENT 'S24 Plan Plies\r\n',
  `p_s26` int(11) NOT NULL COMMENT 'S26 Plan Plies\r\n',
  `p_s28` int(11) NOT NULL COMMENT 'S28 Plan Plies\r\n',
  `p_s30` int(11) NOT NULL COMMENT 'S30 Plan Plies\r\n',
  `rm_date` datetime DEFAULT NULL COMMENT 'RM update date\r\n',
  `cut_inp_temp` int(11) DEFAULT NULL COMMENT 'Cutting Partial Input Status\r\n',
  `plan_module` varchar(10) DEFAULT NULL COMMENT 'Planned Module\r\n',
  `fabric_status` smallint(6) NOT NULL COMMENT 'Fabric Issue Status\r\n',
  `plan_lot_ref` text NOT NULL COMMENT 'Issued Lot details\r\n',
  `log_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Last Updated',
  `destination` varchar(10) NOT NULL COMMENT 'destiantion',
  `docket_printed_person` varchar(20) NOT NULL,
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`),
  KEY `act_cut_issue_status` (`act_cut_issue_status`),
  KEY `act_cut_issue_status1` (`act_cut_status`),
  KEY `act_cut_status` (`act_cut_status`,`act_cut_issue_status`),
  KEY `date` (`date`,`cat_ref`,`p_plies`,`a_plies`),
  KEY `doc_no_ref` (`doc_no`),
  KEY `order_tid` (`order_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log_cat_log_ref_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`plandoc_stat_log_cat_log_ref_temp`;

CREATE TABLE `bai_pro3`.`plandoc_stat_log_cat_log_ref_temp` (
  `order_del_no` bigint(20) DEFAULT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `act_cut_status` varchar(20) DEFAULT NULL,
  `doc_total` bigint(20) DEFAULT NULL,
  `act_cut_issue_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log_delete` */

DROP TABLE IF EXISTS `bai_pro3`.`plandoc_stat_log_delete`;

CREATE TABLE `bai_pro3`.`plandoc_stat_log_delete` (
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cuttable_ref` int(11) NOT NULL,
  `allocate_ref` int(11) NOT NULL,
  `mk_ref` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `pcutno` int(11) NOT NULL,
  `ratio` int(11) NOT NULL,
  `p_xs` int(11) NOT NULL,
  `p_s` int(11) NOT NULL,
  `p_m` int(11) NOT NULL,
  `p_l` int(11) NOT NULL,
  `p_xl` int(11) NOT NULL,
  `p_xxl` int(11) NOT NULL,
  `p_xxxl` int(11) NOT NULL,
  `p_plies` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL,
  `acutno` int(11) NOT NULL,
  `a_xs` int(11) NOT NULL,
  `a_s` int(11) NOT NULL,
  `a_m` int(11) NOT NULL,
  `a_l` int(11) NOT NULL,
  `a_xl` int(11) NOT NULL,
  `a_xxl` int(11) NOT NULL,
  `a_xxxl` int(11) NOT NULL,
  `a_plies` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `act_cut_status` varchar(50) NOT NULL,
  `act_cut_issue_status` varchar(50) NOT NULL,
  `pcutdocid` varchar(200) NOT NULL,
  `print_status` date DEFAULT NULL,
  `a_s06` int(11) NOT NULL,
  `a_s08` int(11) NOT NULL,
  `a_s10` int(11) NOT NULL,
  `a_s12` int(11) NOT NULL,
  `a_s14` int(11) NOT NULL,
  `a_s16` int(11) NOT NULL,
  `a_s18` int(11) NOT NULL,
  `a_s20` int(11) NOT NULL,
  `a_s22` int(11) NOT NULL,
  `a_s24` int(11) NOT NULL,
  `a_s26` int(11) NOT NULL,
  `a_s28` int(11) NOT NULL,
  `a_s30` int(11) NOT NULL,
  `p_s06` int(11) NOT NULL,
  `p_s08` int(11) NOT NULL,
  `p_s10` int(11) NOT NULL,
  `p_s12` int(11) NOT NULL,
  `p_s14` int(11) NOT NULL,
  `p_s16` int(11) NOT NULL,
  `p_s18` int(11) NOT NULL,
  `p_s20` int(11) NOT NULL,
  `p_s22` int(11) NOT NULL,
  `p_s24` int(11) NOT NULL,
  `p_s26` int(11) NOT NULL,
  `p_s28` int(11) NOT NULL,
  `p_s30` int(11) NOT NULL,
  `rm_date` datetime DEFAULT NULL,
  `cut_inp_temp` int(11) DEFAULT NULL,
  `plan_module` int(11) DEFAULT NULL,
  `fabric_status` smallint(6) NOT NULL,
  `plan_lot_ref` text DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `d_time` datetime DEFAULT NULL,
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log_sch_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`plandoc_stat_log_sch_temp`;

CREATE TABLE `bai_pro3`.`plandoc_stat_log_sch_temp` (
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cuttable_ref` int(11) NOT NULL,
  `allocate_ref` int(11) NOT NULL,
  `mk_ref` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `pcutno` int(11) NOT NULL,
  `ratio` int(11) NOT NULL,
  `p_xs` int(11) NOT NULL,
  `p_s` int(11) NOT NULL,
  `p_m` int(11) NOT NULL,
  `p_l` int(11) NOT NULL,
  `p_xl` int(11) NOT NULL,
  `p_xxl` int(11) NOT NULL,
  `p_xxxl` int(11) NOT NULL,
  `p_plies` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL AUTO_INCREMENT,
  `acutno` int(11) NOT NULL,
  `a_xs` int(11) NOT NULL,
  `a_s` int(11) NOT NULL,
  `a_m` int(11) NOT NULL,
  `a_l` int(11) NOT NULL,
  `a_xl` int(11) NOT NULL,
  `a_xxl` int(11) NOT NULL,
  `a_xxxl` int(11) NOT NULL,
  `a_plies` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `act_cut_status` varchar(50) NOT NULL,
  `act_cut_issue_status` varchar(50) NOT NULL,
  `pcutdocid` varchar(200) NOT NULL,
  `print_status` date DEFAULT NULL,
  `a_s01` int(11) NOT NULL COMMENT 's01 Actual Plies',
  `a_s02` int(11) NOT NULL COMMENT 's02 Actual Plies',
  `a_s03` int(11) NOT NULL COMMENT 's03 Actual Plies',
  `a_s04` int(11) NOT NULL COMMENT 's04 Actual Plies',
  `a_s05` int(11) NOT NULL COMMENT 's05 Actual Plies',
  `a_s06` int(11) NOT NULL COMMENT 's06 Actual \n\nPlies',
  `a_s07` int(11) NOT NULL COMMENT 's07 Actual Plies',
  `a_s08` int(11) NOT NULL COMMENT 's08 Actual Plies',
  `a_s09` int(11) NOT NULL COMMENT 's09 Actual Plies',
  `a_s10` int(11) NOT NULL COMMENT 's10 Actual Plies',
  `a_s11` int(11) NOT NULL COMMENT 's11 Actual Plies',
  `a_s12` int(11) NOT NULL COMMENT 's12 Actual Plies',
  `a_s13` int(11) NOT NULL COMMENT 's13 Actual Plies',
  `a_s14` int(11) NOT NULL COMMENT 's14 Actual Plies',
  `a_s15` int(11) NOT NULL COMMENT 's15 Actual Plies',
  `a_s16` int(11) NOT NULL COMMENT 's16 Actual Plies',
  `a_s17` int(11) NOT NULL COMMENT 's17 Actual \n\nPlies',
  `a_s18` int(11) NOT NULL COMMENT 's18 Actual Plies',
  `a_s19` int(11) NOT NULL COMMENT 's19 Actual Plies',
  `a_s20` int(11) NOT NULL COMMENT 's20 Actual Plies',
  `a_s21` int(11) NOT NULL COMMENT 's21 Actual Plies',
  `a_s22` int(11) NOT NULL COMMENT 's22 Actual Plies',
  `a_s23` int(11) NOT NULL COMMENT 's23 Actual Plies',
  `a_s24` int(11) NOT NULL COMMENT 's24 Actual Plies',
  `a_s25` int(11) NOT NULL COMMENT 's25 Actual Plies',
  `a_s26` int(11) NOT NULL COMMENT 's26 Actual Plies',
  `a_s27` int(11) NOT NULL COMMENT 's27 Actual Plies',
  `a_s28` int(11) NOT NULL COMMENT 's28 Actual \n\nPlies',
  `a_s29` int(11) NOT NULL COMMENT 's29 Actual Plies',
  `a_s30` int(11) NOT NULL COMMENT 's30 Actual Plies',
  `a_s31` int(11) NOT NULL COMMENT 's31 Actual Plies',
  `a_s32` int(11) NOT NULL COMMENT 's32 Actual Plies',
  `a_s33` int(11) NOT NULL COMMENT 's33 Actual Plies',
  `a_s34` int(11) NOT NULL COMMENT 's34 Actual Plies',
  `a_s35` int(11) NOT NULL COMMENT 's35 Actual Plies',
  `a_s36` int(11) NOT NULL COMMENT 's36 Actual Plies',
  `a_s37` int(11) NOT NULL COMMENT 's37 Actual Plies',
  `a_s38` int(11) NOT NULL COMMENT 's38 Actual Plies',
  `a_s39` int(11) NOT NULL COMMENT 's39 Actual \n\nPlies',
  `a_s40` int(11) NOT NULL COMMENT 's40 Actual Plies',
  `a_s41` int(11) NOT NULL COMMENT 's41 Actual Plies',
  `a_s42` int(11) NOT NULL COMMENT 's42 Actual Plies',
  `a_s43` int(11) NOT NULL COMMENT 's43 Actual Plies',
  `a_s44` int(11) NOT NULL COMMENT 's44 Actual Plies',
  `a_s45` int(11) NOT NULL COMMENT 's45 Actual Plies',
  `a_s46` int(11) NOT NULL COMMENT 's46 Actual Plies',
  `a_s47` int(11) NOT NULL COMMENT 's47 Actual Plies',
  `a_s48` int(11) NOT NULL COMMENT 's48 Actual Plies',
  `a_s49` int(11) NOT NULL COMMENT 's49 Actual Plies',
  `a_s50` int(11) NOT NULL COMMENT 's50 Actual \n\nPlies',
  `p_s01` int(11) NOT NULL COMMENT 's01 Plan Plies',
  `p_s02` int(11) NOT NULL COMMENT 's02 Plan Plies',
  `p_s03` int(11) NOT NULL COMMENT 's03 Plan Plies',
  `p_s04` int(11) NOT NULL COMMENT 's04 Plan Plies',
  `p_s05` int(11) NOT NULL COMMENT 's05 Plan Plies',
  `p_s06` int(11) NOT NULL COMMENT 's06 Plan Plies',
  `p_s07` int(11) NOT NULL COMMENT 's07 Plan Plies',
  `p_s08` int(11) NOT NULL COMMENT 's08 Plan Plies',
  `p_s09` int(11) NOT NULL COMMENT 's09 Plan Plies',
  `p_s10` int(11) NOT NULL COMMENT 's10 Plan Plies',
  `p_s11` int(11) NOT NULL COMMENT 's11 Plan Plies',
  `p_s12` int(11) NOT NULL COMMENT 's12 Plan Plies',
  `p_s13` int(11) NOT NULL COMMENT 's13 Plan Plies',
  `p_s14` int(11) NOT NULL COMMENT 's14 Plan Plies',
  `p_s15` int(11) NOT NULL COMMENT 's15 Plan Plies',
  `p_s16` int(11) NOT NULL COMMENT 's16 Plan Plies',
  `p_s17` int(11) NOT NULL COMMENT 's17 Plan \n\nPlies',
  `p_s18` int(11) NOT NULL COMMENT 's18 Plan Plies',
  `p_s19` int(11) NOT NULL COMMENT 's19 Plan Plies',
  `p_s20` int(11) NOT NULL COMMENT 's20 Plan Plies',
  `p_s21` int(11) NOT NULL COMMENT 's21 Plan Plies',
  `p_s22` int(11) NOT NULL COMMENT 's22 Plan Plies',
  `p_s23` int(11) NOT NULL COMMENT 's23 Plan Plies',
  `p_s24` int(11) NOT NULL COMMENT 's24 Plan Plies',
  `p_s25` int(11) NOT NULL COMMENT 's25 Plan Plies',
  `p_s26` int(11) NOT NULL COMMENT 's26 Plan Plies',
  `p_s27` int(11) NOT NULL COMMENT 's27 Plan Plies',
  `p_s28` int(11) NOT NULL COMMENT 's28 Plan Plies',
  `p_s29` int(11) NOT NULL COMMENT 's29 Plan Plies',
  `p_s30` int(11) NOT NULL COMMENT 's30 Plan Plies',
  `p_s31` int(11) NOT NULL COMMENT 's31 Plan Plies',
  `p_s32` int(11) NOT NULL COMMENT 's32 Plan Plies',
  `p_s33` int(11) NOT NULL COMMENT 's33 Plan Plies',
  `p_s34` int(11) NOT NULL COMMENT 's34 Plan \n\nPlies',
  `p_s35` int(11) NOT NULL COMMENT 's35 Plan Plies',
  `p_s36` int(11) NOT NULL COMMENT 's36 Plan Plies',
  `p_s37` int(11) NOT NULL COMMENT 's37 Plan Plies',
  `p_s38` int(11) NOT NULL COMMENT 's38 Plan Plies',
  `p_s39` int(11) NOT NULL COMMENT 's39 Plan Plies',
  `p_s40` int(11) NOT NULL COMMENT 's40 Plan Plies',
  `p_s41` int(11) NOT NULL COMMENT 's41 Plan Plies',
  `p_s42` int(11) NOT NULL COMMENT 's42 Plan Plies',
  `p_s43` int(11) NOT NULL COMMENT 's43 Plan Plies',
  `p_s44` int(11) NOT NULL COMMENT 's44 Plan Plies',
  `p_s45` int(11) NOT NULL COMMENT 's45 Plan Plies',
  `p_s46` int(11) NOT NULL COMMENT 's46 Plan Plies',
  `p_s47` int(11) NOT NULL COMMENT 's47 Plan Plies',
  `p_s48` int(11) NOT NULL COMMENT 's48 Plan Plies',
  `p_s49` int(11) NOT NULL COMMENT 's49 Plan Plies',
  `p_s50` int(11) NOT NULL COMMENT 's50 Plan Plies',
  `rm_date` datetime DEFAULT NULL,
  `cut_inp_temp` int(11) DEFAULT NULL,
  `plan_module` varchar(8) DEFAULT NULL,
  `fabric_status` smallint(6) NOT NULL,
  `plan_lot_ref` tinytext NOT NULL,
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `printed_job_sheet` */

DROP TABLE IF EXISTS `bai_pro3`.`printed_job_sheet`;

CREATE TABLE `bai_pro3`.`printed_job_sheet` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(20) DEFAULT NULL,
  `printed_time` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`),
  KEY `doc_no` (`doc_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `pro_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`pro_stat_log`;

CREATE TABLE `bai_pro3`.`pro_stat_log` (
  `pro_order_tid` varchar(200) NOT NULL,
  `pro_s_xs` int(50) NOT NULL,
  `pro_s_s` int(50) NOT NULL,
  `pro_s_m` int(50) NOT NULL,
  `pro_s_l` int(50) NOT NULL,
  `pro_s_xl` int(50) NOT NULL,
  `pro_s_xxl` int(50) NOT NULL,
  `pro_s_xxxl` int(50) NOT NULL,
  `pro_up_date` datetime NOT NULL,
  `pro_remarks` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ratio_input_update` */

DROP TABLE IF EXISTS `bai_pro3`.`ratio_input_update`;

CREATE TABLE `bai_pro3`.`ratio_input_update` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'tid reference',
  `style` varchar(60) NOT NULL,
  `schedule` varchar(60) NOT NULL,
  `color` varchar(60) NOT NULL,
  `size` varchar(60) NOT NULL,
  `ratio_qty` varchar(30) NOT NULL,
  `username` varchar(60) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rand_track_no` varchar(60) NOT NULL,
  `order_tid` varchar(60) NOT NULL,
  `set_type` varchar(45) NOT NULL COMMENT 'identify size set',
  `sfcs_size` varchar(45) NOT NULL COMMENT 'sfcs size',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `recut_ims_log` */

DROP TABLE IF EXISTS `bai_pro3`.`recut_ims_log`;

CREATE TABLE `bai_pro3`.`recut_ims_log` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `recut_ims_log_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`recut_ims_log_backup`;

CREATE TABLE `bai_pro3`.`recut_ims_log_backup` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL,
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `recut_track` */

DROP TABLE IF EXISTS `bai_pro3`.`recut_track`;

CREATE TABLE `bai_pro3`.`recut_track` (
  `doc_no` double DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `sys_name` varchar(50) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `recut_v1` */

DROP TABLE IF EXISTS `bai_pro3`.`recut_v1`;

CREATE TABLE `bai_pro3`.`recut_v1` (
  `rec_doc_no` int(11) NOT NULL AUTO_INCREMENT,
  `rec_order_tid` varchar(500) NOT NULL,
  `cat_ref` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `rec_cut_no` int(11) NOT NULL,
  `print_stat` int(11) NOT NULL,
  `q_xs` int(11) NOT NULL,
  `q_s` int(11) NOT NULL,
  `q_m` int(11) NOT NULL,
  `q_l` int(11) NOT NULL,
  `q_xl` int(11) NOT NULL,
  `q_xxl` int(11) NOT NULL,
  `q_xxxl` int(11) NOT NULL,
  `q_yds` float NOT NULL,
  `act_cut_issue_status` varchar(50) NOT NULL,
  `q_s01` int(11) NOT NULL COMMENT 'qms size s01',
  `q_s02` int(11) NOT NULL COMMENT 'qms size s02',
  `q_s03` int(11) NOT NULL COMMENT 'qms size s03',
  `q_s04` int(11) NOT NULL COMMENT 'qms size s04',
  `q_s05` int(11) NOT NULL COMMENT 'qms size s05',
  `q_s06` int(11) NOT NULL COMMENT 'qms size s06',
  `q_s07` int(11) NOT NULL COMMENT 'qms size s07',
  `q_s08` int(11) NOT NULL COMMENT 'qms size s08',
  `q_s09` int(11) NOT NULL COMMENT 'qms size s09',
  `q_s10` int(11) NOT NULL COMMENT 'qms size \n\ns10',
  `q_s11` int(11) NOT NULL COMMENT 'qms size s11',
  `q_s12` int(11) NOT NULL COMMENT 'qms size s12',
  `q_s13` int(11) NOT NULL COMMENT 'qms \n\nsize s13',
  `q_s14` int(11) NOT NULL COMMENT 'qms size s14',
  `q_s15` int(11) NOT NULL COMMENT 'qms size s15',
  `q_s16` int(11) NOT NULL COMMENT 'qms size s16',
  `q_s17` int(11) NOT NULL COMMENT 'qms size s17',
  `q_s18` int(11) NOT NULL COMMENT 'qms size s18',
  `q_s19` int(11) NOT NULL COMMENT 'qms size s19',
  `q_s20` int(11) NOT NULL COMMENT 'qms size s20',
  `q_s21` int(11) NOT NULL COMMENT 'qms size s21',
  `q_s22` int(11) NOT NULL COMMENT 'qms size s22',
  `q_s23` int(11) NOT NULL COMMENT 'qms size s23',
  `q_s24` int(11) NOT NULL COMMENT 'qms size s24',
  `q_s25` int(11) NOT NULL COMMENT 'qms size s25',
  `q_s26` int(11) NOT NULL COMMENT 'qms size s26',
  `q_s27` int(11) NOT NULL COMMENT 'qms size s27',
  `q_s28` int(11) NOT NULL COMMENT 'qms size s28',
  `q_s29` int(11) NOT NULL COMMENT 'qms size s29',
  `q_s30` int(11) NOT NULL COMMENT 'qms size s30',
  `q_s31` int(11) NOT NULL COMMENT 'qms size s31',
  `q_s32` int(11) NOT NULL COMMENT 'qms size s32',
  `q_s33` int(11) NOT NULL COMMENT 'qms size s33',
  `q_s34` int(11) NOT NULL COMMENT 'qms size s34',
  `q_s35` int(11) NOT NULL COMMENT 'qms size s35',
  `q_s36` int(11) NOT NULL COMMENT 'qms size \n\ns36',
  `q_s37` int(11) NOT NULL COMMENT 'qms size s37',
  `q_s38` int(11) NOT NULL COMMENT 'qms size s38',
  `q_s39` int(11) NOT NULL COMMENT 'qms \n\nsize s39',
  `q_s40` int(11) NOT NULL COMMENT 'qms size s40',
  `q_s41` int(11) NOT NULL COMMENT 'qms size s41',
  `q_s42` int(11) NOT NULL COMMENT 'qms size s42',
  `q_s43` int(11) NOT NULL COMMENT 'qms size s43',
  `q_s44` int(11) NOT NULL COMMENT 'qms size s44',
  `q_s45` int(11) NOT NULL COMMENT 'qms size s45',
  `q_s46` int(11) NOT NULL COMMENT 'qms size s46',
  `q_s47` int(11) NOT NULL COMMENT 'qms size s47',
  `q_s48` int(11) NOT NULL COMMENT 'qms size s48',
  `q_s49` int(11) NOT NULL COMMENT 'qms size s49',
  `q_s50` int(11) NOT NULL COMMENT 'qms size s50',
  `module` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`rec_doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `recut_v2` */

DROP TABLE IF EXISTS `bai_pro3`.`recut_v2`;

CREATE TABLE `bai_pro3`.`recut_v2` (
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cuttable_ref` int(11) NOT NULL,
  `allocate_ref` int(11) NOT NULL,
  `mk_ref` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `pcutno` int(11) NOT NULL,
  `ratio` int(11) NOT NULL,
  `p_xs` int(11) NOT NULL,
  `p_s` int(11) NOT NULL,
  `p_m` int(11) NOT NULL,
  `p_l` int(11) NOT NULL,
  `p_xl` int(11) NOT NULL,
  `p_xxl` int(11) NOT NULL,
  `p_xxxl` int(11) NOT NULL,
  `p_plies` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL AUTO_INCREMENT,
  `acutno` int(11) NOT NULL,
  `a_xs` int(11) NOT NULL,
  `a_s` int(11) NOT NULL,
  `a_m` int(11) NOT NULL,
  `a_l` int(11) NOT NULL,
  `a_xl` int(11) NOT NULL,
  `a_xxl` int(11) NOT NULL,
  `a_xxxl` int(11) NOT NULL,
  `a_plies` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `act_cut_status` varchar(50) NOT NULL,
  `act_cut_issue_status` varchar(50) NOT NULL,
  `pcutdocid` varchar(200) NOT NULL,
  `print_status` date DEFAULT NULL,
  `a_s01` int(11) NOT NULL COMMENT 's01 Actual Plies',
  `a_s02` int(11) NOT NULL COMMENT 's02 Actual Plies',
  `a_s03` int(11) NOT NULL COMMENT 's03 Actual Plies',
  `a_s04` int(11) NOT NULL COMMENT 's04 Actual Plies',
  `a_s05` int(11) NOT NULL COMMENT 's05 Actual Plies',
  `a_s06` int(11) NOT NULL COMMENT 's06 Actual \n\nPlies',
  `a_s07` int(11) NOT NULL COMMENT 's07 Actual Plies',
  `a_s08` int(11) NOT NULL COMMENT 's08 Actual Plies',
  `a_s09` int(11) NOT NULL COMMENT 's09 Actual Plies',
  `a_s10` int(11) NOT NULL COMMENT 's10 Actual Plies',
  `a_s11` int(11) NOT NULL COMMENT 's11 Actual Plies',
  `a_s12` int(11) NOT NULL COMMENT 's12 Actual Plies',
  `a_s13` int(11) NOT NULL COMMENT 's13 Actual Plies',
  `a_s14` int(11) NOT NULL COMMENT 's14 Actual Plies',
  `a_s15` int(11) NOT NULL COMMENT 's15 Actual Plies',
  `a_s16` int(11) NOT NULL COMMENT 's16 Actual Plies',
  `a_s17` int(11) NOT NULL COMMENT 's17 Actual \n\nPlies',
  `a_s18` int(11) NOT NULL COMMENT 's18 Actual Plies',
  `a_s19` int(11) NOT NULL COMMENT 's19 Actual Plies',
  `a_s20` int(11) NOT NULL COMMENT 's20 Actual Plies',
  `a_s21` int(11) NOT NULL COMMENT 's21 Actual Plies',
  `a_s22` int(11) NOT NULL COMMENT 's22 Actual Plies',
  `a_s23` int(11) NOT NULL COMMENT 's23 Actual Plies',
  `a_s24` int(11) NOT NULL COMMENT 's24 Actual Plies',
  `a_s25` int(11) NOT NULL COMMENT 's25 Actual Plies',
  `a_s26` int(11) NOT NULL COMMENT 's26 Actual Plies',
  `a_s27` int(11) NOT NULL COMMENT 's27 Actual Plies',
  `a_s28` int(11) NOT NULL COMMENT 's28 Actual \n\nPlies',
  `a_s29` int(11) NOT NULL COMMENT 's29 Actual Plies',
  `a_s30` int(11) NOT NULL COMMENT 's30 Actual Plies',
  `a_s31` int(11) NOT NULL COMMENT 's31 Actual Plies',
  `a_s32` int(11) NOT NULL COMMENT 's32 Actual Plies',
  `a_s33` int(11) NOT NULL COMMENT 's33 Actual Plies',
  `a_s34` int(11) NOT NULL COMMENT 's34 Actual Plies',
  `a_s35` int(11) NOT NULL COMMENT 's35 Actual Plies',
  `a_s36` int(11) NOT NULL COMMENT 's36 Actual Plies',
  `a_s37` int(11) NOT NULL COMMENT 's37 Actual Plies',
  `a_s38` int(11) NOT NULL COMMENT 's38 Actual Plies',
  `a_s39` int(11) NOT NULL COMMENT 's39 Actual \n\nPlies',
  `a_s40` int(11) NOT NULL COMMENT 's40 Actual Plies',
  `a_s41` int(11) NOT NULL COMMENT 's41 Actual Plies',
  `a_s42` int(11) NOT NULL COMMENT 's42 Actual Plies',
  `a_s43` int(11) NOT NULL COMMENT 's43 Actual Plies',
  `a_s44` int(11) NOT NULL COMMENT 's44 Actual Plies',
  `a_s45` int(11) NOT NULL COMMENT 's45 Actual Plies',
  `a_s46` int(11) NOT NULL COMMENT 's46 Actual Plies',
  `a_s47` int(11) NOT NULL COMMENT 's47 Actual Plies',
  `a_s48` int(11) NOT NULL COMMENT 's48 Actual Plies',
  `a_s49` int(11) NOT NULL COMMENT 's49 Actual Plies',
  `a_s50` int(11) NOT NULL COMMENT 's50 Actual \n\nPlies',
  `p_s01` int(11) NOT NULL COMMENT 's01 Plan Plies',
  `p_s02` int(11) NOT NULL COMMENT 's02 Plan Plies',
  `p_s03` int(11) NOT NULL COMMENT 's03 Plan Plies',
  `p_s04` int(11) NOT NULL COMMENT 's04 Plan Plies',
  `p_s05` int(11) NOT NULL COMMENT 's05 Plan Plies',
  `p_s06` int(11) NOT NULL COMMENT 's06 Plan Plies',
  `p_s07` int(11) NOT NULL COMMENT 's07 Plan Plies',
  `p_s08` int(11) NOT NULL COMMENT 's08 Plan Plies',
  `p_s09` int(11) NOT NULL COMMENT 's09 Plan Plies',
  `p_s10` int(11) NOT NULL COMMENT 's10 Plan Plies',
  `p_s11` int(11) NOT NULL COMMENT 's11 Plan Plies',
  `p_s12` int(11) NOT NULL COMMENT 's12 Plan Plies',
  `p_s13` int(11) NOT NULL COMMENT 's13 Plan Plies',
  `p_s14` int(11) NOT NULL COMMENT 's14 Plan Plies',
  `p_s15` int(11) NOT NULL COMMENT 's15 Plan Plies',
  `p_s16` int(11) NOT NULL COMMENT 's16 Plan Plies',
  `p_s17` int(11) NOT NULL COMMENT 's17 Plan \n\nPlies',
  `p_s18` int(11) NOT NULL COMMENT 's18 Plan Plies',
  `p_s19` int(11) NOT NULL COMMENT 's19 Plan Plies',
  `p_s20` int(11) NOT NULL COMMENT 's20 Plan Plies',
  `p_s21` int(11) NOT NULL COMMENT 's21 Plan Plies',
  `p_s22` int(11) NOT NULL COMMENT 's22 Plan Plies',
  `p_s23` int(11) NOT NULL COMMENT 's23 Plan Plies',
  `p_s24` int(11) NOT NULL COMMENT 's24 Plan Plies',
  `p_s25` int(11) NOT NULL COMMENT 's25 Plan Plies',
  `p_s26` int(11) NOT NULL COMMENT 's26 Plan Plies',
  `p_s27` int(11) NOT NULL COMMENT 's27 Plan Plies',
  `p_s28` int(11) NOT NULL COMMENT 's28 Plan Plies',
  `p_s29` int(11) NOT NULL COMMENT 's29 Plan Plies',
  `p_s30` int(11) NOT NULL COMMENT 's30 Plan Plies',
  `p_s31` int(11) NOT NULL COMMENT 's31 Plan Plies',
  `p_s32` int(11) NOT NULL COMMENT 's32 Plan Plies',
  `p_s33` int(11) NOT NULL COMMENT 's33 Plan Plies',
  `p_s34` int(11) NOT NULL COMMENT 's34 Plan \n\nPlies',
  `p_s35` int(11) NOT NULL COMMENT 's35 Plan Plies',
  `p_s36` int(11) NOT NULL COMMENT 's36 Plan Plies',
  `p_s37` int(11) NOT NULL COMMENT 's37 Plan Plies',
  `p_s38` int(11) NOT NULL COMMENT 's38 Plan Plies',
  `p_s39` int(11) NOT NULL COMMENT 's39 Plan Plies',
  `p_s40` int(11) NOT NULL COMMENT 's40 Plan Plies',
  `p_s41` int(11) NOT NULL COMMENT 's41 Plan Plies',
  `p_s42` int(11) NOT NULL COMMENT 's42 Plan Plies',
  `p_s43` int(11) NOT NULL COMMENT 's43 Plan Plies',
  `p_s44` int(11) NOT NULL COMMENT 's44 Plan Plies',
  `p_s45` int(11) NOT NULL COMMENT 's45 Plan Plies',
  `p_s46` int(11) NOT NULL COMMENT 's46 Plan Plies',
  `p_s47` int(11) NOT NULL COMMENT 's47 Plan Plies',
  `p_s48` int(11) NOT NULL COMMENT 's48 Plan Plies',
  `p_s49` int(11) NOT NULL COMMENT 's49 Plan Plies',
  `p_s50` int(11) NOT NULL COMMENT 's50 Plan Plies',
  `rm_date` datetime DEFAULT NULL,
  `cut_inp_temp` int(11) DEFAULT NULL,
  `plan_module` varchar(5) DEFAULT NULL,
  `fabric_status` smallint(6) NOT NULL,
  `plan_lot_ref` text NOT NULL,
  `log_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`),
  KEY `plan_module` (`plan_module`),
  KEY `act_cut_status` (`act_cut_status`,`act_cut_issue_status`),
  KEY `act_cut_issue_status1` (`act_cut_status`),
  KEY `act_cut_issue_status` (`act_cut_issue_status`),
  KEY `order_tid` (`order_tid`),
  KEY `date` (`date`,`cat_ref`,`p_plies`,`a_plies`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `recut_v2_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`recut_v2_archive`;

CREATE TABLE `bai_pro3`.`recut_v2_archive` (
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cuttable_ref` int(11) NOT NULL,
  `allocate_ref` int(11) NOT NULL,
  `mk_ref` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `pcutno` int(11) NOT NULL,
  `ratio` int(11) NOT NULL,
  `p_xs` int(11) NOT NULL,
  `p_s` int(11) NOT NULL,
  `p_m` int(11) NOT NULL,
  `p_l` int(11) NOT NULL,
  `p_xl` int(11) NOT NULL,
  `p_xxl` int(11) NOT NULL,
  `p_xxxl` int(11) NOT NULL,
  `p_plies` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL AUTO_INCREMENT,
  `acutno` int(11) NOT NULL,
  `a_xs` int(11) NOT NULL,
  `a_s` int(11) NOT NULL,
  `a_m` int(11) NOT NULL,
  `a_l` int(11) NOT NULL,
  `a_xl` int(11) NOT NULL,
  `a_xxl` int(11) NOT NULL,
  `a_xxxl` int(11) NOT NULL,
  `a_plies` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `act_cut_status` varchar(50) NOT NULL,
  `act_cut_issue_status` varchar(50) NOT NULL,
  `pcutdocid` varchar(200) NOT NULL,
  `print_status` date DEFAULT NULL,
  `a_s01` int(11) NOT NULL COMMENT 's01 Actual Plies',
  `a_s02` int(11) NOT NULL COMMENT 's02 Actual Plies',
  `a_s03` int(11) NOT NULL COMMENT 's03 Actual Plies',
  `a_s04` int(11) NOT NULL COMMENT 's04 Actual Plies',
  `a_s05` int(11) NOT NULL COMMENT 's05 Actual Plies',
  `a_s06` int(11) NOT NULL COMMENT 's06 Actual \n\nPlies',
  `a_s07` int(11) NOT NULL COMMENT 's07 Actual Plies',
  `a_s08` int(11) NOT NULL COMMENT 's08 Actual Plies',
  `a_s09` int(11) NOT NULL COMMENT 's09 Actual Plies',
  `a_s10` int(11) NOT NULL COMMENT 's10 Actual Plies',
  `a_s11` int(11) NOT NULL COMMENT 's11 Actual Plies',
  `a_s12` int(11) NOT NULL COMMENT 's12 Actual Plies',
  `a_s13` int(11) NOT NULL COMMENT 's13 Actual Plies',
  `a_s14` int(11) NOT NULL COMMENT 's14 Actual Plies',
  `a_s15` int(11) NOT NULL COMMENT 's15 Actual Plies',
  `a_s16` int(11) NOT NULL COMMENT 's16 Actual Plies',
  `a_s17` int(11) NOT NULL COMMENT 's17 Actual \n\nPlies',
  `a_s18` int(11) NOT NULL COMMENT 's18 Actual Plies',
  `a_s19` int(11) NOT NULL COMMENT 's19 Actual Plies',
  `a_s20` int(11) NOT NULL COMMENT 's20 Actual Plies',
  `a_s21` int(11) NOT NULL COMMENT 's21 Actual Plies',
  `a_s22` int(11) NOT NULL COMMENT 's22 Actual Plies',
  `a_s23` int(11) NOT NULL COMMENT 's23 Actual Plies',
  `a_s24` int(11) NOT NULL COMMENT 's24 Actual Plies',
  `a_s25` int(11) NOT NULL COMMENT 's25 Actual Plies',
  `a_s26` int(11) NOT NULL COMMENT 's26 Actual Plies',
  `a_s27` int(11) NOT NULL COMMENT 's27 Actual Plies',
  `a_s28` int(11) NOT NULL COMMENT 's28 Actual \n\nPlies',
  `a_s29` int(11) NOT NULL COMMENT 's29 Actual Plies',
  `a_s30` int(11) NOT NULL COMMENT 's30 Actual Plies',
  `a_s31` int(11) NOT NULL COMMENT 's31 Actual Plies',
  `a_s32` int(11) NOT NULL COMMENT 's32 Actual Plies',
  `a_s33` int(11) NOT NULL COMMENT 's33 Actual Plies',
  `a_s34` int(11) NOT NULL COMMENT 's34 Actual Plies',
  `a_s35` int(11) NOT NULL COMMENT 's35 Actual Plies',
  `a_s36` int(11) NOT NULL COMMENT 's36 Actual Plies',
  `a_s37` int(11) NOT NULL COMMENT 's37 Actual Plies',
  `a_s38` int(11) NOT NULL COMMENT 's38 Actual Plies',
  `a_s39` int(11) NOT NULL COMMENT 's39 Actual \n\nPlies',
  `a_s40` int(11) NOT NULL COMMENT 's40 Actual Plies',
  `a_s41` int(11) NOT NULL COMMENT 's41 Actual Plies',
  `a_s42` int(11) NOT NULL COMMENT 's42 Actual Plies',
  `a_s43` int(11) NOT NULL COMMENT 's43 Actual Plies',
  `a_s44` int(11) NOT NULL COMMENT 's44 Actual Plies',
  `a_s45` int(11) NOT NULL COMMENT 's45 Actual Plies',
  `a_s46` int(11) NOT NULL COMMENT 's46 Actual Plies',
  `a_s47` int(11) NOT NULL COMMENT 's47 Actual Plies',
  `a_s48` int(11) NOT NULL COMMENT 's48 Actual Plies',
  `a_s49` int(11) NOT NULL COMMENT 's49 Actual Plies',
  `a_s50` int(11) NOT NULL COMMENT 's50 Actual \n\nPlies',
  `p_s01` int(11) NOT NULL COMMENT 's01 Plan Plies',
  `p_s02` int(11) NOT NULL COMMENT 's02 Plan Plies',
  `p_s03` int(11) NOT NULL COMMENT 's03 Plan Plies',
  `p_s04` int(11) NOT NULL COMMENT 's04 Plan Plies',
  `p_s05` int(11) NOT NULL COMMENT 's05 Plan Plies',
  `p_s06` int(11) NOT NULL COMMENT 's06 Plan Plies',
  `p_s07` int(11) NOT NULL COMMENT 's07 Plan Plies',
  `p_s08` int(11) NOT NULL COMMENT 's08 Plan Plies',
  `p_s09` int(11) NOT NULL COMMENT 's09 Plan Plies',
  `p_s10` int(11) NOT NULL COMMENT 's10 Plan Plies',
  `p_s11` int(11) NOT NULL COMMENT 's11 Plan Plies',
  `p_s12` int(11) NOT NULL COMMENT 's12 Plan Plies',
  `p_s13` int(11) NOT NULL COMMENT 's13 Plan Plies',
  `p_s14` int(11) NOT NULL COMMENT 's14 Plan Plies',
  `p_s15` int(11) NOT NULL COMMENT 's15 Plan Plies',
  `p_s16` int(11) NOT NULL COMMENT 's16 Plan Plies',
  `p_s17` int(11) NOT NULL COMMENT 's17 Plan \n\nPlies',
  `p_s18` int(11) NOT NULL COMMENT 's18 Plan Plies',
  `p_s19` int(11) NOT NULL COMMENT 's19 Plan Plies',
  `p_s20` int(11) NOT NULL COMMENT 's20 Plan Plies',
  `p_s21` int(11) NOT NULL COMMENT 's21 Plan Plies',
  `p_s22` int(11) NOT NULL COMMENT 's22 Plan Plies',
  `p_s23` int(11) NOT NULL COMMENT 's23 Plan Plies',
  `p_s24` int(11) NOT NULL COMMENT 's24 Plan Plies',
  `p_s25` int(11) NOT NULL COMMENT 's25 Plan Plies',
  `p_s26` int(11) NOT NULL COMMENT 's26 Plan Plies',
  `p_s27` int(11) NOT NULL COMMENT 's27 Plan Plies',
  `p_s28` int(11) NOT NULL COMMENT 's28 Plan Plies',
  `p_s29` int(11) NOT NULL COMMENT 's29 Plan Plies',
  `p_s30` int(11) NOT NULL COMMENT 's30 Plan Plies',
  `p_s31` int(11) NOT NULL COMMENT 's31 Plan Plies',
  `p_s32` int(11) NOT NULL COMMENT 's32 Plan Plies',
  `p_s33` int(11) NOT NULL COMMENT 's33 Plan Plies',
  `p_s34` int(11) NOT NULL COMMENT 's34 Plan \n\nPlies',
  `p_s35` int(11) NOT NULL COMMENT 's35 Plan Plies',
  `p_s36` int(11) NOT NULL COMMENT 's36 Plan Plies',
  `p_s37` int(11) NOT NULL COMMENT 's37 Plan Plies',
  `p_s38` int(11) NOT NULL COMMENT 's38 Plan Plies',
  `p_s39` int(11) NOT NULL COMMENT 's39 Plan Plies',
  `p_s40` int(11) NOT NULL COMMENT 's40 Plan Plies',
  `p_s41` int(11) NOT NULL COMMENT 's41 Plan Plies',
  `p_s42` int(11) NOT NULL COMMENT 's42 Plan Plies',
  `p_s43` int(11) NOT NULL COMMENT 's43 Plan Plies',
  `p_s44` int(11) NOT NULL COMMENT 's44 Plan Plies',
  `p_s45` int(11) NOT NULL COMMENT 's45 Plan Plies',
  `p_s46` int(11) NOT NULL COMMENT 's46 Plan Plies',
  `p_s47` int(11) NOT NULL COMMENT 's47 Plan Plies',
  `p_s48` int(11) NOT NULL COMMENT 's48 Plan Plies',
  `p_s49` int(11) NOT NULL COMMENT 's49 Plan Plies',
  `p_s50` int(11) NOT NULL COMMENT 's50 Plan Plies',
  `rm_date` datetime DEFAULT NULL,
  `cut_inp_temp` int(11) DEFAULT NULL,
  `plan_module` varchar(5) DEFAULT NULL,
  `fabric_status` smallint(6) NOT NULL,
  `plan_lot_ref` text NOT NULL,
  `log_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `rej_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`rej_stat_log`;

CREATE TABLE `bai_pro3`.`rej_stat_log` (
  `rej_order_tid` varchar(200) NOT NULL,
  `rej_s_xs` int(50) NOT NULL,
  `rej_s_s` int(50) NOT NULL,
  `rej_s_m` int(50) NOT NULL,
  `rej_s_l` int(50) NOT NULL,
  `rej_s_xl` int(50) NOT NULL,
  `rej_s_xxl` int(50) NOT NULL,
  `rej_s_xxxl` int(50) NOT NULL,
  `rej_mod` varchar(60) NOT NULL,
  `rej_up_date` datetime NOT NULL,
  `rej_remarks` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `review_print_track` */

DROP TABLE IF EXISTS `bai_pro3`.`review_print_track`;

CREATE TABLE `bai_pro3`.`review_print_track` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `ref_tid` varchar(500) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `log_user` varchar(50) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `scanned_cartons` */

DROP TABLE IF EXISTS `bai_pro3`.`scanned_cartons`;

CREATE TABLE `bai_pro3`.`scanned_cartons` (
  `bid` varchar(45) NOT NULL,
  `style` varchar(45) DEFAULT NULL,
  `schedule` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `input_job_no` varchar(45) DEFAULT NULL,
  `input_job_random` varchar(45) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `scan_time` varchar(45) DEFAULT NULL,
  `module` varchar(45) DEFAULT NULL,
  `doc_no` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `schedule_oprations_master` */

DROP TABLE IF EXISTS `bai_pro3`.`schedule_oprations_master`;

CREATE TABLE `bai_pro3`.`schedule_oprations_master` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `Style` varchar(50) DEFAULT NULL,
  `ScheduleNumber` varchar(50) DEFAULT NULL,
  `ColorId` varchar(200) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `SizeId` varchar(20) DEFAULT NULL,
  `ZFeature` varchar(20) DEFAULT NULL,
  `ZFeatureId` varchar(20) DEFAULT NULL,
  `MONumber` bigint(20) DEFAULT NULL,
  `SMV` decimal(10,2) DEFAULT NULL,
  `OperationDescription` varchar(50) DEFAULT NULL,
  `OperationNumber` int(11) DEFAULT NULL,
  `SequenceNoForSorting` int(11) DEFAULT NULL,
  `WorkCenterId` varchar(25) DEFAULT NULL,
  `Main_OperationNumber` int(11) DEFAULT NULL,
  `Main_WorkCenterId` varchar(25) DEFAULT NULL,
  `Inserted_Time` datetime DEFAULT NULL,
  `Updated_Time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `unique_key` (`MONumber`,`OperationNumber`),
  KEY `style_size` (`Style`,`ScheduleNumber`,`Description`,`SizeId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `schedule_oprations_master_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`schedule_oprations_master_backup`;

CREATE TABLE `bai_pro3`.`schedule_oprations_master_backup` (
  `tid` int(11) DEFAULT NULL,
  `Style` varchar(50) DEFAULT NULL,
  `ScheduleNumber` varchar(50) DEFAULT NULL,
  `ColorId` varchar(200) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `SizeId` varchar(20) DEFAULT NULL,
  `ZFeature` varchar(20) DEFAULT NULL,
  `ZFeatureId` varchar(20) DEFAULT NULL,
  `MONumber` bigint(20) DEFAULT NULL,
  `SMV` decimal(10,2) DEFAULT NULL,
  `OperationDescription` varchar(50) DEFAULT NULL,
  `OperationNumber` int(11) DEFAULT NULL,
  `SequenceNoForSorting` int(11) DEFAULT NULL,
  `WorkCenterId` varchar(25) DEFAULT NULL,
  `Main_OperationNumber` int(11) DEFAULT NULL,
  `Main_WorkCenterId` varchar(25) DEFAULT NULL,
  `Inserted_Time` datetime DEFAULT NULL,
  `Updated_Time` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `NewIndex1` (`Style`,`ScheduleNumber`,`ColorId`,`Description`,`SizeId`,`ZFeature`,`MONumber`,`OperationDescription`,`OperationNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sections_db` */

DROP TABLE IF EXISTS `bai_pro3`.`sections_db`;

CREATE TABLE `bai_pro3`.`sections_db` (
  `sec_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_head` varchar(50) NOT NULL,
  `sec_mods` varchar(500) NOT NULL,
  `password` varchar(10) NOT NULL,
  `qms_pw` varbinary(10) NOT NULL,
  `user_id` varchar(25) DEFAULT NULL,
  `user_id2` varchar(25) DEFAULT NULL,
  `ims_priority_boxes` int(11) NOT NULL,
  `pro_res_a` varchar(25) NOT NULL,
  `pro_res_b` varchar(25) NOT NULL,
  `ie_res_a` varchar(25) NOT NULL,
  `ie_res_b` varchar(25) NOT NULL,
  PRIMARY KEY (`sec_id`),
  KEY `sec_mods` (`sec_mods`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `ship_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`ship_stat_log`;

CREATE TABLE `bai_pro3`.`ship_stat_log` (
  `ship_order_tid` varchar(200) DEFAULT NULL,
  `ship_s_xs` int(50) NOT NULL,
  `ship_s_s` int(50) NOT NULL,
  `ship_s_m` int(50) NOT NULL,
  `ship_s_l` int(50) NOT NULL,
  `ship_s_xl` int(50) NOT NULL,
  `ship_s_xxl` int(50) NOT NULL,
  `ship_s_xxxl` int(50) NOT NULL,
  `ship_up_date` timestamp NULL DEFAULT NULL,
  `ship_remarks` varchar(200) DEFAULT NULL,
  `ship_status` int(11) DEFAULT NULL,
  `ship_style` varchar(100) DEFAULT NULL,
  `ship_schedule` varchar(100) DEFAULT NULL,
  `ship_s_s01` int(11) NOT NULL COMMENT 'ship size s01',
  `ship_s_s02` int(11) NOT NULL COMMENT 'ship size s02',
  `ship_s_s03` int(11) NOT NULL COMMENT 'ship size s03',
  `ship_s_s04` int(11) NOT NULL COMMENT 'ship size s04',
  `ship_s_s05` int(11) NOT NULL COMMENT 'ship size s05',
  `ship_s_s06` int(11) NOT NULL COMMENT 'ship size s06',
  `ship_s_s07` int(11) NOT NULL COMMENT 'ship size s07',
  `ship_s_s08` int(11) NOT NULL COMMENT 'ship size s08',
  `ship_s_s09` int(11) NOT NULL COMMENT 'ship size s09',
  `ship_s_s10` int(11) NOT NULL COMMENT 'ship size s10',
  `ship_s_s11` int(11) NOT NULL COMMENT 'ship size s11',
  `ship_s_s12` int(11) NOT NULL COMMENT 'ship size s12',
  `ship_s_s13` int(11) NOT NULL COMMENT 'ship size s13',
  `ship_s_s14` int(11) NOT NULL COMMENT 'ship size s14',
  `ship_s_s15` int(11) NOT NULL COMMENT 'ship size s15',
  `ship_s_s16` int(11) NOT NULL COMMENT 'ship size s16',
  `ship_s_s17` int(11) NOT NULL COMMENT 'ship size s17',
  `ship_s_s18` int(11) NOT NULL COMMENT 'ship size s18',
  `ship_s_s19` int(11) NOT NULL COMMENT 'ship size s19',
  `ship_s_s20` int(11) NOT NULL COMMENT 'ship size s20',
  `ship_s_s21` int(11) NOT NULL COMMENT 'ship size s21',
  `ship_s_s22` int(11) NOT NULL COMMENT 'ship size s22',
  `ship_s_s23` int(11) NOT NULL COMMENT 'ship size s23',
  `ship_s_s24` int(11) NOT NULL COMMENT 'ship size s24',
  `ship_s_s25` int(11) NOT NULL COMMENT 'ship size s25',
  `ship_s_s26` int(11) NOT NULL COMMENT 'ship size s26',
  `ship_s_s27` int(11) NOT NULL COMMENT 'ship size s27',
  `ship_s_s28` int(11) NOT NULL COMMENT 'ship size s28',
  `ship_s_s29` int(11) NOT NULL COMMENT 'ship size s29',
  `ship_s_s30` int(11) NOT NULL COMMENT 'ship size s30',
  `ship_s_s31` int(11) NOT NULL COMMENT 'ship size s31',
  `ship_s_s32` int(11) NOT NULL COMMENT 'ship size s32',
  `ship_s_s33` int(11) NOT NULL COMMENT 'ship size s33',
  `ship_s_s34` int(11) NOT NULL COMMENT 'ship size s34',
  `ship_s_s35` int(11) NOT NULL COMMENT 'ship size s35',
  `ship_s_s36` int(11) NOT NULL COMMENT 'ship size s36',
  `ship_s_s37` int(11) NOT NULL COMMENT 'ship size s37',
  `ship_s_s38` int(11) NOT NULL COMMENT 'ship size s38',
  `ship_s_s39` int(11) NOT NULL COMMENT 'ship size s39',
  `ship_s_s40` int(11) NOT NULL COMMENT 'ship size s40',
  `ship_s_s41` int(11) NOT NULL COMMENT 'ship size s41',
  `ship_s_s42` int(11) NOT NULL COMMENT 'ship size s42',
  `ship_s_s43` int(11) NOT NULL COMMENT 'ship size s43',
  `ship_s_s44` int(11) NOT NULL COMMENT 'ship size s44',
  `ship_s_s45` int(11) NOT NULL COMMENT 'ship size s45',
  `ship_s_s46` int(11) NOT NULL COMMENT 'ship size s46',
  `ship_s_s47` int(11) NOT NULL COMMENT 'ship size s47',
  `ship_s_s48` int(11) NOT NULL COMMENT 'ship size s48',
  `ship_s_s49` int(11) NOT NULL COMMENT 'ship size s49',
  `ship_s_s50` int(11) NOT NULL COMMENT 'ship size s50',
  `ship_tid` int(11) NOT NULL AUTO_INCREMENT,
  `ship_cartons` int(11) DEFAULT NULL,
  `disp_note_no` int(11) DEFAULT NULL,
  `last_up` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Last Updated',
  `ship_color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`ship_tid`),
  KEY `ship_schedule` (`ship_schedule`),
  KEY `ship_status` (`ship_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan` */

DROP TABLE IF EXISTS `bai_pro3`.`shipment_plan`;

CREATE TABLE `bai_pro3`.`shipment_plan` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style_no` varchar(200) NOT NULL,
  `schedule_no` varchar(200) NOT NULL,
  `color` varchar(200) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `exfact_date` date NOT NULL,
  `CPO` varchar(200) NOT NULL,
  `buyer_div` varchar(200) NOT NULL,
  `style_id` varchar(200) DEFAULT NULL,
  `size_code` varchar(500) NOT NULL,
  `packing_method` varchar(12) DEFAULT NULL,
  `order_embl_a` int(11) DEFAULT NULL,
  `order_embl_b` int(11) DEFAULT NULL,
  `order_embl_c` int(11) DEFAULT NULL,
  `order_embl_d` int(11) DEFAULT NULL,
  `order_embl_e` int(11) DEFAULT NULL,
  `order_embl_f` int(11) DEFAULT NULL,
  `order_embl_g` int(11) DEFAULT NULL,
  `order_embl_h` int(11) DEFAULT NULL,
  `destination` varchar(10) DEFAULT NULL,
  `zfeature` varchar(8) DEFAULT NULL COMMENT 'Country Block',
  `order_no` varchar(200) DEFAULT NULL COMMENT 'CO Number',
  PRIMARY KEY (`tid`),
  KEY `style_no` (`style_no`),
  KEY `schedule_no` (`schedule_no`),
  KEY `color` (`color`),
  KEY `style_no_2` (`style_no`),
  KEY `schedule_no_2` (`schedule_no`),
  KEY `color_2` (`color`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `short_names_for_fabrication` */

DROP TABLE IF EXISTS `bai_pro3`.`short_names_for_fabrication`;

CREATE TABLE `bai_pro3`.`short_names_for_fabrication` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(10) DEFAULT NULL,
  `fab_des` varchar(100) DEFAULT NULL,
  `define_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `smv_for_fabrication` */

DROP TABLE IF EXISTS `bai_pro3`.`smv_for_fabrication`;

CREATE TABLE `bai_pro3`.`smv_for_fabrication` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `define_name` varchar(50) DEFAULT NULL,
  `laying` float DEFAULT NULL,
  `cutting` float DEFAULT NULL,
  `bundling` float DEFAULT NULL,
  `smv` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sp_sample_order_db` */

DROP TABLE IF EXISTS `bai_pro3`.`sp_sample_order_db`;

CREATE TABLE `bai_pro3`.`sp_sample_order_db` (
  `order_tid` varchar(200) NOT NULL COMMENT 'Clubbing of Style Schedule color ID',
  `ims_ref_tid` varchar(100) NOT NULL COMMENT 'Ims log referance number',
  `size` varchar(20) NOT NULL COMMENT 'Size name',
  `input_qty` varchar(10) NOT NULL COMMENT 'plan sample quantity of size',
  `remarks` varchar(50) NOT NULL COMMENT 'IMS remark verification',
  `user` varchar(50) NOT NULL COMMENT 'Update user name',
  `log_time` datetime NOT NULL COMMENT 'Log date & time',
  `sizes_ref` varchar(20) NOT NULL,
  PRIMARY KEY (`order_tid`,`size`,`remarks`,`sizes_ref`),
  UNIQUE KEY `unique_key` (`order_tid`,`size`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `speed_del_dashboard` */

DROP TABLE IF EXISTS `bai_pro3`.`speed_del_dashboard`;

CREATE TABLE `bai_pro3`.`speed_del_dashboard` (
  `speed_style` varchar(100) NOT NULL DEFAULT '-',
  `speed_act` int(11) NOT NULL DEFAULT 0,
  `speed_plan` int(11) NOT NULL DEFAULT 0,
  `speed_schedule` bigint(20) NOT NULL DEFAULT 0,
  `speed_order_qty` int(11) NOT NULL DEFAULT 0,
  `speed_cut_qty` int(11) NOT NULL DEFAULT 0,
  `speed_in_qty` int(11) NOT NULL DEFAULT 0,
  `speed_out_qty` int(11) NOT NULL DEFAULT 0,
  `speed_fab_stat` varchar(100) NOT NULL DEFAULT '-',
  `speed_elastic_stat` varchar(100) NOT NULL DEFAULT '-',
  `speed_label_stat` varchar(100) NOT NULL DEFAULT '-',
  `speed_thread_stat` varchar(100) NOT NULL DEFAULT '-',
  `lastup` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_hrs` float NOT NULL DEFAULT 0,
  `today_hrs` float NOT NULL DEFAULT 0,
  `till_yst_plan` int(11) DEFAULT 0,
  `today_per_hr_plan` int(11) DEFAULT 0,
  `audited` int(11) NOT NULL,
  `fgqty` int(11) NOT NULL,
  `pending_carts` int(11) NOT NULL,
  `internal_audited` int(11) NOT NULL,
  KEY `speed_schedule` (`speed_schedule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `stest` */

DROP TABLE IF EXISTS `bai_pro3`.`stest`;

CREATE TABLE `bai_pro3`.`stest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `sss` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `stk_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`stk_stat_log`;

CREATE TABLE `bai_pro3`.`stk_stat_log` (
  `stk_order_tid` varchar(200) NOT NULL,
  `stk_s_xs` int(50) NOT NULL,
  `stk_s_s` int(50) NOT NULL,
  `stk_s_m` int(50) NOT NULL,
  `stk_s_l` int(50) NOT NULL,
  `stk_s_xl` int(50) NOT NULL,
  `stk_s_xxl` int(50) NOT NULL,
  `stk_s_xxxl` int(50) NOT NULL,
  `stk_up_date` datetime NOT NULL,
  `stk_remarks` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `style_db` */

DROP TABLE IF EXISTS `bai_pro3`.`style_db`;

CREATE TABLE `bai_pro3`.`style_db` (
  `style` varchar(50) NOT NULL,
  PRIMARY KEY (`style`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_carton` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_carton`;

CREATE TABLE `bai_pro3`.`tbl_carton` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_schedule` varchar(20) NOT NULL,
  `cr_qty` int(11) NOT NULL,
  `cr_time` datetime DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cr_id`),
  KEY `NewIndex1` (`cr_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_carton_complete` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_carton_complete`;

CREATE TABLE `bai_pro3`.`tbl_carton_complete` (
  `cr_schedule` varchar(20) NOT NULL,
  `cr_time` datetime DEFAULT NULL,
  `cr_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cr_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_category`;

CREATE TABLE `bai_pro3`.`tbl_category` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `cat_selection` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_key` (`cat_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_cif` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_cif`;

CREATE TABLE `bai_pro3`.`tbl_cif` (
  `cif_id` int(11) NOT NULL AUTO_INCREMENT,
  `cif_schedule` varchar(20) NOT NULL,
  `cif_qty` varchar(10) NOT NULL,
  `cif_time` datetime DEFAULT NULL,
  `cif_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cif_id`),
  KEY `NewIndex1` (`cif_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_cif_complete` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_cif_complete`;

CREATE TABLE `bai_pro3`.`tbl_cif_complete` (
  `cif_schedule` varchar(20) NOT NULL,
  `cif_time` datetime NOT NULL,
  `cif_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cif_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_comment` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_comment`;

CREATE TABLE `bai_pro3`.`tbl_comment` (
  `cm_id` double NOT NULL AUTO_INCREMENT,
  `sch_no` varchar(30) DEFAULT NULL,
  `sch_cmnt` blob DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `possible_ex` varchar(45) DEFAULT NULL,
  `comp_date` varchar(45) DEFAULT NULL,
  `fca` varchar(45) DEFAULT NULL,
  `cif` varchar(45) DEFAULT NULL,
  `dispatch` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_cutting_section` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_cutting_section`;

CREATE TABLE `bai_pro3`.`tbl_cutting_section` (
  `sec_id` int(11) NOT NULL COMMENT 'PK- Section ID',
  `sec_name` varchar(20) NOT NULL,
  `sec_head` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_cutting_table` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_cutting_table`;

CREATE TABLE `bai_pro3`.`tbl_cutting_table` (
  `tbl_id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_name` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`tbl_id`),
  UNIQUE KEY `unique_key` (`tbl_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_dispatch` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_dispatch`;

CREATE TABLE `bai_pro3`.`tbl_dispatch` (
  `dis_id` int(11) NOT NULL AUTO_INCREMENT,
  `dis_schedule` varchar(20) NOT NULL,
  `dis_qty` varchar(10) NOT NULL,
  `dis_time` datetime DEFAULT NULL,
  `dis_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`dis_id`),
  KEY `NewIndex1` (`dis_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_dispatch_complete` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_dispatch_complete`;

CREATE TABLE `bai_pro3`.`tbl_dispatch_complete` (
  `dis_schedule` varchar(20) NOT NULL,
  `dis_time` datetime NOT NULL,
  `dis_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`dis_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_fabric_request_time` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_fabric_request_time`;

CREATE TABLE `bai_pro3`.`tbl_fabric_request_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_time` int(11) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_fabric_request_time_log` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_fabric_request_time_log`;

CREATE TABLE `bai_pro3`.`tbl_fabric_request_time_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_time` int(11) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified_by` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_fca` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_fca`;

CREATE TABLE `bai_pro3`.`tbl_fca` (
  `fca_id` int(11) NOT NULL AUTO_INCREMENT,
  `fca_schedule` varchar(20) NOT NULL,
  `fca_qty` varchar(20) NOT NULL,
  `fca_time` datetime DEFAULT NULL,
  `fca_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`fca_id`),
  KEY `sch` (`fca_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_fca_complete` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_fca_complete`;

CREATE TABLE `bai_pro3`.`tbl_fca_complete` (
  `fca_schedule` varchar(20) NOT NULL,
  `fca_time` datetime NOT NULL,
  `fca_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`fca_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_fg_crt_handover_team_list` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_fg_crt_handover_team_list`;

CREATE TABLE `bai_pro3`.`tbl_fg_crt_handover_team_list` (
  `emp_id` varchar(50) DEFAULT NULL COMMENT 'emp_id',
  `team_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
  `emp_call_name` varchar(200) DEFAULT NULL COMMENT 'call name',
  `selected_user` varchar(200) DEFAULT NULL COMMENT 'current scanning user',
  `emp_status` int(11) DEFAULT NULL COMMENT '0-active, 1-inactive',
  `lastup` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_folding` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_folding`;

CREATE TABLE `bai_pro3`.`tbl_folding` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_schedule` varchar(20) NOT NULL COMMENT 'schedule no',
  `f_qty` int(11) NOT NULL COMMENT 'qty',
  `date_n_time` datetime NOT NULL COMMENT 'date and time',
  `username` varchar(30) DEFAULT NULL COMMENT 'User name',
  PRIMARY KEY (`f_id`),
  KEY `sch` (`f_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_folding_complete` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_folding_complete`;

CREATE TABLE `bai_pro3`.`tbl_folding_complete` (
  `f_schedule` varchar(20) NOT NULL,
  `f_time` datetime NOT NULL,
  `f_username` varchar(30) NOT NULL,
  PRIMARY KEY (`f_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_leader_name` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_leader_name`;

CREATE TABLE `bai_pro3`.`tbl_leader_name` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(30) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_plant_timings` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_plant_timings`;

CREATE TABLE `bai_pro3`.`tbl_plant_timings` (
  `time_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_value` varchar(255) NOT NULL,
  `time_display` varchar(255) NOT NULL,
  `day_part` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`time_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_product_master` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_product_master`;

CREATE TABLE `bai_pro3`.`tbl_product_master` (
  `order_tid` varchar(200) NOT NULL,
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `smv` float(11,2) DEFAULT NULL,
  `smo` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_serial_number` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_serial_number`;

CREATE TABLE `bai_pro3`.`tbl_serial_number` (
  `serial_no` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_serial_number_new` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_serial_number_new`;

CREATE TABLE `bai_pro3`.`tbl_serial_number_new` (
  `serial_no` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_size_lable` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_size_lable`;

CREATE TABLE `bai_pro3`.`tbl_size_lable` (
  `buyer_devision` varchar(200) NOT NULL COMMENT 'Name of the buyer devision',
  `size_type` int(1) DEFAULT NULL COMMENT 'Flag for identification of size type,If it is 0 = 7th sizes,if it is 1 13 size lable',
  `xs` varchar(15) DEFAULT NULL,
  `s` varchar(15) DEFAULT NULL,
  `m` varchar(15) DEFAULT NULL,
  `l` varchar(15) DEFAULT NULL,
  `xl` varchar(15) DEFAULT NULL,
  `xxl` varchar(15) DEFAULT NULL,
  `xxxl` varchar(15) DEFAULT NULL,
  `s01` varchar(15) DEFAULT NULL COMMENT ' Size s01',
  `s02` varchar(15) DEFAULT NULL COMMENT ' Size s02',
  `s03` varchar(15) DEFAULT NULL COMMENT ' Size s03',
  `s04` varchar(15) DEFAULT NULL COMMENT ' Size s04',
  `s05` varchar(15) DEFAULT NULL COMMENT ' Size \n\ns05',
  `s06` varchar(15) DEFAULT NULL COMMENT ' Size s06',
  `s07` varchar(15) DEFAULT NULL COMMENT ' Size s07',
  `s08` varchar(15) DEFAULT NULL COMMENT ' Size s08',
  `s09` varchar(15) DEFAULT NULL COMMENT ' Size s09',
  `s10` varchar(15) DEFAULT NULL COMMENT ' Size s10',
  `s11` varchar(15) DEFAULT NULL COMMENT ' Size s11',
  `s12` varchar(15) DEFAULT NULL COMMENT ' Size s12',
  `s13` varchar(15) DEFAULT NULL COMMENT ' Size s13',
  `s14` varchar(15) DEFAULT NULL COMMENT ' Size s14',
  `s15` varchar(15) DEFAULT NULL COMMENT ' Size s15',
  `s16` varchar(15) DEFAULT NULL COMMENT ' Size \n\ns16',
  `s17` varchar(15) DEFAULT NULL COMMENT ' Size s17',
  `s18` varchar(15) DEFAULT NULL COMMENT ' Size s18',
  `s19` varchar(15) DEFAULT NULL COMMENT ' Size s19',
  `s20` varchar(15) DEFAULT NULL COMMENT ' Size s20',
  `s21` varchar(15) DEFAULT NULL COMMENT ' Size s21',
  `s22` varchar(15) DEFAULT NULL COMMENT ' Size s22',
  `s23` varchar(15) DEFAULT NULL COMMENT ' Size s23',
  `s24` varchar(15) DEFAULT NULL COMMENT ' Size s24',
  `s25` varchar(15) DEFAULT NULL COMMENT ' Size s25',
  `s26` varchar(15) DEFAULT NULL COMMENT ' Size s26',
  `s27` varchar(15) DEFAULT NULL COMMENT ' Size \n\ns27',
  `s28` varchar(15) DEFAULT NULL COMMENT ' Size s28',
  `s29` varchar(15) DEFAULT NULL COMMENT ' Size s29',
  `s30` varchar(15) DEFAULT NULL COMMENT ' Size s30',
  `s31` varchar(15) DEFAULT NULL COMMENT ' Size s31',
  `s32` varchar(15) DEFAULT NULL COMMENT ' Size s32',
  `s33` varchar(15) DEFAULT NULL COMMENT ' Size s33',
  `s34` varchar(15) DEFAULT NULL COMMENT ' Size s34',
  `s35` varchar(15) DEFAULT NULL COMMENT ' Size s35',
  `s36` varchar(15) DEFAULT NULL COMMENT ' Size s36',
  `s37` varchar(15) DEFAULT NULL COMMENT ' Size s37',
  `s38` varchar(15) DEFAULT NULL COMMENT ' Size \n\ns38',
  `s39` varchar(15) DEFAULT NULL COMMENT ' Size s39',
  `s40` varchar(15) DEFAULT NULL COMMENT ' Size s40',
  `s41` varchar(15) DEFAULT NULL COMMENT ' Size s41',
  `s42` varchar(15) DEFAULT NULL COMMENT ' Size s42',
  `s43` varchar(15) DEFAULT NULL COMMENT ' Size s43',
  `s44` varchar(15) DEFAULT NULL COMMENT ' Size s44',
  `s45` varchar(15) DEFAULT NULL COMMENT ' Size s45',
  `s46` varchar(15) DEFAULT NULL COMMENT ' Size s46',
  `s47` varchar(15) DEFAULT NULL COMMENT ' Size s47',
  `s48` varchar(15) DEFAULT NULL COMMENT ' Size s48',
  `s49` varchar(15) DEFAULT NULL COMMENT ' Size \n\ns49',
  `s50` varchar(15) DEFAULT NULL COMMENT ' Size s50',
  `docket_path` varchar(20) DEFAULT NULL COMMENT 'Docket Handout Path',
  `layplan_path` varchar(20) DEFAULT NULL COMMENT 'Layplan Handout Path',
  `buyer_short_code` varchar(10) DEFAULT NULL COMMENT 'Short Code of BUyer Divisions',
  PRIMARY KEY (`buyer_devision`),
  KEY `buyer_devision` (`buyer_devision`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_size_matrix` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_size_matrix`;

CREATE TABLE `bai_pro3`.`tbl_size_matrix` (
  `buyer_division` varchar(900) DEFAULT NULL,
  `sfcs_size_code` varchar(90) DEFAULT NULL,
  `m3_size_code` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_user_auth` */

DROP TABLE IF EXISTS `bai_pro3`.`tbl_user_auth`;

CREATE TABLE `bai_pro3`.`tbl_user_auth` (
  `u_id` double NOT NULL AUTO_INCREMENT,
  `username` varchar(500) DEFAULT NULL COMMENT 'username',
  `password` text DEFAULT NULL COMMENT 'passwrd',
  `active_flag` int(11) DEFAULT NULL COMMENT '1=active, 0=deactive',
  `user_type` varchar(100) DEFAULT NULL COMMENT 'user level',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `temp_delivery_schedule` */

DROP TABLE IF EXISTS `bai_pro3`.`temp_delivery_schedule`;

CREATE TABLE `bai_pro3`.`temp_delivery_schedule` (
  `status` varchar(20) DEFAULT NULL,
  `buyer_lable` varchar(8) DEFAULT NULL,
  `po_no` varchar(20) DEFAULT NULL,
  `style` varchar(20) DEFAULT NULL,
  `schedule` varchar(20) NOT NULL,
  `ex_date` varchar(20) DEFAULT NULL,
  `des` varchar(10) DEFAULT NULL,
  `order_qty` int(11) DEFAULT NULL,
  `cut_qty` int(11) DEFAULT NULL,
  `cut_date` datetime DEFAULT NULL,
  `in_qty` int(11) DEFAULT NULL,
  `in_date` datetime DEFAULT NULL,
  `out_qty` int(11) DEFAULT NULL,
  `out_date` datetime DEFAULT NULL,
  `folding_qty` int(11) DEFAULT NULL,
  `folding_date` datetime DEFAULT NULL,
  `carton_qty` int(11) DEFAULT NULL,
  `carton_date` datetime DEFAULT NULL,
  `fa_qty` varchar(10) DEFAULT NULL,
  `fa_date` datetime DEFAULT NULL,
  `cif_qty` varchar(10) DEFAULT NULL,
  `cif_date` datetime DEFAULT NULL,
  `dispatch_qty` int(11) DEFAULT NULL,
  `dispatch_date` datetime DEFAULT NULL,
  `team_no` varchar(80) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`schedule`),
  KEY `NewIndex1` (`style`,`ex_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `temp_line_input_log` */

DROP TABLE IF EXISTS `bai_pro3`.`temp_line_input_log`;

CREATE TABLE `bai_pro3`.`temp_line_input_log` (
  `log_id` double NOT NULL AUTO_INCREMENT,
  `schedule_no` varchar(33) DEFAULT NULL,
  `style` varchar(30) DEFAULT NULL,
  `input_job_no` varchar(33) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `page_name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `temp_line_input_log_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`temp_line_input_log_archive`;

CREATE TABLE `bai_pro3`.`temp_line_input_log_archive` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_no` varchar(11) DEFAULT NULL,
  `style` varchar(10) DEFAULT NULL,
  `input_job_no` varchar(11) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `page_name` varchar(50) DEFAULT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `module` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `temp_line_input_log_test` */

DROP TABLE IF EXISTS `bai_pro3`.`temp_line_input_log_test`;

CREATE TABLE `bai_pro3`.`temp_line_input_log_test` (
  `log_id` int(11) DEFAULT NULL,
  `schedule_no` varchar(45) DEFAULT NULL,
  `input_job_no` varchar(45) DEFAULT NULL,
  `ndate` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `test_plandoc_stat_log` */

DROP TABLE IF EXISTS `bai_pro3`.`test_plandoc_stat_log`;

CREATE TABLE `bai_pro3`.`test_plandoc_stat_log` (
  `date` date NOT NULL,
  `cat_ref` int(11) NOT NULL,
  `cuttable_ref` int(11) NOT NULL,
  `allocate_ref` int(11) NOT NULL,
  `mk_ref` int(11) NOT NULL,
  `order_tid` varchar(200) NOT NULL,
  `pcutno` int(11) NOT NULL,
  `ratio` int(11) NOT NULL,
  `p_xs` int(11) NOT NULL,
  `p_s` int(11) NOT NULL,
  `p_m` int(11) NOT NULL,
  `p_l` int(11) NOT NULL,
  `p_xl` int(11) NOT NULL,
  `p_xxl` int(11) NOT NULL,
  `p_xxxl` int(11) NOT NULL,
  `p_plies` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL AUTO_INCREMENT,
  `acutno` int(11) NOT NULL,
  `a_xs` int(11) NOT NULL,
  `a_s` int(11) NOT NULL,
  `a_m` int(11) NOT NULL,
  `a_l` int(11) NOT NULL,
  `a_xl` int(11) NOT NULL,
  `a_xxl` int(11) NOT NULL,
  `a_xxxl` int(11) NOT NULL,
  `a_plies` int(11) NOT NULL,
  `lastup` datetime NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `act_cut_status` varchar(50) NOT NULL,
  `act_cut_issue_status` varchar(50) NOT NULL,
  `pcutdocid` varchar(200) NOT NULL,
  `print_status` datetime DEFAULT NULL,
  `a_s06` int(11) NOT NULL,
  `a_s08` int(11) NOT NULL,
  `a_s10` int(11) NOT NULL,
  `a_s12` int(11) NOT NULL,
  `a_s14` int(11) NOT NULL,
  `a_s16` int(11) NOT NULL,
  `a_s18` int(11) NOT NULL,
  `a_s20` int(11) NOT NULL,
  `a_s22` int(11) NOT NULL,
  `a_s24` int(11) NOT NULL,
  `a_s26` int(11) NOT NULL,
  `a_s28` int(11) NOT NULL,
  `a_s30` int(11) NOT NULL,
  `p_s06` int(11) NOT NULL,
  `p_s08` int(11) NOT NULL,
  `p_s10` int(11) NOT NULL,
  `p_s12` int(11) NOT NULL,
  `p_s14` int(11) NOT NULL,
  `p_s16` int(11) NOT NULL,
  `p_s18` int(11) NOT NULL,
  `p_s20` int(11) NOT NULL,
  `p_s22` int(11) NOT NULL,
  `p_s24` int(11) NOT NULL,
  `p_s26` int(11) NOT NULL,
  `p_s28` int(11) NOT NULL,
  `p_s30` int(11) NOT NULL,
  `rm_date` datetime DEFAULT NULL,
  `cut_inp_temp` int(11) DEFAULT NULL,
  `plan_module` int(11) DEFAULT NULL,
  `fabric_status` smallint(6) NOT NULL,
  `plan_lot_ref` text DEFAULT NULL,
  `docket_printed_person` text NOT NULL,
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `tpd_plan_dash_doc_summ` */

DROP TABLE IF EXISTS `bai_pro3`.`tpd_plan_dash_doc_summ`;

CREATE TABLE `bai_pro3`.`tpd_plan_dash_doc_summ` (
  `print_status` date DEFAULT NULL,
  `plan_lot_ref` text DEFAULT NULL,
  `bundle_location` varchar(200) DEFAULT NULL,
  `fabric_status_new` smallint(6) DEFAULT NULL,
  `doc_no` double DEFAULT NULL,
  `module` varchar(24) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `act_cut_issue_status` varchar(50) DEFAULT NULL,
  `act_cut_status` varchar(50) DEFAULT NULL,
  `rm_date` datetime DEFAULT NULL,
  `cut_inp_temp` int(11) DEFAULT NULL,
  `order_tid` varchar(200) DEFAULT NULL,
  `fabric_status` int(11) DEFAULT NULL,
  `color_code` int(11) DEFAULT NULL,
  `clubbing` smallint(6) DEFAULT NULL,
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `acutno` int(11) DEFAULT NULL,
  `ft_status` int(11) DEFAULT NULL,
  `st_status` int(11) DEFAULT NULL,
  `pt_status` int(11) DEFAULT NULL,
  `trim_status` int(11) DEFAULT NULL,
  `xs` bigint(21) DEFAULT NULL,
  `s` bigint(21) DEFAULT NULL,
  `m` bigint(21) DEFAULT NULL,
  `l` bigint(21) DEFAULT NULL,
  `xl` bigint(21) DEFAULT NULL,
  `xxl` bigint(21) DEFAULT NULL,
  `xxxl` bigint(21) DEFAULT NULL,
  `s06` bigint(21) DEFAULT NULL,
  `s08` bigint(21) DEFAULT NULL,
  `s10` bigint(21) DEFAULT NULL,
  `s12` bigint(21) DEFAULT NULL,
  `s14` bigint(21) DEFAULT NULL,
  `s16` bigint(21) DEFAULT NULL,
  `s18` bigint(21) DEFAULT NULL,
  `s20` bigint(21) DEFAULT NULL,
  `s22` bigint(21) DEFAULT NULL,
  `s24` bigint(21) DEFAULT NULL,
  `s26` bigint(21) DEFAULT NULL,
  `s28` bigint(21) DEFAULT NULL,
  `s30` bigint(21) DEFAULT NULL,
  `a_plies` int(11) DEFAULT NULL,
  `mk_ref` int(11) DEFAULT NULL,
  `total` bigint(40) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `emb_stat` int(3) DEFAULT NULL,
  `cat_ref` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tpd_plan_dash_summ` */

DROP TABLE IF EXISTS `bai_pro3`.`tpd_plan_dash_summ`;

CREATE TABLE `bai_pro3`.`tpd_plan_dash_summ` (
  `doc_no` double DEFAULT NULL,
  `module` varchar(24) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `fabric_status` int(11) DEFAULT NULL,
  `act_cut_issue_status` varchar(50) DEFAULT NULL,
  `plan_lot_ref` text DEFAULT NULL,
  `bundle_location` varchar(200) DEFAULT NULL,
  `print_status` date DEFAULT NULL,
  `act_cut_status` varchar(50) DEFAULT NULL,
  `rm_date` datetime DEFAULT NULL,
  `cut_inp_temp` int(11) DEFAULT NULL,
  `xs` bigint(21) DEFAULT NULL,
  `s` bigint(21) DEFAULT NULL,
  `m` bigint(21) DEFAULT NULL,
  `l` bigint(21) DEFAULT NULL,
  `xl` bigint(21) DEFAULT NULL,
  `xxl` bigint(21) DEFAULT NULL,
  `xxxl` bigint(21) DEFAULT NULL,
  `s06` bigint(21) DEFAULT NULL,
  `s08` bigint(21) DEFAULT NULL,
  `s10` bigint(21) DEFAULT NULL,
  `s12` bigint(21) DEFAULT NULL,
  `s14` bigint(21) DEFAULT NULL,
  `s16` bigint(21) DEFAULT NULL,
  `s18` bigint(21) DEFAULT NULL,
  `s20` bigint(21) DEFAULT NULL,
  `s22` bigint(21) DEFAULT NULL,
  `s24` bigint(21) DEFAULT NULL,
  `s26` bigint(21) DEFAULT NULL,
  `s28` bigint(21) DEFAULT NULL,
  `s30` bigint(21) DEFAULT NULL,
  `a_plies` int(11) DEFAULT NULL,
  `mk_ref` int(11) DEFAULT NULL,
  `order_tid` varchar(200) DEFAULT NULL,
  `fabric_status_new` smallint(6) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tpd_plan_dashboard` */

DROP TABLE IF EXISTS `bai_pro3`.`tpd_plan_dashboard`;

CREATE TABLE `bai_pro3`.`tpd_plan_dashboard` (
  `module` varchar(24) DEFAULT NULL,
  `doc_no` double NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `fabric_status` int(11) DEFAULT NULL,
  `log_time` datetime NOT NULL,
  `track_id` int(11) NOT NULL,
  PRIMARY KEY (`doc_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `transport_modes` */

DROP TABLE IF EXISTS `bai_pro3`.`transport_modes`;

CREATE TABLE `bai_pro3`.`transport_modes` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `transport_mode` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `unique_key` (`transport_mode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `trims_dashboard` */

DROP TABLE IF EXISTS `bai_pro3`.`trims_dashboard`;

CREATE TABLE `bai_pro3`.`trims_dashboard` (
  `doc_ref` int(11) NOT NULL,
  `priority` double DEFAULT NULL,
  `plan_time` datetime NOT NULL,
  `module` double DEFAULT NULL,
  `section` double DEFAULT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` double NOT NULL DEFAULT 0,
  `tid` double NOT NULL AUTO_INCREMENT,
  `log_user` varchar(50) NOT NULL,
  PRIMARY KEY (`doc_ref`),
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `trims_dashboard_archive` */

DROP TABLE IF EXISTS `bai_pro3`.`trims_dashboard_archive`;

CREATE TABLE `bai_pro3`.`trims_dashboard_archive` (
  `doc_ref` double DEFAULT NULL,
  `priority` double DEFAULT NULL,
  `plan_time` datetime NOT NULL,
  `module` varchar(10) DEFAULT NULL,
  `section` double DEFAULT NULL,
  `trims_req_time` datetime NOT NULL,
  `log_user` varchar(50) DEFAULT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` double NOT NULL DEFAULT 0,
  `tid` double NOT NULL AUTO_INCREMENT,
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `trims_dashboard_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`trims_dashboard_backup`;

CREATE TABLE `bai_pro3`.`trims_dashboard_backup` (
  `doc_ref` double DEFAULT NULL,
  `priority` double DEFAULT NULL,
  `plan_time` datetime NOT NULL,
  `module` double DEFAULT NULL,
  `section` double DEFAULT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` double NOT NULL DEFAULT 0,
  `tid` double NOT NULL AUTO_INCREMENT,
  `log_user` varchar(50) NOT NULL,
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `trims_priorities` */

DROP TABLE IF EXISTS `bai_pro3`.`trims_priorities`;

CREATE TABLE `bai_pro3`.`trims_priorities` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(50) NOT NULL,
  `req_time` datetime NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `log_user` varchar(50) NOT NULL,
  `section` int(11) NOT NULL DEFAULT 0,
  `module` varchar(8) NOT NULL DEFAULT '0',
  `issued_time` datetime NOT NULL,
  PRIMARY KEY (`doc_ref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
