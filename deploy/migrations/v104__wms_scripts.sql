/*
SQLyog Professional v12.5.1 (64 bit)
MySQL - 5.7.32-0ubuntu0.18.04.1 : Database - wms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `wms`;

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
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`disp_note_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To track dispatch details';



/*Table structure for table `fabric_cad_allocation_deleted` */

DROP TABLE IF EXISTS `fabric_cad_allocation_deleted`;

CREATE TABLE `fabric_cad_allocation_deleted` (
  `tran_pin` double NOT NULL AUTO_INCREMENT,
  `doc_no` double DEFAULT NULL,
  `roll_id` double DEFAULT NULL,
  `roll_width` float DEFAULT NULL,
  `plies` double DEFAULT NULL,
  `mk_len` float DEFAULT NULL,
  `doc_type` varchar(36) DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `allocated_qty` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1- Check_pending, 2-Check_completed',
  `shade` varchar(20) DEFAULT NULL,
  `nbits` varchar(255) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tran_pin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `fabric_cad_allocation_old` */

DROP TABLE IF EXISTS `fabric_cad_allocation_old`;

CREATE TABLE `fabric_cad_allocation_old` (
  `tran_pin` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction Track',
  `doc_no` varchar(36) DEFAULT NULL COMMENT 'Cut Docket No',
  `roll_id` int(11) DEFAULT NULL COMMENT 'Roll Sticker No',
  `roll_width` float DEFAULT NULL COMMENT 'Roll Width',
  `plies` int(11) DEFAULT NULL COMMENT 'Revised No. of Plies planned',
  `mk_len` float DEFAULT NULL COMMENT 'Revised Marker Lenght',
  `doc_type` varchar(12) DEFAULT NULL COMMENT 'Docket Type',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `allocated_qty` float DEFAULT NULL COMMENT 'Allocated Quantity',
  `status` int(11) DEFAULT NULL COMMENT '1- Check_pending, 2-Check_completed',
  `shade` varchar(20) DEFAULT NULL,
  `nbits` varchar(255) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tran_pin`),
  KEY `doc_no` (`doc_no`),
  KEY `Roll` (`doc_no`,`roll_id`),
  KEY `roll_id` (`roll_id`,`status`),
  KEY `doc_no_type` (`doc_no`,`doc_type`)
) ENGINE=MyISAM AUTO_INCREMENT=39653 DEFAULT CHARSET=latin1;

/*Table structure for table `four_points_table` */

DROP TABLE IF EXISTS `four_points_table`;

CREATE TABLE `four_points_table` (
  `insp_child_id` int(10) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `points` int(10) DEFAULT NULL,
  `selected_point` int(10) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  KEY `insp_child_id` (`insp_child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_complaint_db` */

DROP TABLE IF EXISTS `inspection_complaint_db`;

CREATE TABLE `inspection_complaint_db` (
  `complaint_no` double DEFAULT NULL,
  `ref_no` varchar(450) DEFAULT NULL,
  `product_categoy` varchar(450) DEFAULT NULL,
  `complaint_category` varchar(450) DEFAULT NULL,
  `req_date` datetime NOT NULL,
  `complaint_raised_by` varchar(450) DEFAULT NULL,
  `complaint_remarks` blob,
  `supplier_name` varchar(450) DEFAULT NULL,
  `buyer_name` varchar(450) DEFAULT NULL,
  `reject_item_codes` varchar(450) DEFAULT NULL,
  `reject_item_color` varchar(450) DEFAULT NULL,
  `reject_item_desc` varchar(900) DEFAULT NULL,
  `reject_batch_no` varchar(450) DEFAULT NULL,
  `reject_po_no` varchar(450) DEFAULT NULL,
  `reject_inv_no` varchar(450) DEFAULT NULL,
  `reject_lot_no` varchar(900) DEFAULT NULL,
  `reject_roll_qty` decimal(12,2) DEFAULT '0.00',
  `reject_len_qty` decimal(12,2) DEFAULT '0.00',
  `uom` varchar(450) DEFAULT NULL,
  `supplier_approved_date` date DEFAULT NULL,
  `supplier_status` varchar(450) DEFAULT NULL,
  `supplier_remarks` blob,
  `new_invoice_no` varchar(450) DEFAULT NULL,
  `supplier_replace_approved_qty` decimal(12,2) DEFAULT NULL,
  `supplier_credit_no` varchar(150) DEFAULT NULL,
  `supplier_claim_no` varchar(150) DEFAULT NULL,
  `supplier_claim_approved_qty` decimal(12,2) DEFAULT NULL,
  `complaint_status` double DEFAULT NULL,
  `mail_status` double DEFAULT NULL,
  `purchase_width` double(10,2) DEFAULT '0.00',
  `actual_width` double(10,2) DEFAULT '0.00',
  `purchase_gsm` double(10,2) DEFAULT '0.00',
  `actual_gsm` double(10,2) DEFAULT '0.00',
  `inspected_qty` double(10,2) DEFAULT '0.00',
  `complaint_cat_ref` int(11) NOT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  KEY `complaint` (`complaint_no`,`req_date`),
  KEY `complaint_no` (`complaint_no`),
  KEY `req_date` (`req_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_complaint_db_delete_log` */

DROP TABLE IF EXISTS `inspection_complaint_db_delete_log`;

CREATE TABLE `inspection_complaint_db_delete_log` (
  `complaint_no` double DEFAULT NULL,
  `ref_no` varchar(450) DEFAULT NULL,
  `product_categoy` varchar(450) DEFAULT NULL,
  `complaint_category` varchar(450) DEFAULT NULL,
  `req_date` datetime DEFAULT NULL,
  `complaint_raised_by` varchar(450) DEFAULT NULL,
  `complaint_remarks` blob,
  `supplier_name` varchar(450) DEFAULT NULL,
  `buyer_name` varchar(450) DEFAULT NULL,
  `reject_item_codes` varchar(450) DEFAULT NULL,
  `reject_item_color` varchar(450) DEFAULT NULL,
  `reject_item_desc` varchar(450) DEFAULT NULL,
  `reject_batch_no` varchar(450) DEFAULT NULL,
  `reject_po_no` varchar(450) DEFAULT NULL,
  `reject_inv_no` varchar(450) DEFAULT NULL,
  `reject_lot_no` varchar(900) DEFAULT NULL,
  `reject_roll_qty` decimal(12,2) DEFAULT NULL,
  `reject_len_qty` decimal(12,2) DEFAULT NULL,
  `uom` varchar(450) DEFAULT NULL,
  `supplier_approved_date` date DEFAULT NULL,
  `supplier_status` varchar(450) DEFAULT NULL,
  `supplier_remarks` blob,
  `new_invoice_no` varchar(450) DEFAULT NULL,
  `supplier_replace_approved_qty` decimal(12,2) DEFAULT NULL,
  `supplier_credit_no` varchar(150) DEFAULT NULL,
  `supplier_claim_no` varchar(150) DEFAULT NULL,
  `supplier_claim_approved_qty` decimal(12,2) DEFAULT NULL,
  `complaint_status` double DEFAULT NULL,
  `mail_status` double DEFAULT NULL,
  `purchase_width` double DEFAULT NULL,
  `actual_width` double DEFAULT NULL,
  `purchase_gsm` double DEFAULT NULL,
  `actual_gsm` double DEFAULT NULL,
  `inspected_qty` double DEFAULT NULL,
  `complaint_cat_ref` double DEFAULT NULL,
  `deleted_by` varchar(25) DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `hostname` varchar(25) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_complaint_db_log` */

DROP TABLE IF EXISTS `inspection_complaint_db_log`;

CREATE TABLE `inspection_complaint_db_log` (
  `complaint_track_id` double DEFAULT NULL,
  `complaint_reason` varchar(450) DEFAULT NULL,
  `complaint_rej_qty` decimal(22,2) DEFAULT NULL,
  `complaint_rating` varchar(20) DEFAULT NULL,
  `complaint_commnets` blob,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  KEY `NewIndex1` (`complaint_track_id`,`complaint_reason`,`complaint_rej_qty`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_complaint_reasons` */

DROP TABLE IF EXISTS `inspection_complaint_reasons`;

CREATE TABLE `inspection_complaint_reasons` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `sno` double DEFAULT NULL,
  `complaint_reason` varchar(1350) DEFAULT NULL,
  `Complaint_clasification` varchar(2700) DEFAULT NULL,
  `complaint_category` varchar(1350) DEFAULT NULL,
  `status` double DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_db` */

DROP TABLE IF EXISTS `inspection_db`;

CREATE TABLE `inspection_db` (
  `batch_ref` varchar(50) NOT NULL COMMENT 'Batch Reference1',
  `act_gsm` float NOT NULL DEFAULT '0' COMMENT 'Actual GSM',
  `pur_width` float NOT NULL DEFAULT '0' COMMENT 'Purchase Width',
  `act_width` float NOT NULL DEFAULT '0' COMMENT 'Actual Width',
  `sp_rem` text COMMENT 'Special Remarks',
  `qty_insp` float NOT NULL DEFAULT '0' COMMENT 'Quantity Inspected',
  `gmt_way` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'GMT Way (1-N/A, 2-One Way, 3-Two Way)',
  `pts` float NOT NULL DEFAULT '0' COMMENT 'Points per 100 sq. yard',
  `fallout` float NOT NULL DEFAULT '0' COMMENT 'Fallout Percentage',
  `skew` float NOT NULL DEFAULT '0' COMMENT 'Skew',
  `skew_cat` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Skew Category (1- Skewness, 2-Bowing)',
  `shrink_l` float NOT NULL DEFAULT '0' COMMENT 'Residual Shrinkage for Length %',
  `shrink_w` float NOT NULL DEFAULT '0' COMMENT 'Residual Shrinkage for Width',
  `supplier` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Supplier Reference (As Per Code)',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time Stamp for Unique ID',
  `unique_id` varchar(20) DEFAULT NULL COMMENT 'Unique Track ID',
  `status` tinyint(4) DEFAULT NULL COMMENT 'Status of Inspection/Confirmation/Communication',
  `track_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'tracking_id',
  `pur_gsm` float NOT NULL DEFAULT '0',
  `consumption` float NOT NULL DEFAULT '0',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`batch_ref`),
  UNIQUE KEY `track_id` (`track_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_population` */

DROP TABLE IF EXISTS `inspection_population`;

CREATE TABLE `inspection_population` (
  `sno` int(10) NOT NULL AUTO_INCREMENT,
  `lot_no` varchar(100) DEFAULT NULL,
  `supplier_po` int(50) DEFAULT NULL,
  `po_line` int(50) DEFAULT NULL,
  `po_subline` int(50) DEFAULT NULL,
  `supplier_invoice` varchar(150) DEFAULT NULL,
  `item_code` varchar(150) DEFAULT NULL,
  `item_desc` varchar(150) DEFAULT NULL,
  `item_name` varchar(150) DEFAULT NULL,
  `supplier_batch` varchar(150) DEFAULT NULL,
  `rm_color` varchar(150) DEFAULT NULL,
  `supplier_roll_no` varchar(50) DEFAULT NULL,
  `sfcs_roll_no` varchar(50) DEFAULT NULL,
  `rec_qty` float(10,2) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `parent_id` int(10) NOT NULL,
  `store_in_id` int(10) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`sno`),
  KEY `sno` (`sno`),
  KEY `status` (`status`),
  KEY `parent_id` (`parent_id`),
  KEY `store_in_id` (`store_in_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14491 DEFAULT CHARSET=latin1;

/*Table structure for table `location_db` */

DROP TABLE IF EXISTS `location_db`;

CREATE TABLE `location_db` (
  `location_id` varchar(50) NOT NULL,
  `product` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`sno`),
  KEY `location_id` (`location_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=latin1;

/*Table structure for table `location_trnsf` */

DROP TABLE IF EXISTS `location_trnsf`;

CREATE TABLE `location_trnsf` (
  `date` date DEFAULT NULL,
  `source_location` varchar(50) DEFAULT NULL,
  `new_location` varchar(50) DEFAULT NULL,
  `tid` varchar(50) DEFAULT NULL,
  `lot_no` varchar(50) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `old_qty` double DEFAULT NULL,
  `new_qty` double DEFAULT NULL,
  `log_user` varchar(100) DEFAULT NULL,
  `log_tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`log_tran_id`),
  KEY `NewIndex1` (`source_location`,`new_location`,`tid`,`lot_no`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

/*Table structure for table `main_population_tbl` */

DROP TABLE IF EXISTS `main_population_tbl`;

CREATE TABLE `main_population_tbl` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `no_of_rolls` int(20) DEFAULT NULL,
  `qty` float(10,2) DEFAULT NULL,
  `supplier` text,
  `invoice_no` text,
  `batch` text,
  `lot_no` text,
  `rm_color` text,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fab_composition` varchar(225) DEFAULT NULL,
  `tolerence` varchar(25) DEFAULT NULL,
  `s_width` varchar(25) DEFAULT NULL,
  `s_weight` varchar(25) DEFAULT NULL,
  `repeat_len` varchar(25) DEFAULT NULL,
  `lab_testing` varchar(25) DEFAULT NULL,
  `remarks` varchar(150) DEFAULT NULL,
  `status` int(4) DEFAULT '1' COMMENT '1- pending, 2- inprogress, 3- close',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

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
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `app_by` varchar(30) NOT NULL,
  `app_date` datetime NOT NULL,
  `issue_closed` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `rand_track` bigint(20) NOT NULL,
  `comm_status` int(11) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `category` int(11) NOT NULL COMMENT '1) fabric 2) accessories',
  `spoc` varchar(30) NOT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`style`,`schedule`,`color`),
  KEY `NewIndex2` (`schedule`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `material_deallocation_track` */

DROP TABLE IF EXISTS `material_deallocation_track`;

CREATE TABLE `material_deallocation_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_no` varchar(40) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `requested_by` varchar(30) DEFAULT NULL,
  `requested_at` datetime DEFAULT NULL,
  `approved_by` varchar(30) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `mrn_out_allocation` */

DROP TABLE IF EXISTS `mrn_out_allocation`;

CREATE TABLE `mrn_out_allocation` (
  `tid` double NOT NULL AUTO_INCREMENT COMMENT 'Transaction ID',
  `mrn_tid` double DEFAULT NULL COMMENT 'MRN Transaction ID',
  `lable_id` varchar(255) DEFAULT NULL COMMENT 'Lable ID',
  `lot_no` varchar(300) DEFAULT NULL COMMENT 'LOT Number',
  `iss_qty` double DEFAULT NULL COMMENT 'Issued Quantity',
  `cut_status` varchar(10) DEFAULT '0' COMMENT 'If cut reported for MRN, status 1 else status 0',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Log Time of issuing',
  `updated_user` varchar(100) DEFAULT NULL COMMENT 'Log user details of material issuing',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`mrn_tid`,`lable_id`,`lot_no`),
  KEY `NewIndex2` (`lable_id`),
  KEY `NewIndex3` (`lot_no`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
  `avail_qty` float NOT NULL DEFAULT '0' COMMENT 'Available Quantity',
  `issued_qty` float NOT NULL DEFAULT '0' COMMENT 'Issued Quantity',
  `status` smallint(6) NOT NULL COMMENT '1-Request; 2-Approved; 3-Rejected; 4-Informed/On Progress; 5-Sourcing Updated; 6-Canceled; 7-Doc Printed, 8-Doc Issued, 9-Doc Closed',
  `req_user` varchar(50) NOT NULL COMMENT 'Requested User',
  `section` varchar(6) NOT NULL COMMENT 'Section Number',
  `app_by` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Approved By',
  `updated_by` varchar(50) DEFAULT NULL COMMENT 'Updated by',
  `issued_by` varchar(50) DEFAULT NULL COMMENT 'Issued By',
  `tid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
  `rand_track_id` int(11) NOT NULL COMMENT 'Random Number',
  `req_date` datetime NOT NULL COMMENT 'Request date',
  `app_date` datetime DEFAULT NULL COMMENT 'Approve Date',
  `updated_date` datetime DEFAULT NULL COMMENT 'Update Date',
  `issued_date` datetime DEFAULT NULL COMMENT 'Issued Date',
  `reason_code` varchar(40) NOT NULL COMMENT 'Reason Code',
  `remarks` varchar(200) NOT NULL COMMENT 'Remarks',
  `batch_ref` varchar(50) DEFAULT NULL COMMENT 'To Track Batch Ref Details For Tracking The Issued Qty Of a Batch',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `request_date` (`req_date`),
  KEY `NewIndex1` (`style`,`schedule`,`color`),
  KEY `NewIndex2` (`schedule`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `plant_details` */

DROP TABLE IF EXISTS `plant_details`;

CREATE TABLE `plant_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `plantcode` varchar(10) DEFAULT NULL,
  `plant_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `reject_reasons` */

DROP TABLE IF EXISTS `reject_reasons`;

CREATE TABLE `reject_reasons` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `reject_code` varchar(50) DEFAULT NULL,
  `reject_desc` varchar(100) DEFAULT NULL,
  UNIQUE KEY `tid` (`tid`),
  UNIQUE KEY `reject_code` (`reject_code`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=latin1;

/*Table structure for table `remarks_log` */

DROP TABLE IF EXISTS `remarks_log`;

CREATE TABLE `remarks_log` (
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `username` varchar(45) NOT NULL,
  `date` datetime NOT NULL,
  `level` varchar(45) NOT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`sno`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=1324 DEFAULT CHARSET=latin1;

/*Table structure for table `roll_inspection_child` */

DROP TABLE IF EXISTS `roll_inspection_child`;

CREATE TABLE `roll_inspection_child` (
  `sno` int(20) NOT NULL AUTO_INCREMENT,
  `inspection_status` varchar(150) DEFAULT NULL,
  `inspected_per` float DEFAULT NULL,
  `inspected_qty` double DEFAULT NULL,
  `width_s` double DEFAULT NULL,
  `width_m` double DEFAULT NULL,
  `width_e` double DEFAULT NULL,
  `actual_height` float DEFAULT NULL,
  `actual_repeat_height` float DEFAULT NULL,
  `skw` varchar(150) DEFAULT NULL,
  `bow` varchar(150) DEFAULT NULL,
  `ver` varchar(150) DEFAULT NULL,
  `gsm` varchar(150) DEFAULT NULL,
  `comment` varchar(450) DEFAULT NULL,
  `marker_type` varchar(450) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `status` int(10) NOT NULL,
  `store_in_tid` int(10) NOT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `where_clause` (`store_in_tid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;


/*Table structure for table `sticker_report_deleted` */

DROP TABLE IF EXISTS `sticker_report_deleted`;

CREATE TABLE `sticker_report_deleted` (
  `item` varchar(200) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_desc` varchar(200) NOT NULL,
  `inv_no` varchar(100) NOT NULL,
  `po_no` varchar(100) NOT NULL,
  `rec_no` varchar(100) NOT NULL,
  `rec_qty` double NOT NULL,
  `lot_no` varchar(100) NOT NULL,
  `batch_no` varchar(200) NOT NULL,
  `buyer` varchar(200) NOT NULL,
  `product_group` varchar(150) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pkg_no` varchar(50) NOT NULL,
  `grn_date` varchar(50) NOT NULL,
  `allocated_qty` float NOT NULL,
  `backup_status` tinyint(4) NOT NULL,
  `supplier` varchar(300) NOT NULL COMMENT 'Supplier Info',
  `uom` varchar(10) DEFAULT NULL,
  `grn_location` varchar(15) DEFAULT NULL,
  `po_line_price` double(10,4) DEFAULT NULL,
  `po_total_cost` double(10,2) DEFAULT NULL,
  `style_no` varchar(25) DEFAULT NULL,
  `grn_type` varchar(50) DEFAULT NULL,
  `po_line` int(18) DEFAULT NULL,
  `po_subline` int(18) DEFAULT NULL,
  `rm_color` varchar(255) DEFAULT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  KEY `item` (`item`),
  KEY `inv_no` (`inv_no`,`batch_no`),
  KEY `batch_no` (`batch_no`),
  KEY `lot_no` (`lot_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `sticker_report_old` */

DROP TABLE IF EXISTS `sticker_report_old`;

CREATE TABLE `sticker_report_old` (
  `item` varchar(200) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_desc` varchar(200) NOT NULL,
  `inv_no` varchar(100) NOT NULL,
  `po_no` varchar(100) NOT NULL,
  `rec_no` varchar(100) NOT NULL,
  `rec_qty` double NOT NULL,
  `lot_no` varchar(100) NOT NULL,
  `batch_no` varchar(200) NOT NULL,
  `buyer` varchar(200) NOT NULL,
  `product_group` varchar(150) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pkg_no` varchar(50) NOT NULL,
  `grn_date` varchar(50) NOT NULL,
  `allocated_qty` float NOT NULL,
  `backup_status` tinyint(4) NOT NULL,
  `supplier` varchar(300) NOT NULL COMMENT 'Supplier Info',
  `uom` varchar(10) DEFAULT NULL,
  `grn_location` varchar(15) DEFAULT NULL,
  `po_line_price` double(10,4) DEFAULT NULL,
  `po_total_cost` double(10,2) DEFAULT NULL,
  `style_no` varchar(35) DEFAULT NULL COMMENT 'style no',
  `grn_type` varchar(50) DEFAULT NULL,
  `po_line` int(18) DEFAULT NULL,
  `po_subline` int(18) DEFAULT NULL,
  `rm_color` varchar(255) DEFAULT NULL,
  `plant_code` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  UNIQUE KEY `NewIndex1` (`rec_no`,`lot_no`,`plant_code`),
  KEY `item` (`item`),
  KEY `inv_no` (`inv_no`,`batch_no`),
  KEY `batch_no` (`batch_no`),
  KEY `rec_no` (`rec_no`),
  KEY `get_lot_no` (`po_no`,`po_line`,`po_subline`,`rec_no`),
  KEY `product_group` (`product_group`),
  KEY `style_no` (`style_no`),
  KEY `buyer` (`buyer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `stock_report_inventory` */

DROP TABLE IF EXISTS `stock_report_inventory`;

CREATE TABLE `stock_report_inventory` (
  `ref1` varchar(150) DEFAULT NULL,
  `lot_no` varchar(450) DEFAULT NULL,
  `batch_no` varchar(600) DEFAULT NULL,
  `item_desc` varchar(600) DEFAULT NULL,
  `item_name` varchar(600) DEFAULT NULL,
  `item` varchar(600) DEFAULT NULL,
  `supplier` varchar(600) DEFAULT NULL,
  `buyer` varchar(600) DEFAULT NULL,
  `style_no` varchar(105) DEFAULT NULL,
  `ref2` varchar(300) DEFAULT NULL,
  `ref3` varchar(300) DEFAULT NULL,
  `pkg_no` varchar(150) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `grn_date` varchar(150) DEFAULT NULL,
  `remarks` varchar(600) DEFAULT NULL,
  `tid` bigint(20) DEFAULT NULL,
  `qty_rec` double DEFAULT NULL,
  `qty_issued` double DEFAULT NULL,
  `qty_ret` double DEFAULT NULL,
  `balance` double DEFAULT '0',
  `product_group` varchar(450) DEFAULT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `roll_remarks` varchar(255) NOT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  KEY `lot_no` (`lot_no`),
  KEY `label_id` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/*Table structure for table `store_in_backup` */

DROP TABLE IF EXISTS `store_in_backup`;

CREATE TABLE `store_in_backup` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `lot_no` varchar(150) NOT NULL,
  `ref1` varchar(50) NOT NULL COMMENT 'Location No',
  `ref2` varchar(100) NOT NULL COMMENT 'Box/Roll No',
  `ref3` varchar(100) NOT NULL COMMENT 'Art No / ctex Width',
  `qty_rec` double NOT NULL,
  `qty_issued` double NOT NULL,
  `qty_ret` double NOT NULL,
  `date` date NOT NULL,
  `log_user` varchar(50) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `ref4` varchar(10) NOT NULL COMMENT 'shade group',
  `ref5` varchar(10) NOT NULL COMMENT 'ctex Length',
  `ref6` varchar(10) NOT NULL COMMENT 'act width',
  `allotment_status` smallint(6) NOT NULL COMMENT 'Allotment Status for Roll Nos in Docket',
  `qty_allocated` double(11,2) NOT NULL COMMENT 'Allocated Quantity',
  `roll_joins` int(11) NOT NULL,
  `roll_status` tinyint(4) DEFAULT NULL,
  `partial_appr_qty` double(10,2) DEFAULT NULL,
  `upload_file` varchar(200) DEFAULT NULL,
  `shrinkage_length` float NOT NULL DEFAULT '0',
  `shrinkage_width` float NOT NULL DEFAULT '0',
  `shrinkage_group` varchar(255) NOT NULL,
  `roll_remarks` varchar(255) NOT NULL,
  `rejection_reason` varchar(255) NOT NULL,
  `m3_call_status` enum('Y','N') DEFAULT 'N',
  `split_roll` varchar(50) DEFAULT NULL,
  `barcode_number` varchar(255) DEFAULT NULL,
  `ref_tid` int(11) DEFAULT '0',
  `shade_grp` varchar(10) DEFAULT NULL,
  `act_width_grp` varchar(10) DEFAULT NULL,
  `supplier_no` varchar(10) NOT NULL DEFAULT '0',
  `four_point_status` int(10) NOT NULL DEFAULT '0',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `lot_no` (`lot_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `store_in_deleted` */

DROP TABLE IF EXISTS `store_in_deleted`;

CREATE TABLE `store_in_deleted` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `lot_no` varchar(150) NOT NULL,
  `ref1` varchar(50) NOT NULL COMMENT 'Location No',
  `ref2` varchar(100) NOT NULL COMMENT 'Box/Roll No',
  `ref3` varchar(100) NOT NULL COMMENT 'Art No / ctex Width',
  `qty_rec` double(11,2) NOT NULL,
  `qty_issued` double(11,2) NOT NULL,
  `qty_ret` double(11,2) NOT NULL,
  `date` date NOT NULL,
  `log_user` varchar(50) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL COMMENT '0-Available, 1-Locked, 2-Completed',
  `ref4` varchar(10) NOT NULL COMMENT 'shade group',
  `ref5` varchar(10) NOT NULL COMMENT 'ctex Length',
  `ref6` varchar(10) NOT NULL COMMENT 'act width',
  `allotment_status` smallint(6) NOT NULL COMMENT 'Allotment Status for Roll Nos in Docket 0-Not Allocated 1-Allocated,2-Completed',
  `qty_allocated` double(11,2) NOT NULL COMMENT 'Allocated Quantities',
  `roll_joins` int(11) NOT NULL COMMENT 'To trace joins of a roll',
  `roll_status` tinyint(4) NOT NULL COMMENT '0-approved, 1-rejected, 2-partial rejected, 3-hold',
  `partial_appr_qty` double(10,2) NOT NULL COMMENT 'partial rejected quantity',
  `upload_file` varchar(200) DEFAULT NULL,
  `shrinkage_length` float NOT NULL DEFAULT '0',
  `shrinkage_width` float NOT NULL DEFAULT '0',
  `shrinkage_group` varchar(255) NOT NULL,
  `roll_remarks` varchar(255) NOT NULL,
  `rejection_reason` varchar(255) NOT NULL,
  `m3_call_status` enum('Y','N') DEFAULT 'N',
  `split_roll` varchar(50) DEFAULT NULL,
  `barcode_number` varchar(255) DEFAULT NULL,
  `ref_tid` int(11) DEFAULT '0',
  `shade_grp` varchar(10) DEFAULT NULL,
  `act_width_grp` varchar(10) DEFAULT NULL,
  `supplier_no` varchar(10) NOT NULL DEFAULT '0',
  `four_point_status` int(10) NOT NULL DEFAULT '0',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  KEY `lot_no` (`lot_no`),
  KEY `ref1` (`ref1`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=836 DEFAULT CHARSET=latin1;

/*Table structure for table `store_in_old` */

DROP TABLE IF EXISTS `store_in_old`;

CREATE TABLE `store_in_old` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `lot_no` varchar(150) NOT NULL,
  `ref1` varchar(50) NOT NULL COMMENT 'Location No',
  `ref2` varchar(100) NOT NULL COMMENT 'Box/Roll No',
  `ref3` varchar(100) NOT NULL COMMENT 'Art No / ctex Width',
  `qty_rec` double(11,2) NOT NULL,
  `qty_issued` double(11,2) DEFAULT NULL,
  `qty_ret` double(11,2) DEFAULT NULL,
  `date` date NOT NULL,
  `log_user` varchar(50) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `log_stamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0' COMMENT '0-Available, 1-Locked, 2-Completed',
  `ref4` varchar(10) DEFAULT NULL COMMENT 'shade group',
  `ref5` varchar(10) DEFAULT NULL COMMENT 'ctex Length',
  `ref6` varchar(10) DEFAULT NULL COMMENT 'act width',
  `allotment_status` smallint(6) DEFAULT '0' COMMENT 'Allotment Status for Roll Nos in Docket 0-Not Allocated 1-Allocated,2-Completed',
  `qty_allocated` double(11,2) DEFAULT NULL COMMENT 'Allocated Quantities',
  `roll_joins` int(11) DEFAULT NULL COMMENT 'To trace joins of a roll',
  `roll_status` tinyint(4) DEFAULT '0' COMMENT '0-approved, 1-rejected, 2-partial rejected, 3-hold',
  `partial_appr_qty` double(10,2) DEFAULT NULL COMMENT 'partial rejected quantity',
  `upload_file` varchar(200) DEFAULT NULL,
  `shrinkage_length` float NOT NULL DEFAULT '0',
  `shrinkage_width` float NOT NULL DEFAULT '0',
  `shrinkage_group` varchar(255) DEFAULT NULL,
  `roll_remarks` varchar(255) DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,
  `m3_call_status` enum('Y','N') DEFAULT 'N',
  `split_roll` varchar(50) DEFAULT NULL,
  `barcode_number` varchar(255) DEFAULT NULL,
  `ref_tid` int(11) DEFAULT '0',
  `shade_grp` varchar(10) DEFAULT NULL,
  `act_width_grp` varchar(10) DEFAULT NULL,
  `supplier_no` varchar(10) NOT NULL DEFAULT '0',
  `four_point_status` int(10) NOT NULL DEFAULT '0',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `store_in_1ix` (`lot_no`),
  KEY `store_in_2ix` (`barcode_number`),
  KEY `allotment_status` (`allotment_status`)
) ENGINE=InnoDB AUTO_INCREMENT=586 DEFAULT CHARSET=latin1;

/*Table structure for table `store_out` */

DROP TABLE IF EXISTS `store_out`;

CREATE TABLE `store_out` (
  `tid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tran_tid` bigint(20) unsigned NOT NULL,
  `qty_issued` float NOT NULL,
  `Style` tinytext,
  `Schedule` tinytext,
  `cutno` varchar(500) DEFAULT NULL,
  `date` date NOT NULL,
  `updated_by` varchar(20) NOT NULL,
  `remarks` tinytext NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`,`tran_tid`),
  KEY `cutno` (`cutno`),
  KEY `NewIndex1` (`tran_tid`),
  KEY `NewIndex2` (`tran_tid`,`qty_issued`),
  KEY `index_stock` (`tran_tid`,`date`)
) ENGINE=MyISAM AUTO_INCREMENT=38026 DEFAULT CHARSET=latin1;

/*Table structure for table `store_out_backup` */

DROP TABLE IF EXISTS `store_out_backup`;

CREATE TABLE `store_out_backup` (
  `tid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tran_tid` bigint(20) unsigned NOT NULL,
  `qty_issued` float NOT NULL,
  `Style` tinytext NOT NULL,
  `Schedule` tinytext NOT NULL,
  `cutno` tinytext NOT NULL,
  `date` date NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `remarks` tinytext NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`,`tran_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `store_returns` */

DROP TABLE IF EXISTS `store_returns`;

CREATE TABLE `store_returns` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `tran_tid` bigint(20) NOT NULL,
  `qty_returned` double NOT NULL,
  `date` date NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`tran_tid`,`qty_returned`,`date`)
) ENGINE=MyISAM AUTO_INCREMENT=362 DEFAULT CHARSET=latin1;

/*Table structure for table `supplier_performance_track` */

DROP TABLE IF EXISTS `supplier_performance_track`;

CREATE TABLE `supplier_performance_track` (
  `tid` varchar(50) NOT NULL,
  `bai1_rec` int(11) DEFAULT NULL,
  `weekno` int(11) DEFAULT NULL,
  `pkg_no` varchar(25) DEFAULT NULL,
  `invoice` varchar(25) DEFAULT NULL,
  `srdfs` date DEFAULT NULL,
  `srtfs` varchar(25) DEFAULT NULL,
  `srdfsw` varchar(25) NOT NULL,
  `insp_date` date DEFAULT NULL,
  `reldat` date DEFAULT NULL,
  `unique_id` varchar(50) DEFAULT NULL,
  `grn_date` date DEFAULT NULL,
  `entdate` date DEFAULT NULL,
  `buyer` varchar(100) DEFAULT NULL,
  `item` varchar(100) DEFAULT NULL,
  `lots_ref` varchar(250) DEFAULT NULL,
  `po_ref` varchar(50) DEFAULT NULL,
  `supplier_name` varchar(50) DEFAULT NULL,
  `quality` varchar(50) DEFAULT NULL,
  `rms` varchar(50) DEFAULT NULL,
  `const` varchar(50) DEFAULT NULL,
  `compo` varchar(50) DEFAULT NULL,
  `color_ref` varchar(50) DEFAULT NULL,
  `syp` varchar(50) DEFAULT NULL,
  `batch_ref` varchar(50) DEFAULT NULL,
  `rolls_count` int(11) DEFAULT NULL,
  `tktlen` decimal(16,2) DEFAULT NULL,
  `ctexlen` decimal(16,2) DEFAULT NULL,
  `lenper` decimal(16,2) DEFAULT NULL,
  `qty_insp` decimal(16,2) DEFAULT NULL,
  `qty_insp_act` decimal(16,2) DEFAULT NULL,
  `len_qty` decimal(16,2) DEFAULT NULL,
  `inches` varchar(10) DEFAULT NULL,
  `pur_width_ref` decimal(16,2) DEFAULT NULL,
  `act_width_ref` decimal(16,2) DEFAULT NULL,
  `pur_gsm` decimal(16,2) DEFAULT NULL,
  `act_gsm` decimal(16,2) DEFAULT NULL,
  `consumption` decimal(5,5) NOT NULL,
  `pts_prod` varchar(10) DEFAULT NULL,
  `fallout` varchar(10) DEFAULT NULL,
  `defects` varchar(25) DEFAULT NULL,
  `skew_cat_ref` varchar(10) DEFAULT NULL,
  `skew` varchar(25) DEFAULT NULL,
  `shrink_l` decimal(16,2) DEFAULT NULL,
  `shrink_w` decimal(16,2) DEFAULT NULL,
  `sup_test_rep` varchar(25) DEFAULT NULL,
  `inspec_per_rep` varchar(25) DEFAULT NULL,
  `cc_rep` varchar(25) DEFAULT NULL,
  `com_ref1` varchar(25) DEFAULT NULL,
  `reason_qty` decimal(16,2) DEFAULT NULL,
  `reason_name` varchar(20) DEFAULT NULL,
  `reason_ref_explode_ex` decimal(16,2) DEFAULT NULL,
  `reason_name1` varchar(20) DEFAULT NULL,
  `reason_ref_explode_ex1` decimal(16,2) DEFAULT NULL,
  `fab_tech` varchar(25) DEFAULT NULL,
  `high_pts_prod` varchar(10) DEFAULT NULL,
  `fall_out` varchar(10) DEFAULT NULL,
  `skew_bowing` varchar(10) DEFAULT NULL,
  `wirc_shading` varchar(10) DEFAULT NULL,
  `gsm` varchar(10) DEFAULT NULL,
  `others` varchar(10) DEFAULT NULL,
  `off_shade` varchar(10) DEFAULT NULL,
  `hand_feel` varchar(10) DEFAULT NULL,
  `length` varchar(10) DEFAULT NULL,
  `width` varchar(10) DEFAULT NULL,
  `test_report` varchar(10) DEFAULT NULL,
  `status_f` varchar(10) DEFAULT NULL,
  `impact` varchar(10) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL COMMENT 'To capture the log time of data registered.',
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `NewIndex1` (`grn_date`),
  KEY `NewIndex2` (`grn_date`,`supplier_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `supplier_performance_track_log` */

DROP TABLE IF EXISTS `supplier_performance_track_log`;

CREATE TABLE `supplier_performance_track_log` (
  `t_tid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` varchar(150) NOT NULL,
  `bai1_rec` double NOT NULL,
  `weekno` double NOT NULL,
  `pkg_no` varchar(75) NOT NULL,
  `invoice` varchar(75) NOT NULL,
  `srdfs` date NOT NULL,
  `srtfs` varchar(75) NOT NULL,
  `srdfsw` varchar(25) NOT NULL,
  `insp_date` date NOT NULL,
  `reldat` date NOT NULL,
  `unique_id` varchar(150) NOT NULL,
  `grn_date` date NOT NULL,
  `entdate` date NOT NULL,
  `buyer` varchar(300) NOT NULL,
  `item` varchar(300) NOT NULL,
  `lots_ref` varchar(750) NOT NULL,
  `po_ref` varchar(150) NOT NULL,
  `supplier_name` varchar(150) NOT NULL,
  `quality` varchar(150) NOT NULL,
  `rms` varchar(150) NOT NULL,
  `const` varchar(150) NOT NULL,
  `compo` varchar(150) NOT NULL,
  `color_ref` varchar(150) NOT NULL,
  `syp` varchar(150) NOT NULL,
  `batch_ref` varchar(150) NOT NULL,
  `rolls_count` double NOT NULL,
  `tktlen` decimal(16,2) DEFAULT NULL,
  `ctexlen` decimal(16,2) DEFAULT NULL,
  `lenper` decimal(16,2) DEFAULT NULL,
  `qty_insp` decimal(16,2) DEFAULT NULL,
  `qty_insp_act` decimal(16,2) DEFAULT NULL,
  `len_qty` decimal(16,2) DEFAULT NULL,
  `inches` varchar(30) NOT NULL,
  `pur_width_ref` decimal(16,2) DEFAULT NULL,
  `act_width_ref` decimal(16,2) DEFAULT NULL,
  `pur_gsm` decimal(16,2) DEFAULT NULL,
  `act_gsm` decimal(16,2) DEFAULT NULL,
  `consumption` decimal(5,5) NOT NULL,
  `pts_prod` varchar(30) NOT NULL,
  `fallout` varchar(30) NOT NULL,
  `defects` varchar(75) NOT NULL,
  `skew_cat_ref` varchar(30) NOT NULL,
  `skew` varchar(75) NOT NULL,
  `shrink_l` decimal(16,2) DEFAULT NULL,
  `shrink_w` decimal(16,2) DEFAULT NULL,
  `sup_test_rep` varchar(75) NOT NULL,
  `inspec_per_rep` varchar(75) NOT NULL,
  `cc_rep` varchar(75) NOT NULL,
  `com_ref1` varchar(75) NOT NULL,
  `reason_qty` decimal(16,2) DEFAULT NULL,
  `reason_name` varchar(60) NOT NULL,
  `reason_ref_explode_ex` decimal(16,2) DEFAULT NULL,
  `reason_name1` varchar(60) NOT NULL,
  `reason_ref_explode_ex1` decimal(16,2) DEFAULT NULL,
  `fab_tech` varchar(75) NOT NULL,
  `high_pts_prod` varchar(30) NOT NULL,
  `fall_out` varchar(30) NOT NULL,
  `skew_bowing` varchar(30) NOT NULL,
  `wirc_shading` varchar(30) NOT NULL,
  `gsm` varchar(30) NOT NULL,
  `others` varchar(30) NOT NULL,
  `off_shade` varchar(30) NOT NULL,
  `hand_feel` varchar(30) NOT NULL,
  `length` varchar(30) NOT NULL,
  `width` varchar(30) NOT NULL,
  `test_report` varchar(30) NOT NULL,
  `status_f` varchar(30) NOT NULL,
  `impact` varchar(30) NOT NULL,
  `host_name` varchar(30) NOT NULL,
  `user_name` varchar(35) NOT NULL,
  `log_time` datetime NOT NULL,
  `plant_code` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` varchar(120) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(120) DEFAULT NULL,
  `version_flag` int(11) DEFAULT NULL,
  `pts` varchar(50) DEFAULT NULL,
  `high_pts` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`t_tid`),
  KEY `NewIndex1` (`tid`,`grn_date`,`supplier_name`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

