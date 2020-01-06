/*#2084 alter table*/
USE `bai_pro3`;

ALTER TABLE `bai_pro3`.`act_cut_status`
ADD COLUMN `joints_endbits` VARCHAR
(100) NULL COMMENT 'Store Joints & Endbits' AFTER `leader_name`;

UPDATE `bai_pro3`.`act_cut_status`
SET
`joints_endbits` = '0^0';