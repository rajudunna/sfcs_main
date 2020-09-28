<style>
	table, th, td {
		text-align: center;
	}
	
#loading-image{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  /* background-image:url('ajax-loader.gif'); */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
<script>
function checkAll()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
}

</script>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',2,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R'); ?>"></script><!-- External script -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
 <div class='panel panel-primary'>
        <div class='panel-heading'>
            <h3 class='panel-title'>FG Carton Reconfirm Interface</h3>
        </div>
        <div class='panel-body'>
        


<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config_ajax.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/rest_api_calls.php',4,'R'));
$plant_code = $plant_wh_code;
?>
<?php
	if(!isset($_POST['reconfirm']))
	{
		$sql="SELECT * from $bai_pro3.pac_stat where fg_status='fail'";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$count=mysqli_num_rows($sql_result);
		if($count>0)
		{
			echo '<div class="panel-body">
			<div class="col-md-12 table-responsive">
			<table class="table table-bordered" id=\"table1\">
			<tr style="background-color:#337ab7;color:white;"><th>S.No</th><th>Style</th><th>Schedule</th><th>Carton  No</th><th>Carton ID</th><th>Carton Qty</th>';
			echo  '<th><input type="checkbox" onClick="checkAll()"/>Select All</th>
			<form action="'.getFullURLLevel($_GET["r"],"fg_carton_reconfirmation.php","0","N").'" method="POST" > </tr>';
			$i=1;
			while($sql_row=mysqli_fetch_array($sql_result))
			{                  
			   $style=$sql_row['style'];
			   $schedule=$sql_row['schedule'];
			   $carton_id=$sql_row['id'];
			   $carton_no=$sql_row['carton_no'];
			   $qty=$sql_row['carton_qty'];
			  
			   echo "<tr><td>".$i++."</td><td>".$style."</td><td>".$schedule."<td>".$carton_no."</td><td>".$carton_id."</td><td>".$qty."</td>";
			   echo "<td><input type='checkbox' name='carton_data[]' value='".$carton_id."'></td>";
			}  

			//  echo $count;
			if($count>0){
				
			   $reconfirm='<input type="submit" name="reconfirm" id="reconfirm" class="btn btn-success retry_transaction" onclick="return check_val();" value="Re-Try" style="margin-top: 18px;">';
			}
			echo '</table>'."$reconfirm".'</form></div></div></div>';  
		}
		else{
			echo '<div class="panel panel-primary">
			<div class="panel-heading" style="text-align:center;"><h4>Data Not Found....!</h3></div>';          
		}
	}
	?>
</div>
</div>

<?php
	if(isset($_POST['reconfirm']))
	{
		$carton_details=$_POST['carton_data'];
		if(sizeof($carton_details)>0)
		{			
			for($j=0;$j<sizeof($carton_details);$j++)
			{
				$carton_id=$carton_details[$j];
				$sql_carton="SELECT * from $bai_pro3.pac_stat where id=".$carton_id."";
				$carton_result=mysqli_query($link, $sql_carton) or exit("Sql Error1112".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$style=$sql_row['style'];
					$schedule=$sql_row['schedule'];
					$carton_no=$sql_row['carton_no'];
					$carton_qty=$sql_row['carton_qty'];
				}
				
				$get_co_vpo="SELECT order_date,co_no,vpo FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule'";
				$get_co_vpo_result = mysqli_query($link,$get_co_vpo);
				while($row_main=mysqli_fetch_array($get_co_vpo_result))
				{
					$co_no=$row_main['co_no'];
					$vpo=$row_main['vpo'];
					$order_date=$row_main['order_date'];
				}
				
				$carton_info = '[
				{
					"serialNumber" : "'.$carton_id.'",
					"m3StyleNumber" : "'.$style.'",
					"remarks" : "",
					"m3ScheduleNumber" : "'.$schedule.'",
					"m3ColorCode" : "",	
					"cartonQuantity" : '.$carton_qty.',
					"customerOrder" : "'.$co_no.'",
					"vendorPurchaseOrder" : "'.$vpo.'",
					"m3ReferenceNumber" : "",
					"confirmedDeliveryDate" : "'.$order_date.'"
				}
				]';				
				$post_carton_response = $obj->postCartonInfo($carton_info, $plant_code, $carton_id);
				$decoded = json_decode($post_carton_response,true);
				var_dump($decoded);
				//die();
				if($decoded['api_status'] == 'fail') {
					// the API is unsuccessfull
					$update_fg_id="update $bai_pro3.pac_stat set fg_status='fail'  where id = ".$carton_id."";
					mysqli_query($link, $update_fg_id) or exit("Error while updating pac_stat inventory");
				} else {
					// the API is successfull
					$inventory_id = $decoded[0]['id'];
					$update_fg_id="update $bai_pro3.pac_stat set fg_status='pass', fg_inventory_id='".$inventory_id."'  where id = ".$carton_id."";
					mysqli_query($link, $update_fg_id) or exit("Error while updating pac_stat inventory");
				}
			}
			
			echo "<script>sweetAlert('Reconfirmation submitted','','success');</script>";
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1500);
			function Redirect() 
			{
				location.href = \"".getFullURLLevel($_GET['r'], "fg_carton_reconfirmation.php", "0", "N")."\";
			}
			</script>";
		}
		else
		{
			echo "<script>sweetAlert('Please select the carton and try','','warning');</script>";
			echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1500);
			function Redirect() 
			{
				location.href = \"".getFullURLLevel($_GET['r'], "fg_carton_reconfirmation.php", "0", "N")."\";
			}
			</script>";
		}
	}
   
?>
<script type="text/javascript">
	$(document).ready(function() 
	{
		$(".retry_transaction").click(function()
		{
			$("#loading-image").show();
		});
	});
</script>
<script language="javascript" type="text/javascript">
	//<![CDATA[
		$('#reset_example1').addClass('btn btn-warning');
	var table6_Props = 	{
							table6_Props: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "example1",table6_Props );
	$(document).ready(function(){
		$('#reset_example1').addClass('btn btn-warning btn-xs');
	});
	
$('#reset_table1').addClass('btn btn-warning');
var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
	// on_change: true,
	// display_all_text: " [ Show all ] ",
	// loader_text: "Filtering data...",  
	// loader: true,
	// loader_text: "Filtering data...",
	btn_reset: true,
	alternate_rows: true,
	btn_reset_text: "Clear",
	col_operation: { 
						id: ["table1Tot1"],
						col: [4],  
						operation: ["sum"],
						decimal_precision: [1],
						write_method: ["innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
	};
	
	 setFilterGrid("table1",fnsFilters);
//]]>
	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
	//]]>
</script>