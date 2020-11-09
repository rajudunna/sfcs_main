<style type="text/css">
    div.ex3 {
        width: 100%;    
        overflow-y: auto;
    }
    table, th, td {
        text-align: center;
    }
</style>


<?php

        include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
        include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
        include(getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
        $style=$_GET['style'];
        $schedule=$_GET['schedule'];
        $color=$_GET['color'];
        $mpo=$_GET['mpo'];
        $sub_po=$_GET['sub_po'];
        $plant_Code = $_SESSION['plantCode'];

        // $schedule = $_GET['schedule'];
        // $seq_no = $_GET['seq_no'];
        // $style = $_GET['style'];
        // $style = style_decode($_GET['style']);
        // //Encoded Style
        // $main_style = style_encode($style);

        $url1 = getFullURLLevel($_GET['r'],'print_input_sheet.php',0,'R');
        $url2 = getFullURLLevel($_GET['r'],'print_input_sheet_mm.php',0,'R');
        //To get Sub PO Description
        $result_po_des=getPoDetaials($sub_po,$plant_Code);
        $subpo_des=$result_po_des['po_description'];
        echo '<br>
            <div class="panel panel-primary">
                <div class="panel-heading">Sewing Jobs for Schedule - '.$schedule.' & Sub Po - '.$subpo_des.'</div>
                <div class="panel-body">
                    <div class="col-md-12 ">';       
                        echo "<a class='btn btn-warning' href='$url1?&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po&plant_code=$plant_Code&flag=1' onclick=\"return popitup2('$url1?&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po&plant_code=$plant_Code&flag=1')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print Ratio Sheet - Job Wise</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo "<a class='btn btn-warning' href='$url2?style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po&plant_code=$plant_Code' onclick=\"return popitup2('$url2?style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po&plant_code=$plant_Code')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print Ratio Sheet - Split Wise</a>";
                    echo '</div>
                </div>
            </div>';
?>
