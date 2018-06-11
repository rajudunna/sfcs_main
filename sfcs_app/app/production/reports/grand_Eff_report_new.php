<?php 
       include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
?>
		<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'datetimepicker_css.js',1,'R') ?>"></script>

		<!-- <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'style.css',1,'R') ?>" type="text/css" media="all" /> -->

		<!-- <script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'/styles/dropdowntabs.js',1,'R') ?>"></script> -->
		<!-- <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'/styles/ddcolortabs.css',1,'R') ?>" type="text/css" media="all" /> -->
		<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	 -->
<style>
lable{
	color:black;
}
td {
	color:black;
}
th {
	color:white;
	text-weight:bold;
	text-align:center;
}
</style>

<div class="panel panel-primary">
<!-- <div class="panel-heading">Total Factory Production Status</div> -->
<div class="panel-heading">Grand Efficiency Summary Report</div>
<div class="panel-body">
<form method="POST" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
<?php
$sdate=$_POST['dat1'];
$edate=$_POST['dat2'];
?>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-3">
		<label>Start Date:</label>
		<input id="demo1" type="text" data-toggle="datepicker" class="form-control" name="dat1" value=<?php if($sdate!="") { echo $sdate; } else { echo date("Y-m-d"); } ?>>
	</div>
	<div class="col-md-3">
		<label>End Date:</label>
		<input id="demo2" type="text" data-toggle="datepicker" class="form-control" name="dat2" value=<?php if($edate!="") { echo $edate; } else { echo date("Y-m-d"); } ?>>
	</div>
	<div class="col-md-1"><br/>
		<input type="submit" name="submit" id="submit" value="Show" onclick ="return verify_date()" class="btn btn-sm btn-success">
	</div>
</div>
</form>



<?php



if(isset($_POST['submit']))
{
	$edate=$_POST['dat2'];
	$sdate=$_POST['dat1'];
	
	$decimal_factor=2;
		
	// NEW BUFFER Table Selection
   	$table_name="$bai_pro.bai_log";
    $sql="select count(*) as \"row_count\" from $bai_pro.bai_log_buf where bac_date=\"$sdate\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($sql_result))
	{
		$row_count1=$sql_row['row_count'];
	}
	 
	$sql="select count(*) as \"row_count\" from $bai_pro.bai_log_buf where bac_date=\"$edate\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($sql_row=mysqli_fetch_array($sql_result))
	{
		$row_count2=$sql_row['row_count'];
	}

	if($row_count1>1 and $row_count2>1)
	{
		$table_name="$bai_pro.bai_log_buf";
	}
	$table_name2="$bai_pro.bai_quality_log";

		
	echo "<br/><hr/><h4> Report for the period: $sdate to $edate </h4>";
	
	echo "<table id=\"info\" class=\"table table-bordered\">";
	/*echo "<tr>";
	echo "<th>Date</th>";
	echo "<th>Module</th>";
	echo "<th>Shift</th>";
	echo "<th>Section</th>";
	echo "<th>Plan Out</th>";
	echo "<th>Act Out</th>";
	echo "<th>Plan CLH</th>";
	echo "<th>Act CLH</th>";
	echo "<th>Plan STH</th>";
	echo "<th>Act STH</th>";
	echo "</tr>"; */
	
	echo "<tr>";
	echo "<th style='background-color:#29759C;'>Section</th>";
	echo "<th style='background-color:#29759C;'>Team</th>";
	echo "<th style='background-color:#29759C;'>Plan EFF</th>";
	echo "<th style='background-color:#29759C;'>Act EFF</th>";
	echo "<th style='background-color:#29759C;'>Plan STH</th>";
	echo "<th style='background-color:#29759C;'>Act STH</th>";
	echo "<th style='background-color:#29759C;'>Plan PRO</th>";
	echo "<th style='background-color:#29759C;'>Act PRO</th>";
	echo "</tr>";
	
	
$sql222_new="select distinct bac_date from $table_name where bac_date between \"$sdate\" and \"$edate\"";
//echo $sql222_new;
mysqli_query($link, $sql222_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result222_new=mysqli_query($link, $sql222_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row222_new=mysqli_fetch_array($sql_result222_new))
{
	$date=$sql_row222_new['bac_date'];
	
	
	//Date:2013-11-20
	//Ticket #274262
	//Renmoved the where clause for section
	$sql222="select distinct bac_sec from $table_name where bac_date=\"$date\"";
	//echo $sql222;
	mysqli_query($link, $sql222) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result222=mysqli_query($link, $sql222) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row222=mysqli_fetch_array($sql_result222))
	{
		$sec=$sql_row222['bac_sec'];
		
		$sql_new="select distinct bac_shift from $table_name where bac_date=\"$date\" and bac_sec=$sec";
		//echo $sql_new;
		mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result_new=mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_new=mysqli_fetch_array($sql_result_new))
		{
			//Initial
			$mod_tot_pln_output=0;
			$mod_tot_act_output=0;
			$mod_tot_pln_clh=0;
			$mod_tot_act_clh=0;
			$mod_tot_pln_sth=0;
			$mod_tot_act_sth=0;
			
			//Initial
			
			
			$shift=$sql_row_new['bac_shift'];
			
			$sql_new1="select distinct bac_no from $table_name where bac_date=\"$date\" and bac_sec=$sec and bac_shift=\"$shift\"";
			//echo $sql_new1;
			mysqli_query($link, $sql_new1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result_new1=mysqli_query($link, $sql_new1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_new1=mysqli_fetch_array($sql_result_new1))
			{
				$module=$sql_row_new1['bac_no'];

				//COM: Production Total
				$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
				//echo $sql2;
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$act_output=$sql_row2['sum'];
				}
				
				$sql2="select COALESCE(sum(bac_qty),0) as \"sum\" from $table_name2 where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
				//echo $sql2;
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$rework_qty=$sql_row2['sum'];
				}
				
				//COM: Styles
				$style_db=array();
				$buyer_db=array();
				//$sql2="select distinct bac_style  from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
				$sql2="select distinct bac_style  from $table_name where bac_sec=$sec and bac_date=\"$date\" and bac_no=$module";
				//echo $sql2;
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$style_db[]=$sql_row2['bac_style'];
				}
				
				//$sql2="select distinct buyer  from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
				$sql2="select distinct buyer  from $table_name where bac_sec=$sec and bac_date=\"$date\" and bac_no=$module";
				//echo $sql2;
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$buyer_db[]=$sql_row2['buyer'];
				}
				$style_db_new=implode(",",$style_db);
				$buyer_db_new=implode(",",$buyer_db);
			
			//COM: Standard Hours
			$sql2="select sum((bac_qty*smv)/60) as \"stha\" from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
			//echo $sql2;
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$act_sth=$sql_row2['stha'];
			}
			
					
			//COM :Production Hours
			$sql2="select count(distinct hour(bac_lastup)) as \"hoursa\" from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module";
			//echo $sql2;
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$hoursa=$sql_row2['hoursa'];
			}

			if($hoursa==4 && ($sec==3 || $sec==4) )
			{
				$hoursa=$hoursa;	
			}
			else
			{
				if($hoursa>3)
				{
					$hoursa=$hoursa+0.5-1;	
				}
			}

			if($hoursa==11.5 && ($sec==3 || $sec==4) )
			{
				$hoursa=$hoursa;
			}
			else
			{
				if($hoursa>7.5)
				{
					$hoursa=$hoursa+0.5-1;
				}
			}

			//COM: NOP and SMV Selection
			$max=0;
			$sql2="select bac_style,smv,nop, sum(bac_qty) as \"qty\", couple,delivery from $table_name where bac_sec=$sec and bac_shift=\"$shift\" and bac_date=\"$date\" and bac_no=$module group by bac_style";
			//echo $sql2;
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				if($sql_row2['qty']>=$max)
				{
					$style_code_new=$sql_row2['bac_style'];
					$delivery=$sql_row2['delivery'];
					$max=$sql_row2['qty'];
					$smv=$sql_row2['smv'];
					$nop=$sql_row2['nop'];
				}
			}
			//********** disabled due to reports discripency
			/*$sql13="select fix_nop as nop from $bai_pro.pro_plan where mod_no=$module and date=\"".$date."\" and shift=\"".$shift."\"";
			$result13=mysql_query($sql13,$link) or exit("Sql Error".mysql_error());
			while($sql_row13=mysql_fetch_array($result13))
			{
				//$nop=$sql_row13["nop"];
			}
			
			//For Temp Check (Taking Allocated Operators as cadre to calculate Clock Hours)
			$sql13="select (avail_$shift-absent_$shift) as nop from pro_atten where module=$module and date=\"".$date."\"";
			$result13=mysql_query($sql13,$link) or exit("Sql Error".mysql_error());
			while($sql_row13=mysql_fetch_array($result13))
			{
				//$nop=$sql_row13["nop"];
			}
			*/
			
			$days=0;
			$sql2="select days from $bai_pro.pro_style where style=\"$style_code_new\"";
			//echo $sql2;
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$days=$sql_row2['days'];
			}


			//COM: Actual Clock Hours

			$act_clh=$nop*$hoursa;

			//COM: PLAN
			$pln_eff_a=0;
			$pln_output=0;
			$pln_hrs=0;
			$sql2="select plan_eff, plan_pro, act_hours from $bai_pro.pro_plan where sec_no=$sec and shift=\"$shift\" and date=\"$date\" and mod_no=$module";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$pln_eff_a=$sql_row2['plan_eff'];
				$pln_output=$sql_row2['plan_pro'];
				$pln_hrs=$sql_row2['act_hours'];
			}

			//COM: Plan Clock Hours and Standara Hours
			$pln_clh=($pln_hrs*$nop);
			$pln_sth=($pln_output*$smv)/60;
			
			//New 2012-05-21 - Need to do since plan sah has to calculate based on the clock hours (updated in Plan).
			$pln_sth=($pln_clh*$pln_eff_a)/100;
			$act_clh=$pln_clh;
			
			//New 2013-07-27 for actula clock hours calculation
$act_nop=0;			
$sql2="SELECT (CAST(avail_$shift as SIGNED)-CAST(absent_$shift as SIGNED)) as nop FROM $bai_pro.pro_atten WHERE DATE='$date' AND module=$module";
$note.=$sql2."<br/>";
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error40".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$act_nop=$sql_row2['nop'];
			}
			$act_clh=$act_nop*$pln_hrs;

			/*// Table Start
			echo "<tr>";
			echo "<td>$date</td>";
			echo "<td>$module</td>";
			echo "<td>$shift</td>";
			echo "<td>$sec</td>";
			echo "<td>$pln_output</td>";
			echo "<td>$act_output</td>";
			echo "<td>$pln_clh</td>";
			echo "<td>$act_clh</td>";
			echo "<td>$pln_sth</td>";
			echo "<td>$act_sth</td>";
			echo "</tr>";
			// Table End */
			
			$code=$date."-".$module."-".$shift;
			
			$sql2="insert ignore into $bai_pro.grand_rep(tid) values (\"$code\")";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
			//New code to extract values from existing
			
			if(date("Y-m-d")>"2014-06-30")
			{
				$pln_output=0;
				$pln_clh=0;
				$pln_sth=0;
				$sql2="select plan_eff, plan_pro, plan_sah,plan_clh from $bai_pro.pro_plan where sec_no=$sec and shift=\"$shift\" and date=\"$date\" and mod_no=$module";
				$note.=$sql2."<br/>";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error40".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$pln_output=$sql_row2['plan_pro'];
					
					$pln_clh=round($sql_row2['plan_clh'],2);
					$pln_sth=$sql_row2['plan_sah'];
					//echo $plan_sth."<br/>";
				}
				
				if(strlen($pln_clh)==0 or $pln_clh==NULL or $pln_clh=="")
				{
					$pln_clh=0;				
				}
			}
			
			$sql2="update $bai_pro.grand_rep set date=\"$date\", module=$module, shift=\"$shift\", section=$sec, plan_out=$pln_output, act_out=$act_output, plan_clh=$pln_clh, act_clh=$act_clh, plan_sth=$pln_sth, act_sth=$act_sth, styles=\"$style_db_new\", smv=$smv, nop=$nop, buyer=\"$buyer_db_new\", days=$days,rework_qty=$rework_qty,max_style=\"$delivery^$style_code_new\" where tid=\"$code\"";
			//echo $sql2."<br/>";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));			
		
		} //Module		
	} //Shift
	
} //Section
} // Date

			//SECTION Breakup
			//Date:2013-11-20
			//Ticket #274262
			//Renmoved the where clause for section
			$sql2="select distinct section from $bai_pro.grand_rep where date between \"$sdate\" and \"$edate\" order by section";
			mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$section=$sql_row2['section'];
					
				$check=0;
				
				$sql_new="select distinct shift from $bai_pro.grand_rep where section=$section and date between \"$sdate\" and \"$edate\"";
				mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result_new=mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rowspan=mysqli_num_rows($sql_result_new);
				while($sql_row_new=mysqli_fetch_array($sql_result_new))
				{
					$shift=$sql_row_new['shift'];
					
					echo "<tr>";
					if($check==0)
					{
						echo "<td rowspan=$rowspan>$section</td>";
						$check=1;
					}
					echo "<td>$shift</td>";
					
					$sql="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from $bai_pro.grand_rep where section=$section and shift=\"$shift\" and date between \"$sdate\" and \"$edate\"";
					//echo $sql."<br/>";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    				while($sql_row=mysqli_fetch_array($sql_result))
					{
						$plan_sth=$sql_row['plan_sth'];
						$plan_clh=$sql_row['plan_clh'];
						$act_sth=$sql_row['act_sth'];
						$act_clh=$sql_row['act_clh'];
						$plan_out=$sql_row['plan_out'];
						$act_out=$sql_row['act_out'];
					}
					
				
					echo "<td>".round(($plan_sth/$plan_clh)*100,0)."%</td>";
					echo "<td>".round(($act_sth/$act_clh)*100,0)."%</td>";
					echo "<td>".round($plan_sth,$decimal_factor)."</td>";
					echo "<td>".round($act_sth,$decimal_factor)."</td>";
					echo "<td>".round($plan_out,0)."</td>";
					echo "<td>".round($act_out,0)."</td>";
					echo "</tr>";
				}
				
			}
				
				//Total Breakup
				//Date:2013-11-20
				//Ticket #274262
				//Renmoved the where clause for section
				$check=0;
				$sql_new="select distinct shift from $bai_pro.grand_rep where date between \"$sdate\" and \"$edate\"";
				mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result_new=mysqli_query($link, $sql_new) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rowspan=mysqli_num_rows($sql_result_new);
				while($sql_row_new=mysqli_fetch_array($sql_result_new))
				{
					$shift=$sql_row_new['shift'];
					
					echo "<tr bgcolor=\"yellow\">";
					if($check==0)
					{
						echo "<td rowspan=$rowspan>Total</td>";
						$check=1;
					}
					echo "<td>$shift</td>";
					
					$sql="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from $bai_pro.grand_rep where shift=\"$shift\" and date between \"$sdate\" and \"$edate\"";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    				while($sql_row=mysqli_fetch_array($sql_result))
					{
						$plan_sth=$sql_row['plan_sth'];
						$plan_clh=$sql_row['plan_clh'];
						$act_sth=$sql_row['act_sth'];
						$act_clh=$sql_row['act_clh'];
						$plan_out=$sql_row['plan_out'];
						$act_out=$sql_row['act_out'];
					}
					
				
					echo "<td>".round(($plan_sth/$plan_clh)*100,0)."%</td>";
					echo "<td>".round(($act_sth/$act_clh)*100,0)."%</td>";
					echo "<td>".round($plan_sth,$decimal_factor)."</td>";
					echo "<td>".round($act_sth,$decimal_factor)."</td>";
					echo "<td>".round($plan_out,0)."</td>";
					echo "<td>".round($act_out,0)."</td>";
					echo "</tr>";
				}
				
				//Grand Total
				
					echo "<tr class=\"total\">";
					echo "<td colspan=2>Grand Total</td>";
										
					$sql="select ROUND(sum(plan_sth),$decimal_factor) as \"plan_sth\", ROUND(sum(plan_clh),$decimal_factor) as \"plan_clh\", ROUND(sum(act_sth),$decimal_factor) as \"act_sth\", ROUND(sum(act_clh),$decimal_factor) as \"act_clh\", sum(plan_out) as \"plan_out\", sum(act_out) as \"act_out\" from $bai_pro.grand_rep where date between \"$sdate\" and \"$edate\"";
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    				while($sql_row=mysqli_fetch_array($sql_result))
					{
						$plan_sth=$sql_row['plan_sth'];
						$plan_clh=$sql_row['plan_clh'];
						$act_sth=$sql_row['act_sth'];
						$act_clh=$sql_row['act_clh'];
						$plan_out=$sql_row['plan_out'];
						$act_out=$sql_row['act_out'];
					}
					
				
					echo "<td>".round(($plan_sth/$plan_clh)*100,0)."%</td>";
					echo "<td>".round(($act_sth/$act_clh)*100,0)."%</td>";
					echo "<td>".round($plan_sth,$decimal_factor)."</td>";
					echo "<td>".round($act_sth,$decimal_factor)."</td>";
					echo "<td>".round($plan_out,0)."</td>";
					echo "<td>".round($act_out,0)."</td>";
					echo "</tr>";
				
echo "</table>";

}

?>
</div>
</div>
</div>
</div>
<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>
<script type="text/javascript">
	function verify_date(){
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
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