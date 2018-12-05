/*USE central_administration_sfcs;*/

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description, link_tool_tip, link_cmd) 
VALUES ('1612', 'SFCS_0379', '8', '8', '1487', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/create_sewing_job_packlist.php', 'Create Sewing Jobs (Packing List Based)', '1', ''); 

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1612', 'Create Sewing Jobs (Packing List Based)', '1');