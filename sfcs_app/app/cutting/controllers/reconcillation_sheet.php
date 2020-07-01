<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',3,'R'));

$path="".getFullURLLevel($_GET['r'], "bundle_guide_print.php", "0", "r")."";
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); ?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value+"&color="+window.btoa(unescape(encodeURIComponent(document.test.color.value)));
	window.location.href = uriVal;
}
$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
	});
	$('#color').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == null && schedule == null){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule == null){
			sweetAlert('Please Select Schedule','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
});

</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	//include("menu_content.php");
	$style=style_decode($_GET['style']);
	$schedule=$_GET['schedule']; 
    $color=color_decode($_GET['color']);
    if(isset($_POST['submit']))
    {
        $style=$_POST['style'];
        $color=$_POST['color'];
        $schedule=$_POST['schedule'];
    }
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Module Reconcillaiton Form</div>
<div class = "panel-body">
<form name="test" action="?r=<?php echo $_GET['r']; ?>" method="post">
<?php
$sql="select order_style_no from $bai_pro3.packing_summary_input group by order_style_no ";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style' required>";
echo "<option value='' disabled selected>Please Select</option>";
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
echo "  </select>
	</div>";
?>

<?php
echo "<div class='col-sm-2'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule' required>";
	$sql="select order_del_no from $bai_pro3.packing_summary_input where order_style_no='".$style."' group by order_del_no";	

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
			echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
		}
	else{
		echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
	}
}

echo "	</select>
	 </div>";
?>

<?php

	echo "<div class='col-sm-3' style='padding-top:23px;'>"; 
	echo "<input class='btn btn-success' type=\"submit\" value=\"Submit\" name=\"submit\" id='submit'>
	 </div>";	
echo "</div>";
?>

</form>

<hr/>

<?php
if(isset($_POST['submit']))
{

	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$sno=1;	
		
	$sewing_job=array();
	$sewing_job_cols=array();
	$sewing_job_qty=array();
	$sewing_job_bundle=array();
	$cuts_sew=array();
	$sewing_job_rand=array();
	$sql12="SELECT type_of_sewing,input_job_no_random,input_job_no,COUNT(*) AS bundles,
	GROUP_CONCAT(DISTINCT order_col_des ORDER BY order_col_des) AS order_col_des,GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno,
	SUM(carton_act_qty) AS carton_act_qty 
	FROM $bai_pro3.packing_summary_input WHERE order_del_no=$schedule GROUP BY input_job_no*1";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result12)>0)
	{
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{			
			$sewing_job_nos[]=$sql_row12['input_job_no']; 
			$sewing_job_rand[$sql_row12['input_job_no']]=$sql_row12['input_job_no_random']; 
			$sewing_job_cols[$sql_row12['input_job_no']]=$sql_row12['order_col_des']; 
			$sewing_job_qty[$sql_row12['input_job_no']]=$sql_row12['carton_act_qty']; 
			$sewing_job_bundle[$sql_row12['input_job_no']]=$sql_row12['bundles']; 
			$cuts=explode(",", $sql_row12['acutno']);
			
			$sql322="select prefix from $brandix_bts.tbl_sewing_job_prefix where id=".$sql_row12['type_of_sewing']."";
			$sql_result12321=mysqli_query($link, $sql322) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row12213=mysqli_fetch_array($sql_result12321))
			{				
				$sewing_job[$sql_row12['input_job_no']]  = $sql_row12213['prefix'].leading_zeros($sql_row12['input_job_no'],3);				
			}
			
			$cut_jobs_new='';
			for($ii=0;$ii<sizeof($cuts);$ii++)
			{
				$arr = explode("$", $cuts[$ii], 2);
			   	$sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."' and order_col_des='".$arr[0]."'";
				$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row4=mysqli_fetch_array($sql_result4))
				{
					$color_code=$sql_row4["color_code"];					
				}				
				$cut_jobs_new .= chr($color_code).leading_zeros($arr[1], 3)."<br>";
				unset($arr);
			}
			$cuts_sew[$sql_row12['input_job_no']]=$cut_jobs_new;
			$cut_jobs_new='';
		}
		
		$sql41="select vpo from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
		$sql_result41=mysqli_query($link, $sql41) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row41=mysqli_fetch_array($sql_result41))
		{
			$vpo=$sql_row41["vpo"];
		}
		
		echo "<div class='alert alert-info' style='text-align:center; font-size: 20px;'><b>Style Code : ".$style."</b>Schedule : <b>".$schedule."</b> VPO No : <b>".$vpo."</b></div>";
		
		echo "<div class='col-sm-12 table-responsive'>
		<table width='100%' class='table table-bordered info'><thead>
		<tr><th>S No</th><th>Sewing Job No</th><th>Cut Job No</th><th>No Of Bundles</th><th>Quantity</th><th>Color</th><th>Control</th></thead>";
		$colors=array();$sjob=0;
		$url1 = getFullURLLevel($_GET['r'],'input_sheet_print.php',0,'R');
		for($i=0;$i<sizeof($sewing_job_nos);$i++)
		{
			$colors=explode(",",$sewing_job_cols[$sewing_job_nos[$i]]);
			$sjob=$sewing_job_rand[$sewing_job_nos[$i]];
			$size=sizeof($colors);
			echo "<tr><td rowspan=".$size.">".$sno."</td><td rowspan=".$size.">".$sewing_job[$sewing_job_nos[$i]]."</td><td rowspan=".$size.">".$cuts_sew[$sewing_job_nos[$i]]."</td>
			<td rowspan=".$size.">".$sewing_job_bundle[$sewing_job_nos[$i]]."</td><td rowspan=".$size.">".$sewing_job_qty[$sewing_job_nos[$i]]."</td>";
			for($ii=0;$ii<sizeof($colors);$ii++)
			{	
				if($ii==0)
				{
					$main_color = color_encode($colors[$ii]);
					echo "<td>".$colors[$ii]."</td>";					
					echo "<td><a class='btn btn-warning' href='$url1?color=$main_color&input_job=$sjob' onclick=\"return popitup2('$url1?color=$main_color&input_job=$sjob')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>Click Here to Print</td></tr>";
					
				}
				else
				{
					$main_color = color_encode($colors[$ii]);
					echo "<tr><td>".$colors[$ii]."</td>";					
					echo "<td><a class='btn btn-warning' href='$url1?color=$main_color&input_job=$sjob' onclick=\"return popitup2('$url1?color=$main_color&input_job=$sjob')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>Click Here to Print</td></tr>";
				}			
			}
			$sno++;
			unset($colors);
		}
		echo "</table></div>";
	}
}

	
   ?> 
   </div>
   </div>
   </div>
   </div>
  