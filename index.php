<!DOCTYPE html>
<html lang="de">
<head>
<title>Temperatur &Uuml;bersicht</title>
<meta charset="utf-8">
<meta http-equiv="refresh" content="300">
<link rel="stylesheet" href="./css/styles.css">
</head>
<body>

<?php

// Report all PHP errors
error_reporting(E_ALL);

date_default_timezone_set('Europe/Berlin');

require_once('./config/sensors.cfg');

function get_blebox_state($ip)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://".$ip."/state");
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);

}

echo "<h2>Temperatur &Uuml;bersicht</h2>";

asort($sensors);

echo "<div class='boxes'>";
$i = 0;

foreach ($sensors as $sensor) {

	$i++;

	echo "<div class='box-temperature'>";

	echo "<div class='room-title'>".$sensor['room']."</div>";

	$data = get_blebox_state($sensor['IP']);

	$temperature = $data["tempSensor"]["sensors"][0]["value"]/100;
	$trend = match ($data["tempSensor"]["sensors"][0]["trend"]) {
		1 => "&#126;",
		2 => "&#8600;",
		3 => "&#8599;",
		default => null,
	};
	echo "<div class='values'>";
	echo "<div class='temperature'>".$temperature."°C</div>";
	echo "<div class='trend'>".$trend."</div>";
	echo "</div>"; #closing values
	echo "</div>"; #closing box
	if ($i % 2 == 0) {
		echo "</div><div class='boxes'>";
	}
	
	
}

echo "</div>";

echo "<footer><p><i>Diese Seite aktualisiert sich alle 5 Minuten automatisch<br>Letzte Aktualisierung: ".date("d.m.Y H:i")." Uhr</i></p></footer>";

?>