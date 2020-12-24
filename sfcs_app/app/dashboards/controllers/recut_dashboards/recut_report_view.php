<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>
<style id="Book4_5113_Styles">
th{ color : black;}
td{ color : black;}
.black{
	text-align : right;
	font-weight : bold;
	color : #000;
}
</style>
<script type='text/javascript'>
function show_pop1(){
	if($('#style').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}
function show_pop2(){
	if($('#schedule').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}
function show_pop3(){
	if($('#color').val() == 'NIL' )
		sweetAlert('Please select the following in ORDER','STYLE -> SCHEDULE -> COLOR -> CATEGORY','warning');
}

function firstbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value;
}


function secondbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value
}
function thirdbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
function fourthbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value
}
function fifthbox()
{
	window.location.href ="<?php echo 'index-no-navi.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&subpo="+document.test.subpo.value
}
</script>

<?php 
$url3 = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R');
include("$url3"); 
?>

<?php 
// $url4 =  $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'menu_content.php',2,'R');
// include("$url4"); 
?>

<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];
$mpo=$_GET['mpo'];
$subpo=$_GET['subpo'];

if(isset($_POST['style']))
{
	$style=$_POST['style'];
}

if(isset($_POST['schedule']))
{
	$schedule=$_POST['schedule'];
}

if(isset($_POST['color']))
{
	$color=$_POST['color'];
}

if(isset($_POST['mpo']))
{
	$mpo=$_POST['mpo'];
}

if(isset($_POST['subpo']))
{
	$subpo=$_POST['subpo'];
}
?>

<div class='panel panel-primary'>
	<div class="panel-heading">
		<b>Recut Issue Details</b>
	</div>
	<div class="panel-body">
		<form method="post" name="test" action="?r=<?= $_GET['r'] ?>">
			<div class="col-sm-2 form-group">
				<label for='style'>Select Style</label>
				<select class='form-control' name='style' id='style' onchange='firstbox()'>
				<?php
					echo "<option value=\"NIL\" selected>Select Style</option>";
					//$sql="select distinct order_style_no from bai_orders_db";
					$sql="SELECT DISTINCT style as order_style_no FROM $pts.rejection_header WHERE plant_code='$plantcode' AND is_active=1";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);

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
				echo "</select>";
				?>	
			</div>
			<div class="col-sm-2 form-group">
				<label for='schedule'>Select Schedule</label>
				<select class='form-control' name='schedule' id='schedule' onclick='show_pop1()' onchange='secondbox();' >
				<?php
					echo "<option value=\"NIL\" selected>Select Schedule</option>";	
					//$sql="select distinct order_del_no from bai_orders_db where order_style_no=\"$style\"";
                    $sql="select distinct schedule as order_del_no from $pts.rejection_header where plant_code='$plantcode' AND style ='$style' AND is_active=1";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);

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
					echo "</select>";
				?>
			</div>	
			<div class="col-sm-2 form-group" >
				<label for='color'>Select Color:</label>
				<select class='form-control' name='color' id='color' onclick='show_pop2()' onchange='thirdbox();' >
				<?php
					echo "<option value=\"NIL\" selected>Select Color</option>";
					$sql="select distinct fg_color as order_col_des from $pts.rejection_header where plant_code='$plantcode' and style='$style' and schedule='$schedule' AND is_active=1";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					// echo "<option value=\"All\" selected>All</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
						{
							echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
						}
					}
                echo "</select>";
            ?>
            </div>
            <?php
            /*function to get mpo from getdata_MPOs
			@params : plantcode,schedule,color
			@returns: mpo
			*/
			if($schedule!='' && $color!='' && $plantcode!=''){
				$result_bulk_MPO=getMpos($schedule,$color,$plantcode);
				$master_po_description=$result_bulk_MPO['master_po_description'];
			}
			echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
			echo "<select style='min-width:100%' name=\"mpo\" onchange=\"fourthbox();\" class='form-control' >
					<option value=\"NIL\" selected>NIL</option>";
						foreach ($master_po_description as $key=>$master_po_description_val) {
							if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$mpo)) 
							{ 
								echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
							} 
							else 
							{ 
								echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
							}
						} 
			echo "</select></div>";
            ?>
			<div class="col-sm-2 form-group">
				<label for='style'>Select SubPO</label>
				<select class='form-control' name='subpo' id='subpo' onclick='show_pop3()' onchange='fifthbox();' >
				<?php
					/*function to get subpo from getdata_bulk_subPO
						@params : plantcode,mpo
						@returns: subpo
					*/
					if($mpo!='' && $plantcode!=''){
						$result_bulk_subPO=getBulkSubPo($mpo,$plantcode);
						$sub_po_description=$result_bulk_subPO['sub_po_description'];
					}
					echo "<option value=\"NIL\" selected>Select subpo</option>";
					foreach ($sub_po_description as $key=>$sub_po_description_val) {
						if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$subpo)) 
						{ 
							echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
						}
					} 
				echo "</select>";
				?>	
			</div>
            </br>
            <div class="col-sm-2 form-group">
            <?php
                echo "<input class='btn btn-success' type=\"submit\" value=\"Get Details\" name=\"submit\">";
            ?>
            </div>
		</form>
    </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">Recut Detailed View
                <button type="button" class="btn btn-danger btn-sm pull-right"  id = "cancel" data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body" id='main-content'>
                <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" role="dialog">
    <form action="index.php?r=<?php echo $_GET['r']?>" name= "approve" method="post" id="approve" onsubmit='return validationfunction();'>
        <div class="modal-dialog" style="width: 80%;  height: 100%;">
            <div class="modal-content">
                <div class="modal-header">Markers view
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
                </div>
                <div id='pre'>
                    <div class="modal-body">
                        <div class='panel-body' id="dynamic_table_panel">
                            <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                        <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                            </div>
                            <div id ="dynamic_table1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
if(isset($_POST['submit']))
{
    $style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$mpo=$_POST['mpo'];
	$subpo=$_POST['subpo'];
    ?><div class='row'>
        <div class='panel panel-primary'>
            <div class='panel-heading'>
                <b>Re Cut Issue Dashboard</b>
            </div>
            <div class='panel-body'>
            <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Recut Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Master PO</th><th>Sub PO</th><th>Component</th><th>Rejected quantity</th><th>Recut Raised Quantity</th><th>Recut Reported Quantity</th><th>Issued Quantity</th><th>Remaining Quantity</th><th>View</th>
			<!-- <th>Markers</th> --></thead>
                <?php  
				$s_no = 1;
				$blocks_query="SELECT rh_id,master_po,sub_po,style,SCHEDULE,fg_color,component FROM $pts.rejection_header WHERE plant_code='$plantcode' AND style='$style' AND schedule='$schedule' AND fg_color='$color' AND sub_po='$subpo' AND is_active=1 group by component,rh_id";
                // echo $blocks_query;
				$blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error'); 
				if($blocks_result->num_rows > 0)
            	{       
					while($row = mysqli_fetch_array($blocks_result))
					{
						//echo "<td>".$row['doc_no']."</td>";
						 //$ratios=$row['rh_id'];
						$subpo=$row['sub_po'];
						$masterpo=$row['master_po'];
						$component=$row['component'];
						//To get Ratio_id
						$get_ratio_id="SELECT ratio_id FROM $pps.`lp_ratio` WHERE plant_code='$plantcode' AND po_number='$subpo' AND cut_type='RECUT'";
						$sql_result = mysqli_query($link,$get_ratio_id) or exit('Error get_ratio_id');
						if($sql_result->num_rows > 0)
						{
							while($ratio_row = mysqli_fetch_array($sql_result))
							{
								$ratio_id[]=$ratio_row['ratio_id'];
							}
						} else 
						{
							echo "<tr><td colspan='12' style='color:red;text-align: center;'><b>No Recut Dockets Found!!!</b></td></tr>";
							die();
						}
						
						//To get PO Description
						$result_po_des=getPoDetaials($subpo,$plantcode);
						$subpo_des=$result_po_des['po_description']; 
						//To get MPO Description
						$qry_toget_podescri="SELECT master_po_description FROM $pps.mp_order WHERE master_po_number='$masterpo' AND plant_code='$plantcode' AND is_active=1";
						$toget_podescri_result=mysqli_query($link, $qry_toget_podescri) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($des_row = mysqli_fetch_array($toget_podescri_result))
						{
							$masterpo_des=$des_row['master_po_description'];
						}
						//To get Docket numbers
						$get_component_ids="SELECT lp_ratio_cg_id FROM $pps.`lp_ratio_component_group` LEFT JOIN $pps.`lp_product_component` ON lp_product_component.`component_group_id`= lp_ratio_component_group.`component_group_id` WHERE lp_ratio_component_group.plant_code='$plantcode' AND ratio_id IN ('".implode("','" , $ratio_id)."') AND component_name='$component'";
						$sql_result1 = mysqli_query($link,$get_component_ids) or exit('Error get_component_ids');
						while($row1 = mysqli_fetch_array($sql_result1))
						{
							$lp_ratio_ids[]=$row1['lp_ratio_cg_id'];
						}
						$get_jm_docketids="SELECT jm_docket_id FROM $pps.`jm_dockets` WHERE plant_code='$plantcode' AND ratio_comp_group_id IN ('".implode("','" , $lp_ratio_ids)."')";
						$sql_result2 = mysqli_query($link,$get_jm_docketids) or exit('Error get_jm_docketids');
						while($row2 = mysqli_fetch_array($sql_result2))
						{
							$jm_docket_id[]=$row2['jm_docket_id'];
						}
						$doc_qty=0;
						$get_dockets="SELECT docket_number FROM $pps.`jm_dockets` WHERE plant_code='$plantcode' AND jm_docket_id IN ('".implode("','" , $jm_docket_id)."') group by docket_number";
						$sql_result3 = mysqli_query($link,$get_dockets) or exit('Error get_dockets');
						while($row3 = mysqli_fetch_array($sql_result3))
						{
							$docket=$row3['docket_number'];
							$dockets[]=$row3['docket_number'];
							//To get docket qty
							$result_doc_qty=getDocketInformation($docket,$plantcode);
							$doc_qty =$result_doc_qty['docket_quantity'];

							//To get rejected and replament qtys
							$get_rejected_qtys="SELECT SUM(rejection_quantity) as rejected, SUM(replaced_quantity) as replacement FROM pts.`rejection_transaction` WHERE plant_code='$plantcode' AND component='$component' AND job_number='$docket' AND job_type='PD'";
							$sql_result4 = mysqli_query($link,$get_rejected_qtys) or exit('Error get_rejected_qtys');
							while($row4 = mysqli_fetch_array($sql_result4))
							{
								$rejected_qty=$row4['rejected'];
								$replacement_qty=$row4['replacement'];
							}
							//To get reported qty
							$get_reported_qty="SELECT SUM(good_quantity) AS quantity FROM $pts.transaction_log WHERE plant_code='$plantcode' AND parent_job ='$docket' AND parent_job_type='PD' AND operation='15'";
							$sql_result5 = mysqli_query($link,$get_reported_qty) or exit('Error get_reported_qty');
							while($row5 = mysqli_fetch_array($sql_result5))
							{
								$reported_qty=$row5['quantity'];
							}
							$remainig_qty=$reported_qty - $replacement_qty;
							echo "<tr><td>$s_no</td>";
							echo "<td>$docket</td>";
							echo "<td>$style</td>";
							echo "<td>$schedule</td>";
							echo "<td>$color</td>";
							echo "<td>$masterpo_des</td>";
							echo "<td>$subpo_des</td>";
							echo "<td>$component</td>";
							echo "<td>$rejected_qty</td>";
							echo "<td>$doc_qty</td>";
							echo "<td>$reported_qty</td>";
							echo "<td>$replacement_qty</td>";
							echo "<td>$remainig_qty</td>";
							echo "<td><button type='button'class='btn btn-primary' onclick=\"viewrecutdetails('$subpo','$component','$plantcode')\">View</button></td>";
							// echo "<td><button type='button'class='btn btn-success' onclick='viewmarkerdetails('".$subpo."','".$component."','".$plantcode."')'>Marker View</button></td>";
							echo "</tr>";
							$s_no++;
						}		
					}
				}
				else
				{
					echo "<tr><td colspan='12' style='color:red;text-align: center;'><b>No Details Found!!!</b></td></tr>";
				}
                ?>
                </table>
            </div>
        </div>
   </div>
<?php
}
?>
<script>
function viewrecutdetails(subpo,component,plantcode)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
	var data_array = [subpo,component,plantcode];
    $('.loading-image').show();
    $('#myModal').modal('toggle');
    $.ajax({

			type: "POST",
			url: function_text+"?recut_doc_id="+data_array,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('main-content').innerHTML = response;
                $('.loading-image').hide();
            }

    });

}
// function viewmarkerdetails(subpo,component,plantcode)
// {
//     $('#myModal1').modal('toggle');
//     var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
//     var data_array = [subpo,component,plantcode];
//     $('.loading-image').show();
//     $.ajax({

// 			type: "POST",
// 			url: function_text+"?markers_view_docket="+data_array,
// 			//dataType: "json",
// 			success: function (response) 
// 			{
//                 document.getElementById('dynamic_table1').innerHTML = response;
//                 $('.loading-image').hide();
               
//             }

//     });

// }
</script>
