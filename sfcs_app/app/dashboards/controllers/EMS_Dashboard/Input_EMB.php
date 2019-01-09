<?php

// Service Request #938009 // kirang // 2015-05-09 // Schedule and Size level Validation Applied to Garment Cartons Reporting

?>

<?php
set_time_limit(2000);
?>
<?php include("../../dbconf.php"); ?>
<?php include("functions2.php"); 
//$module=$_GET['module'];
?>
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/user_acl_v1.php"); 
include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
$view_access=user_acl("SFCS_0200",$username,1,$group_id_sfcs); 
$authorized=user_acl("SFCS_0200",$username,50,$group_id_sfcs); 

//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
//$authorized=array("kirang","kirang","roshanm","baiemb","malleswararaog","prabhakarg","swatikumariv","varalaxmib");
?>

<html>
<head>
<title>POP - Embellishment Input Track Panel</title>
<?php include("header_scripts.php"); ?>



<style>

body
{
	font-family:arial;
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

<!--<h2>Embellishment Input Track Panel</h2>-->
<div id="page_heading"><span style="float: left"><h3>Embellishment Input Track Panel</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

//var message="Function Disabled!";

///////////////////////////////////
// function clickIE4(){
// if (event.button==2){
// alert(message);
// return false;
// }
// }

// function clickNS4(e){
// if (document.layers||document.getElementById&&!document.all){
// if (e.which==2||e.which==3){
// alert(message);
// return false;
// }
// }
// }

// if (document.layers){
// document.captureEvents(Event.MOUSEDOWN);
// document.onmousedown=clickNS4;
// }
// else if (document.all&&!document.getElementById){
// document.onmousedown=clickIE4;
// }

// document.oncontextmenu=new Function("alert(message);return false")

// --> 
</script>
<form name="input" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
Enter Carton Label ID: <input type="text" name="label_id" value=""><input type="submit" name="search" value="Search">
</form>
<?php

//To update a log, to count number of instances where system contact m3 server for data.
$myfile = fopen("emb_log.csv", "a") or die("Unable to open file!");



if(isset($_POST['transfer']))
{
	$label=$_POST['label'];
	$schedule=$_POST['schedule'];
	
		$tid_ref_array=array();
		$sql1="SELECT doc_no_ref from pac_stat_log where tid=$label";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$doc_no_ref=$sql_row1['doc_no_ref'];
		}
		
		//echo $doc_no_ref;
		$sql1="SELECT tid from pac_stat_log where doc_no_ref='$doc_no_ref'  AND (STATUS<>'EGS' OR STATUS IS NULL OR STATUS='')";
		//echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$tid_ref_array[]=$sql_row1['tid'];
		}
		
		//print_r($tid_ref_array);
		
	$sql1="update pac_stat_log set status=\"EGS\" where tid in (".implode(",",$tid_ref_array).")  AND (STATUS<>'EGS' OR STATUS IS NULL OR STATUS='')";
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	
	
	
	
	//To track log
	$txt = "EGS,$username,$label,".date("Y-m-d H:i:s").",".date("Y-m-d")."\n";
	fwrite($myfile, $txt);

	echo "<script type=\"text/javascript\"> window.close(); </script>";
}

if(isset($_POST['received']))
{
	$label=$_POST['label'];
	$schedule=$_POST['schedule'];
	
		$tid_ref_array=array();
		$sql1="SELECT doc_no_ref from pac_stat_log where tid=$label";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$doc_no_ref=$sql_row1['doc_no_ref'];
		}
		
		$sql1="SELECT tid from pac_stat_log where doc_no_ref='$doc_no_ref' AND (STATUS<>'EGR' OR STATUS IS NULL OR STATUS='')";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$tid_ref_array[]=$sql_row1['tid'];
		}
		
	
	
	
	if(sizeof($tid_ref_array)>0)
	{
		//M3 Bulk Upload
		$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,carton_act_qty,USER(),'ASPS',tid FROM bai_pro3.packing_summary WHERE tid in (".implode(",",$tid_ref_array).") AND tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule=$schedule and  m3_op_des='ASPS')";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//SR#20981688 -KiranG 20150805 Changed the sequence of execution to avoid missing of data in M3 Log
		
		$sql1="update pac_stat_log set status=\"EGR\" where tid in (".implode(",",$tid_ref_array).") AND (STATUS<>'EGR' OR STATUS IS NULL OR STATUS='')";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	
	
	//To track log
	$txt = "EGR,$username,$label,".date("Y-m-d H:i:s").",".date("Y-m-d")."\n";
	fwrite($myfile, $txt);
	
	echo "<script type=\"text/javascript\"> window.close(); </script>";
}

if(isset($_POST['complete']))
{
	$label=$_POST['label'];
	$schedule=$_POST['schedule'];
	
		$tid_ref_array=array();
		$sql1="SELECT doc_no_ref from pac_stat_log where tid=$label";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$doc_no_ref=$sql_row1['doc_no_ref'];
		}
		
		$sql1="SELECT tid from pac_stat_log where doc_no_ref='$doc_no_ref' AND (STATUS<>'EGI' OR STATUS IS NULL OR STATUS='')";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$tid_ref_array[]=$sql_row1['tid'];
		}
		
	
	
	if(sizeof($tid_ref_array)>0)
	{
		//M3 Bulk Upload
		$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref) SELECT NOW(),order_style_no,order_del_no,order_col_des,size_code,doc_no,carton_act_qty,USER(),'ASPR',tid FROM bai_pro3.packing_summary WHERE tid in (".implode(",",$tid_ref_array).") AND tid NOT IN (SELECT sfcs_tid_ref FROM m3_bulk_ops_rep_db.m3_sfcs_tran_log WHERE sfcs_schedule=$schedule and  m3_op_des='ASPR')";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//SR#20981688 -KiranG 20150805 Changed the sequence of execution to avoid missing of data in M3 Log
		$sql1="update pac_stat_log set status=\"EGI\" where tid in (".implode(",",$tid_ref_array).") AND (STATUS<>'EGI' OR STATUS IS NULL OR STATUS='')";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	
	//To track log
	$txt = "EGI,$username,$label,".date("Y-m-d H:i:s").",".date("Y-m-d")."\n";
	fwrite($myfile, $txt);
	echo "<script type=\"text/javascript\"> window.close(); </script>";
}

//To track log
fclose($myfile);

if(isset($_POST['search']) or isset($_GET['label_id']))
{
	if(isset($_POST['search']))
{
	$lable_id=$_POST['label_id'];
	}
	if(isset($_GET['label_id']))
{	$lable_id=$_GET['label_id'];	}

	

	$sql1="SELECT * from packing_summary where tid=$lable_id";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		echo "<table>";
		echo "<tr><td>Style</td><td>:</td><td>".$sql_row1['order_style_no']."</td></tr>";
		echo "<tr><td>Schedule</td><td>:</td><td>".$sql_row1['order_del_no']."</td></tr>";
		echo "<tr><td>Color</td><td>:</td><td>".$sql_row1['order_col_des']."</td></tr>";
		echo "<tr><td>Carton ID</td><td>:</td><td>".$sql_row1['tid']."</td></tr>";
		echo "<tr><td>Size</td><td>:</td><td>".$sql_row1['size_code']."</td></tr>";
		echo "<tr><td>Quantity</td><td>:</td><td>".$sql_row1['carton_act_qty']."</td></tr>";
		
		echo $sql_row1['status'];
		
		if($sql_row1['status']=="DONE")
		{
			echo "Carton Already Scanned";
		}
					
		$sql1zz="SELECT order_del_no from bai_orders_db_confirm where (order_embl_e+order_embl_f)>0 and order_del_no=".$sql_row1['order_del_no'];
		$sql_result1zz=mysqli_query($link, $sql1zz) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		// Service Request #938009 // kirang // 2015-05-09 // Schedule and Size level Validation Applied to Garment Cartons Reporting
		
		$sql_output="select sum(ims_pro_qty) as out1 from ims_log where ims_schedule=\"".$sql_row1['order_del_no']."\" and ims_color=\"".$sql_row1['order_col_des']."\" and ims_size=\"a_".$sql_row1['size_code']."\"";
		//echo $sql_output."<br>";
		$sql_result_output=mysqli_query($link, $sql_output) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_output=mysqli_fetch_array($sql_result_output))
		{
			$out=$sql_row_output["out1"];
		}
		//echo "<br>".$out."<br>";
		$sql_output1="select sum(ims_pro_qty) as out1 from ims_log_backup where ims_schedule=\"".$sql_row1['order_del_no']."\" and ims_color=\"".$sql_row1['order_col_des']."\" and ims_size=\"a_".$sql_row1['size_code']."\"";
		//echo $sql_output1."<br>";
		$sql_result_output1=mysqli_query($link, $sql_output1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_output1=mysqli_fetch_array($sql_result_output1))
		{
			$out1=$sql_row_output1["out1"];
		}
		//echo "<br>".$out1."<br>";
		$sql_pac="select sum(carton_act_qty) as pac_aty from packing_summary where order_del_no=\"".$sql_row1['order_del_no']."\" and order_col_des=\"".$sql_row1['order_col_des']."\" and size_code=\"".$sql_row1['size_code']."\" and length(status)>0";
		//echo $sql_pac."<br>";
		$sql_result_pac=mysqli_query($link, $sql_pac) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_pac=mysqli_fetch_array($sql_result_pac))
		{
			$pac_qty=$sql_row_pac["pac_aty"];
		}
		//echo "<br>".($out+$out1)."-".$pac_qty."<br>";
		$balance=($out+$out1)-$pac_qty;
		
		// Service Request #938009 // kirang // 2015-05-09 // Schedule and Size level Validation Applied to Garment Cartons Reporting
		
		//echo "<br>".$out."-".$out1."-".$pac_qty."-".$balance."-".$sql_row1['carton_act_qty']."<br>";
			
		if(mysqli_num_rows($sql_result1zz)>0){
			
			//if($sql_row1['disp_carton_no']==1)
			if($balance >= $sql_row1['carton_act_qty'] || $sql_row1['status']=="EGS" || $sql_row1['status']=="EGR")
			{
				echo "<tr><td colspan=4><form name=\"test\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"><br/><br/>";
				
				if($sql_row1['status']=="")
				{
					echo "<input type=\"submit\" name=\"transfer\" value=\"Send for Embellishment / Printing\">";
				}
				if($sql_row1['status']=="EGS" and in_array($username,$authorized))
				{
					echo "<input type=\"submit\" name=\"received\" value=\"Confirm Received\">";
				}
				if($sql_row1['status']=="EGR" and in_array($username,$authorized))
				{
					echo "<input type=\"submit\" name=\"complete\" value=\"Confirm Completed and Returned\">";
				}
	
				echo "<input type=\"hidden\" name=\"label\" value=\"".$sql_row1['tid']."\">
					<input type=\"hidden\" name=\"schedule\" value=\"".$sql_row1['order_del_no']."\">
				</form></td></tr>";
			}																	
			else
			{
				echo "<tr><td colspan=4><br/><br/><strong>Alert: Output is yet to report. Please contact IE Team.</strong></td></tr>";
			}
		}else{
			echo "<tr><td colspan=4><br/><br/><strong>Alert: This carton is not belongs to embellishment.</strong></td></tr>";
		}
			
			
		echo "</table>";
	}
}
?>


</body>
</html>