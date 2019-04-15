/*#1708 script*/
USE `bai_pro3`;

DROP TABLE bai_pro3.deleted_sewing_jobs;

CREATE TABLE bai_pro3.deleted_sewing_jobs (
  id int(11) NOT NULL AUTO_INCREMENT,
  schedule int(10) NOT NULL,
  input_job_no_random varchar(20) NOT NULL,
  size_id varchar(10) NOT NULL,
  qty int(5) DEFAULT NULL,
  tid int(10) DEFAULT NULL,
  type_of_sewing int(2) DEFAULT NULL,
  date_time datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1;