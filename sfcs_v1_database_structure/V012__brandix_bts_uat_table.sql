/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - brandix_bts_uat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`brandix_bts_uat` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*USE `brandix_bts_uat`;*/

/*Table structure for table `bundle_transactions_20_repeat_virtual_snap_ini_bundles` */

DROP TABLE IF EXISTS `brandix_bts_uat`.`bundle_transactions_20_repeat_virtual_snap_ini_bundles`;

CREATE TABLE `brandix_bts_uat`.`bundle_transactions_20_repeat_virtual_snap_ini_bundles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(11) DEFAULT NULL,
  `bundle_barcode` varchar(150) NOT NULL,
  `quantity` int(6) DEFAULT NULL,
  `bundle_id` bigint(11) DEFAULT NULL,
  `operation_id` varchar(45) DEFAULT NULL,
  `rejection_quantity` int(6) DEFAULT NULL,
  `act_module` int(11) DEFAULT NULL,
  PRIMARY KEY (`bundle_barcode`),
  KEY `operation_id` (`operation_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='temporary table to keep the records of mini order initial bundle info.';

/*Table structure for table `snap_session_track` */

DROP TABLE IF EXISTS `brandix_bts_uat`.`snap_session_track`;

CREATE TABLE `brandix_bts_uat`.`snap_session_track` (
  `session_status` varchar(5) DEFAULT NULL,
  `session_id` int(11) NOT NULL,
  `time_stamp` varchar(20) DEFAULT NULL,
  `swap_status` varchar(10) DEFAULT NULL,
  `6_snap` varchar(100) DEFAULT NULL,
  `5_snap` varchar(100) DEFAULT NULL,
  `4_snap` varchar(100) DEFAULT NULL,
  `3_snap` varchar(100) DEFAULT NULL,
  `2_snap` varchar(100) DEFAULT NULL,
  `1_snap` varchar(100) DEFAULT NULL,
  `0_tbl_snap` varchar(100) DEFAULT NULL,
  `day_status` varchar(11) DEFAULT NULL COMMENT '0-ready, 1-not ready',
  `fg_last_updated_tid` bigint(20) DEFAULT NULL COMMENT 'last id which got processed.',
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_1_snap` */

DROP TABLE IF EXISTS `brandix_bts_uat`.`view_set_1_snap`;

CREATE TABLE `brandix_bts_uat`.`view_set_1_snap` (
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

DROP TABLE IF EXISTS `brandix_bts_uat`.`view_set_2_snap`;

CREATE TABLE `brandix_bts_uat`.`view_set_2_snap` (
  `tbl_orders_size_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_size_ref_size_name` varchar(150) DEFAULT NULL,
  `tbl_orders_sizes_master_id` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_parent_id` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_ref_size_name` int(11) DEFAULT NULL,
  `tbl_orders_sizes_master_size_title` varchar(765) DEFAULT NULL,
  `tbl_orders_sizes_master_order_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_act_quantity` int(6) DEFAULT NULL,
  `tbl_orders_sizes_master_order_col_des` varchar(765) DEFAULT NULL,
  `tbl_orders_master_id` int(11) DEFAULT NULL,
  `tbl_orders_master_ref_product_style` int(11) DEFAULT NULL,
  `tbl_orders_master_product_schedule` varchar(150) DEFAULT NULL,
  `tbl_orders_master_order_status` text DEFAULT NULL,
  `tbl_orders_style_ref_id` int(11) DEFAULT NULL,
  `tbl_orders_style_ref_product_style` varchar(210) DEFAULT NULL,
  `order_id` varchar(954) DEFAULT NULL,
  `smv` varchar(150) DEFAULT NULL,
  `order_div` varchar(150) DEFAULT NULL,
  `order_date` varchar(150) DEFAULT NULL,
  UNIQUE KEY `unique` (`tbl_orders_sizes_master_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_3_snap` */

DROP TABLE IF EXISTS `brandix_bts_uat`.`view_set_3_snap`;

CREATE TABLE `brandix_bts_uat`.`view_set_3_snap` (
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

DROP TABLE IF EXISTS `brandix_bts_uat`.`view_set_4_snap`;

CREATE TABLE `brandix_bts_uat`.`view_set_4_snap` (
  `DATE` date NOT NULL,
  `style` varchar(60) NOT NULL,
  `SCHEDULE` varchar(60) NOT NULL,
  `cpk_qty` double DEFAULT NULL,
  `order_tid_new` varchar(400) NOT NULL,
  UNIQUE KEY `unique id` (`order_tid_new`),
  KEY `date` (`DATE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_5_snap` */

DROP TABLE IF EXISTS `brandix_bts_uat`.`view_set_5_snap`;

CREATE TABLE `brandix_bts_uat`.`view_set_5_snap` (
  `log_date` date DEFAULT NULL,
  `qms_style` varchar(90) DEFAULT NULL,
  `qms_schedule` varchar(60) DEFAULT NULL,
  `rejected_qty` decimal(28,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `view_set_6_snap` */

DROP TABLE IF EXISTS `brandix_bts_uat`.`view_set_6_snap`;

CREATE TABLE `brandix_bts_uat`.`view_set_6_snap` (
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

DROP TABLE IF EXISTS `brandix_bts_uat`.`view_set_snap_1_tbl`;

CREATE TABLE `brandix_bts_uat`.`view_set_snap_1_tbl` (
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
