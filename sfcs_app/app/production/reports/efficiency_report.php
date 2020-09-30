<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>
<script>
$(function(){
	today=new Date();
	var month,day,year;
	year=today.getFullYear();
	month=today.getMonth();
	date=today.getDate();
	var backdate = new Date(year,month-3,date)
	$('.datepicker1').datepicker({
	format: 'yyyy-mm-dd',
	startDate: backdate,
	endDate: '+0d',
	autoHide: true
    });
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
		startDate: backdate,
        endDate: '+0d',
        autoHide: true
    });
});

function verify(){
	var from = document.getElementById('demo1').value;
	var to = document.getElementById('demo2').value;
	if( from > to){
		sweetAlert('To date should be greater than From date ','','warning');
		return false;
	}
}
</script>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
<title>Daily SAH</title>
<!-- <script type="text/javascript" src="jquery.min.js"></script> -->
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="SAH%20-JUN_files/filelist.xml">
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FileSaver.js',1,'R');?>"></script>
<style id="SAH -JUN_13441_Styles">

</style>
<div class="panel panel-primary">
<div class="panel-heading"> Efficiency Report</div>	
<div class="panel-body">
<form method="POST" class="form-inline" onsubmit="return verify();" action=<?php getFullURLLevel($_GET['r'],'efficiency_report.php',0,'N') ?> >
<body>
    <div class="row">
		<div class="col-sm-2">
			<label>From Date :</label><br>
			<input id="demo1" type="text"  class="form-control datepicker" size="8" name="fdat" value=<?php if(isset($_POST['fdat'])) { echo $_POST['fdat']; } else { echo date("Y-m-d"); } ?>>
		</div>
		<div class="col-sm-2">
				<label for='demo2'>To Date :</label><br>
				<input id="demo2" class="form-control datepicker" type="text"  size="8" name="tdat" value=<?php if(isset($_POST['tdat'])) { echo $_POST['tdat']; } else { echo date("Y-m-d"); } ?>>
		</div>
		<div class='col-sm-1'>
			<br/><input type="submit" name="submit" value="Show" class="btn btn-primary">
		</div>
		<div class='col-sm-1'>
			<br/><input id="excel" type="button"  class="btn btn-success" value="Export To Excel" onclick="getCSVData()">

		</div>
		
	</div>	
	</form>
</br>
<?php

if(isset($_POST['submit']))
{
	$fdat=$_POST['fdat'];
    $tdat=$_POST['tdat'];
	function remove_element($array,$value) {
	  return array_diff($array, (is_array($value) ? $value : array($value)));
	}
	$result = remove_element($shifts_array,'ALL');
	$shifts_array=array();
	$shifts_array=array_values($result);
 	$rowspan=sizeof($shifts_array);
    echo '<div class="row"><div class="col-sm-2"><input type="checkbox"  id="checkbox" name="checkbox">&nbsp <b>Hide Style Info</b></div>';
	if($rowspan>1)
	{
		echo'<div class="col-sm-2"><input type="checkbox"  id="checkbox1" name="checkbox1" checked="checked">&nbsp <b>Enable Summary</b></div></div>';
	}
	else
	{
		echo'<div class="col-sm-2"></div></div>';
	}
    echo "<div class='table-responsive' id='report'>
   <table  class=\"table table-bordered\" id='example1' name='example1' style='border: 1px black solid'>";
   if($rowspan>1)
	{
		$rowspans=$rowspan+1;
		
	}
	else
	{
		$rowspans=$rowspan;
	}
	
	echo"<tr>
   <th rowspan=2 >Line No</th>
   <th rowspan=2 >Shift</th>
   <th id='test' style='background-color:#e6fff8;' rowspan=2>Customer</th>
   <th id='style' style='background-color:#e6fff8;' rowspan=2>Style</th>
   <th id='smv' style='background-color:#e6fff8;' rowspan=2>SMV</th>
   <th id='days' style='background-color:#e6fff8;' rowspan=2>No of Days</th>
   <th id='team' colspan=2>No of TM</th>
   <th colspan=2>Clock Hours</th>
   <th colspan=3>Output</th>
   <th colspan=3>SAH</th>
   <th colspan=2>Efficiency</th></tr>";
	echo"<tr>
	<th style='background-color:#ccddff;' colspan=1 rowspan=1>Plan</th>
	<th style='background-color:#d6f5d6;' colspan=1 rowspan=1>Actual</th>
	<th style='background-color:#ccddff;' colspan=1 rowspan=1>Plan</th>
	<th style='background-color:#d6f5d6;' colspan=1 rowspan=1>Actual</th>
	<th style='background-color:#ccddff;' colspan=1 rowspan=1>Plan</th>
	<th style='background-color:#d6f5d6;' colspan=1 rowspan=1>Actual</th>
	<th colspan=1 rowspan=1>Variance</th>
	<th style='background-color:#ccddff;' colspan=1 rowspan=1>Plan</th>
	<th style='background-color:#d6f5d6;' colspan=1 rowspan=1>Actual</th>
	<th style='' colspan=1 rowspan=1>Variance</th>
	<th style='background-color:#ccddff;' colspan=1 rowspan=1>Plan</th>
	<th style='background-color:#d6f5d6;' colspan=1 rowspan=1>Actual</th>
	</tr></n></n><br></br>";
	$output=array();
	$sah=array();
	$no_of_days=array();
	$buyer_code=array();
	$style_name=array();
	$order_div=array();
	$smv=array();
	$plan_eff=array();
	$plan_clh=array();
	$plan_sah=array();
	$plan_pro=array();
	$nop=array();
	$modules=array();
	$effective_shift_working_hours=array();
	$sql="select * from $bai_pro3.module_master where status='Active' ORDER BY module_name*1";
	$result=mysqli_query($link, $sql) or die("Error =8 ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($result))
	{ 
		$modules[]=$row["module_name"];
	}
	


	$sql2="SELECT operation_code  FROM $brandix_bts.`tbl_orders_ops_ref` where category='sewing'";
	$result2=mysqli_query($link, $sql2) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row2=mysqli_fetch_array($result2))
	{
		$operation_code_array[]=$row2['operation_code'];
	
	}
	
	$operation_codes = implode("','", $operation_code_array);
	//Getting Actuals
	$sql3="SELECT style,sfcs_smv,recevied_qty,assigned_module,shift  FROM $brandix_bts.`bundle_creation_data_temp` 
	WHERE  date_time between '".$fdat." 00:00:00' and '".$tdat." 23:59:59' and sfcs_smv>0 and operation_id in ('$operation_codes')";

	$result3=mysqli_query($link, $sql3) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row3=mysqli_fetch_array($result3))
	{           
		$sah[$row3["assigned_module"]][$row3["shift"]]=$sah[$row3["assigned_module"]][$row3["shift"]]+($row3["recevied_qty"]*$row3["sfcs_smv"]/60);
		$output[$row3["assigned_module"]][$row3["shift"]]=$output[$row3["assigned_module"]][$row3["shift"]]+$row3["recevied_qty"];
	}
	
	//Getting Styles and SMV
	$sql6="SELECT GROUP_CONCAT(DISTINCT style) AS style, GROUP_CONCAT(DISTINCT sfcs_smv) AS sfcs_smv, COUNT(DISTINCT DATE(date_time)) AS days, assigned_module,shift FROM brandix_bts.`bundle_creation_data_temp` WHERE date_time BETWEEN '".$fdat." 00:00:00' and '".$tdat." 23:59:59' and sfcs_smv>0 and operation_id in('$operation_codes') group by assigned_module,shift";
	$result6=mysqli_query($link, $sql6) or die("Sql Error2: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));  
	while($row6=mysqli_fetch_array($result6))
	{
		$no_of_days[$row6["assigned_module"]][$row6["shift"]]=$row6["days"];
		$style_name[$row6["assigned_module"]][$row6["shift"]]=trim($row6["style"]);
		$smv[$row6["assigned_module"]][$row6["shift"]]=$row6["sfcs_smv"];
		//Buyer Name
		$sql61="SELECT order_div FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_style_no in ('".str_replace(",","','",$row6["style"])."') group by order_div";
		$result61=mysqli_query($link, $sql61) or die("Sql Error3: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));  
		while($row61=mysqli_fetch_array($result61))
		{
			$order_div[]=$row61['order_div'];
		}
		//Buyer Code
		$sql612="SELECT buyer_code FROM $bai_pro2.`buyer_codes` WHERE buyer_name in ('".implode("','",$order_div)."') group by buyer_code";
		$result612=mysqli_query($link, $sql612) or die("Sql Error4: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));  
		while($row612=mysqli_fetch_array($result612))
		{
			$buyer_code[$row6["assigned_module"]][$row6["shift"]]=$row612['buyer_code'];
		}
		unset($order_div);
	}
	
	// Getting Plan details
	for($j=0;$j<sizeof($modules);$j++)
	{		
		for ($jj=0; $jj < sizeof($shifts_array); $jj++) 
		{
			$sql1="SELECT mod_no,shift,AVG(plan_eff) AS plan_eff,SUM(plan_pro) AS plan_pro,SUM(plan_clh) AS plan_clh,SUM(plan_sah) AS plan_sah,SUM(fix_nop) AS nop FROM $bai_pro.pro_plan WHERE date between '".$fdat."' and '".$tdat."' and mod_no='".$modules[$j]."' and shift='".$shifts_array[$jj]."' group by mod_no,shift";
			$result1=mysqli_query($link, $sql1) or die("Error5 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($result1)!='')
			{
				while($row1=mysqli_fetch_array($result1))
				{
					$plan_eff[$row1["mod_no"]][$row1["shift"]]=round($row1["plan_eff"],2);
					$plan_clh[$row1["mod_no"]][$row1["shift"]]=$row1["plan_clh"];
					$plan_sah[$row1["mod_no"]][$row1["shift"]]=$row1["plan_sah"];
					$plan_pro[$row1["mod_no"]][$row1["shift"]]=$row1["plan_pro"];
					$nop[$row1["mod_no"]][$row1["shift"]]=$row1["nop"];
				}  
			}
			else
			{
				$plan_eff[$modules[$j]][$shifts_array[$jj]]=0;
				$plan_clh[$modules[$j]][$shifts_array[$jj]]=0;
				$plan_sah[$modules[$j]][$shifts_array[$jj]]=0;
				$plan_pro[$modules[$j]][$shifts_array[$jj]]=0;
				$nop[$modules[$j]][$shifts_array[$jj]]=0;
			}
			// Getting Working Hours
			$sql7="select date,module,shift,present,jumper from $bai_pro.`pro_attendance` WHERE  date between '".$fdat."' and '".$tdat."' and module='".$modules[$j]."' and shift='".$shifts_array[$jj]."' order by module*1";
			$result7=mysqli_query($link, $sql7) or die("Sql Error6: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"])); 
			if(mysqli_num_rows($result7)!='')
			{		
				while($row7=mysqli_fetch_array($result7))
				{
					$smo[$row7["module"]][$row7["shift"]]=$smo[$row7["module"]][$row7["shift"]]+$row7["present"]+$row7["jumper"];
					$temp_smo=$row7["present"]+$row7["jumper"];
					$sql8="select start_time,end_time FROM $bai_pro.pro_atten_hours where date='".$row7["date"]."' and shift='".$row7["shift"]."'";					
					$sql_result8=mysqli_query($link, $sql8) or exit ("Sql Error7: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row8=mysqli_fetch_array($sql_result8))
					{
						$start_time=$sql_row8['start_time'];
						$end_time=$sql_row8['end_time'];
						$sql81="select start_time FROM $bai_pro3.tbl_plant_timings where time_value='".$start_time."'";				
						$sql_result81=mysqli_query($link, $sql81) or exit ("Sql Error7: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row81=mysqli_fetch_array($sql_result81))
						{
							$start=$sql_row81['start_time'];
						}
						
						$sql82="select end_time FROM $bai_pro3.tbl_plant_timings where time_value='".$end_time."'";						
						$sql_result82=mysqli_query($link, $sql82) or exit ("Sql Error7: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row82=mysqli_fetch_array($sql_result82))
						{
							$end='';
							$data=explode(":",$sql_row82['end_time']);
							for($i=0;$i<sizeof($data);$i++)
							{
								if($i==0)
								{
									$end .= $data[$i];
								}
								else
								{
									if($data[$i]=='59')
									{									
										$end .= ":00";
									}
									else
									{
										$end .= ":".($data[$i]+1);
									}								
								}
							}
						}						
						$time1 = strtotime($start);
						$time2 = strtotime($end);
						$difference = round(abs($time2 - $time1) / 3600,2);
						$effective_shift_working_hours[$row7["module"]][$row7["shift"]] = $effective_shift_working_hours[$row7["module"]][$row7["shift"]]+($temp_smo*(($difference)-($breakhours/60)));
					}	
					$temp_smo=0;					
				}
			}
			else
			{
				$smo[$modules[$j]][$shifts_array[$jj]]=0;
				$effective_shift_working_hours[$modules[$j]][$shifts_array[$jj]]=0;
			}
		}
			
	}
	
	
	for ($ii=0; $ii < sizeof($modules); $ii++) 
	{    
		echo"<tr>";
		$module_name=$modules[$ii];
		echo "<td rowspan=$rowspans>".$module_name."</td>";  
		$plan_smo=0;
		$plant_clh_total=0;
		$plan_clh_count=0;
		$plan_clock_hours_total=0;
		$plan_output_total=0;
		$plan_sah_total=0;
		$actual_clock_hours_total=0;
		$actual_bac_qty_total=0;
		$actual_sah_total=0;
		$actual_eff_total=0;	
		$total_no_of_days=0;
		$total_var_out=0;
		$total_var_sah=0;	
		$act_smo=0;	
		for ($i=0; $i < sizeof($shifts_array); $i++) 
		{		
			echo"<td>".$shifts_array[$i]."</td>
			<td class='test1'>".implode("<br>",explode(",",$buyer_code[$module_name][$shifts_array[$i]]))."</td>
			<td class='style1'>".implode("<br>",explode(",",$style_name[$module_name][$shifts_array[$i]]))."</td>
			<td class='smv1'>".implode("<br>",explode(",",$smv[$module_name][$shifts_array[$i]]))."</td>";		
			echo"<td class='days1'>".$no_of_days[$module_name][$shifts_array[$i]]."</td>";
			echo" <td colspan=1>".$nop[$module_name][$shifts_array[$i]]."</td>";
			$value=0;
			$actual_clock_hours=0;
			// echo Checking Adjustments;
			$sql91="SELECT SUM(smo_adjustment_hours) as hrs FROM $bai_pro.`pro_attendance_adjustment` WHERE date between '".$fdat."' and '".$tdat."' AND module ='$module_name' AND shift ='$shifts_array[$i]'";
			$result91=mysqli_query($link, $sql91) or die("Sql Error9: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"])); 
			$adjustment_count=mysqli_num_rows($result91);
			if($adjustment_count >0)
			{
				while($row9=mysqli_fetch_array($result91))
				{
					$value =$value+$row9["hrs"];		
				}	
				$actual_clock_hours=$effective_shift_working_hours[$module_name][$shifts_array[$i]]+$value;			
			}
			else
			{
				$actual_clock_hours=$effective_shift_working_hours[$module_name][$shifts_array[$i]];
			}
			
			
			if($actual_clock_hours>0)
			{	
				$actual_eff=(($sah[$module_name][$shifts_array[$i]]/$actual_clock_hours)*100);
			}
			else
			{
				$actual_eff=0;
			}
			echo"<td colspan=1>".$smo[$module_name][$shifts_array[$i]]."</td>
			<td colspan=1>".round($plan_clh[$module_name][$shifts_array[$i]],2)."</td>
			<td colspan=1>".round($actual_clock_hours,2)."</td>
			<td colspan=1>".round($plan_pro[$module_name][$shifts_array[$i]],2)."</td>
			<td colspan=1>".round($output[$module_name][$shifts_array[$i]],2)."</td>
			<td colspan=1>".round($plan_pro[$module_name][$shifts_array[$i]]-$output[$module_name][$shifts_array[$i]],2)."</td>
			<td colspan=1>".round($plan_sah[$module_name][$shifts_array[$i]],2)."</td>
			<td colspan=1>".round($sah[$module_name][$shifts_array[$i]],2)."</td>
			<td colspan=1>".round(($plan_sah[$module_name][$shifts_array[$i]]-$sah[$module_name][$shifts_array[$i]]),2)."</td>
			<td colspan=1>".round($plan_eff[$module_name][$shifts_array[$i]],2)."</td>
			<td colspan=1>".round($actual_eff,2)."</td>";
			echo"</tr>"; 
			$plan_smo += $nop[$module_name][$shifts_array[$i]];	
			$act_smo += $smo[$module_name][$shifts_array[$i]];	
			$plan_clock_hours_total += $plan_clh[$module_name][$shifts_array[$i]];	
			$actual_clock_hours_total += $actual_clock_hours;	
			$plan_sah_total += round($plan_sah[$module_name][$shifts_array[$i]],2);	
			$actual_sah_total += round($sah[$module_name][$shifts_array[$i]],2);	
			$plan_output_total += $plan_pro[$module_name][$shifts_array[$i]];	
			$actual_bac_qty_total += $output[$module_name][$shifts_array[$i]];	
			$planeff_temp[] = round($plan_eff[$module_name][$shifts_array[$i]],2);	
			$acteff_temp[] = round($actual_eff,2);	
			$total_no_of_days +=$no_of_days[$module_name][$shifts_array[$i]];			
			$total_var_out +=round($plan_pro[$module_name][$shifts_array[$i]]-$output[$module_name][$shifts_array[$i]],2);			
			$total_var_sah +=round(($plan_sah[$module_name][$shifts_array[$i]]-$sah[$module_name][$shifts_array[$i]]),2);			
		}
		
		if($rowspan>1)
		{
			// Act Eff
			$p_eff=0;
			$eff=0;
			if($actual_clock_hours_total>0)
			{	
				$eff=(($actual_sah_total/$actual_clock_hours_total)*100);
			}
			else
			{
				$eff=0;
			}
			//Plan Eff
			if($plan_clock_hours_total>0)
			{	
				$p_eff=(($plan_sah_total/$plan_clock_hours_total)*100);
			}
			else
			{
				$p_eff=0;
			}
			echo"<tr >";
			echo"<td class='summary'>".implode("+",$shifts_array)."</td>
			<td class='test2'>-</td>";
			echo" <td class='style2'>-</td>
			<td class='smv2'>-</td>
			<td class='days2'>".$total_no_of_days."</td>
			<td colspan=1 class='summary1'>".round($plan_smo,2)."</td>
			<td colspan=1 class='summary2'>".round($act_smo,2)."</td>
			<td colspan=1 class='summary3'>".round($plan_clock_hours_total,2)."</td>
			<td colspan=1 class='summary4'>".round($actual_clock_hours_total,2)."</td>
			<td colspan=1 class='summary5'>".round($plan_output_total,2)."</td>
			<td colspan=1 class='summary6'>".round($actual_bac_qty_total,2)."</td>
			<td colspan=1 class='summary7'>".round($total_var_out,2)."</td>
			<td colspan=1 class='summary8'>".round($plan_sah_total,2)."</td>
			<td colspan=1 class='summary9'>".round($actual_sah_total,2)."</td>
			<td colspan=1 class='summary10'>".round($total_var_sah,2)."</td>
			<td colspan=1 class='summary11'>".round($p_eff,2)."</td>
			<td colspan=1 class='summary12'>".round($eff,2)."</td>";
			echo"</tr>"; 
			
		}
		unset($planeff_temp);
		unset($acteff_temp);
	}
	echo "</table></div>";
}
?>
</body>
      </div>

       </div>
</div>
 <script type="text/javascript">

	$('#excel').click(function(){		
        var blob = new Blob([document.getElementById('report').innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
		});
		saveAs(blob,"Efficiency_Report.xls");
		return;
    })
</script>


<script>
    $("#checkbox").click(function() {
    if($(this).is(":checked")) {
        $("#test").hide();
        $("#style").hide();
        $("#smv").hide();
        $("#days").hide();
        $(".test1").hide();
        $(".style1").hide();
        $(".smv1").hide();
        $(".days1").hide();
     }
     else
     {	  
        $("#test").show();
        $("#style").show();
        $("#smv").show();
        $("#days").show();
        $(".test1").show();
        $(".style1").show();
        $(".smv1").show();
        $(".days1").show();
		if($('#checkbox1').not(':checked').length){
		a$(".style2").hide();
        $(".smv2").hide();
        $(".days2").hide();
        $(".test2").hide(); 
		} 
		$(".style2").show();
        $(".smv2").show();
        $(".days2").show();
        $(".test2").show(); 
		
    }
	
	if($("#checkbox").is(":checked") && $("#checkbox1").is(":checked")) {
		$(".style2").hide();
        $(".smv2").hide();
        $(".days2").hide();
        $(".test2").hide(); 
	}
	
});

$("#checkbox1").click(function() {
   if($(this).is(":checked")) {
		$(".summary").show();
        $(".summary1").show();
        $(".summary2").show();
        $(".summary3").show();
        $(".summary4").show();
        $(".summary5").show();
        $(".summary6").show();
        $(".summary7").show();
        $(".summary8").show();
        $(".summary9").show();
        $(".summary10").show();
        $(".summary11").show();
        $(".summary12").show();
		$(".style2").show();
        $(".smv2").show();
        $(".days2").show();
        $(".test2").show();
		if($("#checkbox").is(":checked")) {
		$(".style2").hide();
        $(".smv2").hide();
        $(".days2").hide();
        $(".test2").hide(); 
		}
		
    }else{      
        $(".summary").hide();
        $(".summary1").hide();
        $(".summary2").hide();
        $(".summary3").hide();
        $(".summary4").hide();
        $(".summary5").hide();
        $(".summary6").hide();
        $(".summary7").hide();
        $(".summary8").hide();
        $(".summary9").hide();
        $(".summary10").hide();
        $(".summary11").hide();
        $(".summary12").hide();
		$(".style2").hide();
        $(".smv2").hide();
        $(".days2").hide();
        $(".test2").hide();
    }

});
</script>
<style>        
	th,td{
	text-align:center;
	color:black;
	}		
</style>

