/*#1989 New table*/


USE bai_pro3;

ALTER TABLE `bai_pro3`.`m3_transactions`
ADD COLUMN `m3_bulk_tran_id` INT
(11) NULL AFTER `api_type`;

ALTER TABLE `bai_pro3`.`m3_transactions_archive`
ADD COLUMN `m3_bulk_tran_id` INT
(11) NULL AFTER `api_type`;


CREATE TABLE `bai_pro3`.`m3_bulk_transactions`
(
`id` bigint
(20) NOT NULL AUTO_INCREMENT,
`date_time` datetime DEFAULT NULL,
`mo_no` varchar
(50) DEFAULT NULL,
`quantity` int
(11) DEFAULT NULL,
`reason` varchar
(100) DEFAULT NULL,
`remarks` text DEFAULT NULL,
`log_user` varchar
(30) DEFAULT NULL,
`tran_status_code` int
(11) DEFAULT NULL,
`module_no` varchar
(10) DEFAULT NULL,
`shift` varchar
(10) DEFAULT NULL,
`op_code` int
(11) DEFAULT NULL,
`op_des` varchar
(100) DEFAULT NULL,
`ref_no` varchar
(100) DEFAULT NULL,
`workstation_id` varchar
(10) DEFAULT NULL,
`response_status` varchar
(20) DEFAULT NULL,
`m3_ops_code` int
(11) DEFAULT NULL,
`m3_trail_count` smallint
(2) NOT NULL DEFAULT 0,
`api_type` varchar
(10) DEFAULT NULL COMMENT 'fg=PMS050MI || opn=PMS070MI',
PRIMARY KEY
(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;



ALTER TABLE `bai_pro3`.`m3_transactions`
ADD KEY `response_status`
(`response_status`),
ADD KEY `m3_bulk_tran_id`
(`m3_bulk_tran_id`);

ALTER TABLE `bai_pro3`.`m3_bulk_transactions`
ADD KEY `response_status`
(`response_status`);