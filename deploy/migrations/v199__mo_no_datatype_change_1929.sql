/*#1929 Alter table*/


USE `bai_pro3`;
ALTER TABLE `bai_pro3`.`bai_orders_db_mo` CHANGE `mo_number` `mo_number` VARCHAR
(20)  NOT NULL COMMENT 'mo number';
ALTER TABLE `bai_pro3`.`m3_transactions` CHANGE `mo_no` `mo_no` VARCHAR
(20)  NULL;
ALTER TABLE `bai_pro3`.`m3_transactions_archive` CHANGE `mo_no` `mo_no` VARCHAR
(20)  NULL;
ALTER TABLE `bai_pro3`.`mo_details` CHANGE `mo_no` `mo_no` VARCHAR
(20)  NULL;
ALTER TABLE `bai_pro3`.`mo_details_archive` CHANGE `mo_no` `mo_no` VARCHAR
(20)  NULL;
ALTER TABLE `bai_pro3`.`mo_operation_quantites` CHANGE `mo_no` `mo_no` VARCHAR
(20) NULL;
ALTER TABLE `bai_pro3`.`mo_operation_quantites_archive` CHANGE `mo_no` `mo_no` VARCHAR
(20)  NULL;
ALTER TABLE `bai_pro3`.`schedule_oprations_master` CHANGE `MONumber` `MONumber` VARCHAR
(20) NULL;
ALTER TABLE `bai_pro3`.`schedule_oprations_master_backup` CHANGE `MONumber` `MONumber` VARCHAR
(20) NULL;
ALTER TABLE `bai_pro3`.`tbl_carton_ready` CHANGE `mo_no` `mo_no` VARCHAR
(20) NOT NULL;
ALTER TABLE `bai_pro3`.`bai_emb_db` CHANGE `mo_no` `mo_no` VARCHAR
(20)  NOT NULL;
USE `m3_inputs`;
ALTER TABLE `m3_inputs`.`bom_details` CHANGE `mo_no` `mo_no` VARCHAR
(20)  NULL;
ALTER TABLE `m3_inputs`.`mo_details` CHANGE `MONUMBER` `MONUMBER` VARCHAR
(20) NULL;
ALTER TABLE `m3_inputs`.`order_details` CHANGE `MO_NUMBER` `MO_NUMBER` VARCHAR
(20)  NULL;
ALTER TABLE `m3_inputs`.`order_details_original` CHANGE `MO_NUMBER` `MO_NUMBER` VARCHAR
(20)  NULL;