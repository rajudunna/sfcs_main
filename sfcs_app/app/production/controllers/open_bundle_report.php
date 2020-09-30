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
                                                $openbundle_sql="SELECT bundle_number FROM `$pts`.`transaction_log` WHERE style='".$style."' AND schedule='".$schedule."' and operation IN ($opcodes) and plant_code='$plant_code' order BY bundle_number";
												// echo $openbundle_sql;
												$select_bundlenum=mysqli_query($link,$openbundle_sql) or exit($openbundle_sql."Error at something");
                                                $operation_bundles=array();$bundle_qty_stats_bundles = array();
                                                while($row_2 = mysqli_fetch_assoc( $select_bundlenum)){
													// if($row_2['bundle_qty_status'] == 0)
													// {
													// 	$bundle_qty_stats_bundles[] =  $row_2['bundle_number'];
													// }									
                                                    $operation_bundles[]=$row_2['bundle_number'];
                                                }
												// $bundle_qty_stats_bundle_nums=implode(',',$bundle_qty_stats_bundles);
                                                $bundle_nums=implode(',',$operation_bundles);
												if(sizeof($operation_bundles)>0)
                                                {
                                                    // if(sizeof($bundle_qty_stats_bundles)>0)
													// {
                                                        $selectSQL = "SELECT sewing_job_number,original_qty,bundle_number,size,color,rejected_quantity,good_quantity,operation FROM `$pts`.`transaction_log` WHERE style='".$style."' AND schedule='".$schedule."' AND operation IN ($opcodes) AND bundle_number IN ($bundle_nums) order by sewing_job_number*1,bundle_number";
                                                        $selectRes=mysqli_query($link,$selectSQL) or exit($selectSQL."Error at something");
                                                        while( $row = mysqli_fetch_assoc( $selectRes ))
                                                        {                                                    
                                                            $data_array_rec[$row['bundle_number']][$row['operation']] = $row['good_quantity'];
                                                            $data_array_rej[$row['bundle_number']][$row['operation']] = $row['rejected_quantity'];
                                                            $data_array_recut[$row['bundle_number']][$row['operation']] = $row['recut_in'];
                                                            $data_array_col[$row['bundle_number']] = $row['color'];
                                                            $data_array_size[$row['bundle_number']] = $row['size'];
                                                            $data_array_input[$row['bundle_number']] = $row['sewing_job_number'];
                                                            $tot_bundles[] = $row['bundle_number'];
                                                            $data_array_qty[$row['bundle_number']] = $row['original_qty'];
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
                                                    for($i=0;$i<sizeof($tot_bundles);$i++)
                                                    {                                     
                                                       echo "<tr><td>{$schedule}</td><td>{$data_array_input[$tot_bundles[$i]]}</td><td>{$data_array_col[$tot_bundles[$i]]}</td><td>{$data_array_size[$tot_bundles[$i]]}</td><td>{$data_array_qty[$tot_bundles[$i]]}</td>
                                                        <td>{$tot_bundles[$i]}</td>";
                                                        for ($ii=0; $ii< count($operation_codes); $ii++) 
                                                        {
                                                            if($data_array_rec[$tot_bundles[$i]][$operation_codes[$ii]]==0){
                                                                echo "<td>--</td>";
                                                            }else{
                                                                 echo "<td>".$data_array_rec[$tot_bundles[$i]][$operation_codes[$ii]]."</td>";
                                                            }
                                                            if($data_array_rej[$tot_bundles[$i]][$operation_codes[$ii]]==0){
                                                                echo "<td>--</td>";
                                                            }else{
                                                                echo "<td>".$data_array_rej[$tot_bundles[$i]][$operation_codes[$ii]]."</td>";
                                                            }
                                                            if(($data_array_rej[$tot_bundles[$i]][$operation_codes[$ii]]-$data_array_recut[$tot_bundles[$i]][$operation_codes[$ii]])==0){
                                                                echo "<td>--</td>";
                                                            }else{
                                                                echo "<td>".($data_array_rej[$tot_bundles[$i]][$operation_codes[$ii]]-$data_array_recut[$tot_bundles[$i]][$operation_codes[$ii]])."</td>";
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
