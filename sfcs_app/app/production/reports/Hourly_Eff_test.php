<title>Hourly Efficiency Report</title>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=edge,chrome=1" /> 
<link rel="stylesheet" href="style.css" type="text/css" media="all" /> 
<link rel="stylesheet" href="../../../common/css/styles/bootstrap.min.css">
<script language="javascript" type="text/javascript" src="../../../common/js/TableFilter_EN/tablefilter.js"></script>
<script language="javascript" type="text/javascript" src="../../../common/js/TableFilter_EN/actb.js"></script>


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
                        include("../../../common/config/config.php");
                        error_reporting(0);
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
         ?> 

<!--form starting for taking the inputs -->
 <form method="POST" class="form-inline" action="<?php $_SERVER['PHP_SELF']; ?>" onsubmit="showHideDiv()"> 
                        <div class="row">
                            <div class="col-md-2">
									<label for="demo1">Select Date: </label>
                                	<input type="date" data-toggle="datepicker" name="dat" id="demo1" value="<?= $date; ?>"  required class="form-control"/></td> 
                            </div>
                            <div class="col-md-2">
                                <label for="section">Select Section: </label>
                                <?php
                                    echo "<select name=\"section\" id='section' class=\"form-control\" >"; 
                                    $sql2="select * from $bai_pro3.sections_master order by sec_id"; 
									
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        if($sections_string==$sql_row2['sec_name']) 
                                        { 
                                            echo "<option value=\"".$sql_row2['sec_name']."\" selected>".$sql_row2['section_display_name']."</option>"; 
											$sections_list[]=$sql_row2['sec_name'];
                                        } 
                                        else 
                                        { 
                                            echo "<option value=\"".$sql_row2['sec_name']."\">".$sql_row2['section_display_name']."</option>"; 
											$sections_list[]=$sql_row2['sec_name'];
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
                                <select name="team" id="team" class="form-control"> 
								<option value=<?php echo implode(",",$shifts_array); ?>>All</option>
                                    <?php 
                                        for ($i=0; $i < sizeof($shifts_array); $i++) {?>
                                            <option  <?php echo 'value="'.$shifts_array[$i].'"'; if($team==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
                                        <?php }
                                    ?>
                                </select>
                            </div> 
                            <div class="col-md-2">
                               <label for="hour_filter" valign="top">Select Hour: </label>
                               <?php
                                    echo "<select name=\"hour_filter\" id='hour_filter' class=\"form-control\" >";
                                    
                                    

                                    $sql22="SELECT GROUP_CONCAT(CONCAT(start_time,'$',end_time)) AS intervala,GROUP_CONCAT(time_value) AS time_display FROM $bai_pro3.tbl_plant_timings"; 
									
                                    $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    $sql_row22=mysqli_fetch_array($sql_result22);
                                    $hours_list=$sql_row22['intervala'];
                                    $hours_list_dispaly=$sql_row22['time_display'];
                                    $hours_list_array=explode(",",$hours_list);
                                    $hours_list_dispaly_array=explode(",",$hours_list_dispaly);
                                    
                                    if($hour_filter=='All'){
                                        echo "<option value=\"All\" selected>All</option>";
                                        $headers=array();
                                        foreach($hours_list_array as $key => $hours_list_ss){
                                            $headers[$key]=$hours_list_dispaly_array[$key];
                                        }
                                    }else{
                                        echo "<option value=\"All\">All</option>";
                                    }
                                   
                                    // echo "<option value=\"".$hour_filter."\">selected</option>";
                                    foreach($hours_list_array as $key => $hours_list_ss){
                                        if($hours_list_ss==$hour_filter){
                                            $headers=array();
                                            echo "<option value=\"".$hours_list_ss."\" selected>".$hours_list_dispaly_array[$key]."</option>"; 
                                            $headers[0]=$hours_list_dispaly_array[$key];
                                        }else{
                                        //$headers[$key]=$hours_list_dispaly_array[$key]."-".$hours_list_dispaly_array[$key+1];
                                            echo "<option value=\"".$hours_list_ss."\">".$hours_list_dispaly_array[$key]."</option>"; 
                                        }
                                       
                                        
                                    }  
                                   
                                    echo "</select>"; 
                                   // echo $sql; 
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
                        <img src="../common/images/pleasewait.gif"> 
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
	//echo explode(",",$team)."<bR>";
    $hour_filter=$_POST['hour_filter'];//slected hour  
    $style_break=($_POST['secstyles']==1) ? $_POST['secstyles'] : 0 ; //style break
    $hourly_break=($_POST['option1']==1) ? $_POST['option1'] : 0;//hourly Break 
    //echo "<br>date".$date." - section -".$sections_string." - team - ".$team." - hour ".$hour_filter." - style break".$secstyles." -hourly Break ".$option1; 
	$current_hr=date('H');
	$current_date=date('Y-m-d');
	if(sizeof(explode(",",$team))==1)
	{
		$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift ='".$team."'";
		//echo $sql_hr."<br>";
		$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_hr)>0)
		{
			while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
			{
				$start_check=$sql_row_hr['start_time'];
				$end_check=$sql_row_hr['end_time'];
			}
		}
		else
		{
			exit;
		}
	}
	else
	{
		$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date'";
		//echo $sql_hr."<br>";
		$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_result_hr)>0)
		{
			$sql_hr12="SELECT MIN(time_value*1)AS vals,MAX(time_value*1) AS vals2 FROM $bai_pro3.tbl_plant_timings";
			//echo $sql_hr12."<br>";
			$sql_result_hr12=mysqli_query($link, $sql_hr12) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_hr12=mysqli_fetch_array($sql_result_hr12)) 
			{
				$start_check=$sql_row_hr12['vals'];
				$end_check=$sql_row_hr12['vals2'];
			}
		}
		else
		{
			exit;
		}
	}
	
	if($current_date<>$date)
    {
		$sql32="SELECT MAX(time_value*1) as val FROM $bai_pro3.tbl_plant_timings";
		//echo $sql."<br>";
		$sql_result32=mysqli_query($link, $sql32) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row32=mysqli_fetch_array($sql_result32)) 
		{
			$current_hr=$sql_row32['val'];
		}			
    }
    if($hour_filter=='All') 
    { 
		$time_query=""; 
		$sql="SELECT MIN(start_time) AS start_time,MAX(end_time) AS end_time FROM $bai_pro3.tbl_plant_timings where time_value<=".$current_hr."";
		//echo $sql."<br>";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row=mysqli_fetch_array($sql_result)) 
		{				
			$time_query=" AND TIME(bac_lastup) BETWEEN ('".$sql_row['start_time']."') and ('".$sql_row['end_time']."')"; 		
		}		
    } 
    else 
    {	
		$hour_filter_array=explode("$", $_POST['hour_filter']);
		$time_query=" AND TIME(bac_lastup) BETWEEN ('".$hour_filter_array[0]."') and ('".$hour_filter_array[1]."')"; 
    }
    $sections=explode(",", $_POST['section']);
    $teams=explode(",",$team);
    $team = "'".str_replace(",","','",$team)."'"; 
    $work_hrs=0;
    $sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift in ($team)";
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
    }
	else
	{
        if(sizeof($teams) > 1) 
        { 
            $work_hours=15; 
        } 
        else 
        { 
            $work_hours=7.5; 
        }
    }                          
   
	if($current_date==$date)
    {
        $hour_dur=0;
        for($i=0;$i<sizeof($teams);$i++)
        {
            $sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$teams[$i]."' and  $current_hr between start_time and end_time";
			$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
            if(mysqli_num_rows($sql_result_hr) >0)
            {
                while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
                { 
                    $start_time=$sql_row_hr['start_time'];
                    $end_time=$sql_row_hr['end_time'];
                    $diff_time=$current_hr-$start_time;
                    if($diff_time>3)
                    {
                         $diff_time=$diff_time-0.5;
                    }
                    $hour_dur=$hour_dur+$diff_time;
                }
            }
            else
            {
                $sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$teams[$i]."' and $current_hr > end_time";
                $sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
	//creation of temp tables start 
	$pro_mod="temp_pool_db.".$username.date("YmdHis")."_"."pro_mod"; 
	$pro_plan="temp_pool_db.".$username.date("YmdHis")."_"."pro_plan"; 
	$grand_rep="temp_pool_db.".$username.date("YmdHis")."_"."grand_rep"; 
	$pro_style="temp_pool_db.".$username.date("YmdHis")."_"."pro_style"; 
	$table_name="temp_pool_db.".$username.date("YmdHis")."_"."bai_log"; 

	$sql="create TEMPORARY table ".$pro_mod." ENGINE = MyISAM select * from bai_pro3.module_master where status='Active'"; 
	$sql_result1=mysqli_query($link, $sql) or exit("Sql Error1z1".mysqli_error($GLOBALS["___mysqli_ston"])); 

	$sql="create TEMPORARY table ".$pro_plan." ENGINE = MyISAM select * from bai_pro.pro_plan where date='".$date."'"; 
	$sql_result2=mysqli_query($link, $sql) or exit("Sql Error1z2".mysqli_error($GLOBALS["___mysqli_ston"])); 

	$sql="create TEMPORARY table ".$grand_rep." ENGINE = MyISAM select * from bai_pro.grand_rep where date='".$date."'"; 
	$sql_result3=mysqli_query($link, $sql) or exit("Sql Error1z3".mysqli_error($GLOBALS["___mysqli_ston"])); 

	$sql="create TEMPORARY table ".$pro_style." ENGINE = MyISAM select * from bai_pro.pro_style where date='".$date."'"; 
	$sql_result4=mysqli_query($link, $sql) or exit("Sql Error1z4".mysqli_error($GLOBALS["___mysqli_ston"])); 

	$sql="create TEMPORARY table ".$table_name." ENGINE = MyISAM select * from bai_pro.bai_log where bac_date='".$date."'"; 
	$sql_result5=mysqli_query($link, $sql) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
	//creation of temp tables end
	//$style_break  $hourly_break  
	/* sections table mandatory for all scenarios */  
	$hr=array();
	$hr_disp=array();
	$hr_start=array();
	$hr_end=array();
	
    echo "<div class=\"maincontentof\"><table class='table table-bordered' id=\"table_format_first\">";
    echo "<tr><th style='background-color:#29759C;'>Section#</th><th style='background-color:#29759C;'>Module#</th><th style='background-color:#29759C;'>NOP</th><th style='background-color:#29759C;'>Style DB</th><th style='background-color:#29759C;'>Schedule</th>";
	
    if($hourly_break==1)
	{
		if($hour_filter=='All') 
		{ 
			// $time_query="";
			// $current_hr=11;
			$sql="SELECT * FROM $bai_pro3.tbl_plant_timings where time_value<=".$current_hr." and time_value BETWEEN $start_check and $end_check";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row=mysqli_fetch_array($sql_result)) 
			{ 
				$hr[] = $sql_row['time_value'];
				$hr_disp[] = $sql_row['time_display']." ".$sql_row['day_part'];
				$hr_start[] = $sql_row['start_time'];
				$hr_end[] = $sql_row['end_time'];																			
			}									  
		} 
		else 
		{      
			$hour_filter_array=explode("$", $_POST['hour_filter']);
			//$time_query="AND TIME(bac_lastup) BETWEEN ('".$hour_filter_array[0]."') and ('".$hour_filter_array[1]."')"; 
			$sql="SELECT * FROM $bai_pro3.tbl_plant_timings where start_time='".$hour_filter_array[0]."' and end_time='".$hour_filter_array[1]."'";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row=mysqli_fetch_array($sql_result)) 
			{ 
				$hr[] = $sql_row['time_value'];
				$hr_start[] = $sql_row['start_time'];
				$hr_end[] = $sql_row['end_time'];										
			}
		}
		for($i=0;$i<sizeof($hr);$i++) 
		{ 
			echo "<th style='background-color:#29759C;'>".$hr_disp[$i]."</th>";
		}
    }
	
     echo "<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Hours</th> 
          <th style='background-color:#29759C;'>Plan EFF%</th> 
          <th style='background-color:#29759C;'>Plan Pro.</th> 
          <th style='background-color:#29759C;'>CLH</th> 
          <th style='background-color:#29759C;'>Plan SAH</th> 
          <th style='background-color:#29759C;'>Act SAH</th> 
          <th style='background-color:#29759C;'>Act. EFF%</th> 
          <th style='background-color:#29759C;'>Balance Pcs.</th> 
          <th style='background-color:#29759C;'>Act. Pcs/Hr</th> 
          <th style='background-color:#29759C;'>Req. Pcs/Hr</th> 
        </tr>";

		$sum_total=array();
		$pstha_sum_total=$pclha_sum_total=$hoursa_shift_sum_total=$ppro_a_total_sum_total=$clha_total_sum_total=
		$plan_sah_hr_total_sum_total=$plan_pro_sum=0;
for ($j=0;$j<sizeof($sections);$j++) 
{ 
    $sec=$sections[$j];
    $sec_head=""; 
    $sql="select * from $bai_pro3.sections_master where sec_name=$sec";                  
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $sec_head=$sql_row['section_head']; 
    } 
    // $sql="select mod_style, mod_no from $pro_mod where mod_sec=$sec and mod_date=\"$date\" order by mod_no*1";  
	$sql="select 0 as mod_style,module_name as mod_no FROM $bai_pro3.module_master WHERE section=$sec and status='Active' order by module_name*1";      
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
   // Module Level total calculations
    while($sql_row=mysqli_fetch_array($sql_result)) 
	{ 
		$mod=$sql_row['mod_no']; 
		$style=$sql_row['mod_style']; 
		$delno=$sql_row['delivery']; 
		$deldb=""; 
		$sql2="select distinct delivery from $table_name where bac_date=\"$date\" and bac_no=$mod $time_query";                              
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$deldb=$deldb." ".$sql_row2['delivery']; 
		} 
		$styledb=""; 
		$stylecount=0; 
		$sql2="select count(distinct bac_style) as \"count\" from $table_name where bac_date=\"$date\" 
		and bac_no=$mod  $time_query";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
		$stylecount=$sql_row2['count']; 
		} 
		if($stylecount>1) 
		{ 
			$sql2="select distinct bac_style from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query";               
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row2=mysqli_fetch_array($sql_result2)) 
			{ 
				$styledb=$styledb.$sql_row2['bac_style']."/"; 
			} 
			$styledb=substr_replace($styledb ,"",-1); 
		} 
		else 
		{ 
			$sql2="select distinct bac_style from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query"; 
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row2=mysqli_fetch_array($sql_result2)) 
			{ 
				$styledb=$styledb.$sql_row2['bac_style']; 
			} 
		} 
		echo "<tr><td>".$sec."</td><td>".$mod."</td>";
		$max=0; 
		$sql2="select bac_style, couple,smv,nop, sum(bac_qty) as \"qty\" from $table_name 
		where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style"; 
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			if($sql_row2['qty']>=$max) 
			{ 
				$couple=$sql_row2['couple']; 
				$style_code_new=$sql_row2['bac_style']; 
				$max=$sql_row2['qty']; 
				$smv=$sql_row2['smv']; 
				$nop=$sql_row2['nop']; 
			} 
		} 
		$nop=0; 
		$clha_shift=0; 
		$hoursa=0; 
		$nop_shift=0;
		$hoursa_shift=0;
		$diff_time=0;
		$current_date=date("Y-m-d");
		// date_default_timezone_set("Asia/Calcutta");
		$current_hr=date('H'); // echo $current_hr."<br>";

		//teams based looping start    
		for($k=0;$k<sizeof($teams);$k++)
		{
			$shift=$teams[$k];
			$sql_nop="select (present+jumper) as avail,absent from $bai_pro.pro_attendance 
			where date=\"$date\" and module=\"$mod\" and shift=\"$shift\""; 
			// echo $sql_nop."<br>";
			$sql_result_nop=mysqli_query($link, $sql_nop) or exit("Sql Error-<br>".$sql_nop."<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result_nop) > 0) 
			{ 
				while($sql_row_nop=mysqli_fetch_array($sql_result_nop)) 
				{ 
				   $nop=$sql_row_nop["avail"]-$sql_row_nop["absent"];
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
				$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$shift."' 
				and  $current_hr between start_time and end_time";
				// echo $sql_hr."<br>";
				$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
				if(mysqli_num_rows($sql_result_hr) >0)
				{
					while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
					{ 
						$start_time=$sql_row_hr['start_time'];
						$end_time=$sql_row_hr['end_time'];
						$diff_time=$current_hr-$start_time;
						if($diff_time>3)
						{
							$diff_time=$diff_time-0.5;
						}
						$hoursa_shift=$hoursa_shift+$diff_time;
					}
				}
				else
				{
					$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$shift."'
					 and $current_hr > end_time";
					// echo $sql_hr."<br>";
					$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
					while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
					{ 
						$start_time=$sql_row_hr['start_time'];
						$end_time=$sql_row_hr['end_time'];
						if($end_time > $start_time)
						{
						$diff_time=$end_time-$start_time;
						}
						else
						{
						$start=24-$start_time;
						$diff_time=$start+$end_time;
						}
						if($diff_time>3)
						{
						$diff_time=$diff_time-0.5;
						}
						$hoursa_shift=$hoursa_shift+$diff_time;
					}
				}		                     
			}
			else
			{
		  //if current date != given date start
				$work_hrs=0;
				$sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift ='".$shift."'";
				// echo $sql_hr."<br>";
				$sql_result_hr=mysqli_query($link, $sql_hr) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 
				if(mysqli_num_rows($sql_result_hr) >0)
				{
					while($sql_row_hr=mysqli_fetch_array($sql_result_hr)) 
					{ 
						$start_time=$sql_row_hr['start_time'];
						$end_time=$sql_row_hr['end_time'];
						if($end_time > $start_time)
						{
							$diff_time=$end_time-$start_time;
						}else
						{
						$start=24-$start_time;
						$diff_time=$start+$end_time;
						}
						if($diff_time>3)
						{
							$diff_time=$diff_time-0.5;
						}
						$hoursa_shift=$hoursa_shift+$diff_time;
					}
				}          
			}
			//if current date != given date end 
            $aaa=$nop*$diff_time;
            $clha_shift=$clha_shift+$aaa;
		}
		//teams based looping end 
		$sqlx="select * from $pro_plan where mod_no=$mod and date=\"$date\""; 
		$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
		{ 
			$couple=$sql_rowx['couple']; 
			$fix_nop=$sql_rowx['fix_nop']; 
		} 
		if(($couple-1)==0) 
		{ 
			$couple=""; 
		} 
		else
		{ 
			$couple=$couple-1; 
		} 
		//NOP 
		$max=0; 
		$sql2="select smv,nop, styles, buyer, days, act_out from $grand_rep where 
		module=$mod and date=\"".$date."\" "; //echo $sql2; 
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			if($sql_row2['act_out']>$max) 
			{ 
			  $max=$sql_row2['act_out']; 
			  $smv=$sql_row2['smv']; //$nop=round($sql_row2['nop'],0); 
			}
			else 
			{ 
				$smv=$sql_row2['smv'];//$nop=round($sql_row2['nop'],0); 
			} 
		} 
		$sqlx="select nop$couple as \"nop\", smv$couple as \"smv\" from $pro_style 
		where style=\"$style_code_new\" and date=\"$date\"";//echo $sqlx."<br/>"; 
		$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
        { //$smv=$sql_rowx['smv']; 
           $style_col=$sql_rowx['nop']; 
        } 
        echo "<td>".$nop_shift."</td>";  
        echo "<td>".$styledb."</td>";  
        echo "<td>".$deldb."</td>"; 
        $gtotal=0; 
        $atotal=0; 
        $psth=0; 
        $sql_sth="select sum(plan_sth) as psth from $bai_pro.grand_rep where date=\"$date\"
         and module=$mod and shift in ($team)"; 
        //echo $sql_sth."<br>"; 
        $sql_result_sth=mysqli_query($link, $sql_sth) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_rowx=mysqli_fetch_array($sql_result_sth)) 
        { 
            $psth_array[]=$sql_rowx["psth"]; 
            $psth=$sql_rowx["psth"]; //echo $psth."<br>"; 
        } 
		//headers based loop for times date
		if($hourly_break==1)
		{ 
			for($i=0; $i<sizeof($hr); $i++) 
			{ 
				$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod  AND TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."')"; 
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($sql_row2=mysqli_fetch_array($sql_result2)) 
				{					
					$sum=$sql_row2['sum']; 
					if($sum==0) 
					{ 
						$sum=0; 
						echo "<td bgcolor=\"red\">0</td>"; 
					}
					else 
					{ 
					   echo "<td bgcolor=\"YELLOW\">".$sum."</td>";
					   $gtotal=$gtotal+$sum; 
					} 
					
				} 
			}
		} 
		//headers based loop for times date end
		//total and hours  start
		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod 
		and  bac_shift in ($team) $time_query";          
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$sum=$sql_row2['sum']; 
			if($sum==0) 
			{ 
				$sum=0; 
				echo "<td bgcolor\"red\">0</td>";
			}
			else 
			{ 
				echo "<td>".$sum."</td>";
			} 
		} 
		$atotal=$sum; 
		$stha=0; 
		$effa=0; 
		$sql2="select sum(bac_Qty) as \"total\",smv, sum((bac_qty*smv)/60) as \"stha\" from $table_name 
		where bac_date=\"$date\" and bac_shift in ($team) and bac_no=$mod $time_query group by bac_no"; 
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$total22=$sql_row2['total']; 
			$smv_sth=$sql_row2['smv']; 
			$stha=$sql_row2['stha']; //$stha=$total22*$smv_sth/60; 
		} 
		$check=0; 
		$total=0;
		$max=0; 
		$sql2="select bac_style, couple,nop,smv, sum(bac_qty) as \"qty\" from $table_name 
		where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style";//echo $sql2; 
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			if($sql_row2['qty']>=$max) 
			{ 
				$couple=$sql_row2['couple']; 
				$style_code_new=$sql_row2['bac_style']; 
				$max=$sql_row2['qty']; 
				$smv=$sql_row2['smv']; //$nop=$sql_row2['nop']; 
			} 
		}
		if($clha_shift>0) 
		{ 
		 $effa=$stha/$clha_shift; 
		} 
		 //total and hours  end       
		/* PLAN EFF, PRO */ 
		$peff_a=0; 
		$ppro_a=0;
		$sql2="select avg(plan_eff) as \"plan_eff\", sum(plan_pro) as \"plan_pro\" from $pro_plan where date=\"$date\" and shift in ($team) and mod_no=$mod";          
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$peff_a=$sql_row2['plan_eff']; 
			$ppro_a=$sql_row2['plan_pro']; 
		} 
		echo "<td>".$hoursa_shift."</td>"; 
		echo "<td>".round($peff_a,2)."%</td>";
		$plan_sah_hr=round(($psth*$hoursa_shift/$work_hours),0); 
		$sah_per=round(($stha*100/$plan_sah_hr),0); 
		$plan_sah_hr_total=$plan_sah_hr_total+$plan_sah_hr; 
		if($sah_per < 90) 
		{ 
			$color_per="#ff0915"; 
		} 
		elseif(90 <= $sah_per && $sah_per < 100) 
		{ 
			$color_per="#fc9625"; 
		} 
		else 
		{ 
			$color_per="#1cfe0a"; 
		}
        $peff_a_total=$peff_a_total+$peff_a; 
        $peff_g_total=$peff_a_total; 
        echo "<td>".round($ppro_a,0)."</td>";
        $ppro_a_total=$ppro_a_total+$ppro_a; 
        $ppro_g_total=$ppro_a_total; 
        echo "<td>".round($clha_shift,0)."</td>"; 
        $clha_total=$clha_total+$clha_shift; 
        $clhg_total=$clha_total; 
        echo "<td>".round($plan_sah_hr)."</td>"; 
        $stha_total=$stha_total+round($stha,2); 
        $sthg_total=$stha_total; 
        $act_eff=round((round(($effa)*100,0)/$peff_a)*100,2); 
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
        echo "<td>".round($stha,0)."</td>";
        echo "<td bgcolor=\"$color\">".round(($effa*100),0)."%</td>";
        $effa_total=$effa_total+round(($effa*100),2); 
        $effg_total=$effa_total; 
        echo "<td>".round(($atotal-$ppro_a),0)."</td>";
        if($hoursa_shift>0) 
		{ 
			$avgperhour=$atotal/$hoursa_shift; 
		}else 
		{ 
			$avgperhour=$atotal; 
		} 
		echo "<td>".round($avgperhour,0)."</td>";
        /* NEW 20100318 */ 
		
		if($current_hr<14)
		{
			$qty=round(($ppro_a-$atotal),0);
			$hoursnw=8-$hoursa;
			//echo $qty."<br>";
			if($hoursnw==0)
			{
				$exp_pcs_hr=round($qty,0);
			}
			else
			{
				$exp_pcs_hr=round($qty,0)/round($hoursnw,0);
			}		
		}
		else
		{
			$qty=round(($ppro_a-$atotal),0);
			//echo $qty."<br>";
			$hoursnw=16-$hoursa;
			$exp_pcs_hr=round($qty,0)/round($hoursnw,0);
			//$exp_pcs_hr=round(($atotal-$ppro_a),0);
			
		}
		// $expect_qty=$expect_qty+$exp_pcs_hr;
		// if($option1==1){	 echo "<td>".round($exp_pcs_hr,0)."</td>"; }
		
		
		
		
        // if((7.5-$hoursa_shift)>0) 
        // { 
			// $exp_pcs_hr=(round($ppro_a,0)-(($avgperhour*$hoursa_shift)))/(7.5-$hoursa_shift); 
        // }
		// else 
        // { 
            // $exp_pcs_hr=round(($atotal-$ppro_a),0); 
        // } 
        echo "<td>".round($exp_pcs_hr,0)."</td>";
        $avgpcstotal=$avgpcstotal+$avgperhour; 
        $hourlytargettotal=$hourlytargettotal+$exp_pcs_hr; 
    }
 
	$total=0; 
	$atotal=0;
    for($i=0; $i<sizeof($hr); $i++) 
	{ 
		$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query 
		and bac_sec=$sec and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."')";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$sum=$sql_row2['sum']; 
			if($sum>0) 
			{ 
				//echo "<td>".$sum."</td>";
				$sum_total[$i]=$sum_total[$i]+$sum;
			}else 
			{ 
				$sum=0; 
				//echo "<td bgcolor=\"red\">0</td>";
				$sum_total[$i]=$sum_total[$i]+$sum;
			}
		} 
	} 
    $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and 
    bac_sec=$sec and  bac_shift in ($team) $time_query"; 
    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row2=mysqli_fetch_array($sql_result2)) 
     { 
        $sum=$sql_row2['sum']; 
         $atotal=$atotal+$sum; 
      } 
      $total=$atotal; 
      /* NEW */ 
      $pclha=0; 
      $pstha=0; 
      $nop=0; 
      $smv=0; 
      //$phours=7.5; 
      $peff_a_total=0; 
      $sql="select module_name as mod_no from $pro_mod where section=$sec"; 
      $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
      while($sql_row=mysqli_fetch_array($sql_result)) 
      { 
          $mod=$sql_row['mod_no']; 
          $sql2="select act_hours from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";          
          $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
          while($sql_row2=mysqli_fetch_array($sql_result2)) 
           { 
              $phours=$sql_row2['act_hours']; 
            }
            //A-Plan 
            $max=0; 
           $sql2="select bac_style, couple,nop,smv, sum(bac_qty) as \"qty\" from $table_name 
           where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style";//echo $sql2;          
           $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row2=mysqli_fetch_array($sql_result2)) 
              { 
                if($sql_row2['qty']>=$max) 
                { 
                    $couple=$sql_row2['couple']; 
                    $style_code_new=$sql_row2['bac_style']; 
                    $max=$sql_row2['qty']; 
                    $smv=$sql_row2['smv']; 
                    $nop=$sql_row2['nop']; 
                    } 
               } 
               $sql2="select plan_pro,act_hours from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";          
               $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
               while($sql_row2=mysqli_fetch_array($sql_result2)) 
                 { 
                   $plan_pro=$sql_row2['plan_pro']; 
                   $phours=$sql_row2['act_hours']; 
                  }
                 $pclha=$pclha+($phours*$nop); 
                 $pstha=$pstha+($plan_pro*$smv)/60;//echo ($phours*$nop)."<br/>"; 
	} 
	/* 20100226 hourly break total*/ 
    //  echo "<td rowspan=4>".$atotal."</td>"; 
    //  echo "<td rowspan=4>".$hoursa_shift."</td>";
    $pstha_sum_total=$pstha_sum_total+$pstha;
    $pclha_sum_total=$pclha_sum_total+$pclha;
    $hoursa_shift_sum_total=$hoursa_shift_sum_total+$hoursa_shift;
    $ppro_a_total_sum_total=$ppro_a_total_sum_total+$ppro_a_total;
    $clha_total_sum_total=$clha_total_sum_total+$clha_total;
    $plan_sah_hr_total_sum_total=$plan_sah_hr_total_sum_total+$plan_sah_hr_total;
	$peffresulta=0;
	if($ppro_a_total>0 && $pclha>0) 
	{ 
		$peffresulta=(round(($pstha/$pclha),2)*100); 
	} 
    //  echo "<td rowspan=4>".$peffresulta."%</td>"; 
    //  echo "<td rowspan=4>".round($ppro_a_total,0)."</td>"; 
    //  echo "<td rowspan=4>".$clha_total."</td>"; 
    $clha_total_new+=$clha_total; //Change 20100819 
    // echo "<td rowspan=4>".round($plan_sah_hr_total,0)."</td>"; 
	$sah_per_fac=round(($stha_total*100/$plan_sah_hr_total),0); 
    if($sah_per_fac < 90) 
	{ 
	 $color_per_fac="#ff0915"; 
	} 
	elseif(90 <= $sah_per_fac && $sah_per_fac < 100) 
	{ 
		$color_per_fac="#fc9625"; 
	} 
	else 
	{ 
		$color_per_fac="#1cfe0a"; 
	} 
	$xa=0; 
	$xb=0; 
	if($clha_total>0) 
	{ 
		$xa=round(($stha_total/$clha_total)*100,2); 
	} 

	if($xa>=70) 
	{ 
		$color_per_fac1="#1cfe0a"; 
	} 
	elseif($xa>=60 and $xa<70) 
	{ 
		$color_per_fac1="YELLOW"; 
	} 
	else 
	{ 
		$color_per_fac1="#ff0915"; 
	} 
	$stha_total_sum_total=$stha_total_sum_total+$stha_total;
	$avgpcstotal_sum_total=$avgpcstotal_sum_total+$avgpcstotal;
	//echo "<td rowspan=4>".round($stha_total,0)."</td>"; 
	$fac_sah_total=$fac_sah_total+$plan_sah_hr_total; 
	$plan_sah_hr_total=0; 
	if((7.5-$hoursa_shift)>0) 
	{ 
	   // echo "<td  rowspan=4>".round($hourlytargettotal,0)."</td>";
	   $req_pcs_per_hour=$req_pcs_per_hour+$hourlytargettotal;
	} 
	else 
	{ 
	   // echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>"; 
	   $req_pcs_per_hour=$req_pcs_per_hour+($atotal-$ppro_a_total);
	} 
        
} 
	// Over All Totals
	$var_val=1;
	$sum_total_final=0;
	$iii=0;
	echo "<tr class=\"total\"><td colspan=5>Total</td>";
	if($hourly_break==1)
	{
		for($ii=0;$ii<sizeof($hr);$ii++) 
		{
			//$iii=$ii;
			// $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and TIME(bac_lastup) BETWEEN ('".$hr_start[$ii]."') and ('".$hr_end[$ii]."')"; 
			// $sql_result2213=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// if(mysqli_num_rows($sql_result2213)>0)
			// {	
				// while($sql_row2=mysqli_fetch_array($sql_result2213)) 
				// {					.
					// echo "<td id='table1Tot".($var_val+$ii)."' style='background-color:#FFFFCC;>".$sql_result2213["sum"]."</td>";				
				// }
			// }
			// else
			// {
				// echo "Test Neasw----".$hr[$ii]."<br>";			
				echo "<td id='table1Tots".($var_val+$ii)."' style='background-color:#FFFFCC;'>0</td>";
				//echo "test---".$hr[$ii]."<br>";
			// }	
			//$var_val++;			
		}
		$var_val=$var_val+sizeof($hr);
	}
	else
	{
		$var_val=1;
	}	
	$sql2="select sum(bac_qty) as sum from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and  bac_shift in ($team)"; 
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($sql_row2=mysqli_fetch_array($sql_result2)) 
	{ 
		$sum_total_final=$sql_row2['sum']; 
	}

	$peffresulta_sum_total=0;
	if($ppro_a_total_sum_total>0 && $pclha_sum_total>0) 
	{ 
		$peffresulta_sum_total=(round(($pstha_sum_total/$pclha_sum_total),2)*100); 
	}

	echo "<td id='table1Tots".($var_val)."' style='background-color:#FFFFCC;'>".$sum_total_final."</td>";
	echo "<td id='table1Tots".($var_val+1)."' style='background-color:#FFFFCC;'>".$hoursa_shift_sum_total."</td>";
	echo "<td id='table1Tots".($var_val+2)."' style='background-color:#FFFFCC;'>".$peffresulta_sum_total."%</td>";
	$plan_eff_avg=$var_val+2;
	echo "<td id='table1Tots".($var_val+3)."' style='background-color:#FFFFCC;'>".$ppro_a_total_sum_total."</td>";
	echo "<td id='table1Tots".($var_val+4)."' style='background-color:#FFFFCC;'>".$clha_total_sum_total."</td>";
	echo "<td id='table1Tots".($var_val+5)."' style='background-color:#FFFFCC;'>".$plan_sah_hr_total_sum_total."</td>";
	echo "<td id='table1Tots".($var_val+6)."' style='background-color:#FFFFCC;'>".$stha_total_sum_total."</td>";
	$xa_sum_total=round(($stha_total_sum_total/$clha_total_sum_total)*100,2);
	echo "<td id='table1Tots".($var_val+7)."' style='background-color:#FFFFCC;'>".round($xa_sum_total,0)."%</td>";
	$act_eff_avg=$var_val+7;
	echo "<td id='table1Tots".($var_val+8)."' style='background-color:#FFFFCC;'>".round(($sum_total_final-$ppro_a_total_sum_total),0)."</td>";
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
				$val31[]="avg";
		}
		else
		{
			$val31[]="sum";
		}	
		$val41[]=1;
		$val51[]="innerHTML";
	}
	/* Ending of sections table  */
	//-----------------------------------------common to show this for all selections total factory start-------------------------------------//
	$total_factory_summery="<div class=\"maincontentof\"><table id=\"info\" class='table table-bordered'><th><h4>Factory Summary</h4></th>";
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
	$total_factory_summery .="<tr class=\"total\"><td colspan=1>Totals</td>";
	$total=0; 
	$atotal=0; 
	if($hourly_break==1)
	{
		for($i=0; $i<sizeof($hr); $i++) 
		{ 
			$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" 
			and bac_sec in ($sections_group)  and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."')"; 
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error 11". $sql2.mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row2=mysqli_fetch_array($sql_result2)) 
			{ 
				$sum=$sql_row2['sum']; 
				if($sum==0) 
				{ 
					$sum=0; 
					$total_factory_summery .="<td bgcolor=\"red\">0</td>"; 
				} 
				else 
				{ 
					$total_factory_summery .="<td>".$sum."</td>"; 
				} 
			} 
		} 
	}
	$sum=0;
	$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" 
	and bac_sec in ($sections_group)  $time_query and bac_shift in ($team)";      
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error 22". $sql2.mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($sql_row2=mysqli_fetch_array($sql_result2)) 
	{ 
		$sum=$sql_row2['sum']; 
		$atotal=$atotal+$sum; 
	} 
	$total=$atotal; 
	/* NEW */ 
	$pclha=0; 
	$pstha=0; 
	$nop=0; 
	$smv=0; 
	//$phours=7.5; 
	$peff_a_total=0; 
	$sql="select module_name as mod_no from $pro_mod where section in ($sections_group)";      
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error 33 ". $sql2.mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($sql_row=mysqli_fetch_array($sql_result)) 
	{ 
		$mod=$sql_row['mod_no']; 
		//A-Plan 
		$sql2="select act_hours from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";          
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$phours=$sql_row2['act_hours']; 
		} 
		$max=0; 
		$sql2="select bac_style, couple,smv,nop, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod $time_query and bac_shift in ($team) group by bac_style"; 
		//echo $sql2;         
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			if($sql_row2['qty']>=$max) 
			{ 
				$couple=$sql_row2['couple']; 
				$style_code_new=$sql_row2['bac_style']; 
				$max=$sql_row2['qty']; 
				$smv=$sql_row2['smv']; 
				$nop=$sql_row2['nop']; 
			} 
		} 
		$sql2="select plan_pro from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team) ";          
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$plan_pro=$sql_row2['plan_pro']; 
		}
		$pclha=$pclha+($phours*$nop); 
		$pstha=$pstha+($plan_pro*$smv)/60; 
	} 

	/* 20100226factory view */ 
	$total_factory_summery .="<td rowspan=4>".$atotal."</td>"; 
	$total_factory_summery .="<td rowspan=4>".$hoursa_shift."</td>"; 

	$peffresulta=0; 

	if($ppro_a_total>0 && $pclha>0) 
	{ 
		$peffresulta=(round(($pstha/$pclha),2)*100); 
	} 

		$total_factory_summery .="<td rowspan=4>".$peffresulta."%</td>"; 
		$total_factory_summery .="<td rowspan=4>".round($ppro_a_total,0)."</td>"; 
		$total_factory_summery .="<td rowspan=4>".$clha_total_new."</td>"; //Change 20100819 
		  
		$sah_per_fac1=round(($stha_total*100/$fac_sah_total),0); 
		if($sah_per_fac1 < 90) 
		{ 
			$color_per_fac1="#ff0915"; 
		} 
		elseif(90 <= $sah_per_fac1 && $sah_per_fac1 < 100) 
		{ 
			$color_per_fac1="#fc9625"; 
		} 
		else 
		{ 
			$color_per_fac1="#1cfe0a"; 
		} 
		
		$total_factory_summery .="<td rowspan=4>".round($fac_sah_total,0)."</td>"; 
		$total_factory_summery .="<td rowspan=4>".round($stha_total,0)."</td>"; 

		$xa=0; 
		$xb=0; 
		if($clha_total>0) 
		{ 
			$xa=round(($stha_total/$clha_total_new)*100,2); //Change 20100819 
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

		//echo "<td rowspan=4 bgcolor=\"$color_per_fac2\">".round($xa,0)."%</td>"; 
		//echo "<td rowspan=4 ><font size=30 color=\"$color_per_fac2\">&#8226;</font><br/>".round($xa,0)."%</td>"; 
		$total_factory_summery .="<td rowspan=4 style='background-color:$color_per_fac2; color:black; font-weight:bold; '>".round($xa,0)."%</td>"; 
		$total_factory_summery .="<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>"; 
		$total_factory_summery .="<td  rowspan=4>".round($avgpcstotal,0)."</td>"; 

		/* 20100318 */ 

		if((7.5-$hoursa_shift)>0) 
		{ 
			$total_factory_summery .="<td  rowspan=4>".round($hourlytargettotal,0)."</td>"; 
		} 
		else 
		{ 
			$total_factory_summery .="<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>"; 
		} 

		/* STH */ 

		$total_factory_summery .="<tr class=\"total\"><td>HOURLY SAH</td>"; 
		if($hourly_break==1)
        {
			for($i=0; $i<sizeof($hr); $i++) 
			{
				$sth=0; 
				$sql2="select sum((bac_qty*smv)/60) as \"sth\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."')";
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2)) 
				{ 
					$sth=$sql_row2['sth']; 
				} 
				$total_factory_summery .="<td>".round($sth,0)."</td>"; 
			} 
        }

		/* EFF */ 
		$total_factory_summery .="<tr class=\"total\"><td>HLY EFF%</td>"; 
		if($hourly_break==1)
		{
			for($i=0; $i<sizeof($hr); $i++) 
			{ 
				$eff=0; 
				$minutes=30;
				$sql2="select sum((bac_qty*smv)/(nop*".$minutes.")*100) as \"eff\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."')"; 
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($sql_row2=mysqli_fetch_array($sql_result2)) 
				{ 
					$eff=$sql_row2['eff']; 
				} 
				/* NEW20100219 */ 
				$sql2="select count(distinct bac_no) as \"noofmodsb\" from $table_name where bac_date=\"$date\" $time_query and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."') and bac_sec in ($sections_group)"; 
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($sql_row2=mysqli_fetch_array($sql_result2)) 
				{ 
					$noofmodsb=$sql_row2['noofmodsb']; 
				} 
				$noofmods=$noofmodsb; 
				/* NEW20100219 */ 
				if($noofmods>0) 
				{ 
					$total_factory_summery .="<td>".round((round($eff,2)/$noofmods),0)."%</td>"; 
				} 
				else 
				{ 
					$total_factory_summery .="<td>0</td>"; 
				} 
			} 
		}
         /* AVG p per hour */ 
        $total_factory_summery .="<tr class=\"total\"><td>AVG-Pcs/HR</td>"; 
		$total=0; 
		$btotal=0; 
		if($hourly_break==1)
		{
			for($i=0; $i<sizeof($hr); $i++) 
			{ 
				$sum=0; 
				$count=0;
				$sql2="select bac_qty from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) $time_query and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."')"; 
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($sql_row2=mysqli_fetch_array($sql_result2)) 
				{ 
					if($sql_row2['bac_qty']>0) 
					$count=$count+1; 
				} 

				$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query 
				and bac_sec in ($sections_group) and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."')"; 
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($sql_row2=mysqli_fetch_array($sql_result2)) 
				{ 
					$sum=$sql_row2['sum']; 
					if($sum==0) 
					{ 
						$sum=0; 
						$total_factory_summery .="<td bgcolor=\"red\">0</td>"; 
					} 
					else 
					{ 
						if($count>0) 
						{ 
							$total_factory_summery .="<td>".round(($sum/$count),0)."</td>"; 
						} 
						else 
						{ 
							$total_factory_summery .="<td>".round(($sum),0)."</td>"; 
						} 
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
	$style_summery.="<tr><th style='background-color:#29759C;'>Style Name</th style='background-color:#29759C;'><th style='background-color:#29759C;'>SMV</th ><th style='background-color:#29759C;'>Oprs</th><th style='background-color:#29759C;'>Mod Count</th>"; 
	for($m=0;$m<sizeof($hr);$m++) 
	{ 
		$style_summery.="<th style='background-color:#29759C;'>".$hr_disp[$m]."</th>"; 
	} 
	$style_summery.="<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Plan Pcs</th><th style='background-color:#29759C;'>Balance Pcs</th><th style='background-color:#29759C;'>Avg. Pcs/Hr</th><th style='background-color:#29759C;'>Hr Tgt.</th><th style='background-color:#29759C;'>Avg. Pcs<br/>Hr/Mod</th><th style='background-color:#29759C;'>Hr Tgt./Mod.</th></tr>"; 
	$avgpcshrsum=0; 
	$planpcsgrand=0; 
	$balancepcs=0; 
	$exp_pcs_hr_total=0; 
	$avgperhour2_sum=0; 
	$exp_pcs_hr2_sum=0; 
	$sql="select bac_style,smv,nop from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and bac_shift in ($team) group by bac_style";      
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($sql_row=mysqli_fetch_array($sql_result)) 
	{ 
		$mod_style=$sql_row['bac_style']; 
		$style_summery.="<tr><td>".$mod_style."</td>"; 
		$style_summery.="<td>".$sql_row['smv']."</td>"; //to show smv based on m3 integration from system. 
		$style_summery.="<td>".$sql_row2['nop']."</td>";			
		$count=0; $total=0;
		$sql2="select group_concat(distinct bac_no) as \"mods\",count(distinct bac_no) as \"count\",sum(bac_qty) as sum from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and bac_style=\"$mod_style\" and bac_shift in ($team)"; 
		//echo $sql2."<br>";
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$count=$sql_row2['count']; 
			$mod_no=$sql_row2['mods']; 
			$total=$sql_row2['sum']; 
			$style_summery.="<td>".$count."</td>"; 
		}
		 
		if($hourly_break==1)
		{
			$total=0;
			for($i=0; $i<sizeof($hr); $i++) 
			{ 
				$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and bac_style=\"$mod_style\" and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."') and bac_sec in ($sections_group) and bac_shift in ($team)"; 
				//echo $sql2."<BR>"; 
				$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
				while($sql_row2=mysqli_fetch_array($sql_result2)) 
				{ 
					$sum=$sql_row2['sum']; 
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
		}
		$style_summery.="<td>".$total."</td>"; 

		$plan_pcs=0; 
		// $sql2="select module_name as mod_no from $pro_mod where section in ($sections_group)"; 
		// $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		// while($sql_row2=mysqli_fetch_array($sql_result2)) 
		// { 
			//$mod_no=$sql_row2['mod_no']; 
			$sql22="select plan_pro from $pro_plan where date=\"$date\" and mod_no in ($mod_no) and shift in ($team)"; 
			$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row22=mysqli_fetch_array($sql_result22)) 
			{ 
				$plan_pcs=$plan_pcs+$sql_row22['plan_pro']; 
			} 
		// } 
		$planpcsgrand=$planpcsgrand+$plan_pcs; 
		$style_summery.="<td>".round($plan_pcs,0)."</td>";
		$balancepcs=$balancepcs+($plan_pcs-$total); 
		$style_summery.="<td>".(round($plan_pcs,0)-$total)."</td>"; 
		$avgperhour=0; 
		$avgperhour2=0; 
		$count2=0; 
		$sql2="select count(distinct bac_no) as \"count\", sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) and bac_style=\"$mod_style\"  and bac_shift in ($team) $time_query"; 
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			if(($hoursa_shift)>0) 
			{ 
				$avgperhour2=round(($sql_row2['sum']/$sql_row2['count']/($hoursa_shift)),0); 
				$avgperhour=round(($sql_row2['sum']/($hoursa_shift)),0); 
				$count2=$sql_row2['count']; 
				$style_summery.="<td>".$avgperhour."</td>"; 
			} 
			else 
			{ 
				$style_summery.="<td>0</td>"; 
			} 
		} 
		$avgpcshrsum=$avgpcshrsum+$avgperhour; 
		$exp_pcs_hr=0; 
		$exp_pcs_hr2=0; 
				
		if($current_hr<14)
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
				$exp_pcs_hr2=round($qty,0)/round($hoursnw,0)/$count2;
			}		
		}
		else
		{
			$qty=round(($plan_pcs-$total),0);
			//echo $qty."<br>";
			$hoursnw=16-$hoursa;
			$exp_pcs_hr=round($qty,0)/round($hoursnw,0);
			$exp_pcs_hr2=round($qty,0)/round($hoursnw,0)/$count2;
			//$exp_pcs_hr=round(($atotal-$ppro_a),0);
			
		}
		
		// if((7.5-$hoursa_shift)>0) 
		// { 
			// $exp_pcs_hr=($plan_pcs-$total)/(7.5-$hoursa_shift); 
			// $exp_pcs_hr2=(($plan_pcs-$total)/(7.5-$hoursa_shift))/$count2; 
		// } 
		// else 
		// { 
			// $exp_pcs_hr=($total-$plan_pcs); 
			// $exp_pcs_hr2=($total-$plan_pcs)/$count2; 
		// } 
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
	$total=0; 
	if($hourly_break==1)
	{
		for($i=0; $i<sizeof($hr); $i++) 
		{ 
			$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and TIME(bac_lastup) BETWEEN ('".$hr_start[$i]."') and ('".$hr_end[$i]."') and bac_sec in ($sections_group) and bac_shift in ($team) $time_query";
			//echo $sql2;           
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row2=mysqli_fetch_array($sql_result2)) 
			{ 
				$sum=$sql_row2['sum']; 
				if($sum==0) 
				{ 
					$sum=0;
					$style_summery.="<td id='table1Tot".($value)."' style='background-color:#FFFFCC;'>0</td>"; 
				} 
				else 
				{ 
					$style_summery.="<td id='table1Tot".($value)."' style='background-color:#FFFFCC;'>".$sum."</td>"; 
				} 
			}
			$value++;
		} 
	}
	else
	{
		$value=1;
	}	
	$sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and bac_sec in ($sections_group) and bac_shift in ($team) $time_query";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($sql_row2=mysqli_fetch_array($sql_result2)) 
	{ 
		$total=$sql_row2['sum'];
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
			echo "col_".(sizeof($hr)+6).": 'none',";
			echo "col_".(sizeof($hr)+7).": 'none',";
			echo "col_".(sizeof($hr)+8).": 'none',";
			echo "col_".(sizeof($hr)+9).": 'none',";
			echo "col_".(sizeof($hr)+10).": 'none',";
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
	<?php for($i=0;$i<sizeof($hr);$i++) 
		{
			echo "col_".($i+4).": 'none',";
		}
		if(sizeof($hr)>0){
			echo "col_".(sizeof($hr)+5).": 'none',";
			echo "col_".(sizeof($hr)+6).": 'none',";
			echo "col_".(sizeof($hr)+7).": 'none',";
			echo "col_".(sizeof($hr)+8).": 'none',";
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