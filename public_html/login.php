<?
include_once("functions/include.php");
session_start();
if ($_GET['l']==1) { $_POST['Do'] = "Logout"; }
$r = (isset($_POST['r'])?$_POST['r']:$_GET['r']);

if ($_SESSION['admin_override'] && $_GET['back_to_admin']) {
  $user = get_user($_SESSION['admin_override']);
  $_SESSION['user_id'] = $_SESSION['admin_override'];
  unset($_SESSION['admin_override']);
  header("Location: ".$domain."admin_users.php");
  exit;
}

if ($_POST['Do']=="Logout") {
    unset($_SESSION['user_id']);
    unset($_SESSION['admin_id']);
    unset($_SESSION['authenticated']);
	$message = "You have been logged out.";
} elseif ($_POST['Do']=="Login") {
  $go = true;
  
  $required = array("username");
  if (!filled_out($_POST, $required)) {
    $go = false;
    $message = "Please fill in all fields.";
  }
  
  if ($go) {
    if ($_POST['type']=="Email") {
      if (exists_username($_POST['username'])) {
        if (email_password($_POST['username'])) {
          $message = "<font color=blue>Your password has been sent</font>";
        } else {
          $message = "<font color=red>An error occurred.  Please try again.</font>";
        }
      } else {
        $message = "Unknown login";
      }  
    } else {
      if (!($user_id = login_user($_POST['username'], $_POST['password']))) {    
        $message = "Unknown login";
      } else {
        $_SESSION['authenticated'] = 1;
        $_SESSION['user_id'] = $user_id;
        $loginRedir = $_SESSION['loginRedir'];
        unset($_SESSION['loginRedir']);
        if ($loginRedir!="") { header("Location: ".$domain.$loginRedir); exit; }
        
        $user = get_user($user_id);
        switch ($r) {
          case "chk1":
            header("Location: checkout1.php");
            exit;
            break;
          default:
            if ($user['user_type']==$SITEADMIN_UTID) { header("Location: admin_users.php"); }
            elseif ($user['user_type']==$LICENSEE_UTID) { header("Location: licensee_downloads.php"); }
            else { header("Location: ".$domain); }
            exit;
            break;
        }
      }    
    }
  }
}

$TEMPLATE['onload'] = "document.form1.username.focus();";
$replace['LOGIN_FORM'] = '
      <div align="center"><form method="POST" action="login.php" name="form1" class="form1">
      <input type="hidden" name="Do" value="Login">
      <input type="hidden" name="r" value="'.$r.'">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
'.($message!=""?'
        <tr>
          <td class="text1" align="left" valign="top"><font color="#ff0000">'.$message.'<br><br></font></td>
        </tr>':'').'
        <tr>
          <td align="left" valign="top" class="text1"><input type="text" name="username" class="formfield3" value="'.$_POST['username'].'"> Email Address</td>
        </tr>
        <tr>
          <td align="left" valign="top"><img border="0" src="images/transparent.gif" width="1" height="4" alt=""></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="text1"><input type="password" name="password" class="formfield3"> Password<br>
          <input type="checkbox" name="type" value="Email"> Check here if you have forgotten your password.</td>
        </tr>
        <tr>
          <td align="left" valign="top"><img border="0" src="images/transparent.gif" width="1" height="4" alt=""></td>
        </tr>
        <tr>
          <td align="left" valign="top"><input type="submit" value="Sign In &#187;" name="Submit" class="formbutton1"></td>
        </tr>
	<tr>
			<td><br><br>
	<strong>NOTICE (August 2014)</strong>:  We have recently updated many of our Technical Manuals.  After completing your log in please review the manuals that you are authorized to use for any changes.  Additionally, we are now moving to having all of our Technical Manual Updates done on line and as part of this process we are recalling all hard copy technical manuals.  Please contact Kim Bowse at <a href="mailto:kbowse@phillips-screw.com">kbowse@phillips-screw.com</a> for instructions on how to return your out dated manuals.
		</td>
	</tr>
      </table></form></div>';
      
include("template.php");
exit;
?>
