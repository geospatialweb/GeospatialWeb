<?php
require_once('database_aqo.php');

$stn_ID = $_GET['stationId'];

$array = array();

$sql = "select DAY(AQI_DateTime) as label, Reading as value
		from AQI_Data
		where Stn_ID = $stn_ID and AQI_DateTime between '2010-06-01 00:00:00' and '2010-06-30 23:00:00'
		order by AQI_DateTime";

$result = sqlsrv_query($conn, $sql)
		or die('Invalid Query');

while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
{
	array_push($array, $record['value']);
}


sqlsrv_close($conn);

echo json_encode($array);
?>
