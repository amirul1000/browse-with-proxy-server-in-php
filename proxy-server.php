<?php
//The URL you want to send a cURL proxy request to.
$url = 'http://google.com';

//The IP address of the proxy you want to send
//your request through.
$proxyIP = '209.127.191.180';

//The port that the proxy is listening on.
$proxyPort = '9279';

//The username for authenticating with the proxy.
$proxyUsername = 'tujmnzwh-dest';

//The password for authenticating with the proxy.
$proxyPassword = '47yleq06y17t';


$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL , 1);

//Set the proxy IP.
curl_setopt($ch, CURLOPT_PROXY, $proxyIP);

//Set the port.
curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);

//Specify the username and password.
curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$proxyUsername:$proxyPassword");

//Execute the request.
$output = curl_exec($ch);

//Check for errors.
if(curl_errno($ch)){
    throw new Exception(curl_error($ch));
}

//Print the output.
echo $output;
?>