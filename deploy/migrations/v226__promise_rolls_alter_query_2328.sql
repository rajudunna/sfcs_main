/*#2328 alter promise_rolls*/

USE `bai_rm_pj1`;

ALTER TABLE `bai_rm_pj1`.`sticker_report`
ADD COLUMN `po_line` INT
(18) NULL AFTER `grn_type`,
ADD COLUMN `po_subline` INT
(18) NULL AFTER `po_line`;

DROP INDEX IF EXISTS `get_lot_no` ON `bai_rm_pj1`.`sticker_report`;

ALTER TABLE `bai_rm_pj1`.`sticker_report`
ADD KEY `get_lot_no`
(`po_no`, `po_line`, `po_subline`, `rec_no`);