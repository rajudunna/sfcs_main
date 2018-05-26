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
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
//var phn = document.getElementById('txtPhn');
//swal(keycode);
//comparing pressed keycodes
if (keycode < 48 || keycode > 57)
{
	if(keycode==45)
	{
	
	}
	else
	{
	return false;
	}
}

}
function validateQty(event) {
    var key = window.event ? event.keyCode : event.which;
	//swal(key);
if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 45 || event.keyCode == 13) {
    return true;
}
else if ( key < 48 || key > 57 ) {
    return false;
}
else 
{
return true;

}
}
function focus_box()
{
	document.input.bundle_id.focus();
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body onload="focus_box()">
<div class="panel panel-primary">
	<div class="panel-heading">Bundle Scanning Form</div>
	<div class="panel-body">
<?php
$global_path = getFullURLLevel($_GET['r'],'',4,'R');
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'ajax_bundle_validation.php',0,'R'));

?>

<?php
error_reporting(0);
$id=$_REQUEST['id'];
$mod_id=$_REQUEST['mod_id'];

error_reporting(E_ERROR | E_WARNING | E_PARSE);
$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");
?>
<h2 style='background-color: MidnightBlue ;text-align: center;color:orangered;' >Selected Module/Shift-<?php echo $mod_id;?></h2>
<hr>
<form name="input" action="?r=<?= $_GET['r']?>" method="post" enctype="multipart/form data">
<table class="mytable1 table table-bordered" border=0 cellpadding=0 cellspacing=0>
<tr>
	<th>Bundle Bar-code :</th>
	<td><input type="text" class="form-control" autocomplete="off" name="bundle_id" id="bundle_id" value="" onkeypress='return validateQty(event);'>
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<input type="hidden" name="mod_id" value="<?php echo $mod_id;?>"></td>

</table>

</form>


<?php
if(isset($_POST['bundle_id']) or isset($_REQUEST['bundle_id2']))
{
	if($_POST['bundle_id']!='')
	{
		$bundle=$_POST['bundle_id'];
	}
	else if($_POST['bundle_id2']!='')
	{
		$bundle=$_POST['bundle_id2'];
	}
	$id=$_POST['id'];
	$mod_id=$_POST['mod_id'];
	if (strpos($bundle, '-') != false) 
	{
		$bundle_details=explode("-",$bundle);
		$bundle_id = ltrim($bundle_details[0], '0');
		$operation_id = ltrim($bundle_details[1], '0');
		//$ops_check=echo_title("tbl_orders_ops_ref","count(*)","default_operation='YES' and id",$operation_id,$link);
		//if($ops_check>0)
		//{			
			$bund_quantity=bundle_quantity($bundle,$link);
			$barcode_ops=echo_title("bundle_transactions_20_repeat","count(*)","operation_id='".$operation_id."' and bundle_id",$bundle_id,$link);
			//echo $bund_quantity."--<br>";
			if($barcode_ops>0)
			{
				echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:red;' >Bundle Already scanned</h4>";
			}
			else
			{
				if($bund_quantity == 'QN')
				{
					echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:red;' >Cut Quantity is not Available.</h4>";
				}
				else if($bund_quantity == 'OPN')
				{
					echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:red;' >Entered Operation id is Not Available.</h4>";
				}
				else if($bund_quantity == 'PO')
				{
					echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:orangered;' >Previous Operation Not Done</h4>";
				}
				else if($bund_quantity == 'NA')
				{
					echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:orangered;' >Bundle Not Available</h4>";
				}
				else if($bund_quantity == 'C')
				{
					echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:orangered;' >Total Operations Completed</h4>";
				}
				else if($bund_quantity == 'CS')
				{
					echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:orangered;' >Cut Reporting Pending</h4>";
				}
				else
				{		
					if($id > 0 && $bundle<>'')
					{
						$sql="insert into $brandix_bts.`bundle_transactions_20_repeat` (`parent_id`, `bundle_barcode`, `quantity`, `bundle_id`, `operation_id`, `rejection_quantity`) values ('$id', '$bundle', '$bund_quantity', '$bundle_id', '$operation_id', '0')";
						$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_2<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql."<br>";
						if($operation_id=='4')
						{
							$moid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
							$mo_no=echo_title("bundle_transactions_20_repeat","act_module","id",$moid,$link);
							echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:limegreen;' >Bundle Inserted in Line no-".$mo_no."</h4>";
						}
						else
						{
							echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:limegreen;' >Bundle Inserted Successfully</h4>";
						}
					}
					else
					{
						echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:limegreen;' >Parent id missing please select again.</h4>";
					}
				}
				
			}
		/*	
		}	
		else
		{
			echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:red;' >Entered Operation id is Not Valid.</h4>";
		}	
*/		
	}
	else
	{
		echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:green;' >Enter Correct Bundle Id.</h4>";
	}
	echo "<input type=\"hidden\" name=id value=\"$id\" >";
	echo "<input type=\"hidden\" name=mod_id value=\"$mod_id\" >";
}

	if($_GET['update_ajax']==1)
	{
		echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:yellow;' >Rejection Updated</h4>";
	}
	else if($_GET['update_ajax']==3)
	{
		echo "<h4 style='background-color: MidnightBlue ;text-align: center;color:YellowGreen;' >Transaction Cancelled</h4>";
	}
	
	$sql1="select * from $brandix_bts.`bundle_transactions_20_repeat` where parent_id='".$id."' order by id desc";
	$sql_result1=mysqli_query($link, $sql1) or exit($sql."Sql Error-echo_2<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
	$i=mysqli_num_rows($sql_result1);
	if(mysqli_num_rows($sql_result1)>0)
	{
		echo "<table border=1px class='table table-bordered'><tr><th>S.no</th><th>Bundle Number</th><th>Operation</th><th>Quantity</th><th>Rejection</th><th colspan=2>Control</th></tr>";
		while($row=mysqli_fetch_array($sql_result1))
		{
			$operation_id=$row['operation_id'];
			$bundle=$row['bundle_barcode'];
			echo "<tr>";	
			echo "<td>".$i."</td>";
			echo "<td>".$row['bundle_id']."</td>";
			echo "<td>".$row['operation_id']."</td>";
			echo "<td>".$row['quantity']."</td>";
			echo "<td>".$row['rejection_quantity']."</td>";
			//$ord_id=echo_title("tbl_orders_ops_ref","ops_order","default_operation='YES' and id",$row['operation_id'],$link);
			//$max_ops_id=echo_title("tbl_orders_ops_ref","id","default_operation='YES' and ops_order",$ord_id,$link);
			$check=bundle_ops_check($row['bundle_id'],$operation_id,$link);
			$val=explode("$",$check);
			$operation_p = ltrim($val[0], '0');
			$max_ops_id = ltrim($val[1], '0');
			$check_nxt_ops=echo_title("brandix_bts.bundle_transactions_20_repeat","count(*)","operation_id='".$operation_p."' and bundle_id",$row['bundle_id'],$link);
			
			if($check_nxt_ops>0)
			{
				echo "<td colspan=2>None</a></td>";	
			}
			else
			{
				if($operation_id==4)
				{
					$rejection=echo_title("brandix_bts.bundle_transactions_20_repeat","rejection_quantity","operation_id='".$operation_id."' and bundle_id",$row['bundle_id'],$link);
					if($rejection>0)
					{
						echo "<td colspan=2>Updated</a></td>";	
					}
					else
					{
						$url_001 = getFullUrl($_GET['r'],'update_ops.php','N');
						echo "<td><a href=\"$url_001&id=$id&mod_id=$mod_id&bundle_id=$bundle&ops=1\" >Edit</a></td>";
					}
				}
				else
				{
					echo "<td colspan=2>None</a></td>";	
				}
			}
			$i--;
			
		}
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