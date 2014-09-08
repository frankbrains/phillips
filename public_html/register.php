<?
include("functions/include.php");

$thanks = false;
$id = (isset($_POST['id'])?$_POST['id']:$_GET['id']);

if (isset($_POST['Do']) && $_POST['Do']=="Submit") {
  $go = true;

  $required = array("fname", "lname", "company", "email");
  if (!filled_out($_POST, $required)) {
    $go = false;
    $message = "Please fill in all fields.";
  }
  
  if ($_POST['email']!="" && !valid_email($_POST['email'])) {
    $go = false;
    $message .= ($message!=""?"<br>":"")."Invalid email address.";
  }
  
  if ($go) {
    $user = get_users(array("email"=>$_POST['email']));
    if (!count($user)) {
      if (add_user(array("user_type"=>$RESOURCE_LIBRARY_UTID, "fname"=>$_POST['fname'], "lname"=>$_POST['lname'], "email"=>$_POST['email'], "company"=>$_POST['company']))) {
        setcookie("rlreg", 1, time()+31536000);
        echo "1";
        exit;
      } else {
        $message = "An error occurred.";
      }
    } else {
      setcookie("rlreg", 1, time()+31536000);
      echo "1";
      exit;
    }
  }
  
  echo $message;
  exit;  
}
?>
<script type="text/javascript">
$().ready(function() {
  $("#frmRegister").ajaxForm({
    success: showResponse
  });
});

function showResponse(responseText, statusText, xhr, $form)  { 
  if (responseText=="1") {
    $("#divForm").hide();
    $("#divThanks").show();
    setTimeout("submitdl()", 2000);
  } else {    
    alert(responseText);
  }
}

function submitdl() {
  filedl(<?=$id?>);
  cancellink();
}

function cancellink() { $.colorbox.close(); }
</script>
<div id="divForm">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
  <tr>
    <td width="392" height="547" align="left" valign="top" class="reg_bg">
    <form method="POST" action="register.php" class="form1" id="frmRegister">
    <input type="hidden" name="Do" value="Submit">
    <input type="hidden" name="id" value="<?=$id?>">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="49" rowspan="9">&nbsp;</td>
          <td width="343" align="right" height="40" valign="top" colspan="2"><a href="javascript:;" onclick="cancellink()"><img src="images/transparent.gif" border="0" width="29" height="29" alt=""></a></td>
        </tr>
        <tr>
          <td width="343" class="text1" align="left" height="39" valign="top" colspan="2"><a href="javascript:;" onclick="cancellink()">CLOSE WINDOW</a></td>
        </tr>
        <tr>
          <td width="343" class="text29" colspan="2" align="left" height="27" valign="top">We respect your privacy.</td>
        </tr>
        <tr>
          <td width="343" class="text30" colspan="2" align="left" height="154" valign="top">
          Phillips Screw Company is pleased to make<br>
          these proprietary materials available to the<br>
          engineering community.<br>
          <br>
          Be assured that the information requested<br>
          below is for the exclusive use of Phillips Screw<br>
          Company and will not be sold or shared with<br>
          any external party.</td>
        </tr>
        <tr>
          <td width="75" height="31" class="text26" align="left"><b>FIRST NAME</b></td>
          <td width="268" align="left"><input type="text" name="fname" class="formfield4" value="<?=$_POST['fname']?>"></td>
        </tr>
        <tr>
          <td width="75" height="31" class="text26" align="left"><b>LAST NAME</b></td>
          <td width="268" align="left"><input type="text" name="lname" class="formfield4" value="<?=$_POST['lname']?>"></td>
        </tr>
        <tr>
          <td width="75" height="31" class="text26" align="left"><b>COMPANY</b></td>
          <td width="268" align="left"><input type="text" name="company" class="formfield4" value="<?=$_POST['company']?>"></td>
        </tr>
        <tr>
          <td width="75" height="31" class="text26" align="left"><b>EMAIL</b></td>
          <td width="268" align="left"><input type="text" name="email" class="formfield4" value="<?=$_POST['email']?>"></td>
        </tr>
        <tr>
          <td width="75">&nbsp;</td>
          <td width="268" align="left "style="padding-left: 40px;"><input type="image" src="images/submit.png" border="0" alt=""></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
</table>    
</div>
<div id="divThanks" style="display:none;">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
  <tr>
    <td width="392" height="547" align="left" valign="top" class="reg_bg">      
      <form method="post" action="resource_library.php" id="frmDownload" style="margin: 0px; padding: 0px;">
      <input type="hidden" name="Do" value="Download">
      <input type="hidden" name="id" value="<?=$id?>">
      </form>
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="49" rowspan="9">&nbsp;</td>
          <td width="343" align="right" height="40" valign="top" colspan="2"><a href="javascript:;" onclick="cancellink()"><img src="images/transparent.gif" border="0" width="29" height="29" alt=""></a></td>
        </tr>
        <tr>
          <td width="343" class="text1" align="left" height="39" valign="top" colspan="2"><a href="javascript:;" onclick="cancellink()">CLOSE WINDOW</a></td>
        </tr>
        <tr>
          <td width="343" class="text29" colspan="2" align="left" height="27" valign="top">We respect your privacy.</td>
        </tr>
        <tr>
          <td width="343" class="text30" colspan="2" align="left" height="154" valign="top">
          Thank you for your registration.<br>
          Your download will start momentarily.</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>