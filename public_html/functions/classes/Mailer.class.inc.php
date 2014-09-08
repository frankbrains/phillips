<?
class Mailer {
/*
  Example:
    $mailer = new Mailer();
    $mailer->AddAddress("to", "support@nethosters.com", "Nethosters Support");
    $mailer->from("Noreply", "noreply@nethosters.com");
    $mailer->subject("An email for you");
    $mailer->text("Plain Text Message");
    $mailer->html("<html><body><b>HTML Message</b></body></html>");
    $mailer->send();
*/

  var $_to = array();
  var $_bcc = array();
  var $_cc = array();
  var $_files = array();
  var $_errors = array();
  var $_errcnt = 0;
  var $_fromemail = "";
  var $_fromname = "";
  var $_replyto = "";
  var $_textbody = "";
  var $_htmlbody = "";
  var $_subject = "";
  var $mixed_boundary = "";
  var $alternative_boundary = "";

  function AddAddress($type, $email, $name) {
    $lowertype = strtolower($type);
    $data = array("name" => $name, "email" => $email);
    switch ($lowertype) {
      case "to":
        array_push($this->_to, $data);
        break;
      case "cc":
        array_push($this->_cc, $data);
        break;
      case "bcc":
        array_push($this->_bcc, array("email"=>$email));
        break;
    }
  }

  function to($name, $email) {
    $this->_to = array("name" => $name, "email" => $email);
  }

  function from($name, $email) {
    $this->_fromname = $name;
    $this->_fromemail = $email;
  }

  function fromname($name) {
    $this->_fromname = $name;
  }

  function fromemail($email) {
    $this->_fromemail = $email;
  }

  function subject($subject) {
    $this->_subject = $subject;
  }

  function body($type, $body) {
    if ($type=="html") {
      $this->html = $body;
    } elseif ($type=="text") {
      $this->text = $body;
    }
  }

  function html($body) {
    $this->_htmlbody = $body;
  }

  function text($body) {
    $this->_textbody = $body;
  }


  function replyto($email) {
    $this->_replyto = $email;
  }

  function send() {
    $topheader = false;
    $body = "";
    $this->mixed_boundary = $this->_generate_boundary();
    $this->alternative_boundary = $this->_generate_boundary();

    // Build Headers
    $headers =
       'From: '.($this->_fromname!=""?$this->_fromname.' ':'').'<'.$this->_fromemail . ">\n" .
      (count($this->_cc)?'CC: '.$this->_createAddresses($this->_cc)."\n":"").
      (count($this->_bcc)?'BCC: '.$this->_createAddresses($this->_bcc)."\n":"").
      ($this->_replyto!=""?"Reply-To: ".$this->_replyto."\n":"").
      'X-Mailer: PHP/'.phpversion()."\n".
      'Mime-Version: 1.0';

    if ($this->multipart_mixed()) {
      $headers .= "\nContent-Type: multipart/mixed;\n boundary=\"".$this->mixed_boundary."\"";
    } elseif ($this->multipart_alternative()) {
      $headers .= "\nContent-Type: multipart/alternative;\n boundary=\"".$this->alternative_boundary."\"";
    } elseif (!$this->multipart()) {
      if ($this->_textbody!="") {
        $headers .= "\n".$this->_textheader();
      } elseif($this->_htmlbody!="") {
        $headers .= "\n".$this->_htmlheader();
      }
    }
    // Finished building headers
    if ($this->multipart_alternative()) {
      $alternative_body = "--".$this->alternative_boundary."\n".$this->_textheader()."\n".$this->_textbody."\n\n"."--".$this->alternative_boundary."\n".$this->_htmlheader()."\n".$this->_htmlbody;
    }

    if ($this->multipart_mixed()) {
      $body .= "This is a multi-part message in MIME format.\n"."--".$this->mixed_boundary."\n";
      if ($this->multipart_alternative()) {
        $body .=  $this->_altheader()."\n\n".$alternative_body."\n".$this->alternative_boundary."--";
      } else {
        if ($this->_textbody!="") {
          $body .= "\n\n".$this->_textheader."\n".$this->textbody;
        } elseif ($this->_htmlbody!="") {
          $body .= "\n\n".$this->_htmlheader."\n".$this->_htmlbody;
        }
      }
      if (count($this->_files)>0) {
        foreach ($this->_files as $file) {
          $body .= "\n\n"."--".$this->mixed_boundary."\n".$this->_filebody($file);
        }
      }
      $body .= "\n--".$this->mixed_boundary."--\n\n";

    } elseif ($this->multipart_alternative()) {
      $body .= "This is a multi-part message in MIME format.\n".$alternative_body."\n"."--".$this->alternative_boundary."--\n\n";
    } elseif (!$this->multipart()) {
      $body .= ($this->_textbody!=""?$this->_textbody:($this->_htmlbody!=""?$this->_htmlbody:""));
    }

    $body .= "\n\n";
    if (!mail($this->_createAddresses($this->_to), $this->_subject, $body, $headers, '-r '.$this->_fromemail)) {
      $this->_errors[] = "Email send failed.";
      $this->_errcnt = sizeof($this->_errors);
    }
  }

  function _filebody($file) {
    $out = "Content-Type: text/plain; name=\"nexus.txt\"\nContent-Transfer-Encoding: base64\nContent-Disposition: attachment; filename=\"nexus.txt\"\n\n";
    $out .= "ICANCiAqIGltcGxlbWVudCBzZWFyY2ggc3RhdHMgcmVwb3J0IG9uIE5leHVzOiAyLTMgaG91
cnMgIA0KICogaW1wbGVtZW50IHNlYXJjaCBzdGF0IHJlcG9ydA0KDQogKiByZXF1aXJlIGFs
bCBnb2FscyBmaWVsZHMgb24gbWVtYmVyIGFwcCwgYW5kIGFkZCBpbiBhbGwgb3RoZXIgZ29h
bHMgZmllbGRzIGhlcmUsIHVzZXIgcHJlZnMgYW5kIGFkbWluIHBhZ2VzOiAyLTMgaG91cnMg
DQogIA0KICogY2l0eSBwcm9maWxlcyANCiAgDQogKiByZXBvcnRzIA0KICANCg0KZml4IHJl
c2VydmUgdGhpcyBwcm9wZXJ0eSBvbiBJUiAtDQpkaXNwbGF5IHRoYW5rIHlvdSBub3RlIGZv
ciBOZXh1cyBtZW1iZXJzDQoNCnJhY2sgb3JmLW50LTE4";
    return $out;
  }

  function _altheader() {
    $out = "Content-Type: multipart/alternative;\n boundary=\"".$this->alternative_boundary."\""."\n";
    return $out;
  }

  function _textheader() {
    $out = "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\nContent-Transfer-Encoding: 7bit\n";
    return $out;
  }

  function _htmlheader() {
    $out = "Content-Type: text/html; charset=ISO-8859-1\nContent-Transfer-Encoding: 7bit\n";
    return $out;
  }

  function _createAddresses($data) {
    $return = "";
    foreach ($data as $row) {
      $return .= ($row['name']!=""?$row['name'].' <':"").$row['email'].($row['name']!=""?'>':"").",";
    }

    return rtrim($return, ",");
  }

  function _generate_boundary() {
    $chars = "0123456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $boundary = '--------------' ;

    while ($i <= 23) {
      $num = rand() % 10;
      $tmp = substr($chars, $num, 1);
      $boundary .= $tmp;
      $i++;
    }

    return $boundary;
  }

  function multipart() {
    $parts = 0;
    if ($this->_htmlbody!="") { $parts++; }
    if ($this->_textbody!="") { $parts++; }
    if (count($this->_files)>0) { $parts++; }
    if ($parts>1) { return true; }
    return false;
  }

  function multipart_mixed() {
    if (count($this->_files)>0) { return true; }
    return false;
  }

  function multipart_alternative() {
    if ($this->_htmlbody!="" && $this->_textbody!="") {
      return true;
    }
    return false;
  }
}
?>
