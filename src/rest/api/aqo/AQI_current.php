<?php
$ch = curl_init();
$url = 'http://www.airqualityontario.com/reports/today.php?sites=' . $_GET['stationId'];

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