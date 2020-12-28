ALTER TABLE wms.supplier_performance_track_log MODIFY COLUMN supplier_name VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `wms`.`supplier_performance_track_log` CHANGE `high_pts_prod` `high_pts_prod` VARCHAR(30) CHARSET latin1 COLLATE latin1_swedish_ci DEFAULT '0' NOT NULL; 

ALTER TABLE `wms`.`supplier_performance_track_log` CHANGE `pts_prod` `pts_prod` VARCHAR(30) CHARSET latin1 COLLATE latin1_swedish_ci DEFAULT '0' NOT NULL; 

ALTER TABLE `wms`.`supplier_performance_track_log` CHANGE `consumption` `consumption` DECIMAL(16,2) NOT NULL;