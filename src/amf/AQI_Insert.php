<?php
	class AQI_Insert
	{
		public function AQI_Insert()
		{
		
		}
		
		public function insertData($stn_ID, $datetime, $reading, $cause)
		{
			require_once("database_aqo_data.php");

			$sql = "insert into AQI_Data (Stn_ID, AQI_DateTime, Reading, Cause) values ($stn_ID, convert(smalldatetime, $datetime), convert(int, $reading), $cause)";			

			sqlsrv_query($conn, $sql)
				or die("Invalid Query");
		}
	}
?>