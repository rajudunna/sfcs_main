<!--
Core Module: Here we can update rejections and replacement pcs.

Description: Here we can update rejections and replacement pcs.

Ticket #475514 - KiranG 2014-06-19
New version released to update job number against the rejections.

Cr# 215 / KiranG -2014/10/18
disabled date change option to avoid backdated reporting.

CR# 198 / kirang - 2014-11-22 / Rejection update panel need to change according to M3 reasons 

CR# 375 / kirang - 2014-12-22 / Submit validation for enable and disable button

-->

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
//include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',4,'R'));

//$View_access=user_acl("SFCS_0143",$username,1,$group_id_sfcs);

//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);


//Rejection Reasons with Keys Db
$rejections_fileds_array=array("Fabric_Miss Yarn","Fabric_Fabric Holes","Fabric_Slub","Fabric_F.Yarn","Fabric_Stain Mark","Fabric_Color Shade","Fabric_Heat Seal","Fabric_Trim","Cutting_Panel Un-Even","Cutting_Stain Mark","Cutting_Strip Match","Sewing_Cut Damage","Sewing_Heat Seal","Sewing_M' ment Out",
"Sewing_Un Even","Sewing_Shape Out Leg","Sewing_Shape Out waist","Sewing_Shape Out","Sewing_Stain Mark","Sewing_With out Label","Sewing_Trim shortage",
"Sewing_Sewing Excess","Machine Damages_Cut Holes","Machine Damages_Slip Stitch�s","Machine Damages_Oil Marks","Embellishment_Others EMB",
"Embellishment_Foil Defects","Embellishment_Embroidery","Embellishment_Print","Embellishment_Sequence","Embellishment_Bead",
"Embellishment_Dye","Embellishment_wash");

//Panel Form Rejections Codes
$panel_codes=array("PA","PB","PC","PD","PE","PF","PL","PB","PG","PH","PI","PK","PL","PM","PM","PN","PN","PN","PE","PO","PO","PO","PK","PK",
"PE","PU","PP","PQ","PR","PS","PT","PV","PW");

//Garment Form Rejection Codes
$garment_codes=array("GA","GB","GC","GD","GE","GF","GL","GB","GG","GH","GI","GK","GL","GM","GM","GN","GN","GN","GE","GO","GO","GO","GK","GK",
"GE","GU","GP","GQ","GR","GS","GT","GV","GW");

//Rejection Reasons
$rejections_array=array("Fabric_Miss Yarn"=>"0","Fabric_Fabric Holes"=>"1","Fabric_Slub"=>"2","Fabric_F.Yarn"=>"3","Fabric_Stain Mark"=>"4","Fabric_Color Shade"=>"5","Fabric_Heat Seal"=>"15","Fabric_Trim"=>"16","Cutting_Panel Un-Even"=>"6","Cutting_Stain Mark"=>"7","Cutting_Strip Match"=>"8","Sewing_Cut Damage"=>"9","Sewing_Heat Seal"=>"11","Sewing_M' ment Out"=>"12","Sewing_Un Even"=>"17","Sewing_Shape Out Leg"=>"18","Sewing_Shape Out waist"=>"19","Sewing_Shape Out"=>"13","Sewing_Stain Mark"=>"10","Sewing_With out Label"=>"20","Sewing_Trim shortage"=>"21","Sewing_Sewing Excess"=>"22","Machine Damages_Cut Holes"=>"23",
"Machine Damages_Slip Stitch�s"=>"24","Machine Damages_Oil Marks"=>"25","Embellishment_Others EMB"=>"14","Embellishment_Foil Defects"=>"26","Embellishment_Embroidery"=>"27","Embellishment_Print"=>"28","Embellishment_Sequence"=>"29","Embellishment_Bead"=>"30","Embellishment_Dye"=>"31",
"Embellishment_wash"=>"32");

$rej_val=array(0,1,2,3,4,5,15,16,6,7,8,9,11,12,17,18,19,13,10,20,21,22,23,24,25,14,26,27,28,29,30,31,32);
/*
$sql="select * from menu_index where list_id=178";
$result=mysql_query($sql,$link) or mysql_error("Error=".mysql_error());
while($row=mysql_fetch_array($result))
{
	$users=$row["auth_members"];
}

$author_id_db=explode(",",$users);

if(in_array($username,$author_id_db))
{
	
}
else
{
	header("Location:restricted.php");
}
*/
?>
<!DOCTYPE html>
<html>
<title>Rejection Update Panel</title>
<head>
<style>
div.vertical-text {
	transform: rotate(90deg);
	transform-origin: left top 0;
}
</style>

<style type="text/css">
#page_heading{
    width: 100%;
    height: 25px;
    color: WHITE;
    background-color: #29759c;
    z-index: -999;
    font-family:Arial;
    font-size:15px;  
    margin-bottom: 10px;
}
#page_heading h3{
	vertical-align: middle;
	margin-left: 15px;
	margin-bottom: 0;	
	padding: 0px;
 }

#page_heading img{
    margin-top: 2px;
    margin-right: 15px;
}
body
{
	background-color: #EEEEEE;
}
table.gridtable {
	font-family:arial;
	font-size:12px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
	/*height: 100%; 
	width: 100%;*/
}
table.gridtable th {
	border-width: 1px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
table.gridtable td {
	border-width: 1px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
	text-align:center;
	vertical-align: text-bottom;
	word-span:nowrap;
}
</style>
<script>
 
function disp(x)
{
	
	//alert("test");
	//alert(x);
	document.getElementById("qty["+x+"]").style.backgroundColor="red";
	document.getElementById("demos"+x).style.backgroundColor="red";
	
	//document.getElementById("test["+x+"]").value=0;
	//val=document.input["ref["+x+"]"].value;
	style=document.getElementById("style["+x+"]").value;
	//alert(style);
	schedule=document.getElementById("schedule["+x+"]").value;
	//alert(schedule);
	color=document.getElementById("color["+x+"]").value;
	//alert(color);
	size=document.getElementById("size["+x+"]").value;
	//alert(size);
	shift=document.getElementById("shift["+x+"]").value;
	//alert(shift);
	job=document.getElementById("job["+x+"]").value;
	//alert(job);
	forms=document.getElementById("form["+x+"]").value;
    qty=document.getElementById("qty["+x+"]").value;
	//alert(qty);
	modno=document.getElementById("mods["+x+"]").value;
	//alert(modno);
	
	document.getElementById("modules["+x+"]").value=document.getElementById("mods["+x+"]").value;;
	
	//alert(size+"-"+job+"-"+forms+"-"+color+"-"+style+"-"+schedule+"-"+modno);
	//alert(qty);
	breakup=0;
	for(i=0;i<33;i++)
	{
		//alert(x+"-"+i);
		if(parseInt(document.getElementById("ref["+x+"]["+i+"]").value)>0)
		{
			breakup=breakup + parseInt(document.getElementById("ref["+x+"]["+i+"]").value);
		}
		
	}

	//alert(breakup);
	if(qty>0)
	{
		//alert('Test');
		document.getElementById("qty["+x+"]").style.backgroundColor="red";
		document.getElementById("test["+x+"]").value=0;
		
		if(style.length>0 && schedule.length>0 && color.length>0 && size.length>0 && job.length>0 && modno!=0 && shift!=0)
		{
			//alert('Test--1');
			if(qty==breakup)
			{
				document.getElementById("qty["+x+"]").style.backgroundColor="green";
				document.getElementById("test["+x+"]").value=1;
			}
		}
		else
		{
			alert("Please fill all the required details");
			
			document.getElementById("qty["+x+"]").value=0;
			document.getElementById("demo"+x).style.backgroundColor="red";
			document.getElementById("demos"+x).style.backgroundColor="red";
			document.getElementById("test["+x+"]").value=0;
			
		}		
	}
	else
	{
		document.getElementById("demo"+x).style.backgroundColor="red";
		document.getElementById("demos"+x).style.backgroundColor="red";
		document.getElementById("test["+x+"]").value=0;
	}
	
}


 function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('submit').style.visibility="hidden";
}


function dodisable()
{
document.getElementById('submit').disabled='true';
document.getElementById('process_message').style.visibility="hidden";
}

function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('submit').disabled='';
	} 
	else 
	{
		document.getElementById('submit').disabled='true';
	}
}

function check1(x) 
{
	if(x==0)
	{
		document.input.submit.style.visibility="hidden"; 
	} 
	else 
	{
		
		document.input.submit.style.visibility=""; 
	}
}
</script>



 <script type="text/javascript">
String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "");
};


function showUser(str,x,y,val)
{
//alert(str+"-"+x+"-"+y+"-"+val);

//alert(document.getElementById("schedule[0]").value);

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    	//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		//document.getElementById("11").innerHTML=xmlhttp.responseText;
		// alert(xmlhttp.responseText);
		
		if(str==1)
		{
			var result=xmlhttp.responseText.split("$");
			document.getElementById(result[0].trim()).innerHTML=result[1];
			var result=xmlhttp.responseText.split("$");
			document.getElementById(result[2].trim()).innerHTML=result[3];			
		}
		else
		{
			var result=xmlhttp.responseText.split("$");
			document.getElementById(result[0].trim()).innerHTML=result[1];
			var result=xmlhttp.responseText.split("$");
			document.getElementById(result[2].trim()).innerHTML=result[3];
		}
		
	}
  }
//alert(str); 
var get_url = '<?= getFullURLLevel($_GET['r'],'getuser2.php',0,'R'); ?>';
switch(str)
{
	case 1:
		xmlhttp.open("GET",get_url+"?qq="+str+"&x="+x+"&y="+y+"&val="+val+"&rand="+Math.random(),true);
		xmlhttp.send();
		break;
	case 2:
		val=document.input["schedule["+x+"]"].value+"$"+val;
		xmlhttp.open("GET",get_url+"?qq="+str+"&x="+x+"&y="+y+"&val="+val+"&rand="+Math.random(),true);
		xmlhttp.send();
		break;
	case 3:
		//val=document.input["style["+x+"]"].value+"$"+document.input["schedule["+x+"]"].value+"$"+document.input["color["+x+"]"].value+"$"+val;
		val=document.getElementById("style["+x+"]").value+"$"+document.getElementById("schedule["+x+"]").value+"$"+document.getElementById("color["+x+"]").value+"$"+val;
		//alert(val);
		xmlhttp.open("GET",get_url+"?qq="+str+"&x="+x+"&y="+y+"&val="+val+"&rand="+Math.random(),true);
		xmlhttp.send();
		break;
	case 4:
		//val=document.input["style["+x+"]"].value+"$"+document.input["schedule["+x+"]"].value+"$"+document.input["color["+x+"]"].value+"$"+document.input["job["+x+"]"].value+"$"+val;
		val=document.getElementById("style["+x+"]").value+"$"+document.getElementById("schedule["+x+"]").value+"$"+document.getElementById("color["+x+"]").value+"$"+document.getElementById("job["+x+"]").value+"$"+val;
		xmlhttp.open("GET",get_url+"?qq="+str+"&x="+x+"&y="+y+"&val="+val+"&rand="+Math.random(),true);
		xmlhttp.send();
		break;	
		
	case 5:
		//val=document.input["style["+x+"]"].value+"$"+document.input["schedule["+x+"]"].value+"$"+document.input["color["+x+"]"].value+"$"+document.input["job["+x+"]"].value+"$"+val;
		val=document.getElementById("style["+x+"]").value+"$"+document.getElementById("schedule["+x+"]").value+"$"+document.getElementById("color["+x+"]").value+"$"+document.getElementById("job["+x+"]").value+"$"+document.getElementById("size["+x+"]").value+"$"+val;
		xmlhttp.open("GET",get_url+"?qq="+str+"&x="+x+"&y="+y+"&val="+val+"&rand="+Math.random(),true);
		xmlhttp.send();
		break;
		
	case 6:
		val=document.input["style["+x+"]"].value+"$"+document.input["schedule["+x+"]"].value+"$"+document.input["color["+x+"]"].value+"$"+document.input["job["+x+"]"].value+"$"+document.getElementById("size["+x+"]").value+"$"+document.getElementById("mods["+x+"]").value+"$"+val;
		//val=document.getElementById("mods["+x+"]").value+"$"+document.getElementById("color["+x+"]").value+"$"+document.getElementById("job["+x+"]").value+"$"+document.getElementById("size["+x+"]").value+"$"+val;
		//alert(val);
		xmlhttp.open("GET",get_url+"?qq="+str+"&x="+x+"&y="+y+"&val="+val+"&rand="+Math.random(),true);
		xmlhttp.send();
		break;
			
	
}

}
</script>
<script type="text/javascript" src="check_new.js"></script>

<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

        var version = navigator.appVersion;

        function showKeyCode(e) {
            var keycode = (window.event) ? event.keyCode : e.keyCode;

            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }
            }
        }

    </script>
</head>
<body onload="javascript:dodisable();" onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">
<div id="page_heading"><span style=""><h3>Rejections Update Panel</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
<div id="process_message"><font color="red" size="3">Please wait while updating data!!!</font><br/><font color="blue"size="3">After update, this window will close automatically!</font></div>
<form name="input" method="post" action="process2.php">
<?php
echo "<input type=\"checkbox\" name=\"option\"  id=\"option\" onclick=\"javascript:enableButton();\">Enable";
echo "<input type=\"submit\" id=\"submit\" name=\"Update\" value=\"Update\" onclick=\"javascript:button_disable();\">";
?>

<table class="gridtable">
<tr>
<th rowspan="4">Style</th><th rowspan="4">Sch#</th><th rowspan="4">Color</th><th rowspan="4">Job#</th><th rowspan="4">Sizes</th>
<th rowspan="4">Mod#</th><th rowspan="4">Shift</th><th rowspan="4">Form<br>(Garment<br>/Panel)</th><th rowspan="4">Qty</th><th colspan="8" style="background-color:#FFFF33;">Fabric</th><th colspan="3" style="background-color:#33CC33;">Cutting</th>
<th colspan="11" style="background-color:#FF9966;">Sewing</th><th colspan="3" style="background-color:#CCCCFF;">Machine Damages</th><th colspan="8" style="background-color:#99CCFF;">Embellishment</th>
</tr>
<tr>
<?php

for($m1=0;$m1<sizeof($rejections_array);$m1++)
{
	echo "<td Style=\"background-color:#FFCCCC;\">".$panel_codes[$m1]."</td>"; 
}

?>
</tr>
<tr>
<?php

for($m1=0;$m1<sizeof($rejections_array);$m1++)
{
	echo "<td Style=\"background-color:#FFCCCC;\">".$garment_codes[$m1]."</td>"; 
}

?>
</tr>
<?php
function verticaltext($string) 
{        
	$tlen = strlen($string);        
	for($i=0;$i<$tlen;$i++)       
	{             
		$vtext .= substr($string,$i,1)."<br />";          
	}        
	return $vtext; 
}

echo "<tr>";

for($m1=0;$m1<sizeof($rejections_array);$m1++)
{
	$img_name= '../common/images/Images_Reasons/'.$rejections_fileds_array[$m1].'.png';
	// echo $img_name;
	$img_url = getFullURLLevel($_GET['r'],$img_name,1,'R');
	echo "<td><img src='$img_url'></img></td>"; 
}
echo "</tr>";

for($i=0;$i<15;$i++)
{
  echo "
  <tr>
  <td id='$i"."0'></td>
  <td id='$i"."1'><input type=\"text\" size=\"8\" id=\"schedule[$i]\" style=\"border-style:none;\" name=\"schedule[$i]\" onchange=\"showUser(1,$i,1,this.value)\"></td>
  <td id='$i"."2'>&nbsp;</td>
  <td id='$i"."3'></td>
  <td id='$i"."4'>&nbsp;</td>";
  //Panel 5 added to display the modules numbers
  echo "<td id='$i"."5'></td>";
  
  //Shift details added to update mutiple schedules and multiple modules rejection details at one time
  echo "<td><select name=\"shift[$i]\"><option value=\"0\">Select</option><option value=\"A\">A</option><option value=\"B\">B</option></select></td>";

  //To identify the form of the garment		
  echo "<td><select name=\"form[$i]\" onchange=\"showUser(6,$i,1,this.value)\"><option value=\"0\">Select</option><option value=\"P\">Panel</option><option value=\"G\">Garment</option></select></td>";
  
  // echo "<td class=xl11531661 style='border-left:none' id='$i"."6'>
  // </td>";
  echo "<td class=xl11531661 style='border-left:none' >
  <input type=\"hidden\" id=\"modules[$i]\" style=\"border-style:none;\" name=\"modules[$i]\" size=\"5\" value=\"\">
  <input type=\"text\" id=\"qty[$i]\" class=\"integer\" style=\"border-style:none;\" name=\"qty[$i]\" size=\"5\" value=\"\" onkeyup='verify_alpha(event)' onchange=\"disp($i)\"> <input type=\"hidden\" id=\"test[$i]\" name=\"test[$i]\" value=\"0\"></td>";
  
  for($m=0;$m<sizeof($rejections_array);$m++)
  {
	echo "<td><input type=\"text\" size='1' style=\"border-style:none;\" id=\"ref[$i][$rej_val[$m]]\" name=\"ref[$i][$rej_val[$m]]\" value=\"\" onchange=\"disp($i)\"></td>";
  } 
  
  echo "</tr>";
}

?>
</table>
</form>

</body>
</html>