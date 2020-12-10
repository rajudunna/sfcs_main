/*#5454  Create Query*/

CREATE TABLE `bai_pro3`.`bundle_operations` (
    `id` int(20) NOT NULL AUTO_INCREMENT,
    `bundle_no` int(20) DEFAULT NULL,
    `operation` int(10) DEFAULT NULL,
    `quantity` int(20) DEFAULT NULL,
    `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `username` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `bundle_no` (`bundle_no`),
    KEY `operation_no` (`operation`)
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = latin1;
