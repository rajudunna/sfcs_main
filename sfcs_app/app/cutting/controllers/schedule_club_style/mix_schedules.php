


<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R'));  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R')); ?>

<?php $self_url = 'index.php?r='.$_GET['r']; ?>;
<script>
	function firstbox()
	{
		window.location.href ="<?= $self_url ?>&style="+document.test.style.value;
	}

	function midbox()
	{
		window.location.href ="<?= $self_url ?>&style="+document.test.style.value+"&po="+document.test.po.value;
	}

	function secondbox()
	{
		window.location.href ="<?= $self_url ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&po="+document.test.po.value
	}

	function thirdbox()
	{
		window.location.href ="<?= $self_url ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&po="+document.test.po.value
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
	$po=$_GET['po'];

	if(isset($_POST['submit']))
	{
		$style=$_POST['style'];
		$schedule=$_POST['schedule']; 
		$color=$_POST['color'];
		$po=$_POST['po'];
	}

//echo $style.$schedule.$color;
?>
<div class='panel panel-primary'>
	<div class='panel panel-heading'>Color Clubbing (Style)</div>
	<div class='panel-body'>
		<form name="test" action="index.php?r=<?= $_GET['r'] ?>" method="post">
		<?php

		echo "<div class='col-sm-3'>";
			//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				$sql="select distinct order_style_no from $bai_pro3.bai_orders_db where order_style_no not in ('H18122AA       ','I292550A       ','I292553A       ','I292580A       ','I292653A       ','I296643A       ','I96632AA       ','I96646AA       ','I97183AA','IDUMY929','M04600AA       ','M04600AB       ','M04600AC','M04634AD       ','M04634AE       ','M04634AF','M04634AG','M04641AA       ','M04648AA','M04649AA','M05083AA','M06484AQ       ','M06484AR','M06485AP       ','M07562AA','M09313AE       ','M09313AG       ','M09313AH','M4600GAA       ','M4634LAA','M4634RAA','M7028AAE       ','M7028AAF','N12201AE       ','N19201AD       ','N19801AB       ','N19801AC       ','N7118SAH       ','N7118SAI       ','S16580AA       ','S174815A       ','S174815B       ','S174815C       ','S17761AA       ','S17761AB       ','S17761AC       ','S17764AA       ','S17764AB       ','S17764AC       ','S17767AA       ','S17767AB       ','S17767AC       ','S17775AA       ','S17775AB       ','S17775AC       ','S19876AA       ','S19879AA       ','S19965AA       ','U10098AJ       ','U10217AH       ','U10217AI','U20128AH       ','U20128AI','U30002AH       ','U30002AI','U30148AK       ','U30148AL','U50027AK       ','U50027AL','U60116AK       ','U60117AK       ','U60117AL','U90008AH       ','U90008AI','YCI028AA','YCI278AA','YCI404AA','YCI553AA','YCI931AA','YCL028AA','YCL278AA','YCL404AA','YCL553AA','YCL931AA','YSI028AA','YSI278AA','YSI404AA','YSI553AA','YSI931AA') order by order_style_no";		
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

	if(isset($_GET['color'])){
		echo "<div class='col-sm-1'>";
			echo "<label></label><br/>";
			echo "<input type='submit' class='btn btn-primary' value='submit' name='submit'>";
		echo "</div>";	
	}	
?>


</form>
<br/>
<br/>


<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	
	$exfact=$_POST['schedule'];
	$style_input=$_POST['style'];
	//$size=array("s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50"); 
	$size_array=array();
	$orginal_size_array=array();
	for($q=0;$q<sizeof($sizes_array);$q++)
	{
		$sql6="select order_del_no,sum(order_s_".$sizes_array[$q].") as order_qty,title_size_".$sizes_array[$q]." as size from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" group by order_del_no order by order_style_no,order_del_no";
		$result6=mysqli_query($link,$sql6) or die("Error 3 = ".$sql6.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row6=mysqli_fetch_array($result6))
		{	
			if($row6["size"] <> '')
			{
				if(!in_array($sizes_array[$q],$size_array))
				{
					$size_array[]=$sizes_array[$q];
				}	
				if(!in_array($row6["size"],$orginal_size_array))
				{
					$orginal_size_array[]=$row6["size"];
				}
			}
		}
	}
	sort($orginal_size_array);
	sort($size_array);
	$unique_orginal_sizes=implode(",",array_unique($orginal_size_array));
	$unique_sizes=implode(",",array_unique($size_array));
	$unique_orginal_sizes_explode=explode(",",$unique_orginal_sizes);
	$unique_sizes_explode=explode(",",$unique_sizes);
	$size_type=1;
	echo "<form name='testnew' action='index.php?r=".$_GET['r']."' method='post'>";
	if(sizeof($size_array)>0)
	{
		echo "<table class='table table-bordered '>";
		echo "<tr class='warning'>";
		echo "<th>Select</th>";
		echo "<th>Style</th>";
		echo "<th>Schedule</th>";
		echo "<th>Color</th>";
		for($q=0;$q<sizeof($unique_orginal_sizes_explode);$q++)
		{
			echo "<th>".$unique_orginal_sizes_explode[$q]."</th>";
		}	
		echo "<th>Total</th>";
		echo "</tr>";
		$sql="select * from $bai_pro3.bai_orders_db where order_joins not in (\"1\",\"2\") and order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no>0 order by order_style_no";
		$test_count=0;
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error 4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			for($ii=0;$ii<sizeof($sizes_array);$ii++)
			{
				if($sql_row["title_size_".$sizes_array[$ii].""]<>'')
				{
					$o_s[]=$sql_row["order_s_".$sizes_array[$ii].""];
					$o_s_t[]=$sql_row["title_size_".$sizes_array[$ii].""];
				}
			}
			$order_total=array_sum($o_s);
			unset($o_s);
			$schedule=$sql_row['order_del_no'];
			$order_tid=$sql_row['order_tid'];
			$destination_ref=$sql_row["destination"];
			$schedule_array[]=$schedule;
			$sql4="delete FROM $bai_pro3.`orders_club_schedule` where order_del_no in (".$schedule.") and order_col_des=\"".$sql_row['order_col_des']."\"";
			$result4=mysqli_query($link, $sql4) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
			$style=$sql_row['order_style_no'];
			$color=$sql_row['order_col_des'];	
			$order_joins=$sql_row['order_joins'];
			echo "<tr>";
			if($order_total>0)
			{
				$sql41="select * FROM $bai_pro3.`plandoc_stat_log` where order_tid='".$order_tid."'";
				$result41=mysqli_query($link,$sql41) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($result41)==0)
				{
					if($order_joins=="0")
					{
						echo "<td><input type=\"checkbox\" name=\"sch[]\" value=\"$schedule\" checked></td>";
						$test_count=$test_count+1;
					}
					else
					{
						echo "<td>".substr($order_joins,1)."</td>";
					}
				}
				else
				{
					echo "<td>Already Planned-".substr($order_joins,1)."</td>";
				}
				
			}
			else
			{
				echo "<td></td>";
			}
			echo "<td>$style</td>";
			echo "<td>$schedule</td>";
			echo "<td>$color</td>";
			$row_ref=array();
			for($q1=0;$q1<sizeof($unique_orginal_sizes_explode);$q1++)
			{	
				$falg=0;
				$size_code_or=$unique_orginal_sizes_explode[$q1];
				for($q2=0;$q2<sizeof($unique_sizes_explode);$q2++)
				{
					
					$sql61="select sum(order_s_".$unique_sizes_explode[$q2].") as order_qty,title_size_".$unique_sizes_explode[$q2]." as size,destination from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no=\"".$schedule."\"";	
					$result61=mysqli_query($link, $sql61) or die("Error3 = ".$sql61.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row61=mysqli_fetch_array($result61))
					{	
						$size_code=$row61["size"];
						$size_code_ref_val=$unique_sizes_explode[$q2];
						$destination=$row61["destination"];
						if($size_code == $size_code_or)
						{
							echo "<td>".$row61["order_qty"]."</td>";
							$row_ref[]=$row61["order_qty"]."";
							$falg=1;
						}	
					}										
				}
				if($falg==0)
				{
					echo "<td>0</td>";
					$row_ref[]="0";
				}			
				
			}
			$sql3="insert into $bai_pro3.orders_club_schedule(order_del_no,order_col_des,destination,size_code,orginal_size_code,order_qty) values(\"".$schedule."\",\"".$color."\",\"".$destination."\",\"".$unique_orginal_sizes."\",\"".$unique_sizes."\",\"".implode(",",$row_ref)."\")";
			//echo $sql3."<br>";
			mysqli_query($link, $sql3) or die("Error3 = ".$sql3.mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<td>$order_total</td>";
			echo "</tr>";
		}
		echo "</table>";	
		$sql4="SELECT DISTINCT size_code as size_code FROM $bai_pro3.`orders_club_schedule` where order_del_no in (".implode(",",$schedule_array).") ORDER BY size_code";
		$result4=mysqli_query($link, $sql4) or die("Error3 = ".$sql61.mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row4=mysqli_fetch_array($result4))
		{
			$size_code_ref=$row4["size_code"];
		}	
		echo '<input type="hidden" name="style" value="'.$style.'">';
		echo '<input type="hidden" name="schedule" value="'.$schedule.'">';
		echo '<input type="hidden" name="color" value="'.$color.'">';
		echo '<input type="hidden" name="exfact" value="'.$exfact.'">';
		echo '<input type="hidden" name="po" value="'.$po.'">';
		if($test_count>=1)
		{
			echo "<input type=\"submit\" class='btn btn-success btn-sm' value=\"confirm\" name=\"fix\"  id=\"confirm\" onclick=\"document.getElementById('confirm').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
			echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait data is processing...!<h5></span>";
		}
		
		echo '</form>';
		
		$row_count=0;
		echo "<br>";
		echo "<h4>Clubbed Schedule Details</h4>";
		$sql452="select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$style."' and order_col_des=\"".$color."\" and order_joins in (1,2)";
		$sql_result452=mysqli_query($link, $sql452) or die("Error".$sql452.mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result452)>0)
		{
			while($sql_row452=mysqli_fetch_array($sql_result452))
			{
				$row_count++;
				echo "<table class='table table-responsive table-bordered'>
						<tr class='info'>
							<th>Style </th><th>Schedule No</th>
							<th>Color</th><th>Orginal schedules</th>";
				for($kl=0;$kl<sizeof($size_array);$kl++)
				{
					if($sql_row452["title_size_".$size_array[$kl].""]<>'')
					{
						$sizes_code_tmp[]=$size_array[$kl];
						echo "<th>".$sql_row452["title_size_".$size_array[$kl].""]."</th>";
					}			
				}
				echo "</tr>";
				echo "<tr><td>".$sql_row452["order_style_no"]."</td><td>".$sql_row452["order_del_no"]."</td><td>".$sql_row452["order_col_des"]."</td>";
				$sql453="select group_concat(order_del_no)  as org_sch from $bai_pro3.bai_orders_db_confirm where order_joins='J".$sql_row452["order_del_no"]."' and order_col_des=\"".$color."\"";
				$sql_result453=mysqli_query($link, $sql453) or die("Error".$sql452.mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row453=mysqli_fetch_array($sql_result453))
				{		
					echo "<td>".$sql_row453["org_sch"]."</td>";
				}
				for($kll=0;$kll<sizeof($sizes_code_tmp);$kll++)
				{
					echo "<td>".$sql_row452["order_s_".$sizes_code_tmp[$kll].""]."</td>";
				}
				unset($sizes_code_tmp);
				echo "</tr>";
				echo "</table>";
				echo "<br>";
			}
		}
		if($row_count == 0){
			echo "<b style='color:#ff0000'>No data Found</b>";
		}
	}
	else
	{
		echo "<h3 style='color:#ff0000'>Still Order quantity not updated</h3>";
	}
}
?>

<?php

if(isset($_POST['fix']))
{
	$selected=$_POST['sch'];
	$style=$_POST['style'];
	$new_sch=date("ymds").rand(10,99);
	$color=$_POST['color'];
	$exfact=$_POST['exfact'];
	$po=$_POST['po'];
	
	$size_array1=array();
	$orginal_size_array1=array();
	$schedule_array=array();
	
	for($q1=0;$q1<sizeof($sizes_array);$q1++)
	{
		for($x1=0;$x1<sizeof($selected);$x1++)
		{
			$sql62="select order_del_no,sum(order_s_".$sizes_array[$q1].") as order_qty,title_size_".$sizes_array[$q1]." as size from $bai_pro3.bai_orders_db where order_col_des=\"$color\" and order_del_no='".$selected[$x1]."' group by order_del_no order by order_style_no,order_del_no";
			$result62=mysqli_query($link, $sql62) or die("Error3 = ".$sql62.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row62=mysqli_fetch_array($result62))
			{	
				$schedule_array[]=$selected[$x1];
				if($row62["size"] <> '')
				{
					if(!in_array($sizes_array[$q1],$size_array1))
					{
						$size_array1[]=$sizes_array[$q1];
					}	
					if(!in_array($row62["size"],$orginal_size_array1))
					{
						$orginal_size_array1[]=$row62["size"];
					}
				}
			}
		}
	}
	sort($orginal_size_array1);
	sort($size_array1);
	
	$unique_orginal_sizes1=implode(",",array_unique($orginal_size_array1));
	$unique_sizes1=implode(",",array_unique($size_array1));
	//echo $unique_orginal_sizes1."---".$unique_sizes1."<br>";
	$unique_orginal_sizes_explode1=explode(",",$unique_orginal_sizes1);
	$unique_sizes_explode1=explode(",",$unique_sizes1);

	$po_code=substr($exfact,-2);
	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_joins in (1,2) and order_col_des=\"$color\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$tot_ext_count=mysqli_num_rows($sql_result);
	$tot_ext_count++;
	if(sizeof($selected)>=1)
	{
		//To find new color code 
		$sql="select max(color_code) as new_color_code from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\"";
		echo $sql."<bR>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$new_color_code=($sql_row['new_color_code']);
		}
		
		$sql1="delete from $bai_pro3.bai_orders_db_club where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
		//echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="insert ignore into $bai_pro3.bai_orders_db_club select * from $bai_pro3.bai_orders_db where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
		//echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql1="insert ignore into $bai_pro3.bai_orders_db_confirm select * from $bai_pro3.bai_orders_db where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
		//echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		//New to eliminate issues 2012
		$sql17="SELECT order_tid,order_tid2,COUNT(*) AS cnt FROM $bai_pro3.cat_stat_log WHERE order_tid IN (SELECT order_tid FROM $bai_pro3.bai_orders_db WHERE order_del_no IN 
		('".implode("','",$selected)."') AND order_col_des='$color') GROUP BY order_tid ORDER BY cnt DESC LIMIT 1"; 
        //echo $sql17."<br>";
	    $sql_result17=mysqli_query( $link, $sql17) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row17=mysqli_fetch_array($sql_result17)) 
        { 
			$sql="select * from $bai_pro3.cat_stat_log csl
					left join $bai_pro3.bai_orders_db bdb on bdb.order_tid = csl.order_tid 
					where csl.order_tid='".$sql_row17["order_tid"]."'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$style=$sql_row['order_style_no'];
				$color=$sql_row['order_col_des'];
				$order_tid=$sql_row['order_tid'];
				$delivery=$sql_row['order_del_no'];
				$tid=str_replace($sql_row['order_del_no'],$new_sch,$sql_row['order_tid']);
				$tid2=str_replace($sql_row['order_del_no'],$new_sch,$sql_row['order_tid2']);
				$com_no=$sql_row['compo_no'];
				$sql1="insert ignore into $bai_pro3.cat_stat_log (order_tid,order_tid2,catyy,fab_des,col_des,mo_status,compo_no) values (\"".$tid."\",\"".$tid2."\",".$sql_row['catyy'].",\"".$sql_row['fab_des']."\",\"".$sql_row['col_des']."\",\"Y\",\"$com_no\")";
				mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}

		if(mysqli_num_rows($sql_result)>0)
		{
			//echo $new_sch."<br>";
			$sql1="insert ignore into $bai_pro3.bai_orders_db(order_tid,order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,color_code,order_joins,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no,order_s_s01,order_s_s02,order_s_s03,order_s_s04,order_s_s05,order_s_s06,order_s_s07,order_s_s08,order_s_s09,order_s_s10,order_s_s11,order_s_s12,order_s_s13,order_s_s14,order_s_s15,order_s_s16,order_s_s17,order_s_s18,order_s_s19,order_s_s20,order_s_s21,order_s_s22,order_s_s23,order_s_s24,order_s_s25,order_s_s26,order_s_s27,order_s_s28,order_s_s29,order_s_s30,order_s_s31,order_s_s32,order_s_s33,order_s_s34,order_s_s35,order_s_s36,order_s_s37,order_s_s38,order_s_s39,order_s_s40,order_s_s41,order_s_s42,order_s_s43,order_s_s44,order_s_s45,order_s_s46,order_s_s47,order_s_s48,order_s_s49,order_s_s50,old_order_s_s01,old_order_s_s02,old_order_s_s03,old_order_s_s04,old_order_s_s05,old_order_s_s06,old_order_s_s07,old_order_s_s08,old_order_s_s09,old_order_s_s10,old_order_s_s11,old_order_s_s12,old_order_s_s13,old_order_s_s14,old_order_s_s15,old_order_s_s16,old_order_s_s17,old_order_s_s18,old_order_s_s19,old_order_s_s20,old_order_s_s21,old_order_s_s22,old_order_s_s23,old_order_s_s24,old_order_s_s25,old_order_s_s26,old_order_s_s27,old_order_s_s28,old_order_s_s29,old_order_s_s30,old_order_s_s31,old_order_s_s32,old_order_s_s33,old_order_s_s34,old_order_s_s35,old_order_s_s36,old_order_s_s37,old_order_s_s38,old_order_s_s39,old_order_s_s40,old_order_s_s41,old_order_s_s42,old_order_s_s43,old_order_s_s44,old_order_s_s45,old_order_s_s46,old_order_s_s47,old_order_s_s48,old_order_s_s49,old_order_s_s50) select \"".$style.$new_sch.$color."\",order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,$new_sch,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,$new_color_code,1,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			//echo $sql1."<br><br>";
			mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql1="update $bai_pro3.bai_orders_db set order_joins=\"J$new_sch\" where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//New to eliminate issues 2012
			$sql1="insert ignore into $bai_pro3.bai_orders_db_confirm(order_tid,order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,color_code,order_joins,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no,order_s_s01,order_s_s02,order_s_s03,order_s_s04,order_s_s05,order_s_s06,order_s_s07,order_s_s08,order_s_s09,order_s_s10,order_s_s11,order_s_s12,order_s_s13,order_s_s14,order_s_s15,order_s_s16,order_s_s17,order_s_s18,order_s_s19,order_s_s20,order_s_s21,order_s_s22,order_s_s23,order_s_s24,order_s_s25,order_s_s26,order_s_s27,order_s_s28,order_s_s29,order_s_s30,order_s_s31,order_s_s32,order_s_s33,order_s_s34,order_s_s35,order_s_s36,order_s_s37,order_s_s38,order_s_s39,order_s_s40,order_s_s41,order_s_s42,order_s_s43,order_s_s44,order_s_s45,order_s_s46,order_s_s47,order_s_s48,order_s_s49,order_s_s50,old_order_s_s01,old_order_s_s02,old_order_s_s03,old_order_s_s04,old_order_s_s05,old_order_s_s06,old_order_s_s07,old_order_s_s08,old_order_s_s09,old_order_s_s10,old_order_s_s11,old_order_s_s12,old_order_s_s13,old_order_s_s14,old_order_s_s15,old_order_s_s16,old_order_s_s17,old_order_s_s18,old_order_s_s19,old_order_s_s20,old_order_s_s21,old_order_s_s22,old_order_s_s23,old_order_s_s24,old_order_s_s25,old_order_s_s26,old_order_s_s27,old_order_s_s28,old_order_s_s29,old_order_s_s30,old_order_s_s31,old_order_s_s32,old_order_s_s33,old_order_s_s34,old_order_s_s35,old_order_s_s36,old_order_s_s37,old_order_s_s38,old_order_s_s39,old_order_s_s40,old_order_s_s41,old_order_s_s42,old_order_s_s43,old_order_s_s44,old_order_s_s45,old_order_s_s46,old_order_s_s47,old_order_s_s48,old_order_s_s49,old_order_s_s50) select \"".$style.$new_sch.$color."\",order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,$new_sch,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,$new_color_code,1,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			mysqli_query($link, $sql1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo "2=".$sql1."<br><br>";
			$sql1="update $bai_pro3.bai_orders_db_confirm set order_joins=\"J$new_sch\" where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			/*
			for($q11=0;$q11<sizeof($unique_orginal_sizes_explode1);$q11++)
			{	
				$falg1=0;
				$size_code_or1=$unique_orginal_sizes_explode1[$q11];
				for($q21=0;$q21<sizeof($unique_sizes_explode1);$q21++)
				{
					$sql611="select sum(order_s_".$unique_sizes_explode1[$q21].") as order_qty,title_size_".$unique_sizes_explode1[$q21]." as size,
					order_del_no from bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no in (".implode(",",$selected).") group by order_del_no";	
					$result611=mysql_query($sql611,$link) or die("Error3 = ".$sql611.mysql_error());
					while($row611=mysql_fetch_array($result611))
					{	
						$size_code1=$row611["size"];
						if($size_code1 == $size_code_or1)
						{
							$sql12="update bai_orders_db set order_s_".$sizes_array[$q11]."=order_s_".$sizes_array[$q11]."+".$row611["order_qty"].",old_order_s_".$sizes_array[$q11]."=old_order_s_".$sizes_array[$q11]."+".$row611["order_qty"].",title_size_".$sizes_array[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_del_no=$new_sch";
							mysql_query($sql12,$link) or die("Error112 = ".$sql12.mysql_error());
							//echo "<br>S-1=".$sql12."<br>";	
							$sql121="update bai_orders_db_confirm set order_s_".$sizes_array[$q11]."=order_s_".$sizes_array[$q11]."+".$row611["order_qty"].",old_order_s_".$sizes_array[$q11]."=old_order_s_".$sizes_array[$q11]."+".$row611["order_qty"].",title_size_".$sizes_array[$q11]."=\"".$unique_orginal_sizes_explode1[$q11]."\",title_flag=1  where order_del_no=$new_sch";
						    mysql_query($sql121,$link) or die("Error112 = ".$sql121.mysql_error());
						}	
					}										
				}				
			}		
			*/
			$sql45="select * from $bai_pro3.orders_club_schedule where order_del_no in (".implode(",",$selected).") and order_col_des=\"".$color."\"";
			//echo $sql45."<br>";
			$sql_result45=mysqli_query($link, $sql45) or die("Error".$sql45.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row45=mysqli_fetch_array($sql_result45))
			{
				$order_del_no_ref=$sql_row45["order_del_no"];
				$size_code_ref=$sql_row45["size_code"];
				$original_size_code_ref=$sql_row45["orginal_size_code"];
				$order_col_des_ref=$sql_row45["order_col_des"];
				$destination_ref=$sql_row45["destination"];
				$order_qty_ref=$sql_row45["order_qty"];
				
				$original_size_code_ref_explode=explode(",",$original_size_code_ref);
				$order_qty_ref_explode=explode(",",$order_qty_ref);
				$size_code_ref_explode=explode(",",$size_code_ref);
				
				for($i1=0;$i1<sizeof($original_size_code_ref_explode);$i1++)
				{
					//echo $original_size_code_ref_explode[$i1]."<br>";
					$sql46="update $bai_pro3.bai_orders_db set order_s_".$original_size_code_ref_explode[$i1]."=".$order_qty_ref_explode[$i1].",old_order_s_".$original_size_code_ref_explode[$i1]."=".$order_qty_ref_explode[$i1].",title_size_".$original_size_code_ref_explode[$i1]."=\"".$size_code_ref_explode[$i1]."\" where order_del_no=\"".$order_del_no_ref."\" and order_col_des=\"".$order_col_des_ref."\"";
					//echo $sql46."<br>";
					mysqli_query($link, $sql46) or die("Error".$sql46.mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql47="update $bai_pro3.bai_orders_db_confirm set order_s_".$original_size_code_ref_explode[$i1]."=".$order_qty_ref_explode[$i1].",old_order_s_".$original_size_code_ref_explode[$i1]."=".$order_qty_ref_explode[$i1].",title_size_".$original_size_code_ref_explode[$i1]."=\"".$size_code_ref_explode[$i1]."\" where order_del_no=\"".$order_del_no_ref."\" and order_col_des=\"".$order_col_des_ref."\"";
					//echo $sql47."<br>";
					mysqli_query($link, $sql47) or die("Error".$sql47.mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$sql121="update $bai_pro3.bai_orders_db_confirm set order_s_".$original_size_code_ref_explode[$i1]."=order_s_".$original_size_code_ref_explode[$i1]."+".$order_qty_ref_explode[$i1].",old_order_s_".$original_size_code_ref_explode[$i1]."=old_order_s_".$original_size_code_ref_explode[$i1]."+".$order_qty_ref_explode[$i1].",title_size_".$original_size_code_ref_explode[$i1]."=\"".$size_code_ref_explode[$i1]."\",title_flag=1  where order_del_no='$new_sch'";
				   mysqli_query($link, $sql121) or die("Error112 = ".$sql121.mysqli_error($GLOBALS["___mysqli_ston"]));
				   $sql121="update $bai_pro3.bai_orders_db set order_s_".$original_size_code_ref_explode[$i1]."=order_s_".$original_size_code_ref_explode[$i1]."+".$order_qty_ref_explode[$i1].",old_order_s_".$original_size_code_ref_explode[$i1]."=old_order_s_".$original_size_code_ref_explode[$i1]."+".$order_qty_ref_explode[$i1].",title_size_".$original_size_code_ref_explode[$i1]."=\"".$size_code_ref_explode[$i1]."\",title_flag=1  where order_del_no='$new_sch'";
				   mysqli_query($link, $sql121) or die("Error112 = ".$sql121.mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
			}
			$sql451="insert ignore into $bai_pro3.bai_orders_db_club_confirm select * from $bai_pro3.bai_orders_db_confirm where order_del_no in (".implode(",",$schedule_array).") and order_col_des=\"".$color."\"";
			$sql451=mysqli_query($link, $sql451) or die("Error".$sql451.mysqli_error($GLOBALS["___mysqli_ston"]));
					
			
			echo "<h2>New Style: $style</h2>";
			echo "<h2>New Schedule: $new_sch</h2>";
			echo "<h2>New Color: $color</h2>";
			echo "<h2>Successfully Completed.</h2>";	
			
			$sql451="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='".$new_sch."' and order_col_des=\"".$color."\" ";
			$sql_result451=mysqli_query($link, $sql451) or die("Error".$sql451.mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result451)>0)
			{
				while($sql_row451=mysqli_fetch_array($sql_result451))
				{
					echo "<table class='table table-bordered table-responsive'><tr class='info'><th>Style </th><th>Schedule No</th><th>Color</th><th> Orginal schedules</th>";
					for($kk=0;$kk<sizeof($sizes_array);$kk++)
					{
						if($sql_row451["title_size_".$sizes_array[$kk].""]<>'')
						{
							$sizes_code_tmp[]=$sizes_array[$kk];
							echo "<th>".$sql_row451["title_size_".$sizes_array[$kk].""]."</th>";
						}			
					}
					echo "</tr>";
					echo "<tr><td>".$sql_row451["order_style_no"]."</td><td>".$sql_row451["order_del_no"]."</td><td>".$sql_row451["order_col_des"]."</td>";
					$sql457="select group_concat(order_del_no)  as org_sch from $bai_pro3.bai_orders_db_confirm where order_joins='J".$new_sch."' and order_col_des=\"".$color."\"";
					$sql_result457=mysqli_query($link, $sql457) or die("Error".$sql457.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row457=mysqli_fetch_array($sql_result457))
					{		
						echo "<td>".$sql_row457["org_sch"]."</td>";
					}
					for($kkk=0;$kkk<sizeof($sizes_code_tmp);$kkk++)
					{
						echo "<td>".$sql_row451["order_s_".$sizes_code_tmp[$kkk].""]."</td>";
					}
					echo "</tr>";
					echo "</table>";
					echo "<br>";
				}
			}
			
		}																								
		else
		{
			echo "<script>swal('Please upload order status for selected schedules.','','warning');</script>";
		}
	}
	else
	{
		echo "<script>swal('Please select more than one schedule for clubbing.','','warning');";
	}
	
}

?>

	</div><!-- panel body -->
</div><!-- panel -->