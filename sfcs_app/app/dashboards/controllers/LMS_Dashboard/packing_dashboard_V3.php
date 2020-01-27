<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $view_access=user_acl("SFCS_0245",$username,1,$group_id_sfcs);
    
    $popup_report_v3=getFullURL($_GET['r'],'popup_report_v3.php','N');
    $pop_pending_list_v3=getFullURL($_GET['r'],'pop_pending_list_v3.php','N');
    
    $image1 = getFullURLLevel($_GET['r'],'common/images/LMS.jpg',2,'R');
    set_time_limit(200000);
?> 
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.corner.js',4,'R') ?>"></script>

<style> 
    body 
    { 
        background-color:#eeeeee; 
        color: #000000; 
        font-family: Trebuchet MS; 
    } 
    a {text-decoration: none;} 

    table 
    { 
        border-collapse:collapse; 
    } 
    .new td 
    { 
        border: 1px solid red; 
        white-space:nowrap; 
        border-collapse:collapse; 
    } 

    .new th 
    { 
        border: 1px solid red; 
        white-space:nowrap; 
        border-collapse:collapse; 
    } 

    .bottom th,td 
    { 
        border-bottom: 1px solid #000000;  
        padding-bottom: 5px; 
        padding-top: 5px; 
    } 


    .fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: #000000; font-family: Arial; font-size:12px; }  

    .fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;} 

    .fontnn a { color: #000000; font-family: Arial; font-size:12px; }  



    a{ 
        text-decoration:none; 
        color: #000000; 
    } 

    #white { 
    width:20px; 
    height:20px; 
    background-color: #ffffff; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #white a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #white a:hover { 
    text-decoration:none; 
    background-color: #ffffff; 
    } 


    #red { 
    width:20px; 
    height:20px; 
    background-color: #ff0000; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #red a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #red a:hover { 
    text-decoration:none; 
    background-color: #ff0000; 
    } 

    #green { 
    width:20px; 
    height:20px; 
    background-color: #00ff00; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #green a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #green a:hover { 
    text-decoration:none; 
    background-color: #00ff00; 
    } 

    #yellow { 
    width:20px; 
    height:20px; 
    background-color: #ffff00; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #yellow a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #yellow a:hover { 
    text-decoration:none; 
    background-color: #ffff00; 
    } 


    #pink { 
    width:20px; 
    height:20px; 
    background-color: #ff00ff; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #pink a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #pink a:hover { 
    text-decoration:none; 
    background-color: #ff00ff; 
    } 

    #orange { 
    width:20px; 
    height:20px; 
    background-color: #991144; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #orange a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #orange a:hover { 
    text-decoration:none; 
    background-color: #991144; 
    } 

    #blue { 
    width:20px; 
    height:20px; 
    background-color: #15a5f2; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #blue a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #blue a:hover { 
    text-decoration:none; 
    background-color: #15a5f2; 
    } 


    #yash { 
    width:20px; 
    height:20px; 
    background-color: #999999; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #yash a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #yash a:hover { 
    text-decoration:none; 
    background-color: #999999; 
    } 

    #black { 
    width:20px; 
    height:20px; 
    background-color: black; 
    display:block; 
    float: left; 
    margin: 2px; 
    border: 1px solid #000000; 
    } 

    #black a { 
    display:block; 
    float: left; 
    width:100%; 
    height:100%; 
    text-decoration:none; 
    } 

    #black a:hover { 
    text-decoration:none; 
    background-color: black; 
    } 
</style> 

<SCRIPT> 
<!-- 
function doBlink() { 
    var blink = document.all.tags("BLINK") 
    for (var i=0; i<blink.length; i++) 
        blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : ""  
} 

function startBlink() { 
    if (document.all) 
        setInterval("doBlink()",1000) 
} 
window.onload = startBlink; 

</SCRIPT> 



<?php //include("../menu_content.php"); ?> 

<script language="JavaScript"> 
<!-- 

//Disable right mouse click Script 
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive 
//For full source code, visit http://www.dynamicdrive.com 

//var message="Function Disabled!"; 

/////////////////////////////////// 
// function clickIE4(){ 
// if (event.button==2){ 
// alert(message); 
// return false; 
// } 
// } 

// function clickNS4(e){ 
// if (document.layers||document.getElementById&&!document.all){ 
// if (e.which==2||e.which==3){ 
// alert(message); 
// return false; 
// } 
// } 
// } 

// if (document.layers){ 
// document.captureEvents(Event.MOUSEDOWN); 
// document.onmousedown=clickNS4; 
// } 
// else if (document.all&&!document.getElementById){ 
// document.onmousedown=clickIE4; 
// } 

// document.oncontextmenu=new Function("alert(message);return false") 

// -->  
</script> 

<?php 
//if(mysql_num_rows($result_list) > 0) 
{ 
//Embellishment Schedules 
$emb_schedules=array(); //Emb Schedules - Garment Form 
$sql="select order_del_no from $bai_pro3.bai_orders_db where order_embl_e=1 or order_embl_f=1"; 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $emb_schedules[]=$sql_row['order_del_no']; 
} 
//EMB 


///NEW ADD 2011-07-14 
//TEMP Table 
echo "<div class='panel panel-primary'><div class='panel-heading'>Cartons Work in Progress Dashboard (LMS)<span class='pull-right' style='color:white;'><a href='$pop_pending_list_v3' onclick=\"return popitup("."'$pop_pending_list_v3'".")\">Carton Issues</a></b>&nbsp;&nbsp;<b><a href='$image1' onclick=\"return popitup("."'$image1'".")\">?</a></span></div>
    <div class='panel-body'>";

            $sqlx="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name GROUP BY section ORDER BY section + 0"; 
            $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
            { 
                $section=$sql_rowx['sec_id']; 
                $section_head=$sql_rowx['sec_head']; 
                $section_mods=$sql_rowx['sec_mods'];
                $section_display_name=$sql_rowx['section_display_name'];

           

                echo '<div style="width:270px; background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">'; 
                echo "<p>"; 
                echo "<table>"; 
                echo "<tr><th colspan=2><a href='$popup_report_v3&section_no=$section' onclick=\"return popitup("."'$popup_report_v3&section_no=$section'".")\"><h2>$section_display_name</h2></a></th></tr>"; 

                $mods=array(); 
                $mods=explode(",",$section_mods); 

                for($x=0;$x<sizeof($mods);$x++) 
                { 
                    
                    $module=$mods[$x]; 
                    
                    //if(in_array($module,$module_list_array)) 
                    { 
                    
                    echo "<tr class=\"bottom\">"; 
                    echo "<td class=\"bottom\"><strong><font class=\"fontnn\" color=black >$module</font></strong></td><td>"; 
                    
                    $sql1="SELECT *,HOUR(TIMEDIFF(ims_log_date,\"".date("Y-m-d H:i:s")."\")) as \"diff\" from $bai_pro3.packing_dashboard_temp where ims_mod_no=$module order by lastup"; 
                    $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    $sql_num_check=mysqli_num_rows($sql_result1); 
                    while($sql_row1=mysqli_fetch_array($sql_result1)) 
                    { 
                        $carton_qty=$sql_row1['carton_act_qty']; 
                        $carton_mode=$sql_row1['carton_mode']; 
                        $out_qty=$sql_row1['ims_pro_qty']; 
                        $carton_no=$sql_row1['carton_no'];  
                        $lastup=$sql_row1['lastup']; 
                        $style=substr($sql_row1['ims_style'],0,1); 
                        $diff=$sql_row1['diff']; 
                        $ims_doc_no=$sql_row1['doc_no']; 
                        $ims_size=$sql_row1['size_code']; 
                        $ims_tid_qty=$sql_row1['carton_act_qty']; 
                        $carton_id_ref=$sql_row1['tid']; 
                        $add_css=""; 
                        
                        $sqla="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0"; 
                        $sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        while($sql_rowa=mysqli_fetch_array($sql_resulta)) 
                        { 
                            $output_qty=$sql_rowa["qty"];     
                        } 
                        
                        $sqla1="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log_backup where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0"; 
                        //echo $sqla1; 
                        $sql_resulta1=mysqli_query($link, $sqla1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        while($sql_rowa1=mysqli_fetch_array($sql_resulta1)) 
                        { 
                            $output_qty1=$sql_rowa1["qty"];     
                        } 
                        
                        $sqlb="select sum(carton_act_qty) as qty from $bai_pro3.pac_stat_log where doc_no=$ims_doc_no and size_code=\"".$ims_size."\" and status=\"DONE\""; 
                        $sql_resultb=mysqli_query($link, $sqlb) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        while($sql_rowb=mysqli_fetch_array($sql_resultb)) 
                        { 
                            $packing_qty=$sql_rowb["qty"];     
                        } 
                        
                        $text_ref=""; 
                        $id="blue"; 
                        $hour_1=0; 
                        $hour_2=0; 
                        $carton_status=0; 
                        
                        $sql42="SELECT * FROM $bai_pro3.aql_track_log WHERE carton_id=$carton_id_ref AND log_time=(SELECT MAX(log_time) AS log_time FROM $bai_pro3.aql_track_log WHERE carton_id=$carton_id_ref)"; 
                        $result42=mysqli_query($link, $sql42) or exit("Sql Error42".$sql42."-".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        if(mysqli_num_rows($result42)>0) 
                        { 
                            while($row42=mysqli_fetch_array($result42)) 
                            { 
                                $carton_status=$row42["carton_status"]; 
                                $aql_tid_ref=$row42["tid"]; 
                            } 
                        } 
                        
                        if($carton_status==1) 
                        { 
                            $id="Red"; 
                            $sql41="select * from $bai_pro3.aql_track_log where carton_id=$carton_id_ref and carton_status=1"; 
                            $result41=mysqli_query($link, $sql41) or exit("Sql Error41".$sql41."-".mysqli_error($GLOBALS["___mysqli_ston"]));     
                            //echo $sql41."<br>"; 
                            if(mysqli_num_rows($result41)>0) 
                            { 
                                $sql41x="select HOUR(TIMEDIFF(NOW(),log_time)) AS hourd from $bai_pro3.aql_track_log where carton_id=$carton_id_ref and carton_status=1 and tid=$aql_tid_ref"; 
                                //echo $sql41x."<br>"; 
                                $result41x=mysqli_query($link, $sql41x) or exit("Sql Error41".$sql41x."-".mysqli_error($GLOBALS["___mysqli_ston"]));     
                                while($row41x=mysqli_fetch_array($result41x)) 
                                { 
                                    $hour_1=$row41x["hourd"]; 
                                } 
                            } 
                            if(mysqli_num_rows($result41)>1) 
                            { 
                                $text_ref="X"; 
                            } 
                        } 
                        
                        if($carton_status==2) 
                        { 
                            $id="Yellow"; 
                            $sql42x="select HOUR(TIMEDIFF(NOW(),log_time)) AS hourd from $bai_pro3.aql_track_log where carton_id=$carton_id_ref and tid=$aql_tid_ref"; 
                            $result42x=mysqli_query($link, $sql42x) or exit("Sql Error42".$sql42x."-".mysqli_error($GLOBALS["___mysqli_ston"]));                 
                            while($row42x=mysqli_fetch_array($result42x)) 
                            { 
                                $hour_2=$row42x["hourd"]; 
                            } 
                        } 
                        
                        if($carton_status==3) 
                        { 
                            $id="Green"; 
                            $sql_sta="select status from $bai_pro3.pac_stat_log where tid=$carton_id_ref"; 
                            $result_sta=mysqli_query($link, $sql_sta) or exit("Sql Error_sta".$sql_sta."-".mysqli_error($GLOBALS["___mysqli_ston"]));                 
                            while($row_sta=mysqli_fetch_array($result_sta)) 
                            { 
                                $carton_scan_status=$row_sta["status"]; 
                            } 
                            if($carton_scan_status!="DONE") 
                            { 
                                $sql43x="select MINUTE(TIMEDIFF(NOW(),log_time)) AS mintd from $bai_pro3.aql_track_log where carton_id=$carton_id_ref and tid=$aql_tid_ref"; 
                                $result43x=mysqli_query($link, $sql43x) or exit("Sql Error43".$sql43x."-".mysqli_error($GLOBALS["___mysqli_ston"]));                 
                                while($row43x=mysqli_fetch_array($result43x)) 
                                { 
                                    $mint_3=$row43x["mintd"]; 
                                } 
                            } 
                        } 
                        
                        if(mysqli_num_rows($result42)>0) 
                        {             
                            if($hour_1 > 0) 
                            { 
                                $add_css="class=\"blink\""; 
                            } 
                            
                            if($hour_2 > 0) 
                            { 
                                $add_css="class=\"blink\""; 
                            } 
                            
                            if($mint_3 > 30) 
                            { 
                                $add_css="class=\"blink\""; 
                            } 
                        } 
                        
                        $title=str_pad("Carton ID : ".$carton_id_ref,30).str_pad("\nCarton Qty : ".$carton_qty,30); 
                        
                        //embellishment highlight 
                        $emb_text=""; 
                        if(in_array($sql_row1['ims_schedule'],$emb_schedules)) 
                        { 
                            $emb_text="E"; 
                        } 
                        
                        if((($output_qty+$output_qty1)-$packing_qty) >= $ims_tid_qty) 
                        { 
                            echo "<div id=\"$id\" style=\"color:black;text-align:center;\" $add_css title=\"$title\"><font style=\"color:black;text-align:center;\"><b>$emb_text$text_ref</b></font></div>"; 
                        }     
                        $hour_1=0;     
                        $hour_2=0;             
                    }     
                    
                    echo "</td>"; 
                    echo "</tr>"; 
                    } 
                } 

                echo "</table>"; 
                echo "</p>"; 
                echo '</div>'; 

            } 

} 
echo "</div></div>";
?> 
<div style="clear: both;"> </div> 
<script> 
     
    function blink(selector){ 
    $(selector).fadeOut('slow', function(){ 
        $(this).fadeIn('slow', function(){ 
            blink(this); 
        }); 
    }); 
    } 
         
    blink('.blink'); 
</script> 


<?php 

((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); 
((is_null($___mysqli_res = mysqli_close($link_new))) ? false : $___mysqli_res); 
//mysql_close($link_new2); 

?> 