<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php   

//$reasons=array("Miss Yarn","Fabric Holes","Slub","Foreign Yarn","Stain Mark","Color Shade","Panel Un-Even","Stain Mark","Strip Match","Cut Dmg","Stain Mark","Heat Seal","M ment Out","Shape Out","Emb Defects");
$reasons=array("Miss Yarn","Fabric Holes","Slub","F.Yarn","Stain Mark","Color Shade","Heat Seal","Trim","Panel Un-Even","Stain Mark","Strip Match","Cut Damage","Heat Seal","M' ment Out","Un Even","Shape Out Leg","Shape Out waist","Shape Out","Stain Mark","With out Label","Trim shortage","Sewing Excess",
"Cut Holes","Slip Stitch's","Oil Marks","Others EMB","Foil Defects","Embroidery","Print","Sequence","Bead","Dye","wash");



?>


<meta http-equiv="refresh" content="180">
		<style>
		h1{
			font-size: 80px;
		}
			body
			{
				font-family:calibri;
				font-size:12px;
				zoom: 100%;
			}

			table tr
			{
				border: 1px solid black;
				text-align: right;
				white-space:nowrap; 
			}

			table td
			{
				border: 1px solid black;
				text-align: right;
			white-space:nowrap; 
			height:35px;
			}

			table th
			{
				border: 1px solid black;
				text-align: center;
			    	background-color: BLUE;
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
			background-image:url(Diag.gif);
			background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
			background-position:center middle;
			}
		</style>
		<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',4,'R'); ?>"></script>
	<body>
	<div class="panel panel-primary">
	<div class="panel-heading">Daily Rejection Detail Report - Module <?php echo $module; ?></div>
	<div class="panel-body">
	<div class="table-responsive">
	<?php
	if(isset($_GET['module']))
	{
		$module=$_GET['module'];
	}
	else
	{
		$module=1;
	}
	?>
		<!--<div id="page_heading"><span style="float: left"><h3>Daily Rejection Detail Report - Module <?php echo $module; ?></h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->

		<?php

		{
	
			$sdate=date("Y-m-d");
			$edate=date("Y-m-d");
			
			//$sdate='2017-11-02';
			//$edate=$sdate;
			
			$choice=0;
			
			$sec_db=$module;
			
			$col_heading=array("Fabric","Cutting","Sewing","Machine Damages","Embellishment");
			/*$start_key=array(0,8,11,22,25);
			$end_key=array(8,11,22,25,33); */
			
			$start_key=array(0,11,22);
			$end_key=array(11,22,33);
			
			$sql="select sum(bac_qty) as \"output\", bac_no from $bai_pro.bai_log where bac_no in ($sec_db) and bac_date between \"$sdate\" and \"$edate\" group by bac_no";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

					while($sql_row=mysqli_fetch_array($sql_result))
					{
						
												
						$sw_out=$sql_row['output'];
					}
					
					$sql="select COALESCE(sum(bac_qty),0) as \"output\", bac_no from $bai_pro.bai_quality_log where bac_no in ($sec_db) and bac_date between \"$sdate\" and \"$edate\" group by bac_no";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						
												
						$rework_out=$sql_row['output'];
					}
					
					if($rework_out=="")
					{
						$rework_out=0;
					}
					
					$sql="select COALESCE (sum(qms_qty),0) as \"qms_qty\" from $bai_pro3.bai_qms_db where qms_tran_type=3 and substring_index(remarks,\"-\",1)=\"$mod\" and log_date between \"$sdate\" and \"$edate\"";
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$rejected_qty=$sql_row['qms_qty'];
					}
					if(mysqli_num_rows($sql_result)==0)
					{
						$rejected_qty=0;
					}
				$td_url= $_SERVER['HTTP_HOST'].'/sfcs_app/app/dashboards/controllers/quality_endline_display/module.php';
				//echo $td_url;
				//$td_url= 'module.php';
				echo "<table class='table table-bordered'>";
				echo "<tr class='tblheading'>";
				echo "<th>Sewing Output</th><th>Rework Qty</th><th>Rework %</th><th>Rejected Qty</th><th>Rejected %</th> <th>Hourly Rework Trend</th>";
				echo "</tr>";
				echo "<tr>";
				echo "<td><h1>$sw_out</h1></td>";
				echo "<td><h1><font color=blue>$rework_out</font></h1></td>";
				echo "<td><h1><font color=blue>".($sw_out>0?round((($rework_out/$sw_out)*100),0):0)."%</font></h1></td>";
				echo "<td><h1><font color=red>$rejected_qty</font></h1></td>";
				echo "<td><h1><font color=red>".($sw_out>0?round((($rejected_qty/$sw_out)*100),0):0)."%</font></h1></td>";

				echo "<td><iframe src=\"http://$td_url?module=$module\" width=700 height=100></iframe></td>";
				echo "</tr>";
				echo "</table><br/>";
	
			
					
			for($y=0;$y<5;$y++)
			{

				echo "<br/>";
				echo "<table class='table table-bordered'>";
				echo "<tr class='tblheading'>";
					
					
					if($y==0) { echo "<th colspan=8>Fabric</th>"; }
					
					if($y==0) { echo "<th colspan=3>Cutting</th>"; }
					if($y==1) { echo "<th colspan=11>Sewing</th>"; }
					if($y==2) { echo "<th colspan=3>Machine Damages</th>"; }
					if($y==2) { echo "<th colspan=8>Embellishment</th>"; }
			echo "</tr>";

					echo "<tr class='tblheading'>";
					for($i=$start_key[$y];$i<$end_key[$y];$i++) {
						echo "<th>".$reasons[$i]."</th>";
					}
					echo "</tr>";
					
					/*
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
					*/
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
						
						for($i=$start_key[$y];$i<$end_key[$y];$i++) {	$grand_vals[$i]=0;	}
						$grand_output=0;
						$grand_rejections=0;

					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
					

					while($sql_row=mysqli_fetch_array($sql_result))
					{
						
						$mod=$sql_row['bac_no'];
						$shif=$sql_row['bac_shift'];
						$delivery=$sql_row['delivery'];
						echo "<tr>";
						
						
						$sw_out=$sql_row['output'];
						
						$sql1x="SET SESSION group_concat_max_len = 1000000";
						mysqli_query($link, $sql1x) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

						
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
						$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row1=mysqli_fetch_array($sql_result1))
						{
							$ref=$sql_row1['ref1'];
							$qms_qty=$sql_row1['qms_qty'];
						}
						
						if($qms_qty==0 or $qms_qty==NULL)
						{
							$qms_qty=0;
						}
						
						$span1='<p style="text-align: left;">';
						$span2='<p style="padding-left:20px; margin-top:-20px; position:relative; ">';
						$span3='</p>';
					
					
						//echo $sql_row['bac_no']."=".strlen($ref);	
						$vals=array();
						$rej_val=array(0,1,2,3,4,5,15,16,6,7,8,9,11,12,17,18,19,13,10,20,21,22,23,24,25,14,26,27,28,29,30,31,32);
						for($i=$start_key[$y];$i<$end_key[$y];$i++) {	$vals[$i]=0;	}
						
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
						
						for($i=$start_key[$y];$i<$end_key[$y];$i++) {
						
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
					
				
					$bgcolor=" bgcolor=#66DD88 ";
				
				//	$fi=$grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[6]+$grand_vals[7];
					
					
					if($y==0) { echo "<td class=\"BG\" $bgcolor colspan=8>$span1".($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[0]+$grand_vals[1]+$grand_vals[2]+$grand_vals[3]+$grand_vals[4]+$grand_vals[5]+$grand_vals[15]+$grand_vals[16])/$grand_output)*100,1)."%"; } echo "$span3</td>";
					}
				$bgcolor=" bgcolor=white ";
					if($y==0) { 
					echo "<td class=\"BG\" $bgcolor colspan=3>$span1".($grand_vals[6]+$grand_vals[7]+$grand_vals[8])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[6]+$grand_vals[7]+$grand_vals[8])/$grand_output)*100,1)."%"; } echo "$span3</td>";
					}
				$bgcolor=" bgcolor=#66DD88 ";
					if($y==1) { 
					echo "<td class=\"BG\" $bgcolor colspan=11>$span1".($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[9]+$grand_vals[11]+$grand_vals[12]+$grand_vals[17]+$grand_vals[18]+$grand_vals[19]+$grand_vals[13]+$grand_vals[10]+$grand_vals[20]+$grand_vals[21]+$grand_vals[22])/$grand_output)*100,1)."%"; } echo "$span3</td>";
					}
				 $bgcolor=" bgcolor=white ";
					if($y==2) { 
					echo "<td class=\"BG\" $bgcolor colspan=3>$span1".($grand_vals[23]+$grand_vals[24]+$grand_vals[25])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[23]+$grand_vals[24]+$grand_vals[25])/$grand_output)*100,1)."%"; } echo "$span3</td>";
					}
					$bgcolor=" bgcolor=#66DD88 ";
					if($y==2) { 
					echo "<td class=\"BG\" $bgcolor colspan=8>$span1".($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])."$span3$span2"; if($grand_output>0) { echo round((($grand_vals[14]+$grand_vals[26]+$grand_vals[27]+$grand_vals[28]+$grand_vals[29]+$grand_vals[30]+$grand_vals[31]+$grand_vals[32])/$grand_output)*100,1)."%"; } echo "$span3</td>";
					}
					echo "</tr>";
					
				echo "</table>";
		
			}
			
}


?>
</div></div></div>
</body>