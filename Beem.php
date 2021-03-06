<?php

//.... replace <api_key> and <secret_key> with the valid keys obtained from the platform, under profile>authentication information

sendRequest($msisdn)
{
    $api_key= getenv('BEEM_KEY');
    $secret_key = getenv('BEEM_SECRET');

    // The data to send to the API
    $postData = array(
        'appId' => '76',
        'msisdn' => '223'.$msisdn,
    );
    //.... Api url
    $Url ='https://apiotp.beem.africa/v1/request';

    // Setup cURL
    $ch = curl_init($Url);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array(
            'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
            'Content-Type: application/json'

        ),
        CURLOPT_POSTFIELDS => json_encode($postData)
    ));

    // Send the request
    $response = curl_exec($ch);

    // Check for errors
    if($response === FALSE){
            echo $response;

        die(curl_error($ch));
    }
    dd($response);    
}
