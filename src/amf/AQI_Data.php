<?php
	class AQI_Data
	{
		public function AQI_Data()
		{
		
		}
		
		public function getData($stn_ID, $day, $month, $year)
		{
			$ch = curl_init();
			$url = 'http://www.airqualityontario.com/reports/aqisearch.cfm?StationID=" + $stn_ID + "&this_date=" + $day + "-" + $month + "-" + $year + "&startmonth=24hour';

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
		
		}
	}
?>