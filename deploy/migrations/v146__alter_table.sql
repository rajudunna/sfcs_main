/*#1298*/
ALTER TABLE bai_pro3.m3_transactions ADD COLUMN api_type VARCHAR(10) NULL COMMENT 'fg=PMS050MI || opn=PMS070MI' AFTER m3_trail_count;
