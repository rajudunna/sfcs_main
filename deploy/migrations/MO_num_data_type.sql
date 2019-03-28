/*USE BAI_PRO3;*/
ALTER TABLE `BAI_PRO3`.`bai_emb_db` CHANGE `mo_no` `mo_no` VARCHAR(11) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL; 
ALTER TABLE `BAI_PRO3`.`m3_transactions` CHANGE `mo_no` `mo_no` VARCHAR(11) NULL; 
ALTER TABLE `BAI_PRO3`.`mo_details` CHANGE `mo_no` `mo_no` VARCHAR(11) NULL; 
ALTER TABLE `BAI_PRO3`.`mo_operation_quantites` CHANGE `mo_no` `mo_no` VARBINARY(11) NULL;
ALTER TABLE `BAI_PRO3`.`schedule_oprations_master` CHANGE `MONumber` `MONumber` VARCHAR(11) NULL; 
ALTER TABLE `BAI_PRO3`.`schedule_oprations_master_backup` CHANGE `MONumber` `MONumber` VARCHAR(11) NULL; 

/*USE m3_inputs;*/
ALTER TABLE `m3_inputs`.`bom_details` CHANGE `mo_no` `mo_no` VARCHAR(11) CHARSET latin1 COLLATE latin1_swedish_ci NULL; 
ALTER TABLE `m3_inputs`.`mo_details` CHANGE `MONUMBER` `MONUMBER` VARCHAR(11) NULL;
ALTER TABLE `m3_inputs`.`order_details_original` CHANGE `MO_NUMBER` `MO_NUMBER` VARCHAR(11) CHARSET latin1 COLLATE latin1_swedish_ci NULL; 
ALTER TABLE `m3_inputs`.`order_details_temp` CHANGE `MO_NUMBER` `MO_NUMBER` VARCHAR(11) CHARSET latin1 COLLATE latin1_swedish_ci NULL;





