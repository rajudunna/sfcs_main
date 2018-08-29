<?php
$double_modules=array("11","54","64");
?>

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
?>


<title>IMS</title>


<script language=\"javascript\" type=\"text/javascript\" src=".getFullURL($_GET['r'],'common/js/dropdowntabs.js',4,'R')."></script>
<link rel=\"stylesheet\" href=".getFullURL($_GET['r'],'common/css/ddcolortabs.css',4,'R')." type=\"text/css\" media=\"all\" />
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

</style>


<SCRIPT>
<!--
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
// -->
</SCRIPT>

<!-- POP up window -  start  -->
<script>         
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>
<!-- POP up window -  End  -->

<!-- <script>

$("#dyna img[title]").tooltip({
 
   // tweak the position
   offset: [10, 2],
 
   // use the "slide" effect
   effect: 'slide'
 
// add dynamic plugin with optional configuration for bottom edge
}).dynamic({ bottom: { direction: 'down', bounce: true } });
</script> -->

<style>
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
  
}

#tooltip .tipHeader {
  height:8px;
  background:url('<?= getFullURL($_GET['r'],'common/images/tipHeader.gif',2,'R');?>') no-repeat;
  font-size:0px;
}


#tooltip .tipBody {
  background-color:#000;
  padding:5px 5px 5px 15px;
}

#tooltip .tipFooter {
  height:8px;
  background:url('<?= getFullURL($_GET['r'],'common/images/tipFooter.gif',2,'R');?>') no-repeat;
}

</style>


<script type="text/javascript">

$(document).ready(function() {

  //Select all anchor tag with rel set to tooltip
  $('a[rel=tooltip]').mouseover(function(e) {
    
    //Grab the title attribute's value and assign it to a variable
    var tip = $(this).attr('title');  
    
    //Remove the title attribute's to avoid the native tooltip from the browser
    $(this).attr('title','');
    
    //Append the tooltip template and its value
    $(this).append('<div id="tooltip"><div class="tipHeader"></div><div class="tipBody">' + tip + '</div><div class="tipFooter"></div></div>');   
        
    //Show the tooltip with faceIn effect
    $('#tooltip').fadeIn('100');
    //$('#tooltip').fadeTo('10',0.9);
    
  }).mousemove(function(e) {
  
    //Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
    console.log('y = '+e.pageY+' : '+e.view.parent.pageYOffset);
    console.log(e);
    //e.pageY + 0.5 * e.view.parent.pageYOffset
    $('#tooltip').css('top',);
    $('#tooltip').css('left', e.pageX - 265 );
    $('#tooltip').css('display', 'inline' );
     $('#tooltip').css('position', 'absolute' );
  }).mouseout(function() {
  
    //Put back the title attribute's value
    $(this).attr('title',$('.tipBody').html());
  
    //Remove the appended tooltip template
    $(this).children('div#tooltip').remove();
    
  });

});

</script>

<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-blink.js',2,'R'); ?>" language="javscript" type="text/javascript"></script>

<script type="text/javascript" language="javascript">

$(document).ready(function()
{
  //$('.blink').blink();
});
//function blink(selector){
//$(selector).fadeOut('slow', function(){
  //  $(this).fadeIn('slow', function(){
    //    blink(this);
    //});
//});
//}
    
//blink('.blink');


</script>

<body>


<div class="panel panel-primary">
  
   <div class="panel-heading">
    
      Input Management System - Production WIP Dashboard -<span style="color:#fff;font-size:12px;margin-left:15px;">Refresh Rate: 120 Sec.</span>
<?php
$sql="select max(ims_log_date) as \"lastup\" from $bai_pro3.ims_log";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{ ?>
  <span style="font-size:12px;color:#CCC;">Last Update at: <?PHP echo $sql_row['lastup']; ?></span>
<?php
} ?>
  </div>
  <div class="panel-body">
    <div style="padding-top:15px;">
    <div class="table-responsiv">
      <div class='col-sm-12'>
   <?php $sqlx="select * from $bai_pro3.sections_db where sec_id>0";
  $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  $break_counter = 0;
  while($sql_rowx=mysqli_fetch_array($sql_resultx))     //section Loop -start
  {
    $break_counter++;
    
    $section=$sql_rowx['sec_id'];
    $section_head=$sql_rowx['sec_head'];
    $section_mods=$sql_rowx['sec_mods']; 
    
    $mods=array();
    $mods=explode(",",$section_mods);

        if($break_counter == 5){
            $break_counter = 1;
            echo "</div><span style='height:50px'></span><div class='col-sm-12'>";
        }
    ?>
    <div class="section_main_box">
          <div class="sections_heading1">
            <a href="javascript:void(0);" onclick="PopupCenter('<?= getFullURL($_GET['r'],'sec_rep.php','R');?>?section=<?php echo $section; ?>', 'myPop1',800,600);" >Section <?php echo $section; ?><br />
          <!-- <span style="font-size:12px;color:#C0F"><?php echo $section_head; ?></span> -->
      </a>
            </div>
            
           <?php    // modules Loop -Start
       for($x=0;$x<sizeof($mods);$x++)
      {
      
      $module=$mods[$x];
      include("mod_rep_recon.php");
  
      ?>

      <?php
      /*
       $rev_qty=0;
       $rev_query="select sum(qms_qty) as rej_qty from $bai_pro3.bai_qms_db where remarks like '$module-%'";
       //echo $rev_query;
       $result=mysqli_query($link, $rev_query) or exit("Sql Error rev qty".mysqli_error($GLOBALS["___mysqli_ston"]));
      // echo $rev_query;
       while($row=mysqli_fetch_array($result))
       {
         $rev_qty=$row['rej_qty'];
       }
          */
      ?>
            <div class="line_main">
              <div class="line_no">  <!-- module number DIV start -->
                
                <?php 

                $sqlwip="SELECT SUM(ims_qty-ims_pro_qty) AS WIP ,ims_doc_no  FROM $bai_pro3.ims_log WHERE ims_mod_no='$module' and ims_status<>'DONE'";
             //echo $sqlwip;
        $sql_resultwip=mysqli_query($link, $sqlwip) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        
        while($sql_rowwip=mysqli_fetch_array($sql_resultwip))
        {
        ?>
        
                <a href="#" data-toggle="tootip" tile="M-<?php echo $module; ?> WIP :  <?php echo $sql_rowwip['WIP']; 
        $wip='0';
        $wip=$sql_rowwip['WIP'];
        ?>" class="red-tooltip" 
            onclick="PopupCenter('<?= getFullURL($_GET['r'],'mod_rep.php','R');?>?module=<?php echo $module; ?>', 'myPop1',800,600);">
            <?php echo $module; ?></a>
        <?php } ?>
               
                </div>  <!-- module number DIV END -->
                
               <div style="float:left;padding-left:25px;">
               
                <?php 
                $sqlred="SELECT SUM(i.ims_qty) AS Input,SUM(i.ims_pro_qty) AS Output,i.ims_doc_no,i.ims_style,REPLACE(GROUP_CONCAT(DISTINCT TRIM(i.ims_size)),\"a_\",\"\") AS ims_size,GROUP_CONCAT(DISTINCT TRIM(i.ims_color)) AS ims_color,i.ims_schedule,i.rand_track,GROUP_CONCAT(DISTINCT TRIM(i.ims_remarks)) AS ims_remarks, p.acutno,i.input_job_no_ref AS inputjobno,i.input_job_rand_no_ref AS inputjobnorand,i.ims_date,i.pac_tid FROM $bai_pro3.ims_log i,$bai_pro3.plandoc_stat_log p WHERE i.ims_mod_no='$module' AND i.ims_doc_no=p.doc_no AND i.ims_status !=\"DONE\" GROUP BY inputjobnorand";
                // echo $sqlred;
        //$sqlred="SELECT SUM(ims_qty) AS Input,SUM(ims_pro_qty) AS Output,ims_doc_no,ims_style,ims_color,ims_schedule,rand_track  FROM ims_log WHERE ims_mod_no='$module' GROUP BY ims_doc_no"
        $sql_resultred=mysqli_query($link, $sqlred) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $total_qty="0";
        $total_out="0";



        
        while($sql_rowred=mysqli_fetch_array($sql_resultred))     //docket boxes Loop -start
        {
            $input_qty=$sql_rowred['Input'];      // input qty
            $output_qty=$sql_rowred['Output'];      // output qty
            $docket_no=$sql_rowred['ims_doc_no'];   // capturing docket number
            $style_no=$sql_rowred['ims_style'];     // style
            $color_name=$sql_rowred['ims_color'];   // color
      // echo "Color=".$color_name."<br>";
      $color_ref="'".str_replace(",","','",$sql_rowred['ims_color'])."'"; 
      $remarks_ref="'".str_replace(",","','",$sql_rowred['ims_remarks'])."'"; 
      // echo $color_ref."<br>";
            $schedul_no=$sql_rowred['ims_schedule'];  // schedul no
            $rand_track=$sql_rowred['rand_track'];
            $ims_remarks=$sql_rowred['ims_remarks'];
            $ims_size=$sql_rowred['ims_size'];
            $color_code=echo_title("$bai_pro3.bai_orders_db_confirm","color_code","order_col_des in (".$color_ref.") and order_del_no",$schedul_no,$link);
            $cut_no=$sql_rowred['acutno'];
            $inputno=$sql_rowred['inputjobno'];
            $inputjobnorand=$sql_rowred['inputjobnorand'];
            $pac_tid=$sql_rowred['pac_tid'];
            $total_qty=$total_qty+$input_qty;
            $total_out=$total_out+$output_qty;
            $input_date=$sql_rowred['ims_date'];
            $ijrs[] = $inputjobnorand;
           
      
      $sql22="select * from $bai_pro3.plandoc_stat_log where doc_no=$docket_no and a_plies>0";
      //echo $sql22;
      $sql_result22=mysqli_query($link, $sql22) or exit("Sql Error1111".mysqli_error($GLOBALS["___mysqli_ston"]));      
      while($sql_row22=mysqli_fetch_array($sql_result22))
      {
        $order_tid=$sql_row22['order_tid'];
      } 
      
      $sql33="select order_col_des from $bai_pro3.bai_orders_db where order_tid=\"".$order_tid."\"";
      $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error1111".mysqli_error($GLOBALS["___mysqli_ston"]));      
      while($sql_row33=mysqli_fetch_array($sql_result33))
      {
        $ims_color=$sql_row33['order_tid'];
      }
      $size_value=array();
      $sizes_explode=explode(",",$ims_size);
      for($i=0;$i<sizeof($sizes_explode);$i++)
      {
        $size_value[]=ims_sizes($order_tid,$schedul_no,$style_no,$ims_color,$sizes_explode[$i],$link);
        // echo "<BR>sIZE=".ims_sizes($order_tid,$schedul_no,$style_no,$ims_color,$sizes_explode[$i],$link)."<br>";
      }
      
      $sizes_implode="'".implode("','",$size_value)."'";
      
             $rejected=0;
             $sql33="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where  qms_schedule=".$sql_rowred['ims_schedule']." and qms_color in (".$color_ref.") and qms_size in (".$sizes_implode.") and input_job_no=\"".$sql_rowred['inputjobnorand']."\"and qms_style=\"".$sql_rowred['ims_style']."\" and operation_id='130' and qms_remarks in (".$remarks_ref.")";
               
               // echo $sql33;

              $sql_result33=mysqli_query($link, $sql33) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
              while($sql_row33=mysqli_fetch_array($sql_result33))
              {
                $rejected=$sql_row33['rejected']; 
              }



              $display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedul_no,$color_name,$inputno,$link);
              $application='IMS';

              $scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
              //echo $scanning_query;
              $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
              while($sql_row=mysqli_fetch_array($scanning_result))
              {
                $operation_name=$sql_row['operation_name'];
                $operation_code=$sql_row['operation_code'];
              } 
               
               $shift='G';
               //$barcode_generation='1';
               $sidemenu=true;
              $ui_url1 = getFullURLLevel($_GET["r"],'production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php',3,'N');
              //$ui_url1= getFullURLLevel($_GET["r"],'production/controllers/sewing_job/sewing_job_scaning/pre_input_job_scanning.php',3,'N');

          ?>
                  
                  <a href="javascript:void(0);" onclick="PopupCenter('<?= $ui_url1;?>&module=<?php echo $module; ?>&input_job_no_random_ref=<?php echo $inputjobnorand; ?>&style=<?php echo $style_no; ?>&schedule=<?php echo $schedul_no; ?>&operation_id=<?php echo $operation_code; ?>&shift=<?php echo $shift; ?>&sidemenu=<?= $sidemenu ?>', 'myPop1',800,600);"  title="
                  Style No : <?php echo $style_no."<br/>"; ?>
                  Schedul No :<?php echo $schedul_no."<br/>"; ?>
                  Color : <?php echo $color_name."<br/>"; ?>
                  Docket No : <?php echo $docket_no."<br/>"; ?>
                  Job No : <?php echo $display."<br/>"; ?>
                  Cut No : <?php echo chr($color_code).leading_zeros($cut_no,3)."<br/>"; ?>
                  Input Date : <?php echo $input_date."<br/>"; ?>
                  <?php echo "-------------------------</br>"; ?>
                  Total Input :<?php echo $input_qty."<br/>"; ?>
                  Total Output:<?php echo $output_qty."<br/>"; ?>
                  Rejected:<?php echo $rejected."<br/>"; ?>
                  <?php echo "Balance : ".($input_qty - ($output_qty+$rejected))."<br/>";
                   // echo "Balance :".(int)$input_qty - (int)$output_qty."";
                  ?>
                    Remarks: <?php echo $ims_remarks."<br/>"; ?>
                  " rel="tooltip"><div class="blue_box"  >
                  
                  </div></a>
                  <?php 
                }//closing while for red blocks
                     $rev_qty=0;
                     $rev_query="select sum(qms_qty) as rej_qty from $bai_pro3.bai_qms_db where remarks like '$module-%'
                                 and input_job_no IN ('".implode("','",$ijrs)."')";
                      // echo $rev_query;           
                     $result=mysqli_query($link, $rev_query) or exit("Sql Error rev qty".mysqli_error($GLOBALS["___mysqli_ston"]));
                    // echo $rev_query;
                     $ijrs = array();
                     while($row=mysqli_fetch_array($result))
                     {
                       $rev_qty=$row['rej_qty'];
                     }
                     if($wip!=0){
                      if($wip>=217 && $wip<=750) { 
                        $span_color = 'green'; 
                      }else if($wip<=216){
                        $span_color = 'red';
                      }else if($wip>=751){
                        $span_color = 'black';
                      }
                      ?>
                        <span class="<?= $span_color ?>_back">
                            WIP :  <?php echo $wip - $rev_qty; 
                        $wip=0;
                    ?></span>
                  <?php } ?>
                  
                  <?php         
          if(($total_qty-$total_out)<=1000) {         //  WIP <=2 000 then appear Green box
          ?>
                   <!-- <a href="" title="
                  Module is available for new input" rel="tooltip"><div class="green_box">
                  </div></a> -->
                  <?php } ?>
                  
                   <?php        
          if(($total_qty-$total_out)>1000) {         //  WIP >3 000 then appear Yreen box
             $redirect_url = getFullURL($_GET['r'],'mod_rep_ch.php','R')."?module=$module";
          ?>
                   
              <!-- <a href="javascript:void(0);" 
                 onclick=" PopupCenter('<?= $redirect_url ?>','myPop1',680,450);" >
                  <div class="yellow_box blink" id="blink" >WIP : <?php echo $wip; ?>
                  </div>
              </a>  --> 
      <?php } ?>
              <div class="clear"></div>
              </div>                  
              <div class="clear"></div>
            </div>
            <?php } // modules Loop -End ?>
            
      </div>
        
        <?php } //section Loop -End ?> 
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
</div>
</div>

</body>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>