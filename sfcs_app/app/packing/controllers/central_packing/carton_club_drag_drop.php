	<!doctype html>
	<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carton Club</title>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
        include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
        echo '<script src="'.getFullURLLevel($_GET['r'],'common/js/jquery-ui.js',2,'R').'"></script>';
        if (isset($_GET['style']))
        {
            $style=$_GET['style'];
            $schedule=$_GET['schedule'];
            $style_ori = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style,$link); 
            $schedule_ori = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
        }
        if(isset($_POST['submit']))
        {
            $style = $_POST['style'];
            $schedule = $_POST['schedule'];
            $packmethod = $_POST['packmethod'];
		}

    ?>
    <script type="text/javascript">
        var url1 = '<?= getFullURL($_GET['r'],'carton_club_drag_drop.php','N'); ?>';
        function firstbox()
        {
            window.location.href =url1+"&style="+document.mini_order_report.style.value
        }

        function secondbox()
        {
            window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
        }
    </script>
    <style>
        #sortable1{
            height: 250px;
            overflow-y: auto;
        }
        #sortable2 {
            height: 150px;
        }
        #sortable1, #sortable2 {
            border: 1px solid black;
            width: 1000px;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }
        #sortable1 li, #sortable2 li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 100px;
        }
    </style>
    <script>
        $( function() {
            $( "#sortable1, #sortable2" ).sortable({
                cancel: ".unsortable",
                connectWith: ".connectedSortable"
            }).disableSelection();
        });
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading"> Carton Clubbing</div>
            <div class="panel-body">
                <?php
                    echo "<div class='col-md-12'>
                        <form action=\"#\" method=\"post\" class='form-inline' name='mini_order_report' id='mini_order_report'>
                            <label>Style: </label>";
                                // Style
                                echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" required>";
                                $sql="select * from $brandix_bts.tbl_orders_style_ref order by product_style";
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error2");
                                $sql_num_check=mysqli_num_rows($sql_result);
                                echo "<option value=''>Please Select</option>";
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$style))
                                    {
                                        echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_style']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_style']."</option>";
                                    }
                                }
                                echo "</select>
                                &nbsp;
                            <label>Schedule:</label>";
                                // Schedule
                                echo "<select class='form-control' name=\"schedule\" onchange=\"secondbox();\" id=\"schedule\"  required>";
                                $sql="select * from $brandix_bts.tbl_orders_master where ref_product_style='".$style."'";
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $sql_num_check=mysqli_num_rows($sql_result);
                                echo "<option value=''>Please Select</option>";
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    if(str_replace(" ","",$sql_row['id'])==str_replace(" ","",$schedule))
                                    {
                                        echo "<option value=\"".$sql_row['id']."\" selected>".$sql_row['product_schedule']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=\"".$sql_row['id']."\">".$sql_row['product_schedule']."</option>";
                                    }
                                }
                                echo "</select>&nbsp;&nbsp;";
								echo "<label>Pack Method:</label> 
                                    <select class='form-control' name=\"packmethod\"  id='packmethod' required>";
                                        $sql="select distinct pack_method from $bai_pro3.pac_stat_log where style=\"$style_ori\" AND schedule=\"$schedule_ori\"";  
                                        $sql_result=mysqli_query($link, $sql) or exit("Sql Error");
                                        echo "<option value=''>Please Select</option>";
                                    while($sql_row=mysqli_fetch_array($sql_result))
                                    {
                                        $seqno="select distinct seq_no from $bai_pro3.pac_stat_log where style=\"$style_ori\" AND schedule=\"$schedule_ori\" and pack_method='".$sql_row['pack_method']."'";
                                        $seqrslt=mysqli_query($link, $seqno) or exit("error while getting seq no");
                                        while($row=mysqli_fetch_array($seqrslt))
                                        {
                                            if($row['seq_no']."-".$sql_row['pack_method']==$packmethod)
                                            {
                                                echo "<option value=\"".$row['seq_no']."-".$sql_row['pack_method']."\" selected>".$row['seq_no']."-".$operation[$sql_row['pack_method']]."</option>";
                                            }
                                            else
                                            {
                                                echo "<option value=\"".$row['seq_no']."-".$sql_row['pack_method']."\">".$row['seq_no']."-".$operation[$sql_row['pack_method']]."</option>";
                                            }
                                        }
                                    }
                                    echo "</select>";
                            ?>
                            &nbsp;&nbsp;
                            <input type="submit" name="submit" id="submit" class="btn btn-success " value="Submit">
                        </form>
                    </div>

                <?php
                    if (isset($_POST['submit']))
                    { 
                        $style = $_POST['style'];
                        $schedule = $_POST['schedule'];
                        $packmethod = $_POST['packmethod'];
						$seq = substr($packmethod,0,1);
						$packm = substr($packmethod,-1);
                        $style_ori = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style,$link); 
                        $schedule_ori = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
                        echo '
                            <input type="hidden" name="style_id" id="style_id" value="'.$style.'">
                            <input type="hidden" name="schedule_id" id="schedule_id" value="'.$schedule.'">
                            <input type="hidden" name="style1" id="style1" value="'.$style_ori.'">
                            <input type="hidden" name="schedule1" id="schedule1" value="'.$schedule_ori.'">
                            <input type="hidden" name="packmethod1" id="packmethod1" value="'.$packmethod.'">';

                        $carton_no = array();   $status = array();  $carton_mode=array();   $doc_no_ref = array();
                        $get_cartons = "SELECT carton_no, status, carton_mode, doc_no_ref FROM bai_pro3.pac_stat_log WHERE SCHEDULE=$schedule_ori and seq_no=$seq group by carton_no";
						$carton_result=mysqli_query($link, $get_cartons) or die("Error"); 
                        while($row=mysqli_fetch_array($carton_result)) 
                        {
                            $doc_no_ref[]=$row['doc_no_ref'];
                            $carton_no[]=$row['carton_no'];
                            $status[] = $row['status'];
                            $carton_mode[] = $row['carton_mode'];
                        }
                         ?>
                        <br><br>
                        <br><br>
                        
                        <!-- Legends -->
                        <button class='btn btn-success btn-sm'></button>Full Carton&nbsp;&nbsp;
                        <button class='btn btn-warning btn-sm'></button>Partial Carton&nbsp;&nbsp;
                        <button class='btn btn-danger btn-sm'></button>Scanning Completed

                        <!-- From Container -->
                        <ul id="sortable1" class="connectedSortable">
                            <?php
                                for ($i=0; $i < sizeof($carton_no); $i++)
                                {
                                    $final_details = "SELECT GROUP_CONCAT(DISTINCT TRIM(color) SEPARATOR '\n') AS colors, GROUP_CONCAT(DISTINCT size_tit) AS sizes, SUM(carton_act_qty) AS carton_qty FROM bai_pro3.`pac_stat_log` WHERE doc_no_ref = '".$doc_no_ref[$i]."';";
                                    $final_result = mysqli_query($link,$final_details);
                                    while($row=mysqli_fetch_array($final_result))
                                    {
                                        $colors=$row['colors'];
                                        $sizes=$row['sizes'];
                                        $carton_qty=$row['carton_qty'];
                                    }
                                    if ($status[$i] != 'DONE')
                                    {
                                        if ($carton_mode[$i] == 'F')
                                        {
                                            
                                            echo "<li class='btn btn-success' value='".$carton_no[$i]."' title='Color: ".$colors."\nSize: ".$sizes."\nQty: ".$carton_qty."'>Carton - $carton_no[$i]</li>";
                                        }
                                        else
                                        {
                                            echo "<li class='btn btn-warning' value='".$carton_no[$i]."' title='Color: ".$colors."\nSize: ".$sizes."\nQty: ".$carton_qty."'>Carton - $carton_no[$i]</li>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<li class='btn btn-danger unsortable' value='".$carton_no[$i]."' title='Color: ".$colors."\nSize: ".$sizes."\nQty: ".$carton_qty."'>Carton - $carton_no[$i]</li>";
                                    }
                                }
                            ?>
                        </ul>
                        <br><br>
                        <br><br>
                        <br><br>
                        <br><br>
						<br><br>
						<br><br>
                        <br><br>
						<br><br>
                        <h3><span class="label label-info">Drop Carton Box in Below Container which you want to Club</span></h3>
                        <!-- To Container -->
                        <ul id="sortable2" class="connectedSortable">

                        </ul>
                        <br><br>
                        <br><br>
                            <input type="button" name="save" id="save" value="Club" class="btn btn-success" onclick="test();">
                        <?php
                    } ?>                       
            </div>
        </div>
    </div>

     <script type="text/javascript">
        function test()
        {
            var style = document.getElementById('style1').value;
            var schedule = document.getElementById('schedule1').value;
            var packmethod = document.getElementById('packmethod1').value;
            var style_id = document.getElementById('style_id').value;
            var schedule_id = document.getElementById('schedule_id').value;
            var url12 = '<?= getFullURL($_GET['r'],'carton_club_drag_drop.php','N'); ?>';
            var cart = "";
            var listItems = document.querySelectorAll('#sortable2 li');
            for (let i = 0; i < listItems.length; i++)
            {
                console.log(listItems[i].value);
                cart += listItems[i].value+',';
            }
            document.getElementById('new_cartons').value = cart;
            var new_car = document.getElementById('new_cartons').value;
            window.location.href =url12+"&carton="+new_car+"&style1="+style+"&schedule1="+schedule+"&packmethod1="+packmethod+"&style_id="+style_id+"&schedule_id="+schedule_id;
        }
      
    </script>
    <input type="hidden" name="new_cartons" id="new_cartons">
    <?php
        if (isset($_GET['carton']))
        {
            $style_id = $_GET['style_id'];
            $schedule_id = $_GET['schedule_id'];
            $cartons = $_GET['carton'];
            $style = $_GET['style1'];
            $schedule = $_GET['schedule1'];
            $packmethod = $_GET['packmethod1'];
            if ($cartons != '' || $cartons != null)
            {
                $test = substr($cartons,0,-1);
                $final_cartons=explode(',', $test);
                
                $seq = substr($packmethod,0,1);
                $packm = substr($packmethod,-1);

                $wout_min=array();
                $id1=$final_cartons;
                $count1=count($id1);
                if(sizeof($final_cartons)>1)
                {
                    $mincart=min($id1);
                    for($i = 0; $i<sizeof($id1); $i++)
                    {
                        if($id1[$i] != $mincart)
                        {
                            $wout_min[]= $id1[$i];
                        }
                    }
                    $carton=implode(",",$wout_min);
                    $getmincartdetails="select carton_no,doc_no_ref from $bai_pro3.pac_stat_log where style='$style' AND schedule='$schedule' AND carton_no='$mincart' AND seq_no='$seq' AND pack_method='$packm'";
                    // echo $getmincartdetails.'<br>';
                    $cartdetrslt=mysqli_query($link, $getmincartdetails) or die("Error while getting min cart details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($cartrow=mysqli_fetch_array($cartdetrslt))
                    {
                        $cartno=$cartrow['carton_no'];
                        $docnoref=$cartrow['doc_no_ref'];
                    }
                    $updatedetails="update $bai_pro3.pac_stat_log set doc_no_ref='$docnoref',carton_no='$cartno' where style='$style' AND schedule='$schedule' AND carton_no in ($carton) AND seq_no='$seq' AND pack_method='$packm'";
                    $result12=mysqli_query($link, $updatedetails) or die("Error while updating carton details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<script>sweetAlert('Packing Jobs Clubbed','Sucessfully','success');</script>";
                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1500);
						function Redirect() 
						{
							location.href = \"".getFullURLLevel($_GET['r'], "carton_club_drag_drop.php", "0", "N")."&style=$style_id&schedule=$schedule_id&packmethod=$packmethod\";
						}
						</script>";
                }
                else
                {
                    echo "<script>sweetAlert('Cannot Club Single Carton','','warning');</script>";
                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1500);
						function Redirect() 
						{
							location.href = \"".getFullURLLevel($_GET['r'], "carton_club_drag_drop.php", "0", "N")."&style=$style_id&schedule=$schedule_id&packmethod=$packmethod\";
						}
						</script>";
                }
            }
            else
            {
                echo "<script>sweetAlert('No Cartons Added to Club','','warning');</script>";
                echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1500);
					function Redirect() 
					{
						location.href = \"".getFullURLLevel($_GET['r'], "carton_club_drag_drop.php", "0", "N")."&style=$style_id&schedule=$schedule_id&packmethod=$packmethod\";
					}
					</script>";
            }
            
                
        }
    ?>

</body>
</html>