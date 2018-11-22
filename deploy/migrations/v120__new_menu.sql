USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd)
VALUES('1613','SFCS_00002','8','5','508','1','1','1','/sfcs_app/app/cutting/controllers/emb_cut_scanning/emb_cut_scanning.php','ems cut scan','3','emsd');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id)VALUES('1613','EMS SCAN','1');