/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai3_finishing
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai3_finishing` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai3_finishing`;

/* Procedure structure for procedure `sync_fg_to_m3` */

/*!50003 DROP PROCEDURE IF EXISTS  `sync_fg_to_m3` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sync_fg_to_m3`()
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
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
