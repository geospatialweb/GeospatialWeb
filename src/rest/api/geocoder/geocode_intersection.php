<?php
$ch = curl_init();
$data = array('street1' => $_POST['street1'], 'street2' => $_POST['street2'], 'city' => $_POST['city'], 'prov' => $_POST['prov'], 'geoit' => 'xml');
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