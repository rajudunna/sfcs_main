USE `bai_pro3`;

/* Alter table in target */
ALTER TABLE `module_master` 
	ADD COLUMN `color` varchar(255) NULL after `section` , 
	ADD COLUMN `label` varchar(255) NULL after `color` ;