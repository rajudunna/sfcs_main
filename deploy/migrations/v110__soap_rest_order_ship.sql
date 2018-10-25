USE m3_inputs;
ALTER TABLE mo_details
ADD COLUMN packing_method VARCHAR(10),
ADD COLUMN destination VARCHAR(10),
ADD COLUMN cpo VARCHAR(20),
ADD COLUMN buyer_id VARCHAR(50);

USE bai_pro3;
ALTER TABLE mo_details
ADD COLUMN packing_method VARCHAR(10),
ADD COLUMN cpo VARCHAR(20),
ADD COLUMN buyer_id VARCHAR(50),
ADD COLUMN material_master_status INT(11),
ADD COLUMN shipment_master_status INT(11);

alter table mo_details 
   change material_master_status material_master_status int(11) default '0' NULL , 
   change shipment_master_status shipment_master_status int(11) default '0' NULL;