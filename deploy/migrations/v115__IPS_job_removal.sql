/*USE central_administration_sfcs;*/
INSERT INTO central_administration_sfcs.tbl_menu_list(page_id,fk_group_id,fk_app_id,parent_id,link_type,
link_status,link_visibility,link_location,link_description,link_tool_tip,link_cmd)
VALUES ('SFCS_9005',8,8,212,1,1,1,'/sfcs_app/app/production/controllers/delete_0F_jobs_ips.php','  IPS jobs',6,'remove');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id) VALUES (1609,'Remove Jobs From IPS',1);


INSERT INTO central_administration_sfcs.tbl_menu_list(page_id,fk_group_id,fk_app_id,parent_id,link_type,link_status,link_visibility,link_location,link_description,link_tooltip,link_cmd)
VALUES('SFCS_00002','8','5','508','1','1','1','/sfcs_app/app/cutting/controllers/emb_cut_scanning/emb_cut_scanning.php','EMS Cut Scan','3','emsd');

INSERT INTO central_administration_sfcs.rbac_role_menu(menu_pid,menu_description,roll_id) VALUES(1610,'EMS SCAN','1');

	
/*USE bai_pro3;*/

create table bai_pro3.delete_jobs_log( 
   id int(11) NOT NULL AUTO_INCREMENT , 
   input_job_no_random int(15) , 
   username varchar(50) , 
   date_time datetime , 
   PRIMARY KEY (id)
);

alter table bai_pro3.cps_log add column reported_status varchar(15) NULL after remaining_qty;





