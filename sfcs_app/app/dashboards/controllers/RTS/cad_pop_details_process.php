<?php

//KiranG - 2015-09-02 : passing link as parameter in update_m3_or function to avoid missing user name. SR#

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=$username_list[1];

//$authorized=array("kirang","herambaj","kishorek","sarojiniv","kirang","demiank","ravipu","ramanav","sekhark","lovakumarig","ganeshb","pithanic","srinivasaraot","santhoshbo","vemanas","rambabub","chaitanyag","kirang","kirang","herambaj","kishorek","sarojiniv","kirang","demiank","ravipu","ramanav","sekhark","lovakumarig","ganeshb","pithanic","srinivasaraot","santhoshbo","vemanas","rambabub","chaitanyag","kirang","sreenivasg");
//$authorized=array("kirang");


include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));

// if(!(in_array(strtolower($username),$authorized)))
// {
// 	header("Location:restrict.php");
// }

?>



<?php
set_time_limit(2000);
$doc_no=$_GET['doc_no'];
$code=$_GET['code'];
//1 -cad
//2 -sourcing
//3 -issued to module update
?>

<html>
<head>


</head>
<body>

<?php

//function to update M3 Bulk OR
function update_m3_or($order_tid,$cut_no_ref,$operation,$link)
{
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	$size_code_db=array('xs','s','m','l','xl','xxl','xxxl','s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

	$size_qty=array();
	
	$sql="select * from $bai_pro3.recut_v2 where order_tid=\"$order_tid\" and acutno=$cut_no_ref and remarks in ('".implode("','",$in_categories)."')"; //20110911
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$size_qty[]=$sql_row['a_xs']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_m']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_l']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_xl']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_xxl']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_xxxl']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s01']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s02']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s03']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s04']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s05']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s06']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s07']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s08']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s09']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s10']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s11']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s12']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s13']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s14']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s15']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s16']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s17']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s18']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s19']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s20']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s21']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s22']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s23']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s24']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s25']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s26']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s27']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s28']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s29']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s30']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s31']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s32']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s33']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s34']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s35']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s36']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s37']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s38']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s39']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s40']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s41']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s42']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s43']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s44']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s45']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s46']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s47']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s48']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s49']*$sql_row['a_plies'];
		$size_qty[]=$sql_row['a_s50']*$sql_row['a_plies'];
		$plan_module=$sql_row['plan_module'];
		$doc_no=$sql_row['doc_no'];
	}
	
	$sql111="select order_style_no,order_del_no,order_col_des from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row111=mysqli_fetch_array($sql_result111))
	{
		$style=$sql_row111['order_style_no'];
		$schedule=$sql_row111['order_del_no'];
		$color=$sql_row111['order_col_des'];		
	}
	
	
	$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_tid_ref='$doc_no' and m3_op_des='$operation'";
	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result111)==0)
	{
		for($i=0;$i<sizeof($size_code_db);$i++)
		{
			
			if($size_qty[$i]>0)
			{
				//SR# 58655600 - KIRANG-20150815 added string quotes for plan module to handle TOP, CUT, EMB recuts.
				$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) values (NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,'$plan_module','','R".leading_zeros($cut_no_ref,3)."')"; 
			
				//echo $sql."<br/>";
				mysqli_query($link, $sql1) or exit("Sql Error6$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
	return 'TRUE';
	}
	else
	{
		return 'FALSE';
	}
	
}

if(isset($_POST['issue']))
{
	$order_tid=$_POST['order_tid'];
	$cut_no_ref=$_POST['cut_no_ref'];
	$status=$_POST['status'];
	$doc_nos=$_POST['doc_no_ref'];
	$codes=$_POST['code_no_ref'];
	$hostname=explode(".",gethostbyaddr($_SERVER['REMOTE_ADDR']));
	
	//For Embellishment Monitoring
	if($status==1)
	{
		//M3 Bulk Upload
			
		$ret=update_m3_or($order_tid,$cut_no_ref,'SIN',$link);
		
		if($ret=="TRUE")
		{
			$sql1="update $bai_pro3.recut_v2 set cut_inp_temp=$status where order_tid=\"$order_tid\" and acutno=$cut_no_ref";
			mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			
			$sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
	}
	else
	{
		switch($status)
		{
			case "EPS":
			{
				//M3 Bulk Upload
				//$ret=update_m3_or($order_tid,$cut_no_ref,'PS',$link);
				
				//if($ret=="TRUE")
				{
					$sql1="update $bai_pro3.recut_v2 set act_cut_issue_status='$status' where order_tid=\"$order_tid\" and acutno=$cut_no_ref";
					mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
				break;
			}
			case "EPR":
			{
				//M3 Bulk Upload
				$ret=update_m3_or($order_tid,$cut_no_ref,'PS',$link);
				
				if($ret=="TRUE")
				{
					$sql1="update $bai_pro3.recut_v2 set act_cut_issue_status='$status' where order_tid=\"$order_tid\" and acutno=$cut_no_ref";
					mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				break;
			}
			case "EPC":
			{
				$ret=update_m3_or($order_tid,$cut_no_ref,'PR',$link);
				
				if($ret=="TRUE")
				{
					$sql1="update $bai_pro3.recut_v2 set act_cut_issue_status='$status' where order_tid=\"$order_tid\" and acutno=$cut_no_ref";
					mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				break;
			}
			default:
			{
				
			}
		}
	}
	
	echo "<h2>Successfully Updated</h2>";
}


?>


<?php

if(isset($_POST['update']))
{
	$order_tid=$_POST['order_tid'];
	$cut_no_ref=$_POST['cut_no_ref'];
	$status=$_POST['status'];
	$doc_nos=$_POST['doc_no_ref'];
	$codes=$_POST['code_no_ref'];
	$hostname=explode(".",gethostbyaddr($_SERVER['REMOTE_ADDR']));
	
	$add_query="";
	if($status==1)
	{
		$add_query=", lastup=\"".date("Y-m-d H:i:s")."\" ";
	}
	$sql1="update $bai_pro3.recut_v2 set fabric_status=$status $add_query where order_tid=\"$order_tid\" and acutno=$cut_no_ref";
	mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<h2>Successfully Updated</h2>";
}

?>

<?php

if(isset($_POST['submit']))
{
	$cat=$_POST['cat'];
	$mklen=$_POST['mklen'];
	$plies=$_POST['plies'];
	$docno=$_POST['docno'];
	$order_tid=$_POST['order_tid'];
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$module=$_POST['module'];
	$cat_name=$_POST['cat_name'];
	$doc_nos=$_POST['doc_no_ref'];
	$codes=$_POST['code_no_ref'];
	$docket_no = '';
	
	$hostname=explode(".",gethostbyaddr($_SERVER['REMOTE_ADDR']));
	
	for($i=0;$i<sizeof($cat);$i++)
	{
		$temp="size_".$cat[$i];
		$size=$_POST[$temp];
		$temp="qty_".$cat[$i];
		$qty=$_POST[$temp];
		$cat_name_temp=$cat_name[$i];
		if(strtoupper($cat_name_temp) == 'BODY' || strtoupper($cat_name_temp) == 'BODY' )
			$docket_no =  $docno[$i];

		$temp=array();
		for($j=0;$j<sizeof($size);$j++)
		{
			$temp[]=$size[$j]."=".$qty[$j];
		}
		
		$sql1="insert into $bai_pro3.maker_stat_log(date,cat_ref,order_tid,mklength) values (\"".date("Y-m-d")."\",".$cat[$i].",\"$order_tid\",".$mklen[$i].")";
		//echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$ilastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
		
		$sql1="update $bai_pro3.recut_v2 set p_plies=".$plies[$i].",a_plies=".$plies[$i].",mk_ref=$ilastid,".implode(",",$temp)." where doc_no=".$docno[$i];
		//echo $sql1;
		mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//if($i==0)
		if($cat_name_temp=="Body" or $cat_name_temp=="Front")
		{
			for($j=0;$j<sizeof($size);$j++)
			{
				$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".str_replace("a_","",$size[$j])."\",".($qty[$j]*$plies[$i]).",9,\"$module-".$docno[$i]."\")";
		//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		$sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
	}

	//-------------------------------------------MO Filling Logic ----------------------------------------------------------------

	// $sizes    = $_POST['size_'];
	$style    = $_POST['style'];
	$schedule = $_POST['schedule'];
	$color    = $_POST['color'];
	$doc_no   = $docket_no;
	$mos = array();
	$qty = 0;
	
	$op_code_query ="SELECT operation_name,operation_code as code FROM $brandix_bts.tbl_orders_ops_ref 
			  		 WHERE default_operation='Yes' and trim(category) = 'cutting' ";
	$op_code_result = mysqli_query($link, $op_code_query) or exit("No Operation Found for Cutting");
	while($row12106=mysqli_fetch_array($op_code_result)) 
	{
		$op_code = $row12106['code'];
		$op_name = $row['operation_name'];		
	}

	$sizes_query = "Select * from $bai_pro3.recut_v2 where doc_no = $doc_no";
	$sizes_result = mysqli_query($link,$sizes_query) or exit('An Error Encountered');
	
	while($row = mysqli_fetch_array($sizes_result)){
		foreach($sizes_array as $key => $value){
			if($row['a_'.$value] > 0)
				$sizes[] = $value;
		}
	}


	foreach($sizes as $key => $sizet){
		//echo $size;
		$qty = 0;
		//getting size title
		//$sizet = ltrim($size,'a'); 
		$size_query = "Select title_size_$sizet as title from $bai_pro3.bai_orders_db_confirm where order_del_no = '$schedule' and 
					order_style_no = '$style' and order_col_des = '$color' ";
		$size_result = mysqli_query($link,$size_query);
		while($row = mysqli_fetch_array($size_result)){
			$mo_size = $row['title'];
			$size_code[$sizet] = $row['title'];
		}		  

		//--------------------------------------- check whether that style exists -------------------------------------
		$mo_no_query = "SELECT mo.mo_no as mo_no,mo.mo_quantity as mo_quantity,SUM(bundle_quantity) as bundle_quantity,
						SUM(good_quantity) as good_quantity,SUM(rejected_quantity) as rejected_quantity
						FROM $bai_pro3.mo_details mo 
						LEFT JOIN $bai_pro3.mo_operation_quantites mop ON mo.mo_no = mop.mo_no  
						WHERE TRIM(size)='$mo_size' and schedule='$schedule' and TRIM(color)='$color' 
						and mop.op_code = 15
						group by mop.mo_no
						order by mo.mo_no*1"; 			
		$mo_no_result  = mysqli_query($link,$mo_no_query);
		$mo_no_result2 = $mo_no_result;   
		while($row = mysqli_fetch_array($mo_no_result)){
			// if($row['op_desc'] == 'recut' )
			// 	continue;l
			//$mos[] = $row['mo_no'];	
			if($row['bundle_quantity'] >= $row['good_quantity'] && $row['rejected_quantity']==0)	
				continue;
			if($row['rejected_quantity'] == 0)
				$mos[$row['mo_no']] = $row['mo_quantity'] - $row['bundle_quantity'];
			else	
				$mos[$row['mo_no']] = $row['mo_quantity'] - $row['bundle_quantity'] + $row['rejected_quantity'];
		}
	
		//getting the recut quantity for the particular size 
		$qty_query = "Select (a_plies * a_$sizet) as qty,acutno from $bai_pro3.recut_v2 where doc_no = '$doc_no' ";
		$qty_result = mysqli_query($link,$qty_query);
		while($row  = mysqli_fetch_array($qty_result)){
			$qty = $row['qty'];
			$acut_no = $row['acutno'];
		}

		foreach($mos as $mo_no => $rej_qty){
			$last_mo = $mo_no;
			$qty = $qty - $rej_qty;
			if( $qty >= 0){
				$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
							(`date_time`, `mo_no`, `doc_no`,`bundle_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES 
							(".date('Y-m-d H:i:s').",$mo_no,$doc_no,$acut_no,$rej_qty,$op_code,'recut')";
				mysqli_query($link,$insert_query) or exit('error 1');
			}else{
				$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
							(`date_time`, `mo_no`, `doc_no`,`bundle_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES 
							(".date('Y-m-d H:i:s').",$mo_no,$doc_no,$acut_no,$qty,$op_code,'recut')";
				mysqli_query($link,$insert_query) or exit('error 2');
				break;
			}	
		}
		// 	inserting excess quantity to the last mo 
		if($qty >= 0){
			$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
						(`date_time`, `mo_no`, `doc_no`,`bundle_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES 
						(".date('Y-m-d H:i:s').",$last_mo,$doc_no,$acut_no,$qty,$op_code,'recut')";
			mysqli_query($link,$insert_query) or exit('error 3');	
			unset($mos);
		}
	}

	echo "<h2>Successfully Updated</h2>";



	//---------------------------------------MO Filling Ends------------------------------------------------------------------	
}

?>

</body>
</html>

