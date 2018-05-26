<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<META HTTP-EQUIV="refresh" content="120">
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
	var url1 = '<?= getFullUrl($_GET['r'],'mini_order_report.php','N'); ?>';
	//swal("report");
	window.location.href = url1+"&style="+document.mini_order_report.style.value
}

function secondbox()
{
	//swal('test');
	//window.location.href ="../mini-orders/excel-export?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
}

function check_val()
{
	//swal('dfsds');
	var style=document.bundle_operation.style.value;
	var c_block=document.bundle_operation.c_block.value;
	var schedule=document.bundle_operation.schedule.value;
	var barcode=document.bundle_operation.barcode.value;
	//swal(style);
	//swal(c_block);
	//swal(schedule);
		if(style==0 || c_block=='NIL' || schedule=='NIL' || barcode=='NIL')
		{
			swal('Please select the values');
			return false;
		}
		
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
if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 ) {
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
	<div class="panel-heading">Bundle Scanning Form</div>
	<div class="panel-body">
<?php  ?>

<?php
// error_reporting(0);
$shift=$_POST['shift'];
$module=$_POST['module'];
$global_path = getFullURLLevel($_GET['r'],'',4,'R');
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0273",$username,1,$group_id_sfcs);
$authorized=user_acl("SFCS_0273",$username,7,$group_id_sfcs);
$super_user[]=user_acl("SFCS_0273",$username,33,$group_id_sfcs);
$super_user[]='kirang';

// Report simple running errors
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
$hrs=array("06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21");
$hrs_back=array("06"=>"6 - 7 AM","07"=>"7 - 8 AM","08"=>"8 - 9 AM","09"=>"9 - 10 AM","10"=>"10 - 11 AM","11"=>"11 - 12 AM","12"=>"12 - 1 PM","13"=>"1 - 2 PM",
"14"=>"2 - 3 PM","15"=>"3 - 4 PM","16" =>"4 - 5 PM","17"=>"5 - 6 PM","18"=>"6 - 7 PM","19"=>"7 - 8 PM","20"=>"8 - 9 PM","21"=>"9 - 10 PM");
$status="close";
$min=date('i');
$cur_hr=date('H');
$prev_hr = date('H', strtotime('-1 hour'));
$min_val=30;
//echo $min."--".$min_val."-".$cur_hr."--".$prev_hr."<br>";

// include("dbconf.php");

// Doubt about this database connection.........
// $database1="bai_hr_database";
// $user1="bainet";
// $password1="bainet";
// $host1="baidbsrv05";

// $link1= ($GLOBALS["___mysqli_ston"] = mysqli_connect($host1, $user1, $password1)) or die("Could not connect: ".mysqli_error($GLOBALS["___mysqli_ston"]));
// mysqli_select_db($link1, $database1) or die("Error in selecting the database:".mysqli_error($GLOBALS["___mysqli_ston"]));

// $date=date("Y-m-d");
// $prev_date= date('Y-m-d', strtotime("-1 day",strtotime($date)));
// $prev_em_att_year_db="bai_hr_tna_em_".date("y",strtotime($prev_date)).date("y",strtotime($prev_date)); 
// $date_n='';

// do
// {
// 	$sql="SELECT * FROM $prev_em_att_year_db.`calendar` WHERE DATE='".$prev_date."' and day_type='w'";
// 	// echo $sql;
// 	$sql_result=mysqli_query($link1, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// 	while($sql_row=mysqli_fetch_array($sql_result))
// 	{
// 		$date_n=$sql_row['date'];
// 	}
// 	$prev_date= date('Y-m-d', strtotime("-1 day",strtotime($prev_date)));
// }
// while($date_n=='0' || $date_n=='');

// Doubt about this database connection.........


$ex_date=echo_title("$brandix_bts.users","exp_date","id",1,$link);
$ex_hour=echo_title("$brandix_bts.users","exp_time","id",1,$link);
$cur_date=date("Y-m-d");
$date_n=date('Y-m-d');
// echo $ex_date."--".$ex_hour."--".$cur_date."--".$cur_hr."<br>";

?>

<form action="?r=<?= $_GET['r'] ?>" method="post">
<table class="mytable1 table table-bordered"><tr>
<?php
if($cur_date<=$ex_date && $cur_hr<=$ex_hour && in_array($username,$authorized))
{
	echo "<th>Select Date:</th>";
	?>
	<td>
	<?php
	echo "<select name='op_date' id='op_date' class='form-control'>";
	echo "<option value='".$date."'>".$date."</option>";
	echo "<option value='".$date_n."'>".$date_n."</option>";
	echo "</select>";
}
if($status=='open')
{
?>
<th>Hour:</th><td> <select name="hour" id='hour' class='form-control'>
<?php
if(in_array($username,$super_user))
{
	for($i=0;$i<sizeof($hrs);$i++)
	{
		if($hrs[$i]<=$cur_hr)
		{
			if($cur_hr == $hrs[$i])
			{
				$select="selected";
			}
			else
			{
				$select="";
			}
			
			if($hrs[$i]<12)
			{
				echo "<option value=\"".$hrs[$i]."\" $select>".$hrs_back[$hrs[$i]]."</option>";
			}
			else
			{
				echo "<option value=\"".$hrs[$i]."\" $select>".$hrs_back[$hrs[$i]]."</option>";
			}
		}
	}

}
else
{

	if($cur_hr=='06' )
	{
		echo "<option value=\"".$cur_hr."\" selected>".$hrs_back[$cur_hr]."</option>";
	}
	else if($cur_hr=='22')
	{
		echo "<option value=\"".$prev_hr."\" selected>".$hrs_back[$prev_hr]."</option>";
	}
	else
	{
		if($min<=$min_val)
		{
			for($i=0;$i<2;$i++)
			{
				if($i==0)
				{
					echo "<option value=\"".$prev_hr."\" >".$hrs_back[$prev_hr]."</option>";
				}
				else
				{
					echo "<option value=\"".$cur_hr."\" selected>".$hrs_back[$cur_hr]."</option>";
				}
			}
		}
		else
		{
			echo "<option value=\"".$cur_hr."\" selected>".$hrs_back[$cur_hr]."</option>";
		}
	}
	
}
?>
</select>
</td>
<?php
}
?>
<th>Shift:</th><td> <select name="shift" id='shift' class='form-control'>
<?php
$sql1="select * from $brandix_bts.tbl_shifts_master";
$result1=mysqli_query($link, $sql1) or exit("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($result1))
{
	if(str_replace(" ","",$sql_row1['id'])==str_replace(" ","",$shift))
	{
		echo "<option value=\"".$sql_row1['id']."\" selected>".$sql_row1['shift_name']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row1['id']."\">".$sql_row1['shift_name']."</option>";
	}
	
}
?>
</select>
</td>
<th>Module:</th><td> <select name="module" id='module' class='form-control'>
<?php
$sql="select * from $brandix_bts.tbl_module_ref";
$result=mysqli_query($link, $sql) or exit("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));

if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$module))
{
	echo "<option value=\"-1\" selected>EMB</option>";
}
while($sql_row=mysqli_fetch_array($result))
{
	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$module))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['id']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['id']."</option>";
	}
	
}
?>
</select>
<td><span id="msg" style="display:none;">Please Wait...</span>
	<input type="submit" name="submit" class='btn btn-primary' id='submit' value="Submit" onclick="document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';"></td>
</table>

</form>


<?php
if(isset($_POST['submit']))
{
	
	$emp_id=$_POST['emp_no'];
	$module_id=$_POST['module'];
	$shift=$_POST['shift'];
	//$shift=$_POST['op_date'];
	//$hour=$_POST['hour'];
	$hour=date('H');
	if($shift==1)
	{
		$shift_ops='A';
	}
	else
	{
		$shift_ops='B';
	}
	if($cur_date<=$ex_date && $cur_hour<=$ex_hour && in_array($username,$authorized))
	{
		if($_POST['op_date']==date("Y-m-d"))
		{
			$operation_date=date("Y-m-d")." $hour:00:00";
		}
		else
		{
			$operation_date=$_POST['op_date']." 21:00:00";
		}
		$operation_date_n=date("Y-m-d H:i:s");		
		$mod_shift=$_POST['op_date']."/".$module_id."/".$shift_ops;
	}
	else
	{
		//$operation_date=date("Y-m-d")." $hour:00:00";
		$operation_date=date("Y-m-d H:i:s");		
		$operation_date_n=date("Y-m-d H:i:s");
		$mod_shift=$module_id."/".$shift_ops;
	}
	//echo date("Y-m-d H:i:s")."<br>";
	//echo $opration_date."<br>";


	$emp_id=$username;
	
	//$sql="insert into(date_time,operation_time,employee_id,shift,trans_status,module_id) values('".date("Y-m-d H:i:s")."','$date $time:00','".$emp_id."','".$shift."','Yes','".$module_id."')";
	$sql="INSERT INTO $brandix_bts.`bundle_transactions` (`date_time`, `operation_time`, `employee_id`, `shift`, `trans_status`, `module_id`) 
	VALUES ('".$operation_date."','".$operation_date_n."','".$emp_id."','".$shift."','Yes','".$module_id."')";
	//echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error-1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
	$url_01 =  getFullUrl($_GET['r'],'bundle_scan_ops.php','N');
	header("Location: $url_01&id=$id&mod_id=$mod_shift");
	


}
?> 
</div>
</div>

<style>

#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>