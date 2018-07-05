<?php  
/*
    Purpose : Page to update down time in sewing time based on planning vs actual 
    Created By : Chandu
    Create : 04-07-2018
    Update : 05-07-2018 
    inputs : date,time,module
    output : show table with style,schedule,color details and update button for update down time
*/
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/user_acl_v1.php',3,'R'));
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));  
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',3,'R'));
//========== get modules list ================
$sql_module = 'select sec_mods FROM '.$bai_pro3.'.sections_db where sec_id>0';
$result_module = mysqli_query($link, $sql_module) or exit("Sql Error - module".mysqli_error($GLOBALS["___mysqli_ston"]));
//=========== get timimgs list =======================
$sql_time = 'select time_value,CONCAT(time_display,"(",day_part,")") AS time_display  FROM '.$bai_pro3.'.tbl_plant_timings';
$result_time = mysqli_query($link, $sql_time) or exit("Sql Error time".mysqli_error($GLOBALS["___mysqli_ston"]));
?> 
<head>
<title>Down time capturing</title>
</head>
<body>
    <div class="panel panel-primary">
        <div class='panel-heading'><h3 class='panel-title'>Downtime Capturing</h3></div>
        <div class='panel-body'>
            <form>
                <input type='hidden' name='r' value='<?= $_GET['r'] ?>'>
                <div class="form-group col-sm-3">
                    <input type="date" class="form-control" name='mdate' value="<?= isset($_GET['mdate']) ? $_GET['mdate'] : '' ?>" required>
                </div>
                <div class="form-group col-sm-3">
                    <select class="form-control" name='mtime' required>
                        <option value=''>Select Time</option>
                        <?php
                            while($row=mysqli_fetch_array($result_time)){
                                if(isset($_GET['mtime']) && $_GET['mtime']==$row['time_value'])
                                    echo "<option value='".$row['time_value']."' selected>".$row['time_display']."</option>";
                                else
                                    echo "<option value='".$row['time_value']."'>".$row['time_display']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <select class="form-control" name='module' required>
                        <option value=''>Module</option>
                        <?php
                            while($row=mysqli_fetch_array($result_module)){
                                $list = explode(',',$row['sec_mods']);
                                foreach($list as $pv){
                                    if(isset($_GET['module']) && $_GET['module']==$pv)
                                        echo "<option value='".$pv."' selected>".$pv."</option>";
                                    else
                                        echo "<option value='".$pv."'>".$pv."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Filter</button>
                <a href="index.php?r=<?= $_GET['r'] ?>" class="btn btn-warning"><i class="fas fa-times"></i> Clear</a>
            </form>

<!-- Logics starts here -->
<?php

            if(isset($_GET['module']) && $_GET['module']!='' && isset($_GET['mtime']) && $_GET['mtime']!='' && isset($_GET['mdate']) && $_GET['mdate']!=''){
                echo "<hr/>";
                $get_log_data = "SELECT bac_style,color,delivery,sum(bac_Qty) as bac_Qty FROM $bai_pro.bai_log WHERE DATE(bac_lastup) = '".date('Y-m-d',strtotime($_GET['mdate']))."' AND HOUR(bac_lastup) = '".$_GET['mtime']."' AND bac_no = '".$_GET['module']."' group by bac_style,delivery,color" ;
                $result_log_data = mysqli_query($link, $get_log_data) or exit("Sql Error log".mysqli_error($GLOBALS["___mysqli_ston"]));
                $get_fr_data = "
                SELECT style,schedule,color,(fr_qty/hours) AS qty FROM $bai_pro2.fr_data WHERE DATE(frdate)='".date('Y-m-d',strtotime($_GET['mdate']))."' AND team='".$_GET['module']."'";
                $result_fr_data = mysqli_query($link, $get_fr_data) or exit("Sql Error fr".mysqli_error($GLOBALS["___mysqli_ston"]));

                $tab="<table class='table'><thead><tr><th>Type</th><th>Style</th><th>Schedule</th><th>Color</th><th>Quantity</th></tr></thead><tbody>";
                $act_data = [];
                $target = true;
                $act_count = mysqli_num_rows($result_log_data);
                $fr_count = mysqli_num_rows($result_fr_data);
                while($row=mysqli_fetch_array($result_log_data)){
                    $tab.="<tr>";
                    if(count($act_data)==0)
                        $tab.="<td style='vertical-align: middle;' class='text-center' rowspan=".$act_count."><h5>Actual</h5></td>";
                    $tab.="<td>".$row['bac_style']."</td><td>".$row['delivery']."</td><td>".$row['color']."</td><td>".$row['bac_Qty']."</td></tr>";
                    $act_data[trim($row['bac_style']).trim($row['delivery']).trim($row['color'])] = $row['bac_Qty'];
                }
                $i=0;
                while($row=mysqli_fetch_array($result_fr_data)){
                    $tab.="<tr>";
                    if($i==0)
                        $tab.="<td style='vertical-align: middle;' class='text-center' rowspan=".$fr_count."><h5>Plan</h5></td>";
                    $tab.="<td>".$row['style']."</td><td>".$row['schedule']."</td><td>".$row['color']."</td><td>".$row['qty']."</td></tr>";

                    $key = trim($row['style']).trim($row['schedule']).trim($row['color']);
                    if(isset($act_data[$key])){
                        if($act_data[$key]<$row['qty']){
                            $target = false;
                        }
                    }else{
                        $target = false;
                    }
                    $i++;
                }
                $tab.="</tbody></table>";
                if(!$target)
                    echo "<button class='btn btn-danger pull right'><i class='fas fa-clock'></i> Update Down Time</button>";
                if($act_count>0 || $fr_count>0)
                    echo $tab;
                else
                    echo "<div class='alert alert-warning'>No Data Found</div>";
            }
?>
        </div>
    </div>
</body>