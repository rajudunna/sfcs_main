<html>
<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
?>
<!--<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>-->
<script>
 $(document).ready(function(){
	var url1 = '<?= getFullURL($_GET['r'],'sewing_club.php','N'); ?>';
    console.log(url1);
    $("#style").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected = this.value;
	  window.location.href =url1+"&style="+valueSelected
    });
	 $("#schedule").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected2 = this.value;
	   var style1 = $("#style").val();
	   window.location.href =url1+"&style="+style1+"&schedule="+valueSelected2
	 //window.location.href ="http://localhost/sfcs_app/app/production/controllers/sewing_job/sewing_club.php?schedule="+valueSelected2
	 
	 //window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
    });
});
</script>
<head>
<div class = 'panel panel-primary'>
<div class = 'panel-heading'>
<b>Sewing Job Clubbing</b></div>
<div class = 'panel-body'>
</head>
<body>
<form>
<?php
	
	//include("menu_content.php");
	
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
	// echo $schedule;
	 //echo $variable = "<script>document.write(valueSelected)</script>";
	 if(isset($_POST['myval'])){
		$value = $_POST['myval'];
		//echo $value;  
		//die();
		$value1 = explode(",",$value);
		//var_dump($value1);
		$list1 = "'". implode("', '", $value1) ."'";
		//print_r($value1);
		//echo count($value1);
		$checked_count = count($value1);
        //echo $checked_count;
			//die();
			if($checked_count > 1)
			{
		//print_r($value1);
		//echo min($value1);
		//var_dump($value1[0]);
		//echo $schedule;
		$value2 = min_vals($value1);
		//echo $value2;
		//die();
		$list = "'". implode("', '", $value1) ."'";
		//echo $list;
		$count_sch_qry3="SELECT input_job_no_random FROM bai_pro3.packing_summary_input WHERE order_del_no ='$schedule' AND input_job_no ='$value2'";
		$result13=mysqli_query($link, $count_sch_qry3) or die("Error110-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row2=mysqli_fetch_array($result13);
		$input_job_random_min = $row2['input_job_no_random'];
		// echo $input_job_random_min;
		
		
		$check_update_before="select * from brandix_bts.bundle_creation_data_temp where schedule='".$schedule."' and input_job_no in ($list1) ";
		// echo $check_update_before;
		
		$result22=mysqli_query($link, $check_update_before) or die("Error100-".$check_update_before."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows_count22=mysqli_num_rows($result22);
		// echo $rows_count22;die();
		if($rows_count22 > 0){
			  //echo 'Sorry! Some of the jobs were already scanned';
			  echo "<script>sweetAlert('Sorry! Some of the jobs were already scanned','','warning');</script>";
		}
		
		else{
		$count_sch_qry1="SELECT input_job_no,input_job_no_random FROM bai_pro3.packing_summary_input WHERE order_del_no ='$schedule' AND input_job_no in ($list1) ";
		$result10=mysqli_query($link, $count_sch_qry1) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		//$row2=mysqli_fetch_array($result10);
		//$input_job_random = $row2['input_job_no_random'];
		while($row2=mysqli_fetch_array($result10))
						{
							// swal("Already Scanned");
							$input_job=$row2["input_job_no"];
							$input_job_random=$row2["input_job_no_random"];
							$count_sch_qry2 = "UPDATE bai_pro3.pac_stat_log_input_job SET input_job_no = '$value2', input_job_no_random = '$input_job_random_min'
							WHERE input_job_no = '$input_job' and input_job_no_random = '$input_job_random'";
							//echo $count_sch_qry2 ;
							$result12=mysqli_query($link, $count_sch_qry2) or die("Error108-".$count_sch_qry2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							 //die();
							//echo 'Input Job NO '.$input_job.'clubbed to '.$value2.' and Random Number '.$input_job_random_min.' </br>';
							//echo "Updated data successfully\n";
							
						}
						echo "<script>sweetAlert('Following Sewing Jobs Clubbed Sucessfully','','success');</script>";
			}
		}
		else{
			//echo "Please Select More than One Sewing Job to Club";
			//swal('Please Select More than One Sewing Job to Club','','warning');
			echo "<script>sweetAlert('Please Select More than One Sewing Job to Club','','warning');</script>";
			
		}
	 }
?>
<?php
$sql="select distinct order_style_no from bai_orders_db";	
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
?>
</form>

</div>
<?php
if($style != "" && $schedule != "")
{	
$query_sewing_check = "SELECT * FROM $bai_pro3.packing_summary_input WHERE order_style_no ='$style' AND order_del_no = '$schedule'";
//
//echo $query_sewing_check;
//die();
$result111=mysqli_query($link, $query_sewing_check) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
$rows_count_jobs=mysqli_num_rows($result111);
if($rows_count_jobs == 0){
		echo "<script>sweetAlert('Sewing Jobs Not Generated for this style and schedule','','warning');</script>";
	} 
	
	else{?>
		
<div class="panel panel-primary">
				<!--<div class="panel-heading"><b>Ratio Sheet (Sewing Job wise)</b></div>-->
				<div class="panel-body">
					<!--<div style="float:right"><img src="../../common/images/Book1_29570_image003_v2.png" width="250px"/></div>-->
					
					<?php
						

						echo "<div class='row'>";
						echo "<div class='col-md-12'>";
						
						echo "<table id = \"example\">"; 
						echo "<thead>";
						echo "<tr>";
						//echo "<th>Style</th>"; 
						/* echo "<th>PO#</th>"; */
						echo "<th>Schedule</th>";
						echo "<th>Input Job#</th>";
						echo "<th>Quantity</th>";
						
						echo "<th>Clubbing Details</th>";  
						echo "</tr></thead>";

						//$sql="select distinct input_job_no as job from $bai_pro3.packing_summary_input where order_del_no in ($schedule) order by input_job_no*1 ";
						//echo $sql."<br>";
						$sql = "SELECT type_of_sewing,input_job_no_random,sch_mix,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT m3_size_code order by m3_size_code) AS size_code,group_concat(distinct order_col_des order by order_col_des) as order_col_des,doc_no,group_concat(distinct order_del_no) as order_del_no,GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno,SUM(carton_act_qty) AS carton_act_qty FROM (SELECT DISTINCT(SUBSTRING_INDEX(order_joins,'J',-1)) AS sch_mix,order_del_no,input_job_no,input_job_no_random,tid,doc_no,doc_no_ref,m3_size_code,order_col_des,acutno,SUM(carton_act_qty) AS carton_act_qty,type_of_sewing FROM bai_pro3.packing_summary_input WHERE order_del_no in ($schedule) GROUP BY order_col_des,order_del_no,input_job_no_random,
						acutno,m3_size_code order by field(order_del_no,$schedule),field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) AS t GROUP BY input_job_no_random ORDER BY input_job_no*1,field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')";
						
						$result=mysqli_query($link, $sql) or die("Error8-".$sql."-".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($result))
						{

							    $del_no_new=$sql_row["order_del_no"];
								// echo $del_no_new;
								$job_new=$sql_row["input_job_no"];
								// echo $job_new;
								$count_sch_qry="select * from brandix_bts.bundle_creation_data_temp where schedule='".$del_no_new."' and input_job_no='".$job_new."'";
								// echo $count_sch_qry;
								
								$result9=mysqli_query($link, $count_sch_qry) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								$rows_count1=mysqli_num_rows($result9);
								
								// echo $rows_count1;
								// die();
								echo "<tr height=20 style='height:15.0pt'>";
								//echo "<td height=20 style='height:15.0pt'>".$style."</td>";
								echo "<td height=20 style='height:15.0pt'>".$sql_row["order_del_no"]."</td>";
								$url=getFullURL($_GET['r'],'small_popup.php','R');
								// echo "<td height=20 style='height:15.0pt'>J".$sql_row["input_job_no"]." <a class='tooltippage' id='clickme' href='#' rel='$url&schedule='".$sql_row["order_del_no"]."'&jobno='".$sql_row["input_job_no"]." title='Full Details of Input Job'>Click Here</a></td>";
								echo "<td height=20 style='height:15.0pt'> <a class='btn btn-success btn-sm' href='$url?schedule=$del_no_new&jobno=$job_new' onclick=\"return popitup2('$url?schedule=$del_no_new&jobno=$job_new')\" target='_blank'>J".$sql_row["input_job_no"]."</a></td>";
								 echo "<td height=20 style='height:15.0pt'>".$sql_row["carton_act_qty"]."</td>"; 
								
                               

								// echo "<td>Clubbed</td>";		
								if($rows_count1 > 0){
									    
                                 		echo "<td>Already Scanned</td>";			
								}
								// else {
									// echo "<td>hai</td>";
								// }
								else{
									
									echo "<td><input type='checkbox' id='club' name='club[]' value=".$sql_row["input_job_no"]." ></td>";
								}
										
								
								/* echo "<td align=\"center\">".$total_qty1."</td>"; */
								$total_qty1=0;
								echo "</tr>";
							
						}
						

						echo "</table></div></div></div></div><br>";
					?>
				</div>
				
				<div id='alert-box' class='deliveryChargeDetail'></div>

				<form method='post'>
				<input type='hidden' id='myval' name='myval'>
            <button type="submit" class="btn btn-primary btn-lg">Merge Jobs</button>
			</form>
				<?php
	}
	
}
else
{
	
}
//echo "<div id='alert-box' class='deliveryChargeDetail'></div>";
	 ?>

	 
	<script>
	
	

	 $(document).ready(function() {
    var tableUsers =  $('#example').DataTable();
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
function min_vals($ary){
	$temp = '';
	foreach($ary as $v){
		if($temp!=''){
			if($temp>$v){
				$temp = $v;
			}
		}else{
			$temp = $v;
		}
	}
	return $temp;
}
?>

