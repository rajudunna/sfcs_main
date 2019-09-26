/*#2585 indexing ims log tables*/


USE bai_pro3;

ALTER TABLE bai_pro3.ims_log ADD KEY key_date_mod_shift
(ims_date, ims_mod_no, ims_shift);

ALTER TABLE bai_pro3.ims_log_backup ADD KEY key_date_mod_shift1
(ims_date, ims_mod_no, ims_shift);