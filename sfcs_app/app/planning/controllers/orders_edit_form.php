<!--
Ticket# 575423: 2014-02-08/Kirang: Added Color Filter Clause for multi color order qty amendments.

-->
<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$order_quantity_mail=$conf1->get('order_quantity_mail');
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/group_def.php");
// $view_access=user_acl("SFCS_0135",$username,1,$group_id_sfcs);

?>
<?php
//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=strtolower($username_list[1]);

//$authorized=array("muralim","kirang","kirang","srinub","kirang","lokeshk","prabathsa","kirang");
/*$sql="select * from menu_index where list_id=135";
$result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error());
while($row=mysql_fetch_array($result))
{
	$users=$row["auth_members"];
}

$authorized=explode(",",$users);
if(in_array($username,$authorized))
{
	
}
else
{
	header("Location:restrict.php");	
}
*/

?>
<script>

function firstbox()
{
	var ajax_url ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value;
	Ajaxify(ajax_url);

}

function secondbox()
{
		var ajax_url ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value;Ajaxify(ajax_url);

	
}

function thirdbox()
{
	var ajax_url ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;Ajaxify(ajax_url);
	
}
	function check_style()
	{

		var style=document.getElementById('style').value;
		if(style=='')
		{
			sweetAlert('Please Select Style First','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
	function check_style_sch()
	{
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
	
		if(style=='')
		{
			sweetAlert('Please Select Style First','','warning');
			return false;
		}
		else if(sch=='')
		{
			sweetAlert('Please Select schedule','','warning');
			return false;
		
		}
		else
		{
			return true;
		}
	}
	function check_style_sch_col()
	{
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
		var col=document.getElementById('color').value;

	
		if(style=='' && sch=='' && col=='')
		{
			sweetAlert('Please Select Style Schedule and Color','','warning');
			return false;
		}
		else if(sch=='' && col=='')
		{

			sweetAlert('Please Select schedule and Color','','warning');
			return false;
		
		}
		else if(col=='')
		{
			sweetAlert('Please Select Color','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}

</script>
<!-- <link href="style_new.css" rel="stylesheet" type="text/css" /> -->
<?php 
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<div class="panel panel-primary">
<div class="panel-heading">Order Qty Update (Color Wise)</div>
<div class"panel-body">
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];

?>

<form name="test" action="index.php?r=<?php echo $_GET['r']; ?>" method="post">
<div class="form-group">
<?php
// include("dbconf.php");
echo "<div class=\"col-sm-12\"><div class=\"row\"><div class=\"col-sm-3\">
	  <label for='style'>Select Style:</label> 
	  <select class =\"form-control\" name=\"style\" id=\"style\"  onchange=\"firstbox();\" >";

$sql="select distinct order_style_no from $bai_pro3.bai_orders_db";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
{
	echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
}

}

echo "</select>";
echo "</div>"
?>

<?php

echo "<div class=\"col-sm-3\">
      <label for='schedule'>Select Schedule:</label> 
      <select class=\"form-control\" name=\"schedule\" id=\"schedule\"onclick=\"return check_style();\"  onchange=\"secondbox();\" >";
$sql_result='';
if($style){
$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
}
echo "<option value='' selected>NIL</option>";
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

echo "<div class='col-sm-3'>
	  <label for='color'>Select Color:</label> 
	  <select class = \"form-control\" name=\"color\" id=\"color\" onclick=\"return check_style_sch();\"   onchange=\"thirdbox();\" >";
$sql_result='';
if($schedule){
$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
}
echo "<option value='' selected>NIL</option>";
	
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


$sql="select order_tid from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_tid=$sql_row['order_tid'];
}


	echo "<div class=\"col-sm-1\">
			<label for='submit'><br/></label>
			<button type=\"submit\" onclick=\"return check_style_sch_col();\"  class=\" form-control btn btn-success\" name=\"submit\">Show</button></div>";	

echo "</div></div>";

?>

</div>
</form>
<br><br>
<form action="index.php?r=<?php echo $_GET['r']?>" method="post" name="f3">
<?php
error_reporting(0);
if(isset($_POST['submit']))
{
	$row_count = 0;
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];

	
	if($style == '' || $style == 'NIL' || $color =='' || $color == 'NIL' || $schedule =='' || $schedule == 'NIL' ){
		echo "<script>sweetAlert('Please Select Style, Schedule & Color','','info');</script>";
		
	}else{
	
	$qry = "select count(order_del_no) from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	$sql=mysqli_query($link,$qry);

	while($row=mysqli_fetch_array($sql))
	{
		$count=$row["count(order_del_no)"];
	}
	$qry1 = "select count(order_del_no) from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	$sql1=mysqli_query($link,$qry1);
	//echo $sql1;
	//echo "<tr><th>select count(order_del_no) from $table1 where order_del_no=\"$schedule\"</th></tr></table>";
	while($row1=mysqli_fetch_array($sql1))
	{
		$count1=$row1["count(order_del_no)"];
	}
	//echo $count1;
	if($count1 > 0)
	{
		echo "<div class=\"col-sm-12\"><h4 align=left style='color:red;'>
			  <span class=\"label label-warning\">Order Quantity already Updated</span></h4></div>";
		
		// echo "<table class=\"table table-striped jambo_table bulk_action\">";
		// echo "<thread><tr><th>Style</th><td>$style</td></tr></thread>";
		// echo "<thread><tr><th>Schedule</th><td>$schedule</td></tr></thread>";
		// echo "<thread><tr><th>Color</th><td>$color</td></tr></thread>";
		// echo "</table><br><br><br><br>";
		// echo "<table>";

		echo "<div class=\"row\">";
		echo "<div class=\"col-sm-4\">";
		echo "<div class=\"col-sm-12\">";
		echo "<div class=\"table-responsive\">";
		//echo "<table class=\"table table-striped jambo_table bulk_action\">";
		echo "<table class='table table-bordered'>";
		echo "<tr>";
		echo "<th class=''>Style</th>";
		echo "<td class=\"  \">$style</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th class=''>Schedule</th>";
		echo "<td class=\"  \">$schedule</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th class=''>Color</th>";
		echo "<td class=\"  \">$color</td>";
		echo "</tr>";
		echo "</table>";
		echo "</div></div></div></div>";

		echo "<div class=\"col-sm-12\">";
		echo "<div class=\"table-responsive\">";
		//echo "<table class=\"table table-striped table-bordered jambo_table bulk_action\">";
		echo "<table class=\"table table-striped table-bordered\">";
		echo "<thead><tr class='info'>
						<th><center>Size</center></th>
						<th><center>New Order Quantity</center></th>
						<th><center>Old Order Quantity</center></th>
						<th><center>Order Qty Difference</center></th>
					 </tr>
			  </thead>";
		$qry3= "select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		$sql2=mysqli_query($link,$qry3);


		while($row2=mysqli_fetch_array($sql2))
		{			
				$s01_old=$row2['old_order_s_s01'];
				$s02_old=$row2['old_order_s_s02'];
				$s03_old=$row2['old_order_s_s03'];
				$s04_old=$row2['old_order_s_s04'];
				$s05_old=$row2['old_order_s_s05'];
				$s06_old=$row2['old_order_s_s06'];
				$s07_old=$row2['old_order_s_s07'];
				$s08_old=$row2['old_order_s_s08'];
				$s09_old=$row2['old_order_s_s09'];
				$s10_old=$row2['old_order_s_s10'];
				$s11_old=$row2['old_order_s_s11'];
				$s12_old=$row2['old_order_s_s12'];
				$s13_old=$row2['old_order_s_s13'];
				$s14_old=$row2['old_order_s_s14'];
				$s15_old=$row2['old_order_s_s15'];
				$s16_old=$row2['old_order_s_s16'];
				$s17_old=$row2['old_order_s_s17'];
				$s18_old=$row2['old_order_s_s18'];
				$s19_old=$row2['old_order_s_s19'];
				$s20_old=$row2['old_order_s_s20'];
				$s21_old=$row2['old_order_s_s21'];
				$s22_old=$row2['old_order_s_s22'];
				$s23_old=$row2['old_order_s_s23'];
				$s24_old=$row2['old_order_s_s24'];
				$s25_old=$row2['old_order_s_s25'];
				$s26_old=$row2['old_order_s_s26'];
				$s27_old=$row2['old_order_s_s27'];
				$s28_old=$row2['old_order_s_s28'];
				$s29_old=$row2['old_order_s_s29'];
				$s30_old=$row2['old_order_s_s30'];
				$s31_old=$row2['old_order_s_s31'];
				$s32_old=$row2['old_order_s_s32'];
				$s33_old=$row2['old_order_s_s33'];
				$s34_old=$row2['old_order_s_s34'];
				$s35_old=$row2['old_order_s_s35'];
				$s36_old=$row2['old_order_s_s36'];
				$s37_old=$row2['old_order_s_s37'];
				$s38_old=$row2['old_order_s_s38'];
				$s39_old=$row2['old_order_s_s39'];
				$s40_old=$row2['old_order_s_s40'];
				$s41_old=$row2['old_order_s_s41'];
				$s42_old=$row2['old_order_s_s42'];
				$s43_old=$row2['old_order_s_s43'];
				$s44_old=$row2['old_order_s_s44'];
				$s45_old=$row2['old_order_s_s45'];
				$s46_old=$row2['old_order_s_s46'];
				$s47_old=$row2['old_order_s_s47'];
				$s48_old=$row2['old_order_s_s48'];
				$s49_old=$row2['old_order_s_s49'];
				$s50_old=$row2['old_order_s_s50'];

							
				$s01=$row2['order_s_s01'];
				$s02=$row2['order_s_s02'];
				$s03=$row2['order_s_s03'];
				$s04=$row2['order_s_s04'];
				$s05=$row2['order_s_s05'];
				$s06=$row2['order_s_s06'];
				$s07=$row2['order_s_s07'];
				$s08=$row2['order_s_s08'];
				$s09=$row2['order_s_s09'];
				$s10=$row2['order_s_s10'];
				$s11=$row2['order_s_s11'];
				$s12=$row2['order_s_s12'];
				$s13=$row2['order_s_s13'];
				$s14=$row2['order_s_s14'];
				$s15=$row2['order_s_s15'];
				$s16=$row2['order_s_s16'];
				$s17=$row2['order_s_s17'];
				$s18=$row2['order_s_s18'];
				$s19=$row2['order_s_s19'];
				$s20=$row2['order_s_s20'];
				$s21=$row2['order_s_s21'];
				$s22=$row2['order_s_s22'];
				$s23=$row2['order_s_s23'];
				$s24=$row2['order_s_s24'];
				$s25=$row2['order_s_s25'];
				$s26=$row2['order_s_s26'];
				$s27=$row2['order_s_s27'];
				$s28=$row2['order_s_s28'];
				$s29=$row2['order_s_s29'];
				$s30=$row2['order_s_s30'];
				$s31=$row2['order_s_s31'];
				$s32=$row2['order_s_s32'];
				$s33=$row2['order_s_s33'];
				$s34=$row2['order_s_s34'];
				$s35=$row2['order_s_s35'];
				$s36=$row2['order_s_s36'];
				$s37=$row2['order_s_s37'];
				$s38=$row2['order_s_s38'];
				$s39=$row2['order_s_s39'];
				$s40=$row2['order_s_s40'];
				$s41=$row2['order_s_s41'];
				$s42=$row2['order_s_s42'];
				$s43=$row2['order_s_s43'];
				$s44=$row2['order_s_s44'];
				$s45=$row2['order_s_s45'];
				$s46=$row2['order_s_s46'];
				$s47=$row2['order_s_s47'];
				$s48=$row2['order_s_s48'];
				$s49=$row2['order_s_s49'];
				$s50=$row2['order_s_s50'];

				$size01 = $row2['title_size_s01'];
				$size02 = $row2['title_size_s02'];
				$size03 = $row2['title_size_s03'];
				$size04 = $row2['title_size_s04'];
				$size05 = $row2['title_size_s05'];
				$size06 = $row2['title_size_s06'];
				$size07 = $row2['title_size_s07'];
				$size08 = $row2['title_size_s08'];
				$size09 = $row2['title_size_s09'];
				$size10 = $row2['title_size_s10'];
				$size11 = $row2['title_size_s11'];
				$size12 = $row2['title_size_s12'];
				$size13 = $row2['title_size_s13'];
				$size14 = $row2['title_size_s14'];
				$size15 = $row2['title_size_s15'];
				$size16 = $row2['title_size_s16'];
				$size17 = $row2['title_size_s17'];
				$size18 = $row2['title_size_s18'];
				$size19 = $row2['title_size_s19'];
				$size20 = $row2['title_size_s20'];
				$size21 = $row2['title_size_s21'];
				$size22 = $row2['title_size_s22'];
				$size23 = $row2['title_size_s23'];
				$size24 = $row2['title_size_s24'];
				$size25 = $row2['title_size_s25'];
				$size26 = $row2['title_size_s26'];
				$size27 = $row2['title_size_s27'];
				$size28 = $row2['title_size_s28'];
				$size29 = $row2['title_size_s29'];
				$size30 = $row2['title_size_s30'];
				$size31 = $row2['title_size_s31'];
				$size32 = $row2['title_size_s32'];
				$size33 = $row2['title_size_s33'];
				$size34 = $row2['title_size_s34'];
				$size35 = $row2['title_size_s35'];
				$size36 = $row2['title_size_s36'];
				$size37 = $row2['title_size_s37'];
				$size38 = $row2['title_size_s38'];
				$size39 = $row2['title_size_s39'];
				$size40 = $row2['title_size_s40'];
				$size41 = $row2['title_size_s41'];
				$size42 = $row2['title_size_s42'];
				$size43 = $row2['title_size_s43'];
				$size44 = $row2['title_size_s44'];
				$size45 = $row2['title_size_s45'];
				$size46 = $row2['title_size_s46'];
				$size47 = $row2['title_size_s47'];
				$size48 = $row2['title_size_s48'];
				$size49 = $row2['title_size_s49'];
				$size50 = $row2['title_size_s50'];

				$flag = $row2['title_flag'];
				if($flag == 0)
				{
					$size01 = 1; $size01 = sprintf("%02d", $size01);
					$size02 = 2; $size02 = sprintf("%02d", $size02);
					$size03 = 3; $size03 = sprintf("%02d", $size03);
					$size04 = 4; $size04 = sprintf("%02d", $size04);
					$size05 = 5; $size05 = sprintf("%02d", $size05);
					$size06 = 6; $size06 = sprintf("%02d", $size06);
					$size07 = 7; $size07 = sprintf("%02d", $size07);
					$size08 = 8; $size08 = sprintf("%02d", $size08);
					$size09 = 9; $size09 = sprintf("%02d", $size09);
					$size10 = 10;
					$size11 = 11;
					$size12 = 12;
					$size13 = 13;
					$size14 = 14;
					$size15 = 15;
					$size16 = 16;
					$size17 = 17;
					$size18 = 18;
					$size19 = 19;
					$size20 = 20;
					$size21 = 21;
					$size22 = 22;
					$size23 = 23;
					$size24 = 24;
					$size25 = 25;
					$size26 = 26;
					$size27 = 27;
					$size28 = 28;
					$size29 = 29;
					$size30 = 30;
					$size31 = 31;
					$size32 = 32;
					$size33 = 33;
					$size34 = 34;
					$size35 = 35;
					$size36 = 36;
					$size37 = 37;
					$size38 = 38;
					$size39 = 39;
					$size40 = 40;
					$size41 = 41;
					$size42 = 42;
					$size43 = 43;
					$size44 = 44;
					$size45 = 45;
					$size46 = 46;
					$size47 = 47;
					$size48 = 48;
					$size49 = 49;
					$size50 = 50;
				}
		}
		
		$xs_dif=$xs-$xs_old;
		$s_dif=$s-$s_old;
		$m_dif=$m-$m_old;
		$l_dif=$l-$l_old;
		$xl_dif=$xl-$xl_old;
		$xxl_dif=$xxl-$xxl_old;
		$xxxl_dif=$xxxl-$xxxl_old;
		
		$s01_dif=$s01-$s01_old;
		$s02_dif=$s02-$s02_old;
		$s03_dif=$s03-$s03_old;
		$s04_dif=$s04-$s04_old;
		$s05_dif=$s05-$s05_old;
		$s06_dif=$s06-$s06_old;
		$s07_dif=$s07-$s07_old;
		$s08_dif=$s08-$s08_old;
		$s09_dif=$s09-$s09_old;
		$s10_dif=$s10-$s10_old;
		$s11_dif=$s11-$s11_old;
		$s12_dif=$s12-$s12_old;
		$s13_dif=$s13-$s13_old;
		$s14_dif=$s14-$s14_old;
		$s15_dif=$s15-$s15_old;
		$s16_dif=$s16-$s16_old;
		$s17_dif=$s17-$s17_old;
		$s18_dif=$s18-$s18_old;
		$s19_dif=$s19-$s19_old;
		$s20_dif=$s20-$s20_old;
		$s21_dif=$s21-$s21_old;
		$s22_dif=$s22-$s22_old;
		$s23_dif=$s23-$s23_old;
		$s24_dif=$s24-$s24_old;
		$s25_dif=$s25-$s25_old;
		$s26_dif=$s26-$s26_old;
		$s27_dif=$s27-$s27_old;
		$s28_dif=$s28-$s28_old;
		$s29_dif=$s29-$s29_old;
		$s30_dif=$s30-$s30_old;
		$s31_dif=$s31-$s31_old;
		$s32_dif=$s32-$s32_old;
		$s33_dif=$s33-$s33_old;
		$s34_dif=$s34-$s34_old;
		$s35_dif=$s35-$s35_old;
		$s36_dif=$s36-$s36_old;
		$s37_dif=$s37-$s37_old;
		$s38_dif=$s38-$s38_old;
		$s39_dif=$s39-$s39_old;
		$s40_dif=$s40-$s40_old;
		$s41_dif=$s41-$s41_old;
		$s42_dif=$s42-$s42_old;
		$s43_dif=$s43-$s43_old;
		$s44_dif=$s44-$s44_old;
		$s45_dif=$s45-$s45_old;
		$s46_dif=$s46-$s46_old;
		$s47_dif=$s47-$s47_old;
		$s48_dif=$s48-$s48_old;
		$s49_dif=$s49-$s49_old;
		$s50_dif=$s50-$s50_old;	
		
		echo "<tbody>";

		for($i = 1; $i<=50; $i++ )
		{
			$x=$i;
			$i = sprintf("%02d",$x);
			
			if(${size.$i} != null and ${s.$i} != null and ${s.$i._old} != null)
			{
				echo "<tr><td><center>".${"size".$i}."</center></td><td><center>".${"s".$i}."</center></td><td><center>".${"s".$i._old}."</center></td><td><center>".${"s".$i._dif}."</center></td></tr>";
			}
		}

		// echo "<tbody><tr><td>$size01</td><td>$s01</td><td>$s01_old</td><td>$s01_dif</td></tr><tr><td>$size02</td><td>$s02</td><td>$s02_old</td><td>$s02_dif</td></tr><tr><td>$size03</td><td>$s03</td><td>$s03_old</td><td>$s03_dif</td></tr><tr><td>$size04</td><td>$s04</td><td>$s04_old</td><td>$s04_dif</td></tr><tr><td>$size05</td><td>$s05</td><td>$s05_old</td><td>$s05_dif</td></tr><tr><td>$size06</td><td>$s06</td><td>$s06_old</td><td>$s06_dif</td></tr><tr><td>$size07</td><td>$s07</td><td>$s07_old</td><td>$s07_dif</td></tr><tr><td>$size08</td><td>$s08</td><td>$s08_old</td><td>$s08_dif</td></tr><tr><td>$size09</td><td>$s09</td><td>$s09_old</td><td>$s09_dif</td></tr><tr><td>$size10</td><td>$s10</td><td>$s10_old</td><td>$s10_dif</td></tr><tr><td>$size11</td><td>$s11</td><td>$s11_old</td><td>$s11_dif</td></tr><tr><td>$size12</td><td>$s12</td><td>$s12_old</td><td>$s12_dif</td></tr><tr><td>$size13</td><td>$s13</td><td>$s13_old</td><td>$s13_dif</td></tr><tr><td>$size14</td><td>$s14</td><td>$s14_old</td><td>$s14_dif</td></tr><tr><td>$size15</td><td>$s15</td><td>$s15_old</td><td>$s15_dif</td></tr><tr><td>$size16</td><td>$s16</td><td>$s16_old</td><td>$s16_dif</td></tr><tr><td>$size17</td><td>$s17</td><td>$s17_old</td><td>$s17_dif</td></tr><tr><td>$size18</td><td>$s18</td><td>$s18_old</td><td>$s18_dif</td></tr><tr><td>$size19</td><td>$s19</td><td>$s19_old</td><td>$s19_dif</td></tr><tr><td>$size20</td><td>$s20</td><td>$s20_old</td><td>$s20_dif</td></tr><tr><td>$size21</td><td>$s21</td><td>$s21_old</td><td>$s21_dif</td></tr><tr><td>$size22</td><td>$s22</td><td>$s22_old</td><td>$s22_dif</td></tr><tr><td>$size23</td><td>$s23</td><td>$s23_old</td><td>$s23_dif</td></tr><tr><td>$size24</td><td>$s24</td><td>$s24_old</td><td>$s24_dif</td></tr><tr><td>$size25</td><td>$s25</td><td>$s25_old</td><td>$s25_dif</td></tr><tr><td>$size26</td><td>$s26</td><td>$s26_old</td><td>$s26_dif</td></tr><tr><td>$size27</td><td>$s27</td><td>$s27_old</td><td>$s27_dif</td></tr><tr><td>$size28</td><td>$s28</td><td>$s28_old</td><td>$s28_dif</td></tr><tr><td>$size29</td><td>$s29</td><td>$s29_old</td><td>$s29_dif</td></tr><tr><td>$size30</td><td>$s30</td><td>$s30_old</td><td>$s30_dif</td></tr><tr><td>$size31</td><td>$s31</td><td>$s31_old</td><td>$s31_dif</td></tr><tr><td>$size32</td><td>$s32</td><td>$s32_old</td><td>$s32_dif</td></tr><tr><td>$size33</td><td>$s33</td><td>$s33_old</td><td>$s33_dif</td></tr><tr><td>$size34</td><td>$s34</td><td>$s34_old</td><td>$s34_dif</td></tr><tr><td>$size35</td><td>$s35</td><td>$s35_old</td><td>$s35_dif</td></tr><tr><td>$size36</td><td>$s36</td><td>$s36_old</td><td>$s36_dif</td></tr><tr><td>$size37</td><td>$s37</td><td>$s37_old</td><td>$s37_dif</td></tr><tr><td>$size38</td><td>$s38</td><td>$s38_old</td><td>$s38_dif</td></tr><tr><td>$size39</td><td>$s39</td><td>$s39_old</td><td>$s39_dif</td></tr><tr><td>$size40</td><td>$s40</td><td>$s40_old</td><td>$s40_dif</td></tr><tr><td>$size41</td><td>$s41</td><td>$s41_old</td><td>$s41_dif</td></tr><tr><td>$size42</td><td>$s42</td><td>$s42_old</td><td>$s42_dif</td></tr><tr><td>$size43</td><td>$s43</td><td>$s43_old</td><td>$s43_dif</td></tr><tr><td>$size44</td><td>$s44</td><td>$s44_old</td><td>$s44_dif</td></tr><tr><td>$size45</td><td>$s45</td><td>$s45_old</td><td>$s45_dif</td></tr><tr><td>$size46</td><td>$s46</td><td>$s46_old</td><td>$s46_dif</td></tr><tr><td>$size47</td><td>$s47</td><td>$s47_old</td><td>$s47_dif</td></tr><tr><td>$size48</td><td>$s48</td><td>$s48_old</td><td>$s48_dif</td></tr><tr><td>$size49</td><td>$s49</td><td>$s49_old</td><td>$s49_dif</td></tr><tr><td>$size50</td><td>$s50</td><td>$s50_old</td><td>$s50_dif</td></tr></tbody>";
		
		echo "</tbody></table></div></div><br>";
		
	}
	else
	{
		// echo "<table class='tblheading'>";
		// echo "<tr><th>Style</th><td>$style</td></tr>";
		// echo "<tr><th>Schedule</th><td>$schedule</td></tr>";
		// echo "<tr><th>Color</th><td>$color</td></tr>";
		// echo "</table><br><br><br><br><br><br><br><br>";
		// echo "<table>";
		echo "<div class=\"row\">";
		echo "<div class=\"col-sm-4\">";
		echo "<div class=\"col-sm-12\">";
		echo "<table class=\"table table-striped jambo_table bulk_action\">";		

		echo "<tr>";
		echo "<th class=\"column-title\">Style</th>";
		echo "<td class=\"  \">$style</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<th class=\"column-title\">Schedule</th>";
		echo "<td class=\"  \">$schedule</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<th class=\"column-title\">Color</th>";
		echo "<td class=\"  \">$color</td>";
		echo "</tr>";
		
		echo "<tr>
		<th class=\"column-title\">Excess %</th>
		<td class=\"  \"><input type=\"textbox\" style='border=\"0px\"' class=\"form-control input-sm float\" id=\"ext\"  name=\"ext\" value=\"0\" size=\"4\" onKeyUp=\"
		document.f3.s01.value=Math.round(parseInt(document.f3.s011.value)+parseFloat(document.f3.s011.value*document.f3.ext.value/100));
		document.f3.s02.value=Math.round(parseInt(document.f3.s021.value)+parseFloat(document.f3.s021.value*document.f3.ext.value/100));
		document.f3.s03.value=Math.round(parseInt(document.f3.s031.value)+parseFloat(document.f3.s031.value*document.f3.ext.value/100));
		document.f3.s04.value=Math.round(parseInt(document.f3.s041.value)+parseFloat(document.f3.s041.value*document.f3.ext.value/100));
		document.f3.s05.value=Math.round(parseInt(document.f3.s051.value)+parseFloat(document.f3.s051.value*document.f3.ext.value/100));
		document.f3.s06.value=Math.round(parseInt(document.f3.s061.value)+parseFloat(document.f3.s061.value*document.f3.ext.value/100));
		document.f3.s07.value=Math.round(parseInt(document.f3.s071.value)+parseFloat(document.f3.s071.value*document.f3.ext.value/100));
		document.f3.s08.value=Math.round(parseInt(document.f3.s081.value)+parseFloat(document.f3.s081.value*document.f3.ext.value/100));
		document.f3.s09.value=Math.round(parseInt(document.f3.s091.value)+parseFloat(document.f3.s091.value*document.f3.ext.value/100));
		document.f3.s10.value=Math.round(parseInt(document.f3.s101.value)+parseFloat(document.f3.s101.value*document.f3.ext.value/100));
		document.f3.s11.value=Math.round(parseInt(document.f3.s111.value)+parseFloat(document.f3.s111.value*document.f3.ext.value/100));
		document.f3.s12.value=Math.round(parseInt(document.f3.s121.value)+parseFloat(document.f3.s121.value*document.f3.ext.value/100));
		document.f3.s13.value=Math.round(parseInt(document.f3.s131.value)+parseFloat(document.f3.s131.value*document.f3.ext.value/100));
		document.f3.s14.value=Math.round(parseInt(document.f3.s141.value)+parseFloat(document.f3.s141.value*document.f3.ext.value/100));
		document.f3.s15.value=Math.round(parseInt(document.f3.s151.value)+parseFloat(document.f3.s151.value*document.f3.ext.value/100));
		document.f3.s16.value=Math.round(parseInt(document.f3.s161.value)+parseFloat(document.f3.s161.value*document.f3.ext.value/100));
		document.f3.s17.value=Math.round(parseInt(document.f3.s171.value)+parseFloat(document.f3.s171.value*document.f3.ext.value/100));
		document.f3.s18.value=Math.round(parseInt(document.f3.s181.value)+parseFloat(document.f3.s181.value*document.f3.ext.value/100));
		document.f3.s19.value=Math.round(parseInt(document.f3.s191.value)+parseFloat(document.f3.s191.value*document.f3.ext.value/100));
		document.f3.s20.value=Math.round(parseInt(document.f3.s201.value)+parseFloat(document.f3.s201.value*document.f3.ext.value/100));
		document.f3.s21.value=Math.round(parseInt(document.f3.s211.value)+parseFloat(document.f3.s211.value*document.f3.ext.value/100));
		document.f3.s22.value=Math.round(parseInt(document.f3.s221.value)+parseFloat(document.f3.s221.value*document.f3.ext.value/100));
		document.f3.s23.value=Math.round(parseInt(document.f3.s231.value)+parseFloat(document.f3.s231.value*document.f3.ext.value/100));
		document.f3.s24.value=Math.round(parseInt(document.f3.s241.value)+parseFloat(document.f3.s241.value*document.f3.ext.value/100));
		document.f3.s25.value=Math.round(parseInt(document.f3.s251.value)+parseFloat(document.f3.s251.value*document.f3.ext.value/100));
		document.f3.s26.value=Math.round(parseInt(document.f3.s261.value)+parseFloat(document.f3.s261.value*document.f3.ext.value/100));
		document.f3.s27.value=Math.round(parseInt(document.f3.s271.value)+parseFloat(document.f3.s271.value*document.f3.ext.value/100));
		document.f3.s28.value=Math.round(parseInt(document.f3.s281.value)+parseFloat(document.f3.s281.value*document.f3.ext.value/100));
		document.f3.s29.value=Math.round(parseInt(document.f3.s291.value)+parseFloat(document.f3.s291.value*document.f3.ext.value/100));
		document.f3.s30.value=Math.round(parseInt(document.f3.s301.value)+parseFloat(document.f3.s301.value*document.f3.ext.value/100));
		document.f3.s31.value=Math.round(parseInt(document.f3.s311.value)+parseFloat(document.f3.s311.value*document.f3.ext.value/100));
		document.f3.s32.value=Math.round(parseInt(document.f3.s321.value)+parseFloat(document.f3.s321.value*document.f3.ext.value/100));
		document.f3.s33.value=Math.round(parseInt(document.f3.s331.value)+parseFloat(document.f3.s331.value*document.f3.ext.value/100));
		document.f3.s34.value=Math.round(parseInt(document.f3.s341.value)+parseFloat(document.f3.s341.value*document.f3.ext.value/100));
		document.f3.s35.value=Math.round(parseInt(document.f3.s351.value)+parseFloat(document.f3.s351.value*document.f3.ext.value/100));
		document.f3.s36.value=Math.round(parseInt(document.f3.s361.value)+parseFloat(document.f3.s361.value*document.f3.ext.value/100));
		document.f3.s37.value=Math.round(parseInt(document.f3.s371.value)+parseFloat(document.f3.s371.value*document.f3.ext.value/100));
		document.f3.s38.value=Math.round(parseInt(document.f3.s381.value)+parseFloat(document.f3.s381.value*document.f3.ext.value/100));
		document.f3.s39.value=Math.round(parseInt(document.f3.s391.value)+parseFloat(document.f3.s391.value*document.f3.ext.value/100));
		document.f3.s40.value=Math.round(parseInt(document.f3.s401.value)+parseFloat(document.f3.s401.value*document.f3.ext.value/100));
		document.f3.s41.value=Math.round(parseInt(document.f3.s411.value)+parseFloat(document.f3.s411.value*document.f3.ext.value/100));
		document.f3.s42.value=Math.round(parseInt(document.f3.s421.value)+parseFloat(document.f3.s421.value*document.f3.ext.value/100));
		document.f3.s43.value=Math.round(parseInt(document.f3.s431.value)+parseFloat(document.f3.s431.value*document.f3.ext.value/100));
		document.f3.s44.value=Math.round(parseInt(document.f3.s441.value)+parseFloat(document.f3.s441.value*document.f3.ext.value/100));
		document.f3.s45.value=Math.round(parseInt(document.f3.s451.value)+parseFloat(document.f3.s451.value*document.f3.ext.value/100));
		document.f3.s46.value=Math.round(parseInt(document.f3.s461.value)+parseFloat(document.f3.s461.value*document.f3.ext.value/100));
		document.f3.s47.value=Math.round(parseInt(document.f3.s471.value)+parseFloat(document.f3.s471.value*document.f3.ext.value/100));
		document.f3.s48.value=Math.round(parseInt(document.f3.s481.value)+parseFloat(document.f3.s481.value*document.f3.ext.value/100));
		document.f3.s49.value=Math.round(parseInt(document.f3.s491.value)+parseFloat(document.f3.s491.value*document.f3.ext.value/100));
		document.f3.s50.value=Math.round(parseInt(document.f3.s501.value)+parseFloat(document.f3.s501.value*document.f3.ext.value/100));
		\"
		onKeyDown =\"document.f3.s01ext.value=0;
		document.f3.s02ext.value=0;
		document.f3.s03ext.value=0;
		document.f3.s04ext.value=0;
		document.f3.s05ext.value=0;
		document.f3.s06ext.value=0;
		document.f3.s07ext.value=0;
		document.f3.s08ext.value=0;
		document.f3.s09ext.value=0;
		document.f3.s10ext.value=0;
		document.f3.s11ext.value=0;
		document.f3.s12ext.value=0;
		document.f3.s13ext.value=0;
		document.f3.s14ext.value=0;
		document.f3.s15ext.value=0;
		document.f3.s16ext.value=0;
		document.f3.s17ext.value=0;
		document.f3.s18ext.value=0;
		document.f3.s19ext.value=0;
		document.f3.s20ext.value=0;
		document.f3.s21ext.value=0;
		document.f3.s22ext.value=0;
		document.f3.s23ext.value=0;
		document.f3.s24ext.value=0;
		document.f3.s25ext.value=0;
		document.f3.s26ext.value=0;
		document.f3.s27ext.value=0;
		document.f3.s28ext.value=0;
		document.f3.s29ext.value=0;
		document.f3.s30ext.value=0;
		document.f3.s31ext.value=0;
		document.f3.s32ext.value=0;
		document.f3.s33ext.value=0;
		document.f3.s34ext.value=0;
		document.f3.s35ext.value=0;
		document.f3.s36ext.value=0;
		document.f3.s37ext.value=0;
		document.f3.s38ext.value=0;
		document.f3.s39ext.value=0;
		document.f3.s40ext.value=0;
		document.f3.s41ext.value=0;
		document.f3.s42ext.value=0;
		document.f3.s43ext.value=0;
		document.f3.s44ext.value=0;
		document.f3.s45ext.value=0;
		document.f3.s46ext.value=0;
		document.f3.s47ext.value=0;
		document.f3.s48ext.value=0;
		document.f3.s49ext.value=0;
		document.f3.s50ext.value=0;
		document.f3.xsext.value=0;
		document.f3.sext.value=0;
		document.f3.mext.value=0;
		document.f3.lext.value=0;
		document.f3.xlext.value=0;
		document.f3.xxlext.value=0;
		document.f3.xxxlext.value=0;\" >
		</td></tr>";
		
		echo "</table></div>";
		echo "</div>";
		echo "</div>";

        // echo "</table><br><br><br><br><br><br><br><br>";
		echo "<div class=\"col-sm-12\"><div class=\"table-responsive\"><table class=\"table table-bordered\">";
		echo "<thead><tr class=\"info\"><th><center>Size</center></th><th><center>Current Order Quantity</center></th><th><center>Old Order Quantity</center></th><th><center>Size Excess %</center></th><th><center>New Order Quantity</center></th></tr><thead>";
		
		$qry4= "select * from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		$sql2=mysqli_query($link,$qry4);
		//$test_qry="select * from bai_orders_db where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		//echo $test_qry."<br>";
		while($row2=mysqli_fetch_array($sql2))
		{
			$s01_old=$row2['old_order_s_s01'];
			$s02_old=$row2['old_order_s_s02'];
			$s03_old=$row2['old_order_s_s03'];
			$s04_old=$row2['old_order_s_s04'];
			$s05_old=$row2['old_order_s_s05'];
			$s06_old=$row2['old_order_s_s06'];
			$s07_old=$row2['old_order_s_s07'];
			$s08_old=$row2['old_order_s_s08'];
			$s09_old=$row2['old_order_s_s09'];
			$s10_old=$row2['old_order_s_s10'];
			$s11_old=$row2['old_order_s_s11'];
			$s12_old=$row2['old_order_s_s12'];
			$s13_old=$row2['old_order_s_s13'];
			$s14_old=$row2['old_order_s_s14'];
			$s15_old=$row2['old_order_s_s15'];
			$s16_old=$row2['old_order_s_s16'];
			$s17_old=$row2['old_order_s_s17'];
			$s18_old=$row2['old_order_s_s18'];
			$s19_old=$row2['old_order_s_s19'];
			$s20_old=$row2['old_order_s_s20'];
			$s21_old=$row2['old_order_s_s21'];
			$s22_old=$row2['old_order_s_s22'];
			$s23_old=$row2['old_order_s_s23'];
			$s24_old=$row2['old_order_s_s24'];
			$s25_old=$row2['old_order_s_s25'];
			$s26_old=$row2['old_order_s_s26'];
			$s27_old=$row2['old_order_s_s27'];
			$s28_old=$row2['old_order_s_s28'];
			$s29_old=$row2['old_order_s_s29'];
			$s30_old=$row2['old_order_s_s30'];
			$s31_old=$row2['old_order_s_s31'];
			$s32_old=$row2['old_order_s_s32'];
			$s33_old=$row2['old_order_s_s33'];
			$s34_old=$row2['old_order_s_s34'];
			$s35_old=$row2['old_order_s_s35'];
			$s36_old=$row2['old_order_s_s36'];
			$s37_old=$row2['old_order_s_s37'];
			$s38_old=$row2['old_order_s_s38'];
			$s39_old=$row2['old_order_s_s39'];
			$s40_old=$row2['old_order_s_s40'];
			$s41_old=$row2['old_order_s_s41'];
			$s42_old=$row2['old_order_s_s42'];
			$s43_old=$row2['old_order_s_s43'];
			$s44_old=$row2['old_order_s_s44'];
			$s45_old=$row2['old_order_s_s45'];
			$s46_old=$row2['old_order_s_s46'];
			$s47_old=$row2['old_order_s_s47'];
			$s48_old=$row2['old_order_s_s48'];
			$s49_old=$row2['old_order_s_s49'];
			$s50_old=$row2['old_order_s_s50'];
			
			$s01=$row2['order_s_s01'];
			$s02=$row2['order_s_s02'];
			$s03=$row2['order_s_s03'];
			$s04=$row2['order_s_s04'];
			$s05=$row2['order_s_s05'];
			$s06=$row2['order_s_s06'];
			$s07=$row2['order_s_s07'];
			$s08=$row2['order_s_s08'];
			$s09=$row2['order_s_s09'];
			$s10=$row2['order_s_s10'];
			$s11=$row2['order_s_s11'];
			$s12=$row2['order_s_s12'];
			$s13=$row2['order_s_s13'];
			$s14=$row2['order_s_s14'];
			$s15=$row2['order_s_s15'];
			$s16=$row2['order_s_s16'];
			$s17=$row2['order_s_s17'];
			$s18=$row2['order_s_s18'];
			$s19=$row2['order_s_s19'];
			$s20=$row2['order_s_s20'];
			$s21=$row2['order_s_s21'];
			$s22=$row2['order_s_s22'];
			$s23=$row2['order_s_s23'];
			$s24=$row2['order_s_s24'];
			$s25=$row2['order_s_s25'];
			$s26=$row2['order_s_s26'];
			$s27=$row2['order_s_s27'];
			$s28=$row2['order_s_s28'];
			$s29=$row2['order_s_s29'];
			$s30=$row2['order_s_s30'];
			$s31=$row2['order_s_s31'];
			$s32=$row2['order_s_s32'];
			$s33=$row2['order_s_s33'];
			$s34=$row2['order_s_s34'];
			$s35=$row2['order_s_s35'];
			$s36=$row2['order_s_s36'];
			$s37=$row2['order_s_s37'];
			$s38=$row2['order_s_s38'];
			$s39=$row2['order_s_s39'];
			$s40=$row2['order_s_s40'];
			$s41=$row2['order_s_s41'];
			$s42=$row2['order_s_s42'];
			$s43=$row2['order_s_s43'];
			$s44=$row2['order_s_s44'];
			$s45=$row2['order_s_s45'];
			$s46=$row2['order_s_s46'];
			$s47=$row2['order_s_s47'];
			$s48=$row2['order_s_s48'];
			$s49=$row2['order_s_s49'];
			$s50=$row2['order_s_s50'];


			$size01 = $row2['title_size_s01'];
			$size02 = $row2['title_size_s02'];
			$size03 = $row2['title_size_s03'];
			$size04 = $row2['title_size_s04'];
			$size05 = $row2['title_size_s05'];
			$size06 = $row2['title_size_s06'];
			$size07 = $row2['title_size_s07'];
			$size08 = $row2['title_size_s08'];
			$size09 = $row2['title_size_s09'];
			$size10 = $row2['title_size_s10'];
			$size11 = $row2['title_size_s11'];
			$size12 = $row2['title_size_s12'];
			$size13 = $row2['title_size_s13'];
			$size14 = $row2['title_size_s14'];
			$size15 = $row2['title_size_s15'];
			$size16 = $row2['title_size_s16'];
			$size17 = $row2['title_size_s17'];
			$size18 = $row2['title_size_s18'];
			$size19 = $row2['title_size_s19'];
			$size20 = $row2['title_size_s20'];
			$size21 = $row2['title_size_s21'];
			$size22 = $row2['title_size_s22'];
			$size23 = $row2['title_size_s23'];
			$size24 = $row2['title_size_s24'];
			$size25 = $row2['title_size_s25'];
			$size26 = $row2['title_size_s26'];
			$size27 = $row2['title_size_s27'];
			$size28 = $row2['title_size_s28'];
			$size29 = $row2['title_size_s29'];
			$size30 = $row2['title_size_s30'];
			$size31 = $row2['title_size_s31'];
			$size32 = $row2['title_size_s32'];
			$size33 = $row2['title_size_s33'];
			$size34 = $row2['title_size_s34'];
			$size35 = $row2['title_size_s35'];
			$size36 = $row2['title_size_s36'];
			$size37 = $row2['title_size_s37'];
			$size38 = $row2['title_size_s38'];
			$size39 = $row2['title_size_s39'];
			$size40 = $row2['title_size_s40'];
			$size41 = $row2['title_size_s41'];
			$size42 = $row2['title_size_s42'];
			$size43 = $row2['title_size_s43'];
			$size44 = $row2['title_size_s44'];
			$size45 = $row2['title_size_s45'];
			$size46 = $row2['title_size_s46'];
			$size47 = $row2['title_size_s47'];
			$size48 = $row2['title_size_s48'];
			$size49 = $row2['title_size_s49'];
			$size50 = $row2['title_size_s50'];

				$flag = $row2['title_flag'];
				if($flag == 0)
				{
					$size01 = 1; $size01 = sprintf("%02d", $size01);
					$size02 = 2; $size02 = sprintf("%02d", $size02);
					$size03 = 3; $size03 = sprintf("%02d", $size03);
					$size04 = 4; $size04 = sprintf("%02d", $size04);
					$size05 = 5; $size05 = sprintf("%02d", $size05);
					$size06 = 6; $size06 = sprintf("%02d", $size06);
					$size07 = 7; $size07 = sprintf("%02d", $size07);
					$size08 = 8; $size08 = sprintf("%02d", $size08);
					$size09 = 9; $size09 = sprintf("%02d", $size09);
					$size10 = 10; 
					$size11 = 11;
					$size12 = 12;
					$size13 = 13;
					$size14 = 14;
					$size15 = 15;
					$size16 = 16;
					$size17 = 17;
					$size18 = 18;
					$size19 = 19;
					$size20 = 20;
					$size21 = 21;
					$size22 = 22;
					$size23 = 23;
					$size24 = 24;
					$size25 = 25;
					$size26 = 26;
					$size27 = 27;
					$size28 = 28;
					$size29 = 29;
					$size30 = 30;
					$size31 = 31;
					$size32 = 32;
					$size33 = 33;
					$size34 = 34;
					$size35 = 35;
					$size36 = 36;
					$size37 = 37;
					$size38 = 38;
					$size39 = 39;
					$size40 = 40;
					$size41 = 41;
					$size42 = 42;
					$size43 = 43;
					$size44 = 44;
					$size45 = 45;
					$size46 = 46;
					$size47 = 47;
					$size48 = 48;
					$size49 = 49;
					$size50 = 50;
				}

		}
		
		echo "<input type=\"hidden\" name=\"sty\" value=\"$style\">";
		echo "<input type=\"hidden\" name=\"sch\" value=\"$schedule\">";
		echo "<input type=\"hidden\" name=\"col\" value=\"$color\">";
				
		echo "<input type=\"hidden\" name=\"s011\" value=\"$s01\">
				<input type=\"hidden\" name=\"s021\" value=\"$s02\">
				<input type=\"hidden\" name=\"s031\" value=\"$s03\">
				<input type=\"hidden\" name=\"s041\" value=\"$s04\">
				<input type=\"hidden\" name=\"s051\" value=\"$s05\">
				<input type=\"hidden\" name=\"s061\" value=\"$s06\">
				<input type=\"hidden\" name=\"s071\" value=\"$s07\">
				<input type=\"hidden\" name=\"s081\" value=\"$s08\">
				<input type=\"hidden\" name=\"s091\" value=\"$s09\">
				<input type=\"hidden\" name=\"s101\" value=\"$s10\">
				<input type=\"hidden\" name=\"s111\" value=\"$s11\">
				<input type=\"hidden\" name=\"s121\" value=\"$s12\">
				<input type=\"hidden\" name=\"s131\" value=\"$s13\">
				<input type=\"hidden\" name=\"s141\" value=\"$s14\">
				<input type=\"hidden\" name=\"s151\" value=\"$s15\">
				<input type=\"hidden\" name=\"s161\" value=\"$s16\">
				<input type=\"hidden\" name=\"s171\" value=\"$s17\">
				<input type=\"hidden\" name=\"s181\" value=\"$s18\">
				<input type=\"hidden\" name=\"s191\" value=\"$s19\">
				<input type=\"hidden\" name=\"s201\" value=\"$s20\">
				<input type=\"hidden\" name=\"s211\" value=\"$s21\">
				<input type=\"hidden\" name=\"s221\" value=\"$s22\">
				<input type=\"hidden\" name=\"s231\" value=\"$s23\">
				<input type=\"hidden\" name=\"s241\" value=\"$s24\">
				<input type=\"hidden\" name=\"s251\" value=\"$s25\">
				<input type=\"hidden\" name=\"s261\" value=\"$s26\">
				<input type=\"hidden\" name=\"s271\" value=\"$s27\">
				<input type=\"hidden\" name=\"s281\" value=\"$s28\">
				<input type=\"hidden\" name=\"s291\" value=\"$s29\">
				<input type=\"hidden\" name=\"s301\" value=\"$s30\">
				<input type=\"hidden\" name=\"s311\" value=\"$s31\">
				<input type=\"hidden\" name=\"s321\" value=\"$s32\">
				<input type=\"hidden\" name=\"s331\" value=\"$s33\">
				<input type=\"hidden\" name=\"s341\" value=\"$s34\">
				<input type=\"hidden\" name=\"s351\" value=\"$s35\">
				<input type=\"hidden\" name=\"s361\" value=\"$s36\">
				<input type=\"hidden\" name=\"s371\" value=\"$s37\">
				<input type=\"hidden\" name=\"s381\" value=\"$s38\">
				<input type=\"hidden\" name=\"s391\" value=\"$s39\">
				<input type=\"hidden\" name=\"s401\" value=\"$s40\">
				<input type=\"hidden\" name=\"s411\" value=\"$s41\">
				<input type=\"hidden\" name=\"s421\" value=\"$s42\">
				<input type=\"hidden\" name=\"s431\" value=\"$s43\">
				<input type=\"hidden\" name=\"s441\" value=\"$s44\">
				<input type=\"hidden\" name=\"s451\" value=\"$s45\">
				<input type=\"hidden\" name=\"s461\" value=\"$s46\">
				<input type=\"hidden\" name=\"s471\" value=\"$s47\">
				<input type=\"hidden\" name=\"s481\" value=\"$s48\">
				<input type=\"hidden\" name=\"s491\" value=\"$s49\">
				<input type=\"hidden\" name=\"s501\" value=\"$s50\">";
		
		
		echo "<input type=\"hidden\" name=\"s012\" value=\"$s01_old\">
				<input type=\"hidden\" name=\"s022\" value=\"$s02_old\">
				<input type=\"hidden\" name=\"s032\" value=\"$s03_old\">
				<input type=\"hidden\" name=\"s042\" value=\"$s04_old\">
				<input type=\"hidden\" name=\"s052\" value=\"$s05_old\">
				<input type=\"hidden\" name=\"s062\" value=\"$s06_old\">
				<input type=\"hidden\" name=\"s072\" value=\"$s07_old\">
				<input type=\"hidden\" name=\"s082\" value=\"$s08_old\">
				<input type=\"hidden\" name=\"s092\" value=\"$s09_old\">
				<input type=\"hidden\" name=\"s102\" value=\"$s10_old\">
				<input type=\"hidden\" name=\"s112\" value=\"$s11_old\">
				<input type=\"hidden\" name=\"s122\" value=\"$s12_old\">
				<input type=\"hidden\" name=\"s132\" value=\"$s13_old\">
				<input type=\"hidden\" name=\"s142\" value=\"$s14_old\">
				<input type=\"hidden\" name=\"s152\" value=\"$s15_old\">
				<input type=\"hidden\" name=\"s162\" value=\"$s16_old\">
				<input type=\"hidden\" name=\"s172\" value=\"$s17_old\">
				<input type=\"hidden\" name=\"s182\" value=\"$s18_old\">
				<input type=\"hidden\" name=\"s192\" value=\"$s19_old\">
				<input type=\"hidden\" name=\"s202\" value=\"$s20_old\">
				<input type=\"hidden\" name=\"s212\" value=\"$s21_old\">
				<input type=\"hidden\" name=\"s222\" value=\"$s22_old\">
				<input type=\"hidden\" name=\"s232\" value=\"$s23_old\">
				<input type=\"hidden\" name=\"s242\" value=\"$s24_old\">
				<input type=\"hidden\" name=\"s252\" value=\"$s25_old\">
				<input type=\"hidden\" name=\"s262\" value=\"$s26_old\">
				<input type=\"hidden\" name=\"s272\" value=\"$s27_old\">
				<input type=\"hidden\" name=\"s282\" value=\"$s28_old\">
				<input type=\"hidden\" name=\"s292\" value=\"$s29_old\">
				<input type=\"hidden\" name=\"s302\" value=\"$s30_old\">
				<input type=\"hidden\" name=\"s312\" value=\"$s31_old\">
				<input type=\"hidden\" name=\"s322\" value=\"$s32_old\">
				<input type=\"hidden\" name=\"s332\" value=\"$s33_old\">
				<input type=\"hidden\" name=\"s342\" value=\"$s34_old\">
				<input type=\"hidden\" name=\"s352\" value=\"$s35_old\">
				<input type=\"hidden\" name=\"s362\" value=\"$s36_old\">
				<input type=\"hidden\" name=\"s372\" value=\"$s37_old\">
				<input type=\"hidden\" name=\"s382\" value=\"$s38_old\">
				<input type=\"hidden\" name=\"s392\" value=\"$s39_old\">
				<input type=\"hidden\" name=\"s402\" value=\"$s40_old\">
				<input type=\"hidden\" name=\"s412\" value=\"$s41_old\">
				<input type=\"hidden\" name=\"s422\" value=\"$s42_old\">
				<input type=\"hidden\" name=\"s432\" value=\"$s43_old\">
				<input type=\"hidden\" name=\"s442\" value=\"$s44_old\">
				<input type=\"hidden\" name=\"s452\" value=\"$s45_old\">
				<input type=\"hidden\" name=\"s462\" value=\"$s46_old\">
				<input type=\"hidden\" name=\"s472\" value=\"$s47_old\">
				<input type=\"hidden\" name=\"s482\" value=\"$s48_old\">
				<input type=\"hidden\" name=\"s492\" value=\"$s49_old\">
				<input type=\"hidden\" name=\"s502\" value=\"$s50_old\">";
			echo "<tbody>";
			$j =11;
			for($i = 1; $i<=50; $i++ )
			{
				$x=$i;
				$i = sprintf("%02d",$x);
				$y =$j;
				$j = sprintf("%03d",$y);
				if(${size.$i} != null and ${s.$i} != null and ${s.$i._old} != null)
				{
					$flag = (${"s".$i} == 0)?'readonly':'';	
					$row_count++;				
					echo "<tr>
							  <td><center>".${"size".$i}."</center></td>
							  <td><center>".${"s".$i}."</center></td>
							  <td><center>".${"s".$i._old}."</center></td>
							  <td><center><input type=\"text\" style='border=\"0px\"' name=\"s".$i."ext\" value=\"0\" size=\"4\" class=\"form-control input-sm float\" 
									  onKeyUp=\"
												  if(event.keyCode == 9) 
												  		return; 
												  else if(document.f3.s".$i."ext.value.length == 0 || document.f3.s".$i."ext.value.length == '' )
												  	 document.f3.s".$i.".value = parseInt(document.f3.s".$j.".value)+parseInt(document.f3.s".$j.".value*document.f3.ext.value/100);
												  else
													  document.f3.s".$i.".value = parseInt(document.f3.s".$j.".value)+parseInt(document.f3.s".$j.".value*document.f3.s".$i."ext.value/100);\"
									  	  ></center></td>
							  <td><center><input class=\"form-control input-sm\" type=\"text\" readonly style='border=\"0px\"' $flag onkeypress=\"return isNum(event)\" name=\"s".$i."\" value=".${"s".$i}."></center></td></tr>";
					//    <tr><td>$size01</td><td>$s01</td><td>$s01_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s01ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s01.value=parseInt(document.f3.s011.value)+parseInt(document.f3.s011.value*document.f3.s01ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s01\" value=\"$s01\"></td>
				}
				$j = $j+10;
			}				
// echo "<tr><td>$size01</td><td>$s01</td><td>$s01_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s01ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s01.value=parseInt(document.f3.s011.value)+parseInt(document.f3.s011.value*document.f3.s01ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s01\" value=\"$s01\"></td>
// <tr><td>$size02</td><td>$s02</td><td>$s02_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s02ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s02.value=parseInt(document.f3.s021.value)+parseInt(document.f3.s021.value*document.f3.s02ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s02\" value=\"$s02\"></td>
// <tr><td>$size03</td><td>$s03</td><td>$s03_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s03ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s03.value=parseInt(document.f3.s031.value)+parseInt(document.f3.s031.value*document.f3.s03ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s03\" value=\"$s03\"></td>
// <tr><td>$size04</td><td>$s04</td><td>$s04_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s04ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s04.value=parseInt(document.f3.s041.value)+parseInt(document.f3.s041.value*document.f3.s04ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s04\" value=\"$s04\"></td>
// <tr><td>$size05</td><td>$s05</td><td>$s05_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s05ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s05.value=parseInt(document.f3.s051.value)+parseInt(document.f3.s051.value*document.f3.s05ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s05\" value=\"$s05\"></td>
// <tr><td>$size06</td><td>$s06</td><td>$s06_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s06ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s06.value=parseInt(document.f3.s061.value)+parseInt(document.f3.s061.value*document.f3.s06ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s06\" value=\"$s06\"></td>
// <tr><td>$size07</td><td>$s07</td><td>$s07_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s07ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s07.value=parseInt(document.f3.s071.value)+parseInt(document.f3.s071.value*document.f3.s07ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s07\" value=\"$s07\"></td>
// <tr><td>$size08</td><td>$s08</td><td>$s08_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s08ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s08.value=parseInt(document.f3.s081.value)+parseInt(document.f3.s081.value*document.f3.s08ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s08\" value=\"$s08\"></td>
// <tr><td>$size09</td><td>$s09</td><td>$s09_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s09ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s09.value=parseInt(document.f3.s091.value)+parseInt(document.f3.s091.value*document.f3.s09ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s09\" value=\"$s09\"></td>
// <tr><td>$size10</td><td>$s10</td><td>$s10_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s10ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s10.value=parseInt(document.f3.s101.value)+parseInt(document.f3.s101.value*document.f3.s10ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s10\" value=\"$s10\"></td>
// <tr><td>$size11</td><td>$s11</td><td>$s11_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s11ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s11.value=parseInt(document.f3.s111.value)+parseInt(document.f3.s111.value*document.f3.s11ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s11\" value=\"$s11\"></td>
// <tr><td>$size12</td><td>$s12</td><td>$s12_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s12ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s12.value=parseInt(document.f3.s121.value)+parseInt(document.f3.s121.value*document.f3.s12ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s12\" value=\"$s12\"></td>
// <tr><td>$size13</td><td>$s13</td><td>$s13_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s13ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s13.value=parseInt(document.f3.s131.value)+parseInt(document.f3.s131.value*document.f3.s13ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s13\" value=\"$s13\"></td>
// <tr><td>$size14</td><td>$s14</td><td>$s14_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s14ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s14.value=parseInt(document.f3.s141.value)+parseInt(document.f3.s141.value*document.f3.s14ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s14\" value=\"$s14\"></td>
// <tr><td>$size15</td><td>$s15</td><td>$s15_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s15ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s15.value=parseInt(document.f3.s151.value)+parseInt(document.f3.s151.value*document.f3.s15ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s15\" value=\"$s15\"></td>
// <tr><td>$size16</td><td>$s16</td><td>$s16_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s16ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s16.value=parseInt(document.f3.s161.value)+parseInt(document.f3.s161.value*document.f3.s16ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s16\" value=\"$s16\"></td>
// <tr><td>$size17</td><td>$s17</td><td>$s17_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s17ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s17.value=parseInt(document.f3.s171.value)+parseInt(document.f3.s171.value*document.f3.s17ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s17\" value=\"$s17\"></td>
// <tr><td>$size18</td><td>$s18</td><td>$s18_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s18ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s18.value=parseInt(document.f3.s181.value)+parseInt(document.f3.s181.value*document.f3.s18ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s18\" value=\"$s18\"></td>
// <tr><td>$size19</td><td>$s19</td><td>$s19_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s19ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s19.value=parseInt(document.f3.s191.value)+parseInt(document.f3.s191.value*document.f3.s19ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s19\" value=\"$s19\"></td>
// <tr><td>$size20</td><td>$s20</td><td>$s20_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s20ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s20.value=parseInt(document.f3.s201.value)+parseInt(document.f3.s201.value*document.f3.s20ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s20\" value=\"$s20\"></td>
// <tr><td>$size21</td><td>$s21</td><td>$s21_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s21ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s21.value=parseInt(document.f3.s211.value)+parseInt(document.f3.s211.value*document.f3.s21ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s21\" value=\"$s21\"></td>
// <tr><td>$size22</td><td>$s22</td><td>$s22_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s22ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s22.value=parseInt(document.f3.s221.value)+parseInt(document.f3.s221.value*document.f3.s22ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s22\" value=\"$s22\"></td>
// <tr><td>$size23</td><td>$s23</td><td>$s23_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s23ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s23.value=parseInt(document.f3.s231.value)+parseInt(document.f3.s231.value*document.f3.s23ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s23\" value=\"$s23\"></td>
// <tr><td>$size24</td><td>$s24</td><td>$s24_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s24ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s24.value=parseInt(document.f3.s241.value)+parseInt(document.f3.s241.value*document.f3.s24ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s24\" value=\"$s24\"></td>
// <tr><td>$size25</td><td>$s25</td><td>$s25_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s25ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s25.value=parseInt(document.f3.s251.value)+parseInt(document.f3.s251.value*document.f3.s25ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s25\" value=\"$s25\"></td>
// <tr><td>$size26</td><td>$s26</td><td>$s26_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s26ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s26.value=parseInt(document.f3.s261.value)+parseInt(document.f3.s261.value*document.f3.s26ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s26\" value=\"$s26\"></td>
// <tr><td>$size27</td><td>$s27</td><td>$s27_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s27ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s27.value=parseInt(document.f3.s271.value)+parseInt(document.f3.s271.value*document.f3.s27ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s27\" value=\"$s27\"></td>
// <tr><td>$size28</td><td>$s28</td><td>$s28_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s28ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s28.value=parseInt(document.f3.s281.value)+parseInt(document.f3.s281.value*document.f3.s28ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s28\" value=\"$s28\"></td>
// <tr><td>$size29</td><td>$s29</td><td>$s29_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s29ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s29.value=parseInt(document.f3.s291.value)+parseInt(document.f3.s291.value*document.f3.s29ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s29\" value=\"$s29\"></td>
// <tr><td>$size30</td><td>$s30</td><td>$s30_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s30ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s30.value=parseInt(document.f3.s301.value)+parseInt(document.f3.s301.value*document.f3.s30ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s30\" value=\"$s30\"></td>
// <tr><td>$size31</td><td>$s31</td><td>$s31_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s31ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s31.value=parseInt(document.f3.s311.value)+parseInt(document.f3.s311.value*document.f3.s31ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s31\" value=\"$s31\"></td>
// <tr><td>$size32</td><td>$s32</td><td>$s32_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s32ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s32.value=parseInt(document.f3.s321.value)+parseInt(document.f3.s321.value*document.f3.s32ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s32\" value=\"$s32\"></td>
// <tr><td>$size33</td><td>$s33</td><td>$s33_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s33ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s33.value=parseInt(document.f3.s331.value)+parseInt(document.f3.s331.value*document.f3.s33ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s33\" value=\"$s33\"></td>
// <tr><td>$size34</td><td>$s34</td><td>$s34_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s34ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s34.value=parseInt(document.f3.s341.value)+parseInt(document.f3.s341.value*document.f3.s34ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s34\" value=\"$s34\"></td>
// <tr><td>$size35</td><td>$s35</td><td>$s35_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s35ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s35.value=parseInt(document.f3.s351.value)+parseInt(document.f3.s351.value*document.f3.s35ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s35\" value=\"$s35\"></td>
// <tr><td>$size36</td><td>$s36</td><td>$s36_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s36ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s36.value=parseInt(document.f3.s361.value)+parseInt(document.f3.s361.value*document.f3.s36ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s36\" value=\"$s36\"></td>
// <tr><td>$size37</td><td>$s37</td><td>$s37_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s37ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s37.value=parseInt(document.f3.s371.value)+parseInt(document.f3.s371.value*document.f3.s37ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s37\" value=\"$s37\"></td>
// <tr><td>$size38</td><td>$s38</td><td>$s38_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s38ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s38.value=parseInt(document.f3.s381.value)+parseInt(document.f3.s381.value*document.f3.s38ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s38\" value=\"$s38\"></td>
// <tr><td>$size39</td><td>$s39</td><td>$s39_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s39ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s39.value=parseInt(document.f3.s391.value)+parseInt(document.f3.s391.value*document.f3.s39ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s39\" value=\"$s39\"></td>
// <tr><td>$size40</td><td>$s40</td><td>$s40_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s40ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s40.value=parseInt(document.f3.s401.value)+parseInt(document.f3.s401.value*document.f3.s40ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s40\" value=\"$s40\"></td>
// <tr><td>$size41</td><td>$s41</td><td>$s41_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s41ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s41.value=parseInt(document.f3.s411.value)+parseInt(document.f3.s411.value*document.f3.s41ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s41\" value=\"$s41\"></td>
// <tr><td>$size42</td><td>$s42</td><td>$s42_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s42ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s42.value=parseInt(document.f3.s421.value)+parseInt(document.f3.s421.value*document.f3.s42ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s42\" value=\"$s42\"></td>
// <tr><td>$size43</td><td>$s43</td><td>$s43_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s43ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s43.value=parseInt(document.f3.s431.value)+parseInt(document.f3.s431.value*document.f3.s43ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s43\" value=\"$s43\"></td>
// <tr><td>$size44</td><td>$s44</td><td>$s44_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s44ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s44.value=parseInt(document.f3.s441.value)+parseInt(document.f3.s441.value*document.f3.s44ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s44\" value=\"$s44\"></td>
// <tr><td>$size45</td><td>$s45</td><td>$s45_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s45ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s45.value=parseInt(document.f3.s451.value)+parseInt(document.f3.s451.value*document.f3.s45ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s45\" value=\"$s45\"></td>
// <tr><td>$size46</td><td>$s46</td><td>$s46_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s46ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s46.value=parseInt(document.f3.s461.value)+parseInt(document.f3.s461.value*document.f3.s46ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s46\" value=\"$s46\"></td>
// <tr><td>$size47</td><td>$s47</td><td>$s47_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s47ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s47.value=parseInt(document.f3.s471.value)+parseInt(document.f3.s471.value*document.f3.s47ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s47\" value=\"$s47\"></td>
// <tr><td>$size48</td><td>$s48</td><td>$s48_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s48ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s48.value=parseInt(document.f3.s481.value)+parseInt(document.f3.s481.value*document.f3.s48ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s48\" value=\"$s48\"></td>
// <tr><td>$size49</td><td>$s49</td><td>$s49_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s49ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s49.value=parseInt(document.f3.s491.value)+parseInt(document.f3.s491.value*document.f3.s49ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s49\" value=\"$s49\"></td>
// <tr><td>$size50</td><td>$s50</td><td>$s50_old</td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s50ext\" value=\"0\" size=\"4\" onKeyUp=\"document.f3.s50.value=parseInt(document.f3.s501.value)+parseInt(document.f3.s501.value*document.f3.s50ext.value/100);\"></td><td><input type=\"textbox\" style='border=\"0px\"' name=\"s50\" value=\"$s50\"></td>";
	echo "<tr><td class=\" \"></td><td class=\" \"></td><td class=\" \"></td><td class=\" \"></td><td class=\" \">
	  <input type=\"submit\" value=\"Update\" name=\"update\" id='update_btn' class=\"btn btn-success\"></td></tr><tbody>";
	echo "</table></div></div>";

		if($row_count == 0){
			echo "<script>document.getElementById('update_btn').disabled = true;</script>";
		}
	}
}
}
?> 
</form> 
</div>
</div>
</div>
<?php

if(isset($_POST["update"]))
{
	$sty=$_POST["sty"];
	$sch=$_POST["sch"];
	$col=$_POST["col"];
	$ext=$_POST["ext"];
	
	$s01_old=$_POST["s011"];
	$s02_old=$_POST["s021"];
	$s03_old=$_POST["s031"];
	$s04_old=$_POST["s041"];
	$s05_old=$_POST["s051"];
	$s06_old=$_POST["s061"];
	$s07_old=$_POST["s071"];
	$s08_old=$_POST["s081"];
	$s09_old=$_POST["s091"];
	$s10_old=$_POST["s101"];
	$s11_old=$_POST["s111"];
	$s12_old=$_POST["s121"];
	$s13_old=$_POST["s131"];
	$s14_old=$_POST["s141"];
	$s15_old=$_POST["s151"];
	$s16_old=$_POST["s161"];
	$s17_old=$_POST["s171"];
	$s18_old=$_POST["s181"];
	$s19_old=$_POST["s191"];
	$s20_old=$_POST["s201"];
	$s21_old=$_POST["s211"];
	$s22_old=$_POST["s221"];
	$s23_old=$_POST["s231"];
	$s24_old=$_POST["s241"];
	$s25_old=$_POST["s251"];
	$s26_old=$_POST["s261"];
	$s27_old=$_POST["s271"];
	$s28_old=$_POST["s281"];
	$s29_old=$_POST["s291"];
	$s30_old=$_POST["s301"];
	$s31_old=$_POST["s311"];
	$s32_old=$_POST["s321"];
	$s33_old=$_POST["s331"];
	$s34_old=$_POST["s341"];
	$s35_old=$_POST["s351"];
	$s36_old=$_POST["s361"];
	$s37_old=$_POST["s371"];
	$s38_old=$_POST["s381"];
	$s39_old=$_POST["s391"];
	$s40_old=$_POST["s401"];
	$s41_old=$_POST["s411"];
	$s42_old=$_POST["s421"];
	$s43_old=$_POST["s431"];
	$s44_old=$_POST["s441"];
	$s45_old=$_POST["s451"];
	$s46_old=$_POST["s461"];
	$s47_old=$_POST["s471"];
	$s48_old=$_POST["s481"];
	$s49_old=$_POST["s491"];
	$s50_old=$_POST["s501"];
	
	$s01_new=$_POST["s01"];
	$s02_new=$_POST["s02"];
	$s03_new=$_POST["s03"];
	$s04_new=$_POST["s04"];
	$s05_new=$_POST["s05"];
	$s06_new=$_POST["s06"];
	$s07_new=$_POST["s07"];
	$s08_new=$_POST["s08"];
	$s09_new=$_POST["s09"];
	$s10_new=$_POST["s10"];
	$s11_new=$_POST["s11"];
	$s12_new=$_POST["s12"];
	$s13_new=$_POST["s13"];
	$s14_new=$_POST["s14"];
	$s15_new=$_POST["s15"];
	$s16_new=$_POST["s16"];
	$s17_new=$_POST["s17"];
	$s18_new=$_POST["s18"];
	$s19_new=$_POST["s19"];
	$s20_new=$_POST["s20"];
	$s21_new=$_POST["s21"];
	$s22_new=$_POST["s22"];
	$s23_new=$_POST["s23"];
	$s24_new=$_POST["s24"];
	$s25_new=$_POST["s25"];
	$s26_new=$_POST["s26"];
	$s27_new=$_POST["s27"];
	$s28_new=$_POST["s28"];
	$s29_new=$_POST["s29"];
	$s30_new=$_POST["s30"];
	$s31_new=$_POST["s31"];
	$s32_new=$_POST["s32"];
	$s33_new=$_POST["s33"];
	$s34_new=$_POST["s34"];
	$s35_new=$_POST["s35"];
	$s36_new=$_POST["s36"];
	$s37_new=$_POST["s37"];
	$s38_new=$_POST["s38"];
	$s39_new=$_POST["s39"];
	$s40_new=$_POST["s40"];
	$s41_new=$_POST["s41"];
	$s42_new=$_POST["s42"];
	$s43_new=$_POST["s43"];
	$s44_new=$_POST["s44"];
	$s45_new=$_POST["s45"];
	$s46_new=$_POST["s46"];
	$s47_new=$_POST["s47"];
	$s48_new=$_POST["s48"];
	$s49_new=$_POST["s49"];
	$s50_new=$_POST["s50"];


	
	$update="update $bai_pro3.bai_orders_db set order_no=\"1\",old_order_s_s01=\"$s01_old\",old_order_s_s02=\"$s02_old\",old_order_s_s03=\"$s03_old\",old_order_s_s04=\"$s04_old\",old_order_s_s05=\"$s05_old\",old_order_s_s06=\"$s06_old\",old_order_s_s07=\"$s07_old\",old_order_s_s08=\"$s08_old\",old_order_s_s09=\"$s09_old\",old_order_s_s10=\"$s10_old\",old_order_s_s11=\"$s11_old\",old_order_s_s12=\"$s12_old\",old_order_s_s13=\"$s13_old\",old_order_s_s14=\"$s14_old\",old_order_s_s15=\"$s15_old\",old_order_s_s16=\"$s16_old\",old_order_s_s17=\"$s17_old\",old_order_s_s18=\"$s18_old\",old_order_s_s19=\"$s19_old\",old_order_s_s20=\"$s20_old\",old_order_s_s21=\"$s21_old\",old_order_s_s22=\"$s22_old\",old_order_s_s23=\"$s23_old\",old_order_s_s24=\"$s24_old\",old_order_s_s25=\"$s25_old\",old_order_s_s26=\"$s26_old\",old_order_s_s27=\"$s27_old\",old_order_s_s28=\"$s28_old\",old_order_s_s29=\"$s29_old\",old_order_s_s30=\"$s30_old\",old_order_s_s31=\"$s31_old\",old_order_s_s32=\"$s32_old\",old_order_s_s33=\"$s33_old\",old_order_s_s34=\"$s34_old\",old_order_s_s35=\"$s35_old\",old_order_s_s36=\"$s36_old\",old_order_s_s37=\"$s37_old\",old_order_s_s38=\"$s38_old\",old_order_s_s39=\"$s39_old\",old_order_s_s40=\"$s40_old\",old_order_s_s41=\"$s41_old\",old_order_s_s42=\"$s42_old\",old_order_s_s43=\"$s43_old\",old_order_s_s44=\"$s44_old\",old_order_s_s45=\"$s45_old\",old_order_s_s46=\"$s46_old\",old_order_s_s47=\"$s47_old\",old_order_s_s48=\"$s48_old\",old_order_s_s49=\"$s49_old\",old_order_s_s50=\"$s50_old\",order_s_s01=\"$s01_new\",order_s_s02=\"$s02_new\",order_s_s03=\"$s03_new\",order_s_s04=\"$s04_new\",order_s_s05=\"$s05_new\",order_s_s06=\"$s06_new\",order_s_s07=\"$s07_new\",order_s_s08=\"$s08_new\",order_s_s09=\"$s09_new\",order_s_s10=\"$s10_new\",order_s_s11=\"$s11_new\",order_s_s12=\"$s12_new\",order_s_s13=\"$s13_new\",order_s_s14=\"$s14_new\",order_s_s15=\"$s15_new\",order_s_s16=\"$s16_new\",order_s_s17=\"$s17_new\",order_s_s18=\"$s18_new\",order_s_s19=\"$s19_new\",order_s_s20=\"$s20_new\",order_s_s21=\"$s21_new\",order_s_s22=\"$s22_new\",order_s_s23=\"$s23_new\",order_s_s24=\"$s24_new\",order_s_s25=\"$s25_new\",order_s_s26=\"$s26_new\",order_s_s27=\"$s27_new\",order_s_s28=\"$s28_new\",order_s_s29=\"$s29_new\",order_s_s30=\"$s30_new\",order_s_s31=\"$s31_new\",order_s_s32=\"$s32_new\",order_s_s33=\"$s33_new\",order_s_s34=\"$s34_new\",order_s_s35=\"$s35_new\",order_s_s36=\"$s36_new\",order_s_s37=\"$s37_new\",order_s_s38=\"$s38_new\",order_s_s39=\"$s39_new\",order_s_s40=\"$s40_new\",order_s_s41=\"$s41_new\",order_s_s42=\"$s42_new\",order_s_s43=\"$s43_new\",order_s_s44=\"$s44_new\",order_s_s45=\"$s45_new\",order_s_s46=\"$s46_new\",order_s_s47=\"$s47_new\",order_s_s48=\"$s48_new\",order_s_s49=\"$s49_new\",order_s_s50=\"$s50_new\" where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$col\"";
// echo $update;
	//echo "<table><tr><th>$update</th></tr></table>";

    if(!mysqli_query($link, $update))
	{
		echo "<div class=\"col-sm-12 alert-danger\"><h2><span class=\"label label-default\">Order quantities already updated!</span></h2></div>";
	}
	else
	{
		$insert="insert into $bai_pro3.bai_orders_db_confirm (select * from bai_orders_db where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$col\")";
		// echo $insert;
        if(!mysqli_query($link, $insert))
		{
			//echo "<div class=\"col-sm-12 alert-danger\"><h2><span>Records are not inserted Failed!</span></h2></div>";
			echo "<script>sweetAlert('Order Quantity Update Failed','','warning');</script>";
		}
		else
		{
			//echo "<div class=\"col-sm-12 alert-success\"><h2><span>Order Quantity Updated Successfully</span></h2></div>";
			echo "<script>sweetAlert('Order Quantity Updated Successfully','','success');</script>";
		}
		
	}

	
?>
	</div>
</div>
</div>







<?php	
	$email_header="<html><head><style>
		body
		{
			font-family: Trebuchet MS;
			font-size: 12px;
		}
		
		table
		{
		border-collapse:collapse;
		white-space:nowrap;
		tr.total
		{
		font-weight: bold;
		white-space:nowrap; 
		}
		
		table
		{
		border-collapse:collapse;
		white-space:nowrap;
		font-size: 12pt; 
		}
		}
		
		th
		{
			background-color: RED;
			color: WHITE;
		border: 1px solid #660000;
			padding: 10px;
		white-space:nowrap; 
		
		}
		
		td
		{
			background-color: WHITE;
			color: BLACK;
		border: 1px solid #660000;
			padding: 1px;
		white-space:nowrap; 
		}
		
		td.date
		{
			background-color: WHITE;
			color: BLACK;
		border: 1px solid #660000;
			padding: 5px;
		white-space:nowrap;
		text-align:center;
		}
		
		
		td.style
		{
			background-color: YELLOW;
			color: BLACK;
		border: 1px solid #660000;
			padding: 2px;
		white-space:nowrap; 
		font-weight: bold;
		}
		</style></head><body>";
	$email_footer="</body></html>";
	
	
	function send_email1($from, $to, $bcc, $subject1, $message1)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: BAI-PRO <".$from.">\r\n";
		$headers .= "Reply-To: ".$from."\r\n";
		$headers .= "Return-Path: ".$from."\r\n";
		//$headers .= "CC: ".$cc."\r\n"
		$headers .= "BCC: ".$to."\r\n";
						
		if (mail($to,$subject1,$message1,$headers) ) 
		{  		
			echo "<h2 align='center'>Email Successfully sent</h2>";	
		} 
		else 
	    {				
			echo "<h2 align='center'>Email could not be sent</h2>";			
		}									
	}
					
	$subject1 = $plant_alert_code."Order Quantity Amendments of $sch on ".date("Y-m-d H:i:s")."";
																	
	$message1 =$email_header;
									
	$message1 .= "Dear All,</BR></BR> Sunny added ".$ext."% extra quantity to $sch schedule Order Qty.<br><br> ";
	
	$message1 .= "<table><tr><th>Size</th><th>New Order Qty</th><th>Old Order Qty</th></tr><tr><td>XS</td><td>$xs_new</td><td>$xs_old</td></tr><tr><td>S</td><td>$s_new</td><td>$s_old</td></tr><tr><td>M</td><td>$m_new</td><td>$m_old</td><tr><td>L</td><td>$l_new</td><td>$l_old</td></tr><tr><td>XL</td><td>$xl_new</td><td>$xl_old</td></tr><tr><td>XXL</td><td>$xxl_new</td><td>$xxl_old</td></tr><tr><td>XXXL</td><td>$xxxl_new</td><td>$xxxl_old</td></tr></table>";
											
	
	
										
	$message1 .=$email_footer;		
											
	send_email1("baiict@brandix.com",$order_quantity_mail,"",$subject1,$message1);
}

?>
