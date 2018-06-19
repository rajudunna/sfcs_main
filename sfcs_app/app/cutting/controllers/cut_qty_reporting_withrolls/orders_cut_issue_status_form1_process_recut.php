<?php 
//KiranG - 2015-09-02 : passing link as parameter in update_m3_or function to avoid missing user name.
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
?>

<?php

//function to update M3 Bulk OR
function update_m3_or($doc_no,$plies,$operation,$link)
{
	//include("dbconf.php"); 
	//include("functions.php"); 
	
	$size_code_db=array('xs','s','m','l','xl','xxl','xxxl','s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');
	$size_qty=array();
	
	$sql="select * from $bai_pro3.order_cat_recut_doc_mix where doc_no=\"$doc_no\" and remarks in ('Body','Front')"; //20110911
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$size_qty[]=$sql_row['a_xs']*$plies;
		$size_qty[]=$sql_row['a_s']*$plies;
		$size_qty[]=$sql_row['a_m']*$plies;
		$size_qty[]=$sql_row['a_l']*$plies;
		$size_qty[]=$sql_row['a_xl']*$plies;
		$size_qty[]=$sql_row['a_xxl']*$plies;
		$size_qty[]=$sql_row['a_xxxl']*$plies;
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
		$order_tid=$sql_row['order_tid'];
		$jobno=$sql_row['acutno'];
	}
	
	
	
	
	//validation to exclude non primary components (Gusset)
	$other_docs=mysqli_num_rows($sql_result);
	
	$sql111="select order_style_no,order_del_no,order_col_des,color_code from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row111=mysqli_fetch_array($sql_result111))
	{
		$style=$sql_row111['order_style_no'];
		$schedule=$sql_row111['order_del_no'];
		$color=$sql_row111['order_col_des'];
		$job='R'.leading_zeros($jobno,3);		
	}
	
	$check=0;
	$query_array=array();

	if($other_docs>0)
	{
		for($i=0;$i<sizeof($size_code_db);$i++)
		{
			//validation to report previous operation. //kirang 2015-10-14
			$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='".$size_code_db[$i]."' and sfcs_doc_no='$doc_no' and m3_op_des='LAY' and sfcs_status<>90";
			//$sql_result1112=mysql_query($sql111,$link) or exit("Sql Error".mysql_error());
			
			
			//Validation to avoid duplicates
			$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='".$size_code_db[$i]."' and sfcs_doc_no='$doc_no' and sfcs_qty=".$size_qty[$i]." and m3_op_des='$operation'";
			$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			if($size_qty[$i]>0 and mysqli_num_rows($sql_result111)==0 )
			{
								
				//$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_job_no) values (NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,'$job')"; 
			
				//echo $sql."<br/>";
				//mysql_query($sql1,$link) or exit("Sql Error6$sql1".mysql_error());
				
				$query_array[]="(NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,'$job')";
				
				if($check==0)
				{
					$check=1;
				}
			}
		}
		
	
	}
	
	if($check==1 OR $other_docs==0)
	{
		for($j=0;$j<sizeof($query_array);$j++)
		{
			$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_job_no) values ".$query_array[$j]; 
			
				//echo $sql."<br/>";
				mysqli_query($link, $sql1) or exit("Sql Error6$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		
	$sql="update $bai_pro3.recut_v2 set act_cut_status=\"DONE\" where doc_no=$doc_no";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		return 'TRUE';
	}
	else
	{
		return 'FALSE';
	}
	
	
}

?>

<?php

if(isset($_POST['Update']))
{


$input_date=$_POST['date'];
$input_section=$_POST['section'];
$input_shift=$_POST['shift'];
$input_fab_rec=$_POST['fab_rec'];
$input_fab_ret=$_POST['fab_ret'];
$input_damages=$_POST['damages'];
$input_shortages=$_POST['shortages'];
$input_remarks=$_POST['remarks'];
$input_doc_no=$_POST['doc_no'];
$tran_order_tid=$_POST['tran_order_tid'];

$plies=$_POST['plies'];
$old_plies=$_POST['old_plies'];

$old_input_fab_rec=$_POST['old_fab_rec'];
$old_input_fab_ret=$_POST['old_fab_ret'];
$old_input_damages=$_POST['old_damages'];
$old_input_shortages=$_POST['old_shortages'];

if(strlen($_POST['remarks'])>0)
{
	$input_remarks=$_POST['remarks']."$".$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages;
}
else
{
	$input_remarks=$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages;
}

$input_fab_rec+=$old_input_fab_rec;
$input_fab_ret+=$old_input_fab_ret;
$input_damages+=$old_input_damages;
$input_shortages+=$old_input_shortages;



if($plies>0)
{
	
	
	
		
	
	$ret=update_m3_or($input_doc_no,$plies,'CUT',$link);
	
	if($ret=="TRUE")
	{
		
		$sql="insert ignore into $bai_pro3.act_cut_status_recut_v2 (doc_no) values ($input_doc_no)";
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

		$sql="update $bai_pro3.ct_cut_status_recut_v2 set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=$input_fab_rec, fab_returned=$input_fab_ret, damages=$input_damages, shortages=$input_shortages, remarks=\"$input_remarks\" where doc_no=$input_doc_no";
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		$sql="update $bai_pro3.recut_v2 set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies)." where doc_no=$input_doc_no";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

}



}
//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"orders_cut_issue_status_list.php?tran_order_tid=$tran_order_tid\"; }</script>";
$url = getFullURL($_GET['r'],'doc_track_panel_recut.php','N');
echo "<script>sweetAlert('Updated Successfully','','success')</script>";
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"$url\"; }</script>";

?>

