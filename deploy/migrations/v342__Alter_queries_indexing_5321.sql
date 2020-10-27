/*#5321  Alter Queries Indexing*/

ALTER TABLE bai_pro3.bai_orders_db_confirm ADD KEY style_vpo (vpo, order_style_no);

ALTER TABLE bai_pro3.mo_details ADD KEY SCHEDULE (SCHEDULE);

ALTER TABLE bai_pro3.tbl_pack_ref ADD KEY sch_style (SCHEDULE, style);

ALTER TABLE brandix_bts.tbl_orders_sizes_master ADD KEY parent_id_size_tit (parent_id, size_title);
