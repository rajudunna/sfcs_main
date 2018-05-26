<?php
	$global_path = getFullURLLevel($_GET['r'],'',4,'R');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" type="text/css" href="table.css">
<!-- <style type="text/css">
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
</style> -->
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
	//alert("report");
	var url1 = '<?= getFullUrl($_GET['r'],'mini_order_create.php','N'); ?>';
	window.location.href = url1+"&style="+document.mini_order_report.style.value;
}

function secondbox()
{
	//alert('test');
	var url1 = '<?= getFullUrl($_GET['r'],'mini_order_create.php','N'); ?>';
	window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value;
}

function tot_sum()
{
	//alert('Test');
	
	
	
	//return false;
}
function check_val()
{
	//alert('dfsds');
	var style=document.getElementById("style").value;
	var schedule=document.getElementById("schedule").value;
	
	if(style == 'NIL' || schedule == 'NIL' || mini_order == 'NIL')
	{
		alert('Please select the values');
		//document.getElementById('msg').style.display='';
		document.getElementById('submit').style.display=''
		document.getElementById('msg').style.display='none';
		return false;
	}
	//return false;	
}
function check_val1()
{
	//alert('Test');
	var bundle_size=document.getElementById("bundle_plies").value;
	var bundle_per_size=document.getElementById("bundle_per_size").value;
	var mini_order_qty=document.getElementById("mini_order_qty").value;
	
	if(bundle_size>=1 && mini_order_qty>1)
	{
		//alert('Ok');
	}
	else
	{
		alert('Please Check the values.');
		document.getElementById('generate').style.display='';
		document.getElementById('msg1').style.display='none';
		return false;
	}
	if(confirm("Do you need Bundle Split..?") == true )
	{
		document.getElementById('split_option').value=1;
		if(confirm("Mini Order Quantity :"+mini_order_qty) == true )
		{
			//alert("ok");
			//return false;	
			
		}
		else
		{
			//alert("No");
			document.getElementById('msg1').style.display='none';
			document.getElementById('generate').style.display='';
			return false;
		}
		
	}
	else
	{
		document.getElementById('split_option').value=2;
		if(confirm("Mini Order Quantity :"+mini_order_qty) == true )
		{
			//alert("ok");
			//return false;	
			
		}
		else
		{
			//alert("No");
			document.getElementById('msg1').style.display='none';
			document.getElementById('generate').style.display='';
			return false;
		}
	}
	
	
	//return false;
}

function openWin() {
    //window.open("http://baidevsrv1:8080/projects/beta/bundle_tracking_system/brandix_bts/mini_order_report/bundle_alloc_save.php");
}
function validate(id,key)
{
//getting key code of pressed key
//alert('okaeyup');
var keycode = (key.which) ? key.which : key.keyCode;
//alert(id);
//alert(keycode);
//comparing pressed keycodes
if (keycode < '48' || keycode > '57')
{
	if(keycode==8 || keycode==46 || keycode==9 || keycode==16)
	{
		
	}
	else
	{
		document.getElementById(id).value=1;
	}
}
	var bundle_plies=document.getElementById("bundle_plies").value;
	var bundle_per_size=document.getElementById("bundle_per_size").value;
	var carton_qty=document.getElementById("carton_qty").value;
	mini_order_qty=document.getElementById("mini_order_qty").value=bundle_plies*bundle_per_size*carton_qty;
}
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">

<div class="panel-heading">Mini Order Creation</div>
<div class="panel-body">
<?php 
$authorized=array('kirang'); 
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0271",$username,1,$group_id_sfcs);
?>

<?php
// error_reporting(0);

// // Report simple running errors
// error_reporting(E_ERROR | E_WARNING | E_PARSE);


if(isset($_POST['style']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
}
//echo $_GET['ops']."<br>";
//echo $style.$schedule.$color;
?>

<form name="mini_order_report" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();">
<br>
<div class="form-group col-lg-2">
<label>Select Style:</label>
<?php

echo "<select id=\"style\" name=\"style\" class=\"form-control\" onchange=\"firstbox();\">";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_style_ref";	
//}
//mysql_query($sql,$link) or exit("Sql Error1".mysql_error());
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])."-".mysqli_errno($link));
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
<div class="col-lg-2 form-group">
<label>Select Schedule:</label>

<?php

echo "<select id=\"schedule\" class=\"form-control\" name=\"schedule\">";

//$sql="select distinct style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";	
//}
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
	{
		echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
	}

}

echo "</select>";

?>
</div>
<br>
<div class="col-lg-2 form-group" >
	<label></label>
 <?php 
	//echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";	
		echo "<input  class='btn btn-sm btn-primary' type=\"submit\" value=\"submit\" name=\"submit\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg').style.display='';\"/>";
		echo "<span id=\"msg\" style=\"display:none;\"><h5>Please Wait...<h5></span>";

?>
</div>

</form>


<?php
if(isset($_POST['submit']))
{
	$style_id=$_POST['style'];
	$sch_id=$_POST['schedule'];
	//echo $style."<bR>";
	$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_id,$link);
	$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$sch_id,$link);
	$mini_order_ref = echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$sch_id,$link);
	$bundle = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$mini_order_ref,$link);
	$c_ref = echo_title("brandix_bts.tbl_carton_ref","id","ref_order_num",$sch_id,$link);
	$carton_qty = echo_title("brandix_bts.tbl_carton_size_ref","sum(quantity)","parent_id",$c_ref,$link);
	//echo $mini_order_ref."<br>";
	if($carton_qty>0)
	{
		$sql="select * from $brandix_bts.tbl_min_ord_ref where ref_crt_schedule='".$sch_id."' and ref_product_style='".$style_id."'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result)>0)
		{
			while($row=mysqli_fetch_array($sql_result))
			{ 
				$bundle_size=$row['miximum_bundles_per_size'];
				$bundle_plie=$row['max_bundle_qnty'];
				$mini_qty=$row['mini_order_qnty'];
				$split_qty=$row['split_qty'];
			}
		}
		else
		{
			$bundle_size=1;
			$bundle_plie=1;
			$mini_qty=$bundle_size*$bundle_plie*$carton_qty;
			$split_qty=45;
		}
		//$o_colors = echo_title("bai_pro3.bai_orders_db","group_concat(distinct order_col_des order by order_col_des)","order_del_no",$schedule,$link);
		$sql1="select order_col_des from $bai_pro3.bai_orders_db where order_del_no='".$schedule."' group by order_col_des";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row1=mysqli_fetch_array($sql_result1))
		{
			$order_colors[]=$row1['order_col_des'];
		}
		$sql2="select order_col_des from $brandix_bts.tbl_orders_sizes_master where parent_id='".$sch_id."' group by order_col_des";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($sql_result2))
		{
			$planned_colors[]=$row2['order_col_des'];
		}
		//$p_colors = echo_title("brandix_bts.tbl_orders_sizes_master","group_concat(distinct order_col_des order by order_col_des)","parent_id",$sch_id,$link);
		//$order_colors=explode(",",$o_colors);	
		//$planned_colors=explode(",",$p_colors);
		//echo sizeof($order_colors)."---".sizeof($planned_colors)."<br>";
		$val=sizeof($order_colors);
		$val1=sizeof($planned_colors);
		$ii=0;
		if($val==$val1 )
		{
			$ii=1;
		}
		if($bundle==0)
		{
			$status='';
		}
		else
		{
			$status='readonly';
		}
		echo '<form name="input" method="post" action=?r='.$_GET['r'].' onsubmit=" return check_val1();">';
		echo  "<input type=\"hidden\" value=\"$style_id\" id=\"style_id\" name=\"style_id\">";
		echo  "<input type=\"hidden\" value=\"\" id=\"split_option\" name=\"split\">";
		echo  "<input type=\"hidden\" value=\"$sch_id\" id=\"sch_id\" name=\"sch_id\">";
		echo "<h2>Style :<b>$style</b></h2>";
		echo "<div class='table-responsive'><table class='table table-bordered' border=1px><tr><th >Schedule</th><th>Total Colors</th><th>Planned Colors</th><th >Carton Quantity</th><th >Max Plies</th><th >Max bundles per size</th><th>Mini Order Quantity</th><th>Split Quantity</th><th>Control</th></tr>";
		//echo $val."--".$val1."---".$status."<br>";
		echo "<tr><td rowspan=$val>$schedule</td>";
		for($i=0;$i<sizeof($order_colors);$i++)
		{
			if($i!=0)
			{
				echo "<tr>";
			}
			echo "<td>".$order_colors[$i]."</td>";
			echo "<td>".$planned_colors[$i]."</td>";
			if($i==0)
			{
				echo "<td rowspan=$val>".$carton_qty."<input type=\"hidden\" value=\"$carton_qty\" id=\"carton_qty\" name=\"carton_qty\" ></td>
				<td rowspan=$val><input type=\"text\" value=\"$bundle_plie\" id=\"bundle_plies\" name=\"bundle_plies\" onkeyup=\"validate(this.id,event)\" $status></td>
				<td rowspan=$val><input type=\"text\" value=\"$bundle_size\" id=\"bundle_per_size\" name=\"bundle_per_size\"  onkeyup=\"validate(this.id,event)\" $status></td>
				<td rowspan=$val><input type=\"text\" value=\"$mini_qty\" id=\"mini_order_qty\" name=\"mini_order_qty\" onkeyup=\"tot_sum()\" readonly></td>
				<td rowspan=$val><input type=\"text\" value=\"$split_qty\" id=\"split_qty\" name=\"split_qty\" onkeyup=\"validate(this.id,event)\" ></td>";
				if($ii==1)
				{
					if($bundle>0)
					{
						echo "<td rowspan=$val>MiniOrder generation Completed.</td>";
					}
					else
					{
						echo "<td rowspan=$val><input class='btn btn-sm btn-primary' type=\"submit\" value=\"Generate\" name=\"generate\" id=\"generate\" onclick=\"document.getElementById('generate').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
						echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait..Mini orders Generating.<h5></span></td>";
					}
				}
				else
				{
					echo "<td rowspan=$val>Some colors are Pending.</td>";
				}			
				echo "</tr>";
					
			}
			else
			{
				echo "</tr>";
			}
		}
		echo "</table></div>";
		echo "</form>";
	}
	else
	{
		echo "<h2>Please update the Carton Properties</h2>";
	}
	
	
}
if(isset($_POST['generate']))
{
	$style=$_POST['style_id'];
	$split=$_POST['split'];
	$split_qty=$_POST['split_qty'];
	$scheudle=$_POST['sch_id'];
	$mini_order_ref =echo_title("brandix_bts.tbl_min_ord_ref","id","ref_crt_schedule",$scheudle,$link);
	$carton_qty=$_POST['carton_qty'];
	$bundle_plies=$_POST['bundle_plies'];
	$bundle_per_size=$_POST['bundle_per_size'];
	$mini_order_qty=$_POST['mini_order_qty'];
	if($bundle_plies!=0 && $bundle_per_size!=0 && $mini_order_qty!=0)
	{
		if($mini_order_ref>0)
		{
			$sql="update $brandix_bts.`tbl_min_ord_ref` set max_bundle_qnty='".$bundle_plies."', miximum_bundles_per_size='".$bundle_per_size."',mini_order_qnty='".$mini_order_qty."',split_qty='".$split_qty."' where id='".$mini_order_ref."'";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$id=$mini_order_ref;
		}
		else
		{
			$sql="insert into $brandix_bts.`tbl_min_ord_ref` (`ref_product_style`, `ref_crt_schedule`, `carton_quantity`, `max_bundle_qnty`, `miximum_bundles_per_size`, `mini_order_qnty`,`split_qty`) values ('".$style."', '".$scheudle."', '".$carton_qty."', '".$bundle_plies."', '".$bundle_per_size."', '".$mini_order_qty."','".$split_qty."')";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$id=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
		}
	}
	else
	{
		echo "<h2>Please Fill Correct values</h2>";
	}
	//echo $id."<br>";
	//echo "<a href=\"mini_order_gen.php?id=$id\">Generate Mini Orders</a>";
	//echo "<h2>Mini orders Generation under process Please wait.....<h2>";
	header("Location:mini_order_gen.php?id=$id&split_code=$split");
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