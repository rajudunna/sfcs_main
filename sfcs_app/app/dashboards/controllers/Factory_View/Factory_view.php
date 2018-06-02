<html>
<script language="javascript">

function popup(Site)
{
window.open(Site,'PopupName','toolbar=no,statusbar=yes,menubar=yes,location=no,scrollbars=yes,resizable=yes,width=775,height=700');
}
</script>
<?php 

// include($_SERVER['DOCUMENT_ROOT']."/sfcs/server/db_hosts.php");
$sec_x = $_GET['sec_x'];
?>
<body onload="popup('<?php echo getFullURLLevel($_GET['r'],'plant_dash_board_v2.php',0,'R')."?sec_x=".$sec_x; ?>');">

</body>
</html>
