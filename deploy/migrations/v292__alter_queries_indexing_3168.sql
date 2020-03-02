/*#3168 alter queries indexing*/

ALTER TABLE bai_pro.bai_log_buf ADD KEY bac_style (bac_style);

ALTER TABLE bai_pro.bai_log_buf ADD KEY bstyle_bno_bshift (bac_style, bac_no, bac_shift);

ALTER TABLE bai_pro2.movex_styles ADD KEY buyer_id (buyer_id);