<?php
include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');
$php_self = explode('/',$_SERVER['PHP_SELF']);
array_pop($php_self);
$url_r = base64_encode(implode('/',$php_self)."/fabric_requisition.php");
$has_permission=haspermission($url_r);
// echo "Authp : ".var_dump($has_permission);
// die();
$get_fabric_requisition = getFullURL($_GET['r'],'fabric_requisition.php','N');
						$sidemenu=true;
?>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURL($_GET['r'],'marker_length_popup.php','R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	// $username="sfcsproject1";
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
		header("Location:sfcs_app/app/dashboards/controllers/cut_table_dashboard/restrict.php?group_docs=".$_GET['group_docs']);
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
	$get_url1 = getFullURLLevel($_GET['r'],'marker_length_popup.php',0,'R');

    
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
			document.apply['submit1'].disabled =true;
			document.apply['check'].checked=false;
		}
	}else{
		sweetAlert("Info!", "Enter Correct Date And Time.", "warning");
		document.getElementById("sdat").value=yer+"-"+month+"-"+date;
		document.getElementById("mins").value=mins;
		document.apply['submit1'].disabled =true;
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

<tr><th>Style</th><th>Schedule</th><th>Color</th><th>Job No</th><th>Category</th><th>Item Code</th><th>Docket No</th><th>Requirment</th><th>Reference</th><th>Length</th><th>Shrinkage</th><th>Width</th><th>Control</th></tr>
<?php
	$sql11x1="select order_tid,acutno from $bai_pro3.plandoc_stat_log where doc_no=$doc_no";	
	$sql_result11x1=mysqli_query($link, $sql11x1) or die("Error10 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x1=mysqli_fetch_array($sql_result11x1))
	{
		$order_ti=$row111x1["order_tid"];
		$cut_no=$row111x1["acutno"];			
	}
	$sql11x132="select order_style_no from $bai_pro3.bai_orders_db_confirm where order_tid='".$order_ti."'";	
	$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error11 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x112=mysqli_fetch_array($sql_result11x112))
	{
		$stylex=$row111x112["order_style_no"];
	}
	$sql111x="select mklength,compo_no,category,order_del_no,order_col_des,color_code,doc_no,cat_ref,acutno,material_req,(sum(p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50
	)*p_plies) as qty from $bai_pro3.order_cat_doc_mk_mix where order_tid='".$order_ti."' and pcutno='".$cut_no."' group by doc_no";
	$sql_result111x=mysqli_query($link, $sql111x) or die("Error12 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row111x=mysqli_fetch_array($sql_result111x))
	{
		$schedulex=$row111x["order_del_no"];
		$colorx=$row111x["order_col_des"];	
		$docs_no[] = $row111x["doc_no"];	
		$appender = $row111x["color_code"];
		$doc_qty[$row111x["doc_no"]] = $row111x["qty"];
		$cat_refnce[$row111x["doc_no"]] = $row111x["category"];
		$cat_compo[$row111x["doc_no"]] = $row111x["compo_no"];
		$cat_tid = $row111x["cat_ref"];
		// $sql111x12="select seperate_docket,binding_consumption from $bai_pro3.cat_stat_log where order_tid='".$order_ti."' and tid='".$row111x["cat_ref"]."'";
		$sql111x12="select seperate_docket,binding_consumption from $bai_pro3.cat_stat_log where order_tid='".$order_ti."' and tid=$cat_tid";
		$sql_result111x12=mysqli_query($link, $sql111x12) or die("Error13 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
		// $mk_len=$row111x["mklength"];
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
		// echo "<td>".$mk_len."</td>";		
		$sql11x132112="select allocate_ref,mk_ref_id from $bai_pro3.plandoc_stat_log where doc_no=".$docs_no[$i].";";
		$sql_result11x1121=mysqli_query($link, $sql11x132112) or die("Error14 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row111x21=mysqli_fetch_array($sql_result11x1121)) 
		{				//$rows=0;
			if($row111x21['mk_ref_id']>0)
			{	
				$sql11x1321="select shrinkage_group,width,marker_length from $bai_pro3.maker_details where parent_id=".$row111x21['allocate_ref']." and id=".$row111x21['mk_ref_id']."";
				//echo $sql11x1321."<br>";
				$sql_result11x11211=mysqli_query($link, $sql11x1321) or die("Error15 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row111x2112=mysqli_fetch_array($sql_result11x11211)) 
				{
					echo "<td>".$row111x2112['marker_length']."</td>";
					echo "<td>".$row111x2112['shrinkage_group']."</td>";

					echo "<td>".$row111x2112['width']."</td>";
					echo "<td><center><input type='button' style='display : block' class='btn btn-sm btn-danger' id='rejections_panel_btn'".$docs_no[$i]." onclick=test(".$docs_no[$i].") value='Edit'></center></td>";
				
				}
			}
			else
			{
				echo "<td><center>N/A</center></td>";
				echo "<td><center>N/A</center></td>";
				echo "<td><center>N/A</center></td>";
				echo "<td><center>N/A</center></td>";
			}
		}

		
		echo "</tr>";
		
			 
		
		 
		 
			// echo  $modal;
	}

?>

</table><br/><br/>
<?php
for($i=0;$i<sizeof($cat_refnce);$i++)
{
?>
<div class="modal fade" id="rejections_modal<?= $docs_no[$i];?>" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Change Marker Length
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body">
                <div class='panel panel-primary'>
                    <div class='panel-heading'>
                        Marker Length Details
                    </div>
                    <div class='panel-body'>
					<div class='col-sm-12'>
                            <table class='table table-bordered rejections_table' id='mark_len_table<?=$docs_no[$i]?>'>
							<thead>
								<tr class='.bg-dark'><th></th><th>Marker Type</th><th>Marker Version</th><th>Shrinkage Group</th><th>Width</th><th>Marker Length</th><th>Marker Name</th><th>Pattern Name</th><th>Marker Eff.</th><th>Perimeters</th><th>Remarks 1</th><th>Remarks 2</th><th>Remarks 3</th><th>Remarks 4</th><th>Control</th></tr>
							</thead>
                                <tbody id='rejections_table_body<?=$docs_no[$i]?>'>
								<?php 
									
									$doc_no = $docs_no[$i];									
									$sql11x132="select allocate_ref,mk_ref_id,mk_ref from $bai_pro3.plandoc_stat_log where doc_no=".$doc_no.";";
									$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error16 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
									$rows=0;
									
									while($row111x2=mysqli_fetch_array($sql_result11x112)) 
									{
										$mk_ref_id=$row111x2['mk_ref_id'];
										$sql_marker_details = "select * from $bai_pro3.maker_details where parent_id='".$row111x2['allocate_ref']."'";
										$sql_marker_details_result=mysqli_query($link, $sql_marker_details) or die("Error17 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
										$values_rows=mysqli_num_rows($sql_marker_details_result);
										echo "<input type='hidden' name='rows_val' id='rows_val' value='$values_rows' >";
										while($sql_marker_details_res=mysqli_fetch_array($sql_marker_details_result))
										{   
											// var_dump($sql_marker_details_res[id]);
											// var_dump($mk_ref_id);
											$rows++;
											if($sql_marker_details_res[id] == $mk_ref_id)
											{
												echo "<input type='hidden' name='first_val' id='first_val".$doc_no."' value='$mk_ref_id' >";
												echo "<input type='hidden' name='all_ref' id='all_ref".$doc_no."' value=".$row111x2['allocate_ref']." >";
												echo "<input type='hidden' name='mk_ref' id='mk_ref".$doc_no."' value=".$row111x2['mk_ref']." >";
												echo "<input type='hidden' name='doc_no' id='doc_no' value='$doc_no' >";
												echo "<tr><td style='display:none;' class='checked_value' id='checked$sql_marker_details_res[0]'>yes</td>
												<td style='display:none;'  id='id'>$sql_marker_details_res[id]</td>
												<td style='display:none;'  id='doc_no'>$doc_no</td>
												<td style='display:none;'  id='all_ref".$doc_no."'>".$row111x2['allocate_ref']."</td>
												<td style='display:none;'  id='mk_ref".$doc_no."'>".$row111x2['mk_ref']."</td>
												<td><input type='radio' name='selected_len$doc_no' value='".$sql_marker_details_res[0]."' onchange = valid_button($sql_marker_details_res[0]) id='check$sql_marker_details_res[0]' CHECKED></td>
												
												<td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[perimeters]</td><td>$sql_marker_details_res[remarks1]</td><td>$sql_marker_details_res[remarks2]</td><td>$sql_marker_details_res[remarks3]</td><td>$sql_marker_details_res[remarks4]</td><td style='display:none;'>1</td>	
												<td>Can't Delete</td>
												</tr>";
											}
											else
											{
												echo "<input type='hidden' name='first_val' id='first_val".$doc_no."' value='$mk_ref_id' >";
												echo "<input type='hidden' name='all_ref' id='all_ref".$doc_no."' value=".$row111x2['allocate_ref']." >";
												echo "<input type='hidden' name='mk_ref' id='mk_ref".$doc_no."' value=".$row111x2['mk_ref']." >";
												echo "<input type='hidden' name='doc_no' id='doc_no' value='$doc_no' >";
												echo "<tr><td style='display:none;' class='checked_value' id='checked$sql_marker_details_res[id]'>no</td>
												<td style='display:none;'  id='id'>$sql_marker_details_res[id]</td>
												<td style='display:none;'  id='doc_no'>$doc_no</td>
												<td style='display:none;'  id='all_ref".$doc_no."'>".$row111x2['allocate_ref']."</td>
												<td style='display:none;'  id='mk_ref".$doc_no."'>".$row111x2['mk_ref']."</td>
												<td><input type='radio' name='selected_len$doc_no' value='".$sql_marker_details_res[0]."' onchange = valid_button($sql_marker_details_res[id]) id='check$sql_marker_details_res[0]'></td>
												
												<td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[perimeters]</td><td>$sql_marker_details_res[remarks1]</td><td>$sql_marker_details_res[remarks2]</td><td>$sql_marker_details_res[remarks3]</td><td>$sql_marker_details_res[remarks4]</td><td style='display:none;'>1</td><td>Can't Delete</td></tr>";
											}												
										}										
									}
									?>
                                </tbody>

                                <tbody id='rejections_table'>
                                                
									<tr>
									<td></td>
									<?php
									echo "<input type='hidden' name='doc_no_new' id='doc_no_new' value='$id' >";
									?>
									<td><input class="form-control alpha"  type="text" name="in_mktype" id="mk_type<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_mkver" id= "mk_ver<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
									<td><input class="form-control alpha"  type="text" name= "in_skgrp" id= "sk_grp<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
									<td><input class="form-control float"  type="text" name= "in_width" id= "width<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
									<td><input class="form-control float"  type="text" name= "in_mklen" id= "mk_len<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
									<td><input class="form-control alpha"  type="text" name= "in_mkname" id="mk_name<?=$doc_no ?>" onchange="marker_validation(<?=$doc_no ?>, this)"    ></td>
									<td><input class="form-control alpha"  type="text" name= "in_ptrname" id="ptr_name<?=$doc_no ?>"></td>
									<td><input class="form-control float"  type="text" name= "in_mkeff" id= "mk_eff<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_permts" id= "permts<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_rmks1" id= "rmks1<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_rmks2" id= "rmks2<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_rmks3" id= "rmks3<?=$doc_no ?>"></td>
									<td><input class="form-control alpha"  type="text" name= "in_rmks4" id= "rmks4<?=$doc_no ?>"></td>
									<td></td>
									</tr>  
								</tbody>
                            </table>
								<input type='button' class='btn btn-danger pull-right' value='clear' name='clear_rejection' id='clear_rejection' onclick='clear_row(<?=$doc_no ?>)'>
								<?php 
									echo "<input type='button' class='btn btn-warning pull-right' value='Add' name='add_mklen' onclick = 'add_Newmklen(".$doc_no.")' id='add_marker_length'>";
								?>
					<br>
					<?php
					echo "<input type='button' class='btn btn-success pull-left' value='Submit' name='submit' onclick=submit_mklen(".$doc_no.")  id='submit_length'>";
					?>

                    </div>

                </div>
				</div>
                    
                
            </div>

        </div>
    </div>
</div>
<?php
}
?>
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
					$hours=00;
					$mints=0;

					$mins=array("00","05","10","15","20","25","30","35","40","45","50","55");

					echo "<SELECT name=\"mins\" id=\"mins\" onchange=\"GetSelectedItem($rms_request_time);\">

					<option value=\"0:00\" name=\"0.00\">Select Time</option>";
					$selected="";
					for($l=$hours;$l<=23;$l++)
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

					echo "<option value=\"23:59:59\" hidden=\"r22\">11:59 P.M</option>";

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
					
				if(date("H:i:s") <= "23:59:59")
				{
					echo "<td><input type=\"checkbox\" onClick=\" document.apply['submit1'].disabled =(document.apply['submit1'].disabled)? false : true; GetSelectedItem();\" name=\"check\">
					<input type=\"submit\" id=\"submit1\" name=\"submit1\" value=\"Submit\" class=\"btn btn-primary\" style=\"float: right;\" disabled></td>	";
				}
				// else
				// {
				// 	echo "<td><H2>After 9'o Clock You Can't Raise The Fabric Request. If Any Concern Please Concant RM Warehouse Manager.</H2></td>";
				// }	
			}
		
		?>	
	  
		</tr>
	</table>
</form>
</div>
<br/><br/>

<?php
error_reporting(0);
if(isset($_POST["submit1"]))
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
$result2=mysqli_query($link, $sql2) or die("Error12 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row2=mysqli_fetch_array($result2))
{
	$log=$row2["req_time"];
	$log_split=explode(" ",$log);
	
	$sql11="select order_tid,acutno,rm_date from $bai_pro3.plandoc_stat_log where doc_no=\"".$row2["doc_ref"]."\"";
	$sql_result11=mysqli_query($link, $sql11) or die("Error13 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
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
function compareArrays(arr1, arr2){
	arr1 = $.trim(arr1);
	arr2 = $.trim(arr2);
	if(arr1.toString() == arr2.toString()){
		return true;
	}else{
		return false;
	}
}

function marker_validation(id_name, cur_element) 
{
	if($("#mk_name"+id_name).val() != ''){
	var array = [];
	var CurData=[];
	$('#mark_len_table'+id_name+' tr').has('td').each(function() {
		var arrayItem = [];
		$('td', $(this)).each(function(index, item) {
			arrayItem[index] = $(item).text();
		});
		array.push(arrayItem);
	});
	CurData = [$("#mk_name"+id_name).val()];
		var table = $('#mark_len_table'+id_name);
		var tr_length= table.find('tr').length;
		for($i=0; $i<tr_length - 1; $i++)
		{
			rowData = [array[$i][11]];
			if(compareArrays(CurData, rowData)){
				swal('Marker Name Already exists','Please Check.','warning');
				$("#"+cur_element.id).val('');
				return true;
			}
		}
	}
}

function validate_data(id_name, cur_element) 
{
	// console.log(id_name);
	
	if($("#mk_ver"+id_name).val() != '' && $("#sk_grp"+id_name).val() != '' && $("#width"+id_name).val() != '' && $("#mk_len"+id_name).val()){
	var array = [];
	var CurData=[];
	// console.log($('#mark_len_table'+id_name+' tr'));
	$('#mark_len_table'+id_name+' tr').has('td').each(function() {
		var arrayItem = [];
		$('td', $(this)).each(function(index, item) {
			// console.log($(item).text());
			// console.log($(item).val());
			arrayItem[index] = $(item).text();
		});
		array.push(arrayItem);
	});
	CurData = [$("#mk_ver"+id_name).val(), $("#sk_grp"+id_name).val(), $("#width"+id_name).val(), Math.round($("#mk_len"+id_name).val())];
		var table = $('#mark_len_table'+id_name);
		var tr_length= table.find('tr').length;
	

		for($i=0; $i<tr_length - 1; $i++)
		{
			rowData = [array[$i][7], array[$i][8], array[$i][9], Math.round(array[$i][10])];
			console.log(CurData);
			console.log(rowData);
			// if(compareArrays(CurData, rowData)){
			// 	swal('Marker Name Must be Unique','','error');
			// 	$("#"+cur_element.id).val('');
			// 	return true;
			// }
			if(compareArrays(CurData, rowData)){
				swal('Using Same combinations...','Please Check.','warning');
				$("#"+cur_element.id).val('');
				return true;
			}
		}

	}
	// else {
	// 	sweetAlert('Marker Type/Marker Version/Shrinkage Group/Width/Marker Length are mandatory','','warning');
	// }
}
function add_Newmklen(doc_no)
{	
	var mk_type = $('#mk_type'+doc_no).val();
	var mk_ver = $('#mk_ver'+doc_no).val();
	var sk_grp = $('#sk_grp'+doc_no).val();
	var width = $('#width'+doc_no).val();
	var mk_len = $('#mk_len'+doc_no).val();
	var mk_name = $('#mk_name'+doc_no).val();
	var ptr_name = $('#ptr_name'+doc_no).val();
	var mk_eff = $('#mk_eff'+doc_no).val();
	var permts = $('#permts'+doc_no).val();
	var rmks1 = $('#rmks1'+doc_no).val();
	var rmks2 = $('#rmks2'+doc_no).val();
	var rmks3 = $('#rmks3'+doc_no).val();
	var rmks4 = $('#rmks4'+doc_no).val();
	var values_rows1 = $('#first_val').val();
	var all_refs = $('#all_ref'+doc_no).val();
	var doc_nos = doc_no;
	var doc_no_new = doc_no;
	// alert(doc_nos);
	// $('#doc_no_new').val(doc_nos);
	var mk_refs = $('#mk_ref'+doc_no).val();
	var rows_valu = parseInt($('#rows_val').val())+1;
	//alert(values_rows1)
	//$('#rows_val').val(rows_valu);
	$('.checked_value').text('no');
	//$('#checked'+values_rows1).text('no');
	
	

	if(mk_ver == ''){
		sweetAlert('Please enter valid Marker Version','','warning');
		return false;
	}
	// if(mk_eff == ''){
	// 	sweetAlert('Please enter valid Marker Eff','','warning');
	// 	return false;
	// }
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
	var table_body = $("#rejections_table_body"+doc_no);
	var new_row = "<tr id='unique_d_"+doc_no+"_r_"+rows_valu+"'><td style='display:none;' class='checked_value' id='checked"+values_rows1+"'>yes</td><td style='display:none;' id='id'>"+rows_valu+"</td><td style='display:none;' id='doc_no' >"+doc_no_new+"</td><td style='display:none;'  id='all_ref'>"+all_refs+"</td><td style='display:none;'  id='mk_ref'>"+mk_refs+"</td><td><input type='radio' name='selected_len"+doc_no+"' value="+rows_valu+" id='check"+rows_valu+"' onchange = valid_button("+rows_valu+") CHECKED></td><td>"+mk_type+"</td><td>"+mk_ver+"</td><td>"+sk_grp+"</td><td>"+width+"</td><td>"+mk_len+"</td><td>"+mk_name+"</td><td>"+ptr_name+"</td><td>"+mk_eff+"</td><td>"+permts+"</td><td>"+rmks1+"</td><td>"+rmks2+"</td><td>"+rmks3+"</td><td>"+rmks4+"</td><td style='display:none;'>0</td><td><input type='button' style='display : block' class='btn btn-sm btn-danger' id=delete_row"+rows_valu+" onclick=delete_row("+rows_valu+","+doc_no+") value='Delete'></td></tr>";
	
	// $('#delete_row'+rows_valu).on('click',function(){
	// alert(rows_valu);
      	
    // });

	$("#rejections_table_body"+doc_no).append(new_row);
	$('#mk_type'+doc_no).val(' ');
	$('#mk_ver'+doc_no).val(' ');
	$('#sk_grp'+doc_no).val(' ');
	$('#width'+doc_no).val(' ');
	$('#mk_len'+doc_no).val(' ');
	$('#mk_name'+doc_no).val(' ');
	$('#ptr_name'+doc_no).val(' ');
	$('#mk_eff'+doc_no).val(' ');
	$('#permts'+doc_no).val(' ');
	$('#rmks1'+doc_no).val(' ');
	$('#rmks2'+doc_no).val(' ');
	$('#rmks3'+doc_no).val(' ');
	$('#rmks4'+doc_no).val(' ');
}
function delete_row(rows_valu,doc_no){
	
	$("#rejections_table_body"+doc_no+" tr#unique_d_"+doc_no+"_r_"+rows_valu).remove();
	var values_rows1 = $("#first_val"+doc_no+"").val();
	
	$('.checked_value').text('no');
	$('#checked'+values_rows1).text('yes');
	$('#check'+values_rows1).prop('checked', true);
}
function clear_row(doc_no)
{
	$('#mk_type'+doc_no).val(' ');
	$('#mk_ver'+doc_no).val(' ');
	$('#sk_grp'+doc_no).val(' ');
	$('#width'+doc_no).val(' ');
	$('#mk_len'+doc_no).val(' ');
	$('#mk_name'+doc_no).val(' ');
	$('#ptr_name'+doc_no).val(' ');
	$('#mk_eff'+doc_no).val(' ');
	$('#permts'+doc_no).val(' ');
	$('#rmks1'+doc_no).val(' ');
	$('#rmks2'+doc_no).val(' ');
	$('#rmks3'+doc_no).val(' ');
	$('#rmks4'+doc_no).val(' ');
}
function valid_button(row_num)
{
	$('.checked_value').text('no');
	$('#checked'+row_num).text('yes');
	//alert(row_num);
	// $('input[name="selected_len"]').val('no');
	// $('#'+id.name).val('yes');
}
function submit_mklen(doc_no)
{
	var tabledata = [];
	$('#mark_len_table'+doc_no+' tr').has('td').each(function() {
		var tabledataItem = [];
		$('td', $(this)).each(function(index, item) {
			
			// console.log(index,$(item));
			tabledataItem[index] = $(item).text();
			// console.log(index);
		});
		tabledata.push(tabledataItem);
		// console.log(tabledata);
	});

	var jsonString = JSON.stringify(tabledata);
	$.ajax({
	type : "POST",
	url : '<?= $get_url1 ?>',
	data: {data : jsonString,doc_no:doc_no}, 
	}).success(function(response){
		//console.log(response);
		//var check_val = response.status_no;
		var data = jQuery.parseJSON(response);
		var p1 = data.status_no;
		//console.log(p1);
		
		if(p1 == 1)
		{
			swal('Success',data.status,'success');
		}
		else if(p1 == 2)
		{
			swal('Success',data.status_new,'success');
		}
		else
		{
			swal('error','Something Went Wrong Please try again..!','error');	
		}	
		//swal('Success','Marker Details Updated successfully','success');
		location.reload();	
	});
}
function test(doc_no){
	// var t = document.getElementById('doc_details').value;
	// $('#product_name').val(t);
	$("#rejections_modal"+doc_no).modal('toggle');
	
}

// $('#rejections_panel_btn').on('click',function(){

//         $('#rejections_modal').modal('toggle');
//     });

</script>
