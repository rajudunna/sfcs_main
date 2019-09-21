<!--
Changes Log:

2014-07-09/ Dharanid /service request #159184 / Add the balasubramanyams,lakshmik,ramalingeswararaoa user names at $users array
2014-09-06 / dharnid/ service request #800666 : baisec1 user access to kanakalakshmi(baicutsec1).

2014-12-22 / RameshK / Service Request# 354829 / Changed the logic for calculating the difference between two times.
-->

<?php
// include($_SERVER['DOCUMENT_ROOT']."server/user_acl_v1.php");
// include($_SERVER['DOCUMENT_ROOT']."server/group_def.php");
// $view_access=user_acl("SFCS_0208",$username,1,$group_id_sfcs);
// $users=user_acl("SFCS_0208",$username,43,$group_id_sfcs);
include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/fabric_requisition.php");
$has_permission=haspermission($url_r);
// echo "Authp : ".var_dump($has_permission);
// die();

?>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURL($_GET['r'],'marker_length_popup.php','R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	// $username="sfcsproject1";
	// $users=array("sfcsproject1","rameshk","kirang","duminduw","rajanaa","chandrasekhard","prabathsa","baiadmn","naleenn","priyankat","balasubramanyams","lakshmik","ramalingeswararaoa","baicutsec1","tharangam");
	//$mods=array();
	$query = "select * from $bai_pro3.tbl_fabric_request_time";
	$update_request_time=mysqli_query($link, $query) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($update_request_time)){
		$rms_request_time = $row['request_time'];
	}
	if((in_array($authorized,$has_permission)))
	{
		//echo "Names Exit";
	}
	else
	{	
		// echo $_GET['r'];
		header("Location:sfcs_app/app/dashboards/controllers/Cut_table_dashboard/restrict.php?group_docs=".$_GET['group_docs']);
		// header($_GET['r'],'restrict.php','N');
	}

	if(isset($_POST['sdat'])) 
	{ 
		//echo $_POST['doc'];
		$doc_no=$_POST['doc'];
		$group_docs=$_POST["group_docs"];
		$section=$_POST["secs"];
		$module=$_POST["mods"];
		$sql2x="select * from $bai_pro3.fabric_priorities where doc_ref=\"".$doc_no."\"";
		$result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows2=mysqli_num_rows($result2x);	
	} 
	else
	{
		$doc_no=$_GET["doc_no"];
		$group_docs=$_GET["group_docs"];
		$section=$_GET["section"];
		$module=$_GET["module"];
		$sql2x="select * from $bai_pro3.fabric_priorities where doc_ref=\"".$doc_no."\"";
		$result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows2=mysqli_num_rows($result2x);	
	}	
	$get_url = getFullURL($_GET['r'],'fabric_requisition.php',0,'R');
    $get_url = getFullURLLevel($_GET['r'],'marker_length_popup.php',0,'R');
	
    
//echo $doc_no;
?>

  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'TableFilter_EN/filtergrid.css',0,'R'); ?>">
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/


/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:15px; padding:15px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>

<script>

function pad(number, length) {
   
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
   
    return str;

}

function GetSelectedItem()
{
	var rms_request_time_test = "<?php echo $rms_request_time; ?>";
	var dat=document.getElementById("sdat").value;
	var mins=document.getElementById("mins").value;
	var currentTime = new Date();
	var date=currentTime.getDate();
	var month=currentTime.getUTCMonth()+1;
	var yer=currentTime.getFullYear();
	var hours=currentTime.getHours();
	//var hours=currentTime.getHours()+3; //3 hours lead time
	//var hours=currentTime.getHours()+parseInt(rms_request_time_test); //1 hours lead time
	var mints=currentTime.getMinutes();
	var datsplit=dat.split("-");
	var timsplit=mins.split(":");
	
	var dt1 = new Date(parseInt(month)+" "+parseInt(date)+", "+parseInt(yer)+" "+parseInt(hours)+":"+parseInt(mints));
	var dt2 = new Date(parseInt(datsplit[1])+" "+parseInt(datsplit[2])+", "+parseInt(datsplit[0])+" "+parseInt(timsplit[0])+":"+parseInt(timsplit[1]));
	var diff =(dt2.getTime() - dt1.getTime()) / 1000;
	var diff=diff / (60 * 60);
	var round_diff=diff.toFixed(2);
	if(parseFloat(round_diff)>0){
		if(parseFloat(round_diff)>parseFloat(rms_request_time_test)){	
		
		}
		else{
			sweetAlert("Info!", "Enter Correct Date And Time.", "warning");
			document.getElementById("sdat").value=yer+"-"+month+"-"+date;
			document.getElementById("mins").value=mins;
			document.apply['submit'].disabled =true;
			document.apply['check'].checked=false;
		}
	}else{
		sweetAlert("Info!", "Enter Correct Date And Time.", "warning");
		document.getElementById("sdat").value=yer+"-"+month+"-"+date;
		document.getElementById("mins").value=mins;
		document.apply['submit'].disabled =true;
		document.apply['check'].checked=false;
	}
	
}

</script>

<body>
<div class="panel panel-primary">
<div class="panel-heading">Fabric Requisition Form</div>
<div class="panel-body">
<hr>
<!--<?php echo "Docket No = ".$doc_no; ?>-->
<div class='table-responsive'>
<form method="POST" name="apply">
<table class="table table-bordered">

<tr><th>Style</th><th>Schedule</th><th>Color</th><th>Job No</th><th>Category</th><th>Item Code</th><th>Docket No</th><th>Requirment</th><th>Reference</th><th>Marker Length</th></tr>
<?php
	$sql11x1="select order_tid,acutno from $bai_pro3.plandoc_stat_log where doc_no='".$doc_no."'";	
	$sql_result11x1=mysqli_query($link, $sql11x1) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x1=mysqli_fetch_array($sql_result11x1))
	{
		$order_ti=$row111x1["order_tid"];
		$cut_no=$row111x1["acutno"];
	}
	$sql11x132="select order_style_no from $bai_pro3.bai_orders_db_confirm where order_tid='".$order_ti."'";	
	$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x112=mysqli_fetch_array($sql_result11x112))
	{
		$stylex=$row111x112["order_style_no"];
	}
	$sql111x="select compo_no,category,order_del_no,order_col_des,color_code,doc_no,cat_ref,acutno,material_req,(sum(p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50
	)*p_plies) as qty from $bai_pro3.order_cat_doc_mk_mix where order_tid='".$order_ti."' and pcutno='".$cut_no."' group by doc_no";
	$sql_result111x=mysqli_query($link, $sql111x) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x=mysqli_fetch_array($sql_result111x))
	{
		$schedulex=$row111x["order_del_no"];
		$colorx=$row111x["order_col_des"];	
		$docs_no[] = $row111x["doc_no"];	
		$appender = $row111x["color_code"];
		$doc_qty[$row111x["doc_no"]] = $row111x["qty"];
		$cat_refnce[$row111x["doc_no"]] = $row111x["category"];
		$cat_compo[$row111x["doc_no"]] = $row111x["compo_no"];
		$sql111x12="select seperate_docket,binding_consumption from $bai_pro3.cat_stat_log where order_tid='".$order_ti."' and tid='".$row111x["cat_ref"]."'";
		$sql_result111x12=mysqli_query($link, $sql111x12) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row111x2=mysqli_fetch_array($sql_result111x12))
		{
			if($row111x2['seperate_docket']=='No')
			{
				$doc_mat[$row111x["doc_no"]] = $row111x["material_req"];				
			}
			else
			{
				$bindin_val = round($row111x2["binding_consumption"]*$row111x["qty"],4);
				$doc_mat[$row111x["doc_no"]] = $row111x["material_req"]-$bindin_val;	
			}
		}		
	}

	for($i=0;$i<sizeof($cat_refnce);$i++)
	{	
		echo "<td>".$stylex."</td>";
		echo "<td>".$schedulex."</td>";
		echo "<td>".$colorx."</td>";
		echo "<td>".chr($appender).leading_zeros($cut_no,3)."</td>";
		echo "<td>".$cat_refnce[$docs_no[$i]]."</td>";
		echo "<td>".$cat_compo[$docs_no[$i]]."</td>";
		echo "<td>".$docs_no[$i]."</td>";
		echo "<td>".$doc_mat[$docs_no[$i]]."</td>";
		echo "<td><input type='hidden' name='doc_details[]' id='doc_details' value='".$docs_no[$i]."'> <input type='text' name='reference[]' value=''></td>";
		// echo "<td><center><input type='button' value='Create' class='homebutton' id='btnHome' data-target='#theModal' data-toggle='modal' onclick=test('".trim($stylex)."','".trim($schedulex)."','".strstr($colorx, '-', true)."','".trim($docs_no[$i])."'); /></center></td>";
		echo "<td><center><input type='button' style='display : block' class='btn btn-sm btn-danger' id='rejections_panel_btn'".$docs_no[$i]." onclick=test(".$docs_no[$i].") value='Create'></center></td>";
		echo "</tr>";
		
			 
		
		 
		 
			// echo  $modal;
	}

?>

</table><br/><br/>
<div class="modal fade" id="rejections_modal" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Assign Marker Length
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body">
                <div class='panel panel-primary'>
                    <div class='panel-heading'>
                        Marker Length Details
                    </div>
                    <div class='panel-body'>
					<div class='col-sm-12'>
                            <table class='table table-bordered rejections_table'>
							<thead>
								<tr class='.bg-dark'><th></th><th>Marker Type</th><th>Marker Version</th><th>Shrinkage Group</th><th>Width</th><th>Marker Length</th><th>Marker Name</th><th>Pattern Name</th><th>Marker Eff.</th><th>Perimeters</th><th>Remarks</th></tr>
							</thead>
                                <tbody id='rejections_table_body'>
								<input type="hidden" name="product" placeholder="Product Name" value="" id="product_name" />
								<?php 
									
									$doc_no = json_encode($_GET['doc_no']);
									$sql11x132="select mk_ref from $bai_pro3.plandoc_stat_log where doc_no=".$doc_no.";";
									$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));

									while($row111x2=mysqli_fetch_array($sql_result11x112)) {
										$sql_marker_stat_log_id = "select allocate_ref, marker_details_id from $bai_pro3.maker_stat_log where tid='".$row111x2['mk_ref']."'";
										$sql_marker_stat_log_result=mysqli_query($link, $sql_marker_stat_log_id) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($sql_marker_id=mysqli_fetch_array($sql_marker_stat_log_result))
										{
											$sql_marker_details = "select * from $bai_pro3.maker_details where parent_id='".$sql_marker_id['allocate_ref']."'";
											$sql_marker_details_result=mysqli_query($link, $sql_marker_details) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
											$no_of_rows = mysqli_num_rows($sql_marker_details_result);
											while($sql_marker_details_res=mysqli_fetch_array($sql_marker_details_result)){
												if($sql_marker_details_res[id] == $sql_marker_id[marker_details_id])
												{
													echo "<tr><td><input type='radio' name='gender' value='' id='check$sql_marker_details_res[0]' CHECKED></td><td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pat_ver]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[remarks]</td></tr>";
												}
												else{

												echo "<tr><td><input type='radio' name='gender' value='' id='check$sql_marker_details_res[0]'></td><td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pat_ver]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[remarks]</td></tr>";
													// echo json_encode($sql_marker_details_res[0]);
												}
							
											}
										}
									}
									?>
                                </tbody>
                            </table>
                        </div>  
                        <div class='col-sm-offset-2 col-sm-8'>
						<table class='table table-bordered rejections_table'>
							<thead>
								<tr class='.bg-dark'><th>Marker Type</th><th>Marker Version</th><th>Shrinkage Group</th><th>Width</th><th>Marker Length</th><th>Marker Name</th><th>Pattern Name</th><th>Marker Eff.</th><th>Perimeters</th><th>Remarks</th></tr>
							</thead>
                                <tbody id='rejections_table_body'>
								
								<tr>
									<td><input class="form-control"  type="text" name="in_mktype" id="mk_type"  title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_mkver" id= "mk_ver" onchange="validate_data(this)" title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_skgrp" id= "sk_grp" onchange="validate_data(this)" title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_width" id= "width" onchange="validate_data(this)" title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_mklen" id= "mk_len" onchange="validate_data(this)" title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_mkname" id="mk_name" title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_ptrname" id="ptr_name" title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_mkeff" id= "mk_eff" title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_permts" id= "permts" title="please enter numbers and decimals"></td>
									<td><input class="form-control"  type="text" name= "in_rmks" id= "rmks" title="please enter numbers and decimals"></td>
									
									</tr>  
                                </tbody>
                            </table>
								<input type='button' class='btn btn-danger pull-right' value='clear' name='clear_rejection' id='clear_rejection' onclick='clear_rejection()'>
								<!-- <input class="btn btn-sm btn-success" onclick="add_Newmklen()" type = 'submit' id='create' name = "update" value = '+'> -->
								<input type='button' class='btn btn-warning pull-right' value='+' name='add_mklen' onclick = 'add_Newmklen()' id='add_marker_length'>
								
                    </div>
                </div>
				</div>
                    
                
            </div>

        </div>
    </div>
</div>

	<table class="table table-bordered">
		<tr>

			<td style="display:none"><input type="hidden" id="doc" name="doc" value="<?php echo $doc_no; ?>" ></td>
			<td style="display:none"><input type="hidden" id="$group_docs" name="group_docs" value="<?php echo $group_docs; ?>" ></td>

		<?php
			if($rows2 > 0)
			{
				echo "<h2>Fabric Already Requested For This Docket</h2>";
			}	
			else
			{	
		?>
		     
			 
			<th>Date</th>
			<td>
				<input data-toggle="datepicker" readonly="true" type="text" id="sdat" name="sdat" onchange="GetSelectedItem();" size=8 value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("Y-m-d"); } ?>"/>
			
				<?php 
					// echo "<a href="."\"javascript:NewCssCal('sdat','yyyymmdd','dropdown')\" onclick=\"document.apply['submit'].disabled =true;document.apply['check'].checked=false;\">";
					// echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
				?>
			</td>

			<th>Time</th>
			<td>
				<?php

					$hours=date("H");

					$mints=date("i");
					$hours=6;
					$mints=0;

					$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");

					echo "<SELECT name=\"mins\" id=\"mins\" onchange=\"GetSelectedItem($rms_request_time);\">

					<option value=\"0:00\" name=\"0.00\">Select Time</option>";
					$selected="";
					for($l=$hours;$l<=21;$l++)
					{
						
						for($k=0;$k<sizeof($mins);$k++)
						{
							if($l==date("H") and $mins[$k]>=date("i"))
							{
								$selected="selected";
							}
							
							if($l<13)
							{
								if($l==$hours)
								{
									if($mints <= $mins[$k])
									{	
										//echo $mins[$k];
										if($l==12)
										{
											echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$l.":".$mins[$k]." P.M</option>";
										}
										else
										{
											echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$l.":".$mins[$k]." A.M</option>";
										}
									}
								}
								else
								{
									if($l==12)
									{
										echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$l.":".$mins[$k]." P.M</option>";
									}
									else
									{
										echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$l.":".$mins[$k]." A.M</option>";
									}
								}
								
							}
							else
							{
								if($l==$hours)
								{
									if($mints <= $mins[$k])
									{
										$r=$l-12;
										echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$r.":".$mins[$k]." P.M</option>";
									}
								}
								else
								{
									$r=$l-12;
									echo "<option value=\"".$l.":".$mins[$k]."\" name=\"r".$l."\" $selected>".$r.":".$mins[$k]." P.M</option>";
								}
							} 
							$selected="";
						}	
					}

					echo "<option value=\"22:00\" name=\"r22\">10:00 P.M</option>";

					if($rms_request_time==1){
						$hour = 'Hour';
					}
					else {
						$hour = 'Hours';
					}


					echo "</SELECT> <strong>Lead time for RM supply is ".$rms_request_time." ".$hour." </strong>";

				?>
			</td>
	
			<td style="display:none"><input type="hidden" id="name" name="name" value="<?php echo $username; ?>" ></td>	
			<td style="display:none"><input type="hidden" id="name" name="secs" value="<?php echo $section; ?>" ></td>	
			<td style="display:none"><input type="hidden" id="name" name="mods" value="<?php echo $module; ?>" ></td>
			
		<?php
					
				if(date("H:i:s") <= "21:00:00")
				{
					echo "<td><input type=\"checkbox\" onClick=\" document.apply['submit'].disabled =(document.apply['submit'].disabled)? false : true; GetSelectedItem();\" name=\"check\"><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Submit\" class=\"btn btn-primary\" style=\"float: right;\" disabled></td>	";
				}
				else
				{
					echo "<td><H2>After 9'o Clock You Can't Raise The Fabric Request. If Any Concern Please Concant RM Warehouse Manager.</H2></td>";
				}	
			}
		
		?>	
	  
		</tr>
	</table>
</form>
</div>
<br/><br/>

<?php
error_reporting(0);
if(isset($_POST["submit"]))
{
	$log_time=date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s");
	$req_time=$_POST["sdat"]." ".$_POST["mins"].":00";
	$doc_nos=$_POST["doc"];
	$group_docs=$_POST["group_docs"];
	$secs=$_POST["secs"];
	$mods=$_POST["mods"];
	$ref=$_POST['reference'];
	$dockets=$_POST['doc_details'];
	
	for($i=0;$i < count($ref);$i++ )
	{		
		$insert="Update $bai_pro3.`plandoc_stat_log` set reference='".$ref[$i]."' where doc_no='".$dockets[$i]."'";
		mysqli_query($link, $insert) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	// var_dump($insert);
	// die();
	// $insert= substr_replace($insert, "", -1);
	$i=mysqli_query($link,$insert);
	//Date: 2013-10-09
	//Old Logic
	//Validation for Requested time and log time 
	/*$log_time_explode=explode(" ",$log_time);
	$req_time_explode=explode(" ",$req_time);
	
	$log_time_explode_explode=explode(":",$log_time_explode[1]);
	$req_time_explode_explode=explode(":",$req_time_explode[1]);
	$log_req_diff=$req_time_explode_explode[0]-$log_time_explode_explode[0];*/
	
	//Calculated time difference between two times
	$date1 = $log_time;
	$date2 = $req_time; 
	//echo strtotime($date2) ."\n";
	$diff = strtotime($date2) - strtotime($date1);
	//echo $diff ."\n";
	$diff_in_hrs = $diff/3600;
	//print_r(round($diff_in_hrs,0));
	$log_req_diff=round($diff_in_hrs,0);
	
	$doc_nos_split=explode(",",$group_docs);
	$host_name=str_replace(".brandixlk.org","",gethostbyaddr($_SERVER['REMOTE_ADDR']));
	$note=date("Y-m-d H:i:s")."_".$username."_".$host_name."<br/>";
	
	//for($i=0;$i<sizeof($doc_nos_split);$i++)
	for($i=0;$i<1;$i++)
	{
		$sql1="select * from $bai_pro3.fabric_priorities where doc_ref=\"".$doc_nos_split[$i]."\"";
		$result=mysqli_query($link, $sql1) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows=mysqli_num_rows($result);
		//Date: 2013-10-09
		//Time difference is grater than or equel to 3
		//Then only system will accept the fabric request
		//if($log_req_diff >= 3)
		if($log_req_diff >= 1)
		{
			if($rows==0)
			{
				$sql="insert into $bai_pro3.fabric_priorities(doc_ref,doc_ref_club,req_time,log_time,log_user,section,module) values(\"".$doc_nos_split[$i]."\",\"".$doc_nos."\",\"".$req_time."\",\"".$log_time."\",\"".$username."\",\"".$secs."\",\"".$mods."\")";
				//echo "<br>".$sql."<br>";
				$note.=$sql."<br>";
				if(!mysqli_query($link, $sql))
				{
					die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				} 
				else
				{
					echo "<h2 style=\"color:red;\">Request Sent Successfully...</h2>";
				}
				
				//Date:2013-08-27
				//Track the requested user details and system details.
				$myFile = "log/".date("Y_m_d")."_fabric_request_track.html";
				$fh = fopen($myFile, 'a');
				$stringData = $note;
				fwrite($fh, $stringData);
			}
			else
			{
				echo "<h2 style=\"color:red;\">Fabric Already Requested For ".$doc_nos_split[$i]." Docket</h2>";
			}
		}
		
	}	
}

echo "<h2>Already Requested Cut Jobs </h2>";
echo "<div class='table-responsive'><table class=\"table table-bordered\" id=\"table1\" border=0 cellpadding=0 cellspacing=0>";
echo "<tr><th>Section</th><th>Module</th><th>Date</th><th>Time</th><th>Requested By</th><th>Style</th><th>Schedule</th><th>Color</th><th>Docket No</th><th>Job No</th><th>Fabric Status</th></tr>";
$sql2="select * from $bai_pro3.fabric_priorities where (log_user=\"".$username."\"  or section=$section) and issued_time=\"0000-00-00 00:00:00\" order by section,req_time,module";
$result2=mysqli_query($link, $sql2) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row2=mysqli_fetch_array($result2))
{
	$log=$row2["req_time"];
	$log_split=explode(" ",$log);
	
	$sql11="select order_tid,acutno,rm_date from $bai_pro3.plandoc_stat_log where doc_no=\"".$row2["doc_ref"]."\"";
	$sql_result11=mysqli_query($link, $sql11) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row11=mysqli_fetch_array($sql_result11))
	{
		$order_tid=$row11["order_tid"];
		$cut_nos=$row11["acutno"];
		$rm_date=$row11["rm_date"];
	}
	
	echo "<tr>";
	echo "<td>".$row2["section"]."</td>";
	echo "<td>".$row2["module"]."</td>";	
	echo "<td>".$log_split[0]."</td>";
	echo "<td>".$log_split[1]."</td>";
	echo "<td>".strtoupper($row2["log_user"])."</td>";	
	
	$sql21="select order_style_no,order_del_no,order_col_des,order_div,color_code from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
	$sql_result21=mysqli_query($link, $sql21) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row21=mysqli_fetch_array($sql_result21))
	{
		$style=$row21["order_style_no"];
		$schedule=$row21["order_del_no"];
		$color=$row21["order_col_des"];
		$buyer=$row21["order_div"];
		$color_code=$row21["color_code"];
	}
	
	echo "<td>".$style."</td>";
	echo "<td>".$schedule."</td>";
	echo "<td>".$color."</td>";
	
	echo "<td>".$row2["doc_ref"]."</td>";
	echo "<td>".chr($color_code).leading_zeros($cut_nos,3)."</td>";
	// echo "<td>".chr($color_code)."00".$cut_nos."</td>";
	
	$issued_time=$row2["issued_time"];
	
	if($issued_time=="0000-00-00 00:00:00")
	{
		echo "<td>Not Issued</td>";
	}
	else
	{
		echo "<td>Issued</td>";
	}
	echo "</tr>";
	
}
echo "</table></div>";

?>
<?php
if(isset($_GET['sidemenu'])){

	echo "<style>
          .left_col,.top_nav{
          	display:none !important;
          }
          .right_col{
          	width: 100% !important;
    margin-left: 0 !important;
          }
	</style>";
}
?>
</div>
</div>
</body>

<script>
function validate_data(id) {
	// alert(id);
	
}
function add_Newmklen()
{
	var mk_type = $('#mk_type').val();
	var mk_ver = $('#mk_ver').val();
	var sk_grp = $('#sk_grp').val();
	var width = $('#width').val();
	var mk_len = $('#mk_len').val();
	var mk_name = $('#mk_name').val();
	var ptr_name = $('#ptr_name').val();
	var mk_eff = $('#mk_eff').val();
	var permts = $('#permts').val();
	var rmks = $('#rmks').val();
	if(mk_ver == ''){
		sweetAlert('Please enter valid Marker Version','','warning');
		return false;
	}
	if(mk_eff == ''){
		sweetAlert('Please enter valid Marker Eff','','warning');
		return false;
	}
	if(mk_len <=0)
	{
		sweetAlert('Please enter valid Marker Length','','warning');
		return false;
	}
	if(width <=0){
		sweetAlert('Please enter valid Marker Width','','warning');
		return false;
	}
	if(mk_len == ''|| mk_len <=0){
		sweetAlert('Please enter valid Marker Length','','warning');
		return false;
	}
	if(mk_eff == '')
	{
		mk_eff = 0;
	}
	if(mk_eff>100){
		sweetAlert('Please enter valid Marker Efficiency','','warning');
		return false;
	}
	if(mk_ver <=0 || mk_ver ==''){
		sweetAlert('Please enter valid Marker Version','','warning');
		return false;
	}
	$.ajax({
	url : '<?= $get_url ?>?mk_ver='+mk_ver+'?mk_type='+mk_type+'?sk_grp='+sk_grp+'?mk_eff='+mk_eff+'?mk_len='+mk_len+'?width='+width+'?permts='+permts+'?ptr_name='+ptr_name+'?rmks='+rmks+'?mk_name='+mk_name
	}).done(function(res){
		console.log(res);
	});
	console.log(mk_ver);
	console.log(mk_type);
	console.log(mk_eff);
	console.log(mk_len);
	console.log(width);
	console.log(ptr_name);
	console.log(permts);
	console.log(rmks);

	// document.getElementById('create').style.display="none";
	// $("#rejections_modal").modal('toggle');

	// return true;
}
function clear_rejection()
{
// $('#clear_rejection').on('click',function(){
	alert($('#mk_type').val());
	// $('#mk_ver').val(' ');
	// $('#sk_grp').val(' ');
	// $('#width').val(' ');
	// $('#mk_len').val(' ');
	// $('#mk_name').val(' ');
	// $('#ptr_name').val(' ');
	// $('#mk_eff').val(' ');
	// $('#permts').val(' ');
	// $('#rmks').val(' ');
}
function test(doc_no){
	var t = document.getElementById('doc_details').value;
	$('#product_name').val(t);
	$("#rejections_modal").modal('toggle');
	$.ajax({
	url : '<?= $get_url ?>?doc_no='+doc_no
	}).done(function(res){
		console.log(res);
	});
}

// $('#rejections_panel_btn').on('click',function(){

//         $('#rejections_modal').modal('toggle');
//     });

</script>
