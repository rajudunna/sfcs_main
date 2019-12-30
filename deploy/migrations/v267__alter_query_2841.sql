/*#2841 alter query */


USE `bai_pro3`;

DROP PROCEDURE IF EXISTS `bai_pro3`.`get_m3_transactions`;

CREATE  PROCEDURE `bai_pro3`.`get_m3_transactions`(TransactionDate DATE, TransactionsTime TIME) SELECT * FROM bai_pro3.m3_bulk_transactions WHERE DATE(date_time)>TransactionDate AND TIME(date_time)>TransactionsTime;