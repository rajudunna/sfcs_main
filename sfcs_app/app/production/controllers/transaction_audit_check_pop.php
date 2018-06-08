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
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/user_acl_v1.php',3,'R'));
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));  
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',3,'R'));

// include("header.php"); 
?> 

<html> 
<title>Lay Plan Delete</title> 
<head> 
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'/common/js/TableFilter_EN/tablefilter.js',3,'R');?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'/common/js/TableFilter_EN/actb.js',3,'R');?>"></script>
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

function myfunction() 
{ 
    //var val = document.getElementById('reason_code').value; 
    var val= $('#schedule').val();
    if(val.length < 1){
        sweetAlert('Please fill the Schedule','','warning'); 
        return false; 
    }
    //alert(val.length); 
    if(val.length<5 || val.length<=5) 
    { 
        sweetAlert('Please enter valid schedule','','warning'); 
        return false; 
    } 
     
} 
</script> 
<link href="style.css" rel="stylesheet" type="text/css" /> 
<?php //echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> 
</head> 

<body> 
<div class="panel panel-primary">
<div class="panel-heading">Production Review</div> 
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
    
    <form name="test" action="index.php?r=<?php echo $_GET['r'];?>" method="post" >
    <div class="col-sm-12">
    <div class="row">
    <div class="col-sm-3">Enter Schedule 
    <input type="text" required class="form-control input-sm integer" name="schedule" id='schedule' onblur="firstbox();" size=8 value="<?php  if(isset($_POST['schedule'])) { echo $_POST['schedule']; } elseif(isset($_GET['schedule'])) { echo $_GET['schedule']; } ?> "></td></div>
            

    <?php 

    echo "<div class=\"col-sm-3\">Select Color: <select class=\"form-control\" name=\"color\" onclick='verify_sch()' onchange=\"secondbox();\" >"; 
	$sql="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_joins='0'";
	echo "<option value='' selected disabled>Select Color</option>"; 
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


    echo "</select></div><br>"; 
?> 

<div class = "col-sm-3"><input type="button" class = "btn btn-primary" value="Show" 
	onclick= "return myfunction()"  id="submit" name="submit"  /></div>
</form> 
</div></div>


<?php

if(isset($_POST['submit']))
{
	$schedule=$_POST['schedule'];
	$col=$_POST['color'];
	
	$sqla="select *  FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no =$schedule";
	$sql_result=mysqli_query($link, $sqla) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if(mysqli_num_rows($sql_result)>0)
	{
	 

	if($col!='')
	{
	
	
	//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
// echo "<h2><b>Production Status</b></h2>";
// $url = getFullURL($_GET['r'],'transaction_audit_schedule.php','R');
// echo "<br/><a href=\"$url?schedule=$schedule\" onclick=\"return popitup("."'"."$url?schedule=$schedule"."'".")\" class='btn btn-success'>Production Status</a><br/>";

	// if($username=="kirang")
	// {
		// include("transaction_audit_recon_check.php");
	// }

//echo "<div>";
echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>Plan Board Transaction Log</div>";
echo "<div class='panel-body'>";
echo "<div class='table-responsive'><table class=\"table table-bordered\">";
echo "<tr><th>Docket ID</th><th width=\"150\">What</th><th>Who</th><th>When</th></tr>";


$sql="select * from $bai_pro3.plan_dashboard_change_log where doc_no in (select doc_no from $bai_pro3.order_cat_doc_mk_mix where order_del_no=\"$schedule\" and order_col_des='$col')";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
		echo "<tr>";

		echo "<td>".$sql_row['doc_no']."</td>";
		echo "<td>".$sql_row['record_comment']."</td>";
		echo "<td>".$sql_row['record_user']."</td>";
		echo "<td>".$sql_row['record_timestamp']."</td>";
		echo "</tr>";
}


echo "</table></div>";
echo "</div></div>";
?>

<?php

	
//echo "<div>";
echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>Output Log</div>";
echo "<div class='panel-body'>";
echo "<div class='table-responsive'><table class=\"table table-bordered filtertable\"  id='filtertable'>";

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_col_des='$col'";
 //echo $sql;
//mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("No Data Found".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$color=$sql_row['order_col_des'];
	for($i=0;$i<sizeof($sizes_array);$i++)
	{				
		if($sql_row["title_size_".$sizes_array[$i].""]<>'')
		{					
			$sizes_tit=$sql_row["title_size_".$sizes_array[$i].""];
		}
	}
			
}	
echo "<tr><th>Date</th><th>Module</th><th>Section</th><th>Shift</th><th>User Style</th><th>Movex Style</th><th>Schedule</th><th>Color</th><th>Job No</th><th>DocketNo</th><th>Qty</th><th>SMV</th><th>NOP</th>";
for($i=0;$i<sizeof($sizes_tit);$i++)
{				
	echo "<th>".$sizes_tit[$i]."</th>";
}
echo "</tr>";


$sql="select tid,bac_no,bac_sec,bac_date,bac_shift,sum(bac_Qty) as \"bac_Qty\",bac_lastup,bac_style,ims_doc_no,ims_tid,ims_table_name,log_time,smv,nop, sum(size_xs) as \"size_xs\", sum(size_s) as \"size_s\", sum(size_m) as \"size_m\", sum(size_l) as \"size_l\", sum(size_xl) as \"size_xl\", sum(size_xxl) as \"size_xxl\", sum(size_xxxl) as \"size_xxxl\", sum(size_s01) as \"size_s01\", sum(size_s02) as \"size_s02\", sum(size_s03) as \"size_s03\", sum(size_s04) as \"size_s04\", sum(size_s05) as \"size_s05\", sum(size_s06) as \"size_s06\", sum(size_s07) as \"size_s07\", sum(size_s08) as \"size_s08\", sum(size_s09) as \"size_s09\", sum(size_s10) as \"size_s10\", sum(size_s11) as \"size_s11\", sum(size_s12) as \"size_s12\", sum(size_s13) as \"size_s13\", sum(size_s14) as \"size_s14\", sum(size_s15) as \"size_s15\", sum(size_s16) as \"size_s16\", sum(size_s17) as \"size_s17\", sum(size_s18) as \"size_s18\", sum(size_s19) as \"size_s19\", sum(size_s20) as \"size_s20\", sum(size_s21) as \"size_s21\", sum(size_s22) as \"size_s22\", sum(size_s23) as \"size_s23\", sum(size_s24) as \"size_s24\", sum(size_s25) as \"size_s25\", sum(size_s26) as \"size_s26\", sum(size_s27) as \"size_s27\", sum(size_s28) as \"size_s28\", sum(size_s29) as \"size_s29\", sum(size_s30) as \"size_s30\", sum(size_s31) as \"size_s31\", sum(size_s32) as \"size_s32\", sum(size_s33) as \"size_s33\", sum(size_s34) as \"size_s34\", sum(size_s35) as \"size_s35\", sum(size_s36) as \"size_s36\", sum(size_s37) as \"size_s37\", sum(size_s38) as \"size_s38\", sum(size_s39) as \"size_s39\", sum(size_s40) as \"size_s40\", sum(size_s41) as \"size_s41\", sum(size_s42) as \"size_s42\", sum(size_s43) as \"size_s43\", sum(size_s44) as \"size_s44\", sum(size_s45) as \"size_s45\", sum(size_s46) as \"size_s46\", sum(size_s47) as \"size_s47\", sum(size_s48) as \"size_s48\", sum(size_s49) as \"size_s49\", sum(size_s50) as \"size_s50\"  from $bai_pro.bai_log where delivery=\"$schedule\" and color='$col' group by tid order by ims_doc_no";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("No Data Found".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tid=$sql_row['tid'];
	$module=$sql_row['bac_no'];
	$section=$sql_row['bac_sec'];
	$date=$sql_row['bac_date'];
	$shift=$sql_row['bac_shift'];
	$qty=$sql_row['bac_Qty'];
	$lastup=$sql_row['bac_lastup'];
	$userstyle=$sql_row['bac_style'];
	$doc_no=$sql_row['ims_doc_no'];
	$ims_tid=$sql_row['ims_tid'];
	$ims_table_name=$sql_row['ims_table_name'];
	$log_time=$sql_row['log_time'];
	$smv=$sql_row['smv'];
	$nop=$sql_row['nop'];
	for($i=0;$i<sizeof($sizes_tit);$i++)
	{			
		$sizes_val[]=$sql_row["size_".$sizes_tit[$i].""];
	}
	$sql1="select * from $bai_pro3.plandoc_stat_log where doc_no='$doc_no'";
	//echo $sql1;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$order_tid=$sql_row1['order_tid'];
		$cutno=$sql_row1['acutno'];
		$cat_ref=$sql_row1["cat_ref"];
	}
	
	$sql1="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"'$order_tid'\"";
	mysqli_query($link, $sql1) or exit("No Data Found".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("No Data Found".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$style=$sql_row1['order_style_no'];
		$schedule=$sql_row1['order_del_no'];
		$color=$sql_row1['order_col_des'];
		$color_code=$sql_row1['color_code'];
		$$carton_id_new_create=$sql_row1["carton_id"];
		$tran_order_tid=$sql_row1["order_tid"];
	}

	$bgcolor="";	
	if($smv==0 and $nop==0)
	{
		$bgcolor="RED";
	}
			
	echo "<tr bgcolor=\"$bgcolor\">";

	//echo "<td>$tid</td>";
	echo "<td>$date</td>";
	echo "<td>$module</td>";
	echo "<td>$section</td>";
	echo "<td>$shift</td>";

	echo "<td>$userstyle</td>";
	echo "<td>$style</td>";
	echo "<td>$schedule</td>";
	echo "<td>$color</td>";
	echo "<td>".chr($color_code).leading_zeros($cutno,3)."</td>";
	echo "<td>$doc_no</td>";
	echo "<td>$qty</td>";
	echo "<td>".$smv."</td>";
	echo "<td>".$nop."</td>";
	for($i=0;$i<sizeof($sizes_tit);$i++)
	{				
		echo "<td>".$sizes_val[$i]."</td>";
	}
	echo "</tr>";
}

echo '<tr><td>Output Total:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';

echo "</table></div>";
echo "</div></div>";
?>

<script language="javascript" type="text/javascript">
//<![CDATA[
	var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1Tot1"],
						 col: [10],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('filtertable'),"tr").length]
	};
	setFilterGrid("filtertable",fnsFilters);
	/*setFilterGrid( "table10" );*/
//]]>
</script>
<?php

echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>Input & Output Log</div>";
echo "<div class='panel-body'>";

echo "<div class='table-responsive'><table class=\"table table-bordered table111\" id=\"table111\">";
echo "<tr><th>Input Date</th><th>Layplan ID</th><th>Dockete</th><th>Module</th><th>Shift</th><th>Size</th><th>Input Qty</th><th>Output Qty</th><th>Status</th><th>Bai Log Ref</th><th>Last Update</th><th>Remarks</th><th>Style</th><th>Schedule</th><th>Color</th><th>IMS Tid</th><th>Random Track</th></tr>";

$sql="select * from $bai_pro3.ims_log where ims_schedule=\"$schedule\" and ims_color='$col'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$ims_date=$sql_row['ims_date'];
	$ims_cid=$sql_row['ims_cid'];
	$ims_doc_no=$sql_row['ims_doc_no'];
	$ims_mod_no=$sql_row['ims_mod_no'];
	$ims_shift=$sql_row['ims_shift'];
	$ims_size=$sql_row['ims_size'];
	$ims_qty=$sql_row['ims_qty'];
	$ims_pro_qty=$sql_row['ims_pro_qty'];
	$ims_status=$sql_row['ims_status'];
	$bai_pro_ref=$sql_row['bai_pro_ref'];
	$ims_log_date=$sql_row['ims_log_date'];
	$ims_remarks=$sql_row['ims_remarks'];
	$ims_style=$sql_row['ims_style'];
	$ims_schedule=$sql_row['ims_schedule'];
	$ims_color=$sql_row['ims_color'];
	$tid=$sql_row['tid'];
	$rand_track=$sql_row['rand_track'];
	$size_value=ims_sizes('',$sql_row['ims_schedule'],$sql_row['ims_style'],$sql_row['ims_color'],strtoupper(substr($sql_row['ims_size'],2)),$link11);
	echo "<tr><td>".$sql_row['ims_date']."</td><td>".$sql_row['ims_cid']."</td><td>".$sql_row['ims_doc_no']."</td><td>".$sql_row['ims_mod_no']."</td><td>".$sql_row['ims_shift']."</td><td>".$size_value."</td><td>".$sql_row['ims_qty']."</td><td>".$sql_row['ims_pro_qty']."</td><td>".$sql_row['ims_status']."</td><td>".$sql_row['bai_pro_ref']."</td><td>".$sql_row['ims_log_date']."</td><td>".$sql_row['ims_remarks']."</td><td>".$sql_row['ims_style']."</td><td>".$sql_row['ims_schedule']."</td><td>".$sql_row['ims_color']."</td><td>".$sql_row['tid']."</td><td>".$sql_row['rand_track']."</td></tr>";

}

$sql="select * from $bai_pro3.ims_log_backup where ims_schedule=\"$schedule\" and ims_color='$col' order by ims_mod_no";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$ims_date=$sql_row['ims_date'];
	$ims_cid=$sql_row['ims_cid'];
	$ims_doc_no=$sql_row['ims_doc_no'];
	$ims_mod_no=$sql_row['ims_mod_no'];
	$ims_shift=$sql_row['ims_shift'];
	$ims_size=$sql_row['ims_size'];
	$ims_qty=$sql_row['ims_qty'];
	$ims_pro_qty=$sql_row['ims_pro_qty'];
	$ims_status=$sql_row['ims_status'];
	$bai_pro_ref=$sql_row['bai_pro_ref'];
	$ims_log_date=$sql_row['ims_log_date'];
	$ims_remarks=$sql_row['ims_remarks'];
	$ims_style=$sql_row['ims_style'];
	$ims_schedule=$sql_row['ims_schedule'];
	$ims_color=$sql_row['ims_color'];
	$tid=$sql_row['tid'];
	$rand_track=$sql_row['rand_track'];
	$size_value=ims_sizes('',$sql_row['ims_schedule'],$sql_row['ims_style'],$sql_row['ims_color'],strtoupper(substr($sql_row['ims_size'],2)),$link11);
	echo "<tr><td>".$sql_row['ims_date']."</td><td>".$sql_row['ims_cid']."</td><td>".$sql_row['ims_doc_no']."</td><td>".$sql_row['ims_mod_no']."</td><td>".$sql_row['ims_shift']."</td><td>".$size_value."</td><td>".$sql_row['ims_qty']."</td><td>".$sql_row['ims_pro_qty']."</td><td>".$sql_row['ims_status']."</td><td>".$sql_row['bai_pro_ref']."</td><td>".$sql_row['$bai_pro3.ims_log_date']."</td><td>".$sql_row['ims_remarks']."</td><td>".$sql_row['ims_style']."</td><td>".$sql_row['ims_schedule']."</td><td>".$sql_row['ims_color']."</td><td>".$sql_row['tid']."</td><td>".$sql_row['rand_track']."</td></tr>";

}
echo '<tr><td>Input Total:</td><td id="table111Tot1" style="background-color:#FFFFCC; color:red;"></td><td>Output Total:</td><td id="table111Tot2" style="background-color:#FFFFCC; color:red;"></td></tr>';
echo "</table></div>";
echo "</div></div>";

?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	//setFilterGrid( "table111" );
var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table111Tot1","table111Tot2"],
						 col: [6,7],  
						operation: ["sum","sum"],
						 decimal_precision: [1,1],
						write_method: ["innerHTML","innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table111'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table111",fnsFilters);
//]]>
</script>

<?php



echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>Finished Log</div>";
echo "<div class='panel-body'>";

echo "<div class='table-responsive'><table class=\"table table-bordered table1111\" id=\"table1111\">";
echo "<tr><th>Docket</th><th>Docket Ref</th><th>TID</th><th>Size</th><th>Remarks</th><th>Status</th><th>Last Updated</th><th>Carton Act Qty</th><th>Style</th><th>Schedule</th><th>Color</th></tr>";
$packing_tid_list=array();
$sql="select * from $bai_pro3.packing_summary where order_del_no=\"$schedule\" and order_col_des='$col' order by size_code,carton_act_qty desc,tid";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$doc_no=$sql_row['doc_no'];
	$doc_no_ref=$sql_row['doc_no_ref'];
	$tid=$sql_row['tid'];
	$packing_tid_list[]=$sql_row['tid'];
	$size_code=$sql_row['size_code'];
	$remarks=$sql_row['remarks'];
	$status=$sql_row['status'];
	$lastup=$sql_row['lastup'];
	$container=$sql_row['container'];
	$disp_carton_no=$sql_row['disp_carton_no'];
	$disp_id=$sql_row['disp_id'];
	$carton_act_qty=$sql_row['carton_act_qty'];
	$audit_status=$sql_row['audit_status'];
	$order_style_no=$sql_row['order_style_no'];
	$order_del_no=$sql_row['order_del_no'];
	$order_col_des=$sql_row['order_col_des'];

	$size_value=ims_sizes('',$sql_row['order_del_no'],$sql_row['order_style_no'],$sql_row['order_col_des'],strtoupper($sql_row['size_code']),$link11);
	echo "<tr><td>".$sql_row['doc_no']."</td><td>".$sql_row['doc_no_ref']."</td><td>".$sql_row['tid']."</td><td>".$size_value."</td><td>".$sql_row['remarks']."</td><td>".(strlen($sql_row['status'])==0?"Pending":$sql_row['status'])."</td><td>".$sql_row['lastup']."</td><td>".$sql_row['carton_act_qty']."</td><td>".$sql_row['order_style_no']."</td><td>".$sql_row['order_del_no']."</td><td>".$sql_row['order_col_des']."</td>
	</tr>";

}
echo '<tr><td>Total:</td><td id="table1111Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
echo "</table></div>";
echo "</div></div>";
if($username=="kirang")
{
	echo implode($packing_tid_list,",");
}

?>


<script language="javascript" type="text/javascript">
//<![CDATA[
	//setFilterGrid( "table1111" );

var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1111Tot1"],
						 col: [7],  
						operation: ["sum"],
						 decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1111'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("table1111",fnsFilters);
//]]>
</script>

<?php
//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>Packing Check List</div>";
echo "<div class='panel-body'>";
$url=getFullURLLevel($_GET['r'],'packing/controllers/packing_check_list.php',2,'R');
echo "<br/><h3><a href=\"$url&order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create\" class=\"btn btn-warning\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create"."'".")\">Carton Track</a></h3><br/>";
echo "</div></div>";
?>



<?php
//Date 2013-11-25/Ticket#100078/ Added Carton Track and AOD details
echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>AOD Details</div>";
echo "<div class='panel-body'>";
echo "<div class='table-responsive'><table class=\"table table-bordered\">";
echo "<tr><th>order tid</th><th>update</th><th>remarks</th><th>status</th><th>style</th><th>schedule</th>";
for($i=0;$i<sizeof($sizes_tit);$i++)
{				
	echo "<td>".$sizes_tit[$i]."</td>";
}
echo "<th>tid</th><th>cartons</th><th>AOD no</th><th>lastup</th><th>Total QTY</th></tr>";
$sql="select * from $bai_pro3.ship_stat_log where ship_schedule=$schedule";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	echo "<tr><td>".$sql_row["ship_order_tid"]."</td>
	<td>".$sql_row["ship_up_date"]."</td>
	<td>".$sql_row["ship_remarks"]."</td>
	<td>".$sql_row["ship_status"]."</td>
	<td>".$sql_row["ship_style"]."</td>
	<td>".$sql_row["ship_schedule"]."</td>";
	for($i=0;$i<sizeof($sizes_tit);$i++)
	{				
		echo "<td>".$sql_row["ship_s_".$sizes_array[$i].""]."</td>";
		
	}
}
echo "</table></div>";
echo "</div></div>";
echo "</table></div>";
	}
	else
	{
		echo "<script>swal('Please Select Color','','warning');</script>";
	}
}
else
{
	echo "<script>sweetAlert('Invalid Schedule No ','','warning')</script>";	
}

?>
<script language="javascript" type="text/javascript">
//<![CDATA[
	setFilterGrid( "table11111" );
//]]>
</script>
<?php


}
?>
<script>
	document.getElementById("msg").style.display="none";		
</script>

</div></div>

