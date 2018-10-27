<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
$view_access=user_acl("SFCS_0051",$username,1,$group_id_sfcs); 
// $rep3 = getFullURL($_GET['r'],'rep3.php','N'); 
// echo $rep3;
?>

<script>

	function firstbox()
	{
		window.location.href = "index.php?r=<?= $_GET['r'] ?>&style="+document.input.style.value;
	}

	function secondbox()
	{
		window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.input.style.value+"&schedule="+document.input.schedule.value
	}

	function thirdbox()
	{
		window.location.href ="index.php?r=<?= $_GET['r'] ?>&style="+document.input.style.value+"&schedule="+document.input.schedule.value+"&color="+document.input.color.value
	}
</script>
<script >
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
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


	/* table tr
	{
		border: 1px solid black;
		text-align: right;
		white-space:nowrap; 
	}

	table td
	{
		border: 1px solid black;
		text-align: center;
		white-space:nowrap;
		background-color:#e8e8ea; 
		height:35px;
	} */

	table th
	{
		border: 1px solid black;
		text-align: center;
		background-color: #003366;
		color: WHITE;
		white-space:nowrap; 
		padding-left: 5px;
		padding-right: 5px;
	}

	table{
		white-space:nowrap; 
		border-collapse:collapse;
		font-size:12px;
		background-color: white;
	}
	td {
		font-weight:bold;
		color:black;
	}
	.form-control{
		min-width : 200px;
	}
	.BG {
	/* background-image:url(Diag.gif); */
	background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
	}
</style>
<div class="panel panel-primary">
<div class="panel-heading">Daily Rejection Detail Report - Style Level</div>
<div class="panel-body">
<form name="input" class="form-inline" method="post" action="?r=<?= $_GET['r'] ?>">
	<div class="row">
		<!-- <div class="col-md-1" class="alert alert-primary"><label><label></div> -->
		<div class="col-md-3 form-group">
			<label>Ex-Factory Start Date</label>
			<input  class="form-control" type="text" data-toggle='datepicker' id="dat1" name="sdate" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
		</div>
		<div class="col-md-3 form-group">
			<label>End Date</label>
			<input  class="form-control" type="text" data-toggle='datepicker' id="dat2" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
		</div>
		<div class="col-md-3 form-group">
			<br/>
			<input type="checkbox" class="checkbox" name="module" value="1" <?php if(isset($_POST['module'])) { echo "checked"; }?>>
			<label class="checkbox-inline">Module</label>
		</div>
		<div class="col-md-1 form-group">
			<label class="checkbox-inline"></label><br/>
		 	<input type="submit" class="btn btn-primary" name="filter" onclick='return verify_date()' value="Filter">
		</div>
	</div>

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
<hr>
<div class="row">
	<!-- <div class="col-md-1"></div> -->
	<div class="col-md-3 form-group">
	<label>Select Style</label><br/>
	<select name="style" onchange="firstbox();"  class="form-control">
	<?php
		$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm order by order_style_no";	
		// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
	?>
	</select>
	</div>
	<div class="col-sm-3">
	<label>Select Schedule:</label><br/>
	<select name="schedule" onchange="secondbox();"  class="form-control">
	<?php
		$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" order by order_del_no";	
		// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	?>
	</select>
	</div>
	<div class="col-sm-3">
	<label>Select Color:</label><br/>
	<select name="color" onchange="thirdbox();"  class="form-control">
	<?php
		$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" ";
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
	?>
	</select>
	</div>
	<div class="col-md-1">
		<label></label><br/>
		<input type="submit" class="btn btn-primary" value="Filter" name="filter2">
	</div>
</div>
</form>

<?php

	if(isset($_POST['filter']) or isset($_POST['filter2']))
	{
		
		$sdate=$_POST['sdate'];
		$edate=$_POST['edate'];
		$module=$_POST['module'];
		
		$choice=1;
		
		if($module>0)
		{
			$choice=2;
		}
		
		echo " <br/><hr/><br/><div class='table-responsive' style='max-height:600px;max-width:1000px;overflow-x:scroll;overflow-y:scroll;'><table class='table table-bordered'>";
		echo "<tr class='tblheading'>
			<th rowspan=3>Style</th>
			<th rowspan=3>Schedule</th>
			<th rowspan=3>Color</th>
			<th rowspan=3>Size</th>
			<th rowspan=3>Order Qty</th>
			<th rowspan=3>Module</th>
			<th rowspan=3>Sewing Out</th>
			<th rowspan=3 width=45>Reject<br/> Out</th>
			<th colspan=8>Fabric</th>
			<th colspan=3>Cutting</th>
			<th colspan=11>Sewing</th>
			<th colspan=3>Machine Damages</th>
			<th colspan=8>Embellishment</th>
			
		</tr>";


		echo "<tr class='tblheading'>
			<th width=45>Miss</th>	<th width=45>Fabric </th>	<th width=45>Slub</th>	<th width=45 >Foreign </th>	<th width=45>Stain </th>	<th width=45>Color </th> <th width=45> Heat </th> <th width=45> Trim </th>	<th width=45 >Panel</th> <th  width=45>Stain</th>		<th width=45>Strip</th>	<th width=45>Cut</th> <th  width=45>Heat</th>	<th  width=45> M'ment </th>  <th  width=45> Un </th> <th width=45>Shape </th>	<th width=45>Shape</th>	<th width=45 >Shape </th>	<th width=45>Stain </th>	<th width=45>With</th> <th width=45>Trim</th>  <th width=45>Sewing</th>  <th width=45>Cut</th>   <th width=45>Slip</th>  <th width=45>Oil</th> <th width=45>Others</th>  <th width=45>Foil</th>  <th width=45>Embroidery</th> <th width=45>Print</th>  <th width=45>Sequence</th>  <th width=45>Bead</th>  <th width=45>Dye</th>  <th width=45>Wash</th> 

		</tr>";

		echo "<tr class='tblheading'>
			<th>Yarn</th>	<th>Holes</th>	<th></th>	<th>Yarn</th>	<th>Mark </th>	<th>Shade</th> <th> seal </th> <th></th>	<th>Un-Even</th> <th>Mark</th>		<th>Match</th>	<th>Dmg</th> <th>Seal</th> <th>out</th>	 <th>Even</th><th>OutLeg </th>	<th>Outwaist</th>	<th>Out</th>	<th>Mark </th>	<th>OutLabel</th> <th>Shortage</th> <th>Excess</th> <th>Holes</th> <th>Stitch's</th> <th>Marks</th> <th>EMB</th> <th>Defects</th> <th></th>  <th></th> <th></th><th></th><th></th><th></th>	

		</tr>";


		if(isset($_POST['filter2']))
		{
			$sch_db_grand=$_POST['schedule'];
			$sch_color=$_POST['color'];
		}
		else
		{
			$sql="select group_concat(distinct schedule_no) as schedules from $bai_pro4.week_delivery_plan_ref where ex_factory_date_new between '$sdate' and '$edate'";
			 echo $sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$sch_db_grand=$sql_row['schedules'];
			}
		}
		//echo $sch_db_grand;
		if(sizeof($sch_db_grand)>0)
		{

			$query_add="";
			if(isset($_POST['filter2']))
			{
				$query_add=" and qms_color=\"$sch_color\" ";
			}
			$grand_vals=array();
			for($i=0;$i<33;$i++) {	$grand_vals[$i]=0;	}
			$grand_output=0;
			$grand_rejections=0;
			if($sch_db_grand == 'NIL')
			{
				//exit('problem');
				echo "<script>swal('Please Enter Schedule','','error');
                      $('.tblheading').hide();
				</script>";
				exit();
			}

			if($choice==1)
			{
				if(sizeof(explode(",",$sch_db_grand))==1)
				{
					// $sql1="select sum(bac_Qty) as qty,delivery,size,bac_no,color from $bai_pro.bai_log_view where length(size)>0 and delivery in ($sch_db_grand) and color=\"$sch_color\" and length(size)>0 group by delivery,color,size";
					$sql1="select sum(recevied_qty) as qty,schedule,size_id,assigned_module,color from $brandix_bts.bundle_creation_data where length(size_id)>0 and schedule in ($sch_db_grand) and color = '$sch_color' group by schedule,color,size_id";
				}
				else
				{
					// $sql1="select sum(bac_Qty) as qty,delivery,size,bac_no,color from $bai_pro.bai_log_view where length(size)>0 and delivery in ($sch_db_grand) and length(size)>0 group by delivery,color,size";
					$sql1="select sum(recevied_qty) as qty,schedule,size_id,assigned_module,color from $brandix_bts.bundle_creation_data where length(size_id)>0 and schedule in ($sch_db_grand) group by schedule,color,size_id";
				}
				//echo $sql1;
			}
			if($choice==2)
			{
				// $sql1="select sum(bac_Qty) as qty,delivery,size,bac_no,color from $bai_pro.bai_log_view where delivery in ($sch_db_grand) and color=\"$sch_color\" and length(size)>0 group by delivery,color,size,bac_no";
				$sql1="select sum(recevied_qty) as qty,schedule,size_id,assigned_module,color from $brandix_bts.bundle_creation_data where schedule in ($sch_db_grand) and color = '$sch_color' and length(size_id)>0 group by schedule,color,size_id,assigned_module";
			}
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				
				$sw_out=$sql_row1['qty'];	
				$sch_db=$sql_row1['schedule'];
				$size=$sql_row1['size_id'];
				$mod=$sql_row1['assigned_module'];	
				$color=$sql_row1['color'];
				$qms_qty=0;
				$ref1="";
				
				if($choice==1)
				{
					$sql="select qms_size,qms_style,qms_schedule,qms_color,substring_index(substring_index(remarks,\"-\",2),\"-\",-1) as \"shift\",log_date,group_concat(ref1,\"$\") as \"ref1\",coalesce(sum(qms_qty),0) as \"qms_qty\" from $bai_pro3.bai_qms_db where substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in (\"A\",\"B\") $query_add and qms_size=\"$size\" and qms_tran_type=3 and qms_schedule in ($sch_db) group by qms_style,qms_schedule,qms_color,qms_size order by qms_style,qms_schedule,qms_color,qms_size";
				}

				if($choice==2)
				{
					$sql="select qms_size,qms_style,qms_schedule,qms_color,substring_index(remarks,\"-\",1) as \"module\",substring_index(substring_index(remarks,\"-\",2),\"-\",-1) as \"shift\",log_date,group_concat(ref1,\"$\") as \"ref1\",coalesce(sum(qms_qty),0) as \"qms_qty\" from $bai_pro3.bai_qms_db where substring_index(substring_index(remarks,\"-\",2),\"-\",-1) in (\"A\",\"B\") $query_add and qms_tran_type=3 and qms_schedule in ($sch_db) and substring_index(remarks,\"-\",1)=\"$mod\" and qms_size=\"$size\" group by qms_style,qms_schedule,qms_color,qms_size,substring_index(remarks,\"-\",1) order by qms_style,qms_schedule,qms_color,qms_size,substring_index(remarks,\"-\",1)";
				}

				//echo $sql."<br>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{

						//$mod=$sql_row['module'];
						//$shif=$sql_row['shift'];
						$qms_qty=$sql_row['qms_qty'];
						$ref1=$sql_row['ref1'];	
				}

				//echo $ref1;
				//if($choice==1)	
				//{
				$sql11="select order_s_".$size." as qty, order_style_no,order_del_no,order_col_des from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$sch_db."\" and order_col_des=\"".$color."\"";
				// echo $sql11;
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$or_qty=$sql_row11['qty'];
					$style=$sql_row11['order_style_no'];
					$schedule=$sql_row11['order_del_no'];
					$color=$sql_row11['order_col_des'];
				}
		//}


				echo "<tr>";
				
				echo "<td>".$style."</td>";
				echo "<td>".$schedule."</td>";
				echo "<td>".$color."</td>";
				echo "<td>".$size."</td>";

				$span1='<p class="pull-left">';
				$span2='<p class="pull-right">';
				$span3='</p>';
				
				echo "<td>".$or_qty."</td>";
				echo "<td>".$mod."</td>";
				echo "<td>".$sw_out."</td>";
				echo "<td class=\"BG\">$span1".$qms_qty."$span3$span2"; if($sw_out>0) { echo round(($qms_qty/$sw_out)*100,1)."%"; } echo "$span3</td>";

			$vals=array();
			
			
			$rej_val=array(0,1,2,3,4,5,15,16,6,7,8,9,11,12,17,18,19,13,10,20,21,22,23,24,25,14,26,27,28,29,30,31,32);						
				for($i=0;$i<33;$i++) {	$vals[$i]=0;	}
				
				$temp=array();
				$temp=explode("$",str_replace(",","$",$ref1));
				
				for($i=0;$i<sizeof($temp);$i++)
				{
					if(strlen($temp[$i])>0)
					{
						$temp2=array();
						$temp2=explode("-",$temp[$i]);
						$x=$temp2[0];
						$vals[$x]+=$temp2[1];
						$grand_vals[$x]+=$temp2[1];
					}
				}

				for($i=0;$i<33;$i++)
				{	
				
					//BG Color
					if($i<8)
					{
						$bgcolor=" bgcolor=#FFEEDD ";
					}
					
					if($i>7 and $i<11)
					{
						$bgcolor=" bgcolor=white";
					}
					if($i>10 and $i<22)
					{
							$bgcolor=" bgcolor=#FFEEDD";
					}
					if($i>21 and $i<25)
					{
						$bgcolor=" bgcolor=white";
					}
					if($i>24)
					{
							$bgcolor=" bgcolor=#FFEEDD";
					}
					/*if($i>22 and $i<26)
					{
						$bgcolor=" bgcolor=#FFEEDD ";
					}
					if($i>25)
					{
						$bgcolor=" bgcolor=#FFEEDD ";
					}
					//if($i>13)
					//{
					//	$bgcolor=" bgcolor=white ";
					//}*/
					//BG Color
					
					echo "<td class=\"BG\" $bgcolor>$span1".$vals[$rej_val[$i]]."$span3$span2"; if($sw_out>0) { echo round(($vals[$rej_val[$i]]/$sw_out)*100,1)."%"; } echo "$span3</td>";
				
				
					
					//echo "<td>".$vals[$i]."</td>";	
				}
				
				echo "</tr>";
				$grand_output+=$sw_out;
				$grand_rejections+=$qms_qty;

			}

			echo "<tr>";
			echo "<td colspan=6 style='background-color:#66dd88'>Total</td>";
			echo "<td>".$grand_output."</td>";
			echo "<td class=\"BG\">$span1".$grand_rejections."$span3$span2"; if($grand_output>0) { echo round(($grand_rejections/$grand_output)*100,1)."%"; } echo "$span3</td>";
			for($i=0;$i<33;$i++)
			{	
					if($i<8)
					{
						$bgcolor=" bgcolor=#66DD88 ";
					}
					
					if($i>7 and $i<11)
					{
						$bgcolor=" bgcolor=white";
					}
					if($i>10 and $i<22)
					{
							$bgcolor=" bgcolor=#66DD88";
					}
					if($i>21 and $i<25)
					{
						$bgcolor=" bgcolor=white";
					}
					if($i>24)
					{
							$bgcolor=" bgcolor=#66DD88";
					}
				
					echo "<td class=\"BG\"  $bgcolor>$span1".$grand_vals[$rej_val[$i]]."$span3$span2"; if($grand_output>0) { echo round(($grand_vals[$rej_val[$i]]/$grand_output)*100,1)."%"; } echo "$span3 </td>";
			}
			echo "</tr>";


			echo "<tr><span >";
			echo "<td colspan=6 style='background-color:#66dd88'>Total</td>";
			echo "<td>".$grand_output."</td>";
				
			echo "<td class=\"BG\">$span1".$grand_rejections."$span3$span2"; if($grand_output>0) { echo round(($grand_rejections/$grand_output)*100,1)."%"; } echo "$span3 </td>";

				$bgcolor=" bgcolor=#66DD88 ";
				
					echo "<td class=\"BG\" $bgcolor colspan=8>$span1".($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])/$grand_output)*100,1)."%"; } echo "$span3 </td>";

				
				$bgcolor=" bgcolor=white ";

				echo "<td class=\"BG\" $bgcolor colspan=3>$span1".($grand_vals[6]+$grand_vals[7]+$grand_vals[8])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[6]+$grand_vals[7]+$grand_vals[8])/$grand_output)*100,1)."%"; } echo "$span3</td>";

	$bgcolor=" bgcolor=#66DD88 ";
	
			echo "<td class=\"BG\" $bgcolor colspan=11>$span1".($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])/$grand_output)*100,1)."%"; } echo "$span3</td>";
	
	$bgcolor=" bgcolor=white ";

			echo "<td class=\"BG\" $bgcolor  colspan=3>$span1".($grand_vals[23]+$grand_vals[24]+$grand_vals[25])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[23]+$grand_vals[24]+$grand_vals[25])/$grand_output)*100,1)."%"; } echo "$span3</td>";
			
	$bgcolor=" bgcolor=#66DD88 ";

			echo "<td class=\"BG\" $bgcolor  colspan=8>$span1".($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])/$grand_output)*100,1)."%"; } echo "$span3</td>";


			echo "</tr>";
		}

	}

?>
</table>
</div>
</div>
</div>
</div>