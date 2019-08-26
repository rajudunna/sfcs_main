/*#2067 create promise tables*/

USE `bai_pro3`;

CREATE TABLE `bai_pro3`.`job_pro_track`
( `input_job_no_random` VARCHAR
(50) NOT NULL, `log_time` VARCHAR
(50), PRIMARY KEY
(`input_job_no_random`) );

CREATE TABLE `bai_pro3`.`promis_module_mapping`
( `sfcs_module_name` VARCHAR
(50) NOT NULL, `promis_division_code` VARCHAR
(50), `promis_division_name` VARCHAR
(50), PRIMARY KEY
(`sfcs_module_name`) );

CREATE TABLE `bai_pro3`.`promis_ops_mapping`
( `sfcs_operation_id` INT
(10) NOT NULL, `promis_operation_id` INT
(10) NOT NULL, `flag` INT
(10) DEFAULT 0 COMMENT '0- Not Consider, 1- non scan, 2- Scan', PRIMARY KEY
(`sfcs_operation_id`) );

ALTER TABLE `bai_pro3`.`m3_transactions`
ADD COLUMN `promis_status` INT
(5) DEFAULT 0 NULL COMMENT '0- pending, 1- completed' AFTER `api_type`;

DROP VIEW IF EXISTS `bai_pro3`.`promisdata`;


CREATE VIEW `bai_pro3`.`promisdata` AS
(
SELECT `moq`.`ref_no
` AS `barcode`,
`mos`.`REFERENCEORDER` AS `co_id`,
`mos`.`COLORCODE` AS `colour_code`,
`mos`.`COLOURDESC` AS `colour_desc`,
`mos`.`SIZECODE` AS `size_code`,
`mos`.`SIZEDESC` AS `size_desc`,
`mos`.`SCHEDULE` AS `schedule_id`,
`mos`.`ZCODE` AS `z_name`,
`mos`.`ZDESC` AS `z_desc`,
0 AS `country_id`,0 AS `mrnno`,
0 AS `cut_no`,
`moq`.`ref_no` AS `bundle_number`,
`tran`.`m3_ops_code` AS `operation_id`,
`tran`.`op_des` AS `operation_desc`,
`tran`.`mo_no` AS `mo_number`,
CAST
(`tran`.`date_time` AS DATE) AS `trans_date`,
`tran`.`module_no` AS `division_code`,
TIME
(`tran`.`date_time`) AS `time_slot`,
`tran`.`quantity` AS `quantity`,
`tran`.`log_user` AS `user_id`,
`tran`.`id` AS `unique_id`,
`tran`.`reason` AS `rejection_reason`,
`gs`.`gate_id` AS `gate_pass_no`,
CASE 
WHEN TIME
(`tran`.`date_time`) BETWEEN
('07:30:00') AND
('08:29:59')  THEN 1
WHEN TIME
(`tran`.`date_time`) BETWEEN
('08:30:00') AND
('09:44:59')  THEN 2
WHEN TIME
(`tran`.`date_time`) BETWEEN
('09:45:00') AND
('10:44:59')  THEN 3
WHEN TIME
(`tran`.`date_time`) BETWEEN
('10:45:00') AND
('11:44:59')  THEN 4
WHEN TIME
(`tran`.`date_time`) BETWEEN
('11:45:00') AND
('13:14:59')  THEN 5
WHEN TIME
(`tran`.`date_time`) BETWEEN
('13:15:00') AND
('14:14:59')  THEN 6
WHEN TIME
(`tran`.`date_time`) BETWEEN
('14:15:00') AND
('15:29:59')  THEN 7
WHEN TIME
(`tran`.`date_time`) BETWEEN
('15:30:00') AND
('16:29:59')  THEN 8
WHEN TIME
(`tran`.`date_time`) BETWEEN
('16:30:00') AND
('17:30:00')  THEN 9
ELSE 10
END AS 'slot_id'
FROM
((((`bai_pro3`.`m3_transactions` `tran` LEFT JOIN `bai_pro3`.`mo_operation_quantites` `moq` ON
(((`tran`.`ref_no` = `moq`.`id`) AND
(`tran`.`op_code` = `moq`.`op_code`)))) 
LEFT JOIN `m3_inputs`.`mo_details` `mos` ON
((`moq`.`mo_no` = `mos`.`MONUMBER`))) 
LEFT JOIN `bai_pro3`.`promis_ops_mapping` `pos` ON
((`pos`.`sfcs_operation_id` = `tran`.`m3_ops_code`))) 
LEFT JOIN `brandix_bts`.`gatepass_track` `gs` ON
(((`gs`.`bundle_no` = `moq`.`ref_no`) AND
(SUBSTRING_INDEX
(`gs`.`operation_id`,'-',1) = `moq`.`op_code`)))) WHERE `pos`.flag>0 and `tran`.`promis_status`=0 AND `tran`.`api_type`='opn');