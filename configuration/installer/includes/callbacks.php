<?php

class Callbacks extends Callbacks_Core
{

	function databaseSetUP($params = array()){
		$dbconf = array(
			'db_host' => $_SESSION['params']['db_hostname'],
			'db_user' => $_SESSION['params']['db_username'],
			'db_pass' => $_SESSION['params']['db_password'],
			'db_port' => $_SESSION['params']['db_port'],
			'db_encoding' => 'utf8',
		);
		
		$mysqli = new mysqli($dbconf['db_host'], $dbconf['db_user'], $dbconf['db_pass'], null, $dbconf['db_port']);
		
		// Check connection
		if ($mysqli->connect_error) {
			$this->error = "Database params are wrong";
			return false;
		}

		$jsonFile = file_get_contents(realpath("../config-builder/saved_fields/fields.json"));
		$fields = json_decode($jsonFile, true);
		
		$fields["database_info"]["db_host"] = $dbconf["db_host"];
		$fields["database_info"]["db_user"] = $dbconf["db_user"];
		$fields["database_info"]["db_pass"] = $dbconf["db_pass"];
		$fields["database_info"]["db_port"] = $dbconf["db_port"];

		$finalString = json_encode($fields,JSON_PRETTY_PRINT);
    	file_put_contents("../config-builder/saved_fields/fields.json", $finalString);

		$databases = $fields['database'];
		
		foreach ($databases as $key => $value) {
			$file = $value['sql_file'];
			$databaseName = $value['sql_title'];
			$dbconf['db_name'] = $databaseName;
		
			// Create database
			$sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
			if ($mysqli->query($sql) === TRUE) {

				$realPath =  realpath("../config-builder/".$file);
				//echo $realPath;
				
				$command = exec("mysql -u {$dbconf['db_user']} -p{$dbconf['db_pass']} " . "-h {$dbconf['db_host']} -D {$dbconf['db_name']} < {$realPath}" );

			}else{
				$this->error = "Database not created ($databaseName)";
				return false;
			}
		}
		return true;
	}


	function stepCallBack($params){

		try{

			$filedsNames = [
				"checkbox-group",
				"select",
				"text",
			];
	
			$stepIndex = $params['stepIndex'];
	
			$jsonFile = file_get_contents(realpath("../config-builder/saved_fields/fields.json"));
			$fields = json_decode($jsonFile, true);
			$step = $fields['steps'][$stepIndex];
			
			foreach ($step as $key => $value) {	
				if(isset($value['type']) && in_array($value['type'], $filedsNames) && isset($value['name']) ){
					$value['value'] = $_SESSION['params'][ $value['name']];
					$step[$key] = $value;
				}
			}
			$fields['steps'][$stepIndex] = $step;

			$finalString = json_encode($fields, JSON_PRETTY_PRINT);
			file_put_contents("../config-builder/saved_fields/fields.json", $finalString);
	
			if(isset($params['callBackName'])){
				$callBackName = $params['callBackName'];
				include realpath("../config-builder/call_back_scripts/".$callBackName.".php");
			}
			return true;
		}catch(Exception $e){
			return false;
		}
	}
}
