<?php  

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));; 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );
include("../".getFullURLLevel($_GET['r'], "common/config/group_def.php", 3, "R"));
$view_access=user_acl("SFCS_0036",$username,1,$group_id_sfcs);
$aut_users=user_acl("SFCS_0036",$username,7,$group_id_sfcs);
?>

<style>
td,th{
	color : #000;
}
</style>



<script>

function firstbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>&style="+document.input.style.value
}

function secondbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>&style="+document.input.style.value+"&schedule="+document.input.schedule.value
}

function thirdbox()
{
	window.location.href ="index.php?r=<?php echo $_GET['r'] ?>&style="+document.input.style.value+"&schedule="+document.input.schedule.value+"&color="+document.input.color.value
}
</script>

<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>M3 Offline Dispatch Reporting</b>
	</div>
	<div class='panel-body'>
		<form name="input" method="post" action="?r=<?php echo $_GET['r']; ?>">
			<?php
			$username_list=explode('\\',$_SERVER['REMOTE_USER']);
			$username=strtolower($username_list[1]);

			$author_id_db=array("kirang");
			if(in_array($username,$author_id_db))
			{
				//echo '| <strong><a href="cut_to_ship3.php">Current Week Process</a></strong> | <strong> <a href="cut_to_ship33.php">Previous Week Process</a> </strong>';
			}
			?>
			<?php
			if(isset($_POST['filter2']))
			{
				$style=$_POST['style'];
				$schedule=$_POST['schedule']; 
				$color=$_POST['color'];
			}
			else
			{
				$style=$_GET['style'];
				$schedule=$_GET['schedule']; 
				$color=$_GET['color'];
			}
			?>

			<?php
			echo "<div class='col-sm-3 form-group'>";
			echo "<label for='style'>Select Style </label>
				  <select class='form-control' name=\"style\" onchange=\"firstbox();\" >";

			//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log)";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm order by order_style_no";	
			//}
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			echo "<option value=\"NIL\" selected>NIL</option>";
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

			echo "</select>
			</div>";
			?>

			<?php
		    echo "<div class='col-sm-3 form-group'>";
			echo "<label for='schedule'>Select Schedule</label>
				  <select class='form-control' name=\"schedule\" onchange=\"secondbox();\" >";

			//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" order by order_del_no";	
				//echo $sql;
			//}
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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


			echo "</select>
			</div>";
			?>

			<?php
			echo "<div class='col-sm-3 form-group'>";
			echo "<label for='color'>Select Color</label>
				  <select class='form-control' name=\"color\" onchange=\"thirdbox();\" >";

			//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			//}
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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


			echo "</select>
			</div>";

			echo '<span id="msg" style="display:none; color:blue;">Please Wait...</span>';
			echo "<div class='col-sm-3'><br>
				  	<input class='btn btn-success' disabled id='show' type=\"submit\" value=\"Show\" name=\"filter2\" onclick=\"document.getElementById('filter2').style.display='none'; document.getElementById('msg').style.display='';\">
				  ";
			$report_url = getFullURL($_GET['r'],'index.php', 'N');	  
			echo " 	<a class='btn btn-warning' href='$report_url'> Report</a>
				  </div>";
			?>
		</form>
		<br>
		<br>


<?php

if(isset($_POST['submit_new'])){


$style=$_POST['style'];
$schedule=$_POST['schedule'];
$color=$_POST['color'];
$size=$_POST['size'];
$order_qty=$_POST['order_qty'];
$cut_qty=$_POST['cut_qty'];
$input_qty=$_POST['input_qty'];
$out_qty=$_POST['out_qty'];
$fg_qty=$_POST['fg_qty'];
$fca_qty=$_POST['fca_qty'];
$ship_qty=$_POST['ship_qty'];
$exist_report_qty=$_POST['exist_report_qty'];
$report_qty=$_POST['report_qty'];

//print_r($size);
for($i=0;$i<sizeof($size);$i++){
	if($report_qty[$i]>0){
		$sql="insert into $bai_pro3.m3_offline_dispatch(style,schedule,color,size,order_qty,cut_qty,input_qty,out_qty,fg_qty,fca_qty,ship_qty,report_qty,exist_report_qty,log_user) values ('".$style[$i]."','".$schedule[$i]."','".$color[$i]."','".$size[$i]."',".$order_qty[$i].",".$cut_qty[$i].",".$input_qty[$i].",".$out_qty[$i].",".$fg_qty[$i].",".$fca_qty[$i].",".$ship_qty[$i].",".$report_qty[$i].",".$exist_report_qty[$i].",'$username')";
		//echo $sql;
		$status = mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
	}	
	if($status){
		echo "<script>sweetAlert('Updated Successfully','','success')</script>";
	}
}

	
}

?>


<?php


if(isset($_POST['filter']) or isset($_POST['filter2']))
{
	$row_count = 0;
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	echo "<form name='test' method='post' action='?r=".$_GET['r']."'>";
	echo "<div class='table-responsive' style='overflow: auto;max-height : 600px'>";
	echo "<table class='table table-bordered'>";
	echo "<tr class='danger'>
	<th>Division</th>
	<th>FG Status</th>
	<th>Ex-Factory</th>
	<th>Style</th>
	<th>Schedule</th>
	<th>Color</th>
	<th>Section</th>
	<th>Size</th>
	<th>M3 Order <br/>Quantity</th>
	<th>Total Order <br/>Quantity</th>
	<th>Total Cut <br/>Quantity</th>
	<th>Total Input <br/>Quantity</th>
	<th>Total Sewing Out <br/>Quantity</th>
	<th>Total FG <br/>Quantity</th>
	<th>Total FCA <br/>Quantity</th>";
	//echo "<th>Total MCA <br/>Quantity</th>";
	
	echo "<th>Total Shipped <br/>Quantity</th>";
	echo "<th>M3 Confirmed Sofar</th>";
	echo "<th>Report Qty</th>";
	/*echo "<th>Rejected <br/>Quantity</th>
	<th>Sample <br/>Quantity</th>
	<th>Good Panel <br/>Quantity</th>
	<th>Out of Ratio <br/>Quantity</th>
	<th>Total Missing<br/>Panels</th>
	<th class=\"total\">Sewing <br/>Missing</th>
	<th class=\"total\">Panel Room <br/>Missing</th>
	<th class=\"total\">Cutting <br/>Missing</th>"; */
echo "</tr>";
	
	if(isset($_POST['filter2']))
	{
		$sch_db=$_POST['schedule'];
		$sql="select style,schedule_no,color,ssc_code_new,priority,buyer_division,ex_factory_date_new,sections from $bai_pro4.bai_cut_to_ship_ref where schedule_no=\"$sch_db\" and trim(color)=\"$color\" order by ex_factory_date_new limit 1";
		//echo $sql;
	}
	else
	{
		$sql="select style,schedule_no,color,ssc_code_new,priority,buyer_division,ex_factory_date_new,sections from $bai_pro4.bai_cut_to_ship_ref where ex_factory_date_new between \"$sdate\" and \"$edate\" order by ex_factory_date_new";
	}
	//echo $sql;	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if(mysqli_num_rows($sql_result)==0){
		$sql="select order_style_no as style,order_del_no as schedule_no,order_col_des as color,order_tid as ssc_code_new,priority,order_div as buyer_division from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$sch_db\" and trim(order_col_des)=\"$color\" limit 1";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	while($sql_row=mysqli_fetch_array($sql_result))
	{
			$status=$sql_row['priority'];
			$ssc_code_new=$sql_row['ssc_code_new'];
			$order_qtys=array();
			$old_order_qtys=array();
			$out_qtys=array();
			
			$sizes_db=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");
			
			$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$sql_row['style']."\" and order_del_no=\"".$sql_row['schedule_no']."\" and order_col_des=\"".$sql_row['color']."\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$order_qtys[]=$sql_row1['order_s_xs'];
				$order_qtys[]=$sql_row1['order_s_s'];
				$order_qtys[]=$sql_row1['order_s_m'];
				$order_qtys[]=$sql_row1['order_s_l'];
				$order_qtys[]=$sql_row1['order_s_xl'];
				$order_qtys[]=$sql_row1['order_s_xxl'];
				$order_qtys[]=$sql_row1['order_s_xxxl'];
				$order_qtys[]=$sql_row1['order_s_s01'];
				$order_qtys[]=$sql_row1['order_s_s02'];
				$order_qtys[]=$sql_row1['order_s_s03'];
				$order_qtys[]=$sql_row1['order_s_s04'];
				$order_qtys[]=$sql_row1['order_s_s05'];
				$order_qtys[]=$sql_row1['order_s_s06'];
				$order_qtys[]=$sql_row1['order_s_s07'];
				$order_qtys[]=$sql_row1['order_s_s08'];
				$order_qtys[]=$sql_row1['order_s_s09'];
				$order_qtys[]=$sql_row1['order_s_s10'];
				$order_qtys[]=$sql_row1['order_s_s11'];
				$order_qtys[]=$sql_row1['order_s_s12'];
				$order_qtys[]=$sql_row1['order_s_s13'];
				$order_qtys[]=$sql_row1['order_s_s14'];
				$order_qtys[]=$sql_row1['order_s_s15'];
				$order_qtys[]=$sql_row1['order_s_s16'];
				$order_qtys[]=$sql_row1['order_s_s17'];
				$order_qtys[]=$sql_row1['order_s_s18'];
				$order_qtys[]=$sql_row1['order_s_s19'];
				$order_qtys[]=$sql_row1['order_s_s20'];
				$order_qtys[]=$sql_row1['order_s_s21'];
				$order_qtys[]=$sql_row1['order_s_s22'];
				$order_qtys[]=$sql_row1['order_s_s23'];
				$order_qtys[]=$sql_row1['order_s_s24'];
				$order_qtys[]=$sql_row1['order_s_s25'];
				$order_qtys[]=$sql_row1['order_s_s26'];
				$order_qtys[]=$sql_row1['order_s_s27'];
				$order_qtys[]=$sql_row1['order_s_s28'];
				$order_qtys[]=$sql_row1['order_s_s29'];
				$order_qtys[]=$sql_row1['order_s_s30'];
				$order_qtys[]=$sql_row1['order_s_s31'];
				$order_qtys[]=$sql_row1['order_s_s32'];
				$order_qtys[]=$sql_row1['order_s_s33'];
				$order_qtys[]=$sql_row1['order_s_s34'];
				$order_qtys[]=$sql_row1['order_s_s35'];
				$order_qtys[]=$sql_row1['order_s_s36'];
				$order_qtys[]=$sql_row1['order_s_s37'];
				$order_qtys[]=$sql_row1['order_s_s38'];
				$order_qtys[]=$sql_row1['order_s_s39'];
				$order_qtys[]=$sql_row1['order_s_s40'];
				$order_qtys[]=$sql_row1['order_s_s41'];
				$order_qtys[]=$sql_row1['order_s_s42'];
				$order_qtys[]=$sql_row1['order_s_s43'];
				$order_qtys[]=$sql_row1['order_s_s44'];
				$order_qtys[]=$sql_row1['order_s_s45'];
				$order_qtys[]=$sql_row1['order_s_s46'];
				$order_qtys[]=$sql_row1['order_s_s47'];
				$order_qtys[]=$sql_row1['order_s_s48'];
				$order_qtys[]=$sql_row1['order_s_s49'];
				$order_qtys[]=$sql_row1['order_s_s50'];
				$old_order_qtys[]=$sql_row1['old_order_s_xs'];
				$old_order_qtys[]=$sql_row1['old_order_s_s'];
				$old_order_qtys[]=$sql_row1['old_order_s_m'];
				$old_order_qtys[]=$sql_row1['old_order_s_l'];
				$old_order_qtys[]=$sql_row1['old_order_s_xl'];
				$old_order_qtys[]=$sql_row1['old_order_s_xxl'];
				$old_order_qtys[]=$sql_row1['old_order_s_xxxl'];
				$old_order_qtys[]=$sql_row1['old_order_s_s01'];
				$old_order_qtys[]=$sql_row1['old_order_s_s02'];
				$old_order_qtys[]=$sql_row1['old_order_s_s03'];
				$old_order_qtys[]=$sql_row1['old_order_s_s04'];
				$old_order_qtys[]=$sql_row1['old_order_s_s05'];
				$old_order_qtys[]=$sql_row1['old_order_s_s06'];
				$old_order_qtys[]=$sql_row1['old_order_s_s07'];
				$old_order_qtys[]=$sql_row1['old_order_s_s08'];
				$old_order_qtys[]=$sql_row1['old_order_s_s09'];
				$old_order_qtys[]=$sql_row1['old_order_s_s10'];
				$old_order_qtys[]=$sql_row1['old_order_s_s11'];
				$old_order_qtys[]=$sql_row1['old_order_s_s12'];
				$old_order_qtys[]=$sql_row1['old_order_s_s13'];
				$old_order_qtys[]=$sql_row1['old_order_s_s14'];
				$old_order_qtys[]=$sql_row1['old_order_s_s15'];
				$old_order_qtys[]=$sql_row1['old_order_s_s16'];
				$old_order_qtys[]=$sql_row1['old_order_s_s17'];
				$old_order_qtys[]=$sql_row1['old_order_s_s18'];
				$old_order_qtys[]=$sql_row1['old_order_s_s19'];
				$old_order_qtys[]=$sql_row1['old_order_s_s20'];
				$old_order_qtys[]=$sql_row1['old_order_s_s21'];
				$old_order_qtys[]=$sql_row1['old_order_s_s22'];
				$old_order_qtys[]=$sql_row1['old_order_s_s23'];
				$old_order_qtys[]=$sql_row1['old_order_s_s24'];
				$old_order_qtys[]=$sql_row1['old_order_s_s25'];
				$old_order_qtys[]=$sql_row1['old_order_s_s26'];
				$old_order_qtys[]=$sql_row1['old_order_s_s27'];
				$old_order_qtys[]=$sql_row1['old_order_s_s28'];
				$old_order_qtys[]=$sql_row1['old_order_s_s29'];
				$old_order_qtys[]=$sql_row1['old_order_s_s30'];
				$old_order_qtys[]=$sql_row1['old_order_s_s31'];
				$old_order_qtys[]=$sql_row1['old_order_s_s32'];
				$old_order_qtys[]=$sql_row1['old_order_s_s33'];
				$old_order_qtys[]=$sql_row1['old_order_s_s34'];
				$old_order_qtys[]=$sql_row1['old_order_s_s35'];
				$old_order_qtys[]=$sql_row1['old_order_s_s36'];
				$old_order_qtys[]=$sql_row1['old_order_s_s37'];
				$old_order_qtys[]=$sql_row1['old_order_s_s38'];
				$old_order_qtys[]=$sql_row1['old_order_s_s39'];
				$old_order_qtys[]=$sql_row1['old_order_s_s40'];
				$old_order_qtys[]=$sql_row1['old_order_s_s41'];
				$old_order_qtys[]=$sql_row1['old_order_s_s42'];
				$old_order_qtys[]=$sql_row1['old_order_s_s43'];
				$old_order_qtys[]=$sql_row1['old_order_s_s44'];
				$old_order_qtys[]=$sql_row1['old_order_s_s45'];
				$old_order_qtys[]=$sql_row1['old_order_s_s46'];
				$old_order_qtys[]=$sql_row1['old_order_s_s47'];
				$old_order_qtys[]=$sql_row1['old_order_s_s48'];
				$old_order_qtys[]=$sql_row1['old_order_s_s49'];
				$old_order_qtys[]=$sql_row1['old_order_s_s50'];

				$order_tid=$sql_row1['order_tid'];
				$schedule=$sql_row1['order_del_no'];
				$color=$sql_row1['order_col_des'];
			}
			
			
			$sql2="select bac_sec, coalesce(sum(bac_Qty),0) as \"qty\", coalesce(sum(size_xs),0) as \"size_xs\", coalesce(sum(size_s),0) as \"size_s\", coalesce(sum(size_m),0) as \"size_m\", coalesce(sum(size_l),0) as \"size_l\", coalesce(sum(size_xl),0) as \"size_xl\", coalesce(sum(size_xxl),0) as \"size_xxl\", coalesce(sum(size_xxxl),0) as \"size_xxxl\", coalesce(sum(size_s01),0) as \"size_s01\", coalesce(sum(size_s02),0) as \"size_s02\", coalesce(sum(size_s03),0) as \"size_s03\", coalesce(sum(size_s04),0) as \"size_s04\", coalesce(sum(size_s05),0) as \"size_s05\", coalesce(sum(size_s06),0) as \"size_s06\", coalesce(sum(size_s07),0) as \"size_s07\", coalesce(sum(size_s08),0) as \"size_s08\", coalesce(sum(size_s09),0) as \"size_s09\", coalesce(sum(size_s10),0) as \"size_s10\", coalesce(sum(size_s11),0) as \"size_s11\", coalesce(sum(size_s12),0) as \"size_s12\", coalesce(sum(size_s13),0) as \"size_s13\", coalesce(sum(size_s14),0) as \"size_s14\", coalesce(sum(size_s15),0) as \"size_s15\", coalesce(sum(size_s16),0) as \"size_s16\", coalesce(sum(size_s17),0) as \"size_s17\", coalesce(sum(size_s18),0) as \"size_s18\", coalesce(sum(size_s19),0) as \"size_s19\", coalesce(sum(size_s20),0) as \"size_s20\", coalesce(sum(size_s21),0) as \"size_s21\", coalesce(sum(size_s22),0) as \"size_s22\", coalesce(sum(size_s23),0) as \"size_s23\", coalesce(sum(size_s24),0) as \"size_s24\", coalesce(sum(size_s25),0) as \"size_s25\", coalesce(sum(size_s26),0) as \"size_s26\", coalesce(sum(size_s27),0) as \"size_s27\", coalesce(sum(size_s28),0) as \"size_s28\", coalesce(sum(size_s29),0) as \"size_s29\", coalesce(sum(size_s30),0) as \"size_s30\", coalesce(sum(size_s31),0) as \"size_s31\", coalesce(sum(size_s32),0) as \"size_s32\", coalesce(sum(size_s33),0) as \"size_s33\", coalesce(sum(size_s34),0) as \"size_s34\", coalesce(sum(size_s35),0) as \"size_s35\", coalesce(sum(size_s36),0) as \"size_s36\", coalesce(sum(size_s37),0) as \"size_s37\", coalesce(sum(size_s38),0) as \"size_s38\", coalesce(sum(size_s39),0) as \"size_s39\", coalesce(sum(size_s40),0) as \"size_s40\", coalesce(sum(size_s41),0) as \"size_s41\", coalesce(sum(size_s42),0) as \"size_s42\", coalesce(sum(size_s43),0) as \"size_s43\", coalesce(sum(size_s44),0) as \"size_s44\", coalesce(sum(size_s45),0) as \"size_s45\", coalesce(sum(size_s46),0) as \"size_s46\", coalesce(sum(size_s47),0) as \"size_s47\", coalesce(sum(size_s48),0) as \"size_s48\", coalesce(sum(size_s49),0) as \"size_s49\", coalesce(sum(size_s50),0) as \"size_s50\" from $bai_pro.bai_log_buf where delivery=\"".$sql_row['schedule_no']."\" and color=\"".$color."\"";
			//echo $sql2."<br/>";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$out_qtys[]=$sql_row2['size_xs'];
				$out_qtys[]=$sql_row2['size_s'];
				$out_qtys[]=$sql_row2['size_m'];
				$out_qtys[]=$sql_row2['size_l'];
				$out_qtys[]=$sql_row2['size_xl'];
				$out_qtys[]=$sql_row2['size_xxl'];
				$out_qtys[]=$sql_row2['size_xxxl'];
				$out_qtys[]=$sql_row2['size_s01'];
				$out_qtys[]=$sql_row2['size_s02'];
				$out_qtys[]=$sql_row2['size_s03'];
				$out_qtys[]=$sql_row2['size_s04'];
				$out_qtys[]=$sql_row2['size_s05'];
				$out_qtys[]=$sql_row2['size_s06'];
				$out_qtys[]=$sql_row2['size_s07'];
				$out_qtys[]=$sql_row2['size_s08'];
				$out_qtys[]=$sql_row2['size_s09'];
				$out_qtys[]=$sql_row2['size_s10'];
				$out_qtys[]=$sql_row2['size_s11'];
				$out_qtys[]=$sql_row2['size_s12'];
				$out_qtys[]=$sql_row2['size_s13'];
				$out_qtys[]=$sql_row2['size_s14'];
				$out_qtys[]=$sql_row2['size_s15'];
				$out_qtys[]=$sql_row2['size_s16'];
				$out_qtys[]=$sql_row2['size_s17'];
				$out_qtys[]=$sql_row2['size_s18'];
				$out_qtys[]=$sql_row2['size_s19'];
				$out_qtys[]=$sql_row2['size_s20'];
				$out_qtys[]=$sql_row2['size_s21'];
				$out_qtys[]=$sql_row2['size_s22'];
				$out_qtys[]=$sql_row2['size_s23'];
				$out_qtys[]=$sql_row2['size_s24'];
				$out_qtys[]=$sql_row2['size_s25'];
				$out_qtys[]=$sql_row2['size_s26'];
				$out_qtys[]=$sql_row2['size_s27'];
				$out_qtys[]=$sql_row2['size_s28'];
				$out_qtys[]=$sql_row2['size_s29'];
				$out_qtys[]=$sql_row2['size_s30'];
				$out_qtys[]=$sql_row2['size_s31'];
				$out_qtys[]=$sql_row2['size_s32'];
				$out_qtys[]=$sql_row2['size_s33'];
				$out_qtys[]=$sql_row2['size_s34'];
				$out_qtys[]=$sql_row2['size_s35'];
				$out_qtys[]=$sql_row2['size_s36'];
				$out_qtys[]=$sql_row2['size_s37'];
				$out_qtys[]=$sql_row2['size_s38'];
				$out_qtys[]=$sql_row2['size_s39'];
				$out_qtys[]=$sql_row2['size_s40'];
				$out_qtys[]=$sql_row2['size_s41'];
				$out_qtys[]=$sql_row2['size_s42'];
				$out_qtys[]=$sql_row2['size_s43'];
				$out_qtys[]=$sql_row2['size_s44'];
				$out_qtys[]=$sql_row2['size_s45'];
				$out_qtys[]=$sql_row2['size_s46'];
				$out_qtys[]=$sql_row2['size_s47'];
				$out_qtys[]=$sql_row2['size_s48'];
				$out_qtys[]=$sql_row2['size_s49'];
				$out_qtys[]=$sql_row2['size_s50'];
			}
			

			$recut_qty_db=array();
			$recut_req_db=array();
			
			
			
			$sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s01*a_plies),0) as \"a_s01\", coalesce(sum(a_s02*a_plies),0) as \"a_s02\", coalesce(sum(a_s03*a_plies),0) as \"a_s03\", coalesce(sum(a_s04*a_plies),0) as \"a_s04\", coalesce(sum(a_s05*a_plies),0) as \"a_s05\", coalesce(sum(a_s06*a_plies),0) as \"a_s06\", coalesce(sum(a_s07*a_plies),0) as \"a_s07\", coalesce(sum(a_s08*a_plies),0) as \"a_s08\", coalesce(sum(a_s09*a_plies),0) as \"a_s09\", coalesce(sum(a_s10*a_plies),0) as \"a_s10\", coalesce(sum(a_s11*a_plies),0) as \"a_s11\", coalesce(sum(a_s12*a_plies),0) as \"a_s12\", coalesce(sum(a_s13*a_plies),0) as \"a_s13\", coalesce(sum(a_s14*a_plies),0) as \"a_s14\", coalesce(sum(a_s15*a_plies),0) as \"a_s15\", coalesce(sum(a_s16*a_plies),0) as \"a_s16\", coalesce(sum(a_s17*a_plies),0) as \"a_s17\", coalesce(sum(a_s18*a_plies),0) as \"a_s18\", coalesce(sum(a_s19*a_plies),0) as \"a_s19\", coalesce(sum(a_s20*a_plies),0) as \"a_s20\", coalesce(sum(a_s21*a_plies),0) as \"a_s21\", coalesce(sum(a_s22*a_plies),0) as \"a_s22\", coalesce(sum(a_s23*a_plies),0) as \"a_s23\", coalesce(sum(a_s24*a_plies),0) as \"a_s24\", coalesce(sum(a_s25*a_plies),0) as \"a_s25\", coalesce(sum(a_s26*a_plies),0) as \"a_s26\", coalesce(sum(a_s27*a_plies),0) as \"a_s27\", coalesce(sum(a_s28*a_plies),0) as \"a_s28\", coalesce(sum(a_s29*a_plies),0) as \"a_s29\", coalesce(sum(a_s30*a_plies),0) as \"a_s30\", coalesce(sum(a_s31*a_plies),0) as \"a_s31\", coalesce(sum(a_s32*a_plies),0) as \"a_s32\", coalesce(sum(a_s33*a_plies),0) as \"a_s33\", coalesce(sum(a_s34*a_plies),0) as \"a_s34\", coalesce(sum(a_s35*a_plies),0) as \"a_s35\", coalesce(sum(a_s36*a_plies),0) as \"a_s36\", coalesce(sum(a_s37*a_plies),0) as \"a_s37\", coalesce(sum(a_s38*a_plies),0) as \"a_s38\", coalesce(sum(a_s39*a_plies),0) as \"a_s39\", coalesce(sum(a_s40*a_plies),0) as \"a_s40\", coalesce(sum(a_s41*a_plies),0) as \"a_s41\", coalesce(sum(a_s42*a_plies),0) as \"a_s42\", coalesce(sum(a_s43*a_plies),0) as \"a_s43\", coalesce(sum(a_s44*a_plies),0) as \"a_s44\", coalesce(sum(a_s45*a_plies),0) as \"a_s45\", coalesce(sum(a_s46*a_plies),0) as \"a_s46\", coalesce(sum(a_s47*a_plies),0) as \"a_s47\", coalesce(sum(a_s48*a_plies),0) as \"a_s48\", coalesce(sum(a_s49*a_plies),0) as \"a_s49\", coalesce(sum(a_s50*a_plies),0) as \"a_s50\" ,coalesce(sum(p_xs),0) as \"p_xs\", coalesce(sum(p_s),0) as \"p_s\", coalesce(sum(p_m),0) as \"p_m\", coalesce(sum(p_l),0) as \"p_l\", coalesce(sum(p_xl),0) as \"p_xl\", coalesce(sum(p_xxl),0) as \"p_xxl\", coalesce(sum(p_xxxl),0) as \"p_xxxl\", coalesce(sum(p_s01),0) as \"p_s01\", coalesce(sum(p_s02),0) as \"p_s02\", coalesce(sum(p_s03),0) as \"p_s03\", coalesce(sum(p_s04),0) as \"p_s04\", coalesce(sum(p_s05),0) as \"p_s05\", coalesce(sum(p_s06),0) as \"p_s06\", coalesce(sum(p_s07),0) as \"p_s07\", coalesce(sum(p_s08),0) as \"p_s08\", coalesce(sum(p_s09),0) as \"p_s09\", coalesce(sum(p_s10),0) as \"p_s10\", coalesce(sum(p_s11),0) as \"p_s11\", coalesce(sum(p_s12),0) as \"p_s12\", coalesce(sum(p_s13),0) as \"p_s13\", coalesce(sum(p_s14),0) as \"p_s14\", coalesce(sum(p_s15),0) as \"p_s15\", coalesce(sum(p_s16),0) as \"p_s16\", coalesce(sum(p_s17),0) as \"p_s17\", coalesce(sum(p_s18),0) as \"p_s18\", coalesce(sum(p_s19),0) as \"p_s19\", coalesce(sum(p_s20),0) as \"p_s20\", coalesce(sum(p_s21),0) as \"p_s21\", coalesce(sum(p_s22),0) as \"p_s22\", coalesce(sum(p_s23),0) as \"p_s23\", coalesce(sum(p_s24),0) as \"p_s24\", coalesce(sum(p_s25),0) as \"p_s25\", coalesce(sum(p_s26),0) as \"p_s26\", coalesce(sum(p_s27),0) as \"p_s27\", coalesce(sum(p_s28),0) as \"p_s28\", coalesce(sum(p_s29),0) as \"p_s29\", coalesce(sum(p_s30),0) as \"p_s30\", coalesce(sum(p_s31),0) as \"p_s31\", coalesce(sum(p_s32),0) as \"p_s32\", coalesce(sum(p_s33),0) as \"p_s33\", coalesce(sum(p_s34),0) as \"p_s34\", coalesce(sum(p_s35),0) as \"p_s35\", coalesce(sum(p_s36),0) as \"p_s36\", coalesce(sum(p_s37),0) as \"p_s37\", coalesce(sum(p_s38),0) as \"p_s38\", coalesce(sum(p_s39),0) as \"p_s39\", coalesce(sum(p_s40),0) as \"p_s40\", coalesce(sum(p_s41),0) as \"p_s41\", coalesce(sum(p_s42),0) as \"p_s42\", coalesce(sum(p_s43),0) as \"p_s43\", coalesce(sum(p_s44),0) as \"p_s44\", coalesce(sum(p_s45),0) as \"p_s45\", coalesce(sum(p_s46),0) as \"p_s46\", coalesce(sum(p_s47),0) as \"p_s47\", coalesce(sum(p_s48),0) as \"p_s48\", coalesce(sum(p_s49),0) as \"p_s49\", coalesce(sum(p_s50),0) as \"p_s50\" from $bai_pro3.recut_v2_summary where order_tid=\"$order_tid\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result1))
			{
				$recut_qty_db[]=$sql_row2['a_xs'];
				$recut_qty_db[]=$sql_row2['a_s'];
				$recut_qty_db[]=$sql_row2['a_m'];
				$recut_qty_db[]=$sql_row2['a_l'];
				$recut_qty_db[]=$sql_row2['a_xl'];
				$recut_qty_db[]=$sql_row2['a_xxl'];
				$recut_qty_db[]=$sql_row2['a_xxxl'];
				$recut_qty_db[]=$sql_row2['a_s01'];
				$recut_qty_db[]=$sql_row2['a_s02'];
				$recut_qty_db[]=$sql_row2['a_s03'];
				$recut_qty_db[]=$sql_row2['a_s04'];
				$recut_qty_db[]=$sql_row2['a_s05'];
				$recut_qty_db[]=$sql_row2['a_s06'];
				$recut_qty_db[]=$sql_row2['a_s07'];
				$recut_qty_db[]=$sql_row2['a_s08'];
				$recut_qty_db[]=$sql_row2['a_s09'];
				$recut_qty_db[]=$sql_row2['a_s10'];
				$recut_qty_db[]=$sql_row2['a_s11'];
				$recut_qty_db[]=$sql_row2['a_s12'];
				$recut_qty_db[]=$sql_row2['a_s13'];
				$recut_qty_db[]=$sql_row2['a_s14'];
				$recut_qty_db[]=$sql_row2['a_s15'];
				$recut_qty_db[]=$sql_row2['a_s16'];
				$recut_qty_db[]=$sql_row2['a_s17'];
				$recut_qty_db[]=$sql_row2['a_s18'];
				$recut_qty_db[]=$sql_row2['a_s19'];
				$recut_qty_db[]=$sql_row2['a_s20'];
				$recut_qty_db[]=$sql_row2['a_s21'];
				$recut_qty_db[]=$sql_row2['a_s22'];
				$recut_qty_db[]=$sql_row2['a_s23'];
				$recut_qty_db[]=$sql_row2['a_s24'];
				$recut_qty_db[]=$sql_row2['a_s25'];
				$recut_qty_db[]=$sql_row2['a_s26'];
				$recut_qty_db[]=$sql_row2['a_s27'];
				$recut_qty_db[]=$sql_row2['a_s28'];
				$recut_qty_db[]=$sql_row2['a_s29'];
				$recut_qty_db[]=$sql_row2['a_s30'];
				$recut_qty_db[]=$sql_row2['a_s31'];
				$recut_qty_db[]=$sql_row2['a_s32'];
				$recut_qty_db[]=$sql_row2['a_s33'];
				$recut_qty_db[]=$sql_row2['a_s34'];
				$recut_qty_db[]=$sql_row2['a_s35'];
				$recut_qty_db[]=$sql_row2['a_s36'];
				$recut_qty_db[]=$sql_row2['a_s37'];
				$recut_qty_db[]=$sql_row2['a_s38'];
				$recut_qty_db[]=$sql_row2['a_s39'];
				$recut_qty_db[]=$sql_row2['a_s40'];
				$recut_qty_db[]=$sql_row2['a_s41'];
				$recut_qty_db[]=$sql_row2['a_s42'];
				$recut_qty_db[]=$sql_row2['a_s43'];
				$recut_qty_db[]=$sql_row2['a_s44'];
				$recut_qty_db[]=$sql_row2['a_s45'];
				$recut_qty_db[]=$sql_row2['a_s46'];
				$recut_qty_db[]=$sql_row2['a_s47'];
				$recut_qty_db[]=$sql_row2['a_s48'];
				$recut_qty_db[]=$sql_row2['a_s49'];
				$recut_qty_db[]=$sql_row2['a_s50'];

				
				$recut_req_db[]=$sql_row2['p_xs'];
				$recut_req_db[]=$sql_row2['p_s'];
				$recut_req_db[]=$sql_row2['p_m'];
				$recut_req_db[]=$sql_row2['p_l'];
				$recut_req_db[]=$sql_row2['p_xl'];
				$recut_req_db[]=$sql_row2['p_xxl'];
				$recut_req_db[]=$sql_row2['p_xxxl'];
				$recut_req_db[]=$sql_row2['p_s01'];
				$recut_req_db[]=$sql_row2['p_s02'];
				$recut_req_db[]=$sql_row2['p_s03'];
				$recut_req_db[]=$sql_row2['p_s04'];
				$recut_req_db[]=$sql_row2['p_s05'];
				$recut_req_db[]=$sql_row2['p_s06'];
				$recut_req_db[]=$sql_row2['p_s07'];
				$recut_req_db[]=$sql_row2['p_s08'];
				$recut_req_db[]=$sql_row2['p_s09'];
				$recut_req_db[]=$sql_row2['p_s10'];
				$recut_req_db[]=$sql_row2['p_s11'];
				$recut_req_db[]=$sql_row2['p_s12'];
				$recut_req_db[]=$sql_row2['p_s13'];
				$recut_req_db[]=$sql_row2['p_s14'];
				$recut_req_db[]=$sql_row2['p_s15'];
				$recut_req_db[]=$sql_row2['p_s16'];
				$recut_req_db[]=$sql_row2['p_s17'];
				$recut_req_db[]=$sql_row2['p_s18'];
				$recut_req_db[]=$sql_row2['p_s19'];
				$recut_req_db[]=$sql_row2['p_s20'];
				$recut_req_db[]=$sql_row2['p_s21'];
				$recut_req_db[]=$sql_row2['p_s22'];
				$recut_req_db[]=$sql_row2['p_s23'];
				$recut_req_db[]=$sql_row2['p_s24'];
				$recut_req_db[]=$sql_row2['p_s25'];
				$recut_req_db[]=$sql_row2['p_s26'];
				$recut_req_db[]=$sql_row2['p_s27'];
				$recut_req_db[]=$sql_row2['p_s28'];
				$recut_req_db[]=$sql_row2['p_s29'];
				$recut_req_db[]=$sql_row2['p_s30'];
				$recut_req_db[]=$sql_row2['p_s31'];
				$recut_req_db[]=$sql_row2['p_s32'];
				$recut_req_db[]=$sql_row2['p_s33'];
				$recut_req_db[]=$sql_row2['p_s34'];
				$recut_req_db[]=$sql_row2['p_s35'];
				$recut_req_db[]=$sql_row2['p_s36'];
				$recut_req_db[]=$sql_row2['p_s37'];
				$recut_req_db[]=$sql_row2['p_s38'];
				$recut_req_db[]=$sql_row2['p_s39'];
				$recut_req_db[]=$sql_row2['p_s40'];
				$recut_req_db[]=$sql_row2['p_s41'];
				$recut_req_db[]=$sql_row2['p_s42'];
				$recut_req_db[]=$sql_row2['p_s43'];
				$recut_req_db[]=$sql_row2['p_s44'];
				$recut_req_db[]=$sql_row2['p_s45'];
				$recut_req_db[]=$sql_row2['p_s46'];
				$recut_req_db[]=$sql_row2['p_s47'];
				$recut_req_db[]=$sql_row2['p_s48'];
				$recut_req_db[]=$sql_row2['p_s49'];
				$recut_req_db[]=$sql_row2['p_s50'];
			}
			
			$act_cut_new_db=array();
			$sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s01*a_plies),0) as \"a_s01\", coalesce(sum(a_s02*a_plies),0) as \"a_s02\", coalesce(sum(a_s03*a_plies),0) as \"a_s03\", coalesce(sum(a_s04*a_plies),0) as \"a_s04\", coalesce(sum(a_s05*a_plies),0) as \"a_s05\", coalesce(sum(a_s06*a_plies),0) as \"a_s06\", coalesce(sum(a_s07*a_plies),0) as \"a_s07\", coalesce(sum(a_s08*a_plies),0) as \"a_s08\", coalesce(sum(a_s09*a_plies),0) as \"a_s09\", coalesce(sum(a_s10*a_plies),0) as \"a_s10\", coalesce(sum(a_s11*a_plies),0) as \"a_s11\", coalesce(sum(a_s12*a_plies),0) as \"a_s12\", coalesce(sum(a_s13*a_plies),0) as \"a_s13\", coalesce(sum(a_s14*a_plies),0) as \"a_s14\", coalesce(sum(a_s15*a_plies),0) as \"a_s15\", coalesce(sum(a_s16*a_plies),0) as \"a_s16\", coalesce(sum(a_s17*a_plies),0) as \"a_s17\", coalesce(sum(a_s18*a_plies),0) as \"a_s18\", coalesce(sum(a_s19*a_plies),0) as \"a_s19\", coalesce(sum(a_s20*a_plies),0) as \"a_s20\", coalesce(sum(a_s21*a_plies),0) as \"a_s21\", coalesce(sum(a_s22*a_plies),0) as \"a_s22\", coalesce(sum(a_s23*a_plies),0) as \"a_s23\", coalesce(sum(a_s24*a_plies),0) as \"a_s24\", coalesce(sum(a_s25*a_plies),0) as \"a_s25\", coalesce(sum(a_s26*a_plies),0) as \"a_s26\", coalesce(sum(a_s27*a_plies),0) as \"a_s27\", coalesce(sum(a_s28*a_plies),0) as \"a_s28\", coalesce(sum(a_s29*a_plies),0) as \"a_s29\", coalesce(sum(a_s30*a_plies),0) as \"a_s30\", coalesce(sum(a_s31*a_plies),0) as \"a_s31\", coalesce(sum(a_s32*a_plies),0) as \"a_s32\", coalesce(sum(a_s33*a_plies),0) as \"a_s33\", coalesce(sum(a_s34*a_plies),0) as \"a_s34\", coalesce(sum(a_s35*a_plies),0) as \"a_s35\", coalesce(sum(a_s36*a_plies),0) as \"a_s36\", coalesce(sum(a_s37*a_plies),0) as \"a_s37\", coalesce(sum(a_s38*a_plies),0) as \"a_s38\", coalesce(sum(a_s39*a_plies),0) as \"a_s39\", coalesce(sum(a_s40*a_plies),0) as \"a_s40\", coalesce(sum(a_s41*a_plies),0) as \"a_s41\", coalesce(sum(a_s42*a_plies),0) as \"a_s42\", coalesce(sum(a_s43*a_plies),0) as \"a_s43\", coalesce(sum(a_s44*a_plies),0) as \"a_s44\", coalesce(sum(a_s45*a_plies),0) as \"a_s45\", coalesce(sum(a_s46*a_plies),0) as \"a_s46\", coalesce(sum(a_s47*a_plies),0) as \"a_s47\", coalesce(sum(a_s48*a_plies),0) as \"a_s48\", coalesce(sum(a_s49*a_plies),0) as \"a_s49\", coalesce(sum(a_s50*a_plies),0) as \"a_s50\" from $bai_pro3.order_cat_doc_mix where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\") and act_cut_status=\"DONE\"";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result1))
			{
				$act_cut_new_db[]=$sql_row2['a_xs'];
				$act_cut_new_db[]=$sql_row2['a_s'];
				$act_cut_new_db[]=$sql_row2['a_m'];
				$act_cut_new_db[]=$sql_row2['a_l'];
				$act_cut_new_db[]=$sql_row2['a_xl'];
				$act_cut_new_db[]=$sql_row2['a_xxl'];
				$act_cut_new_db[]=$sql_row2['a_xxxl'];
				$act_cut_new_db[]=$sql_row2['a_s01'];
				$act_cut_new_db[]=$sql_row2['a_s02'];
				$act_cut_new_db[]=$sql_row2['a_s03'];
				$act_cut_new_db[]=$sql_row2['a_s04'];
				$act_cut_new_db[]=$sql_row2['a_s05'];
				$act_cut_new_db[]=$sql_row2['a_s06'];
				$act_cut_new_db[]=$sql_row2['a_s07'];
				$act_cut_new_db[]=$sql_row2['a_s08'];
				$act_cut_new_db[]=$sql_row2['a_s09'];
				$act_cut_new_db[]=$sql_row2['a_s10'];
				$act_cut_new_db[]=$sql_row2['a_s11'];
				$act_cut_new_db[]=$sql_row2['a_s12'];
				$act_cut_new_db[]=$sql_row2['a_s13'];
				$act_cut_new_db[]=$sql_row2['a_s14'];
				$act_cut_new_db[]=$sql_row2['a_s15'];
				$act_cut_new_db[]=$sql_row2['a_s16'];
				$act_cut_new_db[]=$sql_row2['a_s17'];
				$act_cut_new_db[]=$sql_row2['a_s18'];
				$act_cut_new_db[]=$sql_row2['a_s19'];
				$act_cut_new_db[]=$sql_row2['a_s20'];
				$act_cut_new_db[]=$sql_row2['a_s21'];
				$act_cut_new_db[]=$sql_row2['a_s22'];
				$act_cut_new_db[]=$sql_row2['a_s23'];
				$act_cut_new_db[]=$sql_row2['a_s24'];
				$act_cut_new_db[]=$sql_row2['a_s25'];
				$act_cut_new_db[]=$sql_row2['a_s26'];
				$act_cut_new_db[]=$sql_row2['a_s27'];
				$act_cut_new_db[]=$sql_row2['a_s28'];
				$act_cut_new_db[]=$sql_row2['a_s29'];
				$act_cut_new_db[]=$sql_row2['a_s30'];
				$act_cut_new_db[]=$sql_row2['a_s31'];
				$act_cut_new_db[]=$sql_row2['a_s32'];
				$act_cut_new_db[]=$sql_row2['a_s33'];
				$act_cut_new_db[]=$sql_row2['a_s34'];
				$act_cut_new_db[]=$sql_row2['a_s35'];
				$act_cut_new_db[]=$sql_row2['a_s36'];
				$act_cut_new_db[]=$sql_row2['a_s37'];
				$act_cut_new_db[]=$sql_row2['a_s38'];
				$act_cut_new_db[]=$sql_row2['a_s39'];
				$act_cut_new_db[]=$sql_row2['a_s40'];
				$act_cut_new_db[]=$sql_row2['a_s41'];
				$act_cut_new_db[]=$sql_row2['a_s42'];
				$act_cut_new_db[]=$sql_row2['a_s43'];
				$act_cut_new_db[]=$sql_row2['a_s44'];
				$act_cut_new_db[]=$sql_row2['a_s45'];
				$act_cut_new_db[]=$sql_row2['a_s46'];
				$act_cut_new_db[]=$sql_row2['a_s47'];
				$act_cut_new_db[]=$sql_row2['a_s48'];
				$act_cut_new_db[]=$sql_row2['a_s49'];
				$act_cut_new_db[]=$sql_row2['a_s50'];
			}
			
			$rejected_db=array();
			$replaced_panels_new_db=array();
			$sample_room_new_db=array();
			$or_ratio_db=array();
			$good_panels=array();
			$sql1="select sum(rejected) as \"rejected\", sum(replaced) as \"replaced\", sum(sample_room) as \"sample_room\", sum(good_garments) as \"or_ratio\", sum(good_panels) as \"good_panels\", qms_size  from $bai_pro3.bai_qms_day_report where qms_schedule=\"".$sql_row['schedule_no']."\" and qms_color=\"".$color."\" group by qms_size";
//echo $sql1."<br/>";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$l=array_search($sql_row1['qms_size'],$sizes_db);
				$rejected_db[$l]=$sql_row1['rejected'];
				$replaced_panels_new_db[$l]=$sql_row1['replaced'];
				$sample_room_new_db[$l]=$sql_row1['sample_room'];
				$or_ratio_db[$l]=$sql_row1['or_ratio'];
				$good_panels[$l]=$sql_row1['good_panels'];
				//echo $rejected."<br/>";
			}
			
			$act_in_new_db=array();
			for($m=0;$m<sizeof($sizes_db);$m++)
			{
				$act_in_new_db[$m]=0;
			}
			$sqlx1="select SUM(ims_qty) as \"ims_qty\", ims_size from $bai_pro3.ims_log where ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0 group by ims_size";
			//echo $sqlx1."<br/>";
			$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
			{
				$l=array_search(str_replace("a_","",$sql_rowx1['ims_size']),$sizes_db);
				//echo $l;
				$act_in_new_db[$l]+=$sql_rowx1['ims_qty'];
			}
			
			$sqlx1="select SUM(ims_qty) as \"ims_qty\", ims_size from $bai_pro3.ims_log_backup where ims_schedule=\"$schedule\" and ims_color=\"$color\" and ims_mod_no>0 group by ims_size";
			//echo $sqlx1."<br/>";
			$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
			{
				$l=array_search(str_replace("a_","",$sql_rowx1['ims_size']),$sizes_db);
				//echo $l;
				$act_in_new_db[$l]+=$sql_rowx1['ims_qty'];
			}
			
			$act_fg_new_db=array();
			$act_fca_new_db=array();
			
			for($m=0;$m<sizeof($sizes_db);$m++)
			{
				$act_fg_new_db[$m]=0;
				$act_fca_new_db[$m]=0;
			}
			
			if(substr($style,0,1)=="M")
			{
				$sqlx1="select sum(carton_act_qty) as scanned,size_code from $bai_pro3.packing_summary where order_del_no=\"$schedule\" and trim(order_col_des)=\"$color\" and status=\"DONE\" group by size_code";
				//echo $sqlx1."<br/>";
				$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
				{
					$l=array_search($sql_rowx1['size_code'],$sizes_db);
					$act_fg_new_db[$l]=$sql_rowx1['scanned'];
					$act_fca_new_db[$l]=$sql_rowx1['scanned'];
					$tot_ship_new_db[$l]=$sql_rowx1['scanned'];
				}
			}
			else
			{
				$sqlx1="select scanned,fca_app,size_code from $bai_pro3.disp_mix_size where order_del_no=\"$schedule\"";
				//echo $sqlx1."<br/>";
				$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
				{
					$l=array_search($sql_rowx1['size_code'],$sizes_db);
					$act_fg_new_db[$l]=$sql_rowx1['scanned'];
					$act_fca_new_db[$l]=$sql_rowx1['fca_app'];
					
				}
				
				$tot_ship_new_db=array();
			$sql1="select coalesce(sum(ship_s_xs),0) as \"ship_s_xs\", coalesce(sum(ship_s_s),0) as \"ship_s_s\", coalesce(sum(ship_s_m),0) as \"ship_s_m\", coalesce(sum(ship_s_l),0) as \"ship_s_l\", coalesce(sum(ship_s_xl),0) as \"ship_s_xl\", coalesce(sum(ship_s_xxl),0) as \"ship_s_xxl\", coalesce(sum(ship_s_xxxl),0) as \"ship_s_xxxl\", coalesce(sum(ship_s_s01),0) as \"ship_s_s01\", coalesce(sum(ship_s_s02),0) as \"ship_s_s02\", coalesce(sum(ship_s_s03),0) as \"ship_s_s03\", coalesce(sum(ship_s_s04),0) as \"ship_s_s04\", coalesce(sum(ship_s_s05),0) as \"ship_s_s05\", coalesce(sum(ship_s_s06),0) as \"ship_s_s06\", coalesce(sum(ship_s_s07),0) as \"ship_s_s07\", coalesce(sum(ship_s_s08),0) as \"ship_s_s08\", coalesce(sum(ship_s_s09),0) as \"ship_s_s09\", coalesce(sum(ship_s_s10),0) as \"ship_s_s10\", coalesce(sum(ship_s_s11),0) as \"ship_s_s11\", coalesce(sum(ship_s_s12),0) as \"ship_s_s12\", coalesce(sum(ship_s_s13),0) as \"ship_s_s13\", coalesce(sum(ship_s_s14),0) as \"ship_s_s14\", coalesce(sum(ship_s_s15),0) as \"ship_s_s15\", coalesce(sum(ship_s_s16),0) as \"ship_s_s16\", coalesce(sum(ship_s_s17),0) as \"ship_s_s17\", coalesce(sum(ship_s_s18),0) as \"ship_s_s18\", coalesce(sum(ship_s_s19),0) as \"ship_s_s19\", coalesce(sum(ship_s_s20),0) as \"ship_s_s20\", coalesce(sum(ship_s_s21),0) as \"ship_s_s21\", coalesce(sum(ship_s_s22),0) as \"ship_s_s22\", coalesce(sum(ship_s_s23),0) as \"ship_s_s23\", coalesce(sum(ship_s_s24),0) as \"ship_s_s24\", coalesce(sum(ship_s_s25),0) as \"ship_s_s25\", coalesce(sum(ship_s_s26),0) as \"ship_s_s26\", coalesce(sum(ship_s_s27),0) as \"ship_s_s27\", coalesce(sum(ship_s_s28),0) as \"ship_s_s28\", coalesce(sum(ship_s_s29),0) as \"ship_s_s29\", coalesce(sum(ship_s_s30),0) as \"ship_s_s30\", coalesce(sum(ship_s_s31),0) as \"ship_s_s31\", coalesce(sum(ship_s_s32),0) as \"ship_s_s32\", coalesce(sum(ship_s_s33),0) as \"ship_s_s33\", coalesce(sum(ship_s_s34),0) as \"ship_s_s34\", coalesce(sum(ship_s_s35),0) as \"ship_s_s35\", coalesce(sum(ship_s_s36),0) as \"ship_s_s36\", coalesce(sum(ship_s_s37),0) as \"ship_s_s37\", coalesce(sum(ship_s_s38),0) as \"ship_s_s38\", coalesce(sum(ship_s_s39),0) as \"ship_s_s39\", coalesce(sum(ship_s_s40),0) as \"ship_s_s40\", coalesce(sum(ship_s_s41),0) as \"ship_s_s41\", coalesce(sum(ship_s_s42),0) as \"ship_s_s42\", coalesce(sum(ship_s_s43),0) as \"ship_s_s43\", coalesce(sum(ship_s_s44),0) as \"ship_s_s44\", coalesce(sum(ship_s_s45),0) as \"ship_s_s45\", coalesce(sum(ship_s_s46),0) as \"ship_s_s46\", coalesce(sum(ship_s_s47),0) as \"ship_s_s47\", coalesce(sum(ship_s_s48),0) as \"ship_s_s48\", coalesce(sum(ship_s_s49),0) as \"ship_s_s49\", coalesce(sum(ship_s_s50),0) as \"ship_s_s50\" from $bai_pro3.ship_stat_log where ship_schedule=\"$schedule\" and disp_note_no>0";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result1))
			{
				$tot_ship_new_db[]=$sql_row2['ship_s_xs'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s'];
				$tot_ship_new_db[]=$sql_row2['ship_s_m'];
				$tot_ship_new_db[]=$sql_row2['ship_s_l'];
				$tot_ship_new_db[]=$sql_row2['ship_s_xl'];
				$tot_ship_new_db[]=$sql_row2['ship_s_xxl'];
				$tot_ship_new_db[]=$sql_row2['ship_s_xxxl'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s01'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s02'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s03'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s04'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s05'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s06'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s07'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s08'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s09'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s10'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s11'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s12'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s13'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s14'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s15'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s16'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s17'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s18'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s19'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s20'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s21'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s22'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s23'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s24'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s25'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s26'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s27'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s28'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s29'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s30'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s31'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s32'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s33'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s34'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s35'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s36'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s37'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s38'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s39'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s40'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s41'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s42'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s43'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s44'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s45'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s46'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s47'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s48'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s49'];
				$tot_ship_new_db[]=$sql_row2['ship_s_s50'];
			}
			}
			
			
			
			
			$display_total_good_panels=0;
			$display_total_missing_panels=0;
			$display_total_rejected_panels=0;
			
			for($i=0;$i<sizeof($order_qtys);$i++)
			{
				if($order_qtys[$i]>0)
				{
					
						$recut_qty=$recut_qty_db[$i];
						$recut_req=$recut_req_db[$i];
					
					
					$excess=0;
					
						$excess=$act_cut_new_db[$i]-$order_qtys[$i];
						$act_cut_new=$act_cut_new_db[$i];
				
					
					$rejected=0;
					$replaced_panels_new=0;
					$sample_room_new=0;
					
						$rejected=$rejected_db[$i];
						$replaced_panels_new=$replaced_panels_new_db[$i];
						$sample_room_new=$sample_room_new_db[$i];
						$or_ratio=$or_ratio_db[$i];
						
						$act_in_new=0;
					$act_in_new=$act_in_new_db[$i];
					
						$act_fg_new=$act_fg_new_db[$i];
						$act_fca_new=$act_fca_new_db[$i];
					
					
						$tot_ship_new=$tot_ship_new_db[$i];
					
					
					$missing_panels_new=0;
					$excess_panels_new=0;
					
					//calculation part
					
					$field_1=$act_cut_new+$recut_qty; //total cut qty
					$field_2=($act_in_new+$replaced_panels_new+($recut_qty-($recut_qty-$recut_req)));
					$field_3=$rejected;
					$field_4=$recut_req;
					$field_5=$recut_qty;
					$field_6=$sample_room_new;
					$field_7=$or_ratio;
					$field_8=$replaced_panels_new;
					$field_9=$good_panels[$i];
					$field_10=$tot_ship_new_db[$i];
					
					if($field_4==0)
					{
						$excess_panels_new=$field_9-$field_8;
					}
					else
					{
						$excess_panels_new=$field_5-$field_4;
					}
					
					if($field_4==0)
					{
						$missing_panels_new=$field_1-(($field_3+$field_6+$field_7+$field_10)+($field_9-$field_8));
					}
					else
					{
						$missing_panels_new=$field_1-($field_3+$field_6+$field_7+$field_10);
					}
					
					$sw_missing=$field_2-($field_3+$field_7+$field_10);
					if($field_4!=0)
					{
						$pr_missing=$field_9-$field_8;
					}
					
					$ct_missing=$field_1-(($field_2-$field_8)+($field_6+$field_9));
					//$sw_missing=$field_1."-".$field_2."-".$field_3."-".$field_4."-".$field_5."-".$field_6."-".$field_7."-".$field_8."-".$field_9."-".$field_10;
					
					//calculation part
					
					
					
					
					$status=6; //RM
					if($act_cut_new==0)
					{
						$status=6; //RM
					}
					else
					{
						if($act_cut_new>0 and $act_in_new==0)
						{
							$status=5; //Cutting
						}
						else
						{
							if($act_in_new>0)
							{
								$status=4; //Sewing
							}
						}
					}
					if($out_qtys[$i]>=$act_fg_new and $out_qtys[$i]>0 and $act_fg_new==$order_qtys[$i])
					{
						$status=2; //FG
						if($act_fca_new==$act_fg_new)
						{
							$status=1;
						}
					} 
					if($out_qtys[$i]>=$order_qtys[$i] and $out_qtys[$i]>0 and $act_fg_new<$order_qtys[$i])
					{
						$status=3; //packing
					}
					
					$status_title="Nil";
					switch($status)
					{
						case 6:
						{
							$status_title="RM";
							break;
						}
						case 5:
						{
							$status_title="Cutting";
							break;
						}
						case 4:
						{
							$status_title="Sewing";
							break;
						}
						case 3:
						{
							$status_title="Packing";
							break;
						}
						case 2:
						{
							$status_title="FG";
							break;
						}
						default:
						{
							$status_title="Nil";
						}
					}
					
					
					if(($status_title=="Nil" or $status_title=="FG") and $tot_ship_new>0)
					{
						if($tot_ship_new>=$order_qtys[$i])
						{
							$status_title="Shipped";
						}
						else
						{
							$status_title="Part Shipped";
						}
					}
					
					$style=$sql_row['style'];
					$schedule=$sql_row['schedule_no'];
					$color=$sql_row['color'];
					
					$already_reported=0;
					$sql1xx="select COALESCE(sum(report_qty),0) as report_qty from $bai_pro3.m3_offline_dispatch where style=\"$style\" and schedule=\"$schedule\" and color=\"$color\" and size=\"".$sizes_db[$i]."\"";
					$sql_result1xx=mysqli_query($link, $sql1xx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2xx=mysqli_fetch_array($sql_result1xx))
					{
						$already_reported=$sql_row2xx['report_qty'];
					}
					$style_url = getFullURL($_GET['r'],'pop_report.php', 'N');
					
					$row_count++;
					echo "<tr>";
					echo "<td class=\"lef\">".$sql_row['buyer_division']."</td>";
					echo "<td class=\"lef\">".$status_title."</td>";
					echo "<td>".$sql_row['ex_factory_date_new']."</td>";
					echo "<td class=\"lef\"><a class='btn btn-info btn-xs' href=\"$style_url&style=$style&schedule=$schedule&color=$color\" onclick=\"Popup=window.open('$style_url&style=$style&schedule=$schedule&color=$color"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$sql_row['style']."</a></td>";
					echo "<td>".$sql_row['schedule_no']."</td>";
					echo "<td class=\"lef\">".$sql_row['color']."</td>";
					echo "<td>".substr($sql_row['sections'],0,-1)."</td>";
					echo "<td>".$sizes_db[$i]."</td>";
					echo "<td>".$old_order_qtys[$i]."</td>";
					echo "<td>".$order_qtys[$i]."</td>";
					echo "<td>".($act_cut_new+$recut_qty)."</td>";
					echo "<td>".($act_in_new+$replaced_panels_new+($recut_qty-($recut_qty-$recut_req)))."</td>";
					echo "<td>".$out_qtys[$i]."</td>";
					echo "<td>".$act_fg_new."</td>";
					echo "<td>".$act_fca_new."</td>";
					//echo "<td>".$act_mca."</td>";
					echo "<td>".$tot_ship_new;
					echo "<input type=\"hidden\" name=\"style[]\" value=\"$style\">";
					echo "<input type=\"hidden\" name=\"schedule[]\" value=\"$schedule\">";
					echo "<input type=\"hidden\" name=\"color[]\" value=\"$color\">";
					echo "<input type=\"hidden\" name=\"size[]\" value=\"".$sizes_db[$i]."\">";
					echo "<input type=\"hidden\" name=\"order_qty[]\" value=\"".$order_qtys[$i]."\">";
					echo "<input type=\"hidden\" name=\"cut_qty[]\" value=\"".($act_cut_new+$recut_qty)."\">";
					echo "<input type=\"hidden\" name=\"input_qty[]\" value=\"".($act_in_new+$replaced_panels_new+($recut_qty-($recut_qty-$recut_req)))."\">";
					echo "<input type=\"hidden\" name=\"out_qty[]\" value=\"".$out_qtys[$i]."\">";
					echo "<input type=\"hidden\" name=\"fg_qty[]\" value=\"".$act_fg_new."\">";
					echo "<input type=\"hidden\" name=\"fca_qty[]\" value=\"".$act_fca_new."\">";
					echo "<input type=\"hidden\" name=\"ship_qty[]\" value=\"".$tot_ship_new."\">";
					echo "<input type=\"hidden\" name=\"exist_report_qty[]\" value=\"".$already_reported."\">";
					
					echo"</td>";
					echo "<td>".$already_reported."</td>";
					
					if(!in_array($username,$aut_users)){
						$check="readonly=\"true\"";
						$value=$act_fca_new-$already_reported;
					}else{
						$value=$order_qtys[$i]-$already_reported;
					}
					echo "<td><input type=\"number\" name=\"report_qty[]\" value=\"$value\" $check onkeyup=\"if(this.value>$value || this.value<0 || (event.which)==189 || (event.which)==187  ){ this.value=$value; sweetAlert('Please enter correct value.','','warning'); }\"></td>";
					//echo "<td>".$rejected."</td>";
					//echo "<td>".$sample_room_new."</td>";
					//echo "<td>".($excess_panels_new)."</td>";
					//echo "<td>".$or_ratio."</td>";
					//echo "<td>".$missing_panels_new."</td>";
					//echo "<td>".$sw_missing."</td>";
					//echo "<td>".$pr_missing."</td>";
					//echo "<td>".$ct_missing."</td>";
					echo "</tr>";
					
					$display_total_good_panels+=abs($excess_panels_new);
					$display_total_missing_panels+=abs($missing_panels_new);
					$display_total_rejected_panels+=abs($rejected);
				}
			}
		
			unset($order_qtys);
			unset($out_qtys);
			unset($recut_qty_db);
			unset($recut_req_db);
			unset($act_cut_new_db);
			unset($rejected_db);
			unset($replaced_panels_new_db);
			unset($sample_room_new_db);
			unset($or_ratio_db);
			unset($good_panels);
			unset($act_in_new_db);
			unset($act_fg_new_db);
			unset($act_fca_new_db);
			unset($tot_ship_new_db);
		
	
	} 
	echo "</table>";
	if($row_count > 0)	{
		echo '<span id="msg2" style="display:none; color:blue;">Please Wait...</span>';
		echo "<input class='btn btn-sm btn-warning' type=\"submit\" name=\"submit_new\" id='upd' value=\"Update\" onclick=\"document.getElementById('submit_new').style.display='none'; document.getElementById('msg2').style.display='';\">";
	}	
	echo "</form>
	</div>";

	if($row_count == 0)
		echo "<script> $('#upd').attr('disabled', 'disabled'); </script>";
}


?>
	</div><!-- panel body -->
</div><!-- panel -->
</div>

<?php
if(isset($_GET['color']))
	echo "<script>document.getElementById('show').disabled = false;
		  </script>";
?>