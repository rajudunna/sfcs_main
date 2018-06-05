<html>
<head>
<script language="javascript">

function pop(url1)
{
//window.close();
var url = 'http://192.168.0.110:8084/sfcs_app/app/quality/controllers/pending.php';
console.log(url);
window.open(url,'PopupName','toolbar=no,statusbar=yes,menubar=yes,location=no,scrollbars=yes,resizable=yes,width=775,height=700');
}

// end -->
</script>
</head>
<!--<body onLoad="popup('http://bainet:8080/projects/alpha/anu/new_int_v4/new_factory_eff2_copy_new.php')"> -->
<body onLoad="pop('http://localhost:8080/sfcs_app/app/quality/controllers/pending.php')" >

</body>

</html>