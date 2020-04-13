/*#3661 alter queries indexing*/

ALTER TABLE bai_pro3.tbl_plant_timings ADD KEY time_val (time_value);

ALTER TABLE bai_pro.bai_log ADD KEY bac_date (bac_date);