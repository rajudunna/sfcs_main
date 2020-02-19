/*#2825 alter query */

USE `bai_rm_pj1`;

ALTER TABLE `bai_rm_pj1`.`store_in_deleted`  
 ADD COLUMN `shade_grp` VARCHAR(10) NULL AFTER `ref_tid`,
 ADD COLUMN `act_width_grp` VARCHAR(10) NULL AFTER `shade_grp`,
 ADD COLUMN `supplier_no` VARCHAR(10) DEFAULT '0' NOT NULL AFTER `act_width_grp`,
 ADD COLUMN `four_point_status` INT(10) DEFAULT 0 NOT NULL AFTER `supplier_no`; 
 
ALTER TABLE `bai_rm_pj1`.`store_in_backup`  
 ADD COLUMN `shade_grp` VARCHAR(10) NULL AFTER `ref_tid`,
 ADD COLUMN `act_width_grp` VARCHAR(10) NULL AFTER `shade_grp`,
 ADD COLUMN `supplier_no` VARCHAR(10) DEFAULT '0' NOT NULL AFTER `act_width_grp`,
 ADD COLUMN `four_point_status` INT(10) DEFAULT 0 NOT NULL AFTER `supplier_no`; 
