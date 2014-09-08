<?
include("functions/include.php");
session_start();

$fail = false;
$results = "";
$f = trim($_GET['f']);
$id = trim($_GET['id']);
$data = array();
$out = "[ {\"optionValue\": \"\", \"optionDisplay\": \"\"}";
switch($f) {  
  case "tax":
    print "[ {\"tax\": \"".(isset($state_taxes[$_REQUEST['state']])?$state_taxes[$_REQUEST['state']]:0)."\"} ]";
    exit;
    break;
  case "country":
    $data = $COUNTRIES;
    break;
    
  case "us_states":
    $data = $STATES;
    break;
    
  case "ca_provinces":
    $data = $CANADA_PROVINCES;
    break;
    
  case "irish_states":
    $data = $IRISH_STATES;
    break;
    
  case "documentCategories":
    foreach ($DOCUMENT_CATEGORIES[$_GET['type']] as $cid=>$cdata) $data[$cid] = $cdata['name'];
    break;
    
  case "documentSubcategories":
    foreach ($DOCUMENT_CATEGORIES[$_GET['type']][$_GET['category']]['categories'] as $cid=>$cdata) $data[$cid] = $cdata['name'];
    break;
    
  case "documentSubcategories2":
    foreach ($DOCUMENT_CATEGORIES[$_GET['type']][$_GET['category']]['categories'][$_GET['subcategory']]['categories'] as $cid=>$cdata) $data[$cid] = $cdata['name'];
    break;
    
  default:
    $fail = true;
    break;
}

if (!$fail) {
  foreach ($data as $y=>$z) { $out .= ", {\"optionValue\": \"".$y."\", \"optionDisplay\": \"".$z."\"}"; }
  $out .= "]";
  if (!count($data)) $out = "[ ]";
  print $out;exit;
} 
?>