/*#923*/
USE central_administration_sfcs;
INSERT INTO tbl_menu_list(menu_pid,page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd) VALUES ('1614','SFCS_9005',8,8,212,1,1,1,'/sfcs_app/app/production/controllers/delete_0F_jobs_ips.php','IPS jobs',6,'remove');

INSERT INTO rbac_role_menu(menu_pid,menu_description,roll_id) VALUES (1614,'Remove Jobs From IPS',1);

INSERT INTO tbl_menu_list(page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tooltip,link_cmd)
VALUES('1615','SFCS_00002','8','5','508','1','1','1','/sfcs_app/app/cutting/controllers/emb_cut_scanning/emb_cut_scanning.php','EMS Cut Scan','3','emsd');

INSERT INTO rbac_role_menu(menu_pid,menu_description,roll_id) VALUES(1615,'EMS Cut Scan','1');





