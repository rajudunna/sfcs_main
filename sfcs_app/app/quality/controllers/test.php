<!--
Core Module: Here we can update Good panels.

Description: Here we can update Good panels.

Changes:

1)Change 01(line nos: 447,454): 2013-11-20/kirang/Ticket#445574/add the please wait option after submit the details.
-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
//$view_access=user_acl("SFCS_0141",$username,1,$group_id_sfcs);
?>


<script>
function dodisable()
{
	document.input.update.style.visibility="hidden"; 
}


function check1(x) 
{
	console.log(x);
	if(x=="")
	{
		document.input.update.style.visibility="hidden"; 
	} 
	else 
	{
		
		document.input.update.style.visibility=""; 
		document.getElementById('msg').style.display='none';
	}
}
</script>

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

<style>
body
{
	font-family: arial;
}
table
{
	border-collapse:collapse;
	font-size:12px;
}
td
{
	border: 1px solid #29759c;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid #29759c;
	white-space:nowrap;
	border-collapse:collapse;
	width: 150px;
}
</style>

 <script>
function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('update').style.visibility="hidden";
}
 
function validateQty(event, bal, pre_val) 
{
	if($('#new_qty_'+pre_val).val() > bal){
		sweetAlert('Warning', 'update quantity must less than balance to receive.', 'error');
		// $(this).default.val();
		// console.log($('#new_qty_'+pre_val).defaultValue);
		$('#new_qty_'+pre_val).val(bal);
	}else {
		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
}
 </script>


<body onload="dodisable()">

<?php  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3_bulk_or_proc.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/appcommon/config/m3_bulk_or_proc.php"); 
?>

<?php

if(isset($_POST['submit']))
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
<div class="panel panel-primary">
<div class="panel-heading">Good Panel/Garments Entry Form</div>
<div class="panel-body">

<form name="test" action="?r=<?= $_GET['r'] ?>" method="post">
<div class="row">
	<div class='col-md-2'><label>Select Style:</label>
		<?php
		echo "<select name=\"style\" onchange=\"firstbox();\" class='form-control'>";
		//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log)";
		//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
		//{
			$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm order by order_style_no";	
		//}
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

		echo "</select>";
		?>
	</div>
	<div class='col-md-2'><label>Select Schedule: </label>
	<?php
		echo "<select name=\"schedule\" onchange=\"secondbox();\" class='form-control'>";
		error_reporting(0);
		$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" order by order_del_no";
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

		$sql11="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm_archive where order_style_no=\"$style\" and style_id>0 order by order_del_no";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check11=mysqli_num_rows($sql_result11);

		while($sql_row11=mysqli_fetch_array($sql_result11))
		{

		if(str_replace(" ","",$sql_row11['order_del_no'])==str_replace(" ","",$schedule))
		{
			echo "<option value=\"".$sql_row11['order_del_no']."\" selected>".$sql_row11['order_del_no']."</option>";
		}
		else
		{
			echo "<option value=\"".$sql_row11['order_del_no']."\">".$sql_row11['order_del_no']."</option>";
		}
		}

		echo "</select>";
	?>
	</div>
	<div class='col-md-2'><label>Select Color: </label>
	<?php
		echo "<select name=\"color\" onchange=\"thirdbox();\" class='form-control'>";
		$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
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

		$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm_archive where order_style_no=\"$style\" and order_del_no=\"$schedule\" and style_id>0";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);

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
	?>
	</div><br/>
	<div class='col-md-2'>
		<input type="submit" value="Show" name="submit" class="btn btn-primary">
	</div>
</div>
</form>

	<?php
	if(isset($_POST['submit']))
	{
		$style=$_POST['style'];
		$color=$_POST['color'];
		$schedule=$_POST['schedule'];
		
		if ($style=='NIL' or $schedule=='NIL' or $color=='NIL') {
			echo "<br><div class='alert alert-danger'>
					  <strong>Warning!</strong> Please Provide all Details
					</div>";
		} else {
					
			$sql_sch="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$style."\" and order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\"";
			$sql_result=mysqli_query($link, $sql_sch) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$count=mysqli_num_rows($sql_result);
			if($count > 0)
			{
				$table_name="bai_orders_db_confirm";
			}
			else
			{
				$table_name="bai_orders_db_archive";
			}	
			
			$title_sizes=array();
			$sql="select order_tid,order_s_xs,order_s_s,order_s_m,order_s_l,order_s_xl,order_s_xxl,order_s_xxxl,order_s_s01,order_s_s02,order_s_s03,order_s_s04,order_s_s05,order_s_s06,order_s_s07,order_s_s08,order_s_s09,order_s_s10,order_s_s11,order_s_s12,order_s_s13,order_s_s14,order_s_s15,order_s_s16,order_s_s17,order_s_s18,order_s_s19,order_s_s20,order_s_s21,order_s_s22,order_s_s23,order_s_s24,order_s_s25,order_s_s26,order_s_s27,order_s_s28,order_s_s29,order_s_s30,order_s_s31,order_s_s32,order_s_s33,order_s_s34,order_s_s35,order_s_s36,order_s_s37,order_s_s38,order_s_s39,order_s_s40,order_s_s41,order_s_s42,order_s_s43,order_s_s44,order_s_s45,order_s_s46,order_s_s47,order_s_s48,order_s_s49,order_s_s50,title_size_s01,title_size_s02,title_size_s03,title_size_s04,title_size_s05,title_size_s06,title_size_s07,title_size_s08,title_size_s09,title_size_s10,title_size_s11,title_size_s12,title_size_s13,title_size_s14,title_size_s15,title_size_s16,title_size_s17,title_size_s18,title_size_s19,title_size_s20,title_size_s21,title_size_s22,title_size_s23,title_size_s24,title_size_s25,title_size_s26,title_size_s27,title_size_s28,title_size_s29,title_size_s30,title_size_s31,title_size_s32,title_size_s33,title_size_s34,title_size_s35,title_size_s36,title_size_s37,title_size_s38,title_size_s39,title_size_s40,title_size_s41,title_size_s42,title_size_s43,title_size_s44,title_size_s45,title_size_s46,title_size_s47,title_size_s48,title_size_s49,title_size_s50,title_flag from $table_name where order_style_no=\"".$style."\" and order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				
				$size01 = $sql_row['title_size_s01'];
				$size02 = $sql_row['title_size_s02'];
				$size03 = $sql_row['title_size_s03'];
				$size04 = $sql_row['title_size_s04'];
				$size05 = $sql_row['title_size_s05'];
				$size06 = $sql_row['title_size_s06'];
				$size07 = $sql_row['title_size_s07'];
				$size08 = $sql_row['title_size_s08'];
				$size09 = $sql_row['title_size_s09'];
				$size10 = $sql_row['title_size_s10'];
				$size11 = $sql_row['title_size_s11'];
				$size12 = $sql_row['title_size_s12'];
				$size13 = $sql_row['title_size_s13'];
				$size14 = $sql_row['title_size_s14'];
				$size15 = $sql_row['title_size_s15'];
				$size16 = $sql_row['title_size_s16'];
				$size17 = $sql_row['title_size_s17'];
				$size18 = $sql_row['title_size_s18'];
				$size19 = $sql_row['title_size_s19'];
				$size20 = $sql_row['title_size_s20'];
				$size21 = $sql_row['title_size_s21'];
				$size22 = $sql_row['title_size_s22'];
				$size23 = $sql_row['title_size_s23'];
				$size24 = $sql_row['title_size_s24'];
				$size25 = $sql_row['title_size_s25'];
				$size26 = $sql_row['title_size_s26'];
				$size27 = $sql_row['title_size_s27'];
				$size28 = $sql_row['title_size_s28'];
				$size29 = $sql_row['title_size_s29'];
				$size30 = $sql_row['title_size_s30'];
				$size31 = $sql_row['title_size_s31'];
				$size32 = $sql_row['title_size_s32'];
				$size33 = $sql_row['title_size_s33'];
				$size34 = $sql_row['title_size_s34'];
				$size35 = $sql_row['title_size_s35'];
				$size36 = $sql_row['title_size_s36'];
				$size37 = $sql_row['title_size_s37'];
				$size38 = $sql_row['title_size_s38'];
				$size39 = $sql_row['title_size_s39'];
				$size40 = $sql_row['title_size_s40'];
				$size41 = $sql_row['title_size_s41'];
				$size42 = $sql_row['title_size_s42'];
				$size43 = $sql_row['title_size_s43'];
				$size44 = $sql_row['title_size_s44'];
				$size45 = $sql_row['title_size_s45'];
				$size46 = $sql_row['title_size_s46'];
				$size47 = $sql_row['title_size_s47'];
				$size48 = $sql_row['title_size_s48'];
				$size49 = $sql_row['title_size_s49'];
				$size50 = $sql_row['title_size_s50'];
				$flag = $sql_row['title_flag'];
				
				if($flag==0)
				{
					$size01 = 's01';
					$size02 = 's02';
					$size03 = 's03';
					$size04 = 's04';
					$size05 = 's05';
					$size06 = 's06';
					$size07 = 's07';
					$size08 = 's08';
					$size09 = 's09';
					$size10 = 's10';
					$size11 = 's11';
					$size12 = 's12';
					$size13 = 's13';
					$size14 = 's14';
					$size15 = 's15';
					$size16 = 's16';
					$size17 = 's17';
					$size18 = 's18';
					$size19 = 's19';
					$size20 = 's20';
					$size21 = 's21';
					$size22 = 's22';
					$size23 = 's23';
					$size24 = 's24';
					$size25 = 's25';
					$size26 = 's26';
					$size27 = 's27';
					$size28 = 's28';
					$size29 = 's29';
					$size30 = 's30';
					$size31 = 's31';
					$size32 = 's32';
					$size33 = 's33';
					$size34 = 's34';
					$size35 = 's35';
					$size36 = 's36';
					$size37 = 's37';
					$size38 = 's38';
					$size39 = 's39';
					$size40 = 's40';
					$size41 = 's41';
					$size42 = 's42';
					$size43 = 's43';
					$size44 = 's44';
					$size45 = 's45';
					$size46 = 's46';
					$size47 = 's47';
					$size48 = 's48';
					$size49 = 's49';
					$size50 = 's50';
				}
				
				if($sql_row['order_s_xs']>0) { $qty[]=$sql_row['order_s_xs']; $sizes[]=str_replace("order_s_","","order_s_xs");$title_sizes[]='XS';}
				if($sql_row['order_s_s']>0) { $qty[]=$sql_row['order_s_s'];  $sizes[]=str_replace("order_s_","","order_s_s");$title_sizes[]='S';}	
				if($sql_row['order_s_m']>0) {  $qty[]=$sql_row['order_s_m']; $sizes[]=str_replace("order_s_","","order_s_m");$title_sizes[]='M';}	
				if($sql_row['order_s_l']>0) {  $qty[]=$sql_row['order_s_l']; $sizes[]=str_replace("order_s_","","order_s_l");$title_sizes[]='L';}	
				if($sql_row['order_s_xl']>0) {  $qty[]=$sql_row['order_s_xl']; $sizes[]=str_replace("order_s_","","order_s_xl");$title_sizes[]='XL';}	
				if($sql_row['order_s_xxl']>0) {  $qty[]=$sql_row['order_s_xxl']; $sizes[]=str_replace("order_s_","","order_s_xxl");$title_sizes[]='XXL';}	
				if($sql_row['order_s_xxxl']>0) {  $qty[]=$sql_row['order_s_xxxl']; $sizes[]=str_replace("order_s_","","order_s_xxxl");$title_sizes[]='XXXL';}	
				if($sql_row['order_s_s01']>0) {  $qty[]=$sql_row['order_s_s01']; $sizes[]=str_replace("order_s_","","order_s_s01");$title_sizes[]=$size01;}
				if($sql_row['order_s_s02']>0) {  $qty[]=$sql_row['order_s_s02']; $sizes[]=str_replace("order_s_","","order_s_s02");$title_sizes[]=$size02;}
				if($sql_row['order_s_s03']>0) {  $qty[]=$sql_row['order_s_s03']; $sizes[]=str_replace("order_s_","","order_s_s03");$title_sizes[]=$size03;}
				if($sql_row['order_s_s04']>0) {  $qty[]=$sql_row['order_s_s04']; $sizes[]=str_replace("order_s_","","order_s_s04");$title_sizes[]=$size04;}
				if($sql_row['order_s_s05']>0) {  $qty[]=$sql_row['order_s_s05']; $sizes[]=str_replace("order_s_","","order_s_s05");$title_sizes[]=$size05;}
				if($sql_row['order_s_s06']>0) {  $qty[]=$sql_row['order_s_s06']; $sizes[]=str_replace("order_s_","","order_s_s06");$title_sizes[]=$size06;}
				if($sql_row['order_s_s07']>0) {  $qty[]=$sql_row['order_s_s07']; $sizes[]=str_replace("order_s_","","order_s_s07");$title_sizes[]=$size07;}
				if($sql_row['order_s_s08']>0) {  $qty[]=$sql_row['order_s_s08']; $sizes[]=str_replace("order_s_","","order_s_s08");$title_sizes[]=$size08;}
				if($sql_row['order_s_s09']>0) {  $qty[]=$sql_row['order_s_s09']; $sizes[]=str_replace("order_s_","","order_s_s09");$title_sizes[]=$size09;}
				if($sql_row['order_s_s10']>0) {  $qty[]=$sql_row['order_s_s10']; $sizes[]=str_replace("order_s_","","order_s_s10");$title_sizes[]=$size10;}
				if($sql_row['order_s_s11']>0) {  $qty[]=$sql_row['order_s_s11']; $sizes[]=str_replace("order_s_","","order_s_s11");$title_sizes[]=$size11;}
				if($sql_row['order_s_s12']>0) {  $qty[]=$sql_row['order_s_s12']; $sizes[]=str_replace("order_s_","","order_s_s12");$title_sizes[]=$size12;}
				if($sql_row['order_s_s13']>0) {  $qty[]=$sql_row['order_s_s13']; $sizes[]=str_replace("order_s_","","order_s_s13");$title_sizes[]=$size13;}
				if($sql_row['order_s_s14']>0) {  $qty[]=$sql_row['order_s_s14']; $sizes[]=str_replace("order_s_","","order_s_s14");$title_sizes[]=$size14;}
				if($sql_row['order_s_s15']>0) {  $qty[]=$sql_row['order_s_s15']; $sizes[]=str_replace("order_s_","","order_s_s15");$title_sizes[]=$size15;}
				if($sql_row['order_s_s16']>0) {  $qty[]=$sql_row['order_s_s16']; $sizes[]=str_replace("order_s_","","order_s_s16");$title_sizes[]=$size16;}
				if($sql_row['order_s_s17']>0) {  $qty[]=$sql_row['order_s_s17']; $sizes[]=str_replace("order_s_","","order_s_s17");$title_sizes[]=$size17;}
				if($sql_row['order_s_s18']>0) {  $qty[]=$sql_row['order_s_s18']; $sizes[]=str_replace("order_s_","","order_s_s18");$title_sizes[]=$size18;}
				if($sql_row['order_s_s19']>0) {  $qty[]=$sql_row['order_s_s19']; $sizes[]=str_replace("order_s_","","order_s_s19");$title_sizes[]=$size19;}
				if($sql_row['order_s_s20']>0) {  $qty[]=$sql_row['order_s_s20']; $sizes[]=str_replace("order_s_","","order_s_s20");$title_sizes[]=$size20;}
				if($sql_row['order_s_s21']>0) {  $qty[]=$sql_row['order_s_s21']; $sizes[]=str_replace("order_s_","","order_s_s21");$title_sizes[]=$size21;}
				if($sql_row['order_s_s22']>0) {  $qty[]=$sql_row['order_s_s22']; $sizes[]=str_replace("order_s_","","order_s_s22");$title_sizes[]=$size22;}
				if($sql_row['order_s_s23']>0) {  $qty[]=$sql_row['order_s_s23']; $sizes[]=str_replace("order_s_","","order_s_s23");$title_sizes[]=$size23;}
				if($sql_row['order_s_s24']>0) {  $qty[]=$sql_row['order_s_s24']; $sizes[]=str_replace("order_s_","","order_s_s24");$title_sizes[]=$size24;}
				if($sql_row['order_s_s25']>0) {  $qty[]=$sql_row['order_s_s25']; $sizes[]=str_replace("order_s_","","order_s_s25");$title_sizes[]=$size25;}
				if($sql_row['order_s_s26']>0) {  $qty[]=$sql_row['order_s_s26']; $sizes[]=str_replace("order_s_","","order_s_s26");$title_sizes[]=$size26;}
				if($sql_row['order_s_s27']>0) {  $qty[]=$sql_row['order_s_s27']; $sizes[]=str_replace("order_s_","","order_s_s27");$title_sizes[]=$size27;}
				if($sql_row['order_s_s28']>0) {  $qty[]=$sql_row['order_s_s28']; $sizes[]=str_replace("order_s_","","order_s_s28");$title_sizes[]=$size28;}
				if($sql_row['order_s_s29']>0) {  $qty[]=$sql_row['order_s_s29']; $sizes[]=str_replace("order_s_","","order_s_s29");$title_sizes[]=$size29;}
				if($sql_row['order_s_s30']>0) {  $qty[]=$sql_row['order_s_s30']; $sizes[]=str_replace("order_s_","","order_s_s30");$title_sizes[]=$size30;}
				if($sql_row['order_s_s31']>0) {  $qty[]=$sql_row['order_s_s31']; $sizes[]=str_replace("order_s_","","order_s_s31");$title_sizes[]=$size31;}
				if($sql_row['order_s_s32']>0) {  $qty[]=$sql_row['order_s_s32']; $sizes[]=str_replace("order_s_","","order_s_s32");$title_sizes[]=$size32;}
				if($sql_row['order_s_s33']>0) {  $qty[]=$sql_row['order_s_s33']; $sizes[]=str_replace("order_s_","","order_s_s33");$title_sizes[]=$size33;}
				if($sql_row['order_s_s34']>0) {  $qty[]=$sql_row['order_s_s34']; $sizes[]=str_replace("order_s_","","order_s_s34");$title_sizes[]=$size34;}
				if($sql_row['order_s_s35']>0) {  $qty[]=$sql_row['order_s_s35']; $sizes[]=str_replace("order_s_","","order_s_s35");$title_sizes[]=$size35;}
				if($sql_row['order_s_s36']>0) {  $qty[]=$sql_row['order_s_s36']; $sizes[]=str_replace("order_s_","","order_s_s36");$title_sizes[]=$size36;}
				if($sql_row['order_s_s37']>0) {  $qty[]=$sql_row['order_s_s37']; $sizes[]=str_replace("order_s_","","order_s_s37");$title_sizes[]=$size37;}
				if($sql_row['order_s_s38']>0) {  $qty[]=$sql_row['order_s_s38']; $sizes[]=str_replace("order_s_","","order_s_s38");$title_sizes[]=$size38;}
				if($sql_row['order_s_s39']>0) {  $qty[]=$sql_row['order_s_s39']; $sizes[]=str_replace("order_s_","","order_s_s39");$title_sizes[]=$size39;}
				if($sql_row['order_s_s40']>0) {  $qty[]=$sql_row['order_s_s40']; $sizes[]=str_replace("order_s_","","order_s_s40");$title_sizes[]=$size40;}
				if($sql_row['order_s_s41']>0) {  $qty[]=$sql_row['order_s_s41']; $sizes[]=str_replace("order_s_","","order_s_s41");$title_sizes[]=$size41;}
				if($sql_row['order_s_s42']>0) {  $qty[]=$sql_row['order_s_s42']; $sizes[]=str_replace("order_s_","","order_s_s42");$title_sizes[]=$size42;}
				if($sql_row['order_s_s43']>0) {  $qty[]=$sql_row['order_s_s43']; $sizes[]=str_replace("order_s_","","order_s_s43");$title_sizes[]=$size43;}
				if($sql_row['order_s_s44']>0) {  $qty[]=$sql_row['order_s_s44']; $sizes[]=str_replace("order_s_","","order_s_s44");$title_sizes[]=$size44;}
				if($sql_row['order_s_s45']>0) {  $qty[]=$sql_row['order_s_s45']; $sizes[]=str_replace("order_s_","","order_s_s45");$title_sizes[]=$size45;}
				if($sql_row['order_s_s46']>0) {  $qty[]=$sql_row['order_s_s46']; $sizes[]=str_replace("order_s_","","order_s_s46");$title_sizes[]=$size46;}
				if($sql_row['order_s_s47']>0) {  $qty[]=$sql_row['order_s_s47']; $sizes[]=str_replace("order_s_","","order_s_s47");$title_sizes[]=$size47;}
				if($sql_row['order_s_s48']>0) {  $qty[]=$sql_row['order_s_s48']; $sizes[]=str_replace("order_s_","","order_s_s48");$title_sizes[]=$size48;}
				if($sql_row['order_s_s49']>0) {  $qty[]=$sql_row['order_s_s49']; $sizes[]=str_replace("order_s_","","order_s_s49");$title_sizes[]=$size49;}
				if($sql_row['order_s_s50']>0) {  $qty[]=$sql_row['order_s_s50']; $sizes[]=str_replace("order_s_","","order_s_s50");$title_sizes[]=$size50;}
				$order_tid=$sql_row['order_tid'];

			}
			$sql="select sum(p_xs*p_plies) AS \"xs\",sum(p_s*p_plies) AS \"s\",sum(p_m*p_plies) AS \"m\",sum(p_l*p_plies) AS \"l\",sum(p_xl*p_plies) AS \"xl\",sum(p_xxl*p_plies) AS \"xxl\",sum(p_xxxl*p_plies) AS \"xxxl\",sum(p_s01 * p_plies) as \"s01\", sum(p_s02 * p_plies) as \"s02\", sum(p_s03 * p_plies) as \"s03\", sum(p_s04 * p_plies) as \"s04\", sum(p_s05 * p_plies) as \"s05\", sum(p_s06 * p_plies) as \"s06\", sum(p_s07 * p_plies) as \"s07\", sum(p_s08 * p_plies) as \"s08\", sum(p_s09 * p_plies) as \"s09\", sum(p_s10 * p_plies) as \"s10\", sum(p_s11 * p_plies) as \"s11\", sum(p_s12 * p_plies) as \"s12\", sum(p_s13 * p_plies) as \"s13\", sum(p_s14 * p_plies) as \"s14\", sum(p_s15 * p_plies) as \"s15\", sum(p_s16 * p_plies) as \"s16\", sum(p_s17 * p_plies) as \"s17\", sum(p_s18 * p_plies) as \"s18\", sum(p_s19 * p_plies) as \"s19\", sum(p_s20 * p_plies) as \"s20\", sum(p_s21 * p_plies) as \"s21\", sum(p_s22 * p_plies) as \"s22\", sum(p_s23 * p_plies) as \"s23\", sum(p_s24 * p_plies) as \"s24\", sum(p_s25 * p_plies) as \"s25\", sum(p_s26 * p_plies) as \"s26\", sum(p_s27 * p_plies) as \"s27\", sum(p_s28 * p_plies) as \"s28\", sum(p_s29 * p_plies) as \"s29\", sum(p_s30 * p_plies) as \"s30\", sum(p_s31 * p_plies) as \"s31\", sum(p_s32 * p_plies) as \"s32\", sum(p_s33 * p_plies) as \"s33\", sum(p_s34 * p_plies) as \"s34\", sum(p_s35 * p_plies) as \"s35\", sum(p_s36 * p_plies) as \"s36\", sum(p_s37 * p_plies) as \"s37\", sum(p_s38 * p_plies) as \"s38\", sum(p_s39 * p_plies) as \"s39\", sum(p_s40 * p_plies) as \"s40\", sum(p_s41 * p_plies) as \"s41\", sum(p_s42 * p_plies) as \"s42\", sum(p_s43 * p_plies) as \"s43\", sum(p_s44 * p_plies) as \"s44\", sum(p_s45 * p_plies) as \"s45\", sum(p_s46 * p_plies) as \"s46\", sum(p_s47 * p_plies) as \"s47\", sum(p_s48 * p_plies) as \"s48\", sum(p_s49 * p_plies) as \"s49\", sum(p_s50 * p_plies) as \"s50\" from plandoc_stat_log where cat_ref in (select tid from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in ($in_categories)) and remarks=\"Normal\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				if($sql_row['xs']>0) { $acut[]=$sql_row['xs'];}
				if($sql_row['s']>0) { $acut[]=$sql_row['s'];}
				if($sql_row['m']>0) { $acut[]=$sql_row['m'];}
				if($sql_row['l']>0) { $acut[]=$sql_row['l'];}
				if($sql_row['xl']>0) { $acut[]=$sql_row['xl'];}
				if($sql_row['xxl']>0) { $acut[]=$sql_row['xxl'];}
				if($sql_row['xxxl']>0) { $acut[]=$sql_row['xxxl'];}
				if($sql_row['s01']>0) { $acut[]=$sql_row['s01'];}
				if($sql_row['s02']>0) { $acut[]=$sql_row['s02'];}
				if($sql_row['s03']>0) { $acut[]=$sql_row['s03'];}
				if($sql_row['s04']>0) { $acut[]=$sql_row['s04'];}
				if($sql_row['s05']>0) { $acut[]=$sql_row['s05'];}
				if($sql_row['s06']>0) { $acut[]=$sql_row['s06'];}
				if($sql_row['s07']>0) { $acut[]=$sql_row['s07'];}
				if($sql_row['s08']>0) { $acut[]=$sql_row['s08'];}
				if($sql_row['s09']>0) { $acut[]=$sql_row['s09'];}
				if($sql_row['s10']>0) { $acut[]=$sql_row['s10'];}
				if($sql_row['s11']>0) { $acut[]=$sql_row['s11'];}
				if($sql_row['s12']>0) { $acut[]=$sql_row['s12'];}
				if($sql_row['s13']>0) { $acut[]=$sql_row['s13'];}
				if($sql_row['s14']>0) { $acut[]=$sql_row['s14'];}
				if($sql_row['s15']>0) { $acut[]=$sql_row['s15'];}
				if($sql_row['s16']>0) { $acut[]=$sql_row['s16'];}
				if($sql_row['s17']>0) { $acut[]=$sql_row['s17'];}
				if($sql_row['s18']>0) { $acut[]=$sql_row['s18'];}
				if($sql_row['s19']>0) { $acut[]=$sql_row['s19'];}
				if($sql_row['s20']>0) { $acut[]=$sql_row['s20'];}
				if($sql_row['s21']>0) { $acut[]=$sql_row['s21'];}
				if($sql_row['s22']>0) { $acut[]=$sql_row['s22'];}
				if($sql_row['s23']>0) { $acut[]=$sql_row['s23'];}
				if($sql_row['s24']>0) { $acut[]=$sql_row['s24'];}
				if($sql_row['s25']>0) { $acut[]=$sql_row['s25'];}
				if($sql_row['s26']>0) { $acut[]=$sql_row['s26'];}
				if($sql_row['s27']>0) { $acut[]=$sql_row['s27'];}
				if($sql_row['s28']>0) { $acut[]=$sql_row['s28'];}
				if($sql_row['s29']>0) { $acut[]=$sql_row['s29'];}
				if($sql_row['s30']>0) { $acut[]=$sql_row['s30'];}
				if($sql_row['s31']>0) { $acut[]=$sql_row['s31'];}
				if($sql_row['s32']>0) { $acut[]=$sql_row['s32'];}
				if($sql_row['s33']>0) { $acut[]=$sql_row['s33'];}
				if($sql_row['s34']>0) { $acut[]=$sql_row['s34'];}
				if($sql_row['s35']>0) { $acut[]=$sql_row['s35'];}
				if($sql_row['s36']>0) { $acut[]=$sql_row['s36'];}
				if($sql_row['s37']>0) { $acut[]=$sql_row['s37'];}
				if($sql_row['s38']>0) { $acut[]=$sql_row['s38'];}
				if($sql_row['s39']>0) { $acut[]=$sql_row['s39'];}
				if($sql_row['s40']>0) { $acut[]=$sql_row['s40'];}
				if($sql_row['s41']>0) { $acut[]=$sql_row['s41'];}
				if($sql_row['s42']>0) { $acut[]=$sql_row['s42'];}
				if($sql_row['s43']>0) { $acut[]=$sql_row['s43'];}
				if($sql_row['s44']>0) { $acut[]=$sql_row['s44'];}
				if($sql_row['s45']>0) { $acut[]=$sql_row['s45'];}
				if($sql_row['s46']>0) { $acut[]=$sql_row['s46'];}
				if($sql_row['s47']>0) { $acut[]=$sql_row['s47'];}
				if($sql_row['s48']>0) { $acut[]=$sql_row['s48'];}
				if($sql_row['s49']>0) { $acut[]=$sql_row['s49'];}
				if($sql_row['s50']>0) { $acut[]=$sql_row['s50'];}
			}
			?>
			<form name="input" method="post" action="?r=<?= $_GET['r'] ?>">
			<?php
				echo "<br/><br/><div style='max-width:1000px;overflow-x:scroll;'><table class='table table-bordered table-striped'>";
				echo "<tr><th style='background-color:#003366;color:white;'>Sizes</th>";
				$sizes_db=array();
				for($i=0;$i<sizeof($qty);$i++)
				{
					if($qty[$i]>0)
					{
						echo "<th>".strtoupper($title_sizes[$i])."</th>";
						$sizes_db[]=$sizes[$i];
						$title_sizes_db[]= $title_sizes[$i];
					}
				}
				echo "</tr>";
				
				echo "<tr><th style='background-color:#003366;color:white;'>Order Qty</th>";
				for($i=0;$i<sizeof($qty);$i++)
				{
					if($qty[$i]>0)
					{
						echo "<th>".$qty[$i]."</th>";
					}
				}
				echo "</tr>";
				
				echo "<tr><th style='background-color:#003366;color:white;'>Excess Cut</th>";
				for($i=0;$i<sizeof($qty);$i++)
				{
					if($qty[$i]>0)
					{
						if(intval($acut[$i])>=$qty[$i]){
							echo "<th>".($acut[$i]-$qty[$i])."</th>";
						}else{
							echo "<th>0</th>";
						}
					}
				}
				echo "</tr>";
				
				$qms_qty_ref=array();
				echo "<tr><th style='background-color:#003366;color:white;'>Received so far</th>";
				for($i=0;$i<sizeof($qty);$i++)
				{
					if($qty[$i]>0)
					{
						
						$sql="select coalesce(sum(qms_qty),0) as \"qms_qty\"  from $bai_pro3.bai_qms_db where qms_style=\"".$style."\" and qms_schedule=\"".$schedule."\" and qms_color=\"".$color."\" and qms_size=\"".$title_sizes_db[$i]."\" and qms_tran_type in (1)";

						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($sql_result))
						{
							$qms_qty=$sql_row['qms_qty'];
							$qms_qty_ref[]=$sql_row['qms_qty'];
						}
						
						echo "<th>".$qms_qty."</th>";
					}
				}
				echo "</tr>";
				
				echo "<tr><th style='background-color:#003366;color:white;'>Balance to Receive</th>";
				for($i=0;$i<sizeof($qty);$i++)
				{
					if(intval($acut[$i]) >= $qty[$i]){
						echo "<th>".(($acut[$i]-$qty[$i])-$qms_qty_ref[$i])."</th>";
					}else{
						echo "<th>".(($qty[$i]-$acut[$i])- intval($qms_qty_ref[$i]))."</th>";
					}
				}
				echo "</tr>";
				
				echo "<tr><th style='background-color:#003366;color:white;'>Update</th>";
				for($i=0;$i<sizeof($qty);$i++)
				{
					if($qty[$i]>0)
					{
						if(intval($acut[$i]) >= $qty[$i]){
							echo "<th style='color:black;'><input class='integer' type=\"text\" onchange='return validateQty(event,".(($acut[$i]-$qty[$i])-$qms_qty_ref[$i]).", ".$i.");' value=\"".(($acut[$i]-$qty[$i])-$qms_qty_ref[$i])."\" id=\"new_qty_".$i."\" name=\"qty[]\"></th>";
							
						}else{
							echo "<th style='color:black;'><input class='integer' type=\"text\" onchange='return validateQty(event,".(($qty[$i]-$acut[$i])- intval($qms_qty_ref[$i])).", ".$i.");' value=\"".(($qty[$i]-$acut[$i])- intval($qms_qty_ref[$i]))."\" name=\"qty[]\" id=\"new_qty_".$i."\"></th>";
							
						}
						//echo "<th>".(($acut[$i]-$qty[$i])-$qms_qty_ref[$i])."</th>";
					}
				}
				echo "</tr>";
				
				echo "</table></div>";
			?><br/>
			<div class='row'>
			<div class='col-md-4'></div>
				<div class='col-md-3'>
				<label>Source: </label>
					<?php
					echo "<select name=\"source\" onChange=\"check1(this.value)\" required class='form-control'>";
					echo "<option value=''>Select</option>";
					$sql1234="SELECT *  FROM $bai_pro3.tbl_cutting_table";

					$result7=mysqli_query($link, $sql1234) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($result7))
					{
						echo "<option value=\"".$sql_row['tbl_id']."\">". $sql_row['tbl_name']."</option>";
					}
					
					//echo "<option value=\"-1\">Production (O.R)</option>"; //given required rights to amulya
					//echo "<option value=\"0\">Sample Room</option>";

					echo "</select>";
					?>
				</div>
				<div class='col-md-2'><br/>
					<?= "<input type=\"submit\" name=\"update\" class='btn btn-success' style value=\"Update\" id=\"update\" onclick=\"document.getElementById('update').style.visibility='hidden'; document.getElementById('msg').style.display='';\">";  // Change 01 ( add the please wait option )?>
				</div>		
			</div>
			<?php
			echo "<input type=\"hidden\" name=\"sizes\" value=\"".implode(",",$sizes_db)."\">";
			echo "<input type=\"hidden\" name=\"title_sizes\" value=\"".implode(",",$title_sizes_db)."\">";
			echo "<input type=\"hidden\" name=\"style\" value=\"".$style."\">";
			echo "<input type=\"hidden\" name=\"schedule\" value=\"".$schedule."\">";
			echo "<input type=\"hidden\" name=\"color\" value=\"".$color."\">";
			
			//echo "<input type=\"submit\" name=\"update\" value=\"Update\" id=\"update\" onclick=\"javascript:button_disable();\">";
		    //	echo "<div id=\"process_message\"><h2><font color=\"red\">Please wait while updating data!!!</font></h2></div>";
			echo "</form>";

		}
		
	}

	?>
	
	<span id="msg" style="display:none;">Your Request is under process. Please Wait..</span> <!--Change 01 ( add the please wait option )-->

	<?php

	if(isset($_POST['update']))
	{
		
		$qty=$_POST['qty'];
		$style=$_POST['style'];
		$schedule=$_POST['schedule'];
		$color=$_POST['color'];
		$source=$_POST['source'];
		$sizes=$_POST['sizes'];
		$title_sizes=$_POST['title_sizes'];
		$title_sizes_db=array();
		$sizes_db=array();
		$sizes_db=explode(",",$sizes);
		$title_sizes_db=explode(",",$title_sizes);
		
		switch($source)
		{
			case -1:
			{
				$temp=5;
				break;
			}
			case 0:
			{
				$temp=5;
				break;
			}
			case 1:
			{
				$temp=1;
				break;
			}
			case 2:
			{
				$temp=1;
				break;
			}
			case 3:
			{
				$temp=1;
				break;
			}
			case 4:
			{
				$temp=1;
				break;
			}
		}
		
		$usr_msg="<br/>
		<br/><br/><table class='table table-bordered'><tr style='background-color:#003366;;color:white;'><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th></tr>";
		
		for($i=0;$i<sizeof($sizes_db);$i++)
		{
			if($qty[$i]>0)
			{
				$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,qms_size,qms_qty,qms_tran_type,remarks,log_date) values (\"".$style."\",\"".$schedule."\",\"".$color."\",\"".$title_sizes_db[$i]."\",".$qty[$i].",$temp,\"".$source."\",\"".date("Y-m-d")."\")";
				//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error1=".mysqli_error($GLOBALS["___mysqli_ston"]));
				
			}
			else
			{
				$flag=1;
				$usr_msg.="<tr><td>".$schedule."</td><td>".$color."</td><td>".$title_sizes_db[$i]."</td><td>".$qty[$i]."</td></tr>";
			}
		}
		
		$usr_msg.="</table>";
		
		
		//Validations
		echo $usr_msg;
		if ($flag != 1) 
		{
			echo "<h2 style='color:green;text-align:center'>Successfully Updated.</h2>";
		}
		
	}

	?>
</div>
</div></div>
</div>
<style>
table{
	text-weight:bold;
	text-align: center;
}
/* th {
	background-color:#003366;
	color:white;
} */
td{
	color:black;
}
</style>