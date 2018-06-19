<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));


?>
<head>
<!--<title>Extra Shipment Details</title>-->
<!--<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:0px; padding:0px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}

caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
<link href="<?= '../'.getFullURLLevel($_GET['r'],'common/css/style_new.css',3,'R') ?>" rel="stylesheet" type="text/css" />-->
<SCRIPT LANGUAGE="Javascript" SRC="<?= '../'.getFullURLLevel($_GET['r'],'dashboards/fusion_charts/FusionCharts/FusionCharts.js',1,'R') ?>"></SCRIPT>
<!--<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'datetimepicker_css.js','R') ?>"></script>

<link rel="stylesheet" type="text/css" media="all" href="<?= getFullURLLevel($_GET['r'],'movex_rep/reports/jsdatepick-calendar/jsDatePick_ltr.min.css',2,'R'); ?>" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'movex_rep/reports/jsdatepick-calendar/jsDatePick.min.1.3.js',2,'R'); ?>"></script>-->
<script type="text/javascript">
	// window.onload = function()
	// {
		// new JsDatePick({
			// useMode:2,
			// target:"demo1",
			// dateFormat:"%Y-%m-%d"
		// });
		// new JsDatePick({
			// useMode:2,
			// target:"demo2",
			// dateFormat:"%Y-%m-%d"
		// });
	// };
</script>

<?php
 // echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	
</head>


<div class='panel panel-primary'>
<div class='panel-heading'>Extra Shipment Details</div>
<div class='panel-body'>

<form action="<?= getFullURLLevel($_GET['r'],'index_data_old_new.php',0,'N') ?>" method="post">
<div class="row">
<div class="col-sm-3">
Ex-factory Start Date: 
<input type="text" size="8" data-toggle="datepicker" class="form-control" name="dat1" id="demo1" value="<?php  if(isset($_POST['dat1'])) { echo $_POST['dat1']; } else { echo date("Y-m-d"); } ?>" required />
<?php 
	// echo "<a href="."\"javascript:NewCssCal('demo1','yyyymmdd','dropdown')\">";
	// echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
?>&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<div class="col-sm-3">
Ex-factory End Date: 
<input type="text" name="dat2" size="8" data-toggle="datepicker" class="form-control" id="demo2" value="<?php  if(isset($_POST['dat2'])) { echo $_POST['dat2']; } else { echo date("Y-m-d"); } ?>" required />

<?php 
	// echo "<a href="."\"javascript:NewCssCal('demo2','yyyymmdd','dropdown')\">";
	// echo "<img src='images/cal.gif' width='16' height='16' alt='Pick a date'></a>";
?>&nbsp;&nbsp;&nbsp;&nbsp;
</div></br>
<div class="col-sm-3">
<input class='btn btn-primary' type="submit" name="submit" id="show" value="Show" onclick="return check_date()" />
</div> <!--Adding the please wait option -->
</div>
</form>
<span id="msg" style="display:none;"><h4>Please Wait.. While Processing Data..</h4></span>
</div>
</div>

<script>
function check_date()
{
	var startDate = document.getElementById("demo1").value;
    var endDate = document.getElementById("demo2").value;
    if(startDate > endDate)
    {
    	 sweetAlert('Start date should be less than End date','','warning');
    	 return false;
    }
    else
    {
    	return true;
    }
	
}
</script>