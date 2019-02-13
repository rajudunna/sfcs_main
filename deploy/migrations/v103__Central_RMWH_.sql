
/*USE bai_rm_pj1;*/


ALTER TABLE bai_rm_pj1.store_in
  CHANGE log_user log_user VARCHAR(50) NOT NULL;

ALTER TABLE bai_rm_pj1.store_in
  ADD COLUMN barcode_number VARCHAR(255) NULL AFTER split_roll,
  ADD COLUMN ref_tid INT(11) DEFAULT 0 NULL AFTER barcode_number;
 
ALTER TABLE bai_rm_pj1.store_in_deleted
  ADD COLUMN barcode_number VARCHAR(255) NULL AFTER split_roll,
  ADD COLUMN ref_tid INT(11) DEFAULT 0 NULL AFTER barcode_number;

/*USE central_administration_sfcs;*/

/* insert into central_administration_sfcs.tbl_menu_list (page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility,  link_location, link_description, link_tool_tip, link_cmd) values('SFCS_9021','8','10','179','1','1','1','/sfcs_app/app/warehouse/controllers/scanV2.php','RM Warehouse Material Receive','','');

insert into central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) values('1594','RM Warehouse Material Receive','1'); */



/*USE bai_pro3;*/

CREATE TABLE bai_pro3.plant_details (
  id int(11) NOT NULL AUTO_INCREMENT,
  date_time timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  plant_code varchar(10) DEFAULT NULL,
  plant_name varchar(200) DEFAULT NULL,
  ip_address varchar(15) DEFAULT NULL,
  port_number int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


  ALTER TABLE bai_pro3.plant_details
  ADD COLUMN database_type VARCHAR(200) NULL AFTER port_number;
  
  
  ALTER TABLE bai_pro3.plant_details
  ADD COLUMN username VARCHAR(200) NULL AFTER database_type,
  ADD COLUMN password VARCHAR(200) NULL AFTER username;







