/*
SQLyog Job Agent Version 8.4 Copyright(c) Webyog Softworks Pvt. Ltd. All Rights Reserved.


MySQL - 5.5.5-10.1.28-MariaDB : Database - brandix_bts
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Database structure for database `brandix_bts` */

CREATE DATABASE /*!32312 IF NOT EXISTS*/`brandix_bts` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `brandix_bts`;

/*Table structure for table `bts_to_sfcs_sync` */

DROP TABLE IF EXISTS `bts_to_sfcs_sync`;

CREATE TABLE `bts_to_sfcs_sync` (
  `bts_tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sync_bundle_id` bigint(20) NOT NULL,
  `sync_operation_id` int(11) NOT NULL,
  `sync_operation_code` int(11) NOT NULL COMMENT '0-Add, 1-Update, 2-Delete',
  `sync_status` int(11) NOT NULL COMMENT '1-Sync Completed',
  `sync_rep_id` bigint(20) NOT NULL COMMENT 'id of bud_tran_20_rep',
  `insert_time_stamp` timestamp NULL DEFAULT NULL,
  `updated_time_stamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`bts_tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bundle_creation_data` */

DROP TABLE IF EXISTS `bundle_creation_data`;

CREATE TABLE `bundle_creation_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cut_number` int(11) DEFAULT NULL,
  `style` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size_id` varchar(250) DEFAULT NULL,
  `size_title` varchar(11) DEFAULT NULL,
  `sfcs_smv` decimal(10,2) DEFAULT NULL,
  `bundle_number` int(11) DEFAULT NULL,
  `original_qty` int(11) DEFAULT NULL,
  `send_qty` int(11) DEFAULT NULL,
  `recevied_qty` int(11) DEFAULT '0',
  `missing_qty` int(11) DEFAULT '0',
  `rejected_qty` int(11) DEFAULT '0',
  `left_over` int(11) DEFAULT '0',
  `operation_id` int(11) DEFAULT NULL,
  `operation_sequence` int(11) DEFAULT NULL,
  `ops_dependency` int(11) DEFAULT NULL,
  `docket_number` int(11) DEFAULT NULL,
  `bundle_status` varchar(255) DEFAULT 'OPEN',
  `split_status` varchar(255) DEFAULT NULL,
  `sewing_order_status` varchar(10) DEFAULT 'No',
  `is_sewing_order` varchar(10) DEFAULT 'No',
  `sewing_order` int(11) DEFAULT '0',
  `assigned_module` varchar(10) DEFAULT '0',
  `remarks` text,
  `scanned_date` datetime DEFAULT NULL,
  `shift` varchar(11) DEFAULT NULL,
  `scanned_user` varchar(255) DEFAULT NULL,
  `sync_status` int(11) DEFAULT '0',
  `shade` varchar(10) DEFAULT NULL,
  `input_job_no` int(11) DEFAULT NULL,
  `input_job_no_random_ref` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `bundle_creation_data_temp` */

DROP TABLE IF EXISTS `bundle_creation_data_temp`;

CREATE TABLE `bundle_creation_data_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cut_number` int(11) DEFAULT NULL,
  `style` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size_id` varchar(250) DEFAULT NULL,
  `size_title` varchar(11) DEFAULT NULL,
  `sfcs_smv` decimal(10,2) DEFAULT NULL,
  `bundle_number` int(11) DEFAULT NULL,
  `original_qty` int(11) DEFAULT NULL,
  `send_qty` int(11) DEFAULT NULL,
  `recevied_qty` int(11) DEFAULT '0',
  `missing_qty` int(11) DEFAULT '0',
  `rejected_qty` int(11) DEFAULT '0',
  `left_over` int(11) DEFAULT '0',
  `operation_id` int(11) DEFAULT NULL,
  `operation_sequence` int(11) DEFAULT NULL,
  `ops_dependency` int(11) DEFAULT NULL,
  `docket_number` int(11) DEFAULT NULL,
  `bundle_status` varchar(255) DEFAULT 'OPEN',
  `split_status` varchar(255) DEFAULT NULL,
  `sewing_order_status` varchar(10) DEFAULT 'No',
  `is_sewing_order` varchar(10) DEFAULT 'No',
  `sewing_order` int(11) DEFAULT '0',
  `assigned_module` varchar(10) DEFAULT '0',
  `remarks` text,
  `scanned_date` datetime DEFAULT NULL,
  `shift` varchar(11) DEFAULT NULL,
  `scanned_user` varchar(255) DEFAULT NULL,
  `sync_status` int(11) DEFAULT '0',
  `shade` varchar(10) DEFAULT NULL,
  `input_job_no` int(11) DEFAULT NULL,
  `input_job_no_random_ref` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `bundle_transactions` */

DROP TABLE IF EXISTS `bundle_transactions`;

CREATE TABLE `bundle_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `operation_time` datetime DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `shift` int(11) DEFAULT NULL,
  `trans_status` varchar(255) DEFAULT NULL,
  `module_id` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scanned_qty` (`operation_time`,`shift`,`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bundle_transactions_20_repeat` */

DROP TABLE IF EXISTS `bundle_transactions_20_repeat`;

CREATE TABLE `bundle_transactions_20_repeat` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(11) DEFAULT NULL,
  `bundle_barcode` varchar(50) NOT NULL,
  `quantity` int(6) DEFAULT NULL,
  `bundle_id` int(6) DEFAULT NULL,
  `operation_id` varchar(15) DEFAULT NULL,
  `rejection_quantity` int(6) DEFAULT NULL,
  `act_module` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`bundle_barcode`),
  UNIQUE KEY `bundle_barcode` (`bundle_barcode`),
  KEY `op_id` (`operation_id`),
  KEY `scanned_qty` (`parent_id`,`bundle_id`),
  KEY `bundle_id` (`bundle_id`,`operation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bundle_transactions_20_repeat_archive` */

DROP TABLE IF EXISTS `bundle_transactions_20_repeat_archive`;

CREATE TABLE `bundle_transactions_20_repeat_archive` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(11) DEFAULT NULL,
  `bundle_barcode` varchar(50) NOT NULL,
  `quantity` int(6) DEFAULT NULL,
  `bundle_id` int(6) DEFAULT NULL,
  `operation_id` varchar(15) DEFAULT NULL,
  `rejection_quantity` int(6) DEFAULT NULL,
  `act_module` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`bundle_barcode`),
  UNIQUE KEY `bundle_barcode` (`bundle_barcode`),
  KEY `op_id` (`operation_id`),
  KEY `scanned_qty` (`parent_id`,`bundle_id`),
  KEY `bundle_id` (`bundle_id`,`operation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bundle_transactions_20_repeat_delete` */

DROP TABLE IF EXISTS `bundle_transactions_20_repeat_delete`;

CREATE TABLE `bundle_transactions_20_repeat_delete` (
  `id` bigint(11) NOT NULL DEFAULT '0',
  `parent_id` bigint(11) DEFAULT NULL,
  `bundle_barcode` varchar(50) NOT NULL,
  `quantity` int(6) DEFAULT NULL,
  `bundle_id` int(6) DEFAULT NULL,
  `operation_id` varchar(15) DEFAULT NULL,
  `rejection_quantity` int(6) DEFAULT NULL,
  `act_module` int(11) DEFAULT NULL,
  `status` int(5) NOT NULL DEFAULT '0',
  `user` varchar(70) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` varchar(200) NOT NULL,
  `updated_by` varchar(70) NOT NULL,
  `update_log` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bundle_transactions_20_repeat_deleted` */

DROP TABLE IF EXISTS `bundle_transactions_20_repeat_deleted`;

CREATE TABLE `bundle_transactions_20_repeat_deleted` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `bundle_barcode` varchar(50) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `bundle_id` int(6) DEFAULT NULL,
  `operation_id` varchar(15) DEFAULT NULL,
  `rejection_quantity` int(6) DEFAULT NULL,
  `act_module` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `op_id` (`operation_id`),
  KEY `scanned_qty` (`parent_id`,`bundle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `bundle_transactions_20_repeat_virtual_snap_ini_bundles` */

DROP TABLE IF EXISTS `bundle_transactions_20_repeat_virtual_snap_ini_bundles`;

CREATE TABLE `bundle_transactions_20_repeat_virtual_snap_ini_bundles` (
  `id` bigint(11) DEFAULT NULL,
  `parent_id` bigint(11) DEFAULT NULL,
  `bundle_barcode` varchar(150) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `bundle_id` bigint(11) DEFAULT NULL,
  `operation_id` varchar(45) DEFAULT NULL,
  `rejection_quantity` int(6) DEFAULT NULL,
  `act_module` int(11) DEFAULT NULL,
  KEY `operation_id` (`operation_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='temporary table to keep the records of mini order initial bundle info.';

/*Table structure for table `bundle_transactions_archive` */

DROP TABLE IF EXISTS `bundle_transactions_archive`;

CREATE TABLE `bundle_transactions_archive` (
  `id` int(11) NOT NULL DEFAULT '0',
  `date_time` datetime DEFAULT NULL,
  `operation_time` datetime DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `shift` int(11) DEFAULT NULL,
  `trans_status` varchar(255) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `re_print_table` */

DROP TABLE IF EXISTS `re_print_table`;

CREATE TABLE `re_print_table` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `bundle_id` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `emp_id` varchar(10) NOT NULL,
  `module_id` int(3) NOT NULL,
  `shift` varchar(2) NOT NULL,
  `user_name` varchar(15) NOT NULL,
  `remark` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `snap_session_track` */

DROP TABLE IF EXISTS `snap_session_track`;

CREATE TABLE `snap_session_track` (
  `session_status` varchar(5) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `time_stamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `swap_status` varchar(10) DEFAULT NULL,
  `6_snap` varchar(100) DEFAULT NULL,
  `5_snap` varchar(100) DEFAULT NULL,
  `4_snap` varchar(100) DEFAULT NULL,
  `3_snap` varchar(100) DEFAULT NULL,
  `2_snap` varchar(100) DEFAULT NULL,
  `1_snap` varchar(100) DEFAULT NULL,
  `0_tbl_snap` varchar(100) DEFAULT NULL,
  `fg_m3_sync_status` varchar(11) DEFAULT NULL COMMENT 'on, off',
  `fg_last_updated_tid` bigint(20) DEFAULT NULL COMMENT 'last id which got processed.',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_bundle_master` */

DROP TABLE IF EXISTS `tbl_bundle_master`;

CREATE TABLE `tbl_bundle_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `bundle_status` varchar(60) NOT NULL,
  `planned_module` int(11) NOT NULL,
  `bundle_quantity` int(11) NOT NULL,
  `plan_date` date NOT NULL,
  `issue_date` date NOT NULL,
  `request_time` date NOT NULL,
  `planned_date` datetime DEFAULT NULL,
  `issued_date` datetime DEFAULT NULL,
  `Color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_bundle_tran_master` */

DROP TABLE IF EXISTS `tbl_bundle_tran_master`;

CREATE TABLE `tbl_bundle_tran_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bundle_id` int(11) DEFAULT NULL,
  `act_module` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_carton_ref` */

DROP TABLE IF EXISTS `tbl_carton_ref`;

CREATE TABLE `tbl_carton_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carton_barcode` varchar(40) NOT NULL,
  `carton_tot_quantity` int(11) NOT NULL,
  `ref_order_num` varchar(255) DEFAULT NULL,
  `style_code` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_carton_ref_archive` */

DROP TABLE IF EXISTS `tbl_carton_ref_archive`;

CREATE TABLE `tbl_carton_ref_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carton_barcode` varchar(40) NOT NULL,
  `carton_tot_quantity` int(11) NOT NULL,
  `ref_order_num` varchar(255) DEFAULT NULL,
  `style_code` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_carton_size_ref` */

DROP TABLE IF EXISTS `tbl_carton_size_ref`;

CREATE TABLE `tbl_carton_size_ref` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `ref_size_name` int(11) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_carton_size_ref_archive` */

DROP TABLE IF EXISTS `tbl_carton_size_ref_archive`;

CREATE TABLE `tbl_carton_size_ref_archive` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `ref_size_name` int(11) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_cut_master` */

DROP TABLE IF EXISTS `tbl_cut_master`;

CREATE TABLE `tbl_cut_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_num` varchar(50) NOT NULL,
  `ref_order_num` int(11) NOT NULL,
  `cut_num` int(11) NOT NULL,
  `cut_status` text,
  `planned_module` int(11) DEFAULT NULL,
  `request_time` datetime DEFAULT NULL,
  `issued_time` datetime DEFAULT NULL,
  `planned_plies` int(11) NOT NULL,
  `actual_plies` int(11) NOT NULL,
  `plan_date` datetime DEFAULT NULL,
  `style_id` int(6) DEFAULT NULL,
  `product_schedule` varchar(255) DEFAULT NULL,
  `cat_ref` int(6) DEFAULT NULL,
  `cuttable_ref` int(6) DEFAULT NULL,
  `mk_ref` int(6) DEFAULT NULL,
  `col_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doc_num` (`doc_num`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_cut_master_archive` */

DROP TABLE IF EXISTS `tbl_cut_master_archive`;

CREATE TABLE `tbl_cut_master_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_num` varchar(50) NOT NULL,
  `ref_order_num` int(11) NOT NULL,
  `cut_num` int(11) NOT NULL,
  `cut_status` text,
  `planned_module` int(11) DEFAULT NULL,
  `request_time` datetime DEFAULT NULL,
  `issued_time` datetime DEFAULT NULL,
  `planned_plies` int(11) NOT NULL,
  `actual_plies` int(11) NOT NULL,
  `plan_date` datetime DEFAULT NULL,
  `style_id` int(6) DEFAULT NULL,
  `product_schedule` varchar(255) DEFAULT NULL,
  `cat_ref` int(6) DEFAULT NULL,
  `cuttable_ref` int(6) DEFAULT NULL,
  `mk_ref` int(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `doc_num` (`doc_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_cut_size_master` */

DROP TABLE IF EXISTS `tbl_cut_size_master`;

CREATE TABLE `tbl_cut_size_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `ref_size_name` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_cut_size_master_archive` */

DROP TABLE IF EXISTS `tbl_cut_size_master_archive`;

CREATE TABLE `tbl_cut_size_master_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `ref_size_name` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_emblishment_recover_panels` */

DROP TABLE IF EXISTS `tbl_emblishment_recover_panels`;

CREATE TABLE `tbl_emblishment_recover_panels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `bundle_number` int(11) DEFAULT NULL,
  `operation_code` int(11) DEFAULT NULL,
  `style` varchar(100) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `color` varchar(100) DEFAULT NULL,
  `bundle_generate` enum('yes','no') DEFAULT 'no',
  `good_panels` varchar(255) DEFAULT NULL,
  `rejected_panels` varchar(255) DEFAULT NULL,
  `cut_no` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_garment_ops_rej_track` */

DROP TABLE IF EXISTS `tbl_garment_ops_rej_track`;

CREATE TABLE `tbl_garment_ops_rej_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `no_of_reasons` int(11) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `style` varchar(250) NOT NULL,
  `schedule` varchar(250) NOT NULL,
  `color` varchar(250) NOT NULL,
  `cut_no` int(11) NOT NULL,
  `size` varchar(250) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `shift` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_garmet_ops_track` */

DROP TABLE IF EXISTS `tbl_garmet_ops_track`;

CREATE TABLE `tbl_garmet_ops_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(250) NOT NULL,
  `schedule` varchar(250) NOT NULL,
  `color` varchar(250) NOT NULL,
  `cut_number` int(11) NOT NULL,
  `received_qty` int(11) NOT NULL,
  `rejected_qty` int(11) NOT NULL,
  `sew_out_qty` int(11) NOT NULL,
  `sendig_qty` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  `size_title` varchar(250) NOT NULL,
  `size_id` int(11) NOT NULL,
  `shift` varchar(250) DEFAULT 'Null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_min_ord_map_ref` */

DROP TABLE IF EXISTS `tbl_min_ord_map_ref`;

CREATE TABLE `tbl_min_ord_map_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mini_order_num` int(11) NOT NULL,
  `ref_order_num` int(11) NOT NULL,
  `plannned_date` date NOT NULL,
  `issued_date` date NOT NULL,
  `request_time` date NOT NULL,
  `mini_order_status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_min_ord_ref` */

DROP TABLE IF EXISTS `tbl_min_ord_ref`;

CREATE TABLE `tbl_min_ord_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_product_style` int(11) DEFAULT NULL,
  `ref_crt_schedule` int(11) NOT NULL,
  `carton_quantity` int(11) NOT NULL,
  `max_bundle_qnty` int(11) NOT NULL,
  `miximum_bundles_per_size` int(11) NOT NULL,
  `mini_order_qnty` int(11) NOT NULL,
  `carton_method` varchar(255) NOT NULL COMMENT '1=>''single cut as input'',2=>''singe color- single size'',3=>''single color - multi size'',4=>''multi color single size, 5=> multi color - multi size',
  `transac_status` varchar(20) DEFAULT NULL,
  `split_qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `scanned_qty` (`ref_product_style`,`ref_crt_schedule`),
  KEY `ref_crt_schedule` (`ref_crt_schedule`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_min_ord_ref_archive` */

DROP TABLE IF EXISTS `tbl_min_ord_ref_archive`;

CREATE TABLE `tbl_min_ord_ref_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_product_style` int(11) DEFAULT NULL,
  `ref_crt_schedule` int(11) NOT NULL,
  `carton_quantity` int(11) NOT NULL,
  `max_bundle_qnty` int(11) NOT NULL,
  `miximum_bundles_per_size` int(11) NOT NULL,
  `mini_order_qnty` int(11) NOT NULL,
  `split_qty` varchar(255) DEFAULT NULL,
  `transac_status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scanned_qty` (`ref_product_style`,`ref_crt_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_min_ord_ref_repeat_planned_module` */

DROP TABLE IF EXISTS `tbl_min_ord_ref_repeat_planned_module`;

CREATE TABLE `tbl_min_ord_ref_repeat_planned_module` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `planned_module` int(11) DEFAULT NULL,
  `params` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_mini_order_change` */

DROP TABLE IF EXISTS `tbl_mini_order_change`;

CREATE TABLE `tbl_mini_order_change` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `mini_order_num` int(6) DEFAULT NULL,
  `max_bundle_qnty` int(6) DEFAULT NULL,
  `prev_max_bundle_qnty` int(6) DEFAULT NULL,
  `update_status` varchar(255) DEFAULT NULL,
  `style_id` int(11) DEFAULT NULL,
  `product_schedule` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_miniorder_data` */

DROP TABLE IF EXISTS `tbl_miniorder_data`;

CREATE TABLE `tbl_miniorder_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `mini_order_ref` int(11) NOT NULL,
  `mini_order_num` int(5) DEFAULT NULL,
  `cut_num` varchar(15) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `bundle_number` int(6) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `docket_number` varchar(15) DEFAULT NULL,
  `issued_date` datetime DEFAULT NULL,
  `plan_date` datetime DEFAULT NULL,
  `bundle_status` varchar(15) DEFAULT 'OPEN',
  `planned_module` int(11) DEFAULT NULL,
  `mini_order_priority` int(6) DEFAULT NULL,
  `requested_date` datetime DEFAULT NULL,
  `trim_status` text,
  `mini_order_status` varchar(15) DEFAULT NULL,
  `loc_status` int(11) DEFAULT '0',
  `split_status` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scanned_qty` (`mini_order_num`,`color`),
  KEY `mini_order_ref` (`mini_order_ref`),
  KEY `bun_no` (`bundle_number`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_miniorder_data_archive` */

DROP TABLE IF EXISTS `tbl_miniorder_data_archive`;

CREATE TABLE `tbl_miniorder_data_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `mini_order_ref` int(11) NOT NULL,
  `mini_order_num` float(6,2) DEFAULT NULL,
  `cut_num` varchar(15) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `bundle_number` int(6) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `docket_number` varchar(15) DEFAULT NULL,
  `issued_date` datetime DEFAULT NULL,
  `plan_date` datetime DEFAULT NULL,
  `bundle_status` varchar(15) DEFAULT 'OPEN',
  `planned_module` int(11) DEFAULT NULL,
  `mini_order_priority` int(6) DEFAULT NULL,
  `requested_date` datetime DEFAULT NULL,
  `trim_status` text,
  `mini_order_status` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bun_no` (`bundle_number`),
  KEY `scanned_qty` (`mini_order_num`,`color`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_miniorder_data_deleted` */

DROP TABLE IF EXISTS `tbl_miniorder_data_deleted`;

CREATE TABLE `tbl_miniorder_data_deleted` (
  `id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `mini_order_ref` int(11) DEFAULT NULL,
  `mini_order_num` float(6,2) DEFAULT NULL,
  `cut_num` varchar(45) DEFAULT NULL,
  `color` varchar(765) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `bundle_number` int(6) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `docket_number` varchar(45) DEFAULT NULL,
  `issued_date` datetime DEFAULT NULL,
  `plan_date` datetime DEFAULT NULL,
  `bundle_status` varchar(45) DEFAULT NULL,
  `planned_module` int(11) DEFAULT NULL,
  `mini_order_priority` int(6) DEFAULT NULL,
  `requested_date` datetime DEFAULT NULL,
  `trim_status` text,
  `mini_order_status` varchar(45) DEFAULT NULL,
  `split_status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_miniorder_data_temp` */

DROP TABLE IF EXISTS `tbl_miniorder_data_temp`;

CREATE TABLE `tbl_miniorder_data_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `mini_order_ref` int(11) NOT NULL,
  `mini_order_num` float(6,2) DEFAULT NULL,
  `cut_num` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `bundle_number` int(6) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `docket_number` varchar(255) DEFAULT NULL,
  `issued_date` datetime DEFAULT NULL,
  `plan_date` datetime DEFAULT NULL,
  `bundle_status` varchar(255) DEFAULT 'OPEN',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_module_ref` */

DROP TABLE IF EXISTS `tbl_module_ref`;

CREATE TABLE `tbl_module_ref` (
  `id` varchar(11) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `module_section` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_colors_master` */

DROP TABLE IF EXISTS `tbl_orders_colors_master`;

CREATE TABLE `tbl_orders_colors_master` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `color_code` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_master` */

DROP TABLE IF EXISTS `tbl_orders_master`;

CREATE TABLE `tbl_orders_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_product_style` int(11) NOT NULL,
  `product_schedule` varchar(50) NOT NULL,
  `order_status` text,
  `emb_status` varchar(10) DEFAULT '0' COMMENT '0-Narmal,1-Panel Emb,2-Garment Emb',
  `log` varchar(55) DEFAULT NULL COMMENT 'log details',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_master_archive` */

DROP TABLE IF EXISTS `tbl_orders_master_archive`;

CREATE TABLE `tbl_orders_master_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_product_style` int(11) NOT NULL,
  `product_schedule` varchar(50) NOT NULL,
  `order_status` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_ops_ref` */

DROP TABLE IF EXISTS `tbl_orders_ops_ref`;

CREATE TABLE `tbl_orders_ops_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_name` varchar(50) NOT NULL,
  `default_operation` text,
  `operation_code` varchar(255) DEFAULT NULL,
  `ops_order` int(10) DEFAULT NULL,
  `operation_description` varchar(100) DEFAULT NULL,
  `operation_type` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_size_ref` */

DROP TABLE IF EXISTS `tbl_orders_size_ref`;

CREATE TABLE `tbl_orders_size_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_sizes_master` */

DROP TABLE IF EXISTS `tbl_orders_sizes_master`;

CREATE TABLE `tbl_orders_sizes_master` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `ref_size_name` int(11) DEFAULT NULL,
  `size_title` varchar(255) DEFAULT NULL,
  `order_quantity` int(6) DEFAULT NULL,
  `order_act_quantity` int(6) DEFAULT NULL,
  `order_col_des` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_id` (`parent_id`,`ref_size_name`,`order_col_des`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_sizes_master_archive` */

DROP TABLE IF EXISTS `tbl_orders_sizes_master_archive`;

CREATE TABLE `tbl_orders_sizes_master_archive` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `ref_size_name` int(11) DEFAULT NULL,
  `size_title` varchar(255) DEFAULT NULL,
  `order_quantity` int(6) DEFAULT NULL,
  `order_act_quantity` int(6) DEFAULT NULL,
  `order_col_des` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_style_ref` */

DROP TABLE IF EXISTS `tbl_orders_style_ref`;

CREATE TABLE `tbl_orders_style_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_style` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_style_ref_archive` */

DROP TABLE IF EXISTS `tbl_orders_style_ref_archive`;

CREATE TABLE `tbl_orders_style_ref_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_style` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_shifts_master` */

DROP TABLE IF EXISTS `tbl_shifts_master`;

CREATE TABLE `tbl_shifts_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime DEFAULT NULL,
  `shift_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_style_ops_master` */

DROP TABLE IF EXISTS `tbl_style_ops_master`;

CREATE TABLE `tbl_style_ops_master` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `operation_name` int(11) DEFAULT NULL,
  `operation_order` float DEFAULT NULL,
  `smo` int(6) DEFAULT NULL,
  `smv` decimal(8,2) DEFAULT NULL,
  `m3_smv` decimal(8,2) DEFAULT NULL,
  `operation_code` int(11) NOT NULL,
  `default_operration` varchar(250) NOT NULL,
  `priority` varchar(250) NOT NULL,
  `style` varchar(250) NOT NULL,
  `schedule` varchar(250) DEFAULT NULL,
  `color` varchar(250) NOT NULL,
  `from_m3_check` int(11) NOT NULL DEFAULT '1',
  `scan_status` int(11) DEFAULT '0',
  `min_order_ref` int(11) DEFAULT '0',
  `barcode` varchar(50) NOT NULL DEFAULT 'No',
  `emb_supplier` int(11) DEFAULT NULL,
  `ops_sequence` varchar(50) DEFAULT '0',
  `ops_dependency` int(11) DEFAULT NULL,
  `component` varchar(250) DEFAULT NULL,
  `main_operationnumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1768 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_suppliers_master` */

DROP TABLE IF EXISTS `tbl_suppliers_master`;

CREATE TABLE `tbl_suppliers_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(250) NOT NULL,
  `supplier_code` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user_access` */

DROP TABLE IF EXISTS `user_access`;

CREATE TABLE `user_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `access_level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `user_id` (`user_id`),
  KEY `branch_id` (`branch_id`),
  KEY `access_level` (`access_level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exp_date` varchar(15) DEFAULT NULL,
  `exp_time` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `view_extra_recut` */

DROP TABLE IF EXISTS `view_extra_recut`;

CREATE TABLE `view_extra_recut` (
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
  `doc_no` varchar(12) CHARACTER SET utf8 NOT NULL DEFAULT '',
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
  `category` varchar(50) DEFAULT NULL COMMENT 'User defined category',
  `color_code` int(11) DEFAULT NULL COMMENT 'Color Code(Number Format)',
  `fabric_status` smallint(6) NOT NULL,
  `order_del_no` varchar(60) DEFAULT NULL COMMENT 'Schedule No',
  `plan_lot_ref` text NOT NULL,
  `order_col_des` varchar(150) DEFAULT NULL COMMENT 'Color ',
  `order_style_no` varchar(60) DEFAULT NULL COMMENT 'Style No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_mini_ord_bundl_master` */

DROP TABLE IF EXISTS `view_mini_ord_bundl_master`;

CREATE TABLE `view_mini_ord_bundl_master` (
  `id` int(11) NOT NULL DEFAULT '0',
  `cut_num` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `mini_order_num` int(5) DEFAULT NULL,
  `bundle_number` int(6) DEFAULT NULL,
  `product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `docket_number` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `ord_tid` varchar(389) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_orders_master` */

DROP TABLE IF EXISTS `view_orders_master`;

CREATE TABLE `view_orders_master` (
  `size_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ref_size_name` int(11) DEFAULT NULL,
  `order_quantity` int(6) DEFAULT NULL,
  `order_col_des` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `size_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `disp_size` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ord_tid` varchar(389) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_1` */

DROP TABLE IF EXISTS `view_set_1`;

CREATE TABLE `view_set_1` (
  `bundle_transactions_20_repeat_id` bigint(11) NOT NULL DEFAULT '0',
  `bundle_transactions_20_repeat_parent_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_barcode` varchar(50) CHARACTER SET utf8 NOT NULL,
  `bundle_transactions_20_repeat_quantity` int(6) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_id` int(6) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` int(6) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_default_operation` text CHARACTER SET utf8,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_id` int(11) DEFAULT NULL,
  `bundle_transactions_date_time` datetime DEFAULT NULL,
  `bundle_transactions_operation_time` datetime DEFAULT NULL,
  `bundle_transactions_employee_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_shift` int(11) DEFAULT NULL,
  `bundle_transactions_trans_status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_shifts_master_id` int(11) DEFAULT NULL,
  `tbl_shifts_master_date_time` datetime DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_1_snap` */

DROP TABLE IF EXISTS `view_set_1_snap`;

CREATE TABLE `view_set_1_snap` (
  `bundle_transactions_20_repeat_id` bigint(11) NOT NULL DEFAULT '0',
  `bundle_transactions_20_repeat_parent_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_barcode` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` bigint(11) DEFAULT NULL,
  `tbl_orders_ops_ref_id` bigint(11) DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_default_operation` text CHARACTER SET utf8,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_date_time` datetime DEFAULT NULL,
  `bundle_transactions_operation_time` datetime DEFAULT NULL,
  `bundle_transactions_employee_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_shift` bigint(11) DEFAULT NULL,
  `bundle_transactions_trans_status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_id` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_date_time` datetime DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`bundle_transactions_20_repeat_id`),
  KEY `bundle_transactions_20_repeat_bundle_id` (`bundle_transactions_20_repeat_bundle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_1_snap_swap_2` */

DROP TABLE IF EXISTS `view_set_1_snap_swap_2`;

CREATE TABLE `view_set_1_snap_swap_2` (
  `bundle_transactions_20_repeat_id` bigint(11) NOT NULL DEFAULT '0',
  `bundle_transactions_20_repeat_parent_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_barcode` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` bigint(11) DEFAULT NULL,
  `tbl_orders_ops_ref_id` bigint(11) DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_default_operation` text CHARACTER SET utf8,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_date_time` datetime DEFAULT NULL,
  `bundle_transactions_operation_time` datetime DEFAULT NULL,
  `bundle_transactions_employee_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_shift` bigint(11) DEFAULT NULL,
  `bundle_transactions_trans_status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_id` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_date_time` datetime DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`bundle_transactions_20_repeat_id`),
  KEY `bundle_transactions_20_repeat_bundle_id` (`bundle_transactions_20_repeat_bundle_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_1_virtual` */

DROP TABLE IF EXISTS `view_set_1_virtual`;

CREATE TABLE `view_set_1_virtual` (
  `bundle_transactions_20_repeat_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_parent_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_barcode` varchar(150) DEFAULT NULL,
  `bundle_transactions_20_repeat_quantity` int(6) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(45) DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` int(6) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_default_operation` text CHARACTER SET utf8,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_id` int(11) DEFAULT NULL,
  `bundle_transactions_date_time` datetime DEFAULT NULL,
  `bundle_transactions_operation_time` datetime DEFAULT NULL,
  `bundle_transactions_employee_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_shift` int(11) DEFAULT NULL,
  `bundle_transactions_trans_status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_shifts_master_id` int(11) DEFAULT NULL,
  `tbl_shifts_master_date_time` datetime DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_2` */

DROP TABLE IF EXISTS `view_set_2`;

CREATE TABLE `view_set_2` (
  `tbl_orders_size_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_size_ref_size_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_id` int(6) NOT NULL DEFAULT '0',
  `tbl_orders_sizes_master_parent_id` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_ref_size_name` int(11) DEFAULT NULL,
  `tbl_orders_sizes_master_size_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_order_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_act_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_col_des` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_id` int(11) DEFAULT NULL,
  `tbl_orders_master_ref_product_style` int(11) DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_order_status` text CHARACTER SET utf8,
  `tbl_orders_style_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_style_ref_product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  `smv` varchar(50) DEFAULT NULL,
  `order_div` varchar(50) DEFAULT NULL,
  `order_date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_2_snap` */

DROP TABLE IF EXISTS `view_set_2_snap`;

CREATE TABLE `view_set_2_snap` (
  `tbl_orders_size_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_size_ref_size_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_id` int(6) NOT NULL DEFAULT '0',
  `tbl_orders_sizes_master_parent_id` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_ref_size_name` int(11) DEFAULT NULL,
  `tbl_orders_sizes_master_size_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_order_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_act_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_col_des` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_id` int(11) DEFAULT NULL,
  `tbl_orders_master_ref_product_style` int(11) DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_order_status` text CHARACTER SET utf8,
  `tbl_orders_style_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_style_ref_product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  `smv` varchar(50) DEFAULT NULL,
  `order_div` varchar(50) DEFAULT NULL,
  `order_date` varchar(50) DEFAULT NULL,
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_2_snap_swap_2` */

DROP TABLE IF EXISTS `view_set_2_snap_swap_2`;

CREATE TABLE `view_set_2_snap_swap_2` (
  `tbl_orders_size_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_size_ref_size_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_id` int(6) NOT NULL DEFAULT '0',
  `tbl_orders_sizes_master_parent_id` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_ref_size_name` int(11) DEFAULT NULL,
  `tbl_orders_sizes_master_size_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_order_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_act_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_col_des` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_id` int(11) DEFAULT NULL,
  `tbl_orders_master_ref_product_style` int(11) DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_order_status` text CHARACTER SET utf8,
  `tbl_orders_style_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_style_ref_product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  `smv` varchar(50) DEFAULT NULL,
  `order_div` varchar(50) DEFAULT NULL,
  `order_date` varchar(50) DEFAULT NULL,
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_3` */

DROP TABLE IF EXISTS `view_set_3`;

CREATE TABLE `view_set_3` (
  `tbl_min_ord_ref_id` int(11) DEFAULT '0',
  `tbl_min_ord_ref_ref_product_style` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_ref_crt_schedule` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_carton_quantity` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_max_bundle_qnty` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_miximum_bundles_per_size` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_mini_order_qnty` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_transac_status` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_id` int(11) NOT NULL DEFAULT '0',
  `tbl_miniorder_data_date_time` datetime DEFAULT NULL,
  `tbl_miniorder_data_mini_order_ref` int(11) NOT NULL,
  `tbl_miniorder_data_mini_order_num` int(5) DEFAULT NULL,
  `tbl_miniorder_data_cut_num` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_color` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_size` int(11) DEFAULT NULL,
  `tbl_miniorder_data_bundle_number` int(6) DEFAULT NULL,
  `tbl_miniorder_data_quantity` decimal(32,0) DEFAULT NULL,
  `tbl_miniorder_data_docket_number` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_issued_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_plan_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_bundle_status` varchar(15) CHARACTER SET utf8 DEFAULT 'OPEN',
  `tbl_miniorder_data_planned_module` int(11) DEFAULT NULL,
  `tbl_miniorder_data_mini_order_priority` int(6) DEFAULT NULL,
  `tbl_miniorder_data_requested_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_trim_status` text CHARACTER SET utf8,
  `tbl_miniorder_data_mini_order_status` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_3_snap` */

DROP TABLE IF EXISTS `view_set_3_snap`;

CREATE TABLE `view_set_3_snap` (
  `tbl_min_ord_ref_id` int(11) DEFAULT '0',
  `tbl_min_ord_ref_ref_product_style` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_ref_crt_schedule` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_carton_quantity` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_max_bundle_qnty` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_miximum_bundles_per_size` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_mini_order_qnty` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_transac_status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_id` int(11) NOT NULL DEFAULT '0',
  `tbl_miniorder_data_date_time` datetime DEFAULT NULL,
  `tbl_miniorder_data_mini_order_ref` int(11) NOT NULL,
  `tbl_miniorder_data_mini_order_num` float(6,2) DEFAULT NULL,
  `tbl_miniorder_data_cut_num` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_color` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_size` int(11) DEFAULT NULL,
  `tbl_miniorder_data_bundle_number` int(6) DEFAULT NULL,
  `tbl_miniorder_data_quantity` decimal(32,0) DEFAULT NULL,
  `tbl_miniorder_data_docket_number` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_issued_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_plan_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_bundle_status` varchar(15) CHARACTER SET utf8 DEFAULT 'OPEN',
  `tbl_miniorder_data_planned_module` int(11) DEFAULT NULL,
  `tbl_miniorder_data_mini_order_priority` int(6) DEFAULT NULL,
  `tbl_miniorder_data_requested_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_trim_status` text CHARACTER SET utf8,
  `tbl_miniorder_data_mini_order_status` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  KEY `tbl_miniorder_data_bundle_number` (`tbl_miniorder_data_bundle_number`),
  KEY `order_id` (`order_id`),
  KEY `tbl_miniorder_data_mini_order_num` (`tbl_miniorder_data_mini_order_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_3_snap_swap_2` */

DROP TABLE IF EXISTS `view_set_3_snap_swap_2`;

CREATE TABLE `view_set_3_snap_swap_2` (
  `tbl_min_ord_ref_id` int(11) DEFAULT '0',
  `tbl_min_ord_ref_ref_product_style` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_ref_crt_schedule` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_carton_quantity` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_max_bundle_qnty` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_miximum_bundles_per_size` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_mini_order_qnty` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_transac_status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_id` int(11) NOT NULL DEFAULT '0',
  `tbl_miniorder_data_date_time` datetime DEFAULT NULL,
  `tbl_miniorder_data_mini_order_ref` int(11) NOT NULL,
  `tbl_miniorder_data_mini_order_num` float(6,2) DEFAULT NULL,
  `tbl_miniorder_data_cut_num` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_color` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_size` int(11) DEFAULT NULL,
  `tbl_miniorder_data_bundle_number` int(6) DEFAULT NULL,
  `tbl_miniorder_data_quantity` decimal(32,0) DEFAULT NULL,
  `tbl_miniorder_data_docket_number` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_issued_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_plan_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_bundle_status` varchar(15) CHARACTER SET utf8 DEFAULT 'OPEN',
  `tbl_miniorder_data_planned_module` int(11) DEFAULT NULL,
  `tbl_miniorder_data_mini_order_priority` int(6) DEFAULT NULL,
  `tbl_miniorder_data_requested_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_trim_status` text CHARACTER SET utf8,
  `tbl_miniorder_data_mini_order_status` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  KEY `tbl_miniorder_data_bundle_number` (`tbl_miniorder_data_bundle_number`),
  KEY `order_id` (`order_id`),
  KEY `tbl_miniorder_data_mini_order_num` (`tbl_miniorder_data_mini_order_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_4` */

DROP TABLE IF EXISTS `view_set_4`;

CREATE TABLE `view_set_4` (
  `DATE` date NOT NULL,
  `style` varchar(60) NOT NULL,
  `SCHEDULE` varchar(60) NOT NULL,
  `cpk_qty` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_4_snap` */

DROP TABLE IF EXISTS `view_set_4_snap`;

CREATE TABLE `view_set_4_snap` (
  `DATE` date NOT NULL,
  `style` varchar(60) NOT NULL,
  `SCHEDULE` varchar(60) NOT NULL,
  `cpk_qty` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_4_snap_swap_2` */

DROP TABLE IF EXISTS `view_set_4_snap_swap_2`;

CREATE TABLE `view_set_4_snap_swap_2` (
  `DATE` date NOT NULL,
  `style` varchar(60) NOT NULL,
  `SCHEDULE` varchar(60) NOT NULL,
  `cpk_qty` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_5` */

DROP TABLE IF EXISTS `view_set_5`;

CREATE TABLE `view_set_5` (
  `log_date` date NOT NULL COMMENT 'Log date',
  `qms_style` varchar(30) NOT NULL COMMENT 'Style',
  `qms_schedule` varchar(20) NOT NULL COMMENT 'Schedule',
  `rejected_qty` decimal(27,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_5_snap` */

DROP TABLE IF EXISTS `view_set_5_snap`;

CREATE TABLE `view_set_5_snap` (
  `log_date` date NOT NULL COMMENT 'Log date',
  `qms_style` varchar(30) NOT NULL COMMENT 'Style',
  `qms_schedule` varchar(20) NOT NULL COMMENT 'Schedule',
  `rejected_qty` decimal(27,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_5_snap_swap_2` */

DROP TABLE IF EXISTS `view_set_5_snap_swap_2`;

CREATE TABLE `view_set_5_snap_swap_2` (
  `log_date` date NOT NULL COMMENT 'Log date',
  `qms_style` varchar(30) NOT NULL COMMENT 'Style',
  `qms_schedule` varchar(20) NOT NULL COMMENT 'Schedule',
  `rejected_qty` decimal(27,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_6` */

DROP TABLE IF EXISTS `view_set_6`;

CREATE TABLE `view_set_6` (
  `DATE` date NOT NULL,
  `style` varchar(60) NOT NULL,
  `SCHEDULE` varchar(60) NOT NULL,
  `color` varchar(60) NOT NULL,
  `size` varchar(60) NOT NULL,
  `cpk_qty` double DEFAULT NULL,
  `order_tid_new` varchar(240) NOT NULL DEFAULT '',
  `barcode` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_6_snap` */

DROP TABLE IF EXISTS `view_set_6_snap`;

CREATE TABLE `view_set_6_snap` (
  `DATE` date NOT NULL,
  `style` varchar(60) NOT NULL,
  `SCHEDULE` varchar(60) NOT NULL,
  `color` varchar(60) NOT NULL,
  `size` varchar(60) NOT NULL,
  `cpk_qty` double DEFAULT NULL,
  `order_tid_new` varchar(300) DEFAULT NULL,
  `barcode` varchar(20) DEFAULT NULL,
  KEY `order_tid_new` (`order_tid_new`),
  KEY `DATE` (`DATE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_6_snap_swap_2` */

DROP TABLE IF EXISTS `view_set_6_snap_swap_2`;

CREATE TABLE `view_set_6_snap_swap_2` (
  `DATE` date NOT NULL,
  `style` varchar(60) NOT NULL,
  `SCHEDULE` varchar(60) NOT NULL,
  `color` varchar(60) NOT NULL,
  `size` varchar(60) NOT NULL,
  `cpk_qty` double DEFAULT NULL,
  `order_tid_new` varchar(300) DEFAULT NULL,
  `barcode` varchar(20) DEFAULT NULL,
  KEY `order_tid_new` (`order_tid_new`),
  KEY `DATE` (`DATE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_7` */

DROP TABLE IF EXISTS `view_set_7`;

CREATE TABLE `view_set_7` (
  `ref_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_snap_1` */

DROP TABLE IF EXISTS `view_set_snap_1`;

CREATE TABLE `view_set_snap_1` (
  `bundle_transactions_20_repeat_id` bigint(11) NOT NULL DEFAULT '0',
  `bundle_transactions_20_repeat_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` bigint(11) DEFAULT NULL,
  `bundle_transactions_employee_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_date_time` datetime DEFAULT NULL,
  `tbl_orders_size_ref_size_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_size_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_order_quantity` int(6) DEFAULT NULL,
  `tbl_orders_style_ref_product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_quantity` decimal(32,0) DEFAULT NULL,
  `tbl_miniorder_data_bundle_number` int(6) DEFAULT NULL,
  `tbl_miniorder_data_color` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_mini_order_num` float(6,2) DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_size_ref_id` int(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_barcode` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `size_disp` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  `sah` double(19,2) DEFAULT NULL,
  `order_div` varchar(50) DEFAULT NULL,
  `order_date` varchar(50) DEFAULT NULL,
  `order_tid_new` text CHARACTER SET utf8,
  `tbl_module_ref_module_section` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_operation_time` datetime DEFAULT NULL,
  `view_set_2_snap_smv` varchar(50) DEFAULT NULL,
  `tbl_miniorder_data_docket_number` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_snap_1_tbl` */

DROP TABLE IF EXISTS `view_set_snap_1_tbl`;

CREATE TABLE `view_set_snap_1_tbl` (
  `bundle_transactions_20_repeat_id` bigint(11) NOT NULL DEFAULT '0',
  `bundle_transactions_20_repeat_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` bigint(11) DEFAULT NULL,
  `bundle_transactions_employee_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_date_time` datetime DEFAULT NULL,
  `tbl_orders_size_ref_size_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_size_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_order_quantity` bigint(11) DEFAULT NULL,
  `tbl_orders_style_ref_product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_quantity` decimal(32,0) DEFAULT NULL,
  `tbl_miniorder_data_bundle_number` bigint(11) DEFAULT NULL,
  `tbl_miniorder_data_color` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_mini_order_num` float(6,2) DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_size_ref_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_barcode` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `size_disp` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  `sah` double(19,2) DEFAULT NULL,
  `order_div` varchar(50) DEFAULT NULL,
  `order_date` varchar(50) DEFAULT NULL,
  `order_tid_new` varchar(300) DEFAULT NULL,
  `tbl_module_ref_module_section` varchar(15) DEFAULT NULL,
  `bundle_transactions_operation_time` datetime DEFAULT NULL,
  `view_set_2_snap_smv` float DEFAULT NULL,
  `tbl_miniorder_data_docket_number` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`bundle_transactions_20_repeat_id`),
  KEY `tbl_orders_style_ref_product_style` (`tbl_orders_style_ref_product_style`),
  KEY `tbl_orders_master_product_schedule` (`tbl_orders_master_product_schedule`),
  KEY `tbl_orders_ops_ref_operation_code` (`tbl_orders_ops_ref_operation_code`),
  KEY `size_disp` (`size_disp`),
  KEY `tbl_miniorder_data_color` (`tbl_miniorder_data_color`),
  KEY `tbl_miniorder_data_mini_order_num` (`tbl_miniorder_data_mini_order_num`),
  KEY `order_tid_new` (`order_tid_new`),
  KEY `order_id` (`order_id`(255)),
  KEY `bundle_transactions_date_time` (`bundle_transactions_date_time`),
  KEY `tbl_miniorder_data_bundle_number` (`tbl_miniorder_data_bundle_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_snap_1_tbl_swap_2` */

DROP TABLE IF EXISTS `view_set_snap_1_tbl_swap_2`;

CREATE TABLE `view_set_snap_1_tbl_swap_2` (
  `bundle_transactions_20_repeat_id` bigint(11) NOT NULL DEFAULT '0',
  `bundle_transactions_20_repeat_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` bigint(11) DEFAULT NULL,
  `bundle_transactions_employee_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_date_time` datetime DEFAULT NULL,
  `tbl_orders_size_ref_size_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_size_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_order_quantity` bigint(11) DEFAULT NULL,
  `tbl_orders_style_ref_product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_quantity` decimal(32,0) DEFAULT NULL,
  `tbl_miniorder_data_bundle_number` bigint(11) DEFAULT NULL,
  `tbl_miniorder_data_color` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_mini_order_num` float(6,2) DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_size_ref_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_barcode` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `size_disp` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  `sah` double(19,2) DEFAULT NULL,
  `order_div` varchar(50) DEFAULT NULL,
  `order_date` varchar(50) DEFAULT NULL,
  `order_tid_new` varchar(300) DEFAULT NULL,
  `tbl_module_ref_module_section` varchar(15) DEFAULT NULL,
  `bundle_transactions_operation_time` datetime DEFAULT NULL,
  `view_set_2_snap_smv` float DEFAULT NULL,
  `tbl_miniorder_data_docket_number` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`bundle_transactions_20_repeat_id`),
  KEY `tbl_orders_style_ref_product_style` (`tbl_orders_style_ref_product_style`),
  KEY `tbl_orders_master_product_schedule` (`tbl_orders_master_product_schedule`),
  KEY `tbl_orders_ops_ref_operation_code` (`tbl_orders_ops_ref_operation_code`),
  KEY `size_disp` (`size_disp`),
  KEY `tbl_miniorder_data_color` (`tbl_miniorder_data_color`),
  KEY `tbl_miniorder_data_mini_order_num` (`tbl_miniorder_data_mini_order_num`),
  KEY `order_tid_new` (`order_tid_new`),
  KEY `order_id` (`order_id`(255)),
  KEY `bundle_transactions_date_time` (`bundle_transactions_date_time`),
  KEY `tbl_miniorder_data_bundle_number` (`tbl_miniorder_data_bundle_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_virtual_repeat` */

DROP TABLE IF EXISTS `view_virtual_repeat`;

CREATE TABLE `view_virtual_repeat` (
  `id` int(1) NOT NULL DEFAULT '0',
  `parent_id` int(1) NOT NULL DEFAULT '0',
  `bundle_barcode` int(6) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `bundle_id` int(6) DEFAULT NULL,
  `operation_id` int(1) NOT NULL DEFAULT '0',
  `rejection_quantity` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `vj5ax_assets` */

DROP TABLE IF EXISTS `vj5ax_assets`;

CREATE TABLE `vj5ax_assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `level` int(10) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_associations` */

DROP TABLE IF EXISTS `vj5ax_associations`;

CREATE TABLE `vj5ax_associations` (
  `id` varchar(50) NOT NULL COMMENT 'A reference to the associated item.',
  `context` varchar(50) NOT NULL COMMENT 'The context of the associated item.',
  `key` char(32) NOT NULL COMMENT 'The key for the association computed from an md5 on associated ids.',
  PRIMARY KEY (`context`,`id`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_banner_clients` */

DROP TABLE IF EXISTS `vj5ax_banner_clients`;

CREATE TABLE `vj5ax_banner_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `extrainfo` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metakey` text NOT NULL,
  `own_prefix` tinyint(4) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_banner_tracks` */

DROP TABLE IF EXISTS `vj5ax_banner_tracks`;

CREATE TABLE `vj5ax_banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_banners` */

DROP TABLE IF EXISTS `vj5ax_banners`;

CREATE TABLE `vj5ax_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `clickurl` varchar(200) NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(255) NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_categories` */

DROP TABLE IF EXISTS `vj5ax_categories`;

CREATE TABLE `vj5ax_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '',
  `extension` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `metadesc` varchar(1024) NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_contact_details` */

DROP TABLE IF EXISTS `vj5ax_contact_details`;

CREATE TABLE `vj5ax_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `con_position` varchar(255) DEFAULT NULL,
  `address` text,
  `suburb` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postcode` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `misc` mediumtext,
  `image` varchar(255) DEFAULT NULL,
  `imagepos` varchar(20) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `webpage` varchar(255) NOT NULL DEFAULT '',
  `sortname1` varchar(255) NOT NULL,
  `sortname2` varchar(255) NOT NULL,
  `sortname3` varchar(255) NOT NULL,
  `language` char(7) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_content` */

DROP TABLE IF EXISTS `vj5ax_content`;

CREATE TABLE `vj5ax_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `title_alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'Deprecated in Joomla! 3.0',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `sectionid` int(10) unsigned NOT NULL DEFAULT '0',
  `mask` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` varchar(5120) NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_content_frontpage` */

DROP TABLE IF EXISTS `vj5ax_content_frontpage`;

CREATE TABLE `vj5ax_content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_content_rating` */

DROP TABLE IF EXISTS `vj5ax_content_rating`;

CREATE TABLE `vj5ax_content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(10) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_core_log_searches` */

DROP TABLE IF EXISTS `vj5ax_core_log_searches`;

CREATE TABLE `vj5ax_core_log_searches` (
  `search_term` varchar(128) NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_extensions` */

DROP TABLE IF EXISTS `vj5ax_extensions`;

CREATE TABLE `vj5ax_extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `access` int(10) unsigned NOT NULL DEFAULT '1',
  `protected` tinyint(3) NOT NULL DEFAULT '0',
  `manifest_cache` text NOT NULL,
  `params` text NOT NULL,
  `custom_data` text NOT NULL,
  `system_data` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT '0',
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_connections` */

DROP TABLE IF EXISTS `vj5ax_fabrik_connections`;

CREATE TABLE `vj5ax_fabrik_connections` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `host` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `database` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `checked_out` int(4) NOT NULL,
  `checked_out_time` datetime DEFAULT NULL,
  `default` int(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_cron` */

DROP TABLE IF EXISTS `vj5ax_fabrik_cron`;

CREATE TABLE `vj5ax_fabrik_cron` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `frequency` smallint(6) NOT NULL,
  `unit` varchar(15) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(6) NOT NULL,
  `created_by_alias` varchar(30) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` varchar(30) NOT NULL,
  `checked_out` int(6) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `plugin` varchar(50) NOT NULL,
  `lastrun` datetime NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_elements` */

DROP TABLE IF EXISTS `vj5ax_fabrik_elements`;

CREATE TABLE `vj5ax_fabrik_elements` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `group_id` int(4) NOT NULL,
  `plugin` varchar(100) NOT NULL,
  `label` text,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_alias` varchar(100) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL DEFAULT '0',
  `default` text NOT NULL,
  `hidden` int(1) NOT NULL,
  `eval` int(1) NOT NULL,
  `ordering` int(4) NOT NULL,
  `show_in_list_summary` int(1) DEFAULT NULL,
  `filter_type` varchar(20) DEFAULT NULL,
  `filter_exact_match` int(1) DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `link_to_detail` int(1) NOT NULL DEFAULT '0',
  `primary_key` int(1) NOT NULL DEFAULT '0',
  `auto_increment` int(1) NOT NULL DEFAULT '0',
  `access` int(1) NOT NULL DEFAULT '0',
  `use_in_page_title` int(1) NOT NULL DEFAULT '0',
  `parent_id` mediumint(6) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_form_sessions` */

DROP TABLE IF EXISTS `vj5ax_fabrik_form_sessions`;

CREATE TABLE `vj5ax_fabrik_form_sessions` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) NOT NULL,
  `user_id` int(6) NOT NULL,
  `form_id` int(6) NOT NULL,
  `row_id` int(10) NOT NULL,
  `last_page` int(4) NOT NULL,
  `referring_url` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `time_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_formgroup` */

DROP TABLE IF EXISTS `vj5ax_fabrik_formgroup`;

CREATE TABLE `vj5ax_fabrik_formgroup` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `form_id` int(4) NOT NULL,
  `group_id` int(4) NOT NULL,
  `ordering` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_forms` */

DROP TABLE IF EXISTS `vj5ax_fabrik_forms`;

CREATE TABLE `vj5ax_fabrik_forms` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `record_in_database` int(4) NOT NULL,
  `error` varchar(150) NOT NULL,
  `intro` text NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_alias` varchar(100) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `publish_up` datetime DEFAULT NULL,
  `publish_down` datetime DEFAULT NULL,
  `reset_button_label` varchar(100) NOT NULL,
  `submit_button_label` varchar(100) NOT NULL,
  `form_template` varchar(255) DEFAULT NULL,
  `view_only_template` varchar(255) DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_groups` */

DROP TABLE IF EXISTS `vj5ax_fabrik_groups`;

CREATE TABLE `vj5ax_fabrik_groups` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `css` text NOT NULL,
  `label` varchar(100) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_alias` varchar(100) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `is_join` int(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_joins` */

DROP TABLE IF EXISTS `vj5ax_fabrik_joins`;

CREATE TABLE `vj5ax_fabrik_joins` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `list_id` int(6) NOT NULL,
  `element_id` int(6) NOT NULL,
  `join_from_table` varchar(255) NOT NULL,
  `table_join` varchar(255) NOT NULL,
  `table_key` varchar(255) NOT NULL,
  `table_join_key` varchar(255) NOT NULL,
  `join_type` varchar(255) NOT NULL,
  `group_id` int(10) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_jsactions` */

DROP TABLE IF EXISTS `vj5ax_fabrik_jsactions`;

CREATE TABLE `vj5ax_fabrik_jsactions` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `element_id` int(10) NOT NULL,
  `action` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_lists` */

DROP TABLE IF EXISTS `vj5ax_fabrik_lists`;

CREATE TABLE `vj5ax_fabrik_lists` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `introduction` text NOT NULL,
  `form_id` int(4) NOT NULL,
  `db_table_name` varchar(255) NOT NULL,
  `db_primary_key` varchar(255) NOT NULL,
  `auto_inc` int(1) NOT NULL,
  `connection_id` int(6) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(4) NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(4) NOT NULL,
  `checked_out` int(4) NOT NULL,
  `checked_out_time` datetime DEFAULT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  `publish_up` datetime DEFAULT NULL,
  `publish_down` datetime DEFAULT NULL,
  `access` int(4) NOT NULL,
  `hits` int(4) NOT NULL,
  `rows_per_page` int(5) NOT NULL,
  `template` varchar(255) NOT NULL,
  `order_by` varchar(255) NOT NULL,
  `order_dir` varchar(255) NOT NULL DEFAULT 'ASC',
  `filter_action` varchar(30) NOT NULL,
  `group_by` varchar(255) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_log` */

DROP TABLE IF EXISTS `vj5ax_fabrik_log`;

CREATE TABLE `vj5ax_fabrik_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `timedate_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flag` smallint(3) NOT NULL,
  `referring_url` varchar(255) NOT NULL,
  `message_source` varchar(255) NOT NULL,
  `message_type` char(60) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_packages` */

DROP TABLE IF EXISTS `vj5ax_fabrik_packages`;

CREATE TABLE `vj5ax_fabrik_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `external_ref` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `component_name` varchar(100) NOT NULL,
  `version` varchar(10) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `checked_out` int(4) NOT NULL,
  `checked_out_time` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(6) NOT NULL,
  `template` varchar(255) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_validations` */

DROP TABLE IF EXISTS `vj5ax_fabrik_validations`;

CREATE TABLE `vj5ax_fabrik_validations` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `element_id` int(4) NOT NULL,
  `validation_plugin` varchar(100) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `client_side_validation` int(1) NOT NULL DEFAULT '0',
  `checked_out` int(4) NOT NULL,
  `checked_out_time` datetime DEFAULT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_fabrik_visualizations` */

DROP TABLE IF EXISTS `vj5ax_fabrik_visualizations`;

CREATE TABLE `vj5ax_fabrik_visualizations` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `plugin` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `intro_text` text NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_by_alias` varchar(100) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `published` int(1) NOT NULL,
  `access` int(6) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_filters` */

DROP TABLE IF EXISTS `vj5ax_finder_filters`;

CREATE TABLE `vj5ax_finder_filters` (
  `filter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `map_count` int(10) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `params` mediumtext,
  PRIMARY KEY (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links` */

DROP TABLE IF EXISTS `vj5ax_finder_links`;

CREATE TABLE `vj5ax_finder_links` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `indexdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `md5sum` varchar(32) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `state` int(5) DEFAULT '1',
  `access` int(5) DEFAULT '0',
  `language` varchar(8) NOT NULL,
  `publish_start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `list_price` double unsigned NOT NULL DEFAULT '0',
  `sale_price` double unsigned NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `object` mediumblob NOT NULL,
  PRIMARY KEY (`link_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_title` (`title`),
  KEY `idx_md5` (`md5sum`),
  KEY `idx_url` (`url`(75)),
  KEY `idx_published_list` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`list_price`),
  KEY `idx_published_sale` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`sale_price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms0` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms0`;

CREATE TABLE `vj5ax_finder_links_terms0` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms1` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms1`;

CREATE TABLE `vj5ax_finder_links_terms1` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms2` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms2`;

CREATE TABLE `vj5ax_finder_links_terms2` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms3` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms3`;

CREATE TABLE `vj5ax_finder_links_terms3` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms4` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms4`;

CREATE TABLE `vj5ax_finder_links_terms4` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms5` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms5`;

CREATE TABLE `vj5ax_finder_links_terms5` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms6` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms6`;

CREATE TABLE `vj5ax_finder_links_terms6` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms7` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms7`;

CREATE TABLE `vj5ax_finder_links_terms7` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms8` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms8`;

CREATE TABLE `vj5ax_finder_links_terms8` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_terms9` */

DROP TABLE IF EXISTS `vj5ax_finder_links_terms9`;

CREATE TABLE `vj5ax_finder_links_terms9` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_termsa` */

DROP TABLE IF EXISTS `vj5ax_finder_links_termsa`;

CREATE TABLE `vj5ax_finder_links_termsa` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_termsb` */

DROP TABLE IF EXISTS `vj5ax_finder_links_termsb`;

CREATE TABLE `vj5ax_finder_links_termsb` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_termsc` */

DROP TABLE IF EXISTS `vj5ax_finder_links_termsc`;

CREATE TABLE `vj5ax_finder_links_termsc` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_termsd` */

DROP TABLE IF EXISTS `vj5ax_finder_links_termsd`;

CREATE TABLE `vj5ax_finder_links_termsd` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_termse` */

DROP TABLE IF EXISTS `vj5ax_finder_links_termse`;

CREATE TABLE `vj5ax_finder_links_termse` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_links_termsf` */

DROP TABLE IF EXISTS `vj5ax_finder_links_termsf`;

CREATE TABLE `vj5ax_finder_links_termsf` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_taxonomy` */

DROP TABLE IF EXISTS `vj5ax_finder_taxonomy`;

CREATE TABLE `vj5ax_finder_taxonomy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `state` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `state` (`state`),
  KEY `ordering` (`ordering`),
  KEY `access` (`access`),
  KEY `idx_parent_published` (`parent_id`,`state`,`access`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_taxonomy_map` */

DROP TABLE IF EXISTS `vj5ax_finder_taxonomy_map`;

CREATE TABLE `vj5ax_finder_taxonomy_map` (
  `link_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`node_id`),
  KEY `link_id` (`link_id`),
  KEY `node_id` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_terms` */

DROP TABLE IF EXISTS `vj5ax_finder_terms`;

CREATE TABLE `vj5ax_finder_terms` (
  `term_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '0',
  `soundex` varchar(75) NOT NULL,
  `links` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `idx_term` (`term`),
  KEY `idx_term_phrase` (`term`,`phrase`),
  KEY `idx_stem_phrase` (`stem`,`phrase`),
  KEY `idx_soundex_phrase` (`soundex`,`phrase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_terms_common` */

DROP TABLE IF EXISTS `vj5ax_finder_terms_common`;

CREATE TABLE `vj5ax_finder_terms_common` (
  `term` varchar(75) NOT NULL,
  `language` varchar(3) NOT NULL,
  KEY `idx_word_lang` (`term`,`language`),
  KEY `idx_lang` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_tokens` */

DROP TABLE IF EXISTS `vj5ax_finder_tokens`;

CREATE TABLE `vj5ax_finder_tokens` (
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '1',
  `context` tinyint(1) unsigned NOT NULL DEFAULT '2',
  KEY `idx_word` (`term`),
  KEY `idx_context` (`context`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_tokens_aggregate` */

DROP TABLE IF EXISTS `vj5ax_finder_tokens_aggregate`;

CREATE TABLE `vj5ax_finder_tokens_aggregate` (
  `term_id` int(10) unsigned NOT NULL,
  `map_suffix` char(1) NOT NULL,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `term_weight` float unsigned NOT NULL,
  `context` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `context_weight` float unsigned NOT NULL,
  `total_weight` float unsigned NOT NULL,
  KEY `token` (`term`),
  KEY `keyword_id` (`term_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_finder_types` */

DROP TABLE IF EXISTS `vj5ax_finder_types`;

CREATE TABLE `vj5ax_finder_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `mime` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_languages` */

DROP TABLE IF EXISTS `vj5ax_languages`;

CREATE TABLE `vj5ax_languages` (
  `lang_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `sitename` varchar(1024) NOT NULL DEFAULT '',
  `published` int(11) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  UNIQUE KEY `idx_image` (`image`),
  UNIQUE KEY `idx_langcode` (`lang_code`),
  KEY `idx_access` (`access`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_menu` */

DROP TABLE IF EXISTS `vj5ax_menu`;

CREATE TABLE `vj5ax_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The published state of the menu link.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__extensions.id',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'The relative ordering of the menu item in the tree.',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The click behaviour of the link.',
  `access` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `home` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) NOT NULL DEFAULT '',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`,`language`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_path` (`path`(255)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_menu_types` */

DROP TABLE IF EXISTS `vj5ax_menu_types`;

CREATE TABLE `vj5ax_menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) NOT NULL,
  `title` varchar(48) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_messages` */

DROP TABLE IF EXISTS `vj5ax_messages`;

CREATE TABLE `vj5ax_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_messages_cfg` */

DROP TABLE IF EXISTS `vj5ax_messages_cfg`;

CREATE TABLE `vj5ax_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) NOT NULL DEFAULT '',
  `cfg_value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_modules` */

DROP TABLE IF EXISTS `vj5ax_modules`;

CREATE TABLE `vj5ax_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `note` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) NOT NULL DEFAULT '',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) DEFAULT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_modules_menu` */

DROP TABLE IF EXISTS `vj5ax_modules_menu`;

CREATE TABLE `vj5ax_modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_newsfeeds` */

DROP TABLE IF EXISTS `vj5ax_newsfeeds`;

CREATE TABLE `vj5ax_newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `link` varchar(200) NOT NULL DEFAULT '',
  `filename` varchar(200) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(10) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(10) unsigned NOT NULL DEFAULT '3600',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rtl` tinyint(4) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_overrider` */

DROP TABLE IF EXISTS `vj5ax_overrider`;

CREATE TABLE `vj5ax_overrider` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `constant` varchar(255) NOT NULL,
  `string` text NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_redirect_links` */

DROP TABLE IF EXISTS `vj5ax_redirect_links`;

CREATE TABLE `vj5ax_redirect_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_url` varchar(255) NOT NULL,
  `new_url` varchar(255) NOT NULL,
  `referer` varchar(150) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_link_old` (`old_url`),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_schemas` */

DROP TABLE IF EXISTS `vj5ax_schemas`;

CREATE TABLE `vj5ax_schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) NOT NULL,
  PRIMARY KEY (`extension_id`,`version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_session` */

DROP TABLE IF EXISTS `vj5ax_session`;

CREATE TABLE `vj5ax_session` (
  `session_id` varchar(200) NOT NULL DEFAULT '',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `guest` tinyint(4) unsigned DEFAULT '1',
  `time` varchar(14) DEFAULT '',
  `data` mediumtext,
  `userid` int(11) DEFAULT '0',
  `username` varchar(150) DEFAULT '',
  `usertype` varchar(50) DEFAULT '',
  PRIMARY KEY (`session_id`),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_template_styles` */

DROP TABLE IF EXISTS `vj5ax_template_styles`;

CREATE TABLE `vj5ax_template_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(50) NOT NULL DEFAULT '',
  `client_id` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `home` char(7) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_home` (`home`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_update_categories` */

DROP TABLE IF EXISTS `vj5ax_update_categories`;

CREATE TABLE `vj5ax_update_categories` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '',
  `description` text NOT NULL,
  `parent` int(11) DEFAULT '0',
  `updatesite` int(11) DEFAULT '0',
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Update Categories';

/*Table structure for table `vj5ax_update_sites` */

DROP TABLE IF EXISTS `vj5ax_update_sites`;

CREATE TABLE `vj5ax_update_sites` (
  `update_site_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `location` text NOT NULL,
  `enabled` int(11) DEFAULT '0',
  `last_check_timestamp` bigint(20) DEFAULT '0',
  PRIMARY KEY (`update_site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Update Sites';

/*Table structure for table `vj5ax_update_sites_extensions` */

DROP TABLE IF EXISTS `vj5ax_update_sites_extensions`;

CREATE TABLE `vj5ax_update_sites_extensions` (
  `update_site_id` int(11) NOT NULL DEFAULT '0',
  `extension_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`update_site_id`,`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Links extensions to update sites';

/*Table structure for table `vj5ax_updates` */

DROP TABLE IF EXISTS `vj5ax_updates`;

CREATE TABLE `vj5ax_updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `update_site_id` int(11) DEFAULT '0',
  `extension_id` int(11) DEFAULT '0',
  `categoryid` int(11) DEFAULT '0',
  `name` varchar(100) DEFAULT '',
  `description` text NOT NULL,
  `element` varchar(100) DEFAULT '',
  `type` varchar(20) DEFAULT '',
  `folder` varchar(20) DEFAULT '',
  `client_id` tinyint(3) DEFAULT '0',
  `version` varchar(10) DEFAULT '',
  `data` text NOT NULL,
  `detailsurl` text NOT NULL,
  `infourl` text NOT NULL,
  PRIMARY KEY (`update_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Available Updates';

/*Table structure for table `vj5ax_user_notes` */

DROP TABLE IF EXISTS `vj5ax_user_notes`;

CREATE TABLE `vj5ax_user_notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(100) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_user_profiles` */

DROP TABLE IF EXISTS `vj5ax_user_profiles`;

CREATE TABLE `vj5ax_user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Simple user profile storage table';

/*Table structure for table `vj5ax_user_usergroup_map` */

DROP TABLE IF EXISTS `vj5ax_user_usergroup_map`;

CREATE TABLE `vj5ax_user_usergroup_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_usergroups` */

DROP TABLE IF EXISTS `vj5ax_usergroups`;

CREATE TABLE `vj5ax_usergroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` (`lft`,`rgt`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_users` */

DROP TABLE IF EXISTS `vj5ax_users`;

CREATE TABLE `vj5ax_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL DEFAULT '0' COMMENT 'Count of password resets since lastResetTime',
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_viewlevels` */

DROP TABLE IF EXISTS `vj5ax_viewlevels`;

CREATE TABLE `vj5ax_viewlevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `vj5ax_weblinks` */

DROP TABLE IF EXISTS `vj5ax_weblinks`;

CREATE TABLE `vj5ax_weblinks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `sid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `access` int(11) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if link is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Function  structure for function  `fn_bai_mini_cumulative` */

/*!50003 DROP FUNCTION IF EXISTS `fn_bai_mini_cumulative` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `fn_bai_mini_cumulative`(in_order_id varchar(300),in_mini_order_num int) RETURNS int(11)
BEGIN
declare retval int;
set retval=(SELECT SUM(tbl_miniorder_data_quantity) FROM `view_set_3_snap` b WHERE b.order_id=in_order_id AND b.tbl_miniorder_data_mini_order_num<=in_mini_order_num);
return retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_bai_pro3_sch_details` */

/*!50003 DROP FUNCTION IF EXISTS `fn_bai_pro3_sch_details` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`baiall`@`%` FUNCTION `fn_bai_pro3_sch_details`(scheduleno int,rettype varchar(30)) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
    
     IF (rettype="orderdiv") THEN
	set retval=(SELECT max(order_div) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno );
end if;
 
IF (rettype="orderdate") THEN
		set retval=(SELECT max(order_date) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno );
end if;
	IF (rettype="smv") THEN
		set retval=(SELECT cast(max(smv) AS decimal(11,2)) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno);
	
	END IF;
   
    return retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_bai_pro3_smv_details` */

/*!50003 DROP FUNCTION IF EXISTS `fn_bai_pro3_smv_details` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`baiall`@`%` FUNCTION `fn_bai_pro3_smv_details`(scheduleno INT,color VARCHAR(100)) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
    
   SET retval=(SELECT CAST(MAX(smv) AS DECIMAL(11,3)) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno and order_col_des=color);
	
   
    RETURN retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_know_size_title` */

/*!50003 DROP FUNCTION IF EXISTS `fn_know_size_title` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `fn_know_size_title`(order_id int,color_code varchar(300),size_id int) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    declare retval varchar(50);
	
	set retval=(SELECT IF(LENGTH(size_title)=0,size_name,size_title) FROM `tbl_orders_sizes_master` 
LEFT JOIN tbl_orders_master ON tbl_orders_master.id=tbl_orders_sizes_master.parent_id
LEFT JOIN tbl_orders_style_ref ON tbl_orders_master.ref_product_style=tbl_orders_style_ref.id
LEFT JOIN `tbl_orders_size_ref` ON tbl_orders_size_ref.id=tbl_orders_sizes_master.ref_size_name
where parent_id=order_id and order_col_des=color_code and ref_size_name=size_id);
	return retval;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `bts_to_sfcs_sync` */

/*!50003 DROP PROCEDURE IF EXISTS  `bts_to_sfcs_sync` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`baiall`@`%` PROCEDURE `bts_to_sfcs_sync`(filterlimit bigint)
BEGIN
	  DECLARE done INT DEFAULT FALSE;
	  DECLARE var_bts_tran_id,var_sync_bundle_id,var_sycn_operation_id,var_sync_operaiton_code,var_sync_rep_id bigint;
	  declare rowcount,var_case_tag,var_nop int;
	  declare tblsnap,var_size_name,var_date_team,var_team varchar(255);
	
	
	  
	  
	
	  DECLARE cur1 CURSOR FOR SELECT bts_tran_id,sync_bundle_id,sync_operation_id,sync_operation_code,sync_rep_id FROM bts_to_sfcs_sync where sync_status=0 and sync_rep_id<=filterlimit  ORDER BY bts_tran_id;
	
	  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	  OPEN cur1;
	 
	  read_loop: LOOP
	    FETCH cur1 INTO var_bts_tran_id,var_sync_bundle_id,var_sycn_operation_id,var_sync_operaiton_code,var_sync_rep_id;
	    
	    IF done THEN
	      LEAVE read_loop;
	    END IF;
	    
	    set @tblsnap=(select 0_tbl_snap from `snap_session_track` where session_id=1);
	    set @var_case_tag=(var_sycn_operation_id*10)+var_sync_operaiton_code;
	    
	    SET @var_size_name='';
	    if @tblsnap='view_set_snap_1_tbl_swap_2' then
	    
		
		set @var_size_name=(select tbl_orders_size_ref_size_name from view_set_snap_1_tbl_swap_2 where `bundle_transactions_20_repeat_id`=var_sync_rep_id and `bundle_transactions_20_repeat_operation_id` in (3,4) limit 1);
		
		
		
		if var_sycn_operation_id=4 then
			SET @var_date_team=(SELECT concat(date(bundle_transactions_date_time),bundle_transactions_20_repeat_act_module) FROM view_set_snap_1_tbl_swap_2 WHERE `bundle_transactions_20_repeat_id`=var_sync_rep_id LIMIT 1);
			SET @var_team=(SELECT tbl_shifts_master_shift_name FROM view_set_snap_1_tbl_swap_2 WHERE `bundle_transactions_20_repeat_id`=var_sync_rep_id LIMIT 1);
		end if;	
	    else
		
		
		SET @var_size_name=(SELECT tbl_orders_size_ref_size_name FROM view_set_snap_1_tbl WHERE `bundle_transactions_20_repeat_id`=var_sync_rep_id AND `bundle_transactions_20_repeat_operation_id` IN (3,4) LIMIT 1);
		
		
		
		IF var_sycn_operation_id=4 THEN
			SET @var_date_team=(SELECT CONCAT(DATE(bundle_transactions_date_time),bundle_transactions_20_repeat_act_module) FROM view_set_snap_1_tbl WHERE `bundle_transactions_20_repeat_id`=var_sync_rep_id LIMIT 1);
			SET @var_team=(SELECT tbl_shifts_master_shift_name FROM view_set_snap_1_tbl WHERE `bundle_transactions_20_repeat_id`=var_sync_rep_id LIMIT 1);
		END IF;	
	    end if;
	    
	if length(@var_size_name)<>0 then
	   
	   if @var_case_tag=30 then
		
		
		SET @query = CONCAT('insert into bai_pro3.ims_log (rand_track,ims_qty,ims_shift,
		ims_mod_no,ims_date,ims_size,ims_style,ims_color,ims_schedule,ims_cid,
		ims_doc_no,bai_pro_ref) select bundle_transactions_20_repeat_id,bundle_transactions_20_repeat_quantity,
		tbl_shifts_master_shift_name,bundle_transactions_20_repeat_act_module,bundle_transactions_date_time,
		concat(''a_'',tbl_orders_size_ref_size_name),tbl_orders_style_ref_product_style,tbl_miniorder_data_color,
		tbl_orders_master_product_schedule,order_tid_new,tbl_miniorder_data_docket_number,tbl_miniorder_data_bundle_number 
		from ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		
		SET @query = CONCAT('INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift)  
		select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,
		tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_quantity,USER(),''SIN'',bundle_transactions_20_repeat_id,
		bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name from ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		update `bts_to_sfcs_sync` SET `sync_status`=1 where `bts_tran_id`=var_bts_tran_id;
	   END IF;
	   
	   IF @var_case_tag=31 THEN
		
		
		
		SET @query = CONCAT('UPDATE bai_pro3.ims_log SET ims_qty=(SELECT bundle_transactions_20_repeat_quantity FROM ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id,') where rand_track=',var_sync_rep_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		
		
		SET @query = CONCAT('INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) 
		select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,
		tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_rejection_quantity*-1,USER(),''SIN'',bundle_transactions_20_repeat_id,
		bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name from ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		UPDATE `bts_to_sfcs_sync` SET `sync_status`=1 WHERE `bts_tran_id`=var_bts_tran_id;
	   END IF;
	   
	   
	   
	   IF @var_case_tag=40 THEN
		
		
		SET @var_nop=0;
		
		
		if @var_team='A' then
		
			SET @var_nop=(select coalesce(avail_A,0) from bai_pro.pro_atten where atten_id=@var_date_team);
		else
			SET @var_nop=(SELECT COALESCE(avail_B,0) FROM bai_pro.pro_atten WHERE atten_id=@var_date_team);
		end if; 
		
		if @var_nop is null then
			set @var_nop=0;
		end if;
		
		SET @query = CONCAT('insert into bai_pro.bai_log (bac_Qty,bac_shift,bac_no,size_xs,bac_style,
		color,delivery,buyer,bac_sec,bac_lastup,smv,ims_doc_no,ims_tid,bac_date,size_',@var_size_name,',nop
) select bundle_transactions_20_repeat_quantity,tbl_shifts_master_shift_name,
		bundle_transactions_20_repeat_act_module,tbl_orders_size_ref_size_name,tbl_orders_style_ref_product_style,
		tbl_miniorder_data_color,tbl_orders_master_product_schedule,order_div,tbl_module_ref_module_section,
		bundle_transactions_date_time,view_set_2_snap_smv,tbl_miniorder_data_docket_number,
		bundle_transactions_20_repeat_id,bundle_transactions_date_time,bundle_transactions_20_repeat_quantity,',@var_nop,'
		from ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		SET @query = CONCAT('insert into bai_pro.bai_log_buf (bac_Qty,bac_shift,bac_no,size_xs,bac_style,
		color,delivery,buyer,bac_sec,bac_lastup,smv,ims_doc_no,ims_tid,bac_date,size_',@var_size_name,'
) select bundle_transactions_20_repeat_quantity,tbl_shifts_master_shift_name,
		bundle_transactions_20_repeat_act_module,tbl_orders_size_ref_size_name,tbl_orders_style_ref_product_style,
		tbl_miniorder_data_color,tbl_orders_master_product_schedule,order_div,tbl_module_ref_module_section,
		bundle_transactions_date_time,view_set_2_snap_smv,tbl_miniorder_data_docket_number,
		bundle_transactions_20_repeat_id,bundle_transactions_date_time,bundle_transactions_20_repeat_quantity
		from ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		
		SET @query = CONCAT('UPDATE bai_pro3.ims_log SET ims_status=''DONE'',ims_pro_qty=(SELECT bundle_transactions_20_repeat_quantity FROM ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id,') where bai_pro_ref=',var_sync_bundle_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		
		SET @query = CONCAT('INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift)  
		select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,
		tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_quantity,USER(),''SOT'',bundle_transactions_20_repeat_id,
		bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name from ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		UPDATE `bts_to_sfcs_sync` SET `sync_status`=1 WHERE `bts_tran_id`=var_bts_tran_id;
		
	   END IF;
	   
	   IF @var_case_tag=41 THEN
		
		
		SET @query = CONCAT('UPDATE bai_pro3.ims_log SET ims_status=''DONE'',ims_pro_qty=(SELECT bundle_transactions_20_repeat_quantity FROM ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id,') where bai_pro_ref=',var_sync_bundle_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		SET @query = CONCAT('UPDATE bai_pro.bai_log SET 
		bac_qty=(SELECT bundle_transactions_20_repeat_quantity FROM ',@tblsnap,' 
		where bundle_transactions_20_repeat_id=',var_sync_rep_id,'),
		size_',@var_size_name,'=(SELECT bundle_transactions_20_repeat_quantity FROM ',@tblsnap,' 
		where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id,') where ims_tid=',var_sync_rep_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		SET @query = CONCAT('UPDATE bai_pro.bai_log_buf SET 
		bac_qty=(SELECT bundle_transactions_20_repeat_quantity FROM ',@tblsnap,' 
		where bundle_transactions_20_repeat_id=',var_sync_rep_id,'),
		size_',@var_size_name,'=(SELECT bundle_transactions_20_repeat_quantity FROM ',@tblsnap,' 
		where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id,') where ims_tid=',var_sync_rep_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		
		SET @query = CONCAT('INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) 
		select NOW(),tbl_orders_style_ref_product_style,tbl_orders_master_product_schedule,tbl_miniorder_data_color,tbl_orders_size_ref_size_name,
		tbl_miniorder_data_docket_number,bundle_transactions_20_repeat_rejection_quantity*-1,USER(),''SOT'',bundle_transactions_20_repeat_id,
		bundle_transactions_20_repeat_act_module,tbl_shifts_master_shift_name from ',@tblsnap,' where bundle_transactions_20_repeat_id=',var_sync_rep_id,' and bundle_transactions_20_repeat_operation_id=',var_sycn_operation_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		
		UPDATE `bts_to_sfcs_sync` SET `sync_status`=1 WHERE `bts_tran_id`=var_bts_tran_id;
		
	   END IF;
	   
	   
	 
	  
	END IF;
	
	  IF @var_case_tag=32 THEN
		
		
		DELETE FROM bai_pro3.ims_log WHERE rand_track=var_sync_rep_id;
		
		
		SET @query = CONCAT('INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) 
		select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty*-1,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref=',var_sync_rep_id,' and m3_op_des=''SIN'' and sfcs_reason=''''');
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		UPDATE `bts_to_sfcs_sync` SET `sync_status`=1 WHERE `bts_tran_id`=var_bts_tran_id;
	   END IF;
	   
	    IF @var_case_tag=42 THEN
		
		
		SET @query = CONCAT('UPDATE bai_pro3.ims_log SET ims_status='''',ims_pro_qty=0 where bai_pro_ref=',var_sync_bundle_id);
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		DELETE FROM bai_pro.bai_log WHERE ims_tid=var_sync_rep_id;
		DELETE FROM bai_pro.bai_log_buf WHERE ims_tid=var_sync_rep_id;
		
		
		SET @query = CONCAT('INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) 
		select sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty*-1,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift from m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref=',var_sync_rep_id,' and m3_op_des=''SOT'' and sfcs_reason=''''');
		PREPARE stmt FROM @query;
		EXECUTE stmt;
		DEALLOCATE PREPARE stmt;
		
		UPDATE `bts_to_sfcs_sync` SET `sync_status`=1 WHERE `bts_tran_id`=var_bts_tran_id;
	   END IF;
	   
	
	  END LOOP;
	  CLOSE cur1;
	 
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_snap_view` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_snap_view` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`baiall`@`%` PROCEDURE `sp_snap_view`()
BEGIN
	DECLARE swap_status_val VARCHAR(100);
	DECLARE swap_session_status VARCHAR(100);
	
	DECLARE hoursdiff bigint;
	declare resetflag varchar(3);
	
	declare count1 bigint;
	DECLARE count2 BIGINT;
	DECLARE count3 BIGINT;
	DECLARE count4 BIGINT;
	DECLARE count5 BIGINT;
	DECLARE count6 BIGINT;
	DECLARE count1_snap BIGINT;
	
	SET sql_log_bin = 0;
	
	SET @swap_status_val=(SELECT swap_status FROM snap_session_track WHERE session_id=1);
	SET @swap_session_status=(SELECT session_status FROM snap_session_track WHERE session_id=1);
	
	
	set @hoursdiff=(SELECT (TIMESTAMPDIFF(MINUTE,time_stamp,NOW())) as hrsdff FROM `snap_session_track`  WHERE session_id=1);
	
	if(@hoursdiff>=40) then
		SET @resetflag='YES';
		UPDATE snap_session_track SET session_status='off',swap_status='reset' WHERE session_id=1;
	else
		SET @resetflag='NO';
	end if;
	
	if(@swap_session_status='off') then	
	
		UPDATE snap_session_track SET session_status='on',swap_status='_swap_2',1_snap='view_set_1_snap_swap_2',2_snap='view_set_2_snap_swap_2',3_snap='view_set_3_snap_swap_2',4_snap='view_set_4_snap_swap_2',5_snap='view_set_5_snap_swap_2',6_snap='view_set_6_snap_swap_2',0_tbl_snap='view_set_snap_1_tbl_swap_2',time_stamp=(SELECT MAX(bundle_transactions_date_time) FROM `view_set_1_snap_swap_2`) WHERE session_id=1;
	
		truncate table `view_set_1_snap`;
		truncate table `view_set_2_snap`;
		truncate table `view_set_3_snap`;
		truncate table `view_set_4_snap`;
		truncate table `view_set_5_snap`;
		truncate table `view_set_6_snap`;
		truncate table `view_set_snap_1_tbl`;
		
		SET @count1=(SELECT COUNT(*) FROM view_set_1_snap);
		SET @count2=(SELECT COUNT(*) FROM view_set_2_snap);
		SET @count3=(SELECT COUNT(*) FROM view_set_3_snap);
		SET @count4=(SELECT COUNT(*) FROM view_set_4_snap);
		SET @count5=(SELECT COUNT(*) FROM view_set_5_snap);
		SET @count6=(SELECT COUNT(*) FROM view_set_6_snap);
		SET @count1_snap=(SELECT COUNT(*) FROM view_set_snap_1_tbl);
		
		IF(@count1=0 AND @count2=0 AND @count3=0 AND @count4=0 AND @count5=0 AND @count6=0 AND @count1_snap=0) THEN
		
			insert ignore into `view_set_1_snap` select * from `view_set_1_snap_swap_2`;
			insert into `view_set_2_snap` select * from `view_set_2_snap_swap_2`;
			insert into `view_set_3_snap` select * from `view_set_3_snap_swap_2`;
			insert into `view_set_4_snap` select * from  `view_set_4_snap_swap_2`;
			INSERT IGNORE INTO `view_set_snap_1_tbl` SELECT * FROM `view_set_snap_1_tbl_swap_2`;
			insert into `view_set_5_snap` select * from `view_set_5_snap_swap_2`;
			insert into `view_set_6_snap` select * from `view_set_6_snap_swap_2`;
		END IF;
		
		set @count1=(select count(*) from view_set_1_snap);
		SET @count2=(SELECT COUNT(*) FROM view_set_2_snap);
		SET @count3=(SELECT COUNT(*) FROM view_set_3_snap);
		SET @count4=(SELECT COUNT(*) FROM view_set_4_snap);
		SET @count5=(SELECT COUNT(*) FROM view_set_5_snap);
		SET @count6=(SELECT COUNT(*) FROM view_set_6_snap);
		set @count1_snap=(select count(*) from view_set_snap_1_tbl);
		
		if(@count1_snap=0) then
			INSERT ignore INTO `brandix_bts`.`view_set_snap_1_tbl` (`bundle_transactions_20_repeat_id`) VALUES ('1');
			INSERT ignore INTO `brandix_bts`.`view_set_snap_1_tbl_swap_2` (`bundle_transactions_20_repeat_id`) VALUES ('1');
		end if;
		
		if(@count1>0 and @count2>0 and @count3>0 and @count4>0 and @count5>0 and @count6>0 and @count1_snap>0) then
				
			UPDATE snap_session_track SET session_status='on',swap_status='',1_snap='view_set_1_snap',2_snap='view_set_2_snap',3_snap='view_set_3_snap',4_snap='view_set_4_snap',5_snap='view_set_5_snap',6_snap='view_set_6_snap',0_tbl_snap='view_set_snap_1_tbl',time_stamp=(SELECT MAX(bundle_transactions_date_time) FROM `view_set_1_snap`)  WHERE session_id=1;
			
			TRUNCATE TABLE view_set_1_snap_swap_2;	
			TRUNCATE TABLE bundle_transactions_20_repeat_virtual_snap_ini_bundles;
			
			INSERT ignore INTO view_set_1_snap_swap_2 SELECT * FROM view_set_1;
			INSERT ignore INTO bundle_transactions_20_repeat_virtual_snap_ini_bundles SELECT  @s:=@s+1 id,1 AS parent_id,bundle_number AS bundle_barcode,quantity,bundle_number AS bundle_id,5 AS operation_id,0 AS rejection_qty, 0 AS act_module FROM tbl_miniorder_data,(SELECT @s:=MAX(id) FROM `bundle_transactions_20_repeat`) AS s;
			
			INSERT ignore INTO view_set_1_snap_swap_2 SELECT * FROM view_set_1_virtual;
			
			
			
			
			
			TRUNCATE TABLE view_set_2_snap_swap_2;
			INSERT INTO view_set_2_snap_swap_2 SELECT * FROM view_set_2;
			
			
			
			
			TRUNCATE TABLE view_set_3_snap_swap_2;
			INSERT INTO view_set_3_snap_swap_2 SELECT * FROM view_set_3;
			
			
			
			
			TRUNCATE TABLE view_set_4_snap_swap_2;
			INSERT INTO view_set_4_snap_swap_2 SELECT * FROM view_set_4;
			
			
			
			
			TRUNCATE TABLE view_set_snap_1_tbl_swap_2;
			INSERT ignore INTO view_set_snap_1_tbl_swap_2 SELECT * FROM view_set_snap_1;
			
			
			
			
			TRUNCATE TABLE view_set_5_snap_swap_2;
			INSERT INTO view_set_5_snap_swap_2 SELECT * FROM view_set_5;
			
			
			
			
			TRUNCATE TABLE view_set_6_snap_swap_2;
			INSERT INTO view_set_6_snap_swap_2 SELECT * FROM view_set_6;
			
			
			
			
			
			SET @count1_snap=(SELECT MAX(bundle_transactions_20_repeat_id) FROM view_set_snap_1_tbl_swap_2 where bundle_transactions_20_repeat_operation_id in (3,4));
			
			
			UPDATE snap_session_track SET session_status='off',swap_status='_swap_2',1_snap='view_set_1_snap_swap_2',2_snap='view_set_2_snap_swap_2',3_snap='view_set_3_snap_swap_2',4_snap='view_set_4_snap_swap_2',5_snap='view_set_5_snap_swap_2',6_snap='view_set_6_snap_swap_2',0_tbl_snap='view_set_snap_1_tbl_swap_2',time_stamp=(SELECT MAX(bundle_transactions_date_time) FROM `view_set_1_snap_swap_2`) WHERE session_id=1;
		END IF;
		
		IF(@resetflag='YES') THEN
				
			UPDATE snap_session_track SET session_status='on',swap_status='',1_snap='view_set_1_snap',2_snap='view_set_2_snap',3_snap='view_set_3_snap',4_snap='view_set_4_snap',5_snap='view_set_5_snap',6_snap='view_set_6_snap',0_tbl_snap='view_set_snap_1_tbl',time_stamp=(SELECT MAX(bundle_transactions_date_time) FROM `view_set_1_snap`)  WHERE session_id=1;
			
			TRUNCATE TABLE view_set_1_snap_swap_2;	
			TRUNCATE TABLE bundle_transactions_20_repeat_virtual_snap_ini_bundles;
			
			INSERT IGNORE INTO view_set_1_snap_swap_2 SELECT * FROM view_set_1;
			INSERT IGNORE INTO bundle_transactions_20_repeat_virtual_snap_ini_bundles SELECT  @s:=@s+1 id,1 AS parent_id,bundle_number AS bundle_barcode,quantity,bundle_number AS bundle_id,5 AS operation_id,0 AS rejection_qty, 0 AS act_module FROM tbl_miniorder_data,(SELECT @s:=MAX(id) FROM `bundle_transactions_20_repeat`) AS s;
			
			INSERT IGNORE INTO view_set_1_snap_swap_2 SELECT * FROM view_set_1_virtual;
			
			
			
			
			
			TRUNCATE TABLE view_set_2_snap_swap_2;
			INSERT INTO view_set_2_snap_swap_2 SELECT * FROM view_set_2;
			
			
			
			
			TRUNCATE TABLE view_set_3_snap_swap_2;
			INSERT INTO view_set_3_snap_swap_2 SELECT * FROM view_set_3;
			
			
			
			
			TRUNCATE TABLE view_set_4_snap_swap_2;
			INSERT INTO view_set_4_snap_swap_2 SELECT * FROM view_set_4;
			
			
			
			
			TRUNCATE TABLE view_set_snap_1_tbl_swap_2;
			INSERT IGNORE INTO view_set_snap_1_tbl_swap_2 SELECT * FROM view_set_snap_1;
			
			
			
			
			TRUNCATE TABLE view_set_5_snap_swap_2;
			INSERT INTO view_set_5_snap_swap_2 SELECT * FROM view_set_5;
			
			
			
			
			TRUNCATE TABLE view_set_6_snap_swap_2;
			INSERT INTO view_set_6_snap_swap_2 SELECT * FROM view_set_6;
			
			
			
			
			
			SET @count1_snap=(SELECT MAX(bundle_transactions_20_repeat_id) FROM view_set_snap_1_tbl_swap_2 WHERE bundle_transactions_20_repeat_operation_id IN (3,4));
			
			
			UPDATE snap_session_track SET session_status='off',swap_status='_swap_2',1_snap='view_set_1_snap_swap_2',2_snap='view_set_2_snap_swap_2',3_snap='view_set_3_snap_swap_2',4_snap='view_set_4_snap_swap_2',5_snap='view_set_5_snap_swap_2',6_snap='view_set_6_snap_swap_2',0_tbl_snap='view_set_snap_1_tbl_swap_2',time_stamp=(SELECT MAX(bundle_transactions_date_time) FROM `view_set_1_snap_swap_2`) WHERE session_id=1;
		END IF;
	END IF;
	
	SET sql_log_bin = 1;
    END */$$
DELIMITER ;

/*Table structure for table `view_bund_tran_master` */

DROP TABLE IF EXISTS `view_bund_tran_master`;

/*!50001 DROP VIEW IF EXISTS `view_bund_tran_master` */;
/*!50001 DROP TABLE IF EXISTS `view_bund_tran_master` */;

/*!50001 CREATE TABLE  `view_bund_tran_master`(
 `parent_id` bigint(11) ,
 `bundle_id` int(6) ,
 `id` int(11) ,
 `operation_name` varchar(50) ,
 `operation_code` varchar(255) ,
 `date_time` datetime ,
 `bundle_barcode` varchar(50) ,
 `quantity` int(6) ,
 `rejection_quantity` int(6) ,
 `operation_id` varchar(15) ,
 `module_id` varchar(11) ,
 `shift_name` varchar(255) 
)*/;

/*View structure for view view_bund_tran_master */

/*!50001 DROP TABLE IF EXISTS `view_bund_tran_master` */;
/*!50001 DROP VIEW IF EXISTS `view_bund_tran_master` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_bund_tran_master` AS (select `bundle_transactions_20_repeat`.`parent_id` AS `parent_id`,`bundle_transactions_20_repeat`.`bundle_id` AS `bundle_id`,`tbl_miniorder_data`.`id` AS `id`,`tbl_orders_ops_ref`.`operation_name` AS `operation_name`,`tbl_orders_ops_ref`.`operation_code` AS `operation_code`,`bundle_transactions`.`date_time` AS `date_time`,`bundle_transactions_20_repeat`.`bundle_barcode` AS `bundle_barcode`,`bundle_transactions_20_repeat`.`quantity` AS `quantity`,`bundle_transactions_20_repeat`.`rejection_quantity` AS `rejection_quantity`,`bundle_transactions_20_repeat`.`operation_id` AS `operation_id`,`bundle_transactions`.`module_id` AS `module_id`,`tbl_shifts_master`.`shift_name` AS `shift_name` from ((((`bundle_transactions_20_repeat` left join `tbl_orders_ops_ref` on((`bundle_transactions_20_repeat`.`operation_id` = `tbl_orders_ops_ref`.`id`))) left join `bundle_transactions` on((`bundle_transactions_20_repeat`.`parent_id` = `bundle_transactions`.`id`))) left join `tbl_shifts_master` on((`bundle_transactions`.`shift` = `tbl_shifts_master`.`id`))) left join `tbl_miniorder_data` on((`bundle_transactions_20_repeat`.`bundle_id` = `tbl_miniorder_data`.`bundle_number`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
