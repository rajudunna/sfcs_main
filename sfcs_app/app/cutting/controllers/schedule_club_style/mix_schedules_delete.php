
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R'));  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R')); ?>

<?php $self_url = 'index.php?r='.$_GET['r']; ?>
<script>
	function firstbox()
	{
		window.location.href ="<?= $self_url ?>&style="+document.test.style.value
	}

	function thirdbox()
	{
		window.location.href ="<?= $self_url ?>&style="+document.test.style.value+"&color="+document.test.color.value
	}

	function SetAllCheckBoxes(FormName, FieldName, CheckValue)
	{
		if(!document.forms[FormName])
			return;
		var objCheckBoxes = document.forms[FormName].elements[FieldName];
		if(!objCheckBoxes)
			return;
		var countCheckBoxes = objCheckBoxes.length;
		if(!countCheckBoxes)
			objCheckBoxes.checked = CheckValue;
		else
			// set the check value for all check boxes
			for(var i = 0; i < countCheckBoxes; i++)
				objCheckBoxes[i].checked = CheckValue;
	}
	</script>

<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];
//$po=$_GET['po'];

if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule']; 
	$color=$_POST['color'];
	//$po=$_POST['po'];
}

//echo $style.$schedule.$color;
?>

<div class='panel panel-primary'>
	<div class='panel panel-heading'>Schedule Mix Delete Panel</div>
	<div class='panel-body'>

<form name="test" action="index.php?r=<?php $_GET['r'] ?>" method="post">
<?php

		echo "<div class='col-sm-3'>";
			//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				// $sql="select distinct order_style_no from $bai_pro3.bai_orders_db where order_style_no not in ('H18122AA       ','I292550A       ','I292553A       ','I292580A       ','I292653A       ','I296643A       ','I96632AA       ','I96646AA       ','I97183AA','IDUMY929','M04600AA       ','M04600AB       ','M04600AC','M04634AD       ','M04634AE       ','M04634AF','M04634AG','M04641AA       ','M04648AA','M04649AA','M05083AA','M06484AQ       ','M06484AR','M06485AP       ','M07562AA','M09313AE       ','M09313AG       ','M09313AH','M4600GAA       ','M4634LAA','M4634RAA','M7028AAE       ','M7028AAF','N12201AE       ','N19201AD       ','N19801AB       ','N19801AC       ','N7118SAH       ','N7118SAI       ','S16580AA       ','S174815A       ','S174815B       ','S174815C       ','S17761AA       ','S17761AB       ','S17761AC       ','S17764AA       ','S17764AB       ','S17764AC       ','S17767AA       ','S17767AB       ','S17767AC       ','S17775AA       ','S17775AB       ','S17775AC       ','S19876AA       ','S19879AA       ','S19965AA       ','U10098AJ       ','U10217AH       ','U10217AI','U20128AH       ','U20128AI','U30002AH       ','U30002AI','U30148AK       ','U30148AL','U50027AK       ','U50027AL','U60116AK       ','U60117AK       ','U60117AL','U90008AH       ','U90008AI','YCI028AA','YCI278AA','YCI404AA','YCI553AA','YCI931AA','YCL028AA','YCL278AA','YCL404AA','YCL553AA','YCL931AA','YSI028AA','YSI278AA','YSI404AA','YSI553AA','YSI931AA') order by order_style_no";		
			//}
			$sql = "select distinct order_style_no from $bai_pro3.bai_orders_db order by order_style_no";
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<label for='style'>Select Style</label>
			<select  class='form-control' name='style' onchange='firstbox();'>";
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

		echo "</div>";
?>

<?php
	echo "<div class='col-sm-3'>";
	echo "<label for='color'>Select Color</label>
	<select  class='form-control' name='color' onchange='thirdbox();'>";

	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));

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
?>

<?php
	echo "<div class='col-sm-3'>";
	echo "<label for='schedule'>Select Club Schedule</label>
		<select  class='form-control' name='schedule'>";
	
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" and order_joins='1'";
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

	if(isset($_GET['color'])){	
		echo "<div class='col-sm-1'>";
			echo "<label></label><br/>";
			echo "<input type='submit' class='btn btn-primary' value='submit' name='clear'>";
		echo "</div>";	
	}
?>

</form>

<?php
if(isset($_POST['clear']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	
	$sql451="delete from $bai_pro3.bai_orders_db where order_del_no='".$schedule."' and order_col_des=\"".$color."\" ";
	//echo $sql451."<br>";
	$sql_result451=mysqli_query($link, $sql451) or die("Error".$sql451.mysqli_error($GLOBALS["___mysqli_ston"]));
		
	$sql452="delete from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des=\"".$color."\" ";
	//echo $sql452."<br>";
	$sql_result452=mysqli_query($link, $sql452) or die("Error".$sql452.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$order_tids=array();
	$sql4533="select order_tid from $bai_pro3.bai_orders_db where order_joins='J".$schedule."' and order_col_des=\"".$color."\"";
	//echo $sql4533."<br>";
	$sql_result4533=mysqli_query($link, $sql4533) or die("Error".$sql4533.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row4533=mysqli_fetch_array($sql_result4533))
	{
		$order_tids[]=$sql_row4533["order_tid"];
	}
	$sql4531="delete from $bai_pro3.bai_orders_db where order_tid in ('".implode("','",$order_tids)."')";
	//echo $sql4531."<br>";
	$sql_result4531=mysqli_query($link, $sql4531) or die("Error".$sql4531.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql4551="INSERT IGNORE INTO $bai_pro3.bai_orders_db SELECT * FROM bai_pro3.bai_orders_db_club WHERE order_tid IN  ('".implode("','",$order_tids)."')";
	//echo $sql4551."<br>";
	$sql_result4551=mysqli_query($link, $sql4551) or die("Error".$sql4551.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql4536="delete from $bai_pro3.bai_orders_db_confirm where order_tid in ('".implode("','",$order_tids)."')";
	//echo $sql4536."<br>";
	$sql_result4536=mysqli_query($link, $sql4536) or die("Error".$sql4536.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql4527="delete from $bai_pro3.allocate_stat_log where order_tid like \"%".$schedule."%\"";
	//echo $sql4527."<br>"; 
	$sql_result4527=mysqli_query($link, $sql4527) or die("Error".$sql4527.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql4528="delete from $bai_pro3.cuttable_stat_log where order_tid like \"%".$schedule."%\"";
	//echo $sql4528."<br>";
	$sql_result4528=mysqli_query($link, $sql4528) or die("Error".$sql4528.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql4529="delete from $bai_pro3.maker_stat_log where order_tid like \"%".$schedule."%\"";
	//echo $sql4529."<br>";
	$sql_result4529=mysqli_query($link, $sql4529) or die("Error".$sql4529.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql45512="DELETE FROM $bai_pro3.bai_orders_db_club_confirm WHERE order_tid IN  ('".implode("','",$order_tids)."')";
	$sql_result45512=mysqli_query($link, $sql45512) or die("Error".$sql45512.mysqli_error($GLOBALS["___mysqli_ston"]));
	
	echo "<script> swal('Mixing schedule has been removed','Please Re-mix the schedules again.','warning');</script>";
	/*
	$style=$_POST['style']; 
    $schedule=$_POST['schedule']; 
    $color=$_POST['color'];
	$order_joins="J".$schedule;	
    $docket_t_cmp=array();
    $docket_tmp=array();
	$docket_t_c=array();
    $docket_t=array();
	$status=0;$rows1=0;$rows=0;
	$sql88="select * from plandoc_stat_log where order_tid like \"%".$schedule.$color."%\""; 
	$result88=mysql_query($sql88,$link) or die("Error=8".mysql_error()); 
	//echo $sql88."<br>"; 
	if(mysql_num_rows($result88)>0) 
	{ 
		$sql881="select * from plandoc_stat_log where order_tid like \"%".$schedule.$color."%\""; 
		//echo $sql881."<br>";
		$result881=mysql_query($sql881,$link) or die("Error=8".mysql_error()); 
		while($row881=mysql_fetch_array($result881)) 
		{ 
			$docket_tmp[]=$row881['doc_no']; 
		} 
		$docket_t=implode(",", $docket_tmp); 
		$sql882="select * from plandoc_stat_log where org_doc_no in (".$docket_t.")"; 
		//echo $sql882."<br>";
		$result882=mysql_query($sql882,$link) or die("Error=8".mysql_error()); 
		if(mysql_num_rows($result882)>0)
		{
			while($row882=mysql_fetch_array($result882)) 
			{ 
				$docket_t_cmp[]=$row882['doc_no']; 
			} 
			$docket_t_c=array_merge($docket_t_cmp,$docket_tmp);
			//$docket_t_c=implode(",", $docket_t_cmp); 
			$sql8831="select * from brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c.")"; 
			//echo $sql8831."<br>";
			$result8831=mysql_query($sql8831,$link) or die("Error=8".mysql_error()); 
			$rows1=mysql_num_rows($result8831);
			
			$sql883="select * from brandix_bts.tbl_miniorder_data where docket_number in (".$docket_t_c.")"; 
			//echo $sql883."<br>";
			$result883=mysql_query($sql883,$link) or die("Error=8".mysql_error()); 
			$rows=mysql_num_rows($result883);
			if($rows>0)
			{
				$status=1;
			}
			else
			{
				$status=0;
			}	
			
		}
		else
		{			
			$status=0;
		}
	}
	//echo "Ststtua---".$status."----Rows1--".$rows1."----Rows--".$rows."<br>";
	if($status==0)
	{	
		$order_tids=array();
		$sql4533="select * from bai_pro3.bai_orders_db_confirm where order_joins='$order_joins' and order_col_des='".$color."'";
		//echo $sql4533."<br>";
		$sql_result4533=mysql_query($sql4533,$link) or exit("Sql Error".mysql_error());
		while($sql_row4533=mysql_fetch_array($sql_result4533))
		{
			$order_tids[]=$sql_row4533["order_tid"];
			$order_del_no[]=$sql_row4533["order_del_no"];
			$order_col_des[]=$sql_row4533["order_col_des"];
		}
		
		$sql4531="delete from bai_pro3.bai_orders_db where order_tid in ('".implode("','",$order_tids)."')";
		// echo $sql4531."<br>";
		$sql_result4531=mysql_query($sql4531,$link) or exit("Sql Error".mysql_error());
		
		$sql4551="INSERT IGNORE INTO bai_pro3.bai_orders_db SELECT * FROM bai_pro3.bai_orders_db_club WHERE order_tid IN  ('".implode("','",$order_tids)."')";
		// echo $sql4551."<br>";
		$sql_result4551=mysql_query($sql4551,$link) or exit("Sql Error".mysql_error());
		
		$sql4536="delete from bai_pro3.bai_orders_db_confirm where order_tid in ('".implode("','",$order_tids)."')";
		// echo $sql4536."<br>";
		$sql_result4536=mysql_query($sql4536,$link) or exit("Sql Error".mysql_error());
		
		$sql45271="delete from bai_pro3.plandoc_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4527."<br>"; 
		$sql_result45271=mysql_query($sql45271,$link) or exit("Sql Error".mysql_error());
		
		$sql452981="delete from bai_pro3.plandoc_stat_log where order_tid in ('".implode("','",$order_tids)."')";
		// echo $sql4527."<br>"; 
		$sql_result45298=mysql_query($sql452981,$link) or exit("Sql Error".mysql_error());
		
		$sql4527="delete from bai_pro3.allocate_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4527."<br>"; 
		$sql_result4527=mysql_query($sql4527,$link) or exit("Sql Error".mysql_error());
		
		$sql45298="delete from bai_pro3.allocate_stat_log where order_tid in ('".implode("','",$order_tids)."')";
		// echo $sql4527."<br>"; 
		$sql_result45298=mysql_query($sql45298,$link) or exit("Sql Error".mysql_error());
				
		$sql4528="delete from bai_pro3.cuttable_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4528."<br>";
		$sql_result4528=mysql_query($sql4528,$link) or exit("Sql Error".mysql_error());
		
		$sql4529="delete from bai_pro3.maker_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4529."<br>";
		$sql_result4529=mysql_query($sql4529,$link) or exit("Sql Error".mysql_error());
		
		$sql45229="delete from bai_pro3.cat_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4529."<br>";
		$sql_result45229=mysql_query($sql45229,$link) or exit("Sql Error".mysql_error());
			
		if($status==0 && $rows1>0)
		{				
			$sql102="delete from brandix_bts.tbl_cut_size_master where parent_id in (select id from brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c."))";
			// echo $sql102."<br>";			
			mysql_query($sql102,$link) or die("Error=121".mysql_error()); 
				 
			$sql103="delete from brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c.")"; 
			// echo $sql103."<br>";
			mysql_query($sql103,$link) or die("Error=121".mysql_error()); 
			 
			$sql101="delete from brandix_bts.tbl_orders_sizes_master where parent_id in (select id from brandix_bts.tbl_orders_master where product_schedule in (".implode(",",$order_del_no).") and order_col_des='".$color."')"; 
			mysql_query($sql101,$link) or die("Error=121".mysql_error()); 
			// echo $sql101."<br>";
		}	
		$sql451="delete from bai_pro3.bai_orders_db where order_del_no='".$schedule."' and order_col_des=\"".$color."\" ";
		// echo $sql451."<br>";
		$sql_result451=mysql_query($sql451,$link) or exit("Sql Error".mysql_error());
		
		$sql4521="delete from bai_pro3.bai_orders_db_club_confirm where order_del_no in (".implode(",",$order_del_no)." and order_col_des=\"".$color."\" ";
		// echo $sql451."<br>";
		$sql_result451=mysql_query($sql4521,$link) or exit("Sql Error".mysql_error());
					
		$sql452="delete from bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des=\"".$color."\" ";
		// echo $sql452."<br>";
		$sql_result452=mysql_query($sql452,$link) or exit("Sql Error".mysql_error());
		
		echo "<h2> Mixing Colour has been removed, Please Re-mix the schedule Colours again.</h2>";	
	}
	else
	{
		echo "<h2> Already Sewing Orders are prepared, Can you please delete the sewing orders and try Again.</h2>";	
	}
	*/
}
?>
