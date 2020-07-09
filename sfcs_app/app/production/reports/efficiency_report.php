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
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    echo "<div class='table-responsive'>
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
$sql="select * from $bai_pro3.module_master where status='Active'";
$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));


while($row=mysqli_fetch_array($result))
{
    echo"<tr>";
    $module_name=$row["module_name"];
    echo "<td rowspan=3>".$module_name."</td>";  
    for ($i=0; $i < sizeof($shifts_array); $i++) {
    
    echo"<td>".$shifts_array[$i]."</td>
    <td class='test'></td>
    <td class='style1'></td>
    <td class='smv1'></td>
    <td class='days1'></td>";
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
          
}  
}else{
    $plan_eff=" ";
    $plan_clh=" ";
    $plan_sah=" ";
    $plan_pro=" ";
    $nop=" ";
  }
echo" <td colspan=1>$nop</td>";
    // while($row=mysqli_fetch_array($result)) {}  
    echo"<td colspan=1></td>
    <td colspan=1>$plan_clh</td>
    <td colspan=1></td>
    <td colspan=1>$plan_pro</td>
    <td colspan=1></td>
    <td colspan=1></td>
    <td colspan=1>$plan_sah</td>
    <td colspan=1></td>
    <td colspan=1></td>
    <td colspan=1>$plan_eff</td>
    <td colspan=1></td>";
    echo"</tr>";
    $a = implode("+", ($shifts_array));

   
    }
    echo"<tr >";
    echo"<td class='summary'>".$a."</td>
    <td class='test1'></td>";
    echo" <td class='style2'></td>
    <td class='smv2'></td>
    <td class='days2'></td>
    <td colspan=1 class='summary1'></td>
    <td colspan=1 class='summary2'></td>
    <td colspan=1 class='summary3'></td>
    <td colspan=1 class='summary4'></td>
    <td colspan=1 class='summary5'></td>
    <td colspan=1 class='summary6'></td>
    <td colspan=1 class='summary7'></td>
    <td colspan=1 class='summary8'></td>
    <td colspan=1 class='summary9'></td>
    <td colspan=1 class='summary10'></td>
    <td colspan=1 class='summary11'></td>
    <td colspan=1 class='summary12'></td>";
    echo"</tr>";
    
}

echo "</table></div>";
}

?>
      </div>

       </div>
</div>
 <script type="text/javascript">
function getCSVData() {
  $('table').attr('border', '1');
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  
    var table = document.getElementById('example1').innerHTML;
    // $('thead').css({"background-color": "blue"});
    var ctx = {worksheet: name || 'Efficiency Report', table : table}
    //window.location.href = uri + base64(format(template, ctx))
    var link = document.createElement("a");
    link.download = "Efficiency Report.xls";
    link.href = uri + base64(format(template, ctx));
    link.click();
    $('table').attr('border', '0');
    $('table').addClass('table-bordered');
}
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
    if($(this).is(":checked")) {
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
        $(".style2").hide();
        $(".smv2").hide();
        $(".days2").hide();
        $(".test1").hide();
        


        
        
    }else{
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
        
    }

});
 jQuery(document).ready(function($) {
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
 });
</script>
 <style>
        
        th,td{
        text-align:center;
        color:black;
        }
        
        
            </style>

