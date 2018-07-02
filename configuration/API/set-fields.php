<?php

$data = [];
foreach ($_POST["data"] as $key => $value) {
    $data[] = json_decode($value, true);
}

try{
    //$data = json_decode( json_encode( $_POST['data'] ) , true);
    $string = file_get_contents("saved_fields/fields.json");
    $fields = json_decode($string, true);

    // if(array_key_exists("steps", $fields)){
        $fields["steps"] = $data;
    //}
    $keys = [];
    foreach($data as $key => $value){
        $teatAreakey = array_search( 'textarea', array_column($value, 'type') );

        $callBackScript = isset($data[$key][$teatAreakey]['value']) ? $data[$key][$teatAreakey]['value']: "";
        $callBackName = isset($data[$key][$teatAreakey]['name'])?$data[$key][$teatAreakey]['name']:"";
        $callBackScript = "<?php ".PHP_EOL.$callBackScript;

        file_put_contents("call_back_scripts/$callBackName.php", $callBackScript);
    }

    $finalString = json_encode($fields,JSON_PRETTY_PRINT);
    file_put_contents("saved_fields/fields.json", $finalString);

    $return = ["status"=>"ok"];
    echo json_encode($return);
}catch(Exception $e){ 
    $return = ["status"=>"nok", "error"=>$e];
    echo json_encode($return);
}

?>