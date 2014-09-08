<?
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Administrative Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style_backend.css" rel="stylesheet" type="text/css">
<link href="style-ui.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="functions.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-1.4.4.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-ui-1.8.11.custom.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.validate.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.cookie.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.tabSlideOut-1.3.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.simpletip-1.3.1.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.form.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.functions.js"></script>
<script language="JavaScript" type="text/javascript" src="sortable.inc.js"></script>
</head>

<body>

<div align="center">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
    <tr>
      <td width="350" align="right" height="100" bgcolor="#ffffff" valign="bottom"><a href="<?=$domain?>"><a href="http://www.phillips-screw.com"><img border="0" src="images/backend_logo.png" width="269" height="96" alt=""></a></td>
      <td width="850" align="right" valign="middle" class="text6" bgcolor="#ffffff">
      <a href="admin_cms.php">CMS</a>&nbsp;|&nbsp;      
      <a href="admin_documents.php">Document Library</a>&nbsp;|&nbsp;
      <a href="admin_news.php">News</a>&nbsp;|&nbsp;      
      <a href="admin_events.php">Events</a>&nbsp;|&nbsp;
      <a href="admin_terms.php">Terminology</a>&nbsp;|&nbsp;
      <a href="admin_users.php">Registered Users</a>&nbsp;|&nbsp;
      <a href="login.php?<?=($_SESSION['admin_override']?"back_to_admin":"l")?>=1"><?=($_SESSION['admin_override']?"Back to Admin":"Logout")?></a>
      &nbsp;&nbsp;&nbsp;&nbsp;
      </td>
    </tr>
    <tr>
      <td colspan="2" class="text2" bgcolor="#FFFFFF" width="1200"><br>
#$#BODY#$#
      <br>
      <br>
      <br>
      <br>
      <br></td>
    </tr>
    <tr>
      <td colspan="2"><img src="images/transparent.gif" width="1" height="65" border="0" alt=""></td>
    </tr>
    </table>
  </center>
</div>

</body>

</html>
