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
  if (delete_event($_POST['id'])) {
    $message = "The event was deleted successfully.";
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
  $(".editEvent").click(function() {
    $("#inputEditId").val($(this).attr("rel"));
    $("#frmEdit").submit();
  });

  $(".deleteEvent").click(function() {
    if (confirm("Are you sure you want to delete this event?")) {
      $("#inputEventsId").val($(this).attr("rel"));
      $("#inputEventsDo").val("Delete");
      $("#frmEvents").submit();
    }
  });
  
  $(".updateSearch").change(function() {
    $("#frmEvents").submit();
  });
});
-->
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr><td align="center" class="text3"><b>Events</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text9" width="805">
      <a href="admin_event_edit.php">Add a new event</a><br><br>
      <form method="post" action="admin_events.php" name="Events" class="form" id="frmEvents">
      <input type="hidden" name="Do" id="inputEventsDo" value="Search">
      <input type="hidden" name="id" id="inputEventsId" value="">
<? if ($message!="") { ?>
      <font color="#ff0000"><?=$message?></font><br>
<? } ?>
<!--
      <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="10" border="0" alt=""></td></tr>
        <tr>
          <td class="text6">Product:&nbsp;</td>
          <td class="text6"><select class="formfield3 updateSearch" name="page_id">
          <option value=""></option>
          <? foreach(get_products() as $row) { ?>
          <option value="<?=$row['id']?>"<?=($_POST['page_id']==$row['id']?' selected':'')?>><?=$row['product_name']?></option>
          <? } ?>
          </select></td>
        </tr>
        <tr><td colspan='2'><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>        
      </table>
-->      
      </form>
    </td>
  </tr>
  <tr><td><img src="images/transparent.gif" width="1" height="30" border="0" alt=""></td></tr>
  <tr>
    <td class="text9">
<?
  $results = search_events($_POST);
  $events = $results['results'];
  if (!count($events)) {
?>
    <span style="color: #ff0000;">Sorry, no matching events were found.</span><br><br><br><br>
<?
  } else {
?>
      <table class="striped sortable" border="0" cellspacing="0" cellpadding="2" style="border-collapse: collapse;">
        <thead>
        <tr>
          <th align="left" class="text6 sort-alpha"><b>Title</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6 sort-alpha"><b>Location</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6 sort-date"><b>Start Date</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6 sort-date"><b>End Date</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6 sort-alpha"><b>URL</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6">&nbsp;</td>
        </tr>
        </thead>
        <tbody>
<?
  $count = 0;
  foreach ($events as $row) {
    ++$count;
?>
        <tr>
          <td valign="top" align="left" class="text6"><?=$row['title']?></td>
          <td valign="top" align="left" class="text6" width="15">&nbsp;</td>
          <td valign="top" align="left" class="text6"><?=$row['location']?></td>
          <td valign="top" align="left" class="text6" width="15">&nbsp;</td>
          <td valign="top" align="left" class="text6"><?=date("m/d/Y", strtotime($row['start_date']))?></td>
          <td valign="top" align="left" class="text6" width="15">&nbsp;</td>
          <td valign="top" align="left" class="text6"><?=date("m/d/Y", strtotime($row['end_date']))?></td>
          <td valign="top" align="left" class="text6" width="15">&nbsp;</td>
          <td valign="top" align="left" class="text6"><?=$row['url']?></td>
          <td valign="top" align="left" class="text6" width="15">&nbsp;</td>
          <td valign="top" align="left" class="text6"><a class="gray editEvent" href="javascript:;" rel="<?=$row['id']?>">Edit</a>&nbsp;|&nbsp;<a class="gray deleteEvent" href="javascript:;" rel="<?=$row['id']?>">Delete</a></td>
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
<form method="post" action="admin_event_edit.php" name="Edit" id="frmEdit">
<input type="hidden" name="Do" value="Edit">
<input type="hidden" name="id" id="inputEditId">
</form>
<? eval_mixed($footer); ?>

