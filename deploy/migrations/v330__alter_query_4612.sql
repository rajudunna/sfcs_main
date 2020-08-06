/*#4612 Alter Query*/


ALTER TABLE bai_rm_pj1.store_out_backup  CHANGE cutno cutno VARCHAR(20) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL,ADD  INDEX cutno (cutno);

ALTER TABLE bai_rm_pj1.store_out  CHANGE cutno cutno VARCHAR(20) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL;
