<style>
th,td{
   text-align:center;
}
.btn{
   float:right;
}

</style>
<script>
function checkAll()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
}

</script>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0068",$username,1,$group_id_sfcs); 
?>
             <?php 
               //  $sql="SELECT id,ref_no,response_status,mo_no,m3_bulk_tran_id FROM $bai_pro3.`m3_transactions` WHERE response_status='fail' AND m3_trail_count=4";
              $sql="SELECT `bai_pro3`.`m3_transactions`.id,remarks,response_status,`bai_pro3`.`m3_transactions`.mo_no,m3_bulk_tran_id,style,schedule,color,size FROM `bai_pro3`.`m3_transactions` LEFT JOIN `bai_pro3`.`mo_details` ON `bai_pro3`.`mo_details`.`mo_no`=`bai_pro3`.`m3_transactions`.`mo_no`
              WHERE response_status='fail' AND m3_trail_count=4";
          
               mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
               $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
               $count=mysqli_num_rows($sql_result);
               
               if($count>0){
               echo '<div class="panel panel-primary">
                      <div class="panel-heading">M3 Bulk Opration Reconfirm Interface</div>
                      <br/>
                      <form action="'.getFullURLLevel($_GET["r"],"m3_transcations_reconfirm_report.php","0","N").'" name="print" method="POST">                    
                       
                        <div class="panel-body">
                        <div class="table-responsive">
                                 <table id="example" cellspacing="0" width="100%" class="table table-bordered">
                                 <input type="submit" value="Re-Confirm" class="btn btn-primary">
                                 <tr><th>S.No</th><th>Mo No</th><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Reason</th><th>Response Status</th>';
                           echo  '<th><input type="checkbox" onClick="checkAll()"/>Select All</th></tr>';
                     $i=1;
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                        
                     $id=$sql_row['id'];
                     $m3_bulk_tran_id=$sql_row['m3_bulk_tran_id'];
                     $style=$sql_row['style'];
                     $schedule=$sql_row['schedule'];
                     $color=$sql_row['color'];
                     $size=$sql_row['size'];
                     $remarks=$sql_row['remarks'];

                     // echo $m3_bulk_tran_id; 
                     if($style==''){
                        $style="--";
                     }else{
                        $style;
                     }
                     if($schedule==''){
                        $schedule="--";
                     }else{
                        $schedule;
                     }
                     if($color==''){
                       $color="--";
                     }else{ 
                       $color;
                     } if($size==''){
                        $size="--";
                     }else{
                        $size;
                     }if($remarks==''){
                        $remarks="--";
                     }else{
                        $remarks;
                     }
                    echo "<tr><td>".$i++."</td><td>".$sql_row['mo_no']."</td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$size."</td><td>".$remarks."</td><td>".$sql_row['response_status']."</td>";
                    echo "<td><input type='checkbox' name='bindingdata[]' value='".$id.'-'.$m3_bulk_tran_id."'></td>";
                  
                }
                
               //  echo $count;
                if($count>25){
                $reconfirm='<input type="submit" value="Re-Confirm" class="btn btn-primary">';
                }
              echo '</table>'."$reconfirm".'</form></div></div></div>';  
               }else{
                  echo '<div class="panel panel-primary">
                  <div class="panel-heading" style="text-align:center;">Data Not Found....!</div>';
               }
           ?>
        <?php
   if(isset($_POST['bindingdata']))
   {
      $binddetails=$_POST['bindingdata'];
      $count1=count($binddetails);


         for($j=0;$j<$count1;$j++)
         {
            $id = $binddetails[$j];
            $exp=explode("-",$id);
            $id_status=$exp[0];
            $reconfim_id=$exp[1]; 
            // echo $reconfim_id;
            $update_sql="update $bai_pro3.`m3_transactions` set m3_trail_count='0' where id='$id_status'";
            // echo $update_sql;
            mysqli_query($link, $update_sql) or exit("Sql Update Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $update_bulk_sql="update $bai_pro3.`m3_bulk_transactions` set m3_trail_count='0' where id='$reconfim_id'";
            mysqli_query($link, $update_bulk_sql) or exit("Sql Update bulk Error".mysqli_error($GLOBALS["___mysqli_ston"]));

         }
      header("Refresh:0");
   }

?>
