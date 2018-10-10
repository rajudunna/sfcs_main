<html xmlns:v="urn:schemas-microsoft-com:vml" 
xmlns:o="urn:schemas-microsoft-com:office:office" 
xmlns:x="urn:schemas-microsoft-com:office:excel" 
xmlns="http://www.w3.org/TR/REC-html40"> 


<head> 
<title>Sewing Job Sheet</title>
<style type="text/css"> 
      #barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 8pt} 
      table {
        table-layout:fixed;
      }
    </style> 
<script src="../../common/js/jquery-1.3.2.js"></script> 
<script src="../../common/js/jquery-barcode-2.0.1.js"></script> 

<?php
    include("../../../../common/config/config.php");
    include("../../../../common/config/functions.php");
    error_reporting(0);

    $ssql122="select serial_no  from  $bai_pro3.`tbl_serial_number` "; 
    $result122=mysqli_query($link, $ssql122) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row122=mysqli_fetch_array($result122)) 
    { 
        $serial_no=$row122["serial_no"];
    } 

    function doc_in_status($link,$result_type,$size,$doc_no,$input_ref) 
    {
        $ret=0; 
         
        switch($result_type) 
        { 
            case 'CUTQTY': 
            { 
                $sql="select (a_$size*a_plies) as cutqty from $bai_pro3.plandoc_stat_log where doc_no=$doc_no"; 
                //echo $sql."<br>"; 
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
                while($sql_row=mysqli_fetch_array($sql_result)) 
                { 
                    $ret=$sql_row['cutqty']; 
                } 
                break; 
            } 
             
            case 'INPUTQTY': 
            { 
                $sql="SELECT COALESCE(SUM(in_qty),0) as input FROM ((SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log_backup WHERE ims_doc_no='$doc_no'  and input_job_rand_no_ref='$input_ref'  and ims_size='a_$size') UNION (SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log WHERE ims_doc_no='$doc_no' and input_job_rand_no_ref='$input_ref' and ims_size='a_$size')) AS tmp";
                //echo $sql."<br>"; 
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
                while($sql_row=mysqli_fetch_array($sql_result)) 
                { 
                    $ret=$sql_row['input']; 
                } 
                break; 
            } 
             
            case 'IMSINPUTQTY': 
            { 
                $sql="SELECT COALESCE(SUM(in_qty),0) as input FROM ((SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log_backup WHERE ims_doc_no='$doc_no'  and ims_size='a_$size') UNION (SELECT SUM(ims_qty) AS in_qty FROM $bai_pro3.ims_log WHERE ims_doc_no='$doc_no' and ims_size='a_$size')) AS tmp"; 
                //echo $sql."<br>"; 
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
                while($sql_row=mysqli_fetch_array($sql_result)) 
                { 
                    $ret=$sql_row['input']; 
                } 
                break; 
            } 
        } 
        return $ret; 
    } 


    $table_name="plan_dashboard_input"; 

    if(isset($_POST["doc"]) or isset($_POST["section"])) 
    { 
        $doc=$_POST["doc"]; 
        $style=$_POST["style"]; 
        $schedule=$_POST["schedule"]; 
        $jobno=$_POST["jobno"]; 
        $module_no=$_POST["moduleno"]; 
        $color=$_POST["color"]; 
        //echo $doc."<br>"; 
    } 
    else 
    { 
        $doc=$_GET["doc_no"]; 
        $style=$_GET["style"]; 
        $schedule=$_GET["schedule"]; 
        $jobno=$_GET["jobno"]; 
        $module_no=$_GET["moduleno"]; 
        $color=$_GET["color"]; 
        //echo $doc."<br>"; 
    } 

    $display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$jobno,$link);
    $ssql12="SELECT COUNT( DISTINCT order_col_des) AS color_count,SUM(carton_act_qty) AS job_tot FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$doc' GROUP BY input_job_no_random"; 
    $result12=mysqli_query($link, $ssql12) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row12=mysqli_fetch_array($result12)) 
    { 
        $job_total_qty=$row12["job_tot"]; 
        $color_count=$row12["color_count"]; 
    } 

    $sql4="select color_code from $bai_pro3.bai_orders_db where order_del_no=\"".$schedule."\"";
    $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row4=mysqli_fetch_array($sql_result4))
    {
        $color_code=$sql_row4["color_code"];
    }

    $ssql15="SELECT * FROM $bai_pro3.plan_dashboard_input WHERE input_job_no_random_ref='$doc'"; 
    // echo $ssql15;     
    $result15=mysqli_query($link, $ssql15) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row15=mysqli_fetch_array($result15)) 
    { 
        $team_number=$row15["input_module"]; 
    } 
    if ($team_number=='')
    {
        $team_number='No Module <br>Assigned';
    }

    $sql1w="select group_concat(distinct order_date) as order_date,group_concat(distinct vpo) as po_no,group_concat(packing_method) as pac from $bai_pro3.bai_orders_db where order_del_no=\"".$schedule."\""; 
    $result1w=mysqli_query($link, $sql1w) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row1w=mysqli_fetch_array($result1w)) 
    { 
        $po_no=$row1w["po_no"]; 
        $del_date=$row1w["order_date"]; 
        $packing_method=$row1w["pac"]; 
    }
 
    $job1_qty=array(); 
    $job1_color=array(); 
    $ssql12="SELECT order_col_des as job_color,SUM(carton_act_qty) AS job_tot FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='$doc' GROUP BY order_col_des,input_job_no_random"; 
    $result12=mysqli_query($link, $ssql12) or exit("Sql Error12.2".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row12=mysqli_fetch_array($result12)) 
    { 
        $job_total=$row12["job_tot"]; 
        $job_color= 
        $job1_qty[]=$row12["job_tot"]; 
        $job1_color[]=$row12["job_color"]; 
    } 

    $destination_list=""; 
    $ssql13="SELECT DISTINCT destination FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random='$doc' GROUP BY input_job_no_random,destination"; 
    //echo $ssql13; 
    $result13=mysqli_query($link, $ssql13) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row13=mysqli_fetch_array($result13)) 
    { 
        $destination_list.=$row13["destination"].","; 
    } 
     
    $ssql14="SELECT GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno FROM $bai_pro3.packing_summary_input WHERE order_del_no = $schedule AND input_job_no_random='$doc'"; 
    // echo $ssql14;
    $result14=mysqli_query($link, $ssql14) or exit("Error while getting Cut Numbers"); 
    while($row14=mysqli_fetch_array($result14)) 
    {
        $cut = $row14['acutno'];
    }

    $total_cuts=explode(",",$cut);
    $cut_jobs_new='';
    for($ii=0;$ii<sizeof($total_cuts);$ii++)
    {
        $arr = explode("$", $total_cuts[$ii], 2);
        $sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$color."'";
        //echo $sql4."<br>";
        $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row4=mysqli_fetch_array($sql_result4))
        {
            $color_code=$sql_row4["color_code"];
        }
        $cut_jobs_new .= chr($color_code).leading_zeros($arr[1], 3).",";
        unset($arr);
    }
    $cut_jobs_new1=substr($cut_jobs_new,0,-1);
    // echo $cut_jobs_new1;
    $ssql33="SELECT order_joins from $bai_pro3.bai_orders_db where order_del_no='$schedule'"; 
    //echo $ssql33; 
    $result33=mysqli_query($link, $ssql33) or exit("Sql Error33".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row33=mysqli_fetch_array($result33)) 
    { 
        $join_sch=$row33["order_joins"]; 
        $join_sch1=$row33["order_joins"]; 
    } 

    if($join_sch1=="0") 
    { 
        $join_sch=$schedule; 
        $org_schs=$schedule; 
    } 
    else if($join_sch1=="1") 
    { 
        $ssql333="SELECT GROUP_CONCAT(order_del_no) as org_schs FROM $bai_pro3.bai_orders_db_confirm WHERE order_joins='j$schedule'"; 
        //echo $ssql333; 
        $result333=mysqli_query($link, $ssql333) or exit("Sql Error333".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($row333=mysqli_fetch_array($result333)) 
        { 
            $org_schs=$row333["org_schs"]; 
            //echo $org_schs; 
        } 
        $join_sch=$schedule."(".$org_schs.")"; 
    } 
    else if($join_sch1=="2") 
    { 
        $ssql333="SELECT GROUP_CONCAT(order_del_no) as org_schs FROM $bai_pro3.bai_orders_db_confirm WHERE order_joins='j$schedule'"; 
        //echo $ssql333; 
        $result333=mysqli_query($link, $ssql333) or exit("Sql Error333".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($row333=mysqli_fetch_array($result333)) 
        { 
            $org_schs=$row333["org_schs"]; 
            //echo $org_schs; 
        } 
        $join_sch=$schedule."(".$org_schs.")"; 
    } 
    else 
    { 
        $ssql333="SELECT GROUP_CONCAT(order_del_no) as org_schs FROM $bai_pro3.bai_orders_db_confirm WHERE order_joins='$join_sch'"; 
        //echo $ssql333; 
        $result333=mysqli_query($link, $ssql333) or exit("Sql Error333".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($row333=mysqli_fetch_array($result333)) 
        { 
            $org_schs=$row333["org_schs"]; 
            //echo $org_schs; 
        } 
        $join_sch=substr($join_sch, 1)."(".$org_schs.")"; 
    } 


?> 
<meta http-equiv=Content-Type content="text/html; charset=windows-1252"> 
<meta name=ProgId content=Excel.Sheet> 
<meta name=Generator content="Microsoft Excel 15"> 
<link rel=File-List href="new_job_sheet3_files/filelist.xml"> 
<!--[if !mso]> 
<style> 
v\:* {behavior:url(#default#VML);} 
o\:* {behavior:url(#default#VML);} 
x\:* {behavior:url(#default#VML);} 
.shape {behavior:url(#default#VML);} 
</style> 
<![endif]--> 
<style id="Copy of Job Wise Garment Reconciliation Sheet (002)_32351_Styles">
table 
    {mso-displayed-decimal-separator:"\."; 
    mso-displayed-thousand-separator:"\,";} 
.font532351 
    {color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0;} 
.font632351 
    {color:white; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0;} 
.font732351 
    {color:black; 
    font-size:7.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0;} 
.xl1532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl6532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl6632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl6732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl6832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl6932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:red; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl7032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl7132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl7232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:red; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl7332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl7432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl7532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl7632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:white; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl7732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl7832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:#BFBFBF; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl7932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border:.5pt solid windowtext; 
    background:#BFBFBF; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl8032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    background:#BFBFBF; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl8132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl8232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl8332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:white; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl8432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl8532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:white; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl8632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl8732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl8832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl8932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl9032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl9132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl9232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl9332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl9432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl9532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl9632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl9732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl9832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl9932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl10032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl10132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl10232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl10332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl10432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl10532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Calibri, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl10632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl10732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl10832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl10932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl11032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal; 
    mso-rotate:90;} 
.xl11132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal; 
    mso-rotate:90;} 
.xl11232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal; 
    mso-rotate:90;} 
.xl11332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal; 
    mso-rotate:90;} 
.xl11432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap; 
    mso-rotate:90;} 
.xl11532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl11632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl11732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap; 
    mso-rotate:90;} 
.xl11832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap; 
    mso-rotate:90;} 
.xl11932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl12032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl12132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap; 
    mso-rotate:90;} 
.xl12232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl12332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl12432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl12532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl12632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl12732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl12832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl12932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yy\;\@"; 
    text-align:left; 
    vertical-align:middle; 
    border:1.0pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl13332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:general; 
    vertical-align:bottom; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"ddd\\-mmm\\-yy\\-h\:mm\\ AM\/PM"; 
    text-align:general; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yy\;\@"; 
    text-align:general; 
    vertical-align:middle; 
    border:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl13932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\@"; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl14032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\@"; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl14132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\@"; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl14232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl14332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl14432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl14532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:none; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl14632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:none; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl14732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl14832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl14932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl15032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl15132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl15232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border:.5pt solid windowtext; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl15332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl15432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl15532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl15632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:#92D050; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl15732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl15832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl15932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl16032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:red; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl16132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\@"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl16232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\@"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl16332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\@"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl16432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl16532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl16632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl16732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl16832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl16932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl17032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl17132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl17232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl17332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl17432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl17532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl17632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl17732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl17832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl17932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl18032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl18132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:top; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl18232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl18332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl18432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl18532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl18632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:white; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl18732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:white; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl18832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    background:white; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl18932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:white; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl19032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl19132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:11.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl19232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl19332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl19432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl19532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl19632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl19732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl19832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl19932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl20032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl20132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl20232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl20332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl20432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl20532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl20632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl20732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:black; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl20832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:0; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl20932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl21032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl21132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl21232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl21332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl21432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl21532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap; 
    mso-rotate:90;} 
.xl21632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap; 
    mso-rotate:90;} 
.xl21732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap; 
    mso-rotate:90;} 
.xl21832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap; 
    mso-rotate:90;} 
.xl21932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl22032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl22132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl22232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl22332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl22432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl22532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl22632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl22732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl22832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:0; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl22932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl23032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl23132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl23232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl23332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:7.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl23432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:7.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl23532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl23632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl23732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl23832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl23932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:20.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:20.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:20.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:20.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl24932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl25032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:Standard; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl25132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:Standard; 
    text-align:left; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl25232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl25332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl25432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl25532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yy\;\@"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl25632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yy\;\@"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl25732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:0; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl25832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:0; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl25932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"ddd\\-mmm\\-yy\\-h\:mm\\ AM\/PM"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl26032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"ddd\\-mmm\\-yy\\-h\:mm\\ AM\/PM"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl26132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl26232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl26332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl26432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:0; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl26532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl26632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl26732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl26832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:#ffffff; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl26932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl27032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal; 
    mso-rotate:90;} 
.xl27132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal; 
    mso-rotate:90;} 
.xl27232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl27332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl27432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl27532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl27632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl27732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl27832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl27932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl28032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yy\;\@"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:#ffffff; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl28132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yy\;\@"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl28232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:windowtext; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"\[ENG\]\[$-409\]d\\-mmm\\-yy\;\@"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl28332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"dd\\-mmm\\-yy\\-h\:mm\\ AM\/PM"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl28432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"dd\\-mmm\\-yy\\-h\:mm\\ AM\/PM"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl28532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:"dd\\-mmm\\-yy\\-h\:mm\\ AM\/PM"; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl28632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl28732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl28832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl28932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl29032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl29132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl29232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl29332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl29432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl29532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:12.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl29632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:12.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl29732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:12.0pt; 
    font-weight:700; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    background:#A6A6A6; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl29832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-diagonal-down:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl29932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-diagonal-down:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl30032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    mso-diagonal-down:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl30132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    mso-diagonal-down:.5pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:normal;} 
.xl30232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:1.0pt solid windowtext; 
    border-left:1.0pt solid windowtext; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl30332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:.5pt solid windowtext; 
    border-bottom:1.0pt solid windowtext; 
    border-left:none; 
    background:#D9D9D9; 
    mso-pattern:black none; 
    white-space:nowrap;} 
.xl30432351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:.5pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl30532351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:10.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:middle; 
    border-top:.5pt solid windowtext; 
    border-right:none; 
    border-bottom:.5pt solid windowtext; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl30632351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:top; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl30732351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:top; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl30832351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:top; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl30932351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:left; 
    vertical-align:top; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl31032351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:normal;} 
.xl31132351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:1.0pt solid windowtext; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl31232351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:none; 
    border-bottom:none; 
    border-left:1.0pt solid windowtext; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
.xl31332351 
    {padding:0px; 
    mso-ignore:padding; 
    color:black; 
    font-size:8.0pt; 
    font-weight:400; 
    font-style:normal; 
    text-decoration:none; 
    font-family:Arial, sans-serif; 
    mso-font-charset:0; 
    mso-number-format:General; 
    text-align:center; 
    vertical-align:bottom; 
    border-top:none; 
    border-right:1.0pt solid windowtext; 
    border-bottom:none; 
    border-left:none; 
    mso-background-source:auto; 
    mso-pattern:auto; 
    white-space:nowrap;} 
</style> 
</head> 
<center><button onClick="printdiv('print_this');">Print Job Sheet</button></center>

<script>
function printdiv(printpage) {
    // window.print();
    var headstr = "<html><head><title></title></head><body>";
    var footstr = "</body>";
    var newstr = document.all.item(printpage).innerHTML;
    var oldstr = document.body.innerHTML;
    document.body.innerHTML = headstr+newstr+footstr;
    window.print();
    document.body.innerHTML = oldstr;
    return false;
}
</script>
<?php
    $hourly_sewing_out_count = "SELECT *,count(*) as count1 FROM $bai_pro3.`tbl_plant_timings`";
    $hourly_sewing_out_count_result=mysqli_query($link, $hourly_sewing_out_count) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row11=mysqli_fetch_array($hourly_sewing_out_count_result)) 
    { 
        $count_tot =$sql_row11['count1'];
    } 
?>
<body>
<div id="print_this" align=center x:publishsource="Excel"> 

<table border=0 cellpadding=0 cellspacing=0 width=1390 class=xl6532351  style='border-collapse:collapse;table-layout:fixed;width:1046pt'> 
 <col class=xl6532351 width=89 style='mso-width-source:userset;mso-width-alt:  3254;width:67pt'> 
 <col class=xl6532351 width=2 style='mso-width-source:userset;mso-width-alt:  73;width:2pt'> 
 <col class=xl6532351 width=59 span=2 style='mso-width-source:userset;  mso-width-alt:2157;width:44pt'> 
 <col class=xl6532351 width=45 span=7 style='mso-width-source:userset;  mso-width-alt:1645;width:34pt'> 
 <col class=xl6532351 width=44 style='mso-width-source:userset;mso-width-alt:  1609;width:33pt'> 
 <col class=xl6532351 width=49 style='mso-width-source:userset;mso-width-alt:  1792;width:37pt'> 
 <col class=xl6532351 width=48 style='mso-width-source:userset;mso-width-alt:  1755;width:36pt'> 
 <col class=xl6532351 width=62 style='mso-width-source:userset;mso-width-alt:  2267;width:47pt'> 
 <col class=xl6532351 width=3 style='mso-width-source:userset;mso-width-alt:  109;width:2pt'> 
 <col class=xl6532351 width=82 style='mso-width-source:userset;mso-width-alt: 2998;width:62pt'> 
 <col class=xl6532351 width=4 style='mso-width-source:userset;mso-width-alt:  146;width:3pt'> 
 <col class=xl6532351 width=51 style='mso-width-source:userset;mso-width-alt: 1865;width:38pt'> 
 <col class=xl6632351 width=44 span=3 style='mso-width-source:userset;  mso-width-alt:1609;width:33pt'> 
 <col class=xl6632351 width=59 style='mso-width-source:userset;mso-width-alt:  2157;width:44pt'> 
 <col class=xl6632351 width=46 style='mso-width-source:userset;mso-width-alt:  1682;width:35pt'> 
 <col class=xl6532351 width=51 style='mso-width-source:userset;mso-width-alt:  1865;width:38pt'> 
 <col class=xl6532351 width=45 style='mso-width-source:userset;mso-width-alt:  1645;width:34pt'> 
 <col class=xl6532351 width=58 style='mso-width-source:userset;mso-width-alt:  2121;width:44pt'> 
 <col class=xl6532351 width=40 span=2 style='mso-width-source:userset;  mso-width-alt:1462;width:30pt'> 
 <col class=xl6532351 width=52 style='mso-width-source:userset;mso-width-alt:  1901;width:39pt'> 
 <tr height=20 style='height:15.0pt'> 
  <td height=20 class=xl6532351 width=89 style='height:15.0pt;width:67pt'></td> 
  <td class=xl6532351 width=2 style='width:2pt'></td> 
  <td class=xl6532351 width=59 style='width:44pt'></td> 
  <td class=xl6532351 width=59 style='width:44pt'></td> 
  <td class=xl6532351 width=45 style='width:34pt'></td> 
  <td class=xl6532351 width=45 style='width:34pt'></td> 
  <td class=xl6532351 width=45 style='width:34pt'></td> 
  <td class=xl6532351 width=45 style='width:34pt'></td> 
  <td class=xl6532351 width=45 style='width:34pt'></td> 
  <td class=xl6532351 width=45 style='width:34pt'></td> 
  <td class=xl6532351 width=45 style='width:34pt'></td> 
  <td class=xl6532351 width=44 style='width:33pt'></td> 
  <td class=xl6532351 width=49 style='width:37pt'></td> 
  <td class=xl6532351 width=48 style='width:36pt'></td> 
  <td class=xl6532351 width=62 style='width:47pt'></td> 
  <td class=xl6532351 width=3 style='width:2pt'></td> 
  <td class=xl6532351 width=82 style='width:62pt'></td> 
  <td class=xl6532351 width=4 style='width:3pt'></td> 
  <td class=xl6532351 width=51 style='width:38pt'></td> 
  <td class=xl6632351 width=44 style='width:33pt'></td> 
  <td class=xl6632351 width=44 style='width:33pt'></td> 
  <td class=xl6632351 width=44 style='width:33pt'></td> 
  <td class=xl6632351 width=59 style='width:44pt'></td> 
  <td class=xl6632351 width=46 style='width:35pt'></td> 
  <td class=xl6532351 width=51 style='width:38pt'></td> 
  <td class=xl6532351 width=45 style='width:34pt'></td> 
  <td class=xl6532351 width=58 style='width:44pt'></td> 
  <td class=xl6532351 width=40 style='width:30pt'></td> 
  <td class=xl6532351 width=40 style='width:30pt'></td> 
  <td class=xl6532351 width=52 style='width:39pt'></td> 
 </tr> 
 <tr class=xl13432351 height=36 style='mso-height-source:userset;height:27.0pt'> 
    <td colspan=4 height=36 width=209 style='border-right:1.0pt solid black;height:27.0pt;width:157pt' align=left valign=top>
        <span style='mso-ignore:vglayout; position:absolute;z-index:1;margin-left:6px;margin-top:2px;width:100px; height:30px'>
            
        </span>
        <span style='mso-ignore:vglayout2'> 
            <table cellpadding=0 cellspacing=0> 
                <tr> 
                    <td colspan=4 height=36 class=xl24132351 width=209 style='border-right:1.0pt solid black;height:43pt;width:157pt'><img width=100% height=100% src="<?= $logo ?>" alt="Brandix Logo" v:shapes="Picture_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x005f_x0020_1"></td> 
                </tr> 
            </table> 
        </span>
    </td>   
   
  <td colspan=19 rowspan=2 class=xl24432351 >
    <center>Job Wise Garment Reconciliation Sheet</center>
    <div id="externalbox"> 
        <div id="inputdata" >
            <center><?php echo '<div id="bcTarget1" style="width:auto;"></div><script>$("#bcTarget1").barcode("'.$doc.'", "code39",{barWidth:2,barHeight:45,moduleSize:5,fontSize:0});</script>'; echo $doc;?></center>
        </div>      
    </div> 
     
 <script type="text/javascript"> 
        /* <![CDATA[ */ 
      function get_object(id) { 
       var object = null; 
       if (document.layers) { 
        object = document.layers[id]; 
       } else if (document.all) { 
        object = document.all[id]; 
       } else if (document.getElementById) { 
        object = document.getElementById(id); 
       } 
       return object; 
      } 
        get_object("inputdata").innerHTML=DrawCode39Barcode(get_object("inputdata").innerHTML,1); 
        /* ]]> */ 
</script> 
  <span style='mso-spacerun:yes'></span></td> 
  <td colspan=2 rowspan=2 class=xl26432351 style='border-right:1.0pt solid black;   border-bottom:1.0pt solid black'>&nbsp;</td> 
  <td colspan=2 class=xl26832351 width=103 style='border-right:1.0pt solid black;   border-left:none;width:78pt'>Date: </td> 
  <td colspan=3 class=xl28032351 width=132 style='border-right:1.0pt solid black;   border-left:none;width:99pt'><?php echo date("Y-m-d"); ?></td> 
 </tr> 
 <tr class=xl13432351 height=30 style='mso-height-source:userset;height:22.5pt'> 
  <td colspan=4 height=30 class=xl23232351 style='border-right:1.0pt solid black;   height:22.5pt'><?php echo $plant_name; ?></td> 
  <?php  date_default_timezone_set("Asia/Colombo");  ?> 
  <td class=xl13632351 colspan=2 style='border-top:none;border-left:none'><center>Issued Date: </center></td> 
  <td colspan=3 class=xl28332351 style='border-right:1.0pt solid black'> 
  <?php echo date("Y-m-d h:i:s")."<br>"; 
   
  $is_original="0"; 
  $o_printed_date=date("Y-m-d h:i:s"); 
    $sqlj="SELECT * FROM $bai_pro3.printed_job_sheet WHERE doc_no=\"".$doc."\" "; 
    //echo $sqlj; 
    $resultj=mysqli_query($link, $sqlj) or exit("Sql Errorxs".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($rowj=mysqli_fetch_array($resultj))     
    { 
        $is_original=$rowj["pid"]; 
    } 
     
    if($is_original=="0") 
    { 
        echo "(Original)"; 
        $sqljj="INSERT INTO $bai_pro3.printed_job_sheet (doc_no,printed_time) VALUES ('".$doc."','".$o_printed_date."')"; 
        mysqli_query($link, $sqljj) or exit("Sql Errorjj".mysqli_error($GLOBALS["___mysqli_ston"])); 
    } 
    else 
    { 
        echo "(Duplicate)"; 
    } 
   
  ?></td> 
 </tr> 
 <tr height=38 style='mso-height-source:userset;height:28.5pt'> 
  <td height=38 class=xl13332351 style='height:28.5pt'>Style No:</td> 
  <td colspan=3 class=xl25232351 style='border-right:1.0pt solid black; border-left:none'><b><?php echo $style; ?></b></td> 
  <td colspan=2 class=xl21932351 style='border-right:.5pt solid black;   border-left:none'>Shedule No:</td> 
  <td colspan=3 class=xl20032351 style='border-right:1.0pt solid black;  border-left:none'><b><?php echo  $schedule; ?></b></td> 
  <td colspan=2 class=xl22132351 width=90 style='border-right:.5pt solid black;   width:68pt'>PO No:</td> 
  <td colspan=2 class=xl22332351 width=93 style='border-left:none;width:70pt'><b><?php echo $po_no; ?></b><span 
  style='mso-spacerun:yes'></span></td> 
  <td colspan=2 class=xl21932351>Country</td> 
  <td colspan=3 class=xl19532351 width=89 style='border-right:1.0pt solid black; width:67pt'><b><center><?php echo  substr($destination_list, 0, -1); ?></center></b><span style='mso-spacerun:yes'> </span></td> 
  <td colspan=2 class=xl19832351 width=95 style='border-left:none;width:71pt'>Delivery Date</td> 
  <td colspan=2 class=xl25532351 width=88 style='width:66pt'><b><?php echo $del_date; ?></b></td> 
  <td class=xl13232351 width=59 style='border-top:none;width:44pt'>Ctn range</td> 
  <td colspan=2 class=xl25732351 width=97 style='border-right:1.0pt solid black;   border-left:none;width:73pt'></td> 
  <td colspan=2 class=xl25932351 width=103 style='border-right:1.0pt solid black;   border-left:none;width:78pt'>Barcode ID</td> 
  <td colspan=3 class=xl26132351 style='border-right:1.0pt solid black; border-left:none'><?php echo  $doc;   ?></td> 
 </tr> 
 <tr height=38 style='mso-height-source:userset;height:28.5pt'> 
  <td height=38 class=xl13132351 style='height:28.5pt'>Line</td> 
  <td colspan=3 class=xl20032351 style='border-right:1.0pt solid black;   border-left:none'><?php   echo $team_number; ?></td> 
  <td colspan=2 class=xl13132351 style='border-left:none'><center>Job No</center></td> 
  <td colspan=5 class=xl24832351 style='border-right:1.0pt solid black;   border-left:none'><b><?php echo $display;?></b></td> 
  <!-- <td colspan=2 class=xl24932351>Cut No:</td>  -->
  <!-- <td colspan=2 class=xl25032351 width=93 style='border-left:none;width:70pt'><center><?php echo $cut_jobs_new1;?></center></td>  -->
  <td colspan=2 class=xl13132351 style='border-right:1.0pt solid black'><center>Job Qty</center></td> 
  <td colspan=5 class=xl23632351 width=89 style='border-right:1.0pt solid black; border-left:none;width:67pt'><?php echo $job_total_qty; ?></td> 
  <td colspan=2 class=xl23932351 style='border-left:none'>No of Carton</td> 
  <td class=xl13032351 style='border-top:none'><center>Full</center></td> 
  <td colspan=2 class=xl22832351 style='border-left:none'></td> 
  <td class=xl12932351 style='border-top:none;border-left:none'><center>Odd</center></td> 
  <td class=xl12832351 style='border-top:none;border-left:none'></td> 
  <td colspan=2 class=xl23632351 width=103 style='border-right:1.0pt solid black; border-left:none;width:78pt'>Garment per Packs</td> 
  <td colspan=3 class=xl28632351 width=132 style='border-right:1.0pt solid black; border-left:none;width:99pt'><?php echo $packing_method; ?></td> 
 </tr> 
 </table>
 <table border=0 cellpadding=0 cellspacing=0 width=1390 class=xl6532351  style='border-collapse:collapse;table-layout:fixed;width:1046pt'> 
 <tr height=28 style='mso-height-source:userset;height:21.0pt'> 
  <td height=28 class=xl12732351 style='height:21.0pt'>Cutting</td> 
  <!-- <td class=xl12632351>&nbsp;</td>  -->
  <td colspan=<?php echo $count_tot+3; ?> class=xl22932351 style='border-right:1.0pt solid black'>Sewing</td> 
  <!-- <td class=xl12532351>&nbsp;</td>  -->
  <td class=xl12432351>Quality</td> 
  <!-- <td class=xl12332351>&nbsp;</td>  -->
  <td colspan=12 class=xl22532351 style='border-right:1.0pt solid black'>Packing</td> 
 </tr> 
 <tr height=28 style='mso-height-source:userset;height:21.0pt'> 
  <td rowspan=2 height=101 class=xl20932351 width=89 style='border-bottom:1.0pt solid black; height:75.75pt;width:67pt'>Color -<br> (<b>Cut No</b>)</td> 
  <!-- <td class=xl12232351 width=2 style='width:2pt'>&nbsp;</td>  -->
  <td colspan=2 class=xl21132351 width=118 style='border-right:1.0pt solid black; width:88pt'>Sewing In<span style='mso-spacerun:yes'> </span></td> 
  <td colspan=<?php echo $count_tot; ?> class=xl21232351>Hourly Sewing Out</td> 
  <td rowspan=2 class=xl21532351 style='border-top:none'>Total</td> 
  <!-- <td class=xl12132351 style='border-left:none'>&nbsp;</td>  -->
  <td rowspan=2 class=xl21732351>Reject</td> 
  <!-- <td class=xl12032351 width=4 style='border-left:none;width:3pt'>&nbsp;</td>  -->
  <td colspan=12 class=xl20332351 width=574 style='border-right:1.0pt solid black; width:431pt'>Carton Packing</td> 
 </tr> 
 <tr height=73 style='mso-height-source:userset;height:54.75pt'> 
  <!-- <td height=73 class=xl11932351 width=2 style='height:54.75pt;width:2pt'>&nbsp;</td>  -->
  <td class=xl11832351 style='border-top:none'>Size</td> 
  <td class=xl11732351 style='border-top:none;border-left:none'>Qty</td> 
  <?php 
//   time_display
$i = 0;
$hourly_sewing_out_count = "SELECT * FROM $bai_pro3.`tbl_plant_timings`";
    $hourly_sewing_out_count_result=mysqli_query($link, $hourly_sewing_out_count) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"])); 
  while($sql_row11=mysqli_fetch_array($hourly_sewing_out_count_result)) 
    { 
        // $count_tot=$sql_row11["count1"];
        
        if($i == ($count_tot-1)){ ?>
            <td class=xl11532351 style='border-top:none;border-left:none; white-space: -o-pre-wrap;
        word-wrap: break-word;
        white-space: pre-wrap;
        white-space: -moz-pre-wrap;
        white-space: -pre-wrap;'><?php echo $sql_row11['time_display'].'<br/>('.$sql_row11['day_part'].')'; ?></td> <?php
        }
        elseif($i == 1) { ?>
            <td class=xl11632351 style='border-top:none; white-space: -o-pre-wrap;
        word-wrap: break-word;
        white-space: pre-wrap;
        white-space: -moz-pre-wrap;
        white-space: -pre-wrap;'><?php echo $sql_row11['time_display'].'<br/>('.$sql_row11['day_part'].')'; ?></td> <?php
        }
        else { ?>
            <td class=xl11632351 style='border-top:none;border-left:none; white-space: -o-pre-wrap;
        word-wrap: break-word;
        white-space: pre-wrap;
        white-space: -moz-pre-wrap;
        white-space: -pre-wrap;'><?php echo $sql_row11['time_display'].'<br/>('.$sql_row11['day_part'].')'; ?></td> <?php
        }
        $i++;
    } 
    // for($i=1;$i<=$count_tot;$i++){
        
        
    // }
    ?>
  <!-- <td class=xl11632351 style='border-top:none'>1</td> 
  <td class=xl11632351 style='border-top:none;border-left:none'>2</td> 
  <td class=xl11632351 style='border-top:none;border-left:none'>3</td> 
  <td class=xl11632351 style='border-top:none;border-left:none'>4</td> 
  <td class=xl11632351 style='border-top:none;border-left:none'>5</td> 
  <td class=xl11632351 style='border-top:none;border-left:none'>6</td> 
  <td class=xl11632351 style='border-top:none;border-left:none'>7</td> 
  <td class=xl11632351 style='border-top:none;border-left:none'>8</td> 
  <td class=xl11632351 style='border-top:none;border-left:none'>9</td> 
  <td class=xl11532351 style='border-top:none;border-left:none'>10</td>  -->
  <!-- <td class=xl11432351 style='border-left:none'>&nbsp;</td>  -->
  <!-- <td class=xl9032351 width=4 style='border-left:none;width:3pt'>&nbsp;</td>  -->
  <td class=xl11232351 width=51 style='border-top:none;width:38pt'>Ctn <br>Number</td> 
  <td class=xl11132351 width=44 style='border-top:none;border-left:none; width:33pt'>Size</td> 
  <td class=xl11132351 width=44 style='border-top:none;border-left:none; width:33pt'>Qty</td> 
  <td class=xl11032351 width=44 style='border-top:none;width:33pt'>Sign</td> 
  <td class=xl11232351 width=59 style='border-top:none;border-left:none; width:44pt'>Ctn <br> Number</td> 
  <td class=xl11132351 width=46 style='border-top:none;border-left:none; width:35pt'>Size</td> 
  <td class=xl11132351 width=51 style='border-top:none;border-left:none; width:38pt'>Qty</td> 
  <td class=xl11332351 width=45 style='border-top:none;width:34pt'>Sign</td> 
  <td class=xl11232351 width=58 style='border-top:none;width:44pt'>Ctn <br> Number</td> 
  <td class=xl11132351 width=40 style='border-top:none;border-left:none; width:30pt'>Size</td> 
  <td class=xl11132351 width=40 style='border-top:none;border-left:none; width:30pt'>Qty</td> 
  <td class=xl11032351 width=52 style='border-top:none;width:39pt'>Sign</td> 
 </tr> 
  <?php  
    // $ssqlxs="SELECT * FROM packing_summary_input WHERE input_job_no_random=\"".$doc."\" order BY order_col_des,input_job_no_random,size_code"; 
    $ssqlxs="SELECT *, SUM(carton_act_qty) AS cum_qty FROM packing_summary_input WHERE input_job_no_random=\"".$doc."\" GROUP BY doc_no,order_col_des,size_code ORDER BY input_job_no_random"; 
    // echo $ssqlxs; 
    $resultxs=mysqli_query($link, $ssqlxs) or exit("Sql Errorxs".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($rowxs=mysqli_fetch_array($resultxs)) 
    {
        $ssqlxs123="SELECT color_code FROM $bai_pro3.bai_orders_db WHERE order_del_no='".$rowxs["order_del_no"]."'  AND order_col_des = '".$rowxs["order_col_des"]."' AND order_style_no ='".$rowxs["order_style_no"]."'"; 
        //echo $ssqlxs123; 
        $resultxs123=mysqli_query($link, $ssqlxs123) or exit("Sql Errorxs".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($rowxs123=mysqli_fetch_array($resultxs123)) 
        {
            $color_code = $rowxs123["color_code"];
        }
        // echo $color_code;
        $cut_new = chr($color_code).leading_zeros($rowxs["acutno"], 3);
         echo "<tr class=xl10632351 height=48 style='mso-height-source:userset;height:36.0pt'> 
          <td rowspan=2 height=96 class=xl17132351 width=89 
          style='border-bottom:1.0pt solid black;height:72.0pt;border-top:none;width:67pt;word-wrap:break-word;'>".$rowxs["order_col_des"]."-(<b>".$cut_new."</b>)</td> 
          <td rowspan=2 class=xl18232351 style='border-bottom:1.0pt solid black'>".strtoupper($rowxs["size_code"])."</td> 
          <td rowspan=2 class=xl18432351 width=59 style='border-bottom:1.0pt solid black; 
          width:44pt'>".$rowxs["cum_qty"]."</td>"; 
            for($i=1;$i<=$count_tot;$i++){
               
                if($i == 1) { ?>
                    <td class=xl10932351>&nbsp;</td> <?php
                }
                else { ?>
                    <td class=xl10932351 style='border-left:none'>&nbsp;</td> <?php
                }
            }
        //   <td class=xl10932351>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td> 
        //   <td class=xl10932351 style='border-left:none'>&nbsp;</td>
        echo "
        <td rowspan=2 class=xl17732351 style='border-bottom:.5pt solid black; 
          border-top:none'>&nbsp;</td> 
          <td rowspan=2 class=xl17732351 style='border-bottom:.5pt solid black'>&nbsp;</td> 
          <td class=xl10232351>1</td> 
          <td class=xl10432351 style='border-left:none'>&nbsp;</td> 
          <td class=xl10432351 style='border-left:none'>&nbsp;</td> 
          <td class=xl10532351 style='border-left:none'>&nbsp;</td> 
          <td class=xl10232351 style='border-left:none'>2</td> 
          <td class=xl10432351 style='border-left:none'>&nbsp;</td> 
          <td class=xl10432351 style='border-left:none'>&nbsp;</td> 
          <td class=xl10332351 style='border-left:none'>&nbsp;</td> 
          <td class=xl10232351>&nbsp;</td> 
          <td class=xl10432351 style='border-left:none'>&nbsp;</td> 
          <td class=xl10432351 style='border-left:none'>&nbsp;</td> 
          <td class=xl10532351 style='border-left:none'>&nbsp;</td> 
         </tr> 
         <tr height=48 style='mso-height-source:userset;height:36.0pt'> 
          ";
            for($i=1;$i<=$count_tot;$i++){
                
                if($i == 1) { ?>
                    <td class=xl7932351 style='border-top:none'>&nbsp;</td> <?php
                }
                else { ?>
                    <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
                }
            }
        //   <td class=xl7932351 style='border-top:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
        //   <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
          echo "
          <td class=xl10232351 style='border-top:none'>&nbsp;</td> 
          <td class=xl10432351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10432351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10532351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10232351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10432351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10432351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10332351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10232351 style='border-top:none'>&nbsp;</td> 
          <td class=xl10132351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10132351 style='border-top:none;border-left:none'>&nbsp;</td> 
          <td class=xl10032351 style='border-top:none;border-left:none'>&nbsp;</td> 
         </tr>"; 
    } 
 ?> 
  
  
 <tr height=48 style='mso-height-source:userset;height:36.0pt'> 
  <td rowspan=2 height=96 class=xl17132351 width=89 style='border-bottom:1.0pt solid black; height:72.0pt;border-top:none;width:67pt'>&nbsp;</td> 
  <!-- <td class=xl9532351 style='border-left:none'>&nbsp;</td>  -->
  <td rowspan=2 class=xl18232351 style='border-bottom:1.0pt solid black; border-top:none'>&nbsp;</td> 
  <td rowspan=2 class=xl18432351 width=59 style='border-bottom:1.0pt solid black; border-top:none;width:44pt'>&nbsp;</td> 
  <?php 
    for($i=1;$i<=$count_tot;$i++){
        if($i == 1) { ?>
            <td class=xl8732351 style='border-top:none'>&nbsp;</td> <?php
        }
        else { ?>
            <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
    }
    ?>
  <!-- <td class=xl8732351 style='border-top:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <td rowspan=2 class=xl17732351 style='border-bottom:.5pt solid black; border-top:none'>&nbsp;</td> 
  <!-- <td class=xl9232351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <td rowspan=2 class=xl17732351 style='border-bottom:.5pt solid black; border-top:none'>&nbsp;</td> 
  <!-- <td class=xl9032351 width=4 style='border-left:none;width:3pt'>&nbsp;</td>  -->
  <td colspan=12 class=xl29532351 style='border-right:1.0pt solid black'>&nbsp;</td> 
 </tr> 
 <tr height=48 style='mso-height-source:userset;height:36.0pt'> 
  <!-- <td height=48 class=xl9532351 style='height:36.0pt;border-left:none'>&nbsp;</td>  -->
  <?php 
    for($i=1;$i<=$count_tot;$i++){
        if($i == 1) { ?>
            <td class=xl7932351 style='border-top:none'>&nbsp;</td> <?php
        }
        else { ?>
            <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
    }
    ?>
  <!-- <td class=xl7932351 style='border-top:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <!-- <td class=xl9432351 style='border-left:none'>&nbsp;</td>  -->
  <!-- <td class=xl9032351 width=4 style='border-left:none;width:3pt'>&nbsp;</td>  -->
  <td colspan=2 rowspan=2 class=xl29832351 width=95 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:71pt'>&nbsp;</td> 
  <td rowspan=2 class=xl27032351 width=44 style='border-bottom:.5pt solid black; width:33pt'><span 
  style='mso-spacerun:yes'></span></td> 
  <td rowspan=2 class=xl27032351 width=44 style='border-bottom:.5pt solid black; width:33pt'>&nbsp;</td> 
  <td rowspan=2 class=xl27032351 width=59 style='border-bottom:.5pt solid black; width:44pt'>&nbsp;</td> 
  <td rowspan=2 class=xl27032351 width=46 style='border-bottom:.5pt solid black; width:35pt'>&nbsp;</td> 
  <td rowspan=2 class=xl27032351 width=51 style='border-bottom:.5pt solid black; width:38pt'>&nbsp;</td> 
  <td colspan=2 rowspan=2 class=xl27232351 width=103 style='border-right:.5pt solid black; border-bottom:.5pt solid black;width:78pt'>System Updated By</td> 
  <td colspan=3 rowspan=2 class=xl27232351 width=132 style='border-right:1.0pt solid black; border-bottom:.5pt solid black;width:99pt'>Cut Collected By</td> 
 </tr> 
 <tr height=33 style='mso-height-source:userset;height:24.95pt'> 
  <td rowspan=2 height=81 class=xl17132351 width=89 style='border-bottom:1.0pt solid black; height:60.95pt;border-top:none;width:67pt'>&nbsp;</td> 
  <!-- <td class=xl9332351>&nbsp;</td>  -->
  <td rowspan=2 class=xl18232351 style='border-top:none'>&nbsp;</td> 
  <td rowspan=2 class=xl18432351 width=59 style='border-top:none;width:44pt'>&nbsp;</td> 
  <?php
    for($i=1;$i<=$count_tot;$i++){
        if($i == 1) { ?>
            <td class=xl8732351 style='border-top:none'>&nbsp;</td> <?php
        }
        else { ?>
            <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
    }
  ?>
  <!-- <td class=xl8732351 style='border-top:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <td rowspan=2 class=xl17732351 style='border-bottom:.5pt solid black; border-top:none'>&nbsp;</td> 
  <!-- <td class=xl9232351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <td rowspan=2 class=xl17732351 style='border-bottom:.5pt solid black; border-top:none'>&nbsp;</td> 
  <!-- <td class=xl9032351 width=4 style='border-left:none;width:3pt'>&nbsp;</td>  -->
 </tr> 
 <tr height=48 style='mso-height-source:userset;height:36.0pt'> 
  <!-- <td height=48 class=xl9132351 style='height:36.0pt'>&nbsp;</td>  -->
  <?php
    for($i=1;$i<=$count_tot;$i++){
        if($i == 1) { ?>
            <td class=xl7932351 style='border-top:none'>&nbsp;</td> <?php
        }
        else { ?>
            <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
    }
  ?>
  <!-- <td class=xl7932351 style='border-top:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <!-- <td class=xl8432351 style='border-left:none'>&nbsp;</td>  -->
  <!-- <td class=xl9032351 width=4 style='border-left:none;width:3pt'>&nbsp;</td>  -->
  <td colspan=2 class=xl29332351 style='border-right:.5pt solid black'>&nbsp;</td> 
  <td class=xl8932351 width=44 style='border-top:none;border-left:none; width:33pt'>&nbsp;</td> 
  <td class=xl8932351 width=44 style='border-top:none;border-left:none; width:33pt'>&nbsp;</td> 
  <td class=xl8932351 width=59 style='border-top:none;border-left:none; width:44pt'>&nbsp;</td> 
  <td class=xl8932351 width=46 style='border-top:none;border-left:none; width:35pt'>&nbsp;</td> 
  <td class=xl8932351 width=51 style='border-top:none;border-left:none; width:38pt'>&nbsp;</td> 
  <td colspan=2 class=xl28932351 width=103 style='border-right:.5pt solid black; border-left:none;width:78pt'>&nbsp;</td> 
  <td colspan=3 class=xl28932351 width=132 style='border-right:.5pt solid black; border-left:none;width:78pt'>&nbsp;</td> 
 </tr> 
 <tr height=33 style='mso-height-source:userset;height:24.95pt'> 
  <td rowspan=2 height=66 class=xl17132351 width=89 style='border-bottom:1.0pt solid black; height:49.9pt;border-top:none;width:67pt'>&nbsp;</td> 
  <!-- <td class=xl8132351>&nbsp;</td>  -->
  <td rowspan=2 class=xl17332351 style='border-bottom:1.0pt solid black'>&nbsp;</td> 
  <td rowspan=2 class=xl17532351 width=59 style='border-bottom:1.0pt solid black; width:44pt'>&nbsp;</td> 
  <?php
    for($i=1;$i<=$count_tot;$i++){
        if($i == 1) { ?>
            <td class=xl8732351 style='border-top:none'>&nbsp;</td> <?php
        }
        else { ?>
            <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
    }
  ?>
  <!-- <td class=xl8832351 style='border-top:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <td rowspan=2 class=xl17732351 style='border-bottom:.5pt solid black; border-top:none'>&nbsp;</td> 
  <!-- <td class=xl8432351 style='border-left:none'>&nbsp;</td>  -->
  <td rowspan=2 class=xl17732351 style='border-bottom:.5pt solid black; border-top:none'>&nbsp;</td> 
  <!-- <td class=xl9032351 width=4 style='border-left:none;width:3pt'>&nbsp;</td>  -->
  <td colspan=2 class=xl29332351 style='border-right:.5pt solid black'>&nbsp;</td> 
  <td class=xl8932351 width=44 style='border-top:none;border-left:none; width:33pt'>&nbsp;</td> 
  <td class=xl8932351 width=44 style='border-top:none;border-left:none; width:33pt'>&nbsp;</td> 
  <td class=xl8932351 width=59 style='border-top:none;border-left:none; width:44pt'>&nbsp;</td> 
  <td class=xl8932351 width=46 style='border-top:none;border-left:none; width:35pt'>&nbsp;</td> 
  <td class=xl8932351 width=51 style='border-top:none;border-left:none; width:38pt'>&nbsp;</td> 
  <td colspan=2 class=xl28932351 width=103 style='border-right:.5pt solid black; border-left:none;width:78pt'>&nbsp;</td> 
  <td colspan=3 class=xl28932351 width=132 style='border-right:1.0pt solid black; border-left:none;width:99pt'>&nbsp;</td> 
 </tr> 
 <tr height=33 style='mso-height-source:userset;height:24.95pt'> 
  <!-- <td height=33 class=xl8132351 style='height:24.95pt'>&nbsp;</td>  -->
  <?php
  for($i=1;$i<=$count_tot;$i++){
        if($i == 1) { ?>
            <td class=xl8032351 style='border-top:none'>&nbsp;</td> <?php
        }
        else { ?>
            <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
    }
    ?>
  <!-- <td class=xl8032351 style='border-top:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <!-- <td class=xl8432351 style='border-left:none'>&nbsp;</td>  -->
  <!-- <td class=xl9032351 width=4 style='border-left:none;width:3pt'>&nbsp;</td>  -->
  <td colspan=2 class=xl29332351 style='border-right:.5pt solid black'>&nbsp;</td> 
  <td class=xl8932351 width=44 style='border-top:none;border-left:none; width:33pt'>&nbsp;</td> 
  <td class=xl8932351 width=44 style='border-top:none;border-left:none; width:33pt'>&nbsp;</td> 
  <td class=xl8932351 width=59 style='border-top:none;border-left:none; width:44pt'>&nbsp;</td> 
  <td class=xl8932351 width=46 style='border-top:none;border-left:none; width:35pt'>&nbsp;</td> 
  <td class=xl8932351 width=51 style='border-top:none;border-left:none; width:38pt'>&nbsp;</td> 
  <td colspan=2 class=xl28932351 width=103 style='border-right:.5pt solid black; border-left:none;width:78pt'>&nbsp;</td> 
  <td colspan=3 class=xl28932351 width=132 style='border-right:.5pt solid black;width:99pt'></td> 
 </tr> 
 <tr class=xl7432351 height=33 style='mso-height-source:userset;height:24.95pt'> 
  <td rowspan=2 height=66 class=xl19032351 style='border-bottom:1.0pt solid black; height:49.9pt;border-top:none'>&nbsp;</td> 
  <!-- <td class=xl8132351>&nbsp;</td>  -->
  <td rowspan=2 class=xl18632351 width=59 style='border-bottom:1.0pt solid black; border-top:none;width:44pt'>&nbsp;</td> 
  <td rowspan=2 class=xl18832351 width=59 style='border-bottom:1.0pt solid black; border-top:none;width:44pt'>&nbsp;</td> 
  <?php
   for($i=1;$i<=$count_tot;$i++){
        if($i == 1) { ?>
            <td class=xl8832351 style='border-top:none'>&nbsp;</td> <?php
        }
        else { ?>
            <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
    }
  ?>
  <!-- <td class=xl8832351 style='border-top:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8732351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8632351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <td class=xl8532351 width=62 style='width:47pt'>&nbsp;</td> 
  <!-- <td class=xl8432351 style='border-left:none'>&nbsp;</td>  -->
  <td class=xl8332351 width=82 style='border-left:none;width:62pt'>&nbsp;</td> 
  <!-- <td rowspan=2 class=xl20632351 width=4 style='border-bottom:1.0pt solid black; width:3pt'>&nbsp;</td>  -->
  <td colspan=2 class=xl29332351 style='border-right:.5pt solid black'>&nbsp;</td> 
  <td class=xl8232351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8232351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8232351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8232351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl8232351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td colspan=2 class=xl28932351 width=103 style='border-right:.5pt solid black; border-left:none;width:78pt'>&nbsp;</td> 
  <td colspan=3 class=xl28932351 width=132 style='border-right:1.0pt solid black; width:99pt'></td> 
 </tr> 
 <tr class=xl7432351 height=33 style='mso-height-source:userset;height:24.95pt'> 
  <!-- <td height=33 class=xl8132351 style='height:24.95pt'>&nbsp;</td>  -->
  <?php
    for($i=1;$i<=$count_tot;$i++){
        if($i == 1) { ?>
            <td class=xl8032351 style='border-top:none'>&nbsp;</td> <?php
        }
        elseif($i == $count_tot) { ?>
            <td class=xl7832351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
        else { ?>
            <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> <?php
        }
    }
  ?>
  <!-- <td class=xl8032351 style='border-top:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7932351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7832351 style='border-top:none;border-left:none'>&nbsp;</td>  -->
  <td class=xl7632351 width=62 style='border-top:none;width:47pt'>&nbsp;</td> 
  <!-- <td class=xl7732351 style='border-left:none'>&nbsp;</td>  -->
  <td class=xl7632351 width=82 style='border-left:none;width:62pt'>&nbsp;</td> 
  <td colspan=2 class=xl30232351 style='border-right:.5pt solid black'>&nbsp;</td> 
  <td class=xl7532351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7532351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7532351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7532351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td class=xl7532351 style='border-top:none;border-left:none'>&nbsp;</td> 
  <td colspan=5 class=xl30432351 style='border-right:.5pt solid black;'></td> 
 </tr> 
 </table>
<table border=0 cellpadding=0 cellspacing=0 width=1390 class=xl6532351  style='border-collapse:collapse;table-layout:fixed;width:1046pt'> 
<tr class=xl6532351 height=33 style='mso-height-source:userset;height:24.95pt'> 
  <td colspan=12 rowspan=2 height=66 class=xl30632351 style='height:49.9pt'>Comments:</td> 
  <td colspan=2 rowspan=2 class=xl31032351 width=97 style='border-right:1.0pt solid black; width:73pt'>______________<br> 
    Recoder</td> 
  <td rowspan=2 class=xl17932351 width=62 style='width:47pt'>_________<br> Supervisor</td> 
  <td class=xl7332351 style='border-top:none'>&nbsp;</td> 
  <td rowspan=2 class=xl17932351 width=82 style='width:62pt'>____________<br> Inline QC</td> 
  <td class=xl6532351></td> 
  <td colspan=4 rowspan=2 class=xl14232351 width=183 style='border-bottom:1.0pt solid black; width:137pt'>Production Supervisor<br> 
    <br><br>______________________</td> 
  <td colspan=5 rowspan=2 class=xl14232351 width=259 style='border-right:1.0pt solid black; border-bottom:.5pt solid black;width:195pt'>Section Incharge<br> <br><br>________________________________</td> 
  <td colspan=3 rowspan=4 class=xl14832351 width=132 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:99pt'>
    Job No: <?php echo $display;?><br> 
    Job Completed<br> 
    <br><br><br><br>__________________<br> 
    Signature<br> 
    (Packing In Charge)</td> 
 </tr> 
 <tr height=33 style='mso-height-source:userset;height:24.95pt'> 
  <td height=33 class=xl6532351 style='height:24.95pt'></td> 
  <td class=xl6532351></td> 
 </tr> 
 <tr height=33 style='mso-height-source:userset;height:24.95pt'> 
  <td colspan=3 height=33 class=xl15732351 style='height:24.95pt'>Sewing In</td> 
  <td class=xl7232351 style='border-left:none'>( - )</td> 
  <td colspan=3 class=xl15732351 style='border-left:none'>Rejection</td> 
  <td class=xl7232351 style='border-left:none'>( +)</td> 
  <td colspan=4 class=xl7232351 style='border-left:none'>Replacement In</td> 
  <td class=xl7232351 style='border-left:none'>( - )</td> 
  <td colspan=4 class=xl7232351 style='border-right:1.0pt solid black; border-left:none'>Carton packing</td> 
  <td class=xl7132351>&nbsp;</td> 
  <td class=xl7032351 style='border-top:none'><font class="font632351">.</font><font class="font532351">=</font></td> 
  <td colspan=3 class=xl16132351 style='border-right:1.0pt solid black'>Zero (0)</td> 
  <td colspan=5 rowspan=2 class=xl16432351 width=259 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:195pt'>Surplus Cordinator<br> <br><br>_______________________________</td> 
 </tr> 
 <tr height=33 style='mso-height-source:userset;height:24.95pt'> 
  <td colspan=3 height=33 class=xl17032351 style='height:24.95pt'>................................................</td> 
  <td class=xl6932351 style='border-top:none;border-left:none'>( - )</td> 
  <td colspan=3 class=xl13732351 style='border-left:none'>...........................................</td> 
  <td class=xl6932351 style='border-top:none;border-left:none'>( +)</td> 
  <td colspan=4 class=xl13732351 style='border-left:none'>.....................................................</td> 
  <td class=xl6932351 style='border-top:none;border-left:none'>( - )</td> 
  <td colspan=4 class=xl13732351 style='border-right:1.0pt solid black; border-left:none'>............................................................</td> 
  <td class=xl6832351 style='border-top:none'>&nbsp;</td> 
  <td class=xl6732351><font class="font632351">.</font><font class="font532351">=</font></td> 
  <td colspan=3 class=xl13932351 style='border-right:1.0pt solid black'>...........................</td> 
 </tr> 
  
  
  

</table> 

</div> 
</body> 

</html>