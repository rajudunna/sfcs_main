/*1384 new menus and alter table*/

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1642','SFCS_0380', '8', '8', '1487', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/release_sj_barcodes.php', 'Release Sewing Job Bundle Barcodes', '1', ''); 

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1642', 'Release Sewing Job Bundle Barcodes', '1');
 
INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1643','SFCS_0345', '8', '8', '29', '1', '1', '/sfcs_app/app/production/reports/kpi/day_hour_report.php', 'Day Hour Report', '1', ''); 

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1643', 'Day Hour Report', '1');

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, 
link_location, link_description, link_tool_tip, link_cmd) VALUES ('1644','SFCS_0557', '8', '8', '70', '1', '1', 
'/sfcs_app/app/production/reports/bundle_wise_main.php', 'Bundle Wise Report', '1', ''); 

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1644', 'Bundle Wise Report', '1');

insert into central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) values('1645','SFCS_0349','8','8','1487','1','1','1','/sfcs_app/app/production/controllers/sewing_job/reprint_ticket_status.php','Bundle Tag Re-Print','4',' ');

insert into central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) values('1645','Bundle Tag Re-Print','1');
  
  
  ALTER TABLE bai_pro3.pac_stat_log_input_job
  ADD COLUMN bundle_print_status INT(11) DEFAULT 0 NOT NULL COMMENT '0=not printed || 1=printed' AFTER mrn_status,
  ADD COLUMN bundle_print_time TIMESTAMP NULL COMMENT 'time of bundle barcode printing' AFTER bundle_print_status;
  
 /*Note: Need to add bundle_print_status column in packing_summary_input view also*/
 
ALTER  VIEW `bai_pro3`.`packing_summary_input` AS 
select
  `bai_orders_db_confirm`.`order_joins`          AS `order_joins`,
  `pac_stat_log_input_job`.`doc_no`              AS `doc_no`,
  `pac_stat_log_input_job`.`input_job_no`        AS `input_job_no`,
  `pac_stat_log_input_job`.`input_job_no_random` AS `input_job_no_random`,
  `pac_stat_log_input_job`.`doc_no_ref`          AS `doc_no_ref`,
  `pac_stat_log_input_job`.`tid`                 AS `tid`,
  ucase(`pac_stat_log_input_job`.`size_code`)    AS `size_code`,
  `pac_stat_log_input_job`.`status`              AS `STATUS`,
  `pac_stat_log_input_job`.`carton_act_qty`      AS `carton_act_qty`,
  `pac_stat_log_input_job`.`packing_mode`        AS `packing_mode`,
  `bai_orders_db_confirm`.`order_style_no`       AS `order_style_no`,
  `bai_orders_db_confirm`.`order_del_no`         AS `order_del_no`,
  `bai_orders_db_confirm`.`order_col_des`        AS `order_col_des`,
  `plandoc_stat_log`.`acutno`                    AS `acutno`,
  `bai_orders_db_confirm`.`destination`          AS `destination`,
  `plandoc_stat_log`.`cat_ref`                   AS `cat_ref`,
  ucase(`pac_stat_log_input_job`.`size_code`)    AS `m3_size_code`,
  `pac_stat_log_input_job`.`old_size`            AS `old_size`,
  `pac_stat_log_input_job`.`type_of_sewing`      AS `type_of_sewing`,
  `pac_stat_log_input_job`.`doc_type`            AS `doc_type`,
  `pac_stat_log_input_job`.`pac_seq_no`          AS `pac_seq_no`,
  `pac_stat_log_input_job`.`sref_id`             AS `sref_id`,
  `pac_stat_log_input_job`.`barcode_sequence`    AS `barcode_sequence`,
  `pac_stat_log_input_job`.`mrn_status`          AS `mrn_status`,
  `pac_stat_log_input_job`.`bundle_print_status`    AS `bundle_print_status`
  
from ((`pac_stat_log_input_job`
    left join `plandoc_stat_log`
      on (`pac_stat_log_input_job`.`doc_no` = `plandoc_stat_log`.`doc_no`))
   left join `bai_orders_db_confirm`
     on (`bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid`));