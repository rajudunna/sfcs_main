USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list (page_id,fk_group_id,fk_app_id,parent_id,link_type,link_visibility,link_location,link_description) VALUES ('SFCS_0556', '8', '1', '49', '1', '1', '/sfcs_app/app/production/reports/style_wip_main.php', 'Style Wip Report'); 


INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid,menu_description,roll_id) VALUES ('1614', 'Style Wip Report', '1');