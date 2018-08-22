<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
$view_access=user_acl("SFCS_0240",$username,1,$group_id_sfcs);
?>

<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>

<?php 
// uncomment this in ui
// include("header_scripts.php"); 
// uncomment this in ui
?>

<script>

function firstbox()
{
	var ajax_url ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value;Ajaxify(ajax_url);

}

function secondbox()
{
	var ajax_url ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;Ajaxify(ajax_url);

}

function thirdbox()
{
	var ajax_url ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;Ajaxify(ajax_url);

}

function active_update()
{
	var x,y;
	x=document.getElementById('samp_chk').checked;
	//	y=document.getElementById('sp_samp_chk').checked;
	//if(x==true || y==true)
	if(x==true)
	{
		document.getElementById('update').disabled='';
	}
	else
	{
		document.getElementById('update').disabled=true;
	}
}
</script>

</head>

<body>

<?php 
// include($_SERVER['DOCUMENT_ROOT'].getFullURL($_GET['r'],'menu_content.php','R')); 
?>
<?php

$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];

//echo $style.$schedule.$color;
?>

<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
<?php

echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>";echo"Sample Room - Sample Schedules Confirmation Form";echo "</div>";
echo "<div class='panel-body'>";
echo "<div class='form-group'>";
echo "<div class='col-md-2 col-sm-3 col-xs-12'>";

echo "Select Style: <select name=\"style\" class=\" form-control\" onchange=\"firstbox();\" required>";

$sql="select distinct order_style_no from $bai_pro3.bai_orders_db";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(trim($sql_row['order_style_no'])==trim($style))
{
	echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
}

}

echo "</select>";
echo "</div>";
?>

<?php

echo "<div class='col-md-2 col-sm-3 col-xs-12'>";
echo "Select Schedule: <select name=\"schedule\" class=\"select2_single form-control\" onchange=\"secondbox();\"  required>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
//}
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
{
	echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
}

}


echo "</select>";
echo "</div>";
?>

<?php
echo "<div class='col-md-2 col-sm-3 col-xs-12'>";
echo "Select Color: <select name=\"color\" class=\"select2_single form-control\" onchange=\"thirdbox();\"  required>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
//}
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
}

}


echo "</select>";
echo "</div>";

$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"".$color."\"";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_tid=$sql_row['order_tid'];
}



$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\"";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$mo_status=$sql_row['mo_status'];
}



if($mo_status=="Y")
{
	echo "<div class='col-md-2 col-sm-3 col-xs-12'>";
	echo "<p style='margin-top: 14px;'>MO Status:"."<font color=GREEN size=5>".$mo_status."es</font></p>";
	echo "</div>";
	echo "<div class='col-md-2 col-sm-3 col-xs-12'>";
	echo "<input type=\"submit\" value=\"submit\" class=\"btn btn-success\" name=\"submit\" style=\"margin-top: 17px;\">";	
	echo "</div>";
}
else
{
	echo "<div class='col-md-2 col-sm-3 col-xs-12'>";
	echo "<p style='margin-top: 14px;'>MO Status:"."<font color=RED size=5>No</font></p>";
	echo "</div>";
	echo "<div class='col-md-2 col-sm-3 col-xs-12'>";
	echo "<input type=\"submit\" value=\"submit\" class=\"btn btn-success\" name=\"submit\" style=\"margin-top: 17px;\">";
	echo "</div>";
}


?>


</form>

<br/>
</body>
</html>
<?php
function get_sp_samle_order_db($fn_order_tid,$fn_size,$ims_remarks)
{
	$order_qty=0;
	$sp_sample_sql="select * from $bai_pro3.sp_sample_order_db where order_tid=\"".$fn_order_tid."\" and size=\"$fn_size\" and remarks='$ims_remarks'";

	$sql_result=mysqli_query($GLOBALS['link'], $sp_sample_sql) or exit("$sp_sample_sql Sql Error $sp_sample_sql".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$order_qty+=$sql_row['input_qty'];
	}
	return $order_qty;
}
foreach ($sizes_array as $key => $value) {
	$title_sizes[$value] = "title_size_".$value;
}
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];

	if($style != 'NIL' && $color != 'NIL' && $schedule != 'NIL') {
		unset($sizes);
		$sql="select * from $bai_pro3.bai_orders_db where order_style_no='$style' and order_del_no='$schedule' and order_col_des='$color'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			foreach ($title_sizes as $key1 => $value1) {
				$final_title_sizes[$key1] = $sql_row[$value1];
			}
			$filtered_title_sizes = array_filter($final_title_sizes);
			$order_tid=$sql_row['order_tid'];
			$style=$sql_row['order_style_no'];
			$schedule=$sql_row['order_del_no'];
			$color=$sql_row['order_col_des'];

			$flag = $sql_row['title_flag'];
			// Recent comment
			// if($flag==1)
			// {
			// 	$pre_count=6;
			// 	for($j=6;$j<=30;)
			// 	{
			// 		$pre_count++;
			// 		$size="size$j";
			// 		if($$size!='')
			// 		{
			// 			$title_sizes[$pre_count]=$$size;//Dynamic variable for minimise hard code(kirang)
			// 		}
			// 		$j=$j+2;
			// 	}
			// }
		}

		if($flag == 1)
		{
		//	$sizes=array("XS","s","M","L","XL","XXL","XXXL");
		//echo "<table border=1><tr><th>Sizes</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th><th>XXS</th><th>$size6</th><th>$size8</th><th>$size10</th><th>$size12</th><th>$size14</th><th>$size16</th><th>$size18</th><th>$size20</th><th>$size22</th><th>$size24</th><th>$size26</th><th>$size28</th><th>$size30</th></tr>";
		}
		else
		{
			// recent comment
			// unset($title_sizes);
			// $title_sizes=$act_sizes;
			// recent comment
		}
		// $sql="select remarks from $bai_pro3.bai_orders_db_remarks where order_tid=\"$order_tid\"";
		// //echo $sql;
		// $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_row=mysqli_fetch_array($sql_result))
		// {	
		// 	$remarks=$sql_row['remarks'];
		// }
		//echo "<p style='margin-top: 52px;'>Input for Order TID: <font color='green'>$order_tid </font></p>";
		echo "<table class=table table-bordered><tr><th>Style : $style</th><th>Schedule : $schedule </th><th>Color : $color</th></tr></table>";
		
		//To identify the layplan completed no.	
		$count=0;
		$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and remarks=\"Normal\"";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{	
			$count++;
		}

		if($count==0)
		{
			echo "<form name=\"test1\" method=\"post\" action=\"".getURL(getBASE($_GET['r'])['path'])['url']."\">";
			echo "<table class='table table-striped'><tr><th>Sizes</th><td></td><th>Sample</th></tr>";
			// echo sizeof($filtered_title_sizes);
			$i=0;
			foreach ($filtered_title_sizes as $sizekey => $sizevalue) {

				$exist_size=get_sp_samle_order_db($order_tid,$sizevalue,"SAMPLE");

				echo "<tr><td><input type=\"hidden\" name=\"sizes[$i]\" value=\"".$sizevalue."\" size=\"5\" class=\"form-control col-md-3 col-xs-12\">
				<input type=\"hidden\" name=\"sizes_ref[$i]\" value=\"".$sizekey."\" size=\"5\" class=\"form-control col-md-3 col-xs-12\">".$sizevalue."</td><td>:</td>
					<td><input type=\"text\"  name=\"samp_input[$i]\" value=\"$exist_size\" id= \"$i\" size=\"5\" class=\"form-control col-md-3 col-xs-12 integer\"></td>";
				echo "</tr>";
				
				$i++;
			}
			echo "<input type='hidden' name='order_tid' value='$order_tid'>";
			echo "<input type='hidden' name='count' id='count' value='$i'>";

		
			echo "<tr><td></td><td></td><td><INPUT TYPE = \"submit\" Name = \"Update\" id=\"update\" class=\"btn btn-success\" VALUE = \"Update\" onclick=\"return check_pack();\"></td></tr>";
			echo "</table></form>";
		}
		else
		{
			echo "<form name=\"test1\" method=\"post\" action=\"".getURL(getBASE($_GET['r'])['path'])['url']."\">";
			echo "<table class='table table-striped'><tr><th>Sizes</th><td></td><th>Sample</th></tr>";
			// echo sizeof($filtered_title_sizes);
			$i=0;
			foreach ($filtered_title_sizes as $sizekey => $sizevalue) {

				$exist_size=get_sp_samle_order_db($order_tid,$sizevalue,"SAMPLE");

				echo "<tr><td><input type=\"hidden\" name=\"sizes[$i]\"  value=\"".$sizevalue."\" size=\"5\" class=\"form-control col-md-3 col-xs-12\">".$sizevalue."</td><td>:</td>
					<td><input type=\"text\"  name=\"samp_input[$i]\" readonly=\"true\" value=\"$exist_size\" id= \"$i\" size=\"5\" class=\"form-control col-md-3 col-xs-12 integer\"></td>";
				echo "</tr>";
				
				$i++;
			}
			echo "<input type='hidden' name='order_tid' value='$order_tid'>";
			echo "<input type='hidden' name='count' id='count' value='$i'>";
			echo "</table></form>";

			echo "<br/><br/><font color='red'>Lay plan generation is done. So you can't edit samples details.</font>";
		}
	}else{
		echo "<script>sweetAlert('Please Select','Style,Schedule and Color','error')</script>";
	}

}

if(isset($_POST['Update']))
{
	$input_remarks=$_POST['remarks'];
	$input_doc_no=$_POST['doc_no'];
	$order_tid=$_POST['order_tid'];
	$cid=$_POST['cid'];
	$remarks=$_POST['remarks'];
	$samp_input=$_POST['samp_input'];
	$sp_samp_input=$_POST['sp_samp_input'];
	$sizes=$_POST['sizes'];
	$sizes_ref=$_POST['sizes_ref'];
	$sp_samp_chk=$_POST['sp_samp_chk'];
	$samp_chk=$_POST['samp_chk'];

	//To Clear Special Requested Input Boxes
	$sp_id=$_POST['sp_id'];
	$final_remark='';$flag=0;$db_sample_remark="Sample:";
	$order_tid_data =  "Order TID:$order_tid<br/>";
	// $link->autocommit(FALSE);
	$query_done = true;
	$sizes_data = "";

	for($i=0;$i<sizeof($samp_input);$i++)
	{
		//$flag=0;$flag1=0;
		$sizes_data .= $sizes[$i]." : ".$samp_input[$i].":".$sizes_ref[$i]."<br/>";		
		if($samp_input[$i]>0)
		{
			$sql="insert ignore into $bai_pro3.sp_sample_order_db(order_tid,size,remarks,sizes_ref) values('$order_tid','".$sizes[$i]."','SAMPLE','".$sizes_ref[$i]."')";
			// echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error $sql".mysqli_error($GLOBALS["___mysqli_ston"]));

			$sql1="update $bai_pro3.sp_sample_order_db set input_qty='$samp_input[$i]',user='$username',log_time='".date("Y-m-d H:i:s")."' where order_tid='$order_tid' and size='".$sizes[$i]."' and remarks='SAMPLE' and sizes_ref='".$sizes_ref[$i]."'";
			$sql_result=mysqli_query($link, $sql1) or exit("$sql1 Sql Error $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			//$flag=1;
			$final_remark=$order_db_remark="Sample:$samp_input[$i]";
			$db_sample_remark.="$sizes[$i]=$samp_input[$i];";
			// if(mysqli_affected_rows($link) == NULL) {	
			// 	$error_msg = "sp_sample_order_db table not updated";
			// 	$query_done = false;
			// 	break;
			// }
		}
	}
	echo "<script>sweetAlert('Successfully Updated','','success')</script>";
}
	// if($flag!=0)
	// {

	// 	$sql="insert ignore into $bai_pro3.bai_orders_db_remarks(order_tid) values(\"$order_tid\")";
	// 	$sql_result=mysqli_query($link, $sql) or exit("$sql Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 	$sql="update $bai_pro3.bai_orders_db_remarks set remarks='$db_sample_remark' where order_tid=\"$order_tid\"";
	// 	$sql_result=mysqli_query($link, $sql);
		// if(mysqli_affected_rows($link) == NULL) {
		// 	$error_msg = "bai_orders_db_remarks table not updated";
		// 	$query_done = false;
		// }
	//}
	// else {
	// 	$error_msg = "sp_sample_order_db table not updated";
	// 	$query_done = false;
	// }
	// if($query_done){
	// 	mysqli_commit($link);
	// 	echo $order_tid_data;
	// 	echo $sizes_data;
	
	// } else{
	// 	mysqli_rollback($link);
	// 	echo "Contact IT team with following Error! ".$error_msg;
	// }
		//	echo "<script type=\"text/javascript\"> window.close(); </script>";
		// NEW to Eliminate duplicates
//}
echo "</div>";
echo "</div>";
echo "</div>";
?> 

<script>
function check_pack()
{
	var count = document.getElementById('count').value;
	var tot_qty = 0;
	for(var i=0; i<count; i++)
	{
		var variable = i;
		var qty_cnt = document.getElementById(variable).value;
		tot_qty += Number(qty_cnt);
	}
	if(Number(tot_qty) <= 0)
	{
		sweetAlert("Please enter atleast one size sample","","warning");
		//swal('Please Enter Any size quantity','','warning');
		return false;
	}
}
</script>
