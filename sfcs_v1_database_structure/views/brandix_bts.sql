/*
SQLyog Community v13.0.0 (64 bit)
MySQL - 5.5.16-log : Database - brandix_bts
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`brandix_bts` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `brandix_bts`;

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

/*Table structure for table `view_set_2` */

DROP TABLE IF EXISTS `view_set_2`;

/*!50001 DROP VIEW IF EXISTS `view_set_2` */;
/*!50001 DROP TABLE IF EXISTS `view_set_2` */;

/*!50001 CREATE TABLE  `view_set_2`(
 `tbl_orders_size_ref_id` int(11) ,
 `tbl_orders_size_ref_size_name` varchar(50) ,
 `tbl_orders_sizes_master_id` int(6) ,
 `tbl_orders_sizes_master_parent_id` int(6) ,
 `tbl_orders_sizes_master_ref_size_name` int(11) ,
 `tbl_orders_sizes_master_size_title` varchar(255) ,
 `tbl_orders_sizes_master_order_quantity` int(6) ,
 `tbl_orders_sizes_master_order_act_quantity` int(6) ,
 `tbl_orders_sizes_master_order_col_des` varchar(255) ,
 `tbl_orders_master_id` int(11) ,
 `tbl_orders_master_ref_product_style` int(11) ,
 `tbl_orders_master_product_schedule` varchar(50) ,
 `tbl_orders_master_order_status` text ,
 `tbl_orders_style_ref_id` int(11) ,
 `tbl_orders_style_ref_product_style` varchar(70) ,
 `order_id` varchar(318) ,
 `smv` varchar(50) ,
 `order_div` varchar(50) ,
 `order_date` varchar(50) 
)*/;

/*Table structure for table `view_set_3` */

DROP TABLE IF EXISTS `view_set_3`;

/*!50001 DROP VIEW IF EXISTS `view_set_3` */;
/*!50001 DROP TABLE IF EXISTS `view_set_3` */;

/*!50001 CREATE TABLE  `view_set_3`(
 `tbl_min_ord_ref_id` int(11) ,
 `tbl_min_ord_ref_ref_product_style` int(11) ,
 `tbl_min_ord_ref_ref_crt_schedule` int(11) ,
 `tbl_min_ord_ref_carton_quantity` int(11) ,
 `tbl_min_ord_ref_max_bundle_qnty` int(11) ,
 `tbl_min_ord_ref_miximum_bundles_per_size` int(11) ,
 `tbl_min_ord_ref_mini_order_qnty` int(11) ,
 `tbl_min_ord_ref_transac_status` varchar(20) ,
 `tbl_miniorder_data_id` int(11) ,
 `tbl_miniorder_data_date_time` datetime ,
 `tbl_miniorder_data_mini_order_ref` int(11) ,
 `tbl_miniorder_data_mini_order_num` int(5) ,
 `tbl_miniorder_data_cut_num` varchar(15) ,
 `tbl_miniorder_data_color` varchar(255) ,
 `tbl_miniorder_data_size` int(11) ,
 `tbl_miniorder_data_bundle_number` int(6) ,
 `tbl_miniorder_data_quantity` decimal(32,0) ,
 `tbl_miniorder_data_docket_number` varchar(15) ,
 `tbl_miniorder_data_issued_date` datetime ,
 `tbl_miniorder_data_plan_date` datetime ,
 `tbl_miniorder_data_bundle_status` varchar(15) ,
 `tbl_miniorder_data_planned_module` int(11) ,
 `tbl_miniorder_data_mini_order_priority` int(6) ,
 `tbl_miniorder_data_requested_date` datetime ,
 `tbl_miniorder_data_trim_status` text ,
 `tbl_miniorder_data_mini_order_status` varchar(15) ,
 `tbl_orders_master_product_schedule` varchar(50) ,
 `order_id` varchar(318) 
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

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_bund_tran_master` AS (select `bundle_transactions_20_repeat`.`parent_id` AS `parent_id`,`bundle_transactions_20_repeat`.`bundle_id` AS `bundle_id`,`tbl_miniorder_data`.`id` AS `id`,`tbl_orders_ops_ref`.`operation_name` AS `operation_name`,`tbl_orders_ops_ref`.`operation_code` AS `operation_code`,`bundle_transactions`.`date_time` AS `date_time`,`bundle_transactions_20_repeat`.`bundle_barcode` AS `bundle_barcode`,`bundle_transactions_20_repeat`.`quantity` AS `quantity`,`bundle_transactions_20_repeat`.`rejection_quantity` AS `rejection_quantity`,`bundle_transactions_20_repeat`.`operation_id` AS `operation_id`,`bundle_transactions`.`module_id` AS `module_id`,`tbl_shifts_master`.`shift_name` AS `shift_name` from ((((`bundle_transactions_20_repeat` left join `tbl_orders_ops_ref` on((`bundle_transactions_20_repeat`.`operation_id` = `tbl_orders_ops_ref`.`id`))) left join `bundle_transactions` on((`bundle_transactions_20_repeat`.`parent_id` = `bundle_transactions`.`id`))) left join `tbl_shifts_master` on((`bundle_transactions`.`shift` = `tbl_shifts_master`.`id`))) left join `tbl_miniorder_data` on((`bundle_transactions_20_repeat`.`bundle_id` = `tbl_miniorder_data`.`bundle_number`)))) */;

/*View structure for view view_extra_cut */

/*!50001 DROP TABLE IF EXISTS `view_extra_cut` */;
/*!50001 DROP VIEW IF EXISTS `view_extra_cut` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_extra_cut` AS (select `order_cat_doc_mk_mix`.`catyy` AS `catyy`,`order_cat_doc_mk_mix`.`cat_patt_ver` AS `cat_patt_ver`,`order_cat_doc_mk_mix`.`mk_file` AS `mk_file`,`order_cat_doc_mk_mix`.`mk_ver` AS `mk_ver`,`order_cat_doc_mk_mix`.`mklength` AS `mklength`,`order_cat_doc_mk_mix`.`style_id` AS `style_id`,`order_cat_doc_mk_mix`.`col_des` AS `col_des`,`order_cat_doc_mk_mix`.`gmtway` AS `gmtway`,`order_cat_doc_mk_mix`.`strip_match` AS `strip_match`,`order_cat_doc_mk_mix`.`fab_des` AS `fab_des`,`order_cat_doc_mk_mix`.`clubbing` AS `clubbing`,`order_cat_doc_mk_mix`.`date` AS `date`,`order_cat_doc_mk_mix`.`cat_ref` AS `cat_ref`,`order_cat_doc_mk_mix`.`compo_no` AS `compo_no`,`order_cat_doc_mk_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_doc_mk_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_doc_mk_mix`.`mk_ref` AS `mk_ref`,`order_cat_doc_mk_mix`.`order_tid` AS `order_tid`,`order_cat_doc_mk_mix`.`pcutno` AS `pcutno`,`order_cat_doc_mk_mix`.`ratio` AS `ratio`,`order_cat_doc_mk_mix`.`p_xs` AS `p_xs`,`order_cat_doc_mk_mix`.`p_s` AS `p_s`,`order_cat_doc_mk_mix`.`p_m` AS `p_m`,`order_cat_doc_mk_mix`.`p_l` AS `p_l`,`order_cat_doc_mk_mix`.`p_xl` AS `p_xl`,`order_cat_doc_mk_mix`.`p_xxl` AS `p_xxl`,`order_cat_doc_mk_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_doc_mk_mix`.`p_plies` AS `p_plies`,`order_cat_doc_mk_mix`.`doc_no` AS `doc_no`,`order_cat_doc_mk_mix`.`acutno` AS `acutno`,`order_cat_doc_mk_mix`.`a_xs` AS `a_xs`,`order_cat_doc_mk_mix`.`a_s` AS `a_s`,`order_cat_doc_mk_mix`.`a_m` AS `a_m`,`order_cat_doc_mk_mix`.`a_l` AS `a_l`,`order_cat_doc_mk_mix`.`a_xl` AS `a_xl`,`order_cat_doc_mk_mix`.`a_xxl` AS `a_xxl`,`order_cat_doc_mk_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_doc_mk_mix`.`a_plies` AS `a_plies`,`order_cat_doc_mk_mix`.`lastup` AS `lastup`,`order_cat_doc_mk_mix`.`remarks` AS `remarks`,`order_cat_doc_mk_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_doc_mk_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_doc_mk_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_doc_mk_mix`.`print_status` AS `print_status`,`order_cat_doc_mk_mix`.`a_s01` AS `a_s01`,`order_cat_doc_mk_mix`.`a_s02` AS `a_s02`,`order_cat_doc_mk_mix`.`a_s03` AS `a_s03`,`order_cat_doc_mk_mix`.`a_s04` AS `a_s04`,`order_cat_doc_mk_mix`.`a_s05` AS `a_s05`,`order_cat_doc_mk_mix`.`a_s06` AS `a_s06`,`order_cat_doc_mk_mix`.`a_s07` AS `a_s07`,`order_cat_doc_mk_mix`.`a_s08` AS `a_s08`,`order_cat_doc_mk_mix`.`a_s09` AS `a_s09`,`order_cat_doc_mk_mix`.`a_s10` AS `a_s10`,`order_cat_doc_mk_mix`.`a_s11` AS `a_s11`,`order_cat_doc_mk_mix`.`a_s12` AS `a_s12`,`order_cat_doc_mk_mix`.`a_s13` AS `a_s13`,`order_cat_doc_mk_mix`.`a_s14` AS `a_s14`,`order_cat_doc_mk_mix`.`a_s15` AS `a_s15`,`order_cat_doc_mk_mix`.`a_s16` AS `a_s16`,`order_cat_doc_mk_mix`.`a_s17` AS `a_s17`,`order_cat_doc_mk_mix`.`a_s18` AS `a_s18`,`order_cat_doc_mk_mix`.`a_s19` AS `a_s19`,`order_cat_doc_mk_mix`.`a_s20` AS `a_s20`,`order_cat_doc_mk_mix`.`a_s21` AS `a_s21`,`order_cat_doc_mk_mix`.`a_s22` AS `a_s22`,`order_cat_doc_mk_mix`.`a_s23` AS `a_s23`,`order_cat_doc_mk_mix`.`a_s24` AS `a_s24`,`order_cat_doc_mk_mix`.`a_s25` AS `a_s25`,`order_cat_doc_mk_mix`.`a_s26` AS `a_s26`,`order_cat_doc_mk_mix`.`a_s27` AS `a_s27`,`order_cat_doc_mk_mix`.`a_s28` AS `a_s28`,`order_cat_doc_mk_mix`.`a_s29` AS `a_s29`,`order_cat_doc_mk_mix`.`a_s30` AS `a_s30`,`order_cat_doc_mk_mix`.`a_s31` AS `a_s31`,`order_cat_doc_mk_mix`.`a_s32` AS `a_s32`,`order_cat_doc_mk_mix`.`a_s33` AS `a_s33`,`order_cat_doc_mk_mix`.`a_s34` AS `a_s34`,`order_cat_doc_mk_mix`.`a_s35` AS `a_s35`,`order_cat_doc_mk_mix`.`a_s36` AS `a_s36`,`order_cat_doc_mk_mix`.`a_s37` AS `a_s37`,`order_cat_doc_mk_mix`.`a_s38` AS `a_s38`,`order_cat_doc_mk_mix`.`a_s39` AS `a_s39`,`order_cat_doc_mk_mix`.`a_s40` AS `a_s40`,`order_cat_doc_mk_mix`.`a_s41` AS `a_s41`,`order_cat_doc_mk_mix`.`a_s42` AS `a_s42`,`order_cat_doc_mk_mix`.`a_s43` AS `a_s43`,`order_cat_doc_mk_mix`.`a_s44` AS `a_s44`,`order_cat_doc_mk_mix`.`a_s45` AS `a_s45`,`order_cat_doc_mk_mix`.`a_s46` AS `a_s46`,`order_cat_doc_mk_mix`.`a_s47` AS `a_s47`,`order_cat_doc_mk_mix`.`a_s48` AS `a_s48`,`order_cat_doc_mk_mix`.`a_s49` AS `a_s49`,`order_cat_doc_mk_mix`.`a_s50` AS `a_s50`,`order_cat_doc_mk_mix`.`p_s01` AS `p_s01`,`order_cat_doc_mk_mix`.`p_s02` AS `p_s02`,`order_cat_doc_mk_mix`.`p_s03` AS `p_s03`,`order_cat_doc_mk_mix`.`p_s04` AS `p_s04`,`order_cat_doc_mk_mix`.`p_s05` AS `p_s05`,`order_cat_doc_mk_mix`.`p_s06` AS `p_s06`,`order_cat_doc_mk_mix`.`p_s07` AS `p_s07`,`order_cat_doc_mk_mix`.`p_s08` AS `p_s08`,`order_cat_doc_mk_mix`.`p_s09` AS `p_s09`,`order_cat_doc_mk_mix`.`p_s10` AS `p_s10`,`order_cat_doc_mk_mix`.`p_s11` AS `p_s11`,`order_cat_doc_mk_mix`.`p_s12` AS `p_s12`,`order_cat_doc_mk_mix`.`p_s13` AS `p_s13`,`order_cat_doc_mk_mix`.`p_s14` AS `p_s14`,`order_cat_doc_mk_mix`.`p_s15` AS `p_s15`,`order_cat_doc_mk_mix`.`p_s16` AS `p_s16`,`order_cat_doc_mk_mix`.`p_s17` AS `p_s17`,`order_cat_doc_mk_mix`.`p_s18` AS `p_s18`,`order_cat_doc_mk_mix`.`p_s19` AS `p_s19`,`order_cat_doc_mk_mix`.`p_s20` AS `p_s20`,`order_cat_doc_mk_mix`.`p_s21` AS `p_s21`,`order_cat_doc_mk_mix`.`p_s22` AS `p_s22`,`order_cat_doc_mk_mix`.`p_s23` AS `p_s23`,`order_cat_doc_mk_mix`.`p_s24` AS `p_s24`,`order_cat_doc_mk_mix`.`p_s25` AS `p_s25`,`order_cat_doc_mk_mix`.`p_s26` AS `p_s26`,`order_cat_doc_mk_mix`.`p_s27` AS `p_s27`,`order_cat_doc_mk_mix`.`p_s28` AS `p_s28`,`order_cat_doc_mk_mix`.`p_s29` AS `p_s29`,`order_cat_doc_mk_mix`.`p_s30` AS `p_s30`,`order_cat_doc_mk_mix`.`p_s31` AS `p_s31`,`order_cat_doc_mk_mix`.`p_s32` AS `p_s32`,`order_cat_doc_mk_mix`.`p_s33` AS `p_s33`,`order_cat_doc_mk_mix`.`p_s34` AS `p_s34`,`order_cat_doc_mk_mix`.`p_s35` AS `p_s35`,`order_cat_doc_mk_mix`.`p_s36` AS `p_s36`,`order_cat_doc_mk_mix`.`p_s37` AS `p_s37`,`order_cat_doc_mk_mix`.`p_s38` AS `p_s38`,`order_cat_doc_mk_mix`.`p_s39` AS `p_s39`,`order_cat_doc_mk_mix`.`p_s40` AS `p_s40`,`order_cat_doc_mk_mix`.`p_s41` AS `p_s41`,`order_cat_doc_mk_mix`.`p_s42` AS `p_s42`,`order_cat_doc_mk_mix`.`p_s43` AS `p_s43`,`order_cat_doc_mk_mix`.`p_s44` AS `p_s44`,`order_cat_doc_mk_mix`.`p_s45` AS `p_s45`,`order_cat_doc_mk_mix`.`p_s46` AS `p_s46`,`order_cat_doc_mk_mix`.`p_s47` AS `p_s47`,`order_cat_doc_mk_mix`.`p_s48` AS `p_s48`,`order_cat_doc_mk_mix`.`p_s49` AS `p_s49`,`order_cat_doc_mk_mix`.`p_s50` AS `p_s50`,`order_cat_doc_mk_mix`.`rm_date` AS `rm_date`,`order_cat_doc_mk_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_doc_mk_mix`.`plan_module` AS `plan_module`,`order_cat_doc_mk_mix`.`category` AS `category`,`order_cat_doc_mk_mix`.`color_code` AS `color_code`,`order_cat_doc_mk_mix`.`fabric_status` AS `fabric_status`,`order_cat_doc_mk_mix`.`material_req` AS `material_req`,`order_cat_doc_mk_mix`.`order_del_no` AS `order_del_no`,`order_cat_doc_mk_mix`.`order_col_des` AS `order_col_des` from (`bai_pro3`.`order_cat_doc_mk_mix` left join `brandix_bts`.`tbl_cut_master` on((`brandix_bts`.`tbl_cut_master`.`doc_num` = `order_cat_doc_mk_mix`.`doc_no`))) where ((`order_cat_doc_mk_mix`.`category` in ('Body','Front')) and (length(`order_cat_doc_mk_mix`.`order_del_no`) < '8') and (`order_cat_doc_mk_mix`.`style_id` not in (74029,23923,74026,73927)) and isnull(`brandix_bts`.`tbl_cut_master`.`id`) and `order_cat_doc_mk_mix`.`order_del_no` in (select `brandix_bts`.`tbl_orders_master`.`product_schedule` from `brandix_bts`.`tbl_orders_master`))) */;

/*View structure for view view_extra_recut */

/*!50001 DROP TABLE IF EXISTS `view_extra_recut` */;
/*!50001 DROP VIEW IF EXISTS `view_extra_recut` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_extra_recut` AS (select `order_cat_recut_doc_mix`.`date` AS `date`,`order_cat_recut_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_recut_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_recut_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_recut_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_recut_doc_mix`.`order_tid` AS `order_tid`,`order_cat_recut_doc_mix`.`pcutno` AS `pcutno`,`order_cat_recut_doc_mix`.`ratio` AS `ratio`,`order_cat_recut_doc_mix`.`p_xs` AS `p_xs`,`order_cat_recut_doc_mix`.`p_s` AS `p_s`,`order_cat_recut_doc_mix`.`p_m` AS `p_m`,`order_cat_recut_doc_mix`.`p_l` AS `p_l`,`order_cat_recut_doc_mix`.`p_xl` AS `p_xl`,`order_cat_recut_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_recut_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_recut_doc_mix`.`p_plies` AS `p_plies`,concat('R',`order_cat_recut_doc_mix`.`doc_no`) AS `doc_no`,`order_cat_recut_doc_mix`.`acutno` AS `acutno`,`order_cat_recut_doc_mix`.`a_xs` AS `a_xs`,`order_cat_recut_doc_mix`.`a_s` AS `a_s`,`order_cat_recut_doc_mix`.`a_m` AS `a_m`,`order_cat_recut_doc_mix`.`a_l` AS `a_l`,`order_cat_recut_doc_mix`.`a_xl` AS `a_xl`,`order_cat_recut_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_recut_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_recut_doc_mix`.`a_plies` AS `a_plies`,`order_cat_recut_doc_mix`.`lastup` AS `lastup`,`order_cat_recut_doc_mix`.`remarks` AS `remarks`,`order_cat_recut_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_recut_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_recut_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_recut_doc_mix`.`print_status` AS `print_status`,`order_cat_recut_doc_mix`.`a_s01` AS `a_s01`,`order_cat_recut_doc_mix`.`a_s02` AS `a_s02`,`order_cat_recut_doc_mix`.`a_s03` AS `a_s03`,`order_cat_recut_doc_mix`.`a_s04` AS `a_s04`,`order_cat_recut_doc_mix`.`a_s05` AS `a_s05`,`order_cat_recut_doc_mix`.`a_s06` AS `a_s06`,`order_cat_recut_doc_mix`.`a_s07` AS `a_s07`,`order_cat_recut_doc_mix`.`a_s08` AS `a_s08`,`order_cat_recut_doc_mix`.`a_s09` AS `a_s09`,`order_cat_recut_doc_mix`.`a_s10` AS `a_s10`,`order_cat_recut_doc_mix`.`a_s11` AS `a_s11`,`order_cat_recut_doc_mix`.`a_s12` AS `a_s12`,`order_cat_recut_doc_mix`.`a_s13` AS `a_s13`,`order_cat_recut_doc_mix`.`a_s14` AS `a_s14`,`order_cat_recut_doc_mix`.`a_s15` AS `a_s15`,`order_cat_recut_doc_mix`.`a_s16` AS `a_s16`,`order_cat_recut_doc_mix`.`a_s17` AS `a_s17`,`order_cat_recut_doc_mix`.`a_s18` AS `a_s18`,`order_cat_recut_doc_mix`.`a_s19` AS `a_s19`,`order_cat_recut_doc_mix`.`a_s20` AS `a_s20`,`order_cat_recut_doc_mix`.`a_s21` AS `a_s21`,`order_cat_recut_doc_mix`.`a_s22` AS `a_s22`,`order_cat_recut_doc_mix`.`a_s23` AS `a_s23`,`order_cat_recut_doc_mix`.`a_s24` AS `a_s24`,`order_cat_recut_doc_mix`.`a_s25` AS `a_s25`,`order_cat_recut_doc_mix`.`a_s26` AS `a_s26`,`order_cat_recut_doc_mix`.`a_s27` AS `a_s27`,`order_cat_recut_doc_mix`.`a_s28` AS `a_s28`,`order_cat_recut_doc_mix`.`a_s29` AS `a_s29`,`order_cat_recut_doc_mix`.`a_s30` AS `a_s30`,`order_cat_recut_doc_mix`.`a_s31` AS `a_s31`,`order_cat_recut_doc_mix`.`a_s32` AS `a_s32`,`order_cat_recut_doc_mix`.`a_s33` AS `a_s33`,`order_cat_recut_doc_mix`.`a_s34` AS `a_s34`,`order_cat_recut_doc_mix`.`a_s35` AS `a_s35`,`order_cat_recut_doc_mix`.`a_s36` AS `a_s36`,`order_cat_recut_doc_mix`.`a_s37` AS `a_s37`,`order_cat_recut_doc_mix`.`a_s38` AS `a_s38`,`order_cat_recut_doc_mix`.`a_s39` AS `a_s39`,`order_cat_recut_doc_mix`.`a_s40` AS `a_s40`,`order_cat_recut_doc_mix`.`a_s41` AS `a_s41`,`order_cat_recut_doc_mix`.`a_s42` AS `a_s42`,`order_cat_recut_doc_mix`.`a_s43` AS `a_s43`,`order_cat_recut_doc_mix`.`a_s44` AS `a_s44`,`order_cat_recut_doc_mix`.`a_s45` AS `a_s45`,`order_cat_recut_doc_mix`.`a_s46` AS `a_s46`,`order_cat_recut_doc_mix`.`a_s47` AS `a_s47`,`order_cat_recut_doc_mix`.`a_s48` AS `a_s48`,`order_cat_recut_doc_mix`.`a_s49` AS `a_s49`,`order_cat_recut_doc_mix`.`a_s50` AS `a_s50`,`order_cat_recut_doc_mix`.`p_s01` AS `p_s01`,`order_cat_recut_doc_mix`.`p_s02` AS `p_s02`,`order_cat_recut_doc_mix`.`p_s03` AS `p_s03`,`order_cat_recut_doc_mix`.`p_s04` AS `p_s04`,`order_cat_recut_doc_mix`.`p_s05` AS `p_s05`,`order_cat_recut_doc_mix`.`p_s06` AS `p_s06`,`order_cat_recut_doc_mix`.`p_s07` AS `p_s07`,`order_cat_recut_doc_mix`.`p_s08` AS `p_s08`,`order_cat_recut_doc_mix`.`p_s09` AS `p_s09`,`order_cat_recut_doc_mix`.`p_s10` AS `p_s10`,`order_cat_recut_doc_mix`.`p_s11` AS `p_s11`,`order_cat_recut_doc_mix`.`p_s12` AS `p_s12`,`order_cat_recut_doc_mix`.`p_s13` AS `p_s13`,`order_cat_recut_doc_mix`.`p_s14` AS `p_s14`,`order_cat_recut_doc_mix`.`p_s15` AS `p_s15`,`order_cat_recut_doc_mix`.`p_s16` AS `p_s16`,`order_cat_recut_doc_mix`.`p_s17` AS `p_s17`,`order_cat_recut_doc_mix`.`p_s18` AS `p_s18`,`order_cat_recut_doc_mix`.`p_s19` AS `p_s19`,`order_cat_recut_doc_mix`.`p_s20` AS `p_s20`,`order_cat_recut_doc_mix`.`p_s21` AS `p_s21`,`order_cat_recut_doc_mix`.`p_s22` AS `p_s22`,`order_cat_recut_doc_mix`.`p_s23` AS `p_s23`,`order_cat_recut_doc_mix`.`p_s24` AS `p_s24`,`order_cat_recut_doc_mix`.`p_s25` AS `p_s25`,`order_cat_recut_doc_mix`.`p_s26` AS `p_s26`,`order_cat_recut_doc_mix`.`p_s27` AS `p_s27`,`order_cat_recut_doc_mix`.`p_s28` AS `p_s28`,`order_cat_recut_doc_mix`.`p_s29` AS `p_s29`,`order_cat_recut_doc_mix`.`p_s30` AS `p_s30`,`order_cat_recut_doc_mix`.`p_s31` AS `p_s31`,`order_cat_recut_doc_mix`.`p_s32` AS `p_s32`,`order_cat_recut_doc_mix`.`p_s33` AS `p_s33`,`order_cat_recut_doc_mix`.`p_s34` AS `p_s34`,`order_cat_recut_doc_mix`.`p_s35` AS `p_s35`,`order_cat_recut_doc_mix`.`p_s36` AS `p_s36`,`order_cat_recut_doc_mix`.`p_s37` AS `p_s37`,`order_cat_recut_doc_mix`.`p_s38` AS `p_s38`,`order_cat_recut_doc_mix`.`p_s39` AS `p_s39`,`order_cat_recut_doc_mix`.`p_s40` AS `p_s40`,`order_cat_recut_doc_mix`.`p_s41` AS `p_s41`,`order_cat_recut_doc_mix`.`p_s42` AS `p_s42`,`order_cat_recut_doc_mix`.`p_s43` AS `p_s43`,`order_cat_recut_doc_mix`.`p_s44` AS `p_s44`,`order_cat_recut_doc_mix`.`p_s45` AS `p_s45`,`order_cat_recut_doc_mix`.`p_s46` AS `p_s46`,`order_cat_recut_doc_mix`.`p_s47` AS `p_s47`,`order_cat_recut_doc_mix`.`p_s48` AS `p_s48`,`order_cat_recut_doc_mix`.`p_s49` AS `p_s49`,`order_cat_recut_doc_mix`.`p_s50` AS `p_s50`,`order_cat_recut_doc_mix`.`rm_date` AS `rm_date`,`order_cat_recut_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_recut_doc_mix`.`plan_module` AS `plan_module`,`order_cat_recut_doc_mix`.`category` AS `category`,`order_cat_recut_doc_mix`.`color_code` AS `color_code`,`order_cat_recut_doc_mix`.`fabric_status` AS `fabric_status`,`order_cat_recut_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_recut_doc_mix`.`plan_lot_ref` AS `plan_lot_ref`,`order_cat_recut_doc_mix`.`order_col_des` AS `order_col_des`,`order_cat_recut_doc_mix`.`order_style_no` AS `order_style_no` from (`bai_pro3`.`order_cat_recut_doc_mix` left join `brandix_bts`.`tbl_cut_master` on((`brandix_bts`.`tbl_cut_master`.`doc_num` = concat('R',`order_cat_recut_doc_mix`.`doc_no`)))) where ((`order_cat_recut_doc_mix`.`category` in ('Body','Front')) and (`order_cat_recut_doc_mix`.`act_cut_status` = 'DONE') and isnull(`brandix_bts`.`tbl_cut_master`.`id`) and `order_cat_recut_doc_mix`.`order_del_no` in (select `brandix_bts`.`tbl_orders_master`.`product_schedule` from `brandix_bts`.`tbl_orders_master`))) */;

/*View structure for view view_set_1 */

/*!50001 DROP TABLE IF EXISTS `view_set_1` */;
/*!50001 DROP VIEW IF EXISTS `view_set_1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_1` AS (select `bundle_transactions_20_repeat`.`id` AS `bundle_transactions_20_repeat_id`,`bundle_transactions_20_repeat`.`parent_id` AS `bundle_transactions_20_repeat_parent_id`,`bundle_transactions_20_repeat`.`bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,`bundle_transactions_20_repeat`.`quantity` AS `bundle_transactions_20_repeat_quantity`,`bundle_transactions_20_repeat`.`bundle_id` AS `bundle_transactions_20_repeat_bundle_id`,`bundle_transactions_20_repeat`.`operation_id` AS `bundle_transactions_20_repeat_operation_id`,`bundle_transactions_20_repeat`.`rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,if((`bundle_transactions_20_repeat`.`act_module` > 0),`bundle_transactions_20_repeat`.`act_module`,`bundle_transactions`.`module_id`) AS `bundle_transactions_20_repeat_act_module`,`tbl_orders_ops_ref`.`id` AS `tbl_orders_ops_ref_id`,`tbl_orders_ops_ref`.`operation_name` AS `tbl_orders_ops_ref_operation_name`,`tbl_orders_ops_ref`.`default_operation` AS `tbl_orders_ops_ref_default_operation`,`tbl_orders_ops_ref`.`operation_code` AS `tbl_orders_ops_ref_operation_code`,`bundle_transactions`.`id` AS `bundle_transactions_id`,`bundle_transactions`.`date_time` AS `bundle_transactions_date_time`,`bundle_transactions`.`operation_time` AS `bundle_transactions_operation_time`,`bundle_transactions`.`employee_id` AS `bundle_transactions_employee_id`,`bundle_transactions`.`shift` AS `bundle_transactions_shift`,`bundle_transactions`.`trans_status` AS `bundle_transactions_trans_status`,`bundle_transactions`.`module_id` AS `bundle_transactions_module_id`,`tbl_shifts_master`.`id` AS `tbl_shifts_master_id`,`tbl_shifts_master`.`date_time` AS `tbl_shifts_master_date_time`,`tbl_shifts_master`.`shift_name` AS `tbl_shifts_master_shift_name` from (((`bundle_transactions_20_repeat` left join `tbl_orders_ops_ref` on((`bundle_transactions_20_repeat`.`operation_id` = `tbl_orders_ops_ref`.`id`))) left join `bundle_transactions` on((`bundle_transactions_20_repeat`.`parent_id` = `bundle_transactions`.`id`))) left join `tbl_shifts_master` on((`tbl_shifts_master`.`id` = `bundle_transactions`.`shift`)))) */;

/*View structure for view view_set_1_virtual */

/*!50001 DROP TABLE IF EXISTS `view_set_1_virtual` */;
/*!50001 DROP VIEW IF EXISTS `view_set_1_virtual` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_1_virtual` AS (select `bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`id` AS `bundle_transactions_20_repeat_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`parent_id` AS `bundle_transactions_20_repeat_parent_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`quantity` AS `bundle_transactions_20_repeat_quantity`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`bundle_id` AS `bundle_transactions_20_repeat_bundle_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`operation_id` AS `bundle_transactions_20_repeat_operation_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,if((`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`act_module` > 0),`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`act_module`,`bundle_transactions`.`module_id`) AS `bundle_transactions_20_repeat_act_module`,`tbl_orders_ops_ref`.`id` AS `tbl_orders_ops_ref_id`,`tbl_orders_ops_ref`.`operation_name` AS `tbl_orders_ops_ref_operation_name`,`tbl_orders_ops_ref`.`default_operation` AS `tbl_orders_ops_ref_default_operation`,`tbl_orders_ops_ref`.`operation_code` AS `tbl_orders_ops_ref_operation_code`,`bundle_transactions`.`id` AS `bundle_transactions_id`,`bundle_transactions`.`date_time` AS `bundle_transactions_date_time`,`bundle_transactions`.`operation_time` AS `bundle_transactions_operation_time`,`bundle_transactions`.`employee_id` AS `bundle_transactions_employee_id`,`bundle_transactions`.`shift` AS `bundle_transactions_shift`,`bundle_transactions`.`trans_status` AS `bundle_transactions_trans_status`,`bundle_transactions`.`module_id` AS `bundle_transactions_module_id`,`tbl_shifts_master`.`id` AS `tbl_shifts_master_id`,`tbl_shifts_master`.`date_time` AS `tbl_shifts_master_date_time`,`tbl_shifts_master`.`shift_name` AS `tbl_shifts_master_shift_name` from (((`bundle_transactions_20_repeat_virtual_snap_ini_bundles` left join `tbl_orders_ops_ref` on((`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`operation_id` = `tbl_orders_ops_ref`.`id`))) left join `bundle_transactions` on((`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`parent_id` = `bundle_transactions`.`id`))) left join `tbl_shifts_master` on((`tbl_shifts_master`.`id` = `bundle_transactions`.`shift`)))) */;

/*View structure for view view_set_2 */

/*!50001 DROP TABLE IF EXISTS `view_set_2` */;
/*!50001 DROP VIEW IF EXISTS `view_set_2` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_2` AS (select `brandix_bts`.`tbl_orders_size_ref`.`id` AS `tbl_orders_size_ref_id`,`brandix_bts`.`tbl_orders_size_ref`.`size_name` AS `tbl_orders_size_ref_size_name`,`brandix_bts`.`tbl_orders_sizes_master`.`id` AS `tbl_orders_sizes_master_id`,`brandix_bts`.`tbl_orders_sizes_master`.`parent_id` AS `tbl_orders_sizes_master_parent_id`,`brandix_bts`.`tbl_orders_sizes_master`.`ref_size_name` AS `tbl_orders_sizes_master_ref_size_name`,`brandix_bts`.`tbl_orders_sizes_master`.`size_title` AS `tbl_orders_sizes_master_size_title`,`brandix_bts`.`tbl_orders_sizes_master`.`order_quantity` AS `tbl_orders_sizes_master_order_quantity`,`brandix_bts`.`tbl_orders_sizes_master`.`order_act_quantity` AS `tbl_orders_sizes_master_order_act_quantity`,`brandix_bts`.`tbl_orders_sizes_master`.`order_col_des` AS `tbl_orders_sizes_master_order_col_des`,`brandix_bts`.`tbl_orders_master`.`id` AS `tbl_orders_master_id`,`brandix_bts`.`tbl_orders_master`.`ref_product_style` AS `tbl_orders_master_ref_product_style`,`brandix_bts`.`tbl_orders_master`.`product_schedule` AS `tbl_orders_master_product_schedule`,`brandix_bts`.`tbl_orders_master`.`order_status` AS `tbl_orders_master_order_status`,`brandix_bts`.`tbl_orders_style_ref`.`id` AS `tbl_orders_style_ref_id`,`brandix_bts`.`tbl_orders_style_ref`.`product_style` AS `tbl_orders_style_ref_product_style`,concat(`brandix_bts`.`tbl_orders_master`.`product_schedule`,'-',`brandix_bts`.`tbl_orders_sizes_master`.`order_col_des`,'-',`brandix_bts`.`tbl_orders_sizes_master`.`ref_size_name`) AS `order_id`,`brandix_bts`.`fn_bai_pro3_smv_details`(`brandix_bts`.`tbl_orders_master`.`product_schedule`,`brandix_bts`.`tbl_orders_sizes_master`.`order_col_des`) AS `smv`,`brandix_bts`.`fn_bai_pro3_sch_details`(`brandix_bts`.`tbl_orders_master`.`product_schedule`,'orderdiv') AS `order_div`,`brandix_bts`.`fn_bai_pro3_sch_details`(`brandix_bts`.`tbl_orders_master`.`product_schedule`,'orderdate') AS `order_date` from (((`brandix_bts`.`tbl_orders_sizes_master` left join `brandix_bts`.`tbl_orders_master` on((`brandix_bts`.`tbl_orders_master`.`id` = `brandix_bts`.`tbl_orders_sizes_master`.`parent_id`))) left join `brandix_bts`.`tbl_orders_size_ref` on((`brandix_bts`.`tbl_orders_sizes_master`.`ref_size_name` = `brandix_bts`.`tbl_orders_size_ref`.`id`))) left join `brandix_bts`.`tbl_orders_style_ref` on((`brandix_bts`.`tbl_orders_style_ref`.`id` = `brandix_bts`.`tbl_orders_master`.`ref_product_style`))) where (length(`brandix_bts`.`tbl_orders_master`.`product_schedule`) < '8')) */;

/*View structure for view view_set_3 */

/*!50001 DROP TABLE IF EXISTS `view_set_3` */;
/*!50001 DROP VIEW IF EXISTS `view_set_3` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_3` AS (select `tbl_min_ord_ref`.`id` AS `tbl_min_ord_ref_id`,`tbl_min_ord_ref`.`ref_product_style` AS `tbl_min_ord_ref_ref_product_style`,`tbl_min_ord_ref`.`ref_crt_schedule` AS `tbl_min_ord_ref_ref_crt_schedule`,`tbl_min_ord_ref`.`carton_quantity` AS `tbl_min_ord_ref_carton_quantity`,`tbl_min_ord_ref`.`max_bundle_qnty` AS `tbl_min_ord_ref_max_bundle_qnty`,`tbl_min_ord_ref`.`miximum_bundles_per_size` AS `tbl_min_ord_ref_miximum_bundles_per_size`,`tbl_min_ord_ref`.`mini_order_qnty` AS `tbl_min_ord_ref_mini_order_qnty`,`tbl_min_ord_ref`.`transac_status` AS `tbl_min_ord_ref_transac_status`,`tbl_miniorder_data`.`id` AS `tbl_miniorder_data_id`,`tbl_miniorder_data`.`date_time` AS `tbl_miniorder_data_date_time`,`tbl_miniorder_data`.`mini_order_ref` AS `tbl_miniorder_data_mini_order_ref`,`tbl_miniorder_data`.`mini_order_num` AS `tbl_miniorder_data_mini_order_num`,`tbl_miniorder_data`.`cut_num` AS `tbl_miniorder_data_cut_num`,`tbl_miniorder_data`.`color` AS `tbl_miniorder_data_color`,`tbl_miniorder_data`.`size` AS `tbl_miniorder_data_size`,`tbl_miniorder_data`.`bundle_number` AS `tbl_miniorder_data_bundle_number`,sum(`tbl_miniorder_data`.`quantity`) AS `tbl_miniorder_data_quantity`,`tbl_miniorder_data`.`docket_number` AS `tbl_miniorder_data_docket_number`,`tbl_miniorder_data`.`issued_date` AS `tbl_miniorder_data_issued_date`,`tbl_miniorder_data`.`plan_date` AS `tbl_miniorder_data_plan_date`,`tbl_miniorder_data`.`bundle_status` AS `tbl_miniorder_data_bundle_status`,`tbl_miniorder_data`.`planned_module` AS `tbl_miniorder_data_planned_module`,`tbl_miniorder_data`.`mini_order_priority` AS `tbl_miniorder_data_mini_order_priority`,`tbl_miniorder_data`.`requested_date` AS `tbl_miniorder_data_requested_date`,`tbl_miniorder_data`.`trim_status` AS `tbl_miniorder_data_trim_status`,`tbl_miniorder_data`.`mini_order_status` AS `tbl_miniorder_data_mini_order_status`,`tbl_orders_master`.`product_schedule` AS `tbl_orders_master_product_schedule`,concat(`tbl_orders_master`.`product_schedule`,'-',`tbl_miniorder_data`.`color`,'-',`tbl_miniorder_data`.`size`) AS `order_id` from ((`tbl_miniorder_data` left join `tbl_min_ord_ref` on((`tbl_min_ord_ref`.`id` = `tbl_miniorder_data`.`mini_order_ref`))) left join `tbl_orders_master` on((`tbl_min_ord_ref`.`ref_crt_schedule` = `tbl_orders_master`.`id`))) group by `tbl_miniorder_data`.`bundle_number`) */;

/*View structure for view view_set_4 */

/*!50001 DROP TABLE IF EXISTS `view_set_4` */;
/*!50001 DROP VIEW IF EXISTS `view_set_4` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_4` AS (select cast(`pacstat`.`scan_date` as date) AS `date`,`orders`.`order_style_no` AS `style`,`orders`.`order_del_no` AS `SCHEDULE`,sum(`pacstat`.`carton_act_qty`) AS `cpk_qty`,concat(cast(`pacstat`.`scan_date` as date),convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8)) AS `order_tid_new` from ((`bai_pro3`.`pac_stat_log` `pacstat` left join `bai_pro3`.`plandoc_stat_log` `plandoc` on((`plandoc`.`doc_no` = `pacstat`.`doc_no`))) left join `bai_pro3`.`bai_orders_db_confirm` `orders` on((`orders`.`order_tid` = `plandoc`.`order_tid`))) where (`pacstat`.`status` = 'DONE') group by cast(`pacstat`.`scan_date` as date),`orders`.`order_style_no`,`orders`.`order_del_no`) */;

/*View structure for view view_set_5 */

/*!50001 DROP TABLE IF EXISTS `view_set_5` */;
/*!50001 DROP VIEW IF EXISTS `view_set_5` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_5` AS (select `bai_pro3`.`bai_qms_db`.`log_date` AS `log_date`,`bai_pro3`.`bai_qms_db`.`qms_style` AS `qms_style`,`bai_pro3`.`bai_qms_db`.`qms_schedule` AS `qms_schedule`,sum(`bai_pro3`.`bai_qms_db`.`qms_qty`) AS `rejected_qty` from `bai_pro3`.`bai_qms_db` where (`bai_pro3`.`bai_qms_db`.`qms_tran_type` in (3,4,5)) group by `bai_pro3`.`bai_qms_db`.`log_date`,`bai_pro3`.`bai_qms_db`.`qms_schedule`) */;

/*View structure for view view_set_6 */

/*!50001 DROP TABLE IF EXISTS `view_set_6` */;
/*!50001 DROP VIEW IF EXISTS `view_set_6` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_6` AS (select cast(`pacstat`.`scan_date` as date) AS `date`,`orders`.`order_style_no` AS `style`,`orders`.`order_del_no` AS `SCHEDULE`,`orders`.`order_col_des` AS `color`,`orders_mas_size`.`size_title` AS `size`,sum(`pacstat`.`carton_act_qty`) AS `cpk_qty`,concat(convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8),convert(`orders`.`order_col_des` using utf8),`orders_mas_size`.`size_title`) AS `order_tid_new`,1 AS `barcode`,concat(cast(`pacstat`.`scan_date` as date),convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8),convert(`orders`.`order_col_des` using utf8),`orders_mas_size`.`size_title`) AS `order_tid_new_2` from (((((`bai_pro3`.`pac_stat_log` `pacstat` left join `bai_pro3`.`plandoc_stat_log` `plandoc` on((`plandoc`.`doc_no` = `pacstat`.`doc_no`))) left join `bai_pro3`.`bai_orders_db_confirm` `orders` on((`orders`.`order_tid` = `plandoc`.`order_tid`))) left join `brandix_bts`.`tbl_orders_size_ref` `sizes` on((convert(`pacstat`.`size_code` using utf8) = `sizes`.`size_name`))) left join `brandix_bts`.`tbl_orders_master` `orders_mas` on((`orders_mas`.`product_schedule` = convert(`orders`.`order_del_no` using utf8)))) left join `brandix_bts`.`tbl_orders_sizes_master` `orders_mas_size` on((`orders_mas_size`.`parent_id` = `orders_mas`.`id`))) where ((`pacstat`.`status` = 'DONE') and (`orders_mas_size`.`order_col_des` = convert(`orders`.`order_col_des` using utf8)) and (`orders_mas_size`.`ref_size_name` = `sizes`.`id`)) group by cast(`pacstat`.`scan_date` as date),`orders`.`order_style_no`,`orders`.`order_del_no`,`orders`.`order_col_des`,`orders_mas_size`.`size_title`) */;

/*View structure for view view_set_snap_1 */

/*!50001 DROP TABLE IF EXISTS `view_set_snap_1` */;
/*!50001 DROP VIEW IF EXISTS `view_set_snap_1` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_snap_1` AS (select distinct `view_set_1_snap`.`bundle_transactions_20_repeat_id` AS `bundle_transactions_20_repeat_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_quantity` AS `bundle_transactions_20_repeat_quantity`,`view_set_1_snap`.`bundle_transactions_20_repeat_operation_id` AS `bundle_transactions_20_repeat_operation_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,`view_set_1_snap`.`tbl_shifts_master_shift_name` AS `tbl_shifts_master_shift_name`,`view_set_1_snap`.`tbl_orders_ops_ref_operation_code` AS `tbl_orders_ops_ref_operation_code`,`view_set_1_snap`.`tbl_orders_ops_ref_operation_name` AS `tbl_orders_ops_ref_operation_name`,`view_set_1_snap`.`bundle_transactions_module_id` AS `bundle_transactions_module_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_act_module` AS `bundle_transactions_20_repeat_act_module`,`view_set_1_snap`.`bundle_transactions_employee_id` AS `bundle_transactions_employee_id`,`view_set_1_snap`.`bundle_transactions_date_time` AS `bundle_transactions_date_time`,`view_set_2_snap`.`tbl_orders_size_ref_size_name` AS `tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title` AS `tbl_orders_sizes_master_size_title`,`view_set_2_snap`.`tbl_orders_sizes_master_order_quantity` AS `tbl_orders_sizes_master_order_quantity`,`view_set_2_snap`.`tbl_orders_style_ref_product_style` AS `tbl_orders_style_ref_product_style`,`view_set_3_snap`.`tbl_miniorder_data_quantity` AS `tbl_miniorder_data_quantity`,`view_set_3_snap`.`tbl_miniorder_data_bundle_number` AS `tbl_miniorder_data_bundle_number`,`view_set_3_snap`.`tbl_miniorder_data_color` AS `tbl_miniorder_data_color`,`view_set_3_snap`.`tbl_miniorder_data_mini_order_num` AS `tbl_miniorder_data_mini_order_num`,`view_set_2_snap`.`tbl_orders_master_product_schedule` AS `tbl_orders_master_product_schedule`,`view_set_2_snap`.`tbl_orders_size_ref_id` AS `tbl_orders_size_ref_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,if((length(`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) = 0),`view_set_2_snap`.`tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) AS `size_disp`,`view_set_3_snap`.`order_id` AS `order_id`,round(if((`view_set_1_snap`.`tbl_orders_ops_ref_operation_code` = 'LNO'),((`view_set_1_snap`.`bundle_transactions_20_repeat_quantity` * `view_set_2_snap`.`smv`) / 60),0),2) AS `sah`,`view_set_2_snap`.`order_div` AS `order_div`,`view_set_2_snap`.`order_date` AS `order_date`,concat(`view_set_2_snap`.`tbl_orders_style_ref_product_style`,`view_set_2_snap`.`tbl_orders_master_product_schedule`,`view_set_3_snap`.`tbl_miniorder_data_color`,if((length(`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) = 0),`view_set_2_snap`.`tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title`)) AS `order_tid_new`,`tbl_module_ref`.`module_section` AS `tbl_module_ref_module_section`,`view_set_1_snap`.`bundle_transactions_operation_time` AS `bundle_transactions_operation_time`,`view_set_2_snap`.`smv` AS `view_set_2_snap_smv`,`view_set_3_snap`.`tbl_miniorder_data_docket_number` AS `tbl_miniorder_data_docket_number` from (((`view_set_1_snap` left join `view_set_3_snap` on((`view_set_1_snap`.`bundle_transactions_20_repeat_bundle_barcode` = `view_set_3_snap`.`tbl_miniorder_data_bundle_number`))) left join `view_set_2_snap` on((`view_set_2_snap`.`order_id` = `view_set_3_snap`.`order_id`))) left join `tbl_module_ref` on((convert(`view_set_1_snap`.`bundle_transactions_module_id` using utf8) = `tbl_module_ref`.`id`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
