/*
SQLyog Job Agent Version 8.4 Copyright(c) Webyog Softworks Pvt. Ltd. All Rights Reserved.


MySQL - 5.5.5-10.1.28-MariaDB : Database - bai_rm_pj1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Database structure for database `bai_rm_pj1` */

CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_rm_pj1` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_rm_pj1`;

/*Table structure for table `cwh_to_rmwh` */

DROP TABLE IF EXISTS `cwh_to_rmwh`;

CREATE TABLE `cwh_to_rmwh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL,
  `do_number` varchar(40) NOT NULL,
  `requisition_date` date NOT NULL,
  `style` varchar(100) NOT NULL,
  `schedule` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `item_description` varchar(100) NOT NULL,
  `proc_grp` varchar(100) NOT NULL,
  `material_item` varchar(100) NOT NULL,
  `material_color` varchar(100) NOT NULL,
  `material_size` varchar(100) NOT NULL,
  `consumption` decimal(15,6) NOT NULL,
  `co_qty` decimal(15,6) NOT NULL,
  `uom` varchar(100) NOT NULL,
  `required_qty` decimal(15,6) NOT NULL,
  `issued_qty` decimal(15,6) NOT NULL,
  `bal_to_issue` decimal(15,6) NOT NULL,
  `prod_grp` varchar(100) NOT NULL,
  `wh_code` varchar(100) NOT NULL,
  `price` decimal(17,6) NOT NULL,
  `status` varchar(60) NOT NULL DEFAULT 'Requested',
  `gmt_size` varchar(100) DEFAULT NULL,
  `tid` varchar(50) DEFAULT NULL,
  `requested_qnty` varchar(100) DEFAULT NULL,
  `production_start_date` date DEFAULT NULL,
  `rmwh_code` varchar(100) DEFAULT NULL,
  `wastage` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule` (`schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cwh_to_rmwh_temp` */

DROP TABLE IF EXISTS `cwh_to_rmwh_temp`;

CREATE TABLE `cwh_to_rmwh_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL,
  `do_number` varchar(40) NOT NULL,
  `requisition_date` date NOT NULL,
  `style` varchar(100) NOT NULL,
  `schedule` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `item_description` varchar(100) NOT NULL,
  `proc_grp` varchar(100) NOT NULL,
  `material_item` varchar(100) NOT NULL,
  `material_color` varchar(100) NOT NULL,
  `material_size` varchar(100) NOT NULL,
  `consumption` decimal(15,6) NOT NULL,
  `co_qty` decimal(15,6) NOT NULL,
  `uom` varchar(100) NOT NULL,
  `required_qty` decimal(15,6) NOT NULL,
  `issued_qty` decimal(15,6) NOT NULL,
  `bal_to_issue` decimal(15,6) NOT NULL,
  `prod_grp` varchar(100) NOT NULL,
  `wh_code` varchar(100) NOT NULL,
  `price` decimal(17,6) NOT NULL,
  `status` varchar(60) NOT NULL DEFAULT 'Requested',
  `gmt_size` varchar(100) DEFAULT NULL,
  `tid` varchar(50) DEFAULT NULL,
  `requested_qnty` varchar(100) DEFAULT NULL,
  `production_start_date` date DEFAULT NULL,
  `rmwh_code` varchar(100) DEFAULT NULL,
  `wastage` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule` (`schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `fabric_cad_allocation` */

DROP TABLE IF EXISTS `fabric_cad_allocation`;

CREATE TABLE `fabric_cad_allocation` (
  `tran_pin` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Transaction Track',
  `doc_no` int(11) DEFAULT NULL COMMENT 'Cut Docket No',
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
  PRIMARY KEY (`tran_pin`),
  KEY `doc_no` (`doc_no`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`tran_pin`)
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
  `complaint_cat_ref` int(11) NOT NULL
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
  `hostname` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_complaint_db_log` */

DROP TABLE IF EXISTS `inspection_complaint_db_log`;

CREATE TABLE `inspection_complaint_db_log` (
  `complaint_track_id` double DEFAULT NULL,
  `complaint_reason` varchar(450) DEFAULT NULL,
  `complaint_rej_qty` decimal(22,2) DEFAULT NULL,
  `complaint_rating` varchar(20) DEFAULT NULL,
  `complaint_commnets` blob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_complaint_reasons` */

DROP TABLE IF EXISTS `inspection_complaint_reasons`;

CREATE TABLE `inspection_complaint_reasons` (
  `sno` double DEFAULT NULL,
  `complaint_reason` varchar(1350) DEFAULT NULL,
  `Complaint_clasification` varchar(2700) DEFAULT NULL,
  `complaint_category` varchar(1350) DEFAULT NULL,
  `status` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_db` */

DROP TABLE IF EXISTS `inspection_db`;

CREATE TABLE `inspection_db` (
  `batch_ref` varchar(50) NOT NULL COMMENT 'Batch Reference1',
  `act_gsm` float NOT NULL COMMENT 'Actual GSM',
  `pur_width` float NOT NULL COMMENT 'Purchase Width',
  `act_width` float NOT NULL COMMENT 'Actual Width',
  `sp_rem` text NOT NULL COMMENT 'Special Remarks',
  `qty_insp` float NOT NULL COMMENT 'Quantity Inspected',
  `gmt_way` tinyint(4) NOT NULL COMMENT 'GMT Way (1-N/A, 2-One Way, 3-Two Way)',
  `pts` float NOT NULL COMMENT 'Points per 100 sq. yard',
  `fallout` float NOT NULL COMMENT 'Fallout Percentage',
  `skew` float NOT NULL COMMENT 'Skew',
  `skew_cat` tinyint(4) NOT NULL COMMENT 'Skew Category (1- Skewness, 2-Bowing)',
  `shrink_l` float NOT NULL COMMENT 'Residual Shrinkage for Length %',
  `shrink_w` float NOT NULL COMMENT 'Residual Shrinkage for Width',
  `supplier` tinyint(4) NOT NULL COMMENT 'Supplier Reference (As Per Code)',
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time Stamp for Unique ID',
  `unique_id` varchar(20) NOT NULL COMMENT 'Unique Track ID',
  `status` tinyint(4) NOT NULL COMMENT 'Status of Inspection/Confirmation/Communication',
  `track_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'tracking_id',
  `pur_gsm` float NOT NULL,
  `consumption` decimal(5,5) NOT NULL,
  PRIMARY KEY (`batch_ref`),
  UNIQUE KEY `track_id` (`track_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `inspection_supplier_db` */

DROP TABLE IF EXISTS `inspection_supplier_db`;

CREATE TABLE `inspection_supplier_db` (
  `product_code` varchar(90) NOT NULL COMMENT 'Product Code Name',
  `supplier_code` varchar(90) NOT NULL COMMENT 'Supplier Name',
  `complaint_no` double NOT NULL COMMENT 'Comaplint Number',
  `supplier_m3_code` varchar(900) NOT NULL COMMENT 'Supplier M3 Code',
  `color_code` varchar(10) NOT NULL COMMENT 'Color Code',
  `seq_no` int(11) NOT NULL COMMENT 'Sequence Number'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `location_db` */

DROP TABLE IF EXISTS `location_db`;

CREATE TABLE `location_db` (
  `location_id` varchar(50) NOT NULL,
  `product` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `sno` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sno`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`log_tran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `m3_fab_issue_track` */

DROP TABLE IF EXISTS `m3_fab_issue_track`;

CREATE TABLE `m3_fab_issue_track` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_ref` varchar(30) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `section` int(11) NOT NULL,
  `picking_list` varchar(30) NOT NULL,
  `delivery_no` varchar(30) NOT NULL,
  `issued_by` varchar(15) NOT NULL,
  `movex_update` smallint(6) NOT NULL,
  `manual_issue` smallint(6) NOT NULL,
  `log_user` varchar(15) NOT NULL,
  `product` varchar(30) NOT NULL,
  PRIMARY KEY (`tran_id`),
  KEY `doc_ref` (`doc_ref`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `reconcile_db` */

DROP TABLE IF EXISTS `reconcile_db`;

CREATE TABLE `reconcile_db` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `lastup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lot_no` varchar(100) NOT NULL,
  `item` varchar(200) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `uom` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `sheet_ref` varchar(60) NOT NULL,
  `ref` varchar(100) NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `reject_reasons` */

DROP TABLE IF EXISTS `reject_reasons`;

CREATE TABLE `reject_reasons` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `reject_code` varchar(50) DEFAULT NULL,
  `reject_desc` varchar(100) DEFAULT NULL,
  UNIQUE KEY `tid` (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;

/*Table structure for table `sheet1$` */

DROP TABLE IF EXISTS `sheet1$`;

CREATE TABLE `sheet1$` (
  `01` varchar(255) DEFAULT NULL,
  `Off shandes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `sticker_report` */

DROP TABLE IF EXISTS `sticker_report`;

CREATE TABLE `sticker_report` (
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
  PRIMARY KEY (`lot_no`),
  KEY `lot_no` (`lot_no`),
  KEY `item` (`item`),
  KEY `inv_no` (`inv_no`,`batch_no`),
  KEY `batch_no` (`batch_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`lot_no`),
  KEY `lot_no` (`lot_no`),
  KEY `item` (`item`),
  KEY `inv_no` (`inv_no`,`batch_no`),
  KEY `batch_no` (`batch_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `store_in` */

DROP TABLE IF EXISTS `store_in`;

CREATE TABLE `store_in` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `lot_no` varchar(150) NOT NULL,
  `ref1` varchar(50) NOT NULL COMMENT 'Location No',
  `ref2` varchar(100) NOT NULL COMMENT 'Box/Roll No',
  `ref3` varchar(100) NOT NULL COMMENT 'Art No / ctex Width',
  `qty_rec` double(11,2) NOT NULL,
  `qty_issued` double(11,2) NOT NULL,
  `qty_ret` double(11,2) NOT NULL,
  `date` date NOT NULL,
  `log_user` int(11) NOT NULL,
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
  PRIMARY KEY (`tid`),
  KEY `lot_no` (`lot_no`),
  KEY `ref1` (`ref1`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

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
  `log_user` int(11) NOT NULL,
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
  PRIMARY KEY (`tid`),
  KEY `lot_no` (`lot_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `store_in_deleted` */

DROP TABLE IF EXISTS `store_in_deleted`;

CREATE TABLE `store_in_deleted` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `lot_no` varchar(150) NOT NULL,
  `ref1` varchar(50) NOT NULL COMMENT 'Location No',
  `ref2` varchar(100) NOT NULL COMMENT 'Box No',
  `ref3` varchar(100) NOT NULL COMMENT 'Art No',
  `qty_rec` double NOT NULL,
  `qty_issued` double NOT NULL,
  `qty_ret` double NOT NULL,
  `date` date NOT NULL,
  `log_user` varchar(50) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `ref4` varchar(10) NOT NULL COMMENT 'shade group',
  `ref5` varchar(10) NOT NULL,
  `ref6` varchar(10) NOT NULL,
  `allotment_status` smallint(6) NOT NULL,
  `qty_allocated` double(11,2) NOT NULL COMMENT 'Allocated Qty',
  `roll_joins` int(11) NOT NULL,
  `roll_status` tinyint(4) DEFAULT NULL,
  `partial_appr_qty` double(10,2) DEFAULT NULL,
  `upload_file` varchar(200) DEFAULT NULL,
  `shrinkage_length` float DEFAULT NULL,
  `shrinkage_width` float DEFAULT NULL,
  `shrinkage_group` varchar(255) DEFAULT NULL,
  `roll_remarks` varchar(255) DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,
  `m3_call_status` enum('Y','N') DEFAULT 'N',
  `split_roll` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `lot_no` (`lot_no`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `store_in_insp_audit_log_temp` */

DROP TABLE IF EXISTS `store_in_insp_audit_log_temp`;

CREATE TABLE `store_in_insp_audit_log_temp` (
  `tid` bigint(20) NOT NULL,
  `lot_no` varchar(150) NOT NULL,
  `ref1` varchar(50) NOT NULL COMMENT 'Location No',
  `ref2` varchar(100) NOT NULL COMMENT 'Box/Roll No',
  `ref3` varchar(100) NOT NULL COMMENT 'Art No / ctex Width',
  `qty_rec` double(11,2) NOT NULL,
  `qty_issued` double(11,2) NOT NULL,
  `qty_ret` double(11,2) NOT NULL,
  `date` date NOT NULL,
  `log_user` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL COMMENT '0-Available, 1-Locked, 2-Completed',
  `ref4` varchar(10) NOT NULL COMMENT 'shade group',
  `ref5` varchar(10) NOT NULL COMMENT 'ctex Length',
  `ref6` varchar(10) NOT NULL COMMENT 'act width',
  `allotment_status` smallint(6) NOT NULL COMMENT 'Allotment Status for Roll Nos in Docket 0-Not Allocated 1-Allocated,2-Completed',
  `qty_allocated` double(11,2) NOT NULL COMMENT 'Allocated Quantities',
  `roll_joins` int(11) NOT NULL COMMENT 'To trace joins of a roll',
  `audit_log_time_stamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `audit_user` varchar(50) NOT NULL,
  `audit_operation` varchar(10) NOT NULL,
  `roll_status` tinyint(4) DEFAULT NULL,
  `partial_appr_qty` double(10,2) DEFAULT NULL,
  KEY `lot_no` (`lot_no`),
  KEY `ref1` (`ref1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `store_in_insp_temp` */

DROP TABLE IF EXISTS `store_in_insp_temp`;

CREATE TABLE `store_in_insp_temp` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `lot_no` varchar(150) NOT NULL,
  `ref1` varchar(50) NOT NULL COMMENT 'Location No',
  `ref2` varchar(100) NOT NULL COMMENT 'Box/Roll No',
  `ref3` varchar(100) NOT NULL COMMENT 'Art No / ctex Width',
  `qty_rec` double(11,2) NOT NULL,
  `qty_issued` double(11,2) NOT NULL,
  `qty_ret` double(11,2) NOT NULL,
  `date` date NOT NULL,
  `log_user` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL COMMENT '0-Available, 1-Locked, 2-Completed',
  `ref4` varchar(10) NOT NULL COMMENT 'shade group',
  `ref5` varchar(10) NOT NULL COMMENT 'ctex Length',
  `ref6` varchar(10) NOT NULL COMMENT 'act width',
  `allotment_status` smallint(6) NOT NULL COMMENT 'Allotment Status for Roll Nos in Docket 0-Not Allocated 1-Allocated,2-Completed',
  `qty_allocated` double(11,2) NOT NULL COMMENT 'Allocated Quantities',
  `roll_joins` int(11) NOT NULL,
  `roll_status` tinyint(4) DEFAULT NULL,
  `partial_appr_qty` double(10,2) DEFAULT NULL,
  `upload_file` varchar(50) DEFAULT NULL,
  `shrinkage_length` float DEFAULT NULL,
  `shrinkage_width` float DEFAULT NULL,
  `shrinkage_group` varchar(50) DEFAULT NULL,
  `roll_remarks` varchar(50) DEFAULT NULL,
  `rejection_reason` varchar(50) DEFAULT NULL,
  `m3_call_status` enum('Y','N') DEFAULT 'N',
  `split_roll` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  KEY `lot_no` (`lot_no`),
  KEY `ref1` (`ref1`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Table structure for table `store_out` */

DROP TABLE IF EXISTS `store_out`;

CREATE TABLE `store_out` (
  `tid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tran_tid` bigint(20) unsigned NOT NULL,
  `qty_issued` float NOT NULL,
  `Style` tinytext NOT NULL,
  `Schedule` tinytext NOT NULL,
  `cutno` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `updated_by` varchar(20) NOT NULL,
  `remarks` tinytext NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tid`,`tran_tid`),
  KEY `cutno` (`cutno`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
  `updated_by` tinyint(2) unsigned NOT NULL,
  `remarks` tinytext NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tid`,`tran_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `store_returns` */

DROP TABLE IF EXISTS `store_returns`;

CREATE TABLE `store_returns` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `tran_tid` bigint(20) NOT NULL,
  `qty_returned` double NOT NULL,
  `date` date NOT NULL,
  `updated_by` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `log_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `pts` varchar(10) DEFAULT NULL,
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
  `high_pts` varchar(10) DEFAULT NULL,
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
  PRIMARY KEY (`tid`)
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
  `pts` varchar(30) NOT NULL,
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
  `high_pts` varchar(30) NOT NULL,
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
  PRIMARY KEY (`t_tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Function  structure for function  `fn_roll_id_fab_scan_status` */

/*!50003 DROP FUNCTION IF EXISTS `fn_roll_id_fab_scan_status` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`baiall`@`%` FUNCTION `fn_roll_id_fab_scan_status`(doc_id BIGINT,doc_type VARCHAR(15), roll_id BIGINT) RETURNS int(11)
BEGIN
DECLARE doc_prf_str VARCHAR(1);
    DECLARE ret_val INT;
    
	IF doc_type='normal' THEN
		SET ret_val=COALESCE((SELECT IF(fabric_status='5' OR act_cut_status='DONE',1,0) FROM bai_pro3.plandoc_stat_log WHERE doc_no=doc_id),0);
		SET ret_val=ret_val+COALESCE((SELECT COUNT(tid) FROM bai_rm_pj1.store_out WHERE tran_tid=roll_id AND UCASE(cutno) IN (CONCAT('D',doc_id),CONCAT('E',doc_id))),0);
	ELSE
		SET ret_val=COALESCE((SELECT IF(fabric_status='5' OR act_cut_status='DONE',1,0) FROM bai_pro3.recut_v2 WHERE doc_no=doc_id),0);
		SET ret_val=ret_val+COALESCE((SELECT COUNT(tid) FROM bai_rm_pj1.store_out WHERE tran_tid=roll_id AND UCASE(cutno)=CONCAT('R',doc_id)),0);
	END IF;
	
	/* return 1 if the docket or recut status is fabric issued or cut completed or available in scan out transaction.*/
	IF ret_val>0 THEN
		RETURN 1;
	ELSE
		RETURN 0;
	END IF;
END */$$
DELIMITER ;

/*Table structure for table `docket_ref` */

DROP TABLE IF EXISTS `docket_ref`;

/*!50001 DROP VIEW IF EXISTS `docket_ref` */;
/*!50001 DROP TABLE IF EXISTS `docket_ref` */;

/*!50001 CREATE TABLE  `docket_ref`(
 `tran_pin` int(11) ,
 `doc_no` int(11) ,
 `roll_id` int(11) ,
 `roll_width` float ,
 `plies` int(11) ,
 `mk_len` float ,
 `doc_type` varchar(12) ,
 `log_time` timestamp ,
 `allocated_qty` float ,
 `ref1` varchar(50) ,
 `lot_no` varchar(150) ,
 `batch_no` varchar(200) ,
 `item_desc` varchar(200) ,
 `item_name` varchar(200) ,
 `item` varchar(200) ,
 `ref2` varchar(100) ,
 `ref3` varchar(100) ,
 `ref4` varchar(10) ,
 `ref5` varchar(10) ,
 `ref6` varchar(10) ,
 `pkg_no` varchar(50) ,
 `status` int(11) ,
 `grn_date` varchar(50) ,
 `remarks` varchar(200) ,
 `tid` bigint(20) ,
 `qty_rec` double(11,2) ,
 `qty_issued` double(11,2) ,
 `qty_ret` double(11,2) ,
 `inv_no` varchar(100) 
)*/;

/*Table structure for table `fabric_status` */

DROP TABLE IF EXISTS `fabric_status`;

/*!50001 DROP VIEW IF EXISTS `fabric_status` */;
/*!50001 DROP TABLE IF EXISTS `fabric_status` */;

/*!50001 CREATE TABLE  `fabric_status`(
 `ref1` varchar(50) ,
 `lot_no` text ,
 `batch_no` varchar(200) ,
 `item_desc` varchar(200) ,
 `item_name` varchar(200) ,
 `item` varchar(200) ,
 `ref2` varchar(100) ,
 `ref3` varchar(100) ,
 `pkg_no` varchar(50) ,
 `status` int(11) ,
 `grn_date` varchar(50) ,
 `remarks` varchar(200) ,
 `tid` bigint(20) ,
 `qty_rec` double(11,2) ,
 `qty_issued` double(11,2) ,
 `qty_ret` double(11,2) ,
 `product_group` varchar(150) ,
 `allocated_qty` float ,
 `rec_qty` double(19,2) ,
 `balance` double(19,2) 
)*/;

/*Table structure for table `fabric_status_v1` */

DROP TABLE IF EXISTS `fabric_status_v1`;

/*!50001 DROP VIEW IF EXISTS `fabric_status_v1` */;
/*!50001 DROP TABLE IF EXISTS `fabric_status_v1` */;

/*!50001 CREATE TABLE  `fabric_status_v1`(
 `ref1` varchar(50) ,
 `lot_no` varchar(150) ,
 `batch_no` varchar(200) ,
 `item_desc` varchar(200) ,
 `item_name` varchar(200) ,
 `item` varchar(200) ,
 `ref2` varchar(100) ,
 `ref3` varchar(100) ,
 `ref4` varchar(10) ,
 `allotment_status` smallint(6) ,
 `pkg_no` varchar(50) ,
 `status` int(11) ,
 `grn_date` varchar(50) ,
 `remarks` varchar(200) ,
 `tid` bigint(20) ,
 `qty_rec` double(19,2) ,
 `qty_issued` double(11,2) ,
 `qty_ret` double(11,2) ,
 `product_group` varchar(150) ,
 `allocated_qty` float ,
 `rec_qty` double(17,0) ,
 `balance` double(17,0) 
)*/;

/*Table structure for table `fabric_status_v2` */

DROP TABLE IF EXISTS `fabric_status_v2`;

/*!50001 DROP VIEW IF EXISTS `fabric_status_v2` */;
/*!50001 DROP TABLE IF EXISTS `fabric_status_v2` */;

/*!50001 CREATE TABLE  `fabric_status_v2`(
 `ref1` varchar(50) ,
 `lot_no` text ,
 `batch_no` varchar(200) ,
 `inv_no` varchar(100) ,
 `item_desc` varchar(200) ,
 `item_name` varchar(200) ,
 `item` varchar(200) ,
 `ref5` varchar(10) ,
 `ref2` varchar(100) ,
 `ref3` varchar(100) ,
 `ref6` varchar(10) ,
 `pkg_no` varchar(50) ,
 `status` int(11) ,
 `grn_date` varchar(50) ,
 `remarks` varchar(200) ,
 `tid` bigint(20) ,
 `qty_rec` double(11,2) ,
 `qty_issued` double(11,2) ,
 `qty_ret` double(11,2) ,
 `shade` varchar(10) ,
 `allotment_status` smallint(6) ,
 `product_group` varchar(150) ,
 `allocated_qty` float ,
 `width` varchar(100) ,
 `rec_qty` double(19,2) ,
 `balance` double(19,2) 
)*/;

/*Table structure for table `fabric_status_v3` */

DROP TABLE IF EXISTS `fabric_status_v3`;

/*!50001 DROP VIEW IF EXISTS `fabric_status_v3` */;
/*!50001 DROP TABLE IF EXISTS `fabric_status_v3` */;

/*!50001 CREATE TABLE  `fabric_status_v3`(
 `ref1` varchar(50) ,
 `lot_no` text ,
 `batch_no` varchar(200) ,
 `inv_no` varchar(100) ,
 `item_desc` varchar(200) ,
 `item_name` varchar(200) ,
 `item` varchar(200) ,
 `ref5` varchar(10) ,
 `ref2` varchar(100) ,
 `ref3` varchar(100) ,
 `ref6` varchar(10) ,
 `pkg_no` varchar(50) ,
 `status` int(11) ,
 `grn_date` varchar(50) ,
 `remarks` varchar(200) ,
 `tid` bigint(20) ,
 `qty_rec` double(11,2) ,
 `qty_issued` double(11,2) ,
 `qty_ret` double(11,2) ,
 `qty_allocated` double(11,2) ,
 `partial_appr_qty` double(10,2) ,
 `shade` varchar(10) ,
 `allotment_status` smallint(6) ,
 `roll_status` tinyint(4) ,
 `shrinkage_length` float ,
 `shrinkage_width` float ,
 `shrinkage_group` varchar(255) ,
 `roll_remarks` tinyint(4) ,
 `product_group` varchar(150) ,
 `allocated_qty` float ,
 `width` varchar(100) ,
 `rec_qty` double(19,2) ,
 `balance` double(19,2) 
)*/;

/*Table structure for table `grn_track_pendings` */

DROP TABLE IF EXISTS `grn_track_pendings`;

/*!50001 DROP VIEW IF EXISTS `grn_track_pendings` */;
/*!50001 DROP TABLE IF EXISTS `grn_track_pendings` */;

/*!50001 CREATE TABLE  `grn_track_pendings`(
 `product` varchar(150) ,
 `lot_no` varchar(100) ,
 `grn_qty` double ,
 `qty_rec` double(19,2) ,
 `qty_diff` double(19,2) ,
 `label_pending` int(1) ,
 `date` date ,
 `shade_pending` decimal(23,0) ,
 `location_pending` decimal(23,0) ,
 `balance` double(19,2) ,
 `ctax_pending` int(1) ,
 `ctax_pending_rolls` text 
)*/;

/*Table structure for table `sticker_ref` */

DROP TABLE IF EXISTS `sticker_ref`;

/*!50001 DROP VIEW IF EXISTS `sticker_ref` */;
/*!50001 DROP TABLE IF EXISTS `sticker_ref` */;

/*!50001 CREATE TABLE  `sticker_ref`(
 `ref1` varchar(50) ,
 `lot_no` varchar(150) ,
 `batch_no` varchar(200) ,
 `item_desc` varchar(200) ,
 `item_name` varchar(200) ,
 `item` varchar(200) ,
 `inv_no` varchar(100) ,
 `ref2` varchar(100) ,
 `ref3` varchar(100) ,
 `ref4` varchar(10) ,
 `ref5` varchar(10) ,
 `ref6` varchar(10) ,
 `pkg_no` varchar(50) ,
 `status` int(11) ,
 `grn_date` varchar(50) ,
 `remarks` varchar(200) ,
 `tid` bigint(20) ,
 `qty_rec` double(11,2) ,
 `qty_issued` double(11,2) ,
 `qty_ret` double(11,2) 
)*/;

/*Table structure for table `stock_report` */

DROP TABLE IF EXISTS `stock_report`;

/*!50001 DROP VIEW IF EXISTS `stock_report` */;
/*!50001 DROP TABLE IF EXISTS `stock_report` */;

/*!50001 CREATE TABLE  `stock_report`(
 `ref1` varchar(50) ,
 `lot_no` varchar(150) ,
 `batch_no` varchar(200) ,
 `item_desc` varchar(200) ,
 `item_name` varchar(200) ,
 `item` varchar(200) ,
 `supplier` varchar(300) ,
 `buyer` varchar(200) ,
 `ref2` varchar(100) ,
 `ref3` varchar(100) ,
 `pkg_no` varchar(50) ,
 `status` int(11) ,
 `grn_date` varchar(50) ,
 `remarks` varchar(200) ,
 `tid` bigint(20) ,
 `qty_rec` double(11,2) ,
 `qty_issued` double(11,2) ,
 `qty_ret` double(11,2) ,
 `balance` double(19,2) ,
 `product_group` varchar(150) 
)*/;

/*Table structure for table `store_in_weekly_backup` */

DROP TABLE IF EXISTS `store_in_weekly_backup`;

/*!50001 DROP VIEW IF EXISTS `store_in_weekly_backup` */;
/*!50001 DROP TABLE IF EXISTS `store_in_weekly_backup` */;

/*!50001 CREATE TABLE  `store_in_weekly_backup`(
 `lot_no` varchar(100) ,
 `sticker_qty` double(19,2) ,
 `grn_qty` double(19,2) ,
 `Recieved_Qty` double(19,2) ,
 `Returned_Qty` double(19,2) ,
 `Issued_Qty` double(19,2) ,
 `Available_Qty` double(19,2) 
)*/;

/*View structure for view docket_ref */

/*!50001 DROP TABLE IF EXISTS `docket_ref` */;
/*!50001 DROP VIEW IF EXISTS `docket_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `docket_ref` AS (select `fabric_cad_allocation`.`tran_pin` AS `tran_pin`,`fabric_cad_allocation`.`doc_no` AS `doc_no`,`fabric_cad_allocation`.`roll_id` AS `roll_id`,`fabric_cad_allocation`.`roll_width` AS `roll_width`,`fabric_cad_allocation`.`plies` AS `plies`,`fabric_cad_allocation`.`mk_len` AS `mk_len`,`fabric_cad_allocation`.`doc_type` AS `doc_type`,`fabric_cad_allocation`.`log_time` AS `log_time`,`fabric_cad_allocation`.`allocated_qty` AS `allocated_qty`,`sticker_ref`.`ref1` AS `ref1`,`sticker_ref`.`lot_no` AS `lot_no`,`sticker_ref`.`batch_no` AS `batch_no`,`sticker_ref`.`item_desc` AS `item_desc`,`sticker_ref`.`item_name` AS `item_name`,`sticker_ref`.`item` AS `item`,`sticker_ref`.`ref2` AS `ref2`,`sticker_ref`.`ref3` AS `ref3`,`sticker_ref`.`ref4` AS `ref4`,`sticker_ref`.`ref5` AS `ref5`,`sticker_ref`.`ref6` AS `ref6`,`sticker_ref`.`pkg_no` AS `pkg_no`,`sticker_ref`.`status` AS `status`,`sticker_ref`.`grn_date` AS `grn_date`,`sticker_ref`.`remarks` AS `remarks`,`sticker_ref`.`tid` AS `tid`,`sticker_ref`.`qty_rec` AS `qty_rec`,`sticker_ref`.`qty_issued` AS `qty_issued`,`sticker_ref`.`qty_ret` AS `qty_ret`,`sticker_ref`.`inv_no` AS `inv_no` from (`fabric_cad_allocation` left join `sticker_ref` on((`fabric_cad_allocation`.`roll_id` = `sticker_ref`.`tid`)))) */;

/*View structure for view fabric_status */

/*!50001 DROP TABLE IF EXISTS `fabric_status` */;
/*!50001 DROP VIEW IF EXISTS `fabric_status` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fabric_status` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round(((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),2)),2) AS `balance` from (`store_in` join `sticker_report`) where ((`sticker_report`.`product_group` like '%fabric%') and (((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0) and (`store_in`.`lot_no` = `sticker_report`.`lot_no`)) group by `store_in`.`lot_no`) */;

/*View structure for view fabric_status_v1 */

/*!50001 DROP TABLE IF EXISTS `fabric_status_v1` */;
/*!50001 DROP VIEW IF EXISTS `fabric_status_v1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fabric_status_v1` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref4` AS `ref4`,`store_in`.`allotment_status` AS `allotment_status`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,round(coalesce(`store_in`.`ref5`,0),2) AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,round(coalesce(`store_in`.`ref5`,0),0) AS `rec_qty`,round(((round(coalesce(`store_in`.`ref5`,0),2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),0) AS `balance` from (`store_in` join `sticker_report`) where ((`store_in`.`lot_no` = `sticker_report`.`lot_no`) and (((round(coalesce(`store_in`.`ref5`,0),2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0) and (`sticker_report`.`product_group` like '%fabric%'))) */;

/*View structure for view fabric_status_v2 */

/*!50001 DROP TABLE IF EXISTS `fabric_status_v2` */;
/*!50001 DROP VIEW IF EXISTS `fabric_status_v2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fabric_status_v2` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`inv_no` AS `inv_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`store_in`.`ref4` AS `shade`,`store_in`.`allotment_status` AS `allotment_status`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,if(((length(`store_in`.`ref3`) > 0) and (`store_in`.`ref3` <> 0)),`store_in`.`ref3`,`store_in`.`ref6`) AS `width`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round(((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),2)),2) AS `balance` from (`store_in` join `sticker_report`) where ((`store_in`.`lot_no` = `sticker_report`.`lot_no`) and (((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0) and (`sticker_report`.`product_group` like '%fabric%') and (`store_in`.`allotment_status` in (0,1)) and (length(`store_in`.`ref4`) > 0)) group by `store_in`.`tid`) */;

/*View structure for view fabric_status_v3 */

/*!50001 DROP TABLE IF EXISTS `fabric_status_v3` */;
/*!50001 DROP VIEW IF EXISTS `fabric_status_v3` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fabric_status_v3` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`inv_no` AS `inv_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`store_in`.`qty_allocated` AS `qty_allocated`,`store_in`.`partial_appr_qty` AS `partial_appr_qty`,`store_in`.`ref4` AS `shade`,`store_in`.`allotment_status` AS `allotment_status`,`store_in`.`roll_status` AS `roll_status`,`store_in`.`shrinkage_length` AS `shrinkage_length`,`store_in`.`shrinkage_width` AS `shrinkage_width`,`store_in`.`shrinkage_group` AS `shrinkage_group`,`store_in`.`roll_status` AS `roll_remarks`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,if(((length(`store_in`.`ref3`) > 0) and (`store_in`.`ref3` <> 0)),`store_in`.`ref3`,`store_in`.`ref6`) AS `width`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round((((round(`store_in`.`qty_rec`,2) - round(`store_in`.`partial_appr_qty`,2)) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),2)),2) AS `balance` from (`store_in` join `sticker_report`) where ((`sticker_report`.`product_group` like '%fabric%') and (((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0) and (`store_in`.`allotment_status` in (0,1,2)) and (`store_in`.`lot_no` = `sticker_report`.`lot_no`) and (`store_in`.`roll_status` in (0,2))) group by `store_in`.`tid`) */;

/*View structure for view grn_track_pendings */

/*!50001 DROP TABLE IF EXISTS `grn_track_pendings` */;
/*!50001 DROP VIEW IF EXISTS `grn_track_pendings` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `grn_track_pendings` AS (select trim(`sticker_report`.`product_group`) AS `product`,`sticker_report`.`lot_no` AS `lot_no`,`sticker_report`.`rec_qty` AS `grn_qty`,coalesce(sum(`store_in`.`qty_rec`),0) AS `qty_rec`,(round(`sticker_report`.`rec_qty`,2) - coalesce(sum(round(`store_in`.`qty_rec`,2)),0)) AS `qty_diff`,if(((round(`sticker_report`.`rec_qty`,2) - coalesce(sum(round(`store_in`.`qty_rec`,2)),0)) >= 1),1,0) AS `label_pending`,cast(`sticker_report`.`grn_date` as date) AS `date`,sum(if(((`store_in`.`ref4` = '') and (trim(`sticker_report`.`product_group`) = 'Fabric')),1,0)) AS `shade_pending`,sum(if((`store_in`.`ref1` = ''),1,0)) AS `location_pending`,((sum(round(`store_in`.`qty_rec`,2)) - sum(round(`store_in`.`qty_issued`,2))) + sum(round(`store_in`.`qty_ret`,2))) AS `balance`,if(((length(`store_in`.`ref3`) <= 1) and (trim(`sticker_report`.`product_group`) = 'Fabric')),1,0) AS `ctax_pending`,replace(replace(group_concat(if(((length(`store_in`.`ref3`) <= 1) and (trim(`sticker_report`.`product_group`) = 'Fabric')),concat(`store_in`.`ref2`,'@',`store_in`.`ref1`),'x') separator ','),'x,',''),'x','') AS `ctax_pending_rolls` from (`sticker_report` left join `store_in` on((`sticker_report`.`lot_no` = `store_in`.`lot_no`))) where ((cast(`sticker_report`.`grn_date` as date) > '2011-09-1') and (`sticker_report`.`backup_status` = 0)) group by `sticker_report`.`lot_no`) */;

/*View structure for view sticker_ref */

/*!50001 DROP TABLE IF EXISTS `sticker_ref` */;
/*!50001 DROP VIEW IF EXISTS `sticker_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `sticker_ref` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`sticker_report`.`inv_no` AS `inv_no`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref4` AS `ref4`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret` from (`store_in` join `sticker_report`) where (`store_in`.`lot_no` = `sticker_report`.`lot_no`)) */;

/*View structure for view stock_report */

/*!50001 DROP TABLE IF EXISTS `stock_report` */;
/*!50001 DROP VIEW IF EXISTS `stock_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock_report` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`sticker_report`.`supplier` AS `supplier`,`sticker_report`.`buyer` AS `buyer`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,round(((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),2) AS `balance`,`sticker_report`.`product_group` AS `product_group` from (`store_in` join `sticker_report`) where ((`store_in`.`lot_no` = `sticker_report`.`lot_no`) and (((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0))) */;

/*View structure for view store_in_weekly_backup */

/*!50001 DROP TABLE IF EXISTS `store_in_weekly_backup` */;
/*!50001 DROP VIEW IF EXISTS `store_in_weekly_backup` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `store_in_weekly_backup` AS (select `sticker_report`.`lot_no` AS `lot_no`,sum(`store_in`.`qty_rec`) AS `sticker_qty`,round(sum(`sticker_report`.`rec_qty`),2) AS `grn_qty`,sum(`store_in`.`qty_rec`) AS `Recieved_Qty`,sum(`store_in`.`qty_ret`) AS `Returned_Qty`,sum(`store_in`.`qty_issued`) AS `Issued_Qty`,((sum(`store_in`.`qty_rec`) + sum(`store_in`.`qty_ret`)) - sum(`store_in`.`qty_issued`)) AS `Available_Qty` from (`store_in` left join `sticker_report` on((`store_in`.`lot_no` = `sticker_report`.`lot_no`))) where (`store_in`.`date` < (curdate() + interval -(15) day)) group by trim(`store_in`.`lot_no`) having (((sum(`store_in`.`qty_rec`) + sum(`store_in`.`qty_ret`)) - sum(`store_in`.`qty_issued`)) = 0)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
