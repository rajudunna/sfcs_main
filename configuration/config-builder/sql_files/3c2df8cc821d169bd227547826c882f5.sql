/*
SQLyog Job Agent Version 8.4 Copyright(c) Webyog Softworks Pvt. Ltd. All Rights Reserved.


MySQL - 5.5.5-10.1.28-MariaDB : Database - bai3_finishing
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Database structure for database `bai3_finishing` */

CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai3_finishing` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai3_finishing`;

/*Table structure for table `barcode_mapping` */

DROP TABLE IF EXISTS `barcode_mapping`;

CREATE TABLE `barcode_mapping` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(60) NOT NULL,
  `schedule` varchar(60) NOT NULL,
  `size` varchar(60) NOT NULL,
  `color` varchar(60) NOT NULL,
  `out_qty` varchar(60) NOT NULL,
  `barcode` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `module` varchar(45) NOT NULL,
  `shift` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `log_time` datetime NOT NULL,
  `bin_barcode` varchar(80) NOT NULL,
  `bin_rand_no` varchar(60) NOT NULL,
  `c_block` varchar(16) NOT NULL COMMENT 'Country Block',
  `unique_code` varchar(350) NOT NULL COMMENT 'Unique_code',
  `m3_sync_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `unique_code` (`unique_code`),
  KEY `style` (`style`,`schedule`,`size`,`color`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `barcode_mapping_archive` */

DROP TABLE IF EXISTS `barcode_mapping_archive`;

CREATE TABLE `barcode_mapping_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(60) NOT NULL,
  `schedule` varchar(60) NOT NULL,
  `size` varchar(60) NOT NULL,
  `color` varchar(60) NOT NULL,
  `out_qty` varchar(60) NOT NULL,
  `barcode` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `module` varchar(45) NOT NULL,
  `shift` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `log_time` datetime NOT NULL,
  `bin_barcode` varchar(80) NOT NULL,
  `bin_rand_no` varchar(60) NOT NULL,
  `c_block` varchar(16) NOT NULL COMMENT 'Country Block',
  `unique_code` varchar(350) NOT NULL COMMENT 'Unique_code',
  `m3_sync_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `unique_code` (`unique_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `barcode_mapping_tmp` */

DROP TABLE IF EXISTS `barcode_mapping_tmp`;

CREATE TABLE `barcode_mapping_tmp` (
  `tid` int(11) DEFAULT NULL,
  `style` varchar(180) DEFAULT NULL,
  `schedule` varchar(180) DEFAULT NULL,
  `size` varchar(60) DEFAULT NULL,
  `color` varchar(180) DEFAULT NULL,
  `out_qty` varchar(180) DEFAULT NULL,
  `barcode` varchar(180) DEFAULT NULL,
  `username` varchar(180) DEFAULT NULL,
  `module` varchar(135) DEFAULT NULL,
  `shift` varchar(135) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `bin_barcode` varchar(240) DEFAULT NULL,
  `bin_rand_no` varchar(60) DEFAULT NULL,
  `c_block` varchar(16) DEFAULT NULL COMMENT 'Country Block',
  `unique_code` varchar(350) DEFAULT NULL,
  `m3_sync_status` tinyint(4) DEFAULT NULL,
  UNIQUE KEY `unique_code` (`unique_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `barcode_update` */

DROP TABLE IF EXISTS `barcode_update`;

CREATE TABLE `barcode_update` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(60) DEFAULT NULL,
  `schedule` varchar(60) DEFAULT NULL,
  `size` varchar(60) DEFAULT NULL,
  `img_name` varchar(60) DEFAULT NULL,
  `img_size` varchar(60) DEFAULT NULL,
  `img_type` varchar(60) DEFAULT NULL,
  `barcode` varchar(60) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `c_block` varchar(16) DEFAULT NULL COMMENT 'Country Block',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `schedule` (`schedule`,`barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `barcode_update_archive` */

DROP TABLE IF EXISTS `barcode_update_archive`;

CREATE TABLE `barcode_update_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(60) DEFAULT NULL,
  `schedule` varchar(60) DEFAULT NULL,
  `size` varchar(60) DEFAULT NULL,
  `img_name` varchar(60) DEFAULT NULL,
  `img_size` varchar(60) DEFAULT NULL,
  `img_type` varchar(60) DEFAULT NULL,
  `barcode` varchar(60) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `c_block` varchar(16) DEFAULT NULL COMMENT 'Country Block',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `schedule` (`schedule`,`barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `input_update` */

DROP TABLE IF EXISTS `input_update`;

CREATE TABLE `input_update` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(60) DEFAULT NULL,
  `schedule` varchar(60) DEFAULT NULL,
  `size` varchar(60) DEFAULT NULL,
  `color` varchar(60) DEFAULT NULL,
  `ims_qty` varchar(60) DEFAULT NULL,
  `barcode` varchar(60) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `c_block` varchar(16) DEFAULT NULL COMMENT 'Country Block',
  PRIMARY KEY (`tid`),
  UNIQUE KEY `schedule` (`schedule`,`size`,`color`,`barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `input_update_archive` */

DROP TABLE IF EXISTS `input_update_archive`;

CREATE TABLE `input_update_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(60) DEFAULT NULL,
  `schedule` varchar(60) DEFAULT NULL,
  `size` varchar(60) DEFAULT NULL,
  `color` varchar(60) DEFAULT NULL,
  `ims_qty` varchar(60) DEFAULT NULL,
  `barcode` varchar(60) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `c_block` varchar(16) DEFAULT NULL COMMENT 'Country Block',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `order_db` */

DROP TABLE IF EXISTS `order_db`;

CREATE TABLE `order_db` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style_no` varchar(60) DEFAULT NULL,
  `schedule_no` varchar(60) DEFAULT NULL,
  `size_code` varchar(60) DEFAULT NULL,
  `color` varchar(60) DEFAULT NULL,
  `order_qty` varchar(60) DEFAULT NULL,
  `mo_status` varchar(60) DEFAULT NULL,
  `compo_no` varchar(60) DEFAULT NULL,
  `item_des` varchar(200) DEFAULT NULL,
  `order_yy` varchar(60) DEFAULT NULL,
  `col_des` varchar(60) DEFAULT NULL,
  `output` varchar(60) DEFAULT '0',
  `c_block` varchar(16) DEFAULT NULL COMMENT 'Country Block',
  `ex_date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `style_no` (`style_no`,`schedule_no`,`color`,`size_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `order_db_archive` */

DROP TABLE IF EXISTS `order_db_archive`;

CREATE TABLE `order_db_archive` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `style_no` varchar(60) DEFAULT NULL,
  `schedule_no` varchar(60) DEFAULT NULL,
  `size_code` varchar(60) DEFAULT NULL,
  `color` varchar(60) DEFAULT NULL,
  `order_qty` varchar(60) DEFAULT NULL,
  `mo_status` varchar(60) DEFAULT NULL,
  `compo_no` varchar(60) DEFAULT NULL,
  `item_des` varchar(200) DEFAULT NULL,
  `order_yy` varchar(60) DEFAULT NULL,
  `col_des` varchar(60) DEFAULT NULL,
  `output` varchar(60) DEFAULT '0',
  `c_block` varchar(16) DEFAULT NULL COMMENT 'Country Block',
  `ex_date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `style_no` (`style_no`,`schedule_no`,`color`,`size_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `station_db` */

DROP TABLE IF EXISTS `station_db`;

CREATE TABLE `station_db` (
  `station_id` varchar(20) NOT NULL COMMENT 'Station Barcode ID',
  `remarks` varchar(100) NOT NULL,
  PRIMARY KEY (`station_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Procedure structure for procedure `sync_fg_to_m3` */

/*!50003 DROP PROCEDURE IF EXISTS  `sync_fg_to_m3` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`baiall`@`%` PROCEDURE `sync_fg_to_m3`()
BEGIN
	declare prv_proc_tid,cur_proc_tid bigint;
	DECLARE swap_session_status VARCHAR(100);
	
	set @prv_proc_tid=(select fg_last_updated_tid from brandix_bts.snap_session_track where session_id=2);
	SET @swap_session_status=(SELECT fg_m3_sync_status FROM brandix_bts.snap_session_track WHERE session_id=2);
	
	IF(@swap_session_status='off') THEN	
	
		update brandix_bts.snap_session_track set fg_m3_sync_status='on' where session_id=2;
		
		SET @cur_proc_tid=(SELECT MAX(tid) FROM bai3_finishing.barcode_mapping WHERE m3_sync_status IS NULL);
		
		INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref) 
		
		SELECT
		a.date, 
		a.style,
		a.schedule,
		a.color,
		if(b.tbl_orders_size_ref_size_name is null,a.size,b.tbl_orders_size_ref_size_name),
		sum(a.out_qty),
		user(),
		'CPK',
		concat(max(a.tid),'-',min(a.tid))
		 FROM bai3_finishing.barcode_mapping AS a LEFT JOIN brandix_bts.view_set_2 AS b 
		ON
		a.style=b.tbl_orders_style_ref_product_style AND
		a.schedule=b.tbl_orders_master_product_schedule AND
		a.color=b.tbl_orders_sizes_master_order_col_des AND
		a.size=b.tbl_orders_sizes_master_size_title
		WHERE (a.tid between @prv_proc_tid and @cur_proc_tid) and a.m3_sync_status IS NULL and b.tbl_orders_size_ref_size_name IS NOT NULL AND LENGTH(b.tbl_orders_size_ref_size_name)>0  
		 GROUP BY 
		a.style,
		a.schedule,
		a.color,a.size;
		
		update bai3_finishing.barcode_mapping set m3_sync_status=1 where m3_sync_status is null and tid between @prv_proc_tid AND @cur_proc_tid;
		
		UPDATE brandix_bts.snap_session_track SET fg_m3_sync_status='off',fg_last_updated_tid=@cur_proc_tid WHERE session_id=2;
	end if;
	
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
