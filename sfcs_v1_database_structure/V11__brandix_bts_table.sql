/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - brandix_bts
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
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
  `updated_time_stamp` varchar(50) DEFAULT NULL,
  `mx_status` int(11) DEFAULT 0 COMMENT '0-pending,1-complete',
  `mx_updatetime` varchar(50) DEFAULT NULL COMMENT 'm3 status update',
  PRIMARY KEY (`bts_tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bts_to_sfcs_sync_archive` */

DROP TABLE IF EXISTS `bts_to_sfcs_sync_archive`;

CREATE TABLE `bts_to_sfcs_sync_archive` (
  `bts_tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sync_bundle_id` bigint(20) NOT NULL,
  `sync_operation_id` int(11) NOT NULL,
  `sync_operation_code` int(11) NOT NULL COMMENT '0-Add, 1-Update, 2-Delete',
  `sync_status` int(11) NOT NULL COMMENT '1-Sync Completed',
  `sync_rep_id` bigint(20) NOT NULL COMMENT 'id of bud_tran_20_rep',
  `insert_time_stamp` timestamp NULL DEFAULT NULL,
  `updated_time_stamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bts_tran_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bundle_creation_data` */

DROP TABLE IF EXISTS `bundle_creation_data`;

CREATE TABLE `bundle_creation_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `recevied_qty` int(11) DEFAULT 0,
  `missing_qty` int(11) DEFAULT 0,
  `rejected_qty` int(11) DEFAULT 0,
  `left_over` int(11) DEFAULT 0,
  `operation_id` int(11) DEFAULT NULL,
  `operation_sequence` int(11) DEFAULT NULL,
  `ops_dependency` int(11) DEFAULT NULL,
  `docket_number` int(11) DEFAULT NULL,
  `bundle_status` varchar(255) DEFAULT 'OPEN',
  `split_status` varchar(255) DEFAULT NULL,
  `sewing_order_status` varchar(10) DEFAULT 'No',
  `is_sewing_order` varchar(10) DEFAULT 'No',
  `sewing_order` int(11) DEFAULT 0,
  `assigned_module` varchar(10) DEFAULT '0',
  `remarks` text DEFAULT NULL,
  `scanned_date` datetime DEFAULT NULL,
  `shift` varchar(11) DEFAULT NULL,
  `scanned_user` varchar(255) DEFAULT NULL,
  `sync_status` int(11) DEFAULT 0,
  `shade` varchar(10) DEFAULT NULL,
  `input_job_no` int(11) DEFAULT NULL,
  `input_job_no_random_ref` varchar(25) DEFAULT NULL,
  `mapped_color` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Bundle` (`bundle_number`,`operation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=148407 DEFAULT CHARSET=latin1;

/*Table structure for table `bundle_creation_data_temp` */

DROP TABLE IF EXISTS `bundle_creation_data_temp`;

CREATE TABLE `bundle_creation_data_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `recevied_qty` int(11) DEFAULT 0,
  `missing_qty` int(11) DEFAULT 0,
  `rejected_qty` int(11) DEFAULT 0,
  `left_over` int(11) DEFAULT 0,
  `operation_id` int(11) DEFAULT NULL,
  `operation_sequence` int(11) DEFAULT NULL,
  `ops_dependency` int(11) DEFAULT NULL,
  `docket_number` int(11) DEFAULT NULL,
  `bundle_status` varchar(255) DEFAULT 'OPEN',
  `split_status` varchar(255) DEFAULT NULL,
  `sewing_order_status` varchar(10) DEFAULT 'No',
  `is_sewing_order` varchar(10) DEFAULT 'No',
  `sewing_order` int(11) DEFAULT 0,
  `assigned_module` varchar(10) DEFAULT '0',
  `remarks` text DEFAULT NULL,
  `scanned_date` datetime DEFAULT NULL,
  `shift` varchar(11) DEFAULT NULL,
  `scanned_user` varchar(255) DEFAULT NULL,
  `sync_status` int(11) DEFAULT 0,
  `shade` varchar(10) DEFAULT NULL,
  `input_job_no` int(11) DEFAULT NULL,
  `input_job_no_random_ref` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `input_job` (`id`,`input_job_no`,`input_job_no_random_ref`),
  KEY `style_schedule` (`style`,`schedule`,`color`,`size_id`,`size_title`),
  KEY `bundle` (`bundle_number`,`input_job_no_random_ref`,`input_job_no`)
) ENGINE=InnoDB AUTO_INCREMENT=142629 DEFAULT CHARSET=latin1;

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
  `id` bigint(11) NOT NULL DEFAULT 0,
  `parent_id` bigint(11) DEFAULT NULL,
  `bundle_barcode` varchar(50) NOT NULL,
  `quantity` int(6) DEFAULT NULL,
  `bundle_id` int(6) DEFAULT NULL,
  `operation_id` varchar(15) DEFAULT NULL,
  `rejection_quantity` int(6) DEFAULT NULL,
  `act_module` int(11) DEFAULT NULL,
  `status` int(5) NOT NULL DEFAULT 0,
  `user` varchar(70) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` varchar(200) NOT NULL,
  `updated_by` varchar(70) NOT NULL,
  `update_log` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
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
  `id` int(11) NOT NULL DEFAULT 0,
  `date_time` datetime DEFAULT NULL,
  `operation_time` datetime DEFAULT NULL,
  `employee_id` varchar(255) DEFAULT NULL,
  `shift` int(11) DEFAULT NULL,
  `trans_status` varchar(255) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `input_transfer` */

DROP TABLE IF EXISTS `input_transfer`;

CREATE TABLE `input_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` varchar(20) NOT NULL,
  `input_module` int(11) DEFAULT NULL,
  `transfer_module` int(11) DEFAULT NULL,
  `bundles` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Table structure for table `module_bundle_track` */

DROP TABLE IF EXISTS `module_bundle_track`;

CREATE TABLE `module_bundle_track` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `date-time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bundle_number` int(11) DEFAULT NULL,
  `module` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `job_no` int(20) DEFAULT NULL,
  `ref_no` int(10) DEFAULT NULL,
  PRIMARY KEY (`tran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1320 DEFAULT CHARSET=latin1;

/*Table structure for table `re_print_table` */

DROP TABLE IF EXISTS `re_print_table`;

CREATE TABLE `re_print_table` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `bundle_id` varchar(10) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `time_stamp` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
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

/*Table structure for table `tbl_carton_ref` */

DROP TABLE IF EXISTS `tbl_carton_ref`;

CREATE TABLE `tbl_carton_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carton_barcode` varchar(40) NOT NULL,
  `carton_tot_quantity` int(11) NOT NULL,
  `ref_order_num` varchar(255) DEFAULT NULL,
  `style_code` int(6) DEFAULT NULL,
  `carton_method` varchar(5) DEFAULT NULL COMMENT 'carton method',
  `exces_from` int(5) DEFAULT NULL COMMENT '1. first , 2. Last',
  `merge_status` int(5) DEFAULT NULL COMMENT '1. Mix Cut Jobs , 2. No mix cut jobs',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=551 DEFAULT CHARSET=utf8;

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
  `size_title` varchar(10) DEFAULT NULL COMMENT 'size title',
  `quantity` int(6) DEFAULT NULL COMMENT 'poly bag ratio',
  `poly_bags_per_carton` int(5) DEFAULT NULL COMMENT 'poly bags per carton',
  `garments_per_carton` int(5) DEFAULT NULL COMMENT 'Gamrents per carton',
  `combo_no` int(5) DEFAULT NULL COMMENT 'Combo pack id',
  `split_qty` int(5) DEFAULT 0 COMMENT 'split bundle qty',
  `no_of_cartons` int(5) DEFAULT 0 COMMENT 'no of cartons',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `color_qnty` (`color`,`size_title`,`quantity`)
) ENGINE=InnoDB AUTO_INCREMENT=4297 DEFAULT CHARSET=utf8;

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
  `cut_status` text DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3660 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_cut_master_archive` */

DROP TABLE IF EXISTS `tbl_cut_master_archive`;

CREATE TABLE `tbl_cut_master_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_num` varchar(50) NOT NULL,
  `ref_order_num` int(11) NOT NULL,
  `cut_num` int(11) NOT NULL,
  `cut_status` text DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_id` (`parent_id`,`ref_size_name`,`quantity`,`color`)
) ENGINE=InnoDB AUTO_INCREMENT=5561 DEFAULT CHARSET=utf8;

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

/*Table structure for table `tbl_ims_ops` */

DROP TABLE IF EXISTS `tbl_ims_ops`;

CREATE TABLE `tbl_ims_ops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_name` varchar(50) NOT NULL,
  `operation_code` varchar(255) DEFAULT NULL,
  `appilication` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `size_ref` varchar(15) DEFAULT NULL,
  `size_tit` varchar(5) DEFAULT NULL COMMENT 'size title',
  `combo_code` varchar(10) DEFAULT NULL COMMENT 'Combo code with in the schedule',
  `mini_order_priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scanned_qty` (`mini_order_num`,`color`),
  KEY `mini_order_ref` (`mini_order_ref`),
  KEY `doc_qnty` (`cut_num`,`quantity`,`docket_number`,`size_tit`)
) ENGINE=MyISAM AUTO_INCREMENT=6619 DEFAULT CHARSET=utf8;

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
  `trim_status` text DEFAULT NULL,
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
  `trim_status` text DEFAULT NULL,
  `mini_order_status` varchar(45) DEFAULT NULL,
  `split_status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_miniorder_data_qty_split_log` */

DROP TABLE IF EXISTS `tbl_miniorder_data_qty_split_log`;

CREATE TABLE `tbl_miniorder_data_qty_split_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_name` varchar(150) DEFAULT NULL,
  `docket_number` varchar(45) DEFAULT NULL,
  `quantity` varchar(60) DEFAULT NULL,
  `shade` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `tbl_module_ref` */

DROP TABLE IF EXISTS `tbl_module_ref`;

CREATE TABLE `tbl_module_ref` (
  `id` varchar(11) NOT NULL,
  `module_name` varchar(50) NOT NULL,
  `module_section` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_master` */

DROP TABLE IF EXISTS `tbl_orders_master`;

CREATE TABLE `tbl_orders_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_product_style` int(11) NOT NULL,
  `product_schedule` varchar(50) NOT NULL,
  `order_status` text DEFAULT NULL,
  `emb_status` varchar(10) DEFAULT '0' COMMENT '0-Narmal,1-Panel Emb,2-Garment Emb',
  `log` varchar(55) DEFAULT NULL COMMENT 'log details',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique identification` (`ref_product_style`,`product_schedule`) COMMENT 'To do not allow duplicate'
) ENGINE=InnoDB AUTO_INCREMENT=495 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_master_archive` */

DROP TABLE IF EXISTS `tbl_orders_master_archive`;

CREATE TABLE `tbl_orders_master_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_product_style` int(11) NOT NULL,
  `product_schedule` varchar(50) NOT NULL,
  `order_status` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_ops_ref` */

DROP TABLE IF EXISTS `tbl_orders_ops_ref`;

CREATE TABLE `tbl_orders_ops_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_name` varchar(50) NOT NULL,
  `default_operation` text DEFAULT NULL,
  `operation_code` varchar(255) DEFAULT NULL,
  `ops_order` int(10) DEFAULT NULL,
  `operation_description` varchar(100) DEFAULT NULL,
  `operation_type` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_op_name` (`operation_name`),
  UNIQUE KEY `unique_op_code` (`operation_code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_size_ref` */

DROP TABLE IF EXISTS `tbl_orders_size_ref`;

CREATE TABLE `tbl_orders_size_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_key` (`size_name`)
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
) ENGINE=InnoDB AUTO_INCREMENT=13607 DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`product_style`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_orders_style_ref_archive` */

DROP TABLE IF EXISTS `tbl_orders_style_ref_archive`;

CREATE TABLE `tbl_orders_style_ref_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_style` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tbl_sewing_job_prefix` */

DROP TABLE IF EXISTS `tbl_sewing_job_prefix`;

CREATE TABLE `tbl_sewing_job_prefix` (
  `id` int(11) DEFAULT NULL,
  `prefix_name` varchar(765) DEFAULT NULL,
  `prefix` varchar(765) DEFAULT NULL,
  `type_of_sewing` int(11) DEFAULT NULL,
  `bg_color` varchar(765) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `from_m3_check` int(11) NOT NULL DEFAULT 1,
  `scan_status` int(11) DEFAULT 0,
  `min_order_ref` int(11) DEFAULT 0,
  `barcode` varchar(50) NOT NULL DEFAULT 'No',
  `emb_supplier` int(11) DEFAULT NULL,
  `ops_sequence` varchar(50) DEFAULT '0',
  `ops_dependency` int(11) DEFAULT NULL,
  `component` varchar(250) DEFAULT NULL,
  `main_operationnumber` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`operation_code`,`style`,`color`),
  KEY `style_color` (`style`,`color`)
) ENGINE=InnoDB AUTO_INCREMENT=1468 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `view_set_1_snap` */

DROP TABLE IF EXISTS `view_set_1_snap`;

CREATE TABLE `view_set_1_snap` (
  `bundle_transactions_20_repeat_id` bigint(11) DEFAULT 0,
  `bundle_transactions_20_repeat_parent_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_barcode` varchar(50) CHARACTER SET utf8 NOT NULL,
  `bundle_transactions_20_repeat_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_bundle_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` varchar(11) DEFAULT NULL,
  `tbl_orders_ops_ref_id` bigint(11) DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_default_operation` text CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_id` bigint(11) DEFAULT NULL,
  `bundle_transactions_date_time` datetime DEFAULT NULL,
  `bundle_transactions_operation_time` datetime DEFAULT NULL,
  `bundle_transactions_employee_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_shift` bigint(11) DEFAULT NULL,
  `bundle_transactions_trans_status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` varchar(11) DEFAULT NULL,
  `tbl_shifts_master_id` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_date_time` datetime DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`bundle_transactions_20_repeat_bundle_barcode`),
  KEY `bundle_transactions_20_repeat_bundle_id` (`bundle_transactions_20_repeat_bundle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_2_snap` */

DROP TABLE IF EXISTS `view_set_2_snap`;

CREATE TABLE `view_set_2_snap` (
  `tbl_orders_size_ref_id` int(11) NOT NULL,
  `tbl_orders_size_ref_size_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `tbl_orders_sizes_master_id` int(6) NOT NULL DEFAULT 0,
  `tbl_orders_sizes_master_parent_id` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_ref_size_name` int(11) DEFAULT NULL,
  `tbl_orders_sizes_master_size_title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_sizes_master_order_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_act_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_col_des` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_id` int(11) DEFAULT NULL,
  `tbl_orders_master_ref_product_style` int(11) DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_order_status` text CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_style_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_style_ref_product_style` varchar(70) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  `smv` varchar(50) DEFAULT NULL,
  `order_div` varchar(50) DEFAULT NULL,
  `order_date` varchar(50) DEFAULT NULL,
  UNIQUE KEY `unique id` (`tbl_orders_sizes_master_id`),
  KEY `order_id` (`order_id`(255))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_3_snap` */

DROP TABLE IF EXISTS `view_set_3_snap`;

CREATE TABLE `view_set_3_snap` (
  `tbl_min_ord_ref_id` int(11) DEFAULT 0,
  `tbl_min_ord_ref_ref_product_style` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_ref_crt_schedule` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_carton_quantity` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_max_bundle_qnty` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_miximum_bundles_per_size` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_mini_order_qnty` int(11) DEFAULT NULL,
  `tbl_min_ord_ref_transac_status` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_id` int(11) NOT NULL DEFAULT 0,
  `tbl_miniorder_data_date_time` datetime DEFAULT NULL,
  `tbl_miniorder_data_mini_order_ref` int(11) NOT NULL,
  `tbl_miniorder_data_mini_order_num` float(6,2) DEFAULT NULL,
  `tbl_miniorder_data_cut_num` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_color` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_size` int(11) DEFAULT NULL,
  `tbl_miniorder_data_bundle_number` int(6) NOT NULL,
  `tbl_miniorder_data_quantity` decimal(32,0) DEFAULT NULL,
  `tbl_miniorder_data_docket_number` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_issued_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_plan_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_bundle_status` varchar(15) CHARACTER SET utf8 DEFAULT 'OPEN',
  `tbl_miniorder_data_planned_module` int(11) DEFAULT NULL,
  `tbl_miniorder_data_mini_order_priority` int(6) DEFAULT NULL,
  `tbl_miniorder_data_requested_date` datetime DEFAULT NULL,
  `tbl_miniorder_data_trim_status` text CHARACTER SET utf8 DEFAULT NULL,
  `tbl_miniorder_data_mini_order_status` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `order_id` varchar(318) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`tbl_miniorder_data_bundle_number`),
  KEY `tbl_miniorder_data_bundle_number` (`tbl_miniorder_data_bundle_number`),
  KEY `order_id` (`order_id`(255)),
  KEY `tbl_miniorder_data_mini_order_num` (`tbl_miniorder_data_mini_order_num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_4_snap` */

DROP TABLE IF EXISTS `view_set_4_snap`;

CREATE TABLE `view_set_4_snap` (
  `DATE` date NOT NULL,
  `style` varchar(60) NOT NULL,
  `SCHEDULE` varchar(60) NOT NULL,
  `cpk_qty` double DEFAULT NULL,
  `order_tid_new` varchar(400) NOT NULL COMMENT 'Order tid New',
  UNIQUE KEY `unique Id` (`order_tid_new`),
  KEY `date` (`DATE`)
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
  `order_tid_new_2` varchar(400) NOT NULL COMMENT 'Unique Id',
  UNIQUE KEY `unique_new` (`order_tid_new_2`),
  KEY `order_tid_new` (`order_tid_new`),
  KEY `DATE` (`DATE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_snap_1_tbl` */

DROP TABLE IF EXISTS `view_set_snap_1_tbl`;

CREATE TABLE `view_set_snap_1_tbl` (
  `bundle_transactions_20_repeat_id` bigint(11) DEFAULT 0,
  `bundle_transactions_20_repeat_quantity` bigint(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_operation_id` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_20_repeat_rejection_quantity` bigint(11) DEFAULT NULL,
  `tbl_shifts_master_shift_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tbl_orders_ops_ref_operation_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `bundle_transactions_module_id` varchar(11) DEFAULT NULL,
  `bundle_transactions_20_repeat_act_module` varchar(11) DEFAULT NULL,
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
  `bundle_transactions_20_repeat_bundle_barcode` varchar(50) CHARACTER SET utf8 NOT NULL,
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
  PRIMARY KEY (`bundle_transactions_20_repeat_bundle_barcode`),
  KEY `tbl_orders_style_ref_product_style` (`tbl_orders_style_ref_product_style`),
  KEY `tbl_orders_master_product_schedule` (`tbl_orders_master_product_schedule`),
  KEY `tbl_orders_ops_ref_operation_code` (`tbl_orders_ops_ref_operation_code`),
  KEY `size_disp` (`size_disp`),
  KEY `tbl_miniorder_data_color` (`tbl_miniorder_data_color`),
  KEY `tbl_miniorder_data_mini_order_num` (`tbl_miniorder_data_mini_order_num`),
  KEY `order_tid_new` (`order_tid_new`),
  KEY `order_id` (`order_id`(255)),
  KEY `bundle_transactions_date_time` (`bundle_transactions_date_time`),
  KEY `tbl_miniorder_data_bundle_number` (`tbl_miniorder_data_bundle_number`),
  KEY `bundle_transactions_20_repeat_operation_id` (`bundle_transactions_20_repeat_operation_id`),
  KEY `bundle_transactions_20_repeat_id` (`bundle_transactions_20_repeat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
