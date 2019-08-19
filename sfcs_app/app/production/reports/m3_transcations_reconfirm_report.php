<style>
th,td{
   text-align:center;
}
.btn{
   float:right;
}
body {
  background: #FFF url("sfcs_app/common/img/bootstrap-colorpicker/KheAuef.png") top left repeat-x;
}

.page    { display: none; padding: 0 0.5em; }
.page h1 { font-size: 2em; line-height: 1em; margin-top: 1.1em; font-weight: bold; }
.page p  { font-size: 1.5em; line-height: 1.275em; margin-top: 0.15em; }

#loading {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 100;
  width: 100vw;
  height: 100vh;
  background-color: rgba(192, 192, 192, 0.5);
  background-image: url("sfcs_app/common/img/bootstrap-colorpicker/MnyxU.gif");
  background-repeat: no-repeat;
  background-position: center;
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
function onReady(callback) {
  var intervalId = window.setInterval(function() {
    if (document.getElementsByTagName('body')[0] !== undefined) {
      window.clearInterval(intervalId);
      callback.call(this);
    }
  }, 1000);
}

function setVisible(selector, visible) {
  document.querySelector(selector).style.display = visible ? 'block' : 'none';
}

onReady(function() {
  setVisible('.page', true);
  setVisible('#loading', false);
});
</script>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0068",$username,1,$group_id_sfcs); 
?>
             <?php 
               //  $sql="SELECT id,ref_no,response_status,mo_no,m3_bulk_tran_id FROM $bai_pro3.`m3_transactions` WHERE response_status='fail' AND m3_trail_count=4";
              $sql="SELECT `bai_pro3`.`m3_transactions`.id,m3_trail_count,response_status,`bai_pro3`.`m3_transactions`.mo_no,m3_bulk_tran_id,style,SCHEDULE,color,size,quantity,`brandix_bts`.`transactions_log`.`response_message` FROM `bai_pro3`.`m3_transactions`  
              LEFT JOIN `bai_pro3`.`mo_details` ON `bai_pro3`.`mo_details`.`mo_no`=`bai_pro3`.`m3_transactions`.`mo_no`
              LEFT JOIN `brandix_bts`.`transactions_log` ON `brandix_bts`.`transactions_log`.`transaction_id`=`bai_pro3`.`m3_transactions`.`m3_bulk_tran_id`
               WHERE `bai_pro3`.`m3_transactions`.`response_status`='fail' AND `bai_pro3`.`m3_transactions`.`m3_trail_count`=4";
          
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
                                 <tr><th>S.No</th><th>Mo No</th><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th><th>Failed Reason</th><th>Failed Count</th><th>Response Status</th>';
                           echo  '<th><input type="checkbox" onClick="checkAll()"/>Select All</th></tr>';
                     $i=1;
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                        
                     $id=$sql_row['id'];
                     $m3_bulk_tran_id=$sql_row['m3_bulk_tran_id'];
                     $style=$sql_row['style'];
                     $schedule=$sql_row['SCHEDULE'];
                     $color=$sql_row['color'];
                     $size=$sql_row['size'];
                     $remarks=$sql_row['response_message'];
                     $mo_qty=$sql_row['quantity'];
                     $trail_count=$sql_row['m3_trail_count'];
                     $response=$sql_row['response_status'];
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
                     }if($mo_qty==''){
                        $mo_qty="--";
                     }else{
                        $mo_qty;
                     }
                     if($response=='fail'){
                        $response='Fail';
                     }else{
                        $response;
                     }
                    echo "<tr><td>".$i++."</td><td>".$sql_row['mo_no']."</td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$size."</td><td>".$mo_qty."</td><td>".$remarks."</td><td>".$trail_count."</td><td>".$response."</td>";
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
            echo $reconfim_id;
            $update_sql="update $bai_pro3.`m3_transactions` set m3_trail_count=0 where id=$id_status";
            echo $update_sql;
            mysqli_query($link, $update_sql) or exit("Sql Update Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $update_bulk_sql="update $bai_pro3.`m3_bulk_transactions` set m3_trail_count=0 where id='$reconfim_id'";
            echo $update_bulk_sql;
            mysqli_query($link, $update_bulk_sql) or exit("Sql Update bulk Error".mysqli_error($GLOBALS["___mysqli_ston"]));

         }
      header("Refresh:0"); 
      echo '<div id="loading"></div>';
    }

?>
