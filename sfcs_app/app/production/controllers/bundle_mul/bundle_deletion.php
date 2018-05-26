<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" type="text/css" href="table.css">
<style type="text/css">
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
/* body{ 
	/* margin:15px; padding:15px; border:1px solid #666; */
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
} */
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
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//swal("report");
	var url1 = '<?= getFullUrl($_GET['r'],'module_change.php','N'); ?>';
	
	window.location.href = url1+"&module_id="+document.module_change.module_id.value
}

function secondbox()
{
	//swal('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}



function check_val_2()
{
	//swal('dfsds');
	
	var count=document.barcode_mapping_2.count_qty.value;
	//swal(count);
	//swal('qty');
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
		swal('Please fill the values');
		return false;
	}
	//return false;	
}
function validateQty(event) {
    var key = window.event ? event.keyCode : event.which;
	//swal(key);
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
<?php
$global_path = getFullURLLevel($_GET['r'],'',4,'R');
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0274",$username,1,$group_id_sfcs);
$authorized=user_acl("SFCS_0274",$username,7,$group_id_sfcs);
$authorized[]='kirang';
?>

<?php
//ALTER TABLE `brandix_bts`.`bundle_transactions` ADD COLUMN `man_update` VARCHAR(455) NULL AFTER `module_id`;

error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$modules=array();
//$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);


//echo $style.$schedule.$color;
?>

<!-- <form name="module_change" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();"> -->

<?php

?>
<form action="?r=<?php echo $_GET['r']; ?>" method="post">
	<div class='form-group col-lg-3'>
	<label>Provide Bundle's To Delete:</label>
	<textarea class='form-control' id="bundle_id" rows="2" cols="30" name="bundle_id"	onkeypress='return validateQty(event);'></textarea>
	</div>
	<div class='form-group col-lg-3'>
		<label>Operation: </label>
	
		<select name='operation_id' id='operation_id' class='form-control'>	
		<option value=1 <?php if($_POST['operation_id']==1){echo "selected";}?> >Operation-1</option>;	
		<option value=2 <?php if($_POST['operation_id']==2){echo "selected";}?> >Operation-2</option>;	
		<option value=3 <?php if($_POST['operation_id']==3){echo "selected";}?> >Operation-3</option>;	
		<option value=4 <?php if($_POST['operation_id']==4){echo "selected";}?> >Operation-4</option>;	
		</select>
	</div>
	<div class='form-group col-lg-2'>
		<input type="submit" class='btn btn-primary' style='margin-top: 20px' value="Show" name="show">&nbsp;&nbsp;
	</div>
	<?php
	$url1 = getFullUrl($_GET['r'],'bundle_deletion.php','N');
	if(in_array($username,$authorized))
	{
		echo "<div class='form-group col-lg-2'>";
		echo "<a href=\"$url1&approve=1\" class='btn btn-primary' style='margin-top: 20px'>Click to Approve/Reject</a></div>";
	}
	echo "<div class='form-group col-lg-2'>";
	echo "<a href=\"$url1&report=1\" class='btn btn-primary' style='margin-top: 20px'>Log Report</a></div>";
	
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
		<form action="?r=<?php echo $_GET['r']; ?>" method="post">
		<?php
		echo "<input type=\"submit\" class='btn btn-primary' value=\"Delete\" name=\"delete\">";
		echo "<table border=\"1px\" class='table table-bordered'><tr><th>Bundle Id</th><th>Operation</th><th>Quantity</th><th>Rejection</th><th>Reason</th></tr>";
		for($i=0;$i<sizeof($bundle_id);$i++)
		{
			if($operation<4)
			{
				$operation_n=$operation+1;
				$check=echo_title("brandix_bts.bundle_transactions_20_repeat","id","bundle_id='".$bundle_id[$i]."' and operation_id",$operation_n,$link);
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
					echo "<td><input type=\"text\" class='form-control' value=\"\" name=\"reason[]\"</td>";
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
		echo "<h4>Please provide the Bundle Numbers.</h4>";
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
		$sql11="update $brandix_bts.bundle_transactions_20_repeat_delete set log_time='".date("Y-m-d H:i:s")."',user='".$username."',reason='".$reason[$i]."' where id='".$id[$i]."'";
		$result=mysqli_query($link, $sql11) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	echo "<h3>Sending for approval please contact Key User<h3>";
	$url1 = getFullUrl($_GET['r'],'bundle_deletion.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",210); function Redirect() {  location.href = \"$url1\"; }</script>";
}

if($_GET['approve']==1) 
{
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<?php
	echo "<table class='table table-bordered' border=\"1px\"><tr><th>Bundle Id</th><th>Operation</th><th>Quantity</th><th>Rejection</th><th>Requested  By</th><th>Requested  Log</th><th>Reason</th></tr>";
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
		echo "<h3>There is no data to Approve/Reject.</h3>";
	}
	echo "<input type=\"submit\" class='btn btn-primary' value=\"Approve\" name=\"approve\">";
	echo "<input type=\"submit\" class='btn btn-warning' value=\"Reject\" name=\"reject\">";
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
	echo "<h3>Deleted Successfully</h3>";
	$url1 = getFullUrl($_GET['r'],'bundle_deletion.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",210); function Redirect() {  location.href = \"$url1\"; }</script>";
}
if(isset($_POST['reject'])) 
{
	$sql2="update $brandix_bts.bundle_transactions_20_repeat_delete set status=2,updated_by='".$username."' where status=0";
	$result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<h3>Rejected Successfully</h3>";
	$url1 = getFullUrl($_GET['r'],'bundle_deletion.php','N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",210); function Redirect() {  location.href = \"$url1\"; }</script>";	
}
if($_GET['report']==1) 
{
	?>
	<hr>
	<form action="?r=<?php echo $_GET['r']; ?>" method="post">
	<div class='form-group col-lg-2'>
		<label>Start Date:</label>
		<input id="demo1" class='form-control' onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" name="sdate" size="8" value="<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>">
	</div>
	<div class='form-group col-lg-2'>
		<label>End Date:</label>
	
	<input id="demo2" class='form-control' onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" type="text" size="8" name="edate" value="<?php if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>">
	</div>
	<div class='form-group col-lg-2'>

	<?php
	echo "<input type=\"submit\" class='btn btn-primary' style='margin-top: 20px' value=\"Show\" name=\"get_report\">";
	?>
	</form>
<?php
}	
if(isset($_POST['get_report'])) 
{	
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];

	$sql1="select * from $brandix_bts.bundle_transactions_20_repeat_delete where date(log_time) between '".$sdate."' and '".$edate."'";
	$result1=mysqli_query($link, $sql1) or die("Error =1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num_rows=mysqli_num_rows($result1);
	if($num_rows>0)
	{
		echo "<table border=\"1px\" class='table table-bordered'><tr><th>Bundle Id</th><th>Operation</th><th>Quantity</th><th>Rejection</th><th>Requested  By</th><th>Requested Log</th><th>Reason</th><th>Authorized By</th><th>Authorized Log</th><th>Status</th></tr>";
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
		echo "<h3>There is no data between these date's.</h3>";
	}
	echo "</table>";	
	
?>
</form>
<?php
}

?>	
</div>
</div>