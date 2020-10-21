<html>
<head>
<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    $plant_code=$_SESSION['plantCode'];
    $username=$_SESSION['userName'];
	if(isset($_POST['style']))
	{
		$style=$_POST['style'];
		$schedule=$_POST['schedule'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
    }
    $sew_in_op=100;
	$sew_out_op=130;
?>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/openbundle_report.min.js',3,'R'); ?>"></script>
<style>
td ,th {
text-align: center;
}

</style>
<script>
$(document).ready(function() {
    $('#myTable').DataTable( { 
        paging:false,
        "bSort": false,
        "dom": '<"top"iflp<"clear">>rt',
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.header()) )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );    
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                    
                } );
                
            } );
        }
    } );
} );




</script>
<script language="javascript" type="text/javascript">
function firstbox()
	{
		var url1 = '<?= getFullUrl($_GET['r'],'open_bundle_report.php','N'); ?>';
		window.location.href =url1+"&style="+document.test.style.value;
	}
function check_val()
	{
		var style=document.getElementById("style").value;
		var schedule=document.getElementById("schedule").value;
		
		if(style=='NIL' || schedule=='NIL')
		{
			sweetAlert('Please Select the Values','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
    </script>
    
</head>
<body>
    <div class='panel panel-primary'>
	    <div class="panel-heading">
		    <b>Open bundle Report</b>
	    </div>
    	<div class="panel-body">
		    <form method="post" name="test" action="#">
                    
                    <div class="col-sm-2 form-group">
                    <label for='style'>Select Style</label>
                           <?php
							// Style
							echo "<select name=\"style\" id=\"style\"  class='form-control' onchange=\"firstbox();\">";
							$sql="select style from $pts.transaction_log  where plant_code='$plant_code' and style!=''  group by style";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check=mysqli_num_rows($sql_result);
							echo "<option value=\"NIL\" selected>Select Style</option>";
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								if(str_replace(" ","",$sql_row['style'])==str_replace(" ","",$style))
								{
									echo "<option value=\"".$sql_row['style']."\" selected>".$sql_row['style']."</option>";
								}
								else
								{
									echo "<option value=\"".$sql_row['style']."\">".$sql_row['style']."</option>";
								}
							}
							echo "</select>";
						?>
                    </div>
                    <div class="col-sm-2 form-group">
                    <label for='schedule'>Select Schedule</label>
						<?php
							echo "<select class='form-control' name='schedule' id='schedule'>";
                            $sql="select  schedule from $pts.transaction_log where style=\"$style\" group by schedule";
                            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $sql_num_check=mysqli_num_rows($sql_result);
                            echo "<option value=\"NIL\" selected>Select Schedule</option>";
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                if(str_replace(" ","",$sql_row['schedule'])==str_replace(" ","",$schedule))
                                {
                                    echo "<option value=\"".$sql_row['schedule']."\" selected>".$sql_row['schedule']."</option>";
                                }
                                else
                                {
                                    echo "<option value=\"".$sql_row['schedule']."\">".$sql_row['schedule']."</option>";
                                }
                            }
                            echo "</select>";
							?>
                      
                        </select>
                    </div>	
                    </br>
                    <div class="col-sm-2 form-group">
                        <?php
                          echo "<input class='btn btn-success' type=\"submit\" value=\"Submit\" name=\"submit\" id=\"submit_data\">";
                        ?>
                    </div> 
	         </form>
      </div>
    </div>
        <?php 
          if(isset($_POST['submit']))
          {
                //$schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$_POST['schedule'],$link);
                //$style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$_POST['style'],$link);
                
                ?>
                <div class='row'>
                     <div class='panel panel-primary'>
                          <div class='panel-heading'>
                             <b>All Open Bundles</b>
                            </div>
                            <div class='panel-body' style="overflow: scroll;height: 616px;">
                                            <?php 
                                               $operation="select operation_category,operation_code,operation_name from $pms.operation_mapping where plant_code='$plant_code' and operation_category='SEWING'";
                                               $operation_result=mysqli_query($link,$operation) or exit($operation."Error at something");
                                               while( $row_12 = mysqli_fetch_assoc( $operation_result ) ){
                                                   $operation_codes[]=$row_12['operation_code'];
                                               }
                                               $opcodes=implode(',',$operation_codes);
                                               if($style!='NIL' && $style!='' && $schedule!='NIL' && $schedule!=''){
                                               $sql_operation="SELECT operation from $pts.transaction_log  WHERE style='".$style."' and schedule='".$schedule."' and operation in($opcodes) and plant_code='$plant_code' GROUP BY operation";
                                               }
                                               else{
                                                $sql_operation="SELECT operation from $pts.transaction_log  WHERE style='".$style."' and schedule='".$schedule."' and operation in('') and plant_code='$plant_code' GROUP BY operation";   
                                               } 
                                                // echo "</br>SQL Operation : ".$sql_operation."</br>";       
                                               $select_opertation=mysqli_query($link,$sql_operation) or exit($sql_operation."Error at something");
                                                //echo "</br>SQL Operation : ".$sql_operation."</br>";       
                                             
                                                    if( mysqli_num_rows( $select_opertation )==0)
                                                    {
                                                     echo '<div><h1><b>No Data Found.....!</b></h1></div>';
													 exit();
                                                    }
                                                    else
                                                    {
														echo '<table style="padding:0px" class = "col-sm-12 table-bordered table-striped table-condensed" id="myTable">
																<thead>
																	<tr>
																		<th rowspan="2">Schedule</th>
																		<th rowspan="2">Sewing Job</th>
																		<th rowspan="2">Color</th>
																		<th rowspan="2">Size</th>
																		<th rowspan="2">Quantity</th>
																		<th rowspan="2">Bundle Number</th>';
                                                        $ab="";
                                                        $operation_codes=array();
                                                        while( $row_1 = mysqli_fetch_assoc( $select_opertation ) ){
                                                                $operation_codes[]=$row_1['operation'];
                                                                $operation_codes1=$row_1['operation'];
                                                                $sql_operation1="SELECT operation_name from $pms.operation_mapping  WHERE operation_code='".$operation_codes1."'  and plant_code='$plant_code' "; 
                                                                //echo "</br>SQL Operation : ".$sql_operation."</br>";       
                                                                $select_opertation1=mysqli_query($link,$sql_operation1) or exit($sql_operation1."Error at something");
                                                                while( $row_111 = mysqli_fetch_assoc( $select_opertation1 ) ){

                                                                    $operation_name=$row_111['operation_name'];
                                                                }
                                                                echo "<th colspan='3' >".$operation_name."</th>";
                                                                $ab.="<th>Good Quantity</th>
                                                                <th>Rejected Quantity</th>
                                                                <th>Pending Recutin</th>";
                                                        }
                                                        echo "</tr><tr>".$ab."</tr></thead>";
                                                        $opcodes=implode(',',$operation_codes);
                                                        //   echo $opcodes;
                                                    }
                                             ?>
                                         <?php  

                                         $get_color="SELECT fg_color FROM `$pps`.`jm_product_logical_bundle` WHERE feature_value='$schedule' and plant_code='$plant_code'";
                                         $get_color_result=mysqli_query($link,$get_color) or exit($get_color_result."Error at something");
                                         while($row_21 = mysqli_fetch_assoc( $get_color_result)){

                                        $color =  $row_21['fg_color'];
                                         }
                                                $openbundle_sql="SELECT jm_pplb_id FROM `$pps`.`jm_job_bundles` WHERE fg_color='".$color."' AND  plant_code='$plant_code' ";
												// echo $openbundle_sql;
												$select_bundlenum=mysqli_query($link,$openbundle_sql) or exit($openbundle_sql."Error at something");
                                                $operation_bundles=array();$bundle_qty_stats_bundles = array();
                                                while($row_2 = mysqli_fetch_assoc( $select_bundlenum)){
													// if($row_2['bundle_qty_status'] == 0)
													// {
													// 	$bundle_qty_stats_bundles[] =  $row_2['bundle_number'];
													// }									
                                                    $pplb_id[]=$row_2['jm_pplb_id'];
                                                }
                                                $pplb="'".implode("','",$pplb_id)."'";
												// $bundle_qty_stats_bundle_nums=implode(',',$bundle_qty_stats_bundles);
                                                // $pplb_id_id=implode(',',$pplb_id);
                                                $bundle_sql="SELECT barcode FROM `$pts`.`barcode` WHERE external_ref_id in($pplb) AND  plant_code='$plant_code' ";
												// echo $bundle_sql;
												$bundle_sql_result=mysqli_query($link,$bundle_sql) or exit($bundle_sql_result."Error at something");
                                                while($row_23 = mysqli_fetch_assoc( $bundle_sql_result)){
                                                    $barcode[]=$row_23['barcode'];
                                                }
                                                $operation_bundles=implode(',',$barcode);
												if(sizeof($operation_bundles)>0)
                                                {
                                                    // if(sizeof($bundle_qty_stats_bundles)>0)
													// {

                                                        // $query="SELECT SUM(IF(operation=$sew_in_op,1,0)) AS sew_in,SUM(IF(operation=$sew_out_op,1,0)) AS sew_out from $pts."
                                                       
                                                        $selectSQL = "SELECT parent_job,parent_barcode,size,color,sum(rejected_quantity) as rejected_quantity,sum(good_quantity) as good_quantity,sum(if(operation=".$sew_in_op.",good_quantity+rejected_quantity,0)) as total_good_quantity,sum(if(operation=".$sew_out_op.",good_quantity+rejected_quantity,0)) as total_quantity,operation,schedule FROM `$pts`.`transaction_log` WHERE style='".$style."' AND schedule='".$schedule."'  AND parent_barcode IN ($operation_bundles)  group by parent_barcode,operation";
                                                           
                                                        $selectRes=mysqli_query($link,$selectSQL) or exit($selectSQL."Error at something");
                                                        while( $row = mysqli_fetch_assoc( $selectRes ))
                                                        {          
                                                            
                                                            
                                                            $data_array_rec[$row['parent_barcode']][$row['operation']] = $row['good_quantity'];
                                                            $data_array_rej[$row['parent_barcode']][$row['operation']] = $row['rejected_quantity'];
                                                            $data_array_recut[$row['parent_barcode']][$row['operation']] = $row['recut_in'];
                                                            $data_array_col[$row['parent_barcode']] = $row['color'];
                                                            $data_array_size[$row['parent_barcode']] = $row['size'];
                                                            $data_array_input[$row['parent_barcode']] = $row['parent_job'];
                                                            $tot_bundles[] = $row['parent_barcode'];
                                                            $data_array_total_good_quantity[$row['parent_barcode']]=$row['total_good_quantity'];
                                                            $data_array_total_quantity[$row['parent_barcode']]=$row['total_quantity'];

                                                            
                                                            // $data_array_qty[$row['parent_barcode']] = $row['original_qty'];
                                                        }
													
													//}
													
                                                        // $pack_bundles111="SELECT * FROM `bai_pro3`.`packing_summary_input` WHERE tid not in ($bundle_nums) and order_del_no='".$schedule."'";
                                                        // //echo "PAcking summary :".$pack_bundles111."</br>"; 
                                                        // $pack_bundles12=mysqli_query($link,$pack_bundles111) or exit($pack_bundles."Error at something");
                                                        // if(mysqli_num_rows($pack_bundles12)>0)
                                                        // {
                                                        //     while($row_2112 = mysqli_fetch_assoc( $pack_bundles12)){
                                                        //     $data_array_input[$row_2112['tid']] = $row_2112['input_job_no'];
                                                        //     $data_array_col[$row_2112['tid']] = $row_2112['order_col_des'];
                                                        //     $data_array_size[$row_2112['tid']] = $row_2112['size_code'];
                                                        //     $data_array_qty[$row_2112['tid']] = $row_2112['carton_act_qty'];
                                                        //     $tot_bundles[]=$row_2112['tid'];
                                                        //     }
                                                        // }
                                                    $tot_bundles=array_values(array_unique($tot_bundles));
                                                    for($i=0;$i<sizeof($barcode);$i++)
                                                    {  
                                                        
                                                        if($data_array_total_good_quantity[$barcode[$i]]== $data_array_total_quantity[$barcode[$i]] or $data_array_total_good_quantity[$barcode[$i]]>0 ){
                                                        $quantity_query="select external_ref_id from $pts.barcode WHERE  barcode='".$barcode[$i]."' and plant_code='$plant_code'";
                                                            
                                                            $selectRes1=mysqli_query($link,$quantity_query) or exit($quantity_query."Error at something");
                                                            while( $row1 = mysqli_fetch_assoc( $selectRes1 ))
                                                            {    
                                                                $external_ref_id=$row1['external_ref_id'];

                                                                $quantity_query1="select size,quantity,jm_jg_header_id from $pps.jm_job_bundles WHERE  jm_pplb_id='".$external_ref_id."' and plant_code='$plant_code'";
                                                            
                                                                $selectRes11=mysqli_query($link,$quantity_query1) or exit($quantity_query1."Error at something");
                                                                while( $row11 = mysqli_fetch_assoc( $selectRes11 ))
                                                                {    
                                                                    $quantity=$row11['quantity'];
                                                                    $size=$row11['size'];
                                                                    $jm_jg_header_id=$row11['jm_jg_header_id'];
                                                                }
                                                                $quantity_query111="select job_number from $pps.jm_jg_header WHERE  jm_jg_header_id='".$jm_jg_header_id."' and plant_code='$plant_code'";
                                                                $selectRes111=mysqli_query($link,$quantity_query111) or exit($quantity_query111."Error at something");
                                                                while( $row111 = mysqli_fetch_assoc( $selectRes111 ))
                                                                {   
                                                                    $job_number=$row111['job_number'];
                                                                }




                                                            }
                                                           // echo $data_array_total_good_quantity[$barcode[$i]];
                                                    //    if($data_array_total_good_quantity[$barcode[$i]]!= $data_array_total_quantity[$barcode[$i]]){
                                                       echo "<tr><td>{$schedule}</td><td>{$job_number}</td><td>{$color}</td><td>{$size}</td><td>$quantity</td>
                                                        <td>{$barcode[$i]}</td>";
                                                        for ($ii=0; $ii< count($operation_codes); $ii++) 
                                                        {
                                                            if($data_array_rec[$barcode[$i]][$operation_codes[$ii]]==0){
                                                                echo "<td>--</td>";
                                                            }else{
                                                                 echo "<td>".$data_array_rec[$barcode[$i]][$operation_codes[$ii]]."</td>";
                                                            }
                                                            if($data_array_rej[$barcode[$i]][$operation_codes[$ii]]==0){
                                                                echo "<td>--</td>";
                                                            }else{
                                                                echo "<td>".$data_array_rej[$barcode[$i]][$operation_codes[$ii]]."</td>";
                                                            }
                                                            if(($data_array_rej[$barcode[$i]][$operation_codes[$ii]]-$data_array_recut[$barcode[$i]][$operation_codes[$ii]])==0){
                                                                echo "<td>--</td>";
                                                            }else{
                                                                echo "<td>".($data_array_rej[$barcode[$i]][$operation_codes[$ii]]-$data_array_recut[$barcode[$i]][$operation_codes[$ii]])."</td>";
                                                            }
                                                        }
                                                     }
                                                    }
                                                }
                                            
                                           ?>
                                    
                                </table>
                             </div>
                        </div>
                            <?php
                             }
                            ?>
                            
<script>

	var table3Filters = {
	rows_counter: true,
	rows_counter_text: "Total rows: ",
	btn_reset: true,
    sort_select: true,

	display_all_text: "Display all"
	}
	setFilterGrid("myTable",table3Filters);
	$('#reset_myTable').addClass('btn btn-warning btn-xs');
	$('select.required').change(function() {
  var total = $('select.required').length;
  var selected = $('select.required option:selected').length;

  $('#submit_data').attr('disabled', (selected == total));
});
</script>
</body>
</html>
