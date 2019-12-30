/*#2997 alter query */

USE brandix_bts;

ALTER TABLE `brandix_bts`.`bundle_creation_data` ADD KEY `reverse_sewing` (`operation_id`, `assigned_module`,`input_job_no_random_ref`);
ALTER TABLE `brandix_bts`.`bundle_creation_data_temp` ADD KEY `date_time_key`(`date_time`, `operation_id`);
ALTER TABLE `brandix_bts`.`bundle_creation_data_temp` ADD KEY `reverse_sewing_1`(`color`, `size_title`, `assigned_module`, `input_job_no_random_ref`);
ALTER TABLE `brandix_bts`.`bundle_creation_data_temp` ADD KEY `reverse_sewing_2` (`operation_id`, `assigned_module`, `input_job_no_random_ref`);

USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd) VALUES("1679", "SFCS_0071", "8", "8", "70", "1", "1", "1", "/sfcs_app/app/production/reports/day_wise_report.php","Day wise Perfomance Report", "", "");

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid,menu_description,roll_id) VALUES("1679", "Day wise Perfomance Report", "1");