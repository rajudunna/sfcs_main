ALTER TABLE `wms`.`store_in`   
	CHANGE `ref_tid` `ref_tid` VARCHAR(40) DEFAULT '0' NULL;
ALTER TABLE `wms`.`store_out` CHANGE `tran_tid` `tran_tid` VARCHAR(40) NOT NULL;