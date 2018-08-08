<?php 
// include("dbconf.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs/app/production/common/config/dbconf.php");
?> 

<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<style> 
body 
{ 
    font-family: Trebuchet MS; 
} 
table,tr,td,th 
{ 
    border: 1px solid black; 
} 
.heading2 
{ 
    background-color:#29759C; 
    color:white; 
    padding:5px; 
    font-size:14px; 
    font-weight: bold; 
} 
.content 
{ 
    padding:5px; 
    font-size:14px; 
} 
</style> 
<?php  
    // include("functions.php"); 
    include($_SERVER['DOCUMENT_ROOT']."/sfcs/app/production/common/config/functions.php");
    if (isset($_GET['style']) and isset($_GET['style'])) 
    {
        $style=$_GET['style']; 
        $schedule=$_GET['schedule'];
    }
      
?>
<script> 

function secondbox() 
{ 
    var ajax_url ="input_job_mix_ch.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value;
    Ajaxify(ajax_url);
 
} 

function firstbox() 
{ 
    var ajax_url ="input_job_mix_ch.php?style="+document.test.style.value;Ajaxify(ajax_url);

} 



</script> 
<link href="style.css" rel="stylesheet" type="text/css" /> 
<script> 
function popitup(url) { 
newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0'); 
if (window.focus) {newwindow.focus();} 
return false; 
} 

function popitup_new(url) { 

newwindow=window.open(url,'name','scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0'); 
if (window.focus) {newwindow.focus();} 
return false; 
} 
</script> 
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> 
</head> 

<body> 

 

<?php 

if(isset($_REQUEST['process'])) 
{ 
    //echo "Test"; 
    $jobno=$_POST['jobno']; 
    $tidset=$_POST['tidset']; 
     
    $temp=1; 
    //$rand=date("ymdHi").$temp.rand(); 
    $rand=$_POST['schedule_no'].date("ymdH").$temp; 
     
    for($i=0;$i<sizeof($jobno);$i++) 
    { 
        if($temp!=$jobno[$i]) 
        { 
            //$rand=date("ymdHi").$jobno[$i].rand(); 
            $rand=$_POST['schedule_no'].date("ymdH").$jobno[$i]; 
            $temp=$jobno[$i];     
        }         
        $sql="update pac_stat_log set input_job_no=".$jobno[$i].", input_job_no_random='$rand' where tid in (".$tidset[$i].")";     
        mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
    } 
     
        //echo "Tids=".implode(",",$tidset); 
        $sql1="select input_job_no as job_no,GROUP_CONCAT(DISTINCT tid) AS tid ,GROUP_CONCAT(DISTINCT doc_no_ref) AS ref from bai_pro3.packing_summary_input where carton_mode=\"P\" and tid in (".implode(",",$tidset).") group by input_job_no*1,destination"; 
        //echo $sql1."<br>"; 
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error1".$sql1.mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        { 
            $sql2="update bai_pro3.packing_summary_input set doc_no_ref=\"".$sql_row1["ref"]."\" where carton_mode=\"P\" and tid in (".$sql_row1["tid"].") and input_job_no=\"".$sql_row1["job_no"]."\""; 
            //echo $sql2."<br>";     
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"])); 
        } 
         
} 

?> 

<div id="page_heading"><span style="float"><h3>Input Job Summary & Reconciliation Report</h3></span><span style="float: right"><b></b>&nbsp;</span></div> 
<form name="test" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 

<?php 


echo "Select Style: <select name=\"style\" onchange=\"firstbox();\" >"; 
    $sql="SELECT DISTINCT order_style_no FROM bai_pro3.plan_doc_summ";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_num_check=mysqli_num_rows($sql_result); 

    echo "<option value=\"NIL\" selected>NIL</option>"; 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style)) 
        { 
            echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>"; 
        } 
        else 
        { 
            echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>"; 
        } 
    } 

echo "</select>"; 
?> 
<?php 

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\""; 
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != ''))  
//{ 
    $sql="SELECT DISTINCT order_del_no FROM bai_pro3.packing_summary_input WHERE order_style_no=\"$style\" and order_del_no>0 and order_joins='0'  order by order_del_no";     
    //echo $sql; 
    //$sql="SELECT DISTINCT order_del_no FROM packing_summary_input WHERE order_del_no>0 order by order_del_no";     
//}   

echo " Select Schedule: <select name=\"schedule\" onchange=\"secondbox();\" >"; 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_num_check=mysqli_num_rows($sql_result); 

echo "<option value=\"NIL\" selected>NIL</option>"; 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)) 
    { 
        echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>"; 
    } 
    else 
    { 
        echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>"; 
    } 
    //For color Clubbing 
} 
//To Show Clubbed Schedules 

$sqlx="SELECT DISTINCT order_del_no FROM bai_pro3.bai_orders_db_confirm WHERE order_joins in (2)";     
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
{ 
    $sql1="select group_concat(distinct order_del_no) as order_del_no,count(distinct order_del_no) as count from bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_joins='J".$sql_rowx['order_del_no']."'"; 
    $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row1=mysqli_fetch_array($sql_result1)) 
    { 
        $order_del_nos=$sql_row1['order_del_no']; 
        $count=$sql_row1['count']; 
    } 
    //echo "<option>".$order_del_nos."</option>"; 
    if(strlen($order_del_nos) > 0) 
    { 
        $sql11="select distinct order_del_no from bai_pro3.packing_summary_input where order_del_no in (".$order_del_nos.")"; 
        $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error88".mysqli_error($GLOBALS["___mysqli_ston"])); 
        //echo "<option>".$order_del_nos."-".mysql_num_rows($sql_result11)."-".$count."</option>"; 
        if(mysqli_num_rows($sql_result11)==$count) 
        {     
            if(str_replace(" ","",$sql_rowx['order_del_no'])==str_replace(" ","",$schedule)) 
            { 
                echo "<option value=\"".$sql_rowx['order_del_no']."\" selected>".$order_del_nos."-".$sql_rowx['order_del_no']."</option>"; 
            } 
            else 
            { 
                echo "<option value=\"".$sql_rowx['order_del_no']."\">".$order_del_nos."-".$sql_rowx['order_del_no']."</option>"; 
            } 
        } 
    } 
} 
echo "</select>"; 

if($schedule>0) 
{ 
    //Check to have schedule clubbing 
    $sql="select order_joins from bai_pro3.bai_orders_db_confirm where order_joins='J$schedule'"; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
    if(mysqli_num_rows($sql_result)>0) 
    { 
        $sql="select group_concat(distinct order_del_no) as order_del_no from bai_pro3.bai_orders_db_confirm where order_joins='J$schedule'"; 
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row=mysqli_fetch_array($sql_result)) 
        { 
            $schedule=$sql_row['order_del_no']; 
        } 
    } 
    $sql="select COUNT(DISTINCT order_col_des) AS count, COALESCE(SUM(IF(input_job_no IS NULL,1,0)),0) AS pending from bai_pro3.packing_summary_input where order_del_no in ($schedule)"; 
    //echo $sql; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $color_count=$sql_row['count']; 
        $pending=$sql_row['pending']; 
    } 
    if($pending>0) 
    { 
        if(!(in_array(strtolower($username),$view_users))) 
        { 
        echo "<br><br>Independent Schedule: <select multiple name=\"donotmixschedule[]\">"; 
        $sql21="select order_del_no,TRIM(destination) as destination from bai_pro3.bai_orders_db where order_del_no in ($schedule)"; 
        //echo $sql21; 
        $sql_result21=mysqli_query($link, $sql21) or exit("Sql Error88 $sql2".mysqli_error($GLOBALS["___mysqli_ston"])); 
        if(mysqli_num_rows($sql_result21)>0) 
        { 
            while($sql_row21=mysqli_fetch_array($sql_result21)) 
            { 
                echo "<option value=\"".$sql_row21["order_del_no"]."\">".$sql_row21["order_del_no"]."-".$sql_row21["destination"]."</option>"; 
            } 
        } 
        echo "</select>"; 
         
        } 
    } 
     
     
     
     

    $sql="select carton_id from bai_pro3.bai_orders_db_confirm where order_del_no in ($schedule)"; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $carton_id=$sql_row['carton_id']; 
    } 

    $sizes='';
    for($j=0;$j<sizeof($sizes_array);$j++)
    {
        $sizes.="'".$sizes_array[$j]."',";

    }
    $query=substr($sizes,0,-1);
    $sql="select GREATEST($query) as max_carton_qty from bai_pro3.carton_qty_chart where id=$carton_id"; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    { 
        $max_limit=$sql_row['max_carton_qty']; 
    } 
     
     
    if($color_count>0 and $pending>0) 
    { 
        echo "Mix Multiple Colors: <input type='checkbox' value='1' name='mix_colors' ".($_REQUEST['mix_colors']==1?"checked":"").">"; 
    } 
    else 
    { 
        echo "<input type='hidden' value='0' name='mix_colors'>"; 
    } 
         
    if($pending>0) 
    { 
        if(!(in_array(strtolower($username),$view_users))) 
        { 
        //echo "Mix Jobs: <input type='checkbox' value='1' name='mix_jobs' ".($_POST['mix_jobs']==1?"checked":"").">"; 
        echo "<input type='hidden' value='$color_count' name='color_count'>"; 
        echo "<input type='hidden' value='$pending' name='pending'>"; 
        echo "<input type='hidden' value='$schedule' name='schedule_no'>"; 
        echo "Max Allowed Job Qty: $max_limit <input type=\"text\" name=\"job_qty\" value=\"".(isset($_REQUEST['job_qty'])?$_REQUEST['job_qty']:$max_limit)."\">"; 
         
        echo "<input type=\"submit\" value=\"List\" name=\"submit\">";     
        } 
        else 
        { 
            echo "<br><h3>INPUT JOBS that are not yet created</h3>"; 
        } 
    } 
    else 
    { 
         
            echo "<input type=\"submit\" value=\"Show\" name=\"submit\">"; 
         
    } 
         
} 
     
?> 


</form> 

<?php 
if(isset($_POST['submit'])) 
{ 
    $style=$_POST['style']; 
    $schedule=$_POST['schedule']; 
    $mix_colors=$_POST['mix_colors']; 
    $color_count=$_POST['color_count']; 
    $mix_jobs=$_POST['mix_jobs']; 
    $job_qty=$_POST['job_qty']; 
    $donotmix_sch=$_POST["donotmixschedule"]; 
    //include("style_header_info.php"); 
    if(sizeof($donotmix_sch) > 0) 
    { 
        for($d=0;$d<sizeof($donotmix_sch);$d++) 
        { 
            $donotmix_sch_list[]=$donotmix_sch[$d]; 
        } 
         
        $excep_sch=implode(",",$donotmix_sch_list);     
         
        $exp_query=" and order_del_no not in ($excep_sch)"; 
    } 
    else 
    { 
        $donotmix_sch_list[]=0; 
        $exp_query=""; 
    } 
     
    $operation=array("","Single Colour & Single Size","Multi Colour & Single Size","Multi Colour & Multi Size","Single Colour & Multi Size"); 
     
    $sql2="select distinct packing_mode as mode from bai_pro3.packing_summary_input where order_del_no in (".$schedule.") "; 
    $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($row2=mysqli_fetch_array($result2)) 
    { 
        $packing_mode=$row2["mode"];     
    } 
     
    if($packing_mode==1 || $packing_mode==4) 
    { 
        $input_job_path="print_input_sheet.php"; 
    } 
    else 
    { 
        $input_job_path="print_input_sheet_mm.php"; 
    } 
     
    /* Enable this, if you want to disable schedule club numbers in list. 
    $sql="select order_joins from bai_orders_db_confirm where order_del_no='$schedule' and left(order_joins,1)='J'"; 
    $sql_result=mysql_query($sql,$link) or exit("Sql Error88 $sql".mysql_error()); 
     
    if(mysql_num_rows($sql_result)>0) 
    { 
        while($sql_row=mysql_fetch_array($sql_result)) 
        { 
            $schedule=substr($sql_row['order_joins'],1);         
        } 
    }*/ 
         
    //echo "sdfhskjhdsfkjdsfsfsf"; 
    //Check to have schedule clubbing 
    for($j=0;$j<sizeof($sizes_array);$j++)
    {
        $bai_orders_db_confirm.="bai_orders_db_confirm.order_s_".$sizes_array[$j]."+";
    }
    $query=substr($bai_orders_db_confirm,0,-1);

    $sql="select order_joins from bai_pro3.bai_orders_db_confirm where order_joins='J$schedule'"; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
    if(mysqli_num_rows($sql_result)>0) 
    { 
        $sql="select group_concat(order_del_no order by order_qty) as order_del_no from (select distinct order_del_no as order_del_no, ($query) as order_qty from bai_pro3.bai_orders_db_confirm where order_joins='J$schedule') as tem order by order_qty"; 
        //echo $sql; 
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row=mysqli_fetch_array($sql_result)) 
        { 
            $schedule=$sql_row['order_del_no']; 
        } 
    } 
     
    echo "<a href=\"".$input_job_path."?schedule=$schedule\" onclick=\"return popitup_new('".$input_job_path."?schedule=$schedule')\">Print Input Job Sheet - Job Wise</a><br>"; 
     
    echo "<a href=\"print_input_sheet_dest.php?schedule=$schedule\" onclick=\"return popitup_new('print_input_sheet_dest.php?schedule=$schedule')\">Print Input Job Sheet - Destination Wise</a>"; 
     
    echo '<form name="new" method="post" action="'.$_SERVER['PHP_SELF'].'">'; 
     
    echo '<input type="hidden" name="mix_colors" value="'.$mix_colors.'">'; 
    echo '<input type="hidden" name="job_qty" value="'.$job_qty.'">'; 
     
    echo "<table>"; 
    echo "<tr>"; 
    if($pending!=0) 
    { 
        echo "<th>S/No</th>"; 
        echo "<th>Destination</th>"; 
    } 
    echo "<th>Schedule</th>"; 
    echo "<th>Color Set</th>"; 
    //echo "<th>Schedule-Cut Job#-Color-Size-Quantity</th>"; 
    echo "<th>Cut Job#</th>"; 
    echo "<th>Size Set</th>"; 
    echo "<th>Quantity</th>"; 
    echo "<th>Input Job#</th>"; 
    //echo "<th>TID</th>"; 
    //echo "<th>Doc# Ref</th>"; 
    echo "</tr>"; 
    //field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50') 
    if($mix_colors>0) 
    { 
        $sql="select * from (select count(distinct acutno) as job_count, GROUP_CONCAT(DISTINCT acutno ORDER BY acutno SEPARATOR '') as job_des,input_job_no,group_concat(distinct tid order by tid) as tid,group_concat(distinct doc_no_ref order by tid) as doc_no_ref,group_concat(distinct size_code) as size_code,group_concat(distinct order_col_des) as order_col_des,group_concat(distinct order_del_no) as order_del_no,group_concat(distinct concat(order_del_no,'-',acutno,'-',order_col_des,'-',size_code,'-',carton_act_qty) order by tid separator '<br/>') as acutno,sum(carton_act_qty) as carton_act_qty from bai_pro3.packing_summary_input where order_del_no in ($schedule) group by doc_no_ref order by field(order_del_no,$schedule),field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) as temp order by job_des+0,job_des,field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')"; 
        $case=1;     
    } 
    else 
    { 
        if($color_count>1) 
        { 
            $sql="select * from (select count(distinct acutno) as job_count, GROUP_CONCAT(DISTINCT acutno ORDER BY acutno SEPARATOR '') as job_des,input_job_no,group_concat(distinct tid order by doc_no) as tid,group_concat(distinct doc_no_ref order by doc_no) as doc_no_ref,group_concat(distinct size_code) as size_code,order_col_des,order_del_no,group_concat(distinct concat(order_del_no,'-',acutno,'-',order_col_des,'-',size_code,'-',carton_act_qty) order by doc_no separator '<br/>' ) as acutno,sum(carton_act_qty) as carton_act_qty from bai_pro3.packing_summary_input where order_del_no in ($schedule) group by order_col_des,doc_no_ref order by order_col_des,field(order_del_no,$schedule),field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) as temp order by order_col_des,job_count,job_des+0,field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')"; 
            //echo $sql; 
            $case=2; 
        } 
        else 
        { 
            //Date:2014-09-03/Added Schedule Number for Ordering 
            //$sql="select * from (select count(distinct acutno) as job_count, GROUP_CONCAT(DISTINCT acutno ORDER BY acutno SEPARATOR '') as job_des,input_job_no,group_concat(distinct tid order by tid) as tid,group_concat(distinct doc_no_ref order by doc_no) as doc_no_ref,group_concat(distinct size_code) as size_code,order_del_no,order_col_des,group_concat(distinct concat(order_del_no,'-',acutno,'-',size_code,'-',order_col_des,carton_act_qty) order by doc_no separator '<br/>') as acutno,sum(carton_act_qty) as carton_act_qty from packing_summary_input where order_del_no in ($schedule) $exp_query group by doc_no_ref order by field(order_del_no,$schedule),field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) as temp order by order_col_des,job_des+0,field(order_del_no,$schedule),field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')"; 
            $sql="select * from (select count(distinct acutno) as job_count,doc_no, GROUP_CONCAT(DISTINCT acutno ORDER BY acutno SEPARATOR '') as job_des,input_job_no,group_concat(distinct tid order by tid) as tid,group_concat(distinct doc_no_ref order by doc_no) as doc_no_ref,group_concat(distinct size_code) as size_code,order_del_no,order_col_des,group_concat(distinct concat(acutno) order by doc_no separator '<br/>') as acutno,sum(carton_act_qty) as carton_act_qty from bai_pro3.packing_summary_input where order_del_no in ($schedule) $exp_query group by doc_no_ref order by field(doc_no,order_del_no,$schedule),field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) as temp order by doc_no,order_col_des,field(order_del_no,$schedule),field(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50'),carton_act_qty+0 desc"; 
            $case=3; 
        } 
         
    } 
    //echo $case; 
     
    if($pending==0) 
    { 
        $sql1x="SET SESSION group_concat_max_len = 1000000"; 
        mysqli_query($link, $sql1x) or exit("Sql Error88 = $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
         
        //$sql="SELECT sch_mix,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT m3_size_code) AS size_code,group_concat(distinct order_col_des) as order_col_des,group_concat(distinct order_del_no) as order_del_no,GROUP_CONCAT(DISTINCT CONCAT(order_del_no,'-',acutno,'-',order_col_des,'-',m3_size_code,'-',carton_act_qty) ORDER BY doc_no SEPARATOR '<br/>' ) AS acutno,SUM(carton_act_qty) AS carton_act_qty FROM (SELECT DISTINCT(SUBSTRING_INDEX(order_joins,'J',-1)) AS sch_mix,order_del_no,input_job_no,input_job_no_random,tid,doc_no,doc_no_ref,m3_size_code,order_col_des,acutno,SUM(carton_act_qty) AS carton_act_qty FROM packing_summary_input WHERE order_del_no in ($schedule) $exp_query GROUP BY order_col_des,order_del_no,input_job_no_random,acutno,m3_size_code order by field(order_del_no,$schedule),field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) AS t GROUP BY input_job_no_random ORDER BY input_job_no,field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')"; 
        $sql="SELECT input_job_no_random,sch_mix,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT m3_size_code) AS size_code,group_concat(distinct order_col_des order by order_col_des) as order_col_des,doc_no,group_concat(distinct order_del_no) as order_del_no,GROUP_CONCAT(DISTINCT CONCAT(acutno) ORDER BY doc_no SEPARATOR '<br/>' ) AS acutno,SUM(carton_act_qty) AS carton_act_qty FROM (SELECT DISTINCT(SUBSTRING_INDEX(order_joins,'J',-1)) AS sch_mix,order_del_no,input_job_no,input_job_no_random,tid,doc_no,doc_no_ref,m3_size_code,order_col_des,acutno,SUM(carton_act_qty) AS carton_act_qty FROM bai_pro3.packing_summary_input WHERE order_del_no in ($schedule) $exp_query GROUP BY order_col_des,order_del_no,input_job_no_random,acutno,m3_size_code order by field(order_del_no,$schedule),field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) AS t GROUP BY input_job_no_random ORDER BY input_job_no,field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')";
    } 
    //echo $sql."<br>"; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 = $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $temp=0; 
    $job_no=0; 
    $i=1; 
    $color=""; 
    while($sql_row=mysqli_fetch_array($sql_result)) 
    {         
        $temp+=$sql_row['carton_act_qty']; 
        if($temp>$job_qty or $color!=$sql_row['order_col_des'] or in_array($sql_row['order_del_no'],$donotmix_sch_list)) 
        { 
            $job_no++; 
            $temp=0; 
            $temp+=$sql_row['carton_act_qty']; 
            $color=$sql_row['order_col_des']; 
        } 
         
        $sql4="select order_tid from bai_pro3.bai_orders_db where order_del_no=\"".$sql_row["sch_mix"]."\""; 
        $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row4=mysqli_fetch_array($sql_result4)) 
        { 
            $order_tid=$sql_row4["order_tid"]; 
        } 
         
        $doc_tag=$sql_row["doc_no"]; 
         
        $sql_des="select destination,group_concat(distinct size_code) as size_code from bai_pro3.packing_summary_input where doc_no=\"$doc_tag\" and input_job_no=".$sql_row['input_job_no'].""; 
        $sql_result4x=mysqli_query($link, $sql_des) or exit("Sql Error44 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
        while($sql_row4x=mysqli_fetch_array($sql_result4x)) 
        { 
            $des_tag=$sql_row4x["destination"];  
            $size_codes=$sql_row4x['size_code']; 
        } 
        //echo $des_tag; 
        echo "<tr>"; 
        if($pending!=0) 
        { 
            echo "<td>$i</td>"; 
            echo "<td>".$des_tag."</td>"; 
        } 
         
        echo "<td>".$sql_row['order_del_no']."</td>"; 
        echo "<td>".$sql_row['order_col_des']."</td>"; 
        echo "<td>".$sql_row['acutno']."</td>"; 
        echo "<td>".strtoupper($size_codes)."</td>"; 
        echo "<td>".$sql_row['carton_act_qty']."</td>"; 
        echo "<td>"; 
         
        if($pending>0) 
        { 
            echo "<input type=\"text\" name=\"jobno[]\" value=\"$job_no\"><input type=\"hidden\" name=\"tidset[]\" value=\"".$sql_row['tid']."\">"; 
        } 
        else 
        { 
            //echo $sql_row['input_job_no']; 
            //echo "<a href=\"Print_Doc_new_input.php?order_tid=$order_tid&&schedule=".$sql_row['order_del_no']."&&job_no=".$sql_row['input_job_no']."\" onclick=\"return popitup('Print_Doc_new_input.php?order_tid=$order_tid&&schedule=".$sql_row['order_del_no']."&&schedule=".$sql_row['order_del_no']."&&job_no=".$sql_row['input_job_no']."')\">".$sql_row['input_job_no']."</a>"; 
             
            echo "<a href=\"new_job_sheet3.php?jobno=".$sql_row['input_job_no']."&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&doc_no=".$sql_row['input_job_no_random']."\" onclick=\"return popitup_new('new_job_sheet3.php?jobno=".$sql_row['input_job_no']."&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&doc_no=".$sql_row['input_job_no_random']."')\">Job Sheet-".$sql_row['input_job_no']."</a><br>"; 
        }         
        echo"</td>"; 
        echo "</tr>"; 
        $i++; 
         
    } 
     
    if(sizeof($donotmix_sch) > 0) 
    { 
        //$sql1="SELECT * FROM (SELECT COUNT(DISTINCT acutno) AS job_count, GROUP_CONCAT(DISTINCT acutno ORDER BY acutno SEPARATOR '') AS job_des,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref, GROUP_CONCAT(DISTINCT size_code) AS size_code,order_del_no,order_col_des,GROUP_CONCAT(DISTINCT CONCAT(order_del_no,'-',acutno,'-',size_code,'-',order_col_des,carton_act_qty) ORDER BY doc_no SEPARATOR '') AS acutno,SUM(carton_act_qty) AS carton_act_qty FROM packing_summary_input WHERE order_del_no IN ($excep_sch) GROUP BY doc_no_ref ORDER BY FIELD(order_del_no,$excep_sch), FIELD(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) AS temp ORDER BY size_code,order_col_des,job_des+0,FIELD(order_del_no,$excep_sch) ,FIELD(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')"; 
        $sql1="SELECT * FROM (SELECT COUNT(DISTINCT acutno) AS job_count, GROUP_CONCAT(DISTINCT acutno ORDER BY acutno SEPARATOR '') AS job_des,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref, GROUP_CONCAT(DISTINCT size_code) AS size_code,order_del_no,doc_no,order_col_des,GROUP_CONCAT(DISTINCT CONCAT(acutno) ORDER BY doc_no SEPARATOR '') AS acutno,SUM(carton_act_qty) AS carton_act_qty FROM bai_pro3.packing_summary_input WHERE order_del_no IN ($excep_sch) GROUP BY doc_no_ref ORDER BY  FIELD(order_del_no,$excep_sch), FIELD(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) AS temp ORDER BY carton_act_qty desc,size_code,order_col_des,job_des+0,FIELD(order_del_no,$excep_sch) ,FIELD(size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')"; 
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error88 $sql1".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $carton_qty=0;     
        $job_no=$job_no+1; 
        //echo $sql1."<br>";         
        while($sql_row1=mysqli_fetch_array($sql_result1)) 
        {     
            $sqlr="select style_id from bai_pro3.bai_orders_db where order_del_no=\"".$sql_row1['order_del_no']."\""; 
            $sql_resultr=mysqli_query($link, $sqlr) or exit("Sql Error88 $sqlr".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowr=mysqli_fetch_array($sql_resultr)) 
            { 
                $style_id_ref=$sql_rowr["style_id"]; 
            } 
         
            $carton_qty=$carton_qty+$sql_row1['carton_act_qty']; 
             
            $doc_no_tag=$sql_row1["doc_no"]; 
             
            $sql_desq="select destination from bai_pro3.plandoc_stat_log where doc_no=\"$doc_no_tag\""; 
            //echo $sql_desq."<br>"; 
            $sql_result4xq=mysqli_query($link, $sql_desq) or exit("Sql Error44 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row4xq=mysqli_fetch_array($sql_result4xq)) 
            { 
                $des_no_tag=$sql_row4xq["destination"]; 
            } 
             
            $sqlx="select ".$sql_row1['size_code']." as qty from bai_pro3.carton_qty_chart where user_style=\"$style_id_ref\""; 
            //echo $sqlx."<br>"; 
            $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error88 $sql1".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
            { 
                $job_qty1=$sql_rowx["qty"]*2; 
            } 
            $job_qty1=$job_qty; 
            //echo "1-".$carton_qty."-".$job_qty."<br>"; 
            if($carton_qty>$job_qty1) 
            { 
                $job_no++; 
                $carton_qty=0;         
                $carton_qty=$carton_qty+$sql_row1['carton_act_qty']; 
                //echo "2-".$carton_qty."-".$job_qty."<br>"; 
                if($carton_qty>$job_qty1) 
                { 
                     
                    echo "<tr>"; 
                    echo "<td>$i</td>"; 
                    echo "<td>".$des_no_tag."</td>"; 
                    echo "<td>".$sql_row1['order_del_no']."</td>"; 
                    echo "<td>".$sql_row1['order_col_des']."</td>"; 
                    echo "<td>".$sql_row1['acutno']."</td>"; 
                    echo "<td>".$sql_row1['size_code']."</td>"; 
                    echo "<td>".$job_qty1."</td>"; 
                    echo "<td>";         
                    if($pending>0) 
                    { 
                        echo "<input type=\"text\" name=\"jobno[]\" value=\"$job_no\"><input type=\"hidden\" name=\"tidset[]\" value=\"".$sql_row1['tid']."\">"; 
                    } 
                    else 
                    { 
                        //echo $sql_row['input_job_no']; 
                        echo "<a href=\"new_job_sheet.php?schedule=".$sql_row1['order_del_no']."&&job_no=".$sql_row['input_job_no']."\" onclick=\"return popitup('new_job_sheet.php?schedule=".$sql_row1['order_del_no']."&&job_no=".$sql_row['input_job_no']."')\">".$sql_row['input_job_no']."</a>"; 
                    }         
                    echo"</td>"; 
                    echo "</tr>"; 
                    $i++; 
                }         
            }             
             
            echo "<tr>"; 
            echo "<td>$i</td>"; 
            echo "<td>".$des_no_tag."</td>"; 
            echo "<td>".$sql_row1['order_del_no']."</td>"; 
            echo "<td>".$sql_row1['order_col_des']."</td>"; 
            echo "<td>".$sql_row1['acutno']."</td>"; 
            echo "<td>".$sql_row1['size_code']."</td>"; 
            //echo "3-".$sql_row1['carton_act_qty']."-".$job_qty."-".($sql_row1['carton_act_qty']-$job_qty1)."-".$i."<br>"; 
            if($sql_row1['carton_act_qty']-$job_qty1 > 0) 
            { 
                echo "<td>".($sql_row1['carton_act_qty']-$job_qty1)."</td>"; 
                $carton_qty=0;     
                $job_no++; 
            } 
            else 
            {     
                echo "<td>".($sql_row1['carton_act_qty'])."</td>"; 
                $job_no=$job_no; 
            } 
            echo "<td>";         
            if($pending>0) 
            { 
                echo "<input type=\"text\" name=\"jobno[]\" value=\"$job_no\"><input type=\"hidden\" name=\"tidset[]\" value=\"".$sql_row1['tid']."\">"; 
                 
            } 
            else 
            { 
                echo "<a href=\"new_job_sheet.php?schedule=".$sql_row1['order_del_no']."&&job_no=".$sql_row['input_job_no']."\" onclick=\"return popitup('new_job_sheet.php?schedule=".$sql_row1['order_del_no']."&&job_no=".$sql_row['input_job_no']."')\">".$sql_row['input_job_no']."</a>"; 
            }         
            echo"</td>"; 
            echo "</tr>"; 
             
            $i++; 
        } 
    } 
    //echo $sql1; 
    echo "</table>"; 
     
    if($pending>0) 
    { 
        echo "<input type='hidden' value='$schedule' name='schedule_no'>"; 
        echo '<input type="submit" name="process" value="Process">';     
    }     
     
    echo "</form>"; 
     
} 
?>   

</body> 
</html>