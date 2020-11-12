<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/server_urls.php',3,'R')); 
$plantCode = $_SESSION['plantCode'];
$filePath=$schedulerIp."/sfcs_app/app/quality/reports/critical_rejection_report_new_".$plantCode.".htm"
?>
<script>
function PopupCenterSection(pageURL, title,w,h) { 
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
  } 
</script>
<style>
	.example_b {
color: #fff !important;
text-transform: uppercase;
text-decoration: none;
background: #2a3f54;;
padding: 20px;
border-radius: 50px;
display: inline-block;
border: none;
transition: all 0.4s ease 0s;
}

.example_b:hover {
text-shadow: 0px 0px 6px rgba(255, 255, 255, 1);
-webkit-box-shadow: 0px 5px 40px -10px rgba(0,0,0,0.57);
-moz-box-shadow: 0px 5px 40px -10px rgba(0,0,0,0.57);
transition: all 0.4s ease 0s;
}
</style>

<div class="button_cont" align="center"><a href="javascript:void(0);" onclick="PopupCenterSection('<?=$filePath?>','myPop1',800,600);" class="example_b">Click Here to Get Report</a></div>


