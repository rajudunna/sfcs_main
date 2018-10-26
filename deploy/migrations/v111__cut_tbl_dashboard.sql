USE central_administration_sfcs;
INSERT INTO tbl_menu_list (page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('SFCS_9016', '8', '5', '508', '1', '1', '/sfcs_app/app/dashboards/controllers/Cut_table_dashboard/cut_table_dashboard.php', 'Cut Table Dashboard (Warehouse)', '3', 'Cut table dashboard for cutting team'); 

INSERT INTO tbl_menu_list (page_id, fk_group_id, fk_app_id, parent_id, link_type, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('SFCS_9017', '8', '5', '508', '1', '1', '/sfcs_app/app/dashboards/controllers/Cut_table_dashboard/cut_table_dashboard_cutting.php', 'Cut Table Dashboard (Cutting)', '3', 'Cut table dashboard for Warehouse team');


INSERT INTO rbac_role_menu (menu_pid,menu_description,roll_id)VALUES ('1606','Cut Table Dashboard (Warehouse)','1'); 
INSERT INTO rbac_role_menu (menu_pid,menu_description,roll_id)VALUES ('1607','Cut Table Dashboard (Cutting)','1');

