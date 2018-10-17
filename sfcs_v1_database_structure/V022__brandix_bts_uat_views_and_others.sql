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

USE `brandix_bts_uat`;

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `call_synchronize` */

/*!50106 DROP EVENT IF EXISTS `call_synchronize`*/;

DELIMITER $$

/*!50106 CREATE EVENT `call_synchronize` ON SCHEDULE EVERY 1 MINUTE STARTS '2017-02-07 17:30:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    IF (HOUR(SYSDATE()) BETWEEN 4 AND 23) THEN 
          CALL `sp_snap_view_uat`();
     END IF;
END */$$
DELIMITER ;

/* Function  structure for function  `fn_bai_mini_cumulative` */

/*!50003 DROP FUNCTION IF EXISTS `fn_bai_mini_cumulative` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_bai_mini_cumulative`(in_order_id VARCHAR(300),in_mini_order_num INT) RETURNS int(11)
BEGIN
DECLARE retval INT;
SET retval=(SELECT SUM(tbl_miniorder_data_quantity) FROM `view_set_3_snap` b WHERE b.order_id=in_order_id AND b.tbl_miniorder_data_mini_order_num<=in_mini_order_num);
RETURN retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_bai_pro3_sch_details` */

/*!50003 DROP FUNCTION IF EXISTS `fn_bai_pro3_sch_details` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_bai_pro3_sch_details`(scheduleno INT,rettype VARCHAR(30)) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
    
     IF (rettype="orderdiv") THEN
	SET retval=(SELECT MAX(order_div) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno );
END IF;
 
IF (rettype="orderdate") THEN
		SET retval=(SELECT MAX(order_date) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno );
END IF;
	IF (rettype="smv") THEN
		SET retval=(SELECT CAST(MAX(smv) AS DECIMAL(11,2)) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno);
	
	END IF;
   
    RETURN retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_bai_pro3_smv_details` */

/*!50003 DROP FUNCTION IF EXISTS `fn_bai_pro3_smv_details` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_bai_pro3_smv_details`(scheduleno INT,color VARCHAR(100)) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
    
   SET retval=(SELECT CAST(MAX(smv) AS DECIMAL(11,3)) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno AND order_col_des=color);
	
   
    RETURN retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_get_sec` */

/*!50003 DROP FUNCTION IF EXISTS `fn_get_sec` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_get_sec`(moduleno INT) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
    
   SET retval=(SELECT section_id FROM `bai_pro3`.`plan_modules` WHERE module_id=moduleno);
	
   
    RETURN retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_know_size_title` */

/*!50003 DROP FUNCTION IF EXISTS `fn_know_size_title` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_know_size_title`(order_id INT,color_code VARCHAR(300),size_id INT) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
	
	SET retval=(SELECT IF(LENGTH(size_title)=0,size_name,size_title) FROM `brandix_bts`.`tbl_orders_sizes_master` 
LEFT JOIN brandix_bts.tbl_orders_master ON brandix_bts.tbl_orders_master.id=brandix_bts.tbl_orders_sizes_master.parent_id
LEFT JOIN brandix_bts.tbl_orders_style_ref ON brandix_bts.tbl_orders_master.ref_product_style=brandix_bts.tbl_orders_style_ref.id
LEFT JOIN `brandix_bts.tbl_orders_size_ref` ON brandix_bts.tbl_orders_size_ref.id=brandix_bts.tbl_orders_sizes_master.ref_size_name
WHERE parent_id=order_id AND order_col_des=color_code AND ref_size_name=size_id);
	RETURN retval;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sp_snap_view_uat` */

/*!50003 DROP PROCEDURE IF EXISTS  `sp_snap_view_uat` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `sp_snap_view_uat`()
BEGIN
	DECLARE swap_status_val VARCHAR(100);
	DECLARE swap_session_status VARCHAR(100);
	DECLARE hour_check VARCHAR(100);
	DECLARE last_id_orders VARCHAR(100);
	DECLARE last_id_mini VARCHAR(100);
	DECLARE last_id_tran VARCHAR(100);
	DECLARE	last_id_ini VARCHAR(100);
	DECLARE	day_sta VARCHAR(100);
	
	SET @hour_check=HOUR(CURTIME()); 
	SET @hoursdiff=(SELECT (TIMESTAMPDIFF(MINUTE,time_stamp,NOW())) AS hrsdff FROM `snap_session_track` WHERE session_id=1); 
	SET @swap_session_status=(SELECT session_status FROM snap_session_track WHERE session_id='1');  
	
	IF (@swap_session_status='on' AND @hoursdiff > '20') THEN 	
	
	UPDATE snap_session_track SET session_status ='off',swap_status ='over' WHERE session_id=1;
	
	SET @swap_session_status=(SELECT session_status FROM snap_session_track WHERE session_id='1'); 
	SET @day_sta=(SELECT session_status FROM snap_session_track WHERE session_id='1');  
	
	END IF; 
	
	IF (@swap_session_status='off' AND @hour_check = '4' and @day_sta = '0') THEN 	
	
	UPDATE snap_session_track SET session_status ='on',swap_status ='all' WHERE session_id=1; 
	
	TRUNCATE `view_set_2_snap`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='42' WHERE session_id=1; 
	
	INSERT IGNORE INTO `view_set_2_snap` SELECT * FROM `brandix_bts_uat`.`view_set_2`;	
	
	UPDATE snap_session_track SET fg_last_updated_tid ='43' WHERE session_id=1;	
	
	TRUNCATE `view_set_4_snap`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='81' WHERE session_id=1; 
	
	INSERT IGNORE INTO `view_set_4_snap` SELECT * FROM `brandix_bts`.`view_set_4`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='91' WHERE session_id=1; 
	
	TRUNCATE `view_set_5_snap`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='101' WHERE session_id=1; 
	
	INSERT IGNORE INTO `view_set_5_snap` SELECT * FROM `brandix_bts`.`view_set_5`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='111' WHERE session_id=1; 
	
	TRUNCATE `view_set_6_snap`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='121' WHERE session_id=1; 
	
	INSERT IGNORE INTO `view_set_6_snap` SELECT * FROM `brandix_bts`.`view_set_6`;  
	
	UPDATE snap_session_track SET day_status='1', session_status ='off',swap_status ='over' WHERE session_id=1; 
	
	END IF; 
	
	SET @last_id_orders=(SELECT MAX(tbl_orders_sizes_master_id) FROM view_set_2_snap); 
	SET @last_id_mini=(SELECT MAX(tbl_miniorder_data_id) FROM view_set_3_snap); 
	-- SET @last_id_tran=(SELECT MAX(bundle_transactions_20_repeat_id) FROM view_set_snap_1_tbl WHERE bundle_transactions_20_repeat_operation_id<>'5'); 
	SET @last_id_ini=(SELECT MAX(id) FROM bundle_transactions_20_repeat_virtual_snap_ini_bundles); 
	
	IF (@swap_session_status='off' AND '6' <= @hour_check <= '23') THEN 
	
	UPDATE snap_session_track SET session_status ='on',swap_status ='run' WHERE session_id=1; 
	
	INSERT IGNORE INTO `view_set_1_snap` SELECT * FROM `view_set_1`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='1' WHERE session_id=1; 
		 
	INSERT IGNORE INTO bundle_transactions_20_repeat_virtual_snap_ini_bundles SELECT @s:=@s+1 id,1 AS parent_id,bundle_number AS bundle_barcode,quantity,bundle_number AS bundle_id,5 AS operation_id,0 AS rejection_qty, 0 AS act_module FROM brandix_bts.tbl_miniorder_data,(SELECT @s:=MAX(id) FROM `bundle_transactions_20_repeat_virtual_snap_ini_bundles`) AS s; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='2' WHERE session_id=1; 	
	
	INSERT IGNORE INTO `view_set_1_snap` SELECT * FROM view_set_1_virtual WHERE bundle_transactions_20_repeat_id > @last_id_ini; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='3' WHERE session_id=1; 	
	
	INSERT IGNORE INTO `view_set_2_snap` SELECT * FROM `view_set_2` WHERE tbl_orders_sizes_master_id > @last_id_orders;
	
	-- TRuncate `view_set_2_snap`;
	
	UPDATE snap_session_track SET fg_last_updated_tid ='4' WHERE session_id=1;
	
	-- INSERT IGNORE INTO `view_set_2_snap` SELECT * FROM `view_set_2`;
	
	-- UPDATE snap_session_track SET fg_last_updated_tid ='41' WHERE session_id=1; 
	
	-- INSERT IGNORE INTO `view_set_3_snap` SELECT * FROM `view_set_3` WHERE tbl_miniorder_data_id > @last_id_mini;
	
	INSERT IGNORE INTO `view_set_3_snap` SELECT * FROM `view_set_3`;
	
	UPDATE snap_session_track SET fg_last_updated_tid ='5' WHERE session_id=1;  
	
	-- INSERT IGNORE INTO `view_set_snap_1_tbl` SELECT * FROM `view_set_snap_1` WHERE bundle_transactions_20_repeat_operation_id = '5' AND bundle_transactions_20_repeat_id > @last_id_ini; 
	
	-- INSERT IGNORE INTO `view_set_snap_1_tbl` SELECT * FROM `view_set_snap_1` where tbl_orders_style_ref_product_style<>'' and tbl_miniorder_data_mini_order_num>0;
	
	INSERT IGNORE INTO `view_set_snap_1_tbl` SELECT * FROM `view_set_snap_1`;
	
	UPDATE snap_session_track SET fg_last_updated_tid ='6' WHERE session_id=1; 	
	
	-- INSERT IGNORE INTO `view_set_snap_1_tbl` SELECT * FROM `view_set_snap_1` WHERE bundle_transactions_20_repeat_operation_id <> '5' AND bundle_transactions_20_repeat_id > @last_id_tran; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='7' WHERE session_id=1;  
	
	DELETE FROM `view_set_4_snap` WHERE DATE=CURDATE(); 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='8' WHERE session_id=1; 
	
	INSERT IGNORE INTO `view_set_4_snap` SELECT * FROM `view_set_4`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='9' WHERE session_id=1; 
	
	DELETE FROM `view_set_5_snap` WHERE LOG_DATE=CURDATE(); 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='10' WHERE session_id=1; 
	
	INSERT IGNORE INTO `view_set_5_snap` SELECT * FROM `view_set_5`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='11' WHERE session_id=1; 
	
	DELETE FROM `view_set_6_snap` WHERE DATE=CURDATE(); 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='12' WHERE session_id=1; 
	
	INSERT IGNORE INTO `view_set_6_snap` SELECT * FROM `view_set_6`; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='13' WHERE session_id=1; 
	
	UPDATE snap_session_track SET day_status='0',session_status='off',swap_status='over',time_stamp=(SELECT MAX(bundle_transactions_operation_time) FROM `view_set_1_snap` WHERE bundle_transactions_20_repeat_operation_id<>'5') WHERE session_id=1; 
	
	UPDATE snap_session_track SET fg_last_updated_tid ='14' WHERE session_id=1; 
	
	END IF; 
	
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
