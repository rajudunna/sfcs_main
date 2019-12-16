/*#2923 menu link query */


USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1675', 'SFCS_0372', '8', '0', '109', '1', '1', '1', '/sfcs_app/app/cutting/controllers/cut_docket_allocate_form.php', 'Cut Docket Allocation Form', '18', '');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1675', 'Cut Docket Allocation Form', '1');