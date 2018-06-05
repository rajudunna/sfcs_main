<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- Mirrored from cnanney.com/journal/demo/apple-counter/countdown.php by HTTrack Website Copier/3.x [XR&CO'2010], Sun, 10 Jun 2012 13:52:35 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8"><!-- /Added by HTTrack -->
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="Countdown to a specific date using an Apple-style digit flip animation." />
<meta http-equiv="refresh" content="900;url=timer_boards.php?new=<?php echo date("His").rand(10,100); ?>" >
<title>BAI SAH</title>
<script type="text/javascript" src="ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<link rel="stylesheet" href="style/stylesheet.css" type="text/css" charset="utf-8" />

<script type="text/javascript" src="../Charts_New/FusionCharts.js"></script>
<SCRIPT LANGUAGE="Javascript" SRC="../fusion_charts/FusionCharts/FusionCharts.js"></SCRIPT>

<script>

function ahah(url, target) {
  document.getElementById(target).innerHTML = ' Fetching data...';
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (req != undefined) {
    req.onreadystatechange = function() {ahahDone(url, target);};
    req.open("GET", url, true);
    req.send("");
  }
}  

function ahahDone(url, target) {
  if (req.readyState == 4) { // only if req is "loaded"
    if (req.status == 200) { // only if "OK"
      document.getElementById(target).innerHTML = req.responseText;
    } else {
      document.getElementById(target).innerHTML=" AHAH Error:\n"+ req.status + "\n" +req.statusText;
    }
  }
}

function load(name, div) {
	ahah(name,div);
	return false;
}


</script>

<script type="text/javascript">
        counts = {};

        function format_number(text){ 
            return text.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        };
        
        function magic_number(element_name, value) {
            var elem = $(element_name);
            var current = counts[element_name] || 0;
            $({count: current}).animate({count: value}, {
                                        duration: 500,
                                        step: function() {
                                            elem.text(format_number(String(parseInt(this.count))));
                                        }});
            							counts[element_name] = value;
        };

        function update() {
            var jqxhr = $.getJSON("number.php?jsonp=?", function(data) {
								
                                magic_number("#number1", data[0]['n1']);
								magic_number("#number2", data[0]['n2']);
                       });
        };

        setInterval(update, 3000);
        update();
</script>
<style>
    #number1{
        font-size: 700%;
		
    }

    #number2{
        font-size: 350%;
	}

    .total{
        width: 100%;
	   }

    .label {
        color: #6aa135;
        font-size: 24px;
        padding-top: 10px;
        padding-bottom: 10px;
		font-family:Georgia, "Times New Roman", Times, serif;
		font-style:italic;
    }

    .count {
        text-shadow: 0 -1px 0 #72a441;
		color:#8cce5b;
		font-family:'BDCartoonShoutRegular', Arial, sans-serif;
    }

    #position {
        position:relative;left:51%; margin:0;
    }
</style>


</head>
<body>
<p class="go_back">BAI <?php echo date("M - Y"); ?></p>
<h1></h1>

<div id="wrap">

<div id="position">
<table>
<tr><td colspan=3 height="100" align="center">
	<div id="chart692div" style="float:left; padding-left:25px;"></div>
	<div id="chart693div" style="float:left; padding-left:25px;"></div>
 	<div id="chart61div" style="float:left; padding-left:25px;"></div>
   <script type="text/javascript">
	var myChart1 = new FusionCharts("Charts_New/VBullet.swf", "myChart1Id", "85", "250", "0", "0");
	myChart1.setDataURL("sah_monthly_status/hbullet1_include.php");
	myChart1.render("chart61div");
   </script>  
   <div id="chart6912div" style="float:left; padding-left:25px;"></div>
     
	 <div id="chart71div" style="float:left;"></div>
   <script type="text/javascript">
	var myChart2 = new FusionCharts("Charts_New/VBullet.swf", "myChart2Id", "85", "250", "0", "0");
	myChart2.setDataURL("sah_monthly_status/hbullet2_include.php");
	myChart2.render("chart71div");
   </script>	 
   <div id="chart6922div" style="float:left; padding-left:25px;"></div>
     
	 <div id="chart31div" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart3 = new FusionCharts("Charts_New/VBullet.swf", "myChart3Id", "85", "250", "0", "0");
	myChart3.setDataURL("sah_monthly_status/hbullet3_include.php");
	myChart3.render("chart31div");
   </script>	 
    <div id="chart6932div" style="float:left; padding-left:25px;"></div>
   
     
	 <div id="chart41div" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart4 = new FusionCharts("Charts_New/VBullet.swf", "myChart4Id", "85", "250", "0", "0");
	myChart4.setDataURL("sah_monthly_status/hbullet4_include.php");
	myChart4.render("chart41div");
   </script>	 
    <div id="chart6942div" style="float:left; padding-left:25px;"></div>
     
	 <div id="chart51div" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart5 = new FusionCharts("Charts_New/VBullet.swf", "myChart5Id", "85", "250", "0", "0");
	myChart5.setDataURL("sah_monthly_status/hbullet5_include.php");
	myChart5.render("chart51div");
   </script>	 
   	 <div id="chart6952div" style="float:left; padding-left:25px;"></div>
      
	 <div id="chart81div" align="center"  style="float:left;"></div>
   <script type="text/javascript">
	var myChart5 = new FusionCharts("Charts_New/VBullet.swf", "myChart5Id", "85", "250", "0", "0");
	myChart5.setDataURL("sah_monthly_status/hbullet6_include.php");
	myChart5.render("chart81div");
   </script>	  
  
</td></tr>
<tr>
<td style="padding-right:20px;"><div id="number1" class="count"></div></td><td style="border-left:1px solid black; padding-left:20px;"></td>
<td><div class="count"><font color=blue>Req./Day:</font></div><div id="number2" class="count"></div></td>
</tr>

</table>
 
 
</div>
</div>

</body>

</html>