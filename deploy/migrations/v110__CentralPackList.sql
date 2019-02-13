
/*USE `bai_pro3`;*/

CREATE TABLE `bai_pro3`.`pac_stat` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `style` varchar(30) NOT NULL,
  `schedule` varchar(10) NOT NULL,
  `pac_seq_no` int(5) NOT NULL COMMENT 'sequence number',
  `carton_no` int(15) NOT NULL,
  `carton_mode` varchar(5) NOT NULL COMMENT 'Partial / Full',
  `carton_qty` int(15) NOT NULL COMMENT 'total qty in that carton',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `bai_pro3`.`pac_stat_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(255) DEFAULT NULL,
  `schedule` int(11) DEFAULT NULL,
  `no_of_cartons` int(11) DEFAULT NULL COMMENT 'sewing no of cartons',
  `mix_jobs` int(11) DEFAULT NULL COMMENT '1=yes | 2=no',
  `bundle_qty` int(11) DEFAULT NULL COMMENT 'sewing job bundle qty',
  `pac_seq_no` int(11) DEFAULT NULL COMMENT 'pack seq_no',
  `pack_method` int(11) DEFAULT NULL COMMENT 'sewing pack method',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `bai_pro3`.`tbl_carton_ready` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_id` int(11) NOT NULL,
  `mo_no` int(11) NOT NULL,
  `remaining_qty` int(11) NOT NULL,
  `cumulative_qty` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `bai_pro3`.`tbl_docket_qty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cut_no` int(11) DEFAULT NULL,
  `doc_no` int(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `ref_size` int(11) DEFAULT NULL COMMENT 'id of size from brandix_bts.tbl_size master',
  `plan_qty` int(11) DEFAULT NULL,
  `fill_qty` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1=normal | 2=excess | 3=sample',
  `pac_stat_input_id` int(11) DEFAULT NULL COMMENT 'id from pac_stat_input table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `bai_pro3`.`tbl_pack_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `bai_pro3`.`tbl_pack_size_ref` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent_id` int(6) DEFAULT NULL,
  `color` varchar(765) DEFAULT NULL,
  `ref_size_name` int(11) DEFAULT NULL,
  `size_title` varchar(30) DEFAULT NULL,
  `quantity` int(6) DEFAULT NULL,
  `poly_bags_per_carton` int(5) DEFAULT NULL,
  `garments_per_carton` int(5) DEFAULT NULL,
  `seq_no` int(5) DEFAULT NULL,
  `cartons_per_pack_job` int(5) DEFAULT NULL,
  `pack_job_per_pack_method` int(5) DEFAULT NULL,
  `pack_method` int(5) DEFAULT NULL,
  `pack_description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


ALTER TABLE bai_pro3.pac_stat_log
 ADD COLUMN size_tit VARCHAR(255) NULL COMMENT 'actual size' AFTER color,
 ADD COLUMN pac_stat_id INT(11) NULL COMMENT 'id from pac_stat table' AFTER size_tit;
 

ALTER VIEW `bai_pro3`.`packing_summary` AS (
select
  `pac_stat_log`.`doc_no`         AS `doc_no`,
  `pac_stat_log`.`doc_no_ref`     AS `doc_no_ref`,
  `pac_stat_log`.`tid`            AS `tid`,
  `pac_stat`.`carton_no`          AS `carton_no`,
  `pac_stat_log`.`size_code`      AS `size_code`,
  `pac_stat_log`.`remarks`        AS `remarks`,
  `pac_stat_log`.`status`         AS `STATUS`,
  `pac_stat_log`.`lastup`         AS `lastup`,
  `pac_stat_log`.`container`      AS `container`,
  `pac_stat_log`.`disp_carton_no` AS `disp_carton_no`,
  `pac_stat_log`.`disp_id`        AS `disp_id`,
  `pac_stat_log`.`carton_act_qty` AS `carton_act_qty`,
  `pac_stat_log`.`audit_status`   AS `audit_status`,
  `pac_stat`.`style`              AS `order_style_no`,
  `pac_stat`.`schedule`           AS `order_del_no`,
  `pac_stat`.`carton_mode`        AS `carton_mode`,
  `pac_stat_log`.`color`          AS `order_col_des`,
  `pac_stat_log`.`size_tit`       AS `size_tit`,
  `pac_stat`.`pac_seq_no`         AS `seq_no`,
  `pac_stat_log`.`pac_stat_id`    AS `pac_stat_id`
from (((`pac_stat_log`
     left join `pac_stat`
       on (`pac_stat`.`id` = `pac_stat_log`.`pac_stat_id`))
    left join `plandoc_stat_log`
      on (`pac_stat_log`.`doc_no` = `plandoc_stat_log`.`doc_no`))
   left join `bai_orders_db_confirm`
     on (`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`)));

	 
	 
/*USE central_administration_sfcs;*/
	
/* INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1596', 'SFCS_0363', '8', '2', '143', '0', '1', '', 'Centralized Packing List', '1', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1597', 'SFCS_0364', '8', '2', '1596', '1', '1', '/sfcs_app/app/packing/controllers/central_packing/order_qty_vs_packed_qty.php', 'Add Packing List', '1', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1598', 'SFCS_0365', '8', '2', '1596', '1', '1', '/sfcs_app/app/packing/controllers/central_packing/pack_method_loading.php', 'Pack Method Loading', '2', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1599', 'SFCS_0366', '8', '2', '1596', '1', '1', '/sfcs_app/app/packing/controllers/central_packing/carton_club_drag_drop.php', 'Carton Club', '3', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1600', 'SFCS_0367', '8', '2', '1596', '1', '1', '/sfcs_app/app/packing/controllers/central_packing/carton_split.php', 'Carton Split', '4', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1601', 'SFCS_0368', '8', '2', '1596', '1', '1', '/sfcs_app/app/packing/controllers/central_packing/carton_scan_select_user.php', 'Carton Scanning', '5', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1602', 'SFCS_0369', '8', '2', '1596', '1', '1', '/sfcs_app/app/packing/controllers/central_packing/pack_method_deletion.php', 'Delete Packing List', '6', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1603', 'SFCS_0370', '8', '2', '1596', '1', '1', '/sfcs_app/app/packing/controllers/central_packing/carton_reversal.php', 'Carton Reversal', '7', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1604', 'SFCS_0371', '8', '2', '39', '1', '1', '/sfcs_app/app/packing/reports/central_packing/eligible_cartons_report.php', 'Carton Eligible Report', '', ''); 
INSERT INTO `central_administration_sfcs`.`tbl_menu_list` (`menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) VALUES ('1605', 'SFCS_0372', '8', '2', '39', '1', '1', '/sfcs_app/app/packing/reports/central_packing/cut_job_packing_report.php', 'Central Pack Report', '', ''); 


INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1597', 'Add Packing List', '1'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1598', 'Pack Method Loading', '1'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1599', 'Carton Club', '1'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1600', 'Carton Split', '1'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1601', 'Carton Scanning', '1'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1602', 'Delete Packing List', '1'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1603', 'Carton Reversal', '1'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1604', 'Carton Eligible Report', '1'); 
INSERT INTO `central_administration_sfcs`.`rbac_role_menu` (`menu_pid`, `menu_description`, `roll_id`) VALUES ('1605', 'Carton Pack Report', '1'); */ 
