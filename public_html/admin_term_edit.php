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
  $required = array("term", "definition");

  if (!filled_out($_POST, $required)) {
    $go = false;
    $message = "Please fill in all required fields.";
  }

  if ($go) {
    foreach (array_keys($_FILES) as $fileKey) $_POST[$fileKey] = $_FILES[$fileKey];
    if (terminology_save($_POST)) {
      header("Location: admin_terms.php?message=".urlencode("The term was ".($_POST['Do']=="Add"?"added":"updated")." successfully."));exit;
    } else {
      $message = "An error occurred.  Please try again.";    
    }
  }
  $edit = 1;
}

if (isset($_POST['Do']) && $_POST['Do']=="Edit") {
  $edit = 1;

	$terms = search_terminology(array('id'=>$id));
  $_POST = $terms['results'][0];
}

list($header,$footer) = get_backend_pieces();
?>

<?eval_mixed($header);?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script language="JavaScript" type="text/javascript">
$().ready(function() {
});
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr><td align="center" class="text2"><b>Terminology</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text10">
        <form method="post" action="admin_term_edit.php" name="Term" enctype="multipart/form-data">
        <input type="hidden" name="Do" value="<?=($edit?"Update":"Add")?>">
        <?=($edit?'<input type="hidden" name="id" value="'.$id.'">':'')?>
        Required fields are marked with an asterisk *<br><br>
<? if ($message!="") { ?>
      <font color="#ff0000"><?=$message?><br><br>
<? } ?>

        <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td align="left" class="text10" valign="top">Wizard Term: *</td>
            <td align="left" class="text10" valign="top"><input type="checkbox" name="wizard" value="1"<?=($_POST['wizard']==1?" checked":"")?>></td>
          </tr>
          <tr>
            <td align="left" class="text10" valign="top">Term: *</td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" name="term" value="<?=$_POST['term']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text10" valign="top">Definition: *</td>
            <td align="left" class="text10" valign="top"><textarea class="formfield5" id="definition" name="definition"><?=$_POST['definition']?></textarea></td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="text10">
              <br><input type="submit" name="submitit" value="<?=($add?'Add':'Edit')?> Term" class="formbutton1"></td>
          </tr>
        </table>
        </form></td>
  </tr>
</table>
<? eval_mixed($footer); ?>

