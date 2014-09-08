<?
include("include.php");
exit;

$id = 1;
$q = "SELECT * FROM DebugLog WHERE id='".addslashes($id)."'";
$r = execute($q);
$r = fetch($r);

var_dump(json_decode($r['data']));
?>