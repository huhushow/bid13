<?php
function isValidPhoneNumber($phone_number, $customer_id, $api_key) {

    $ch = curl_init();
    $base_url = "https://rest-ww.telesign.com";
    $path = "/v1/phoneid/$phone_number";
    $api_url = $base_url . $path;
    
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    //set http request method
    $request_method = 'POST';
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request_method);

    
    // Content type should be application/json
    $content_type = "application/json";

    //set extra header for digest authentication
    $date = date(DATE_RFC7231);
    $x_ts_auth_method = "HMAC-SHA256";
    $x_ts_nonce = bin2hex(random_bytes(8));

    // since this code doesn't send a body, doesn't set a string for body
    $str_to_sign_arr = [
        'http-method' => $request_method,
        'content-type' => $content_type,
        'date' => $date,
        'x-ts-auth-method' => "x-ts-auth-method: $x_ts_auth_method",
        'x-ts-date' => "",
        'x-ts-nonce' => "x-ts-nonce: $x_ts_nonce",
        'path' => $path,
    ];

    $str_to_sign = implode('\n', $str_to_sign_arr);

    $signature = base64_encode(
        hash_hmac("sha256", mb_convert_encoding($str_to_sign, "UTF-8", mb_detect_encoding($str_to_sign)), base64_decode($api_key), true)
    );
    $authorization = "TSA $customer_id:$signature";

    $headers = [
        // change authorization type to digest to protect customer id and api key
        // "Authorization: Basic " . base64_encode("$customer_id:$api_key"),
        "Authorization: $authorization",
        "Content-Type: $content_type",
        // add accept header
        "accept: application/json",
        // add extra header for digest authentication
        "Date: $date",
        "x-ts-auth-method: $x_ts_auth_method",
        "x-ts-nonce: $x_ts_nonce",
    ];

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    
    
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code !== 200) {
        return false; // API request failed
    }
    
    $data = json_decode($response, true);
    if (!isset($data['phone_type'])) {
        return false; // Unexpected API response
    }
    
    // change type text string to code
    // no code for VALID 
    // there are more codes than Prepaid, Voip, Invalid, Payphone or Restricted. need to specify how to handle other codes. 
    $valid_types = ["1", "2"];
    return in_array(strtoupper($data['phone_type']['code']), $valid_types);
}

// Usage example
$phone_number = "1234567890"; // Replace with actual phone number
$customer_id = "your_customer_id";
$api_key = "your_api_key";
$result = isValidPhoneNumber($phone_number, $customer_id, $api_key);
var_dump($result);