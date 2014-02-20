<?php
$ch = curl_init();
$data = array('postal' => $_POST['postal'], 'geoit' => 'xml');
$query = http_build_query($data);
$url = 'http://www.geocoder.ca/';

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

$response = curl_exec($ch);    

if (curl_errno($ch))
{
    echo curl_error($ch);
}
else
{
    curl_close($ch);
    echo htmlentities($response);
}
?>