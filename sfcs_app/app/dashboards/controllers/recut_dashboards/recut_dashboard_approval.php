<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
error_reporting(0);
if(isset($_POST['formSubmit']))
{
   $order_tid=$_POST['order_tid'];
   $status=$_POST['status'];
   $doc_nos=$_POST['doc_no_ref'];
   $codes=$_POST['code_no_ref'];
   $hostname=explode(".",gethostbyaddr($_SERVER['REMOTE_ADDR']));
   $add_query="";
   if($status==1)
   {
       $add_query=", lastup=\"".date("Y-m-d H:i:s")."\" ";
   }
   $sql1="update $bai_pro3.recut_v2 set fabric_status=$status $add_query where doc_no = '$doc_nos'";
   mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
   $sql2="update $bai_pro3.plandoc_stat_log set fabric_status=$status $add_query where doc_no = '$doc_nos'";
   mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
   $sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
   //echo $sql;
   mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
   $url = '?r='.$_GET['r'];
   if($status == 1)
   {
        echo "<script>sweetAlert('Successfully Approved','','success');window.location = '".$url."'</script>";
   }
   else
   {
    echo "<script>sweetAlert('Material Not Available to Approve','','error');window.location = '".$url."'</script>";
   }
  
}
?>
<?php
$shifts_array = ["NotApproved","Approved"];
$drp_down = '<div class="row"><div class="col-md-3"><label>Status Filter:</label>
<select class="form-control rm"  name="status" id="rm" style="width:100%;" onchange="myFunction()" required>';
for ($i=0; $i <= 1; $i++) 
{
    $drp_down .= '<option value='.$shifts_array[$i].'>'.$shifts_array[$i].'</option>';
}
$drp_down .= "</select></div>";
$drp_down .= "<div class='col-md-3'><label>Schedule Filter:</label>
              <input class='form-control integer' placeholder='Enter Schedule here' onchange='myfunctionsearch()' id='schedule_id'></input></div></div>";
echo $drp_down;
?>
</br></br>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">Recut Detailed View
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id='main-content'>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Markers view
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
                    <div class='panel-body' id="dynamic_table_panel">	
                            <div id ="dynamic_table1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>Re Cut Approval Dashboard - View</b>
        </div>
        <div class='panel-body'>
           <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Quantity</th><th>Recut Reported Quantity</th><th>Eligibility to Issue Quantity</th><th>View recut</th><th>Markers view</th><th>Approval</th>
            </thead>
            <?php  
            $s_no = 1;
            $blocks_query  = "SELECT fabric_status,SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`style_id`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule
            FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            LEFT JOIN bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            WHERE r.mk_ref != '0'
            GROUP BY parent_id";
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');        
            while($row = mysqli_fetch_array($blocks_result))
            {
                $id = $row['doc_no'];
                if($row['fabric_status'] == '1')
                {
                    $button_html = "<b style='color:red;'>Approved</b>";
                    $html_hiding = "Approved";
                }
                else
                {
                    $button_html = "<button type='button'class='btn btn-danger' onclick='viewmarkerdetails(".$id.",1)'>Approve</button>";
                    $html_hiding = "NotApproved";
                }
                echo "<tr><td>$s_no</td>";
                echo "<td>".$row['doc_no']."</td>";
                echo "<td>".$row['style']."</td>";
                echo "<td>".$row['schedule']."</td>";
                echo "<td>".$row['color']."</td>";
                echo "<td>".$row['rejected_qty']."</td>";
                echo "<td>".$row['recut_qty']."</td>";
                echo "<td>".$row['recut_reported_qty']."</td>";
                echo "<td>".$row['issued_qty']."</td>";
                echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>Recut View</button></td>";
                echo "<td><button type='button'class='btn btn-success' onclick='viewmarkerdetails(".$id.",2)'>Marker View</button></td>";
                echo "<td style='display:none'>$html_hiding</td>"; 
                echo "<td>$button_html</td>"; 
                echo "</tr>";
                $s_no++;
            }
            ?>
             </table>
             <div id='myTable1' style='diplay:none;'>
                <b style='color:red'>No Records Found</b>
             </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() 
{
    myFunction();
});
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal').modal('toggle');
    $.ajax({

			type: "POST",
			url: function_text+"?recut_doc_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('main-content').innerHTML = response;
            }

    });

}
function viewmarkerdetails(id,flag)
{
    $('#myModal1').modal('toggle');
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    var id_array = [id,flag];
    $.ajax({

			type: "POST",
			url: function_text+"?markers_view_docket="+id_array,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
               
            }

    });

}
function myFunction() 
{
    var input, filter, table, tr, td, i;
    input = document.getElementById("rm").value;
    filter = input.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var count = 0;
    if(tr.length > 1)
    {
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[11];
            if(td) 
            {
                if(td.innerHTML.toUpperCase() == filter)
                {
                    tr[i].style.display = "";
                } 
                else 
                {
                    count++;
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // if(count == 1)
    // {
    //     $('#myTable').hide();
        // $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
        $('#myTable1').hide();
    // }
}
function myfunctionsearch() 
{
    var input, filter, table, tr, td, i;
    input = document.getElementById("schedule_id").value;
    filter = input.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var count = 0;
    if(tr.length > 1)
    {
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[3];
            if(td) 
            {
                console.log(td.innerHTML.toUpperCase());
                console.log(filter);
                if(td.innerHTML.toUpperCase() == filter)
                {
                    console.log(tr[i]);
                    tr[i].style.display = "";
                } 
                else 
                {
                    count++;
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // console.log(count);
    // if(count == 0)
    // {
    //     $('#myTable').hide();
    //     $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
    //     $('#myTable1').hide();
    // }
}
</script>