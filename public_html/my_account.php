<?
include("functions/include.php");
session_start();
$uid = check_session($_SESSION);
$login = get_user($_SESSION['user_id']);
verify_privileges($login, array($LICENSEE_UTID));

$message= ($_GET['message']!=""?$_GET['message']:"");
$id = $_SESSION['user_id'];
$edit = 1;  

if (isset($_POST['Do']) && $_POST['Do']=="Update") {
  $go = true;

  $required = array("fname", "lname", "email");
  if (!filled_out($_POST, $required)) {
    $go = false;
    $message = "Please fill in all required fields.";
  }

  if ($_POST['email']!="" && !valid_email($_POST['email'])) {
    $go = false;
    $message .= ($message!=""?"<br>":"")."Please enter a valid email address.";
  }
  
  if ($_POST['email']!="" && username_exists($_POST['email'], $id)) {
    $go = false;
    $message .= ($message!=""?"<br>":"")."That email address is already registered.";
  }

  if ( ($_POST['password']!=""||$_POST['password2']!="")
       && ($_POST['password']!=$_POST['password2'])) {
    $go = false;
    $message .= ($message!=""?"<br>":"")."Passwords must match.";
  }

  if ($go) {
    if ($_POST['bill_country']!="US"&&$_POST['bill_country']!="CA"&&$_POST['bill_country']!="IE") $_POST['bill_state'] = $_POST['bill_state_other'];
    if ($_POST['Do']=="Update" && edit_user($id, $_POST)) {
      header("Location: my_account.php?message=".urlencode("Your information has been updated."));
      exit;
    } else {
      header("Location: my_account.php?message=".urlencode("An error occured.  Please try again."));
      exit;
    }
  }
}

if (!isset($_POST['Do'])) {
  $_POST = get_user($id);
  if ($_POST['bill_country']!="US"&&$_POST['bill_country']!="CA"&&$_POST['bill_country']!="IE") $_POST['bill_state_other'] = $_POST['bill_state'];
}

if (!isset($_POST['bill_country'])) $_POST['bill_country'] = "US";
if (!isset($_POST['ship_country'])) $_POST['ship_country'] = "US";

list($header,$footer) = get_backend_pieces();

$replace['PAGINATOR'] = "";
$replace['PREV_ARROW'] = "";
$replace['NEXT_ARROW'] = "";
$replace['PAGINATOR_LABEL'] = "";

$replace['ACCOUNT_FORM'] = '
<script language="JavaScript">
</script>

      <form method="post" action="my_account.php" name="User">
      <input type="hidden" name="Do" value="Update">
      <span class="text6">Required fields are marked with an asterisk *<br><br>
      '.($message!=""?'<font color="#ff0000">'.$message.'<br><br>':'').'</span>
        <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td align="left" class="text6">First Name: *</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="fname" value="'.$_POST['fname'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Last Name: *</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="lname" value="'.$_POST['lname'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Email: *</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="email" value="'.$_POST['email'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Password:</td>
            <td align="left" class="text6"><input type="password" class="formfield3" name="password" value=""></td>
          </tr>
          <tr>
            <td align="left" class="text6">Verify Password:</td>
            <td align="left" class="text6"><input type="password" class="formfield3" name="password2" value=""></td>
          </tr>
          <tr>
            <td align="left" class="text6">Company:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="company" value="'.$_POST['company'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Address 1:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="bill_address1" value="'.$_POST['bill_address1'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Address 2:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="bill_address2" value="'.$_POST['bill_address2'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">City:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="bill_city" value="'.$_POST['bill_city'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6"><span id="span_bill_state">State</span>:</td>
            <td align="left" class="text6">
              <span id="span_sel_bill_state"'.($_POST['bill_country']==""||($_POST['bill_country']=="US"||$_POST['bill_country']=="CA"||$_POST['bill_country']=="IE")?'':' style="display:none;"').'>
			  <select name="bill_state" id="bill_state" class="formfield3">
              <option value=""></option>';    

foreach (($_POST['bill_country']=="CA"?$CANADA_PROVINCES:($_POST['bill_country']=="IE"?$IRISH_STATES:$STATES)) as $tid=>$tval) {
$replace['ACCOUNT_FORM'] .= '
              <option value="'.$tid.'"'.($_POST['bill_state']==$tid?" selected":"").'>'.$tval.'</option>';
}
$replace['ACCOUNT_FORM'] .= '
            </select></span><span id="span_sel_bill_state_other"'.($_POST['bill_country']!=""&&($_POST['bill_country']!="US"&&$_POST['bill_country']!="CA"&&$_POST['bill_country']!="IE")?'':' style="display:none;"').'><input type="text" name="bill_state_other" id="bill_state_other" value="'.$_POST['bill_state_other'].'"></span></td>
          </tr>
          <tr>
            <td align="left" class="text6">Zip:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="bill_zip" value="'.$_POST['bill_zip'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Country:&nbsp;</td>
            <td align="left" class="text6"><select id="bill_country" name="bill_country" class="changeState" rel="bill_state">
			<option value=""></option>';
foreach ($COUNTRIES as $cid=>$cval) {
$replace['ACCOUNT_FORM'] .= '
            <option value="'.$cid.'"'.($_POST['bill_country']==$cid?" selected":"").'>'.$cval.'</option>';
}
$replace['ACCOUNT_FORM'] .= '
              </select></td>
          </tr>				  
          <tr>
            <td align="left" class="text6">Phone:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="phone" value="'.$_POST['phone'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Fax:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="fax" value="'.$_POST['fax'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">URL:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="url" value="'.$_POST['url'].'"></td>
          </tr>
          <tbody id="tbody_driveSystems"'.($_POST['user_type']!=$LICENSEE_UTID?' style="display: none;"':'').'>
          <tr><td colspan="2"><img src="images/transparent.gif" height="10" width="1" alt="" border="0"></td></tr>
          <tr>
            <td colspan="2" align="left" class="text6"><b>Primary Contact</b></td>
          </tr>
          <tr>
            <td align="left" class="text6">Name:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="pri_name" value="'.$_POST['pri_name'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Title:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="pri_title" value="'.$_POST['pri_title'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Email:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="pri_email" value="'.$_POST['pri_email'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Phone:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="pri_phone" value="'.$_POST['pri_phone'].'"></td>
          </tr>
          <tr><td colspan="2"><img src="images/transparent.gif" height="10" width="1" alt="" border="0"></td></tr>
          <tr>
            <td colspan="2" align="left" class="text6"><b>Secondary Contact</b></td>
          </tr>
          <tr>
            <td align="left" class="text6">Name:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="sec_name" value="'.$_POST['sec_name'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Title:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="sec_title" value="'.$_POST['sec_title'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Email:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="sec_email" value="'.$_POST['sec_email'].'"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Phone:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="sec_phone" value="'.$_POST['sec_phone'].'"></td>
          </tr>          
          <tr><td colspan="2"><img src="images/transparent.gif" height="10" width="1" alt="" border="0"></td></tr>
          <tr>
            <td colspan="2" align="center" class="text6">
              <br><input type="submit" name="submitit" value="Update my profile" class="formbutton1"></td>
          </tr>
        </table>
        </form>';
        
include("template.php");
?>