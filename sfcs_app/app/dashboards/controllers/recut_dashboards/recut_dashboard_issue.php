<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
?>
<?php
if(isset($_POST['formSubmit']))
{
	$cat=$_POST['cat'];
	$mklen=$_POST['mklen'];
	$plies=$_POST['plies'];
	$order_tid=$_POST['order_tid'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$module=$_POST['module'];
	$cat_name=$_POST['cat_name'];
    $doc_nos=$_POST['doc_no_ref'];
    // $size = $_POST['size'];
    $ratioval =$_POST['ratioval'];
	$codes='2';
    $docket_no = '';
    $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.recut_v2 WHERE doc_no = '$doc_nos' ";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		$ordtid=$row['order_tid'];
		for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
                $cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
                $size[] = $sizes_array[$i];
                // $ratioval[$sizes_array[$i]][] = $row['a_'.$sizes_array[$i]];
			}
		}
    }

	$insdupdoc="INSERT INTO $bai_pro3.recut_v2 (date,cat_ref,cuttable_ref,  allocate_ref,  mk_ref, order_tid,                                              pcutno,   ratio,    p_xs,     p_s,     p_m,     p_l,    p_xl,   p_xxl,  p_xxxl,  p_plies,  acutno,    a_xs,     a_s,     a_m,     a_l,    a_xl,   a_xxl,  a_xxxl,  a_plies,  lastup,               remarks,  act_cut_status,  act_cut_issue_status,  pcutdocid,  print_status,   a_s01,   a_s02,   a_s03,   a_s04,   a_s05,   a_s06,   a_s07,   a_s08,   a_s09,   a_s10,   a_s11,   a_s12,   a_s13,   a_s14,   a_s15,   a_s16,   a_s17,   a_s18,   a_s19,   a_s20,   a_s21,   a_s22,   a_s23,   a_s24,   a_s25,   a_s26,   a_s27,   a_s28,   a_s29,   a_s30,   a_s31,  a_s32,   a_s33,   a_s34,   a_s35,   a_s36,   a_s37,   a_s38,   a_s39,   a_s40,   a_s41,   a_s42,   a_s43,   a_s44,   a_s45,   a_s46,   a_s47,   a_s48,   a_s49,   a_s50,   p_s01,   p_s02,   p_s03,   p_s04,   p_s05,   p_s06,   p_s07,   p_s08,   p_s09,   p_s10,   p_s11,   p_s12,   p_s13,   p_s14,   p_s15,   p_s16,   p_s17,   p_s18,   p_s19,   p_s20,   p_s21,   p_s22,   p_s23,   p_s24,   p_s25,   p_s26,   p_s27,   p_s28,   p_s29,   p_s30,   p_s31,   p_s32,   p_s33,   p_s34,   p_s35,   p_s36,   p_s37,   p_s38,   p_s39,   p_s40,   p_s41,   p_s42,   p_s43,   p_s44,   p_s45,   p_s46,   p_s47,   p_s48,   p_s49,   p_s50,  rm_date,  cut_inp_temp,  plan_module,  fabric_status,  plan_lot_ref, log_update  ) SELECT date,cat_ref,cuttable_ref,  allocate_ref,  mk_ref, order_tid,                                              pcutno,   ratio,    p_xs,     p_s,     p_m,     p_l,    p_xl,   p_xxl,  p_xxxl,  p_plies,  acutno,    a_xs,     a_s,     a_m,     a_l,    a_xl,   a_xxl,  a_xxxl,  a_plies,  lastup,               remarks,  act_cut_status,  act_cut_issue_status,  pcutdocid,  print_status,   a_s01,   a_s02,   a_s03,   a_s04,   a_s05,   a_s06,   a_s07,   a_s08,   a_s09,   a_s10,   a_s11,   a_s12,   a_s13,   a_s14,   a_s15,   a_s16,   a_s17,   a_s18,   a_s19,   a_s20,   a_s21,   a_s22,   a_s23,   a_s24,   a_s25,   a_s26,   a_s27,   a_s28,   a_s29,   a_s30,   a_s31,  a_s32,   a_s33,   a_s34,   a_s35,   a_s36,   a_s37,   a_s38,   a_s39,   a_s40,   a_s41,   a_s42,   a_s43,   a_s44,   a_s45,   a_s46,   a_s47,   a_s48,   a_s49,   a_s50,   p_s01,   p_s02,   p_s03,   p_s04,   p_s05,   p_s06,   p_s07,   p_s08,   p_s09,   p_s10,   p_s11,   p_s12,   p_s13,   p_s14,   p_s15,   p_s16,   p_s17,   p_s18,   p_s19,   p_s20,   p_s21,   p_s22,   p_s23,   p_s24,   p_s25,   p_s26,   p_s27,   p_s28,   p_s29,   p_s30,   p_s31,   p_s32,   p_s33,   p_s34,   p_s35,   p_s36,   p_s37,   p_s38,   p_s39,   p_s40,   p_s41,   p_s42,   p_s43,   p_s44,   p_s45,   p_s46,   p_s47,   p_s48,   p_s49,   p_s50,  rm_date,  cut_inp_temp,  plan_module,  fabric_status,  plan_lot_ref, log_update   FROM $bai_pro3.recut_v2 WHERE doc_no = '$doc_nos'";
	
	mysqli_query($link, $insdupdoc) or exit("insert_qry_recut".mysqli_error($GLOBALS["___mysqli_ston"]));
    $last_doc_no=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
    echo"$last_doc_no this is updated doc number";
    echo"$doc_nos this is doc number";
    // //inserting in plandoc_stat_log
    // $insplandoc="INSERT INTO `bai_pro3`.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`, `doc_no`, `acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `lastup`, `remarks`, `act_cut_status`, `act_cut_issue_status`, `pcutdocid`, `print_status`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`, `p_s08`, `p_s09`, `p_s10`, `p_s11`, `p_s12`, `p_s13`, `p_s14`, `p_s15`, `p_s16`, `p_s17`, `p_s18`, `p_s19`, `p_s20`, `p_s21`, `p_s22`, `p_s23`, `p_s24`, `p_s25`, `p_s26`, `p_s27`, `p_s28`, `p_s29`, `p_s30`, `p_s31`, `p_s32`, `p_s33`, `p_s34`, `p_s35`, `p_s36`, `p_s37`, `p_s38`, `p_s39`, `p_s40`, `p_s41`, `p_s42`, `p_s43`, `p_s44`, `p_s45`, `p_s46`, `p_s47`, `p_s48`, `p_s49`, `p_s50`, `rm_date`, `cut_inp_temp`, `plan_module`, `fabric_status`, `plan_lot_ref`, `log_update`, `org_doc_no`, `org_plies`, `docket_printed_person`) SELECT`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`, `doc_no`, `acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `lastup`, `remarks`, `act_cut_status`, `act_cut_issue_status`, `pcutdocid`, `print_status`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`, `p_s08`, `p_s09`, `p_s10`, `p_s11`, `p_s12`, `p_s13`, `p_s14`, `p_s15`, `p_s16`, `p_s17`, `p_s18`, `p_s19`, `p_s20`, `p_s21`, `p_s22`, `p_s23`, `p_s24`, `p_s25`, `p_s26`, `p_s27`, `p_s28`, `p_s29`, `p_s30`, `p_s31`, `p_s32`, `p_s33`, `p_s34`, `p_s35`, `p_s36`, `p_s37`, `p_s38`, `p_s39`, `p_s40`, `p_s41`, `p_s42`, `p_s43`, `p_s44`, `p_s45`, `p_s46`, `p_s47`, `p_s48`, `p_s49`, `p_s50`, `rm_date`, `cut_inp_temp`, `plan_module`, `fabric_status`, `plan_lot_ref`, `log_update`, `org_doc_no`, `org_plies`, `docket_printed_person` FROM $bai_pro3.plandoc_stat_log WHERE doc_no = '$doc_nos'";
    // mysqli_query($link, $insplandoc) or exit("insert_qry_plandoc".mysqli_error());
    // $lastdoc_no=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
    
	// $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));
    $query="SELECT* FROM $bai_pro3.`cuttable_stat_log` WHERE order_tid='$order_tid'";
    $sql_result111=mysqli_query($link, $query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row111=mysqli_fetch_array($sql_result111))
    {
        $tid=$sql_row111['tid'];
    }
    $qry_to_get = "SELECT * FROM  `$bai_pro3`.`cat_stat_log` WHERE  order_tid = \"$order_tid\" and category = '$cat_name'";
    $res_qry_to_get = $link->query($qry_to_get);
    while($row_cat_ref = $res_qry_to_get->fetch_assoc()) 
    {
        $cat_ref =$row_cat_ref['tid'];
        $patt_ver = $row_cat_ref['patt_ver'];
    }
	
    $sql1="insert into $bai_pro3.maker_stat_log(date,cat_ref,order_tid,mklength,mk_ver) values (\"".date("Y-m-d")."\",".$cat_ref.",\"$order_tid\",".$mklen.",'".$patt_ver."')";
    mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $ilastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
    $sql1="update $bai_pro3.recut_v2 set fabric_status='0',p_plies=".$plies.",a_plies=".$plies.",mk_ref=$ilastid where doc_no=".$doc_nos;
    mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql1="update $bai_pro3.plandoc_stat_log set p_plies=".$plies.",a_plies=".$plies.",mk_ref=$ilastid where doc_no=".$doc_nos;
    mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	//getting details from recut_v2
	$get_det_qry="select max(pcutno) as pcutno from bai_pro3.recut_v2 where order_tid='$order_tid'";
	$sql_res = $link->query($get_det_qry);
	while($rows =$sql_res->fetch_assoc()) 
    {
		$cutno=$rows['pcutno'];
    }
    $newcut_no=$cutno+1; 
	
    //retreaving actual quantity to recut
    
    for($j=0;$j<sizeof($size);$j++)
    {
        $qty_act = array_sum($ratioval[$size[$j]])*$plies;
        $buffer_qty[$size[$j]] = $qty_act - $cut_done_qty[$size[$j]] ;
        $qty_ind_ratio  =  array_sum($ratioval[$size[$j]]);
        $a_string = 'a_'.$size[$j];
        $p_string = 'p_'.$size[$j];
        

		$getquantities="select  $a_string as quantity,$p_string from bai_pro3.recut_v2 where doc_no = $doc_nos";
		$sql_res_fin = $link->query($getquantities);
		while($rows =$sql_res_fin->fetch_assoc()) 
		{
			$quant=$rows['quantity'];
		}
		$finalquantity=$quant-$qty_a_stringind_ratio;
		
        $sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".str_replace("a_","",$size[$j])."\",".($qty_act).",9,\"$module-".$doc_nos."\")";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));

        $update_qry = "update  $bai_pro3.recut_v2 set $a_string=$finalquantity,$p_string=$finalquantity where doc_no = $doc_nos";
        mysqli_query($link, $update_qry) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));

        $update_qry_plan = "update  $bai_pro3.plandoc_stat_log set $a_string=$qty_ind_ratio,$p_string=$qty_ind_ratio where doc_no = $doc_nos";
        mysqli_query($link, $update_qry_plan) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        
		//update recut_v2 details
		$updatev2="update bai_pro3.recut_v2 set date='".date("Y-m-d")."',pcutno='$newcut_no',acutno='$newcut_no',fabric_status='98',$a_string=$qty_ind_ratio,$p_string=$qty_ind_ratio where doc_no='$last_doc_no'";
        mysqli_query($link, $updatev2) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $sql_size="select 'a_'.$size[$j] as size from bai_pro3.recut_v2 where doc_no = $last_doc_no";
		$sql_size_res = $link->query($sql_size);
		while($rows =$sql_res_fin->fetch_assoc()) 
		{
            $size=$rows['size'];
                $qry_bundle_number= "SELECT * FROM `bai_pro3`.`recut_v2_child` WHERE doc_no = '$doc_nos' ";
                $result_qry_bundle_number = $link->query($qry_bundle_number);
                while($row = $result_qry_bundle_number->fetch_assoc()) 
                {
                    $bundle_no=$row['bcd_id'];
                    $operation_id=$row['operation_id'];

                }
                    if($size != '0')
                {        
                    $sql_recut_child="INSERT INTO `bai_pro3`.`recut_v2_child` (`parent_id`, `size_id`, `bcd_id`, `operation_id`, `rejected_qty`, `recut_qty`, `recut_reported_qty`, `issued_qty`) 
                    VALUES ('$last_doc_no', '$size[$j]', '$bundle_no', '$operation_id', '$qty_a_stringind_ratio', '$qty_a_stringind_ratio', '0', '0')";
                    mysqli_query($link, $sql_recut_child) or exit("Sql Error".mysqli_error($sql_recut_child));
                    var_dump($sql_recut_child);
                    echo "<script>sweetAlert('Quantity inserted Successfully','','success');</script>";

                    // $sql_recut_child_issue_track="INSERT INTO `bai_pro3`.`recut_v2_child_issue_track` (`recut_id`, `bcd_id`, `issued_qty`, `status`) VALUES ('.$last_doc_no.', '.$bundle_no.', '.$finalquantity.', '12')";
                    // mysqli_query($link, $sql_recut_child_issue_track) or exit("Sql Error".mysqli_error($sql_recut_child_issue_track));

                }


            }
        
        // $getquantity="select  $a_string as quantity,$p_string from bai_pro3.plandoc_stat_log where doc_no = $doc_nos";
		// $sql_result_fin = $link->query($getquantity);
		// while($rows_quant =$sql_result_fin->fetch_assoc()) 
		// {
		// 	$quant_plan=$rows_quant['quantity'];
		// }
		// $finalquantity=$quant_plan-$qty_a_stringind_ratio;
		
        // $update_qry_plandoc = "update  $bai_pro3.plandoc_stat_log set $a_string=$finalquantity,$p_string=$finalquantity where doc_no = $doc_nos";
        // mysqli_query($link, $update_qry_plandoc) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));

		// //update recut_v2 details
		// $updateplan="update bai_pro3.plandoc_stat_log set date='".date("Y-m-d")."',pcutno='$newcut_no',acutno='$newcut_no',fabric_status='98',$a_string=$qty_ind_ratio,$p_string=$qty_ind_ratio where doc_no='$last_doc_no'";
        // mysqli_query($link, $updateplan) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));


    }
    $i=1;
    $sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $url = '?r='.$_GET['r'];
    echo "<script>sweetAlert('Successfully Markers updated','','success');window.location = '".$url."'</script>";
}
if(isset($_POST['formIssue']))
{
    $issueval = $_POST['issueval'];
    $bcd_id = $_POST['bcd_id'];
    $doc_no_ref = $_POST['doc_no_ref'];
    $get_recut_status="select max(status) as recut_status from $bai_pro3.recut_v2_child_issue_track where recut_id=".$doc_no_ref."";
    $get_recut_result=mysqli_query($link, $get_recut_status)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($recut_row = mysqli_fetch_array($get_recut_result))
    {
        if($recut_row['recut_status']!='')
        {
            $issue_status=$recut_row['recut_status']+1;
        }
        else
        {
            $issue_status=1;
        }       
    }
    foreach($issueval as $key=>$value)
    {
        //retreaving remaining_qty from recut_v2_child
        $act_id = $bcd_id[$key];
        $recut_allowing_qty = $issueval[$key];
        $retreaving_bcd_data = "SELECT * FROM `$brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";
        $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
        while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
        {
            $bcd_individual = $row_bcd['bundle_number'];
            $bundle_number = $row_bcd['id'];
            $operation_id = $row_bcd['operation_id'];
            $retreaving_rej_qty = "SELECT * FROM `$bai_pro3`.`recut_v2_child` where bcd_id = $bundle_number and parent_id = '$doc_no_ref'";
            // echo $retreaving_rej_qty;
            $retreaving_rej_qty_res = $link->query($retreaving_rej_qty);
            while($child_details = $retreaving_rej_qty_res->fetch_assoc()) 
            {
                $actual_allowing_to_recut = $child_details['recut_reported_qty']-$child_details['issued_qty'];
            }
            if($actual_allowing_to_recut < $recut_allowing_qty)
            {
                $to_add = $actual_allowing_to_recut;
                $recut_allowing_qty = $recut_allowing_qty - $actual_allowing_to_recut;
            }
            else
            {
                $to_add = $recut_allowing_qty;
                $recut_allowing_qty = 0;
            }
            
            if($to_add > 0)
            {
                //updating recut_v2_child
                $update_recut_v2_child = "update $bai_pro3.recut_v2_child set issued_qty = issued_qty+$to_add where bcd_id = $bundle_number and parent_id = $doc_no_ref";
               mysqli_query($link, $update_recut_v2_child) or exit("update_recut_v2_child".mysqli_error($GLOBALS["___mysqli_ston"]));

              $insert_query_track= "INSERT INTO $bai_pro3.`recut_v2_child_issue_track` (`recut_id`, `bcd_id`, `issued_qty`, `status`) VALUES ( $doc_no_ref, $bundle_number, $to_add, $issue_status)"; 
              mysqli_query($link, $insert_query_track) or exit("Inserting_recut_v2_issue_track_table_track".mysqli_error($GLOBALS["___mysqli_ston"]));
               
               //updating rejection_log_child
                $updating_rejection_log_child = "update $bai_pro3.rejection_log_child set issued_qty=issued_qty+$to_add where bcd_id = $bundle_number";
               mysqli_query($link, $updating_rejection_log_child) or exit("updating_rejection_log_child".mysqli_error($GLOBALS["___mysqli_ston"]));
                $issued_to_module = issued_to_module($bundle_number,$to_add,2);

            }
        }
    }
    $url = '?r='.$_GET['r'];
    echo "<script>sweetAlert('Successfully Issued','','success');window.location = '".$url."'</script>";
}
function issued_to_module($bcd_id,$qty,$ref)
{
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $bcd_colum_ref = "replace_in";
    if($ref == 2)
    {
        $bcd_colum_ref = "recut_in";
    }
    $bcd_qry = "select style,mapped_color,docket_number,assigned_module,input_job_no_random_ref,operation_id,bundle_number,size_id from $brandix_bts.bundle_creation_data where id = $bcd_id";
    // echo $bcd_qry;
    $result_bcd_qry = $link->query($bcd_qry);
    while($row = $result_bcd_qry->fetch_assoc()) 
    {
        $style = $row['style'];
        $mapped_color = $row['mapped_color'];
        $docket_no = $row['docket_number'];
        $input_job_no_random_ref = $row['input_job_no_random_ref'];
        $ops_code = $row['operation_id'];
        $bundle_number = $row['bundle_number'];
        $size_id = $row['size_id'];
    }
    //updating cps log and bts
    $update_qry_cps = "update $bai_pro3.cps_log set remaining_qty = remaining_qty+$qty where doc_no = $docket_no and operation_code = 15 and size_code ='$size_id'";
    // echo $update_qry_cps.'</br>';
    mysqli_query($link, $update_qry_cps) or exit("update_qry_cps".mysqli_error($GLOBALS["___mysqli_ston"]));
    $update_qry_bcd = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref=$bcd_colum_ref+$qty where docket_number = $docket_no and size_id = '$size_id' and operation_id = 15";
     mysqli_query($link, $update_qry_bcd) or exit("update_qry_bcd".mysqli_error($GLOBALS["___mysqli_ston"]));
     //validate parellel operations for updating recut_in
     $qry_prellel_ops="select COUNT(*) as cnt from $brandix_bts.tbl_style_ops_master where style='$style' and color='$mapped_color' and ops_dependency>0";
     $result_qry_prellel_ops = $link->query($qry_prellel_ops);
    while($row_ops = $result_qry_prellel_ops->fetch_assoc()) 
    {
       $parellel_ops_cnt = $row_ops['cnt'];
    }

    if($parellel_ops_cnt>0){
        
        //retreaving emblishment operations from operatoin master
        $ops_master_qry = "select operation_code from $brandix_bts.tbl_orders_ops_ref where category in ('Send PF')";
    }else{

        //retreaving emblishment operations from operatoin master
        $ops_master_qry = "select MIN(operation_code) as operation_code from $brandix_bts.tbl_orders_ops_ref where category in ('Send PF')"; 
    }
    $result_ops_master_qry = $link->query($ops_master_qry);
    while($row_ops = $result_ops_master_qry->fetch_assoc()) 
    {
       $emb_ops[] = $row_ops['operation_code'];
    }
    $qry_ops_mapping = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color='$mapped_color' and  operation_code in (".implode(',',$emb_ops).")";
    // echo $qry_ops_mapping;
    $result_qry_ops_mapping = $link->query($qry_ops_mapping);
    if(mysqli_num_rows($result_qry_ops_mapping) > 0)
    {
        while($row_emb = $result_qry_ops_mapping->fetch_assoc()) 
        {
            $emb_input_ops_code = $row_emb['operation_code'];

            //updating bcd for emblishment in operation 
            $update_bcd_for_emb_qry = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref = $bcd_colum_ref + $qty where docket_number = $docket_no and operation_id = $emb_input_ops_code and size_id = '$size_id'";
            // echo $update_bcd_for_emb_qry;
            mysqli_query($link, $update_bcd_for_emb_qry) or exit("update_bcd_for_emb_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

            //updating embellishment_plan_dashboard
            $update_plan_dashboard_qry = "UPDATE `$bai_pro3`.`embellishment_plan_dashboard` SET orginal_qty = orginal_qty+$qty WHERE doc_no = $docket_no AND send_op_code = $emb_input_ops_code";
            // echo $update_plan_dashboard_qry;
            mysqli_query($link, $update_plan_dashboard_qry) or exit("update_plan_dashboard_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    // else
    // {
        $emb_cut_check_flag = 0;
        //checking the ips having that input job or not
        $category=['cutting','Send PF','Receive PF'];
        $checking_qry = "SELECT category FROM `$brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $ops_code";
        // echo $checking_qry;
        $result_checking_qry = $link->query($checking_qry);
        while($row_cat = $result_checking_qry->fetch_assoc()) 
        {
            $category_act = $row_cat['category'];
        }
        if(in_array($category_act,$category))
        {
            $emb_cut_check_flag = 1;
        }
        if($emb_cut_check_flag == 0)
        {
            $checking_qry_plan_dashboard = "SELECT * FROM `$bai_pro3`.`plan_dashboard_input` WHERE input_job_no_random_ref = '$input_job_no_random_ref'";
            $result_checking_qry_plan_dashboard = $link->query($checking_qry_plan_dashboard);
            if(mysqli_num_rows($result_checking_qry_plan_dashboard) == 0)
            {   
                $insert_qry_ips = "INSERT IGNORE INTO `$bai_pro3`.`plan_dashboard_input` 
                SELECT * FROM `$bai_pro3`.`plan_dashboard_input_backup`
                WHERE input_job_no_random_ref = '$input_job_no_random_ref'";
                mysqli_query($link, $insert_qry_ips) or exit("insert_qry_ips".mysqli_error($GLOBALS["___mysqli_ston"]));
            }            
            $qry_ops_mapping_after = "SELECT of.operation_code FROM `$brandix_bts`.`tbl_style_ops_master` tm 
            LEFT JOIN brandix_bts.`tbl_orders_ops_ref` of ON of.`operation_code`=tm.`operation_code`
            WHERE tm.`style` ='$style' AND tm.`color` = '$mapped_color'
            AND category = 'sewing' AND display_operations='yes' and of.operation_code>1 ORDER BY operation_order*1 LIMIT 1";
            $result_qry_ops_mapping_after = $link->query($qry_ops_mapping_after);
            if(mysqli_num_rows($result_qry_ops_mapping_after) > 0)
            {
                while($ops_post = $result_qry_ops_mapping_after->fetch_assoc()) 
                {
                    $input_ops_code = $ops_post['operation_code'];
                }
            }
            else
            {
                $input_ops_code=echo_title("$brandix_bts.tbl_ims_ops","operation_code","appilication",'IPS',$link);  
            }    
            $update_qry_bcd_input = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref=$bcd_colum_ref+$qty where bundle_number = $bundle_number and operation_id = $input_ops_code";
            mysqli_query($link, $update_qry_bcd_input) or exit("update_qry_bcd".mysqli_error($GLOBALS["___mysqli_ston"]));            
        }   
    return;
}
$shifts_array = ["IssueToModule","AlreadyIssued","WaitingForApproval","UpdateMarkers","ReportPending"];
$drp_down = '<div class="row"><div class="col-md-3"><label>Status Filter:</label>
<select class="form-control rm"  name="status" id="rm" style="width:100%;" onchange="myFunction()" required>';
for ($i=0; $i <= 4; $i++) 
{
    $drp_down .= '<option value='.$shifts_array[$i].'>'.$shifts_array[$i].'</option>';
}
$drp_down .= "</select></div>";
$drp_down = "<div class='row'><div class='col-md-3'><label>Schedule Filter:</label>
              <input class='form-control integer' placeholder='Enter Schedule here' onchange='myfunctionsearch()' id='schedule_id'></input></div></div>";
echo $drp_down;
?>
</br></br>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">Recut Detailed View
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body" id='main-content'>
                <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Markers Update Form
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform" onsubmit='return validationfunction();'>
                    <div id='pre'>
                        <div class='panel-body' id="dynamic_table_panel">
                            <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                            </div>	
                                <div id ="dynamic_table1"></div>
                        </div>
                        <p style='color:red;'>Note:The excess quantity will create as excess sewing job for respective style,schedule and color.</p>
                        <div class="pull-right"><input type="submit" id='markers' class="btn btn-primary" value="Submit" name="formSubmit"></div>
                    </div>
                </form>
                <div id='post'>
                        <div class='panel-body'>	
                             <b style='color:red'>Please wait while Updating Markers!!!</b>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Issuing to Module Form
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform" onsubmit='return validationfunctionissue();'>
                    <div id='pre_pre'>
                        <div class='panel-body' id="dynamic_table_panel">
                            <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                            </div>	
                                <div id ="dynamic_table2"></div>
                        </div>
                        <div class="pull-right"><input type="submit" class="btn btn-primary" value="Submit" name="formIssue"></div>
                    </div>
                    <div id='post_post'>
                        <div class='panel-body'>	
                             <b style='color:red'>Please wait while Issuing To Module!!!</b>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>ReCut Dashboard</b>
        </div>
        <div class='panel-body'>
           <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Recut Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Category</th><th>Rejected quantity</th><th>Recut Raised Quantity</th><th>Recut Reported Quantity</th><th>Issued Quantity</th><th>Remaining Quantity</th><th>View</th><th>Issue</th>
            </thead>
            <?php  
            $s_no = 1;
            // $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`order_style_no` AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,fabric_status
            // FROM `$bai_pro3`.`recut_v2_child` rc 
            // LEFT JOIN $bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            // LEFT JOIN $bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            // WHERE remarks in ($in_categories)
            // GROUP BY parent_id having (recut_qty-issued_qty)>0";
            $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`order_style_no` AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,fabric_status,remarks as category
            FROM `$bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN $bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            LEFT JOIN $bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            GROUP BY parent_id having (recut_qty-issued_qty)>0";
            // echo $blocks_query;
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');
            if($blocks_result->num_rows > 0)
            {
                while($row = mysqli_fetch_array($blocks_result))
                {
                    $id = $row['doc_no'];
                    //chekcing this docket planned or not
                    $dock_checking_flag = 0;
                    $checking_docket_planned_qry = "SELECT * FROM `$bai_pro3`.`cutting_table_plan` WHERE doc_no = $id";
                    $result_checking_docket_planned_qry = $link->query($checking_docket_planned_qry);
                    if($result_checking_docket_planned_qry->num_rows > 0)
                    {
                        $dock_checking_flag = 1;
                    }
                    $rem_qty = $row['recut_reported_qty'] - $row['issued_qty'];

                    if($row['fabric_status'] == '98' && $row['mk_ref'] == '0')
                    {
                        $button_html = "<button type='button' style='border-color: #f4d142;border-width: 4px;' class='btn btn-danger' onclick='editmarkers(".$id.")'>Markers Rejected</button>";
                        $html_hiding = "MarkersRejected";
                    }
                    else if($row['mk_ref'] == '0')
                    {
                        $button_html = "<button type='button'class='btn btn-danger' onclick='editmarkers(".$id.")'>Update Markers</button>";
                        $html_hiding = "UpdateMarkers";
                    }
                    else if($row['fabric_status'] == '0')
                    {
                        $button_html = "Markers updated and Waiting for Approval";
                        $html_hiding = "WaitingForApproval";
                    }
                    else if($row['fabric_status'] == '99' && $dock_checking_flag == 0)
                    {
                        $button_html = "<b style='color:blue;'>Approved and Planning Pending!!!</b>";
                        $html_hiding = "Planning Pending";
                    }
                    else if($row['recut_reported_qty'] <= 0)
                    {
                        $button_html = "<b style='color:red;'>Report Pending!!!</b>";
                        $html_hiding = "ReportPending";
                    }
                    else if($rem_qty == 0)
                    {
                        $button_html = "<b style='color:red;'>Already issued</b>";
                        $html_hiding = "AlreadyIssued";
                    }
                    else
                    {
                        $button_html = "<button type='button'class='btn btn-danger' onclick='issuemodule(".$id.")'>Issue To Module</button>";
                      
						$html_hiding = "IssueToModule";
                    }
					if($html_hiding == "ReportPending")
					{
						if(strtolower($row['category'])=='body' or strtolower($row['front']))
						{
							echo "<tr><td>$s_no</td>";
							echo "<td>".$row['doc_no']."</td>";
							echo "<td>".$row['style']."</td>";
							echo "<td>".$row['schedule']."</td>";
							echo "<td>".$row['color']."</td>";
							echo "<td>".$row['category']."</td>";
							echo "<td>".$row['rejected_qty']."</td>";
							echo "<td>".$row['recut_qty']."</td>";
							echo "<td>".$row['recut_reported_qty']."</td>";
							echo "<td>".$row['issued_qty']."</td>";
							echo "<td>".$rem_qty."</td>";
							echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
							echo "<td style='display:none'>$html_hiding</td>"; 
							echo "<td>$button_html</td>"; 
							echo "</tr>";
							$s_no++;
						}
					}
					else
					{
						echo "<tr><td>$s_no</td>";
						echo "<td>".$row['doc_no']."</td>";
						echo "<td>".$row['style']."</td>";
						echo "<td>".$row['schedule']."</td>";
						echo "<td>".$row['color']."</td>";
						echo "<td>".$row['category']."</td>";
						echo "<td>".$row['rejected_qty']."</td>";
						echo "<td>".$row['recut_qty']."</td>";
						echo "<td>".$row['recut_reported_qty']."</td>";
						echo "<td>".$row['issued_qty']."</td>";
						echo "<td>".$rem_qty."</td>";
						echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
						echo "<td style='display:none'>$html_hiding</td>"; 
						echo "<td>$button_html</td>"; 
						echo "</tr>";
						$s_no++;
					}
                }
            }
            else
            {
                echo "<tr><td colspan='12' style='color:red;text-align: center;'><b>No Details Found!!!</b></td></tr>";
            }
            ?>
             </table>
             <div id='myTable1'>
                <b style='color:red'>No Records Found</b>
             </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() 
{
    $('#myTable1').hide();
    $('#post').hide();
    $('#post_post').hide();
    // myFunction();
});
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('.loading-image').show();
    $('#myModal').modal('toggle');
    $.ajax({

			type: "POST",
			url: function_text+"?recut_doc_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('main-content').innerHTML = response;
                $('.loading-image').hide();
            }

    });

}
function editmarkers(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal1').modal('toggle');
    $('.loading-image').show();
    document.getElementById('dynamic_table1').innerHTML = '';
    document.getElementById('dynamic_table2').innerHTML = '';
    $.ajax({

			type: "POST",
			url: function_text+"?markers_update_doc_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
                $('.loading-image').hide();
            }

    });

}
function issuemodule(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal2').modal('toggle');
    $('#pre_pre').show();
    $('#post_post').hide();
    $('.loading-image').show();
    document.getElementById('dynamic_table1').innerHTML = '';
    document.getElementById('dynamic_table2').innerHTML = '';
    $.ajax({

			type: "POST",
			url: function_text+"?issued_to_module_process="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table2').innerHTML = response;
                $('.loading-image').hide();

            }

    });
}
function validatingremaining(sno)
{
    var remaining_qty_var = sno+"rems";
    var rem_qty = Number(document.getElementById(remaining_qty_var).innerHTML);
    var issuing_qty = Number(document.getElementById(sno).value);
    if(Number(rem_qty) < Number(issuing_qty))
    {
        swal('You are Issuing More than remaining quantity.','','error');
        document.getElementById(sno).value = 0;
    }
}
function myFunction() 
{
    var input, filter, table, tr, td, i;
    input = document.getElementById("rm").value;
    filter = input.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var count = 0;
    if(tr.length > 1)
    {
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[11];
            if(td) 
            {
                if(td.innerHTML.toUpperCase() == filter)
                {
                    tr[i].style.display = "";
                } 
                else 
                {
                    count++;
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // if(count == 1)
    // {
    //     $('#myTable').hide();
    //     $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
    //     $('#myTable1').hide();
    // }
}
function isintegervalidation() 
{
    var data = document.getElementById('a_plies').value;
    if(isInteger(data))
    {

    }
    else
    {  
        document.getElementById('a_plies').value = 0;
    }
}
function isInteger(value) 
{
    if ((undefined === value) || (null === value))
    {
        return false;
    }
    return value % 1 == 0;
}
function isintegervallidation(id)
{
    var data = document.getElementById(id).value;
    if(isInteger(data))
    {

    }
    else
    {  
        document.getElementById(id).value = 0;
    }
}
function validationfunction()
{
    var flag = 0;
    var value = 0;
	var check= 0;
    var mklen = document.getElementById('mklen').value;
    var a_plies =  document.getElementById('a_plies').value;
    var total_rows = document.getElementById('no_of_rows').value;
    if(mklen == '' || mklen == 0)
    {
        swal('Please enter marker length.','','error');
        flag = 1;
    }
    else if(a_plies == '' || a_plies == 0)
    {
        swal('Please enter actual plies.','','error');
        flag = 1;
    }
    else
    {
        for(var i=1; i<=total_rows;i++)
        {
            value = value + Number(document.getElementById(i).value);
			if((Number(document.getElementById(i).value)*a_plies)>Number(document.getElementById('dat_'+i).value))
			{
				check = 1;
			}
        }
        if(value == 0)
        {
            swal('Atlease one ratio should be there.','','error');
            flag = 1;
        }
		if(check == 1)
        {
            swal('(Ratio * Plies) should be equal or more than requested Quantity per size.','','error');
            flag = 1;
        }
    }
    if(flag == 0)
    {
        $('#markers').hide();
        $('#pre').hide();
        $('#post').show();
        return true;
	}
	else
	{
		return false;
	}
}
function isInteger(value) 
{
    if ((undefined === value) || (null === value))
    {
        return false;
    }
    return value % 1 == 0;
}
function setfunction()
{
    var noofrows = $('#no_of_rows').val();
    if(document.getElementById('setreset').value == 'Set')
    {
        for(var i=1; i<=Number(noofrows); i++)
        {
            var rem_var = i+'rems';
            console.log(rem_var);
            var remaining_qty = document.getElementById(rem_var).innerHTML;
            document.getElementById(i).value = remaining_qty; 
        }
    }
}
function resetfunction()
{
    var noofrows = $('#no_of_rows').val();
    for(var i=1; i<=Number(noofrows); i++)
    {
        document.getElementById(i).value = 0; 
    }
}
function validationfunctionissue()
{
    var flag = 0;
    var value = 0;
    var total_rows = document.getElementById('no_of_rows').value;
    for(var i=1; i<=total_rows;i++)
    {
        value = value + Number(document.getElementById(i).value);
    }
    if(value == 0)
    {
        swal('Atlease one size quantity should be there.','','error');
        flag = 1;
    }
    if(flag == 0)
    {
        $('#pre_pre').hide();
        $('#post_post').show();
        return true;
    }
    else
    {
        return false;
    }
}
function focus_validate(id)
{
    var data = document.getElementById(id).value;
    if(data == 0)
    {
        document.getElementById(id).value = '';
    }
}
function focus_out_validation(id)
{
    var data = document.getElementById(id).value;
    if(data == '')
    {
        document.getElementById(id).value = 0;
    }
}
function myfunctionsearch() 
{
    var input, filter, table, tr, td, i;
    input = document.getElementById("schedule_id").value;
    filter = input.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var count = 0;
    if(tr.length > 1)
    {
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[3];
            if(td) 
            {
                console.log("input"+input);
                console.log(td.innerHTML.toUpperCase());
                console.log(filter);
                if(td.innerHTML.toUpperCase() == filter)
                {
                    console.log(tr[i]);
                    tr[i].style.display = "";
                } 
                else if(input != '')
                {
                    count++;
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // console.log(count);
    // if(count == 0)
    // {
    //     $('#myTable').hide();
    //     $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
    //     $('#myTable1').hide();
    // }
}
function isInt(t)
{
    if(Number(t.value) < 0 || t.value =='e' || t.value == 'E' || t.value == null)
    { 
        t.value = 0;
        return false;
    }
}
</script>
