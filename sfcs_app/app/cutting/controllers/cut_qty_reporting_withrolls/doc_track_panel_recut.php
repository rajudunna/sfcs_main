<?php
	//require_once('../phplogin/auth2.php');
?>
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
?>

<!-- <style>
body
{
	font-family:arial;
	font-size:14px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align:left;
	vertical-align:top;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:14px;
}


</style> -->
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R')); ?>
</head>

<div class="panel panel-primary">
<div class="panel-heading">Recut Status Reporting</div>
<div class="panel-body">
<?php //include("../menu_content.php"); ?>


<form method="post" name="input" action="<?php echo getFullURL($_GET['r'],'doc_track_panel_recut.php','N'); ?>">
<div class="row">
<div class="col-md-3">
<label>Enter Recut- Docket Number: </label>
<input type="text" name="docket_id" size=15 class="form-control integer swal">
</div>
<div class="col-md-3">
<input type="submit" value="search" name="submit" class="btn btn-primary" style="margin-top:22px;">
</div>
<div class="col-md-3 col-md-offset-3">
<a href="<?= getFullURLLevel($_GET['r'],'doc_track_panel.php',0,'N')?>" class="btn btn-info btn-sm pull-right" style="margin-top:22px;">Go to Cut Status Reporting >> </a>
</div>
</div>
<!--
Enter Recut- CID Number: <input type="text" name="cid" size=15>
<input type="submit" value="search" name="submit2"> -->
</form>



<?php

if(isset($_POST['submit']))
{
	echo "<hr/>";
	$docket_id=$_POST['docket_id'];
	
	
	if($docket_id>0)
	{
		
	
	$sql="select cat_ref,order_tid,fabric_status,category from $bai_pro3.order_cat_recut_doc_mk_mix where doc_no=$docket_id";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cat_ref=$sql_row['cat_ref'];
		$order_tid=$sql_row['order_tid'];
		$catgory=$sql_row['category'];
		if($sql_row['category']=="Body" or $sql_row['category']=="Front")
		{
			$fabric_status=$sql_row['fabric_status'];
			$sql1="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_doc_no=$docket_id and m3_op_des='LAY'"; 
			$result=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$val_check=mysqli_num_rows($result);
		}
		else
		{
			$fabric_status=5;
		}
	}
	
	if($cat_ref>0 and $fabric_status==5)
	{
		$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
		{
			$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
		}	
	}
		
}		

	
	
$cat_id=$cat_ref;
$date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));


echo "<div class='table-responsive'><table class='table table-bordered'>";
echo "<tr style='color: #fff;background-color: #337ab7;border-color: #337ab7;'>";
echo "<th>Doc ID</th><th>Cut No</th>";

//echo "<th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>s08</th><th>s10</th><th>s12</th><th>s14</th><th>s16</th><th>s18</th><th>s20</th><th>s22</th><th>s24</th><th>s26</th><th>s28</th>";
for($s=0;$s<sizeof($s_tit);$s++)
	{
		echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
			
	}
echo "<th>Cut Status</th><th>Cut Issue status</th><th>Control</th><th>Date</th><th>Section</th><th>Shift</th><th>Fab_REC</th><th>Fab_Ret</th><th>Damages</th><th>Shortage</th>";


echo "</tr>";
$a_s=array();
//$sql="select * from plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_id order by doc_no";
$sql="select * from $bai_pro3.recut_v2 where order_tid=\"$order_tid\" and cat_ref=$cat_id and doc_no=$docket_id order by doc_no"; //NEW 2011
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$doc_no=$sql_row['doc_no'];
	$doc_acutno=$sql_row['acutno'];
	$a_plies=$sql_row['p_plies'];
	
	
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		$a_s[$sizes_code[$s]]=$sql_row["a_s".$sizes_code[$s].""]*$a_plies;
	}
	
$plies=$sql_row['a_plies'];

	
	
	$remarks=$sql_row['remarks'];
	$act_cut_status=$sql_row['act_cut_status'];
	$act_cut_issue_status=$sql_row['act_cut_issue_status'];
	
$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row33=mysqli_fetch_array($sql_result33))
{
$color_code=$sql_row33['color_code']; //Color Code
	
}
	
	echo "<tr>";
	
	echo "<td>".leading_zeros($doc_no,9)."</td><td>"."R".leading_zeros($doc_acutno,3)."</td>";
	for($s=0;$s<sizeof($s_tit);$s++)
	{
		echo "<td>".$a_s[$sizes_code[$s]]."</td>";
			
	}
	echo "<td>$act_cut_status</td><td>$act_cut_issue_status</td>";
//	<td>$a_xs</td><td>$a_s</td><td>$a_m</td><td>$a_l</td><td>$a_xl</td><td>$a_xxl</td><td>$a_xxxl</td><td>$s08</td><td>$s10</td><td>$s12</td><td>$s14</td><td>$s16</td><td>$s18</td><td>$s20</td><td>$s22</td><td>$s24</td><td>$s26</td><td>$s28</td><td>$act_cut_status</td><td>$act_cut_issue_status</td>";
//echo "<td>$remarks</td>";

	/* if($act_cut_status=="DONE" and $plies==$a_plies)
	{
		echo "<td>Edit</td>";
	}
	else
	{
		echo "<td><a href=\"orders_cut_issue_status_form1.php?doc_no=$doc_no\">Create</a></td>";
	} */
	if($category=='Body' or $category=="Front")
	{
		//if($val_check>0)
		//{
			if(strlen($act_cut_status)==0)
			{
				$url = getFullURL($_GET['r'],'orders_cut_issue_status_form1_recut.php','N');
				echo "<td><a href=\"$url&doc_no=$doc_no\" class='btn btn-success btn-sm'>Create</a></td>";
			}
			else
			{
				echo "<td>Edit</td>";
			}
		//}
		//else
		//{
		//	echo "<td>Lay report Pending.</td>";
		//}
	}
	else
	{
		if(strlen($act_cut_status)==0)
			{
				$url = getFullURL($_GET['r'],'orders_cut_issue_status_form1_recut.php','N');
				echo "<td><a href=\"$url&doc_no=$doc_no\" class='btn btn-success btn-sm'>Create</a></td>";
			}
			else
			{
				echo "<td>Edit</td>";
			}
	}
	


		$acs_date="";
		$acs_section="";
		$acs_shift="";
		$acs_fab_received="";
		$acs_fab_returned="";
		$acs_damages="";
		$acs_shortages="";
		$acs_remarks="";
		
	$sql2="select * from $bai_pro3.act_cut_status_recut_v2 where doc_no=$doc_no";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$acs_date=$sql_row2['date'];
		$acs_section=$sql_row2['section'];
		$acs_shift=$sql_row2['shift'];
		$acs_fab_received=$sql_row2['fab_received'];
		$acs_fab_returned=$sql_row2['fab_returned'];
		$acs_damages=$sql_row2['damages'];
		$acs_shortages=$sql_row2['shortages'];
		$acs_remarks=$sql_row2['remarks'];
	}
	


	
	echo "<td>$acs_date</td><td>$acs_section</td><td>$acs_shift</td><td>$acs_fab_received</td><td>$acs_fab_returned</td><td>$acs_damages</td><td>$acs_shortages</td>";
//cho "<td>$acs_remarks</td>";


	if($act_cut_issue_status=="DONE")
	{
		//IMS IMPLEMNT
		//echo "<td>Edit</td>";
	}
	else
	{
		
		if($act_cut_status=="DONE")
		{
			//IMS IMplemet
			//echo "<td><a href=\"orders_cut_issue_status_form2.php?doc_no=$doc_no\">Create</a></td>";
		}
	}


	
	//echo "<td>$acis_remarks</td>";

	echo "</tr>";

}
echo "</table></div>";
}
else
{
	echo "<script>sweetAlert('','Requested Docket doesnt exist/Fabric not issued to this docket.Please Contact your planner or RM Team','warning');</script>";
	//echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Requested Docket doesnot exist or Fabric Not issued to this docket. Please contact your planner/RM Team.</div>";
}
}
else
{
	echo "<script>sweetAlert('','Please enter a valid docket number','error')</script>";
	//echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Please enter valid Docket Number</div>";
}
}
?>

<?php

if(isset($_POST['submit2']))
{
	
	echo "<hr/>";
	$cid=$_POST['cid'];
	
	
	if($cid>0)
	{
		
	
	//$sql="select * from recut_v2 where cat_ref=$cid";
	$sql="select cat_ref,order_tid,fabric_status,category from $bai_pro3.order_cat_recut_doc_mk_mix where cat_ref=$cid";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cat_ref=$sql_row['cat_ref'];
		$order_tid=$sql_row['order_tid'];
		if($sql_row['category']=="Body" or $sql_row['category']=="Front")
		{
			$fabric_status=$sql_row['fabric_status'];
		}
		else
		{
			$fabric_status=5;
		}
	}
	
	if($cat_ref>0 and $fabric_status==5)
	{
		
	
	
$cat_id=$cat_ref;
$date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));


echo "<div class='table-responsive'><table class='table table-bordered'>";
echo "<tr class='tblheading'>";
echo "<th>Doc ID</th><th>Cut No</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXXL</th><th>s08</th><th>s10</th><th>s12</th><th>s14</th><th>s16</th><th>s18</th><th>s20</th><th>s22</th><th>s24</th><th>s26</th><th>s28</th><th>CUT STAT</th><th>CUT ISSUE STAT</th><th>Control</th>";

echo "<th>Date</th><th>Section</th><th>Shift</th><th>Fab_REC</th><th>Fab_Ret</th><th>Damages</th><th>Shortage</th>";



echo "</tr>";

$sql="select * from $bai_pro3.recut_v2 where order_tid=\"$order_tid\" and cat_ref=$cat_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

while($sql_row=mysqli_fetch_array($sql_result))
{
	$doc_no=$sql_row['doc_no'];
	$doc_acutno=$sql_row['acutno'];
	$a_plies=$sql_row['p_plies'];
	$a_xs=$sql_row['a_xs']*$a_plies;
	$a_s=$sql_row['a_s']*$a_plies;
	$a_m=$sql_row['a_m']*$a_plies;
	$a_l=$sql_row['a_l']*$a_plies;
	$a_xl=$sql_row['a_xl']*$a_plies;
	$a_xxl=$sql_row['a_xxl']*$a_plies;
	$a_xxxl=$sql_row['a_xxxl']*$a_plies;
	
	$a_s08=$sql_row['a_s08']*$a_plies;
$a_s10=$sql_row['a_s10']*$a_plies;
$a_s12=$sql_row['a_s12']*$a_plies;
$a_s14=$sql_row['a_s14']*$a_plies;
$a_s16=$sql_row['a_s16']*$a_plies;
$a_s18=$sql_row['a_s18']*$a_plies;
$a_s20=$sql_row['a_s20']*$a_plies;
$a_s22=$sql_row['a_s22']*$a_plies;
$a_s24=$sql_row['a_s24']*$a_plies;
$a_s26=$sql_row['a_s26']*$a_plies;
$a_s28=$sql_row['a_s28']*$a_plies;
$plies=$sql_row['a_plies'];

	$remarks=$sql_row['remarks'];
	$act_cut_status=$sql_row['act_cut_status'];
	$act_cut_issue_status=$sql_row['act_cut_issue_status'];
	
$sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row33=mysqli_fetch_array($sql_result33))
{
$color_code=$sql_row33['color_code']; //Color Code
	
}
	
	echo "<tr>";
	
	echo "<td>".leading_zeros($doc_no,9)."</td><td>".chr($color_code).leading_zeros($doc_acutno,3)."</td><td>$a_xs</td><td>$a_s</td><td>$a_m</td><td>$a_l</td><td>$a_xl</td><td>$a_xxl</td><td>$a_xxxl</td><td>$s08</td><td>$s10</td><td>$s12</td><td>$s14</td><td>$s16</td><td>$s18</td><td>$s20</td><td>$s22</td><td>$s24</td><td>$s26</td><td>$s28</td><td>$act_cut_status</td><td>$act_cut_issue_status</td>";
//echo "<td>$remarks</td>";

	/* if($act_cut_status=="DONE" and $plies==$a_plies)
	{
		echo "<td>Edit</td>";
	}
	else
	{
		echo "<td><a href=\"orders_cut_issue_status_form1.php?doc_no=$doc_no\">Create</a></td>";
	} */
	if(strlen($act_cut_status)==0)
	{
		$url = getFullURL($_GET['r'],'orders_cut_issue_status_form1_recut.php','N');
		echo "<td><a href=\"$url&doc_no=$doc_no\" class='btn btn-primary btn-sm'>Create</a></td>";
	}
	else
	{
		echo "<td>Edit</td>";
	}


		$acs_date="";
		$acs_section="";
		$acs_shift="";
		$acs_fab_received="";
		$acs_fab_returned="";
		$acs_damages="";
		$acs_shortages="";
		$acs_remarks="";
		
	$sql2="select * from $bai_pro3.act_cut_status_recut_v2 where doc_no=$doc_no";
	mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$acs_date=$sql_row2['date'];
		$acs_section=$sql_row2['section'];
		$acs_shift=$sql_row2['shift'];
		$acs_fab_received=$sql_row2['fab_received'];
		$acs_fab_returned=$sql_row2['fab_returned'];
		$acs_damages=$sql_row2['damages'];
		$acs_shortages=$sql_row2['shortages'];
		$acs_remarks=$sql_row2['remarks'];
	}
	


	
	echo "<td>$acs_date</td><td>$acs_section</td><td>$acs_shift</td><td>$acs_fab_received</td><td>$acs_fab_returned</td><td>$acs_damages</td><td>$acs_shortages</td>";
//echo "<td>$acs_remarks</td>";


	if($act_cut_issue_status=="DONE")
	{
		//ims implementations
		//echo "<td>Edit</td>";
	}
	else
	{
		if($act_cut_status=="DONE")
		{
			//IMS Implementation
			//echo "<td><a href=\"orders_cut_issue_status_form2.php?doc_no=$doc_no\">Create</a></td>";
		}
	}




	echo "</tr>";

}
echo "</table></div>";
}
else
{
	echo "<script>sweetAlert('','Requested Docket doesnt exist/Fabric not issued to this docket.Contact your Planner/RM Team','error');</script>";
	//echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Requested Docket doesnot exist or Fabric Not issued to this docket. Please contact your planner/RM Team.</div>";
}
}
else
{
	echo "<script>swwtAlert('Please enter valid Docket Reference','','error');</script>";
	//echo "<div class='alert alert-danger' role='alert' style='text-align:center;'>Please enter valid Docket Reference</div>";
}
}

?>

</div>
</div>