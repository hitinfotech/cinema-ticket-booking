<?php

function api_error_format($errors){
	$data = array();

	foreach ($errors as $key => $value) {
		$data[$key] = $value[0];
	}
	return $data;
}