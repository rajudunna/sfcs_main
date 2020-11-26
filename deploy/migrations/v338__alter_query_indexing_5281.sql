/*#5281  Alter Query Indexing*/

ALTER TABLE m3_inputs.order_details_original ADD COLUMN STATUS INT(11) DEFAULT 0 NULL COMMENT 'cat_stat_log sync status 0 - no, 1 - yes' AFTER time_stamp, ADD KEY STATUS (STATUS);
