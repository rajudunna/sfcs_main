<?php
    //==================== IPS Dashboard ========================
    /* ==========================================================
                      Created By: Chandu
    Input & output: get section details and send ajax call to server and display it in sections div
    Created at: 19-09-2018
    Updated at: 21-09-2018 
    ============================================================ */
    
    $ui_url1 ='?r='.base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php');
    $v_r = explode('/',base64_decode($_GET['r']));
    array_pop($v_r);
    $url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/ips_dashboard.php";
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R'));
    $plant_code = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];
    $dashboard_name="IPS";
    $departmentType = DepartmentTypeEnum::SEWING;
    $sec_result = mysqli_query($link, "select section_id,section_code,section_name from $pms.sections as sec left join $pms.departments as dept on sec.department_id = dept.department_id where sec.plant_code='".$plant_code."' and dept.plant_code='".$plant_code."' and dept.department_type= '".$departmentType."' and sec.is_active=1") or exit("Sec qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sections = mysqli_fetch_all($sec_result,MYSQLI_ASSOC);
    echo "<script>var sec_ids = '".implode(',',array_column($sections, 'section_id'))."';</script>";
    echo "<script>var sec_names = '".implode(',',array_column($sections, 'section_name'))."';</script>";
    echo "<div class='panel panel-primary'>
            <div class='panel-heading'><h3 class='panel-title'>IPS Dashboard</h3></div>
            <div class='panel-body'>
            <div class='col-sm-12' style='padding-bottom:20px'>
            <div class='form-group'>
              <div class='col-sm-3'>";
                echo 'Sewing Job Track: <input type="text" name="sewing" id="sewing" class="form-control alpha" onkeyup="blink_new(this.value)" size="10"><input type="hidden" id="plant_code" name="plant_code" value='.$plant_code.' required><input type="hidden" id="username" name="username" value='.$username.' required>';
              echo "</div><div class='col-sm-3'>";
                echo 'Schedule Track: <input type="text" name="schedule" id="schedule"  class="form-control integer" onkeyup="blink_new3(this.value)" size="10"> &nbsp;&nbsp;';
              echo "</div>
              <div class='col-sm-3'>
                Shift :<select class='form-control' id='shift' name='shift' required>
                  <option value=''>Select Shift</option>";
                  $shift_sql="SELECT shift_code FROM $pms.shifts where plant_code = '$plant_code' and is_active=1";
                  $shift_sql_res=mysqli_query($link, $shift_sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($shift_row = mysqli_fetch_array($shift_sql_res))
                  {
                      $shift_code=$shift_row['shift_code'];
                      echo "<option value='".$shift_code."' >".$shift_code."</option>"; 
                  }
              echo "</select></div>";
              echo '<div class="col-sm-3">Priorities:
              <select class="form-control" id="view_priority" onchange="redirect_priority()">
              <option value="4" selected>4</option>
              <option value="6">6</option>
              <option value="8">8</option>';
              echo '</select></div>';

              echo "</div>
            </div>
            <div class='col-sm-12'>";
            $inc=0;
    foreach($sections as $sec){
        echo "<div style='width:20%;float:left;padding:5px'>
            <div class='panel panel-success'>
                <div class='panel-body sec-box'>
                    <div class='loading-block' id='sec-load-".$sec['section_id']."' style='display:block'></div>
                    <div id='sec-".$sec['section_id']."'>

                    </div>
                </div>
            </div>
        </div>";
        $inc++;
        if($inc%5==0){
          echo "</div><div class='col-sm-12'>";
        }
    }
    echo "</div>";
    echo "<div class='col-sm-12'>";
    include "include_legends_ips.php";
    echo "</div></div></div>";
?>

<script>

function redirect_priority()
{
  call_server();
}

</script>

<script>
var sec_id_ar = sec_ids.split(',');
var sec_name_ar = sec_names.split(',');
jQuery( document ).ready(function() {
    call_server();
});

function call_server(){
    for(var i=0;i<sec_id_ar.length;i++){
      ajax_calls(sec_id_ar[i],sec_name_ar[i],false);
    }
}
setInterval(function() {
  ajax_calls(sec_id_ar[0],sec_name_ar[0],true);
}, 120000); 


function ajax_calls(value,sec_name,sync_type){
  $('#sec-load-'+value).css('display','block');
  $('#sec-'+value).html('');
  var plant_code = $('#plant_code').val();
  var username = $('#username').val();
  $.ajax({
      url: "<?= $url ?>?sec_id="+value+"&sec_name="+sec_name+"&plant_code="+plant_code+"&username="+username+"&priority_limit="+$('#view_priority').val()
  }).done(function(data) {
      try{
        var r_data = JSON.parse(data) ;
        console.log(r_data);
        $('#sec-'+r_data.sec).html(r_data.data);
        $('#sec-load-'+r_data.sec).css('display','none');
        if(sync_type){
          var ind = sec_id_ar.indexOf(r_data.sec);
          if(sec_id_ar[ind+1]){
            ajax_calls(sec_id_ar[ind+1],sec_name_ar[ind+1],true);
          }
        }
      }catch(err){
        if(sync_type){
          $('#sec-'+value).html('<b>couldn\'t fetch the data & It will automatically refresh in 2 mins</b>');
          $('#sec-load-'+value).css('display','none');
          if(sync_type){
            var ind = sec_id_ar.indexOf(value);
            if(sec_id_ar[ind+1]){
              ajax_calls(sec_id_ar[ind+1],sec_name_ar[ind+1],true);
            }
          }
        }
      }
  }).fail(function(){
    if(sync_type){
      $('#sec-'+value).html('<b>Network Error.It will automatically refresh in 2 mins.</b>');
      $('#sec-load-'+value).css('display','none');
        var ind = sec_id_ar.indexOf(value);
        var s_name = sec_name_ar.indexOf(r_data.sec_name);
        if(sec_id_ar[ind+1]){
          ajax_calls(sec_id_ar[ind+1],sec_name_ar[ind+1],true);
        }
      }else{

      }
  });
}


function viewPopupCenter(style,schedule,module,input_job_no_random_ref,operation_code,sidemenu,plantcode,username){
  url = '<?= $ui_url1 ?>'+'&style='+style+'&schedule='+schedule+'&plant_code='+plantcode+'&username='+username+'&module='+module+'&input_job_no_random_ref='+input_job_no_random_ref+'&operation_id='+operation_code+'&sidemenu='+sidemenu+'&shift=';
  PopupCenter(url, 'myPop1',800,600);
}
function PopupCenter(pageURL, title,w,h) {
    
    var shift= $('#shift').val();
    var plant_code= $('#plant_code').val();
    // alert(plant_code);
    if(shift==''){
      swal('Please Select Shift First','','error');
      return false;
    }else{
      var append_params= shift+'&plant_code='+plant_code;
      pageURL+=append_params;
    }
 
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function blink_new_priority(x)
{
	var temp=x.split(",");
	
	for(i=0;i<x.length;i++)
	{
		blink_new1(temp[i]);
	}
}

function blink_new(x)
{	
	$("div[id='SJ"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	});
}

function blink_new3(x)
{
	$("div[id='S"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	});
}

function blink_new1(x)
{	
	obj="#"+x;
	
	if ( $(obj).length ) 
	{
		$(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	}
}
</script>
<style>
.sec-box{
    min-height:100px;
}
.loading-block{
    border: 10px solid #f3f3f3; 
    border-top: 10px solid #156b0a; 
    border-radius: 50%;
    width: 70px;
    height: 70px;
    animation: spin 2s linear infinite;
    margin : 0 auto;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
a {text-decoration: none;}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom th,td
{
	 border-bottom: 1px solid #000000; 
	padding-bottom: 5px;
	padding-top: 5px;
}


.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: #000000; font-family: Arial; font-size:12px; } 

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: #000000; font-family: Arial; font-size:12px; } 

a{
	text-decoration:none;
	color: #000000;
}

.white {
  width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
}

.white a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.white a:hover {
  text-decoration:none;
  background-color: #ffffff;
}


.red {
  width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

.green {
  width:20px;
  height:20px;
  background-color: #339900;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.green a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.green a:hover {
  text-decoration:none;
  background-color: #339900;
}

.lgreen {
  width:20px;
  height:20px;
  background-color: #59ff05;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
 
 }

.lgreen a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
 
}

.lgreen a:hover {
  text-decoration:none;
  background-color: #59ff05;
  
}

.yellow {
  width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yellow a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yellow a:hover {
  text-decoration:none;
  background-color: #ffff00;
}


.pink {
  width:20px;
  height:20px;
  background-color: pink;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.pink a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.pink a:hover {
  text-decoration:none;
  background-color: pink;
}

.orange {
  width:20px;
  height:20px;
  background-color: #eda11e;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.orange a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.orange a:hover {
  text-decoration:none;
  background-color: #eda11e;
}

.blue {
  width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.blue a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}


.yash {
  width:20px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yash a:hover {
  text-decoration:none;
  background-color: #999999;
}

.black {
  width:20px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.black a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}
.black a:hover {
  text-decoration:none;
  background-color: black;
}

</style>



