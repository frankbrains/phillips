<?
include("functions/include.php");
if (!session_id()) session_start();

$user = array();
if ($_SESSION['authenticated']&&$_SESSION['user_id']) $user = get_user($_SESSION['user_id']);

$page = end(explode("/", $_SERVER['SCRIPT_NAME']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<head>
<title><?=$pieces['pagetitle']?></title>
<meta name="description" content="<?=$pieces['description']?>">
<meta name="keywords" content="<?=$pieces['keywords']?>">
<meta name="google-site-verification" content="TjWPoCSF2f35lufqqf_j5Gqz2sNK4G94FUEzetjN37U" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="functions.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-1.4.4.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-ui-1.8.11.custom.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.validate.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.cookie.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.tabSlideOut-1.3.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.simpletip-1.3.1.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.functions.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.colorbox.js"></script>
<script type="text/javascript">
function cbox_close() {
  $.colorbox.close();
}

$(document).ready(function() {
  //Examples of Global Changes 
  $.fn.colorbox.settings.bgOpacity = "0.8"; 
  $.fn.colorbox.settings.transition = "fade"; 
  
  //Examples of how to assign the ColorBox event to elements.
  $("a[rel='popup']").colorbox({iframe:true, height:358, width:483, scrolling:false});
  $("a[rel='popup2']").colorbox({iframe:true, height:547, width:392, scrolling:false});
  $("a[rel='popupTimeline']").colorbox({iframe:true, height:660, width:800, scrolling:false});
});

$().ready(function() {
  $('.rollChangeDiv').mouseover(function() {
    var type = $(this).attr('rel');
    $('#wrapDivs > div').each(function() {
      $(this).hide();
    });    
    $("#div"+type).show();
  });
  
  $('.unChangeDivs').hover(function() {
  
  }, function() {
    $('#wrapDivs > div').each(function() {
      $(this).hide();
    });      
    $("#divDefault").show();
  });
});
-->
</script>
</head>

<body onLoad="MM_preloadImages('images/nav_aerospace1.jpg','images/nav_aerospace2.jpg','images/nav_automotive1.jpg','images/nav_automotive2.jpg','images/nav_diy1.jpg','images/nav_diy2.jpg','images/nav_electronics1.jpg','images/nav_electronics2.jpg','images/nav_industrial1.jpg','images/nav_industrial2.jpg','images/nav_marine1.jpg','images/nav_marine2.jpg','images/nav_military1.jpg','images/nav_military2.jpg','images/nav_header1.jpg','images/nav_header2.jpg');">
<div class="slide-out-div" style="display: none;">
<a class="handle" href="contact.php">Contact Us</a>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
  <tr>
    <td width="280" height="908" class="contact_bg_new4" align="left" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
      <tr>
        <td width="19" rowspan="12"><img src="images/transparent.gif" border="0" width="19" height="1" alt=""></td>
        <td width="261" height="43">&nbsp;</td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="48" class="text21">Email a Phillips market<br>
        specialist today.</td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="58" class="text20">Just click on the link to start<br>
        discussing your fastening needs.</td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="86" class="text20"><span class="text22">AEROSPACE</span><br>
        Mike Mowins (Global)<br>
        Tony Green (Europe)<br>
        <a href="mailto:aerospace@phillips-screw.com?subject=Aerospace Info Request" class="red">Aerospace@phillips-screw.com</a></td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="86" class="text20"><span class="text22">AUTOMOTIVE</span><br>
        Mike Mowins (Global)<br>
        Tony Green (Europe)<br>
        <a href="mailto:automotive@phillips-screw.com?subject=Automotive Info Request" class="red">Automotive@phillips-screw.com</a></td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="68" class="text20"><span class="text22">DIY and TRADE</span><br>
        Nick Bennison<br>
        <a href="mailto:diyandtrade@phillips-screw.com?subject=DIY and Trade Info Request" class="red">DIYandTrade@phillips-screw.com</a></td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="68" class="text20"><span class="text22">ELECTRONICS</span><br>
        Mike Mowins<br>
        <a href="mailto:electronics@phillips-screw.com?subject=Electronics Info Request" class="red">Electronics@phillips-screw.com</a></td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="86" class="text20"><span class="text22">INDUSTRIAL</span><br>
        Mike Mowins (Global)<br>
        Tony Green (Europe)<br>
        <a href="mailto:industrial@phillips-screw.com?subject=Industrial Info Request" class="red">Industrial@phillips-screw.com</a></td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="68" class="text20"><span class="text22">MARINE</span><br>
        Mike Mowins<br>
        <a href="mailto:marine@phillips-screw.com?subject=Marine Info Request" class="red">Marine@phillips-screw.com</a></td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="86" class="text20"><span class="text22">MILITARY</span><br>
        Mike Mowins<br>
        Ken Campitelli<br>
        <a href="mailto:military@phillips-screw.com?subject=Military Info Request" class="red">Military@phillips-screw.com</a></td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" height="86" class="text20"><span class="text22">HEADER TOOLS AND GAUGING</span><br>
        Wrentham Tool Group<br>
        Customer Service Center <a href="mailto:wrenthamtool@phillips-screw.com?subject=Wrentham Tool Group Info Request" class="red">WrenthamTool@phillips-screw.com</a></td>
      </tr>
      <tr>
        <td width="261" align="left" valign="top" class="text20"><span class="text22">CORPORATE</span><br>
        Ken Hurley<br>
        <a href="mailto:corporate@phillips-screw.com?subject=Phillips Screw Company Info Request" class="red">Corporate@phillips-screw.com</a></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</div>
<div align="center">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
  <tr>
    <td width="70" class="shadow_left" rowspan="13">&nbsp;</td>
    <td width="980" class="white1" colspan="7"><img border="0" src="images/transparent.gif" width="1" height="1" alt=""></td>
    <td width="70" class="shadow_right" rowspan="13">&nbsp;</td>
  </tr>
  <tr>
    <td width="1" class="white1" rowspan="11"><img border="0" src="images/transparent.gif" width="1" height="1" alt=""></td>
    <td width="978" class="white1" colspan="5"><img border="0" src="images/transparent.gif" width="1" height="15" alt=""></td>
    <td width="1" class="white1" rowspan="11"><img border="0" src="images/transparent.gif" width="1" height="1" alt=""></td>
  </tr>
  <tr>
    <td width="19" class="white1" height="19" rowspan="3"><img border="0" src="images/transparent.gif" width="19" height="19" alt=""></td>
    <td width="53" class="white1" height="19" align="left" valign="top"><a href="http://www.phillips-screw.com"><img border="0" src="images/logo_top.jpg" width="53" height="19" alt=""></a></td>
    <td width="889" class="white1" height="19" align="right" valign="top" colspan="2"><img border="0" src="images/transparent.gif" width="1" height="19" alt=""></td>
    <td width="17" class="white1" height="19" rowspan="3"><img border="0" src="images/transparent.gif" width="17" height="19" alt=""></td>
  </tr>
  <tr>
    <td width="53" class="white1" height="55" valign="top"><a href="http://www.phillips-screw.com"><img border="0" src="images/logo_left_new.jpg" width="53" height="55" alt=""></a></td>
    <td width="416" class="white1" height="55" valign="top" align="left"><a href="http://www.phillips-screw.com"><img border="0" src="images/logo_right_new.jpg" width="216" height="55" alt=""></a></td>
    <td width="473" class="white1" align="right" valign="top" rowspan="2">
    <form method="POST" action="search.php" class="form1">
    <input type="hidden" name="Do" value="Search">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="140" valign="top" align="right"><img src="images/search.jpg" border="0" width="60" height="17" alt=""></td>
          <td width="158" valign="top">
          <input type="text" name="search" class="formfield1"></td>
          <td width="27" valign="top"><input type="image" src="images/go.jpg" alt=""></td>
        </tr>
        <tr>
          <td width="325" colspan="3" align="right" height="60" valign="bottom" class="text2">
          <? if ($user['user_type']==$LICENSEE_UTID) { ?>
          &gt;&gt; <a href="licensee_downloads.php" class="login"><span style="color: #ff0000;">Return to Licensee Resources</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <? } ?>
          &gt;&gt; <a href="login.php<?=($_SESSION['authenticated']?'?l=1':'')?>" class="login"><?=($_SESSION['authenticated']?'Log Out':'Licensee Log In')?></a></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
  <tr>
    <td width="469" class="white1" align="left" height="22" valign="top" colspan="2"><h1>Innovation in fastener technology</h1></td>
  </tr>
  <tr>
    <td width="978" class="white1" colspan="5" height="21">&nbsp;</td>
  </tr>
  <tr>
    <td width="978" class="white1" colspan="5" align="center">
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
                <tr>
                  <td width="943" height="376" class="black1 unChangeDivs">
                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
            <tr>
              <td width="943" colspan="3"><img border="0" src="images/transparent.gif" width="1" height="18" alt=""></td>
            </tr>
            <tr>
              <td width="11" rowspan="8"><img border="0" src="images/transparent.gif" width="11" height="1" alt=""></td>
              <td width="237" align="left" valign="top" height="43"><a class="rollChangeDiv" rel="aerospace" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nav_aerospace','','images/nav_aerospace2.jpg',1)" href="aviation_fasteners.php">
        <img id="nav_aerospace" border="0" src="images/nav_aerospace1.jpg" width="229" height="43" alt=""></a></td>
              <td width="695" align="left" valign="top" rowspan="8" height="340">
              <div id="wrapDivs">
              <div id="divDefault">
<a href="about_us.php"><img src="images/main_default.jpg" border="0" width="677" height="340" alt=""></a>
</div>
<div id="divaerospace" style="display: none;">
<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('main_aerospace','','images/main_aerospace2.jpg',1)" href="aviation_fasteners.php">
        <img id="main_aerospace" border="0" src="images/main_aerospace1.jpg" width="677" height="340" alt=""></a>
</div>
<div id="divautomotive" style="display: none;">
<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('main_automotive','','images/main_automotive2.jpg',1)" href="automotive_fasteners.php">
        <img id="main_automotive" border="0" src="images/main_automotive1.jpg" width="677" height="340" alt=""></a>
</div>
<div id="divdiy" style="display: none;">
<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('main_diy_trade','','images/main_diy2.jpg',1)" href="diy_trade.php">
        <img id="main_diy_trade" border="0" src="images/main_diy1.jpg" width="677" height="340" alt=""></a>
</div>
<div id="divelectronics" style="display: none;">
<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('main_electronics','','images/main_electronics2.jpg',1)" href="micro_fasteners.php">
        <img id="main_electronics" border="0" src="images/main_electronics1.jpg" width="677" height="340" alt=""></a>
</div>
<div id="divindustrial" style="display: none;">
<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('main_industrial','','images/main_industrial2.jpg',1)" href="industrial_fasteners.php">
        <img id="main_industrial" border="0" src="images/main_industrial1.jpg" width="677" height="340" alt=""></a>
</div>
<div id="divmarine" style="display: none;">
<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('main_marine','','images/main_marine2.jpg',1)" href="marine_fasteners.php">
        <img id="main_marine" border="0" src="images/main_marine1.jpg" width="677" height="340" alt=""></a>
</div>
<div id="divmilitary" style="display: none;">
<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('main_military','','images/main_military2.jpg',1)" href="military_fasteners.php">
        <img id="main_military" border="0" src="images/main_military1.jpg" width="677" height="340" alt=""></a>
</div>
<div id="divheader" style="display: none;">
<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('main_header','','images/main_header2.jpg',1)" href="wrentham_tool_group.php">
        <img id="main_header" border="0" src="images/main_header1.jpg" width="677" height="340" alt=""></a>
</div></div></td>
            </tr>
            <tr>
              <td width="237" align="left" valign="top" height="38"><a class="rollChangeDiv" rel="automotive" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nav_automotive','','images/nav_automotive2.jpg',1)" href="automotive_fasteners.php">
        <img id="nav_automotive" border="0" src="images/nav_automotive1.jpg" width="229" height="38" alt=""></a></td>
            </tr>
            <tr>
              <td width="237" align="left" valign="top" height="38"><a class="rollChangeDiv" rel="diy" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nav_diy','','images/nav_diy2.jpg',1)" href="diy_trade.php">
        <img id="nav_diy" border="0" src="images/nav_diy1.jpg" width="229" height="38" alt=""></a></td>
            </tr>
            <tr>
              <td width="237" align="left" valign="top" height="38"><a class="rollChangeDiv" rel="electronics" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nav_electronics','','images/nav_electronics2.jpg',1)" href="micro_fasteners.php">
        <img id="nav_electronics" border="0" src="images/nav_electronics1.jpg" width="229" height="38" alt=""></a></td>
            </tr>
            <tr>
              <td width="237" align="left" valign="top" height="38"><a class="rollChangeDiv" rel="industrial" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nav_industrial','','images/nav_industrial2.jpg',1)" href="industrial_fasteners.php">
        <img id="nav_industrial" border="0" src="images/nav_industrial1.jpg" width="229" height="38" alt=""></a></td>
            </tr>
            <tr>
              <td width="237" align="left" valign="top" height="39"><a class="rollChangeDiv" rel="marine" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nav_marine','','images/nav_marine2.jpg',1)" href="marine_fasteners.php">
        <img id="nav_marine" border="0" src="images/nav_marine1.jpg" width="229" height="39" alt=""></a></td>
            </tr>
            <tr>
              <td width="237" align="left" valign="top" height="37"><a class="rollChangeDiv" rel="military" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nav_military','','images/nav_military2.jpg',1)" href="military_fasteners.php">
        <img id="nav_military" border="0" src="images/nav_military1.jpg" width="229" height="37" alt=""></a></td>
            </tr>
            <tr>
              <td width="237" align="left" valign="top" height="87"><a class="rollChangeDiv" rel="header" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('nav_header','','images/nav_header2.jpg',1)" href="wrentham_tool_group.php">
        <img id="nav_header" border="0" src="images/nav_header1.jpg" width="229" height="64" alt=""></a></td>
            </tr>
          </table>
</td>
                </tr>
              </table>
    </td>
  </tr>
  <tr>
    <td width="978" class="white1" colspan="5" height="48">&nbsp;</td>
  </tr>
  <tr>
    <td width="978" class="white1" colspan="5" align="center">
<?=$pieces['body']?>
    </td>
  </tr>
  <tr>
    <td width="978" class="white1" colspan="5" height="99">&nbsp;</td>
  </tr>
  <tr>
    <td width="978" class="white1" colspan="5" align="center" height="59" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
      <tr>
        <td width="943" class="text3" align="left">Phillips Screw Company is a leader in the <i>design</i> and <i>engineering</i> of proprietary fastener technology, including high-performance drive systems for fastening applications<br>
        in <b><a href="aviation_fasteners.php" class="footer">Aerospace</a></b>, <b><a href="automotive_fasteners.php" class="footer">Automotive</a></b>, <b><a href="diy_trade.php" class="footer">DIY and Trade</a></b>, <b><a href="micro_fasteners.php" class="footer">Electronics</a></b>, <b><a href="industrial_fasteners.php" class="footer">Industrial</a></b>, <b><a href="marine_fasteners.php" class="footer">Marine</a></b>, <b><a href="military_fasteners.php" class="footer">Military</a></b> and <a href="wrentham_tool_group.php" class="footer"><b>Header Tools and Gauging</b></a> markets. The <i>manufacturing</i> of products that incorporate<br>
        genuine Phillips Drive System technology are made to our precise specifications by our global network of licensed manufacturers, including <b><a href="wrentham_tool_group.php" class="footer">Wrentham Tool Group</a></b>.</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="978" class="white1" colspan="5" align="center" height="19" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
      <tr>
        <td width="471" class="text4" align="left">&#169; 2011 PHILLIPS SCREW COMPANY. <a href="http://www.phillips-screw.com" style="color: #80777e;">FASTENER TECHNOLOGY</a> | ALL RIGHTS RESERVED.</td>
        <td width="473" class="text4" align="right">One Van de Graaff Drive | Burlington, MA 01803 | +1 781-224-9750</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="980" class="white1" colspan="7"><img border="0" src="images/transparent.gif" width="1" height="1" alt=""></td>
  </tr>
  <tr>
    <td width="1120" colspan="9"><img src="images/shadow_footer.png" border="0" width="1120" height="71" alt=""></td>
  </tr>
</table>
<form class="form" method="post" id="frmBrochureDownload" action="resource_library.php" target="_blank" style="margin: 0px; padding: 0px;">
<input type="hidden" name="Do" id="inputBrochureDownloadDo">
<input type="hidden" name="id" id="inputBrochureDownloadId">
</form>
</div>
</body>
</html>