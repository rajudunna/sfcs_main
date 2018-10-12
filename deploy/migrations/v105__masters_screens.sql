USE bai_rm_pj1;
ALTER TABLE inspection_complaint_reasons ADD COLUMN tid INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;


USE brandix_bts;
ALTER TABLE tbl_sewing_job_prefix MODIFY id INT AUTO_INCREMENT PRIMARY KEY;