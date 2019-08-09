<?php
if(isset($_POST['submit']))
{
header("Content-type: application/octet-stream");
$title_name=$_POST['title'];
header("Content-Disposition: attachment; filename=\"".$title_name.".csv\"");
$data=stripcslashes($_POST['table']);
echo $data;
} 
?>