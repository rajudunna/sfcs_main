/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - m3_bulk_ops_rep_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`m3_bulk_ops_rep_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `m3_bulk_ops_rep_db`;

/*Table structure for table `file_process_log` */

DROP TABLE IF EXISTS `file_process_log`;

CREATE TABLE `file_process_log` (
  `file_tran_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'File Transaction ID',
  `file_process_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Time Stamp',
  `file_name` varchar(300) NOT NULL COMMENT 'File Name',
  `file_folder_name` varchar(300) NOT NULL COMMENT 'Folder Name of the files',
  PRIMARY KEY (`file_tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `m3_sfcs_mrn_log` */

DROP TABLE IF EXISTS `m3_sfcs_mrn_log`;

CREATE TABLE `m3_sfcs_mrn_log` (
  `mrn_tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sfcs_style` varchar(300) DEFAULT NULL,
  `sfcs_schedule` varchar(300) DEFAULT NULL,
  `minord_no` float(11,2) DEFAULT NULL,
  `inserted_time` datetime DEFAULT NULL,
  `mrn_update_status` int(11) DEFAULT 0,
  `updated_time` datetime DEFAULT NULL,
  `customer_order` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`mrn_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `m3_sfcs_tran_log` */

DROP TABLE IF EXISTS `m3_sfcs_tran_log`;

CREATE TABLE `m3_sfcs_tran_log` (
  `sfcs_tid` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Transaction ID',
  `sfcs_date` date NOT NULL COMMENT 'Reporting Date',
  `sfcs_style` varchar(300) NOT NULL COMMENT 'style',
  `sfcs_schedule` varchar(300) NOT NULL COMMENT 'Schedule',
  `sfcs_color` varchar(300) NOT NULL COMMENT 'Color',
  `sfcs_size` varchar(10) NOT NULL COMMENT 'SFCS Size',
  `m3_size` varchar(10) NOT NULL COMMENT 'M3 relevant Size Code',
  `sfcs_doc_no` bigint(20) NOT NULL COMMENT 'SFCS Docket Reference NO',
  `sfcs_qty` int(11) NOT NULL COMMENT 'Positive/Negative Qty',
  `sfcs_reason` varchar(3) NOT NULL COMMENT 'Rejection/Scrap Reason Code',
  `sfcs_remarks` varchar(250) NOT NULL COMMENT 'Remarks',
  `sfcs_log_user` varchar(50) NOT NULL COMMENT 'Log User',
  `sfcs_log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Auto Time Stamp',
  `sfcs_status` tinyint(4) NOT NULL COMMENT '0-Created, 10-Validated, 15-Confirmed, 16-Reconfirmed, 20-M3 Log Created,  30- Success, 40-Failed, 50-Manually Updated, 60-Success Archived, 70-Failed Archived, 90-Ignored',
  `m3_mo_no` varchar(100) NOT NULL COMMENT 'MO Number',
  `m3_op_code` varchar(50) NOT NULL COMMENT 'Operation Code (10,15)',
  `sfcs_job_no` varchar(50) NOT NULL COMMENT 'SFCS Job',
  `sfcs_mod_no` varchar(10) NOT NULL COMMENT 'SFCS Module',
  `sfcs_shift` varchar(10) NOT NULL COMMENT 'SFCS Shift',
  `m3_op_des` varchar(250) NOT NULL COMMENT 'M3 Operation Desc (AINLAY)',
  `sfcs_tid_ref` varchar(30) NOT NULL COMMENT 'Transaction ID Ref.',
  `work_centre` varchar(50) NOT NULL,
  `m3_error_code` varchar(255) NOT NULL COMMENT 'Error Code Description',
  PRIMARY KEY (`sfcs_tid`),
  KEY `primary_index` (`sfcs_status`,`m3_op_des`)
) ENGINE=InnoDB AUTO_INCREMENT=89034 DEFAULT CHARSET=latin1;

/*Table structure for table `m3_sfcs_tran_log_backup` */

DROP TABLE IF EXISTS `m3_sfcs_tran_log_backup`;

CREATE TABLE `m3_sfcs_tran_log_backup` (
  `sfcs_tid` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Transaction ID',
  `sfcs_date` date NOT NULL COMMENT 'Reporting Date',
  `sfcs_style` varchar(300) NOT NULL COMMENT 'style',
  `sfcs_schedule` varchar(300) NOT NULL COMMENT 'Schedule',
  `sfcs_color` varchar(300) NOT NULL COMMENT 'Color',
  `sfcs_size` varchar(10) NOT NULL COMMENT 'SFCS Size',
  `m3_size` varchar(10) NOT NULL COMMENT 'M3 relevant Size Code',
  `sfcs_doc_no` bigint(20) NOT NULL COMMENT 'SFCS Docket Reference NO',
  `sfcs_qty` int(11) NOT NULL COMMENT 'Positive/Negative Qty',
  `sfcs_reason` varchar(3) NOT NULL COMMENT 'Rejection/Scrap Reason Code',
  `sfcs_remarks` varchar(250) NOT NULL COMMENT 'Remarks',
  `sfcs_log_user` varchar(50) NOT NULL COMMENT 'Log User',
  `sfcs_log_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Auto Time Stamp',
  `sfcs_status` tinyint(4) NOT NULL COMMENT '0-Created, 10-Validated, 15-Confirmed, 16-Reconfirmed, 20-M3 Log Created,  30- Success, 40-Failed, 50-Manually Updated, 60-Success Archived, 70-Failed Archived, 90-Ignored',
  `m3_mo_no` varchar(100) NOT NULL COMMENT 'MO Number',
  `m3_op_code` varchar(50) NOT NULL COMMENT 'Operation Code (10,15)',
  `sfcs_job_no` varchar(50) NOT NULL COMMENT 'SFCS Job',
  `sfcs_mod_no` varchar(10) NOT NULL COMMENT 'SFCS Module',
  `sfcs_shift` varchar(10) NOT NULL COMMENT 'SFCS Shift',
  `m3_op_des` varchar(10) NOT NULL COMMENT 'M3 Operation Desc (AINLAY)',
  `sfcs_tid_ref` varchar(30) NOT NULL COMMENT 'Transaction ID Ref.',
  `m3_error_code` varchar(255) NOT NULL COMMENT 'Error Code Description',
  `work_centre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sfcs_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `m3_sfcs_tran_log_v2` */

DROP TABLE IF EXISTS `m3_sfcs_tran_log_v2`;

CREATE TABLE `m3_sfcs_tran_log_v2` (
  `sfcs_tid` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Transaction ID',
  `sfcs_date` date NOT NULL COMMENT 'Reporting Date',
  `sfcs_style` varchar(300) NOT NULL COMMENT 'style',
  `sfcs_schedule` varchar(300) NOT NULL COMMENT 'Schedule',
  `sfcs_color` varchar(300) NOT NULL COMMENT 'Color',
  `sfcs_size` varchar(10) NOT NULL COMMENT 'SFCS Size',
  `m3_size` varchar(10) NOT NULL COMMENT 'M3 relevant Size Code',
  `sfcs_doc_no` bigint(20) NOT NULL COMMENT 'SFCS Docket Reference NO',
  `sfcs_qty` int(11) NOT NULL COMMENT 'Positive/Negative Qty',
  `sfcs_reason` varchar(3) NOT NULL COMMENT 'Rejection/Scrap Reason Code',
  `sfcs_remarks` varchar(250) NOT NULL COMMENT 'Remarks',
  `sfcs_log_user` varchar(50) NOT NULL COMMENT 'Log User',
  `sfcs_log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Auto Time Stamp',
  `sfcs_status` tinyint(4) NOT NULL COMMENT '0-Created, 10-Validated, 15-Confirmed, 16-Reconfirmed, 20-M3 Log Created,  30- Success, 40-Failed, 50-Manually Updated, 60-Success Archived, 70-Failed Archived',
  `m3_mo_no` varchar(100) NOT NULL COMMENT 'MO Number',
  `m3_op_code` varchar(50) NOT NULL COMMENT 'Operation Code (10,15)',
  `sfcs_job_no` varchar(50) NOT NULL COMMENT 'SFCS Job',
  `sfcs_mod_no` varchar(10) NOT NULL COMMENT 'SFCS Module',
  `sfcs_shift` varchar(10) NOT NULL COMMENT 'SFCS Shift',
  `m3_op_des` varchar(10) NOT NULL COMMENT 'M3 Operation Desc (AINLAY)',
  `sfcs_tid_ref` varchar(30) NOT NULL COMMENT 'Transaction ID Ref.',
  `m3_error_code` varchar(255) NOT NULL COMMENT 'Error Code Description',
  `old_sfcs_qty` int(5) DEFAULT NULL COMMENT 'old sfcs qty',
  `club_status` int(5) DEFAULT 0 COMMENT 'Club status',
  PRIMARY KEY (`sfcs_tid`),
  KEY `sfcs_schedule` (`sfcs_schedule`,`sfcs_color`,`sfcs_size`,`m3_mo_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `order_status_tbl` */

DROP TABLE IF EXISTS `order_status_tbl`;

CREATE TABLE `order_status_tbl` (
  `order_del_no` varchar(60) DEFAULT NULL,
  `order_col_des` varchar(150) DEFAULT NULL,
  `order_size` varchar(15) DEFAULT NULL,
  `order_mo_no` varchar(30) DEFAULT NULL,
  `order_stat` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `rejection_report_matrix` */

DROP TABLE IF EXISTS `rejection_report_matrix`;

CREATE TABLE `rejection_report_matrix` (
  `interface` varchar(30) NOT NULL COMMENT 'Interface Type',
  `ref1` varchar(30) NOT NULL COMMENT 'Reason Source (Good Garments or G or P)',
  `ref2` varchar(10) NOT NULL COMMENT 'Source (CNP, PCK, CUT)',
  `ref3` int(11) NOT NULL COMMENT 'SFCS Reason Code Number',
  `m3_reason_code` varchar(5) NOT NULL COMMENT 'M3 Rejection Reason Code',
  `m3_operation_code` varchar(5) NOT NULL COMMENT 'M3 Operation Code (SOT) default will be SOT if noting returns from this table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `sfcs_to_m3_batch_log` */

DROP TABLE IF EXISTS `sfcs_to_m3_batch_log`;

CREATE TABLE `sfcs_to_m3_batch_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `no_of_records` int(11) DEFAULT NULL,
  `normal_records_ids` varchar(255) DEFAULT NULL,
  `scrap_records_ids` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

/*Table structure for table `sfcs_to_m3_response_log` */

DROP TABLE IF EXISTS `sfcs_to_m3_response_log`;

CREATE TABLE `sfcs_to_m3_response_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `error_message` varchar(255) DEFAULT NULL,
  `m3_sfcs_tran_log_id` int(11) DEFAULT NULL,
  `sfcs_to_m3_batch_log_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
