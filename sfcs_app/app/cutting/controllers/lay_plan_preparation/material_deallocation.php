<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
	$username = getrbac_user()['uname'];
	$url_r = $_GET['r'];
    $get_url1 = getFullURLLevel($_GET['r'],'pop_up_maker.php',0,'R');
    $get_url2 = getFullURLLevel($_GET['r'],'pop_up_maker.php',0,'N');
	$temp = 0;
    $plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
?>

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
<div class="panel panel-primary"> 
    <div class="panel-heading">Material Deallocation</div>
        <div class='panel-body'>
            <form method="post" name="form1" action="?r=<?php echo $_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Docket Number</label>
                        <input type="text" class='integer form-control' id="docket_number" name="docket_number" size=8 required>
                    </div>
                    <br/>
                    <div class="col-md-3">
					<?php 
						 
						echo '<input type="submit" id="material_deallocation" class="btn btn-primary" name="formSubmit" value="Request to Deallocate">';
						
					?>
                    </div>
                    <img id="loading-image" class=""/>  
                </div>
            </form>
        </div>
        <ul id="rowTab" class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab_a"><b><span class='label label-default' style='font-size:15px'>Deallocate Requests</span></b></a></li>
            <li><a data-toggle="tab" href="#tab_b"><b><span class='label label-default' style='font-size:15px'>Deallocated List </span></b></a></li>
        </ul>
        <div class="tab-content">
            <div id="tab_a" class="tab-pane fade active in">
                <div style='overflow:scroll;' class='table-responsive'>
                    <table id='table1' class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>SNo.</th>
                                <th>Docket Number</th>
                                <th>Style</th>
                                <th>Color</th>
                                <th>Qty</th>
                                <th>Requested By</th>
                                <th>Requested At</th>
								<?php 
										echo "<th>Status</th>
										<th>Control</th>
										<th>Control</th>";
									
								?>
                            </tr>
                        </thead>
                        <?php
                            $doc_nos=array();    
                            $query = "select * from $wms.material_deallocation_track where status='Open' and plant_code='".$plant_code."'";
                            $sql_result = mysqli_query($link,$query);
                            // echo $query;
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                // var_dump($sql_row);
                                $doc_nos[]=$sql_row['doc_no'];
                                $table1_rows++;
                                $i = $sql_row['id'];
                                $doc_no = $sql_row['doc_no'];
                                $index+=1;
								$query2 = "SELECT style,color FROM $pps.`jm_docket_lines` jdl 
								LEFT JOIN $pps.`jm_dockets` jd ON jd.jm_docket_id=jdl.`jm_docket_id`
								LEFT JOIN $pps.`jm_cut_job` jcj ON jcj.`jm_cut_job_id`=jd.`jm_cut_job_id`
								LEFT JOIN $pps.`mp_sub_order` mso ON mso.`po_number`=jcj.`po_number`
								LEFT JOIN $pps.`mp_color_detail` mcd ON mcd.`master_po_details_id`=mso.`master_po_number`
								WHERE jdl.`docket_line_number`=".$doc_no."";
								$sql_result2 = mysqli_query($link,$query2);
								while($sql_row2=mysqli_fetch_array($sql_result2)) 
								{
									// var_dump($sql_row2['order_style_no']);
									// var_dump($sql_row2['order_del_no']);

									echo "<tr><td>".$index."</td>";
									echo "<td>".$sql_row['doc_no']."</td>";
									echo "<td>".$sql_row2['style']."</td>";
									echo "<td>".$sql_row2['color']."</td>";
									echo "<td>".$sql_row['qty']."</td>";
									echo "<td>".$sql_row['requested_by']."</td>";
									echo "<td>".$sql_row['requested_at']."</td>";
									 
										echo "<td><select name='issue_status$i' id='issue_status-$i' class='select2_single form-control' onchange='IssueAction($i);'>";
										echo "<option value=''>Please Select</option>";
										echo "<option value='Deallocated'>Deallocated</option>";
										echo "<option value='Reject'>Reject</option>";
										echo "</select></td>";
										echo "<td><input type='submit' name='submit$i' id='submit-$i' class='btn btn-primary' value='Deallocate' disabled='disabled' onclick='Approve_deallocation($i);'><input type='reject' name='reject$i' id='reject-$i' class='btn btn-danger' value='Reject' disabled='disabled' onclick='Reject_deallocation($i);'></td>";
										echo "<td><input type='button' style='display : block' class='btn btn-sm btn-warning' id='rejections_panel_btn'".$doc_no." onclick=test(".$doc_no.") value='Edit'></td>"; 
									
									
									echo "</tr>";
							   
								}
                                
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div id="tab_b" class="tab-pane fade">
                <div style='overflow:scroll;' class='table-responsive'>
                    <table id='table1' class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>SNo.</th>
                                <th>Docket Number</th>
                                <th>Qty</th>
                                <th>Requested By</th>
                                <th>Requested At</th>
                                <th>Approved By</th>
                                <th>Approved At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <?php
                            $query = "select * from $wms.material_deallocation_track where status<>'Open' and plant_code='".$plant_code."'";
                            $sql_result = mysqli_query($link,$query);
                            // echo $query;
                            $index=0;
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                $table1_rows++;
                                $i = $sql_row['id'];
                                $index+=1;
                                echo "<tr><td>".$index."</td>";
                                echo "<td>".$sql_row['doc_no']."</td>";
                                echo "<td>".$sql_row['qty']."</td>";
                                echo "<td>".$sql_row['requested_by']."</td>";
                                echo "<td>".$sql_row['requested_at']."</td>";
                                echo "<td>".$sql_row['approved_by']."</td>";
                                echo "<td>".$sql_row['approved_at']."</td>";
                                echo "<td>".$sql_row['status']."</td>";
                                echo "</tr>";
                            }
                            ?> 
                    </table>
                </div>
            </div>
            
    </div>
   
   
</div>
<?php
for($i=0;$i<sizeof($doc_nos);$i++)
{
?>
<div class="modal fade" id="rejections_modal<?= $doc_nos[$i];?>" role="dialog">
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
                            <table class='table table-bordered rejections_table' id='mark_len_table<?=$doc_nos[$i]?>'>
							<thead>
								<tr class='.bg-dark'><th></th><th>Marker Type</th><th>Marker Version</th><th>Shrinkage Group</th><th>Width</th><th>Marker Length</th><th>Marker Name</th><th>Pattern Name</th><th>Marker Eff.</th><th>Perimeters</th><th>Remarks 1</th><th>Remarks 2</th><th>Remarks 3</th><th>Remarks 4</th><th>Control</th></tr>
							</thead>
                                <tbody id='rejections_table_body<?=$doc_nos[$i]?>'>
								<?php 
									
									$doc_no = $doc_nos[$i];
									
									$sql11x132="select allocate_ref,mk_ref_id,mk_ref from $bai_pro3.plandoc_stat_log where doc_no=".$doc_no.";";
									$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error16 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
									$rows=0;
									
									while($row111x2=mysqli_fetch_array($sql_result11x112)) 
									{
										$mk_ref_id=$row111x2['mk_ref_id'];
										//echo $mk_ref_id."--".$row111x2['allocate_ref']."<br>";
										$sql_marker_details = "select * from $bai_pro3.maker_details where parent_id='".$row111x2['allocate_ref']."'";
										$sql_marker_details_result=mysqli_query($link, $sql_marker_details) or die("Error17 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
										$values_rows=mysqli_num_rows($sql_marker_details_result);
										echo "<input type='hidden' name='rows_val' id='rows_val' value='$values_rows' >";
										while($sql_marker_details_res=mysqli_fetch_array($sql_marker_details_result))
										{   
											// var_dump($sql_marker_details_res[id]);
											// var_dump($mk_ref_id);
											//echo $sql_marker_details_res[id]."<br>";
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
												<td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[perimeters]</td><td>$sql_marker_details_res[remarks1]</td><td>$sql_marker_details_res[remarks2]</td><td>$sql_marker_details_res[remarks3]</td><td>$sql_marker_details_res[remarks4]</td><td style='display:none;'>1</td><td>Can't Delete</td>	
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

if(isset($_POST['formSubmit']))
{
        $doc_no = $_POST['docket_number'];
   
        $fabric_status_qry="SELECT * FROM $pps.requested_dockets WHERE doc_no=$doc_no";
        // echo $fabric_status_qry;
    
        $fabric_status_qry_result=mysqli_query($link, $fabric_status_qry) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($fabric_status_qry_result)>0)
        {
            while($sql_row0=mysqli_fetch_array($fabric_status_qry_result))
            {
                $fabric_status = $sql_row0['fabric_status'];
            }
        
            $fab_qry="SELECT * FROM $wms.fabric_cad_allocation WHERE doc_no='$doc_no' and plant_code='".$plant_code."'";
            $fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
            if(mysqli_num_rows($fab_qry_result)>0)
            {     
                if($fabric_status != 5)
                {
                    $is_requested="SELECT * FROM $wms.material_deallocation_track WHERE doc_no=$doc_no and status='Open' and plant_code='".$plant_code."'";
                    $is_requested_result=mysqli_query($link, $is_requested) or exit("Sql Error0: fabric_status_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

                    if(mysqli_num_rows($is_requested_result)==0)
                    {
                        $fab_qry="SELECT * FROM $wms.fabric_cad_allocation WHERE doc_no='$doc_no' and plant_code='".$plant_code."'";
                        $fab_qry_result=mysqli_query($link, $fab_qry) or exit("Sql Error1: fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $allocated_qty=0;
                        while($sql_row1=mysqli_fetch_array($fab_qry_result))
                        {
                            $allocated_qty+=$sql_row1['allocated_qty'];  
                        }
                        $req_at = date("Y-m-d H:i:s");
                        $insert_req_qry = "INSERT INTO $wms.material_deallocation_track(doc_no,qty,requested_by,requested_at,status,plant_code,created_user,updated_user,updated_at) values ($doc_no,$allocated_qty,'$username','$req_at','Open','".$plant_code."','".$username."','".$username."',NOW())";
                        $insert_req_qry_result=mysqli_query($link, $insert_req_qry) or exit("Sql Error2: material_deallocation_track".mysqli_error($GLOBALS["___mysqli_ston"]));
                        echo "<script>swal('success','Request Sent Successfully','success')</script>";
                        $url = getFullUrlLevel($_GET['r'],'material_deallocation.php',0,'N');
                        echo "<script>setTimeout(function(){
                                    location.href='$url' 
                                },2000);
                                </script>";
                        exit();
                    } 
                    else 
                    {
                        echo "<script>swal('Warning','Material Deallocation Request is Already Sent','warning')</script>";
                    }
                }else 
                {
                    echo "<script>swal('Error','Material is Issued to Cutting','error')</script>";
                }
            }
            else{
                echo "<script>swal('Error','Material is Not Yet Allocated','error')</script>";
            }
        } 
        else{
            echo "<script>swal('Error','Enter Valid Docket Number','error')</script>";
        }
}
?>
<script>
// $(document).ready(function(){
// 	document.getElementById('material_deallocation').style.visibility='hidden';
// });
// $('#docket_number').on('change',function(){

// 	document.getElementById('material_deallocation').style.visibility='hidden';
// 	// document.getElementById('material_deallocation_message').style.visibility='visible';
// });
// $(document).ready(function(){
// 	document.getElementById('submit-'+i).style.visibility='hidden';
// 	document.getElementById('reject-'+i).style.visibility='hidden';

// });
function IssueAction(i)
{
	if($('#issue_status-'+i).val()=='Deallocated'){
	    document.getElementById('submit-'+i).disabled = false;
	    document.getElementById('reject-'+i).disabled = true;
		// document.getElementById('submit-'+i).style.visibility='visible';
		// document.getElementById('reject-'+i).style.visibility='hidden';
	} else {
	    document.getElementById('reject-'+i).disabled = false;
	    document.getElementById('submit-'+i).disabled = true;
		// document.getElementById('reject-'+i).style.visibility='visible';
		// document.getElementById('submit-'+i).style.visibility='hidden';
	}
}
function Approve_deallocation(i) {
    if($('#submit-'+i).val()) {
        var status = $('#issue_status-'+i).val();
        var row_id = i;

        if(status=='Deallocated') {
            url_path = "<?php echo getFullURL($_GET['r'],'update_deallocation_status.php','N'); ?>";
            location.href=url_path+"&id="+row_id+"&status="+status;
        }
    }
    
}

function Reject_deallocation(i) {
    if($('#reject-'+i).val()) {
        var status = $('#issue_status-'+i).val();
        var row_id = i;

        if(status=='Reject') {
            url_path = "<?php echo getFullURL($_GET['r'],'delete_deallocation.php','N'); ?>";
            location.href=url_path+"&id="+row_id+"&status="+status;
        }
    }
    
}

function compareArrays(arr1, arr2){
	// console.log(arr1.toString());
	// console.log(arr2.toString());
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
	var values_rows1 = $('#first_val'+doc_no).val();
	var all_refs = $('#all_ref'+doc_no).val();
	var doc_nos = doc_no;
	var doc_no_new = doc_no;
	// alert(doc_nos);
	// $('#doc_no_new').val(doc_nos);
	var mk_refs = $('#mk_ref'+doc_no).val();
	var rows_valu = parseInt($('#rows_val').val())+1;
	//alert(values_rows1)
	$('#rows_val').val(rows_valu);
	$('#checked'+values_rows1).text('no');
	
	

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
	var new_row = "<tr id='unique_d_"+doc_no+"_r_"+rows_valu+"'><td style='display:none;' class='checked_value' id='checked"+values_rows1+"'>yes</td><td style='display:none;' id='id'>"+rows_valu+"</td><td style='display:none;' id='doc_no' >"+doc_no_new+"</td><td style='display:none;'  id='all_ref'>"+all_refs+"</td><td style='display:none;'  id='mk_ref'>"+mk_refs+"</td><td><input type='radio' name='selected_len"+doc_no+"' value="+rows_valu+" id='check"+rows_valu+"' onchange = valid_button("+rows_valu+") CHECKED></td><td>"+mk_type+"</td><td>"+mk_ver+"</td><td>"+sk_grp+"</td><td>"+width+"</td><td>"+mk_len+"</td><td>"+mk_name+"</td><td>"+ptr_name+"</td><td>"+permts+"</td><td>"+mk_eff+"</td><td>"+rmks1+"</td><td>"+rmks2+"</td><td>"+rmks3+"</td><td>"+rmks4+"</td><td style='display:none;'>0</td><td><input type='button' style='display : block' class='btn btn-sm btn-danger' id=delete_row"+rows_valu+" onclick=delete_row("+rows_valu+","+doc_no+") value='Delete'></td></tr>";
	
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
	// alert('unique_d_'+doc_no+'_r_'+rows_valu);
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
	$('#rmks'+doc_no).val(' ');
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

</script>