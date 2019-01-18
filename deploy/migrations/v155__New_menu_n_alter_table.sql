/*#935 new menus and alter table*/
insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1634','SFCS_0012','8','0','1548','1','1','1','/sfcs_app/app/masters/surplus/surplus_table.php','Surplus Locations','31','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1623','SFCS_9008','8','0','1548','1','1','1','/sfcs_app/app/masters/Inspection_rejection_reasons/save_inspection_rej_reasons.php','Inspection Rejection Reasons','33','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1624','SFCS_9009','8','0','1548','1','1','1','/sfcs_app/app/masters/mrn _request _reasons/save_mrn_req_reasons.php','MRN Request Reasons','35','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1625','SFCS_9010','8','0','1548','1','1','1','/sfcs_app/app/masters/downtime_reason/down_time_reason_add.php','Downtime Reasons','37','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1626','SFCS_9011','8','0','1548','1','1','1','/sfcs_app/app/masters/sewing_jobs_prefix/sewing_jobs_prefix_add.php','Sewing Jobs Prefix','39','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1627','SFCS_9012','8','0','1548','1','1','1','/sfcs_app/app/masters/plant_timings/plant_timings_add.php','Plant Timings','43','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1628','SFCS_9014','8','0','1548','1','1','1','/sfcs_app/app/masters/transport_modes/transport_modes_add.php','Transport Modes','21','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1629','SFCS_9015','8','0','1548','1','1','1','/sfcs_app/app/masters/suppliers_master_data/save_suppliers_master_data.php','Suppliers Master Data','29','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1630','SFCS_9017','8','0','1548','1','1','1','/sfcs_app/app/masters/cuttings/cutting_table_add.php','Cutting Team Leader Names','20','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`, `page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1631','SFCS_9019','8','0','1548','1','1','1','/sfcs_app/app/masters/inspection_supplier_claim_reasons/save_inspection_supplier_claim_reasons.php','Inspection Supplier Claim Reasons','32','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1632','SFCS_0505','8','0','1548','1','1','1','/sfcs_app/app/masters/handover_team_list/save_handover_team_list.php','Carton Handover Users List','34','');

insert into central_administration_sfcs.tbl_menu_list ( `menu_pid`,`page_id`, `fk_group_id`, `fk_app_id`, `parent_id`, `link_type`, `link_status`, `link_visibility`, `link_location`, `link_description`, `link_tool_tip`, `link_cmd`) values('1633','SFCS_9009','8','0','1548','1','1','1','/sfcs_app/app/masters/production_rejection_reasons/save_production_rejection_reasons.php','Production Rejection Reasons','45','');


insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1634','Surplus Locations','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1623','Inspection Rejection Reasons','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1624','MRN Request Reasons','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1625','Downtime Reasons','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1626','Sewing Jobs Prefix','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1627','Plant Timings','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1628','Transport Modes','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1629','Suppliers Master Data','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1630','Cutting Team Leader Names','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1631','Inspection Supplier Claim Reasons','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1632','Carton Handover Users List','1');
insert into central_administration_sfcs.rbac_role_menu ( `menu_pid`, `menu_description`, `roll_id`) values('1633','Production Rejection Reasons','1');

	ALTER TABLE brandix_bts.tbl_sewing_job_prefix MODIFY id INT AUTO_INCREMENT PRIMARY KEY;

	ALTER TABLE bai_rm_pj1.inspection_complaint_reasons ADD COLUMN tid INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;
 