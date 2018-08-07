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
</style>
<script language="javascript" type="text/javascript" src="TableFilter_EN/actb.js"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="TableFilter_EN/tablefilter.js"></script>



<script language="javascript" type="text/javascript">
function firstbox()
{
	//alert("report");
	var ajax_url ="module_change.php?module_id="+document.module_change.module_id.value;Ajaxify(ajax_url);

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
<div id="page_heading"><span style="float: left"><h3>Bundle Deletion Form</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<?php
include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
$view_access=user_acl("SFCS_0069",$username,1,$group_id_sfcs);

?>

<?php
//ALTER TABLE `brandix_bts`.`bundle_transactions` ADD COLUMN `man_update` VARCHAR(455) NULL AFTER `module_id`;

error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$modules=array();
include("dbconf.php"); 
//$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);


//echo $style.$schedule.$color;
?>

<form name="module_change" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit=" return check_val();">

<?php

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	Start Date: <input id="demo1" onclick="javascript:NewCssCal('demo1','yyyymmdd','dropdown')" type="text" name="sdate" size="8" value="<?php if(isset($_REQUEST['sdate'])) { echo $_REQUEST['sdate']; } else { echo date("Y-m-d"); } ?>"> End Date: <input id="demo2" onclick="javascript:NewCssCal('demo2','yyyymmdd','dropdown')" type="text" size="8" name="edate" value="<?php if(isset($_REQUEST['edate'])) { echo $_REQUEST['edate']; } else { echo date("Y-m-d"); } ?>">
	<?php
	echo "<input type=\"submit\" value=\"Show\" name=\"get_report\">";
	?>
	</form>
<?php
	
if(isset($_POST['get_report'])) 
{	
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	
	$sql1="select * from brandix_bts.bundle_transactions_20_repeat_delete where date(log_time) between '".$sdate."' and '".$edate."'";
	$result1=mysqli_query($link, $sql1) or die("Error =1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num_rows=mysqli_num_rows($result1);
	if($num_rows>0)
	{
		echo "<table border=\"1px\"><tr><th>Bundle Id</th><th>Operation</th><th>Quantity</th><th>Rejection</th><th>Requested  By</th><th>Requested Log</th><th>Reason</th><th>Authorized By</th><th>Authorized Log</th><th>Status</th></tr>";
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