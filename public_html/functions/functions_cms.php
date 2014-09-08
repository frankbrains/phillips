<?
function get_page_pieces($data) {
  global $site_url;

  $filename = end(explode("/",$data['SCRIPT_NAME']));
  $q = "SELECT * FROM pages WHERE filename='".addslashes($filename)."'";
  $r = execute($q);
  $r = fetch($r);

  if (!$r) { header("Location: ".$site_url); exit; }
  return $r;
}

function get_pages() {
  $q = "SELECT * FROM pages ORDER BY filename ASC";
  $r = execute($q);
  return @collect($r);
}

function get_page($id, $revision="") {
  $q = "SELECT * FROM pages WHERE id='".addslashes($id)."'";
  $r = execute($q);
  $r = fetch($r);

  if ($revision) {
    $q = "SELECT * FROM archive WHERE
          filename='".addslashes($r['filename'])."' AND timestamp='".addslashes($revision)."'";
    $r = execute($q);
    $r = fetch($r);
  }
  
  return $r;
}

function create_site_file($filename) {
  global $path;

  if (file_exists($path."/".$filename)) return false;
  if (!$handle = fopen($path."/".$filename, "w")) return false;
  if (fwrite($handle, "<? include(\"template.php\"); ?>") === FALSE) return false;
  fclose($handle);
  return true;
}

function remove_site_file($filename) {
  global $path;

  if (!file_exists($path."/".$filename)) return 1;
  if (!unlink($path."/".$filename)) { return 0; }
  else { return 1; }
}

// Insert a page in the CMS database, apply IE WYSIWYG fixes first
function insert_cms_page($data) {
	

  $q = "INSERT INTO pages SET
  filename=\"".addslashes($data['newfilename'])."\",
  pagetitle = '".addslashes($data['pagetitle'])."',
  template='".addslashes($data['template'])."',
  "./*stylesheet='".addslashes($data['stylesheet'])."',
  section='".addslashes($data['section'])."',*/
  "description = '".addslashes($data['description'])."',
  keywords = '".addslashes($data['keywords'])."',
  body = '".addslashes($data['body'])."',
  aerospace_enable = '".($data['aerospace_enable']?1:0)."',
  aerospace_apps = '".addslashes($data['aerospace_apps'])."',
  automotive_enable = '".($data['automotive_enable']?1:0)."',
  automotive_apps = '".addslashes($data['automotive_apps'])."',
  diytrade_enable = '".($data['diytrade_enable']?1:0)."',
  diytrade_apps = '".addslashes($data['diytrade_apps'])."',
  electronics_enable = '".($data['electronics_enable']?1:0)."',
  electronics_apps = '".addslashes($data['electronics_apps'])."',
  industrial_enable = '".($data['industrial_enable']?1:0)."',
  industrial_apps = '".addslashes($data['industrial_apps'])."',
  marine_enable = '".($data['marine_enable']?1:0)."',
  marine_apps = '".addslashes($data['marine_apps'])."',
  military_enable = '".($data['military_enable']?1:0)."',
  military_apps = '".addslashes($data['military_apps'])."',
  editable=1";
  $r = execute($q) or quit($q);
  $id = mysql_insert_id();
  
  if (mysql_affected_rows() > 0) { 
    $page = get_page($id);
    $config = array(
	  "_config" => array(
		"subject" => "CMS added: ".$page['filename'],
	  ),
      "pagetitle" => array("name"=>"Page Title"),
	  "template" => array("name"=>"Page Template"),
	  "description" => array("name"=>"Meta Description"),
	  "keywords" => array("name"=>"Meta Keywords"),
	  "body" => array("name"=>"Page Body"),
	  "aerospace_enable" => array("name"=>"Aerospace Enabled"),
	  "aerospace_apps" => array("name"=>"Aerospace Apps."),
	  "automotive_enable" => array("name"=>"Automotive Enabled"),
	  "automotive_apps" => array("name"=>"Automotive Apps."),
	  "diytrade_enable" => array("name"=>"DIY &amp; Trade Enabled"),
	  "diytrade_apps" => array("name"=>"DIY &amp; Trade Apps."),
	  "electronics_enable" => array("name"=>"Electronics Enabled"),
	  "electronics_apps" => array("name"=>"Electronics Apps."),
	  "industrial_enable" => array("name"=>"Industrial Enabled"),
	  "industrial_apps" => array("name"=>"Industrial Apps."),
	  "marine_enable" => array("name"=>"Marine Enabled"),
	  "marine_apps" => array("name"=>"Marine Apps."),
	  "military_enable" => array("name"=>"Military Enabled"),
	  "military_apps" => array("name"=>"Military Apps.")
    );
    report_db_changes(array(), $page, $config);      
  
    return 1;
  }
  else { return 0; }
}

function update_cms_page($data) {
  if (!archive_cms_page($data)) return 0;
  $old = get_page($data['page']);
  
  $q = "UPDATE pages SET
        pagetitle = '".addslashes($data['pagetitle'])."',
        template='".addslashes($data['template'])."',
        "./*stylesheet='".addslashes($data['stylesheet'])."',
        section='".addslashes($data['section'])."',*/
        "description = '".addslashes($data['description'])."',
        keywords = '".addslashes($data['keywords'])."',
        body = '".addslashes($data['body'])."',
        aerospace_enable = '".($data['aerospace_enable']?1:0)."',
        aerospace_apps = '".addslashes($data['aerospace_apps'])."',
        automotive_enable = '".($data['automotive_enable']?1:0)."',
        automotive_apps = '".addslashes($data['automotive_apps'])."',
        diytrade_enable = '".($data['diytrade_enable']?1:0)."',
        diytrade_apps = '".addslashes($data['diytrade_apps'])."',
        electronics_enable = '".($data['electronics_enable']?1:0)."',
        electronics_apps = '".addslashes($data['electronics_apps'])."',
        industrial_enable = '".($data['industrial_enable']?1:0)."',
        industrial_apps = '".addslashes($data['industrial_apps'])."',
        marine_enable = '".($data['marine_enable']?1:0)."',
        marine_apps = '".addslashes($data['marine_apps'])."',
        military_enable = '".($data['military_enable']?1:0)."',
        military_apps = '".addslashes($data['military_apps'])."'
        WHERE id='".addslashes($data['page'])."'";

  execute($q);
  if (mysql_error()) { return 0; }
  
  $new = get_page($data['page']);
  $config = array(
	"_config" => array(
		"subject" => "CMS edit: ".$old['filename'],
	),
    "pagetitle" => array("name"=>"Page Title"),
	"template" => array("name"=>"Page Template"),
	"description" => array("name"=>"Meta Description"),
	"keywords" => array("name"=>"Meta Keywords"),
	"body" => array("name"=>"Page Body"),
	"aerospace_enable" => array("name"=>"Aerospace Enabled"),
	"aerospace_apps" => array("name"=>"Aerospace Apps."),
	"automotive_enable" => array("name"=>"Automotive Enabled"),
	"automotive_apps" => array("name"=>"Automotive Apps."),
	"diytrade_enable" => array("name"=>"DIY &amp; Trade Enabled"),
	"diytrade_apps" => array("name"=>"DIY &amp; Trade Apps."),
	"electronics_enable" => array("name"=>"Electronics Enabled"),
	"electronics_apps" => array("name"=>"Electronics Apps."),
	"industrial_enable" => array("name"=>"Industrial Enabled"),
	"industrial_apps" => array("name"=>"Industrial Apps."),
	"marine_enable" => array("name"=>"Marine Enabled"),
	"marine_apps" => array("name"=>"Marine Apps."),
	"military_enable" => array("name"=>"Military Enabled"),
	"military_apps" => array("name"=>"Military Apps.")
  );
  report_db_changes($old, $new, $config);
  
  return 1;
}

// Insert a page in the CMS database, apply IE WYSIWYG fixes first
function get_cms_archives($data) {
  if (!isset($data['page'])) { return null; }
  $page = get_page($data['page']);

  $q = "SELECT timestamp FROM `archive` WHERE filename='".$page['filename']."' ORDER BY timestamp DESC";
  $r = execute($q);
  return @collect($r);
}

function delete_cms_page($data) {
  $page = get_page($data['page']);

  $q = "DELETE FROM pages WHERE filename=\"".trim($page['filename'])."\"";
  execute($q);
  if (mysql_error()) return 0;

  $q = "DELETE FROM archive WHERE filename=\"".trim($page['filename'])."\"";
  execute($q);
  if (mysql_error()) return 0;
  
  remove_site_file($page['filename']);
  
  $config = array(
	"_config" => array(
		"subject" => "CMS deleted: ".$page['filename'],
	),
    "pagetitle" => array("name"=>"Page Title"),
	"template" => array("name"=>"Page Template"),
	"description" => array("name"=>"Meta Description"),
	"keywords" => array("name"=>"Meta Keywords"),
	"body" => array("name"=>"Page Body"),
	"aerospace_enable" => array("name"=>"Aerospace Enabled"),
	"aerospace_apps" => array("name"=>"Aerospace Apps."),
	"automotive_enable" => array("name"=>"Automotive Enabled"),
	"automotive_apps" => array("name"=>"Automotive Apps."),
	"diytrade_enable" => array("name"=>"DIY &amp; Trade Enabled"),
	"diytrade_apps" => array("name"=>"DIY &amp; Trade Apps."),
	"electronics_enable" => array("name"=>"Electronics Enabled"),
	"electronics_apps" => array("name"=>"Electronics Apps."),
	"industrial_enable" => array("name"=>"Industrial Enabled"),
	"industrial_apps" => array("name"=>"Industrial Apps."),
	"marine_enable" => array("name"=>"Marine Enabled"),
	"marine_apps" => array("name"=>"Marine Apps."),
	"military_enable" => array("name"=>"Military Enabled"),
	"military_apps" => array("name"=>"Military Apps.")
  );
  report_db_changes($page, array(), $config);  
  
  return 1;
}

// This saves a copy of any page into the archive
function archive_cms_page($data) {
  $q = "INSERT INTO archive (timestamp, filename, template, stylesheet, section, pagetitle, description, keywords, body, is_product, aerospace_enable, aerospace_apps, automotive_enable, automotive_apps, diytrade_enable, diytrade_apps, electronics_enable, electronics_apps, industrial_enable, industrial_apps, marine_enable, marine_apps, military_enable, military_apps)
        SELECT NOW(), filename, template, stylesheet, section, pagetitle, description, keywords, body, is_product, aerospace_enable, aerospace_apps, automotive_enable, automotive_apps, diytrade_enable, diytrade_apps, electronics_enable, electronics_apps, industrial_enable, industrial_apps, marine_enable, marine_apps, military_enable, military_apps
        FROM pages WHERE id='".addslashes($data['page'])."'";
  execute($q);
                                           
  if (mysql_error()) { return 0; }
  return 1;
}

// Adaptation of eval() that parses embedded PHP in HTML
function eval_mixed($string){
   return eval("?>".str_replace('<'.'?php', '<'.'?', $string)."<?");
}

function get_backend_pieces() {
  $file = file_get_contents("backend_template.php");
  list($header,$footer) = explode("#$#BODY#$#", $file);
  return array($header,$footer);
}
?>
