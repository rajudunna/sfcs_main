USE m3_inputs;
ALTER TABLE mo_details
ADD COLUMN packing_method VARCHAR(10),
ADD COLUMN destination VARCHAR(10),
ADD COLUMN cpo VARCHAR(20),
ADD COLUMN buyer_id VARCHAR(50);

USE bai_pro3;

ALTER TABLE `mo_details`   
  ADD COLUMN `packing_method` VARCHAR(10) NULL AFTER `product_sku`,
  ADD COLUMN `cpo` VARCHAR(20) NULL AFTER `packing_method`,
  ADD COLUMN `buyer_id` VARCHAR(50) NULL AFTER `cpo`,
  ADD COLUMN `material_master_status` INT(11) DEFAULT 0 NULL AFTER `buyer_id`,
  ADD COLUMN `shipment_master_status` INT(11) DEFAULT 0 NULL AFTER `material_master_status`;
