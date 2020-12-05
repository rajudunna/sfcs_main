<html>
<?php 
include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include(getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
?>
<script>
 $(document).ready(function(){
	var url1 = '<?= getFullURL($_GET['r'],'sewing_club.php','N'); ?>';
    console.log(url1);
    $("#style").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected = this.value;
	  window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(valueSelected)))
    });
	$("#schedule").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected2 = this.value;
	   var style1 = $("#style").val();
	   window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(style1)))+"&schedule="+valueSelected2
	});
	$("#submit_val").click(function(){
	var style_val = $("#style").val();
	var sch_val = $("#schedule").val();
	if(style_val == null || sch_val == null)
	{
		sweetAlert('Please Select  Style,Schedule','','warning');
		return false;
	}
	else
	{
		window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(style_val)))+"&schedule="+sch_val+"&submit_val=submit_val";
	}
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
$decode_style = $_GET['style'];
$style=style_decode($_GET['style']);
$schedule=$_GET['schedule']; 
if(isset($_POST['myval']))
{
	$value = $_POST['myval'];
	$value1 = explode(",",$value);
	$list1 = "'". implode("', '", $value1) ."'";
	$checked_count = count($value1);
	if($checked_count > 1)
	{
		$value2 = min($value1);
		$list = "'". implode("', '", $value1) ."'";
		$count_sch_qry3="SELECT input_job_no_random FROM $bai_pro3.packing_summary_input WHERE order_del_no ='$schedule' AND input_job_no ='$value2'";
		$result13=mysqli_query($link, $count_sch_qry3) or die("Error110-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row2=mysqli_fetch_array($result13);
		$input_job_random_min = $row2['input_job_no_random'];
		$sql32="SELECT * FROM $bai_pro3.packing_summary_input WHERE order_del_no ='$schedule' AND input_job_no in ($list1) and bundle_print_status = 1"; 
		$result32=mysqli_query($link, $sql32) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($result32)>0)
		{
			echo "<script>
							sweetAlert('Error','Job already printed.','warning');
							setTimeout('Redirect()',500); 
							function Redirect() {  
								location.href = \"".getFullURLLevel($_GET['r'], "sewing_club.php", "0", "N")."&style=$decode_style&schedule=$schedule&submit_val=submit_val1\";
							}
				</script>";
				exit();
		}
		$count_sch_qry1="SELECT input_job_no,input_job_no_random FROM $bai_pro3.packing_summary_input WHERE order_del_no ='$schedule' AND input_job_no in ($list1) group by input_job_no";
		$result10=mysqli_query($link, $count_sch_qry1) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row2=mysqli_fetch_array($result10))
		{
			$input_job_random=$row2["input_job_no_random"];
			$input_job_no_r=$row2["input_job_no"];
			$count_sch_qry2 = "UPDATE bai_pro3.pac_stat_log_input_job SET input_job_no = '$value2', input_job_no_random = '$input_job_random_min' WHERE input_job_no='$input_job_no_r' and input_job_no_random = '$input_job_random'";
			$result12=mysqli_query($link, $count_sch_qry2) or die("Error108-".$count_sch_qry2."-".mysqli_error($GLOBALS["___mysqli_ston"]));				
		}
		update_barcode_sequences($input_job_random_min);
		//echo "<script>sweetAlert('Following Sewing Jobs Clubbed Sucessfully','','success');</script>";
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
			function Redirect() {
			sweetAlert('Following Sewing Jobs Clubbed Sucessfully','','success');
			location.href = \"".getFullURLLevel($_GET['r'], "sewing_club.php", "0", "N")."&style=$decode_style&schedule=$schedule&submit_val=submit_val1\";
			}
			</script>";
	}	
	else
	{
		//echo "<script>sweetAlert('Please Select More than One Sewing Job to Club','','warning');</script>";	
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0);
		function Redirect() {
		sweetAlert('Please Select More than One Sewing Job to Club','','warning');
		location.href = \"".getFullURLLevel($_GET['r'], "sewing_club.php", "0", "N")."&style=$decode_style&schedule=$schedule&submit_val=submit_val2\";
		}
		</script>";	
	}
}
?>
<?php
$sql="select order_style_no from $bai_pro3.packing_summary_input group by order_style_no";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
$sql="select order_del_no from $bai_pro3.packing_summary_input where order_style_no='$style' group by order_del_no";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<option value='' disabled selected>Please Select</option>";
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
echo "	</select>
	 </div>";
echo "&nbsp;&nbsp;";
echo "<div class='col-md-3 col-sm-3'><input type='button' name='submit_val' id='submit_val' class='btn btn-success' value='Show' style='margin-top: 18px;'></div>";
?>
</form>

</div>
<br/>
<?php
if($style != null && $schedule != null && isset($_GET['submit_val']))
{
	?>
	<div class="panel panel-primary">
		<div class="panel-body">
			<?php
			echo "<div class='row'>";
			echo "<div class='col-md-12'>";
			echo "<table id = \"example\">"; 
			echo "<thead>";
			echo "<tr>";
			echo "<th>Schedule</th>";
			echo "<th>Cutting Job</th>";
			echo "<th>Input Job#</th>";
			echo "<th>Quantity</th>";
			echo "<th>Clubbing Details</th>";  
			echo "</tr></thead>";
			$sql = "SELECT order_del_no,input_job_no,input_job_no_random,SUM(carton_act_qty) AS carton_act_qty,order_col_des, mrn_status,bundle_print_status FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' GROUP BY input_job_no ORDER BY input_job_no*1";
			$result=mysqli_query($link, $sql) or die("Error8-".$sql."-".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($result))
			{
				$del_no_new=$sql_row["order_del_no"];
				$job_new=$sql_row["input_job_no"];
				$input_job_no_random=$sql_row["input_job_no_random"];
				$get_cut_no="SELECT GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno from $bai_pro3.packing_summary_input WHERE order_del_no = '$del_no_new' and input_job_no='$job_new' ";
				$result_cut_no=mysqli_query($link, $get_cut_no) or die("Error92-".$get_cut_no."-".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_cut_no=mysqli_fetch_array($result_cut_no))
				{
					$total_cuts=explode(",",$sql_row_cut_no['acutno']);
					$cut_jobs_new='';
					for($ii=0;$ii<sizeof($total_cuts);$ii++)
					{
						$arr = explode("$", $total_cuts[$ii], 2);;
						$sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$arr[0]."'";
						$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row4=mysqli_fetch_array($sql_result4))
						{
							$color_code=$sql_row4["color_code"];
						}
						$cut_jobs_new .= chr($color_code).leading_zeros($arr[1], 3)."<br>";
						unset($arr);
					}
				}
				$count_sch_qry="select * from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref='".$input_job_no_random."'";
				$result9=mysqli_query($link, $count_sch_qry) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows_count1=mysqli_num_rows($result9);
				//Validation For sewing clubbing cant if jobs loaded
				$count_plan_input="select * from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='".$input_job_no_random."'";
				$result_plan_input=mysqli_query($link, $count_plan_input) or die("Error101-".$count_plan_input."-".mysqli_error($GLOBALS["___mysqli_ston"]));
				$plan_dash_count=mysqli_num_rows($result_plan_input);
				echo "<tr height=20 style='height:15.0pt'>";
				echo "<td height=20 style='height:15.0pt'>".$sql_row["order_del_no"]."</td>";
				echo "<td height=20 style='height:15.0pt'>".$cut_jobs_new."</td>";
				$url=getFullURL($_GET['r'],'small_popup.php','R');
				$get_color = $sql_row["order_col_des"];
				$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row["order_del_no"],$get_color,$sql_row["input_job_no"],$link);
				echo "<td height=20 style='height:15.0pt'> <a class='btn btn-success btn-sm' href='$url?schedule=$del_no_new&jobno=$job_new' onclick=\"return popitup2('$url?schedule=$del_no_new&jobno=$job_new')\" target='_blank'>".$display_prefix1."</a></td>";
				echo "<td height=20 style='height:15.0pt'>".$sql_row["carton_act_qty"]."</td>"; 
				if(($rows_count1 > 0) || ($plan_dash_count > 0))
				{								    
					echo "<td>Already Jobs Loaded</td>";			
				}
				else if($sql_row['bundle_print_status']==1)
				{
					echo "<td>Job already Printed</td>";
				}
				else
				{									
					if($sql_row['mrn_status']==1)
					{
						echo "<td>MRN Confirmed</td>";
					}
					else
					{
						echo "<td><input type='checkbox' id='club' name='club[]' value=".$sql_row["input_job_no"]." ></td>";	
					}
				}
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
?>
<script>
	 $(document).ready(function() {
    var tableUsers =  $('#example').DataTable();
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
						if(club.length>0)
						{
							idsp = '<p>List Of Sewing Jobs to be Clubbed :</p><ul class = list-group >';
							for(var i=0;i<club.length;i++){
								idsp+="<li class='label label-success' style='font-size:15px;'>J"+club[i]+"</li>&nbsp;";
							}
							idsp+='</ul>';
						}
					});
					//$(".deliveryChargeDetail ul").addClass('list-group');
					$('#myval').val(club);
					$('#alert-box').html(idsp);
                });
            });
	
     });
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

function update_barcode_sequences($input_job_random)
{
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $query = "select tid from $bai_pro3.pac_stat_log_input_job where input_job_no_random = '$input_job_random' order by doc_no,old_size";
    $result = mysqli_query($link,$query);
	$counter=1;
	while($row = mysqli_fetch_array($result))
	{
        $tid = $row['tid'];
        $update_query = "Update bai_pro3.pac_stat_log_input_job set barcode_sequence = $counter where tid=$tid";
        mysqli_query($link,$update_query) or exit('Unable to update');
        $counter++;        
	}
	return;
}  
?>

