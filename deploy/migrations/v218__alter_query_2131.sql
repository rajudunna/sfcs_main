/*#2131 alter query*/

USE `bai_pro3`;

ALTER TABLE `bai_pro3`.`plandoc_stat_log` ADD COLUMN `reference` VARCHAR(50) NULL COMMENT 'Store reference' AFTER `docket_printed_person`; 