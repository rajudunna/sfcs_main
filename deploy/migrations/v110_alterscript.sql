ALTER TABLE `wms`.`store_in` CHANGE `qty_issued` `qty_issued` DOUBLE(11,2) DEFAULT 0 NULL, CHANGE `qty_ret` `qty_ret` DOUBLE(11,2) DEFAULT 0 NULL, CHANGE `qty_allocated` `qty_allocated` DOUBLE(10,1) DEFAULT 0 NULL;