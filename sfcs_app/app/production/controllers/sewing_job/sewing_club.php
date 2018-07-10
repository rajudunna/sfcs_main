<html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css" />
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
 <script>
 $(document).ready(function(){
    $("#style").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected = this.value;
	 window.location.href ="http://localhost/sfcs_app/app/production/controllers/sewing_job/sewing_club.php?style="+valueSelected
    });
	 $("#schedule").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected2 = this.value;
	 window.location.href ="http://localhost/sfcs_app/app/production/controllers/sewing_job/sewing_club.php?schedule="+valueSelected2
    });
});
</script>
</html>
<?php   
   //include("../../../../common/config/config.php");
   include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
   include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
   //include("../../../../common/config/functions.php");
  include("../../../../common/config/user_acl_v1.php");
  include("../../../../common/config/headers.php");
   include('/template/header.php');
 ?>

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
		$value1 = explode(",",$value);
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
		$value2 = min($value1);
		$list = "'". implode("', '", $value1) ."'";
		//echo $list;
		$count_sch_qry3="SELECT input_job_no_random FROM bai_pro3.packing_summary_input WHERE order_del_no ='$schedule' AND input_job_no =$value2";
		$result13=mysqli_query($link, $count_sch_qry3) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		$row2=mysqli_fetch_array($result13);
		$input_job_random_min = $row2['input_job_no_random'];
		// echo $input_job_random_min;
		
		
		$check_update_before="select * from brandix_bts.bundle_creation_data_temp where schedule='".$schedule."' and input_job_no in ($list1) ";
		// echo $check_update_before;
		
		$result22=mysqli_query($link, $check_update_before) or die("Error100-".$check_update_before."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows_count22=mysqli_num_rows($result22);
		// echo $rows_count22;die();
		if($rows_count22 > 0){
			  echo 'Sorry! Some of the jobs were already scanned';
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
							WHERE input_job_no = $input_job and input_job_no_random = '$input_job_random'";
							// echo $count_sch_qry2 ;
							$result12=mysqli_query($link, $count_sch_qry2) or die("Error100-".$count_sch_qry2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							// die();
							echo 'Input Job NO '.$input_job.'clubbed to '.$value2.' and Random Number '.$input_job_random_min.' </br>';
							//echo "Updated data successfully\n";
							
						}
		
			}
		}
		else{
			echo "Please Select More than One Sewing Job to Club";
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
</form

</div>
<?php
if($schedule==''){
		echo "<script>console.log('There are no schedules');
			</script>";
	} 
	
	else{?>
		
<div class="panel panel-primary">
				<!--<div class="panel-heading"><b>Ratio Sheet (Sewing Job wise)</b></div>-->
				<div class="panel-body">
					<!--<div style="float:right"><img src="../../common/images/Book1_29570_image003_v2.png" width="250px"/></div>-->
					<?php
						$sql="select distinct order_del_no as sch from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
						// echo $sql."<br>";
						$result=mysqli_query($link, $sql) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($result))
						{
							$schs_array1[]=$row["sch"];
						}

						// $operation=array("","Single Colour & Single Size","Multi Colour & Single Size","Multi Colour & Multi Size","Single Colour & Multi Size(Non Ratio Pack)","Single Colour & Multi Size(Ratio Pack)");

						$sql2="select distinct packing_mode as mode from $bai_pro3.packing_summary_input where order_del_no in (".$schedule.") ";
						$result2=mysqli_query($link, $sql2) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row2=mysqli_fetch_array($result2))
						{
							$packing_mode=$row2["mode"];
						}

						if (sizeof($schs_array1)>1)
						{
							$sql="select distinct order_joins from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
							//echo $sql;
							$result=mysqli_query($link, $sql) or die("Error3 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($row=mysqli_fetch_array($result))
							{
								$joinSch=substr($row["order_joins"], 1);
								//echo $joinSch;
							}
						}
						else
						{
							$joinSch=$schs_array1[0];
							//echo $joinSch;
						}

						//$sql2="select * from $bai_pro3.bai_orders_db_confirm where order_del_no = \"$joinSch\" ";
						$sql2="select order_style_no,GROUP_CONCAT(DISTINCT order_col_des) AS order_col_des from $bai_pro3.bai_orders_db_confirm where order_joins not in ('1','2') and order_del_no = \"$joinSch\" ";

						$result2=mysqli_query($link, $sql2) or die("Error22 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($result2))
						{
							$disStyle=$row["order_style_no"];
							$disColor=$row["order_col_des"];

						}
					?>
					<?php
						// Display Sample QTY - 05-11-2014 - ChathurangaD
						$sqlr="SELECT remarks from $bai_pro3.bai_orders_db_remarks where order_tid in (SELECT order_tid from $bai_pro3.bai_orders_db where order_del_no in (".$schedule.")) ";
						// echo $sqlr;
						$resultr=mysqli_query($link, $sqlr) or die("Errorr4 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($resultr))
						{
							$sampleqty = $row["remarks"];  
							// $result =  preg_replace('/[^0-9\-]/','', $sampleqty);   
							// $sampleqty = $result;

							if($sampleqty == '') {
								$sampleqty = "N/A";
							} 
							/* echo "<table class=\"gridtable\" align=\"center\" style=\"margin-bottom:2px;font-size:14px;\">";
							echo "<tr>";
							echo "<th>Sample Job</th><td>$sampleqty</td></tr></table>"; */
						}
						echo "<br>";
						$sql="select distinct order_del_no as sch,order_div from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
						$result=mysqli_query($link, $sql) or die("Error45 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($row=mysqli_fetch_array($result))
						{
							$schs_array[]=$row["sch"];
							$division=$row["order_div"];
						}


						$size_array=array();

						for($p=0;$p<sizeof($schs_array);$p++)
						{
							for($q=0;$q<sizeof($sizes_array);$q++)
							{
								$sql6="select sum(order_s_".$sizes_array[$q].") as order_qty,title_size_".$sizes_array[$q]." as size from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schs_array[$p].") ";
								$result6=mysqli_query($link, $sql6) or die("Error35 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($row6=mysqli_fetch_array($result6))
								{
									//echo $sizes_array[$q]."-".$row6["order_qty"]."<br>";
									if($row6["order_qty"] > 0)
									{
										if(!in_array($sizes_array[$q],$size_array))
										{
											$size_array[]=$sizes_array[$q];
											$orginal_size_array[]=$row6["size"];
										}
									}
								}
							}
						}

						echo "<div class='row'>";
						echo "<div class='col-md-12'>";
						
						echo "<table id = \"example\">"; 
						echo "<thead>";
						echo "<tr>";
						echo "<th>Style</th>"; 
						/* echo "<th>PO#</th>"; */
						echo "<th>Schedule</th>";
						echo "<th>Input Job#</th>";
						echo "<th>Clubbing Details</th>";  
						echo "</tr></thead>";

						$sql="select distinct input_job_no as job from $bai_pro3.packing_summary_input where order_del_no in ($schedule) order by input_job_no*1 ";
						//echo $sql."<br>";
						$result=mysqli_query($link, $sql) or die("Error8-".$sql."-".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row=mysqli_fetch_array($result))
						{

							$sql1="select acutno,group_concat(distinct order_del_no) as del_no,group_concat(distinct doc_no) as doc_nos from $bai_pro3.packing_summary_input where order_del_no in ($schedule) and input_job_no='".$sql_row["job"]."' group by order_del_no,acutno*1";
							//echo $sql1."<br>";
							$result1=mysqli_query($link, $sql1) or die("Error88-".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($sql_row1=mysqli_fetch_array($result1))
							{
								$doc_nos_des=$sql_row1["doc_nos"];
								$acutno_ref=$sql_row1["acutno"];

								//$sql2d="select group_concat(distinct destination) as dest from plandoc_stat_log where doc_no in (".$doc_nos_des.") and acutno='".$acutno_ref."'";
								$sql2d="select group_concat(distinct destination) as dest from $bai_pro3.pac_stat_log_input_job where doc_no in (".$doc_nos_des.")";
								$result2d=mysqli_query($link, $sql2d) or die("Error888-".$sql2d."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row2d=mysqli_fetch_array($result2d))
								{
									$destination=$sql_row2d["dest"];
								}

								$sql2="select group_concat(distinct trim(destination)) as dest,order_style_no as style,GROUP_CONCAT(DISTINCT order_col_des separator '<br/>') as color,order_po_no as cpo,order_date,vpo from $bai_pro3.bai_orders_db where order_joins not in ('1','2') and order_del_no in (".$sql_row1["del_no"].")";
								// echo $sql2;
								$result2=mysqli_query($link, $sql2) or die("Error-".$sql2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row2=mysqli_fetch_array($result2))
								{
									//$destination=$sql_row2["dest"];
									$color=$sql_row2["color"];
									$style=$sql_row2["style"];
									$po=$sql_row2["cpo"];
									$del_date=$sql_row2["order_date"];
									$vpo=$sql_row2["vpo"];
								}

								// $vpo_po_query="select shipment_plan.Customer_Order_No, order_details.VPO_NO FROM $m3_inputs.order_details,$m3_inputs.shipment_plan WHERE order_details.Schedule=shipment_plan.Schedule_No AND order_details.Schedule=$schedule";
								// // echo $vpo_po_query;
								// $vpo_po_result=mysqli_query($link, $vpo_po_query) or die("Error while getting VPO and PO numbers");
								// while($row1w=mysqli_fetch_array($vpo_po_result))
								// {
								// 	$po=$row1w["Customer_Order_No"];
								// 	$vpo=$row1w["VPO_NO"];
								// }

								$sql_cut="select group_concat(distinct acutno) as cut, sum(carton_act_qty) as totqty from $bai_pro3.packing_summary_input where order_del_no in ($schedule) and input_job_no='".$sql_row["job"]."' and acutno='".$acutno_ref."'";
								//echo $sql_cut;
								$result_cut=mysqli_query($link, $sql_cut) or die("Error9-".$sql2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_cut=mysqli_fetch_array($result_cut))
								{
									$cut_job_no=$sql_row_cut["cut"];
									$totcount1=$sql_row_cut["totqty"];

								}

								//$totcount="- (".$totcount1.")<br>";
								//Display color
								$display_colors=str_replace(',',$totcount,$color);
								//$totcount=0;

								$del_no_new=$sql_row1["del_no"];
								// echo $del_no_new;
								$job_new=$sql_row["job"];
								// echo $job_new;
								$count_sch_qry="select * from brandix_bts.bundle_creation_data_temp where schedule='".$del_no_new."' and input_job_no='".$job_new."'";
								// echo $count_sch_qry;
								
								$result9=mysqli_query($link, $count_sch_qry) or die("Error100-".$count_sch_qry."-".mysqli_error($GLOBALS["___mysqli_ston"]));
								$rows_count1=mysqli_num_rows($result9);
								
								// echo $rows_count1;
								// die();
								echo "<tr height=20 style='height:15.0pt'>";
								echo "<td height=20 style='height:15.0pt'>".$style."</td>";
								/* echo "<td height=20 style='height:15.0pt'>$po</td>"; */
								echo "<td height=20 style='height:15.0pt'>".$sql_row1["del_no"]."</td>";
								echo "<td height=20 style='height:15.0pt'>J".$sql_row["job"]."</td>";

								// echo "<td>Clubbed</td>";		
								if($rows_count1 > 0){
									    
                                 		echo "<td>Already Scanned</td>";			
								}
								// else {
									// echo "<td>hai</td>";
								// }
								else{
									
									echo "<td><input type='checkbox' id='club' name='club[]' value=".$sql_row["job"]." ></td>";
								}
								// echo "<tr height=20 style='height:15.0pt'>";
							// /* 	echo "<td height=20 style='height:15.0pt'>".$style."</td>"; */
								// /* echo "<td height=20 style='height:15.0pt'>$po</td>"; */
								// echo "<td height=20 style='height:15.0pt'>".$sql_row1["del_no"]."</td>";
								// echo "<td height=20 style='height:15.0pt'>J".$sql_row["job"]."</td>";
                               // echo "<td><input type='checkbox' id='club' name='club[]' value=".$sql_row["job"]." ></td>";
								
								
								
								
								
								

								// echo "<tr height=20 style='height:15.0pt'>";
							// /* 	echo "<td height=20 style='height:15.0pt'>".$style."</td>"; */
								// /* echo "<td height=20 style='height:15.0pt'>$po</td>"; */
								// echo "<td height=20 style='height:15.0pt'>".$sql_row1["del_no"]."</td>";
								// echo "<td height=20 style='height:15.0pt'>J".$sql_row["job"]."</td>";
                               // echo "<td><input type='checkbox' id='club' name='club[]' value=".$sql_row["job"]." ></td>";						
								for($i=0;$i<sizeof($size_array);$i++)  
								{
									$sql7="SELECT * FROM $bai_pro3.packing_summary_input where order_del_no in (".$sql_row1["del_no"].")  and size_code='".$orginal_size_array[$i]."' and input_job_no='".$sql_row["job"]."' and acutno='".$acutno_ref."'";
									//echo $sql7."<br>";
									$result7=mysqli_query($link, $sql7) or die("Error7-".$sql7."-".mysqli_error($GLOBALS["___mysqli_ston"]));
									$rows_count=mysqli_num_rows($result7);
									if($rows_count > 0)
									{
										$sql5="SELECT round(sum(carton_act_qty),0) as qty FROM $bai_pro3.packing_summary_input where size_code='".$orginal_size_array[$i]."' and order_del_no in (".$sql_row1["del_no"].") and input_job_no='".$sql_row["job"]."' and acutno='".$acutno_ref."'";
										//echo $sql5."<br>";
										$result5=mysqli_query($link, $sql5) or die("Error969-".$sql5."-".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($sql_row5=mysqli_fetch_array($result5))
										{
											//echo "<td class=xl787179 align=\"center\">".$sql_row5["qty"]."</td>";
											$total_qty1=$total_qty1+$sql_row5["qty"];
										}
									}
									else
									{
										/* echo "<td class=xl787179 align=\"center\">0</td>"; */
										$total_qty1=$total_qty1+0;
									}
								}
								/* echo "<td align=\"center\">".$total_qty1."</td>"; */
								$total_qty1=0;
								echo "</tr>";
							}
						}
						// $o_total=0;
						// echo "<tr>";
						// echo "<th colspan=1  style=\"border-top:2px solid #000;border-bottom:1px dotted #000;font-size:14px;\"> Total</th>";
						// for($k=0;$k<sizeof($size_array);$k++)
						// {
							// $sql1="select sum(order_s_".$size_array[$k].") as qty from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$joinSch\"";
							// echo $sql1;
							// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error996".mysqli_error($GLOBALS["___mysqli_ston"]));
							// while($sql_row1=mysqli_fetch_array($sql_result1))
							// {
								// $o_s=$sql_row1['qty'];
								// if ($o_s!=0) {	echo "<th align=\"center\" style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">".$o_s."</th>"; }
								// $o_total=$o_s+$o_total;
								// echo $o_total;
							// }
						// }
						// echo "<th  style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">$o_total</th>";
						// echo "</tr>";

						echo "</table></div></div></div></div><br>";
					?>
				</div>
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
	//alert('Hello');
	 
	var rows = tableUsers.rows({ 'search': 'applied' }).nodes();
	$('input[type="checkbox"]', rows).each(function(i,e){
                $(e).change(function(){
                    var checkBoxC = [];
                    var club = new Array();
					console.log(club);
                    $('input[type="checkbox"]:checked', rows).each(function(o,a){
                        checkBoxC[checkBoxC.length]=$(a).val();
						  $.each(checkBoxC, function(h, el){
                            if($.inArray(el, club) === -1) club.push(el);
                        });
                    });
           
					$('#myval').val(club);
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
</style>
</body>

   
