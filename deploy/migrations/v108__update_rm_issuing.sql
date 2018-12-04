/*USE bai_pro3;*/
ALTER TABLE bai_pro3.recut_v2 AUTO_INCREMENT = 9000001;
CREATE TABLE bai_pro3.recut_v2_child( id INT NOT NULL AUTO_INCREMENT, doc_no INT NOT NULL, size VARCHAR(50) NOT NULL, qty INT NOT NULL, PRIMARY KEY (id) );
ALTER TABLE bai_pro3.recut_v2_child ADD COLUMN parent_id INT(11) NOT NULL AFTER id; 
ALTER TABLE bai_pro3.recut_v2_child CHANGE doc_no doc_no VARCHAR(50) NOT NULL;
ALTER TABLE bai_pro3.recut_v2_child ADD COLUMN operation_id INT(11) NULL AFTER qty;
ALTER TABLE bai_pro3.maker_stat_log DROP KEY unique_key, ADD INDEX unique_key (cat_ref, cuttable_ref, allocate_ref, order_tid);