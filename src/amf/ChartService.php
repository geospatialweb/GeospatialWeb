<?php
	class ChartService
	{
		public function ChartService()
		{
		
		}
		
		public function getReadings($stn_ID)
		{
			require_once("database_aqo.php");
			$readings = array();
	
			$sql = "select Reading as value
					from AQI_Data
					where Stn_ID = $stn_ID and AQI_DateTime between '2011-03-01 00:00:00' and '2011-03-31 23:00:00'
					order by AQI_DateTime";
		
			$result = sqlsrv_query($conn, $sql)
				or die("Invalid Query");
		
			while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
			{
				if (($record['value'] == -999) || ($record['value'] == 9999))
					$record['value'] = 20;
				
				$readings[] = $record;
			}
			
			sqlsrv_close($conn);
			return $readings;
		}
	}
?>