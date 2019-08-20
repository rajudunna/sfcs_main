/*#2136 create table query*/

USE `bai_pro3`;

CREATE TABLE `bai_pro3`.`ratio_lay_plans`
(
  `ratio_number` INT
(11) NOT NULL,
  `size` VARCHAR
(30) NOT NULL,
  `order_id` VARCHAR
(200) NOT NULL,
  `cat_id` VARCHAR
(50) NOT NULL,
  `cutt_ref` VARCHAR
(50) NOT NULL,
  `user` VARCHAR
(50) NOT NULL,
  `time` VARCHAR
(50) NOT NULL,
  KEY `ratio_number`
(`ratio_number`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;