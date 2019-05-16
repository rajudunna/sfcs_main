<title>Hourly Efficiency Report</title>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=edge,chrome=1" /> 
<link rel="stylesheet" href="style.css" type="text/css" media="all" /> 
<link rel="stylesheet" href="../../../common/css/styles/bootstrap.min.css">
<script language="javascript" type="text/javascript" src="../../../common/js/TableFilter_EN/tablefilter.js"></script>
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


table#TABLE2 td
{
	border: 1px solid black;
	text-align: right;
    white-space:nowrap; 
}

table#TABLE2 th
{
	border: 1px solid black;
	text-align: center;
    background-color: BLUE;
	color: WHITE;
    white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}


table#TABLE2 tr.total
{
	border: 1px solid black;
    background-color: GREEN;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#TABLE2 td.head
{
	border: 1px solid black;
    background-color: GREEN;
	color: WHITE;
	text-align: right;
    white-space:nowrap; 
}

table#TABLE2 tr.total_grand
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
                        $hour_filter=$_POST['hour_filter']; 
                        $date=$_POST['dat']; 
                        $option1=$_POST['option1']; 
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
    $hour_filter=$_POST['hour_filter'];//slected hour  
    $style_break=($_POST['secstyles']==1) ? $_POST['secstyles'] : 0 ; //style break
    $hourly_break=($_POST['option1']==1) ? $_POST['option1'] : 0;//hourly Break 
    //echo "<br>date".$date." - section -".$sections_string." - team - ".$team." - hour ".$hour_filter." - style break".$secstyles." -hourly Break ".$option1;                          
    if($hour_filter=='All') 
    { 
          $time_query=""; 
    } 
    else 
    {      
     $hour_filter_array=explode("$", $_POST['hour_filter']);
     //$time_query=" AND HOUR(bac_lastup) in ('".$hour_filter."') "; 
     $time_query=" AND TIME(bac_lastup) BETWEEN ('".$hour_filter_array[0]."') and ('".$hour_filter_array[1]."')"; 
    }
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
//creation of temp tables start 
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
//creation of temp tables end


//$style_break  $hourly_break  





























//-----------------------------------------common to show this for all selections total factory start-------------------------------------//
$total_factory_summery="<table id=\"info\"><th><h4>Factory Summary</h4></th>";
for($i=0;$i<sizeof($headers);$i++) 
{ 
    $total_factory_summery .="<th style='background-color:#29759C;'>".$headers[$i]."-".($headers[$i]+1)."</th>";  
}
  $total_factory_summery .="<th style='background-color:#29759C;'>Total</th><th style='background-color:#29759C;'>Avg Hours</th> 
         <th style='background-color:#29759C;'>Avg Plan EFF%</th> 
         <th style='background-color:#29759C;'>Plan Pro.</th> 

         <th style='background-color:#29759C;'>CLH</th> 
         <th style='background-color:#29759C;'>Plan SAH/Hr</th> 
         <th style='background-color:#29759C;'>Act SAH</th> 
         <th style='background-color:#29759C;'>Act. EFF%</th> 
         <th style='background-color:#29759C;'>Avg Balance Pcs.</th> 
         <th style='background-color:#29759C;'>Act.Pcs/Hr</th> 
         <th style='background-color:#29759C;'>Req.Pcs/Hr</th>"; 
     $total_factory_summery .="<tr class=\"total\"><td colspan=1>Totals</td>";
         $total=0; 
         $atotal=0; 

         for($i=0; $i<sizeof($headers); $i++) 
         { 
             $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query 
             and bac_sec in ($sections_group)  and Hour(bac_lastup) between $headers[$i] and $headers[$i]"; 
             //echo $sql2."-".$i."<br>"; 
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
        $sql="select mod_no from $pro_mod where mod_sec in ($sections_group) and mod_date=\"$date\"";      
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
         for($i=0; $i<sizeof($headers); $i++) 
         { 

             $sth=0; 
             $sql2="select sum((bac_qty*smv)/60) as \"sth\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $headers[$i] and $headers[$i]";
             $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
             while($sql_row2=mysqli_fetch_array($sql_result2)) 
             { 
                 $sth=$sql_row2['sth']; 
             } 
             $total_factory_summery .="<td>".round($sth,0)."</td>"; 
         } 

         /* EFF */ 
         $total_factory_summery .="<tr class=\"total\"><td>HLY EFF%</td>"; 
         for($i=0; $i<sizeof($headers); $i++) 
         { 
             $eff=0; 
             /* NEW20100219 */ 
             $minutes=60; 
             if(($headers[$i]==9 or $headers[$i]==17) and ($sec==1 or $sec==2 or  $sec==5 or $sec==6)) 
             { 
                 $minutes=30; 
             } 
             else 
             { 
                 $minutes=60; 
             } 
              
             if(($headers[$i]==10 or $headers[$i]==18) and ($sec==3 or $sec==4)) 
             { 
                 $minutes=30; 
             } 
             //echo $minutes; 
             /* NEW20100219 */ 

             //IMS    $sql2="select sum(($table_name.bac_qty*pro_style.smv)/(pro_style.nop*".$minutes.")*100) as \"eff\" from $table_name,pro_style where $table_name.bac_date=\"$date\" and pro_style.date=\"$date\" and $table_name.bac_sec in ($sections_group) and $table_name.bac_style=pro_style.style and Hour($table_name.bac_lastup) between $headers[$i] and $headers[$i]";

             $sql2="select sum((bac_qty*smv)/(nop*".$minutes.")*100) as \"eff\" from $table_name where bac_date=\"$date\" $time_query and bac_sec in ($sections_group) and Hour(bac_lastup) between $headers[$i] and $headers[$i]"; 
             $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
             while($sql_row2=mysqli_fetch_array($sql_result2)) 
             { 
                 $eff=$sql_row2['eff']; 
             } 

             /* NEW20100219 */ 
             $sql2="select count(distinct bac_no) as \"noofmodsb\" from $table_name where bac_date=\"$date\" $time_query and Hour(bac_lastup) between $headers[$i] and $headers[$i] and bac_sec in ($sections_group)"; 
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

         /* AVG p per hour */ 

         $total_factory_summery .="<tr class=\"total\"><td>AVG-Pcs/HR</td>"; 

         $total=0; 
         $btotal=0; 

         for($i=0; $i<sizeof($headers); $i++) 
         { 
             $sum=0; 
             $count=0; 

             $sql2="select bac_qty from $table_name where bac_date=\"$date\" and bac_sec in ($sections_group) $time_query and Hour(bac_lastup) between $headers[$i] and $headers[$i]"; 
             $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
             while($sql_row2=mysqli_fetch_array($sql_result2)) 
             { 
                 if($sql_row2['bac_qty']>0) 
                 $count=$count+1; 
             } 

             $sql2="select sum(bac_qty) as \"sum\" from $table_name where bac_date=\"$date\" $time_query 
             and bac_sec in ($sections_group) and Hour(bac_lastup) between $headers[$i] and $headers[$i]"; 
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
$total_factory_summery .="</tr>"; 
$total_factory_summery .="</table>";
  echo  $total_factory_summery;
//-----------------------------------------common to show this for all selections total factory end-------------------------------------//

//-----------------------------------------style summery Report while he selects Style Break-------------------------------------//








//-----------------------------------------style summery Report while he selects Style Break-------------------------------------//

















}