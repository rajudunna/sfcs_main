/*#2859 alter query */

use bai_pro3;

ALTER VIEW `bai_pro3`.`plan_doc_summ` AS (
SELECT `plandoc_stat_log`.`order_tid` AS `order_tid`,`plandoc_stat_log`.`doc_no` AS `doc_no`,`plandoc_stat_log`.`org_doc_no` AS `org_doc_no`,`plandoc_stat_log`.`acutno` AS `acutno`,`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`plandoc_stat_log`.`a_plies` AS `a_plies`,`plandoc_stat_log`.`p_plies` AS `p_plies`,`bai_orders_db_confirm`.`color_code` AS `color_code`,`bai_orders_db_confirm`.`order_div` AS `order_div`,`bai_orders_db_confirm`.`order_style_no` AS `order_style_no`,`bai_orders_db_confirm`.`order_del_no` AS `order_del_no`,`bai_orders_db_confirm`.`order_col_des` AS `order_col_des`,`bai_orders_db_confirm`.`ft_status` AS `ft_status`,`bai_orders_db_confirm`.`st_status` AS `st_status`,`bai_orders_db_confirm`.`pt_status` AS `pt_status`,`bai_orders_db_confirm`.`trim_status` AS `trim_status`,`cat_stat_log`.`category` AS `category`,`cat_stat_log`.`clubbing` AS `clubbing`,`plandoc_stat_log`.`plan_module` AS `plan_module`,`plandoc_stat_log`.`act_movement_status` AS `act_movement_status`,`plandoc_stat_log`.`cat_ref` AS `cat_ref`,`plandoc_stat_log`.`remarks` AS `remarks`,IF(`bai_orders_db_confirm`.`order_embl_a` + `bai_orders_db_confirm`.`order_embl_b` > 0,1,0) + IF(`bai_orders_db_confirm`.`order_embl_e` + `bai_orders_db_confirm`.`order_embl_f` > 0,2,0) AS `emb_stat1` FROM ((`plandoc_stat_log` JOIN `bai_orders_db_confirm`) JOIN `cat_stat_log`) WHERE `bai_orders_db_confirm`.`order_tid` = `plandoc_stat_log`.`order_tid` AND `cat_stat_log`.`tid` = `plandoc_stat_log`.`cat_ref` AND `cat_stat_log`.`category` IN ('Body','Front') AND `plandoc_stat_log`.`date` > '2010-08-01' AND (`plandoc_stat_log`.`act_cut_issue_status` = '' OR `plandoc_stat_log`.`a_plies` <> `plandoc_stat_log`.`p_plies` OR `plandoc_stat_log`.`plan_module` IS NULL) ORDER BY `bai_orders_db_confirm`.`order_style_no`);

ALTER VIEW `bai_pro3`.`plan_dash_summ_embl` AS (
SELECT `bai_pro3`.`embellishment_plan_dashboard`.`track_id` AS `track_id`,`bai_pro3`.`embellishment_plan_dashboard`.`short_shipment_status` AS `short_shipment_status`,`bai_pro3`.`embellishment_plan_dashboard`.`doc_no` AS `doc_no`,`bai_pro3`.`embellishment_plan_dashboard`.`module` AS `module`,`bai_pro3`.`embellishment_plan_dashboard`.`priority` AS `priority`,`bai_pro3`.`embellishment_plan_dashboard`.`fabric_status` AS `fabric_status`,`bai_pro3`.`plandoc_stat_log`.`act_cut_issue_status` AS `act_cut_issue_status`,`bai_pro3`.`plandoc_stat_log`.`plan_lot_ref` AS `plan_lot_ref`,`bai_pro3`.`plandoc_stat_log`.`pcutdocid` AS `bundle_location`,`bai_pro3`.`plandoc_stat_log`.`print_status` AS `print_status`,`bai_pro3`.`plandoc_stat_log`.`act_cut_status` AS `act_cut_status`,`bai_pro3`.`plandoc_stat_log`.`rm_date` AS `rm_date`,`bai_pro3`.`plandoc_stat_log`.`cut_inp_temp` AS `cut_inp_temp`,`bai_pro3`.`plandoc_stat_log`.`a_xs` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `xs`,`bai_pro3`.`plandoc_stat_log`.`a_s` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s`,`bai_pro3`.`plandoc_stat_log`.`a_m` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `m`,`bai_pro3`.`plandoc_stat_log`.`a_l` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `l`,`bai_pro3`.`plandoc_stat_log`.`a_xl` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `xl`,`bai_pro3`.`plandoc_stat_log`.`a_xxl` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `xxl`,`bai_pro3`.`plandoc_stat_log`.`a_xxxl` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `xxxl`,`bai_pro3`.`plandoc_stat_log`.`a_s01` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s01`,`bai_pro3`.`plandoc_stat_log`.`a_s02` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s02`,`bai_pro3`.`plandoc_stat_log`.`a_s03` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s03`,`bai_pro3`.`plandoc_stat_log`.`a_s04` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s04`,`bai_pro3`.`plandoc_stat_log`.`a_s05` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s05`,`bai_pro3`.`plandoc_stat_log`.`a_s06` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s06`,`bai_pro3`.`plandoc_stat_log`.`a_s07` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s07`,`bai_pro3`.`plandoc_stat_log`.`a_s08` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s08`,`bai_pro3`.`plandoc_stat_log`.`a_s09` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s09`,`bai_pro3`.`plandoc_stat_log`.`a_s10` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s10`,`bai_pro3`.`plandoc_stat_log`.`a_s11` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s11`,`bai_pro3`.`plandoc_stat_log`.`a_s12` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s12`,`bai_pro3`.`plandoc_stat_log`.`a_s13` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s13`,`bai_pro3`.`plandoc_stat_log`.`a_s14` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s14`,`bai_pro3`.`plandoc_stat_log`.`a_s15` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s15`,`bai_pro3`.`plandoc_stat_log`.`a_s16` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s16`,`bai_pro3`.`plandoc_stat_log`.`a_s17` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s17`,`bai_pro3`.`plandoc_stat_log`.`a_s18` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s18`,`bai_pro3`.`plandoc_stat_log`.`a_s19` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s19`,`bai_pro3`.`plandoc_stat_log`.`a_s20` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s20`,`bai_pro3`.`plandoc_stat_log`.`a_s21` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s21`,`bai_pro3`.`plandoc_stat_log`.`a_s22` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s22`,`bai_pro3`.`plandoc_stat_log`.`a_s23` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s23`,`bai_pro3`.`plandoc_stat_log`.`a_s24` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s24`,`bai_pro3`.`plandoc_stat_log`.`a_s25` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s25`,`bai_pro3`.`plandoc_stat_log`.`a_s26` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s26`,`bai_pro3`.`plandoc_stat_log`.`a_s27` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s27`,`bai_pro3`.`plandoc_stat_log`.`a_s28` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s28`,`bai_pro3`.`plandoc_stat_log`.`a_s29` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s29`,`bai_pro3`.`plandoc_stat_log`.`a_s30` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s30`,`bai_pro3`.`plandoc_stat_log`.`a_s31` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s31`,`bai_pro3`.`plandoc_stat_log`.`a_s32` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s32`,`bai_pro3`.`plandoc_stat_log`.`a_s33` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s33`,`bai_pro3`.`plandoc_stat_log`.`a_s34` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s34`,`bai_pro3`.`plandoc_stat_log`.`a_s35` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s35`,`bai_pro3`.`plandoc_stat_log`.`a_s36` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s36`,`bai_pro3`.`plandoc_stat_log`.`a_s37` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s37`,`bai_pro3`.`plandoc_stat_log`.`a_s38` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s38`,`bai_pro3`.`plandoc_stat_log`.`a_s39` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s39`,`bai_pro3`.`plandoc_stat_log`.`a_s40` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s40`,`bai_pro3`.`plandoc_stat_log`.`a_s41` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s41`,`bai_pro3`.`plandoc_stat_log`.`a_s42` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s42`,`bai_pro3`.`plandoc_stat_log`.`a_s43` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s43`,`bai_pro3`.`plandoc_stat_log`.`a_s44` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s44`,`bai_pro3`.`plandoc_stat_log`.`a_s45` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s45`,`bai_pro3`.`plandoc_stat_log`.`a_s46` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s46`,`bai_pro3`.`plandoc_stat_log`.`a_s47` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s47`,`bai_pro3`.`plandoc_stat_log`.`a_s48` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s48`,`bai_pro3`.`plandoc_stat_log`.`a_s49` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s49`,`bai_pro3`.`plandoc_stat_log`.`a_s50` * `bai_pro3`.`plandoc_stat_log`.`a_plies` AS `s50`,`bai_pro3`.`plandoc_stat_log`.`a_plies` AS `a_plies`,`bai_pro3`.`plandoc_stat_log`.`p_plies` AS `p_plies`,`bai_pro3`.`plandoc_stat_log`.`mk_ref` AS `mk_ref`,`bai_pro3`.`plandoc_stat_log`.`order_tid` AS `order_tid`,`bai_pro3`.`plandoc_stat_log`.`fabric_status` AS `fabric_status_new`,`bai_pro3`.`embellishment_plan_dashboard`.`log_time` AS `log_time`,`bai_pro3`.`plandoc_stat_log`.`remarks` AS `remarks` FROM (`bai_pro3`.`embellishment_plan_dashboard` LEFT JOIN `bai_pro3`.`plandoc_stat_log` ON(`bai_pro3`.`embellishment_plan_dashboard`.`doc_no` = `bai_pro3`.`plandoc_stat_log`.`doc_no`)) WHERE `bai_pro3`.`plandoc_stat_log`.`order_tid` IS NOT NULL ORDER BY `bai_pro3`.`embellishment_plan_dashboard`.`priority`);


ALTER  VIEW `bai_pro3`.`plan_dash_doc_summ_embl` AS (
SELECT `plan_dash_summ_embl`.`track_id` AS `track_id`,`plan_dash_summ_embl`.`short_shipment_status` AS `short_shipment_status`,`plan_dash_summ_embl`.`print_status` AS `print_status`,`plan_dash_summ_embl`.`plan_lot_ref` AS `plan_lot_ref`,`plan_dash_summ_embl`.`bundle_location` AS `bundle_location`,`plan_dash_summ_embl`.`fabric_status_new` AS `fabric_status_new`,`plan_dash_summ_embl`.`doc_no` AS `doc_no`,`plan_dash_summ_embl`.`module` AS `module`,`plan_dash_summ_embl`.`priority` AS `priority`,`plan_dash_summ_embl`.`act_cut_issue_status` AS `act_cut_issue_status`,`plan_dash_summ_embl`.`act_cut_status` AS `act_cut_status`,`plan_dash_summ_embl`.`rm_date` AS `rm_date`,`plan_dash_summ_embl`.`cut_inp_temp` AS `cut_inp_temp`,`plan_dash_summ_embl`.`order_tid` AS `order_tid`,`plan_dash_summ_embl`.`fabric_status` AS `fabric_status`,`plan_doc_summ`.`color_code` AS `color_code`,`plan_doc_summ`.`clubbing` AS `clubbing`,`plan_doc_summ`.`order_style_no` AS `order_style_no`,`plan_doc_summ`.`order_div` AS `order_div`,`plan_doc_summ`.`order_col_des` AS `order_col_des`,`plan_doc_summ`.`acutno` AS `acutno`,`plan_doc_summ`.`ft_status` AS `ft_status`,`plan_doc_summ`.`st_status` AS `st_status`,`plan_doc_summ`.`pt_status` AS `pt_status`,`plan_doc_summ`.`trim_status` AS `trim_status`,`plan_dash_summ_embl`.`xs` AS `xs`,`plan_dash_summ_embl`.`s` AS `s`,`plan_dash_summ_embl`.`m` AS `m`,`plan_dash_summ_embl`.`l` AS `l`,`plan_dash_summ_embl`.`xl` AS `xl`,`plan_dash_summ_embl`.`xxl` AS `xxl`,`plan_dash_summ_embl`.`xxxl` AS `xxxl`,`plan_dash_summ_embl`.`s01` AS `s01`,`plan_dash_summ_embl`.`s02` AS `s02`,`plan_dash_summ_embl`.`s03` AS `s03`,`plan_dash_summ_embl`.`s04` AS `s04`,`plan_dash_summ_embl`.`s05` AS `s05`,`plan_dash_summ_embl`.`s06` AS `s06`,`plan_dash_summ_embl`.`s07` AS `s07`,`plan_dash_summ_embl`.`s08` AS `s08`,`plan_dash_summ_embl`.`s09` AS `s09`,`plan_dash_summ_embl`.`s10` AS `s10`,`plan_dash_summ_embl`.`s11` AS `s11`,`plan_dash_summ_embl`.`s12` AS `s12`,`plan_dash_summ_embl`.`s13` AS `s13`,`plan_dash_summ_embl`.`s14` AS `s14`,`plan_dash_summ_embl`.`s15` AS `s15`,`plan_dash_summ_embl`.`s16` AS `s16`,`plan_dash_summ_embl`.`s17` AS `s17`,`plan_dash_summ_embl`.`s18` AS `s18`,`plan_dash_summ_embl`.`s19` AS `s19`,`plan_dash_summ_embl`.`s20` AS `s20`,`plan_dash_summ_embl`.`s21` AS `s21`,`plan_dash_summ_embl`.`s22` AS `s22`,`plan_dash_summ_embl`.`s23` AS `s23`,`plan_dash_summ_embl`.`s24` AS `s24`,`plan_dash_summ_embl`.`s25` AS `s25`,`plan_dash_summ_embl`.`s26` AS `s26`,`plan_dash_summ_embl`.`s27` AS `s27`,`plan_dash_summ_embl`.`s28` AS `s28`,`plan_dash_summ_embl`.`s29` AS `s29`,`plan_dash_summ_embl`.`s30` AS `s30`,`plan_dash_summ_embl`.`s31` AS `s31`,`plan_dash_summ_embl`.`s32` AS `s32`,`plan_dash_summ_embl`.`s33` AS `s33`,`plan_dash_summ_embl`.`s34` AS `s34`,`plan_dash_summ_embl`.`s35` AS `s35`,`plan_dash_summ_embl`.`s36` AS `s36`,`plan_dash_summ_embl`.`s37` AS `s37`,`plan_dash_summ_embl`.`s38` AS `s38`,`plan_dash_summ_embl`.`s39` AS `s39`,`plan_dash_summ_embl`.`s40` AS `s40`,`plan_dash_summ_embl`.`s41` AS `s41`,`plan_dash_summ_embl`.`s42` AS `s42`,`plan_dash_summ_embl`.`s43` AS `s43`,`plan_dash_summ_embl`.`s44` AS `s44`,`plan_dash_summ_embl`.`s45` AS `s45`,`plan_dash_summ_embl`.`s46` AS `s46`,`plan_dash_summ_embl`.`s47` AS `s47`,`plan_dash_summ_embl`.`s48` AS `s48`,`plan_dash_summ_embl`.`s49` AS `s49`,`plan_dash_summ_embl`.`s50` AS `s50`,`plan_dash_summ_embl`.`a_plies` AS `a_plies`,`plan_dash_summ_embl`.`p_plies` AS `p_plies`,`plan_dash_summ_embl`.`mk_ref` AS `mk_ref`,`plan_dash_summ_embl`.`xs` + `plan_dash_summ_embl`.`s` + `plan_dash_summ_embl`.`m` + `plan_dash_summ_embl`.`l` + `plan_dash_summ_embl`.`xl` + `plan_dash_summ_embl`.`xxl` + `plan_dash_summ_embl`.`xxxl` + `plan_dash_summ_embl`.`s01` + `plan_dash_summ_embl`.`s02` + `plan_dash_summ_embl`.`s03` + `plan_dash_summ_embl`.`s04` + `plan_dash_summ_embl`.`s05` + `plan_dash_summ_embl`.`s06` + `plan_dash_summ_embl`.`s07` + `plan_dash_summ_embl`.`s08` + `plan_dash_summ_embl`.`s09` + `plan_dash_summ_embl`.`s10` + `plan_dash_summ_embl`.`s11` + `plan_dash_summ_embl`.`s12` + `plan_dash_summ_embl`.`s13` + `plan_dash_summ_embl`.`s14` + `plan_dash_summ_embl`.`s15` + `plan_dash_summ_embl`.`s16` + `plan_dash_summ_embl`.`s17` + `plan_dash_summ_embl`.`s18` + `plan_dash_summ_embl`.`s19` + `plan_dash_summ_embl`.`s20` + `plan_dash_summ_embl`.`s21` + `plan_dash_summ_embl`.`s22` + `plan_dash_summ_embl`.`s23` + `plan_dash_summ_embl`.`s24` + `plan_dash_summ_embl`.`s25` + `plan_dash_summ_embl`.`s26` + `plan_dash_summ_embl`.`s27` + `plan_dash_summ_embl`.`s28` + `plan_dash_summ_embl`.`s29` + `plan_dash_summ_embl`.`s30` + `plan_dash_summ_embl`.`s31` + `plan_dash_summ_embl`.`s32` + `plan_dash_summ_embl`.`s33` + `plan_dash_summ_embl`.`s34` + `plan_dash_summ_embl`.`s35` + `plan_dash_summ_embl`.`s36` + `plan_dash_summ_embl`.`s37` + `plan_dash_summ_embl`.`s38` + `plan_dash_summ_embl`.`s39` + `plan_dash_summ_embl`.`s40` + `plan_dash_summ_embl`.`s41` + `plan_dash_summ_embl`.`s42` + `plan_dash_summ_embl`.`s43` + `plan_dash_summ_embl`.`s44` + `plan_dash_summ_embl`.`s45` + `plan_dash_summ_embl`.`s46` + `plan_dash_summ_embl`.`s47` + `plan_dash_summ_embl`.`s48` + `plan_dash_summ_embl`.`s49` + `plan_dash_summ_embl`.`s50` AS `total`,`plan_doc_summ`.`act_movement_status` AS `act_movement_status`,`plan_doc_summ`.`order_del_no` AS `order_del_no`,`plan_dash_summ_embl`.`log_time` AS `log_time`,`plan_doc_summ`.`emb_stat1` AS `emb_stat`,`plan_doc_summ`.`cat_ref` AS `cat_ref`,`plan_doc_summ`.`remarks` AS `remarks` FROM (`plan_dash_summ_embl` LEFT JOIN `plan_doc_summ` ON (`plan_doc_summ`.`doc_no` = `plan_dash_summ_embl`.`doc_no`)));