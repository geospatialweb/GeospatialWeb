<?php
require_once("database_aqo.php");

$Stn_ID = "'" . $_GET["stn"] . "'";
$AQI_DateTime = "'" . $_GET["datetime"] . "'";
$Reading = "'" . $_GET["reading"] . "'";
$Cause = "'" . $_GET["cause"] . "'";

$sql = "insert into AQI_Data (Stn_ID, AQI_DateTime, Reading, Cause) values ($Stn_ID, convert(smalldatetime, $AQI_DateTime), convert(int,$Reading), $Cause)";
			
sqlsrv_query($conn, $sql)
	or die("Invalid Query");

sqlsrv_close($conn);
?>