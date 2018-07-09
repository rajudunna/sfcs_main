<!-- 
Ticket #645397: KiranG/2014-02-17 
Excess Panel input reporting interface link has been added to this report to report excess panel input to the module. 

Ticket#45927327 Nareshb/Date:24-12-2015/Applying user_acl to give access for input remove,input transfer and to report sample room for cut panels 

--> 
<?php 

error_reporting(0);
ini_set('display_errors', 'On');
set_time_limit(2000); 
?> 

<?php 

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/sec_rep.php");
$has_permission=haspermission($url_r);
//include($_SERVER['DOCUMENT_ROOT']."M3_Bulk_OR/ims_size.php"); 
//include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php"); 
//include($_SERVER['DOCUMENT_ROOT']."server/group_def.php"); 
//access for authorised user to transfer the input  
//$auth_users=user_acl("SFCS_0203",$username,7,$group_id_sfcs);  
$auth_users=array("rameshk","chathurangad","dinushapre","$username"); 
//access for power user to remove the input 
//$auth_cut_users=user_acl("SFCS_0203",$username,22,$group_id_sfcs);  
$auth_cut_users=array("rameshk","chathurangad","dinushapre","$username"); 
//access for super user to report the sample room for cut panel input 
//$auth_users_for_sample_cut_input=user_acl("SFCS_0203",$username,33,$group_id_sfcs); 
$auth_users_for_sample_cut_input=array("rameshk","chathurangad","dinushapre","$username"); 
?> 


<?php 
/* 
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
         
         
        $sql="select * from sections_db where sec_id=$section and password=\"$key\""; 
        //echo $sql; 
        //$sql="select * from members where login=\"$password\""; 
        mysql_query($sql,$link) or exit("Sql Error".mysql_error()); 
        $sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error()); 
        $sql_num_check=mysql_num_rows($sql_result); 
        while($sql_row=mysql_fetch_array($sql_result)) 
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
            $sql="insert into ims_sp_db(module,req_user,remarks,status) values ($module,\"$username\",\"$reason\",0)"; 
            mysql_query($sql,$link) or exit("Sql Error".mysql_error()); 
        } 
        else 
        { 
            header("Location:../cheat_system.php"); 
        } 
        echo "<script type=\"text/javascript\"> window.close(); </script>"; 
    } 
}*/ 
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>POP - IMS Track Panel</title>
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
        echo '<div id="page_heading"><span style=""><h3>Module - '.$module_ref.' Summary</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>'; 
        echo '<table style="color:black; border: 1px solid red;">'; 
        echo "<tr class=\"new\"><th>Select</th><th>Input Date</th><th>Exp. to Comp.</th><th>Style</th><th>Schedule</th><th>Color</th>"; 
        //echo "<th>CID</th><th>DOC#</th>"; 
        echo "<th>Input Remarks</th>"; 
        echo "<th>Input Job No No</th><th>Cut No</th><th>Size</th><th>Input</th><th>Output</th><th>Rejected</th><th>Balance</th></tr>"; 
             
        $toggle=0; 
        $sql="select * from $bai_pro3.ims_log where ims_mod_no=$module_ref order by tid"; 
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error2.1".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row=mysqli_fetch_array($sql_result)) 
        { 
            $rand_track=$sql_row['rand_track'];
            $ims_size=$sql_row['ims_size'];
            $ims_size2=substr($ims_size,2);
            $title_size='title_size_'.$size_code;
            $input_job_rand_no_ref=$sql_row['input_job_rand_no_ref'];
            $ims_style=$sql_row['ims_style'];
            $ims_schedule=$sql_row['ims_schedule'];
            $ims_color=$sql_row['ims_color'];
            $ims_remarks=$sql_row['ims_remarks']; 


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
            $sql12="select req_date from $bai_pro3.ims_exceptions where ims_rand_track=$rand_track"; 
           // mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2.2".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row12=mysqli_fetch_array($sql_result12)) 
            { 
                $req_date=$sql_row12['req_date']; 
            } 
             
            $sql12="select * from $bai_pro3.ims_log where ims_mod_no=$module_ref and rand_track=$rand_track and ims_status<>\"DONE\" order by ims_schedule, ims_size DESC"; 
           // mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2.3".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row12=mysqli_fetch_array($sql_result12)) 
            { 
                 
                $ims_doc_no=$sql_row12['ims_doc_no']; 
				$ims_size=$sql_row12['ims_size'];
				$ims_size2=substr($ims_size,2);
                $inputjobno=$sql_row12['input_job_no_ref'];
				
                $sql22="select * from $bai_pro3.plandoc_stat_log where doc_no=$ims_doc_no and a_plies>0"; 
                //mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error2.4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                while($sql_row22=mysqli_fetch_array($sql_result22)) 
                { 
                    $order_tid=$sql_row22['order_tid']; 
                     
                    $sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\""; 
                    $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error2.5".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row33=mysqli_fetch_array($sql_result33)) 
                    { 
                        $color_code=$sql_row33['color_code']; //Color Code 
                    } 
                    $cutno=$sql_row22['acutno']; 
                } 
     
                 $size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link);

    
                 $sql33="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where qms_schedule=".$ims_schedule." and qms_color=\"".$ims_color."\" and input_job_no=\"".$input_job_rand_no_ref."\" and qms_style=\"".$ims_style."\" and qms_remarks=\"".$ims_remarks=$sql_row['ims_remarks']."\" and qms_size=\"".strtoupper($size_value)."\" and operation_id='130'";  
                // echo $sql33;  
                  $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error888".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($sql_row33=mysqli_fetch_array($sql_result33))
                  {
                    $rejected=0;
                    $rejected=$sql_row33['rejected']; 
                  }
                 
                echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>"; 
                 
                if($sql_row12['ims_remarks']!="SAMPLE" and $sql_row12['ims_pro_qty']==0 ) 
                { 
                    echo "<input type=\"radio\" name=\"radio\" value=\"".$sql_row12['tid']."\">"; 
                } 
                else 
                { 
                    echo "N/A"; 
                } 
                     
                //$size_value=ims_sizes($order_tid,'','','',substr($sql_row12['ims_size'],2),$link); 
				$size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link);
                     
                echo "</td><td>".$sql_row12['ims_date']."</td><td>$req_date</td><td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td>"; 
                echo "<td>".$sql_row12['ims_remarks']."</td>"; 
//echo "<td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td>"; 
echo "<td>"."J".$inputjobno."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".strtoupper($size_value)."</td><td>".$sql_row12['ims_qty']."</td><td>".$sql_row12['ims_pro_qty']."</td><td>".$rejected."</td><td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']+$rejected))."</td></tr>"; 
            } 
        } 
        echo "</table>"; 
/*         
        $username_list=explode('\\',$_SERVER['REMOTE_USER']); 
    $username=strtolower($username_list[1]); 

    $sql="select * from menu_index where list_id=283"; 
    $result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error()); 
    while($row=mysql_fetch_array($result)) 
    { 
        $users=$row["auth_members"]; 
    } 

    $auth_users=explode(",",$users); 
*/     

        if(in_array($authorized,$has_permission))         
        {   
         echo "&nbsp;<input  title='click to remove the Input' type='radio' name = 'option' Id='option' value='input_remove'  > Input Remove"; 
         
        } 
/*         
        $username_list=explode('\\',$_SERVER['REMOTE_USER']); 
    $username=strtolower($username_list[1]); 

    $sql="select * from menu_index where list_id=285"; 
    $result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error()); 
    while($row=mysql_fetch_array($result)) 
    { 
        $users=$row["auth_members"]; 
    } 

    $auth_cut_users=explode(",",$users); 
*/ 
        if(in_array($authorized,$has_permission))
        { 
             
            echo "&nbsp;<input  title='click to transfer the input' type='radio' name = 'option' Id='option' value='input_transfer'> Input Transfer"; 
        } 
             
            echo '&nbsp;&nbsp;<input type="submit" name="submit" value=" Unlock"> 
                <input type="hidden" value="'.$module_ref.'" name="module"> 
                <input type="hidden" value="'.$section_id.'" name="section_ids">'; 
         
?> 


</form> 

<!-- <h3>Request for Special Input</h3> 
<form name="test_input" method="post" action="special_input.php"> 
<input type="hidden" name="module" value="<?php echo $module_ref;  ?>"> 
<input type="hidden" name="section" value="<?php echo $section_id;  ?>"> 

<input type="submit" name="spreq" value="Create Special Input Box">  -->


</form> 

<br/> 

<?php 
//First cut will be excempted and total input can be reported to module, based on the global value. 
if($input_excess_cut_as_full_input==1) 
{ 
?> <!-- 
    <h3 style="cursor: pointer; color:RED;" onclick="window.location='../ims_allsizes_zero.php?inremark=EXCESS&module=<?php echo $_GET['module']; ?>'">Click here to Report Excess Cut Panel Input</h3> 

    <h3 style="cursor: pointer; color: BLUE;" onclick="window.location='../ims_allsizes_zero.php?inremark=SAMPLE&module=<?php echo $_GET['module']; ?>'">Click here to Report SAMPLE ROOM Cut Panel Input</h3>  -->
<?php 
} 
else 
{ 

?> 
<?php 
/* 
    $username_list=explode('\\',$_SERVER['REMOTE_USER']); 
    $username=strtolower($username_list[1]); 

    $sql="select * from menu_index where list_id=286"; 
    $result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error()); 
    while($row=mysql_fetch_array($result)) 
    { 
        $users=$row["auth_members"]; 
    } 

    $auth_users=explode(",",$users); 
*/ 
        if(in_array($authorized,$haspermission))         
        { 

?> 
<!-- <h3 style="cursor: pointer; color: BLUE;" onclick="window.location='../ims_allsizes.php?inremark=SAMPLE&module=<?php echo $_GET['module']; ?>'">Click here to Report SAMPLE ROOM Cut Panel Input</h3>  -->
<?php 
} 
?> 

<?php 
} 
?> 

</body> 
</html> 