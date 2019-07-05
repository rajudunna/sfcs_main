<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    $query = "select * from $bai_pro3.binding_consumption where status='Allocated'";
    $sql_result = mysqli_query($link,$query);
    if(mysqli_num_rows($sql_result)>0){
        $count = mysqli_num_rows($sql_result);
    } else {
        $count = 0;
    }
    
?>
<div class="panel panel-primary">
    <div class="panel-heading"><b>Binding Allocation Form</b></div>
    <div class="panel-body">
        <ul id="rowTab" class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab_a"><b>Requests</b></a></li>
            <li><a data-toggle="tab" href="#tab_b"><b>Allocated (<?= $count; ?>)</b></a></li>
        </ul>

        <div class="tab-content">
            <div id="tab_a" class="tab-pane fade active in">
                <div style='overflow:scroll;' class='table-responsive'>
                    <table id='table1' class='table table-bordered'>
                        <tr>
                            <th>SNo.</th>
                            <th>Style</th>
                            <th>Schedule</th>
                            <th>Color</th>
                            <th>Total Required Quantity</th>
                            <th>Total Binding Required Quantity</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        <?php
                            $query = "select * from $bai_pro3.binding_consumption where status='Open'";
                            $sql_result = mysqli_query($link,$query);
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                $i = $sql_row['id'];
                                $index+=1;
                                echo "<tr><td data-toggle='modal' data-target='#myModal$i'><input type='hidden' id='row_id-$i' value='$i'>$index</td>";
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
                        ?>
                    </table>
                </div>
            </div>
            <div id="tab_b" class="tab-pane fade">
                <div style='overflow:scroll;' class='table-responsive'>
                    <table id='table1' class='table table-bordered'>
                        <tr>
                            <th>SNo.</th>
                            <th>Style</th>
                            <th>Schedule</th>
                            <th>Color</th>
                            <th>Total Required Quantity</th>
                            <th>Total Binding Required Quantity</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        <?php   
                                $path = getFullURLLevel($_GET['r'],'lay_plan_preparation/Book3_print_binding.php',0,'R'); 
                             
                                $query = "select * from $bai_pro3.binding_consumption where status='Allocated'";
                                $sql_result = mysqli_query($link,$query);
                                $index=0;
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    $i = $sql_row['id'];
                                    $index+=1;
                                    echo "<tr><td data-toggle='modal' data-target='#myModal$i'><input type='hidden' id='row_id-$i' value='$i'>$index</td>";
                                    echo "<td>".$sql_row['style']."</td>";
                                    echo "<td>".$sql_row['schedule']."</td>";
                                    echo "<td>".$sql_row['color']."</td>";
                                    echo "<td>".$sql_row['tot_req_qty']."</td>";
                                    echo "<td>".$sql_row['tot_bindreq_qty']."</td>";
                                    echo "<td>".$sql_row['status']."</td>";
                                      
                                    echo "<td><a href=\"$path?binding_id=$i\" onclick=\"Popup1=window.open('$path?binding_id=$i','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-warning btn-xs'><i class='fa fa-print'></i>&nbsp;Print</a></td>";
                                    echo "</tr>";
                                }
                            
                            ?>
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
                                echo "<div class='row'><div class='col-md-3'><b>Style :</b>$child_row[style]</div><div class='col-md-3'><b>Schedule:</b>$child_row[schedule]</div><div class='col-md-3'><b>Color:</b>$child_row[color]</div></div><br/>";
                                echo "<table class='table table-bordered '>
                                        <thead>
                                            <tr class='danger'>
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
    $(document).ready(function(){
    });

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
            
            // $.ajax({
            //     type: "POST",
            //     url: url_path+"?doc_no=B"+row_id+"&status="+status,
            //     dataType: "json",
            //     success: function (response) 
            //     {
            //         console.log(response);
                   
            //         // var url1 = ' //getFullURL($_GET['r'],'seperate_docket.php','N'); ';
            //         // window.location.href = url1;
            //     }
            // });
        }
        
    }
    </script>
