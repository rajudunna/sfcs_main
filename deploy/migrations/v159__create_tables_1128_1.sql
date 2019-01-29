/*
#1128 new tables and alter tables
CREATE TABLE `bai_pro3`.`bai_qms_rejection_reason` (
  `sno` double NOT NULL AUTO_INCREMENT,
  `reason_cat` varchar(150) DEFAULT NULL,
  `reason_desc` varchar(150) DEFAULT NULL,
  `reason_code` double DEFAULT NULL,
  `reason_order` double DEFAULT NULL,
  `form_type` varchar(5) DEFAULT NULL,
  `m3_reason_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;*/
CREATE TABLE `bai_pro3`.`rejections_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style` varchar(20) DEFAULT NULL,
  `schedule` varchar(20) DEFAULT NULL,
  `color` varchar(60) DEFAULT NULL,
  `rejected_qty` int(10) DEFAULT NULL,
  `replaced_qty` int(10) DEFAULT '0',
  `recut_qty` int(10) DEFAULT NULL,
  `remaining_qty` int(10) DEFAULT NULL,
  `status` char(1) DEFAULT 'P',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
CREATE TABLE `bai_pro3`.`rejection_log_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `bcd_id` int(11) DEFAULT NULL,
  `doc_no` int(11) DEFAULT NULL,
  `input_job_no_random_ref` varchar(250) DEFAULT NULL,
  `size_id` varchar(50) DEFAULT NULL,
  `size_title` varchar(10) DEFAULT NULL,
  `assigned_module` varchar(10) DEFAULT NULL,
  `rejected_qty` int(11) DEFAULT NULL,
  `recut_qty` int(11) DEFAULT '0',
  `replaced_qty` int(11) DEFAULT '0',
  `issued_qty` int(11) DEFAULT '0',
  `operation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
CREATE TABLE `bai_pro3`.`rejections_reason_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL COMMENT 'id of rejection log',
  `date_time` timestamp NULL DEFAULT NULL,
  `bcd_id` int(11) NOT NULL,
  `rejection_reason` varchar(10) DEFAULT NULL,
  `rejected_qty` int(10) DEFAULT NULL,
  `form_type` char(2) DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
CREATE TABLE `bai_pro3`.`replacment_allocation_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bcd_id` int(11) NOT NULL,
  `input_job_no_random_ref` varchar(250) NOT NULL,
  `replaced_qty` int(11) NOT NULL,
  `size_title` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE `bai_pro3`.`recut_v2_child`; 
CREATE TABLE `bai_pro3`.`recut_v2_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `size_id` varchar(20) DEFAULT NULL,
  `bcd_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `rejected_qty` int(6) DEFAULT NULL,
  `recut_qty` int(6) NOT NULL,
  `recut_reported_qty` int(6) DEFAULT '0',
  `issued_qty` int(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

ALTER TABLE `brandix_bts`.`bundle_creation_data`  ADD COLUMN `recut_in` INT(10) DEFAULT 0 NOT NULL AFTER `cancel_qty`, ADD COLUMN `replace_in` INT(10) DEFAULT 0 NOT NULL AFTER `recut_in`;

