/*#3725 Alter query indexing*/

Alter table bai_pro3.replacment_allocation_log add KEY input_job_no (input_job_no_random_ref, size_title) Comment "3725";
