ALTER TABLE `wms`.`stock_report_inventory` CHANGE `tid` `tid` VARCHAR(36) CHARSET latin1 COLLATE latin1_swedish_ci NULL;


ALTER TABLE wms.stock_report_inventory MODIFY COLUMN supplier VARCHAR(600)  
    CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;