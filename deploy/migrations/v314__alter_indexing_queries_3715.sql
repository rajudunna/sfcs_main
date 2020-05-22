/*#3715 Alter and indexing queries*/

ALTER TABLE bai_pro3.lay_plan_delete_track DROP PRIMARY KEY;

ALTER TABLE bai_pro3.lay_plan_delete_track ADD COLUMN sno INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (sno);

ALTER TABLE bai_pro3.lay_plan_delete_track ADD  KEY index_all (tid, schedule_no, col_desc, reason, log_time);