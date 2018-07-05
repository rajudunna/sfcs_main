<?php
 include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
set_time_limit(2000);
?>

<?php  
$module=$_GET['module'];
$docket=$_GET['docket'];
$input_job_no=$_GET['input_job_no'];
$input_job_rand_ref=$_GET['input_job_rand_ref'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<!-- POP up window -  start  -->
<script>         
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
<!-- POP up window -  End  -->
</head>
<style>
body
{
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size:10px;
	color:#000;
	margin:0px;
	
	
}
td
{
	border-bottom:1px dotted #ccc;
}

.header1
{
	background-color:#227EE6;
	color:#FFF;
	font-size:15px;
	font-weight:bold;
	text-align:center;
	height:30px;
	border-bottom:0px;
}

.header2
{
	background-color:#06F;
	color:#FFF;
	font-size:15px;
	font-weight:bold;
	text-align:center;
	height:30px;
	border-bottom:0px;
}

.header3
{
	background-color:#EDFEFE;
	color:#06F;
	font-size:13px;
	
	text-align:center;
	height:30px;
	border-bottom:0px;
}

.info_row
{
	font-size:14px;
	color:#666;
	text-align:center;
	height:25px;
}
</style>
<body>


<?php
$sqljob="SELECT SUM(carton_act_qty) AS Job_tot,input_job_no FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random='".$input_job_rand_ref."' and input_job_no='".$input_job_no."'";
//echo $sqljob."<br>";
$sql_job1=mysqli_query($link, $sqljob) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_job2=mysqli_fetch_array($sql_job1);
$job_no=$sql_job2['input_job_no'];
//echo substr($input_job_rand_ref,0,6)."<br>";
$schedule_ref=substr($input_job_rand_ref,0,6);
$job_tot=$sql_job2['Job_tot'];


$sqldoc="SELECT ims_schedule,GROUP_CONCAT(DISTINCT  ims_color) AS ims_color,ims_style,ims_doc_no,ims_date,ims_size FROM $bai_pro3.ims_log WHERE input_job_no_ref='".$job_no."' and ims_schedule='".$schedule_ref."' AND ims_mod_no='".$module."'";
//echo $sqldoc."<br>";
$sql_doc=mysqli_query($link, $sqldoc) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_docket=mysqli_fetch_array($sql_doc);
?>
<table width="400" border="0" cellpadding="3" align="center">
  <tr>
    <td align="center">Module No <?php echo $module; ?>  Summary</td>
  </tr>
    </table><br />

<table width="400" border="0" cellpadding="3" align="center">
  <tr>
    <td class="header2">Style</td>
    <td class="header3"><?php echo $sql_docket['ims_style'];?></td>
    <td style="border:0px;">&nbsp;</td>
    <td class="header2">Schedule</td>
    <td class="header3"><?php echo $sql_docket['ims_schedule'];?></td>
  </tr>
  <tr>
    <td class="header2">Job No</td>
    <td class="header3">J<?php echo $job_no;?></td>
    <td style="border:0px;">&nbsp;</td>
    <td class="header2">Job qty</td>
    <td class="header3"><?php echo $job_tot;?></td>
  </tr>
  
</table>


  <br />

  <table width="600px" border="0" cellpadding="0" align="center" >
  <tr class="header1">
    <td >Date</td>
	<td >Color</td>
    <td >Size</td>
    <td>Input Qty</td>
    <td>Output Qty</td>
    <td>Rejected</td>
    <td>Balance</td>
    
  </tr>
  
<?php
$sql="SELECT input_job_rand_no_ref,ims_size,ims_color,SUM(ims_qty) AS ims_qty,SUM(ims_pro_qty) AS ims_pro_qty,MIN(ims_date) AS ims_date FROM $bai_pro3.ims_combine WHERE ims_schedule='".$schedule_ref."' and input_job_no_ref='".$job_no."' AND ims_mod_no='".$module."' GROUP BY ims_color,ims_size ORDER BY ims_date";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{ 
	$size_code=str_replace("a_","",$sql_row['ims_size']);
	//get size title from bai orders db
	$title_size='title_size_'.$size_code;
	$input_job_rand_no_ref=$sql_row['input_job_rand_no_ref'];
	$style_code=$sql_docket['ims_style'];
	$schedule_code=$sql_docket['ims_schedule'];
	$color=$sql_row['ims_color'];
	$size_title_qry="select $title_size as title from $bai_pro3.bai_orders_db_confirm where order_style_no='$style_code' and order_del_no='$schedule_code' and  order_col_des='$color'";
	//echo $size_title_qry; 
	$size_title_result=mysqli_query($link, $size_title_qry) or exit("Sql Error size_title_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($size_title_res=mysqli_fetch_array($size_title_result))
	{ 
		$size_title=$size_title_res['title'];
	}

	$rejected=0;
     $sql33="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where  qms_schedule=".$schedule_code." and qms_color=\"".$color."\" and input_job_no=\"".$input_job_rand_no_ref."\"";

	  //echo $sql33.'<br>';
	    
	  $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error888".mysqli_error($GLOBALS["___mysqli_ston"]));
	  while($sql_row33=mysqli_fetch_array($sql_result33))
	  {
	    $rejected=$sql_row33['rejected']; 
	  }
?>
 <tr class="info_row">
    <td><?php echo $sql_row['ims_date']; ?></td>
	<td><?php echo $sql_row['ims_color']; ?></td>
    <td><?php echo $size_title; ?></td>
    <td><?php echo $sql_row['ims_qty']; ?></td>
    <td><?php echo $sql_row['ims_pro_qty']; ?></td>
    <td><?php echo $rejected; ?></td>
    <td><?php echo $sql_row['ims_qty']-($sql_row['ims_pro_qty']+$rejected); ?></td>

    
  </tr>
<?php } ?>
</table>

</body>
</html>