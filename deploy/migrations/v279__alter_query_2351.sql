/*#2351 alter queries */

USE central_administration_sfcs;

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES ('1676','SFCS_0052','8','3','127','1','1','1','/sfcs_app/app/inspection/controllers/digital_inspection/digital_inspection_report.php','Digital Inspection Report','1','');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1676','Digital Inspection Report', '1');

INSERT INTO central_administration_sfcs.tbl_menu_list (menu_pid,page_id, fk_group_id, fk_app_id, parent_id, link_type, link_status, link_visibility, link_location, link_description, link_tool_tip, link_cmd) VALUES('1677','SFCS_0055','8','3','24','1','1','1','/sfcs_app/app/inspection/reports/pending_inspection_report.php','4 Point Inspection Report','1','');

INSERT INTO central_administration_sfcs.rbac_role_menu (menu_pid, menu_description, roll_id) VALUES ('1677','4 Point Inspection Report', '1');

USE bai_rm_pj1;

CREATE TABLE bai_rm_pj1.`main_population_tbl` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `no_of_rolls` int(20) DEFAULT NULL,
  `qty` float(10,2) DEFAULT NULL,
  `supplier` text,
  `invoice_no` text,
  `batch` text,
  `lot_no` text,
  `rm_color` text,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fab_composition` varchar(225) DEFAULT NULL,
  `tolerence` varchar(25) DEFAULT NULL,
  `s_width` varchar(25) DEFAULT NULL,
  `s_weight` varchar(25) DEFAULT NULL,
  `repeat_len` varchar(25) DEFAULT NULL,
  `lab_testing` varchar(25) DEFAULT NULL,
  `remarks` VARCHAR(50) DEFAULT NULL,
  `status` int(4) DEFAULT '1' COMMENT '1- pending, 2- inprogress, 3- close',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `bai_rm_pj1`.`roll_inspection` (
`id` int(20) NOT NULL AUTO_INCREMENT,
 `po_no` varchar(300) NOT NULL,
  `batch_no` varchar(600) NOT NULL,
  `color` varchar(600) NOT NULL,
  PRIMARY KEY (`po_no`,`batch_no`,`color`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `bai_rm_pj1`.`roll_inspection_child` (
  `sno` int(20) NOT NULL AUTO_INCREMENT,
  `inspection_status` varchar(150) DEFAULT NULL,
  `inspected_per` float DEFAULT NULL,
  `inspected_qty` double DEFAULT NULL,
  `width_s` double DEFAULT NULL,
  `width_m` double DEFAULT NULL,
  `width_e` double DEFAULT NULL,
  `actual_height` int(20) DEFAULT NULL,
  `actual_repeat_height` int(20) DEFAULT NULL,
  `skw` varchar(150) DEFAULT NULL,
  `bow` varchar(150) DEFAULT NULL,
  `ver` varchar(150) DEFAULT NULL,
  `gsm` varchar(150) DEFAULT NULL,
  `comment` varchar(450) DEFAULT NULL,
  `marker_type` varchar(450) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `status` int(10) NOT NULL,
  `store_in_tid` int(10) NOT NULL,
  PRIMARY KEY (`sno`),
  UNIQUE KEY `where_clause` (`store_in_tid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `bai_rm_pj1`.`four_points_table` (
`insp_child_id` int(10) NOT NULL,
 `code` varchar(20) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `points` INT(10) NULL,
  `selected_point` INT(10) NULL,
  KEY `insp_child_id` (`insp_child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 CREATE TABLE `bai_rm_pj1`.`inspection_population` (
  `sno` int(10) NOT NULL AUTO_INCREMENT,
  `lot_no` varchar(100) DEFAULT NULL,
  `supplier_po` int(50) DEFAULT NULL,
  `po_line` int(50) DEFAULT NULL,
  `po_subline` int(50) DEFAULT NULL,
  `supplier_invoice` varchar(150) DEFAULT NULL,
  `item_code` varchar(150) DEFAULT NULL,
  `item_desc` varchar(150) DEFAULT NULL,
  `item_name` VARCHAR(150) DEFAULT NULL,
  `supplier_batch` varchar(150) DEFAULT NULL,
  `rm_color` varchar(150) DEFAULT NULL,
  `supplier_roll_no` VARCHAR(50) DEFAULT NULL,
  `sfcs_roll_no` VARCHAR(50) DEFAULT NULL,
  `rec_qty` FLOAT(10,2) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `parent_id` int(10) NOT NULL,
  `store_in_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`sno`),
  KEY `sno` (`sno`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



ALTER TABLE `bai_rm_pj1`.`sticker_report` ADD COLUMN `rm_color` VARCHAR(255) NULL AFTER `po_subline`; 

ALTER TABLE `bai_rm_pj1`.`sticker_report_deleted` ADD COLUMN `rm_color` VARCHAR(255) NULL AFTER `po_subline`;
 