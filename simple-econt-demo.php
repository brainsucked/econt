<?php

function preprint($s, $return=false)
{
	$x = '<pre>';
	$x .= print_r($s, 1);
	$x .= '</pre>';
	if ($return) return $x;
	else print $x;
}

function requestDemo() {
	ini_set('memory_limit', '2G');
	ini_set('max_execution_time', '0');
	
	// https://ee.econt.com/
	$username = 'iasp-dev'; // your username
	$password = 'iasp-dev'; // your password
	
	$service = 'http://demo.econt.com/e-econt/xml_service_tool.php'; // demo url
	//$service = 'http://www.econt.com/e-econt/xml_service_tool.php'; // live url

	$request = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><request/>');

	$client = $request->addChild('client');
	$client->addChild('username', $username);
	$client->addChild('password', $password);
	
	// types: cities_zones, cities_regions, cities_streets, shipments, shipping, cities, cancel_shipments, cities_quarters, offices, profile, access_clients, delivery_days
	$request->addChild('request_type', 'access_clients');

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $service);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array('xml' => $request->asXML()));

	$response = simplexml_load_string(curl_exec($ch));

	curl_close($ch);
	
	return $response;
}

preprint(requestDemo());

?>