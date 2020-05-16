/*#3382 alter queries indexing*/

ALTER TABLE bai_pro3.bai_qms_db  ADD  KEY tran (qms_tran_type, input_job_no);

ALTER TABLE brandix_bts.bundle_creation_data_temp  ADD  KEY random_ref (input_job_no_random_ref);