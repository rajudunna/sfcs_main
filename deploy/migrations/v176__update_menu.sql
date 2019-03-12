/*#1553 menu link access*/

insert into central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) values('1648','Cut Based Sewing Job Generation','1');

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1649','SFCS_00001', '8', '8', '109', '1', '1', '1', '/sfcs_app/app/cutting/controllers/check_list/bundle_check_list.php', 'Bundle Check List', '3', '1'); 

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES('1649','Bundle Check List','1');