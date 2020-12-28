ALTER TABLE `wms`.`sticker_report` CHANGE `po_line` `po_line` INT(11) DEFAULT 0 NOT NULL, CHANGE `po_subline` `po_subline` INT(11) DEFAULT 0 NOT NULL,CHANGE `po_total_cost` `po_total_cost` DOUBLE(10,2) DEFAULT 0 NOT NULL,CHANGE `po_line_price` `po_line_price` DOUBLE(10,4) DEFAULT 0 NOT NULL, CHANGE `rec_qty` `rec_qty` DOUBLE(10,1) DEFAULT 0 NOT NULL; 


ALTER TABLE wms.sticker_report MODIFY COLUMN supplier VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `wms`.`inspection_db` ADD UNIQUE INDEX `unique_keys` (`batch_ref`, `plant_code`);

ALTER TABLE `wms`.`inspection_db` DROP PRIMARY KEY;

ALTER TABLE `wms`.`store_in` CHANGE `ref1` `ref1` VARCHAR(50) CHARSET latin1 COLLATE latin1_swedish_ci DEFAULT '0' NOT NULL; 