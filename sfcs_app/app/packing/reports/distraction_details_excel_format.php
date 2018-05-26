<!--  2014-01-30/kirang/Ticket #372506 / Change the Intranet formats.  -->
<html>

<head>
<title>Out Of Ratio Report</title>
<style>
th
{
	color:black;
	font-size:12.0px;
	font-style:normal;
	font-family:century gothic;
	text-align:center;
	background:#EEE;
	white-space:nowrap;
	border-color:black;
}

td
{
	color:#000000;
	font-size:12.0px;
	font-style:normal;
	font-family:century gothic;
	text-align:left;
	background:#ffffff;
	white-space:nowrap;
	border-color:black;
}

</style>

</head>

<body>
<?php
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);

?>
<div id="page_heading"><span style="float: left"><h3>Destroyed Qty</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<form action="?r=<?= $_GET['r'] ?>" method="POST">
<table border="0" cellspacing="0" cellpadding="1">
<tr>
<th>Week Start #</th><th><input type="text" name="sdat" size="2" value="<?php  if(isset($_POST['sdat'])) { echo $_POST['sdat']; } else { echo date("W"); } ?>" /></th>
<th>Week End #</th><th><input type="text" name="edat" size="2" value="<?php  if(isset($_POST['edat'])) { echo $_POST['edat']; } else { echo date("W"); } ?>" /></th>
<th>Year #</th><th><input type="text" name="year" size="2" value="<?php  if(isset($_POST['year'])) { echo $_POST['year']; } else { echo date("Y"); } ?>" /></th>
<th><input type="submit" name="submit" value="Generate Excel Sheet" /></th>
</tr>
</table>
</form>

<?php
echo "<h2><a href='excel_upload.php'>Upload Data</a></h2>";
//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"excel_upload.php\"; }</script>";
?>

</body>

</html>
