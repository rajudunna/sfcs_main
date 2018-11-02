<?php
require "flyway.php";

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

$flyway = new Flyway($link);
$flyway->migrate();
    

