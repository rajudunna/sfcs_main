<!--
Core Module: Here we can club the two colors into one lay plan of same schedule

Deascription: We can club the two colors for single cut plan.

-->
<?php
//echo getFullURLLevel($_GET['r'],'common/config/config.php',4,'R');
include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
//include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R')); 

?>
 
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->


<script>
	
	// $('#show').prop('disabled', true);
	// document.getElementById('show').disabled = true;
	
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
		// document.getElementById('show').disabled = false;
		// $('#show').prop('disabled', false);
		window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&category="+document.test.category.value		
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
	function check_style_sch_cat()
	{
		var style=document.getElementById('style').value;
		var sch=document.getElementById('schedule').value;
		var cat=document.getElementById('category').value;

	
		if(style=='' && sch=='' && cat=='')
		{
			sweetAlert('Please Select Style Schedule and category','','warning');
			return false;
		}
		else if(sch=='' && cat=='')
		{

			sweetAlert('Please Select schedule and category','','warning');
			return false;
		
		}
		else if(cat=='')
		{
			sweetAlert('Please Select category','','warning');
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
		var cat=document.getElementById('category').value;
	
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
	
</script>

<style>

th,td{ color : #000 }
</style>

<?php //include("../menu_content.php"); ?>

<?php
	//echo q$bai_pro3;
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
	$category=$_GET['category'];
	
?>


<div class="panel panel-primary">
	<div class="panel-heading"><b>Color Clubbing Panel</b> </div>
	<div class="panel-body">
		<form name="test" action="?r=<?php echo $_GET['r']; ?>" method="post">

<?php


echo "<div class='row'>";
echo "<div class='col-md-3'>Select Style: <select name=\"style\" id=\"style\" onchange=\"firstbox();\" class=\"select2_single form-control\">";
$sql="select distinct order_style_no from $bai_pro3.bai_orders_db group by order_style_no";	
// echo "working".$sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

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

echo "</select></div>";
?>

<?php

echo "<div class='col-md-3'>Select Schedule: <select name=\"schedule\" id=\"schedule\"  onclick=\"return check_style();\"  onchange=\"secondbox();\"  class=\"select2_single form-control\">";
$sql_result='';
if($style){
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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

echo "</select></div>";
$style_schedule=$style."".$schedule;
$style_schedule=str_replace(' ', '', $style_schedule);
$sql_result = '';
if($schedule){
	$sql="select distinct category from $bai_pro3.order_cat_doc_mix where REPLACE(order_tid,' ','') like \"%$style_schedule%\"";
	// echo "Qry :".$sql."</br>";	
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
echo "<div class='col-md-3'>Select Category: <select name=\"category\" id=\"category\" onclick=\"return check_style_sch();\" onchange=\"thirdbox();\" class=\"select2_single form-control\">";
echo "<option value='' selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['category'])==str_replace(" ","",$category)) {
		echo "<option value=\"".$sql_row['category']."\" selected>".$sql_row['category']."</option>";
	} else {
		echo "<option value=\"".$sql_row['category']."\">".$sql_row['category']."</option>";
	}
}


echo "</select></div>";


$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$total_schedules=mysqli_num_rows($sql_result);

$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\"";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$lay_plan_generated=mysqli_num_rows($sql_result);

$sql="select print_status from $bai_pro3.plandoc_stat_log where order_tid in (select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\") and print_status is not null and plan_module is not null";
	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$doc_count=mysqli_num_rows($sql_result);
//Exception
//$doc_count=0;

if($total_schedules==$lay_plan_generated and $doc_count==0 || $category!='')
{
	echo "<input type=\"submit\" id='show' value=\"Show\" name=\"submit\" class=\"btn btn-success\" onclick=\"return check_style_sch_cat();\" style=\"margin-top: 18px;\">";
}
// if(){
// 	echo "<input type=\"submit\" id='show' value=\"Show\" name=\"submit\" class=\"btn btn-success\" onclick=\"return check_style_sch_cat();\" style=\"margin-top: 18px;\">";
	
// }
?>

</form>

<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$category=$_POST['category'];
	
	if($style=='' || $schedule=='' || $category==''){
		echo "<script>sweetAlert('You did not select style or schedule or category','','warning');</script>";
		die();
		
	}
	
	$row_count = 0;
	// echo "<div class='row'>";
	echo "<br><br><div class='col-md-12'>";
	echo "<form name=\"test2\" method=\"post\" action='?r=".$_GET['r']."'>";
	echo "<table class='table table-bordered'>";
	$existing_id=0;
	echo "<tr class='success'><th>Group</th><th>Style/Schedule/Color</th><th>Category</th><th>Purchase Width</th><th>Order Quantity</th><th>Packing Method Ratio</th></tr>";
	$sql="select sum(p_xs*p_plies) as xs, sum(p_s*p_plies) as s, sum(p_m*p_plies) as m, sum(p_l*p_plies) as l, sum(p_xl*p_plies) as xl, sum(p_xxl*p_plies) as xxl, sum(p_xxxl*p_plies) as xxxl, sum(p_s01*p_plies) as s01,sum(p_s02*p_plies) as s02,sum(p_s03*p_plies) as s03,sum(p_s04*p_plies) as s04,sum(p_s05*p_plies) as s05,sum(p_s06*p_plies) as s06,sum(p_s07*p_plies) as s07,sum(p_s08*p_plies) as s08,sum(p_s09*p_plies) as s09,sum(p_s10*p_plies) as s10,sum(p_s11*p_plies) as s11,sum(p_s12*p_plies) as s12,sum(p_s13*p_plies) as s13,sum(p_s14*p_plies) as s14,sum(p_s15*p_plies) as s15,sum(p_s16*p_plies) as s16,sum(p_s17*p_plies) as s17,sum(p_s18*p_plies) as s18,sum(p_s19*p_plies) as s19,sum(p_s20*p_plies) as s20,sum(p_s21*p_plies) as s21,sum(p_s22*p_plies) as s22,sum(p_s23*p_plies) as s23,sum(p_s24*p_plies) as s24,sum(p_s25*p_plies) as s25,sum(p_s26*p_plies) as s26,sum(p_s27*p_plies) as s27,sum(p_s28*p_plies) as s28,sum(p_s29*p_plies) as s29,sum(p_s30*p_plies) as s30,sum(p_s31*p_plies) as s31,sum(p_s32*p_plies) as s32,sum(p_s33*p_plies) as s33,sum(p_s34*p_plies) as s34,sum(p_s35*p_plies) as s35,sum(p_s36*p_plies) as s36,sum(p_s37*p_plies) as s37,sum(p_s38*p_plies) as s38,sum(p_s39*p_plies) as s39,sum(p_s40*p_plies) as s40,sum(p_s41*p_plies) as s41,sum(p_s42*p_plies) as s42,sum(p_s43*p_plies) as s43,sum(p_s44*p_plies) as s44,sum(p_s45*p_plies) as s45,sum(p_s46*p_plies) as s46,sum(p_s47*p_plies) as s47,sum(p_s48*p_plies) as s48,sum(p_s49*p_plies) as s49,sum(p_s50*p_plies) as s50, category,order_tid,purwidth,clubbing,cat_ref from $bai_pro3.order_cat_doc_mix where order_tid in (select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\") and category=\"$category\" group by order_tid,category order by purwidth";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$i=0;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$row_count++;
		$xs=$sql_row['xs'];
		$s=$sql_row['s'];
		$m=$sql_row['m'];
		$l=$sql_row['l'];
		$xl=$sql_row['xl'];
		$xxl=$sql_row['xxl'];
		$xxxl=$sql_row['xxxl'];
		$s01=$sql_row['s01'];
		$s02=$sql_row['s02'];
		$s03=$sql_row['s03'];
		$s04=$sql_row['s04'];
		$s05=$sql_row['s05'];
		$s06=$sql_row['s06'];
		$s07=$sql_row['s07'];
		$s08=$sql_row['s08'];
		$s09=$sql_row['s09'];
		$s10=$sql_row['s10'];
		$s11=$sql_row['s11'];
		$s12=$sql_row['s12'];
		$s13=$sql_row['s13'];
		$s14=$sql_row['s14'];
		$s15=$sql_row['s15'];
		$s16=$sql_row['s16'];
		$s17=$sql_row['s17'];
		$s18=$sql_row['s18'];
		$s19=$sql_row['s19'];
		$s20=$sql_row['s20'];
		$s21=$sql_row['s21'];
		$s22=$sql_row['s22'];
		$s23=$sql_row['s23'];
		$s24=$sql_row['s24'];
		$s25=$sql_row['s25'];
		$s26=$sql_row['s26'];
		$s27=$sql_row['s27'];
		$s28=$sql_row['s28'];
		$s29=$sql_row['s29'];
		$s30=$sql_row['s30'];
		$s31=$sql_row['s31'];
		$s32=$sql_row['s32'];
		$s33=$sql_row['s33'];
		$s34=$sql_row['s34'];
		$s35=$sql_row['s35'];
		$s36=$sql_row['s36'];
		$s37=$sql_row['s37'];
		$s38=$sql_row['s38'];
		$s39=$sql_row['s39'];
		$s40=$sql_row['s40'];
		$s41=$sql_row['s41'];
		$s42=$sql_row['s42'];
		$s43=$sql_row['s43'];
		$s44=$sql_row['s44'];
		$s45=$sql_row['s45'];
		$s46=$sql_row['s46'];
		$s47=$sql_row['s47'];
		$s48=$sql_row['s48'];
		$s49=$sql_row['s49'];
		$s50=$sql_row['s50'];

		
		$order_ratio_stat=$sql_row['clubbing'];
		
		if($order_ratio_stat>$existing_id)
		{
			$existing_id=$order_ratio_stat;
		}
		//$total=$xs+$s+$m+$l+$xl+$xxl+$xxxl+$s06+$s08+$s10+$s12+$s14+$s16+$s18+$s20+$s22+$s24+$s26+$s28+$s30;
		$total = $xs+$s+$m+$l+$xl+$xxl+$xxxl+$s01+$s02+$s03+$s04+$s05+$s06+$s07+$s08+$s09+$s10+$s11+$s12+$s13+$s14+$s15+$s16+$s17+$s18+$s19+$s20+$s21+$s22+$s23+$s24+$s25+$s26+$s27+$s28+$s29+$s30+$s31+$s32+$s33+$s34+$s35+$s36+$s37+$s38+$s39+$s40+$s41+$s42+$s43+$s44+$s45+$s46+$s47+$s48+$s49+$s50;

		if($order_ratio_stat==0)
		{
			$order_ratio_stat="<input type=\"checkbox\" name=\"cb_ids[$i]\" value=\"".$sql_row['cat_ref']."\">".$sql_row['cat_ref'];
			$input="<input type=\"text\" id = \"tot[$i]\" name=\"tot[$i]\" class=\"select2_single form-control integer\">";
			//echo "<input type='text' name='tot[$i]' value='$total'>";
			$i++;
		}
		//echo "<tr><td><input type=\"checkbox\" value=\"".$sql_row['order_tid']."\">".$sql_row['order_col_des']."</td>";
		echo "<tr><td>".$order_ratio_stat."</td><td>".$sql_row['order_tid']."</td><td>".$sql_row['category']."</td><td>".$sql_row['purwidth']."</td><td>".$total."</td><td>".$input."</td></tr>";
	}
	echo "</table></div></div>";
	echo "<div class='row'>";

	echo "<div class='col-md-3'><input type=\"hidden\" name=\"new_id\" value=\"$existing_id\" class='form-control'>";
	echo "Plies:<select name='plies_ref' class='form-control'>
			<option value='max' selected>max</option>
			<option value='min'>min</option>
			</select></div>";

	echo '<div class="col-md-3">Clubing Ratio: <input type="text" name="clb_ratio" value="0" class="form-control integer"></div>';
    echo "<input type=\"submit\" id='club' name=\"club\" value=\"Club\" class=\"btn btn-success\" style=\"margin-top: 18px;\">";
	echo "</form></div>";
	echo "<h2 style='color:Red;'>Note: Please use clubbing only colours having same purchase width.</h2>";
	echo "</div>";
	if($row_count==0){
		echo '<script>
				sweetAlert("No Data Found","Try With Other schedule,color,category","warning");
				document.getElementById("club").disabled = "true";
			  </script>';
	}
}


if(isset($_POST['club']))
{
	echo '<br/>';
	$count = 0;
	$new_id=$_POST['new_id']+1;
	$cat_ids=$_POST['cb_ids'];
	$tot=$_POST['tot'];
	$plies_ref=$_POST['plies_ref'];
	$clb_ratio=$_POST['clb_ratio'];
	
	$coun = 0;
	$sum_keys = 0;

	if(count($tot) > 0){
		foreach($tot as $key => $val)
		{
			if(is_null($val) || $val == '' || $val==0){
				$coun++;
				unset($tot[$key]);
			}else
			{
				$sum_keys = $sum_keys+$val;
			}
		}
		$new_key=0;
		foreach($tot as $key => $val){
			unset($tot[$key]);
								
			$tot[$new_key] = $val;
			
			$new_key++;
		}
	}
	$new_key=0;
	if(count($cat_ids) > 0){
		foreach($cat_ids as $key => $val)
		{
			unset($cat_ids[$key]);
								
			$cat_ids[$new_key] = $val;
			
			$new_key++;
		}
	}
	//print_r($tot);
	//print_r($cat_ids);
	
	//$cat_id[0] = explode(":",$cat_ids);
	//print_r($cat_id[0]);

	if(sizeof($tot)==sizeof($cat_ids))
	{
		($_POST['cb_ids']!= NULL ) ? $cb_ids_array = implode(',',$_POST['cb_ids'])  :  $cb_ids_array = '';
			
	    $sql="Select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as sum  from $bai_pro3.bai_orders_db where order_tid in (select order_tid from $bai_pro3.cat_stat_log where tid in ($cb_ids_array))";
		//echo $sql."<br>";
		if(!$cb_ids_array){
			echo "<script>swal('Colors Already Clubbed ','','info')</script>";
			exit();
		}
		// $sql="Select (order_s_s06+order_s_s08+order_s_s10+order_s_s12+order_s_s14+order_s_s16+order_s_s18+order_s_s20+order_s_s22+order_s_s24+order_s_s26+order_s_s28+order_s_s30) as sum  from bai_orders_db 
		//       where order_tid in (select order_tid from cat_stat_log where tid in (".implode(",",$_POST['cb_ids'])."))";
		//echo $sql."<br/>";
		if(mysqli_query($link, $sql) or exit("Sql Error 31".mysqli_error($GLOBALS["___mysqli_ston"])))	
		//$sql="update cat_stat_log set clubbing=$new_id where tid in (".implode(",",$_POST['cb_ids']).")";
		$sql="update $bai_pro3.cat_stat_log set clubbing='$new_id' where tid in ($cb_ids_array)";
		// echo $sql."<br/>";
		if(mysqli_query($link, $sql) or exit("Sql Error 2".mysqli_error($GLOBALS["___mysqli_ston"])))
		{
			echo "<div class='col-sm-12'><div class='alert alert-success' role='alert' >Successfully Updated.</div></div>";
		}
		else
		{
			echo "<div class='col-sm-12'><div class='alert alert-danger' role='alert' >Failed.</div></div>";
		}
	
		//$cat_ids=$_POST['cb_ids'];
		$club_count=sizeof($_POST['cb_ids']);
		if($plies_ref=="max")
		{
		// $sql="select max(pliespercut) as plies from allocate_stat_log where cat_ref in (".implode(",",$_POST['cb_ids']).")";
		$sql="select max(pliespercut) as plies from $bai_pro3.allocate_stat_log where cat_ref in ('$cb_ids_array')";

		}
		if($plies_ref=="min")
		{
		// $sql="select min(pliespercut) as plies from allocate_stat_log where cat_ref in (".implode(",",$_POST['cb_ids']).")";
		$sql="select min(pliespercut) as plies from $bai_pro3.allocate_stat_log where cat_ref in ('$cb_ids_array')";

		}
		//echo $sql."<br/>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$maxplies=$sql_row['plies'];
		}
	
		for($i=0;$i<sizeof($cat_ids);$i++)
		{
			$cat_ref=$cat_ids[$i];
			
			if($clb_ratio==0)
			{
				$allowed_per_cut=sizeof($tot)/$sum_keys*$maxplies;
				// echo $allowed_per_cut."=".sizeof($tot)."/".$sum_keys."*".$maxplies."<br>";
			}
			else
			{
				$allowed_per_cut=$tot[$i]/$clb_ratio*$maxplies; 
			}
						
			$amend_doc=array();
			$amend_plies=array();
			
			$new_doc_ref=array();
			$new_doc_plies=array();
			$new_doc_cut_no=array(); //added by KiranG 20150912 - to avoid ratio jumping issue
			
			$sql="select doc_no,p_plies,pcutno from $bai_pro3.plandoc_stat_log where cat_ref=$cat_ref order by pcutno";
			//echo "<br/>".$sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$doc_no=$sql_row['doc_no'];
				$p_plies=$sql_row['p_plies'];
				$pcutno=$sql_row['pcutno']; //relocated by KiranG 20150912 - to avoid ratio jumping issue
				//echo "<br/>data=".$doc_no."--".$p_plies."--".$pcutno;
				//echo "<br/> allowed per cut ".$allowed_per_cut;
				if($p_plies>$allowed_per_cut)
				{
					//echo "One"."<br/>";
					$amend_doc[]=$doc_no;
					$amend_plies[]=$allowed_per_cut;
					$p_plies=$p_plies-$allowed_per_cut;
					
					$new_cut_no=1; //added by KiranG 20150912 - to avoid ratio jumping issue
					do
					{
						//echo "Two"."<br/>";
						if($p_plies>$allowed_per_cut)
						{
							$new_doc_ref[]=$doc_no;
							$new_doc_plies[]=$allowed_per_cut;
						}
						else
						{
							$new_doc_ref[]=$doc_no;
							$new_doc_plies[]=$p_plies;
						}
						$p_plies=$p_plies-$allowed_per_cut;
						$new_doc_cut_no[]=$pcutno.".".$new_cut_no; //added by KiranG 20150912 - to avoid ratio jumping issue
						$new_cut_no++; //added by KiranG 20150912 - to avoid ratio jumping issue
					}while($p_plies>0);
				}
				
			}
			
			for($j=0;$j<sizeof($amend_doc);$j++)
			{
				$sql="update $bai_pro3.plandoc_stat_log set p_plies=".$amend_plies[$j].", a_plies=".$amend_plies[$j]." where cat_ref=$cat_ref and doc_no=".$amend_doc[$j];
				// echo "<br/>".$sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			$pcutno++;
			
			for($j=0;$j<sizeof($new_doc_ref);$j++)
			{
				$new_plies=$new_doc_plies[$j];
				$sql="insert into $bai_pro3.plandoc_stat_log(date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,pcutno,acutno,ratio,p_xs,p_s,p_m,p_l,p_xl,p_xxl,p_xxxl,p_plies,a_xs,a_s,a_m,a_l,a_xl,a_xxl,a_xxxl,a_plies,lastup,remarks,act_cut_status,act_cut_issue_status,pcutdocid,print_status,a_s01,a_s02,a_s03,a_s04,a_s05,a_s06,a_s07,a_s08,a_s09,a_s10,a_s11,a_s12,a_s13,a_s14,a_s15,a_s16,a_s17,a_s18,a_s19,a_s20,a_s21,a_s22,a_s23,a_s24,a_s25,a_s26,a_s27,a_s28,a_s29,a_s30,a_s31,a_s32,a_s33,a_s34,a_s35,a_s36,a_s37,a_s38,a_s39,a_s40,a_s41,a_s42,a_s43,a_s44,a_s45,a_s46,a_s47,a_s48,a_s49,a_s50				,p_s01,p_s02,p_s03,p_s04,p_s05,p_s06,p_s07,p_s08,p_s09,p_s10,p_s11,p_s12,p_s13,p_s14,p_s15,p_s16,p_s17,p_s18,p_s19,p_s20,p_s21,p_s22,p_s23,p_s24,p_s25,p_s26,p_s27,p_s28,p_s29,p_s30,p_s31,p_s32,p_s33,p_s34,p_s35,p_s36,p_s37,p_s38,p_s39,p_s40,p_s41,p_s42,p_s43,p_s44,p_s45,p_s46,p_s47,p_s48,p_s49,p_s50,rm_date,cut_inp_temp,plan_module,fabric_status,plan_lot_ref) select date,cat_ref,cuttable_ref,allocate_ref,mk_ref,order_tid,".$new_doc_cut_no[$j].",".$new_doc_cut_no[$j].",ratio,p_xs,p_s,p_m,p_l,p_xl,p_xxl,p_xxxl,$new_plies,a_xs,a_s,a_m,a_l,a_xl,a_xxl,a_xxxl,$new_plie,lastup,remarks,act_cut_status,act_cut_issue_status,pcutdocid,print_status,a_s01,a_s02,a_s03,a_s04,a_s05,a_s06,a_s07,a_s08,a_s09,a_s10,a_s11,a_s12,a_s13,a_s14,a_s15,a_s16,a_s17,a_s18,a_s19,a_s20,a_s21,a_s22,a_s23,a_s24,a_s25,a_s26,a_s27,a_s28,a_s29,a_s30,a_s31,a_s32,a_s33,a_s34,a_s35,a_s36,a_s37,a_s38,a_s39,a_s40,a_s41,a_s42,a_s43,a_s44,a_s45,a_s46,a_s47,a_s48,a_s49,a_s50	,p_s01,p_s02,p_s03,p_s04,p_s05,p_s06,p_s07,p_s08,p_s09,p_s10,p_s11,p_s12,p_s13,p_s14,p_s15,p_s16,p_s17,p_s18,p_s19,p_s20,p_s21,p_s22,p_s23,p_s24,p_s25,p_s26,p_s27,p_s28,p_s29,p_s30,p_s31,p_s32,p_s33,p_s34,p_s35,p_s36,p_s37,p_s38,p_s39,p_s40,p_s41,p_s42,p_s43,p_s44,p_s45,p_s46,p_s47,p_s48,p_s49,p_s50,rm_date,cut_inp_temp,plan_module,fabric_status,plan_lot_ref from $bai_pro3.plandoc_stat_log where doc_no=".$new_doc_ref[$j]; //replaced $pcutno with $new_doc_cut_no by KiranG 20150912 - to avoid ratio jumping issue
				// echo "<br/>".$sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$pcutno++;
			}
			
			//Resetting the sequence of acutno and pcutno // kirang 20150912
			$sql="select doc_no from $bai_pro3.plandoc_stat_log where cat_ref=$cat_ref order by pcutno";
			// echo "<br/>".$sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$m=1;
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sql="update $bai_pro3.plandoc_stat_log set pcutno=$m,acutno=$m where doc_no=".$sql_row['doc_no']; //replaced $pcutno with $new_doc_cut_no by KiranG 20150912 - to avoid ratio jumping issue
				//echo "<br/>".$sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$m++;
			}
			
			
			unset($amend_doc);
			unset($amend_plies);
			unset($new_doc_plies);
			unset($new_doc_ref);		
		}

	}
	else
	{
		echo "<script>swal('Process stopped due to ratio has not entered for some colours. Please enter the ratio for all selected colours')</script>";
	}
}
?>

</div><!-- panel body -->
</div><!-- panel -->
</div>
</div>