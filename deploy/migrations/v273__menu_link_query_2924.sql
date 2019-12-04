/*#2924 menu link query */

USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1674', 'SFCS_0371', '8', '0', '109', '1', '1', '1', '/sfcs_app/app/cutting/controllers/reconcillation_sheet.php', 'Module Input Sheet', '17', '');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1674', 'Module Input Sheet', '1');