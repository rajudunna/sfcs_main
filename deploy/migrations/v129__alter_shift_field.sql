/*#1242*/
ALTER TABLE `bai_pro`.`tbl_freez_plan_upload` CHANGE `shift` `shift` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'Shift'; 
ALTER TABLE `bai_pro`.`tbl_freez_plan_tmp` CHANGE `shift` `shift` CHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift'; 
ALTER TABLE `bai_pro`.`tbl_freez_plan_log` CHANGE `shift` `shift` CHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift'; 
ALTER TABLE `bai_pro`.`pro_plan_today` CHANGE `shift` `shift` CHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift'; 
ALTER TABLE `bai_pro`.`pro_plan` CHANGE `shift` `shift` CHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift'; 
ALTER TABLE `bai_pro`.`pro_mod_today` CHANGE `mod_shift` `mod_shift` CHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift'; 
ALTER TABLE `bai_pro`.`pro_mod` CHANGE `mod_shift` `mod_shift` CHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift'; 
ALTER TABLE `bai_pro`.`grand_rep` CHANGE `shift` `shift` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift'; 
ALTER TABLE `bai_pro`.`bai_log_buf` CHANGE `bac_shift` `bac_shift` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift';
ALTER TABLE `bai_pro`.`bai_log` CHANGE `bac_shift` `bac_shift` VARCHAR(10) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Shift'; 