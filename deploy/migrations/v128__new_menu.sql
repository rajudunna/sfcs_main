/*824*/
USE central_administration_sfcs;
INSERT INTO tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd)VALUES("1616","SFCS_0370","8","0","109","1","1","1","/sfcs_app/app/production/controllers/reversal_docket/reversal_docket_form.php","Cutting Reversal","16","");

insert into central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id)values(1616,"Cutting Reversal","1");
