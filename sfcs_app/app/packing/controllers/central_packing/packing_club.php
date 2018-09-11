<html>
<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
?>
<script>
 $(document).ready(function(){
	var url1 = '<?= getFullURL($_GET['r'],'packing_club.php','N'); ?>';
    console.log(url1);
    $("#style").change(function(){
	   var optionSelected = $("option:selected", this);
	   var valueSelected = this.value;
	   window.location.href =url1+"&style="+valueSelected
    });
	 $("#schedule").change(function(){
		var optionSelected = $("option:selected", this);
        var valueSelected2 = this.value;
	    var style1 = $("#style").val();
	    window.location.href =url1+"&style="+style1+"&schedule="+valueSelected2
    });
	 $("#packmethod").change(function(){
		var optionSelected = $("option:selected", this);
        var valueSelected3 = this.value;
	    var style1 = $("#style").val();
		var schedule1 = $("#schedule").val();
	    window.location.href =url1+"&style="+style1+"&schedule="+schedule1+"&packmethod="+valueSelected3
    });
});
</script>
<head>
<div class = 'panel panel-primary'>
<div class = 'panel-heading'>
<b>Pack Job Clubbing</b></div>
<div class = 'panel-body'>
</head>
<body>
<form action="#" method="post">
<?php
	
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$packmethod=$_GET['packmethod'];
	$seq = substr($packmethod,0,1);
	$packm = substr($packmethod,-1);

	if(isset($_POST['merge']))
	{
		$wout_min=array();
		$id1=$_POST['club'];
		$count1=count($id1);
		if($count1>0)
		{
			$mincart=min($id1);
			for($i = 0; $i<sizeof($id1); $i++)
			{
				if($id1[$i] != $mincart)
				{
					$wout_min[]= $id1[$i];
				}
			}
			$carton=implode(",",$wout_min);
			$getmincartdetails="select carton_no,doc_no_ref from $bai_pro3.pac_stat_log where style='$style' AND schedule='$schedule' AND carton_no='$mincart' AND seq_no='$seq' AND pack_method='$packm'";
			$cartdetrslt=mysqli_query($link, $getmincartdetails) or die("Error while getting min cart details".mysqli_error($GLOBALS["___mysqli_ston"]));
			if($cartrow=mysqli_fetch_array($cartdetrslt))
			{
				$cartno=$cartrow['carton_no'];
				$docnoref=$cartrow['doc_no_ref'];
			}
			$updatedetails="update $bai_pro3.pac_stat_log set doc_no_ref='$docnoref',carton_no='$cartno' where style='$style' AND schedule='$schedule' AND carton_no in ($carton) AND seq_no='$seq' AND pack_method='$packm'";
			$result12=mysqli_query($link, $updatedetails) or die("Error while updating carton details".mysqli_error($GLOBALS["___mysqli_ston"]));
			echo "<script>sweetAlert('Packing Jobs Clubbed','Sucessfully','success');</script>";
		}
	}
		// if(isset($_POST['myval']))
		// {
		// $value = $_POST['myval'];
		// $value1 = explode(",",$value);
		// $list1 = "'". implode("', '", $value1) ."'";
		// echo $list1;
		// die();
		// $checked_count = count($value1);
        	// if($checked_count > 1)
			// {
		// $value2 = min_vals($value1);
		// $list = "'". implode("', '", $value1) ."'";
		// $count_sch_qry3="SELECT input_job_no_random FROM bai_pro3.packing_summary_input WHERE order_del_no ='$schedule' AND input_job_no ='$value2'";
		// $result13=mysqli_query($link, $count_sch_qry3) or die("Error110-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $row2=mysqli_fetch_array($result13);
		// $input_job_random_min = $row2['input_job_no_random'];
		
		
		// $check_update_before="select * from brandix_bts.bundle_creation_data_temp where schedule='".$schedule."' and input_job_no in ($list1) ";
		// $result22=mysqli_query($link, $check_update_before) or die("Error100-".$check_update_before."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		// $rows_count22=mysqli_num_rows($result22);
		// if($rows_count22 > 0){
			  // echo "<script>sweetAlert('Sorry! Some of the jobs were already scanned','','warning');</script>";
		// }
		
		// else{
		// $count_sch_qry1="SELECT input_job_no,input_job_no_random FROM bai_pro3.packing_summary_input WHERE order_del_no ='$schedule' AND input_job_no in ($list1) ";
		// $result10=mysqli_query($link, $count_sch_qry1) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($row2=mysqli_fetch_array($result10))
						// {
							// $input_job=$row2["input_job_no"];
							// $input_job_random=$row2["input_job_no_random"];
							// $count_sch_qry2 = "UPDATE bai_pro3.pac_stat_log_input_job SET input_job_no = '$value2', input_job_no_random = '$input_job_random_min'
							// WHERE input_job_no = '$input_job' and input_job_no_random = '$input_job_random'";
							// $result12=mysqli_query($link, $count_sch_qry2) or die("Error108-".$count_sch_qry2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
							
						// }
						// echo "<script>sweetAlert('Following Sewing Jobs Clubbed Sucessfully','','success');</script>";
			// }
		// }
		// else{
			// echo "<script>sweetAlert('Please Select More than One Sewing Job to Club','','warning');</script>";
			
		// }
	 // }
?>
<?php
$sql="select distinct order_style_no from $bai_pro3.bai_orders_db";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style:</label><select class='form-control' name=\"style\"  id='style'>";

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
	
	echo "<div class='col-sm-3'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\"  id='schedule'>";
$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

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
	 
	 
	 	echo "<div class='col-sm-3'><label>Select Pack Method:</label> 
	  <select class='form-control' name=\"packmethod\"  id='packmethod'>";
$sql="select distinct pack_method from $bai_pro3.pac_stat_log where style=\"$style\" AND schedule=\"$schedule\"";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	$seqno="select distinct seq_no from $bai_pro3.pac_stat_log where style=\"$style\" AND schedule=\"$schedule\" and pack_method='$sql_row[pack_method]'";
	$seqrslt=mysqli_query($link, $seqno) or exit("error while getting seq no".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($seqrslt))
	{
		if(str_replace(" ","",$sql_row['pack_method'])==str_replace(" ","",$packmethod)){
				echo "<option value=\"".$row['seq_no']."-".$sql_row['pack_method']."\" selected>".$row['seq_no']."-".$operation[$sql_row['pack_method']]."</option>";
			}
		else{
			echo "<option value=\"".$row['seq_no']."-".$sql_row['pack_method']."\">".$row['seq_no']."-".$operation[$sql_row['pack_method']]."</option>";
		}
	}
}

echo "	</select>
	 </div>";
?>


</div>
<?php
if($style != "" && $schedule != "" && $packmethod !="")
{	

$seq = substr($packmethod,0,1);
$packm = substr($packmethod,-1);

	// $query_sewing_check = "SELECT * FROM $bai_pro3.packing_summary_input WHERE order_style_no ='$style' AND order_del_no = '$schedule'";
	// $result111=mysqli_query($link, $query_sewing_check) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
	// $rows_count_jobs=mysqli_num_rows($result111);
	// if($rows_count_jobs == 0){
			// echo "<script>sweetAlert('Sewing Jobs Not Generated for this style and schedule','','warning');</script>";
		// } 
		
	// else
	{
?>
		
<div class="panel panel-primary">
				<div class="panel-body">
					<?php
						echo "<div class='row'>";
						echo "<div class='col-md-12'>";
						
						

						// $packmethod="SELECT DISTINCT pack_method as pack_method FROM $bai_pro3.pac_stat_log where style='$style' AND schedule='$schedule' ORDER BY pack_method";
						// $packmetrslt=mysqli_query($link, $packmethod) or die("Error while getting pack methods".mysqli_error($GLOBALS["___mysqli_ston"]));
						// while($packrow=mysqli_fetch_array($packmetrslt))
						// {
							// $pack_method[]=$packrow['pack_method'];
						// }
						// echo "<table id = \"example\" class=\"table table-bordered\">"; 
						// for($i=0;$i<sizeof($pack_method);$i++)
						{
							echo "<table id = \"example\" class=\"table table-bordered\">";
							echo "<thead>";
							echo "<tr>";
							echo "<th>Schedule</th>";
							echo "<th>Pack Method</th>";
							echo "<th>Seq No</th>";
							echo "<th>Carton No</th>";
							echo "<th>Carton Mode</th>";
							echo "<th>Quantity</th>";
							echo "<th>Clubbing Details</th>";  
							echo "</tr></thead>";
							$detailsqry="select carton_no,seq_no,carton_mode,sum(carton_act_qty) as carton_act_qty,pack_method from $bai_pro3.pac_stat_log where style='$style' AND schedule='$schedule' AND pack_method='$packm' and seq_no='$seq' group by carton_no";
							$detailsrslt=mysqli_query($link, $detailsqry) or die("Error while getting details".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($detrow=mysqli_fetch_array($detailsrslt))
							{
								
								$packmet=$detrow['pack_method'];
								echo "<tr>";
									echo "<td>".$schedule."</td>";
									echo "<td>".$operation[$packmet]."</td>";
									echo "<td>".$detrow['seq_no']."</td>";
									echo "<td>".$detrow['carton_no']."</td>";
									if($detrow['carton_mode']=='F')
									{
										$cartmod='Full';
										echo "<td style='background-color: green;'>".$cartmod."</td>";		
									}
									else
									{
										$cartmod='Partial';
										echo "<td style='background-color: yellow;'>".$cartmod."</td>";
									}
									echo "<td>".$detrow['carton_act_qty']."</td>";
									
									$getstatus="select status from $bai_pro3.pac_stat_log where style='$style' AND schedule='$schedule' AND pack_method='$pack_method[$i]' and carton_no='$detrow[carton_no]'";
									$statusrslt=mysqli_query($link, $getstatus) or die("Error while getting status".mysqli_error($GLOBALS["___mysqli_ston"]));
									if($statrow=mysqli_fetch_array($statusrslt))
									{
										$status=$statrow['status'];
									}
									if($status=='DONE')
									{
										echo "<td>Already Scanned</td>";
									}
									else
									{
										echo "<td><input type='checkbox'  name='club[]' value=".$detrow['carton_no']." ></td>";
									}
									
								echo "</tr>";
							}
							
						}
						
						echo "</table></div></div></div></div><br>";
					?>
				</div>
				
				<div id='alert-box' class='deliveryChargeDetail'></div>

			
            <button type="submit" name="merge" class="btn btn-primary btn-lg">Merge Jobs</button>
			</form>
				<?php
	}
	
}
else
{
	
}
//echo "<div id='alert-box' class='deliveryChargeDetail'></div>";
	 ?>
<?php

?>	 
	<script>
	
	

	 $(document).ready(function() {
    var tableUsers =  $('#example').val();
	//alert('Hello');
	 
	var rows = tableUsers.rows({ 'search': 'applied' }).nodes();
	$('input[type="checkbox"]', rows).each(function(i,e){
				
                $(e).change(function(){
                    var checkBoxC = [];
                    var club = new Array();
					console.log(club);
					var idsp = '';
                    $('input[type="checkbox"]:checked', rows).each(function(o,a){
                        checkBoxC[checkBoxC.length]=$(a).val();
						  $.each(checkBoxC, function(h, el){
                            if($.inArray(el, club) === -1) club.push(el);
							
							
                        });
						
						console.log(club.length);
						if(club.length>0){
						idsp = '<p>List Of Sewing Jobs to be Clubbed :</p><ul class = list-group >';
						for(var i=0;i<club.length;i++){
							idsp+="<li class='label label-success' style='font-size:15px;'>J"+club[i]+"</li>&nbsp;";
						}
						idsp+='</ul>';
						}
						//console.log(idsp);

						
                    });
					//$(".deliveryChargeDetail ul").addClass('list-group');
					$('#myval').val(club);
					$('#alert-box').html(idsp);
                });
            });
	
     });

	 
  /* $(document).ready(function() {
    var table = $('#example').DataTable();
 
    $('button').click( function() {
        var data = table.$('input').serialize();
		console.log(data);
        
        return false;
    } );
});  */
	
</script>
<style>
table th
{
border: 1px solid grey;
text-align: center;
   background-color: #003366;
color: WHITE;
white-space:nowrap; 
padding-left: 5px;
padding-right: 5px;
}
table{
white-space:nowrap; 
border-collapse:collapse;
font-size:12px;
background-color: white;
}
table tr
{
border: 1px solid grey;
text-align: right;
white-space:nowrap; 
}

table td
{
border: 1px solid grey;
text-align: center;
white-space:nowrap;
color:black;
}
div#example_filter {
    display: none;
}
.lastActive {
    background-color: red;
}

</style>
</body>

</html>
<?php 
// function min_vals($ary){
	// $temp = '';
	// foreach($ary as $v){
		// if($temp!=''){
			// if($temp>$v){
				// $temp = $v;
			// }
		// }else{
			// $temp = $v;
		// }
	// }
	// return $temp;
// }
?>

