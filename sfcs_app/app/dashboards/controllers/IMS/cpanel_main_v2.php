<?php
$double_modules=array("11","54","64");
?>

<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
?>


<title>IMS</title>


<script language=\"javascript\" type=\"text/javascript\" src=".getFullURL($_GET['r'],'common/js/dropdowntabs.js',4,'R')."></script>
<link rel=\"stylesheet\" href=".getFullURL($_GET['r'],'common/css/ddcolortabs.css',4,'R')." type=\"text/css\" media=\"all\" />
<style>
  
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
  height:800px;
  
  float:left;
  margin-right:20px;
  border:1px dotted #CCC;
}

.sections_heading1
{
   width:218px;
   text-align:center;
   font-size:16px;
   padding-top:5px;
   padding-bottom:5px;
   border-bottom:1px dotted #666;
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
}

.green_box
{
  width:20px;height:20px;float:left;margin-right:5px;background-color:#0F0;line-height:0px;font-size:0px;
  margin-bottom:5px;
}

.yellow_box
{
  width:80px;height:20px;float:left;margin-right:5px;background-color:#FFFF00;line-height:0px;font-size:12px;
  margin-bottom:5px;padding-top:10px;padding-left:10px;
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
      margin-left: -999em;
      position: absolute;
    }
    .tooltip:hover span {
      border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; 
      box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
      font-family: Calibri, Tahoma, Geneva, sans-serif;
      position: absolute; left: 1em; top: 2em; z-index: 99;
      margin-left: 0; width: 150px;
    }
    .tooltip:hover img {
      border: 0; margin: -10px 0 0 -55px;
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
width:150px;
}
#tooltip {
  position:absolute;
  z-index:9999;
  color:#fff;
  font-size:12px;
  width:180px;
  
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
    $('#tooltip').fadeIn('500');
    $('#tooltip').fadeTo('10',0.9);
    
  }).mousemove(function(e) {
  
    //Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
    $('#tooltip').css('top', e.pageY - 50 );
    $('#tooltip').css('left', e.pageX - 250 );
    
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
    <div class="table-responsive">
   <?php $sqlx="select * from $bai_pro3.sections_db where sec_id>0";
  $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
  
  while($sql_rowx=mysqli_fetch_array($sql_resultx))     //section Loop -start
  {
    $section=$sql_rowx['sec_id'];
    $section_head=$sql_rowx['sec_head'];
    $section_mods=$sql_rowx['sec_mods']; 
    
    $mods=array();
    $mods=explode(",",$section_mods);
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
  
      ?>
            <div class="line_main">
              <div class="line_no">  <!-- module number DIV start -->
                
                <?php $sqlwip="SELECT SUM(ims_qty-ims_pro_qty) AS WIP ,ims_doc_no  FROM $bai_pro3.ims_log WHERE ims_mod_no='$module' ";
        $sql_resultwip=mysqli_query($link, $sqlwip) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        
        while($sql_rowwip=mysqli_fetch_array($sql_resultwip)){
        ?>
        
                <a href="#" data-toggle="tooltip" title="M-<?php echo $module; ?> WIP :  <?php echo $sql_rowwip['WIP']; 
        $wip='0';
        $wip=$sql_rowwip['WIP'];
        ?>" class="red-tooltip"><?php echo $module; ?></a>
				<?php } ?>
				<!-- onclick="PopupCenter('<?= getFullURL($_GET['r'],'mod_rep_ch.php','R');?>?module=<?php echo $module; ?>', 'myPop1',800,600);" -->
                </div>  <!-- module number DIV END -->
                <!-- <span class="classic">M-<?php echo $module; ?> WIP :  <?php echo $sql_rowwip['WIP']; 
        $wip='0';
        $wip=$sql_rowwip['WIP'];
        ?></span> -->
                <div style="float:left;padding-left:25px;">
                
                <?php $sqlred="SELECT SUM(i.ims_qty) AS Input,SUM(i.ims_pro_qty) AS Output,i.ims_doc_no,i.ims_style,i.ims_color,i.ims_schedule,i.rand_track, p.acutno,i.ims_date FROM $bai_pro3.ims_log i,plandoc_stat_log p WHERE i.ims_mod_no='$module' AND i.ims_doc_no=p.doc_no GROUP BY ims_doc_no";
        //$sqlred="SELECT SUM(ims_qty) AS Input,SUM(ims_pro_qty) AS Output,ims_doc_no,ims_style,ims_color,ims_schedule,rand_track  FROM ims_log WHERE ims_mod_no='$module' GROUP BY ims_doc_no"
        mysqli_query($link, $sqlred) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
            $schedul_no=$sql_rowred['ims_schedule'];  // schedul no
            $rand_track=$sql_rowred['rand_track'];
            $cut_no=$sql_rowred['acutno'];
            
            $total_qty=$total_qty+$input_qty;
            $total_out=$total_out+$output_qty;
            $input_date=$sql_rowred['ims_date'];
          ?>
                  
                  <a href="javascript:void(0);" onclick="PopupCenter('<?= getFullURL($_GET['r'],'pop_red_box_details.php','R');?>?module=<?php echo $module; ?>&docket=<?php echo $docket_no; ?>', 'myPop1',800,600);"  title="
                  Style No : <?php echo $style_no."<br/>"; ?>
                  Schedul No :<?php echo $schedul_no."<br/>"; ?>
                  Color : <?php echo $color_name."<br/>"; ?>
                  Docket No : <?php echo $docket_no."<br/>"; ?>
                  Cut No : <?php echo "A00".$cut_no."<br/>"; ?>
                  Input Date : <?php echo $input_date."<br/>"; ?>
                  Total Input :<?php echo $input_qty."<br/>"; ?>
                  Total Output:<?php echo $output_qty."<br/>"; ?>
                  <?php echo "Balance : ".($input_qty - $output_qty); ?>
                  " rel="tooltip"><div class="red_box"  >
                  
                  </div></a>
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
                   
              <a href="javascript:void(0);" 
                 onclick=" PopupCenter('<?= $redirect_url ?>','myPop1',680,450);" >
                  <div class="yellow_box blink" id="blink" >WIP : <?php echo $wip; ?>
                  </div>
              </a>  
      <?php } ?>
              <div class="clear"></div>
              </div>                  
              <div class="clear"></div>
            </div>
            
            <?php } // modules Loop -End ?>


<!-- ADDED NEW -->
             <?php
                  $sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where module='$module' and act_cut_issue_status<>\"DONE\" order by priority limit 1";
            $sql_result1=mysqli_query($link,$sql1) or exit("Sql Error".mysqli_error());
            $sql_num_check=mysqli_num_rows($sql_result1);
            while($sql_row1=mysqli_fetch_array($sql_result1)){
                    $cut_new=$sql_row1['act_cut_status'];
              $cut_input_new=$sql_row1['act_cut_issue_status'];
              $rm_new=strtolower(chop($sql_row1['rm_date']));
              $rm_update_new=strtolower(chop($sql_row1['rm_date']));
              $input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
              $doc_no=$sql_row1['doc_no'];
              $order_tid=$sql_row1['order_tid'];
              //$fabric_status=$sql_row1['fabric_status'];
              $fabric_status=$sql_row1['fabric_status_new']; //NEW due to plan dashboard clearing regularly and to stop issuing issued fabric.

              $style=$sql_row1['order_style_no'];
              $schedule=$sql_row1['order_del_no'];
              $color=$sql_row1['order_col_des'];
              $total_qty=$sql_row1['total'];
              
              $cut_no=$sql_row1['acutno'];
              $color_code=$sql_row1['color_code'];
              $log_time=$sql_row1['log_time'];
              $emb_stat=$sql_row1['emb_stat'];
              
              
              $sql11="select sum(ims_pro_qty) as \"bac_qty\", sum(emb) as \"emb_sum\" from (SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as \"emb\" FROM $bai_pro3.ims_log where ims_log.ims_doc_no=$doc_no UNION ALL SELECT ims_pro_qty, if(ims_status='EPR' or ims_status='EPS',1,0) as \"emb\" FROM ims_log_backup WHERE ims_log_backup.ims_mod_no<>0 and ims_log_backup.ims_doc_no=$doc_no) as t";
              mysqli_query($link,$sql11) or exit("Sql Error".mysqli_error());
              
              $sql_result11=mysqli_query($link,$sql11) or exit("Sql Error".mysqli_error());
              $input_count=mysqli_num_rows($sql_result11);
              while($sql_row11=mysqli_fetch_array($sql_result11))
              {
                $output=$sql_row11['bac_qty'];
                $emb_sum=$sql_row11['emb_sum'];
                if($emb_sum==NULL)
                {
                  $input_count=0;
                }
              } 
            
                if($cut_new=="DONE"){ $cut_new="T";} else { $cut_new="F"; }
                if($rm_update_new==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
                if($rm_new=="0000-00-00 00:00:00" or $rm_new=="") { $rm_new="F"; } else { $rm_new="T";  }
                if($input_temp==1) { $input_temp="T"; } else { $input_temp="F"; }
                if($cut_input_new=="DONE") { $cut_input_new="T";  } else { $cut_input_new="F"; }
                
                $check_string=$cut_new.$rm_update_new.$rm_new.$input_temp.$cut_input_new;
                $rem="Nil";
                
                //NEW FSP
                if($fabric_status!=5)
                {
                  $fabric_status=$sql_row1['ft_status'];
                }
                //NEW FSP
              
                if($cut_new=="T"){
                  $id="blue";
                }
              
                $title=str_pad("Style:".$style,80).str_pad("Schedule:".$schedule,80).str_pad("Color:".$color,80).str_pad("Job_No:".chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3),80).str_pad("Total_Qty:".$total_qty,80).str_pad("Log_Time:".$log_time,80).str_pad("Remarks:".$rem,80);

                //Embellishment Tracking
                if($emb_sum=="")
                {
                  $emb_sum=0;
                }
                if($input_count=="")
                {
                  $input_count=0;
                }
                $emb_stat_title="";
                //echo $emb_stat."-".$emb_sum."-".$input_count."$";
                if(($emb_stat==1 or $emb_stat==3) and $emb_sum>0)
                {
                  $emb_stat_title="<font color=black size=2>X</font>";
                }
                else
                {
                  if(($emb_stat==1 or $emb_stat==3) and $emb_sum==0 and $input_count>0)
                  {
                    $emb_stat_title="<font color=black size=2>&#8730;</font>";
                  }
                  else
                  {
                    if(($emb_stat==1 or $emb_stat==3))
                    {
                      $emb_stat_title="<font color=black size=2>X</font>";
                    }
                  }
                }
                //echo $emb_sum;
                //Embellishment Tracking
                
                $sql11="select trims_status from $bai_pro3.trims_dashboard where doc_ref=$doc_no";
                $sql_result11=mysqli_query($link,$sql11) or exit("Sql Error".mysqli_error());
                while($sql_row11=mysqli_fetch_array($sql_result11))
                {
                  $trims_status=$sql_row11['trims_status']; 
                }
                
                $add_css="behavior: url(border-radius-ie8.htc);  border-radius: 10px;";
                if($trims_status>0){
                  $add_css="";
                }
            }
                    if($id=="blue"){
                  echo "<div id=\"$doc_no\" class=\"$id\" style=\"font-size:12px; text-align:center; $add_css\" title=\"$title\" >$emb_stat_title</div>"; 
                  }
             
            ?>
<!--  ENDED NEW  -->








            
      </div>
        
        <?php } //section Loop -End ?> 
    
  <div style="width:220px;height:500px;float:left;">
    <table width="100%" class="description">
  <!-- <tr>
    <td>Empty Slot</td>
    <td><div class="green_box" style="margin-left:15px;"></div></td>
  </tr> -->
  <tr>
    <td>Allocated Cut</td>
    <td><div class="red_box" style="margin-left:15px;"></div></td>
  </tr>
  <tr>
    <td>Line WIP &gt; 1000</td>
    <td><div class="yellow_box" style="margin-left:15px;width:20px;padding-top:0px;"></div></td>
  </tr>
</table>
</div>
    
    
  </div>

</div>
</div>
</div>
</body>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>