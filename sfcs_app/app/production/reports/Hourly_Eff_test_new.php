<title>Hourly Efficiency Report</title>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=edge,chrome=1" /> 
<link rel="stylesheet" href="style.css" type="text/css" media="all" /> 
<link rel="stylesheet" href="../../../common/css/styles/bootstrap.min.css">
<!-- <script language="javascript" type="text/javascript" src="../../../common/js/TableFilter_EN/tablefilter.js"></script>
<script language="javascript" type="text/javascript" src="../../../common/js/TableFilter_EN/actb.js"></script> -->

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/style.css',3,'R'); ?>" type="text/css" media="all" /> 
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />

<style>
body
{
	background-color: WHITE;
	font-size: 8pt;
	color: BLACK;
	line-height: 15pt;
	font-style: normal;
	font-family: "calibri", Verdana, Arial, Helvetica, sans-serif;
	text-decoration: none;
}
#inf_table_format_first{
	width: 100%;
}
.maincontentof{
	overflow: auto; 
}
table#filter td
{
	
	padding:10px;
}

table#info
{
	border-collapse:collapse;

}

table#info tr
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table#info2 td
{
	border: 1px solid black;
	text-align: right;
	vertical-align:top;
    white-space:nowrap; 
}

table#info td
{
	border: 1px solid black;
	text-align: right;
    white-space:nowrap; 
}

table#info th
{
	border: 1px solid black;
	text-align: center;
    background-color: BLUE;
	color: WHITE;
    white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}


table#info tr.total
{
	border: 1px solid black;
    background-color: GREEN;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#info td.head
{
	border: 1px solid black;
    background-color: GREEN;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#info tr.total_grand
{
	border: 1px solid black;
    background-color: ORANGE;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}


table#Table2 td
{
	border: 1px solid black;
	text-align: right;
    white-space:nowrap; 
}

table#Table2 th
{
	border: 1px solid black;
	text-align: center;
    background-color: BLUE;
	color: WHITE;
    white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}


table#Table2 tr.total
{
	border: 1px solid black;
    background-color: GREEN;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#Table2 td.head
{
	border: 1px solid black;
    background-color: GREEN;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#Table2 tr.total_grand
{
	border: 1px solid black;
    background-color: ORANGE;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#TABLE3 td
{
	border: 1px solid black;
	text-align: right;
    white-space:nowrap; 
}

table#TABLE3 th
{
	border: 1px solid black;
	text-align: center;
    background-color: BLUE;
	color: WHITE;
    white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}


table#TABLE3 tr.total
{
	border: 1px solid black;
    background-color: GREEN;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#TABLE3 td.head
{
	border: 1px solid black;
    background-color: GREEN;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#TABLE3 tr.total_grand
{
	border: 1px solid black;
    background-color: ORANGE;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table
{
    width:100%;
} 
td,th 
{
    border-collapse: separate;
    border: 1px solid black;
}
@media print 
{ 
    @page narrow {size: 11in 9in} 
    @page rotated {size: landscape} 
    DIV {page: narrow} 
    TABLE {page: rotated} 
    #non-printable { display: none; } 
    #printable {  
    display: block;  
    padding-left:20px; 
    } 
    #logo { display: block; } 
    body { 
    zoom:75%;  
    } 
} 

@media screen{ 
#logo { display: none; } 
} 

#circle { width: 100px; height: 100px; background: red; -moz-border-radius: 50px; -webkit-border-radius: 50px; border-radius: 50px; } 
</style> 

<script> 
    function displayStatus()
    { 
        var w = window.open("","_status","width=300,height=200"); 
        w.document.write('<html><head><title>Status</title><style type="text/css">body{font:bold 14px Verdana;color:red}</style></head><body>Uploading...Please wait.</body></html>'); 
        w.document.close(); 
        w.focus(); 
    } 

    function hideStatus()
    { 
        var w = window.open("","_status"); //get handle of existing popup 
        if (w && !w.closed) w.close(); //close it 
    } 

    function showHideDiv() 
    { 
        var divstyle = new String(); 
        divstyle = document.getElementById("loading").style.display; 
            
        if(divstyle.toLowerCase()=="" || divstyle == "") 
        { 
            document.getElementById("loading").style.display = "none"; 
            document.getElementById("filter").style.display = ""; 
            document.getElementById("printable").style.display = ""; 
        } 
        else 
        { 
            document.getElementById("loading").style.display = ""; 
            document.getElementById("filter").style.display = "none"; 
            document.getElementById("printable").style.display = "none"; 
            
        } 
    } 

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

    function popitup(url) 
    { 
        newwindow=window.open(url,'name','height=1000,width=650,scrollbars=yes,resizable=yes'); 
        if (window.focus) {newwindow.focus()} 
        return false; 
    } 
</script> 
          

    <body onload="showHideDiv()"> 
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Hourly Efficiency Report</strong></div>
            <div class="panel-body">
                <div id="non-printable"> 
				
                    <!-- <a href="#" onClick="print(); return false;">click here to print this page</a> --> 
					
                    <!--<div id="page_heading">
                        <span style="float: left"><b>Hourly Efficiency Report</b></span><span style="float: right"><b><a href="Help.htm" onclick="return popitup('Help.htm')">?</a></b>&nbsp;</span>
                    </div>--> 
                    <!--<div id="page_heading"><h3 style="background-color: #29759c; color: WHITE;  font-size:15px; ">Hourly Efficiency Report</h3><span style="float: right"><b>?</b>&nbsp;</span></div>--> 
                    <!--<h3 style="background-color: #29759c; color: WHITE;  font-size:15px; ">Hourly Efficiency Report</h3>--> 
                    <?php  
						//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
                        error_reporting(0);						
						include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
						include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
                        $style_break=$_POST['secstyles']; 
                        $sections_string=$_POST['section']; 
                        $hour_filter=$_POST['hour_filter']; 
                        $date=$_POST['dat']; 
                        $hourly_break=$_POST['option1']; 
                        $team=$_POST['team']; 
                        $total_hours = $plant_end_time - $plant_start_time;
                        // echo $total_hours."<br>";
                        list($hour, $minutes, $seconds) = explode(':', $plant_start_time);
						$hour_start = $hour + 1;
						$plantcode=$_SESSION['plantCode'];
						$username=$_SESSION['userName'];
         ?> 

<!--form starting for taking the inputs -->
<form method="POST" class="form-inline" action="<?php $_SERVER['PHP_SELF']; ?>" onsubmit="showHideDiv()"> 
                        <div class="row">
                            <div class="col-md-2">
									<label for="demo1">Select Date: </label>
                                	<input type="date" data-toggle="datepicker" name="dat" id="demo1" value="<?php if($date!=""){echo $date;}else {echo date("Y-m-d");} ; ?>"  required class="form-control"/></td> 
                            </div>
                            <div class="col-md-2">
                                <label for="section">Select Section: </label>
                                <?php
									$departmentType = DepartmentTypeEnum::SEWING;
                                    echo "<select name=\"section\" id='section' class=\"form-control\" >"; 
									$sql2="select sec.section_id,sec.section_name from $pms.sections as sec left join $pms.departments as dep on sec.department_id = dep.department_id where dep.department_type='".$departmentType."' and sec.plant_code= '".$plantcode."'"; 
									
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Section Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        if($sections_string==$sql_row2['section_id']) 
                                        { 
                                            echo "<option value=\"".$sql_row2['section_id']."\" selected>".$sql_row2['section_name']."</option>"; 
											$sections_list[]=$sql_row2['section_id'];
                                        } 
                                        else 
                                        { 
                                            echo "<option value=\"".$sql_row2['section_id']."\">".$sql_row2['section_name']."</option>"; 
											$sections_list[]=$sql_row2['section_id'];
                                        } 
                                    } 
									if($sections_string==implode(",",$sections_list)) 
									{
										echo "<option value=\"".implode(",",$sections_list)."\" selected>Factory</option>"; 
									}
									else
									{
										echo "<option value=\"".implode(",",$sections_list)."\">Factory</option>"; 
									}
                                    echo "</select>"; 
                                ?>
                            </div>
                            <div class="col-md-2">
                                <label for="team">Select Team: </label>
								<?php
									$shifts	= [];								
									$sql2="select shift_code,shift_description from $pms.shifts where plant_code= '".$plantcode."'";
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql shift Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
										$shift_list['shiftCode']=$sql_row2['shift_code'];
										array_push($shifts, $shift_list);  
										$shift_codes[] = $sql_row2['shift_code'];                                     
									} 
                                ?>
                                <select name="team" id="team" class="form-control"> 
								<option value=<?php echo implode(",",$shift_codes); ?>>All</option>
									<?php 
										foreach($shifts as $shift){
											if($team==$shift['shiftCode']) {
												echo "<option value='".$shift['shiftCode']."' selected>".$shift['shiftCode']."</option>";
											} else {
												echo "<option value='". $shift['shiftCode']."'>".$shift['shiftCode']."</option>";
											}
										}
                                    ?>
                                </select>
                            </div> 
                            <div class="col-md-2">
                               <label for="hour_filter" valign="top">Select Hour: </label>
                               <?php                                    
									$sql22="SELECT TIMESTAMPDIFF(HOUR,plant_start_time,plant_end_time) AS hours,plant_start_time,plant_end_time  FROM $pms.plant WHERE plant_code='$plantcode' AND is_active=1"; 							
									$sql_result22=mysqli_query($link, $sql22) or exit("Sql Time Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
									if(mysqli_num_rows($sql_result22)>0){
										while($timingRows=mysqli_fetch_array($sql_result22))
										{
											$workingHours=$timingRows['hours'];
											$plant_start_time=$timingRows['plant_start_time'];
											$plant_end_time=$timingRows['plant_end_time'];
										}
									}									
                                    $startHour= explode(':', $plant_start_time);
									$endHour= explode(':', $plant_end_time);
									echo "<select name=\"hour_filter\" id='hour_filter' class=\"form-control\" >";
									if($hour_filter == 'All') {
										echo "<option value=\"All\" selected>All</option>";
									} else {
										echo "<option value=\"All\">All</option>";
									}
									for($i=$startHour[0];$i<=$endHour[0];$i++)
									{	
										$startingHour=str_pad($i, 2, '0', STR_PAD_LEFT);
										if($hour_filter==$i)
										{
								
											echo "<option value=\"".$startingHour."\" selected>".$startingHour."</option>";
										}
										else
										{
											echo "<option value=\"".$startingHour."\" >".$startingHour."</option>";
										}		
									}
                                    echo "</select>"; 
                                ?>  
                                </select>
                            </div> 
                            <div class="col-md-2">
                                <label for="secstyles">Style Break: &nbsp;&nbsp;</label> 
                                <input type="checkbox" class="checkbox" id='secstyles' name="secstyles" value="1" <?php if($style_break==1) echo "checked"; ?>>
                            </div> 
                            <div class="col-md-2">
                                <label for="option1">Hourly Break: </label> 
                                <input type="checkbox" class="checkbox" name="option1" id="option1" value="1" <?php if($hourly_break==1) echo "checked"; ?>>
                                    <!-- To display/stop/hourly break --> 
                            </div>
                        </div>
                        <div class="row pull-right">
                            <div class="col-md-2">
                                <input type="submit" name="submit" class="btn btn-primary" value="Filter" id="filter"/>  
                                <?php 	
                                    $team_ref=str_replace('"',"*",$team);                                    
                                ?> 
                            </div>
                    </form> 
				<!--form ending for taking the inputs -->
				<!--Giff Loader image  code starting -->                   
            <div id="loading" align="center" style="position:relative; top:10px; left:20px;"> 
                        <img src="<?= getFullURLLevel($_GET['r'],'common/images/pleasewait.gif',1,'R') ?>"> 
                        <script> 
                            var count=30; 
                            var counter=setInterval(timer, 1000); //1000 will  run it every 1 second 
                            function timer() 
                            { 
                                count=count-1; 
                                if (count <= 0) 
                                { 
                                    clearInterval(counter); 
                                    return; 
                                } 
                                document.getElementById("timer").innerHTML="We will be back in <font color=red>"+count + "</font> secs"; // watch for spelling 
                            } 
                            count=20; 
                        </script> 
                        <br/><br/> 
                        <span id="timer" style="font-size:15px;"></span> 
                    </div>  </div> 
 <!--Giff Loader image  code ending -->  
 <?php
 //after submitting the data
 if(isset($_POST['submit']))
 {
    $date=$_POST['dat'];//date of the input 
    $sections_group=$sections_string=$_POST['section'];//sections
    $team=$_POST['team'];//team
	$hour_filter=$_POST['hour_filter'];//slected hour  
    $style_break=($_POST['secstyles']==1) ? $_POST['secstyles'] : 0 ; //style break
    $hourly_break=($_POST['option1']==1) ? $_POST['option1'] : 0;//hourly Break 
    $current_hr=date('H');
	$current_date=date('Y-m-d');
	
	if(sizeof(explode(",",$team))==1)
	{
		$teams=explode(",",$team);
		$team = "'".str_replace(",","','",$team)."'"; 
		$sql_hr="select * from $pms.pro_atten_hours where plant_code='$plantcode' and date='$date' and shift =".$team."";
		$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql pro_atten_hours-1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_hr)>0)
		{
			while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
			{
				$start_check=$sql_row_hr['start_time'];
				$end_check=$sql_row_hr['end_time'];
				$start_time_exact=$sql_row_hr['start_time'];
				$end_time_exact=$sql_row_hr['end_time'];
				if($current_date == $date)
				{
					if($start_check>$current_hr)
					{
						echo "<h2>Selected Shift still not started.</h2><br>";		
						die;
					}						
				}
			}
		}
		else
		{
			echo "<h2>Plant Timings Not Available,Please Update Plant Timings.</h2><br>";	
			die;
		}
	}
	else
	{
		$teams=explode(",",$team);
		$team = "'".str_replace(",","','",$team)."'"; 
		$sql_hr="select MIN(start_time*1)AS vals,MAX(end_time*1) AS vals2 from $pms.pro_atten_hours where plant_code='$plantcode' and date='$date' and shift in ($team)";
		$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql pro_atten_hours-2 Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_hr)>0)
		{
			while($sql_row_hr12=mysqli_fetch_array($sql_result_hr)) 
			{
				$start_check=$sql_row_hr12['vals'];
				$end_check=$sql_row_hr12['vals2'];	
				$start_time_exact=$sql_row_hr12['vals'];
				$end_time_exact=$sql_row_hr12['val2'];
			}
		}
		else
		{
				echo "<h2>Plant Timings Not Available,Please Update Plant Timings.</h2><br>";	
				die;
		}
	}
	$sections=explode(",", $_POST['section']);
    
	$hoursa_shift=0;
	//teams based looping start    
	for($k=0;$k<sizeof($teams);$k++)
	{
		$shift=$teams[$k];
		$sql_nop="select (present+jumper) as avail,absent from $pms.pro_attendance where plant_code='$plantcode' and date=\"$date\" and module=\"$mod\" and shift=\"$shift\""; 
		// echo $sql_nop."<br>";
		$sql_result_nop=mysqli_query($link, $sql_nop) or exit("Sql pro_attendance-1 Error".$sql_nop."<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_nop) > 0) 
		{ 
			while($sql_row_nop=mysqli_fetch_array($sql_result_nop)) 
			{ 
			   $nop=$sql_row_nop["avail"];
			   $nop_shift=$nop_shift+$nop; 
			} 
		}
		else
		{ 
			  $nop=0; 
			  $nop_shift=$nop_shift+$nop; 
		}
		//if current date == given date start 
		if($current_date == $date)
		{
			$sql_hr="select start_time,end_time from $pms.pro_atten_hours where plant_code='$plantcode' and date='$date' and shift ='".$shift."'";
			$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql pro_atten_hours-3 Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
			{ 
				$start_time=$sql_row_hr['start_time'];
				$end_time=$sql_row_hr['end_time'];
				$start_time_exact1=$sql_row_hr['start_time'];				
				
				if($current_hr<$end_time)
				{
					$end_time_exact1= date("H:i:s");
				}
				else
				{
					$end_time_exact1= $sql_row_hr['end_time'];
				}	
				$time1 = strtotime($start_time_exact1);
				$time2 = strtotime($end_time_exact1);
				$difference = round(abs($time2 - $time1) / 3600,2);
				if($difference>3)
				{
					$difference=$difference-($breakhours/60);
				}
				$hoursa_shift=$hoursa_shift+$difference;
			}
				                     
		}
		else
		{
			$sql_hr="select * from $pms.pro_atten_hours where plant_code='$plantcode' and date='$date' and shift ='".$shift."'";
			$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql pro_atten_hours-4 Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			if(mysqli_num_rows($sql_result_hr) >0)
			{
				while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
				{ 
					$start_time=$sql_row_hr['start_time'];
					$end_time=$sql_row_hr['end_time'];
					$start_time_exact1=$sql_row_hr['start_time'];
					$end_time_exact1=$sql_row_hr['end_time'];
					$time1 = strtotime($start_time_exact1);
					$time2 = strtotime($end_time_exact1);
					$difference = round(abs($time2 - $time1) / 3600,2);
					if($difference>3)
					{
						$difference=$difference-($breakhours/60);
					}
					$hoursa_shift=$hoursa_shift+($difference);
				}
			}          
		}
		//if current date != given date end 
		$aaa=$nop*$diff_time;
		$clha_shift=$clha_shift+$aaa;
	}
	
	
	$time_query_new=""; 	
	if($hour_filter=='All') 
    {	
		$time_query_new=" created_at BETWEEN ('$date ".$start_time_exact."') and ('$date ".$end_time_exact."')"; 		
    } 
    else 
    {	
		$hour_filter_array=explode("$", $_POST['hour_filter']);
		$time_query_new="created_at BETWEEN ('$date ".$hour_filter_array[0]."') and ('$date ".$hour_filter_array[1]."')"; 
    }	
 
	$hr=array();
	$hr_disp=array();
	$hr_start=array();
	$hr_end=array();
	
    echo "<div class=\"maincontentof\"><table class='table table-bordered' id=\"table_format_first\">";
    echo "<tr><th style='background-color:#29759C;color:white;'>Section#</th><th style='background-color:#29759C;color:white;'>Module#</th><th style='background-color:#29759C;color:white;'>NOP</th><th style='background-color:#29759C;color:white;'>Style DB</th><th style='background-color:#29759C;color:white;'>Schedule</th>";
	
    if($hourly_break==1)
	{
		if($hour_filter=='All') 
		{ 
			$sql="SELECT TIMESTAMPDIFF(HOUR,plant_start_time,plant_end_time) AS hours,plant_start_time,plant_end_time FROM $pms.plant WHERE plant_code='$plantcode' and plant_start_time>='$start_time_exact' AND plant_end_time <= '$end_time_exact' ORDER BY plant_start_time";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Plant-5 Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row=mysqli_fetch_array($sql_result)) 
			{ 
				$hours = $sql_row['total'];
				$hr_start = $sql_row['plant_start_time'];
				$hr_end = $sql_row['plant_end_time'];																			
			}		
			$startHour= explode(':', $hr_start);
			$endHour= explode(':', $hr_end);						
			for($i=$startHour[0];$i<=$endHour[0];$i++)
			{					
				$startingHour=str_pad($i, 2, '0', STR_PAD_LEFT);	
				$endingHour = str_pad($startingHour+1, 2, '0', STR_PAD_LEFT);	
				$hr[] = $startingHour;
				$hr_disp[] = $startingHour."-".$endingHour;
			}									  
		} 
		else 
		{      
			$hoursa_shift=1;
			$hour_filter_array=explode("$", $_POST['hour_filter']);
			$startHour= explode(':', $hour_filter_array[0]);
			$endHour= explode(':', $hour_filter_array[1]);						
			for($i=$startHour[0];$i<$endHour[0];$i++)
			{					
				$startingHour=str_pad($i, 2, '0', STR_PAD_LEFT);				
				$endingHour = str_pad($startingHour+1, 2, '0', STR_PAD_LEFT);	
				$hr[] = $startingHour;
				$hr_disp[] = $startingHour."-".$endingHour;
			}	
		}
		for($i=0;$i<sizeof($hr);$i++) 
		{ 
			echo "<th style='background-color:#29759C;color:white;'>".$hr_disp[$i]."</th>";
		}
    }	
     echo "<th style='background-color:#29759C;color:white;'>Total</th><th style='background-color:#29759C;color:white;'>Hours</th> 
          <th style='background-color:#29759C;color:white;'>Plan EFF%</th> 
          <th style='background-color:#29759C;color:white;'>Plan Pro.</th> 
          <th style='background-color:#29759C;color:white;'>CLH</th> 
          <th style='background-color:#29759C;color:white;'>Plan SAH</th> 
          <th style='background-color:#29759C;color:white;'>Act SAH</th> 
          <th style='background-color:#29759C;color:white;'>Act. EFF%</th> 
          <th style='background-color:#29759C;color:white;'>Balance Pcs.</th> 
          <th style='background-color:#29759C;color:white;'>Act. Pcs/Hr</th> 
          <th style='background-color:#29759C;color:white;'>Req. Pcs/Hr</th> 
		</tr>";
	$sum_total=array();
	$hour_tot=array();
	$pstha_sum_total=$pclha_sum_total=$hoursa_shift_sum_total=$ppro_a_total_sum_total=$clha_total_sum_total=
	$plan_sah_hr_total_sum_total=$plan_pro_sum=0;
for ($j=0;$j<sizeof($sections);$j++) 
{ 
    $sec=$sections[$j];
    $sec_head=""; 
	$sql="select us.first_name,sec.section_name from $pms.sections as sec left join $pms.user as us on sec.user_id=us.user_id where section_id='$sec' and plant_code='$plantcode'";                  
	$sql_result=mysqli_query($link, $sql) or exit("Sql Section-1 Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($sql_row=mysqli_fetch_array($sql_result)) 
	{ 
		$sec_head=$sql_row['first_name'];
		$section_name=$sql_row['section_name']; 
	} 
	$sql="select 0 as mod_style,workstation_id as mod_no,workstation_code as modcode FROM $pms.workstation WHERE section_id='$sec' and plant_code='$plantcode' and is_active=1 order by workstation_id*1";      
	$sql_result=mysqli_query($link, $sql) or exit("Sql workstation-1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));       
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));  
	   $peff_a_total=0; 
	   $peff_g_total=0; 
	   $ppro_a_total=0; 
	   $ppro_g_total=0; 
	   $clha_total=0; 
	   $clhg_total=0; 
	   $stha_total=0; 
	   $sthg_total=0; 
	   $effa_total=0; 
	   $effg_total=0; 
	   $avgpcstotal=0; 
	   $hourlytargettotal=0; 
	   $target_hour_total=0; 
	   $psth_array=array(); 
	   $tot_modules=array(); 
   // Module Level total calculations
    while($sql_row=mysqli_fetch_array($sql_result)) 
	{ 
		$tot_modules[]=$sql_row['mod_no'];
		$mod=$sql_row['mod_no']; 
		$modcode = $sql_row['modcode'];
		$sah=array(); 
		$output=array(); 
		$schedules=array(); 
		$style_name=array(); 
		$smv=array();
		$plan_eff=array();
		$plan_clh=array();
		$plan_sah=array();
		$plan_pro=array();
		$nop=array();	
		// Getting Plan Information
		$sql_month_plan="select sum(planned_qty) as qty,sum(planned_sah) as sah,planned_eff,capacity_factor from $pps.monthly_production_plan where plant_code='$plantcode' and row_name='".$modcode."'";
		$sql_month_plan_res=mysqli_query($link, $sql_month_plan) or exit("Fetching Monthly Plan information".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($monthlyRow=mysqli_fetch_array($sql_month_plan_res))
		{
			// echo $monthlyRow['sah']."-Plan--".$monthlyRow['qty']."<br>";
			//Plan SAH
			if($monthlyRow['sah']>0)
			{
				$plan_sah[$mod]=$monthlyRow['sah']/sizeof($teams);
			}
			else
			{
				$plan_sah[$mod]=0;
			}
			//Plan Out
			if($monthlyRow['qty']>0)
			{
				$plan_pro[$mod]=$monthlyRow['qty']/sizeof($teams);
			}
			else
			{
				$plan_pro[$mod]=0;
			}
			//Plan SMO
			if($monthlyRow['capacity_factor']>0)
			{
				$nop[$mod]=$monthlyRow['capacity_factor']/sizeof($teams);
				$plan_clh[$mod]=$monthlyRow['capacity_factor']*$work_hrs_plan[$teams[$i]];
			}
			else
			{
				$nop[$mod]=0;
				$plan_clh[$mod]=0;
			}
			//Plan Eff
			if($monthlyRow['planned_eff']>0)
			{
				$plan_eff[$mod]=$monthlyRow['planned_eff'];
			}
			else
			{
				$plan_sah[$mod]=0;
			}
		}
		
		$sql_trans="SELECT operation,style,color,SUM(good_quantity) AS qty, schedule FROM $pts.transaction_log WHERE $time_query_new AND parent_barcode_type='PPLB' and resource_id='".$mod."' and shift in ($team) and plant_code='".$plantcode."' group by style,color,operation";
		// echo $sql_trans."<br>";
		$trans_result=mysqli_query($link, $sql_trans) or exit("SQL Error - transaction_log -1".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($trans_result)>0)
		{
			while($trans_row=mysqli_fetch_array($trans_result))
			{	
				$style=$trans_row['style'];
				$color=$trans_row['color'];
				$operaiton_code=$trans_row['operation'];
				$schedule=$trans_row['schedule'];
				//echo $style."--".$color."--".$operaiton_code."<br>";
				//Fetching SMV
				$sql_to_fet_smv="SELECT smv FROM $oms.oms_products_info AS opi LEFT JOIN $oms.oms_mo_operations AS omo ON opi.mo_number=omo.mo_number LEFT JOIN $oms.oms_mo_details AS omd ON omd.mo_number=omo.mo_number WHERE opi.style='".$style."' AND opi.color_desc='".$color."' AND omo.operation_code=".$operaiton_code." and omd.plant_code='".$plantcode."' LIMIT 1";
				// echo $sql_to_fet_smv."<br>";
				$sql_to_fet_smv_res=mysqli_query($link, $sql_to_fet_smv) or exit("Error while getting SMV Information".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($smv_res=mysqli_fetch_array($sql_to_fet_smv_res))
				{
					$smv=$smv_res['smv'];
				}
				
				if($smv>0)
				{
					$style_temp_arr[] = $style;
					$schedule_temp_arr[] = $schedule;
					$smv_temp_arr[] = $smv;
					$output[$mod]=$output[$mod]+$trans_row['qty'];
					$sah[$mod]=$sah[$mod]+$trans_row['qty']*$smv/60;
				}								
			}
			$schedules[$mod]=array_values(array_unique($style_temp_arr));
			$style_name[$mod]=array_values(array_unique($schedule_temp_arr));
			$smv[$mod]=array_values(array_unique($smv_temp_arr));
		} else {
			$output[$mod] = 0;
			$sah[$mod] = 0;
			$schedules[$mod]=0;
			$style_name[$mod]=0;
			$smv[$mod]=0;
		}
		
		echo "<tr><td>".$section_name."</td><td>".$modcode."</td>";
		$sql2="select sum(present+jumper) as nop from $pms.pro_attendance where plant_code = '$plantcode' and date='".$date."' and module='$mod' and  shift in ($team)"; 
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		if(mysqli_num_rows($result6)>0)
		{
			while($sql_row2=mysqli_fetch_array($sql_result2)) 
			{ 
				$nop=$sql_row2['nop']; 
			}
		}		
		else
		{
			$nop=0;
		}	
		$clha_shift=0; 
		$hoursa=0; 
		$nop_shift=0;
		//$hoursa_shift=0;
		$diff_time=0;
		$current_date=date("Y-m-d");
		$current_hr=date('H'); 
		
		
		//teams based looping end 
		
        echo "<td>".$nop_shift."</td>";  
        echo "<td>".implode("<br>",explode(",",$style_name[$mod]))."</td>";  
        echo "<td>".implode("<br>",explode(",",$schedules[$mod]))."</td>"; 
        $gtotal=0; 
        $atotal=0; 
        $psth=0; 
     
		//headers based loop for times date
		if($hourly_break==1)
		{ 
			for($i=0; $i<sizeof($hr); $i++) 
			{ 
				$sql31="SELECT sum(good_quantity) as sum, style,color,operation FROM $pts.`transaction_log` 
				WHERE plant_code='".$plantcode."' and created_at BETWEEN ('$date ".$hr_start[$i]."') and ('$date ".$hr_end[$i]."') and shift in ($team) and resource_id='".$mod."' group by style,color,operation";
				//echo $sql31."<br>";
				$result31=mysqli_query($link, $sql31) or die("SQL Error - transaction_log -2".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($result31)>0)
				{	
					while($rows=mysqli_fetch_array($result31))
					{	
						$style=$rows['style'];
						$color=$rows['color'];
						$operation=$rows['operation'];
						$sql_to_fet_smv="SELECT smv FROM $oms.oms_products_info AS opi LEFT JOIN $oms.oms_mo_operations AS omo ON opi.mo_number=omo.mo_number LEFT JOIN $oms.oms_mo_details AS omd ON omd.mo_number=omo.mo_number WHERE opi.style='".$style."' AND opi.color_desc='".$color."' AND omo.operation_code=".$operation." and omd.plant_code='".$plantcode."' LIMIT 1";
						// echo $sql_to_fet_smv."<br>";
						$sql_to_fet_smv_res=mysqli_query($link, $sql_to_fet_smv) or exit("Error while getting SMV Information".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($smv_res=mysqli_fetch_array($sql_to_fet_smv_res))
						{
							$smv=$smv_res['smv'];
						}						
						if($smv>0)
						{
							$sum= $sum + $rows['sum'];
							$sah_val = $sah_val + ($rows['sum']*$smv)/60;
						}	
					}
					$eff = round(($sah_val/($nop_shift*$hoursa_shift)*100),2);	
					if($sum==0)
					{							
						echo "<td bgcolor=\"red\">0</td>";
						$hour_tot[$hr[$i]]=$hour_tot[$hr[$i]]+$sum;
						$hour_sah[$hr[$i]]=$hour_sah[$hr[$i]]+$sah_val;
					}
					else
					{
						echo "<td bgcolor=\"YELLOW\">".$sum."</td>";
						$hour_tot[$hr[$i]]=$hour_tot[$hr[$i]]+$sum;
						$hour_sah[$hr[$i]]=$hour_sah[$hr[$i]]+$sah_val;
						$hour_cnt[$hr[$i]]=$hour_cnt[$hr[$i]]+1;	
						$hour_cnt_eff[$hr[$i]]=$hour_cnt_eff[$hr[$i]]+$eff;
					}
					
					$gtotal=$gtotal+$sum;
				}
				else
				{
					echo "<td bgcolor=\"red\">0</td>"; 
				}				
				
			}
		}
		else
		{
			$gtotal=$output[$mod];
			$hour_tots=$hour_tots+$gtotal;
		}	
		//headers based loop for times date end
		//total and hours  start
		if($gtotal==0) 
		{ 
			echo "<td bgcolor\"red\">0</td>";
		}
		else 
		{ 
			echo "<td>".$gtotal."</td>";
		} 
		$digit=2;
		$atotal=$gtotal;
		//total and hours  end       
		/* PLAN EFF, PRO */ 
		$stha=$sah[$mod];
		$peff_a=$plan_eff[$mod];
		$ppro_a=$plan_pro[$mod];
		$psth=$plan_sah[$mod];
		if($clha_shift>0)
		{	
			$effa=($sah[$mod]/$clha_shift);
		}
		else
		{
			$effa=0;
		}
		echo "<td>".$hoursa_shift."</td>"; 
		$hrs[]=$hoursa_shift;
		echo "<td>".round($peff_a,2)."%</td>";
		$plan_sah_hr=$psth; 
        echo "<td>".round($ppro_a,$digit)."</td>";
        echo "<td>".round($clha_shift,$digit)."</td>"; 
        echo "<td>".round($plan_sah_hr,$digit)."</td>"; 
        $color=""; 
        if(round(($effa*100))>=70) 
        { 
          $color="#1cfe0a"; 
        }elseif(round(($effa*100))>=60 and round(($effa*100))<70) 
        { 
          $color="YELLOW"; 
        }else 
        { 
          $color="#ff0915"; 
        }
        echo "<td>".round($stha,$digit)."</td>";
        echo "<td bgcolor=\"$color\">".round(($effa*100),$digit)."%</td>";
        echo "<td>".round(($atotal-$ppro_a),$digit)."</td>";
        if($hoursa_shift>0) 
		{ 
			$avgperhour=$atotal/$hoursa_shift; 
		}else 
		{ 
			$avgperhour=$atotal; 
		} 
		echo "<td>".round($avgperhour,$digit)."</td>";
        /* NEW 20100318 */ 
		if(sizeof($shifts_array)<2 && ($atotal-$ppro_a<0))
		{
			$qty=round(($ppro_a-$atotal),$digit);
			$hoursnw=8-$hoursa;
			if($hoursnw==0)
			{
				$exp_pcs_hr=round($qty,$digit);
			}
			else
			{
				$exp_pcs_hr=round($qty,$digit)/round($hoursnw,$digit);
			}
		}
		else if(($atotal-$ppro_a<0))
		{	
			if($current_hr<14 )
			{
				$qty=round(($ppro_a-$atotal),$digit);
				$hoursnw=8-$hoursa;
				if($hoursnw==0)
				{
					$exp_pcs_hr=round($qty,$digit);
				}
				else
				{
					$exp_pcs_hr=round($qty,$digit)/round($hoursnw,$digit);
				}		
			}
			else
			{
				$qty=round(($ppro_a-$atotal),$digit);
				$hoursnw=16-$hoursa;
				$exp_pcs_hr=round($qty,$digit)/round($hoursnw,$digit);
			}
		}
		else
		{
			$exp_pcs_hr=0;
		}
        echo "<td>".round($exp_pcs_hr,$digit)."</td>";
		$sum_total_final=$sum_total_final+round($atotal,$digit);
		$hoursa_shift_sum_total=$hoursa_shift_sum_total+round($hoursa_shift,$digit);
		$ppro_a_total_sum_total=$ppro_a_total_sum_total+round($ppro_a,$digit);
		$clha_total_sum_total=$clha_total_sum_total+round($clha_shift,$digit);
		$plan_sah_hr_total_sum_total=$plan_sah_hr_total_sum_total+round($plan_sah_hr,$digit);
		$stha_total_sum_total=$stha_total_sum_total+round($stha,$digit);
		$plan_clha_total_sum_total=$plan_clha_total_sum_total+round($plan_clh[$mod],$digit);
		$avgpcstotal_sum_total=$avgpcstotal_sum_total+round($avgperhour,$digit);
		$req_pcs_per_hour=$req_pcs_per_hour+round($exp_pcs_hr,$digit);
	} 
} 
	// Over All Totals
	$var_val=1;
	$iii=0;
	echo "<tr class=\"total\"><td colspan=5>Total</td>";
	if($hourly_break==1)
	{
		for($ii=0;$ii<sizeof($hr);$ii++) 
		{
			echo "<td id='table1Tots".($var_val+$ii)."' style='background-color:#FFFFCC;'>0</td>";
		}
		$var_val=$var_val+sizeof($hr);
	}
	else
	{
		$var_val=1;
	}	
	
	echo "<td id='table1Tots".($var_val)."' style='background-color:#FFFFCC;'>".round($sum_total_final,$digit)."</td>";
	echo "<td id='table1Tots".($var_val+1)."' style='background-color:#FFFFCC;'>".round($hoursa_shift_sum_total,$digit)."</td>";
	$peffsecresult=round(($plan_sah_hr_total_sum_total/$plan_clha_total_sum_total)*100,2);
	echo "<td id='table1Tots".($var_val+2)."' style='background-color:#FFFFCC;'>".round($peffsecresult,$digit)."%</td>";
	$plan_eff_avg=$var_val+2;
	echo "<td id='table1Tots".($var_val+3)."' style='background-color:#FFFFCC;'>".round($ppro_a_total_sum_total,$digit)."</td>";
	echo "<td id='table1Tots".($var_val+4)."' style='background-color:#FFFFCC;'>".round($clha_total_sum_total,$digit)."</td>";
	echo "<td id='table1Tots".($var_val+5)."' style='background-color:#FFFFCC;'>".round($plan_sah_hr_total_sum_total,$digit)."</td>";
	echo "<td id='table1Tots".($var_val+6)."' style='background-color:#FFFFCC;'>".round($stha_total_sum_total,$digit)."</td>";
	if($clha_total_sum_total>0)
	{	
		$aeffsecresult=round(($stha_total_sum_total/$clha_total_sum_total)*100,2);
	}
	else{
		$aeffsecresult=0;
	}
	echo "<td id='table1Tots".($var_val+7)."' style='background-color:#FFFFCC;'>".round($aeffsecresult,$digit)."%</td>";
	$act_eff_avg=$var_val+7;
	echo "<td id='table1Tots".($var_val+8)."' style='background-color:#FFFFCC;'>".round(($sum_total_final-$ppro_a_total_sum_total),$digit)."</td>";
	echo "<td id='table1Tots".($var_val+9)."' style='background-color:#FFFFCC;'>".$avgpcstotal_sum_total."</td>";
	echo "<td id='table1Tots".($var_val+10)."' style='background-color:#FFFFCC;'>".$req_pcs_per_hour."</td>";
	echo"</tr></table><br><br></div>";
	$var_val=$var_val+10;
	for($j=1;$j<=$var_val;$j++)
	{
		$val11[]="table1Tots".$j;
		$val21[]=$j+4;
		if(($j==$plan_eff_avg) || ($j==$act_eff_avg))
		{
				$val31[]="mean";
		}
		else
		{
			$val31[]="sum";
		}	
		$val41[]=1;
		$val51[]="innerHTML";
	}
	/* Ending of sections table  */
	$total_factory_summery ="";
	$total_factory_summery="<br><h2 style=\"color:white;background-color: #29759C;\">Factory Summary<h2>"; 
	
	$total_factory_summery .="<div class=\"maincontentof\"><table id=\"info\" class='table table-bordered'><th style='background-color:#29759C;'><h4></h4></th>";
	for($i=0;$i<sizeof($hr);$i++) 
	{ 
		if($hourly_break==1)
		{
			$total_factory_summery .="<th style='background-color:#29759C;'>".$hr_disp[$i]."</th>"; 
		} 
	}
	$total_factory_summery .="<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Avg Hours</th> 
	 <th style='background-color:#29759C;'>Avg Plan EFF%</th> 
	 <th style='background-color:#29759C;'>Plan Pro.</th> 
	 <th style='background-color:#29759C;'>CLH</th> 
	 <th style='background-color:#29759C;'>Plan SAH</th> 
	 <th style='background-color:#29759C;'>Act SAH</th> 
	 <th style='background-color:#29759C;'>Act. EFF%</th> 
	 <th style='background-color:#29759C;'>Avg Balance Pcs.</th> 
	 <th style='background-color:#29759C;'>Act.Pcs/Hr</th> 
	 <th style='background-color:#29759C;'>Req.Pcs/Hr</th>"; 
	$total_factory_summery .="<tr class=\"total\"><td colspan=1 style='background-color:white;color:black'>Totals</td>";
	$total=0; 
	$atotal=0; 
	if($hourly_break==1)
	{
		for($i=0; $i<sizeof($hr); $i++) 
		{			 
			$sum=$hour_tot[$hr[$i]]; 
			if($sum==0) 
			{ 
				$sum=0; 
				$total_factory_summery .="<td style='background-color:white;color:black'>0</td>"; 
			} 
			else 
			{ 
				$total_factory_summery .="<td style='background-color:white;color:black'>".$sum."</td>"; 
			}			 
		}
		$atotal=array_sum($hour_tot);		
	}
	else
	{
		$sum=$hour_tots; 
		if($sum==0) 
		{ 
			$sum=0; 
			$total_factory_summery .="<td style='background-color:white;color:black'>0</td>"; 
		} 
		else 
		{ 
			$total_factory_summery .="<td style='background-color:white;color:black'>".$sum."</td>"; 
		}
		$atotal=$hour_tots;
	}
	
	/* NEW */ 	
	$hoursa_shift=array_sum($hrs)/count($hrs);
	$total_factory_summery .="<td rowspan=4 style='background-color:white;color:black'>".$atotal."</td>"; 
	$total_factory_summery .="<td rowspan=4 style='background-color:white;color:black'>".$hoursa_shift."</td>"; 
	$total_factory_summery .="<td rowspan=4 style='background-color:white;color:black'>".round($peffsecresult,$digit)."%</td>"; 
	$total_factory_summery .="<td rowspan=4 style='background-color:white;color:black'>".round($ppro_a_total_sum_total,$digit)."</td>"; 
	$total_factory_summery .="<td rowspan=4 style='background-color:white;color:black'>".round($clha_total_sum_total,$digit)."</td>"; 
	$total_factory_summery .="<td rowspan=4 style='background-color:white;color:black'>".round($plan_sah_hr_total_sum_total,$digit)."</td>"; 
	$total_factory_summery .="<td rowspan=4>".round($stha_total_sum_total,$digit)."</td>"; 

	$xa=0; 
	if($clha_total_sum_total>0) 
	{ 
		$xa=round(($stha_total_sum_total/$clha_total_sum_total)*100,2);  
	}


	if($xa>=70) 
	{ 
		$color_per_fac2="#1cfe0a"; 
	} 
	elseif($xa>=60 and $xa<70) 
	{ 
		$color_per_fac2="YELLOW"; 
	} 
	else 
	{ 
		$color_per_fac2="#ff0915"; 
	} 

	$total_factory_summery .="<td rowspan=4 style='background-color:$color_per_fac2; color:black; font-weight:bold; '>".round($xa,2)."%</td>"; 
	$total_factory_summery .="<td  rowspan=4 style='background-color:white;color:black'>".round(($sum_total_final-$ppro_a_total_sum_total),$digit)."</td>"; 
	$total_factory_summery .="<td  rowspan=4>".round($avgpcstotal_sum_total,0)."</td>"; 
	$total_factory_summery .="<td  rowspan=4 style='background-color:white;color:black'>".round($req_pcs_per_hour,0)."</td>";	
	
	/* STH */ 
	$cnts=0;
	$total_factory_summery .="<tr class=\"total\"><td style='background-color:white;color:black'>HOURLY SAH</td>"; 
	if($hourly_break==1)
	{
		for($i=0; $i<sizeof($hr); $i++) 
		{
			$sth=0; 
			$sth=$hour_sah[$hr[$i]];
			if($sth>0)
			{
				$cnts++;
			}				
			$total_factory_summery .="<td style='background-color:white;color:black'>".round($sth,0)."</td>"; 
		} 
	}

	/* EFF */ 
	$total_factory_summery .="<tr class=\"total\"><td style='background-color:white;color:black'>HLY EFF%</td>"; 
	if($hourly_break==1)
	{
		for($i=0; $i<sizeof($hr); $i++) 
		{ 
			$eff=0; 
			$minutes=60;
			$eff=$hour_cnt_eff[$hr[$i]];	
			$noofmods=$hour_cnt[$hr[$i]]; 
			/* NEW20100219 */ 
			if($noofmods>0 && $eff>0) 
			{ 
				$total_factory_summery .="<td style='background-color:white;color:black'>".round((round($eff,2)/$noofmods),0)."%</td>"; 
			} 
			else 
			{ 
				$total_factory_summery .="<td style='background-color:white;color:black'>0</td>"; 
			} 
		} 
	}
	/* AVG p per hour */ 
	$total_factory_summery .="<tr class=\"total\"><td style='background-color:white;color:black'>AVG-Pcs/HR</td>"; 
	$total=0; 
	$btotal=0; 
	if($hourly_break==1)
	{
		for($i=0; $i<sizeof($hr); $i++) 
		{ 
			$sum=$hour_tot[$hr[$i]]; 
			
			if($sum==0) 	
			{ 
				$sum=0; 
				$total_factory_summery .="<td style='background-color:white;color:black'>0</td>"; 
			} 
			else 
			{ 
				if($cnts>0) 
				{ 
					$total_factory_summery .="<td style='background-color:white;color:black'>".round(($sum/$cnts),0)."</td>"; 
				} 
				else 
				{ 
					$total_factory_summery .="<td style='background-color:white;color:black'>".round(($sum),0)."</td>"; 
				} 
			} 
			
		} 
	}
$total_factory_summery .="</tr>"; 
$total_factory_summery .="</table></div>";
echo  $total_factory_summery;
//-----------------------------------------common to show this for all selections total factory end-------------------------------------//
//-----------------------------------------style summery Report while he selects Style Break-------------------------------------//
if($style_break==1)
{
	//factory level
	/* Stylewise Report */ 
	$sdate=$date;
	$style_summ_head=""; 
	$style_summery='';
	$style_summery='<br><h2 style="color:white;background-color: #337ab7;">Style Summary<h2>'; 
	$style_summery.="<div class=\"maincontentof\"><table class='table table-bordered' id=\"table_format_one\">"; 
	$style_summery.="<tr><th style='background-color:#29759C;color:white;'>Style Name</th style='background-color:#29759C;color:white;'><th style='background-color:#29759C;color:white;'>SMV</th ><th style='background-color:#29759C;color:white;'>Oprs</th><th style='background-color:#29759C;color:white;'>Mod Count</th>"; 
	for($m=0;$m<sizeof($hr);$m++) 
	{ 
		$style_summery.="<th style='background-color:#29759C;color:white;'>".$hr_disp[$m]."</th>"; 
	} 
	$style_summery.="<th style='background-color:#29759C;color:white;'>Total</th><th style='background-color:#29759C;color:white;'>Plan Pcs</th><th style='background-color:#29759C;color:white;'>Balance Pcs</th><th style='background-color:#29759C;color:white;'>Avg. Pcs/Hr</th><th style='background-color:#29759C;color:white;'>Hr Tgt.</th><th style='background-color:#29759C;color:white;'>Avg. Pcs<br/>Hr/Mod</th><th style='background-color:#29759C;color:white;'>Hr Tgt./Mod.</th></tr>"; 
	$avgpcshrsum=0; 
	$planpcsgrand=0; 
	$balancepcs=0; 
	$exp_pcs_hr_total=0; 
	$avgperhour2_sum=0; 
	$exp_pcs_hr2_sum=0; 
	$sql="SELECT operation,style,SUM(good_quantity) AS qty, GROUP_CONCAT(DISTINCT resource_id) AS mods FROM $pts.transaction_log WHERE $time_query_new AND parent_barcode_type='PPLB' and resource_id in ('".implode("','",$tot_modules)."') and shift in ($team) and plant_code='".$plantcode."' group by style,operation";
	$sql_result=mysqli_query($link, $sql) or exit("SQL Error - transaction_log -3".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($trans_row=mysqli_fetch_array($sql_result))
	{	
		$style=$trans_row['style'];
		$mod_no=$trans_row['mods'];
		$operaiton_code=$trans_row['operation'];
		//Fetching SMV
		$sql_to_fet_smv="SELECT smv FROM $oms.oms_products_info AS opi LEFT JOIN $oms.oms_mo_operations AS omo ON opi.mo_number=omo.mo_number LEFT JOIN $oms.oms_mo_details AS omd ON omd.mo_number=omo.mo_number WHERE opi.style='".$style."' AND omo.operation_code=".$operaiton_code." and omd.plant_code='".$plantcode."' LIMIT 1";
		// echo $sql_to_fet_smv."<br>";
		$sql_to_fet_smv_res=mysqli_query($link, $sql_to_fet_smv) or exit("Error while getting SMV Information".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($smv_res=mysqli_fetch_array($sql_to_fet_smv_res))
		{
			$smv=$smv_res['smv'];
		}
		
		if($smv>0)
		{
			$sql212="select sum(present+jumper) as nop from $pms.pro_attendance where date='".$date."' plant_code='$plantcode' and module in ($mod_no) and  shift in ($team)"; 
			$sql_result212=mysqli_query($link, $sql212) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			if(mysqli_num_rows($sql_result212)>0)
			{
				while($sql_row122=mysqli_fetch_array($sql_result212)) 
				{ 
					$nops=$sql_row122['nop']; 
				}
			}		
			else
			{
				$nops=0;
			}
			$cnt=sizeof(explode(",",$mod_no));

			$style_summery.="<tr><td>".$style."</td>"; 
			$style_summery.="<td>".$smv."</td>"; //to show smv based on m3 integration from system. 
			$style_summery.="<td>".$nops."</td>"; //to show smv based on m3 integration from system. 
			$style_summery.="<td>".$cnt."</td>";

			if($hourly_break==1)
			{
				$total=0;
				for($i=0; $i<sizeof($hr); $i++) 
				{ 
					$sql31="SELECT sum(good_quantity),operation as sum FROM $pts.`transaction_log` 
					WHERE plant_code='".$plantcode."' and created_at BETWEEN ('$date ".$hr_start[$i]."') and ('$date ".$hr_end[$i]."') and shift in ($team) and resource_id='".$mod."' group by style,operation";
					//echo $sql31."<br>";
					$result31=mysqli_query($link, $sql31) or die("SQL Error - transaction_log -4".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($result31)>0)
					{	
						while($rows=mysqli_fetch_array($result31))
						{	
							$operation=$rows['operation'];
							$sql_to_fet_smv="SELECT smv FROM $oms.oms_products_info AS opi LEFT JOIN $oms.oms_mo_operations AS omo ON opi.mo_number=omo.mo_number LEFT JOIN $oms.oms_mo_details AS omd ON omd.mo_number=omo.mo_number WHERE opi.style='".$style."' AND omo.operation_code=".$operation." and omd.plant_code='".$plantcode."' LIMIT 1";
							// echo $sql_to_fet_smv."<br>";
							$sql_to_fet_smv_res=mysqli_query($link, $sql_to_fet_smv) or exit("Error while getting SMV Information".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($smv_res=mysqli_fetch_array($sql_to_fet_smv_res))
							{
								$smv=$smv_res['smv'];
							}						
							if($smv>0)
							{
								$sum= $sum + $rows['sum'];
								$hour_data[$hr[$i]]=$hour_data[$hr[$i]]+$rows['sum'];	
							}	
						}
						if($sum==0) 
						{ 
							$sum=0; 
							$style_summery.="<td bgcolor=\"red\">0</td>"; 
						} 
						else 
						{ 
							$style_summery.="<td bgcolor=\"YELLOW\">".$sum."</td>"; 
							$total=$total+$sum; 
						} 
					}
				} 
				$style_summery.="<td>".$total."</td>";
			}
			else
			{
				$total=$trans_row['sum'];	
				$style_summery.="<td>".$total."</td>"; 
			}	
		}
		$plan_pcs=0; 
		$sql22="select sum(planned_qty) as planned_qty from $pps.monthly_production_plan where planned_date=\"$date\" and mod_no in ($mod_no) and shift in ($team)"; 
		//echo $sql22."<br>"; 
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row22=mysqli_fetch_array($sql_result22)) 
		{ 
			$plan_pcs=$sql_row22['planned_qty']; 
		} 
 
		$planpcsgrand=$planpcsgrand+$plan_pcs; 
		$style_summery.="<td>".round($plan_pcs,0)."</td>";
		$balancepcs=$balancepcs+($plan_pcs-$total); 
		$style_summery.="<td>".(round($plan_pcs,0)-$total)."</td>"; 
		$avgperhour=0; 
		$avgperhour2=0; 
		if(($hoursa_shift)>0) 
		{ 
			$avgperhour2=round(($total/$cnt/($hoursa_shift)),0); 
			$avgperhour=round(($total/($hoursa_shift)),0); 
			$count2=$cnt; 
			$style_summery.="<td>".$avgperhour."</td>"; 
		} 
		else 
		{ 
			$style_summery.="<td>0</td>"; 
		} 
		 
		$avgpcshrsum=$avgpcshrsum+$avgperhour; 
		$exp_pcs_hr=0; 
		$exp_pcs_hr2=0; 
		$g_total=$total+$total;		
		if(sizeof($shifts_array)<2)
		{
			$qty=round(($plan_pcs-$total),0);
			$hoursnw=8-$hoursa;
			//echo $qty."<br>";
			if($hoursnw==0)
			{
				$exp_pcs_hr=round($qty,0);
			}
			else
			{
				$exp_pcs_hr=round($qty,0)/round($hoursnw,0);
				$exp_pcs_hr2=round($qty,0)/round($hoursnw,0)/$cnt;
			}
		}
		else
		{	
			if($current_hr<14)
			{
				$qty=round(($plan_pcs-$total),0);
				$hoursnw=8-$hoursa;
				if($hoursnw==0)
				{
					$exp_pcs_hr=round($qty,0);
				}
				else
				{
					$exp_pcs_hr=round($qty,0)/round($hoursnw,0);
					$exp_pcs_hr2=round($qty,0)/round($hoursnw,0)/$cnt;
				}		
			}
			else
			{
				$qty=round(($plan_pcs-$total),0);
				$hoursnw=16-$hoursa;
				$exp_pcs_hr=round($qty,0)/round($hoursnw,0);
				$exp_pcs_hr2=round($qty,0)/round($hoursnw,0)/$cnt;				
			}
		}
		
		$style_summery.="<td>".round($exp_pcs_hr,0)."</td>"; 
		$exp_pcs_hr_total=$exp_pcs_hr_total+$exp_pcs_hr; 
		$style_summery.="<td>".round($avgperhour2,0)."</td>"; 
		$style_summery.="<td>".round($exp_pcs_hr2,0)."</td>"; 
		$avgperhour2_sum=$avgperhour2_sum+$avgperhour2; 
		$exp_pcs_hr2_sum=$exp_pcs_hr2_sum+$exp_pcs_hr2; 
		$style_summery.="</tr>"; 										
	}
	$value=1;
	$style_summery.="<tr><td colspan=4>Total</td>"; 
	if($hourly_break==1)
	{
		for($i=0; $i<sizeof($hr); $i++) 
		{ 
			$sum=$hour_data[$hr[$i]]; 
			if($sum==0) 
			{ 
				$sum=0;
				$style_summery.="<td id='table1Tot".($value)."' style='background-color:#FFFFCC;'>0</td>"; 
			} 
			else 
			{ 
				$style_summery.="<td id='table1Tot".($value)."' style='background-color:#FFFFCC;'>".$sum."</td>"; 
			} 
			
			$value++;
		} 
	}
	else
	{
		$value=1;
	}	
	
	$style_summery.="<td id='table1Tot".$value."' style='background-color:#FFFFCC;'>".$total."</td>"; 
	$style_summery.="<td id='table1Tot".($value+1)."' style='background-color:#FFFFCC;'>".round($planpcsgrand,0)."</td>"; 
	$style_summery.="<td id='table1Tot".($value+2)."' style='background-color:#FFFFCC;'>".round($balancepcs,0)."</td>"; 
	$style_summery.="<td id='table1Tot".($value+3)."' style='background-color:#FFFFCC;'>".$avgpcshrsum."</td>"; 
	$style_summery.="<td id='table1Tot".($value+4)."' style='background-color:#FFFFCC;'>".round($exp_pcs_hr_total,0)."</td>"; 
	$style_summery.="<td id='table1Tot".($value+5)."' style='background-color:#FFFFCC;'>".round($avgperhour2_sum,0)."</td>"; 
	$style_summery.="<td id='table1Tot".($value+6)."' style='background-color:#FFFFCC;'>".round($exp_pcs_hr2_sum)."</td>"; 

	$style_summery.="</table></div>";
	echo  $style_summery;
	echo "</div>";
	$value=$value+6;
	for($j=1;$j<=$value;$j++)
	{
		$val1[]="table1Tot".$j;
		$val2[]=$j+3;
		$val3[]="sum";
		$val4[]=1;
		$val5[]="innerHTML";
	}			
	
}

//-----------------------------------------style summery Report while he selects Style Break-------------------------------------//

}
//echo "test--".$var_val."<br>";
?>
<?php  ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); 

?>

<script language="javascript" type="text/javascript">
	var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	col_0: 'select',
	col_1: 'select',
	col_2: 'none',
	col_3: 'select',
	col_4: 'select',
	col_<?php echo ($var_val+4); ?>: 'select',
	<?php for($i=0;$i<sizeof($hr);$i++) 
		{
			echo "col_".($i+5).": 'none',";
		}
		if(sizeof($hr)>0){
			echo "col_".(sizeof($hr)+5).": 'none',";
			echo "col_".(sizeof($hr)+6).": 'none',";
			echo "col_".(sizeof($hr)+7).": 'none',";
			echo "col_".(sizeof($hr)+8).": 'none',";
			echo "col_".(sizeof($hr)+9).": 'none',";
			echo "col_".(sizeof($hr)+10).": 'none',";
			echo "col_".(sizeof($hr)+11).": 'none',";
			echo "col_".(sizeof($hr)+12).": 'none',";
			echo "col_".(sizeof($hr)+13).": 'none',";
			echo "col_".(sizeof($hr)+14).": 'none',";
		}
		?>
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: {						
						id: ["<?php echo implode('","',$val11) ?>"],
						col: [<?php echo implode(',',$val21) ?>],  
						operation: ["<?php echo implode('","',$val31) ?>"],
						decimal_precision: [<?php echo implode(',',$val41) ?>],
						write_method: ["<?php echo implode('","',$val51) ?>"] 
					},
	rows_always_visible: [grabTag(grabEBI('table_format_first'),"tr").length]
		
	};
	
	 setFilterGrid("table_format_first",fnsFilters);
	
</script>

<script language="javascript" type="text/javascript">
	var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	col_0: 'select',
	col_1: 'none',
	col_2: 'none',
	col_3: 'none',
	<?php for($i=0;$i<sizeof($hr);$i++) 
		{
			echo "col_".($i+4).": 'none',";
		}
		if(sizeof($hr)>0){
			echo "col_".(sizeof($hr)+4).": 'none',";
			echo "col_".(sizeof($hr)+5).": 'none',";
			echo "col_".(sizeof($hr)+6).": 'none',";
			echo "col_".(sizeof($hr)+7).": 'none',";
			echo "col_".(sizeof($hr)+8).": 'none',";
			echo "col_".(sizeof($hr)+9).": 'none',";
			echo "col_".(sizeof($hr)+10).": 'none',";
		}?>
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: {						
						id: ["<?php echo implode('","',$val1) ?>"],
						col: [<?php echo implode(',',$val2) ?>],  
						operation: ["<?php echo implode('","',$val3) ?>"],
						decimal_precision: [<?php echo implode(',',$val4) ?>],
						write_method: ["<?php echo implode('","',$val5) ?>"] 
					/*	id: ["table1Tot1","table1Tot2","table1Tot3","table1Tot4","table1Tot5","table1Tot6","table1Tot7"],
						col: [4,5,6,7,8,9,10],  
						operation: ["sum","sum","sum","sum","sum","sum","sum"],
						decimal_precision: [1,1,1,1,1,1,1],
						write_method: ["innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML"] */
					},
	rows_always_visible: [grabTag(grabEBI('table_format_one'),"tr").length]
		
	};
	
	 setFilterGrid("table_format_one",fnsFilters);
	
</script>
