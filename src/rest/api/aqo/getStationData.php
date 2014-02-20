<?php
require_once("database_aqo.php");

$sql = "select Stn_ID, Stn_Name, Stn_Index, Stn_Lat, Stn_Lng
			from Stn_Info
				order by Stn_Index";

$result = sqlsrv_query($conn, $sql)
			or die("Invalid Query");

$stations = '{"type": "FeatureCollection", "features": [';

while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
{
	$features = '{"type": "Feature", "geometry": {"type": "Point", "coordinates": [' . $record["Stn_Lng"] . ', ' . $record["Stn_Lat"] . ']}, "properties": {"stnID": "' . $record["Stn_ID"] . '", "stnIndex": "' . $record["Stn_Index"] . '", "stnName": "' . $record["Stn_Name"] . '"}},';
	
	$stations .= $features;
}

$stations = substr($stations, 0, -1);
$stations .= ']}';

sqlsrv_close($conn);
echo $stations;
?>