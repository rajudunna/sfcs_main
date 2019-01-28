/*1128 index tables*/
ALTER TABLE `bai_pro3`.`rejections_log` ADD UNIQUE INDEX `rejection_log_ix2` (`style`, `schedule`, `color`);
ALTER TABLE `bai_pro3`.`rejection_log_child` ADD UNIQUE INDEX `rejection_log_child` (`bcd_id`);
ALTER TABLE `bai_pro3`.`recut_v2_child` ADD INDEX `recut_v2_child_ix2` (`bcd_id`); 
ALTER TABLE `brandix_bts`.`bundle_creation_data` DROP INDEX `ij_size_op`, ADD KEY `ij_size_ops` (`size_title`, `operation_id`, `input_job_no_random_ref`);