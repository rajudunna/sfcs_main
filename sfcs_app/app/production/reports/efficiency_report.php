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
function styleFunction() {


  if (document.getElementById('checkbox').checked){
      alert('hii');
    document.getElementById("demo").style.display='none';
    document.getElementById("style").style.display='none';
    document.getElementById("smv").style.display='none';
    document.getElementById("days").style.display='none';
  }else{
    
    document.getElementById("demo").style.display='block';
    document.getElementById("style").style.display='block';
    document.getElementById("smv").style.display='block';
    document.getElementById("days").style.display='block';

  }
}


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
                    
				</div>	
                </form>
			</br>
			
 
<?php

if(isset($_POST['submit']))
{
	$fdat=$_POST['fdat'];
	$tdat=$_POST['tdat'];
   


    echo '<form action="'.getFullURL($_GET['r'],'export_excel3.php','R').'" method ="post" > 
            <input type="hidden" name="csv_text" id="csv_text">
           
            <input type="submit" class="btn btn-info" id="expexc" name="expexc" value="Export to Excel" onclick="getCSVData()">
            </form>';
    echo '<input type="checkbox" id="checkbox" name="checkbox" onclick="styleFunction()">
    <label style="color:black;">Hide Style Info</label><br></br>';
    echo "<div class='table-responsive'>
   <table  class=\"table table-bordered\" id='example1' name='example1'>";
    echo"<tr>
   <th  rowspan=2 >Line No</th>
   <th  rowspan=2 >Shift</th>
   <th  id='demo'  rowspan=2>Customer</th>
   <th id='style'  rowspan=2>Style</th>
   <th id='smv'  rowspan=2>SMV</th>
   <th id='days' rowspan=2>No of Days</th>
   <th  id='team' colspan=4>No of TM</th>
   <th  colspan=4>Clock Hours</th>
   <th  colspan=9>Output</th>
   <th colspan=9>SAH</th>
   <th colspan=4>Efficiency</th>
 



</tr>";
echo"<tr>
<th style='background-color:#a6b0ec;' colspan=2>Plan</th>
<th style='background-color:#90e6a4;' colspan=2>Actual</th>
<th style='background-color:#a6b0ec;' colspan=2>Plan</th>
<th style='background-color:#90e6a4;' colspan=2>Actual</th>
<th style='background-color:#a6b0ec;' colspan=3>Plan</th>
<th style='background-color:#90e6a4;' colspan=3>Actual</th>
<th  colspan=3>Variance</th>
<th style='background-color:#a6b0ec;' colspan=3>Plan</th>
<th style='background-color:#90e6a4;' colspan=3>Actual</th>
<th style='' colspan=3>Variance</th>
<th style='background-color:#a6b0ec;' colspan=2>Plan</th>
<th style='background-color:#90e6a4;' colspan=2>Actual</th>
</tr>";
$sql="select * from $bai_pro3.module_master where status='Active'";
$result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));


while($row=mysqli_fetch_array($result))
{
    echo"<tr>";
    $module_name=$row["module_name"];
    echo "<td rowspan=4>".$module_name."</td>";  
    for ($i=0; $i < sizeof($shifts_array); $i++) {
    echo"<tr>";
    echo"<td>".$shifts_array[$i]."</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>";
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
echo" <td colspan=2>$nop</td>";
    // while($row=mysqli_fetch_array($result)) {}  
    echo"<td colspan=2></td>
    <td colspan=2>$plan_clh</td>
    <td colspan=2></td>
    <td colspan=3>$plan_pro</td>
    <td colspan=3></td>
    <td colspan=3></td>
    <td colspan=3>$plan_sah</td>
    <td colspan=3></td>
    <td colspan=3></td>
    <td colspan=2>$plan_eff</td>
    <td colspan=2></td>";
    echo"</tr>";
    $a = implode("+", ($shifts_array));

   
    }
    echo"<td>".$a."</td><td></td>";
    echo" <td></td>
    <td></td>
    <td></td>
    <td colspan=2></td>
    <td colspan=2></td>
    <td colspan=2></td>
    <td colspan=2></td>
    <td colspan=3></td>
    <td colspan=3></td>
    <td colspan=3></td>
    <td colspan=3></td>
    <td colspan=3></td>
    <td colspan=3></td>
    <td colspan=2></td>
    <td colspan=2></td>";
    echo"</tr>";
    
}

echo "</table></div>";
// header("Content-type: application/x-msdownload"); 
// header('Content-Disposition: attachment; filename="filename.xls"');
// $data=stripcslashes($_REQUEST['csv_text']);
// echo $data; 

}

?>
      </div>

       </div>
</div>

<script>
// function getCSVData(){
// 	var dummytable = $('.fltrow').html();
// 	var dummytotal = $('.total_excel').html();
// 	$('.fltrow').html('');
// 	$('.total_excel').html('');
// 	var csv_value= $("#report").table2CSV({delivery:'value',excludeRows: '.fltrow .total_excel'});
// 	$("#csv_text").val(csv_value);	
// 	$('.fltrow').html(dummytable);
// 	$('.total_excel').html(dummytotal);

// }

	
</script>
<script language="javascript">
   function getCSVData(){
      var csv_value=$('#example1').table2CSV({delivery:'value'});
      $("#csv_text").val(csv_value);	
      }

 
 </script>  


 <style>
        table, tr, td {
            border: 1px black solid;
        }
        th,td{
        text-align:center;
        color:black;
        }
        #demo,#style,#smv,#days{
            background-color:#da7033;
        }
    </style>

