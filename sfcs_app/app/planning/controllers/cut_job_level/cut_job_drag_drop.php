<?php

//Function to get workstations from getWorkstations based on department,plant_code
$task_type='DOCKET';
$department='Cutting';
$result_worksation_id=getWorkstations($department,$plantcode);
$workstations=$result_worksation_id['workstation'];

foreach($workstations as $work_id=>$work_des)
{
  echo "<div style=\"width:170px;\" align=\"center\"><h4>$work_des</h4>";

   echo "<ul id='".$work_id."' style='width:150px'>";
//To get taskrefrence from task_jobs based on resourceid
     $task_job_reference=array();
     $get_refrence_no="SELECT task_job_reference FROM $tms.task_jobs WHERE resource_id='$work_id' AND task_status='PLANNED' AND task_type='$task_type' AND plant_code='$plantcode'";
     $get_refrence_no_result=mysqli_query($link_new, $get_refrence_no) or exit("Sql Error at refrence_no".mysqli_error($GLOBALS["___mysqli_ston"]));
     while($refrence_no_row=mysqli_fetch_array($get_refrence_no_result))
     {
      $task_job_reference[] = $refrence_no_row['task_job_reference'];
     }
     //To get dockets from jm_dockets based on jm_docket_id
     $docket_no=array();
     $qry_get_dockets="SELECT docket_number,jm_docket_id From $pps.jm_dockets WHERE jm_docket_id in ('".implode("','" , $task_job_reference)."') AND plant_code='$plantcode' order by docket_number ASC";
     $toget_dockets_result=mysqli_query($link_new, $qry_get_dockets) or exit("Sql Error at dockets".mysqli_error($GLOBALS["___mysqli_ston"]));
     while($dockets_row=mysqli_fetch_array($toget_dockets_result))
     {
       $docket_no[$dockets_row['docket_number']]=$dockets_row['jm_docket_id'];
     }
     //Function to get cut numbers from getCutDetails based on subpo,plantcode
     $result_cuts=getCutDetails($sub_po,$plantcode);
     $cuts=$result_cuts['cut_number'];
     $cut_details=implode("','" , $cuts);

     //Function to get schedules from getBulkSchedules based on style,plantcode
     $result_schedules=getBulkSchedules($style,$plantcode);
     $schedule_details=$result_schedules['bulk_schedule'];
     $schedule1=implode("," , $schedule_details);
     $doc_qty=0;
     foreach($docket_no as $dok_num=>$jm_dok_id)
     {
        //Function to get style,color,docket_qty from getJmDockets based on docket and plantcode
      $result_get_details=getJmDockets($dok_num,$plantcode);
      $style1=$result_get_details['style'];
      $color1=$result_get_details['fg_color'];
      $plies=$result_get_details['plies'];
      $length=$result_get_details['length'];
        $doc_qty=$plies*$length;

        $id="#33AADD"; //default existing color

if($style==$style1 and $color==$color1)
{
$id="red";
}
else
{
$id="#008080";
}
$title=str_pad("Style:".$style1,30)."\n".str_pad("Schedule:".$schedule1,50)."\n".str_pad("Color:".$color1,50)."\n".str_pad("Job No:".$cut_details,50)."\n".str_pad("Qty:".$doc_qty,50);

        echo '<li id="'.$jm_dok_id.'" data-color="'.$id.'" style="background-color:'.$id.';  color:white;" title="'.$title.'"><strong>'.$dok_num.'</strong></li>';

      }
 echo "</ul>";
echo "</div>";

}

?>