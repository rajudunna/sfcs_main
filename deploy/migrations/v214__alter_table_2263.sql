/*#2263 alter table*/

USE `bai_pro3`;

ALTER TABLE bai_pro3.ims_log ADD KEY ims_db_check
(ims_mod_no, input_job_rand_no_ref);

ALTER TABLE bai_pro3.ims_log_backup ADD KEY ims_db_check
(ims_mod_no, input_job_rand_no_ref);