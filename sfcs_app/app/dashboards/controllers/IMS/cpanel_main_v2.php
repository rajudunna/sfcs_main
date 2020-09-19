<style>
.green_back{
  background : #00ff00;
 padding: 2px;
  height:20px;
} 
.red_back{
  background : #ff0000;
  padding:2px;
  height:20px;
} 
.black_back{
  background : #000;
  color:white;
  padding:2px;
  height:20px;
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
border: 1px solid black;
}

.blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}
body
{
  font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
  background-color:#333333;
  color: BLACK;
}
h2
{
  font-size:20px;
  margin-bottom:0px;
  padding-bottom:0px;
}
a{
  text-decoration:none;
}
.main_div
{
  padding-top:10px;
  width:1200px;
  height:600px;
  
}
.main_heading
{
  height:100px;
  width:850px;
  padding-top:10px;
  background-color:#00C;
}
.section_main_box
{
  width:220px;
  height:auto;
  
  float:left;
  margin-right:20px;
  border:1px solid #CCC;
}

.sections_heading1
{
   width:218px;
   text-align:center;
   font-size:16px;
   padding-top:5px;
   padding-bottom:5px;
   border-bottom:1px solid #666;
}
.sections_heading1 a
{
  
   font-size:16px;
   color:black;
   text-decoration:none;
}

.line_main
{
  width:206px;
  
   padding-bottom:5px;
   margin:5px;
   border-bottom:1px dotted #666;
}

.line_no
{
  width:10px;
  height:10px;
  color:black;
  float:left;
}
.line_no a
{
  color:black;
}
.red_box
{
  width:20px;height:20px;float:left;margin-right:5px;background-color:#F00;line-height:0px;font-size:0px;
  margin-bottom:5px;
  padding-left : 3px;
  padding-right : 3px;
 
}

.green_box
{
  width:20px;height:20px;float:left;margin-right:5px;background-color:#0F0;line-height:0px;font-size:0px;
  margin-bottom:5px;
padding-top:10px;
  
 
}

.green_box1
{
  width:auto;height:20px;float:left;margin-right:5px;background-color:#06FF00;line-height:15px;
  margin-bottom:5px;display: inline;
  padding-top:10px;
  
}
.blue_box
{
  width:20px;height:20px;float:left;margin-right:5px;background-color:#15a5f2;line-height:0px;font-size:0px;
  margin-bottom:5px;border:1px;
}
.blue_box{
  color: #000;
  font-weight: 800;
  font-size: 14px;
  text-align: center;
  vertical-align: middle;
   padding-top: 10px;
}
.yellow_box
{
  width:30px;height:20px;float:left;margin-right:5px;background-color:#FFFF00;line-height:0px;font-size:12px;
  margin-bottom:5px;padding-top:10px;padding-left:10px;
}
.black_box1
{
  width:20px;height:20px;float:left;margin-right:5px;background-color:#000;line-height:0px;font-size:12px;
  margin-bottom:5px;padding-top:10px;padding-left:10px;color:white;

}
.clear
{
  clear:both;
}


.description table
{
  border-collapse:collapse;
}

.description tr
{
  display:table-row;
  vertical-align:inherit;
  border-color:inherit;
}


.description th,td
{
   border-bottom: 1px solid white; 
  padding-bottom: 5px;
  padding-top: 5px;
  white-space:inherit;
  border-collapse:collapse;
  display:table-cell;
  
}
.tooltip {
    
      outline: none;
      cursor: auto; 
      text-decoration: none;
      position: relative;
      color:#333;
    }
    .tooltip span {
      margin-left: -1500em;
      position: absolute;
    }
    .tooltip:hover span {
      border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; 
      box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
      font-family: Calibri, Tahoma, Geneva, sans-serif;
      position: absolute; 
      left: 0em; top: 0em; z-index: 99;
      margin-left: -100px; width: 150px;
      margin-top: -100px;


    }
    .tooltip:hover img {
      border: 0; 
      margin: -10px 0 0 -55px;
      float: left; position: absolute;
    }
    .tooltip:hover em {
      font-family: Candara, Tahoma, Geneva, sans-serif; font-size: 1.2em; font-weight: bold;
      display: block; padding: 0.2em 0 0.6em 0;
    }
    .classic { padding: 0.8em 1em; }
    .custom { padding: 0.5em 0.8em 0.8em 2em; }
    * html a:hover { background: transparent; }
    .classic {background: #000; border: 1px solid #FFF;font-weight:bold; }
    .critical { background: #FFCCAA; border: 1px solid #FF3334; }
    .help { background: #9FDAEE; border: 1px solid #2BB0D7; }
    .info { background: #9FDAEE; border: 1px solid #2BB0D7; }
    .warning { background: #FFFFAA; border: 1px solid #FFAD33; }
    
  
    /* Tooltip */
.red-tooltip + .tooltip > .tooltip-inner {
background-color: black;
width:350px;
}
#tooltip {
  position:absolute;
  z-index:9999;
  color:#fff;
  font-size:12px;
  width:250px;
  pointer-events: none; 
  
}

#tooltip .tipHeader {
  height:8px;
  /*background:url('<?= getFullURL($_GET['r'],'common/images/tipHeader.gif',2,'R');?>') no-repeat;*/
  font-size:0px;
}


#tooltip .tipBody {
  background-color:#000;
  padding:5px 5px 5px 15px;
}

#tooltip .tipFooter {
   height:8px;
   /*background:url('<?= getFullURL($_GET['r'],'common/images/tipFooter.gif',2,'R');?>') no-repeat;*/
}

</style>
<script>
function loadpopup(url)
{ 
    var shift = document.getElementById('shift').value;
    if(shift)
    {
        url = url+'&shift='+shift;
        window.open(url,'Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;
    }
    else
    {
        swal({
            title: "Warning!",
            text: "Please select shift",
            type: "warning"
        }).then(function() {
            // window.close();
        });
    }
}
setTimeout(function()
{
    var shift = document.getElementById('shift').value; 
    var url = window.location.href;
    var url1 = window.location.href.split('&')[0];
    if(shift){
      window.location.href = url1+'&shift='+shift;  
    }
    else{
        window.location.href = url;    
    }
}, 120000);

function doBlink() {
  var blink = document.all.tags("BLINK")
  for (var i=0; i<blink.length; i++)
    blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : "" 
}

function startBlink() {
  if (document.all)
    setInterval("doBlink()",8000)
}
window.onload = startBlink;
//POP up window -  start 
function PopupCenter(pageURL, title,w,h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 

function PopupCenterSection(pageURL, title,w,h) { 
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
function blink_new3(x)
{
    $("div[id='S"+x+"']").each(function() {
        $(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
    });
}

$(document).ready(function() {
//Select all anchor tag with rel set to tooltip
$('a[rel=tooltip]').hover(function(e) {
  
  //Grab the title attribute's value and assign it to a variable
  var tip = $(this).attr('title');  
  
  //Remove the title attribute's to avoid the native tooltip from the browser
  $(this).attr('title','');
  
  //Append the tooltip template and its value
  $(this).append('<div id="tooltip"><div class="tipHeader"></div><div class="tipBody">' + tip + '</div><div class="tipFooter"></div></div>');   
  
}).mousemove(function(e) {

  //Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
  console.log('y = '+e.pageY+' : '+e.view.parent.pageYOffset);
  console.log(e);

  //e.pageY + 0.5 * e.view.parent.pageYOffset
  $('#tooltip').css('top',$(this).offset.top-$(window).scrollTop());
  $('#tooltip').css('left',$(this).offset.left - 255 );
   $('#tooltip').css('margin-left','10px' );
   $('#tooltip').css('margin-top','10px' );
   $('#tooltip').css('position', 'absolute' );
   $('#tooltip').css('z-index', '999999' );
}).mouseout(function() {

  //Put back the title attribute's value
  $(this).attr('title',$('.tipBody').html());

  //Remove the appended tooltip template
  $(this).children('div#tooltip').remove();
  
});

});


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip(); 
var url = '<?= getFullURL($_GET['r'],'mod_rep_recon.php','R'); ?>';
var modules = '<?= json_encode($data); ?>';

$.ajax
({
  type: "POST",
  url: url,
  data:{modules:modules},
  success: function(data)
  {

  }
});  
});
</script>
<title>IMS</title>
<?php
    include('imsCalls.php');
    $start_timestamp = microtime(true);
    $plantCode = $_SESSION['plantCode'];
    $username = $_SESSION['userName']; 
?>

<body>
<div class="panel panel-primary">
  <div class="panel-heading">    
    Input Management System - Production WIP Dashboard -
    <span style="color:#fff;font-size:12px;margin-left:15px;">Refresh Rate: 120 Sec.</span>
  </div>
  <div class="panel-body">
    <div class="form-inline">
      <div class="form-group">Shift 
        <select class="form-control" id="shift" name="shift">
          <option value="">Select</option>
          <?php
              $shifts_array=getShifts($plantCode);
              $shifts = (isset($_GET['shift']))?$_GET['shift']:'';
              foreach($shifts_array as $shift){
                if($shifts == $shift){
                  echo "<option value='".$shift['shiftValue']."' selected>'".$shift['shiftLabel']."'</option>";
                }else{
                  echo "<option value='".$shift['shiftValue']."' >'".$shift['shiftLabel']."'</option>";
                }
              }
          ?>
        </select>   
      </div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      
      <div class="form-group">
        Schedule Track: <input type="text" name="schedule" id="schedule"  class="form-control" onkeyup="blink_new3(this.value)" size="10">
      </div>
    </div>  
    <div style="padding-top:15px;">
      <div class="table-responsiv">
        <div class='col-sm-12'>
   <?php
      $break_counter = 0;
      /**
       * Get Setions for department type 'SEWING' and plant code
       */
      $departments=getSectionByDeptTypeSewing($plantCode);
      foreach($departments as $department)    //section Loop -start
      {      
          $break_counter++; 

          // $ims_priority_boxes=echo_title("$bai_pro3.sections_master","ims_priority_boxs","sec_name",$section,$link);;

          // $mods=array();
          // $mods=explode(",",$section_mods);
          if($break_counter == 5){
            $break_counter = 1;
            echo "</div><span style='height:50px'></span><div class='col-sm-12'>";
          }
          ?>
        <div class="section_main_box">
              <div class="sections_heading1">
                <a href="javascript:void(0);" onclick="PopupCenterSection('<?= getFullURL($_GET['r'],'sec_rep.php','R');?>?section=<?php echo $department['sectionId']; ?>', 'myPop1',800,600);" ><?php echo $department['sectionName']; ?><br />
                </a>
              </div>
          <?php    
            // modules Loop -Start
            /**
             * get workstations for plant code and section id
            */
            $sectionId=$department['sectionId'];
            $workstationsArray=getWorkstationsForSectionId($plantCode, $sectionId);
            $wip=0;
            foreach($workstationsArray as $workstations)
              {
          ?>

          <div class="line_main"  style="background:<?= $module_col_lab['color']; ?>">
                <h5 align="center" style="margin-bottom: 0px;margin-top: 0px;" ><b><?= $workstations['workstationLabel']; ?></b></h5>
                <!-- module number DIV start -->  
              <div class="line_no">
                <a href="#" data-toggle="tooltip" tile="M-<?php echo $workstations['workstationCode']; ?> WIP :  
                <?php echo $wip; ?>" class="red-tooltip" onclick="window.open('<?= getFullURL($_GET['r'],'mod_rep.php','R');?>?module=<?= $workstations['workstationId'] ?>', 'myPop1');">
                <?= $workstations['workstationCode'] ?></a>
              </div>  
              <!-- module number DIV END -->
              <div style="float:left;padding-left:25px;">
              <?php
              /**
             * get planned sewing jobs(JG) for the workstation
             */  
              $jobsArray=getJobsForWorkstationIdTypeSewing($plantCode, $workstations['workstationId']);
              $total_qty="0";
              $total_out="0";
              //docket boxes Loop -start
              if(sizeof($jobsArray)>0)
              {
                //while($sql_rowred=mysqli_fetch_array($sql_resultred))
                foreach($jobsArray as $jobs)     
                {   
                  $taskJobId=$jobs['taskJobId'];
                  // Initializations
                  $job_group=0;
                  $minOperation='';
                  $minOrgnalQty=0;
                  $minGoodQty=0;
                  $maxOperation='';
                  $maxOrgnalQty=0;
                  $maxGoodQty=0;
                  $maxRejQty=0;

                    /**
                     * get MIN operation wrt jobs based on operation seq
                     */
                    $qrytoGetMinOperation="SELECT job_group,operation_code,
                    original_quantity,
                    good_quantity,
                    rejected_quantity FROM $tms.`task_job_transaction` WHERE task_jobs_id='$taskJobId' AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
                    $minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting operations data for job');
                    if(mysqli_num_rows($minOperationResult)>0){
                      while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
                          $job_group=$minOperationResultRow['job_group'];
                          $minOperation=$minOperationResultRow['operation_code'];
                          $minOrgnalQty=$minOperationResultRow['original_quantity'];
                          $minGoodQty=$minOperationResultRow['good_quantity'];
                        }
                        $minRejQty=$minOperationResultRow['rejected_quantity'];
                    }

                    /**
                     * get MAX operation wrt jobs based on operation seq
                     */
                    $qrytoGetMaxOperation="SELECT job_group,operation_code,
                    original_quantity,
                    good_quantity,
                    rejected_quantity FROM $tms.`task_job_transaction` WHERE task_jobs_id='$taskJobId' AND plant_code='$plantCode' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
                    $maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
                    if(mysqli_num_rows($maxOperationResult)>0){
                      while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
                          $job_group=$maxOperationResultRow['job_group'];
                          $maxOperation=$maxOperationResultRow['operation_code'];
                          $maxOrgnalQty=$maxOperationResultRow['original_quantity'];
                          $maxGoodQty=$maxOperationResultRow['good_quantity'];
                          $maxRejQty=$maxOperationResultRow['rejected_quantity'];
                      }
                    }  


                    $value='';
                    $input_qty=$minGoodQty;      // input qty
                    $output_qty=$maxGoodQty;
                    $rejected_qty = $maxRejQty;
                    /**
                     * get eligible jobs to display in dashboards based on below condition
                     */
                    if(($minGoodQty>0) && (($maxGoodQty+$maxRejQty)<$minGoodQty)){
                          //TO GET STYLE AND COLOR FROM TASK ATTRIBUTES USING TASK JOB ID
                          $job_detail_attributes = [];
                          $qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id='$taskJobId' and plant_code='$plantCode'";
                          $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                          while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
                            $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
                          }
                          $style = $job_detail_attributes[$sewing_job_attributes['style']];
                          $color = $job_detail_attributes[$sewing_job_attributes['color']];
                          $schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
                          $ponumber = $job_detail_attributes[$sewing_job_attributes['ponumber']];
                          $masterponumber = $job_detail_attributes[$sewing_job_attributes['masterponumber']];
                          $cutjobno = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
                          $docketno = $job_detail_attributes[$sewing_job_attributes['docketno']];
                          $sewingjobno = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
                          $bundleno = $job_detail_attributes[$sewing_job_attributes['bundleno']];
                          $packingjobno = $job_detail_attributes[$sewing_job_attributes['packingjobno']];
                          $cartonno = $job_detail_attributes[$sewing_job_attributes['cartonno']];
                          $componentgroup = $job_detail_attributes[$sewing_job_attributes['componentgroup']];
                          
                          $sidemenu=true;
                          $ui_url1 = getFullURLLevel($_GET["r"],'production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php',3,'N')."&module=$module&input_job_no_random_ref=$sewingjobno&style=$style&schedule=$schedule&operation_id=$maxOperation&sidemenu=$sidemenu&shift=$shift";
                          ?>
                          <a href="javascript:void(0);" onclick="loadpopup('<?= $ui_url1;?>', 'myPop1',800,600);"  title="
                          Style No : <?php echo $style."<br/>"; ?>
                          Co No : <?php echo $co_no."<br/>"; ?>
                          Schedul No :<?php echo $schedule."<br/>"; ?>
                          Color : <?php echo $color."<br/>"; ?>
                          Docket No : <?php echo $docketno."<br/>"; ?>
                          Job No : <?php echo $sewingjobno."<br/>"; ?>
                          Cut No : <?php echo $cutjobno."<br/>"; //chr($color_code).leading_zeros(?>
                          Input Date : <?php echo $input_date."<br/>"; ?>
                          Total Input :<?php echo $input_qty."<br/>"; ?>
                          Total Output:<?php echo $output_qty."<br/>"; ?>
                          Rejected:<?php echo $MaxRejQty."<br/>"; ?>
                          <?php echo "Balance : ".($input_qty - ($output_qty+$MaxRejQty))."<br/>";?>Remarks: <?php echo $ims_remarks."<br/>"; ?>
                          " rel="tooltip">
                          <?php echo "<div class=\"blue_box\" id=\"S$schedul_no\" style=\"$rejection_border\">";?>
                          <?php echo $value; ?>
                          </div></a>
                          <?php
                          $wip=(($wip+$input_qty)-($output_qty+$MaxRejQty));
                    } 
                }
              }
              
              /*
              $pending=array();
              $pending_tmp=array();
              $pending_tmp=array_values(array_diff($recut_job,$available_job));
              $pending=array_values(array_diff($pending_tmp,$jobs_not_consider));
              $pending=5;
              if(sizeof($pending)>0)
              {           
                    for($kk=0;$kk<$pending;$kk++)
                    { 
                        $sqlwip122="SELECT style,color FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref='".$pending[$kk]."'";
                        $sql_resultwip122=mysqli_query($link, $sqlwip122) or exit("Sql Error1225".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_rowwip122=mysqli_fetch_array($sql_resultwip122))
                        {
                          $style=$sql_rowwip122['style'];
                          $color=$sql_rowwip122['color'];
                        }
                        $application2='IPS';

                        $scanning_query12="select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application2'";
                        $scanning_result12=mysqli_query($link, $scanning_query12)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row123=mysqli_fetch_array($scanning_result12))
                        {
                          $operation_in_code=$sql_row123['operation_code'];
                        }
                        if($operation_in_code == 'Auto'){
                          $get_ips_op = get_ips_operation_code($link,$style,$color);
                          $operation_in_code=$get_ips_op['operation_code'];
                        }
                        $value=$recut_job_val[$pending[$kk]];             
                        $sqlwip12="SELECT input_job_no,remarks,cut_number,docket_number,style,schedule,color,sum(if(operation_id = $operation_in_code,recevied_qty,0)) as input,sum(if(operation_id = $operation_out_code,recevied_qty,0)) as output,SUM(IF(operation_id = $operation_out_code,rejected_qty,0))  as rejected FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref='".$pending[$kk]."'";
                        $sql_resultwip12=mysqli_query($link, $sqlwip12) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_rowwip12=mysqli_fetch_array($sql_resultwip12))
                        {
                          $style_no=$sql_rowwip12['style'];
                          $schedul_no=$sql_rowwip12['schedule'];
                          $color_name=$sql_rowwip12['color'];
                          $docket_no=$sql_rowwip12['docket_number'];
                          $input_qty=$sql_rowwip12['input'];
                          $output_qty=$sql_rowwip12['output'];
                          $cut_no=$sql_rowwip12['cut_number'];
                          $type_of_sewing=$sql_rowwip12['remarks'];
                          $inputno=$sql_rowwip12['input_job_no'];
                          $rejected=$sql_rowwip12['rejected'];
                        }
                        if(!in_array($schedul_no,$scheudles))
                        {
                            $color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des='".$color_name."' and order_del_no",$schedul_no,$link);
                            $co_no=echo_title("$bai_pro3.bai_orders_db_confirm","co_no","order_del_no",$schedul_no,$link);              
                            $sewing_prefi=echo_title("$brandix_bts.tbl_sewing_job_prefix","prefix","prefix_name",$type_of_sewing,$link);
                            $display = $sewing_prefi.leading_zeros($inputno,3);
                            $sidemenu=true;
                            $ui_url1 = getFullURLLevel($_GET["r"],'production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php',3,'N')."&module=$module&input_job_no_random_ref=$pending[$kk]&style=$style_no&schedule=$schedul_no&operation_id=$operation_code&sidemenu=$sidemenu&shift=$shift";
                            ?>
                            <a href="javascript:void(0);" onclick="loadpopup('<?= $ui_url1;?>', 'myPop1',800,600);"  
                              title="
                                Style No : <?php echo $style_no."<br/>"; ?>
                                Co No : <?php echo $co_no."<br/>"; ?>
                                Schedul No :<?php echo $schedul_no."<br/>"; ?>
                                Color : <?php echo $color_name."<br/>"; ?>
                                Docket No : <?php echo $docket_no."<br/>"; ?>
                                Job No : <?php echo $display."<br/>"; ?>
                                Cut No : <?php echo chr($color_code).leading_zeros($cut_no,3)."<br/>"; ?>
                                Input Date : <?php echo $input_date."<br/>"; ?>
                                Total Input :<?php echo $input_qty."<br/>"; ?>
                                Total Output:<?php echo $output_qty."<br/>"; ?>
                                Rejected:<?php echo $rejected."<br/>"; ?>
                                <?php echo "Balance : ".($input_qty - ($output_qty+$rejected))."<br/>";?>Remarks: <?php echo $ims_remarks."<br/>"; ?>
                            " 
                            rel="tooltip">
                            <?php echo "<div class=\"blue_box\" id=\"S$schedul_no\" style=\"$rejection_border\">";?>
                              <?php echo $value; ?>
                            </div></a>
                            <?php
                        }
                  }
              }
              */

              /*docket boxes Loop -End 
              closing while for red blocks
              */
              if($wip!=0){
                if($wip>=217 && $wip<=750) { 
                  $span_color = 'green'; 
                }else if($wip<=216){
                  $span_color = 'red';
                }else if($wip>=751){
                  $span_color = 'black';
                }
              ?>
              <span class="<?= $span_color ?>_back">WIP :  <?php echo $wip; $wip=0; ?></span>
              <?php 
              }        
                if(($total_qty-$total_out)>1000) {         //  WIP >3 000 then appear Yreen box
                  $redirect_url = getFullURL($_GET['r'],'mod_rep_ch.php','R')."?module=$module";
                }
              ?>
              <div class="clear"></div>
              </div>                  
              <div class="clear"></div>
              </div>
              <?php 
            } 
            // modules Loop -End 
            echo '</div>';
      } 
      //section Loop -End 
      ?> 
     </div><span style='height:50px'></span>
     <div style='height:300px'></div>
  </div>   
</div>

<br/><br/><br/>
<span style='height:50px'></span>
  <div class='col-sm-2' style="width:220px;height:auto;float:left;margin-top:0;border : 1px solid black">
   <table width="100%" class="description" style='float : none'>
      <tr>
        <td>Allocated Jobs</td>
        <td><div class="blue_box" style="margin-left:15px;"></div></td>
      </tr>
      <tr>
        <td>Line WIP &ge; 217 && &le; 750</td>
        <td><div class="green_box" style="margin-left:15px;"></div></td>
      </tr>
      <tr>
        <td>Line WIP &le; 216</td>
        <td><div class="red_box" style="margin-left:15px;"></div></td>
      </tr>
      <tr>
        <td>Line WIP &ge; 751</td>
        <td><div class="black_box1" style="margin-left:15px;"></div></td>
      </tr>
    </table>
  </div>
</body>