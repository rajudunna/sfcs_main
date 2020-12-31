ALTER TABLE `pms`.`pro_atten_hours` ADD COLUMN `break_hours` INT(3) NULL AFTER `updated_at`;
ALTER TABLE `pms`.`pro_atten_hours` CHANGE `start_time` `start_time` VARCHAR(10) NOT NULL, CHANGE `end_time` `end_time` VARCHAR(10) NOT NULL;
ALTER TABLE `pms`.`pro_attendance` ADD COLUMN `break_hours` INT(3) NULL AFTER `updated_at`; 
ALTER TABLE `pms`.`pro_attendance` CHANGE `absent` `absent` INT(10) UNSIGNED DEFAULT 0 NOT NULL;

ALTER TABLE `pms`.`pro_attendance` CHANGE `shift` `shift` VARCHAR(40) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL; 