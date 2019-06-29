<?php 

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/js/jquery.min1.7.1.js',4,'R'));

if(isset($_GET['gatepassid']))
{
$gatepassid=$_GET['gatepassid'];
$sql12="select vehicle_no from $brandix_bts.gatepass_table where id=".$gatepassid." and vehicle_no=''";
$sql_result123=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result123)>0)
{	
	?>
	<div class="panel panel-primary">
    <div class="panel-heading">Gate Pass</div>
    <div class="panel-body">
            <form method="post" name="input" action="<?php echo '?r='.$_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-2">
                        <label>Enter Vehice Number: </label>
                        <input type="text"  id="vehicle_no"  name="vehicle_no" class="form-control"  value="<?php  if(isset($_POST['vehicle_no'])) { echo $_POST['vehicle_no']; } else { echo ""; } ?>" />
                         <input type="hidden"  id="gatepassno"  name="gatepassno" class="form-control"  value="<?=$gatepassid; ?>" />
                    </div>
                    <div class="row">
                    <div class="col-md-8">
                        <input type="submit" value="Generate Gate Pass" name="submit" class="btn btn-success"  style="margin-top:22px;">
                    </div>
                    </div>
                </div> 
            </form><br/>
	<?php	
}
else
{
	while($sql_row12=mysqli_fetch_array($sql_result123))
	{
		$vehicle_no=$sql_row12['vehicle_no'];	
	}
	$url = getFullURLLEVEL($_GET['r'],'gatepass_summery_detail.php',0,'N');
	echo "<script>window.location = '$url&vehicle_no=$vehicle_no&status=0&gatepassno=$gatepassid';</script>";	
}
?>

<?php

}



if(!isset($_GET['gatepassid']) && !isset($_POST['submit']) && !isset($_GET['status']))
{
    ?>
    <div class="panel panel-primary">
    <div class="panel-heading">Gate Pass</div>
    <div class="panel-body">
            <form method="post" name="input" action="<?php echo '?r='.$_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-2">
                        <label>Select Date: </label>
                        <input type="text" data-toggle="datepicker" id="date_select"  name="date" class="form-control"  size=8/>
                         <input type="hidden"  id="gatepassno"  name="gatepassno" class="form-control"  value="<?=$gatepassid; ?>" />
                    </div>
                    <div class="row">
                    <div class="col-md-8">
                        <input type="submit" value="Get Details" name="submitdetails" class="btn btn-success"  style="margin-top:22px;">
                    </div>
                    </div>
                </div> 
            </form><br/>
            <?php     
    }
  
    ?>

<style>
th,td{
    text-align:center;
}
</style>


<?php
if(isset($_POST['submit']) || isset($_GET['status'])){

	if($_GET['gatepassno']>0)
	{
		$vehicle_number=$_POST['vehicle_no'];
		$gate_id=$_POST['gatepassno'];
		$sql33="update $brandix_bts.gatepass_table set vehicle_no='$vehicle_number',gatepass_status=2 where id=".$gate_id."";
		mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
   	}
	else
	{
		$vehicle_number=$_GET['vehicle_no'];
		$gate_id=$_GET['gatepassno'];	
	}
    
	// echo $vehicle_number."---".$gate_id."<br>";
	// die();
	
	$sql_total="SELECT style,schedule,color,SUM(bundle_qty) AS qty_bundle,COUNT(bundle_no) AS bundle_count FROM $brandix_bts.`gatepass_track` where gate_id=".$gate_id." GROUP BY style,schedule,color";
	$sql_grand_total_res = mysqli_query($link,$sql_total) or exit('error in heading table view');
	while($res_row12 = mysqli_fetch_array($sql_grand_total_res))
	{
		$array_res[]=$res_row12;
	}
	$sql="select style,schedule,color,size from $brandix_bts.gatepass_track where gate_id=".$gate_id." group by style,schedule,color,size";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$styles[]=$sql_row['style'];
		$schedule[]=$sql_row['schedule'];
		$color[]=$sql_row['color'];	
		$size[]=$sql_row['size'];	
	}
	$styles=array_values(array_unique($styles));
	$schedule=array_values(array_unique($schedule));
	$color=array_values(array_unique($color));
	$size=array_values(array_unique($size));
	$tot_qty=0;
	$tot_bds=0;
	$sql1="select style,schedule,color,size,sum(bundle_qty) as qty,count(bundle_no) as cnts from $brandix_bts.gatepass_track where gate_id=".$gate_id." group by style,schedule,color,size";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$quantity[$sql_row1['schedule']][$sql_row1['color']][$sql_row1['size']]=$sql_row1['qty'];
		$bundles[$sql_row1['schedule']][$sql_row1['color']][$sql_row1['size']]=$sql_row1['cnts'];
		$tot_qty=$tot_qty+$sql_row1['qty'];
		$tot_bds=$tot_bds+$sql_row1['cnts'];
	}
	$sql12="select schedule,color,sum(bundle_qty) as qty,count(bundle_no) as cnts from $brandix_bts.gatepass_track where gate_id=".$gate_id." group by schedule,color";
	$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
	while($sql_row12=mysqli_fetch_array($sql_result12))
	{
		$quantity_val[$sql_row12['schedule']][$sql_row12['color']]=$sql_row12['qty'];
		$bundles_val[$sql_row12['schedule']][$sql_row12['color']]=$sql_row12['cnts'];
	}
	/* Summary View */
	echo "<div>Vehicle No:  
	<button class='btn btn-warning' >".$vehicle_number."</button>									
	</div>";
	
	echo "</br></br>";
	$url=getFullURL($_GET['r'],'gate_pass_print.php','R');
	echo "<div class='col-sm-12'><br><div class='alert alert-info' style='font-size:13px;padding:5px'>Generated gatepass Summary View.           
	<a class='btn btn-warning' href='$url?pass_id=".$gate_id."&type=1' >Print Gate Pass - ".$gate_id."</a>									
	</div>";
	 echo"<div class='panel-body'>
    <div class='panel panel-primary'>
	<table class='table table-bordered'>";
	echo "<tr class='warning'> 
			<th class='tblheading'>Style</th>
			<th class='tblheading' >Schedule</th>
			<th class='tblheading'>Color</th>
			<th class='tblheading'>Qty</th><th class='tblheading'>Number of Bundles</th></tr>
			<tr style='background-color:#efef99'><th colspan=3 style='text-align: left;'>Grand Total:</th>";
			echo "<th>$tot_qty</th><th>$tot_bds</th></tr>";
			foreach ($array_res as $key => $value) {
				echo "<tr><td>".$array_res[$key]['style']."</td><td>".$array_res[$key]['schedule']."</td><td>".$array_res[$key]['color']."</td><td>".$array_res[$key]['qty_bundle']."</td><td>".$array_res[$key]['bundle_count']."</td></tr>";   
			}
		  
	echo "</table></div></div></br>";
	
	/* Summary View */
	echo "<div class='col-sm-12'><br><div class='alert alert-info' style='font-size:13px;padding:5px'>Generated gatepass Detailed View. 
	<a class='btn btn-warning' href='$url?pass_id=".$gate_id."&type=2' >Print Gate Pass - ".$gate_id."</a></div>";
	echo"<div class='panel-body'>
    <div class='panel panel-primary'>
	<table class='table table-bordered'>";
	echo "<tr class='warning'> 
	<th class='tblheading'>Style</th>
	<th class='tblheading' >Schedule</th>
	<th class='tblheading'>Color</th>
	<th class='tblheading'>Size</th>
	<th class='tblheading'>Qty</th><th class='tblheading'>Number of Bundles</th></tr>
	<tr style='background-color:#efef99'><th colspan=4 style='text-align: left;'>Grand Total:</th>";
	echo "<th>$tot_qty</th><th>$tot_bds</th></tr>";
	for($i=0;$i<sizeof($styles);$i++)
	{
		for($ii=0;$ii<sizeof($schedule);$ii++)
		{
			for($iii=0;$iii<sizeof($color);$iii++)
			{
				if($bundles_val[$schedule[$ii]][$color[$iii]]<>'')
				{					
					echo "<tr style='background-color:#4dd2ff'><td>".trim($styles[$i])."</td><td>".$schedule[$ii]."</td><td>".substr($color[$iii],0,15)."</td><td></td><td>".$quantity_val[$schedule[$ii]][$color[$iii]]."</td><td>".$bundles_val[$schedule[$ii]][$color[$iii]]."</td></tr>";   					
				}
				for($iiii=0;$iiii<sizeof($size);$iiii++)
				{
					if($bundles[$schedule[$ii]][$color[$iii]][$size[$iiii]]<>'')
					{				
						echo "<tr><td>".trim($styles[$i])."</td><td>".$schedule[$ii]."</td><td>".substr($color[$iii],0,15)."</td><td>".$size[$iiii]."</td><td>".$quantity[$schedule[$ii]][$color[$iii]][$size[$iiii]]."</td><td>".$bundles[$schedule[$ii]][$color[$iii]][$size[$iiii]]."</td></tr>";   						
					}
				}
			}
		}
	}
		  
	echo "</table></div></div>";
	
	}

	if(isset($_POST['submitdetails'])){
		$date=$_POST['date'];
		$sql_date="select * from $brandix_bts.`gatepass_table` where date='$date' ";
	// echo $sql_date;
		$date_gatepass = mysqli_query($link,$sql_date) or exit('error in heading table view222');
		echo  "<div class='panel-body'>";
		echo "<div class='panel panel-primary'>";
		echo '<table class="table table-bordered"><tr class="warning"><th class="tblheading">Date</th><th class="tblheading">Gate Pass Id</th><th class="tblheading">Operation</th><th class="tblheading">Vehicle No</th><th class="tblheading">Shift</th><th class="tblheading">Status</th></tr>';
		$url = getFullURLLEVEL($_GET['r'],'gatepass_summery_detail.php',2,'N');
		while($data_res = mysqli_fetch_array($date_gatepass))
		{
			$id=$data_res['id'];
			$shift=$data_res['shift']; 
			$status=$data_res['gatepass_status'];    
			$operation=$data_res['operation'];    
			$vehicle_no=$data_res['vehicle_no'];    
			$date_get=$data_res['date'];   
			$sql1122="select operation_name from $brandix_bts.tbl_orders_ops_ref where operation_code=".$operation."";
			$sql_result1w23=mysqli_query($link, $sql1122) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
			while($sql_row1212=mysqli_fetch_array($sql_result1w23))
			{
				$ops_name=$sql_row1212['operation_name'];
			}
			if($status==1)
			{
				$remark='In Progress';	
			}	
			else
			{
				$remark='Completed';
			}			
			echo "<tr><td>$date_get</td><td><a class='btn btn-warning' href='$url?pass_id=".$id."&type=1' >Print Gate Pass - ".$id."</a></td><td>$ops_name</td><td>$vehicle_no</td><td>$shift</td><td>$remark</td></tr>";
		 }
		 echo '</table></div></div>';
	 
	}
                ?>