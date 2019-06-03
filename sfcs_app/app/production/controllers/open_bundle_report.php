<html>
<head>
<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
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
							$sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
							$sql_num_check=mysqli_num_rows($sql_result);
							echo "<option value=\"NIL\" selected>Select Style</option>";
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
								{
									echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
								}
								else
								{
									echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
								}
							}
							echo "</select>";
						?>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label for='schedule'>Select Schedule</label>
						<?php
							echo "<select class='form-control' name='schedule' id='schedule'>";
                            $sql="select id,product_schedule as schedule from $brandix_bts.tbl_orders_master where ref_product_style=\"$style\" group by schedule";
                            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $sql_num_check=mysqli_num_rows($sql_result);
                            echo "<option value=\"NIL\" selected>Select Schedule</option>";
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
                                {
                                    echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['schedule']."</option>";
                                }
                                else
                                {
                                    echo "<option value=\"".$sql_row['id']."\">".$sql_row['schedule']."</option>";
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
                $schedule = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$_POST['schedule'],$link);
                $style = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$_POST['style'],$link);
                
                ?>
                <div class='row'>
                     <div class='panel panel-primary'>
                          <div class='panel-heading'>
                             <b>All Open Bundles</b>
                            </div>
                            <div class='panel-body' style="overflow: scroll;height: 616px;">
                                <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'>
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Schedule</th>
                                            <th rowspan="2">Sewing Job</th>
                                            <th rowspan="2">Color</th>
                                            <th rowspan="2">Size</th>
                                            <th rowspan="2">Quantity</th>
                                            <th rowspan="2">Bundle Number</th>
                                            <?php 
                                                $sql_operation="SELECT tor.operation_name AS operation_name,tor.operation_code AS operation_code FROM brandix_bts.tbl_style_ops_master tsm LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='".$style."' AND tsm.barcode='Yes' AND tor.category = 'sewing' AND tor.display_operations='yes' GROUP BY operation_code ORDER BY tsm.operation_order*1;"; 
                                                            
                                                $select_opertation=mysqli_query($link,$sql_operation) or exit($sql_operation."Error at something");
                                                    if( mysqli_num_rows( $select_opertation )==0 )
                                                    {
                                                     echo '<div>No Data Found.....!</div>';
                                                    }else{ 
                                                    $ab="";
                                                    $operation_codes=array();
                                                        while( $row_1 = mysqli_fetch_assoc( $select_opertation ) ){
                                                                $operation_codes[]=$row_1['operation_code'];
                                                                echo "<th colspan='3' >".$row_1['operation_name']."</th>";
                                                                $ab.="<th>Good Quantity</th>
                                                                <th>Rejected Quantity</th>
                                                                <th>Pending Recutin</th>";
                                                        }
                                                          echo "</tr><tr>".$ab."</tr>";
                                                          $opcodes=implode(',',$operation_codes);
                                                        //   echo $opcodes;
                                                 }
                                             ?>
                                         </tr>
                                    </thead>
                                         <?php  
                                                $openbundle_sql="SELECT bundle_number FROM `brandix_bts`.`bundle_creation_data` WHERE style='".$style."' AND schedule='".$schedule."' AND original_qty <> recevied_qty AND operation_id='130' GROUP BY bundle_number"; 
                                                $select_bundlenum=mysqli_query($link,$openbundle_sql) or exit($openbundle_sql."Error at something");
                                                $operation_bundles=array();
                                                 while($row_2 = mysqli_fetch_assoc( $select_bundlenum)){
                                                    $operation_bundles[]=$row_2['bundle_number'];
                                                 }
                                                 $bundle_nums=implode(',',$operation_bundles);
												if(sizeof($operation_bundles)>0)
                                                {
                                                    $selectSQL = "SELECT input_job_no,original_qty,bundle_number,size_title,color,recut_in,rejected_qty,recevied_qty,operation_id FROM `brandix_bts`.`bundle_creation_data` WHERE style='".$style."' AND schedule='".$schedule."' AND operation_id IN ($opcodes) AND bundle_number IN ($bundle_nums) order by input_job_no*1,bundle_number";
                                                    $selectRes=mysqli_query($link,$selectSQL) or exit($selectSQL."Error at something");
                                                    while( $row = mysqli_fetch_assoc( $selectRes ))
                                                    {                                                    
                                                        $data_array_rec[$row['bundle_number']][$row['operation_id']] = $row['recevied_qty'];
                                                        $data_array_rej[$row['bundle_number']][$row['operation_id']] = $row['rejected_qty'];
                                                        $data_array_recut[$row['bundle_number']][$row['operation_id']] = $row['recut_in'];
                                                        $data_array_col[$row['bundle_number']] = $row['color'];
                                                        $data_array_size[$row['bundle_number']] = $row['size_title'];
                                                        $data_array_input[$row['bundle_number']] = $row['input_job_no'];
                                                        $tot_bundles[] = $row['bundle_number'];
                                                        $data_array_qty[$row['bundle_number']] = $row['original_qty'];
                                                    }
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
