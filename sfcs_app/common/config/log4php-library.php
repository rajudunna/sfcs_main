<?php
// Include the log4php php files
include ($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/log4php/Logger.php');
// Start the session - primarily to save a session name
// session_start();
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$origin= $_SERVER['HTTP_ORIGIN'];
$host= $_SERVER['HTTP_HOST'];
$method_request = $_SERVER['REQUEST_METHOD'];
$data = $_REQUEST;
$info_data=getallheaders();
$file_path=base64_decode($data['r']);

$main_data= json_encode($info_data);


//Use the configuration file for log4php
Logger::configure(array(
    'appenders' => array(
        'default' => array(
            'class' => 'LoggerAppenderDailyFile',
            'params' => array(
                'datePattern' => 'Y-m-d',
                'file' => 'integration_logs/log-%s.log',
            ),
        ),
    ),
    'rootLogger' => array(
        'level' => 'ERROR',
        'appenders' => array('default'),
    ),
));
//Logger::configure('config.xml');
// Create the $logger logging object
$logger = Logger::getLogger("main");
//To log INFO
function log_request($request_id) {
   // Use the logger that was create in the main routine
    global $logger;
    global $host;
    global $plant_code;
    global $username;
    global $main_data;
    global $method_request; 
    global $file_path;
   //INFO MEssage
   $error_info_message['id']=$request_id;
   $error_info_message['date']=date('Y-m-d h:i:s');
   $error_info_message['method']=$method_request;
   $error_info_message['url']=$file_path;
   $error_info_message['headers']=$main_data;
   $error_info_message['PlantCode']=$plant_code;
   $error_info_message['UserName']=$username;
   $main_result=json_encode($error_info_message);
   $logger->info(str_replace('\\', '', $main_result));
}
//To handle other errors
function log_statement($type,$error_message,$error_file,$error_line) {

    // Use the logger that was create in the main routine
    global $logger;
    global $origin;
    global $host;
    global $plant_code;
    global $username;
    global $main_data;
    global $method_request;
    global $file_path;

    //Put together the error message for the logging file
    $error_log_message['id']=$_REQUEST['unique_request'];
    $error_log_message['date']=date('Y-m-d h:i:s');
    $error_log_message['method']=$method_request;
    $error_log_message['url']=$file_path;
    $error_log_message['headers']=$main_data;
    $error_log_message['PlantCode']=$plant_code;
    $error_log_message['UserName']=$username;
    $error_log_message['Error']=$error_message;
    $error_log_message['File']=$error_file;
    $error_log_message['Line']=$error_line;
    $main_result=json_encode($error_log_message);
   
    switch($type)
    {
        case('error'):
        $logger->error(str_replace('\\', '', $main_result));
        break;

        case('debug'):
        $logger->debug(str_replace('\\', '', $main_result));
        break;
    }
}

?>