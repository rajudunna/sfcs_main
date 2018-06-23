<?php

include "confr.php";

$conf = new confr("../config-builder/saved_fields/fields.json");

var_dump(implode(',',$conf->get("category-display-dashboard")));
//var_dump( $conf->getDBConfig() );
//var_dump( $conf->getConnection() );
