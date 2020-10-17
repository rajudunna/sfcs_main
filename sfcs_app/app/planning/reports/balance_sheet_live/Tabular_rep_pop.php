<?php

set_time_limit(2000);
if (isset($_GET['style_id'])) {
    $start_week = $_GET['week_start'];
    $end_week = $_GET['week_end'];
    $style_id = $_GET['style_id'];
    include $_SERVER['DOCUMENT_ROOT'] . '/' . getFullURLLevel($_GET['r'], 'common/config/config.php', 4, 'R');
    $plantcode = $_SESSION['plantCode'];
    $username = $_SESSION['userName'];

    ?>

<html>
<head>
<div class="panel panel-primary">
<div class="panel-heading">
Movex Analytical - POPUP REPORT
</div>

<script language="javascript" type="text/javascript" src="<?=getFullURLLevel($_GET['r'], 'common/js/dropdowntabs.js', 4, 'R');?>"></script>
<link rel="stylesheet" href="<?=getFullURLLevel($_GET['r'], 'common/css/ddcolortabs.css', 4, 'R');?>" type="text/css" media="all" />
<link href="<?=getFullURLLevel($_GET['r'], 'common/css/table_style.css', 4, 'R');?>" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="panel-body">
<span><h2>Order Status - POP REPORT</h2></span>

<?php
$table = '';
    $table .= "<table class=table table-bodered>";
    $table .= "<tr class=danger>";
    $table .= "<th>Style</th>";
    $table .= "<th>Schedule</th>";
    $table .= "<th>Color</th>";
    $table .= "<th>Ex-Factory Date</th>";
    $table .= "<th>Order Qty</th>";
    $table .= "<th>Cut Qty</th>";
    $table .= "<th>%</th>";
    $table .= "<th>Sewing In Qty</th>";
    $table .= "<th>%</th>";
    $table .= "<th>Sewing Out Qty</th>";
    $table .= "<th>%</th>";
    $table .= "<th>Pack Qty</th>";
    $table .= "<th>%</th>";
    $table .= "<th>Ship Qty</th>";
    $table .= "<th>%</th>";
    $table .= "</tr>";

	$table .= "</table>";
	echo $table;
}?>

</div>
</div>

</body>
</html>


