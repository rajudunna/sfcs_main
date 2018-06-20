<?php
if($_GET['msg']==1)
{
	echo "<h2>It's too late to access this page.</h2>";
	echo "<h2>Access Timings: <br/><br/>Morning: 7:15 to 9:45<br/><br/> 12:30 to 14:00<br/>Evening: 16:00 to 17:30</h2>";
}


if($_GET['msg']==2)
{
	echo "<h2>Dear Associate,</h2>";
	echo "<h2>Currently Planner is updating system, hence this report is not avalable between 7:45 to 9:45 AM, 12:30PM to 14:00PM and 16:00 to 17:30 PM.</h2>";
}


?>