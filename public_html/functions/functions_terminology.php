<?
function search_terminology($data) {
  $where = array();
  if ($data['id']!="") $where[] = "t.id='".addslashes($data['id'])."'";
  if ($data['term']!="") $where[] = "UCASE(t.term)=UCASE('".addslashes($data['term'])."')";
  if ($data['wizard']!="") $where[] = "t.wizard='".addslashes($data['wizard'])."'";

  if (!$data['sort']) { $sort = "wizard DESC, term ASC"; }
  else { $sort = $data['sort']; }
  
  $q = "SELECT SQL_CALC_FOUND_ROWS t.* FROM Terminology t".(count($where)?' WHERE '.implode(" AND ", $where):"").' ORDER BY '.$sort.(isset($data['rpp'])?" LIMIT ".(isset($data['start'])?$data['start'].",":"").$data['rpp']:"");  
  $r = execute($q);
  $ret = @collect($r);

  $q = "SELECT FOUND_ROWS() as total";
  $r = execute($q);
  $r = fetch($r);
  $total = $r['total'];  
  
  return array("total"=>$total, "results"=>$ret);  
}

function terminology_save($data) {
  $term = array();
  if ($data['id']!="") {
    $terms = search_terminology(array("id"=>$data['id']));
    $term = $terms['results'][0];
  }  
  
  $values["term"]="'".addslashes($data["term"])."'";
  $values["definition"]="'".addslashes($data["definition"])."'";
  $values["wizard"]="'".($data['wizard']==1?1:0)."'";

  $q = ($data["id"]?"UPDATE ":"INSERT INTO ")."Terminology SET ";
  $p = false;
  foreach ($values as $key=>$val) {
    $q .= ($p?", ":"").$key."=".$val;
    $p = true;
  }
  $q .= ($data["id"]?" WHERE id='".addslashes($data["id"])."'":"");
  execute($q);
  if (!$data['id']) $data['id'] = mysql_insert_id();
  
  $newTerms = search_terminology(array("id"=>$data['id']));
  $newTerm = $newTerms['results'][0];
  $config = array(
	"_config" => array(
		"subject" => "Terminology Edit: ".$term['term'],
		"addSubject" => "Terminology Added: ".$newTerm['term']
	),
    "term" => array("name"=>"Term"),
	"definition" => array("name"=>"Definition"),
	"wizard" => array(
		"name"=>"Wizard Term?", 
		"map"=>array("1"=>"Yes", "0"=>"No")
	)
  );
  report_db_changes($term, $newTerm, $config);    
  
  return true;
}

function delete_terminology($id) {  
  $terms = search_terminology(array("id"=>$id));
  $term = $terms['results'][0];

  $q = "DELETE FROM Terminology WHERE id='".addslashes($id)."'";
  execute($q);
  if (mysql_error()) return false;
  
  $config = array(
	"_config" => array(
		"subject" => "Terminology Delete: ".$term['term'],
	),
    "term" => array("name"=>"Term"),
	"definition" => array("name"=>"Definition"),
	"wizard" => array(
		"name"=>"Wizard Term?", 
		"map"=>array("1"=>"Yes", "0"=>"No")
	)
  );
  report_db_changes($term, array(), $config);  
  
  return true; 
}
?>