/*#2483 new tables and menus */

/*#2419 not executed  due to duplicate menu_pid given in v247__adding menu_2419*/

USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list
    (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd)
VALUES('1667', 'SFCS_9023', '8', '8', '1487', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/bundle_transfer.php', 'Bundle Transfer Barcode Scanning', '16', '');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1667',
        'Bundle Transfer Barcode Scanning', '1');


USE bai_pro3;

ALTER TABLE bai_pro3.ims_log
ADD KEY pac_tid
(pac_tid, operation_id);


USE brandix_bts;

CREATE TABLE brandix_bts.module_transfer_track
(
 id INT
(10) NOT NULL AUTO_INCREMENT,
 username VARCHAR
(150) DEFAULT NULL,
 bundle_number INT
(50) DEFAULT NULL,
 operation_code INT
(20) DEFAULT NULL,
 from_module VARCHAR
(90) DEFAULT NULL,
 to_module VARCHAR
(90) DEFAULT NULL,
 time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
() ON
UPDATE CURRENT_TIMESTAMP(),
 PRIMARY KEY
(id)
);


DROP INDEX IF EXISTS barcode_number
ON brandix_bts.bundle_creation_data;

ALTER TABLE brandix_bts.bundle_creation_data
ADD KEY barcode
(barcode_number);


USE bai_pro3;

CREATE TABLE bai_pro3.docket_roll_info
(
  id int
(11) NOT NULL AUTO_INCREMENT,
  style varchar
(25) DEFAULT NULL,
  schedule varchar
(50) DEFAULT NULL,
  color varchar
(50) DEFAULT NULL,
  docket int
(11) DEFAULT NULL,
  lay_sequence int
(11) DEFAULT NULL,
  roll_no int
(11) DEFAULT NULL,
  shade char
(255) DEFAULT NULL,
  width decimal
(10,2) DEFAULT NULL,
  fabric_rec_qty decimal
(10,2) DEFAULT NULL,
  reporting_plies int
(11) DEFAULT NULL,
  damages decimal
(10,2) DEFAULT NULL,
  joints decimal
(10,2) DEFAULT NULL,
  endbits decimal
(10,2) DEFAULT NULL,
  shortages decimal
(10,2) DEFAULT NULL,
  fabric_return decimal
(10,2) DEFAULT NULL,
  KEY id
(id)
);



CREATE TABLE bai_pro3.docket_number_info
(
  id int
(11) NOT NULL AUTO_INCREMENT,
  doc_no int
(11) DEFAULT NULL,
  size varchar
(25) DEFAULT NULL,
  bundle_no int
(11) DEFAULT NULL,
  shade_bundle varchar
(25) DEFAULT NULL,
  shade varchar
(25) DEFAULT NULL,
  bundle_start int
(25) DEFAULT NULL,
  bundle_end int
(25) DEFAULT NULL,
  qty int
(25) DEFAULT NULL,
  PRIMARY KEY
(id),
  KEY doc_no
(doc_no)
);


ALTER TABLE bai_pro3.docket_number_info
ADD KEY doc_no
(doc_no);
/*
ALTER TABLE bai_pro3.bai_orders_db
ADD KEY schedule
(order_del_no);

ALTER TABLE bai_pro3.docket_roll_info
ADD KEY docket
(docket);


USE central_administration_sfcs;

INSERT INTO 
central_administration_sfcs.tbl_menu_list

(menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES
('1668','SFCS_0371', '8', '0', '109', '1', '1', '1','/sfcs_app/app/cutting/controllers/cut_reporting_without_rolls/generate_bundle_guide_report.php','Bundle Guide Form','17','');

INSERT INTO central_administration_sfcs.rbac_role_menu
    (menu_pid, menu_description, roll_id)
VALUES
    ('1668', 'Bundle Guide Form', '1'); */


