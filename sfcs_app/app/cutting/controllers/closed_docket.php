<?php 
include("../../../common/config/config_ajax.php");
$plantcode=$_SESSION['plantCode'];
if(isset($_GET['date']))
{
    $query = "select id,style,schedule,color,tot_bindreq_qty from $pps.binding_consumption where plant_code='".$plantcode."' and status='Close' and date(status_at)='".$_GET['date']."'";
    $sql_result = mysqli_query($link,$query);

    $response_table = '<tr>
                        <th>SNo.</th>
                        <th>Style</th>
                        <th>Schedule</th>
                        <th>Color</th>
                        <th>Total Required Quantity</th>
                        <th>Print</th>
                    </tr>';
    $index=0;
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $i = $sql_row['id'];
        $docket_query = "select doc_no from $pps.binding_consumption_items where parent_id='$i' and plant_code='".$plantcode."'";
                                    $docket_query_result = mysqli_query($link_new,$docket_query);
                                    while($sql_row1=mysqli_fetch_array($docket_query_result))
                                    {
                                        $docket_number = $sql_row1['doc_no'];
                                    }
        $path = '../../../sfcs_app/app/cutting/controllers/lay_plan_preparation/book3_print_binding.php'; 
        $index+=1;
        $response_table.= "<tr><td data-toggle='modal' data-target='#myModal$i'><input type='hidden' id='row_id-$i' value='$i'><span class='label label-info fa fa-list fa-xl' >&nbsp;&nbsp;&nbsp;$index</span></td>";
        $response_table.= "<td>".$sql_row['style']."</td>";
        $response_table.= "<td>".$sql_row['schedule']."</td>";
        $response_table.= "<td>".$sql_row['color']."</td>";
        $response_table.= "<td>".$sql_row['tot_bindreq_qty']."</td>";
        // $response_table.= "<td>".$sql_row['tot_bindreq_qty']."</td>";
        $response_table.= "<td><a href=\"$path?binding_id=$i&docket_number=$docket_number\" onclick=\"Popup1=window.open('$path?binding_id=$i&plant_code=$plantcode&username=$username&docket_number=$docket_number','Popup1','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup1.focus()} return false;\" class='btn btn-warning btn-xs'><i class='fa fa-print'></i>&nbsp;Print</a></td>";
        $response_table.= "</tr>";
    }
    if($index == 0){
        $response_table.= "<tr><td colspan=7> No data Found</td></tr>";
    }
    
    echo $response_table;
}
?>