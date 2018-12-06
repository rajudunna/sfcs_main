/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_pro2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro2` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*USE `bai_pro2`;*/

/*!50106 set global event_scheduler = 1*/;

/* Event structure for event `buyer_codes_event` */

/*!50106 DROP EVENT IF EXISTS `buyer_codes_event`*/;

DELIMITER $$

/*!50106 CREATE EVENT `buyer_codes_event` ON SCHEDULE EVERY 1 HOUR STARTS '2018-07-14 19:05:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
                INSERT INTO buyer_codes (buyer_name, buyer_code) 
		SELECT  TRIM(order_div), CONCAT(LEFT(TRIM(order_div),3), '-', RIGHT(TRIM(order_div),3)) AS buyer_code 
		FROM bai_pro3.bai_orders_db WHERE TRIM(order_div) NOT IN 
		(SELECT TRIM(buyer_name) FROM buyer_codes)
		GROUP BY order_div;
    END */$$
DELIMITER ;

/*Table structure for table `hourly_downtime_reason` */

DROP TABLE IF EXISTS `bai_pro2`.`hourly_downtime_reason`;

/*!50001 DROP VIEW IF EXISTS `hourly_downtime_reason` */;
/*!50001 DROP TABLE IF EXISTS `hourly_downtime_reason` */;

/*!50001 CREATE TABLE  `hourly_downtime_reason`(
 `date` varchar(45) ,
 `dreason` varchar(45) ,
 `output_qty` varchar(45) ,
 `rdept` varchar(65) ,
 `team` varchar(45) 
)*/;

/*Table structure for table `style_status_summ_live` */

DROP TABLE IF EXISTS `bai_pro2`.`style_status_summ_live`;

/*!50001 DROP VIEW IF EXISTS `style_status_summ_live` */;
/*!50001 DROP TABLE IF EXISTS `style_status_summ_live` */;

/*!50001 CREATE TABLE  `style_status_summ_live`(
 `ssc_code` varchar(200) ,
 `cut_qty` decimal(32,0) ,
 `sewing_in` decimal(32,0) ,
 `sewing_out` decimal(32,0) ,
 `pack_qty` decimal(32,0) ,
 `ship_qty` decimal(32,0) 
)*/;

/*View structure for view hourly_downtime_reason */

/*!50001 DROP TABLE IF EXISTS `hourly_downtime_reason` */;
/*!50001 DROP VIEW IF EXISTS `hourly_downtime_reason` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `hourly_downtime_reason` AS (select `hourly_downtime`.`date` AS `date`,`hourly_downtime`.`dreason` AS `dreason`,`hourly_downtime`.`output_qty` AS `output_qty`,`downtime_reason`.`rdept` AS `rdept`,`hourly_downtime`.`team` AS `team` from (`hourly_downtime` join `downtime_reason` on(`hourly_downtime`.`dreason` = `downtime_reason`.`code`))) */;

/*View structure for view style_status_summ_live */

/*!50001 DROP TABLE IF EXISTS `style_status_summ_live` */;
/*!50001 DROP VIEW IF EXISTS `style_status_summ_live` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `style_status_summ_live` AS (select `bai_pro3`.`bai_orders_db`.`order_tid` AS `ssc_code`,sum(`bai_pro3`.`bai_orders_db`.`act_cut`) AS `cut_qty`,sum(`bai_pro3`.`bai_orders_db`.`act_in`) AS `sewing_in`,sum(`bai_pro3`.`bai_orders_db`.`output`) AS `sewing_out`,sum(`bai_pro3`.`bai_orders_db`.`act_fg`) AS `pack_qty`,sum(`bai_pro3`.`bai_orders_db`.`act_ship`) AS `ship_qty` from `bai_pro3`.`bai_orders_db` group by `bai_pro3`.`bai_orders_db`.`order_tid`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
