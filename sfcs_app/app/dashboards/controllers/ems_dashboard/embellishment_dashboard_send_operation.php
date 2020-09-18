<?php
// $double_modules=array();
// include($_SERVER['DOCUMENT_ROOT'].'template/helper.php');
// $php_self = explode('/',$_SERVER['PHP_SELF']);
// array_pop($php_self);
// $url_r = base64_encode(implode('/',$php_self)."/embellishment_dashboard_send_operation.php");
// $has_permission=haspermission($url_r); 
?>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#schedule,#docket').keypress(function(e) {
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

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 4, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/functions_v2.php', 4, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/functions.php', 4, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/group_def.php', 4, 'R'));
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/enums.php', 4, 'R'));
set_time_limit(200000);
$session_plant_code = $_SESSION['plantCode'];
// $session_plant_code = 'AIP';
$username =  $_SESSION['userName'];
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<!-- <head> -->
<title>EMS Dashboard</title>
<link rel="stylesheet" href="../../../../common/css/bootstrap.min.css">
<?php
$hour = date("H.i");
//echo '<META HTTP-EQUIV="refresh" content="120">';
?>
<script type="text/javascript" src="../../../../common/js/jquery.js"></script>
<script type="text/javascript">
  <!--
  spe = 700;
  na = document.all.tags("blink");
  swi = 1;
  bringBackBlinky();

  function bringBackBlinky() {
    if (swi == 1) {
      sho = "visible";
      swi = 0;
    } else {
      sho = "hidden";
      swi = 1;
    }
    for (i = 0; i < na.length; i++) {
      na[i].style.visibility = sho;
    }
    setTimeout("bringBackBlinky()", spe);
  }
  -->
  function
  redirect_view()
  {
  y
  =
  document.getElementById('view_div').value;
  window.location
  =
  "<?= getFullURL($_GET['r'], 'embellishment_dashboard_send_operation.php', 'N') ?>"
  +
  "&view=2&view_div="
  +
  y;
  }
  function
  redirect_dash()
  {
  x
  =
  document.getElementById('view_cat').value;
  y
  =
  document.getElementById('view_div').value;
  z
  =
  document.getElementById('view_dash').value;
  window.location
  =
  "<?= getFullURL($_GET['r'], 'embellishment_dashboard_send_operation.php', 'N') ?>"
  +
  "&view="
  +
  z
  +
  "&view_cat="
  +
  x
  +
  "&view_div="
  +
  y;
  }
  function
  blink_new3(x)
  {
  $("div[id='S"
  +
  x
  +
  "']").each(function()
  {
  $(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
  });
  }
  function
  blink_new(x)
  {
  $("div[id='D"
  +
  x
  +
  "']").each(function()
  {
  $(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
  });
  }
</script>

<style>
  /*blink css for req time exceeding */
  @-webkit-keyframes blinker {
    from {
      opacity: 1.0;
    }

    to {
      opacity: 0.0;
    }
  }

  .blink {
    text-decoration: blink;
    -webkit-animation-name: blinker;
    -webkit-animation-duration: 0.6s;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: ease-in-out;
    -webkit-animation-direction: alternate;
  }

  body {
    background-color: #eeeeee;
    color: #000000;
    font-family: Arial;
  }

  a {
    text-decoration: none;
  }

  table {
    border-collapse: collapse;
  }

  .new td {
    border: 1px solid red;
    white-space: nowrap;
    border-collapse: collapse;
  }

  .new th {
    border: 1px solid red;
    white-space: nowrap;
    border-collapse: collapse;
  }

  .bottom th,
  td {
    border-bottom: 1px solid white;
    padding-bottom: 5px;
    padding-top: 5px;
  }

  a {
    text-decoration: none;
    color: white;
  }

  .orange {
    max-width: 130px;
    min-width: 20px;
    height: 20px;
    background-color: #FFA500;
    display: block;
    float: left;
    margin: 2px;
    border: 1px solid #000000;
    height: 25px;
    width: 250px;
    /* padding: 4px; */
  }

  .orange a {
    display: block;
    float: left;
    width: 100%;
    height: 100%;
    text-decoration: none;
  }

  .orange a:hover {
    text-decoration: none;
    background-color: #FFA500;
  }

  .red {
    max-width: 130px;
    min-width: 20px;
    height: 20px;
    background-color: #FF0000;
    display: block;
    float: left;
    margin: 2px;
    border: 1px solid #000000;
    height: 25px;
    width: 250px;
    /* padding: 4px; */
  }

  .red a {
    display: block;
    float: left;
    width: 100%;
    height: 100%;
    text-decoration: none;
  }

  .red a:hover {
    text-decoration: none;
    background-color: #FF0000;
  }

  .blue {
    max-width: 130px;
    min-width: 20px;
    height: 20px;
    background-color: #15a5f2;
    display: block;
    float: left;
    margin: 2px;
    border: 1px solid #000000;
    height: 25px;
    width: 250px;
    /* padding: 4px; */
  }

  .blue a {
    display: block;
    float: left;
    width: 100%;
    height: 100%;
    text-decoration: none;
  }

  .blue a:hover {
    text-decoration: none;
    background-color: #15a5f2;
  }


  .yash {
    max-width: 130px;
    min-width: 20px;
    height: 20px;
    background-color: #999999;
    display: block;
    float: left;
    margin: 2px;
    border: 1px solid #000000;
    height: 25px;
    width: 250px;
    /* padding: 4px; */
  }

  .yash a {
    display: block;
    float: left;
    width: 100%;
    height: 100%;
    text-decoration: none;
  }

  .yash a:hover {
    text-decoration: none;
    background-color: #999999;
  }
</style>
<?php

echo "<div style='width=100%;'>";

if ($_GET['view'] == 1) {
  echo "<font color=yellow> - Quick View</font>";
}
if ($_GET['view'] == 3) {
  echo "<font color=yellow> - Cut View</font>";
}
echo "</font>";

echo '<div class="panel panel-primary">';

echo "<div class='panel-heading'><span style='float'><strong>EMB Send Dashboard</strong></a>
</span><span style='float: right; margin-top: 0px'><b>
<a href='javascript:void(0)' onclick='Popup=window.open('cps.htm" . "','Popup',
'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); 
if (window.focus) {Popup.focus()} return false;'></a></b></span></div>";
echo '<div class="panel-body">
<div class="form-inline">';
echo '<div class="form-group">';
echo '&nbsp;&nbsp;&nbsp;Shift: 
  <select class="form-control" id="shift" name="shift">
  <option value="">Select</option>';
$shifts = (isset($_GET['shift'])) ? $_GET['shift'] : '';
foreach ($shifts_array as $shift) {
  if ($shift == $shifts) {
    echo "<option value='$shift' selected>$shift</option>";
  } else {
    echo "<option value='$shift'>$shift</option>";
  }
}
echo '</select>   
</div>
<div class="form-group">';
echo 'Docket Track: <input type="text" name="docket" id="docket" class="form-control" onkeyup="blink_new(this.value)" size="10">&nbsp;&nbsp;&nbsp;';
echo "</div>";
echo '<div class="form-group">';
echo 'Schedule Track: <input type="text" name="schedule" id="schedule" class="form-control" onkeyup="blink_new3(this.value)" size="10">';
echo "</div>";

// echo '<div class="form-group">';
// echo '&nbsp;&nbsp;&nbsp;Buyer Division: 
// <select name="view_div" id="view_div" class="form-control" onchange="redirect_view()">';
// if ($_GET['view_div'] == "ALL") {
//   echo '<option value="ALL" selected>All</option>';
// } else {
//   echo '<option value="ALL">All</option>';
// }
// echo "</div>";
// echo "</div>";

// $sqly = "SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
// $sql_resulty = mysqli_query($link, $sqly) or exit("Sql Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
// while ($sql_rowy = mysqli_fetch_array($sql_resulty)) {
//   $buyer_div = $sql_rowy['buyer_div'];
//   $buyer_name = $sql_rowy['buyer_name'];

//   if (urldecode($_GET["view_div"]) == "$buyer_name") {
//     echo "<option value='" . $buyer_name . "' selected>" . $buyer_div . "</option>";
//   } else {
//     echo "<option value='" . $buyer_name . "' >" . $buyer_div . "</option>";
//   }
// }
// echo '</select>';
// echo '</div>';
// echo '<br><br>';
?>
<div>
    <div
        style="margin-top: 4px;border: 1px solid #000;float: left;background-color: #FFA500;color: white;margin-left: 10px;">
        <div>Partially Send to Embellishment Jobs</div>
    </div>&nbsp;&nbsp;&nbsp;
    <div
        style="margin-top: 4px;border: 1px solid #000;float: left;background-color: #15a5f2;color: white;margin-left: 30px;">
        <div>Cut Completed Jobs</div>
    </div>
    <div
        style="margin-top: 4px;border: 1px solid #000;float: left;background-color: #999999;color: white;margin-left: 30px;">
        <div>Cut Not Completed Jobs</div>
    </div>
    <div style="clear: both;"> </div>
</div>

<?php
//For blinking priorties as per the section module wips
$bindex = 0;
$blink_docs = array();

/** Getting work stations based on department wise
 * @param:department,plantcode
 * @return:workstation
 **/
$result_worksation_id = getWorkstations(DepartmentTypeEnum::EMBELLISHMENT, $session_plant_code);

$workstations = $result_worksation_id['workstation'];
// $sqlx="select * from $bai_pro3.tbl_emb_table where emb_table_id>0";
// mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// while($sql_rowx= $embelishment_tables)
foreach ($workstations as $emb_key => $emb_value) {


  echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;">';
  echo "<p>";
  echo "<table>";
  echo "<tr><th colspan=2'><center><h2><b>$emb_value</b></h2></center></th></tr>";

  // $blink_minimum=0;
  // {
  // $module=$mods[$x];
  // $blink_check=0;

  echo "<tr class='bottom'><td>";

  // to get all planned jobs
  $result_planned_jobs = getPlannedJobs($emb_key, TaskTypeEnum::EMBELLISHMENTJOB, $session_plant_code);

  $job_number = $result_planned_jobs['job_number'];
  $task_header_id = $result_planned_jobs['task_header_id'];
  $task_job_ids = $result_planned_jobs['task_job_ids'];
  $task_job_header_log = $result_planned_jobs['task_header_log_time'];

  foreach ($task_job_ids as $task_job_id => $task_header_id_j) {
    $log_time = $task_job_header_log[$task_header_id_j];
    $emb_job_no = $job_number[$task_header_id_j];
    //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK HEADER ID
    $job_detail_attributes = [];
    $qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id ='$task_job_id' and plant_code='$session_plant_code'";
    // echo $qry_toget_style_sch."<br/>";

    $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
    if (mysqli_num_rows($qry_toget_style_sch_result) > 0) {

      while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {

        $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
      }
      $style1 = $job_detail_attributes[$sewing_job_attributes['style']];
      $colors_db = $job_detail_attributes[$sewing_job_attributes['color']];
      $co_no = $job_detail_attributes[$sewing_job_attributes['cono']];
      $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
      $club_c_code = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
      $club_docs = $job_detail_attributes[$sewing_job_attributes['docketno']];
      $job_num = $job_detail_attributes[$sewing_job_attributes['embjobno']];


      $task_job_trans = "SELECT * FROM $tms.task_job_transaction where task_jobs_id ='$task_job_id'  order by operation_seq ASC limit 0,1";
      $task_job_trans_result = mysqli_query($link_new, $task_job_trans) or exit("Sql Error at task_job_trans_result" . mysqli_error($GLOBALS["___mysqli_ston"]));
      if (mysqli_num_rows($task_job_trans_result) > 0) {

        while ($row_res = mysqli_fetch_array($task_job_trans_result)) {
          $orginal_qty = $row_res['original_quantity'];
          $good_qty = $row_res['good_quantity'];
          $rej_qty = $row_res['rejected_quantity'];
          $operation_code = $row_res['operation_code'];
          $operation_seq = $row_res['operation_seq'];
        }
        $task_job_trans2 = "SELECT * FROM $tms.task_job_transaction where task_jobs_id ='$task_job_id' and operation_seq < $operation_seq order by operation_seq DESC limit 0,1";
        $task_job_trans2_result = mysqli_query($link_new, $task_job_trans2) or exit("Sql Error at task_job_trans2_result123" . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row_res2 = mysqli_fetch_array($task_job_trans2_result)) {
          $send_qty = $row_res2['good_quantity'];
        }

        $id = "yash";
        if ($good_qty == 0) {
          $id = "yash";
        }

        if ($orginal_qty != $good_qty && $good_qty > 0) {
          $id = "orange";
        }
        if ($good_qty > $send_qty) {
          $id = "red";
        }

        $type = 'embellishment';
        // sfcs_app\app\production\controllers\embellishment_job\embellishment_job_scaning\scan_jobs.php
        $emb_url = getFullURLLevel($_GET["r"], 'production/controllers/embellishment_job/embellishment_job_scaning/scan_jobs.php', 3, 'N')."&input_job_no_random_ref=$emb_job_no&plant_code=$session_plant_code&type=$type&operation_id=$operation_code&style=$style1&schedule=$schedule&color=$colors_db&barcode_generation=1";
        $title = str_pad("Style:" . trim($style1), 80) . "\n" . str_pad("CO:" . trim($co_no), 80) . "\n" . str_pad("Schedule:" . $schedule, 80) . "\n" . str_pad("Color:" . trim($colors_db), 50) . "\n" . str_pad("Cut_No:" . trim($club_c_code), 80) . "\n" . str_pad("DOC No:" . trim($club_docs), 80) . "\n" . str_pad("Total Plan Qty:" . $orginal_qty, 80) . "\n" . str_pad("Actual Cut Qty:" . $total, 80) . "\n" . str_pad("Send Qty:" . ($send_qty), 80) . "\n" . str_pad("Received Qty:" . ($good_qty), 80) . "\n" . str_pad("Rejected Qty:" . $rej_qty, 80) . "\n" . str_pad("Plan_Time:" . $log_time, 50) . "\n";

        echo "<div id=\"S$schedule\" style=\"float:left;\"><div id='D$doc_no' class='$id' style='font-size:12px;color:white; text-align:center; float:left;' title='$title'><span onclick=\"loadpopup('$emb_url')\" style='cursor:pointer;'>$schedule(" . $club_c_code . ")-OP:$operation_code</span></div></div><br>";
      }
    }
  }
  echo "</td>";
  echo "</tr>";
  echo "</div>";
  echo "</table>";
  echo "</p>";
  echo '</div>';
}

if ((in_array($authorized, $has_permission))) {
  echo "<script>";
  echo "blink_new_priority('" . implode(",", $blink_docs) . "');";
  echo "</script>";
}
?>

<div style="clear: both;"> </div>
</br>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'cps.htm', 0, 'R'));
?>

<?php
((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res);
((is_null($___mysqli_res = mysqli_close($link_new))) ? false : $___mysqli_res);
?>

<script>
  function loadpopup(url) {
    var shift = document.getElementById('shift').value;
    if (shift) {
      url = url + '&shift=' + shift;
      window.open(url, 'Popup', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23');
      if (window.focus) {
        Popup.focus()
      }
      return false;
    } else {
      swal({
        title: "Warning!",
        text: "Please select shift",
        type: "warning"
      }).then(function() {
        // window.close();
      });
    }
  }
  setTimeout(function() {
    var shift = document.getElementById('shift').value;
    var url = window.location.href + '&shift=' + shift;
    if (shift) {
      window.location.href = url;
    }
  }, 120000);
</script>