<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));

   
?>
<link rel="stylesheet" href="../../common/css/jquery-ui.css">
<script src="../../common/js/jquery-1.3.2.js"></script>
<script src="../../common/js/jquery-ui.js"></script>
<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.0em; border-radius: 15px;}
  #sortable li span { position: absolute; margin-left: -1.3em; margin-top:0px;}
</style>
<script>
    $( function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
    });

    function saveDragDropNodes()
    {
        var saveString = "";
        var module = $('#sortable li').parent().attr('module');
       
        $("#sortable li").each(function(i) {
            if(saveString.length>0)saveString = saveString + ";";
            saveString = saveString + module + '|' + $(this).attr('id');
        });
        
        
        document.forms['myForm'].listOfItems.value = saveString;
        document.forms["myForm"].submit();
    }

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
                            $sql = "SELECT * FROM $bai_pro3.plan_modules";
                            $sql_result = mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

                            while($sql_row=mysqli_fetch_array($sql_result)){
                                echo "<option value='".$sql_row['module_id']."'>".$sql_row['module_id']."</option>";

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

                $temp_table_name="temp_pool_db.plan_dash_doc_summ_input_".$username;

                $sql="DROP TABLE IF EXISTS $temp_table_name";
                // echo $sql."<br/>";
                mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                $sql="CREATE  TABLE $temp_table_name ENGINE = MYISAM SELECT act_cut_status,doc_no,order_style_no,order_del_no,order_col_des,carton_act_qty as total,input_job_no as acutno,group_concat(distinct char(color_code)) as color_code,input_job_no,input_job_no_random_ref,input_module from $bai_pro3.plan_dash_doc_summ_input where (input_trims_status!=4 or input_trims_status IS NULL or input_panel_status!=2 or input_panel_status IS NULL) GROUP BY input_job_no_random_ref order by input_priority";
                mysqli_query($link, $sql) or exit("$sql Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));

                $module= $_POST['module'];

                $sql1="SELECT * from $temp_table_name where input_module='$module'";

                $sql_result1=mysqli_query($link, $sql1) or exit("$sql1 Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $sql_num_check=mysqli_num_rows($sql_result1);
                    
                echo "<h3><span class='label label-success'>Selected Module : ". $module."</span></h3>";
                echo '<form action="'.getFullURLLevel($_GET['r'],'input_job_seq_update.php',0,'N').'" method="post" name="myForm">';
                echo '<div class="row"><div class="col-md-4">';
                echo '<ul id="sortable" module="'.$module.'">';
                $input_jobs = array();
                $no_of_jobs = mysqli_num_rows($sql_result1);
                while($sql_row1=mysqli_fetch_array($sql_result1))
                {
                    $type_of_sewing=$sql_row1['type_of_sewing'];
                    $doc_no_ref=$sql_row1['doc_no'];
                    $doc_no=$sql_row1["input_job_no_random_ref"];						
                    $style1=$sql_row1['order_style_no'];
                    $schedule1=$sql_row1['order_del_no'];
                    $color1=$sql_row1['order_col_des'];
                    $total_qty1=$sql_row1['total'];
                    $cut_no1=$sql_row1['acutno'];
                    $color_code1=$sql_row1['color_code'];
                    
                    $input_priority=$sql_row1['input_priority'];

                    $sql_style_id="SELECT DISTINCT style_id as sid FROM $bai_pro3.BAI_ORDERS_DB_CONFIRM WHERE order_STYLE_NO=\"$style1\" and order_del_no=\"$schedule1\" LIMIT 1";
                    $sql_result_id=mysqli_query($link, $sql_style_id) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row_id=mysqli_fetch_array($sql_result_id))
                    {
                        $style_id_new=$sql_row_id["sid"];
                    }
                        
                    $get_fab_req_details="SELECT * FROM $bai_pro3.fabric_priorities WHERE doc_ref_club=\"$doc_no_ref\" ";
                    $get_fab_req_result=mysqli_query($link, $get_fab_req_details) or exit("getting fabric details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $resulted_rows = mysqli_num_rows($get_fab_req_result);


                    // add by Chathuranga	
                    
                    
                    $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule1,$color1,$cut_no1,$link);
                    $bg_color1 = get_sewing_job_prefix("bg_color","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule1,$color1,$cut_no1,$link);

                    $title=str_pad("Style:".$style1,80)."\n".str_pad("Schedule:".$schedule1,80)."\n".str_pad("Job No:".$display_prefix1,80)."\n".str_pad("Qty:".$total_qty1,90);   
                    if($style1){
                        if($bg_color1 == 'white'){
                            echo '<li class="ui-state-default" id="'.$doc_no.'"  style="background-color:red;" title="'.$title.'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><strong><font color="black">'.$display_prefix1."(".$style_id_new."-".$schedule1.')</font></strong></li>';
                        }else if($bg_color1 == 'yellow'){
                            echo '<li class="ui-state-default" id="'.$doc_no.'"  style="background-color:white;border: 4px solid yellow;" title="'.$title.'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><strong><font color="red">'.$display_prefix1."(".$style_id_new."-".$schedule1.')</font></strong></li>';
                        }else{
                            if($style_id_new !== NULL){
                                echo '<li class="ui-state-default" id="'.$doc_no.'"  style="background-color:'.$bg_color1.';"  title="'.$title.'" ><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><strong><font color="red">'.$display_prefix1."(".$style_id_new."-".$schedule1.')</font></strong></li>';
                            }
                        }
                    }
                }
                echo '</ul></div></div><br>';
                echo '<input type="hidden" name="listOfItems" value="">';
                if($no_of_jobs > 0){
                    echo "<input type='button' value='Save Sequence' class='btn btn-success btn-sm' id='button_disabled'  onclick='saveDragDropNodes()'/>";
                }else{
                    echo "<div class='alert alert-danger'>No Jobs found for this Module <strong>".$module."</strong></div>";
                }
                echo "</form>";
               
               
            }
            
        ?>
            
    </div>
</div>

