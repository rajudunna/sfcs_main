/*#3332 alter query indexing*/

ALTER TABLE `bai_rm_pj1`.`store_out` ADD KEY `index_stock` (`tran_tid`, `date`);