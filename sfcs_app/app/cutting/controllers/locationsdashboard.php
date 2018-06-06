<style> 
    .cell {
        width: 100px;
        height: 40px; 
        margin-left: 5%; 
        margin-top: 3%;          
    }

    .Empty {
        background-color: lightgreen;
    }

    .Half_filled {
        background-color: #ffff33;
    }

    .filled {
        background-color: #ff4d4d;
    }
    .blink_me {
        animation: blinker 2s linear infinite;
    }
    @keyframes blinker {  
        50% { opacity: 0; }
    }
</style>
<script type="text/javascript">
jQuery(document).ready(function($){
   $('#schedule,#docket').keypress(function (e) {
       var regex = new RegExp("^[0-9\]+$");
       var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
       if (regex.test(str)) {
           return true;
       }
       e.preventDefault();
       return false;
   });
});
</script>
    </head>
    <body>
        <?php 
            error_reporting(0);             
            include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
                $sqlQuery = "SELECT * FROM $bai_pro3.locations";
				$sqlData = mysqli_query($link, $sqlQuery) or exit("Problem picking the locations from database/".mysqli_error($GLOBALS["___mysqli_ston"]));
                $locationData = array();
                $resultArray = array();
                while($row = mysqli_fetch_array($sqlData)){
                    $locationData['loc_id'] = $row['loc_id'];
                    $locationData['loc_name'] = $row['loc_name'];
                    $locationData['capacity'] = $row['capacity'];
                    $locationData['filled_qty'] = $row['filled_qty'];
                    array_push($resultArray, $locationData);
                }               
                if(!empty($_POST['sch_no']) || !empty($_POST['doc_no'])){
                    if(!empty($_POST['sch_no'])){ 
                        $sch =  $_POST['sch_no'];                 
                        $docketinfo = "SELECT DISTINCT doc_loc_mapping.doc_no,GROUP_CONCAT(DISTINCT doc_loc_mapping.loc_id) AS loc_id,GROUP_CONCAT(DISTINCT locations.loc_name) AS loc_name FROM $bai_pro3.doc_loc_mapping LEFT JOIN $bai_pro3.locations ON locations.loc_id= doc_loc_mapping.loc_id WHERE doc_loc_mapping.doc_no IN(SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE '%".$sch."%')";
                        $docketresult = mysqli_query($link, $docketinfo) or exit("Error getting dockets with schedule number/".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $docketcount = mysqli_num_rows($docketresult);
						
						$docketlocs = "SELECT DISTINCT loc_id FROM $bai_pro3.doc_loc_mapping WHERE doc_no IN(SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE '%".$sch."%')";						
						$docketlocresult = mysqli_query($link, $docketlocs) or exit("Error getting dockets with schedule number/".mysqli_error($GLOBALS["___mysqli_ston"]));
						$docketloccount = mysqli_num_rows($docketlocresult);
                    }
                    if(!empty($_POST['doc_no'])){
                        $doc =  $_POST['doc_no'];
                        $docketinfo = "SELECT doc_loc_mapping.doc_no,GROUP_CONCAT(DISTINCT doc_loc_mapping.loc_id) AS loc_id,GROUP_CONCAT(DISTINCT locations.loc_name) AS loc_name FROM $bai_pro3.doc_loc_mapping LEFT JOIN $bai_pro3.locations ON locations.loc_id = doc_loc_mapping.loc_id WHERE  doc_no = ".$doc." AND doc_loc_mapping.`loc_id` = locations.`loc_id`";
                        $docketresult = mysqli_query($link, $docketinfo) or exit("Error getting dockets with docket number/".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $docketcount = mysqli_num_rows($docketresult);
						
						$docketlocs = "SELECT DISTINCT loc_id FROM $bai_pro3.doc_loc_mapping WHERE doc_no =".$doc;						
						$docketlocresult = mysqli_query($link, $docketlocs) or exit("Error getting dockets with docket number/".mysqli_error($GLOBALS["___mysqli_ston"]));
						$docketloccount = mysqli_num_rows($docketlocresult);
                    }
                    $locArray =array();
                    $resArray =array();
					if($docketcount >0){
						while($row = mysqli_fetch_array($docketresult)){
							$locArray['loc_id'] = $row['loc_id'];
							$locArray['doc_no'] = $row['doc_no'];
							$locArray['loc_name'] = $row['loc_name'];
							array_push($resArray, $locArray);
						}                     
					}
					$locArray1 =array();
                    $resArray1 =array();
					if($docketloccount >0){
						while($row = mysqli_fetch_array($docketlocresult)){
							$locArray1['loc_id'] = $row['loc_id'];
							array_push($resArray1, $locArray1);
						}
						$result=array_intersect($resArray1,$resultArray);
					}
                }         
        ?>
        <div class="container-fluid">
            <div class="panel panel-primary"> 
            <div class="panel-heading"><strong>Cut Bundles Locations Dashboard/Report</strong></div>
                <div class="panel-body">
                    <form action="#" method="POST" class="form-inline">
                        <div class="form-group">
                            <label>Schedule Number:</label>
                            <input class="form-control" type="text" id="schedule" min="0" name="sch_no">
                        </div>
                            <span>(OR)</span>
                             <div class="form-group">
                            <label>Docket Number:</label>
                            <input class="form-control"  type="text" id="docket" min="0" name="doc_no">
                            <!-- pattern="[a-zA-Z0-9]+"-->
                        </div>
                        <button type="submit" id="submit" class="btn btn-primary">Search</button><br><br>
                    </form>
                    <div class="col-sm-8">
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"><strong>Locations</strong></div>
                            <div class="panel-body">
                                <?php 
                                    if(count($resultArray)>0){
                                        foreach ($resultArray as $key => $row) {

                                            $SCSarray['order_style_no'] = "";
                                            $SCSarray['order_del_no'] = "";
                                            $SCSarray['order_col_des'] = "";

                                            $get_doc_no = "SELECT DISTINCT doc_no FROM $bai_pro3.`doc_loc_mapping` WHERE loc_id = ".$row['loc_id'];
                                            $get_doc_result = mysqli_query($link, $get_doc_no) or exit("Error getting doc_no with loc_id/".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $doc_array = array();
                                           
                                            while ($doc = mysqli_fetch_array($get_doc_result)) {
                                                $doc_array['doc_no'] = $doc['doc_no'];
                                                $SCSdetails = "SELECT * FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT  order_tid FROM $bai_pro3.plandoc_stat_log WHERE doc_no = ".$doc_array['doc_no'].")";
                                                $SCSresult = mysqli_query($link, $SCSdetails) or exit("Error getting Style, Colour, Schedule details with docket number/".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                
                                                $SCSarray = array();
                                                while ($SCS = mysqli_fetch_array($SCSresult)) {
                                                    $SCSarray['order_style_no'] = $SCS['order_style_no'];
                                                    $SCSarray['order_del_no'] = $SCS['order_del_no'];
                                                    $SCSarray['order_col_des'] = $SCS['order_col_des'];
                                                }
                                            }

                                            $test = "Style: ".$SCSarray['order_style_no']." 
                                                    Schedule: ".$SCSarray['order_del_no']." 
                                                    Color: ".$SCSarray['order_col_des']."
                                                    Docket Number: ".$doc_array['doc_no']."
                                                    ";
											if(count($result)>0){
												foreach ($result as $key => $blink) {
													if($row['loc_id'] == $blink['loc_id']){
														$classBlink = "blink_me";
														break;
													}else{
														$classBlink = "";
													}
												}
											}else{
												$classBlink = "";
											}

                                            if ($row['filled_qty'] == 0) {
                                                echo "<div class='Empty cell col-md-2 ".$classBlink."' title= '".$test."'><span>".$row['loc_name']."</span><br/><span>".$row['filled_qty']."/".$row['capacity']."</span></div>";
                                            }else{
                                                if ($row['filled_qty'] == $row['capacity']) {
                                                    echo "<div class='filled cell col-md-2 ".$classBlink."' title= '".$test."'><span>".$row['loc_name']."</span><br/><span>".$row['filled_qty']."/".$row['capacity']."</span></div>";
                                                }else{
                                                    echo "<div class='Half_filled cell col-md-2 ".$classBlink."' title= '".$test."'><span>".$row['loc_name']."</span><br/><span>".$row['filled_qty']."/".$row['capacity']."</span></div>";
                                                }
                                            }
                                        }                                        
                                    }else{
                                        echo "<center><h2><span style='color:red'>No Locations Available</span></h2></center>   ";
                                    }
                                    
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($_POST['sch_no']) || !empty($_POST['doc_no'])){?>
                    <div class="col-sm-4">
                        <div class="panel panel-primary"> 
                            <div class="panel-heading"><strong><?php if(!empty($_POST['sch_no'])){echo "Schedule No:".$_POST['sch_no'];}else if(!empty($_POST['doc_no'])){echo "Docket No:".$_POST['doc_no'];}?></strong></div>
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>Docket No</th>
                                        <th>Location</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(count($resArray) > 0){
												for($i=0;$i<count($resArray);$i++){
													echo "<tr><td>".$resArray[$i]['doc_no']."</td><td>".$resArray[$i]['loc_name']."</td></tr>";
												}                                                
                                            }else{
                                                echo "<tr><td>No Dockets Available for this Schedule No/Docket No</td></tr>";
                                            }
                                        ?>                                                                          
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
		
