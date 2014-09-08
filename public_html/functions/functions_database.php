<?
//!!DO NOT MODIFY!!
//basic database functions
function exists_username($un) {
	$q = "SELECT user_id FROM Users WHERE email=\"".addslashes($un)."\"";
	$r = execute($q);
	return ($r = fetch($r));
}

//login/register functions
function login_user($un, $pw) {
  global $STATUS_ACTIVE;
  
	$q = "SELECT user_id FROM Users WHERE email=\"".addslashes($un)."\" AND (password!=\"\" AND password=\"".addslashes($pw)."\") AND user_status='".$STATUS_ACTIVE."'";
	$r = execute($q);
	if ($r = fetch($r)) {
		return $r['user_id'];
	} else {
		return false;
	}
}

function get_user($user_id) {
  $q = "SELECT Users.* FROM Users WHERE Users.user_id='".addslashes($user_id)."'";
  $r = execute($q);
  return @fetch($r);
}

function get_user_drive_systems($user_id) {
  $q = "SELECT * FROM Users_DriveSystems WHERE user_id='".addslashes($user_id)."'";
  $r = execute($q);
  return @collect($r);
}

function get_session_user_type() {
  global $_SESSION;
  return get_user_type($_SESSION['user_id']);
}

function get_user_type($user_id) {
  $r = get_user($user_id);
  if ($r['user_type']) return $r['user_type'];
  return false;
}

function get_users($data) {
  global $user_types;
  
  $where = "";
  if (!$data['sort']) { $sort = "Users.lname ASC, Users.fname ASC"; }
  else { $sort = $data['sort']; }
  
  if ($data['keyword']!="") { $where = "(UCASE(Users.email) like UCASE('%".addslashes($data['keyword'])."%') OR UCASE(Users.fname) like UCASE('%".addslashes($data['keyword'])."%') OR UCASE(Users.lname) like UCASE('%".addslashes($data['keyword'])."%'))"; }  
  if ($data['user_type']!="") { $where .= ($where!=""?" AND ":"")." Users.user_type='".addslashes($data['user_type'])."'"; }
  if ($data['email']!="") { $where .= ($where!=""?" AND ":"")." Users.email='".addslashes($data['email'])."'"; }
  
  $where .= ($where!=""?" AND ":"")." (";
  $keys = array_keys($user_types);
  for($i=0;$i<count($user_types);$i++) {
    $where .= ($i>0?" OR ":"")."Users.user_type='".$keys[$i]."'";
  }
  $where .= ")";
  
  $q = "SELECT Users.* FROM Users ".($where!=""?"WHERE ".$where:"")." ORDER BY ".$sort;
  $r = execute($q);
  
  return @collect($r);  
}

function username_exists($username, $user_id="") {
  $q = "SELECT user_id FROM Users WHERE email LIKE '".addslashes($username)."'";
  $r = execute($q);
  $r = fetch($r);
  if ($user_id!="" && $user_id == $r['user_id']) return false;
  return $r['user_id'];
}

function register_user_public($data) {
	$uid = new_index("Users", "user_id");
  
	$q = "INSERT INTO Users SET ".  
    "user_id=\"".addslashes($uid)."\", ".
    "user_type=\"10\", ".
    "fname=\"".addslashes($data['fname'])."\", ".
    "lname=\"".addslashes($data['lname'])."\", ".
    "email=\"".addslashes($data['email'])."\", ".
    "password=\"".addslashes($data['rpassword'])."\", ".
    "company=\"".addslashes($data['company'])."\", ".
    "bill_address1=\"".addslashes($data['bill_address1'])."\", ".
    "bill_address2=\"".addslashes($data['bill_address2'])."\", ".
    "bill_city=\"".addslashes($data['bill_city'])."\", ".
    "bill_state=\"".addslashes($data['bill_state'])."\", ".
    "bill_zip=\"".addslashes($data['bill_zip'])."\", ".
    "bill_country=\"".addslashes($data['bill_country'])."\", ".
    "ship_address1=\"".addslashes($data['ship_address1'])."\", ".
    "ship_address2=\"".addslashes($data['ship_address2'])."\", ".
    "ship_city=\"".addslashes($data['ship_city'])."\", ".
    "ship_state=\"".addslashes($data['ship_state'])."\", ".
    "ship_zip=\"".addslashes($data['ship_zip'])."\", ".
    "ship_country=\"".addslashes($data['ship_country'])."\", ".
    "date_created=NOW()";
  execute($q) or quit($q);

	return $uid;
}

function add_user($data) {
	$uid = new_index("Users", "user_id");
  
	$q = "INSERT INTO Users SET ".  
    "user_id=\"".addslashes($uid)."\", ".
    ($data['user_type']!=""?"user_type=\"".addslashes($data['user_type'])."\", ":"").
    ($data['user_status']!=""?"user_status=\"".addslashes($data['user_status'])."\", ":"").
    "fname=\"".addslashes($data['fname'])."\", ".
    "lname=\"".addslashes($data['lname'])."\", ".
    "email=\"".addslashes($data['email'])."\", ".
    "password=\"".addslashes($data['password'])."\", ".
    "company=\"".addslashes($data['company'])."\", ".
    "phone=\"".addslashes($data['phone'])."\", ".    
    "fax=\"".addslashes($data['fax'])."\", ".    
    "url=\"".addslashes($data['url'])."\", ".    
    "bill_address1=\"".addslashes($data['bill_address1'])."\", ".
    "bill_address2=\"".addslashes($data['bill_address2'])."\", ".
    "bill_city=\"".addslashes($data['bill_city'])."\", ".
    "bill_state=\"".addslashes($data['bill_state'])."\", ".
    "bill_zip=\"".addslashes($data['bill_zip'])."\", ".
    "bill_country=\"".addslashes($data['bill_country'])."\", ".
    "ship_address1=\"".addslashes($data['ship_address1'])."\", ".
    "ship_address2=\"".addslashes($data['ship_address2'])."\", ".
    "ship_city=\"".addslashes($data['ship_city'])."\", ".
    "ship_state=\"".addslashes($data['ship_state'])."\", ".
    "ship_zip=\"".addslashes($data['ship_zip'])."\", ".
    "ship_country=\"".addslashes($data['ship_country'])."\", ".
    "pri_name=\"".addslashes($data['pri_name'])."\", ".
    "pri_title=\"".addslashes($data['pri_title'])."\", ".
    "pri_email=\"".addslashes($data['pri_email'])."\", ".
    "pri_phone=\"".addslashes($data['pri_phone'])."\", ".
    "sec_name=\"".addslashes($data['sec_name'])."\", ".
    "sec_title=\"".addslashes($data['sec_title'])."\", ".
    "sec_email=\"".addslashes($data['sec_email'])."\", ".
    "sec_phone=\"".addslashes($data['sec_phone'])."\", ".
    "date_created=NOW()";
    execute($q) or quit($q);

  if (count($data['driveSystems'])) {
    for($i=0;$i<count($data['driveSystems']);$i++) {
      $q = "INSERT INTO Users_DriveSystems SET user_id='".addslashes($uid)."', product_id='".addslashes($data['driveSystems'][$i])."'";
      execute($q);
    }
  }
  
	return $uid;
}

function edit_user($uid, $data) {
  $q = "UPDATE Users SET ".
    ($data['password']!=""?"password=\"".addslashes($data['password'])."\", ":"").
    "fname=\"".addslashes($data['fname'])."\", ".
    "lname=\"".addslashes($data['lname'])."\", ".
    "email=\"".addslashes($data['email'])."\", ".
    "company=\"".addslashes($data['company'])."\", ".
    "phone=\"".addslashes($data['phone'])."\", ".    
    "fax=\"".addslashes($data['fax'])."\", ".    
    "url=\"".addslashes($data['url'])."\", ".        
    "bill_address1=\"".addslashes($data['bill_address1'])."\", ".
    "bill_address2=\"".addslashes($data['bill_address2'])."\", ".
    "bill_city=\"".addslashes($data['bill_city'])."\", ".
    "bill_state=\"".addslashes($data['bill_state'])."\", ".
    "bill_zip=\"".addslashes($data['bill_zip'])."\", ".
    "bill_country=\"".addslashes($data['bill_country'])."\", ".
    "ship_address1=\"".addslashes($data['ship_address1'])."\", ".
    "ship_address2=\"".addslashes($data['ship_address2'])."\", ".
    "ship_city=\"".addslashes($data['ship_city'])."\", ".
    "ship_state=\"".addslashes($data['ship_state'])."\", ".
    "ship_zip=\"".addslashes($data['ship_zip'])."\", ".
    "ship_country=\"".addslashes($data['ship_country'])."\", ".
    "pri_name=\"".addslashes($data['pri_name'])."\", ".
    "pri_title=\"".addslashes($data['pri_title'])."\", ".
    "pri_email=\"".addslashes($data['pri_email'])."\", ".
    "pri_phone=\"".addslashes($data['pri_phone'])."\", ".
    "sec_name=\"".addslashes($data['sec_name'])."\", ".
    "sec_title=\"".addslashes($data['sec_title'])."\", ".
    "sec_email=\"".addslashes($data['sec_email'])."\", ".
    "sec_phone=\"".addslashes($data['sec_phone'])."\"    
    WHERE user_id=".addslashes($uid);
  execute($q) or quit($q);
  
  if (mysql_error()) return false;
  return true;
}

function update_user($data) {

	$q = "UPDATE Users SET ".
    ($data['user_type']!=""?"user_type=\"".addslashes($data['user_type'])."\", ":"").
    ($data['user_status']!=""?"user_status=\"".addslashes($data['user_status'])."\", ":"").
    ($data['password2']!=""?"password=\"".addslashes($data['password2'])."\", ":"").
    "fname=\"".addslashes($data['fname'])."\", ".
    "lname=\"".addslashes($data['lname'])."\", ".
    "email=\"".addslashes($data['email'])."\", ".
    "company=\"".addslashes($data['company'])."\", ".
    "phone=\"".addslashes($data['phone'])."\", ".
    "fax=\"".addslashes($data['fax'])."\", ".    
    "url=\"".addslashes($data['url'])."\", ".    
    "bill_address1=\"".addslashes($data['bill_address1'])."\", ".
    "bill_address2=\"".addslashes($data['bill_address2'])."\", ".
    "bill_city=\"".addslashes($data['bill_city'])."\", ".
    "bill_state=\"".addslashes($data['bill_state'])."\", ".
    "bill_zip=\"".addslashes($data['bill_zip'])."\", ".
    "bill_country=\"".addslashes($data['bill_country'])."\", ".
    "ship_address1=\"".addslashes($data['ship_address1'])."\", ".
    "ship_address2=\"".addslashes($data['ship_address2'])."\", ".
    "ship_city=\"".addslashes($data['ship_city'])."\", ".
    "ship_state=\"".addslashes($data['ship_state'])."\", ".
    "ship_zip=\"".addslashes($data['ship_zip'])."\", ".
    "ship_country=\"".addslashes($data['ship_country'])."\", ".
    "pri_name=\"".addslashes($data['pri_name'])."\", ".
    "pri_title=\"".addslashes($data['pri_title'])."\", ".
    "pri_email=\"".addslashes($data['pri_email'])."\", ".
    "pri_phone=\"".addslashes($data['pri_phone'])."\", ".
    "sec_name=\"".addslashes($data['sec_name'])."\", ".
    "sec_title=\"".addslashes($data['sec_title'])."\", ".
    "sec_email=\"".addslashes($data['sec_email'])."\", ".
    "sec_phone=\"".addslashes($data['sec_phone'])."\"   ".    
    "WHERE user_id=\"".addslashes($data['user_id'])."\"";
  execute($q) or quit($q);  
  if (mysql_error()) { return false; }
  
  $q = "DELETE FROM Users_DriveSystems WHERE user_id='".addslashes($data['user_id'])."'";
  execute($q);
  if (count($data['driveSystems'])) {
    for($i=0;$i<count($data['driveSystems']);$i++) {
      $q = "INSERT INTO Users_DriveSystems SET user_id='".addslashes($data['user_id'])."', product_id='".addslashes($data['driveSystems'][$i])."'";
      execute($q);
    }
  }
  
  return true;
}

function delete_user($user_id) {
  $q = "DELETE from Users WHERE user_id='".addslashes($user_id)."'";
  execute($q);
  if (mysql_error()) return false;
    
  return true;
}

function update_settings($data) {
  $keys = array();
  foreach ($keys as $k) {
    $q = "INSERT INTO settings (config, value) VALUES('".addslashes($k)."', '".addslashes($data[$k])."') ON DUPLICATE KEY UPDATE value='".addslashes($data[$k])."'";
    execute($q);
    if (mysql_error()) { return false; }
  }
  return true;
}

function get_settings() {
  $ret = array();
  
  $q = "SELECT * FROM settings";
  $r = execute($q);
  foreach (@collect($r) as $row) {
    $ret[$row['config']] = $row['value'];
  }
  return $ret;
}

//creates new id number for specified table
function new_index($table, $id, $cond=false) {
	$q = "SELECT MAX($id) AS m FROM $table".($cond!=false?" WHERE ".$cond:"");
	$r = execute($q);
	if ($r = fetch($r)) {
		$newid = $r['m'] + 1;
	} else {
		$newid = 1;
	}
	return $newid;
}

function search_pages($data) {
  $where = array();

  if (!$data['sort']) { $sort = "filename ASC"; }
  else { $sort = $data['sort']; }
  
  foreach (explode(" ", $data['search']) as $word) {
    $where[] = "(body LIKE '%".addslashes($word)."%' OR pagetitle LIKE '%".addslashes($word)."%')";
    //$search .= ($search!=""?" AND ":"")."body LIKE '%".addslashes($word)."%' OR pagetitle LIKE '%".addslashes($word)."%'";
  }
  if ($data['id']!="") $where[] = "pages.id='".addslashes($data['id'])."'";
  if ($data['is_product']!="") $where[] = "pages.is_product='".addslashes($data['is_product'])."'";

  if (!count($where)) return false;
  
  $q = "SELECT * FROM pages ".(count($where)?"WHERE ".implode(" AND ",$where):"")." ORDER BY ".addslashes($sort);
  $r = execute($q);
  return @collect($r);
}

function get_industries($data=false) {
  $where = array();
  if ($data['id']!="") $where[] = "id='".addslashes($data['id'])."'";

  $q = "SELECT * FROM Industries".(count($where)?' WHERE '.implode(" AND ", $where):"")." ORDER BY name ASC";
  $r = execute($q);
  return @collect($r);
}

function get_critical_needs($data=false) {
  $where = array();
  if ($data['id']!="") $where[] = "id='".addslashes($data['id'])."'";

  $q = "SELECT * FROM CriticalNeeds".(count($where)?' WHERE '.implode(" AND ", $where):"");
  $r = execute($q);
  return @collect($r);
}

function get_products($data = false) {
  $data['is_product'] = 1;
  return search_pages($data);
}



function search_wizard($data) {
  $where = array();
  //$where[] = "i.id IS NOT NULL AND cn.id IS NOT NULL";
  $where[] = "p.is_product = 1";
  $where[] = "p.wizardHide != 1";
  
  if ($data['industry']!="") $where[] = "i.id='".addslashes($data['industry'])."'";
  if ($data['challenge']!="") $where[] = "cn.id='".addslashes($data['challenge'])."'";
  
  $q = "SELECT p.* FROM pages p 
  LEFT JOIN product2CriticalNeeds p2cn ON p.id = p2cn.page_id 
  LEFT JOIN product2Industries p2i ON p.id = p2i.page_id
  LEFT JOIN Industries i ON p2i.industry_id = i.id
  LEFT JOIN CriticalNeeds cn ON p2cn.need_id = cn.id
  ".(count($where)?" WHERE ".implode(" AND ", $where)." ":"")."
  GROUP BY p.id";

  $r = execute($q);
  return @collect($r);  
}

function logDebug($val) {
  $q = "INSERT INTO DebugLog SET data='".addslashes(json_encode($val))."'";
  execute($q);
}
?>