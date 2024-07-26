<?php
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
?>