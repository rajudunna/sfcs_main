<html>
<head>

</style>

<div id=\"msg\"><center><br/><br/><br/><h1><font color="red">Sorry..Already Quantity Allocated more than Scheduled Quantity</font></h1></center></div>

<div id=\"msg\"><center><br/><br/><br/><h3><font color="red">Please Contact RM manager</font></h3></center></div>

<br><br><div class="alert alert-warning" style='color:blue'> <strong>Please Wait!</strong> You Will be Redirected Back...	</div>
<?php
    //this is for after allocating article redirect to cps dashboard.removed sfcsui
    $php_self = explode('/',$_SERVER['PHP_SELF']);
    array_pop($php_self);
    $url_r = base64_encode(implode('/',$php_self)."/fab_priority_dashboard.php");
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/index.php?r=".$url_r;
    echo"<script>location.href = '".$url."';</script>"; 
?>

