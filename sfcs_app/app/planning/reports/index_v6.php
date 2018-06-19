<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="600" />
<title>Delivery Schedule</title>
<?php 
$has_perm=haspermission($_GET['r']);
// include("dbconf.php"); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

$test="0";
$status_cut="Cut Finish";
//$today= date('Y-m-d');
$endday=Date('Y-m-d', strtotime("+14 days"));
$today=Date('Y-m-d', strtotime("-2 days"));

//$today= "2013-06-05";
//$endday="2013-06-05";

?>
<link href="main.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R')?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>

<!--
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.tipTip.js',1,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.tipTip.minified.js',1,'R')?>"></script>-->
<link href="<?= getFullURLLevel($_GET['r'],'common/js/tipTip.css',1,'R')?>" rel="stylesheet" type="text/css" />

	<script type="text/javascript">
		$(function(){
		// $(".someClass").tipTip({maxWidth: "auto", edgeOffset: 10,fadeIn:0});
		});
	</script>
	<style>
		th,td
		{
			white-space: nowrap;
			text-align: center;
		}
	</style>
</head>

<body style="margin:0px;">
<div class = "panel panel-primary">
<div class = "panel-heading">Delivery Schedule Report</div>
<div class = "panel-body table-responsive">
<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\" style=\"overflow-x: auto\" >
<!-- <div class="main_outer1" style="overflow: hidden;display:block;position:fixed;top:0px; right:auto;left:0px;padding-top:0px;width:1300px;background-color:#FFF;"> -->
<span style="margin-left:50px;"><?php echo "Last Refreshed Time  ". date("g.i a", time()); ?></span>
<table width=100% id="table1" name="table1" class="table table-striped table-bordered">
    <thead>
    <tr  style="height:15px;background-color:#606;color:#FFF;font-weight:bold;">
	   <th>Week.</th>
     
      <th>Buyer</th>
      <th>PO</th>  
      <th>Style</th>
      <th>Schedule</th>
	  <th>Mode</th>
	  <th>FR Team </th>
	  <th>Plan Team</th>
      <th>Ex fac Date</th>
      <th>Possible Ex Fac</th>
      <th>Comment</th>
      <th>Order Qty</th>
      
      <th>Cut Qty</th>
      <th>In</th>
      <th>Out </th>
     
     <th>Completion Date</th>
      <th >FA </th>
      <th >CIF </th>
       <th>Dis</th>
	   
    
      <th>Action </th>
      
    </tr>
</thead>
    <!-- </table> -->
<!-- </div> -->
<!-- <div class="main_outer1" style="overflow:auto;padding-top:0px;width:1300px;margin-left:0px;padding-left:0px;text-align:left;">
  
  
  <table width="1300px" border="0" style="margin-top:60px;margin-left:0px;padding-left:0px;" align="left" id="table1">
  
  <tr style="visibility:hidden">
  <td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td><td >m</td>
  
  </tr> -->
    <?php



$sql_schedule="SELECT 	* FROM $bai_pro3.`temp_delivery_schedule` WHERE ex_date BETWEEN \"$today\" and \"$endday\" AND `status` not in ('Completed' , 'Short shipped') GROUP BY ex_date ,`schedule`   order by ex_date ASC	";

	$sql_schedule_result=mysqli_query($link, $sql_schedule) or exit ("Sql Error in Order QTY2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_schedule_result);
	while($sql_row=mysqli_fetch_array($sql_schedule_result))
	{ 
		$status=$sql_row['status '];
		$order_div=$sql_row['buyer_lable' ];
		$po_no=$sql_row['po_no' ];
		$style_no=$sql_row['style' ];
		$schedule_no=$sql_row['schedule' ];
		$ex_date=$sql_row['ex_date' ];
		$weeknum=date("W", strtotime($ex_date));
		$destination=$sql_row['des' ];
		$order_qty=$sql_row['order_qty' ];
		$cut_qty=$sql_row['cut_qty' ];
		$ims_in_qty=$sql_row['in_qty' ];
		$ims_out_qty=$sql_row['out_qty' ];	
		$folding_qty=$sql_row['folding_qty' ];
		$folding_date=$sql_row['folding_date' ];
		$carton_qty=$sql_row['carton_qty' ];
		$carton_date=$sql_row['carton_date' ];
		$fa_qty=$sql_row['fa_qty' ];
		$fa_date=$sql_row['fa_date' ];
		$cif_qty=$sql_row['cif_qty' ];
		$cif_date=$sql_row['cif_date' ];
		$dispatch_qty=$sql_row['dispatch_qty' ];
		$dispatch_date=$sql_row['dispatch_date' ];
		$team_no=$sql_row['team_no' ];
		
		$comnt="";
		$comnt_user="";
		
		$que1="SELECT mode from $bai_pro2.deliver_mode where order_del='$schedule_no'";
		$que1_result=mysqli_query($link, $que1) or exit ("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($que1_row=mysqli_fetch_array($que1_result))
			{ 
				$mode=$que1_row['mode'];
			}
		else{
				$mode="";
			}
			
		$que2="SELECT team from $bai_pro2.fr_data where schedule='$schedule_no'";
		$que2_result=mysqli_query($link, $que2) or exit ("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		if($que2_row=mysqli_fetch_array($que2_result))
			{ 
				$fr_team=$que2_row['team'];
			}
		else{
				$fr_team="Not Planned";
			}
		$sql_cmnt="SELECT * FROM $bai_pro3.tbl_comment WHERE sch_no='$schedule_no'";
//echo $sql_schedule;
	mysqli_query($link, $sql_cmnt) or exit ("Sql Error in CMNT QTY1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_cmnt_result=mysqli_query($link, $sql_cmnt) or exit ("Sql Error in CMNT QTY2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_cmnt_result);
	if($sql_row_cmnt=mysqli_fetch_array($sql_cmnt_result))
	{ 
		$comnt=$sql_row_cmnt['sch_cmnt'];
		$comnt_user=$sql_row_cmnt['username'];
		$ped=$sql_row_cmnt['possible_ex'];
		$cd=$sql_row_cmnt['comp_date'];
		$fca=$sql_row_cmnt['fca'];
		$cif=$sql_row_cmnt['cif'];
		$dispatch=$sql_row_cmnt['dispatch'];
	
		
		
	}else{
		$comnt="";
		$comnt_user="";
		$ped="";
		$cd="";
		$fca="";
		$cif="";
		$dispatch="";
	
	
	}
		
		if($test=="0")
		{
			$test="1";
		}else if($test=="1")
		{
			$test="0";
		}
		
		 if($dispatch_date!="0000-00-00 00:00:00")
		{
			
			if($order_qty<=$dispatch_qty)
			{
				$org_status="10";
				$status_cut="Completed";
			}
			else
			{
				$org_status="11";
				$status_cut="Short shipped";
			}
		}
		else if($cut_qty=="0")
		{
			$org_status="1";
			$status_cut="Cut Pending";
		}else if($status_cut=="Cutting")
		{
			$org_status="2";
		}else if($status_cut=="Cut Finish" and $cut_qty=="0" )
		{
			$org_status="3";
			$status_cut="Sewing Pending";
		}else if($ims_in_qty!="0" and ($order_qty>$ims_out_qty))
		{
			$org_status="4";
			$status_cut="Sewing";
		}else if($cif_date!="0000-00-00 00:00:00")
		{
			$org_status="9";
			$status_cut="Dispatch Pending";
		}else if($fa_date!="0000-00-00 00:00:00")
		{
			$org_status="8";
			$status_cut="CIF";
		}else if($carton_date!="0000-00-00 00:00:00")
		{
			$org_status="7";
			$status_cut="FA";
		}else if($folding_date!="0000-00-00 00:00:00")
		{
			$org_status="6";
			$status_cut="Carton";
		}else if($order_qty<=$ims_out_qty)
		{
			$org_status="5";
			$status_cut="Folding";
		}
		

		
	?>
		
	<?php if($org_status!="10") { ?>	
	<tbody>	
    <tr class="<?php if($test=="0"){ ?> hlight<?php } ?> m_over <?php if($fa_qty=="Fail" or $cif_qty=="Fail" ){ ?> fca_fail <?php } else if($fa_qty=="Pass1" or $cif_qty=="Pass1"){ ?> fca_pass <?php } ?>">
     <td><?php  echo $weeknum;  ?></div>
    <td><?php echo $order_div;
	  
	 
	  //include("incude_buyer_lable.php");
	  
	  ?></td>
      <td ><?php echo $po_no; ?></td>
    
     
      <td  ><?php echo $style_no; ?></td>
      <td ><?php echo $schedule_no; ?></td>
	  <td ><?php echo $mode; ?></td>
	  <td>
	  <?php  
	  echo $fr_team;
	  ?></td>
	    <td >
	  <?php  
	  echo $team_no;
	  ?></td>
	  
      
       <td ><?php echo date('m-d', strtotime($ex_date)); ?></td>
	    <td  > <?php
		if($ped != ""){
		echo date('m-d', strtotime($ped));
		}else{
		$ped="";
		}
		?></td>
     
      
      
      <td ><?php echo $comnt; ?></td>
      <td><?php echo $order_qty; ?></td>
      <td  <?php if($org_status=="1" || $org_status=="2"){ ?>class="del_dashboard_red" <?php } ?> ><?php echo $cut_qty; ?></td>
      <td  <?php if($org_status=="4" || $org_status=="3"){ ?>class="del_dashboard_red" <?php } ?> ><?php echo $ims_in_qty; ?></td>
      <td  <?php if($org_status=="4" ){ ?>class="del_dashboard_red" <?php } ?> ><?php echo $ims_out_qty; ?></td>
    <td ><?php 
	if($cd != ""){
	echo date('m-d', strtotime($cd)); }else { $cd=""; }?></td>
	<td >
	  <?php echo $fca;   ?>
	  </td>
     <td >
	  <?php echo $cif;   ?>
	  </td>
	   <td></td>
   
      <td >
	<?php 
	 // $username_list=explode('\\',$_SERVER['REMOTE_USER']);
		// 	$username=strtolower($username_list[1]);
	// $username="sfcsproject1";
			// $super_user=array("hasithada","thusharako","thilinana","chathurangad","dinushapre","dineshp","harshanak","sfcsproject1");
							
				if (in_array($authorized,$has_perm)){  ?>
				
	  <a href="<?= getFullURL($_GET['r'],'comment_creation.php','N'); ?>&style=<?php echo $style_no; ?>&schedule=<?php echo $schedule_no; ?>" ><img src="<?= getFullURL($_GET['r'],'images/memo.png','R');?>" width="32" height="32" border="0" /></a></td>
    <?php   } ?>
	
	</tr>
</tbody>	
    
    <?php }  } ?>
  </table>
	
  </div> 
</div>
</div>


</body>


<!-- <div id="tiptip_holder">
<div id="tiptip_content">
<div id="tiptip_arrow">
<div id="tiptip_arrow_inner"></div>
</div>
</div>
</div> -->
</html>
<script language="javascript" type="text/javascript">
//<![CDATA[
var MyTableFilter = { col_0: "select",
						col_1: "select",
							col_5: "select",
							col_6: "select",
							col_7: "select",
							col_8: "select",
							col_9: "select",
							col_10: "select",
							col_11: "select",
							col_12: "select",
							col_13: "select",
							col_14: "select",
							col_16: "select",
							
							on_change: true,
							btn_reset_text: "Clear",
							display_all_text: "All",
							sort_select: true }

	setFilterGrid( "table1",MyTableFilter );
//]]>
</script>