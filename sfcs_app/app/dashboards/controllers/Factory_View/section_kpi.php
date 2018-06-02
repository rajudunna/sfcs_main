<?php include("../../../../common/config/config.php"); ?>


<html>
<head>
<style>
	body
{
	background-color:#EEEEEE;
	color: #000000;
	font-family: Arial;
	font-size:15px;
}
a {text-decoration: none;}

table
{
	border-collapse:collapse;
	background-color:white;
	border-bottom: 3px solid black;
	border-right: 1px solid #000000;
	position: absolute;
	zoom: 125%;
}
td
{
	border-top: 3px solid black;
	border-left: 1px solid black;
	white-space:nowrap;
	border-collapse:collapse;
	text-align:center;
	padding:5px;
	text-align: center;
	float: center;
}

td div
{
	float: center;

}

.heading
{
	font-size:20px;
	text-align: right;
	text-align: center;
	float: center;
}

th
{
	font-size:25px;
	border-top: 3px solid black;
	border-left: 1px solid black;
	white-space:nowrap;
	border-collapse:collapse;
	text-align: center;
	float: center;
}



.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: black; font-family: Arial; font-size:12px; } 

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: black; font-family: Arial; font-size:12px; } 

a{
	text-decoration:none;
	color: black;
}

#white {
  width:40px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#white a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#white a:hover {
  text-decoration:none;
  background-color: #ffffff;
}


#red {
  width:40px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

#green {
  width:40px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#green a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#green a:hover {
  text-decoration:none;
  background-color: #00ff00;
}

#yellow {
  width:40px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#yellow a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#yellow a:hover {
  text-decoration:none;
  background-color: #ffff00;
}


#pink {
  width:40px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#pink a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#pink a:hover {
  text-decoration:none;
  background-color: #ff00ff;
}

#orange {
  width:40px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#orange a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#orange a:hover {
  text-decoration:none;
  background-color: #991144;
}

#blue {
  width:40px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#blue a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}


#yash {
  width:40px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

#yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#yash a:hover {
  text-decoration:none;
  background-color: #999999;
}

#black {
  width:40px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
}

#black a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

#black a:hover {
  text-decoration:none;
  background-color: black;
}

</style>

</head>

<body>

<?php

$sec_x=$_GET['sec_x'];

?>

<table align="left">
<tr><th colspan="2">KPI</th></tr>
<tr><td class="heading">IPS</td><?php include("pps.php"); ?></tr>



<tr><td class="heading">IMS</td><?php include("ims.php"); ?></tr>

<tr><td class="heading">RLS</td><?php include("rls.php"); ?></tr>

<tr><td class="heading">LMS</td><?php include("lms.php"); ?></tr>



<tr><td class="heading">SAH</td><?php include("live.php"); ?></tr>


<!-- <tr><td class="heading">HRM</td><?php include("live_hr.php") ?></tr> -->
</table>

</body>

</html>
