<?php
    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include("..".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));

$view_access=user_acl("SFCS_0066",$username,1,$group_id_sfcs);
?>
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
<!--<body onLoad="popup('http://bainet:8080/projects/alpha/anu/new_int_v4/new_factory_eff2_copy_new.php')"> -->
<?php $url=getFullURLLevel($_GET['r'],'Hourly_Eff_test_rework.php',0,'R') ?>

<body onLoad="<?php echo "popup('$url')"; ?>">
</body>

</html>   


