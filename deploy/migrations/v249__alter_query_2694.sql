/*#2694 alter query*/


USE bai_pro3;

ALTER TABLE bai_pro3.plandoc_stat_log  CHANGE manual_flag manual_flag INT
(2) DEFAULT 0  NOT NULL  COMMENT 'mark as fully reported';