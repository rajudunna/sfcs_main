
/*#116 Cut table dashboard Queries*/

ALTER TABLE `bai_pro3`.`mo_details` ADD COLUMN `vpo` VARCHAR(20) NULL AFTER `shipment_master_status`, ADD COLUMN `startdate` DATE NULL AFTER `vpo`, ADD COLUMN `coplandeldate` DATE NULL AFTER `startdate`, ADD COLUMN `referenceorder` VARCHAR(40) NULL AFTER `coplandeldate`; 

ALTER TABLE `bai_pro3`.`order_plan` ADD COLUMN `order_status` INT(11) DEFAULT 0 NULL AFTER `material_sequence`; 

ALTER TABLE `bai_pro3`.`shipment_plan` ADD COLUMN `shipment_status` INT(11) DEFAULT 0 NULL AFTER `order_no`; 

ALTER TABLE `bai_pro3`.`order_plan` CHANGE `order_status` `order_status` INT(11) DEFAULT 0 NOT NULL, ADD COLUMN `required_qty` FLOAT(10,4) NOT NULL AFTER `order_status`; 

ALTER TABLE `bai_pro3`.`order_plan` ADD COLUMN `VPO_NO` VARCHAR(200) NOT NULL AFTER `required_qty`; 

ALTER TABLE `bai_pro3`.`shipment_plan` ADD COLUMN `Customer_Order_No` INT(11) NULL AFTER `shipment_status`;

