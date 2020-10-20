/*#4473  Create Query*/

CREATE TABLE `brandix_bts`.`order_sync_log` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
    `order_tid` varchar(50) DEFAULT NULL,
    `style` varchar(30) DEFAULT NULL,
    `color` varchar(30) DEFAULT NULL,
    `schedule` varchar(30) DEFAULT NULL,
    `status` int(11) NOT NULL DEFAULT 0 COMMENT '2-direct order sync, 1- main interface, 3 - doc gen form',
    `status_change` int(11) DEFAULT NULL COMMENT '4 - docket details sync, 5- re sync',
    PRIMARY KEY (`id`),
    KEY `sch` (`schedule`)
) ENGINE = InnoDB AUTO_INCREMENT = 24 DEFAULT CHARSET = latin1;

