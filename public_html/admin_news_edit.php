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
  $required = array("title", "date", "summary");

  if (!filled_out($_POST, $required)) {
    $go = false;
    $message = "Please fill in all required fields.";
  }

  if (is_array($_FILES['file']) && $_FILES['file']['error']===0) {
    $ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], "."));
    if (strtolower($ext) != ".pdf") {
      $go = false;
      $message .= ($message!=""?"<br>":"")."Please only upload PDF files.";
    }
  }

  if ($go) {
    foreach (array_keys($_FILES) as $fileKey) $_POST[$fileKey] = $_FILES[$fileKey];
    if (news_save($_POST)) {
      header("Location: admin_news.php?message=".urlencode("The news article was ".($_POST['Do']=="Add"?"added":"updated")." successfully."));exit;
    } else {
      $message = "An error occurred.  Please try again.";    
    }
  }
  $edit = 1;
}

if (isset($_POST['Do']) && $_POST['Do']=="Edit") {
  $edit = 1;

	$news_articles = search_news(array('id'=>$id));
  $_POST = $news_articles['results'][0];
  $_POST['date'] = date("m/d/Y", strtotime($_POST['date']));  
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
  <tr><td align="center" class="text2"><b>News Articles</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text10">
        <form method="post" action="admin_news_edit.php" name="News" enctype="multipart/form-data">
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
            <td align="left" class="text10" valign="top">Date: *</td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" rel="date" name="date" value="<?=$_POST['date']?>"></td>
          </tr>
          <tr>
            <td align="left" class="text10" valign="top">PDF:</td>
            <td align="left" class="text1" valign="top"><?=($_POST['pdf']!=""?'<a target="_blank" href="'.$upload_url.$_POST['pdf'].'">'.end(explode("/", $_POST['pdf']))."</a><br>":"")?><input type="file" class="formfield4" name="file"></td>
          </tr>
          <tr>
            <td align="left" class="text10" valign="top">Summary: *</td>
            <td align="left" class="text10" valign="top"><textarea id="summary" name="summary"><?=$_POST['summary']?></textarea></td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="text10">
              <br><input type="submit" name="submitit" value="<?=($add?'Add':'Edit')?> News Article" class="formbutton1"></td>
          </tr>
        </table>
        </form></td>
  </tr>
</table>
<script language="JavaScript" type="text/javascript">
window.onload = function() {
  var editor = CKEDITOR.replace('summary', {customConfig: "../ckeditor_config_news.js"});
  CKFinder.setupCKEditor( editor, '/ckfinder/' );
};
</script>
<? eval_mixed($footer); ?>

