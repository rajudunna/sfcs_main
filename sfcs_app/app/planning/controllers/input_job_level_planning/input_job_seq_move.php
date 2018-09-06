<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));

   
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.0em; border-radius: 15px;}
  #sortable li span { position: absolute; margin-left: -1.3em; margin-top:0px;}
</style>
<script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
<div class="panel panel-primary">
    <div class="panel-heading">Input Job Sequence Change</div>
    <div class="panel-body">
        <form action="<?= getFULLURL($_GET['r'],'input_job_seq_move.php','N');?>" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <label>Module</label>
                    <select class='form-control' name="module">
                        <option value='NIL'>Select Module</option>
                        <?php  
                            $sql = "SELECT * FROM $bai_pro3.module_master";
                            $sql_result = mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

                            while($sql_row=mysqli_fetch_array($sql_result)){
                                echo "<option value='".$sql_row['module_name']."'>".$sql_row['module_name']."</option>";

                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="submit" name="submit" value="view" class="btn btn-primary" style="margin-top:20px;">
                </div>
            </div>
        </form>

        <?php
            if($_POST['submit']){
                echo "<hr>";
                $module= $_POST['module'];
                $sql1 = "SELECT * FROM $bai_pro3.plan_dashboard_input LEFT JOIN $bai_pro3.packing_summary_input ON plan_dashboard_input.input_job_no_random_ref = packing_summary_input.input_job_no_random where input_module=\"$module\" GROUP BY input_job_no_random_ref ORDER BY order_del_no AND acutno";
                $sql_result1 = mysqli_query($link, $sql1) or exit("Sql1 Error".mysqli_error($GLOBALS["___mysqli_ston"]));

                echo "<h3><span class='label label-success'>Selected Module : ". $module."</span></h3>";
                echo '<div class="row"><div class="col-md-4" style="max-height:270px;overflow-y:auto">
                
                <ul id="sortable">';
                $input_jobs = array();
                $no_of_jobs = mysqli_num_rows($sql_result1);
                while($sql_row1 = mysqli_fetch_array($sql_result1)){
                   
                    $schedule1 = $sql_row1['order_del_no'];
                    $color1 = $sql_row1['order_color_des'];
                    $cut_no1 = $sql_row1['acutno'];
                    $style_id_new = $sql_row1['order_style_no'];
                    $doc_no = $sql_row1['doc_no'];
                    $input_priority = $sql_row1['input_priority'];
                    if($style_id_new !== NULL){
                        $input_jobs[] = $sql_row1['input_job_no_random_ref'];
                    }
                    
                    $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row1['order_del_no'],$sql_row1['order_color_des'], $cut_no1,$link);
                    // var_dump( $display_prefix1);
                    $bg_color1 = get_sewing_job_prefix("bg_color","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$sql_row1['order_del_no'],$sql_row1['order_color_des'], $cut_no1,$link);
                    // var_dump( $bg_color1);

                    $title=str_pad("Style:".$style_id_new,80)."\n".str_pad("Schedule:".$schedule1,80)."\n".str_pad("Job No:".$display_prefix1,80);

                    if($bg_color1 == 'white'){
                        echo '<li class="ui-state-default" id="'.$input_priority.'"  style="background-color:red;" data-color="red" title="'.$title.'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><strong><font color="black">'.$display_prefix1."(".$style_id_new.')</font></strong></li>';
                    }else if($bg_color1 == 'yellow'){
                        echo '<li class="ui-state-default" id="'.$input_priority.'"  style="background-color:white;border: 4px solid yellow;" data-color="red" title="'.$title.'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><strong><font color="red">'.$display_prefix1."(".$style_id_new.')</font></strong></li>';
                    }else{
                        if($style_id_new !== NULL){
                            echo '<li class="ui-state-default" id="'.$input_priority.'"  style="background-color:'.$bg_color1.';" data-color = '.$bg_color1.' title="'.$title.'" ><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><strong><font color="red">'.$display_prefix1."(".$style_id_new.')</font></strong></li>';
                        }
                        
                    }	

                }
                echo '</ul></div></div>';
                echo "<br><br>";
                if($no_of_jobs > 0){
                    echo "<input type='button' value='Save Sequence' onclick='saveOrder();' class='btn btn-success btn-sm' id='button_disabled'/>";
                }else{
                    echo "<div class='alert alert-danger'>No Jobs found for this Module <strong>".$module."</strong></div>";
                }
               
            }
            
        ?>
            
    </div>
</div>
<script>
function saveOrder() {
    var input_jobs = '<?= json_encode($input_jobs);?>';
    var url = '<?= getFullURL($_GET['r'],'input_job_seq_update.php','R');?>';
    var redirection_url = '<?= getFullURL($_GET['r'],'input_job_seq_move.php','N');?>';
    console.log(input_jobs);
    var jobsorder = "";
    $("#sortable li").each(function(i) {
        if (jobsorder == '')
            jobsorder = $(this).attr('id');
        else
            jobsorder += "," + $(this).attr('id');
    });
    console.log(jobsorder);
    $('#button_disabled').prop('disabled', true);
    $.ajax({
        data: {'input_jobs': input_jobs, 'jobsorder': jobsorder},
        type: 'POST',
        url: url,
        success: function(response){
            swal('Jobs Sequence Changed','','success');
            // window.location = redirection_url;
        }
    });  
    $('#button_disabled').prop('disabled', false);   
    
}
</script>