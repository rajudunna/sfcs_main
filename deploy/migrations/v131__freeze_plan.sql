/*#1261*/

ALTER TABLE `bai_pro`.`pro_plan` CHANGE `plan_tag` `plan_tag` VARCHAR(50) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL;
Alter table `bai_pro`.`tbl_freez_plan_upload` ADD COLUMN `nop` int(5) DEFAULT 0  NOT NULL  COMMENT 'fixed number of operators' after `module`;
ALTER TABLE `bai_pro`.`tbl_freez_plan_tmp` ADD COLUMN `nop` INT(5) DEFAULT 0  NOT NULL COMMENT 'fixed number of operators' AFTER `plan_sah`;
ALTER TABLE `bai_pro`.`tbl_freez_plan_log` ADD COLUMN `nop` INT(5) DEFAULT 0  NOT NULL COMMENT 'fixed number of operators' AFTER `plan_sah`;
UPDATE `bai_pro`.`tbl_freez_plan_upload` SET nop=0;
UPDATE `bai_pro`.`tbl_freez_plan_tmp` SET nop=0;
UPDATE `bai_pro`.`tbl_freez_plan_log` SET nop=0;
