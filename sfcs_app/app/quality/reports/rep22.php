<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
$view_access=user_acl("SFCS_0050",$username,1,$group_id_sfcs); 
// $Diag = getFullURL($_GET['r'],'Diag.gif','R');
// echo $Diag;
?>
<?php  

$reasons=array("Miss Yarn","Fabric Holes","Slub","F.Yarn","Stain Mark","Color Shade","Heat Seal","Trim","Panel Un-Even","Stain Mark","Strip Match","Cut Damage","Heat Seal","M' ment Out","Un Even","Shape Out Leg","Shape Out waist","Shape Out","Stain Mark","With out Label","Trim shortage","Sewing Excess",
"Cut Holes","Slip Stitch’s","Oil Marks","Others EMB","Foil Defects","Embroidery","Print","Sequence","Bead","Dye","wash");
?>
<style>
td {
	font-weight:bold;
	color:black;
}

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


.BG {
/* background-image:url($Diag); */
background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
background-position:center middle;
}
</style>
<div class="panel panel-primary">
<div class="panel-heading">Daily Rejection Detail Report - Module Level</div>
<div class="panel-body">
		<form name="input" method="post" action="?r=<?= $_GET['r'] ?>">
			<div class="row">
				<div class='col-md-2'><label>Start Date</lable><input id="demo1" class="form-control" type="text" data-toggle='datepicker' name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"></div>
				<div class='col-md-2'><label>End Date</lable><input id="demo2" class="form-control" type="text" data-toggle='datepicker' size="8" name="edate" value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>"></div>
				<div class='col-md-2'><label>Style Level</label><input type="checkbox" class="checkbox" name="style_level" value="1" <?php if(isset($_POST['style_level'])) { echo "checked"; }?>></div>
				<div class='col-md-1'><label>Shift Level </label><input type="checkbox" class="checkbox" name="shift_level" value="2" <?php if(isset($_POST['shift_level'])) { echo "checked"; }?>></div>
				<div class='col-md-2'><label>Section</label>
					<?php
						$section_dd = $_POST['section'];
						echo "<select name=\"section\" class='form-control'>";
						//echo "<option value=\"0\">All</option>";
						$sql="SELECT sec_id as secid FROM $bai_pro3.sections_db WHERE sec_id NOT IN (0,-1) ORDER BY sec_id";
						$result17=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($result17))
						{
							$sql_sec=$sql_row["secid"];
					?>
							<option <?php if ($section_dd==$sql_sec) { ?>selected="selected"<?php } ?> value="<?php echo $sql_sec ?>">
								<?php echo $sql_sec; ?>
							</option>
					<?php			
						}
							echo "</select>";	
					?>
				</div><br/>
			<input type="submit" name="filter" value="Filter" class="btn btn-primary">
		</div>
		</form>

		<?php

// echo "Hello";
		if(isset($_POST['filter']))
		{
			$sdate=$_POST['sdate'];
			$edate=$_POST['edate'];
			$style_level=$_POST['style_level'];
			$shift_level=$_POST['shift_level'];
			$section=$_POST['section'];
			
			$choice=0;
			
			if($style_level>0 and $shift_level>0)
			{
				$choice=3;
			}
			else
			{
				if($style_level==1)
				{
					$choice=1;
				}
				else
				{
					if($shift_level==2) {	$choice=2; }
				}
			}
			if($section>0)
			{
				//$choice=-1;
				$sec_db="";
				$sql="select sec_mods from $bai_pro3.sections_db where sec_id=$section";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$sec_db=$sql_row['sec_mods'];
				}
			}
			

			echo "<br/><hr/><br/><div class='table-responsive'><table class='table table-bordered'>";
			echo "<tr class='tblheading'>
				<th rowspan=3>Module</th>
				<th rowspan=3>Shift</th>
				<th rowspan=3>Style</th>
				<th rowspan=3>Schedule</th>
				<th rowspan=3>Color</th>
				<th rowspan=3>Sewing Out</th>
				<th rowspan=3 width=45>Reject<br/> Out</th>
				<th colspan=8>Fabric</th>
				<th colspan=3>Cutting</th>
				<th colspan=11>Sewing</th>
				<th colspan=3>Machine Damages</th>
				<th colspan=8>Embellishment</th>
		</tr>";

				//echo "<tr class='tblheading'>
				//	<th width=45>Miss</th>	<th width=45>Fabric </th>	<th width=45>Slub</th>	<th width=45 >Foreign </th>	<th width=45>Stain </th>	<th width=45>Color </th>	<th width=45 >Panel</th>	<th width=45>Stain </th>	<th width=45>Strip</th>	<th width=45>Cut</th>	<th width=45>Stain </th>	<th width=45>Heat</th>	<th width=45 >M' ment </th>	<th width=45>Shape </th>	<th width=45>Emb</th>
					echo "<tr class='tblheading'>
							<th width=45>Miss</th>	<th width=45>Fabric </th>	<th width=45>Slub</th>	<th width=45 >Foreign </th>	<th width=45>Stain </th>	<th width=45>Color </th> <th width=45> Heat </th> <th width=45> Trim </th>	<th width=45 >Panel</th> <th  width=45>Stain</th>		<th width=45>Strip</th>	<th width=45>Cut</th> <th  width=45>Heat</th>	<th  width=45> M'ment </th>  <th  width=45> Un </th> <th width=45>Shape </th>	<th width=45>Shape</th>	<th width=45 >Shape </th>	<th width=45>Stain </th>	<th width=45>With</th> <th width=45>Trim</th>  <th width=45>Sewing</th>  <th width=45>Cut</th>   <th width=45>Slip</th>  <th width=45>Oil</th> <th width=45>Others</th>  <th width=45>Foil</th>  <th width=45>Embroidery</th> <th width=45>Print</th>  <th width=45>Sequence</th>  <th width=45>Bead</th>  <th width=45>Dye</th>  <th width=45>Wash</th> 

					</tr>";

				//echo "<tr class='tblheading'>
				//	<th>Yarn</th>	<th>Holes</th>	<th></th>	<th>Yarn</th>	<th>Mark </th>	<th>Shade</th>	<th>Un-Even</th>	<th>Mark </th>	<th>Match</th>	<th>Dmg</th>	<th>Mark </th>	<th>Seal</th>	<th>Out</th>	<th>Out </th>	<th>Defects</th>
					echo "<tr class='tblheading'>
						<th>Yarn</th>	<th>Holes</th>	<th></th>	<th>Yarn</th>	<th>Mark </th>	<th>Shade</th> <th> seal </th> <th></th>	<th>Un-Even</th> <th>Mark</th>		<th>Match</th>	<th>Dmg</th> <th>Seal</th> <th>out</th>	 <th>Even</th><th>OutLeg </th>	<th>Outwaist</th>	<th>Out</th>	<th>Mark </th>	<th>OutLabel</th> <th>Shortage</th> <th>Excess</th> <th>Holes</th> <th>Stitch's</th> <th>Marks</th> <th>EMB</th> <th>Defects</th> <th></th>  <th></th> <th></th><th></th><th></th><th></th>	

					</tr>";


					if($choice==0)
					{
						$sql="select sum(bac_qty) as \"output\", bac_no from $bai_pro.bai_log where bac_no in ($sec_db) and bac_date between \"$sdate\" and \"$edate\" group by bac_no";
					}

					if($choice==1)
					{
						$sql="select sum(bac_qty) as \"output\", group_concat(distinct delivery) as \"delivery\", group_concat(distinct color) as \"color\", bac_style from $bai_pro.bai_log where bac_date between \"$sdate\" and \"$edate\" group by bac_style order by bac_style+1";
					}

					if($choice==2)
					{
						$sql="select sum(bac_qty) as \"output\", bac_no, bac_shift from $bai_pro.bai_log where bac_no in ($sec_db) and bac_date between \"$sdate\" and \"$edate\" group by bac_no,bac_shift order by bac_no,bac_shift";
					}

					if($choice==3)
					{
						$sql="select sum(bac_qty) as \"output\", group_concat(distinct delivery) as \"delivery\", group_concat(distinct color) as \"color\", bac_style,bac_no, bac_shift from $bai_pro.bai_log where bac_no in ($sec_db) and bac_date between \"$sdate\" and \"$edate\" group by bac_style,bac_no,bac_shift order by bac_no,bac_shift";
					}
					$grand_vals=array();
					
					for($i=0;$i<33;$i++) {	$grand_vals[$i]=0;	}
					$grand_output=0;
					$grand_rejections=0;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					
					$mod=$sql_row['bac_no'];
					$shif=$sql_row['bac_shift'];
					$delivery=$sql_row['delivery'];
					echo "<tr>";
					echo "<td>".$sql_row['bac_no']."</td>";
					echo "<td>".$sql_row['bac_shift']."</td>";
					echo "<td>".$sql_row['bac_style']."</td>";
					echo "<td>".$sql_row['delivery']."</td>";
					echo "<td>".$sql_row['color']."</td>";
					
					$sw_out=$sql_row['output'];
					
					$sql1x="SET SESSION group_concat_max_len = 1000000";
					mysqli_query($link, $sql1x) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

					if($choice==0)
					{
						$sql1="select group_concat(ref1,\"$\") as \"ref1\",sum(qms_qty) as \"qms_qty\" from $bai_pro3.bai_qms_db where qms_tran_type=3 and substring_index(remarks,\"-\",1)=\"$mod\" and log_date between \"$sdate\" and \"$edate\"";

					}
					
					if($choice==1)
					{
						$sql1="select group_concat(ref1,\"$\") as \"ref1\",sum(qms_qty) as \"qms_qty\" from $bai_pro3.bai_qms_db where qms_tran_type=3 and qms_schedule in ($delivery) and log_date between \"$sdate\" and \"$edate\"";
						//echo $sql1."<br/>";
					}
					
					if($choice==2)
					{
						
						$sql1="select group_concat(ref1,\"$\") as \"ref1\",sum(qms_qty) as \"qms_qty\" from $bai_pro3.bai_qms_db where qms_tran_type=3 and substring_index(remarks,\"-\",1)=\"$mod\" and  substring_index(substring_index(remarks,\"-\",2),\"-\",-1)=\"$shif\" and log_date between \"$sdate\" and \"$edate\" ";
					}
					
					if($choice==3)
					{
						
						$sql1="select group_concat(ref1,\"$\") as \"ref1\",sum(qms_qty) as \"qms_qty\" from $bai_pro3.bai_qms_db where qms_tran_type=3 and qms_schedule in ($delivery) and substring_index(remarks,\"-\",1)=\"$mod\" and  substring_index(substring_index(remarks,\"-\",2),\"-\",-1)=\"$shif\" and log_date between \"$sdate\" and \"$edate\"";
					  // echo "query=".$sql1;
					}
					
					$qms_qty=0;
					$ref="";
			//echo $sql1;
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$ref=$sql_row1['ref1'];
						$qms_qty=$sql_row1['qms_qty'];
					}
					
					if($qms_qty==0 or $qms_qty==NULL)
					{
						$qms_qty=0;
					}
					
					$span1='<p class="pull-left">';
					$span2='<p class="pull-right">';
					$span3='</p>';
				
					echo "<td>".$sw_out."</td>";
					echo "<td class=\"BG\">$span1".$qms_qty."$span3$span2"; if($sw_out>0) { echo round(($qms_qty/$sw_out)*100,1)."%"; } echo "$span3</td>";
					
					//echo $sql_row['bac_no']."=".strlen($ref);	
					$vals=array();
					$rej_val=array(0,1,2,3,4,5,15,16,6,7,8,9,11,12,17,18,19,13,10,20,21,22,23,24,25,14,26,27,28,29,30,31,32);
					for($i=0;$i<33;$i++) {	$vals[$i]=0;	}
					
					$temp=array();
					$temp=explode("$",str_replace(",","$",$ref));
					
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
					
					for($i=0;$i<33;$i++) {
					
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
					//BG Color
						
					echo "<td class=\"BG\" $bgcolor>$span1".$vals[$rej_val[$i]]."$span3$span2"; if($sw_out>0) { echo round(($vals[$rej_val[$i]]/$sw_out)*100,1)."%"; } echo "$span3</td>";
					
					//echo "<td>".$vals[$i]."</td>";	
					}
					
					echo "</tr>";
					
					$grand_output+=$sw_out;
					$grand_rejections+=$qms_qty;
					
				} 
				
				
				
				echo "<tr >";
				echo "<td colspan=5 bgcolor=#f47f7f>Section - $section</td>";
				echo "<td>".$grand_output."</td>";
				echo "<td class=\"BG\">$span1".$grand_rejections."$span3$span2"; if($grand_output>0) { echo round(($grand_rejections/$grand_output)*100,1)."%"; } echo "$span3</td>";
				for($i=0;$i<33;$i++) {	
				
				//BG Color
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
				//BG Color
					
				echo "<td class=\"BG\" $bgcolor>$span1".$grand_vals[$rej_val[$i]]."$span3$span2"; if($grand_output>0) { echo round(($grand_vals[$rej_val[$i]]/$grand_output)*100,1)."%"; } echo "$span3</td>";
				
				//echo "<td>".$vals[$i]."</td>";	
				}
				echo "</tr>";
				
				
				echo "<tr >";
				echo "<td colspan=5 bgcolor=#f47f7f>Section - $section</td>";
				echo "<td>".$grand_output."</td>";
				echo "<td class=\"BG\">$span1".$grand_rejections."$span3$span2"; if($grand_output>0) { echo round(($grand_rejections/$grand_output)*100,1)."%"; } echo "$span3</td>";

				$bgcolor=" bgcolor=#66DD88 ";
			
			//	$fi=$grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[6]+$grand_vals[7];
				
				
				echo "<td class=\"BG\" $bgcolor colspan=8>$span1".($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])/$grand_output)*100,1)."%"; } echo "$span3</td>";

			$bgcolor=" bgcolor=white ";
				
				echo "<td class=\"BG\" $bgcolor colspan=3>$span1".($grand_vals[6]+$grand_vals[7]+$grand_vals[8])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[6]+$grand_vals[7]+$grand_vals[8])/$grand_output)*100,1)."%"; } echo "$span3</td>";

			$bgcolor=" bgcolor=#66DD88 ";
				
				echo "<td class=\"BG\" $bgcolor colspan=11>$span1".($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])/$grand_output)*100,1)."%"; } echo "$span3</td>";
			 
			 $bgcolor=" bgcolor=white ";
				
				echo "<td class=\"BG\" $bgcolor colspan=3>$span1".($grand_vals[23]+$grand_vals[24]+$grand_vals[25])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[23]+$grand_vals[24]+$grand_vals[25])/$grand_output)*100,1)."%"; } echo "$span3</td>";
				
				$bgcolor=" bgcolor=#66DD88 ";
				echo "<td class=\"BG\" $bgcolor colspan=8>$span1".($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])/$grand_output)*100,1)."%"; } echo "$span3</td>";
				
				echo "</tr>";
				
			echo "</table></div>";
			//echo "<h2>Total Output: $grand_output</h2>";
			//echo "<h2>Total Rejected: $grand_rejections</h2>";
			//echo "<h2>Reject %: ".round(($grand_rejections/$grand_output)*100,2)."</h2>";
}


?>

</div>
</div>
</div>