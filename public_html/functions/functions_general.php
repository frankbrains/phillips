<?
//!!DO NOT MODIFY!!
//misc functions for data validation/manipulation
function site_url($path) {
  global $domain;
  return $domain.(substr($domain, -1)=="/"?"":"/").(substr($path,0,1)=="/"?substr($path,1):$path);
}

function verify_privileges($user, $allowed) {
  global $_SESSION;
  
  $go = false;
  if (is_array($allowed)) {
    for ($i=0;$i<count($allowed);$i++) {
      if ($user['user_type']==$allowed[$i]) { $go = true; }
    }
  } else {
    if ($user['user_type']==$allowed) { $go = true; }
  }
 
  if (!$go) {
    header("Location: login.php?message=".urlencode("Your session has expired or you do not have permission to access that page."));
    exit;
  }
}

function check_session() {  
  global $_SESSION, $_SERVER;
  
  if (!session_id() || !$_SESSION['user_id']) {
    $_SESSION['loginRedir'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php?message=".urlencode('Session expired or access denied.'));
    exit;
  }
  return $_SESSION['user_id'];
}

function month($id) {
  global $MONTHS;
  if (is_numeric($id) && $id>=1 && $id<=12) {
    return $MONTHS[($id-1)];
  }
  return false;
}

function filled_out($data, $required) {
	$result = true;
	foreach ($required as $field) {
		if (trim($data[$field]) == "") {
			$result = false;
		}
	}
	return $result;
}

function is_blank($s) {
	return preg_match("/^\s*$/", $s);
}

function valid_email($address) {
	$address = preg_replace("/^\s+/", "", $address);
	$address = preg_replace("/\s+$/", "", $address);

	return preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $address);
}

function valid_emails($emails) {
	$emails = preg_split("/[\s,]+/", $emails);

	$result = true;
	foreach ($emails as $email) {
		if (!valid_email($email)) {
			$result = false;
			break;
		}
	}
	return $result;
}

function valid_phone($phone) {
	$phone = preg_replace("/^\s+/", "", $phone);
	$phone = preg_replace("/\s+$/", "", $phone);

	return preg_match("/^\d{3}\.\d{3}\.\d{4}$/", $phone);
}

function make_list($array) {
	$list = "(";
	for ($i=0; $i<count($array)-1; $i++) {
		$list .= $array[$i] .",";
	}
	$list .= $array[$i] .")";
	return $list;
}

function shorten($s, $n, $add) {
	if (strlen($s) > $n) {
		return substr($s, 0, $n-1) . $add;
	} else {
		return $s;
	}
}

function fix_puncs($s) {
	$s = preg_replace("/(\\\){2}/", "&#92;", $s);
	$s = preg_replace("/\\\/", "", $s);
	$s = preg_replace("/\"/", "&quot;", $s);
	$s = preg_replace("/'/", "&#39;", $s);
	return $s;
}

function random($n) {
	return substr(md5(uniqid(rand())),0,$n);
}

//if country is US or Canada, user needs to specify state/province
function need_state($iso_code) {
	return ($iso_code == "US");
}

if (substr(phpversion(), 0, 1)<5) {
  function fputcsv($handle, $row, $fd=',', $quot='"')
  {
     $str='';
     foreach ($row as $cell) {
         $cell=str_replace(Array($quot,        "\n"),
                           Array($quot.$quot,  ''),
                           $cell);
         if (strchr($cell, $fd)!==FALSE || strchr($cell, $quot)!==FALSE) {
             $str.=$quot.$cell.$quot.$fd;
         } else {
             $str.=$cell.$fd;
         }
     }

     fputs($handle, substr($str, 0, -1)."\n");

     return strlen($str);
  }
}

function strtflt($str) {
    $il = strlen($str);
    $flt = "";
    $cstr = "";
   
    for($i=0;$i<$il;$i++) {
        $cstr = substr($str, $i, 1);
        if(is_numeric($cstr) || $cstr == ".")
            $flt = $flt.$cstr;
    }
    return floatval($flt);
}

function curl_authnet($oid, $data) {
	$authorizenet = get_authorizenet();
	$order = get_order($oid);

  //if amount is 0, then skip payment gateway
  if ($order['total']<=0) {
          $results = array();
          $results[0] = 1;
          return $results;
  }

  $host = "https://secure.authorize.net/gateway/transact.dll";
  $x_login = $authorizenet['login_id'];
  $x_tran_key = $authorizenet['transaction_key'];

	$billsame = $order['billsame'];

  $pdata ="x_login=".$x_login."&".
    "x_tran_key=".$x_tran_key."&".
    "x_currency_code=USD&".
    "x_method=CC&".
    "x_type=AUTH_CAPTURE&".
    "x_card_num=".urlencode(trim(get_ccn($oid)))."&".
    "x_exp_date=".urlencode(str_pad($order['cc_exp_month'], 2, "0", STR_PAD_LEFT).str_pad($order['cc_exp_year'], 2, "0", STR_PAD_LEFT))."&".
    "x_card_code=".urlencode(trim($data['cc_cvv2']))."&".
    "x_amount=".urlencode($order['total'])."&".
    "x_first_name=".urlencode($order['bill_fname'])."&".
    "x_last_name=".urlencode($order['bill_lname'])."&".
    "x_address=".urlencode($order['bill_address1'])."&".
    "x_city=".urlencode($order['bill_city'])."&".
    "x_customer_ip=".urlencode($order['ip'])."&".
    "x_state=".urlencode($order['bill_state'])."&".
    "x_zip=".urlencode($order['bill_zip'])."&".
    "x_phone=".urlencode($order['bill_phone'])."&".
    "x_country=".urlencode($order['bill_country'])."&".
    "x_email=".urlencode($order['bill_email'])."&".
    "x_delim_data=TRUE&".
    "x_delim_char=".urlencode(",")."&".
    "x_encap_char=".urlencode("\"")."&".
    "x_relay_url=FALSE&".
    "x_test_request=true";

  $ch = curl_init($host);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $pdata);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $result = curl_exec($ch);
  curl_close($ch);
  $result = preg_replace("/\"/", "", $result);
  $results = preg_split("/,/", $result, 6);

  return $results;
}

function report_db_changes($oldRow, $newRow, $config) {
  global $email_from, $_SESSION, $domain, $change_reporting_to;
  
  $user = get_user($_SESSION['user_id']);

  // Meant to report changes to rows in the following modules:
  // (cms, doc library, news, events, terminology)
  
  $subject = (isset($config['_config']['subject'])?$config['_config']['subject']:"Website content change notification.");
  $from = $email_from;
  $to = $change_reporting_to;  
  $send = false;
  
  if (!count($oldRow)) {
    // Added
    $subject = (isset($config['_config']['addSubject'])?$config['_config']['addSubject']:"Website content added notification.");
    $introText = date("m/d/Y G:i:s T").'<br>
The following record was added to the website by '.$user['fname'].' '.$user['lname'].' (<a href="mailto:'.$user['email'].'">'.$user['email'].'</a>):';

	$changes = array();
	foreach (array_keys($newRow) as $keys1) {
		if (isset($config[$keys1])) {
			$changes[] = array("key"=>$keys1, "new"=>$newRow[$keys1]);
		}
	}
	$changeRows = '';
	foreach ($changes as $change) {
	  $changeRows .= '
  <tr><td colspan="2" height="5" align="left"><div style="height: 5px;"></div></td></tr>
  <tr><td colspan="2" height="1" align="left" style="background-color: #cccccc;"><div style="height: 1px;"></div></td></tr>
  <tr><td colspan="2" height="5" align="left"><div style="height: 5px;"></div></td></tr>
  <tr>
    <td style="font-family: Arial; font-size: 12px;" align="left" valign="top"><b>Field:</b>&nbsp;&nbsp;&nbsp;</td>
	<td style="font-family: Arial; font-size: 12px;">'.$config[$change['key']]['name'].'</td>
  </tr>
  <tr>
    <td style="font-family: Arial; font-size: 12px;" align="left" valign="top"><b>Value:</b>&nbsp;&nbsp;&nbsp;</td>
	<td style="font-family: Arial; font-size: 12px;">'.(isset($config[$change['key']]['map'])?$config[$change['key']]['map'][$change['new']]:$change['new']).'</td>
  </tr>';      
	}
	
	$send = true;
  } elseif (!count($newRow)) {
    $introText = date("m/d/Y G:i:s T").'<br>
The following record was deleted from the website by '.$user['fname'].' '.$user['lname'].' (<a href="mailto:'.$user['email'].'">'.$user['email'].'</a>):';

	$changes = array();
	foreach (array_keys($oldRow) as $keys1) {
		if (isset($config[$keys1])) {
			$changes[] = array("key"=>$keys1, "old"=>$oldRow[$keys1]);
		}
	}
	$changeRows = '';
	foreach ($changes as $change) {
	  $changeRows .= '
  <tr><td colspan="2" height="5" align="left"><div style="height: 5px;"></div></td></tr>
  <tr><td colspan="2" height="1" align="left" style="background-color: #cccccc;"><div style="height: 1px;"></div></td></tr>
  <tr><td colspan="2" height="5" align="left"><div style="height: 5px;"></div></td></tr>
  <tr>
    <td style="font-family: Arial; font-size: 12px;" align="left" valign="top"><b>Field:</b>&nbsp;&nbsp;&nbsp;</td>
	<td style="font-family: Arial; font-size: 12px;">'.$config[$change['key']]['name'].'</td>
  </tr>
  <tr>
    <td style="font-family: Arial; font-size: 12px;" align="left" valign="top"><b>Value:</b>&nbsp;&nbsp;&nbsp;</td>
	<td style="font-family: Arial; font-size: 12px;">'.(isset($config[$change['key']]['map'])?$config[$change['key']]['map'][$change['old']]:$change['old']).'</td>
  </tr>';      
	}
	$send = true;
  } else {	    
    $introText = date("m/d/Y G:i:s T").'<br>
The following changes were published to the website by '.$user['fname'].' '.$user['lname'].' (<a href="mailto:'.$user['email'].'">'.$user['email'].'</a>):';

	$changes = array();
	foreach (array_keys($newRow) as $keys1) {
		if ($newRow[$keys1]!=$oldRow[$keys1]) {
		  if (isset($config[$keys1])) {
			$changes[] = array("key"=>$keys1, "old"=>$oldRow[$keys1], "new"=>$newRow[$keys1]);
		  }
		}
	}
	$changeRows = '';
	foreach ($changes as $change) {
	  $changeRows .= '
  <tr><td colspan="2" height="5" align="left"><div style="height: 5px;"></div></td></tr>
  <tr><td colspan="2" height="1" align="left" style="background-color: #cccccc;"><div style="height: 1px;"></div></td></tr>
  <tr><td colspan="2" height="5" align="left"><div style="height: 5px;"></div></td></tr>
  <tr>
    <td style="font-family: Arial; font-size: 12px;" align="left" valign="top"><b>Field:</b>&nbsp;&nbsp;&nbsp;</td>
	<td style="font-family: Arial; font-size: 12px;">'.$config[$change['key']]['name'].'</td>
  </tr>
  <tr>
    <td style="font-family: Arial; font-size: 12px;" align="left" valign="top"><b>Before:</b>&nbsp;&nbsp;&nbsp;</td>
	<td style="font-family: Arial; font-size: 12px;">'.(isset($config[$change['key']]['map'])?$config[$change['key']]['map'][$change['old']]:$change['old']).'</td>
  </tr>
  <tr>
    <td style="font-family: Arial; font-size: 12px;" align="left" valign="top"><b>After:</b>&nbsp;&nbsp;&nbsp;</td>
	<td style="font-family: Arial; font-size: 12px;">'.(isset($config[$change['key']]['map'])?$config[$change['key']]['map'][$change['new']]:$change['new']).'</td>
  </tr>';
	}	

	if (count($changes)) $send = true;
  }

  if ($send) {  
	$body = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="'.$domain.'style_email.css" rel="stylesheet" type="text/css">
</head><body style="background-color: #ffffff;">	
<table border="0" cellspacing="2" cellpadding="0" style="border-collapse: collapse;">
  <tr>
    <td colspan="2" style="font-family: Arial; font-size: 12px;" align="left">
    '.$introText.'
	</td>
  </tr>
  <tr><td colspan="2" height="5" align="left"><div style="height: 5px;"></div></td></tr>
  '.$changeRows.'
</table>
</body></html>';		
  
	$mailer = new Mailer();
	foreach (explode(",", $to) as $toE) $mailer->AddAddress("to", $toE, "");    
	$mailer->from("Noreply", $from);
	$mailer->subject($subject);
			
	$mailer->html($body);
	$mailer->send();
  }
}
?>