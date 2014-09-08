<?
include("functions/include.php");
session_start();

$thanks = false;
$fid = (isset($_POST['id'])?$_POST['id']:$_GET['fid']);

if (isset($_POST['Do']) && $_POST['Do']=="Submit") {
  $go = true;

  $required = array("agree");
  if (!filled_out($_POST, $required)) {
    $go = false;
    $message = "Please fill in all fields.";
  }
  
  if ($go) {
    if (headstandard_log_download(array("user_id"=>$_SESSION['user_id'], "id"=>$_POST['id']))) {
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
  filedl(<?=$fid?>);
  cancellink();
}

function cancellink() { $.colorbox.close(); }
</script>
<div id="divForm">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
  <tr>
    <td width="392" height="547" align="left" valign="top" class="reg_bg">
    <form method="POST" action="register2.php" class="form1" id="frmRegister">
    <input type="hidden" name="Do" value="Submit">
    <input type="hidden" name="id" value="<?=$_GET['fid']?>">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="49" rowspan="5">&nbsp;</td>
          <td width="343" align="right" height="40" valign="top" colspan="2"><a href="javascript:;" onclick="cancellink()"><img src="images/transparent.gif" border="0" width="29" height="29" alt=""></a></td>
        </tr>
        <tr>
          <td width="343" class="text1" align="left" height="39" valign="top" colspan="2"><a href="javascript:;" onclick="cancellink()">CLOSE WINDOW</a></td>
        </tr>
        <tr>
          <td width="343" class="text29" colspan="2" align="left" height="27" valign="top">NOTICE:</td>
        </tr>
        <tr>
          <td width="343" class="text30" colspan="2" align="left" height="230" valign="top">
          This manual and its contents are the CONFIDENTIAL<br>
          property of the Phillips Screw Company and it may<br>
          not be copied, disseminated, or distributed in<br>
          print or electronic form without the express<br>
          written permission of the Phillips Screw Company.<br>
          All rights to the Patents, Trademarks, and<br>
          Technical Information contained herein are the<br>
          express property of the Phillips Screw Company.<br>
          <br>
          <input type="checkbox" name="agree" value="Y">  Please check this box indicating that you have<br>
          read and acknowledge this notice.</td>
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
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="49" rowspan="5">&nbsp;</td>
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
          Thank you for your accepting the license terms.<br>
          Your download will start momentarily.</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>