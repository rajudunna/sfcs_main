	USE bai_pro3;
	DROP PROCEDURE IF EXISTS bai_pro3.sp_get_cut_completed_docs;
	CREATE PROCEDURE bai_pro3.sp_get_cut_completed_docs(TransactionDate DATE)
	
		SELECT plandoc_stat_log.doc_no, order_style_no AS style, order_del_no AS schedule_no, order_col_des AS color, 
		(plandoc_stat_log.p_s01+plandoc_stat_log.p_s02+plandoc_stat_log.p_s03+plandoc_stat_log.p_s04+plandoc_stat_log.p_s05+plandoc_stat_log.p_s06+plandoc_stat_log.p_s07+plandoc_stat_log.p_s08+plandoc_stat_log.p_s09+plandoc_stat_log.p_s10+plandoc_stat_log.p_s11+plandoc_stat_log.p_s12+plandoc_stat_log.p_s13+plandoc_stat_log.p_s14+plandoc_stat_log.p_s15+plandoc_stat_log.p_s16+plandoc_stat_log.p_s17+plandoc_stat_log.p_s18+plandoc_stat_log.p_s19+plandoc_stat_log.p_s20+plandoc_stat_log.p_s21+plandoc_stat_log.p_s22+plandoc_stat_log.p_s23+plandoc_stat_log.p_s24+plandoc_stat_log.p_s25+plandoc_stat_log.p_s26+plandoc_stat_log.p_s27+plandoc_stat_log.p_s28+plandoc_stat_log.p_s29+plandoc_stat_log.p_s30+plandoc_stat_log.p_s31+plandoc_stat_log.p_s32+plandoc_stat_log.p_s33+plandoc_stat_log.p_s34+plandoc_stat_log.p_s35+plandoc_stat_log.p_s36+plandoc_stat_log.p_s37+plandoc_stat_log.p_s38+plandoc_stat_log.p_s39+plandoc_stat_log.p_s40+plandoc_stat_log.p_s41+plandoc_stat_log.p_s42+plandoc_stat_log.p_s43+plandoc_stat_log.p_s44+plandoc_stat_log.p_s45+plandoc_stat_log.p_s46+plandoc_stat_log.p_s47+plandoc_stat_log.p_s48+plandoc_stat_log.p_s49+plandoc_stat_log.p_s50)*p_plies AS planned_qty,
		(plandoc_stat_log.a_s01+plandoc_stat_log.a_s02+plandoc_stat_log.a_s03+plandoc_stat_log.a_s04+plandoc_stat_log.a_s05+plandoc_stat_log.a_s06+plandoc_stat_log.a_s07+plandoc_stat_log.a_s08+plandoc_stat_log.a_s09+plandoc_stat_log.a_s10+plandoc_stat_log.a_s11+plandoc_stat_log.a_s12+plandoc_stat_log.a_s13+plandoc_stat_log.a_s14+plandoc_stat_log.a_s15+plandoc_stat_log.a_s16+plandoc_stat_log.a_s17+plandoc_stat_log.a_s18+plandoc_stat_log.a_s19+plandoc_stat_log.a_s20+plandoc_stat_log.a_s21+plandoc_stat_log.a_s22+plandoc_stat_log.a_s23+plandoc_stat_log.a_s24+plandoc_stat_log.a_s25+plandoc_stat_log.a_s26+plandoc_stat_log.a_s27+plandoc_stat_log.a_s28+plandoc_stat_log.a_s29+plandoc_stat_log.a_s30+plandoc_stat_log.a_s31+plandoc_stat_log.a_s32+plandoc_stat_log.a_s33+plandoc_stat_log.a_s34+plandoc_stat_log.a_s35+plandoc_stat_log.a_s36+plandoc_stat_log.a_s37+plandoc_stat_log.a_s38+plandoc_stat_log.a_s39+plandoc_stat_log.a_s40+plandoc_stat_log.a_s41+plandoc_stat_log.a_s42+plandoc_stat_log.a_s43+plandoc_stat_log.a_s44+plandoc_stat_log.a_s45+plandoc_stat_log.a_s46+plandoc_stat_log.a_s47+plandoc_stat_log.a_s48+plandoc_stat_log.a_s49+plandoc_stat_log.a_s50)*a_plies AS actual_qty,
		p_plies AS no_of_planned_plies,mklength AS marker_length, purwidth AS marker_width, mkeff AS marker_efficiency, 
		ROUND(mklength/(plandoc_stat_log.p_s01+plandoc_stat_log.p_s02+plandoc_stat_log.p_s03+plandoc_stat_log.p_s04+plandoc_stat_log.p_s05+plandoc_stat_log.p_s06+plandoc_stat_log.p_s07+plandoc_stat_log.p_s08+plandoc_stat_log.p_s09+plandoc_stat_log.p_s10+plandoc_stat_log.p_s11+plandoc_stat_log.p_s12+plandoc_stat_log.p_s13+plandoc_stat_log.p_s14+plandoc_stat_log.p_s15+plandoc_stat_log.p_s16+plandoc_stat_log.p_s17+plandoc_stat_log.p_s18+plandoc_stat_log.p_s19+plandoc_stat_log.p_s20+plandoc_stat_log.p_s21+plandoc_stat_log.p_s22+plandoc_stat_log.p_s23+plandoc_stat_log.p_s24+plandoc_stat_log.p_s25+plandoc_stat_log.p_s26+plandoc_stat_log.p_s27+plandoc_stat_log.p_s28+plandoc_stat_log.p_s29+plandoc_stat_log.p_s30+plandoc_stat_log.p_s31+plandoc_stat_log.p_s32+plandoc_stat_log.p_s33+plandoc_stat_log.p_s34+plandoc_stat_log.p_s35+plandoc_stat_log.p_s36+plandoc_stat_log.p_s37+plandoc_stat_log.p_s38+plandoc_stat_log.p_s39+plandoc_stat_log.p_s40+plandoc_stat_log.p_s41+plandoc_stat_log.p_s42+plandoc_stat_log.p_s43+plandoc_stat_log.p_s44+plandoc_stat_log.p_s45+plandoc_stat_log.p_s46+plandoc_stat_log.p_s47+plandoc_stat_log.p_s48+plandoc_stat_log.p_s49+plandoc_stat_log.p_s50),4) AS marker_yy,
		acutno AS cut_no,a_plies AS no_of_actual_plies, compo_no AS rm_sku
		FROM bai_pro3.plandoc_stat_log
		LEFT JOIN bai_pro3.bai_orders_db ON plandoc_stat_log.order_tid =  bai_orders_db.order_tid
		LEFT JOIN bai_pro3.maker_stat_log ON plandoc_stat_log.mk_ref =  maker_stat_log.tid
		LEFT JOIN bai_pro3.cat_stat_log ON plandoc_stat_log.cat_ref =  cat_stat_log.tid
		LEFT JOIN bai_pro3.act_cut_status ON plandoc_stat_log.doc_no =  act_cut_status.doc_no
		LEFT JOIN bai_pro3.cps_log ON plandoc_stat_log.doc_no = cps_log.doc_no
		WHERE DATE(act_cut_status.log_date)=TransactionDate AND cps_log.reported_status='F' GROUP BY doc_no;