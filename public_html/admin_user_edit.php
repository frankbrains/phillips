<?
include("functions/include.php");
session_start();
$uid = check_session($_SESSION);
$login = get_user($_SESSION['user_id']);
verify_privileges($login, array($SITEADMIN_UTID));

$message= ($_GET['message']!=""?$_GET['message']:"");
$id = ($_POST['user_id']?$_POST['user_id']:$_GET['user_id']);
if (!$id) {
  $add = 1;
  #header("Location: admin_users.php?message=".urlencode("Invalid user id specified")); exit; 
}

if (isset($_POST['Do']) && ($_POST['Do']=="Add" || $_POST['Do']=="Update") ) {
  $go = true;
  
  if ($_POST['Do']=="Update") $edit = 1;  

  $required = array("user_type", "fname", "lname", "email");
  if ($_POST['Do']=="Add") { array_push($required, "password", "password2"); }
  if ($_POST['school_id']=="NEW") { array_push($required, "new_school"); }
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
    if ($_POST['Do']=="Add" && add_user($_POST)) {
      header("Location: admin_users.php?message=".urlencode("User added successfully."));
      exit;
    } elseif ($_POST['Do']=="Update" && update_user($_POST)) {
      header("Location: admin_users.php?message=".urlencode("User updated successfully."));
      exit;
    } else {
      $message = "An error occured.  Please try again.";
    }
  }
}

if (isset($_POST['Do']) && $_POST['Do']=="Edit") {
  $edit = 1;

  $user = get_user($id);  
  $driveSystems = get_user_drive_systems($id);
  $_POST = $user;
  $_POST['driveSystems'] = array();
  foreach ($driveSystems as $row) $_POST['driveSystems'][] = $row['product_id'];

  if ($_POST['bill_country']!="US"&&$_POST['bill_country']!="CA"&&$_POST['bill_country']!="IE") $_POST['bill_state_other'] = $_POST['bill_state'];  
} elseif (!isset($_POST['Do'])) {
  $_POST['driveSystems'] = array();
}

if (!isset($_POST['bill_country'])) $_POST['bill_country'] = "US";
if (!isset($_POST['ship_country'])) $_POST['ship_country'] = "US";

list($header,$footer) = get_backend_pieces();
?>

<?eval_mixed($header);?>
<script language="JavaScript">
$().ready(function() {
  $("#user_type").change(function() {
    if ($(this).children("option:selected").val()=="<?=$LICENSEE_UTID?>") $("#tbody_driveSystems").show();
    else $("#tbody_driveSystems").hide();
  });
});
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr><td align="center" class="text3"><b>Registered Users</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text6">
        <form method="post" action="admin_user_edit.php" name="User">
        <input type="hidden" name="Do" value="<?=($edit?"Update":"Add")?>">
        <?=($edit?'<input type="hidden" name="user_id" value="'.$id.'">':'')?>
        Required fields are marked with an asterisk *<br><br>
<? if ($message!="") { ?>
      <font color="#ff0000"><?=$message?><br><br>
<? } ?>

        <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td align="left" class="text6" width="130">User Type: *</td>
            <td align="left" class="text6">
              <select name="user_type" id="user_type" class="formfield3">
              <option value=""></option>              
<? foreach ($user_types as $tid=>$tval) { ?>
              <option value="<?=$tid?>"<?=($_POST['user_type']==$tid?" selected":"")?>><?=$tval?></option>
<? } ?>
            </select></td>
          </tr> 
          <tr>
            <td align="left" class="text6" width="130">User Status: *</td>
            <td align="left" class="text6">
              <select name="user_status" id="user_status" class="formfield3">
              <option value=""></option>              
<? foreach ($user_status as $tid=>$tval) { ?>
              <option value="<?=$tid?>"<?=($_POST['user_status']==$tid?" selected":"")?>><?=$tval?></option>
<? } ?>
            </select></td>
          </tr>           
          <tr>
            <td align="left" class="text6">First Name: *</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="fname" value="<?=$_POST['fname']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Last Name: *</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="lname" value="<?=$_POST['lname']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Email: *</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="email" value="<?=$_POST['email']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Password: <?=($add?"*":"")?></td>
            <td align="left" class="text6"><input type="password" class="formfield3" name="password" value=""></td>
          </tr>
          <tr>
            <td align="left" class="text6">Verify Password: <?=($add?"*":"")?></td>
            <td align="left" class="text6"><input type="password" class="formfield3" name="password2" value=""></td>
          </tr>
          <tr>
            <td align="left" class="text6">Company:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="company" value="<?=$_POST['company']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Address 1:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="bill_address1" value="<?=$_POST['bill_address1']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Address 2:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="bill_address2" value="<?=$_POST['bill_address2']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">City:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="bill_city" value="<?=$_POST['bill_city']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6"><span id="span_bill_state">State</span>:</td>
            <td align="left" class="text6">
			  <span id="span_sel_bill_state"<?=($_POST['bill_country']==""||($_POST['bill_country']=="US"||$_POST['bill_country']=="CA"||$_POST['bill_country']=="IE")?'':' style="display:none;"')?>>
			  <select name="bill_state" id="bill_state" class="formfield3">
              <option value=""></option>              
<? foreach (($_POST['bill_country']=="CA"?$CANADA_PROVINCES:($_POST['bill_country']=="IE"?$IRISH_STATES:$STATES)) as $tid=>$tval) { ?>
              <option value="<?=$tid?>"<?=($_POST['bill_state']==$tid?" selected":"")?>><?=$tval?></option>
<? } ?>
            </select></span><span id="span_sel_bill_state_other"<?=($_POST['bill_country']!=""&&($_POST['bill_country']!="US"&&$_POST['bill_country']!="CA"&&$_POST['bill_country']!="IE")?'':' style="display:none;"')?>><input type="text" name="bill_state_other" id="bill_state_other" value="<?=$_POST['bill_state_other']?>"></span></td>
          </tr>
          <tr>
            <td align="left" class="text6">Zip:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="bill_zip" value="<?=$_POST['bill_zip']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Country:&nbsp;</td>
            <td align="left" class="text6"><select id="bill_country" name="bill_country" class="changeState" rel="bill_state">
			<option value=""></option>
			<?foreach ($COUNTRIES as $cid=>$cval){?><option value="<?=$cid?>"<?=($_POST['bill_country']==$cid?" selected":"")?>><?=$cval?></option><?}?></select></td>
          </tr>		  
          <tr>
            <td align="left" class="text6">Phone:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="phone" value="<?=$_POST['phone']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Fax:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="fax" value="<?=$_POST['fax']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">URL:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="url" value="<?=$_POST['url']?>"></td>
          </tr>
          <tbody id="tbody_driveSystems"<?=($_POST['user_type']!=$LICENSEE_UTID?' style="display: none;"':'')?>>
          <tr><td colspan="2"><img src="images/transparent.gif" height="10" width="1" alt="" border="0"></td></tr>
          <tr>
            <td colspan="2" align="left" class="text6"><b>Primary Contact</b></td>
          </tr>
          <tr>
            <td align="left" class="text6">Name:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="pri_name" value="<?=$_POST['pri_name']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Title:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="pri_title" value="<?=$_POST['pri_title']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Email:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="pri_email" value="<?=$_POST['pri_email']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Phone:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="pri_phone" value="<?=$_POST['pri_phone']?>"></td>
          </tr>
          <tr><td colspan="2"><img src="images/transparent.gif" height="10" width="1" alt="" border="0"></td></tr>
          <tr>
            <td colspan="2" align="left" class="text6"><b>Secondary Contact</b></td>
          </tr>
          <tr>
            <td align="left" class="text6">Name:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="sec_name" value="<?=$_POST['sec_name']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Title:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="sec_title" value="<?=$_POST['sec_title']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Email:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="sec_email" value="<?=$_POST['sec_email']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Phone:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="sec_phone" value="<?=$_POST['sec_phone']?>"></td>
          </tr>          
          <tr><td colspan="2"><img src="images/transparent.gif" height="10" width="1" alt="" border="0"></td></tr>
          <tr>
            <td align="left" class="text6" valign="top">Drive Systems:</td>
            <td align="left" class="text6">
              <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                <tr>
                  <td class="text6">
              <?
                $systems = search_pages(array("is_product"=>1));                
                for($i=0;$i<count($systems);$i++) {
              ?>
                    <input type="checkbox" name="driveSystems[]" value="<?=$systems[$i]['id']?>"<?=(in_array($systems[$i]['id'], $_POST['driveSystems'])?" checked":"")?>> <?=$systems[$i]['product_name']?><br>
              <?
                }
              ?>
              </table></td>
          </tr>
          </tbody>
          <?/*
          <tr>
            <td align="left" class="text6">Billing Country:</td>
            <td align="left" class="text6"><select name="bill_country" class="formfield3">
              <option value=""></option>
<? foreach ($COUNTRIES as $tid=>$tval) { ?>
              <option value="<?=$tid?>"<?=($_POST['bill_country']==$tid?" selected":"")?>><?=$tval?></option>
<? } ?>
            </select></td>          
          </tr>          
          <tr>
            <td align="left" class="text6">Shipping Address 1:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="ship_address1" value="<?=$_POST['ship_address1']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Shipping Address 2:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="ship_address2" value="<?=$_POST['ship_address2']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Shipping City:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="ship_city" value="<?=$_POST['ship_city']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Shipping State:</td>
            <td align="left" class="text6"><select name="ship_state" class="formfield3">
              <option value=""></option>
<? foreach (($_POST['ship_country']=="CA"?$CANADA_PROVINCES:($_POST['ship_country']=="IE"?$IRISH_STATES:$STATES)) as $tid=>$tval) { ?>
              <option value="<?=$tid?>"<?=($_POST['ship_state']==$tid?" selected":"")?>><?=$tval?></option>
<? } ?>
            </select></td>
          </tr>
          <tr>
            <td align="left" class="text6">Shipping Zip:</td>
            <td align="left" class="text6"><input type="text" class="formfield3" name="ship_zip" value="<?=$_POST['ship_zip']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text6">Shipping Country:</td>
            <td align="left" class="text6"><select name="ship_country" class="formfield3">
              <option value=""></option>
<? foreach ($COUNTRIES as $tid=>$tval) { ?>
              <option value="<?=$tid?>"<?=($_POST['ship_country']==$tid?" selected":"")?>><?=$tval?></option>
<? } ?>
            </select></td>          
          </tr>  
          */?>
          <tr>
            <td colspan="2" align="center" class="text6">
              <br><input type="submit" name="submitit" value="<?=($add?'Add':'Edit')?> User" class="formbutton1"></td>
          </tr>
        </table>
        </form>
<?
$downloads = get_headstandard_downloads($id);
if (count($downloads)) {
?>
        <br>
        <center><table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
          <tr>
            <td colspan="2" align="center" class="text6">Licensee Resource Downloads</td>
          </tr>
          <tr>
            <td colspan="2"><img src="images/transparent.gif" height="4" width="1" alt="" border="0"></td>
          </tr>
          <tr>
            <td colspan="2">
              <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                <tr>
                  <td class="text6"><b>Description</b></td>
                  <td class="text6"><b>File name</b></td>
                  <td class="text6" align="center"><b>Downloaded on</b></td>
                </tr>
<? foreach ($downloads as $row) { ?>
                <tr>
                  <td class="text6"><?=$row['description']?>&nbsp;&nbsp;</td>
                  <td class="text6"><?=end(explode("/", $row['file']))?>&nbsp;&nbsp;</td>
                  <td class="text6" align="center"><?=date("m/d/Y", strtotime($row['time']))?></td>
                </tr>
<? } ?>
              </table>
            </td>
          </tr>
        </table></center>
<?
}
?>          
        </td>
  </tr>
</table>
<? eval_mixed($footer); ?>

