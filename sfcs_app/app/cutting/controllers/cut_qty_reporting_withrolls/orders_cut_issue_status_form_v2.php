<!-- 
Changes Log:       
kirang/2014-07-28/ Service Request #974044: Add code for time based shift from HRMS 
KiranG/201506-16 Service Request # 186661 : Added form submit button validation to show a message while processing form. 
--> 

<!DOCTYPE html> 

        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />

        <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/check.js',2,'R'); ?>"></script>

<!-- <style> 

th{ 
    background-color:#337ab7; 
} 
.form-control 
{ 
    width:40%; 
} 

</style> --> 

<script> 
//alert(document.documentMode); 
$(document).ready(function(){
    if($('#planned_plies').val() == $('#plies').val()){
        document.getElementById('new_ratio_drop').disabled = true;
        return;
    }
});
function validate(x,y) 
{ 
    if( x == y){
        document.getElementById('new_ratio_drop').value = 'no';
        document.getElementById('new_ratio_drop').disabled = true;
        return;
    }
    if(x<0 || x>y) { 
        sweetAlert("Please enter valid plies ",'','warning'); 
        document.getElementById('new_ratio_drop').value = 'no';
        document.getElementById('new_ratio_drop').disabled = true;
        return true;  
    }else{
        document.getElementById('new_ratio_drop').disabled = false;
    }
    return false; 
} 

function validatePlies(id){ 
    var plies = document.getElementById('plies').value; //$plies_check
    var elements = document.getElementsByClassName("roleplies"); 
    var val = 0; 
    for(var i=0; i<elements.length; i++) { 
        if(document.getElementById(elements[i].name).value){ 
            val = parseInt(val) + parseInt(document.getElementById(elements[i].name).value); 
        } 
    } 
    //alert(val); 
    //alert(plies); 
    if(val > plies){ 
        sweetAlert("Please check!!\nRoll plies is greater than Cut Plies",'','warning');     
        document.getElementById(id).value = ""; 
        document.getElementById('update').style.display='none'; 
    }else if(val < plies){ 
        //alert("Please check role plies is less than Plies");     
        //document.getElementById(id).value = ""; 
        document.getElementById('update').style.display='none'; 
    } 
    else{ 
        document.getElementById('update').style.display='block'; 
    } 
} 

function isNumber(evt) { 
    evt = (evt) ? evt : window.event; 
    var charCode = (evt.which) ? evt.which : evt.keyCode; 
    if (charCode > 31 && (charCode < 48 || charCode > 57)) { 
        return false; 
    } 
    return true; 
} 

</script> 
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
?> 


<body onloa="document.getElementById('update').style.display='none';"> 
<!--<div id="page_heading"><span style="float"><h3>Cut Quantity Reporting</h3></span><span style="float: right; margin-top:-20px"><b>?</b>&nbsp;</span></div>--> 
<div class="panel panel-primary"> 
<div class="panel-heading">Cut Quantity Reporting</div> 
<div class="panel-body"> 


<?php 
$doc_no=$_GET['doc_no']; 

// echo "<h1><font color=red>Cut Status Reporting</font></h1>"; 

echo "<div class='table-responsive'><table class='table table-bordered' border=1>"; 
echo "<tr>"; 
echo "<th>Doc ID</th><th>Cut No</th>"; 

$sql="select * from $bai_pro3.plandoc_stat_log where doc_no='$doc_no'"; 
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_num_check=mysqli_num_rows($sql_result); 

while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $doc_no=$sql_row['doc_no']; 
    $doc_acutno=$sql_row['acutno']; 
    $a_plies=$sql_row['p_plies']; 
/*    $a_xs=$sql_row['a_xs']*$a_plies; 
    $a_s=$sql_row['a_s']*$a_plies; 
    $a_m=$sql_row['a_m']*$a_plies; 
    $a_l=$sql_row['a_l']*$a_plies; 
    $a_xl=$sql_row['a_xl']*$a_plies; 
    $a_xxl=$sql_row['a_xxl']*$a_plies; 
    $a_xxxl=$sql_row['a_xxxl']*$a_plies; 
    $a_s01=$sql_row['a_s01']*$a_plies; 
    $a_s02=$sql_row['a_s02']*$a_plies; 
    $a_s03=$sql_row['a_s03']*$a_plies; 
    $a_s04=$sql_row['a_s04']*$a_plies; 
    $a_s05=$sql_row['a_s05']*$a_plies; 
    $a_s06=$sql_row['a_s06']*$a_plies; 
    $a_s07=$sql_row['a_s07']*$a_plies; 
    $a_s08=$sql_row['a_s08']*$a_plies; 
    $a_s09=$sql_row['a_s09']*$a_plies; 
    $a_s10=$sql_row['a_s10']*$a_plies; 
    $a_s11=$sql_row['a_s11']*$a_plies; 
    $a_s12=$sql_row['a_s12']*$a_plies; 
    $a_s13=$sql_row['a_s13']*$a_plies; 
    $a_s14=$sql_row['a_s14']*$a_plies; 
    $a_s15=$sql_row['a_s15']*$a_plies; 
    $a_s16=$sql_row['a_s16']*$a_plies; 
    $a_s17=$sql_row['a_s17']*$a_plies; 
    $a_s18=$sql_row['a_s18']*$a_plies; 
    $a_s19=$sql_row['a_s19']*$a_plies; 
    $a_s20=$sql_row['a_s20']*$a_plies; 
    $a_s21=$sql_row['a_s21']*$a_plies; 
    $a_s22=$sql_row['a_s22']*$a_plies; 
    $a_s23=$sql_row['a_s23']*$a_plies; 
    $a_s24=$sql_row['a_s24']*$a_plies; 
    $a_s25=$sql_row['a_s25']*$a_plies; 
    $a_s26=$sql_row['a_s26']*$a_plies; 
    $a_s27=$sql_row['a_s27']*$a_plies; 
    $a_s28=$sql_row['a_s28']*$a_plies; 
    $a_s29=$sql_row['a_s29']*$a_plies; 
    $a_s30=$sql_row['a_s30']*$a_plies; 
    $a_s31=$sql_row['a_s31']*$a_plies; 
    $a_s32=$sql_row['a_s32']*$a_plies; 
    $a_s33=$sql_row['a_s33']*$a_plies; 
    $a_s34=$sql_row['a_s34']*$a_plies; 
    $a_s35=$sql_row['a_s35']*$a_plies; 
    $a_s36=$sql_row['a_s36']*$a_plies; 
    $a_s37=$sql_row['a_s37']*$a_plies; 
    $a_s38=$sql_row['a_s38']*$a_plies; 
    $a_s39=$sql_row['a_s39']*$a_plies; 
    $a_s40=$sql_row['a_s40']*$a_plies; 
    $a_s41=$sql_row['a_s41']*$a_plies; 
    $a_s42=$sql_row['a_s42']*$a_plies; 
    $a_s43=$sql_row['a_s43']*$a_plies; 
    $a_s44=$sql_row['a_s44']*$a_plies; 
    $a_s45=$sql_row['a_s45']*$a_plies; 
    $a_s46=$sql_row['a_s46']*$a_plies; 
    $a_s47=$sql_row['a_s47']*$a_plies; 
    $a_s48=$sql_row['a_s48']*$a_plies; 
    $a_s49=$sql_row['a_s49']*$a_plies; 
    $a_s50=$sql_row['a_s50']*$a_plies; 
*/ 
    $remarks=$sql_row['remarks']; 
    $act_cut_status=$sql_row['act_cut_status']; 
    $act_cut_issue_status=$sql_row['act_cut_issue_status']; 
    $maker_ref=$sql_row['mk_ref']; 
    $act_plies=$sql_row['p_plies']; 
    $tran_order_tid=$sql_row['order_tid']; 
    $print_status=$sql_row['print_status']; 
    $plies=$sql_row['a_plies']; 
     
    $sql33="select * from $bai_pro3.bai_orders_db where order_tid=\"$tran_order_tid\""; 
    mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row33=mysqli_fetch_array($sql_result33)) 
    { 
        $color_code=$sql_row33['color_code']; //Color Code 
    } 
     
    $sql34="SELECT material_req FROM $bai_pro3.order_cat_doc_mk_mix WHERE doc_no=$doc_no"; 
    $sql_result34=mysqli_query($link, $sql34) or exit("Sql Error34".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row34=mysqli_fetch_array($sql_result34)) 
    { 
        $material_req_ref=$sql_row34['material_req']; //Color Code 
    } 
     
    $sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\""; 
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
     
    while($sql_row1=mysqli_fetch_array($sql_result)) 
    { 
        for($s=0;$s<sizeof($sizes_code);$s++) 
        { 
            if($sql_row1["title_size_s".$sizes_code[$s].""]<>'') 
            { 
                $s_tit[$s]=$sql_row1["title_size_s".$sizes_code[$s].""]; 
            }     
        } 
             
    } 
     
    for($s=0;$s<sizeof($s_tit);$s++) 
    { 
        echo "<th>".$s_tit[$s]."</th>"; 
             
    } 
     
    echo "<th>Total</th><th>Cut Status</th><th>Cut Issue Status</th><th>Remarks</th>"; 
    echo "</tr>"; 

    for($s=0;$s<sizeof($sizes_code);$s++) 
    { 
        //echo $sizes_code[$s]."--".$sql_row["p_s01"]."<br>"; 
        $a_s[$s]=$sql_row["p_s".$sizes_code[$s].""]*$act_plies; 
    } 
         
    echo "<tr>"; 
     
    echo "<td>".leading_zeros($doc_no,9)."</td><td>".chr($color_code).leading_zeros($doc_acutno,3)."</td>"; 

    for($s=0;$s<sizeof($s_tit);$s++) 
    { 
        echo "<td>".$a_s[$s]."</td>"; 
             
    } 
    echo "<td>".array_sum($a_s)."</td>";     
    echo "<td>$act_cut_status</td><td>$act_cut_issue_status</td><td>$remarks</td>"; 

    echo "</tr>"; 
} 
echo "</table></div>"; 
$sql33="select order_joins from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
$sql_result33=mysqli_query($link, $sql33) or exit("Sql Error4569".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row33=mysqli_fetch_array($sql_result33))
{
	$order_joins=$sql_row33['order_joins']; //Color Code
}

$sql="select mklength from $bai_pro3.maker_stat_log where tid=$maker_ref"; 
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_num_check=mysqli_num_rows($sql_result); 

while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $mklength=$sql_row['mklength']; 
} 


$fab_received=0; 
$fab_returned=0; 
$fab_damages=0; 
$fab_shortages=0; 
$fab_remarks=""; 
     
$sql="select * from $bai_pro3.act_cut_status where doc_no='$doc_no'"; 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $fab_received=$sql_row['fab_received']; 
    $fab_returned=$sql_row['fab_returned']; 
    $fab_damages=$sql_row['damages']; 
    $fab_shortages=$sql_row['shortages']; 
    $fab_remarks=$sql_row['remarks']; 
} 
if ($fab_received==0 || $fab_received == '')
{
    $sql1="select sum(allocated_qty) as rec from $bai_rm_pj1.fabric_cad_allocation where doc_no='$doc_no' and status='2'"; 
    //echo $sql."<br>"; 
    $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row1=mysqli_fetch_array($sql_result1)) 
    { 
        $fab_received=$sql_row1["rec"];
    }        
}
$plies_check=0; 
if($act_cut_status=="DONE" and $plies<=$act_plies) 
{ 
    $plies_check=($act_plies-$plies); 
} 
else 
{ 
    $plies_check=$act_plies; 
} 

if($act_cut_status=="DONE") 
{ 
    $old_plies=$plies; 
} 
else 
{ 
    $old_plies=0; 
} 
//Adding to verify schedule club or not 
// $club_status=0; $order_tids=array();
// $sql1="select * from plandoc_stat_log where org_doc_no=$doc_no"; 
// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
// $count=mysqli_num_rows($sql_result1); 
// if($count>0) 
// { 
	// while($rows2=mysqli_fetch_array($sql_result1)) 
    // { 
        // $order_tids[]=$rows['order_tid']; 
    // } 
	// $sql12="select * from bai_orders_db_confirm where order_tid in ('".implode("','",$order_tids)."') limit 1"; 
    // $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    // while($rows=mysqli_fetch_array($sql_result12)) 
    // { 
        // if(strlen($rows['order_joins'])<5)
		// {
			// $club_status=1;	
		// }
		// else
		// {
			// $club_status=2;	
		// }	
			
    // } 
	// $sql12="select * from plandoc_stat_log where doc_no=$doc_no"; 
    // $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    // while($rows=mysqli_fetch_array($sql_result12)) 
    // { 
        // $a_plies_qty=$rows['a_plies']; 
    // } 
// } 
// else 
// { 
    // $club_status=0; 
    // $sql12="select * from plandoc_stat_log where doc_no=$doc_no"; 
    // $sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    // while($rows=mysqli_fetch_array($sql_result12)) 
    // { 
        // $a_plies_qty=$rows['a_plies']; 
    // } 
// } 
$club_status=0;$a_plies_qty=0;
?> 
<h2 align='center'><u>Input Entry Form</u></h2> 
<form method="post" name="input" action="<?= getFullURLLevel($_GET['r'],'orders_cut_issue_status_form1_process.php',0,'N'); ?>"> 
<input type="hidden" name="doc_no" value="<?php echo $doc_no; ?>"> 
<div class='row'> 
    <div class="col-md-12"> 
        <div class='table-responsive'>
            <table class="table table-bordered"> 


<?php 
if($print_status==NULL) 
{ 
    echo "<script>sweetAlert('Docket is yet to generate','Please Contact your cutting Head','error');</script>";
    //echo "<div class='alert alert-danger'>Docket is yet to generate. Please contact your cutting head.</div>";
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",4000); function Redirect() {  location.href = '".getFullURL($_GET['r'],'doc_track_panel.php','N')."'; }</script>"; 
    echo "</table></div></div></div>"; 
} 
else 
{ 
        
    $special_users=array("kirang","prabathsa","kirang"); 
    echo "<input type=\"hidden\" name=\"tran_order_tid\" value=\"".$tran_order_tid."\">"; 
    echo "<input type=\"hidden\" name=\"club_status\" value=\"".$club_status."\">"; 
    echo "<input type=\"hidden\" name=\"a_plies_qty\" value=\"".$a_plies_qty."\">"; 
    echo "<table class='table table-bordered'>"; 


    echo "<tr><td>Date</td><td>:</td><td><input type=\"hidden\" name=\"date\" value=".date("Y-m-d").">".date("Y-m-d")."</td></tr>"; 
    //echo "<tr><td>Section</td><td>:</td><td><input type=\"text\" name=\"section\" value=\"0\"></td></tr>"; 
    $table_q="SELECT * FROM $bai_pro3.`tbl_cutting_table` WHERE STATUS='active'"; 
    $table_result=mysqli_query($link, $table_q) or exit("Error getting Table Details"); 
    while($tables=mysqli_fetch_array($table_result)) 
    { 
        $table_name[]=$tables['tbl_name']; 
        $table_id[]=$tables['tbl_id']; 
    } 
    // var_dump($table_name); 
    echo "<tr> 
    <td>Cutting Table</td> 
    <td>:</td><td><div class='row'><div class='col-md-6'><select class=\"form-control\" name=\"section\" required><option value=\"0\">Select Table</option>"; 
    for($i = 0; $i < sizeof($table_name); $i++) 
    { 
        echo "<option value='".$table_id[$i]."' style='background-color:#FFFFAA;'>".$table_name[$i]."</option>"; 
    } 
    echo "</select></div></div></td></tr>"; 
    //Satish logic for FF 
    //echo "<tr><td>Shift</td><td>:</td><td><input type=\"text\" name=\"shift\" value=\"NIL\"></td></tr>"; 
    /*$sql_shift="select remarks from calendar where date=\"".date("Y-m-d")."\""; 
    $result_shift=mysql_query($sql_shift,$link1) or die("Error".mysql_error()); 
    while($row_shift=mysql_fetch_array($result_shift)) 
    { 
        $shift_ex=$row_shift["remarks"]; 
    } 
    /* 
    $shift_ex_explode=explode("$",$shift_ex); 
    $shift_name=explode('/',$shift_ex_explode[0]); 

    if($shift_name[0] == "A") 
    { 
        $shift_final="A"; 
        if(date("H") >= 14) 
        { 
            $shift_final="B"; 
        }     
    } 


    if($shift_name[0] == "B") 
    { 
        $shift_final="B"; 
        if(date("H") >= 14) 
        { 
            $shift_final="A"; 
        } 
    } 
    */ 

    // Add code for time based shift from HRMS  
    /*    $shift_ex_explode=explode("$",$shift_ex); 
        $shift_name=explode('/',$shift_ex_explode[0]); 
        $time_name=explode(':',$shift_name[1]); 
        //echo "<br/>".$shift_name[0]; 
        //echo "<br/>1st time=".$time_name[0]; 
        $time_name1=explode('-',$shift_name[1]); 
        $time_name2=explode(':',$time_name1[1]); 
        //echo "<br/>2nd time=".$time_name2[0]; 
        
        if($time_name[0] <= date("H") and date("H") <= $time_name2[0]) 
            { 
                    $shift_final=$shift_name[0]; 
            } 
        
        $shift_name1=explode('/',$shift_ex_explode[1]); 
        $time_name11=explode(':',$shift_name1[1]); 
        //echo "<br/>".$shift_name1[0]; 
        //echo "<br/>3rd time=".$time_name11[0]; 
        $time_name3=explode('-',$shift_name1[1]); 
        $time_name4=explode(':',$time_name3[1]); 
        //echo "<br/>4th time=".$time_name4[0]; 
        
        if($time_name11[0] <= date("H") and date("H") <= $time_name4[0])     
            { 
                    $shift_final=$shift_name1[0]; 
            } 
        /*  For General Shift 
        $shift_name2=explode('/',$shift_ex_explode[2]); 
        $time_name22=explode(':',$shift_name2[1]); 
        echo "<br/>".$shift_name2[0]; 
        echo "<br/>5th time=".$time_name22[0]; 
        $time_name5=explode('-',$shift_name2[1]); 
        $time_name6=explode(':',$time_name5[1]); 
        echo "<br/>6th time=".$time_name6[0]; 
        if($time_name22[0] <= date("H") and date("H") <= $time_name6[0])     
            { 
                    $shift_final=$shift_name2[0]; 
            } 
        */ 
        
    // if(in_array($username,$special_users)) 
    // { 
    //     echo "<tr><td>Shift</td><td>:</td><td><div class='row'><div class='col-md-6'><select class=\"form-control\" name=\"shift\" required> 
    //             <option value=\"A\">A</option> 
    //             <option value=\"B\">B</option> 
    //             </select></div></div></td></tr>"; 
    // } 
    // else 
    // { 
        /*echo "<tr><td>Shift</td><td>:</td><td><select name=\"shift\"> 
    <option value=\"$shift_final\">$shift_final</option> 
    </select></td></tr>";*/ 

    echo "<tr><td>Shift</td><td>:</td><td><div class='row'><div class='col-md-6'><select class=\"form-control\" name=\"shift\" required>";
    foreach($shifts_array as $key=>$shift){
        echo "<option value='$shift'>$shift</option>";
    }
        echo "</select></div></td></tr>"; 
    //} 

    $team_query="SELECT * FROM $bai_pro3.tbl_leader_name";
    $team_result=mysqli_query($link, $team_query) or exit("Error getting Team Details");
    echo "<tr>
            <td>Team Leader</td><td>:</td>
            <td><div class='row'><div class='col-sm-6'><select name=\"leader_name\" class='form-control'>";
    echo "<option value='' selected disabled>Select Team</option>";
    while($row=mysqli_fetch_array($team_result))
    {
        echo "<option value='".$row['emp_name']."'>".$row['emp_name']."</option>";
    }
    echo "</select></div></div>
        </td></tr>"; 
        
    echo "<tr><td>Do you want to create a new cut <br/>for the same ratio to remaining plies</td><td>:</td><td><div class='row'><div class='col-md-6'>
    <select class=\"form-control\" name=\"newratio\" id='new_ratio_drop'> 
    <option value=\"no\">No</option> 
    <option value=\"yes\">Yes</option> 
    </select></div><div class='col-md-6'><span class='label label-danger'>Note:</span>  If <b>Yes</b> Plies must change</div></div></td></tr>"; 
    echo "<tr><td>Docket Fabric Required</td><td>:</td><td>".round($material_req_ref,2)."</td></tr>"; 
    echo "<input type='hidden' id='fb_required' value='".round($material_req_ref,2)."' >";
    echo "<tr><td>Planned Plies</td><td>:</td><td>".$plies_check."</td></tr>"; 
    echo "<input type='hidden' value='$plies_check' id='planned_plies'>";
    echo "<tr><td>Cut Plies</td><td>:</td><td>
                <input  type=\"hidden\" name=\"old_plies\" value=\"$old_plies\">
                    <div class='row'><div class='col-md-6'>
                        <input class=\"form-control integer\" type=\"text\" required name=\"plies\" value=\"$plies_check\" id=\"plies\" onkeyup=\"if(validate(this.value,$plies_check)) { this.value = 0; }\" >
                        </div>
                </div>
          </td></tr>"; 
    echo "<tr><td>Fabric Received</td><td>:</td><td>
                  <input type=\"hidden\" name=\"old_fab_rec\" value=\"$fab_received\">
                  <div class='row'><div class='col-md-6'>
                    <input class=\"form-control float\" id='fb_received' type=\"text\" required name=\"fab_rec\" value=".round($fab_received,2)." ></div></div>
              </td></tr>"; 
    echo "<tr><td>Fabric Returned</td><td>:</td><td><input type=\"hidden\" name=\"old_fab_ret\" value=\"$fab_returned\">
              <div class='row'><div class='col-md-3'>
                <input class=\"form-control float\" type=\"text\" id='fb_returned' required  name=\"fab_ret\" value=\"0\">
              </div>
              <div class='col-md-1'><b>to</b></div><div class='col-md-3'>
                <select class=\"form-control\" name=\"ret_to\"><option value=\"0\">Cutting</option><option value=\"1\">RM</option></select></div>
            </div></td></tr>"; 
    // echo "<tr><td>Fabric Returned</td><td>:</td><td><input type=\"hidden\" name=\"old_fab_ret\" value=\"$fab_returned\"><input type=\"text\" onkeypress=\"return isNumber(event)\"  name=\"fab_ret\" value=\"0\">&nbsp; to <select name=\"ret_to\"><option value=\"0\">Cutting</option><option value=\"1\">RM</option></select></td></tr>"; 
    echo "<tr><td>Damages</td><td>:</td>
              <td><input type=\"hidden\" name=\"old_damages\" value=\"$fab_damages\">
              <div class='row'><div class='col-md-6'>
                <input class=\"form-control integer\" type=\"text\" id='fb_damaged' name=\"damages\" value=\"0\"></div>
            </div></td></tr>"; 
    echo "<tr><td>Shortages</td><td>:</td><td>
            <input type=\"hidden\" name=\"old_shortages\" value=\"$fab_shortages\">
            <div class='row'><div class='col-md-6'><input class=\"form-control integer\" id='fb_shortage' type=\"text\" name=\"shortages\" value=\"0\"></div>
        </div></td></tr>"; 
    //Leader Name   
     

    echo "<tr style='display:none;'><td>Bundle Location</td><td>:</td><td><select name=\"bun_loc\">"; 
    echo "<option value='' style='background-color:#FF5500;'></option>"; 
    //$locations="select * from locations where status='active'"; 
    //$locations_result=mysql_query($locations,$link) or exit("Sql Error".mysql_error()); 
    // while($location=mysql_fetch_array($locations_result)) 
    // { 
        // $qty = $location['capacity']-$location['filed_qty']; 
        // echo "<option value=".$location['loc_id']." style='background-color:#FFFFAA;'>".$location['loc_name']."(".$qty.")</option>"; 
    // } 
    /* echo "<option value='1-T1-A' style='background-color:#66EEEE;'>1-T1-A</option> 
    <option value='1-T2-A' style='background-color:#66EEEE;'>1-T2-A</option> 
    <option value='1-T3-A' style='background-color:#66EEEE;'>1-T3-A</option> 
    <option value='1-T4-A' style='background-color:#66EEEE;'>1-T4-A</option> 
    <option value='1-T5-A' style='background-color:#66EEEE;'>1-T5-A</option> 
    <option value='1-T6-A' style='background-color:#66EEEE;'>1-T6-A</option> 
    <option value='1-T7-A' style='background-color:#66EEEE;'>1-T7-A</option> 
    <option value='1-T8-A' style='background-color:#66EEEE;'>1-T8-A</option> 
    <option value='1-T9-A' style='background-color:#66EEEE;'>1-T9-A</option> 
    <option value='1-T10-A' style='background-color:#66EEEE;'>1-T10-A</option> 
    <option value='1-T11-A' style='background-color:#66EEEE;'>1-T11-A</option> 
    <option value='1-T12-A' style='background-color:#66EEEE;'>1-T12-A</option> 
    <option value='1-T1-B' style='background-color:#66EEEE;'>1-T1-B</option> 
    <option value='1-T2-B' style='background-color:#66EEEE;'>1-T2-B</option> 
    <option value='1-T3-B' style='background-color:#66EEEE;'>1-T3-B</option> 
    <option value='1-T4-B' style='background-color:#66EEEE;'>1-T4-B</option> 
    <option value='1-T5-B' style='background-color:#66EEEE;'>1-T5-B</option> 
    <option value='1-T6-B' style='background-color:#66EEEE;'>1-T6-B</option> 
    <option value='1-T7-B' style='background-color:#66EEEE;'>1-T7-B</option> 
    <option value='1-T8-B' style='background-color:#66EEEE;'>1-T8-B</option> 
    <option value='1-T9-B' style='background-color:#66EEEE;'>1-T9-B</option> 
    <option value='1-T10-B' style='background-color:#66EEEE;'>1-T10-B</option> 
    <option value='1-T11-B' style='background-color:#66EEEE;'>1-T11-B</option> 
    <option value='1-T12-B' style='background-color:#66EEEE;'>1-T12-B</option> 
    <option value='1-T1-C' style='background-color:#66EEEE;'>1-T1-C</option> 
    <option value='1-T2-C' style='background-color:#66EEEE;'>1-T2-C</option> 
    <option value='1-T3-C' style='background-color:#66EEEE;'>1-T3-C</option> 
    <option value='1-T4-C' style='background-color:#66EEEE;'>1-T4-C</option> 
    <option value='1-T5-C' style='background-color:#66EEEE;'>1-T5-C</option> 
    <option value='1-T6-C' style='background-color:#66EEEE;'>1-T6-C</option> 
    <option value='1-T7-C' style='background-color:#66EEEE;'>1-T7-C</option> 
    <option value='1-T8-C' style='background-color:#66EEEE;'>1-T8-C</option> 
    <option value='1-T9-C' style='background-color:#66EEEE;'>1-T9-C</option> 
    <option value='1-T10-C' style='background-color:#66EEEE;'>1-T10-C</option> 
    <option value='1-T11-C' style='background-color:#66EEEE;'>1-T11-C</option> 
    <option value='1-T12-C' style='background-color:#66EEEE;'>1-T12-C</option> 
    <option value='2-T1-A' style='background-color:#00FF77;'>2-T1-A</option> 
    <option value='2-T2-A' style='background-color:#00FF77;'>2-T2-A</option> 
    <option value='2-T3-A' style='background-color:#00FF77;'>2-T3-A</option> 
    <option value='2-T4-A' style='background-color:#00FF77;'>2-T4-A</option> 
    <option value='2-T5-A' style='background-color:#00FF77;'>2-T5-A</option> 
    <option value='2-T6-A' style='background-color:#00FF77;'>2-T6-A</option> 
    <option value='2-T7-A' style='background-color:#00FF77;'>2-T7-A</option> 
    <option value='2-T8-A' style='background-color:#00FF77;'>2-T8-A</option> 
    <option value='2-T9-A' style='background-color:#00FF77;'>2-T9-A</option> 
    <option value='2-T10-A' style='background-color:#00FF77;'>2-T10-A</option> 
    <option value='2-T11-A' style='background-color:#00FF77;'>2-T11-A</option> 
    <option value='2-T12-A' style='background-color:#00FF77;'>2-T12-A</option> 
    <option value='2-T1-B' style='background-color:#00FF77;'>2-T1-B</option> 
    <option value='2-T2-B' style='background-color:#00FF77;'>2-T2-B</option> 
    <option value='2-T3-B' style='background-color:#00FF77;'>2-T3-B</option> 
    <option value='2-T4-B' style='background-color:#00FF77;'>2-T4-B</option> 
    <option value='2-T5-B' style='background-color:#00FF77;'>2-T5-B</option> 
    <option value='2-T6-B' style='background-color:#00FF77;'>2-T6-B</option> 
    <option value='2-T7-B' style='background-color:#00FF77;'>2-T7-B</option> 
    <option value='2-T8-B' style='background-color:#00FF77;'>2-T8-B</option> 
    <option value='2-T9-B' style='background-color:#00FF77;'>2-T9-B</option> 
    <option value='2-T10-B' style='background-color:#00FF77;'>2-T10-B</option> 
    <option value='2-T11-B' style='background-color:#00FF77;'>2-T11-B</option> 
    <option value='2-T12-B' style='background-color:#00FF77;'>2-T12-B</option> 
    <option value='2-T1-C' style='background-color:#00FF77;'>2-T1-C</option> 
    <option value='2-T2-C' style='background-color:#00FF77;'>2-T2-C</option> 
    <option value='2-T3-C' style='background-color:#00FF77;'>2-T3-C</option> 
    <option value='2-T4-C' style='background-color:#00FF77;'>2-T4-C</option> 
    <option value='2-T5-C' style='background-color:#00FF77;'>2-T5-C</option> 
    <option value='2-T6-C' style='background-color:#00FF77;'>2-T6-C</option> 
    <option value='2-T7-C' style='background-color:#00FF77;'>2-T7-C</option> 
    <option value='2-T8-C' style='background-color:#00FF77;'>2-T8-C</option> 
    <option value='2-T9-C' style='background-color:#00FF77;'>2-T9-C</option> 
    <option value='2-T10-C' style='background-color:#00FF77;'>2-T10-C</option> 
    <option value='2-T11-C' style='background-color:#00FF77;'>2-T11-C</option> 
    <option value='2-T12-C' style='background-color:#00FF77;'>2-T12-C</option>"; */ 
    /*// echo " 
    // <option value='L01' style='background-color:#FFFFAA;'>L01</option> 
    // <option value='L02' style='background-color:#FFFFAA;'>L02</option> 
    // <option value='L03' style='background-color:#FFFFAA;'>L03</option> 
    // <option value='L04' style='background-color:#FFFFAA;'>L04</option> 
    // <option value='L05' style='background-color:#FFFFAA;'>L05</option> 
    // <option value='L06' style='background-color:#FFFFAA;'>L06</option> 
    // <option value='L07' style='background-color:#FFFFAA;'>L07</option> 
    // <option value='L08' style='background-color:#FFFFAA;'>L08</option> 
    // <option value='L09' style='background-color:#FFFFAA;'>L09</option> 
    // <option value='L10' style='background-color:#FFFFAA;'>L10</option> 
    // <option value='L11' style='background-color:#FFFFAA;'>L11</option> 
    // <option value='L12' style='background-color:#FFFFAA;'>L12</option> 
    // <option value='L13' style='background-color:#FFFFAA;'>L13</option> 
    // <option value='L14' style='background-color:#FFFFAA;'>L14</option> 
    // <option value='L15' style='background-color:#FFFFAA;'>L15</option> 
    // <option value='L16' style='background-color:#FFFFAA;'>L16</option> 
    // <option value='L17' style='background-color:#FFFFAA;'>L17</option> 
    // <option value='L18' style='background-color:#FFFFAA;'>L18</option> 
    // <option value='L19' style='background-color:#FFFFAA;'>L19</option> 
    // <option value='L20' style='background-color:#FFFFAA;'>L20</option> 
    // <option value='L21' style='background-color:#FFFFAA;'>L21</option> 
    // <option value='L22' style='background-color:#FFFFAA;'>L22</option> 
    // <option value='L23' style='background-color:#FFFFAA;'>L23</option> 
    // <option value='L24' style='background-color:#FFFFAA;'>L24</option> 
    // <option value='L25' style='background-color:#FFFFAA;'>L25</option> 
    // <option value='L26' style='background-color:#FFFFAA;'>L26</option> 
    // <option value='L27' style='background-color:#FFFFAA;'>L27</option> 
    // <option value='L28' style='background-color:#FFFFAA;'>L28</option> 
    // <option value='L29' style='background-color:#FFFFAA;'>L29</option> 
    // <option value='L30' style='background-color:#FFFFAA;'>L30</option> 
    // </select> 
    // </td></tr>"; 
    //echo "<tr><td>remarks</td><td>:</td><td><input type=\"text\" name=\"remarks\" value=\"NIL\"></td></tr>";*/ 
    echo "</table></div></div></div>"; 
    echo "<input type=\"hidden\" name=\"remarks\" value=\"$fab_remarks\">"; 
    echo "<input type=\"hidden\" value='".array_sum($a_s)."' name='total'/>"; 

} 
?> 


<?php 
$rollwisedata = array(); 
$rolltabeldata = array();  
$sql="select * from $bai_rm_pj1.fabric_cad_allocation where doc_no=$doc_no"; 
//echo $sql."<br>"; 
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_row=mysqli_fetch_array($sql_result)) 
{ 
    $rollwisedata['roll_id'] = $sql_row['roll_id']; 
    $rollwisedata['roll_width'] = $sql_row['roll_width']; 
    $rollwisedata['doc_type'] = $sql_row['doc_type']; 
    $rollwisedata['allocated_qty'] = $sql_row['allocated_qty']; 
    $allocated_quantity_fabric =  $sql_row['allocated_qty']; 
    $rollwisedata['tran_pin'] = $sql_row['tran_pin'];     

    $sql1="select lot_no,ref4 from $bai_rm_pj1.store_in where tid=".$sql_row['roll_id']; 
    //echo "Qry for lot : ".$sql1."</br>"; 
     
    $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
    while($sql_row1=mysqli_fetch_array($sql_result1)) 
    { 
        $rollwisedata['lot_no'] = ($sql_row1['lot_no'])?$sql_row1['lot_no']:'No Data'; 
        $rollwisedata['ref4'] = ($sql_row1['ref4'])?$sql_row1['ref4']:'No Data'; 
        array_push($rolltabeldata, $rollwisedata);     
    }     
} 
?> 
<?php 
   // if ($order_joins==0)
    //{
        if(count($rolltabeldata) > 0)
        { 
            ?> 
            <u><h2 align='center'>Update RolL Information</h2></u> 
            <div class="row"> 
            <div class='col-md-12 table-responsive'><table class="table table-bordered"> 
                <thead><tr><th>Roll No</th><th>Roll Width</th><th>Doc Type</th><th>Allocated Quantity</th><th>Lot No</th><th>Shade</th><th>Roll Plies</th><th>End Bits</th></tr></thead> 
                <tbody> 
                <?php             
                    foreach ($rolltabeldata as $key => $value) { 
                        echo "<tr><td>".$value['roll_id']."</td>
                                  <td>".$value['roll_width']."</td>
                                  <td>".$value['doc_type']."</td>
                                  <td>".$value['allocated_qty']."</td><td>".$value['lot_no']."</td>
                                  <td>".$value['ref4']."<input type=\"hidden\" name=\"inputdata[$key][shade]\" value=\"".$value['ref4']."\"></td>
                                  <td><input class=\"form-control roleplies integer\" type=\"text\" name=\"inputdata[$key][roleplies]\" id=\"inputdata[$key][roleplies]\" onchange=\"validatePlies(this.id)\"></td>
                                  <td><input class=\"form-control integer\" type=\"text\" name=\"inputdata[$key][nbits]\" onkeypress=\"return isNumber(event)\"></td>
                                  <input type=\"hidden\" name=\"inputdata[$key][tran_pin]\" value=".$value['tran_pin']."></tr>";                 
                    }             
                ?> 
                </tbody> 
            </table></div></div> 
            <?php 
        } 
    
    if(sizeof($rolltabeldata)>0){ 
                //onclick="javascript:enableButton();" 
    ?> 
            <span><input type = "submit" class="btn btn-success" name = "Update" value = "Update" id="update" onclick='return verify_total_fabric()'  onload="document.getElementById('update').style.display='none';"></span> 
    <?php 
    }
    //} else {
    //   echo "<h2><font color='red'>This is a Clubbed Docket!<br>So, you cannot Cut-Report Roll-Wise<br>Please Report Without Rolls</font></h2>";
    //}
    ?> 
</form> 
<span id="msg" style="display:none;"><h1><font color="red">Please wait while updating data...</font></h1></span> 
</div></div> 
</div> 
<style> 
th{ 
    background-color:#f8d7da; 
    border-color: #f5c6cb; 
} 
</style>

<script>
function verify_total_fabric(){
    var req = document.getElementById('fb_required').value;
    var rec = document.getElementById('fb_received').value;
    var sht = document.getElementById('fb_shortage').value;
    var ret = document.getElementById('fb_returned').value;
    var dam = document.getElementById('fb_damaged').value;
    if(parseInt(req) != parseInt(rec) + parseInt(sht) + parseInt(ret) + parseInt(dam)){
        sweetAlert('','The Sum of Received,Returned,Damaged,Shortage quantities is greater than Required Quantity','warning');
        return false;
    }
    return true;
}
</script>
