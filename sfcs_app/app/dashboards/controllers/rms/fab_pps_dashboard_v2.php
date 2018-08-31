<?php
    $double_modules=array();
    set_time_limit(200000);
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
?>
<script type="text/javascript">
    jQuery(document).ready(function($)
    {
       $('#schedule,#docket').keypress(function (e) {
           var regex = new RegExp("^[0-9\]+$");
           var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
           if (regex.test(str)) {
               return true;
           }
           e.preventDefault();
           return false;
       });
    });
</script>

<?php
    $hour=date("H.i");
    echo '<META HTTP-EQUIV="refresh" content="180">';
    include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');
    $php_self = explode('/',$_SERVER['PHP_SELF']);
    array_pop($php_self);
    $url_r = base64_encode(implode('/',$php_self)."/fab_pps_dashboard_v2.php");
    $has_permission=haspermission($url_r); 

    if(!in_array($authorized,$has_permission))
    {
        echo '<script>
        var ctrlPressed = false;
        $(document).keydown(function(evt) {
          if (evt.which == 17 || evt.which == 13) { // ctrl
            ctrlPressed = true;
            alert("This key has been disabled.");
          }
        }).keyup(function(evt) {
          if (evt.which == 17) { // ctrl
            ctrlPressed = false;
          }
        });
        
        $(document).click(function() {
          if (ctrlPressed) {
            // do something
            //alert("Test");
          } else {
            // do something else
          }
        });
        </script>';
    }
?>

<script>
    function redirect_view()
    {
        //x=document.getElementById('view_cat').value;
        y=document.getElementById('view_div').value;
        r=document.getElementById('view_qty').value;
        //window.location = "fab_pps_dashboard_v2.php?view=2&view_cat="+x+"&view_div="+y;
        window.location = "index.php?r=<?= $_GET['r'] ?>&view=2&view_div="+encodeURIComponent(y)+"&view_qty="+r;
       
    }

    function redirect_dash()
    {
        //x=document.getElementById('view_cat').value;
        y=document.getElementById('view_div').value;
        z=document.getElementById('view_dash').value;
        a=document.getElementById('view_priority').value;
        r=document.getElementById('view_qty').value;
        //window.location = "fab_pps_dashboard_v2.php?view="+z+"&view_cat="+x+"&view_div="+y;
        window.location = "index.php?r=<?= $_GET['r'] ?>&view="+z+"&view_div="+encodeURIComponent(y)+"&view_priority="+a+"&view_qty="+r;
       
    }

    function redirect_priority()
    {
        //x=document.getElementById('view_cat').value;
        y=document.getElementById('view_div').value;
        z=document.getElementById('view_dash').value;
        a=document.getElementById('view_priority').value;
        r=document.getElementById('view_qty').value;
        //window.location = "pps_dashboard_v2.php?view="+z+"&view_cat="+x+"&view_div="+y;
        window.location = "index.php?r=<?= $_GET['r'] ?>&view="+z+"&view_div="+encodeURIComponent(y)+"&view_priority="+a+"&view_qty="+r;
       
    }
</script>


<script>
    function blink_new(x)
    {
        obj="#"+x;
        if ( $(obj).length ) 
        {
            $(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
        }
    }

    function blink_new3(x)
    {
        $("div[id='S"+x+"']").each(function() {
            $(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
        });
    }


    function blink_new1(x)
    {
        obj="#"+x;
        
        if ( $(obj).length ) 
        {
            $(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
        }
    }

    function blink_new_priority(x)
    {
        var temp=x.split(",");
        
        for(i=0;i<x.length;i++)
        {
            blink_new1(temp[i]);
        }
    }
</script>


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
</style>


<style>
    a{
        text-decoration:none;
        color: #000000;
    }

    .white {
      width:20px;
      height:20px;
      background-color: #ffffff;
      display:block;
      float: left;
      margin: 2px;
      border: 1px solid #000000;
    }

    .white a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }

    .white a:hover {
      text-decoration:none;
      background-color: #ffffff;
    }


    .red {
      width:20px;
      height:20px;
      background-color: red;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .red a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }

    .red a:hover {
      text-decoration:none;
      background-color: #ff0000;
    }

    .green {
      width:20px;
      height:20px;
      background-color: green;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .green a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }

    .green a:hover {
      text-decoration:none;
      background-color: green;
    }

    .lgreen {
      width:20px;
      height:20px;
      background-color: #59ff05;
      display:block;
      float: left;
      margin: 2px;
      border: 1px solid #000000;
     }

    .lgreen a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
     
    }

    .lgreen a:hover {
      text-decoration:none;
      background-color: #59ff05;
      
    }

    .yellow {
      width:20px;
      height:20px;
      background-color: #ffff00;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .yellow a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }

    .yellow a:hover {
      text-decoration:none;
      background-color: #ffff00;
    }


    .pink {
      width:20px;
      height:20px;
      background-color: pink;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .pink a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }

    .pink a:hover {
      text-decoration:none;
      background-color: pink;
    }

    .orange {
      width:20px;
      height:20px;
      background-color: #991144;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .orange a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }

    .orange a:hover {
      text-decoration:none;
      background-color: #991144;
    }

    .blue {
      width:20px;
      height:20px;
      background-color: #15a5f2;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .blue a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }

    .blue a:hover {
      text-decoration:none;
      background-color: #15a5f2;
    }


    .yash {
      width:20px;
      height:20px;
      background-color: #999999;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .yash a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }

    .yash a:hover {
      text-decoration:none;
      background-color: #999999;
    }

    .black {
      width:20px;
      height:20px;
      background-color: black;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .brown {
      width:20px;
      height:20px;
      background-color: #333333;
      display:block;
      float: left;
      margin: 2px;
    border: 1px solid #000000;
    }

    .black a {
      display:block;
      float: left;
      width:100%;
      height:100%;
      text-decoration:none;
    }
    .black a:hover {
      text-decoration:none;
      background-color: black;
    }
    .form-inline .form-control {
    width: 74px;
    
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
    // -->
</SCRIPT>


<script language="JavaScript">
    <!--

    //Disable right mouse click Script
    //By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
    //For full source code, visit http://www.dynamicdrive.com

    var message="Function Disabled!";

    ///////////////////////////////////
    function clickIE4(){
        if (event.button==2){
            alert(message);
            return false;
        }
    }

    function clickNS4(e){
        if (document.layers||document.getElementById&&!document.all){
            if (e.which==2||e.which==3){
                alert(message);
                return false;
            }
        }
    }

    if (document.layers){
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown=clickNS4;
    }
    else if (document.all&&!document.getElementById){
        document.onmousedown=clickIE4;
    }

    document.oncontextmenu=new Function("alert(message);return false")

    // --> 
</script>

<?php
    //NEW to correct
    $remove_docs=array();
    $sqlx="select * from $bai_pro3.plan_dash_doc_summ where act_cut_issue_status=\"DONE\"";
    // $sqlx="select * from plan_dash_doc_summ where act_cut_status=\"DONE\"";
    // mysqli_query($link, $sqlx) or exit("Sql Error 27".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["$___mysqli_ston"]));
    {
        if($sql_rowx['doc_no'] != null)
        {
            $remove_docs[]=$sql_rowx['doc_no'];
        }
        // echo $sql_rowx['doc_no'];
    }

    if(sizeof($remove_docs)>0)
    {
        $sqlx="delete from $bai_pro3.plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
        mysqli_query($link, $sqlx) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    echo "</p>";
?>

<div class="panel panel-primary">
    <div class="panel-heading"><strong>RMS Dashboard</strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="form-inline">
                <div class="form-group">
                    <?php
                        echo '<label>Docket Track: </label>
                              <input type="text" name="docket" id="docket" class="form-control" onkeyup="blink_new(this.value)" size="10">';
                    ?>
                </div>
                <div class="form-group">
                    <?php
                        echo 'Schedule Track: <input type="text" name="schedule" id="schedule"  class="form-control" onkeyup="blink_new3(this.value)" size="10">';
                    ?>
                </div>
                <div class="form-group">
                    <?php
                        //echo "<font size=4>LIVE FABRIC STATUS DASHBOARD";
                        if($_GET['view']==1)
                        {
                            echo "<font color=yellow> - Quick View</font>";
                        }
                        if($_GET['view']==3)
                        {
                        //  echo "<font color=yellow> - Cut View</font>";
                        }
                        echo "</font>";
                        //echo "<font color=yellow>Refresh Rate: 120 Sec. (ALPHA TESTING)</font>";


                        echo '&nbsp;&nbsp;&nbsp;Dashboard View
                        <select name="view_dash" id="view_dash" class="form-control" onchange="redirect_dash()">';
                        if($_GET['view']=="ALL") { echo '<option value="ALL" selected>All</option>'; } else { echo '<option value="ALL">All</option>'; }
                        if($_GET['view']=="1") { echo '<option value="1" selected>RM</option>'; } else { echo '<option value="1">RM</option>'; }
                        if($_GET['view']=="3") { echo '<option value="3" selected>Cutting</option>'; } else { echo '<option value="3">Cutting</option>'; }
                        echo '</select>';
                        // Ticket #424781 Disply buyer division from the database level plan_module table
                        $sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
                        // echo $sqly.'<br>';
                        echo '&nbsp;&nbsp;&nbsp;Buyer Division :
                        <select name="view_div" id="view_div" class="form-control" onchange="redirect_view()">';
                        echo "<option value=\"ALL\" selected >ALL</option>";
                        //$sqly="select distinct(buyer_div) from plan_modules";

                        $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_rowy=mysqli_fetch_array($sql_resulty))
                        {
                            $buyer_div=$sql_rowy['buyer_div'];
                            $buyer_name=$sql_rowy['buyer_name'];
                            
                            if(urldecode($_GET["view_div"])=="$buyer_name") 
                            {
                                 echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
                            } 
                            else 
                            {
                                 echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
                            }
                        }

                        echo '</select>';
                        echo '&nbsp;&nbsp;&nbsp;Priorities:<select name="view_priority" id="view_priority" class="form-control" onchange="redirect_priority()">';
                        if($_GET['view_priority']=="4") { echo '<option value="4" selected>4</option>'; } else { echo '<option value="4">4</option>'; }
                        if($_GET['view_priority']=="6") { echo '<option value="6" selected>6</option>'; } else { echo '<option value="6">6</option>'; }
                        if($_GET['view_priority']=="8") { echo '<option value="8" selected>8</option>'; } else { echo '<option value="8">8</option>'; }
                        if($_GET['view_priority']=="12") { echo '<option value="12" selected>12</option>'; } else { echo '<option value="12">12</option>'; }
                        if($_GET['view_priority']=="16") { echo '<option value="16" selected>16</option>'; } else { echo '<option value="16">16</option>'; }
                        echo '</select>';
                        echo '&nbsp;&nbsp;&nbsp;Show Quantity :<select name="view_qty" id="view_qty" class="form-control" onchange="redirect_view()">';
                        if($_GET['view_qty']==1) 
                        {
                            echo "<option value=\"1\" selected >Yes</option>";
                             echo "<option value=\"0\">No</option>";
                         }
                         else
                         {
                             echo "<option value=\"1\">Yes</option>";
                             echo "<option value=\"0\" selected>No</option>";
                         }
                         echo '</select>';
                        if(isset($_GET['view_priority']))
                        {
                            $priority_limit=$_GET['view_priority'];
                        }
                        else
                        {
                            $priority_limit=4;
                        }
                    ?>
                </div>
            </div>
            <?php
                //For blinking priorties as per the section module wips
                $bindex=0;
                $blink_docs=array();
                //Ticket #663887  display buyers like pink,logo and IU as per plan_modules table
                $sqlx="select * from $bai_pro3.sections_db where sec_id>0";
                $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error 7".mysqli_error($GLOBALS["___mysqli_ston"]));
                $rows5=mysqli_num_rows($sql_resultx);   
                while($sql_rowx=mysqli_fetch_array($sql_resultx))
                {
                    $section=$sql_rowx['sec_id'];
                    $section_head=$sql_rowx['sec_head'];
                    $section_mods=$sql_rowx['sec_mods'];
                    
                    //echo "buyer=".$_GET["view_div"];
                    if($_GET["view_div"]!='ALL' && $_GET["view_div"]!='')
                    {
                        //echo "Buyer=".urldecode($_GET["view_div"])."<br>";
                        $buyer_division=urldecode($_GET["view_div"]);
                        //echo '"'.str_replace(",",'","',$buyer_division).'"'."<br>";
                        $buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
                        $order_div_ref="and order_div in (".$buyer_division_ref.")";
                    }
                    else
                    {
                        $order_div_ref='';
                    }   
                        
                    // Ticket #976613 change the buyer division display based on the pink,logo,IU as per plan_modules
                    $sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1";
                    //echo $sql1d."<br>";
                    $qty_view_status=$_GET["view_qty"];
                    $sql_num_checkd=0;
                    $sql_result1d=mysqli_query($link, $sql1d) or exit("Sql Error 9".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $sql_num_checkd=mysqli_num_rows($sql_result1d);
                    //echo $sql_num_checkd."<br>";
                    if($sql_num_checkd > 0)
                    {       
                        $mods=array();
                        while($sql_row1d=mysqli_fetch_array($sql_result1d))
                        {
                            $mods[]=$sql_row1d["modx"];
                        }
                    
                        echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
                        echo "<p>";
                        echo "<table>";
                        $url=getFullURL($_GET['r'],'board_update.php','N');
                        echo "<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('$url&section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">SECTION - $section</a></h2></th></th></tr>";

                        //$mods=explode(",",$section_mods);
                        
                        //For Section level blinking
                        $blink_minimum=0;
                    

                        for($x=0;$x<sizeof($mods);$x++)
                        {

                            $module=$mods[$x];
                            $blink_check=0;
                            
                            $sql11="select sum(ims_qty-ims_pro_qty) as \"wip\" from $bai_pro3.ims_log where ims_mod_no=$module";
                            $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error 11".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row11=mysqli_fetch_array($sql_result11))
                            {
                                $wip=$sql_row11['wip'];
                            } 
                            $iu_modules=array('0');
                            $iu_module_highlight="";
                            if(in_array($module,$iu_modules))
                            {
                                $iu_module_highlight="bgcolor=\"$iu_module_highlight_color\"";
                            }
                            
                            echo "<tr class=\"bottom\">";
                            $url5=getFullURL($_GET['r'],'module_wise_summary.php','N');
                            $sql_count="select * from $bai_pro3.plan_dash_doc_summ where act_cut_status!=\"DONE\" and module='$module'";
                            $sql_count_result=mysqli_query($link, $sql_count) or exit("Sql Error2".mysqli_error($GLOBALS["$___mysqli_ston"]));
                            $rows5=mysqli_num_rows($sql_count_result);
                            //echo $rows5;
                            if($rows5!=''or $rows5!='0')
                            {
                                echo "<td class=\"bottom\" $iu_module_highlight>
                                    <strong><a href=\"javascript:void(0)\" >
                                              <font class=\"fontnn\" color=black  onclick=\"Popup=window.open('$url5&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$module</font>
                                    </a></strong>
                                  </td>
                                  <td>";
                            }
                            else
                            {
                                echo "<td class=\"bottom\" $iu_module_highlight>
                                <strong><a href=\"javascript:void(0)\" >
                                <font class=\"fontnn\" color=black style='background-color:white;'><a href='#'>$module</a></font>
                                </a></strong>
                                  </td>
                                  <td>";
                            }     
                            //To disable issuing fabric to cutting tables
                            //All yellow colored jobs will be treated as Fabric Wip
                            $cut_wip_control=3000;
                            $fab_wip=0;
                            $pop_restriction=0;

                            //Filter view to avoid Cut Completed and Fabric Issued Modules

                            $sql1="SELECT * FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module AND act_cut_status<>'DONE' AND clubbing<>'0' ".$order_div_ref." GROUP BY order_del_no,clubbing,acutno UNION 
                            SELECT * FROM bai_pro3.plan_dash_doc_summ WHERE module=$module AND act_cut_status<>'DONE' AND clubbing='0' ".$order_div_ref." GROUP BY doc_no order by priority limit $priority_limit";
                            //echo "Module : ".$sql1."<br>";
                            //Filter view to avoid Cut Completed and Fabric Issued Modules
                            if($_GET['view']==1)
                            {
                                $sql1="SELECT * FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module AND fabric_status_new='5' AND clubbing<>'0' ".$order_div_ref." GROUP BY order_del_no,clubbing,acutno UNION 
                                SELECT * FROM bai_pro3.plan_dash_doc_summ WHERE module=$module AND act_cut_status<>'DONE' AND clubbing='0' ".$order_div_ref." GROUP BY doc_no order by log_time limit $priority_limit";
                                $view_count=0;
                            }       
                            //filter to show only cut completed
                            if($_GET['view']==3)
                            {
                                $sql1="SELECT * FROM $bai_pro3.plan_dash_doc_summ WHERE module=$module AND act_cut_status='DONE' AND clubbing<>'0' ".$order_div_ref." GROUP BY order_del_no,clubbing,acutno UNION 
                                SELECT * FROM bai_pro3.plan_dash_doc_summ WHERE module=$module AND act_cut_status='DONE' AND clubbing='0' ".$order_div_ref." GROUP BY doc_no order by priority limit $priority_limit";
                                $view_count=0;
                            }
                           
                            $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error 12".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $sql_num_check=mysqli_num_rows($sql_result1);
                            while($sql_row1=mysqli_fetch_array($sql_result1))
                            {
                                $cut_new=$sql_row1['act_cut_status'];
                                $cut_input_new=$sql_row1['act_cut_issue_status'];
                                $rm_new=strtolower(chop($sql_row1['rm_date']));
                                $rm_update_new=strtolower(chop($sql_row1['rm_date']));
                                $input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
                                $doc_no=$sql_row1['doc_no'];
                                //echo $doc_no;
                                $order_tid=$sql_row1['order_tid'];
                                $ord_style=$sql_row1['order_style_no'];
                                //$fabric_status=$sql_row1['fabric_status'];
                                $fabric_status=$sql_row1['fabric_status_new']; //NEW due to plan dashboard clearing regularly and to stop issuing issued fabric.
                                $bundle_location="";
                                if(sizeof(explode("$",$sql_row1['bundle_location']))>1)
                                {
                                    $bundle_location=end(explode("$",$sql_row1['bundle_location']));
                                }
                                $fabric_location="";
                                if(sizeof(explode("$",$sql_row1['plan_lot_ref']))>1)
                                {
                                    $fabric_location=end(explode("$",$sql_row1['plan_lot_ref']));
                                }                               
                                $style=$sql_row1['order_style_no'];
                                $schedule=$sql_row1['order_del_no'];
                                $color=$sql_row1['order_col_des'];
                                $total_qty=$sql_row1['total'];
                                
                                $cut_no=$sql_row1['acutno'];
                                $color_code=$sql_row1['color_code'];
                                $log_time=$sql_row1['log_time'];
                                $emb_stat=$sql_row1['emb_stat'];
                                $ft_status=$sql_row1['ft_status'];
                                         
                                //For Color Clubbing
                                unset($club_c_code);
                                unset($club_docs);
                                $club_c_code=array();
                                $club_docs=array();
                                $colors_db=array();
                                
                                if($sql_row1['clubbing']>0)
                                {
                                    $tids=array();
									$total_qty=0;
                                    $sql11="select order_tid,order_col_des,color_code,doc_no,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where UPPER(category) in (".$in_categories.") and order_del_no=$schedule and clubbing=".$sql_row1['clubbing']." and acutno='".$cut_no."'";
                                    //echo "</br>RMS tool Tip:".$sql11."</br>";
                                    $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error 22".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($sql_row11=mysqli_fetch_array($sql_result11))
                                    {
                                        $club_c_code[]=chr($sql_row11['color_code']).leading_zeros($sql_row1['acutno'],3);
                                        $club_docs[]=$sql_row11['doc_no'];
                                        $total_qty+=$sql_row11['total'];
                                        $colors_db[]=trim($sql_row11['order_col_des']);
										$tids[]=$sql_row11['order_tid'];
                                    }
									$sql111="select min(st_status) as s_status,min(ft_status) as f_status from $bai_pro3.bai_orders_db_confirm where order_tid in ('".implode("','",$tids)."')";
									$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error 18".mysqli_error($GLOBALS["___mysqli_ston"]));
									while($sql_row112=mysqli_fetch_array($sql_result111))
									{
										$ft_status=$sql_row112['f_status'];
									}									
									// $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_joins=2";
                                    // $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error 18".mysqli_error($GLOBALS["___mysqli_ston"]));                                    
                                    // if(mysqli_num_rows($sql_result11)>0)
                                    // {
                                        // $sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_joins=\"J$schedule\"";
                                        // $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error 19".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        // while($sql_row11=mysqli_fetch_array($sql_result11))
                                        // {
                                            // $join_ft_status=$sql_row11['ft_status'];
                                            // if($sql_row11['ft_status']==0 or $sql_row11['ft_status']>1)
                                            // {
                                                // break;
                                            // }
                                        // }
										// $ft_status=$join_ft_status;
                                    // }
                                }
                                else
                                {
                                    $colors_db[]=$color;
                                    $club_c_code[]=chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3);
                                    $club_docs[]=$doc_no;
									$tids=array();
									//NEW FSP if it has schedule Clubbing 
									$sql11="select * from $bai_pro3.plandoc_stat_log where org_doc_no='".$doc_no."'";
                                    $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error 18".mysqli_error($GLOBALS["___mysqli_ston"]));                                    
                                    if(mysqli_num_rows($sql_result11)>0)
                                    {
                                        while($sql_row11=mysqli_fetch_array($sql_result11))
                                        {
											$tids[]=$sql_row11['order_tid'];
                                        }
										$sql111="select min(st_status) as s_status,min(ft_status) as f_status from $bai_pro3.bai_orders_db_confirm where order_tid in ('".implode("','",$tids)."')";
										$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error 18".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($sql_row112=mysqli_fetch_array($sql_result11))
                                        {
											$ft_status=$sql_row112['f_status'];
										}
									}
                                }
                                unset($tids);
                                $colors_db=array_unique($colors_db);
                                $club_c_code=array_unique($club_c_code);
                                $club_docs=array_unique($club_docs);
                                
                                $fab_issue_query="select * from $bai_pro3.plandoc_stat_log where fabric_status!=5 and doc_no IN (".implode(",",$club_docs).")";
                                // echo "Fab Issue Query : ".$fab_issue_query."<br>";
                                $fab_issue_result=mysqli_query($link, $fab_issue_query) or exit("error while getting fab issue details");
                                if (mysqli_num_rows($fab_issue_result)>0)
                                {
                                    $fab_status = 0;
                                }
                                else
                                {
                                    $fab_status = 5;
                                }
								
								$fab_issue2_query="select * from $bai_pro3.plan_dashboard where fabric_status='1' and doc_no IN (".implode(",",$club_docs).")";
								// echo $fab_issue2_query."<br>";
								$fab_status="";
								$fab_isuue2_result=mysqli_query($link, $fab_issue2_query) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
								if(mysqli_num_rows($fab_isuue2_result)>0)
								{
									$fab_status="1";
								}
							$fab_request_query="select * from $bai_pro3.fabric_priorities where doc_ref in (".implode(",",$club_docs).")";
                                $fab_request_result=mysqli_query($link, $fab_request_query) or exit("error while getting fab Requested details");
    
                                if ($fab_status==5)
                                {
                                    $final_cols = 'yellow';
                                    $rem="Fabric issued";
                                }
								elseif($fab_status==1){
									$final_cols = 'pink';
                                    $rem="Ready To issue";
								}
                                elseif (mysqli_num_rows($fab_request_result)>0)
                                {
                                    $final_cols = 'green';
                                    $rem="Fabric requested";
                                }
                                elseif ($fabric_status < 5)
                                {
                                    switch ($ft_status)
                                    {
                                        case "1":
                                        {
                                            $final_cols="lgreen";                    
                                            $rem="Fabric Available but not Requested";
                                            break;
                                        }
                                        case "0":
                                        {                                   
                                            $final_cols="red";
                                            $rem="Fabric Not Available";
                                            break;
                                        }
                                        case "2":
                                        {
                                            $final_cols="red";
                                            $rem="Fabric In House Issue";
                                            break;
                                        }
                                        case "3":
                                        {
                                            $final_cols="red";
                                            $rem="GRN issue";
                                            break;
                                        }
                                        case "4":
                                        {
                                            $final_cols="red";
                                            $rem="Put Away Issue";
                                            break;
                                        }
                                        default:
                                        {
                                            $final_cols="yash";
                                            $rem="No Status";
                                            break;
                                        }
                                    }
                                }
                                else
                                {
                                    $final_cols='yash';
                                    $rem="No status";
                                }
                                //For Fabric Wip Tracking
                                
                                // if($cut_new!="T" and $final_cols=="yellow")
                                // {
                                //     $fab_wip+=$total_qty;
                                // }
                                        
                                $title=str_pad("Style:".trim($style),80)."\n".str_pad("Schedule:".$schedule,80)."\n".str_pad("Color:".trim(implode(",",$colors_db)),80)."\n".str_pad("Cut Job No:".implode(", ",$club_c_code),80)."\n".str_pad("Total_Qty:".$total_qty,80)."\n".str_pad("Log Time:".$log_time,80)."\n".str_pad("Fab_Loc.:".$fabric_location."Bundle_Loc.:".$bundle_location,80)."\n".str_pad("Remarks:".$rem,80);
                                

                                // Ticket #688771 Display IU modues Priorit boxes with "IU" Symbol.
                                $sqlt="SELECT * from $bai_pro3.plan_dash_doc_summ where module=$module and doc_no=$doc_no and act_cut_issue_status<>\"DONE\"" ;
                                    // echo $sqlt;
                                $sql_result12=mysqli_query($link, $sqlt) or exit("Sql Error 23".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $check_num_rows=mysqli_num_rows($sql_result12);     
                                while($sql_row12=mysqli_fetch_array($sql_result12))
                                {
                                    $sel_sty=$sql_row12['order_style_no'];
                                    $sel_sch=$sql_row12['order_del_no'];
                                }
                                //echo $module."-schedules:".$sel_sch."-".$sel_sty."-".$ord_style."<br/>";  
                                // if($check_num_rows>0 && $sel_sty==$ord_style)
                                // {                                     
                                    if(in_array($authorized,$has_permission) and $final_cols!="yellow" and $final_cols!="green")
                                    {
                                        // echo "yash<br>";
                                        $url1=getFullURL($_GET['r'],'fabric_requisition.php','N');
                                        if($qty_view_status==1){
                                            echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$final_cols\" style=\"font-size:12px;width:20px; text-align:center;min-width:20px;width:auto;color:$final_cols\" title=\"$title\" ><a href=\"$url1&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open('$url1&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$total_qty</a></div>";
            
                                        }else{
                                            echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$final_cols\" style=\"font-size:12px; text-align:center; color:$final_cols\" title=\"$title\" ><a href=\"$url1&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open('$url1&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"></a>";
                                        }
                                        //echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$final_cols\" style=\"font-size:12px; text-align:center; color:$final_cols\" title=\"$title\" ><a href=\"$url1&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open('$url1&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"></a>";
                                        //echo $schedule;
                                        echo "</div></div>";
                                    }
                                    else
                                    {
                                        // echo "yellow or green<br>";
                                        if($qty_view_status==1){
                                            echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$final_cols\" style=\"font-size:12px;width:20px; text-align:center;min-width:20px;width:auto;color:$final_cols\" title=\"$title\" ><a href=\"#\">$total_qty</a></div></div>";
                                           }else{
                                               echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$final_cols\" style=\"font-size:12px; text-align:center; color:$final_cols\" title=\"$title\" ><a href=\"#\"></a></div></div>";
      
                                           }
                                       // echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$final_cols\" style=\"font-size:12px; text-align:center; color:$final_cols\" title=\"$title\" ><a href=\"#\"></a></div></div>";
                                    }        
                                // }
                                // else
                                // {
                                //     if(in_array($authorized,$has_permission) and $final_cols!="yellow" and $final_cols!="green")
                                //     {
                                //         // echo "yash 1<br>";
                                //         $url1=getFullURL($_GET['r'],'fabric_requisition.php','N');
                                //         echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$final_cols\" style=\"font-size:12px; text-align:center; color:$final_cols\" title=\"$title\" ><a href=\"$url1&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."\" onclick=\"Popup=window.open('$url1&module=$module&section=$section&doc_no=$doc_no&pop_restriction=$pop_restriction&group_docs=".implode(",",$club_docs)."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"></a>";
                                        
                                //         echo "</div></div>";
                                //     }
                                //     else
                                //     {
                                //         // echo "yellow or green 1";
                                //         echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"$doc_no\" class=\"$final_cols\" style=\"font-size:12px; text-align:center; color:$final_cols\" title=\"$title\" ></div></div>";
                                //     }
                                // }
                            }
                            //Ticket #663887 dispaly the buyer name of module at the end of boxes
                            $sqly="select buyer_div from $bai_pro3.plan_modules where module_id=$module";
                            //echo $sqly."<br>";
                            $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error 24".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_rowy=mysqli_fetch_array($sql_resulty))
                            {
                                $buyer_div=$sql_rowy['buyer_div'];
                            }

                            if(!in_array($module,$double_modules))
                            {
                                if($_GET['view']==1)
                                {
                                    for($i=1;$i<=($priority_limit-$view_count);$i++)
                                    {
                                        // $testurl=getFullURL($_GET['r'],'test.php','N');
                                        // echo "<div class=\"white\"><a href=\" $tesurl \"></a></div>";
                                        echo "<div class=\"white\"></div>";
                                    }
                                    echo substr($buyer_div,0,1);
                                }
                                else
                                {
                                    for($i=1;$i<=($priority_limit-$sql_num_check);$i++)
                                    {
                                        // $testurl=getFullURL($_GET['r'],'test.php','N');
                                        // echo "<div class=\"white\"><a href=\" $testurl \"></a></div>";
                                        echo "<div class=\"white\"></div>";
                                    }
                                    echo substr($buyer_div,0,1);
                                }   
                            }
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                        
                        //Blinking at section level
                        $bindex++;

                        echo "</table>";
                        echo "</p>";
                        echo '</div>';
                    }
                }
                    
                //To show section level priority only to RM-Fabric users only.
                if((in_array($authorized,$has_permission)))
                {
                    //PLEASE UNCOMMENT THIS IF YOU WANT TO BLINK SOME SECTIONS FOR SPECIFIC LOGGED IN USERS DURING ON LOAD
                    /*  echo "<script>
                                $(document).ready(function(){ 
                                    blink_new_priority('".implode(",",$blink_docs)."'); 
                                })
                             </script>";
                    */
                }   
            ?>
        </div>
        <div class="row">
            <?php
                // include(getFullURL($_GET['r'],'include_legends_rms.php','N'));
                include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'include_legends_rms.php',0,'R'));
            ?>
        </div>
    </div>
</div>