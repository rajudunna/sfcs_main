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
	var url1 = '<?= getFullUrl($_GET['r'],'mini_order_deletion.php','N'); ?>';
	
	window.location.href = url1 + "&style="+document.mini_order_report.style.value;
}

function secondbox()
{
	//alert('test');
	var url1 = '<?= getFullUrl($_GET['r'],'mini_order_deletion.php','N'); ?>';
	
	window.location.href = url1 + "&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
}

function check_val1()
{
	//alert('Test');
	var tot_cnt=document.getElementById("tot_cnt").value;
	var tot_bund=document.getElementById("bundle_tot").value;
	var total=0;
	//alert(tot_cnt);
	//alert(tot_bund);
	for(var i=1;i<tot_cnt;i++)
	{
		var total=parseInt(document.getElementById("total["+i+"]").value)+parseInt(total);
	}
	if(total==tot_bund)
	{
		//alert('Ok');
	}
	else
	{
		alert('Allocation Pending/Exceed for some Colors.');
		return false;
	}
	
	
	//return false;
}
function check_val()
{
	//alert('dfsds');
	var style=document.getElementById("style").value;
	var schedule=document.getElementById("schedule").value;
	var mini_order=document.getElementById("mini_order_num").value;
	
	if(style == 'NIL' || schedule == 'NIL' || mini_order == 'NIL')
	{
		alert('Please select the values');
		return false;
	}	
}
function validate(key)
{
//getting key code of pressed key
var keycode = (key.which) ? key.which : key.keyCode;
var phn = document.getElementById('txtPhn');
//comparing pressed keycodes
if ((keycode < 48 || keycode > 57) && (keycode<46 || keycode>47))
{
return false;
}
else
{
//Condition to check textbox contains ten numbers or not
if (phn.value.length <10)
{
return true;
}
else
{
return false;
}
}
}

function validate_input(input_value,sno,i)
{
	if (/^[0-9]{1,20}$/.test(+input_value) && input_value.length<=10)
	{ 
	}
	else
	{
		alert('Please Enter Numbers Only'); 
		document.getElementById('mod['+sno+']['+i+']').value='';
		console.log('mod['+sno+']['+i+']');
	}
}
function validate_bundles(val,sno,rowid,lines_count,mini_order_rows)
{
	//alert('test');
	//alert('value = '+val+" rowid = "+sno+" module = "+line_id+" modules_count= "+lines_count);
	var total_qnty=0;
	var qnty=0;
	var total_available=Number(document.getElementById('bundles_count['+sno+']').value);
	//console.log(lines_count);
	for(var i=0;i<=lines_count;i++)
	{
		qnty=document.getElementById('mod['+sno+']['+i+']').value;
		//console.log('mod['+sno+']['+i+']');
		if(qnty!='')
		{
			qnty=Number(qnty);
		}
		else
		{
			qnty=Number(0);
		}
		//console.log('mod['+rowid+']['+sno+']');
		total_qnty+=Number(qnty);
		//console.log(total_qnty);
		if(total_qnty>total_available)
		{
			document.getElementById('total['+sno+']').value=total_qnty-document.getElementById('mod['+sno+']['+rowid+']').value;
			document.getElementById('mod['+sno+']['+rowid+']').value='0';
			document.getElementById('row'+sno).style.backgroundColor='#ff0000';
		}
		else
		{
			document.getElementById('total['+sno+']').value=total_qnty;
			if(total_qnty==total_available)
			{
				document.getElementById('row'+sno).style.backgroundColor='#00cc00';
			}
			else
			{
				document.getElementById('row'+sno).style.backgroundColor='';
			}
			
		}
		//qnty=0;
	}
	//console.log(total_qnty);
	calculate_totals(lines_count,mini_order_rows);
}
function calculate_totals(lines_count,mini_order_rows)
{
	var total_bundles=0;
	var bund_qnty='';
	var total_bundles_available=0;
	for(var i=0;i<=mini_order_rows;i++)
	{
		bundle_count=document.getElementById('bundles_count['+i+']').value;
		total_bundles_available+=Number(bundle_count);
		for(var j=0;j<=lines_count;j++)
		{
			bund_qnty=document.getElementById('mod['+i+']['+j+']').value;
			total_bundles+=Number(bund_qnty);
		}
	}
	if(total_bundles_available==total_bundles)
	{
		document.getElementById('submit').style.display='block';
	}
}
function openWin() {
    //window.open("http://baidevsrv1:8080/projects/beta/bundle_tracking_system/brandix_bts/mini_order_report/bundle_alloc_save.php");
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
	<div class="panel-heading">Mini Order Deletion</div>
	<div class="panel-body">
<?php 
//$authorized=array('kirang'); 
$global_path = getFullURLLevel($_GET['r'],'',4,'R');

include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0278",$username,1,$group_id_sfcs);
$authorized=user_acl("SFCS_0278",$username,7,$group_id_sfcs);
$authorized[]='kirang'; 
?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_danger | E_PARSE);

if(isset($_POST['style']))
{
    $style=$_POST['style'];
   
}
else
{
	$style=$_GET['style'];
	
}
//echo $_GET['ops']."<br>";
//echo $style.$schedule.$color;
?>

<form name="mini_order_report" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();">
<br>
<div class="form-group col-lg-2">
<label>Select Style:</label>
<?php

echo " <select id=\"style\" name=\"style\" class='form-control'>";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_style_ref";	
//}
// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
	}

}

echo "</select>";

?>
</div>

<div class="form-group col-lg-2">

 <?php
	//echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";	
	echo "<input type=\"submit\" class='btn btn-primary' style='margin-top: 20px' value=\"submit\" name=\"submit\">";	
?>
</div>


</form>


<?php
if(isset($_POST['submit']))
{
	$style_id=$_POST['style'];
	//echo $style."<bR>";
	$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
	$sql="select * from $brandix_bts.tbl_min_ord_ref where ref_product_style='".$style_id."' group by ref_crt_schedule order by id";
	//echo $sql."<br>";
	$result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<h2>Style :<b>$style</b></h2>";
	echo "<table border=1px class='table table-bordered'><tr><th>Schedule</th><th>Total Mini orders</th><th>Control</th></tr>";
	
//	echo $sql."<br>";
	while($m=mysqli_fetch_array($result))
	{
		$sch_id=$m['ref_crt_schedule'];
		$mini_ref=$m['id'];
		$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);	
		$mini_order_cnt = echo_title("$brandix_bts.tbl_miniorder_data","count(distinct mini_order_num)","mini_order_ref",$mini_ref,$link);	
		$mini_order_cnt_delete = echo_title("$brandix_bts.tbl_miniorder_data_deleted","count(distinct mini_order_num)","mini_order_ref",$mini_ref,$link);	
		//$mini_orders = echo_title("brandix_bts.tbl_miniorder_data","group_count(distinct mini_order_num)","mini_order_ref",$m['id'],$link);	
		echo "<tr><td>$schedule</td><td>$mini_order_cnt</td>";
		$status_print = echo_title("$brandix_bts.tbl_miniorder_data","group_concat(distinct mini_order_num)","mini_order_status=1 and mini_order_ref",$mini_ref,$link);
		//$sql1="select count(*) from brandix_bts.tbl_miniorder_data where mini_order_ref='".$m['mini_order_ref']."' and mini_order_status='1'";
		
		if(in_array($username,$authorized))
		{
			if($mini_order_cnt>0)
			{
				if($status_print=='')
				{
					$url1 = getFullUrl($_GET['r'],'miniorder_delete.php','N');
					
					echo "<td><a class='btn btn-danger' href='$url1&mini_order_ref=$mini_ref&ops=1'>Delete</a></td></tr>";
				}
				else
				{
					//echo "<td></td></tr>";
					$url1 = getFullUrl($_GET['r'],'miniorder_delete.php','N');
					
					echo "<td><a class='btn btn-danger' href='$url1&mini_order_ref=$mini_ref&ops=1'>Delete</a>/Tags generated for-($status_print).</td></tr>";
				}
			}
			else
			{
				echo "<td>Mini order Not generated.</td>";
			}
			
		}
		else
		{
			if($mini_order_cnt>0)
			{
				if($status_print=='')
				{
					$url1 = getFullUrl($_GET['r'],'miniorder_delete.php','N');
					
					echo "<td><a class='btn btn-danger' href='$url1&mini_order_ref=$mini_ref&ops=1'>Delete</a></td></tr>";
				}
				else
				{
					
					echo "<td>Tags generated for-($status_print).</td></tr>";
				}
			}
			else
			{
				echo "<td>Mini order Not generated.</td></tr>";
			}

		}		
	}	
	
}

if(isset($_GET['deleted']) && $_GET['deleted'] == 'yes'){
	echo "<script>swal('Successfully deleted','', 'success')</script>";
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