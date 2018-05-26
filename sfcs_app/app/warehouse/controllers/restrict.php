<?php
	// require_once('phplogin/auth.php');
	ob_start();
	// require_once "ajax-autocomplete/config.php";
?>

<?php include("dbconf.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!-- <script type="text/javascript" src="ajax-autocomplete/jquery.js"></script>
<script type='text/javascript' src='ajax-autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="ajax-autocomplete/jquery.autocomplete.css" />
 -->
<!-- <script type="text/javascript">
$().ready(function() {
	$("#course").autocomplete("ajax-autocomplete/get_course_list_rec_no.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
});
</script>
 -->
  <title>Stock In Form (NEW)</title>

  <link rel="stylesheet" href="includes/page_style.css" type="text/css" media="all" />
  <link rel="stylesheet" href="includes/ddcolortabs.css" type="text/css" media="all" />
  <script type="text/javascript" src="includes/dropdowntabs.js"></script>
  <script type="text/javascript" src="includes/js/check.js"></script>


</head>
<body onload="dodisable();">
<?php include("menu_content.php"); ?>

<?php

echo "<h2>Restricted to access this page and please contact ICT Team for further details.</h2>";
?>
</body>
</html>