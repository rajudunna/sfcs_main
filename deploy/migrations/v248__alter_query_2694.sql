/*#2694 alter query*/

USE bai_pro3;

Alter table `bai_pro3`.`plandoc_stat_log`   
  change `doc_no` `doc_no` int
(11) NOT NULL Auto_increment COMMENT 'Docket No\r\n',
add column `manual_flag` int
(2) NULL COMMENT 'mark as fully reported' after `reference`;