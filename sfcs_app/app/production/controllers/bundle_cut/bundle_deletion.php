<?php $has_permission = haspermission($_GET['r']);?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',4,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',4,'R')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/style.css',4,'R')?>">
<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/table.css',4,'R')?>">
<!---<style type="text/css">
#div-1a {
 position:absolute;
 top:65px;
 right:0;
 width:auto;
float:right;
table {
    float:left;
    width:33%;
}
</style>
<style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px;  padding:5px; background-color:#f4f4f4; solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; outset #f4f4f4; margin:2px; }
.mytable th{ background-color:#29759c; color:#FFF; padding:2px; solid #ccc; white-space: nowrap;}
td{ padding:2px; white-space: nowrap;}
</style>--->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',4,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',4,'R')?>"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//alert("report");
	window.location.href ="module_change.php?module_id="+document.module_change.module_id.value
}

function secondbox()
{
	//alert('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}



function check_val_2()
{
	//alert('dfsds');
	
	var count=document.barcode_mapping_2.count_qty.value;
	//alert(count);
	//alert('qty');
	var check_exist=0;
	for(i=0;i<5;i++)
	{
		var qty=document.getElementById("qty["+i+"]").value;
		if(qty!=0)
	    {
			var check_exist=1;
		}
	}
	if(check_exist==0)
	{
		alert('Please fill the values');
		return false;
	}
	//return false;	
}
function validateQty(event) {
    var key = window.event ? event.keyCode : event.which;
	//alert(key);
if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 44) {
    return true;
}
else if ( key < 48 || key > 57 ) {
    return false;
}
else 
{
return true;

}
};
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Bundle Deletion Form</div>
<div class="panel-body">
<!---<div id="page_heading"><span style="float: left"><h3>Bundle Deletion Form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
// $view_access=user_acl("SFCS_0274",$username,1,$group_id_sfcs);
// $authorized=user_acl("SFCS_0274",$username,7,$group_id_sfcs);
?>

<?php
//ALTER TABLE `brandix_bts`.`bundle_transactions` ADD COLUMN `man_update` VARCHAR(455) NULL AFTER `module_id`;

error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$modules=array();
?>

<form name="module_change" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post" onsubmit=" return check_val();">

<?php

?>
<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
<div class='col-md-3 col-sm-3 col-xs-12'>
	Provide Bundle's To Delete:<textarea id="bundle_id" class="form-control" rows="2" cols="30" name="bundle_id"	onkeypress='return validateQty(event);'></textarea>
</div>	
<div class='col-md-3 col-sm-3 col-xs-12'>
	Operations:<select name='operation_id' class="select2_single form-control">	
	<option value=1 <?php if($_POST['operation_id']==1){echo "selected";}?> >Operation-1</option>;	
	<option value=2 <?php if($_POST['operation_id']==2){echo "selected";}?> >Operation-2</option>;	
	<option value=3 <?php if($_POST['operation_id']==3){echo "selected";}?> >Operation-3</option>;	
	<option value=4 <?php if($_POST['operation_id']==4){echo "selected";}?> >Operation-4</option>;	
	</select>
</div>	
<div class='col-md-3 col-sm-3 col-xs-12' style="margin-top: 16px;">
	<input type="submit" value="Show" class="btn btn-primary" name="show">&nbsp&nbsp
</div>	
	<?php
	$url=getFullURLLevel($_GET['r'],'bundle_deletion.php',0,'N');
	if(in_array($approve,$has_permission))
	{
		echo "<a href=\"$url&approve=1\" class=\"btn btn-success\">Click to Approve/Reject</a>&nbsp&nbsp&nbsp&nbsp";
	}
		echo "<a href=\"$url&report=1\" class=\"btn btn-success\">Log Report</a>";
	
	?>
	
	</form>


<?php

if(isset($_POST['show'])) 
{
	$operation=$_POST['operation_id'];
	$bundle_ids=$_POST['bundle_id'];
	$ops_pending=array();
	$bundle_id=explode(",",$bundle_ids);
	$next_ops=$operation+1;
	if(sizeof($bundle_id)>0)
	{
		?>
		<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
		<?php
		echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Delete\" name=\"delete\">";
		echo "<table class='table table-bordered'><tr><th>Bundle Id</th><th>Operation</th><th>Quantity</th><th>Rejection</th><th>Reason</th></tr>";
		for($i=0;$i<sizeof($bundle_id);$i++)
		{
			if($operation<4)
			{
				$operation_n=$operation+1;
				$check=echo_title("$brandix_bts.bundle_transactions_20_repeat","id","bundle_id='".$bundle_id[$i]."' and operation_id",$operation_n,$link);
			}
			else
			{
				$check=0;
			}
			$sql1="select * from $brandix_bts.bundle_transactions_20_repeat where bundle_id='".$bundle_id[$i]."' and operation_id='".$operation."'";
			//echo $sql1."<br>";
			$result1=mysqli_query($link, $sql1) or die("Error =1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $check."---".$operation."--".$num_rows."<br>";
			$num_rows=mysqli_num_rows($result1);
			if(($check==0 || $operation==4) && $num_rows>0)
			{
				while($row1=mysqli_fetch_array($result1))
				{
					$id=$row1['id'];
					echo "<tr>";
					echo "<input type=\"hidden\" value=\"$id\" name=\"tran_id[]\">";
					echo "<td>".$row1['bundle_id']."</td>";
					echo "<td>".$operation."</td>";
					echo "<td>".$row1['quantity']."</td>";
					echo "<td>".$row1['rejection_quantity']."</td>";
					echo "<td><input type=\"text\" value=\"\" name=\"reason[]\"</td>";
					echo "</tr>";
				}

			}
			else
			{
				$ops_pending[]=$bundle_id[$i];
			}
			
		}
		
		echo "</table>";	
		$check_status=sizeof($ops_pending);
		if($check_status>0)
		{
			echo "<h2>Already Next Operation Reported / Not yet Scanned / Not found for these bundle-(".implode(",",$ops_pending).")</h2>";
		}
	}
	else
	{
		echo "<script>swal('Please provide the Bundle Numbers','','warning');</script>";
	}
?>
</form>
<?php
}	

if(isset($_POST['delete'])) 
{
	$id=$_POST['tran_id'];
	$tran_id=implode(",",$id);
	$reason=$_POST['reason'];
	//echo $tran_id."<br>";
	$sql="insert into $brandix_bts.bundle_transactions_20_repeat_delete(id,parent_id,bundle_barcode,quantity,bundle_id,operation_id,rejection_quantity,act_module
	) select id,parent_id,bundle_barcode,quantity,bundle_id,operation_id,rejection_quantity,act_module from bundle_transactions_20_repeat where id in (".$tran_id.")";
	//echo $sql."<br>";
	$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	for($i=0;$i<sizeof($id);$i++)
	{
		$sql11="update $brandix_bts.bundle_transactions_20_repeat_delete set log_time='".date("Y-m-d h:i:s")."',user='".$username."',reason='".$reason[$i]."' where id='".$id[$i]."'";
		$result=mysqli_query($link, $sql11) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	echo "<script>swal('Sending for approval please contact Key User','','warning');</script>";
	$url=getFullURLLevel($_GET['r'],'bundle_deletion.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",210); function Redirect() {  location.href = \"$url\"; }</script>";
}

if($_GET['approve']==1) 
{
	?>
	<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
	<?php
	echo "<table class=\"table table-bordered\"><tr><th>Bundle Id</th><th>Operation</th><th>Quantity</th><th>Rejection</th><th>Requested  By</th><th>Requested  Log</th><th>Reason</th></tr>";
	$sql1="select * from $brandix_bts.bundle_transactions_20_repeat_delete where status=0";
	$result1=mysqli_query($link, $sql1) or die("Error =1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num_rows=mysqli_num_rows($result1);
	if($num_rows>0)
	{
		while($row1=mysqli_fetch_array($result1))
		{
			$id=$sqlrow['id'];
			echo "<tr>";
			echo "<input type=\"hidden\" value=\"$id\" name=\"tran_id[]\">";
			echo "<td>".$row1['bundle_id']."</td>";
			echo "<td>".$row1['operation_id']."</td>";
			echo "<td>".$row1['quantity']."</td>";
			echo "<td>".$row1['rejection_quantity']."</td>";
			echo "<td>".$row1['user']."</td>";
			echo "<td>".$row1['log_time']."</td>";
			echo "<td>".$row1['reason']."</td>";
			echo "</tr>";
		}

	}
	else
	{
		echo "<script>swal('There is no data','to Approve/Reject','warning');</script>";
	}
	echo "<input type=\"submit\" value=\"Approve\" class=\"btn btn-success\" name=\"approve\">";
	echo "<input type=\"submit\" value=\"Reject\" class=\"btn btn-danger\" name=\"reject\">";
	echo "</table>";	
	
?>
</form>
<?php
}
if(isset($_POST['approve'])) 
{	
	$sql1="select group_concat(id) as id FROM $brandix_bts.bundle_transactions_20_repeat_delete where status=0";
	$result1=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows=mysqli_fetch_array($result1))
	{
		$id=$rows['id'];
		$sql2="delete from $brandix_bts.bundle_transactions_20_repeat where id in (".$id.")";
		$result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql2="update $brandix_bts.bundle_transactions_20_repeat_delete set status=1,updated_by='".$username."',update_log='".date("Y-m-d H:i:s")."' where id in (".$id.")";
		$result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	echo "<script>swal('Successfully','Deleted','success');</script>";
	$url=getFullURLLevel($_GET['r'],'bundle_deletion.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",210); function Redirect() {  location.href = \"$url\"; }</script>";
}
if(isset($_POST['reject'])) 
{
	$sql2="update $brandix_bts.bundle_transactions_20_repeat_delete set status=2,updated_by='".$username."' where status=0";
	$result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<script>swal('Successfully','Rejected','success');</script>";
	$url=getFullURLLevel($_GET['r'],'bundle_deletion.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",210); function Redirect() {  location.href = \"$url\"; }</script>";	
}
if($_GET['report']==1) 
{
	?>
	<form action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
	<div class='col-md-3 col-sm-3 col-xs-12'>
	Start Date: <input id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" class="form-control" type="text" name="sdate" size="8" value="<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>">
	</div>
	<div class='col-md-3 col-sm-3 col-xs-12'>
	End Date: <input id="demo2" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" class="form-control" type="text" size="8" name="edate" value="<?php if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>">
	</div>
	<div class='col-md-3 col-sm-3 col-xs-12' style="margin-top: 17px;">
	<?php
	echo "<input type=\"submit\" value=\"Show\" class=\"btn btn-primary\" name=\"get_report\">";
	?>
	</div>
	</form>
<?php
}	
if(isset($_POST['get_report'])) 
{	
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	echo "<table class='table table-bordered'><tr><th>Bundle Id</th><th>Operation</th><th>Quantity</th><th>Rejection</th><th>Requested  By</th><th>Requested Log</th><th>Reason</th><th>Authorized By</th><th>Authorized Log</th><th>Status</th></tr>";
	$sql1="select * from $brandix_bts.bundle_transactions_20_repeat_delete where date(log_time) between '".$sdate."' and '".$edate."'";
	$result1=mysqli_query($link, $sql1) or die("Error =1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num_rows=mysqli_num_rows($result1);
	if($num_rows>0)
	{
		while($row1=mysqli_fetch_array($result1))
		{
			$id=$sqlrow['id'];
			echo "<tr>";
			echo "<input type=\"hidden\" value=\"$id\" name=\"tran_id[]\">";
			echo "<td>".$row1['bundle_id']."</td>";
			echo "<td>".$row1['operation_id']."</td>";
			echo "<td>".$row1['quantity']."</td>";
			echo "<td>".$row1['rejection_quantity']."</td>";
			echo "<td>".$row1['user']."</td>";
			echo "<td>".$row1['log_time']."</td>";
			echo "<td>".$row1['reason']."</td>";
			echo "<td>".$row1['updated_by']."</td>";
			echo "<td>".$row1['update_log']."</td>";
			if($row1['status']==0)
			{
				echo "<td>Pending</td>";
			}
			else if($row1['status']==1)
			{
				echo "<td>Approved</td>";
			}
			else
			{
				echo "<td>Rejected</td>";
			}
			echo "</tr>";
		}

	}
	else
	{
		echo "<script>swal('There is no data between these dates','','warning');</script>";
	}
	echo "</table>";	
}
?>
</form>
</div>
</div>
</body>