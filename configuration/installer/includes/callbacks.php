<?php

class Callbacks extends Callbacks_Core
{
	function mysqldatabaseSetUP($params = array()){

		$dbconf = array(
			'db_host' => $_SESSION['params']['mysql_db_hostname'],
			'db_user' => $_SESSION['params']['mysql_db_username'],
			'db_pass' => $_SESSION['params']['mysql_db_password'],
			'db_port' => $_SESSION['params']['mysql_db_port'],
			'db_encoding' => 'utf8',
		);
		
		$mysqli = new mysqli($dbconf['db_host'], $dbconf['db_user'], $dbconf['db_pass'], null, $dbconf['db_port']);
		
		// Check connection
		if ($mysqli->connect_error) {
			$this->error = "Database params are wrong";
			return false;
		}

		$jsonFile = file_get_contents(realpath("../API/saved_fields/fields.json"));
		$fields = json_decode($jsonFile, true);
		
		$fields["mysql_database_info"]["db_host"] = $dbconf["db_host"];
		$fields["mysql_database_info"]["db_user"] = $dbconf["db_user"];
		$fields["mysql_database_info"]["db_pass"] = $dbconf["db_pass"];
		$fields["mysql_database_info"]["db_port"] = $dbconf["db_port"];

		$finalString = json_encode($fields,JSON_PRETTY_PRINT);
		file_put_contents("../API/saved_fields/fields.json", $finalString);

		$databases = $fields['database']['mysql'];
		var_dump($databases);
		foreach ($databases as $key => $value) {
			$file = $value['sql_file'];
			$databaseName = $value['sql_title'];
			$dbconf['db_name'] = $databaseName;
		
			// Create database
			$sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
			if ($mysqli->query($sql) === TRUE) {
				$realPath =  realpath("../API/".$file);
				$command = exec("mysql -u {$dbconf['db_user']} -p{$dbconf['db_pass']} " . "-h {$dbconf['db_host']} -D {$dbconf['db_name']} < {$realPath}" );
			}else{
				$this->error = "Database not created ($databaseName)";
				return false;
			}
		}
		return true;
	}

	function mssqldatabaseSetUP($params = array()){
		return true;
		$dbconf = array(
			'db_host' => $_SESSION['params']['mssql_db_hostname'],
			'db_user' => $_SESSION['params']['mssql_db_username'],
			'db_pass' => $_SESSION['params']['mssql_db_password'],
			'db_port' => $_SESSION['params']['mssql_db_port'],
			'db_encoding' => 'utf8',
		);
		
		try{
			$db = new PDO("sqlsrv:Server=".$dbconf['db_host'].";Port=".$dbconf['db_port'], $dbconf['db_user'], $dbconf['db_pass']);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
		}
		
		// Check connection
		if ($mssqli->connect_error) {
			$this->error = "Database params are wrong";
			return false;
		}

		$jsonFile = file_get_contents(realpath("../API/saved_fields/fields.json"));
		$fields = json_decode($jsonFile, true);
		
		$fields["mssql_database_info"]["db_host"] = $dbconf["db_host"];
		$fields["mssql_database_info"]["db_user"] = $dbconf["db_user"];
		$fields["mssql_database_info"]["db_pass"] = $dbconf["db_pass"];
		$fields["mssql_database_info"]["db_port"] = $dbconf["db_port"];

		$finalString = json_encode($fields,JSON_PRETTY_PRINT);
    	file_put_contents("../API/saved_fields/fields.json", $finalString);

		$databases = $fields['database']['mssql'];
		
		foreach ($databases as $key => $value) {
			$file = $value['sql_file'];
			$databaseName = $value['sql_title'];
			$dbconf['db_name'] = $databaseName;
		
			// Create database
			$sql = "CREATE DATABASE IF NOT EXISTS $databaseName";
			if ($mssqli->query($sql) === TRUE) {
				$realPath =  realpath("../API/".$file);
				//echo $realPath;
				$command = exec("mssql -u {$dbconf['db_user']} -p{$dbconf['db_pass']} " . "-h {$dbconf['db_host']} -D {$dbconf['db_name']} < {$realPath}" );
			}else{
				$this->error = "Database not created ($databaseName)";
				return false;
			}
		}
		return true;
	}

	function MSSQLlinkedServerSP($params = array()){
		$mssql_ls_server = $_SESSION['params']['mssql_ls_server'];
		$mssql_ls_rmtuser = $_SESSION['params']['mssql_ls_rmtuser'];
		$mssql_ls_rmtpass = $_SESSION['params']['mssql_ls_rmtpass'];
		return true;
	}

	function MySQLlinkedServerSP($params = array()){
		$mysql_ls_server = $_SESSION['params']['mysql_ls_server'];
		$mysql_ls_rmtuser = $_SESSION['params']['mysql_ls_rmtuser'];
		$mysql_ls_rmtpass = $_SESSION['params']['mysql_ls_rmtpass'];
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
	
			$jsonFile = file_get_contents(realpath("../API/saved_fields/fields.json"));
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
			file_put_contents("../API/saved_fields/fields.json", $finalString);
	
			if(isset($params['callBackName'])){
				$callBackName = $params['callBackName'];
				include realpath("../API/call_back_scripts/".$callBackName.".php");
			}
			return true;
		}catch(Exception $e){
			return false;
		}
	}
}
