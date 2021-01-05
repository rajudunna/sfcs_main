/*#5421  Alter Queries Indexing*/

ALTER TABLE bai_pro3.pac_stat_log_input_job ADD KEY sref_id (sref_id, size_code); 

ALTER TABLE bai_pro3.marker_ref_matrix ADD KEY style (style_code); 

ALTER TABLE bai_pro3.pac_stat_log ADD KEY color (color);

ALTER TABLE bai_pro.bai_log_buf ADD  KEY delivery (delivery);

ALTER TABLE bai_pro3.ims_log_backup ADD  KEY tid (tid);