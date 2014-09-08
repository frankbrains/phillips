<?
//!!DO NOT MODIFY!!
//functions for php:database interface

function db_connect() {
    global $db_host, $db_user, $db_pass, $db_name;
	$result = mysql_connect($db_host, $db_user, $db_pass) or die("Could not connect to database!");
	if (!$result) {
		return false;
	} else {
		mysql_select_db($db_name);
		return true;
	}
	return $result;
}

function fetch($result) {
	return @mysql_fetch_array($result);
}

function execute($query) {
	return mysql_query($query);
}

function collect($resource) {
	$result = array();
	for ($i=0; $r = fetch($resource); $i++) {
		$result[$i] = $r;
	}
	return $result;
}

function inter($data, $by) {
	$new_data = array();
	foreach ($data as $d) {
		$new_data[$d[$by]] = $d;
	}
	return $new_data;
}

function quit($q) {
	die($q.":".mysql_error());
}

db_connect() or quit("");
?>
