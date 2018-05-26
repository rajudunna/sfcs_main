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
/* body{  */
	/* margin:15px; padding:15px; border:1px solid #666; */
	/* font-family:Arial, Helvetica, sans-serif; font-size:88%;  */
/* } */
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
	var url1 = '<?= getFullUrl($_GET['r'],'mini_order_priority.php','N'); ?>';
	
	//swal("report");
	window.location.href = url1 + "&style="+document.mini_order_report.style.value
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
</script>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="panel panel-primary">
	<div class="panel-heading">Mini Order Scheduling</div>
	<div class='panel-body'>
<?php 
$global_path = getFullURLLevel($_GET['r'],'',4,'R');

include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'dbconf.php',0,'R'));
include($_SERVER['DOCUMENT_ROOT'].$global_path."/common/config/user_acl_v1.php");
$view_access=user_acl("SFCS_0275",$username,1,$group_id_sfcs); 
$authorized_to_modify=user_acl("SFCS_0275",$username,1,$group_id_sfcs); 

?>

<?php
error_reporting(0);
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$hrs=array('08','09','10','11','12','13','14','15','16','17','18','19','20','21');
if(isset($_POST['style']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
	//$mini_order_num=$_POST['mini_order_num']; 
	//$color=$_POST['color'];
}
else
{
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	//$mini_order_num=$_GET['mini_order_num'];
	//$color=$_GET['color']; 
}

//echo $style.$schedule.$color;
?>

<form name="mini_order_report" action="?r=<?php echo $_GET['r']; ?>" method="post" onsubmit=" return check_val();">
<br>
<div class="form-group col-lg-2">
<label>Select Style:</label>
<?php

echo "<select name=\"style\" id='style' class='form-control' onchange=\"firstbox();\" >";

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
<label>Select Schedule:</label>
<?php

echo "<select name=\"schedule\" class='form-control' id='schedule'>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select id,product_schedule as schedule from $brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule";	
	//$sql="select product_schedule as schedule,id from tbl_orders_master where ref_product_style=$style group by schedule";
//}
//echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
/*
if(str_replace(" ","",0)==str_replace(" ","",$c_block))
{
echo "<option value=\"0\" selected>All Country blocks</option>";
}
else
{
	echo "<option value=\"0\">All Country block</option>";
}*/
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['schedule']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['id']."\">".$sql_row['schedule']."</option>";
}

}


echo "</select>";

?>
</div>
<div class="form-group col-lg-2">
	<label>Select Type:</label>
	<select name="type" id='type' class='form-control'>
	<option value="1" <?php if($_POST['type'] == 1){echo "selected";} ?> > Schedule Wise plan </option>
	<option value="2" <?php if($_POST['type'] == 2){echo "selected";} ?> > Mini Order Level plan </option>
	</select>
</div>
<div class="form-group col-lg-2">
 	<?php
		echo "<input type=\"submit\" class='btn btn-primary' style='margin-top: 20px' value=\"submit\" name=\"submit\">";	
	?>
</div>


</form>


<?php
if(isset($_POST['submit']))
{
	$i=0;
	$style_code=$_POST['style'];
	$schedule_code=$_POST['schedule'];
	$type=$_POST['type'];
	$mini_order_ref= echo_title("brandix_bts.tbl_min_ord_ref","id","ref_product_style='".$style_code."' and ref_crt_schedule",$schedule_code,$link);
	// var_dump($mini_order_ref);	
	$style = echo_title("brandix_bts.tbl_orders_style_ref","product_style","id",$style_code,$link);
	$schedule = echo_title("brandix_bts.tbl_orders_master","product_schedule","id",$schedule_code,$link);
	$bundles = echo_title("brandix_bts.tbl_miniorder_data","count(*)","mini_order_ref",$mini_order_ref,$link);
	if($type=='1')
	{		
		$check_trim=echo_title("bai_pro3.trims_dashboard","max(tid)","tid",$mini_order_ref,$link);
		//echo $check_trim."<bR>";
		if($check_trim == 0)
		{
			if($bundles>0)
			{
				$sql="select mini_order_num,min(docket_number) from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' group by mini_order_num";
				// echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				echo '<form name="input" method="post" action="?r='.$_GET['r'].'" onsubmit="return check_val1();">';
				echo "<table border=1px class='table table-bordered'><tr><th>Style</th><th>Schedule</th><th>Module</th><th>Plan Date</th><th>Control</th></tr>";
				echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";
				echo "<tr><td>$style</td><td>$schedule</td>";
				if(in_array($username,$authorized_to_modify))
				{
					echo "<td><input type=\"text\" class='form-control' name='module' value='' ></td>";
				}
				echo "<td><div><input id=\"plandate\" data-toggle='datepicker' type=\"text\" class='textbox form-control' name=\"plandate\" value=\"".$cut_date_ref."\"><br><br>";
				echo "<select name='hrs' id='hrs' class='form-control'>";
				for($ii=0;$ii<sizeof($hrs);$ii++)
				{
					echo "<option value='".$hrs[$ii]."'>".$hrs[$ii]."</option>";
				}
				echo "</select>";
				echo "</td><td><input type=\"submit\" class='btn btn-primary' value=\"Allocate\" name=\"schedule_save\"></div>";
				echo "</td></tr>";
				echo "</table>";
				echo "</form>";
			}
			else
			{
				echo "<h2>Mini Order not generated.</h2>";
			}
		}
		else
		{
			echo "<h3>Already plan completed for some mini orders, Please use Mini order type.</h3>";
		}
	}
	else
	{
		
		if($bundles>0)
		{
			$sql="select mini_order_num from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' and  planned_module<>0 group by mini_order_num order by mini_order_num";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo '<form name="input" method="post" action="?r='.$_GET['r'].'" onsubmit=" return check_val1();">';
			$j=0;
			if(mysqli_num_rows($sql_result)>0 or in_array($username,$authorized_to_modify))
			{
				if(mysqli_num_rows($sql_result)==0)
				{
					$sql="select mini_order_num from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' group by mini_order_num order by mini_order_num";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
				}
				echo "<table border=1px class='table table-bordered'><tr><th>Style</th><th>Schedule</th><th>Mini Order</th><th>Allocate modules</th><th>Planned Date & Time</th></tr>";
				echo "<input type=\"hidden\" value=\"$mini_order_ref\" name=\"mini_order_ref\">";
				while($row=mysqli_fetch_array($sql_result))
				{
					echo "<input type=\"hidden\" value=".$row['mini_order_num']." name=\"mini_order_num[".$i."]\">";
					echo "<tr><td>$style</td><td>$schedule</td>";
					echo "<td>".$row['mini_order_num']."</td>";
					$module=echo_title("bai_pro3.trims_dashboard","module","mini_ord_num=".$row['mini_order_num']." and mini_ord_ref",$mini_order_ref,$link);
					$sql1="select planned_module from $brandix_bts.tbl_miniorder_data where planned_module<>0 and mini_order_ref='".$mini_order_ref."' and mini_order_num=".$row['mini_order_num']." group by planned_module order by planned_module";
					//echo $sql1."<br>";
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$rows=mysqli_num_rows($sql_result1);
					if($rows==0 && in_array($username,$authorized_to_modify))
					{
						echo "<td><input type=\"text\" class='form-control' name='module[".$j."]' value='$module' ></td>";
					}
					else
					{
						echo "<td>";
						while($row1=mysqli_fetch_array($sql_result1))
						{
							if($module==$row1['planned_module'])
							{
								echo "<input type=\"radio\" name='module[".$j."]' value='".$row1['planned_module']."' checked=\"checked\">".$row1['planned_module']."";
							}
							else
							{
								echo "<input type=\"radio\" name='module[".$j."]' value='".$row1['planned_module']."' >".$row1['planned_module']."";
							}
						}
					}
					$j++;
					echo "</td>";
					$check_trim=echo_title("bai_pro3.trims_dashboard","tid","mini_ord_num=".$row['mini_order_num']." and mini_ord_ref",$mini_order_ref,$link);
					$plan_time=echo_title("bai_pro3.trims_dashboard","plan_time","mini_ord_num=".$row['mini_order_num']." and mini_ord_ref",$mini_order_ref,$link);
					if($check_trim>0)
					{
						$cut_date_ref=echo_title("bai_pro3.trims_dashboard","trims_req_time","mini_ord_num=".$row['mini_order_num']." and mini_ord_ref",$mini_order_ref,$link);
						if(in_array($username,$authorized_to_modify))
						{
							$hour=date('H',strtotime($plan_time));
							echo "<td><input size=\"20\" id=\"plan_d".$i."\" onclick=\"javascript:NewCssCal('plan_d".$i."','yyyymmdd','dropdown')\" onclick=\"javascript:NewCssCal('plan_d".$i."','yyyymmdd','dropdown')\" type=\"text\" class='textbox form-control' name=\"plan_d[".$i."]\" size=8 value=\"".$plan_time."\">";
							echo "<select name='hrs[$i]' class='form-control'>";
							for($ii=0;$ii<sizeof($hrs);$ii++)
							{
								//echo $hour."--".$hrs[$ii]."<br>";
								if($hour == $hrs[$ii])
								{	
									echo "<option value='".$hrs[$ii]."' selected>".$hrs[$ii]."</option>";
								}
								else
								{
									echo "<option value='".$hrs[$ii]."'>".$hrs[$ii]."</option>";
								}
							}
							echo "</select>";
							//echo "</td><td><input type=\"checkbox\" value=\"1\" name=\"chk_b[".$i."]\"></td>";
							echo "</td></tr>";
						}
						else
						{
							echo "<td>".$plan_time."</td>";
							echo "<input type='hidden' id=\"plan_d".$i."\" name=\"plan_d[".$i."]\" size=8 value=\"\">";
												
						}
						
					}
					else
					{
						echo "<td><input size=\"20\" id=\"plan_d".$i."\" onclick=\"javascript:NewCssCal('plan_d".$i."','yyyymmdd','dropdown')\" onclick=\"javascript:NewCssCal('plan_d".$i."','yyyymmdd','dropdown')\" type=\"text\" class='textbox form-control' name=\"plan_d[".$i."]\" size=8 value=\"\">";
						echo "<select name='hrs[$i]' class='form-control'>";
						for($ii=0;$ii<sizeof($hrs);$ii++)
						{
							echo "<option value='".$hrs[$ii]."'>".$hrs[$ii]."</option>";
						}
						echo "</select>";
						//echo "</td><td><input type=\"checkbox\" value=\"1\" name=\"chk_b[".$i."]\"></td>";
						echo "</tr>";
					}
					$i++;
					$cut_date_ref='';
				}
				echo "</table>";
				echo "<input type=\"hidden\" value=\"$i\" name=\"count\">";
				echo "<input type=\"submit\" class='btn btn-primary' value=\"Allocate\" name=\"save\">";
			}
			else
			{
				echo "<h3>Bundle Allocation Pending.</h3>";
			}
			echo "</form>";
		}
		else
		{
			echo "<h2>Mini Order not generated.</h2>";
		}
	
	}
	
}
if(isset($_POST['save']))
{
	$mini_order_num=$_POST['mini_order_num'];
	$mini_order_ref=$_POST['mini_order_ref'];
	$modules=$_POST['module'];
	$chk_b=$_POST['chk_b'];
	$date=$_POST['plan_d'];
	$cnt=$_POST['count'];
	$bundle_alloc=array();
	$ii=1;$hrs=$_POST['hrs'];
	$sch_id = echo_title("brandix_bts.tbl_min_ord_ref","ref_crt_schedule","id",$mini_order_ref,$link);
	for($i=0;$i<$cnt;$i++)
	{
		if($date[$i]!='')
		{
			$module = $modules[$i];
			
			if($module>0)
			{				
				$section = echo_title("brandix_bts.tbl_module_ref","module_section","id",$module,$link);
				$check = echo_title("bai_pro3.trims_dashboard","tid","mini_ord_num=".$mini_order_num[$i]." and mini_ord_ref",$mini_order_ref,$link);
				$doc_no = echo_title("brandix_bts.tbl_miniorder_data","group_concat(distinct docket_number)","mini_order_num=".$mini_order_num[$i]." and mini_order_ref",$mini_order_ref,$link);
				//echo $doc_no."<br>";
				if($check>0)
				{
					$sql1="update $bai_pro3.trims_dashboard set module='".$module."',section='".$section."',plan_time='".$date[$i]." ".$hrs[$i]."',trims_req_time='".$date[$i]." ".$hrs[$i]."',log_user='".$username."',priority='".$ii."' where mini_ord_ref=".$mini_order_ref." and mini_ord_num=".$mini_order_num[$i]."";
					//echo $sql1."<br>";
					$result1=mysqli_query($link, $sql1) or exit("Sql Error-1".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql2="update $brandix_bts.tbl_miniorder_data set plan_date='".$date[$i]."' where mini_order_ref=".$mini_order_ref." and mini_order_num=".$mini_order_num[$i]."";
					//echo $sql2."<br>";
					$result2=mysqli_query($link, $sql2) or exit("Sql Error-2".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
					$ii++;
				}
				else
				{
					$sql1="insert into $bai_pro3.trims_dashboard(doc_ref,sch_id,mini_ord_ref,mini_ord_num,module,section,priority,plan_time,trims_req_time,log_user) 
					values('".$doc_no."','".$sch_id."','".$mini_order_ref."','".$mini_order_num[$i]."','".$module."','".$section."','".$ii."','".$date[$i]." ".$hrs[$i]."','".$date[$i]." ".$hrs[$i]."','".$username."')";
					$result1=mysqli_query($link, $sql1) or exit("Sql Error2-13".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql2="update $brandix_bts.tbl_miniorder_data set plan_date='".$date[$i]." ".$hrs[$i]."' where mini_order_ref=".$mini_order_ref." and mini_order_num=".$mini_order_num[$i]."";
					$result2=mysqli_query($link, $sql2) or exit("Sql Error-4".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
					$ii++;
					
				}
			}
			else	
			{
				$bundle_alloc[]=$mini_order_num[$i];
			}
			
		}
	}
	
	if(sizeof($bundle_alloc)>0)
	{
		echo "<h2>Bundle Allocation Pending-(".implode("," ,$bundle_alloc).").</h2>";
	}
	else
	{
		echo "<h3>Updated successfully.</h3>";
	}
	
}
if(isset($_POST['schedule_save']))
{
	$ii=1;
	$mini_order_ref=$_POST['mini_order_ref'];
	$mini=echo_title("$brandix_bts.tbl_miniorder_data","group_concat(distinct mini_order_num order by mini_order_num)","mini_order_ref",$mini_order_ref,$link);
	$mini_orders=explode(",",$mini);
	$chk_b=$_POST['chk_b'];
	$date=$_POST['plandate'];
	$hrs=$_POST['hrs'];
	$cnt=$_POST['count'];
	$bundle_alloc=array();
	$sch_id = echo_title("$brandix_bts.tbl_min_ord_ref","ref_crt_schedule","id",$mini_order_ref,$link);
	//for($j=0;$j<sizeof($mini_orders);$j++)
	//{
		$sql="SELECT mini_order_num,min(planned_module) AS module FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='".$mini_order_ref."' group by mini_order_num";
		//echo $sql."<br>";
		$result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row = mysqli_fetch_array($result))
		{
			$module=$row['module'];
			$mini_orders=$row['mini_order_num'];
			
			if($module>0 && $module<> '')
			{																																																				
				$doc_no = echo_title("$brandix_bts.tbl_miniorder_data","GROUP_CONCAT(DISTINCT docket_number)","mini_order_num=".$mini_orders." and mini_order_ref",$mini_order_ref,$link);
				//echo $doc_no."<br>";
				$section = echo_title("$bai_pro3.plan_modules","section_id","module_id",$module,$link);
				$sql1="insert into $bai_pro3.trims_dashboard(doc_ref,sch_id,mini_ord_ref,mini_ord_num,module,section,priority,plan_time,trims_req_date,log_user) values('".$doc_no."','".$sch_id."','".$mini_order_ref."','".$mini_orders."','".$module."','".$section."','".$ii."','".$date." $hrs:00:00','".$date." $hrs:00:00','".$username."')";
				//echo $sql1."<br>";
				$result1=mysqli_query($link, $sql1) or exit("Sql Error2-".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql2="update $brandix_bts.tbl_miniorder_data set plan_date='".$date."' where mini_order_ref=\"$mini_order_ref\" and mini_order_num=".$mini_orders."";
				$result2=mysqli_query($link, $sql2) or exit("Sql Error-".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
				$ii++;
			}
			else
			{
				$bundle_alloc[]=$mini_orders;
				$module=$_POST['module'];
				$doc_no = echo_title("$brandix_bts.tbl_miniorder_data","GROUP_CONCAT(DISTINCT docket_number)","mini_order_num=".$mini_orders." and mini_order_ref",$mini_order_ref,$link);
				//echo $doc_no."<br>";
				$section = echo_title("$bai_pro3.plan_modules","section_id","module_id",$module,$link);
				$sql1="insert into $bai_pro3.trims_dashboard(doc_ref,sch_id,mini_ord_ref,mini_ord_num,module,section,priority,plan_time,trims_req_time,log_user) values('".$doc_no."','".$sch_id."','".$mini_order_ref."','".$mini_orders."','".$module."','".$section."','".$ii."','".$date." $hrs:00:00','".$date." $hrs:00:00','".$username."')";
				//echo $sql1."<br>";
				$result1=mysqli_query($link, $sql1) or exit("Sql Error2-".$sql1.mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql2="update $brandix_bts.tbl_miniorder_data set plan_date='".$date."' where mini_order_ref=\"$mini_order_ref\" and mini_order_num=".$mini_orders."";
				$result2=mysqli_query($link, $sql2) or exit("Sql Error-".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
				$ii++;
			}
		}
		
	//}		
	
	if(sizeof($bundle_alloc)>0)
	{
		echo "<h2>Bundle Allocation Pending-(".implode("," ,$bundle_alloc).").</h2>";
		echo "<h3>Updated in to the system</h3>";
	}
	else
	{
		echo "<h3>Updated in to the system</h3>";
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