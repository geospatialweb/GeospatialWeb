<?php
	class StationList
	{
		public function StationList()
		{
		
		}
		
		public function getStations()
		{
			require_once("database_aqo.php");
			$stations = array();
	
			$sql = "select Stn_ID, Stn_Name, Stn_Index, Stn_Lat, Stn_Lng
					from Stn_Info
					order by Stn_Index";
		
			$result = sqlsrv_query($conn, $sql)
				or die("Invalid Query");
		
			while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
			{
				$stations[] = $record;
			}
			
			sqlsrv_close($conn);
			return $stations;
		}
	}
?>