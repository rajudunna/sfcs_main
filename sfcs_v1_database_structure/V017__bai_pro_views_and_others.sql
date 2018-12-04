/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_pro
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*USE `bai_pro`;*/

/*Table structure for table `bai_log_view` */

DROP TABLE IF EXISTS `bai_pro`.`bai_log_view`;

/*!50001 DROP VIEW IF EXISTS `bai_log_view` */;
/*!50001 DROP TABLE IF EXISTS `bai_log_view` */;

/*!50001 CREATE TABLE  `bai_log_view`(
 `tid` bigint(11) ,
 `bac_no` varchar(8) ,
 `bac_sec` tinyint(1) unsigned ,
 `size` varchar(53) ,
 `bac_Qty` smallint(5) ,
 `bac_lastup` datetime ,
 `bac_date` date ,
 `bac_shift` varchar(3) ,
 `bac_style` varchar(19) ,
 `bac_remarks` tinytext ,
 `bac_stat` char(6) ,
 `log_time` datetime ,
 `division` varchar(7) ,
 `buyer` tinytext ,
 `delivery` bigint(11) ,
 `color` tinytext ,
 `loguser` varchar(30) ,
 `ims_doc_no` int(10) unsigned ,
 `couple` tinyint(1) unsigned ,
 `nop` tinyint(2) unsigned ,
 `smv` float ,
 `ims_table_name` varchar(14) ,
 `ims_tid` mediumint(5) unsigned ,
 `size_xs` smallint(5) ,
 `size_s` smallint(4) ,
 `size_m` smallint(4) ,
 `size_l` smallint(4) ,
 `size_xl` smallint(4) ,
 `size_xxl` smallint(3) ,
 `size_xxxl` smallint(3) ,
 `size_s01` smallint(4) ,
 `size_s02` smallint(4) ,
 `size_s03` smallint(4) ,
 `size_s04` smallint(4) ,
 `size_s05` smallint(4) ,
 `size_s06` smallint(4) ,
 `size_s07` smallint(4) ,
 `size_s08` smallint(4) ,
 `size_s09` smallint(4) ,
 `size_s10` smallint(4) ,
 `size_s11` smallint(4) ,
 `size_s12` smallint(4) ,
 `size_s13` smallint(4) ,
 `size_s14` smallint(4) ,
 `size_s15` smallint(4) ,
 `size_s16` smallint(4) ,
 `size_s17` smallint(4) ,
 `size_s18` smallint(4) ,
 `size_s19` smallint(4) ,
 `size_s20` smallint(4) ,
 `size_s21` smallint(4) ,
 `size_s22` smallint(4) ,
 `size_s23` smallint(4) ,
 `size_s24` smallint(4) ,
 `size_s25` smallint(4) ,
 `size_s26` smallint(4) ,
 `size_s27` smallint(4) ,
 `size_s28` smallint(4) ,
 `size_s29` smallint(4) ,
 `size_s30` smallint(4) ,
 `size_s31` smallint(4) ,
 `size_s32` smallint(4) ,
 `size_s33` smallint(4) ,
 `size_s34` smallint(4) ,
 `size_s35` smallint(4) ,
 `size_s36` smallint(4) ,
 `size_s37` smallint(4) ,
 `size_s38` smallint(4) ,
 `size_s39` smallint(4) ,
 `size_s40` smallint(4) ,
 `size_s41` smallint(4) ,
 `size_s42` smallint(4) ,
 `size_s43` smallint(4) ,
 `size_s44` smallint(4) ,
 `size_s45` smallint(4) ,
 `size_s46` smallint(4) ,
 `size_s47` smallint(4) ,
 `size_s48` smallint(4) ,
 `size_s49` smallint(4) ,
 `size_s50` smallint(4) 
)*/;

/*View structure for view bai_log_view */

/*!50001 DROP TABLE IF EXISTS `bai_log_view` */;
/*!50001 DROP VIEW IF EXISTS `bai_log_view` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_log_view` AS (select `bai_log`.`tid` AS `tid`,`bai_log`.`bac_no` AS `bac_no`,`bai_log`.`bac_sec` AS `bac_sec`,concat(if(`bai_log`.`size_xs` > 0,'xs',''),if(`bai_log`.`size_s` > 0,'s',''),if(`bai_log`.`size_m` > 0,'m',''),if(`bai_log`.`size_l` > 0,'l',''),if(`bai_log`.`size_xl` > 0,'xl',''),if(`bai_log`.`size_xxl` > 0,'xxl',''),if(`bai_log`.`size_xxxl` > 0,'xxxl',''),if(`bai_log`.`size_s06` > 0,'s06',''),if(`bai_log`.`size_s08` > 0,'s08',''),if(`bai_log`.`size_s10` > 0,'s10',''),if(`bai_log`.`size_s12` > 0,'s12',''),if(`bai_log`.`size_s14` > 0,'s14',''),if(`bai_log`.`size_s16` > 0,'s16',''),if(`bai_log`.`size_s18` > 0,'s18',''),if(`bai_log`.`size_s20` > 0,'s20',''),if(`bai_log`.`size_s22` > 0,'s22',''),if(`bai_log`.`size_s24` > 0,'s24',''),if(`bai_log`.`size_s26` > 0,'s26',''),if(`bai_log`.`size_s28` > 0,'s28',''),if(`bai_log`.`size_s30` > 0,'s30','')) AS `size`,`bai_log`.`bac_Qty` AS `bac_Qty`,`bai_log`.`bac_lastup` AS `bac_lastup`,`bai_log`.`bac_date` AS `bac_date`,`bai_log`.`bac_shift` AS `bac_shift`,`bai_log`.`bac_style` AS `bac_style`,`bai_log`.`bac_remarks` AS `bac_remarks`,`bai_log`.`bac_stat` AS `bac_stat`,`bai_log`.`log_time` AS `log_time`,`bai_log`.`division` AS `division`,`bai_log`.`buyer` AS `buyer`,`bai_log`.`delivery` AS `delivery`,`bai_log`.`color` AS `color`,`bai_log`.`loguser` AS `loguser`,`bai_log`.`ims_doc_no` AS `ims_doc_no`,`bai_log`.`couple` AS `couple`,`bai_log`.`nop` AS `nop`,`bai_log`.`smv` AS `smv`,`bai_log`.`ims_table_name` AS `ims_table_name`,`bai_log`.`ims_tid` AS `ims_tid`,`bai_log`.`size_xs` AS `size_xs`,`bai_log`.`size_s` AS `size_s`,`bai_log`.`size_m` AS `size_m`,`bai_log`.`size_l` AS `size_l`,`bai_log`.`size_xl` AS `size_xl`,`bai_log`.`size_xxl` AS `size_xxl`,`bai_log`.`size_xxxl` AS `size_xxxl`,`bai_log`.`size_s01` AS `size_s01`,`bai_log`.`size_s02` AS `size_s02`,`bai_log`.`size_s03` AS `size_s03`,`bai_log`.`size_s04` AS `size_s04`,`bai_log`.`size_s05` AS `size_s05`,`bai_log`.`size_s06` AS `size_s06`,`bai_log`.`size_s07` AS `size_s07`,`bai_log`.`size_s08` AS `size_s08`,`bai_log`.`size_s09` AS `size_s09`,`bai_log`.`size_s10` AS `size_s10`,`bai_log`.`size_s11` AS `size_s11`,`bai_log`.`size_s12` AS `size_s12`,`bai_log`.`size_s13` AS `size_s13`,`bai_log`.`size_s14` AS `size_s14`,`bai_log`.`size_s15` AS `size_s15`,`bai_log`.`size_s16` AS `size_s16`,`bai_log`.`size_s17` AS `size_s17`,`bai_log`.`size_s18` AS `size_s18`,`bai_log`.`size_s19` AS `size_s19`,`bai_log`.`size_s20` AS `size_s20`,`bai_log`.`size_s21` AS `size_s21`,`bai_log`.`size_s22` AS `size_s22`,`bai_log`.`size_s23` AS `size_s23`,`bai_log`.`size_s24` AS `size_s24`,`bai_log`.`size_s25` AS `size_s25`,`bai_log`.`size_s26` AS `size_s26`,`bai_log`.`size_s27` AS `size_s27`,`bai_log`.`size_s28` AS `size_s28`,`bai_log`.`size_s29` AS `size_s29`,`bai_log`.`size_s30` AS `size_s30`,`bai_log`.`size_s31` AS `size_s31`,`bai_log`.`size_s32` AS `size_s32`,`bai_log`.`size_s33` AS `size_s33`,`bai_log`.`size_s34` AS `size_s34`,`bai_log`.`size_s35` AS `size_s35`,`bai_log`.`size_s36` AS `size_s36`,`bai_log`.`size_s37` AS `size_s37`,`bai_log`.`size_s38` AS `size_s38`,`bai_log`.`size_s39` AS `size_s39`,`bai_log`.`size_s40` AS `size_s40`,`bai_log`.`size_s41` AS `size_s41`,`bai_log`.`size_s42` AS `size_s42`,`bai_log`.`size_s43` AS `size_s43`,`bai_log`.`size_s44` AS `size_s44`,`bai_log`.`size_s45` AS `size_s45`,`bai_log`.`size_s46` AS `size_s46`,`bai_log`.`size_s47` AS `size_s47`,`bai_log`.`size_s48` AS `size_s48`,`bai_log`.`size_s49` AS `size_s49`,`bai_log`.`size_s50` AS `size_s50` from `bai_log`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
