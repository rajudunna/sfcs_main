<?php
if(isset($_GET['lay_id']))
{
	$lay_id = $_GET['lay_id'];
	if($lay_id != '')
	{
		getLayDetails($lay_id);
	}
}
function getLayDetails($lay_id)
{
    include("../../../../common/config/config_ajax.php");
    $get_lay_details = " SELECT lp_roll_id,lay_sequence,roll_no, roll.plies AS roll_plies, lay.jm_docket_id  FROM $pps.lp_lay lay LEFT JOIN $pps.`lp_roll` roll ON roll.lp_lay_id = lay.lp_lay_id    
    WHERE lay.lp_lay_id = '$lay_id' ORDER BY roll.lay_sequence";
    $docketLineDetails = mysqli_query($link,$get_lay_details);
    $table_data =  "<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>Roll Details</b>
        </div>
        <div class='panel-body'>
            <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'>
                <thead>
                    <th>Roll No</th>
                    <th>Lay Sequence</th>
                    <th>Roll Plies</th>
                    <th>Reverse Plies</th>
                </thead>";
                $s_no = 1;
                while($row = mysqli_fetch_array($docketLineDetails)){
                    $id = '"'.$row['lp_roll_id'].'"';
                    $docket_id = $row['jm_docket_id'];
                    $table_data .= "<tr><td>".$row['roll_no']."</td>";
                    $table_data .= "<td>".$row['lay_sequence']."</td>";
                    $rem_string = $row['lp_roll_id'].'rems';
                    $table_data .= "<td id='$rem_string'>".$row['roll_plies']."</td>";
                    $table_data .= "<td><input class='form-control integer' type = 'Number' name='reverseVal[]' value='0' min='0' id=$id onchange='validatingReverseQty($id)' onkeyup='return  isInt(this);'></td></tr>";
                    $table_data .= "<input type='hidden' name='roll_ids[]' value='$id'>";
                    $table_data .= "<input type='hidden' name='lay_id' value='$lay_id'>";
                    $table_data .= "<input type='hidden' name='docket_number' value='$docket_id'>";
                    $s_no++;
                }
                $table_data .= "</div>
    </div>
    </div>";
    echo $table_data;
}

?>