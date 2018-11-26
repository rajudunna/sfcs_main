USE bai_pro3;

CREATE TABLE cutting_table_plan (
  track_id int(11) NOT NULL AUTO_INCREMENT,
  doc_no varchar(50) NOT NULL,
  priority int(11) DEFAULT NULL,
  dashboard_ref varchar(50) DEFAULT NULL,
  cutting_tbl_id int(11) NOT NULL,
  doc_no_ref varchar(500) DEFAULT NULL,
  username varchar(50) DEFAULT NULL,
  log_time datetime DEFAULT NULL,
  PRIMARY KEY (track_id)
)