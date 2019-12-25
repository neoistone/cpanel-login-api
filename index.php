<?php

// This can also be the reseller who owns the cPanel user.
$whmusername = "whm username";
$whmpassword = "password";


// The user on whose behalf the API call runs.
$cpanel_user = $_GET['user'];//$_POST['cp_user']; //under reseller

$servername = "whm.host.name";


$query = "https://" . $servername . ":2087/json-api/create_user_session?api.version=2&user=$cpanel_user&service=cpaneld";

$curl = curl_init();                                     // Create Curl Object.
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);       // Allow self-signed certificates...
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);       // and certificates that don't match the hostname.
curl_setopt($curl, CURLOPT_HEADER, false);               // Do not include header in output
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);        // Return contents of transfer on curl_exec.
$header[0] = "Authorization: Basic " . base64_encode($whmusername.":".$whmpassword) . "\n\r";
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);         // Set the username and password.
curl_setopt($curl, CURLOPT_URL, $query);                 // Execute the query.
$result = curl_exec($curl);
if ($result == false) {
    error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
                                                    // log error if curl exec fails
}


$decoded_response = json_decode( $result, true );
$targetURL = $decoded_response['data']['url'];
 header("Location:$targetURL");

?>
