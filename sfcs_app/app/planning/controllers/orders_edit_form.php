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
function validate_qty(ele)
{
	var k= 10;
	var exist_qty = $('#temp'+ele.id).val();
	console.log('entered = '+exist_qty);
	if(Number(ele.value) < Number(exist_qty) ){
		swal("You are entering new order quantity less than the current order quantity","","warning");
		ele.value = exist_qty;
	}
	
}



function firstbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value;
}

function secondbox()
{
		window.location.href ="index.php?r=<?php echo $_GET['r'] ?>"+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value
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

?>

<form name="test" action="index.php?r=<?php echo $_GET['r']; ?>" method="post">
<div class="form-group">
<?php
// include("dbconf.php");
echo "<div class=\"col-sm-12\"><div class=\"row\"><div class=\"col-sm-3\">
	  <label for='style'>Select Style:</label> 
	  <select class =\"form-control\" name=\"style\" id=\"style\"  onchange=\"firstbox();\" >";

$sql="select distinct order_style_no from $bai_pro3.bai_orders_db where $order_joins_not_in";	
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
$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and $order_joins_not_in";	

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
	  <select class = \"form-control\" name=\"color\" id=\"color\" onclick=\"return check_style_sch();\" >";
$sql_result='';
if($schedule){
$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and $order_joins_not_in";
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
	
	$qry12 = "select order_tid,order_joins,order_no from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
	//echo $qry12."<br>";
	$sql12=mysqli_query($link,$qry12);
	while($row12=mysqli_fetch_array($sql12))
	{
		$order_tid=$row12["order_tid"];
		$ord_joins=$row12["order_joins"];
		$ord_no=$row12["order_no"];
		//echo $ord_joins."<br>";
		if($ord_joins<>'0')
		{
			//echo "Test===".$ord_joins."<br>";
			if(strlen($ord_joins)<4)
			{
				$status_col="Color-".str_replace("J","",$ord_joins)."";
				$sel_club="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$status_col\"";
				//echo $sel_club."<br>";
				$sql_res=mysqli_query($link, $sel_club);
				while($row = mysqli_fetch_array($sql_res))
				{
					$tid=$row['order_tid'];
					$sel_check="select count(*) as cnt from $bai_pro3.cat_stat_log where order_tid='".$tid."' and category<>''";
					//echo $sel_club."<br>";
					$sql_check=mysqli_query($link, $sel_check);
					if(mysqli_num_rows($sql_check)>0)
					{	
						while($row_check = mysqli_fetch_array($sql_check))
						{
							$val=$row_check['cnt'];
						}
					}
					else					
					{
						$val=0;
					}	
				}	
			}
			else
			{
				$status_sch=str_replace("J","",$ord_joins);
				$sel_club="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$status_sch\" and order_col_des=\"$color\"";
				$sql_res=mysqli_query($link, $sel_club);
				//echo $sel_club."<br>";
				while($row = mysqli_fetch_array($sql_res))
				{
					$tid=$row['order_tid'];
					$sel_check="select count(*) as cnt from $bai_pro3.cat_stat_log where order_tid='".$tid."' and category<>''";
					//echo $sel_check."<br>";
					$sql_check=mysqli_query($link, $sel_check);
					if(mysqli_num_rows($sql_check)>0)
					{	
						while($row_check = mysqli_fetch_array($sql_check))
						{
							$val=$row_check['cnt'];
						}
					}
					else					
					{
						$val=0;
					}	
				}			
			}			
		}
		else
		{
			$sel_club="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
			$sql_res=mysqli_query($link, $sel_club);
			if(mysqli_num_rows($sql_res)>0)
			{
				while($row = mysqli_fetch_array($sql_res))
				{
					$tid=$row['order_tid'];
					$sel_check="select count(*) as cnt from $bai_pro3.cat_stat_log where order_tid='".$tid."' and category<>''";
					$sql_check=mysqli_query($link, $sel_check);
					if(mysqli_num_rows($sql_check)>0)
					{	
						while($row_check = mysqli_fetch_array($sql_check))
						{
							$val=$row_check['cnt'];
						}
					}
					else					
					{
						$val=0;
					}	
				}
			}
			else
			{
				$val=0;
			}	
		}	
	}	
	//echo $ord_joins."----".$val."<br>";
	//echo $ord_no."----".$val."<br>";
	if($ord_no=='1' || $val>0)
	{
		echo "<div class=\"col-sm-12\"><h4 align=left style='color:red;'>
			  <span class=\"label label-warning\">Order Quantity already Updated</span></h4></div>";
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
			for($ij=0;$ij<sizeof($sizes_array);$ij++)
			{
				$code="";
				$code="".$sizes_array[$ij]."_old";
				$$code=$row2["old_order_s_".$sizes_array[$ij].""];
				$code="";
				$code=$sizes_array[$ij];
				$$code=$row2["order_s_".$sizes_array[$ij].""];
				$code="";
				$code="size".$sizes_code[$ij]."";
				$$code=$row2["title_size_".$sizes_array[$ij].""];
				$code="";
				$code="".$sizes_array[$ij]."_dif";
				$code1="";
				$code1="".$sizes_array[$ij]."_old";
				$code2="";
				$code2=$sizes_array[$ij];
				$$code=$$code2-$$code1;
				$code="";	
				
			}	
				
		}		
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

		
		echo "</tbody></table></div></div><br>";
		
	}
	else
	{
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
		if($ord_joins=='0')
		{
			$qry4= "select * from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		}
		else
		{
			$qry4= "select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		}	
		$sql2=mysqli_query($link,$qry4);
		//$test_qry="select * from bai_orders_db where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
		//echo $qry4."<br>";
		while($row2=mysqli_fetch_array($sql2))
		{
			for($ij=0;$ij<sizeof($sizes_array);$ij++)
			{
				$code="";
				$code="".$sizes_array[$ij]."_old";
				$$code=$row2["old_order_s_".$sizes_array[$ij].""];
				$code="";
				$code=$sizes_array[$ij];
				$$code=$row2["order_s_".$sizes_array[$ij].""];
				$code="";
				$code="size".$sizes_code[$ij]."";
				$$code=$row2["title_size_".$sizes_array[$ij].""];
				$code="";					
			}			
		}
		
		echo "<input type=\"hidden\" name=\"sty\" value=\"$style\">";
		echo "<input type=\"hidden\" name=\"sch\" value=\"$schedule\">";
		echo "<input type=\"hidden\" name=\"col\" value=\"$color\">";
		echo "<input type=\"hidden\" name=\"order_join\" value=\"$ord_joins\">";				
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
				 
				  <td><center>".${"s".$i._old}."</center></td>
				  <td><center><input type='hidden' id='temps$i'  value='".${"s".$i}."'><center>".${"s".$i}."</center></td>
				  <td><center><input type=\"text\" style='border=\"0px\"' name=\"s".$i."ext\" value=\"0\" size=\"4\" class=\"form-control input-sm float\" 
				  onKeyUp=\"
				  if(event.keyCode == 9) 
						return; 
				  else if(document.f3.s".$i."ext.value.length == 0 || document.f3.s".$i."ext.value.length == '' )
					 document.f3.s".$i.".value = parseInt(document.f3.s".$j.".value)+parseInt(document.f3.s".$j.".value*document.f3.ext.value/100);
				  else
					  document.f3.s".$i.".value = parseInt(document.f3.s".$j.".value)+parseInt(document.f3.s".$j.".value*document.f3.s".$i."ext.value/100);\"
				  ></center></td>
					<td><center><input class=\"form-control input-sm\" type=\"text\"  style='border=\"0px\"' $flag onchange=\"validate_qty(this);\" name=\"s".$i."\" id=\"s".$i."\" value=".${"s".$i}."></center></td></tr>";
				}
				$j = $j+10;
			}				

	echo "<tr><td class=\" \"></td><td class=\" \"></td><td class=\" \"></td><td class=\" \"></td><td class=\" \">
	  <input type=\"submit\" value=\"Update\" name=\"update\" id='update_btn' class=\"btn btn-success\"></td></tr><tbody>";
	echo "</table></div></div>";

	}
}
}


if(isset($_POST["update"]))
{
	$sty=$_POST["sty"];
	$sch=$_POST["sch"];
	$col=$_POST["col"];
	$ext=$_POST["ext"];
	$ord_joins=$_POST["order_join"];

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
	$code="";
	for($ij=0;$ij<sizeof($sizes_array);$ij++)
	{
		$code_new = "".$sizes_array[$ij]."_new";
		if($$code_new=='')
		{
			$$code_new=0;
		}
	}	
	
	if($ord_joins<>'0')
	{
		if(strlen($ord_joins)<4)
		{
			$status_col="Color-".str_replace("J","",$ord_joins)."";
			$code="";
			$code1="";
			for($ij=0;$ij<sizeof($sizes_array);$ij++)
			{
				$code_old = "".$sizes_array[$ij]."_old";
				$code_new = "".$sizes_array[$ij]."_new";
				$code .= "order_s_".$sizes_array[$ij]."=(order_s_".$sizes_array[$ij]."+(".$$code_new."-".$$code_old.")),";
				$code1 .= "old_order_s_".$sizes_array[$ij]."=order_s_".$sizes_array[$ij].",";
			}
			$query_code= rtrim($code,',');
			$sql_check="select * from $bai_pro3.bai_orders_db_confirm where order_no=1 and order_style_no='".$sty."' and order_del_no=\"$sch\" and order_col_des='".$status_col."'";
			$res=mysqli_query($link, $sql_check);
			if(mysqli_num_rows($res)>0)
			{
				$code1="";
			}
			$update_club="update $bai_pro3.bai_orders_db_confirm set order_no=1,$code1 $query_code where order_style_no='".$sty."' and order_del_no=\"$sch\" and order_col_des='".$status_col."'";
			//echo $update_club."<br>";
			mysqli_query($link, $update_club);
			$update_club1="update $bai_pro3.bai_orders_db set order_no=1,$code1 $query_code where order_style_no='".$sty."' and order_del_no=\"$sch\" and order_col_des='".$status_col."'";
			//echo $update_club."<br>";
			mysqli_query($link, $update_club1);
		}
		else
		{
			$status_sch=str_replace("J","",$ord_joins);
			$code="";
			$code1="";
			for($ij=0;$ij<sizeof($sizes_array);$ij++)
			{
				$code_old = "".$sizes_array[$ij]."_old";
				$code_new = "".$sizes_array[$ij]."_new";
				$code .= "order_s_".$sizes_array[$ij]."=(order_s_".$sizes_array[$ij]."+(".$$code_new."-".$$code_old.")),";
				$code1 .= "old_order_s_".$sizes_array[$ij]."=order_s_".$sizes_array[$ij].",";
			}
			$query_code= rtrim($code,',');
			$sql_check="select * from $bai_pro3.bai_orders_db_confirm where order_no=1 and order_style_no='".$sty."' and order_del_no=\"$sch\" and order_col_des='".$status_col."'";
			$res=mysqli_query($link, $sql_check);
			if(mysqli_num_rows($res)>0)
			{
				$code1="";
			}
			$update_club="update $bai_pro3.bai_orders_db_confirm set order_no=1,$code1 $query_code where order_style_no='".$sty."' and order_del_no=\"$status_sch\" and order_col_des='".$col."'";
			//echo $update_club."<br>";
			mysqli_query($link, $update_club);

			$update_club1="update $bai_pro3.bai_orders_db set order_no=1,$code1 $query_code where order_style_no='".$sty."' and order_del_no=\"$status_sch\" and order_col_des='".$col."'";
			//echo $update_club."<br>";
			mysqli_query($link, $update_club1);
		}
		$update1="update $bai_pro3.bai_orders_db set order_no=\"1\" where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$col\"";
		mysqli_query($link, $update1);
		
		$update="update $bai_pro3.bai_orders_db_confirm set order_no=\"1\",old_order_s_s01=\"$s01_old\",old_order_s_s02=\"$s02_old\",old_order_s_s03=\"$s03_old\",old_order_s_s04=\"$s04_old\",old_order_s_s05=\"$s05_old\",old_order_s_s06=\"$s06_old\",old_order_s_s07=\"$s07_old\",old_order_s_s08=\"$s08_old\",old_order_s_s09=\"$s09_old\",old_order_s_s10=\"$s10_old\",old_order_s_s11=\"$s11_old\",old_order_s_s12=\"$s12_old\",old_order_s_s13=\"$s13_old\",old_order_s_s14=\"$s14_old\",old_order_s_s15=\"$s15_old\",old_order_s_s16=\"$s16_old\",old_order_s_s17=\"$s17_old\",old_order_s_s18=\"$s18_old\",old_order_s_s19=\"$s19_old\",old_order_s_s20=\"$s20_old\",old_order_s_s21=\"$s21_old\",old_order_s_s22=\"$s22_old\",old_order_s_s23=\"$s23_old\",old_order_s_s24=\"$s24_old\",old_order_s_s25=\"$s25_old\",old_order_s_s26=\"$s26_old\",old_order_s_s27=\"$s27_old\",old_order_s_s28=\"$s28_old\",old_order_s_s29=\"$s29_old\",old_order_s_s30=\"$s30_old\",old_order_s_s31=\"$s31_old\",old_order_s_s32=\"$s32_old\",old_order_s_s33=\"$s33_old\",old_order_s_s34=\"$s34_old\",old_order_s_s35=\"$s35_old\",old_order_s_s36=\"$s36_old\",old_order_s_s37=\"$s37_old\",old_order_s_s38=\"$s38_old\",old_order_s_s39=\"$s39_old\",old_order_s_s40=\"$s40_old\",old_order_s_s41=\"$s41_old\",old_order_s_s42=\"$s42_old\",old_order_s_s43=\"$s43_old\",old_order_s_s44=\"$s44_old\",old_order_s_s45=\"$s45_old\",old_order_s_s46=\"$s46_old\",old_order_s_s47=\"$s47_old\",old_order_s_s48=\"$s48_old\",old_order_s_s49=\"$s49_old\",old_order_s_s50=\"$s50_old\",order_s_s01=\"$s01_new\",order_s_s02=\"$s02_new\",order_s_s03=\"$s03_new\",order_s_s04=\"$s04_new\",order_s_s05=\"$s05_new\",order_s_s06=\"$s06_new\",order_s_s07=\"$s07_new\",order_s_s08=\"$s08_new\",order_s_s09=\"$s09_new\",order_s_s10=\"$s10_new\",order_s_s11=\"$s11_new\",order_s_s12=\"$s12_new\",order_s_s13=\"$s13_new\",order_s_s14=\"$s14_new\",order_s_s15=\"$s15_new\",order_s_s16=\"$s16_new\",order_s_s17=\"$s17_new\",order_s_s18=\"$s18_new\",order_s_s19=\"$s19_new\",order_s_s20=\"$s20_new\",order_s_s21=\"$s21_new\",order_s_s22=\"$s22_new\",order_s_s23=\"$s23_new\",order_s_s24=\"$s24_new\",order_s_s25=\"$s25_new\",order_s_s26=\"$s26_new\",order_s_s27=\"$s27_new\",order_s_s28=\"$s28_new\",order_s_s29=\"$s29_new\",order_s_s30=\"$s30_new\",order_s_s31=\"$s31_new\",order_s_s32=\"$s32_new\",order_s_s33=\"$s33_new\",order_s_s34=\"$s34_new\",order_s_s35=\"$s35_new\",order_s_s36=\"$s36_new\",order_s_s37=\"$s37_new\",order_s_s38=\"$s38_new\",order_s_s39=\"$s39_new\",order_s_s40=\"$s40_new\",order_s_s41=\"$s41_new\",order_s_s42=\"$s42_new\",order_s_s43=\"$s43_new\",order_s_s44=\"$s44_new\",order_s_s45=\"$s45_new\",order_s_s46=\"$s46_new\",order_s_s47=\"$s47_new\",order_s_s48=\"$s48_new\",order_s_s49=\"$s49_new\",order_s_s50=\"$s50_new\" where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$col\"";
		//echo $update."<br>";
		mysqli_query($link, $update);
		$delete="DELETE FROM $bai_pro3.bai_orders_db_club_confirm where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$col\"";
		//echo $delete."<br>";
		mysqli_query($link, $delete);
		$insert="insert into $bai_pro3.bai_orders_db_club_confirm (select * from bai_orders_db_confirm where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$col\")";
		//echo $insert."<br>";
		//die();
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
	else
	{		
		$update="update $bai_pro3.bai_orders_db set order_no=\"1\",old_order_s_s01=\"$s01_old\",old_order_s_s02=\"$s02_old\",old_order_s_s03=\"$s03_old\",old_order_s_s04=\"$s04_old\",old_order_s_s05=\"$s05_old\",old_order_s_s06=\"$s06_old\",old_order_s_s07=\"$s07_old\",old_order_s_s08=\"$s08_old\",old_order_s_s09=\"$s09_old\",old_order_s_s10=\"$s10_old\",old_order_s_s11=\"$s11_old\",old_order_s_s12=\"$s12_old\",old_order_s_s13=\"$s13_old\",old_order_s_s14=\"$s14_old\",old_order_s_s15=\"$s15_old\",old_order_s_s16=\"$s16_old\",old_order_s_s17=\"$s17_old\",old_order_s_s18=\"$s18_old\",old_order_s_s19=\"$s19_old\",old_order_s_s20=\"$s20_old\",old_order_s_s21=\"$s21_old\",old_order_s_s22=\"$s22_old\",old_order_s_s23=\"$s23_old\",old_order_s_s24=\"$s24_old\",old_order_s_s25=\"$s25_old\",old_order_s_s26=\"$s26_old\",old_order_s_s27=\"$s27_old\",old_order_s_s28=\"$s28_old\",old_order_s_s29=\"$s29_old\",old_order_s_s30=\"$s30_old\",old_order_s_s31=\"$s31_old\",old_order_s_s32=\"$s32_old\",old_order_s_s33=\"$s33_old\",old_order_s_s34=\"$s34_old\",old_order_s_s35=\"$s35_old\",old_order_s_s36=\"$s36_old\",old_order_s_s37=\"$s37_old\",old_order_s_s38=\"$s38_old\",old_order_s_s39=\"$s39_old\",old_order_s_s40=\"$s40_old\",old_order_s_s41=\"$s41_old\",old_order_s_s42=\"$s42_old\",old_order_s_s43=\"$s43_old\",old_order_s_s44=\"$s44_old\",old_order_s_s45=\"$s45_old\",old_order_s_s46=\"$s46_old\",old_order_s_s47=\"$s47_old\",old_order_s_s48=\"$s48_old\",old_order_s_s49=\"$s49_old\",old_order_s_s50=\"$s50_old\",order_s_s01=\"$s01_new\",order_s_s02=\"$s02_new\",order_s_s03=\"$s03_new\",order_s_s04=\"$s04_new\",order_s_s05=\"$s05_new\",order_s_s06=\"$s06_new\",order_s_s07=\"$s07_new\",order_s_s08=\"$s08_new\",order_s_s09=\"$s09_new\",order_s_s10=\"$s10_new\",order_s_s11=\"$s11_new\",order_s_s12=\"$s12_new\",order_s_s13=\"$s13_new\",order_s_s14=\"$s14_new\",order_s_s15=\"$s15_new\",order_s_s16=\"$s16_new\",order_s_s17=\"$s17_new\",order_s_s18=\"$s18_new\",order_s_s19=\"$s19_new\",order_s_s20=\"$s20_new\",order_s_s21=\"$s21_new\",order_s_s22=\"$s22_new\",order_s_s23=\"$s23_new\",order_s_s24=\"$s24_new\",order_s_s25=\"$s25_new\",order_s_s26=\"$s26_new\",order_s_s27=\"$s27_new\",order_s_s28=\"$s28_new\",order_s_s29=\"$s29_new\",order_s_s30=\"$s30_new\",order_s_s31=\"$s31_new\",order_s_s32=\"$s32_new\",order_s_s33=\"$s33_new\",order_s_s34=\"$s34_new\",order_s_s35=\"$s35_new\",order_s_s36=\"$s36_new\",order_s_s37=\"$s37_new\",order_s_s38=\"$s38_new\",order_s_s39=\"$s39_new\",order_s_s40=\"$s40_new\",order_s_s41=\"$s41_new\",order_s_s42=\"$s42_new\",order_s_s43=\"$s43_new\",order_s_s44=\"$s44_new\",order_s_s45=\"$s45_new\",order_s_s46=\"$s46_new\",order_s_s47=\"$s47_new\",order_s_s48=\"$s48_new\",order_s_s49=\"$s49_new\",order_s_s50=\"$s50_new\" where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$col\"";
		//echo $update."<br>";
		mysqli_query($link, $update);
		$insert="insert into $bai_pro3.bai_orders_db_confirm (select * from bai_orders_db where order_style_no=\"$sty\" and order_del_no=\"$sch\" and order_col_des=\"$col\")";
		//echo $insert."<br>";
		//die();
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

}

?> 
</form> 
</div>
</div>
</div>
<?php

	
?>
	</div>
</div>
</div>







<?php	
	// $email_header="<html><head><style>
		// body
		// {
			// font-family: Trebuchet MS;
			// font-size: 12px;
		// }
		
		// table
		// {
		// border-collapse:collapse;
		// white-space:nowrap;
		// tr.total
		// {
		// font-weight: bold;
		// white-space:nowrap; 
		// }
		
		// table
		// {
		// border-collapse:collapse;
		// white-space:nowrap;
		// font-size: 12pt; 
		// }
		// }
		
		// th
		// {
			// background-color: RED;
			// color: WHITE;
		// border: 1px solid #660000;
			// padding: 10px;
		// white-space:nowrap; 
		
		// }
		
		// td
		// {
			// background-color: WHITE;
			// color: BLACK;
		// border: 1px solid #660000;
			// padding: 1px;
		// white-space:nowrap; 
		// }
		
		// td.date
		// {
			// background-color: WHITE;
			// color: BLACK;
		// border: 1px solid #660000;
			// padding: 5px;
		// white-space:nowrap;
		// text-align:center;
		// }
		
		
		// td.style
		// {
			// background-color: YELLOW;
			// color: BLACK;
		// border: 1px solid #660000;
			// padding: 2px;
		// white-space:nowrap; 
		// font-weight: bold;
		// }
		// </style></head><body>";
	// $email_footer="</body></html>";
	
	
	// function send_email1($from, $to, $bcc, $subject1, $message1)
	// {
		// $headers  = 'MIME-Version: 1.0' . "\r\n";
		// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// $headers .= "From: BAI-PRO <".$from.">\r\n";
		// $headers .= "Reply-To: ".$from."\r\n";
		// $headers .= "Return-Path: ".$from."\r\n";
		//$headers .= "CC: ".$cc."\r\n"
		// $headers .= "BCC: ".$to."\r\n";
						
		// if (mail($to,$subject1,$message1,$headers) ) 
		// {  		
			// echo "<h2 align='center'>Email Successfully sent</h2>";	
		// } 
		// else 
	    // {				
			// echo "<h2 align='center'>Email could not be sent</h2>";			
		// }									
	// }
					
	// $subject1 = $plant_alert_code."Order Quantity Amendments of $sch on ".date("Y-m-d H:i:s")."";
																	
	// $message1 =$email_header;
									
	// $message1 .= "Dear All,</BR></BR> Sunny added ".$ext."% extra quantity to $sch schedule Order Qty.<br><br> ";
	
	// $message1 .= "<table><tr><th>Size</th><th>New Order Qty</th><th>Old Order Qty</th></tr><tr><td>XS</td><td>$xs_new</td><td>$xs_old</td></tr><tr><td>S</td><td>$s_new</td><td>$s_old</td></tr><tr><td>M</td><td>$m_new</td><td>$m_old</td><tr><td>L</td><td>$l_new</td><td>$l_old</td></tr><tr><td>XL</td><td>$xl_new</td><td>$xl_old</td></tr><tr><td>XXL</td><td>$xxl_new</td><td>$xxl_old</td></tr><tr><td>XXXL</td><td>$xxxl_new</td><td>$xxxl_old</td></tr></table>";
											
	
	
										
	// $message1 .=$email_footer;		
											
	// send_email1("baiict@brandix.com",$order_quantity_mail,"",$subject1,$message1);
//}

?>
