/*#2763 alter query */

USE `bai_pro3`;

ALTER TABLE `bai_pro3`.`cat_stat_log` ADD KEY `order_tid` (`order_tid`); 

ALTER TABLE `bai_pro3`.`rejection_log_child` ADD KEY `bcd_id` (`bcd_id`); 