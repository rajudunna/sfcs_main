USE bai_pro3;
ALTER TABLE pac_stat_log_input_job
  CHANGE pac_seq_no pac_seq_no INT(11) DEFAULT 0 NOT NULL;