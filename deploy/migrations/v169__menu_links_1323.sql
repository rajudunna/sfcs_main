
/*1323 new menus*/
INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,
link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd)
VALUES ('1646','SFCS_9006',8,8,1487,1,1,1,'/sfcs_app/app/production/controllers/ratio split/ratio_split_interface.php','Ratio Splitting',2,'split');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id)
VALUES (1646,'Ratio Splitting',1);


