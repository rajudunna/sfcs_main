/*#3586 alter queries*/

ALTER TABLE `bai_rm_pj2`.`mrn_out_allocation` ADD COLUMN `cut_status` VARCHAR(10) DEFAULT '0' NULL COMMENT 'If cut reported for MRN, status 1 else status 0' AFTER `iss_qty`;

ALTER TABLE `bai_pro3`.`docket_roll_info` ADD COLUMN `alloc_type` ENUM('Mrn','Fabric') NULL COMMENT 'Mrn-Mrn Allocation.Fabric-Fabric cad allocation' AFTER `status`, ADD COLUMN `alloc_type_id` INT(11) NULL AFTER `alloc_type`; 
