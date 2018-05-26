
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'styles/dropdowntabs.js',1,'R') ?>"></script>
		<link rel="stylesheet" href="<?= '../'.getFullURLLevel($_GET['r'],'styles/ddcolortabs.css',1,'R') ?>" type="text/css" media="all" />
		
<style>
body
{
	font-family:calibri;
	font-size:12px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table td.new
{
	background-color: BLUE;
	color: WHITE;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
}


}

}
</style>

<style rel="stylesheet" type="text/css">
#div-1a {
 position:absolute;
 top:110px;
 right:0;
 width:auto;
float:right;
}
</style>


<link rel="stylesheet" type="text/css" media="all" href="<?= '../'.getFullURL($_GET['r'],'jsdatepick-calendar/jsDatePick_ltr.min.css','R') ?>" />
<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'jsdatepick-calendar/jsDatePick.min.1.3.js','R') ?>"></script>
<script type="text/javascript" src="<?= '../'.getFullURL($_GET['r'],'datetimepicker_css.js','R') ?>"></script>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
</head>
<div class='panel panel-primary'>
	<div class='panel-heading'>FR - Daily Plan Achievement Report</div>
<div class='panel-body'>
<?php include('../'.getFullURL($_GET['r'],"dbconf5.php",'R')); ?>

<form method="POST" action="?r=<?php echo $_GET['r'];?>" name="input">
<div class="row">
<div class="form-group col-md-3">
<label>Select Date: </label><input id="demo1" class="form-control" data-toggle="datepicker" type="text" name="sdate" size="8" value="<?php if(isset($_POST['sdate'])) { echo $_POST['sdate']; } else { echo date("Y-m-d"); } ?>">
</div>
<input type="submit" class='btn btn-primary' name="submit" value="submit" style="margin-top:22px;"/>
</div>

</form>


<?php


if(isset($_POST['submit']))
{
	echo "<hr/>";
	$sdate=$_POST['sdate'];
	$filename="../".getFullURL($_GET['r'],"FR_Plan/$sdate.htm","R");

	
	if(date('D', strtotime($sdate))=="Sun")
	{
		
		if(file_exists($filename))
		{

			header("Location:".$filename);
		}
		else
		{
			echo "<div class='alert alert-danger' role='alert'>Required File Was Not Available</div>";
		}
	}	
	else
	{
		echo "<div class='alert alert-warning' role='alert'>Please Select Sunday Date Only</div>";
	}
	
		
}
?>	
</div></div>
</html>
<?php ((is_null($___mysqli_res = mysqli_close($link))) ? false : $___mysqli_res); ?>