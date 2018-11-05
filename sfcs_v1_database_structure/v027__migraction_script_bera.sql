USE `bai_pro`;

/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_log_view` AS (select `bai_log`.`tid` AS `tid`,`bai_log`.`bac_no` AS `bac_no`,`bai_log`.`bac_sec` AS `bac_sec`,concat(if(`bai_log`.`size_xs` > 0,'xs',''),if(`bai_log`.`size_s` > 0,'s',''),if(`bai_log`.`size_m` > 0,'m',''),if(`bai_log`.`size_l` > 0,'l',''),if(`bai_log`.`size_xl` > 0,'xl',''),if(`bai_log`.`size_xxl` > 0,'xxl',''),if(`bai_log`.`size_xxxl` > 0,'xxxl',''),if(`bai_log`.`size_s06` > 0,'s06',''),if(`bai_log`.`size_s08` > 0,'s08',''),if(`bai_log`.`size_s10` > 0,'s10',''),if(`bai_log`.`size_s12` > 0,'s12',''),if(`bai_log`.`size_s14` > 0,'s14',''),if(`bai_log`.`size_s16` > 0,'s16',''),if(`bai_log`.`size_s18` > 0,'s18',''),if(`bai_log`.`size_s20` > 0,'s20',''),if(`bai_log`.`size_s22` > 0,'s22',''),if(`bai_log`.`size_s24` > 0,'s24',''),if(`bai_log`.`size_s26` > 0,'s26',''),if(`bai_log`.`size_s28` > 0,'s28',''),if(`bai_log`.`size_s30` > 0,'s30','')) AS `size`,`bai_log`.`bac_Qty` AS `bac_Qty`,`bai_log`.`bac_lastup` AS `bac_lastup`,`bai_log`.`bac_date` AS `bac_date`,`bai_log`.`bac_shift` AS `bac_shift`,`bai_log`.`bac_style` AS `bac_style`,`bai_log`.`bac_remarks` AS `bac_remarks`,`bai_log`.`bac_stat` AS `bac_stat`,`bai_log`.`log_time` AS `log_time`,`bai_log`.`division` AS `division`,`bai_log`.`buyer` AS `buyer`,`bai_log`.`delivery` AS `delivery`,`bai_log`.`color` AS `color`,`bai_log`.`loguser` AS `loguser`,`bai_log`.`ims_doc_no` AS `ims_doc_no`,`bai_log`.`couple` AS `couple`,`bai_log`.`nop` AS `nop`,`bai_log`.`smv` AS `smv`,`bai_log`.`ims_table_name` AS `ims_table_name`,`bai_log`.`ims_tid` AS `ims_tid`,`bai_log`.`size_xs` AS `size_xs`,`bai_log`.`size_s` AS `size_s`,`bai_log`.`size_m` AS `size_m`,`bai_log`.`size_l` AS `size_l`,`bai_log`.`size_xl` AS `size_xl`,`bai_log`.`size_xxl` AS `size_xxl`,`bai_log`.`size_xxxl` AS `size_xxxl`,`bai_log`.`size_s01` AS `size_s01`,`bai_log`.`size_s02` AS `size_s02`,`bai_log`.`size_s03` AS `size_s03`,`bai_log`.`size_s04` AS `size_s04`,`bai_log`.`size_s05` AS `size_s05`,`bai_log`.`size_s06` AS `size_s06`,`bai_log`.`size_s07` AS `size_s07`,`bai_log`.`size_s08` AS `size_s08`,`bai_log`.`size_s09` AS `size_s09`,`bai_log`.`size_s10` AS `size_s10`,`bai_log`.`size_s11` AS `size_s11`,`bai_log`.`size_s12` AS `size_s12`,`bai_log`.`size_s13` AS `size_s13`,`bai_log`.`size_s14` AS `size_s14`,`bai_log`.`size_s15` AS `size_s15`,`bai_log`.`size_s16` AS `size_s16`,`bai_log`.`size_s17` AS `size_s17`,`bai_log`.`size_s18` AS `size_s18`,`bai_log`.`size_s19` AS `size_s19`,`bai_log`.`size_s20` AS `size_s20`,`bai_log`.`size_s21` AS `size_s21`,`bai_log`.`size_s22` AS `size_s22`,`bai_log`.`size_s23` AS `size_s23`,`bai_log`.`size_s24` AS `size_s24`,`bai_log`.`size_s25` AS `size_s25`,`bai_log`.`size_s26` AS `size_s26`,`bai_log`.`size_s27` AS `size_s27`,`bai_log`.`size_s28` AS `size_s28`,`bai_log`.`size_s29` AS `size_s29`,`bai_log`.`size_s30` AS `size_s30`,`bai_log`.`size_s31` AS `size_s31`,`bai_log`.`size_s32` AS `size_s32`,`bai_log`.`size_s33` AS `size_s33`,`bai_log`.`size_s34` AS `size_s34`,`bai_log`.`size_s35` AS `size_s35`,`bai_log`.`size_s36` AS `size_s36`,`bai_log`.`size_s37` AS `size_s37`,`bai_log`.`size_s38` AS `size_s38`,`bai_log`.`size_s39` AS `size_s39`,`bai_log`.`size_s40` AS `size_s40`,`bai_log`.`size_s41` AS `size_s41`,`bai_log`.`size_s42` AS `size_s42`,`bai_log`.`size_s43` AS `size_s43`,`bai_log`.`size_s44` AS `size_s44`,`bai_log`.`size_s45` AS `size_s45`,`bai_log`.`size_s46` AS `size_s46`,`bai_log`.`size_s47` AS `size_s47`,`bai_log`.`size_s48` AS `size_s48`,`bai_log`.`size_s49` AS `size_s49`,`bai_log`.`size_s50` AS `size_s50` from `bai_log`)$$
DELIMITER ;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `bai_pro2`;

/* Alter table in target */
ALTER TABLE `hourly_downtime` 
	ADD COLUMN `reason_id` int(5)   NULL after `dhour` ;

/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `hourly_downtime_reason` AS (select `hourly_downtime`.`date` AS `date`,`hourly_downtime`.`dreason` AS `dreason`,`hourly_downtime`.`output_qty` AS `output_qty`,`downtime_reason`.`rdept` AS `rdept`,`hourly_downtime`.`team` AS `team` from (`hourly_downtime` join `downtime_reason` on(`hourly_downtime`.`dreason` = `downtime_reason`.`code`)))$$
DELIMITER ;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `bai_pro3`;

/* Create table in target */
CREATE TABLE `cps_log`(
	`id` int(11) NOT NULL  auto_increment , 
	`doc_no` int(11) NULL  , 
	`size_code` varchar(50) COLLATE latin1_swedish_ci NULL  , 
	`size_title` varchar(50) COLLATE latin1_swedish_ci NULL  , 
	`operation_code` int(11) NOT NULL  , 
	`short_key_code` varchar(50) COLLATE latin1_swedish_ci NOT NULL  , 
	`cut_quantity` int(11) NOT NULL  , 
	`remaining_qty` int(11) NOT NULL  , 
	PRIMARY KEY (`id`) , 
	KEY `doc_no_op_code`(`doc_no`,`operation_code`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `embellishment_plan_dashboard`(
	`module` varchar(8) COLLATE latin1_swedish_ci NULL  COMMENT 'Module No\r\n' , 
	`doc_no` int(11) NULL  COMMENT 'Docket No\r\n' , 
	`priority` int(11) NULL  COMMENT 'Priority\r\n' , 
	`fabric_status` int(11) NULL  COMMENT 'Fabric Issue Status\r\n' , 
	`log_time` datetime NOT NULL  COMMENT 'Updating time\r\n' , 
	`track_id` int(11) NOT NULL  auto_increment COMMENT 'Tracing Id\r\n' , 
	`cutting_table_location` int(11) NULL  , 
	`shift` varchar(5) COLLATE latin1_swedish_ci NULL  , 
	`cut_date` date NULL  , 
	`send_op_code` int(11) NULL  , 
	`receive_op_code` int(11) NULL  , 
	`orginal_qty` int(11) NOT NULL  DEFAULT 0 , 
	`send_qty` int(11) NOT NULL  DEFAULT 0 , 
	`receive_qty` int(11) NOT NULL  DEFAULT 0 , 
	PRIMARY KEY (`track_id`) , 
	UNIQUE KEY `track_id`(`track_id`) , 
	UNIQUE KEY `doc_no`(`doc_no`,`send_op_code`,`receive_op_code`) , 
	KEY `module`(`module`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `excess_cuts_log`(
	`id` int(11) NULL  , 
	`schedule_no` varchar(45) COLLATE latin1_swedish_ci NULL  , 
	`color` varchar(150) COLLATE latin1_swedish_ci NULL  , 
	`excess_cut_qty` char(3) COLLATE latin1_swedish_ci NULL  , 
	`date` datetime NULL  , 
	`user` varchar(60) COLLATE latin1_swedish_ci NULL  
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';

/* Create table in target */
CREATE TABLE `m3_transactions`(
	`id` bigint(20) NOT NULL  auto_increment , 
	`date_time` datetime NULL  , 
	`mo_no` varchar(50) COLLATE latin1_swedish_ci NULL  , 
	`quantity` int(11) NULL  , 
	`reason` varchar(100) COLLATE latin1_swedish_ci NULL  , 
	`remarks` text COLLATE latin1_swedish_ci NULL  , 
	`log_user` varchar(30) COLLATE latin1_swedish_ci NULL  , 
	`tran_status_code` int(11) NULL  , 
	`module_no` varchar(10) COLLATE latin1_swedish_ci NULL  , 
	`shift` varchar(10) COLLATE latin1_swedish_ci NULL  , 
	`op_code` int(11) NULL  , 
	`op_des` varchar(100) COLLATE latin1_swedish_ci NULL  , 
	`ref_no` varchar(100) COLLATE latin1_swedish_ci NULL  , 
	`workstation_id` varchar(10) COLLATE latin1_swedish_ci NULL  , 
	`response_status` varchar(20) COLLATE latin1_swedish_ci NULL  , 
	`m3_ops_code` int(11) NULL  , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `mo_details`(
	`id` int(11) NOT NULL  auto_increment , 
	`date_time` datetime NULL  , 
	`mo_no` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`mo_quantity` int(11) NULL  , 
	`style` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`schedule` int(11) NULL  , 
	`color` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`size` varchar(25) COLLATE latin1_swedish_ci NULL  , 
	`destination` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`zfeature` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`item_code` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`ops_master_status` int(11) NULL  DEFAULT 0 COMMENT 'Ops master capturing ;0-NO,1-YES' , 
	`product_sku` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	PRIMARY KEY (`id`) , 
	UNIQUE KEY `unique`(`mo_no`,`style`,`schedule`,`color`,`size`,`destination`,`zfeature`,`item_code`) , 
	UNIQUE KEY `MO`(`mo_no`,`item_code`,`zfeature`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `mo_operation_quantites`(
	`id` int(11) NOT NULL  auto_increment , 
	`date_time` datetime NULL  , 
	`mo_no` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`ref_no` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`bundle_quantity` int(11) NULL  , 
	`good_quantity` int(11) NULL  , 
	`rejected_quantity` int(11) NULL  , 
	`status` char(2) COLLATE latin1_swedish_ci NULL  , 
	`op_code` int(11) NULL  , 
	`op_desc` text COLLATE latin1_swedish_ci NULL  , 
	PRIMARY KEY (`id`) , 
	KEY `ref_no_op_coe`(`ref_no`,`op_code`) , 
	KEY `mo_no`(`mo_no`,`op_code`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `module_master`(
	`id` int(11) NOT NULL  auto_increment , 
	`date_time` timestamp NOT NULL  DEFAULT current_timestamp() on update current_timestamp() , 
	`module_name` varchar(50) COLLATE latin1_swedish_ci NULL  , 
	`module_description` text COLLATE latin1_swedish_ci NULL  , 
	`status` varchar(10) COLLATE latin1_swedish_ci NULL  , 
	`mapped_cut_table` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	`section` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `order_plan_schedule_level`(
	`schedule_no` bigint(11) NOT NULL  , 
	`mo_status` varchar(2) COLLATE latin1_swedish_ci NOT NULL  , 
	`style_no` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`color` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`size_code` varchar(10) COLLATE latin1_swedish_ci NOT NULL  , 
	`order_qty` int(11) NOT NULL  , 
	`compo_no` varchar(400) COLLATE latin1_swedish_ci NOT NULL  , 
	`item_des` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`order_yy` double NOT NULL  , 
	`col_des` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`material_sequence` varchar(100) COLLATE latin1_swedish_ci NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci' COMMENT='Temp table to update Category details from M3';

/* Alter table in target */
ALTER TABLE `pac_stat_log_input_job` 
	ADD COLUMN `sref_id` int(11)   NULL after `type_of_sewing` , 
	ADD COLUMN `pac_seq_no` int(11)   NULL after `sref_id` , 
	ADD COLUMN `barcode_sequence` int(11)   NULL after `pac_seq_no` , 
	ADD KEY `input_job_rand_no`(`input_job_no_random`) , ENGINE=InnoDB; 

	/* Alter table in target */
ALTER TABLE `plan_dashboard_deleted` 
	CHANGE `doc_no` `doc_no` varchar(50)  COLLATE latin1_swedish_ci NULL COMMENT 'Docket No\r\n' after `module` , 
	ADD COLUMN `cutting_table_location` int(11)   NULL after `track_id` , 
	ADD COLUMN `shift` varchar(5)  COLLATE latin1_swedish_ci NULL after `cutting_table_location` , 
	ADD COLUMN `cut_date` date   NULL after `shift` , 
	DROP KEY `PRIMARY` ;
	
/* Create table in target */
CREATE TABLE `sections_master`(
	`sec_id` int(11) NOT NULL  auto_increment , 
	`date_time` datetime NULL  , 
	`sec_name` varchar(100) COLLATE latin1_swedish_ci NULL  , 
	`ims_priority_boxs` varchar(100) COLLATE latin1_swedish_ci NULL  , 
	KEY `sec_id`(`sec_id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `sewing_jobs_ref`(
	`id` int(10) NOT NULL  auto_increment , 
	`style` varchar(20) COLLATE latin1_swedish_ci NULL  , 
	`schedule` varchar(20) COLLATE latin1_swedish_ci NULL  , 
	`bundles_count` int(5) NULL  , 
	`log_time` datetime NULL  , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';

/* Create table in target */
CREATE TABLE `shipment_plan_schedule_level`(
	`tid` int(11) NOT NULL  auto_increment , 
	`style_no` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`schedule_no` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`color` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`order_qty` int(11) NOT NULL  , 
	`exfact_date` date NOT NULL  , 
	`CPO` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`buyer_div` varchar(200) COLLATE latin1_swedish_ci NOT NULL  , 
	`style_id` varchar(200) COLLATE latin1_swedish_ci NULL  , 
	`size_code` varchar(500) COLLATE latin1_swedish_ci NOT NULL  , 
	`packing_method` varchar(12) COLLATE latin1_swedish_ci NULL  , 
	`order_embl_a` int(11) NULL  , 
	`order_embl_b` int(11) NULL  , 
	`order_embl_c` int(11) NULL  , 
	`order_embl_d` int(11) NULL  , 
	`order_embl_e` int(11) NULL  , 
	`order_embl_f` int(11) NULL  , 
	`order_embl_g` int(11) NULL  , 
	`order_embl_h` int(11) NULL  , 
	`destination` varchar(10) COLLATE latin1_swedish_ci NULL  , 
	`zfeature` varchar(8) COLLATE latin1_swedish_ci NULL  COMMENT 'Country Block' , 
	`order_no` varchar(200) COLLATE latin1_swedish_ci NULL  COMMENT 'CO Number' , 
	PRIMARY KEY (`tid`) , 
	KEY `style_no`(`style_no`) , 
	KEY `schedule_no`(`schedule_no`) , 
	KEY `color`(`color`) , 
	KEY `style_no_2`(`style_no`) , 
	KEY `schedule_no_2`(`schedule_no`) , 
	KEY `color_2`(`color`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `tbl_emb_table`(
	`emb_table_id` int(11) NOT NULL  auto_increment , 
	`emb_table_name` varchar(255) COLLATE latin1_swedish_ci NOT NULL  , 
	`cut_table_name` varchar(255) COLLATE latin1_swedish_ci NOT NULL  , 
	`emb_table_status` enum('active','inactive') COLLATE latin1_swedish_ci NOT NULL  , 
	`work_station_id` varchar(255) COLLATE latin1_swedish_ci NOT NULL  , 
	PRIMARY KEY (`emb_table_id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';

/* Alter table in target */
ALTER TABLE `tbl_fg_crt_handover_team_list` 
	CHANGE `lastup` `lastup` timestamp   NULL on update current_timestamp() after `emp_status` ;

/* Create table in target */
CREATE TABLE `work_stations_mapping`(
	`id` int(11) NOT NULL  auto_increment , 
	`date_time` datetime NOT NULL  , 
	`operation_code` varchar(100) COLLATE latin1_swedish_ci NULL  , 
	`module` varchar(50) COLLATE latin1_swedish_ci NULL  , 
	`work_station_id` varchar(255) COLLATE latin1_swedish_ci NULL  , 
	KEY `id`(`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,sum(if(`fca_audit_fail_db`.`tran_type` = 1,`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`fca_audit_fail_db`.`tran_type` = 2,`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`color` AS `color`,sum(if(`fca_audit_fail_db`.`tran_type` = 1,`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`fca_audit_fail_db`.`tran_type` = 2,`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`color`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_size` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`size` AS `size`,sum(if(`fca_audit_fail_db`.`tran_type` = 1,`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`fca_audit_fail_db`.`tran_type` = 2,`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `audit_disp_tb2_size_2` AS (select `fca_audit_fail_db`.`style` AS `style`,`fca_audit_fail_db`.`schedule` AS `SCHEDULE`,`fca_audit_fail_db`.`color` AS `color`,`fca_audit_fail_db`.`size` AS `size`,sum(if(`fca_audit_fail_db`.`tran_type` = 1,`fca_audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`fca_audit_fail_db`.`tran_type` = 2,`fca_audit_fail_db`.`pcs`,0)) AS `fail` from `fca_audit_fail_db` group by `fca_audit_fail_db`.`schedule`,`fca_audit_fail_db`.`color`,`fca_audit_fail_db`.`size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_cts_ref` AS (select `bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,sum(if(`bai_qms_db`.`qms_tran_type` = 1,`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if(`bai_qms_db`.`qms_tran_type` = 2,`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if(`bai_qms_db`.`qms_tran_type` = 3,`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if(`bai_qms_db`.`qms_tran_type` = 4,`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if(`bai_qms_db`.`qms_tran_type` = 5,`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if(`bai_qms_db`.`qms_tran_type` = 6,`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if(`bai_qms_db`.`qms_tran_type` = 7,`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if(`bai_qms_db`.`qms_tran_type` = 8,`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if(`bai_qms_db`.`qms_tran_type` = 9,`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,sum(if(`bai_qms_db`.`qms_tran_type` = 10,`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if(`bai_qms_db`.`qms_tran_type` = 11,`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if(`bai_qms_db`.`qms_tran_type` = 12,`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if(`bai_qms_db`.`qms_tran_type` = 13,`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by `bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_day_report` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,`bai_qms_db`.`log_user` AS `log_user`,`bai_qms_db`.`log_date` AS `log_date`,`bai_qms_db`.`log_time` AS `log_time`,`bai_qms_db`.`issued_by` AS `issued_by`,`bai_qms_db`.`qms_size` AS `qms_size`,sum(if(`bai_qms_db`.`qms_tran_type` = 1,`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if(`bai_qms_db`.`qms_tran_type` = 2,`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if(`bai_qms_db`.`qms_tran_type` = 3,`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if(`bai_qms_db`.`qms_tran_type` = 4,`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if(`bai_qms_db`.`qms_tran_type` = 5,`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if(`bai_qms_db`.`qms_tran_type` = 6,`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if(`bai_qms_db`.`qms_tran_type` = 7,`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if(`bai_qms_db`.`qms_tran_type` = 8,`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if(`bai_qms_db`.`qms_tran_type` = 9,`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,`bai_qms_db`.`remarks` AS `remarks`,`bai_qms_db`.`ref1` AS `ref1`,sum(if(`bai_qms_db`.`qms_tran_type` = 10,`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if(`bai_qms_db`.`qms_tran_type` = 11,`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if(`bai_qms_db`.`qms_tran_type` = 12,`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if(`bai_qms_db`.`qms_tran_type` = 13,`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by concat(`bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`qms_size`))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_qms_pop_report` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,`bai_qms_db`.`log_user` AS `log_user`,`bai_qms_db`.`log_date` AS `log_date`,`bai_qms_db`.`log_time` AS `log_time`,`bai_qms_db`.`issued_by` AS `issued_by`,`bai_qms_db`.`qms_size` AS `qms_size`,sum(if(`bai_qms_db`.`qms_tran_type` = 1,`bai_qms_db`.`qms_qty`,0)) AS `good_panels`,sum(if(`bai_qms_db`.`qms_tran_type` = 2,`bai_qms_db`.`qms_qty`,0)) AS `replaced`,sum(if(`bai_qms_db`.`qms_tran_type` = 3,`bai_qms_db`.`qms_qty`,0)) AS `rejected`,sum(if(`bai_qms_db`.`qms_tran_type` = 4,`bai_qms_db`.`qms_qty`,0)) AS `sample_room`,sum(if(`bai_qms_db`.`qms_tran_type` = 5,`bai_qms_db`.`qms_qty`,0)) AS `good_garments`,sum(if(`bai_qms_db`.`qms_tran_type` = 6,`bai_qms_db`.`qms_qty`,0)) AS `recut_raised`,sum(if(`bai_qms_db`.`qms_tran_type` = 7,`bai_qms_db`.`qms_qty`,0)) AS `disposed`,sum(if(`bai_qms_db`.`qms_tran_type` = 8,`bai_qms_db`.`qms_qty`,0)) AS `sent_to_customer`,sum(if(`bai_qms_db`.`qms_tran_type` = 9,`bai_qms_db`.`qms_qty`,0)) AS `actual_recut`,`bai_qms_db`.`remarks` AS `remarks`,`bai_qms_db`.`ref1` AS `ref1`,substring_index(`bai_qms_db`.`remarks`,'-',1) AS `module`,substring_index(`bai_qms_db`.`remarks`,'-',-1) AS `team`,sum(if(`bai_qms_db`.`qms_tran_type` = 10,`bai_qms_db`.`qms_qty`,0)) AS `tran_sent`,sum(if(`bai_qms_db`.`qms_tran_type` = 11,`bai_qms_db`.`qms_qty`,0)) AS `tran_rec`,sum(if(`bai_qms_db`.`qms_tran_type` = 12,`bai_qms_db`.`qms_qty`,0)) AS `resrv_dest`,sum(if(`bai_qms_db`.`qms_tran_type` = 13,`bai_qms_db`.`qms_qty`,0)) AS `panel_destroyed` from `bai_qms_db` group by concat(`bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`qms_size`,`bai_qms_db`.`log_date`,substring_index(`bai_qms_db`.`remarks`,'-',1)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_ship_cts_ref` AS (select sum(`ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08` + `ship_stat_log`.`ship_s_s10` + `ship_stat_log`.`ship_s_s12` + `ship_stat_log`.`ship_s_s14` + `ship_stat_log`.`ship_s_s16` + `ship_stat_log`.`ship_s_s18` + `ship_stat_log`.`ship_s_s20` + `ship_stat_log`.`ship_s_s22` + `ship_stat_log`.`ship_s_s24` + `ship_stat_log`.`ship_s_s26` + `ship_stat_log`.`ship_s_s28` + `ship_stat_log`.`ship_s_s30` + `ship_stat_log`.`ship_s_xs` + `ship_stat_log`.`ship_s_s` + `ship_stat_log`.`ship_s_m` + `ship_stat_log`.`ship_s_l` + `ship_stat_log`.`ship_s_xl` + `ship_stat_log`.`ship_s_xxl` + `ship_stat_log`.`ship_s_xxxl`) AS `shipped`,`ship_stat_log`.`ship_style` AS `ship_style`,`ship_stat_log`.`ship_schedule` AS `ship_schedule`,group_concat(`ship_stat_log`.`disp_note_no` separator ',') AS `disp_note_ref` from `ship_stat_log` where `ship_stat_log`.`ship_status` = 2 group by `ship_stat_log`.`ship_schedule`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `cut_dept_report` AS (select `a`.`date` AS `date`,`o`.`category` AS `category`,`o`.`catyy` AS `catyy`,`a`.`doc_no` AS `doc_no`,`a`.`section` AS `section`,`a`.`remarks` AS `remarks`,`a`.`fab_received` - (`a`.`damages` + `a`.`shortages`) AS `net_uti`,cast(`a`.`log_date` as time) AS `log_time`,`a`.`fab_received` AS `fab_received`,`a`.`damages` AS `damages`,`a`.`shortages` AS `shortages`,(`o`.`a_xs` + `o`.`a_s` + `o`.`a_m` + `o`.`a_l` + `o`.`a_xl` + `o`.`a_xxl` + `o`.`a_xxxl` + `o`.`a_s01` + `o`.`a_s02` + `o`.`a_s03` + `o`.`a_s04` + `o`.`a_s05` + `o`.`a_s06` + `o`.`a_s07` + `o`.`a_s08` + `o`.`a_s09` + `o`.`a_s10` + `o`.`a_s11` + `o`.`a_s12` + `o`.`a_s13` + `o`.`a_s14` + `o`.`a_s15` + `o`.`a_s16` + `o`.`a_s17` + `o`.`a_s18` + `o`.`a_s19` + `o`.`a_s20` + `o`.`a_s21` + `o`.`a_s22` + `o`.`a_s23` + `o`.`a_s24` + `o`.`a_s25` + `o`.`a_s26` + `o`.`a_s27` + `o`.`a_s28` + `o`.`a_s29` + `o`.`a_s30` + `o`.`a_s31` + `o`.`a_s32` + `o`.`a_s33` + `o`.`a_s34` + `o`.`a_s35` + `o`.`a_s36` + `o`.`a_s37` + `o`.`a_s38` + `o`.`a_s39` + `o`.`a_s40` + `o`.`a_s41` + `o`.`a_s42` + `o`.`a_s43` + `o`.`a_s44` + `o`.`a_s45` + `o`.`a_s46` + `o`.`a_s47` + `o`.`a_s48` + `o`.`a_s49` + `o`.`a_s50`) * `o`.`a_plies` AS `tot_cut_qty` from (`act_cut_status` `a` join `order_cat_doc_mk_mix` `o`) where `a`.`doc_no` = `o`.`doc_no` order by `a`.`section`,cast(`a`.`log_date` as time))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix` AS (select `disp_tb1`.`order_del_no` AS `order_del_no`,`disp_tb1`.`order_style_no` AS `order_style_no`,`disp_tb1`.`order_col_des` AS `order_col_des`,`disp_tb1`.`total` AS `total`,`disp_tb1`.`scanned` AS `scanned`,`disp_tb1`.`unscanned` AS `unscanned`,coalesce(`disp_tb2`.`app`,0) AS `app`,coalesce(`disp_tb2`.`fail`,0) AS `fail`,coalesce(`disp_tb1`.`scanned`,0) - coalesce(`disp_tb2`.`app`,0) AS `audit_pending`,coalesce(`audit_disp_tb2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2`.`fail`,0) AS `fca_fail`,coalesce(`disp_tb1`.`scanned`,0) - coalesce(`audit_disp_tb2`.`app`,0) AS `fca_audit_pending` from ((`disp_tb1` left join `disp_tb2` on(`disp_tb1`.`order_del_no` = `disp_tb2`.`SCHEDULE`)) left join `audit_disp_tb2` on(`disp_tb1`.`order_del_no` = `audit_disp_tb2`.`SCHEDULE`)) where `disp_tb1`.`order_del_no` is not null)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_2` AS (select `disp_tb1_2`.`order_del_no` AS `order_del_no`,`disp_tb1_2`.`order_style_no` AS `order_style_no`,`disp_tb1_2`.`order_col_des` AS `order_col_des`,`disp_tb1_2`.`total` AS `total`,`disp_tb1_2`.`scanned` AS `scanned`,`disp_tb1_2`.`unscanned` AS `unscanned`,coalesce(`disp_tb2_2`.`app`,0) AS `app`,coalesce(`disp_tb2_2`.`fail`,0) AS `fail`,coalesce(`disp_tb1_2`.`scanned`,0) - coalesce(`disp_tb2_2`.`app`,0) AS `audit_pending`,coalesce(`audit_disp_tb2_2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_2`.`fail`,0) AS `fca_fail`,coalesce(`disp_tb1_2`.`scanned`,0) - coalesce(`audit_disp_tb2_2`.`app`,0) AS `fca_audit_pending` from ((`disp_tb1_2` left join `disp_tb2_2` on(concat(`disp_tb1_2`.`order_del_no`,`disp_tb1_2`.`order_col_des`) = concat(`disp_tb2_2`.`SCHEDULE`,`disp_tb2_2`.`color`))) left join `audit_disp_tb2_2` on(concat(`disp_tb1_2`.`order_del_no`,`disp_tb1_2`.`order_col_des`) = concat(`audit_disp_tb2_2`.`SCHEDULE`,`audit_disp_tb2_2`.`color`))) where `disp_tb1_2`.`order_del_no` is not null)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_size` AS (select `disp_tb1_size`.`order_del_no` AS `order_del_no`,`disp_tb1_size`.`order_style_no` AS `order_style_no`,`disp_tb1_size`.`order_col_des` AS `order_col_des`,`disp_tb1_size`.`total` AS `total`,`disp_tb1_size`.`scanned` AS `scanned`,`disp_tb1_size`.`unscanned` AS `unscanned`,`disp_tb1_size`.`size_code` AS `size_code`,coalesce(`disp_tb2_size`.`app`,0) AS `app`,coalesce(`disp_tb2_size`.`fail`,0) AS `fail`,coalesce(`disp_tb1_size`.`scanned`,0) - coalesce(`disp_tb2_size`.`app`,0) AS `audit_pending`,coalesce(`audit_disp_tb2_size`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_size`.`fail`,0) AS `fca_fail`,coalesce(`disp_tb1_size`.`scanned`,0) - coalesce(`audit_disp_tb2_size`.`app`,0) AS `fca_audit_pending` from ((`disp_tb1_size` left join `disp_tb2_size` on(`disp_tb1_size`.`order_del_no` = `disp_tb2_size`.`SCHEDULE` and `disp_tb1_size`.`size_code` = `disp_tb2_size`.`size`)) left join `audit_disp_tb2_size` on(`disp_tb1_size`.`order_del_no` = `audit_disp_tb2_size`.`SCHEDULE` and `disp_tb1_size`.`size_code` = `audit_disp_tb2_size`.`size`)) where `disp_tb1_size`.`order_del_no` is not null)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_mix_size_2` AS (select `disp_tb1_size_2`.`order_del_no` AS `order_del_no`,`disp_tb1_size_2`.`order_style_no` AS `order_style_no`,`disp_tb1_size_2`.`order_col_des` AS `order_col_des`,`disp_tb1_size_2`.`total` AS `total`,`disp_tb1_size_2`.`scanned` AS `scanned`,`disp_tb1_size_2`.`unscanned` AS `unscanned`,`disp_tb1_size_2`.`size_code` AS `size_code`,coalesce(`disp_tb2_size_2`.`app`,0) AS `app`,coalesce(`disp_tb2_size_2`.`fail`,0) AS `fail`,coalesce(`disp_tb1_size_2`.`scanned`,0) - coalesce(`disp_tb2_size_2`.`app`,0) AS `audit_pending`,coalesce(`audit_disp_tb2_size_2`.`app`,0) AS `fca_app`,coalesce(`audit_disp_tb2_size_2`.`fail`,0) AS `fca_fail`,coalesce(`disp_tb1_size_2`.`scanned`,0) - coalesce(`audit_disp_tb2_size_2`.`app`,0) AS `fca_audit_pending` from ((`disp_tb1_size_2` left join `disp_tb2_size_2` on(`disp_tb1_size_2`.`order_del_no` = `disp_tb2_size_2`.`SCHEDULE` and `disp_tb1_size_2`.`size_code` = `disp_tb2_size_2`.`size` and `disp_tb1_size_2`.`order_col_des` = `disp_tb2_size_2`.`color`)) left join `audit_disp_tb2_size_2` on(`disp_tb1_size_2`.`order_del_no` = `audit_disp_tb2_size_2`.`SCHEDULE` and `disp_tb1_size_2`.`size_code` = `audit_disp_tb2_size_2`.`size` and `disp_tb1_size_2`.`order_col_des` = `audit_disp_tb2_size_2`.`color`)) where `disp_tb1_size_2`.`order_del_no` is not null)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,group_concat(distinct `packing_summary`.`tid` separator ',') AS `lable_ids`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null,`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where `packing_summary`.`order_del_no` is not null group by `packing_summary`.`order_del_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_2` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,group_concat(distinct `packing_summary`.`tid` separator ',') AS `lable_ids`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null,`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where `packing_summary`.`order_del_no` is not null group by `packing_summary`.`order_del_no`,`packing_summary`.`order_col_des`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_size` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,`packing_summary`.`size_code` AS `size_code`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null,`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where `packing_summary`.`order_del_no` is not null group by `packing_summary`.`order_del_no`,`packing_summary`.`size_code`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb1_size_2` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,`packing_summary`.`order_style_no` AS `order_style_no`,`packing_summary`.`size_code` AS `size_code`,group_concat(distinct trim(`packing_summary`.`order_col_des`) separator ',') AS `order_col_des`,sum(`packing_summary`.`carton_act_qty`) AS `total`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null,`packing_summary`.`carton_act_qty`,0)) AS `unscanned` from `packing_summary` where `packing_summary`.`order_del_no` is not null group by `packing_summary`.`order_del_no`,`packing_summary`.`order_col_des`,`packing_summary`.`size_code`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,sum(if(`audit_fail_db`.`tran_type` = 1,`audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`audit_fail_db`.`tran_type` = 2,`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`color` AS `color`,sum(if(`audit_fail_db`.`tran_type` = 1,`audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`audit_fail_db`.`tran_type` = 2,`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`color`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_size` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`size` AS `size`,sum(if(`audit_fail_db`.`tran_type` = 1,`audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`audit_fail_db`.`tran_type` = 2,`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `disp_tb2_size_2` AS (select `audit_fail_db`.`style` AS `style`,`audit_fail_db`.`schedule` AS `SCHEDULE`,`audit_fail_db`.`size` AS `size`,`audit_fail_db`.`color` AS `color`,sum(if(`audit_fail_db`.`tran_type` = 1,`audit_fail_db`.`pcs`,0)) AS `app`,sum(if(`audit_fail_db`.`tran_type` = 2,`audit_fail_db`.`pcs`,0)) AS `fail` from `audit_fail_db` group by `audit_fail_db`.`schedule`,`audit_fail_db`.`size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `emb_garment_carton_pendings` AS (select min(`pac_stat_log_temp`.`tid`) AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,`pac_stat_log_temp`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where `pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no` and `pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','') and `pac_stat_log_temp`.`disp_carton_no` >= 1 and `ims_log_backup`.`ims_mod_no` <> 0 and left(`pac_stat_log_temp`.`status`,1) = 'E' group by `pac_stat_log_temp`.`doc_no_ref`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fg_wh_report` AS (select `packing_summary`.`order_del_no` AS `order_del_no`,sum(`packing_summary`.`carton_act_qty`) AS `total_qty`,sum(if(`packing_summary`.`status` = 'DONE',`packing_summary`.`carton_act_qty`,0)) AS `scanned`,sum(if(`packing_summary`.`status` is null or octet_length(`packing_summary`.`status`) = 0,`packing_summary`.`carton_act_qty`,0)) AS `unscanned`,sum(if(left(`packing_summary`.`status`,1) = 'E',`packing_summary`.`carton_act_qty`,0)) AS `embellish`,0 AS `shipped` from `packing_summary` group by `packing_summary`.`order_del_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fg_wh_report_summary` AS (select `fg_wh_report`.`order_del_no` AS `order_del_no`,`fg_wh_report`.`total_qty` AS `total_qty`,`fg_wh_report`.`scanned` AS `scanned`,`fg_wh_report`.`unscanned` AS `unscanned`,`fg_wh_report`.`embellish` AS `embellish`,`fg_wh_report`.`shipped` AS `shipped`,`bai_orders_db_confirm`.`order_date` AS `order_date`,`bai_orders_db_confirm`.`order_po_no` AS `order_po_no`,group_concat(trim(`bai_orders_db_confirm`.`order_col_des`) separator ', ') AS `color`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no` from (`fg_wh_report` left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_del_no` = `fg_wh_report`.`order_del_no`)) where `fg_wh_report`.`order_del_no` is not null and `fg_wh_report`.`scanned` > 0 and `fg_wh_report`.`total_qty` - `fg_wh_report`.`shipped` <> 0 group by `fg_wh_report`.`order_del_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fsp_order_ref` AS (select `bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`ft_status` AS `ft_status`,`bai_orders_db`.`st_status` AS `st_status`,`bai_orders_db`.`pt_status` AS `pt_status`,group_concat(distinct `bai_orders_db`.`order_col_des` separator ',') AS `color`,sum(`bai_orders_db`.`order_s_xs` + `bai_orders_db`.`order_s_s` + `bai_orders_db`.`order_s_m` + `bai_orders_db`.`order_s_l` + `bai_orders_db`.`order_s_xl` + `bai_orders_db`.`order_s_xxl` + `bai_orders_db`.`order_s_xxxl` + `bai_orders_db`.`order_s_s06` + `bai_orders_db`.`order_s_s08` + `bai_orders_db`.`order_s_s10` + `bai_orders_db`.`order_s_s12` + `bai_orders_db`.`order_s_s14` + `bai_orders_db`.`order_s_s16` + `bai_orders_db`.`order_s_s18` + `bai_orders_db`.`order_s_s20` + `bai_orders_db`.`order_s_s22` + `bai_orders_db`.`order_s_s24` + `bai_orders_db`.`order_s_s26` + `bai_orders_db`.`order_s_s28` + `bai_orders_db`.`order_s_s30`) AS `order_qty`,`bai_orders_db`.`trim_cards` AS `trim_cards`,`bai_orders_db`.`order_div` AS `order_div`,`bai_orders_db`.`trim_status` AS `trim_status`,`bai_orders_db`.`fsp_time_line` AS `fsp_time_line` from `bai_orders_db` group by `bai_orders_db`.`order_del_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ft_st_pk_shipfast_status` AS (select `fastreact_plan_summary`.`group_code` AS `group_code`,`fastreact_plan_summary`.`module` AS `module`,`fastreact_plan_summary`.`style` AS `style`,`fastreact_plan_summary`.`order_code` AS `order_code`,`fastreact_plan_summary`.`color` AS `color`,`fastreact_plan_summary`.`smv` AS `smv`,`fastreact_plan_summary`.`delivery_date` AS `delivery_date`,`fastreact_plan_summary`.`schedule` AS `schedule`,`fastreact_plan_summary`.`production_date` AS `production_date`,`fastreact_plan_summary`.`qty` AS `qty`,`fastreact_plan_summary`.`tid` AS `tid`,`fastreact_plan_summary`.`week_code` AS `week_code`,`fastreact_plan_summary`.`status` AS `status`,`fastreact_plan_summary`.`production_start` AS `production_start`,`bai_pro3`.`bai_orders_db`.`order_tid` AS `order_tid`,`bai_pro3`.`bai_orders_db`.`order_date` AS `order_date`,`bai_pro3`.`bai_orders_db`.`order_upload_date` AS `order_upload_date`,`bai_pro3`.`bai_orders_db`.`order_last_mod_date` AS `order_last_mod_date`,`bai_pro3`.`bai_orders_db`.`order_last_upload_date` AS `order_last_upload_date`,`bai_pro3`.`bai_orders_db`.`order_div` AS `order_div`,`bai_pro3`.`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_pro3`.`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_pro3`.`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_pro3`.`bai_orders_db`.`order_col_code` AS `order_col_code`,`bai_pro3`.`bai_orders_db`.`order_s_xs` AS `order_s_xs`,`bai_pro3`.`bai_orders_db`.`order_s_s` AS `order_s_s`,`bai_pro3`.`bai_orders_db`.`order_s_m` AS `order_s_m`,`bai_pro3`.`bai_orders_db`.`order_s_l` AS `order_s_l`,`bai_pro3`.`bai_orders_db`.`order_s_xl` AS `order_s_xl`,`bai_pro3`.`bai_orders_db`.`order_s_xxl` AS `order_s_xxl`,`bai_pro3`.`bai_orders_db`.`order_s_xxxl` AS `order_s_xxxl`,`bai_pro3`.`bai_orders_db`.`order_cat_stat` AS `order_cat_stat`,`bai_pro3`.`bai_orders_db`.`order_cut_stat` AS `order_cut_stat`,`bai_pro3`.`bai_orders_db`.`order_ratio_stat` AS `order_ratio_stat`,`bai_pro3`.`bai_orders_db`.`order_cad_stat` AS `order_cad_stat`,`bai_pro3`.`bai_orders_db`.`order_stat` AS `order_stat`,`bai_pro3`.`bai_orders_db`.`Order_remarks` AS `Order_remarks`,`bai_pro3`.`bai_orders_db`.`order_po_no` AS `order_po_no`,`bai_pro3`.`bai_orders_db`.`order_no` AS `order_no`,`bai_pro3`.`bai_orders_db`.`old_order_s_xs` AS `old_order_s_xs`,`bai_pro3`.`bai_orders_db`.`old_order_s_s` AS `old_order_s_s`,`bai_pro3`.`bai_orders_db`.`old_order_s_m` AS `old_order_s_m`,`bai_pro3`.`bai_orders_db`.`old_order_s_l` AS `old_order_s_l`,`bai_pro3`.`bai_orders_db`.`old_order_s_xl` AS `old_order_s_xl`,`bai_pro3`.`bai_orders_db`.`old_order_s_xxl` AS `old_order_s_xxl`,`bai_pro3`.`bai_orders_db`.`old_order_s_xxxl` AS `old_order_s_xxxl`,`bai_pro3`.`bai_orders_db`.`color_code` AS `color_code`,`bai_pro3`.`bai_orders_db`.`order_joins` AS `order_joins`,`bai_pro3`.`bai_orders_db`.`order_s_s01` AS `order_s_s01`,`bai_pro3`.`bai_orders_db`.`order_s_s02` AS `order_s_s02`,`bai_pro3`.`bai_orders_db`.`order_s_s03` AS `order_s_s03`,`bai_pro3`.`bai_orders_db`.`order_s_s04` AS `order_s_s04`,`bai_pro3`.`bai_orders_db`.`order_s_s05` AS `order_s_s05`,`bai_pro3`.`bai_orders_db`.`order_s_s06` AS `order_s_s06`,`bai_pro3`.`bai_orders_db`.`order_s_s07` AS `order_s_s07`,`bai_pro3`.`bai_orders_db`.`order_s_s08` AS `order_s_s08`,`bai_pro3`.`bai_orders_db`.`order_s_s09` AS `order_s_s09`,`bai_pro3`.`bai_orders_db`.`order_s_s10` AS `order_s_s10`,`bai_pro3`.`bai_orders_db`.`order_s_s11` AS `order_s_s11`,`bai_pro3`.`bai_orders_db`.`order_s_s12` AS `order_s_s12`,`bai_pro3`.`bai_orders_db`.`order_s_s13` AS `order_s_s13`,`bai_pro3`.`bai_orders_db`.`order_s_s14` AS `order_s_s14`,`bai_pro3`.`bai_orders_db`.`order_s_s15` AS `order_s_s15`,`bai_pro3`.`bai_orders_db`.`order_s_s16` AS `order_s_s16`,`bai_pro3`.`bai_orders_db`.`order_s_s17` AS `order_s_s17`,`bai_pro3`.`bai_orders_db`.`order_s_s18` AS `order_s_s18`,`bai_pro3`.`bai_orders_db`.`order_s_s19` AS `order_s_s19`,`bai_pro3`.`bai_orders_db`.`order_s_s20` AS `order_s_s20`,`bai_pro3`.`bai_orders_db`.`order_s_s21` AS `order_s_s21`,`bai_pro3`.`bai_orders_db`.`order_s_s22` AS `order_s_s22`,`bai_pro3`.`bai_orders_db`.`order_s_s23` AS `order_s_s23`,`bai_pro3`.`bai_orders_db`.`order_s_s24` AS `order_s_s24`,`bai_pro3`.`bai_orders_db`.`order_s_s25` AS `order_s_s25`,`bai_pro3`.`bai_orders_db`.`order_s_s26` AS `order_s_s26`,`bai_pro3`.`bai_orders_db`.`order_s_s27` AS `order_s_s27`,`bai_pro3`.`bai_orders_db`.`order_s_s28` AS `order_s_s28`,`bai_pro3`.`bai_orders_db`.`order_s_s29` AS `order_s_s29`,`bai_pro3`.`bai_orders_db`.`order_s_s30` AS `order_s_s30`,`bai_pro3`.`bai_orders_db`.`order_s_s31` AS `order_s_s31`,`bai_pro3`.`bai_orders_db`.`order_s_s32` AS `order_s_s32`,`bai_pro3`.`bai_orders_db`.`order_s_s33` AS `order_s_s33`,`bai_pro3`.`bai_orders_db`.`order_s_s34` AS `order_s_s34`,`bai_pro3`.`bai_orders_db`.`order_s_s35` AS `order_s_s35`,`bai_pro3`.`bai_orders_db`.`order_s_s36` AS `order_s_s36`,`bai_pro3`.`bai_orders_db`.`order_s_s37` AS `order_s_s37`,`bai_pro3`.`bai_orders_db`.`order_s_s38` AS `order_s_s38`,`bai_pro3`.`bai_orders_db`.`order_s_s39` AS `order_s_s39`,`bai_pro3`.`bai_orders_db`.`order_s_s40` AS `order_s_s40`,`bai_pro3`.`bai_orders_db`.`order_s_s41` AS `order_s_s41`,`bai_pro3`.`bai_orders_db`.`order_s_s42` AS `order_s_s42`,`bai_pro3`.`bai_orders_db`.`order_s_s43` AS `order_s_s43`,`bai_pro3`.`bai_orders_db`.`order_s_s44` AS `order_s_s44`,`bai_pro3`.`bai_orders_db`.`order_s_s45` AS `order_s_s45`,`bai_pro3`.`bai_orders_db`.`order_s_s46` AS `order_s_s46`,`bai_pro3`.`bai_orders_db`.`order_s_s47` AS `order_s_s47`,`bai_pro3`.`bai_orders_db`.`order_s_s48` AS `order_s_s48`,`bai_pro3`.`bai_orders_db`.`order_s_s49` AS `order_s_s49`,`bai_pro3`.`bai_orders_db`.`order_s_s50` AS `order_s_s50`,`bai_pro3`.`bai_orders_db`.`old_order_s_s01` AS `old_order_s_s01`,`bai_pro3`.`bai_orders_db`.`old_order_s_s02` AS `old_order_s_s02`,`bai_pro3`.`bai_orders_db`.`old_order_s_s03` AS `old_order_s_s03`,`bai_pro3`.`bai_orders_db`.`old_order_s_s04` AS `old_order_s_s04`,`bai_pro3`.`bai_orders_db`.`old_order_s_s05` AS `old_order_s_s05`,`bai_pro3`.`bai_orders_db`.`old_order_s_s06` AS `old_order_s_s06`,`bai_pro3`.`bai_orders_db`.`old_order_s_s07` AS `old_order_s_s07`,`bai_pro3`.`bai_orders_db`.`old_order_s_s08` AS `old_order_s_s08`,`bai_pro3`.`bai_orders_db`.`old_order_s_s09` AS `old_order_s_s09`,`bai_pro3`.`bai_orders_db`.`old_order_s_s10` AS `old_order_s_s10`,`bai_pro3`.`bai_orders_db`.`old_order_s_s11` AS `old_order_s_s11`,`bai_pro3`.`bai_orders_db`.`old_order_s_s12` AS `old_order_s_s12`,`bai_pro3`.`bai_orders_db`.`old_order_s_s13` AS `old_order_s_s13`,`bai_pro3`.`bai_orders_db`.`old_order_s_s14` AS `old_order_s_s14`,`bai_pro3`.`bai_orders_db`.`old_order_s_s15` AS `old_order_s_s15`,`bai_pro3`.`bai_orders_db`.`old_order_s_s16` AS `old_order_s_s16`,`bai_pro3`.`bai_orders_db`.`old_order_s_s17` AS `old_order_s_s17`,`bai_pro3`.`bai_orders_db`.`old_order_s_s18` AS `old_order_s_s18`,`bai_pro3`.`bai_orders_db`.`old_order_s_s19` AS `old_order_s_s19`,`bai_pro3`.`bai_orders_db`.`old_order_s_s20` AS `old_order_s_s20`,`bai_pro3`.`bai_orders_db`.`old_order_s_s21` AS `old_order_s_s21`,`bai_pro3`.`bai_orders_db`.`old_order_s_s22` AS `old_order_s_s22`,`bai_pro3`.`bai_orders_db`.`old_order_s_s23` AS `old_order_s_s23`,`bai_pro3`.`bai_orders_db`.`old_order_s_s24` AS `old_order_s_s24`,`bai_pro3`.`bai_orders_db`.`old_order_s_s25` AS `old_order_s_s25`,`bai_pro3`.`bai_orders_db`.`old_order_s_s26` AS `old_order_s_s26`,`bai_pro3`.`bai_orders_db`.`old_order_s_s27` AS `old_order_s_s27`,`bai_pro3`.`bai_orders_db`.`old_order_s_s28` AS `old_order_s_s28`,`bai_pro3`.`bai_orders_db`.`old_order_s_s29` AS `old_order_s_s29`,`bai_pro3`.`bai_orders_db`.`old_order_s_s30` AS `old_order_s_s30`,`bai_pro3`.`bai_orders_db`.`old_order_s_s31` AS `old_order_s_s31`,`bai_pro3`.`bai_orders_db`.`old_order_s_s32` AS `old_order_s_s32`,`bai_pro3`.`bai_orders_db`.`old_order_s_s33` AS `old_order_s_s33`,`bai_pro3`.`bai_orders_db`.`old_order_s_s34` AS `old_order_s_s34`,`bai_pro3`.`bai_orders_db`.`old_order_s_s35` AS `old_order_s_s35`,`bai_pro3`.`bai_orders_db`.`old_order_s_s36` AS `old_order_s_s36`,`bai_pro3`.`bai_orders_db`.`old_order_s_s37` AS `old_order_s_s37`,`bai_pro3`.`bai_orders_db`.`old_order_s_s38` AS `old_order_s_s38`,`bai_pro3`.`bai_orders_db`.`old_order_s_s39` AS `old_order_s_s39`,`bai_pro3`.`bai_orders_db`.`old_order_s_s40` AS `old_order_s_s40`,`bai_pro3`.`bai_orders_db`.`old_order_s_s41` AS `old_order_s_s41`,`bai_pro3`.`bai_orders_db`.`old_order_s_s42` AS `old_order_s_s42`,`bai_pro3`.`bai_orders_db`.`old_order_s_s43` AS `old_order_s_s43`,`bai_pro3`.`bai_orders_db`.`old_order_s_s44` AS `old_order_s_s44`,`bai_pro3`.`bai_orders_db`.`old_order_s_s45` AS `old_order_s_s45`,`bai_pro3`.`bai_orders_db`.`old_order_s_s46` AS `old_order_s_s46`,`bai_pro3`.`bai_orders_db`.`old_order_s_s47` AS `old_order_s_s47`,`bai_pro3`.`bai_orders_db`.`old_order_s_s48` AS `old_order_s_s48`,`bai_pro3`.`bai_orders_db`.`old_order_s_s49` AS `old_order_s_s49`,`bai_pro3`.`bai_orders_db`.`old_order_s_s50` AS `old_order_s_s50`,`bai_pro3`.`bai_orders_db`.`packing_method` AS `packing_method`,`bai_pro3`.`bai_orders_db`.`style_id` AS `style_id`,`bai_pro3`.`bai_orders_db`.`carton_id` AS `carton_id`,`bai_pro3`.`bai_orders_db`.`carton_print_status` AS `carton_print_status`,`bai_pro3`.`bai_orders_db`.`ft_status` AS `ft_status`,`bai_pro3`.`bai_orders_db`.`st_status` AS `st_status`,`bai_pro3`.`bai_orders_db`.`pt_status` AS `pt_status` from (`bai_pro4`.`fastreact_plan_summary` left join `bai_pro3`.`bai_orders_db` on(`fastreact_plan_summary`.`schedule` = `bai_pro3`.`bai_orders_db`.`order_del_no`)) order by `fastreact_plan_summary`.`production_start`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_backup_t1` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track` from `ims_log_backup` where `ims_log_backup`.`ims_mod_no` <> 0 group by `ims_log_backup`.`ims_doc_no`,`ims_log_backup`.`ims_size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_backup_t2` AS (select `ims_log`.`ims_date` AS `ims_date`,`ims_log`.`ims_cid` AS `ims_cid`,`ims_log`.`ims_doc_no` AS `ims_doc_no`,`ims_log`.`ims_mod_no` AS `ims_mod_no`,`ims_log`.`ims_shift` AS `ims_shift`,`ims_log`.`ims_size` AS `ims_size`,sum(`ims_log`.`ims_qty`) AS `ims_qty`,sum(`ims_log`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log`.`ims_status` AS `ims_status`,`ims_log`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log`.`ims_log_date` AS `ims_log_date`,`ims_log`.`ims_remarks` AS `ims_remarks`,`ims_log`.`ims_style` AS `ims_style`,`ims_log`.`ims_schedule` AS `ims_schedule`,`ims_log`.`ims_color` AS `ims_color`,`ims_log`.`tid` AS `tid`,`ims_log`.`rand_track` AS `rand_track` from `ims_log` where `ims_log`.`ims_mod_no` <> 0 group by `ims_log`.`ims_doc_no`,`ims_log`.`ims_size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_live` AS select `brandix_bts`.`bundle_creation_data`.`id` AS `id`,`brandix_bts`.`bundle_creation_data`.`date_time` AS `date_time`,`brandix_bts`.`bundle_creation_data`.`style` AS `style`,`brandix_bts`.`bundle_creation_data`.`schedule` AS `schedule`,`brandix_bts`.`bundle_creation_data`.`color` AS `color`,`brandix_bts`.`bundle_creation_data`.`size_title` AS `size_title`,`brandix_bts`.`bundle_creation_data`.`bundle_number` AS `bundle_number`,`brandix_bts`.`bundle_creation_data`.`original_qty` AS `original_qty`,`brandix_bts`.`bundle_creation_data`.`send_qty` AS `send_qty`,`brandix_bts`.`bundle_creation_data`.`recevied_qty` AS `recevied_qty`,`brandix_bts`.`bundle_creation_data`.`missing_qty` AS `missing_qty`,`brandix_bts`.`bundle_creation_data`.`rejected_qty` AS `rejected_qty`,`brandix_bts`.`bundle_creation_data`.`left_over` AS `left_over`,`brandix_bts`.`bundle_creation_data`.`docket_number` AS `docket_number`,`brandix_bts`.`bundle_creation_data`.`assigned_module` AS `assigned_module`,`brandix_bts`.`bundle_creation_data`.`operation_id` AS `operation_id`,`brandix_bts`.`bundle_creation_data`.`shift` AS `shift`,`brandix_bts`.`bundle_creation_data`.`cut_number` AS `cut_number`,`brandix_bts`.`bundle_creation_data`.`input_job_no` AS `input_job_no`,`brandix_bts`.`bundle_creation_data`.`input_job_no_random_ref` AS `input_job_no_random_ref` from `brandix_bts`.`bundle_creation_data` where `brandix_bts`.`bundle_creation_data`.`original_qty` <> `brandix_bts`.`bundle_creation_data`.`recevied_qty` + `brandix_bts`.`bundle_creation_data`.`rejected_qty`$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ims_log_long_pending_transfers` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,`ims_log_backup`.`ims_qty` AS `ims_qty`,`ims_log_backup`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color` from `ims_log_backup` where `ims_log_backup`.`ims_qty` - `ims_log_backup`.`ims_pro_qty` > 0 and `ims_log_backup`.`ims_mod_no` <> 0 and `ims_log_backup`.`ims_date` > '2010-10-01')$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incentive_emb_reference` AS (select `bai_orders_db`.`order_del_no` AS `order_del_no`,if(0 + 0 + 0 + 0 + `bai_orders_db`.`order_embl_e` + `bai_orders_db`.`order_embl_f` + 0 + 0 > 0,1,0) AS `emb_stat` from `bai_orders_db` where 0 + 0 + 0 + 0 + `bai_orders_db`.`order_embl_e` + `bai_orders_db`.`order_embl_f` + 0 + 0 > 0 group by `bai_orders_db`.`order_del_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `incentive_fca_audit_fail_sch` AS (select `fca_audit_fail_db`.`schedule` AS `schedule`,group_concat(distinct `fca_audit_fail_db`.`remarks` separator ',') AS `remarks` from `fca_audit_fail_db` where `fca_audit_fail_db`.`tran_type` = 2 group by `fca_audit_fail_db`.`schedule`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from ((`ims_log` left join `plandoc_stat_log` on(`plandoc_stat_log`.`doc_no` = `ims_log`.`ims_doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref2` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from (`plandoc_stat_log` left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `live_pro_table_ref3` AS (select `bai_orders_db_confirm`.`color_code` AS `color_code`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`a_plies` AS `a_plies` from ((`ims_log_backup` left join `plandoc_stat_log` on(`plandoc_stat_log`.`doc_no` = `ims_log_backup`.`ims_doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `marker_ref_matrix_view` AS (select `cat_stat_log`.`category` AS `category`,`cat_stat_log`.`strip_match` AS `strip_match`,`cat_stat_log`.`gmtway` AS `gmtway`,`marker_ref_matrix`.`marker_ref_tid` AS `marker_ref_tid`,`marker_ref_matrix`.`marker_width` AS `marker_width`,`marker_ref_matrix`.`marker_length` AS `marker_length`,`marker_ref_matrix`.`marker_ref` AS `marker_ref`,`marker_ref_matrix`.`cat_ref` AS `cat_ref`,`marker_ref_matrix`.`allocate_ref` AS `allocate_ref`,`marker_ref_matrix`.`style_code` AS `style_code`,`marker_ref_matrix`.`buyer_code` AS `buyer_code`,`marker_ref_matrix`.`pat_ver` AS `pat_ver`,`marker_ref_matrix`.`xs` AS `xs`,`marker_ref_matrix`.`s` AS `s`,`marker_ref_matrix`.`m` AS `m`,`marker_ref_matrix`.`l` AS `l`,`marker_ref_matrix`.`xl` AS `xl`,`marker_ref_matrix`.`xxl` AS `xxl`,`marker_ref_matrix`.`xxxl` AS `xxxl`,`marker_ref_matrix`.`s01` AS `s01`,`marker_ref_matrix`.`s02` AS `s02`,`marker_ref_matrix`.`s03` AS `s03`,`marker_ref_matrix`.`s04` AS `s04`,`marker_ref_matrix`.`s05` AS `s05`,`marker_ref_matrix`.`s06` AS `s06`,`marker_ref_matrix`.`s07` AS `s07`,`marker_ref_matrix`.`s08` AS `s08`,`marker_ref_matrix`.`s09` AS `s09`,`marker_ref_matrix`.`s10` AS `s10`,`marker_ref_matrix`.`s11` AS `s11`,`marker_ref_matrix`.`s12` AS `s12`,`marker_ref_matrix`.`s13` AS `s13`,`marker_ref_matrix`.`s14` AS `s14`,`marker_ref_matrix`.`s15` AS `s15`,`marker_ref_matrix`.`s16` AS `s16`,`marker_ref_matrix`.`s17` AS `s17`,`marker_ref_matrix`.`s18` AS `s18`,`marker_ref_matrix`.`s19` AS `s19`,`marker_ref_matrix`.`s20` AS `s20`,`marker_ref_matrix`.`s21` AS `s21`,`marker_ref_matrix`.`s22` AS `s22`,`marker_ref_matrix`.`s23` AS `s23`,`marker_ref_matrix`.`s24` AS `s24`,`marker_ref_matrix`.`s25` AS `s25`,`marker_ref_matrix`.`s26` AS `s26`,`marker_ref_matrix`.`s27` AS `s27`,`marker_ref_matrix`.`s28` AS `s28`,`marker_ref_matrix`.`s29` AS `s29`,`marker_ref_matrix`.`s30` AS `s30`,`marker_ref_matrix`.`s31` AS `s31`,`marker_ref_matrix`.`s32` AS `s32`,`marker_ref_matrix`.`s33` AS `s33`,`marker_ref_matrix`.`s34` AS `s34`,`marker_ref_matrix`.`s35` AS `s35`,`marker_ref_matrix`.`s36` AS `s36`,`marker_ref_matrix`.`s37` AS `s37`,`marker_ref_matrix`.`s38` AS `s38`,`marker_ref_matrix`.`s39` AS `s39`,`marker_ref_matrix`.`s40` AS `s40`,`marker_ref_matrix`.`s41` AS `s41`,`marker_ref_matrix`.`s42` AS `s42`,`marker_ref_matrix`.`s43` AS `s43`,`marker_ref_matrix`.`s44` AS `s44`,`marker_ref_matrix`.`s45` AS `s45`,`marker_ref_matrix`.`s46` AS `s46`,`marker_ref_matrix`.`s47` AS `s47`,`marker_ref_matrix`.`s48` AS `s48`,`marker_ref_matrix`.`s49` AS `s49`,`marker_ref_matrix`.`s50` AS `s50`,`marker_ref_matrix`.`lastup` AS `lastup`,`marker_ref_matrix`.`title_size_s01` AS `title_size_s01`,`marker_ref_matrix`.`title_size_s02` AS `title_size_s02`,`marker_ref_matrix`.`title_size_s03` AS `title_size_s03`,`marker_ref_matrix`.`title_size_s04` AS `title_size_s04`,`marker_ref_matrix`.`title_size_s05` AS `title_size_s05`,`marker_ref_matrix`.`title_size_s06` AS `title_size_s06`,`marker_ref_matrix`.`title_size_s07` AS `title_size_s07`,`marker_ref_matrix`.`title_size_s08` AS `title_size_s08`,`marker_ref_matrix`.`title_size_s09` AS `title_size_s09`,`marker_ref_matrix`.`title_size_s10` AS `title_size_s10`,`marker_ref_matrix`.`title_size_s11` AS `title_size_s11`,`marker_ref_matrix`.`title_size_s12` AS `title_size_s12`,`marker_ref_matrix`.`title_size_s13` AS `title_size_s13`,`marker_ref_matrix`.`title_size_s14` AS `title_size_s14`,`marker_ref_matrix`.`title_size_s15` AS `title_size_s15`,`marker_ref_matrix`.`title_size_s16` AS `title_size_s16`,`marker_ref_matrix`.`title_size_s17` AS `title_size_s17`,`marker_ref_matrix`.`title_size_s18` AS `title_size_s18`,`marker_ref_matrix`.`title_size_s19` AS `title_size_s19`,`marker_ref_matrix`.`title_size_s20` AS `title_size_s20`,`marker_ref_matrix`.`title_size_s21` AS `title_size_s21`,`marker_ref_matrix`.`title_size_s22` AS `title_size_s22`,`marker_ref_matrix`.`title_size_s23` AS `title_size_s23`,`marker_ref_matrix`.`title_size_s24` AS `title_size_s24`,`marker_ref_matrix`.`title_size_s25` AS `title_size_s25`,`marker_ref_matrix`.`title_size_s26` AS `title_size_s26`,`marker_ref_matrix`.`title_size_s27` AS `title_size_s27`,`marker_ref_matrix`.`title_size_s28` AS `title_size_s28`,`marker_ref_matrix`.`title_size_s29` AS `title_size_s29`,`marker_ref_matrix`.`title_size_s30` AS `title_size_s30`,`marker_ref_matrix`.`title_size_s31` AS `title_size_s31`,`marker_ref_matrix`.`title_size_s32` AS `title_size_s32`,`marker_ref_matrix`.`title_size_s33` AS `title_size_s33`,`marker_ref_matrix`.`title_size_s34` AS `title_size_s34`,`marker_ref_matrix`.`title_size_s35` AS `title_size_s35`,`marker_ref_matrix`.`title_size_s36` AS `title_size_s36`,`marker_ref_matrix`.`title_size_s37` AS `title_size_s37`,`marker_ref_matrix`.`title_size_s38` AS `title_size_s38`,`marker_ref_matrix`.`title_size_s39` AS `title_size_s39`,`marker_ref_matrix`.`title_size_s40` AS `title_size_s40`,`marker_ref_matrix`.`title_size_s41` AS `title_size_s41`,`marker_ref_matrix`.`title_size_s42` AS `title_size_s42`,`marker_ref_matrix`.`title_size_s43` AS `title_size_s43`,`marker_ref_matrix`.`title_size_s44` AS `title_size_s44`,`marker_ref_matrix`.`title_size_s45` AS `title_size_s45`,`marker_ref_matrix`.`title_size_s46` AS `title_size_s46`,`marker_ref_matrix`.`title_size_s47` AS `title_size_s47`,`marker_ref_matrix`.`title_size_s48` AS `title_size_s48`,`marker_ref_matrix`.`title_size_s49` AS `title_size_s49`,`marker_ref_matrix`.`title_size_s50` AS `title_size_s50`,`marker_ref_matrix`.`title_flag` AS `title_flag`,`maker_stat_log`.`remarks` AS `remarks` from ((`marker_ref_matrix` left join `cat_stat_log` on(`marker_ref_matrix`.`cat_ref` = `cat_stat_log`.`tid`)) left join `maker_stat_log` on(`marker_ref_matrix`.`cat_ref` = `maker_stat_log`.`cat_ref` and `marker_ref_matrix`.`allocate_ref` = `maker_stat_log`.`allocate_ref`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_doc_mix` AS (select `cat_stat_log`.`catyy` AS `catyy`,`bai_orders_db`.`style_id` AS `style_id`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`cat_stat_log`.`patt_ver` AS `cat_patt_ver`,`cat_stat_log`.`strip_match` AS `strip_match`,`cat_stat_log`.`col_des` AS `col_des`,`plandoc_stat_log`.`date` AS `date`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,`plandoc_stat_log`.`cuttable_ref` AS `cuttable_ref`,`plandoc_stat_log`.`allocate_ref` AS `allocate_ref`,`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`pcutno` AS `pcutno`,`plandoc_stat_log`.`ratio` AS `ratio`,`plandoc_stat_log`.`p_xs` AS `p_xs`,`plandoc_stat_log`.`p_s` AS `p_s`,`plandoc_stat_log`.`p_m` AS `p_m`,`plandoc_stat_log`.`p_l` AS `p_l`,`plandoc_stat_log`.`p_xl` AS `p_xl`,`plandoc_stat_log`.`p_xxl` AS `p_xxl`,`plandoc_stat_log`.`p_xxxl` AS `p_xxxl`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`a_xs` AS `a_xs`,`plandoc_stat_log`.`a_s` AS `a_s`,`plandoc_stat_log`.`a_m` AS `a_m`,`plandoc_stat_log`.`a_l` AS `a_l`,`plandoc_stat_log`.`a_xl` AS `a_xl`,`plandoc_stat_log`.`a_xxl` AS `a_xxl`,`plandoc_stat_log`.`a_xxxl` AS `a_xxxl`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`lastup` AS `lastup`,`plandoc_stat_log`.`remarks` AS `remarks`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`pcutdocid` AS `pcutdocid`,`plandoc_stat_log`.`print_status` AS `print_status`,`plandoc_stat_log`.`a_s01` AS `a_s01`,`plandoc_stat_log`.`a_s02` AS `a_s02`,`plandoc_stat_log`.`a_s03` AS `a_s03`,`plandoc_stat_log`.`a_s04` AS `a_s04`,`plandoc_stat_log`.`a_s05` AS `a_s05`,`plandoc_stat_log`.`a_s06` AS `a_s06`,`plandoc_stat_log`.`a_s07` AS `a_s07`,`plandoc_stat_log`.`a_s08` AS `a_s08`,`plandoc_stat_log`.`a_s09` AS `a_s09`,`plandoc_stat_log`.`a_s10` AS `a_s10`,`plandoc_stat_log`.`a_s11` AS `a_s11`,`plandoc_stat_log`.`a_s12` AS `a_s12`,`plandoc_stat_log`.`a_s13` AS `a_s13`,`plandoc_stat_log`.`a_s14` AS `a_s14`,`plandoc_stat_log`.`a_s15` AS `a_s15`,`plandoc_stat_log`.`a_s16` AS `a_s16`,`plandoc_stat_log`.`a_s17` AS `a_s17`,`plandoc_stat_log`.`a_s18` AS `a_s18`,`plandoc_stat_log`.`a_s19` AS `a_s19`,`plandoc_stat_log`.`a_s20` AS `a_s20`,`plandoc_stat_log`.`a_s21` AS `a_s21`,`plandoc_stat_log`.`a_s22` AS `a_s22`,`plandoc_stat_log`.`a_s23` AS `a_s23`,`plandoc_stat_log`.`a_s24` AS `a_s24`,`plandoc_stat_log`.`a_s25` AS `a_s25`,`plandoc_stat_log`.`a_s26` AS `a_s26`,`plandoc_stat_log`.`a_s27` AS `a_s27`,`plandoc_stat_log`.`a_s28` AS `a_s28`,`plandoc_stat_log`.`a_s29` AS `a_s29`,`plandoc_stat_log`.`a_s30` AS `a_s30`,`plandoc_stat_log`.`a_s31` AS `a_s31`,`plandoc_stat_log`.`a_s32` AS `a_s32`,`plandoc_stat_log`.`a_s33` AS `a_s33`,`plandoc_stat_log`.`a_s34` AS `a_s34`,`plandoc_stat_log`.`a_s35` AS `a_s35`,`plandoc_stat_log`.`a_s36` AS `a_s36`,`plandoc_stat_log`.`a_s37` AS `a_s37`,`plandoc_stat_log`.`a_s38` AS `a_s38`,`plandoc_stat_log`.`a_s39` AS `a_s39`,`plandoc_stat_log`.`a_s40` AS `a_s40`,`plandoc_stat_log`.`a_s41` AS `a_s41`,`plandoc_stat_log`.`a_s42` AS `a_s42`,`plandoc_stat_log`.`a_s43` AS `a_s43`,`plandoc_stat_log`.`a_s44` AS `a_s44`,`plandoc_stat_log`.`a_s45` AS `a_s45`,`plandoc_stat_log`.`a_s46` AS `a_s46`,`plandoc_stat_log`.`a_s47` AS `a_s47`,`plandoc_stat_log`.`a_s48` AS `a_s48`,`plandoc_stat_log`.`a_s49` AS `a_s49`,`plandoc_stat_log`.`a_s50` AS `a_s50`,`plandoc_stat_log`.`p_s01` AS `p_s01`,`plandoc_stat_log`.`p_s02` AS `p_s02`,`plandoc_stat_log`.`p_s03` AS `p_s03`,`plandoc_stat_log`.`p_s04` AS `p_s04`,`plandoc_stat_log`.`p_s05` AS `p_s05`,`plandoc_stat_log`.`p_s06` AS `p_s06`,`plandoc_stat_log`.`p_s07` AS `p_s07`,`plandoc_stat_log`.`p_s08` AS `p_s08`,`plandoc_stat_log`.`p_s09` AS `p_s09`,`plandoc_stat_log`.`p_s10` AS `p_s10`,`plandoc_stat_log`.`p_s11` AS `p_s11`,`plandoc_stat_log`.`p_s12` AS `p_s12`,`plandoc_stat_log`.`p_s13` AS `p_s13`,`plandoc_stat_log`.`p_s14` AS `p_s14`,`plandoc_stat_log`.`p_s15` AS `p_s15`,`plandoc_stat_log`.`p_s16` AS `p_s16`,`plandoc_stat_log`.`p_s17` AS `p_s17`,`plandoc_stat_log`.`p_s18` AS `p_s18`,`plandoc_stat_log`.`p_s19` AS `p_s19`,`plandoc_stat_log`.`p_s20` AS `p_s20`,`plandoc_stat_log`.`p_s21` AS `p_s21`,`plandoc_stat_log`.`p_s22` AS `p_s22`,`plandoc_stat_log`.`p_s23` AS `p_s23`,`plandoc_stat_log`.`p_s24` AS `p_s24`,`plandoc_stat_log`.`p_s25` AS `p_s25`,`plandoc_stat_log`.`p_s26` AS `p_s26`,`plandoc_stat_log`.`p_s27` AS `p_s27`,`plandoc_stat_log`.`p_s28` AS `p_s28`,`plandoc_stat_log`.`p_s29` AS `p_s29`,`plandoc_stat_log`.`p_s30` AS `p_s30`,`plandoc_stat_log`.`p_s31` AS `p_s31`,`plandoc_stat_log`.`p_s32` AS `p_s32`,`plandoc_stat_log`.`p_s33` AS `p_s33`,`plandoc_stat_log`.`p_s34` AS `p_s34`,`plandoc_stat_log`.`p_s35` AS `p_s35`,`plandoc_stat_log`.`p_s36` AS `p_s36`,`plandoc_stat_log`.`p_s37` AS `p_s37`,`plandoc_stat_log`.`p_s38` AS `p_s38`,`plandoc_stat_log`.`p_s39` AS `p_s39`,`plandoc_stat_log`.`p_s40` AS `p_s40`,`plandoc_stat_log`.`p_s41` AS `p_s41`,`plandoc_stat_log`.`p_s42` AS `p_s42`,`plandoc_stat_log`.`p_s43` AS `p_s43`,`plandoc_stat_log`.`p_s44` AS `p_s44`,`plandoc_stat_log`.`p_s45` AS `p_s45`,`plandoc_stat_log`.`p_s46` AS `p_s46`,`plandoc_stat_log`.`p_s47` AS `p_s47`,`plandoc_stat_log`.`p_s48` AS `p_s48`,`plandoc_stat_log`.`p_s49` AS `p_s49`,`plandoc_stat_log`.`p_s50` AS `p_s50`,`plandoc_stat_log`.`rm_date` AS `rm_date`,`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`fab_des` AS `fab_des`,`cat_stat_log`.`gmtway` AS `gmtway`,`cat_stat_log`.`compo_no` AS `compo_no`,`cat_stat_log`.`purwidth` AS `purwidth`,`bai_orders_db`.`color_code` AS `color_code`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`fabric_status` AS `fabric_status`,`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des` from ((`plandoc_stat_log` left join `cat_stat_log` on(`plandoc_stat_log`.`cat_ref` = `cat_stat_log`.`tid`)) left join `bai_orders_db` on(`plandoc_stat_log`.`order_tid` = `bai_orders_db`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_doc_mk_mix` AS (select `order_cat_doc_mix`.`catyy` AS `catyy`,`order_cat_doc_mix`.`cat_patt_ver` AS `cat_patt_ver`,`maker_stat_log`.`remarks` AS `mk_file`,`maker_stat_log`.`mk_ver` AS `mk_ver`,`maker_stat_log`.`mklength` AS `mklength`,`order_cat_doc_mix`.`style_id` AS `style_id`,`order_cat_doc_mix`.`col_des` AS `col_des`,`order_cat_doc_mix`.`gmtway` AS `gmtway`,`order_cat_doc_mix`.`strip_match` AS `strip_match`,`order_cat_doc_mix`.`fab_des` AS `fab_des`,`order_cat_doc_mix`.`clubbing` AS `clubbing`,`order_cat_doc_mix`.`date` AS `date`,`order_cat_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_doc_mix`.`compo_no` AS `compo_no`,`order_cat_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_doc_mix`.`order_tid` AS `order_tid`,`order_cat_doc_mix`.`pcutno` AS `pcutno`,`order_cat_doc_mix`.`ratio` AS `ratio`,`order_cat_doc_mix`.`p_xs` AS `p_xs`,`order_cat_doc_mix`.`p_s` AS `p_s`,`order_cat_doc_mix`.`p_m` AS `p_m`,`order_cat_doc_mix`.`p_l` AS `p_l`,`order_cat_doc_mix`.`p_xl` AS `p_xl`,`order_cat_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_doc_mix`.`p_plies` AS `p_plies`,`order_cat_doc_mix`.`doc_no` AS `doc_no`,`order_cat_doc_mix`.`acutno` AS `acutno`,`order_cat_doc_mix`.`a_xs` AS `a_xs`,`order_cat_doc_mix`.`a_s` AS `a_s`,`order_cat_doc_mix`.`a_m` AS `a_m`,`order_cat_doc_mix`.`a_l` AS `a_l`,`order_cat_doc_mix`.`a_xl` AS `a_xl`,`order_cat_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_doc_mix`.`a_plies` AS `a_plies`,`order_cat_doc_mix`.`lastup` AS `lastup`,`order_cat_doc_mix`.`remarks` AS `remarks`,`order_cat_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_doc_mix`.`print_status` AS `print_status`,`order_cat_doc_mix`.`a_s01` AS `a_s01`,`order_cat_doc_mix`.`a_s02` AS `a_s02`,`order_cat_doc_mix`.`a_s03` AS `a_s03`,`order_cat_doc_mix`.`a_s04` AS `a_s04`,`order_cat_doc_mix`.`a_s05` AS `a_s05`,`order_cat_doc_mix`.`a_s06` AS `a_s06`,`order_cat_doc_mix`.`a_s07` AS `a_s07`,`order_cat_doc_mix`.`a_s08` AS `a_s08`,`order_cat_doc_mix`.`a_s09` AS `a_s09`,`order_cat_doc_mix`.`a_s10` AS `a_s10`,`order_cat_doc_mix`.`a_s11` AS `a_s11`,`order_cat_doc_mix`.`a_s12` AS `a_s12`,`order_cat_doc_mix`.`a_s13` AS `a_s13`,`order_cat_doc_mix`.`a_s14` AS `a_s14`,`order_cat_doc_mix`.`a_s15` AS `a_s15`,`order_cat_doc_mix`.`a_s16` AS `a_s16`,`order_cat_doc_mix`.`a_s17` AS `a_s17`,`order_cat_doc_mix`.`a_s18` AS `a_s18`,`order_cat_doc_mix`.`a_s19` AS `a_s19`,`order_cat_doc_mix`.`a_s20` AS `a_s20`,`order_cat_doc_mix`.`a_s21` AS `a_s21`,`order_cat_doc_mix`.`a_s22` AS `a_s22`,`order_cat_doc_mix`.`a_s23` AS `a_s23`,`order_cat_doc_mix`.`a_s24` AS `a_s24`,`order_cat_doc_mix`.`a_s25` AS `a_s25`,`order_cat_doc_mix`.`a_s26` AS `a_s26`,`order_cat_doc_mix`.`a_s27` AS `a_s27`,`order_cat_doc_mix`.`a_s28` AS `a_s28`,`order_cat_doc_mix`.`a_s29` AS `a_s29`,`order_cat_doc_mix`.`a_s30` AS `a_s30`,`order_cat_doc_mix`.`a_s31` AS `a_s31`,`order_cat_doc_mix`.`a_s32` AS `a_s32`,`order_cat_doc_mix`.`a_s33` AS `a_s33`,`order_cat_doc_mix`.`a_s34` AS `a_s34`,`order_cat_doc_mix`.`a_s35` AS `a_s35`,`order_cat_doc_mix`.`a_s36` AS `a_s36`,`order_cat_doc_mix`.`a_s37` AS `a_s37`,`order_cat_doc_mix`.`a_s38` AS `a_s38`,`order_cat_doc_mix`.`a_s39` AS `a_s39`,`order_cat_doc_mix`.`a_s40` AS `a_s40`,`order_cat_doc_mix`.`a_s41` AS `a_s41`,`order_cat_doc_mix`.`a_s42` AS `a_s42`,`order_cat_doc_mix`.`a_s43` AS `a_s43`,`order_cat_doc_mix`.`a_s44` AS `a_s44`,`order_cat_doc_mix`.`a_s45` AS `a_s45`,`order_cat_doc_mix`.`a_s46` AS `a_s46`,`order_cat_doc_mix`.`a_s47` AS `a_s47`,`order_cat_doc_mix`.`a_s48` AS `a_s48`,`order_cat_doc_mix`.`a_s49` AS `a_s49`,`order_cat_doc_mix`.`a_s50` AS `a_s50`,`order_cat_doc_mix`.`p_s01` AS `p_s01`,`order_cat_doc_mix`.`p_s02` AS `p_s02`,`order_cat_doc_mix`.`p_s03` AS `p_s03`,`order_cat_doc_mix`.`p_s04` AS `p_s04`,`order_cat_doc_mix`.`p_s05` AS `p_s05`,`order_cat_doc_mix`.`p_s06` AS `p_s06`,`order_cat_doc_mix`.`p_s07` AS `p_s07`,`order_cat_doc_mix`.`p_s08` AS `p_s08`,`order_cat_doc_mix`.`p_s09` AS `p_s09`,`order_cat_doc_mix`.`p_s10` AS `p_s10`,`order_cat_doc_mix`.`p_s11` AS `p_s11`,`order_cat_doc_mix`.`p_s12` AS `p_s12`,`order_cat_doc_mix`.`p_s13` AS `p_s13`,`order_cat_doc_mix`.`p_s14` AS `p_s14`,`order_cat_doc_mix`.`p_s15` AS `p_s15`,`order_cat_doc_mix`.`p_s16` AS `p_s16`,`order_cat_doc_mix`.`p_s17` AS `p_s17`,`order_cat_doc_mix`.`p_s18` AS `p_s18`,`order_cat_doc_mix`.`p_s19` AS `p_s19`,`order_cat_doc_mix`.`p_s20` AS `p_s20`,`order_cat_doc_mix`.`p_s21` AS `p_s21`,`order_cat_doc_mix`.`p_s22` AS `p_s22`,`order_cat_doc_mix`.`p_s23` AS `p_s23`,`order_cat_doc_mix`.`p_s24` AS `p_s24`,`order_cat_doc_mix`.`p_s25` AS `p_s25`,`order_cat_doc_mix`.`p_s26` AS `p_s26`,`order_cat_doc_mix`.`p_s27` AS `p_s27`,`order_cat_doc_mix`.`p_s28` AS `p_s28`,`order_cat_doc_mix`.`p_s29` AS `p_s29`,`order_cat_doc_mix`.`p_s30` AS `p_s30`,`order_cat_doc_mix`.`p_s31` AS `p_s31`,`order_cat_doc_mix`.`p_s32` AS `p_s32`,`order_cat_doc_mix`.`p_s33` AS `p_s33`,`order_cat_doc_mix`.`p_s34` AS `p_s34`,`order_cat_doc_mix`.`p_s35` AS `p_s35`,`order_cat_doc_mix`.`p_s36` AS `p_s36`,`order_cat_doc_mix`.`p_s37` AS `p_s37`,`order_cat_doc_mix`.`p_s38` AS `p_s38`,`order_cat_doc_mix`.`p_s39` AS `p_s39`,`order_cat_doc_mix`.`p_s40` AS `p_s40`,`order_cat_doc_mix`.`p_s41` AS `p_s41`,`order_cat_doc_mix`.`p_s42` AS `p_s42`,`order_cat_doc_mix`.`p_s43` AS `p_s43`,`order_cat_doc_mix`.`p_s44` AS `p_s44`,`order_cat_doc_mix`.`p_s45` AS `p_s45`,`order_cat_doc_mix`.`p_s46` AS `p_s46`,`order_cat_doc_mix`.`p_s47` AS `p_s47`,`order_cat_doc_mix`.`p_s48` AS `p_s48`,`order_cat_doc_mix`.`p_s49` AS `p_s49`,`order_cat_doc_mix`.`p_s50` AS `p_s50`,`order_cat_doc_mix`.`rm_date` AS `rm_date`,`order_cat_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_doc_mix`.`plan_module` AS `plan_module`,`order_cat_doc_mix`.`category` AS `category`,`order_cat_doc_mix`.`color_code` AS `color_code`,`order_cat_doc_mix`.`fabric_status` AS `fabric_status`,round(`order_cat_doc_mix`.`a_plies` * `maker_stat_log`.`mklength` * (1 + `cuttable_stat_log`.`cuttable_wastage`),2) + (`order_cat_doc_mix`.`a_xs` + `order_cat_doc_mix`.`a_s` + `order_cat_doc_mix`.`a_m` + `order_cat_doc_mix`.`a_l` + `order_cat_doc_mix`.`a_xl` + `order_cat_doc_mix`.`a_xxl` + `order_cat_doc_mix`.`a_xxxl` + `order_cat_doc_mix`.`a_s01` + `order_cat_doc_mix`.`a_s02` + `order_cat_doc_mix`.`a_s03` + `order_cat_doc_mix`.`a_s04` + `order_cat_doc_mix`.`a_s05` + `order_cat_doc_mix`.`a_s06` + `order_cat_doc_mix`.`a_s07` + `order_cat_doc_mix`.`a_s08` + `order_cat_doc_mix`.`a_s09` + `order_cat_doc_mix`.`a_s10` + `order_cat_doc_mix`.`a_s11` + `order_cat_doc_mix`.`a_s12` + `order_cat_doc_mix`.`a_s13` + `order_cat_doc_mix`.`a_s14` + `order_cat_doc_mix`.`a_s15` + `order_cat_doc_mix`.`a_s16` + `order_cat_doc_mix`.`a_s17` + `order_cat_doc_mix`.`a_s18` + `order_cat_doc_mix`.`a_s19` + `order_cat_doc_mix`.`a_s20` + `order_cat_doc_mix`.`a_s21` + `order_cat_doc_mix`.`a_s22` + `order_cat_doc_mix`.`a_s23` + `order_cat_doc_mix`.`a_s24` + `order_cat_doc_mix`.`a_s25` + `order_cat_doc_mix`.`a_s26` + `order_cat_doc_mix`.`a_s27` + `order_cat_doc_mix`.`a_s28` + `order_cat_doc_mix`.`a_s29` + `order_cat_doc_mix`.`a_s30` + `order_cat_doc_mix`.`a_s31` + `order_cat_doc_mix`.`a_s32` + `order_cat_doc_mix`.`a_s33` + `order_cat_doc_mix`.`a_s34` + `order_cat_doc_mix`.`a_s35` + `order_cat_doc_mix`.`a_s36` + `order_cat_doc_mix`.`a_s37` + `order_cat_doc_mix`.`a_s38` + `order_cat_doc_mix`.`a_s39` + `order_cat_doc_mix`.`a_s40` + `order_cat_doc_mix`.`a_s41` + `order_cat_doc_mix`.`a_s42` + `order_cat_doc_mix`.`a_s43` + `order_cat_doc_mix`.`a_s44` + `order_cat_doc_mix`.`a_s45` + `order_cat_doc_mix`.`a_s46` + `order_cat_doc_mix`.`a_s47` + `order_cat_doc_mix`.`a_s48` + `order_cat_doc_mix`.`a_s49` + `order_cat_doc_mix`.`a_s50`) * `order_cat_doc_mix`.`a_plies` * `fn_know_binding_con`(`maker_stat_log`.`order_tid`) AS `material_req`,`order_cat_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_doc_mix`.`order_col_des` AS `order_col_des`,`order_cat_doc_mix`.`plan_lot_ref` AS `plan_lot_ref` from ((`order_cat_doc_mix` left join `maker_stat_log` on(`order_cat_doc_mix`.`mk_ref` = `maker_stat_log`.`tid`)) left join `cuttable_stat_log` on(`cuttable_stat_log`.`cat_id` = `order_cat_doc_mix`.`cat_ref`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_doc_mk_mix_v2` AS (select `order_cat_doc_mix`.`catyy` AS `catyy`,`order_cat_doc_mix`.`cat_patt_ver` AS `cat_patt_ver`,`maker_stat_log`.`remarks` AS `mk_file`,`maker_stat_log`.`mk_ver` AS `mk_ver`,`maker_stat_log`.`mklength` AS `mklength`,`order_cat_doc_mix`.`style_id` AS `style_id`,`order_cat_doc_mix`.`col_des` AS `col_des`,`order_cat_doc_mix`.`gmtway` AS `gmtway`,`order_cat_doc_mix`.`strip_match` AS `strip_match`,`order_cat_doc_mix`.`fab_des` AS `fab_des`,`order_cat_doc_mix`.`clubbing` AS `clubbing`,`order_cat_doc_mix`.`date` AS `date`,`order_cat_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_doc_mix`.`compo_no` AS `compo_no`,`order_cat_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_doc_mix`.`order_tid` AS `order_tid`,`order_cat_doc_mix`.`pcutno` AS `pcutno`,`order_cat_doc_mix`.`ratio` AS `ratio`,`order_cat_doc_mix`.`p_xs` AS `p_xs`,`order_cat_doc_mix`.`p_s` AS `p_s`,`order_cat_doc_mix`.`p_m` AS `p_m`,`order_cat_doc_mix`.`p_l` AS `p_l`,`order_cat_doc_mix`.`p_xl` AS `p_xl`,`order_cat_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_doc_mix`.`p_plies` AS `p_plies`,`order_cat_doc_mix`.`doc_no` AS `doc_no`,`order_cat_doc_mix`.`acutno` AS `acutno`,`order_cat_doc_mix`.`a_xs` AS `a_xs`,`order_cat_doc_mix`.`a_s` AS `a_s`,`order_cat_doc_mix`.`a_m` AS `a_m`,`order_cat_doc_mix`.`a_l` AS `a_l`,`order_cat_doc_mix`.`a_xl` AS `a_xl`,`order_cat_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_doc_mix`.`a_plies` AS `a_plies`,`order_cat_doc_mix`.`lastup` AS `lastup`,`order_cat_doc_mix`.`remarks` AS `remarks`,`order_cat_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_doc_mix`.`print_status` AS `print_status`,`order_cat_doc_mix`.`a_s01` AS `a_s01`,`order_cat_doc_mix`.`a_s02` AS `a_s02`,`order_cat_doc_mix`.`a_s03` AS `a_s03`,`order_cat_doc_mix`.`a_s04` AS `a_s04`,`order_cat_doc_mix`.`a_s05` AS `a_s05`,`order_cat_doc_mix`.`a_s06` AS `a_s06`,`order_cat_doc_mix`.`a_s07` AS `a_s07`,`order_cat_doc_mix`.`a_s08` AS `a_s08`,`order_cat_doc_mix`.`a_s09` AS `a_s09`,`order_cat_doc_mix`.`a_s10` AS `a_s10`,`order_cat_doc_mix`.`a_s11` AS `a_s11`,`order_cat_doc_mix`.`a_s12` AS `a_s12`,`order_cat_doc_mix`.`a_s13` AS `a_s13`,`order_cat_doc_mix`.`a_s14` AS `a_s14`,`order_cat_doc_mix`.`a_s15` AS `a_s15`,`order_cat_doc_mix`.`a_s16` AS `a_s16`,`order_cat_doc_mix`.`a_s17` AS `a_s17`,`order_cat_doc_mix`.`a_s18` AS `a_s18`,`order_cat_doc_mix`.`a_s19` AS `a_s19`,`order_cat_doc_mix`.`a_s20` AS `a_s20`,`order_cat_doc_mix`.`a_s21` AS `a_s21`,`order_cat_doc_mix`.`a_s22` AS `a_s22`,`order_cat_doc_mix`.`a_s23` AS `a_s23`,`order_cat_doc_mix`.`a_s24` AS `a_s24`,`order_cat_doc_mix`.`a_s25` AS `a_s25`,`order_cat_doc_mix`.`a_s26` AS `a_s26`,`order_cat_doc_mix`.`a_s27` AS `a_s27`,`order_cat_doc_mix`.`a_s28` AS `a_s28`,`order_cat_doc_mix`.`a_s29` AS `a_s29`,`order_cat_doc_mix`.`a_s30` AS `a_s30`,`order_cat_doc_mix`.`a_s31` AS `a_s31`,`order_cat_doc_mix`.`a_s32` AS `a_s32`,`order_cat_doc_mix`.`a_s33` AS `a_s33`,`order_cat_doc_mix`.`a_s34` AS `a_s34`,`order_cat_doc_mix`.`a_s35` AS `a_s35`,`order_cat_doc_mix`.`a_s36` AS `a_s36`,`order_cat_doc_mix`.`a_s37` AS `a_s37`,`order_cat_doc_mix`.`a_s38` AS `a_s38`,`order_cat_doc_mix`.`a_s39` AS `a_s39`,`order_cat_doc_mix`.`a_s40` AS `a_s40`,`order_cat_doc_mix`.`a_s41` AS `a_s41`,`order_cat_doc_mix`.`a_s42` AS `a_s42`,`order_cat_doc_mix`.`a_s43` AS `a_s43`,`order_cat_doc_mix`.`a_s44` AS `a_s44`,`order_cat_doc_mix`.`a_s45` AS `a_s45`,`order_cat_doc_mix`.`a_s46` AS `a_s46`,`order_cat_doc_mix`.`a_s47` AS `a_s47`,`order_cat_doc_mix`.`a_s48` AS `a_s48`,`order_cat_doc_mix`.`a_s49` AS `a_s49`,`order_cat_doc_mix`.`a_s50` AS `a_s50`,`order_cat_doc_mix`.`p_s01` AS `p_s01`,`order_cat_doc_mix`.`p_s02` AS `p_s02`,`order_cat_doc_mix`.`p_s03` AS `p_s03`,`order_cat_doc_mix`.`p_s04` AS `p_s04`,`order_cat_doc_mix`.`p_s05` AS `p_s05`,`order_cat_doc_mix`.`p_s06` AS `p_s06`,`order_cat_doc_mix`.`p_s07` AS `p_s07`,`order_cat_doc_mix`.`p_s08` AS `p_s08`,`order_cat_doc_mix`.`p_s09` AS `p_s09`,`order_cat_doc_mix`.`p_s10` AS `p_s10`,`order_cat_doc_mix`.`p_s11` AS `p_s11`,`order_cat_doc_mix`.`p_s12` AS `p_s12`,`order_cat_doc_mix`.`p_s13` AS `p_s13`,`order_cat_doc_mix`.`p_s14` AS `p_s14`,`order_cat_doc_mix`.`p_s15` AS `p_s15`,`order_cat_doc_mix`.`p_s16` AS `p_s16`,`order_cat_doc_mix`.`p_s17` AS `p_s17`,`order_cat_doc_mix`.`p_s18` AS `p_s18`,`order_cat_doc_mix`.`p_s19` AS `p_s19`,`order_cat_doc_mix`.`p_s20` AS `p_s20`,`order_cat_doc_mix`.`p_s21` AS `p_s21`,`order_cat_doc_mix`.`p_s22` AS `p_s22`,`order_cat_doc_mix`.`p_s23` AS `p_s23`,`order_cat_doc_mix`.`p_s24` AS `p_s24`,`order_cat_doc_mix`.`p_s25` AS `p_s25`,`order_cat_doc_mix`.`p_s26` AS `p_s26`,`order_cat_doc_mix`.`p_s27` AS `p_s27`,`order_cat_doc_mix`.`p_s28` AS `p_s28`,`order_cat_doc_mix`.`p_s29` AS `p_s29`,`order_cat_doc_mix`.`p_s30` AS `p_s30`,`order_cat_doc_mix`.`p_s31` AS `p_s31`,`order_cat_doc_mix`.`p_s32` AS `p_s32`,`order_cat_doc_mix`.`p_s33` AS `p_s33`,`order_cat_doc_mix`.`p_s34` AS `p_s34`,`order_cat_doc_mix`.`p_s35` AS `p_s35`,`order_cat_doc_mix`.`p_s36` AS `p_s36`,`order_cat_doc_mix`.`p_s37` AS `p_s37`,`order_cat_doc_mix`.`p_s38` AS `p_s38`,`order_cat_doc_mix`.`p_s39` AS `p_s39`,`order_cat_doc_mix`.`p_s40` AS `p_s40`,`order_cat_doc_mix`.`p_s41` AS `p_s41`,`order_cat_doc_mix`.`p_s42` AS `p_s42`,`order_cat_doc_mix`.`p_s43` AS `p_s43`,`order_cat_doc_mix`.`p_s44` AS `p_s44`,`order_cat_doc_mix`.`p_s45` AS `p_s45`,`order_cat_doc_mix`.`p_s46` AS `p_s46`,`order_cat_doc_mix`.`p_s47` AS `p_s47`,`order_cat_doc_mix`.`p_s48` AS `p_s48`,`order_cat_doc_mix`.`p_s49` AS `p_s49`,`order_cat_doc_mix`.`p_s50` AS `p_s50`,`order_cat_doc_mix`.`rm_date` AS `rm_date`,`order_cat_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_doc_mix`.`plan_module` AS `plan_module`,`order_cat_doc_mix`.`category` AS `category`,`order_cat_doc_mix`.`color_code` AS `color_code`,`order_cat_doc_mix`.`fabric_status` AS `fabric_status`,round(`order_cat_doc_mix`.`a_plies` * `maker_stat_log`.`mklength` * (1 + `cuttable_stat_log`.`cuttable_wastage`),2) + (`order_cat_doc_mix`.`a_xs` + `order_cat_doc_mix`.`a_s` + `order_cat_doc_mix`.`a_m` + `order_cat_doc_mix`.`a_l` + `order_cat_doc_mix`.`a_xl` + `order_cat_doc_mix`.`a_xxl` + `order_cat_doc_mix`.`a_xxxl` + `order_cat_doc_mix`.`a_s01` + `order_cat_doc_mix`.`a_s02` + `order_cat_doc_mix`.`a_s03` + `order_cat_doc_mix`.`a_s04` + `order_cat_doc_mix`.`a_s05` + `order_cat_doc_mix`.`a_s06` + `order_cat_doc_mix`.`a_s07` + `order_cat_doc_mix`.`a_s08` + `order_cat_doc_mix`.`a_s09` + `order_cat_doc_mix`.`a_s10` + `order_cat_doc_mix`.`a_s11` + `order_cat_doc_mix`.`a_s12` + `order_cat_doc_mix`.`a_s13` + `order_cat_doc_mix`.`a_s14` + `order_cat_doc_mix`.`a_s15` + `order_cat_doc_mix`.`a_s16` + `order_cat_doc_mix`.`a_s17` + `order_cat_doc_mix`.`a_s18` + `order_cat_doc_mix`.`a_s19` + `order_cat_doc_mix`.`a_s20` + `order_cat_doc_mix`.`a_s21` + `order_cat_doc_mix`.`a_s22` + `order_cat_doc_mix`.`a_s23` + `order_cat_doc_mix`.`a_s24` + `order_cat_doc_mix`.`a_s25` + `order_cat_doc_mix`.`a_s26` + `order_cat_doc_mix`.`a_s27` + `order_cat_doc_mix`.`a_s28` + `order_cat_doc_mix`.`a_s29` + `order_cat_doc_mix`.`a_s30` + `order_cat_doc_mix`.`a_s31` + `order_cat_doc_mix`.`a_s32` + `order_cat_doc_mix`.`a_s33` + `order_cat_doc_mix`.`a_s34` + `order_cat_doc_mix`.`a_s35` + `order_cat_doc_mix`.`a_s36` + `order_cat_doc_mix`.`a_s37` + `order_cat_doc_mix`.`a_s38` + `order_cat_doc_mix`.`a_s39` + `order_cat_doc_mix`.`a_s40` + `order_cat_doc_mix`.`a_s41` + `order_cat_doc_mix`.`a_s42` + `order_cat_doc_mix`.`a_s43` + `order_cat_doc_mix`.`a_s44` + `order_cat_doc_mix`.`a_s45` + `order_cat_doc_mix`.`a_s46` + `order_cat_doc_mix`.`a_s47` + `order_cat_doc_mix`.`a_s48` + `order_cat_doc_mix`.`a_s49` + `order_cat_doc_mix`.`a_s50`) * `order_cat_doc_mix`.`a_plies` * `fn_know_binding_con_v2`(`maker_stat_log`.`order_tid`,`order_cat_doc_mix`.`category`) AS `material_req`,`order_cat_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_doc_mix`.`order_col_des` AS `order_col_des`,`order_cat_doc_mix`.`plan_lot_ref` AS `plan_lot_ref` from ((`order_cat_doc_mix` left join `maker_stat_log` on(`order_cat_doc_mix`.`mk_ref` = `maker_stat_log`.`tid`)) left join `cuttable_stat_log` on(`cuttable_stat_log`.`cat_id` = `order_cat_doc_mix`.`cat_ref`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_recut_doc_mix` AS (select `recut_v2`.`date` AS `date`,`recut_v2`.`cat_ref` AS `cat_ref`,`recut_v2`.`cuttable_ref` AS `cuttable_ref`,`recut_v2`.`allocate_ref` AS `allocate_ref`,`recut_v2`.`mk_ref` AS `mk_ref`,`recut_v2`.`order_tid` AS `order_tid`,`recut_v2`.`pcutno` AS `pcutno`,`recut_v2`.`ratio` AS `ratio`,`recut_v2`.`p_xs` AS `p_xs`,`recut_v2`.`p_s` AS `p_s`,`recut_v2`.`p_m` AS `p_m`,`recut_v2`.`p_l` AS `p_l`,`recut_v2`.`p_xl` AS `p_xl`,`recut_v2`.`p_xxl` AS `p_xxl`,`recut_v2`.`p_xxxl` AS `p_xxxl`,`recut_v2`.`p_plies` AS `p_plies`,`recut_v2`.`doc_no` AS `doc_no`,`recut_v2`.`acutno` AS `acutno`,`recut_v2`.`a_xs` AS `a_xs`,`recut_v2`.`a_s` AS `a_s`,`recut_v2`.`a_m` AS `a_m`,`recut_v2`.`a_l` AS `a_l`,`recut_v2`.`a_xl` AS `a_xl`,`recut_v2`.`a_xxl` AS `a_xxl`,`recut_v2`.`a_xxxl` AS `a_xxxl`,`recut_v2`.`a_plies` AS `a_plies`,`recut_v2`.`lastup` AS `lastup`,`recut_v2`.`remarks` AS `remarks`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`act_cut_issue_status` AS `act_cut_issue_status`,`recut_v2`.`pcutdocid` AS `pcutdocid`,`recut_v2`.`print_status` AS `print_status`,`recut_v2`.`a_s01` AS `a_s01`,`recut_v2`.`a_s02` AS `a_s02`,`recut_v2`.`a_s03` AS `a_s03`,`recut_v2`.`a_s04` AS `a_s04`,`recut_v2`.`a_s05` AS `a_s05`,`recut_v2`.`a_s06` AS `a_s06`,`recut_v2`.`a_s07` AS `a_s07`,`recut_v2`.`a_s08` AS `a_s08`,`recut_v2`.`a_s09` AS `a_s09`,`recut_v2`.`a_s10` AS `a_s10`,`recut_v2`.`a_s11` AS `a_s11`,`recut_v2`.`a_s12` AS `a_s12`,`recut_v2`.`a_s13` AS `a_s13`,`recut_v2`.`a_s14` AS `a_s14`,`recut_v2`.`a_s15` AS `a_s15`,`recut_v2`.`a_s16` AS `a_s16`,`recut_v2`.`a_s17` AS `a_s17`,`recut_v2`.`a_s18` AS `a_s18`,`recut_v2`.`a_s19` AS `a_s19`,`recut_v2`.`a_s20` AS `a_s20`,`recut_v2`.`a_s21` AS `a_s21`,`recut_v2`.`a_s22` AS `a_s22`,`recut_v2`.`a_s23` AS `a_s23`,`recut_v2`.`a_s24` AS `a_s24`,`recut_v2`.`a_s25` AS `a_s25`,`recut_v2`.`a_s26` AS `a_s26`,`recut_v2`.`a_s27` AS `a_s27`,`recut_v2`.`a_s28` AS `a_s28`,`recut_v2`.`a_s29` AS `a_s29`,`recut_v2`.`a_s30` AS `a_s30`,`recut_v2`.`a_s31` AS `a_s31`,`recut_v2`.`a_s32` AS `a_s32`,`recut_v2`.`a_s33` AS `a_s33`,`recut_v2`.`a_s34` AS `a_s34`,`recut_v2`.`a_s35` AS `a_s35`,`recut_v2`.`a_s36` AS `a_s36`,`recut_v2`.`a_s37` AS `a_s37`,`recut_v2`.`a_s38` AS `a_s38`,`recut_v2`.`a_s39` AS `a_s39`,`recut_v2`.`a_s40` AS `a_s40`,`recut_v2`.`a_s41` AS `a_s41`,`recut_v2`.`a_s42` AS `a_s42`,`recut_v2`.`a_s43` AS `a_s43`,`recut_v2`.`a_s44` AS `a_s44`,`recut_v2`.`a_s45` AS `a_s45`,`recut_v2`.`a_s46` AS `a_s46`,`recut_v2`.`a_s47` AS `a_s47`,`recut_v2`.`a_s48` AS `a_s48`,`recut_v2`.`a_s49` AS `a_s49`,`recut_v2`.`a_s50` AS `a_s50`,`recut_v2`.`p_s01` AS `p_s01`,`recut_v2`.`p_s02` AS `p_s02`,`recut_v2`.`p_s03` AS `p_s03`,`recut_v2`.`p_s04` AS `p_s04`,`recut_v2`.`p_s05` AS `p_s05`,`recut_v2`.`p_s06` AS `p_s06`,`recut_v2`.`p_s07` AS `p_s07`,`recut_v2`.`p_s08` AS `p_s08`,`recut_v2`.`p_s09` AS `p_s09`,`recut_v2`.`p_s10` AS `p_s10`,`recut_v2`.`p_s11` AS `p_s11`,`recut_v2`.`p_s12` AS `p_s12`,`recut_v2`.`p_s13` AS `p_s13`,`recut_v2`.`p_s14` AS `p_s14`,`recut_v2`.`p_s15` AS `p_s15`,`recut_v2`.`p_s16` AS `p_s16`,`recut_v2`.`p_s17` AS `p_s17`,`recut_v2`.`p_s18` AS `p_s18`,`recut_v2`.`p_s19` AS `p_s19`,`recut_v2`.`p_s20` AS `p_s20`,`recut_v2`.`p_s21` AS `p_s21`,`recut_v2`.`p_s22` AS `p_s22`,`recut_v2`.`p_s23` AS `p_s23`,`recut_v2`.`p_s24` AS `p_s24`,`recut_v2`.`p_s25` AS `p_s25`,`recut_v2`.`p_s26` AS `p_s26`,`recut_v2`.`p_s27` AS `p_s27`,`recut_v2`.`p_s28` AS `p_s28`,`recut_v2`.`p_s29` AS `p_s29`,`recut_v2`.`p_s30` AS `p_s30`,`recut_v2`.`p_s31` AS `p_s31`,`recut_v2`.`p_s32` AS `p_s32`,`recut_v2`.`p_s33` AS `p_s33`,`recut_v2`.`p_s34` AS `p_s34`,`recut_v2`.`p_s35` AS `p_s35`,`recut_v2`.`p_s36` AS `p_s36`,`recut_v2`.`p_s37` AS `p_s37`,`recut_v2`.`p_s38` AS `p_s38`,`recut_v2`.`p_s39` AS `p_s39`,`recut_v2`.`p_s40` AS `p_s40`,`recut_v2`.`p_s41` AS `p_s41`,`recut_v2`.`p_s42` AS `p_s42`,`recut_v2`.`p_s43` AS `p_s43`,`recut_v2`.`p_s44` AS `p_s44`,`recut_v2`.`p_s45` AS `p_s45`,`recut_v2`.`p_s46` AS `p_s46`,`recut_v2`.`p_s47` AS `p_s47`,`recut_v2`.`p_s48` AS `p_s48`,`recut_v2`.`p_s49` AS `p_s49`,`recut_v2`.`p_s50` AS `p_s50`,`recut_v2`.`rm_date` AS `rm_date`,`recut_v2`.`cut_inp_temp` AS `cut_inp_temp`,`recut_v2`.`plan_module` AS `plan_module`,`cat_stat_log`.`category` AS `category`,`bai_orders_db`.`color_code` AS `color_code`,`recut_v2`.`fabric_status` AS `fabric_status`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`recut_v2`.`plan_lot_ref` AS `plan_lot_ref`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_orders_db`.`order_style_no` AS `order_style_no` from ((`recut_v2` left join `cat_stat_log` on(`recut_v2`.`cat_ref` = `cat_stat_log`.`tid`)) left join `bai_orders_db` on(`recut_v2`.`order_tid` = `bai_orders_db`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `order_cat_recut_doc_mk_mix` AS (select `order_cat_recut_doc_mix`.`date` AS `date`,`order_cat_recut_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_recut_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_recut_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_recut_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_recut_doc_mix`.`order_tid` AS `order_tid`,`order_cat_recut_doc_mix`.`pcutno` AS `pcutno`,`order_cat_recut_doc_mix`.`ratio` AS `ratio`,`order_cat_recut_doc_mix`.`p_xs` AS `p_xs`,`order_cat_recut_doc_mix`.`p_s` AS `p_s`,`order_cat_recut_doc_mix`.`p_m` AS `p_m`,`order_cat_recut_doc_mix`.`p_l` AS `p_l`,`order_cat_recut_doc_mix`.`p_xl` AS `p_xl`,`order_cat_recut_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_recut_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_recut_doc_mix`.`p_plies` AS `p_plies`,`order_cat_recut_doc_mix`.`doc_no` AS `doc_no`,`order_cat_recut_doc_mix`.`acutno` AS `acutno`,`order_cat_recut_doc_mix`.`a_xs` AS `a_xs`,`order_cat_recut_doc_mix`.`a_s` AS `a_s`,`order_cat_recut_doc_mix`.`a_m` AS `a_m`,`order_cat_recut_doc_mix`.`a_l` AS `a_l`,`order_cat_recut_doc_mix`.`a_xl` AS `a_xl`,`order_cat_recut_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_recut_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_recut_doc_mix`.`a_plies` AS `a_plies`,`order_cat_recut_doc_mix`.`lastup` AS `lastup`,`order_cat_recut_doc_mix`.`remarks` AS `remarks`,`order_cat_recut_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_recut_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_recut_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_recut_doc_mix`.`print_status` AS `print_status`,`order_cat_recut_doc_mix`.`a_s01` AS `a_s01`,`order_cat_recut_doc_mix`.`a_s02` AS `a_s02`,`order_cat_recut_doc_mix`.`a_s03` AS `a_s03`,`order_cat_recut_doc_mix`.`a_s04` AS `a_s04`,`order_cat_recut_doc_mix`.`a_s05` AS `a_s05`,`order_cat_recut_doc_mix`.`a_s06` AS `a_s06`,`order_cat_recut_doc_mix`.`a_s07` AS `a_s07`,`order_cat_recut_doc_mix`.`a_s08` AS `a_s08`,`order_cat_recut_doc_mix`.`a_s09` AS `a_s09`,`order_cat_recut_doc_mix`.`a_s10` AS `a_s10`,`order_cat_recut_doc_mix`.`a_s11` AS `a_s11`,`order_cat_recut_doc_mix`.`a_s12` AS `a_s12`,`order_cat_recut_doc_mix`.`a_s13` AS `a_s13`,`order_cat_recut_doc_mix`.`a_s14` AS `a_s14`,`order_cat_recut_doc_mix`.`a_s15` AS `a_s15`,`order_cat_recut_doc_mix`.`a_s16` AS `a_s16`,`order_cat_recut_doc_mix`.`a_s17` AS `a_s17`,`order_cat_recut_doc_mix`.`a_s18` AS `a_s18`,`order_cat_recut_doc_mix`.`a_s19` AS `a_s19`,`order_cat_recut_doc_mix`.`a_s20` AS `a_s20`,`order_cat_recut_doc_mix`.`a_s21` AS `a_s21`,`order_cat_recut_doc_mix`.`a_s22` AS `a_s22`,`order_cat_recut_doc_mix`.`a_s23` AS `a_s23`,`order_cat_recut_doc_mix`.`a_s24` AS `a_s24`,`order_cat_recut_doc_mix`.`a_s25` AS `a_s25`,`order_cat_recut_doc_mix`.`a_s26` AS `a_s26`,`order_cat_recut_doc_mix`.`a_s27` AS `a_s27`,`order_cat_recut_doc_mix`.`a_s28` AS `a_s28`,`order_cat_recut_doc_mix`.`a_s29` AS `a_s29`,`order_cat_recut_doc_mix`.`a_s30` AS `a_s30`,`order_cat_recut_doc_mix`.`a_s31` AS `a_s31`,`order_cat_recut_doc_mix`.`a_s32` AS `a_s32`,`order_cat_recut_doc_mix`.`a_s33` AS `a_s33`,`order_cat_recut_doc_mix`.`a_s34` AS `a_s34`,`order_cat_recut_doc_mix`.`a_s35` AS `a_s35`,`order_cat_recut_doc_mix`.`a_s36` AS `a_s36`,`order_cat_recut_doc_mix`.`a_s37` AS `a_s37`,`order_cat_recut_doc_mix`.`a_s38` AS `a_s38`,`order_cat_recut_doc_mix`.`a_s39` AS `a_s39`,`order_cat_recut_doc_mix`.`a_s40` AS `a_s40`,`order_cat_recut_doc_mix`.`a_s41` AS `a_s41`,`order_cat_recut_doc_mix`.`a_s42` AS `a_s42`,`order_cat_recut_doc_mix`.`a_s43` AS `a_s43`,`order_cat_recut_doc_mix`.`a_s44` AS `a_s44`,`order_cat_recut_doc_mix`.`a_s45` AS `a_s45`,`order_cat_recut_doc_mix`.`a_s46` AS `a_s46`,`order_cat_recut_doc_mix`.`a_s47` AS `a_s47`,`order_cat_recut_doc_mix`.`a_s48` AS `a_s48`,`order_cat_recut_doc_mix`.`a_s49` AS `a_s49`,`order_cat_recut_doc_mix`.`a_s50` AS `a_s50`,`order_cat_recut_doc_mix`.`p_s01` AS `p_s01`,`order_cat_recut_doc_mix`.`p_s02` AS `p_s02`,`order_cat_recut_doc_mix`.`p_s03` AS `p_s03`,`order_cat_recut_doc_mix`.`p_s04` AS `p_s04`,`order_cat_recut_doc_mix`.`p_s05` AS `p_s05`,`order_cat_recut_doc_mix`.`p_s06` AS `p_s06`,`order_cat_recut_doc_mix`.`p_s07` AS `p_s07`,`order_cat_recut_doc_mix`.`p_s08` AS `p_s08`,`order_cat_recut_doc_mix`.`p_s09` AS `p_s09`,`order_cat_recut_doc_mix`.`p_s10` AS `p_s10`,`order_cat_recut_doc_mix`.`p_s11` AS `p_s11`,`order_cat_recut_doc_mix`.`p_s12` AS `p_s12`,`order_cat_recut_doc_mix`.`p_s13` AS `p_s13`,`order_cat_recut_doc_mix`.`p_s14` AS `p_s14`,`order_cat_recut_doc_mix`.`p_s15` AS `p_s15`,`order_cat_recut_doc_mix`.`p_s16` AS `p_s16`,`order_cat_recut_doc_mix`.`p_s17` AS `p_s17`,`order_cat_recut_doc_mix`.`p_s18` AS `p_s18`,`order_cat_recut_doc_mix`.`p_s19` AS `p_s19`,`order_cat_recut_doc_mix`.`p_s20` AS `p_s20`,`order_cat_recut_doc_mix`.`p_s21` AS `p_s21`,`order_cat_recut_doc_mix`.`p_s22` AS `p_s22`,`order_cat_recut_doc_mix`.`p_s23` AS `p_s23`,`order_cat_recut_doc_mix`.`p_s24` AS `p_s24`,`order_cat_recut_doc_mix`.`p_s25` AS `p_s25`,`order_cat_recut_doc_mix`.`p_s26` AS `p_s26`,`order_cat_recut_doc_mix`.`p_s27` AS `p_s27`,`order_cat_recut_doc_mix`.`p_s28` AS `p_s28`,`order_cat_recut_doc_mix`.`p_s29` AS `p_s29`,`order_cat_recut_doc_mix`.`p_s30` AS `p_s30`,`order_cat_recut_doc_mix`.`p_s31` AS `p_s31`,`order_cat_recut_doc_mix`.`p_s32` AS `p_s32`,`order_cat_recut_doc_mix`.`p_s33` AS `p_s33`,`order_cat_recut_doc_mix`.`p_s34` AS `p_s34`,`order_cat_recut_doc_mix`.`p_s35` AS `p_s35`,`order_cat_recut_doc_mix`.`p_s36` AS `p_s36`,`order_cat_recut_doc_mix`.`p_s37` AS `p_s37`,`order_cat_recut_doc_mix`.`p_s38` AS `p_s38`,`order_cat_recut_doc_mix`.`p_s39` AS `p_s39`,`order_cat_recut_doc_mix`.`p_s40` AS `p_s40`,`order_cat_recut_doc_mix`.`p_s41` AS `p_s41`,`order_cat_recut_doc_mix`.`p_s42` AS `p_s42`,`order_cat_recut_doc_mix`.`p_s43` AS `p_s43`,`order_cat_recut_doc_mix`.`p_s44` AS `p_s44`,`order_cat_recut_doc_mix`.`p_s45` AS `p_s45`,`order_cat_recut_doc_mix`.`p_s46` AS `p_s46`,`order_cat_recut_doc_mix`.`p_s47` AS `p_s47`,`order_cat_recut_doc_mix`.`p_s48` AS `p_s48`,`order_cat_recut_doc_mix`.`p_s49` AS `p_s49`,`order_cat_recut_doc_mix`.`p_s50` AS `p_s50`,`order_cat_recut_doc_mix`.`rm_date` AS `rm_date`,`order_cat_recut_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_recut_doc_mix`.`plan_module` AS `plan_module`,`order_cat_recut_doc_mix`.`category` AS `category`,`order_cat_recut_doc_mix`.`color_code` AS `color_code`,`order_cat_recut_doc_mix`.`fabric_status` AS `fabric_status`,if(`order_cat_recut_doc_mix`.`category` = 'Body' or `order_cat_recut_doc_mix`.`category` = 'Front',round(`order_cat_recut_doc_mix`.`a_plies` * `maker_stat_log`.`mklength`,2) + (`order_cat_recut_doc_mix`.`a_xs` + `order_cat_recut_doc_mix`.`a_s` + `order_cat_recut_doc_mix`.`a_m` + `order_cat_recut_doc_mix`.`a_l` + `order_cat_recut_doc_mix`.`a_xl` + `order_cat_recut_doc_mix`.`a_xxl` + `order_cat_recut_doc_mix`.`a_xxxl` + `order_cat_recut_doc_mix`.`a_s01` + `order_cat_recut_doc_mix`.`a_s02` + `order_cat_recut_doc_mix`.`a_s03` + `order_cat_recut_doc_mix`.`a_s04` + `order_cat_recut_doc_mix`.`a_s05` + `order_cat_recut_doc_mix`.`a_s06` + `order_cat_recut_doc_mix`.`a_s07` + `order_cat_recut_doc_mix`.`a_s08` + `order_cat_recut_doc_mix`.`a_s09` + `order_cat_recut_doc_mix`.`a_s10` + `order_cat_recut_doc_mix`.`a_s11` + `order_cat_recut_doc_mix`.`a_s12` + `order_cat_recut_doc_mix`.`a_s13` + `order_cat_recut_doc_mix`.`a_s14` + `order_cat_recut_doc_mix`.`a_s15` + `order_cat_recut_doc_mix`.`a_s16` + `order_cat_recut_doc_mix`.`a_s17` + `order_cat_recut_doc_mix`.`a_s18` + `order_cat_recut_doc_mix`.`a_s19` + `order_cat_recut_doc_mix`.`a_s20` + `order_cat_recut_doc_mix`.`a_s21` + `order_cat_recut_doc_mix`.`a_s22` + `order_cat_recut_doc_mix`.`a_s23` + `order_cat_recut_doc_mix`.`a_s24` + `order_cat_recut_doc_mix`.`a_s25` + `order_cat_recut_doc_mix`.`a_s26` + `order_cat_recut_doc_mix`.`a_s27` + `order_cat_recut_doc_mix`.`a_s28` + `order_cat_recut_doc_mix`.`a_s29` + `order_cat_recut_doc_mix`.`a_s30` + `order_cat_recut_doc_mix`.`a_s31` + `order_cat_recut_doc_mix`.`a_s32` + `order_cat_recut_doc_mix`.`a_s33` + `order_cat_recut_doc_mix`.`a_s34` + `order_cat_recut_doc_mix`.`a_s35` + `order_cat_recut_doc_mix`.`a_s36` + `order_cat_recut_doc_mix`.`a_s37` + `order_cat_recut_doc_mix`.`a_s38` + `order_cat_recut_doc_mix`.`a_s39` + `order_cat_recut_doc_mix`.`a_s40` + `order_cat_recut_doc_mix`.`a_s41` + `order_cat_recut_doc_mix`.`a_s42` + `order_cat_recut_doc_mix`.`a_s43` + `order_cat_recut_doc_mix`.`a_s44` + `order_cat_recut_doc_mix`.`a_s45` + `order_cat_recut_doc_mix`.`a_s46` + `order_cat_recut_doc_mix`.`a_s47` + `order_cat_recut_doc_mix`.`a_s48` + `order_cat_recut_doc_mix`.`a_s49` + `order_cat_recut_doc_mix`.`a_s50`) * `order_cat_recut_doc_mix`.`a_plies` * `fn_know_binding_con`(`maker_stat_log`.`order_tid`),round(`order_cat_recut_doc_mix`.`a_plies` * `maker_stat_log`.`mklength`,2)) AS `material_req`,`order_cat_recut_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_recut_doc_mix`.`plan_lot_ref` AS `plan_lot_ref` from (`order_cat_recut_doc_mix` left join `maker_stat_log` on(`order_cat_recut_doc_mix`.`mk_ref` = `maker_stat_log`.`tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pac_stat_log_for_live` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,sum(`pac_stat_log`.`carton_act_qty`) AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des` from ((`pac_stat_log` left join `plandoc_stat_log` on(`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)) group by `pac_stat_log`.`doc_no_ref`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `pack_to_be_backup` AS (select `disp_tb1`.`total` AS `total`,`disp_tb1`.`order_del_no` AS `order_del_no`,`disp_tb1`.`scanned` AS `scanned`,`disp_tb1`.`unscanned` AS `unscanned`,`disp_tb1`.`lable_ids` AS `lable_ids`,`disp_db`.`create_date` AS `create_date`,`ship_stat_log`.`ship_s_xs` + `ship_stat_log`.`ship_s_s` + `ship_stat_log`.`ship_s_m` + `ship_stat_log`.`ship_s_l` + `ship_stat_log`.`ship_s_xl` + `ship_stat_log`.`ship_s_xxl` + `ship_stat_log`.`ship_s_xxxl` + `ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08` + `ship_stat_log`.`ship_s_s10` + `ship_stat_log`.`ship_s_s12` + `ship_stat_log`.`ship_s_s14` + `ship_stat_log`.`ship_s_s16` + `ship_stat_log`.`ship_s_s18` + `ship_stat_log`.`ship_s_s20` + `ship_stat_log`.`ship_s_s22` + `ship_stat_log`.`ship_s_s24` + `ship_stat_log`.`ship_s_s26` + `ship_stat_log`.`ship_s_s28` + `ship_stat_log`.`ship_s_s30` AS `ship_qty` from ((`ship_stat_log` left join `disp_tb1` on(`disp_tb1`.`order_del_no` = `ship_stat_log`.`ship_schedule`)) left join `disp_db` on(`disp_db`.`disp_note_no` = `ship_stat_log`.`disp_note_no`)) where `ship_stat_log`.`disp_note_no` is not null and `disp_tb1`.`unscanned` = 0 and `disp_tb1`.`total` = `ship_stat_log`.`ship_s_xs` + `ship_stat_log`.`ship_s_s` + `ship_stat_log`.`ship_s_m` + `ship_stat_log`.`ship_s_l` + `ship_stat_log`.`ship_s_xl` + `ship_stat_log`.`ship_s_xxl` + `ship_stat_log`.`ship_s_xxxl` + `ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08` + `ship_stat_log`.`ship_s_s10` + `ship_stat_log`.`ship_s_s12` + `ship_stat_log`.`ship_s_s14` + `ship_stat_log`.`ship_s_s16` + `ship_stat_log`.`ship_s_s18` + `ship_stat_log`.`ship_s_s20` + `ship_stat_log`.`ship_s_s22` + `ship_stat_log`.`ship_s_s24` + `ship_stat_log`.`ship_s_s26` + `ship_stat_log`.`ship_s_s28` + `ship_stat_log`.`ship_s_s30`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard` AS (select min(`pac_stat_log_temp`.`tid`) AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,`pac_stat_log_temp`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where `pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no` and `pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','') and `pac_stat_log_temp`.`disp_carton_no` >= 1 and `ims_log_backup`.`ims_mod_no` <> 0 and `pac_stat_log_temp`.`status` is null group by `pac_stat_log_temp`.`doc_no_ref`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard_new` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,`ims_log_backup`.`ims_qty` AS `ims_qty`,`ims_log_backup`.`ims_pro_qty` AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty_cumm` from `ims_log_backup` where `ims_log_backup`.`ims_mod_no` <> 0 and `ims_log_backup`.`ims_schedule` in (select `packing_pending_schedules`.`order_del_no` AS `order_del_no` from `packing_pending_schedules`) group by `ims_log_backup`.`ims_schedule`,`ims_log_backup`.`ims_size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dashboard_new2` AS (select `ims_log_backup`.`ims_date` AS `ims_date`,`ims_log_backup`.`ims_cid` AS `ims_cid`,`ims_log_backup`.`ims_doc_no` AS `ims_doc_no`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,`ims_log_backup`.`ims_shift` AS `ims_shift`,`ims_log_backup`.`ims_size` AS `ims_size`,sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_status` AS `ims_status`,`ims_log_backup`.`bai_pro_ref` AS `bai_pro_ref`,`ims_log_backup`.`ims_log_date` AS `ims_log_date`,`ims_log_backup`.`ims_remarks` AS `ims_remarks`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,`ims_log_backup`.`tid` AS `tid`,`ims_log_backup`.`rand_track` AS `rand_track`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty_cumm` from `ims_log_backup` where `ims_log_backup`.`ims_mod_no` <> 0 and `ims_log_backup`.`ims_schedule` in (select `packing_pending_schedules`.`order_del_no` AS `order_del_no` from `packing_pending_schedules`) group by `ims_log_backup`.`ims_doc_no`,`ims_log_backup`.`ims_size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_dboard_stage1` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,if(`pac_stat_log`.`status` = 'DONE',`pac_stat_log`.`carton_act_qty`,0) AS `new` from ((`pac_stat_log` left join `plandoc_stat_log` on(`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_issues` AS (select `pac_stat_log_temp`.`tid` AS `tid`,`pac_stat_log_temp`.`doc_no` AS `doc_no`,`pac_stat_log_temp`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_temp`.`size_code` AS `size_code`,`pac_stat_log_temp`.`carton_no` AS `carton_no`,`pac_stat_log_temp`.`carton_mode` AS `carton_mode`,round(sum(`pac_stat_log_temp`.`carton_act_qty`) / count(`ims_log_backup`.`ims_doc_no`),0) AS `carton_act_qty`,`pac_stat_log_temp`.`status` AS `status`,`pac_stat_log_temp`.`lastup` AS `lastup`,`pac_stat_log_temp`.`remarks` AS `remarks`,`pac_stat_log_temp`.`disp_id` AS `disp_id`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,min(`ims_log_backup`.`ims_date`) AS `input_date`,sum(`ims_log_backup`.`ims_pro_qty`) AS `ims_pro_qty`,`ims_log_backup`.`ims_mod_no` AS `ims_mod_no`,max(`ims_log_backup`.`ims_log_date`) AS `ims_log_date` from (`pac_stat_log_temp` join `ims_log_backup`) where `pac_stat_log_temp`.`doc_no` = `ims_log_backup`.`ims_doc_no` and `pac_stat_log_temp`.`size_code` = replace(`ims_log_backup`.`ims_size`,'a_','') and `ims_log_backup`.`ims_mod_no` <> 0 and `pac_stat_log_temp`.`status` is null and `pac_stat_log_temp`.`disp_id` = 1 group by `pac_stat_log_temp`.`doc_no_ref`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_pending_schedules` AS (select distinct `packing_summary`.`order_del_no` AS `order_del_no` from `packing_summary` where `packing_summary`.`status` <> 'DONE' or `packing_summary`.`status` is null)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno` from ((`pac_stat_log` left join `plandoc_stat_log` on(`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_backup` AS (select `pac_stat_log_backup`.`doc_no` AS `doc_no`,`pac_stat_log_backup`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_backup`.`tid` AS `tid`,`pac_stat_log_backup`.`size_code` AS `size_code`,`pac_stat_log_backup`.`remarks` AS `remarks`,`pac_stat_log_backup`.`status` AS `status`,`pac_stat_log_backup`.`lastup` AS `lastup`,`pac_stat_log_backup`.`container` AS `container`,`pac_stat_log_backup`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log_backup`.`disp_id` AS `disp_id`,`pac_stat_log_backup`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_backup`.`audit_status` AS `audit_status`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno` from ((`pac_stat_log_backup` left join `plandoc_stat_log` on(`pac_stat_log_backup`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db` on(`bai_orders_db`.`order_tid` = `plandoc_stat_log`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_input` AS select `bai_orders_db_confirm`.`order_joins` AS `order_joins`,`pac_stat_log_input_job`.`doc_no` AS `doc_no`,`pac_stat_log_input_job`.`input_job_no` AS `input_job_no`,`pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,`pac_stat_log_input_job`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log_input_job`.`tid` AS `tid`,ucase(`pac_stat_log_input_job`.`size_code`) AS `size_code`,`pac_stat_log_input_job`.`status` AS `STATUS`,`pac_stat_log_input_job`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log_input_job`.`packing_mode` AS `packing_mode`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`plandoc_stat_log`.`acutno` AS `acutno`,`bai_orders_db_confirm`.`destination` AS `destination`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,ucase(`pac_stat_log_input_job`.`size_code`) AS `m3_size_code`,`pac_stat_log_input_job`.`old_size` AS `old_size`,`pac_stat_log_input_job`.`type_of_sewing` AS `type_of_sewing`,`pac_stat_log_input_job`.`doc_type` AS `doc_type`,`pac_stat_log_input_job`.`pac_seq_no` AS `pac_seq_no`,`pac_stat_log_input_job`.`sref_id` AS `sref_id`,`pac_stat_log_input_job`.`barcode_sequence` AS `barcode_sequence` from ((`pac_stat_log_input_job` left join `plandoc_stat_log` on(`pac_stat_log_input_job`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `packing_summary_temp` AS (select `pac_stat_log`.`doc_no` AS `doc_no`,`pac_stat_log`.`doc_no_ref` AS `doc_no_ref`,`pac_stat_log`.`tid` AS `tid`,`pac_stat_log`.`size_code` AS `size_code`,`pac_stat_log`.`remarks` AS `remarks`,`pac_stat_log`.`status` AS `status`,`pac_stat_log`.`lastup` AS `lastup`,`pac_stat_log`.`container` AS `container`,`pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,`pac_stat_log`.`disp_id` AS `disp_id`,`pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,`pac_stat_log`.`audit_status` AS `audit_status`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des` from ((`pac_stat_log` left join `plandoc_stat_log` on(`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`)) left join `bai_orders_db_confirm` on(`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_doc_summ` AS (select `plan_dash_summ`.`print_status` AS `print_status`,`plan_dash_summ`.`plan_lot_ref` AS `plan_lot_ref`,`plan_dash_summ`.`bundle_location` AS `bundle_location`,`plan_dash_summ`.`fabric_status_new` AS `fabric_status_new`,`plan_dash_summ`.`doc_no` AS `doc_no`,`plan_dash_summ`.`module` AS `module`,`plan_dash_summ`.`priority` AS `priority`,`plan_dash_summ`.`act_cut_issue_status` AS `act_cut_issue_status`,`plan_dash_summ`.`act_cut_status` AS `act_cut_status`,`plan_dash_summ`.`rm_date` AS `rm_date`,`plan_dash_summ`.`cut_inp_temp` AS `cut_inp_temp`,`plan_dash_summ`.`order_tid` AS `order_tid`,`plan_dash_summ`.`fabric_status` AS `fabric_status`,`plan_doc_summ`.`color_code` AS `color_code`,`plan_doc_summ`.`clubbing` AS `clubbing`,`plan_doc_summ`.`order_style_no` AS `order_style_no`,`plan_doc_summ`.`order_div` AS `order_div`,`plan_doc_summ`.`order_col_des` AS `order_col_des`,`plan_doc_summ`.`acutno` AS `acutno`,`plan_doc_summ`.`ft_status` AS `ft_status`,`plan_doc_summ`.`st_status` AS `st_status`,`plan_doc_summ`.`pt_status` AS `pt_status`,`plan_doc_summ`.`trim_status` AS `trim_status`,`plan_dash_summ`.`xs` AS `xs`,`plan_dash_summ`.`s` AS `s`,`plan_dash_summ`.`m` AS `m`,`plan_dash_summ`.`l` AS `l`,`plan_dash_summ`.`xl` AS `xl`,`plan_dash_summ`.`xxl` AS `xxl`,`plan_dash_summ`.`xxxl` AS `xxxl`,`plan_dash_summ`.`s01` AS `s01`,`plan_dash_summ`.`s02` AS `s02`,`plan_dash_summ`.`s03` AS `s03`,`plan_dash_summ`.`s04` AS `s04`,`plan_dash_summ`.`s05` AS `s05`,`plan_dash_summ`.`s06` AS `s06`,`plan_dash_summ`.`s07` AS `s07`,`plan_dash_summ`.`s08` AS `s08`,`plan_dash_summ`.`s09` AS `s09`,`plan_dash_summ`.`s10` AS `s10`,`plan_dash_summ`.`s11` AS `s11`,`plan_dash_summ`.`s12` AS `s12`,`plan_dash_summ`.`s13` AS `s13`,`plan_dash_summ`.`s14` AS `s14`,`plan_dash_summ`.`s15` AS `s15`,`plan_dash_summ`.`s16` AS `s16`,`plan_dash_summ`.`s17` AS `s17`,`plan_dash_summ`.`s18` AS `s18`,`plan_dash_summ`.`s19` AS `s19`,`plan_dash_summ`.`s20` AS `s20`,`plan_dash_summ`.`s21` AS `s21`,`plan_dash_summ`.`s22` AS `s22`,`plan_dash_summ`.`s23` AS `s23`,`plan_dash_summ`.`s24` AS `s24`,`plan_dash_summ`.`s25` AS `s25`,`plan_dash_summ`.`s26` AS `s26`,`plan_dash_summ`.`s27` AS `s27`,`plan_dash_summ`.`s28` AS `s28`,`plan_dash_summ`.`s29` AS `s29`,`plan_dash_summ`.`s30` AS `s30`,`plan_dash_summ`.`s31` AS `s31`,`plan_dash_summ`.`s32` AS `s32`,`plan_dash_summ`.`s33` AS `s33`,`plan_dash_summ`.`s34` AS `s34`,`plan_dash_summ`.`s35` AS `s35`,`plan_dash_summ`.`s36` AS `s36`,`plan_dash_summ`.`s37` AS `s37`,`plan_dash_summ`.`s38` AS `s38`,`plan_dash_summ`.`s39` AS `s39`,`plan_dash_summ`.`s40` AS `s40`,`plan_dash_summ`.`s41` AS `s41`,`plan_dash_summ`.`s42` AS `s42`,`plan_dash_summ`.`s43` AS `s43`,`plan_dash_summ`.`s44` AS `s44`,`plan_dash_summ`.`s45` AS `s45`,`plan_dash_summ`.`s46` AS `s46`,`plan_dash_summ`.`s47` AS `s47`,`plan_dash_summ`.`s48` AS `s48`,`plan_dash_summ`.`s49` AS `s49`,`plan_dash_summ`.`s50` AS `s50`,`plan_dash_summ`.`a_plies` AS `a_plies`,`plan_dash_summ`.`p_plies` AS `p_plies`,`plan_dash_summ`.`mk_ref` AS `mk_ref`,`plan_dash_summ`.`xs` + `plan_dash_summ`.`s` + `plan_dash_summ`.`m` + `plan_dash_summ`.`l` + `plan_dash_summ`.`xl` + `plan_dash_summ`.`xxl` + `plan_dash_summ`.`xxxl` + `plan_dash_summ`.`s01` + `plan_dash_summ`.`s02` + `plan_dash_summ`.`s03` + `plan_dash_summ`.`s04` + `plan_dash_summ`.`s05` + `plan_dash_summ`.`s06` + `plan_dash_summ`.`s07` + `plan_dash_summ`.`s08` + `plan_dash_summ`.`s09` + `plan_dash_summ`.`s10` + `plan_dash_summ`.`s11` + `plan_dash_summ`.`s12` + `plan_dash_summ`.`s13` + `plan_dash_summ`.`s14` + `plan_dash_summ`.`s15` + `plan_dash_summ`.`s16` + `plan_dash_summ`.`s17` + `plan_dash_summ`.`s18` + `plan_dash_summ`.`s19` + `plan_dash_summ`.`s20` + `plan_dash_summ`.`s21` + `plan_dash_summ`.`s22` + `plan_dash_summ`.`s23` + `plan_dash_summ`.`s24` + `plan_dash_summ`.`s25` + `plan_dash_summ`.`s26` + `plan_dash_summ`.`s27` + `plan_dash_summ`.`s28` + `plan_dash_summ`.`s29` + `plan_dash_summ`.`s30` + `plan_dash_summ`.`s31` + `plan_dash_summ`.`s32` + `plan_dash_summ`.`s33` + `plan_dash_summ`.`s34` + `plan_dash_summ`.`s35` + `plan_dash_summ`.`s36` + `plan_dash_summ`.`s37` + `plan_dash_summ`.`s38` + `plan_dash_summ`.`s39` + `plan_dash_summ`.`s40` + `plan_dash_summ`.`s41` + `plan_dash_summ`.`s42` + `plan_dash_summ`.`s43` + `plan_dash_summ`.`s44` + `plan_dash_summ`.`s45` + `plan_dash_summ`.`s46` + `plan_dash_summ`.`s47` + `plan_dash_summ`.`s48` + `plan_dash_summ`.`s49` + `plan_dash_summ`.`s50` AS `total`,`plan_doc_summ`.`act_movement_status` AS `act_movement_status`,`plan_doc_summ`.`order_del_no` AS `order_del_no`,`plan_dash_summ`.`log_time` AS `log_time`,`plan_doc_summ`.`emb_stat1` AS `emb_stat`,`plan_doc_summ`.`cat_ref` AS `cat_ref` from (`plan_dash_summ` left join `plan_doc_summ` on(`plan_doc_summ`.`doc_no` = `plan_dash_summ`.`doc_no`)))$$
DELIMITER ;

 DROP TABLE IF EXISTS `plan_dash_doc_summ_embl`;
/*  Create View in target  */

DELIMITER $$
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_doc_summ_embl` AS (select `plan_dash_summ_embl`.`print_status` AS `print_status`,`plan_dash_summ_embl`.`plan_lot_ref` AS `plan_lot_ref`,`plan_dash_summ_embl`.`bundle_location` AS `bundle_location`,`plan_dash_summ_embl`.`fabric_status_new` AS `fabric_status_new`,`plan_dash_summ_embl`.`doc_no` AS `doc_no`,`plan_dash_summ_embl`.`module` AS `module`,`plan_dash_summ_embl`.`priority` AS `priority`,`plan_dash_summ_embl`.`act_cut_issue_status` AS `act_cut_issue_status`,`plan_dash_summ_embl`.`act_cut_status` AS `act_cut_status`,`plan_dash_summ_embl`.`rm_date` AS `rm_date`,`plan_dash_summ_embl`.`cut_inp_temp` AS `cut_inp_temp`,`plan_dash_summ_embl`.`order_tid` AS `order_tid`,`plan_dash_summ_embl`.`fabric_status` AS `fabric_status`,`plan_doc_summ`.`color_code` AS `color_code`,`plan_doc_summ`.`clubbing` AS `clubbing`,`plan_doc_summ`.`order_style_no` AS `order_style_no`,`plan_doc_summ`.`order_div` AS `order_div`,`plan_doc_summ`.`order_col_des` AS `order_col_des`,`plan_doc_summ`.`acutno` AS `acutno`,`plan_doc_summ`.`ft_status` AS `ft_status`,`plan_doc_summ`.`st_status` AS `st_status`,`plan_doc_summ`.`pt_status` AS `pt_status`,`plan_doc_summ`.`trim_status` AS `trim_status`,`plan_dash_summ_embl`.`xs` AS `xs`,`plan_dash_summ_embl`.`s` AS `s`,`plan_dash_summ_embl`.`m` AS `m`,`plan_dash_summ_embl`.`l` AS `l`,`plan_dash_summ_embl`.`xl` AS `xl`,`plan_dash_summ_embl`.`xxl` AS `xxl`,`plan_dash_summ_embl`.`xxxl` AS `xxxl`,`plan_dash_summ_embl`.`s01` AS `s01`,`plan_dash_summ_embl`.`s02` AS `s02`,`plan_dash_summ_embl`.`s03` AS `s03`,`plan_dash_summ_embl`.`s04` AS `s04`,`plan_dash_summ_embl`.`s05` AS `s05`,`plan_dash_summ_embl`.`s06` AS `s06`,`plan_dash_summ_embl`.`s07` AS `s07`,`plan_dash_summ_embl`.`s08` AS `s08`,`plan_dash_summ_embl`.`s09` AS `s09`,`plan_dash_summ_embl`.`s10` AS `s10`,`plan_dash_summ_embl`.`s11` AS `s11`,`plan_dash_summ_embl`.`s12` AS `s12`,`plan_dash_summ_embl`.`s13` AS `s13`,`plan_dash_summ_embl`.`s14` AS `s14`,`plan_dash_summ_embl`.`s15` AS `s15`,`plan_dash_summ_embl`.`s16` AS `s16`,`plan_dash_summ_embl`.`s17` AS `s17`,`plan_dash_summ_embl`.`s18` AS `s18`,`plan_dash_summ_embl`.`s19` AS `s19`,`plan_dash_summ_embl`.`s20` AS `s20`,`plan_dash_summ_embl`.`s21` AS `s21`,`plan_dash_summ_embl`.`s22` AS `s22`,`plan_dash_summ_embl`.`s23` AS `s23`,`plan_dash_summ_embl`.`s24` AS `s24`,`plan_dash_summ_embl`.`s25` AS `s25`,`plan_dash_summ_embl`.`s26` AS `s26`,`plan_dash_summ_embl`.`s27` AS `s27`,`plan_dash_summ_embl`.`s28` AS `s28`,`plan_dash_summ_embl`.`s29` AS `s29`,`plan_dash_summ_embl`.`s30` AS `s30`,`plan_dash_summ_embl`.`s31` AS `s31`,`plan_dash_summ_embl`.`s32` AS `s32`,`plan_dash_summ_embl`.`s33` AS `s33`,`plan_dash_summ_embl`.`s34` AS `s34`,`plan_dash_summ_embl`.`s35` AS `s35`,`plan_dash_summ_embl`.`s36` AS `s36`,`plan_dash_summ_embl`.`s37` AS `s37`,`plan_dash_summ_embl`.`s38` AS `s38`,`plan_dash_summ_embl`.`s39` AS `s39`,`plan_dash_summ_embl`.`s40` AS `s40`,`plan_dash_summ_embl`.`s41` AS `s41`,`plan_dash_summ_embl`.`s42` AS `s42`,`plan_dash_summ_embl`.`s43` AS `s43`,`plan_dash_summ_embl`.`s44` AS `s44`,`plan_dash_summ_embl`.`s45` AS `s45`,`plan_dash_summ_embl`.`s46` AS `s46`,`plan_dash_summ_embl`.`s47` AS `s47`,`plan_dash_summ_embl`.`s48` AS `s48`,`plan_dash_summ_embl`.`s49` AS `s49`,`plan_dash_summ_embl`.`s50` AS `s50`,`plan_dash_summ_embl`.`a_plies` AS `a_plies`,`plan_dash_summ_embl`.`p_plies` AS `p_plies`,`plan_dash_summ_embl`.`mk_ref` AS `mk_ref`,`plan_dash_summ_embl`.`xs` + `plan_dash_summ_embl`.`s` + `plan_dash_summ_embl`.`m` + `plan_dash_summ_embl`.`l` + `plan_dash_summ_embl`.`xl` + `plan_dash_summ_embl`.`xxl` + `plan_dash_summ_embl`.`xxxl` + `plan_dash_summ_embl`.`s01` + `plan_dash_summ_embl`.`s02` + `plan_dash_summ_embl`.`s03` + `plan_dash_summ_embl`.`s04` + `plan_dash_summ_embl`.`s05` + `plan_dash_summ_embl`.`s06` + `plan_dash_summ_embl`.`s07` + `plan_dash_summ_embl`.`s08` + `plan_dash_summ_embl`.`s09` + `plan_dash_summ_embl`.`s10` + `plan_dash_summ_embl`.`s11` + `plan_dash_summ_embl`.`s12` + `plan_dash_summ_embl`.`s13` + `plan_dash_summ_embl`.`s14` + `plan_dash_summ_embl`.`s15` + `plan_dash_summ_embl`.`s16` + `plan_dash_summ_embl`.`s17` + `plan_dash_summ_embl`.`s18` + `plan_dash_summ_embl`.`s19` + `plan_dash_summ_embl`.`s20` + `plan_dash_summ_embl`.`s21` + `plan_dash_summ_embl`.`s22` + `plan_dash_summ_embl`.`s23` + `plan_dash_summ_embl`.`s24` + `plan_dash_summ_embl`.`s25` + `plan_dash_summ_embl`.`s26` + `plan_dash_summ_embl`.`s27` + `plan_dash_summ_embl`.`s28` + `plan_dash_summ_embl`.`s29` + `plan_dash_summ_embl`.`s30` + `plan_dash_summ_embl`.`s31` + `plan_dash_summ_embl`.`s32` + `plan_dash_summ_embl`.`s33` + `plan_dash_summ_embl`.`s34` + `plan_dash_summ_embl`.`s35` + `plan_dash_summ_embl`.`s36` + `plan_dash_summ_embl`.`s37` + `plan_dash_summ_embl`.`s38` + `plan_dash_summ_embl`.`s39` + `plan_dash_summ_embl`.`s40` + `plan_dash_summ_embl`.`s41` + `plan_dash_summ_embl`.`s42` + `plan_dash_summ_embl`.`s43` + `plan_dash_summ_embl`.`s44` + `plan_dash_summ_embl`.`s45` + `plan_dash_summ_embl`.`s46` + `plan_dash_summ_embl`.`s47` + `plan_dash_summ_embl`.`s48` + `plan_dash_summ_embl`.`s49` + `plan_dash_summ_embl`.`s50` AS `total`,`plan_doc_summ`.`act_movement_status` AS `act_movement_status`,`plan_doc_summ`.`order_del_no` AS `order_del_no`,`plan_dash_summ_embl`.`log_time` AS `log_time`,`plan_doc_summ`.`emb_stat1` AS `emb_stat`,`plan_doc_summ`.`cat_ref` AS `cat_ref` from (`plan_dash_summ_embl` left join `plan_doc_summ` on(`plan_doc_summ`.`doc_no` = `plan_dash_summ_embl`.`doc_no`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_doc_summ_input` AS (select `plan_dashboard_input`.`input_job_no_random_ref` AS `input_job_no_random_ref`,`plan_dashboard_input`.`input_module` AS `input_module`,`plan_dashboard_input`.`input_priority` AS `input_priority`,`plan_dashboard_input`.`input_trims_status` AS `input_trims_status`,`plan_dashboard_input`.`input_panel_status` AS `input_panel_status`,`plan_dashboard_input`.`log_time` AS `log_time`,`plan_dashboard_input`.`track_id` AS `track_id`,`plan_doc_summ_input`.`input_job_no` AS `input_job_no`,`plan_doc_summ_input`.`tid` AS `tid`,`plan_doc_summ_input`.`input_job_no_random` AS `input_job_no_random`,`plan_doc_summ_input`.`order_tid` AS `order_tid`,`plan_doc_summ_input`.`doc_no` AS `doc_no`,`plan_doc_summ_input`.`acutno` AS `acutno`,`plan_doc_summ_input`.`act_cut_status` AS `act_cut_status`,`plan_doc_summ_input`.`a_plies` AS `a_plies`,`plan_doc_summ_input`.`p_plies` AS `p_plies`,`plan_doc_summ_input`.`color_code` AS `color_code`,`plan_doc_summ_input`.`order_style_no` AS `order_style_no`,`plan_doc_summ_input`.`order_del_no` AS `order_del_no`,`plan_doc_summ_input`.`order_col_des` AS `order_col_des`,`plan_doc_summ_input`.`order_div` AS `order_div`,`plan_doc_summ_input`.`ft_status` AS `ft_status`,`plan_doc_summ_input`.`st_status` AS `st_status`,`plan_doc_summ_input`.`pt_status` AS `pt_status`,`plan_doc_summ_input`.`trim_status` AS `trim_status`,`plan_doc_summ_input`.`category` AS `category`,`plan_doc_summ_input`.`clubbing` AS `clubbing`,`plan_doc_summ_input`.`plan_module` AS `plan_module`,`plan_doc_summ_input`.`cat_ref` AS `cat_ref`,`plan_doc_summ_input`.`emb_stat1` AS `emb_stat1`,`plan_doc_summ_input`.`carton_act_qty` AS `carton_act_qty`,`plan_doc_summ_input`.`type_of_sewing` AS `type_of_sewing` from (`plan_dashboard_input` left join `plan_doc_summ_input` on(`plan_dashboard_input`.`input_job_no_random_ref` = `plan_doc_summ_input`.`input_job_no_random`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_summ` AS (select `plan_dashboard`.`doc_no` AS `doc_no`,`plan_dashboard`.`module` AS `module`,`plan_dashboard`.`priority` AS `priority`,`plan_dashboard`.`fabric_status` AS `fabric_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`plandoc_stat_log`.`pcutdocid` AS `bundle_location`,`plandoc_stat_log`.`print_status` AS `print_status`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`rm_date` AS `rm_date`,`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,`plandoc_stat_log`.`a_xs` * `plandoc_stat_log`.`a_plies` AS `xs`,`plandoc_stat_log`.`a_s` * `plandoc_stat_log`.`a_plies` AS `s`,`plandoc_stat_log`.`a_m` * `plandoc_stat_log`.`a_plies` AS `m`,`plandoc_stat_log`.`a_l` * `plandoc_stat_log`.`a_plies` AS `l`,`plandoc_stat_log`.`a_xl` * `plandoc_stat_log`.`a_plies` AS `xl`,`plandoc_stat_log`.`a_xxl` * `plandoc_stat_log`.`a_plies` AS `xxl`,`plandoc_stat_log`.`a_xxxl` * `plandoc_stat_log`.`a_plies` AS `xxxl`,`plandoc_stat_log`.`a_s01` * `plandoc_stat_log`.`a_plies` AS `s01`,`plandoc_stat_log`.`a_s02` * `plandoc_stat_log`.`a_plies` AS `s02`,`plandoc_stat_log`.`a_s03` * `plandoc_stat_log`.`a_plies` AS `s03`,`plandoc_stat_log`.`a_s04` * `plandoc_stat_log`.`a_plies` AS `s04`,`plandoc_stat_log`.`a_s05` * `plandoc_stat_log`.`a_plies` AS `s05`,`plandoc_stat_log`.`a_s06` * `plandoc_stat_log`.`a_plies` AS `s06`,`plandoc_stat_log`.`a_s07` * `plandoc_stat_log`.`a_plies` AS `s07`,`plandoc_stat_log`.`a_s08` * `plandoc_stat_log`.`a_plies` AS `s08`,`plandoc_stat_log`.`a_s09` * `plandoc_stat_log`.`a_plies` AS `s09`,`plandoc_stat_log`.`a_s10` * `plandoc_stat_log`.`a_plies` AS `s10`,`plandoc_stat_log`.`a_s11` * `plandoc_stat_log`.`a_plies` AS `s11`,`plandoc_stat_log`.`a_s12` * `plandoc_stat_log`.`a_plies` AS `s12`,`plandoc_stat_log`.`a_s13` * `plandoc_stat_log`.`a_plies` AS `s13`,`plandoc_stat_log`.`a_s14` * `plandoc_stat_log`.`a_plies` AS `s14`,`plandoc_stat_log`.`a_s15` * `plandoc_stat_log`.`a_plies` AS `s15`,`plandoc_stat_log`.`a_s16` * `plandoc_stat_log`.`a_plies` AS `s16`,`plandoc_stat_log`.`a_s17` * `plandoc_stat_log`.`a_plies` AS `s17`,`plandoc_stat_log`.`a_s18` * `plandoc_stat_log`.`a_plies` AS `s18`,`plandoc_stat_log`.`a_s19` * `plandoc_stat_log`.`a_plies` AS `s19`,`plandoc_stat_log`.`a_s20` * `plandoc_stat_log`.`a_plies` AS `s20`,`plandoc_stat_log`.`a_s21` * `plandoc_stat_log`.`a_plies` AS `s21`,`plandoc_stat_log`.`a_s22` * `plandoc_stat_log`.`a_plies` AS `s22`,`plandoc_stat_log`.`a_s23` * `plandoc_stat_log`.`a_plies` AS `s23`,`plandoc_stat_log`.`a_s24` * `plandoc_stat_log`.`a_plies` AS `s24`,`plandoc_stat_log`.`a_s25` * `plandoc_stat_log`.`a_plies` AS `s25`,`plandoc_stat_log`.`a_s26` * `plandoc_stat_log`.`a_plies` AS `s26`,`plandoc_stat_log`.`a_s27` * `plandoc_stat_log`.`a_plies` AS `s27`,`plandoc_stat_log`.`a_s28` * `plandoc_stat_log`.`a_plies` AS `s28`,`plandoc_stat_log`.`a_s29` * `plandoc_stat_log`.`a_plies` AS `s29`,`plandoc_stat_log`.`a_s30` * `plandoc_stat_log`.`a_plies` AS `s30`,`plandoc_stat_log`.`a_s31` * `plandoc_stat_log`.`a_plies` AS `s31`,`plandoc_stat_log`.`a_s32` * `plandoc_stat_log`.`a_plies` AS `s32`,`plandoc_stat_log`.`a_s33` * `plandoc_stat_log`.`a_plies` AS `s33`,`plandoc_stat_log`.`a_s34` * `plandoc_stat_log`.`a_plies` AS `s34`,`plandoc_stat_log`.`a_s35` * `plandoc_stat_log`.`a_plies` AS `s35`,`plandoc_stat_log`.`a_s36` * `plandoc_stat_log`.`a_plies` AS `s36`,`plandoc_stat_log`.`a_s37` * `plandoc_stat_log`.`a_plies` AS `s37`,`plandoc_stat_log`.`a_s38` * `plandoc_stat_log`.`a_plies` AS `s38`,`plandoc_stat_log`.`a_s39` * `plandoc_stat_log`.`a_plies` AS `s39`,`plandoc_stat_log`.`a_s40` * `plandoc_stat_log`.`a_plies` AS `s40`,`plandoc_stat_log`.`a_s41` * `plandoc_stat_log`.`a_plies` AS `s41`,`plandoc_stat_log`.`a_s42` * `plandoc_stat_log`.`a_plies` AS `s42`,`plandoc_stat_log`.`a_s43` * `plandoc_stat_log`.`a_plies` AS `s43`,`plandoc_stat_log`.`a_s44` * `plandoc_stat_log`.`a_plies` AS `s44`,`plandoc_stat_log`.`a_s45` * `plandoc_stat_log`.`a_plies` AS `s45`,`plandoc_stat_log`.`a_s46` * `plandoc_stat_log`.`a_plies` AS `s46`,`plandoc_stat_log`.`a_s47` * `plandoc_stat_log`.`a_plies` AS `s47`,`plandoc_stat_log`.`a_s48` * `plandoc_stat_log`.`a_plies` AS `s48`,`plandoc_stat_log`.`a_s49` * `plandoc_stat_log`.`a_plies` AS `s49`,`plandoc_stat_log`.`a_s50` * `plandoc_stat_log`.`a_plies` AS `s50`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`plan_dashboard`.`log_time` AS `log_time` from (`plan_dashboard` left join `plandoc_stat_log` on(`plan_dashboard`.`doc_no` = `plandoc_stat_log`.`doc_no`)) where `plandoc_stat_log`.`order_tid` is not null order by `plan_dashboard`.`priority`)$$
DELIMITER ;

/*  Create View in target  */

DELIMITER $$
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_dash_summ_embl` AS (select `embellishment_plan_dashboard`.`doc_no` AS `doc_no`,`embellishment_plan_dashboard`.`module` AS `module`,`embellishment_plan_dashboard`.`priority` AS `priority`,`embellishment_plan_dashboard`.`fabric_status` AS `fabric_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`plandoc_stat_log`.`pcutdocid` AS `bundle_location`,`plandoc_stat_log`.`print_status` AS `print_status`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`rm_date` AS `rm_date`,`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,`plandoc_stat_log`.`a_xs` * `plandoc_stat_log`.`a_plies` AS `xs`,`plandoc_stat_log`.`a_s` * `plandoc_stat_log`.`a_plies` AS `s`,`plandoc_stat_log`.`a_m` * `plandoc_stat_log`.`a_plies` AS `m`,`plandoc_stat_log`.`a_l` * `plandoc_stat_log`.`a_plies` AS `l`,`plandoc_stat_log`.`a_xl` * `plandoc_stat_log`.`a_plies` AS `xl`,`plandoc_stat_log`.`a_xxl` * `plandoc_stat_log`.`a_plies` AS `xxl`,`plandoc_stat_log`.`a_xxxl` * `plandoc_stat_log`.`a_plies` AS `xxxl`,`plandoc_stat_log`.`a_s01` * `plandoc_stat_log`.`a_plies` AS `s01`,`plandoc_stat_log`.`a_s02` * `plandoc_stat_log`.`a_plies` AS `s02`,`plandoc_stat_log`.`a_s03` * `plandoc_stat_log`.`a_plies` AS `s03`,`plandoc_stat_log`.`a_s04` * `plandoc_stat_log`.`a_plies` AS `s04`,`plandoc_stat_log`.`a_s05` * `plandoc_stat_log`.`a_plies` AS `s05`,`plandoc_stat_log`.`a_s06` * `plandoc_stat_log`.`a_plies` AS `s06`,`plandoc_stat_log`.`a_s07` * `plandoc_stat_log`.`a_plies` AS `s07`,`plandoc_stat_log`.`a_s08` * `plandoc_stat_log`.`a_plies` AS `s08`,`plandoc_stat_log`.`a_s09` * `plandoc_stat_log`.`a_plies` AS `s09`,`plandoc_stat_log`.`a_s10` * `plandoc_stat_log`.`a_plies` AS `s10`,`plandoc_stat_log`.`a_s11` * `plandoc_stat_log`.`a_plies` AS `s11`,`plandoc_stat_log`.`a_s12` * `plandoc_stat_log`.`a_plies` AS `s12`,`plandoc_stat_log`.`a_s13` * `plandoc_stat_log`.`a_plies` AS `s13`,`plandoc_stat_log`.`a_s14` * `plandoc_stat_log`.`a_plies` AS `s14`,`plandoc_stat_log`.`a_s15` * `plandoc_stat_log`.`a_plies` AS `s15`,`plandoc_stat_log`.`a_s16` * `plandoc_stat_log`.`a_plies` AS `s16`,`plandoc_stat_log`.`a_s17` * `plandoc_stat_log`.`a_plies` AS `s17`,`plandoc_stat_log`.`a_s18` * `plandoc_stat_log`.`a_plies` AS `s18`,`plandoc_stat_log`.`a_s19` * `plandoc_stat_log`.`a_plies` AS `s19`,`plandoc_stat_log`.`a_s20` * `plandoc_stat_log`.`a_plies` AS `s20`,`plandoc_stat_log`.`a_s21` * `plandoc_stat_log`.`a_plies` AS `s21`,`plandoc_stat_log`.`a_s22` * `plandoc_stat_log`.`a_plies` AS `s22`,`plandoc_stat_log`.`a_s23` * `plandoc_stat_log`.`a_plies` AS `s23`,`plandoc_stat_log`.`a_s24` * `plandoc_stat_log`.`a_plies` AS `s24`,`plandoc_stat_log`.`a_s25` * `plandoc_stat_log`.`a_plies` AS `s25`,`plandoc_stat_log`.`a_s26` * `plandoc_stat_log`.`a_plies` AS `s26`,`plandoc_stat_log`.`a_s27` * `plandoc_stat_log`.`a_plies` AS `s27`,`plandoc_stat_log`.`a_s28` * `plandoc_stat_log`.`a_plies` AS `s28`,`plandoc_stat_log`.`a_s29` * `plandoc_stat_log`.`a_plies` AS `s29`,`plandoc_stat_log`.`a_s30` * `plandoc_stat_log`.`a_plies` AS `s30`,`plandoc_stat_log`.`a_s31` * `plandoc_stat_log`.`a_plies` AS `s31`,`plandoc_stat_log`.`a_s32` * `plandoc_stat_log`.`a_plies` AS `s32`,`plandoc_stat_log`.`a_s33` * `plandoc_stat_log`.`a_plies` AS `s33`,`plandoc_stat_log`.`a_s34` * `plandoc_stat_log`.`a_plies` AS `s34`,`plandoc_stat_log`.`a_s35` * `plandoc_stat_log`.`a_plies` AS `s35`,`plandoc_stat_log`.`a_s36` * `plandoc_stat_log`.`a_plies` AS `s36`,`plandoc_stat_log`.`a_s37` * `plandoc_stat_log`.`a_plies` AS `s37`,`plandoc_stat_log`.`a_s38` * `plandoc_stat_log`.`a_plies` AS `s38`,`plandoc_stat_log`.`a_s39` * `plandoc_stat_log`.`a_plies` AS `s39`,`plandoc_stat_log`.`a_s40` * `plandoc_stat_log`.`a_plies` AS `s40`,`plandoc_stat_log`.`a_s41` * `plandoc_stat_log`.`a_plies` AS `s41`,`plandoc_stat_log`.`a_s42` * `plandoc_stat_log`.`a_plies` AS `s42`,`plandoc_stat_log`.`a_s43` * `plandoc_stat_log`.`a_plies` AS `s43`,`plandoc_stat_log`.`a_s44` * `plandoc_stat_log`.`a_plies` AS `s44`,`plandoc_stat_log`.`a_s45` * `plandoc_stat_log`.`a_plies` AS `s45`,`plandoc_stat_log`.`a_s46` * `plandoc_stat_log`.`a_plies` AS `s46`,`plandoc_stat_log`.`a_s47` * `plandoc_stat_log`.`a_plies` AS `s47`,`plandoc_stat_log`.`a_s48` * `plandoc_stat_log`.`a_plies` AS `s48`,`plandoc_stat_log`.`a_s49` * `plandoc_stat_log`.`a_plies` AS `s49`,`plandoc_stat_log`.`a_s50` * `plandoc_stat_log`.`a_plies` AS `s50`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`embellishment_plan_dashboard`.`log_time` AS `log_time` from (`embellishment_plan_dashboard` left join `plandoc_stat_log` on(`embellishment_plan_dashboard`.`doc_no` = `plandoc_stat_log`.`doc_no`)) where `plandoc_stat_log`.`order_tid` is not null order by `embellishment_plan_dashboard`.`priority`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_div` AS `order_div`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`act_movement_status` AS `act_movement_status`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,if(`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b` > 0,1,0) + if(`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f` > 0,2,0) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where `bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid` and `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` and `cat_stat_log`.`category` in ('Body','Front') and `plandoc_stat_log`.`date` > '2010-08-01' and (`plandoc_stat_log`.`act_cut_issue_status` = '' or `plandoc_stat_log`.`a_plies` <> `plandoc_stat_log`.`p_plies` or `plandoc_stat_log`.`plan_module` is null) order by `bai_orders_db_confirm`.`order_style_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ_in_ref` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`order_div` AS `order_div`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,if(`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b` > 0,1,0) + if(`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f` > 0,2,0) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where `bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid` and `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` and `cat_stat_log`.`category` in ('Body','Front') and `plandoc_stat_log`.`date` > '2017-02-01' order by `bai_orders_db_confirm`.`order_style_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plan_doc_summ_input` AS (select `pac_stat_log_input_job`.`input_job_no` AS `input_job_no`,`pac_stat_log_input_job`.`tid` AS `tid`,`pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,`pac_stat_log_input_job`.`size_code` AS `size_code`,`pac_stat_log_input_job`.`type_of_sewing` AS `type_of_sewing`,`plan_doc_summ_in_ref`.`order_tid` AS `order_tid`,`plan_doc_summ_in_ref`.`doc_no` AS `doc_no`,`plan_doc_summ_in_ref`.`acutno` AS `acutno`,if(octet_length(`plan_doc_summ_in_ref`.`act_cut_status`) = 0,'',`plan_doc_summ_in_ref`.`act_cut_status`) AS `act_cut_status`,if(octet_length(`plan_doc_summ_in_ref`.`act_cut_issue_status`) = 0,'',`plan_doc_summ_in_ref`.`act_cut_issue_status`) AS `act_cut_issue_status`,`plan_doc_summ_in_ref`.`a_plies` AS `a_plies`,`plan_doc_summ_in_ref`.`p_plies` AS `p_plies`,`plan_doc_summ_in_ref`.`color_code` AS `color_code`,`plan_doc_summ_in_ref`.`order_style_no` AS `order_style_no`,`plan_doc_summ_in_ref`.`order_del_no` AS `order_del_no`,`plan_doc_summ_in_ref`.`order_col_des` AS `order_col_des`,`plan_doc_summ_in_ref`.`order_div` AS `order_div`,`plan_doc_summ_in_ref`.`ft_status` AS `ft_status`,`plan_doc_summ_in_ref`.`st_status` AS `st_status`,`plan_doc_summ_in_ref`.`pt_status` AS `pt_status`,`plan_doc_summ_in_ref`.`trim_status` AS `trim_status`,`plan_doc_summ_in_ref`.`category` AS `category`,`plan_doc_summ_in_ref`.`clubbing` AS `clubbing`,`plan_doc_summ_in_ref`.`plan_module` AS `plan_module`,`plan_doc_summ_in_ref`.`cat_ref` AS `cat_ref`,`plan_doc_summ_in_ref`.`emb_stat1` AS `emb_stat1`,sum(`pac_stat_log_input_job`.`carton_act_qty`) AS `carton_act_qty` from (`pac_stat_log_input_job` left join `plan_doc_summ_in_ref` on(`pac_stat_log_input_job`.`doc_no` = `plan_doc_summ_in_ref`.`doc_no`)) where `plan_doc_summ_in_ref`.`order_tid` is not null and `pac_stat_log_input_job`.`input_job_no` is not null and octet_length(`pac_stat_log_input_job`.`input_job_no_random`) > 0 group by `plan_doc_summ_in_ref`.`order_del_no`,`pac_stat_log_input_job`.`doc_no`,`pac_stat_log_input_job`.`input_job_no`,`pac_stat_log_input_job`.`input_job_no_random`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `plandoc_stat_log_cat_log_ref` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`log_update` AS `log_update`,`bai_orders_db`.`color_code` AS `color_code`,`bai_orders_db`.`order_div` AS `order_div`,`bai_orders_db`.`order_style_no` AS `order_style_no`,`bai_orders_db`.`order_del_no` AS `order_del_no`,`bai_orders_db`.`order_col_des` AS `order_col_des`,`bai_orders_db`.`ft_status` AS `ft_status`,`bai_orders_db`.`st_status` AS `st_status`,`bai_orders_db`.`pt_status` AS `pt_status`,`bai_orders_db`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,(`plandoc_stat_log`.`a_xs` + `plandoc_stat_log`.`a_s` + `plandoc_stat_log`.`a_m` + `plandoc_stat_log`.`a_l` + `plandoc_stat_log`.`a_xl` + `plandoc_stat_log`.`a_xxl` + `plandoc_stat_log`.`a_xxxl` + `plandoc_stat_log`.`a_s01` + `plandoc_stat_log`.`a_s02` + `plandoc_stat_log`.`a_s03` + `plandoc_stat_log`.`a_s04` + `plandoc_stat_log`.`a_s05` + `plandoc_stat_log`.`a_s06` + `plandoc_stat_log`.`a_s07` + `plandoc_stat_log`.`a_s08` + `plandoc_stat_log`.`a_s09` + `plandoc_stat_log`.`a_s10` + `plandoc_stat_log`.`a_s11` + `plandoc_stat_log`.`a_s12` + `plandoc_stat_log`.`a_s13` + `plandoc_stat_log`.`a_s14` + `plandoc_stat_log`.`a_s15` + `plandoc_stat_log`.`a_s16` + `plandoc_stat_log`.`a_s17` + `plandoc_stat_log`.`a_s18` + `plandoc_stat_log`.`a_s19` + `plandoc_stat_log`.`a_s20` + `plandoc_stat_log`.`a_s21` + `plandoc_stat_log`.`a_s22` + `plandoc_stat_log`.`a_s23` + `plandoc_stat_log`.`a_s24` + `plandoc_stat_log`.`a_s25` + `plandoc_stat_log`.`a_s26` + `plandoc_stat_log`.`a_s27` + `plandoc_stat_log`.`a_s28` + `plandoc_stat_log`.`a_s29` + `plandoc_stat_log`.`a_s30` + `plandoc_stat_log`.`a_s31` + `plandoc_stat_log`.`a_s32` + `plandoc_stat_log`.`a_s33` + `plandoc_stat_log`.`a_s34` + `plandoc_stat_log`.`a_s35` + `plandoc_stat_log`.`a_s36` + `plandoc_stat_log`.`a_s37` + `plandoc_stat_log`.`a_s38` + `plandoc_stat_log`.`a_s39` + `plandoc_stat_log`.`a_s40` + `plandoc_stat_log`.`a_s41` + `plandoc_stat_log`.`a_s42` + `plandoc_stat_log`.`a_s43` + `plandoc_stat_log`.`a_s44` + `plandoc_stat_log`.`a_s45` + `plandoc_stat_log`.`a_s46` + `plandoc_stat_log`.`a_s47` + `plandoc_stat_log`.`a_s48` + `plandoc_stat_log`.`a_s49` + `plandoc_stat_log`.`a_s50`) * `plandoc_stat_log`.`a_plies` AS `doc_total` from ((`plandoc_stat_log` join `bai_orders_db`) join `cat_stat_log`) where `bai_orders_db`.`order_tid` = `plandoc_stat_log`.`order_tid` and `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` and `cat_stat_log`.`category` in ('Body','Front') and `plandoc_stat_log`.`date` > '2010-08-01' order by `bai_orders_db`.`order_style_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `qms_vs_recut` AS (select `bai_qms_db`.`qms_tid` AS `qms_tid`,min(`bai_qms_db`.`log_date`) AS `log_date`,`bai_qms_db`.`qms_style` AS `qms_style`,`bai_qms_db`.`qms_schedule` AS `qms_schedule`,`bai_qms_db`.`qms_color` AS `qms_color`,sum(if(`bai_qms_db`.`qms_tran_type` = 6,`bai_qms_db`.`qms_qty`,0)) AS `raised`,sum(if(`bai_qms_db`.`qms_tran_type` = 9,`bai_qms_db`.`qms_qty`,0)) AS `actual`,`bai_qms_db`.`ref1` AS `ref1`,`bai_qms_db`.`qms_size` AS `qms_size`,substring_index(`bai_qms_db`.`remarks`,'-',1) AS `module`,substring_index(`bai_qms_db`.`remarks`,'-',-1) AS `doc_no`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`plan_module` AS `plan_module`,`recut_v2`.`fabric_status` AS `fabric_status` from (`bai_qms_db` left join `recut_v2` on(substring_index(`bai_qms_db`.`remarks`,'-',-1) = `recut_v2`.`doc_no`)) where `bai_qms_db`.`qms_tran_type` in (6,9) and `bai_qms_db`.`log_date` > '2011-09-01' group by `bai_qms_db`.`qms_schedule`,`bai_qms_db`.`qms_color`,`bai_qms_db`.`remarks`,`bai_qms_db`.`qms_size`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `recut_v2_summary` AS (select `recut_v2`.`date` AS `date`,`recut_v2`.`cat_ref` AS `cat_ref`,`recut_v2`.`cuttable_ref` AS `cuttable_ref`,`recut_v2`.`allocate_ref` AS `allocate_ref`,`recut_v2`.`mk_ref` AS `mk_ref`,`recut_v2`.`order_tid` AS `order_tid`,`recut_v2`.`pcutno` AS `pcutno`,`recut_v2`.`ratio` AS `ratio`,`recut_v2`.`p_xs` AS `p_xs`,`recut_v2`.`p_s` AS `p_s`,`recut_v2`.`p_m` AS `p_m`,`recut_v2`.`p_l` AS `p_l`,`recut_v2`.`p_xl` AS `p_xl`,`recut_v2`.`p_xxl` AS `p_xxl`,`recut_v2`.`p_xxxl` AS `p_xxxl`,`recut_v2`.`p_plies` AS `p_plies`,`recut_v2`.`doc_no` AS `doc_no`,`recut_v2`.`acutno` AS `acutno`,`recut_v2`.`a_xs` AS `a_xs`,`recut_v2`.`a_s` AS `a_s`,`recut_v2`.`a_m` AS `a_m`,`recut_v2`.`a_l` AS `a_l`,`recut_v2`.`a_xl` AS `a_xl`,`recut_v2`.`a_xxl` AS `a_xxl`,`recut_v2`.`a_xxxl` AS `a_xxxl`,`recut_v2`.`a_plies` AS `a_plies`,`recut_v2`.`lastup` AS `lastup`,`recut_v2`.`remarks` AS `remarks`,`recut_v2`.`act_cut_status` AS `act_cut_status`,`recut_v2`.`act_cut_issue_status` AS `act_cut_issue_status`,`recut_v2`.`pcutdocid` AS `pcutdocid`,`recut_v2`.`print_status` AS `print_status`,`recut_v2`.`a_s01` AS `a_s01`,`recut_v2`.`a_s02` AS `a_s02`,`recut_v2`.`a_s03` AS `a_s03`,`recut_v2`.`a_s04` AS `a_s04`,`recut_v2`.`a_s05` AS `a_s05`,`recut_v2`.`a_s06` AS `a_s06`,`recut_v2`.`a_s07` AS `a_s07`,`recut_v2`.`a_s08` AS `a_s08`,`recut_v2`.`a_s09` AS `a_s09`,`recut_v2`.`a_s10` AS `a_s10`,`recut_v2`.`a_s11` AS `a_s11`,`recut_v2`.`a_s12` AS `a_s12`,`recut_v2`.`a_s13` AS `a_s13`,`recut_v2`.`a_s14` AS `a_s14`,`recut_v2`.`a_s15` AS `a_s15`,`recut_v2`.`a_s16` AS `a_s16`,`recut_v2`.`a_s17` AS `a_s17`,`recut_v2`.`a_s18` AS `a_s18`,`recut_v2`.`a_s19` AS `a_s19`,`recut_v2`.`a_s20` AS `a_s20`,`recut_v2`.`a_s21` AS `a_s21`,`recut_v2`.`a_s22` AS `a_s22`,`recut_v2`.`a_s23` AS `a_s23`,`recut_v2`.`a_s24` AS `a_s24`,`recut_v2`.`a_s25` AS `a_s25`,`recut_v2`.`a_s26` AS `a_s26`,`recut_v2`.`a_s27` AS `a_s27`,`recut_v2`.`a_s28` AS `a_s28`,`recut_v2`.`a_s29` AS `a_s29`,`recut_v2`.`a_s30` AS `a_s30`,`recut_v2`.`a_s31` AS `a_s31`,`recut_v2`.`a_s32` AS `a_s32`,`recut_v2`.`a_s33` AS `a_s33`,`recut_v2`.`a_s34` AS `a_s34`,`recut_v2`.`a_s35` AS `a_s35`,`recut_v2`.`a_s36` AS `a_s36`,`recut_v2`.`a_s37` AS `a_s37`,`recut_v2`.`a_s38` AS `a_s38`,`recut_v2`.`a_s39` AS `a_s39`,`recut_v2`.`a_s40` AS `a_s40`,`recut_v2`.`a_s41` AS `a_s41`,`recut_v2`.`a_s42` AS `a_s42`,`recut_v2`.`a_s43` AS `a_s43`,`recut_v2`.`a_s44` AS `a_s44`,`recut_v2`.`a_s45` AS `a_s45`,`recut_v2`.`a_s46` AS `a_s46`,`recut_v2`.`a_s47` AS `a_s47`,`recut_v2`.`a_s48` AS `a_s48`,`recut_v2`.`a_s49` AS `a_s49`,`recut_v2`.`a_s50` AS `a_s50`,`recut_v2`.`p_s01` AS `p_s01`,`recut_v2`.`p_s02` AS `p_s02`,`recut_v2`.`p_s03` AS `p_s03`,`recut_v2`.`p_s04` AS `p_s04`,`recut_v2`.`p_s05` AS `p_s05`,`recut_v2`.`p_s06` AS `p_s06`,`recut_v2`.`p_s07` AS `p_s07`,`recut_v2`.`p_s08` AS `p_s08`,`recut_v2`.`p_s09` AS `p_s09`,`recut_v2`.`p_s10` AS `p_s10`,`recut_v2`.`p_s11` AS `p_s11`,`recut_v2`.`p_s12` AS `p_s12`,`recut_v2`.`p_s13` AS `p_s13`,`recut_v2`.`p_s14` AS `p_s14`,`recut_v2`.`p_s15` AS `p_s15`,`recut_v2`.`p_s16` AS `p_s16`,`recut_v2`.`p_s17` AS `p_s17`,`recut_v2`.`p_s18` AS `p_s18`,`recut_v2`.`p_s19` AS `p_s19`,`recut_v2`.`p_s20` AS `p_s20`,`recut_v2`.`p_s21` AS `p_s21`,`recut_v2`.`p_s22` AS `p_s22`,`recut_v2`.`p_s23` AS `p_s23`,`recut_v2`.`p_s24` AS `p_s24`,`recut_v2`.`p_s25` AS `p_s25`,`recut_v2`.`p_s26` AS `p_s26`,`recut_v2`.`p_s27` AS `p_s27`,`recut_v2`.`p_s28` AS `p_s28`,`recut_v2`.`p_s29` AS `p_s29`,`recut_v2`.`p_s30` AS `p_s30`,`recut_v2`.`p_s31` AS `p_s31`,`recut_v2`.`p_s32` AS `p_s32`,`recut_v2`.`p_s33` AS `p_s33`,`recut_v2`.`p_s34` AS `p_s34`,`recut_v2`.`p_s35` AS `p_s35`,`recut_v2`.`p_s36` AS `p_s36`,`recut_v2`.`p_s37` AS `p_s37`,`recut_v2`.`p_s38` AS `p_s38`,`recut_v2`.`p_s39` AS `p_s39`,`recut_v2`.`p_s40` AS `p_s40`,`recut_v2`.`p_s41` AS `p_s41`,`recut_v2`.`p_s42` AS `p_s42`,`recut_v2`.`p_s43` AS `p_s43`,`recut_v2`.`p_s44` AS `p_s44`,`recut_v2`.`p_s45` AS `p_s45`,`recut_v2`.`p_s46` AS `p_s46`,`recut_v2`.`p_s47` AS `p_s47`,`recut_v2`.`p_s48` AS `p_s48`,`recut_v2`.`p_s49` AS `p_s49`,`recut_v2`.`p_s50` AS `p_s50`,`recut_v2`.`rm_date` AS `rm_date`,`recut_v2`.`cut_inp_temp` AS `cut_inp_temp`,`recut_v2`.`plan_module` AS `plan_module`,`recut_v2`.`fabric_status` AS `fabric_status`,`recut_v2`.`plan_lot_ref` AS `plan_lot_ref`,(`recut_v2`.`a_xs` + `recut_v2`.`a_s` + `recut_v2`.`a_m` + `recut_v2`.`a_l` + `recut_v2`.`a_xl` + `recut_v2`.`a_xxl` + `recut_v2`.`a_xxxl` + `recut_v2`.`a_s01` + `recut_v2`.`a_s02` + `recut_v2`.`a_s03` + `recut_v2`.`a_s04` + `recut_v2`.`a_s05` + `recut_v2`.`a_s06` + `recut_v2`.`a_s07` + `recut_v2`.`a_s08` + `recut_v2`.`a_s09` + `recut_v2`.`a_s10` + `recut_v2`.`a_s11` + `recut_v2`.`a_s12` + `recut_v2`.`a_s13` + `recut_v2`.`a_s14` + `recut_v2`.`a_s15` + `recut_v2`.`a_s16` + `recut_v2`.`a_s17` + `recut_v2`.`a_s18` + `recut_v2`.`a_s19` + `recut_v2`.`a_s20` + `recut_v2`.`a_s21` + `recut_v2`.`a_s22` + `recut_v2`.`a_s23` + `recut_v2`.`a_s24` + `recut_v2`.`a_s25` + `recut_v2`.`a_s26` + `recut_v2`.`a_s27` + `recut_v2`.`a_s28` + `recut_v2`.`a_s29` + `recut_v2`.`a_s30` + `recut_v2`.`a_s31` + `recut_v2`.`a_s32` + `recut_v2`.`a_s33` + `recut_v2`.`a_s34` + `recut_v2`.`a_s35` + `recut_v2`.`a_s36` + `recut_v2`.`a_s37` + `recut_v2`.`a_s38` + `recut_v2`.`a_s39` + `recut_v2`.`a_s40` + `recut_v2`.`a_s41` + `recut_v2`.`a_s42` + `recut_v2`.`a_s43` + `recut_v2`.`a_s44` + `recut_v2`.`a_s45` + `recut_v2`.`a_s46` + `recut_v2`.`a_s47` + `recut_v2`.`a_s48` + `recut_v2`.`a_s49` + `recut_v2`.`a_s50`) * `recut_v2`.`a_plies` AS `actual_cut_qty`,`recut_v2`.`p_xs` + `recut_v2`.`p_s` + `recut_v2`.`p_m` + `recut_v2`.`p_l` + `recut_v2`.`p_xl` + `recut_v2`.`p_xxl` + `recut_v2`.`p_xxxl` + `recut_v2`.`p_s01` + `recut_v2`.`p_s02` + `recut_v2`.`p_s03` + `recut_v2`.`p_s04` + `recut_v2`.`p_s05` + `recut_v2`.`p_s06` + `recut_v2`.`p_s07` + `recut_v2`.`p_s08` + `recut_v2`.`p_s09` + `recut_v2`.`p_s10` + `recut_v2`.`p_s11` + `recut_v2`.`p_s12` + `recut_v2`.`p_s13` + `recut_v2`.`p_s14` + `recut_v2`.`p_s15` + `recut_v2`.`p_s16` + `recut_v2`.`p_s17` + `recut_v2`.`p_s18` + `recut_v2`.`p_s19` + `recut_v2`.`p_s20` + `recut_v2`.`p_s21` + `recut_v2`.`p_s22` + `recut_v2`.`p_s23` + `recut_v2`.`p_s24` + `recut_v2`.`p_s25` + `recut_v2`.`p_s26` + `recut_v2`.`p_s27` + `recut_v2`.`p_s28` + `recut_v2`.`p_s29` + `recut_v2`.`p_s30` + `recut_v2`.`p_s31` + `recut_v2`.`p_s32` + `recut_v2`.`p_s33` + `recut_v2`.`p_s34` + `recut_v2`.`p_s35` + `recut_v2`.`p_s36` + `recut_v2`.`p_s37` + `recut_v2`.`p_s38` + `recut_v2`.`p_s39` + `recut_v2`.`p_s40` + `recut_v2`.`p_s41` + `recut_v2`.`p_s42` + `recut_v2`.`p_s43` + `recut_v2`.`p_s44` + `recut_v2`.`p_s45` + `recut_v2`.`p_s46` + `recut_v2`.`p_s47` + `recut_v2`.`p_s48` + `recut_v2`.`p_s49` + `recut_v2`.`p_s50` AS `actual_req_qty` from `recut_v2` where `recut_v2`.`act_cut_status` = 'DONE' and `recut_v2`.`remarks` in ('Body','Front'))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `test_plan_doc_summ` AS (select `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`act_movement_status` AS `act_movement_status`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,if(`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b` > 0,1,0) + if(`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f` > 0,2,0) AS `emb_stat1` from ((`plandoc_stat_log` join `bai_orders_db_confirm`) join `cat_stat_log`) where `bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid` and `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` and `cat_stat_log`.`category` in ('Body','Front') and `plandoc_stat_log`.`date` > '2010-08-01' and (`plandoc_stat_log`.`act_cut_issue_status` = '' and (`plandoc_stat_log`.`act_movement_status` = 'DONE' or `plandoc_stat_log`.`act_movement_status` = '') or `plandoc_stat_log`.`a_plies` <> `plandoc_stat_log`.`p_plies` or `plandoc_stat_log`.`plan_module` is null) order by `bai_orders_db_confirm`.`order_style_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `zero_module_trans` AS (select sum(`ims_log_backup`.`ims_qty`) AS `ims_qty`,`ims_log_backup`.`ims_style` AS `ims_style`,`ims_log_backup`.`ims_schedule` AS `ims_schedule`,`ims_log_backup`.`ims_color` AS `ims_color`,replace(`ims_log_backup`.`ims_size`,'a_','') AS `size` from `ims_log_backup` where `ims_log_backup`.`ims_mod_no` = 0 and `ims_log_backup`.`ims_date` > '2013-12-01' group by concat(`ims_log_backup`.`ims_style`,`ims_log_backup`.`ims_schedule`,`ims_log_backup`.`ims_color`,`ims_log_backup`.`ims_size`))$$
DELIMITER ;

/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_act_pac_qty`$$
CREATE FUNCTION `fn_act_pac_qty`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	   SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(carton_act_qty),0) FROM pac_stat_log WHERE doc_no=in_ims_doc_no AND size_code=in_ims_size AND STATUS="DONE");
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;	 
	  RETURN var_name;
    END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_act_ship_qty`$$
CREATE FUNCTION `fn_act_ship_qty`(in_sch_no BIGINT) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	  /*SET var_name=(SELECT COALESCE(SUM(shipped),0) FROM bai_ship_cts_ref WHERE ship_schedule=in_sch_no);*/
	  SET var_name=(SELECT
  COALESCE(SUM((((((((((((((((((((`ship_stat_log`.`ship_s_s06` + `ship_stat_log`.`ship_s_s08`) + `ship_stat_log`.`ship_s_s10`) + `ship_stat_log`.`ship_s_s12`) + `ship_stat_log`.`ship_s_s14`) + `ship_stat_log`.`ship_s_s16`) + `ship_stat_log`.`ship_s_s18`) + `ship_stat_log`.`ship_s_s20`) + `ship_stat_log`.`ship_s_s22`) + `ship_stat_log`.`ship_s_s24`) + `ship_stat_log`.`ship_s_s26`) + `ship_stat_log`.`ship_s_s28`) + `ship_stat_log`.`ship_s_s30`) + `ship_stat_log`.`ship_s_xs`) + `ship_stat_log`.`ship_s_s`) + `ship_stat_log`.`ship_s_m`) + `ship_stat_log`.`ship_s_l`) + `ship_stat_log`.`ship_s_xl`) + `ship_stat_log`.`ship_s_xxl`) + `ship_stat_log`.`ship_s_xxxl`)),0) AS `shipped`
FROM `ship_stat_log`
WHERE (ship_schedule=in_sch_no AND `ship_stat_log`.`ship_status` = 2));
	  RETURN var_name;
    END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_buyer_division_sch`$$
CREATE FUNCTION `fn_buyer_division_sch`(in_schedule VARCHAR(100)) RETURNS varchar(100) CHARSET latin1
BEGIN
	DECLARE order_div_name VARCHAR(200);
	set order_div_name=(SELECT order_div FROM bai_pro3.bai_orders_db_confirm WHERE order_del_no=in_schedule limit 1);
	if LENGTH(order_div_name)=0 or order_div_name is null then
		SET order_div_name=(SELECT order_div FROM bai_pro3.bai_orders_db_confirm_archive WHERE order_del_no=in_schedule LIMIT 1);
	end if;
	
	return order_div_name;
END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_ims_log_bk_output`$$
CREATE FUNCTION `fn_ims_log_bk_output`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	   SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(ims_pro_qty),0) FROM ims_log_backup WHERE ims_doc_no=in_ims_doc_no AND ims_size=("a_"+in_ims_size) AND ims_mod_no > 0);
SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;	  
	  RETURN var_name;
    END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_ims_log_output`$$
CREATE FUNCTION `fn_ims_log_output`(in_ims_doc_no BIGINT,in_ims_size VARCHAR(100)) RETURNS int(11)
BEGIN
	DECLARE var_name INT;
	  SET var_name = 0;
	  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED ;
	  SET var_name=(SELECT COALESCE(SUM(ims_pro_qty),0) FROM ims_log WHERE ims_doc_no=in_ims_doc_no AND ims_size=("a_"+in_ims_size) AND ims_mod_no > 0);
	SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ ;
	  RETURN var_name;
    END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `stripSpeciaChars`$$
CREATE FUNCTION `stripSpeciaChars`(`dirty_string` VARCHAR(2048),allow_space TINYINT,allow_number TINYINT,allow_alphabets TINYINT,no_trim TINYINT) RETURNS varchar(2048) CHARSET utf8
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
END$$
DELIMITER ;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `bai_pro4`;

/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bai_cut_to_ship_ref` AS (select `shipment_plan_ref`.`ship_tid` AS `ship_tid`,`week_delivery_plan`.`tid` AS `tid`,`shipment_plan_ref`.`buyer_division` AS `buyer_division`,`shipment_plan_ref`.`ssc_code_new` AS `ssc_code_new`,`shipment_plan_ref`.`schedule_no` AS `schedule_no`,`shipment_plan_ref`.`color` AS `color`,`shipment_plan_ref`.`style` AS `style`,`week_delivery_plan`.`original_order_qty` AS `ord_qty_new`,`shipment_plan_ref`.`ord_qty_new` AS `ord_qty_new_old`,`shipment_plan_ref`.`ex_factory_date` AS `m3_ship_plan_ex_fact`,`week_delivery_plan`.`act_exfact` AS `ex_factory_date`,`week_delivery_plan`.`rev_exfactory` AS `rev_exfactory`,if(`week_delivery_plan`.`rev_exfactory` = '0000-00-00',`week_delivery_plan`.`act_exfact`,`week_delivery_plan`.`rev_exfactory`) AS `ex_factory_date_new`,`week_delivery_plan`.`actu_sec1` + `week_delivery_plan`.`actu_sec2` + `week_delivery_plan`.`actu_sec3` + `week_delivery_plan`.`actu_sec4` + `week_delivery_plan`.`actu_sec5` + `week_delivery_plan`.`actu_sec6` + `week_delivery_plan`.`actu_sec7` + `week_delivery_plan`.`actu_sec8` + `week_delivery_plan`.`actu_sec9` AS `output`,concat(if(`week_delivery_plan`.`actu_sec1` > 0,'1,',''),if(`week_delivery_plan`.`actu_sec2` > 0,'2,',''),if(`week_delivery_plan`.`actu_sec3` > 0,'3,',''),if(`week_delivery_plan`.`actu_sec4` > 0,'4,',''),if(`week_delivery_plan`.`actu_sec5` > 0,'5,',''),if(`week_delivery_plan`.`actu_sec6` > 0,'6,',''),if(`week_delivery_plan`.`actu_sec7` > 0,'7,',''),if(`week_delivery_plan`.`actu_sec8` > 0,'8,',''),if(`week_delivery_plan`.`actu_sec9` > 0,'9,',''),if(`week_delivery_plan`.`actu_sec10` > 0,'10,',''),if(`week_delivery_plan`.`actu_sec11` > 0,'11,',''),if(`week_delivery_plan`.`actu_sec12` > 0,'12,',''),if(`week_delivery_plan`.`actu_sec13` > 0,'13,',''),if(`week_delivery_plan`.`actu_sec14` > 0,'14,',''),if(`week_delivery_plan`.`actu_sec15` > 0,'15,','')) AS `sections`,`week_delivery_plan`.`act_cut` AS `act_cut`,`week_delivery_plan`.`act_in` AS `act_in`,`week_delivery_plan`.`act_fca` AS `act_fca`,`week_delivery_plan`.`act_mca` AS `act_mca`,`week_delivery_plan`.`act_fg` AS `act_fg`,`week_delivery_plan`.`cart_pending` AS `cart_pending`,`week_delivery_plan`.`priority` AS `priority`,`week_delivery_plan`.`ref_id` AS `ref_id` from (`week_delivery_plan` left join `shipment_plan_ref` on(`week_delivery_plan`.`shipment_plan_id` = `shipment_plan_ref`.`ship_tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `delivery_report_p1` AS (select `shipment_plan`.`buyer_division` AS `buyer_division`,`shipment_plan`.`mpo` AS `mpo`,`shipment_plan`.`cpo` AS `cpo`,`shipment_plan`.`order_no` AS `order_no`,`shipment_plan`.`style` AS `style`,`shipment_plan`.`schedule_no` AS `schedule_no`,`shipment_plan`.`color` AS `color`,`shipment_plan`.`ex_factory_date` AS `ex_factory_date`,`shipment_plan`.`mode` AS `MODE`,`shipment_plan`.`ssc_code` AS `ssc_code`,concat(`shipment_plan`.`order_embl_a`,`shipment_plan`.`order_embl_b`,`shipment_plan`.`order_embl_c`,`shipment_plan`.`order_embl_d`,`shipment_plan`.`order_embl_e`,`shipment_plan`.`order_embl_f`,`shipment_plan`.`order_embl_g`,`shipment_plan`.`order_embl_h`) AS `embl_status`,sum(if(`shipment_plan`.`size` = 'size_xs',`shipment_plan`.`ord_qty`,0)) AS `xs`,sum(if(`shipment_plan`.`size` = 'size_s',`shipment_plan`.`ord_qty`,0)) AS `s`,sum(if(`shipment_plan`.`size` = 'size_m',`shipment_plan`.`ord_qty`,0)) AS `m`,sum(if(`shipment_plan`.`size` = 'size_l',`shipment_plan`.`ord_qty`,0)) AS `l`,sum(if(`shipment_plan`.`size` = 'size_xl',`shipment_plan`.`ord_qty`,0)) AS `xl`,sum(if(`shipment_plan`.`size` = 'size_xxl',`shipment_plan`.`ord_qty`,0)) AS `xxl`,sum(if(`shipment_plan`.`size` = 'size_xxxl',`shipment_plan`.`ord_qty`,0)) AS `xxxl`,sum(if(`shipment_plan`.`size` = 'size_s01',`shipment_plan`.`ord_qty`,0)) AS `s01`,sum(if(`shipment_plan`.`size` = 'size_s02',`shipment_plan`.`ord_qty`,0)) AS `s02`,sum(if(`shipment_plan`.`size` = 'size_s03',`shipment_plan`.`ord_qty`,0)) AS `s03`,sum(if(`shipment_plan`.`size` = 'size_s04',`shipment_plan`.`ord_qty`,0)) AS `s04`,sum(if(`shipment_plan`.`size` = 'size_s05',`shipment_plan`.`ord_qty`,0)) AS `s05`,sum(if(`shipment_plan`.`size` = 'size_s06',`shipment_plan`.`ord_qty`,0)) AS `s06`,sum(if(`shipment_plan`.`size` = 'size_s07',`shipment_plan`.`ord_qty`,0)) AS `s07`,sum(if(`shipment_plan`.`size` = 'size_s08',`shipment_plan`.`ord_qty`,0)) AS `s08`,sum(if(`shipment_plan`.`size` = 'size_s09',`shipment_plan`.`ord_qty`,0)) AS `s09`,sum(if(`shipment_plan`.`size` = 'size_s10',`shipment_plan`.`ord_qty`,0)) AS `s10`,sum(if(`shipment_plan`.`size` = 'size_s11',`shipment_plan`.`ord_qty`,0)) AS `s11`,sum(if(`shipment_plan`.`size` = 'size_s12',`shipment_plan`.`ord_qty`,0)) AS `s12`,sum(if(`shipment_plan`.`size` = 'size_s13',`shipment_plan`.`ord_qty`,0)) AS `s13`,sum(if(`shipment_plan`.`size` = 'size_s14',`shipment_plan`.`ord_qty`,0)) AS `s14`,sum(if(`shipment_plan`.`size` = 'size_s15',`shipment_plan`.`ord_qty`,0)) AS `s15`,sum(if(`shipment_plan`.`size` = 'size_s16',`shipment_plan`.`ord_qty`,0)) AS `s16`,sum(if(`shipment_plan`.`size` = 'size_s17',`shipment_plan`.`ord_qty`,0)) AS `s17`,sum(if(`shipment_plan`.`size` = 'size_s18',`shipment_plan`.`ord_qty`,0)) AS `s18`,sum(if(`shipment_plan`.`size` = 'size_s19',`shipment_plan`.`ord_qty`,0)) AS `s19`,sum(if(`shipment_plan`.`size` = 'size_s20',`shipment_plan`.`ord_qty`,0)) AS `s20`,sum(if(`shipment_plan`.`size` = 'size_s21',`shipment_plan`.`ord_qty`,0)) AS `s21`,sum(if(`shipment_plan`.`size` = 'size_s22',`shipment_plan`.`ord_qty`,0)) AS `s22`,sum(if(`shipment_plan`.`size` = 'size_s23',`shipment_plan`.`ord_qty`,0)) AS `s23`,sum(if(`shipment_plan`.`size` = 'size_s24',`shipment_plan`.`ord_qty`,0)) AS `s24`,sum(if(`shipment_plan`.`size` = 'size_s25',`shipment_plan`.`ord_qty`,0)) AS `s25`,sum(if(`shipment_plan`.`size` = 'size_s26',`shipment_plan`.`ord_qty`,0)) AS `s26`,sum(if(`shipment_plan`.`size` = 'size_s27',`shipment_plan`.`ord_qty`,0)) AS `s27`,sum(if(`shipment_plan`.`size` = 'size_s28',`shipment_plan`.`ord_qty`,0)) AS `s28`,sum(if(`shipment_plan`.`size` = 'size_s29',`shipment_plan`.`ord_qty`,0)) AS `s29`,sum(if(`shipment_plan`.`size` = 'size_s30',`shipment_plan`.`ord_qty`,0)) AS `s30`,sum(if(`shipment_plan`.`size` = 'size_s31',`shipment_plan`.`ord_qty`,0)) AS `s31`,sum(if(`shipment_plan`.`size` = 'size_s32',`shipment_plan`.`ord_qty`,0)) AS `s32`,sum(if(`shipment_plan`.`size` = 'size_s33',`shipment_plan`.`ord_qty`,0)) AS `s33`,sum(if(`shipment_plan`.`size` = 'size_s34',`shipment_plan`.`ord_qty`,0)) AS `s34`,sum(if(`shipment_plan`.`size` = 'size_s35',`shipment_plan`.`ord_qty`,0)) AS `s35`,sum(if(`shipment_plan`.`size` = 'size_s36',`shipment_plan`.`ord_qty`,0)) AS `s36`,sum(if(`shipment_plan`.`size` = 'size_s37',`shipment_plan`.`ord_qty`,0)) AS `s37`,sum(if(`shipment_plan`.`size` = 'size_s38',`shipment_plan`.`ord_qty`,0)) AS `s38`,sum(if(`shipment_plan`.`size` = 'size_s39',`shipment_plan`.`ord_qty`,0)) AS `s39`,sum(if(`shipment_plan`.`size` = 'size_s40',`shipment_plan`.`ord_qty`,0)) AS `s40`,sum(if(`shipment_plan`.`size` = 'size_s41',`shipment_plan`.`ord_qty`,0)) AS `s41`,sum(if(`shipment_plan`.`size` = 'size_s42',`shipment_plan`.`ord_qty`,0)) AS `s42`,sum(if(`shipment_plan`.`size` = 'size_s43',`shipment_plan`.`ord_qty`,0)) AS `s43`,sum(if(`shipment_plan`.`size` = 'size_s44',`shipment_plan`.`ord_qty`,0)) AS `s44`,sum(if(`shipment_plan`.`size` = 'size_s45',`shipment_plan`.`ord_qty`,0)) AS `s45`,sum(if(`shipment_plan`.`size` = 'size_s46',`shipment_plan`.`ord_qty`,0)) AS `s46`,sum(if(`shipment_plan`.`size` = 'size_s47',`shipment_plan`.`ord_qty`,0)) AS `s47`,sum(if(`shipment_plan`.`size` = 'size_s48',`shipment_plan`.`ord_qty`,0)) AS `s48`,sum(if(`shipment_plan`.`size` = 'size_s49',`shipment_plan`.`ord_qty`,0)) AS `s49`,sum(if(`shipment_plan`.`size` = 'size_s50',`shipment_plan`.`ord_qty`,0)) AS `s50` from `shipment_plan` where `shipment_plan`.`schedule_no` in (select distinct `fastreact_plan`.`schedule` AS `SCHEDULE` from `fastreact_plan`) group by `shipment_plan`.`ssc_code`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `week_delivery_plan_ref` AS (select `shipment_plan_ref`.`ship_tid` AS `ship_tid`,`week_delivery_plan`.`tid` AS `tid`,`shipment_plan_ref`.`buyer_division` AS `buyer_division`,`shipment_plan_ref`.`schedule_no` AS `schedule_no`,`shipment_plan_ref`.`color` AS `color`,`shipment_plan_ref`.`style` AS `style`,`shipment_plan_ref`.`size` AS `size`,`week_delivery_plan`.`original_order_qty` AS `ord_qty_new`,`shipment_plan_ref`.`ord_qty_new` AS `ord_qty_new_old`,`shipment_plan_ref`.`ex_factory_date` AS `m3_ship_plan_ex_fact`,`shipment_plan_ref`.`ex_factory_date` AS `ex_factory_date`,`week_delivery_plan`.`rev_exfactory` AS `rev_exfactory`,if(`week_delivery_plan`.`rev_exfactory` = '0000-00-00',`week_delivery_plan`.`act_exfact`,`week_delivery_plan`.`rev_exfactory`) AS `ex_factory_date_new`,`week_delivery_plan`.`actu_sec1` + `week_delivery_plan`.`actu_sec2` + `week_delivery_plan`.`actu_sec3` + `week_delivery_plan`.`actu_sec4` + `week_delivery_plan`.`actu_sec5` + `week_delivery_plan`.`actu_sec6` + `week_delivery_plan`.`actu_sec7` + `week_delivery_plan`.`actu_sec8` + `week_delivery_plan`.`actu_sec9` + `week_delivery_plan`.`actu_sec10` + `week_delivery_plan`.`actu_sec11` + `week_delivery_plan`.`actu_sec12` + `week_delivery_plan`.`actu_sec13` + `week_delivery_plan`.`actu_sec14` + `week_delivery_plan`.`actu_sec15` AS `output`,`week_delivery_plan`.`act_cut` AS `act_cut`,`week_delivery_plan`.`act_in` AS `act_in`,`week_delivery_plan`.`act_fca` AS `act_fca`,`week_delivery_plan`.`act_mca` AS `act_mca`,`week_delivery_plan`.`act_fg` AS `act_fg`,`week_delivery_plan`.`act_ship` AS `act_ship`,`week_delivery_plan`.`cart_pending` AS `cart_pending`,`week_delivery_plan`.`priority` AS `priority`,`week_delivery_plan`.`ref_id` AS `ref_id`,`week_delivery_plan`.`act_exfact` AS `act_exfact`,`week_delivery_plan`.`act_rej` AS `act_rej`,`week_delivery_plan`.`remarks` AS `remarks` from (`week_delivery_plan` left join `shipment_plan_ref` on(`week_delivery_plan`.`shipment_plan_id` = `shipment_plan_ref`.`ship_tid`)))$$
DELIMITER ;

/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `uExtractNumberFromString`$$
CREATE FUNCTION `uExtractNumberFromString`(in_string VARCHAR(50)) RETURNS varchar(30) CHARSET latin1
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
    END$$
DELIMITER ;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `bai_rm_pj1`;

/* Alter table in target */
ALTER TABLE `inspection_supplier_db` 
	DROP KEY `NewIndex1`, ADD KEY `NewIndex1`(`supplier_code`,`supplier_m3_code`) , 
	DROP KEY `unique`, ADD KEY `unique`(`product_code`,`supplier_code`,`supplier_m3_code`) ;

/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `docket_ref` AS (select `fabric_cad_allocation`.`tran_pin` AS `tran_pin`,`fabric_cad_allocation`.`doc_no` AS `doc_no`,`fabric_cad_allocation`.`roll_id` AS `roll_id`,`fabric_cad_allocation`.`roll_width` AS `roll_width`,`fabric_cad_allocation`.`plies` AS `plies`,`fabric_cad_allocation`.`mk_len` AS `mk_len`,`fabric_cad_allocation`.`doc_type` AS `doc_type`,`fabric_cad_allocation`.`log_time` AS `log_time`,`fabric_cad_allocation`.`allocated_qty` AS `allocated_qty`,`sticker_ref`.`ref1` AS `ref1`,`sticker_ref`.`lot_no` AS `lot_no`,`sticker_ref`.`batch_no` AS `batch_no`,`sticker_ref`.`item_desc` AS `item_desc`,`sticker_ref`.`item_name` AS `item_name`,`sticker_ref`.`item` AS `item`,`sticker_ref`.`ref2` AS `ref2`,`sticker_ref`.`ref3` AS `ref3`,`sticker_ref`.`ref4` AS `ref4`,`sticker_ref`.`ref5` AS `ref5`,`sticker_ref`.`ref6` AS `ref6`,`sticker_ref`.`pkg_no` AS `pkg_no`,`sticker_ref`.`status` AS `status`,`sticker_ref`.`grn_date` AS `grn_date`,`sticker_ref`.`remarks` AS `remarks`,`sticker_ref`.`tid` AS `tid`,`sticker_ref`.`qty_rec` AS `qty_rec`,`sticker_ref`.`qty_issued` AS `qty_issued`,`sticker_ref`.`qty_ret` AS `qty_ret`,`sticker_ref`.`inv_no` AS `inv_no` from (`fabric_cad_allocation` left join `sticker_ref` on(`fabric_cad_allocation`.`roll_id` = `sticker_ref`.`tid`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fabric_status` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round(round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2),2)),2) AS `balance` from (`store_in` join `sticker_report`) where `sticker_report`.`product_group` like '%fabric%' and round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2) > 0 and `store_in`.`lot_no` = `sticker_report`.`lot_no` group by `store_in`.`lot_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fabric_status_v1` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref4` AS `ref4`,`store_in`.`allotment_status` AS `allotment_status`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,round(coalesce(`store_in`.`ref5`,0),2) AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,round(coalesce(`store_in`.`ref5`,0),0) AS `rec_qty`,round(round(coalesce(`store_in`.`ref5`,0),2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2),0) AS `balance` from (`store_in` join `sticker_report`) where `store_in`.`lot_no` = `sticker_report`.`lot_no` and round(coalesce(`store_in`.`ref5`,0),2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2) > 0 and `sticker_report`.`product_group` like '%fabric%')$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fabric_status_v2` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`inv_no` AS `inv_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`store_in`.`ref4` AS `shade`,`store_in`.`allotment_status` AS `allotment_status`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,if(octet_length(`store_in`.`ref3`) > 0 and `store_in`.`ref3` <> 0,`store_in`.`ref3`,`store_in`.`ref6`) AS `width`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round(round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2),2)),2) AS `balance` from (`store_in` join `sticker_report`) where `store_in`.`lot_no` = `sticker_report`.`lot_no` and round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2) > 0 and `sticker_report`.`product_group` like '%fabric%' and `store_in`.`allotment_status` in (0,1) and octet_length(`store_in`.`ref4`) > 0 group by `store_in`.`tid`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `fabric_status_v3` AS (select `store_in`.`ref1` AS `ref1`,group_concat(distinct `store_in`.`lot_no` separator ',') AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`inv_no` AS `inv_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,`store_in`.`qty_allocated` AS `qty_allocated`,`store_in`.`partial_appr_qty` AS `partial_appr_qty`,`store_in`.`ref4` AS `shade`,`store_in`.`allotment_status` AS `allotment_status`,`store_in`.`roll_status` AS `roll_status`,`store_in`.`shrinkage_length` AS `shrinkage_length`,`store_in`.`shrinkage_width` AS `shrinkage_width`,`store_in`.`shrinkage_group` AS `shrinkage_group`,`store_in`.`roll_status` AS `roll_remarks`,`sticker_report`.`product_group` AS `product_group`,`sticker_report`.`allocated_qty` AS `allocated_qty`,if(octet_length(`store_in`.`ref3`) > 0 and `store_in`.`ref3` <> 0,`store_in`.`ref3`,`store_in`.`ref6`) AS `width`,round(sum(`store_in`.`qty_rec`),2) AS `rec_qty`,round(sum(round(round(`store_in`.`qty_rec`,2) - round(`store_in`.`partial_appr_qty`,2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2),2)),2) AS `balance` from (`store_in` join `sticker_report`) where `sticker_report`.`product_group` like '%fabric%' and round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2) > 0 and `store_in`.`allotment_status` in (0,1,2) and `store_in`.`lot_no` = `sticker_report`.`lot_no` and `store_in`.`roll_status` in (0,2) group by `store_in`.`tid`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `grn_track_pendings` AS (select trim(`sticker_report`.`product_group`) AS `product`,`sticker_report`.`lot_no` AS `lot_no`,`sticker_report`.`rec_qty` AS `grn_qty`,coalesce(sum(`store_in`.`qty_rec`),0) AS `qty_rec`,round(`sticker_report`.`rec_qty`,2) - coalesce(sum(round(`store_in`.`qty_rec`,2)),0) AS `qty_diff`,if(round(`sticker_report`.`rec_qty`,2) - coalesce(sum(round(`store_in`.`qty_rec`,2)),0) >= 1,1,0) AS `label_pending`,cast(`sticker_report`.`grn_date` as date) AS `date`,sum(if(`store_in`.`ref4` = '' and trim(`sticker_report`.`product_group`) = 'Fabric',1,0)) AS `shade_pending`,sum(if(`store_in`.`ref1` = '',1,0)) AS `location_pending`,sum(round(`store_in`.`qty_rec`,2)) - sum(round(`store_in`.`qty_issued`,2)) + sum(round(`store_in`.`qty_ret`,2)) AS `balance`,if(octet_length(`store_in`.`ref3`) <= 1 and trim(`sticker_report`.`product_group`) = 'Fabric',1,0) AS `ctax_pending`,replace(replace(group_concat(if(octet_length(`store_in`.`ref3`) <= 1 and trim(`sticker_report`.`product_group`) = 'Fabric',concat(`store_in`.`ref2`,'@',`store_in`.`ref1`),'x') separator ','),'x,',''),'x','') AS `ctax_pending_rolls` from (`sticker_report` left join `store_in` on(`sticker_report`.`lot_no` = `store_in`.`lot_no`)) where cast(`sticker_report`.`grn_date` as date) > '2011-09-1' and `sticker_report`.`backup_status` = 0 group by `sticker_report`.`lot_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `sticker_ref` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`sticker_report`.`inv_no` AS `inv_no`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`store_in`.`ref4` AS `ref4`,`store_in`.`ref5` AS `ref5`,`store_in`.`ref6` AS `ref6`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret` from (`store_in` join `sticker_report`) where `store_in`.`lot_no` = `sticker_report`.`lot_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `stock_report` AS (select `store_in`.`ref1` AS `ref1`,`store_in`.`lot_no` AS `lot_no`,`sticker_report`.`batch_no` AS `batch_no`,`sticker_report`.`item_desc` AS `item_desc`,`sticker_report`.`item_name` AS `item_name`,`sticker_report`.`item` AS `item`,`sticker_report`.`supplier` AS `supplier`,`sticker_report`.`buyer` AS `buyer`,`store_in`.`ref2` AS `ref2`,`store_in`.`ref3` AS `ref3`,`sticker_report`.`pkg_no` AS `pkg_no`,`store_in`.`status` AS `status`,`sticker_report`.`grn_date` AS `grn_date`,`store_in`.`remarks` AS `remarks`,`store_in`.`tid` AS `tid`,`store_in`.`qty_rec` AS `qty_rec`,`store_in`.`qty_issued` AS `qty_issued`,`store_in`.`qty_ret` AS `qty_ret`,round(round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2),2) AS `balance`,`sticker_report`.`product_group` AS `product_group` from (`store_in` join `sticker_report`) where `store_in`.`lot_no` = `sticker_report`.`lot_no` and round(`store_in`.`qty_rec`,2) - round(`store_in`.`qty_issued`,2) + round(`store_in`.`qty_ret`,2) > 0)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `store_in_weekly_backup` AS (select `sticker_report`.`lot_no` AS `lot_no`,sum(`store_in`.`qty_rec`) AS `sticker_qty`,round(sum(`sticker_report`.`rec_qty`),2) AS `grn_qty`,sum(`store_in`.`qty_rec`) AS `Recieved_Qty`,sum(`store_in`.`qty_ret`) AS `Returned_Qty`,sum(`store_in`.`qty_issued`) AS `Issued_Qty`,sum(`store_in`.`qty_rec`) + sum(`store_in`.`qty_ret`) - sum(`store_in`.`qty_issued`) AS `Available_Qty` from (`store_in` left join `sticker_report` on(`store_in`.`lot_no` = `sticker_report`.`lot_no`)) where `store_in`.`date` < curdate() + interval -15 day group by trim(`store_in`.`lot_no`) having sum(`store_in`.`qty_rec`) + sum(`store_in`.`qty_ret`) - sum(`store_in`.`qty_issued`) = 0)$$
DELIMITER ;

/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_roll_id_fab_scan_status`$$
CREATE FUNCTION `fn_roll_id_fab_scan_status`(doc_id BIGINT,doc_type VARCHAR(15), roll_id BIGINT) RETURNS int(11)
BEGIN
DECLARE doc_prf_str VARCHAR(1);
    DECLARE ret_val INT;
    
	IF doc_type='normal' THEN
		SET ret_val=COALESCE((SELECT IF(fabric_status='5' OR act_cut_status='DONE',1,0) FROM bai_pro3.plandoc_stat_log WHERE doc_no=doc_id),0);
		SET ret_val=ret_val+COALESCE((SELECT COUNT(tid) FROM bai_rm_pj1.store_out WHERE tran_tid=roll_id AND UCASE(cutno) IN (CONCAT('D',doc_id),CONCAT('E',doc_id))),0);
	ELSE
		SET ret_val=COALESCE((SELECT IF(fabric_status='5' OR act_cut_status='DONE',1,0) FROM bai_pro3.recut_v2 WHERE doc_no=doc_id),0);
		SET ret_val=ret_val+COALESCE((SELECT COUNT(tid) FROM bai_rm_pj1.store_out WHERE tran_tid=roll_id AND UCASE(cutno)=CONCAT('R',doc_id)),0);
	END IF;
	
	/* return 1 if the docket or recut status is fabric issued or cut completed or available in scan out transaction.*/
	IF ret_val>0 THEN
		RETURN 1;
	ELSE
		RETURN 0;
	END IF;
END$$
DELIMITER ;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `bai3_finishing`;
/*  Alter Procedure in target  */

DELIMITER $$
DROP PROCEDURE IF EXISTS `sync_fg_to_m3`$$
CREATE PROCEDURE `sync_fg_to_m3`()
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
	
    END$$
DELIMITER ;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `brandix_bts`;

/* Alter table in target */
ALTER TABLE `bundle_creation_data` 
	CHANGE `date_time` `date_time` timestamp   NOT NULL DEFAULT current_timestamp() after `id` , 
	ADD COLUMN `barcode_sequence` int(11)   NULL after `mapped_color` , 
	ADD COLUMN `barcode_number` int(11)   NULL after `barcode_sequence` , 
	ADD KEY `barcode_number`(`barcode_number`) , 
	ADD KEY `input_job_op_code`(`input_job_no_random_ref`,`operation_id`) ;

/* Alter table in target */
ALTER TABLE `bundle_creation_data_temp` 
	CHANGE `date_time` `date_time` timestamp   NOT NULL DEFAULT current_timestamp() after `id` , 
	ADD KEY `input_mod_remark`(`input_job_no_random_ref`,`operation_id`,`assigned_module`,`color`,`size_title`) ;


/* Create table in target */
CREATE TABLE `default_operation_workflow`(
	`id` int(50) NOT NULL  auto_increment , 
	`operation_name` int(11) NOT NULL  , 
	`operation_code` int(11) NOT NULL  , 
	`operation_order` varchar(250) COLLATE latin1_swedish_ci NOT NULL  , 
	`default_operration` varchar(250) COLLATE latin1_swedish_ci NOT NULL  , 
	`ops_sequence` int(11) NOT NULL  , 
	`ops_dependency` int(11) NULL  , 
	`component` varchar(250) COLLATE latin1_swedish_ci NULL  , 
	`barcode` varchar(50) COLLATE latin1_swedish_ci NOT NULL  DEFAULT 'yes' , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';

/* Create table in target */
CREATE TABLE `ops_short_cuts`(
	`id` int(11) NOT NULL  auto_increment , 
	`short_key_code` varchar(20) COLLATE latin1_swedish_ci NULL  , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `parent_work_center_id`(
	`id` int(11) NOT NULL  auto_increment , 
	`work_center_id_name` varchar(50) COLLATE latin1_swedish_ci NULL  , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';

/* Alter table in target */
ALTER TABLE `snap_session_track` 
	CHANGE `time_stamp` `time_stamp` timestamp   NULL on update current_timestamp() after `session_id` ;

/* Alter table in target */
ALTER TABLE `tbl_miniorder_data` 
	CHANGE `size_tit` `size_tit` varchar(255)  COLLATE utf8_general_ci NULL COMMENT 'size title' after `size_ref` ;

/* Alter table in target */
ALTER TABLE `tbl_orders_ops_ref` 
	ADD COLUMN `short_cut_code` varchar(50)  COLLATE utf8_general_ci NULL after `type` , 
	ADD COLUMN `work_center_id` varchar(250)  COLLATE utf8_general_ci NULL after `short_cut_code` , 
	ADD COLUMN `category` varchar(250)  COLLATE utf8_general_ci NULL after `work_center_id` , 
	ADD COLUMN `parent_work_center_id` varchar(50)  COLLATE utf8_general_ci NULL after `category` ;

/* Alter table in target */
ALTER TABLE `tbl_style_ops_master` 
	CHANGE `operation_order` `operation_order` varchar(250)  COLLATE utf8_general_ci NULL after `operation_name` ;

/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_bund_tran_master` AS (select `bundle_transactions_20_repeat`.`parent_id` AS `parent_id`,`bundle_transactions_20_repeat`.`bundle_id` AS `bundle_id`,`tbl_miniorder_data`.`id` AS `id`,`tbl_orders_ops_ref`.`operation_name` AS `operation_name`,`tbl_orders_ops_ref`.`operation_code` AS `operation_code`,`bundle_transactions`.`date_time` AS `date_time`,`bundle_transactions_20_repeat`.`bundle_barcode` AS `bundle_barcode`,`bundle_transactions_20_repeat`.`quantity` AS `quantity`,`bundle_transactions_20_repeat`.`rejection_quantity` AS `rejection_quantity`,`bundle_transactions_20_repeat`.`operation_id` AS `operation_id`,`bundle_transactions`.`module_id` AS `module_id`,`tbl_shifts_master`.`shift_name` AS `shift_name` from ((((`bundle_transactions_20_repeat` left join `tbl_orders_ops_ref` on(`bundle_transactions_20_repeat`.`operation_id` = `tbl_orders_ops_ref`.`id`)) left join `bundle_transactions` on(`bundle_transactions_20_repeat`.`parent_id` = `bundle_transactions`.`id`)) left join `tbl_shifts_master` on(`bundle_transactions`.`shift` = `tbl_shifts_master`.`id`)) left join `tbl_miniorder_data` on(`bundle_transactions_20_repeat`.`bundle_id` = `tbl_miniorder_data`.`bundle_number`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_extra_cut` AS (select `order_cat_doc_mk_mix`.`catyy` AS `catyy`,`order_cat_doc_mk_mix`.`cat_patt_ver` AS `cat_patt_ver`,`order_cat_doc_mk_mix`.`mk_file` AS `mk_file`,`order_cat_doc_mk_mix`.`mk_ver` AS `mk_ver`,`order_cat_doc_mk_mix`.`mklength` AS `mklength`,`order_cat_doc_mk_mix`.`style_id` AS `style_id`,`order_cat_doc_mk_mix`.`col_des` AS `col_des`,`order_cat_doc_mk_mix`.`gmtway` AS `gmtway`,`order_cat_doc_mk_mix`.`strip_match` AS `strip_match`,`order_cat_doc_mk_mix`.`fab_des` AS `fab_des`,`order_cat_doc_mk_mix`.`clubbing` AS `clubbing`,`order_cat_doc_mk_mix`.`date` AS `date`,`order_cat_doc_mk_mix`.`cat_ref` AS `cat_ref`,`order_cat_doc_mk_mix`.`compo_no` AS `compo_no`,`order_cat_doc_mk_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_doc_mk_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_doc_mk_mix`.`mk_ref` AS `mk_ref`,`order_cat_doc_mk_mix`.`order_tid` AS `order_tid`,`order_cat_doc_mk_mix`.`pcutno` AS `pcutno`,`order_cat_doc_mk_mix`.`ratio` AS `ratio`,`order_cat_doc_mk_mix`.`p_xs` AS `p_xs`,`order_cat_doc_mk_mix`.`p_s` AS `p_s`,`order_cat_doc_mk_mix`.`p_m` AS `p_m`,`order_cat_doc_mk_mix`.`p_l` AS `p_l`,`order_cat_doc_mk_mix`.`p_xl` AS `p_xl`,`order_cat_doc_mk_mix`.`p_xxl` AS `p_xxl`,`order_cat_doc_mk_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_doc_mk_mix`.`p_plies` AS `p_plies`,`order_cat_doc_mk_mix`.`doc_no` AS `doc_no`,`order_cat_doc_mk_mix`.`acutno` AS `acutno`,`order_cat_doc_mk_mix`.`a_xs` AS `a_xs`,`order_cat_doc_mk_mix`.`a_s` AS `a_s`,`order_cat_doc_mk_mix`.`a_m` AS `a_m`,`order_cat_doc_mk_mix`.`a_l` AS `a_l`,`order_cat_doc_mk_mix`.`a_xl` AS `a_xl`,`order_cat_doc_mk_mix`.`a_xxl` AS `a_xxl`,`order_cat_doc_mk_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_doc_mk_mix`.`a_plies` AS `a_plies`,`order_cat_doc_mk_mix`.`lastup` AS `lastup`,`order_cat_doc_mk_mix`.`remarks` AS `remarks`,`order_cat_doc_mk_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_doc_mk_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_doc_mk_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_doc_mk_mix`.`print_status` AS `print_status`,`order_cat_doc_mk_mix`.`a_s01` AS `a_s01`,`order_cat_doc_mk_mix`.`a_s02` AS `a_s02`,`order_cat_doc_mk_mix`.`a_s03` AS `a_s03`,`order_cat_doc_mk_mix`.`a_s04` AS `a_s04`,`order_cat_doc_mk_mix`.`a_s05` AS `a_s05`,`order_cat_doc_mk_mix`.`a_s06` AS `a_s06`,`order_cat_doc_mk_mix`.`a_s07` AS `a_s07`,`order_cat_doc_mk_mix`.`a_s08` AS `a_s08`,`order_cat_doc_mk_mix`.`a_s09` AS `a_s09`,`order_cat_doc_mk_mix`.`a_s10` AS `a_s10`,`order_cat_doc_mk_mix`.`a_s11` AS `a_s11`,`order_cat_doc_mk_mix`.`a_s12` AS `a_s12`,`order_cat_doc_mk_mix`.`a_s13` AS `a_s13`,`order_cat_doc_mk_mix`.`a_s14` AS `a_s14`,`order_cat_doc_mk_mix`.`a_s15` AS `a_s15`,`order_cat_doc_mk_mix`.`a_s16` AS `a_s16`,`order_cat_doc_mk_mix`.`a_s17` AS `a_s17`,`order_cat_doc_mk_mix`.`a_s18` AS `a_s18`,`order_cat_doc_mk_mix`.`a_s19` AS `a_s19`,`order_cat_doc_mk_mix`.`a_s20` AS `a_s20`,`order_cat_doc_mk_mix`.`a_s21` AS `a_s21`,`order_cat_doc_mk_mix`.`a_s22` AS `a_s22`,`order_cat_doc_mk_mix`.`a_s23` AS `a_s23`,`order_cat_doc_mk_mix`.`a_s24` AS `a_s24`,`order_cat_doc_mk_mix`.`a_s25` AS `a_s25`,`order_cat_doc_mk_mix`.`a_s26` AS `a_s26`,`order_cat_doc_mk_mix`.`a_s27` AS `a_s27`,`order_cat_doc_mk_mix`.`a_s28` AS `a_s28`,`order_cat_doc_mk_mix`.`a_s29` AS `a_s29`,`order_cat_doc_mk_mix`.`a_s30` AS `a_s30`,`order_cat_doc_mk_mix`.`a_s31` AS `a_s31`,`order_cat_doc_mk_mix`.`a_s32` AS `a_s32`,`order_cat_doc_mk_mix`.`a_s33` AS `a_s33`,`order_cat_doc_mk_mix`.`a_s34` AS `a_s34`,`order_cat_doc_mk_mix`.`a_s35` AS `a_s35`,`order_cat_doc_mk_mix`.`a_s36` AS `a_s36`,`order_cat_doc_mk_mix`.`a_s37` AS `a_s37`,`order_cat_doc_mk_mix`.`a_s38` AS `a_s38`,`order_cat_doc_mk_mix`.`a_s39` AS `a_s39`,`order_cat_doc_mk_mix`.`a_s40` AS `a_s40`,`order_cat_doc_mk_mix`.`a_s41` AS `a_s41`,`order_cat_doc_mk_mix`.`a_s42` AS `a_s42`,`order_cat_doc_mk_mix`.`a_s43` AS `a_s43`,`order_cat_doc_mk_mix`.`a_s44` AS `a_s44`,`order_cat_doc_mk_mix`.`a_s45` AS `a_s45`,`order_cat_doc_mk_mix`.`a_s46` AS `a_s46`,`order_cat_doc_mk_mix`.`a_s47` AS `a_s47`,`order_cat_doc_mk_mix`.`a_s48` AS `a_s48`,`order_cat_doc_mk_mix`.`a_s49` AS `a_s49`,`order_cat_doc_mk_mix`.`a_s50` AS `a_s50`,`order_cat_doc_mk_mix`.`p_s01` AS `p_s01`,`order_cat_doc_mk_mix`.`p_s02` AS `p_s02`,`order_cat_doc_mk_mix`.`p_s03` AS `p_s03`,`order_cat_doc_mk_mix`.`p_s04` AS `p_s04`,`order_cat_doc_mk_mix`.`p_s05` AS `p_s05`,`order_cat_doc_mk_mix`.`p_s06` AS `p_s06`,`order_cat_doc_mk_mix`.`p_s07` AS `p_s07`,`order_cat_doc_mk_mix`.`p_s08` AS `p_s08`,`order_cat_doc_mk_mix`.`p_s09` AS `p_s09`,`order_cat_doc_mk_mix`.`p_s10` AS `p_s10`,`order_cat_doc_mk_mix`.`p_s11` AS `p_s11`,`order_cat_doc_mk_mix`.`p_s12` AS `p_s12`,`order_cat_doc_mk_mix`.`p_s13` AS `p_s13`,`order_cat_doc_mk_mix`.`p_s14` AS `p_s14`,`order_cat_doc_mk_mix`.`p_s15` AS `p_s15`,`order_cat_doc_mk_mix`.`p_s16` AS `p_s16`,`order_cat_doc_mk_mix`.`p_s17` AS `p_s17`,`order_cat_doc_mk_mix`.`p_s18` AS `p_s18`,`order_cat_doc_mk_mix`.`p_s19` AS `p_s19`,`order_cat_doc_mk_mix`.`p_s20` AS `p_s20`,`order_cat_doc_mk_mix`.`p_s21` AS `p_s21`,`order_cat_doc_mk_mix`.`p_s22` AS `p_s22`,`order_cat_doc_mk_mix`.`p_s23` AS `p_s23`,`order_cat_doc_mk_mix`.`p_s24` AS `p_s24`,`order_cat_doc_mk_mix`.`p_s25` AS `p_s25`,`order_cat_doc_mk_mix`.`p_s26` AS `p_s26`,`order_cat_doc_mk_mix`.`p_s27` AS `p_s27`,`order_cat_doc_mk_mix`.`p_s28` AS `p_s28`,`order_cat_doc_mk_mix`.`p_s29` AS `p_s29`,`order_cat_doc_mk_mix`.`p_s30` AS `p_s30`,`order_cat_doc_mk_mix`.`p_s31` AS `p_s31`,`order_cat_doc_mk_mix`.`p_s32` AS `p_s32`,`order_cat_doc_mk_mix`.`p_s33` AS `p_s33`,`order_cat_doc_mk_mix`.`p_s34` AS `p_s34`,`order_cat_doc_mk_mix`.`p_s35` AS `p_s35`,`order_cat_doc_mk_mix`.`p_s36` AS `p_s36`,`order_cat_doc_mk_mix`.`p_s37` AS `p_s37`,`order_cat_doc_mk_mix`.`p_s38` AS `p_s38`,`order_cat_doc_mk_mix`.`p_s39` AS `p_s39`,`order_cat_doc_mk_mix`.`p_s40` AS `p_s40`,`order_cat_doc_mk_mix`.`p_s41` AS `p_s41`,`order_cat_doc_mk_mix`.`p_s42` AS `p_s42`,`order_cat_doc_mk_mix`.`p_s43` AS `p_s43`,`order_cat_doc_mk_mix`.`p_s44` AS `p_s44`,`order_cat_doc_mk_mix`.`p_s45` AS `p_s45`,`order_cat_doc_mk_mix`.`p_s46` AS `p_s46`,`order_cat_doc_mk_mix`.`p_s47` AS `p_s47`,`order_cat_doc_mk_mix`.`p_s48` AS `p_s48`,`order_cat_doc_mk_mix`.`p_s49` AS `p_s49`,`order_cat_doc_mk_mix`.`p_s50` AS `p_s50`,`order_cat_doc_mk_mix`.`rm_date` AS `rm_date`,`order_cat_doc_mk_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_doc_mk_mix`.`plan_module` AS `plan_module`,`order_cat_doc_mk_mix`.`category` AS `category`,`order_cat_doc_mk_mix`.`color_code` AS `color_code`,`order_cat_doc_mk_mix`.`fabric_status` AS `fabric_status`,`order_cat_doc_mk_mix`.`material_req` AS `material_req`,`order_cat_doc_mk_mix`.`order_del_no` AS `order_del_no`,`order_cat_doc_mk_mix`.`order_col_des` AS `order_col_des` from (`bai_pro3`.`order_cat_doc_mk_mix` left join `brandix_bts`.`tbl_cut_master` on(`brandix_bts`.`tbl_cut_master`.`doc_num` = `order_cat_doc_mk_mix`.`doc_no`)) where `order_cat_doc_mk_mix`.`category` in ('Body','Front') and octet_length(`order_cat_doc_mk_mix`.`order_del_no`) < '8' and `order_cat_doc_mk_mix`.`style_id` not in (74029,23923,74026,73927) and `brandix_bts`.`tbl_cut_master`.`id` is null and `order_cat_doc_mk_mix`.`order_del_no` in (select `brandix_bts`.`tbl_orders_master`.`product_schedule` from `brandix_bts`.`tbl_orders_master`))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_extra_recut` AS (select `order_cat_recut_doc_mix`.`date` AS `date`,`order_cat_recut_doc_mix`.`cat_ref` AS `cat_ref`,`order_cat_recut_doc_mix`.`cuttable_ref` AS `cuttable_ref`,`order_cat_recut_doc_mix`.`allocate_ref` AS `allocate_ref`,`order_cat_recut_doc_mix`.`mk_ref` AS `mk_ref`,`order_cat_recut_doc_mix`.`order_tid` AS `order_tid`,`order_cat_recut_doc_mix`.`pcutno` AS `pcutno`,`order_cat_recut_doc_mix`.`ratio` AS `ratio`,`order_cat_recut_doc_mix`.`p_xs` AS `p_xs`,`order_cat_recut_doc_mix`.`p_s` AS `p_s`,`order_cat_recut_doc_mix`.`p_m` AS `p_m`,`order_cat_recut_doc_mix`.`p_l` AS `p_l`,`order_cat_recut_doc_mix`.`p_xl` AS `p_xl`,`order_cat_recut_doc_mix`.`p_xxl` AS `p_xxl`,`order_cat_recut_doc_mix`.`p_xxxl` AS `p_xxxl`,`order_cat_recut_doc_mix`.`p_plies` AS `p_plies`,concat('R',`order_cat_recut_doc_mix`.`doc_no`) AS `doc_no`,`order_cat_recut_doc_mix`.`acutno` AS `acutno`,`order_cat_recut_doc_mix`.`a_xs` AS `a_xs`,`order_cat_recut_doc_mix`.`a_s` AS `a_s`,`order_cat_recut_doc_mix`.`a_m` AS `a_m`,`order_cat_recut_doc_mix`.`a_l` AS `a_l`,`order_cat_recut_doc_mix`.`a_xl` AS `a_xl`,`order_cat_recut_doc_mix`.`a_xxl` AS `a_xxl`,`order_cat_recut_doc_mix`.`a_xxxl` AS `a_xxxl`,`order_cat_recut_doc_mix`.`a_plies` AS `a_plies`,`order_cat_recut_doc_mix`.`lastup` AS `lastup`,`order_cat_recut_doc_mix`.`remarks` AS `remarks`,`order_cat_recut_doc_mix`.`act_cut_status` AS `act_cut_status`,`order_cat_recut_doc_mix`.`act_cut_issue_status` AS `act_cut_issue_status`,`order_cat_recut_doc_mix`.`pcutdocid` AS `pcutdocid`,`order_cat_recut_doc_mix`.`print_status` AS `print_status`,`order_cat_recut_doc_mix`.`a_s01` AS `a_s01`,`order_cat_recut_doc_mix`.`a_s02` AS `a_s02`,`order_cat_recut_doc_mix`.`a_s03` AS `a_s03`,`order_cat_recut_doc_mix`.`a_s04` AS `a_s04`,`order_cat_recut_doc_mix`.`a_s05` AS `a_s05`,`order_cat_recut_doc_mix`.`a_s06` AS `a_s06`,`order_cat_recut_doc_mix`.`a_s07` AS `a_s07`,`order_cat_recut_doc_mix`.`a_s08` AS `a_s08`,`order_cat_recut_doc_mix`.`a_s09` AS `a_s09`,`order_cat_recut_doc_mix`.`a_s10` AS `a_s10`,`order_cat_recut_doc_mix`.`a_s11` AS `a_s11`,`order_cat_recut_doc_mix`.`a_s12` AS `a_s12`,`order_cat_recut_doc_mix`.`a_s13` AS `a_s13`,`order_cat_recut_doc_mix`.`a_s14` AS `a_s14`,`order_cat_recut_doc_mix`.`a_s15` AS `a_s15`,`order_cat_recut_doc_mix`.`a_s16` AS `a_s16`,`order_cat_recut_doc_mix`.`a_s17` AS `a_s17`,`order_cat_recut_doc_mix`.`a_s18` AS `a_s18`,`order_cat_recut_doc_mix`.`a_s19` AS `a_s19`,`order_cat_recut_doc_mix`.`a_s20` AS `a_s20`,`order_cat_recut_doc_mix`.`a_s21` AS `a_s21`,`order_cat_recut_doc_mix`.`a_s22` AS `a_s22`,`order_cat_recut_doc_mix`.`a_s23` AS `a_s23`,`order_cat_recut_doc_mix`.`a_s24` AS `a_s24`,`order_cat_recut_doc_mix`.`a_s25` AS `a_s25`,`order_cat_recut_doc_mix`.`a_s26` AS `a_s26`,`order_cat_recut_doc_mix`.`a_s27` AS `a_s27`,`order_cat_recut_doc_mix`.`a_s28` AS `a_s28`,`order_cat_recut_doc_mix`.`a_s29` AS `a_s29`,`order_cat_recut_doc_mix`.`a_s30` AS `a_s30`,`order_cat_recut_doc_mix`.`a_s31` AS `a_s31`,`order_cat_recut_doc_mix`.`a_s32` AS `a_s32`,`order_cat_recut_doc_mix`.`a_s33` AS `a_s33`,`order_cat_recut_doc_mix`.`a_s34` AS `a_s34`,`order_cat_recut_doc_mix`.`a_s35` AS `a_s35`,`order_cat_recut_doc_mix`.`a_s36` AS `a_s36`,`order_cat_recut_doc_mix`.`a_s37` AS `a_s37`,`order_cat_recut_doc_mix`.`a_s38` AS `a_s38`,`order_cat_recut_doc_mix`.`a_s39` AS `a_s39`,`order_cat_recut_doc_mix`.`a_s40` AS `a_s40`,`order_cat_recut_doc_mix`.`a_s41` AS `a_s41`,`order_cat_recut_doc_mix`.`a_s42` AS `a_s42`,`order_cat_recut_doc_mix`.`a_s43` AS `a_s43`,`order_cat_recut_doc_mix`.`a_s44` AS `a_s44`,`order_cat_recut_doc_mix`.`a_s45` AS `a_s45`,`order_cat_recut_doc_mix`.`a_s46` AS `a_s46`,`order_cat_recut_doc_mix`.`a_s47` AS `a_s47`,`order_cat_recut_doc_mix`.`a_s48` AS `a_s48`,`order_cat_recut_doc_mix`.`a_s49` AS `a_s49`,`order_cat_recut_doc_mix`.`a_s50` AS `a_s50`,`order_cat_recut_doc_mix`.`p_s01` AS `p_s01`,`order_cat_recut_doc_mix`.`p_s02` AS `p_s02`,`order_cat_recut_doc_mix`.`p_s03` AS `p_s03`,`order_cat_recut_doc_mix`.`p_s04` AS `p_s04`,`order_cat_recut_doc_mix`.`p_s05` AS `p_s05`,`order_cat_recut_doc_mix`.`p_s06` AS `p_s06`,`order_cat_recut_doc_mix`.`p_s07` AS `p_s07`,`order_cat_recut_doc_mix`.`p_s08` AS `p_s08`,`order_cat_recut_doc_mix`.`p_s09` AS `p_s09`,`order_cat_recut_doc_mix`.`p_s10` AS `p_s10`,`order_cat_recut_doc_mix`.`p_s11` AS `p_s11`,`order_cat_recut_doc_mix`.`p_s12` AS `p_s12`,`order_cat_recut_doc_mix`.`p_s13` AS `p_s13`,`order_cat_recut_doc_mix`.`p_s14` AS `p_s14`,`order_cat_recut_doc_mix`.`p_s15` AS `p_s15`,`order_cat_recut_doc_mix`.`p_s16` AS `p_s16`,`order_cat_recut_doc_mix`.`p_s17` AS `p_s17`,`order_cat_recut_doc_mix`.`p_s18` AS `p_s18`,`order_cat_recut_doc_mix`.`p_s19` AS `p_s19`,`order_cat_recut_doc_mix`.`p_s20` AS `p_s20`,`order_cat_recut_doc_mix`.`p_s21` AS `p_s21`,`order_cat_recut_doc_mix`.`p_s22` AS `p_s22`,`order_cat_recut_doc_mix`.`p_s23` AS `p_s23`,`order_cat_recut_doc_mix`.`p_s24` AS `p_s24`,`order_cat_recut_doc_mix`.`p_s25` AS `p_s25`,`order_cat_recut_doc_mix`.`p_s26` AS `p_s26`,`order_cat_recut_doc_mix`.`p_s27` AS `p_s27`,`order_cat_recut_doc_mix`.`p_s28` AS `p_s28`,`order_cat_recut_doc_mix`.`p_s29` AS `p_s29`,`order_cat_recut_doc_mix`.`p_s30` AS `p_s30`,`order_cat_recut_doc_mix`.`p_s31` AS `p_s31`,`order_cat_recut_doc_mix`.`p_s32` AS `p_s32`,`order_cat_recut_doc_mix`.`p_s33` AS `p_s33`,`order_cat_recut_doc_mix`.`p_s34` AS `p_s34`,`order_cat_recut_doc_mix`.`p_s35` AS `p_s35`,`order_cat_recut_doc_mix`.`p_s36` AS `p_s36`,`order_cat_recut_doc_mix`.`p_s37` AS `p_s37`,`order_cat_recut_doc_mix`.`p_s38` AS `p_s38`,`order_cat_recut_doc_mix`.`p_s39` AS `p_s39`,`order_cat_recut_doc_mix`.`p_s40` AS `p_s40`,`order_cat_recut_doc_mix`.`p_s41` AS `p_s41`,`order_cat_recut_doc_mix`.`p_s42` AS `p_s42`,`order_cat_recut_doc_mix`.`p_s43` AS `p_s43`,`order_cat_recut_doc_mix`.`p_s44` AS `p_s44`,`order_cat_recut_doc_mix`.`p_s45` AS `p_s45`,`order_cat_recut_doc_mix`.`p_s46` AS `p_s46`,`order_cat_recut_doc_mix`.`p_s47` AS `p_s47`,`order_cat_recut_doc_mix`.`p_s48` AS `p_s48`,`order_cat_recut_doc_mix`.`p_s49` AS `p_s49`,`order_cat_recut_doc_mix`.`p_s50` AS `p_s50`,`order_cat_recut_doc_mix`.`rm_date` AS `rm_date`,`order_cat_recut_doc_mix`.`cut_inp_temp` AS `cut_inp_temp`,`order_cat_recut_doc_mix`.`plan_module` AS `plan_module`,`order_cat_recut_doc_mix`.`category` AS `category`,`order_cat_recut_doc_mix`.`color_code` AS `color_code`,`order_cat_recut_doc_mix`.`fabric_status` AS `fabric_status`,`order_cat_recut_doc_mix`.`order_del_no` AS `order_del_no`,`order_cat_recut_doc_mix`.`plan_lot_ref` AS `plan_lot_ref`,`order_cat_recut_doc_mix`.`order_col_des` AS `order_col_des`,`order_cat_recut_doc_mix`.`order_style_no` AS `order_style_no` from (`bai_pro3`.`order_cat_recut_doc_mix` left join `brandix_bts`.`tbl_cut_master` on(`brandix_bts`.`tbl_cut_master`.`doc_num` = concat('R',`order_cat_recut_doc_mix`.`doc_no`))) where `order_cat_recut_doc_mix`.`category` in ('Body','Front') and `order_cat_recut_doc_mix`.`act_cut_status` = 'DONE' and `brandix_bts`.`tbl_cut_master`.`id` is null and `order_cat_recut_doc_mix`.`order_del_no` in (select `brandix_bts`.`tbl_orders_master`.`product_schedule` from `brandix_bts`.`tbl_orders_master`))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_1` AS (select `bundle_transactions_20_repeat`.`id` AS `bundle_transactions_20_repeat_id`,`bundle_transactions_20_repeat`.`parent_id` AS `bundle_transactions_20_repeat_parent_id`,`bundle_transactions_20_repeat`.`bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,`bundle_transactions_20_repeat`.`quantity` AS `bundle_transactions_20_repeat_quantity`,`bundle_transactions_20_repeat`.`bundle_id` AS `bundle_transactions_20_repeat_bundle_id`,`bundle_transactions_20_repeat`.`operation_id` AS `bundle_transactions_20_repeat_operation_id`,`bundle_transactions_20_repeat`.`rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,if(`bundle_transactions_20_repeat`.`act_module` > 0,`bundle_transactions_20_repeat`.`act_module`,`bundle_transactions`.`module_id`) AS `bundle_transactions_20_repeat_act_module`,`tbl_orders_ops_ref`.`id` AS `tbl_orders_ops_ref_id`,`tbl_orders_ops_ref`.`operation_name` AS `tbl_orders_ops_ref_operation_name`,`tbl_orders_ops_ref`.`default_operation` AS `tbl_orders_ops_ref_default_operation`,`tbl_orders_ops_ref`.`operation_code` AS `tbl_orders_ops_ref_operation_code`,`bundle_transactions`.`id` AS `bundle_transactions_id`,`bundle_transactions`.`date_time` AS `bundle_transactions_date_time`,`bundle_transactions`.`operation_time` AS `bundle_transactions_operation_time`,`bundle_transactions`.`employee_id` AS `bundle_transactions_employee_id`,`bundle_transactions`.`shift` AS `bundle_transactions_shift`,`bundle_transactions`.`trans_status` AS `bundle_transactions_trans_status`,`bundle_transactions`.`module_id` AS `bundle_transactions_module_id`,`tbl_shifts_master`.`id` AS `tbl_shifts_master_id`,`tbl_shifts_master`.`date_time` AS `tbl_shifts_master_date_time`,`tbl_shifts_master`.`shift_name` AS `tbl_shifts_master_shift_name` from (((`bundle_transactions_20_repeat` left join `tbl_orders_ops_ref` on(`bundle_transactions_20_repeat`.`operation_id` = `tbl_orders_ops_ref`.`id`)) left join `bundle_transactions` on(`bundle_transactions_20_repeat`.`parent_id` = `bundle_transactions`.`id`)) left join `tbl_shifts_master` on(`tbl_shifts_master`.`id` = `bundle_transactions`.`shift`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_1_virtual` AS (select `bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`id` AS `bundle_transactions_20_repeat_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`parent_id` AS `bundle_transactions_20_repeat_parent_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`quantity` AS `bundle_transactions_20_repeat_quantity`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`bundle_id` AS `bundle_transactions_20_repeat_bundle_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`operation_id` AS `bundle_transactions_20_repeat_operation_id`,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,if(`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`act_module` > 0,`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`act_module`,`bundle_transactions`.`module_id`) AS `bundle_transactions_20_repeat_act_module`,`tbl_orders_ops_ref`.`id` AS `tbl_orders_ops_ref_id`,`tbl_orders_ops_ref`.`operation_name` AS `tbl_orders_ops_ref_operation_name`,`tbl_orders_ops_ref`.`default_operation` AS `tbl_orders_ops_ref_default_operation`,`tbl_orders_ops_ref`.`operation_code` AS `tbl_orders_ops_ref_operation_code`,`bundle_transactions`.`id` AS `bundle_transactions_id`,`bundle_transactions`.`date_time` AS `bundle_transactions_date_time`,`bundle_transactions`.`operation_time` AS `bundle_transactions_operation_time`,`bundle_transactions`.`employee_id` AS `bundle_transactions_employee_id`,`bundle_transactions`.`shift` AS `bundle_transactions_shift`,`bundle_transactions`.`trans_status` AS `bundle_transactions_trans_status`,`bundle_transactions`.`module_id` AS `bundle_transactions_module_id`,`tbl_shifts_master`.`id` AS `tbl_shifts_master_id`,`tbl_shifts_master`.`date_time` AS `tbl_shifts_master_date_time`,`tbl_shifts_master`.`shift_name` AS `tbl_shifts_master_shift_name` from (((`bundle_transactions_20_repeat_virtual_snap_ini_bundles` left join `tbl_orders_ops_ref` on(`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`operation_id` = `tbl_orders_ops_ref`.`id`)) left join `bundle_transactions` on(`bundle_transactions_20_repeat_virtual_snap_ini_bundles`.`parent_id` = `bundle_transactions`.`id`)) left join `tbl_shifts_master` on(`tbl_shifts_master`.`id` = `bundle_transactions`.`shift`)))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_4` AS (select cast(`pacstat`.`scan_date` as date) AS `date`,`orders`.`order_style_no` AS `style`,`orders`.`order_del_no` AS `SCHEDULE`,sum(`pacstat`.`carton_act_qty`) AS `cpk_qty`,concat(cast(`pacstat`.`scan_date` as date),convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8)) AS `order_tid_new` from ((`bai_pro3`.`pac_stat_log` `pacstat` left join `bai_pro3`.`plandoc_stat_log` `plandoc` on(`plandoc`.`doc_no` = `pacstat`.`doc_no`)) left join `bai_pro3`.`bai_orders_db_confirm` `orders` on(`orders`.`order_tid` = `plandoc`.`order_tid`)) where `pacstat`.`status` = 'DONE' group by cast(`pacstat`.`scan_date` as date),`orders`.`order_style_no`,`orders`.`order_del_no`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_5` AS (select `bai_pro3`.`bai_qms_db`.`log_date` AS `log_date`,`bai_pro3`.`bai_qms_db`.`qms_style` AS `qms_style`,`bai_pro3`.`bai_qms_db`.`qms_schedule` AS `qms_schedule`,sum(`bai_pro3`.`bai_qms_db`.`qms_qty`) AS `rejected_qty` from `bai_pro3`.`bai_qms_db` where `bai_pro3`.`bai_qms_db`.`qms_tran_type` in (3,4,5) group by `bai_pro3`.`bai_qms_db`.`log_date`,`bai_pro3`.`bai_qms_db`.`qms_schedule`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_6` AS (select cast(`pacstat`.`scan_date` as date) AS `date`,`orders`.`order_style_no` AS `style`,`orders`.`order_del_no` AS `SCHEDULE`,`orders`.`order_col_des` AS `color`,`orders_mas_size`.`size_title` AS `size`,sum(`pacstat`.`carton_act_qty`) AS `cpk_qty`,concat(convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8),convert(`orders`.`order_col_des` using utf8),`orders_mas_size`.`size_title`) AS `order_tid_new`,1 AS `barcode`,concat(cast(`pacstat`.`scan_date` as date),convert(`orders`.`order_style_no` using utf8),convert(`orders`.`order_del_no` using utf8),convert(`orders`.`order_col_des` using utf8),`orders_mas_size`.`size_title`) AS `order_tid_new_2` from (((((`bai_pro3`.`pac_stat_log` `pacstat` left join `bai_pro3`.`plandoc_stat_log` `plandoc` on(`plandoc`.`doc_no` = `pacstat`.`doc_no`)) left join `bai_pro3`.`bai_orders_db_confirm` `orders` on(`orders`.`order_tid` = `plandoc`.`order_tid`)) left join `brandix_bts`.`tbl_orders_size_ref` `sizes` on(convert(`pacstat`.`size_code` using utf8) = `sizes`.`size_name`)) left join `brandix_bts`.`tbl_orders_master` `orders_mas` on(`orders_mas`.`product_schedule` = convert(`orders`.`order_del_no` using utf8))) left join `brandix_bts`.`tbl_orders_sizes_master` `orders_mas_size` on(`orders_mas_size`.`parent_id` = `orders_mas`.`id`)) where `pacstat`.`status` = 'DONE' and `orders_mas_size`.`order_col_des` = convert(`orders`.`order_col_des` using utf8) and `orders_mas_size`.`ref_size_name` = `sizes`.`id` group by cast(`pacstat`.`scan_date` as date),`orders`.`order_style_no`,`orders`.`order_del_no`,`orders`.`order_col_des`,`orders_mas_size`.`size_title`)$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_set_snap_1` AS (select distinct `view_set_1_snap`.`bundle_transactions_20_repeat_id` AS `bundle_transactions_20_repeat_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_quantity` AS `bundle_transactions_20_repeat_quantity`,`view_set_1_snap`.`bundle_transactions_20_repeat_operation_id` AS `bundle_transactions_20_repeat_operation_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_rejection_quantity` AS `bundle_transactions_20_repeat_rejection_quantity`,`view_set_1_snap`.`tbl_shifts_master_shift_name` AS `tbl_shifts_master_shift_name`,`view_set_1_snap`.`tbl_orders_ops_ref_operation_code` AS `tbl_orders_ops_ref_operation_code`,`view_set_1_snap`.`tbl_orders_ops_ref_operation_name` AS `tbl_orders_ops_ref_operation_name`,`view_set_1_snap`.`bundle_transactions_module_id` AS `bundle_transactions_module_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_act_module` AS `bundle_transactions_20_repeat_act_module`,`view_set_1_snap`.`bundle_transactions_employee_id` AS `bundle_transactions_employee_id`,`view_set_1_snap`.`bundle_transactions_date_time` AS `bundle_transactions_date_time`,`view_set_2_snap`.`tbl_orders_size_ref_size_name` AS `tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title` AS `tbl_orders_sizes_master_size_title`,`view_set_2_snap`.`tbl_orders_sizes_master_order_quantity` AS `tbl_orders_sizes_master_order_quantity`,`view_set_2_snap`.`tbl_orders_style_ref_product_style` AS `tbl_orders_style_ref_product_style`,`view_set_3_snap`.`tbl_miniorder_data_quantity` AS `tbl_miniorder_data_quantity`,`view_set_3_snap`.`tbl_miniorder_data_bundle_number` AS `tbl_miniorder_data_bundle_number`,`view_set_3_snap`.`tbl_miniorder_data_color` AS `tbl_miniorder_data_color`,`view_set_3_snap`.`tbl_miniorder_data_mini_order_num` AS `tbl_miniorder_data_mini_order_num`,`view_set_2_snap`.`tbl_orders_master_product_schedule` AS `tbl_orders_master_product_schedule`,`view_set_2_snap`.`tbl_orders_size_ref_id` AS `tbl_orders_size_ref_id`,`view_set_1_snap`.`bundle_transactions_20_repeat_bundle_barcode` AS `bundle_transactions_20_repeat_bundle_barcode`,if(octet_length(`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) = 0,`view_set_2_snap`.`tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) AS `size_disp`,`view_set_3_snap`.`order_id` AS `order_id`,round(if(`view_set_1_snap`.`tbl_orders_ops_ref_operation_code` = 'LNO',`view_set_1_snap`.`bundle_transactions_20_repeat_quantity` * `view_set_2_snap`.`smv` / 60,0),2) AS `sah`,`view_set_2_snap`.`order_div` AS `order_div`,`view_set_2_snap`.`order_date` AS `order_date`,concat(`view_set_2_snap`.`tbl_orders_style_ref_product_style`,`view_set_2_snap`.`tbl_orders_master_product_schedule`,`view_set_3_snap`.`tbl_miniorder_data_color`,if(octet_length(`view_set_2_snap`.`tbl_orders_sizes_master_size_title`) = 0,`view_set_2_snap`.`tbl_orders_size_ref_size_name`,`view_set_2_snap`.`tbl_orders_sizes_master_size_title`)) AS `order_tid_new`,`tbl_module_ref`.`module_section` AS `tbl_module_ref_module_section`,`view_set_1_snap`.`bundle_transactions_operation_time` AS `bundle_transactions_operation_time`,`view_set_2_snap`.`smv` AS `view_set_2_snap_smv`,`view_set_3_snap`.`tbl_miniorder_data_docket_number` AS `tbl_miniorder_data_docket_number` from (((`view_set_1_snap` left join `view_set_3_snap` on(`view_set_1_snap`.`bundle_transactions_20_repeat_bundle_barcode` = `view_set_3_snap`.`tbl_miniorder_data_bundle_number`)) left join `view_set_2_snap` on(`view_set_2_snap`.`order_id` = `view_set_3_snap`.`order_id`)) left join `tbl_module_ref` on(convert(`view_set_1_snap`.`bundle_transactions_module_id` using utf8) = `tbl_module_ref`.`id`)))$$
DELIMITER ;

/* Alter Trigger in target */

DELIMITER $$
/*!50003 DROP TRIGGER *//*!50032 IF EXISTS*//*!50003 `bts_sfcs_del`*/$$
CREATE
    TRIGGER `bts_sfcs_del` BEFORE DELETE ON `bundle_transactions_20_repeat` 
    FOR EACH ROW BEGIN
	IF OLD.operation_id=1 OR OLD.operation_id=3 OR OLD.operation_id=4 OR OLD.operation_id=6 OR OLD.operation_id=7 THEN
		INSERT INTO `bts_to_sfcs_sync`(sync_bundle_id,sync_operation_id,sync_operation_code,sync_rep_id,insert_time_stamp) VALUES (OLD.bundle_id,OLD.operation_id,2,OLD.id,NOW());
		-- DELETE FROM `brandix_bts_uat`.`view_set_1_snap` WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode;
		-- DELETE FROM `brandix_bts_uat`.`view_set_snap_1_tbl` WHERE bundle_transactions_20_repeat_bundle_barcode=OLD.bundle_barcode;  
	END IF;
    END;
$$
DELIMITER ;


/* Alter Trigger in target */

DELIMITER $$
/*!50003 DROP TRIGGER *//*!50032 IF EXISTS*//*!50003 `bts_sfcs_insert`*/$$
CREATE
    TRIGGER `bts_sfcs_insert` AFTER INSERT ON `bundle_transactions_20_repeat` 
    FOR EACH ROW BEGIN
	IF NEW.operation_id=1 Or NEW.operation_id=3 OR NEW.operation_id=4 OR NEW.operation_id=6 OR NEW.operation_id=7 THEN
		INSERT INTO `bts_to_sfcs_sync`(sync_bundle_id,sync_operation_id,sync_operation_code,sync_rep_id,insert_time_stamp) VALUES (NEW.bundle_id,NEW.operation_id,0,NEW.id,NOW());
	END IF;
    END;
$$
DELIMITER ;


/* Alter Trigger in target */

DELIMITER $$
/*!50003 DROP TRIGGER *//*!50032 IF EXISTS*//*!50003 `update_act_module`*/$$
CREATE
    TRIGGER `update_act_module` BEFORE INSERT ON `bundle_transactions_20_repeat` 
    FOR EACH ROW BEGIN
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
	
	
    END;
$$
DELIMITER ;


/* Alter Trigger in target */

DELIMITER $$
/*!50003 DROP TRIGGER *//*!50032 IF EXISTS*//*!50003 `update_rejections`*/$$
CREATE
    TRIGGER `update_rejections` BEFORE UPDATE ON `bundle_transactions_20_repeat` 
    FOR EACH ROW BEGIN
    
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
	
    END;
$$
DELIMITER ;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `brandix_bts_uat`;
/*  Alter Procedure in target  */

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_snap_view_uat`$$
CREATE PROCEDURE `sp_snap_view_uat`()
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
	
	END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_bai_mini_cumulative`$$
CREATE FUNCTION `fn_bai_mini_cumulative`(in_order_id VARCHAR(300),in_mini_order_num INT) RETURNS int(11)
BEGIN
DECLARE retval INT;
SET retval=(SELECT SUM(tbl_miniorder_data_quantity) FROM `view_set_3_snap` b WHERE b.order_id=in_order_id AND b.tbl_miniorder_data_mini_order_num<=in_mini_order_num);
RETURN retval;
    END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_bai_pro3_sch_details`$$
CREATE FUNCTION `fn_bai_pro3_sch_details`(scheduleno INT,rettype VARCHAR(30)) RETURNS varchar(50) CHARSET latin1
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
    END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_bai_pro3_smv_details`$$
CREATE FUNCTION `fn_bai_pro3_smv_details`(scheduleno INT,color VARCHAR(100)) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
    
   SET retval=(SELECT CAST(MAX(smv) AS DECIMAL(11,3)) FROM `bai_pro3`.`bai_orders_db_confirm` WHERE order_del_no=scheduleno AND order_col_des=color);
	
   
    RETURN retval;
    END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_get_sec`$$
CREATE FUNCTION `fn_get_sec`(moduleno INT) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
    
   SET retval=(SELECT section_id FROM `bai_pro3`.`plan_modules` WHERE module_id=moduleno);
	
   
    RETURN retval;
    END$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fn_know_size_title`$$
CREATE FUNCTION `fn_know_size_title`(order_id INT,color_code VARCHAR(300),size_id INT) RETURNS varchar(50) CHARSET latin1
BEGIN
    
    DECLARE retval VARCHAR(50);
	
	SET retval=(SELECT IF(LENGTH(size_title)=0,size_name,size_title) FROM `brandix_bts`.`tbl_orders_sizes_master` 
LEFT JOIN brandix_bts.tbl_orders_master ON brandix_bts.tbl_orders_master.id=brandix_bts.tbl_orders_sizes_master.parent_id
LEFT JOIN brandix_bts.tbl_orders_style_ref ON brandix_bts.tbl_orders_master.ref_product_style=brandix_bts.tbl_orders_style_ref.id
LEFT JOIN `brandix_bts.tbl_orders_size_ref` ON brandix_bts.tbl_orders_size_ref.id=brandix_bts.tbl_orders_sizes_master.ref_size_name
WHERE parent_id=order_id AND order_col_des=color_code AND ref_size_name=size_id);
	RETURN retval;
    END$$
DELIMITER ;



/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `central_administration_sfcs`;

/* Alter table in target */
ALTER TABLE `tbl_menu_list` ENGINE=InnoDB; 

/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `veiw_menu_matrix` AS select `a`.`matrix_pid` AS `matrix_pid`,`a`.`fk_menu_pid` AS `fk_menu_pid`,`a`.`fk_fn_id` AS `fk_fn_id`,`a`.`matrix_status` AS `matrix_status`,`a`.`matrix_purpose` AS `matrix_purpose`,`a`.`matrix_remarks` AS `matrix_remarks`,`b`.`menu_pid` AS `menu_pid`,`b`.`page_id` AS `page_id`,`b`.`fk_group_id` AS `fk_group_id`,`b`.`fk_app_id` AS `fk_app_id`,`b`.`parent_id` AS `parent_id`,`b`.`link_type` AS `link_type`,`b`.`link_status` AS `link_status`,`b`.`link_visibility` AS `link_visibility`,`b`.`link_location` AS `link_location`,`b`.`link_description` AS `link_description`,`b`.`link_tool_tip` AS `link_tool_tip`,`b`.`link_cmd` AS `link_cmd`,`c`.`fn_id` AS `fn_id`,`c`.`fn_name` AS `fn_name`,`c`.`fn_purpose` AS `fn_purpose`,`c`.`fn_status` AS `fn_status`,`c`.`fn_remarks` AS `fn_remarks`,`d`.`app_id` AS `app_id`,`d`.`app_name` AS `app_name`,`d`.`app_description` AS `app_description`,`d`.`app_purpose` AS `app_purpose`,`d`.`app_owner` AS `app_owner`,`d`.`app_point_person` AS `app_point_person`,`d`.`app_status` AS `app_status`,`d`.`app_start_date` AS `app_start_date`,`d`.`app_last_revision` AS `app_last_revision`,`d`.`app_remarks` AS `app_remarks`,`e`.`group_id` AS `group_id`,`e`.`group_status` AS `group_status`,`e`.`group_purpose` AS `group_purpose` from ((((`tbl_menu_matrix` `a` join `tbl_menu_list` `b` on(`a`.`fk_menu_pid` = `b`.`menu_pid`)) join `tbl_function_list` `c` on(`a`.`fk_fn_id` = `c`.`fn_id`)) join `tbl_application_list` `d` on(`b`.`fk_app_id` = `d`.`app_id`)) join `tbl_group_list` `e` on(`b`.`fk_group_id` = `e`.`group_id`))$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_menu` AS select `a`.`user_id` AS `user_id`,`a`.`username` AS `user_name`,`a`.`user_status` AS `user_status`,`a`.`user_location` AS `user_location`,`b`.`acl_id` AS `acl_id`,`b`.`fk_matrix_pid` AS `fk_matrix_pid`,`b`.`fk_user_id` AS `fk_user_id`,`b`.`acl_status` AS `acl_status`,`c`.`matrix_pid` AS `matrix_pid`,`c`.`fk_menu_pid` AS `fk_menu_pid`,`c`.`fk_fn_id` AS `fk_fn_id`,`c`.`matrix_status` AS `matrix_status`,`c`.`matrix_purpose` AS `matrix_purpose`,`c`.`matrix_remarks` AS `matrix_remarks`,`d`.`fn_id` AS `fn_id`,`d`.`fn_name` AS `fn_name`,`d`.`fn_purpose` AS `fn_purpose`,`d`.`fn_status` AS `fn_status`,`d`.`fn_remarks` AS `fn_remarks`,`e`.`menu_pid` AS `menu_pid`,`e`.`page_id` AS `page_id`,`e`.`fk_group_id` AS `fk_group_id`,`e`.`fk_app_id` AS `fk_app_id`,`e`.`parent_id` AS `parent_id`,`e`.`link_type` AS `link_type`,`e`.`link_status` AS `link_status`,`e`.`link_visibility` AS `link_visibility`,`e`.`link_location` AS `link_location`,`e`.`link_description` AS `link_description`,`e`.`link_tool_tip` AS `link_tool_tip`,`e`.`link_cmd` AS `link_cmd`,`f`.`group_id` AS `group_id`,`f`.`group_status` AS `group_status`,`f`.`group_purpose` AS `group_purpose`,`h`.`app_id` AS `app_id`,`h`.`app_name` AS `app_name`,`h`.`app_description` AS `app_description`,`h`.`app_purpose` AS `app_purpose`,`h`.`app_owner` AS `app_owner`,`h`.`app_point_person` AS `app_point_person`,`h`.`app_status` AS `app_status`,`h`.`app_start_date` AS `app_start_date`,`h`.`app_last_revision` AS `app_last_revision`,`h`.`app_remarks` AS `app_remarks` from ((((((`tbl_user_list` `a` join `tbl_user_acl_list` `b` on(`a`.`user_id` = `b`.`fk_user_id` and `a`.`user_status` = 1 and `b`.`acl_status` = 1)) join `tbl_menu_matrix` `c` on(`b`.`fk_matrix_pid` = `c`.`matrix_pid` and `c`.`matrix_status` = 1)) join `tbl_function_list` `d` on(`c`.`fk_fn_id` = `d`.`fn_id` and `d`.`fn_status` = 1)) join `tbl_menu_list` `e` on(`c`.`fk_menu_pid` = `e`.`menu_pid` and `e`.`link_status` = 1)) join `tbl_group_list` `f` on(`e`.`fk_group_id` = `f`.`group_id` and `f`.`group_status` = 1)) join `tbl_application_list` `h` on(`e`.`fk_app_id` = `h`.`app_id` and `h`.`app_status` = 1)) order by `a`.`user_id`,`c`.`matrix_pid`$$
DELIMITER ;


/*  Alter View in target  */
DELIMITER $$
ALTER ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_menu_role` AS select `a`.`user_id` AS `user_id`,`a`.`username` AS `username`,`a`.`user_status` AS `user_status`,`a`.`user_location` AS `user_location`,`b`.`acl_id` AS `acl_id`,`b`.`fk_role_pid` AS `fk_role_pid`,`b`.`fk_user_id` AS `fk_user_id`,`b`.`acl_status` AS `acl_status`,`c`.`role_id` AS `role_id`,`c`.`role_desc` AS `role_desc`,`c`.`role_status` AS `role_status`,`c`.`fk_app_pid` AS `fk_app_pid`,`d`.`role_matrix_id` AS `role_matrix_id`,`d`.`fk_role_id` AS `fk_role_id`,`d`.`fk_menu_matrix_id` AS `fk_menu_matrix_id`,`d`.`role_matrix_desc` AS `role_matrix_desc`,`d`.`role_matrix_status` AS `role_matrix_status`,`e`.`matrix_pid` AS `matrix_pid`,`e`.`fk_menu_pid` AS `fk_menu_pid`,`e`.`fk_fn_id` AS `fk_fn_id`,`e`.`matrix_status` AS `matrix_status`,`e`.`matrix_purpose` AS `matrix_purpose`,`e`.`matrix_remarks` AS `matrix_remarks`,`f`.`fn_id` AS `fn_id`,`f`.`fn_name` AS `fn_name`,`f`.`fn_purpose` AS `fn_purpose`,`f`.`fn_status` AS `fn_status`,`f`.`fn_remarks` AS `fn_remarks`,`g`.`menu_pid` AS `menu_pid`,`g`.`page_id` AS `page_id`,`g`.`fk_group_id` AS `fk_group_id`,`g`.`fk_app_id` AS `fk_app_id`,`g`.`parent_id` AS `parent_id`,`g`.`link_type` AS `link_type`,`g`.`link_status` AS `link_status`,`g`.`link_visibility` AS `link_visibility`,`g`.`link_location` AS `link_location`,`g`.`link_description` AS `link_description`,`g`.`link_tool_tip` AS `link_tool_tip`,`g`.`link_cmd` AS `link_cmd`,`h`.`group_id` AS `group_id`,`h`.`group_status` AS `group_status`,`h`.`group_purpose` AS `group_purpose`,`i`.`app_id` AS `app_id`,`i`.`app_name` AS `app_name`,`i`.`app_description` AS `app_description`,`i`.`app_purpose` AS `app_purpose`,`i`.`app_owner` AS `app_owner`,`i`.`app_point_person` AS `app_point_person`,`i`.`app_status` AS `app_status`,`i`.`app_start_date` AS `app_start_date`,`i`.`app_last_revision` AS `app_last_revision`,`i`.`app_remarks` AS `app_remarks` from ((((((((`central_administration`.`tbl_user_list` `a` join `central_administration`.`tbl_user_acl_list_role` `b` on(`a`.`user_id` = `b`.`fk_user_id` and `a`.`user_status` = 1 and `b`.`acl_status` = 1)) join `central_administration`.`tbl_role_list` `c` on(`b`.`fk_role_pid` = `c`.`role_id` and `c`.`role_status` = 1)) join `central_administration`.`tbl_role_matrix` `d` on(`b`.`fk_role_pid` = `d`.`fk_role_id` and `d`.`role_matrix_status` = 1)) join `central_administration`.`tbl_menu_matrix` `e` on(`d`.`fk_menu_matrix_id` = `e`.`matrix_pid` and `e`.`matrix_status` = 1)) join `central_administration`.`tbl_function_list` `f` on(`e`.`fk_fn_id` = `f`.`fn_id` and `f`.`fn_status` = 1)) join `central_administration`.`tbl_menu_list` `g` on(`e`.`fk_menu_pid` = `g`.`menu_pid` and `g`.`link_status` = 1)) join `central_administration`.`tbl_group_list` `h` on(`g`.`fk_group_id` = `h`.`group_id` and `h`.`group_status` = 1)) join `central_administration`.`tbl_application_list` `i` on(`g`.`fk_app_id` = `i`.`app_id` and `i`.`app_status` = 1)) order by `a`.`user_id`,`c`.`role_id`$$
DELIMITER ;

/*  Alter Procedure in target  */

DELIMITER $$
DROP PROCEDURE IF EXISTS `GetFunctionDetails`$$
CREATE PROCEDURE `GetFunctionDetails`()
BEGIN
 SELECT fn_id,fn_name 
 FROM menu.tbl_function_list where fn_status=1;
 END$$
DELIMITER ;


/*  Alter Procedure in target  */

DELIMITER $$
DROP PROCEDURE IF EXISTS `list_function`$$
CREATE PROCEDURE `list_function`()
begin
DECLARE v_fn_id int;
DECLARE v_fn_name varchar(255);
DECLARE done INT DEFAULT FALSE;
declare cur1 cursor for SELECT fn_id,fn_name FROM menu.tbl_function_list where fn_status=1;
declare continue handler for not found set v_fn_id=0;
open cur1;
the_loop: loop
Fetch cur1 into v_fn_id,v_fn_name;
IF done THEN
      LEAVE the_loop;
    END IF;
    IF v_fn_id IS NULL THEN
      SET v_fn_id = "";
    END IF;
 
    IF v_fn_name IS NULL THEN
      SET v_fn_name = "";
    END IF;
end loop the_loop;
close cur1;
end$$
DELIMITER ;


/*  Alter Procedure in target  */

DELIMITER $$
DROP PROCEDURE IF EXISTS `test1`$$
CREATE PROCEDURE `test1`()
begin
declare done int default false;
declare v_fn_id integer;
declare v_fn_name text;
declare curs1 cursor for SELECT fn_id,fn_name FROM menu.tbl_function_list where fn_status=1;
 DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
 OPEN curs1;
read_loop: LOOP
fetch curs1 into v_fn_id,v_fn_name;
if done then
leave read_loop;
end if;
SELECT menu_pid,parent_id,app_id,app_name,link_description,
if(fn_id=1,group_concat(distinct(user_name)),NULL) as 'view_users',
if(fn_id=2,group_concat(distinct(user_name)),NULL) as 'edit_users',
if(fn_id=3,group_concat(distinct(user_name)),NULL) as 'update_users',
if(fn_id=4,group_concat(distinct(user_name)),NULL) as 'delete_users',
if(fn_id=5,group_concat(distinct(user_name)),NULL) as 'alert_recipients_users'
FROM menu.view_menu 
where menu_pid in (
select distinct(menu_pid) from menu.view_menu where group_id=1) 
group by menu_pid order by app_id;end loop;
close curs1;
end$$
DELIMITER ;


/*  Alter Function in target  */

DELIMITER $$
DROP FUNCTION IF EXISTS `fun_emp_mod`$$
CREATE FUNCTION `fun_emp_mod`(`id` VARCHAR(100)) RETURNS varchar(200) CHARSET latin1
    DETERMINISTIC
BEGIN
		DECLARE RET VARCHAR(200);
		SELECT module INTO RET FROM bai_hr_tna_em_1515.Jan WHERE emp_id=id and date='2015-01-01';
		RETURN RET;
	    END$$
DELIMITER ;


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `m3_inputs`;

/* Create table in target */
CREATE TABLE `mo_details`(
	`id` int(11) NOT NULL  auto_increment , 
	`MONUMBER` varchar(10) COLLATE latin1_swedish_ci NULL  , 
	`MOQTY` varchar(20) COLLATE latin1_swedish_ci NULL  , 
	`STARTDATE` date NULL  , 
	`VPO` varchar(20) COLLATE latin1_swedish_ci NULL  , 
	`COLORNAME` varchar(20) COLLATE latin1_swedish_ci NULL  , 
	`COLOURDESC` varchar(30) COLLATE latin1_swedish_ci NULL  , 
	`SIZENAME` varchar(15) COLLATE latin1_swedish_ci NULL  , 
	`SIZEDESC` varchar(15) COLLATE latin1_swedish_ci NULL  , 
	`ZNAME` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`ZDESC` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`SCHEDULE` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`STYLE` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`PRODUCT` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`PRDNAME` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`PRDDESC` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`REFERENCEORDER` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`REFORDLINE` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`MOSTS` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`MAXOPERATIONSTS` varchar(40) COLLATE latin1_swedish_ci NULL  , 
	`COPLANDELDATE` date NULL  , 
	`COREQUESTEDDELDATE` date NULL  , 
	PRIMARY KEY (`id`) , 
	UNIQUE KEY `UNIQUE`(`MONUMBER`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Alter table in target */
ALTER TABLE `order_details` 
	CHANGE `sno` `sno` bigint(20)   NOT NULL first , 
	CHANGE `time_stamp` `time_stamp` timestamp   NULL DEFAULT current_timestamp() after `SEQ_NUMBER` , 
	DROP KEY `PRIMARY` ;

/* Create table in target */
CREATE TABLE `order_details_original`(
	`sno` bigint(20) NOT NULL  auto_increment , 
	`Facility` longtext COLLATE latin1_swedish_ci NULL  , 
	`Customer_Style_No` longtext COLLATE latin1_swedish_ci NULL  , 
	`CPO_NO` longtext COLLATE latin1_swedish_ci NULL  , 
	`VPO_NO` longtext COLLATE latin1_swedish_ci NULL  , 
	`CO_no` longtext COLLATE latin1_swedish_ci NULL  , 
	`Style` longtext COLLATE latin1_swedish_ci NULL  , 
	`Schedule` longtext COLLATE latin1_swedish_ci NULL  , 
	`Manufacturing_Schedule_no` longtext COLLATE latin1_swedish_ci NULL  , 
	`MO_Split_Method` longtext COLLATE latin1_swedish_ci NULL  , 
	`MO_Released_Status_Y_N` longtext COLLATE latin1_swedish_ci NULL  , 
	`GMT_Color` longtext COLLATE latin1_swedish_ci NULL  , 
	`GMT_Size` longtext COLLATE latin1_swedish_ci NULL  , 
	`GMT_Z_Feature` longtext COLLATE latin1_swedish_ci NULL  , 
	`Graphic_Number` longtext COLLATE latin1_swedish_ci NULL  , 
	`CO_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`MO_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`PCD` longtext COLLATE latin1_swedish_ci NULL  , 
	`Plan_Delivery_Date` longtext COLLATE latin1_swedish_ci NULL  , 
	`Destination` longtext COLLATE latin1_swedish_ci NULL  , 
	`Packing_Method` longtext COLLATE latin1_swedish_ci NULL  , 
	`Item_Code` longtext COLLATE latin1_swedish_ci NULL  , 
	`Item_Description` longtext COLLATE latin1_swedish_ci NULL  , 
	`RM_Color_Description` longtext COLLATE latin1_swedish_ci NULL  , 
	`Order_YY_WO_Wastage` longtext COLLATE latin1_swedish_ci NULL  , 
	`Wastage` longtext COLLATE latin1_swedish_ci NULL  , 
	`Required_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`UOM` longtext COLLATE latin1_swedish_ci NULL  , 
	`A15NEXT` longtext COLLATE latin1_swedish_ci NULL  , 
	`A15` longtext COLLATE latin1_swedish_ci NULL  , 
	`A20` longtext COLLATE latin1_swedish_ci NULL  , 
	`A30` longtext COLLATE latin1_swedish_ci NULL  , 
	`A40` longtext COLLATE latin1_swedish_ci NULL  , 
	`A50` longtext COLLATE latin1_swedish_ci NULL  , 
	`A60` longtext COLLATE latin1_swedish_ci NULL  , 
	`A70` longtext COLLATE latin1_swedish_ci NULL  , 
	`A75` longtext COLLATE latin1_swedish_ci NULL  , 
	`A80` longtext COLLATE latin1_swedish_ci NULL  , 
	`A90` longtext COLLATE latin1_swedish_ci NULL  , 
	`A100` longtext COLLATE latin1_swedish_ci NULL  , 
	`A110` longtext COLLATE latin1_swedish_ci NULL  , 
	`A115` longtext COLLATE latin1_swedish_ci NULL  , 
	`A120` longtext COLLATE latin1_swedish_ci NULL  , 
	`A125` longtext COLLATE latin1_swedish_ci NULL  , 
	`A130` longtext COLLATE latin1_swedish_ci NULL  , 
	`A140` longtext COLLATE latin1_swedish_ci NULL  , 
	`A143` longtext COLLATE latin1_swedish_ci NULL  , 
	`A144` longtext COLLATE latin1_swedish_ci NULL  , 
	`A147` longtext COLLATE latin1_swedish_ci NULL  , 
	`A148` longtext COLLATE latin1_swedish_ci NULL  , 
	`A150` longtext COLLATE latin1_swedish_ci NULL  , 
	`A160` longtext COLLATE latin1_swedish_ci NULL  , 
	`A170` longtext COLLATE latin1_swedish_ci NULL  , 
	`A175` longtext COLLATE latin1_swedish_ci NULL  , 
	`A180` longtext COLLATE latin1_swedish_ci NULL  , 
	`A190` longtext COLLATE latin1_swedish_ci NULL  , 
	`A200` longtext COLLATE latin1_swedish_ci NULL  , 
	`MO_NUMBER` longtext COLLATE latin1_swedish_ci NULL  , 
	`SEQ_NUMBER` longtext COLLATE latin1_swedish_ci NULL  , 
	`time_stamp` timestamp NULL  DEFAULT current_timestamp() , 
	PRIMARY KEY (`sno`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `order_details_temp`(
	`sno` bigint(20) NOT NULL  , 
	`Facility` longtext COLLATE latin1_swedish_ci NULL  , 
	`Customer_Style_No` longtext COLLATE latin1_swedish_ci NULL  , 
	`CPO_NO` longtext COLLATE latin1_swedish_ci NULL  , 
	`VPO_NO` longtext COLLATE latin1_swedish_ci NULL  , 
	`CO_no` longtext COLLATE latin1_swedish_ci NULL  , 
	`Style` longtext COLLATE latin1_swedish_ci NULL  , 
	`Schedule` longtext COLLATE latin1_swedish_ci NULL  , 
	`Manufacturing_Schedule_no` longtext COLLATE latin1_swedish_ci NULL  , 
	`MO_Split_Method` longtext COLLATE latin1_swedish_ci NULL  , 
	`MO_Released_Status_Y_N` longtext COLLATE latin1_swedish_ci NULL  , 
	`GMT_Color` longtext COLLATE latin1_swedish_ci NULL  , 
	`GMT_Size` longtext COLLATE latin1_swedish_ci NULL  , 
	`GMT_Z_Feature` longtext COLLATE latin1_swedish_ci NULL  , 
	`Graphic_Number` longtext COLLATE latin1_swedish_ci NULL  , 
	`CO_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`MO_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`PCD` longtext COLLATE latin1_swedish_ci NULL  , 
	`Plan_Delivery_Date` longtext COLLATE latin1_swedish_ci NULL  , 
	`Destination` longtext COLLATE latin1_swedish_ci NULL  , 
	`Packing_Method` longtext COLLATE latin1_swedish_ci NULL  , 
	`Item_Code` longtext COLLATE latin1_swedish_ci NULL  , 
	`Item_Description` longtext COLLATE latin1_swedish_ci NULL  , 
	`RM_Color_Description` longtext COLLATE latin1_swedish_ci NULL  , 
	`Order_YY_WO_Wastage` longtext COLLATE latin1_swedish_ci NULL  , 
	`Wastage` longtext COLLATE latin1_swedish_ci NULL  , 
	`Required_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`UOM` longtext COLLATE latin1_swedish_ci NULL  , 
	`A15NEXT` longtext COLLATE latin1_swedish_ci NULL  , 
	`A15` longtext COLLATE latin1_swedish_ci NULL  , 
	`A20` longtext COLLATE latin1_swedish_ci NULL  , 
	`A30` longtext COLLATE latin1_swedish_ci NULL  , 
	`A40` longtext COLLATE latin1_swedish_ci NULL  , 
	`A50` longtext COLLATE latin1_swedish_ci NULL  , 
	`A60` longtext COLLATE latin1_swedish_ci NULL  , 
	`A70` longtext COLLATE latin1_swedish_ci NULL  , 
	`A75` longtext COLLATE latin1_swedish_ci NULL  , 
	`A80` longtext COLLATE latin1_swedish_ci NULL  , 
	`A90` longtext COLLATE latin1_swedish_ci NULL  , 
	`A100` longtext COLLATE latin1_swedish_ci NULL  , 
	`A110` longtext COLLATE latin1_swedish_ci NULL  , 
	`A115` longtext COLLATE latin1_swedish_ci NULL  , 
	`A120` longtext COLLATE latin1_swedish_ci NULL  , 
	`A125` longtext COLLATE latin1_swedish_ci NULL  , 
	`A130` longtext COLLATE latin1_swedish_ci NULL  , 
	`A140` longtext COLLATE latin1_swedish_ci NULL  , 
	`A143` longtext COLLATE latin1_swedish_ci NULL  , 
	`A144` longtext COLLATE latin1_swedish_ci NULL  , 
	`A147` longtext COLLATE latin1_swedish_ci NULL  , 
	`A148` longtext COLLATE latin1_swedish_ci NULL  , 
	`A150` longtext COLLATE latin1_swedish_ci NULL  , 
	`A160` longtext COLLATE latin1_swedish_ci NULL  , 
	`A170` longtext COLLATE latin1_swedish_ci NULL  , 
	`A175` longtext COLLATE latin1_swedish_ci NULL  , 
	`A180` longtext COLLATE latin1_swedish_ci NULL  , 
	`A190` longtext COLLATE latin1_swedish_ci NULL  , 
	`A200` longtext COLLATE latin1_swedish_ci NULL  , 
	`MO_NUMBER` longtext COLLATE latin1_swedish_ci NULL  , 
	`SEQ_NUMBER` longtext COLLATE latin1_swedish_ci NULL  , 
	`time_stamp` timestamp NULL  DEFAULT current_timestamp() 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Alter table in target */
ALTER TABLE `shipment_plan` 
	CHANGE `sno` `sno` bigint(20)   NOT NULL first , 
	CHANGE `time_stamp` `time_stamp` timestamp   NULL DEFAULT current_timestamp() after `BTS_vs_FG_Qty` , 
	DROP KEY `PRIMARY` ;

/* Create table in target */
CREATE TABLE `shipment_plan_original`(
	`sno` bigint(20) NOT NULL  auto_increment , 
	`Customer_Order_No` longtext COLLATE latin1_swedish_ci NULL  , 
	`CO_Line_Status` longtext COLLATE latin1_swedish_ci NULL  , 
	`Ex_Factory` longtext COLLATE latin1_swedish_ci NULL  , 
	`Order_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`Mode` longtext COLLATE latin1_swedish_ci NULL  , 
	`Destination` longtext COLLATE latin1_swedish_ci NULL  , 
	`Packing_Method` longtext COLLATE latin1_swedish_ci NULL  , 
	`FOB_Price_per_piece` longtext COLLATE latin1_swedish_ci NULL  , 
	`MPO` longtext COLLATE latin1_swedish_ci NULL  , 
	`CPO` longtext COLLATE latin1_swedish_ci NULL  , 
	`DBFDST` longtext COLLATE latin1_swedish_ci NULL  , 
	`Size` longtext COLLATE latin1_swedish_ci NULL  , 
	`HMTY15` longtext COLLATE latin1_swedish_ci NULL  , 
	`ZFeature` longtext COLLATE latin1_swedish_ci NULL  , 
	`MMBUAR` longtext COLLATE latin1_swedish_ci NULL  , 
	`Style_No` longtext COLLATE latin1_swedish_ci NULL  , 
	`Product` longtext COLLATE latin1_swedish_ci NULL  , 
	`Buyer_Division` longtext COLLATE latin1_swedish_ci NULL  , 
	`Buyer` longtext COLLATE latin1_swedish_ci NULL  , 
	`CM_Value` longtext COLLATE latin1_swedish_ci NULL  , 
	`Schedule_No` longtext COLLATE latin1_swedish_ci NULL  , 
	`Colour` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_A` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_B` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_C` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_D` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_E` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_F` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_G` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_H` longtext COLLATE latin1_swedish_ci NULL  , 
	`Alloc_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`Dsptched_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`BTS_vs_Ord_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`BTS_vs_FG_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`time_stamp` timestamp NULL  DEFAULT current_timestamp() , 
	PRIMARY KEY (`sno`) 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';


/* Create table in target */
CREATE TABLE `shipment_plan_temp`(
	`sno` bigint(20) NOT NULL  , 
	`Customer_Order_No` longtext COLLATE latin1_swedish_ci NULL  , 
	`CO_Line_Status` longtext COLLATE latin1_swedish_ci NULL  , 
	`Ex_Factory` longtext COLLATE latin1_swedish_ci NULL  , 
	`Order_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`Mode` longtext COLLATE latin1_swedish_ci NULL  , 
	`Destination` longtext COLLATE latin1_swedish_ci NULL  , 
	`Packing_Method` longtext COLLATE latin1_swedish_ci NULL  , 
	`FOB_Price_per_piece` longtext COLLATE latin1_swedish_ci NULL  , 
	`MPO` longtext COLLATE latin1_swedish_ci NULL  , 
	`CPO` longtext COLLATE latin1_swedish_ci NULL  , 
	`DBFDST` longtext COLLATE latin1_swedish_ci NULL  , 
	`Size` longtext COLLATE latin1_swedish_ci NULL  , 
	`HMTY15` longtext COLLATE latin1_swedish_ci NULL  , 
	`ZFeature` longtext COLLATE latin1_swedish_ci NULL  , 
	`MMBUAR` longtext COLLATE latin1_swedish_ci NULL  , 
	`Style_No` longtext COLLATE latin1_swedish_ci NULL  , 
	`Product` longtext COLLATE latin1_swedish_ci NULL  , 
	`Buyer_Division` longtext COLLATE latin1_swedish_ci NULL  , 
	`Buyer` longtext COLLATE latin1_swedish_ci NULL  , 
	`CM_Value` longtext COLLATE latin1_swedish_ci NULL  , 
	`Schedule_No` longtext COLLATE latin1_swedish_ci NULL  , 
	`Colour` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_A` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_B` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_C` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_D` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_E` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_F` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_G` longtext COLLATE latin1_swedish_ci NULL  , 
	`EMB_H` longtext COLLATE latin1_swedish_ci NULL  , 
	`Alloc_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`Dsptched_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`BTS_vs_Ord_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`BTS_vs_FG_Qty` longtext COLLATE latin1_swedish_ci NULL  , 
	`time_stamp` timestamp NULL  DEFAULT current_timestamp() 
) ENGINE=InnoDB DEFAULT CHARSET='latin1' COLLATE='latin1_swedish_ci';

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;