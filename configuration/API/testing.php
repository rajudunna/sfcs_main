<?php

include "confr.php";

$conf = new confr("../config-builder/saved_fields/fields.json");

var_dump($conf->get("layplanmail"));
//var_dump( $conf->getDBConfig() );
//var_dump( $conf->getConnection() );
