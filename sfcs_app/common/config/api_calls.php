<?php
function getInfoFromApi($url, $post_data, $bearer_token) {
    $post_data = json_encode($post_data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $post_data,
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Authorization: Bearer ".$bearer_token,
        ),
    ));
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    if ($error !== '') {
        throw new \Exception($error);
    }
    return json_decode($response, true);
}

//get authenication
function getAuthenication($url1, $auth_data) {
    //$auth_data = json_encode($auth_data);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>  $auth_data,
        CURLOPT_HTTPHEADER => array(
             "Content-Type': 'application/x-www-form-urlencoded"
        ),
    ));
    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);
    if ($error !== '') {
        throw new \Exception($error);
    }
    return json_decode($response, true);
}
?>