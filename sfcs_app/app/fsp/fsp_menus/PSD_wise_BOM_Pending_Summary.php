<html>
<script language="javascript">

function popup(Site)
{
window.open(Site,'PopupName','toolbar=no,statusbar=yes,menubar=yes,location=no,scrollbars=yes,resizable=yes,width=775,height=700');
}
</script>
<?php 
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
?>
<body onload="popup('<?php echo $dnr_adr_sp_chain; ?>/prj_rmw_0001/PRJ_RMW_0001_S_0040_REP_FORMAT_8_POP.cshtml');">

</body>
</html>
