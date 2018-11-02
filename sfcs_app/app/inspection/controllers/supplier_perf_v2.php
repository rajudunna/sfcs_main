<?php
// Need to show summary of batches and update the log time for fully filled batches. Total Batches || Updated Batches || Pending Batches || Passed Batches || Failed Batches
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/headers.php',1,'R')); 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
$Page_Id='SFCS_0054';
?>
<style>
.lb-lg {
  font-size: 12px;
}
body{
    
    color:black;
}
.flt{
    width:100%;
}

</style>
<?php  


//$sql="select * from $bai_rm_pj1.inspection_supplier_db where product_code=\"Fabric\"";
$sql="SELECT * FROM $bai_rm_pj1.sticker_report WHERE product_group='Fabric' GROUP BY supplier";
$sql_result=mysqli_query($link, $sql) or exit("No Data Avaiable".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    $supplier_code[]=$sql_row["supplier"];
}
if(isset($_POST['filter']))
{
    $supplier1=$_POST['supplier'];
    $supplier_list1=array();
    if($supplier1)
    {
        foreach ($supplier1 as $t1)
        {
            $supplier_list1[]=$t1;
        }
    }
}
else
{   
    $supplier_list1=array();
    $supplier_list1[]="All";
}

?>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionCharts.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/FusionChartsExportComponent.js',3,'R'); ?>"></script>


<style>
.textbox{
    background-color:#99ff88;
    width:auto;
    border:none;
    color:black;
    height:100%;
}
.listbox{
    background-color:#99ff88;
    width:100%;
    border:none;
    color:black;
    height:100%;
}
.textspace{
    background-color:#99ff88;
    width:100%;
    border:none;
    color:black;
    height:100%;
}
</style>

<script>
function dodisablenew()
{
    document.getElementById('update').disabled='true';
}


function enableButton() 
{
    if(document.getElementById('option').checked)
    {
        document.getElementById('update').disabled='';
    } 
    else 
    {
        document.getElementById('update').disabled='true';
    }
}

function change_body(x,y,z)
{
    
    document.getElementById(y).style.background="#FFCCFF";
}


</script>

<script language="javascript" type="text/javascript">

function popitup(url) {
    newwindow=window.open(url,'name','height=500,width=650,resizable=yes,scrollbars=1,menubar=1');
    if (window.focus) {newwindow.focus()}
    return false;
}


</script>



<div class="panel panel-primary">
<div class="panel-heading">Supplier Performance Report Update</div>
<div class="panel-body">


<body onload="javascript:dodisablenew();">
<?php
$url=getFullURL($_GET['r'],'supplier_perf_v1.php','N'); 
?>
<form target="_blank" name="input" method="post" action="<?php echo $url; ?>">
<div>
<?php
    echo "<b style='color:red' >Note:The Selected Dates are GRN Dates </b>";
    ?>
</div>
<br>

<div class="row">
<div class="col-md-2">
<label>
Start Date </label><input type="text" class="form-control" data-toggle="datepicker" id="demo1"  name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>"> 
</div>
<div class="col-md-2">
<label>End Date </label><input  type="text" data-toggle='datepicker' class="form-control" size="8" name="edate" id="demo2"  value="<?php if(isset($_POST['edate'])) { echo $_POST['edate']; } else { echo date("Y-m-d"); } ?>">
</div>
<div class="col-md-2">
<label> Batch Ref </label><input type="text" name="batch_obj" class="form-control alpha" id="batch_obj" size=8 value="<?php if(isset($_POST['batch_obj'])) { echo $_POST['batch_obj']; }?>">
</div>
<div class="col-md-3">
<label>Supplier</label>
<select name="supplier[]" multiple="multiple" class="form-control"> 
<?php
echo implode(",",$supplier_list1);
if(in_array("All",$supplier_list1))
{   
    echo "<option value=\"All\" selected>All</option>";
}
else
{
    echo "<option value=\"All\">All</option>";
}

for($i=0;$i<sizeof($supplier_code);$i++)
{
    if(in_array($supplier_code[$i],$supplier_list1))
    {
        echo "<option value=\"".$supplier_code[$i]."\" selected>".$supplier_code[$i]."</option>";
    }
    else
    {
        echo "<option value=\"".$supplier_code[$i]."\">".$supplier_code[$i]."</option>";
    }
}

?>
</select>
</div>
<div class="col-md-2">
<label></label>
<input type="checkbox" value="1" name="excemptflag" id="excemptflag" >&nbsp;&nbsp;Excempt Inspection/Relaxation Results
</div>
<input type="submit" name="filter" value="Filter" onclick="return pop_check()" class="btn btn-success" style="margin-top: 22px;">
</div>
</form>


</body>

</div>
</div>
