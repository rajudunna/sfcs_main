<?php 
    // include("../dbconf.php"); 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));   
    // include(getFullURLLevel($_GET['r'],'functions.php','R')); 
    
	$section_no=$_GET['section_no']; 
?> 



<script type="text/javascript"> 
	(function() 
	{     
	if (window.addEventListener) 
	{ 
		window.addEventListener("load", hide_loading_screen, false);     
	} 
	else 
	{ 
		window.attachEvent("onload", hide_loading_screen); 
	} 
	})(); 

	function display_loading_screen() 
	{ 
	document.getElementById("loading_screen").style.display = 'block'; 
	} 

	function hide_loading_screen() 
	{ 
	document.getElementById("loading_screen").style.display = 'none'; 
	} 

</script> 

<style type="text/css"> 
#loading_screen 
{   
  display: none; 
  position: absolute; 
  left: 0px; 
  top: 0px; 
  height: 100%; 
  width: 100%; 
  background-color: black; 
  color: white;   
  text-align: center; 
  padding-top: 100px; 
} 
</style> 

<!--Loading End --> 

<title>Carton Pending Report</title> 

<style> 

table{ 
    font-size:12px; 
} 
td{ 
    text-align:center;
} 
th {
    text-align:center;
}
</style> 

</head> 
<body> 

<!-- Loading begining --> 
<div id="loading_screen"> 
    <h1>Loading...</h1>  
   <h3>Please Wait...</h3>  

</div> 

<!-- <script type="text/javascript">  
display_loading_screen(); 
</script>  -->

<!-- Loading End --> 

<?php 
echo "<div class='panel panel-primary'>
        <div class='panel-heading'>Carton Pending List - Section - $section_no</div>
        <div class='panel-body'>";  
echo "<div class='table-responsive' style='max-height:600px;overflow-y:scroll;'><table class='table table-bordered'>"; 
echo "<tr style='background-color:#003366;color:white;text-align:center;font-size:12px;'><th>Module</th><th>Style</th><th>Schedule</th><th>Color</th><th>Job</th><th>Carton ID</th><th>Size</th><th>Carton Qty</th><th>Completed on</th><th>Executed Modules</th></tr>"; 

//NEW2013 
//NEW ADD 2013-04-17 
$sql1="truncate $bai_pro3.packing_dashboard_temp"; 
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 

$sql1="insert into $bai_pro3.packing_dashboard_temp SELECT tid,doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,lastup,remarks,doc_no_ref,ims_style,ims_schedule,ims_color,input_date,ims_pro_qty,ims_mod_no,ims_log_date from $bai_pro3.packing_dashboard";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
//NEW ADD 2013-04-17 

$sqlx="select * from $bai_pro3.sections_db where sec_id>=0 and sec_id in ($section_no)"; 
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
while($sql_rowx=mysqli_fetch_array($sql_resultx)) 
{ 
    $section=$sql_rowx['sec_id']; 
    $section_head=$sql_rowx['sec_head']; 
    $section_mods=$sql_rowx['sec_mods']; 
     
    $mods=array(); 
    $mods=explode(",",$section_mods); 

    $row_color="test"; 
    for($x=0;$x<sizeof($mods);$x++) 
    { 
        $module=$mods[$x]; 
        $x1=0; 
        $sql1="SELECT * FROM $bai_pro3.packing_dashboard_temp WHERE ims_mod_no=$module ORDER BY lastup"; 
        //echo $sql1."<br>"; 
        $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
        $sql_num_check=mysqli_num_rows($sql_result1); 
        $check=0; 
        // echo "<script>alert('".$sql_num_check."');</script>";
        if ($sql_num_check != 0) {
        	while($sql_row1=mysqli_fetch_array($sql_result1)) 
	        {                     
	            $ims_doc_no=$sql_row1['doc_no']; 
	            $ims_size=$sql_row1['size_code']; 
	            $ims_tid_qty=$sql_row1['carton_act_qty']; 
	             $ims_schedule=$sql_row1['ims_schedule'];
	             $ims_color=$sql_row1['ims_color'];
	               $ims_style=$sql_row1['ims_style'];
	            //$sqla="select sum(bac_qty) as qty from bai_pro.bai_log_buf where ims_doc_no=$ims_doc_no and size_$ims_size > 0"; 
	            $sql3="SELECT  * FROM $bai_pro3.bai_orders_db WHERE order_del_no=\"$ims_schedule\" and order_col_des=\"$ims_color\"  and order_s_$ims_size > 0";    
	             // echo $sql3;
	            $sql_result11=mysqli_query($link, $sql3) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"])); 
	            while($sql_row=mysqli_fetch_array($sql_result11)) 
	            { 
	                $sizecode=$sql_row['title_size_'.$ims_size.''];
	            } 
	            $sqla="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log where ims_doc_no=$ims_doc_no and ims_size=\"a_$ims_size\" and ims_mod_no > 0"; 
	            // echo $sqla;
	            $sql_resulta=mysqli_query($link, $sqla) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"])); 
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
	            $sql_resultb=mysqli_query($link, $sqlb) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"])); 
	            while($sql_rowb=mysqli_fetch_array($sql_resultb)) 
	            { 
	                $packing_qty=$sql_rowb["qty"];     
	            } 
	             
	            $sql11="SELECT group_concat(distinct ims_mod_no order by ims_mod_no) as \"bac_no\" FROM $bai_pro3.ims_log_backup where ims_mod_no<>0 and ims_schedule=\"$ims_schedule\"";
	            // mysqli_query($link, $sql11) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"])); 
	            $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	            while($sql_row11=mysqli_fetch_array($sql_result11)) 
	            { 
	                $modules_list=$sql_row11['bac_no'];     
	            } 
	             
	            $sql11="select acutno,color_code from $bai_pro3.live_pro_table_ref2 where doc_no= \"$ims_doc_no\"";
	            $sql_result11=mysqli_query($link, $sql11) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"])); 
	            while($sql_row11=mysqli_fetch_array($sql_result11)) 
	            { 
	                $job=chr($sql_row11['color_code']).leading_zeros($sql_row11['acutno'],3); 
	            } 
	             
	            if((($output_qty+$output_qty1)-$packing_qty) >= $ims_tid_qty) 
	            { 
	                $sql_num_check=$sql_num_check;         
	            } 
	            else 
	            { 
	                //$sql_num_check=$sql_num_check-1; 
	                $x1=$x1+1; 
	            } 
	            echo "<tr class=\"$row_color\" style='color:black';>"; 
	            if($check==0) 
	            { 
	                if((($output_qty+$output_qty1)-$packing_qty) >= $ims_tid_qty) 
	                { 
	                echo "<td rowspan=".($sql_num_check-$x1).">$module</td>"; 
	                $check=1; 
	                } 
	            } 
	            if((($output_qty+$output_qty1)-$packing_qty) >= $ims_tid_qty) 
	            {     
	            	echo "<td>$ims_style</td><td>$ims_schedule</td><td>$ims_color</td><td>$job</td><td>$sql_row1[tid]</td><td>$sizecode</td><td>$sql_row1[carton_act_qty]</td><td>$sql_row1[ims_log_date]</td><td>$modules_list</td>"; 
	            } 
	            echo "</tr>"; 
	        }
        } 
         
        if($row_color=="test") 
        { 
            $row_color="test1"; 
        } 
        else 
        { 
            $row_color="test"; 
        } 
    }
    if ($sql_num_check == 0) {
    	echo "<div class='alert alert-danger'>No Data Found to Display</div>";
    }
     
} 
?> 
</table>
</div>
</div></div>
