<?php

function getWeather ($code = '',$temp = 'c') {
	$file = 'http://weather.yahooapis.com/forecastress?p=' .$code .'&u=' .$temp;
	
	$request = new WP_Http;
	$result = $request->request($file);
	
	if(isset($result->errors)) {
		return FALSE;
	}
	
	$data = $result['body'];
	
	$output = array (
			'temperature' => weather_properties('temp',$data),
			'weather' => weather_properties('text',$data),
			'weather_code' => weather_properties('code',$data),
			'class' => 'weatherIcon-' .weather_properties('code',$data),
	);
	
	return $output;
	
}

function weather_properties($item, $data) {
	$regex = '<yweather:condition.*' .$item .'="(.*?)".*/>';
	preg_match($regex,$data,$matches);
	
	return $matches[1];
}
