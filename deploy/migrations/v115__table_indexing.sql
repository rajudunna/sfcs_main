USE `bai_pro3`;
ALTER TABLE `mo_operation_quantites` CHANGE 
`mo_no` `mo_no` INT(11) NULL,
 CHANGE `ref_no` `ref_no` INT(11) NULL;
 
 ALTER TABLE `mo_details` CHANGE `mo_no` `mo_no` INT(11) NULL; 
 ALTER TABLE `m3_transactions` CHANGE `mo_no` `mo_no` INT(11) NULL; 
 
 USE `m3_inputs`;
 ALTER TABLE `mo_details` CHANGE `MONUMBER` `MONUMBER` INT(11) NULL; 
 
 