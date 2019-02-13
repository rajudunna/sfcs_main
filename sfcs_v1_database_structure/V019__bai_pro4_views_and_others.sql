/*
SQLyog Community
MySQL - 10.3.8-MariaDB : Database - bai_pro4
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bai_pro4` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*USE `bai_pro4`;*/

/* Function  structure for function  `uExtractNumberFromString` */

/*!50003 DROP FUNCTION IF EXISTS `uExtractNumberFromString` */;
DELIMITER $$

/*!50003 CREATE FUNCTION `uExtractNumberFromString`(in_string VARCHAR(50)) RETURNS varchar(30) CHARSET latin1
    DETERMINISTIC
BEGIN
    
DECLARE ctrNumber VARCHAR(50);
DECLARE finNumber VARCHAR(50) DEFAULT ' ';
DECLARE sChar VARCHAR(2);
DECLARE inti INTEGER DEFAULT 1;
DECLARE chk INTEGER DEFAULT 0;
IF LENGTH(in_string) > 0 THEN
myloop: WHILE(inti <= LENGTH(in_string)) DO
    SET sChar= SUBSTRING(in_string,inti,1);
    SET ctrNumber= FIND_IN_SET(sChar,'0,1,2,3,4,5,6,7,8,9');
    IF ctrNumber > 0 THEN
       SET finNumber=CONCAT(finNumber,sChar);
    ELSE
       SET finNumber=CONCAT(finNumber,'');
       SET chk=chk+1;
    END IF;
    
    IF chk>=2 then
	LEAVE myloop;
    END IF;
	    
    SET inti=inti+1;
END WHILE;
if finNumber=0 then
RETURN in_string;
else
RETURN CAST(finNumber AS SIGNED INTEGER) ;
END IF;
ELSE
  RETURN 0;
END IF;
    END */$$
DELIMITER ;

/*Table structure for table `bai_cut_to_ship_ref` */

DROP TABLE IF EXISTS `bai_pro4`.`bai_cut_to_ship_ref`;

/*!50001 DROP VIEW IF EXISTS `bai_cut_to_ship_ref` */;
/*!50001 DROP TABLE IF EXISTS `bai_cut_to_ship_ref` */;

/*!50001 CREATE TABLE  `bai_cut_to_ship_ref`(
 `ship_tid` bigint(20) ,
 `tid` mediumint(9) ,
 `buyer_division` varchar(40) ,
 `ssc_code_new` varchar(200) ,
 `schedule_no` varchar(15) ,
 `color` varchar(50) ,
 `style` varchar(15) ,
 `ord_qty_new` mediumint(9) ,
 `ord_qty_new_old` decimal(41,0) ,
 `m3_ship_plan_ex_fact` date ,
 `ex_factory_date` date ,
 `rev_exfactory` date ,
 `ex_factory_date_new` date ,
 `output` bigint(17) ,
 `sections` varchar(36) ,
 `act_cut` mediumint(9) ,
 `act_in` mediumint(9) ,
 `act_fca` mediumint(9) ,
 `act_mca` mediumint(9) ,
 `act_fg` mediumint(9) ,
 `cart_pending` mediumint(9) ,
 `priority` mediumint(9) ,
 `ref_id` int(11) 
)*/;

/*Table structure for table `delivery_report_p1` */

DROP TABLE IF EXISTS `bai_pro4`.`delivery_report_p1`;

/*!50001 DROP VIEW IF EXISTS `delivery_report_p1` */;
/*!50001 DROP TABLE IF EXISTS `delivery_report_p1` */;

/*!50001 CREATE TABLE  `delivery_report_p1`(
 `buyer_division` varchar(40) ,
 `mpo` varchar(30) ,
 `cpo` varchar(30) ,
 `order_no` varchar(10) ,
 `style` varchar(15) ,
 `schedule_no` varchar(15) ,
 `color` varchar(50) ,
 `ex_factory_date` date ,
 `MODE` varchar(5) ,
 `ssc_code` varchar(150) ,
 `embl_status` varchar(88) ,
 `xs` decimal(41,0) ,
 `s` decimal(41,0) ,
 `m` decimal(41,0) ,
 `l` decimal(41,0) ,
 `xl` decimal(41,0) ,
 `xxl` decimal(41,0) ,
 `xxxl` decimal(41,0) ,
 `s01` decimal(41,0) ,
 `s02` decimal(41,0) ,
 `s03` decimal(41,0) ,
 `s04` decimal(41,0) ,
 `s05` decimal(41,0) ,
 `s06` decimal(41,0) ,
 `s07` decimal(41,0) ,
 `s08` decimal(41,0) ,
 `s09` decimal(41,0) ,
 `s10` decimal(41,0) ,
 `s11` decimal(41,0) ,
 `s12` decimal(41,0) ,
 `s13` decimal(41,0) ,
 `s14` decimal(41,0) ,
 `s15` decimal(41,0) ,
 `s16` decimal(41,0) ,
 `s17` decimal(41,0) ,
 `s18` decimal(41,0) ,
 `s19` decimal(41,0) ,
 `s20` decimal(41,0) ,
 `s21` decimal(41,0) ,
 `s22` decimal(41,0) ,
 `s23` decimal(41,0) ,
 `s24` decimal(41,0) ,
 `s25` decimal(41,0) ,
 `s26` decimal(41,0) ,
 `s27` decimal(41,0) ,
 `s28` decimal(41,0) ,
 `s29` decimal(41,0) ,
 `s30` decimal(41,0) ,
 `s31` decimal(41,0) ,
 `s32` decimal(41,0) ,
 `s33` decimal(41,0) ,
 `s34` decimal(41,0) ,
 `s35` decimal(41,0) ,
 `s36` decimal(41,0) ,
 `s37` decimal(41,0) ,
 `s38` decimal(41,0) ,
 `s39` decimal(41,0) ,
 `s40` decimal(41,0) ,
 `s41` decimal(41,0) ,
 `s42` decimal(41,0) ,
 `s43` decimal(41,0) ,
 `s44` decimal(41,0) ,
 `s45` decimal(41,0) ,
 `s46` decimal(41,0) ,
 `s47` decimal(41,0) ,
 `s48` decimal(41,0) ,
 `s49` decimal(41,0) ,
 `s50` decimal(41,0) 
)*/;

/*Table structure for table `fastreact_plan_summary` */

DROP TABLE IF EXISTS `bai_pro4`.`fastreact_plan_summary`;

/*!50001 DROP VIEW IF EXISTS `fastreact_plan_summary` */;
/*!50001 DROP TABLE IF EXISTS `fastreact_plan_summary` */;

/*!50001 CREATE TABLE  `fastreact_plan_summary`(
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
 `execution` mediumtext ,
 `production_start` date 
)*/;

/*Table structure for table `shipment_plan_ref` */

DROP TABLE IF EXISTS `bai_pro4`.`shipment_plan_ref`;

/*!50001 DROP VIEW IF EXISTS `shipment_plan_ref` */;
/*!50001 DROP TABLE IF EXISTS `shipment_plan_ref` */;

/*!50001 CREATE TABLE  `shipment_plan_ref`(
 `order_no` varchar(10) ,
 `delivery_no` varchar(10) ,
 `del_status` varchar(2) ,
 `mpo` varchar(30) ,
 `cpo` varchar(30) ,
 `buyer` varchar(36) ,
 `product` varchar(40) ,
 `buyer_division` varchar(40) ,
 `style` varchar(15) ,
 `schedule_no` varchar(15) ,
 `color` varchar(50) ,
 `size` varchar(15) ,
 `z_feature` varchar(15) ,
 `ord_qty` bigint(20) ,
 `ex_factory_date` date ,
 `mode` varchar(5) ,
 `destination` varchar(10) ,
 `packing_method` varchar(6) ,
 `fob_price_per_piece` float ,
 `cm_value` float ,
 `ssc_code` varchar(150) ,
 `ship_tid` bigint(20) ,
 `week_code` tinyint(11) ,
 `status` tinyint(11) ,
 `ssc_code_new` varchar(200) ,
 `order_embl_a` tinyint(11) ,
 `order_embl_b` tinyint(11) ,
 `order_embl_c` tinyint(11) ,
 `order_embl_d` tinyint(11) ,
 `order_embl_e` tinyint(11) ,
 `order_embl_f` tinyint(11) ,
 `order_embl_g` tinyint(11) ,
 `order_embl_h` tinyint(11) ,
 `ord_qty_new` decimal(41,0) 
)*/;

/*Table structure for table `week_delivery_plan_ref` */

DROP TABLE IF EXISTS `bai_pro4`.`week_delivery_plan_ref`;

/*!50001 DROP VIEW IF EXISTS `week_delivery_plan_ref` */;
/*!50001 DROP TABLE IF EXISTS `week_delivery_plan_ref` */;

/*!50001 CREATE TABLE  `week_delivery_plan_ref`(
 `ship_tid` bigint(20) ,
 `tid` mediumint(9) ,
 `buyer_division` varchar(40) ,
 `schedule_no` varchar(15) ,
 `color` varchar(50) ,
 `style` varchar(15) ,
 `size` varchar(15) ,
 `ord_qty_new` mediumint(9) ,
 `ord_qty_new_old` decimal(41,0) ,
 `m3_ship_plan_ex_fact` date ,
 `ex_factory_date` date ,
 `rev_exfactory` date ,
 `ex_factory_date_new` date ,
 `output` bigint(23) ,
 `act_cut` mediumint(9) ,
 `act_in` mediumint(9) ,
 `act_fca` mediumint(9) ,
 `act_mca` mediumint(9) ,
 `act_fg` mediumint(9) ,
 `act_ship` mediumint(9) ,
 `cart_pending` mediumint(9) ,
 `priority` mediumint(9) ,
 `ref_id` int(11) ,
 `act_exfact` date ,
 `act_rej` int(11) ,
 `remarks` text 
)*/;

/*View structure for view bai_cut_to_ship_ref */

/*!50001 DROP TABLE IF EXISTS `bai_cut_to_ship_ref` */;
/*!50001 DROP VIEW IF EXISTS `bai_cut_to_ship_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_cut_to_ship_ref` AS (select `shipment_plan_ref`.`ship_tid` AS `ship_tid`,`week_delivery_plan`.`tid` AS `tid`,`shipment_plan_ref`.`buyer_division` AS `buyer_division`,`shipment_plan_ref`.`ssc_code_new` AS `ssc_code_new`,`shipment_plan_ref`.`schedule_no` AS `schedule_no`,`shipment_plan_ref`.`color` AS `color`,`shipment_plan_ref`.`style` AS `style`,`week_delivery_plan`.`original_order_qty` AS `ord_qty_new`,`shipment_plan_ref`.`ord_qty_new` AS `ord_qty_new_old`,`shipment_plan_ref`.`ex_factory_date` AS `m3_ship_plan_ex_fact`,`week_delivery_plan`.`act_exfact` AS `ex_factory_date`,`week_delivery_plan`.`rev_exfactory` AS `rev_exfactory`,if(`week_delivery_plan`.`rev_exfactory` = '0000-00-00',`week_delivery_plan`.`act_exfact`,`week_delivery_plan`.`rev_exfactory`) AS `ex_factory_date_new`,`week_delivery_plan`.`actu_sec1` + `week_delivery_plan`.`actu_sec2` + `week_delivery_plan`.`actu_sec3` + `week_delivery_plan`.`actu_sec4` + `week_delivery_plan`.`actu_sec5` + `week_delivery_plan`.`actu_sec6` + `week_delivery_plan`.`actu_sec7` + `week_delivery_plan`.`actu_sec8` + `week_delivery_plan`.`actu_sec9` AS `output`,concat(if(`week_delivery_plan`.`actu_sec1` > 0,'1,',''),if(`week_delivery_plan`.`actu_sec2` > 0,'2,',''),if(`week_delivery_plan`.`actu_sec3` > 0,'3,',''),if(`week_delivery_plan`.`actu_sec4` > 0,'4,',''),if(`week_delivery_plan`.`actu_sec5` > 0,'5,',''),if(`week_delivery_plan`.`actu_sec6` > 0,'6,',''),if(`week_delivery_plan`.`actu_sec7` > 0,'7,',''),if(`week_delivery_plan`.`actu_sec8` > 0,'8,',''),if(`week_delivery_plan`.`actu_sec9` > 0,'9,',''),if(`week_delivery_plan`.`actu_sec10` > 0,'10,',''),if(`week_delivery_plan`.`actu_sec11` > 0,'11,',''),if(`week_delivery_plan`.`actu_sec12` > 0,'12,',''),if(`week_delivery_plan`.`actu_sec13` > 0,'13,',''),if(`week_delivery_plan`.`actu_sec14` > 0,'14,',''),if(`week_delivery_plan`.`actu_sec15` > 0,'15,','')) AS `sections`,`week_delivery_plan`.`act_cut` AS `act_cut`,`week_delivery_plan`.`act_in` AS `act_in`,`week_delivery_plan`.`act_fca` AS `act_fca`,`week_delivery_plan`.`act_mca` AS `act_mca`,`week_delivery_plan`.`act_fg` AS `act_fg`,`week_delivery_plan`.`cart_pending` AS `cart_pending`,`week_delivery_plan`.`priority` AS `priority`,`week_delivery_plan`.`ref_id` AS `ref_id` from (`week_delivery_plan` left join `shipment_plan_ref` on(`week_delivery_plan`.`shipment_plan_id` = `shipment_plan_ref`.`ship_tid`))) */;

/*View structure for view delivery_report_p1 */

/*!50001 DROP TABLE IF EXISTS `delivery_report_p1` */;
/*!50001 DROP VIEW IF EXISTS `delivery_report_p1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `delivery_report_p1` AS (select `shipment_plan`.`buyer_division` AS `buyer_division`,`shipment_plan`.`mpo` AS `mpo`,`shipment_plan`.`cpo` AS `cpo`,`shipment_plan`.`order_no` AS `order_no`,`shipment_plan`.`style` AS `style`,`shipment_plan`.`schedule_no` AS `schedule_no`,`shipment_plan`.`color` AS `color`,`shipment_plan`.`ex_factory_date` AS `ex_factory_date`,`shipment_plan`.`mode` AS `MODE`,`shipment_plan`.`ssc_code` AS `ssc_code`,concat(`shipment_plan`.`order_embl_a`,`shipment_plan`.`order_embl_b`,`shipment_plan`.`order_embl_c`,`shipment_plan`.`order_embl_d`,`shipment_plan`.`order_embl_e`,`shipment_plan`.`order_embl_f`,`shipment_plan`.`order_embl_g`,`shipment_plan`.`order_embl_h`) AS `embl_status`,sum(if(`shipment_plan`.`size` = 'size_xs',`shipment_plan`.`ord_qty`,0)) AS `xs`,sum(if(`shipment_plan`.`size` = 'size_s',`shipment_plan`.`ord_qty`,0)) AS `s`,sum(if(`shipment_plan`.`size` = 'size_m',`shipment_plan`.`ord_qty`,0)) AS `m`,sum(if(`shipment_plan`.`size` = 'size_l',`shipment_plan`.`ord_qty`,0)) AS `l`,sum(if(`shipment_plan`.`size` = 'size_xl',`shipment_plan`.`ord_qty`,0)) AS `xl`,sum(if(`shipment_plan`.`size` = 'size_xxl',`shipment_plan`.`ord_qty`,0)) AS `xxl`,sum(if(`shipment_plan`.`size` = 'size_xxxl',`shipment_plan`.`ord_qty`,0)) AS `xxxl`,sum(if(`shipment_plan`.`size` = 'size_s01',`shipment_plan`.`ord_qty`,0)) AS `s01`,sum(if(`shipment_plan`.`size` = 'size_s02',`shipment_plan`.`ord_qty`,0)) AS `s02`,sum(if(`shipment_plan`.`size` = 'size_s03',`shipment_plan`.`ord_qty`,0)) AS `s03`,sum(if(`shipment_plan`.`size` = 'size_s04',`shipment_plan`.`ord_qty`,0)) AS `s04`,sum(if(`shipment_plan`.`size` = 'size_s05',`shipment_plan`.`ord_qty`,0)) AS `s05`,sum(if(`shipment_plan`.`size` = 'size_s06',`shipment_plan`.`ord_qty`,0)) AS `s06`,sum(if(`shipment_plan`.`size` = 'size_s07',`shipment_plan`.`ord_qty`,0)) AS `s07`,sum(if(`shipment_plan`.`size` = 'size_s08',`shipment_plan`.`ord_qty`,0)) AS `s08`,sum(if(`shipment_plan`.`size` = 'size_s09',`shipment_plan`.`ord_qty`,0)) AS `s09`,sum(if(`shipment_plan`.`size` = 'size_s10',`shipment_plan`.`ord_qty`,0)) AS `s10`,sum(if(`shipment_plan`.`size` = 'size_s11',`shipment_plan`.`ord_qty`,0)) AS `s11`,sum(if(`shipment_plan`.`size` = 'size_s12',`shipment_plan`.`ord_qty`,0)) AS `s12`,sum(if(`shipment_plan`.`size` = 'size_s13',`shipment_plan`.`ord_qty`,0)) AS `s13`,sum(if(`shipment_plan`.`size` = 'size_s14',`shipment_plan`.`ord_qty`,0)) AS `s14`,sum(if(`shipment_plan`.`size` = 'size_s15',`shipment_plan`.`ord_qty`,0)) AS `s15`,sum(if(`shipment_plan`.`size` = 'size_s16',`shipment_plan`.`ord_qty`,0)) AS `s16`,sum(if(`shipment_plan`.`size` = 'size_s17',`shipment_plan`.`ord_qty`,0)) AS `s17`,sum(if(`shipment_plan`.`size` = 'size_s18',`shipment_plan`.`ord_qty`,0)) AS `s18`,sum(if(`shipment_plan`.`size` = 'size_s19',`shipment_plan`.`ord_qty`,0)) AS `s19`,sum(if(`shipment_plan`.`size` = 'size_s20',`shipment_plan`.`ord_qty`,0)) AS `s20`,sum(if(`shipment_plan`.`size` = 'size_s21',`shipment_plan`.`ord_qty`,0)) AS `s21`,sum(if(`shipment_plan`.`size` = 'size_s22',`shipment_plan`.`ord_qty`,0)) AS `s22`,sum(if(`shipment_plan`.`size` = 'size_s23',`shipment_plan`.`ord_qty`,0)) AS `s23`,sum(if(`shipment_plan`.`size` = 'size_s24',`shipment_plan`.`ord_qty`,0)) AS `s24`,sum(if(`shipment_plan`.`size` = 'size_s25',`shipment_plan`.`ord_qty`,0)) AS `s25`,sum(if(`shipment_plan`.`size` = 'size_s26',`shipment_plan`.`ord_qty`,0)) AS `s26`,sum(if(`shipment_plan`.`size` = 'size_s27',`shipment_plan`.`ord_qty`,0)) AS `s27`,sum(if(`shipment_plan`.`size` = 'size_s28',`shipment_plan`.`ord_qty`,0)) AS `s28`,sum(if(`shipment_plan`.`size` = 'size_s29',`shipment_plan`.`ord_qty`,0)) AS `s29`,sum(if(`shipment_plan`.`size` = 'size_s30',`shipment_plan`.`ord_qty`,0)) AS `s30`,sum(if(`shipment_plan`.`size` = 'size_s31',`shipment_plan`.`ord_qty`,0)) AS `s31`,sum(if(`shipment_plan`.`size` = 'size_s32',`shipment_plan`.`ord_qty`,0)) AS `s32`,sum(if(`shipment_plan`.`size` = 'size_s33',`shipment_plan`.`ord_qty`,0)) AS `s33`,sum(if(`shipment_plan`.`size` = 'size_s34',`shipment_plan`.`ord_qty`,0)) AS `s34`,sum(if(`shipment_plan`.`size` = 'size_s35',`shipment_plan`.`ord_qty`,0)) AS `s35`,sum(if(`shipment_plan`.`size` = 'size_s36',`shipment_plan`.`ord_qty`,0)) AS `s36`,sum(if(`shipment_plan`.`size` = 'size_s37',`shipment_plan`.`ord_qty`,0)) AS `s37`,sum(if(`shipment_plan`.`size` = 'size_s38',`shipment_plan`.`ord_qty`,0)) AS `s38`,sum(if(`shipment_plan`.`size` = 'size_s39',`shipment_plan`.`ord_qty`,0)) AS `s39`,sum(if(`shipment_plan`.`size` = 'size_s40',`shipment_plan`.`ord_qty`,0)) AS `s40`,sum(if(`shipment_plan`.`size` = 'size_s41',`shipment_plan`.`ord_qty`,0)) AS `s41`,sum(if(`shipment_plan`.`size` = 'size_s42',`shipment_plan`.`ord_qty`,0)) AS `s42`,sum(if(`shipment_plan`.`size` = 'size_s43',`shipment_plan`.`ord_qty`,0)) AS `s43`,sum(if(`shipment_plan`.`size` = 'size_s44',`shipment_plan`.`ord_qty`,0)) AS `s44`,sum(if(`shipment_plan`.`size` = 'size_s45',`shipment_plan`.`ord_qty`,0)) AS `s45`,sum(if(`shipment_plan`.`size` = 'size_s46',`shipment_plan`.`ord_qty`,0)) AS `s46`,sum(if(`shipment_plan`.`size` = 'size_s47',`shipment_plan`.`ord_qty`,0)) AS `s47`,sum(if(`shipment_plan`.`size` = 'size_s48',`shipment_plan`.`ord_qty`,0)) AS `s48`,sum(if(`shipment_plan`.`size` = 'size_s49',`shipment_plan`.`ord_qty`,0)) AS `s49`,sum(if(`shipment_plan`.`size` = 'size_s50',`shipment_plan`.`ord_qty`,0)) AS `s50` from `shipment_plan` where `shipment_plan`.`schedule_no` in (select distinct `fastreact_plan`.`schedule` AS `SCHEDULE` from `fastreact_plan`) group by `shipment_plan`.`ssc_code`) */;

/*View structure for view fastreact_plan_summary */

/*!50001 DROP TABLE IF EXISTS `fastreact_plan_summary` */;
/*!50001 DROP VIEW IF EXISTS `fastreact_plan_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fastreact_plan_summary` AS (select `fastreact_plan`.`group_code` AS `group_code`,`fastreact_plan`.`module` AS `module`,`fastreact_plan`.`style` AS `style`,`fastreact_plan`.`order_code` AS `order_code`,`fastreact_plan`.`color` AS `color`,`fastreact_plan`.`smv` AS `smv`,`fastreact_plan`.`delivery_date` AS `delivery_date`,`fastreact_plan`.`schedule` AS `schedule`,`fastreact_plan`.`production_date` AS `production_date`,`fastreact_plan`.`qty` AS `qty`,`fastreact_plan`.`tid` AS `tid`,`fastreact_plan`.`week_code` AS `week_code`,`fastreact_plan`.`status` AS `status`,group_concat(distinct `fastreact_plan`.`module` order by `fastreact_plan`.`module` ASC separator ',') AS `execution`,min(`fastreact_plan`.`production_date`) AS `production_start` from `fastreact_plan` group by `fastreact_plan`.`schedule`) */;

/*View structure for view shipment_plan_ref */

/*!50001 DROP TABLE IF EXISTS `shipment_plan_ref` */;
/*!50001 DROP VIEW IF EXISTS `shipment_plan_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `shipment_plan_ref` AS (select `shipment_plan`.`order_no` AS `order_no`,`shipment_plan`.`delivery_no` AS `delivery_no`,`shipment_plan`.`del_status` AS `del_status`,`shipment_plan`.`mpo` AS `mpo`,`shipment_plan`.`cpo` AS `cpo`,`shipment_plan`.`buyer` AS `buyer`,`shipment_plan`.`product` AS `product`,`shipment_plan`.`buyer_division` AS `buyer_division`,`shipment_plan`.`style` AS `style`,`shipment_plan`.`schedule_no` AS `schedule_no`,`shipment_plan`.`color` AS `color`,`shipment_plan`.`size` AS `size`,`shipment_plan`.`z_feature` AS `z_feature`,`shipment_plan`.`ord_qty` AS `ord_qty`,`shipment_plan`.`ex_factory_date` AS `ex_factory_date`,`shipment_plan`.`mode` AS `mode`,`shipment_plan`.`destination` AS `destination`,`shipment_plan`.`packing_method` AS `packing_method`,`shipment_plan`.`fob_price_per_piece` AS `fob_price_per_piece`,`shipment_plan`.`cm_value` AS `cm_value`,`shipment_plan`.`ssc_code` AS `ssc_code`,`shipment_plan`.`ship_tid` AS `ship_tid`,`shipment_plan`.`week_code` AS `week_code`,`shipment_plan`.`status` AS `status`,`shipment_plan`.`ssc_code_new` AS `ssc_code_new`,`shipment_plan`.`order_embl_a` AS `order_embl_a`,`shipment_plan`.`order_embl_b` AS `order_embl_b`,`shipment_plan`.`order_embl_c` AS `order_embl_c`,`shipment_plan`.`order_embl_d` AS `order_embl_d`,`shipment_plan`.`order_embl_e` AS `order_embl_e`,`shipment_plan`.`order_embl_f` AS `order_embl_f`,`shipment_plan`.`order_embl_g` AS `order_embl_g`,`shipment_plan`.`order_embl_h` AS `order_embl_h`,sum(`shipment_plan`.`ord_qty`) AS `ord_qty_new` from `shipment_plan` group by concat(`shipment_plan`.`ssc_code_new`,`shipment_plan`.`delivery_no`,`shipment_plan`.`cw_check`,`shipment_plan`.`size`,`shipment_plan`.`ship_tid`)) */;

/*View structure for view week_delivery_plan_ref */

/*!50001 DROP TABLE IF EXISTS `week_delivery_plan_ref` */;
/*!50001 DROP VIEW IF EXISTS `week_delivery_plan_ref` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `week_delivery_plan_ref` AS (select `shipment_plan_ref`.`ship_tid` AS `ship_tid`,`week_delivery_plan`.`tid` AS `tid`,`shipment_plan_ref`.`buyer_division` AS `buyer_division`,`shipment_plan_ref`.`schedule_no` AS `schedule_no`,`shipment_plan_ref`.`color` AS `color`,`shipment_plan_ref`.`style` AS `style`,`shipment_plan_ref`.`size` AS `size`,`week_delivery_plan`.`original_order_qty` AS `ord_qty_new`,`shipment_plan_ref`.`ord_qty_new` AS `ord_qty_new_old`,`shipment_plan_ref`.`ex_factory_date` AS `m3_ship_plan_ex_fact`,`shipment_plan_ref`.`ex_factory_date` AS `ex_factory_date`,`week_delivery_plan`.`rev_exfactory` AS `rev_exfactory`,if(`week_delivery_plan`.`rev_exfactory` = '0000-00-00',`week_delivery_plan`.`act_exfact`,`week_delivery_plan`.`rev_exfactory`) AS `ex_factory_date_new`,`week_delivery_plan`.`actu_sec1` + `week_delivery_plan`.`actu_sec2` + `week_delivery_plan`.`actu_sec3` + `week_delivery_plan`.`actu_sec4` + `week_delivery_plan`.`actu_sec5` + `week_delivery_plan`.`actu_sec6` + `week_delivery_plan`.`actu_sec7` + `week_delivery_plan`.`actu_sec8` + `week_delivery_plan`.`actu_sec9` + `week_delivery_plan`.`actu_sec10` + `week_delivery_plan`.`actu_sec11` + `week_delivery_plan`.`actu_sec12` + `week_delivery_plan`.`actu_sec13` + `week_delivery_plan`.`actu_sec14` + `week_delivery_plan`.`actu_sec15` AS `output`,`week_delivery_plan`.`act_cut` AS `act_cut`,`week_delivery_plan`.`act_in` AS `act_in`,`week_delivery_plan`.`act_fca` AS `act_fca`,`week_delivery_plan`.`act_mca` AS `act_mca`,`week_delivery_plan`.`act_fg` AS `act_fg`,`week_delivery_plan`.`act_ship` AS `act_ship`,`week_delivery_plan`.`cart_pending` AS `cart_pending`,`week_delivery_plan`.`priority` AS `priority`,`week_delivery_plan`.`ref_id` AS `ref_id`,`week_delivery_plan`.`act_exfact` AS `act_exfact`,`week_delivery_plan`.`act_rej` AS `act_rej`,`week_delivery_plan`.`remarks` AS `remarks` from (`week_delivery_plan` left join `shipment_plan_ref` on(`week_delivery_plan`.`shipment_plan_id` = `shipment_plan_ref`.`ship_tid`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
