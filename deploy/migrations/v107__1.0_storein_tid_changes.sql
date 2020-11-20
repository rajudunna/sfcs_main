ALTER TABLE `wms`.`store_in_deleted` CHANGE `tid` `tid` VARCHAR(36) NOT NULL; 
ALTER TABLE `wms`.`inspection_population` CHANGE `store_in_id` `store_in_id` VARCHAR(36) NULL; 
ALTER TABLE `wms`.`roll_inspection_child` CHANGE `store_in_tid` `store_in_tid` VARCHAR(36) NOT NULL; 
ALTER TABLE `wms`.`four_points_table` CHANGE `insp_child_id` `insp_child_id` VARCHAR(36) NOT NULL; 
ALTER TABLE `wms`.`store_in_backup` CHANGE `tid` `tid` VARCHAR(36) NOT NULL; 