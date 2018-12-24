<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));  
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
?> 

<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<title>Plan Dashboard</title>
<style> 
body 
{ 
    font-family: Trebuchet MS; 
} 
</style> 
<script> 
var url = '<?= getFullURLLevel($_GET['r'],'cut_job_test_new.php',0,'N'); ?>'; 
function firstbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value 
} 

function secondbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value 
} 

function thirdbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value 
} 
</script> 
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> --> 

</head> 
<!-- <link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',4,'R'); ?>" rel="stylesheet" type="text/css" /> --> 
<body> 

<?php  

$style=$_GET['style']; 
$schedule=$_GET['schedule'];  
$color=$_GET['color']; 

?> 

<div class="panel panel-primary"> 
<div class="panel-heading">Cut Job Production Planning Panel</div> 
<div class="panel-body"> 
<form name="test" action="index.php?r=<?php echo $_GET['r'];  ?>" method="post"> 
<?php 

echo "<div class='row'>"; 
	echo "<div class='col-sm-3'><label>Select Style: </label><select name=\"style\" onchange=\"firstbox();\" class='form-control' required>"; 
	$sql="select distinct order_style_no from $bai_pro3.bai_orders_db_confirm"; 
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	echo "<option value=\"\" selected>NIL</option>"; 
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

	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and $order_joins_in_full";     
	echo "<div class='col-sm-3'><label>Select Schedule: </label><select name=\"schedule\" onchange=\"secondbox();\" class='form-control' required>"; 
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	echo "<option value=\"\" selected>NIL</option>"; 
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

	echo "<div class='col-sm-3'><label>Select Color: </label>"; 
	// $sql="select GROUP_CONCAT(DISTINCT trim(order_col_des)) AS disp,max(plan_module),order_col_des from order_cat_doc_mix where order_style_no=\"$style\" and order_del_no=\"$schedule\" and clubbing>0 group by clubbing union select DISTINCT order_col_des,plan_module,order_col_des AS disp from $bai_pro3.order_cat_doc_mix where order_style_no=\"$style\" and order_del_no=\"$schedule\" and clubbing=0 group by clubbing,order_col_des";
	$sql="SELECT GROUP_CONCAT(DISTINCT trim(order_col_des)) AS disp,order_col_des FROM bai_pro3.`bai_orders_db_confirm` LEFT JOIN bai_pro3.`plandoc_stat_log` ON bai_orders_db_confirm.`order_tid`=plandoc_stat_log.`order_tid` WHERE order_style_no=\"$style\" AND order_del_no=\"$schedule\" AND $order_joins_in_full group by order_col_des";
	// echo $sql;
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
	echo "<select name=\"color\" onchange=\"thirdbox();\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>"; 
				while($sql_row=mysqli_fetch_array($sql_result)) 
				{ 
					if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color)) 
					{ 
						echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['disp']."</option>"; 
					} 
					else 
					{ 
						echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['disp']."</option>"; 
					} 
				}
	echo "</select></div>"; 

	$check_status = echo_title('bai_pro3.bai_orders_db_confirm', 'order_joins', "order_style_no='$style' and order_del_no='$schedule' and order_col_des", $color, $link); 
	if ($check_status < 3 )
	{
		$code=""; 
		$sql="select doc_no,color_code,acutno,act_cut_status,cat_ref from $bai_pro3.plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" and doc_no not in (select doc_no from  $bai_pro3.cutting_table_plan) and ( act_cut_status='') order by doc_no"; 
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		while($sql_row=mysqli_fetch_array($sql_result)) 
		{ 
			$doc_no_for_recut = $sql_row['doc_no'];
			$remarks_query = "select * from $bai_pro3.plandoc_stat_log where doc_no = $doc_no_for_recut";
			$remarks_query_result=mysqli_query($link,$remarks_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($remarks_row=mysqli_fetch_array($remarks_query_result)) 
			{
				$remarks = $remarks_row['remarks'];
			}
			if(strtolower($remarks) == 'recut')
			{
				$code.=$sql_row['doc_no']."-R".leading_zeros($sql_row['acutno'],3)."-".$sql_row['act_cut_status']."*"; 
				$cat_ref= $sql_row['cat_ref']; 
			}
			else
			{
				$code.=$sql_row['doc_no']."-".chr($sql_row['color_code']).leading_zeros($sql_row['acutno'],3)."-".$sql_row['act_cut_status']."*"; 
				$cat_ref= $sql_row['cat_ref']; 
			}
		}	 

		$sql= "select cat_ref from $bai_pro3.plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" order by doc_no"; 

		$sql_result=mysqli_query($link,$sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
		$sql_num_check=mysqli_num_rows($sql_result); 
		while($sql_row=mysqli_fetch_array($sql_result)) 
		{ 
		    $cat_ref=$sql_row['cat_ref']; 
		} 
		echo "</br><div class='col-sm-3'>"; 
		if($sql_num_check>0) 
		{ 
		    echo "Cut Jobs Available:"."<font color=GREEN class='label label-success'>YES</font>"; 
		    echo "<input type=\"hidden\" name=\"code\" value=\"$code\">"; 
		    echo "<input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">"; 
		    echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"submit\" name=\"submit\">";     
		} 
		else 
		{ 
		    echo "Cut Jobs Available: <font color=RED size=5>No</font>"; 
		} 
		echo "</div>"; 

		 
	}
	else
	{
		echo "<font color=RED size=5>Not Eligible (Because Schedule Clubbed)</font>"; 
	}
	echo "</div></div></form>";

?> 
</body> 
<?php 
if(isset($_POST['submit'])) 
{ 
    $style=$_POST['style']; 
    $color=$_POST['color']; 
    $schedule=$_POST['schedule']; 
    $code=$_POST['code']; 

    $cat_ref=$_POST['cat_ref']; 
     
    $data_sym="$"; 
     

    $my_file = getFullURLLevel($_GET['r'],'cut_job_drag_drop_data.php',0,'R'); 

    $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file); 

    $stringData = "<?php ".$data_sym."style_ref=\"".$style."\"; ".$data_sym."schedule_ref=\"".$schedule."\"; ".$data_sym."color_ref=\"".$color."\"; ".$data_sym."cat_ref_ref=\"".$cat_ref."\"; ".$data_sym."code_ref=\"".$code."\"; ?>"; 

    fwrite($handle, $stringData); 
    fclose(handle); 

     
    //echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"drag_drop.php?color=$color&style=$style&schedule=$schedule&code=$code&cat_ref=$cat_ref\"; }</script>"; 
    $url = getFullURLLevel($_GET['r'],'cut_job_drag_drop.php',0,'N'); 
    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>"; 
} 
?>