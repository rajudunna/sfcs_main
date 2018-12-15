/*1220*/
ALTER TABLE bai_pro3.m3_transactions 
ADD COLUMN m3_trail_count SMALLINT(2) DEFAULT '0'  NOT NULL AFTER m3_ops_code;