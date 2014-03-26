<?php
$url = 'https://maps.googleapis.com/maps/api/geocode/xml?address=' . $_GET['address'] . ',+' . $_GET['city'] . ',+' . $_GET['prov'] . ',+Canada&sensor=false';
$url = str_replace(" ","%20",$url);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
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