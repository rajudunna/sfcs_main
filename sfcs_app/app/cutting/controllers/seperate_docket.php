<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$has_permission=haspermission($_GET['r']);
    $per = 'No';

    $close_url = getFullURLLevel($_GET['r'],'closed_docket.php',0,'R');
    
    $query = "select * from $bai_pro3.binding_consumption where status='Allocated'";
    $sql_result = mysqli_query($link,$query);
    if(mysqli_num_rows($sql_result)>0){
        $count = mysqli_num_rows($sql_result);
    } else {
        $count = 0;
    }

    $table1_rows = 0;
    $table2_rows = 0;
    
?>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<style>
table {	
	text-align:center;
	font-size:12px;
	width:100%;
	padding: 1em 1em 1em 1em;
	color:black;
}
th{
	background-color:#29759c;
	color:white;
	text-align:center;
}
</style>
<div class="panel panel-primary">
    <div class="panel-heading"><b>Binding Allocation Form</b></div>
    <div class="panel-body">
    <div class='pull-right'><span class='label label-info fa fa-list fa-xl' >&nbsp;&nbsp;&nbsp;To Show Binding Items</span></div>
   
        <ul id="rowTab" class="nav nav-tabs">
            
            <li class="active"><a data-toggle="tab" href="#tab_a"><b><span class='label label-default' style='font-size:15px'>Requests</span></b></a></li>
           
            <li><a data-toggle="tab" href="#tab_b"><b><span class='label label-default' style='font-size:15px'>Allocated (<?= $count; ?>)</span></b></a></li>
            <li><a data-toggle="tab" href="#tab_c"><b><span class='label label-default' style='font-size:15px'>Closed</span></b></a></li>
            
            
        </ul>
        
        <div class="tab-content">
            <div id="tab_a" class="tab-pane fade active in">
                <div style='overflow:scroll;' class='table-responsive'>
                    <table id='table1' class='table table-bordered'>
                        <thead>
                        <tr>
                            <th>SNo.</th>
                            <th>Style</th>
                            <th>Schedule</th>
                            <th>Color</th>
                            <th>Total Required Quantity</th>
                            <th>Total Binding Required Quantity</th>
                            <th>Control</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $query = "select * from $bai_pro3.binding_consumption where status='Open'";
                            $sql_result = mysqli_query($link,$query);
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                $table1_rows++;
                                $i = $sql_row['id'];
                                $index+=1;
                                echo "<tr><td data-toggle='modal' data-target='#myModal$i'><input type='hidden' id='row_id-$i' value='$i'><span class='label label-info fa fa-list fa-xl' >&nbsp;&nbsp;&nbsp;$index</span></td>";
                                echo "<td>".$sql_row['style']."</td>";
                                echo "<td>".$sql_row['schedule']."</td>";
                                echo "<td>".$sql_row['color']."</td>";
                                echo "<td>".$sql_row['tot_req_qty']."</td>";
                                echo "<td>".$sql_row['tot_bindreq_qty']."</td>";
                                echo "<td><select name='issue_status$i' id='issue_status-$i' class='select2_single form-control' onchange='IssueAction($i);'>";
                                echo "<option value=''>Please Select</option>";
                                echo "<option value='Allocate'>Allocate</option>";
                                echo "<option value='Reject'>Reject</option>";
                                echo "</select></td>";
                                echo "<td><input type='submit' name='submit$i' id='submit-$i' class='btn btn-info' value='Submit' disabled='disabled' onclick='UpdateDamageStatus($i);'></td>";
                                echo "</tr>";
                            }
                            if($index==0) {
                                
                                echo "<tr><td colspan=8>No Data Found</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tab_b" class="tab-pane fade">
                <div style='overflow:scroll;' class='table-responsive'>
                    <table id='table2' class='table table-bordered'>
                        <tr>
                            <th>SNo.</th>
                            <th>Style</th>
                            <th>Schedule</th>
                            <th>Color</th>
                            <th>Total Required Quantity</th>
                            <th>Total Binding Required Quantity</th>
                            <th>Control</th>
                            <th></th>
                        </tr>
                        <?php   
                                $path = getFullURLLevel($_GET['r'],'lay_plan_preparation/Book3_print_binding.php',0,'R'); 
                             
                                $query = "select * from $bai_pro3.binding_consumption where status='Allocated'";
                                $sql_result = mysqli_query($link,$query);
                                $index=0;
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    $table2_rows++;
                                    $i = $sql_row['id'];
                                    $index+=1;
                                    echo "<tr><td data-toggle='modal' data-target='#myModal$i'><input type='hidden' id='row_id-$i' value='$i'><span class='label label-info fa fa-list fa-xl' >&nbsp;&nbsp;&nbsp;$index</span></td>";
                                    echo "<td>".$sql_row['style']."</td>";
                                    echo "<td>".$sql_row['schedule']."</td>";
                                    echo "<td>".$sql_row['color']."</td>";
                                    echo "<td>".$sql_row['tot_req_qty']."</td>";
                                    echo "<td>".$sql_row['tot_bindreq_qty']."</td>";
                                    echo "<td>".$sql_row['status']."</td>";
                                      
                                    echo "<td><a href=\"$path?binding_id=$i\" onclick=\"Popup1=window.open('$path?binding_id=$i','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-warning btn-xs'><i class='fa fa-print'></i>&nbsp;Print</a></td>";
                                    echo "</tr>";
                                }
                                if($index==0) {
                                    
                                    echo "<tr><td colspan=8>No Data Found!</td></tr>";
                                }
                            ?>
                    </table>
                </div>         
            </div>
            <div id="tab_c" class="tab-pane fade">
                <div class="row">

                </div>
                <br/>
                <div class="row">
                    <div class="col-md-2">
                        <input class="form-control" type="text" data-toggle='datepicker' name="sdat" id="sdate" size=8 placeholder='Select Date' onchange='DateChange();'/>
                    </div>
                    <div class="col-md-1">
                        <input type='buttom' name='submit1' id='submit1' class='btn btn-success' value='Filter' disabled='disabled' onclick='FilterFunction();'>
                    </div>
                </div>
             
                <div style='overflow:scroll;' class='table-responsive' id='closed'>
                    <table id='table3' class='table table-bordered'>
                        <!-- <tr>
                            <th>SNo.</th>
                            <th>Style</th>
                            <th>Schedule</th>
                            <th>Color</th>
                            <th>Total Required Quantity</th>
                            <th>Total Binding Required Quantity</th>
                        </tr> -->
                    </table>
                </div>
                         
            </div>
            
        </div>

  <?php
    $query = "select * from $bai_pro3.binding_consumption";
    $sql_result = mysqli_query($link,$query) or exit('Cant  run');
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $i = $sql_row['id'];
        echo "<div class='modal fade' id='myModal$i' name='myModal$i' role='dialog'>";
        echo "<div class='modal-dialog' style='width: 60%;  height: 100%;'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>Binding Docket Details
                    <button type='button' class='close'  id = 'cancel' data-dismiss='modal'>&times;</button>
                </div>";
        echo "<div class='modal-body'>";
                    $child_query = "select * from $bai_pro3.binding_consumption_items as c LEFT JOIN $bai_pro3.binding_consumption p ON p.id=c.parent_id where parent_id='".$i."'";
                    $child_result = mysqli_query($link,$child_query);
                    // var_dump(mysqli_num_rows($child_result));
                    if(mysqli_num_rows($child_result) > 0){
                        $index = 0;
                        while($child_row=mysqli_fetch_array($child_result))
                        {
                            // var_dump($child_row);
                            
                            $index += 1;
                            if($index == 1) {
                                echo "<div class='row'><div class='col-md-3'><b>Style : </b><span class='label label-info'>$child_row[style]</span></div><div class='col-md-3'><b>Schedule : </b><span class='label label-info'>$child_row[schedule]</span></div><div class='col-md-3'><b>Color : </b><span class='label label-info'>$child_row[color]</span></div></div><br/>";
                                echo "<table class='table table-bordered '>
                                        <thead>
                                            <tr class='primary'>
                                                <th>#</th><th>Component Number</th><th>Docket Number</th><th>Category</th><th>Cut Number</th><th>Required Qty.</th><th>Binding Category</th><th>Binding Required Qty.</th>
                                            </tr>
                                        </thead>
                                <tbody>";
                            }
                            echo "<tr>";
                            echo "<td>".$index."</td>";
                            echo "<td>".$child_row['compo_no']."</td>";
                            echo "<td>".$child_row['doc_no']."</td>";
                            echo "<td>".$child_row['category']."</td>";
                            echo "<td>".$child_row['cutno']."</td>";
                            echo "<td>".$child_row['req_qty']."</td>";
                            echo "<td>".$child_row['bind_category']."</td>";
                            echo "<td>".$child_row['bind_req_qty']."</td>";
                            echo "</tr>";
                        }
                    }
            echo "</tbody>
                    </table>";
            echo "</div>
                </div>
                </div>
        </div>";
    }
    ?>  
        
    </div>
</div>

<script type="text/javascript">
    var table_Props;
    $('document').ready(function(){
        $('#closed').hide();
        $('#reset_table3').addClass('btn btn-warning');
        table_Props = 	{
                                rows_counter: true,
                                btn_reset: true,
                                btn_reset_text: "Clear",
                                loader: true,
                                loader_text: "Filtering data..."
                            };
        <?php if($table1_rows > 1)
            echo 'setFilterGrid( "table1",table_Props );';
        ?>
        setFilterGrid( "table2",table_Props );
        setFilterGrid( "table3",table_Props );
    })
    function IssueAction(i)
    {
        document.getElementById('submit-'+i).disabled = false;
    }
    function UpdateDamageStatus(i) {
        if($('#submit-'+i).val()) {
            var status = $('#issue_status-'+i).val();
            var row_id = i
            //  console.log($_GET['r']);
            if(status=='Allocate') {
                url_path = "<?php echo getFullURLLevel($_GET['r'],'dashboards/controllers/cps/binding_consumption_allocation.php',2,'R'); ?>";
                window.open(url_path+"?doc_no=B"+row_id+"&status="+status);
            } else {
                url_path = "<?php echo getFullURLLevel($_GET['r'],'cutting/controllers/binding_consumption.php',2,'R'); ?>";
                window.open(url_path+"?row_id="+row_id+"&status="+status);
            }
        }
        
    }

    function DateChange() {
        if($('#sdate').val()) {
            document.getElementById('submit1').disabled = false;
        }
    }
    function FilterFunction() {
        if($('#sdate').val()) {
            $('#closed').show();
            $.ajax({
            url  : '<?= $close_url ?>?date='+$('#sdate').val(),
            type : 'GET',
            }).then(function(res){
                $('#table3').html(res);
                setFilterGrid( "table3",table_Props );
            });
        }
        
    }
    </script>
