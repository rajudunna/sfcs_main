/*1271*/
ALTER TABLE bai_pro3.plandoc_stat_log
  DROP INDEX unique_key,
  ADD  UNIQUE INDEX unique_key (cat_ref, pcutno, ratio, order_tid);