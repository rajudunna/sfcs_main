/*#2395 alter query */

USE bai_pro3;

CREATE TABLE `bai_pro3`.`emb_bundles`
(
  `tid` int
(11) NOT NULL AUTO_INCREMENT,
  `doc_no` int
(11) DEFAULT NULL,
  `size` varchar
(30) DEFAULT NULL,
  `ops_code` int
(11) DEFAULT NULL,
  `barcode` varchar
(60) DEFAULT NULL,
  `quantity` int
(10) DEFAULT NULL,
  `good_qty` int
(10) DEFAULT NULL,
  `reject_qty` int
(10) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `club_status` int
(4) DEFAULT NULL,
  `log_user` varchar
(60) DEFAULT NULL,
  `tran_id` int
(100) DEFAULT NULL,
  `status` int
(2) DEFAULT NULL,
  `report_seq` int
(11) DEFAULT NULL,
  `print_status` int
(11) DEFAULT NULL,
  `shade` varchar
(50) DEFAULT NULL,
  `num_id` int
(50) DEFAULT NULL COMMENT 'numbering infomration',
  PRIMARY KEY
(`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE bai_pro3.`emb_bundles_temp`
(
  `tid` int
(11) NOT NULL AUTO_INCREMENT,
  `doc_no` int
(11) DEFAULT NULL,
  `size` varchar
(30) DEFAULT NULL,
  `ops_code` int
(11) DEFAULT NULL,
  `barcode` varchar
(60) DEFAULT NULL,
  `quantity` int
(10) DEFAULT NULL,
  `good_qty` int
(10) DEFAULT NULL,
  `reject_qty` int
(10) DEFAULT NULL,
  `insert_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `club_status` int
(4) DEFAULT NULL,
  `log_user` varchar
(60) DEFAULT NULL,
  `tran_id` int
(100) DEFAULT NULL,
  `status` int
(2) DEFAULT NULL,
  PRIMARY KEY
(`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE bai_pro3.`emb_reprint_track`
(
  `id` int
(11) NOT NULL AUTO_INCREMENT,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp
(),
  `barcode` varchar
(100) DEFAULT NULL,
  `shift` varchar
(50) DEFAULT NULL,
  `emp_id` varchar
(100) DEFAULT NULL,
  `remarks` varchar
(200) DEFAULT NULL,
  `username` varchar
(100) DEFAULT NULL,
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `bai_pro3`.`docket_roll_info` ADD COLUMN `status` INT (3) DEFAULT 0 NULL AFTER `fabric_return`;

USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type,link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1670', 'SFCS_0371', '8', '0', '109', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/emb_scanning.php', 'Emblishment Bundle Scanning', '17', '');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1670', 'Emblishment Bundle Scanning', '1');


INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type,link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1671', 'SFCS_0371', '8', '0', '109', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/emb_revarsal.php', 'Emblishment Bundle Revarsal', '18', '');


INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1671', 'Emblishment Bundle Revarsal', '1');



INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1672', 'SFCS_0006', '8', '4', '109', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/emb_barcode_reprint.php', 'Embellishment Barcode Re-Print', '1', '');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1672', 'Embellishment Barcode Re-Print', '1');

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1673', 'SFCS_0006', '8', '4', '109', '1', '1', '1', '/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/emb_barcode_bulk_print.php', 'Embellishment Barcode Print', '1', '');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1673', 'Embellishment Barcode Print', '1');
