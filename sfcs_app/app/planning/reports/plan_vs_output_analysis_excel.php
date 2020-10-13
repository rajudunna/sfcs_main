<?php
header("Content-type: application/x-msdownload");
# replace excelfile.xls with whatever you want the filename to default to
header("Content-Disposition: attachment; filename=Daily_Plan_Achievement_Report.xls");
header("Pragma: no-cache");
header("Expires: 0"); ?>
<style>
	body {
		font-family: calibri;
		font-size: 12px;
	}

	table tr {
		border: solid black;
		text-align: right;
		white-space: nowrap;
	}

	table td {
		border: solid black;
		text-align: right;
		white-space: nowrap;
		text-align: left;
	}

	table th {
		border: solid black;
		text-align: center;
		background-color: BLUE;
		color: WHITE;
		white-space: nowrap;
		padding-left: 5px;
		padding-right: 5px;
	}

	table {
		white-space: nowrap;
		border-collapse: collapse;
		font-size: 12px;
	}

	.tblheading th {
		background-color: #29759C;
	}
</style>
<?php
echo  $_POST['table'];
?>