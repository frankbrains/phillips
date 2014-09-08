<?
function search_headstandards($data) {
  $where = array();
  if ($data['page_id']!="") $where[] = "p.id='".addslashes($data['page_id'])."'";
  if ($data['id']!="") $where[] = "hs.id='".addslashes($data['id'])."'";
  if ($data['type']!="") $where[] = "hs.type='".addslashes($data['type'])."'";
  if (array_key_exists("cat", $data)) $where[] = "hs.category='".addslashes($data['cat'])."'";
  if ($data['subcat']!="") $where[] = "hs.subcategory='".addslashes($data['subcat'])."'";
  if ($data['subcat2']!="") $where[] = "hs.subcategory2='".addslashes($data['subcat2'])."'";
  
  if (!$data['sort']) { $sort = "hs.description ASC"; }
  else { $sort = $data['sort']; }
  
  $q = "SELECT SQL_CALC_FOUND_ROWS hs.*,p.filename as page_filename,p.product_name as page_product_name,hso.display_order as display_order FROM HeadStandards hs LEFT JOIN HeadStandardsOrder hso ON hs.id = hso.document_id LEFT JOIN pages p ON hs.page_id = p.id".(count($where)?' WHERE '.implode(" AND ", $where):"").' ORDER BY '.$sort.(isset($data['rpp'])?" LIMIT ".(isset($data['start'])?$data['start'].",":"").$data['rpp']:"");

  $r = execute($q);
  $ret = @collect($r);

  $q = "SELECT FOUND_ROWS() as total";
  $r = execute($q);
  $r = fetch($r);
  $total = $r['total'];  
  
  return array("total"=>$total, "results"=>$ret);  
}

function search_headstandards_licensee_techsupport($data) {
  $where = array();
  if ($data['page_id']!="") $where[] = "p.id='".addslashes($data['page_id'])."'";
  if ($data['id']!="") $where[] = "hs.id='".addslashes($data['id'])."'";

  $where[] = "( (hs.type='L' OR hs.category='1') OR (hs.type='R' AND hs.category='2') )";  

  if (!$data['sort']) { $sort = "hs.type ASC, hs.description ASC"; }
  else { $sort = $data['sort']; }  
  
  $q = "SELECT SQL_CALC_FOUND_ROWS hs.*,p.filename as page_filename,p.product_name as page_product_name FROM HeadStandards hs LEFT JOIN HeadStandardsOrder hso ON hs.id = hso.document_id LEFT JOIN pages p ON hs.page_id = p.id".(count($where)?' WHERE '.implode(" AND ", $where):"").' ORDER BY '.$sort.(isset($data['rpp'])?" LIMIT ".(isset($data['start'])?$data['start'].",":"").$data['rpp']:"");  

  $r = execute($q);
  $ret = @collect($r);

  $q = "SELECT FOUND_ROWS() as total";
  $r = execute($q);
  $r = fetch($r);
  $total = $r['total'];  
  
  return array("total"=>$total, "results"=>$ret);  
}

function user_access_drivesystem($uid, $page_id) {
  $q = "SELECT * FROM Users_DriveSystems WHERE user_id='".addslashes($uid)."' AND product_id='".addslashes($page_id)."'";
  $r = execute($q);
  $r = fetch($r);

  if (!$r['id']) return false;
  return true;
}

function delete_headstandard($id) {
  global $upload_path, $DOCUMENT_TYPES, $DOCUMENT_LANGUAGES, $DOCUMENT_CATEGORIES, $DOCUMENT_FORMATS, $HEAD_UNITS;
  
  $heads = search_headstandards(array("id"=>$id));
  $head = $heads['results'][0];

  $q = "DELETE FROM HeadStandards WHERE id='".addslashes($id)."'";
  execute($q);
  if (mysql_error()) return false;
  
  if ($head['file']!="" && file_exists($upload_path.$head['file'])) unlink($upload_path.$head['file']);
  if ($head['thumbnail']!="" && file_exists($upload_path.$head['thumbnail'])) unlink($upload_path.$head['thumbnail']);

  $q = "DELETE FROM HeadStandardsOrder WHERE document_id='".addslashes($id)."'";
  execute($q);  
  //$q = "UPDATE HeadStandards SET display_order=display_order-1 WHERE type='".$head['type']."' AND page_id='".$head['page_id']."' AND display_order>".$head['display_order'];
  //execute($q);
  headstandard_reorder_categories();
  
  $categories = array();
  foreach (array_keys($DOCUMENT_CATEGORIES[$head['type']]) as $c) $categories[$c] = $DOCUMENT_CATEGORIES[$head['type']][$c]['name'];
  $subcategories = array();
  if (count($DOCUMENT_CATEGORIES[$head['type']][$head['category']]['categories'])) {
    foreach (array_keys($DOCUMENT_CATEGORIES[$head['type']][$head['category']]['categories']) as $c) $subcategories[$c] = $DOCUMENT_CATEGORIES[$head['type']][$head['category']]['categories'][$c]['name'];
  }
  $subcategories2 = array();
  if (count($DOCUMENT_CATEGORIES[$head['type']][$head['category']]['categories'][$head['subcategory']]['categories'])) {
    foreach (array_keys($DOCUMENT_CATEGORIES[$head['type']][$head['category']]['categories'][$head['subcategory']]['categories']) as $c) $subcategories2[$c] = $DOCUMENT_CATEGORIES[$head['type']][$head['category']]['categories'][$head['subcategory']]['categories'][$c]['name'];
  }
  $products = array();
  foreach(get_pages() as $p) { $products[$p['id']] = $p['product_name']; }
  
  $config = array(
	"_config" => array(
		"subject" => "Document Delete: ".$head['description'],
	),  
    "type" => array(
	  "name" => "Type",
	  "map" => $DOCUMENT_TYPES),
	"category" => array(
	  "name" => "Category",
	  "map" => $categories),
	"subcategory" => array(
	  "name" => "Subcategory",
	  "map" => $subcategories),
	"subcategory2" => array(
	  "name"=>"Second Subcategory",
	  "map" => $subcategories2),
	"page_id" => array(
	  "name"=>"Product",
	  "map" => $products),
	"name" => array("name"=>"Name"),
	"description" => array("name"=>"Description"),
	"unit" => array(
	  "name"=>"Unit",
	  "map" => $HEAD_UNITS),
	"language" => array(
	  "name"=>"Language",
	  "map" => $DOCUMENT_LANGUAGES),
	"drawing_number" => array("name"=>"Drawing Number"),
	"format" => array(
	  "name"=>"Format",
	  "map" => $DOCUMENT_FORMATS),
	"url" => array("name"=>"URL/Website"),
	"file" => array("name"=>"File/PDF"),
	"thumbnail" => array("name"=>"Thumbnail")
  );
  report_db_changes($head, array(), $config);
  
  return true; 
}

function headstandard_save($data) {
  global $upload_path, $DOCUMENT_TYPES, $DOCUMENT_LANGUAGES, $DOCUMENT_CATEGORIES, $DOCUMENT_FORMATS, $HEAD_UNITS;
  global $_POST, $_COOKIE, $_FILES, $_SERVER;

  $debug = array("post"=>$_POST, "cookie"=>$_COOKIE, "files"=>$_FILES, "server"=>$_SERVER, "session"=>$_SESSION);
  logDebug($debug);
  
  if ($data['id']!="") {
    $heads = search_headstandards(array("id"=>$data['id']));
    $head = $heads['results'][0];
    $display_order = $head['display_order'];
  } else {
    $q = "SELECT MAX(display_order) as max FROM HeadStandardsOrder WHERE type='".addslashes($data['type'])."' AND category='".addslashes($data['category'])."'".($data['page_id']!=""?" AND page_id='".addslashes($data['page_id'])."'":"").($data['subcat']!=""?" AND subcategory='".addslashes($data['subcat'])."'":"").($data['subcat2']!=""?" AND subcategory2='".addslashes($data['subcat2'])."'":"");
    $r = fetch($q);
    $display_order = $r['max']+1;
  }
  
  $values["type"]="'".addslashes($data["type"])."'";
  $values["category"]="'".addslashes($data["category"])."'";
  $values["subcategory"]="'".addslashes($data["subcategory"])."'";
  $values["subcategory2"]="'".addslashes($data["subcategory2"])."'";
  $values["page_id"]="'".addslashes($data["page_id"])."'";
  $values["name"]="'".addslashes($data["name"])."'";
  $values["description"]="'".addslashes($data["description"])."'";
  $values["unit"]="'".addslashes($data["unit"])."'";
  $values["language"]="'".addslashes($data["language"])."'";
  $values["drawing_number"]="'".addslashes($data["drawing_number"])."'";
  $values["format"]="'".addslashes($data["format"])."'";
  $values["url"]="'".addslashes($data["url"])."'";

  $q = ($data["id"]?"UPDATE ":"INSERT INTO ")."HeadStandards SET ";
  $p = false;
  foreach ($values as $key=>$val) {
    $q .= ($p?", ":"").$key."=".$val;
    $p = true;
  }
  $q .= ($data["id"]?" WHERE id='".addslashes($data["id"])."'":"");
  execute($q);  
  
  if (!$data["id"]) { $data["id"] = mysql_insert_id(); }

  $q = "DELETE FROM HeadStandardsOrder WHERE document_id='".addslashes($data['id'])."'";
  execute($q);
  $q = "INSERT INTO HeadStandardsOrder SET display_order='".addslashes($display_order)."', document_id='".addslashes($data['id'])."', type='".addslashes($data['type'])."', category='".addslashes($data['category'])."'".($data['page_id']!=""?", page_id='".addslashes($data['page_id'])."'":"").($data['subcategory']!=""?", subcategory='".addslashes($data['subcategory'])."'":"").($data['subcategory2']!=""?", subcategory2='".addslashes($data['subcategory2'])."'":"");
  execute($q);
  
  headstandard_reorder_categories();
  
  // Upload Images  
  $files = false;
  $images = array(
    "file" => array(
      "file" => array("noresize"=>true)
    ),
    "thumbnail" => array(
      "thumbnail" => array("height"=>9999, "width"=>"225")
    )
  );

  foreach (array_keys($images) as $image) {
    if (is_array($data[$image]) && $data[$image]['error']===0) {      
      if ($head[$image]!="" && file_exists($upload_path.$head[$image])) {
        unlink($upload_path.$head[$image]);
      }
      $dir = "heads/".$data["id"]."/";
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
        $q = "UPDATE HeadStandards SET ".$key."='".addslashes($val)."' WHERE id='".addslashes($data["id"])."'";
        execute($q);
      }
    }
  }
  
  $newHeads = search_headstandards(array("id"=>$data['id']));
  $new = $newHeads['results'][0];

  $type = (isset($head['type'])?$head['type']:$new['type']);
  $category = (isset($head['category'])?$head['category']:$new['category']);
  $subcategory = (isset($head['subcategory'])?$head['subcategory']:$new['subcategory']);
  
  $categories = array();
  foreach (array_keys($DOCUMENT_CATEGORIES[$type]) as $c) $categories[$c] = $DOCUMENT_CATEGORIES[$type][$c]['name'];
  $subcategories = array();
  if (count($DOCUMENT_CATEGORIES[$type][$category]['categories'])) {
    foreach (array_keys($DOCUMENT_CATEGORIES[$type][$category]['categories']) as $c) $subcategories[$c] = $DOCUMENT_CATEGORIES[$type][$category]['categories'][$c]['name'];
  }
  $subcategories2 = array();
  if (count($DOCUMENT_CATEGORIES[$type][$category]['categories'][$subcategory]['categories'])) {
    foreach (array_keys($DOCUMENT_CATEGORIES[$type][$category]['categories'][$subcategory]['categories']) as $c) $subcategories2[$c] = $DOCUMENT_CATEGORIES[$type][$category]['categories'][$subcategory]['categories'][$c]['name'];
  }
  $products = array();
  foreach(get_pages() as $p) { $products[$p['id']] = $p['product_name']; }
  
  $config = array(
	"_config" => array(
		"subject" => "Document Edit: ".$head['description'],
		"addSubject" => "Document Added: ".$new['description']
	),  
    "type" => array(
	  "name" => "Type",
	  "map" => $DOCUMENT_TYPES),
	"category" => array(
	  "name" => "Category",
	  "map" => $categories),
	"subcategory" => array(
	  "name" => "Subcategory",
	  "map" => $subcategories),
	"subcategory2" => array(
	  "name"=>"Second Subcategory",
	  "map" => $subcategories2),
	"page_id" => array(
	  "name"=>"Product",
	  "map" => $products),
	"name" => array("name"=>"Name"),
	"description" => array("name"=>"Description"),
	"unit" => array(
	  "name"=>"Unit",
	  "map" => $HEAD_UNITS),
	"language" => array(
	  "name"=>"Language",
	  "map" => $DOCUMENT_LANGUAGES),
	"drawing_number" => array("name"=>"Drawing Number"),
	"format" => array(
	  "name"=>"Format",
	  "map" => $DOCUMENT_FORMATS),
	"url" => array("name"=>"URL/Website"),
	"file" => array("name"=>"File/PDF"),
	"thumbnail" => array("name"=>"Thumbnail")
  );  
  
  report_db_changes($head, $new, $config);
  
  return true;
}

function headstandard_reorder($data) {
  $q = "SELECT HeadStandardsOrder.id,HeadStandardsOrder.display_order,HeadStandards.id as document_id,HeadStandards.type,HeadStandards.category,HeadStandards.subcategory,HeadStandards.subcategory2,HeadStandards.page_id FROM HeadStandards LEFT JOIN HeadStandardsOrder ON HeadStandards.id = HeadStandardsOrder.document_id WHERE HeadStandards.type='".addslashes($data['type'])."' AND HeadStandards.category='".addslashes($data['cat'])."'".($data['page_id']!=""?" AND HeadStandards.page_id='".addslashes($data['page_id'])."'":"").($data['subcat']!=""?" AND HeadStandards.subcategory='".addslashes($data['subcat'])."'":"").($data['subcat2']!=""?" AND HeadStandards.subcategory2='".addslashes($data['subcat2'])."'":"")." ORDER BY display_order";
  $r = execute($q);
  $rows = collect($r);
  for($i=0;$i<count($rows);$i++) {
    if ($rows[$i]['id']) {    
      $q = "UPDATE HeadStandardsOrder SET display_order='".($i+1)."' WHERE id='".addslashes($rows[$i]['id'])."'";  
      execute($q);
    } else {
      $q = "INSERT INTO HeadStandardsOrder SET document_id='".addslashes($rows[$i]['document_id'])."', display_order='".($i+1)."', type='".addslashes($rows[$i]['type'])."', category='".addslashes($rows[$i]['category'])."', subcategory='".addslashes($rows[$i]['subcategory'])."', page_id='".addslashes($rows[$i]['page_id'])."', subcategory2='".addslashes($rows[$i]['subcategory2'])."'";
      execute($q);
    }
  }
}

function headstandard_reorder_categories() {
  global $DOCUMENT_CATEGORIES;
  foreach (array_keys($DOCUMENT_CATEGORIES) as $type) {
    foreach (array_keys($DOCUMENT_CATEGORIES[$type]) as $cat) {
      if (count($DOCUMENT_CATEGORIES[$type][$cat]['categories'])) {
        foreach (array_keys($DOCUMENT_CATEGORIES[$type][$cat]['categories']) as $subcat) {
          if (count($DOCUMENT_CATEGORIES[$type][$cat]['categories'][$subcat]['categories'])) {
            foreach(array_keys($DOCUMENT_CATEGORIES[$type][$cat]['categories'][$subcat]['categories']) as $subcat2) {
              headstandard_reorder(array("type"=>$type, "cat"=>$cat, "subcat"=>$subcat, "subcat2"=>$subcat2));
            }
          } else {
            headstandard_reorder(array("type"=>$type, "cat"=>$cat, "subcat"=>$subcat));
          }
        }
      } else {
        if ($type=='R' && $cat=='2') {
          $q = "SELECT id FROM pages WHERE is_product=1";
          $r = execute($q);
          $rows = collect($r);
          foreach ($rows as $r) {
            headstandard_reorder(array("type"=>$type, "cat"=>$cat, "page_id"=>$r['id']));
          }
        } else {
          headstandard_reorder(array("type"=>$type, "cat"=>$cat));
        }
      }
    }
  }
}

function moveup_headstandard($data) {

  $heads = search_headstandards(array("id"=>$data['id']));
  //print_r($heads);exit;
  $data = $heads['results'][0];

  $new_order = $data['display_order'] - 1;
  $q = "UPDATE HeadStandardsOrder SET `display_order`=`display_order`+1 WHERE type='".$data['type']."'".($data['category']!=""?" AND category='".addslashes($data['category'])."'":"").($data['subcategory']!=""?" AND subcategory='".addslashes($data['subcategory'])."'":"").($data['subcategory2']!=""?" AND subcategory2='".addslashes($data['subcategory2'])."'":"").($data['page_id']?" AND page_id='".addslashes($data['page_id'])."'":"")." AND `display_order` >= ".$new_order." AND `display_order` < ".$data['display_order'];

  execute($q);  
  if (mysql_error()) { return false; }
  
  $q = "UPDATE HeadStandardsOrder SET `display_order` = ".$new_order." WHERE document_id=".$data['id'];
  execute($q);  
  if (mysql_error()) { return false; }
  
  return true;
}

function movedown_headstandard($data) {
  $heads = search_headstandards(array("id"=>$data['id']));
  $data = $heads['results'][0];

  $new_order = $data['display_order'] + 1;
  $q = "UPDATE HeadStandardsOrder SET `display_order`=`display_order`-1 WHERE type='".$data['type']."'".($data['category']!=""?" AND category='".addslashes($data['category'])."'":"").($data['subcategory']!=""?" AND subcategory='".addslashes($data['subcategory'])."'":"").($data['subcatgory22']!=""?" AND subcategory2='".addslashes($data['subcategory2'])."'":"").($data['page_id']?" AND page_id='".addslashes($data['page_id'])."'":"")." AND `display_order` > ".$data['display_order']." AND `display_order` <= ".$new_order;

  execute($q);  
  if (mysql_error()) { return false; }
  
  $q = "UPDATE HeadStandardsOrder SET `display_order` = ".$new_order." WHERE document_id=".$data['id'];  
  execute($q);   
  if (mysql_error()) { return false; }
  
  return true;
}

function headstandard_log_download($data) {
  $q = "INSERT INTO Users_Downloads SET user_id='".addslashes($data['user_id'])."', file_id='".addslashes($data['id'])."', time=NOW()";
  execute($q);
  
  if (mysql_error()) return false;
  return true;
}

function get_headstandard_downloads($user_id) {
  $q = "SELECT hs.*,ud.time FROM Users_Downloads ud LEFT JOIN HeadStandards hs ON ud.file_id=hs.id WHERE ud.user_id='".addslashes($user_id)."' ORDER BY time DESC";
  $r = execute($q);
  return @collect($r);
}
?>