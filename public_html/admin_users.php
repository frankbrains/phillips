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
  if (delete_user($_POST['id'])) {
    $message = "User was deleted successfully.";
  } else {
    $message = "An error occurred.  Please try again.";
  }
  unset($_POST);
} elseif (isset($_POST['Do']) && $_POST['Do']=="Login") {
  $new_user = get_user($_POST['id']);
  $_SESSION['admin_override'] = $_SESSION['user_id'];
  $_SESSION['user_id'] = $_POST['id'];  
  //if ($new_user['user_type']==$SCHOOLADMIN_UTID) { header("Location: admin_events.php"); }
  //else { header("Location: admin_users.php"); }
  exit;
} elseif (isset($_POST['Do']) && $_POST['Do']=="Export") {
   $results = get_users($_POST);
  if (!$fp = fopen("/tmp/tmp.csv", "w")) { $message = "There was an error opening temporary file for CSV output."; }
  else {
    $go = true;
    $csv_head = array("USER TYPE", "USER STATUS", "FIRST NAME", "LAST NAME", "EMAIL ADDRESS", "COMPANY", "PHONE", "FAX", "URL", "BILLING ADDRESS 1", "BILLING ADDRESS 2",
    "BILLING CITY", "BILLING STATE", "BILLING ZIP", "BILLING COUNTRY", "SHIPPING ADDRESS 1", "SHIPPING ADDRESS 2",
    "SHIPPING CITY", "SHIPPING STATE", "SHIPPING ZIP", "SHIPPING COUNTRY", "PRIMARY NAME", "PRIMARY TITLE", "PRIMARY EMAIL", "PRIMARY PHONE", "SECONDARY NAME", "SECONDARY TITLE", "SECONDARY EMAIL", "SECONDARY PHONE", "DATE CREATED");
    fputcsv($fp, $csv_head);
    unset($csv_head);

    $count = 0;
    foreach ($results as $row) {     
      ++$count;

      $csv_row = array($user_types[$row['user_type']], $user_status[$row['user_status']], $row['fname'], $row['lname'], $row['email'], $row['company'], $row['phone'], $row['fax'], $row['url'], $row['bill_address1'], $row['bill_address2'], $row['bill_city'], $row['bill_state'], $row['bill_zip'], $row['bill_country'], $row['ship_address1'], $row['ship_address2'], $row['ship_city'], $row['ship_state'], $row['ship_zip'], $row['ship_country'], $row['pri_name'], $row['pri_title'], $row['pri_email'], $row['pri_phone'], $row['sec_name'], $row['sec_title'], $row['sec_email'], $row['sec_phone'], date("m/d/Y", strtotime($row['date_created'])));
      if (!fputcsv($fp, $csv_row)) { $message = "There was an error converting database values to CSV format."; $go2=false; }
    }
    if (!$count) { $message = "No subscribers found."; $go = false; }
    fclose($fp);
    if ($go) {
      header("Content-type: text/csv");
      header("Content-disposition: attachment; filename=\"export.csv\"");
      readfile("/tmp/tmp.csv");
      unlink("/tmp/tmp.csv");
      exit;      
    }
  }    
} 


list($header,$footer) = get_backend_pieces();
?>

<?eval_mixed($header);?>
<script language="JavaScript" type="text/javascript">
<!--
function export_users() {
  document.Users.Do.value = "Export";
  document.Users.submit();
}
function delete_user(val) {
  if (confirm("Are you sure you want to delete this user?")) {
    document.Users.Do.value = "Delete";
    document.Users.id.value = val;
    document.Users.submit();
  }
}
function edit_user(val) {
  document.Edit.user_id.value = val;
  document.Edit.submit();
}
function order_user(val) {
  document.Orders.id.value = val;
  document.Orders.submit();
}
function login_as_user(id) {
  document.Users.Do.value = "Login";
  document.Users.id.value = id;
  document.Users.submit();
}
-->
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr><td align="center" class="text3"><b>Registered Users</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text9" width="805">
      <a href="admin_user_edit.php">Add a new user</a><br><br>
      <form method="post" action="admin_users.php" name="Users" class="form">
      <input type="hidden" name="Do" value="Search">
      <input type="hidden" name="id" value="">
<? if ($message!="") { ?>
      <font color="#ff0000"><?=$message?></font><br>
<? } ?>
      <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="10" border="0" alt=""></td></tr>
        <tr>
          <td class="text6">Keyword:&nbsp;</td>
          <td class="text6"><input type="text" name="keyword" class="formfield3" value="<?=$_POST['keyword']?>"></td>
        </tr>
        <tr><td colspan='2'><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>        
        <tr>
          <td class="text6">User Type:&nbsp;</td>
          <td class="text6"><select name="user_type" class="formfield3">
          <option value=""></option>
<? foreach ($user_types as $tid=>$tval) { ?>
          <option value="<?=$tid?>"<?=($_POST['user_type']==$tid?" selected":"")?>><?=$tval?></option>
<? } ?>
          </select></td>
        </tr>
        <tr><td colspan='2'><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <input class="formbutton1" type="submit" name="submit1" value="Search">
            <input class="formbutton1" type="button" onclick="export_users()" name="submit2" value="Export Users">
          </td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
  <tr><td><img src="images/transparent.gif" width="1" height="30" border="0" alt=""></td></tr>
  <tr>
    <td class="text9">
<?
  $users = get_users($_POST);
  if (!count($users)) {
?>
    <span style="color: #ff0000;">Sorry, no matching users were found.</span><br><br><br><br>
<?
  } else {
?>
      <table class="striped" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
        <thead>
        <tr>
          <td class="text6">&nbsp;</td>
          <td class="text6"><b>Name</b></td>
          <td class="text6" width="10">&nbsp;</td>
          <td class="text6"><b>User type</b></td>
          <td class="text6" width="10">&nbsp;</td>
          <td class="text6"><b>Company</b></td>
          <td class="text6" width="10">&nbsp;</td>
          <td class="text6"><b>Email address</b></td>
          <td class="text6" width="10">&nbsp;</td>          
          <td class="text6"><b>Date created</b></td>
          <td class="text6" width="10">&nbsp;</td>                    
          <td class="text6">&nbsp;</td>
        </tr>
        </thead>
        <tbody>
<?
  $count = 0;
  foreach ($users as $u) {
    //$orders = get_user_orders($u['user_id']);
    ++$count;
?>
        <tr class="noStripe">
          <td colspan="10">
            <img src="images/transparent.gif" height="5" width="1" alt="" border="0"></td>
        </tr>
        <tr>
          <td valign="top" class="text6"><?=$count?>.&nbsp;</td>
          <td valign="top" class="text9"><?=$u['fname']?>&nbsp;<?=$u['lname']?></td>
          <td class="text6" width="10">&nbsp;</td>
          <td valign="top" class="text9"><?=$user_types[$u['user_type']]?></td>
          <td class="text6" width="10">&nbsp;</td>
          <td valign="top" class="text9"><?=$u['company']?></td>
          <td class="text6" width="10">&nbsp;</td>
          <td valign="top" class="text9"><a href="mailto:<?=$u['email']?>"><?=$u['email']?></a></td>
          <td class="text6" width="10">&nbsp;</td>
          <td valign="top" class="text9"><?=date("m/d/Y", strtotime($u['date_created']))?></td>
          <td class="text6" width="10">&nbsp;</td>          
          <td valign="top" align="left" class="text9"><a class="gray" href="javascript:edit_user(<?=$u['user_id']?>);">Edit</a>&nbsp;|&nbsp;<?/*=(count($orders)?'<a class="gray" href="javascript:order_user('.$u["user_id"].');">Orders</a>&nbsp;|&nbsp;':'')*/?><a class="gray" href="javascript:delete_user(<?=$u['user_id']?>);">Delete</a><!--&nbsp;|&nbsp;<a class="gray" href="javascript:login_as_user(<?=$u['user_id']?>);">Login as user</a>--></td>
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
<form method="post" action="admin_user_edit.php" name="Edit">
<input type="hidden" name="Do" value="Edit">
<input type="hidden" name="user_id">
</form>
<form method="post" action="admin_orderhistory.php" name="Orders">
<input type="hidden" name="id">
</form>
<? eval_mixed($footer); ?>

