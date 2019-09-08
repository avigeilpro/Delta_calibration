<?php
$url = "http://Octoprint_IP/api/files/local";
$apikey = "My_Octoprint_APIKey";
$M663 = $_POST["M663"];
$M664 = $_POST["M664"];
$M665 = $_POST["M665"];

$mime_boundary=md5(time());

$params  = "--".$mime_boundary."\r\n"
	. 'Content-Disposition: form-data; name="file"; filename="Calib.gcode"' . "\r\n"
    . "Content-Type: application/octet-stream\r\n"
    . "\r\n"
    . $M663 . "\r\n"
    . $M664 . "\r\n"
    . $M665 . "\r\n"
    . "G135". "\r\n"
    . "--".$mime_boundary."--";

$first_newline      = strpos($params, "\r\n");
$multipart_boundary = substr($params, 2, $first_newline - 2);
$request_headers    = array();
$request_headers[]  = 'Content-Type: multipart/form-data; boundary='
    . $multipart_boundary;
$request_headers[]  = 'X-Api-Key:' . $apikey;

// send the request now

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);

$reply = curl_exec($ch);

?>