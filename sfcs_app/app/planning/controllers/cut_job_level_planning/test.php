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

include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'N'));

?>
<body onLoad="<?php echo "popup('test_new.php')"; ?>">

</body>

</html>