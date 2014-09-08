<?
include("functions/include.php");
session_start();
$uid = check_session($_SESSION);
$user = get_user($_SESSION['user_id']);
verify_privileges($user, array($SITEADMIN_UTID));

$edit = 0;

$message= ($_GET['message']!=""?$_GET['message']:"");
$id = ($_POST['id']?$_POST['id']:$_GET['id']);

if (isset($_POST['Do']) && $_POST['Do']=="Delete") {
  if (delete_terminology($_POST['id'])) {
    $message = "The term was deleted successfully.";
  } else {
    $message = "An error occurred.  Please try again.";
  }
  unset($_POST);
}


list($header,$footer) = get_backend_pieces();
?>

<?eval_mixed($header);?>
<script language="JavaScript" type="text/javascript">
<!--
$().ready(function() {
  $(".editTerm").click(function() {
    $("#inputEditId").val($(this).attr("rel"));
    $("#frmEdit").submit();
  });

  $(".deleteTerm").click(function() {
    if (confirm("Are you sure you want to delete this term?")) {
      $("#inputTermId").val($(this).attr("rel"));
      $("#inputTermDo").val("Delete");
      $("#frmTerm").submit();
    }
  });
  
  $(".updateSearch").change(function() {
    $("#frmTerm").submit();
  });
});
-->
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr><td align="center" class="text3"><b>Terminology</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text9" width="805">
      <a href="admin_term_edit.php">Add a new term</a><br><br>
      <form method="post" action="admin_terms.php" name="Terminology" class="form" id="frmTerm">
      <input type="hidden" name="Do" id="inputTermDo" value="Search">
      <input type="hidden" name="id" id="inputTermId" value="">
<? if ($message!="") { ?>
      <font color="#ff0000"><?=$message?></font><br>
<? } ?>
      </form>
    </td>
  </tr>
  <tr><td><img src="images/transparent.gif" width="1" height="30" border="0" alt=""></td></tr>
  <tr>
    <td class="text9">
<?
  $results = search_terminology($_POST);
  $terms = $results['results'];
  if (!count($terms)) {
?>
    <span style="color: #ff0000;">Sorry, no matching terms were found.</span><br><br><br><br>
<?
  } else {
?>
      <table class="striped sortable" border="0" cellspacing="0" cellpadding="2" style="border-collapse: collapse;">
        <thead>
        <tr>
          <th align="left" class="text6 sort-alpha"><b>Term</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6 sort-alpha"><b>Wizard</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>          
          <th align="left" class="text6 sort-alpha"><b>Definition</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6">&nbsp;</td>
        </tr>
        </thead>
        <tbody>
<?
  $count = 0;
  foreach ($terms as $row) {
    ++$count;
?>
        <tr>
          <td valign="top" align="left" class="text6" valign="top"><?=$row['term']?></td>
          <td valign="top" align="left" class="text6" width="15">&nbsp;</td>
          <td valign="top" align="left" class="text6" valign="top"><?=($row['wizard']==1?"Yes":"No")?></td>
          <td valign="top" align="left" class="text6" width="15">&nbsp;</td>
          <td valign="top" align="left" width="650" class="text6" valign="top"><?=$row['definition']?></td>
          <td valign="top" align="left" class="text6" width="15">&nbsp;</td>          
          <td valign="top" align="left" class="text6" valign="top"><a class="gray editTerm" href="javascript:;" rel="<?=$row['id']?>">Edit</a>&nbsp;|&nbsp;<a class="gray deleteTerm" href="javascript:;" rel="<?=$row['id']?>">Delete</a></td>
        </tr>
<? } ?>
        </tbody>
      </table>
<?
  }
?>
    </td>
  </tr>
</table>
<form method="post" action="admin_term_edit.php" name="Edit" id="frmEdit">
<input type="hidden" name="Do" value="Edit">
<input type="hidden" name="id" id="inputEditId">
</form>
<? eval_mixed($footer); ?>

