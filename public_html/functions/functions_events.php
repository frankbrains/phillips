<?
function search_events($data) {
  $where = array();
  if ($data['id']!="") $where[] = "e.id='".addslashes($data['id'])."'";
  
  $q = "SELECT SQL_CALC_FOUND_ROWS e.* FROM Events e".(count($where)?' WHERE '.implode(" AND ", $where):"")." ORDER BY start_date DESC".(isset($data['rpp'])?" LIMIT ".(isset($data['start'])?$data['start'].",":"").$data['rpp']:"");  
  $r = execute($q);
  $ret = @collect($r);

  $q = "SELECT FOUND_ROWS() as total";
  $r = execute($q);
  $r = fetch($r);
  $total = $r['total'];  
  
  return array("total"=>$total, "results"=>$ret);  
}

function event_save($data) {
  global $upload_path;

  if ($data['id']!="") {
    $events = search_events(array("id"=>$data['id']));
    $event = $events['results'][0];
  }
  
  $values["title"]="'".addslashes($data["title"])."'";
  $values["location"]="'".addslashes($data["location"])."'";
  $values["start_date"]="'".date("Y-m-d", strtotime(addslashes($data["start_date"])))."'";
  $values["end_date"]="'".date("Y-m-d", strtotime(addslashes($data["end_date"])))."'";
  $values["url"]="'".addslashes($data["url"])."'";

  $q = ($data["id"]?"UPDATE ":"INSERT INTO ")."Events SET ";
  $p = false;
  foreach ($values as $key=>$val) {
    $q .= ($p?", ":"").$key."=".$val;
    $p = true;
  }
  $q .= ($data["id"]?" WHERE id='".addslashes($data["id"])."'":"");
  execute($q);
  if (!$data['id']) $data['id'] = mysql_insert_id();
    
  $newEvents = search_events(array("id"=>$data['id']));
  $newEvent = $newEvents['results'][0];

  $config = array(
	"_config" => array(
		"subject" => "Events Edit: ".$event['title'],
		"addSubject" => "Event Added: ".$newEvent['title']
	),
    "title" => array("name"=>"Title"),
    "location" => array("name"=>"Location"),
    "start_date" => array("name"=>"Start Date"),
    "end_date" => array("name"=>"End Date"),
	"url" => array("name"=>"URL")
  );
  report_db_changes($event, $newEvent, $config);  
  
  return true;
}

function delete_event($id) {
  $events = search_events(array("id"=>$id));
  $event = $events['results'][0];
  
  $q = "DELETE FROM Events WHERE id='".addslashes($id)."'";
  execute($q);
  
  if (mysql_error()) return false;  
  
  
  $config = array(
	"_config" => array(
		"subject" => "Event Deleted: ".$event['title'],
	),
    "title" => array("name"=>"Title"),
    "location" => array("name"=>"Location"),
    "start_date" => array("name"=>"Start Date"),
    "end_date" => array("name"=>"End Date"),
	"url" => array("name"=>"URL")
  );
  report_db_changes($event, array(), $config);  
  
  return true; 
}
?>