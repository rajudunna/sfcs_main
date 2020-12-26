<style>
th,td{
   text-align:center;
}
.btn{
   float:right;
}
body {
  background: #FFF url("sfcs_app/common/img/bootstrap-colorpicker/KheAuef.png") top left repeat-x;
}

.page    { display: none; padding: 0 0.5em; }
.page h1 { font-size: 2em; line-height: 1em; margin-top: 1.1em; font-weight: bold; }
.page p  { font-size: 1.5em; line-height: 1.275em; margin-top: 0.15em; }

#loading {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 100;
  width: 100vw;
  height: 100vh;
  background-color: rgba(192, 192, 192, 0.5);
  background-image: url("sfcs_app/common/img/bootstrap-colorpicker/MnyxU.gif");
  background-repeat: no-repeat;
  background-position: center;
}
table
{
	font-family:calibri;
	font-size:15px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: center;
	white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
	white-space:nowrap; 
}
table th
{
	border: 1px solid black;
	text-align: center;
	background-color: #337ab7;
	border-color: #337ab7;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:15px;
}
#reset_example1{
	width : 50px;
	color : #ec971f;
	margin-top : 10px;
	margin-left : 0px;
	margin-bottom:15pt;
}
</style>
<script>
$(document).ready(function()
{
   $("#sdate").prop("disabled",true);
   $("#edate").prop("disabled",true);
   $("#schedule").prop("disabled",true);

   $("#val1").change(function()
   {
      var vall1 = $("#val1").val();
      if(vall1 == 'date_range')
      {
         $("#sdate").prop("disabled",false);
         $("#edate").prop("disabled",false);
         $("#schedule").prop("disabled",true);
      }
      else if(vall1 == 'schedule_val')
      {
         $("#schedule").prop("disabled",false);
         $("#sdate").prop("disabled",true);
         $("#edate").prop("disabled",true);
      }
      else
      {
         $("#sdate").prop("disabled",true);
         $("#edate").prop("disabled",true);
         $("#schedule").prop("disabled",true);
      }
   });
});
</script>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R')?>"></script>

<script type="text/javascript">

	function check_date()
	{
      var sch_val = document.getElementById("schedule").value;
		var from_date = document.getElementById("sdate").value;
		var to_date   = document.getElementById("edate").value;
		var today = document.getElementById("today").value;
		if (to_date < from_date && from_date != '' && to_date != '')
      {
			sweetAlert("End date should be greater than Start date",'','warning');
			document.getElementById("edate").value = "<?php  echo date("Y-m-d");  ?>";
			document.getElementById("sdate").value = "<?php  echo date("Y-m-d");  ?>";
		}
      if(to_date > today)
      {
			sweetAlert("End date should not be greater than Today",'','warning');
			document.getElementById("edate").value = "<?php  echo date("Y-m-d");  ?>";
		}
	}


</script>
 <div class='panel panel-primary'>
        <div class='panel-heading'>
            <h3 class='panel-title'>M3 Bulk Opration Reconfirm Interface</h3>
        </div>
        <div class='panel-body'>
        <form action="<?= '?r='.$_GET['r']; ?>" method="post">
   <div class='row'>
      <div class='col-sm-2'>
         <label>Select Filter</label><br/>
         <select class="form-control" id="val1" name="val1">
            <option value="">Please Select</option>
            <option value="schedule_val">Schedule</option>
            <option value="date_range">Date Range</option>
         </select>
      </div>   
      <div class='col-sm-2'>
            <label>Schedule</label><br/>
            <input class='form-control' type='text' id='schedule' name='schedule' value="<?= $_POST['schedule'] ?>"/>
      </div>
      <div class="form-group col-sm-3">
            <input type="hidden" name="today" id="today" value="<?php echo date("Y-m-d"); ?>">
            <label>From Date</label><br/>
            <input placeholder="Start Date" type="text" data-toggle='datepicker' id='sdate'  name="dat" onchange="check_date();" class="form-control" size="8" value="<?php  if(isset($_POST['dat'])) { echo $_POST['dat']; }  ?>" required/>
      </div>
      <div class="form-group col-sm-3">
            <label>To Date</label><br/>
            <input placeholder="End Date" type="text"  data-toggle='datepicker' id='edate' name="dat1" onchange="check_date();" size="8" class="form-control" value="<?php  if(isset($_POST['dat1'])) { echo $_POST['dat1']; } ?>" required/>
      </div>
   <div class="form-group col-sm-1">
   <input type="submit" value="submit" class='btn btn-success' name="submit" id="submit" style='margin-top:22px;' >
   </div>
   </div>
   </form>
</div>
</div>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>
<script>
function checkAll()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
}
function onReady(callback) {
  var intervalId = window.setInterval(function() {
    if (document.getElementsByTagName('body')[0] !== undefined) {
      window.clearInterval(intervalId);
      callback.call(this);
    }
  }, 1000);
}

function setVisible(selector, visible) {
  document.querySelector(selector).style.display = visible ? 'block' : 'none';
}

onReady(function() {
  setVisible('.page', true);
  setVisible('#loading', false);
});
</script>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0068",$username,1,$group_id_sfcs); 
?>
<?php 
   if(isset($_POST["submit"]))
   {
      if($_POST["schedule"] != '' || $_POST["dat"] != '' && $_POST["dat1"] != '')
      {
         $shour='00:00:00';
         $ehour='23:59:59';
         $sdate=$_POST['dat'];
         $edate=$_POST['dat1'];
         $schedule=$_POST['schedule'];

         //  $sql="SELECT id,ref_no,response_status,mo_no,m3_bulk_tran_id FROM $bai_pro3.`m3_transactions` WHERE response_status='fail' AND m3_trail_count=4";
         if($schedule != '')
         {
            $sql="SELECT `bai_pro3`.`m3_transactions`.id,m3_trail_count,response_status,op_des,`bai_pro3`.`m3_transactions`.mo_no,m3_bulk_tran_id,m3_ops_code,style,SCHEDULE,color,size,quantity FROM `bai_pro3`.`m3_transactions`  
            LEFT JOIN `bai_pro3`.`mo_details` ON `bai_pro3`.`mo_details`.`mo_no`=`bai_pro3`.`m3_transactions`.`mo_no`
            WHERE `bai_pro3`.`m3_transactions`.`response_status`='fail' AND `bai_pro3`.`m3_transactions`.`m3_trail_count`>=4 and bai_pro3.mo_details.schedule='$schedule' ";
            $msg = "Data for the schedule - ".$schedule;
         }
         else
         {
            $sql="SELECT `bai_pro3`.`m3_transactions`.id,m3_trail_count,response_status,op_des,`bai_pro3`.`m3_transactions`.mo_no,m3_bulk_tran_id,m3_ops_code,style,SCHEDULE,color,size,quantity FROM `bai_pro3`.`m3_transactions`  
            LEFT JOIN `bai_pro3`.`mo_details` ON `bai_pro3`.`mo_details`.`mo_no`=`bai_pro3`.`m3_transactions`.`mo_no`
            WHERE `bai_pro3`.`m3_transactions`.`response_status`='fail' AND `bai_pro3`.`m3_transactions`.`m3_trail_count`>=4 and `bai_pro3`.`m3_transactions`.date_time between \"".$sdate." ".$shour."\" and \"".$edate." ".$ehour."\"";
            $date_1 = $sdate;$date_2 = $edate;
            $date1= strtotime($date_1);$date2= strtotime($date_2);
            $msg = "Data from ".date('d-M-Y', $date1)." to ".date('d-M-Y', $date2);
         }
         // echo $sql;
         // mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
         $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
         $count=mysqli_num_rows($sql_result);
         if($count>0)
         {
            echo '<form action="'.getFullURL($_GET['r'],'export_excel2.php','R').'" method ="post" > 
            <input type="hidden" name="csv_text" id="csv_text">
            <input type="hidden" name="csvname" id="csvname" value="Order Summary Report"><h5 style="color:black;">'.$msg.'</h3>
            <input type="submit" class="btn btn-info" id="expexc" name="expexc" value="Export to Excel" onclick="getCSVData()">
            </form>';
            echo '<div class="panel-body">
                     <div class="table-responsive">
                              <table  id="example1" name="example1" >
                              <tr class="tblheading"><th>S.No</th><th>Mo No</th><th>ID</th><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th><th>Operation</th><th>M3 Operation Code</th><th>Tran_Id</th><th>Failed Reason</th><th>Failed Count</th><th>Response Status</th>';
                        echo  '<th><input type="checkbox" onClick="checkAll()"/>Select All</th>
                        <form action="'.getFullURLLevel($_GET["r"],"m3_transcations_reconfirm_report.php","0","N").'" name="print" method="POST"> </tr> <input type="submit" value="Re-Confirm" class="btn btn-primary">';
            $i=1;
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                  
               $id=$sql_row['id'];
               $m3_bulk_tran_id=$sql_row['m3_bulk_tran_id'];
               $style=$sql_row['style'];
               $m3_ops_code=$sql_row['m3_ops_code'];
               $schedule=$sql_row['SCHEDULE'];
               $color=$sql_row['color'];
               $size=$sql_row['size'];
               $mo_qty=$sql_row['quantity'];
               $trail_count=$sql_row['m3_trail_count'];
               $response_status=$sql_row['response_status']; 
               $op_dec=$sql_row['op_des'];
               // echo $m3_bulk_tran_id; 
               if($style==''){
                  $style="--";
               }else{
                  $style;
               }
               if($schedule==''){
                  $schedule="--";
               }else{
                  $schedule;
               }
               if($m3_ops_code==''){
                  $m3_ops_code='--';
               }else{
                  $m3_ops_code;
               }
               if($color==''){
                  $color="--";
               }else{ 
                  $color;
               } if($size==''){
                  $size="--";
               }else{
                  $size;
               }if($remarks==''){
                  $remarks="--";
               }else{
                  $remarks;
               }if($mo_qty==''){
                  $mo_qty="--";
               }else{
                  $mo_qty;
               }if($response_status=='fail'){
               $response_status='Fail';
               }else{
                  $response_status='--';
               }

               $ndr = "SELECT response_message,transaction_id FROM brandix_bts.`transactions_log` WHERE transaction_id=".$sql_row['m3_bulk_tran_id']." order by sno desc limit 1";
               $sql_result1=mysqli_query($link, $ndr) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
               while($sql_row1=mysqli_fetch_array($sql_result1))
               {
                     $response=$sql_row1['response_message'];
                     $tran_id=$sql_row1['transaction_id'];
               }
               echo "<tr><td>".$i++."</td><td>".$sql_row['mo_no']."</td><td>".$id."<td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$size."</td><td>".$mo_qty."</td><td>".$op_dec."</td><td>".$m3_ops_code."</td><td>".$tran_id."</td><td>".$response_status."</td><td>".$trail_count."</td><td>".$response."</td>";
               echo "<td><input type='checkbox' name='bindingdata[]' value='".$id.'-'.$m3_bulk_tran_id."'></td>";

            }  

            //  echo $count;
            if($count>0){
               $reconfirm='<input type="submit" value="Re-Confirm" class="btn btn-primary">';
            }
            echo '</table>'."$reconfirm".'</form></div></div></div>';  
         }
         else{
            echo '<div class="panel panel-primary">
            <div class="panel-heading" style="text-align:center;"><h4>Data Not Found....!</h3></div>';
            echo "<script>
            document.getElementById('sdate').value = '';
            document.getElementById('edate').value = '';
            document.getElementById('schedule').value = '';
            </script>";
         }
      }
      else
      {
         echo "<h3 style='color:red;'>Please Select Filter</h3>";
         echo "<script>
         document.getElementById('sdate').value = '';
         document.getElementById('edate').value = '';
         document.getElementById('schedule').value = '';
         </script>";
      }
      
      
   }
?>
<?php
   if(isset($_POST['bindingdata']))
   {
      $binddetails=$_POST['bindingdata'];
      $count1=count($binddetails);


         for($j=0;$j<$count1;$j++)
         {
            $id = $binddetails[$j];
            $exp=explode("-",$id);
            $id_status=$exp[0];
            $reconfim_id=$exp[1]; 
            echo $reconfim_id;
            $update_sql="update $bai_pro3.`m3_transactions` set m3_trail_count=0 where id=$id_status";
            // echo $update_sql;
            mysqli_query($link, $update_sql) or exit("Sql Update Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $update_bulk_sql="update $bai_pro3.`m3_bulk_transactions` set m3_trail_count=0 where id='$reconfim_id'";
            // echo $update_bulk_sql;
            mysqli_query($link, $update_bulk_sql) or exit("Sql Update bulk Error".mysqli_error($GLOBALS["___mysqli_ston"]));

         }
      header("Refresh:0"); 
      echo '<div id="loading"></div>';
   }
   
?>
<script language="javascript">
   function getCSVData(){
      var csv_value=$('#example1').table2CSV({delivery:'value'});
      $("#csv_text").val(csv_value);	
      }
</script>
<script language="javascript" type="text/javascript">
	//<![CDATA[
		$('#reset_example1').addClass('btn btn-warning');
	var table6_Props = 	{
							table6_Props: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "example1",table6_Props );
	$(document).ready(function(){
		$('#reset_example1').addClass('btn btn-warning btn-xs');
	});
	//]]>
</script>