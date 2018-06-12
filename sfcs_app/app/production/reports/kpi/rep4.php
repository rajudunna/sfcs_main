
<?Php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',4,'R'));
 $view_access=user_acl("SFCS_0024",$username,1,$group_id_sfcs); 
?>
<?php 
// include("../dbconf.php"); 
?>
<LINK href="<?= getFullURLLevel($_GET['r'],'style.css',1,'R'); ?>" rel="stylesheet" type="text/css">
<!-- <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/datetimepicker_css.js',2,'R');?>"></script> -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',4,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',4,'R'); ?>"></script>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<div class="panel panel-primary">
<div class="panel-heading">Carton WIP</div>
<!--<div id="page_heading"><span style="float"><h3>Carton WIP</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
<div class="panel-body">
<form name="test" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">
<div class="col-sm-3">
From Date: <input type="text" data-toggle='datepicker' class="form-control" name="fdate" size="8" id="demo1" value="<?php  if(isset($_POST['fdate'])) { echo $_POST['fdate']; } else { echo date("Y-m-d"); } ?>" >
 </div>
 <div class="col-sm-3">
 To Date: <input type="text" data-toggle='datepicker' class="form-control" name="tdate" size="8" id="demo2" value="<?php  if(isset($_POST['tdate'])) { echo $_POST['tdate']; } else { echo date("Y-m-d"); } ?>" >
</div><br/>
<div class="col-sm-3">
<input type="submit" class="btn btn-primary" name="submit" onclick='return verify_date()' value="Show">
</div>
</form>

<?php

if(isset($_POST['submit']))
{
	$fdate=$_POST['fdate'];
	$tdate=$_POST['tdate'];
	
	$countqry="select count(*) as cnt from $bai_kpi.kpi_tracking where rep_date between \"$fdate\" and \"$tdate\" group by rep_date";
	$cntrslt=mysqli_query($link, $countqry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$row=mysqli_num_rows($cntrslt);
	
	if($row>0)
	{
	echo "<hr/><div class=\"table-responsive\"><table class='table table-bordered' id='table_one'>";
	echo "<tr style='background-color:#6995d6;color:white'>";
	echo "<th style='text-align:  center;'>Date</th>";
	echo "<th style='text-align:  center;'>Section 1</th>";
	echo "<th style='text-align:  center;'>Section 2</th>";
	echo "<th style='text-align:  center;'>Section 3</th>";
	echo "<th style='text-align:  center;'>Section 4</th>";
	echo "<th style='text-align:  center;'>Section 5</th>";
	echo "<th style='text-align:  center;'>Section 6</th>";
	echo "</tr>";
	
	$sql="select rep_date,sum(if(parameter='A2003' and title=1,value,0)) as sec1,sum(if(parameter='A2003' and title=2,value,0)) as sec2,sum(if(parameter='A2003' and title=3,value,0)) as sec3,sum(if(parameter='A2003' and title=4,value,0)) as sec4,sum(if(parameter='A2003' and title=5,value,0)) as sec5,sum(if(parameter='A2003' and title=6,value,0)) as sec6  from $bai_kpi.kpi_tracking where rep_date between \"$fdate\" and \"$tdate\" group by rep_date";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		echo "<tr>";
		echo "<td>".$sql_row['rep_date']."</td>";
		echo "<td>".$sql_row['sec1']."</td>";
		echo "<td>".$sql_row['sec2']."</td>";
		echo "<td>".$sql_row['sec3']."</td>";
		echo "<td>".$sql_row['sec4']."</td>";
		echo "<td>".$sql_row['sec5']."</td>";
		echo "<td>".$sql_row['sec6']."</td>";
		echo "</tr>";
	}
	
	echo "</table></div>";
	}
	else
	{
		echo "<div class='alert alert-danger'>No data found!</div>";
	}
}
?>
</div></div>
<script >
function verify_date()
{
	var val1 = $('#demo1').val();
	var val2 = $('#demo2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;
	}
}

// <script language="javascript" type="text/javascript">
//<![CDATA[	
	var table2_Props = 	{					
					// col_1: "select",
					// col_2: "select",
					// col_3: "select",
					display_all_text: " [ Show all ] ",
					btn_reset: true,
					bnt_reset_text: "Clear all ",
					rows_counter: true,
					rows_counter_text: "Total Rows: ",
					alternate_rows: true,
					sort_select: true,
					loader: true
				};
	setFilterGrid( "table_one",table2_Props );
//]]>		
// </script>
</script>
