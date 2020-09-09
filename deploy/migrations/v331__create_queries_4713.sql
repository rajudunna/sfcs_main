/*#4713 Create Queries*/

CREATE TABLE `bai_pro3`.`request_log` (
    `id` int(15) NOT NULL AUTO_INCREMENT,
    `request_time` varchar(50) DEFAULT NULL,
    `sewing_job_no` varchar(50) DEFAULT NULL,
    `ops_id` int(15) DEFAULT NULL,
    `user_name` varchar(50) DEFAULT NULL,
    `close_time` varchar(50) DEFAULT NULL,
    `reported_qty` int(15) DEFAULT NULL,
    `module_no` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `job_opn` (`sewing_job_no`, `ops_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = latin1;

CREATE TABLE `bai_pro3`.`sewing_scanning_status` (
    `id` int(20) NOT NULL AUTO_INCREMENT,
    `sewing_job` varchar(50) DEFAULT NULL,
    `operation_id` int(10) DEFAULT NULL,
    `module` varchar(15) DEFAULT NULL,
    `status` varchar(15) DEFAULT NULL,
    `log_user` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_id` (`sewing_job`, `operation_id`),
    KEY `job_operation` (`sewing_job`, `operation_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = latin1;