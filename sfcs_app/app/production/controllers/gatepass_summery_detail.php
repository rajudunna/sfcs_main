<?php 

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/js/jquery.min1.7.1.js',4,'R'));

// if(isset($_GET['gatepassid']) && isset($_GET['vehicle_no']) ){
//     $test=1;
//     $gatepassid=$_GET['gatepassid'];
//     $vehicle_no=$_GET['vehicle_no'];

// }

// $gatepassid=$_GET['gatepassid'];

// $sql="select * from $brandix_bts.gatepass_table where id='$gatepassid' ";
// $sql_res = mysqli_query($link,$sql) or exit('error in gate pass');
// while($res1 = mysqli_fetch_array($sql_res)){
//     $vehicle_number = $res1['vehicle_no'];
// }
if(isset($_GET['gatepassid']))
{
?>
<div class="panel panel-primary">
    <div class="panel-heading">Gate Pass</div>
    <div class="panel-body">
            <form method="post" name="input" action="<?php echo '?r='.$_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-2">
                        <label>Enter Vehice Number: </label>
                        <input type="text"  id="vehicle_no"  name="vehicle_no" class="form-control"  value="<?php  if(isset($_POST['vehicle_no'])) { echo $_POST['vehicle_no']; } else { echo ""; } ?>" />
                         <input type="hidden"  id="gatepassno"  name="gatepassno" class="form-control"  value="<?=$gatepassid; ?>" />
                    </div>
                    <div class="row">
                    <div class="col-md-8">
                        <input type="submit" value="Generate Gate Pass" name="submit" class="btn btn-success"  style="margin-top:22px;">
                    </div>
                    </div>
                </div> 
            </form><br/>
<?php

}
if(!isset($_GET['gatepassid'])){
    ?>
    <div class="panel panel-primary">
    <div class="panel-heading">Gate Pass</div>
    <div class="panel-body">
            <form method="post" name="input" action="<?php echo '?r='.$_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-2">
                        <label>Select Date: </label>
                        <input type="text" data-toggle="datepicker" id="date_select"  name="date" class="form-control"  size=8/>
                         <input type="hidden"  id="gatepassno"  name="gatepassno" class="form-control"  value="<?=$gatepassid; ?>" />
                    </div>
                    <div class="row">
                    <div class="col-md-8">
                        <input type="submit" value="Get Details" name="submitdetails" class="btn btn-success"  style="margin-top:22px;">
                    </div>
                    </div>
                </div> 
            </form><br/>
            <?php     
          
        // echo "<script>window.location = '$url&gatepassid=$id';</script>";
    }
  
    ?>

<style>
th,td{
    text-align:center;
}
</style>


<?php
if(isset($_POST['submit'])){
    $vehicle_number=$_POST['vehicle_no'];
    $gatepassno=$_POST['gatepassno'];
    // echo $gatepassno;
    $sql33="update $brandix_bts.gatepass_table set vehicle_no='$vehicle_number' where id=\"1\"";
    // echo $sql33."<br/>";
    mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    // echo "<p style='float: right;position: relative;bottom: 9px;right: 18px;' id='status' class='btn btn-success btn-xs' value='True'><span>Detail View</span></p>

    echo"<div class='panel-body'>
    
    <div class='panel panel-primary'>
                <table class='table table-bordered'>";
                $sql_total="SELECT style,size,schedule,color,SUM(bundle_qty) AS qty_bundle,COUNT(bundle_no) AS bundle_count FROM `brandix_bts`.`gatepass_track` GROUP BY style,schedule,color";
           
                $sql_grand_total_res = mysqli_query($link,$sql_total) or exit('error in heading table view');
                while($res_row12 = mysqli_fetch_array($sql_grand_total_res))
                {
                 $array_res[]=$res_row12;
                }
                // $array_res=json_encode($array_res);
                // var_dump($array_res);die();
                $grand_total_Qty=$grand_total_Bundle=0;
                foreach ($array_res as $key => $value) {
                    $grand_total_Qty=$grand_total_Qty+$array_res[$key]['qty_bundle'];
                    $grand_total_Bundle=$grand_total_Bundle+$array_res[$key]['bundle_count'];
                }
                echo "<tr class='warning'> 
                        <th class='tblheading'>Style</th>
                        <th class='tblheading' >Schedule</th>
                        <th class='tblheading'>Color</th>
                        <th class='tblheading'>Qty</th><th class='tblheading'>Number of Bundles</th></tr>
                        <tr style='background-color:#efef99'><th>Grand Total:</th>";
                        echo "<th></th><th></th><th>$grand_total_Qty</th><th>$grand_total_Bundle</th></tr>";
                        foreach ($array_res as $key => $value) {
                            echo "<tr><td>".$array_res[$key]['style']."</td><td>".$array_res[$key]['schedule']."</td><td>".$array_res[$key]['color']."</td><td>".$array_res[$key]['qty_bundle']."</td><td>".$array_res[$key]['bundle_count']."</td></tr>";   
                        }
                      
                echo "</table></div></div>";
                }




                if(isset($_POST['submitdetails'])){
                    $date=$_POST['date'];
                    $sql_date="select * from $brandix_bts.`gatepass_table` where date='$date' ";
                // echo $sql_date;
                  $date_gatepass = mysqli_query($link,$sql_date) or exit('error in heading table view222');
                  echo  "<div class='panel-body'>";
                  echo "<div class='panel panel-primary'>";
                    echo '<table class="table table-bordered"><tr class="warning"><th class="tblheading">Gate Pass Id</th><th class="tblheading">Shift</th><th class="tblheading">Operation</th><th class="tblheading">Vehicle No</th><th class="tblheading">Status</th><th class="tblheading">Date</th></tr>';
                    $url="http://localhost//index.php?r=L3NmY3NfYXBwL2FwcC9wcm9kdWN0aW9uL2NvbnRyb2xsZXJzL2dhdGVwYXNzX3N1bW1lcnlfZGV0YWlsLnBocA==";
    
                    while($data_res = mysqli_fetch_array($date_gatepass))
                    {
                        $id=$data_res['id'];
                        $shift=$data_res['shift']; 
                        $status=$data_res['gatepass_status'];    
                        $operation=$data_res['operation'];    
                        $vehicle_no=$data_res['vehicle_no'];    
                        $date_get=$data_res['date'];    
                        echo "<tr><td><a href='$url&gatepassid=$id'>$id</a></td><td>$shift</td><td>$operation</td><td>$vehicle_no</td><td>$status</td><td>$date_get</td></tr>";
                     }
                     echo '</table></div></div>';
                 
                }
                ?>