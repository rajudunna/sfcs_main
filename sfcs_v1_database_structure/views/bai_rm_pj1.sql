/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16 : Database - bai_rm_pj1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_rm_pj1` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bai_rm_pj1`;

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

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `docket_ref` AS (select `fabric_cad_allocation`.`tran_pin` AS `tran_pin`,`fabric_cad_allocation`.`doc_no` AS `doc_no`,`fabric_cad_allocation`.`roll_id` AS `roll_id`,`fabric_cad_allocation`.`roll_width` AS `roll_width`,`fabric_cad_allocation`.`plies` AS `plies`,`fabric_cad_allocation`.`mk_len` AS `mk_len`,`fabric_cad_allocation`.`doc_type` AS `doc_type`,`fabric_cad_allocation`.`log_time` AS `log_time`,`fabric_cad_allocation`.`allocated_qty` AS `allocated_qty`,`sticker_ref`.`ref1` AS `ref1`,`sticker_ref`.`lot_no` AS `lot_no`,`sticker_ref`.`batch_no` AS `batch_no`,`sticker_ref`.`item_desc` AS `item_desc`,`sticker_ref`.`item_name` AS `item_name`,`sticker_ref`.`item` AS `item`,`sticker_ref`.`ref2` AS `ref2`,`sticker_ref`.`ref3` AS `ref3`,`sticker_ref`.`ref4` AS `ref4`,`sticker_ref`.`ref5` AS `ref5`,`sticker_ref`.`ref6` AS `ref6`,`sticker_ref`.`pkg_no` AS `pkg_no`,`sticker_ref`.`status` AS `status`,`sticker_ref`.`grn_date` AS `grn_date`,`sticker_ref`.`remarks` AS `remarks`,`sticker_ref`.`tid` AS `tid`,`sticker_ref`.`qty_rec` AS `qty_rec`,`sticker_ref`.`qty_issued` AS `qty_issued`,`sticker_ref`.`qty_ret` AS `qty_ret`,`sticker_ref`.`inv_no` AS `inv_no` from (`fabric_cad_allocation` left join `sticker_ref` on((`fabric_cad_allocation`.`roll_id` = `sticker_ref`.`tid`)))) */;

/*View structure for view fabric_status */

/*!50001 DROP TABLE IF EXISTS `fabric_status` */;
/*!50001 DROP VIEW IF EXISTS `fabric_status` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `fabric_status` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round(((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),2)),2) AS `balance` from (`store_in` join `sticker_report`) where ((`sticker_report`.`product_group` like '%fabric%') and (((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0) and (`store_in`.`lot_no` = `sticker_report`.`lot_no`)) group by `store_in`.`lot_no`) */;

/*View structure for view fabric_status_v1 */

/*!50001 DROP TABLE IF EXISTS `fabric_status_v1` */;
/*!50001 DROP VIEW IF EXISTS `fabric_status_v1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `fabric_status_v1` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref4` AS `ref4`,`store_in`.`allotment_status` AS `allotment_status`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,round(coalesce(`store_in`.`ref5`,0),2) AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,round(coalesce(`store_in`.`ref5`,0),0) AS `rec_qty`,round(((round(coalesce(`store_in`.`ref5`,0),2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),0) AS `balance` from (`store_in` join `sticker_report`) where ((`store_in`.`lot_no` = `sticker_report`.`lot_no`) and (((round(coalesce(`store_in`.`ref5`,0),2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0) and (`sticker_report`.`product_group` like '%fabric%'))) */;

/*View structure for view fabric_status_v2 */

/*!50001 DROP TABLE IF EXISTS `fabric_status_v2` */;
/*!50001 DROP VIEW IF EXISTS `fabric_status_v2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `fabric_status_v2` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`inv_no` AS `inv_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`store_in`.`ref4` AS `shade`,`store_in`.`allotment_status` AS `allotment_status`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,if(((length(`store_in`.`ref3`) > 0) and (`store_in`.`ref3` <> 0)),`store_in`.`ref3`,`store_in`.`ref6`) AS `width`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round(((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),2)),2) AS `balance` from (`store_in` join `sticker_report`) where ((`store_in`.`lot_no` = `sticker_report`.`lot_no`) and (((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0) and (`sticker_report`.`product_group` like '%fabric%') and (`store_in`.`allotment_status` in (0,1)) and (length(`store_in`.`ref4`) > 0)) group by `store_in`.`tid`) */;

/*View structure for view fabric_status_v3 */

/*!50001 DROP TABLE IF EXISTS `fabric_status_v3` */;
/*!50001 DROP VIEW IF EXISTS `fabric_status_v3` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `fabric_status_v3` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`inv_no` AS `inv_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`store_in`.`qty_allocated` AS `qty_allocated`,`store_in`.`partial_appr_qty` AS `partial_appr_qty`,`store_in`.`ref4` AS `shade`,`store_in`.`allotment_status` AS `allotment_status`,`store_in`.`roll_status` AS `roll_status`,`store_in`.`shrinkage_length` AS `shrinkage_length`,`store_in`.`shrinkage_width` AS `shrinkage_width`,`store_in`.`shrinkage_group` AS `shrinkage_group`,`store_in`.`roll_status` AS `roll_remarks`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,if(((length(`store_in`.`ref3`) > 0) and (`store_in`.`ref3` <> 0)),`store_in`.`ref3`,`store_in`.`ref6`) AS `width`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round((((round(`store_in`.`qty_rec`,2) - round(`store_in`.`partial_appr_qty`,2)) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),2)),2) AS `balance` from (`store_in` join `sticker_report`) where ((`sticker_report`.`product_group` like '%fabric%') and (((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0) and (`store_in`.`allotment_status` in (0,1,2)) and (`store_in`.`lot_no` = `sticker_report`.`lot_no`) and (`store_in`.`roll_status` in (0,2))) group by `store_in`.`tid`) */;

/*View structure for view grn_track_pendings */

/*!50001 DROP TABLE IF EXISTS `grn_track_pendings` */;
/*!50001 DROP VIEW IF EXISTS `grn_track_pendings` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `grn_track_pendings` AS (select trim(`sticker_report`.`product_group`) AS `product`,`sticker_report`.`lot_no` AS `lot_no`,`sticker_report`.`rec_qty` AS `grn_qty`,coalesce(sum(`store_in`.`qty_rec`),0) AS `qty_rec`,(round(`sticker_report`.`rec_qty`,2) - coalesce(sum(round(`store_in`.`qty_rec`,2)),0)) AS `qty_diff`,if(((round(`sticker_report`.`rec_qty`,2) - coalesce(sum(round(`store_in`.`qty_rec`,2)),0)) >= 1),1,0) AS `label_pending`,cast(`sticker_report`.`grn_date` as date) AS `date`,sum(if(((`store_in`.`ref4` = '') and (trim(`sticker_report`.`product_group`) = 'Fabric')),1,0)) AS `shade_pending`,sum(if((`store_in`.`ref1` = ''),1,0)) AS `location_pending`,((sum(round(`store_in`.`qty_rec`,2)) - sum(round(`store_in`.`qty_issued`,2))) + sum(round(`store_in`.`qty_ret`,2))) AS `balance`,if(((length(`store_in`.`ref3`) <= 1) and (trim(`sticker_report`.`product_group`) = 'Fabric')),1,0) AS `ctax_pending`,replace(replace(group_concat(if(((length(`store_in`.`ref3`) <= 1) and (trim(`sticker_report`.`product_group`) = 'Fabric')),concat(`store_in`.`ref2`,'@',`store_in`.`ref1`),'x') separator ','),'x,',''),'x','') AS `ctax_pending_rolls` from (`sticker_report` left join `store_in` on((`sticker_report`.`lot_no` = `store_in`.`lot_no`))) where ((cast(`sticker_report`.`grn_date` as date) > '2011-09-1') and (`sticker_report`.`backup_status` = 0)) group by `sticker_report`.`lot_no`) */;

/*View structure for view sticker_ref */

/*!50001 DROP TABLE IF EXISTS `sticker_ref` */;
/*!50001 DROP VIEW IF EXISTS `sticker_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `sticker_ref` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`sticker_report`.`inv_no` AS `inv_no`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref4` AS `ref4`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret` from (`store_in` join `sticker_report`) where (`store_in`.`lot_no` = `sticker_report`.`lot_no`)) */;

/*View structure for view stock_report */

/*!50001 DROP TABLE IF EXISTS `stock_report` */;
/*!50001 DROP VIEW IF EXISTS `stock_report` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `stock_report` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`sticker_report`.`supplier` AS `supplier`,`sticker_report`.`buyer` AS `buyer`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,round(((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)),2) AS `balance`,`sticker_report`.`product_group` AS `product_group` from (`store_in` join `sticker_report`) where ((`store_in`.`lot_no` = `sticker_report`.`lot_no`) and (((round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2)) + round(`store_in`.`qty_ret`,2)) > 0))) */;

/*View structure for view store_in_weekly_backup */

/*!50001 DROP TABLE IF EXISTS `store_in_weekly_backup` */;
/*!50001 DROP VIEW IF EXISTS `store_in_weekly_backup` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`baiall`@`%` SQL SECURITY DEFINER VIEW `store_in_weekly_backup` AS (select `sticker_report`.`lot_no` AS `lot_no`,sum(`store_in`.`qty_rec`) AS `sticker_qty`,round(sum(`sticker_report`.`rec_qty`),2) AS `grn_qty`,sum(`store_in`.`qty_rec`) AS `Recieved_Qty`,sum(`store_in`.`qty_ret`) AS `Returned_Qty`,sum(`store_in`.`qty_issued`) AS `Issued_Qty`,((sum(`store_in`.`qty_rec`) + sum(`store_in`.`qty_ret`)) - sum(`store_in`.`qty_issued`)) AS `Available_Qty` from (`store_in` left join `sticker_report` on((`store_in`.`lot_no` = `sticker_report`.`lot_no`))) where (`store_in`.`date` < (curdate() + interval -(15) day)) group by trim(`store_in`.`lot_no`) having (((sum(`store_in`.`qty_rec`) + sum(`store_in`.`qty_ret`)) - sum(`store_in`.`qty_issued`)) = 0)) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
