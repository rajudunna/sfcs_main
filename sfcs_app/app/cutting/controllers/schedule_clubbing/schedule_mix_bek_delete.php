<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?> 
<?php  
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R')); 
// $view_access=user_acl("SFCS_0092",$username,1,$group_id_sfcs); 
?> 
<?php 
// include("header_scripts.php");  
?> 

<script> 

function firstbox() 
{ 
    var ajax_url ="<?= getFullURLLevel($_GET['r'],'schedule_mix_bek_delete.php',0,'N'); ?>&style="+document.test.style.value ;Ajaxify(ajax_url);

} 
function secondbox() 
{ 
    var ajax_url ="<?= getFullURLLevel($_GET['r'],'schedule_mix_bek_delete.php',0,'N'); ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value ;
	Ajaxify(ajax_url);

}


</script> 
<!--<link href="style.css" rel="stylesheet" type="text/css" /> -->
<?php 
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> 
 

<SCRIPT> 

function SetAllCheckBoxes(FormName, FieldName, CheckValue) 
{ 
    if(!document.forms[FormName]) 
        return; 
    var objCheckBoxes = document.forms[FormName].elements[FieldName]; 
    if(!objCheckBoxes) 
        return; 
    var countCheckBoxes = objCheckBoxes.length; 
    if(!countCheckBoxes) 
        objCheckBoxes.checked = CheckValue; 
    else 
        // set the check value for all check boxes 
        for(var i = 0; i < countCheckBoxes; i++) 
            objCheckBoxes[i].checked = CheckValue; 
} 

	function fill_up()
	{
	
		var sourceid=document.getElementById('sourceid').value;
		var source=document.getElementById('source').value;
		if(sourceid=='' || source=='')
		{
			sweetAlert('Please Fill The Mandatory Fields','','warning');
			return false;
		}
		else
		{
			return true;
		}

	}
function check_all()
{
	var style=document.getElementById('style').value;
	var sch=document.getElementById('schedule').value;
	var color=document.getElementById('color').value;
	if(style=='NIL' || sch=='NIL' || color=='NIL')
	{
		sweetAlert('Please Enter style ,Schedule and Color','','warning');
		return false;
	}
	else
	{
		return true;
	}
}
function check_sch()
{
	var style=document.getElementById('style').value;
	if(style=='NIL' )
	{
		sweetAlert('Please Enter Style First','','warning');
		return false;
	}
	else
	{
		return true;
	}

}
function check_sch_sty()
{
	var style=document.getElementById('style').value;
	var sch=document.getElementById('schedule').value;
	if(style=='NIL' )
	{
		sweetAlert('Please Enter Style First','','warning');
		return false;
	}
	else if(sch=='NIL')
	{
		sweetAlert('Please Enter Schedule ','','warning');
		return false;
	}
	else
	{
		return true;
	}
	

}

</SCRIPT> 
</head> 

<body> 
<div class="panel panel-primary">
<div class="panel-heading">Schedule Clubing Clear Panel</div>
<div class="panel-body">
<div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/menu_content.php',4,'R'));?> 
<?php 
$style=$_GET['style']; 
$schedule=$_GET['schedule'];  
$color=$_GET['color']; 
//$po=$_GET['po']; 

if(isset($_POST['submit'])) 
{ 
    $style=$_POST['style']; 
    $schedule=$_POST['schedule'];  
    $color=$_POST['color']; 
    //$po=$_POST['po']; 
} 

//echo $style.$schedule.$color; 
?> 
<!--<div id="page_heading"><span style="float"><h3>Schedule Mix Panel (PO Level)</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div> -->

<form name="test" action="#" method="post"> 
<?php 

echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style: </label><select name=\"style\" id=\"style\" class=\"form-control\" onchange=\"firstbox();\" >"; 

$sql="select distinct order_style_no from $bai_pro3.bai_orders_db"; 

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_num_check=mysqli_num_rows($sql_result); 

echo "<option value=\"NIL\" selected>Select</option>"; 
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

echo "</select></div>"; 
?> 

<?php 

echo "<div class=\"col-sm-3\"><label>Select Schedule: </label><select name=\"schedule\" id=\"schedule\" class=\"form-control\" onchange=\"secondbox();\" >"; 
$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\""; 

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
$sql_num_check=mysqli_num_rows($sql_result); 

echo "<option value=\"NIL\" selected>Select</option>"; 
     
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

} 


echo "</select></div>"; 


?>

<?php
echo "<div class=\"col-sm-3\"><label>Select Mixing Color: </label><select name=\"color\" id=\"color\" class=\"form-control\" >"; 
$sql1="select distinct order_col_des from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_joins in (1,2)"; 
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
echo "<option value=\"NIL\" selected>Select</option>"; 
     
while($sql_row1=mysqli_fetch_array($sql_result1)) 
{ 
	if(str_replace(" ","",$sql_row1['order_col_des'])==str_replace(" ","",$color)) 
	{ 
		echo "<option value=\"".$sql_row1['order_col_des']."\" selected>".$sql_row1['order_col_des']."</option>"; 
	} 
	else 
	{ 
		echo "<option value=\"".$sql_row1['order_col_des']."\">".$sql_row1['order_col_des']."</option>"; 
	} 
} 


echo "</select></div></br>"; 
// echo "</select>"; 

    echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Clear\" name=\"submit\" onclick='return check_all();'>";     
?> 

</div></br>
</form> 


<?php 
if(isset($_POST['submit'])) 
{ 
    $style=$_POST['style']; 
    $schedule=$_POST['schedule']; 
    $color=$_POST['color'];
	$order_joins='J'.substr($color,-1);	
    $docket_t_cmp=array();
    $docket_tmp=array();
	$docket_t_c=array();
    $docket_t=array();
	$status=0;$rows1=0;$rows=0;
	$sql88="select * from $bai_pro3.plandoc_stat_log where order_tid like \"%".$schedule.$color."%\""; 
	$result88=mysqli_query($link, $sql88) or die("Error=8".mysqli_error($GLOBALS["___mysqli_ston"])); 
	//echo $sql88."<br>"; 
	if(mysqli_num_rows($result88)>0) 
	{ 
		$sql881="select * from $bai_pro3.plandoc_stat_log where order_tid like \"%".$schedule.$color."%\""; 
		//echo $sql881."<br>";
		$result881=mysqli_query($link, $sql881) or die("Error=8".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($row881=mysqli_fetch_array($result881)) 
		{ 
			$docket_tmp[]=$row881['doc_no']; 
		} 
		$docket_t=implode(",", $docket_tmp); 
		$sql882="select * from $bai_pro3.plandoc_stat_log where org_doc_no in (".$docket_t.")"; 
		//echo $sql882."<br>";
		$result882=mysqli_query($link, $sql882) or die("Error=8".mysqli_error($GLOBALS["___mysqli_ston"])); 
		if(mysqli_num_rows($result882)>0)
		{
			while($row882=mysqli_fetch_array($result882)) 
			{ 
				$docket_t_cmp[]=$row882['doc_no']; 
			} 
			$docket_t_c=implode(",", $docket_t_cmp); 
			$sql8831="select * from $brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c.")"; 
			//echo $sql8831."<br>";
			$result8831=mysqli_query($link, $sql8831) or die("Error=8".mysqli_error($GLOBALS["___mysqli_ston"])); 
			$rows1=mysqli_num_rows($result8831);
			
			$sql883="select * from $brandix_bts.tbl_miniorder_data where docket_number in (".$docket_t_c.")"; 
			//echo $sql883."<br>";
			$result883=mysqli_query($link, $sql883) or die("Error=8".mysqli_error($GLOBALS["___mysqli_ston"])); 
			$rows=mysqli_num_rows($result883);
			if($rows>0)
			{
				$status=1;
			}
			else
			{
				$status=0;
			}	
			
		}
		else
		{			
			$status=0;
		}
	}
	//echo "Ststtua---".$status."----Rows1--".$rows1."----Rows--".$rows."<br>";
	if($status==0)
	{	
		$order_tids=array();
		$sql4533="select * from $bai_pro3.bai_orders_db_confirm where order_joins='$order_joins' and order_del_no='".$schedule."'";
		//echo $sql4533."<br>";
		$sql_result4533=mysqli_query($link, $sql4533) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row4533=mysqli_fetch_array($sql_result4533))
		{
			$order_tids[]=$sql_row4533["order_tid"];
			$order_del_no[]=$sql_row4533["order_del_no"];
			$order_col_des[]=$sql_row4533["order_col_des"];
		}
		
		$sql4531="delete from $bai_pro3.bai_orders_db where order_tid in ('".implode("','",$order_tids)."')";
		// echo $sql4531."<br>";
		$sql_result4531=mysqli_query($link, $sql4531) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql4551="INSERT IGNORE INTO $bai_pro3.bai_orders_db SELECT * FROM $bai_pro3.bai_orders_db_club WHERE order_tid IN  ('".implode("','",$order_tids)."')";
		// echo $sql4551."<br>";
		$sql_result4551=mysqli_query($link, $sql4551) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql4536="delete from $bai_pro3.bai_orders_db_confirm where order_tid in ('".implode("','",$order_tids)."')";
		// echo $sql4536."<br>";
		$sql_result4536=mysqli_query($link, $sql4536) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql45271="delete from $bai_pro3.plandoc_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4527."<br>"; 
		$sql_result45271=mysqli_query($link, $sql45271) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql452981="delete from $bai_pro3.plandoc_stat_log where order_tid in ('".implode("','",$order_tids)."')";
		// echo $sql4527."<br>"; 
		$sql_result45298=mysqli_query($link, $sql452981) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql4527="delete from $bai_pro3.allocate_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4527."<br>"; 
		$sql_result4527=mysqli_query($link, $sql4527) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql45298="delete from $bai_pro3.allocate_stat_log where order_tid in ('".implode("','",$order_tids)."')";
		// echo $sql4527."<br>"; 
		$sql_result45298=mysqli_query($link, $sql45298) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
		$sql4528="delete from $bai_pro3.cuttable_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4528."<br>";
		$sql_result4528=mysqli_query($link, $sql4528) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql4529="delete from $bai_pro3.maker_stat_log where order_tid like \"%".$schedule.$color."%\"";
		// echo $sql4529."<br>";
		$sql_result4529=mysqli_query($link, $sql4529) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		if($status==0 && $rows1>0)
		{				
			$sql102="delete from $brandix_bts.tbl_cut_size_master where parent_id in (select id from $brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c."))";
			// echo $sql102."<br>";			
			mysqli_query($link, $sql102) or die("Error=121".mysqli_error($GLOBALS["___mysqli_ston"])); 
				 
			$sql103="delete from $brandix_bts.tbl_cut_master where doc_num in (".$docket_t_c.")"; 
			// echo $sql103."<br>";
			mysqli_query($link, $sql103) or die("Error=121".mysqli_error($GLOBALS["___mysqli_ston"])); 
			 
			$sql101="delete from $brandix_bts.tbl_orders_sizes_master where parent_id in (select id from $brandix_bts.tbl_orders_master where product_schedule='$schedule') and order_col_des in ('".implode("','",$order_col_des)."')"; 
			mysqli_query($link, $sql101) or die("Error=121".mysqli_error($GLOBALS["___mysqli_ston"])); 
			// echo $sql101."<br>";
		}	
		$sql451="delete from $bai_pro3.bai_orders_db where order_del_no='".$schedule."' and order_col_des=\"".$color."\" ";
		// echo $sql451."<br>";
		$sql_result451=mysqli_query($link, $sql451) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		$sql452="delete from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des=\"".$color."\" ";
		// echo $sql452."<br>";
		$sql_result452=mysqli_query($link, $sql452) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		// echo "<h2> Mixing Colour has been removed, Please Re-mix the schedule Colours again.</h2>";
		echo "<script type=\"text/javascript\"> 
						sweetAlert('Successfully Removed the Mixing Colour','','success');
					</script>";	
	}
	else
	{
		echo "<h2> Already Sewing Orders are prepared, Can you please delete the sewing orders and try Again.</h2>";	
	}	
} 
?> 

</div></div></div>
 </body>


