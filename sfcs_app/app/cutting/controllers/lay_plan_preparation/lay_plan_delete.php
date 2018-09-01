<!-- 
Ticket# 365867 
Date:2014-01-22 
Task: LayPlan Deletion Validation Enhancement 
Action : Taken the Order Tid instead of Schedule No for validate the query. 

Ticket# 761746 
Date: 2014-01-29 
Task: Lay Plan Delettion Validation (added IMS and Cut Completion Status) 
--> 

<?php    
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
$layplanmail = $conf1->get('layplanmail'); 
//var_dump($layplanmail);
// include("header.php"); 
?> 
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php 

function echo_title($table_name,$field,$compare,$key,$link) 
{ 
    $sql="select $field as result from $table_name where $compare='$key'"; 
    //echo "1$".$sql."<br>"; 
    $sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        return $sql_row['result']; 
        //echo $sql_row['result']."<br>"; 
    } 
    ((mysqli_free_result($sql_result) || (is_object($sql_result) && (get_class($sql_result) == "mysqli_result"))) ? true : false); 
} 

?> 
<html> 
<title>Lay Plan Delete</title> 
<head> 
<script> 

var flag = 0;

function firstbox(){ 
    var format = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    var schedule = document.getElementById('schedule');
        if( format.test(schedule.value) ){
            sweetAlert('No special Characters Allowed','','warning');
            schedule.value = '';
            return;
        }else{
            window.location.href ="index.php?r=<?php echo $_GET['r']?>"+"&schedule="+schedule.value;
        }
} 

function secondbox() { 
    window.location.href ="index.php?r=<?php echo $_GET['r']?>"+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
} 

function verify_sch(){  
    if(document.getElementById('schedule').value == '')
        sweetAlert('Please Enter Schedule','','warning');
}

function myfunction () 
{ 
    var val=document.getElementById('reason_code').value; 
    var val1=document.getElementById('schedule').value; 
    if(val1.length < 1){
        sweetAlert('Please fill the Schedule','','warning'); 
        return false; 
    }
    //alert(val.length); 
    if(val.length<5 || val1.length<=5) 
    { 
        sweetAlert('Please enter valid Reason','','warning'); 
        return false; 
    } 
     
} 
</script> 
<link href="style.css" rel="stylesheet" type="text/css" /> 
<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> 
</head> 

<body> 
<div class="panel panel-primary">
<div class="panel-heading">Lay Plan - Deletion Form</div> 
<div class="panel-body">
<?php 
    if(isset($_GET['schedule'])) 
    { 
        $schedule=$_GET['schedule'];  
        if(isset($_GET['color'])=='') 
        { 
            $color=''; 
        } 
        else 
        { 
            $color=$_GET['color']; 
        } 
    }     
    elseif(isset($_POST['schedule'])) 
    { 
        $schedule=$_POST['schedule'];  
        $color=$_POST['color']; 
        
    } 
    else 
    { 
    $schedule='';  
    $color=''; 

    } 
    

    ?> 
    
    <form name="test" action="index.php?r=<?php echo $_GET['r'];?>" method="post" onsubmit= "return myfunction();">
    <div class="col-sm-12">
    <div class="row">
    <div class="col-sm-3">Enter Schedule 
    <input type="text" class="form-control input-sm integer" name="schedule" id='schedule' onblur="firstbox();" size=8 value="<?php  if(isset($_POST['schedule'])) { echo $_POST['schedule']; } elseif(isset($_GET['schedule'])) { echo $_GET['schedule']; } ?>"></td></div>
            

    <?php 

    echo "<div class=\"col-sm-3\">Select Color: <select class=\"form-control\" name=\"color\" onclick='verify_sch()' onchange=\"secondbox();\" >"; 
    echo "<option value='' selected disabled>Select Color</option>"; 

    //$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log) and order_style_no=\"$style\" and order_del_no=\"$schedule\""; 
    //if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != ''))  
    //{ 
        $sql="select distinct order_col_des from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" and order_joins='0'";
		//echo $sql;
    //} 
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_num_check=mysqli_num_rows($sql_result); 

    if($schedule>0) 
    { 
        if($sql_num_check>0) 
        {     
            while($sql_row=mysqli_fetch_array($sql_result)) 
            { 

            if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color)) 
            { 
                echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>"; 
            } 
            else 
            { 
                echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>"; 
            } 

            } 
        } 
    } 


    echo "</select></div>"; 
?> 
<div class = "col-sm-3">Enter Reason<input type="text" class ="form-control input-sm" name="reason" id='reason_code' size=15 value="<?php  if(isset($_POST['reason'])) { echo $_POST['reason']; } else { echo ""; } ?>"/><span style='font-size:10px;color:#ff0000'>Please enter 8-16 characters</span></div><br/>
<div class = "col-sm-3"><input type="submit" class = "btn btn-primary" value="Delete" id="submit" name="submit" /></div>
</form> 
</div></div>
</div>
</div>
</body> 
<?php  
if(isset($_POST["submit"])) 
{ 
    $schedule=$_POST["schedule"];     
    $color=$_POST["color"];     
    $reason=$_POST["reason"];     
    $date=date("Y-m-d h:i:sa"); 
    $j=0;$check=0;$check_a=0;$check_c=0;$check_m=0;$check_oc=0; 
    $order_tid=array(); 
    $schedule_no=array(); 
    $col_desc=array(); 
    $order_det=array(); 
    $order_det_suc=array(); 
    //echo $schedule."---".$color."<br>"; 
    //Ticket# 365867/Date:2014-01-22/Task: LayPlan Deletion Validation Enhancement/Action:Taken the Order Tid instead of Schedule No for validate the query. 
    if($color!='0' || $color!='0') 
    {   
        $sql73="select *,order_tid as otid from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" and order_col_des=\"$color\" and order_joins='0'"; 
    } 
    else 
    { 
        $sql73="select *,order_tid as otid from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\" order_joins='0'"; 
    } 
    //echo $sql73."<br>"; 
    $result73=mysqli_query($link, $sql73) or die("Error=71".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row73=mysqli_fetch_array($result73)) 
    { 
        $order_tid[]=$row73["otid"]; 
        $schedule_no[]=$row73["order_del_no"]; 
        $col_desc[]=$row73["order_col_des"]; 
        $order_joins[]=$row73["order_joins"]; 
    } 
    for($i=0;$i<sizeof($order_tid);$i++) 
    { 
        $check+=echo_title("plandoc_stat_log","count(*)","order_tid",$order_tid[$i],$link); 
        $check_a+=echo_title("allocate_stat_log","count(*)","order_tid",$order_tid[$i],$link); 
        $check_c+=echo_title("cuttable_stat_log","count(*)","order_tid",$order_tid[$i],$link); 
        $check_m+=echo_title("maker_stat_log","count(*)","order_tid",$order_tid[$i],$link); 
        $check_oc+=echo_title("bai_orders_db_confirm","count(*)","order_tid",$order_tid[$i],$link); 
    } 
     
    $mini_orders=0; 
    $schedule_id=0; 
	$sql_s="select id from $brandix_bts.tbl_orders_master where product_schedule=".$schedule." limit 1"; 
	$result_s=mysqli_query($link, $sql_s) or die("Error=s".mysqli_error($GLOBALS["___mysqli_ston"])); 
	if(mysqli_num_rows($result_s) > 0) 
	{ 
		while($roww1=mysqli_fetch_array($result_s)) 
		{ 
			$schedule_id=$roww1['id']; 
		} 
		$sql_sid="select id from $brandix_bts.tbl_min_ord_ref where ref_crt_schedule=".$schedule_id.""; 
		$result_sid=mysqli_query($link, $sql_sid) or die("Error=s".mysqli_error($GLOBALS["___mysqli_ston"])); 
		if(mysqli_num_rows($result_sid) > 0) 
		{ 
			while($roww2=mysqli_fetch_array($result_sid)) 
			{ 
				$m_ref_id=$roww2['id']; 
			} 
			$sql_mid="select * from $brandix_bts.tbl_miniorder_data where mini_order_ref=".$m_ref_id.""; 
			$result_mid=mysqli_query($link, $sql_mid) or die("Error=s".mysqli_error($GLOBALS["___mysqli_ston"])); 
			$mini_orders=mysqli_num_rows($result_mid); 
		} 
		else 
		{ 
			$mini_orders=0; 
		}         
	} 
	else 
	{ 
		$mini_orders=0; 
		$schedule_id=0; 
	}
    if($mini_orders>0) 
    { 
        echo "<h2>Already Sewing Orders Generated ...!</h2>"; 
		echo "<h2>Please delete Sewing Orders and try again...!</h2>"; 
    } 
    else 
    { 
		if($check>0 || $check_a>0 || $check_c>0 || $check_m>0 || $check_oc>0) 
        {              
            for($i=0;$i<sizeof($order_tid);$i++) 
            { 
                //echo $order_tid."<br>";
                $sql71="SELECT * from $bai_pro3.pac_stat_log where status=\"DONE\" and doc_no in (select doc_no from $bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid[$i]."\")"; 
                //echo $sql71."<br>"; 
                $result71=mysqli_query($link, $sql71) or die("Error=71".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $row71=mysqli_num_rows($result71); 
                //echo $sql71."<br>"; 
                //echo $row71."<br>"; 
                 
                $sql72="SELECT * from $bai_pro3.plandoc_stat_log where act_cut_status=\"DONE\" and order_tid=\"".$order_tid[$i]."\""; 
                $result72=mysqli_query($link, $sql72) or die("Error=72".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $row72=mysqli_num_rows($result72); 
                //echo $sql72."<br>"; 
                //echo $row72."<br>"; 
                 
                $sql73="SELECT * from $bai_pro.bai_log where delivery='$schedule'"; 
                $result73=mysqli_query($link, $sql73) or die("Error=73".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $row73=mysqli_num_rows($result73); 
                //echo $sql73."<br>"; 
                //echo $row73."<br>"; 
                 
                $sql74="SELECT * from $bai_pro3.plandoc_stat_log where order_tid =\"".$order_tid[$i]."\" and act_cut_status=\"DONE\""; 
                $result74=mysqli_query($link, $sql74) or die("Error=74".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $row74=mysqli_num_rows($result74);     
                //echo $sql74."<br>"; 
                //echo $row74."<br>"; 

                if($row71 == 0 and $row72==0 and $row73==0 and $row74==0) 
                { 
                    $sql33="select doc_no from $bai_pro3.plandoc_stat_log where order_tid='".$order_tid[$i]."'"; 
                    $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row33=mysqli_fetch_array($sql_result33)) 
                    { 
                        //M3 Reversal 
                        //M3 Bulk operation reversal 
                        //To update M3 Bulk Upload Tool (To pass negative entry) 
                        $sql2m3="insert into $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,sfcs_qty,sfcs_reason,sfcs_log_user,sfcs_status,m3_mo_no,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref) select NOW(),sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,m3_size,sfcs_doc_no,(sfcs_qty*-1),sfcs_reason,USER(),0,m3_mo_no,m3_op_code,sfcs_job_no,sfcs_mod_no,sfcs_shift,m3_op_des,sfcs_tid_ref from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_doc_no=".$sql_row33['doc_no']." AND m3_op_des='LAY' and sfcs_reason='' and left(sfcs_job_no,1)<>'R' and sfcs_qty>0"; 
                        mysqli_query($link, $sql2m3) or die("Sql error".$sql2m3.mysqli_errno($GLOBALS["___mysqli_ston"]));     
                    } 
                    $sql1="update bai_orders_db set order_no=0 where order_tid=\"".$order_tid[$i]."\""; 
                    mysqli_query($link, $sql1) or die("Error=11".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    //echo $sql1."<br>"; 

                    $sql_orders_db="select * from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid[$i]."\"";
                    $sql_result_orders_db=mysqli_query($link, $sql_orders_db) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row=mysqli_fetch_array($sql_result_orders_db))
                    {   
                        //updating old order quantites to new order quantites, dont worry about the lables
                        $update="update $bai_pro3.bai_orders_db set order_s_s01=\"$sql_row['old_order_s_s01']\",order_s_s02=\"$sql_row['old_order_s_s02']\",order_s_s03=\"$sql_row['old_order_s_s03']\",order_s_s04=\"$sql_row['old_order_s_s04']\",order_s_s05=\"$sql_row['old_order_s_s05']\",order_s_s06=\"$sql_row['old_order_s_s06']\",order_s_s07=\"$sql_row['old_order_s_s08']\",order_s_s08=\"$sql_row['old_order_s_s08']\",order_s_s09=\"$sql_row['old_order_s_s09']\",order_s_s10=\"$sql_row['old_order_s_s10']\",order_s_s11=\"$sql_row['old_order_s_s11']\",order_s_s12=\"$sql_row['old_order_s_s12']\",order_s_s13=\"$sql_row['old_order_s_s13']\",order_s_s14=\"$sql_row['old_order_s_s14']\",order_s_s15=\"$sql_row['old_order_s_s15']\",order_s_s16=\"$sql_row['old_order_s_s16']\",order_s_s17=\"$sql_row['old_order_s_s17']\",order_s_s18=\"$sql_row['old_order_s_s18']\",order_s_s19=\"$sql_row['old_order_s_s19']\",order_s_s20=\"$sql_row['old_order_s_s20']\",order_s_s21=\"$sql_row['old_order_s_s21']\",order_s_s22=\"$sql_row['old_order_s_s22']\",order_s_s23=\"$sql_row['old_order_s_s23']\",order_s_s24=\"$sql_row['old_order_s_s24']\",order_s_s25=\"$sql_row['old_order_s_s25']\",order_s_s26=\"$sql_row['old_order_s_s26']\",order_s_s27=\"$sql_row['old_order_s_s27']\",order_s_s28=\"$sql_row['old_order_s_s28']\",order_s_s29=\"$sql_row['old_order_s_s29']\",order_s_s30=\"$sql_row['old_order_s_s30']\",order_s_s31=\"$sql_row['old_order_s_s31']\",order_s_s32=\"$sql_row['old_order_s_s32']\",order_s_s33=\"$sql_row['old_order_s_s33']\",order_s_s34=\"$sql_row['old_order_s_s34']\",order_s_s35=\"$sql_row['old_order_s_s35']\",order_s_s36=\"$sql_row['old_order_s_s36']\",order_s_s37=\"$sql_row['old_order_s_s37']\",order_s_s38=\"$sql_row['old_order_s_s38']\",order_s_s39=\"$sql_row['old_order_s_s39']\",order_s_s40=\"$sql_row['old_order_s_s40']\",order_s_s41=\"$sql_row['old_order_s_s41']\",order_s_s42=\"$sql_row['old_order_s_s42']\",order_s_s43=\"$sql_row['old_order_s_s43']\",order_s_s44=\"$sql_row['old_order_s_s44']\",order_s_s45=\"$sql_row['old_order_s_s45']\",order_s_s46=\"$sql_row['old_order_s_s46']\",order_s_s47=\"$sql_row['old_order_s_s47']\",order_s_s48=\"$sql_row['old_order_s_s48']\",order_s_s49=\"$sql_row['old_order_s_s49']\",order_s_s50=\"$sql_row['old_order_s_s50']\" where order_tid=\"".$order_tid[$i]."\"";
                        
                        mysqli_query($link, $update) or die("quantites not updated".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                     
                    $sql8="select doc_no from $bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid[$i]."\""; 
                    $result8=mysqli_query($link, $sql8) or die("Error=8".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    //echo $sql8."<br>"; 
                    $row8=mysqli_num_rows($result8); 
                    if($row8 > 0) 
                    { 
                        $sql7="delete from $bai_pro3.pac_stat_log where doc_no in (select doc_no from $bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid[$i]."\")"; 
                        mysqli_query($link, $sql7) or die("Error=7".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        //echo $sql7."<br>"; 
                         
                        $sql9="delete from $bai_pro3.plan_dashboard where doc_no in (select doc_no from $bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid[$i]."\")"; 
                        mysqli_query($link, $sql9) or die("Error=9".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        //echo $sql9."<br>"; 
                         
                        $sql121="insert ignore into $bai_pro3.lay_plan_delete_track(tid,schedule_no,col_desc,reason,log_time,username) values('$order_tid[$i]','$schedule_no[$i]','$col_desc[$i]','$reason','$date','$username')";
						//echo $sql121;
                        mysqli_query($link, $sql121) or die("Error=121".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        //echo $sql121."<br>"; 
                    } 

                    $sql2="delete from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid[$i]."\""; 
                    mysqli_query($link, $sql2) or die("Error=2".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    // echo $sql2."<br>"; 
                     
                    $sql3="delete from $bai_pro3.cuttable_stat_log where order_tid=\"".$order_tid[$i]."\""; 
                    mysqli_query($link, $sql3) or die("Error=3".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    // echo $sql3."<br>"; 
                     
                    $sql4="delete from $bai_pro3.allocate_stat_log where order_tid=\"".$order_tid[$i]."\""; 
                    mysqli_query($link, $sql4) or die("Error=4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    // echo $sql4."<br>"; 
                     
                    $sql5="delete from $bai_pro3.maker_stat_log where order_tid=\"".$order_tid[$i]."\""; 
                    mysqli_query($link, $sql5) or die("Error=5".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    // echo $sql5."<br>"; 
                     
                    $sql7="update $bai_pro3.cat_stat_log set clubbing=0,category='',purwidth=0,gmtway='',patt_ver='' where order_tid=\"".$order_tid[$i]."\""; 
                    mysqli_query($link, $sql7) or die("Error=7".mysqli_error($GLOBALS["___mysqli_ston"]));  
                    // echo $sql7."<br>"; 
                     
                    if($schedule_id!=0) 
                    { 
                       // $docket_t=array();
                        $sql88="select * from $bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid[$i]."\"";
                        $result88=mysqli_query($link, $sql88) or die("Error=8".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        // echo $sql88."<br>"; 
                        if(mysqli_num_rows($result88)>0) 
                        { 
                            $sql881="select GROUP_CONCAT(doc_no) as doc_no from $bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid[$i]."\""; 
							$result88=mysqli_query($link, $sql881) or die("Error=8".mysqli_error($GLOBALS["___mysqli_ston"])); 
							while($row88=mysqli_fetch_array($result88)) 
                            { 
								//echo $row88['doc_no'];
                               $docket_t =$row88['doc_no']; 
                            } 
							$dockets = $docket_t;
                           // $dockets=explode(",", $docket_t); 
							// var_dump($dockets);
                            // echo $dockets.'<br>';
                            $sql102="delete from $brandix_bts.tbl_cut_size_master where parent_id in (select id from $brandix_bts.tbl_cut_master where doc_num in (".$dockets."))"; 
                            // echo $sql102."<br>"; 
                            mysqli_query($link, $sql102) or die("Error=121".mysqli_error($GLOBALS["___mysqli_ston"])); 
                           
                            $sql103="delete from $brandix_bts.tbl_cut_master where doc_num in (".$dockets.")"; 
                            // echo $sql103."<br>";
                            mysqli_query($link, $sql103) or die("Error=121".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            
                            $sql101="delete from $brandix_bts.tbl_orders_sizes_master where parent_id=".$schedule_id." and order_col_des='".$col_desc[$i]."'"; 
                            // echo $sql101."<br>"; 
                            mysqli_query($link, $sql101) or die("Error=121".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            
                        }     
                                         
                    } 
                    //echo gethostname."<br>"; 
                     
                    $sql6="delete from $bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid[$i]."\""; 
                    mysqli_query($link, $sql6) or die("Error=6".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    //echo $sql6."<br>"; 
                     
                    $j++; 
                    $order_det_suc[]=$order_tid[$i]; 
                    //MAIL 
                    //echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow() { window.open('','_self',''); window.close(); }  </script>"; 
                } 
                else 
                { 
                    $order_det[]=$order_tid[$i]; 
                    //echo "<h2>Cartons Already Scanned For This Schedule# $schedule. System can't delete the Lay Plan.</h2>"; 
                } 
            } 
            if($j>0) 
            { 
				for($k=0;$k<sizeof($order_det_suc);$k++) 
				{ 
					if($k==0) 
					{ 
						echo "<div class=\"col-sm-12\" style=\"color: #33CC33\"><b><h2>Successfully Deleted Lay Plan For below Colors:</h2></b></div>"."<br>";
					}
					echo "<div class=\"row\">";
					echo "<div class=\"col-sm-4\">";
					echo "<div class=\"col-sm-12\">";
					echo "<table class=\"table table-bordered\">";    
					echo "<tr><td class=\"  \">".($k+1)."</td><td class=\"  \">".$order_det_suc[$k]."</td></tr>";
					echo "</table>";
					echo "</div></div></div>";
				}             
				//echo "<h2>Lay Plan Successfully Deleted</h2>"."<br>"; 
				$message="Dear All,<br/><br/>sch# $schedule Lay Plan has been deleted on $date.<br><br>"; 
				$message.="Finishing Team in reading: Please regenerate the Packing list for mentioned schedule.<br><br>"; 
				$message.="Planning Team in reading: Please reorganize your dashboard.<br><br>"; 
				$message.="Reason: ".$_POST['reason']."<br><br>"; 
				$message.="Lay Plan Deleted By : $username"; 
				 
				//if(strtolower($_SERVER['SERVER_NAME'])=="bainet") 
				//{ 
					//$plant_name="BAI-1"; 
					$to  = $layplanmail; 
				//}                    
				// subject 
				$subject = 'Lay Plan Deletion In SFCS'; 
				//$to  = 'brandixalerts@schemaxtech.com, brandixalerts@schemaxtech.com , brandixalerts@schemaxtech.com'; 
				// To send HTML mail, the Content-type header must be set 
				$headers  = 'MIME-Version: 1.0' . "\r\n"; 
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

				// Additional headers 
				//$headers .= 'To: <BAIPlanningTeam@brandix.com>; <BAIManufacturingTeam@brandix.com>; <baiieteam@brandix.com>'. "\r\n"; 
				//$headers .= 'To: '.$to."\r\n"; 
				$headers .= 'From: Shop Floor System Alert <ictsysalert@brandix.com>'. "\r\n"; 
				//$headers .= 'Cc: YasanthiN@brandix.com' . "\r\n"; 

				// Mail it 
				//mail($to, $subject, $message, $headers); 
            } 
            if(sizeof($order_det)>0) 
            { 
                echo "<h2>Can you Please Check Below Criterias for Lay Plan Not Deleted.</h2>"; 
                echo "<h3>1.Fabric Issued To Production.</h3>"; 
                echo "<h3>2.Cutting Completed.</h3>"; 
                echo "<h3>3.Output Reported.</h3>"; 
                echo "<h3>4.Carton's Scanned.</h3>"; 
                 
                for($k=0;$k<sizeof($order_det);$k++) 
                { 
                    echo ($k+1).".  ".$order_det[$k]."<br>"; 
                } 
                 
            } 
        } 
        else 
        { 
            echo "<div class=\"col-sm-12\" style=\"color: #ff0000\"><h2>Selected color not exists in the data. Please select another color.</h2></div>"; 
        } 
    }     
}     

?> 
<script> 
    document.form.button.value="Delete"; 
    document.form.button.disable=false; 
</script> 
</html>