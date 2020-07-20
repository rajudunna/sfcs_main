<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0059",$username,1,$group_id_sfcs);



?>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R')?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FileSaver.js',1,'R');?>"></script>

<script>

$(function(){
	

		today=new Date();
		var month,day,year;
		year=today.getFullYear();
		month=today.getMonth();
		date=today.getDate();
	
		var backdate = new Date(year,month-3,date)
		$('.datepicker1').datepicker({
		
        format: 'yyyy-mm-dd',
		
		startDate: backdate,
        endDate: '+0d',
        autoHide: true
    });
    $('.datepicker').datepicker({
		
        format: 'yyyy-mm-dd',
		
		startDate: backdate,
        endDate: '+0d',
        autoHide: true
    });
	

});

   

//function styleFunction() {


//   if (document.getElementById('checkbox').checked){
//     //   alert('hii');
//     document.getElementById("test").style.display='none';
//     // document.getElementById("style").style.display='none';
//     // document.getElementById("smv").style.display='none';
//     // document.getElementById("days").style.display='none';
//   }else{
    
//     document.getElementById("test").style.display='block';
    
//     // document.getElementById("style").style.display='block';
//     // document.getElementById("smv").style.display='block';
//     // document.getElementById("days").style.display='block';

//   }
//}


function verify(){
	var from = document.getElementById('demo1').value;
	var to = document.getElementById('demo2').value;
	if( from > to){
		sweetAlert('To date should be greater than From date ','','warning');
		return false;
	}
}
</script>

<div class="panel panel-primary">
	   <div class="panel-heading"> Efficiency Report</div>	
		  <div class="panel-body">
          <form method="POST" class="form-inline" action=<?php getFullURLLevel($_GET['r'],'efficiency_report.php',0,'N') ?>>
          <body>
               <div class="row">
					<div class="col-sm-2">
						<label>From Date :</label><br>
						<input id="demo1" type="text"  class="form-control datepicker" size="8" name="fdat" value=<?php if(isset($_POST['fdat'])) { echo $_POST['fdat']; } else { echo date("Y-m-d"); } ?>>
					</div>
					<div class="col-sm-2">
							<label for='demo2'>To Date :</label><br>
							<input id="demo2" class="form-control datepicker" type="text"  size="8" name="tdat" value=<?php if(isset($_POST['tdat'])) { echo $_POST['tdat']; } else { echo date("Y-m-d"); } ?>>
					</div>
                    <div class='col-sm-1'>
						<br/><input type="submit" name="submit" onclick='verify()' value="Show" class="btn btn-primary">
					</div>
                    <div class='col-sm-1'>
						<br/><input id="excel" type="button"  class="btn btn-success" value="Export To Excel" onclick="getCSVData()">
  
					</div>
                    
				</div>	
                </form>
			</br>
            
            
  
 
<?php

if(isset($_POST['submit']))
{
	$fdat=$_POST['fdat'];
    $tdat=$_POST['tdat'];
 
    echo '<div class="row"><div class="col-sm-2"><input type="checkbox"  id="checkbox" name="checkbox">&nbsp <b>Hide Style Info</b></div>';
    echo'<div class="col-sm-2"><input type="checkbox"  id="checkbox1" name="checkbox1">&nbsp <b>Enable Summary</b></div></div>';
    echo "<div class='table-responsive' id='report'>
   <table  class=\"table table-bordered\" id='example1' name='example1' style='border: 1px black solid'>";
    echo"<tr>
   <th  rowspan=2 >Line No</th>
   <th  rowspan=2 >Shift</th>
   <th  id='demo'  style='background-color:#da7033;' rowspan=2>Customer</th>
   <th id='style'   style='background-color:#da7033;' rowspan=2>Style</th>
   <th id='smv'   style='background-color:#da7033;' rowspan=2>SMV</th>
   <th id='days'  style='background-color:#da7033;' rowspan=2>No of Days</th>
   <th  id='team' colspan=2>No of TM</th>
   <th  colspan=2>Clock Hours</th>
   <th  colspan=3>Output</th>
   <th colspan=3>SAH</th>
   <th colspan=2>Efficiency</th>
 



</tr>";
echo"<tr>
<th style='background-color:#a6b0ec;' colspan=1 rowspan=1>Plan</th>
<th style='background-color:#90e6a4;' colspan=1 rowspan=1>Actual</th>
<th style='background-color:#a6b0ec;' colspan=1 rowspan=1>Plan</th>
<th style='background-color:#90e6a4;' colspan=1 rowspan=1>Actual</th>
<th style='background-color:#a6b0ec;' colspan=1 rowspan=1>Plan</th>
<th style='background-color:#90e6a4;' colspan=1 rowspan=1>Actual</th>
<th  colspan=1 rowspan=1>Variance</th>
<th style='background-color:#a6b0ec;' colspan=1 rowspan=1>Plan</th>
<th style='background-color:#90e6a4;' colspan=1 rowspan=1>Actual</th>
<th style='' colspan=1 rowspan=1>Variance</th>
<th style='background-color:#a6b0ec;' colspan=1 rowspan=1>Plan</th>
<th style='background-color:#90e6a4;' colspan=1 rowspan=1>Actual</th>
</tr>";
$sql="select * from $bai_pro3.module_master where status='Active' ORDER BY module_name*1;";
$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));


while($row=mysqli_fetch_array($result))
{
    
    echo"<tr>";
    $module_name=$row["module_name"];
    echo "<td rowspan=3>".$module_name."</td>";  
    $no_of_days1=0;
    $no_of_days_count=0;
    $plant_clh_total=0;
    $plan_clh_count=0;
    $plan_clock_hours_total=0;
    $plan_output_total=0;
    $plan_sah_total=0;
    $actual_clock_hours_total=0;
    $actual_bac_qty_total=0;
    $actual_sah_total=0;
    $actual_eff_total=0;
    for ($i=0; $i < sizeof($shifts_array); $i++) {

        $sql3="SELECT GROUP_CONCAT(DISTINCT \"'\",style,\"'\")  AS style,GROUP_CONCAT(DISTINCT color SEPARATOR ',') AS color,GROUP_CONCAT(DISTINCT sfcs_smv SEPARATOR ',') AS smv    FROM $brandix_bts.`bundle_creation_data_temp` 
        WHERE  date_time between \"$fdat\" and \"$tdat\" and assigned_module=\"$module_name\"  and shift=\"$shifts_array[$i]\" ";
        //echo $sql3;
        $result3=mysqli_query($link, $sql3) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        while($row3=mysqli_fetch_array($result3))
        {

            
            $style1=$row3["style"];
            $style_name = str_replace(array('\'', '"'), '', $row3["style"]); 
            $style=$row3["style"];
            $color=$row3["color"];
            $smv=$row3["smv"];
            $smv_name = str_replace(array('\'', '"'), '', $row3["smv"]); 
            
            if($style1==''){
                $style1='NULL';
            }
         
       // $status_implode='"'.implode('',$style1).'"';
       
      
            //echo $style1."</br>";
           // echo $style1;  //echo $str;
            $sql4="select GROUP_CONCAT(DISTINCT \"'\",order_div,\"'\")  AS order_div from $bai_pro3.bai_orders_db where order_style_no IN ($style1)";
            $result4=mysqli_query($link, $sql4) or die("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
           //echo $sql4;

            while($row4=mysqli_fetch_array($result4)){
                $order_div=$row4["order_div"];

                if($order_div==''){
                    $order_div='NULL';
                }
                $sql5="select GROUP_CONCAT(DISTINCT \"'\",buyer_code,\"'\")  AS buyer_code from $bai_pro2.buyer_codes where buyer_name IN ($order_div)";
                $result5=mysqli_query($link, $sql5) or die("Sql Error123: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
              // echo $sql5;
    
                while($row5=mysqli_fetch_array($result5)){
                    $order_div=$row5["buyer_code"];
                    $buyer_name = str_replace(array('\'', '"'), '', $row5["buyer_code"]); 
    
    
                }

            }
            
        }
       
       // echo $sql6;
    echo"<td>".$shifts_array[$i]."</td>
    <td class='test'>".$buyer_name."</td>
    <td class='style1'>".$style_name."</td>
    <td class='smv1'>".$smv_name."</td>";
    $sql6="select count(*) as count from $brandix_bts.`bundle_creation_data_temp` WHERE  date_time between \"$fdat\" and \"$tdat\" and assigned_module=\"$module_name\"  and shift=\"$shifts_array[$i]\" ";
    //echo  $sql6;
            $result6=mysqli_query($link, $sql6) or die("Sql Error67: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));  
            //$no_of_days=mysqli_num_rows($result6); 
           
            while($row6=mysqli_fetch_array($result6)){
                $no_of_days=$row6["count"];
                $no_of_days1+=$row6["count"];
                $no_of_days_count+=count($no_of_days);
               
              
            }
    echo"<td class='days1'>".$no_of_days."</td>";
    $sql1="select SUM(plan_eff) as plan_eff,SUM(plan_pro) as plan_pro,SUM(plan_clh) as plan_clh,SUM(plan_sah) as plan_sah,SUM(nop) as nop from $bai_pro.tbl_freez_plan_log  where mod_no='$module_name' and date between \"$fdat\" and \"$tdat\" and shift=\"$shifts_array[$i]\" group by mod_no,shift";
    
    $result1=mysqli_query($link, $sql1) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
  if(mysqli_num_rows($result1)!=''){
while($row1=mysqli_fetch_array($result1))
{
  
        $plan_eff=$row1["plan_eff"];
        $plan_clh=$row1["plan_clh"];
        $plan_sah=$row1["plan_sah"];
        $plan_pro=$row1["plan_pro"];
        $nop=$row1["nop"];

       
       // $plant_clh_total+=$row1["plan_clh"];

       // $plan_clh_count+=count($plan_clh);

        $plan_clock_hours_total+=$row1["plan_clh"];
        $plan_output_total+=$row1["plan_pro"];
        $plan_sah_total+=$row1["plan_sah"];

       
          
}  
}else{
    $plan_eff="0";
    $plan_clh="0";
    $plan_sah="0";
    $plan_pro="0";
    $nop="0";
  }
echo" <td colspan=1>$nop</td>";
        $sql7="select sum(present) as present,sum(jumper) as jumper from $bai_pro.`pro_attendance` WHERE  date between \"$fdat\" and \"$tdat\" and module=\"$module_name\"  and shift=\"$shifts_array[$i]\" ";
        //echo  $sql6;
                $result7=mysqli_query($link, $sql7) or die("Sql Error67: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));  
                while($row7=mysqli_fetch_array($result7)){
                    $present=$row7["present"];
                    $jumper=$row7["jumper"];

                    $actual_team=$row7["present"]+$row7["jumper"];

                  //echo $no_of_days;
    
                }
                $sql8="select  plant_start_time,plant_end_time FROM $pms.plant where plant_code='$facility_code' and plant_name='$plant_name'";
                $sql_result8=mysqli_query($link, $sql8) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row8=mysqli_fetch_array($sql_result8))
                {
                    $start_time=$sql_row8['plant_start_time'];
                    $end_time=$sql_row8['plant_end_time'];

                }
                $effective_shift_working_hours=(($end_time-$start_time)-$breakhours/60);
               // echo $effective_shift_working_hours;
                $sql91="select SUM(CASE WHEN adjustment_type='Positive' THEN smo_adjustment_hours ELSE 0 END) as Positivetotal,SUM(CASE WHEN adjustment_type='Negative' THEN smo_adjustment_hours ELSE 0 END) as Negativetotal,module,COUNT(*) AS count from $bai_pro.`pro_attendance_adjustment` WHERE  date between \"$fdat\" and \"$tdat\" and module=\"$module_name\"  and shift=\"$shifts_array[$i]\" ";

                //echo  $sql9;
                        $result91=mysqli_query($link, $sql91) or die("Sql Error671: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        $adjustment_count=mysqli_num_rows($result91);
                        // echo $adjustment_count;
                        if($adjustment_count >0){
                        while($row9=mysqli_fetch_array($result91)){
                            $Positivetotal=$row9["Positivetotal"];
                            $Negativetotal=$row9["Negativetotal"];
                            $module_name1=$row9["module"];
                            //$smo_adjustment_hours=$row9["smo_adjustment_hours"];
                            $module_name1=$row9["module"];
                            $sql10="select sum(present) as present,sum(jumper) as jumper from $bai_pro.`pro_attendance` WHERE  date between \"$fdat\" and \"$tdat\" and module=\"$module_name1\"  and shift=\"$shifts_array[$i]\" ";
                            //echo  $sql10;
                                    $result10=mysqli_query($link, $sql10) or die("Sql Error67: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($row10=mysqli_fetch_array($result10)){
                                        $jumper1=$row10["jumper"];
                                        $present1=$row10["present"];
                                    }    
        
                          $actual_clock_hours=($present1*($effective_shift_working_hours))+($Positivetotal-$Negativetotal);
                         
                          //echo $actual_clock_hours;
                          $actual_clock_hours_total+=$actual_clock_hours;
            
                        }
                      }
                   
                      $sql11="select  sum(bac_Qty) as bac_Qty,smv FROM $bai_pro.bai_log WHERE  bac_date between \"$fdat\" and \"$tdat\" and bac_no=\"$module_name\"  and bac_shift=\"$shifts_array[$i]\" ";
                      $sql_result8=mysqli_query($link, $sql11) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
                      //echo $sql11;
                      if( mysqli_num_rows($sql_result8)!=''){
                      while($sql_row8=mysqli_fetch_array($sql_result8))
                      {
                          $bac_Qty=$sql_row8['bac_Qty'];
                          $actual_smv=$sql_row8['smv'];
                          $actual_bac_qty_total+=$bac_Qty;
      
                      }

                    }else{
                        $bac_Qty="0";
                        $actual_smv="0";
                    }

                      $output_variance=round(($plan_pro-$bac_Qty),2);
                      $sah=round((($actual_smv*$bac_Qty)/60),2);
                      $sah_variance=round(($plan_sah-$sah),2);
                      $plan_eff=round((($plan_sah/$plan_clh)*100),2);
                      $actual_eff=round((($sah/$actual_clock_hours)*100),2);
                      $actual_sah_total+=$sah;
    // while($row=mysqli_fetch_array($result)) {}  
    echo"<td colspan=1>".$actual_team."</td>
    <td colspan=1>$plan_clh</td>
    <td colspan=1>$actual_clock_hours</td>
    <td colspan=1>$plan_pro</td>
    <td colspan=1>$bac_Qty</td>
    <td colspan=1>$output_variance</td>
    <td colspan=1>$plan_sah</td>
    <td colspan=1>$sah</td>
    <td colspan=1>$sah_variance</td>
    <td colspan=1>$plan_eff</td>
    <td colspan=1>$actual_eff</td>";
    echo"</tr>";
    $a = implode("+", ($shifts_array));

    
    }
    $total_no_of_days=round(($no_of_days1)/($no_of_days_count),2);
    $plan_eff_total=round(($plan_sah_total)/($plan_clock_hours_total),2);
    $actual_eff_total=round(($actual_sah_total)/($actual_clock_hours_total),2);
    //$plant_clh_avg=round(($plant_clh_total)/($plan_clh_count),2);
    //echo $plant_clh_total;
    echo"<tr >";
    echo"<td class='summary'>".$a."</td>
    <td class='test1'></td>";
    echo" <td class='style2'></td>
    <td class='smv2'></td>
    <td class='days2'><b>Avg:$total_no_of_days</b></td>
    <td colspan=1 class='summary1'></td>
    <td colspan=1 class='summary2'></td>
    <td colspan=1 class='summary3'><b>Total:&nbsp$plan_clock_hours_total</b></td>
    <td colspan=1 class='summary4'><b>Total:&nbsp$actual_clock_hours_total</b></td>
    <td colspan=1 class='summary5'><b>Total:&nbsp$plan_output_total</b></td>
    <td colspan=1 class='summary6'><b>Total:&nbsp$actual_bac_qty_total</b></td>
    <td colspan=1 class='summary7'></td>
    <td colspan=1 class='summary8'><b>Total:&nbsp$plan_sah_total</b></td>
    <td colspan=1 class='summary9'><b>Total:&nbsp$actual_sah_total</b></td>
    <td colspan=1 class='summary10'></td>
    <td colspan=1 class='summary11'><b>Total:&nbsp$plan_eff_total</b></td>
    <td colspan=1 class='summary12'><b>Total:&nbsp$actual_eff_total</b></td>";
    echo"</tr>";
    
}

echo "</table></div>";
}
// header("Content-Type: application/xls");    
// header("Content-Disposition: attachment; filename=$filename");  
// header("Pragma: no-cache"); 
// header("Expires: 0");
?>
</body>
      </div>

       </div>
</div>
 <script type="text/javascript">
function getCSVData() {
//   $('table').attr('border', '1');
//   var uri = 'data:application/vnd.ms-excel;base64,'
//     , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><div><table>{table}</table></div></body></html>'
//     , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
//     , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  
//     var table = document.getElementById('report').innerHTML;
//     // $('thead').css({"background-color": "blue"});
//     var ctx = {worksheet: name || 'Efficiency Report', table : table}
//     //window.location.href = uri + base64(format(template, ctx))
//     var link = document.createElement("a");
//     link.download = "Efficiency Report.xls";
//     link.href = uri + base64(format(template, ctx));
//     link.click();
//     $('table').attr('border', '0');
//     $('table').addClass('table-bordered');
}
// $("#excel").click(function(e) {
//   let file = new Blob([$('#report').html()], {type:"application/octet-stream"});
// let url = URL.createObjectURL(file);
// let a = $("<a />", {
//   href: url,
//   download: "filename.xls"}).appendTo("body").get(0).click();
//   e.preventDefault();
// });
$(document).ready(function() {
   
   $('#excel').on('click', function(e) {
   
   var blob = new Blob([document.getElementById('report').innerHTML], {
   
   type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
   
   });
   saveAs(blob,"efficiency-report.xls"); 
   });
   });
</script>

<script>
    $("#checkbox").click(function() {
        
   
    
  
    if($(this).is(":checked")) {


        $("#demo").hide();
        $("#style").hide();
        $("#smv").hide();
        $("#days").hide();
        $(".test").hide();
        $(".style1").hide();
        $(".smv1").hide();
        $(".days1").hide();
        $(".style2").hide();
        $(".smv2").hide();
        $(".days2").hide();
        $(".test1").hide();

       
    }
     else
     {
        $("#demo").show();
        $("#style").show();
        $("#smv").show();
        $("#days").show();
        $(".test").show();
        $(".style1").show();
        $(".smv1").show();
        $(".days1").show();
        $(".style2").show();
        $(".smv2").show();
        $(".days2").show();
        $(".test1").show();

            
    }
    
});

$("#checkbox1").click(function() {
    if ( $("#checkbox").is(":checked") && $("#checkbox1").not(":checked") ){
      
        $(".style2").hide();
        $(".smv2").hide();
        $(".days2").hide();
        $(".test1").hide();
    }
    else{

 $(".style2").show();
        $(".smv2").show();
        $(".days2").show();
        $(".test1").show();
         
    }
    if($(this).is(":checked")) {

  $(".summary").hide();
        $(".summary1").hide();
        $(".summary2").hide();
        $(".summary3").hide();
        $(".summary4").hide();
        $(".summary5").hide();
        $(".summary6").hide();
        $(".summary7").hide();
        $(".summary8").hide();
        $(".summary9").hide();
        $(".summary10").hide();
        $(".summary11").hide();
        $(".summary12").hide();
        $(".style2").hide();
        $(".smv2").hide();
        $(".days2").hide();
        $(".test1").hide();

       

    }else{
      
        $(".summary").show();
        $(".summary1").show();
        $(".summary2").show();
        $(".summary3").show();
        $(".summary4").show();
        $(".summary5").show();
        $(".summary6").show();
        $(".summary7").show();
        $(".summary8").show();
        $(".summary9").show();
        $(".summary10").show();
        $(".summary11").show();
        $(".summary12").show(); 
    }

});

//  jQuery(document).ready(function($) {
//     $(".summary").hide();
//         $(".summary1").hide();
//         $(".summary2").hide();
//         $(".summary3").hide();
//         $(".summary4").hide();
//         $(".summary5").hide();
//         $(".summary6").hide();
//         $(".summary7").hide();
//         $(".summary8").hide();
//         $(".summary9").hide();
//         $(".summary10").hide();
//         $(".summary11").hide();
//         $(".summary12").hide();
//         $(".style2").hide();
//         $(".smv2").hide();
//         $(".days2").hide();
//         $(".test1").hide();
//  });
</script>
 <style>
        
        th,td{
        text-align:center;
        color:black;
        }
        
        
            </style>

