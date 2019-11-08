/*#2843 alter query */

DROP INDEX IF EXISTS doc_no_op_code ON `bai_pro3`.`cps_log`;

ALTER TABLE `bai_pro3`.`cps_log`  ADD  KEY `doc_no_op_code` (`doc_no`, `operation_code`);