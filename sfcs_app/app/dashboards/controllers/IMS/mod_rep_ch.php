<!-- 
Ticket #645397: KiranG/2014-02-17 
Excess Panel input reporting interface link has been added to this report to report excess panel input to the module. 

--> 
<?php

set_time_limit(2000);
error_reporting(0);
ini_set('display_errors', 'On');
?>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/input_status_update_input.php");
$has_permission=haspermission($url_r); 
?>


<?php 
//echo $username; 
$username_list=explode('\\',$_SERVER['REMOTE_USER']); 
$username=strtolower($username_list[1]); 

//Special Input Processing Block 
{ 
    if(isset($_POST['spreq'])) 
    { 
        $module=$_POST['module']; 
        $reason=$_POST['reason']; 
        $section=$_POST['section']; 
        $key=$_POST['key']; 
         
         
        $sql="select * from $bai_pro3.sections_db where sec_id=$section and password='$key'"; 
        //echo $sql; 
        //$sql="select * from members where login=\"$password\""; 
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_num_check=mysqli_num_rows($sql_result); 
        while($sql_row=mysqli_fetch_array($sql_result)) 
        { 
            $mods=array(); 
            $mods=explode(",",$sql_row['sec_mods']); 
        } 
        if(in_array($module,$mods) and $sql_num_check>0)  
        { 
             
        } 
        else  
        { 
            $sql_num_check=0; 
        } 
         
         
        $username_list=explode('\\',$_SERVER['REMOTE_USER']); 
        $username=strtolower($username_list[1]); 
         
        echo "Reason =".strlen($reason)."   Rows =".$sql_num_check; 
         
        if(strlen($reason)>0 and $sql_num_check>0) 
        { 
            $sql="insert into $bai_pro3.ims_sp_db(module,req_user,remarks,status) values ($module,\"$username\",\"$reason\",0)"; 
            mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        } 
        else 
        { 
            header("Location:cheat_system.php"); 
        } 
        echo "<script type=\"text/javascript\"> window.close(); </script>"; 
    } 
} 
?> 
<script language=\"javascript\" type=\"text/javascript\" src=".getFullURL($_GET['r'],'common/js/dropdowntabs.js',4,'R')."></script>
<link rel=\"stylesheet\" href=".getFullURL($_GET['r'],'common/css/ddcolortabs.css',4,'R')." type=\"text/css\" media=\"all\" />



<style> 
body{ 
    font-family: calibri; 
} 
a {text-decoration: none;} 

.atip 
{ 
    color:black; 
} 

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

.bottom 
{ 
    border-bottom: 3px solid white; 
    padding-bottom: 5px; 
    padding-top: 5px; 
} 

</style> 

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/common/css/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> 

</head> 

<body> 

<form name="test" action="pop_login.php" method="post"> 
<?php 
        $module_ref=$_GET['module']; 
        $section_id=$_GET['section_id']; 
        //echo "<h2>Module - $module_ref Summary</h2>"; 
        echo '<div id="page_heading"><span style="float: left"><h3>Module - '.$module_ref.' Summary</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>'; 
        echo '<table style="color:black; border: 1px solid red;">'; 
        echo "<tr class=\"new\"><th>Select</th><th>Input Date</th><th>Exp. to Comp.</th><th>TID</th><th>Style</th><th>Schedule</th><th>Color</th>"; 
        //echo "<th>CID</th><th>DOC#</th>"; 
        echo "<th>Input Remarks</th>"; 
        echo "<th>Cut No</th><th>Input Job No</th><th>Size</th><th>Input</th><th>Output</th><th>Balance</th></tr>"; 
             
        $toggle=0; 
        $sql="select distinct rand_track from $bai_pro3.ims_log where ims_mod_no='$module_ref' order by tid";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row=mysqli_fetch_array($sql_result)) 
        { 
            $rand_track=$sql_row['rand_track']; 
             
            if($toggle==0) 
            { 
                $tr_color="#66DDAA"; 
                $toggle=1; 
            } 
            else if($toggle==1) 
            { 
                $tr_color="white"; 
                $toggle=0; 
            } 
             
            $req_date=""; 
            $sql12="select req_date from $bai_pro3.ims_exceptions where ims_rand_track='$rand_track'";  
            $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row12=mysqli_fetch_array($sql_result12)) 
            { 
                $req_date=$sql_row12['req_date']; 
            } 
            $input_job_no=0; 
            $sql12="select * from $bai_pro3.ims_log where ims_mod_no='$module_ref' and rand_track=$rand_track and ims_status<>'DONE' order by ims_schedule, ims_size DESC"; 
            // echo $sql12.'<br>'; 
            $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row12=mysqli_fetch_array($sql_result12)) 
            {                  
                $ims_doc_no=$sql_row12['ims_doc_no']; 
                $input_job_no=$sql_row12['input_job_no_ref'];
                $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row12['ims_schedule'],$sql_row12['ims_color'],$sql_row12['input_job_no_ref'],$link);
             
                $sql22="select * from $bai_pro3.plandoc_stat_log where doc_no=$ims_doc_no and a_plies>0"; 
                $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                while($sql_row22=mysqli_fetch_array($sql_result22)) 
                { 
                    $order_tid=$sql_row22['order_tid']; 
                     
                    $sql33="select * from $bai_pro3.bai_orders_db where order_tid='$order_tid'"; 
                    $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row33=mysqli_fetch_array($sql_result33)) 
                    { 
                        $color_code=$sql_row33['color_code']; //Color Code 
                    } 
                    $cutno=$sql_row22['acutno']; 
                } 
     
                 
                echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>"; 
                 
                if($sql_row12['ims_remarks']!="SAMPLE") 
                { 
                    echo "<input type=\"radio\" name=\"radio\" value=\"".$sql_row12['tid']."\">"; 
                } 
                else 
                { 
                    echo "N/A"; 
                } 
                     
                     
                echo "</td><td>".$sql_row12['ims_date']."</td><td>$req_date</td><td>".$sql_row12['tid']."</td><td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td>"; 
                echo "<td>".$sql_row12['ims_remarks']."</td>"; 
//echo "<td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td>"; 
echo "<td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".$display_prefix1."</td><td>".strtoupper(substr($sql_row12['ims_size'],2))."</td><td>".$sql_row12['ims_qty']."</td><td>".$sql_row12['ims_pro_qty']."</td><td>".($sql_row12['ims_qty']-$sql_row12['ims_pro_qty'])."</td></tr>"; 
            } 
        } 
        echo "</table>"; 
         
         

    $auth_cad_mem=array("thusharako","chathurangad","dinushapre","eshankal","monathu","lasitham","hasithada"); 
    $username=strtolower ($username); 
    if(in_array($update,$haspermission)) 
    { 
         
            echo 'Please enter your key to unlock edit panel: 

                <input type="password" size=6 name="key"> 
                <input type="submit" name="submit" value="Unlock"> 
                <input type="hidden" value="'.$module_ref.'" name="module"> 
                <input type="hidden" value="'.$section_id.'" name="section_ids">'; 
         
    } 
     

         
?> 


</form> 

<h3>Request for Special Input</h3> 
<form name="test_input" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
<input type="hidden" name="module" value="<?php echo $module_ref;  ?>"> 
<input type="hidden" name="section" value="<?php echo $section_id;  ?>"> 
Password: <input type="password" name="key" value="" size="4">Reason: <input type="text" name="reason" value=""> <font color=red>* This is mandatory field.</font> 
<input type="submit" name="spreq" value="Create Special Input Box"> 


</form> 

<br/> 

<?php 
//First cut will be excempted and total input can be reported to module, based on the global value. 
if($input_excess_cut_as_full_input==1) 
{ 
?> 
    <!-- <h3 style="cursor: pointer; color:RED;" onclick="window.location='../ims_allsizes_zero.php?inremark=EXCESS&module=<?php echo $_GET['module']; ?>'">Click here to Report Excess Cut Panel Input</h3> 

    <h3 style="cursor: pointer; color: BLUE;" onclick="window.location='../ims_allsizes_zero.php?inremark=SAMPLE&module=<?php echo $_GET['module']; ?>'">Click here to Report SAMPLE ROOM Cut Panel Input</h3>  -->
<?php 
} 
else 
{ 

?> 
<!-- <h3 style="cursor: pointer; color: BLUE;" onclick="window.location='../ims_allsizes.php?inremark=SAMPLE&module=<?php echo $_GET['module']; ?>'">Click here to Report SAMPLE ROOM Cut Panel Input</h3>  -->
<?php 
} 
?> 

</body> 
</html> 