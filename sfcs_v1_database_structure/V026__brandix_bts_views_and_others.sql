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

/* Trigger structure for table `bundle_transactions_20_repeat` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_act_module` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `update_act_module` BEFORE INSERT ON `bundle_transactions_20_repeat` FOR EACH ROW BEGIN
	declare prv_module varchar(11);
	DECLARE cur_module varchar(11);
	DECLARE prv_parent_id BIGINT;
	DECLARE good_qty BIGINT;
	declare count_qty int;
	
	-- IF NEW.operation_id=1 THEN
	--	SET good_qty=(SELECT SUM(quantity) FROM tbl_miniorder_data WHERE bundle_number=NEW.bundle_id);
	--	SET NEW.quantity=good_qty;
	-- ELSE
	--	SET good_qty=(SELECT quantity FROM bundle_transactions_20_repeat WHERE bundle_id=NEW.bundle_id AND operation_id=(NEW.operation_id-1));
	--	SET NEW.quantity=good_qty;
	-- END IF;
	
	if NEW.operation_id=4 then
	
		set prv_parent_id=(select parent_id from `bundle_transactions_20_repeat` where bundle_id=NEW.bundle_id and operation_id=3 order by id desc  limit 1);
		
		SET cur_module=(SELECT module_id FROM `bundle_transactions` WHERE id=NEW.parent_id);
		
		
		if prv_parent_id is null then
			set prv_module=cur_module;
		else
		
		
			set prv_module=(select module_id from `bundle_transactions` where id=prv_parent_id);
		end if;
		
		
		set NEW.act_module=prv_module;
		
		
	
	end if;
	
	-- IF NEW.operation_id>1 THEN
	
	--	SET count_qty=(SELECT COUNT(id) as cont FROM bundle_transactions_20_repeat WHERE bundle_id=NEW.bundle_id AND operation_id=(NEW.operation_id-1));
	--	IF count_qty=0 THEN
	--		 SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Please Report the Previous Operation';
	--	END IF;
	-- END IF;
	
	
    END */$$


DELIMITER ;

/* Trigger structure for table `bundle_transactions_20_repeat` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `bts_sfcs_insert` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `bts_sfcs_insert` AFTER INSERT ON `bundle_transactions_20_repeat` FOR EACH ROW BEGIN
	IF NEW.operation_id=1 Or NEW.operation_id=3 OR NEW.operation_id=4 OR NEW.operation_id=6 OR NEW.operation_id=7 THEN
		INSERT INTO `bts_to_sfcs_sync`(sync_bundle_id,sync_operation_id,sync_operation_code,sync_rep_id,insert_time_stamp) VALUES (NEW.bundle_id,NEW.operation_id,0,NEW.id,NOW());
	END IF;
    END */$$


DELIMITER ;

/* Trigger structure for table `bundle_transactions_20_repeat` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_rejections` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `update_rejections` BEFORE UPDATE ON `bundle_transactions_20_repeat` FOR EACH ROW BEGIN
    
     DECLARE good_qty BIGINT;
	 IF NEW.rejection_quantity>0 THEN
	--	IF OLD.operation_id=1 THEN
	--		SET good_qty=(SELECT SUM(quantity) FROM tbl_miniorder_data WHERE bundle_number=OLD.bundle_id);
	--		SET NEW.quantity=good_qty-NEW.rejection_quantity;
	--		UPDATE `brandix_bts_uat`.`view_set_1_snap` SET bundle_transactions_20_repeat_quantity=NEW.quantity,bundle_transactions_20_repeat_rejection_quantity=NEW.rejection_quantity WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode; 
	--		UPDATE `brandix_bts_uat`.`view_set_snap_1_tbl` SET bundle_transactions_20_repeat_quantity=NEW.quantity,bundle_transactions_20_repeat_rejection_quantity=NEW.rejection_quantity WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode; 
	--	ELSE
	--		SET good_qty=(SELECT quantity FROM bundle_transactions_20_repeat WHERE bundle_id=OLD.bundle_id AND operation_id=(OLD.operation_id-1));
	--		SET NEW.quantity=good_qty-NEW.rejection_quantity;
	--		UPDATE `brandix_bts_uat`.`view_set_1_snap` SET bundle_transactions_20_repeat_quantity=NEW.quantity,bundle_transactions_20_repeat_rejection_quantity=NEW.rejection_quantity WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode; 
	--		UPDATE `brandix_bts_uat`.`view_set_snap_1_tbl` SET bundle_transactions_20_repeat_quantity=NEW.quantity,bundle_transactions_20_repeat_rejection_quantity=NEW.rejection_quantity WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode; 
	--	END IF;
		
		-- UPDATE `brandix_bts_uat`.`view_set_1_snap` SET bundle_transactions_20_repeat_quantity=NEW.quantity,bundle_transactions_20_repeat_rejection_quantity=NEW.rejection_quantity WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode; 
		-- UPDATE `brandix_bts_uat`.`view_set_snap_1_tbl` SET bundle_transactions_20_repeat_quantity=NEW.quantity,bundle_transactions_20_repeat_rejection_quantity=NEW.rejection_quantity WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode; 
		-- IF OLD.operation_id=4 then
		--	SET good_qty=(SELECT quantity FROM bundle_transactions_20_repeat WHERE bundle_id=OLD.bundle_id AND operation_id=3);
		--	SET NEW.quantity=good_qty-NEW.rejection_quantity;
		--	UPDATE `brandix_bts_uat`.`view_set_1_snap` SET bundle_transactions_20_repeat_quantity=NEW.quantity,bundle_transactions_20_repeat_rejection_quantity=NEW.rejection_quantity WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode; 
		--	UPDATE `brandix_bts_uat`.`view_set_snap_1_tbl` SET bundle_transactions_20_repeat_quantity=NEW.quantity,bundle_transactions_20_repeat_rejection_quantity=NEW.rejection_quantity WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode; 
		-- END IF;
		
		IF OLD.operation_id=3 OR OLD.operation_id=4 OR OLD.operation_id=6 OR OLD.operation_id=7 THEN
			INSERT INTO `bts_to_sfcs_sync`(sync_bundle_id,sync_operation_id,sync_operation_code,sync_rep_id,insert_time_stamp) VALUES (OLD.bundle_id,OLD.operation_id,1,OLD.id,NOW());
		END IF;
	 END IF;
	
    END */$$


DELIMITER ;

/* Trigger structure for table `bundle_transactions_20_repeat` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `bts_sfcs_del` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `bts_sfcs_del` BEFORE DELETE ON `bundle_transactions_20_repeat` FOR EACH ROW BEGIN
	IF OLD.operation_id=1 OR OLD.operation_id=3 OR OLD.operation_id=4 OR OLD.operation_id=6 OR OLD.operation_id=7 THEN
		INSERT INTO `bts_to_sfcs_sync`(sync_bundle_id,sync_operation_id,sync_operation_code,sync_rep_id,insert_time_stamp) VALUES (OLD.bundle_id,OLD.operation_id,2,OLD.id,NOW());
		-- DELETE FROM `brandix_bts_uat`.`view_set_1_snap` WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode;
		-- DELETE FROM `brandix_bts_uat`.`view_set_snap_1_tbl` WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode;  
	END IF;
    END */$$


DELIMITER ;

/* Function  structure for function  `fn_bai_mini_cumulative` */

/*!50003 DROP FUNCTION IF EXISTS `fn_bai_mini_cumulative` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_bai_mini_cumulative`(in_order_id varchar(300),in_mini_order_num int) RETURNS int(11)
BEGIN
declare retval int;
set retval=(SELECT SUM(tbl_miniorder_data_quantity) FROM `view_set_3_snap` b WHERE b.order_id=in_order_id AND b.tbl_miniorder_data_mini_order_num<=in_mini_order_num);
return retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_bai_pro3_sch_details` */

/*!50003 DROP FUNCTION IF EXISTS `fn_bai_pro3_sch_details` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_bai_pro3_sch_details`(scheduleno int,rettype varchar(30)) RETURNS varchar(50) CHARSET latin1
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

/*!50003 CREATE FUNCTION `fn_bai_pro3_smv_details`(scheduleno INT,color VARCHAR(100)) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
    
   SET retval=(SELECT CAST(MAX(smv) AS DECIMAL(11,3)) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno and order_col_des=color);
	
   
    RETURN retval;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_know_size_title` */

/*!50003 DROP FUNCTION IF EXISTS `fn_know_size_title` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_know_size_title`(order_id int,color_code varchar(300),size_id int) RETURNS varchar(50) CHARSET latin1
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

/*!50003 CREATE PROCEDURE `bts_to_sfcs_sync`(filterlimit bigint)
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

/*!50003 CREATE PROCEDURE `sp_snap_view`()
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

/*Table structure for table `view_extra_cut` */

DROP TABLE IF EXISTS `view_extra_cut`;

/*!50001 DROP VIEW IF EXISTS `view_extra_cut` */;
/*!50001 DROP TABLE IF EXISTS `view_extra_cut` */;

/*!50001 CREATE TABLE  `view_extra_cut`(
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
 `order_col_des` varchar(150) 
)*/;

/*Table structure for table `view_extra_recut` */

DROP TABLE IF EXISTS `view_extra_recut`;

/*!50001 DROP VIEW IF EXISTS `view_extra_recut` */;
/*!50001 DROP TABLE IF EXISTS `view_extra_recut` */;

/*!50001 CREATE TABLE  `view_extra_recut`(
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
 `doc_no` varchar(12) ,
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

/*Table structure for table `view_set_1` */

DROP TABLE IF EXISTS `view_set_1`;

/*!50001 DROP VIEW IF EXISTS `view_set_1` */;
/*!50001 DROP TABLE IF EXISTS `view_set_1` */;

/*!50001 CREATE TABLE  `view_set_1`(
 `bundle_transactions_20_repeat_id` bigint(11) ,
 `bundle_transactions_20_repeat_parent_id` bigint(11) ,
 `bundle_transactions_20_repeat_bundle_barcode` varchar(50) ,
 `bundle_transactions_20_repeat_quantity` int(6) ,
 `bundle_transactions_20_repeat_bundle_id` int(6) ,
 `bundle_transactions_20_repeat_operation_id` varchar(15) ,
 `bundle_transactions_20_repeat_rejection_quantity` int(6) ,
 `bundle_transactions_20_repeat_act_module` varchar(11) ,
 `tbl_orders_ops_ref_id` int(11) ,
 `tbl_orders_ops_ref_operation_name` varchar(50) ,
 `tbl_orders_ops_ref_default_operation` text ,
 `tbl_orders_ops_ref_operation_code` varchar(255) ,
 `bundle_transactions_id` int(11) ,
 `bundle_transactions_date_time` datetime ,
 `bundle_transactions_operation_time` datetime ,
 `bundle_transactions_employee_id` varchar(255) ,
 `bundle_transactions_shift` int(11) ,
 `bundle_transactions_trans_status` varchar(255) ,
 `bundle_transactions_module_id` varchar(11) ,
 `tbl_shifts_master_id` int(11) ,
 `tbl_shifts_master_date_time` datetime ,
 `tbl_shifts_master_shift_name` varchar(255) 
)*/;

/*Table structure for table `view_set_1_virtual` */

DROP TABLE IF EXISTS `view_set_1_virtual`;

/*!50001 DROP VIEW IF EXISTS `view_set_1_virtual` */;
/*!50001 DROP TABLE IF EXISTS `view_set_1_virtual` */;

/*!50001 CREATE TABLE  `view_set_1_virtual`(
 `bundle_transactions_20_repeat_id` bigint(11) ,
 `bundle_transactions_20_repeat_parent_id` bigint(11) ,
 `bundle_transactions_20_repeat_bundle_barcode` varchar(150) ,
 `bundle_transactions_20_repeat_quantity` int(6) ,
 `bundle_transactions_20_repeat_bundle_id` bigint(11) ,
 `bundle_transactions_20_repeat_operation_id` varchar(45) ,
 `bundle_transactions_20_repeat_rejection_quantity` int(6) ,
 `bundle_transactions_20_repeat_act_module` varchar(11) ,
 `tbl_orders_ops_ref_id` int(11) ,
 `tbl_orders_ops_ref_operation_name` varchar(50) ,
 `tbl_orders_ops_ref_default_operation` text ,
 `tbl_orders_ops_ref_operation_code` varchar(255) ,
 `bundle_transactions_id` int(11) ,
 `bundle_transactions_date_time` datetime ,
 `bundle_transactions_operation_time` datetime ,
 `bundle_transactions_employee_id` varchar(255) ,
 `bundle_transactions_shift` int(11) ,
 `bundle_transactions_trans_status` varchar(255) ,
 `bundle_transactions_module_id` varchar(11) ,
 `tbl_shifts_master_id` int(11) ,
 `tbl_shifts_master_date_time` datetime ,
 `tbl_shifts_master_shift_name` varchar(255) 
)*/;

/*Table structure for table `view_set_4` */

DROP TABLE IF EXISTS `view_set_4`;

/*!50001 DROP VIEW IF EXISTS `view_set_4` */;
/*!50001 DROP TABLE IF EXISTS `view_set_4` */;

/*!50001 CREATE TABLE  `view_set_4`(
 `date` date ,
 `style` varchar(60) ,
 `SCHEDULE` varchar(60) ,
 `cpk_qty` decimal(29,0) ,
 `order_tid_new` varchar(130) 
)*/;

/*Table structure for table `view_set_5` */

DROP TABLE IF EXISTS `view_set_5`;

/*!50001 DROP VIEW IF EXISTS `view_set_5` */;
/*!50001 DROP TABLE IF EXISTS `view_set_5` */;

/*!50001 CREATE TABLE  `view_set_5`(
 `log_date` date ,
 `qms_style` varchar(30) ,
 `qms_schedule` varchar(20) ,
 `rejected_qty` decimal(27,0) 
)*/;

/*Table structure for table `view_set_6` */

DROP TABLE IF EXISTS `view_set_6`;

/*!50001 DROP VIEW IF EXISTS `view_set_6` */;
/*!50001 DROP TABLE IF EXISTS `view_set_6` */;

/*!50001 CREATE TABLE  `view_set_6`(
 `date` date ,
 `style` varchar(60) ,
 `SCHEDULE` varchar(60) ,
 `color` varchar(150) ,
 `size` varchar(255) ,
 `cpk_qty` decimal(29,0) ,
 `order_tid_new` text ,
 `barcode` int(1) ,
 `order_tid_new_2` text 
)*/;

/*Table structure for table `view_set_snap_1` */

DROP TABLE IF EXISTS `view_set_snap_1`;

/*!50001 DROP VIEW IF EXISTS `view_set_snap_1` */;
/*!50001 DROP TABLE IF EXISTS `view_set_snap_1` */;

/*!50001 CREATE TABLE  `view_set_snap_1`(
 `bundle_transactions_20_repeat_id` bigint(11) ,
 `bundle_transactions_20_repeat_quantity` bigint(11) ,
 `bundle_transactions_20_repeat_operation_id` varchar(15) ,
 `bundle_transactions_20_repeat_rejection_quantity` bigint(11) ,
 `tbl_shifts_master_shift_name` varchar(255) ,
 `tbl_orders_ops_ref_operation_code` varchar(255) ,
 `tbl_orders_ops_ref_operation_name` varchar(50) ,
 `bundle_transactions_module_id` varchar(11) ,
 `bundle_transactions_20_repeat_act_module` varchar(11) ,
 `bundle_transactions_employee_id` varchar(255) ,
 `bundle_transactions_date_time` datetime ,
 `tbl_orders_size_ref_size_name` varchar(50) ,
 `tbl_orders_sizes_master_size_title` varchar(255) ,
 `tbl_orders_sizes_master_order_quantity` int(6) ,
 `tbl_orders_style_ref_product_style` varchar(70) ,
 `tbl_miniorder_data_quantity` decimal(32,0) ,
 `tbl_miniorder_data_bundle_number` int(6) ,
 `tbl_miniorder_data_color` varchar(255) ,
 `tbl_miniorder_data_mini_order_num` float(6,2) ,
 `tbl_orders_master_product_schedule` varchar(50) ,
 `tbl_orders_size_ref_id` int(11) ,
 `bundle_transactions_20_repeat_bundle_barcode` varchar(50) ,
 `size_disp` varchar(255) ,
 `order_id` varchar(318) ,
 `sah` double(19,2) ,
 `order_div` varchar(50) ,
 `order_date` varchar(50) ,
 `order_tid_new` text ,
 `tbl_module_ref_module_section` varchar(10) ,
 `bundle_transactions_operation_time` datetime ,
 `view_set_2_snap_smv` varchar(50) ,
 `tbl_miniorder_data_docket_number` varchar(15) 
)*/;

/*View structure for view view_bund_tran_master */

/*!50001 DROP TABLE IF EXISTS `view_bund_tran_master` */;
/*!50001 DROP VIEW IF EXISTS `view_bund_tran_master` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_bund_tran_master` AS (select `bundle_transactions_20_repeat`.`parent_id` AS `parent_id`,`bundle_transactions_20_repeat`.`bundle_id` AS `bundle_id`,`tbl_miniorder_data`.`id` AS `id`,`tbl_orders_ops_ref`.`operation_name` AS `operation_name`,`tbl_orders_ops_ref`.`operation_code` AS `operation_code`,`bundle_transactions`.`date_time` AS `date_time`,`bundle_transactions_20_repeat`.`bundle_barcode` AS `bundle_barcode`,`bundle_transactions_20_repeat`.`quantity` AS `quantity`,`bundle_transactions_20_repeat`.`rejection_quantity` AS `rejection_quantity`,`bundle_transactions_20_repeat`.`operation_id` AS `operation_id`,`bundle_transactions`.`module_id` AS `module_id`,`tbl_shifts_master`.`shift_name` AS `shift_name` from ((((`bundle_transactions_20_repeat` left join `tbl_orders_ops_ref` on(`bundle_transactions_20_repeat`.`operation_id` = `tbl_orders_ops_ref`.`id`)) left join `bundle_transactions` on(`bundle_transactions_20_repeat`.`parent_id` = `bundle_transactions`.`id`)) left join `tbl_shifts_master` on(`bundle_transactions`.`shift` = `tbl_shifts_master`.`id`)) left join `tbl_miniorder_data` on(`bundle_transactions_20_repeat`.`bundle_id` = `tbl_miniorder_data`.`bundle_number`))) */;

/*View structure for view view_extra_cut */

/*!50001 DROP TABLE IF EXISTS `view_extra_cut` */;
/*!50001 DROP VIEW IF EXISTS `view_extra_cut` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_extra_cut` AS (select `order_cat_doc_mk_mix`.`catyy` AS `catyy`,`order_cat_doc_mk_mix`.`cat_patt_ver` AS `cat_patt_ver`,`order_cat_doc_mk_mix`.`mk_file` AS `mk_file`,`order_cat_doc_mk_mix`.`mk_ver` AS `mk_ver`,`order_cat_doc_mk_mix`.`mklength` AS `mklength`,`order_cat_doc_mk_mix`.`style_id` AS `style_id`,`order_cat_doc_mk_mix`.`col_des` AS `col_des`,`order_cat_doc_mk_mix`.`gmtway` AS `gmtway`,`order_cat_doc_mk_mix`.`strip_match` AS `strip_match`,`order_cat_doc_mk_mix`.`fab_des` AS `fab_des`,`order_cat_doc_mk_mix`.`clubbing` AS `clubbing`,`order_cat_doc_mk_mix`.`date` AS `date`,`order_cat_doc_mk_mix`.`cat_ref` AS `cat_ref`,`order_cat_doc_mk_mix`.`compo_no` AS `compo_no`,`order_cat_doc_mk_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_doc_mk_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_doc_mk_mix`.`mk_ref` AS `mk_ref`,`order_cat_doc_mk_mix`.`order_tid` AS `order_tid`,`order_cat_doc_mk_mix`.`pcutno` AS `pcutno`,`order_cat_doc_mk_mix`.`ratio` AS `ratio`,`order_cat_doc_mk_mix`.`p_xs` AS `p_xs`,`order_cat_doc_mk_mix`.`p_s` AS `p_s`,`order_cat_doc_mk_mix`.`p_m` AS `p_m`,`order_cat_doc_mk_mix`.`p_l` AS `p_l`,`order_cat_doc_mk_mix`.`p_xl` AS `p_xl`,`order_cat_doc_mk_mix`.`p_xxl` AS `p_xxl`,`order_cat_doc_mk_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_doc_mk_mix`.`p_plies` AS `p_plies`,`order_cat_doc_mk_mix`.`doc_no` AS `doc_no`,`order_cat_doc_mk_mix`.`acutno` AS `acutno`,`order_cat_doc_mk_mix`.`a_xs` AS `a_xs`,`order_cat_doc_mk_mix`.`a_s` AS `a_s`,`order_cat_doc_mk_mix`.`a_m` AS `a_m`,`order_cat_doc_mk_mix`.`a_l` AS `a_l`,`order_cat_doc_mk_mix`.`a_xl` AS `a_xl`,`order_cat_doc_mk_mix`.`a_xxl` AS `a_xxl`,`order_cat_doc_mk_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_doc_mk_mix`.`a_plies` AS `a_plies`,`order_cat_doc_mk_mix`.`lastup` AS `lastup`,`order_cat_doc_mk_mix`.`remarks` AS `remarks`,`order_cat_doc_mk_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_doc_mk_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_doc_mk_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_doc_mk_mix`.`print_status` AS `print_status`,`order_cat_doc_mk_mix`.`a_s01` AS `a_s01`,`order_cat_doc_mk_mix`.`a_s02` AS `a_s02`,`order_cat_doc_mk_mix`.`a_s03` AS `a_s03`,`order_cat_doc_mk_mix`.`a_s04` AS `a_s04`,`order_cat_doc_mk_mix`.`a_s05` AS `a_s05`,`order_cat_doc_mk_mix`.`a_s06` AS `a_s06`,`order_cat_doc_mk_mix`.`a_s07` AS `a_s07`,`order_cat_doc_mk_mix`.`a_s08` AS `a_s08`,`order_cat_doc_mk_mix`.`a_s09` AS `a_s09`,`order_cat_doc_mk_mix`.`a_s10` AS `a_s10`,`order_cat_doc_mk_mix`.`a_s11` AS `a_s11`,`order_cat_doc_mk_mix`.`a_s12` AS `a_s12`,`order_cat_doc_mk_mix`.`a_s13` AS `a_s13`,`order_cat_doc_mk_mix`.`a_s14` AS `a_s14`,`order_cat_doc_mk_mix`.`a_s15` AS `a_s15`,`order_cat_doc_mk_mix`.`a_s16` AS `a_s16`,`order_cat_doc_mk_mix`.`a_s17` AS `a_s17`,`order_cat_doc_mk_mix`.`a_s18` AS `a_s18`,`order_cat_doc_mk_mix`.`a_s19` AS `a_s19`,`order_cat_doc_mk_mix`.`a_s20` AS `a_s20`,`order_cat_doc_mk_mix`.`a_s21` AS `a_s21`,`order_cat_doc_mk_mix`.`a_s22` AS `a_s22`,`order_cat_doc_mk_mix`.`a_s23` AS `a_s23`,`order_cat_doc_mk_mix`.`a_s24` AS `a_s24`,`order_cat_doc_mk_mix`.`a_s25` AS `a_s25`,`order_cat_doc_mk_mix`.`a_s26` AS `a_s26`,`order_cat_doc_mk_mix`.`a_s27` AS `a_s27`,`order_cat_doc_mk_mix`.`a_s28` AS `a_s28`,`order_cat_doc_mk_mix`.`a_s29` AS `a_s29`,`order_cat_doc_mk_mix`.`a_s30` AS `a_s30`,`order_cat_doc_mk_mix`.`a_s31` AS `a_s31`,`order_cat_doc_mk_mix`.`a_s32` AS `a_s32`,`order_cat_doc_mk_mix`.`a_s33` AS `a_s33`,`order_cat_doc_mk_mix`.`a_s34` AS `a_s34`,`order_cat_doc_mk_mix`.`a_s35` AS `a_s35`,`order_cat_doc_mk_mix`.`a_s36` AS `a_s36`,`order_cat_doc_mk_mix`.`a_s37` AS `a_s37`,`order_cat_doc_mk_mix`.`a_s38` AS `a_s38`,`order_cat_doc_mk_mix`.`a_s39` AS `a_s39`,`order_cat_doc_mk_mix`.`a_s40` AS `a_s40`,`order_cat_doc_mk_mix`.`a_s41` AS `a_s41`,`order_cat_doc_mk_mix`.`a_s42` AS `a_s42`,`order_cat_doc_mk_mix`.`a_s43` AS `a_s43`,`order_cat_doc_mk_mix`.`a_s44` AS `a_s44`,`order_cat_doc_mk_mix`.`a_s45` AS `a_s45`,`order_cat_doc_mk_mix`.`a_s46` AS `a_s46`,`order_cat_doc_mk_mix`.`a_s47` AS `a_s47`,`order_cat_doc_mk_mix`.`a_s48` AS `a_s48`,`order_cat_doc_mk_mix`.`a_s49` AS `a_s49`,`order_cat_doc_mk_mix`.`a_s50` AS `a_s50`,`order_cat_doc_mk_mix`.`p_s01` AS `p_s01`,`order_cat_doc_mk_mix`.`p_s02` AS `p_s02`,`order_cat_doc_mk_mix`.`p_s03` AS `p_s03`,`order_cat_doc_mk_mix`.`p_s04` AS `p_s04`,`order_cat_doc_mk_mix`.`p_s05` AS `p_s05`,`order_cat_doc_mk_mix`.`p_s06` AS `p_s06`,`order_cat_doc_mk_mix`.`p_s07` AS `p_s07`,`order_cat_doc_mk_mix`.`p_s08` AS `p_s08`,`order_cat_doc_mk_mix`.`p_s09` AS `p_s09`,`order_cat_doc_mk_mix`.`p_s10` AS `p_s10`,`order_cat_doc_mk_mix`.`p_s11` AS `p_s11`,`order_cat_doc_mk_mix`.`p_s12` AS `p_s12`,`order_cat_doc_mk_mix`.`p_s13` AS `p_s13`,`order_cat_doc_mk_mix`.`p_s14` AS `p_s14`,`order_cat_doc_mk_mix`.`p_s15` AS `p_s15`,`order_cat_doc_mk_mix`.`p_s16` AS `p_s16`,`order_cat_doc_mk_mix`.`p_s17` AS `p_s17`,`order_cat_doc_mk_mix`.`p_s18` AS `p_s18`,`order_cat_doc_mk_mix`.`p_s19` AS `p_s19`,`order_cat_doc_mk_mix`.`p_s20` AS `p_s20`,`order_cat_doc_mk_mix`.`p_s21` AS `p_s21`,`order_cat_doc_mk_mix`.`p_s22` AS `p_s22`,`order_cat_doc_mk_mix`.`p_s23` AS `p_s23`,`order_cat_doc_mk_mix`.`p_s24` AS `p_s24`,`order_cat_doc_mk_mix`.`p_s25` AS `p_s25`,`order_cat_doc_mk_mix`.`p_s26` AS `p_s26`,`order_cat_doc_mk_mix`.`p_s27` AS `p_s27`,`order_cat_doc_mk_mix`.`p_s28` AS `p_s28`,`order_cat_doc_mk_mix`.`p_s29` AS `p_s29`,`order_cat_doc_mk_mix`.`p_s30` AS `p_s30`,`order_cat_doc_mk_mix`.`p_s31` AS `p_s31`,`order_cat_doc_mk_mix`.`p_s32` AS `p_s32`,`order_cat_doc_mk_mix`.`p_s33` AS `p_s33`,`order_cat_doc_mk_mix`.`p_s34` AS `p_s34`,`order_cat_doc_mk_mix`.`p_s35` AS `p_s35`,`order_cat_doc_mk_mix`.`p_s36` AS `p_s36`,`order_cat_doc_mk_mix`.`p_s37` AS `p_s37`,`order_cat_doc_mk_mix`.`p_s38` AS `p_s38`,`order_cat_doc_mk_mix`.`p_s39` AS `p_s39`,`order_cat_doc_mk_mix`.`p_s40` AS `p_s40`,`order_cat_doc_mk_mix`.`p_s41` AS `p_s41`,`order_cat_doc_mk_mix`.`p_s42` AS `p_s42`,`order_cat_doc_mk_mix`.`p_s43` AS `p_s43`,`order_cat_doc_mk_mix`.`p_s44` AS `p_s44`,`order_cat_doc_mk_mix`.`p_s45` AS `p_s45`,`order_cat_doc_mk_mix`.`p_s46` AS `p_s46`,`order_cat_doc_mk_mix`.`p_s47` AS `p_s47`,`order_cat_doc_mk_mix`.`p_s48` AS `p_s48`,`order_cat_doc_mk_mix`.`p_s49` AS `p_s49`,`order_cat_doc_mk_mix`.`p_s50` AS `p_s50`,`order_cat_doc_mk_mix`.`rm_date` AS `rm_date`,`order_cat_doc_mk_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_doc_mk_mix`.`plan_module` AS `plan_module`,`order_cat_doc_mk_mix`.`category` AS `category`,`order_cat_doc_mk_mix`.`color_code` AS `color_code`,`order_cat_doc_mk_mix`.`fabric_status` AS `fabric_status`,`order_cat_doc_mk_mix`.`material_req` AS `material_req`,`order_cat_doc_mk_mix`.`order_del_no` AS `order_del_no`,`order_cat_doc_mk_mix`.`order_col_des` AS `order_col_des` from (`bai_pro3`.`order_cat_doc_mk_mix` left join `brandix_bts`.`tbl_cut_master` on(`brandix_bts`.`tbl_cut_master`.`doc_num` = `order_cat_doc_mk_mix`.`doc_no`)) where `order_cat_doc_mk_mix`.`category` in ('Body','Front') and octet_length(`order_cat_doc_mk_mix`.`order_del_no`) < '8' and `order_cat_doc_mk_mix`.`style_id` not in (74029,23923,74026,73927) and `brandix_bts`.`tbl_cut_master`.`id` is null and `order_cat_doc_mk_mix`.`order_del_no` in (select `brandix_bts`.`tbl_orders_master`.`product_schedule` from `brandix_bts`.`tbl_orders_master`)) */;

/*View structure for view view_extra_recut */

/*!50001 DROP TABLE IF EXISTS `view_extra_recut` */;
/*!50001 DROP VIEW IF EXISTS `view_extra_recut` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_extra_recut` AS (select `order_cat_recut_doc_mix`.`date` AS `date`,`order_cat_recut_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_recut_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_recut_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_recut_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_recut_doc_mix`.`order_tid` AS `order_tid`,`order_cat_recut_doc_mix`.`pcutno` AS `pcutno`,`order_cat_recut_doc_mix`.`ratio` AS `ratio`,`order_cat_recut_doc_mix`.`p_xs` AS `p_xs`,`order_cat_recut_doc_mix`.`p_s` AS `p_s`,`order_cat_recut_doc_mix`.`p_m` AS `p_m`,`order_cat_recut_doc_mix`.`p_l` AS `p_l`,`order_cat_recut_doc_mix`.`p_xl` AS `p_xl`,`order_cat_recut_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_recut_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_recut_doc_mix`.`p_plies` AS `p_plies`,concat('R',`order_cat_recut_doc_mix`.`doc_no`) AS `doc_no`,`order_cat_recut_doc_mix`.`acutno` AS `acutno`,`order_cat_recut_doc_mix`.`a_xs` AS `a_xs`,`order_cat_recut_doc_mix`.`a_s` AS `a_s`,`order_cat_recut_doc_mix`.`a_m` AS `a_m`,`order_cat_recut_doc_mix`.`a_l` AS `a_l`,`order_cat_recut_doc_mix`.`a_xl` AS `a_xl`,`order_cat_recut_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_recut_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_recut_doc_mix`.`a_plies` AS `a_plies`,`order_cat_recut_doc_mix`.`lastup` AS `lastup`,`order_cat_recut_doc_mix`.`remarks` AS `remarks`,`order_cat_recut_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_recut_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_recut_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_recut_doc_mix`.`print_status` AS `print_status`,`order_cat_recut_doc_mix`.`a_s01` AS `a_s01`,`order_cat_recut_doc_mix`.`a_s02` AS `a_s02`,`order_cat_recut_doc_mix`.`a_s03` AS `a_s03`,`order_cat_recut_doc_mix`.`a_s04` AS `a_s04`,`order_cat_recut_doc_mix`.`a_s05` AS `a_s05`,`order_cat_recut_doc_mix`.`a_s06` AS `a_s06`,`order_cat_recut_doc_mix`.`a_s07` AS `a_s07`,`order_cat_recut_doc_mix`.`a_s08` AS `a_s08`,`order_cat_recut_doc_mix`.`a_s09` AS `a_s09`,`order_cat_recut_doc_mix`.`a_s10` AS `a_s10`,`order_cat_recut_doc_mix`.`a_s11` AS `a_s11`,`order_cat_recut_doc_mix`.`a_s12` AS `a_s12`,`order_cat_recut_doc_mix`.`a_s13` AS `a_s13`,`order_cat_recut_doc_mix`.`a_s14` AS `a_s14`,`order_cat_recut_doc_mix`.`a_s15` AS `a_s15`,`order_cat_recut_doc_mix`.`a_s16` AS `a_s16`,`order_cat_recut_doc_mix`.`a_s17` AS `a_s17`,`order_cat_recut_doc_mix`.`a_s18` AS `a_s18`,`order_cat_recut_doc_mix`.`a_s19` AS `a_s19`,`order_cat_recut_doc_mix`.`a_s20` AS `a_s20`,`order_cat_recut_doc_mix`.`a_s21` AS `a_s21`,`order_cat_recut_doc_mix`.`a_s22` AS `a_s22`,`order_cat_recut_doc_mix`.`a_s23` AS `a_s23`,`order_cat_recut_doc_mix`.`a_s24` AS `a_s24`,`order_cat_recut_doc_mix`.`a_s25` AS `a_s25`,`order_cat_recut_doc_mix`.`a_s26` AS `a_s26`,`order_cat_recut_doc_mix`.`a_s27` AS `a_s27`,`order_cat_recut_doc_mix`.`a_s28` AS `a_s28`,`order_cat_recut_doc_mix`.`a_s29` AS `a_s29`,`order_cat_recut_doc_mix`.`a_s30` AS `a_s30`,`order_cat_recut_doc_mix`.`a_s31` AS `a_s31`,`order_cat_recut_doc_mix`.`a_s32` AS `a_s32`,`order_cat_recut_doc_mix`.`a_s33` AS `a_s33`,`order_cat_recut_doc_mix`.`a_s34` AS `a_s34`,`order_cat_recut_doc_mix`.`a_s35` AS `a_s35`,`order_cat_recut_doc_mix`.`a_s36` AS `a_s36`,`order_cat_recut_doc_mix`.`a_s37` AS `a_s37`,`order_cat_recut_doc_mix`.`a_s38` AS `a_s38`,`order_cat_recut_doc_mix`.`a_s39` AS `a_s39`,`order_cat_recut_doc_mix`.`a_s40` AS `a_s40`,`order_cat_recut_doc_mix`.`a_s41` AS `a_s41`,`order_cat_recut_doc_mix`.`a_s42` AS `a_s42`,`order_cat_recut_doc_mix`.`a_s43` AS `a_s43`,`order_cat_recut_doc_mix`.`a_s44` AS `a_s44`,`order_cat_recut_doc_mix`.`a_s45` AS `a_s45`,`order_cat_recut_doc_mix`.`a_s46` AS `a_s46`,`order_cat_recut_doc_mix`.`a_s47` AS `a_s47`,`order_cat_recut_doc_mix`.`a_s48` AS `a_s48`,`order_cat_recut_doc_mix`.`a_s49` AS `a_s49`,`order_cat_recut_doc_mix`.`a_s50` AS `a_s50`,`order_cat_recut_doc_mix`.`p_s01` AS `p_s01`,`order_cat_recut_doc_mix`.`p_s02` AS `p_s02`,`order_cat_recut_doc_mix`.`p_s03` AS `p_s03`,`order_cat_recut_doc_mix`.`p_s04` AS `p_s04`,`order_cat_recut_doc_mix`.`p_s05` AS `p_s05`,`order_cat_recut_doc_mix`.`p_s06` AS `p_s06`,`order_cat_recut_doc_mix`.`p_s07` AS `p_s07`,`order_cat_recut_doc_mix`.`p_s08` AS `p_s08`,`order_cat_recut_doc_mix`.`p_s09` AS `p_s09`,`order_cat_recut_doc_mix`.`p_s10` AS `p_s10`,`order_cat_recut_doc_mix`.`p_s11` AS `p_s11`,`order_cat_recut_doc_mix`.`p_s12` AS `p_s12`,`order_cat_recut_doc_mix`.`p_s13` AS `p_s13`,`order_cat_recut_doc_mix`.`p_s14` AS `p_s14`,`order_cat_recut_doc_mix`.`p_s15` AS `p_s15`,`order_cat_recut_doc_mix`.`p_s16` AS `p_s16`,`order_cat_recut_doc_mix`.`p_s17` AS `p_s17`,`order_cat_recut_doc_mix`.`p_s18` AS `p_s18`,`order_cat_recut_doc_mix`.`p_s19` AS `p_s19`,`order_cat_recut_doc_mix`.`p_s20` AS `p_s20`,`order_cat_recut_doc_mix`.`p_s21` AS `p_s21`,`order_cat_recut_doc_mix`.`p_s22` AS `p_s22`,`order_cat_recut_doc_mix`.`p_s23` AS `p_s23`,`order_cat_recut_doc_mix`.`p_s24` AS `p_s24`,`order_cat_recut_doc_mix`.`p_s25` AS `p_s25`,`order_cat_recut_doc_mix`.`p_s26` AS `p_s26`,`order_cat_recut_doc_mix`.`p_s27` AS `p_s27`,`order_cat_recut_doc_mix`.`p_s28` AS `p_s28`,`order_cat_recut_doc_mix`.`p_s29` AS `p_s29`,`order_cat_recut_doc_mix`.`p_s30` AS `p_s30`,`order_cat_recut_doc_mix`.`p_s31` AS `p_s31`,`order_cat_recut_doc_mix`.`p_s32` AS `p_s32`,`order_cat_recut_doc_mix`.`p_s33` AS `p_s33`,`order_cat_recut_doc_mix`.`p_s34` AS `p_s34`,`order_cat_recut_doc_mix`.`p_s35` AS `p_s35`,`order_cat_recut_doc_mix`.`p_s36` AS `p_s36`,`order_cat_recut_doc_mix`.`p_s37` AS `p_s37`,`order_cat_recut_doc_mix`.`p_s38` AS `p_s38`,`order_cat_recut_doc_mix`.`p_s39` AS `p_s39`,`order_cat_recut_doc_mix`.`p_s40` AS `p_s40`,`order_cat_recut_doc_mix`.`p_s41` AS `p_s41`,`order_cat_recut_doc_mix`.`p_s42` AS `p_s42`,`order_cat_recut_doc_mix`.`p_s43` AS `p_s43`,`order_cat_recut_doc_mix`.`p_s44` AS `p_s44`,`order_cat_recut_doc_mix`.`p_s45` AS `p_s45`,`order_cat_recut_doc_mix`.`p_s46` AS `p_s46`,`order_cat_recut_doc_mix`.`p_s47` AS `p_s47`,`order_cat_recut_doc_mix`.`p_s48` AS `p_s48`,`order_cat_recut_doc_mix`.`p_s49` AS `p_s49`,`order_cat_recut_doc_mix`.`p_s50` AS `p_s50`,`order_cat_recut_doc_mix`.`rm_date` AS `rm_date`,`order_cat_recut_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_recut_doc_mix`.`plan_module` AS `plan_module`,`order_cat_recut_doc_mix`.`category` AS `category`,`order_cat_recut_doc_mix`.`color_code` AS `color_code`,`order_cat_recut_doc_mix`.`fabric_status` AS `fabric_status`,`order_cat_recut_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_recut_doc_mix`.`plan_lot_ref` AS `plan_lot_ref`,`order_cat_recut_doc_mix`.`order_col_des` AS `order_col_des`,`order_cat_recut_doc_mix`.`order_style_no` AS `order_style_no` from (`bai_pro3`.`order_cat_recut_doc_mix` left join `brandix_bts`.`tbl_cut_master` on(`brandix_bts`.`tbl_cut_master`.`doc_num` = concat('R',`order_cat_recut_doc_mix`.`doc_no`))) where `order_cat_recut_doc_mix`.`category` in ('Body','Front') and `order_cat_recut_doc_mix`.`act_cut_status` = 'DONE' and `brandix_bts`.`tbl_cut_master`.`id` is null and `order_cat_recut_doc_mix`.`order_del_no` in (select `brandix_bts`.`tbl_orders_master`.`product_schedule` from `brandix_bts`.`tbl_orders_master`)) */;

/*View structure for view view_set_1 */

/*!50001 DROP TABLE IF EXISTS `view_set_1` */;
/*!50001 DROP VIEW IF EXISTS `view_set_1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_1` AS (select `bundle_transactions_20_repeat`.`id` AS `bundle_transactions_20_repeat_id`,`bundle_transactions_20_repeat`.`parent_id` AS `bundle_transactions_20_repeat_parent_id`,`bundle_transactions_20_repeat`.`bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,`bundle_transactions_20_repeat`.`quantity` AS `bundle_transactions_20_repeat_quantity`,`bundle_transactions_20_repeat`.`bundle_id` AS `bundle_transactions_20_repeat_bundle_id`,`bundle_transactions_20_repeat`.`operation_id` AS `bundle_transactions_20_repeat_operation_id`,`bundle_transactions_20_repeat`.`rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,if(`bundle_transactions_20_repeat`.`act_module` > 0,`bundle_transactions_20_repeat`.`act_module`,`bundle_transactions`.`module_id`) AS `bundle_transactions_20_repeat_act_module`,`tbl_orders_ops_ref`.`id` AS `tbl_orders_ops_ref_id`,`tbl_orders_ops_ref`.`operation_name` AS `tbl_orders_ops_ref_operation_name`,`tbl_orders_ops_ref`.`default_operation` AS `tbl_orders_ops_ref_default_operation`,`tbl_orders_ops_ref`.`operation_code` AS `tbl_orders_ops_ref_operation_code`,`bundle_transactions`.`id` AS `bundle_transactions_id`,`bundle_transactions`.`date_time` AS `bundle_transactions_date_time`,`bundle_transactions`.`operation_time` AS `bundle_transactions_operation_time`,`bundle_transactions`.`employee_id` AS `bundle_transactions_employee_id`,`bundle_transactions`.`shift` AS `bundle_transactions_shift`,`bundle_transactions`.`trans_status` AS `bundle_transactions_trans_status`,`bundle_transactions`.`module_id` AS `bundle_transactions_module_id`,`tbl_shifts_master`.`id` AS `tbl_shifts_master_id`,`tbl_shifts_master`.`date_time` AS `tbl_shifts_master_date_time`,`tbl_shifts_master`.`shift_name` AS `tbl_shifts_master_shift_name` from (((`bundle_transactions_20_repeat` left join `tbl_orders_ops_ref` on(`bundle_transactions_20_repeat`.`operation_id` = `tbl_orders_ops_ref`.`id`)) left join `bundle_transactions` on(`bundle_transactions_20_repeat`.`parent_id` = `bundle_transactions`.`id`)) left join `tbl_shifts_master` on(`tbl_shifts_master`.`id` = `bundle_transactions`.`shift`))) */;

/*View structure for view view_set_1_virtual */

/*!50001 DROP TABLE IF EXISTS `view_set_1_virtual` */;
/*!50001 DROP VIEW IF EXISTS `view_set_1_virtual` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_1_virtual` AS (select `bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`id` AS `bundle_transactions_20_repeat_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`parent_id` AS `bundle_transactions_20_repeat_parent_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`quantity` AS `bundle_transactions_20_repeat_quantity`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`bundle_id` AS `bundle_transactions_20_repeat_bundle_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`operation_id` AS `bundle_transactions_20_repeat_operation_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,if(`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`act_module` > 0,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`act_module`,`bundle_transactions`.`module_id`) AS `bundle_transactions_20_repeat_act_module`,`tbl_orders_ops_ref`.`id` AS `tbl_orders_ops_ref_id`,`tbl_orders_ops_ref`.`operation_name` AS `tbl_orders_ops_ref_operation_name`,`tbl_orders_ops_ref`.`default_operation` AS `tbl_orders_ops_ref_default_operation`,`tbl_orders_ops_ref`.`operation_code` AS `tbl_orders_ops_ref_operation_code`,`bundle_transactions`.`id` AS `bundle_transactions_id`,`bundle_transactions`.`date_time` AS `bundle_transactions_date_time`,`bundle_transactions`.`operation_time` AS `bundle_transactions_operation_time`,`bundle_transactions`.`employee_id` AS `bundle_transactions_employee_id`,`bundle_transactions`.`shift` AS `bundle_transactions_shift`,`bundle_transactions`.`trans_status` AS `bundle_transactions_trans_status`,`bundle_transactions`.`module_id` AS `bundle_transactions_module_id`,`tbl_shifts_master`.`id` AS `tbl_shifts_master_id`,`tbl_shifts_master`.`date_time` AS `tbl_shifts_master_date_time`,`tbl_shifts_master`.`shift_name` AS `tbl_shifts_master_shift_name` from (((`bundle_transactions_20_repeat_virtual_snap_ini_bundles` left join `tbl_orders_ops_ref` on(`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`operation_id` = `tbl_orders_ops_ref`.`id`)) left join `bundle_transactions` on(`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`parent_id` = `bundle_transactions`.`id`)) left join `tbl_shifts_master` on(`tbl_shifts_master`.`id` = `bundle_transactions`.`shift`))) */;

/*View structure for view view_set_4 */

/*!50001 DROP TABLE IF EXISTS `view_set_4` */;
/*!50001 DROP VIEW IF EXISTS `view_set_4` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_4` AS (select cast(`pacstat`.`scan_date` as date) AS `date`,`orders`.`order_style_no` AS `style`,`orders`.`order_del_no` AS `SCHEDULE`,sum(`pacstat`.`carton_act_qty`) AS `cpk_qty`,concat(cast(`pacstat`.`scan_date` as date),convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8)) AS `order_tid_new` from ((`bai_pro3`.`pac_stat_log` `pacstat` left join `bai_pro3`.`plandoc_stat_log` `plandoc` on(`plandoc`.`doc_no` = `pacstat`.`doc_no`)) left join `bai_pro3`.`bai_orders_db_confirm` `orders` on(`orders`.`order_tid` = `plandoc`.`order_tid`)) where `pacstat`.`status` = 'DONE' group by cast(`pacstat`.`scan_date` as date),`orders`.`order_style_no`,`orders`.`order_del_no`) */;

/*View structure for view view_set_5 */

/*!50001 DROP TABLE IF EXISTS `view_set_5` */;
/*!50001 DROP VIEW IF EXISTS `view_set_5` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_5` AS (select `bai_pro3`.`bai_qms_db`.`log_date` AS `log_date`,`bai_pro3`.`bai_qms_db`.`qms_style` AS `qms_style`,`bai_pro3`.`bai_qms_db`.`qms_schedule` AS `qms_schedule`,sum(`bai_pro3`.`bai_qms_db`.`qms_qty`) AS `rejected_qty` from `bai_pro3`.`bai_qms_db` where `bai_pro3`.`bai_qms_db`.`qms_tran_type` in (3,4,5) group by `bai_pro3`.`bai_qms_db`.`log_date`,`bai_pro3`.`bai_qms_db`.`qms_schedule`) */;

/*View structure for view view_set_6 */

/*!50001 DROP TABLE IF EXISTS `view_set_6` */;
/*!50001 DROP VIEW IF EXISTS `view_set_6` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_6` AS (select cast(`pacstat`.`scan_date` as date) AS `date`,`orders`.`order_style_no` AS `style`,`orders`.`order_del_no` AS `SCHEDULE`,`orders`.`order_col_des` AS `color`,`orders_mas_size`.`size_title` AS `size`,sum(`pacstat`.`carton_act_qty`) AS `cpk_qty`,concat(convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8),convert(`orders`.`order_col_des` using utf8),`orders_mas_size`.`size_title`) AS `order_tid_new`,1 AS `barcode`,concat(cast(`pacstat`.`scan_date` as date),convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8),convert(`orders`.`order_col_des` using utf8),`orders_mas_size`.`size_title`) AS `order_tid_new_2` from (((((`bai_pro3`.`pac_stat_log` `pacstat` left join `bai_pro3`.`plandoc_stat_log` `plandoc` on(`plandoc`.`doc_no` = `pacstat`.`doc_no`)) left join `bai_pro3`.`bai_orders_db_confirm` `orders` on(`orders`.`order_tid` = `plandoc`.`order_tid`)) left join `brandix_bts`.`tbl_orders_size_ref` `sizes` on(convert(`pacstat`.`size_code` using utf8) = `sizes`.`size_name`)) left join `brandix_bts`.`tbl_orders_master` `orders_mas` on(`orders_mas`.`product_schedule` = convert(`orders`.`order_del_no` using utf8))) left join `brandix_bts`.`tbl_orders_sizes_master` `orders_mas_size` on(`orders_mas_size`.`parent_id` = `orders_mas`.`id`)) where `pacstat`.`status` = 'DONE' and `orders_mas_size`.`order_col_des` = convert(`orders`.`order_col_des` using utf8) and `orders_mas_size`.`ref_size_name` = `sizes`.`id` group by cast(`pacstat`.`scan_date` as date),`orders`.`order_style_no`,`orders`.`order_del_no`,`orders`.`order_col_des`,`orders_mas_size`.`size_title`) */;

/*View structure for view view_set_snap_1 */

/*!50001 DROP TABLE IF EXISTS `view_set_snap_1` */;
/*!50001 DROP VIEW IF EXISTS `view_set_snap_1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_snap_1` AS (select distinct `view_set_1_snap`.`bundle_transactions_20_repeat_id` AS `bundle_transactions_20_repeat_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_quantity` AS `bundle_transactions_20_repeat_quantity`,`view_set_1_snap`.`bundle_transactions_20_repeat_operation_id` AS `bundle_transactions_20_repeat_operation_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,`view_set_1_snap`.`tbl_shifts_master_shift_name` AS `tbl_shifts_master_shift_name`,`view_set_1_snap`.`tbl_orders_ops_ref_operation_code` AS `tbl_orders_ops_ref_operation_code`,`view_set_1_snap`.`tbl_orders_ops_ref_operation_name` AS `tbl_orders_ops_ref_operation_name`,`view_set_1_snap`.`bundle_transactions_module_id` AS `bundle_transactions_module_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_act_module` AS `bundle_transactions_20_repeat_act_module`,`view_set_1_snap`.`bundle_transactions_employee_id` AS `bundle_transactions_employee_id`,`view_set_1_snap`.`bundle_transactions_date_time` AS `bundle_transactions_date_time`,`view_set_2_snap`.`tbl_orders_size_ref_size_name` AS `tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title` AS `tbl_orders_sizes_master_size_title`,`view_set_2_snap`.`tbl_orders_sizes_master_order_quantity` AS `tbl_orders_sizes_master_order_quantity`,`view_set_2_snap`.`tbl_orders_style_ref_product_style` AS `tbl_orders_style_ref_product_style`,`view_set_3_snap`.`tbl_miniorder_data_quantity` AS `tbl_miniorder_data_quantity`,`view_set_3_snap`.`tbl_miniorder_data_bundle_number` AS `tbl_miniorder_data_bundle_number`,`view_set_3_snap`.`tbl_miniorder_data_color` AS `tbl_miniorder_data_color`,`view_set_3_snap`.`tbl_miniorder_data_mini_order_num` AS `tbl_miniorder_data_mini_order_num`,`view_set_2_snap`.`tbl_orders_master_product_schedule` AS `tbl_orders_master_product_schedule`,`view_set_2_snap`.`tbl_orders_size_ref_id` AS `tbl_orders_size_ref_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,if(octet_length(`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) = 0,`view_set_2_snap`.`tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) AS `size_disp`,`view_set_3_snap`.`order_id` AS `order_id`,round(if(`view_set_1_snap`.`tbl_orders_ops_ref_operation_code` = 'LNO',`view_set_1_snap`.`bundle_transactions_20_repeat_quantity` * `view_set_2_snap`.`smv` / 60,0),2) AS `sah`,`view_set_2_snap`.`order_div` AS `order_div`,`view_set_2_snap`.`order_date` AS `order_date`,concat(`view_set_2_snap`.`tbl_orders_style_ref_product_style`,`view_set_2_snap`.`tbl_orders_master_product_schedule`,`view_set_3_snap`.`tbl_miniorder_data_color`,if(octet_length(`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) = 0,`view_set_2_snap`.`tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title`)) AS `order_tid_new`,`tbl_module_ref`.`module_section` AS `tbl_module_ref_module_section`,`view_set_1_snap`.`bundle_transactions_operation_time` AS `bundle_transactions_operation_time`,`view_set_2_snap`.`smv` AS `view_set_2_snap_smv`,`view_set_3_snap`.`tbl_miniorder_data_docket_number` AS `tbl_miniorder_data_docket_number` from (((`view_set_1_snap` left join `view_set_3_snap` on(`view_set_1_snap`.`bundle_transactions_20_repeat_bundle_barcode` = `view_set_3_snap`.`tbl_miniorder_data_bundle_number`)) left join `view_set_2_snap` on(`view_set_2_snap`.`order_id` = `view_set_3_snap`.`order_id`)) left join `tbl_module_ref` on(convert(`view_set_1_snap`.`bundle_transactions_module_id` using utf8) = `tbl_module_ref`.`id`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
