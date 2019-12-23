/*#2996 alter query */


INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,
    link_cmd) VALUES("1678", "SFCS_0071", "8", "8", "70", "1", "1", "1", "/sfcs_app/app/production/reports/mini_order_bundle_wise_report.php"
, "Bundle or Sewing Job Wise Perfomance Report", "", "");

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid,menu_description,roll_id) VALUES ("1678", "Bundle or Sewing Job Wise Perfomance Report", "1");


ALTER TABLE `brandix_bts`.`bundle_creation_data_temp` ADD KEY `style_operation` (`style`, `operation_id`);

ALTER TABLE `brandix_bts`.`tbl_orders_ops_ref` ADD KEY `op_code_category` (`operation_code`, `category`);

