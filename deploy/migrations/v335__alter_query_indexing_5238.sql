/*#5238  Alter Query Indexing*/

ALTER TABLE bai_pro3.m3_transactions ADD KEY ref_no (ref_no), ADD KEY promis_job (api_type, promis_status, date_time);
