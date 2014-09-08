<?
include("functions/include.php");
session_start();
$uid = check_session($_SESSION);
$login = get_user($_SESSION['user_id']);
verify_privileges($login, array($SITEADMIN_UTID));

$message= ($_GET['message']!=""?$_GET['message']:"");
$id = ($_POST['id']?$_POST['id']:$_GET['id']);
if (!$id) {
  $add = 1;
}

if (isset($_POST['Do']) && ($_POST['Do']=="Add" || $_POST['Do']=="Update") ) {
  $go = true;
  $required = array("title", "location", "start_date", "end_date");

  if (!filled_out($_POST, $required)) {
    $go = false;
    $message = "Please fill in all required fields.";
  }

  if (strtotime($_POST['end_date'])<strtotime($_POST['start_date'])) {
    $go = false;
    $message .= ($message!=""?"<br>":"")."Event end date cannot be earlier than start date.";
  }
  
  if ($go) {
    foreach (array_keys($_FILES) as $fileKey) $_POST[$fileKey] = $_FILES[$fileKey];
    if (event_save($_POST)) {
      header("Location: admin_events.php?message=".urlencode("The event was ".($_POST['Do']=="Add"?"added":"updated")." successfully."));exit;
    } else {
      $message = "An error occurred.  Please try again.";    
    }
  }
  $edit = 1;
}

if (isset($_POST['Do']) && $_POST['Do']=="Edit") {
  $edit = 1;

	$events = search_events(array('id'=>$id));
  $_POST = $events['results'][0];
  $_POST['start_date'] = date("m/d/Y", strtotime($_POST['start_date']));
  $_POST['end_date'] = date("m/d/Y", strtotime($_POST['end_date']));
}

list($header,$footer) = get_backend_pieces();
?>

<?eval_mixed($header);?>
<script language="JavaScript" type="text/javascript">
$().ready(function() {
});
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr><td align="center" class="text2"><b>Events</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text10">
        <form method="post" action="admin_event_edit.php" name="Events" enctype="multipart/form-data">
        <input type="hidden" name="Do" value="<?=($edit?"Update":"Add")?>">
        <?=($edit?'<input type="hidden" name="id" value="'.$id.'">':'')?>
        Required fields are marked with an asterisk *<br><br>
<? if ($message!="") { ?>
      <font color="#ff0000"><?=$message?><br><br>
<? } ?>

        <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td align="left" class="text10" valign="top">Title: *</td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" name="title" value="<?=$_POST['title']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text10" valign="top">Location: *</td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" name="location" value="<?=$_POST['location']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text10" valign="top">Start Date: *</td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" rel="date" name="start_date" value="<?=$_POST['start_date']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text10" valign="top">End Date: *</td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" rel="date" name="end_date" value="<?=$_POST['end_date']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text10" valign="top">URL: </td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" name="url" value="<?=$_POST['url']?>"></td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="text10">
              <br><input type="submit" name="submitit" value="<?=($add?'Add':'Edit')?> Event" class="formbutton1"></td>
          </tr>
        </table>
        </form></td>
  </tr>
</table>
<? eval_mixed($footer); ?>

