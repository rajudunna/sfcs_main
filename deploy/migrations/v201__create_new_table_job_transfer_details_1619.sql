/*#1619 create table*/
USE bai_pro3;

CREATE TABLE bai_pro3.job_transfer_details
(
    id INT(11) NOT NULL
    AUTO_INCREMENT,
  sewing_job_number VARCHAR
    (30) DEFAULT NULL,
  transfered_module VARCHAR
    (10) DEFAULT NULL,
  STATUS VARCHAR
    (3) DEFAULT NULL COMMENT 'P-Pending,S-Send',
  DATE TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    () ON
    UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY
    (id)
) ENGINE=INNODB DEFAULT CHARSET=latin1