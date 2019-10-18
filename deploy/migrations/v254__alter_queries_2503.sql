/*#2503 new tables and menus */

/*#2483 not executed given in v251__new_tables_2483 */

USE bai_pro3;

ALTER TABLE bai_pro3.bai_orders_db ADD KEY schedule (order_del_no);

ALTER TABLE bai_pro3.docket_roll_info ADD KEY docket (docket);


USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list(menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1668','SFCS_0371', '8', '0', '109', '1', '1', '1','/sfcs_app/app/cutting/controllers/cut_reporting_without_rolls/generate_bundle_guide_report.php','Bundle Guide Form','17','');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1668', 'Bundle Guide Form', '1');


INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid, page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1669','SFCS_0559', '8', '4', '109', '1', '1', '1', '/sfcs_app/app/cutting/controllers/lay_plan_preparation/material_deallocation.php', 'Material Deallocation Form', '', '');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1669', 'Material Deallocation Form', '1');



USE bai_rm_pj1;

CREATE TABLE bai_rm_pj1.material_deallocation_track (
  id int(11) NOT NULL AUTO_INCREMENT,
  doc_no int(11) DEFAULT NULL,
  qty double DEFAULT NULL,
  requested_by varchar(30) DEFAULT NULL,
  requested_at datetime DEFAULT NULL,
  approved_by varchar(30) DEFAULT NULL,
  approved_at datetime DEFAULT NULL,
  status varchar(10) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


USE bai_pro3;
CREATE TABLE bai_pro3.maker_details (
  id int(11) NOT NULL AUTO_INCREMENT,
  parent_id int(11) NOT NULL,
  marker_type varchar(255) NOT NULL,
  marker_version varchar(255) NOT NULL,
  shrinkage_group varchar(255) NOT NULL,
  width varchar(20) NOT NULL,
  marker_length decimal(10,2) NOT NULL,
  marker_name varchar(255) NOT NULL,
  pattern_name varchar(255) NOT NULL,
  marker_eff varchar(255) NOT NULL,
  perimeters int(11) NOT NULL,
  remarks varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
  
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


ALTER TABLE bai_pro3.maker_stat_log ADD COLUMN marker_details_id INT(11) NULL; 

CREATE TABLE bai_pro3.marker_changes_log( tid INT NOT NULL AUTO_INCREMENT, user VARCHAR(25) NOT NULL, date_time VARCHAR(25) NOT NULL, doc_no INT(25) NOT NULL, alloc_ref INT(50) NOT NULL, mk_ref_id INT(50) NOT NULL, PRIMARY KEY (tid) );


ALTER TABLE bai_pro3.maker_details CHANGE remarks remarks1 VARCHAR(255) CHARSET latin1 COLLATE latin1_swedish_ci NULL, ADD COLUMN remarks2 VARCHAR(255) NULL AFTER remarks1, ADD COLUMN remarks3 VARCHAR(255) NULL AFTER remarks2, ADD COLUMN remarks4 VARCHAR(255) NULL AFTER remarks3; 

ALTER TABLE bai_pro3.maker_details CHANGE perimeters perimeters VARCHAR(255) NOT NULL; 

ALTER TABLE bai_pro3.plandoc_stat_log  ADD COLUMN mk_ref_id INT(11) NULL;