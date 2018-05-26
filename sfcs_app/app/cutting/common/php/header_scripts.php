<link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'/common/css/ddcolortabs.css',3,'R'); ?>" type="text/css" media="all" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'/common/js/dropdowntabs.js',3,'R'); ?>"></script>
<?php

// echo "<script language=\"javascript\" type=\"text/javascript\" src="styles/dropdowntabs.js"></script>";
// echo "<link rel=\"stylesheet\" href=\"styles/ddcolortabs.css\" type=\"text/css\" media=\"all\" />";

echo "<script language=\"javascript\" type=\"text/javascript\">";

echo "function popitup(url) {";
echo "	newwindow=window.open(url,"."'"."name"."'".",'"."scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0"."'".");";
echo "	if (window.focus) {newwindow.focus()}";
echo "	return false;";
echo "}";
echo "</script>";

echo "<script language=\"javascript\" type=\"text/javascript\">";

echo "function popitup2(url) {";
echo "	newwindow=window.open(url,"."'"."name"."'".",'"."scrollbars=1,menubar=1,resizable=1,location=0,toolbar=0"."'".");";
echo "	if (window.focus) {newwindow.focus()}";
echo "	return false;";
echo "}";
echo "</script>";


?>