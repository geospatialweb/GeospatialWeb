<?php
require_once('database_aqo.php');

$stn_ID = $_GET['stationId'];

$dom = new DOMDocument('1.0', 'utf-8');
$dom->formatOutput = true;
$node = $dom->createElement('chart');
$root_node = $dom->appendChild($node);
$root_node->setAttribute('showValues', '0');
$root_node->setAttribute('drawAnchors', '0');
$root_node->setAttribute('labelStep', '48');
$root_node->setAttribute('lineColor', '008800');
$root_node->setAttribute('lineThickness', '2');
$root_node->setAttribute('canvasPadding', '2');
$root_node->setAttribute('chartTopMargin', '32');
$root_node->setAttribute('chartLeftMargin', '8');

$sql = "select DAY(AQI_DateTime) as label, Reading as value
		from AQI_Data
		where Stn_ID = $stn_ID and AQI_DateTime between '2011-03-01 00:00:00' and '2011-03-31 23:00:00'
		order by AQI_DateTime";

$result = sqlsrv_query($conn, $sql)
		or die('Invalid Query');

while ($record = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
{
	if (($record['value'] == -999) || ($record['value'] == 9999))
		$record['value'] = 20;	

	$node = $dom->createElement('set');
	$set_node = $root_node->appendChild($node);
	$set_node->setAttribute('label', $record['label']);
	$set_node->setAttribute('value', $record['value']);
}

sqlsrv_close($conn);
header('Content-type: text/xml');
echo $dom->saveXML();
$dom->save('AQI_chart.xml');
?>
