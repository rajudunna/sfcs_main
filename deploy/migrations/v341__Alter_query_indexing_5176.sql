/*#5176  Alter Query Indexing*/

ALTER TABLE bai_pro3.job_deactive_log ADD KEY sch_job_status_rej_rev (SCHEDULE, input_job_no_random, remove_type);
