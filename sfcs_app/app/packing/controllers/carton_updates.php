<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));	?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));	?>
<?php // include('..'.getFullURLLevel($_GET['r'],'menu_content.php',1,'R')); This file is not used here?>
<?php // include('..'.getFullURLLevel($_GET['r'],'functions.php',1,'R')); This file is not used here?>

<?php

	$view_access=user_acl("SFCS_0124",$username,1,$group_id_sfcs);

	function get_size($table_name,$field,$compare,$key,$link)
	{
		$sql="select $field as result from $bai_pro3.$table_name where $compare='$key'";
		//echo $sql;
		$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			return $sql_row['result'];
		}
		((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false);
	}
?>

<script language="javascript" type="text/javascript" 
		src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/tablefilter_en/table_filter.js',3,'R'); ?>">
</script>

<div class="panel panel-primary">
	<div class="panel-heading"><b>Create Carton Quantities</b></div>
	<div class="panel-body">
		<?php $path1 = getFullURL($_GET['r'],'carton_create.php','N'); ?>
		<a href="<?= $path1; ?>"><button class="btn btn-success">Create</button></a><br/><br/>

		<?php

		echo "<div class='table-responsive' style='overflow-y:scroll;max-height:600px;'>";
		echo '<table id="table1" class="mytable table table-hover table-bordered">';
		echo "<tr class='tblheading danger'>
				 <th>Style</th><th>Schedule</th><th>Pack Method</th><th>Size</th><th>Quantity</th>
				 <th>Status</th><th>Track Label Qty</th><th>SRP Qty</th><th>Control</th></tr>";

		//$sql="select * from carton_qty_chart";
		if(strtolower($username)=="amulyap" OR strtolower($username)=="kirang")
		{
			$sql="select * from $bai_pro3.carton_qty_chart where status=0";
		}
		else
		{
			$sql="select * from $bai_pro3.carton_qty_chart";
		}
		//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result);
		 
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			if($sql_row['status']==0)
			{
				$remarks="Active";
			}
			else
			{
				$remarks="In-Active";
			}
			
			
			for($i=0;$i<50;$i++)
			{
				$key1 = 's'.str_pad($i+1, 2, "0", STR_PAD_LEFT);
				$size[$i] = $key1;
				if($size[$i] !='' && $sql_row[$size[$i]] !=0){
					echo "<tr>";
					echo "<td>".$sql_row['user_style']."</td>";
					$schedule = $sql_row['user_schedule'];
					echo "<td>".$schedule."</td>";
					// echo "<td>".$sql_row['buyer']."</td>";
					echo "<td>".$sql_row['packing_method']."</td>";	
					$get_color = "SELECT title_size_".$key1." FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='".$sql_row['user_schedule']."' LIMIT 1";			
					$sql_color=mysqli_query($link, $get_color);
					$sql_num_check1=mysqli_num_rows($sql_color);
					if($sql_num_check1>0){				
						$color_des=mysqli_fetch_array($sql_color);				
						$sizek=$color_des[0];				
					}else{				
						$sizek="empty";
					}			
					echo "<td>".$sizek."</td>";		
					echo "<td>".$sql_row[$size[$i]]."</td>";
					echo "<td>$remarks</td><td>".$sql_row['track_qty']."</td><td>".$sql_row['srp_qty']."</td>";
					$path2 = getFullURL($_GET['r'],'carton_edit.php','N');
					echo "<td><a href=".$path2."&id=".$sql_row['id']."&in_size=".$sizek."><button class='btn btn-success'>Edit</button></a></td>";
					echo "</tr>";
				}
			}
			//echo "<td>".$sql_row['xs']."</td><td>".$sql_row['s']."</td><td>".$sql_row['m']."</td><td>".$sql_row['l']."</td><td>".$sql_row['xl']."</td><td>".$sql_row['xxl']."</td><td>".$sql_row['xxxl']."</td>";
		}
		echo "</table></div>";
		?>
	</div>
</div>


<script language="javascript" type="text/javascript">

var table6_Props = 	{
	 		            rows_counter: true,
						btn_reset: true,
						loader: true,
						loader_text: "Filtering data..."
					};
	setFilterGrid( "table1",table6_Props );


</script>