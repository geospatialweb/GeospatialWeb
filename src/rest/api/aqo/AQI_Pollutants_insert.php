<?php
require_once("database_aqo.php");

$Stn_ID = "'" . $_POST["Stn_ID"] . "'";;
$Poll_ID = "'" . $_POST["Poll_ID"] . "'";;
$Poll_DateTime = "'" . $_POST["Poll_DateTime"] . "'";
$Reading = $_POST["Reading"];

$sql = "insert into Poll_Data (Stn_ID, Poll_ID, Poll_DateTime, Reading) values ($Stn_ID, $Poll_ID, convert(smalldatetime, $Poll_DateTime), $Reading)";
			
sqlsrv_query($conn, $sql)
	or die("Invalid Query");

sqlsrv_close($conn);
?>