
/*#1727 alter queries*/

USE `bai_pro3`;

ALTER TABLE `bai_pro3`.`mo_details`
ADD INDEX `mo_details_ix5`
(`style`, `schedule`, `color`, `size`);

ALTER TABLE `bai_pro3`.`schedule_oprations_master`
ADD KEY `schedule_opr_master_ix4`
(`Style`, `Description`, `Main_OperationNumber`, `SMV`);

ALTER TABLE `bai_pro3`.`tbl_cutting_table`
ADD KEY `cutting_table_ix3`
(`status`);

ALTER TABLE `bai_pro3`.`cutting_table_plan`
ADD INDEX `cutting_table_plan_ix2`
(`cutting_tbl_id`);

ALTER TABLE `bai_pro3`.`cutting_table_plan` CHANGE `doc_no` `doc_no` INT
(11) NOT NULL;

ALTER TABLE `bai_pro3`.`cutting_table_plan`
ADD INDEX `cutting_table_plan_ix3`
(`doc_no`);

ALTER TABLE `bai_pro3`.`cuttable_stat_log`
ADD INDEX `cuttable_stat_log_ix3`
(`cat_id`);