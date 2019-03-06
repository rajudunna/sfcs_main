<title>Hourly Efficiency Report</title>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=edge,chrome=1" /> 
<script language="javascript" type="text/javascript" src="../common/js/datetimepicker_css.js"></script> 
<link rel="stylesheet" href="style.css" type="text/css" media="all" /> 
<link rel="stylesheet" href="../../../common/css/styles/bootstrap.min.css">
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
        <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>     

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
                        $secstyles=$_POST['secstyles']; 
                        $sections_string=$_POST['section']; 
                        $date=$_POST['dat']; 
                        $option1=$_POST['option1']; 
                        $team=$_POST['team']; 
                        $hour_filter=$_POST['hour_filter']; 
                        $total_hours = $plant_end_time - $plant_start_time;
                        // echo $total_hours."<br>";
                        list($hour, $minutes, $seconds) = explode(':', $plant_start_time);
                        $hour_start = $hour + 1;
                        
                        
                    ?> 


                    <form method="POST" class="form-inline" action="<?php $_SERVER['PHP_SELF']; ?>" onsubmit="showHideDiv()"> 
                        <div class="row">
                            <div class="col-md-2">
									<label for="demo1">Select Date: </label>
                                	<input id="demo1" readonly type="text" class="form-control" size="8" name="dat" onclick="NewCssCal('demo1','yyyymmdd')" value=<?php if($date<>"") {echo $date; } else {echo date("Y-m-d");} ?>>     <a href="javascript:NewCssCal('demo1','yyyymmdd')"><img src="../common/images/cal.gif" width="16" height="16" border="0" alt="Pick a date" name="dat"></a> 
                            </div>
                            <div class="col-md-2">
                                <label for="section">Select Unit: </label>
                                <?php
                                    echo "<select name=\"section\" id='section' class=\"form-control\" >"; 
                                    $sql2="select * from $bai_pro3.sections_master order by sec_id"; 
									
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        if($sections_string==$sql_row2['sec_name']) 
                                        { 
                                            echo "<option value=\"".$sql_row2['sec_name']."\" selected>Unit-".$sql_row2['section_display_name']."</option>"; 
											$sections_list[]=$sql_row2['sec_name'];
                                        } 
                                        else 
                                        { 
                                            echo "<option value=\"".$sql_row2['sec_name']."\">Unit-".$sql_row2['section_display_name']."</option>"; 
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
                                <select name="hour_filter[]" id="hour_filter" class="form-control" multiple> 
                                    <?php 
                                         $hour_filter1 = array();
                                         for ($i=0; $i <= $total_hours; $i++)
                                         {
                                             $hour2=$hour;
                                            if($minutes >0)
                                            {
                                                 $to_hour = "'".$hour2.":".$minutes."'";
                                            }
                                            else
                                            {
                                                 $to_hour = "'".$hour2."'";
                                            }
                                            $hour_filter1[]=$to_hour;
                                            $hour++;
                                         }
                                         echo '<option value="'.(implode(',',$hour_filter1)).'">All</option>'; 
                                         list($hour, $minutes, $seconds) = explode(':', $plant_start_time);
                                         for ($i=0; $i <= $total_hours; $i++)
                                         {
                                             $hour1=$hour;
                                             if($minutes >0){
                                                $to_hour = $hour1.":".$minutes;
                                             }
                                             else{
                                                 $to_hour = $hour1;
                                             }
											//  if($hour1 > 12)
											//  {
											// 	$to_hour = $hour1-12;
											//  }
											//  else
											//  {
											// 	$to_hour = $hour1;
											//  }
                                             echo '<option value="\''.$to_hour.'\'">'.$to_hour.'</option>';
                                             // echo '<br/>'.$to_hour;
                                             $hour++;
                 
                                         }
                                     	
                                    ?> 
                                </select>
                            </div> 
                            <div class="col-md-2">
                                <label for="secstyles">Style Break: &nbsp;&nbsp;</label> 
                                <input type="checkbox" class="checkbox" id='secstyles' name="secstyles" value="1" <?php if($secstyles==1) echo "checked"; ?>>
                            </div> 
                            <div class="col-md-2">
                                <label for="option1">Hourly Break: </label> 
                                <input type="checkbox" class="checkbox" name="option1" id="option1" value="1" <?php if($option1==1) echo "checked"; ?>>
                                    <!-- To display/stop/hourly break --> 
                            </div>
                        </div>
                        <div class="row pull-right">
                            <div class="col-md-2">
                                <input type="submit" name="submit" class="btn btn-primary" value="Filter" id="filter"/>  
                                <?php 	
                                    $team_ref=str_replace('"',"*",$team); 
                                    // echo "<form action=\"Hourly_Eff_Print.php?section=$sections_string&secstyles=$secstyles&option1=$option1&dat=$date&team=$team\"><input type=\"submit\" value=\"Print\"></form>"; 
                                    if(strlen($team_ref)>0) 
                                    { 
                                        // echo "<div style=\"float:right;\">"; 
                                        // echo "<a href=\"Hourly_Eff_Print_New.php?section=$sections_string&secstyles=$secstyles&option1=$option1&dat=$date&team=$team_ref\" onclick=\"Popup=window.open('Hourly_Eff_Print_New.php?section=".$sections_string."&secstyles=".$secstyles."&option1=".$option1."&dat=".$date."&team=".$team_ref."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><img border=0 width=100px height=100px src=\"../images/Printer_icon2.png\"></a>"; 
                                        // echo "</div>"; 
                                    }     
                                ?> 
                            </div>
                    </form> 
                    
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
                    </div> 
                </div> 

                <div id="logo"> 
                    <table> 
                        <tr><td><img src="../common/images/BAI_Logo.jpg"></td> 
                        <td valign="bottom"><center><h3>Hourly Efficiency Report (<?php echo $date; ?>)</h3></center></td></tr> 
                    </table> 
                </div> 
				<div class="table-responsive">
                <div id="printable">    
                    <?php 
                        if(isset($_POST['submit'])) 
                        { 
                            /* Function BEGINING */ 
                            function TimeCvt ($time, $format)   
                            { 
                                if (ereg ("[0-9]{1,2}:[0-9]{2}:[0-9]{2}<wbr />", $time))
                                { 
                                    $has_seconds = TRUE; 
                                } 
                                else
                                { 
                                    $has_seconds = FALSE; 
                                } 

                                if ($format == 0)
                                {         //  24 to 12 hr convert 
                                    $time = trim ($time); 
                                    if ($has_seconds == TRUE)   { 
                                        $RetStr = date("g", strtotime($time)); 
                                    } 
                                    else   { 
                                        $RetStr = date("g", strtotime($time)); 
                                    } 
                                } 
                                elseif ($format == 1)   
                                {     // 12 to 24 hr convert 
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
                            
                            //Time filter 
                            $hour_filter=$_POST['hour_filter']; 
                            
                            if($hour_filter=='') 
                            { 
                                   $time_query=""; 
                            } 
                            else 
                            { 
                                   $time_query=" AND HOUR(bac_lastup) in (".implode(",",$hour_filter).") "; 
                            }
                            
                            /* Function END */ 
                            // $sections=array(1,2,3,4,5,6); 
                            $sections_string=$_POST['section']; 
                            $sections=explode(",", $_POST['section']); 
                            $sections_group=$_POST['section']; 
                            $secstyles=$_POST['secstyles']; 
                            $option1=$_POST['option1']; 
                            $date=$_POST['dat']; 
                            $team=$_POST['team'];
							// echo $team."<br>";
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

                            if($current_date==$date)
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
                            //Table namespace 
                            $pro_mod="temp_pool_db.".$username.date("YmdHis")."_"."pro_mod"; 
                            $pro_plan="temp_pool_db.".$username.date("YmdHis")."_"."pro_plan"; 
                            $grand_rep="temp_pool_db.".$username.date("YmdHis")."_"."grand_rep"; 
                            $pro_style="temp_pool_db.".$username.date("YmdHis")."_"."pro_style"; 
                            $table_name="temp_pool_db.".$username.date("YmdHis")."_"."bai_log"; 

                            $sql="create TEMPORARY table ".$pro_mod." ENGINE = MyISAM select * from bai_pro.pro_mod where mod_date='".$date."'"; 
                            $sql_result1=mysqli_query($link, $sql) or exit("Sql Error1z1".mysqli_error($GLOBALS["___mysqli_ston"])); 

                            $sql="create TEMPORARY table ".$pro_plan." ENGINE = MyISAM select * from bai_pro.pro_plan where date='".$date."'"; 
                            $sql_result2=mysqli_query($link, $sql) or exit("Sql Error1z2".mysqli_error($GLOBALS["___mysqli_ston"])); 

                            $sql="create TEMPORARY table ".$grand_rep." ENGINE = MyISAM select * from bai_pro.grand_rep where date='".$date."'"; 
                            $sql_result3=mysqli_query($link, $sql) or exit("Sql Error1z3".mysqli_error($GLOBALS["___mysqli_ston"])); 

                            $sql="create TEMPORARY table ".$pro_style." ENGINE = MyISAM select * from bai_pro.pro_style where date='".$date."'"; 
                            $sql_result4=mysqli_query($link, $sql) or exit("Sql Error1z4".mysqli_error($GLOBALS["___mysqli_ston"])); 

                            $sql="create TEMPORARY table ".$table_name." ENGINE = MyISAM select * from bai_pro.bai_log where bac_date='".$date."'"; 
                            $sql_result5=mysqli_query($link, $sql) or exit("Sql Error1z5".mysqli_error($GLOBALS["___mysqli_ston"])); 

                            //  echo $option1."<br>";
                            if($option1!=1) 
                            { 
                                $h1=array(); 
                                $h2=array(); 
                                $headers=array(); 
                                $i=0; 
                                $j=0;
                                $sql='SELECT DISTINCT(HOUR(bac_lastup)) AS "time" FROM '.$table_name.' WHERE bac_date="'.$date.'" AND bac_shift IN ('.$team.') '.$time_query.' ORDER BY HOUR(bac_lastup)';
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                while($sql_row=mysqli_fetch_array($sql_result)) 
                                { 
                                    $time = $sql_row['time'];
                                    $h1[$i]=$time; 
                                    $h2[$i]=$time; 
                                    $timestr=$time.":0:0"; 
                                    if ($time > 12) {   $time = date("g", strtotime($timestr));   }
                                    $headers[$i]=$time; 
                                    $i=$i+1;
                                }
                                echo "<hr/>";
                                echo "<table id=\"info\">"; 
                                echo "<tr><th style='background-color:#29759C;'>Section</th><th style='background-color:#29759C;'>Head</th>"; 
                                for($i=0;$i<sizeof($headers);$i++) 
                                { 
                                    echo "<th style='background-color:#29759C;'>".$headers[$i]."-".($headers[$i]+1)."</th>";  
                                } 

                                echo "<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Hours</th> 
                                <th style='background-color:#29759C;'>Plan EFF%</th> 
                                <th style='background-color:#29759C;'>Plan Pro.</th> 

                                <th style='background-color:#29759C;'>CLH</th> 
                                <th style='background-color:#29759C;'>SAH</th> 
                                <th style='background-color:#29759C;'>Act SAH</th> 
                                <th style='background-color:#29759C;'>Act. EFF%</th> 
                                <th style='background-color:#29759C;'>Balance Pcs.</th> 
                                <th style='background-color:#29759C;'>Act.Pcs/Hr</th> 
                                <th style='background-color:#29759C;'>Req.Pcs/Hr</th> 
                                </tr>"; 
                                // echo "</table>"; 
                            } 
                     
                            for ($j=0;$j<sizeof($sections);$j++) 
                            { 
                                $sec=$sections[$j]; 
                          
                                $h1=array(); 
                                $h2=array(); 
                                $headers=array(); 
                                $i=0; 

                                $sql="select distinct(Hour(bac_lastup)) as \"time\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) $time_query order by hour(bac_lastup)"; 
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error123".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                while($sql_row=mysqli_fetch_array($sql_result)) 
                                { 
                                    $time = $sql_row['time'];
                                    $h1[$i]=$time; 
                                    $h2[$i]=$time; 
                                    $timestr=$time.":0:0"; 
                                    if ($time > 12) {   $time = date("g", strtotime($timestr));   }
                                    $headers[$i]=$time; 
                                    $i=$i+1;
                                } 
                                /* Headings */ 
                                $sec_head=""; 
                                $sql="select * from $bai_pro.pro_sec_db where sec_no=$sec";                  
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                while($sql_row=mysqli_fetch_array($sql_result)) 
                                { 
                                    $sec_head=$sql_row['sec_head']; 
                                } 
                                $sql="select mod_style, mod_no from $pro_mod where mod_sec=$sec and mod_date=\"$date\" order by mod_no*1";                          
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                if($option1==1)
                                {  
                                    $sql12="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=$sec";
                                    $result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($sql_row12=mysqli_fetch_array($result12))
                                    {
                                        $section_display_name=$sql_row12["section_display_name"];
                                    }
                                    echo "<table id=\"info\">";
                                    echo "<tr><td colspan=4 style='background-color:#29759C; color: white;'> ".$section_display_name."</td></tr>"; 
                                    echo "<tr><th style='background-color:#29759C;'>M#</th><th style='background-color:#29759C;'>NOP</th><th style='background-color:#29759C;'>Style DB</th><th style='background-color:#29759C;'>Del DB</th>";              
                                    for($i=0;$i<sizeof($headers);$i++) 
                                    { 
                                        echo "<th style='background-color:#29759C;'>".$headers[$i]."-".($headers[$i]+1)."</th>";
                                    } 
                                    echo "<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Hours</th> 
                                        <th style='background-color:#29759C;'>Plan EFF%</th> 
                                        <th style='background-color:#29759C;'>Plan Pro.</th> 
                                        <th style='background-color:#29759C;'>CLH</th> 
                                        <th style='background-color:#29759C;'>Plan SAH/Hr</th> 
                                        <th style='background-color:#29759C;'>Act SAH</th> 
                                        <th style='background-color:#29759C;'>Act. EFF%</th> 
                                        <th style='background-color:#29759C;'>Balance Pcs.</th> 
                                        <th style='background-color:#29759C;'>Act. Pcs/Hr</th> 
                                        <th style='background-color:#29759C;'>Req. Pcs/Hr</th> 
                                        </tr>"; 
                                } 

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
                                     
                                    $sql2="select count(distinct bac_style) as \"count\" from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query";
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



                                    if($option1==1){ echo "<tr><td>".$mod."</td>"; } 
                                    $max=0; 
                                    $sql2="select bac_style, couple,smv,nop, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style"; 
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
                                    $current_hr=date('H');
                                    // echo $current_hr."<br>";
                                    for($k=0;$k<sizeof($teams);$k++)
                                    {
                                        $shift=$teams[$k];
                                        
                                        $sql_nop="select (present+jumper) as avail,absent from $bai_pro.pro_attendance where date=\"$date\" and module=\"$mod\" and shift=\"$shift\""; 
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
                                        if($current_date == $date)
                                        {
                                            $sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$shift."' and  $current_hr between start_time and end_time";
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
                                                $sql_hr="select * from $bai_pro.pro_atten_hours where date='$date' and shift='".$shift."' and $current_hr > end_time";
                                                // echo $sql_hr."<br>";
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
                                                    $hoursa_shift=$hoursa_shift+$diff_time;
                                                }
                                            }
                                        }else{
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
                                                    $hoursa_shift=$hoursa_shift+$diff_time;
                                                }
                                            }          
                                        }
                                        // echo $nop."<br>";
                                        // echo $diff_time."ds<br>";

                                        $aaa=$nop*$diff_time;
                                        $clha_shift=$clha_shift+$aaa;
                                    }
                                    //      echo $hoursa_shift."hrs<br>"; 
                                    //  //    $clha_shift=$nop_shift*$hoursa_shift; 
                                    //     echo $clha_shift."cha<br>"; 
                                    //      echo $nop_shift."nop<br>"; 
                                    //NEW 
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
                                    $sql2="select smv,nop, styles, buyer, days, act_out from $grand_rep where module=$mod and date=\"".$date."\" "; 
                                    //echo $sql2; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        if($sql_row2['act_out']>$max) 
                                        { 
                                            $max=$sql_row2['act_out']; 
                                            $smv=$sql_row2['smv']; 
                                            //$nop=round($sql_row2['nop'],0); 
                                        } 
                                        else 
                                        { 
                                            $smv=$sql_row2['smv']; 
                                            //$nop=round($sql_row2['nop'],0); 
                                        } 
                                    } 
                                             
                                    $sqlx="select nop$couple as \"nop\", smv$couple as \"smv\" from $pro_style where style=\"$style_code_new\" and date=\"$date\""; 
                                    //echo $sqlx."<br/>"; 
                                    $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
                                    { 
                                        //$smv=$sql_rowx['smv']; 
                                        $style_col=$sql_rowx['nop']; 
                                    } 
                                    //NEW 
                                    //$style_col=$nop; 

                                    if($option1==1)
                                    {        
                                        //echo "<td>".$style_col."</td>";  
                                        echo "<td>".$nop_shift."</td>";  
                                        echo "<td>".$styledb."</td>";  
                                        echo "<td>".$deldb."</td>"; 
                                    } 
                                    $gtotal=0; 
                                    $atotal=0; 
                                     
                                    $psth=0; 
                                    $sql_sth="select sum(plan_sth) as psth from $bai_pro.grand_rep where date=\"$date\" and module=$mod and shift in ($team)"; 
                                    //echo $sql_sth."<br>"; 
                                    $sql_result_sth=mysqli_query($link, $sql_sth) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_rowx=mysqli_fetch_array($sql_result_sth)) 
                                    { 
                                        $psth_array[]=$sql_rowx["psth"]; 
                                        $psth=$sql_rowx["psth"]; 
                                        //echo $psth."<br>"; 
                                    } 


                                    for($i=0; $i<sizeof($h1); $i++) 
                                    { 
                                        $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query and  Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
                                        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                        { 
                                            $sum=$sql_row2['sum']; 
                                            if($sum==0) 
                                            { 
                                                $sum=0; 
                                            	if($option1==1){    echo "<td bgcolor=\"red\">0</td>"; } 
                                            } 
                                            else 
                                            { 
                                            	if($option1==1){    echo "<td bgcolor=\"YELLOW\">".$sum."</td>"; } 
                                                $gtotal=$gtotal+$sum; 
                                            } 
                                        } 
                                    } 


                                    $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query";          
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $sum=$sql_row2['sum']; 
                                        if($sum==0) 
                                        { 
                                            $sum=0; 
                                        if($option1==1){    echo "<td bgcolor\"red\">0</td>"; } 
                                        } 
                                        else 
                                        { 
                                        if($option1==1){ echo "<td>".$sum."</td>"; } 
                                        } 
                                    } 
                                    $atotal=$sum; 

                                    // SECTION A 

                                    $stha=0; 
                                    //$clha=0; 
                                    $effa=0; 
                                     
                                    $sql2="select sum(bac_Qty) as \"total\",smv, sum((bac_qty*smv)/60) as \"stha\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) and bac_no=$mod $time_query group by bac_no"; 
                                    //echo $sql2; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $total22=$sql_row2['total']; 
                                        $smv_sth=$sql_row2['smv']; 
                                        $stha=$sql_row2['stha']; 
                                        //$stha=$total22*$smv_sth/60; 
                                    } 

                                    $check=0; 
                                    $total=0; 

                                    $max=0; 
                                    $sql2="select bac_style, couple,nop,smv, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style"; 
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
                                            //$nop=$sql_row2['nop']; 
                                        } 
                                    } 
                                    //$clha=$nop*$hoursa; 
                                    if($clha_shift>0) 
                                    { 
                                        $effa=$stha/$clha_shift; 
                                    } 
                                    /* PLAN EFF, PRO */ 

                                    $peff_a=0; 
                                    $ppro_a=0; 

                                    //Change 20110411 

                                    $sql2="select avg(plan_eff) as \"plan_eff\", sum(plan_pro) as \"plan_pro\" from $pro_plan where date=\"$date\" and shift in ($team) and mod_no=$mod";          
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $peff_a=$sql_row2['plan_eff']; 
                                        $ppro_a=$sql_row2['plan_pro']; 
                                    } 
                                    //hourly break
                                    if($option1==1)
                                    { 
                                            echo "<td>".$hoursa_shift."</td>"; 
                                            echo "<td>".round($peff_a,2)."%</td>"; 
                                    } 
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

                                    if($option1==1){        echo "<td>".round($ppro_a,0)."</td>";  } 
                                    $ppro_a_total=$ppro_a_total+$ppro_a; 
                                    $ppro_g_total=$ppro_a_total; 

                                    if($option1==1){        echo "<td>".round($clha_shift,0)."</td>"; } 
                                    $clha_total=$clha_total+$clha_shift; 
                                    $clhg_total=$clha_total; 

                                    if($option1==1){//echo "<td>".round($plan_sah_hr)."-".round($psth)."-".$hoursa."</td>";         
                                        echo "<td>".round($plan_sah_hr)."</td>"; 
                                    } 

                                    $stha_total=$stha_total+round($stha,2); 
                                    $sthg_total=$stha_total; 
                               
                               
                                    $act_eff=round((round(($effa)*100,0)/$peff_a)*100,2); 
                                    $color=""; 
                                    if(round(($effa*100))>=70) 
                                    { 
                                        $color="#1cfe0a"; 
                                    } 
                                    elseif(round(($effa*100))>=60 and round(($effa*100))<70) 
                                    { 
                                        $color="YELLOW"; 
                                    } 
                                    else 
                                    { 
                                        $color="#ff0915"; 
                                    } 
                                 
                                    if($option1==1){echo "<td>".round($stha,0)."</td>";        echo "<td bgcolor=\"$color\">".round(($effa*100),0)."%</td>"; } 
                                    $effa_total=$effa_total+round(($effa*100),2); 
                                    $effg_total=$effa_total; 
                                    if($option1==1){        echo "<td>".round(($atotal-$ppro_a),0)."</td>"; } 
                                    if($hoursa_shift>0) 
                                    { 
                                        $avgperhour=$atotal/$hoursa_shift; 
                                    } 
                                    else 
                                    { 
                                        $avgperhour=$atotal; 
                                    } 

                                    if($option1==1){ echo "<td>".round($avgperhour,0)."</td>"; } 

                                    /* NEW 20100318 */ 
                                    if((7.5-$hoursa_shift)>0) 
                                    { 
                                        $exp_pcs_hr=(round($ppro_a,0)-(($avgperhour*$hoursa_shift)))/(7.5-$hoursa_shift); 
                                    } 
                                    else 
                                    { 
                                        $exp_pcs_hr=round(($atotal-$ppro_a),0); 
                                    } 
                                    if($option1==1){     echo "<td>".round($exp_pcs_hr,0)."</td>"; } 
                                    $avgpcstotal=$avgpcstotal+$avgperhour; 
                                    $hourlytargettotal=$hourlytargettotal+$exp_pcs_hr; 
                                } 

                                if($option1==1)
                                {
                                    echo "<tr class=\"total\"><td colspan=4>Total</td>"; } else { echo "<tr class=\"total\"><td rowspan=4>".$sec."</td><td>Total</td>";  
                                } 

                                $total=0; 
                                $atotal=0;
                                for($i=0; $i<sizeof($h1); $i++) 
                                { 
                                    $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $sum=$sql_row2['sum']; 
                                        if($sum>0) 
                                        { 
                                            echo "<td>".$sum."</td>";
                                        } 
                                        else 
                                        { 
                                            $sum=0; 
                                            echo "<td bgcolor=\"red\">0</td>"; 
                                        }
                                    } 
                                } 
								
                                $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_sec=$sec and  bac_shift in ($team) $time_query"; 
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


                                $sql="select mod_no from $pro_mod where mod_sec=$sec and mod_date=\"$date\""; 
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

                                    $sql2="select bac_style, couple,nop,smv, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod and  bac_shift in ($team) $time_query group by bac_style"; 
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

                                    $sql2="select plan_pro,act_hours from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";          
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $plan_pro=$sql_row2['plan_pro']; 
                                        $phours=$sql_row2['act_hours']; 
                                    } 

                                    $pclha=$pclha+($phours*$nop); 
                                    $pstha=$pstha+($plan_pro*$smv)/60; 
                                    //echo ($phours*$nop)."<br/>"; 
                                } 


                                /* 20100226 hourly break total*/ 
                                echo "<td rowspan=4>".$atotal."</td>"; 
                                echo "<td rowspan=4>".$hoursa_shift."</td>"; 

                                $peffresulta=0; 

                                if($ppro_a_total>0 && $pclha>0) 
                                { 
                                    $peffresulta=(round(($pstha/$pclha),2)*100); 
                                } 
                                echo "<td rowspan=4>".$peffresulta."%</td>"; 
                                echo "<td rowspan=4>".round($ppro_a_total,0)."</td>"; 
                                echo "<td rowspan=4>".$clha_total."</td>"; 
                                $clha_total_new+=$clha_total; //Change 20100819 
                                echo "<td rowspan=4>".round($plan_sah_hr_total,0)."</td>"; 
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

                                echo "<td rowspan=4>".round($stha_total,0)."</td>"; 
                                $fac_sah_total=$fac_sah_total+$plan_sah_hr_total; 
                                $plan_sah_hr_total=0; 

                                //echo "<td rowspan=4 ><font size=30 color=\"$color_per_fac1\">&#8226;</font><br/>".round($xa,0)."%</td>"; 
                                echo "<td rowspan=4 style='background-color:$color_per_fac1; color:black; font-weight:bold;' >".round($xa,0)."%</td>";    
                                echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>"; 
                                echo "<td  rowspan=4>".round($avgpcstotal,0)."</td>"; 

                                /* 20100318 */ 

                                if((7.5-$hoursa_shift)>0) 
                                { 
                                    echo "<td  rowspan=4>".round($hourlytargettotal,0)."</td>"; 
                                } 
                                else 
                                { 
                                    echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>"; 
                                } 


                                /* STH */ 

                                if($option1==1){ echo "<tr class=\"total\"><td colspan=4>HOURLY SAH</td>"; } else {  echo "<tr class=\"total\"><td>HOURLY SAH</td>"; } 
                                for($i=0; $i<sizeof($h1); $i++) 
                                { 
                                    $sth=0; 
                                    $sql2="select sum((bac_qty*smv)/60) as \"sth\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $sth=$sql_row2['sth']; 
                                    } 
                                    echo "<td>".round($sth,0)."</td>"; 
                                } 

                                /* EFF */ 
                                if($option1==1) {  echo "<tr class=\"total\"><td colspan=4>HLY EFF%</td>"; } else { echo "<tr class=\"total\"><td>HLY EFF%</td>";   } 


                                for($i=0; $i<sizeof($h1); $i++) 
                                {
                                    $eff=0; 
                                    /* NEW20100219 */ 
                                    $minutes=60; 
                                    if(($h1[$i]==9 or $h1[$i]==17) and ($sec==1 or $sec==2 or  $sec==3 or $sec==6)) 
                                    { 
                                        $minutes=30; 
                                    } 
                                    else 
                                    { 
                                        $minutes=60; 
                                    } 
                                     
                                    if(($h1[$i]==10 or $h1[$i]==18) and ($sec==4)) 
                                    { 
                                        $minutes=30; 
                                    }              
                             
                                    //echo $h1[$i]."-".$sec."-".$minutes; 
                                    /* NEW20100219 */ 

                                    //IMS    $sql2="select sum(($table_name.bac_qty*pro_style.smv)/(pro_style.nop*".$minutes.")*100) as \"eff\" from $table_name,pro_style where $table_name.bac_date=\"$date\" and pro_style.date=\"$date\" and $table_name.bac_sec=$sec and $table_name.bac_style=pro_style.style and Hour($table_name.bac_lastup) between $h1[$i] and $h2[$i]"; 

                                    $sql2="select sum((bac_qty*smv)/(nop*".$minutes.")*100) as \"eff\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $eff=$sql_row2['eff']; 
                                    } 

                                    /* NEW20100219 */ 
                                    $sql2="select count(distinct bac_no) as \"noofmodsb\" from $table_name where bac_date=\"$date\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec=$sec"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $noofmodsb=$sql_row2['noofmodsb']; 
                                    } 
                                    $noofmods=$noofmodsb; 
                                    /* NEW20100219 */ 

                                    if($noofmods>0) 
                                    { 
                                        echo "<td>".round((round($eff,2)/$noofmods),0)."%</td>"; 
                                    } 
                                    else 
                                    { 
                                        echo "<td>0</td>"; 
                                    } 
                                } 

                                /* AVG p per hour */ 

                                if($option1==1) {  echo "<tr class=\"total\"><td colspan=4>AVG-Pcs/HR</td>"; } else { echo "<tr class=\"total\"><td>AVG-Pcs/HR</td>";  }
                                $total=0; 
                                $btotal=0; 

                                for($i=0; $i<sizeof($h1); $i++) 
                                { 
                                    $sum=0; 
                                    $count=0; 

                                    $sql2="select bac_qty from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        if($sql_row2['bac_qty']>0) 
                                        $count=$count+1; 
                                    } 

                                    $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $sum=$sql_row2['sum']; 
                                        if($sum==0) 
                                        { 
                                            $sum=0; 
                                            echo "<td bgcolor=\"RED\">0</td>"; 
                                        } 
                                        else 
                                        { 
                                            if($count>0) 
                                            { 
                                                echo "<td>".round(($sum/$count),0)."</td>"; 
                                            } 
                                            else 
                                            { 
                                                echo "<td>".round(($sum),0)."</td>"; 
                                            } 
                                        } 
                                    } 
                                } 
                                echo "</tr>"; 
                                /*        echo "</table>"; */ 
                                echo "<br/>"; 
                                if($secstyles==1 && sizeof($sections)==1) 
                                { 
                                    /* Stylewise Report */ 
                                    $sdate=$date; 
                                    /*    echo "<table id=\"info\">"; */ 
                                    echo "<tr style='background-color:#29759C;'><th style='background-color:#29759C;'>Style Code</th><th style='background-color:#29759C;'>SMV</th><th style='background-color:#29759C;'>Oprs</th><th style='background-color:#29759C;'>Mod Count</th>"; 

                                    for($i=0;$i<sizeof($headers);$i++) 
                                    { 
                                        echo "<th style='background-color:#29759C;'>".$headers[$i]."-".($headers[$i]+1)."</th>"; 
                                    } 

                                    echo "<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Plan Pcs</th><th style='background-color:#29759C;'>Balance Pcs</th><th style='background-color:#29759C;'>Avg. Pcs/Hr</th><th style='background-color:#29759C;'>Hr Tgt.</th><th style='background-color:#29759C;'>Avg. Pcs<br/>Hr/Mod</th><th style='background-color:#29759C;'>Hr Tgt./Mod.</th></tr>"; 
                                    $avgpcshrsum=0; 
                                    $planpcsgrand=0; 
                                    $balancepcs=0; 
                                    $exp_pcs_hr_total=0; 
                                    $avgperhour2_sum=0; 
                                    $exp_pcs_hr2_sum=0; 

                                    //$sql="select distinct bac_style,smv,nop from $table_name where bac_date=\"$date\" and bac_sec=$sec and bac_shift in ($team)"; 
                                    $sql="select distinct bac_style,smv from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and bac_shift in ($team)";
									// echo $sql."<br>";
									// echo $sql."<br>";
                                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row=mysqli_fetch_array($sql_result)) 
                                    { 
                                        $mod_style=$sql_row['bac_style']; 
                                        echo "<tr><td>".$mod_style."</td>"; 
                                        $sql2="select nop,smv from $pro_style where style=\"$mod_style\" and date=\"$date\""; 
                                        $smv_show=$nop_show=''; 
                                        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                        { 
                                            $smv_show=$sql_row2['smv']; 
                                            $nop_show=$sql_row2['nop']; 
                                            //echo "<td>".$sql_row2['smv']."</td>"; 
                                            //echo "<td>".$sql_row['smv']."</td>"; //Modified by KiranG 20150814 to show smv based on m3 integration from system. 
                                            //echo "<td>".$sql_row2['nop']."</td>"; 
                                        } 
                                         
                                        //SMV NOP directo from log 
                                            echo "<td>$smv_show</td>"; //to eliminate <td> issue 
                                            echo "<td>$nop_show</td>"; 

                                        //SMV NOP directo from log         
                                         
                                        $count=0; 
                                        $sql2="select count(distinct bac_no) as \"count\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and bac_style=\"$mod_style\" and bac_shift in ($team)";                                  
                                        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                        { 
                                            $count=$sql_row2['count']; 
                                            echo "<td>".$count."</td>"; 
                                        } 
                                        $total=0; 
                                        for($i=0; $i<sizeof($h1); $i++) 
                                        { 
                                            $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and bac_style=\"$mod_style\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec=$sec and bac_shift in ($team)";                            
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
                                                    $total=$total+$sum; 
                                                } 
                                            }
                                        } 
                                        echo "<td>".$total."</td>"; 
                                        $plan_pcs=0; 
                                        $sql2="select mod_no from $pro_mod where mod_sec=$sec and mod_date=\"$date\" and mod_style=\"$mod_style\"";                      
                                        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                        { 
                                            $mod_no=$sql_row2['mod_no']; 
                                            $sql22="select plan_pro from $pro_plan where date=\"$date\" and mod_no=$mod_no and shift in ($team)";                      
                                            $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                            while($sql_row22=mysqli_fetch_array($sql_result22)) 
                                            { 
                                                $plan_pcs=$plan_pcs+$sql_row22['plan_pro']; 
                                            } 
                                        } 

                                        $planpcsgrand=$planpcsgrand+$plan_pcs; 
                                        echo "<td>".round($plan_pcs,0)."</td>";
                                        $balancepcs=$balancepcs+($plan_pcs-$total); 
                                        echo "<td>".(round($plan_pcs,0)-$total)."</td>"; 

                                        $avgperhour=0; 
                                        $avgperhour2=0; 
                                        $count2=0; 
                                        $sql2="select count(distinct bac_no) as \"count\", sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec=$sec and bac_style=\"$mod_style\"  and bac_shift in ($team)"; 
                                        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                        { 
                                            if($hoursa_shift>0) 
                                            { 
                                                ///        $avgperhour=round(($sql_row2['sum']/$sql_row2['count']/($hoursa)),0); 
                                                $avgperhour2=round(($sql_row2['sum']/$sql_row2['count']/($hoursa_shift)),0); 
                                                $avgperhour=round(($sql_row2['sum']/($hoursa_shift)),0); 
                                                $count2=$sql_row2['count']; 
                                                echo "<td>".$avgperhour."</td>"; 
                                            } 
                                            else 
                                            { 
                                                echo "<td>0</td>"; 
                                            } 
                                        } 
                                        $avgpcshrsum=$avgpcshrsum+$avgperhour; 
                                        $exp_pcs_hr=0; 
                                        $exp_pcs_hr2=0; 

                                        if((7.5-$hoursa_shift)>0) 
                                        { 
                                            //        $exp_pcs_hr=(($plan_pcs)-(($avgperhour*$hoursa)*$count))/(7.5-$hoursa); 
                                           $exp_pcs_hr=($plan_pcs-$total)/(7.5-$hoursa_shift); 
                                           $exp_pcs_hr2=(($plan_pcs-$total)/(7.5-$hoursa_shift))/$count2; 
                                        } 
                                        else 
                                        { 
                                            $exp_pcs_hr=($total-$plan_pcs); 
                                            $exp_pcs_hr2=($total-$plan_pcs)/$count2; 
                                        } 

                                        echo "<td>".round($exp_pcs_hr,0)."</td>"; 
                                        $exp_pcs_hr_total=$exp_pcs_hr_total+$exp_pcs_hr; 
                                        echo "<td>".round($avgperhour2,0)."</td>"; 
                                        echo "<td>".round($exp_pcs_hr2,0)."</td>"; 
                                        $avgperhour2_sum=$avgperhour2_sum+$avgperhour2; 
                                        $exp_pcs_hr2_sum=$exp_pcs_hr2_sum+$exp_pcs_hr2; 
                                        echo "</tr>"; 
                                    } 

                                    echo "<tr class=\"total\"><td>Total</td><td></td><td></td><td></td>"; 

                                    $total=0; 

                                    for($i=0; $i<sizeof($h1); $i++) 
                                    { 
                                        $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec=$sec and bac_shift in ($team)";   
                                        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                        { 
                                            $sum=$sql_row2['sum']; 
                                            if($sum==0) 
                                            { 
                                                $sum=0; 
                                                echo "<td bgcolor=\"RED\">0</td>"; 
                                            } 
                                            else 
                                            { 
                                                echo "<td>".$sum."</td>"; 
                                                $total=$total+$sum; 
                                            } 
                                        } 

                                    } 
                                    echo "<td>".$total."</td>"; 
                                    echo "<td>".round($planpcsgrand,0)."</td>"; 
                                    echo "<td>".round($balancepcs,0)."</td>"; 
                                    echo "<td>".$avgpcshrsum."</td>"; 
                                    echo "<td>".round($exp_pcs_hr_total,0)."</td>"; 
                                    echo "<td>".round($avgperhour2_sum,0)."</td>"; 
                                    echo "<td>".round($exp_pcs_hr2_sum)."</td>"; 
                                    echo "<tr>"; 
                                    echo "</table>"; 
                                } 

                            } /* NEW */ 


                            /* NEW 20100321 */ 
                            if($option1!=1 && sizeof($sections)>1) 
                            { 
                                /*new 20100320 */ 
                                /*new 20100320 */       $sec=$sections[$j]; 

                                /*new 20100320 */        // $sec=$_POST['section']; 



                                /* $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));  */ 

                                /* $sec=5; */ 

                                /* $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y"))); */ 

                                /* $date = date("Y-m-d", $sdate); 
                                echo $sdate; */ 

                                /* $h1=array(1,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21); 
                                $h2=array(6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24); */ 
                                $h1=array(); 
                                $h2=array(); 
                                $headers=array(); 
                                $i=0; 

                                $sql="select distinct(Hour(bac_lastup)) as \"time\" from $table_name where bac_date=\"$date\" and bac_shift in ($team) $time_query order by bac_lastup"; 
                                // echo $sql."<br>"; 
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                while($sql_row=mysqli_fetch_array($sql_result)) 
                                { 
                                    $time = $sql_row['time'];
                                    $h1[$i]=$sql_row['time']; 
                                    // echo $sql_row['time']."<br>"; 
                                    $h2[$i]=$sql_row['time']; 
                                    $timestr=$sql_row['time'].":0:0"; 
                                    if ($time > 12) {   $time = date("g", strtotime($timestr));   }
                                    $headers[$i]=$time;
                                    $i=$i+1; 
                                } 
                                $sql="select mod_style, mod_no from $pro_mod where mod_sec in ($sections_group) and mod_date=\"$date\" order by mod_no";      
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

                                    $sql2="select distinct bac_style from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query";                            
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $styledb=$styledb." ".$sql_row2['bac_style']; 
                                    }     

                                    $style_col=""; 
                                    $sql2="select nop from $pro_style where style=\"$style\" and date=\"$date\"";                              
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $style_col=$sql_row2['nop']; 
                                    } 
                                    $gtotal=0; 
                                    $atotal=0; 



                                    for($i=0; $i<sizeof($h1); $i++) 
                                    { 
                                        $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i]";              
                                        $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                        { 
                                            $sum=$sql_row2['sum']; 
                                            if($sum==0) 
                                            { 
                                                $sum=0; 
                                            } 
                                            else 
                                            { 
                                                $gtotal=$gtotal+$sum; 
                                            } 
                                        } 
                                    } 


                                    $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_no=$mod  $time_query and bac_shift in ($team)";
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $sum=$sql_row2['sum']; 
                                        if($sum==0) 
                                        { 
                                            $sum=0; 

                                        } 
                                        else 
                                        { 

                                        } 
                                    } 
                                    $atotal=$sum; 

                                    // SECTION A 
                                    $stha=0; 
                                    $clha=0; 
                                    $effa=0; 
                                
                                    $sql2="select sum(bac_Qty) as \"total\", sum((bac_qty*smv)/60) as \"stha\" from $table_name where bac_date=\"$date\" $time_query and bac_shift in ($team) and bac_no=$mod group by bac_no";                             
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $total22=$sql_row2['total']; 
                                        $stha=$sql_row2['stha']; 
                                    } 

                                    $check=0; 
                                    $total=0; 
                                    $max=0; 
                                    $sql2="select bac_style, couple,smv,nop, sum(bac_qty) as \"qty\" from $table_name where bac_date=\"$date\" and bac_no=$mod $time_query and  bac_shift in ($team) group by bac_style"; 
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
                                    $clha=$nop*$hoursa_shift; 



                                    if($clha>0) 
                                    { 
                                        $effa=$stha/$clha; 
                                    } 

                                    /* PLAN EFF, PRO */ 

                                    $peff_a=0; 
                                    $ppro_a=0; 

                                    $sql2="select plan_eff, plan_pro from $pro_plan where date=\"$date\" and shift in ($team) and mod_no=$mod"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $peff_a=$sql_row2['plan_eff']; 
                                        $ppro_a=$sql_row2['plan_pro']; 
                                    } 
                                    $peff_a_total=$peff_a_total+$peff_a; 
                                    $peff_g_total=$peff_a_total; 
                                    $ppro_a_total=$ppro_a_total+$ppro_a; 
                                    $ppro_g_total=$ppro_a_total; 
                                    $clha_total=$clha_total+$clha; 
                                    $clhg_total=$clha_total; 
                                    $stha_total=$stha_total+round($stha,2); 
                                    $sthg_total=$stha_total; 
                                    $effa_total=$effa_total+round(($effa*100),2); 
                                    $effg_total=$effa_total; 
                               
                                    if($hoursa_shift>0) 
                                    { 
                                        $avgperhour=$atotal/$hoursa_shift; 
                                    } 
                                    else 
                                    { 
                                        $avgperhour=$atotal; 
                                    } 

                                    /* NEW 20100318 */ 
                                    if((7.5-$hoursa_shift)>0) 
                                    { 
                                        $exp_pcs_hr=(round($ppro_a,0)-(($avgperhour*$hoursa_shift)))/(7.5-$hoursa_shift); 
                                    } 
                                    else 
                                    { 
                                        $exp_pcs_hr=round(($atotal-$ppro_a),0); 
                                    } 


                                    $avgpcstotal=$avgpcstotal+$avgperhour; 
                                    $hourlytargettotal=$hourlytargettotal+$exp_pcs_hr; 
                                } 
                                echo "<tr class=\"total\"><td rowspan=4>Factory</td><td>Total</td>"; 

                                $total=0; 
                                $atotal=0; 

                                for($i=0; $i<sizeof($h1); $i++) 
                                { 
                                    $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
                                    //echo $sql2."-".$i."<br>"; 
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
                                            echo "<td>".$sum."</td>"; 
                                        } 
                                    } 
                                } 

                                $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group)  $time_query and bac_shift in ($team)";      
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


                                $sql="select mod_no from $pro_mod where mod_sec in ($sections_group) and mod_date=\"$date\"";      
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
                                    $sql2="select plan_pro from $pro_plan where date=\"$date\" and mod_no=$mod and shift in ($team)";          
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $plan_pro=$sql_row2['plan_pro']; 
                                    } 

                                    $pclha=$pclha+($phours*$nop); 
                                    $pstha=$pstha+($plan_pro*$smv)/60; 
                                } 

                                /* 20100226factory view */ 
                                echo "<td rowspan=4>".$atotal."</td>"; 
                                echo "<td rowspan=4>".$hoursa_shift."</td>"; 

                                $peffresulta=0; 

                                if($ppro_a_total>0 && $pclha>0) 
                                { 
                                    $peffresulta=(round(($pstha/$pclha),2)*100); 
                                } 

                                echo "<td rowspan=4>".$peffresulta."%</td>"; 
                                echo "<td rowspan=4>".round($ppro_a_total,0)."</td>"; 
                                echo "<td rowspan=4>".$clha_total_new."</td>"; //Change 20100819 
                                     
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

                                echo "<td rowspan=4>".round($fac_sah_total,0)."</td>"; 
                                echo "<td rowspan=4>".round($stha_total,0)."</td>"; 

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
                                echo "<td rowspan=4 style='background-color:$color_per_fac2; color:black; font-weight:bold; '>".round($xa,0)."%</td>"; 
                                echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>"; 
                                echo "<td  rowspan=4>".round($avgpcstotal,0)."</td>"; 

                                /* 20100318 */ 

                                if((7.5-$hoursa_shift)>0) 
                                { 
                                    echo "<td  rowspan=4>".round($hourlytargettotal,0)."</td>"; 
                                } 
                                else 
                                { 
                                    echo "<td  rowspan=4>".round(($atotal-$ppro_a_total),0)."</td>"; 
                                } 

                                /* STH */ 

                                echo "<tr class=\"total\"><td>HOURLY SAH</td>"; 
                                for($i=0; $i<sizeof($h1); $i++) 
                                { 

                                    $sth=0; 
                                    $sql2="select sum((bac_qty*smv)/60) as \"sth\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $h1[$i] and $h2[$i]";
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $sth=$sql_row2['sth']; 
                                    } 
                                    echo "<td>".round($sth,0)."</td>"; 
                                } 

                                /* EFF */ 
                                echo "<tr class=\"total\"><td>HLY EFF%</td>"; 
                                for($i=0; $i<sizeof($h1); $i++) 
                                { 
                                    $eff=0; 
                                    /* NEW20100219 */ 
                                    $minutes=60; 
                                    if(($h1[$i]==9 or $h1[$i]==17) and ($sec==1 or $sec==2 or  $sec==5 or $sec==6)) 
                                    { 
                                        $minutes=30; 
                                    } 
                                    else 
                                    { 
                                        $minutes=60; 
                                    } 
                                     
                                    if(($h1[$i]==10 or $h1[$i]==18) and ($sec==3 or $sec==4)) 
                                    { 
                                        $minutes=30; 
                                    } 
                                    //echo $minutes; 
                                    /* NEW20100219 */ 

                                    //IMS    $sql2="select sum(($table_name.bac_qty*pro_style.smv)/(pro_style.nop*".$minutes.")*100) as \"eff\" from $table_name,pro_style where $table_name.bac_date=\"$date\" and pro_style.date=\"$date\" and $table_name.bac_sec in ($sections_group) and $table_name.bac_style=pro_style.style and Hour($table_name.bac_lastup) between $h1[$i] and $h2[$i]";

                                    $sql2="select sum((bac_qty*smv)/(nop*".$minutes.")*100) as \"eff\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $eff=$sql_row2['eff']; 
                                    } 

                                    /* NEW20100219 */ 
                                    $sql2="select count(distinct bac_no) as \"noofmodsb\" from $table_name where bac_date=\"$date\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec in ($sections_group)"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $noofmodsb=$sql_row2['noofmodsb']; 
                                    } 

                                    $noofmods=$noofmodsb; 
                                    /* NEW20100219 */ 

                                    if($noofmods>0) 
                                    { 
                                        echo "<td>".round((round($eff,2)/$noofmods),0)."%</td>"; 
                                    } 
                                    else 
                                    { 
                                        echo "<td>0</td>"; 
                                    } 
                                } 

                                /* AVG p per hour */ 

                                echo "<tr class=\"total\"><td>AVG-Pcs/HR</td>"; 

                                $total=0; 
                                $btotal=0; 

                                for($i=0; $i<sizeof($h1); $i++) 
                                { 
                                    $sum=0; 
                                    $count=0; 

                                    $sql2="select bac_qty from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        if($sql_row2['bac_qty']>0) 
                                        $count=$count+1; 
                                    } 

                                    $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $h1[$i] and $h2[$i]"; 
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
                                            if($count>0) 
                                            { 
                                                echo "<td>".round(($sum/$count),0)."</td>"; 
                                            } 
                                            else 
                                            { 
                                                echo "<td>".round(($sum),0)."</td>"; 
                                            } 
                                        } 
                                    } 
                                } 
                                echo "</tr>"; 
                                /*        echo "</table>"; */ 
                                echo "<br/>"; 
                            } /* NEW */ 
                            /* NEW 20100321 */ 

                            /* Factroy */ 

                            if(sizeof($sections)>1 && $secstyles==1) 
                            { 

                                /* Stylewise Report */ 
                                $sdate=$date;
                                $style_summ_head=""; 
                                $sql="select * from $bai_pro.unit_db where unit_members=\"$sections\""; 
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                while($sql_row=mysqli_fetch_array($sql_result)) 
                                { 
                                    $style_summ_head=$sql_row['unit_id']; 
                                } 
                                echo "<table id=\"info\">"; 
                                echo "<tr><td>Style Summary ".$style_summ_head."</td></tr>"; 
                                echo "<tr><th>Style Code</th><th>SMV</th><th>Oprs</th><th>Mod Count</th>"; 

                                for($m=0;$m<sizeof($headers);$m++) 
                                { 
                                    echo "<th>".$headers[$m]."-".($headers[$m]+1)."</th>"; 
                                } 

                                echo "<th>Total</th><th>Plan Pcs</th><th>Balance Pcs</th><th>Avg. Pcs/Hr</th><th>Hr Tgt.</th><th>Avg. Pcs<br/>Hr/Mod</th><th>Hr Tgt./Mod.</th></tr>"; 
                                $avgpcshrsum=0; 
                                $planpcsgrand=0; 
                                $balancepcs=0; 
                                $exp_pcs_hr_total=0; 
                                $avgperhour2_sum=0; 
                                $exp_pcs_hr2_sum=0; 

                                //$sql="select distinct bac_style,smv,nop from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) and bac_shift in ($team)"; 
                                $sql="select distinct bac_style,smv from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and bac_shift in ($team)";      
								// echo $sql."<br>";								
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                while($sql_row=mysqli_fetch_array($sql_result)) 
                                { 
                                    $mod_style=$sql_row['bac_style']; 
                                    echo "<tr><td>".$mod_style."</td>"; 
                                    $sql2="select nop,smv from $pro_style where style=\"$mod_style\" and date=\"$date\"";                              
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
									if(mysqli_num_rows($sql_result2)>0)
									{
										while($sql_row2=mysqli_fetch_array($sql_result2)) 
										{ 
											//echo "<td>".$sql_row2['smv']."</td>"; 
											echo "<td>".$sql_row['smv']."</td>"; //Modified by KiranG 20150814 to show smv based on m3 integration from system. 
											echo "<td>".$sql_row2['nop']."</td>"; 
										} 
									}
									else
									{
										
										$sql2="select smv,nop from $table_name where bac_date=\"$date\" and bac_style=\"$mod_style\" limit 1"; 
										//echo $sql2;         
										$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
										if(mysqli_num_rows($sql_result2)>0)
										{
											while($sql_row2=mysqli_fetch_array($sql_result2)) 
											{ 
												echo "<td>".$sql_row['smv']."</td>"; //Modified by KiranG 20150814 to show smv based on m3 integration from system. 
												echo "<td>".$sql_row2['nop']."</td>"; 
											} 
										}
										else
										{										
											echo "<td>0</td>"; 
											echo "<td>0</td>"; 
										}
									}
                                     
                                    //SMV and NOP from direct table 
                                        //echo "<td>".$sql_row['smv']."</td>"; 
                                        //echo "<td>".$sql_row['nop']."</td>"; 
                                     
                                    //SMV and NOP from direct table 
                                     
                                    $count=0; 
                                    $sql2="select count(distinct bac_no) as \"count\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and bac_style=\"$mod_style\" and bac_shift in ($team)";                              
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $count=$sql_row2['count']; 
                                        echo "<td>".$count."</td>"; 
                                    } 

                                    $total=0; 

                                    for($i=0; $i<sizeof($h1); $i++) 
                                    { 
                                        $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and bac_style=\"$mod_style\" $time_query and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec in ($sections_group) and bac_shift in ($team)"; 
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
                                                $total=$total+$sum; 
                                            } 
                                        }
                                    } 
                                    echo "<td>".$total."</td>"; 

                                    $plan_pcs=0; 
                                    $sql2="select mod_no from $pro_mod where mod_sec in ($sections_group) and mod_date=\"$date\" and mod_style=\"$mod_style\""; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        $mod_no=$sql_row2['mod_no']; 
                                        $sql22="select plan_pro from $pro_plan where date=\"$date\" and mod_no=$mod_no and shift in ($team)"; 
                                        $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                        while($sql_row22=mysqli_fetch_array($sql_result22)) 
                                        { 
                                            $plan_pcs=$plan_pcs+$sql_row22['plan_pro']; 
                                        } 
                                    } 
                                    $planpcsgrand=$planpcsgrand+$plan_pcs; 
                                    echo "<td>".round($plan_pcs,0)."</td>";
                                    $balancepcs=$balancepcs+($plan_pcs-$total); 
                                    echo "<td>".(round($plan_pcs,0)-$total)."</td>"; 

                                    $avgperhour=0; 
                                    $avgperhour2=0; 
                                    $count2=0; 
                                    $sql2="select count(distinct bac_no) as \"count\", sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) and bac_style=\"$mod_style\"  and bac_shift in ($team) $time_query"; 
                                    $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($sql_row2=mysqli_fetch_array($sql_result2)) 
                                    { 
                                        if(($hoursa_shift)>0) 
                                        { 
                                            ///        $avgperhour=round(($sql_row2['sum']/$sql_row2['count']/($hoursa)),0); 
                                            $avgperhour2=round(($sql_row2['sum']/$sql_row2['count']/($hoursa_shift)),0); 
                                            $avgperhour=round(($sql_row2['sum']/($hoursa_shift)),0); 
                                            $count2=$sql_row2['count']; 
                                            echo "<td>".$avgperhour."</td>"; 
                                        } 
                                        else 
                                        { 
                                            echo "<td>0</td>"; 
                                        } 
                                    } 
                                    $avgpcshrsum=$avgpcshrsum+$avgperhour; 
                                    $exp_pcs_hr=0; 
                                    $exp_pcs_hr2=0; 

                                    if((7.5-$hoursa_shift)>0) 
                                    { 
                                        //        $exp_pcs_hr=(($plan_pcs)-(($avgperhour*$hoursa)*$count))/(7.5-$hoursa); 
                                        $exp_pcs_hr=($plan_pcs-$total)/(7.5-$hoursa_shift); 
                                        $exp_pcs_hr2=(($plan_pcs-$total)/(7.5-$hoursa_shift))/$count2; 
                                    } 
                                    else 
                                    { 
                                        $exp_pcs_hr=($total-$plan_pcs); 
                                        $exp_pcs_hr2=($total-$plan_pcs)/$count2; 
                                    } 
                                    echo "<td>".round($exp_pcs_hr,0)."</td>"; 
                                    $exp_pcs_hr_total=$exp_pcs_hr_total+$exp_pcs_hr; 
                                    echo "<td>".round($avgperhour2,0)."</td>"; 
                                    echo "<td>".round($exp_pcs_hr2,0)."</td>"; 
                                    $avgperhour2_sum=$avgperhour2_sum+$avgperhour2; 
                                    $exp_pcs_hr2_sum=$exp_pcs_hr2_sum+$exp_pcs_hr2; 
                                    echo "</tr>"; 
                                } 

                                echo "<tr class=\"total\"><td>Total</td><td></td><td></td><td></td>"; 
                                $total=0; 

                                for($i=0; $i<sizeof($h1); $i++) 
                                { 
                                    $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$sdate\" and Hour(bac_lastup) between $h1[$i] and $h2[$i] and bac_sec in ($sections_group) and bac_shift in ($team) $time_query";              
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
                                            echo "<td>".$sum."</td>"; 
                                            $total=$total+$sum; 
                                        } 
                                    } 
                                } 
                                echo "<td>".$total."</td>"; 
                                echo "<td>".round($planpcsgrand,0)."</td>"; 
                                echo "<td>".round($balancepcs,0)."</td>"; 
                                echo "<td>".$avgpcshrsum."</td>"; 
                                echo "<td>".round($exp_pcs_hr_total,0)."</td>"; 
                                echo "<td>".round($avgperhour2_sum,0)."</td>"; 
                                echo "<td>".round($exp_pcs_hr2_sum)."</td>"; 
                                echo "<tr>"; 
                                echo "</table>"; 
                            } 
                        }    
                    ?> 
					</div>
                </div>
            </div>
			
            </div>
        </div>
    </body> 
<?php  ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?> 