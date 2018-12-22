<?php

//Service Request #191876 // kirang // 2015-04-09 // Embellishment Input Reporting and Recut Request AccesS.swatikumariv,varalaxmib

?>
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php"); 
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
$view_access=user_acl("SFCS_0200",$username,1,$group_id_sfcs); 
$authorized=user_acl("SFCS_0200",$username,49,$group_id_sfcs); 
include($_SERVER['DOCUMENT_ROOT']."M3_Bulk_OR/ims_size.php");
?>
<?php
set_time_limit(2000);
?>
<?php include("../../dbconf.php"); ?>
<?php include("functions2.php"); ?>

<html>
<head>
<title>POP - Embellishment Track Panel</title>
<?php include("header_scripts.php"); 
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
//$authorized=array("kirang","kirang","roshanm","bainet","baiadmn","baiemb","malleswararaog","prabhakarg","swatikumariv","varalaxmib");
?>



<style>

body{
	font-family:calibri;
}

a {text-decoration: none;}

.atip
{
	color:black;
}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom
{
	border-bottom: 3px solid white;
	padding-bottom: 5px;
	padding-top: 5px;
}


</style>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

</head>

<body>

<?php

if(isset($_POST['confirm_rec']))
{
	$module_ref=$_POST['module'];
	$ims_doc_no_ref=$_POST['doc_no'];
	$rand_track=$_POST['rand_no'];
	
	
	$sql1="update ims_log set ims_status=\"EPR\" where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\"";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	
	echo "<script type=\"text/javascript\"> window.close(); </script>";
}

?>

<?php
//Function to Validate M3 Entries

function m3_validate_ems($link,$tid,$doc_no,$operation)
{
	
	$sql111="SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_doc_no='$doc_no' AND sfcs_tid_ref=$tid AND m3_op_des='$operation'";
	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	return mysqli_num_rows($sql_result111);
}

?>

<?php

if(isset($_POST['confirm_issue']))
{
	$module_ref=$_POST['module'];
	$ims_doc_no_ref=$_POST['doc_no'];
	$input_doc_no=$_POST['doc_no'];//
	$rand_track=$_POST['rand_no'];
	$new_module=$_POST['new_module'];
	$input_module=$_POST['new_module'];//
	//$tid=implode(",",$_POST['tid']); //Old Model
	$tid=$_POST['tid'];
	$tid1=$_POST['tid1'];
	$input_date=date("Y-m-d");//
	$input_shift=$_POST['new_shift'];//
	$input_remarks=$_POST['remarks'];
	
	$new_qty=$_POST['new_qty'];
	$avl_qty=$_POST['avl_qty'];
	
	$tot_rows=$_POST['tot_rows'];
	$chk_box=$_POST['chk_box'];
	
	$new_qty1=$_POST['new_qty1']; //For Partial Input Update
	$avl_qty1=$_POST['avl_qty1']; //For Partial Input Update
	
	
	if(sizeof($tid1)>0)
	{
		for($i=0;$i<sizeof($tid1);$i++)
		{
			if($new_qty[$i]!=$avl_qty[$i] and $new_qty[$i]>0)
			{
				$diff=$avl_qty[$i]-$new_qty[$i];
				
				$sql1="insert into  ims_log (ims_date, ims_cid, ims_doc_no, ims_mod_no, ims_shift, ims_size, ims_qty, ims_pro_qty, ims_status, bai_pro_ref, ims_log_date, ims_remarks, ims_style, ims_schedule, ims_color, rand_track) select ims_date, ims_cid, ims_doc_no, ims_mod_no, ims_shift, ims_size, ims_qty, ims_pro_qty, ims_status, bai_pro_ref, ims_log_date, ims_remarks, ims_style, ims_schedule, ims_color, rand_track from ims_log where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid=".$tid1[$i];
				echo "query1".$sql1."<br/>";
				//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
				$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				
				$sql1="update  ims_log set ims_qty=$diff where tid=".$iLastid;
				echo "query2".$sql1."<br/>";
				//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
				$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
				
							
				$sql1="update ims_log set ims_status=\"EPC\", ims_qty=".$new_qty[$i]." where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid=".$tid1[$i];
				echo "query3".$sql1."<br/>";
				//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
				
				if(m3_validate_ems($link,$tid1[$i],$ims_doc_no_ref,'PR')==0)
				{
					//TO update M3 Bulk OR (Print Received)
					$sql="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) select NOW(),ims_style,ims_schedule,ims_color,REPLACE(ims_size,'a_',''),ims_doc_no,".$new_qty[$i].",USER(),'PR',tid,'','' from bai_pro3.ims_log where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid=".$tid1[$i]." AND tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_doc_no='$ims_doc_no_ref' AND m3_op_des='PR')"; 
					
					echo "query4".$sql."<br/>";
					//mysql_query($sql,$link) or exit("Sql Error6$sql".mysql_error());
				}
				
			}
			else
			{
				$sql1="update ims_log set ims_status=\"EPC\" where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid=".$tid1[$i];
				echo "query5".$sql1."<br/>";
				//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
				
				if(m3_validate_ems($link,$tid1[$i],$ims_doc_no_ref,'PR')==0)
				{
					//TO update M3 Bulk OR (Print Received)
					$sql="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) select NOW(),ims_style,ims_schedule,ims_color,REPLACE(ims_size,'a_',''),ims_doc_no,ims_qty,USER(),'PR',tid,'','' from bai_pro3.ims_log where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid=".$tid1[$i]." AND tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_doc_no='$ims_doc_no_ref' AND m3_op_des='PR')"; 
					
					echo "query6".$sql."<br/>";
					//mysql_query($sql,$link) or exit("Sql Error6$sql".mysql_error());
				}
			}
		}
		
	}
	
	//if($new_module>0 and sizeof($tid)>0)
    if(sizeof($tid)>0)
	{
		
		//Old Mode of updating Issued Values.
		//$sql1="update ims_log set ims_status=\"EPI\", ims_mod_no=$new_module where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid in ($tid)";
		//mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
		for($i=0;$i<$tot_rows;$i++)
		{
			//echo $i."--Test--".$chk_box[$i]."--Val<br>";
			if($chk_box[$i]>0)
			{
				//echo "<br/>data".$new_qty1[$i]."--".$avl_qty1[$i]."--".$new_qty1[$i]."<br/>";
				if($new_qty1[$i]!=$avl_qty1[$i] and $new_qty1[$i]>0)
				{
					$diff=$avl_qty1[$i]-$new_qty1[$i];
					
					$sql1="insert into  ims_log (ims_date, ims_cid, ims_doc_no, ims_mod_no, ims_shift, ims_size, ims_qty, ims_pro_qty, ims_status, bai_pro_ref, ims_log_date, ims_remarks, ims_style, ims_schedule, ims_color, rand_track) select ims_date, ims_cid, ims_doc_no, ims_mod_no, ims_shift, ims_size, ims_qty, ims_pro_qty, ims_status, bai_pro_ref, ims_log_date, ims_remarks, ims_style, ims_schedule, ims_color, rand_track from ims_log where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid=".$tid[$i];
					echo "query7".$sql1."<br/>";
					mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					
					$sql1="update  ims_log set ims_qty=$diff where tid=".$iLastid;
					echo "query8".$sql1;
					mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
					
								
					$sql1="update ims_log set ims_date='".date("Y-m-d")."',ims_status=\"EPI\",ims_remarks='$input_remarks', ims_mod_no=$new_module, ims_qty=".$new_qty1[$i]." where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid=".$tid[$i];
					echo "query9".$sql1."<br/>";
					mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					if(m3_validate_ems($link,$tid[$i],$ims_doc_no_ref,'SIN')==0 && $new_module>0)
					{
						//TO update M3 Bulk OR (Input Issued to Module)
						$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) select NOW(),ims_style,ims_schedule,ims_color,REPLACE(ims_size,'a_',''),ims_doc_no,ims_qty,USER(),'SIN',tid,ims_mod_no,ims_shift from bai_pro3.ims_log where rand_track=\"$rand_track\" and tid=".$tid[$i]." AND tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_doc_no='$ims_doc_no_ref' AND m3_op_des='SIN')"; 
						
						if($input_remarks=="SAMPLE" or $input_remarks=="SHIPMENT_SAMPLE")
						{
							$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select NOW(),ims_style,ims_schedule,ims_color,REPLACE(ims_size,'a_',''),ims_doc_no,ims_qty,USER(),'SIN',tid,ims_mod_no,ims_shift,'SAMPLE' from bai_pro3.ims_log where rand_track=\"$rand_track\" and tid=".$tid[$i]." AND tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_doc_no='$ims_doc_no_ref' AND m3_op_des='SIN')"; 
						}
						
						echo "query10".$sql1."<br/>";
						mysqli_query($link, $sql1) or exit("Sql Error6$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
				else
				{
					$sql1="update ims_log set ims_date='".date("Y-m-d")."',ims_status=\"EPI\",ims_remarks='$input_remarks', ims_mod_no=$new_module where ims_mod_no=\"$module_ref\" and ims_doc_no=\"$ims_doc_no_ref\" and rand_track=\"$rand_track\" and tid=".$tid[$i];
					echo "query11".$sql1."<br/>";
					mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					if(m3_validate_ems($link,$tid[$i],$ims_doc_no_ref,'SIN')==0 && $new_module>0)
					{
						//TO update M3 Bulk OR (Input Issued to Module)
						$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) select NOW(),ims_style,ims_schedule,ims_color,REPLACE(ims_size,'a_',''),ims_doc_no,ims_qty,USER(),'SIN',tid,ims_mod_no,ims_shift from bai_pro3.ims_log where rand_track=\"$rand_track\" and tid=".$tid[$i]." AND tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_doc_no='$ims_doc_no_ref' AND m3_op_des='SIN')"; 
						
						if($input_remarks=="SAMPLE" or $input_remarks=="SHIPMENT_SAMPLE")
						{
							$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) select NOW(),ims_style,ims_schedule,ims_color,REPLACE(ims_size,'a_',''),ims_doc_no,ims_qty,USER(),'SIN',tid,ims_mod_no,ims_shift,'SAMPLE' from bai_pro3.ims_log where rand_track=\"$rand_track\" and tid=".$tid[$i]." AND tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_doc_no='$ims_doc_no_ref' AND m3_op_des='SIN')"; 
						}
						
						echo "query12".$sql1."<br/>";
						mysqli_query($link, $sql1) or exit("Sql Error6$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}
		}
		//to clear planning board
		
		//NEW to Eliminate duplicates
	
		//$sql="select sum(ims_qty) as \"qty\" from ims_log where ims_doc_no=$input_doc_no";
		$sql="SELECT (SELECT COALESCE(SUM(ims_qty),0) AS \"qty\" FROM ims_log WHERE ims_doc_no=$input_doc_no and ims_mod_no>-1)+ (SELECT COALESCE(SUM(ims_qty),0) AS \"qty\" FROM ims_log_backup WHERE ims_doc_no=$input_doc_no and ims_mod_no>-1) AS \"qty\"";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$check_qty=$sql_row['qty'];
		}
		
		$sql="select sum((a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s06+a_s08+a_s10+a_s12+a_s14+a_s16+a_s18+a_s20+a_s22+a_s24+a_s26+a_s28+a_s30)*p_plies) as \"qty\" from plandoc_stat_log where doc_no=$input_doc_no"; //20110911
		//echo $sql;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$doc_qty=$sql_row['qty'];
		}
		
		if($check_qty==$doc_qty)
		{
			$sql="insert ignore into act_cut_issue_status (doc_no, date, mod_no, remarks, shift) values ($input_doc_no, \"$input_date\", $input_module, \"$input_remarks\", \"$input_shift\")";
			echo "query13".$sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
			$sql="update plandoc_stat_log set act_cut_issue_status=\"DONE\" where doc_no=$input_doc_no";
			echo "query14".$sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql="delete from plan_dashboard where doc_no=$input_doc_no";
			echo "query15".$sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		//to clear planning board
	}
	
	
	
	echo "<script type=\"text/javascript\"> window.close(); </script>";
}

?>


<?php
$module_ref=$_GET['module'];
$ims_doc_no_ref=$_GET['doc_ref'];
$rand_track=$_GET['rand_track'];
$check_new=0;
$sql22="select * from plandoc_stat_log where doc_no=$ims_doc_no_ref and a_plies>0";
mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row22=mysqli_fetch_array($sql_result22))
{
	$order_tid=$sql_row22['order_tid'];
	
	$sql33="select * from bai_orders_db where order_tid=\"$order_tid\"";
	mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row33=mysqli_fetch_array($sql_result33))
	{
		$color_code=$sql_row33['color_code']; //Color Code
		$emb_a=$sql_row33['order_embl_a'];
		$emb_b=$sql_row33['order_embl_b'];
	}
	$cutno=$sql_row22['acutno'];
}

	echo "<form name=\"input\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
	//echo "<h2>Embellishment - CUT No: ".chr($color_code).leading_zeros($cutno,3)." Summary</h2>";
	echo '<div id="page_heading"><span style="float: left"><h3>Embellishment - CUT No: '.chr($color_code).leading_zeros($cutno,3).' Summary</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>';
	echo '<table style="color:black; border: 1px solid red;">';
	echo "<tr class=\"new\"><th>TID</th><th>Style</th><th>Schedule</th><th>Color</th><th>CID</th><th>DOC#</th><th>Cut No</th><th>Size</th><th>Input</th><th>Status / Quantity</th></tr>";
	$i=0;
	$sql1="SELECT rand_track, ims_doc_no, ims_status FROM ims_log WHERE ims_mod_no=$module_ref AND ims_doc_no=$ims_doc_no_ref AND rand_track=$rand_track AND ims_status <> \"DONE\" group by rand_track";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result1);
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$ims_doc_no=$sql_row1['ims_doc_no'];
		$ims_status=$sql_row1['ims_status'];
		

	
					
		$sql12="select * from ims_log where ims_mod_no=$module_ref and rand_track=$rand_track";
		//echo $sql12;
		mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			$additions="";
			$color="";
			if($sql_row12['ims_status']=="EPR")
			{
				$additions="<input type=\"checkbox\" name=\"tid1[]\" value=\"".$sql_row12['tid']."\"> <input type=\"text\" name=\"new_qty[]\" value=\"".$sql_row12['ims_qty']."\" onchange=\"if(this.value<0 || this.value>".$sql_row12['ims_qty'].") {alert('Please Enter Correct Value'); this.value=".$sql_row12['ims_qty']."; }\" size=5> <input type=\"hidden\" name=\"avl_qty[]\" value=\"".$sql_row12['ims_qty']."\">";
				$check_new=1;
			}
			
			if($sql_row12['ims_status']=="EPC")
			{
				$additions="<input type=\"checkbox\" name=\"chk_box[".$i."]\" value=\"1\"><input type=\"hidden\" name=\"tid[".$i."]\" value=\"".$sql_row12['tid']."\"><input type=\"text\" name=\"new_qty1[".$i."]\" value=\"".$sql_row12['ims_qty']."\" onchange=\"if(this.value<0 || this.value>".$sql_row12['ims_qty'].") {alert('Please Enter Correct Value'); this.value=".$sql_row12['ims_qty']."; }\" size=5> <input type=\"hidden\" name=\"avl_qty1[".$i."]\" value=\"".$sql_row12['ims_qty']."\">";
				$check_new=1;
				$color=" bgcolor=#00FF11";
			}
			$size_value=ims_sizes('',$sql_row12['ims_schedule'],$sql_row12['ims_style'],$sql_row12['ims_color'],strtoupper(substr($sql_row12['ims_size'],2)),$link);
			//echo "<tr class=\"new\"><td>".$sql_row12['tid']."</td><td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".strtoupper(str_replace("a_","",$sql_row12['ims_size']))."</td><td>".$sql_row12['ims_qty']."</td><td $color>".$sql_row12['ims_status']."$additions</td></tr>";
			echo "<tr class=\"new\"><td>".$sql_row12['tid']."</td><td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".$size_value."</td><td>".$sql_row12['ims_qty']."</td><td $color>".$sql_row12['ims_status']."$additions</td></tr>";
			$i++;
		}
		echo "<input type=\"hidden\" name=\"tot_rows\" value=\"".$i."\">";
		if($emb_a>0 or $emb_b>0)
		{
			$sql12="select * from ims_log_backup where rand_track=$rand_track and ims_mod_no=0";
			mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row12=mysqli_fetch_array($sql_result12))
			{
				$size_value=ims_sizes('',$sql_row12['ims_schedule'],$sql_row12['ims_style'],$sql_row12['ims_color'],strtoupper(substr($sql_row12['ims_size'],2)),$link);
				//echo "<tr class=\"new\"><td>".$sql_row12['tid']."</td><td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".$sql_row12['ims_size']."</td><td>".$sql_row12['ims_qty']."</td><td>Excess</td></tr>";
				echo "<tr class=\"new\"><td>".$sql_row12['tid']."</td><td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td><td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".$size_value."</td><td>".$sql_row12['ims_qty']."</td><td>Excess</td></tr>";
			}
		}
		echo "</table>";
	}
	
	if($check_new==1 and in_array($username,$authorized))
	{
		
		echo "Module:";
		echo "<select name=\"new_module\">";
		echo "<option value=\"-1\"></option>";
		echo "<option value=\"0\">0</option>";
		//Date 2013-09-19
		//Dispaly Modules based on sections
		$sql="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS mods FROM bai_pro3.module_master WHERE section NOT IN (0,-1) ORDER BY section";
		//echo $sql;
		$result7=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($result7))
		{
			$sql_mod=$sql_row["mods"];
		}

		$sql_mods=explode(",",$sql_mod);

		for($i=0;$i<sizeof($sql_mods);$i++)
		{
			echo "<option value=\"".$sql_mods[$i]."\">".$sql_mods[$i]."</option>";
		}
		echo "</select>";
		
		echo "Shift:";
		echo "<select name=\"new_shift\">";
		echo "<option value=\"A\">A</option>";
		echo "<option value=\"B\">B</option>";
		echo "</select>";
		
		echo "Remarks: <select name=\"remarks\"><option value='nil'>nil</option><option value='SAMPLE'>SAMPLE</option><option value='SHIPMENT_SAMPLE'>SHIPMENT_SAMPLE</option></select>";
		
		echo "<input type=\"hidden\" name=\"module\" value=\"$module_ref\">";
		echo "<input type=\"hidden\" name=\"doc_no\" value=\"$ims_doc_no_ref\">";
		echo "<input type=\"hidden\" name=\"rand_no\" value=\"$rand_track\">";
		echo "<input type=\"submit\" name=\"confirm_issue\" value=\"Confirm - Complete/Issue\">";	
	}
	echo "</form>";
	
	if($ims_status=="EPS" and in_array($username,$authorized))
	{
		echo "<form name=\"input\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
		echo "<input type=\"hidden\" name=\"module\" value=\"$module_ref\">";
		echo "<input type=\"hidden\" name=\"doc_no\" value=\"$ims_doc_no_ref\">";
		echo "<input type=\"hidden\" name=\"rand_no\" value=\"$rand_track\">";
		echo "<input type=\"submit\" name=\"confirm_rec\" value=\"Confirm - Received\">";	
		echo "</form>";
	}


?>

</body>
</html>

