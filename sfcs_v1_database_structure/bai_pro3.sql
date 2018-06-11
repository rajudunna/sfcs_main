/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_pro3
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro3` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_pro3`;

/*Table structure for table `act_cut_issue_status` */

DROP TABLE IF EXISTS `act_cut_issue_status`;

CREATE TABLE `act_cut_issue_status` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Date of Issue',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `mod_no` varchar(8) NOT NULL COMMENT 'Module',
  `shift` varchar(20) NOT NULL COMMENT 'Shift',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Log Time',
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track cut job issue status.';

/*Table structure for table `act_cut_issue_status_archive` */

DROP TABLE IF EXISTS `act_cut_issue_status_archive`;

CREATE TABLE `act_cut_issue_status_archive` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Date of Issue',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `mod_no` varchar(8) NOT NULL COMMENT 'Module',
  `shift` varchar(20) NOT NULL COMMENT 'Shift',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Log Time',
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `act_cut_status` */

DROP TABLE IF EXISTS `act_cut_status`;

CREATE TABLE `act_cut_status` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Cut Completed/Reported Date',
  `section` int(11) NOT NULL COMMENT 'Cut Exceuted Section',
  `shift` varchar(10) NOT NULL COMMENT 'Shift',
  `fab_received` float NOT NULL COMMENT 'Fabric Received Qty from RM',
  `fab_returned` float NOT NULL COMMENT 'Fabric Returned Qty to RM',
  `damages` float NOT NULL COMMENT 'Fabric Damage details',
  `shortages` float NOT NULL COMMENT 'Fabric Shortage Details',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time',
  `bundle_loc` varchar(200) DEFAULT NULL COMMENT 'Bundle location',
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track actual cut completion status.';

/*Table structure for table `act_cut_status_archive` */

DROP TABLE IF EXISTS `act_cut_status_archive`;

CREATE TABLE `act_cut_status_archive` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Cut Completed/Reported Date',
  `section` int(11) NOT NULL COMMENT 'Cut Exceuted Section',
  `shift` varchar(10) NOT NULL COMMENT 'Shift',
  `fab_received` float NOT NULL COMMENT 'Fabric Received Qty from RM',
  `fab_returned` float NOT NULL COMMENT 'Fabric Returned Qty to RM',
  `damages` float NOT NULL COMMENT 'Fabric Damage details',
  `shortages` float NOT NULL COMMENT 'Fabric Shortage Details',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time',
  `bundle_loc` varchar(200) DEFAULT NULL COMMENT 'Bundle Location',
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `act_cut_status_recut_v2` */

DROP TABLE IF EXISTS `act_cut_status_recut_v2`;

CREATE TABLE `act_cut_status_recut_v2` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Cut Completed/Reported Date',
  `section` int(11) NOT NULL COMMENT 'Cut Exceuted Section',
  `shift` varchar(10) NOT NULL COMMENT 'Shift',
  `fab_received` float NOT NULL COMMENT 'Fabric Received Qty from RM',
  `fab_returned` float NOT NULL COMMENT 'Fabric Returned Qty to RM',
  `damages` float NOT NULL COMMENT 'Fabric Damage details',
  `shortages` float NOT NULL COMMENT 'Fabric Shortage Details',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time',
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track recut cut job status.';

/*Table structure for table `act_cut_status_recut_v2_archive` */

DROP TABLE IF EXISTS `act_cut_status_recut_v2_archive`;

CREATE TABLE `act_cut_status_recut_v2_archive` (
  `doc_no` int(11) NOT NULL COMMENT 'Cut Docket Number',
  `date` date NOT NULL COMMENT 'Cut Completed/Reported Date',
  `section` int(11) NOT NULL COMMENT 'Cut Exceuted Section',
  `shift` varchar(10) NOT NULL COMMENT 'Shift',
  `fab_received` float NOT NULL COMMENT 'Fabric Received Qty from RM',
  `fab_returned` float NOT NULL COMMENT 'Fabric Returned Qty to RM',
  `damages` float NOT NULL COMMENT 'Fabric Damage details',
  `shortages` float NOT NULL COMMENT 'Fabric Shortage Details',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time',
  PRIMARY KEY (`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `allocate_stat_log` */

DROP TABLE IF EXISTS `allocate_stat_log`;

CREATE TABLE `allocate_stat_log` (
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
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=263 DEFAULT CHARSET=latin1 COMMENT='To track ration detail of cut job';

/*Table structure for table `allocate_stat_log_archive` */

DROP TABLE IF EXISTS `allocate_stat_log_archive`;

CREATE TABLE `allocate_stat_log_archive` (
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
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `aql_auditor_list` */

DROP TABLE IF EXISTS `aql_auditor_list`;

CREATE TABLE `aql_auditor_list` (
  `login_id` varchar(15) NOT NULL COMMENT 'Employee ID',
  `section_list` varchar(10) NOT NULL COMMENT 'Section List',
  `module_list` varchar(100) NOT NULL COMMENT 'Module List',
  `department_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Department Category',
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `aql_track_log` */

DROP TABLE IF EXISTS `aql_track_log`;

CREATE TABLE `aql_track_log` (
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

DROP TABLE IF EXISTS `audit_fail_db`;

CREATE TABLE `audit_fail_db` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking ID',
  `style` varchar(50) DEFAULT NULL COMMENT 'Order Style',
  `schedule` int(11) DEFAULT NULL COMMENT 'Order Schedule',
  `size` varchar(10) DEFAULT NULL COMMENT 'Size',
  `pcs` int(11) NOT NULL COMMENT 'Quantity',
  `lastup` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time',
  `remarks` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `tran_type` int(11) DEFAULT NULL COMMENT 'Transaction Mode',
  `fail_reason` int(11) DEFAULT NULL COMMENT 'Reason for Rejection',
  `done_by` varchar(50) DEFAULT NULL COMMENT 'Updated User Name',
  `color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule` (`schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track MCA fail details';

/*Table structure for table `audit_fail_db_archive` */

DROP TABLE IF EXISTS `audit_fail_db_archive`;

CREATE TABLE `audit_fail_db_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking ID',
  `style` varchar(50) DEFAULT NULL COMMENT 'Order Style',
  `schedule` int(11) DEFAULT NULL COMMENT 'Order Schedule',
  `size` varchar(10) DEFAULT NULL COMMENT 'Size',
  `pcs` int(11) NOT NULL COMMENT 'Quantity',
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time',
  `remarks` varchar(100) DEFAULT NULL COMMENT 'Remarks',
  `tran_type` int(11) DEFAULT NULL COMMENT 'Transaction Mode',
  `fail_reason` int(11) DEFAULT NULL COMMENT 'Reason for Rejection',
  `done_by` varchar(50) DEFAULT NULL COMMENT 'Updated User Name',
  `color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule` (`schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track MCA fail details';

/*Table structure for table `audit_ref` */

DROP TABLE IF EXISTS `audit_ref`;

CREATE TABLE `audit_ref` (
  `audit_ref` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking ID',
  `reason` varchar(200) NOT NULL COMMENT 'Reason for rejection',
  `rej_code` varchar(30) NOT NULL COMMENT 'Rejection Code',
  `category` varchar(50) NOT NULL COMMENT 'Category',
  `status` tinyint(1) NOT NULL COMMENT 'Status to filter in list',
  PRIMARY KEY (`audit_ref`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1 COMMENT='Matrix to refer while updating FCA details';

/*Table structure for table `bai_emb_db` */

DROP TABLE IF EXISTS `bai_emb_db`;

CREATE TABLE `bai_emb_db` (
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
) ENGINE=InnoDB AUTO_INCREMENT=930418 DEFAULT CHARSET=latin1 COMMENT='Clone of M3 embellishment table';

/*Table structure for table `bai_emb_excess_db` */

DROP TABLE IF EXISTS `bai_emb_excess_db`;

CREATE TABLE `bai_emb_excess_db` (
  `qms_tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction Id',
  `qms_style` varchar(30) NOT NULL COMMENT 'Style',
  `qms_schedule` varchar(20) NOT NULL COMMENT 'Schedule',
  `qms_color` varchar(150) NOT NULL COMMENT 'Color',
  `log_user` varchar(15) NOT NULL COMMENT 'Updated user',
  `log_date` date NOT NULL COMMENT 'Log date',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time',
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
) ENGINE=MyISAM AUTO_INCREMENT=592 DEFAULT CHARSET=latin1 COMMENT='To update quality/rejection details';

/*Table structure for table `bai_orders_db` */

DROP TABLE IF EXISTS `bai_orders_db`;

CREATE TABLE `bai_orders_db` (
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
  `color_code` int(11) NOT NULL DEFAULT '0' COMMENT 'Color Code(Number Format)',
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
  `title_flag` int(11) NOT NULL DEFAULT '0' COMMENT 'Title Flag',
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
  `bts_status` int(11) NOT NULL DEFAULT '0',
  `zfeature` varchar(15) DEFAULT NULL COMMENT 'Country Block',
  `ratio_packing_method` varchar(45) DEFAULT NULL COMMENT 'Ratio Packing Method 1.Single: Single \n\nSize Multiple Colours Ratio Packing, 2.Multiple: Multiple Sizes Multiple Colours Ratio Packing',
  `co_no` varchar(25) DEFAULT NULL COMMENT 'customer order number',
  `vpo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Order details for CMS and other applications';

/*Table structure for table `bai_orders_db_archive` */

DROP TABLE IF EXISTS `bai_orders_db_archive`;

CREATE TABLE `bai_orders_db_archive` (
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
  `title_flag` int(11) NOT NULL DEFAULT '0' COMMENT 'Title Flag',
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

/*Table structure for table `bai_orders_db_club` */

DROP TABLE IF EXISTS `bai_orders_db_club`;

CREATE TABLE `bai_orders_db_club` (
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
  `color_code` int(11) NOT NULL DEFAULT '0' COMMENT 'Color Code(Number Format)',
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
  `title_flag` int(11) NOT NULL DEFAULT '0' COMMENT 'Title Flag',
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
  `bts_status` int(11) NOT NULL DEFAULT '0',
  `zfeature` varchar(15) DEFAULT NULL COMMENT 'Country Block',
  `ratio_packing_method` varchar(45) DEFAULT NULL COMMENT 'Ratio Packing Method 1.Single: Single \n\nSize Multiple Colours Ratio Packing, 2.Multiple: Multiple Sizes Multiple Colours Ratio Packing',
  `co_no` varchar(25) DEFAULT NULL COMMENT 'customer order number',
  `vpo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`order_tid`),
  KEY `order_style_no` (`order_style_no`,`order_del_no`,`order_col_des`),
  KEY `order_tid` (`order_tid`,`order_style_no`,`order_del_no`,`order_col_des`,`color_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Order details for CMS and other applications';

/*Table structure for table `bai_orders_db_confirm` */

DROP TABLE IF EXISTS `bai_orders_db_confirm`;

CREATE TABLE `bai_orders_db_confirm` (
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
  `title_flag` int(11) NOT NULL DEFAULT '0' COMMENT 'Title Flag',
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
  `bts_status` int(11) NOT NULL DEFAULT '0',
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

DROP TABLE IF EXISTS `bai_orders_db_confirm_archive`;

CREATE TABLE `bai_orders_db_confirm_archive` (
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
  `title_flag` int(11) NOT NULL DEFAULT '0' COMMENT 'Title Flag',
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

/*Table structure for table `bai_orders_db_confirm_mo` */

DROP TABLE IF EXISTS `bai_orders_db_confirm_mo`;

CREATE TABLE `bai_orders_db_confirm_mo` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `order_upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_style_no` varchar(180) DEFAULT NULL,
  `order_del_no` varchar(180) DEFAULT NULL,
  `order_col_des` varchar(450) DEFAULT NULL,
  `sfcs_size` varchar(150) DEFAULT NULL,
  `m_size` varchar(75) DEFAULT NULL COMMENT 'm3 size',
  `mo_qty` int(11) DEFAULT NULL COMMENT 'order qty',
  `fill_qty` int(11) DEFAULT '0' COMMENT 'filled qty',
  `rej_pcs` int(11) DEFAULT '0' COMMENT 'rejection pcs',
  `sfcs_ops` varchar(75) DEFAULT NULL COMMENT 'sfcs operation',
  `m_ops` varchar(75) DEFAULT NULL COMMENT 'm3 operation code',
  `zfeature_desc` varchar(75) DEFAULT NULL COMMENT 'validate with this description',
  `mo_number` varchar(75) DEFAULT NULL COMMENT 'mo number',
  `destination` varchar(30) DEFAULT NULL COMMENT 'destination',
  `zfeature` varchar(45) DEFAULT NULL COMMENT 'Country Block',
  `co_no` varchar(75) DEFAULT NULL COMMENT 'customer order number',
  `mpo_no` varchar(75) DEFAULT NULL COMMENT 'manufacture order',
  `vpo_no` varchar(75) DEFAULT NULL,
  `order_no` int(10) DEFAULT '0' COMMENT '1- is last , 0 - order',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique id` (`m_ops`,`mo_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_orders_db_mo` */

DROP TABLE IF EXISTS `bai_orders_db_mo`;

CREATE TABLE `bai_orders_db_mo` (
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

DROP TABLE IF EXISTS `bai_orders_db_remarks`;

CREATE TABLE `bai_orders_db_remarks` (
  `order_tid` varchar(300) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL COMMENT 'Special Remarks for Lay Plan',
  `binding_con` double NOT NULL,
  PRIMARY KEY (`order_tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To add additional comments for Layplan';

/*Table structure for table `bai_orders_db_temp` */

DROP TABLE IF EXISTS `bai_orders_db_temp`;

CREATE TABLE `bai_orders_db_temp` (
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

/*Table structure for table `bai_orders_db_temp_confirm` */

DROP TABLE IF EXISTS `bai_orders_db_temp_confirm`;

CREATE TABLE `bai_orders_db_temp_confirm` (
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

DROP TABLE IF EXISTS `bai_qms_db`;

CREATE TABLE `bai_qms_db` (
  `qms_tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction Id',
  `qms_style` varchar(30) NOT NULL COMMENT 'Style',
  `qms_schedule` varchar(20) NOT NULL COMMENT 'Schedule',
  `qms_color` varchar(150) NOT NULL COMMENT 'Color',
  `log_user` varchar(15) NOT NULL COMMENT 'Updated user',
  `log_date` date NOT NULL COMMENT 'Log date',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time',
  `issued_by` varchar(30) NOT NULL COMMENT 'Good panels issued by',
  `qms_size` varchar(5) NOT NULL COMMENT 'Size',
  `qms_qty` smallint(6) NOT NULL COMMENT 'Qunatity',
  `qms_tran_type` smallint(6) NOT NULL COMMENT 'Trasaction type - 1-Good Panel 2- Replaced 3- Rejected 4- Sample Room 5- Good Garments 6-recut raised 7-Disposed (Actual-Panel&Garment) 8-Sent to customer 9- actual Recut 10-Transfer Sent 11-Transfer Received 12-Reserved for Destroy 13-Destroyed Panels (Internal)',
  `remarks` text NOT NULL COMMENT 'Remarks updation / Docket',
  `ref1` varchar(500) NOT NULL,
  `doc_no` varchar(20) NOT NULL COMMENT 'Docket_Reference',
  `location_id` varchar(30) NOT NULL COMMENT 'FK_Location map ID',
  `input_job_no` varchar(15) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`qms_tid`),
  KEY `sscs` (`qms_style`,`qms_schedule`,`qms_color`,`qms_size`),
  KEY `qms_size` (`qms_style`,`qms_size`),
  KEY `qms_color` (`qms_schedule`,`qms_color`),
  KEY `qms_tran_type` (`qms_tran_type`),
  KEY `ref1` (`qms_tran_type`,`ref1`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=latin1 COMMENT='To update quality/rejection details';

/*Table structure for table `bai_qms_db_archive` */

DROP TABLE IF EXISTS `bai_qms_db_archive`;

CREATE TABLE `bai_qms_db_archive` (
  `qms_tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction Id',
  `qms_style` varchar(30) NOT NULL,
  `qms_schedule` varchar(20) NOT NULL,
  `qms_color` varchar(150) NOT NULL,
  `log_user` varchar(15) NOT NULL COMMENT 'Updated user',
  `log_date` date NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `issued_by` varchar(30) NOT NULL COMMENT 'Good panels issued by',
  `qms_size` varchar(5) NOT NULL,
  `qms_qty` smallint(6) NOT NULL,
  `qms_tran_type` smallint(6) NOT NULL COMMENT 'Trasaction type - 1-Good Panel 2- Replaced 3- Rejected 4- Sample Room 5- Good Garments 6-recut raised 7-Dispatched 8-Sent to customer 9- actual Recut',
  `remarks` text NOT NULL COMMENT 'Remarks updation / Docket',
  `ref1` varchar(500) NOT NULL,
  `doc_no` varchar(20) NOT NULL COMMENT 'Docket_Reference',
  `location_id` varchar(30) NOT NULL COMMENT 'FK_Location map ID',
  PRIMARY KEY (`qms_tid`),
  KEY `qms_color` (`qms_schedule`,`qms_color`),
  KEY `qms_size` (`qms_style`,`qms_size`),
  KEY `qms_tran_type` (`qms_tran_type`),
  KEY `sscs` (`qms_style`,`qms_schedule`,`qms_color`,`qms_size`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To update quality/rejection details';

/*Table structure for table `bai_qms_db_deleted` */

DROP TABLE IF EXISTS `bai_qms_db_deleted`;

CREATE TABLE `bai_qms_db_deleted` (
  `qms_tid` int(11) NOT NULL AUTO_INCREMENT,
  `qms_style` varchar(30) NOT NULL,
  `qms_schedule` varchar(20) NOT NULL,
  `qms_color` varchar(150) NOT NULL,
  `log_user` varchar(15) NOT NULL,
  `log_date` date NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COMMENT='To track deleted Trans of QMS table';

/*Table structure for table `bai_qms_db_reason_track` */

DROP TABLE IF EXISTS `bai_qms_db_reason_track`;

CREATE TABLE `bai_qms_db_reason_track` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `qms_tid` double DEFAULT NULL,
  `qms_reason` double DEFAULT NULL,
  `qms_qty` double DEFAULT NULL,
  `supplier` varchar(100) NOT NULL,
  `log_date` date NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_destroy_log` */

DROP TABLE IF EXISTS `bai_qms_destroy_log`;

CREATE TABLE `bai_qms_destroy_log` (
  `qms_des_note_no` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Destroy Note Number',
  `qms_des_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `qms_log_user` varchar(30) NOT NULL,
  `mer_month_year` varchar(25) DEFAULT NULL,
  `mer_remarks` varchar(100) DEFAULT NULL COMMENT 'To Track Remarks of Relevant MER Packing List',
  PRIMARY KEY (`qms_des_note_no`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_location_db` */

DROP TABLE IF EXISTS `bai_qms_location_db`;

CREATE TABLE `bai_qms_location_db` (
  `qms_location_id` varchar(11) NOT NULL COMMENT 'Location ID',
  `qms_location` varchar(30) NOT NULL COMMENT 'Location of carton/container',
  `qms_location_cap` int(11) NOT NULL COMMENT 'Capacity of carton/container',
  `qms_cur_qty` int(11) NOT NULL COMMENT 'Current Quantity',
  `active_status` tinyint(4) NOT NULL COMMENT '0-Active, 1-Inactive',
  `location_type` int(11) NOT NULL COMMENT '0-Normal Location, 1-Reserve for Destroy',
  `order_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`qms_location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_rejection_reason` */

DROP TABLE IF EXISTS `bai_qms_rejection_reason`;

CREATE TABLE `bai_qms_rejection_reason` (
  `sno` double NOT NULL AUTO_INCREMENT,
  `reason_cat` varchar(150) DEFAULT NULL,
  `reason_desc` varchar(150) DEFAULT NULL,
  `reason_code` double DEFAULT NULL,
  `reason_order` double DEFAULT NULL,
  `form_type` varchar(5) DEFAULT NULL,
  `m3_reason_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

/*Table structure for table `bai_qms_transfers_log` */

DROP TABLE IF EXISTS `bai_qms_transfers_log`;

CREATE TABLE `bai_qms_transfers_log` (
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

/*Table structure for table `buyer_style` */

DROP TABLE IF EXISTS `buyer_style`;

CREATE TABLE `buyer_style` (
  `buyer_id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_name` varchar(20) DEFAULT NULL,
  `buyer_identity` varchar(20) DEFAULT NULL,
  `user_list` text,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1-Active,0-Inactive',
  `buyer` varchar(45) DEFAULT NULL COMMENT 'actual name of the buyer, PINK as VS PINK',
  PRIMARY KEY (`buyer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `buyer_users` */

DROP TABLE IF EXISTS `buyer_users`;

CREATE TABLE `buyer_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `users` text,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `carton_qty_chart` */

DROP TABLE IF EXISTS `carton_qty_chart`;

CREATE TABLE `carton_qty_chart` (
  `user_style` varchar(50) DEFAULT NULL COMMENT 'User Defined Style',
  `buyer` varchar(50) DEFAULT NULL,
  `buyer_identity` varchar(50) DEFAULT NULL COMMENT 'L & O for VS Logo; P & K for VS Pink;  M for M&S; D for DIM',
  `packing_method` varchar(50) DEFAULT NULL COMMENT 'Packing Method (Assortment Reference)',
  `xs` int(11) DEFAULT '0',
  `s` int(11) DEFAULT '0',
  `m` int(11) DEFAULT '0',
  `l` int(11) DEFAULT '0',
  `xl` int(11) DEFAULT '0',
  `xxl` int(11) DEFAULT '0',
  `xxxl` int(11) DEFAULT '0',
  `s01` int(11) DEFAULT '0' COMMENT 'carton \n\nqty of size s01',
  `s02` int(11) DEFAULT '0' COMMENT 'carton qty of size s02',
  `s03` int(11) DEFAULT '0' COMMENT 'carton qty of size s03',
  `s04` int(11) DEFAULT '0' COMMENT 'carton qty of size s04',
  `s05` int(11) DEFAULT '0' COMMENT 'carton qty of size s05',
  `s06` int(11) DEFAULT '0' COMMENT 'carton qty of size s06',
  `s07` int(11) DEFAULT '0' COMMENT 'carton qty of size s07',
  `s08` int(11) DEFAULT '0' COMMENT 'carton qty of size s08',
  `s09` int(11) DEFAULT '0' COMMENT 'carton qty of size s09',
  `s10` int(11) DEFAULT '0' COMMENT 'carton qty of size s10',
  `s11` int(11) DEFAULT '0' COMMENT 'carton qty of size s11',
  `s12` int(11) DEFAULT '0' COMMENT 'carton qty of size s12',
  `s13` int(11) DEFAULT '0' COMMENT 'carton qty of size \n\ns13',
  `s14` int(11) DEFAULT '0' COMMENT 'carton qty of size s14',
  `s15` int(11) DEFAULT '0' COMMENT 'carton qty of size s15',
  `s16` int(11) DEFAULT '0' COMMENT 'carton qty of size s16',
  `s17` int(11) DEFAULT '0' COMMENT 'carton qty of size s17',
  `s18` int(11) DEFAULT '0' COMMENT 'carton qty of \n\nsize s18',
  `s19` int(11) DEFAULT '0' COMMENT 'carton qty of size s19',
  `s20` int(11) DEFAULT '0' COMMENT 'carton qty of size s20',
  `s21` int(11) DEFAULT '0' COMMENT 'carton qty of size s21',
  `s22` int(11) DEFAULT '0' COMMENT 'carton qty of size s22',
  `s23` int(11) DEFAULT '0' COMMENT 'carton \n\nqty of size s23',
  `s24` int(11) DEFAULT '0' COMMENT 'carton qty of size s24',
  `s25` int(11) DEFAULT '0' COMMENT 'carton qty of size s25',
  `s26` int(11) DEFAULT '0' COMMENT 'carton qty of size s26',
  `s27` int(11) DEFAULT '0' COMMENT 'carton qty of size s27',
  `s28` int(11) DEFAULT '0' COMMENT 'carton qty of size s28',
  `s29` int(11) DEFAULT '0' COMMENT 'carton qty of size s29',
  `s30` int(11) DEFAULT '0' COMMENT 'carton qty of size s30',
  `s31` int(11) DEFAULT '0' COMMENT 'carton qty of size s31',
  `s32` int(11) DEFAULT '0' COMMENT 'carton qty of size s32',
  `s33` int(11) DEFAULT '0' COMMENT 'carton qty of size s33',
  `s34` int(11) DEFAULT '0' COMMENT 'carton qty of size s34',
  `s35` int(11) DEFAULT '0' COMMENT 'carton qty of size \n\ns35',
  `s36` int(11) DEFAULT '0' COMMENT 'carton qty of size s36',
  `s37` int(11) DEFAULT '0' COMMENT 'carton qty of size s37',
  `s38` int(11) DEFAULT '0' COMMENT 'carton qty of size s38',
  `s39` int(11) DEFAULT '0' COMMENT 'carton qty of size s39',
  `s40` int(11) DEFAULT '0' COMMENT 'carton qty of \n\nsize s40',
  `s41` int(11) DEFAULT '0' COMMENT 'carton qty of size s41',
  `s42` int(11) DEFAULT '0' COMMENT 'carton qty of size s42',
  `s43` int(11) DEFAULT '0' COMMENT 'carton qty of size s43',
  `s44` int(11) DEFAULT '0' COMMENT 'carton qty of size s44',
  `s45` int(11) DEFAULT '0' COMMENT 'carton \n\nqty of size s45',
  `s46` int(11) DEFAULT '0' COMMENT 'carton qty of size s46',
  `s47` int(11) DEFAULT '0' COMMENT 'carton qty of size s47',
  `s48` int(11) DEFAULT '0' COMMENT 'carton qty of size s48',
  `s49` int(11) DEFAULT '0' COMMENT 'carton qty of size s49',
  `s50` int(11) DEFAULT '0' COMMENT 'carton qty of size s50',
  `remarks` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking \n\nID',
  `status` int(10) unsigned zerofill DEFAULT NULL COMMENT '0-active , 1- inactive',
  `track_qty` int(11) DEFAULT NULL COMMENT 'for M&S \n\nTracking Label Qty',
  `srp_qty` int(11) DEFAULT NULL,
  `user_schedule` varchar(45) NOT NULL COMMENT 'schedule number',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='Matrix \n\nto refer standard carton qty';

/*Table structure for table `carton_weight_chart` */

DROP TABLE IF EXISTS `carton_weight_chart`;

CREATE TABLE `carton_weight_chart` (
  `user_style` varchar(50) NOT NULL COMMENT 'User Defined Style',
  `buyer` varchar(50) NOT NULL,
  `buyer_identity` varchar(50) NOT NULL COMMENT 'L & O for VS Logo; P & K for VS Pink;  M for M&S; D for DIM',
  `style_description` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `carton_dimension` varchar(100) NOT NULL,
  `packing_method` varchar(50) NOT NULL COMMENT 'Packing \n\nMethod (Assortment Reference)',
  `xs` float NOT NULL DEFAULT '0',
  `s` float NOT NULL DEFAULT '0',
  `m` float NOT NULL DEFAULT '0',
  `l` float NOT NULL DEFAULT '0',
  `xl` float NOT NULL DEFAULT '0',
  `xxl` float NOT NULL DEFAULT '0',
  `xxxl` float NOT NULL DEFAULT '0',
  `s01` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s01',
  `s02` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s02',
  `s03` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s03',
  `s04` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s04',
  `s05` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s05',
  `s06` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s06',
  `s07` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s07',
  `s08` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s08',
  `s09` float NOT NULL DEFAULT '0' COMMENT 'carton \n\nweight of size s09',
  `s10` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s10',
  `s11` float NOT NULL DEFAULT '0' COMMENT 'carton weight \n\nof size s11',
  `s12` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s12',
  `s13` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size \n\ns13',
  `s14` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s14',
  `s15` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s15',
  `s16` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s16',
  `s17` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s17',
  `s18` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s18',
  `s19` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s19',
  `s20` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s20',
  `s21` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s21',
  `s22` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s22',
  `s23` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s23',
  `s24` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s24',
  `s25` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s25',
  `s26` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s26',
  `s27` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s27',
  `s28` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s28',
  `s29` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s29',
  `s30` float NOT NULL DEFAULT '0' COMMENT 'carton \n\nweight of size s30',
  `s31` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s31',
  `s32` float NOT NULL DEFAULT '0' COMMENT 'carton weight \n\nof size s32',
  `s33` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s33',
  `s34` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size \n\ns34',
  `s35` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s35',
  `s36` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s36',
  `s37` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s37',
  `s38` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s38',
  `s39` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s39',
  `s40` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s40',
  `s41` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s41',
  `s42` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s42',
  `s43` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s43',
  `s44` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s44',
  `s45` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s45',
  `s46` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s46',
  `s47` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s47',
  `s48` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s48',
  `s49` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s49',
  `s50` float NOT NULL DEFAULT '0' COMMENT 'carton weight of size s50',
  `remarks` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Tracking ID',
  `status` int(10) NOT NULL COMMENT '0-active , 1- inactive',
  `track_qty` int(11) NOT NULL COMMENT 'for M&S Tracking Label Qty',
  `user_schedule` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `cat_stat_log` */

DROP TABLE IF EXISTS `cat_stat_log`;

CREATE TABLE `cat_stat_log` (
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
  PRIMARY KEY (`tid`),
  UNIQUE KEY `order_tid2` (`order_tid2`),
  KEY `tid` (`tid`,`order_tid`,`category`),
  KEY `clubbing` (`clubbing`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=4267 DEFAULT CHARSET=latin1 COMMENT='To maintain order details (categories) to prepare Lay Plan';

/*Table structure for table `cat_stat_log_archive` */

DROP TABLE IF EXISTS `cat_stat_log_archive`;

CREATE TABLE `cat_stat_log_archive` (
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
  PRIMARY KEY (`tid`),
  UNIQUE KEY `order_tid2` (`order_tid2`),
  KEY `tid` (`tid`,`order_tid`,`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To maintain order details (categories) to prepare Lay Plan';

/*Table structure for table `cuttable_stat_log` */

DROP TABLE IF EXISTS `cuttable_stat_log`;

CREATE TABLE `cuttable_stat_log` (
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
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 COMMENT='To track actual cuttable % on order quantities';

/*Table structure for table `cuttable_stat_log_archive` */

DROP TABLE IF EXISTS `cuttable_stat_log_archive`;

CREATE TABLE `cuttable_stat_log_archive` (
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

/*Table structure for table `cutting_plan_modules` */

DROP TABLE IF EXISTS `cutting_plan_modules`;

CREATE TABLE `cutting_plan_modules` (
  `module_id` varchar(24) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `power_user` varchar(90) DEFAULT NULL,
  `lastup` timestamp NULL DEFAULT NULL,
  `buyer_div` varchar(45) DEFAULT NULL,
  `ims_priority_boxes` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `db_update_log` */

DROP TABLE IF EXISTS `db_update_log`;

CREATE TABLE `db_update_log` (
  `date` date NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `operation` varchar(100) NOT NULL,
  `lupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To track schedule updation status';

/*Table structure for table `disp_db` */

DROP TABLE IF EXISTS `disp_db`;

CREATE TABLE `disp_db` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='To track dispatch details';

/*Table structure for table `disp_mix_temp` */

DROP TABLE IF EXISTS `disp_mix_temp`;

CREATE TABLE `disp_mix_temp` (
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

DROP TABLE IF EXISTS `doc_loc_mapping`;

CREATE TABLE `doc_loc_mapping` (
  `doc_loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_id` int(11) DEFAULT NULL,
  `doc_no` varchar(255) DEFAULT NULL,
  `pcsqty` int(11) DEFAULT NULL,
  `bundlesqty` int(11) DEFAULT NULL,
  `pliesqty` int(11) DEFAULT NULL,
  PRIMARY KEY (`doc_loc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `doc_shade_info` */

DROP TABLE IF EXISTS `doc_shade_info`;

CREATE TABLE `doc_shade_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shade` varchar(255) DEFAULT NULL,
  `plies` int(11) DEFAULT NULL,
  `doc_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `fabric_priorities` */

DROP TABLE IF EXISTS `fabric_priorities`;

CREATE TABLE `fabric_priorities` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(50) NOT NULL,
  `req_time` datetime NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_user` varchar(50) NOT NULL,
  `section` int(11) NOT NULL DEFAULT '0',
  `module` varchar(8) NOT NULL DEFAULT '0',
  `issued_time` datetime NOT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` int(11) NOT NULL DEFAULT '0',
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`),
  KEY `doc_ref` (`doc_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Table structure for table `fabric_priorities_backup` */

DROP TABLE IF EXISTS `fabric_priorities_backup`;

CREATE TABLE `fabric_priorities_backup` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(50) NOT NULL,
  `req_time` datetime NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_user` varchar(50) NOT NULL,
  `section` int(11) NOT NULL DEFAULT '0',
  `module` varchar(8) NOT NULL DEFAULT '0',
  `issued_time` datetime NOT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` int(11) NOT NULL DEFAULT '0',
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3641 DEFAULT CHARSET=latin1;

/*Table structure for table `fabric_priorities_temp` */

DROP TABLE IF EXISTS `fabric_priorities_temp`;

CREATE TABLE `fabric_priorities_temp` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(150) DEFAULT NULL,
  `req_time` datetime DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `fca_audit_fail_db`;

CREATE TABLE `fca_audit_fail_db` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(50) NOT NULL,
  `schedule` int(11) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `pcs` int(11) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(100) DEFAULT NULL,
  `tran_type` int(11) DEFAULT NULL COMMENT 'Transaction Type',
  `fail_reason` varchar(50) NOT NULL COMMENT 'Reason for Fail',
  `done_by` varchar(50) NOT NULL,
  `color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule` (`schedule`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COMMENT='To track FCA fail details';

/*Table structure for table `fca_audit_fail_db_archive` */

DROP TABLE IF EXISTS `fca_audit_fail_db_archive`;

CREATE TABLE `fca_audit_fail_db_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(50) NOT NULL,
  `schedule` int(11) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `pcs` int(11) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(100) DEFAULT NULL,
  `tran_type` int(11) DEFAULT NULL COMMENT 'Transaction Type',
  `fail_reason` varchar(50) NOT NULL COMMENT 'Reason for Fail',
  `done_by` varchar(50) NOT NULL,
  `color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track FCA fail details';

/*Table structure for table `fg_quality_returns` */

DROP TABLE IF EXISTS `fg_quality_returns`;

CREATE TABLE `fg_quality_returns` (
  `ret_trna_tid` int(11) DEFAULT NULL,
  `carton_id` int(11) DEFAULT NULL,
  `carton_doc_ref` varchar(300) DEFAULT NULL,
  `ret_by` varchar(30) DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` varchar(100) DEFAULT NULL COMMENT 'Reason for return',
  `received_by` varchar(100) DEFAULT NULL COMMENT 'Receiving Party'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `ims_exceptions` */

DROP TABLE IF EXISTS `ims_exceptions`;

CREATE TABLE `ims_exceptions` (
  `ims_tid` bigint(20) NOT NULL COMMENT 'IMS TID',
  `ims_rand_track` varchar(200) NOT NULL COMMENT 'IMS Random Track',
  `req_date` datetime NOT NULL COMMENT 'Req Date',
  `req_remarks` varchar(300) NOT NULL COMMENT 'Reason for request',
  `alloted_rand_track` varchar(200) NOT NULL COMMENT 'Alloted Random Track',
  `module` varchar(8) NOT NULL COMMENT 'Module',
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4562 DEFAULT CHARSET=latin1 COMMENT='To update request against pendings.';

/*Table structure for table `ims_log` */

DROP TABLE IF EXISTS `ims_log`;

CREATE TABLE `ims_log` (
  `ims_date` date NOT NULL COMMENT 'Input date',
  `ims_cid` int(11) NOT NULL COMMENT 'Category Reference',
  `ims_doc_no` int(11) NOT NULL COMMENT 'Docket Reference',
  `ims_mod_no` varchar(8) NOT NULL COMMENT 'Module Number',
  `ims_shift` varchar(10) NOT NULL COMMENT 'Shift',
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT '0' COMMENT 'Input Quantity',
  `ims_pro_qty` int(11) NOT NULL COMMENT 'Output Quantity',
  `ims_status` varchar(10) NOT NULL COMMENT 'Status - DONE for completion',
  `bai_pro_ref` varchar(500) NOT NULL COMMENT 'Production log tracking references',
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Last updated time stamp',
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Reference ID',
  `rand_track` bigint(20) NOT NULL COMMENT 'Random track reference',
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  `input_job_rand_no_ref` varchar(50) NOT NULL COMMENT 'reference of input job random #',
  `input_job_no_ref` int(11) NOT NULL COMMENT 'reference of input job number',
  `destination` varchar(10) NOT NULL COMMENT 'destination',
  `pac_tid` int(11) NOT NULL COMMENT 'TID of the pac_stat_log table',
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`),
  KEY `ims_schedule` (`ims_schedule`,`ims_color`,`ims_size`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Table to track IMS';

/*Table structure for table `ims_log_backup` */

DROP TABLE IF EXISTS `ims_log_backup`;

CREATE TABLE `ims_log_backup` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT '0',
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  UNIQUE KEY `bundle_number` (`bai_pro_ref`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`),
  KEY `ims_doc_no` (`ims_doc_no`,`ims_size`),
  KEY `ims_schedule` (`ims_schedule`,`ims_color`,`ims_size`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Clone of IMS_LOG to backup completed WIP entries.';

/*Table structure for table `ims_log_backup_backup` */

DROP TABLE IF EXISTS `ims_log_backup_backup`;

CREATE TABLE `ims_log_backup_backup` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT '0',
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
) ENGINE=MyISAM AUTO_INCREMENT=133614 DEFAULT CHARSET=latin1 COMMENT='Backup of IMS_LOG and IMS_LOG_Backup taking after shipment';

/*Table structure for table `ims_log_bc` */

DROP TABLE IF EXISTS `ims_log_bc`;

CREATE TABLE `ims_log_bc` (
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
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(500) NOT NULL,
  `ims_schedule` varchar(500) NOT NULL,
  `ims_color` varchar(500) NOT NULL,
  `tid` int(11) NOT NULL,
  `tid_ref` int(11) NOT NULL AUTO_INCREMENT,
  `rand_track` int(11) NOT NULL,
  `team_comm` varchar(250) NOT NULL COMMENT 'For updating Team Comments in Production',
  PRIMARY KEY (`tid_ref`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COMMENT='Clone of IMS_log for deleted entries.';

/*Table structure for table `ims_log_ems` */

DROP TABLE IF EXISTS `ims_log_ems`;

CREATE TABLE `ims_log_ems` (
  `ims_date` date NOT NULL COMMENT 'Input date',
  `ims_cid` int(11) NOT NULL COMMENT 'Category Reference',
  `ims_doc_no` int(11) NOT NULL COMMENT 'Docket Reference',
  `ims_mod_no` varchar(8) NOT NULL COMMENT 'Module Number',
  `ims_shift` varchar(10) NOT NULL COMMENT 'Shift',
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT '0' COMMENT 'Input Quantity',
  `ims_pro_qty` int(11) NOT NULL COMMENT 'Output Quantity',
  `ims_status` varchar(10) NOT NULL COMMENT 'Status - DONE for completion',
  `bai_pro_ref` varchar(500) NOT NULL COMMENT 'Production log tracking references',
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Last updated time stamp',
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

DROP TABLE IF EXISTS `ims_log_packing`;

CREATE TABLE `ims_log_packing` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT '0',
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `ims_log_packing_v3`;

CREATE TABLE `ims_log_packing_v3` (
  `ims_date` date NOT NULL,
  `ims_cid` int(11) NOT NULL,
  `ims_doc_no` int(11) NOT NULL,
  `ims_mod_no` varchar(8) NOT NULL,
  `ims_shift` varchar(10) NOT NULL,
  `ims_size` varchar(10) NOT NULL,
  `ims_qty` int(11) NOT NULL DEFAULT '0',
  `ims_pro_qty` int(11) NOT NULL,
  `ims_status` varchar(10) NOT NULL,
  `bai_pro_ref` varchar(500) NOT NULL,
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `ims_log_packing_v3_ber_databasesvc`;

CREATE TABLE `ims_log_packing_v3_ber_databasesvc` (
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

DROP TABLE IF EXISTS `ims_log_packing_v3_sfcsproject1`;

CREATE TABLE `ims_log_packing_v3_sfcsproject1` (
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

/*Table structure for table `ims_sp_db` */

DROP TABLE IF EXISTS `ims_sp_db`;

CREATE TABLE `ims_sp_db` (
  `ims_sp_tid` int(11) NOT NULL AUTO_INCREMENT,
  `req_user` varchar(30) DEFAULT NULL COMMENT 'Requested User (Computer Login)',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` varchar(200) DEFAULT NULL COMMENT 'Reason for requesting new block',
  `module` varchar(8) DEFAULT NULL COMMENT 'Module Requested',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Status - 0-Req, 1-Utilized',
  PRIMARY KEY (`ims_sp_tid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='This table to give special access to update input in IMS';

/*Table structure for table `inputjob_delete_log` */

DROP TABLE IF EXISTS `inputjob_delete_log`;

CREATE TABLE `inputjob_delete_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(150) DEFAULT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` varchar(765) DEFAULT NULL,
  `schedule` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=591 DEFAULT CHARSET=latin1;

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

/*Table structure for table `jobsheet_users` */

DROP TABLE IF EXISTS `jobsheet_users`;

CREATE TABLE `jobsheet_users` (
  `username` varchar(135) DEFAULT NULL,
  `password` varchar(135) DEFAULT NULL,
  `lines` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `kpi_db` */

DROP TABLE IF EXISTS `kpi_db`;

CREATE TABLE `kpi_db` (
  `tid` varchar(200) NOT NULL,
  `date` date DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  `shift` varchar(5) DEFAULT NULL,
  `abs` float NOT NULL COMMENT 'Absenteeism',
  `aud` float NOT NULL COMMENT 'Audit Fail %',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='To maintain cutting KPI';

/*Table structure for table `kpi_ref` */

DROP TABLE IF EXISTS `kpi_ref`;

CREATE TABLE `kpi_ref` (
  `category` varchar(50) DEFAULT NULL,
  `fixed` double DEFAULT NULL,
  `point_r1` double DEFAULT NULL,
  `point_r2` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Reference for Cutting Team KPI Metrics';

/*Table structure for table `lay_plan_delete_track` */

DROP TABLE IF EXISTS `lay_plan_delete_track`;

CREATE TABLE `lay_plan_delete_track` (
  `tid` varchar(150) NOT NULL,
  `schedule_no` varchar(45) DEFAULT NULL,
  `col_desc` varchar(150) DEFAULT NULL,
  `reason` varchar(450) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `line_forecast` */

DROP TABLE IF EXISTS `line_forecast`;

CREATE TABLE `line_forecast` (
  `forcast_id` varchar(55) NOT NULL,
  `module` varchar(45) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`forcast_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `loc_id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `filled_qty` int(11) DEFAULT '0',
  `status` enum('active','inactive') DEFAULT 'active',
  `catagory` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`loc_id`),
  UNIQUE KEY `location` (`loc_name`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Table structure for table `log_rm_ready_in_pool` */

DROP TABLE IF EXISTS `log_rm_ready_in_pool`;

CREATE TABLE `log_rm_ready_in_pool` (
  `d_id` double DEFAULT NULL,
  `doc_no` double DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `m3_bulk_or_lay_reported` */

DROP TABLE IF EXISTS `m3_bulk_or_lay_reported`;

CREATE TABLE `m3_bulk_or_lay_reported` (
  `order_tid` varchar(500) NOT NULL COMMENT 'To track M3 OR reported schedule',
  `log_user` varchar(50) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `m3_offline_dispatch` */

DROP TABLE IF EXISTS `m3_offline_dispatch`;

CREATE TABLE `m3_offline_dispatch` (
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
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exist_report_qty` int(11) NOT NULL COMMENT 'Already Reported Qty',
  PRIMARY KEY (`tran_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `maker_stat_log` */

DROP TABLE IF EXISTS `maker_stat_log`;

CREATE TABLE `maker_stat_log` (
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
  KEY `allocate_ref` (`allocate_ref`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1 COMMENT='To track marker details';

/*Table structure for table `maker_stat_log_archive` */

DROP TABLE IF EXISTS `maker_stat_log_archive`;

CREATE TABLE `maker_stat_log_archive` (
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

/*Table structure for table `marker_ref_matrix` */

DROP TABLE IF EXISTS `marker_ref_matrix`;

CREATE TABLE `marker_ref_matrix` (
  `marker_ref_tid` varchar(20) NOT NULL COMMENT 'marker_ref_id+width',
  `marker_width` varchar(5) NOT NULL,
  `marker_length` varchar(10) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `marker_ref_matrix_archive`;

CREATE TABLE `marker_ref_matrix_archive` (
  `marker_ref_tid` varchar(20) NOT NULL COMMENT 'marker_ref_id+width',
  `marker_width` varchar(5) NOT NULL,
  `marker_length` varchar(10) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
  `login` varchar(100) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COMMENT='Login details for CMS';

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
  `auth_members` text NOT NULL,
  `help_tip` varchar(100) NOT NULL,
  `command` varchar(30) NOT NULL COMMENT 'Shortcut Commands',
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Manufacturing Menu Details';

/*Table structure for table `mix_temp_desti` */

DROP TABLE IF EXISTS `mix_temp_desti`;

CREATE TABLE `mix_temp_desti` (
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='For Temp table for Order Mixing (for Job Level)';

/*Table structure for table `mix_temp_source` */

DROP TABLE IF EXISTS `mix_temp_source`;

CREATE TABLE `mix_temp_source` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='For Temp table for Order Mixing (for Job Level)';

/*Table structure for table `mod_back_color` */

DROP TABLE IF EXISTS `mod_back_color`;

CREATE TABLE `mod_back_color` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `mod_no` varchar(5) DEFAULT NULL COMMENT 'Module number',
  `back_color` varchar(20) DEFAULT NULL COMMENT 'background color',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `order_plan` */

DROP TABLE IF EXISTS `order_plan`;

CREATE TABLE `order_plan` (
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

DROP TABLE IF EXISTS `orders_club_schedule`;

CREATE TABLE `orders_club_schedule` (
  `order_del_no` varchar(10) DEFAULT NULL,
  `order_col_des` varchar(50) DEFAULT NULL,
  `destination` varchar(10) DEFAULT NULL,
  `size_code` varchar(500) DEFAULT NULL,
  `orginal_size_code` varchar(500) DEFAULT NULL,
  `order_qty` varchar(500) DEFAULT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=347 DEFAULT CHARSET=latin1;

/*Table structure for table `orders_cut_split_db` */

DROP TABLE IF EXISTS `orders_cut_split_db`;

CREATE TABLE `orders_cut_split_db` (
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

DROP TABLE IF EXISTS `pac_sawing_out`;

CREATE TABLE `pac_sawing_out` (
  `tid` int(100) NOT NULL AUTO_INCREMENT,
  `input_job_random` varchar(50) DEFAULT NULL,
  `input_job_number` varchar(44) DEFAULT NULL,
  `doc_no` varchar(30) DEFAULT NULL,
  `order_tid` text,
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

DROP TABLE IF EXISTS `pac_sawing_out_archive`;

CREATE TABLE `pac_sawing_out_archive` (
  `tid` int(100) NOT NULL AUTO_INCREMENT,
  `input_job_random` varchar(50) DEFAULT NULL,
  `input_job_number` varchar(44) DEFAULT NULL,
  `doc_no` varchar(30) DEFAULT NULL,
  `order_tid` text,
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

DROP TABLE IF EXISTS `pac_stat_log`;

CREATE TABLE `pac_stat_log` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(10) DEFAULT NULL,
  `carton_no` smallint(5) unsigned DEFAULT NULL,
  `carton_mode` char(1) DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(1000) DEFAULT NULL,
  `container` smallint(7) unsigned DEFAULT NULL,
  `disp_carton_no` tinyint(2) unsigned DEFAULT NULL,
  `disp_id` tinyint(2) unsigned DEFAULT NULL,
  `audit_status` char(7) DEFAULT NULL,
  `scan_date` datetime DEFAULT NULL,
  `scan_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `doc_no` (`doc_no`),
  KEY `doc_no_ref` (`tid`,`doc_no`,`size_code`),
  KEY `status` (`status`),
  KEY `carton_act_qty` (`carton_act_qty`),
  KEY `size_code` (`size_code`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=20569 DEFAULT CHARSET=latin1 COMMENT='Carton details table';

/*Table structure for table `pac_stat_log_backup` */

DROP TABLE IF EXISTS `pac_stat_log_backup`;

CREATE TABLE `pac_stat_log_backup` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL COMMENT 'F-Full/P-Partial',
  `carton_act_qty` int(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `container` int(11) DEFAULT NULL,
  `disp_carton_no` int(11) DEFAULT NULL COMMENT 'to capture pending cartons',
  `disp_id` int(11) DEFAULT NULL COMMENT 'to capture failed events',
  `audit_status` int(11) DEFAULT NULL COMMENT '0- OK, 1- Not OK ',
  `scan_date` datetime DEFAULT NULL,
  `scan_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Clone of Pac_Stat_Log for system backup after shipment';

/*Table structure for table `pac_stat_log_deleted` */

DROP TABLE IF EXISTS `pac_stat_log_deleted`;

CREATE TABLE `pac_stat_log_deleted` (
  `tid` int(11) NOT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL COMMENT 'F-Full/P-Partial',
  `carton_act_qty` int(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `container` int(11) DEFAULT NULL,
  `disp_carton_no` int(11) DEFAULT NULL,
  `disp_id` int(11) DEFAULT NULL,
  `audit_status` int(11) DEFAULT NULL,
  `scan_date` datetime DEFAULT NULL,
  `scan_user` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Clone of Pac_Stat_Log to track deleted carton details';

/*Table structure for table `pac_stat_log_input_job` */

DROP TABLE IF EXISTS `pac_stat_log_input_job`;

CREATE TABLE `pac_stat_log_input_job` (
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
  PRIMARY KEY (`tid`),
  KEY `doc_no` (`doc_no`)
) ENGINE=MyISAM AUTO_INCREMENT=4550 DEFAULT CHARSET=latin1;

/*Table structure for table `pac_stat_log_new` */

DROP TABLE IF EXISTS `pac_stat_log_new`;

CREATE TABLE `pac_stat_log_new` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(10) DEFAULT NULL,
  `carton_no` smallint(5) unsigned DEFAULT NULL,
  `carton_mode` char(1) DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `pac_stat_log_new_archive`;

CREATE TABLE `pac_stat_log_new_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(10) DEFAULT NULL,
  `carton_no` smallint(5) unsigned DEFAULT NULL,
  `carton_mode` char(1) DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `pac_stat_log_partial`;

CREATE TABLE `pac_stat_log_partial` (
  `carton_id` bigint(20) NOT NULL,
  `partial_qty` int(11) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track split label details';

/*Table structure for table `pac_stat_log_sch_temp` */

DROP TABLE IF EXISTS `pac_stat_log_sch_temp`;

CREATE TABLE `pac_stat_log_sch_temp` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL COMMENT 'F-Full/P-Partial',
  `carton_act_qty` int(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(200) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Temp table for packing summary';

/*Table structure for table `packing_dashboard_alert_temp` */

DROP TABLE IF EXISTS `packing_dashboard_alert_temp`;

CREATE TABLE `packing_dashboard_alert_temp` (
  `tid` int(11) DEFAULT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL,
  `carton_act_qty` decimal(10,0) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `packing_dashboard_pop_temp`;

CREATE TABLE `packing_dashboard_pop_temp` (
  `tid` int(11) DEFAULT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL,
  `carton_act_qty` decimal(10,0) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `packing_dashboard_temp`;

CREATE TABLE `packing_dashboard_temp` (
  `tid` int(11) DEFAULT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `carton_no` int(11) DEFAULT NULL,
  `carton_mode` varchar(11) DEFAULT NULL,
  `carton_act_qty` decimal(10,0) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `packing_summary_tmp`;

CREATE TABLE `packing_summary_tmp` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `tid` int(11) NOT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `packing_summary_tmp_v1`;

CREATE TABLE `packing_summary_tmp_v1` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `tid` int(11) NOT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `packing_summary_tmp_v3`;

CREATE TABLE `packing_summary_tmp_v3` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(300) DEFAULT NULL,
  `tid` int(11) NOT NULL,
  `size_code` varchar(20) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `packing_summary_tmp_v3_ber_databasesvc`;

CREATE TABLE `packing_summary_tmp_v3_ber_databasesvc` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(1000) DEFAULT NULL,
  `tid` int(11) NOT NULL DEFAULT '0',
  `size_code` varchar(10) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `container` smallint(7) unsigned DEFAULT NULL,
  `disp_carton_no` tinyint(2) unsigned DEFAULT NULL,
  `disp_id` tinyint(2) unsigned DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `audit_status` char(7) DEFAULT NULL,
  `order_style_no` varchar(60),
  `order_del_no` varchar(60),
  `order_col_des` varchar(150),
  `acutno` int(11) COMMENT 'Actual Cutno\r\n'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `packing_summary_tmp_v3_sfcsproject1` */

DROP TABLE IF EXISTS `packing_summary_tmp_v3_sfcsproject1`;

CREATE TABLE `packing_summary_tmp_v3_sfcsproject1` (
  `doc_no` bigint(20) DEFAULT NULL,
  `doc_no_ref` varchar(1000) DEFAULT NULL,
  `tid` int(11) NOT NULL DEFAULT '0',
  `size_code` varchar(10) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `status` char(8) DEFAULT NULL,
  `lastup` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `container` smallint(7) unsigned DEFAULT NULL,
  `disp_carton_no` tinyint(2) unsigned DEFAULT NULL,
  `disp_id` tinyint(2) unsigned DEFAULT NULL,
  `carton_act_qty` smallint(7) unsigned DEFAULT NULL,
  `audit_status` char(7) DEFAULT NULL,
  `order_style_no` varchar(60),
  `order_del_no` varchar(60),
  `order_col_des` varchar(150),
  `acutno` int(11) COMMENT 'Actual Cutno\r\n'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `party_db` */

DROP TABLE IF EXISTS `party_db`;

CREATE TABLE `party_db` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `party_details` varchar(500) NOT NULL,
  `order_no` int(11) NOT NULL,
  `party_name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard` */

DROP TABLE IF EXISTS `plan_dashboard`;

CREATE TABLE `plan_dashboard` (
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
) ENGINE=MyISAM AUTO_INCREMENT=218 DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_change_log` */

DROP TABLE IF EXISTS `plan_dashboard_change_log`;

CREATE TABLE `plan_dashboard_change_log` (
  `doc_no` bigint(20) DEFAULT NULL,
  `record_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `record_user` varchar(100) DEFAULT NULL,
  `record_comment` text,
  KEY `doc_no` (`doc_no`),
  KEY `record_user` (`record_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input` */

DROP TABLE IF EXISTS `plan_dashboard_input`;

CREATE TABLE `plan_dashboard_input` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) DEFAULT NULL,
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  PRIMARY KEY (`input_job_no_random_ref`),
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`)
) ENGINE=InnoDB AUTO_INCREMENT=1884 DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input1` */

DROP TABLE IF EXISTS `plan_dashboard_input1`;

CREATE TABLE `plan_dashboard_input1` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) NOT NULL DEFAULT '',
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  PRIMARY KEY (`input_job_no_random_ref`),
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`),
  KEY `plan_dashboard_input_jobnoref` (`input_job_no_random_ref`,`input_module`,`track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input_backup` */

DROP TABLE IF EXISTS `plan_dashboard_input_backup`;

CREATE TABLE `plan_dashboard_input_backup` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) DEFAULT NULL,
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '1-Partial Input, 2-Full Input',
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `input_trims_request_time` datetime DEFAULT NULL COMMENT 'Request Time ',
  PRIMARY KEY (`input_job_no_random_ref`),
  KEY `track_id` (`track_id`),
  KEY `input_module` (`input_module`,`input_priority`)
) ENGINE=MyISAM AUTO_INCREMENT=61876 DEFAULT CHARSET=latin1;

/*Table structure for table `plan_dashboard_input_deleted` */

DROP TABLE IF EXISTS `plan_dashboard_input_deleted`;

CREATE TABLE `plan_dashboard_input_deleted` (
  `input_job_no_random_ref` varchar(30) NOT NULL,
  `input_module` varchar(10) NOT NULL DEFAULT '',
  `input_priority` int(11) DEFAULT NULL,
  `input_trims_status` int(11) DEFAULT NULL,
  `input_panel_status` int(11) DEFAULT NULL COMMENT 'Panel input to line status',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '1-Partial Input, 2-Full Input',
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

DROP TABLE IF EXISTS `plan_doc_summ_input_sfcsproject1`;

CREATE TABLE `plan_doc_summ_input_sfcsproject1` (
  `st_status` int(11) DEFAULT NULL COMMENT 'Sewing_Trims_Status 1-available, 0- NOT, NULL - NOT Updated',
  `act_cut_status` varchar(50) DEFAULT NULL,
  `doc_no` int(11) DEFAULT NULL COMMENT 'Docket No\r\n',
  `order_style_no` varchar(60),
  `order_del_no` varchar(60),
  `order_col_des` varchar(150),
  `total` decimal(32,0) DEFAULT NULL,
  `acutno` varchar(255) DEFAULT NULL,
  `color_code` blob,
  `input_job_no` varchar(255) DEFAULT NULL,
  `input_job_no_random` varchar(90) DEFAULT NULL,
  `input_job_no_random_ref` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `plan_modules` */

DROP TABLE IF EXISTS `plan_modules`;

CREATE TABLE `plan_modules` (
  `module_id` varchar(8) NOT NULL,
  `section_id` smallint(6) NOT NULL,
  `power_user` varchar(30) NOT NULL,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `buyer_div` varchar(15) NOT NULL,
  `ims_priority_boxes` int(11) NOT NULL,
  `table_tid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`table_tid`),
  KEY `NewIndex1` (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log` */

DROP TABLE IF EXISTS `plandoc_stat_log`;

CREATE TABLE `plandoc_stat_log` (
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
  `log_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last Updated',
  `destination` varchar(11) DEFAULT NULL,
  `org_doc_no` int(11) DEFAULT '0',
  `org_plies` int(11) DEFAULT '0',
  `act_movement_status` varchar(25) DEFAULT NULL,
  `docket_printed_person` varchar(20) NOT NULL,
  PRIMARY KEY (`doc_no`),
  KEY `date` (`date`,`cat_ref`,`p_plies`,`a_plies`),
  KEY `order_tid` (`order_tid`),
  KEY `act_cut_issue_status` (`act_cut_issue_status`),
  KEY `act_cut_issue_status1` (`act_cut_status`),
  KEY `act_cut_status` (`act_cut_status`,`act_cut_issue_status`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`),
  KEY `doc_no_ref` (`doc_no`)
) ENGINE=InnoDB AUTO_INCREMENT=1035 DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log_archive` */

DROP TABLE IF EXISTS `plandoc_stat_log_archive`;

CREATE TABLE `plandoc_stat_log_archive` (
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
  `log_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log_cat_log_ref_temp` */

DROP TABLE IF EXISTS `plandoc_stat_log_cat_log_ref_temp`;

CREATE TABLE `plandoc_stat_log_cat_log_ref_temp` (
  `order_del_no` bigint(20) DEFAULT NULL,
  `doc_no` bigint(20) DEFAULT NULL,
  `act_cut_status` varchar(20) DEFAULT NULL,
  `doc_total` bigint(20) DEFAULT NULL,
  `act_cut_issue_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `plandoc_stat_log_sch_temp` */

DROP TABLE IF EXISTS `plandoc_stat_log_sch_temp`;

CREATE TABLE `plandoc_stat_log_sch_temp` (
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

DROP TABLE IF EXISTS `printed_job_sheet`;

CREATE TABLE `printed_job_sheet` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(20) DEFAULT NULL,
  `printed_time` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

/*Table structure for table `pro_stat_log` */

DROP TABLE IF EXISTS `pro_stat_log`;

CREATE TABLE `pro_stat_log` (
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

DROP TABLE IF EXISTS `ratio_input_update`;

CREATE TABLE `ratio_input_update` (
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'tid reference',
  `style` varchar(60) NOT NULL,
  `schedule` varchar(60) NOT NULL,
  `color` varchar(60) NOT NULL,
  `size` varchar(60) NOT NULL,
  `ratio_qty` varchar(30) NOT NULL,
  `username` varchar(60) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rand_track_no` varchar(60) NOT NULL,
  `order_tid` varchar(60) NOT NULL,
  `set_type` varchar(45) NOT NULL COMMENT 'identify size set',
  `sfcs_size` varchar(45) NOT NULL COMMENT 'sfcs size',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `recut_ims_log` */

DROP TABLE IF EXISTS `recut_ims_log`;

CREATE TABLE `recut_ims_log` (
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
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `recut_ims_log_backup` */

DROP TABLE IF EXISTS `recut_ims_log_backup`;

CREATE TABLE `recut_ims_log_backup` (
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
  `ims_log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ims_remarks` varchar(200) NOT NULL,
  `ims_style` varchar(100) NOT NULL,
  `ims_schedule` varchar(50) NOT NULL,
  `ims_color` varchar(300) NOT NULL,
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tid`),
  KEY `ims_size` (`ims_size`,`ims_style`,`ims_schedule`,`ims_color`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `recut_track` */

DROP TABLE IF EXISTS `recut_track`;

CREATE TABLE `recut_track` (
  `doc_no` double DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `sys_name` varchar(50) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `recut_v1` */

DROP TABLE IF EXISTS `recut_v1`;

CREATE TABLE `recut_v1` (
  `rec_doc_no` int(11) NOT NULL AUTO_INCREMENT,
  `rec_order_tid` varchar(500) NOT NULL,
  `cat_ref` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

DROP TABLE IF EXISTS `recut_v2`;

CREATE TABLE `recut_v2` (
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
  `log_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`),
  KEY `plan_module` (`plan_module`),
  KEY `act_cut_status` (`act_cut_status`,`act_cut_issue_status`),
  KEY `act_cut_issue_status1` (`act_cut_status`),
  KEY `act_cut_issue_status` (`act_cut_issue_status`),
  KEY `order_tid` (`order_tid`),
  KEY `date` (`date`,`cat_ref`,`p_plies`,`a_plies`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Table structure for table `recut_v2_archive` */

DROP TABLE IF EXISTS `recut_v2_archive`;

CREATE TABLE `recut_v2_archive` (
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
  `log_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`doc_no`),
  KEY `doc_no` (`cat_ref`,`order_tid`,`doc_no`)
) ENGINE=MyISAM AUTO_INCREMENT=1670 DEFAULT CHARSET=latin1;

/*Table structure for table `rej_stat_log` */

DROP TABLE IF EXISTS `rej_stat_log`;

CREATE TABLE `rej_stat_log` (
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

DROP TABLE IF EXISTS `review_print_track`;

CREATE TABLE `review_print_track` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `ref_tid` varchar(500) NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_user` varchar(50) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=228 DEFAULT CHARSET=latin1;

/*Table structure for table `schedule_oprations_master` */

DROP TABLE IF EXISTS `schedule_oprations_master`;

CREATE TABLE `schedule_oprations_master` (
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
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=23445 DEFAULT CHARSET=latin1;

/*Table structure for table `schedule_oprations_master_backup` */

DROP TABLE IF EXISTS `schedule_oprations_master_backup`;

CREATE TABLE `schedule_oprations_master_backup` (
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
  `Main_WorkCenterId` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sections_db` */

DROP TABLE IF EXISTS `sections_db`;

CREATE TABLE `sections_db` (
  `sec_id` int(11) NOT NULL,
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
  PRIMARY KEY (`sec_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `ship_stat_log` */

DROP TABLE IF EXISTS `ship_stat_log`;

CREATE TABLE `ship_stat_log` (
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
  `last_up` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last Updated',
  `ship_color` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`ship_tid`),
  KEY `ship_schedule` (`ship_schedule`),
  KEY `ship_status` (`ship_status`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

/*Table structure for table `shipment_plan` */

DROP TABLE IF EXISTS `shipment_plan`;

CREATE TABLE `shipment_plan` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sp_sample_order_db` */

DROP TABLE IF EXISTS `sp_sample_order_db`;

CREATE TABLE `sp_sample_order_db` (
  `order_tid` varchar(200) NOT NULL COMMENT 'Clubbing of Style Schedule color ID',
  `ims_ref_tid` varchar(100) NOT NULL COMMENT 'Ims log referance number',
  `size` varchar(20) NOT NULL COMMENT 'Size name',
  `input_qty` varchar(10) NOT NULL COMMENT 'plan sample quantity of size',
  `remarks` varchar(50) NOT NULL COMMENT 'IMS remark verification',
  `user` varchar(50) NOT NULL COMMENT 'Update user name',
  `log_time` datetime NOT NULL COMMENT 'Log date & time',
  PRIMARY KEY (`order_tid`,`size`,`remarks`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `speed_del_dashboard` */

DROP TABLE IF EXISTS `speed_del_dashboard`;

CREATE TABLE `speed_del_dashboard` (
  `speed_style` varchar(100) NOT NULL DEFAULT '-',
  `speed_act` int(11) NOT NULL DEFAULT '0',
  `speed_plan` int(11) NOT NULL DEFAULT '0',
  `speed_schedule` bigint(20) NOT NULL DEFAULT '0',
  `speed_order_qty` int(11) NOT NULL DEFAULT '0',
  `speed_cut_qty` int(11) NOT NULL DEFAULT '0',
  `speed_in_qty` int(11) NOT NULL DEFAULT '0',
  `speed_out_qty` int(11) NOT NULL DEFAULT '0',
  `speed_fab_stat` varchar(100) NOT NULL DEFAULT '-',
  `speed_elastic_stat` varchar(100) NOT NULL DEFAULT '-',
  `speed_label_stat` varchar(100) NOT NULL DEFAULT '-',
  `speed_thread_stat` varchar(100) NOT NULL DEFAULT '-',
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_hrs` float NOT NULL DEFAULT '0',
  `today_hrs` float NOT NULL DEFAULT '0',
  `till_yst_plan` int(11) DEFAULT '0',
  `today_per_hr_plan` int(11) DEFAULT '0',
  `audited` int(11) NOT NULL,
  `fgqty` int(11) NOT NULL,
  `pending_carts` int(11) NOT NULL,
  `internal_audited` int(11) NOT NULL,
  KEY `speed_schedule` (`speed_schedule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `style_db` */

DROP TABLE IF EXISTS `style_db`;

CREATE TABLE `style_db` (
  `style` varchar(50) NOT NULL,
  PRIMARY KEY (`style`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_carton` */

DROP TABLE IF EXISTS `tbl_carton`;

CREATE TABLE `tbl_carton` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_schedule` varchar(20) NOT NULL,
  `cr_qty` int(11) NOT NULL,
  `cr_time` datetime DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cr_id`),
  KEY `NewIndex1` (`cr_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `tbl_category`;

CREATE TABLE `tbl_category` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_cif` */

DROP TABLE IF EXISTS `tbl_cif`;

CREATE TABLE `tbl_cif` (
  `cif_id` int(11) NOT NULL AUTO_INCREMENT,
  `cif_schedule` varchar(20) NOT NULL,
  `cif_qty` varchar(10) NOT NULL,
  `cif_time` datetime DEFAULT NULL,
  `cif_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cif_id`),
  KEY `NewIndex1` (`cif_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_cif_complete` */

DROP TABLE IF EXISTS `tbl_cif_complete`;

CREATE TABLE `tbl_cif_complete` (
  `cif_schedule` varchar(20) NOT NULL,
  `cif_time` datetime NOT NULL,
  `cif_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cif_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_comment` */

DROP TABLE IF EXISTS `tbl_comment`;

CREATE TABLE `tbl_comment` (
  `cm_id` double NOT NULL AUTO_INCREMENT,
  `sch_no` varchar(30) DEFAULT NULL,
  `sch_cmnt` blob,
  `date_n_time` datetime DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `possible_ex` varchar(45) DEFAULT NULL,
  `comp_date` varchar(45) DEFAULT NULL,
  `fca` varchar(45) DEFAULT NULL,
  `cif` varchar(45) DEFAULT NULL,
  `dispatch` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_cutting_table` */

DROP TABLE IF EXISTS `tbl_cutting_table`;

CREATE TABLE `tbl_cutting_table` (
  `tbl_id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_name` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`tbl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_fca` */

DROP TABLE IF EXISTS `tbl_fca`;

CREATE TABLE `tbl_fca` (
  `fca_id` int(11) NOT NULL AUTO_INCREMENT,
  `fca_schedule` varchar(20) NOT NULL,
  `fca_qty` varchar(20) NOT NULL,
  `fca_time` datetime DEFAULT NULL,
  `fca_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`fca_id`),
  KEY `sch` (`fca_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_fca_complete` */

DROP TABLE IF EXISTS `tbl_fca_complete`;

CREATE TABLE `tbl_fca_complete` (
  `fca_schedule` varchar(20) NOT NULL,
  `fca_time` datetime NOT NULL,
  `fca_username` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`fca_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_fg_crt_handover_team_list` */

DROP TABLE IF EXISTS `tbl_fg_crt_handover_team_list`;

CREATE TABLE `tbl_fg_crt_handover_team_list` (
  `emp_id` varchar(50) DEFAULT NULL COMMENT 'emp_id',
  `team_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
  `emp_call_name` varchar(200) DEFAULT NULL COMMENT 'call name',
  `selected_user` varchar(200) DEFAULT NULL COMMENT 'current scanning user',
  `emp_status` int(11) DEFAULT NULL COMMENT '0-active, 1-inactive',
  `lastup` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`team_id`),
  UNIQUE KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_plant_timings` */

DROP TABLE IF EXISTS `tbl_plant_timings`;

CREATE TABLE `tbl_plant_timings` (
  `time_id` int(11) NOT NULL AUTO_INCREMENT,
  `time_value` varchar(255) NOT NULL,
  `time_display` varchar(255) NOT NULL,
  `day_part` varchar(255) NOT NULL,
  PRIMARY KEY (`time_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_product_master` */

DROP TABLE IF EXISTS `tbl_product_master`;

CREATE TABLE `tbl_product_master` (
  `order_tid` varchar(200) NOT NULL,
  `order_style_no` varchar(60) DEFAULT NULL,
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `smv` float(11,2) DEFAULT NULL,
  `smo` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_serial_number` */

DROP TABLE IF EXISTS `tbl_serial_number`;

CREATE TABLE `tbl_serial_number` (
  `serial_no` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_size_lable` */

DROP TABLE IF EXISTS `tbl_size_lable`;

CREATE TABLE `tbl_size_lable` (
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

DROP TABLE IF EXISTS `tbl_size_matrix`;

CREATE TABLE `tbl_size_matrix` (
  `buyer_division` varchar(900) DEFAULT NULL,
  `sfcs_size_code` varchar(90) DEFAULT NULL,
  `m3_size_code` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_user_auth` */

DROP TABLE IF EXISTS `tbl_user_auth`;

CREATE TABLE `tbl_user_auth` (
  `u_id` double NOT NULL AUTO_INCREMENT,
  `username` varchar(500) DEFAULT NULL COMMENT 'username',
  `password` text COMMENT 'passwrd',
  `active_flag` int(11) DEFAULT NULL COMMENT '1=active, 0=deactive',
  `user_type` varchar(100) DEFAULT NULL COMMENT 'user level',
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `temp_delivery_schedule` */

DROP TABLE IF EXISTS `temp_delivery_schedule`;

CREATE TABLE `temp_delivery_schedule` (
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

DROP TABLE IF EXISTS `temp_line_input_log`;

CREATE TABLE `temp_line_input_log` (
  `log_id` double NOT NULL AUTO_INCREMENT,
  `schedule_no` varchar(33) DEFAULT NULL,
  `style` varchar(30) DEFAULT NULL,
  `input_job_no` varchar(33) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `date_n_time` datetime DEFAULT NULL,
  `page_name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `tpd_plan_dash_doc_summ` */

DROP TABLE IF EXISTS `tpd_plan_dash_doc_summ`;

CREATE TABLE `tpd_plan_dash_doc_summ` (
  `print_status` date DEFAULT NULL,
  `plan_lot_ref` text,
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

DROP TABLE IF EXISTS `tpd_plan_dash_summ`;

CREATE TABLE `tpd_plan_dash_summ` (
  `doc_no` double DEFAULT NULL,
  `module` varchar(24) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `fabric_status` int(11) DEFAULT NULL,
  `act_cut_issue_status` varchar(50) DEFAULT NULL,
  `plan_lot_ref` text,
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

DROP TABLE IF EXISTS `tpd_plan_dashboard`;

CREATE TABLE `tpd_plan_dashboard` (
  `module` varchar(24) DEFAULT NULL,
  `doc_no` double NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `fabric_status` int(11) DEFAULT NULL,
  `log_time` datetime NOT NULL,
  `track_id` int(11) NOT NULL,
  PRIMARY KEY (`doc_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `transport_modes` */

DROP TABLE IF EXISTS `transport_modes`;

CREATE TABLE `transport_modes` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `transport_mode` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `trims_dashboard` */

DROP TABLE IF EXISTS `trims_dashboard`;

CREATE TABLE `trims_dashboard` (
  `doc_ref` int(11) NOT NULL,
  `priority` double DEFAULT NULL,
  `plan_time` datetime NOT NULL,
  `module` double DEFAULT NULL,
  `section` double DEFAULT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` double NOT NULL DEFAULT '0',
  `tid` double NOT NULL AUTO_INCREMENT,
  `log_user` varchar(50) NOT NULL,
  PRIMARY KEY (`doc_ref`),
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `trims_dashboard_backup` */

DROP TABLE IF EXISTS `trims_dashboard_backup`;

CREATE TABLE `trims_dashboard_backup` (
  `doc_ref` double DEFAULT NULL,
  `priority` double DEFAULT NULL,
  `plan_time` datetime NOT NULL,
  `module` double DEFAULT NULL,
  `section` double DEFAULT NULL,
  `trims_req_time` datetime NOT NULL,
  `trims_issued_time` datetime NOT NULL,
  `trims_status` double NOT NULL DEFAULT '0',
  `tid` double NOT NULL AUTO_INCREMENT,
  `log_user` varchar(50) NOT NULL,
  UNIQUE KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `trims_priorities` */

DROP TABLE IF EXISTS `trims_priorities`;

CREATE TABLE `trims_priorities` (
  `doc_ref` double NOT NULL,
  `doc_ref_club` varchar(50) NOT NULL,
  `req_time` datetime NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_user` varchar(50) NOT NULL,
  `section` int(11) NOT NULL DEFAULT '0',
  `module` varchar(8) NOT NULL DEFAULT '0',
  `issued_time` datetime NOT NULL,
  PRIMARY KEY (`doc_ref`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `call_sync_dump` */

/*!50106 DROP EVENT IF EXISTS `call_sync_dump`*/;

DELIMITER $$

/*!50106 CREATE EVENT `call_sync_dump` ON SCHEDULE EVERY 5 MINUTE STARTS '2017-05-30 05:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	   	 CALL carton_scan_dump();
	   END */$$
DELIMITER ;

/* Function  structure for function  `fn_act_pac_qty` */

/*!50003 DROP FUNCTION IF EXISTS `fn_act_pac_qty` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_act_pac_qty`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	   SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(carton_act_qty),0) FROM pac_stat_log WHERE doc_no=in_ims_doc_no AND size_code=in_ims_size AND STATUS="DONE");
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;	 
	  RETURN var_name;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_act_ship_qty` */

/*!50003 DROP FUNCTION IF EXISTS `fn_act_ship_qty` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_act_ship_qty`(in_sch_no BIGINT) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	  /*SET var_name=(SELECT COALESCE(SUM(shipped),0) FROM bai_ship_cts_ref WHERE ship_schedule=in_sch_no);*/
	  SET var_name=(SELECT
  COALESCE(SUM((((((((((((((((((((`ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08`) + `ship_stat_log`.`ship_s_s10`) + `ship_stat_log`.`ship_s_s12`) + `ship_stat_log`.`ship_s_s14`) + `ship_stat_log`.`ship_s_s16`) + `ship_stat_log`.`ship_s_s18`) + `ship_stat_log`.`ship_s_s20`) + `ship_stat_log`.`ship_s_s22`) + `ship_stat_log`.`ship_s_s24`) + `ship_stat_log`.`ship_s_s26`) + `ship_stat_log`.`ship_s_s28`) + `ship_stat_log`.`ship_s_s30`) + `ship_stat_log`.`ship_s_xs`) + `ship_stat_log`.`ship_s_s`) + `ship_stat_log`.`ship_s_m`) + `ship_stat_log`.`ship_s_l`) + `ship_stat_log`.`ship_s_xl`) + `ship_stat_log`.`ship_s_xxl`) + `ship_stat_log`.`ship_s_xxxl`)),0) AS `shipped`
FROM `ship_stat_log`
WHERE (ship_schedule=in_sch_no AND `ship_stat_log`.`ship_status` = 2));
	  RETURN var_name;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_buyer_division_sch` */

/*!50003 DROP FUNCTION IF EXISTS `fn_buyer_division_sch` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_buyer_division_sch`(in_schedule VARCHAR(100)) RETURNS varchar(100) CHARSET latin1
BEGIN
	DECLARE order_div_name VARCHAR(200);
	set order_div_name=(SELECT order_div FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no=in_schedule limit 1);
	if LENGTH(order_div_name)=0 or order_div_name is null then
		SET order_div_name=(SELECT order_div FROM bai_pro3.bai_orders_db_confirm_archive WHERE order_del_no=in_schedule LIMIT 1);
	end if;
	
	return order_div_name;
END */$$
DELIMITER ;

/* Function  structure for function  `fn_ims_log_bk_output` */

/*!50003 DROP FUNCTION IF EXISTS `fn_ims_log_bk_output` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_ims_log_bk_output`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	   SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(ims_pro_qty),0) FROM ims_log_backup WHERE ims_doc_no=in_ims_doc_no AND ims_size=("a_"+in_ims_size) AND ims_mod_no > 0);
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;	  
	  RETURN var_name;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_ims_log_output` */

/*!50003 DROP FUNCTION IF EXISTS `fn_ims_log_output` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_ims_log_output`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(ims_pro_qty),0) FROM ims_log WHERE ims_doc_no=in_ims_doc_no AND ims_size=("a_"+in_ims_size) AND ims_mod_no > 0);
	SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
	  RETURN var_name;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_know_binding_con` */

/*!50003 DROP FUNCTION IF EXISTS `fn_know_binding_con` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_know_binding_con`(ord_id VARCHAR(200)) RETURNS float(10,4)
BEGIN
DECLARE bin_con FLOAT(10,4);
SET @bin_con = (SELECT COALESCE(binding_con,0) FROM `bai_orders_db_remarks` WHERE order_tid=ord_id);
RETURN COALESCE(@bin_con,0);
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_savings_per_cal` */

/*!50003 DROP FUNCTION IF EXISTS `fn_savings_per_cal` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_savings_per_cal`(dat date,cat_re BIGINT,sch VARCHAR(300),col VARCHAR(300)) RETURNS float(10,2)
BEGIN
    /* This function created on 20140207 by KiranG, to get additional material calculation based on the savings above 1% */
	DECLARE order_qty BIGINT;
	DECLARE actyy FLOAT(10,2);
	DECLARE multipleval FLOAT(10,2);
	
	if dat>'2014-02-07' THEN
		
		SET @order_qty = (SELECT (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30) FROM bai_orders_db_confirm WHERE order_del_no=sch AND TRIM(BOTH FROM order_col_des)=TRIM(BOTH FROM col));
		
		SET @actyy= (SELECT ROUND(((MIN(catyy)-SUM(mklength*p_plies)/@order_qty)/MIN(catyy))*100,1) FROM order_cat_doc_mk_mix WHERE cat_ref=cat_re);
		
		IF @actyy>1 THEN
			SET @multipleval=0;
		ELSE
			SET @multipleval=0;
		END IF;
	else
		set @multipleval=0.01;
	end if;
	
	RETURN @multipleval;
	
    END */$$
DELIMITER ;

/* Function  structure for function  `input_job_input_status` */

/*!50003 DROP FUNCTION IF EXISTS `input_job_input_status` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `input_job_input_status`(in_job_rand_no_ref VARCHAR(30)) RETURNS varchar(10) CHARSET latin1
    DETERMINISTIC
BEGIN
	DECLARE input_qty BIGINT;
	DECLARE job_qty BIGINT;
	SET @input_qty = (SELECT COALESCE(SUM(in_qty),0) FROM ((SELECT SUM(ims_qty) AS in_qty FROM ims_log_backup WHERE input_job_rand_no_ref=in_job_rand_no_ref) UNION (SELECT SUM(ims_qty) AS in_qty FROM ims_log WHERE input_job_rand_no_ref=in_job_rand_no_ref)) AS tmp);
	
	SET @job_qty = (SELECT SUM(carton_act_qty) FROM pac_stat_log_input_job WHERE input_job_no_random=in_job_rand_no_ref);
	
	IF(@input_qty=@job_qty) THEN
		RETURN 'DONE';
	ELSE
		RETURN '';
	END IF;
    END */$$
DELIMITER ;

/* Function  structure for function  `stripSpeciaChars` */

/*!50003 DROP FUNCTION IF EXISTS `stripSpeciaChars` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `stripSpeciaChars`(`dirty_string` VARCHAR(2048),allow_space TINYINT,allow_number TINYINT,allow_alphabets TINYINT,no_trim TINYINT) RETURNS varchar(2048) CHARSET utf8
BEGIN
/**
*http://devzone.co.in/mysql-function-to-remove-special-characters-accents-non-ascii-characters/
 * MySQL function to remove Special characters, Non-ASCII,hidden characters leads to spaces, accents etc
 * Downloaded from http://DevZone.co.in
 * @param VARCHAR dirty_string : dirty string as input
 * @param VARCHAR allow_space : allow spaces between string in output; takes 0-1 as parameter
 * @param VARCHAR allow_number : allow numbers in output; takes 0-1 as parameter
 * @param VARCHAR allow_alphabets : allow alphabets in output; takes 0-1 as parameter
 * @param VARCHAR no_trim : don't trim the output; takes 0-1 as parameter
 * @return VARCHAR clean_string : clean string as output
 * 
 * Usage Syntax: stripSpeciaChars(string,allow_space,allow_number,allow_alphabets,no_trim);
 * Usage SQL> SELECT stripSpeciaChars("sdfa7987*&^&*ÂÃ ÄÅÆÇÈÉÊ sd sdfgËÌÍÎÏÑ ÒÓÔÕÖØÙÚàáâã sdkarkhru",0,0,1,0);
 * result : sdfasdsdfgsdkarkhru
 */
      DECLARE clean_string VARCHAR(2048) DEFAULT '';
      DECLARE c VARCHAR(2048) DEFAULT '';
      DECLARE counter INT DEFAULT 1;
	  
	  DECLARE has_space TINYINT DEFAULT 0; -- let spaces in result string
	  DECLARE chk_cse TINYINT DEFAULT 0; 
	  DECLARE adv_trim TINYINT DEFAULT 1; -- trim extra spaces along with hidden characters, new line characters etc.	  
	
	     IF allow_number=0 AND allow_alphabets=0 THEN
	    RETURN NULL;
	  ELSEIF allow_number=1 AND allow_alphabets=0 THEN
	  SET chk_cse =1;
	 ELSEIF allow_number=0 AND allow_alphabets=1 THEN
	  SET chk_cse =2;
	  END IF;	  
	  
	  IF allow_space=1 THEN
	  SET has_space =1;
	  END IF;
	  
	   IF no_trim=1 THEN
	  SET adv_trim =0;
	  END IF;
      IF ISNULL(dirty_string) THEN
            RETURN NULL;
      ELSE
	  
	  CASE chk_cse
      WHEN 1 THEN 
	  -- return only Numbers in result
	  WHILE counter <= LENGTH(dirty_string) DO
                   
                  SET c = MID(dirty_string, counter, 1);
                  IF ASCII(c) = 32 OR ASCII(c) >= 48 AND ASCII(c) <= 57  THEN
                        SET clean_string = CONCAT(clean_string, c);
                  END IF;
                  SET counter = counter + 1;
            END WHILE;
      WHEN 2 THEN 
	  -- return only Alphabets in result
	  WHILE counter <= LENGTH(dirty_string) DO
                   
                  SET c = MID(dirty_string, counter, 1);
                  IF ASCII(c) = 32 OR ASCII(c) >= 65 AND ASCII(c) <= 90  OR ASCII(c) >= 97 AND ASCII(c) <= 122 THEN
                        SET clean_string = CONCAT(clean_string, c);
                  END IF;
                  SET counter = counter + 1;
            END WHILE;
      ELSE
	   -- return numbers and Alphabets in result
        WHILE counter <= LENGTH(dirty_string) DO
                   
                  SET c = MID(dirty_string, counter, 1);
                  IF ASCII(c) = 32 OR ASCII(c) >= 48 AND ASCII(c) <= 57 OR ASCII(c) >= 65 AND ASCII(c) <= 90  OR ASCII(c) >= 97 AND ASCII(c) <= 122 THEN
                        SET clean_string = CONCAT(clean_string, c);
                  END IF;
                  SET counter = counter + 1;
            END WHILE;		
    END CASE;            
      END IF;
	 
	  -- remove spaces from result
	  IF has_space=0 THEN
	  SET clean_string =REPLACE(clean_string,' ','');
	  END IF;
	 
	   -- remove extra spaces, newline,tabs. from result
	 IF adv_trim=1 THEN
	  SET clean_string =TRIM(REPLACE(REPLACE(REPLACE(clean_string,'\t',''),'\n',''),'\r',''));
	  END IF;	 
	  
      RETURN clean_string;
END */$$
DELIMITER ;

/*Table structure for table `audit_disp_tb2` */

DROP TABLE IF EXISTS `audit_disp_tb2`;

/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2` */;
/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2` */;

/*!50001 CREATE TABLE  `audit_disp_tb2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `audit_disp_tb2_2` */

DROP TABLE IF EXISTS `audit_disp_tb2_2`;

/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_2` */;
/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_2` */;

/*!50001 CREATE TABLE  `audit_disp_tb2_2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `color` varchar(60) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `audit_disp_tb2_size` */

DROP TABLE IF EXISTS `audit_disp_tb2_size`;

/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_size` */;
/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_size` */;

/*!50001 CREATE TABLE  `audit_disp_tb2_size`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `size` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `audit_disp_tb2_size_2` */

DROP TABLE IF EXISTS `audit_disp_tb2_size_2`;

/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_size_2` */;
/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_size_2` */;

/*!50001 CREATE TABLE  `audit_disp_tb2_size_2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `color` varchar(60) ,
 `size` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `bai_qms_cts_ref` */

DROP TABLE IF EXISTS `bai_qms_cts_ref`;

/*!50001 DROP VIEW IF EXISTS `bai_qms_cts_ref` */;
/*!50001 DROP TABLE IF EXISTS `bai_qms_cts_ref` */;

/*!50001 CREATE TABLE  `bai_qms_cts_ref`(
 `qms_schedule` varchar(20) ,
 `qms_color` varchar(150) ,
 `good_panels` decimal(27,0) ,
 `replaced` decimal(27,0) ,
 `rejected` decimal(27,0) ,
 `sample_room` decimal(27,0) ,
 `good_garments` decimal(27,0) ,
 `recut_raised` decimal(27,0) ,
 `disposed` decimal(27,0) ,
 `sent_to_customer` decimal(27,0) ,
 `actual_recut` decimal(27,0) ,
 `tran_sent` decimal(27,0) ,
 `tran_rec` decimal(27,0) ,
 `resrv_dest` decimal(27,0) ,
 `panel_destroyed` decimal(27,0) 
)*/;

/*Table structure for table `bai_qms_day_report` */

DROP TABLE IF EXISTS `bai_qms_day_report`;

/*!50001 DROP VIEW IF EXISTS `bai_qms_day_report` */;
/*!50001 DROP TABLE IF EXISTS `bai_qms_day_report` */;

/*!50001 CREATE TABLE  `bai_qms_day_report`(
 `qms_tid` int(11) ,
 `qms_style` varchar(30) ,
 `qms_schedule` varchar(20) ,
 `qms_color` varchar(150) ,
 `log_user` varchar(15) ,
 `log_date` date ,
 `log_time` timestamp ,
 `issued_by` varchar(30) ,
 `qms_size` varchar(5) ,
 `good_panels` decimal(27,0) ,
 `replaced` decimal(27,0) ,
 `rejected` decimal(27,0) ,
 `sample_room` decimal(27,0) ,
 `good_garments` decimal(27,0) ,
 `recut_raised` decimal(27,0) ,
 `disposed` decimal(27,0) ,
 `sent_to_customer` decimal(27,0) ,
 `actual_recut` decimal(27,0) ,
 `remarks` text ,
 `ref1` varchar(500) ,
 `tran_sent` decimal(27,0) ,
 `tran_rec` decimal(27,0) ,
 `resrv_dest` decimal(27,0) ,
 `panel_destroyed` decimal(27,0) 
)*/;

/*Table structure for table `bai_qms_pop_report` */

DROP TABLE IF EXISTS `bai_qms_pop_report`;

/*!50001 DROP VIEW IF EXISTS `bai_qms_pop_report` */;
/*!50001 DROP TABLE IF EXISTS `bai_qms_pop_report` */;

/*!50001 CREATE TABLE  `bai_qms_pop_report`(
 `qms_tid` int(11) ,
 `qms_style` varchar(30) ,
 `qms_schedule` varchar(20) ,
 `qms_color` varchar(150) ,
 `log_user` varchar(15) ,
 `log_date` date ,
 `log_time` timestamp ,
 `issued_by` varchar(30) ,
 `qms_size` varchar(5) ,
 `good_panels` decimal(27,0) ,
 `replaced` decimal(27,0) ,
 `rejected` decimal(27,0) ,
 `sample_room` decimal(27,0) ,
 `good_garments` decimal(27,0) ,
 `recut_raised` decimal(27,0) ,
 `disposed` decimal(27,0) ,
 `sent_to_customer` decimal(27,0) ,
 `actual_recut` decimal(27,0) ,
 `remarks` text ,
 `ref1` varchar(500) ,
 `module` text ,
 `team` text ,
 `tran_sent` decimal(27,0) ,
 `tran_rec` decimal(27,0) ,
 `resrv_dest` decimal(27,0) ,
 `panel_destroyed` decimal(27,0) 
)*/;

/*Table structure for table `bai_ship_cts_ref` */

DROP TABLE IF EXISTS `bai_ship_cts_ref`;

/*!50001 DROP VIEW IF EXISTS `bai_ship_cts_ref` */;
/*!50001 DROP TABLE IF EXISTS `bai_ship_cts_ref` */;

/*!50001 CREATE TABLE  `bai_ship_cts_ref`(
 `shipped` decimal(65,0) ,
 `ship_style` varchar(100) ,
 `ship_schedule` varchar(100) ,
 `disp_note_ref` varchar(341) 
)*/;

/*Table structure for table `cut_dept_report` */

DROP TABLE IF EXISTS `cut_dept_report`;

/*!50001 DROP VIEW IF EXISTS `cut_dept_report` */;
/*!50001 DROP TABLE IF EXISTS `cut_dept_report` */;

/*!50001 CREATE TABLE  `cut_dept_report`(
 `date` date ,
 `category` varchar(50) ,
 `catyy` double ,
 `doc_no` int(11) ,
 `section` int(11) ,
 `remarks` varchar(200) ,
 `net_uti` double ,
 `log_time` time ,
 `fab_received` float ,
 `damages` float ,
 `shortages` float ,
 `tot_cut_qty` bigint(40) 
)*/;

/*Table structure for table `disp_mix` */

DROP TABLE IF EXISTS `disp_mix`;

/*!50001 DROP VIEW IF EXISTS `disp_mix` */;
/*!50001 DROP TABLE IF EXISTS `disp_mix` */;

/*!50001 CREATE TABLE  `disp_mix`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_col_des` text ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) ,
 `audit_pending` decimal(33,0) ,
 `fca_app` decimal(32,0) ,
 `fca_fail` decimal(32,0) ,
 `fca_audit_pending` decimal(33,0) 
)*/;

/*Table structure for table `disp_mix_2` */

DROP TABLE IF EXISTS `disp_mix_2`;

/*!50001 DROP VIEW IF EXISTS `disp_mix_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_mix_2` */;

/*!50001 CREATE TABLE  `disp_mix_2`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_col_des` text ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) ,
 `audit_pending` decimal(33,0) ,
 `fca_app` decimal(32,0) ,
 `fca_fail` decimal(32,0) ,
 `fca_audit_pending` decimal(33,0) 
)*/;

/*Table structure for table `disp_mix_size` */

DROP TABLE IF EXISTS `disp_mix_size`;

/*!50001 DROP VIEW IF EXISTS `disp_mix_size` */;
/*!50001 DROP TABLE IF EXISTS `disp_mix_size` */;

/*!50001 CREATE TABLE  `disp_mix_size`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_col_des` text ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `size_code` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) ,
 `audit_pending` decimal(33,0) ,
 `fca_app` decimal(32,0) ,
 `fca_fail` decimal(32,0) ,
 `fca_audit_pending` decimal(33,0) 
)*/;

/*Table structure for table `disp_mix_size_2` */

DROP TABLE IF EXISTS `disp_mix_size_2`;

/*!50001 DROP VIEW IF EXISTS `disp_mix_size_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_mix_size_2` */;

/*!50001 CREATE TABLE  `disp_mix_size_2`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_col_des` text ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `size_code` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) ,
 `audit_pending` decimal(33,0) ,
 `fca_app` decimal(32,0) ,
 `fca_fail` decimal(32,0) ,
 `fca_audit_pending` decimal(33,0) 
)*/;

/*Table structure for table `disp_tb1` */

DROP TABLE IF EXISTS `disp_tb1`;

/*!50001 DROP VIEW IF EXISTS `disp_tb1` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb1` */;

/*!50001 CREATE TABLE  `disp_tb1`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `lable_ids` varchar(341) ,
 `order_col_des` text ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) 
)*/;

/*Table structure for table `disp_tb1_2` */

DROP TABLE IF EXISTS `disp_tb1_2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb1_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb1_2` */;

/*!50001 CREATE TABLE  `disp_tb1_2`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `lable_ids` varchar(341) ,
 `order_col_des` text ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) 
)*/;

/*Table structure for table `disp_tb1_size` */

DROP TABLE IF EXISTS `disp_tb1_size`;

/*!50001 DROP VIEW IF EXISTS `disp_tb1_size` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb1_size` */;

/*!50001 CREATE TABLE  `disp_tb1_size`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `size_code` varchar(10) ,
 `order_col_des` text ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) 
)*/;

/*Table structure for table `disp_tb1_size_2` */

DROP TABLE IF EXISTS `disp_tb1_size_2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb1_size_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb1_size_2` */;

/*!50001 CREATE TABLE  `disp_tb1_size_2`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `size_code` varchar(10) ,
 `order_col_des` text ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) 
)*/;

/*Table structure for table `disp_tb2` */

DROP TABLE IF EXISTS `disp_tb2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb2` */;

/*!50001 CREATE TABLE  `disp_tb2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `disp_tb2_2` */

DROP TABLE IF EXISTS `disp_tb2_2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb2_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb2_2` */;

/*!50001 CREATE TABLE  `disp_tb2_2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `color` varchar(60) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `disp_tb2_size` */

DROP TABLE IF EXISTS `disp_tb2_size`;

/*!50001 DROP VIEW IF EXISTS `disp_tb2_size` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb2_size` */;

/*!50001 CREATE TABLE  `disp_tb2_size`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `size` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `disp_tb2_size_2` */

DROP TABLE IF EXISTS `disp_tb2_size_2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb2_size_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb2_size_2` */;

/*!50001 CREATE TABLE  `disp_tb2_size_2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `size` varchar(10) ,
 `color` varchar(60) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `emb_garment_carton_pendings` */

DROP TABLE IF EXISTS `emb_garment_carton_pendings`;

/*!50001 DROP VIEW IF EXISTS `emb_garment_carton_pendings` */;
/*!50001 DROP TABLE IF EXISTS `emb_garment_carton_pendings` */;

/*!50001 CREATE TABLE  `emb_garment_carton_pendings`(
 `tid` int(11) ,
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `size_code` varchar(10) ,
 `carton_no` smallint(5) unsigned ,
 `carton_mode` char(1) ,
 `carton_act_qty` decimal(29,0) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `input_date` date ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_mod_no` varchar(8) ,
 `ims_log_date` timestamp 
)*/;

/*Table structure for table `fg_wh_report` */

DROP TABLE IF EXISTS `fg_wh_report`;

/*!50001 DROP VIEW IF EXISTS `fg_wh_report` */;
/*!50001 DROP TABLE IF EXISTS `fg_wh_report` */;

/*!50001 CREATE TABLE  `fg_wh_report`(
 `order_del_no` varchar(60) ,
 `total_qty` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `embellish` decimal(29,0) ,
 `shipped` int(1) 
)*/;

/*Table structure for table `fg_wh_report_summary` */

DROP TABLE IF EXISTS `fg_wh_report_summary`;

/*!50001 DROP VIEW IF EXISTS `fg_wh_report_summary` */;
/*!50001 DROP TABLE IF EXISTS `fg_wh_report_summary` */;

/*!50001 CREATE TABLE  `fg_wh_report_summary`(
 `order_del_no` varchar(60) ,
 `total_qty` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `embellish` decimal(29,0) ,
 `shipped` int(1) ,
 `order_date` date ,
 `order_po_no` varchar(100) ,
 `color` text ,
 `order_style_no` varchar(60) 
)*/;

/*Table structure for table `fsp_order_ref` */

DROP TABLE IF EXISTS `fsp_order_ref`;

/*!50001 DROP VIEW IF EXISTS `fsp_order_ref` */;
/*!50001 DROP TABLE IF EXISTS `fsp_order_ref` */;

/*!50001 CREATE TABLE  `fsp_order_ref`(
 `order_del_no` varchar(60) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `color` text ,
 `order_qty` decimal(65,0) ,
 `trim_cards` varchar(100) ,
 `order_div` varchar(60) ,
 `trim_status` int(11) ,
 `fsp_time_line` varchar(500) 
)*/;

/*Table structure for table `ft_st_pk_shipfast_status` */

DROP TABLE IF EXISTS `ft_st_pk_shipfast_status`;

/*!50001 DROP VIEW IF EXISTS `ft_st_pk_shipfast_status` */;
/*!50001 DROP TABLE IF EXISTS `ft_st_pk_shipfast_status` */;

/*!50001 CREATE TABLE  `ft_st_pk_shipfast_status`(
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
 `production_start` date ,
 `order_tid` varchar(200) ,
 `order_date` date ,
 `order_upload_date` date ,
 `order_last_mod_date` date ,
 `order_last_upload_date` date ,
 `order_div` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `order_col_code` varchar(100) ,
 `order_s_xs` int(50) ,
 `order_s_s` int(50) ,
 `order_s_m` int(50) ,
 `order_s_l` int(50) ,
 `order_s_xl` int(50) ,
 `order_s_xxl` int(50) ,
 `order_s_xxxl` int(50) ,
 `order_cat_stat` varchar(20) ,
 `order_cut_stat` varchar(20) ,
 `order_ratio_stat` varchar(20) ,
 `order_cad_stat` varchar(20) ,
 `order_stat` varchar(20) ,
 `Order_remarks` varchar(250) ,
 `order_po_no` varchar(100) ,
 `order_no` varchar(100) ,
 `old_order_s_xs` int(11) ,
 `old_order_s_s` int(11) ,
 `old_order_s_m` int(11) ,
 `old_order_s_l` int(11) ,
 `old_order_s_xl` int(11) ,
 `old_order_s_xxl` int(11) ,
 `old_order_s_xxxl` int(11) ,
 `color_code` int(11) ,
 `order_joins` varchar(500) ,
 `order_s_s01` int(11) ,
 `order_s_s02` int(11) ,
 `order_s_s03` int(11) ,
 `order_s_s04` int(11) ,
 `order_s_s05` int(11) ,
 `order_s_s06` int(11) ,
 `order_s_s07` int(11) ,
 `order_s_s08` int(11) ,
 `order_s_s09` int(11) ,
 `order_s_s10` int(11) ,
 `order_s_s11` int(11) ,
 `order_s_s12` int(11) ,
 `order_s_s13` int(11) ,
 `order_s_s14` int(11) ,
 `order_s_s15` int(11) ,
 `order_s_s16` int(11) ,
 `order_s_s17` int(11) ,
 `order_s_s18` int(11) ,
 `order_s_s19` int(11) ,
 `order_s_s20` int(11) ,
 `order_s_s21` int(11) ,
 `order_s_s22` int(11) ,
 `order_s_s23` int(11) ,
 `order_s_s24` int(11) ,
 `order_s_s25` int(11) ,
 `order_s_s26` int(11) ,
 `order_s_s27` int(11) ,
 `order_s_s28` int(11) ,
 `order_s_s29` int(11) ,
 `order_s_s30` int(11) ,
 `order_s_s31` int(11) ,
 `order_s_s32` int(11) ,
 `order_s_s33` int(11) ,
 `order_s_s34` int(11) ,
 `order_s_s35` int(11) ,
 `order_s_s36` int(11) ,
 `order_s_s37` int(11) ,
 `order_s_s38` int(11) ,
 `order_s_s39` int(11) ,
 `order_s_s40` int(11) ,
 `order_s_s41` int(11) ,
 `order_s_s42` int(11) ,
 `order_s_s43` int(11) ,
 `order_s_s44` int(11) ,
 `order_s_s45` int(11) ,
 `order_s_s46` int(11) ,
 `order_s_s47` int(11) ,
 `order_s_s48` int(11) ,
 `order_s_s49` int(11) ,
 `order_s_s50` int(11) ,
 `old_order_s_s01` int(11) ,
 `old_order_s_s02` int(11) ,
 `old_order_s_s03` int(11) ,
 `old_order_s_s04` int(11) ,
 `old_order_s_s05` int(11) ,
 `old_order_s_s06` int(11) ,
 `old_order_s_s07` int(11) ,
 `old_order_s_s08` int(11) ,
 `old_order_s_s09` int(11) ,
 `old_order_s_s10` int(11) ,
 `old_order_s_s11` int(11) ,
 `old_order_s_s12` int(11) ,
 `old_order_s_s13` int(11) ,
 `old_order_s_s14` int(11) ,
 `old_order_s_s15` int(11) ,
 `old_order_s_s16` int(11) ,
 `old_order_s_s17` int(11) ,
 `old_order_s_s18` int(11) ,
 `old_order_s_s19` int(11) ,
 `old_order_s_s20` int(11) ,
 `old_order_s_s21` int(11) ,
 `old_order_s_s22` int(11) ,
 `old_order_s_s23` int(11) ,
 `old_order_s_s24` int(11) ,
 `old_order_s_s25` int(11) ,
 `old_order_s_s26` int(11) ,
 `old_order_s_s27` int(11) ,
 `old_order_s_s28` int(11) ,
 `old_order_s_s29` int(11) ,
 `old_order_s_s30` int(11) ,
 `old_order_s_s31` int(11) ,
 `old_order_s_s32` int(11) ,
 `old_order_s_s33` int(11) ,
 `old_order_s_s34` int(11) ,
 `old_order_s_s35` int(11) ,
 `old_order_s_s36` int(11) ,
 `old_order_s_s37` int(11) ,
 `old_order_s_s38` int(11) ,
 `old_order_s_s39` int(11) ,
 `old_order_s_s40` int(11) ,
 `old_order_s_s41` int(11) ,
 `old_order_s_s42` int(11) ,
 `old_order_s_s43` int(11) ,
 `old_order_s_s44` int(11) ,
 `old_order_s_s45` int(11) ,
 `old_order_s_s46` int(11) ,
 `old_order_s_s47` int(11) ,
 `old_order_s_s48` int(11) ,
 `old_order_s_s49` int(11) ,
 `old_order_s_s50` int(11) ,
 `packing_method` varchar(12) ,
 `style_id` varchar(20) ,
 `carton_id` int(11) ,
 `carton_print_status` int(11) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) 
)*/;

/*Table structure for table `ims_combine` */

DROP TABLE IF EXISTS `ims_combine`;

/*!50001 DROP VIEW IF EXISTS `ims_combine` */;
/*!50001 DROP TABLE IF EXISTS `ims_combine` */;

/*!50001 CREATE TABLE  `ims_combine`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` int(11) ,
 `ims_pro_qty` int(11) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` varchar(40) ,
 `rand_track` bigint(20) ,
 `input_job_no_ref` int(11) 
)*/;

/*Table structure for table `ims_log_backup_t1` */

DROP TABLE IF EXISTS `ims_log_backup_t1`;

/*!50001 DROP VIEW IF EXISTS `ims_log_backup_t1` */;
/*!50001 DROP TABLE IF EXISTS `ims_log_backup_t1` */;

/*!50001 CREATE TABLE  `ims_log_backup_t1`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` decimal(32,0) ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` varchar(40) ,
 `rand_track` bigint(20) 
)*/;

/*Table structure for table `ims_log_backup_t2` */

DROP TABLE IF EXISTS `ims_log_backup_t2`;

/*!50001 DROP VIEW IF EXISTS `ims_log_backup_t2` */;
/*!50001 DROP TABLE IF EXISTS `ims_log_backup_t2` */;

/*!50001 CREATE TABLE  `ims_log_backup_t2`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` decimal(32,0) ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` int(11) ,
 `rand_track` bigint(20) 
)*/;

/*Table structure for table `ims_log_long_pending_transfers` */

DROP TABLE IF EXISTS `ims_log_long_pending_transfers`;

/*!50001 DROP VIEW IF EXISTS `ims_log_long_pending_transfers` */;
/*!50001 DROP TABLE IF EXISTS `ims_log_long_pending_transfers` */;

/*!50001 CREATE TABLE  `ims_log_long_pending_transfers`(
 `ims_date` date ,
 `tid` varchar(40) ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` int(11) ,
 `ims_pro_qty` int(11) ,
 `ims_log_date` timestamp ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) 
)*/;

/*Table structure for table `incentive_emb_reference` */

DROP TABLE IF EXISTS `incentive_emb_reference`;

/*!50001 DROP VIEW IF EXISTS `incentive_emb_reference` */;
/*!50001 DROP TABLE IF EXISTS `incentive_emb_reference` */;

/*!50001 CREATE TABLE  `incentive_emb_reference`(
 `order_del_no` varchar(60) ,
 `emb_stat` int(1) 
)*/;

/*Table structure for table `incentive_fca_audit_fail_sch` */

DROP TABLE IF EXISTS `incentive_fca_audit_fail_sch`;

/*!50001 DROP VIEW IF EXISTS `incentive_fca_audit_fail_sch` */;
/*!50001 DROP TABLE IF EXISTS `incentive_fca_audit_fail_sch` */;

/*!50001 CREATE TABLE  `incentive_fca_audit_fail_sch`(
 `schedule` int(11) ,
 `remarks` text 
)*/;

/*Table structure for table `live_pro_table_ref` */

DROP TABLE IF EXISTS `live_pro_table_ref`;

/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref` */;
/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref` */;

/*!50001 CREATE TABLE  `live_pro_table_ref`(
 `color_code` int(11) ,
 `acutno` int(11) ,
 `doc_no` int(11) ,
 `a_plies` int(11) 
)*/;

/*Table structure for table `live_pro_table_ref2` */

DROP TABLE IF EXISTS `live_pro_table_ref2`;

/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref2` */;
/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref2` */;

/*!50001 CREATE TABLE  `live_pro_table_ref2`(
 `color_code` int(11) ,
 `acutno` int(11) ,
 `doc_no` int(11) ,
 `a_plies` int(11) 
)*/;

/*Table structure for table `live_pro_table_ref3` */

DROP TABLE IF EXISTS `live_pro_table_ref3`;

/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref3` */;
/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref3` */;

/*!50001 CREATE TABLE  `live_pro_table_ref3`(
 `color_code` int(11) ,
 `acutno` int(11) ,
 `doc_no` int(11) ,
 `a_plies` int(11) 
)*/;

/*Table structure for table `marker_ref_matrix_view` */

DROP TABLE IF EXISTS `marker_ref_matrix_view`;

/*!50001 DROP VIEW IF EXISTS `marker_ref_matrix_view` */;
/*!50001 DROP TABLE IF EXISTS `marker_ref_matrix_view` */;

/*!50001 CREATE TABLE  `marker_ref_matrix_view`(
 `category` varchar(50) ,
 `strip_match` varchar(10) ,
 `gmtway` varchar(100) ,
 `marker_ref_tid` varchar(20) ,
 `marker_width` varchar(5) ,
 `marker_length` varchar(10) ,
 `marker_ref` int(11) ,
 `cat_ref` int(11) ,
 `allocate_ref` int(11) ,
 `style_code` varchar(10) ,
 `buyer_code` varchar(3) ,
 `pat_ver` varchar(15) ,
 `xs` int(11) ,
 `s` int(11) ,
 `m` int(11) ,
 `l` int(11) ,
 `xl` int(11) ,
 `xxl` int(11) ,
 `xxxl` int(11) ,
 `s01` int(11) ,
 `s02` int(11) ,
 `s03` int(11) ,
 `s04` int(11) ,
 `s05` int(11) ,
 `s06` int(11) ,
 `s07` int(11) ,
 `s08` int(11) ,
 `s09` int(11) ,
 `s10` int(11) ,
 `s11` int(11) ,
 `s12` int(11) ,
 `s13` int(11) ,
 `s14` int(11) ,
 `s15` int(11) ,
 `s16` int(11) ,
 `s17` int(11) ,
 `s18` int(11) ,
 `s19` int(11) ,
 `s20` int(11) ,
 `s21` int(11) ,
 `s22` int(11) ,
 `s23` int(11) ,
 `s24` int(11) ,
 `s25` int(11) ,
 `s26` int(11) ,
 `s27` int(11) ,
 `s28` int(11) ,
 `s29` int(11) ,
 `s30` int(11) ,
 `s31` int(11) ,
 `s32` int(11) ,
 `s33` int(11) ,
 `s34` int(11) ,
 `s35` int(11) ,
 `s36` int(11) ,
 `s37` int(11) ,
 `s38` int(11) ,
 `s39` int(11) ,
 `s40` int(11) ,
 `s41` int(11) ,
 `s42` int(11) ,
 `s43` int(11) ,
 `s44` int(11) ,
 `s45` int(11) ,
 `s46` int(11) ,
 `s47` int(11) ,
 `s48` int(11) ,
 `s49` int(11) ,
 `s50` int(11) ,
 `lastup` timestamp ,
 `title_size_s01` varchar(20) ,
 `title_size_s02` varchar(20) ,
 `title_size_s03` varchar(20) ,
 `title_size_s04` varchar(20) ,
 `title_size_s05` varchar(20) ,
 `title_size_s06` varchar(20) ,
 `title_size_s07` varchar(20) ,
 `title_size_s08` varchar(20) ,
 `title_size_s09` varchar(20) ,
 `title_size_s10` varchar(20) ,
 `title_size_s11` varchar(20) ,
 `title_size_s12` varchar(20) ,
 `title_size_s13` varchar(20) ,
 `title_size_s14` varchar(20) ,
 `title_size_s15` varchar(20) ,
 `title_size_s16` varchar(20) ,
 `title_size_s17` varchar(20) ,
 `title_size_s18` varchar(20) ,
 `title_size_s19` varchar(20) ,
 `title_size_s20` varchar(20) ,
 `title_size_s21` varchar(20) ,
 `title_size_s22` varchar(20) ,
 `title_size_s23` varchar(20) ,
 `title_size_s24` varchar(20) ,
 `title_size_s25` varchar(20) ,
 `title_size_s26` varchar(20) ,
 `title_size_s27` varchar(20) ,
 `title_size_s28` varchar(20) ,
 `title_size_s29` varchar(20) ,
 `title_size_s30` varchar(20) ,
 `title_size_s31` varchar(20) ,
 `title_size_s32` varchar(20) ,
 `title_size_s33` varchar(20) ,
 `title_size_s34` varchar(20) ,
 `title_size_s35` varchar(20) ,
 `title_size_s36` varchar(20) ,
 `title_size_s37` varchar(20) ,
 `title_size_s38` varchar(20) ,
 `title_size_s39` varchar(20) ,
 `title_size_s40` varchar(20) ,
 `title_size_s41` varchar(20) ,
 `title_size_s42` varchar(20) ,
 `title_size_s43` varchar(20) ,
 `title_size_s44` varchar(20) ,
 `title_size_s45` varchar(20) ,
 `title_size_s46` varchar(20) ,
 `title_size_s47` varchar(20) ,
 `title_size_s48` varchar(20) ,
 `title_size_s49` varchar(20) ,
 `title_size_s50` varchar(20) ,
 `title_flag` int(11) ,
 `remarks` varchar(500) 
)*/;

/*Table structure for table `order_cat_doc_mix` */

DROP TABLE IF EXISTS `order_cat_doc_mix`;

/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mix` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mix` */;

/*!50001 CREATE TABLE  `order_cat_doc_mix`(
 `catyy` double ,
 `style_id` varchar(20) ,
 `order_style_no` varchar(60) ,
 `cat_patt_ver` varchar(10) ,
 `strip_match` varchar(10) ,
 `col_des` varchar(200) ,
 `date` date ,
 `cat_ref` int(11) ,
 `cuttable_ref` int(11) ,
 `allocate_ref` int(11) ,
 `mk_ref` int(11) ,
 `order_tid` varchar(200) ,
 `pcutno` int(11) ,
 `ratio` int(11) ,
 `p_xs` int(11) ,
 `p_s` int(11) ,
 `p_m` int(11) ,
 `p_l` int(11) ,
 `p_xl` int(11) ,
 `p_xxl` int(11) ,
 `p_xxxl` int(11) ,
 `p_plies` int(11) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `a_xs` int(11) ,
 `a_s` int(11) ,
 `a_m` int(11) ,
 `a_l` int(11) ,
 `a_xl` int(11) ,
 `a_xxl` int(11) ,
 `a_xxxl` int(11) ,
 `a_plies` int(11) ,
 `lastup` datetime ,
 `remarks` varchar(500) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `pcutdocid` varchar(200) ,
 `print_status` date ,
 `a_s01` int(11) ,
 `a_s02` int(11) ,
 `a_s03` int(11) ,
 `a_s04` int(11) ,
 `a_s05` int(11) ,
 `a_s06` int(11) ,
 `a_s07` int(11) ,
 `a_s08` int(11) ,
 `a_s09` int(11) ,
 `a_s10` int(11) ,
 `a_s11` int(11) ,
 `a_s12` int(11) ,
 `a_s13` int(11) ,
 `a_s14` int(11) ,
 `a_s15` int(11) ,
 `a_s16` int(11) ,
 `a_s17` int(11) ,
 `a_s18` int(11) ,
 `a_s19` int(11) ,
 `a_s20` int(11) ,
 `a_s21` int(11) ,
 `a_s22` int(11) ,
 `a_s23` int(11) ,
 `a_s24` int(11) ,
 `a_s25` int(11) ,
 `a_s26` int(11) ,
 `a_s27` int(11) ,
 `a_s28` int(11) ,
 `a_s29` int(11) ,
 `a_s30` int(11) ,
 `a_s31` int(11) ,
 `a_s32` int(11) ,
 `a_s33` int(11) ,
 `a_s34` int(11) ,
 `a_s35` int(11) ,
 `a_s36` int(11) ,
 `a_s37` int(11) ,
 `a_s38` int(11) ,
 `a_s39` int(11) ,
 `a_s40` int(11) ,
 `a_s41` int(11) ,
 `a_s42` int(11) ,
 `a_s43` int(11) ,
 `a_s44` int(11) ,
 `a_s45` int(11) ,
 `a_s46` int(11) ,
 `a_s47` int(11) ,
 `a_s48` int(11) ,
 `a_s49` int(11) ,
 `a_s50` int(11) ,
 `p_s01` int(11) ,
 `p_s02` int(11) ,
 `p_s03` int(11) ,
 `p_s04` int(11) ,
 `p_s05` int(11) ,
 `p_s06` int(11) ,
 `p_s07` int(11) ,
 `p_s08` int(11) ,
 `p_s09` int(11) ,
 `p_s10` int(11) ,
 `p_s11` int(11) ,
 `p_s12` int(11) ,
 `p_s13` int(11) ,
 `p_s14` int(11) ,
 `p_s15` int(11) ,
 `p_s16` int(11) ,
 `p_s17` int(11) ,
 `p_s18` int(11) ,
 `p_s19` int(11) ,
 `p_s20` int(11) ,
 `p_s21` int(11) ,
 `p_s22` int(11) ,
 `p_s23` int(11) ,
 `p_s24` int(11) ,
 `p_s25` int(11) ,
 `p_s26` int(11) ,
 `p_s27` int(11) ,
 `p_s28` int(11) ,
 `p_s29` int(11) ,
 `p_s30` int(11) ,
 `p_s31` int(11) ,
 `p_s32` int(11) ,
 `p_s33` int(11) ,
 `p_s34` int(11) ,
 `p_s35` int(11) ,
 `p_s36` int(11) ,
 `p_s37` int(11) ,
 `p_s38` int(11) ,
 `p_s39` int(11) ,
 `p_s40` int(11) ,
 `p_s41` int(11) ,
 `p_s42` int(11) ,
 `p_s43` int(11) ,
 `p_s44` int(11) ,
 `p_s45` int(11) ,
 `p_s46` int(11) ,
 `p_s47` int(11) ,
 `p_s48` int(11) ,
 `p_s49` int(11) ,
 `p_s50` int(11) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `plan_module` varchar(8) ,
 `category` varchar(50) ,
 `fab_des` varchar(200) ,
 `gmtway` varchar(100) ,
 `compo_no` varchar(200) ,
 `purwidth` float ,
 `color_code` int(11) ,
 `clubbing` smallint(6) ,
 `fabric_status` smallint(6) ,
 `plan_lot_ref` text ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) 
)*/;

/*Table structure for table `order_cat_doc_mk_mix` */

DROP TABLE IF EXISTS `order_cat_doc_mk_mix`;

/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mk_mix` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mk_mix` */;

/*!50001 CREATE TABLE  `order_cat_doc_mk_mix`(
 `catyy` double ,
 `cat_patt_ver` varchar(10) ,
 `mk_file` varchar(500) ,
 `mk_ver` varchar(50) ,
 `mklength` float ,
 `style_id` varchar(20) ,
 `col_des` varchar(200) ,
 `gmtway` varchar(100) ,
 `strip_match` varchar(10) ,
 `fab_des` varchar(200) ,
 `clubbing` smallint(6) ,
 `date` date ,
 `cat_ref` int(11) ,
 `compo_no` varchar(200) ,
 `cuttable_ref` int(11) ,
 `allocate_ref` int(11) ,
 `mk_ref` int(11) ,
 `order_tid` varchar(200) ,
 `pcutno` int(11) ,
 `ratio` int(11) ,
 `p_xs` int(11) ,
 `p_s` int(11) ,
 `p_m` int(11) ,
 `p_l` int(11) ,
 `p_xl` int(11) ,
 `p_xxl` int(11) ,
 `p_xxxl` int(11) ,
 `p_plies` int(11) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `a_xs` int(11) ,
 `a_s` int(11) ,
 `a_m` int(11) ,
 `a_l` int(11) ,
 `a_xl` int(11) ,
 `a_xxl` int(11) ,
 `a_xxxl` int(11) ,
 `a_plies` int(11) ,
 `lastup` datetime ,
 `remarks` varchar(500) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `pcutdocid` varchar(200) ,
 `print_status` date ,
 `a_s01` int(11) ,
 `a_s02` int(11) ,
 `a_s03` int(11) ,
 `a_s04` int(11) ,
 `a_s05` int(11) ,
 `a_s06` int(11) ,
 `a_s07` int(11) ,
 `a_s08` int(11) ,
 `a_s09` int(11) ,
 `a_s10` int(11) ,
 `a_s11` int(11) ,
 `a_s12` int(11) ,
 `a_s13` int(11) ,
 `a_s14` int(11) ,
 `a_s15` int(11) ,
 `a_s16` int(11) ,
 `a_s17` int(11) ,
 `a_s18` int(11) ,
 `a_s19` int(11) ,
 `a_s20` int(11) ,
 `a_s21` int(11) ,
 `a_s22` int(11) ,
 `a_s23` int(11) ,
 `a_s24` int(11) ,
 `a_s25` int(11) ,
 `a_s26` int(11) ,
 `a_s27` int(11) ,
 `a_s28` int(11) ,
 `a_s29` int(11) ,
 `a_s30` int(11) ,
 `a_s31` int(11) ,
 `a_s32` int(11) ,
 `a_s33` int(11) ,
 `a_s34` int(11) ,
 `a_s35` int(11) ,
 `a_s36` int(11) ,
 `a_s37` int(11) ,
 `a_s38` int(11) ,
 `a_s39` int(11) ,
 `a_s40` int(11) ,
 `a_s41` int(11) ,
 `a_s42` int(11) ,
 `a_s43` int(11) ,
 `a_s44` int(11) ,
 `a_s45` int(11) ,
 `a_s46` int(11) ,
 `a_s47` int(11) ,
 `a_s48` int(11) ,
 `a_s49` int(11) ,
 `a_s50` int(11) ,
 `p_s01` int(11) ,
 `p_s02` int(11) ,
 `p_s03` int(11) ,
 `p_s04` int(11) ,
 `p_s05` int(11) ,
 `p_s06` int(11) ,
 `p_s07` int(11) ,
 `p_s08` int(11) ,
 `p_s09` int(11) ,
 `p_s10` int(11) ,
 `p_s11` int(11) ,
 `p_s12` int(11) ,
 `p_s13` int(11) ,
 `p_s14` int(11) ,
 `p_s15` int(11) ,
 `p_s16` int(11) ,
 `p_s17` int(11) ,
 `p_s18` int(11) ,
 `p_s19` int(11) ,
 `p_s20` int(11) ,
 `p_s21` int(11) ,
 `p_s22` int(11) ,
 `p_s23` int(11) ,
 `p_s24` int(11) ,
 `p_s25` int(11) ,
 `p_s26` int(11) ,
 `p_s27` int(11) ,
 `p_s28` int(11) ,
 `p_s29` int(11) ,
 `p_s30` int(11) ,
 `p_s31` int(11) ,
 `p_s32` int(11) ,
 `p_s33` int(11) ,
 `p_s34` int(11) ,
 `p_s35` int(11) ,
 `p_s36` int(11) ,
 `p_s37` int(11) ,
 `p_s38` int(11) ,
 `p_s39` int(11) ,
 `p_s40` int(11) ,
 `p_s41` int(11) ,
 `p_s42` int(11) ,
 `p_s43` int(11) ,
 `p_s44` int(11) ,
 `p_s45` int(11) ,
 `p_s46` int(11) ,
 `p_s47` int(11) ,
 `p_s48` int(11) ,
 `p_s49` int(11) ,
 `p_s50` int(11) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `plan_module` varchar(8) ,
 `category` varchar(50) ,
 `color_code` int(11) ,
 `fabric_status` smallint(6) ,
 `material_req` double(21,4) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `plan_lot_ref` text 
)*/;

/*Table structure for table `order_cat_recut_doc_mix` */

DROP TABLE IF EXISTS `order_cat_recut_doc_mix`;

/*!50001 DROP VIEW IF EXISTS `order_cat_recut_doc_mix` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_recut_doc_mix` */;

/*!50001 CREATE TABLE  `order_cat_recut_doc_mix`(
 `date` date ,
 `cat_ref` int(11) ,
 `cuttable_ref` int(11) ,
 `allocate_ref` int(11) ,
 `mk_ref` int(11) ,
 `order_tid` varchar(200) ,
 `pcutno` int(11) ,
 `ratio` int(11) ,
 `p_xs` int(11) ,
 `p_s` int(11) ,
 `p_m` int(11) ,
 `p_l` int(11) ,
 `p_xl` int(11) ,
 `p_xxl` int(11) ,
 `p_xxxl` int(11) ,
 `p_plies` int(11) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `a_xs` int(11) ,
 `a_s` int(11) ,
 `a_m` int(11) ,
 `a_l` int(11) ,
 `a_xl` int(11) ,
 `a_xxl` int(11) ,
 `a_xxxl` int(11) ,
 `a_plies` int(11) ,
 `lastup` datetime ,
 `remarks` varchar(500) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `pcutdocid` varchar(200) ,
 `print_status` date ,
 `a_s01` int(11) ,
 `a_s02` int(11) ,
 `a_s03` int(11) ,
 `a_s04` int(11) ,
 `a_s05` int(11) ,
 `a_s06` int(11) ,
 `a_s07` int(11) ,
 `a_s08` int(11) ,
 `a_s09` int(11) ,
 `a_s10` int(11) ,
 `a_s11` int(11) ,
 `a_s12` int(11) ,
 `a_s13` int(11) ,
 `a_s14` int(11) ,
 `a_s15` int(11) ,
 `a_s16` int(11) ,
 `a_s17` int(11) ,
 `a_s18` int(11) ,
 `a_s19` int(11) ,
 `a_s20` int(11) ,
 `a_s21` int(11) ,
 `a_s22` int(11) ,
 `a_s23` int(11) ,
 `a_s24` int(11) ,
 `a_s25` int(11) ,
 `a_s26` int(11) ,
 `a_s27` int(11) ,
 `a_s28` int(11) ,
 `a_s29` int(11) ,
 `a_s30` int(11) ,
 `a_s31` int(11) ,
 `a_s32` int(11) ,
 `a_s33` int(11) ,
 `a_s34` int(11) ,
 `a_s35` int(11) ,
 `a_s36` int(11) ,
 `a_s37` int(11) ,
 `a_s38` int(11) ,
 `a_s39` int(11) ,
 `a_s40` int(11) ,
 `a_s41` int(11) ,
 `a_s42` int(11) ,
 `a_s43` int(11) ,
 `a_s44` int(11) ,
 `a_s45` int(11) ,
 `a_s46` int(11) ,
 `a_s47` int(11) ,
 `a_s48` int(11) ,
 `a_s49` int(11) ,
 `a_s50` int(11) ,
 `p_s01` int(11) ,
 `p_s02` int(11) ,
 `p_s03` int(11) ,
 `p_s04` int(11) ,
 `p_s05` int(11) ,
 `p_s06` int(11) ,
 `p_s07` int(11) ,
 `p_s08` int(11) ,
 `p_s09` int(11) ,
 `p_s10` int(11) ,
 `p_s11` int(11) ,
 `p_s12` int(11) ,
 `p_s13` int(11) ,
 `p_s14` int(11) ,
 `p_s15` int(11) ,
 `p_s16` int(11) ,
 `p_s17` int(11) ,
 `p_s18` int(11) ,
 `p_s19` int(11) ,
 `p_s20` int(11) ,
 `p_s21` int(11) ,
 `p_s22` int(11) ,
 `p_s23` int(11) ,
 `p_s24` int(11) ,
 `p_s25` int(11) ,
 `p_s26` int(11) ,
 `p_s27` int(11) ,
 `p_s28` int(11) ,
 `p_s29` int(11) ,
 `p_s30` int(11) ,
 `p_s31` int(11) ,
 `p_s32` int(11) ,
 `p_s33` int(11) ,
 `p_s34` int(11) ,
 `p_s35` int(11) ,
 `p_s36` int(11) ,
 `p_s37` int(11) ,
 `p_s38` int(11) ,
 `p_s39` int(11) ,
 `p_s40` int(11) ,
 `p_s41` int(11) ,
 `p_s42` int(11) ,
 `p_s43` int(11) ,
 `p_s44` int(11) ,
 `p_s45` int(11) ,
 `p_s46` int(11) ,
 `p_s47` int(11) ,
 `p_s48` int(11) ,
 `p_s49` int(11) ,
 `p_s50` int(11) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `plan_module` varchar(5) ,
 `category` varchar(50) ,
 `color_code` int(11) ,
 `fabric_status` smallint(6) ,
 `order_del_no` varchar(60) ,
 `plan_lot_ref` text ,
 `order_col_des` varchar(150) ,
 `order_style_no` varchar(60) 
)*/;

/*Table structure for table `order_cat_recut_doc_mk_mix` */

DROP TABLE IF EXISTS `order_cat_recut_doc_mk_mix`;

/*!50001 DROP VIEW IF EXISTS `order_cat_recut_doc_mk_mix` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_recut_doc_mk_mix` */;

/*!50001 CREATE TABLE  `order_cat_recut_doc_mk_mix`(
 `date` date ,
 `cat_ref` int(11) ,
 `cuttable_ref` int(11) ,
 `allocate_ref` int(11) ,
 `mk_ref` int(11) ,
 `order_tid` varchar(200) ,
 `pcutno` int(11) ,
 `ratio` int(11) ,
 `p_xs` int(11) ,
 `p_s` int(11) ,
 `p_m` int(11) ,
 `p_l` int(11) ,
 `p_xl` int(11) ,
 `p_xxl` int(11) ,
 `p_xxxl` int(11) ,
 `p_plies` int(11) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `a_xs` int(11) ,
 `a_s` int(11) ,
 `a_m` int(11) ,
 `a_l` int(11) ,
 `a_xl` int(11) ,
 `a_xxl` int(11) ,
 `a_xxxl` int(11) ,
 `a_plies` int(11) ,
 `lastup` datetime ,
 `remarks` varchar(500) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `pcutdocid` varchar(200) ,
 `print_status` date ,
 `a_s01` int(11) ,
 `a_s02` int(11) ,
 `a_s03` int(11) ,
 `a_s04` int(11) ,
 `a_s05` int(11) ,
 `a_s06` int(11) ,
 `a_s07` int(11) ,
 `a_s08` int(11) ,
 `a_s09` int(11) ,
 `a_s10` int(11) ,
 `a_s11` int(11) ,
 `a_s12` int(11) ,
 `a_s13` int(11) ,
 `a_s14` int(11) ,
 `a_s15` int(11) ,
 `a_s16` int(11) ,
 `a_s17` int(11) ,
 `a_s18` int(11) ,
 `a_s19` int(11) ,
 `a_s20` int(11) ,
 `a_s21` int(11) ,
 `a_s22` int(11) ,
 `a_s23` int(11) ,
 `a_s24` int(11) ,
 `a_s25` int(11) ,
 `a_s26` int(11) ,
 `a_s27` int(11) ,
 `a_s28` int(11) ,
 `a_s29` int(11) ,
 `a_s30` int(11) ,
 `a_s31` int(11) ,
 `a_s32` int(11) ,
 `a_s33` int(11) ,
 `a_s34` int(11) ,
 `a_s35` int(11) ,
 `a_s36` int(11) ,
 `a_s37` int(11) ,
 `a_s38` int(11) ,
 `a_s39` int(11) ,
 `a_s40` int(11) ,
 `a_s41` int(11) ,
 `a_s42` int(11) ,
 `a_s43` int(11) ,
 `a_s44` int(11) ,
 `a_s45` int(11) ,
 `a_s46` int(11) ,
 `a_s47` int(11) ,
 `a_s48` int(11) ,
 `a_s49` int(11) ,
 `a_s50` int(11) ,
 `p_s01` int(11) ,
 `p_s02` int(11) ,
 `p_s03` int(11) ,
 `p_s04` int(11) ,
 `p_s05` int(11) ,
 `p_s06` int(11) ,
 `p_s07` int(11) ,
 `p_s08` int(11) ,
 `p_s09` int(11) ,
 `p_s10` int(11) ,
 `p_s11` int(11) ,
 `p_s12` int(11) ,
 `p_s13` int(11) ,
 `p_s14` int(11) ,
 `p_s15` int(11) ,
 `p_s16` int(11) ,
 `p_s17` int(11) ,
 `p_s18` int(11) ,
 `p_s19` int(11) ,
 `p_s20` int(11) ,
 `p_s21` int(11) ,
 `p_s22` int(11) ,
 `p_s23` int(11) ,
 `p_s24` int(11) ,
 `p_s25` int(11) ,
 `p_s26` int(11) ,
 `p_s27` int(11) ,
 `p_s28` int(11) ,
 `p_s29` int(11) ,
 `p_s30` int(11) ,
 `p_s31` int(11) ,
 `p_s32` int(11) ,
 `p_s33` int(11) ,
 `p_s34` int(11) ,
 `p_s35` int(11) ,
 `p_s36` int(11) ,
 `p_s37` int(11) ,
 `p_s38` int(11) ,
 `p_s39` int(11) ,
 `p_s40` int(11) ,
 `p_s41` int(11) ,
 `p_s42` int(11) ,
 `p_s43` int(11) ,
 `p_s44` int(11) ,
 `p_s45` int(11) ,
 `p_s46` int(11) ,
 `p_s47` int(11) ,
 `p_s48` int(11) ,
 `p_s49` int(11) ,
 `p_s50` int(11) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `plan_module` varchar(5) ,
 `category` varchar(50) ,
 `color_code` int(11) ,
 `fabric_status` smallint(6) ,
 `material_req` double(21,4) ,
 `order_del_no` varchar(60) ,
 `plan_lot_ref` text 
)*/;

/*Table structure for table `pac_stat_log_for_live` */

DROP TABLE IF EXISTS `pac_stat_log_for_live`;

/*!50001 DROP VIEW IF EXISTS `pac_stat_log_for_live` */;
/*!50001 DROP TABLE IF EXISTS `pac_stat_log_for_live` */;

/*!50001 CREATE TABLE  `pac_stat_log_for_live`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `tid` int(11) ,
 `size_code` varchar(10) ,
 `remarks` varchar(200) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `container` smallint(7) unsigned ,
 `disp_carton_no` tinyint(2) unsigned ,
 `disp_id` tinyint(2) unsigned ,
 `carton_act_qty` decimal(29,0) ,
 `audit_status` char(7) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) 
)*/;

/*Table structure for table `pac_stat_log_temp` */

DROP TABLE IF EXISTS `pac_stat_log_temp`;

/*!50001 DROP VIEW IF EXISTS `pac_stat_log_temp` */;
/*!50001 DROP TABLE IF EXISTS `pac_stat_log_temp` */;

/*!50001 CREATE TABLE  `pac_stat_log_temp`(
 `tid` int(11) ,
 `doc_no` bigint(20) ,
 `size_code` varchar(10) ,
 `carton_no` smallint(5) unsigned ,
 `carton_mode` char(1) ,
 `carton_act_qty` decimal(29,0) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `remarks` varchar(200) ,
 `disp_id` tinyint(2) unsigned ,
 `doc_no_ref` varchar(1000) ,
 `disp_carton_no` tinyint(2) unsigned 
)*/;

/*Table structure for table `pack_to_be_backup` */

DROP TABLE IF EXISTS `pack_to_be_backup`;

/*!50001 DROP VIEW IF EXISTS `pack_to_be_backup` */;
/*!50001 DROP TABLE IF EXISTS `pack_to_be_backup` */;

/*!50001 CREATE TABLE  `pack_to_be_backup`(
 `total` decimal(29,0) ,
 `order_del_no` varchar(60) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `lable_ids` varchar(341) ,
 `create_date` date ,
 `ship_qty` bigint(67) 
)*/;

/*Table structure for table `packing_dashboard` */

DROP TABLE IF EXISTS `packing_dashboard`;

/*!50001 DROP VIEW IF EXISTS `packing_dashboard` */;
/*!50001 DROP TABLE IF EXISTS `packing_dashboard` */;

/*!50001 CREATE TABLE  `packing_dashboard`(
 `tid` int(11) ,
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `size_code` varchar(10) ,
 `carton_no` smallint(5) unsigned ,
 `carton_mode` char(1) ,
 `carton_act_qty` decimal(29,0) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `input_date` date ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_mod_no` varchar(8) ,
 `ims_log_date` timestamp 
)*/;

/*Table structure for table `packing_dashboard_new` */

DROP TABLE IF EXISTS `packing_dashboard_new`;

/*!50001 DROP VIEW IF EXISTS `packing_dashboard_new` */;
/*!50001 DROP TABLE IF EXISTS `packing_dashboard_new` */;

/*!50001 CREATE TABLE  `packing_dashboard_new`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` int(11) ,
 `ims_pro_qty` int(11) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` varchar(40) ,
 `rand_track` bigint(20) ,
 `ims_pro_qty_cumm` decimal(32,0) 
)*/;

/*Table structure for table `packing_dashboard_new2` */

DROP TABLE IF EXISTS `packing_dashboard_new2`;

/*!50001 DROP VIEW IF EXISTS `packing_dashboard_new2` */;
/*!50001 DROP TABLE IF EXISTS `packing_dashboard_new2` */;

/*!50001 CREATE TABLE  `packing_dashboard_new2`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` decimal(32,0) ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` varchar(40) ,
 `rand_track` bigint(20) ,
 `ims_pro_qty_cumm` decimal(32,0) 
)*/;

/*Table structure for table `packing_dboard_stage1` */

DROP TABLE IF EXISTS `packing_dboard_stage1`;

/*!50001 DROP VIEW IF EXISTS `packing_dboard_stage1` */;
/*!50001 DROP TABLE IF EXISTS `packing_dboard_stage1` */;

/*!50001 CREATE TABLE  `packing_dboard_stage1`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `tid` int(11) ,
 `size_code` varchar(10) ,
 `remarks` varchar(200) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `container` smallint(7) unsigned ,
 `disp_carton_no` tinyint(2) unsigned ,
 `disp_id` tinyint(2) unsigned ,
 `carton_act_qty` smallint(7) unsigned ,
 `audit_status` char(7) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `new` decimal(7,0) 
)*/;

/*Table structure for table `packing_issues` */

DROP TABLE IF EXISTS `packing_issues`;

/*!50001 DROP VIEW IF EXISTS `packing_issues` */;
/*!50001 DROP TABLE IF EXISTS `packing_issues` */;

/*!50001 CREATE TABLE  `packing_issues`(
 `tid` int(11) ,
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `size_code` varchar(10) ,
 `carton_no` smallint(5) unsigned ,
 `carton_mode` char(1) ,
 `carton_act_qty` decimal(52,0) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `remarks` varchar(200) ,
 `disp_id` tinyint(2) unsigned ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `input_date` date ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_mod_no` varchar(8) ,
 `ims_log_date` timestamp 
)*/;

/*Table structure for table `packing_pending_schedules` */

DROP TABLE IF EXISTS `packing_pending_schedules`;

/*!50001 DROP VIEW IF EXISTS `packing_pending_schedules` */;
/*!50001 DROP TABLE IF EXISTS `packing_pending_schedules` */;

/*!50001 CREATE TABLE  `packing_pending_schedules`(
 `order_del_no` varchar(60) 
)*/;

/*Table structure for table `packing_summary` */

DROP TABLE IF EXISTS `packing_summary`;

/*!50001 DROP VIEW IF EXISTS `packing_summary` */;
/*!50001 DROP TABLE IF EXISTS `packing_summary` */;

/*!50001 CREATE TABLE  `packing_summary`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `tid` int(11) ,
 `size_code` varchar(10) ,
 `remarks` varchar(200) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `container` smallint(7) unsigned ,
 `disp_carton_no` tinyint(2) unsigned ,
 `disp_id` tinyint(2) unsigned ,
 `carton_act_qty` smallint(7) unsigned ,
 `audit_status` char(7) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `acutno` int(11) 
)*/;

/*Table structure for table `packing_summary_backup` */

DROP TABLE IF EXISTS `packing_summary_backup`;

/*!50001 DROP VIEW IF EXISTS `packing_summary_backup` */;
/*!50001 DROP TABLE IF EXISTS `packing_summary_backup` */;

/*!50001 CREATE TABLE  `packing_summary_backup`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(300) ,
 `tid` int(11) ,
 `size_code` varchar(20) ,
 `remarks` varchar(200) ,
 `status` varchar(20) ,
 `lastup` timestamp ,
 `container` int(11) ,
 `disp_carton_no` int(11) ,
 `disp_id` int(11) ,
 `carton_act_qty` int(50) ,
 `audit_status` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `acutno` int(11) 
)*/;

/*Table structure for table `packing_summary_input` */

DROP TABLE IF EXISTS `packing_summary_input`;

/*!50001 DROP VIEW IF EXISTS `packing_summary_input` */;
/*!50001 DROP TABLE IF EXISTS `packing_summary_input` */;

/*!50001 CREATE TABLE  `packing_summary_input`(
 `order_joins` varchar(500) ,
 `doc_no` double ,
 `input_job_no` varchar(255) ,
 `input_job_no_random` varchar(90) ,
 `doc_no_ref` varchar(900) ,
 `tid` double ,
 `size_code` varchar(30) ,
 `status` varchar(24) ,
 `carton_act_qty` int(11) ,
 `packing_mode` int(11) unsigned ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `acutno` int(11) ,
 `destination` varchar(11) ,
 `cat_ref` int(11) ,
 `m3_size_code` varchar(90) ,
 `old_size` varchar(10) 
)*/;

/*Table structure for table `packing_summary_temp` */

DROP TABLE IF EXISTS `packing_summary_temp`;

/*!50001 DROP VIEW IF EXISTS `packing_summary_temp` */;
/*!50001 DROP TABLE IF EXISTS `packing_summary_temp` */;

/*!50001 CREATE TABLE  `packing_summary_temp`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `tid` int(11) ,
 `size_code` varchar(10) ,
 `remarks` varchar(200) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `container` smallint(7) unsigned ,
 `disp_carton_no` tinyint(2) unsigned ,
 `disp_id` tinyint(2) unsigned ,
 `carton_act_qty` smallint(7) unsigned ,
 `audit_status` char(7) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) 
)*/;

/*Table structure for table `plan_dash_doc_summ` */

DROP TABLE IF EXISTS `plan_dash_doc_summ`;

/*!50001 DROP VIEW IF EXISTS `plan_dash_doc_summ` */;
/*!50001 DROP TABLE IF EXISTS `plan_dash_doc_summ` */;

/*!50001 CREATE TABLE  `plan_dash_doc_summ`(
 `print_status` date ,
 `plan_lot_ref` text ,
 `bundle_location` varchar(200) ,
 `fabric_status_new` smallint(6) ,
 `doc_no` int(11) ,
 `module` varchar(8) ,
 `priority` int(11) ,
 `act_cut_issue_status` varchar(50) ,
 `act_cut_status` varchar(50) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `order_tid` varchar(200) ,
 `fabric_status` int(11) ,
 `color_code` int(11) ,
 `clubbing` smallint(6) ,
 `order_style_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `acutno` int(11) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `xs` bigint(21) ,
 `s` bigint(21) ,
 `m` bigint(21) ,
 `l` bigint(21) ,
 `xl` bigint(21) ,
 `xxl` bigint(21) ,
 `xxxl` bigint(21) ,
 `s01` bigint(21) ,
 `s02` bigint(21) ,
 `s03` bigint(21) ,
 `s04` bigint(21) ,
 `s05` bigint(21) ,
 `s06` bigint(21) ,
 `s07` bigint(21) ,
 `s08` bigint(21) ,
 `s09` bigint(21) ,
 `s10` bigint(21) ,
 `s11` bigint(21) ,
 `s12` bigint(21) ,
 `s13` bigint(21) ,
 `s14` bigint(21) ,
 `s15` bigint(21) ,
 `s16` bigint(21) ,
 `s17` bigint(21) ,
 `s18` bigint(21) ,
 `s19` bigint(21) ,
 `s20` bigint(21) ,
 `s21` bigint(21) ,
 `s22` bigint(21) ,
 `s23` bigint(21) ,
 `s24` bigint(21) ,
 `s25` bigint(21) ,
 `s26` bigint(21) ,
 `s27` bigint(21) ,
 `s28` bigint(21) ,
 `s29` bigint(21) ,
 `s30` bigint(21) ,
 `s31` bigint(21) ,
 `s32` bigint(21) ,
 `s33` bigint(21) ,
 `s34` bigint(21) ,
 `s35` bigint(21) ,
 `s36` bigint(21) ,
 `s37` bigint(21) ,
 `s38` bigint(21) ,
 `s39` bigint(21) ,
 `s40` bigint(21) ,
 `s41` bigint(21) ,
 `s42` bigint(21) ,
 `s43` bigint(21) ,
 `s44` bigint(21) ,
 `s45` bigint(21) ,
 `s46` bigint(21) ,
 `s47` bigint(21) ,
 `s48` bigint(21) ,
 `s49` bigint(21) ,
 `s50` bigint(21) ,
 `a_plies` int(11) ,
 `mk_ref` int(11) ,
 `total` bigint(67) ,
 `act_movement_status` varchar(25) ,
 `order_del_no` varchar(60) ,
 `log_time` datetime ,
 `emb_stat` int(3) ,
 `cat_ref` int(11) 
)*/;

/*Table structure for table `plan_dash_doc_summ_input` */

DROP TABLE IF EXISTS `plan_dash_doc_summ_input`;

/*!50001 DROP VIEW IF EXISTS `plan_dash_doc_summ_input` */;
/*!50001 DROP TABLE IF EXISTS `plan_dash_doc_summ_input` */;

/*!50001 CREATE TABLE  `plan_dash_doc_summ_input`(
 `input_job_no_random_ref` varchar(30) ,
 `input_module` varchar(10) ,
 `input_priority` int(11) ,
 `input_trims_status` int(11) ,
 `input_panel_status` int(11) ,
 `log_time` timestamp ,
 `track_id` int(11) ,
 `input_job_no` varchar(255) ,
 `tid` double ,
 `input_job_no_random` varchar(90) ,
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `order_div` varchar(60) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(3) ,
 `carton_act_qty` decimal(32,0) 
)*/;

/*Table structure for table `plan_dash_summ` */

DROP TABLE IF EXISTS `plan_dash_summ`;

/*!50001 DROP VIEW IF EXISTS `plan_dash_summ` */;
/*!50001 DROP TABLE IF EXISTS `plan_dash_summ` */;

/*!50001 CREATE TABLE  `plan_dash_summ`(
 `doc_no` int(11) ,
 `module` varchar(8) ,
 `priority` int(11) ,
 `fabric_status` int(11) ,
 `act_cut_issue_status` varchar(50) ,
 `plan_lot_ref` text ,
 `bundle_location` varchar(200) ,
 `print_status` date ,
 `act_cut_status` varchar(50) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `xs` bigint(21) ,
 `s` bigint(21) ,
 `m` bigint(21) ,
 `l` bigint(21) ,
 `xl` bigint(21) ,
 `xxl` bigint(21) ,
 `xxxl` bigint(21) ,
 `s01` bigint(21) ,
 `s02` bigint(21) ,
 `s03` bigint(21) ,
 `s04` bigint(21) ,
 `s05` bigint(21) ,
 `s06` bigint(21) ,
 `s07` bigint(21) ,
 `s08` bigint(21) ,
 `s09` bigint(21) ,
 `s10` bigint(21) ,
 `s11` bigint(21) ,
 `s12` bigint(21) ,
 `s13` bigint(21) ,
 `s14` bigint(21) ,
 `s15` bigint(21) ,
 `s16` bigint(21) ,
 `s17` bigint(21) ,
 `s18` bigint(21) ,
 `s19` bigint(21) ,
 `s20` bigint(21) ,
 `s21` bigint(21) ,
 `s22` bigint(21) ,
 `s23` bigint(21) ,
 `s24` bigint(21) ,
 `s25` bigint(21) ,
 `s26` bigint(21) ,
 `s27` bigint(21) ,
 `s28` bigint(21) ,
 `s29` bigint(21) ,
 `s30` bigint(21) ,
 `s31` bigint(21) ,
 `s32` bigint(21) ,
 `s33` bigint(21) ,
 `s34` bigint(21) ,
 `s35` bigint(21) ,
 `s36` bigint(21) ,
 `s37` bigint(21) ,
 `s38` bigint(21) ,
 `s39` bigint(21) ,
 `s40` bigint(21) ,
 `s41` bigint(21) ,
 `s42` bigint(21) ,
 `s43` bigint(21) ,
 `s44` bigint(21) ,
 `s45` bigint(21) ,
 `s46` bigint(21) ,
 `s47` bigint(21) ,
 `s48` bigint(21) ,
 `s49` bigint(21) ,
 `s50` bigint(21) ,
 `a_plies` int(11) ,
 `mk_ref` int(11) ,
 `order_tid` varchar(200) ,
 `fabric_status_new` smallint(6) ,
 `log_time` datetime 
)*/;

/*Table structure for table `plan_doc_summ` */

DROP TABLE IF EXISTS `plan_doc_summ`;

/*!50001 DROP VIEW IF EXISTS `plan_doc_summ` */;
/*!50001 DROP TABLE IF EXISTS `plan_doc_summ` */;

/*!50001 CREATE TABLE  `plan_doc_summ`(
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `act_movement_status` varchar(25) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(3) 
)*/;

/*Table structure for table `plan_doc_summ_in_ref` */

DROP TABLE IF EXISTS `plan_doc_summ_in_ref`;

/*!50001 DROP VIEW IF EXISTS `plan_doc_summ_in_ref` */;
/*!50001 DROP TABLE IF EXISTS `plan_doc_summ_in_ref` */;

/*!50001 CREATE TABLE  `plan_doc_summ_in_ref`(
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `act_cut_issue_status` varchar(50) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `order_div` varchar(60) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(3) 
)*/;

/*Table structure for table `plan_doc_summ_input` */

DROP TABLE IF EXISTS `plan_doc_summ_input`;

/*!50001 DROP VIEW IF EXISTS `plan_doc_summ_input` */;
/*!50001 DROP TABLE IF EXISTS `plan_doc_summ_input` */;

/*!50001 CREATE TABLE  `plan_doc_summ_input`(
 `input_job_no` varchar(255) ,
 `tid` double ,
 `input_job_no_random` varchar(90) ,
 `size_code` varchar(30) ,
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `order_div` varchar(60) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(3) ,
 `carton_act_qty` decimal(32,0) 
)*/;

/*Table structure for table `plandoc_stat_log_cat_log_ref` */

DROP TABLE IF EXISTS `plandoc_stat_log_cat_log_ref`;

/*!50001 DROP VIEW IF EXISTS `plandoc_stat_log_cat_log_ref` */;
/*!50001 DROP TABLE IF EXISTS `plandoc_stat_log_cat_log_ref` */;

/*!50001 CREATE TABLE  `plandoc_stat_log_cat_log_ref`(
 `order_tid` varchar(200) ,
 `fabric_status_new` smallint(6) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `log_update` timestamp ,
 `color_code` int(11) ,
 `order_div` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `plan_module` varchar(8) ,
 `cat_ref` int(11) ,
 `doc_total` bigint(66) 
)*/;

/*Table structure for table `qms_vs_recut` */

DROP TABLE IF EXISTS `qms_vs_recut`;

/*!50001 DROP VIEW IF EXISTS `qms_vs_recut` */;
/*!50001 DROP TABLE IF EXISTS `qms_vs_recut` */;

/*!50001 CREATE TABLE  `qms_vs_recut`(
 `qms_tid` int(11) ,
 `log_date` date ,
 `qms_style` varchar(30) ,
 `qms_schedule` varchar(20) ,
 `qms_color` varchar(150) ,
 `raised` decimal(27,0) ,
 `actual` decimal(27,0) ,
 `ref1` varchar(500) ,
 `qms_size` varchar(5) ,
 `module` text ,
 `doc_no` text ,
 `act_cut_status` varchar(50) ,
 `plan_module` varchar(5) ,
 `fabric_status` smallint(6) 
)*/;

/*Table structure for table `recut_v2_summary` */

DROP TABLE IF EXISTS `recut_v2_summary`;

/*!50001 DROP VIEW IF EXISTS `recut_v2_summary` */;
/*!50001 DROP TABLE IF EXISTS `recut_v2_summary` */;

/*!50001 CREATE TABLE  `recut_v2_summary`(
 `date` date ,
 `cat_ref` int(11) ,
 `cuttable_ref` int(11) ,
 `allocate_ref` int(11) ,
 `mk_ref` int(11) ,
 `order_tid` varchar(200) ,
 `pcutno` int(11) ,
 `ratio` int(11) ,
 `p_xs` int(11) ,
 `p_s` int(11) ,
 `p_m` int(11) ,
 `p_l` int(11) ,
 `p_xl` int(11) ,
 `p_xxl` int(11) ,
 `p_xxxl` int(11) ,
 `p_plies` int(11) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `a_xs` int(11) ,
 `a_s` int(11) ,
 `a_m` int(11) ,
 `a_l` int(11) ,
 `a_xl` int(11) ,
 `a_xxl` int(11) ,
 `a_xxxl` int(11) ,
 `a_plies` int(11) ,
 `lastup` datetime ,
 `remarks` varchar(500) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `pcutdocid` varchar(200) ,
 `print_status` date ,
 `a_s01` int(11) ,
 `a_s02` int(11) ,
 `a_s03` int(11) ,
 `a_s04` int(11) ,
 `a_s05` int(11) ,
 `a_s06` int(11) ,
 `a_s07` int(11) ,
 `a_s08` int(11) ,
 `a_s09` int(11) ,
 `a_s10` int(11) ,
 `a_s11` int(11) ,
 `a_s12` int(11) ,
 `a_s13` int(11) ,
 `a_s14` int(11) ,
 `a_s15` int(11) ,
 `a_s16` int(11) ,
 `a_s17` int(11) ,
 `a_s18` int(11) ,
 `a_s19` int(11) ,
 `a_s20` int(11) ,
 `a_s21` int(11) ,
 `a_s22` int(11) ,
 `a_s23` int(11) ,
 `a_s24` int(11) ,
 `a_s25` int(11) ,
 `a_s26` int(11) ,
 `a_s27` int(11) ,
 `a_s28` int(11) ,
 `a_s29` int(11) ,
 `a_s30` int(11) ,
 `a_s31` int(11) ,
 `a_s32` int(11) ,
 `a_s33` int(11) ,
 `a_s34` int(11) ,
 `a_s35` int(11) ,
 `a_s36` int(11) ,
 `a_s37` int(11) ,
 `a_s38` int(11) ,
 `a_s39` int(11) ,
 `a_s40` int(11) ,
 `a_s41` int(11) ,
 `a_s42` int(11) ,
 `a_s43` int(11) ,
 `a_s44` int(11) ,
 `a_s45` int(11) ,
 `a_s46` int(11) ,
 `a_s47` int(11) ,
 `a_s48` int(11) ,
 `a_s49` int(11) ,
 `a_s50` int(11) ,
 `p_s01` int(11) ,
 `p_s02` int(11) ,
 `p_s03` int(11) ,
 `p_s04` int(11) ,
 `p_s05` int(11) ,
 `p_s06` int(11) ,
 `p_s07` int(11) ,
 `p_s08` int(11) ,
 `p_s09` int(11) ,
 `p_s10` int(11) ,
 `p_s11` int(11) ,
 `p_s12` int(11) ,
 `p_s13` int(11) ,
 `p_s14` int(11) ,
 `p_s15` int(11) ,
 `p_s16` int(11) ,
 `p_s17` int(11) ,
 `p_s18` int(11) ,
 `p_s19` int(11) ,
 `p_s20` int(11) ,
 `p_s21` int(11) ,
 `p_s22` int(11) ,
 `p_s23` int(11) ,
 `p_s24` int(11) ,
 `p_s25` int(11) ,
 `p_s26` int(11) ,
 `p_s27` int(11) ,
 `p_s28` int(11) ,
 `p_s29` int(11) ,
 `p_s30` int(11) ,
 `p_s31` int(11) ,
 `p_s32` int(11) ,
 `p_s33` int(11) ,
 `p_s34` int(11) ,
 `p_s35` int(11) ,
 `p_s36` int(11) ,
 `p_s37` int(11) ,
 `p_s38` int(11) ,
 `p_s39` int(11) ,
 `p_s40` int(11) ,
 `p_s41` int(11) ,
 `p_s42` int(11) ,
 `p_s43` int(11) ,
 `p_s44` int(11) ,
 `p_s45` int(11) ,
 `p_s46` int(11) ,
 `p_s47` int(11) ,
 `p_s48` int(11) ,
 `p_s49` int(11) ,
 `p_s50` int(11) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `plan_module` varchar(5) ,
 `fabric_status` smallint(6) ,
 `plan_lot_ref` text ,
 `actual_cut_qty` bigint(66) ,
 `actual_req_qty` bigint(67) 
)*/;

/*Table structure for table `test_plan_doc_summ` */

DROP TABLE IF EXISTS `test_plan_doc_summ`;

/*!50001 DROP VIEW IF EXISTS `test_plan_doc_summ` */;
/*!50001 DROP TABLE IF EXISTS `test_plan_doc_summ` */;

/*!50001 CREATE TABLE  `test_plan_doc_summ`(
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `act_movement_status` varchar(25) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(3) 
)*/;

/*Table structure for table `zero_module_trans` */

DROP TABLE IF EXISTS `zero_module_trans`;

/*!50001 DROP VIEW IF EXISTS `zero_module_trans` */;
/*!50001 DROP TABLE IF EXISTS `zero_module_trans` */;

/*!50001 CREATE TABLE  `zero_module_trans`(
 `ims_qty` decimal(32,0) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `size` varchar(10) 
)*/;

/*View structure for view audit_disp_tb2 */

/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2` */;
/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,sum(if((`fca_audit_fail_db`.`tran_type` = 1),`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if((`fca_audit_fail_db`.`tran_type` = 2),`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`) */;

/*View structure for view audit_disp_tb2_2 */

/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_2` */;
/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`color` AS `color`,sum(if((`fca_audit_fail_db`.`tran_type` = 1),`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if((`fca_audit_fail_db`.`tran_type` = 2),`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`color`) */;

/*View structure for view audit_disp_tb2_size */

/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_size` */;
/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_size` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_size` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`size` AS `size`,sum(if((`fca_audit_fail_db`.`tran_type` = 1),`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if((`fca_audit_fail_db`.`tran_type` = 2),`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`size`) */;

/*View structure for view audit_disp_tb2_size_2 */

/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_size_2` */;
/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_size_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_size_2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`color` AS `color`,`fca_audit_fail_db`.`size` AS `size`,sum(if((`fca_audit_fail_db`.`tran_type` = 1),`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if((`fca_audit_fail_db`.`tran_type` = 2),`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`color`,`fca_audit_fail_db`.`size`) */;

/*View structure for view bai_qms_cts_ref */

/*!50001 DROP TABLE IF EXISTS `bai_qms_cts_ref` */;
/*!50001 DROP VIEW IF EXISTS `bai_qms_cts_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_cts_ref` AS (select `bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,sum(if((`bai_qms_db`.`qms_tran_type` = 1),`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if((`bai_qms_db`.`qms_tran_type` = 2),`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if((`bai_qms_db`.`qms_tran_type` = 3),`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if((`bai_qms_db`.`qms_tran_type` = 4),`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if((`bai_qms_db`.`qms_tran_type` = 5),`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if((`bai_qms_db`.`qms_tran_type` = 6),`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if((`bai_qms_db`.`qms_tran_type` = 7),`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if((`bai_qms_db`.`qms_tran_type` = 8),`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if((`bai_qms_db`.`qms_tran_type` = 9),`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,sum(if((`bai_qms_db`.`qms_tran_type` = 10),`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if((`bai_qms_db`.`qms_tran_type` = 11),`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if((`bai_qms_db`.`qms_tran_type` = 12),`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if((`bai_qms_db`.`qms_tran_type` = 13),`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by `bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`) */;

/*View structure for view bai_qms_day_report */

/*!50001 DROP TABLE IF EXISTS `bai_qms_day_report` */;
/*!50001 DROP VIEW IF EXISTS `bai_qms_day_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_day_report` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,`bai_qms_db`.`log_user` AS `log_user`,`bai_qms_db`.`log_date` AS `log_date`,`bai_qms_db`.`log_time` AS `log_time`,`bai_qms_db`.`issued_by` AS `issued_by`,`bai_qms_db`.`qms_size` AS `qms_size`,sum(if((`bai_qms_db`.`qms_tran_type` = 1),`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if((`bai_qms_db`.`qms_tran_type` = 2),`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if((`bai_qms_db`.`qms_tran_type` = 3),`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if((`bai_qms_db`.`qms_tran_type` = 4),`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if((`bai_qms_db`.`qms_tran_type` = 5),`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if((`bai_qms_db`.`qms_tran_type` = 6),`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if((`bai_qms_db`.`qms_tran_type` = 7),`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if((`bai_qms_db`.`qms_tran_type` = 8),`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if((`bai_qms_db`.`qms_tran_type` = 9),`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,`bai_qms_db`.`remarks` AS `remarks`,`bai_qms_db`.`ref1` AS `ref1`,sum(if((`bai_qms_db`.`qms_tran_type` = 10),`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if((`bai_qms_db`.`qms_tran_type` = 11),`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if((`bai_qms_db`.`qms_tran_type` = 12),`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if((`bai_qms_db`.`qms_tran_type` = 13),`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by concat(`bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`qms_size`)) */;

/*View structure for view bai_qms_pop_report */

/*!50001 DROP TABLE IF EXISTS `bai_qms_pop_report` */;
/*!50001 DROP VIEW IF EXISTS `bai_qms_pop_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_pop_report` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,`bai_qms_db`.`log_user` AS `log_user`,`bai_qms_db`.`log_date` AS `log_date`,`bai_qms_db`.`log_time` AS `log_time`,`bai_qms_db`.`issued_by` AS `issued_by`,`bai_qms_db`.`qms_size` AS `qms_size`,sum(if((`bai_qms_db`.`qms_tran_type` = 1),`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if((`bai_qms_db`.`qms_tran_type` = 2),`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if((`bai_qms_db`.`qms_tran_type` = 3),`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if((`bai_qms_db`.`qms_tran_type` = 4),`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if((`bai_qms_db`.`qms_tran_type` = 5),`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if((`bai_qms_db`.`qms_tran_type` = 6),`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if((`bai_qms_db`.`qms_tran_type` = 7),`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if((`bai_qms_db`.`qms_tran_type` = 8),`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if((`bai_qms_db`.`qms_tran_type` = 9),`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,`bai_qms_db`.`remarks` AS `remarks`,`bai_qms_db`.`ref1` AS `ref1`,substring_index(`bai_qms_db`.`remarks`,'-',1) AS `module`,substring_index(`bai_qms_db`.`remarks`,'-',-(1)) AS `team`,sum(if((`bai_qms_db`.`qms_tran_type` = 10),`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if((`bai_qms_db`.`qms_tran_type` = 11),`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if((`bai_qms_db`.`qms_tran_type` = 12),`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if((`bai_qms_db`.`qms_tran_type` = 13),`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by concat(`bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`qms_size`,`bai_qms_db`.`log_date`,substring_index(`bai_qms_db`.`remarks`,'-',1))) */;

/*View structure for view bai_ship_cts_ref */

/*!50001 DROP TABLE IF EXISTS `bai_ship_cts_ref` */;
/*!50001 DROP VIEW IF EXISTS `bai_ship_cts_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_ship_cts_ref` AS (select sum((((((((((((((((((((`ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08`) + `ship_stat_log`.`ship_s_s10`) + `ship_stat_log`.`ship_s_s12`) + `ship_stat_log`.`ship_s_s14`) + `ship_stat_log`.`ship_s_s16`) + `ship_stat_log`.`ship_s_s18`) + `ship_stat_log`.`ship_s_s20`) + `ship_stat_log`.`ship_s_s22`) + `ship_stat_log`.`ship_s_s24`) + `ship_stat_log`.`ship_s_s26`) + `ship_stat_log`.`ship_s_s28`) + `ship_stat_log`.`ship_s_s30`) + `ship_stat_log`.`ship_s_xs`) + `ship_stat_log`.`ship_s_s`) + `ship_stat_log`.`ship_s_m`) + `ship_stat_log`.`ship_s_l`) + `ship_stat_log`.`ship_s_xl`) + `ship_stat_log`.`ship_s_xxl`) + `ship_stat_log`.`ship_s_xxxl`)) AS `shipped`,`ship_stat_log`.`ship_style` AS `ship_style`,`ship_stat_log`.`ship_schedule` AS `ship_schedule`,group_concat(`ship_stat_log`.`disp_note_no` separator ',') AS `disp_note_ref` from `ship_stat_log` where (`ship_stat_log`.`ship_status` = 2) group by `ship_stat_log`.`ship_schedule`) */;

/*View structure for view cut_dept_report */

/*!50001 DROP TABLE IF EXISTS `cut_dept_report` */;
/*!50001 DROP VIEW IF EXISTS `cut_dept_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `cut_dept_report` AS (select `a`.`date` AS `date`,`o`.`category` AS `category`,`o`.`catyy` AS `catyy`,`a`.`doc_no` AS `doc_no`,`a`.`section` AS `section`,`a`.`remarks` AS `remarks`,(`a`.`fab_received` - (`a`.`damages` + `a`.`shortages`)) AS `net_uti`,cast(`a`.`log_date` as time) AS `log_time`,`a`.`fab_received` AS `fab_received`,`a`.`damages` AS `damages`,`a`.`shortages` AS `shortages`,((((((((((((((((((((`o`.`a_xs` + `o`.`a_s`) + `o`.`a_m`) + `o`.`a_l`) + `o`.`a_xl`) + `o`.`a_xxl`) + `o`.`a_xxxl`) + `o`.`a_s06`) + `o`.`a_s08`) + `o`.`a_s10`) + `o`.`a_s12`) + `o`.`a_s14`) + `o`.`a_s16`) + `o`.`a_s18`) + `o`.`a_s20`) + `o`.`a_s22`) + `o`.`a_s24`) + `o`.`a_s26`) + `o`.`a_s28`) + `o`.`a_s30`) * `o`.`a_plies`) AS `tot_cut_qty` from (`act_cut_status` `a` join `order_cat_doc_mk_mix` `o`) where (`a`.`doc_no` = `o`.`doc_no`) order by `a`.`section`,cast(`a`.`log_date` as time)) */;

/*View structure for view disp_mix */

/*!50001 DROP TABLE IF EXISTS `disp_mix` */;
/*!50001 DROP VIEW IF EXISTS `disp_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix` AS (select `disp_tb1`.`order_del_no` AS `order_del_no`,`disp_tb1`.`order_style_no` AS `order_style_no`,`disp_tb1`.`order_col_des` AS `order_col_des`,`disp_tb1`.`total` AS `total`,`disp_tb1`.`scanned` AS `scanned`,`disp_tb1`.`unscanned` AS `unscanned`,coalesce(`disp_tb2`.`app`,0) AS `app`,coalesce(`disp_tb2`.`fail`,0) AS `fail`,(coalesce(`disp_tb1`.`scanned`,0) - coalesce(`disp_tb2`.`app`,0)) AS `audit_pending`,coalesce(`audit_disp_tb2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2`.`fail`,0) AS `fca_fail`,(coalesce(`disp_tb1`.`scanned`,0) - coalesce(`audit_disp_tb2`.`app`,0)) AS `fca_audit_pending` from ((`disp_tb1` left join `disp_tb2` on((`disp_tb1`.`order_del_no` = `disp_tb2`.`SCHEDULE`))) left join `audit_disp_tb2` on((`disp_tb1`.`order_del_no` = `audit_disp_tb2`.`SCHEDULE`))) where (`disp_tb1`.`order_del_no` is not null)) */;

/*View structure for view disp_mix_2 */

/*!50001 DROP TABLE IF EXISTS `disp_mix_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_mix_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_2` AS (select `disp_tb1_2`.`order_del_no` AS `order_del_no`,`disp_tb1_2`.`order_style_no` AS `order_style_no`,`disp_tb1_2`.`order_col_des` AS `order_col_des`,`disp_tb1_2`.`total` AS `total`,`disp_tb1_2`.`scanned` AS `scanned`,`disp_tb1_2`.`unscanned` AS `unscanned`,coalesce(`disp_tb2_2`.`app`,0) AS `app`,coalesce(`disp_tb2_2`.`fail`,0) AS `fail`,(coalesce(`disp_tb1_2`.`scanned`,0) - coalesce(`disp_tb2_2`.`app`,0)) AS `audit_pending`,coalesce(`audit_disp_tb2_2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_2`.`fail`,0) AS `fca_fail`,(coalesce(`disp_tb1_2`.`scanned`,0) - coalesce(`audit_disp_tb2_2`.`app`,0)) AS `fca_audit_pending` from ((`disp_tb1_2` left join `disp_tb2_2` on((concat(`disp_tb1_2`.`order_del_no`,`disp_tb1_2`.`order_col_des`) = concat(`disp_tb2_2`.`SCHEDULE`,`disp_tb2_2`.`color`)))) left join `audit_disp_tb2_2` on((concat(`disp_tb1_2`.`order_del_no`,`disp_tb1_2`.`order_col_des`) = concat(`audit_disp_tb2_2`.`SCHEDULE`,`audit_disp_tb2_2`.`color`)))) where (`disp_tb1_2`.`order_del_no` is not null)) */;

/*View structure for view disp_mix_size */

/*!50001 DROP TABLE IF EXISTS `disp_mix_size` */;
/*!50001 DROP VIEW IF EXISTS `disp_mix_size` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_size` AS (select `disp_tb1_size`.`order_del_no` AS `order_del_no`,`disp_tb1_size`.`order_style_no` AS `order_style_no`,`disp_tb1_size`.`order_col_des` AS `order_col_des`,`disp_tb1_size`.`total` AS `total`,`disp_tb1_size`.`scanned` AS `scanned`,`disp_tb1_size`.`unscanned` AS `unscanned`,`disp_tb1_size`.`size_code` AS `size_code`,coalesce(`disp_tb2_size`.`app`,0) AS `app`,coalesce(`disp_tb2_size`.`fail`,0) AS `fail`,(coalesce(`disp_tb1_size`.`scanned`,0) - coalesce(`disp_tb2_size`.`app`,0)) AS `audit_pending`,coalesce(`audit_disp_tb2_size`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_size`.`fail`,0) AS `fca_fail`,(coalesce(`disp_tb1_size`.`scanned`,0) - coalesce(`audit_disp_tb2_size`.`app`,0)) AS `fca_audit_pending` from ((`disp_tb1_size` left join `disp_tb2_size` on(((`disp_tb1_size`.`order_del_no` = `disp_tb2_size`.`SCHEDULE`) and (`disp_tb1_size`.`size_code` = `disp_tb2_size`.`size`)))) left join `audit_disp_tb2_size` on(((`disp_tb1_size`.`order_del_no` = `audit_disp_tb2_size`.`SCHEDULE`) and (`disp_tb1_size`.`size_code` = `audit_disp_tb2_size`.`size`)))) where (`disp_tb1_size`.`order_del_no` is not null)) */;

/*View structure for view disp_mix_size_2 */

/*!50001 DROP TABLE IF EXISTS `disp_mix_size_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_mix_size_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_size_2` AS (select `disp_tb1_size_2`.`order_del_no` AS `order_del_no`,`disp_tb1_size_2`.`order_style_no` AS `order_style_no`,`disp_tb1_size_2`.`order_col_des` AS `order_col_des`,`disp_tb1_size_2`.`total` AS `total`,`disp_tb1_size_2`.`scanned` AS `scanned`,`disp_tb1_size_2`.`unscanned` AS `unscanned`,`disp_tb1_size_2`.`size_code` AS `size_code`,coalesce(`disp_tb2_size_2`.`app`,0) AS `app`,coalesce(`disp_tb2_size_2`.`fail`,0) AS `fail`,(coalesce(`disp_tb1_size_2`.`scanned`,0) - coalesce(`disp_tb2_size_2`.`app`,0)) AS `audit_pending`,coalesce(`audit_disp_tb2_size_2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_size_2`.`fail`,0) AS `fca_fail`,(coalesce(`disp_tb1_size_2`.`scanned`,0) - coalesce(`audit_disp_tb2_size_2`.`app`,0)) AS `fca_audit_pending` from ((`disp_tb1_size_2` left join `disp_tb2_size_2` on(((`disp_tb1_size_2`.`order_del_no` = `disp_tb2_size_2`.`SCHEDULE`) and (`disp_tb1_size_2`.`size_code` = `disp_tb2_size_2`.`size`) and (`disp_tb1_size_2`.`order_col_des` = `disp_tb2_size_2`.`color`)))) left join `audit_disp_tb2_size_2` on(((`disp_tb1_size_2`.`order_del_no` = `audit_disp_tb2_size_2`.`SCHEDULE`) and (`disp_tb1_size_2`.`size_code` = `audit_disp_tb2_size_2`.`size`) and (`disp_tb1_size_2`.`order_col_des` = `audit_disp_tb2_size_2`.`color`)))) where (`disp_tb1_size_2`.`order_del_no` is not null)) */;

/*View structure for view disp_tb1 */

/*!50001 DROP TABLE IF EXISTS `disp_tb1` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,group_concat(distinct `packing_summary`.`tid` separator ',') AS `lable_ids`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if((`packing_summary`.`status` = 'DONE'),`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(isnull(`packing_summary`.`status`),`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where (`packing_summary`.`order_del_no` is not null) group by `packing_summary`.`order_del_no`) */;

/*View structure for view disp_tb1_2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb1_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb1_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_2` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,group_concat(distinct `packing_summary`.`tid` separator ',') AS `lable_ids`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if((`packing_summary`.`status` = 'DONE'),`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(isnull(`packing_summary`.`status`),`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where (`packing_summary`.`order_del_no` is not null) group by `packing_summary`.`order_del_no`,`packing_summary`.`order_col_des`) */;

/*View structure for view disp_tb1_size */

/*!50001 DROP TABLE IF EXISTS `disp_tb1_size` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb1_size` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_size` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,`packing_summary`.`size_code` AS `size_code`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if((`packing_summary`.`status` = 'DONE'),`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(isnull(`packing_summary`.`status`),`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where (`packing_summary`.`order_del_no` is not null) group by `packing_summary`.`order_del_no`,`packing_summary`.`size_code`) */;

/*View structure for view disp_tb1_size_2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb1_size_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb1_size_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_size_2` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,`packing_summary`.`size_code` AS `size_code`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if((`packing_summary`.`status` = 'DONE'),`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(isnull(`packing_summary`.`status`),`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where (`packing_summary`.`order_del_no` is not null) group by `packing_summary`.`order_del_no`,`packing_summary`.`order_col_des`,`packing_summary`.`size_code`) */;

/*View structure for view disp_tb2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,sum(if((`audit_fail_db`.`tran_type` = 1),`audit_fail_db`.`pcs`,0)) AS `app`,sum(if((`audit_fail_db`.`tran_type` = 2),`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`) */;

/*View structure for view disp_tb2_2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb2_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb2_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`color` AS `color`,sum(if((`audit_fail_db`.`tran_type` = 1),`audit_fail_db`.`pcs`,0)) AS `app`,sum(if((`audit_fail_db`.`tran_type` = 2),`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`color`) */;

/*View structure for view disp_tb2_size */

/*!50001 DROP TABLE IF EXISTS `disp_tb2_size` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb2_size` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_size` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`size` AS `size`,sum(if((`audit_fail_db`.`tran_type` = 1),`audit_fail_db`.`pcs`,0)) AS `app`,sum(if((`audit_fail_db`.`tran_type` = 2),`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`size`) */;

/*View structure for view disp_tb2_size_2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb2_size_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb2_size_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_size_2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`size` AS `size`,`audit_fail_db`.`color` AS `color`,sum(if((`audit_fail_db`.`tran_type` = 1),`audit_fail_db`.`pcs`,0)) AS `app`,sum(if((`audit_fail_db`.`tran_type` = 2),`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`size`) */;

/*View structure for view emb_garment_carton_pendings */

/*!50001 DROP TABLE IF EXISTS `emb_garment_carton_pendings` */;
/*!50001 DROP VIEW IF EXISTS `emb_garment_carton_pendings` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `emb_garment_carton_pendings` AS (select min(`pac_stat_log_temp`.`tid`) AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,`pac_stat_log_temp`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where ((`pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no`) and (`pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','')) and (`pac_stat_log_temp`.`disp_carton_no` >= 1) and (`ims_log_backup`.`ims_mod_no` <> 0) and (left(`pac_stat_log_temp`.`status`,1) = 'E')) group by `pac_stat_log_temp`.`doc_no_ref`) */;

/*View structure for view fg_wh_report */

/*!50001 DROP TABLE IF EXISTS `fg_wh_report` */;
/*!50001 DROP VIEW IF EXISTS `fg_wh_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fg_wh_report` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,sum(`packing_summary`.`carton_act_qty`) AS `total_qty`,sum(if((`packing_summary`.`status` = 'DONE'),`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if((isnull(`packing_summary`.`status`) or (length(`packing_summary`.`status`) = 0)),`packing_summary`.`carton_act_qty`,0)) AS `unscanned`,sum(if((left(`packing_summary`.`status`,1) = 'E'),`packing_summary`.`carton_act_qty`,0)) AS `embellish`,0 AS `shipped` from `packing_summary` group by `packing_summary`.`order_del_no`) */;

/*View structure for view fg_wh_report_summary */

/*!50001 DROP TABLE IF EXISTS `fg_wh_report_summary` */;
/*!50001 DROP VIEW IF EXISTS `fg_wh_report_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fg_wh_report_summary` AS (select `fg_wh_report`.`order_del_no` AS `order_del_no`,`fg_wh_report`.`total_qty` AS `total_qty`,`fg_wh_report`.`scanned` AS `scanned`,`fg_wh_report`.`unscanned` AS `unscanned`,`fg_wh_report`.`embellish` AS `embellish`,`fg_wh_report`.`shipped` AS `shipped`,`bai_orders_db_confirm`.`order_date` AS `order_date`,`bai_orders_db_confirm`.`order_po_no` AS `order_po_no`,group_concat(trim(`bai_orders_db_confirm`.`order_col_des`) separator ', ') AS `color`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no` from (`fg_wh_report` left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_del_no` = `fg_wh_report`.`order_del_no`))) where ((`fg_wh_report`.`order_del_no` is not null) and (`fg_wh_report`.`scanned` > 0) and ((`fg_wh_report`.`total_qty` - `fg_wh_report`.`shipped`) <> 0)) group by `fg_wh_report`.`order_del_no`) */;

/*View structure for view fsp_order_ref */

/*!50001 DROP TABLE IF EXISTS `fsp_order_ref` */;
/*!50001 DROP VIEW IF EXISTS `fsp_order_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fsp_order_ref` AS (select `bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`ft_status` AS `ft_status`,`bai_orders_db`.`st_status` AS `st_status`,`bai_orders_db`.`pt_status` AS `pt_status`,group_concat(distinct `bai_orders_db`.`order_col_des` separator ',') AS `color`,sum((((((((((((((((((((`bai_orders_db`.`order_s_xs` + `bai_orders_db`.`order_s_s`) + `bai_orders_db`.`order_s_m`) + `bai_orders_db`.`order_s_l`) + `bai_orders_db`.`order_s_xl`) + `bai_orders_db`.`order_s_xxl`) + `bai_orders_db`.`order_s_xxxl`) + `bai_orders_db`.`order_s_s06`) + `bai_orders_db`.`order_s_s08`) + `bai_orders_db`.`order_s_s10`) + `bai_orders_db`.`order_s_s12`) + `bai_orders_db`.`order_s_s14`) + `bai_orders_db`.`order_s_s16`) + `bai_orders_db`.`order_s_s18`) + `bai_orders_db`.`order_s_s20`) + `bai_orders_db`.`order_s_s22`) + `bai_orders_db`.`order_s_s24`) + `bai_orders_db`.`order_s_s26`) + `bai_orders_db`.`order_s_s28`) + `bai_orders_db`.`order_s_s30`)) AS `order_qty`,`bai_orders_db`.`trim_cards` AS `trim_cards`,`bai_orders_db`.`order_div` AS `order_div`,`bai_orders_db`.`trim_status` AS `trim_status`,`bai_orders_db`.`fsp_time_line` AS `fsp_time_line` from `bai_orders_db` group by `bai_orders_db`.`order_del_no`) */;

/*View structure for view ft_st_pk_shipfast_status */

/*!50001 DROP TABLE IF EXISTS `ft_st_pk_shipfast_status` */;
/*!50001 DROP VIEW IF EXISTS `ft_st_pk_shipfast_status` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ft_st_pk_shipfast_status` AS (select `fastreact_plan_summary`.`group_code` AS `group_code`,`fastreact_plan_summary`.`module` AS `module`,`fastreact_plan_summary`.`style` AS `style`,`fastreact_plan_summary`.`order_code` AS `order_code`,`fastreact_plan_summary`.`color` AS `color`,`fastreact_plan_summary`.`smv` AS `smv`,`fastreact_plan_summary`.`delivery_date` AS `delivery_date`,`fastreact_plan_summary`.`schedule` AS `schedule`,`fastreact_plan_summary`.`production_date` AS `production_date`,`fastreact_plan_summary`.`qty` AS `qty`,`fastreact_plan_summary`.`tid` AS `tid`,`fastreact_plan_summary`.`week_code` AS `week_code`,`fastreact_plan_summary`.`status` AS `status`,`fastreact_plan_summary`.`production_start` AS `production_start`,`bai_pro3`.`bai_orders_db`.`order_tid` AS `order_tid`,`bai_pro3`.`bai_orders_db`.`order_date` AS `order_date`,`bai_pro3`.`bai_orders_db`.`order_upload_date` AS `order_upload_date`,`bai_pro3`.`bai_orders_db`.`order_last_mod_date` AS `order_last_mod_date`,`bai_pro3`.`bai_orders_db`.`order_last_upload_date` AS `order_last_upload_date`,`bai_pro3`.`bai_orders_db`.`order_div` AS `order_div`,`bai_pro3`.`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_pro3`.`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_pro3`.`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_pro3`.`bai_orders_db`.`order_col_code` AS `order_col_code`,`bai_pro3`.`bai_orders_db`.`order_s_xs` AS `order_s_xs`,`bai_pro3`.`bai_orders_db`.`order_s_s` AS `order_s_s`,`bai_pro3`.`bai_orders_db`.`order_s_m` AS `order_s_m`,`bai_pro3`.`bai_orders_db`.`order_s_l` AS `order_s_l`,`bai_pro3`.`bai_orders_db`.`order_s_xl` AS `order_s_xl`,`bai_pro3`.`bai_orders_db`.`order_s_xxl` AS `order_s_xxl`,`bai_pro3`.`bai_orders_db`.`order_s_xxxl` AS `order_s_xxxl`,`bai_pro3`.`bai_orders_db`.`order_cat_stat` AS `order_cat_stat`,`bai_pro3`.`bai_orders_db`.`order_cut_stat` AS `order_cut_stat`,`bai_pro3`.`bai_orders_db`.`order_ratio_stat` AS `order_ratio_stat`,`bai_pro3`.`bai_orders_db`.`order_cad_stat` AS `order_cad_stat`,`bai_pro3`.`bai_orders_db`.`order_stat` AS `order_stat`,`bai_pro3`.`bai_orders_db`.`Order_remarks` AS `Order_remarks`,`bai_pro3`.`bai_orders_db`.`order_po_no` AS `order_po_no`,`bai_pro3`.`bai_orders_db`.`order_no` AS `order_no`,`bai_pro3`.`bai_orders_db`.`old_order_s_xs` AS `old_order_s_xs`,`bai_pro3`.`bai_orders_db`.`old_order_s_s` AS `old_order_s_s`,`bai_pro3`.`bai_orders_db`.`old_order_s_m` AS `old_order_s_m`,`bai_pro3`.`bai_orders_db`.`old_order_s_l` AS `old_order_s_l`,`bai_pro3`.`bai_orders_db`.`old_order_s_xl` AS `old_order_s_xl`,`bai_pro3`.`bai_orders_db`.`old_order_s_xxl` AS `old_order_s_xxl`,`bai_pro3`.`bai_orders_db`.`old_order_s_xxxl` AS `old_order_s_xxxl`,`bai_pro3`.`bai_orders_db`.`color_code` AS `color_code`,`bai_pro3`.`bai_orders_db`.`order_joins` AS `order_joins`,`bai_pro3`.`bai_orders_db`.`order_s_s01` AS `order_s_s01`,`bai_pro3`.`bai_orders_db`.`order_s_s02` AS `order_s_s02`,`bai_pro3`.`bai_orders_db`.`order_s_s03` AS `order_s_s03`,`bai_pro3`.`bai_orders_db`.`order_s_s04` AS `order_s_s04`,`bai_pro3`.`bai_orders_db`.`order_s_s05` AS `order_s_s05`,`bai_pro3`.`bai_orders_db`.`order_s_s06` AS `order_s_s06`,`bai_pro3`.`bai_orders_db`.`order_s_s07` AS `order_s_s07`,`bai_pro3`.`bai_orders_db`.`order_s_s08` AS `order_s_s08`,`bai_pro3`.`bai_orders_db`.`order_s_s09` AS `order_s_s09`,`bai_pro3`.`bai_orders_db`.`order_s_s10` AS `order_s_s10`,`bai_pro3`.`bai_orders_db`.`order_s_s11` AS `order_s_s11`,`bai_pro3`.`bai_orders_db`.`order_s_s12` AS `order_s_s12`,`bai_pro3`.`bai_orders_db`.`order_s_s13` AS `order_s_s13`,`bai_pro3`.`bai_orders_db`.`order_s_s14` AS `order_s_s14`,`bai_pro3`.`bai_orders_db`.`order_s_s15` AS `order_s_s15`,`bai_pro3`.`bai_orders_db`.`order_s_s16` AS `order_s_s16`,`bai_pro3`.`bai_orders_db`.`order_s_s17` AS `order_s_s17`,`bai_pro3`.`bai_orders_db`.`order_s_s18` AS `order_s_s18`,`bai_pro3`.`bai_orders_db`.`order_s_s19` AS `order_s_s19`,`bai_pro3`.`bai_orders_db`.`order_s_s20` AS `order_s_s20`,`bai_pro3`.`bai_orders_db`.`order_s_s21` AS `order_s_s21`,`bai_pro3`.`bai_orders_db`.`order_s_s22` AS `order_s_s22`,`bai_pro3`.`bai_orders_db`.`order_s_s23` AS `order_s_s23`,`bai_pro3`.`bai_orders_db`.`order_s_s24` AS `order_s_s24`,`bai_pro3`.`bai_orders_db`.`order_s_s25` AS `order_s_s25`,`bai_pro3`.`bai_orders_db`.`order_s_s26` AS `order_s_s26`,`bai_pro3`.`bai_orders_db`.`order_s_s27` AS `order_s_s27`,`bai_pro3`.`bai_orders_db`.`order_s_s28` AS `order_s_s28`,`bai_pro3`.`bai_orders_db`.`order_s_s29` AS `order_s_s29`,`bai_pro3`.`bai_orders_db`.`order_s_s30` AS `order_s_s30`,`bai_pro3`.`bai_orders_db`.`order_s_s31` AS `order_s_s31`,`bai_pro3`.`bai_orders_db`.`order_s_s32` AS `order_s_s32`,`bai_pro3`.`bai_orders_db`.`order_s_s33` AS `order_s_s33`,`bai_pro3`.`bai_orders_db`.`order_s_s34` AS `order_s_s34`,`bai_pro3`.`bai_orders_db`.`order_s_s35` AS `order_s_s35`,`bai_pro3`.`bai_orders_db`.`order_s_s36` AS `order_s_s36`,`bai_pro3`.`bai_orders_db`.`order_s_s37` AS `order_s_s37`,`bai_pro3`.`bai_orders_db`.`order_s_s38` AS `order_s_s38`,`bai_pro3`.`bai_orders_db`.`order_s_s39` AS `order_s_s39`,`bai_pro3`.`bai_orders_db`.`order_s_s40` AS `order_s_s40`,`bai_pro3`.`bai_orders_db`.`order_s_s41` AS `order_s_s41`,`bai_pro3`.`bai_orders_db`.`order_s_s42` AS `order_s_s42`,`bai_pro3`.`bai_orders_db`.`order_s_s43` AS `order_s_s43`,`bai_pro3`.`bai_orders_db`.`order_s_s44` AS `order_s_s44`,`bai_pro3`.`bai_orders_db`.`order_s_s45` AS `order_s_s45`,`bai_pro3`.`bai_orders_db`.`order_s_s46` AS `order_s_s46`,`bai_pro3`.`bai_orders_db`.`order_s_s47` AS `order_s_s47`,`bai_pro3`.`bai_orders_db`.`order_s_s48` AS `order_s_s48`,`bai_pro3`.`bai_orders_db`.`order_s_s49` AS `order_s_s49`,`bai_pro3`.`bai_orders_db`.`order_s_s50` AS `order_s_s50`,`bai_pro3`.`bai_orders_db`.`old_order_s_s01` AS `old_order_s_s01`,`bai_pro3`.`bai_orders_db`.`old_order_s_s02` AS `old_order_s_s02`,`bai_pro3`.`bai_orders_db`.`old_order_s_s03` AS `old_order_s_s03`,`bai_pro3`.`bai_orders_db`.`old_order_s_s04` AS `old_order_s_s04`,`bai_pro3`.`bai_orders_db`.`old_order_s_s05` AS `old_order_s_s05`,`bai_pro3`.`bai_orders_db`.`old_order_s_s06` AS `old_order_s_s06`,`bai_pro3`.`bai_orders_db`.`old_order_s_s07` AS `old_order_s_s07`,`bai_pro3`.`bai_orders_db`.`old_order_s_s08` AS `old_order_s_s08`,`bai_pro3`.`bai_orders_db`.`old_order_s_s09` AS `old_order_s_s09`,`bai_pro3`.`bai_orders_db`.`old_order_s_s10` AS `old_order_s_s10`,`bai_pro3`.`bai_orders_db`.`old_order_s_s11` AS `old_order_s_s11`,`bai_pro3`.`bai_orders_db`.`old_order_s_s12` AS `old_order_s_s12`,`bai_pro3`.`bai_orders_db`.`old_order_s_s13` AS `old_order_s_s13`,`bai_pro3`.`bai_orders_db`.`old_order_s_s14` AS `old_order_s_s14`,`bai_pro3`.`bai_orders_db`.`old_order_s_s15` AS `old_order_s_s15`,`bai_pro3`.`bai_orders_db`.`old_order_s_s16` AS `old_order_s_s16`,`bai_pro3`.`bai_orders_db`.`old_order_s_s17` AS `old_order_s_s17`,`bai_pro3`.`bai_orders_db`.`old_order_s_s18` AS `old_order_s_s18`,`bai_pro3`.`bai_orders_db`.`old_order_s_s19` AS `old_order_s_s19`,`bai_pro3`.`bai_orders_db`.`old_order_s_s20` AS `old_order_s_s20`,`bai_pro3`.`bai_orders_db`.`old_order_s_s21` AS `old_order_s_s21`,`bai_pro3`.`bai_orders_db`.`old_order_s_s22` AS `old_order_s_s22`,`bai_pro3`.`bai_orders_db`.`old_order_s_s23` AS `old_order_s_s23`,`bai_pro3`.`bai_orders_db`.`old_order_s_s24` AS `old_order_s_s24`,`bai_pro3`.`bai_orders_db`.`old_order_s_s25` AS `old_order_s_s25`,`bai_pro3`.`bai_orders_db`.`old_order_s_s26` AS `old_order_s_s26`,`bai_pro3`.`bai_orders_db`.`old_order_s_s27` AS `old_order_s_s27`,`bai_pro3`.`bai_orders_db`.`old_order_s_s28` AS `old_order_s_s28`,`bai_pro3`.`bai_orders_db`.`old_order_s_s29` AS `old_order_s_s29`,`bai_pro3`.`bai_orders_db`.`old_order_s_s30` AS `old_order_s_s30`,`bai_pro3`.`bai_orders_db`.`old_order_s_s31` AS `old_order_s_s31`,`bai_pro3`.`bai_orders_db`.`old_order_s_s32` AS `old_order_s_s32`,`bai_pro3`.`bai_orders_db`.`old_order_s_s33` AS `old_order_s_s33`,`bai_pro3`.`bai_orders_db`.`old_order_s_s34` AS `old_order_s_s34`,`bai_pro3`.`bai_orders_db`.`old_order_s_s35` AS `old_order_s_s35`,`bai_pro3`.`bai_orders_db`.`old_order_s_s36` AS `old_order_s_s36`,`bai_pro3`.`bai_orders_db`.`old_order_s_s37` AS `old_order_s_s37`,`bai_pro3`.`bai_orders_db`.`old_order_s_s38` AS `old_order_s_s38`,`bai_pro3`.`bai_orders_db`.`old_order_s_s39` AS `old_order_s_s39`,`bai_pro3`.`bai_orders_db`.`old_order_s_s40` AS `old_order_s_s40`,`bai_pro3`.`bai_orders_db`.`old_order_s_s41` AS `old_order_s_s41`,`bai_pro3`.`bai_orders_db`.`old_order_s_s42` AS `old_order_s_s42`,`bai_pro3`.`bai_orders_db`.`old_order_s_s43` AS `old_order_s_s43`,`bai_pro3`.`bai_orders_db`.`old_order_s_s44` AS `old_order_s_s44`,`bai_pro3`.`bai_orders_db`.`old_order_s_s45` AS `old_order_s_s45`,`bai_pro3`.`bai_orders_db`.`old_order_s_s46` AS `old_order_s_s46`,`bai_pro3`.`bai_orders_db`.`old_order_s_s47` AS `old_order_s_s47`,`bai_pro3`.`bai_orders_db`.`old_order_s_s48` AS `old_order_s_s48`,`bai_pro3`.`bai_orders_db`.`old_order_s_s49` AS `old_order_s_s49`,`bai_pro3`.`bai_orders_db`.`old_order_s_s50` AS `old_order_s_s50`,`bai_pro3`.`bai_orders_db`.`packing_method` AS `packing_method`,`bai_pro3`.`bai_orders_db`.`style_id` AS `style_id`,`bai_pro3`.`bai_orders_db`.`carton_id` AS `carton_id`,`bai_pro3`.`bai_orders_db`.`carton_print_status` AS `carton_print_status`,`bai_pro3`.`bai_orders_db`.`ft_status` AS `ft_status`,`bai_pro3`.`bai_orders_db`.`st_status` AS `st_status`,`bai_pro3`.`bai_orders_db`.`pt_status` AS `pt_status` from (`bai_pro4`.`fastreact_plan_summary` left join `bai_pro3`.`bai_orders_db` on((`fastreact_plan_summary`.`schedule` = `bai_pro3`.`bai_orders_db`.`order_del_no`))) order by `fastreact_plan_summary`.`production_start`) */;

/*View structure for view ims_combine */

/*!50001 DROP TABLE IF EXISTS `ims_combine` */;
/*!50001 DROP VIEW IF EXISTS `ims_combine` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_combine` AS select `ims_log`.`ims_date` AS `ims_date`,`ims_log`.`ims_cid` AS `ims_cid`,`ims_log`.`ims_doc_no` AS `ims_doc_no`,`ims_log`.`ims_mod_no` AS `ims_mod_no`,`ims_log`.`ims_shift` AS `ims_shift`,`ims_log`.`ims_size` AS `ims_size`,`ims_log`.`ims_qty` AS `ims_qty`,`ims_log`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log`.`ims_status` AS `ims_status`,`ims_log`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log`.`ims_log_date` AS `ims_log_date`,`ims_log`.`ims_remarks` AS `ims_remarks`,`ims_log`.`ims_style` AS `ims_style`,`ims_log`.`ims_schedule` AS `ims_schedule`,`ims_log`.`ims_color` AS `ims_color`,`ims_log`.`tid` AS `tid`,`ims_log`.`rand_track` AS `rand_track`,`ims_log`.`input_job_no_ref` AS `input_job_no_ref` from `ims_log` union all select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,`ims_log_backup`.`ims_qty` AS `ims_qty`,`ims_log_backup`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track`,`ims_log_backup`.`input_job_no_ref` AS `input_job_no_ref` from `ims_log_backup` */;

/*View structure for view ims_log_backup_t1 */

/*!50001 DROP TABLE IF EXISTS `ims_log_backup_t1` */;
/*!50001 DROP VIEW IF EXISTS `ims_log_backup_t1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_backup_t1` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track` from `ims_log_backup` where (`ims_log_backup`.`ims_mod_no` <> 0) group by `ims_log_backup`.`ims_doc_no`,`ims_log_backup`.`ims_size`) */;

/*View structure for view ims_log_backup_t2 */

/*!50001 DROP TABLE IF EXISTS `ims_log_backup_t2` */;
/*!50001 DROP VIEW IF EXISTS `ims_log_backup_t2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_backup_t2` AS (select `ims_log`.`ims_date` AS `ims_date`,`ims_log`.`ims_cid` AS `ims_cid`,`ims_log`.`ims_doc_no` AS `ims_doc_no`,`ims_log`.`ims_mod_no` AS `ims_mod_no`,`ims_log`.`ims_shift` AS `ims_shift`,`ims_log`.`ims_size` AS `ims_size`,sum(`ims_log`.`ims_qty`) AS `ims_qty`,sum(`ims_log`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log`.`ims_status` AS `ims_status`,`ims_log`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log`.`ims_log_date` AS `ims_log_date`,`ims_log`.`ims_remarks` AS `ims_remarks`,`ims_log`.`ims_style` AS `ims_style`,`ims_log`.`ims_schedule` AS `ims_schedule`,`ims_log`.`ims_color` AS `ims_color`,`ims_log`.`tid` AS `tid`,`ims_log`.`rand_track` AS `rand_track` from `ims_log` where (`ims_log`.`ims_mod_no` <> 0) group by `ims_log`.`ims_doc_no`,`ims_log`.`ims_size`) */;

/*View structure for view ims_log_long_pending_transfers */

/*!50001 DROP TABLE IF EXISTS `ims_log_long_pending_transfers` */;
/*!50001 DROP VIEW IF EXISTS `ims_log_long_pending_transfers` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_long_pending_transfers` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,`ims_log_backup`.`ims_qty` AS `ims_qty`,`ims_log_backup`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color` from `ims_log_backup` where (((`ims_log_backup`.`ims_qty` - `ims_log_backup`.`ims_pro_qty`) > 0) and (`ims_log_backup`.`ims_mod_no` <> 0) and (`ims_log_backup`.`ims_date` > '2010-10-01'))) */;

/*View structure for view incentive_emb_reference */

/*!50001 DROP TABLE IF EXISTS `incentive_emb_reference` */;
/*!50001 DROP VIEW IF EXISTS `incentive_emb_reference` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incentive_emb_reference` AS (select `bai_orders_db`.`order_del_no` AS `order_del_no`,if(((((((((0 + 0) + 0) + 0) + `bai_orders_db`.`order_embl_e`) + `bai_orders_db`.`order_embl_f`) + 0) + 0) > 0),1,0) AS `emb_stat` from `bai_orders_db` where ((((((((0 + 0) + 0) + 0) + `bai_orders_db`.`order_embl_e`) + `bai_orders_db`.`order_embl_f`) + 0) + 0) > 0) group by `bai_orders_db`.`order_del_no`) */;

/*View structure for view incentive_fca_audit_fail_sch */

/*!50001 DROP TABLE IF EXISTS `incentive_fca_audit_fail_sch` */;
/*!50001 DROP VIEW IF EXISTS `incentive_fca_audit_fail_sch` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incentive_fca_audit_fail_sch` AS (select `fca_audit_fail_db`.`schedule` AS `schedule`,group_concat(distinct `fca_audit_fail_db`.`remarks` separator ',') AS `remarks` from `fca_audit_fail_db` where (`fca_audit_fail_db`.`tran_type` = 2) group by `fca_audit_fail_db`.`schedule`) */;

/*View structure for view live_pro_table_ref */

/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref` */;
/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from ((`ims_log` left join `plandoc_stat_log` on((`plandoc_stat_log`.`doc_no` = `ims_log`.`ims_doc_no`))) left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))) */;

/*View structure for view live_pro_table_ref2 */

/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref2` */;
/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref2` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from (`plandoc_stat_log` left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))) */;

/*View structure for view live_pro_table_ref3 */

/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref3` */;
/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref3` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref3` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from ((`ims_log_backup` left join `plandoc_stat_log` on((`plandoc_stat_log`.`doc_no` = `ims_log_backup`.`ims_doc_no`))) left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))) */;

/*View structure for view marker_ref_matrix_view */

/*!50001 DROP TABLE IF EXISTS `marker_ref_matrix_view` */;
/*!50001 DROP VIEW IF EXISTS `marker_ref_matrix_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `marker_ref_matrix_view` AS (select `cat_stat_log`.`category` AS `category`,`cat_stat_log`.`strip_match` AS `strip_match`,`cat_stat_log`.`gmtway` AS `gmtway`,`marker_ref_matrix`.`marker_ref_tid` AS `marker_ref_tid`,`marker_ref_matrix`.`marker_width` AS `marker_width`,`marker_ref_matrix`.`marker_length` AS `marker_length`,`marker_ref_matrix`.`marker_ref` AS `marker_ref`,`marker_ref_matrix`.`cat_ref` AS `cat_ref`,`marker_ref_matrix`.`allocate_ref` AS `allocate_ref`,`marker_ref_matrix`.`style_code` AS `style_code`,`marker_ref_matrix`.`buyer_code` AS `buyer_code`,`marker_ref_matrix`.`pat_ver` AS `pat_ver`,`marker_ref_matrix`.`xs` AS `xs`,`marker_ref_matrix`.`s` AS `s`,`marker_ref_matrix`.`m` AS `m`,`marker_ref_matrix`.`l` AS `l`,`marker_ref_matrix`.`xl` AS `xl`,`marker_ref_matrix`.`xxl` AS `xxl`,`marker_ref_matrix`.`xxxl` AS `xxxl`,`marker_ref_matrix`.`s01` AS `s01`,`marker_ref_matrix`.`s02` AS `s02`,`marker_ref_matrix`.`s03` AS `s03`,`marker_ref_matrix`.`s04` AS `s04`,`marker_ref_matrix`.`s05` AS `s05`,`marker_ref_matrix`.`s06` AS `s06`,`marker_ref_matrix`.`s07` AS `s07`,`marker_ref_matrix`.`s08` AS `s08`,`marker_ref_matrix`.`s09` AS `s09`,`marker_ref_matrix`.`s10` AS `s10`,`marker_ref_matrix`.`s11` AS `s11`,`marker_ref_matrix`.`s12` AS `s12`,`marker_ref_matrix`.`s13` AS `s13`,`marker_ref_matrix`.`s14` AS `s14`,`marker_ref_matrix`.`s15` AS `s15`,`marker_ref_matrix`.`s16` AS `s16`,`marker_ref_matrix`.`s17` AS `s17`,`marker_ref_matrix`.`s18` AS `s18`,`marker_ref_matrix`.`s19` AS `s19`,`marker_ref_matrix`.`s20` AS `s20`,`marker_ref_matrix`.`s21` AS `s21`,`marker_ref_matrix`.`s22` AS `s22`,`marker_ref_matrix`.`s23` AS `s23`,`marker_ref_matrix`.`s24` AS `s24`,`marker_ref_matrix`.`s25` AS `s25`,`marker_ref_matrix`.`s26` AS `s26`,`marker_ref_matrix`.`s27` AS `s27`,`marker_ref_matrix`.`s28` AS `s28`,`marker_ref_matrix`.`s29` AS `s29`,`marker_ref_matrix`.`s30` AS `s30`,`marker_ref_matrix`.`s31` AS `s31`,`marker_ref_matrix`.`s32` AS `s32`,`marker_ref_matrix`.`s33` AS `s33`,`marker_ref_matrix`.`s34` AS `s34`,`marker_ref_matrix`.`s35` AS `s35`,`marker_ref_matrix`.`s36` AS `s36`,`marker_ref_matrix`.`s37` AS `s37`,`marker_ref_matrix`.`s38` AS `s38`,`marker_ref_matrix`.`s39` AS `s39`,`marker_ref_matrix`.`s40` AS `s40`,`marker_ref_matrix`.`s41` AS `s41`,`marker_ref_matrix`.`s42` AS `s42`,`marker_ref_matrix`.`s43` AS `s43`,`marker_ref_matrix`.`s44` AS `s44`,`marker_ref_matrix`.`s45` AS `s45`,`marker_ref_matrix`.`s46` AS `s46`,`marker_ref_matrix`.`s47` AS `s47`,`marker_ref_matrix`.`s48` AS `s48`,`marker_ref_matrix`.`s49` AS `s49`,`marker_ref_matrix`.`s50` AS `s50`,`marker_ref_matrix`.`lastup` AS `lastup`,`marker_ref_matrix`.`title_size_s01` AS `title_size_s01`,`marker_ref_matrix`.`title_size_s02` AS `title_size_s02`,`marker_ref_matrix`.`title_size_s03` AS `title_size_s03`,`marker_ref_matrix`.`title_size_s04` AS `title_size_s04`,`marker_ref_matrix`.`title_size_s05` AS `title_size_s05`,`marker_ref_matrix`.`title_size_s06` AS `title_size_s06`,`marker_ref_matrix`.`title_size_s07` AS `title_size_s07`,`marker_ref_matrix`.`title_size_s08` AS `title_size_s08`,`marker_ref_matrix`.`title_size_s09` AS `title_size_s09`,`marker_ref_matrix`.`title_size_s10` AS `title_size_s10`,`marker_ref_matrix`.`title_size_s11` AS `title_size_s11`,`marker_ref_matrix`.`title_size_s12` AS `title_size_s12`,`marker_ref_matrix`.`title_size_s13` AS `title_size_s13`,`marker_ref_matrix`.`title_size_s14` AS `title_size_s14`,`marker_ref_matrix`.`title_size_s15` AS `title_size_s15`,`marker_ref_matrix`.`title_size_s16` AS `title_size_s16`,`marker_ref_matrix`.`title_size_s17` AS `title_size_s17`,`marker_ref_matrix`.`title_size_s18` AS `title_size_s18`,`marker_ref_matrix`.`title_size_s19` AS `title_size_s19`,`marker_ref_matrix`.`title_size_s20` AS `title_size_s20`,`marker_ref_matrix`.`title_size_s21` AS `title_size_s21`,`marker_ref_matrix`.`title_size_s22` AS `title_size_s22`,`marker_ref_matrix`.`title_size_s23` AS `title_size_s23`,`marker_ref_matrix`.`title_size_s24` AS `title_size_s24`,`marker_ref_matrix`.`title_size_s25` AS `title_size_s25`,`marker_ref_matrix`.`title_size_s26` AS `title_size_s26`,`marker_ref_matrix`.`title_size_s27` AS `title_size_s27`,`marker_ref_matrix`.`title_size_s28` AS `title_size_s28`,`marker_ref_matrix`.`title_size_s29` AS `title_size_s29`,`marker_ref_matrix`.`title_size_s30` AS `title_size_s30`,`marker_ref_matrix`.`title_size_s31` AS `title_size_s31`,`marker_ref_matrix`.`title_size_s32` AS `title_size_s32`,`marker_ref_matrix`.`title_size_s33` AS `title_size_s33`,`marker_ref_matrix`.`title_size_s34` AS `title_size_s34`,`marker_ref_matrix`.`title_size_s35` AS `title_size_s35`,`marker_ref_matrix`.`title_size_s36` AS `title_size_s36`,`marker_ref_matrix`.`title_size_s37` AS `title_size_s37`,`marker_ref_matrix`.`title_size_s38` AS `title_size_s38`,`marker_ref_matrix`.`title_size_s39` AS `title_size_s39`,`marker_ref_matrix`.`title_size_s40` AS `title_size_s40`,`marker_ref_matrix`.`title_size_s41` AS `title_size_s41`,`marker_ref_matrix`.`title_size_s42` AS `title_size_s42`,`marker_ref_matrix`.`title_size_s43` AS `title_size_s43`,`marker_ref_matrix`.`title_size_s44` AS `title_size_s44`,`marker_ref_matrix`.`title_size_s45` AS `title_size_s45`,`marker_ref_matrix`.`title_size_s46` AS `title_size_s46`,`marker_ref_matrix`.`title_size_s47` AS `title_size_s47`,`marker_ref_matrix`.`title_size_s48` AS `title_size_s48`,`marker_ref_matrix`.`title_size_s49` AS `title_size_s49`,`marker_ref_matrix`.`title_size_s50` AS `title_size_s50`,`marker_ref_matrix`.`title_flag` AS `title_flag`,`maker_stat_log`.`remarks` AS `remarks` from ((`marker_ref_matrix` left join `cat_stat_log` on((`marker_ref_matrix`.`cat_ref` = `cat_stat_log`.`tid`))) left join `maker_stat_log` on(((`marker_ref_matrix`.`cat_ref` = `maker_stat_log`.`cat_ref`) and (`marker_ref_matrix`.`allocate_ref` = `maker_stat_log`.`allocate_ref`))))) */;

/*View structure for view order_cat_doc_mix */

/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mix` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_doc_mix` AS (select `cat_stat_log`.`catyy` AS `catyy`,`bai_orders_db`.`style_id` AS `style_id`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`cat_stat_log`.`patt_ver` AS `cat_patt_ver`,`cat_stat_log`.`strip_match` AS `strip_match`,`cat_stat_log`.`col_des` AS `col_des`,`plandoc_stat_log`.`date` AS `date`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,`plandoc_stat_log`.`cuttable_ref` AS `cuttable_ref`,`plandoc_stat_log`.`allocate_ref` AS `allocate_ref`,`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`pcutno` AS `pcutno`,`plandoc_stat_log`.`ratio` AS `ratio`,`plandoc_stat_log`.`p_xs` AS `p_xs`,`plandoc_stat_log`.`p_s` AS `p_s`,`plandoc_stat_log`.`p_m` AS `p_m`,`plandoc_stat_log`.`p_l` AS `p_l`,`plandoc_stat_log`.`p_xl` AS `p_xl`,`plandoc_stat_log`.`p_xxl` AS `p_xxl`,`plandoc_stat_log`.`p_xxxl` AS `p_xxxl`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`a_xs` AS `a_xs`,`plandoc_stat_log`.`a_s` AS `a_s`,`plandoc_stat_log`.`a_m` AS `a_m`,`plandoc_stat_log`.`a_l` AS `a_l`,`plandoc_stat_log`.`a_xl` AS `a_xl`,`plandoc_stat_log`.`a_xxl` AS `a_xxl`,`plandoc_stat_log`.`a_xxxl` AS `a_xxxl`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`lastup` AS `lastup`,`plandoc_stat_log`.`remarks` AS `remarks`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`pcutdocid` AS `pcutdocid`,`plandoc_stat_log`.`print_status` AS `print_status`,`plandoc_stat_log`.`a_s01` AS `a_s01`,`plandoc_stat_log`.`a_s02` AS `a_s02`,`plandoc_stat_log`.`a_s03` AS `a_s03`,`plandoc_stat_log`.`a_s04` AS `a_s04`,`plandoc_stat_log`.`a_s05` AS `a_s05`,`plandoc_stat_log`.`a_s06` AS `a_s06`,`plandoc_stat_log`.`a_s07` AS `a_s07`,`plandoc_stat_log`.`a_s08` AS `a_s08`,`plandoc_stat_log`.`a_s09` AS `a_s09`,`plandoc_stat_log`.`a_s10` AS `a_s10`,`plandoc_stat_log`.`a_s11` AS `a_s11`,`plandoc_stat_log`.`a_s12` AS `a_s12`,`plandoc_stat_log`.`a_s13` AS `a_s13`,`plandoc_stat_log`.`a_s14` AS `a_s14`,`plandoc_stat_log`.`a_s15` AS `a_s15`,`plandoc_stat_log`.`a_s16` AS `a_s16`,`plandoc_stat_log`.`a_s17` AS `a_s17`,`plandoc_stat_log`.`a_s18` AS `a_s18`,`plandoc_stat_log`.`a_s19` AS `a_s19`,`plandoc_stat_log`.`a_s20` AS `a_s20`,`plandoc_stat_log`.`a_s21` AS `a_s21`,`plandoc_stat_log`.`a_s22` AS `a_s22`,`plandoc_stat_log`.`a_s23` AS `a_s23`,`plandoc_stat_log`.`a_s24` AS `a_s24`,`plandoc_stat_log`.`a_s25` AS `a_s25`,`plandoc_stat_log`.`a_s26` AS `a_s26`,`plandoc_stat_log`.`a_s27` AS `a_s27`,`plandoc_stat_log`.`a_s28` AS `a_s28`,`plandoc_stat_log`.`a_s29` AS `a_s29`,`plandoc_stat_log`.`a_s30` AS `a_s30`,`plandoc_stat_log`.`a_s31` AS `a_s31`,`plandoc_stat_log`.`a_s32` AS `a_s32`,`plandoc_stat_log`.`a_s33` AS `a_s33`,`plandoc_stat_log`.`a_s34` AS `a_s34`,`plandoc_stat_log`.`a_s35` AS `a_s35`,`plandoc_stat_log`.`a_s36` AS `a_s36`,`plandoc_stat_log`.`a_s37` AS `a_s37`,`plandoc_stat_log`.`a_s38` AS `a_s38`,`plandoc_stat_log`.`a_s39` AS `a_s39`,`plandoc_stat_log`.`a_s40` AS `a_s40`,`plandoc_stat_log`.`a_s41` AS `a_s41`,`plandoc_stat_log`.`a_s42` AS `a_s42`,`plandoc_stat_log`.`a_s43` AS `a_s43`,`plandoc_stat_log`.`a_s44` AS `a_s44`,`plandoc_stat_log`.`a_s45` AS `a_s45`,`plandoc_stat_log`.`a_s46` AS `a_s46`,`plandoc_stat_log`.`a_s47` AS `a_s47`,`plandoc_stat_log`.`a_s48` AS `a_s48`,`plandoc_stat_log`.`a_s49` AS `a_s49`,`plandoc_stat_log`.`a_s50` AS `a_s50`,`plandoc_stat_log`.`p_s01` AS `p_s01`,`plandoc_stat_log`.`p_s02` AS `p_s02`,`plandoc_stat_log`.`p_s03` AS `p_s03`,`plandoc_stat_log`.`p_s04` AS `p_s04`,`plandoc_stat_log`.`p_s05` AS `p_s05`,`plandoc_stat_log`.`p_s06` AS `p_s06`,`plandoc_stat_log`.`p_s07` AS `p_s07`,`plandoc_stat_log`.`p_s08` AS `p_s08`,`plandoc_stat_log`.`p_s09` AS `p_s09`,`plandoc_stat_log`.`p_s10` AS `p_s10`,`plandoc_stat_log`.`p_s11` AS `p_s11`,`plandoc_stat_log`.`p_s12` AS `p_s12`,`plandoc_stat_log`.`p_s13` AS `p_s13`,`plandoc_stat_log`.`p_s14` AS `p_s14`,`plandoc_stat_log`.`p_s15` AS `p_s15`,`plandoc_stat_log`.`p_s16` AS `p_s16`,`plandoc_stat_log`.`p_s17` AS `p_s17`,`plandoc_stat_log`.`p_s18` AS `p_s18`,`plandoc_stat_log`.`p_s19` AS `p_s19`,`plandoc_stat_log`.`p_s20` AS `p_s20`,`plandoc_stat_log`.`p_s21` AS `p_s21`,`plandoc_stat_log`.`p_s22` AS `p_s22`,`plandoc_stat_log`.`p_s23` AS `p_s23`,`plandoc_stat_log`.`p_s24` AS `p_s24`,`plandoc_stat_log`.`p_s25` AS `p_s25`,`plandoc_stat_log`.`p_s26` AS `p_s26`,`plandoc_stat_log`.`p_s27` AS `p_s27`,`plandoc_stat_log`.`p_s28` AS `p_s28`,`plandoc_stat_log`.`p_s29` AS `p_s29`,`plandoc_stat_log`.`p_s30` AS `p_s30`,`plandoc_stat_log`.`p_s31` AS `p_s31`,`plandoc_stat_log`.`p_s32` AS `p_s32`,`plandoc_stat_log`.`p_s33` AS `p_s33`,`plandoc_stat_log`.`p_s34` AS `p_s34`,`plandoc_stat_log`.`p_s35` AS `p_s35`,`plandoc_stat_log`.`p_s36` AS `p_s36`,`plandoc_stat_log`.`p_s37` AS `p_s37`,`plandoc_stat_log`.`p_s38` AS `p_s38`,`plandoc_stat_log`.`p_s39` AS `p_s39`,`plandoc_stat_log`.`p_s40` AS `p_s40`,`plandoc_stat_log`.`p_s41` AS `p_s41`,`plandoc_stat_log`.`p_s42` AS `p_s42`,`plandoc_stat_log`.`p_s43` AS `p_s43`,`plandoc_stat_log`.`p_s44` AS `p_s44`,`plandoc_stat_log`.`p_s45` AS `p_s45`,`plandoc_stat_log`.`p_s46` AS `p_s46`,`plandoc_stat_log`.`p_s47` AS `p_s47`,`plandoc_stat_log`.`p_s48` AS `p_s48`,`plandoc_stat_log`.`p_s49` AS `p_s49`,`plandoc_stat_log`.`p_s50` AS `p_s50`,`plandoc_stat_log`.`rm_date` AS `rm_date`,`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`fab_des` AS `fab_des`,`cat_stat_log`.`gmtway` AS `gmtway`,`cat_stat_log`.`compo_no` AS `compo_no`,`cat_stat_log`.`purwidth` AS `purwidth`,`bai_orders_db`.`color_code` AS `color_code`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`fabric_status` AS `fabric_status`,`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des` from ((`plandoc_stat_log` left join `cat_stat_log` on((`plandoc_stat_log`.`cat_ref` = `cat_stat_log`.`tid`))) left join `bai_orders_db` on((`plandoc_stat_log`.`order_tid` = `bai_orders_db`.`order_tid`)))) */;

/*View structure for view order_cat_doc_mk_mix */

/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mk_mix` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mk_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_doc_mk_mix` AS (select `order_cat_doc_mix`.`catyy` AS `catyy`,`order_cat_doc_mix`.`cat_patt_ver` AS `cat_patt_ver`,`maker_stat_log`.`remarks` AS `mk_file`,`maker_stat_log`.`mk_ver` AS `mk_ver`,`maker_stat_log`.`mklength` AS `mklength`,`order_cat_doc_mix`.`style_id` AS `style_id`,`order_cat_doc_mix`.`col_des` AS `col_des`,`order_cat_doc_mix`.`gmtway` AS `gmtway`,`order_cat_doc_mix`.`strip_match` AS `strip_match`,`order_cat_doc_mix`.`fab_des` AS `fab_des`,`order_cat_doc_mix`.`clubbing` AS `clubbing`,`order_cat_doc_mix`.`date` AS `date`,`order_cat_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_doc_mix`.`compo_no` AS `compo_no`,`order_cat_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_doc_mix`.`order_tid` AS `order_tid`,`order_cat_doc_mix`.`pcutno` AS `pcutno`,`order_cat_doc_mix`.`ratio` AS `ratio`,`order_cat_doc_mix`.`p_xs` AS `p_xs`,`order_cat_doc_mix`.`p_s` AS `p_s`,`order_cat_doc_mix`.`p_m` AS `p_m`,`order_cat_doc_mix`.`p_l` AS `p_l`,`order_cat_doc_mix`.`p_xl` AS `p_xl`,`order_cat_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_doc_mix`.`p_plies` AS `p_plies`,`order_cat_doc_mix`.`doc_no` AS `doc_no`,`order_cat_doc_mix`.`acutno` AS `acutno`,`order_cat_doc_mix`.`a_xs` AS `a_xs`,`order_cat_doc_mix`.`a_s` AS `a_s`,`order_cat_doc_mix`.`a_m` AS `a_m`,`order_cat_doc_mix`.`a_l` AS `a_l`,`order_cat_doc_mix`.`a_xl` AS `a_xl`,`order_cat_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_doc_mix`.`a_plies` AS `a_plies`,`order_cat_doc_mix`.`lastup` AS `lastup`,`order_cat_doc_mix`.`remarks` AS `remarks`,`order_cat_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_doc_mix`.`print_status` AS `print_status`,`order_cat_doc_mix`.`a_s01` AS `a_s01`,`order_cat_doc_mix`.`a_s02` AS `a_s02`,`order_cat_doc_mix`.`a_s03` AS `a_s03`,`order_cat_doc_mix`.`a_s04` AS `a_s04`,`order_cat_doc_mix`.`a_s05` AS `a_s05`,`order_cat_doc_mix`.`a_s06` AS `a_s06`,`order_cat_doc_mix`.`a_s07` AS `a_s07`,`order_cat_doc_mix`.`a_s08` AS `a_s08`,`order_cat_doc_mix`.`a_s09` AS `a_s09`,`order_cat_doc_mix`.`a_s10` AS `a_s10`,`order_cat_doc_mix`.`a_s11` AS `a_s11`,`order_cat_doc_mix`.`a_s12` AS `a_s12`,`order_cat_doc_mix`.`a_s13` AS `a_s13`,`order_cat_doc_mix`.`a_s14` AS `a_s14`,`order_cat_doc_mix`.`a_s15` AS `a_s15`,`order_cat_doc_mix`.`a_s16` AS `a_s16`,`order_cat_doc_mix`.`a_s17` AS `a_s17`,`order_cat_doc_mix`.`a_s18` AS `a_s18`,`order_cat_doc_mix`.`a_s19` AS `a_s19`,`order_cat_doc_mix`.`a_s20` AS `a_s20`,`order_cat_doc_mix`.`a_s21` AS `a_s21`,`order_cat_doc_mix`.`a_s22` AS `a_s22`,`order_cat_doc_mix`.`a_s23` AS `a_s23`,`order_cat_doc_mix`.`a_s24` AS `a_s24`,`order_cat_doc_mix`.`a_s25` AS `a_s25`,`order_cat_doc_mix`.`a_s26` AS `a_s26`,`order_cat_doc_mix`.`a_s27` AS `a_s27`,`order_cat_doc_mix`.`a_s28` AS `a_s28`,`order_cat_doc_mix`.`a_s29` AS `a_s29`,`order_cat_doc_mix`.`a_s30` AS `a_s30`,`order_cat_doc_mix`.`a_s31` AS `a_s31`,`order_cat_doc_mix`.`a_s32` AS `a_s32`,`order_cat_doc_mix`.`a_s33` AS `a_s33`,`order_cat_doc_mix`.`a_s34` AS `a_s34`,`order_cat_doc_mix`.`a_s35` AS `a_s35`,`order_cat_doc_mix`.`a_s36` AS `a_s36`,`order_cat_doc_mix`.`a_s37` AS `a_s37`,`order_cat_doc_mix`.`a_s38` AS `a_s38`,`order_cat_doc_mix`.`a_s39` AS `a_s39`,`order_cat_doc_mix`.`a_s40` AS `a_s40`,`order_cat_doc_mix`.`a_s41` AS `a_s41`,`order_cat_doc_mix`.`a_s42` AS `a_s42`,`order_cat_doc_mix`.`a_s43` AS `a_s43`,`order_cat_doc_mix`.`a_s44` AS `a_s44`,`order_cat_doc_mix`.`a_s45` AS `a_s45`,`order_cat_doc_mix`.`a_s46` AS `a_s46`,`order_cat_doc_mix`.`a_s47` AS `a_s47`,`order_cat_doc_mix`.`a_s48` AS `a_s48`,`order_cat_doc_mix`.`a_s49` AS `a_s49`,`order_cat_doc_mix`.`a_s50` AS `a_s50`,`order_cat_doc_mix`.`p_s01` AS `p_s01`,`order_cat_doc_mix`.`p_s02` AS `p_s02`,`order_cat_doc_mix`.`p_s03` AS `p_s03`,`order_cat_doc_mix`.`p_s04` AS `p_s04`,`order_cat_doc_mix`.`p_s05` AS `p_s05`,`order_cat_doc_mix`.`p_s06` AS `p_s06`,`order_cat_doc_mix`.`p_s07` AS `p_s07`,`order_cat_doc_mix`.`p_s08` AS `p_s08`,`order_cat_doc_mix`.`p_s09` AS `p_s09`,`order_cat_doc_mix`.`p_s10` AS `p_s10`,`order_cat_doc_mix`.`p_s11` AS `p_s11`,`order_cat_doc_mix`.`p_s12` AS `p_s12`,`order_cat_doc_mix`.`p_s13` AS `p_s13`,`order_cat_doc_mix`.`p_s14` AS `p_s14`,`order_cat_doc_mix`.`p_s15` AS `p_s15`,`order_cat_doc_mix`.`p_s16` AS `p_s16`,`order_cat_doc_mix`.`p_s17` AS `p_s17`,`order_cat_doc_mix`.`p_s18` AS `p_s18`,`order_cat_doc_mix`.`p_s19` AS `p_s19`,`order_cat_doc_mix`.`p_s20` AS `p_s20`,`order_cat_doc_mix`.`p_s21` AS `p_s21`,`order_cat_doc_mix`.`p_s22` AS `p_s22`,`order_cat_doc_mix`.`p_s23` AS `p_s23`,`order_cat_doc_mix`.`p_s24` AS `p_s24`,`order_cat_doc_mix`.`p_s25` AS `p_s25`,`order_cat_doc_mix`.`p_s26` AS `p_s26`,`order_cat_doc_mix`.`p_s27` AS `p_s27`,`order_cat_doc_mix`.`p_s28` AS `p_s28`,`order_cat_doc_mix`.`p_s29` AS `p_s29`,`order_cat_doc_mix`.`p_s30` AS `p_s30`,`order_cat_doc_mix`.`p_s31` AS `p_s31`,`order_cat_doc_mix`.`p_s32` AS `p_s32`,`order_cat_doc_mix`.`p_s33` AS `p_s33`,`order_cat_doc_mix`.`p_s34` AS `p_s34`,`order_cat_doc_mix`.`p_s35` AS `p_s35`,`order_cat_doc_mix`.`p_s36` AS `p_s36`,`order_cat_doc_mix`.`p_s37` AS `p_s37`,`order_cat_doc_mix`.`p_s38` AS `p_s38`,`order_cat_doc_mix`.`p_s39` AS `p_s39`,`order_cat_doc_mix`.`p_s40` AS `p_s40`,`order_cat_doc_mix`.`p_s41` AS `p_s41`,`order_cat_doc_mix`.`p_s42` AS `p_s42`,`order_cat_doc_mix`.`p_s43` AS `p_s43`,`order_cat_doc_mix`.`p_s44` AS `p_s44`,`order_cat_doc_mix`.`p_s45` AS `p_s45`,`order_cat_doc_mix`.`p_s46` AS `p_s46`,`order_cat_doc_mix`.`p_s47` AS `p_s47`,`order_cat_doc_mix`.`p_s48` AS `p_s48`,`order_cat_doc_mix`.`p_s49` AS `p_s49`,`order_cat_doc_mix`.`p_s50` AS `p_s50`,`order_cat_doc_mix`.`rm_date` AS `rm_date`,`order_cat_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_doc_mix`.`plan_module` AS `plan_module`,`order_cat_doc_mix`.`category` AS `category`,`order_cat_doc_mix`.`color_code` AS `color_code`,`order_cat_doc_mix`.`fabric_status` AS `fabric_status`,(round(((`order_cat_doc_mix`.`a_plies` * `maker_stat_log`.`mklength`) * (1 + `cuttable_stat_log`.`cuttable_wastage`)),2) + ((((((((((((((((((((((((((((((((((((((((((((((((((((((((((`order_cat_doc_mix`.`a_xs` + `order_cat_doc_mix`.`a_s`) + `order_cat_doc_mix`.`a_m`) + `order_cat_doc_mix`.`a_l`) + `order_cat_doc_mix`.`a_xl`) + `order_cat_doc_mix`.`a_xxl`) + `order_cat_doc_mix`.`a_xxxl`) + `order_cat_doc_mix`.`a_s01`) + `order_cat_doc_mix`.`a_s02`) + `order_cat_doc_mix`.`a_s03`) + `order_cat_doc_mix`.`a_s04`) + `order_cat_doc_mix`.`a_s05`) + `order_cat_doc_mix`.`a_s06`) + `order_cat_doc_mix`.`a_s07`) + `order_cat_doc_mix`.`a_s08`) + `order_cat_doc_mix`.`a_s09`) + `order_cat_doc_mix`.`a_s10`) + `order_cat_doc_mix`.`a_s11`) + `order_cat_doc_mix`.`a_s12`) + `order_cat_doc_mix`.`a_s13`) + `order_cat_doc_mix`.`a_s14`) + `order_cat_doc_mix`.`a_s15`) + `order_cat_doc_mix`.`a_s16`) + `order_cat_doc_mix`.`a_s17`) + `order_cat_doc_mix`.`a_s18`) + `order_cat_doc_mix`.`a_s19`) + `order_cat_doc_mix`.`a_s20`) + `order_cat_doc_mix`.`a_s21`) + `order_cat_doc_mix`.`a_s22`) + `order_cat_doc_mix`.`a_s23`) + `order_cat_doc_mix`.`a_s24`) + `order_cat_doc_mix`.`a_s25`) + `order_cat_doc_mix`.`a_s26`) + `order_cat_doc_mix`.`a_s27`) + `order_cat_doc_mix`.`a_s28`) + `order_cat_doc_mix`.`a_s29`) + `order_cat_doc_mix`.`a_s30`) + `order_cat_doc_mix`.`a_s31`) + `order_cat_doc_mix`.`a_s32`) + `order_cat_doc_mix`.`a_s33`) + `order_cat_doc_mix`.`a_s34`) + `order_cat_doc_mix`.`a_s35`) + `order_cat_doc_mix`.`a_s36`) + `order_cat_doc_mix`.`a_s37`) + `order_cat_doc_mix`.`a_s38`) + `order_cat_doc_mix`.`a_s39`) + `order_cat_doc_mix`.`a_s40`) + `order_cat_doc_mix`.`a_s41`) + `order_cat_doc_mix`.`a_s42`) + `order_cat_doc_mix`.`a_s43`) + `order_cat_doc_mix`.`a_s44`) + `order_cat_doc_mix`.`a_s45`) + `order_cat_doc_mix`.`a_s46`) + `order_cat_doc_mix`.`a_s47`) + `order_cat_doc_mix`.`a_s48`) + `order_cat_doc_mix`.`a_s49`) + `order_cat_doc_mix`.`a_s50`) * `order_cat_doc_mix`.`a_plies`) * `fn_know_binding_con`(`maker_stat_log`.`order_tid`))) AS `material_req`,`order_cat_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_doc_mix`.`order_col_des` AS `order_col_des`,`order_cat_doc_mix`.`plan_lot_ref` AS `plan_lot_ref` from ((`order_cat_doc_mix` left join `maker_stat_log` on((`order_cat_doc_mix`.`mk_ref` = `maker_stat_log`.`tid`))) left join `cuttable_stat_log` on((`cuttable_stat_log`.`cat_id` = `order_cat_doc_mix`.`cat_ref`)))) */;

/*View structure for view order_cat_recut_doc_mix */

/*!50001 DROP TABLE IF EXISTS `order_cat_recut_doc_mix` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_recut_doc_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_recut_doc_mix` AS (select `recut_v2`.`date` AS `date`,`recut_v2`.`cat_ref` AS `cat_ref`,`recut_v2`.`cuttable_ref` AS `cuttable_ref`,`recut_v2`.`allocate_ref` AS `allocate_ref`,`recut_v2`.`mk_ref` AS `mk_ref`,`recut_v2`.`order_tid` AS `order_tid`,`recut_v2`.`pcutno` AS `pcutno`,`recut_v2`.`ratio` AS `ratio`,`recut_v2`.`p_xs` AS `p_xs`,`recut_v2`.`p_s` AS `p_s`,`recut_v2`.`p_m` AS `p_m`,`recut_v2`.`p_l` AS `p_l`,`recut_v2`.`p_xl` AS `p_xl`,`recut_v2`.`p_xxl` AS `p_xxl`,`recut_v2`.`p_xxxl` AS `p_xxxl`,`recut_v2`.`p_plies` AS `p_plies`,`recut_v2`.`doc_no` AS `doc_no`,`recut_v2`.`acutno` AS `acutno`,`recut_v2`.`a_xs` AS `a_xs`,`recut_v2`.`a_s` AS `a_s`,`recut_v2`.`a_m` AS `a_m`,`recut_v2`.`a_l` AS `a_l`,`recut_v2`.`a_xl` AS `a_xl`,`recut_v2`.`a_xxl` AS `a_xxl`,`recut_v2`.`a_xxxl` AS `a_xxxl`,`recut_v2`.`a_plies` AS `a_plies`,`recut_v2`.`lastup` AS `lastup`,`recut_v2`.`remarks` AS `remarks`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`act_cut_issue_status` AS `act_cut_issue_status`,`recut_v2`.`pcutdocid` AS `pcutdocid`,`recut_v2`.`print_status` AS `print_status`,`recut_v2`.`a_s01` AS `a_s01`,`recut_v2`.`a_s02` AS `a_s02`,`recut_v2`.`a_s03` AS `a_s03`,`recut_v2`.`a_s04` AS `a_s04`,`recut_v2`.`a_s05` AS `a_s05`,`recut_v2`.`a_s06` AS `a_s06`,`recut_v2`.`a_s07` AS `a_s07`,`recut_v2`.`a_s08` AS `a_s08`,`recut_v2`.`a_s09` AS `a_s09`,`recut_v2`.`a_s10` AS `a_s10`,`recut_v2`.`a_s11` AS `a_s11`,`recut_v2`.`a_s12` AS `a_s12`,`recut_v2`.`a_s13` AS `a_s13`,`recut_v2`.`a_s14` AS `a_s14`,`recut_v2`.`a_s15` AS `a_s15`,`recut_v2`.`a_s16` AS `a_s16`,`recut_v2`.`a_s17` AS `a_s17`,`recut_v2`.`a_s18` AS `a_s18`,`recut_v2`.`a_s19` AS `a_s19`,`recut_v2`.`a_s20` AS `a_s20`,`recut_v2`.`a_s21` AS `a_s21`,`recut_v2`.`a_s22` AS `a_s22`,`recut_v2`.`a_s23` AS `a_s23`,`recut_v2`.`a_s24` AS `a_s24`,`recut_v2`.`a_s25` AS `a_s25`,`recut_v2`.`a_s26` AS `a_s26`,`recut_v2`.`a_s27` AS `a_s27`,`recut_v2`.`a_s28` AS `a_s28`,`recut_v2`.`a_s29` AS `a_s29`,`recut_v2`.`a_s30` AS `a_s30`,`recut_v2`.`a_s31` AS `a_s31`,`recut_v2`.`a_s32` AS `a_s32`,`recut_v2`.`a_s33` AS `a_s33`,`recut_v2`.`a_s34` AS `a_s34`,`recut_v2`.`a_s35` AS `a_s35`,`recut_v2`.`a_s36` AS `a_s36`,`recut_v2`.`a_s37` AS `a_s37`,`recut_v2`.`a_s38` AS `a_s38`,`recut_v2`.`a_s39` AS `a_s39`,`recut_v2`.`a_s40` AS `a_s40`,`recut_v2`.`a_s41` AS `a_s41`,`recut_v2`.`a_s42` AS `a_s42`,`recut_v2`.`a_s43` AS `a_s43`,`recut_v2`.`a_s44` AS `a_s44`,`recut_v2`.`a_s45` AS `a_s45`,`recut_v2`.`a_s46` AS `a_s46`,`recut_v2`.`a_s47` AS `a_s47`,`recut_v2`.`a_s48` AS `a_s48`,`recut_v2`.`a_s49` AS `a_s49`,`recut_v2`.`a_s50` AS `a_s50`,`recut_v2`.`p_s01` AS `p_s01`,`recut_v2`.`p_s02` AS `p_s02`,`recut_v2`.`p_s03` AS `p_s03`,`recut_v2`.`p_s04` AS `p_s04`,`recut_v2`.`p_s05` AS `p_s05`,`recut_v2`.`p_s06` AS `p_s06`,`recut_v2`.`p_s07` AS `p_s07`,`recut_v2`.`p_s08` AS `p_s08`,`recut_v2`.`p_s09` AS `p_s09`,`recut_v2`.`p_s10` AS `p_s10`,`recut_v2`.`p_s11` AS `p_s11`,`recut_v2`.`p_s12` AS `p_s12`,`recut_v2`.`p_s13` AS `p_s13`,`recut_v2`.`p_s14` AS `p_s14`,`recut_v2`.`p_s15` AS `p_s15`,`recut_v2`.`p_s16` AS `p_s16`,`recut_v2`.`p_s17` AS `p_s17`,`recut_v2`.`p_s18` AS `p_s18`,`recut_v2`.`p_s19` AS `p_s19`,`recut_v2`.`p_s20` AS `p_s20`,`recut_v2`.`p_s21` AS `p_s21`,`recut_v2`.`p_s22` AS `p_s22`,`recut_v2`.`p_s23` AS `p_s23`,`recut_v2`.`p_s24` AS `p_s24`,`recut_v2`.`p_s25` AS `p_s25`,`recut_v2`.`p_s26` AS `p_s26`,`recut_v2`.`p_s27` AS `p_s27`,`recut_v2`.`p_s28` AS `p_s28`,`recut_v2`.`p_s29` AS `p_s29`,`recut_v2`.`p_s30` AS `p_s30`,`recut_v2`.`p_s31` AS `p_s31`,`recut_v2`.`p_s32` AS `p_s32`,`recut_v2`.`p_s33` AS `p_s33`,`recut_v2`.`p_s34` AS `p_s34`,`recut_v2`.`p_s35` AS `p_s35`,`recut_v2`.`p_s36` AS `p_s36`,`recut_v2`.`p_s37` AS `p_s37`,`recut_v2`.`p_s38` AS `p_s38`,`recut_v2`.`p_s39` AS `p_s39`,`recut_v2`.`p_s40` AS `p_s40`,`recut_v2`.`p_s41` AS `p_s41`,`recut_v2`.`p_s42` AS `p_s42`,`recut_v2`.`p_s43` AS `p_s43`,`recut_v2`.`p_s44` AS `p_s44`,`recut_v2`.`p_s45` AS `p_s45`,`recut_v2`.`p_s46` AS `p_s46`,`recut_v2`.`p_s47` AS `p_s47`,`recut_v2`.`p_s48` AS `p_s48`,`recut_v2`.`p_s49` AS `p_s49`,`recut_v2`.`p_s50` AS `p_s50`,`recut_v2`.`rm_date` AS `rm_date`,`recut_v2`.`cut_inp_temp` AS `cut_inp_temp`,`recut_v2`.`plan_module` AS `plan_module`,`cat_stat_log`.`category` AS `category`,`bai_orders_db`.`color_code` AS `color_code`,`recut_v2`.`fabric_status` AS `fabric_status`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`recut_v2`.`plan_lot_ref` AS `plan_lot_ref`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_orders_db`.`order_style_no` AS `order_style_no` from ((`recut_v2` left join `cat_stat_log` on((`recut_v2`.`cat_ref` = `cat_stat_log`.`tid`))) left join `bai_orders_db` on((`recut_v2`.`order_tid` = `bai_orders_db`.`order_tid`)))) */;

/*View structure for view order_cat_recut_doc_mk_mix */

/*!50001 DROP TABLE IF EXISTS `order_cat_recut_doc_mk_mix` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_recut_doc_mk_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_recut_doc_mk_mix` AS (select `order_cat_recut_doc_mix`.`date` AS `date`,`order_cat_recut_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_recut_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_recut_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_recut_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_recut_doc_mix`.`order_tid` AS `order_tid`,`order_cat_recut_doc_mix`.`pcutno` AS `pcutno`,`order_cat_recut_doc_mix`.`ratio` AS `ratio`,`order_cat_recut_doc_mix`.`p_xs` AS `p_xs`,`order_cat_recut_doc_mix`.`p_s` AS `p_s`,`order_cat_recut_doc_mix`.`p_m` AS `p_m`,`order_cat_recut_doc_mix`.`p_l` AS `p_l`,`order_cat_recut_doc_mix`.`p_xl` AS `p_xl`,`order_cat_recut_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_recut_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_recut_doc_mix`.`p_plies` AS `p_plies`,`order_cat_recut_doc_mix`.`doc_no` AS `doc_no`,`order_cat_recut_doc_mix`.`acutno` AS `acutno`,`order_cat_recut_doc_mix`.`a_xs` AS `a_xs`,`order_cat_recut_doc_mix`.`a_s` AS `a_s`,`order_cat_recut_doc_mix`.`a_m` AS `a_m`,`order_cat_recut_doc_mix`.`a_l` AS `a_l`,`order_cat_recut_doc_mix`.`a_xl` AS `a_xl`,`order_cat_recut_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_recut_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_recut_doc_mix`.`a_plies` AS `a_plies`,`order_cat_recut_doc_mix`.`lastup` AS `lastup`,`order_cat_recut_doc_mix`.`remarks` AS `remarks`,`order_cat_recut_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_recut_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_recut_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_recut_doc_mix`.`print_status` AS `print_status`,`order_cat_recut_doc_mix`.`a_s01` AS `a_s01`,`order_cat_recut_doc_mix`.`a_s02` AS `a_s02`,`order_cat_recut_doc_mix`.`a_s03` AS `a_s03`,`order_cat_recut_doc_mix`.`a_s04` AS `a_s04`,`order_cat_recut_doc_mix`.`a_s05` AS `a_s05`,`order_cat_recut_doc_mix`.`a_s06` AS `a_s06`,`order_cat_recut_doc_mix`.`a_s07` AS `a_s07`,`order_cat_recut_doc_mix`.`a_s08` AS `a_s08`,`order_cat_recut_doc_mix`.`a_s09` AS `a_s09`,`order_cat_recut_doc_mix`.`a_s10` AS `a_s10`,`order_cat_recut_doc_mix`.`a_s11` AS `a_s11`,`order_cat_recut_doc_mix`.`a_s12` AS `a_s12`,`order_cat_recut_doc_mix`.`a_s13` AS `a_s13`,`order_cat_recut_doc_mix`.`a_s14` AS `a_s14`,`order_cat_recut_doc_mix`.`a_s15` AS `a_s15`,`order_cat_recut_doc_mix`.`a_s16` AS `a_s16`,`order_cat_recut_doc_mix`.`a_s17` AS `a_s17`,`order_cat_recut_doc_mix`.`a_s18` AS `a_s18`,`order_cat_recut_doc_mix`.`a_s19` AS `a_s19`,`order_cat_recut_doc_mix`.`a_s20` AS `a_s20`,`order_cat_recut_doc_mix`.`a_s21` AS `a_s21`,`order_cat_recut_doc_mix`.`a_s22` AS `a_s22`,`order_cat_recut_doc_mix`.`a_s23` AS `a_s23`,`order_cat_recut_doc_mix`.`a_s24` AS `a_s24`,`order_cat_recut_doc_mix`.`a_s25` AS `a_s25`,`order_cat_recut_doc_mix`.`a_s26` AS `a_s26`,`order_cat_recut_doc_mix`.`a_s27` AS `a_s27`,`order_cat_recut_doc_mix`.`a_s28` AS `a_s28`,`order_cat_recut_doc_mix`.`a_s29` AS `a_s29`,`order_cat_recut_doc_mix`.`a_s30` AS `a_s30`,`order_cat_recut_doc_mix`.`a_s31` AS `a_s31`,`order_cat_recut_doc_mix`.`a_s32` AS `a_s32`,`order_cat_recut_doc_mix`.`a_s33` AS `a_s33`,`order_cat_recut_doc_mix`.`a_s34` AS `a_s34`,`order_cat_recut_doc_mix`.`a_s35` AS `a_s35`,`order_cat_recut_doc_mix`.`a_s36` AS `a_s36`,`order_cat_recut_doc_mix`.`a_s37` AS `a_s37`,`order_cat_recut_doc_mix`.`a_s38` AS `a_s38`,`order_cat_recut_doc_mix`.`a_s39` AS `a_s39`,`order_cat_recut_doc_mix`.`a_s40` AS `a_s40`,`order_cat_recut_doc_mix`.`a_s41` AS `a_s41`,`order_cat_recut_doc_mix`.`a_s42` AS `a_s42`,`order_cat_recut_doc_mix`.`a_s43` AS `a_s43`,`order_cat_recut_doc_mix`.`a_s44` AS `a_s44`,`order_cat_recut_doc_mix`.`a_s45` AS `a_s45`,`order_cat_recut_doc_mix`.`a_s46` AS `a_s46`,`order_cat_recut_doc_mix`.`a_s47` AS `a_s47`,`order_cat_recut_doc_mix`.`a_s48` AS `a_s48`,`order_cat_recut_doc_mix`.`a_s49` AS `a_s49`,`order_cat_recut_doc_mix`.`a_s50` AS `a_s50`,`order_cat_recut_doc_mix`.`p_s01` AS `p_s01`,`order_cat_recut_doc_mix`.`p_s02` AS `p_s02`,`order_cat_recut_doc_mix`.`p_s03` AS `p_s03`,`order_cat_recut_doc_mix`.`p_s04` AS `p_s04`,`order_cat_recut_doc_mix`.`p_s05` AS `p_s05`,`order_cat_recut_doc_mix`.`p_s06` AS `p_s06`,`order_cat_recut_doc_mix`.`p_s07` AS `p_s07`,`order_cat_recut_doc_mix`.`p_s08` AS `p_s08`,`order_cat_recut_doc_mix`.`p_s09` AS `p_s09`,`order_cat_recut_doc_mix`.`p_s10` AS `p_s10`,`order_cat_recut_doc_mix`.`p_s11` AS `p_s11`,`order_cat_recut_doc_mix`.`p_s12` AS `p_s12`,`order_cat_recut_doc_mix`.`p_s13` AS `p_s13`,`order_cat_recut_doc_mix`.`p_s14` AS `p_s14`,`order_cat_recut_doc_mix`.`p_s15` AS `p_s15`,`order_cat_recut_doc_mix`.`p_s16` AS `p_s16`,`order_cat_recut_doc_mix`.`p_s17` AS `p_s17`,`order_cat_recut_doc_mix`.`p_s18` AS `p_s18`,`order_cat_recut_doc_mix`.`p_s19` AS `p_s19`,`order_cat_recut_doc_mix`.`p_s20` AS `p_s20`,`order_cat_recut_doc_mix`.`p_s21` AS `p_s21`,`order_cat_recut_doc_mix`.`p_s22` AS `p_s22`,`order_cat_recut_doc_mix`.`p_s23` AS `p_s23`,`order_cat_recut_doc_mix`.`p_s24` AS `p_s24`,`order_cat_recut_doc_mix`.`p_s25` AS `p_s25`,`order_cat_recut_doc_mix`.`p_s26` AS `p_s26`,`order_cat_recut_doc_mix`.`p_s27` AS `p_s27`,`order_cat_recut_doc_mix`.`p_s28` AS `p_s28`,`order_cat_recut_doc_mix`.`p_s29` AS `p_s29`,`order_cat_recut_doc_mix`.`p_s30` AS `p_s30`,`order_cat_recut_doc_mix`.`p_s31` AS `p_s31`,`order_cat_recut_doc_mix`.`p_s32` AS `p_s32`,`order_cat_recut_doc_mix`.`p_s33` AS `p_s33`,`order_cat_recut_doc_mix`.`p_s34` AS `p_s34`,`order_cat_recut_doc_mix`.`p_s35` AS `p_s35`,`order_cat_recut_doc_mix`.`p_s36` AS `p_s36`,`order_cat_recut_doc_mix`.`p_s37` AS `p_s37`,`order_cat_recut_doc_mix`.`p_s38` AS `p_s38`,`order_cat_recut_doc_mix`.`p_s39` AS `p_s39`,`order_cat_recut_doc_mix`.`p_s40` AS `p_s40`,`order_cat_recut_doc_mix`.`p_s41` AS `p_s41`,`order_cat_recut_doc_mix`.`p_s42` AS `p_s42`,`order_cat_recut_doc_mix`.`p_s43` AS `p_s43`,`order_cat_recut_doc_mix`.`p_s44` AS `p_s44`,`order_cat_recut_doc_mix`.`p_s45` AS `p_s45`,`order_cat_recut_doc_mix`.`p_s46` AS `p_s46`,`order_cat_recut_doc_mix`.`p_s47` AS `p_s47`,`order_cat_recut_doc_mix`.`p_s48` AS `p_s48`,`order_cat_recut_doc_mix`.`p_s49` AS `p_s49`,`order_cat_recut_doc_mix`.`p_s50` AS `p_s50`,`order_cat_recut_doc_mix`.`rm_date` AS `rm_date`,`order_cat_recut_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_recut_doc_mix`.`plan_module` AS `plan_module`,`order_cat_recut_doc_mix`.`category` AS `category`,`order_cat_recut_doc_mix`.`color_code` AS `color_code`,`order_cat_recut_doc_mix`.`fabric_status` AS `fabric_status`,if(((`order_cat_recut_doc_mix`.`category` = 'Body') or (`order_cat_recut_doc_mix`.`category` = 'Front')),(round((`order_cat_recut_doc_mix`.`a_plies` * `maker_stat_log`.`mklength`),2) + ((((((((((((((((((((((((((((((((((((((((((((((((((((((((((`order_cat_recut_doc_mix`.`a_xs` + `order_cat_recut_doc_mix`.`a_s`) + `order_cat_recut_doc_mix`.`a_m`) + `order_cat_recut_doc_mix`.`a_l`) + `order_cat_recut_doc_mix`.`a_xl`) + `order_cat_recut_doc_mix`.`a_xxl`) + `order_cat_recut_doc_mix`.`a_xxxl`) + `order_cat_recut_doc_mix`.`a_s01`) + `order_cat_recut_doc_mix`.`a_s02`) + `order_cat_recut_doc_mix`.`a_s03`) + `order_cat_recut_doc_mix`.`a_s04`) + `order_cat_recut_doc_mix`.`a_s05`) + `order_cat_recut_doc_mix`.`a_s06`) + `order_cat_recut_doc_mix`.`a_s07`) + `order_cat_recut_doc_mix`.`a_s08`) + `order_cat_recut_doc_mix`.`a_s09`) + `order_cat_recut_doc_mix`.`a_s10`) + `order_cat_recut_doc_mix`.`a_s11`) + `order_cat_recut_doc_mix`.`a_s12`) + `order_cat_recut_doc_mix`.`a_s13`) + `order_cat_recut_doc_mix`.`a_s14`) + `order_cat_recut_doc_mix`.`a_s15`) + `order_cat_recut_doc_mix`.`a_s16`) + `order_cat_recut_doc_mix`.`a_s17`) + `order_cat_recut_doc_mix`.`a_s18`) + `order_cat_recut_doc_mix`.`a_s19`) + `order_cat_recut_doc_mix`.`a_s20`) + `order_cat_recut_doc_mix`.`a_s21`) + `order_cat_recut_doc_mix`.`a_s22`) + `order_cat_recut_doc_mix`.`a_s23`) + `order_cat_recut_doc_mix`.`a_s24`) + `order_cat_recut_doc_mix`.`a_s25`) + `order_cat_recut_doc_mix`.`a_s26`) + `order_cat_recut_doc_mix`.`a_s27`) + `order_cat_recut_doc_mix`.`a_s28`) + `order_cat_recut_doc_mix`.`a_s29`) + `order_cat_recut_doc_mix`.`a_s30`) + `order_cat_recut_doc_mix`.`a_s31`) + `order_cat_recut_doc_mix`.`a_s32`) + `order_cat_recut_doc_mix`.`a_s33`) + `order_cat_recut_doc_mix`.`a_s34`) + `order_cat_recut_doc_mix`.`a_s35`) + `order_cat_recut_doc_mix`.`a_s36`) + `order_cat_recut_doc_mix`.`a_s37`) + `order_cat_recut_doc_mix`.`a_s38`) + `order_cat_recut_doc_mix`.`a_s39`) + `order_cat_recut_doc_mix`.`a_s40`) + `order_cat_recut_doc_mix`.`a_s41`) + `order_cat_recut_doc_mix`.`a_s42`) + `order_cat_recut_doc_mix`.`a_s43`) + `order_cat_recut_doc_mix`.`a_s44`) + `order_cat_recut_doc_mix`.`a_s45`) + `order_cat_recut_doc_mix`.`a_s46`) + `order_cat_recut_doc_mix`.`a_s47`) + `order_cat_recut_doc_mix`.`a_s48`) + `order_cat_recut_doc_mix`.`a_s49`) + `order_cat_recut_doc_mix`.`a_s50`) * `order_cat_recut_doc_mix`.`a_plies`) * `fn_know_binding_con`(`maker_stat_log`.`order_tid`))),round((`order_cat_recut_doc_mix`.`a_plies` * `maker_stat_log`.`mklength`),2)) AS `material_req`,`order_cat_recut_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_recut_doc_mix`.`plan_lot_ref` AS `plan_lot_ref` from (`order_cat_recut_doc_mix` left join `maker_stat_log` on((`order_cat_recut_doc_mix`.`mk_ref` = `maker_stat_log`.`tid`)))) */;

/*View structure for view pac_stat_log_for_live */

/*!50001 DROP TABLE IF EXISTS `pac_stat_log_for_live` */;
/*!50001 DROP VIEW IF EXISTS `pac_stat_log_for_live` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pac_stat_log_for_live` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,sum(`pac_stat_log`.`carton_act_qty`) AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des` from ((`pac_stat_log` left join `plandoc_stat_log` on((`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`))) left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))) group by `pac_stat_log`.`doc_no_ref`) */;

/*View structure for view pac_stat_log_temp */

/*!50001 DROP TABLE IF EXISTS `pac_stat_log_temp` */;
/*!50001 DROP VIEW IF EXISTS `pac_stat_log_temp` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pac_stat_log_temp` AS (select min(`pac_stat_log`.`tid`) AS `tid`,`pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`carton_no` AS `carton_no`,`pac_stat_log`.`carton_mode` AS `carton_mode`,sum(`pac_stat_log`.`carton_act_qty`) AS `carton_act_qty`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no` from `pac_stat_log` group by `pac_stat_log`.`doc_no_ref`) */;

/*View structure for view pack_to_be_backup */

/*!50001 DROP TABLE IF EXISTS `pack_to_be_backup` */;
/*!50001 DROP VIEW IF EXISTS `pack_to_be_backup` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pack_to_be_backup` AS (select `disp_tb1`.`total` AS `total`,`disp_tb1`.`order_del_no` AS `order_del_no`,`disp_tb1`.`scanned` AS `scanned`,`disp_tb1`.`unscanned` AS `unscanned`,`disp_tb1`.`lable_ids` AS `lable_ids`,`disp_db`.`create_date` AS `create_date`,(((((((((((((((((((`ship_stat_log`.`ship_s_xs` + `ship_stat_log`.`ship_s_s`) + `ship_stat_log`.`ship_s_m`) + `ship_stat_log`.`ship_s_l`) + `ship_stat_log`.`ship_s_xl`) + `ship_stat_log`.`ship_s_xxl`) + `ship_stat_log`.`ship_s_xxxl`) + `ship_stat_log`.`ship_s_s06`) + `ship_stat_log`.`ship_s_s08`) + `ship_stat_log`.`ship_s_s10`) + `ship_stat_log`.`ship_s_s12`) + `ship_stat_log`.`ship_s_s14`) + `ship_stat_log`.`ship_s_s16`) + `ship_stat_log`.`ship_s_s18`) + `ship_stat_log`.`ship_s_s20`) + `ship_stat_log`.`ship_s_s22`) + `ship_stat_log`.`ship_s_s24`) + `ship_stat_log`.`ship_s_s26`) + `ship_stat_log`.`ship_s_s28`) + `ship_stat_log`.`ship_s_s30`) AS `ship_qty` from ((`ship_stat_log` left join `disp_tb1` on((`disp_tb1`.`order_del_no` = `ship_stat_log`.`ship_schedule`))) left join `disp_db` on((`disp_db`.`disp_note_no` = `ship_stat_log`.`disp_note_no`))) where ((`ship_stat_log`.`disp_note_no` is not null) and (`disp_tb1`.`unscanned` = 0) and (`disp_tb1`.`total` = (((((((((((((((((((`ship_stat_log`.`ship_s_xs` + `ship_stat_log`.`ship_s_s`) + `ship_stat_log`.`ship_s_m`) + `ship_stat_log`.`ship_s_l`) + `ship_stat_log`.`ship_s_xl`) + `ship_stat_log`.`ship_s_xxl`) + `ship_stat_log`.`ship_s_xxxl`) + `ship_stat_log`.`ship_s_s06`) + `ship_stat_log`.`ship_s_s08`) + `ship_stat_log`.`ship_s_s10`) + `ship_stat_log`.`ship_s_s12`) + `ship_stat_log`.`ship_s_s14`) + `ship_stat_log`.`ship_s_s16`) + `ship_stat_log`.`ship_s_s18`) + `ship_stat_log`.`ship_s_s20`) + `ship_stat_log`.`ship_s_s22`) + `ship_stat_log`.`ship_s_s24`) + `ship_stat_log`.`ship_s_s26`) + `ship_stat_log`.`ship_s_s28`) + `ship_stat_log`.`ship_s_s30`)))) */;

/*View structure for view packing_dashboard */

/*!50001 DROP TABLE IF EXISTS `packing_dashboard` */;
/*!50001 DROP VIEW IF EXISTS `packing_dashboard` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard` AS (select min(`pac_stat_log_temp`.`tid`) AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,`pac_stat_log_temp`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where ((`pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no`) and (`pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','')) and (`pac_stat_log_temp`.`disp_carton_no` >= 1) and (`ims_log_backup`.`ims_mod_no` <> 0) and isnull(`pac_stat_log_temp`.`status`)) group by `pac_stat_log_temp`.`doc_no_ref`) */;

/*View structure for view packing_dashboard_new */

/*!50001 DROP TABLE IF EXISTS `packing_dashboard_new` */;
/*!50001 DROP VIEW IF EXISTS `packing_dashboard_new` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard_new` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,`ims_log_backup`.`ims_qty` AS `ims_qty`,`ims_log_backup`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty_cumm` from `ims_log_backup` where ((`ims_log_backup`.`ims_mod_no` <> 0) and `ims_log_backup`.`ims_schedule` in (select `packing_pending_schedules`.`order_del_no` AS `order_del_no` from `packing_pending_schedules`)) group by `ims_log_backup`.`ims_schedule`,`ims_log_backup`.`ims_size`) */;

/*View structure for view packing_dashboard_new2 */

/*!50001 DROP TABLE IF EXISTS `packing_dashboard_new2` */;
/*!50001 DROP VIEW IF EXISTS `packing_dashboard_new2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard_new2` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty_cumm` from `ims_log_backup` where ((`ims_log_backup`.`ims_mod_no` <> 0) and `ims_log_backup`.`ims_schedule` in (select `packing_pending_schedules`.`order_del_no` AS `order_del_no` from `packing_pending_schedules`)) group by `ims_log_backup`.`ims_doc_no`,`ims_log_backup`.`ims_size`) */;

/*View structure for view packing_dboard_stage1 */

/*!50001 DROP TABLE IF EXISTS `packing_dboard_stage1` */;
/*!50001 DROP VIEW IF EXISTS `packing_dboard_stage1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dboard_stage1` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,if((`pac_stat_log`.`status` = 'DONE'),`pac_stat_log`.`carton_act_qty`,0) AS `new` from ((`pac_stat_log` left join `plandoc_stat_log` on((`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`))) left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))) */;

/*View structure for view packing_issues */

/*!50001 DROP TABLE IF EXISTS `packing_issues` */;
/*!50001 DROP VIEW IF EXISTS `packing_issues` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_issues` AS (select `pac_stat_log_temp`.`tid` AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,round((sum(`pac_stat_log_temp`.`carton_act_qty`) / count(`ims_log_backup`.`ims_doc_no`)),0) AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`pac_stat_log_temp`.`disp_id` AS `disp_id`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where ((`pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no`) and (`pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','')) and (`ims_log_backup`.`ims_mod_no` <> 0) and isnull(`pac_stat_log_temp`.`status`) and (`pac_stat_log_temp`.`disp_id` = 1)) group by `pac_stat_log_temp`.`doc_no_ref`) */;

/*View structure for view packing_pending_schedules */

/*!50001 DROP TABLE IF EXISTS `packing_pending_schedules` */;
/*!50001 DROP VIEW IF EXISTS `packing_pending_schedules` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_pending_schedules` AS (select distinct `packing_summary`.`order_del_no` AS `order_del_no` from `packing_summary` where ((`packing_summary`.`status` <> 'DONE') or isnull(`packing_summary`.`status`))) */;

/*View structure for view packing_summary */

/*!50001 DROP TABLE IF EXISTS `packing_summary` */;
/*!50001 DROP VIEW IF EXISTS `packing_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno` from ((`pac_stat_log` left join `plandoc_stat_log` on((`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`))) left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))) */;

/*View structure for view packing_summary_backup */

/*!50001 DROP TABLE IF EXISTS `packing_summary_backup` */;
/*!50001 DROP VIEW IF EXISTS `packing_summary_backup` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_backup` AS (select `pac_stat_log_backup`.`doc_no` AS `doc_no`,`pac_stat_log_backup`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_backup`.`tid` AS `tid`,`pac_stat_log_backup`.`size_code` AS `size_code`,`pac_stat_log_backup`.`remarks` AS `remarks`,`pac_stat_log_backup`.`status` AS `status`,`pac_stat_log_backup`.`lastup` AS `lastup`,`pac_stat_log_backup`.`container` AS `container`,`pac_stat_log_backup`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log_backup`.`disp_id` AS `disp_id`,`pac_stat_log_backup`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_backup`.`audit_status` AS `audit_status`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno` from ((`pac_stat_log_backup` left join `plandoc_stat_log` on((`pac_stat_log_backup`.`doc_no` = `plandoc_stat_log`.`doc_no`))) left join `bai_orders_db` on((`bai_orders_db`.`order_tid` = `plandoc_stat_log`.`order_tid`)))) */;

/*View structure for view packing_summary_input */

/*!50001 DROP TABLE IF EXISTS `packing_summary_input` */;
/*!50001 DROP VIEW IF EXISTS `packing_summary_input` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_input` AS (select `bai_orders_db_confirm`.`order_joins` AS `order_joins`,`pac_stat_log_input_job`.`doc_no` AS `doc_no`,`pac_stat_log_input_job`.`input_job_no` AS `input_job_no`,`pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,`pac_stat_log_input_job`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_input_job`.`tid` AS `tid`,`pac_stat_log_input_job`.`size_code` AS `size_code`,`pac_stat_log_input_job`.`status` AS `status`,`pac_stat_log_input_job`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_input_job`.`packing_mode` AS `packing_mode`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`destination` AS `destination`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,`tbl_size_matrix`.`m3_size_code` AS `m3_size_code`,`pac_stat_log_input_job`.`old_size` AS `old_size` from (((`pac_stat_log_input_job` left join `plandoc_stat_log` on((`pac_stat_log_input_job`.`doc_no` = `plandoc_stat_log`.`doc_no`))) left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))) left join `tbl_size_matrix` on((concat(`bai_orders_db_confirm`.`order_div`,`pac_stat_log_input_job`.`size_code`) = concat(`tbl_size_matrix`.`buyer_division`,`tbl_size_matrix`.`sfcs_size_code`))))) */;

/*View structure for view packing_summary_temp */

/*!50001 DROP TABLE IF EXISTS `packing_summary_temp` */;
/*!50001 DROP VIEW IF EXISTS `packing_summary_temp` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_temp` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des` from ((`pac_stat_log` left join `plandoc_stat_log` on((`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`))) left join `bai_orders_db_confirm` on((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))) */;

/*View structure for view plan_dash_doc_summ */

/*!50001 DROP TABLE IF EXISTS `plan_dash_doc_summ` */;
/*!50001 DROP VIEW IF EXISTS `plan_dash_doc_summ` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_doc_summ` AS (select `plan_dash_summ`.`print_status` AS `print_status`,`plan_dash_summ`.`plan_lot_ref` AS `plan_lot_ref`,`plan_dash_summ`.`bundle_location` AS `bundle_location`,`plan_dash_summ`.`fabric_status_new` AS `fabric_status_new`,`plan_dash_summ`.`doc_no` AS `doc_no`,`plan_dash_summ`.`module` AS `module`,`plan_dash_summ`.`priority` AS `priority`,`plan_dash_summ`.`act_cut_issue_status` AS `act_cut_issue_status`,`plan_dash_summ`.`act_cut_status` AS `act_cut_status`,`plan_dash_summ`.`rm_date` AS `rm_date`,`plan_dash_summ`.`cut_inp_temp` AS `cut_inp_temp`,`plan_dash_summ`.`order_tid` AS `order_tid`,`plan_dash_summ`.`fabric_status` AS `fabric_status`,`plan_doc_summ`.`color_code` AS `color_code`,`plan_doc_summ`.`clubbing` AS `clubbing`,`plan_doc_summ`.`order_style_no` AS `order_style_no`,`plan_doc_summ`.`order_col_des` AS `order_col_des`,`plan_doc_summ`.`acutno` AS `acutno`,`plan_doc_summ`.`ft_status` AS `ft_status`,`plan_doc_summ`.`st_status` AS `st_status`,`plan_doc_summ`.`pt_status` AS `pt_status`,`plan_doc_summ`.`trim_status` AS `trim_status`,`plan_dash_summ`.`xs` AS `xs`,`plan_dash_summ`.`s` AS `s`,`plan_dash_summ`.`m` AS `m`,`plan_dash_summ`.`l` AS `l`,`plan_dash_summ`.`xl` AS `xl`,`plan_dash_summ`.`xxl` AS `xxl`,`plan_dash_summ`.`xxxl` AS `xxxl`,`plan_dash_summ`.`s01` AS `s01`,`plan_dash_summ`.`s02` AS `s02`,`plan_dash_summ`.`s03` AS `s03`,`plan_dash_summ`.`s04` AS `s04`,`plan_dash_summ`.`s05` AS `s05`,`plan_dash_summ`.`s06` AS `s06`,`plan_dash_summ`.`s07` AS `s07`,`plan_dash_summ`.`s08` AS `s08`,`plan_dash_summ`.`s09` AS `s09`,`plan_dash_summ`.`s10` AS `s10`,`plan_dash_summ`.`s11` AS `s11`,`plan_dash_summ`.`s12` AS `s12`,`plan_dash_summ`.`s13` AS `s13`,`plan_dash_summ`.`s14` AS `s14`,`plan_dash_summ`.`s15` AS `s15`,`plan_dash_summ`.`s16` AS `s16`,`plan_dash_summ`.`s17` AS `s17`,`plan_dash_summ`.`s18` AS `s18`,`plan_dash_summ`.`s19` AS `s19`,`plan_dash_summ`.`s20` AS `s20`,`plan_dash_summ`.`s21` AS `s21`,`plan_dash_summ`.`s22` AS `s22`,`plan_dash_summ`.`s23` AS `s23`,`plan_dash_summ`.`s24` AS `s24`,`plan_dash_summ`.`s25` AS `s25`,`plan_dash_summ`.`s26` AS `s26`,`plan_dash_summ`.`s27` AS `s27`,`plan_dash_summ`.`s28` AS `s28`,`plan_dash_summ`.`s29` AS `s29`,`plan_dash_summ`.`s30` AS `s30`,`plan_dash_summ`.`s31` AS `s31`,`plan_dash_summ`.`s32` AS `s32`,`plan_dash_summ`.`s33` AS `s33`,`plan_dash_summ`.`s34` AS `s34`,`plan_dash_summ`.`s35` AS `s35`,`plan_dash_summ`.`s36` AS `s36`,`plan_dash_summ`.`s37` AS `s37`,`plan_dash_summ`.`s38` AS `s38`,`plan_dash_summ`.`s39` AS `s39`,`plan_dash_summ`.`s40` AS `s40`,`plan_dash_summ`.`s41` AS `s41`,`plan_dash_summ`.`s42` AS `s42`,`plan_dash_summ`.`s43` AS `s43`,`plan_dash_summ`.`s44` AS `s44`,`plan_dash_summ`.`s45` AS `s45`,`plan_dash_summ`.`s46` AS `s46`,`plan_dash_summ`.`s47` AS `s47`,`plan_dash_summ`.`s48` AS `s48`,`plan_dash_summ`.`s49` AS `s49`,`plan_dash_summ`.`s50` AS `s50`,`plan_dash_summ`.`a_plies` AS `a_plies`,`plan_dash_summ`.`mk_ref` AS `mk_ref`,((((((((((((((((((((((((((((((((((((((((((((((((((((((((`plan_dash_summ`.`xs` + `plan_dash_summ`.`s`) + `plan_dash_summ`.`m`) + `plan_dash_summ`.`l`) + `plan_dash_summ`.`xl`) + `plan_dash_summ`.`xxl`) + `plan_dash_summ`.`xxxl`) + `plan_dash_summ`.`s01`) + `plan_dash_summ`.`s02`) + `plan_dash_summ`.`s03`) + `plan_dash_summ`.`s04`) + `plan_dash_summ`.`s05`) + `plan_dash_summ`.`s06`) + `plan_dash_summ`.`s07`) + `plan_dash_summ`.`s08`) + `plan_dash_summ`.`s09`) + `plan_dash_summ`.`s10`) + `plan_dash_summ`.`s11`) + `plan_dash_summ`.`s12`) + `plan_dash_summ`.`s13`) + `plan_dash_summ`.`s14`) + `plan_dash_summ`.`s15`) + `plan_dash_summ`.`s16`) + `plan_dash_summ`.`s17`) + `plan_dash_summ`.`s18`) + `plan_dash_summ`.`s19`) + `plan_dash_summ`.`s20`) + `plan_dash_summ`.`s21`) + `plan_dash_summ`.`s22`) + `plan_dash_summ`.`s23`) + `plan_dash_summ`.`s24`) + `plan_dash_summ`.`s25`) + `plan_dash_summ`.`s26`) + `plan_dash_summ`.`s27`) + `plan_dash_summ`.`s28`) + `plan_dash_summ`.`s29`) + `plan_dash_summ`.`s30`) + `plan_dash_summ`.`s31`) + `plan_dash_summ`.`s32`) + `plan_dash_summ`.`s33`) + `plan_dash_summ`.`s34`) + `plan_dash_summ`.`s35`) + `plan_dash_summ`.`s36`) + `plan_dash_summ`.`s37`) + `plan_dash_summ`.`s38`) + `plan_dash_summ`.`s39`) + `plan_dash_summ`.`s40`) + `plan_dash_summ`.`s41`) + `plan_dash_summ`.`s42`) + `plan_dash_summ`.`s43`) + `plan_dash_summ`.`s44`) + `plan_dash_summ`.`s45`) + `plan_dash_summ`.`s46`) + `plan_dash_summ`.`s47`) + `plan_dash_summ`.`s48`) + `plan_dash_summ`.`s49`) + `plan_dash_summ`.`s50`) AS `total`,`plan_doc_summ`.`act_movement_status` AS `act_movement_status`,`plan_doc_summ`.`order_del_no` AS `order_del_no`,`plan_dash_summ`.`log_time` AS `log_time`,`plan_doc_summ`.`emb_stat1` AS `emb_stat`,`plan_doc_summ`.`cat_ref` AS `cat_ref` from (`plan_dash_summ` left join `plan_doc_summ` on((`plan_doc_summ`.`doc_no` = `plan_dash_summ`.`doc_no`)))) */;

/*View structure for view plan_dash_doc_summ_input */

/*!50001 DROP TABLE IF EXISTS `plan_dash_doc_summ_input` */;
/*!50001 DROP VIEW IF EXISTS `plan_dash_doc_summ_input` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_doc_summ_input` AS (select `plan_dashboard_input`.`input_job_no_random_ref` AS `input_job_no_random_ref`,`plan_dashboard_input`.`input_module` AS `input_module`,`plan_dashboard_input`.`input_priority` AS `input_priority`,`plan_dashboard_input`.`input_trims_status` AS `input_trims_status`,`plan_dashboard_input`.`input_panel_status` AS `input_panel_status`,`plan_dashboard_input`.`log_time` AS `log_time`,`plan_dashboard_input`.`track_id` AS `track_id`,`plan_doc_summ_input`.`input_job_no` AS `input_job_no`,`plan_doc_summ_input`.`tid` AS `tid`,`plan_doc_summ_input`.`input_job_no_random` AS `input_job_no_random`,`plan_doc_summ_input`.`order_tid` AS `order_tid`,`plan_doc_summ_input`.`doc_no` AS `doc_no`,`plan_doc_summ_input`.`acutno` AS `acutno`,`plan_doc_summ_input`.`act_cut_status` AS `act_cut_status`,`plan_doc_summ_input`.`a_plies` AS `a_plies`,`plan_doc_summ_input`.`p_plies` AS `p_plies`,`plan_doc_summ_input`.`color_code` AS `color_code`,`plan_doc_summ_input`.`order_style_no` AS `order_style_no`,`plan_doc_summ_input`.`order_del_no` AS `order_del_no`,`plan_doc_summ_input`.`order_col_des` AS `order_col_des`,`plan_doc_summ_input`.`order_div` AS `order_div`,`plan_doc_summ_input`.`ft_status` AS `ft_status`,`plan_doc_summ_input`.`st_status` AS `st_status`,`plan_doc_summ_input`.`pt_status` AS `pt_status`,`plan_doc_summ_input`.`trim_status` AS `trim_status`,`plan_doc_summ_input`.`category` AS `category`,`plan_doc_summ_input`.`clubbing` AS `clubbing`,`plan_doc_summ_input`.`plan_module` AS `plan_module`,`plan_doc_summ_input`.`cat_ref` AS `cat_ref`,`plan_doc_summ_input`.`emb_stat1` AS `emb_stat1`,`plan_doc_summ_input`.`carton_act_qty` AS `carton_act_qty` from (`plan_dashboard_input` left join `plan_doc_summ_input` on((`plan_dashboard_input`.`input_job_no_random_ref` = `plan_doc_summ_input`.`input_job_no_random`)))) */;

/*View structure for view plan_dash_summ */

/*!50001 DROP TABLE IF EXISTS `plan_dash_summ` */;
/*!50001 DROP VIEW IF EXISTS `plan_dash_summ` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_summ` AS (select `plan_dashboard`.`doc_no` AS `doc_no`,`plan_dashboard`.`module` AS `module`,`plan_dashboard`.`priority` AS `priority`,`plan_dashboard`.`fabric_status` AS `fabric_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`plandoc_stat_log`.`pcutdocid` AS `bundle_location`,`plandoc_stat_log`.`print_status` AS `print_status`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`rm_date` AS `rm_date`,`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,(`plandoc_stat_log`.`a_xs` * `plandoc_stat_log`.`a_plies`) AS `xs`,(`plandoc_stat_log`.`a_s` * `plandoc_stat_log`.`a_plies`) AS `s`,(`plandoc_stat_log`.`a_m` * `plandoc_stat_log`.`a_plies`) AS `m`,(`plandoc_stat_log`.`a_l` * `plandoc_stat_log`.`a_plies`) AS `l`,(`plandoc_stat_log`.`a_xl` * `plandoc_stat_log`.`a_plies`) AS `xl`,(`plandoc_stat_log`.`a_xxl` * `plandoc_stat_log`.`a_plies`) AS `xxl`,(`plandoc_stat_log`.`a_xxxl` * `plandoc_stat_log`.`a_plies`) AS `xxxl`,(`plandoc_stat_log`.`a_s01` * `plandoc_stat_log`.`a_plies`) AS `s01`,(`plandoc_stat_log`.`a_s02` * `plandoc_stat_log`.`a_plies`) AS `s02`,(`plandoc_stat_log`.`a_s03` * `plandoc_stat_log`.`a_plies`) AS `s03`,(`plandoc_stat_log`.`a_s04` * `plandoc_stat_log`.`a_plies`) AS `s04`,(`plandoc_stat_log`.`a_s05` * `plandoc_stat_log`.`a_plies`) AS `s05`,(`plandoc_stat_log`.`a_s06` * `plandoc_stat_log`.`a_plies`) AS `s06`,(`plandoc_stat_log`.`a_s07` * `plandoc_stat_log`.`a_plies`) AS `s07`,(`plandoc_stat_log`.`a_s08` * `plandoc_stat_log`.`a_plies`) AS `s08`,(`plandoc_stat_log`.`a_s09` * `plandoc_stat_log`.`a_plies`) AS `s09`,(`plandoc_stat_log`.`a_s10` * `plandoc_stat_log`.`a_plies`) AS `s10`,(`plandoc_stat_log`.`a_s11` * `plandoc_stat_log`.`a_plies`) AS `s11`,(`plandoc_stat_log`.`a_s12` * `plandoc_stat_log`.`a_plies`) AS `s12`,(`plandoc_stat_log`.`a_s13` * `plandoc_stat_log`.`a_plies`) AS `s13`,(`plandoc_stat_log`.`a_s14` * `plandoc_stat_log`.`a_plies`) AS `s14`,(`plandoc_stat_log`.`a_s15` * `plandoc_stat_log`.`a_plies`) AS `s15`,(`plandoc_stat_log`.`a_s16` * `plandoc_stat_log`.`a_plies`) AS `s16`,(`plandoc_stat_log`.`a_s17` * `plandoc_stat_log`.`a_plies`) AS `s17`,(`plandoc_stat_log`.`a_s18` * `plandoc_stat_log`.`a_plies`) AS `s18`,(`plandoc_stat_log`.`a_s19` * `plandoc_stat_log`.`a_plies`) AS `s19`,(`plandoc_stat_log`.`a_s20` * `plandoc_stat_log`.`a_plies`) AS `s20`,(`plandoc_stat_log`.`a_s21` * `plandoc_stat_log`.`a_plies`) AS `s21`,(`plandoc_stat_log`.`a_s22` * `plandoc_stat_log`.`a_plies`) AS `s22`,(`plandoc_stat_log`.`a_s23` * `plandoc_stat_log`.`a_plies`) AS `s23`,(`plandoc_stat_log`.`a_s24` * `plandoc_stat_log`.`a_plies`) AS `s24`,(`plandoc_stat_log`.`a_s25` * `plandoc_stat_log`.`a_plies`) AS `s25`,(`plandoc_stat_log`.`a_s26` * `plandoc_stat_log`.`a_plies`) AS `s26`,(`plandoc_stat_log`.`a_s27` * `plandoc_stat_log`.`a_plies`) AS `s27`,(`plandoc_stat_log`.`a_s28` * `plandoc_stat_log`.`a_plies`) AS `s28`,(`plandoc_stat_log`.`a_s29` * `plandoc_stat_log`.`a_plies`) AS `s29`,(`plandoc_stat_log`.`a_s30` * `plandoc_stat_log`.`a_plies`) AS `s30`,(`plandoc_stat_log`.`a_s31` * `plandoc_stat_log`.`a_plies`) AS `s31`,(`plandoc_stat_log`.`a_s32` * `plandoc_stat_log`.`a_plies`) AS `s32`,(`plandoc_stat_log`.`a_s33` * `plandoc_stat_log`.`a_plies`) AS `s33`,(`plandoc_stat_log`.`a_s34` * `plandoc_stat_log`.`a_plies`) AS `s34`,(`plandoc_stat_log`.`a_s35` * `plandoc_stat_log`.`a_plies`) AS `s35`,(`plandoc_stat_log`.`a_s36` * `plandoc_stat_log`.`a_plies`) AS `s36`,(`plandoc_stat_log`.`a_s37` * `plandoc_stat_log`.`a_plies`) AS `s37`,(`plandoc_stat_log`.`a_s38` * `plandoc_stat_log`.`a_plies`) AS `s38`,(`plandoc_stat_log`.`a_s39` * `plandoc_stat_log`.`a_plies`) AS `s39`,(`plandoc_stat_log`.`a_s40` * `plandoc_stat_log`.`a_plies`) AS `s40`,(`plandoc_stat_log`.`a_s41` * `plandoc_stat_log`.`a_plies`) AS `s41`,(`plandoc_stat_log`.`a_s42` * `plandoc_stat_log`.`a_plies`) AS `s42`,(`plandoc_stat_log`.`a_s43` * `plandoc_stat_log`.`a_plies`) AS `s43`,(`plandoc_stat_log`.`a_s44` * `plandoc_stat_log`.`a_plies`) AS `s44`,(`plandoc_stat_log`.`a_s45` * `plandoc_stat_log`.`a_plies`) AS `s45`,(`plandoc_stat_log`.`a_s46` * `plandoc_stat_log`.`a_plies`) AS `s46`,(`plandoc_stat_log`.`a_s47` * `plandoc_stat_log`.`a_plies`) AS `s47`,(`plandoc_stat_log`.`a_s48` * `plandoc_stat_log`.`a_plies`) AS `s48`,(`plandoc_stat_log`.`a_s49` * `plandoc_stat_log`.`a_plies`) AS `s49`,(`plandoc_stat_log`.`a_s50` * `plandoc_stat_log`.`a_plies`) AS `s50`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`plan_dashboard`.`log_time` AS `log_time` from (`plan_dashboard` left join `plandoc_stat_log` on((`plan_dashboard`.`doc_no` = `plandoc_stat_log`.`doc_no`))) where (`plandoc_stat_log`.`order_tid` is not null) order by `plan_dashboard`.`priority`) */;

/*View structure for view plan_doc_summ */

/*!50001 DROP TABLE IF EXISTS `plan_doc_summ` */;
/*!50001 DROP VIEW IF EXISTS `plan_doc_summ` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`act_movement_status` AS `act_movement_status`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,(if(((`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b`) > 0),1,0) + if(((`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f`) > 0),2,0)) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where ((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`) and (`cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref`) and (`cat_stat_log`.`category` in ('Body','Front')) and (`plandoc_stat_log`.`date` > '2010-08-01') and ((`plandoc_stat_log`.`act_cut_issue_status` = '') or (`plandoc_stat_log`.`a_plies` <> `plandoc_stat_log`.`p_plies`) or isnull(`plandoc_stat_log`.`plan_module`))) order by `bai_orders_db_confirm`.`order_style_no`) */;

/*View structure for view plan_doc_summ_in_ref */

/*!50001 DROP TABLE IF EXISTS `plan_doc_summ_in_ref` */;
/*!50001 DROP VIEW IF EXISTS `plan_doc_summ_in_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ_in_ref` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`order_div` AS `order_div`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,(if(((`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b`) > 0),1,0) + if(((`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f`) > 0),2,0)) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where ((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`) and (`cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref`) and (`cat_stat_log`.`category` in ('Body','Front')) and (`plandoc_stat_log`.`date` > '2017-02-01')) order by `bai_orders_db_confirm`.`order_style_no`) */;

/*View structure for view plan_doc_summ_input */

/*!50001 DROP TABLE IF EXISTS `plan_doc_summ_input` */;
/*!50001 DROP VIEW IF EXISTS `plan_doc_summ_input` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ_input` AS (select `pac_stat_log_input_job`.`input_job_no` AS `input_job_no`,`pac_stat_log_input_job`.`tid` AS `tid`,`pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,`pac_stat_log_input_job`.`size_code` AS `size_code`,`plan_doc_summ_in_ref`.`order_tid` AS `order_tid`,`plan_doc_summ_in_ref`.`doc_no` AS `doc_no`,`plan_doc_summ_in_ref`.`acutno` AS `acutno`,if((length(`plan_doc_summ_in_ref`.`act_cut_status`) = 0),'',`plan_doc_summ_in_ref`.`act_cut_status`) AS `act_cut_status`,if((length(`plan_doc_summ_in_ref`.`act_cut_issue_status`) = 0),'',`plan_doc_summ_in_ref`.`act_cut_issue_status`) AS `act_cut_issue_status`,`plan_doc_summ_in_ref`.`a_plies` AS `a_plies`,`plan_doc_summ_in_ref`.`p_plies` AS `p_plies`,`plan_doc_summ_in_ref`.`color_code` AS `color_code`,`plan_doc_summ_in_ref`.`order_style_no` AS `order_style_no`,`plan_doc_summ_in_ref`.`order_del_no` AS `order_del_no`,`plan_doc_summ_in_ref`.`order_col_des` AS `order_col_des`,`plan_doc_summ_in_ref`.`order_div` AS `order_div`,`plan_doc_summ_in_ref`.`ft_status` AS `ft_status`,`plan_doc_summ_in_ref`.`st_status` AS `st_status`,`plan_doc_summ_in_ref`.`pt_status` AS `pt_status`,`plan_doc_summ_in_ref`.`trim_status` AS `trim_status`,`plan_doc_summ_in_ref`.`category` AS `category`,`plan_doc_summ_in_ref`.`clubbing` AS `clubbing`,`plan_doc_summ_in_ref`.`plan_module` AS `plan_module`,`plan_doc_summ_in_ref`.`cat_ref` AS `cat_ref`,`plan_doc_summ_in_ref`.`emb_stat1` AS `emb_stat1`,sum(`pac_stat_log_input_job`.`carton_act_qty`) AS `carton_act_qty` from (`pac_stat_log_input_job` left join `plan_doc_summ_in_ref` on((`pac_stat_log_input_job`.`doc_no` = `plan_doc_summ_in_ref`.`doc_no`))) where ((`plan_doc_summ_in_ref`.`order_tid` is not null) and (`pac_stat_log_input_job`.`input_job_no` is not null) and (length(`pac_stat_log_input_job`.`input_job_no_random`) > 0)) group by `plan_doc_summ_in_ref`.`order_del_no`,`pac_stat_log_input_job`.`doc_no`,`pac_stat_log_input_job`.`input_job_no`,`pac_stat_log_input_job`.`input_job_no_random`) */;

/*View structure for view plandoc_stat_log_cat_log_ref */

/*!50001 DROP TABLE IF EXISTS `plandoc_stat_log_cat_log_ref` */;
/*!50001 DROP VIEW IF EXISTS `plandoc_stat_log_cat_log_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plandoc_stat_log_cat_log_ref` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`log_update` AS `log_update`,`bai_orders_db`.`color_code` AS `color_code`,`bai_orders_db`.`order_div` AS `order_div`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_orders_db`.`ft_status` AS `ft_status`,`bai_orders_db`.`st_status` AS `st_status`,`bai_orders_db`.`pt_status` AS `pt_status`,`bai_orders_db`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,(((((((((((((((((((((((((((((((((((((((((((((((((((((((((`plandoc_stat_log`.`a_xs` + `plandoc_stat_log`.`a_s`) + `plandoc_stat_log`.`a_m`) + `plandoc_stat_log`.`a_l`) + `plandoc_stat_log`.`a_xl`) + `plandoc_stat_log`.`a_xxl`) + `plandoc_stat_log`.`a_xxxl`) + `plandoc_stat_log`.`a_s01`) + `plandoc_stat_log`.`a_s02`) + `plandoc_stat_log`.`a_s03`) + `plandoc_stat_log`.`a_s04`) + `plandoc_stat_log`.`a_s05`) + `plandoc_stat_log`.`a_s06`) + `plandoc_stat_log`.`a_s07`) + `plandoc_stat_log`.`a_s08`) + `plandoc_stat_log`.`a_s09`) + `plandoc_stat_log`.`a_s10`) + `plandoc_stat_log`.`a_s11`) + `plandoc_stat_log`.`a_s12`) + `plandoc_stat_log`.`a_s13`) + `plandoc_stat_log`.`a_s14`) + `plandoc_stat_log`.`a_s15`) + `plandoc_stat_log`.`a_s16`) + `plandoc_stat_log`.`a_s17`) + `plandoc_stat_log`.`a_s18`) + `plandoc_stat_log`.`a_s19`) + `plandoc_stat_log`.`a_s20`) + `plandoc_stat_log`.`a_s21`) + `plandoc_stat_log`.`a_s22`) + `plandoc_stat_log`.`a_s23`) + `plandoc_stat_log`.`a_s24`) + `plandoc_stat_log`.`a_s25`) + `plandoc_stat_log`.`a_s26`) + `plandoc_stat_log`.`a_s27`) + `plandoc_stat_log`.`a_s28`) + `plandoc_stat_log`.`a_s29`) + `plandoc_stat_log`.`a_s30`) + `plandoc_stat_log`.`a_s31`) + `plandoc_stat_log`.`a_s32`) + `plandoc_stat_log`.`a_s33`) + `plandoc_stat_log`.`a_s34`) + `plandoc_stat_log`.`a_s35`) + `plandoc_stat_log`.`a_s36`) + `plandoc_stat_log`.`a_s37`) + `plandoc_stat_log`.`a_s38`) + `plandoc_stat_log`.`a_s39`) + `plandoc_stat_log`.`a_s40`) + `plandoc_stat_log`.`a_s41`) + `plandoc_stat_log`.`a_s42`) + `plandoc_stat_log`.`a_s43`) + `plandoc_stat_log`.`a_s44`) + `plandoc_stat_log`.`a_s45`) + `plandoc_stat_log`.`a_s46`) + `plandoc_stat_log`.`a_s47`) + `plandoc_stat_log`.`a_s48`) + `plandoc_stat_log`.`a_s49`) + `plandoc_stat_log`.`a_s50`) * `plandoc_stat_log`.`a_plies`) AS `doc_total` from ((`plandoc_stat_log` join `bai_orders_db`) join `cat_stat_log`) where ((`bai_orders_db`.`order_tid` = `plandoc_stat_log`.`order_tid`) and (`cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref`) and (`cat_stat_log`.`category` in ('Body','Front')) and (`plandoc_stat_log`.`date` > '2010-08-01')) order by `bai_orders_db`.`order_style_no`) */;

/*View structure for view qms_vs_recut */

/*!50001 DROP TABLE IF EXISTS `qms_vs_recut` */;
/*!50001 DROP VIEW IF EXISTS `qms_vs_recut` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `qms_vs_recut` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,min(`bai_qms_db`.`log_date`) AS `log_date`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,sum(if((`bai_qms_db`.`qms_tran_type` = 6),`bai_qms_db`.`qms_qty`,0)) AS `raised`,sum(if((`bai_qms_db`.`qms_tran_type` = 9),`bai_qms_db`.`qms_qty`,0)) AS `actual`,`bai_qms_db`.`ref1` AS `ref1`,`bai_qms_db`.`qms_size` AS `qms_size`,substring_index(`bai_qms_db`.`remarks`,'-',1) AS `module`,substring_index(`bai_qms_db`.`remarks`,'-',-(1)) AS `doc_no`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`plan_module` AS `plan_module`,`recut_v2`.`fabric_status` AS `fabric_status` from (`bai_qms_db` left join `recut_v2` on((substring_index(`bai_qms_db`.`remarks`,'-',-(1)) = `recut_v2`.`doc_no`))) where ((`bai_qms_db`.`qms_tran_type` in (6,9)) and (`bai_qms_db`.`log_date` > '2011-09-01')) group by `bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`remarks`,`bai_qms_db`.`qms_size`) */;

/*View structure for view recut_v2_summary */

/*!50001 DROP TABLE IF EXISTS `recut_v2_summary` */;
/*!50001 DROP VIEW IF EXISTS `recut_v2_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `recut_v2_summary` AS (select `recut_v2`.`date` AS `date`,`recut_v2`.`cat_ref` AS `cat_ref`,`recut_v2`.`cuttable_ref` AS `cuttable_ref`,`recut_v2`.`allocate_ref` AS `allocate_ref`,`recut_v2`.`mk_ref` AS `mk_ref`,`recut_v2`.`order_tid` AS `order_tid`,`recut_v2`.`pcutno` AS `pcutno`,`recut_v2`.`ratio` AS `ratio`,`recut_v2`.`p_xs` AS `p_xs`,`recut_v2`.`p_s` AS `p_s`,`recut_v2`.`p_m` AS `p_m`,`recut_v2`.`p_l` AS `p_l`,`recut_v2`.`p_xl` AS `p_xl`,`recut_v2`.`p_xxl` AS `p_xxl`,`recut_v2`.`p_xxxl` AS `p_xxxl`,`recut_v2`.`p_plies` AS `p_plies`,`recut_v2`.`doc_no` AS `doc_no`,`recut_v2`.`acutno` AS `acutno`,`recut_v2`.`a_xs` AS `a_xs`,`recut_v2`.`a_s` AS `a_s`,`recut_v2`.`a_m` AS `a_m`,`recut_v2`.`a_l` AS `a_l`,`recut_v2`.`a_xl` AS `a_xl`,`recut_v2`.`a_xxl` AS `a_xxl`,`recut_v2`.`a_xxxl` AS `a_xxxl`,`recut_v2`.`a_plies` AS `a_plies`,`recut_v2`.`lastup` AS `lastup`,`recut_v2`.`remarks` AS `remarks`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`act_cut_issue_status` AS `act_cut_issue_status`,`recut_v2`.`pcutdocid` AS `pcutdocid`,`recut_v2`.`print_status` AS `print_status`,`recut_v2`.`a_s01` AS `a_s01`,`recut_v2`.`a_s02` AS `a_s02`,`recut_v2`.`a_s03` AS `a_s03`,`recut_v2`.`a_s04` AS `a_s04`,`recut_v2`.`a_s05` AS `a_s05`,`recut_v2`.`a_s06` AS `a_s06`,`recut_v2`.`a_s07` AS `a_s07`,`recut_v2`.`a_s08` AS `a_s08`,`recut_v2`.`a_s09` AS `a_s09`,`recut_v2`.`a_s10` AS `a_s10`,`recut_v2`.`a_s11` AS `a_s11`,`recut_v2`.`a_s12` AS `a_s12`,`recut_v2`.`a_s13` AS `a_s13`,`recut_v2`.`a_s14` AS `a_s14`,`recut_v2`.`a_s15` AS `a_s15`,`recut_v2`.`a_s16` AS `a_s16`,`recut_v2`.`a_s17` AS `a_s17`,`recut_v2`.`a_s18` AS `a_s18`,`recut_v2`.`a_s19` AS `a_s19`,`recut_v2`.`a_s20` AS `a_s20`,`recut_v2`.`a_s21` AS `a_s21`,`recut_v2`.`a_s22` AS `a_s22`,`recut_v2`.`a_s23` AS `a_s23`,`recut_v2`.`a_s24` AS `a_s24`,`recut_v2`.`a_s25` AS `a_s25`,`recut_v2`.`a_s26` AS `a_s26`,`recut_v2`.`a_s27` AS `a_s27`,`recut_v2`.`a_s28` AS `a_s28`,`recut_v2`.`a_s29` AS `a_s29`,`recut_v2`.`a_s30` AS `a_s30`,`recut_v2`.`a_s31` AS `a_s31`,`recut_v2`.`a_s32` AS `a_s32`,`recut_v2`.`a_s33` AS `a_s33`,`recut_v2`.`a_s34` AS `a_s34`,`recut_v2`.`a_s35` AS `a_s35`,`recut_v2`.`a_s36` AS `a_s36`,`recut_v2`.`a_s37` AS `a_s37`,`recut_v2`.`a_s38` AS `a_s38`,`recut_v2`.`a_s39` AS `a_s39`,`recut_v2`.`a_s40` AS `a_s40`,`recut_v2`.`a_s41` AS `a_s41`,`recut_v2`.`a_s42` AS `a_s42`,`recut_v2`.`a_s43` AS `a_s43`,`recut_v2`.`a_s44` AS `a_s44`,`recut_v2`.`a_s45` AS `a_s45`,`recut_v2`.`a_s46` AS `a_s46`,`recut_v2`.`a_s47` AS `a_s47`,`recut_v2`.`a_s48` AS `a_s48`,`recut_v2`.`a_s49` AS `a_s49`,`recut_v2`.`a_s50` AS `a_s50`,`recut_v2`.`p_s01` AS `p_s01`,`recut_v2`.`p_s02` AS `p_s02`,`recut_v2`.`p_s03` AS `p_s03`,`recut_v2`.`p_s04` AS `p_s04`,`recut_v2`.`p_s05` AS `p_s05`,`recut_v2`.`p_s06` AS `p_s06`,`recut_v2`.`p_s07` AS `p_s07`,`recut_v2`.`p_s08` AS `p_s08`,`recut_v2`.`p_s09` AS `p_s09`,`recut_v2`.`p_s10` AS `p_s10`,`recut_v2`.`p_s11` AS `p_s11`,`recut_v2`.`p_s12` AS `p_s12`,`recut_v2`.`p_s13` AS `p_s13`,`recut_v2`.`p_s14` AS `p_s14`,`recut_v2`.`p_s15` AS `p_s15`,`recut_v2`.`p_s16` AS `p_s16`,`recut_v2`.`p_s17` AS `p_s17`,`recut_v2`.`p_s18` AS `p_s18`,`recut_v2`.`p_s19` AS `p_s19`,`recut_v2`.`p_s20` AS `p_s20`,`recut_v2`.`p_s21` AS `p_s21`,`recut_v2`.`p_s22` AS `p_s22`,`recut_v2`.`p_s23` AS `p_s23`,`recut_v2`.`p_s24` AS `p_s24`,`recut_v2`.`p_s25` AS `p_s25`,`recut_v2`.`p_s26` AS `p_s26`,`recut_v2`.`p_s27` AS `p_s27`,`recut_v2`.`p_s28` AS `p_s28`,`recut_v2`.`p_s29` AS `p_s29`,`recut_v2`.`p_s30` AS `p_s30`,`recut_v2`.`p_s31` AS `p_s31`,`recut_v2`.`p_s32` AS `p_s32`,`recut_v2`.`p_s33` AS `p_s33`,`recut_v2`.`p_s34` AS `p_s34`,`recut_v2`.`p_s35` AS `p_s35`,`recut_v2`.`p_s36` AS `p_s36`,`recut_v2`.`p_s37` AS `p_s37`,`recut_v2`.`p_s38` AS `p_s38`,`recut_v2`.`p_s39` AS `p_s39`,`recut_v2`.`p_s40` AS `p_s40`,`recut_v2`.`p_s41` AS `p_s41`,`recut_v2`.`p_s42` AS `p_s42`,`recut_v2`.`p_s43` AS `p_s43`,`recut_v2`.`p_s44` AS `p_s44`,`recut_v2`.`p_s45` AS `p_s45`,`recut_v2`.`p_s46` AS `p_s46`,`recut_v2`.`p_s47` AS `p_s47`,`recut_v2`.`p_s48` AS `p_s48`,`recut_v2`.`p_s49` AS `p_s49`,`recut_v2`.`p_s50` AS `p_s50`,`recut_v2`.`rm_date` AS `rm_date`,`recut_v2`.`cut_inp_temp` AS `cut_inp_temp`,`recut_v2`.`plan_module` AS `plan_module`,`recut_v2`.`fabric_status` AS `fabric_status`,`recut_v2`.`plan_lot_ref` AS `plan_lot_ref`,(((((((((((((((((((((((((((((((((((((((((((((((((((((((((`recut_v2`.`a_xs` + `recut_v2`.`a_s`) + `recut_v2`.`a_m`) + `recut_v2`.`a_l`) + `recut_v2`.`a_xl`) + `recut_v2`.`a_xxl`) + `recut_v2`.`a_xxxl`) + `recut_v2`.`a_s01`) + `recut_v2`.`a_s02`) + `recut_v2`.`a_s03`) + `recut_v2`.`a_s04`) + `recut_v2`.`a_s05`) + `recut_v2`.`a_s06`) + `recut_v2`.`a_s07`) + `recut_v2`.`a_s08`) + `recut_v2`.`a_s09`) + `recut_v2`.`a_s10`) + `recut_v2`.`a_s11`) + `recut_v2`.`a_s12`) + `recut_v2`.`a_s13`) + `recut_v2`.`a_s14`) + `recut_v2`.`a_s15`) + `recut_v2`.`a_s16`) + `recut_v2`.`a_s17`) + `recut_v2`.`a_s18`) + `recut_v2`.`a_s19`) + `recut_v2`.`a_s20`) + `recut_v2`.`a_s21`) + `recut_v2`.`a_s22`) + `recut_v2`.`a_s23`) + `recut_v2`.`a_s24`) + `recut_v2`.`a_s25`) + `recut_v2`.`a_s26`) + `recut_v2`.`a_s27`) + `recut_v2`.`a_s28`) + `recut_v2`.`a_s29`) + `recut_v2`.`a_s30`) + `recut_v2`.`a_s31`) + `recut_v2`.`a_s32`) + `recut_v2`.`a_s33`) + `recut_v2`.`a_s34`) + `recut_v2`.`a_s35`) + `recut_v2`.`a_s36`) + `recut_v2`.`a_s37`) + `recut_v2`.`a_s38`) + `recut_v2`.`a_s39`) + `recut_v2`.`a_s40`) + `recut_v2`.`a_s41`) + `recut_v2`.`a_s42`) + `recut_v2`.`a_s43`) + `recut_v2`.`a_s44`) + `recut_v2`.`a_s45`) + `recut_v2`.`a_s46`) + `recut_v2`.`a_s47`) + `recut_v2`.`a_s48`) + `recut_v2`.`a_s49`) + `recut_v2`.`a_s50`) * `recut_v2`.`a_plies`) AS `actual_cut_qty`,((((((((((((((((((((((((((((((((((((((((((((((((((((((((`recut_v2`.`p_xs` + `recut_v2`.`p_s`) + `recut_v2`.`p_m`) + `recut_v2`.`p_l`) + `recut_v2`.`p_xl`) + `recut_v2`.`p_xxl`) + `recut_v2`.`p_xxxl`) + `recut_v2`.`p_s01`) + `recut_v2`.`p_s02`) + `recut_v2`.`p_s03`) + `recut_v2`.`p_s04`) + `recut_v2`.`p_s05`) + `recut_v2`.`p_s06`) + `recut_v2`.`p_s07`) + `recut_v2`.`p_s08`) + `recut_v2`.`p_s09`) + `recut_v2`.`p_s10`) + `recut_v2`.`p_s11`) + `recut_v2`.`p_s12`) + `recut_v2`.`p_s13`) + `recut_v2`.`p_s14`) + `recut_v2`.`p_s15`) + `recut_v2`.`p_s16`) + `recut_v2`.`p_s17`) + `recut_v2`.`p_s18`) + `recut_v2`.`p_s19`) + `recut_v2`.`p_s20`) + `recut_v2`.`p_s21`) + `recut_v2`.`p_s22`) + `recut_v2`.`p_s23`) + `recut_v2`.`p_s24`) + `recut_v2`.`p_s25`) + `recut_v2`.`p_s26`) + `recut_v2`.`p_s27`) + `recut_v2`.`p_s28`) + `recut_v2`.`p_s29`) + `recut_v2`.`p_s30`) + `recut_v2`.`p_s31`) + `recut_v2`.`p_s32`) + `recut_v2`.`p_s33`) + `recut_v2`.`p_s34`) + `recut_v2`.`p_s35`) + `recut_v2`.`p_s36`) + `recut_v2`.`p_s37`) + `recut_v2`.`p_s38`) + `recut_v2`.`p_s39`) + `recut_v2`.`p_s40`) + `recut_v2`.`p_s41`) + `recut_v2`.`p_s42`) + `recut_v2`.`p_s43`) + `recut_v2`.`p_s44`) + `recut_v2`.`p_s45`) + `recut_v2`.`p_s46`) + `recut_v2`.`p_s47`) + `recut_v2`.`p_s48`) + `recut_v2`.`p_s49`) + `recut_v2`.`p_s50`) AS `actual_req_qty` from `recut_v2` where ((`recut_v2`.`act_cut_status` = 'DONE') and (`recut_v2`.`remarks` in ('Body','Front')))) */;

/*View structure for view test_plan_doc_summ */

/*!50001 DROP TABLE IF EXISTS `test_plan_doc_summ` */;
/*!50001 DROP VIEW IF EXISTS `test_plan_doc_summ` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `test_plan_doc_summ` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`act_movement_status` AS `act_movement_status`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,(if(((`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b`) > 0),1,0) + if(((`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f`) > 0),2,0)) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where ((`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`) and (`cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref`) and (`cat_stat_log`.`category` in ('Body','Front')) and (`plandoc_stat_log`.`date` > '2010-08-01') and (((`plandoc_stat_log`.`act_cut_issue_status` = '') and ((`plandoc_stat_log`.`act_movement_status` = 'DONE') or (`plandoc_stat_log`.`act_movement_status` = ''))) or (`plandoc_stat_log`.`a_plies` <> `plandoc_stat_log`.`p_plies`) or isnull(`plandoc_stat_log`.`plan_module`))) order by `bai_orders_db_confirm`.`order_style_no`) */;

/*View structure for view zero_module_trans */

/*!50001 DROP TABLE IF EXISTS `zero_module_trans` */;
/*!50001 DROP VIEW IF EXISTS `zero_module_trans` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `zero_module_trans` AS (select sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,replace(`ims_log_backup`.`ims_size`,'a_','') AS `size` from `ims_log_backup` where ((`ims_log_backup`.`ims_mod_no` = 0) and (`ims_log_backup`.`ims_date` > '2013-12-01')) group by concat(`ims_log_backup`.`ims_style`,`ims_log_backup`.`ims_schedule`,`ims_log_backup`.`ims_color`,`ims_log_backup`.`ims_size`)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
