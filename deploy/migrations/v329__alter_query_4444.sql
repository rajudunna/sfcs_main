/*#4444 Alter Query*/

ALTER TABLE bai_pro3.tbl_emb_table ADD COLUMN log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL COMMENT 'CURRENT_TIMESTAMP' AFTER work_station_id, ADD COLUMN updated_by VARCHAR(50) NULL AFTER log_time;

ALTER TABLE bai_pro3.tbl_emb_table ADD KEY stat (emb_table_id, emb_table_status);
