<?php

function parse_json() {
	if (is_readable('example.json')) {
	try {
		$file_return = file_get_contents('example.json');
	} catch (Exception $e) {
		error_log(error_get_last());
		error_log($e->getMessage());
	}
	} else {
		error_log("Not readable I guess");
		error_log(error_get_last());
	}
	if (!$file_return) {
		error_log("Error?");
		error_log(error_get_last());
	}
	error_log($file_return);
	return json_decode(file_get_contents('example.json'));
}
