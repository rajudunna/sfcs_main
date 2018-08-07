
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',2,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R') );  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R') );  ?>

<?php
if($_SERVER['SERVER_NAME']=="bainet")
{
	$view_access=user_acl("SFCS_0242",$username,1,$group_id_sfcs); 
}
else if($_SERVER['SERVER_NAME']=="bai2net")
{
	$view_access=user_acl("SFCS_0250",$username,1,$group_id_sfcs); 
}
else if($_SERVER['SERVER_NAME']=="bai3net")
{
	$view_access=user_acl("SFCS_0293",$username,1,$group_id_sfcs); 
}	
?>
<script>
	function firstbox()
	{
		var url = '<?= getFullURL($_GET['r'],'ratio_mapping.php','N'); ?>';
		var ajax_url = url+"&style="+document.ratio_mapping.style.value;Ajaxify(ajax_url);

	}

	function secondbox()
	{
		var url = '<?= getFullURL($_GET['r'],'ratio_mapping.php','N'); ?>';
		var ajax_url = url+"&style="+document.ratio_mapping.style.value+"&schedule="+document.ratio_mapping.schedule.value;
		Ajaxify(ajax_url);

	}

	function thirdbox()
	{
		var url = '<?= getFullURL($_GET['r'],'ratio_mapping.php','N'); ?>';
		var ajax_url = url+"&style="+document.ratio_mapping.style.value+"&schedule="+document.ratio_mapping.schedule.value;
		Ajaxify(ajax_url);

	}
</script>

<div class="panel panel-primary">
	<div class="panel-heading">Ratio Packing List Mapping</div>
	<div class="panel-body">
	<?php
		$style=$_GET['style'];
		$schedule=$_GET['schedule']; 
		$color=$_GET['color'];
	?>

		<form name="ratio_mapping" action="<?= getFullURL($_GET['r'],'ratio_mapping.php','N'); ?>" 
			  method="post" class="form-inline">
		<?php
			echo "<div class='form-group'><label>Select Style  :</label>  <select name=\"style\" onchange=\"firstbox();\" class='form-control'>";

			//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select order_tid from plandoc_stat_log)";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
				$sql="select distinct order_style_no from $bai_pro3.order_cat_doc_mix order by order_style_no";	
			//}
			mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			echo "<option value=\"NIL\" selected>NIL</option>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
				{
					echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
				}else{
					echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
				}
			}
			echo "</select></div>";
		?>

		<?php
			echo "&nbsp;&nbsp;<div class='form-group'><label>Select Schedule  : </label>  <select name=\"schedule\" onchange=\"secondbox();\" class='form-control'>";

			//$sql="select distinct order_style_no from bai_orders_db_confirm where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
			//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
			//{
			$sql="select distinct order_del_no from $bai_pro3.order_cat_doc_mix where order_style_no=\"$style\" order by order_del_no";	
				//echo $sql;
			//}
			mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			echo "<option value=\"NIL\" selected>NIL</option>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
				{
					echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
				}else{
					echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
				}
			}
			echo "</select></div>";
			$sql="select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\"";
				
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$order_tid=$sql_row['order_tid'];
			}

			$sql="select mo_status from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\"  and length(category)>0 and purwidth>0";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$mo_status=$sql_row['mo_status'];
				//echo $mo_status;
			}

			//$sql_al="";

			$sql_plan="SELECT * FROM $bai_pro3.allocate_stat_log WHERE order_tid LIKE \"% ".$schedule."%\" ";
			//echo $sql_plan;
			if($mo_status=="Y")
			{
				echo " &nbsp;&nbsp;<label>MO Status  : </label><span class='label label-success'><i class='fa fa-check-circle'></i>".$mo_status."es</span>";
				echo " <input type=\"submit\" value=\"submit\" name=\"submit\" onchange=\"thridbox();\" class='btn btn-primary'>";	
			}
			else
			{
				echo "&nbsp;&nbsp; <label>MO Status  : </label><span class='label label-danger'><i class='fa fa-times-circle'></i> No</span>";
						//echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";
			}
		?>

		<?php
			if(isset($_POST['submit']))
			{
				$style=$_POST['style'];
				$color=$_POST['color'];
				$sel_color=$_POST['sel_color'];
				$schedule=$_POST['schedule'];
				//echo "style :".$style."-- schedule:".$schedule."-- Sel color: ".$sel_color."-- color:".$color;
				
				//echo "style :".$style."-- schedule:".$schedule."-- Sel color: ".$sel_color."-- color:".$color;
				echo "<br/>";
				
					$sql1="SELECT * FROM $bai_pro3.ratio_input_update where style=\"$style\" and schedule=\"$schedule\" ";
					//echo $sql1;
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error:$sql1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check1=mysqli_num_rows($sql_result1);
					
					if($sql_num_check1>0)
					{
						echo "<hr><table class='table table-bordered'>";
						echo "<tr class='danger'><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Ratio Quantity</th><th>User Name</th> <th>Log Time</th></tr>";
						while($sql_row1=mysqli_fetch_array($sql_result1))
						{
							$ratio_style=$sql_row1['style'];
							$ratio_schedule=$sql_row1['schedule'];
							$ratio_color=$sql_row1['color'];
							$ratio_size=$sql_row1['size'];
							$ratio_qty=$sql_row1['ratio_qty'];
							$username=$sql_row1['username'];
							$log_time=$sql_row1['log_time'];
							//$sql="SELECT title_size_$ratio_size FROM bai_pro3.bai_orders_db_confirm where order_del_no=$schedule";
							//echo $sql;
							// $sql_result=mysqli_query($link, $sql) or exit("Sql Error:$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
							// $sql_num_check=mysqli_num_rows($sql_result);
							// $sql_row=mysqli_fetch_row($sql_result);
							// $ratio_size = $sql_row[0];
							echo "<tr><td>$ratio_style</td><td>$ratio_schedule</td><td>$ratio_color</td><td>$ratio_size</td><td>$ratio_qty</td><td>$username</td><td>$log_time</td></tr>";
						}
						
						echo "</table>";
					}
				else
				{
				$sql="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_del_no=$schedule";
				//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error:$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);
				//echo $sql_num_check;
				echo "<hr><table class='table table-bordered'>";
					echo "<tr class='danger'><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Ratio Quantity</th></tr>";
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					// var_dump($sql_row);
					$style=$sql_row['order_style_no'];
					$schedule=$sql_row['order_del_no'];
					$color=$sql_row['order_col_des'];
					$order_tid=$sql_row['order_tid'];
					//var_dump($sizes_array);
					foreach ($sizes_array as $key => $value)
					{
						$size = 'title_size_'.$sizes_array[$key];
						$order = 'order_s_'.$sizes_array[$key];
						if($sql_row[$order] != 0)
						{
							echo "<tr><input type=\"hidden\" name=\"style\" value=\"".$style."\" /><td>".$style."</td><input type=\"hidden\" name=\"schedule\" value=\"".$schedule."\" /><td>".$schedule."</td><input type=\"hidden\" name=\"color[]\" value=\"".$color."\" /><td>".$color."</td><input type=\"hidden\" name=\"size[]\" value=\"".$sql_row[$size]."\" /><td>".$sql_row[$size]."</td><td><input type=\"text\" class='form-control integer' name=\"ratio_qty[]\" value=\"".$sql_row[$order]."\" /></td><input type=\"hidden\" name=\"sfcs_size[]\" value=\"".$sizes_array[$key]."\" /><input type=\"hidden\" name=\"order_tid\" value=\"".$order_tid."\" /></tr>";
						}
						
					}
					//var_dump(array_filter($sizes_string_array));
				}
				echo "<tr><td></td><td></td><td></td><td></td><td><input type=\"submit\" value=\"Update\" style='background-color=\"#E6E6E7\"' name=\"update\" class=\"btn btn-primary btn-sm\"></td></tr>";
				}
				
				
				echo "</table>";
			}	
			?>
		</form>
	</div>
</div>


<?php
		$qty=array();
		$color=array();
		$size=array();
		$sfcs_size=array();
		if(isset($_POST['update']))
		{
			$style=$_POST['style'];
			$color=$_POST['color'];
			$schedule=$_POST['schedule'];
			$size=$_POST['size'];
			$qty=$_POST['ratio_qty'];
			$rand_track=rand(1, 1000000)+date("isu");
			$order_tid=$_POST['order_tid'];
			$sfcs_size=$_POST['sfcs_size'];
			for($i=0;$i<sizeof($qty);$i++)
			{ 
				 if($qty[$i] > '0')
				  {
					  $sql1="insert into $bai_pro3.ratio_input_update(style,schedule,size,color,ratio_qty,username,rand_track_no,order_tid,set_type,sfcs_size)values (\"$style\",\"$schedule\",\"$size[$i]\",\"$color[$i]\",\"$qty[$i]\",\"$username\",\"$rand_track\",\"$order_tid\",\"$set\",\"$sfcs_size[$i]\")" ;
					  //echo "<br/>".$sql1;
					  mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
				  }
			}	
			//echo "<hr><div class='alert alert-success' role='alert'>Carton Ratios Quantities successfully updated for this schedule. </div>";	 
			echo "<script>swal('Updated','Carton Ratios Quantities successfully updated for this schedule.','success')</script>";
		}

		?>

<style>
	th,td{
		text-align:center;
	}
</style>