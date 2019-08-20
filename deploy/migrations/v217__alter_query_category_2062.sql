/*#2062 sepearte_laysheet for binding*/

USE `bai_pro3`;

ALTER TABLE `bai_pro3`.`binding_consumption` ADD COLUMN `category` VARCHAR(100) NULL AFTER `color`; 