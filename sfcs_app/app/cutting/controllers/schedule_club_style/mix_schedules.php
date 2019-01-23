<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>

<?php $self_url = 'index.php?r='.$_GET['r']; ?>
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
	$color=$_GET['color'];
	if(isset($_POST['submit']))
	{
		$style=$_POST['style'];
		$color=$_POST['color'];
	}

//echo $style.$schedule.$color;
?>
<div class='panel panel-primary'>
	<div class='panel panel-heading'>Schedule Clubbing (Schedule Level)</div>
	<div class='panel-body'>
		<form name="test" action="index.php?r=<?= $_GET['r'] ?>" method="post">
		<?php	

		echo "<div class='col-sm-3'>";
			$sql = "select distinct order_style_no from $bai_pro3.bai_orders_db order by order_style_no";
			$sql_result=mysqli_query($link,$sql) or exit("Sql Error 1".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<label for='style'>Select Style</label>
			<select  class='form-control' name='style' onchange='firstbox();' required>";
			echo "<option value=''>Please Select</option>";
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
	<select  class='form-control' name='color' required>";

	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));
	echo "<option value=''>Please Select</option>";
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
	echo "<div class='col-sm-1'>";
	echo "<label></label><br/>";
	echo "<input type='submit' class='btn btn-success' value='Submit' name='submit'>";
echo "</div>";

?>


</form>
<br/>
<br/>


<?php
if(isset($_POST['submit']) || $_GET['color']<>'')
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	if($_GET['color']<>'')
	{
		$style=$_GET['style']; 
		$color=$_GET['color']; 
	}
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
	sort(array_unique($orginal_size_array));
	sort(array_unique($size_array));
	$rand_no=date("ymd").rand(1,1000);
	$tabl="temp_pool_db.new_tbl".$rand_no."";
	$sql76="CREATE TEMPORARY TABLE $tabl SELECT * FROM brandix_bts.`tbl_orders_size_ref` LIMIT 1";
	mysqli_query($link,$sql76) or die("Error 1 = ".$sql76.mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql77="DELETE FROM $tabl";
	mysqli_query($link,$sql77) or die("Error 2 = ".$sql77.mysqli_error($GLOBALS["___mysqli_ston"]));
	for($qi=0;$qi<sizeof($orginal_size_array);$qi++)
	{
		$sql78="INSERT INTO $tabl (`size_name`) VALUES ('".$orginal_size_array[$qi]."')";
		mysqli_query($link,$sql78) or die("Error 3 = ".$sql77.mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	$sql79="SELECT * FROM $tabl ORDER BY CONVERT(bai_pro3.stripSpeciaChars(size_name,0,1,0,0) USING utf8)*1,
	FIELD(size_name,'xxs','xs','s','m','l','xl','xxl','xxxl','xxxxl')";
	$result79=mysqli_query($link,$sql79) or die("Error 4 = ".$sql79.mysqli_error($GLOBALS["___mysqli_ston"]));
	unset($orginal_size_array);
	while($row79=mysqli_fetch_array($result79))
	{
		$orginal_size_array[]=$row79['size_name'];
	}
	$sql80="DROP TABLE $tabl";
	mysqli_query($link,$sql80) or die("Error 3 = ".$sql80.mysqli_error($GLOBALS["___mysqli_ston"]));

	if(sizeof($orginal_size_array)<>sizeof($size_array))
	{
		for($qq=0;$qq<sizeof($sizes_array);$qq++)
		{
			if(sizeof($orginal_size_array)<>sizeof($size_array))
			{
				if(!in_array($sizes_array[$qq],$size_array))
				{
					$size_array[]=$sizes_array[$qq];
				}
			}
		}	
	}
	$unique_orginal_sizes=implode(",",$orginal_size_array);
	$unique_sizes=implode(",",$size_array);
	$unique_orginal_sizes_explode=explode(",",$unique_orginal_sizes);
	$unique_sizes_explode=explode(",",$unique_sizes);
	$size_type=1;
	echo "<h3><span class='label label-info' >Make sure selected items must be same Item Codes</span></h3><br>"; 
	echo "<form name='testnew' action='index.php?r=".$_GET['r']."' method='post'>";
	if(sizeof($size_array)>0)
	{
		echo "<table class='table table-bordered '>";
		echo "<tr class='warning'>";
		echo "<th>Select</th>";
		echo "<th>Item Codes</th>";
		echo "<th>MO Status</th>";
		echo "<th>Style</th>";
		echo "<th>Schedule</th>";
		echo "<th>Color</th>";
		for($q=0;$q<sizeof($unique_orginal_sizes_explode);$q++)
		{
			echo "<th>".$unique_orginal_sizes_explode[$q]."</th>";
		}	
		echo "<th>Total</th>";
		echo "</tr>";
		$sql="select * from $bai_pro3.bai_orders_db where $order_joins_not_in and order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no>0 order by order_style_no";		
		$test_count=0;
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error 4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num_rows = mysqli_num_rows($sql_result);
		if($num_rows>1){

		
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
			// Check Operaitons
			$ops_master_sql = "select operation_code as operation_code FROM $brandix_bts.tbl_style_ops_master where style='$style' and color='$color' and default_operration='yes' group by operation_code";
			$result2_ops_master_sql = mysqli_query($link,$ops_master_sql)
								or exit("Error Occured : Unable to get the Operation Codes");
			while($row_result2_ops_master_sql = mysqli_fetch_array($result2_ops_master_sql))
			{
				$array1[] = $row_result2_ops_master_sql['operation_code'];
			}			
			$sql1 = "select OperationNumber FROM $bai_pro3.schedule_oprations_master where Style='$style' and Description ='$color' and ScheduleNumber='$schedule' group by OperationNumber";
			$result1 = mysqli_query($link,$sql1)  
				or exit("Error Occured : Unable to get the Operation Codes");
		
			while($row = mysqli_fetch_array($result1))
			{
				$array2[] = $row['OperationNumber'];
			}
			$val1 = "<td></td>";
			$op_status_above=0;
			if(sizeof($array1) == 0 || sizeof($array2) == 0)
			{
				$val1 = "<td>Ops Doesn't exist</td>";
				$op_status_above=1;
			}
			$compare = array_diff($array1,$array2);
			if($op_status_above==0)
			{
				if(sizeof($compare) > 0)
				{
					$val1 = "<td>Ops codes not match</td>";
					$op_status_above=1;
				}
			}
			$mo_query = "SELECT * from $bai_pro3.mo_details where schedule='$schedule' and 
						color='$color'  and style='$style' limit 1";
			$mo_result = mysqli_query($link,$mo_query);	
			if($op_status_above==0)
			{
				if(!mysqli_num_rows($mo_result) > 0)
				{
					$val1 = "<td>MO Not Available</td>";
					$op_status_above=1;
				}
			}
			$tabl_name="bai_pro3.bai_orders_db";			
			if($order_total>0 && $op_status_above==0)
			{
				$sql41="select * FROM $bai_pro3.`plandoc_stat_log` where order_tid='".$order_tid."'";
				$result41=mysqli_query($link,$sql41) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($result41)==0)
				{
					if($order_joins=="0")
					{
						$sql543111="select * from $bai_pro3.cat_stat_log where order_tid='".$order_tid."'";
						$result41111=mysqli_query($link, $sql543111) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
						$sql54311="select * from $bai_pro3.cat_stat_log where order_tid='".$order_tid."' and mo_status='N'";
						$result4111=mysqli_query($link, $sql54311) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"])); 
						if(mysqli_num_rows($result4111)==0 && mysqli_num_rows($result41111)>0) 
						{
							$sql5431112="select * from $bai_pro3.bai_orders_db_confirm where order_tid='".$order_tid."'";
							$result411112=mysqli_query($link, $sql5431112) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
							if(mysqli_num_rows($result411112)==0)
							{
								echo "<td><input type=\"checkbox\" name=\"sch[]\" value=\"$schedule\" check></td>";
							}
							else
							{
								$tabl_name="bai_pro3.bai_orders_db_confirm";
								echo "<td>Excess Updated</td>";
							}	
						}
						else							
						{
							$sql543112="select * from $bai_pro3.cat_stat_log where order_tid='".$order_tid."'";
							$result41112=mysqli_query($link, $sql543112) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"])); 
							if(mysqli_num_rows($result41112)==0)
							{
								echo "<td>Items Not Available</td>";
							}
							else
							{
								echo "<td>N/A</td>";
							}	
						}
						$test_count=$test_count+1;
					}
					else
					{
						$tabl_name="bai_pro3.bai_orders_db_confirm";
						$sql5431112="select * from $bai_pro3.bai_orders_db_confirm where order_tid='".$order_tid."' and order_no=1";
						$result411112=mysqli_query($link, $sql5431112) or die("Error3 = ".$sql4.mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($result411112)==0)
						{
							echo "<td>".substr($order_joins,1)."</td>";
						}
						else
						{							
							echo "<td>Excess Updated-(".substr($order_joins,1).")</td>";
						}
					}
				}
				else
				{
					$tabl_name="bai_pro3.bai_orders_db_confirm";
					echo "<td>Lay Plan Prepared</td>";
				}
				
			}
			else  
			{ 
				echo $val1; 
			}
			echo "<td>";				
			echo "<table>";					
			$sql5431="select compo_no from $bai_pro3.cat_stat_log where order_tid='".$order_tid."' group by compo_no";
			//echo $sql543."<br>";		
			$sql_result5431=mysqli_query($link, $sql5431) or exit("Sql Error A".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row5431=mysqli_fetch_array($sql_result5431)) 
			{ 
				echo "<tr><td>".$sql_row5431['compo_no']."</td>";
			}
			echo "</table>";
			echo "</td>";
			echo "<td>";
			echo "<table>";					
			$sql543="select mo_status from $bai_pro3.cat_stat_log where order_tid='".$order_tid."' group by compo_no";
			//echo $sql543."<br>";		
			$sql_result543=mysqli_query($link, $sql543) or exit("Sql Error A".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row543=mysqli_fetch_array($sql_result543)) 
			{ 
				echo "<tr><td>".$sql_row543['mo_status']."</td>";
			}
			echo "</table>";
			echo "</td>";
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
					
					$sql61="select sum(order_s_".$unique_sizes_explode[$q2].") as order_qty,title_size_".$unique_sizes_explode[$q2]." as size,destination from $tabl_name where order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no=\"".$schedule."\"";	
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
		
		$row_count=0;
		echo "<br>";
		
		$sql452="select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$style."' and order_col_des=\"".$color."\" and $order_joins_in";
		//echo $sql452."<br>";
		$sql_result452=mysqli_query($link, $sql452) or die("Error".$sql452.mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result452)>0)
		{
			echo "<h4>Clubbed Schedule Details</h4>";
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
		echo "<br><br>";
		if($test_count>=1)
		{
			echo "<input type=\"submit\" class='btn btn-success btn-sm' value=\"Confirm\" name=\"fix\"  id=\"confirm\" onclick=\"document.getElementById('confirm').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
			echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait data is processing...!<h5></span>";
		}		
		echo '</form>';
		}else{
			echo "<script>swal('Warning!','This style doesn't have more than 1 schedule so it cannot be clubbed','warning')</script>";
			exit();
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
	$color=$_POST['color'];
	$exfact=$_POST['exfact'];
	$po=$_POST['po'];

	//Generarting new schedule number for schedule clubbing style
	$val_exist_club=0;
	$scheduleno_sql1 = "SELECT MAX(order_del_no) AS sch FROM $bai_pro3.bai_orders_db_confirm WHERE $order_joins_in and order_del_no like  \"%".date("ymd")."%\"";
	$scheduleno_sql_result1 =mysqli_query($link, $scheduleno_sql1);
	while($row123=mysqli_fetch_array($scheduleno_sql_result1))
	{
		$val_exist_club = ((substr($row123["sch"], 6))+2);
	}
	$new_sch=date("ymd").str_pad($val_exist_club, 5, '0', STR_PAD_LEFT);
	
	$size_array1=array();
	$orginal_size_array1=array();
	$compo_no=array();
	$schedule_array=array();

	if(sizeof($selected)<2)
	{
		echo "<script>swal('Warning!','Please select more than one schedule for clubbing.','warning');</script>"; 
		//write redirection for the style and color here
		exit();
	}
	$schedule_array=explode(",",implode(",",$selected));
	$sql62="select * from $bai_pro3.orders_club_schedule where order_col_des='$color' and order_del_no in (".implode(",",$selected).") limit 1";
	$result62=mysqli_query($link, $sql62) or die("Error3 = ".$sql62.mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row62=mysqli_fetch_array($result62))
	{				
		$unique_orginal_sizes1=$row62["size_code"];
		$unique_sizes1=$row62["orginal_size_code"];
	}
	$unique_orginal_sizes_explode1=explode(",",$unique_orginal_sizes1);
	$unique_sizes_explode1=explode(",",$unique_sizes1);
	
	if(sizeof($selected)>1)
	{
		//To find new color code 
		$sql="select min(color_code) as new_color_code from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_col_des=\"$color\" and order_del_no in (".implode(",",$selected).")";	
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$new_color_code=$sql_row['new_color_code'];
		}
		
		// Validate Components are equal then only club the schedules
		$sql17="SELECT order_tid,COUNT(*) AS cnt FROM $bai_pro3.cat_stat_log WHERE order_tid IN (SELECT order_tid FROM bai_orders_db WHERE order_del_no IN 
		('".implode("','",$selected)."') AND  order_col_des='$color') GROUP BY order_tid ORDER BY cnt DESC LIMIT 1"; 
		$sql_result17=mysqli_query($link, $sql17) or exit("Sql Error C".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row17=mysqli_fetch_array($sql_result17)) 
		{ 
			$order_tid=$sql_row17['order_tid'];
			$sql11="SELECT * from $bai_pro3.bai_orders_db where order_tid='$order_tid'"; 
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error B".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row11=mysqli_fetch_array($sql_result11)) 
			{ 
				$order_col_dess=$sql_row11['order_col_des'];
				//$new_color_code=$sql_row11['color_code'];
			}
		}
		if($order_tid<>'')
		{
			$sql="select * from $bai_pro3.cat_stat_log where order_tid='".$order_tid."'"; 
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error A".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result)) 
			{ 
				$compo_no[]=$sql_row['compo_no'];
			}
			$status=0;
			for($kl=0;$kl<sizeof($selected);$kl++)
			{
				$sql12="SELECT COUNT(*) AS cnt FROM $bai_pro3.cat_stat_log WHERE order_tid IN (SELECT order_tid FROM bai_orders_db WHERE order_del_no='".$selected[$kl]."' AND  order_col_des='$color') and compo_no in ('".implode("','",$compo_no)."')"; 
				$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error A".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row12=mysqli_fetch_array($sql_result12)) 
				{
					$cnt=$sql_row12['cnt'];
				}
				if($cnt<>sizeof($compo_no))
				{
					$status=1;
				}
			}	
		}
		else
		{
			$status=1;
		}	
		if($status==0) 
		{			
			$sql="select * from $bai_pro3.cat_stat_log csl
					left join $bai_pro3.bai_orders_db bdb on bdb.order_tid = csl.order_tid 
					where csl.order_tid='".$order_tid."'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Erro5777r".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			
			$sql1="delete from $bai_pro3.bai_orders_db_club where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			//echo $sql1."<br>";
			mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql1="insert ignore into $bai_pro3.bai_orders_db_club select * from $bai_pro3.bai_orders_db where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			//echo $sql1."<br>";
			mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql1="insert ignore into $bai_pro3.bai_orders_db_confirm select * from $bai_pro3.bai_orders_db where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			//echo $sql1."<br>";
			mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $new_sch."<br>";
			$sql1="insert ignore into $bai_pro3.bai_orders_db(order_tid,order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,color_code,order_joins,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no,order_s_s01,order_s_s02,order_s_s03,order_s_s04,order_s_s05,order_s_s06,order_s_s07,order_s_s08,order_s_s09,order_s_s10,order_s_s11,order_s_s12,order_s_s13,order_s_s14,order_s_s15,order_s_s16,order_s_s17,order_s_s18,order_s_s19,order_s_s20,order_s_s21,order_s_s22,order_s_s23,order_s_s24,order_s_s25,order_s_s26,order_s_s27,order_s_s28,order_s_s29,order_s_s30,order_s_s31,order_s_s32,order_s_s33,order_s_s34,order_s_s35,order_s_s36,order_s_s37,order_s_s38,order_s_s39,order_s_s40,order_s_s41,order_s_s42,order_s_s43,order_s_s44,order_s_s45,order_s_s46,order_s_s47,order_s_s48,order_s_s49,order_s_s50,old_order_s_s01,old_order_s_s02,old_order_s_s03,old_order_s_s04,old_order_s_s05,old_order_s_s06,old_order_s_s07,old_order_s_s08,old_order_s_s09,old_order_s_s10,old_order_s_s11,old_order_s_s12,old_order_s_s13,old_order_s_s14,old_order_s_s15,old_order_s_s16,old_order_s_s17,old_order_s_s18,old_order_s_s19,old_order_s_s20,old_order_s_s21,old_order_s_s22,old_order_s_s23,old_order_s_s24,old_order_s_s25,old_order_s_s26,old_order_s_s27,old_order_s_s28,old_order_s_s29,old_order_s_s30,old_order_s_s31,old_order_s_s32,old_order_s_s33,old_order_s_s34,old_order_s_s35,old_order_s_s36,old_order_s_s37,old_order_s_s38,old_order_s_s39,old_order_s_s40,old_order_s_s41,old_order_s_s42,old_order_s_s43,old_order_s_s44,old_order_s_s45,old_order_s_s46,old_order_s_s47,old_order_s_s48,old_order_s_s49,old_order_s_s50) select \"".$style.$new_sch.$color."\",order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,$new_sch,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,$new_color_code,1,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			//echo $sql1."<br><br>";
			mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql1="update $bai_pro3.bai_orders_db set order_joins='J".$new_sch."' where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//New to eliminate issues 2012
			$sql1="insert ignore into $bai_pro3.bai_orders_db_confirm(order_tid,order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,order_del_no,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,color_code,order_joins,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no,order_s_s01,order_s_s02,order_s_s03,order_s_s04,order_s_s05,order_s_s06,order_s_s07,order_s_s08,order_s_s09,order_s_s10,order_s_s11,order_s_s12,order_s_s13,order_s_s14,order_s_s15,order_s_s16,order_s_s17,order_s_s18,order_s_s19,order_s_s20,order_s_s21,order_s_s22,order_s_s23,order_s_s24,order_s_s25,order_s_s26,order_s_s27,order_s_s28,order_s_s29,order_s_s30,order_s_s31,order_s_s32,order_s_s33,order_s_s34,order_s_s35,order_s_s36,order_s_s37,order_s_s38,order_s_s39,order_s_s40,order_s_s41,order_s_s42,order_s_s43,order_s_s44,order_s_s45,order_s_s46,order_s_s47,order_s_s48,order_s_s49,order_s_s50,old_order_s_s01,old_order_s_s02,old_order_s_s03,old_order_s_s04,old_order_s_s05,old_order_s_s06,old_order_s_s07,old_order_s_s08,old_order_s_s09,old_order_s_s10,old_order_s_s11,old_order_s_s12,old_order_s_s13,old_order_s_s14,old_order_s_s15,old_order_s_s16,old_order_s_s17,old_order_s_s18,old_order_s_s19,old_order_s_s20,old_order_s_s21,old_order_s_s22,old_order_s_s23,old_order_s_s24,old_order_s_s25,old_order_s_s26,old_order_s_s27,old_order_s_s28,old_order_s_s29,old_order_s_s30,old_order_s_s31,old_order_s_s32,old_order_s_s33,old_order_s_s34,old_order_s_s35,old_order_s_s36,old_order_s_s37,old_order_s_s38,old_order_s_s39,old_order_s_s40,old_order_s_s41,old_order_s_s42,old_order_s_s43,old_order_s_s44,old_order_s_s45,old_order_s_s46,old_order_s_s47,old_order_s_s48,old_order_s_s49,old_order_s_s50) select \"".$style.$new_sch.$color."\",order_date,order_upload_date,order_last_mod_date,order_last_upload_date,order_div,order_style_no,$new_sch,order_col_des,order_col_code,order_cat_stat,order_cut_stat,order_ratio_stat,order_cad_stat,order_stat,Order_remarks,order_po_no,order_no,$new_color_code,1,packing_method,style_id,carton_id,carton_print_status,ft_status,st_status,pt_status,trim_cards,trim_status,fsp_time_line,fsp_last_up,order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f,order_embl_g,order_embl_h,destination,zfeature,co_no,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0 from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
			mysqli_query($link, $sql1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo "2=".$sql1."<br><br>";
			$sql1="update $bai_pro3.bai_orders_db_confirm set order_joins='J".$new_sch."' where order_del_no in (".implode(",",$selected).") and order_col_des=\"$color\"";
			mysqli_query($link, $sql1) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			
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
			
			$sql452="select * from $bai_pro3.bai_orders_db_confirm where order_del_no in (".implode(",",$selected).") and order_col_des=\"".$color."\"";
			$sql_result452=mysqli_query($link, $sql452) or die("Error".$sql452.mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row452=mysqli_fetch_array($sql_result452))
			{
				$sql453="select * from $bai_pro3.sp_sample_order_db where order_tid='".$sql_row452['order_tid']."'";
				$sql_result453=mysqli_query($link, $sql453) or die("Error".$sql452.mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result453)>0)
				{
					while($sql_row453=mysqli_fetch_array($sql_result453))
					{
						for($kk=0;$kk<sizeof($sizes_array);$kk++)
						{
							if((trim($sql_row452["title_size_".$sizes_array[$kk].""])==trim($sql_row453['size'])) && ($sizes_array[$kk]<>$sql_row453['sizes_ref']))
							{
								$sql_update="update `bai_pro3`.`sp_sample_order_db` set `sizes_ref` = '".$sizes_array[$kk]."' where `order_tid` = '".$sql_row452['order_tid']."' and `size` = '".$sql_row453['size']."' and `sizes_ref` = '".$sql_row453['sizes_ref']."'";
								mysqli_query($link, $sql_update) or die("Error".$sql_update.mysqli_error($GLOBALS["___mysqli_ston"]));
							}
						}	
					}	
				}				
			}	
					
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
				echo "<script>swal('Clubbing Completed Successfully.','','success');</script>";
				echo("<script>location.href = '".getFullURLLevel($_GET['r'],'mix_schedules.php',0,'N')."&style=$style&color=$color';</script>");				
			}			
		}																								
		else
		{
			echo "<script>swal('You cannot proceed Schedule Clubbing.','Some of the Item codes are not equal for selected Schedules.','warning');</script>";
			echo("<script>location.href = '".getFullURLLevel($_GET['r'],'mix_schedules.php',0,'N')."&style=$style&color=$color';</script>");
		}
	}
	else
	{
		echo "<script>swal('Please select more than one schedule for clubbing.','','warning');";
		echo("<script>location.href = '".getFullURLLevel($_GET['r'],'mix_schedules.php',0,'N')."&style=$style&color=$color';</script>");
	}
	
}

?>

	</div><!-- panel body -->
</div><!-- panel -->