<?php
//Set a custom error handler
set_error_handler("customErrorHandler");

 //Set Last Chance Exception Handler
 set_exception_handler("customExceptionHandler");


//Custom Exception Handler - Calls customErrorHandler
function customExceptionHandler($Exception) {
    customErrorHandler(E_USER_ERROR, $Exception->getmessage(), $Exception->getfile(), $Exception->getline(), null);    
}    
// Customer Error Handler
function customErrorHandler($error_level, $error_message, $error_file, $error_line, $error_context) {
    // Use the logger that was create in the main routine
    global $logger;
    //Display the error on the screen - comment out for productional system
    //echo "<b>Error:</b> [$error_level] $error_message. $error_file, $error_line <br>";
    //Put together the error message for the logging file
    $error_log_message['id']=$_REQUEST['unique_request'];
    $error_log_message['date'].=date('Y-m-d h:i:s');
    $error_log_message['Error'].=$error_message;
    $error_log_message['File'].=$error_file;
    $error_log_message['Line'].=$error_line;
    // $error_log_message =$error_message."  in ".$error_file."  line: ".$error_line;
   

    // //Match $error_level to the log4php error levels
    switch($error_level)
    {
        
            //These errors are considered non-fatal and the program can continue
            case(E_NOTICE):
            case(E_RECOVERABLE_ERROR):
                $logger->trace(json_encode($error_log_message));
                break;
            
            //These errors are warnings and the program can continue
            case(E_WARNING):
            case(E_USER_WARNING):
            case(E_USER_NOTICE):
            case(E_ALL):
                $logger->warn(json_encode($error_log_message));
                break;
            
            //These errors are fatal the the program will stop
            case(E_USER_ERROR):
            case(E_ERROR):
                $logger->fatal(json_encode($error_log_message));
                echo "<br><br><strong>Please Contact Team</strong>";
                die();
                break;
    }
}

?>