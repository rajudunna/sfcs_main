/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_pro2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_pro2`;

/*Table structure for table `style_status_summ_live` */

DROP TABLE IF EXISTS `style_status_summ_live`;

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

/*View structure for view style_status_summ_live */

/*!50001 DROP TABLE IF EXISTS `style_status_summ_live` */;
/*!50001 DROP VIEW IF EXISTS `style_status_summ_live` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `style_status_summ_live` AS (select `bai_pro3`.`bai_orders_db`.`order_tid` AS `ssc_code`,sum(`bai_pro3`.`bai_orders_db`.`act_cut`) AS `cut_qty`,sum(`bai_pro3`.`bai_orders_db`.`act_in`) AS `sewing_in`,sum(`bai_pro3`.`bai_orders_db`.`output`) AS `sewing_out`,sum(`bai_pro3`.`bai_orders_db`.`act_fg`) AS `pack_qty`,sum(`bai_pro3`.`bai_orders_db`.`act_ship`) AS `ship_qty` from `bai_pro3`.`bai_orders_db` group by `bai_pro3`.`bai_orders_db`.`order_tid`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
