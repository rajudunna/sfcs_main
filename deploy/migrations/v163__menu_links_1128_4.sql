/*1128 new menus*/
INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd) VALUES ('1637','SFCS_9005',8,5,508,1,1,1,'/sfcs_app/app/dashboards/controllers/recut_dashboards/recut_dashboard_view.php','Rejection Dashboard',1,'Recut');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id) VALUES ('1637','Rejection Dashboard',1);

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd) VALUES ('1638','SFCS_9006',8,5,508,1,1,1,'/sfcs_app/app/dashboards/controllers/recut_dashboards/recut_dashboard_issue.php','RECUT Dashboard Issue',1,'Recut');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id) VALUES ('1638','Recut Dashboard Issue',1);

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd) VALUES ('1639','SFCS_9007',8,5,508,1,1,1,'/sfcs_app/app/dashboards/controllers/recut_dashboards/recut_dashboard_approval.php','RECUT Dashboard Approval',1,'Recut');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id) VALUES ('1639','Recut Dashboard Approval',1);

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd) VALUES ('1640','SFCS_0001',8,8,109,1,1,1,'/sfcs_app/app/cutting/controllers/cut_reporting_without_rolls/cut_reporting_interface.php','Cut Qty Reporting(New)',3,1);

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id) VALUES ('1640','Cut Qty Reporting(New)',1);

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd)VALUES ('1641','SFCS_0560',8,4,2,1,1,1,'/sfcs_app/app/dashboards/controllers/recut_dashboards/recut_report_view.php','Recut Report',2,1);

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id)VALUES ('1641','Recut Report',1);