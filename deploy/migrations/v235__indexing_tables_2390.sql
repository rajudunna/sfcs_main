/*#2390 alter table*/

ALTER TABLE `bai_pro3`.`pac_stat_log_input_job`
ADD KEY `job_size`
(`size_code`, `input_job_no_random`);

ALTER TABLE `bai_pro3`.`recut_v2_child`
ADD KEY `recut_v2_child_ix3`
(`parent_id`, `bcd_id`);

ALTER TABLE `brandix_bts`.`bundle_creation_data`
ADD KEY `bcd_ix4`
(`style`, `schedule`, `original_qty`, `operation_id`, `bundle_qty_status`);