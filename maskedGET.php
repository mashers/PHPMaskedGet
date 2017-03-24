<?php

require_once('randomstring.php');

/*
	INITIALISATION FUNCTIONS
*/
function maskedGETReset() {
	$_SESSION['maskedget'] = array();
}

function maskedGETClear() {
	unset($_SESSION['maskedget']);
}

/*
	VALUE SETTING FUNCTIONS
*/
function maskedGETSetValues($values) {
	maskedGETReset();

	foreach($values as $value) {
		maskedGETAddValue($value);
	}
}

function maskedGETAddValue($value) {
	if (!isset($_SESSION['maskedget'])) {
		maskedGETReset();
	}
	
	$key = generateRandomString();
	while (array_key_exists($key, $_SESSION['maskedget'])) {
		$key = generateRandomString();
	}
	
	$_SESSION['maskedget'][$key] = $value;
	
	return $key;
}

/*
	VALUE GETTING FUNCTIONS
*/
function maskedGETGetValue($key=nil) {
	if ($key == nil) $key = "k";
	$key = $_GET[$key];
	
	if (!isset($_SESSION['maskedget']) || !isset($_SESSION['maskedget'][$key]))
		return false;
	else
		return $_SESSION['maskedget'][$key];
}

function maskedGETGetValueOrDie($key=nil) {
	$v = maskedGETGetValue($key);
	
	if (!$v) {
		echo "<script>alert('Invalid argument');</script>";
		die("Invalid argument");
	}
	
	return $v;
}

function maskedGETGetKey($value) {
	if (!isset($_SESSION['maskedget']))
		return false;
	else
		return array_search($value, $_SESSION['maskedget']);
}

function maskedGetTrim($size) {
	$count = count($_SESSION['maskedget']);
	
	if ($count > $size) {
		$ntrim = $count - $size;		
		array_splice($_SESSION['maskedget'], 0, $ntrim);
	}
}
?>