<?php

include "confr.php";

$conf = new confr("../config-builder/saved_fields/fields.json");

echo $conf->get("select-1528429950732");
var_dump( $conf->getDBConfig() );
var_dump( $conf->getConnection() );
