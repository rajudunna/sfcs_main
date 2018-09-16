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
           // $style_ori = echo_title("$brandix_bts.tbl_orders_style_ref","product_style","id",$style,$link); 
            //$schedule_ori = echo_title("$brandix_bts.tbl_orders_master","product_schedule","id",$schedule,$link);
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
                                $sql="select * from $bai_pro3.pac_stat group by style order by style*1";
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error2");
                                $sql_num_check=mysqli_num_rows($sql_result);
                                echo "<option value=''>Please Select</option>";
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    if(str_replace(" ","",$sql_row['style'])==str_replace(" ","",$style))
                                    {
                                        echo "<option value=\"".$sql_row['style']."\" selected>".$sql_row['style']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=\"".$sql_row['style']."\">".$sql_row['style']."</option>";
                                    }
                                }
                                echo "</select>
                                &nbsp;
                            <label>Schedule:</label>";
                                // Schedule
                                echo "<select class='form-control' name=\"schedule\" onchange=\"secondbox();\" id=\"schedule\"  required>";
                                $sql="select schedule from $bai_pro3.pac_stat where style='".$style."' group by schedule order by schedule*1";
                                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                                $sql_num_check=mysqli_num_rows($sql_result);
                                echo "<option value=''>Please Select</option>";
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    if(str_replace(" ","",$sql_row['schedule'])==str_replace(" ","",$schedule))
                                    {
                                        echo "<option value=\"".$sql_row['schedule']."\" selected>".$sql_row['schedule']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=\"".$sql_row['schedule']."\">".$sql_row['schedule']."</option>";
                                    }
                                }
                                echo "</select>&nbsp;&nbsp;";
								echo "<label>Pack Method:</label> 
                                    <select class='form-control' name=\"packmethod\"  id='packmethod' required>";
                                        $sql="SELECT seq_no,pack_method,pack_description FROM $bai_pro3.pac_stat 
										LEFT JOIN tbl_pack_ref ON tbl_pack_ref.schedule=pac_stat.schedule 
										LEFT JOIN tbl_pack_size_ref ON tbl_pack_ref.id=tbl_pack_size_ref.parent_id AND pac_stat.pac_seq_no=tbl_pack_size_ref.seq_no
										WHERE pac_stat.schedule='$schedule' GROUP BY pac_seq_no ORDER BY pac_seq_no*1";  
                                        $sql_result=mysqli_query($link, $sql) or exit("Sql Error");
                                        echo "<option value=''>Please Select</option>";
                                        while($row=mysqli_fetch_array($sql_result))
                                        {                                            
											if($row['seq_no']."-".$row['pack_method']==$packmethod)
                                            {
                                                echo "<option value=\"".$row['seq_no']."-".$row['pack_method']."\" selected>".$row['pack_description']."-".$operation[$row['pack_method']]."</option>";
                                            }
                                            else
                                            {
                                                echo "<option value=\"".$row['seq_no']."-".$row['pack_method']."\">".$row['pack_description']."-".$operation[$row['pack_method']]."</option>";
                                            }
                                        }
                                    
                                    echo "</select>";
                            ?>
                            &nbsp;&nbsp;
                            <input type="submit" name="submit" id="submit" class="btn btn-success " value="Submit">
                        </form>
                    </div>

                <?php
                    if(isset($_POST['submit']))
                    { 
                        $style = $_POST['style'];
                        $schedule = $_POST['schedule'];
                        $packmethod = $_POST['packmethod'];
						$seq = substr($packmethod,0,1);
						$packm = substr($packmethod,-1);
						$schedule_id = echo_title("$brandix_bts.tbl_orders_master","id","product_schedule",$schedule,$link);
						$style_id = echo_title("$brandix_bts.tbl_orders_style_ref","id","product_style",$style,$link); 
				        echo '
                            <input type="hidden" name="style_id" id="style" value="'.$style.'">
                            <input type="hidden" name="schedule_id" id="schedule" value="'.$schedule.'">
                           <input type="hidden" name="packmethod" id="packmethod" value="'.$packmethod.'">';

                        $carton_no = array();   $status = array();  $carton_mode=array();   $doc_no_ref = array();  $colors = array();  $sizes = array();  $carton_qty = array();
                        $get_cartons = "SELECT carton_no, status, carton_mode, pac_stat_id, GROUP_CONCAT(DISTINCT TRIM(size_tit)) AS size ,GROUP_CONCAT(DISTINCT TRIM(order_col_des)) AS color,sum(carton_act_qty) as qty FROM bai_pro3.packing_summary WHERE order_del_no=$schedule and seq_no=$seq group by carton_no*1";
						$carton_result=mysqli_query($link, $get_cartons) or die("Error"); 
                        while($row=mysqli_fetch_array($carton_result)) 
                        {
                            $colors[]=$row['color'];
                            $sizes[]=$row['size'];
                            $carton_qty[]=$row['qty'];
                            $pac_stat_id[]=$row['pac_stat_id'];
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
                                for ($i=0; $i < sizeof($pac_stat_id); $i++)
                                {
                                    
                                    if ($status[$i] != 'DONE')
                                    {
                                        if ($carton_mode[$i] == 'F')
                                        {
                                            
                                            echo "<li class='btn btn-success' value='".$pac_stat_id[$i]."' title='Color: ".$colors[$i]."\nSize: ".$sizes[$i]."\nQty: ".$carton_qty[$i]."'>Carton - $carton_no[$i]</li>";
                                        }
                                        else
                                        {
                                            echo "<li class='btn btn-warning' value='".$pac_stat_id[$i]."' title='Color: ".$colors[$i]."\nSize: ".$sizes[$i]."\nQty: ".$carton_qty[$i]."'>Carton - $carton_no[$i]</li>";
                                        }
                                    }
                                    else
                                    {
                                        echo "<li class='btn btn-danger unsortable' value='".$pac_stat_id[$i]."' title='Color: ".$colors[$i]."\nSize: ".$sizes[$i]."\nQty: ".$carton_qty[$i]."'>Carton - $carton_no[$i]</li>";
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
            var style = document.getElementById('style').value;
            var schedule = document.getElementById('schedule').value;
            var packmethod = document.getElementById('packmethod').value;
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
            window.location.href =url12+"&carton="+new_car+"&style="+style+"&schedule="+schedule+"&packmethod="+packmethod;
        }
      
    </script>
    <input type="hidden" name="new_cartons" id="new_cartons">
    <?php
        if (isset($_GET['carton']))
        {
            $style = $_GET['style'];
            $schedule = $_GET['schedule'];
            $cartons = $_GET['carton'];
            $packmethod = $_GET['packmethod'];
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
                    $updatedetails="update $bai_pro3.pac_stat_log set pac_stat_id='$mincart' where pac_stat_id in ($carton)";
                    $result12=mysqli_query($link, $updatedetails) or die("Error while updating carton details".mysqli_error($GLOBALS["___mysqli_ston"]));
					$delete="delete from $bai_pro3.pac_stat where id in ($carton)";
                    $result12=mysqli_query($link, $updatedetails) or die("Error while updating carton details".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<script>sweetAlert('Packing Jobs Clubbed','Sucessfully','success');</script>";
                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1500);
						function Redirect() 
						{
							location.href = \"".getFullURLLevel($_GET['r'], "carton_club_drag_drop.php", "0", "N")."&style=$style&schedule=$schedule&packmethod=$packmethod\";
						}
						</script>";
                }
                else
                {
                    echo "<script>sweetAlert('Cannot Club Single Carton','','warning');</script>";
                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1500);
						function Redirect() 
						{
							location.href = \"".getFullURLLevel($_GET['r'], "carton_club_drag_drop.php", "0", "N")."&style=$style&schedule=$schedule&packmethod=$packmethod\";
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
						location.href = \"".getFullURLLevel($_GET['r'], "carton_club_drag_drop.php", "0", "N")."&style=$style&schedule=$schedule&packmethod=$packmethod\";
					}
					</script>";
            }
            
                
        }
    ?>

</body>
</html>