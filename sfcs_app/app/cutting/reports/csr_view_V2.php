<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/user_acl_v1.php',3,'R'));
// $view_access=user_acl("SFCS_0005",$username,1,$group_id_sfcs); 
?>
<script>
function verify_date(){
		var val1 = $('#sdate').val();
		var val2 = $('#edate').val();
		
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
}

</script>
<style>
 th,td { color : #000;}
</style>
		<?php
			$from_date=$_POST['from_date'];
			$to_date=$_POST['to_date'];
			$section=$_POST['section'];
			$shift=$_POST['shift'];
			$reptype=$_POST['reptype'];
		?>
		<div class="panel panel-primary">
		<div class="panel-heading">Cutting Status Report</div>
		<div class="panel-body">
		<form method="post" name="input" action="<?php echo '?r='.$_GET['r']; ?>">
			<div class="row">
			<div class="col-md-2">
			<label>Start Date: </label>
			<input type="text" data-toggle='datepicker' id="sdate"  name="from_date" class="form-control" size="8" value="<?php  if(isset($_POST['from_date'])) { echo $_POST['from_date']; } else { echo date("Y-m-d"); } ?>" />
			</div>
			<div class="col-md-2">
			<label>End Date:</label> 
			<input type="text" data-toggle='datepicker' id="edate" onchange='return verify_date();' name="to_date" class="form-control" size="8" value="<?php  if(isset($_POST['to_date'])) { echo $_POST['to_date']; } else { echo date("Y-m-d"); } ?>" />
			</div>

			<?php
				$table_q="select * FROM $bai_pro3.tbl_cutting_table WHERE status='active'";
				$table_result=mysqli_query($link, $table_q) or exit("Error getting Table Details");
		
				$all_sec_query = "SELECT GROUP_CONCAT('\"',tbl_id,'\"') as sec FROM $bai_pro3.tbl_cutting_table WHERE STATUS='active'";
				$sec_result_all = mysqli_query($link,$all_sec_query) or exit('Unable to load sections all');
				while($res1 = mysqli_fetch_array($sec_result_all)){
					$all_secs = $res1['sec'];
				}

			?>
			<div class="col-md-2">
				<label>Section: </label>
				<select name="section" class="form-control" required>
					<!-- <option value=''>Please Select</option> -->
					<?php if($all_secs){
					echo "<option value='$all_secs'>All</option>";
					}
					?>
					<?php
						foreach($table_result as $key=>$value){
							echo "<option value='\"".$value['tbl_id']."\"'>".$value['tbl_name']."</option>";
						}
					?>
				</select>
			</div>
			<div class="col-md-2">
				<label>Shift: </label>
				<select name="shift" class="form-control" >
					<?php 
					foreach($shifts_array as $key=>$shift){
						echo "<option value=\"'$shift'\">$shift</option>";
						$all_shifts = $all_shifts."'$shift',";
					}
				?>
				<option value="<?= rtrim($all_shifts,',') ?>" selected>All</option>
				</select>
			</div>
			<div class="col-md-2">
				<label>Report: </label>
				<select name="reptype" class="form-control">
					<option value=1 <?php if($reptype==1){ echo "selected"; } ?> >Detailed</option>
					<option value=2 <?php if($reptype==2){ echo "selected"; } ?>>Summary</option>
				</select>
			</div>
			<div class="col-md-2">
			<input type="submit" value="Show" name="submit" class="btn btn-success" onclick='return verify_date();' style="margin-top:22px;">
			</div>
			</div>
		</form>

		<?php
			if(isset($_POST['submit']))
			{
				$row_count = 0;
				$shift = $_POST['shift'];
		?>	<hr/>
			<div class='panel panel-default'>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<label>Date Range : </label>
							<span class="label label-info" style="font-size: 12px;">
							<?php echo $from_date." to ".$to_date; ?>
							</span>
						</div>
						<div class="col-md-3">
							<label>Shift : </label>
							<span class="label label-info" style="font-size: 12px;">
							<?php echo str_replace('"',"",$shift); ?>
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Section : </label>
							<span class="label label-info" style="font-size: 12px;margin-left: -10px;">
							<?php echo $section ?>
							</span>
						</div>
					</div>
				</div>
			</div>
		<?php
				$from_date=$_POST['from_date'];
				$to_date=$_POST['to_date'];
				$section=$_POST['section'];
				$shift=$_POST['shift'];
				$reptype=$_POST['reptype'];
			}
		?>
  

		<?php
		if(isset($_POST['submit']) && $reptype==1)
		{
			echo " <div class='panel panel-default'>
			  			<div class='panel-heading' align='center'>
							  <b>Detailed Report </b>
						</div>
					    <div class='panel-body'><div style='max-height:700px;overflow-y:scroll'>";	  
			  
  			
			$sql="select * from $bai_pro3.act_cut_status where section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\" and LENGTH(remarks)>0";
            //echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			$row_count = 0;
			echo "<div class='table-responsive'>
					<table class='table table-bordered'>";
  			echo "<tr class='warning'>
					  <th class='tblheading'>Date</th><th  class='tblheading'>Shift</th>
					  <th class='tblheading' >Section</th><th class='tblheading'>Docket No</th>
					  <th class='tblheading'>Style</th><th class='tblheading'>Schedule</th>
					  <th class='tblheading'>Color</th><th class='tblheading'>Category</th>
					  <th class='tblheading'>Cut No</th><th>Size</th><th>Qty</th>";
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$doc_no=$sql_row['doc_no'];
				$date=$sql_row['date'];
				$act_shift=$sql_row['shift'];
				$act_section=$sql_row['section'];
				$cut_remarks=$sql_row["remarks"];
				$cut_remarks_explode=explode("$",$cut_remarks);
				//var_dump($cut_remarks_explode);
				for($i=0;$i<sizeof($cut_remarks_explode);$i++)
				{
					$cut_details_explode=explode("^",$cut_remarks_explode[$i]);
					$cut_plies=$cut_details_explode[8];
					$cut_date=$cut_details_explode[0];
					//if($from_date >= $cut_date && $cut_date <= $to_date)	
					{	
						$sql1="select * from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row1=mysqli_fetch_array($sql_result1))
						{
							$cat_ref=$sql_row1['cat_ref'];
							$act_cut_no=$sql_row1['acutno'];
							$act_xs=$sql_row1['a_xs']*$cut_plies;
							$act_s=$sql_row1['a_s']*$cut_plies;
							$act_m=$sql_row1['a_m']*$cut_plies;
							$act_l=$sql_row1['a_l']*$cut_plies;
							$act_xl=$sql_row1['a_xl']*$cut_plies;
							$act_xxl=$sql_row1['a_xxl']*$cut_plies;
							$act_xxxl=$sql_row1['a_xxxl']*$cut_plies;
							$act_s = array();
							for($i=1;$i<=50;$i++){	
								if($i<=9){										
									$act_s[$i]=$sql_row1['a_s0'.$i]*$cut_plies;									
								}else{
									$act_s[$i]=$sql_row1['a_s'.$i]*$cut_plies;
								}
							}			
							//$act_total = $act_xs+$act_s+$act_m+$act_l+$act_xl+$act_xxl+$act_xxxl;					
							foreach($act_s as $val){
								$act_total+=$val;
							}
					
						}
						$sql1="select category,order_tid from $bai_pro3.cat_stat_log where tid=\"$cat_ref\"";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row1=mysqli_fetch_array($sql_result1))
						{
							$category=$sql_row1['category'];
							$order_tid=$sql_row1['order_tid'];
						}	
	
						$sql1="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row1=mysqli_fetch_array($sql_result1))
						{
							$style=$sql_row1['order_style_no'];
							$schedule=$sql_row1['order_del_no'];
							$color_code=$sql_row1['color_code'];
							$color=$sql_row1['order_col_des'];
							for($i=0;$i<50;$i++)
							{
								$key1 = 'title_size_s'.str_pad($i+1, 2, "0", STR_PAD_LEFT);
								$size[$i] = $sql_row1[$key1];
							}
						}
						$inner_count = 0;
						
						echo  "<tr>
								 <td>".$cut_details_explode[0]."</td> 
								 <td>".$cut_details_explode[2]."</td> 
								 <td>".$cut_details_explode[1]."</td> 
								 <td>".leading_zeros($doc_no,9)."</td> 
								 <td>$style</td> 
								 <td>$schedule</td> 
								 <td>$color</td> 
								 <td>$category</td> 
								 <td>".chr($color_code).leading_zeros($act_cut_no,3)."</td>";
						
						for($i=0;$i<50;$i++)
						{
							if($size[$i]!=''){
								if($inner_count==0){
									echo "<td>".$size[$i]."</td>";
									echo "<td>".$act_s[$i+1]."</td>";
									echo "</tr>";
									$inner_count++;
								}
								else{
									echo "<tr>
										<td>".$cut_details_explode[0]."</td> 
										<td>".$cut_details_explode[2]."</td> 
										<td>".$cut_details_explode[1]."</td> 
										<td>".leading_zeros($doc_no,9)."</td> 
										<td>$style</td> 
										<td>$schedule</td> 
										<td>$color</td> 
										<td>$category</td> 
										<td>".chr($color_code).leading_zeros($act_cut_no,3)."</td>";
								echo "<td>".$size[$i]."</td>";		
								echo "<td>".$act_s[$i+1]."</td>";
								echo "</tr>";
								}
							}
						}
						echo "<tr>";
						echo "<td></td><td></td><td></td><td>
							  </td><td></td><td></td>
							  <td></td><td></td><td></td>
							  <td class='info'>Total :</td>
							  <td class='info'>$act_total</td>";
						echo "</tr>";
						 $act_total = 0;
  					}
				}
			}
			echo "</table>
				</div>";    
 		
			//Recut

			$sql="select * from $bai_pro3.act_cut_status_recut_v2 where section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			if($sql_num_check > 0){
				echo "<div class='table-responsive'><table class='table table-bordered'>";
				echo "<tr class='warning'>
						<th class='tblheading'>Date 2</th><th class='tblheading'>Shift 2</th>
						<th class='tblheading' >Section</th>
						<th class='tblheading'>Docket No</th>
						<th class='tblheading'>Style</th>
						<th class='tblheading'>Schedule</th>
						<th class='tblheading'>Color</th>
						<th class='tblheading'>Category</th>
						<th class='tblheading'>Cut No</th>
						<th>Size</th>
						<th>Qty</th>";
			}

			while($sql_row=mysqli_fetch_array($sql_result))
			{
				
				$doc_no=$sql_row['doc_no'];
				$date=$sql_row['date'];
				$act_shift=$sql_row['shift'];
				$act_section=$sql_row['section'];
				
				
				$sql1="select * from $bai_pro3.recut_v2 where doc_no=\"$doc_no\"";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$cat_ref=$sql_row1['cat_ref'];
					$act_cut_no=$sql_row1['acutno'];
					$act_xs=$sql_row1['a_xs']*$sql_row1['a_plies'];
					$act_s=$sql_row1['a_s']*$sql_row1['a_plies'];
					$act_m=$sql_row1['a_m']*$sql_row1['a_plies'];
					$act_l=$sql_row1['a_l']*$sql_row1['a_plies'];
					$act_xl=$sql_row1['a_xl']*$sql_row1['a_plies'];
					$act_xxl=$sql_row1['a_xxl']*$sql_row1['a_plies'];
					$act_xxxl=$sql_row1['a_xxxl']*$sql_row1['a_plies'];

				
					$act_s = array();
					for($i=1;$i<=50;$i++){	
						if($i<=9){										
							$act_s[$i]=$sql_row1['a_s0'.$i]*$cut_plies;									
						}else{
							$act_s[$i]=$sql_row1['a_s'.$i]*$cut_plies;
						}
					}			
					//$act_total = $act_xs+$act_s+$act_m+$act_l+$act_xl+$act_xxl+$act_xxxl;					
					foreach($act_s as $val){
						$act_total+=$val;
					}
				}
	
				$inner_count = 0;
				echo "<td>$date</td>
						<td>$act_shift</td> 
						<td>$act_section</td> 
						<td>".leading_zeros($doc_no,9)."</td> 
						<td>$style</td> 
						<td>$schedule</td> 
						<td>$color</td> 
						<td>$category</td> 
						<td>"."R".leading_zeros($act_cut_no,3)."</td>";
				
				for($i=0;$i<50;$i++)
				{
					if($size[$i]!=''){
						if($inner_count==0){
							echo "<td>".$size[$i]."</td>";
							echo "<td>".$act_s[$i+1]."</td>";
							echo "</tr>";
							$inner_count++;
						}
						else{
							echo "<tr>
								<td>".$cut_details_explode[0]."</td> 
								<td>".$cut_details_explode[2]."</td> 
								<td>".$cut_details_explode[1]."</td> 
								<td>".leading_zeros($doc_no,9)."</td> 
								<td>$style</td> 
								<td>$schedule</td> 
								<td>$color</td> 
								<td>$category</td> 
								<td>".chr($color_code).leading_zeros($act_cut_no,3)."</td>";
						echo "<td>".$size[$i]."</td>";		
						echo "<td>".$act_s[$i+1]."</td>";
						echo "</tr>";
						}
					}
				}
				echo "<tr>";
				echo "<td></td><td></td><td></td><td>
							  </td><td></td><td></td>
							  <td></td><td></td><td></td>
							  <td class='info'>Total :</td>
							  <td class='info'>$act_total</td>";
				echo "</tr>";
				echo "</tr>";
				 $act_total = 0;

			}
			echo "</table></div>";
			echo "</div></div>";
		}
	 ?>
	 <?php
 		if(isset($_POST['submit']) && $reptype==2)
		{
			echo " <div class='panel panel-default'>
			<h2 align='center'><b>Summary Report for Cut Quantity</b></h2>
			<div class='panel-body'>";
  			//echo"(Summary Report for Cut Quantity)";
			echo"
		  <table class='table table-bordered' >
		  <tr class='warning'>
		  <th class='tblheading'>Section</th>
		  <th class='tblheading'>Shift</th>
		  <th class='tblheading'>Category</th>
		  <th class='tblheading'>Cut Qty</th>
		  </tr>";
 			$sql="select distinct section from $bai_pro3.act_cut_status where section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\" order by section";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);

			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$row_count++;
				$section_new=$sql_row['section'];
				$sql1="select distinct shift from $bai_pro3.act_cut_status where date between \"$from_date\" and \"$to_date\" and section=\"$section_new\" and shift in ($shift) order by shift";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$shift_new=$sql_row1['shift'];
					$doc_list="";
					$sql2="select doc_no from $bai_pro3.act_cut_status where date between \"$from_date\" and \"$to_date\" and section=\"$section_new\" and shift=\"$shift_new\"";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$doc_list=$doc_list.$sql_row2['doc_no'].", ";
					}
					$doc_list=substr($doc_list,0,-2);
					$cat_list="";
					$sql2="select distinct cat_ref from $bai_pro3.plandoc_stat_log where doc_no in ($doc_list) order by cat_ref";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$cat_list=$cat_list.$sql_row2['cat_ref'].", ";
					}
					$cat_list=substr($cat_list,0,-2);
					$sql2="select distinct category from $bai_pro3.cat_stat_log where tid in ($cat_list)";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$category=$sql_row2['category'];
						$cat_base="";
						$sql3="select distinct tid from $bai_pro3.cat_stat_log where category=\"$category\" and tid in ($cat_list)";
						$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row3=mysqli_fetch_array($sql_result3))
						{
							$cat_base=$cat_base.$sql_row3['tid'].", ";
						}
						$cat_base=substr($cat_base,0,-2);
						$sql3="select sum((a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s01+a_s02+a_s03+a_s04+a_s05+a_s06+a_s07+a_s08+a_s09+a_s10+a_s11+a_s12+a_s13+a_s14+a_s15+a_s16+a_s17+a_s18+a_s19+a_s20+a_s21+a_s22+a_s23+a_s24+a_s25+a_s26+a_s27+a_s28+a_s29+a_s30+a_s31+a_s32+a_s33+a_s34+a_s35+a_s36+a_s37+a_s38+a_s39+a_s40+a_s41+a_s42+a_s43+a_s44+a_s45+a_s46+a_s47+a_s48+a_s49+a_s50)*a_plies) as \"cut_qty\" from $bai_pro3.plandoc_stat_log where doc_no in ($doc_list) and cat_ref in ($cat_base)";
						$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row3=mysqli_fetch_array($sql_result3))
						{
							$cut_qty=$sql_row3['cut_qty'];
						}
	 					echo "<tr >";
					    echo "<td >$section_new</td>";
					  	echo "<td >$shift_new</td>";
					  	echo "<td >$category</td>";
					  	echo "<td >$cut_qty</td>";
	 					echo "</tr>";
 
 					}
				}
			}
			if($row_count == 0){
				echo "<tr><td colspan=4 style='color:#ff0000'>No Data found</td></tr>";
			}
			echo "</table></div></div>";
			
	
	
	//recut

	echo "<br/>";
	echo " <div class='panel panel-default'>
	<h2 align='center'>
	<b>Summary Report for Re-Cut Quantity</b></h2>
	<div class='panel-body'>";
	
	echo"<table class='table table-bordered'>
		  <tr class='warning'>
		  <th class='tblheading'>Section</th>
		  <th class='tblheading'>Shift</th>
		  <th class='tblheading'>Category</th>
		  <th class='tblheading'>Re Cut Qty</th>
		  </tr>";
 			$sql="select distinct section from $bai_pro3.act_cut_status_recut_v2 where section in ($section) and shift in ($shift) and date between \"$from_date\" and \"$to_date\" order by section";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result);
			$row_count = 0;
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$section_new=$sql_row['section'];
				$sql1="select distinct shift from $bai_pro3.act_cut_status_recut_v2 where date between \"$from_date\" and \"$to_date\" and section=\"$section_new\" and shift in ($shift) order by shift";
				$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row1=mysqli_fetch_array($sql_result1))
				{
					$row_count++;
					$shift_new=$sql_row1['shift'];
					$doc_list="";
					$sql2="select doc_no from $bai_pro3.act_cut_status_recut_v2 where date between \"$from_date\" and \"$to_date\" and section=$section_new and shift=\"$shift_new\"";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$doc_list=$doc_list.$sql_row2['doc_no'].", ";
					}
					$doc_list=substr($doc_list,0,-2);
					$cat_list="";
					$sql2="select distinct cat_ref from $bai_pro3.recut_v2 where doc_no in ($doc_list) order by cat_ref";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$cat_list=$cat_list.$sql_row2['cat_ref'].", ";
					}
					$cat_list=substr($cat_list,0,-2);
					$sql2="select distinct category from $bai_pro3.cat_stat_log where tid in ($cat_list)";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row2=mysqli_fetch_array($sql_result2))
					{
						$category=$sql_row2['category'];
						$cat_base="";
						$sql3="select distinct tid from $bai_pro3.cat_stat_log where category=\"$category\" and tid in ($cat_list)";
						$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row3=mysqli_fetch_array($sql_result3))
						{
							$cat_base=$cat_base.$sql_row3['tid'].", ";
						}
						$cat_base=substr($cat_base,0,-2);
						$sql3="select sum((a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl+a_s01+a_s02+a_s03+a_s04+a_s05+a_s06+a_s07+a_s08+a_s09+a_s10+a_s11+a_s12+a_s13+a_s14+a_s15+a_s16+a_s17+a_s18+a_s19+a_s20+a_s21+a_s22+a_s23+a_s24+a_s25+a_s26+a_s27+a_s28+a_s29+a_s30+a_s31+a_s32+a_s33+a_s34+a_s35+a_s36+a_s37+a_s38+a_s39+a_s40+a_s41+a_s42+a_s43+a_s44+a_s45+a_s46+a_s47+a_s48+a_s49+a_s50)*a_plies) as \"cut_qty\" from $bai_pro3.recut_v2 where doc_no in ($doc_list) and cat_ref in ($cat_base)";
						$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row3=mysqli_fetch_array($sql_result3))
						{
							$cut_qty=$sql_row3['cut_qty'];
						}
						$row_count++;
	 					echo "<tr >";
					    echo "<td >$section_new</td>";
					  	echo "<td >$shift_new</td>";
					  	echo "<td >$category</td>";
					  	echo "<td >$cut_qty</td>";
	 					echo "</tr>";
 
 					}
				}
			}
			if($row_count == 0){
				echo "<tr><td colspan=4 style='color:#ff0000'>No Data found</td></tr>";
			}
			echo "</table></div>";
			
			echo "</div></div>";
		}
 	?>
		</div>
</div>
</div>