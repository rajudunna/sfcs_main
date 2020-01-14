/*#2352 alter query */
USE bai_pro3;
ALTER TABLE bai_pro3.cps_log ADD KEY (doc_no, size_title, operation_code); 

USE bai_pro2;
ALTER TABLE bai_pro2.hout ADD KEY hout_out_date_team (out_date, team, time_parent_id); 

USE bai_pro;
ALTER TABLE bai_pro.pro_attendance ADD KEY attendance (date, module, shift); 


USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1682', 'SFCS_9022','8','8','1487','1','1','1','/sfcs_app/app/production/controllers/sewing_job/bundle_scanning_new/barcode_scanning_new.php', 'Barcode scanning new','','');
INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1682', 'Barcode scanning new', '1');