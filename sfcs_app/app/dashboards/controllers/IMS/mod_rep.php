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

$auth_users=array("rameshk","chathurangad","dinushapre","$username"); 
//access for power user to remove the input 
//$auth_cut_users=user_acl("SFCS_0203",$username,22,$group_id_sfcs);  
$auth_cut_users=array("rameshk","chathurangad","dinushapre","$username"); 
//access for super user to report the sample room for cut panel input 
//$auth_users_for_sample_cut_input=user_acl("SFCS_0203",$username,33,$group_id_sfcs); 
$auth_users_for_sample_cut_input=array("rameshk","chathurangad","dinushapre","$username"); 
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

<form name="test" action="mod_rep.php" method="post"> 
<?php 
        if($_GET['module']){
          $module=$_GET['module']; 
        }else{
        $module=$_POST['module']; 
        }
        if($_GET['section_id']){
                $section_id=$_GET['section_id']; 

        }else{
                $section_id=$_POST['section_id']; 

        }
       
        //echo "<h2>Module - $module_ref Summary</h2>"; 
        echo '<div id="page_heading"><span style=""><h3>Module - '.$module.' Summary</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>'; 
        echo '<table style="color:black; border: 1px solid red;">'; 
        echo "<tr class=\"new\"><th>Select</th><th>Input Date</th><th>Exp. to Comp.</th><th>Style</th><th>Schedule</th><th>Color</th>"; 
        //echo "<th>CID</th><th>DOC#</th>"; 
        //echo "<th>Input Remarks</th>"; 
        echo "<th>Input Job No No</th><th>Cut No</th><th>Size</th><th>Input</th><th>Output</th><th>Rejected</th><th>Balance</th><th>Input Remarks</th></tr>"; 
             
        $toggle=0; 
        $sql="select distinct rand_track,ims_size,ims_schedule,ims_style,ims_color,ims_remarks,input_job_rand_no_ref from $bai_pro3.ims_log where ims_mod_no=$module and ims_doc_no in (select doc_no from bai_pro3.plandoc_stat_log) order by tid"; 

        
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
             
            $sql12="select * from $bai_pro3.ims_log where ims_mod_no=$module and rand_track=$rand_track and ims_status<>\"DONE\" and ims_remarks='$ims_remarks' and ims_size='$ims_size'  order by ims_schedule, ims_size DESC";
            
            //echo $sql12."<br/>";
           // mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2.3".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row12=mysqli_fetch_array($sql_result12)) 
            { 
                $flag++;
                $ims_doc_no=$sql_row12['ims_doc_no']; 
				$ims_size=$sql_row12['ims_size'];
				$ims_size2=substr($ims_size,2);
				$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row12['ims_schedule'],$sql_row12['ims_color'],$sql_row12['input_job_no_ref'],$link);
                // $inputjobno=$sql_row12['input_job_no_ref'];
                $pac_tid=$sql_row12['pac_tid'];

				
                $sql22="select * from $bai_pro3.plandoc_stat_log where doc_no=$ims_doc_no and a_plies>0"; 
                //mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error2.4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                while($sql_row22=mysqli_fetch_array($sql_result22)) 
                { 
                    $order_tid=$sql_row22['order_tid']; 
                    $cutno=$sql_row22['acutno']; 
                } 
     
                 $size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link);

    
                 $sql33="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where qms_schedule=".$ims_schedule." and qms_color=\"".$ims_color."\" and input_job_no=\"".$input_job_rand_no_ref."\" and qms_style=\"".$ims_style."\" and qms_remarks=\"".$sql_row['ims_remarks']."\" and qms_size=\"".strtoupper($size_value)."\" and operation_id='130' and bundle_no=\"".$sql_row12['pac_tid']."\"";  
                 //echo $sql33;  
                  $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error888".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($sql_row33=mysqli_fetch_array($sql_result33))
                  {
                    $rejected=0;
                    $rejected=$sql_row33['rejected']; 
                  }

                   $bundle_qty="select * from $brandix_bts.bundle_creation_data where bundle_number=".$pac_tid." and operation_id='129'";
                   $sql_result56=mysqli_query($link, $bundle_qty) or exit("Sql bundle_qty".mysqli_error($GLOBALS["___mysqli_ston"]));
                      while($sql_row=mysqli_fetch_array($sql_result56))
                      {
                        $orginal_qty=$sql_row['orginal_qty'];
                        $recevied_qty=$sql_row['recevied_qty'];
                      }
                 // var_dump($send_qty);
                 
                echo "<tr bgcolor=\"$tr_color\" class=\"new\"><td>"; 
                 
                if($orginal_qty == $recevied_qty and $sql_row12['ims_pro_qty']==0 ) 
                { 
                    echo "<input type=\"checkbox\" name=\"log_tid[]\"   value=\"".$sql_row12['tid']."\">"; 
                } 
                else 
                { 
                    echo "N/A"; 
                } 
                     
                 echo '<input type="hidden" value="'.$pac_tid.'" name="pac_tid[]">'; 
                     
                echo "</td><td>".$sql_row12['ims_date']."</td><td>$req_date</td><td>".$sql_row12['ims_style']."</td><td>".$sql_row12['ims_schedule']."</td><td>".$sql_row12['ims_color']."</td>"; 
                //echo "<td>".$sql_row12['ims_remarks']."</td>"; 
//echo "<td>".$sql_row12['ims_cid']."</td><td>".$sql_row12['ims_doc_no']."</td>"; 
echo "<td>".$display_prefix1."</td><td>".chr($color_code).leading_zeros($cutno,3)."</td><td>".strtoupper($size_value)."</td><td>".$sql_row12['ims_qty']."</td><td>".$sql_row12['ims_pro_qty']."</td><td>".$rejected."</td><td>".($sql_row12['ims_qty']-($sql_row12['ims_pro_qty']+$rejected))."</td><td>".$sql_row12['ims_remarks']."</td></tr>"; 
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

        // if(in_array($authorized,$has_permission))//input remove radio button         
        // {   
        //  echo "&nbsp;<input  title='click to remove the Input' type='radio' name = 'option' Id='option' value='input_remove'  > Input Remove"; 
         
        // } 
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
*/  echo "</br>";
                 echo "</br>";
    
                  echo "<div class='col-sm-3'><label>Select Module:</label> 
                  <select class='form-control' name=\"module_ref\"  id='module_ref'>";
                  $sqlx="select * from $bai_pro3.sections_db where sec_id>0 order by sec_head ASC";
                  $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $break_counter = 0;
                  while($sql_rowx=mysqli_fetch_array($sql_resultx))     //section Loop -start
                  {
                    $break_counter++;
                    
                    $section=$sql_rowx['sec_id'];
                    $section_head=$sql_rowx['sec_head'];
                    $section_mods=$sql_rowx['sec_mods']; 
                    
                    $mods=array();
                    $mods=explode(",",$section_mods);
                 

                  for($x=0;$x<sizeof($mods);$x++)
                  {
                    echo "<option value=\"".$mods[$x]."\"  selected>".$mods[$x]."</option>";
                   //$module=$mods[$x];

                  }
                 }
                 echo "  </select>
                 </div>";
                 echo "</br>";
                 echo "</br>";
                  
                    if(in_array($authorized,$has_permission))
                    { 
                         
                        // echo "&nbsp;<input  title='click to transfer the input' type='radio' name = 'option' Id='option' value='input_transfer'> Input Transfer"; 
                     
                         
                        echo '&nbsp;&nbsp;<input type="submit" name="submit" value="Input Transfer"> 
                            <input type="hidden" value="'.$module.'" name="module"> 
                            <input type="hidden" value="'.$section_id.'" name="section_id">'; 
                           
                    }        



?> 


</form> 
</form> 

<br/> 



</body> 
</html> 
<?php

if(isset($_POST['submit']))
{
    $module= $_POST['module'];

    $module_ref= $_POST['module_ref'];
    $tid=array();
  // var_dump($_POST['log_tid']);
   $tid=$_POST['log_tid'];
   foreach($tid as $selected)
   {

    $sql33="update $bai_pro3.ims_log set ims_mod_no = '$module_ref' where tid= '$selected'";
    //echo $sql33;
    $sql_result=mysqli_query($link, $sql33) or exit("Sql Error5123".mysqli_error($GLOBALS["___mysqli_ston"]));


    $sql_ims="select pac_tid from bai_pro3.ims_log where tid='$selected'"; 
    $sql_result123=mysqli_query($link, $sql_ims) or exit("Sql Error_ims".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_rowx=mysqli_fetch_array($sql_result123))  
    { 
      $pac_tid=$sql_rowx['pac_tid'];
    }

    $bund_update="update $brandix_bts.bundle_creation_data set assigned_module ='$module_ref' where bundle_number='$pac_tid'";
    $sql_result1=mysqli_query($link, $bund_update) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 

     $bund_update="update $brandix_bts.bundle_creation_data_temp set assigned_module ='$module_ref' where bundle_number='$pac_tid'";
     $sql_result1=mysqli_query($link, $bund_update) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 



     $sql="select  ims_mod_no, ims_qty,input_job_no_ref,pac_tid from $bai_pro3.ims_log where tid='$selected'"; 
             //echo $sql."<br>";
            
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error455".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $sql331="insert into $brandix_bts.module_bundle_track (user,bundle_number,module,quantity,job_no) values (USER(),\"".$sql_row['pac_tid']."\",". $module_ref.",  \"".$sql_row['ims_qty']."\",\"".$sql_row['input_job_no_ref']."\")";
        //echo $sql331;

        mysqli_query($link, $sql331) or exit("Sql Error_insert".mysqli_error($GLOBALS["___mysqli_ston"]));
     //echo $sql33; 
    } 
   }
echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"mod_rep.php?module=$module\"; }</script>";

}


?>



