<html>
<head>
<script language="javascript">
<!-- begin

function popup(Site)
{
window.open(Site,'PopupName','toolbar=no,statusbar=yes,menubar=yes,location=no,scrollbars=yes,resizable=yes,width=775,height=700');
}

// end -->
</script>
</head>
<!--<body onLoad="popup('test_new.php')"> -->
<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
?>
<body onLoad="<?php echo "var ajax_url ="."'".getFullURL($_GET['r'],'test_new.php','N')."'";'Ajaxify(ajax_url)'; ?>">

</body>

</html>