<?php $has_permission = haspermission($_GET['r']); ?>
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
	var ajax_url ="../mini_order_report/mini_order_deletion.php?style="+document.mini_order_report.style.value;Ajaxify(ajax_url);

}

function secondbox()
{
	//alert('test');
	var ajax_url ="../mini_order_report/mini_order_deletion.php?style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
	Ajaxify(ajax_url);

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
<!---<div id="page_heading"><span style="float: left"><h3>Mini Order Deletion</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<?php 
//$authorized=array('kirang'); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
// $view_access=user_acl("SFCS_0278",$username,1,$group_id_sfcs);
// $authorized=user_acl("SFCS_0278",$username,7,$group_id_sfcs);

?>

<?php
error_reporting(0);

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// include("dbconf.php");

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

<form name="mini_order_report" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post" onsubmit=" return check_val();">
<br>
<?php
echo "<div class='col-md-3 col-sm-3 col-xs-12'>";
echo "Select Style: <select id=\"style\" name=\"style\" class=\"select2_single form-control\">";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";	
//}
mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
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
echo "</div>";
?>


 <?php
	//echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";	
	//echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";
echo "<div class='col-md-3 col-sm-3 col-xs-12' style='margin-top: 16px;'>";	
echo "<input type=\"submit\"  value=\"submit\" class=\"btn btn-primary\" name=\"submit\" id=\"submit\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
echo "</div>";
    // echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait...!<h5></span>";	
?>


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
	echo "<table class='table table-bordered'><tr><th>Schedule</th><th>Total Mini orders</th><th>Control</th></tr>";
	
//	echo $sql."<br>";
	while($m=mysqli_fetch_array($result))
	{
		$sch_id=$m['ref_crt_schedule'];
		$mini_ref=$m['id'];
		$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);	
		//$schedule_status = echo_title("bai_pro3.bai_orders_db_confirm","order_joins","order_del_no",$schedule,$link);	
		$mini_order_cnt = echo_title("$brandix_bts.tbl_miniorder_data","count(distinct mini_order_num)","mini_order_ref",$mini_ref,$link);	
		$mini_order_cnt_delete = echo_title("$brandix_bts.tbl_miniorder_data_deleted","count(distinct mini_order_num)","mini_order_ref",$mini_ref,$link);	
		//$mini_orders = echo_title("$brandix_bts.tbl_miniorder_data","group_count(distinct mini_order_num)","mini_order_ref",$m['id'],$link);	
		echo "<tr><td>$schedule</td><td>$mini_order_cnt</td>";
		$status_print = echo_title("$brandix_bts.tbl_miniorder_data","group_concat(distinct mini_order_num)","mini_order_status=1 and mini_order_ref",$mini_ref,$link);
		$mrn_status = echo_title("$m3_bulk_ops_rep_db.m3_sfcs_mrn_log","count(*)","sfcs_schedule",$schedule,$link);
		//$sql1="select count(*) from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$m['mini_order_ref']."' and mini_order_status='1'";
		if($mrn_status==0)
		{
			if(in_array($authorized,$has_permission))
			{
				if($mini_order_cnt>0)
				{
					$url=getFullURLLevel($_GET['r'],'miniorder_delete.php',0,'N');
					if($status_print=='')
					{
						echo "<td><a href='$url&sch=$schedule&mini_order_ref=$mini_ref&ops=1'>Delete</a></td></tr>";
					}
					else
					{
						//echo "<td></td></tr>";
						echo "<td><a href='$url&sch=$schedule&mini_order_ref=$mini_ref&ops=1'>Delete</a>/Tags generated for-($status_print).</td></tr>";
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
						$url=getFullURLLevel($_GET['r'],'miniorder_delete.php',0,'N');
						echo "<td><a href='$url&sch=$schedule&mini_order_ref=$mini_ref&ops=1'>Delete</a></td></tr>";
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
		else
		{
			echo "<td>MRN already confirmed.</td></tr>";
		}	
	}	
	
}

?> 
</div>
</div>
</body>
<!---<style>

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
</style>--->