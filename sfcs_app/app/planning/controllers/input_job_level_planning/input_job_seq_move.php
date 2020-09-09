<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R')); 
    $plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
?>
<link rel="stylesheet" href="<?=getFullURLLevel($_GET['r'],'common/css/jquery-ui.css',2,'R')?>">
<script src="<?=getFullURLLevel($_GET['r'],'common/js/jquery-1.12.4.js',2,'R')?>"></script>
<script src="<?=getFullURLLevel($_GET['r'],'common/js/jquery-ui.js',2,'R')?>"></script>
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
                            $department='SEWING';
                            /** Getting work stations based on department wise
                            * @param:department,plantcode
                            * @return:workstation
                            **/
                            $result_worksation_id=getWorkstations($department,$plant_code);
                            $workstations=$result_worksation_id['workstation'];
                            foreach($workstations as $work_id=>$work_des)
                            {
                                echo "<option value='".$work_id."&".$work_des."'>".$work_des."</option>";
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
            $tasktype = TaskTypeEnum::SEWINGJOB;
            $job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
            if($_POST['submit']){
                echo "<hr>";
                $splittedValue=explode("&",$_POST['module']);
                $module= $splittedValue[0];
                $moduleDescr= $splittedValue[1];    
                echo "<h3><span class='label label-success'>Selected Module : ". $moduleDescr."</span></h3>";
                echo '<form action="'.getFullURLLevel($_GET['r'],'input_job_seq_update.php',0,'N').'" method="post" name="myForm">';
                echo '<div class="row"><div class="col-md-4">';
                echo '<ul id="sortable" module="'.$module.'" class="ui-sortable">';

               //Qry to fetch task_header_id from task_header
               $task_header_id=array();
               $get_task_header_id="SELECT task_header_id FROM $tms.task_header WHERE resource_id='$module' AND task_status='PLANNED' AND task_type='$tasktype' AND plant_code='$plant_code'";
               $task_header_id_result=mysqli_query($link_new, $get_task_header_id) or exit("Sql Error at get_task_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
               while($task_header_id_row=mysqli_fetch_array($task_header_id_result))
               {
               $task_header_id[] = $task_header_id_row['task_header_id'];
               }
               //To get taskrefrence from task_jobs based on resourceid
               $task_job_reference=array();
               $get_refrence_no="SELECT task_job_reference FROM $tms.task_jobs WHERE task_header_id IN('".implode("','" , $task_header_id)."') AND plant_code='$plant_code'";
               $get_refrence_no_result=mysqli_query($link_new, $get_refrence_no) or exit("Sql Error at refrence_no".mysqli_error($GLOBALS["___mysqli_ston"]));
               while($refrence_no_row=mysqli_fetch_array($get_refrence_no_result))
               {
               $task_job_reference[] = $refrence_no_row['task_job_reference'];
               }
               //Qry to get sewing jobs from jm_jobs_header
               $result_planned_jobs=getPlannedJobs($module,$tasktype,$plant_code);
               $job_number=$result_planned_jobs['job_number'];

               $no_of_jobs = sizeof($job_number);
               
               //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK HEADER ID
               $job_detail_attributes=[];
               $qry_toget_style_sch="SELECT * FROM $tms.task_attributes where task_header_id in ('" . implode ( "', '", $task_header_id ) . "') and plant_code='$plant_code'";
               $qry_toget_style_sch_result=mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
               while($row2=mysqli_fetch_array($get_details_result))
               {
                    foreach($sewing_job_attributes as $key=> $val){
                        if($val == $row2['attribute_name'])
                        {
                            $job_detail_attributes[$val] = $row2['attribute_value'];
                        }
                    }
               }
               $style1=$job_detail_attributes[$sewing_job_attributes['style']];
               $color1=$job_detail_attributes[$sewing_job_attributes['color']];
                   
               //Function to get schedules from getBulkSchedules based on style,plantcode
               $result_schedules=getBulkSchedules($style,$plant_code);
               $schedule_details=$result_schedules['bulk_schedule'];
               $schedule1=implode("," , $schedule_details);
               $doc_qty=0;  
               foreach($job_number as $sew_num=>$jm_sew_id)
               {
                                   
                   $id="#33AADD"; //default existing color
                                           
                   if($style==$style1 and $color==$color1)
                   {
                   $id="red";
                   }
                   else
                   {
                   $id="#008080";
                   }
                   $title=str_pad("Style:".$style1,30)."\n".str_pad("Schedule:".$schedule1,50)."\n".str_pad("Color:".$color1,50)."\n".str_pad("Job No:".$sew_num,50)."\n".str_pad("Qty:".$job_quantity[$jm_sew_id],50);

                   echo '<li class="ui-state-default" id="'.$jm_sew_id.'"  style="background-color:red;" title="'.$title.'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><strong><font color="black">'.$sew_num.'</font></strong></li>';


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

