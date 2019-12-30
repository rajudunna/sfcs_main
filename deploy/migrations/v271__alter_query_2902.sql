
USE `bai_pro3`;

Alter table `bai_pro3`.`plandoc_stat_log` add column `short_shipment_status` int(11) DEFAULT 0 NOT NULL COMMENT 'short shipment status' after `mk_ref_id`,add  KEY `short_shipment_status` (`short_shipment_status`);
  


ALTER VIEW `bai_pro3`.`plan_dash_summ` AS (
SELECT `plan_dashboard`.`doc_no` AS `doc_no`,`plan_dashboard`.`module` AS `module`,`plan_dashboard`.`priority` AS `priority`,`plan_dashboard`.`fabric_status` AS `fabric_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`plandoc_stat_log`.`pcutdocid` AS `bundle_location`,`plandoc_stat_log`.`print_status` AS `print_status`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`rm_date` AS `rm_date`,`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,`plandoc_stat_log`.`a_xs` * `plandoc_stat_log`.`a_plies` AS `xs`,`plandoc_stat_log`.`a_s` * `plandoc_stat_log`.`a_plies` AS `s`,`plandoc_stat_log`.`a_m` * `plandoc_stat_log`.`a_plies` AS `m`,`plandoc_stat_log`.`a_l` * `plandoc_stat_log`.`a_plies` AS `l`,`plandoc_stat_log`.`a_xl` * `plandoc_stat_log`.`a_plies` AS `xl`,`plandoc_stat_log`.`a_xxl` * `plandoc_stat_log`.`a_plies` AS `xxl`,`plandoc_stat_log`.`a_xxxl` * `plandoc_stat_log`.`a_plies` AS `xxxl`,`plandoc_stat_log`.`a_s01` * `plandoc_stat_log`.`a_plies` AS `s01`,`plandoc_stat_log`.`a_s02` * `plandoc_stat_log`.`a_plies` AS `s02`,`plandoc_stat_log`.`a_s03` * `plandoc_stat_log`.`a_plies` AS `s03`,`plandoc_stat_log`.`a_s04` * `plandoc_stat_log`.`a_plies` AS `s04`,`plandoc_stat_log`.`a_s05` * `plandoc_stat_log`.`a_plies` AS `s05`,`plandoc_stat_log`.`a_s06` * `plandoc_stat_log`.`a_plies` AS `s06`,`plandoc_stat_log`.`a_s07` * `plandoc_stat_log`.`a_plies` AS `s07`,`plandoc_stat_log`.`a_s08` * `plandoc_stat_log`.`a_plies` AS `s08`,`plandoc_stat_log`.`a_s09` * `plandoc_stat_log`.`a_plies` AS `s09`,`plandoc_stat_log`.`a_s10` * `plandoc_stat_log`.`a_plies` AS `s10`,`plandoc_stat_log`.`a_s11` * `plandoc_stat_log`.`a_plies` AS `s11`,`plandoc_stat_log`.`a_s12` * `plandoc_stat_log`.`a_plies` AS `s12`,`plandoc_stat_log`.`a_s13` * `plandoc_stat_log`.`a_plies` AS `s13`,`plandoc_stat_log`.`a_s14` * `plandoc_stat_log`.`a_plies` AS `s14`,`plandoc_stat_log`.`a_s15` * `plandoc_stat_log`.`a_plies` AS `s15`,`plandoc_stat_log`.`a_s16` * `plandoc_stat_log`.`a_plies` AS `s16`,`plandoc_stat_log`.`a_s17` * `plandoc_stat_log`.`a_plies` AS `s17`,`plandoc_stat_log`.`a_s18` * `plandoc_stat_log`.`a_plies` AS `s18`,`plandoc_stat_log`.`a_s19` * `plandoc_stat_log`.`a_plies` AS `s19`,`plandoc_stat_log`.`a_s20` * `plandoc_stat_log`.`a_plies` AS `s20`,`plandoc_stat_log`.`a_s21` * `plandoc_stat_log`.`a_plies` AS `s21`,`plandoc_stat_log`.`a_s22` * `plandoc_stat_log`.`a_plies` AS `s22`,`plandoc_stat_log`.`a_s23` * `plandoc_stat_log`.`a_plies` AS `s23`,`plandoc_stat_log`.`a_s24` * `plandoc_stat_log`.`a_plies` AS `s24`,`plandoc_stat_log`.`a_s25` * `plandoc_stat_log`.`a_plies` AS `s25`,`plandoc_stat_log`.`a_s26` * `plandoc_stat_log`.`a_plies` AS `s26`,`plandoc_stat_log`.`a_s27` * `plandoc_stat_log`.`a_plies` AS `s27`,`plandoc_stat_log`.`a_s28` * `plandoc_stat_log`.`a_plies` AS `s28`,`plandoc_stat_log`.`a_s29` * `plandoc_stat_log`.`a_plies` AS `s29`,`plandoc_stat_log`.`a_s30` * `plandoc_stat_log`.`a_plies` AS `s30`,`plandoc_stat_log`.`a_s31` * `plandoc_stat_log`.`a_plies` AS `s31`,`plandoc_stat_log`.`a_s32` * `plandoc_stat_log`.`a_plies` AS `s32`,`plandoc_stat_log`.`a_s33` * `plandoc_stat_log`.`a_plies` AS `s33`,`plandoc_stat_log`.`a_s34` * `plandoc_stat_log`.`a_plies` AS `s34`,`plandoc_stat_log`.`a_s35` * `plandoc_stat_log`.`a_plies` AS `s35`,`plandoc_stat_log`.`a_s36` * `plandoc_stat_log`.`a_plies` AS `s36`,`plandoc_stat_log`.`a_s37` * `plandoc_stat_log`.`a_plies` AS `s37`,`plandoc_stat_log`.`a_s38` * `plandoc_stat_log`.`a_plies` AS `s38`,`plandoc_stat_log`.`a_s39` * `plandoc_stat_log`.`a_plies` AS `s39`,`plandoc_stat_log`.`a_s40` * `plandoc_stat_log`.`a_plies` AS `s40`,`plandoc_stat_log`.`a_s41` * `plandoc_stat_log`.`a_plies` AS `s41`,`plandoc_stat_log`.`a_s42` * `plandoc_stat_log`.`a_plies` AS `s42`,`plandoc_stat_log`.`a_s43` * `plandoc_stat_log`.`a_plies` AS `s43`,`plandoc_stat_log`.`a_s44` * `plandoc_stat_log`.`a_plies` AS `s44`,`plandoc_stat_log`.`a_s45` * `plandoc_stat_log`.`a_plies` AS `s45`,`plandoc_stat_log`.`a_s46` * `plandoc_stat_log`.`a_plies` AS `s46`,`plandoc_stat_log`.`a_s47` * `plandoc_stat_log`.`a_plies` AS `s47`,`plandoc_stat_log`.`a_s48` * `plandoc_stat_log`.`a_plies` AS `s48`,`plandoc_stat_log`.`a_s49` * `plandoc_stat_log`.`a_plies` AS `s49`,`plandoc_stat_log`.`a_s50` * `plandoc_stat_log`.`a_plies` AS `s50`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`plan_dashboard`.`log_time` AS `log_time`,`plandoc_stat_log`.`short_shipment_status` AS `short_shipment_status` FROM (`plan_dashboard` LEFT JOIN `plandoc_stat_log` ON(`plan_dashboard`.`doc_no` = `plandoc_stat_log`.`doc_no`)) WHERE `plandoc_stat_log`.`order_tid` IS NOT NULL ORDER BY `plan_dashboard`.`priority`);

ALTER VIEW `bai_pro3`.`plan_dash_doc_summ` AS (
SELECT `plan_dash_summ`.`print_status` AS `print_status`,`plan_dash_summ`.`plan_lot_ref` AS `plan_lot_ref`,`plan_dash_summ`.`bundle_location` AS `bundle_location`,`plan_dash_summ`.`fabric_status_new` AS `fabric_status_new`,`plan_dash_summ`.`doc_no` AS `doc_no`,`plan_dash_summ`.`module` AS `module`,`plan_dash_summ`.`priority` AS `priority`,`plan_dash_summ`.`act_cut_issue_status` AS `act_cut_issue_status`,`plan_dash_summ`.`act_cut_status` AS `act_cut_status`,`plan_dash_summ`.`rm_date` AS `rm_date`,`plan_dash_summ`.`cut_inp_temp` AS `cut_inp_temp`,`plan_dash_summ`.`order_tid` AS `order_tid`,`plan_dash_summ`.`fabric_status` AS `fabric_status`,`plan_doc_summ`.`color_code` AS `color_code`,`plan_doc_summ`.`clubbing` AS `clubbing`,`plan_doc_summ`.`order_style_no` AS `order_style_no`,`plan_doc_summ`.`order_div` AS `order_div`,`plan_doc_summ`.`order_col_des` AS `order_col_des`,`plan_doc_summ`.`acutno` AS `acutno`,`plan_doc_summ`.`ft_status` AS `ft_status`,`plan_doc_summ`.`st_status` AS `st_status`,`plan_doc_summ`.`pt_status` AS `pt_status`,`plan_doc_summ`.`trim_status` AS `trim_status`,`plan_dash_summ`.`xs` AS `xs`,`plan_dash_summ`.`s` AS `s`,`plan_dash_summ`.`m` AS `m`,`plan_dash_summ`.`l` AS `l`,`plan_dash_summ`.`xl` AS `xl`,`plan_dash_summ`.`xxl` AS `xxl`,`plan_dash_summ`.`xxxl` AS `xxxl`,`plan_dash_summ`.`s01` AS `s01`,`plan_dash_summ`.`s02` AS `s02`,`plan_dash_summ`.`s03` AS `s03`,`plan_dash_summ`.`s04` AS `s04`,`plan_dash_summ`.`s05` AS `s05`,`plan_dash_summ`.`s06` AS `s06`,`plan_dash_summ`.`s07` AS `s07`,`plan_dash_summ`.`s08` AS `s08`,`plan_dash_summ`.`s09` AS `s09`,`plan_dash_summ`.`s10` AS `s10`,`plan_dash_summ`.`s11` AS `s11`,`plan_dash_summ`.`s12` AS `s12`,`plan_dash_summ`.`s13` AS `s13`,`plan_dash_summ`.`s14` AS `s14`,`plan_dash_summ`.`s15` AS `s15`,`plan_dash_summ`.`s16` AS `s16`,`plan_dash_summ`.`s17` AS `s17`,`plan_dash_summ`.`s18` AS `s18`,`plan_dash_summ`.`s19` AS `s19`,`plan_dash_summ`.`s20` AS `s20`,`plan_dash_summ`.`s21` AS `s21`,`plan_dash_summ`.`s22` AS `s22`,`plan_dash_summ`.`s23` AS `s23`,`plan_dash_summ`.`s24` AS `s24`,`plan_dash_summ`.`s25` AS `s25`,`plan_dash_summ`.`s26` AS `s26`,`plan_dash_summ`.`s27` AS `s27`,`plan_dash_summ`.`s28` AS `s28`,`plan_dash_summ`.`s29` AS `s29`,`plan_dash_summ`.`s30` AS `s30`,`plan_dash_summ`.`s31` AS `s31`,`plan_dash_summ`.`s32` AS `s32`,`plan_dash_summ`.`s33` AS `s33`,`plan_dash_summ`.`s34` AS `s34`,`plan_dash_summ`.`s35` AS `s35`,`plan_dash_summ`.`s36` AS `s36`,`plan_dash_summ`.`s37` AS `s37`,`plan_dash_summ`.`s38` AS `s38`,`plan_dash_summ`.`s39` AS `s39`,`plan_dash_summ`.`s40` AS `s40`,`plan_dash_summ`.`s41` AS `s41`,`plan_dash_summ`.`s42` AS `s42`,`plan_dash_summ`.`s43` AS `s43`,`plan_dash_summ`.`s44` AS `s44`,`plan_dash_summ`.`s45` AS `s45`,`plan_dash_summ`.`s46` AS `s46`,`plan_dash_summ`.`s47` AS `s47`,`plan_dash_summ`.`s48` AS `s48`,`plan_dash_summ`.`s49` AS `s49`,`plan_dash_summ`.`s50` AS `s50`,`plan_dash_summ`.`a_plies` AS `a_plies`,`plan_dash_summ`.`p_plies` AS `p_plies`,`plan_dash_summ`.`mk_ref` AS `mk_ref`,`plan_dash_summ`.`xs` + `plan_dash_summ`.`s` + `plan_dash_summ`.`m` + `plan_dash_summ`.`l` + `plan_dash_summ`.`xl` + `plan_dash_summ`.`xxl` + `plan_dash_summ`.`xxxl` + `plan_dash_summ`.`s01` + `plan_dash_summ`.`s02` + `plan_dash_summ`.`s03` + `plan_dash_summ`.`s04` + `plan_dash_summ`.`s05` + `plan_dash_summ`.`s06` + `plan_dash_summ`.`s07` + `plan_dash_summ`.`s08` + `plan_dash_summ`.`s09` + `plan_dash_summ`.`s10` + `plan_dash_summ`.`s11` + `plan_dash_summ`.`s12` + `plan_dash_summ`.`s13` + `plan_dash_summ`.`s14` + `plan_dash_summ`.`s15` + `plan_dash_summ`.`s16` + `plan_dash_summ`.`s17` + `plan_dash_summ`.`s18` + `plan_dash_summ`.`s19` + `plan_dash_summ`.`s20` + `plan_dash_summ`.`s21` + `plan_dash_summ`.`s22` + `plan_dash_summ`.`s23` + `plan_dash_summ`.`s24` + `plan_dash_summ`.`s25` + `plan_dash_summ`.`s26` + `plan_dash_summ`.`s27` + `plan_dash_summ`.`s28` + `plan_dash_summ`.`s29` + `plan_dash_summ`.`s30` + `plan_dash_summ`.`s31` + `plan_dash_summ`.`s32` + `plan_dash_summ`.`s33` + `plan_dash_summ`.`s34` + `plan_dash_summ`.`s35` + `plan_dash_summ`.`s36` + `plan_dash_summ`.`s37` + `plan_dash_summ`.`s38` + `plan_dash_summ`.`s39` + `plan_dash_summ`.`s40` + `plan_dash_summ`.`s41` + `plan_dash_summ`.`s42` + `plan_dash_summ`.`s43` + `plan_dash_summ`.`s44` + `plan_dash_summ`.`s45` + `plan_dash_summ`.`s46` + `plan_dash_summ`.`s47` + `plan_dash_summ`.`s48` + `plan_dash_summ`.`s49` + `plan_dash_summ`.`s50` AS `total`,`plan_doc_summ`.`act_movement_status` AS `act_movement_status`,`plan_doc_summ`.`order_del_no` AS `order_del_no`,`plan_dash_summ`.`log_time` AS `log_time`,`plan_doc_summ`.`emb_stat1` AS `emb_stat`,`plan_doc_summ`.`cat_ref` AS `cat_ref`,`plan_dash_summ`.`short_shipment_status` AS `short_shipment_status` FROM (`bai_pro3`.`plan_dash_summ` LEFT JOIN `bai_pro3`.`plan_doc_summ` ON(`plan_doc_summ`.`doc_no` = `plan_dash_summ`.`doc_no`)));