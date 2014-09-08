<?
function email_password($un) {
  global $email_from;
  
	$q = "SELECT * FROM Users WHERE email=\"".addslashes($un)."\"";
	$r = execute($q);
	$r = fetch($r);

	$to = $r['email'];
	$from = $email_from;
	$subject = "Your Phillips Screw password";
	$body = "Here is the password you requested.\n\nPassword: ".$r['password']."\n\n";

  $mailer = new Mailer();
  $mailer->AddAddress("to", $to, "");
  $mailer->from("", $email_from);
  $mailer->subject($subject);
  $mailer->text($body);
  $mailer->send();
  
  return true;
}

function email_registration($data) {
  global $orders_email_from;
  
  $user_subject = "Your Hebert Candies registration";
  
  $body = '
  <html><head>
  </head>
  <body>
  Your Hebert Candies account has been created.<br><br>
  Username: '.$data['email'].'<br>
  Password: '.$data['password'].'<br>
  </body></html>';
  
  $mailer = new Mailer();
  $mailer->AddAddress("to", $data['email'], "");
  $mailer->from("", $orders_email_from);
  $mailer->subject($user_subject);
  $mailer->html($body);

  $mailer->send();
}
?>