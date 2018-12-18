<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

?>

<meta http-equiv="X-UA-Compatible" content="IE=8" />

<script language="javascript" type="text/javascript" src="<?= $dateurl ?>"></script>
<script language="javascript" type="text/javascript" src="<?= $ddurl ?>"></script>

<style>

@media print {
@page narrow {size: 11in 9in}
@page rotated {size: landscape}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { 
display: block; 
padding-left:20px; }
#logo { display: block; }
body {
zoom:75%; 
}
}

@media screen{
#logo { display: none; }
}
</style>

<script>
	function verify_date(){
		var from = document.getElementById('demo1').value;
		var to   = document.getElementById('demo2').value;
		if(from > to ){
			sweetAlert('Start date must not be greater than End date','','warning');
			return false;
		}
		return;
	}

	function displayStatus(){
		var w = window.open("","_status","width=300,height=200");
		w.document.write('<html><head><title>Status</title><style type="text/css">body{font:bold 14px Verdana;color:red}</style></head><body>Uploading...Please wait.</body></html>');
		w.document.close();
		w.focus();
	}

	function hideStatus(){
		var w = window.open("","_status"); //get handle of existing popup
		if (w && !w.closed) w.close(); //close it
	}

</script>

<script language="javascript" type="text/javascript">
    function showHideDiv()
    {
        var divstyle = new String();
        divstyle = document.getElementById("loading").style.display;
        if(divstyle.toLowerCase()=="" || divstyle == "")
        {
            document.getElementById("loading").style.display = "none";
        }
        else
        {
            document.getElementById("loading").style.display = "";
		}
    }
</script>   
	
<script>
	function printpr()
	{
	var OLECMDID = 7;
	/* OLECMDID values:
	* 6 - print
	* 7 - print preview
	* 1 - open window
	* 4 - Save As
	*/
	var PROMPT = 1; // 2 DONTPROMPTUSER
	var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
	document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
	WebBrowser1.ExecWB(OLECMDID, PROMPT);
	WebBrowser1.outerHTML = "";
	}
</script>


<body onload="showHideDiv()">
<div class="panel panel-primary">
	<div class="panel-heading"><b>Style Analysis Report</b></div>
	<div class="panel-body">
		<div id="non-printable">
			<!-- <a href="#" onClick="print(); return false;">click here to print this page</a> -->
			<!--<div id="page_heading"><span style="float: left"><h3></h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
			<!-- <div id="page_heading"><h3>Hourly Style Breakup</h3><b></b>&nbsp;</div> -->
			<!--<h3 style="background-color: #29759c; color: WHITE;  font-size:15px; ">Hourly Style Breakup</h3>-->

			<form method="POST" action="?r=<?php echo $_GET['r'];?>" onsubmit="showHideDiv()">
			
				<?php
					if(isset($_POST['refresh']))
					{

					$date=$_POST['date'];
					$date1=$_POST['date1'];

					}

				?>
				<div class="row">
					<?php $calurl = getFullURL($_GET['r'],'cal.gif','R');?>
					<div class="col-md-3">
						Select Start Date: <input id="demo1" class="form-control" type="text" data-toggle='datepicker' size="10" name="date" value=<?php if($date<>"") {echo $date; } else {echo date("Y-m-d");} ?>>
					</div>
					<div class="col-md-3">
						Select End Date:   <input id="demo2" class="form-control" type="text" data-toggle='datepicker' size="10" name="date1" value=<?php if($date1<>"") {echo $date1; } else {echo date("Y-m-d");} ?>>
					</div>
				

					<?php
						$date=$_POST['date'];
						$date1=$_POST['date1'];

						$exist_count=0;
						$sql2="select bac_date from $bai_pro.bai_log_buf where bac_date between \"$date\" and \"$date1\"";
						//mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
						$sql_result2=mysqli_query($link, $sql2);
						$exist_count=mysqli_num_rows($sql_result2);

						$bai_log_table_name="$bai_pro.bai_log";
						if($exist_count>0)
						{
							$bai_log_table_name=" $bai_pro.bai_log_buf ";
						}
						else
						{
							$bai_log_table_name=" $bai_pro.bai_log ";
						}
						//echo "length :".strlen($date);
						echo "<div class='col-md-3'>";
							echo "Select Style: <select name=\"styles[]\" size=3 multiple class='form-control'>";
							// if(strlen($date)>0)
							// {
								//TEMP TABLE
								$new_tbl_name2=trim($bai_log_table_name).$username.date("His");
								$sql="CREATE TEMPORARY TABLE $new_tbl_name2  as (select * from $bai_log_table_name where bac_date between '$date' and '$date1')";
								
								mysqli_query($link, $sql);
								$bai_log_table_name2=$new_tbl_name2;
								
								$sql2="select distinct bac_style from ".$bai_log_table_name2." where bac_date between \"$date\" and \"$date1\" order by bac_style";
								//mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
								//echo "<option value=\"".$sql_row2['bac_style']."\" selected>".$sql2."-".$host."</option>";
								$sql_result2=mysqli_query($link, $sql2);
								while($sql_row2=mysqli_fetch_array($sql_result2))
								{
										echo "<option value=\"".$sql_row2['bac_style']."\" selected>".$sql_row2['bac_style']."</option>";
								}
								
								//DROP TEMP TABLE
								$sql="DROP TABLE $new_tbl_name2";
								mysqli_query($link, $sql);
							// }
							echo "</select>";
						echo "</div>";
 
						echo "<div class='col-md-3'>";
							echo "Select Team: <select name=\"team\" class='form-control'>";
							?>
						<option value=<?php echo implode(",",$shifts_array); ?>>All</option>
                                    <?php 
                                        for ($i=0; $i < sizeof($shifts_array); $i++) {?>
                                            <option  <?php echo 'value="'.$shifts_array[$i].'"'; if($team==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
                                        <?php }
									?>
									<?php
							echo "</select>";
						echo "</div>";
					?>

				</div>

				<div class="row">
					<div class="col-md-12">	
						<input type="submit" name="refresh" value="Refresh Styles" class="btn btn-info">
						<input type="submit" name="submit" value="Show" onclick='return verify_date()'  class="btn btn-success">
					</div>
				</div>

			</form>
								
			<?php $pwurl = getFullURLLEVEL($_GET['r'],'common/images/pleasewait.gif',1
			,'R'); ?>
			<div id="loading" align="center" style="position:relative; top:10px; left:20px;">
				<img src="<?= $pwurl ?>">
			</div>

			<div id="logo">
				<table>
					<?php $logourl = getFullURLLEVEL($_GET['r'],'common/images/Book1_29570_image003_v2.png',1,'R'); ?>
					<tr><td><img src="<?= $logourl ?>"></td>
					<td valign="bottom"><center><h3>Hourly Efficiency Report (<?php echo $date; ?>)</h3></center></td></tr>
				</table>
			</div>
	    </div>
		<div id="printable">
			<?php
				if(isset($_POST['submit']))
				{

				$styles=$_POST['styles'];
				$date=$_POST['date'];
				$date1=$_POST['date1'];
				// $date="2018-09-17";
				// $date1="2018-09-17";

				$team=$_POST['team'];
				$teams=explode(",",$team);
				$team = "'".str_replace(",","','",$team)."'"; 
				$row_count = 0;

				echo "<hr/><span class='label label-warning'><b>Report Period: </b>".$date." to $date1 And <b>Team: </b>".str_replace('"',"",$team).'</span>';
				echo "<br/><br/>";


				//TEMP TABLE
				$new_tbl_name=trim($bai_log_table_name).$username.date("His");
				$sql="CREATE TEMPORARY TABLE $new_tbl_name  as (select * from $bai_log_table_name where bac_date between '$date' and '$date1')";
				mysqli_query($link, $sql) or exit("Sql Error3 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				$bai_log_table_name=$new_tbl_name;

				/* Function BEGINING */
				function TimeCvt ($time, $format)   {

					if (ereg ("[0-9]{1,2}:[0-9]{2}:[0-9]{2}<wbr />", $time))   {
						$has_seconds = TRUE;
					}
					else   {
						$has_seconds = FALSE;
					}

					if ($format == 0)   {         //  24 to 12 hr convert
						$time = trim ($time);

						if ($has_seconds == TRUE)   {
						$RetStr = date("g", strtotime($time));
						}
						else   {
						$RetStr = date("g", strtotime($time));
						}
					}
					elseif ($format == 1)   {     // 12 to 24 hr convert
					$time = trim ($time);

						if ($has_seconds == TRUE)   {
						$RetStr = date("H:i:s", strtotime($time));
						}
					else   {
						$RetStr = date("H:i", strtotime($time));
						}
					}
					return $RetStr;
				}
				
				
				/* Function END */
				// $sections=array(1,2,3,4,5,6);
				$work_hrs=0;
				$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift in (\"$team\")";
				// echo $sql_hr."<br>";
				$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
				if(mysqli_num_rows($sql_result_hr) >0)
				{
					while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
					{ 
						$work_hrs=$work_hrs+($sql_row_hr['end_time']-$sql_row_hr['start_time']);

					}
					$break_time=sizeof($teams)*0.5;
					$work_hours=$work_hrs-$break_time;
				}else{
						if(sizeof($teams) > 1) 
						{ 
							$work_hours=15; 
						} 
						else 
						{ 
							$work_hours=7.5; 
						} 
				}
				
				// echo $work_hours."<br>";
				// date_default_timezone_set("Asia/Calcutta");
				$current_hr=date('H');
				// echo $current_hr."<br>";

				// $current_date="2018-09-17";
				$current_date=date('Y-m-d');

				if($current_date==$date && $current_date==$date1)
				{
					$hour_dur=0;
					for($i=0;$i<sizeof($teams);$i++)
					{
						$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$teams[$i]."' and  $current_hr between start_time and end_time";
						// echo $sql_hr."<br>";
						$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
						if(mysqli_num_rows($sql_result_hr) >0)
						{
							while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
							{ 
								$start_time=$sql_row_hr['start_time'];
								$end_time=$sql_row_hr['end_time'];
								$diff_time=$current_hr-$start_time;
								if($diff_time>3){
									$diff_time=$diff_time-0.5;
								}

								$hour_dur=$hour_dur+$diff_time;
							}
						}
						else
						{
							$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$teams[$i]."' and $current_hr > end_time";
							// echo $sql_hr."<br>";
							$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
							// $hour_dur=$hour_dur+0;
							while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
							{ 
								$start_time=$sql_row_hr['start_time'];
								$end_time=$sql_row_hr['end_time'];
								if($end_time > $start_time){
									$diff_time=$end_time-$start_time;
								}
								else
								{
									$start=24-$start_time;
									$diff_time=$start+$end_time;
								}
								if($diff_time>3){
										$diff_time=$diff_time-0.5;
								}
								$hour_dur=$hour_dur+$diff_time;
							}
						}
						
					}
			
					$hoursa_shift=$hour_dur;
				}
				else
				{
					$hoursa_shift=$work_hours;
				}
				// echo $hoursa_shift."<br>";

				$i=0;
				$h=array();
				$sql="select distinct(Hour(bac_lastup)) as \"time\" from ".$bai_log_table_name." where bac_date between \"$date\" and \"$date1\" and bac_shift in (\"$team\") order by hour(bac_lastup)*1";
				// echo $sql."<br>";
				//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				$hoursa=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					// $timestr=$sql_row['time'].":0:0";
					// $h[$i]=TimeCvt($timestr,0);
					// $headers[$i]=date("H",strtotime($timestr));
					// $i=$i+1;
					$h[]=$sql_row['time'];
					$headers[]=$sql_row['time'];
				}

				echo "<div class='table-responsive'>";
				echo "<table id=\"info\" class='table table-bordered'>";
				echo "<tr style='background-color:#286090;color:white;'><th style='text-align:center;'>Style</th>";
				echo "<th style='text-align:center;'>Section</th>";
				echo "<th style='text-align:center;'>Module No</th>";

				for($i=0;$i<sizeof($h);$i++)
				{
					echo "<th style='text-align:center;'>".$h[$i]."-".($h[$i]+1)."</th>"; 
				}

				echo "<th style='text-align:center;'>Total</th>";
				echo "<th style='text-align:center;'>Avg/Mod</th>";
				echo "<th style='text-align:center;'>Avg/Sec</th>";
				echo "<th style='text-align:center;'>Avg/Style</th>";
				echo "<th style='text-align:center;'>Grand Total</th>";
				echo "</tr>";


				// Style Break Start
				$row_bg_col=1;

				for ($i=0;$i<sizeof($styles);$i++)
				{
					$style=$styles[$i];
					$module_count=0;
					$sql2="select distinct(bac_no) as \"module\" from ".$bai_log_table_name." where bac_date between \"$date\" and \"$date1\" and bac_style=\"$style\" and bac_shift in (\"$team\") order by bac_no";
					//mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
					$module_count=mysqli_num_rows($sql_result2); 
					//echo $module_count."<br/>";

					$style_check=0;


					if($row_bg_col==1)
					{
						//$bg_color1="#6699FF";
						//$bg_color2="#66CCFF";
						$bg_color1="#FFCC66";
						$bg_color2="#FFFF99";
						$row_bg_col=0;	
					}
					else
					{
						//$bg_color1="#FF99FF";
						//$bg_color2="#FFCCFF";
						$bg_color1="#99CC33";
						$bg_color2="#CCFF99";
						$row_bg_col=1;	
					}
					
					$sql="select distinct(bac_sec) as \"section\" from ".$bai_log_table_name." where bac_date between \"$date\" and \"$date1\" and bac_style=\"$style\" and bac_shift in (\"$team\") order by bac_sec";
					//mysql_query($sql,$link) or exit("Sql Error".mysql_error());
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$section=$sql_row['section'];
						$row_count++;

						$sql2="select distinct distinct(bac_no) as \"module\" from ".$bai_log_table_name." where bac_date between \"$date\" and \"$date1\" and bac_style=\"$style\" and bac_sec=\"$section\" and bac_shift in (\"$team\") order by bac_no";
						//mysql_query($sql2,$link) or exit("Sql Error".mysql_error());
						$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
						$section_count=mysqli_num_rows($sql_result2); 
						//echo $module_count;

						$section_check=0;
						while($sql_row2=mysqli_fetch_array($sql_result2))
						{
							$module=$sql_row2['module'];
							
							echo "<tr bgcolor=\"$bg_color1\">";
									
							if($style_check==0)
							{
								echo "<td rowspan=$module_count >$style</td>";
								$style_check=1;
							}				
							
							if($section_check==0)
							{

								$sql12="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=$section";
								$result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row12=mysqli_fetch_array($result12))
								{
									$section_display_name=$sql_row12["section_display_name"];
								}

								echo "<td rowspan=$section_count>$section_display_name</td>";
								$section_check=1;
							}
							
							echo "<td>$module</td>";
							
							$module_sum=0;
							for ($j=0;$j<sizeof($headers);$j++)
							{
								$qty=0;
								$sql3="select sum(bac_qty) as \"qty\" from ".$bai_log_table_name." where bac_date between \"$date\" and \"$date1\" and bac_style=\"$style\" and bac_sec=\"$section\" and bac_no=$module and bac_shift in (\"$team\") and Hour(bac_lastup)=".$headers[$j];
								//mysql_query($sql3,$link) or exit("Sql Error".mysql_error());
								$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row3=mysqli_fetch_array($sql_result3))
								{
									$qty=$sql_row3['qty'];
									echo "<td bgcolor=\"$bg_color2\">$qty</td>";
									$module_sum=$module_sum+$qty;			
								}
							}
							echo "<td>".$module_sum."</td>";
							echo "<td>".round(($module_sum/$hoursa_shift),0)."</td>";
							
							//NEW
								$sec_qty=0;
								$sql3="select sum(bac_qty) as \"sec_qty\" from ".$bai_log_table_name." where bac_date between \"$date\" and \"$date1\" and bac_style=\"$style\" and bac_sec=\"$section\" and bac_shift in (\"$team\")";
								//mysql_query($sql3,$link) or exit("Sql Error".mysql_error());
								$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row3=mysqli_fetch_array($sql_result3))
								{
									$sec_qty=$sql_row3['sec_qty'];
								}
								
								if($section_check==1)
								{
									echo "<td rowspan=$section_count>".round((($sec_qty/$section_count)/$hoursa_shift),0)."</td>";
									$section_check=2;
								}
								
							//NEW	
							
							//NEW
								$style_qty=0;
								$sql3="select sum(bac_qty) as \"style_qty\" from ".$bai_log_table_name." where bac_date between \"$date\" and \"$date1\" and bac_style=\"$style\" and bac_shift in (\"$team\")";
								//mysql_query($sql3,$link) or exit("Sql Error".mysql_error());
								$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row3=mysqli_fetch_array($sql_result3))
								{
									$style_qty=$sql_row3['style_qty'];
								}
								
								if($style_check==1)
								{
									echo "<td rowspan=$module_count>".round((($style_qty/$module_count)/$hoursa_shift),0)."</td>";
									echo "<td rowspan=$module_count>".$style_qty."</td>";
									$style_check=2;
								}
								
							//NEW
							
							echo "</tr>";
						}
					}
				}
				echo "</table></div>";

				if($row_count == 0){
					echo "<div class='alert alert-danger'><p></p>No Data Found</div>";
				}
				// Style Break End

				// END
				//DROP TEMP TABLE
				$sql="DROP TABLE $new_tbl_name";
				mysqli_query($link, $sql) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));

				}

			?>
		</div>
	</div>
</div>
</body>
</div>


<?php
 ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); 
 ?>

<style>
	 .label-warning {
		 font-size:14px;
	 }
</style>