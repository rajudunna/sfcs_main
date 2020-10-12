/*#3582  Create Query*/

CREATE TABLE `brandix_bts`.`wip_dash_bund_track`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    `bundle_number` INT(11),
    `input_module` VARCHAR(11),
    `transfer_module` VARCHAR(11),
    `quantity` INT(11),
    `job_no` VARCHAR(90),
    `operation_id` INT(11),
    PRIMARY KEY (`id`)
) ENGINE = INNODB CHARSET = latin1 COLLATE = latin1_swedish_ci;