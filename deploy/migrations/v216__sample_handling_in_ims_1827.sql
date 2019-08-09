/*#1827 Sample handling in IMS*/

USE `bai_pro3`;

ALTER TABLE bai_pro3.ims_log ADD KEY ims_db_check
(ims_mod_no, input_job_rand_no_ref);

ALTER TABLE bai_pro3.ims_log_backup ADD KEY ims_db_check
(ims_mod_no, input_job_rand_no_ref);

ALTER TABLE bai_pro3.pac_stat_log_input_job ADD KEY type_of_sewing
(type_of_sewing);

USE `brandix_bts`;

ALTER TABLE `brandix_bts`.`bundle_creation_data`
ADD KEY `barcode`
(`barcode_number`);

ALTER TABLE `brandix_bts`.`bundle_creation_data`
ADD KEY `parallel_ops`
(`size_title`, `docket_number`);