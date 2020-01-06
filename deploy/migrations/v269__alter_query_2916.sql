/*#2916 alter query */

Alter table `brandix_bts`.`bundle_creation_data_temp`   
  change `input_job_no` `input_job_no` varchar
(255) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `input_job_no_random_ref` `input_job_no_random_ref` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NULL;

Alter table `brandix_bts`.`bundle_creation_data`   
  change `input_job_no` `input_job_no` varchar
(255) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `input_job_no_random_ref` `input_job_no_random_ref` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NULL;

Alter table `bai_pro3`.`plan_dashboard_input`   
  change `input_job_no_random_ref` `input_job_no_random_ref` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL;

Alter table `bai_pro3`.`plan_dashboard_input_backup`   
  change `input_job_no_random_ref` `input_job_no_random_ref` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL;

Alter table `bai_pro3`.`ims_log`   
  change `input_job_rand_no_ref` `input_job_rand_no_ref` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL  COMMENT 'reference of input job random #',
  change `input_job_no_ref` `input_job_no_ref` varchar
(255) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL  COMMENT 'reference of input job number';

Alter table `bai_pro3`.`ims_log_backup`   
  change `input_job_no_ref` `input_job_no_ref` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL;

Alter table `brandix_bts`.`module_bundle_track`   
  change `job_no` `job_no` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NULL;

Alter table `bai_pro3`.`deleted_sewing_jobs`   
  change `input_job_no_random` `input_job_no_random` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL;

Alter table `bai_pro3`.`job_transfer_details`   
  change `sewing_job_number` `sewing_job_number` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NULL;

Alter table `bai_pro3`.`jobs_movement_track`   
  change `input_job_no` `input_job_no` varchar
(255) CHARSET latin1 COLLATE latin1_swedish_ci NULL,
  change `input_job_no_random` `input_job_no_random` varchar
(90) CHARSET latin1 COLLATE latin1_swedish_ci NULL;