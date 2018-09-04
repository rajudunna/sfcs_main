<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/config.php", 4, 'R'));
$go_back_to = $_GET['go_back_to'];
// die();
echo "<div class=\"alert alert-success\">
<strong>Successfully Cutting Reported.</strong>
</div>";
if ($go_back_to == 'doc_track_panel_cut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel_cut.php',0,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_withrolls')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'cut_qty_reporting_withrolls/doc_track_panel.php',1,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_withrolls_recut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'cut_qty_reporting_withrolls/doc_track_panel_recut.php',1,'N')."'; }</script>";
}
else if ($go_back_to == 'doc_track_panel_without_recut')
{
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel.php',1,'N')."'; }</script>";
}


?>