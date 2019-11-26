/*#2835 alter query */


ALTER TABLE brandix_bts.reversal_docket_log add column remarks varchar(30) NULL COMMENT 'username - manual flag' after act_cut_status;