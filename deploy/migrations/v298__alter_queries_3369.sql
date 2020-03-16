/*#3369 alter queries*/

ALTER TABLE bai_rm_pj1.store_in_deleted CHANGE log_user log_user VARCHAR (50) NOT NULL;

ALTER TABLE bai_rm_pj1.store_out_backup CHANGE updated_by updated_by VARCHAR (50) NOT NULL;

ALTER TABLE bai_rm_pj1.store_returns CHANGE updated_by updated_by VARCHAR (50) NOT NULL;