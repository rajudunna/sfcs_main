<?php

echo "SCRIPT STARETED<br/>";
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');

//5 cuts are to be inserted for excess qty of parent cuts
// 1,2 parents are already reported
// 3,4,5 parents are not yet reported 
$insert_query1 = "insert into `bai_pro3`.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`, `acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `lastup`, `remarks`, `act_cut_status`, `act_cut_issue_status`, `pcutdocid`, `print_status`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`,`org_doc_no`, `org_plies`) values ('2019-03-15', '19161', '1347', '5135', '3313', 'JJA152F9       60908701-1P-Off White               ', '3', '2', '0', '0', '0', '0', '0', '0', '0', '1', '3', '0', '0', '0', '0', '0', '0', '0', '1', '2019-03-15 09:31:09', '', '', '', 'JJA152F9       60908701-1P-Off White               /5135/2', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0','0','24','8382','88')";

$insert_query2 = "insert into `bai_pro3`.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`,`acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `lastup`, `remarks`, `act_cut_status`, `act_cut_issue_status`, `pcutdocid`, `print_status`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`,`org_doc_no`, `org_plies`) values ('2019-03-15', '19161', '1347', '5135', '3313', 'JJA152F9       60908701-1P-Off White               ', '4', '3', '0', '0', '0', '0', '0', '0', '0', '1', '4', '0', '0', '0', '0', '0', '0', '0', '1', '2019-03-15 09:31:09', '', '', '', 'JJA152F9       60908701-1P-Off White               /5135/2', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0','0', '8', '0','0','8383','30')";


$insert_query3 = "insert into `bai_pro3`.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`, `acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `lastup`, `remarks`, `act_cut_status`, `act_cut_issue_status`, `pcutdocid`, `print_status`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`,`org_doc_no`, `org_plies`) values ('2019-03-15', '19161', '1347', '5135', '3313', 'JJA152F9       60908701-1P-Off White               ', '5', '4', '0', '0', '0', '0', '0', '0', '0', '1','5', '0', '0', '0', '0', '0', '0', '0', '1', '2019-03-15 09:31:09', '', '', '', 'JJA152F9       60908701-1P-Off White               /5135/2', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0','0', '0', '25', '0','0','8384','5')";

$insert_query4 = "insert into `bai_pro3`.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`,`acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `lastup`, `remarks`, `act_cut_status`, `act_cut_issue_status`, `pcutdocid`, `print_status`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`,`org_doc_no`, `org_plies`) values ('2019-03-15', '19161', '1347', '5135', '3313', 'JJA152F9       60908701-1P-Off White               ', '6', '5', '0', '0', '0', '0', '0', '0', '0', '1','6', '0', '0', '0', '0', '0', '0', '0', '1', '2019-03-15 09:31:09', '', '', '', 'JJA152F9       60908701-1P-Off White               /5135/2', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0','0', '78', '99','0','8385','3')";

$insert_query5 = "insert into `bai_pro3`.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`,`acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `lastup`, `remarks`, `act_cut_status`, `act_cut_issue_status`, `pcutdocid`, `print_status`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`,`org_doc_no`, `org_plies`) values ('2019-03-11', '19169', '1347', '5136', '3080', 'JJA152F9       60957801-1P-Off White               ', '5', '4', '0', '0', '0', '0', '0', '0', '0', '1','4', '0', '0', '0', '0', '0', '0', '0', '1', '0000-00-00 00:00:00', 'Normal', '', '', 'JJA152F9       1903110000401-1P-Off White               /5129/4', NULL, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '5', '0','0','5','5','5','8384','5')";

echo "INSERTED INTO plandoc_stat_log<br/>";

mysqli_query($link,$insert_query1) or exit('Problem doc 1 ');
$doc1 = mysqli_insert_id($link);

mysqli_query($link,$insert_query2) or exit('Problem doc 2 ');
$doc2 = mysqli_insert_id($link);

mysqli_query($link,$insert_query3) or exit('Problem doc 3 ');
$doc3 = mysqli_insert_id($link);

mysqli_query($link,$insert_query4) or exit('Problem doc 4 ');
$doc4 = mysqli_insert_id($link);

mysqli_query($link,$insert_query5) or exit('Problem doc 5 ');
$doc5 = mysqli_insert_id($link);


$query1 = "INSERT INTO brandix_bts.tbl_cut_master (doc_num,ref_order_num,cut_num,cut_status,planned_module,issued_time,planned_plies,
        actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code)
        VALUES($doc1,1490,3,'',0,'2019-03-11',1,1,'2019-03-11',112,609087,19161,1347,3313,65)";

$query2 = "INSERT INTO brandix_bts.tbl_cut_master (doc_num,ref_order_num,cut_num,cut_status,planned_module,issued_time,planned_plies,
        actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code)
        VALUES($doc2,1490,4,'',0,'2019-03-11',1,1,'2019-03-11',112,609087,19161,1347,3313,65)";        

$query3 = "INSERT INTO brandix_bts.tbl_cut_master (doc_num,ref_order_num,cut_num,cut_status,planned_module,issued_time,planned_plies,
        actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code)
		VALUES($doc3,1491,5,'',0,'2019-03-11',1,1,'2019-03-11',112,609578,19169,1347,3080,65)";

$query4 = "INSERT INTO brandix_bts.tbl_cut_master (doc_num,ref_order_num,cut_num,cut_status,planned_module,issued_time,planned_plies,
        actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code)
        VALUES($doc4,1490,5,'',0,'2019-03-11',1,1,'2019-03-11',112,609087,19161,1347,3313,65)";

$query5 = "INSERT INTO brandix_bts.tbl_cut_master (doc_num,ref_order_num,cut_num,cut_status,planned_module,issued_time,planned_plies,
        actual_plies,plan_date,style_id,product_schedule,cat_ref,cuttable_ref,mk_ref,col_code)
        VALUES($doc5,1490,6,'',0,'2019-03-11',1,1,'2019-03-11',112,609087,19161,1347,3313,65)";


mysqli_query($link,$query1) or exit('Problem cutmaster 1 ');
$p1 = mysqli_insert_id($link);

mysqli_query($link,$query2) or exit('Problem docutmasterc 2 ');
$p2 = mysqli_insert_id($link);

mysqli_query($link,$query3) or exit('Problem cutmaster 3 ');
$p3 = mysqli_insert_id($link);

mysqli_query($link,$query4) or exit('Problem cutmaster 4 ');
$p4 = mysqli_insert_id($link);

mysqli_query($link,$query5) or exit('Problem cutmaster 5 ');
$p5 = mysqli_insert_id($link);

echo "Iserted into cut_master<br/>";

$insert_query = "INSERT INTO brandix_bts.tbl_cut_size_master (parent_id,ref_size_name,quantity,color)
			VALUES 
            ($p1,3,8, '01-1P-Off White'),
			($p2,4,24,'01-1P-Off White'),
            ($p3,2,5, '01-1P-Off White'),($p3,5,5,'01-1P-Off White'),($p3,6,5,'01-1P-Off White'),($p3,7,5,'01-1P-Off White'),
			($p4,3,25,'01-1P-Off White'),
			($p5,3,78,'01-1P-Off White'),($p5,4,99,'01-1P-Off White')";
mysqli_query($link,$insert_query);			

echo "inserted into cut_sizes_master<br/>";
//inseting into cps,bcd and moq

doc_size_wise_bundle_insertion($doc1,1);
doc_size_wise_bundle_insertion($doc2,1);
doc_size_wise_bundle_insertion($doc3,1);
doc_size_wise_bundle_insertion($doc4,1);
doc_size_wise_bundle_insertion($doc5,1);

/*

3 - M - 8524097
4 - L - 8524096

*/


echo "Bundle Insertions Done<br/>";
//Creating Sewing jobs for the schedules only for 609087

$sewing_query1 = "INSERT INTO bai_pro3.pac_stat_log_input_job (doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,
				packing_mode,old_size,doc_type,type_of_sewing,sref_id,pac_seq_no,barcode_sequence,bundle_print_status)
                values ($doc1,'M',8,4,'6090871903114','JP01',1,'s03','N',2,1276,0,1,0)";

$sewing_query2 = "INSERT INTO bai_pro3.pac_stat_log_input_job (doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,
				packing_mode,old_size,doc_type,type_of_sewing,sref_id,pac_seq_no,barcode_sequence,bundle_print_status)
                values ($doc2,'L',24,4,'6090871903114','JP01',1,'s04','N',2,1276,0,1,0)";
                
$sewing_query3 = "INSERT INTO bai_pro3.pac_stat_log_input_job (doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,
				packing_mode,old_size,doc_type,type_of_sewing,sref_id,pac_seq_no,barcode_sequence,bundle_print_status)
				values ($doc3,'M',25,4,'6090871903114','JP01',1,'s03','N',2,1276,0,1,0)";

$sewing_query4 = "INSERT INTO bai_pro3.pac_stat_log_input_job (doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,
				packing_mode,old_size,doc_type,type_of_sewing,sref_id,pac_seq_no,barcode_sequence,bundle_print_status)
				values ($doc4,'M',78,4,'6090871903114','JP01',1,'s03','N',2,1276,0,1,0)";

$sewing_query5 = "INSERT INTO bai_pro3.pac_stat_log_input_job (doc_no,size_code,carton_act_qty,input_job_no,input_job_no_random,destination,
				packing_mode,old_size,doc_type,type_of_sewing,sref_id,pac_seq_no,barcode_sequence,bundle_print_status)
				values ($doc4,'L',99,4,'6090871903114','JP01',1,'s04','N',2,1276,0,1,0)";

mysqli_query($link,$sewing_query1) or exit('Problem sewing 1');
$tid1 = mysqli_insert_id($link);

mysqli_query($link,$sewing_query2) or exit('Problem sewing 2');
$tid2 = mysqli_insert_id($link);

mysqli_query($link,$sewing_query3) or exit('Problem sewing 3');
$tid3 = mysqli_insert_id($link);

mysqli_query($link,$sewing_query4) or exit('Problem sewing 4');
$tid4 = mysqli_insert_id($link);

mysqli_query($link,$sewing_query5) or exit('Problem sewing 5');
$tid5 = mysqli_insert_id($link);

echo "Sewing Jobs created<br/>";

//MOQ Insertions
$op_codes_query = "SELECT operation_code,operation_name from bai_pro3.tbl_orders_ops_ref where category = 'sewing' ";
$op_codes_result = mysqli_query($link,$op_codes_query);
while($row = mysqli_fetch_array($op_codes_result)){
	$op  = $row['operation_code'];
	$des = $row['operation_name'];
	$moq_query = "INSERT INTO bai_pro3.mo_operation_quantites (date_time,mo_no,ref_no,bundle_quantity,op_code,op_desc)
			VALUES 
            ('2019-03-11 18:08:55',8524097,$tid1,8,$op,'$des')
			('2019-03-11 18:08:55',8524096,$tid2,24,$op,'$des')
            ('2019-03-11 18:08:55',8524097,$tid1,25,$op,'$des')
			('2019-03-11 18:08:55',8524097,$tid2,78,$op,'$des')
			('2019-03-11 18:08:55',8524096,$tid3,99,$op,'$des')";
	mysqli_query($link,$moq_query) or exit("Problem MOQ $op");		
}
echo "MOQ Inserted<br/>";


//Updating cut for the childs doc1,doc2
$update_cps = "UPDATE $bai_pro3.cps_log set remaining_qty = cut_quantity,reported_status='F' where doc_no IN ($doc1,$doc2) and operation_code = 15";
mysqli_query($link,$update_cps) or exit('Problem In CPS update');

$update_bcd = "UPDATE brandix_bts.bundle_creation_data set recevied_qty = original_qty where docket_number IN ($doc1,$doc2) 
            and operation_id = 15";
mysqli_query($link,$update_bcd) or exit('Problem In BCD update');;

//updating to m3 for doc1,doc2
$docs_query = "SELECT remaining_ty,operation_code from bai_pro3.cps_log where doc_no IN ($doc1,$doc2) and operation_code = 15";
$docs_result = mysqli_query($link,$docs_query);
while($row = mysqli_fetch_array($docs_result)){
    $ref_id = $row['id'];
    $op_code = $row['operation_code'];
    $qty = $row['remaining_qty'];
    updateM3Transactions($ref_id,$op_code,$qty);
}
echo "Updated to M3<br/>";

echo "docs = $doc1 ,$doc2 ,$doc3 ,$doc4 ,$doc5  <br/>";
echo "cut masters = $p1 ,$p2 ,$p3 ,$p4 ,$p5  <br/>";
echo "tids sewing = $tid1 ,$tid2 ,$tid3 ,$tid4 ,$tid5  <br/>";





				



