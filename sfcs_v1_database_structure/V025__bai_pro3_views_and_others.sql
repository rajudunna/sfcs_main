/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_pro3
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro3` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*USE `bai_pro3`;*/

/* Trigger structure for table `bai_orders_db_confirm` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `a_i_bai_orders_db_confirm` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `a_i_bai_orders_db_confirm` AFTER INSERT ON `bai_orders_db_confirm` FOR EACH ROW BEGIN 						SET @time_mark = DATE_ADD(NOW(), INTERVAL 18 SECOND); 						SET @tbl_name = 'bai_orders_db_confirm'; 						SET @pk_d = CONCAT('<order_tid>',NEW.`order_tid`,'</order_tid>'); 						SET @rec_state = 1;						DELETE FROM `history_store` WHERE `table_name` = @tbl_name AND `pk_date_src` = @pk_d; 						INSERT INTO `history_store`( `timemark`, `table_name`, `pk_date_src`,`pk_date_dest`,`record_state` ) 						VALUES (@time_mark, @tbl_name, @pk_d, @pk_d, @rec_state); 						END */$$


DELIMITER ;

/* Trigger structure for table `bai_orders_db_confirm` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `a_u_bai_orders_db_confirm` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `a_u_bai_orders_db_confirm` AFTER UPDATE ON `bai_orders_db_confirm` FOR EACH ROW BEGIN						SET @time_mark = DATE_ADD(NOW(), INTERVAL 18 SECOND); 						SET @tbl_name = 'bai_orders_db_confirm';						SET @pk_d_old = CONCAT('<order_tid>',OLD.`order_tid`,'</order_tid>');						SET @pk_d = CONCAT('<order_tid>',NEW.`order_tid`,'</order_tid>');						SET @rec_state = 2;						SET @rs = 0;						SELECT `record_state` INTO @rs FROM `history_store` WHERE `table_name` = @tbl_name AND `pk_date_src` = @pk_d_old;						IF @rs = 0 THEN 						INSERT INTO `history_store`( `timemark`, `table_name`, `pk_date_src`,`pk_date_dest`, `record_state` ) VALUES (@time_mark, @tbl_name, @pk_d,@pk_d_old, @rec_state );						ELSE 						UPDATE `history_store` SET `timemark` = @time_mark, `pk_date_src` = @pk_d WHERE `table_name` = @tbl_name AND `pk_date_src` = @pk_d_old;						END IF; END */$$


DELIMITER ;

/* Trigger structure for table `bai_orders_db_confirm` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `a_d_bai_orders_db_confirm` */$$

/*!50003 CREATE */ /*!50003 TRIGGER `a_d_bai_orders_db_confirm` AFTER DELETE ON `bai_orders_db_confirm` FOR EACH ROW BEGIN						SET @time_mark = DATE_ADD(NOW(), INTERVAL 19 SECOND); 						SET @tbl_name = 'bai_orders_db_confirm';						SET @pk_d = CONCAT('<order_tid>',OLD.`order_tid`,'</order_tid>');						SET @rec_state = 3;						SET @rs = 0;						SELECT `record_state` INTO @rs FROM `history_store` WHERE  `table_name` = @tbl_name AND `pk_date_src` = @pk_d;						DELETE FROM `history_store` WHERE `table_name` = @tbl_name AND `pk_date_src` = @pk_d; 						IF @rs <> 1 THEN 						INSERT INTO `history_store`( `timemark`, `table_name`, `pk_date_src`,`pk_date_dest`, `record_state` ) VALUES (@time_mark, @tbl_name, @pk_d,@pk_d, @rec_state ); 						END IF; END */$$


DELIMITER ;

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `call_sync_dump` */

/*!50106 DROP EVENT IF EXISTS `call_sync_dump`*/;

DELIMITER $$

/*!50106 CREATE EVENT `call_sync_dump` ON SCHEDULE EVERY 5 MINUTE STARTS '2017-05-30 17:30:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	   	 CALL carton_scan_dump();
	   END */$$
DELIMITER ;

/* Function  structure for function  `fn_act_pac_qty` */

/*!50003 DROP FUNCTION IF EXISTS `fn_act_pac_qty` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_act_pac_qty`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	   SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(carton_act_qty),0) FROM pac_stat_log WHERE doc_no=in_ims_doc_no AND size_code=in_ims_size AND STATUS="DONE");
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;	 
	  RETURN var_name;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_act_ship_qty` */

/*!50003 DROP FUNCTION IF EXISTS `fn_act_ship_qty` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_act_ship_qty`(in_sch_no BIGINT) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	  /*SET var_name=(SELECT COALESCE(SUM(shipped),0) FROM bai_ship_cts_ref WHERE ship_schedule=in_sch_no);*/
	  SET var_name=(SELECT
  COALESCE(SUM((((((((((((((((((((`ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08`) + `ship_stat_log`.`ship_s_s10`) + `ship_stat_log`.`ship_s_s12`) + `ship_stat_log`.`ship_s_s14`) + `ship_stat_log`.`ship_s_s16`) + `ship_stat_log`.`ship_s_s18`) + `ship_stat_log`.`ship_s_s20`) + `ship_stat_log`.`ship_s_s22`) + `ship_stat_log`.`ship_s_s24`) + `ship_stat_log`.`ship_s_s26`) + `ship_stat_log`.`ship_s_s28`) + `ship_stat_log`.`ship_s_s30`) + `ship_stat_log`.`ship_s_xs`) + `ship_stat_log`.`ship_s_s`) + `ship_stat_log`.`ship_s_m`) + `ship_stat_log`.`ship_s_l`) + `ship_stat_log`.`ship_s_xl`) + `ship_stat_log`.`ship_s_xxl`) + `ship_stat_log`.`ship_s_xxxl`)),0) AS `shipped`
FROM `ship_stat_log`
WHERE (ship_schedule=in_sch_no AND `ship_stat_log`.`ship_status` = 2));
	  RETURN var_name;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_buyer_division_sch` */

/*!50003 DROP FUNCTION IF EXISTS `fn_buyer_division_sch` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_buyer_division_sch`(in_schedule VARCHAR(100)) RETURNS varchar(100) CHARSET latin1
BEGIN
	DECLARE order_div_name VARCHAR(200);
	set order_div_name=(SELECT order_div FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no=in_schedule limit 1);
	if LENGTH(order_div_name)=0 or order_div_name is null then
		SET order_div_name=(SELECT order_div FROM bai_pro3.bai_orders_db_confirm_archive WHERE order_del_no=in_schedule LIMIT 1);
	end if;
	
	return order_div_name;
END */$$
DELIMITER ;

/* Function  structure for function  `fn_ims_log_bk_output` */

/*!50003 DROP FUNCTION IF EXISTS `fn_ims_log_bk_output` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_ims_log_bk_output`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	   SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(ims_pro_qty),0) FROM ims_log_backup WHERE ims_doc_no=in_ims_doc_no AND ims_size=("a_"+in_ims_size) AND ims_mod_no > 0);
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;	  
	  RETURN var_name;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_ims_log_output` */

/*!50003 DROP FUNCTION IF EXISTS `fn_ims_log_output` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_ims_log_output`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(ims_pro_qty),0) FROM ims_log WHERE ims_doc_no=in_ims_doc_no AND ims_size=("a_"+in_ims_size) AND ims_mod_no > 0);
	SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
	  RETURN var_name;
    END */$$
DELIMITER ;

/* Function  structure for function  `fn_know_binding_con` */

/*!50003 DROP FUNCTION IF EXISTS `fn_know_binding_con` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_know_binding_con`(ord_id VARCHAR(200)) RETURNS float(10,4)
BEGIN
DECLARE bin_con FLOAT(10,4);
SET @bin_con = (SELECT COALESCE(binding_con,0) FROM `bai_orders_db_remarks` WHERE order_tid=ord_id);
RETURN COALESCE(@bin_con,0);
END */$$
DELIMITER ;

/* Function  structure for function  `fn_know_binding_con_v2` */

/*!50003 DROP FUNCTION IF EXISTS `fn_know_binding_con_v2` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_know_binding_con_v2`(ord_id VARCHAR(200),category VARCHAR(100)) RETURNS float(10,4)
BEGIN
DECLARE bin_con FLOAT(10,4);
IF category='Front' OR category='Body' THEN
SET @bin_con = (SELECT COALESCE(binding_con,0) FROM `bai_orders_db_remarks` WHERE order_tid=ord_id);
ELSE
SET @bin_con =0;
END IF;
RETURN COALESCE(@bin_con,0);
END */$$
DELIMITER ;

/* Function  structure for function  `fn_savings_per_cal` */

/*!50003 DROP FUNCTION IF EXISTS `fn_savings_per_cal` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `fn_savings_per_cal`(dat DATE,cat_re BIGINT,sch VARCHAR(300),col VARCHAR(300)) RETURNS float(10,2)
BEGIN
    /* This function created on 20140207 by KiranG, to get additional material calculation based on the savings above 1% */
	DECLARE order_qty BIGINT;
	DECLARE actyy FLOAT(10,2);
	DECLARE multipleval FLOAT(10,2);
	
	IF dat>'2014-02-07' THEN
		
		SET @order_qty = (SELECT (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30) FROM bai_orders_db_confirm WHERE order_del_no=sch AND TRIM(BOTH FROM order_col_des)=TRIM(BOTH FROM col));
		
		SET @actyy= (SELECT ROUND(((MIN(catyy)-SUM(mklength*p_plies)/@order_qty)/MIN(catyy))*100,1) FROM order_cat_doc_mk_mix WHERE cat_ref=cat_re);
		
		IF @actyy>1 THEN
			SET @multipleval=0;
		ELSE
			SET @multipleval=0;
		END IF;
	ELSE
		SET @multipleval=0.01;
	END IF;
	
	RETURN @multipleval;
	
    END */$$
DELIMITER ;

/* Function  structure for function  `input_job_input_status` */

/*!50003 DROP FUNCTION IF EXISTS `input_job_input_status` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `input_job_input_status`(in_job_rand_no_ref VARCHAR(30)) RETURNS varchar(10) CHARSET latin1
    DETERMINISTIC
BEGIN
	DECLARE input_qty BIGINT;
	DECLARE job_qty BIGINT;
	
	-- SET @input_qty = (SELECT COALESCE(SUM(in_qty),0) FROM ((SELECT SUM(ims_qty) AS in_qty FROM ims_log_backup WHERE input_job_rand_no_ref=in_job_rand_no_ref) UNION (SELECT SUM(ims_qty) AS in_qty FROM ims_log WHERE input_job_rand_no_ref=in_job_rand_no_ref)) AS tmp);
	
	SET @input_qty = (SELECT COALESCE(SUM(ims_qty),0) FROM ((SELECT * FROM ims_log_backup WHERE input_job_rand_no_ref=in_job_rand_no_ref) UNION (SELECT * FROM ims_log WHERE input_job_rand_no_ref=in_job_rand_no_ref)) AS tmp);	
	
	SET @job_qty = (SELECT SUM(carton_act_qty) FROM pac_stat_log_input_job WHERE input_job_no_random=in_job_rand_no_ref);
	
	IF(@input_qty=@job_qty) THEN
		RETURN 'DONE';
	ELSE
		RETURN '';
	END IF;
    END */$$
DELIMITER ;

/* Function  structure for function  `stripSpeciaChars` */

/*!50003 DROP FUNCTION IF EXISTS `stripSpeciaChars` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `stripSpeciaChars`(`dirty_string` VARCHAR(2048),allow_space TINYINT,allow_number TINYINT,allow_alphabets TINYINT,no_trim TINYINT) RETURNS varchar(2048) CHARSET utf8
BEGIN
/**
*http://devzone.co.in/mysql-function-to-remove-special-characters-accents-non-ascii-characters/
 * MySQL function to remove Special characters, Non-ASCII,hidden characters leads to spaces, accents etc
 * Downloaded from http://DevZone.co.in
 * @param VARCHAR dirty_string : dirty string as input
 * @param VARCHAR allow_space : allow spaces between string in output; takes 0-1 as parameter
 * @param VARCHAR allow_number : allow numbers in output; takes 0-1 as parameter
 * @param VARCHAR allow_alphabets : allow alphabets in output; takes 0-1 as parameter
 * @param VARCHAR no_trim : don't trim the output; takes 0-1 as parameter
 * @return VARCHAR clean_string : clean string as output
 * 
 * Usage Syntax: stripSpeciaChars(string,allow_space,allow_number,allow_alphabets,no_trim);
 * Usage SQL> SELECT stripSpeciaChars("sdfa7987*&^&*ÂÃ ÄÅÆÇÈÉÊ sd sdfgËÌÍÎÏÑ ÒÓÔÕÖØÙÚàáâã sdkarkhru",0,0,1,0);
 * result : sdfasdsdfgsdkarkhru
 */
      DECLARE clean_string VARCHAR(2048) DEFAULT '';
      DECLARE c VARCHAR(2048) DEFAULT '';
      DECLARE counter INT DEFAULT 1;
	  
	  DECLARE has_space TINYINT DEFAULT 0; -- let spaces in result string
	  DECLARE chk_cse TINYINT DEFAULT 0; 
	  DECLARE adv_trim TINYINT DEFAULT 1; -- trim extra spaces along with hidden characters, new line characters etc.	  
	
	     IF allow_number=0 AND allow_alphabets=0 THEN
	    RETURN NULL;
	  ELSEIF allow_number=1 AND allow_alphabets=0 THEN
	  SET chk_cse =1;
	 ELSEIF allow_number=0 AND allow_alphabets=1 THEN
	  SET chk_cse =2;
	  END IF;	  
	  
	  IF allow_space=1 THEN
	  SET has_space =1;
	  END IF;
	  
	   IF no_trim=1 THEN
	  SET adv_trim =0;
	  END IF;
      IF ISNULL(dirty_string) THEN
            RETURN NULL;
      ELSE
	  
	  CASE chk_cse
      WHEN 1 THEN 
	  -- return only Numbers in result
	  WHILE counter <= LENGTH(dirty_string) DO
                   
                  SET c = MID(dirty_string, counter, 1);
                  IF ASCII(c) = 32 OR ASCII(c) >= 48 AND ASCII(c) <= 57  THEN
                        SET clean_string = CONCAT(clean_string, c);
                  END IF;
                  SET counter = counter + 1;
            END WHILE;
      WHEN 2 THEN 
	  -- return only Alphabets in result
	  WHILE counter <= LENGTH(dirty_string) DO
                   
                  SET c = MID(dirty_string, counter, 1);
                  IF ASCII(c) = 32 OR ASCII(c) >= 65 AND ASCII(c) <= 90  OR ASCII(c) >= 97 AND ASCII(c) <= 122 THEN
                        SET clean_string = CONCAT(clean_string, c);
                  END IF;
                  SET counter = counter + 1;
            END WHILE;
      ELSE
	   -- return numbers and Alphabets in result
        WHILE counter <= LENGTH(dirty_string) DO
                   
                  SET c = MID(dirty_string, counter, 1);
                  IF ASCII(c) = 32 OR ASCII(c) >= 48 AND ASCII(c) <= 57 OR ASCII(c) >= 65 AND ASCII(c) <= 90  OR ASCII(c) >= 97 AND ASCII(c) <= 122 THEN
                        SET clean_string = CONCAT(clean_string, c);
                  END IF;
                  SET counter = counter + 1;
            END WHILE;		
    END CASE;            
      END IF;
	 
	  -- remove spaces from result
	  IF has_space=0 THEN
	  SET clean_string =REPLACE(clean_string,' ','');
	  END IF;
	 
	   -- remove extra spaces, newline,tabs. from result
	 IF adv_trim=1 THEN
	  SET clean_string =TRIM(REPLACE(REPLACE(REPLACE(clean_string,'\t',''),'\n',''),'\r',''));
	  END IF;	 
	  
      RETURN clean_string;
END */$$
DELIMITER ;

/*Table structure for table `audit_disp_tb2` */

DROP TABLE IF EXISTS `bai_pro3`.`audit_disp_tb2`;

/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2` */;
/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2` */;

/*!50001 CREATE TABLE  `audit_disp_tb2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `audit_disp_tb2_2` */

DROP TABLE IF EXISTS `bai_pro3`.`audit_disp_tb2_2`;

/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_2` */;
/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_2` */;

/*!50001 CREATE TABLE  `audit_disp_tb2_2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `color` varchar(60) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `audit_disp_tb2_size` */

DROP TABLE IF EXISTS `bai_pro3`.`audit_disp_tb2_size`;

/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_size` */;
/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_size` */;

/*!50001 CREATE TABLE  `audit_disp_tb2_size`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `size` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `audit_disp_tb2_size_2` */

DROP TABLE IF EXISTS `bai_pro3`.`audit_disp_tb2_size_2`;

/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_size_2` */;
/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_size_2` */;

/*!50001 CREATE TABLE  `audit_disp_tb2_size_2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `color` varchar(60) ,
 `size` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `bai_qms_cts_ref` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_cts_ref`;

/*!50001 DROP VIEW IF EXISTS `bai_qms_cts_ref` */;
/*!50001 DROP TABLE IF EXISTS `bai_qms_cts_ref` */;

/*!50001 CREATE TABLE  `bai_qms_cts_ref`(
 `qms_schedule` varchar(20) ,
 `qms_color` varchar(150) ,
 `good_panels` decimal(27,0) ,
 `replaced` decimal(27,0) ,
 `rejected` decimal(27,0) ,
 `sample_room` decimal(27,0) ,
 `good_garments` decimal(27,0) ,
 `recut_raised` decimal(27,0) ,
 `disposed` decimal(27,0) ,
 `sent_to_customer` decimal(27,0) ,
 `actual_recut` decimal(27,0) ,
 `tran_sent` decimal(27,0) ,
 `tran_rec` decimal(27,0) ,
 `resrv_dest` decimal(27,0) ,
 `panel_destroyed` decimal(27,0) 
)*/;

/*Table structure for table `bai_qms_day_report` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_day_report`;

/*!50001 DROP VIEW IF EXISTS `bai_qms_day_report` */;
/*!50001 DROP TABLE IF EXISTS `bai_qms_day_report` */;

/*!50001 CREATE TABLE  `bai_qms_day_report`(
 `qms_tid` int(11) ,
 `qms_style` varchar(30) ,
 `qms_schedule` varchar(20) ,
 `qms_color` varchar(150) ,
 `log_user` varchar(15) ,
 `log_date` date ,
 `log_time` timestamp ,
 `issued_by` varchar(30) ,
 `qms_size` varchar(5) ,
 `good_panels` decimal(27,0) ,
 `replaced` decimal(27,0) ,
 `rejected` decimal(27,0) ,
 `sample_room` decimal(27,0) ,
 `good_garments` decimal(27,0) ,
 `recut_raised` decimal(27,0) ,
 `disposed` decimal(27,0) ,
 `sent_to_customer` decimal(27,0) ,
 `actual_recut` decimal(27,0) ,
 `remarks` text ,
 `ref1` varchar(500) ,
 `tran_sent` decimal(27,0) ,
 `tran_rec` decimal(27,0) ,
 `resrv_dest` decimal(27,0) ,
 `panel_destroyed` decimal(27,0) 
)*/;

/*Table structure for table `bai_qms_pop_report` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_qms_pop_report`;

/*!50001 DROP VIEW IF EXISTS `bai_qms_pop_report` */;
/*!50001 DROP TABLE IF EXISTS `bai_qms_pop_report` */;

/*!50001 CREATE TABLE  `bai_qms_pop_report`(
 `qms_tid` int(11) ,
 `qms_style` varchar(30) ,
 `qms_schedule` varchar(20) ,
 `qms_color` varchar(150) ,
 `log_user` varchar(15) ,
 `log_date` date ,
 `log_time` timestamp ,
 `issued_by` varchar(30) ,
 `qms_size` varchar(5) ,
 `good_panels` decimal(27,0) ,
 `replaced` decimal(27,0) ,
 `rejected` decimal(27,0) ,
 `sample_room` decimal(27,0) ,
 `good_garments` decimal(27,0) ,
 `recut_raised` decimal(27,0) ,
 `disposed` decimal(27,0) ,
 `sent_to_customer` decimal(27,0) ,
 `actual_recut` decimal(27,0) ,
 `remarks` text ,
 `ref1` varchar(500) ,
 `module` text ,
 `team` text ,
 `tran_sent` decimal(27,0) ,
 `tran_rec` decimal(27,0) ,
 `resrv_dest` decimal(27,0) ,
 `panel_destroyed` decimal(27,0) 
)*/;

/*Table structure for table `bai_ship_cts_ref` */

DROP TABLE IF EXISTS `bai_pro3`.`bai_ship_cts_ref`;

/*!50001 DROP VIEW IF EXISTS `bai_ship_cts_ref` */;
/*!50001 DROP TABLE IF EXISTS `bai_ship_cts_ref` */;

/*!50001 CREATE TABLE  `bai_ship_cts_ref`(
 `shipped` decimal(65,0) ,
 `ship_style` varchar(100) ,
 `ship_schedule` varchar(100) ,
 `disp_note_ref` mediumtext 
)*/;

/*Table structure for table `cut_dept_report` */

DROP TABLE IF EXISTS `bai_pro3`.`cut_dept_report`;

/*!50001 DROP VIEW IF EXISTS `cut_dept_report` */;
/*!50001 DROP TABLE IF EXISTS `cut_dept_report` */;

/*!50001 CREATE TABLE  `cut_dept_report`(
 `date` date ,
 `category` varchar(50) ,
 `catyy` double ,
 `doc_no` int(11) ,
 `section` int(11) ,
 `remarks` varchar(200) ,
 `net_uti` double ,
 `log_time` time ,
 `fab_received` float ,
 `damages` float ,
 `shortages` float ,
 `tot_cut_qty` bigint(66) 
)*/;

/*Table structure for table `disp_mix` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_mix`;

/*!50001 DROP VIEW IF EXISTS `disp_mix` */;
/*!50001 DROP TABLE IF EXISTS `disp_mix` */;

/*!50001 CREATE TABLE  `disp_mix`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_col_des` mediumtext ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) ,
 `audit_pending` decimal(33,0) ,
 `fca_app` decimal(32,0) ,
 `fca_fail` decimal(32,0) ,
 `fca_audit_pending` decimal(33,0) 
)*/;

/*Table structure for table `disp_mix_2` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_mix_2`;

/*!50001 DROP VIEW IF EXISTS `disp_mix_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_mix_2` */;

/*!50001 CREATE TABLE  `disp_mix_2`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_col_des` mediumtext ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) ,
 `audit_pending` decimal(33,0) ,
 `fca_app` decimal(32,0) ,
 `fca_fail` decimal(32,0) ,
 `fca_audit_pending` decimal(33,0) 
)*/;

/*Table structure for table `disp_mix_size` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_mix_size`;

/*!50001 DROP VIEW IF EXISTS `disp_mix_size` */;
/*!50001 DROP TABLE IF EXISTS `disp_mix_size` */;

/*!50001 CREATE TABLE  `disp_mix_size`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_col_des` mediumtext ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `size_code` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) ,
 `audit_pending` decimal(33,0) ,
 `fca_app` decimal(32,0) ,
 `fca_fail` decimal(32,0) ,
 `fca_audit_pending` decimal(33,0) 
)*/;

/*Table structure for table `disp_mix_size_2` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_mix_size_2`;

/*!50001 DROP VIEW IF EXISTS `disp_mix_size_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_mix_size_2` */;

/*!50001 CREATE TABLE  `disp_mix_size_2`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_col_des` mediumtext ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `size_code` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) ,
 `audit_pending` decimal(33,0) ,
 `fca_app` decimal(32,0) ,
 `fca_fail` decimal(32,0) ,
 `fca_audit_pending` decimal(33,0) 
)*/;

/*Table structure for table `disp_tb1` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_tb1`;

/*!50001 DROP VIEW IF EXISTS `disp_tb1` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb1` */;

/*!50001 CREATE TABLE  `disp_tb1`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `lable_ids` mediumtext ,
 `order_col_des` mediumtext ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) 
)*/;

/*Table structure for table `disp_tb1_2` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_tb1_2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb1_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb1_2` */;

/*!50001 CREATE TABLE  `disp_tb1_2`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `lable_ids` mediumtext ,
 `order_col_des` mediumtext ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) 
)*/;

/*Table structure for table `disp_tb1_size` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_tb1_size`;

/*!50001 DROP VIEW IF EXISTS `disp_tb1_size` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb1_size` */;

/*!50001 CREATE TABLE  `disp_tb1_size`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `size_code` varchar(10) ,
 `order_col_des` mediumtext ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) 
)*/;

/*Table structure for table `disp_tb1_size_2` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_tb1_size_2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb1_size_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb1_size_2` */;

/*!50001 CREATE TABLE  `disp_tb1_size_2`(
 `order_del_no` varchar(60) ,
 `order_style_no` varchar(60) ,
 `size_code` varchar(10) ,
 `order_col_des` mediumtext ,
 `total` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) 
)*/;

/*Table structure for table `disp_tb2` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_tb2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb2` */;

/*!50001 CREATE TABLE  `disp_tb2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `disp_tb2_2` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_tb2_2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb2_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb2_2` */;

/*!50001 CREATE TABLE  `disp_tb2_2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `color` varchar(60) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `disp_tb2_size` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_tb2_size`;

/*!50001 DROP VIEW IF EXISTS `disp_tb2_size` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb2_size` */;

/*!50001 CREATE TABLE  `disp_tb2_size`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `size` varchar(10) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `disp_tb2_size_2` */

DROP TABLE IF EXISTS `bai_pro3`.`disp_tb2_size_2`;

/*!50001 DROP VIEW IF EXISTS `disp_tb2_size_2` */;
/*!50001 DROP TABLE IF EXISTS `disp_tb2_size_2` */;

/*!50001 CREATE TABLE  `disp_tb2_size_2`(
 `style` varchar(50) ,
 `SCHEDULE` int(11) ,
 `size` varchar(10) ,
 `color` varchar(60) ,
 `app` decimal(32,0) ,
 `fail` decimal(32,0) 
)*/;

/*Table structure for table `emb_garment_carton_pendings` */

DROP TABLE IF EXISTS `bai_pro3`.`emb_garment_carton_pendings`;

/*!50001 DROP VIEW IF EXISTS `emb_garment_carton_pendings` */;
/*!50001 DROP TABLE IF EXISTS `emb_garment_carton_pendings` */;

/*!50001 CREATE TABLE  `emb_garment_carton_pendings`(
 `tid` int(11) ,
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `size_code` varchar(10) ,
 `carton_no` smallint(5) unsigned ,
 `carton_mode` char(1) ,
 `carton_act_qty` decimal(29,0) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `input_date` date ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_mod_no` varchar(8) ,
 `ims_log_date` timestamp 
)*/;

/*Table structure for table `fg_wh_report` */

DROP TABLE IF EXISTS `bai_pro3`.`fg_wh_report`;

/*!50001 DROP VIEW IF EXISTS `fg_wh_report` */;
/*!50001 DROP TABLE IF EXISTS `fg_wh_report` */;

/*!50001 CREATE TABLE  `fg_wh_report`(
 `order_del_no` varchar(60) ,
 `total_qty` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `embellish` decimal(29,0) ,
 `shipped` int(1) 
)*/;

/*Table structure for table `fg_wh_report_summary` */

DROP TABLE IF EXISTS `bai_pro3`.`fg_wh_report_summary`;

/*!50001 DROP VIEW IF EXISTS `fg_wh_report_summary` */;
/*!50001 DROP TABLE IF EXISTS `fg_wh_report_summary` */;

/*!50001 CREATE TABLE  `fg_wh_report_summary`(
 `order_del_no` varchar(60) ,
 `total_qty` decimal(29,0) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `embellish` decimal(29,0) ,
 `shipped` int(1) ,
 `order_date` date ,
 `order_po_no` varchar(100) ,
 `color` mediumtext ,
 `order_style_no` varchar(60) 
)*/;

/*Table structure for table `fsp_order_ref` */

DROP TABLE IF EXISTS `bai_pro3`.`fsp_order_ref`;

/*!50001 DROP VIEW IF EXISTS `fsp_order_ref` */;
/*!50001 DROP TABLE IF EXISTS `fsp_order_ref` */;

/*!50001 CREATE TABLE  `fsp_order_ref`(
 `order_del_no` varchar(60) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `color` mediumtext ,
 `order_qty` decimal(65,0) ,
 `trim_cards` varchar(100) ,
 `order_div` varchar(60) ,
 `trim_status` int(11) ,
 `fsp_time_line` varchar(500) 
)*/;

/*Table structure for table `ft_st_pk_shipfast_status` */

DROP TABLE IF EXISTS `bai_pro3`.`ft_st_pk_shipfast_status`;

/*!50001 DROP VIEW IF EXISTS `ft_st_pk_shipfast_status` */;
/*!50001 DROP TABLE IF EXISTS `ft_st_pk_shipfast_status` */;

/*!50001 CREATE TABLE  `ft_st_pk_shipfast_status`(
 `group_code` varchar(20) ,
 `module` varchar(8) ,
 `style` varchar(130) ,
 `order_code` varchar(300) ,
 `color` varchar(200) ,
 `smv` double ,
 `delivery_date` date ,
 `schedule` varchar(300) ,
 `production_date` date ,
 `qty` double ,
 `tid` bigint(20) ,
 `week_code` int(11) ,
 `status` int(11) ,
 `production_start` date ,
 `order_tid` varchar(200) ,
 `order_date` date ,
 `order_upload_date` date ,
 `order_last_mod_date` date ,
 `order_last_upload_date` date ,
 `order_div` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `order_col_code` varchar(100) ,
 `order_s_xs` int(50) ,
 `order_s_s` int(50) ,
 `order_s_m` int(50) ,
 `order_s_l` int(50) ,
 `order_s_xl` int(50) ,
 `order_s_xxl` int(50) ,
 `order_s_xxxl` int(50) ,
 `order_cat_stat` varchar(20) ,
 `order_cut_stat` varchar(20) ,
 `order_ratio_stat` varchar(20) ,
 `order_cad_stat` varchar(20) ,
 `order_stat` varchar(20) ,
 `Order_remarks` varchar(250) ,
 `order_po_no` varchar(100) ,
 `order_no` varchar(100) ,
 `old_order_s_xs` int(11) ,
 `old_order_s_s` int(11) ,
 `old_order_s_m` int(11) ,
 `old_order_s_l` int(11) ,
 `old_order_s_xl` int(11) ,
 `old_order_s_xxl` int(11) ,
 `old_order_s_xxxl` int(11) ,
 `color_code` int(11) ,
 `order_joins` varchar(500) ,
 `order_s_s01` int(11) ,
 `order_s_s02` int(11) ,
 `order_s_s03` int(11) ,
 `order_s_s04` int(11) ,
 `order_s_s05` int(11) ,
 `order_s_s06` int(11) ,
 `order_s_s07` int(11) ,
 `order_s_s08` int(11) ,
 `order_s_s09` int(11) ,
 `order_s_s10` int(11) ,
 `order_s_s11` int(11) ,
 `order_s_s12` int(11) ,
 `order_s_s13` int(11) ,
 `order_s_s14` int(11) ,
 `order_s_s15` int(11) ,
 `order_s_s16` int(11) ,
 `order_s_s17` int(11) ,
 `order_s_s18` int(11) ,
 `order_s_s19` int(11) ,
 `order_s_s20` int(11) ,
 `order_s_s21` int(11) ,
 `order_s_s22` int(11) ,
 `order_s_s23` int(11) ,
 `order_s_s24` int(11) ,
 `order_s_s25` int(11) ,
 `order_s_s26` int(11) ,
 `order_s_s27` int(11) ,
 `order_s_s28` int(11) ,
 `order_s_s29` int(11) ,
 `order_s_s30` int(11) ,
 `order_s_s31` int(11) ,
 `order_s_s32` int(11) ,
 `order_s_s33` int(11) ,
 `order_s_s34` int(11) ,
 `order_s_s35` int(11) ,
 `order_s_s36` int(11) ,
 `order_s_s37` int(11) ,
 `order_s_s38` int(11) ,
 `order_s_s39` int(11) ,
 `order_s_s40` int(11) ,
 `order_s_s41` int(11) ,
 `order_s_s42` int(11) ,
 `order_s_s43` int(11) ,
 `order_s_s44` int(11) ,
 `order_s_s45` int(11) ,
 `order_s_s46` int(11) ,
 `order_s_s47` int(11) ,
 `order_s_s48` int(11) ,
 `order_s_s49` int(11) ,
 `order_s_s50` int(11) ,
 `old_order_s_s01` int(11) ,
 `old_order_s_s02` int(11) ,
 `old_order_s_s03` int(11) ,
 `old_order_s_s04` int(11) ,
 `old_order_s_s05` int(11) ,
 `old_order_s_s06` int(11) ,
 `old_order_s_s07` int(11) ,
 `old_order_s_s08` int(11) ,
 `old_order_s_s09` int(11) ,
 `old_order_s_s10` int(11) ,
 `old_order_s_s11` int(11) ,
 `old_order_s_s12` int(11) ,
 `old_order_s_s13` int(11) ,
 `old_order_s_s14` int(11) ,
 `old_order_s_s15` int(11) ,
 `old_order_s_s16` int(11) ,
 `old_order_s_s17` int(11) ,
 `old_order_s_s18` int(11) ,
 `old_order_s_s19` int(11) ,
 `old_order_s_s20` int(11) ,
 `old_order_s_s21` int(11) ,
 `old_order_s_s22` int(11) ,
 `old_order_s_s23` int(11) ,
 `old_order_s_s24` int(11) ,
 `old_order_s_s25` int(11) ,
 `old_order_s_s26` int(11) ,
 `old_order_s_s27` int(11) ,
 `old_order_s_s28` int(11) ,
 `old_order_s_s29` int(11) ,
 `old_order_s_s30` int(11) ,
 `old_order_s_s31` int(11) ,
 `old_order_s_s32` int(11) ,
 `old_order_s_s33` int(11) ,
 `old_order_s_s34` int(11) ,
 `old_order_s_s35` int(11) ,
 `old_order_s_s36` int(11) ,
 `old_order_s_s37` int(11) ,
 `old_order_s_s38` int(11) ,
 `old_order_s_s39` int(11) ,
 `old_order_s_s40` int(11) ,
 `old_order_s_s41` int(11) ,
 `old_order_s_s42` int(11) ,
 `old_order_s_s43` int(11) ,
 `old_order_s_s44` int(11) ,
 `old_order_s_s45` int(11) ,
 `old_order_s_s46` int(11) ,
 `old_order_s_s47` int(11) ,
 `old_order_s_s48` int(11) ,
 `old_order_s_s49` int(11) ,
 `old_order_s_s50` int(11) ,
 `packing_method` varchar(12) ,
 `style_id` varchar(20) ,
 `carton_id` int(11) ,
 `carton_print_status` int(11) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) 
)*/;

/*Table structure for table `ims_combine` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_combine`;

/*!50001 DROP VIEW IF EXISTS `ims_combine` */;
/*!50001 DROP TABLE IF EXISTS `ims_combine` */;

/*!50001 CREATE TABLE  `ims_combine`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` int(11) ,
 `ims_pro_qty` int(11) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` varchar(40) ,
 `rand_track` bigint(20) ,
 `input_job_rand_no_ref` varchar(255) ,
 `input_job_no_ref` int(20) ,
 `pac_tid` int(11) 
)*/;

/*Table structure for table `ims_log_backup_t1` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_backup_t1`;

/*!50001 DROP VIEW IF EXISTS `ims_log_backup_t1` */;
/*!50001 DROP TABLE IF EXISTS `ims_log_backup_t1` */;

/*!50001 CREATE TABLE  `ims_log_backup_t1`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` decimal(32,0) ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` varchar(40) ,
 `rand_track` bigint(20) 
)*/;

/*Table structure for table `ims_log_backup_t2` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_backup_t2`;

/*!50001 DROP VIEW IF EXISTS `ims_log_backup_t2` */;
/*!50001 DROP TABLE IF EXISTS `ims_log_backup_t2` */;

/*!50001 CREATE TABLE  `ims_log_backup_t2`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` decimal(32,0) ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` int(11) ,
 `rand_track` bigint(20) 
)*/;

/*Table structure for table `ims_log_live` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_live`;

/*!50001 DROP VIEW IF EXISTS `ims_log_live` */;
/*!50001 DROP TABLE IF EXISTS `ims_log_live` */;

/*!50001 CREATE TABLE  `ims_log_live`(
 `id` int(11) ,
 `date_time` timestamp ,
 `style` varchar(255) ,
 `schedule` varchar(255) ,
 `color` varchar(255) ,
 `size_title` varchar(11) ,
 `bundle_number` int(11) ,
 `original_qty` int(11) ,
 `send_qty` int(11) ,
 `recevied_qty` int(11) ,
 `missing_qty` int(11) ,
 `rejected_qty` int(11) ,
 `left_over` int(11) ,
 `docket_number` int(11) ,
 `assigned_module` varchar(10) ,
 `operation_id` int(11) ,
 `shift` varchar(11) ,
 `cut_number` int(11) ,
 `input_job_no` int(11) ,
 `input_job_no_random_ref` varchar(25) 
)*/;

/*Table structure for table `ims_log_long_pending_transfers` */

DROP TABLE IF EXISTS `bai_pro3`.`ims_log_long_pending_transfers`;

/*!50001 DROP VIEW IF EXISTS `ims_log_long_pending_transfers` */;
/*!50001 DROP TABLE IF EXISTS `ims_log_long_pending_transfers` */;

/*!50001 CREATE TABLE  `ims_log_long_pending_transfers`(
 `ims_date` date ,
 `tid` varchar(40) ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` int(11) ,
 `ims_pro_qty` int(11) ,
 `ims_log_date` timestamp ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) 
)*/;

/*Table structure for table `incentive_emb_reference` */

DROP TABLE IF EXISTS `bai_pro3`.`incentive_emb_reference`;

/*!50001 DROP VIEW IF EXISTS `incentive_emb_reference` */;
/*!50001 DROP TABLE IF EXISTS `incentive_emb_reference` */;

/*!50001 CREATE TABLE  `incentive_emb_reference`(
 `order_del_no` varchar(60) ,
 `emb_stat` int(1) 
)*/;

/*Table structure for table `incentive_fca_audit_fail_sch` */

DROP TABLE IF EXISTS `bai_pro3`.`incentive_fca_audit_fail_sch`;

/*!50001 DROP VIEW IF EXISTS `incentive_fca_audit_fail_sch` */;
/*!50001 DROP TABLE IF EXISTS `incentive_fca_audit_fail_sch` */;

/*!50001 CREATE TABLE  `incentive_fca_audit_fail_sch`(
 `schedule` int(11) ,
 `remarks` mediumtext 
)*/;

/*Table structure for table `live_pro_table_ref` */

DROP TABLE IF EXISTS `bai_pro3`.`live_pro_table_ref`;

/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref` */;
/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref` */;

/*!50001 CREATE TABLE  `live_pro_table_ref`(
 `color_code` int(11) ,
 `acutno` int(11) ,
 `doc_no` int(11) ,
 `a_plies` int(11) 
)*/;

/*Table structure for table `live_pro_table_ref2` */

DROP TABLE IF EXISTS `bai_pro3`.`live_pro_table_ref2`;

/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref2` */;
/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref2` */;

/*!50001 CREATE TABLE  `live_pro_table_ref2`(
 `color_code` int(11) ,
 `acutno` int(11) ,
 `doc_no` int(11) ,
 `a_plies` int(11) 
)*/;

/*Table structure for table `live_pro_table_ref3` */

DROP TABLE IF EXISTS `bai_pro3`.`live_pro_table_ref3`;

/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref3` */;
/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref3` */;

/*!50001 CREATE TABLE  `live_pro_table_ref3`(
 `color_code` int(11) ,
 `acutno` int(11) ,
 `doc_no` int(11) ,
 `a_plies` int(11) 
)*/;

/*Table structure for table `marker_ref_matrix_view` */

DROP TABLE IF EXISTS `bai_pro3`.`marker_ref_matrix_view`;

/*!50001 DROP VIEW IF EXISTS `marker_ref_matrix_view` */;
/*!50001 DROP TABLE IF EXISTS `marker_ref_matrix_view` */;

/*!50001 CREATE TABLE  `marker_ref_matrix_view`(
 `category` varchar(50) ,
 `strip_match` varchar(10) ,
 `gmtway` varchar(100) ,
 `marker_ref_tid` varchar(20) ,
 `marker_width` varchar(5) ,
 `marker_length` varchar(10) ,
 `marker_ref` int(11) ,
 `cat_ref` int(11) ,
 `allocate_ref` int(11) ,
 `style_code` varchar(10) ,
 `buyer_code` varchar(3) ,
 `pat_ver` varchar(15) ,
 `xs` int(11) ,
 `s` int(11) ,
 `m` int(11) ,
 `l` int(11) ,
 `xl` int(11) ,
 `xxl` int(11) ,
 `xxxl` int(11) ,
 `s01` int(11) ,
 `s02` int(11) ,
 `s03` int(11) ,
 `s04` int(11) ,
 `s05` int(11) ,
 `s06` int(11) ,
 `s07` int(11) ,
 `s08` int(11) ,
 `s09` int(11) ,
 `s10` int(11) ,
 `s11` int(11) ,
 `s12` int(11) ,
 `s13` int(11) ,
 `s14` int(11) ,
 `s15` int(11) ,
 `s16` int(11) ,
 `s17` int(11) ,
 `s18` int(11) ,
 `s19` int(11) ,
 `s20` int(11) ,
 `s21` int(11) ,
 `s22` int(11) ,
 `s23` int(11) ,
 `s24` int(11) ,
 `s25` int(11) ,
 `s26` int(11) ,
 `s27` int(11) ,
 `s28` int(11) ,
 `s29` int(11) ,
 `s30` int(11) ,
 `s31` int(11) ,
 `s32` int(11) ,
 `s33` int(11) ,
 `s34` int(11) ,
 `s35` int(11) ,
 `s36` int(11) ,
 `s37` int(11) ,
 `s38` int(11) ,
 `s39` int(11) ,
 `s40` int(11) ,
 `s41` int(11) ,
 `s42` int(11) ,
 `s43` int(11) ,
 `s44` int(11) ,
 `s45` int(11) ,
 `s46` int(11) ,
 `s47` int(11) ,
 `s48` int(11) ,
 `s49` int(11) ,
 `s50` int(11) ,
 `lastup` timestamp ,
 `title_size_s01` varchar(20) ,
 `title_size_s02` varchar(20) ,
 `title_size_s03` varchar(20) ,
 `title_size_s04` varchar(20) ,
 `title_size_s05` varchar(20) ,
 `title_size_s06` varchar(20) ,
 `title_size_s07` varchar(20) ,
 `title_size_s08` varchar(20) ,
 `title_size_s09` varchar(20) ,
 `title_size_s10` varchar(20) ,
 `title_size_s11` varchar(20) ,
 `title_size_s12` varchar(20) ,
 `title_size_s13` varchar(20) ,
 `title_size_s14` varchar(20) ,
 `title_size_s15` varchar(20) ,
 `title_size_s16` varchar(20) ,
 `title_size_s17` varchar(20) ,
 `title_size_s18` varchar(20) ,
 `title_size_s19` varchar(20) ,
 `title_size_s20` varchar(20) ,
 `title_size_s21` varchar(20) ,
 `title_size_s22` varchar(20) ,
 `title_size_s23` varchar(20) ,
 `title_size_s24` varchar(20) ,
 `title_size_s25` varchar(20) ,
 `title_size_s26` varchar(20) ,
 `title_size_s27` varchar(20) ,
 `title_size_s28` varchar(20) ,
 `title_size_s29` varchar(20) ,
 `title_size_s30` varchar(20) ,
 `title_size_s31` varchar(20) ,
 `title_size_s32` varchar(20) ,
 `title_size_s33` varchar(20) ,
 `title_size_s34` varchar(20) ,
 `title_size_s35` varchar(20) ,
 `title_size_s36` varchar(20) ,
 `title_size_s37` varchar(20) ,
 `title_size_s38` varchar(20) ,
 `title_size_s39` varchar(20) ,
 `title_size_s40` varchar(20) ,
 `title_size_s41` varchar(20) ,
 `title_size_s42` varchar(20) ,
 `title_size_s43` varchar(20) ,
 `title_size_s44` varchar(20) ,
 `title_size_s45` varchar(20) ,
 `title_size_s46` varchar(20) ,
 `title_size_s47` varchar(20) ,
 `title_size_s48` varchar(20) ,
 `title_size_s49` varchar(20) ,
 `title_size_s50` varchar(20) ,
 `title_flag` int(11) ,
 `remarks` varchar(500) 
)*/;

/*Table structure for table `order_cat_doc_mix` */

DROP TABLE IF EXISTS `bai_pro3`.`order_cat_doc_mix`;

/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mix` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mix` */;

/*!50001 CREATE TABLE  `order_cat_doc_mix`(
 `catyy` double ,
 `style_id` varchar(20) ,
 `order_style_no` varchar(60) ,
 `cat_patt_ver` varchar(10) ,
 `strip_match` varchar(10) ,
 `col_des` varchar(200) ,
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
 `fab_des` varchar(200) ,
 `gmtway` varchar(100) ,
 `compo_no` varchar(200) ,
 `purwidth` float ,
 `color_code` int(11) ,
 `clubbing` smallint(6) ,
 `fabric_status` smallint(6) ,
 `plan_lot_ref` text ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) 
)*/;

/*Table structure for table `order_cat_doc_mk_mix` */

DROP TABLE IF EXISTS `bai_pro3`.`order_cat_doc_mk_mix`;

/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mk_mix` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mk_mix` */;

/*!50001 CREATE TABLE  `order_cat_doc_mk_mix`(
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
 `order_col_des` varchar(150) ,
 `plan_lot_ref` text 
)*/;

/*Table structure for table `order_cat_doc_mk_mix_v2` */

DROP TABLE IF EXISTS `bai_pro3`.`order_cat_doc_mk_mix_v2`;

/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mk_mix_v2` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mk_mix_v2` */;

/*!50001 CREATE TABLE  `order_cat_doc_mk_mix_v2`(
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
 `order_col_des` varchar(150) ,
 `plan_lot_ref` text 
)*/;

/*Table structure for table `order_cat_recut_doc_mix` */

DROP TABLE IF EXISTS `bai_pro3`.`order_cat_recut_doc_mix`;

/*!50001 DROP VIEW IF EXISTS `order_cat_recut_doc_mix` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_recut_doc_mix` */;

/*!50001 CREATE TABLE  `order_cat_recut_doc_mix`(
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
 `plan_module` varchar(5) ,
 `category` varchar(50) ,
 `color_code` int(11) ,
 `fabric_status` smallint(6) ,
 `order_del_no` varchar(60) ,
 `plan_lot_ref` text ,
 `order_col_des` varchar(150) ,
 `order_style_no` varchar(60) 
)*/;

/*Table structure for table `order_cat_recut_doc_mk_mix` */

DROP TABLE IF EXISTS `bai_pro3`.`order_cat_recut_doc_mk_mix`;

/*!50001 DROP VIEW IF EXISTS `order_cat_recut_doc_mk_mix` */;
/*!50001 DROP TABLE IF EXISTS `order_cat_recut_doc_mk_mix` */;

/*!50001 CREATE TABLE  `order_cat_recut_doc_mk_mix`(
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
 `plan_module` varchar(5) ,
 `category` varchar(50) ,
 `color_code` int(11) ,
 `fabric_status` smallint(6) ,
 `material_req` double(21,4) ,
 `order_del_no` varchar(60) ,
 `plan_lot_ref` text 
)*/;

/*Table structure for table `packing_dashboard` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_dashboard`;

/*!50001 DROP VIEW IF EXISTS `packing_dashboard` */;
/*!50001 DROP TABLE IF EXISTS `packing_dashboard` */;

/*!50001 CREATE TABLE  `packing_dashboard`(
 `tid` int(11) ,
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `size_code` varchar(10) ,
 `carton_no` smallint(5) unsigned ,
 `carton_mode` char(1) ,
 `carton_act_qty` decimal(29,0) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `input_date` date ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_mod_no` varchar(8) ,
 `ims_log_date` timestamp 
)*/;

/*Table structure for table `packing_dashboard_new` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_dashboard_new`;

/*!50001 DROP VIEW IF EXISTS `packing_dashboard_new` */;
/*!50001 DROP TABLE IF EXISTS `packing_dashboard_new` */;

/*!50001 CREATE TABLE  `packing_dashboard_new`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` int(11) ,
 `ims_pro_qty` int(11) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` varchar(40) ,
 `rand_track` bigint(20) ,
 `ims_pro_qty_cumm` decimal(32,0) 
)*/;

/*Table structure for table `packing_dashboard_new2` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_dashboard_new2`;

/*!50001 DROP VIEW IF EXISTS `packing_dashboard_new2` */;
/*!50001 DROP TABLE IF EXISTS `packing_dashboard_new2` */;

/*!50001 CREATE TABLE  `packing_dashboard_new2`(
 `ims_date` date ,
 `ims_cid` int(11) ,
 `ims_doc_no` int(11) ,
 `ims_mod_no` varchar(8) ,
 `ims_shift` varchar(10) ,
 `ims_size` varchar(10) ,
 `ims_qty` decimal(32,0) ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_status` varchar(10) ,
 `bai_pro_ref` varchar(500) ,
 `ims_log_date` timestamp ,
 `ims_remarks` varchar(200) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `tid` varchar(40) ,
 `rand_track` bigint(20) ,
 `ims_pro_qty_cumm` decimal(32,0) 
)*/;

/*Table structure for table `packing_dboard_stage1` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_dboard_stage1`;

/*!50001 DROP VIEW IF EXISTS `packing_dboard_stage1` */;
/*!50001 DROP TABLE IF EXISTS `packing_dboard_stage1` */;

/*!50001 CREATE TABLE  `packing_dboard_stage1`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `tid` int(11) ,
 `size_code` varchar(10) ,
 `remarks` varchar(200) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `container` smallint(7) unsigned ,
 `disp_carton_no` tinyint(2) unsigned ,
 `disp_id` tinyint(2) unsigned ,
 `carton_act_qty` smallint(7) unsigned ,
 `audit_status` char(7) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `new` decimal(7,0) 
)*/;

/*Table structure for table `packing_issues` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_issues`;

/*!50001 DROP VIEW IF EXISTS `packing_issues` */;
/*!50001 DROP TABLE IF EXISTS `packing_issues` */;

/*!50001 CREATE TABLE  `packing_issues`(
 `tid` int(11) ,
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `size_code` varchar(10) ,
 `carton_no` smallint(5) unsigned ,
 `carton_mode` char(1) ,
 `carton_act_qty` decimal(52,0) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `remarks` varchar(200) ,
 `disp_id` tinyint(2) unsigned ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `input_date` date ,
 `ims_pro_qty` decimal(32,0) ,
 `ims_mod_no` varchar(8) ,
 `ims_log_date` timestamp 
)*/;

/*Table structure for table `packing_pending_schedules` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_pending_schedules`;

/*!50001 DROP VIEW IF EXISTS `packing_pending_schedules` */;
/*!50001 DROP TABLE IF EXISTS `packing_pending_schedules` */;

/*!50001 CREATE TABLE  `packing_pending_schedules`(
 `order_del_no` varchar(60) 
)*/;

/*Table structure for table `packing_summary` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary`;

/*!50001 DROP VIEW IF EXISTS `packing_summary` */;
/*!50001 DROP TABLE IF EXISTS `packing_summary` */;

/*!50001 CREATE TABLE  `packing_summary`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `tid` int(11) ,
 `size_code` varchar(10) ,
 `remarks` varchar(200) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `container` smallint(7) unsigned ,
 `disp_carton_no` tinyint(2) unsigned ,
 `disp_id` tinyint(2) unsigned ,
 `carton_act_qty` smallint(7) unsigned ,
 `audit_status` char(7) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `acutno` int(11) 
)*/;

/*Table structure for table `packing_summary_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary_backup`;

/*!50001 DROP VIEW IF EXISTS `packing_summary_backup` */;
/*!50001 DROP TABLE IF EXISTS `packing_summary_backup` */;

/*!50001 CREATE TABLE  `packing_summary_backup`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(300) ,
 `tid` int(11) ,
 `size_code` varchar(20) ,
 `remarks` varchar(200) ,
 `status` varchar(20) ,
 `lastup` timestamp ,
 `container` int(11) ,
 `disp_carton_no` int(11) ,
 `disp_id` int(11) ,
 `carton_act_qty` int(50) ,
 `audit_status` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `acutno` int(11) 
)*/;

/*Table structure for table `packing_summary_input` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary_input`;

/*!50001 DROP VIEW IF EXISTS `packing_summary_input` */;
/*!50001 DROP TABLE IF EXISTS `packing_summary_input` */;

/*!50001 CREATE TABLE  `packing_summary_input`(
 `order_joins` varchar(500) ,
 `doc_no` double ,
 `input_job_no` varchar(255) ,
 `input_job_no_random` varchar(90) ,
 `doc_no_ref` varchar(900) ,
 `tid` double ,
 `size_code` varchar(30) ,
 `status` varchar(24) ,
 `carton_act_qty` int(11) ,
 `packing_mode` int(11) unsigned ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `acutno` int(11) ,
 `destination` varchar(10) ,
 `cat_ref` int(11) ,
 `m3_size_code` varchar(30) ,
 `old_size` varchar(10) ,
 `type_of_sewing` int(3) 
)*/;

/*Table structure for table `packing_summary_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`packing_summary_temp`;

/*!50001 DROP VIEW IF EXISTS `packing_summary_temp` */;
/*!50001 DROP TABLE IF EXISTS `packing_summary_temp` */;

/*!50001 CREATE TABLE  `packing_summary_temp`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `tid` int(11) ,
 `size_code` varchar(10) ,
 `remarks` varchar(200) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `container` smallint(7) unsigned ,
 `disp_carton_no` tinyint(2) unsigned ,
 `disp_id` tinyint(2) unsigned ,
 `carton_act_qty` smallint(7) unsigned ,
 `audit_status` char(7) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) 
)*/;

/*Table structure for table `pack_to_be_backup` */

DROP TABLE IF EXISTS `bai_pro3`.`pack_to_be_backup`;

/*!50001 DROP VIEW IF EXISTS `pack_to_be_backup` */;
/*!50001 DROP TABLE IF EXISTS `pack_to_be_backup` */;

/*!50001 CREATE TABLE  `pack_to_be_backup`(
 `total` decimal(29,0) ,
 `order_del_no` varchar(60) ,
 `scanned` decimal(29,0) ,
 `unscanned` decimal(29,0) ,
 `lable_ids` mediumtext ,
 `create_date` date ,
 `ship_qty` bigint(67) 
)*/;

/*Table structure for table `pac_stat_log_for_live` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_for_live`;

/*!50001 DROP VIEW IF EXISTS `pac_stat_log_for_live` */;
/*!50001 DROP TABLE IF EXISTS `pac_stat_log_for_live` */;

/*!50001 CREATE TABLE  `pac_stat_log_for_live`(
 `doc_no` bigint(20) ,
 `doc_no_ref` varchar(1000) ,
 `tid` int(11) ,
 `size_code` varchar(10) ,
 `remarks` varchar(200) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `container` smallint(7) unsigned ,
 `disp_carton_no` tinyint(2) unsigned ,
 `disp_id` tinyint(2) unsigned ,
 `carton_act_qty` decimal(29,0) ,
 `audit_status` char(7) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) 
)*/;

/*Table structure for table `pac_stat_log_temp` */

DROP TABLE IF EXISTS `bai_pro3`.`pac_stat_log_temp`;

/*!50001 DROP VIEW IF EXISTS `pac_stat_log_temp` */;
/*!50001 DROP TABLE IF EXISTS `pac_stat_log_temp` */;

/*!50001 CREATE TABLE  `pac_stat_log_temp`(
 `tid` int(11) ,
 `doc_no` bigint(20) ,
 `size_code` varchar(10) ,
 `carton_no` smallint(5) unsigned ,
 `carton_mode` char(1) ,
 `carton_act_qty` decimal(29,0) ,
 `status` char(8) ,
 `lastup` timestamp ,
 `remarks` varchar(200) ,
 `disp_id` tinyint(2) unsigned ,
 `doc_no_ref` varchar(1000) ,
 `disp_carton_no` tinyint(2) unsigned 
)*/;

/*Table structure for table `plandoc_stat_log_cat_log_ref` */

DROP TABLE IF EXISTS `bai_pro3`.`plandoc_stat_log_cat_log_ref`;

/*!50001 DROP VIEW IF EXISTS `plandoc_stat_log_cat_log_ref` */;
/*!50001 DROP TABLE IF EXISTS `plandoc_stat_log_cat_log_ref` */;

/*!50001 CREATE TABLE  `plandoc_stat_log_cat_log_ref`(
 `order_tid` varchar(200) ,
 `fabric_status_new` smallint(6) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `log_update` timestamp ,
 `color_code` int(11) ,
 `order_div` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `plan_module` varchar(8) ,
 `cat_ref` int(11) ,
 `doc_total` bigint(66) 
)*/;

/*Table structure for table `plan_dash_doc_summ` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dash_doc_summ`;

/*!50001 DROP VIEW IF EXISTS `plan_dash_doc_summ` */;
/*!50001 DROP TABLE IF EXISTS `plan_dash_doc_summ` */;

/*!50001 CREATE TABLE  `plan_dash_doc_summ`(
 `print_status` date ,
 `plan_lot_ref` text ,
 `bundle_location` varchar(200) ,
 `fabric_status_new` smallint(6) ,
 `doc_no` int(11) ,
 `module` varchar(8) ,
 `priority` int(11) ,
 `act_cut_issue_status` varchar(50) ,
 `act_cut_status` varchar(50) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `order_tid` varchar(200) ,
 `fabric_status` int(11) ,
 `color_code` int(11) ,
 `clubbing` smallint(6) ,
 `order_style_no` varchar(60) ,
 `order_div` varchar(60) ,
 `order_col_des` varchar(150) ,
 `acutno` int(11) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `xs` bigint(21) ,
 `s` bigint(21) ,
 `m` bigint(21) ,
 `l` bigint(21) ,
 `xl` bigint(21) ,
 `xxl` bigint(21) ,
 `xxxl` bigint(21) ,
 `s01` bigint(21) ,
 `s02` bigint(21) ,
 `s03` bigint(21) ,
 `s04` bigint(21) ,
 `s05` bigint(21) ,
 `s06` bigint(21) ,
 `s07` bigint(21) ,
 `s08` bigint(21) ,
 `s09` bigint(21) ,
 `s10` bigint(21) ,
 `s11` bigint(21) ,
 `s12` bigint(21) ,
 `s13` bigint(21) ,
 `s14` bigint(21) ,
 `s15` bigint(21) ,
 `s16` bigint(21) ,
 `s17` bigint(21) ,
 `s18` bigint(21) ,
 `s19` bigint(21) ,
 `s20` bigint(21) ,
 `s21` bigint(21) ,
 `s22` bigint(21) ,
 `s23` bigint(21) ,
 `s24` bigint(21) ,
 `s25` bigint(21) ,
 `s26` bigint(21) ,
 `s27` bigint(21) ,
 `s28` bigint(21) ,
 `s29` bigint(21) ,
 `s30` bigint(21) ,
 `s31` bigint(21) ,
 `s32` bigint(21) ,
 `s33` bigint(21) ,
 `s34` bigint(21) ,
 `s35` bigint(21) ,
 `s36` bigint(21) ,
 `s37` bigint(21) ,
 `s38` bigint(21) ,
 `s39` bigint(21) ,
 `s40` bigint(21) ,
 `s41` bigint(21) ,
 `s42` bigint(21) ,
 `s43` bigint(21) ,
 `s44` bigint(21) ,
 `s45` bigint(21) ,
 `s46` bigint(21) ,
 `s47` bigint(21) ,
 `s48` bigint(21) ,
 `s49` bigint(21) ,
 `s50` bigint(21) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `mk_ref` int(11) ,
 `total` bigint(67) ,
 `act_movement_status` varchar(25) ,
 `order_del_no` varchar(60) ,
 `log_time` datetime ,
 `emb_stat` int(2) ,
 `cat_ref` int(11) 
)*/;

/*Table structure for table `plan_dash_doc_summ_input` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dash_doc_summ_input`;

/*!50001 DROP VIEW IF EXISTS `plan_dash_doc_summ_input` */;
/*!50001 DROP TABLE IF EXISTS `plan_dash_doc_summ_input` */;

/*!50001 CREATE TABLE  `plan_dash_doc_summ_input`(
 `input_job_no_random_ref` varchar(30) ,
 `input_module` varchar(10) ,
 `input_priority` int(11) ,
 `input_trims_status` int(11) ,
 `input_panel_status` int(11) ,
 `log_time` timestamp ,
 `track_id` int(11) ,
 `input_job_no` varchar(255) ,
 `tid` double ,
 `input_job_no_random` varchar(90) ,
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `order_div` varchar(60) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(2) ,
 `carton_act_qty` decimal(32,0) 
)*/;

/*Table structure for table `plan_dash_summ` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_dash_summ`;

/*!50001 DROP VIEW IF EXISTS `plan_dash_summ` */;
/*!50001 DROP TABLE IF EXISTS `plan_dash_summ` */;

/*!50001 CREATE TABLE  `plan_dash_summ`(
 `doc_no` int(11) ,
 `module` varchar(8) ,
 `priority` int(11) ,
 `fabric_status` int(11) ,
 `act_cut_issue_status` varchar(50) ,
 `plan_lot_ref` text ,
 `bundle_location` varchar(200) ,
 `print_status` date ,
 `act_cut_status` varchar(50) ,
 `rm_date` datetime ,
 `cut_inp_temp` int(11) ,
 `xs` bigint(21) ,
 `s` bigint(21) ,
 `m` bigint(21) ,
 `l` bigint(21) ,
 `xl` bigint(21) ,
 `xxl` bigint(21) ,
 `xxxl` bigint(21) ,
 `s01` bigint(21) ,
 `s02` bigint(21) ,
 `s03` bigint(21) ,
 `s04` bigint(21) ,
 `s05` bigint(21) ,
 `s06` bigint(21) ,
 `s07` bigint(21) ,
 `s08` bigint(21) ,
 `s09` bigint(21) ,
 `s10` bigint(21) ,
 `s11` bigint(21) ,
 `s12` bigint(21) ,
 `s13` bigint(21) ,
 `s14` bigint(21) ,
 `s15` bigint(21) ,
 `s16` bigint(21) ,
 `s17` bigint(21) ,
 `s18` bigint(21) ,
 `s19` bigint(21) ,
 `s20` bigint(21) ,
 `s21` bigint(21) ,
 `s22` bigint(21) ,
 `s23` bigint(21) ,
 `s24` bigint(21) ,
 `s25` bigint(21) ,
 `s26` bigint(21) ,
 `s27` bigint(21) ,
 `s28` bigint(21) ,
 `s29` bigint(21) ,
 `s30` bigint(21) ,
 `s31` bigint(21) ,
 `s32` bigint(21) ,
 `s33` bigint(21) ,
 `s34` bigint(21) ,
 `s35` bigint(21) ,
 `s36` bigint(21) ,
 `s37` bigint(21) ,
 `s38` bigint(21) ,
 `s39` bigint(21) ,
 `s40` bigint(21) ,
 `s41` bigint(21) ,
 `s42` bigint(21) ,
 `s43` bigint(21) ,
 `s44` bigint(21) ,
 `s45` bigint(21) ,
 `s46` bigint(21) ,
 `s47` bigint(21) ,
 `s48` bigint(21) ,
 `s49` bigint(21) ,
 `s50` bigint(21) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `mk_ref` int(11) ,
 `order_tid` varchar(200) ,
 `fabric_status_new` smallint(6) ,
 `log_time` datetime 
)*/;

/*Table structure for table `plan_doc_summ` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_doc_summ`;

/*!50001 DROP VIEW IF EXISTS `plan_doc_summ` */;
/*!50001 DROP TABLE IF EXISTS `plan_doc_summ` */;

/*!50001 CREATE TABLE  `plan_doc_summ`(
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `color_code` int(11) ,
 `order_div` varchar(60) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `act_movement_status` varchar(25) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(2) 
)*/;

/*Table structure for table `plan_doc_summ_input` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_doc_summ_input`;

/*!50001 DROP VIEW IF EXISTS `plan_doc_summ_input` */;
/*!50001 DROP TABLE IF EXISTS `plan_doc_summ_input` */;

/*!50001 CREATE TABLE  `plan_doc_summ_input`(
 `input_job_no` varchar(255) ,
 `tid` double ,
 `input_job_no_random` varchar(90) ,
 `size_code` varchar(30) ,
 `type_of_sewing` int(3) ,
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `order_div` varchar(60) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(2) ,
 `carton_act_qty` decimal(32,0) 
)*/;

/*Table structure for table `plan_doc_summ_in_ref` */

DROP TABLE IF EXISTS `bai_pro3`.`plan_doc_summ_in_ref`;

/*!50001 DROP VIEW IF EXISTS `plan_doc_summ_in_ref` */;
/*!50001 DROP TABLE IF EXISTS `plan_doc_summ_in_ref` */;

/*!50001 CREATE TABLE  `plan_doc_summ_in_ref`(
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `act_cut_issue_status` varchar(50) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `order_div` varchar(60) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(2) 
)*/;

/*Table structure for table `qms_vs_recut` */

DROP TABLE IF EXISTS `bai_pro3`.`qms_vs_recut`;

/*!50001 DROP VIEW IF EXISTS `qms_vs_recut` */;
/*!50001 DROP TABLE IF EXISTS `qms_vs_recut` */;

/*!50001 CREATE TABLE  `qms_vs_recut`(
 `qms_tid` int(11) ,
 `log_date` date ,
 `qms_style` varchar(30) ,
 `qms_schedule` varchar(20) ,
 `qms_color` varchar(150) ,
 `raised` decimal(27,0) ,
 `actual` decimal(27,0) ,
 `ref1` varchar(500) ,
 `qms_size` varchar(5) ,
 `module` text ,
 `doc_no` text ,
 `act_cut_status` varchar(50) ,
 `plan_module` varchar(5) ,
 `fabric_status` smallint(6) 
)*/;

/*Table structure for table `recut_v2_summary` */

DROP TABLE IF EXISTS `bai_pro3`.`recut_v2_summary`;

/*!50001 DROP VIEW IF EXISTS `recut_v2_summary` */;
/*!50001 DROP TABLE IF EXISTS `recut_v2_summary` */;

/*!50001 CREATE TABLE  `recut_v2_summary`(
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
 `plan_module` varchar(5) ,
 `fabric_status` smallint(6) ,
 `plan_lot_ref` text ,
 `actual_cut_qty` bigint(66) ,
 `actual_req_qty` bigint(67) 
)*/;

/*Table structure for table `test_plan_doc_summ` */

DROP TABLE IF EXISTS `bai_pro3`.`test_plan_doc_summ`;

/*!50001 DROP VIEW IF EXISTS `test_plan_doc_summ` */;
/*!50001 DROP TABLE IF EXISTS `test_plan_doc_summ` */;

/*!50001 CREATE TABLE  `test_plan_doc_summ`(
 `order_tid` varchar(200) ,
 `doc_no` int(11) ,
 `acutno` int(11) ,
 `act_cut_status` varchar(50) ,
 `act_cut_issue_status` varchar(50) ,
 `a_plies` int(11) ,
 `p_plies` int(11) ,
 `color_code` int(11) ,
 `order_style_no` varchar(60) ,
 `order_del_no` varchar(60) ,
 `order_col_des` varchar(150) ,
 `ft_status` int(11) ,
 `st_status` int(11) ,
 `pt_status` int(11) ,
 `trim_status` int(11) ,
 `category` varchar(50) ,
 `clubbing` smallint(6) ,
 `plan_module` varchar(8) ,
 `act_movement_status` varchar(25) ,
 `cat_ref` int(11) ,
 `emb_stat1` int(2) 
)*/;

/*Table structure for table `zero_module_trans` */

DROP TABLE IF EXISTS `bai_pro3`.`zero_module_trans`;

/*!50001 DROP VIEW IF EXISTS `zero_module_trans` */;
/*!50001 DROP TABLE IF EXISTS `zero_module_trans` */;

/*!50001 CREATE TABLE  `zero_module_trans`(
 `ims_qty` decimal(32,0) ,
 `ims_style` varchar(100) ,
 `ims_schedule` varchar(50) ,
 `ims_color` varchar(300) ,
 `size` varchar(10) 
)*/;

/*View structure for view audit_disp_tb2 */

/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2` */;
/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,sum(if(`fca_audit_fail_db`.`tran_type` = 1,`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`fca_audit_fail_db`.`tran_type` = 2,`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`) */;

/*View structure for view audit_disp_tb2_2 */

/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_2` */;
/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`color` AS `color`,sum(if(`fca_audit_fail_db`.`tran_type` = 1,`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`fca_audit_fail_db`.`tran_type` = 2,`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`color`) */;

/*View structure for view audit_disp_tb2_size */

/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_size` */;
/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_size` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_size` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`size` AS `size`,sum(if(`fca_audit_fail_db`.`tran_type` = 1,`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`fca_audit_fail_db`.`tran_type` = 2,`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`size`) */;

/*View structure for view audit_disp_tb2_size_2 */

/*!50001 DROP TABLE IF EXISTS `audit_disp_tb2_size_2` */;
/*!50001 DROP VIEW IF EXISTS `audit_disp_tb2_size_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_size_2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`color` AS `color`,`fca_audit_fail_db`.`size` AS `size`,sum(if(`fca_audit_fail_db`.`tran_type` = 1,`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`fca_audit_fail_db`.`tran_type` = 2,`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`color`,`fca_audit_fail_db`.`size`) */;

/*View structure for view bai_qms_cts_ref */

/*!50001 DROP TABLE IF EXISTS `bai_qms_cts_ref` */;
/*!50001 DROP VIEW IF EXISTS `bai_qms_cts_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_cts_ref` AS (select `bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,sum(if(`bai_qms_db`.`qms_tran_type` = 1,`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if(`bai_qms_db`.`qms_tran_type` = 2,`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if(`bai_qms_db`.`qms_tran_type` = 3,`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if(`bai_qms_db`.`qms_tran_type` = 4,`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if(`bai_qms_db`.`qms_tran_type` = 5,`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if(`bai_qms_db`.`qms_tran_type` = 6,`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if(`bai_qms_db`.`qms_tran_type` = 7,`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if(`bai_qms_db`.`qms_tran_type` = 8,`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if(`bai_qms_db`.`qms_tran_type` = 9,`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,sum(if(`bai_qms_db`.`qms_tran_type` = 10,`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if(`bai_qms_db`.`qms_tran_type` = 11,`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if(`bai_qms_db`.`qms_tran_type` = 12,`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if(`bai_qms_db`.`qms_tran_type` = 13,`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by `bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`) */;

/*View structure for view bai_qms_day_report */

/*!50001 DROP TABLE IF EXISTS `bai_qms_day_report` */;
/*!50001 DROP VIEW IF EXISTS `bai_qms_day_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_day_report` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,`bai_qms_db`.`log_user` AS `log_user`,`bai_qms_db`.`log_date` AS `log_date`,`bai_qms_db`.`log_time` AS `log_time`,`bai_qms_db`.`issued_by` AS `issued_by`,`bai_qms_db`.`qms_size` AS `qms_size`,sum(if(`bai_qms_db`.`qms_tran_type` = 1,`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if(`bai_qms_db`.`qms_tran_type` = 2,`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if(`bai_qms_db`.`qms_tran_type` = 3,`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if(`bai_qms_db`.`qms_tran_type` = 4,`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if(`bai_qms_db`.`qms_tran_type` = 5,`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if(`bai_qms_db`.`qms_tran_type` = 6,`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if(`bai_qms_db`.`qms_tran_type` = 7,`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if(`bai_qms_db`.`qms_tran_type` = 8,`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if(`bai_qms_db`.`qms_tran_type` = 9,`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,`bai_qms_db`.`remarks` AS `remarks`,`bai_qms_db`.`ref1` AS `ref1`,sum(if(`bai_qms_db`.`qms_tran_type` = 10,`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if(`bai_qms_db`.`qms_tran_type` = 11,`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if(`bai_qms_db`.`qms_tran_type` = 12,`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if(`bai_qms_db`.`qms_tran_type` = 13,`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by concat(`bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`qms_size`)) */;

/*View structure for view bai_qms_pop_report */

/*!50001 DROP TABLE IF EXISTS `bai_qms_pop_report` */;
/*!50001 DROP VIEW IF EXISTS `bai_qms_pop_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_pop_report` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,`bai_qms_db`.`log_user` AS `log_user`,`bai_qms_db`.`log_date` AS `log_date`,`bai_qms_db`.`log_time` AS `log_time`,`bai_qms_db`.`issued_by` AS `issued_by`,`bai_qms_db`.`qms_size` AS `qms_size`,sum(if(`bai_qms_db`.`qms_tran_type` = 1,`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if(`bai_qms_db`.`qms_tran_type` = 2,`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if(`bai_qms_db`.`qms_tran_type` = 3,`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if(`bai_qms_db`.`qms_tran_type` = 4,`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if(`bai_qms_db`.`qms_tran_type` = 5,`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if(`bai_qms_db`.`qms_tran_type` = 6,`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if(`bai_qms_db`.`qms_tran_type` = 7,`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if(`bai_qms_db`.`qms_tran_type` = 8,`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if(`bai_qms_db`.`qms_tran_type` = 9,`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,`bai_qms_db`.`remarks` AS `remarks`,`bai_qms_db`.`ref1` AS `ref1`,substring_index(`bai_qms_db`.`remarks`,'-',1) AS `module`,substring_index(`bai_qms_db`.`remarks`,'-',-1) AS `team`,sum(if(`bai_qms_db`.`qms_tran_type` = 10,`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if(`bai_qms_db`.`qms_tran_type` = 11,`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if(`bai_qms_db`.`qms_tran_type` = 12,`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if(`bai_qms_db`.`qms_tran_type` = 13,`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by concat(`bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`qms_size`,`bai_qms_db`.`log_date`,substring_index(`bai_qms_db`.`remarks`,'-',1))) */;

/*View structure for view bai_ship_cts_ref */

/*!50001 DROP TABLE IF EXISTS `bai_ship_cts_ref` */;
/*!50001 DROP VIEW IF EXISTS `bai_ship_cts_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_ship_cts_ref` AS (select sum(`ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08` + `ship_stat_log`.`ship_s_s10` + `ship_stat_log`.`ship_s_s12` + `ship_stat_log`.`ship_s_s14` + `ship_stat_log`.`ship_s_s16` + `ship_stat_log`.`ship_s_s18` + `ship_stat_log`.`ship_s_s20` + `ship_stat_log`.`ship_s_s22` + `ship_stat_log`.`ship_s_s24` + `ship_stat_log`.`ship_s_s26` + `ship_stat_log`.`ship_s_s28` + `ship_stat_log`.`ship_s_s30` + `ship_stat_log`.`ship_s_xs` + `ship_stat_log`.`ship_s_s` + `ship_stat_log`.`ship_s_m` + `ship_stat_log`.`ship_s_l` + `ship_stat_log`.`ship_s_xl` + `ship_stat_log`.`ship_s_xxl` + `ship_stat_log`.`ship_s_xxxl`) AS `shipped`,`ship_stat_log`.`ship_style` AS `ship_style`,`ship_stat_log`.`ship_schedule` AS `ship_schedule`,group_concat(`ship_stat_log`.`disp_note_no` separator ',') AS `disp_note_ref` from `ship_stat_log` where `ship_stat_log`.`ship_status` = 2 group by `ship_stat_log`.`ship_schedule`) */;

/*View structure for view cut_dept_report */

/*!50001 DROP TABLE IF EXISTS `cut_dept_report` */;
/*!50001 DROP VIEW IF EXISTS `cut_dept_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `cut_dept_report` AS (select `a`.`date` AS `date`,`o`.`category` AS `category`,`o`.`catyy` AS `catyy`,`a`.`doc_no` AS `doc_no`,`a`.`section` AS `section`,`a`.`remarks` AS `remarks`,`a`.`fab_received` - (`a`.`damages` + `a`.`shortages`) AS `net_uti`,cast(`a`.`log_date` as time) AS `log_time`,`a`.`fab_received` AS `fab_received`,`a`.`damages` AS `damages`,`a`.`shortages` AS `shortages`,(`o`.`a_xs` + `o`.`a_s` + `o`.`a_m` + `o`.`a_l` + `o`.`a_xl` + `o`.`a_xxl` + `o`.`a_xxxl` + `o`.`a_s01` + `o`.`a_s02` + `o`.`a_s03` + `o`.`a_s04` + `o`.`a_s05` + `o`.`a_s06` + `o`.`a_s07` + `o`.`a_s08` + `o`.`a_s09` + `o`.`a_s10` + `o`.`a_s11` + `o`.`a_s12` + `o`.`a_s13` + `o`.`a_s14` + `o`.`a_s15` + `o`.`a_s16` + `o`.`a_s17` + `o`.`a_s18` + `o`.`a_s19` + `o`.`a_s20` + `o`.`a_s21` + `o`.`a_s22` + `o`.`a_s23` + `o`.`a_s24` + `o`.`a_s25` + `o`.`a_s26` + `o`.`a_s27` + `o`.`a_s28` + `o`.`a_s29` + `o`.`a_s30` + `o`.`a_s31` + `o`.`a_s32` + `o`.`a_s33` + `o`.`a_s34` + `o`.`a_s35` + `o`.`a_s36` + `o`.`a_s37` + `o`.`a_s38` + `o`.`a_s39` + `o`.`a_s40` + `o`.`a_s41` + `o`.`a_s42` + `o`.`a_s43` + `o`.`a_s44` + `o`.`a_s45` + `o`.`a_s46` + `o`.`a_s47` + `o`.`a_s48` + `o`.`a_s49` + `o`.`a_s50`) * `o`.`a_plies` AS `tot_cut_qty` from (`act_cut_status` `a` join `order_cat_doc_mk_mix` `o`) where `a`.`doc_no` = `o`.`doc_no` order by `a`.`section`,cast(`a`.`log_date` as time)) */;

/*View structure for view disp_mix */

/*!50001 DROP TABLE IF EXISTS `disp_mix` */;
/*!50001 DROP VIEW IF EXISTS `disp_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix` AS (select `disp_tb1`.`order_del_no` AS `order_del_no`,`disp_tb1`.`order_style_no` AS `order_style_no`,`disp_tb1`.`order_col_des` AS `order_col_des`,`disp_tb1`.`total` AS `total`,`disp_tb1`.`scanned` AS `scanned`,`disp_tb1`.`unscanned` AS `unscanned`,coalesce(`disp_tb2`.`app`,0) AS `app`,coalesce(`disp_tb2`.`fail`,0) AS `fail`,coalesce(`disp_tb1`.`scanned`,0) - coalesce(`disp_tb2`.`app`,0) AS `audit_pending`,coalesce(`audit_disp_tb2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2`.`fail`,0) AS `fca_fail`,coalesce(`disp_tb1`.`scanned`,0) - coalesce(`audit_disp_tb2`.`app`,0) AS `fca_audit_pending` from ((`disp_tb1` left join `disp_tb2` on(`disp_tb1`.`order_del_no` = `disp_tb2`.`SCHEDULE`)) left join `audit_disp_tb2` on(`disp_tb1`.`order_del_no` = `audit_disp_tb2`.`SCHEDULE`)) where `disp_tb1`.`order_del_no` is not null) */;

/*View structure for view disp_mix_2 */

/*!50001 DROP TABLE IF EXISTS `disp_mix_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_mix_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_2` AS (select `disp_tb1_2`.`order_del_no` AS `order_del_no`,`disp_tb1_2`.`order_style_no` AS `order_style_no`,`disp_tb1_2`.`order_col_des` AS `order_col_des`,`disp_tb1_2`.`total` AS `total`,`disp_tb1_2`.`scanned` AS `scanned`,`disp_tb1_2`.`unscanned` AS `unscanned`,coalesce(`disp_tb2_2`.`app`,0) AS `app`,coalesce(`disp_tb2_2`.`fail`,0) AS `fail`,coalesce(`disp_tb1_2`.`scanned`,0) - coalesce(`disp_tb2_2`.`app`,0) AS `audit_pending`,coalesce(`audit_disp_tb2_2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_2`.`fail`,0) AS `fca_fail`,coalesce(`disp_tb1_2`.`scanned`,0) - coalesce(`audit_disp_tb2_2`.`app`,0) AS `fca_audit_pending` from ((`disp_tb1_2` left join `disp_tb2_2` on(concat(`disp_tb1_2`.`order_del_no`,`disp_tb1_2`.`order_col_des`) = concat(`disp_tb2_2`.`SCHEDULE`,`disp_tb2_2`.`color`))) left join `audit_disp_tb2_2` on(concat(`disp_tb1_2`.`order_del_no`,`disp_tb1_2`.`order_col_des`) = concat(`audit_disp_tb2_2`.`SCHEDULE`,`audit_disp_tb2_2`.`color`))) where `disp_tb1_2`.`order_del_no` is not null) */;

/*View structure for view disp_mix_size */

/*!50001 DROP TABLE IF EXISTS `disp_mix_size` */;
/*!50001 DROP VIEW IF EXISTS `disp_mix_size` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_size` AS (select `disp_tb1_size`.`order_del_no` AS `order_del_no`,`disp_tb1_size`.`order_style_no` AS `order_style_no`,`disp_tb1_size`.`order_col_des` AS `order_col_des`,`disp_tb1_size`.`total` AS `total`,`disp_tb1_size`.`scanned` AS `scanned`,`disp_tb1_size`.`unscanned` AS `unscanned`,`disp_tb1_size`.`size_code` AS `size_code`,coalesce(`disp_tb2_size`.`app`,0) AS `app`,coalesce(`disp_tb2_size`.`fail`,0) AS `fail`,coalesce(`disp_tb1_size`.`scanned`,0) - coalesce(`disp_tb2_size`.`app`,0) AS `audit_pending`,coalesce(`audit_disp_tb2_size`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_size`.`fail`,0) AS `fca_fail`,coalesce(`disp_tb1_size`.`scanned`,0) - coalesce(`audit_disp_tb2_size`.`app`,0) AS `fca_audit_pending` from ((`disp_tb1_size` left join `disp_tb2_size` on(`disp_tb1_size`.`order_del_no` = `disp_tb2_size`.`SCHEDULE` and `disp_tb1_size`.`size_code` = `disp_tb2_size`.`size`)) left join `audit_disp_tb2_size` on(`disp_tb1_size`.`order_del_no` = `audit_disp_tb2_size`.`SCHEDULE` and `disp_tb1_size`.`size_code` = `audit_disp_tb2_size`.`size`)) where `disp_tb1_size`.`order_del_no` is not null) */;

/*View structure for view disp_mix_size_2 */

/*!50001 DROP TABLE IF EXISTS `disp_mix_size_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_mix_size_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_size_2` AS (select `disp_tb1_size_2`.`order_del_no` AS `order_del_no`,`disp_tb1_size_2`.`order_style_no` AS `order_style_no`,`disp_tb1_size_2`.`order_col_des` AS `order_col_des`,`disp_tb1_size_2`.`total` AS `total`,`disp_tb1_size_2`.`scanned` AS `scanned`,`disp_tb1_size_2`.`unscanned` AS `unscanned`,`disp_tb1_size_2`.`size_code` AS `size_code`,coalesce(`disp_tb2_size_2`.`app`,0) AS `app`,coalesce(`disp_tb2_size_2`.`fail`,0) AS `fail`,coalesce(`disp_tb1_size_2`.`scanned`,0) - coalesce(`disp_tb2_size_2`.`app`,0) AS `audit_pending`,coalesce(`audit_disp_tb2_size_2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_size_2`.`fail`,0) AS `fca_fail`,coalesce(`disp_tb1_size_2`.`scanned`,0) - coalesce(`audit_disp_tb2_size_2`.`app`,0) AS `fca_audit_pending` from ((`disp_tb1_size_2` left join `disp_tb2_size_2` on(`disp_tb1_size_2`.`order_del_no` = `disp_tb2_size_2`.`SCHEDULE` and `disp_tb1_size_2`.`size_code` = `disp_tb2_size_2`.`size` and `disp_tb1_size_2`.`order_col_des` = `disp_tb2_size_2`.`color`)) left join `audit_disp_tb2_size_2` on(`disp_tb1_size_2`.`order_del_no` = `audit_disp_tb2_size_2`.`SCHEDULE` and `disp_tb1_size_2`.`size_code` = `audit_disp_tb2_size_2`.`size` and `disp_tb1_size_2`.`order_col_des` = `audit_disp_tb2_size_2`.`color`)) where `disp_tb1_size_2`.`order_del_no` is not null) */;

/*View structure for view disp_tb1 */

/*!50001 DROP TABLE IF EXISTS `disp_tb1` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,group_concat(distinct `packing_summary`.`tid` separator ',') AS `lable_ids`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null,`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where `packing_summary`.`order_del_no` is not null group by `packing_summary`.`order_del_no`) */;

/*View structure for view disp_tb1_2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb1_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb1_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_2` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,group_concat(distinct `packing_summary`.`tid` separator ',') AS `lable_ids`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null,`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where `packing_summary`.`order_del_no` is not null group by `packing_summary`.`order_del_no`,`packing_summary`.`order_col_des`) */;

/*View structure for view disp_tb1_size */

/*!50001 DROP TABLE IF EXISTS `disp_tb1_size` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb1_size` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_size` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,`packing_summary`.`size_code` AS `size_code`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null,`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where `packing_summary`.`order_del_no` is not null group by `packing_summary`.`order_del_no`,`packing_summary`.`size_code`) */;

/*View structure for view disp_tb1_size_2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb1_size_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb1_size_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_size_2` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,`packing_summary`.`size_code` AS `size_code`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null,`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where `packing_summary`.`order_del_no` is not null group by `packing_summary`.`order_del_no`,`packing_summary`.`order_col_des`,`packing_summary`.`size_code`) */;

/*View structure for view disp_tb2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,sum(if(`audit_fail_db`.`tran_type` = 1,`audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`audit_fail_db`.`tran_type` = 2,`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`) */;

/*View structure for view disp_tb2_2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb2_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb2_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`color` AS `color`,sum(if(`audit_fail_db`.`tran_type` = 1,`audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`audit_fail_db`.`tran_type` = 2,`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`color`) */;

/*View structure for view disp_tb2_size */

/*!50001 DROP TABLE IF EXISTS `disp_tb2_size` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb2_size` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_size` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`size` AS `size`,sum(if(`audit_fail_db`.`tran_type` = 1,`audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`audit_fail_db`.`tran_type` = 2,`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`size`) */;

/*View structure for view disp_tb2_size_2 */

/*!50001 DROP TABLE IF EXISTS `disp_tb2_size_2` */;
/*!50001 DROP VIEW IF EXISTS `disp_tb2_size_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_size_2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`size` AS `size`,`audit_fail_db`.`color` AS `color`,sum(if(`audit_fail_db`.`tran_type` = 1,`audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`audit_fail_db`.`tran_type` = 2,`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`size`) */;

/*View structure for view emb_garment_carton_pendings */

/*!50001 DROP TABLE IF EXISTS `emb_garment_carton_pendings` */;
/*!50001 DROP VIEW IF EXISTS `emb_garment_carton_pendings` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `emb_garment_carton_pendings` AS (select min(`pac_stat_log_temp`.`tid`) AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,`pac_stat_log_temp`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where `pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no` and `pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','') and `pac_stat_log_temp`.`disp_carton_no` >= 1 and `ims_log_backup`.`ims_mod_no` <> 0 and left(`pac_stat_log_temp`.`status`,1) = 'E' group by `pac_stat_log_temp`.`doc_no_ref`) */;

/*View structure for view fg_wh_report */

/*!50001 DROP TABLE IF EXISTS `fg_wh_report` */;
/*!50001 DROP VIEW IF EXISTS `fg_wh_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fg_wh_report` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,sum(`packing_summary`.`carton_act_qty`) AS `total_qty`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null or octet_length(`packing_summary`.`status`) = 0,`packing_summary`.`carton_act_qty`,0)) AS `unscanned`,sum(if(left(`packing_summary`.`status`,1) = 'E',`packing_summary`.`carton_act_qty`,0)) AS `embellish`,0 AS `shipped` from `packing_summary` group by `packing_summary`.`order_del_no`) */;

/*View structure for view fg_wh_report_summary */

/*!50001 DROP TABLE IF EXISTS `fg_wh_report_summary` */;
/*!50001 DROP VIEW IF EXISTS `fg_wh_report_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fg_wh_report_summary` AS (select `fg_wh_report`.`order_del_no` AS `order_del_no`,`fg_wh_report`.`total_qty` AS `total_qty`,`fg_wh_report`.`scanned` AS `scanned`,`fg_wh_report`.`unscanned` AS `unscanned`,`fg_wh_report`.`embellish` AS `embellish`,`fg_wh_report`.`shipped` AS `shipped`,`bai_orders_db_confirm`.`order_date` AS `order_date`,`bai_orders_db_confirm`.`order_po_no` AS `order_po_no`,group_concat(trim(`bai_orders_db_confirm`.`order_col_des`) separator ', ') AS `color`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no` from (`fg_wh_report` left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_del_no` = `fg_wh_report`.`order_del_no`)) where `fg_wh_report`.`order_del_no` is not null and `fg_wh_report`.`scanned` > 0 and `fg_wh_report`.`total_qty` - `fg_wh_report`.`shipped` <> 0 group by `fg_wh_report`.`order_del_no`) */;

/*View structure for view fsp_order_ref */

/*!50001 DROP TABLE IF EXISTS `fsp_order_ref` */;
/*!50001 DROP VIEW IF EXISTS `fsp_order_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fsp_order_ref` AS (select `bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`ft_status` AS `ft_status`,`bai_orders_db`.`st_status` AS `st_status`,`bai_orders_db`.`pt_status` AS `pt_status`,group_concat(distinct `bai_orders_db`.`order_col_des` separator ',') AS `color`,sum(`bai_orders_db`.`order_s_xs` + `bai_orders_db`.`order_s_s` + `bai_orders_db`.`order_s_m` + `bai_orders_db`.`order_s_l` + `bai_orders_db`.`order_s_xl` + `bai_orders_db`.`order_s_xxl` + `bai_orders_db`.`order_s_xxxl` + `bai_orders_db`.`order_s_s06` + `bai_orders_db`.`order_s_s08` + `bai_orders_db`.`order_s_s10` + `bai_orders_db`.`order_s_s12` + `bai_orders_db`.`order_s_s14` + `bai_orders_db`.`order_s_s16` + `bai_orders_db`.`order_s_s18` + `bai_orders_db`.`order_s_s20` + `bai_orders_db`.`order_s_s22` + `bai_orders_db`.`order_s_s24` + `bai_orders_db`.`order_s_s26` + `bai_orders_db`.`order_s_s28` + `bai_orders_db`.`order_s_s30`) AS `order_qty`,`bai_orders_db`.`trim_cards` AS `trim_cards`,`bai_orders_db`.`order_div` AS `order_div`,`bai_orders_db`.`trim_status` AS `trim_status`,`bai_orders_db`.`fsp_time_line` AS `fsp_time_line` from `bai_orders_db` group by `bai_orders_db`.`order_del_no`) */;

/*View structure for view ft_st_pk_shipfast_status */

/*!50001 DROP TABLE IF EXISTS `ft_st_pk_shipfast_status` */;
/*!50001 DROP VIEW IF EXISTS `ft_st_pk_shipfast_status` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ft_st_pk_shipfast_status` AS (select `fastreact_plan_summary`.`group_code` AS `group_code`,`fastreact_plan_summary`.`module` AS `module`,`fastreact_plan_summary`.`style` AS `style`,`fastreact_plan_summary`.`order_code` AS `order_code`,`fastreact_plan_summary`.`color` AS `color`,`fastreact_plan_summary`.`smv` AS `smv`,`fastreact_plan_summary`.`delivery_date` AS `delivery_date`,`fastreact_plan_summary`.`schedule` AS `schedule`,`fastreact_plan_summary`.`production_date` AS `production_date`,`fastreact_plan_summary`.`qty` AS `qty`,`fastreact_plan_summary`.`tid` AS `tid`,`fastreact_plan_summary`.`week_code` AS `week_code`,`fastreact_plan_summary`.`status` AS `status`,`fastreact_plan_summary`.`production_start` AS `production_start`,`bai_pro3`.`bai_orders_db`.`order_tid` AS `order_tid`,`bai_pro3`.`bai_orders_db`.`order_date` AS `order_date`,`bai_pro3`.`bai_orders_db`.`order_upload_date` AS `order_upload_date`,`bai_pro3`.`bai_orders_db`.`order_last_mod_date` AS `order_last_mod_date`,`bai_pro3`.`bai_orders_db`.`order_last_upload_date` AS `order_last_upload_date`,`bai_pro3`.`bai_orders_db`.`order_div` AS `order_div`,`bai_pro3`.`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_pro3`.`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_pro3`.`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_pro3`.`bai_orders_db`.`order_col_code` AS `order_col_code`,`bai_pro3`.`bai_orders_db`.`order_s_xs` AS `order_s_xs`,`bai_pro3`.`bai_orders_db`.`order_s_s` AS `order_s_s`,`bai_pro3`.`bai_orders_db`.`order_s_m` AS `order_s_m`,`bai_pro3`.`bai_orders_db`.`order_s_l` AS `order_s_l`,`bai_pro3`.`bai_orders_db`.`order_s_xl` AS `order_s_xl`,`bai_pro3`.`bai_orders_db`.`order_s_xxl` AS `order_s_xxl`,`bai_pro3`.`bai_orders_db`.`order_s_xxxl` AS `order_s_xxxl`,`bai_pro3`.`bai_orders_db`.`order_cat_stat` AS `order_cat_stat`,`bai_pro3`.`bai_orders_db`.`order_cut_stat` AS `order_cut_stat`,`bai_pro3`.`bai_orders_db`.`order_ratio_stat` AS `order_ratio_stat`,`bai_pro3`.`bai_orders_db`.`order_cad_stat` AS `order_cad_stat`,`bai_pro3`.`bai_orders_db`.`order_stat` AS `order_stat`,`bai_pro3`.`bai_orders_db`.`Order_remarks` AS `Order_remarks`,`bai_pro3`.`bai_orders_db`.`order_po_no` AS `order_po_no`,`bai_pro3`.`bai_orders_db`.`order_no` AS `order_no`,`bai_pro3`.`bai_orders_db`.`old_order_s_xs` AS `old_order_s_xs`,`bai_pro3`.`bai_orders_db`.`old_order_s_s` AS `old_order_s_s`,`bai_pro3`.`bai_orders_db`.`old_order_s_m` AS `old_order_s_m`,`bai_pro3`.`bai_orders_db`.`old_order_s_l` AS `old_order_s_l`,`bai_pro3`.`bai_orders_db`.`old_order_s_xl` AS `old_order_s_xl`,`bai_pro3`.`bai_orders_db`.`old_order_s_xxl` AS `old_order_s_xxl`,`bai_pro3`.`bai_orders_db`.`old_order_s_xxxl` AS `old_order_s_xxxl`,`bai_pro3`.`bai_orders_db`.`color_code` AS `color_code`,`bai_pro3`.`bai_orders_db`.`order_joins` AS `order_joins`,`bai_pro3`.`bai_orders_db`.`order_s_s01` AS `order_s_s01`,`bai_pro3`.`bai_orders_db`.`order_s_s02` AS `order_s_s02`,`bai_pro3`.`bai_orders_db`.`order_s_s03` AS `order_s_s03`,`bai_pro3`.`bai_orders_db`.`order_s_s04` AS `order_s_s04`,`bai_pro3`.`bai_orders_db`.`order_s_s05` AS `order_s_s05`,`bai_pro3`.`bai_orders_db`.`order_s_s06` AS `order_s_s06`,`bai_pro3`.`bai_orders_db`.`order_s_s07` AS `order_s_s07`,`bai_pro3`.`bai_orders_db`.`order_s_s08` AS `order_s_s08`,`bai_pro3`.`bai_orders_db`.`order_s_s09` AS `order_s_s09`,`bai_pro3`.`bai_orders_db`.`order_s_s10` AS `order_s_s10`,`bai_pro3`.`bai_orders_db`.`order_s_s11` AS `order_s_s11`,`bai_pro3`.`bai_orders_db`.`order_s_s12` AS `order_s_s12`,`bai_pro3`.`bai_orders_db`.`order_s_s13` AS `order_s_s13`,`bai_pro3`.`bai_orders_db`.`order_s_s14` AS `order_s_s14`,`bai_pro3`.`bai_orders_db`.`order_s_s15` AS `order_s_s15`,`bai_pro3`.`bai_orders_db`.`order_s_s16` AS `order_s_s16`,`bai_pro3`.`bai_orders_db`.`order_s_s17` AS `order_s_s17`,`bai_pro3`.`bai_orders_db`.`order_s_s18` AS `order_s_s18`,`bai_pro3`.`bai_orders_db`.`order_s_s19` AS `order_s_s19`,`bai_pro3`.`bai_orders_db`.`order_s_s20` AS `order_s_s20`,`bai_pro3`.`bai_orders_db`.`order_s_s21` AS `order_s_s21`,`bai_pro3`.`bai_orders_db`.`order_s_s22` AS `order_s_s22`,`bai_pro3`.`bai_orders_db`.`order_s_s23` AS `order_s_s23`,`bai_pro3`.`bai_orders_db`.`order_s_s24` AS `order_s_s24`,`bai_pro3`.`bai_orders_db`.`order_s_s25` AS `order_s_s25`,`bai_pro3`.`bai_orders_db`.`order_s_s26` AS `order_s_s26`,`bai_pro3`.`bai_orders_db`.`order_s_s27` AS `order_s_s27`,`bai_pro3`.`bai_orders_db`.`order_s_s28` AS `order_s_s28`,`bai_pro3`.`bai_orders_db`.`order_s_s29` AS `order_s_s29`,`bai_pro3`.`bai_orders_db`.`order_s_s30` AS `order_s_s30`,`bai_pro3`.`bai_orders_db`.`order_s_s31` AS `order_s_s31`,`bai_pro3`.`bai_orders_db`.`order_s_s32` AS `order_s_s32`,`bai_pro3`.`bai_orders_db`.`order_s_s33` AS `order_s_s33`,`bai_pro3`.`bai_orders_db`.`order_s_s34` AS `order_s_s34`,`bai_pro3`.`bai_orders_db`.`order_s_s35` AS `order_s_s35`,`bai_pro3`.`bai_orders_db`.`order_s_s36` AS `order_s_s36`,`bai_pro3`.`bai_orders_db`.`order_s_s37` AS `order_s_s37`,`bai_pro3`.`bai_orders_db`.`order_s_s38` AS `order_s_s38`,`bai_pro3`.`bai_orders_db`.`order_s_s39` AS `order_s_s39`,`bai_pro3`.`bai_orders_db`.`order_s_s40` AS `order_s_s40`,`bai_pro3`.`bai_orders_db`.`order_s_s41` AS `order_s_s41`,`bai_pro3`.`bai_orders_db`.`order_s_s42` AS `order_s_s42`,`bai_pro3`.`bai_orders_db`.`order_s_s43` AS `order_s_s43`,`bai_pro3`.`bai_orders_db`.`order_s_s44` AS `order_s_s44`,`bai_pro3`.`bai_orders_db`.`order_s_s45` AS `order_s_s45`,`bai_pro3`.`bai_orders_db`.`order_s_s46` AS `order_s_s46`,`bai_pro3`.`bai_orders_db`.`order_s_s47` AS `order_s_s47`,`bai_pro3`.`bai_orders_db`.`order_s_s48` AS `order_s_s48`,`bai_pro3`.`bai_orders_db`.`order_s_s49` AS `order_s_s49`,`bai_pro3`.`bai_orders_db`.`order_s_s50` AS `order_s_s50`,`bai_pro3`.`bai_orders_db`.`old_order_s_s01` AS `old_order_s_s01`,`bai_pro3`.`bai_orders_db`.`old_order_s_s02` AS `old_order_s_s02`,`bai_pro3`.`bai_orders_db`.`old_order_s_s03` AS `old_order_s_s03`,`bai_pro3`.`bai_orders_db`.`old_order_s_s04` AS `old_order_s_s04`,`bai_pro3`.`bai_orders_db`.`old_order_s_s05` AS `old_order_s_s05`,`bai_pro3`.`bai_orders_db`.`old_order_s_s06` AS `old_order_s_s06`,`bai_pro3`.`bai_orders_db`.`old_order_s_s07` AS `old_order_s_s07`,`bai_pro3`.`bai_orders_db`.`old_order_s_s08` AS `old_order_s_s08`,`bai_pro3`.`bai_orders_db`.`old_order_s_s09` AS `old_order_s_s09`,`bai_pro3`.`bai_orders_db`.`old_order_s_s10` AS `old_order_s_s10`,`bai_pro3`.`bai_orders_db`.`old_order_s_s11` AS `old_order_s_s11`,`bai_pro3`.`bai_orders_db`.`old_order_s_s12` AS `old_order_s_s12`,`bai_pro3`.`bai_orders_db`.`old_order_s_s13` AS `old_order_s_s13`,`bai_pro3`.`bai_orders_db`.`old_order_s_s14` AS `old_order_s_s14`,`bai_pro3`.`bai_orders_db`.`old_order_s_s15` AS `old_order_s_s15`,`bai_pro3`.`bai_orders_db`.`old_order_s_s16` AS `old_order_s_s16`,`bai_pro3`.`bai_orders_db`.`old_order_s_s17` AS `old_order_s_s17`,`bai_pro3`.`bai_orders_db`.`old_order_s_s18` AS `old_order_s_s18`,`bai_pro3`.`bai_orders_db`.`old_order_s_s19` AS `old_order_s_s19`,`bai_pro3`.`bai_orders_db`.`old_order_s_s20` AS `old_order_s_s20`,`bai_pro3`.`bai_orders_db`.`old_order_s_s21` AS `old_order_s_s21`,`bai_pro3`.`bai_orders_db`.`old_order_s_s22` AS `old_order_s_s22`,`bai_pro3`.`bai_orders_db`.`old_order_s_s23` AS `old_order_s_s23`,`bai_pro3`.`bai_orders_db`.`old_order_s_s24` AS `old_order_s_s24`,`bai_pro3`.`bai_orders_db`.`old_order_s_s25` AS `old_order_s_s25`,`bai_pro3`.`bai_orders_db`.`old_order_s_s26` AS `old_order_s_s26`,`bai_pro3`.`bai_orders_db`.`old_order_s_s27` AS `old_order_s_s27`,`bai_pro3`.`bai_orders_db`.`old_order_s_s28` AS `old_order_s_s28`,`bai_pro3`.`bai_orders_db`.`old_order_s_s29` AS `old_order_s_s29`,`bai_pro3`.`bai_orders_db`.`old_order_s_s30` AS `old_order_s_s30`,`bai_pro3`.`bai_orders_db`.`old_order_s_s31` AS `old_order_s_s31`,`bai_pro3`.`bai_orders_db`.`old_order_s_s32` AS `old_order_s_s32`,`bai_pro3`.`bai_orders_db`.`old_order_s_s33` AS `old_order_s_s33`,`bai_pro3`.`bai_orders_db`.`old_order_s_s34` AS `old_order_s_s34`,`bai_pro3`.`bai_orders_db`.`old_order_s_s35` AS `old_order_s_s35`,`bai_pro3`.`bai_orders_db`.`old_order_s_s36` AS `old_order_s_s36`,`bai_pro3`.`bai_orders_db`.`old_order_s_s37` AS `old_order_s_s37`,`bai_pro3`.`bai_orders_db`.`old_order_s_s38` AS `old_order_s_s38`,`bai_pro3`.`bai_orders_db`.`old_order_s_s39` AS `old_order_s_s39`,`bai_pro3`.`bai_orders_db`.`old_order_s_s40` AS `old_order_s_s40`,`bai_pro3`.`bai_orders_db`.`old_order_s_s41` AS `old_order_s_s41`,`bai_pro3`.`bai_orders_db`.`old_order_s_s42` AS `old_order_s_s42`,`bai_pro3`.`bai_orders_db`.`old_order_s_s43` AS `old_order_s_s43`,`bai_pro3`.`bai_orders_db`.`old_order_s_s44` AS `old_order_s_s44`,`bai_pro3`.`bai_orders_db`.`old_order_s_s45` AS `old_order_s_s45`,`bai_pro3`.`bai_orders_db`.`old_order_s_s46` AS `old_order_s_s46`,`bai_pro3`.`bai_orders_db`.`old_order_s_s47` AS `old_order_s_s47`,`bai_pro3`.`bai_orders_db`.`old_order_s_s48` AS `old_order_s_s48`,`bai_pro3`.`bai_orders_db`.`old_order_s_s49` AS `old_order_s_s49`,`bai_pro3`.`bai_orders_db`.`old_order_s_s50` AS `old_order_s_s50`,`bai_pro3`.`bai_orders_db`.`packing_method` AS `packing_method`,`bai_pro3`.`bai_orders_db`.`style_id` AS `style_id`,`bai_pro3`.`bai_orders_db`.`carton_id` AS `carton_id`,`bai_pro3`.`bai_orders_db`.`carton_print_status` AS `carton_print_status`,`bai_pro3`.`bai_orders_db`.`ft_status` AS `ft_status`,`bai_pro3`.`bai_orders_db`.`st_status` AS `st_status`,`bai_pro3`.`bai_orders_db`.`pt_status` AS `pt_status` from (`bai_pro4`.`fastreact_plan_summary` left join `bai_pro3`.`bai_orders_db` on(`fastreact_plan_summary`.`schedule` = `bai_pro3`.`bai_orders_db`.`order_del_no`)) order by `fastreact_plan_summary`.`production_start`) */;

/*View structure for view ims_combine */

/*!50001 DROP TABLE IF EXISTS `ims_combine` */;
/*!50001 DROP VIEW IF EXISTS `ims_combine` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_combine` AS select `ims_log`.`ims_date` AS `ims_date`,`ims_log`.`ims_cid` AS `ims_cid`,`ims_log`.`ims_doc_no` AS `ims_doc_no`,`ims_log`.`ims_mod_no` AS `ims_mod_no`,`ims_log`.`ims_shift` AS `ims_shift`,`ims_log`.`ims_size` AS `ims_size`,`ims_log`.`ims_qty` AS `ims_qty`,`ims_log`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log`.`ims_status` AS `ims_status`,`ims_log`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log`.`ims_log_date` AS `ims_log_date`,`ims_log`.`ims_remarks` AS `ims_remarks`,`ims_log`.`ims_style` AS `ims_style`,`ims_log`.`ims_schedule` AS `ims_schedule`,`ims_log`.`ims_color` AS `ims_color`,`ims_log`.`tid` AS `tid`,`ims_log`.`rand_track` AS `rand_track`,`ims_log`.`input_job_rand_no_ref` AS `input_job_rand_no_ref`,`ims_log`.`input_job_no_ref` AS `input_job_no_ref`,`ims_log`.`pac_tid` AS `pac_tid` from `ims_log` union all select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,`ims_log_backup`.`ims_qty` AS `ims_qty`,`ims_log_backup`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track`,`ims_log_backup`.`input_job_rand_no_ref` AS `input_job_rand_no_ref`,`ims_log_backup`.`input_job_no_ref` AS `input_job_no_ref`,`ims_log_backup`.`pac_tid` AS `pac_tid` from `ims_log_backup` */;

/*View structure for view ims_log_backup_t1 */

/*!50001 DROP TABLE IF EXISTS `ims_log_backup_t1` */;
/*!50001 DROP VIEW IF EXISTS `ims_log_backup_t1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_backup_t1` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track` from `ims_log_backup` where `ims_log_backup`.`ims_mod_no` <> 0 group by `ims_log_backup`.`ims_doc_no`,`ims_log_backup`.`ims_size`) */;

/*View structure for view ims_log_backup_t2 */

/*!50001 DROP TABLE IF EXISTS `ims_log_backup_t2` */;
/*!50001 DROP VIEW IF EXISTS `ims_log_backup_t2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_backup_t2` AS (select `ims_log`.`ims_date` AS `ims_date`,`ims_log`.`ims_cid` AS `ims_cid`,`ims_log`.`ims_doc_no` AS `ims_doc_no`,`ims_log`.`ims_mod_no` AS `ims_mod_no`,`ims_log`.`ims_shift` AS `ims_shift`,`ims_log`.`ims_size` AS `ims_size`,sum(`ims_log`.`ims_qty`) AS `ims_qty`,sum(`ims_log`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log`.`ims_status` AS `ims_status`,`ims_log`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log`.`ims_log_date` AS `ims_log_date`,`ims_log`.`ims_remarks` AS `ims_remarks`,`ims_log`.`ims_style` AS `ims_style`,`ims_log`.`ims_schedule` AS `ims_schedule`,`ims_log`.`ims_color` AS `ims_color`,`ims_log`.`tid` AS `tid`,`ims_log`.`rand_track` AS `rand_track` from `ims_log` where `ims_log`.`ims_mod_no` <> 0 group by `ims_log`.`ims_doc_no`,`ims_log`.`ims_size`) */;

/*View structure for view ims_log_live */

/*!50001 DROP TABLE IF EXISTS `ims_log_live` */;
/*!50001 DROP VIEW IF EXISTS `ims_log_live` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_live` AS select `brandix_bts`.`bundle_creation_data`.`id` AS `id`,`brandix_bts`.`bundle_creation_data`.`date_time` AS `date_time`,`brandix_bts`.`bundle_creation_data`.`style` AS `style`,`brandix_bts`.`bundle_creation_data`.`schedule` AS `schedule`,`brandix_bts`.`bundle_creation_data`.`color` AS `color`,`brandix_bts`.`bundle_creation_data`.`size_title` AS `size_title`,`brandix_bts`.`bundle_creation_data`.`bundle_number` AS `bundle_number`,`brandix_bts`.`bundle_creation_data`.`original_qty` AS `original_qty`,`brandix_bts`.`bundle_creation_data`.`send_qty` AS `send_qty`,`brandix_bts`.`bundle_creation_data`.`recevied_qty` AS `recevied_qty`,`brandix_bts`.`bundle_creation_data`.`missing_qty` AS `missing_qty`,`brandix_bts`.`bundle_creation_data`.`rejected_qty` AS `rejected_qty`,`brandix_bts`.`bundle_creation_data`.`left_over` AS `left_over`,`brandix_bts`.`bundle_creation_data`.`docket_number` AS `docket_number`,`brandix_bts`.`bundle_creation_data`.`assigned_module` AS `assigned_module`,`brandix_bts`.`bundle_creation_data`.`operation_id` AS `operation_id`,`brandix_bts`.`bundle_creation_data`.`shift` AS `shift`,`brandix_bts`.`bundle_creation_data`.`cut_number` AS `cut_number`,`brandix_bts`.`bundle_creation_data`.`input_job_no` AS `input_job_no`,`brandix_bts`.`bundle_creation_data`.`input_job_no_random_ref` AS `input_job_no_random_ref` from `brandix_bts`.`bundle_creation_data` where `brandix_bts`.`bundle_creation_data`.`original_qty` <> `brandix_bts`.`bundle_creation_data`.`recevied_qty` + `brandix_bts`.`bundle_creation_data`.`rejected_qty` */;

/*View structure for view ims_log_long_pending_transfers */

/*!50001 DROP TABLE IF EXISTS `ims_log_long_pending_transfers` */;
/*!50001 DROP VIEW IF EXISTS `ims_log_long_pending_transfers` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_long_pending_transfers` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,`ims_log_backup`.`ims_qty` AS `ims_qty`,`ims_log_backup`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color` from `ims_log_backup` where `ims_log_backup`.`ims_qty` - `ims_log_backup`.`ims_pro_qty` > 0 and `ims_log_backup`.`ims_mod_no` <> 0 and `ims_log_backup`.`ims_date` > '2010-10-01') */;

/*View structure for view incentive_emb_reference */

/*!50001 DROP TABLE IF EXISTS `incentive_emb_reference` */;
/*!50001 DROP VIEW IF EXISTS `incentive_emb_reference` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incentive_emb_reference` AS (select `bai_orders_db`.`order_del_no` AS `order_del_no`,if(0 + 0 + 0 + 0 + `bai_orders_db`.`order_embl_e` + `bai_orders_db`.`order_embl_f` + 0 + 0 > 0,1,0) AS `emb_stat` from `bai_orders_db` where 0 + 0 + 0 + 0 + `bai_orders_db`.`order_embl_e` + `bai_orders_db`.`order_embl_f` + 0 + 0 > 0 group by `bai_orders_db`.`order_del_no`) */;

/*View structure for view incentive_fca_audit_fail_sch */

/*!50001 DROP TABLE IF EXISTS `incentive_fca_audit_fail_sch` */;
/*!50001 DROP VIEW IF EXISTS `incentive_fca_audit_fail_sch` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incentive_fca_audit_fail_sch` AS (select `fca_audit_fail_db`.`schedule` AS `schedule`,group_concat(distinct `fca_audit_fail_db`.`remarks` separator ',') AS `remarks` from `fca_audit_fail_db` where `fca_audit_fail_db`.`tran_type` = 2 group by `fca_audit_fail_db`.`schedule`) */;

/*View structure for view live_pro_table_ref */

/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref` */;
/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from ((`ims_log` left join `plandoc_stat_log` on(`plandoc_stat_log`.`doc_no` = `ims_log`.`ims_doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))) */;

/*View structure for view live_pro_table_ref2 */

/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref2` */;
/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref2` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from (`plandoc_stat_log` left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))) */;

/*View structure for view live_pro_table_ref3 */

/*!50001 DROP TABLE IF EXISTS `live_pro_table_ref3` */;
/*!50001 DROP VIEW IF EXISTS `live_pro_table_ref3` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref3` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from ((`ims_log_backup` left join `plandoc_stat_log` on(`plandoc_stat_log`.`doc_no` = `ims_log_backup`.`ims_doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))) */;

/*View structure for view marker_ref_matrix_view */

/*!50001 DROP TABLE IF EXISTS `marker_ref_matrix_view` */;
/*!50001 DROP VIEW IF EXISTS `marker_ref_matrix_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `marker_ref_matrix_view` AS (select `cat_stat_log`.`category` AS `category`,`cat_stat_log`.`strip_match` AS `strip_match`,`cat_stat_log`.`gmtway` AS `gmtway`,`marker_ref_matrix`.`marker_ref_tid` AS `marker_ref_tid`,`marker_ref_matrix`.`marker_width` AS `marker_width`,`marker_ref_matrix`.`marker_length` AS `marker_length`,`marker_ref_matrix`.`marker_ref` AS `marker_ref`,`marker_ref_matrix`.`cat_ref` AS `cat_ref`,`marker_ref_matrix`.`allocate_ref` AS `allocate_ref`,`marker_ref_matrix`.`style_code` AS `style_code`,`marker_ref_matrix`.`buyer_code` AS `buyer_code`,`marker_ref_matrix`.`pat_ver` AS `pat_ver`,`marker_ref_matrix`.`xs` AS `xs`,`marker_ref_matrix`.`s` AS `s`,`marker_ref_matrix`.`m` AS `m`,`marker_ref_matrix`.`l` AS `l`,`marker_ref_matrix`.`xl` AS `xl`,`marker_ref_matrix`.`xxl` AS `xxl`,`marker_ref_matrix`.`xxxl` AS `xxxl`,`marker_ref_matrix`.`s01` AS `s01`,`marker_ref_matrix`.`s02` AS `s02`,`marker_ref_matrix`.`s03` AS `s03`,`marker_ref_matrix`.`s04` AS `s04`,`marker_ref_matrix`.`s05` AS `s05`,`marker_ref_matrix`.`s06` AS `s06`,`marker_ref_matrix`.`s07` AS `s07`,`marker_ref_matrix`.`s08` AS `s08`,`marker_ref_matrix`.`s09` AS `s09`,`marker_ref_matrix`.`s10` AS `s10`,`marker_ref_matrix`.`s11` AS `s11`,`marker_ref_matrix`.`s12` AS `s12`,`marker_ref_matrix`.`s13` AS `s13`,`marker_ref_matrix`.`s14` AS `s14`,`marker_ref_matrix`.`s15` AS `s15`,`marker_ref_matrix`.`s16` AS `s16`,`marker_ref_matrix`.`s17` AS `s17`,`marker_ref_matrix`.`s18` AS `s18`,`marker_ref_matrix`.`s19` AS `s19`,`marker_ref_matrix`.`s20` AS `s20`,`marker_ref_matrix`.`s21` AS `s21`,`marker_ref_matrix`.`s22` AS `s22`,`marker_ref_matrix`.`s23` AS `s23`,`marker_ref_matrix`.`s24` AS `s24`,`marker_ref_matrix`.`s25` AS `s25`,`marker_ref_matrix`.`s26` AS `s26`,`marker_ref_matrix`.`s27` AS `s27`,`marker_ref_matrix`.`s28` AS `s28`,`marker_ref_matrix`.`s29` AS `s29`,`marker_ref_matrix`.`s30` AS `s30`,`marker_ref_matrix`.`s31` AS `s31`,`marker_ref_matrix`.`s32` AS `s32`,`marker_ref_matrix`.`s33` AS `s33`,`marker_ref_matrix`.`s34` AS `s34`,`marker_ref_matrix`.`s35` AS `s35`,`marker_ref_matrix`.`s36` AS `s36`,`marker_ref_matrix`.`s37` AS `s37`,`marker_ref_matrix`.`s38` AS `s38`,`marker_ref_matrix`.`s39` AS `s39`,`marker_ref_matrix`.`s40` AS `s40`,`marker_ref_matrix`.`s41` AS `s41`,`marker_ref_matrix`.`s42` AS `s42`,`marker_ref_matrix`.`s43` AS `s43`,`marker_ref_matrix`.`s44` AS `s44`,`marker_ref_matrix`.`s45` AS `s45`,`marker_ref_matrix`.`s46` AS `s46`,`marker_ref_matrix`.`s47` AS `s47`,`marker_ref_matrix`.`s48` AS `s48`,`marker_ref_matrix`.`s49` AS `s49`,`marker_ref_matrix`.`s50` AS `s50`,`marker_ref_matrix`.`lastup` AS `lastup`,`marker_ref_matrix`.`title_size_s01` AS `title_size_s01`,`marker_ref_matrix`.`title_size_s02` AS `title_size_s02`,`marker_ref_matrix`.`title_size_s03` AS `title_size_s03`,`marker_ref_matrix`.`title_size_s04` AS `title_size_s04`,`marker_ref_matrix`.`title_size_s05` AS `title_size_s05`,`marker_ref_matrix`.`title_size_s06` AS `title_size_s06`,`marker_ref_matrix`.`title_size_s07` AS `title_size_s07`,`marker_ref_matrix`.`title_size_s08` AS `title_size_s08`,`marker_ref_matrix`.`title_size_s09` AS `title_size_s09`,`marker_ref_matrix`.`title_size_s10` AS `title_size_s10`,`marker_ref_matrix`.`title_size_s11` AS `title_size_s11`,`marker_ref_matrix`.`title_size_s12` AS `title_size_s12`,`marker_ref_matrix`.`title_size_s13` AS `title_size_s13`,`marker_ref_matrix`.`title_size_s14` AS `title_size_s14`,`marker_ref_matrix`.`title_size_s15` AS `title_size_s15`,`marker_ref_matrix`.`title_size_s16` AS `title_size_s16`,`marker_ref_matrix`.`title_size_s17` AS `title_size_s17`,`marker_ref_matrix`.`title_size_s18` AS `title_size_s18`,`marker_ref_matrix`.`title_size_s19` AS `title_size_s19`,`marker_ref_matrix`.`title_size_s20` AS `title_size_s20`,`marker_ref_matrix`.`title_size_s21` AS `title_size_s21`,`marker_ref_matrix`.`title_size_s22` AS `title_size_s22`,`marker_ref_matrix`.`title_size_s23` AS `title_size_s23`,`marker_ref_matrix`.`title_size_s24` AS `title_size_s24`,`marker_ref_matrix`.`title_size_s25` AS `title_size_s25`,`marker_ref_matrix`.`title_size_s26` AS `title_size_s26`,`marker_ref_matrix`.`title_size_s27` AS `title_size_s27`,`marker_ref_matrix`.`title_size_s28` AS `title_size_s28`,`marker_ref_matrix`.`title_size_s29` AS `title_size_s29`,`marker_ref_matrix`.`title_size_s30` AS `title_size_s30`,`marker_ref_matrix`.`title_size_s31` AS `title_size_s31`,`marker_ref_matrix`.`title_size_s32` AS `title_size_s32`,`marker_ref_matrix`.`title_size_s33` AS `title_size_s33`,`marker_ref_matrix`.`title_size_s34` AS `title_size_s34`,`marker_ref_matrix`.`title_size_s35` AS `title_size_s35`,`marker_ref_matrix`.`title_size_s36` AS `title_size_s36`,`marker_ref_matrix`.`title_size_s37` AS `title_size_s37`,`marker_ref_matrix`.`title_size_s38` AS `title_size_s38`,`marker_ref_matrix`.`title_size_s39` AS `title_size_s39`,`marker_ref_matrix`.`title_size_s40` AS `title_size_s40`,`marker_ref_matrix`.`title_size_s41` AS `title_size_s41`,`marker_ref_matrix`.`title_size_s42` AS `title_size_s42`,`marker_ref_matrix`.`title_size_s43` AS `title_size_s43`,`marker_ref_matrix`.`title_size_s44` AS `title_size_s44`,`marker_ref_matrix`.`title_size_s45` AS `title_size_s45`,`marker_ref_matrix`.`title_size_s46` AS `title_size_s46`,`marker_ref_matrix`.`title_size_s47` AS `title_size_s47`,`marker_ref_matrix`.`title_size_s48` AS `title_size_s48`,`marker_ref_matrix`.`title_size_s49` AS `title_size_s49`,`marker_ref_matrix`.`title_size_s50` AS `title_size_s50`,`marker_ref_matrix`.`title_flag` AS `title_flag`,`maker_stat_log`.`remarks` AS `remarks` from ((`marker_ref_matrix` left join `cat_stat_log` on(`marker_ref_matrix`.`cat_ref` = `cat_stat_log`.`tid`)) left join `maker_stat_log` on(`marker_ref_matrix`.`cat_ref` = `maker_stat_log`.`cat_ref` and `marker_ref_matrix`.`allocate_ref` = `maker_stat_log`.`allocate_ref`))) */;

/*View structure for view order_cat_doc_mix */

/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mix` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_doc_mix` AS (select `cat_stat_log`.`catyy` AS `catyy`,`bai_orders_db`.`style_id` AS `style_id`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`cat_stat_log`.`patt_ver` AS `cat_patt_ver`,`cat_stat_log`.`strip_match` AS `strip_match`,`cat_stat_log`.`col_des` AS `col_des`,`plandoc_stat_log`.`date` AS `date`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,`plandoc_stat_log`.`cuttable_ref` AS `cuttable_ref`,`plandoc_stat_log`.`allocate_ref` AS `allocate_ref`,`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`pcutno` AS `pcutno`,`plandoc_stat_log`.`ratio` AS `ratio`,`plandoc_stat_log`.`p_xs` AS `p_xs`,`plandoc_stat_log`.`p_s` AS `p_s`,`plandoc_stat_log`.`p_m` AS `p_m`,`plandoc_stat_log`.`p_l` AS `p_l`,`plandoc_stat_log`.`p_xl` AS `p_xl`,`plandoc_stat_log`.`p_xxl` AS `p_xxl`,`plandoc_stat_log`.`p_xxxl` AS `p_xxxl`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`a_xs` AS `a_xs`,`plandoc_stat_log`.`a_s` AS `a_s`,`plandoc_stat_log`.`a_m` AS `a_m`,`plandoc_stat_log`.`a_l` AS `a_l`,`plandoc_stat_log`.`a_xl` AS `a_xl`,`plandoc_stat_log`.`a_xxl` AS `a_xxl`,`plandoc_stat_log`.`a_xxxl` AS `a_xxxl`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`lastup` AS `lastup`,`plandoc_stat_log`.`remarks` AS `remarks`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`pcutdocid` AS `pcutdocid`,`plandoc_stat_log`.`print_status` AS `print_status`,`plandoc_stat_log`.`a_s01` AS `a_s01`,`plandoc_stat_log`.`a_s02` AS `a_s02`,`plandoc_stat_log`.`a_s03` AS `a_s03`,`plandoc_stat_log`.`a_s04` AS `a_s04`,`plandoc_stat_log`.`a_s05` AS `a_s05`,`plandoc_stat_log`.`a_s06` AS `a_s06`,`plandoc_stat_log`.`a_s07` AS `a_s07`,`plandoc_stat_log`.`a_s08` AS `a_s08`,`plandoc_stat_log`.`a_s09` AS `a_s09`,`plandoc_stat_log`.`a_s10` AS `a_s10`,`plandoc_stat_log`.`a_s11` AS `a_s11`,`plandoc_stat_log`.`a_s12` AS `a_s12`,`plandoc_stat_log`.`a_s13` AS `a_s13`,`plandoc_stat_log`.`a_s14` AS `a_s14`,`plandoc_stat_log`.`a_s15` AS `a_s15`,`plandoc_stat_log`.`a_s16` AS `a_s16`,`plandoc_stat_log`.`a_s17` AS `a_s17`,`plandoc_stat_log`.`a_s18` AS `a_s18`,`plandoc_stat_log`.`a_s19` AS `a_s19`,`plandoc_stat_log`.`a_s20` AS `a_s20`,`plandoc_stat_log`.`a_s21` AS `a_s21`,`plandoc_stat_log`.`a_s22` AS `a_s22`,`plandoc_stat_log`.`a_s23` AS `a_s23`,`plandoc_stat_log`.`a_s24` AS `a_s24`,`plandoc_stat_log`.`a_s25` AS `a_s25`,`plandoc_stat_log`.`a_s26` AS `a_s26`,`plandoc_stat_log`.`a_s27` AS `a_s27`,`plandoc_stat_log`.`a_s28` AS `a_s28`,`plandoc_stat_log`.`a_s29` AS `a_s29`,`plandoc_stat_log`.`a_s30` AS `a_s30`,`plandoc_stat_log`.`a_s31` AS `a_s31`,`plandoc_stat_log`.`a_s32` AS `a_s32`,`plandoc_stat_log`.`a_s33` AS `a_s33`,`plandoc_stat_log`.`a_s34` AS `a_s34`,`plandoc_stat_log`.`a_s35` AS `a_s35`,`plandoc_stat_log`.`a_s36` AS `a_s36`,`plandoc_stat_log`.`a_s37` AS `a_s37`,`plandoc_stat_log`.`a_s38` AS `a_s38`,`plandoc_stat_log`.`a_s39` AS `a_s39`,`plandoc_stat_log`.`a_s40` AS `a_s40`,`plandoc_stat_log`.`a_s41` AS `a_s41`,`plandoc_stat_log`.`a_s42` AS `a_s42`,`plandoc_stat_log`.`a_s43` AS `a_s43`,`plandoc_stat_log`.`a_s44` AS `a_s44`,`plandoc_stat_log`.`a_s45` AS `a_s45`,`plandoc_stat_log`.`a_s46` AS `a_s46`,`plandoc_stat_log`.`a_s47` AS `a_s47`,`plandoc_stat_log`.`a_s48` AS `a_s48`,`plandoc_stat_log`.`a_s49` AS `a_s49`,`plandoc_stat_log`.`a_s50` AS `a_s50`,`plandoc_stat_log`.`p_s01` AS `p_s01`,`plandoc_stat_log`.`p_s02` AS `p_s02`,`plandoc_stat_log`.`p_s03` AS `p_s03`,`plandoc_stat_log`.`p_s04` AS `p_s04`,`plandoc_stat_log`.`p_s05` AS `p_s05`,`plandoc_stat_log`.`p_s06` AS `p_s06`,`plandoc_stat_log`.`p_s07` AS `p_s07`,`plandoc_stat_log`.`p_s08` AS `p_s08`,`plandoc_stat_log`.`p_s09` AS `p_s09`,`plandoc_stat_log`.`p_s10` AS `p_s10`,`plandoc_stat_log`.`p_s11` AS `p_s11`,`plandoc_stat_log`.`p_s12` AS `p_s12`,`plandoc_stat_log`.`p_s13` AS `p_s13`,`plandoc_stat_log`.`p_s14` AS `p_s14`,`plandoc_stat_log`.`p_s15` AS `p_s15`,`plandoc_stat_log`.`p_s16` AS `p_s16`,`plandoc_stat_log`.`p_s17` AS `p_s17`,`plandoc_stat_log`.`p_s18` AS `p_s18`,`plandoc_stat_log`.`p_s19` AS `p_s19`,`plandoc_stat_log`.`p_s20` AS `p_s20`,`plandoc_stat_log`.`p_s21` AS `p_s21`,`plandoc_stat_log`.`p_s22` AS `p_s22`,`plandoc_stat_log`.`p_s23` AS `p_s23`,`plandoc_stat_log`.`p_s24` AS `p_s24`,`plandoc_stat_log`.`p_s25` AS `p_s25`,`plandoc_stat_log`.`p_s26` AS `p_s26`,`plandoc_stat_log`.`p_s27` AS `p_s27`,`plandoc_stat_log`.`p_s28` AS `p_s28`,`plandoc_stat_log`.`p_s29` AS `p_s29`,`plandoc_stat_log`.`p_s30` AS `p_s30`,`plandoc_stat_log`.`p_s31` AS `p_s31`,`plandoc_stat_log`.`p_s32` AS `p_s32`,`plandoc_stat_log`.`p_s33` AS `p_s33`,`plandoc_stat_log`.`p_s34` AS `p_s34`,`plandoc_stat_log`.`p_s35` AS `p_s35`,`plandoc_stat_log`.`p_s36` AS `p_s36`,`plandoc_stat_log`.`p_s37` AS `p_s37`,`plandoc_stat_log`.`p_s38` AS `p_s38`,`plandoc_stat_log`.`p_s39` AS `p_s39`,`plandoc_stat_log`.`p_s40` AS `p_s40`,`plandoc_stat_log`.`p_s41` AS `p_s41`,`plandoc_stat_log`.`p_s42` AS `p_s42`,`plandoc_stat_log`.`p_s43` AS `p_s43`,`plandoc_stat_log`.`p_s44` AS `p_s44`,`plandoc_stat_log`.`p_s45` AS `p_s45`,`plandoc_stat_log`.`p_s46` AS `p_s46`,`plandoc_stat_log`.`p_s47` AS `p_s47`,`plandoc_stat_log`.`p_s48` AS `p_s48`,`plandoc_stat_log`.`p_s49` AS `p_s49`,`plandoc_stat_log`.`p_s50` AS `p_s50`,`plandoc_stat_log`.`rm_date` AS `rm_date`,`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`fab_des` AS `fab_des`,`cat_stat_log`.`gmtway` AS `gmtway`,`cat_stat_log`.`compo_no` AS `compo_no`,`cat_stat_log`.`purwidth` AS `purwidth`,`bai_orders_db`.`color_code` AS `color_code`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`fabric_status` AS `fabric_status`,`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des` from ((`plandoc_stat_log` left join `cat_stat_log` on(`plandoc_stat_log`.`cat_ref` = `cat_stat_log`.`tid`)) left join `bai_orders_db` on(`plandoc_stat_log`.`order_tid` = `bai_orders_db`.`order_tid`))) */;

/*View structure for view order_cat_doc_mk_mix */

/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mk_mix` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mk_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_doc_mk_mix` AS (select `order_cat_doc_mix`.`catyy` AS `catyy`,`order_cat_doc_mix`.`cat_patt_ver` AS `cat_patt_ver`,`maker_stat_log`.`remarks` AS `mk_file`,`maker_stat_log`.`mk_ver` AS `mk_ver`,`maker_stat_log`.`mklength` AS `mklength`,`order_cat_doc_mix`.`style_id` AS `style_id`,`order_cat_doc_mix`.`col_des` AS `col_des`,`order_cat_doc_mix`.`gmtway` AS `gmtway`,`order_cat_doc_mix`.`strip_match` AS `strip_match`,`order_cat_doc_mix`.`fab_des` AS `fab_des`,`order_cat_doc_mix`.`clubbing` AS `clubbing`,`order_cat_doc_mix`.`date` AS `date`,`order_cat_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_doc_mix`.`compo_no` AS `compo_no`,`order_cat_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_doc_mix`.`order_tid` AS `order_tid`,`order_cat_doc_mix`.`pcutno` AS `pcutno`,`order_cat_doc_mix`.`ratio` AS `ratio`,`order_cat_doc_mix`.`p_xs` AS `p_xs`,`order_cat_doc_mix`.`p_s` AS `p_s`,`order_cat_doc_mix`.`p_m` AS `p_m`,`order_cat_doc_mix`.`p_l` AS `p_l`,`order_cat_doc_mix`.`p_xl` AS `p_xl`,`order_cat_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_doc_mix`.`p_plies` AS `p_plies`,`order_cat_doc_mix`.`doc_no` AS `doc_no`,`order_cat_doc_mix`.`acutno` AS `acutno`,`order_cat_doc_mix`.`a_xs` AS `a_xs`,`order_cat_doc_mix`.`a_s` AS `a_s`,`order_cat_doc_mix`.`a_m` AS `a_m`,`order_cat_doc_mix`.`a_l` AS `a_l`,`order_cat_doc_mix`.`a_xl` AS `a_xl`,`order_cat_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_doc_mix`.`a_plies` AS `a_plies`,`order_cat_doc_mix`.`lastup` AS `lastup`,`order_cat_doc_mix`.`remarks` AS `remarks`,`order_cat_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_doc_mix`.`print_status` AS `print_status`,`order_cat_doc_mix`.`a_s01` AS `a_s01`,`order_cat_doc_mix`.`a_s02` AS `a_s02`,`order_cat_doc_mix`.`a_s03` AS `a_s03`,`order_cat_doc_mix`.`a_s04` AS `a_s04`,`order_cat_doc_mix`.`a_s05` AS `a_s05`,`order_cat_doc_mix`.`a_s06` AS `a_s06`,`order_cat_doc_mix`.`a_s07` AS `a_s07`,`order_cat_doc_mix`.`a_s08` AS `a_s08`,`order_cat_doc_mix`.`a_s09` AS `a_s09`,`order_cat_doc_mix`.`a_s10` AS `a_s10`,`order_cat_doc_mix`.`a_s11` AS `a_s11`,`order_cat_doc_mix`.`a_s12` AS `a_s12`,`order_cat_doc_mix`.`a_s13` AS `a_s13`,`order_cat_doc_mix`.`a_s14` AS `a_s14`,`order_cat_doc_mix`.`a_s15` AS `a_s15`,`order_cat_doc_mix`.`a_s16` AS `a_s16`,`order_cat_doc_mix`.`a_s17` AS `a_s17`,`order_cat_doc_mix`.`a_s18` AS `a_s18`,`order_cat_doc_mix`.`a_s19` AS `a_s19`,`order_cat_doc_mix`.`a_s20` AS `a_s20`,`order_cat_doc_mix`.`a_s21` AS `a_s21`,`order_cat_doc_mix`.`a_s22` AS `a_s22`,`order_cat_doc_mix`.`a_s23` AS `a_s23`,`order_cat_doc_mix`.`a_s24` AS `a_s24`,`order_cat_doc_mix`.`a_s25` AS `a_s25`,`order_cat_doc_mix`.`a_s26` AS `a_s26`,`order_cat_doc_mix`.`a_s27` AS `a_s27`,`order_cat_doc_mix`.`a_s28` AS `a_s28`,`order_cat_doc_mix`.`a_s29` AS `a_s29`,`order_cat_doc_mix`.`a_s30` AS `a_s30`,`order_cat_doc_mix`.`a_s31` AS `a_s31`,`order_cat_doc_mix`.`a_s32` AS `a_s32`,`order_cat_doc_mix`.`a_s33` AS `a_s33`,`order_cat_doc_mix`.`a_s34` AS `a_s34`,`order_cat_doc_mix`.`a_s35` AS `a_s35`,`order_cat_doc_mix`.`a_s36` AS `a_s36`,`order_cat_doc_mix`.`a_s37` AS `a_s37`,`order_cat_doc_mix`.`a_s38` AS `a_s38`,`order_cat_doc_mix`.`a_s39` AS `a_s39`,`order_cat_doc_mix`.`a_s40` AS `a_s40`,`order_cat_doc_mix`.`a_s41` AS `a_s41`,`order_cat_doc_mix`.`a_s42` AS `a_s42`,`order_cat_doc_mix`.`a_s43` AS `a_s43`,`order_cat_doc_mix`.`a_s44` AS `a_s44`,`order_cat_doc_mix`.`a_s45` AS `a_s45`,`order_cat_doc_mix`.`a_s46` AS `a_s46`,`order_cat_doc_mix`.`a_s47` AS `a_s47`,`order_cat_doc_mix`.`a_s48` AS `a_s48`,`order_cat_doc_mix`.`a_s49` AS `a_s49`,`order_cat_doc_mix`.`a_s50` AS `a_s50`,`order_cat_doc_mix`.`p_s01` AS `p_s01`,`order_cat_doc_mix`.`p_s02` AS `p_s02`,`order_cat_doc_mix`.`p_s03` AS `p_s03`,`order_cat_doc_mix`.`p_s04` AS `p_s04`,`order_cat_doc_mix`.`p_s05` AS `p_s05`,`order_cat_doc_mix`.`p_s06` AS `p_s06`,`order_cat_doc_mix`.`p_s07` AS `p_s07`,`order_cat_doc_mix`.`p_s08` AS `p_s08`,`order_cat_doc_mix`.`p_s09` AS `p_s09`,`order_cat_doc_mix`.`p_s10` AS `p_s10`,`order_cat_doc_mix`.`p_s11` AS `p_s11`,`order_cat_doc_mix`.`p_s12` AS `p_s12`,`order_cat_doc_mix`.`p_s13` AS `p_s13`,`order_cat_doc_mix`.`p_s14` AS `p_s14`,`order_cat_doc_mix`.`p_s15` AS `p_s15`,`order_cat_doc_mix`.`p_s16` AS `p_s16`,`order_cat_doc_mix`.`p_s17` AS `p_s17`,`order_cat_doc_mix`.`p_s18` AS `p_s18`,`order_cat_doc_mix`.`p_s19` AS `p_s19`,`order_cat_doc_mix`.`p_s20` AS `p_s20`,`order_cat_doc_mix`.`p_s21` AS `p_s21`,`order_cat_doc_mix`.`p_s22` AS `p_s22`,`order_cat_doc_mix`.`p_s23` AS `p_s23`,`order_cat_doc_mix`.`p_s24` AS `p_s24`,`order_cat_doc_mix`.`p_s25` AS `p_s25`,`order_cat_doc_mix`.`p_s26` AS `p_s26`,`order_cat_doc_mix`.`p_s27` AS `p_s27`,`order_cat_doc_mix`.`p_s28` AS `p_s28`,`order_cat_doc_mix`.`p_s29` AS `p_s29`,`order_cat_doc_mix`.`p_s30` AS `p_s30`,`order_cat_doc_mix`.`p_s31` AS `p_s31`,`order_cat_doc_mix`.`p_s32` AS `p_s32`,`order_cat_doc_mix`.`p_s33` AS `p_s33`,`order_cat_doc_mix`.`p_s34` AS `p_s34`,`order_cat_doc_mix`.`p_s35` AS `p_s35`,`order_cat_doc_mix`.`p_s36` AS `p_s36`,`order_cat_doc_mix`.`p_s37` AS `p_s37`,`order_cat_doc_mix`.`p_s38` AS `p_s38`,`order_cat_doc_mix`.`p_s39` AS `p_s39`,`order_cat_doc_mix`.`p_s40` AS `p_s40`,`order_cat_doc_mix`.`p_s41` AS `p_s41`,`order_cat_doc_mix`.`p_s42` AS `p_s42`,`order_cat_doc_mix`.`p_s43` AS `p_s43`,`order_cat_doc_mix`.`p_s44` AS `p_s44`,`order_cat_doc_mix`.`p_s45` AS `p_s45`,`order_cat_doc_mix`.`p_s46` AS `p_s46`,`order_cat_doc_mix`.`p_s47` AS `p_s47`,`order_cat_doc_mix`.`p_s48` AS `p_s48`,`order_cat_doc_mix`.`p_s49` AS `p_s49`,`order_cat_doc_mix`.`p_s50` AS `p_s50`,`order_cat_doc_mix`.`rm_date` AS `rm_date`,`order_cat_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_doc_mix`.`plan_module` AS `plan_module`,`order_cat_doc_mix`.`category` AS `category`,`order_cat_doc_mix`.`color_code` AS `color_code`,`order_cat_doc_mix`.`fabric_status` AS `fabric_status`,round(`order_cat_doc_mix`.`a_plies` * `maker_stat_log`.`mklength` * (1 + `cuttable_stat_log`.`cuttable_wastage`),2) + (`order_cat_doc_mix`.`a_xs` + `order_cat_doc_mix`.`a_s` + `order_cat_doc_mix`.`a_m` + `order_cat_doc_mix`.`a_l` + `order_cat_doc_mix`.`a_xl` + `order_cat_doc_mix`.`a_xxl` + `order_cat_doc_mix`.`a_xxxl` + `order_cat_doc_mix`.`a_s01` + `order_cat_doc_mix`.`a_s02` + `order_cat_doc_mix`.`a_s03` + `order_cat_doc_mix`.`a_s04` + `order_cat_doc_mix`.`a_s05` + `order_cat_doc_mix`.`a_s06` + `order_cat_doc_mix`.`a_s07` + `order_cat_doc_mix`.`a_s08` + `order_cat_doc_mix`.`a_s09` + `order_cat_doc_mix`.`a_s10` + `order_cat_doc_mix`.`a_s11` + `order_cat_doc_mix`.`a_s12` + `order_cat_doc_mix`.`a_s13` + `order_cat_doc_mix`.`a_s14` + `order_cat_doc_mix`.`a_s15` + `order_cat_doc_mix`.`a_s16` + `order_cat_doc_mix`.`a_s17` + `order_cat_doc_mix`.`a_s18` + `order_cat_doc_mix`.`a_s19` + `order_cat_doc_mix`.`a_s20` + `order_cat_doc_mix`.`a_s21` + `order_cat_doc_mix`.`a_s22` + `order_cat_doc_mix`.`a_s23` + `order_cat_doc_mix`.`a_s24` + `order_cat_doc_mix`.`a_s25` + `order_cat_doc_mix`.`a_s26` + `order_cat_doc_mix`.`a_s27` + `order_cat_doc_mix`.`a_s28` + `order_cat_doc_mix`.`a_s29` + `order_cat_doc_mix`.`a_s30` + `order_cat_doc_mix`.`a_s31` + `order_cat_doc_mix`.`a_s32` + `order_cat_doc_mix`.`a_s33` + `order_cat_doc_mix`.`a_s34` + `order_cat_doc_mix`.`a_s35` + `order_cat_doc_mix`.`a_s36` + `order_cat_doc_mix`.`a_s37` + `order_cat_doc_mix`.`a_s38` + `order_cat_doc_mix`.`a_s39` + `order_cat_doc_mix`.`a_s40` + `order_cat_doc_mix`.`a_s41` + `order_cat_doc_mix`.`a_s42` + `order_cat_doc_mix`.`a_s43` + `order_cat_doc_mix`.`a_s44` + `order_cat_doc_mix`.`a_s45` + `order_cat_doc_mix`.`a_s46` + `order_cat_doc_mix`.`a_s47` + `order_cat_doc_mix`.`a_s48` + `order_cat_doc_mix`.`a_s49` + `order_cat_doc_mix`.`a_s50`) * `order_cat_doc_mix`.`a_plies` * `fn_know_binding_con`(`maker_stat_log`.`order_tid`) AS `material_req`,`order_cat_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_doc_mix`.`order_col_des` AS `order_col_des`,`order_cat_doc_mix`.`plan_lot_ref` AS `plan_lot_ref` from ((`order_cat_doc_mix` left join `maker_stat_log` on(`order_cat_doc_mix`.`mk_ref` = `maker_stat_log`.`tid`)) left join `cuttable_stat_log` on(`cuttable_stat_log`.`cat_id` = `order_cat_doc_mix`.`cat_ref`))) */;

/*View structure for view order_cat_doc_mk_mix_v2 */

/*!50001 DROP TABLE IF EXISTS `order_cat_doc_mk_mix_v2` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_doc_mk_mix_v2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_doc_mk_mix_v2` AS (select `order_cat_doc_mix`.`catyy` AS `catyy`,`order_cat_doc_mix`.`cat_patt_ver` AS `cat_patt_ver`,`maker_stat_log`.`remarks` AS `mk_file`,`maker_stat_log`.`mk_ver` AS `mk_ver`,`maker_stat_log`.`mklength` AS `mklength`,`order_cat_doc_mix`.`style_id` AS `style_id`,`order_cat_doc_mix`.`col_des` AS `col_des`,`order_cat_doc_mix`.`gmtway` AS `gmtway`,`order_cat_doc_mix`.`strip_match` AS `strip_match`,`order_cat_doc_mix`.`fab_des` AS `fab_des`,`order_cat_doc_mix`.`clubbing` AS `clubbing`,`order_cat_doc_mix`.`date` AS `date`,`order_cat_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_doc_mix`.`compo_no` AS `compo_no`,`order_cat_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_doc_mix`.`order_tid` AS `order_tid`,`order_cat_doc_mix`.`pcutno` AS `pcutno`,`order_cat_doc_mix`.`ratio` AS `ratio`,`order_cat_doc_mix`.`p_xs` AS `p_xs`,`order_cat_doc_mix`.`p_s` AS `p_s`,`order_cat_doc_mix`.`p_m` AS `p_m`,`order_cat_doc_mix`.`p_l` AS `p_l`,`order_cat_doc_mix`.`p_xl` AS `p_xl`,`order_cat_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_doc_mix`.`p_plies` AS `p_plies`,`order_cat_doc_mix`.`doc_no` AS `doc_no`,`order_cat_doc_mix`.`acutno` AS `acutno`,`order_cat_doc_mix`.`a_xs` AS `a_xs`,`order_cat_doc_mix`.`a_s` AS `a_s`,`order_cat_doc_mix`.`a_m` AS `a_m`,`order_cat_doc_mix`.`a_l` AS `a_l`,`order_cat_doc_mix`.`a_xl` AS `a_xl`,`order_cat_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_doc_mix`.`a_plies` AS `a_plies`,`order_cat_doc_mix`.`lastup` AS `lastup`,`order_cat_doc_mix`.`remarks` AS `remarks`,`order_cat_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_doc_mix`.`print_status` AS `print_status`,`order_cat_doc_mix`.`a_s01` AS `a_s01`,`order_cat_doc_mix`.`a_s02` AS `a_s02`,`order_cat_doc_mix`.`a_s03` AS `a_s03`,`order_cat_doc_mix`.`a_s04` AS `a_s04`,`order_cat_doc_mix`.`a_s05` AS `a_s05`,`order_cat_doc_mix`.`a_s06` AS `a_s06`,`order_cat_doc_mix`.`a_s07` AS `a_s07`,`order_cat_doc_mix`.`a_s08` AS `a_s08`,`order_cat_doc_mix`.`a_s09` AS `a_s09`,`order_cat_doc_mix`.`a_s10` AS `a_s10`,`order_cat_doc_mix`.`a_s11` AS `a_s11`,`order_cat_doc_mix`.`a_s12` AS `a_s12`,`order_cat_doc_mix`.`a_s13` AS `a_s13`,`order_cat_doc_mix`.`a_s14` AS `a_s14`,`order_cat_doc_mix`.`a_s15` AS `a_s15`,`order_cat_doc_mix`.`a_s16` AS `a_s16`,`order_cat_doc_mix`.`a_s17` AS `a_s17`,`order_cat_doc_mix`.`a_s18` AS `a_s18`,`order_cat_doc_mix`.`a_s19` AS `a_s19`,`order_cat_doc_mix`.`a_s20` AS `a_s20`,`order_cat_doc_mix`.`a_s21` AS `a_s21`,`order_cat_doc_mix`.`a_s22` AS `a_s22`,`order_cat_doc_mix`.`a_s23` AS `a_s23`,`order_cat_doc_mix`.`a_s24` AS `a_s24`,`order_cat_doc_mix`.`a_s25` AS `a_s25`,`order_cat_doc_mix`.`a_s26` AS `a_s26`,`order_cat_doc_mix`.`a_s27` AS `a_s27`,`order_cat_doc_mix`.`a_s28` AS `a_s28`,`order_cat_doc_mix`.`a_s29` AS `a_s29`,`order_cat_doc_mix`.`a_s30` AS `a_s30`,`order_cat_doc_mix`.`a_s31` AS `a_s31`,`order_cat_doc_mix`.`a_s32` AS `a_s32`,`order_cat_doc_mix`.`a_s33` AS `a_s33`,`order_cat_doc_mix`.`a_s34` AS `a_s34`,`order_cat_doc_mix`.`a_s35` AS `a_s35`,`order_cat_doc_mix`.`a_s36` AS `a_s36`,`order_cat_doc_mix`.`a_s37` AS `a_s37`,`order_cat_doc_mix`.`a_s38` AS `a_s38`,`order_cat_doc_mix`.`a_s39` AS `a_s39`,`order_cat_doc_mix`.`a_s40` AS `a_s40`,`order_cat_doc_mix`.`a_s41` AS `a_s41`,`order_cat_doc_mix`.`a_s42` AS `a_s42`,`order_cat_doc_mix`.`a_s43` AS `a_s43`,`order_cat_doc_mix`.`a_s44` AS `a_s44`,`order_cat_doc_mix`.`a_s45` AS `a_s45`,`order_cat_doc_mix`.`a_s46` AS `a_s46`,`order_cat_doc_mix`.`a_s47` AS `a_s47`,`order_cat_doc_mix`.`a_s48` AS `a_s48`,`order_cat_doc_mix`.`a_s49` AS `a_s49`,`order_cat_doc_mix`.`a_s50` AS `a_s50`,`order_cat_doc_mix`.`p_s01` AS `p_s01`,`order_cat_doc_mix`.`p_s02` AS `p_s02`,`order_cat_doc_mix`.`p_s03` AS `p_s03`,`order_cat_doc_mix`.`p_s04` AS `p_s04`,`order_cat_doc_mix`.`p_s05` AS `p_s05`,`order_cat_doc_mix`.`p_s06` AS `p_s06`,`order_cat_doc_mix`.`p_s07` AS `p_s07`,`order_cat_doc_mix`.`p_s08` AS `p_s08`,`order_cat_doc_mix`.`p_s09` AS `p_s09`,`order_cat_doc_mix`.`p_s10` AS `p_s10`,`order_cat_doc_mix`.`p_s11` AS `p_s11`,`order_cat_doc_mix`.`p_s12` AS `p_s12`,`order_cat_doc_mix`.`p_s13` AS `p_s13`,`order_cat_doc_mix`.`p_s14` AS `p_s14`,`order_cat_doc_mix`.`p_s15` AS `p_s15`,`order_cat_doc_mix`.`p_s16` AS `p_s16`,`order_cat_doc_mix`.`p_s17` AS `p_s17`,`order_cat_doc_mix`.`p_s18` AS `p_s18`,`order_cat_doc_mix`.`p_s19` AS `p_s19`,`order_cat_doc_mix`.`p_s20` AS `p_s20`,`order_cat_doc_mix`.`p_s21` AS `p_s21`,`order_cat_doc_mix`.`p_s22` AS `p_s22`,`order_cat_doc_mix`.`p_s23` AS `p_s23`,`order_cat_doc_mix`.`p_s24` AS `p_s24`,`order_cat_doc_mix`.`p_s25` AS `p_s25`,`order_cat_doc_mix`.`p_s26` AS `p_s26`,`order_cat_doc_mix`.`p_s27` AS `p_s27`,`order_cat_doc_mix`.`p_s28` AS `p_s28`,`order_cat_doc_mix`.`p_s29` AS `p_s29`,`order_cat_doc_mix`.`p_s30` AS `p_s30`,`order_cat_doc_mix`.`p_s31` AS `p_s31`,`order_cat_doc_mix`.`p_s32` AS `p_s32`,`order_cat_doc_mix`.`p_s33` AS `p_s33`,`order_cat_doc_mix`.`p_s34` AS `p_s34`,`order_cat_doc_mix`.`p_s35` AS `p_s35`,`order_cat_doc_mix`.`p_s36` AS `p_s36`,`order_cat_doc_mix`.`p_s37` AS `p_s37`,`order_cat_doc_mix`.`p_s38` AS `p_s38`,`order_cat_doc_mix`.`p_s39` AS `p_s39`,`order_cat_doc_mix`.`p_s40` AS `p_s40`,`order_cat_doc_mix`.`p_s41` AS `p_s41`,`order_cat_doc_mix`.`p_s42` AS `p_s42`,`order_cat_doc_mix`.`p_s43` AS `p_s43`,`order_cat_doc_mix`.`p_s44` AS `p_s44`,`order_cat_doc_mix`.`p_s45` AS `p_s45`,`order_cat_doc_mix`.`p_s46` AS `p_s46`,`order_cat_doc_mix`.`p_s47` AS `p_s47`,`order_cat_doc_mix`.`p_s48` AS `p_s48`,`order_cat_doc_mix`.`p_s49` AS `p_s49`,`order_cat_doc_mix`.`p_s50` AS `p_s50`,`order_cat_doc_mix`.`rm_date` AS `rm_date`,`order_cat_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_doc_mix`.`plan_module` AS `plan_module`,`order_cat_doc_mix`.`category` AS `category`,`order_cat_doc_mix`.`color_code` AS `color_code`,`order_cat_doc_mix`.`fabric_status` AS `fabric_status`,round(`order_cat_doc_mix`.`a_plies` * `maker_stat_log`.`mklength` * (1 + `cuttable_stat_log`.`cuttable_wastage`),2) + (`order_cat_doc_mix`.`a_xs` + `order_cat_doc_mix`.`a_s` + `order_cat_doc_mix`.`a_m` + `order_cat_doc_mix`.`a_l` + `order_cat_doc_mix`.`a_xl` + `order_cat_doc_mix`.`a_xxl` + `order_cat_doc_mix`.`a_xxxl` + `order_cat_doc_mix`.`a_s01` + `order_cat_doc_mix`.`a_s02` + `order_cat_doc_mix`.`a_s03` + `order_cat_doc_mix`.`a_s04` + `order_cat_doc_mix`.`a_s05` + `order_cat_doc_mix`.`a_s06` + `order_cat_doc_mix`.`a_s07` + `order_cat_doc_mix`.`a_s08` + `order_cat_doc_mix`.`a_s09` + `order_cat_doc_mix`.`a_s10` + `order_cat_doc_mix`.`a_s11` + `order_cat_doc_mix`.`a_s12` + `order_cat_doc_mix`.`a_s13` + `order_cat_doc_mix`.`a_s14` + `order_cat_doc_mix`.`a_s15` + `order_cat_doc_mix`.`a_s16` + `order_cat_doc_mix`.`a_s17` + `order_cat_doc_mix`.`a_s18` + `order_cat_doc_mix`.`a_s19` + `order_cat_doc_mix`.`a_s20` + `order_cat_doc_mix`.`a_s21` + `order_cat_doc_mix`.`a_s22` + `order_cat_doc_mix`.`a_s23` + `order_cat_doc_mix`.`a_s24` + `order_cat_doc_mix`.`a_s25` + `order_cat_doc_mix`.`a_s26` + `order_cat_doc_mix`.`a_s27` + `order_cat_doc_mix`.`a_s28` + `order_cat_doc_mix`.`a_s29` + `order_cat_doc_mix`.`a_s30` + `order_cat_doc_mix`.`a_s31` + `order_cat_doc_mix`.`a_s32` + `order_cat_doc_mix`.`a_s33` + `order_cat_doc_mix`.`a_s34` + `order_cat_doc_mix`.`a_s35` + `order_cat_doc_mix`.`a_s36` + `order_cat_doc_mix`.`a_s37` + `order_cat_doc_mix`.`a_s38` + `order_cat_doc_mix`.`a_s39` + `order_cat_doc_mix`.`a_s40` + `order_cat_doc_mix`.`a_s41` + `order_cat_doc_mix`.`a_s42` + `order_cat_doc_mix`.`a_s43` + `order_cat_doc_mix`.`a_s44` + `order_cat_doc_mix`.`a_s45` + `order_cat_doc_mix`.`a_s46` + `order_cat_doc_mix`.`a_s47` + `order_cat_doc_mix`.`a_s48` + `order_cat_doc_mix`.`a_s49` + `order_cat_doc_mix`.`a_s50`) * `order_cat_doc_mix`.`a_plies` * `fn_know_binding_con_v2`(`maker_stat_log`.`order_tid`,`order_cat_doc_mix`.`category`) AS `material_req`,`order_cat_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_doc_mix`.`order_col_des` AS `order_col_des`,`order_cat_doc_mix`.`plan_lot_ref` AS `plan_lot_ref` from ((`order_cat_doc_mix` left join `maker_stat_log` on(`order_cat_doc_mix`.`mk_ref` = `maker_stat_log`.`tid`)) left join `cuttable_stat_log` on(`cuttable_stat_log`.`cat_id` = `order_cat_doc_mix`.`cat_ref`))) */;

/*View structure for view order_cat_recut_doc_mix */

/*!50001 DROP TABLE IF EXISTS `order_cat_recut_doc_mix` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_recut_doc_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_recut_doc_mix` AS (select `recut_v2`.`date` AS `date`,`recut_v2`.`cat_ref` AS `cat_ref`,`recut_v2`.`cuttable_ref` AS `cuttable_ref`,`recut_v2`.`allocate_ref` AS `allocate_ref`,`recut_v2`.`mk_ref` AS `mk_ref`,`recut_v2`.`order_tid` AS `order_tid`,`recut_v2`.`pcutno` AS `pcutno`,`recut_v2`.`ratio` AS `ratio`,`recut_v2`.`p_xs` AS `p_xs`,`recut_v2`.`p_s` AS `p_s`,`recut_v2`.`p_m` AS `p_m`,`recut_v2`.`p_l` AS `p_l`,`recut_v2`.`p_xl` AS `p_xl`,`recut_v2`.`p_xxl` AS `p_xxl`,`recut_v2`.`p_xxxl` AS `p_xxxl`,`recut_v2`.`p_plies` AS `p_plies`,`recut_v2`.`doc_no` AS `doc_no`,`recut_v2`.`acutno` AS `acutno`,`recut_v2`.`a_xs` AS `a_xs`,`recut_v2`.`a_s` AS `a_s`,`recut_v2`.`a_m` AS `a_m`,`recut_v2`.`a_l` AS `a_l`,`recut_v2`.`a_xl` AS `a_xl`,`recut_v2`.`a_xxl` AS `a_xxl`,`recut_v2`.`a_xxxl` AS `a_xxxl`,`recut_v2`.`a_plies` AS `a_plies`,`recut_v2`.`lastup` AS `lastup`,`recut_v2`.`remarks` AS `remarks`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`act_cut_issue_status` AS `act_cut_issue_status`,`recut_v2`.`pcutdocid` AS `pcutdocid`,`recut_v2`.`print_status` AS `print_status`,`recut_v2`.`a_s01` AS `a_s01`,`recut_v2`.`a_s02` AS `a_s02`,`recut_v2`.`a_s03` AS `a_s03`,`recut_v2`.`a_s04` AS `a_s04`,`recut_v2`.`a_s05` AS `a_s05`,`recut_v2`.`a_s06` AS `a_s06`,`recut_v2`.`a_s07` AS `a_s07`,`recut_v2`.`a_s08` AS `a_s08`,`recut_v2`.`a_s09` AS `a_s09`,`recut_v2`.`a_s10` AS `a_s10`,`recut_v2`.`a_s11` AS `a_s11`,`recut_v2`.`a_s12` AS `a_s12`,`recut_v2`.`a_s13` AS `a_s13`,`recut_v2`.`a_s14` AS `a_s14`,`recut_v2`.`a_s15` AS `a_s15`,`recut_v2`.`a_s16` AS `a_s16`,`recut_v2`.`a_s17` AS `a_s17`,`recut_v2`.`a_s18` AS `a_s18`,`recut_v2`.`a_s19` AS `a_s19`,`recut_v2`.`a_s20` AS `a_s20`,`recut_v2`.`a_s21` AS `a_s21`,`recut_v2`.`a_s22` AS `a_s22`,`recut_v2`.`a_s23` AS `a_s23`,`recut_v2`.`a_s24` AS `a_s24`,`recut_v2`.`a_s25` AS `a_s25`,`recut_v2`.`a_s26` AS `a_s26`,`recut_v2`.`a_s27` AS `a_s27`,`recut_v2`.`a_s28` AS `a_s28`,`recut_v2`.`a_s29` AS `a_s29`,`recut_v2`.`a_s30` AS `a_s30`,`recut_v2`.`a_s31` AS `a_s31`,`recut_v2`.`a_s32` AS `a_s32`,`recut_v2`.`a_s33` AS `a_s33`,`recut_v2`.`a_s34` AS `a_s34`,`recut_v2`.`a_s35` AS `a_s35`,`recut_v2`.`a_s36` AS `a_s36`,`recut_v2`.`a_s37` AS `a_s37`,`recut_v2`.`a_s38` AS `a_s38`,`recut_v2`.`a_s39` AS `a_s39`,`recut_v2`.`a_s40` AS `a_s40`,`recut_v2`.`a_s41` AS `a_s41`,`recut_v2`.`a_s42` AS `a_s42`,`recut_v2`.`a_s43` AS `a_s43`,`recut_v2`.`a_s44` AS `a_s44`,`recut_v2`.`a_s45` AS `a_s45`,`recut_v2`.`a_s46` AS `a_s46`,`recut_v2`.`a_s47` AS `a_s47`,`recut_v2`.`a_s48` AS `a_s48`,`recut_v2`.`a_s49` AS `a_s49`,`recut_v2`.`a_s50` AS `a_s50`,`recut_v2`.`p_s01` AS `p_s01`,`recut_v2`.`p_s02` AS `p_s02`,`recut_v2`.`p_s03` AS `p_s03`,`recut_v2`.`p_s04` AS `p_s04`,`recut_v2`.`p_s05` AS `p_s05`,`recut_v2`.`p_s06` AS `p_s06`,`recut_v2`.`p_s07` AS `p_s07`,`recut_v2`.`p_s08` AS `p_s08`,`recut_v2`.`p_s09` AS `p_s09`,`recut_v2`.`p_s10` AS `p_s10`,`recut_v2`.`p_s11` AS `p_s11`,`recut_v2`.`p_s12` AS `p_s12`,`recut_v2`.`p_s13` AS `p_s13`,`recut_v2`.`p_s14` AS `p_s14`,`recut_v2`.`p_s15` AS `p_s15`,`recut_v2`.`p_s16` AS `p_s16`,`recut_v2`.`p_s17` AS `p_s17`,`recut_v2`.`p_s18` AS `p_s18`,`recut_v2`.`p_s19` AS `p_s19`,`recut_v2`.`p_s20` AS `p_s20`,`recut_v2`.`p_s21` AS `p_s21`,`recut_v2`.`p_s22` AS `p_s22`,`recut_v2`.`p_s23` AS `p_s23`,`recut_v2`.`p_s24` AS `p_s24`,`recut_v2`.`p_s25` AS `p_s25`,`recut_v2`.`p_s26` AS `p_s26`,`recut_v2`.`p_s27` AS `p_s27`,`recut_v2`.`p_s28` AS `p_s28`,`recut_v2`.`p_s29` AS `p_s29`,`recut_v2`.`p_s30` AS `p_s30`,`recut_v2`.`p_s31` AS `p_s31`,`recut_v2`.`p_s32` AS `p_s32`,`recut_v2`.`p_s33` AS `p_s33`,`recut_v2`.`p_s34` AS `p_s34`,`recut_v2`.`p_s35` AS `p_s35`,`recut_v2`.`p_s36` AS `p_s36`,`recut_v2`.`p_s37` AS `p_s37`,`recut_v2`.`p_s38` AS `p_s38`,`recut_v2`.`p_s39` AS `p_s39`,`recut_v2`.`p_s40` AS `p_s40`,`recut_v2`.`p_s41` AS `p_s41`,`recut_v2`.`p_s42` AS `p_s42`,`recut_v2`.`p_s43` AS `p_s43`,`recut_v2`.`p_s44` AS `p_s44`,`recut_v2`.`p_s45` AS `p_s45`,`recut_v2`.`p_s46` AS `p_s46`,`recut_v2`.`p_s47` AS `p_s47`,`recut_v2`.`p_s48` AS `p_s48`,`recut_v2`.`p_s49` AS `p_s49`,`recut_v2`.`p_s50` AS `p_s50`,`recut_v2`.`rm_date` AS `rm_date`,`recut_v2`.`cut_inp_temp` AS `cut_inp_temp`,`recut_v2`.`plan_module` AS `plan_module`,`cat_stat_log`.`category` AS `category`,`bai_orders_db`.`color_code` AS `color_code`,`recut_v2`.`fabric_status` AS `fabric_status`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`recut_v2`.`plan_lot_ref` AS `plan_lot_ref`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_orders_db`.`order_style_no` AS `order_style_no` from ((`recut_v2` left join `cat_stat_log` on(`recut_v2`.`cat_ref` = `cat_stat_log`.`tid`)) left join `bai_orders_db` on(`recut_v2`.`order_tid` = `bai_orders_db`.`order_tid`))) */;

/*View structure for view order_cat_recut_doc_mk_mix */

/*!50001 DROP TABLE IF EXISTS `order_cat_recut_doc_mk_mix` */;
/*!50001 DROP VIEW IF EXISTS `order_cat_recut_doc_mk_mix` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_recut_doc_mk_mix` AS (select `order_cat_recut_doc_mix`.`date` AS `date`,`order_cat_recut_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_recut_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_recut_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_recut_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_recut_doc_mix`.`order_tid` AS `order_tid`,`order_cat_recut_doc_mix`.`pcutno` AS `pcutno`,`order_cat_recut_doc_mix`.`ratio` AS `ratio`,`order_cat_recut_doc_mix`.`p_xs` AS `p_xs`,`order_cat_recut_doc_mix`.`p_s` AS `p_s`,`order_cat_recut_doc_mix`.`p_m` AS `p_m`,`order_cat_recut_doc_mix`.`p_l` AS `p_l`,`order_cat_recut_doc_mix`.`p_xl` AS `p_xl`,`order_cat_recut_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_recut_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_recut_doc_mix`.`p_plies` AS `p_plies`,`order_cat_recut_doc_mix`.`doc_no` AS `doc_no`,`order_cat_recut_doc_mix`.`acutno` AS `acutno`,`order_cat_recut_doc_mix`.`a_xs` AS `a_xs`,`order_cat_recut_doc_mix`.`a_s` AS `a_s`,`order_cat_recut_doc_mix`.`a_m` AS `a_m`,`order_cat_recut_doc_mix`.`a_l` AS `a_l`,`order_cat_recut_doc_mix`.`a_xl` AS `a_xl`,`order_cat_recut_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_recut_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_recut_doc_mix`.`a_plies` AS `a_plies`,`order_cat_recut_doc_mix`.`lastup` AS `lastup`,`order_cat_recut_doc_mix`.`remarks` AS `remarks`,`order_cat_recut_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_recut_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_recut_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_recut_doc_mix`.`print_status` AS `print_status`,`order_cat_recut_doc_mix`.`a_s01` AS `a_s01`,`order_cat_recut_doc_mix`.`a_s02` AS `a_s02`,`order_cat_recut_doc_mix`.`a_s03` AS `a_s03`,`order_cat_recut_doc_mix`.`a_s04` AS `a_s04`,`order_cat_recut_doc_mix`.`a_s05` AS `a_s05`,`order_cat_recut_doc_mix`.`a_s06` AS `a_s06`,`order_cat_recut_doc_mix`.`a_s07` AS `a_s07`,`order_cat_recut_doc_mix`.`a_s08` AS `a_s08`,`order_cat_recut_doc_mix`.`a_s09` AS `a_s09`,`order_cat_recut_doc_mix`.`a_s10` AS `a_s10`,`order_cat_recut_doc_mix`.`a_s11` AS `a_s11`,`order_cat_recut_doc_mix`.`a_s12` AS `a_s12`,`order_cat_recut_doc_mix`.`a_s13` AS `a_s13`,`order_cat_recut_doc_mix`.`a_s14` AS `a_s14`,`order_cat_recut_doc_mix`.`a_s15` AS `a_s15`,`order_cat_recut_doc_mix`.`a_s16` AS `a_s16`,`order_cat_recut_doc_mix`.`a_s17` AS `a_s17`,`order_cat_recut_doc_mix`.`a_s18` AS `a_s18`,`order_cat_recut_doc_mix`.`a_s19` AS `a_s19`,`order_cat_recut_doc_mix`.`a_s20` AS `a_s20`,`order_cat_recut_doc_mix`.`a_s21` AS `a_s21`,`order_cat_recut_doc_mix`.`a_s22` AS `a_s22`,`order_cat_recut_doc_mix`.`a_s23` AS `a_s23`,`order_cat_recut_doc_mix`.`a_s24` AS `a_s24`,`order_cat_recut_doc_mix`.`a_s25` AS `a_s25`,`order_cat_recut_doc_mix`.`a_s26` AS `a_s26`,`order_cat_recut_doc_mix`.`a_s27` AS `a_s27`,`order_cat_recut_doc_mix`.`a_s28` AS `a_s28`,`order_cat_recut_doc_mix`.`a_s29` AS `a_s29`,`order_cat_recut_doc_mix`.`a_s30` AS `a_s30`,`order_cat_recut_doc_mix`.`a_s31` AS `a_s31`,`order_cat_recut_doc_mix`.`a_s32` AS `a_s32`,`order_cat_recut_doc_mix`.`a_s33` AS `a_s33`,`order_cat_recut_doc_mix`.`a_s34` AS `a_s34`,`order_cat_recut_doc_mix`.`a_s35` AS `a_s35`,`order_cat_recut_doc_mix`.`a_s36` AS `a_s36`,`order_cat_recut_doc_mix`.`a_s37` AS `a_s37`,`order_cat_recut_doc_mix`.`a_s38` AS `a_s38`,`order_cat_recut_doc_mix`.`a_s39` AS `a_s39`,`order_cat_recut_doc_mix`.`a_s40` AS `a_s40`,`order_cat_recut_doc_mix`.`a_s41` AS `a_s41`,`order_cat_recut_doc_mix`.`a_s42` AS `a_s42`,`order_cat_recut_doc_mix`.`a_s43` AS `a_s43`,`order_cat_recut_doc_mix`.`a_s44` AS `a_s44`,`order_cat_recut_doc_mix`.`a_s45` AS `a_s45`,`order_cat_recut_doc_mix`.`a_s46` AS `a_s46`,`order_cat_recut_doc_mix`.`a_s47` AS `a_s47`,`order_cat_recut_doc_mix`.`a_s48` AS `a_s48`,`order_cat_recut_doc_mix`.`a_s49` AS `a_s49`,`order_cat_recut_doc_mix`.`a_s50` AS `a_s50`,`order_cat_recut_doc_mix`.`p_s01` AS `p_s01`,`order_cat_recut_doc_mix`.`p_s02` AS `p_s02`,`order_cat_recut_doc_mix`.`p_s03` AS `p_s03`,`order_cat_recut_doc_mix`.`p_s04` AS `p_s04`,`order_cat_recut_doc_mix`.`p_s05` AS `p_s05`,`order_cat_recut_doc_mix`.`p_s06` AS `p_s06`,`order_cat_recut_doc_mix`.`p_s07` AS `p_s07`,`order_cat_recut_doc_mix`.`p_s08` AS `p_s08`,`order_cat_recut_doc_mix`.`p_s09` AS `p_s09`,`order_cat_recut_doc_mix`.`p_s10` AS `p_s10`,`order_cat_recut_doc_mix`.`p_s11` AS `p_s11`,`order_cat_recut_doc_mix`.`p_s12` AS `p_s12`,`order_cat_recut_doc_mix`.`p_s13` AS `p_s13`,`order_cat_recut_doc_mix`.`p_s14` AS `p_s14`,`order_cat_recut_doc_mix`.`p_s15` AS `p_s15`,`order_cat_recut_doc_mix`.`p_s16` AS `p_s16`,`order_cat_recut_doc_mix`.`p_s17` AS `p_s17`,`order_cat_recut_doc_mix`.`p_s18` AS `p_s18`,`order_cat_recut_doc_mix`.`p_s19` AS `p_s19`,`order_cat_recut_doc_mix`.`p_s20` AS `p_s20`,`order_cat_recut_doc_mix`.`p_s21` AS `p_s21`,`order_cat_recut_doc_mix`.`p_s22` AS `p_s22`,`order_cat_recut_doc_mix`.`p_s23` AS `p_s23`,`order_cat_recut_doc_mix`.`p_s24` AS `p_s24`,`order_cat_recut_doc_mix`.`p_s25` AS `p_s25`,`order_cat_recut_doc_mix`.`p_s26` AS `p_s26`,`order_cat_recut_doc_mix`.`p_s27` AS `p_s27`,`order_cat_recut_doc_mix`.`p_s28` AS `p_s28`,`order_cat_recut_doc_mix`.`p_s29` AS `p_s29`,`order_cat_recut_doc_mix`.`p_s30` AS `p_s30`,`order_cat_recut_doc_mix`.`p_s31` AS `p_s31`,`order_cat_recut_doc_mix`.`p_s32` AS `p_s32`,`order_cat_recut_doc_mix`.`p_s33` AS `p_s33`,`order_cat_recut_doc_mix`.`p_s34` AS `p_s34`,`order_cat_recut_doc_mix`.`p_s35` AS `p_s35`,`order_cat_recut_doc_mix`.`p_s36` AS `p_s36`,`order_cat_recut_doc_mix`.`p_s37` AS `p_s37`,`order_cat_recut_doc_mix`.`p_s38` AS `p_s38`,`order_cat_recut_doc_mix`.`p_s39` AS `p_s39`,`order_cat_recut_doc_mix`.`p_s40` AS `p_s40`,`order_cat_recut_doc_mix`.`p_s41` AS `p_s41`,`order_cat_recut_doc_mix`.`p_s42` AS `p_s42`,`order_cat_recut_doc_mix`.`p_s43` AS `p_s43`,`order_cat_recut_doc_mix`.`p_s44` AS `p_s44`,`order_cat_recut_doc_mix`.`p_s45` AS `p_s45`,`order_cat_recut_doc_mix`.`p_s46` AS `p_s46`,`order_cat_recut_doc_mix`.`p_s47` AS `p_s47`,`order_cat_recut_doc_mix`.`p_s48` AS `p_s48`,`order_cat_recut_doc_mix`.`p_s49` AS `p_s49`,`order_cat_recut_doc_mix`.`p_s50` AS `p_s50`,`order_cat_recut_doc_mix`.`rm_date` AS `rm_date`,`order_cat_recut_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_recut_doc_mix`.`plan_module` AS `plan_module`,`order_cat_recut_doc_mix`.`category` AS `category`,`order_cat_recut_doc_mix`.`color_code` AS `color_code`,`order_cat_recut_doc_mix`.`fabric_status` AS `fabric_status`,if(`order_cat_recut_doc_mix`.`category` = 'Body' or `order_cat_recut_doc_mix`.`category` = 'Front',round(`order_cat_recut_doc_mix`.`a_plies` * `maker_stat_log`.`mklength`,2) + (`order_cat_recut_doc_mix`.`a_xs` + `order_cat_recut_doc_mix`.`a_s` + `order_cat_recut_doc_mix`.`a_m` + `order_cat_recut_doc_mix`.`a_l` + `order_cat_recut_doc_mix`.`a_xl` + `order_cat_recut_doc_mix`.`a_xxl` + `order_cat_recut_doc_mix`.`a_xxxl` + `order_cat_recut_doc_mix`.`a_s01` + `order_cat_recut_doc_mix`.`a_s02` + `order_cat_recut_doc_mix`.`a_s03` + `order_cat_recut_doc_mix`.`a_s04` + `order_cat_recut_doc_mix`.`a_s05` + `order_cat_recut_doc_mix`.`a_s06` + `order_cat_recut_doc_mix`.`a_s07` + `order_cat_recut_doc_mix`.`a_s08` + `order_cat_recut_doc_mix`.`a_s09` + `order_cat_recut_doc_mix`.`a_s10` + `order_cat_recut_doc_mix`.`a_s11` + `order_cat_recut_doc_mix`.`a_s12` + `order_cat_recut_doc_mix`.`a_s13` + `order_cat_recut_doc_mix`.`a_s14` + `order_cat_recut_doc_mix`.`a_s15` + `order_cat_recut_doc_mix`.`a_s16` + `order_cat_recut_doc_mix`.`a_s17` + `order_cat_recut_doc_mix`.`a_s18` + `order_cat_recut_doc_mix`.`a_s19` + `order_cat_recut_doc_mix`.`a_s20` + `order_cat_recut_doc_mix`.`a_s21` + `order_cat_recut_doc_mix`.`a_s22` + `order_cat_recut_doc_mix`.`a_s23` + `order_cat_recut_doc_mix`.`a_s24` + `order_cat_recut_doc_mix`.`a_s25` + `order_cat_recut_doc_mix`.`a_s26` + `order_cat_recut_doc_mix`.`a_s27` + `order_cat_recut_doc_mix`.`a_s28` + `order_cat_recut_doc_mix`.`a_s29` + `order_cat_recut_doc_mix`.`a_s30` + `order_cat_recut_doc_mix`.`a_s31` + `order_cat_recut_doc_mix`.`a_s32` + `order_cat_recut_doc_mix`.`a_s33` + `order_cat_recut_doc_mix`.`a_s34` + `order_cat_recut_doc_mix`.`a_s35` + `order_cat_recut_doc_mix`.`a_s36` + `order_cat_recut_doc_mix`.`a_s37` + `order_cat_recut_doc_mix`.`a_s38` + `order_cat_recut_doc_mix`.`a_s39` + `order_cat_recut_doc_mix`.`a_s40` + `order_cat_recut_doc_mix`.`a_s41` + `order_cat_recut_doc_mix`.`a_s42` + `order_cat_recut_doc_mix`.`a_s43` + `order_cat_recut_doc_mix`.`a_s44` + `order_cat_recut_doc_mix`.`a_s45` + `order_cat_recut_doc_mix`.`a_s46` + `order_cat_recut_doc_mix`.`a_s47` + `order_cat_recut_doc_mix`.`a_s48` + `order_cat_recut_doc_mix`.`a_s49` + `order_cat_recut_doc_mix`.`a_s50`) * `order_cat_recut_doc_mix`.`a_plies` * `fn_know_binding_con`(`maker_stat_log`.`order_tid`),round(`order_cat_recut_doc_mix`.`a_plies` * `maker_stat_log`.`mklength`,2)) AS `material_req`,`order_cat_recut_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_recut_doc_mix`.`plan_lot_ref` AS `plan_lot_ref` from (`order_cat_recut_doc_mix` left join `maker_stat_log` on(`order_cat_recut_doc_mix`.`mk_ref` = `maker_stat_log`.`tid`))) */;

/*View structure for view packing_dashboard */

/*!50001 DROP TABLE IF EXISTS `packing_dashboard` */;
/*!50001 DROP VIEW IF EXISTS `packing_dashboard` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard` AS (select min(`pac_stat_log_temp`.`tid`) AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,`pac_stat_log_temp`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where `pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no` and `pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','') and `pac_stat_log_temp`.`disp_carton_no` >= 1 and `ims_log_backup`.`ims_mod_no` <> 0 and `pac_stat_log_temp`.`status` is null group by `pac_stat_log_temp`.`doc_no_ref`) */;

/*View structure for view packing_dashboard_new */

/*!50001 DROP TABLE IF EXISTS `packing_dashboard_new` */;
/*!50001 DROP VIEW IF EXISTS `packing_dashboard_new` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard_new` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,`ims_log_backup`.`ims_qty` AS `ims_qty`,`ims_log_backup`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty_cumm` from `ims_log_backup` where `ims_log_backup`.`ims_mod_no` <> 0 and `ims_log_backup`.`ims_schedule` in (select `packing_pending_schedules`.`order_del_no` AS `order_del_no` from `packing_pending_schedules`) group by `ims_log_backup`.`ims_schedule`,`ims_log_backup`.`ims_size`) */;

/*View structure for view packing_dashboard_new2 */

/*!50001 DROP TABLE IF EXISTS `packing_dashboard_new2` */;
/*!50001 DROP VIEW IF EXISTS `packing_dashboard_new2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard_new2` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty_cumm` from `ims_log_backup` where `ims_log_backup`.`ims_mod_no` <> 0 and `ims_log_backup`.`ims_schedule` in (select `packing_pending_schedules`.`order_del_no` AS `order_del_no` from `packing_pending_schedules`) group by `ims_log_backup`.`ims_doc_no`,`ims_log_backup`.`ims_size`) */;

/*View structure for view packing_dboard_stage1 */

/*!50001 DROP TABLE IF EXISTS `packing_dboard_stage1` */;
/*!50001 DROP VIEW IF EXISTS `packing_dboard_stage1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dboard_stage1` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,if(`pac_stat_log`.`status` = 'DONE',`pac_stat_log`.`carton_act_qty`,0) AS `new` from ((`pac_stat_log` left join `plandoc_stat_log` on(`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))) */;

/*View structure for view packing_issues */

/*!50001 DROP TABLE IF EXISTS `packing_issues` */;
/*!50001 DROP VIEW IF EXISTS `packing_issues` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_issues` AS (select `pac_stat_log_temp`.`tid` AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,round(sum(`pac_stat_log_temp`.`carton_act_qty`) / count(`ims_log_backup`.`ims_doc_no`),0) AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`pac_stat_log_temp`.`disp_id` AS `disp_id`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where `pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no` and `pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','') and `ims_log_backup`.`ims_mod_no` <> 0 and `pac_stat_log_temp`.`status` is null and `pac_stat_log_temp`.`disp_id` = 1 group by `pac_stat_log_temp`.`doc_no_ref`) */;

/*View structure for view packing_pending_schedules */

/*!50001 DROP TABLE IF EXISTS `packing_pending_schedules` */;
/*!50001 DROP VIEW IF EXISTS `packing_pending_schedules` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_pending_schedules` AS (select distinct `packing_summary`.`order_del_no` AS `order_del_no` from `packing_summary` where `packing_summary`.`status` <> 'DONE' or `packing_summary`.`status` is null) */;

/*View structure for view packing_summary */

/*!50001 DROP TABLE IF EXISTS `packing_summary` */;
/*!50001 DROP VIEW IF EXISTS `packing_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno` from ((`pac_stat_log` left join `plandoc_stat_log` on(`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))) */;

/*View structure for view packing_summary_backup */

/*!50001 DROP TABLE IF EXISTS `packing_summary_backup` */;
/*!50001 DROP VIEW IF EXISTS `packing_summary_backup` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_backup` AS (select `pac_stat_log_backup`.`doc_no` AS `doc_no`,`pac_stat_log_backup`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_backup`.`tid` AS `tid`,`pac_stat_log_backup`.`size_code` AS `size_code`,`pac_stat_log_backup`.`remarks` AS `remarks`,`pac_stat_log_backup`.`status` AS `status`,`pac_stat_log_backup`.`lastup` AS `lastup`,`pac_stat_log_backup`.`container` AS `container`,`pac_stat_log_backup`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log_backup`.`disp_id` AS `disp_id`,`pac_stat_log_backup`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_backup`.`audit_status` AS `audit_status`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno` from ((`pac_stat_log_backup` left join `plandoc_stat_log` on(`pac_stat_log_backup`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db` on(`bai_orders_db`.`order_tid` = `plandoc_stat_log`.`order_tid`))) */;

/*View structure for view packing_summary_input */

/*!50001 DROP TABLE IF EXISTS `packing_summary_input` */;
/*!50001 DROP VIEW IF EXISTS `packing_summary_input` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_input` AS (select `bai_orders_db_confirm`.`order_joins` AS `order_joins`,`pac_stat_log_input_job`.`doc_no` AS `doc_no`,`pac_stat_log_input_job`.`input_job_no` AS `input_job_no`,`pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,`pac_stat_log_input_job`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_input_job`.`tid` AS `tid`,ucase(`pac_stat_log_input_job`.`size_code`) AS `size_code`,`pac_stat_log_input_job`.`status` AS `status`,`pac_stat_log_input_job`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_input_job`.`packing_mode` AS `packing_mode`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno`,`bai_orders_db_confirm`.`destination` AS `destination`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,ucase(`pac_stat_log_input_job`.`size_code`) AS `m3_size_code`,`pac_stat_log_input_job`.`old_size` AS `old_size`,`pac_stat_log_input_job`.`type_of_sewing` AS `type_of_sewing` from (((`pac_stat_log_input_job` left join `plandoc_stat_log` on(`pac_stat_log_input_job`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)) left join `tbl_size_matrix` on(concat(`bai_orders_db_confirm`.`order_div`,`pac_stat_log_input_job`.`size_code`) = concat(`tbl_size_matrix`.`buyer_division`,`tbl_size_matrix`.`sfcs_size_code`)))) */;

/*View structure for view packing_summary_temp */

/*!50001 DROP TABLE IF EXISTS `packing_summary_temp` */;
/*!50001 DROP VIEW IF EXISTS `packing_summary_temp` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_temp` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des` from ((`pac_stat_log` left join `plandoc_stat_log` on(`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))) */;

/*View structure for view pack_to_be_backup */

/*!50001 DROP TABLE IF EXISTS `pack_to_be_backup` */;
/*!50001 DROP VIEW IF EXISTS `pack_to_be_backup` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pack_to_be_backup` AS (select `disp_tb1`.`total` AS `total`,`disp_tb1`.`order_del_no` AS `order_del_no`,`disp_tb1`.`scanned` AS `scanned`,`disp_tb1`.`unscanned` AS `unscanned`,`disp_tb1`.`lable_ids` AS `lable_ids`,`disp_db`.`create_date` AS `create_date`,`ship_stat_log`.`ship_s_xs` + `ship_stat_log`.`ship_s_s` + `ship_stat_log`.`ship_s_m` + `ship_stat_log`.`ship_s_l` + `ship_stat_log`.`ship_s_xl` + `ship_stat_log`.`ship_s_xxl` + `ship_stat_log`.`ship_s_xxxl` + `ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08` + `ship_stat_log`.`ship_s_s10` + `ship_stat_log`.`ship_s_s12` + `ship_stat_log`.`ship_s_s14` + `ship_stat_log`.`ship_s_s16` + `ship_stat_log`.`ship_s_s18` + `ship_stat_log`.`ship_s_s20` + `ship_stat_log`.`ship_s_s22` + `ship_stat_log`.`ship_s_s24` + `ship_stat_log`.`ship_s_s26` + `ship_stat_log`.`ship_s_s28` + `ship_stat_log`.`ship_s_s30` AS `ship_qty` from ((`ship_stat_log` left join `disp_tb1` on(`disp_tb1`.`order_del_no` = `ship_stat_log`.`ship_schedule`)) left join `disp_db` on(`disp_db`.`disp_note_no` = `ship_stat_log`.`disp_note_no`)) where `ship_stat_log`.`disp_note_no` is not null and `disp_tb1`.`unscanned` = 0 and `disp_tb1`.`total` = `ship_stat_log`.`ship_s_xs` + `ship_stat_log`.`ship_s_s` + `ship_stat_log`.`ship_s_m` + `ship_stat_log`.`ship_s_l` + `ship_stat_log`.`ship_s_xl` + `ship_stat_log`.`ship_s_xxl` + `ship_stat_log`.`ship_s_xxxl` + `ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08` + `ship_stat_log`.`ship_s_s10` + `ship_stat_log`.`ship_s_s12` + `ship_stat_log`.`ship_s_s14` + `ship_stat_log`.`ship_s_s16` + `ship_stat_log`.`ship_s_s18` + `ship_stat_log`.`ship_s_s20` + `ship_stat_log`.`ship_s_s22` + `ship_stat_log`.`ship_s_s24` + `ship_stat_log`.`ship_s_s26` + `ship_stat_log`.`ship_s_s28` + `ship_stat_log`.`ship_s_s30`) */;

/*View structure for view pac_stat_log_for_live */

/*!50001 DROP TABLE IF EXISTS `pac_stat_log_for_live` */;
/*!50001 DROP VIEW IF EXISTS `pac_stat_log_for_live` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pac_stat_log_for_live` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,sum(`pac_stat_log`.`carton_act_qty`) AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des` from ((`pac_stat_log` left join `plandoc_stat_log` on(`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)) group by `pac_stat_log`.`doc_no_ref`) */;

/*View structure for view pac_stat_log_temp */

/*!50001 DROP TABLE IF EXISTS `pac_stat_log_temp` */;
/*!50001 DROP VIEW IF EXISTS `pac_stat_log_temp` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pac_stat_log_temp` AS (select min(`pac_stat_log`.`tid`) AS `tid`,`pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`carton_no` AS `carton_no`,`pac_stat_log`.`carton_mode` AS `carton_mode`,sum(`pac_stat_log`.`carton_act_qty`) AS `carton_act_qty`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no` from `pac_stat_log` group by `pac_stat_log`.`doc_no_ref`) */;

/*View structure for view plandoc_stat_log_cat_log_ref */

/*!50001 DROP TABLE IF EXISTS `plandoc_stat_log_cat_log_ref` */;
/*!50001 DROP VIEW IF EXISTS `plandoc_stat_log_cat_log_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plandoc_stat_log_cat_log_ref` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`log_update` AS `log_update`,`bai_orders_db`.`color_code` AS `color_code`,`bai_orders_db`.`order_div` AS `order_div`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_orders_db`.`ft_status` AS `ft_status`,`bai_orders_db`.`st_status` AS `st_status`,`bai_orders_db`.`pt_status` AS `pt_status`,`bai_orders_db`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,(`plandoc_stat_log`.`a_xs` + `plandoc_stat_log`.`a_s` + `plandoc_stat_log`.`a_m` + `plandoc_stat_log`.`a_l` + `plandoc_stat_log`.`a_xl` + `plandoc_stat_log`.`a_xxl` + `plandoc_stat_log`.`a_xxxl` + `plandoc_stat_log`.`a_s01` + `plandoc_stat_log`.`a_s02` + `plandoc_stat_log`.`a_s03` + `plandoc_stat_log`.`a_s04` + `plandoc_stat_log`.`a_s05` + `plandoc_stat_log`.`a_s06` + `plandoc_stat_log`.`a_s07` + `plandoc_stat_log`.`a_s08` + `plandoc_stat_log`.`a_s09` + `plandoc_stat_log`.`a_s10` + `plandoc_stat_log`.`a_s11` + `plandoc_stat_log`.`a_s12` + `plandoc_stat_log`.`a_s13` + `plandoc_stat_log`.`a_s14` + `plandoc_stat_log`.`a_s15` + `plandoc_stat_log`.`a_s16` + `plandoc_stat_log`.`a_s17` + `plandoc_stat_log`.`a_s18` + `plandoc_stat_log`.`a_s19` + `plandoc_stat_log`.`a_s20` + `plandoc_stat_log`.`a_s21` + `plandoc_stat_log`.`a_s22` + `plandoc_stat_log`.`a_s23` + `plandoc_stat_log`.`a_s24` + `plandoc_stat_log`.`a_s25` + `plandoc_stat_log`.`a_s26` + `plandoc_stat_log`.`a_s27` + `plandoc_stat_log`.`a_s28` + `plandoc_stat_log`.`a_s29` + `plandoc_stat_log`.`a_s30` + `plandoc_stat_log`.`a_s31` + `plandoc_stat_log`.`a_s32` + `plandoc_stat_log`.`a_s33` + `plandoc_stat_log`.`a_s34` + `plandoc_stat_log`.`a_s35` + `plandoc_stat_log`.`a_s36` + `plandoc_stat_log`.`a_s37` + `plandoc_stat_log`.`a_s38` + `plandoc_stat_log`.`a_s39` + `plandoc_stat_log`.`a_s40` + `plandoc_stat_log`.`a_s41` + `plandoc_stat_log`.`a_s42` + `plandoc_stat_log`.`a_s43` + `plandoc_stat_log`.`a_s44` + `plandoc_stat_log`.`a_s45` + `plandoc_stat_log`.`a_s46` + `plandoc_stat_log`.`a_s47` + `plandoc_stat_log`.`a_s48` + `plandoc_stat_log`.`a_s49` + `plandoc_stat_log`.`a_s50`) * `plandoc_stat_log`.`a_plies` AS `doc_total` from ((`plandoc_stat_log` join `bai_orders_db`) join `cat_stat_log`) where `bai_orders_db`.`order_tid` = `plandoc_stat_log`.`order_tid` and `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` and `cat_stat_log`.`category` in ('Body','Front') and `plandoc_stat_log`.`date` > '2010-08-01' order by `bai_orders_db`.`order_style_no`) */;

/*View structure for view plan_dash_doc_summ */

/*!50001 DROP TABLE IF EXISTS `plan_dash_doc_summ` */;
/*!50001 DROP VIEW IF EXISTS `plan_dash_doc_summ` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_doc_summ` AS (select `plan_dash_summ`.`print_status` AS `print_status`,`plan_dash_summ`.`plan_lot_ref` AS `plan_lot_ref`,`plan_dash_summ`.`bundle_location` AS `bundle_location`,`plan_dash_summ`.`fabric_status_new` AS `fabric_status_new`,`plan_dash_summ`.`doc_no` AS `doc_no`,`plan_dash_summ`.`module` AS `module`,`plan_dash_summ`.`priority` AS `priority`,`plan_dash_summ`.`act_cut_issue_status` AS `act_cut_issue_status`,`plan_dash_summ`.`act_cut_status` AS `act_cut_status`,`plan_dash_summ`.`rm_date` AS `rm_date`,`plan_dash_summ`.`cut_inp_temp` AS `cut_inp_temp`,`plan_dash_summ`.`order_tid` AS `order_tid`,`plan_dash_summ`.`fabric_status` AS `fabric_status`,`plan_doc_summ`.`color_code` AS `color_code`,`plan_doc_summ`.`clubbing` AS `clubbing`,`plan_doc_summ`.`order_style_no` AS `order_style_no`,`plan_doc_summ`.`order_div` AS `order_div`,`plan_doc_summ`.`order_col_des` AS `order_col_des`,`plan_doc_summ`.`acutno` AS `acutno`,`plan_doc_summ`.`ft_status` AS `ft_status`,`plan_doc_summ`.`st_status` AS `st_status`,`plan_doc_summ`.`pt_status` AS `pt_status`,`plan_doc_summ`.`trim_status` AS `trim_status`,`plan_dash_summ`.`xs` AS `xs`,`plan_dash_summ`.`s` AS `s`,`plan_dash_summ`.`m` AS `m`,`plan_dash_summ`.`l` AS `l`,`plan_dash_summ`.`xl` AS `xl`,`plan_dash_summ`.`xxl` AS `xxl`,`plan_dash_summ`.`xxxl` AS `xxxl`,`plan_dash_summ`.`s01` AS `s01`,`plan_dash_summ`.`s02` AS `s02`,`plan_dash_summ`.`s03` AS `s03`,`plan_dash_summ`.`s04` AS `s04`,`plan_dash_summ`.`s05` AS `s05`,`plan_dash_summ`.`s06` AS `s06`,`plan_dash_summ`.`s07` AS `s07`,`plan_dash_summ`.`s08` AS `s08`,`plan_dash_summ`.`s09` AS `s09`,`plan_dash_summ`.`s10` AS `s10`,`plan_dash_summ`.`s11` AS `s11`,`plan_dash_summ`.`s12` AS `s12`,`plan_dash_summ`.`s13` AS `s13`,`plan_dash_summ`.`s14` AS `s14`,`plan_dash_summ`.`s15` AS `s15`,`plan_dash_summ`.`s16` AS `s16`,`plan_dash_summ`.`s17` AS `s17`,`plan_dash_summ`.`s18` AS `s18`,`plan_dash_summ`.`s19` AS `s19`,`plan_dash_summ`.`s20` AS `s20`,`plan_dash_summ`.`s21` AS `s21`,`plan_dash_summ`.`s22` AS `s22`,`plan_dash_summ`.`s23` AS `s23`,`plan_dash_summ`.`s24` AS `s24`,`plan_dash_summ`.`s25` AS `s25`,`plan_dash_summ`.`s26` AS `s26`,`plan_dash_summ`.`s27` AS `s27`,`plan_dash_summ`.`s28` AS `s28`,`plan_dash_summ`.`s29` AS `s29`,`plan_dash_summ`.`s30` AS `s30`,`plan_dash_summ`.`s31` AS `s31`,`plan_dash_summ`.`s32` AS `s32`,`plan_dash_summ`.`s33` AS `s33`,`plan_dash_summ`.`s34` AS `s34`,`plan_dash_summ`.`s35` AS `s35`,`plan_dash_summ`.`s36` AS `s36`,`plan_dash_summ`.`s37` AS `s37`,`plan_dash_summ`.`s38` AS `s38`,`plan_dash_summ`.`s39` AS `s39`,`plan_dash_summ`.`s40` AS `s40`,`plan_dash_summ`.`s41` AS `s41`,`plan_dash_summ`.`s42` AS `s42`,`plan_dash_summ`.`s43` AS `s43`,`plan_dash_summ`.`s44` AS `s44`,`plan_dash_summ`.`s45` AS `s45`,`plan_dash_summ`.`s46` AS `s46`,`plan_dash_summ`.`s47` AS `s47`,`plan_dash_summ`.`s48` AS `s48`,`plan_dash_summ`.`s49` AS `s49`,`plan_dash_summ`.`s50` AS `s50`,`plan_dash_summ`.`a_plies` AS `a_plies`,`plan_dash_summ`.`p_plies` AS `p_plies`,`plan_dash_summ`.`mk_ref` AS `mk_ref`,`plan_dash_summ`.`xs` + `plan_dash_summ`.`s` + `plan_dash_summ`.`m` + `plan_dash_summ`.`l` + `plan_dash_summ`.`xl` + `plan_dash_summ`.`xxl` + `plan_dash_summ`.`xxxl` + `plan_dash_summ`.`s01` + `plan_dash_summ`.`s02` + `plan_dash_summ`.`s03` + `plan_dash_summ`.`s04` + `plan_dash_summ`.`s05` + `plan_dash_summ`.`s06` + `plan_dash_summ`.`s07` + `plan_dash_summ`.`s08` + `plan_dash_summ`.`s09` + `plan_dash_summ`.`s10` + `plan_dash_summ`.`s11` + `plan_dash_summ`.`s12` + `plan_dash_summ`.`s13` + `plan_dash_summ`.`s14` + `plan_dash_summ`.`s15` + `plan_dash_summ`.`s16` + `plan_dash_summ`.`s17` + `plan_dash_summ`.`s18` + `plan_dash_summ`.`s19` + `plan_dash_summ`.`s20` + `plan_dash_summ`.`s21` + `plan_dash_summ`.`s22` + `plan_dash_summ`.`s23` + `plan_dash_summ`.`s24` + `plan_dash_summ`.`s25` + `plan_dash_summ`.`s26` + `plan_dash_summ`.`s27` + `plan_dash_summ`.`s28` + `plan_dash_summ`.`s29` + `plan_dash_summ`.`s30` + `plan_dash_summ`.`s31` + `plan_dash_summ`.`s32` + `plan_dash_summ`.`s33` + `plan_dash_summ`.`s34` + `plan_dash_summ`.`s35` + `plan_dash_summ`.`s36` + `plan_dash_summ`.`s37` + `plan_dash_summ`.`s38` + `plan_dash_summ`.`s39` + `plan_dash_summ`.`s40` + `plan_dash_summ`.`s41` + `plan_dash_summ`.`s42` + `plan_dash_summ`.`s43` + `plan_dash_summ`.`s44` + `plan_dash_summ`.`s45` + `plan_dash_summ`.`s46` + `plan_dash_summ`.`s47` + `plan_dash_summ`.`s48` + `plan_dash_summ`.`s49` + `plan_dash_summ`.`s50` AS `total`,`plan_doc_summ`.`act_movement_status` AS `act_movement_status`,`plan_doc_summ`.`order_del_no` AS `order_del_no`,`plan_dash_summ`.`log_time` AS `log_time`,`plan_doc_summ`.`emb_stat1` AS `emb_stat`,`plan_doc_summ`.`cat_ref` AS `cat_ref` from (`plan_dash_summ` left join `plan_doc_summ` on(`plan_doc_summ`.`doc_no` = `plan_dash_summ`.`doc_no`))) */;

/*View structure for view plan_dash_doc_summ_input */

/*!50001 DROP TABLE IF EXISTS `plan_dash_doc_summ_input` */;
/*!50001 DROP VIEW IF EXISTS `plan_dash_doc_summ_input` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_doc_summ_input` AS (select `plan_dashboard_input`.`input_job_no_random_ref` AS `input_job_no_random_ref`,`plan_dashboard_input`.`input_module` AS `input_module`,`plan_dashboard_input`.`input_priority` AS `input_priority`,`plan_dashboard_input`.`input_trims_status` AS `input_trims_status`,`plan_dashboard_input`.`input_panel_status` AS `input_panel_status`,`plan_dashboard_input`.`log_time` AS `log_time`,`plan_dashboard_input`.`track_id` AS `track_id`,`plan_doc_summ_input`.`input_job_no` AS `input_job_no`,`plan_doc_summ_input`.`tid` AS `tid`,`plan_doc_summ_input`.`input_job_no_random` AS `input_job_no_random`,`plan_doc_summ_input`.`order_tid` AS `order_tid`,`plan_doc_summ_input`.`doc_no` AS `doc_no`,`plan_doc_summ_input`.`acutno` AS `acutno`,`plan_doc_summ_input`.`act_cut_status` AS `act_cut_status`,`plan_doc_summ_input`.`a_plies` AS `a_plies`,`plan_doc_summ_input`.`p_plies` AS `p_plies`,`plan_doc_summ_input`.`color_code` AS `color_code`,`plan_doc_summ_input`.`order_style_no` AS `order_style_no`,`plan_doc_summ_input`.`order_del_no` AS `order_del_no`,`plan_doc_summ_input`.`order_col_des` AS `order_col_des`,`plan_doc_summ_input`.`order_div` AS `order_div`,`plan_doc_summ_input`.`ft_status` AS `ft_status`,`plan_doc_summ_input`.`st_status` AS `st_status`,`plan_doc_summ_input`.`pt_status` AS `pt_status`,`plan_doc_summ_input`.`trim_status` AS `trim_status`,`plan_doc_summ_input`.`category` AS `category`,`plan_doc_summ_input`.`clubbing` AS `clubbing`,`plan_doc_summ_input`.`plan_module` AS `plan_module`,`plan_doc_summ_input`.`cat_ref` AS `cat_ref`,`plan_doc_summ_input`.`emb_stat1` AS `emb_stat1`,`plan_doc_summ_input`.`carton_act_qty` AS `carton_act_qty` from (`plan_dashboard_input` left join `plan_doc_summ_input` on(`plan_dashboard_input`.`input_job_no_random_ref` = `plan_doc_summ_input`.`input_job_no_random`))) */;

/*View structure for view plan_dash_summ */

/*!50001 DROP TABLE IF EXISTS `plan_dash_summ` */;
/*!50001 DROP VIEW IF EXISTS `plan_dash_summ` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_summ` AS (select `plan_dashboard`.`doc_no` AS `doc_no`,`plan_dashboard`.`module` AS `module`,`plan_dashboard`.`priority` AS `priority`,`plan_dashboard`.`fabric_status` AS `fabric_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`plandoc_stat_log`.`pcutdocid` AS `bundle_location`,`plandoc_stat_log`.`print_status` AS `print_status`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`rm_date` AS `rm_date`,`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,`plandoc_stat_log`.`a_xs` * `plandoc_stat_log`.`a_plies` AS `xs`,`plandoc_stat_log`.`a_s` * `plandoc_stat_log`.`a_plies` AS `s`,`plandoc_stat_log`.`a_m` * `plandoc_stat_log`.`a_plies` AS `m`,`plandoc_stat_log`.`a_l` * `plandoc_stat_log`.`a_plies` AS `l`,`plandoc_stat_log`.`a_xl` * `plandoc_stat_log`.`a_plies` AS `xl`,`plandoc_stat_log`.`a_xxl` * `plandoc_stat_log`.`a_plies` AS `xxl`,`plandoc_stat_log`.`a_xxxl` * `plandoc_stat_log`.`a_plies` AS `xxxl`,`plandoc_stat_log`.`a_s01` * `plandoc_stat_log`.`a_plies` AS `s01`,`plandoc_stat_log`.`a_s02` * `plandoc_stat_log`.`a_plies` AS `s02`,`plandoc_stat_log`.`a_s03` * `plandoc_stat_log`.`a_plies` AS `s03`,`plandoc_stat_log`.`a_s04` * `plandoc_stat_log`.`a_plies` AS `s04`,`plandoc_stat_log`.`a_s05` * `plandoc_stat_log`.`a_plies` AS `s05`,`plandoc_stat_log`.`a_s06` * `plandoc_stat_log`.`a_plies` AS `s06`,`plandoc_stat_log`.`a_s07` * `plandoc_stat_log`.`a_plies` AS `s07`,`plandoc_stat_log`.`a_s08` * `plandoc_stat_log`.`a_plies` AS `s08`,`plandoc_stat_log`.`a_s09` * `plandoc_stat_log`.`a_plies` AS `s09`,`plandoc_stat_log`.`a_s10` * `plandoc_stat_log`.`a_plies` AS `s10`,`plandoc_stat_log`.`a_s11` * `plandoc_stat_log`.`a_plies` AS `s11`,`plandoc_stat_log`.`a_s12` * `plandoc_stat_log`.`a_plies` AS `s12`,`plandoc_stat_log`.`a_s13` * `plandoc_stat_log`.`a_plies` AS `s13`,`plandoc_stat_log`.`a_s14` * `plandoc_stat_log`.`a_plies` AS `s14`,`plandoc_stat_log`.`a_s15` * `plandoc_stat_log`.`a_plies` AS `s15`,`plandoc_stat_log`.`a_s16` * `plandoc_stat_log`.`a_plies` AS `s16`,`plandoc_stat_log`.`a_s17` * `plandoc_stat_log`.`a_plies` AS `s17`,`plandoc_stat_log`.`a_s18` * `plandoc_stat_log`.`a_plies` AS `s18`,`plandoc_stat_log`.`a_s19` * `plandoc_stat_log`.`a_plies` AS `s19`,`plandoc_stat_log`.`a_s20` * `plandoc_stat_log`.`a_plies` AS `s20`,`plandoc_stat_log`.`a_s21` * `plandoc_stat_log`.`a_plies` AS `s21`,`plandoc_stat_log`.`a_s22` * `plandoc_stat_log`.`a_plies` AS `s22`,`plandoc_stat_log`.`a_s23` * `plandoc_stat_log`.`a_plies` AS `s23`,`plandoc_stat_log`.`a_s24` * `plandoc_stat_log`.`a_plies` AS `s24`,`plandoc_stat_log`.`a_s25` * `plandoc_stat_log`.`a_plies` AS `s25`,`plandoc_stat_log`.`a_s26` * `plandoc_stat_log`.`a_plies` AS `s26`,`plandoc_stat_log`.`a_s27` * `plandoc_stat_log`.`a_plies` AS `s27`,`plandoc_stat_log`.`a_s28` * `plandoc_stat_log`.`a_plies` AS `s28`,`plandoc_stat_log`.`a_s29` * `plandoc_stat_log`.`a_plies` AS `s29`,`plandoc_stat_log`.`a_s30` * `plandoc_stat_log`.`a_plies` AS `s30`,`plandoc_stat_log`.`a_s31` * `plandoc_stat_log`.`a_plies` AS `s31`,`plandoc_stat_log`.`a_s32` * `plandoc_stat_log`.`a_plies` AS `s32`,`plandoc_stat_log`.`a_s33` * `plandoc_stat_log`.`a_plies` AS `s33`,`plandoc_stat_log`.`a_s34` * `plandoc_stat_log`.`a_plies` AS `s34`,`plandoc_stat_log`.`a_s35` * `plandoc_stat_log`.`a_plies` AS `s35`,`plandoc_stat_log`.`a_s36` * `plandoc_stat_log`.`a_plies` AS `s36`,`plandoc_stat_log`.`a_s37` * `plandoc_stat_log`.`a_plies` AS `s37`,`plandoc_stat_log`.`a_s38` * `plandoc_stat_log`.`a_plies` AS `s38`,`plandoc_stat_log`.`a_s39` * `plandoc_stat_log`.`a_plies` AS `s39`,`plandoc_stat_log`.`a_s40` * `plandoc_stat_log`.`a_plies` AS `s40`,`plandoc_stat_log`.`a_s41` * `plandoc_stat_log`.`a_plies` AS `s41`,`plandoc_stat_log`.`a_s42` * `plandoc_stat_log`.`a_plies` AS `s42`,`plandoc_stat_log`.`a_s43` * `plandoc_stat_log`.`a_plies` AS `s43`,`plandoc_stat_log`.`a_s44` * `plandoc_stat_log`.`a_plies` AS `s44`,`plandoc_stat_log`.`a_s45` * `plandoc_stat_log`.`a_plies` AS `s45`,`plandoc_stat_log`.`a_s46` * `plandoc_stat_log`.`a_plies` AS `s46`,`plandoc_stat_log`.`a_s47` * `plandoc_stat_log`.`a_plies` AS `s47`,`plandoc_stat_log`.`a_s48` * `plandoc_stat_log`.`a_plies` AS `s48`,`plandoc_stat_log`.`a_s49` * `plandoc_stat_log`.`a_plies` AS `s49`,`plandoc_stat_log`.`a_s50` * `plandoc_stat_log`.`a_plies` AS `s50`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`plan_dashboard`.`log_time` AS `log_time` from (`plan_dashboard` left join `plandoc_stat_log` on(`plan_dashboard`.`doc_no` = `plandoc_stat_log`.`doc_no`)) where `plandoc_stat_log`.`order_tid` is not null order by `plan_dashboard`.`priority`) */;

/*View structure for view plan_doc_summ */

/*!50001 DROP TABLE IF EXISTS `plan_doc_summ` */;
/*!50001 DROP VIEW IF EXISTS `plan_doc_summ` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_div` AS `order_div`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`act_movement_status` AS `act_movement_status`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,if(`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b` > 0,1,0) + if(`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f` > 0,2,0) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where `bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid` and `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` and `cat_stat_log`.`category` in ('Body','Front') and `plandoc_stat_log`.`date` > '2010-08-01' and (`plandoc_stat_log`.`act_cut_issue_status` = '' or `plandoc_stat_log`.`a_plies` <> `plandoc_stat_log`.`p_plies` or `plandoc_stat_log`.`plan_module` is null) order by `bai_orders_db_confirm`.`order_style_no`) */;

/*View structure for view plan_doc_summ_input */

/*!50001 DROP TABLE IF EXISTS `plan_doc_summ_input` */;
/*!50001 DROP VIEW IF EXISTS `plan_doc_summ_input` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ_input` AS (select `pac_stat_log_input_job`.`input_job_no` AS `input_job_no`,`pac_stat_log_input_job`.`tid` AS `tid`,`pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,`pac_stat_log_input_job`.`size_code` AS `size_code`,`pac_stat_log_input_job`.`type_of_sewing` AS `type_of_sewing`,`plan_doc_summ_in_ref`.`order_tid` AS `order_tid`,`plan_doc_summ_in_ref`.`doc_no` AS `doc_no`,`plan_doc_summ_in_ref`.`acutno` AS `acutno`,if(octet_length(`plan_doc_summ_in_ref`.`act_cut_status`) = 0,'',`plan_doc_summ_in_ref`.`act_cut_status`) AS `act_cut_status`,if(octet_length(`plan_doc_summ_in_ref`.`act_cut_issue_status`) = 0,'',`plan_doc_summ_in_ref`.`act_cut_issue_status`) AS `act_cut_issue_status`,`plan_doc_summ_in_ref`.`a_plies` AS `a_plies`,`plan_doc_summ_in_ref`.`p_plies` AS `p_plies`,`plan_doc_summ_in_ref`.`color_code` AS `color_code`,`plan_doc_summ_in_ref`.`order_style_no` AS `order_style_no`,`plan_doc_summ_in_ref`.`order_del_no` AS `order_del_no`,`plan_doc_summ_in_ref`.`order_col_des` AS `order_col_des`,`plan_doc_summ_in_ref`.`order_div` AS `order_div`,`plan_doc_summ_in_ref`.`ft_status` AS `ft_status`,`plan_doc_summ_in_ref`.`st_status` AS `st_status`,`plan_doc_summ_in_ref`.`pt_status` AS `pt_status`,`plan_doc_summ_in_ref`.`trim_status` AS `trim_status`,`plan_doc_summ_in_ref`.`category` AS `category`,`plan_doc_summ_in_ref`.`clubbing` AS `clubbing`,`plan_doc_summ_in_ref`.`plan_module` AS `plan_module`,`plan_doc_summ_in_ref`.`cat_ref` AS `cat_ref`,`plan_doc_summ_in_ref`.`emb_stat1` AS `emb_stat1`,sum(`pac_stat_log_input_job`.`carton_act_qty`) AS `carton_act_qty` from (`pac_stat_log_input_job` left join `plan_doc_summ_in_ref` on(`pac_stat_log_input_job`.`doc_no` = `plan_doc_summ_in_ref`.`doc_no`)) where `plan_doc_summ_in_ref`.`order_tid` is not null and `pac_stat_log_input_job`.`input_job_no` is not null and octet_length(`pac_stat_log_input_job`.`input_job_no_random`) > 0 group by `plan_doc_summ_in_ref`.`order_del_no`,`pac_stat_log_input_job`.`doc_no`,`pac_stat_log_input_job`.`input_job_no`,`pac_stat_log_input_job`.`input_job_no_random`) */;

/*View structure for view plan_doc_summ_in_ref */

/*!50001 DROP TABLE IF EXISTS `plan_doc_summ_in_ref` */;
/*!50001 DROP VIEW IF EXISTS `plan_doc_summ_in_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ_in_ref` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`order_div` AS `order_div`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,if(`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b` > 0,1,0) + if(`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f` > 0,2,0) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where `bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid` and `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` and `cat_stat_log`.`category` in ('Body','Front') and `plandoc_stat_log`.`date` > '2017-02-01' order by `bai_orders_db_confirm`.`order_style_no`) */;

/*View structure for view qms_vs_recut */

/*!50001 DROP TABLE IF EXISTS `qms_vs_recut` */;
/*!50001 DROP VIEW IF EXISTS `qms_vs_recut` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `qms_vs_recut` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,min(`bai_qms_db`.`log_date`) AS `log_date`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,sum(if(`bai_qms_db`.`qms_tran_type` = 6,`bai_qms_db`.`qms_qty`,0)) AS `raised`,sum(if(`bai_qms_db`.`qms_tran_type` = 9,`bai_qms_db`.`qms_qty`,0)) AS `actual`,`bai_qms_db`.`ref1` AS `ref1`,`bai_qms_db`.`qms_size` AS `qms_size`,substring_index(`bai_qms_db`.`remarks`,'-',1) AS `module`,substring_index(`bai_qms_db`.`remarks`,'-',-1) AS `doc_no`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`plan_module` AS `plan_module`,`recut_v2`.`fabric_status` AS `fabric_status` from (`bai_qms_db` left join `recut_v2` on(substring_index(`bai_qms_db`.`remarks`,'-',-1) = `recut_v2`.`doc_no`)) where `bai_qms_db`.`qms_tran_type` in (6,9) and `bai_qms_db`.`log_date` > '2011-09-01' group by `bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`remarks`,`bai_qms_db`.`qms_size`) */;

/*View structure for view recut_v2_summary */

/*!50001 DROP TABLE IF EXISTS `recut_v2_summary` */;
/*!50001 DROP VIEW IF EXISTS `recut_v2_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `recut_v2_summary` AS (select `recut_v2`.`date` AS `date`,`recut_v2`.`cat_ref` AS `cat_ref`,`recut_v2`.`cuttable_ref` AS `cuttable_ref`,`recut_v2`.`allocate_ref` AS `allocate_ref`,`recut_v2`.`mk_ref` AS `mk_ref`,`recut_v2`.`order_tid` AS `order_tid`,`recut_v2`.`pcutno` AS `pcutno`,`recut_v2`.`ratio` AS `ratio`,`recut_v2`.`p_xs` AS `p_xs`,`recut_v2`.`p_s` AS `p_s`,`recut_v2`.`p_m` AS `p_m`,`recut_v2`.`p_l` AS `p_l`,`recut_v2`.`p_xl` AS `p_xl`,`recut_v2`.`p_xxl` AS `p_xxl`,`recut_v2`.`p_xxxl` AS `p_xxxl`,`recut_v2`.`p_plies` AS `p_plies`,`recut_v2`.`doc_no` AS `doc_no`,`recut_v2`.`acutno` AS `acutno`,`recut_v2`.`a_xs` AS `a_xs`,`recut_v2`.`a_s` AS `a_s`,`recut_v2`.`a_m` AS `a_m`,`recut_v2`.`a_l` AS `a_l`,`recut_v2`.`a_xl` AS `a_xl`,`recut_v2`.`a_xxl` AS `a_xxl`,`recut_v2`.`a_xxxl` AS `a_xxxl`,`recut_v2`.`a_plies` AS `a_plies`,`recut_v2`.`lastup` AS `lastup`,`recut_v2`.`remarks` AS `remarks`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`act_cut_issue_status` AS `act_cut_issue_status`,`recut_v2`.`pcutdocid` AS `pcutdocid`,`recut_v2`.`print_status` AS `print_status`,`recut_v2`.`a_s01` AS `a_s01`,`recut_v2`.`a_s02` AS `a_s02`,`recut_v2`.`a_s03` AS `a_s03`,`recut_v2`.`a_s04` AS `a_s04`,`recut_v2`.`a_s05` AS `a_s05`,`recut_v2`.`a_s06` AS `a_s06`,`recut_v2`.`a_s07` AS `a_s07`,`recut_v2`.`a_s08` AS `a_s08`,`recut_v2`.`a_s09` AS `a_s09`,`recut_v2`.`a_s10` AS `a_s10`,`recut_v2`.`a_s11` AS `a_s11`,`recut_v2`.`a_s12` AS `a_s12`,`recut_v2`.`a_s13` AS `a_s13`,`recut_v2`.`a_s14` AS `a_s14`,`recut_v2`.`a_s15` AS `a_s15`,`recut_v2`.`a_s16` AS `a_s16`,`recut_v2`.`a_s17` AS `a_s17`,`recut_v2`.`a_s18` AS `a_s18`,`recut_v2`.`a_s19` AS `a_s19`,`recut_v2`.`a_s20` AS `a_s20`,`recut_v2`.`a_s21` AS `a_s21`,`recut_v2`.`a_s22` AS `a_s22`,`recut_v2`.`a_s23` AS `a_s23`,`recut_v2`.`a_s24` AS `a_s24`,`recut_v2`.`a_s25` AS `a_s25`,`recut_v2`.`a_s26` AS `a_s26`,`recut_v2`.`a_s27` AS `a_s27`,`recut_v2`.`a_s28` AS `a_s28`,`recut_v2`.`a_s29` AS `a_s29`,`recut_v2`.`a_s30` AS `a_s30`,`recut_v2`.`a_s31` AS `a_s31`,`recut_v2`.`a_s32` AS `a_s32`,`recut_v2`.`a_s33` AS `a_s33`,`recut_v2`.`a_s34` AS `a_s34`,`recut_v2`.`a_s35` AS `a_s35`,`recut_v2`.`a_s36` AS `a_s36`,`recut_v2`.`a_s37` AS `a_s37`,`recut_v2`.`a_s38` AS `a_s38`,`recut_v2`.`a_s39` AS `a_s39`,`recut_v2`.`a_s40` AS `a_s40`,`recut_v2`.`a_s41` AS `a_s41`,`recut_v2`.`a_s42` AS `a_s42`,`recut_v2`.`a_s43` AS `a_s43`,`recut_v2`.`a_s44` AS `a_s44`,`recut_v2`.`a_s45` AS `a_s45`,`recut_v2`.`a_s46` AS `a_s46`,`recut_v2`.`a_s47` AS `a_s47`,`recut_v2`.`a_s48` AS `a_s48`,`recut_v2`.`a_s49` AS `a_s49`,`recut_v2`.`a_s50` AS `a_s50`,`recut_v2`.`p_s01` AS `p_s01`,`recut_v2`.`p_s02` AS `p_s02`,`recut_v2`.`p_s03` AS `p_s03`,`recut_v2`.`p_s04` AS `p_s04`,`recut_v2`.`p_s05` AS `p_s05`,`recut_v2`.`p_s06` AS `p_s06`,`recut_v2`.`p_s07` AS `p_s07`,`recut_v2`.`p_s08` AS `p_s08`,`recut_v2`.`p_s09` AS `p_s09`,`recut_v2`.`p_s10` AS `p_s10`,`recut_v2`.`p_s11` AS `p_s11`,`recut_v2`.`p_s12` AS `p_s12`,`recut_v2`.`p_s13` AS `p_s13`,`recut_v2`.`p_s14` AS `p_s14`,`recut_v2`.`p_s15` AS `p_s15`,`recut_v2`.`p_s16` AS `p_s16`,`recut_v2`.`p_s17` AS `p_s17`,`recut_v2`.`p_s18` AS `p_s18`,`recut_v2`.`p_s19` AS `p_s19`,`recut_v2`.`p_s20` AS `p_s20`,`recut_v2`.`p_s21` AS `p_s21`,`recut_v2`.`p_s22` AS `p_s22`,`recut_v2`.`p_s23` AS `p_s23`,`recut_v2`.`p_s24` AS `p_s24`,`recut_v2`.`p_s25` AS `p_s25`,`recut_v2`.`p_s26` AS `p_s26`,`recut_v2`.`p_s27` AS `p_s27`,`recut_v2`.`p_s28` AS `p_s28`,`recut_v2`.`p_s29` AS `p_s29`,`recut_v2`.`p_s30` AS `p_s30`,`recut_v2`.`p_s31` AS `p_s31`,`recut_v2`.`p_s32` AS `p_s32`,`recut_v2`.`p_s33` AS `p_s33`,`recut_v2`.`p_s34` AS `p_s34`,`recut_v2`.`p_s35` AS `p_s35`,`recut_v2`.`p_s36` AS `p_s36`,`recut_v2`.`p_s37` AS `p_s37`,`recut_v2`.`p_s38` AS `p_s38`,`recut_v2`.`p_s39` AS `p_s39`,`recut_v2`.`p_s40` AS `p_s40`,`recut_v2`.`p_s41` AS `p_s41`,`recut_v2`.`p_s42` AS `p_s42`,`recut_v2`.`p_s43` AS `p_s43`,`recut_v2`.`p_s44` AS `p_s44`,`recut_v2`.`p_s45` AS `p_s45`,`recut_v2`.`p_s46` AS `p_s46`,`recut_v2`.`p_s47` AS `p_s47`,`recut_v2`.`p_s48` AS `p_s48`,`recut_v2`.`p_s49` AS `p_s49`,`recut_v2`.`p_s50` AS `p_s50`,`recut_v2`.`rm_date` AS `rm_date`,`recut_v2`.`cut_inp_temp` AS `cut_inp_temp`,`recut_v2`.`plan_module` AS `plan_module`,`recut_v2`.`fabric_status` AS `fabric_status`,`recut_v2`.`plan_lot_ref` AS `plan_lot_ref`,(`recut_v2`.`a_xs` + `recut_v2`.`a_s` + `recut_v2`.`a_m` + `recut_v2`.`a_l` + `recut_v2`.`a_xl` + `recut_v2`.`a_xxl` + `recut_v2`.`a_xxxl` + `recut_v2`.`a_s01` + `recut_v2`.`a_s02` + `recut_v2`.`a_s03` + `recut_v2`.`a_s04` + `recut_v2`.`a_s05` + `recut_v2`.`a_s06` + `recut_v2`.`a_s07` + `recut_v2`.`a_s08` + `recut_v2`.`a_s09` + `recut_v2`.`a_s10` + `recut_v2`.`a_s11` + `recut_v2`.`a_s12` + `recut_v2`.`a_s13` + `recut_v2`.`a_s14` + `recut_v2`.`a_s15` + `recut_v2`.`a_s16` + `recut_v2`.`a_s17` + `recut_v2`.`a_s18` + `recut_v2`.`a_s19` + `recut_v2`.`a_s20` + `recut_v2`.`a_s21` + `recut_v2`.`a_s22` + `recut_v2`.`a_s23` + `recut_v2`.`a_s24` + `recut_v2`.`a_s25` + `recut_v2`.`a_s26` + `recut_v2`.`a_s27` + `recut_v2`.`a_s28` + `recut_v2`.`a_s29` + `recut_v2`.`a_s30` + `recut_v2`.`a_s31` + `recut_v2`.`a_s32` + `recut_v2`.`a_s33` + `recut_v2`.`a_s34` + `recut_v2`.`a_s35` + `recut_v2`.`a_s36` + `recut_v2`.`a_s37` + `recut_v2`.`a_s38` + `recut_v2`.`a_s39` + `recut_v2`.`a_s40` + `recut_v2`.`a_s41` + `recut_v2`.`a_s42` + `recut_v2`.`a_s43` + `recut_v2`.`a_s44` + `recut_v2`.`a_s45` + `recut_v2`.`a_s46` + `recut_v2`.`a_s47` + `recut_v2`.`a_s48` + `recut_v2`.`a_s49` + `recut_v2`.`a_s50`) * `recut_v2`.`a_plies` AS `actual_cut_qty`,`recut_v2`.`p_xs` + `recut_v2`.`p_s` + `recut_v2`.`p_m` + `recut_v2`.`p_l` + `recut_v2`.`p_xl` + `recut_v2`.`p_xxl` + `recut_v2`.`p_xxxl` + `recut_v2`.`p_s01` + `recut_v2`.`p_s02` + `recut_v2`.`p_s03` + `recut_v2`.`p_s04` + `recut_v2`.`p_s05` + `recut_v2`.`p_s06` + `recut_v2`.`p_s07` + `recut_v2`.`p_s08` + `recut_v2`.`p_s09` + `recut_v2`.`p_s10` + `recut_v2`.`p_s11` + `recut_v2`.`p_s12` + `recut_v2`.`p_s13` + `recut_v2`.`p_s14` + `recut_v2`.`p_s15` + `recut_v2`.`p_s16` + `recut_v2`.`p_s17` + `recut_v2`.`p_s18` + `recut_v2`.`p_s19` + `recut_v2`.`p_s20` + `recut_v2`.`p_s21` + `recut_v2`.`p_s22` + `recut_v2`.`p_s23` + `recut_v2`.`p_s24` + `recut_v2`.`p_s25` + `recut_v2`.`p_s26` + `recut_v2`.`p_s27` + `recut_v2`.`p_s28` + `recut_v2`.`p_s29` + `recut_v2`.`p_s30` + `recut_v2`.`p_s31` + `recut_v2`.`p_s32` + `recut_v2`.`p_s33` + `recut_v2`.`p_s34` + `recut_v2`.`p_s35` + `recut_v2`.`p_s36` + `recut_v2`.`p_s37` + `recut_v2`.`p_s38` + `recut_v2`.`p_s39` + `recut_v2`.`p_s40` + `recut_v2`.`p_s41` + `recut_v2`.`p_s42` + `recut_v2`.`p_s43` + `recut_v2`.`p_s44` + `recut_v2`.`p_s45` + `recut_v2`.`p_s46` + `recut_v2`.`p_s47` + `recut_v2`.`p_s48` + `recut_v2`.`p_s49` + `recut_v2`.`p_s50` AS `actual_req_qty` from `recut_v2` where `recut_v2`.`act_cut_status` = 'DONE' and `recut_v2`.`remarks` in ('Body','Front')) */;

/*View structure for view test_plan_doc_summ */

/*!50001 DROP TABLE IF EXISTS `test_plan_doc_summ` */;
/*!50001 DROP VIEW IF EXISTS `test_plan_doc_summ` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `test_plan_doc_summ` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`act_movement_status` AS `act_movement_status`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,if(`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b` > 0,1,0) + if(`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f` > 0,2,0) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where `bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid` and `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` and `cat_stat_log`.`category` in ('Body','Front') and `plandoc_stat_log`.`date` > '2010-08-01' and (`plandoc_stat_log`.`act_cut_issue_status` = '' and (`plandoc_stat_log`.`act_movement_status` = 'DONE' or `plandoc_stat_log`.`act_movement_status` = '') or `plandoc_stat_log`.`a_plies` <> `plandoc_stat_log`.`p_plies` or `plandoc_stat_log`.`plan_module` is null) order by `bai_orders_db_confirm`.`order_style_no`) */;

/*View structure for view zero_module_trans */

/*!50001 DROP TABLE IF EXISTS `zero_module_trans` */;
/*!50001 DROP VIEW IF EXISTS `zero_module_trans` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `zero_module_trans` AS (select sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,replace(`ims_log_backup`.`ims_size`,'a_','') AS `size` from `ims_log_backup` where `ims_log_backup`.`ims_mod_no` = 0 and `ims_log_backup`.`ims_date` > '2013-12-01' group by concat(`ims_log_backup`.`ims_style`,`ims_log_backup`.`ims_schedule`,`ims_log_backup`.`ims_color`,`ims_log_backup`.`ims_size`)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
