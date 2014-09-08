<?
function search_news($data) {
  $where = array();
  if ($data['id']!="") $where[] = "n.id='".addslashes($data['id'])."'";

  if (!$data['sort']) { $sort = "date DESC"; }
  else { $sort = $data['sort']; }
  
  $q = "SELECT SQL_CALC_FOUND_ROWS n.* FROM News n".(count($where)?' WHERE '.implode(" AND ", $where):"").' ORDER BY '.$sort.(isset($data['rpp'])?" LIMIT ".(isset($data['start'])?$data['start'].",":"").$data['rpp']:"");  
  $r = execute($q);
  $ret = @collect($r);

  $q = "SELECT FOUND_ROWS() as total";
  $r = execute($q);
  $r = fetch($r);
  $total = $r['total'];  
  
  return array("total"=>$total, "results"=>$ret);  
}

function news_save($data) {
  global $upload_path;

  if ($data['id']!="") {
    $news_articles = search_news(array("id"=>$data['id']));
    $news = $news_articles['results'][0];
  }  
  
  $values["title"]="'".addslashes($data["title"])."'";
  $values["date"]="'".date("Y-m-d", strtotime(addslashes($data["date"])))."'";
  $values["summary"]="'".addslashes($data["summary"])."'";

  $q = ($data["id"]?"UPDATE ":"INSERT INTO ")."News SET ";
  $p = false;
  foreach ($values as $key=>$val) {
    $q .= ($p?", ":"").$key."=".$val;
    $p = true;
  }
  $q .= ($data["id"]?" WHERE id='".addslashes($data["id"])."'":"");
  execute($q);
  
  if (!$data["id"]) { $data["id"] = mysql_insert_id(); }
  
  // Upload Images  
  $files = false;
  $images = array(
    "file" => array(
      "pdf" => array("noresize"=>true)
    )
  );

  foreach (array_keys($images) as $image) {
    if (is_array($data[$image]) && $data[$image]['error']===0) {      
      if ($news[$image]!="" && file_exists($upload_path.$news[$image])) {
        unlink($upload_path.$news[$image]);
      }
      $dir = "news/".$data["id"]."/";
      //print $path.$dir;exit;
      if (!is_dir($upload_path."/".$dir)) { mkdir($upload_path."/".$dir, 0755); }
      foreach (array_keys($images[$image]) as $field) {
        $file = $dir.$data[$image]['name'];
        $filename = $upload_path.$file;
        if ($images[$image][$field]['noresize']) {
          if (move_uploaded_file($data[$image]['tmp_name'], $filename)) {
            $files[$field] = $file;
            $data[$image]['tmp_name'] = $filename;
          }
        } else {
          $img_obj = new bfImage($data[$image]);
          $width = $images[$image][$field]["width"];
          $height = $images[$image][$field]["height"];
          if ($img_obj->Process($filename, $width, $height)) {
            $files[$field]=$file;
          }
        }
      }
    }

    if (is_array($files)) {
      foreach ($files as $key=>$val) {
        $q = "UPDATE News SET ".$key."='".addslashes($val)."' WHERE id='".addslashes($data["id"])."'";
        execute($q);
      }
    }
  }

  $newNews_articles = search_news(array("id"=>$data['id']));
  $newNews = $newNews_articles['results'][0];
  $config = array(
	"_config" => array(
		"subject" => "News Edit: ".$news['title'],
		"addSubject" => "News Added: ".$newNews['title']
	),
    "title" => array("name"=>"Title"),
    "date" => array("name"=>"Date"),
    "summary" => array("name"=>"Summary"),
    "pdf" => array("name"=>"PDF")
  );
  report_db_changes($news, $newNews, $config);  
  return true;
}

function delete_news($id) {
  global $upload_path;
  
  $news_articles = search_news(array("id"=>$id));
  $news = $news_articles['results'][0];
  
  $q = "DELETE FROM News WHERE id='".addslashes($id)."'";
  execute($q);
  if (mysql_error()) return false;
  
  if ($news['file']!="" && file_exists($upload_path.$news['file'])) unlink($upload_path.$news['file']);
  
  $config = array(
	"_config" => array(
		"subject" => "News Deleted: ".$news['title'],
	),
    "title" => array("name"=>"Title"),
    "date" => array("name"=>"Date"),
    "summary" => array("name"=>"Summary"),
    "pdf" => array("name"=>"PDF")
  );
  report_db_changes($news, array(), $config);    
  return true; 
}
?>