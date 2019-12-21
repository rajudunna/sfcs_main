<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/bundle_filling.php');
include('cut_rejections_save.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/app/cutting/controllers/cut_reporting_without_rolls/emb_reporting.php');
//include('emb_reporting.php');
error_reporting(0);
$LEFT_THRESHOLD = 10000;
$THRESHOLD = 200; //This Constant ensures the loop to force quit if it was struck in an infinte loop
$LEFT = 0;
 

$rollwisedata=$_POST['data'];
$doc_no=$_POST['doc_no'];
$style   = $_POST['style'];
$schedule= $_POST['schedule'];
$color   = $_POST['color'];
$rollwisestatus   = $_POST['rollwisestatus'];
$emb_check_in_roll=0;
$ids=0;
$num=1;
$response_data = array();
$data = $_POST;

$op_code = 15;
$target = $data['doc_target_type'];
$doc_no = $data['doc_no'];
$plies  = $data['c_plies'];
$f_ret  = $data['fab_returned'];
$f_rec  = $data['fab_received'];
$shift  = $data['shift'];
$cut_table = $data['cut_table'];
$team_leader = $data['team_leader'];
$bundle_location = $data['bundle_location'];
$returned_to = $data['returned_to'];
$damages = $data['damages'];
$joints_endbits = $data['joints_endbits'];
$shortages = $data['shortages'];
$style   = $data['style'];
$schedule= $data['schedule'];
$color   = $data['color'];
$date      = date('Y-m-d');
$date_time = date('Y-m-d H:i:s'); 
$rejections_flag = $data['rejections_flag'];
$rejection_details = $data['rejections'];
$full_reporting_flag = $data['full_reporting_flag'];
// for schedule clubbing we are grabbing all colors and picking one randomly
$colors = explode(',',$color);
$color = $colors[0];
//for schedule clubbing we are grabbing all schedules
$schedules = explode(',',$schedule);
$schedule = $schedules[0];

if($rollwisedata)
{
    foreach($rollwisedata as $value)
    { 
        $laysequence=$value[1]?$value[1]:0;
        $exec ="INSERT INTO $bai_pro3.`docket_roll_info` (style,schedule,color,docket,lay_sequence,roll_no,shade,width,fabric_rec_qty,reporting_plies,damages,joints,endbits,shortages,fabric_return)
        VALUES ('".$style."','".$schedule."','".$color."',".$doc_no.",".$laysequence.",'".$value[2]."','".$value[3]."','".$value[4]."','".$value[5]."','".$value[6]."','".$value[7]."','".$value[8]."','".$value[9]."','".$value[10]."','".$value[11]."')";
        $result= mysqli_query($link,$exec);
		
		$exec1 ="INSERT INTO $bai_pro3.`docket_roll_alloc` (docket,lay_seq,roll_no,shade,width,fabric_recv_qty,plies,damages,joints,endbits,shortages,fabric_return,tran_user,status,color)
		VALUES (".$doc_no.",".$laysequence.",'".$value[2]."','".$value[3]."','".$value[4]."','".$value[5]."','".$value[6]."','".$value[7]."','".$value[8]."','".$value[9]."','".$value[10]."','".$value[11]."','".$username."',0,'".$color."')";
		mysqli_query($link,$exec1);
		
    }
	
	if($result)
    {
		$sql1="select * from $bai_pro3.`bai_orders_db_confirm` where orde_del_no=".$schedule."";
		$resut_1= mysqli_query($link,$sql1);
		while($rows1 = mysqli_fetch_array($resut_1))
		{
			$order_tid = $rows1['order_tid'];			
			for($ss=0;$ss<sizeof($sizes_array);$ss++)
			{
			   if($rows1["title_size_".$sizes_array[$ss].""]<>'')
			   {
					$o_s[$sizes_array[$ss]]=$rows1["title_size_".$sizes_array[$ss].""];                     
			   }
			}
		}
	    $docketexisted="SELECT * from $bai_pro3.docket_number_info where doc_no=".$doc_no."";
        $docketexistedresult=mysqli_query($link,$docketexisted);
        if($docketexistedresult)
        {
            $scheduleddata="select doc_no from $bai_pro3.`plandoc_stat_log` where order_tid='".$order_tid."'";
            $scheduleddataresult= mysqli_query($link,$scheduleddata);
            if(mysqli_num_rows($scheduleddataresult) > 0)
            {
                while($dockts = mysqli_fetch_array($scheduleddataresult))
                {
                    $scheduledockets[] = $dockts['doc_no'];
                }
            }
            $docketnumberexisted="SELECT max(bundle_end) as bundle_end,max(bundle_no) as bundle_no from $bai_pro3.docket_number_info where doc_no IN (".implode(",",$scheduledockets).")";
            $docketnumberexistedresult=mysqli_query($link,$docketnumberexisted);
            $docketno = mysqli_fetch_array($docketnumberexistedresult);
            if(mysqli_num_rows($docketnumberexistedresult) > 0)
            {
                $padded = $docketno['bundle_end']+1;
                $bundle=$docketno['bundle_no']+1;
            }
            
        }
        else
        {
           
			$scheduleddata="select doc_no from $bai_pro3.`plandoc_Stat_log` where order_tid='".$order_tid."'";
            $scheduleddataresult= mysqli_query($link,$scheduleddata);
            if(mysqli_num_rows($scheduleddataresult) > 0)
            {
                while($dockts = mysqli_fetch_array($scheduleddataresult))
                {
                    $scheduledockets[] = $dockts['doc_no'];
                }
            }
            $docketnumberexisted="SELECT max(bundle_end) as bundle_end from $bai_pro3.docket_number_info where doc_no IN (".implode(",",$scheduledockets).")";
            $docketnumberexistedresult=mysqli_query($link,$docketnumberexisted);
            $docketno = mysqli_fetch_array($docketnumberexistedresult);
            if(mysqli_num_rows($docketnumberexistedresult) > 0)
            {
                $padded = $docketno['bundle_end']+1;
            }
            else
            {            
                $padded = 1;
                $bundle = 1;
            }
        }
		
		$size_query = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no=$doc_no";
        $size_result = mysqli_query($link, $size_query) or exit("error while getting details for child doc nos");
        while($sql_row=mysqli_fetch_array($size_result))
        {
            $order_tid = $sql_row['order_tid'];
            $org_status = $sql_row['org_doc_no'];
            for($s=0;$s<sizeof($sizes_array);$s++)
            {
                $planned_s[$sizes_code[$s]]=$sql_row["p_".$sizes_array[$s].""];
            }				
        }
		
		/* Emb Bundles */
		
		$emb=0;$club=0;
		if($barcode_gen_emb=='yes')
		{
			if($org_status==1)
			{
				$club=1;
			}
			else
			{
				$club=0;
			}
			
			$sql_check="SELECT tsm.operation_code AS operation_code,tsm.previous_operation AS previous_operation,tsm.ops_dependency AS ops_dependency FROM brandix_bts.tbl_style_ops_master tsm 
			LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE 
			style='$style' AND color='$color' AND tor.category IN ('Send PF','Receive PF') ORDER BY tsm.`operation_order`*1";
			$result_check=mysqli_query($link,$sql_check) or exit('verifying the codes');
			if(mysqli_num_rows($result_check)>0)
			{
				while($rows = mysqli_fetch_array($result_check))
				{
					$ops_codes[] = $rows['operation_code'];
					$next_ops[] = $rows['ops_dependency'];
					$prev_ops[] = $rows['previous_operation'];
				}
				$emb_check_in_roll=1;
				$sql_check_id="SELECT max(tran_id)+1 as barcode,max(report_seq)+1 as seqid from $bai_pro3.emb_bundles where doc_no=$doc_no";
				$result_check_id=mysqli_query($link,$sql_check_id) or exit('verifying the codes');
				while($row12_id = mysqli_fetch_array($result_check_id))
				{
					if($row12_id['barcode']==0 || $row12_id['barcode']=='')
					{
						$ids=1;
						$seqids=1;
					}
					else
					{
						$ids=$row12_id['barcode'];
						$seqids=$row12_id['seqid'];
					}			
				}

			}
		}
		

        for($jj=0;$jj<sizeof($planned_s);$jj++)
        {
            $ratios_list[$o_s[$sizes_array[$jj]]]= $planned_s[$sizes_code[$jj]];           
        }	

        $docket_query="SELECT *,sum(reporting_plies) as totalplies,group_concat(id) as ids FROM $bai_pro3.`docket_roll_info` where docket=".$doc_no." and status=0 group by shade,lay_sequence order by lay_sequence asc";
        $docket_queryresult = mysqli_query($link,$docket_query);
        if(mysqli_num_rows($docket_queryresult) > 0)
        {
            while($row = mysqli_fetch_array($docket_queryresult))
            {
                $docket_info[] = $row;
				$udpate ="UPDATE $bai_pro3.`docket_roll_info` set status=1 where id in (".$row['ids'].")";
				mysqli_query($link,$udpate);
            }
            $sizeofrolls=count($docket_info);
            $shadebundleno=0;
            foreach($ratios_list as $key=>$value)// no.of. ratios
            {            
                for($i=0;$i<$value;$i++)// value of each ratio
                {   
                    for($k=0;$k<$sizeofrolls;$k++)
                    {
                        $shadebundleno++;
                        
						if($padded==1)
						{
							$startno=$padded;
							$padded=$docket_info[$k]['totalplies'];
						}
						else
						{
							$startno=$padded+1;
							$padded+=$docket_info[$k]['totalplies'];	
						}					
                        
                        $docketrolinfo ="INSERT INTO $bai_pro3.`docket_number_info` (doc_no,size,bundle_no,shade_bundle,shade,bundle_start,bundle_end,qty)
                        VALUES (".$doc_no.",'".$key."',".$bundle.",'".$bundle."-".$shadebundleno."','".$docket_info[$k]['shade']."',".$startno.",".$padded.",".$docket_info[$k]['totalplies'].")";
                        $result= mysqli_query($link,$docketrolinfo);
						$id=mysqli_insert_id($link);
						if($emb_check_in_roll==1 && $barcode_gen_emb=='yes')
						{													
							// inserting bundels
							for($jj=0;$jj<sizeof($ops_codes);$jj++)
							{					
								$sql_insert="INSERT INTO $bai_pro3.`emb_bundles` (`doc_no`, `size`, `ops_code`, `barcode`, `quantity`, `good_qty`, `reject_qty`, `insert_time`, `club_status`, `log_user`, `tran_id`,`report_seq`, shade, num_id) 
								VALUES (".$doc_no.", '".$key."', ".$ops_codes[$jj].", '".$doc_no."-".$ops_codes[$jj]."-".$ids."', ".$docket_info[$k]['totalplies'].", 0, 0, '".date("Y-m-d H:i:s")."', '".$club."', '".$user."', ".$ids.",".$seqids.", '".$docket_info[$k]['shade']."', ".$id." )";
								mysqli_query($link,$sql_insert);
							}
							$ids++;							
						}						
                    }   
                    $bundle++;    
                    $shadebundleno=0;                    
                }
            }         
        }
    }
}
else
{	
	if($plies>0)
	{
		$values=explode("^",$joints_endbits);
	/*	$exec ="INSERT INTO $bai_pro3.`docket_roll_info` (style,schedule,color,docket,lay_sequence,roll_no,shade,width,fabric_rec_qty,reporting_plies,damages,joints,endbits,shortages,fabric_return)
		VALUES ('".$style."','".$schedule."','".$color."',".$doc_no.",1,0,'None',0,'".$f_rec."','".$plies."','".$damages."','".$values[0]."','".$values[1]."','".$shortages."','".$f_ret."')";
		$result= mysqli_query($link,$exec);	
	*/	
		$exec1 ="INSERT INTO $bai_pro3.`docket_roll_alloc` (docket,lay_seq,roll_no,shade,width,fabric_recv_qty,plies,damages,joints,endbits,shortages,fabric_return,tran_user,status,color)
		VALUES (".$doc_no.",1,0,'None',0,'".$f_rec."','".$plies."','".$damages."','".$value[0]."','".$value[1]."','".$shortages."','".$f_ret."','".$username."',0,'".$color."')";
		$result= mysqli_query($link,$exec1);	
	}	
}

$size_update_string = '';
$p_sizes_str   = '';
$a_sizes_str   = '';
$s_p_sizes_str = '';
$s_a_sizes_str = '';
foreach($sizes_array as $size){
    $zero_a_sizes_str .= 'a_'.$size.'=0,';
    $p_sizes_str .= 'p_'.$size.',';
    $a_sizes_str .= 'a_'.$size.',';
    $s_p_sizes_str .= 'p_'.$size.'+';
    $s_a_sizes_str .= 'a_'.$size.'+';
}
$a_sizes_str = rtrim($a_sizes_str,',');
$p_sizes_str = rtrim($p_sizes_str,',');
$s_a_sizes_str = rtrim($s_a_sizes_str,'+');
$s_p_sizes_str = rtrim($s_p_sizes_str,'+');
$cut_remarks = $target;

$before_aS = [];

//Concurrent User Validation
$avl_plies_query = "SELECT p_plies-a_plies as v_plies from $bai_pro3.plandoc_stat_log where doc_no = $doc_no 
                    and act_cut_status = 'DONE' ";
$avl_plies_result = mysqli_query($link,$avl_plies_query);
if(mysqli_num_rows($avl_plies_result) > 0){
    $row = mysqli_fetch_array($avl_plies_result);
    $v_plies = $row['v_plies'];
    if($plies > $v_plies){
        $response_data['concurrent'] = 1;
        echo json_encode($response_data);
        exit(0); 
    }
}
$update_manual_flag ='';
if($full_reporting_flag == 1)
{
    $update_manual_flag = ", manual_flag = 1";
}
//0 plies saving logic 
if($plies == 0 && $full_reporting_flag == 1){
    //Force reporting 0 cut as complete reported
    $all_docs = '';
    $query_check = '';
	$sewl_cwty = "select a_plies from $bai_pro3.plandoc_stat_log where doc_no = $doc_no and act_cut_status='DONE'";
	$insert_result_cechk = mysqli_query($link,$sewl_cwty) or exit('Query Error 0 Cut 1');
	if(mysqli_num_rows($insert_result_cechk)>0)
	{
		$query_check='';
	}
	else
	{
		$query_check='a_plies=0,';
	}

    //inserting to act_cutstatus 
    $remarks = "$date^$cut_table^$shift^$f_rec^$f_ret^$damages^$shortages^$returned_to^$plies";
    $insert_query = "INSERT into $bai_pro3.act_cut_status (doc_no,date,section,shift,fab_received,fab_returned, 
                    damages,shortages,remarks,log_date,bundle_loc,leader_name,joints_endbits) 
                    values ($doc_no,'$date','$cut_table','$shift','$f_rec','$f_ret','$damages','$shortages','$remarks','$date_time','$bundle_location','$team_leader','$joints_endbits')
                    ON DUPLICATE KEY 
                    UPDATE date='$date',section='$cut_table',shift='$shift',fab_received=fab_received + $f_rec,fab_returned='$f_ret',damages='$damages',shortages='$shortages',
                    remarks=CONCAT(remarks,'$','$remarks'),
                    log_date='$date_time',bundle_loc='$bundle_location',leader_name='$team_leader',joints_endbits=CONCAT(joints_endbits,'$','$joints_endbits')";
   // echo $insert_query;
   $update_psl_query = "UPDATE $bai_pro3.plandoc_stat_log set $query_check act_cut_status='DONE' $update_manual_flag
                    where doc_no = $doc_no or org_doc_no = $doc_no";
    $insert_result = mysqli_query($link,$insert_query) or exit('Query Error 0 Cut 1');   
    $update_result = mysqli_query($link,$update_psl_query) or exit('Query Error 0 Cut 2');

    //getting child docs if any
    $child_docs_query = "SELECT group_concat(doc_no) as docs from $bai_pro3.plandoc_stat_log where org_doc_no = $doc_no";
    $child_docs_result = mysqli_query($link,$child_docs_query);
    while($row = mysqli_fetch_array($child_docs_result)){
        $child_docs = $row['docs'];
    }
    if(strlen($child_docs) == 0)
        $all_docs = $doc_no;
    else
        $all_docs = $child_docs;

    $op_codes_str = '';
    $op_codes_query = "SELECT group_concat(operation_code) as op_codes FROM brandix_bts.tbl_orders_ops_ref 
                    WHERE category IN ('Send PF','Receive PF')";
    $op_codes_result = mysqli_query($link,$op_codes_query);
    while($orow = mysqli_fetch_array($op_codes_result)){
        $op_codes = $orow['op_codes'];
    }                
    if(strlen($op_codes) > 0)
        $op_codes_str .= $op_code.','.$op_codes;
    else
        $op_codes_str = $op_code;

    $update_cps_query = "UPDATE $bai_pro3.cps_log set reported_status = 'F' where doc_no IN ($all_docs) and 
                        operation_code IN ($op_codes_str)";
    mysqli_query($link,$update_cps_query);
    $response_data['saved'] = 1;
    $response_data['pass'] = 1;
    echo json_encode($response_data);
    exit();
}

//Other categroy dockets Saving Logic
if(strpos($target,'_other')==true){
    $remarks = "$date^$cut_table^$shift^$f_rec^$f_ret^$damages^$shortages^$returned_to^$plies";
    $insert_query = "INSERT into $bai_pro3.act_cut_status (doc_no,date,section,shift,fab_received,fab_returned,damages,shortages,remarks,log_date,bundle_loc,leader_name,joints_endbits) values ($doc_no,'$date','$cut_table','$shift','$f_rec','$f_ret','$damages','$shortages','$remarks','$date_time','$bundle_location','$team_leader','$joints_endbits') ON DUPLICATE KEY UPDATE date='$date',section='$cut_table',shift='$shift',fab_received=fab_received + $f_rec,fab_returned='$f_ret',damages='$damages',shortages='$shortages', remarks=CONCAT(remarks,'$','$remarks'), log_date='$date_time',bundle_loc='$bundle_location',leader_name='$team_leader',joints_endbits=CONCAT(joints_endbits,'$','$joints_endbits')";

    $update_query = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies = IF(a_plies = p_plies,$plies,a_plies+$plies),
                    act_cut_status='DONE',fabric_status=5 $update_manual_flag where doc_no = $doc_no ";
    $update_query2 = "UPDATE $bai_pro3.plandoc_stat_log SET act_cut_status='DONE',fabric_status=5 $update_manual_flag where org_doc_no = $doc_no ";                
    $insert_result = mysqli_query($link,$insert_query) or force_exit('Query Error Cut 1.0');  
    $update_result = mysqli_query($link,$update_query) or force_exit('Query Error Cut 2.0'); 
    $update_result2 = mysqli_query($link,$update_query2) or force_exit('Query Error Cut 2.1');
    $response_data['saved'] = 1;
    $response_data['pass'] = 1;	
    echo json_encode($response_data);
    exit();
}

//Recut Docket Saving
if($target == 'recut'){
    $rejections_done = [];
    foreach($rejection_details as $size => $reason_wise){
        foreach($reason_wise as $reason => $rqty){
            if($rqty > 0)
                $rejections_done[$size]+= $rqty;
        }
    }

    $ratio_query = "SELECT $a_sizes_str from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
    $ratio_result = mysqli_query($link,$ratio_query);
    while($row = mysqli_fetch_array($ratio_result)){
        foreach($sizes_array as $size)
        {
            if($row['a_'.$size] > 0)
                $ratio[$size] = $row['a_'.$size];
        }
    }
		
    $bcd_data_query = "SELECT id,size_id from $brandix_bts.bundle_creation_data where docket_number=$doc_no 
                and operation_id = $op_code";   
    $bcd_data_result = mysqli_query($link,$bcd_data_query);               
    while($row = mysqli_fetch_array($bcd_data_result)){
        $size = $row['size_id'];
        $bno  = $row['id'];
        $qty  = ($ratio[$size] * $plies) - $rejections_done[$size]; 

        $records_query  = "SELECT id,recut_qty,recut_reported_qty from $bai_pro3.recut_v2_child 
                            where parent_id=$doc_no and size_id = '$size' order by id ASC";
        $records_result = mysqli_query($link,$records_query);
        while($row1 = mysqli_fetch_array($records_result)){
            $recut_qty     = $row1['recut_qty'];
            $reported_qty  = $row1['recut_reported_qty'];
            $id = $row1['id'];
            if($qty > 0){
                if($reported_qty <  $recut_qty){
                    $reporting_qty = $recut_qty - $reported_qty;
                    if($qty > $reporting_qty){
                        $qty -= $reporting_qty;
                        $update_query = " UPDATE $bai_pro3.recut_v2_child 
                            set recut_reported_qty = recut_reported_qty+$reporting_qty 
                            where parent_id=$doc_no and size_id = '$size' and id=$id";
                        $update_result = mysqli_query($link,$update_query);
                    }else{
                        $update_query = " UPDATE $bai_pro3.recut_v2_child 
                            set recut_reported_qty = recut_reported_qty+$qty 
                            where parent_id=$doc_no and size_id = '$size' and id=$id";
                        $update_result = mysqli_query($link,$update_query);
                    }
                }
            }
        }       
    }
   $target = 'normal';
}

//Normal Docket Saving
if($target == 'normal'){

    //inserting to act_cutstatus 
    $remarks = "$date^$cut_table^$shift^$f_rec^$f_ret^$damages^$shortages^$returned_to^$plies";
    // $link2 = mysqli_connect($host, $user, $pass) or force_exit("Could not connect Normal ");
    // mysqli_begin_transaction($link2) or force_exit("Cant Begin Transaction");
    $insert_query = "INSERT into $bai_pro3.act_cut_status (doc_no,date,section,shift,fab_received,fab_returned, damages,shortages,remarks,log_date,bundle_loc,leader_name,joints_endbits) values ($doc_no,'$date','$cut_table','$shift','$f_rec','$f_ret','$damages','$shortages','$remarks','$date_time','$bundle_location','$team_leader','$joints_endbits') ON DUPLICATE KEY UPDATE date='$date',section='$cut_table',shift='$shift',fab_received=fab_received + $f_rec,fab_returned='$f_ret',damages='$damages',shortages='$shortages', remarks=CONCAT(remarks,'$','$remarks'),log_date='$date_time',bundle_loc='$bundle_location',leader_name='$team_leader',joints_endbits=CONCAT(joints_endbits,'$','$joints_endbits')";
    $insert_result = mysqli_query($link,$insert_query);  

	if($barcode_gen_emb=='yes' && $emb_check_in_roll==0)
	{	
		$sql_check="SELECT tsm.operation_code AS operation_code,tsm.previous_operation AS previous_operation,tsm.ops_dependency AS ops_dependency FROM brandix_bts.tbl_style_ops_master tsm 
		LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE 
		style='$style' AND color='$color' AND tor.category IN ('Send PF','Receive PF') ORDER BY tsm.`operation_order`*1";
		$result_check=mysqli_query($link,$sql_check) or exit('verifying the codes');
		if(mysqli_num_rows($result_check)>0)
		{
			while($rows = mysqli_fetch_array($result_check))
			{
				$ops_codes[] = $rows['operation_code'];
				$next_ops[] = $rows['ops_dependency'];
				$prev_ops[] = $rows['previous_operation'];
			}
			$doc_qty_query1 = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
			$doc_qty_result1 = mysqli_query($link,$doc_qty_query1);
			while($row1 = mysqli_fetch_array($doc_qty_result1))
			{
				foreach($sizes_array as $size)
				{
					if($row1['p_'.$size] > 0)
					{
						$doc_qty_query12 = "SELECT title_size_".$size." as size_tit from $bai_pro3.bai_orders_db_confirm where order_tid = '".$row1['order_tid']."'";
						$doc_qty_result12 = mysqli_query($link,$doc_qty_query12);
						while($row12 = mysqli_fetch_array($doc_qty_result12))
						{
							$size_val=$row12['size_tit'];	
						}
						$ratio[$size_val] = $row1['p_'.$size];
						$sizes_tot[]=$size_val;
					}
				}
			}
			$sql_check_id="SELECT max(tran_id)+1 as barcode,max(report_seq)+1 as seqid from $bai_pro3.emb_bundles where doc_no=$doc_no";
			$result_check_id=mysqli_query($link,$sql_check_id) or exit('verifying the codes');
			while($row12_id = mysqli_fetch_array($result_check_id))
			{
				if($row12_id['barcode']==0 || $row12_id['barcode']=='')
				{
					$ids=1;
					$seqids=1;
				}
				else
				{
					$ids=$row12_id['barcode'];
					$seqids=$row12_id['seqid'];
				}			
			}
			for($j=0;$j<sizeof($sizes_tot);$j++)
			{			
				do
				{				
					for($jj=0;$jj<sizeof($ops_codes);$jj++)
					{					
						$sql_insert="INSERT INTO $bai_pro3.`emb_bundles` (`doc_no`, `size`, `ops_code`, `barcode`, `quantity`, `good_qty`, `reject_qty`, `insert_time`, `club_status`, `log_user`, `tran_id`,`report_seq`, `shade`, `num_id`) 
						VALUES (".$doc_no.", '".$sizes_tot[$j]."', ".$ops_codes[$jj].", '".$doc_no."-".$ops_codes[$jj]."-".$ids."', ".$plies.", 0, 0, '".date("Y-m-d H:i:s")."', '0', '".$user."', ".$ids.",".$seqids.",'N/A','0')";
						mysqli_query($link,$sql_insert);
					}
					$ids++;
					$ratio[$sizes_tot[$j]]--;
				}while($ratio[$sizes_tot[$j]]>0);			
			}			
		}
	}
	
    $update_query = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies = IF(a_plies = p_plies,$plies,a_plies+$plies),act_cut_status='DONE',fabric_status=5 $update_manual_flag where doc_no = $doc_no ";
    if($insert_result){
        $update_result = mysqli_query($link,$update_query) or force_exit('Query Error Cut 2.2');
        if($update_result){
            $response_data['saved'] = 1;
            // $stat = mysqli_commit($link2)  or force_exit("Cant Commit Transaction");
            // if($stat == 0){
            //     echo json_encode($response_data);
            //     exit();
            // }
        }else{   
            $response_data['saved'] = 0;
            echo json_encode($response_data);
            //mysqli_rollback($link2); 
            //mysqli_close($link2);   
            exit();
        } 
    }else{
        $response_data['saved'] = 0;
        echo json_encode($response_data);
        //mysqli_close($link2);
        exit();
    }
    //mysqli_close($link2);

    $m3_status  = update_cps_bcd_normal($doc_no,$plies,$style,$schedule,$color,$rejection_details);
   
    if($rejections_flag == 1){
        $rej_status = save_rejections($doc_no,$rejection_details,$style,$schedule,$color,$shift,$cut_remarks);
        $response_data['rejections_response'] = $rej_status;
    } 
    if($m3_status == 'fail'){
        $response_data['pass'] = 0;
        //force_exit('Normal Reporting Failed');
        echo json_encode($response_data);
        exit();
    }else{
		act_logical_bundles($doc_no,$schedule,$style,$color);
        $response_data['pass'] = 1;
        $response_data['m3_updated'] = $m3_status;
        echo json_encode($response_data);
        emblishment_quantities($doc_no,$style,$color);
        exit();
    }
	
}
// $target = 'schedule_club';
// $plies = 50;
// $doc_no = 524879; 
//Schedule Clubbing Docket Saving

if($target == 'schedule_clubbed')
{
    $rejection_details_each = [];
    $quit_counter1 = 0;
    $quit_counter2 = 0;
    $remarks = "$date^$cut_table^$shift^$f_rec^$f_ret^$damages^$shortages^$returned_to^$plies";
    // $link2 = mysqli_connect($host, $user, $pass) or force_exit("Could not connect Schedule Clubbed");
    // mysqli_begin_transaction($link2) or force_exit("Cant Begin Transaction");
    $insert_query = "INSERT into $bai_pro3.act_cut_status (doc_no,date,section,shift,fab_received,fab_returned, 
                    damages,shortages,remarks,log_date,bundle_loc,leader_name,joints_endbits) 
                    values ($doc_no,'$date','$cut_table','$shift','$f_rec','$f_ret','$damages','$shortages','$remarks','$date_time','$bundle_location','$team_leader','$joints_endbits')
                    ON DUPLICATE KEY 
                    UPDATE date='$date',section='$cut_table',shift='$shift',fab_received=fab_received + $f_rec,fab_returned='$f_ret',damages='$damages',shortages='$shortages',
                    remarks=CONCAT(remarks,'$','$remarks'),
                    log_date='$date_time',bundle_loc='$bundle_location',leader_name='$team_leader',joints_endbits=CONCAT(joints_endbits,'$','$joints_endbits')";
    
    $update_query = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies = IF(a_plies = p_plies,$plies,a_plies+$plies),
                    act_cut_status='DONE',fabric_status=5 $update_manual_flag where doc_no = $doc_no ";
    $insert_result = mysqli_query($link,$insert_query) or force_exit('Query Error Cut 1.1');   
	
    
	
	
	
    if($insert_result > 0){
		if($barcode_gen_emb=='yes' && $emb_check_in_roll==0)
		{	
			$doc_qty_query12 = "SELECT order_tid from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
			$doc_qty_result12 = mysqli_query($link,$doc_qty_query12);
			while($row12 = mysqli_fetch_array($doc_qty_result12))
			{
				$doc_qty_query122 = "SELECT order_col_des from $bai_pro3.bai_orders_db_confirm where order_tid = '".$row12['order_tid']."'";
				$doc_qty_result122 = mysqli_query($link,$doc_qty_query122);
				while($row122 = mysqli_fetch_array($doc_qty_result122))
				{
					$cols=$row122['order_col_des'];
				}
			}
			
			$sql_check="SELECT tsm.operation_code AS operation_code,tsm.previous_operation AS previous_operation,tsm.ops_dependency AS ops_dependency FROM brandix_bts.tbl_style_ops_master tsm 
			LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE 
			style='$style' AND color='$cols' AND tor.category IN ('Send PF','Receive PF') ORDER BY tsm.`operation_order`*1";
			$result_check=mysqli_query($link,$sql_check) or exit('verifying the codes');
			if(mysqli_num_rows($result_check)>0)
			{
				while($rows = mysqli_fetch_array($result_check))
				{
					$ops_codes[] = $rows['operation_code'];
					$next_ops[] = $rows['ops_dependency'];
					$prev_ops[] = $rows['previous_operation'];
				}
				$doc_qty_query1 = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
				$doc_qty_result1 = mysqli_query($link,$doc_qty_query1);
				while($row1 = mysqli_fetch_array($doc_qty_result1))
				{
					foreach($sizes_array as $size)
					{
						if($row1['p_'.$size] > 0)
						{
							$doc_qty_query12 = "SELECT title_size_".$size." as size_tit from $bai_pro3.bai_orders_db_confirm where order_tid = '".$row1['order_tid']."'";
							$doc_qty_result12 = mysqli_query($link,$doc_qty_query12);
							while($row12 = mysqli_fetch_array($doc_qty_result12))
							{
								$size_val=$row12['size_tit'];	
							}
							$ratio[$size_val] = $row1['p_'.$size];
							$sizes_tot[]=$size_val;
						}
					}
				}
				$sql_check_id="SELECT max(tran_id)+1 as barcode,max(report_seq)+1 as seqid from $bai_pro3.emb_bundles where doc_no=$doc_no";
				$result_check_id=mysqli_query($link,$sql_check_id) or exit('verifying the codes');
				while($row12_id = mysqli_fetch_array($result_check_id))
				{
					if($row12_id['barcode']==0 || $row12_id['barcode']=='')
					{
						$ids=1;
						$seqids=1;
					}
					else
					{
						$ids=$row12_id['barcode'];
						$seqids=$row12_id['seqid'];
					}			
				}
				for($j=0;$j<sizeof($sizes_tot);$j++)
				{			
					do
					{				
						for($jj=0;$jj<sizeof($ops_codes);$jj++)
						{					
							$sql_insert="INSERT INTO $bai_pro3.`emb_bundles` (`doc_no`, `size`, `ops_code`, `barcode`, `quantity`, `good_qty`, `reject_qty`, `insert_time`, `club_status`, `log_user`, `tran_id`,`report_seq`, `shade`, `num_id`) 
							VALUES (".$doc_no.", '".$sizes_tot[$j]."', ".$ops_codes[$jj].", '".$doc_no."-".$ops_codes[$jj]."-".$ids."', ".$plies.", 0, 0, '".date("Y-m-d H:i:s")."', '1', '".$user."', ".$ids.",".$seqids.",'N/A','0')";
							mysqli_query($link,$sql_insert);
						}
						$ids++;
						$ratio[$sizes_tot[$j]]--;
					}while($ratio[$sizes_tot[$j]]>0);			
				}			
			}
		}
        $update_result = mysqli_query($link,$update_query) or force_exit('Query Error Cut 2.3');
        if($update_result){
            $response_data['saved'] = 1;
            // $stat = mysqli_commit($link2)  or force_exit('Cant Commit Transaction');
            // if($stat == 0){
            //     echo json_encode($response_data);
            //     exit();
            // }
        }else{   
            $response_data['saved'] = 0;
            // mysqli_rollback($link2);
            // mysqli_close($link2);
            echo json_encode($response_data);
            exit();    
        } 
    }else{
        $response_data['saved'] = 0;
        echo json_encode($response_data);
        //mysqli_close($link);
        exit();
    }
    //mysqli_close($link2);
    // $link = mysqli_connect($host, $user, $pass) or force_exit('Unable To COnnect DB'); 
    // if($link == 0){
    //     echo json_encode($response_data);
    //     exit();
    // }

    //getting all child dockets
    $child_docs_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log psl  
                        LEFT JOIN bai_pro3.cat_stat_log csl ON csl.tid = psl.cat_ref
                        where org_doc_no = '$doc_no' and category IN ($in_categories)";
    $child_docs_result = mysqli_query($link,$child_docs_query);
    while($row = mysqli_fetch_array($child_docs_result)){
        $child_docs[] = $row['doc_no'];
    }
    //getting size wise qty of parent docket
    $doc_qty_query = "SELECT $p_sizes_str,doc_no from $bai_pro3.plandoc_stat_log where doc_no = '$doc_no' ";
    $doc_qty_result = mysqli_query($link,$doc_qty_query);
    while($row = mysqli_fetch_array($doc_qty_result)){
        foreach($sizes_array as $size){
            if($row['p_'.$size] > 0)
                $reporting[$size] = $row['p_'.$size] * $plies;
        }
    }
    
    //for each child docket calculating a_s01,a_s02,..
    foreach($child_docs as $child_doc){
        $size_qty_query = "SELECT $p_sizes_str,$a_sizes_str from $bai_pro3.plandoc_stat_log 
                        where doc_no = '$child_doc' ";              
        $sizes_qty_result = mysqli_query($link,$size_qty_query); 
        while($row = mysqli_fetch_array($sizes_qty_result)){
            //getting all the planned sizes for child dockets
            foreach($sizes_array as $size){
                if($row['p_'.$size] - $row['a_'.$size] > 0)
                    $planned[$child_doc][$size]    = $row['p_'.$size] - $row['a_'.$size];
            }
        }

        foreach($planned[$child_doc] as $size=>$qty){
            if($reporting[$size] > $qty){
                $new_qty = $qty;
                $reporting[$size] -= $qty;
            }else{
                $new_qty =  $reporting[$size];
                $reporting[$size] = 0;
            }
            if($new_qty > 0){
                $size_update_string .= "a_$size = a_$size + $new_qty,";
                $reported[$child_doc][$size] = $new_qty;
                $reported2[$child_doc][$size] = $new_qty;
            }
        }
        //Updating plandoc_stat_log for child dockets
        if(strlen($size_update_string) > 0){
            $before_updation = "SELECT $a_sizes_str from $bai_pro3.plandoc_stat_log where doc_no = $child_doc";
            $before_updation_result = mysqli_query($link,$before_updation);
            while($as_row = mysqli_fetch_array($before_updation_result)){
                $dummy_a_str = '';
                foreach($sizes_array as $size){
                    $dummy_a_str .= 'a_'.$size.'='.$as_row[$size].','; 
                }
                $before_aS[$child_doc] = $dummy_a_str;
            }
            $update_childs_query = "UPDATE $bai_pro3.plandoc_stat_log set $size_update_string act_cut_status = 'DONE'
                                    where doc_no ='$child_doc' ";
            $update_childs_result = mysqli_query($link,$update_childs_query) or force_exit('Child Docket Update Error');
            // if($update_childs_result == 0){
            //     echo json_encode($response_data);
            //     exit();
            // }
        }
        unset($size_update_string);
        unset($planned);
    }
   
    //distributing  all rejected quantities among child dockets and getting them into an array
    //NOTE : If this loop quits ,then there will be no updation of cps_log,bcd for good reported quantities
    if($rejections_flag == 1){
        next_reason : foreach($rejection_details as $size => $reason_wise){
            foreach($reason_wise as $reason => $rqty){
                if($quit_counter1++ > $THRESHOLD )
                    goto iquit;
                if($rqty > 0){
                next_docket :foreach($reported2 as $doc => $size_wise){
                                    if($quit_counter2++ > $THRESHOLD )
                                        goto iquit;
                                    foreach($size_wise as $dsize => $dqty){
                                        if($dsize == $size){
                                            if($dqty > 0){
                                                //echo $rqty.' - '.$dqty.'<br/>'; 
                                                if($rqty <= $dqty){
                                                    $rejection_details_each[$doc][$size][$reason] += $rqty;
                                                    $rejection_details_each_size[$doc][$size] += $rqty;
                                                    $reported2[$doc][$size] -= $rqty;
                                                    unset($rejection_details[$size][$reason]);
                                                    //$reason_wise[$reason] = 0;
                                                    // var_dump($rejection_details);echo " Rej <br/>";
                                                    // var_dump($reported2);echo " above <br/>";
                                                    goto next_reason;
                                                }else{
                                                    $rejection_details_each[$doc][$size][$reason] += $dqty;
                                                    $rejection_details_each_size[$doc][$size] += $dqty;
                                                    unset($reported2[$doc][$size]);
                                                    $rejection_details[$size][$reason] -= $dqty;
                                                    $rqty -= $dqty;
                                                    //$reason_wise[$reason] -= $dqty;
                                                    //var_dump($rejection_details);echo " Rej <br/>";
                                                    //var_dump($reported2);echo "<br/>";
                                                    goto next_docket;
                                                }
                                            }
                                        }
                                    }
                                }
                }
            }
        }
    }

    if(sizeof($reported) == 0){
        force_exit('Unable to process the docket');
        echo json_encode($response_data);
        exit();
    }
    //In order to pass the rejected values each doc wise we are calling this function after rejections calc
    $status = update_cps_bcd_schedule_club($reported,$style,$schedule,$color,$rejection_details_each_size);
    
    if($rejections_flag == 1){
        foreach($rejection_details_each as $doc_no => $its_rejection_details){
            $style_color_query = "SELECT color,schedule from $brandix_bts.bundle_creation_data 
                                where docket_number = $doc_no limit 1";
            $style_color_result = mysqli_query($link,$style_color_query);
            if(mysqli_num_rows($style_color_result) > 0){     
                $row = mysqli_fetch_array($style_color_result);  
                $schedule = $row['schedule'];
                $color    = $row['color'];
                $rej_status = save_rejections($doc_no,$its_rejection_details,$style,$schedule,$color,$shift,$cut_remarks);
            }else{
                $rej_status = 3;
            }                 
        }
        $response_data['rejections_response'] = $rej_status;
    } 
    iquit : if($status === 'fail'){
        $response_data['pass'] = 0;
        //force_exit('Schedule Clubbed Docket Reporting Failed');
        echo json_encode($response_data);
        exit();
    }else{
		act_logical_bundles($doc_no,$schedule,$style,$color);
        $response_data['pass'] = 1;
        $response_data['m3_updated'] = $status;
        echo json_encode($response_data);
        emblishment_quantities(implode(",",$child_docs),$style,$color);
        exit();
    } 
}

//Style clubbing docket saving
if($target == 'style_clubbed'){
    $rejection_details_each = [];
    $quit_counter1 = 0;
    $quit_counter2 = 0;
    $remarks = "$date^$cut_table^$shift^$f_rec^$f_ret^$damages^$shortages^$returned_to^$plies";

    // $link2 = mysqli_connect($host, $user, $pass) or force_exit("Could not connect Style Clubbed ");
    // mysqli_begin_transaction($link2) or force_exit("Cant Begin Transaction");
    $insert_query = "INSERT into $bai_pro3.act_cut_status (doc_no,date,section,shift,fab_received,fab_returned, 
                    damages,shortages,remarks,log_date,bundle_loc,leader_name,joints_endbits) 
                    values ($doc_no,'$date','$cut_table','$shift','$f_rec','$f_ret','$damages','$shortages','$remarks','$date_time','$bundle_location','$team_leader','$joints_endbits')
                    ON DUPLICATE KEY 
                    UPDATE date='$date',section='$cut_table',shift='$shift',fab_received=fab_received + $f_rec,fab_returned='$f_ret',damages='$damages',shortages='$shortages',
                    remarks=CONCAT(remarks,'$','$remarks'),
                    log_date='$date_time',bundle_loc='$bundle_location',leader_name='$team_leader',joints_endbits=CONCAT(joints_endbits,'$','$joints_endbits')";

    $update_query = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies = IF(a_plies = p_plies,$plies,a_plies+$plies),
                    act_cut_status='DONE',fabric_status=5 $update_manual_flag where doc_no = $doc_no ";
    $insert_result = mysqli_query($link,$insert_query) or force_exit('Query Error Cut 1.2');   
	
	
	
    if($insert_result > 0){
		
		if($barcode_gen_emb=='yes' && $emb_check_in_roll==0)
		{	
			$sql_check="SELECT tsm.operation_code AS operation_code,tsm.previous_operation AS previous_operation,tsm.ops_dependency AS ops_dependency FROM brandix_bts.tbl_style_ops_master tsm 
			LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.operation_code=tsm.operation_code WHERE 
			style='$style' AND color='$color' AND tor.category IN ('Send PF','Receive PF') ORDER BY tsm.`operation_order`*1";
			$result_check=mysqli_query($link,$sql_check) or exit('verifying the codes');
			if(mysqli_num_rows($result_check)>0)
			{
				while($rows = mysqli_fetch_array($result_check))
				{
					$ops_codes[] = $rows['operation_code'];
					$next_ops[] = $rows['ops_dependency'];
					$prev_ops[] = $rows['previous_operation'];
				}
				$doc_qty_query1 = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no = $doc_no";
				$doc_qty_result1 = mysqli_query($link,$doc_qty_query1);
				while($row1 = mysqli_fetch_array($doc_qty_result1))
				{
					foreach($sizes_array as $size)
					{
						if($row1['p_'.$size] > 0)
						{
							$doc_qty_query12 = "SELECT title_size_".$size." as size_tit from $bai_pro3.bai_orders_db_confirm where order_tid = '".$row1['order_tid']."'";
							$doc_qty_result12 = mysqli_query($link,$doc_qty_query12);
							while($row12 = mysqli_fetch_array($doc_qty_result12))
							{
								$size_val=$row12['size_tit'];	
							}
							$ratio[$size_val] = $row1['p_'.$size];
							$sizes_tot[]=$size_val;
						}
					}
				}
				$sql_check_id="SELECT max(tran_id)+1 as barcode,max(report_seq)+1 as seqid from $bai_pro3.emb_bundles where doc_no=$doc_no";
				$result_check_id=mysqli_query($link,$sql_check_id) or exit('verifying the codes');
				while($row12_id = mysqli_fetch_array($result_check_id))
				{
					if($row12_id['barcode']==0 || $row12_id['barcode']=='')
					{
						$ids=1;
						$seqids=1;
					}
					else
					{
						$ids=$row12_id['barcode'];
						$seqids=$row12_id['seqid'];
					}			
				}
				for($j=0;$j<sizeof($sizes_tot);$j++)
				{			
					do
					{				
						for($jj=0;$jj<sizeof($ops_codes);$jj++)
						{					
							$sql_insert="INSERT INTO $bai_pro3.`emb_bundles` (`doc_no`, `size`, `ops_code`, `barcode`, `quantity`, `good_qty`, `reject_qty`, `insert_time`, `club_status`, `log_user`, `tran_id`,`report_seq`, `shade`, `num_id`) 
							VALUES (".$doc_no.", '".$sizes_tot[$j]."', ".$ops_codes[$jj].", '".$doc_no."-".$ops_codes[$jj]."-".$ids."', ".$plies.", 0, 0, '".date("Y-m-d H:i:s")."', '1', '".$user."', ".$ids.",".$seqids.",'N/A','0')";
							mysqli_query($link,$sql_insert);
						}
						$ids++;
						$ratio[$sizes_tot[$j]]--;
					}while($ratio[$sizes_tot[$j]]>0);			
				}			
			}
		}
		
        $update_result = mysqli_query($link,$update_query) or force_exit('Query Error Cut 2.4');
        if($update_result){
            $response_data['saved'] = 1;
            // $stat = mysqli_commit($link2) or force_exit("Cant Commit Transaction");
            // if($stat == 0){
            //     echo json_encode($response_data);
            //     exit();
            // }
        }else{   
            $response_data['saved'] = 0;
            echo json_encode($response_data);
            // mysqli_rollback($link2);
            // mysqli_close($link2);
            exit();    
        } 
    }else{
        $response_data['saved'] = 0;
        echo json_encode($response_data);
        //mysqli_close($link2);
        exit();
    }
    //mysqli_close($link2);

    //getting all child dockets
    $child_docs_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log psl  
                        LEFT JOIN $bai_pro3.cat_stat_log csl ON csl.tid = psl.cat_ref
                        where org_doc_no = '$doc_no' and category IN ($in_categories)";
    $child_docs_result = mysqli_query($link,$child_docs_query);
    while($row = mysqli_fetch_array($child_docs_result)){
        $child_docs[] = $row['doc_no'];
    }
    //getting the no of schedules clubbed for the style for equal filling logic
    $child_schedules_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log psl  
                    LEFT JOIN $bai_pro3.cat_stat_log csl ON csl.tid = psl.cat_ref
                    where org_doc_no = '$doc_no' and category IN ($in_categories)";
    $child_schedules_result = mysqli_query($link,$child_docs_query);
    while($row = mysqli_fetch_array($child_docs_result)){
        $schedules_count = $row['doc_no'];
    }

    //getting size wise qty of parent docket
    if($plies == $p_plies){
        $doc_qty_query = "SELECT $p_sizes_str,doc_no,a_plies from $bai_pro3.plandoc_stat_log where org_doc_no = '$doc_no' 
        order by acutno ASC";
        $doc_qty_result = mysqli_query($link,$doc_qty_query);
        while($row = mysqli_fetch_array($doc_qty_result)){
            $doc = $row['doc_no'];
            $a_plies = $row['a_plies'];
            foreach($sizes_array as $size){
                if($row['p_'.$size] > 0)
                    $reported[$doc][$size] = ($row['p_'.$size] * $a_plies);
            }
        }
        goto full_plies;
    }else{
        $doc_qty_query = "SELECT $p_sizes_str,doc_no from $bai_pro3.plandoc_stat_log where doc_no = '$doc_no' 
                        order by acutno ASC";
        $doc_qty_result = mysqli_query($link,$doc_qty_query);
        while($row = mysqli_fetch_array($doc_qty_result)){
            foreach($sizes_array as $size){
                if($row['p_'.$size] > 0)
                    $reporting[$size] = ($row['p_'.$size] * $plies);
            }
        }
    }

    //for each child docket calculating a_s01,a_s02,..
    foreach($child_docs as $child_doc){
        $size_qty_query = "SELECT $a_sizes_str,$p_sizes_str from $bai_pro3.plandoc_stat_log 
                        where doc_no = '$child_doc' ";
        $sizes_qty_result = mysqli_query($link,$size_qty_query); 
        while($row = mysqli_fetch_array($sizes_qty_result)){
            //getting all the planned sizes for child dockets
            foreach($sizes_array as $size){
                if($row['p_'.$size] - $row['a_'.$size] > 0){
                    $planned[$size][$child_doc]    = $row['p_'.$size] - $row['a_'.$size];
                    $remaining[$child_doc][$size]  = $reporting[$size];
                    $dockets[$size] += 1;
                }
            }
        }
    }

    //Initial Equal distribution for all dockets
    $rem = 0;
    
    foreach($planned as $size => $docket){
        $qty = $reporting[$size];
        if($qty > 0){
            $docs = $dockets[$size];
            if($docs > 0){
                $splitted = $qty;
                $quit_counter = 0;
                if($qty > $docs){
                    do{
                        if($quit_counter++ > $THRESHOLD){
                            $response_data['pass'] = 0;
                            force_exit('Infinte loop struck');
                            echo json_encode($response_data);
                            exit();
                        }              
                        if(ceil($splitted % $docs) > 0)
                            $splitted--;
                    }while($splitted % $docs > 0);
                    $rem = $qty - $splitted;
                    $splitted = $splitted/$docs;
                }else{
                    $rem = $qty;
                    $splitted = 0;
                }
            }
        }

        foreach($docket as $child_doc => $qty){
            if($qty > 0){
                if($rem > 0){
                    $rem--;
                    $remaining[$child_doc][$size] = $splitted + 1;
                }else   
                    $remaining[$child_doc][$size] = $splitted; 
            }
        }
    }

    //Equal Filling Logic for all child dockets 
    next_size : foreach($planned as $size => $plan){
        $quit_counter = 0;
        do{
            $left_over[$size] = 0;
            if($quit_counter++ > $THRESHOLD){
                $response_data['pass'] = 0;
                force_exit('Threshold Exceeded');
                echo json_encode($response_data);
                exit();
            }
            $fulfill_qty = $reporting[$size];
            $counter = 0;
            foreach($plan as $docket => $qty){
                if($planned[$size][$docket] > 0 && $remaining[$docket][$size] >0){
                    $qty = $qty - $reported[$docket][$size];
                    if($remaining[$docket][$size] > $qty){
                        $reported[$docket][$size] += $qty;
                        $remaining[$docket][$size] -= $qty;
                        $planned[$size][$docket] = 0;
                        $qty = 0;
                    }else{
                        $reported[$docket][$size] += $remaining[$docket][$size];
                        $planned[$size][$docket]  -= $remaining[$docket][$size];
                        $remaining[$docket][$size] = 0;
                        $qty = 0;
                        //$counter++;
                    }   
                }
                if($planned[$size][$docket] > 0)
                    $counter++;

                // if($planned[$size][$docket] > 0 && $reported[$docket][$size]-$planned[$size][$docket] == 0)    
                //     $left_over[$size] += $planned[$size][$docket];
                // else
                $left_over[$size] += $remaining[$docket][$size];

                $fulfill_qty -= $reported[$docket][$size];
            }
            if($counter == 0)
                break;
        
            //$left_over[$size] = round($left_over[$size]/$counter);
            foreach($planned[$size] as $docket => $qty){
                $remaining[$docket][$size] = 0;
            }
            //Equal sharing of left over size for all dockets whose planned is still to be fulfilled
            $LEFT = $left_over[$size];
            $left_quit_counter = 0;
            do{
                if($left_quit_counter++ > $LEFT_THRESHOLD){
                    $response_data['pass'] = 0;
                    force_exit('LEFT Threshold Exceeded');
                    echo json_encode($response_data);
                    exit();
                }
                foreach($planned[$size] as $docket => $qty){
                    if($planned[$size][$docket] > 0){
                        $remaining[$docket][$size] += 1;
                        $LEFT--;
                    }else{
                        $remaining[$docket][$size] = 0;
                    }
                    if($LEFT<=0)
                        break;
                }
            }while($LEFT > 0);
           
            // foreach($planned[$size] as $docket => $qty){
            //     if($planned[$size][$docket] > 0){
            //         $remaining[$docket][$size] = $left_over[$size];
            //     }else{
            //         $remaining[$docket][$size] = 0;
            //     }
            // }
            if($left_over[$size] == 0)
                $fulfill_qty = 0;
        }while($fulfill_qty > 0);
    }
   
    //ALL Excess Qty left out to be filled equally 
    
    foreach($left_over as $size=>$qty){
        if($qty > 0){
            //Ensuring if any qty to be fulfilled before considering it as excess left over qty
            foreach($planned as $docket=>$dummy){
                foreach($docket[$size] as $dummy=>$rqty){
                    if($rqty > 0 && $qty > 0){
                        if($rqty > $qty){
                            $reported[$docket][$size] += $qty;
                            $qty = 0;
                        }else{
                            $reported[$docket][$size] += $rqty;
                            $qty -= $rqty;
                        }
                    }
                }
            }
            $docs = $dockets[$size];
            if($docs > 0 && $qty > 0){
                $splitted = $qty;
                $quit_counter = 0;
                if($qty > $docs){
                    do{
                        $quit_counter++;
                        if($quit_counter > 50){
                            $response_data['pass'] = 0;
                            force_exit('Infinite loop Struck 2');
                            echo json_encode($response_data);
                            exit();
                        }
                        if(ceil($splitted % $docs) > 0)
                            $splitted--;
                    }while($splitted % $docs > 0);
                    $rem = $qty - $splitted;
                    $splitted = $splitted/$docs;
                }else{
                    $rem = $qty;
                    $splitted = 0;
                }
                foreach($planned[$size] as $docket => $ignore){
                    if($rem > 0){
                        $rem--;
                        $reported[$docket][$size] += $splitted + 1;
                    }else{
                        $reported[$docket][$size] += $splitted;
                    }
                }
            }
        }
    }

    full_plies : 
    //Array Cloning reported into reported2
    foreach($reported as $doc => $size_wise){
        foreach($size_wise as $size => $qty){
            $reported2[$doc][$size] = $qty;
        }
    }
    foreach($reported as $child_doc => $plan){
        $size_update_string = '';
        foreach($plan as $size => $qty){
            $size_update_string .= "a_$size = a_$size + $qty ,";
        }
        if(strlen($size_update_string) > 0){
            $before_updation = "SELECT $a_sizes_str from $bai_pro3.plandoc_stat_log where doc_no = $child_doc";
            $before_updation_result = mysqli_query($link,$before_updation);
            while($as_row = mysqli_fetch_array($before_updation_result)){
                $dummy_a_str = '';
                foreach($sizes_array as $size){
                    $dummy_a_str .= 'a_'.$size.'='.$as_row[$size].','; 
                }
                $before_aS[$child_doc] = $dummy_a_str;
            }
            $update_childs_query = "UPDATE $bai_pro3.plandoc_stat_log set $size_update_string act_cut_status = 'DONE'
                                    where doc_no = $child_doc ";
            $update_childs_result = mysqli_query($link,$update_childs_query) 
                                or force_exit('Child Docket Update Error Style Clubbing');
            if($update_childs_result == 0){
                echo json_encode($response_data);
                exit();
            }
        }
    }
    //Updating plandoc_stat_log for child dockets
    unset($size_update_string);
    unset($planned);
    
    //distributing  all rejected quantities among child dockets and getting them into an array
    //NOTE : If this loop quits ,then there will be no updation of cps_log,bcd for good reported quantities
    if($rejections_flag == 1){
        next_reason1 : foreach($rejection_details as $size => $reason_wise){
            foreach($reason_wise as $reason => $rqty){
                if($quit_counter1++ > $THRESHOLD )
                    goto iquit1;
                if($rqty > 0){
                next_docket1 :foreach($reported2 as $doc => $size_wise){
                                    if($quit_counter2++ > $THRESHOLD )
                                        goto iquit1;
                                    foreach($size_wise as $dsize => $dqty){
                                        if($dsize == $size){
                                            if($dqty > 0){
                                                //echo $rqty.' - '.$dqty.'<br/>'; 
                                                if($rqty <= $dqty){
                                                    $rejection_details_each[$doc][$size][$reason] += $rqty;
                                                    $rejection_details_each_size[$doc][$size] += $rqty;
                                                    $reported2[$doc][$size] -= $rqty;
                                                    unset($rejection_details[$size][$reason]);
                                                    //$reason_wise[$reason] = 0;
                                                    goto next_reason1;
                                                }else{
                                                    $rejection_details_each[$doc][$size][$reason] += $dqty;
                                                    $rejection_details_each_size[$doc][$size] += $dqty;
                                                    unset($reported2[$doc][$size]);
                                                    $rejection_details[$size][$reason] -= $dqty;
                                                    $rqty -= $dqty;
                                                    //$reason_wise[$reason] -= $dqty;
                                                    goto next_docket1;
                                                }
                                            }
                                        }
                                    }
                                }
                }
            }
        }
    }
    //In order to pass the rejected values each doc wise we are calling this function after rejections calc
    if(sizeof($reported) == 0){
        force_exit('Unable to process the docket');
        echo json_encode($response_data);
        exit();
    }
    $status = update_cps_bcd_schedule_club($reported,$style,$schedule,$color,$rejection_details_each_size);
    if($rejections_flag == 1){
        //var_dump($rejection_details_each);
        foreach($rejection_details_each as $doc_no => $its_rejection_details){
            $style_color_query = "SELECT color,schedule from $brandix_bts.bundle_creation_data 
                                where docket_number = $doc_no limit 1";
            //echo $style_color_query;                    
            $style_color_result = mysqli_query($link,$style_color_query);
            if(mysqli_num_rows($style_color_result) > 0){     
                $row = mysqli_fetch_array($style_color_result);  
                $schedule = $row['schedule'];
                $color    = $row['color'];
                $rej_status = save_rejections($doc_no,$its_rejection_details,$style,$schedule,$color,$shift,$cut_remarks);
            }else{
                $rej_status = 3;
            }                 
        }
        $response_data['rejections_response'] = $rej_status;
    } 
    iquit1 : if($status === 'fail'){
        $response_data['pass'] = 0;
        //force_exit('Style Clubbed Docket Reporting Failed');
        echo json_encode($response_data);
        exit();
    }else{
		act_logical_bundles($doc_no,$schedule,$style,$color);
        $response_data['pass'] = 1;
        $response_data['m3_updated'] = $status;
        echo json_encode($response_data);
        emblishment_quantities(implode(",",$child_docs),$style,$color);
        exit();
    } 
}

//for style or schdule club dockets a random color is picked 
function get_me_emb_check_flag($style,$color,$op_code){
    //getting post operation code
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $category=['cutting','Send PF','Receive PF'];
    $ops_seq_query = "SELECT id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master 
                    where style='$style' and color = '$color' and operation_code='$op_code'";
    $ops_seq_result = mysqli_query($link,$ops_seq_query);
    while($row = mysqli_fetch_array($ops_seq_result)) 
    {
        $ops_seq    = $row['ops_sequence'];
        $seq_id     = $row['id'];
        $ops_order  = $row['operation_order'];
    }
    if(mysqli_num_rows($ops_seq_result) > 0){
        $post_ops_query = "SELECT operation_code from $brandix_bts.tbl_style_ops_master where style='$style' 
                    and color = '$color' and ops_sequence = $ops_seq  
                    AND CAST(operation_order AS CHAR) > '$ops_order' 
                    AND operation_code not in (10,200) ORDER BY operation_order ASC LIMIT 1";
        $post_ops_result = mysqli_query($link,$post_ops_query);
        while($row = mysqli_fetch_array($post_ops_result)) 
        {
            $post_ops_code = $row['operation_code'];
        }
    }else{
        // return 'fail';
    }
    //post operation code logic ends

    //if post operation is emb then updating send qty of emb operation in BCD
    $category_qry = "SELECT category FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code = '$post_ops_code'";
    $category_result = mysqli_query($link,$category_qry);
    while($row = mysqli_fetch_array($category_result)) 
    {
        $category_act = $row['category'];
    }
    
    if($post_ops_code > 0){
        if(in_array($category_act,$category))
            return $post_ops_code;
        else
            return 0;
    }
    return 0;
    //emb checking ends
}

function update_cps_bcd_normal($doc_no,$plies,$style,$schedule,$color,$rejection_details){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    error_reporting(0);
    global $full_reporting_flag;
    $update_counter = 0;
    $counter = 0;
    $category=['cutting','Send PF','Receive PF'];
    $op_code = 15;

    $emb_cut_check_flag = get_me_emb_check_flag($style,$color,$op_code);

    //Updaitng to cps,bcd,moq,m3_transactions
    $doc_details_query = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no = $doc_no ";
    $doc_details_result = mysqli_query($link,$doc_details_query) or force_exit('Query Error 4');
    while($row = mysqli_fetch_array($doc_details_result)){
        $a_plies = $row['a_plies'];
        $p_plies = $row['p_plies'];
        if($a_plies == $p_plies)
            $reported_status = 'F';
        else    
            $reported_status = 'P' ;
        
        if($full_reporting_flag == 1)
            $reported_status = 'F';
        //Updating CPS log
        foreach($sizes_array as $size)
        {
            if($row['a_'.$size] > 0)
                $cut_qty[$size] = $row['a_'.$size]*$plies;
        }

        //Calculating all the rejected qtys
        foreach($rejection_details as $size => $reason_wise){
            $total_sum = 0;
            foreach($reason_wise as $reason_code => $qty){
                if($qty > 0){
                    $total_sum   += $qty;
                }
            }
            $rejected[$size] = $total_sum;//total size wise qty sum into an array
        }
        
        // $link2 = mysqli_connect($host, $user, $pass) or force_exit("Could not connect CPS_BCD ");
        // $stat  = mysqli_begin_transaction($link2) or force_exit("Cant Begin Transaction CPS_BCD");
        // if($stat == 0)
        //     return 'fail';

        foreach($cut_qty as $size=>$qty){
            $qty = $qty - $rejected[$size];
            $rej = $rejected[$size]>0 ? $rejected[$size] : 0;
            //Updating CPS
            $update_cps_query = "UPDATE $bai_pro3.cps_log set remaining_qty = remaining_qty + $qty,
                            reported_status = '$reported_status' 
                            where doc_no = $doc_no and size_code='$size' and operation_code = $op_code ";
            $update_cps_result = mysqli_query($link,$update_cps_query); 
            $cps_counter = 0;
            if(mysqli_affected_rows($link) == 1)   
                $cps_counter++;
           
            //Updating BCD
            $update_bcd_query = "UPDATE $brandix_bts.bundle_creation_data set recevied_qty = recevied_qty + $qty,
                            rejected_qty = rejected_qty + $rej
                            where docket_number = $doc_no and size_id = '$size' and operation_id = $op_code";
            //echo $update_bcd_query;                
            $update_bcd_result = mysqli_query($link,$update_bcd_query);
            if(mysqli_affected_rows($link) == 1 && $cps_counter == 1)   
                $counter++;

            if($emb_cut_check_flag > 0)
            {
                $update_bcd_query2 = "UPDATE $brandix_bts.bundle_creation_data set send_qty = send_qty+$qty
                                    WHERE docket_number = $doc_no AND size_id = '$size' 
                                    AND operation_id = $emb_cut_check_flag ";
                $update_bcd_result2 = mysqli_query($link,$update_bcd_query2);
            }   
            // if($update_cps_result && $update_bcd_result)
            //     $counter++;
        }
        //maintainig a seperate loop for bcd temp insertions
        foreach($cut_qty as $size => $qty){
            $qty = $qty - $rejected[$size];
            $rej = $rejected[$size]>0 ? $rejected[$size] : 0;
            insert_into_bcd_temp($doc_no,$size,$qty,$rej,$op_code);
        }
        if($counter == sizeof($cut_qty) && $counter > 0){
            // $stat1 = mysqli_commit($link2) or force_exit("Cant Commit Transaction 2");
            // if($stat1 == 0)
            //     return 'fail';
        }else{    
            // mysqli_rollback($link2);
            // mysqli_close($link2);
            return 'fail';
        }
        //mysqli_close($link2);
        // $link= mysqli_connect($host, $user, $pass) or force_exit('Could not connect DB');
        // if($link == 0){
        //     echo json_encode($response_data);
        //     exit();
        // }
        $counter = 0;

        //Maintaining seperate loop for reporting to moq,m3 inorder to prevail the cut qty reporting for cps,bcd in case of a failure
          
        foreach($cut_qty as $size=>$qty){
            $qty = $qty - $rejected[$size];
            $bundle_id_query = "SELECT bundle_number from $brandix_bts.bundle_creation_data 
                            where docket_number=$doc_no and size_id='$size' and operation_id = $op_code";
            $bundle_id_result = mysqli_query($link,$bundle_id_query);
            if(mysqli_num_rows($bundle_id_result) > 0){
                $row = mysqli_fetch_array($bundle_id_result);
                $bundle_number = $row['bundle_number'];
            }
            $updated = updateM3Transactions($bundle_number,$op_code,$qty);
            if($updated == true)
                $counter++;
        }
        //the $counter returns the no:of rows affected to moq,m3_transactions
        if($counter == sizeof($cut_qty))
            return $counter;
        else    
            return 0;     
    }
}

function update_cps_bcd_schedule_club($reported,$style,$schedule,$color,$rejection_details_each_size){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    error_reporting(0);
    global $full_reporting_flag;
    global $s_a_sizes_str;
    global $s_p_sizes_str;
    $counter = 0;
    $update_flag = 0;
    $op_code = 15;
    //NEED TO DEVELOP VERIFICATION FOR THE STYLE CLUBBED DOCKETS
    $emb_cut_check_flag = get_me_emb_check_flag($style,$color,$op_code);

    foreach($reported as $doc_no=>$size_qty){
        //To verify the reported status is full or not for updating in cps_log #923
        $size_qty_query = "SELECT SUM($s_p_sizes_str) as plan,SUM($s_a_sizes_str) as actual 
                        from $bai_pro3.plandoc_stat_log where doc_no = '$doc_no' ";               
        $sizes_qty_result = mysqli_query($link,$size_qty_query) or force_exit('Getting Reported Status Error');
        if($sizes_qty_result == 0)
            return 'fail';
        while($row = mysqli_fetch_array($sizes_qty_result)){
            if($row['plan'] == $row['actual'])
                $reported_status = 'F';
            else
                $reported_status = 'P';
        }
        if($full_reporting_flag == 1)
            $reported_status = 'F';

        // $link2 = mysqli_connect($host, $user, $pass) or force_exit("Could not connect CPS_BCD ");
        // $stat  = mysqli_begin_transaction($link2) or force_exit("Cant Begin Transaction CPS_BCD");   
        foreach($size_qty as $size => $qty){
            $qty = $qty - $rejection_details_each_size[$doc_no][$size];
            $rej = $rejection_details_each_size[$doc_no][$size] > 0 ? $rejection_details_each_size[$doc_no][$size] : 0; 
            if($qty == '')
                $qty = 0;
            //Updating CPS
            $update_flag++;
            $update_cps_query = "UPDATE $bai_pro3.cps_log set remaining_qty = remaining_qty + $qty,
                            reported_status = '$reported_status'
                            where doc_no = $doc_no and size_code='$size' and operation_code = $op_code ";
            $update_cps_result = mysqli_query($link,$update_cps_query);
            $cps_counter = 0;
            if(mysqli_affected_rows($link) == 1)   
                $cps_counter++;

            //Updating CPS to Full Status
            $update_cps_f_query = "UPDATE $bai_pro3.cps_log set reported_status = 'F' 
                                    where doc_no = '$doc_no' and size_code='$size' and operation_code = $op_code 
                                    and cut_quantity = remaining_qty";
            $update_cps_f_result = mysqli_query($link,$update_cps_f_query); 
            
            //Updating BCD
            $update_bcd_query = "UPDATE $brandix_bts.bundle_creation_data set recevied_qty = recevied_qty + $qty,
                            rejected_qty = rejected_qty + $rej where docket_number = $doc_no AND size_id = '$size' 
                            and operation_id = $op_code";
            $update_bcd_result = mysqli_query($link,$update_bcd_query);
            if(mysqli_affected_rows($link) == 1 && $cps_counter == 1)   
                $counter++;

            if($emb_cut_check_flag > 0)
            {
                $update_bcd_query2 = "UPDATE $brandix_bts.bundle_creation_data set send_qty = send_qty+$qty
                                WHERE docket_number = $doc_no AND size_id = '$size' 
                                AND operation_id = $emb_cut_check_flag";
                $update_bcd_result2 = mysqli_query($link,$update_bcd_query2);
            }   
            // if($update_cps_result && $update_bcd_result)
            //     $counter++;
        }
        //maintaining a seperate loop for bcd temp insertions
        foreach($size_qty as $size => $qty){
            $qty = $qty - $rejection_details_each_size[$doc_no][$size];
            $rej = $rejection_details_each_size[$doc_no][$size] > 0 ? $rejection_details_each_size[$doc_no][$size] : 0; 
            if($qty == '')
                $qty = 0;
            insert_into_bcd_temp($doc_no,$size,$qty,$rej,$op_code);
        }
    }

    //echo "$counter -- $update_flag";
    if($counter == $update_flag && $counter > 0){
        // $stat1 = mysqli_commit($link2) or force_exit("Cant Commit Transaction 2");
        // if($stat1 == 0)
        //     return 'fail'; 
    }else{   
        // mysqli_rollback($link2);
        // mysqli_close($link2);
        return 'fail';
    }
    //mysqli_close($link2);
    // $link = mysqli_connect($host, $user, $pass) or force_exit("Could not connect21: ");
    // if($link == 0){
    //     echo json_encode($response_data);
    //     exit();
    // }
    $counter = 0;
    $update_flag = 0;
    $bundles_count = 0;
    //Maintaining seperate loop for reporting to moq,m3 inorder to prevail the cut qty reporting for cps,bcd
    foreach($reported as $doc_no=>$size_qty){
        foreach($size_qty as $size => $qty){
            $qty = $qty - $rejection_details_each_size[$doc_no][$size];

            $bundle_id_query = "SELECT bundle_number from $brandix_bts.bundle_creation_data 
                            where docket_number=$doc_no and size_id='$size' and operation_id = $op_code";
            //echo $bundle_id_query;                
            $bundle_id_result = mysqli_query($link,$bundle_id_query);
            if(mysqli_num_rows($bundle_id_result) > 0){
                $bundles_count++;
                $row = mysqli_fetch_array($bundle_id_result);
                $bundle_number = $row['bundle_number'];
                $update_flag++;

                $updated = updateM3Transactions($bundle_number,$op_code,$qty);
                if($updated == true)
                    $counter++;
            }
        }
    }
    //the $counter returns the no:of rows affected to moq,m3_transactions
    if($counter == $bundles_count)
        return $counter;
    else    
        return 0; 
}


function force_exit($str){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    error_reporting(0);
    global $response_data;
    global $doc_no;
    global $zero_a_sizes_str;
    global $plies;
    
    //reverting back the updates 
    $update_query1 = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies = IF(p_plies-$plies=0,p_plies,a_plies-$plies) 
                where doc_no = $doc_no ";
    mysqli_query($link,$update_query1);
    $update_query2 = "UPDATE $bai_pro3.plandoc_stat_log SET act_cut_status = IF(a_plies = p_plies,'','DONE')
                where doc_no = $doc_no ";        
    mysqli_query($link,$update_query2);
    if($doc_no > 1){
        global $before_aS;
        $child_docs_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log where org_doc_no = $doc_no";
        $child_docs_result = mysqli_query($link,$child_docs_query);
        while($row = mysqli_fetch_array($child_docs_result)){
            $doc = $row['doc_no'];
            $update_query3 = "UPDATE $bai_pro3.plandoc_stat_log SET $before_aS[$doc] act_cut_status = '' 
                            where doc_no = $doc ";
            mysqli_query($link,$update_query3);
        }
    } 
    $response_data['error_msg'] = $str;
    return 0;
}

function insert_into_bcd_temp($doc_no,$size,$qty,$rej,$op_code){
    $last_id = 0;
    global $link;
    global $brandix_bts;
    $date = date('Y-m-d H:i:s');
    $insert_query = "INSERT into $brandix_bts.bundle_creation_data_temp(cut_number,style,SCHEDULE,color,size_id,
                size_title,sfcs_smv,
                bundle_number,original_qty,send_qty,recevied_qty,missing_qty,rejected_qty,left_over,operation_id,operation_sequence,
                ops_dependency,docket_number,bundle_status,split_status,sewing_order_status,is_sewing_order,sewing_order,
                assigned_module,remarks,scanned_date,shift,scanned_user,sync_status,shade,input_job_no,input_job_no_random_ref) (
            select  cut_number,style,SCHEDULE,color,size_id,size_title,sfcs_smv,
                bundle_number,original_qty,send_qty,recevied_qty,missing_qty,rejected_qty,left_over,operation_id,operation_sequence,
                ops_dependency,docket_number,bundle_status,split_status,sewing_order_status,is_sewing_order,sewing_order,
                assigned_module,remarks,scanned_date,shift,scanned_user,sync_status,shade,input_job_no,input_job_no_random_ref
            from $brandix_bts.bundle_creation_data where docket_number=$doc_no and size_id='$size' and operation_id = $op_code)";
    mysqli_query($link,$insert_query);
    $last_id = mysqli_insert_id($link); 
    $update_bcd_temp =  "UPDATE $brandix_bts.bundle_creation_data_temp set recevied_qty = $qty,rejected_qty=$rej,scanned_date='$date' where id=$last_id";
    mysqli_query($link,$update_bcd_temp);
}


?>




