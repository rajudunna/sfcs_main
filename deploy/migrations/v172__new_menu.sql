/*1435 new menus*/

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description, link_tool_tip) VALUES ('1647','SFCS_9011', '8', '1', '168', '1', '1', '/sfcs_app/app/quality/controllers/delete_samples.php', 'Delete Samples', '1');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1647', 'Delete Samples', '1');