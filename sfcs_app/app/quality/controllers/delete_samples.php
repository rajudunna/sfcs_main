<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

?>

<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html>
<head>

<?php 
// uncomment this in ui
// include("header_scripts.php"); 
// uncomment this in ui




session_start();
	if($_GET['style'])
	{
		$style=$_GET['style'];
	}
	else
	{
		$style=	$_POST['style'];
	}
	if($_GET['color'])
	{
		$color=$_GET['color'];
	}
	else
	{
		$color=	$_POST['color'];
	}
	if($_GET['schedule'])
	{
		$schedule=$_GET['schedule'];
	}else
	{
		$schedule=	$_POST['schedule'];
	}
	
	$_SESSION['style']=$style;
	$_SESSION['schedule']=$schedule;
	$_SESSION['color']=$color;
?>
<script>

function firstbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value
}

function secondbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}

function thirdbox()
{
	window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}

</script>

</head>

<body>



<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">
<?php

echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>";echo"Delete Samples";echo "</div>";
echo "<div class='panel-body'>";
echo "<div class='form-group'>";
echo "<div class='col-md-2 col-sm-3 col-xs-12'>";

echo "Select Style: <select name=\"style\" class=\" form-control\" onchange=\"firstbox();\" required>";

$sql="SELECT DISTINCT (b.order_style_no) AS order_style_no,s.order_tid FROM $bai_pro3.sp_sample_order_db  s LEFT JOIN bai_orders_db b ON b.order_tid=s.order_tid group by order_style_no";	
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
	$sql="SELECT DISTINCT (b.order_del_no) AS order_del_no,s.order_tid FROM $bai_pro3.sp_sample_order_db  s LEFT JOIN bai_orders_db b ON b.order_tid=s.order_tid where b.order_style_no=\"$style\"";	
	
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
	$sql="SELECT DISTINCT (b.order_col_des) AS order_col_des,s.order_tid FROM $bai_pro3.sp_sample_order_db  s LEFT JOIN bai_orders_db b ON b.order_tid=s.order_tid where b.order_style_no=\"$style\" and b.order_del_no=\"$schedule\" ";
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
	echo "<div class='col-md-2 col-sm-3 col-xs-12'>";
	echo "<input type=\"submit\" value=\"submit\" class=\"btn btn-success\" name=\"submit\" style=\"margin-top: 17px;\">";
	echo "</div>";



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
		}

		echo "<table class=table table-bordered><tr><th>Style : $style</th><th>Schedule : $schedule </th><th>Color : $color</th></tr></table>";
		$sql1="select * from $bai_pro3.sp_sample_order_db where order_tid=\"".$order_tid."\"";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount=mysqli_num_rows($sql_result1);
		if($rowcount>0){
		$count=0;
		$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid."\"";
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
				<td>$exist_size</td>";
				echo "</tr>";
				
				$i++;
			}
			echo "<input type='hidden' name='order_tid' value='$order_tid'>";
			echo "<input type='hidden' name='count' id='count' value='$i'>";

		
			echo "<tr><td></td><td></td><td><INPUT TYPE = \"submit\" Name = \"Delete\" id=\"delete\" class=\"btn btn-danger\" VALUE = \"Delete\" onclick=\"return check_pack();\"></td></tr>";
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
					<td>$exist_size</td>";
				echo "</tr>";
				
				$i++;
			}
			echo "<input type='hidden' name='order_tid' value='$order_tid'>";
			echo "<input type='hidden' name='count' id='count' value='$i'>";
			echo "</table></form>";

			echo "<br/><br/><font color='red'>Lay plan generation is done. So you can't delete samples.</font>";
		 }
		}
		else{
			echo "<div class='alert alert-danger'>No Data Found</div>";
		}
	}else{
		echo "<script>sweetAlert('Please Select','Style,Schedule and Color','error')</script>";
	}

}
if(isset($_POST['Delete']))
{
	$order_tid=$_POST['order_tid'];
    $delete_query="delete from bai_pro3.sp_sample_order_db where order_tid=\"".$order_tid."\"";
    $sql_result=mysqli_query($link, $delete_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<script>sweetAlert('Samples Deleted Successfully','','success')</script>";
}
echo "</div>";
echo "</div>";
echo "</div>";
?> 


