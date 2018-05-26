<?php

class ConfigManager{

    private $db;

    public function __construct( array $config ) {
        $this->db = $this->db();
    }

    public function __destruct() {
		$this->db = NULL;
	}

    public function get($varible){
        if($this->db  == NULL){
            
        }
    }

    private function db(){
        $databaseName = "";
        $host = "";
        $userName = "";
        $password = "";
        $port = "";
        $mysqlConnection = new mysqli($host,$userName, $password, $databaseName, $port);
        if ($mysqlConnection->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqlConnection->connect_errno . ") " . $mysqlConnection->connect_error;
            return NULL;
        }
        return $mysqlConnection;
    }
}