<?
include("functions/include.php");
if (!session_id()) session_start();

$user = array();
if ($_SESSION['authenticated']&&$_SESSION['user_id']) $user = get_user($_SESSION['user_id']);

$page = end(explode("/", $_SERVER['SCRIPT_NAME']));
$uri = end(explode("/", $_SERVER['REQUEST_URI']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<head>
<title><?=$pieces['pagetitle']?></title>
<meta name="description" content="<?=$pieces['description']?>">
<meta name="keywords" content="<?=$pieces['keywords']?>">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="functions.js"></script>
<script language="JavaScript" type="text/javascript" src="milonic_src.js"></script>	
<script language="JavaScript" type="text/javascript" src="mmenudom.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-1.4.4.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery-ui-1.8.11.custom.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.validate.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.cookie.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.form.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.tabSlideOut-1.3.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.simpletip-1.3.1.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.functions.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.colorbox.js"></script>
<script language="JavaScript" type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
function cbox_close() {
  $.colorbox.close();
}

$().ready(function() {
  //Examples of Global Changes 
  $.fn.colorbox.settings.bgOpacity = "0.8"; 
  $.fn.colorbox.settings.transition = "fade"; 
  
  //Examples of how to assign the ColorBox event to elements.
  $("a[rel='popup']").colorbox({iframe: "true", height:308, width:483, scrolling:false});
  $("a[rel='popup2']").colorbox({iframe: "true", height:547, width:392, scrolling:false});
  $("a[rel='popupTimeline']").colorbox({iframe: "true", height:660, width:800, scrolling:false});

  $('.rollChangeDiv').mouseover(function() {
    var type = $(this).attr('rel');
    $('#wrapDivs > div').each(function() {
      $(this).hide();
    });    
    $("#div"+type).show();
  });
  
  $(".clkOpenWizard").click(function() {
    $("#wizard1").hide();
    $("#wizard2").show();
    $.cookie("openWizard", 1);
  });  
  $(".clkCloseWizard").click(function() {
    $("#wizard2").hide();
    $("#wizard1").show();
    $.cookie("openWizard", 0);
  });  

  $(".wizardChange").change(function() {
    $("#frmWizard").submit();
  });
});
-->
</script>
</head>

<body onLoad="MM_preloadImages('images/mn_about1.jpg','images/mn_about2.jpg','images/mn_drivesystems1.jpg','images/mn_drivesystems2.jpg','images/mn_global_quality1.jpg','images/mn_global_quality2.jpg','images/mn_resource_library1.jpg','images/mn_resource_library2.jpg','images/mn_wrentham1.jpg','images/mn_wrentham2.jpg');<?=$TEMPLATE['onload']?>">
<script language="JavaScript" type="text/javascript" src="menu_data.js"></script>
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
<div id="wrapper">
<? if ($page=="resource_library.php"||$page=="licensee_downloads.php"||$page=="my_account.php"||$page=="terminology.php"||$page=="copyright.php") { ?>
<div id="chest">
<? if ($page=="resource_library.php"||$page=="terminology.php"||$page=="copyright.php") { ?>
<?   foreach ($DOCUMENT_CATEGORIES["R"] as $cid=>$cdata) { ?>
<span class="text26" style="padding-left: 27px;"><a href="resource_library.php?cat=<?=$cid?>"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="resource_library.php?cat=".$cid?"<b>":"")?><?=$cdata['name']?><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="resource_library.php?cat=".$cid?"</b>":"")?></a></span><br>
<?   } ?>
<span class="text26" style="padding-left: 27px;"><a href="terminology.php"><?=($page=="terminology.php"?"<b>":"")?>Definition of Terms<?=($page=="terminology.php"?"</b>":"")?></a></span><br>
<span class="text26" style="padding-left: 27px;"><a href="copyright.php"><?=($page=="copyright.php"?"<b>":"")?>Copyright/Trademarks<?=($page=="copyright.php"?"</b>":"")?></a></span><br>
<? } ?>
<?
  if ($page=="licensee_downloads.php"||$page=="my_account.php") {
    foreach ($DOCUMENT_CATEGORIES["L"] as $cid=>$cdata) {
      echo '<span class="text26" style="padding-left: 27px;"><a href="licensee_downloads.php?cat='.$cid.'">'.(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?cat=".$cid?"<b>":"").$cdata['name'].(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?cat=".$cid?"</b>":"").'</a></span><br>';
      if ($cid=="1") {
?>      
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=29"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=29"?"<b>":"")?>&raquo;&raquo; ACR Phillips<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=29"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=31"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=31"?"<b>":"")?>&raquo;&raquo; ACR Torq-Set<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=31"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=25"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=25"?"<b>":"")?>&raquo;&raquo; HexStix<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=25"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=30"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=30"?"<b>":"")?>&raquo;&raquo; Mortorq<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=30"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=24"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=24"?"<b>":"")?>&raquo;&raquo; Mortorq Super<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=24"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=28"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=28"?"<b>":"")?>&raquo;&raquo; Phillips II<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=28"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=23"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=23"?"<b>":"")?>&raquo;&raquo; Phillips Square-Driv<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=23"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=22"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=22"?"<b>":"")?>&raquo;&raquo; PoziDriv<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=22"?"</b>":"")?></a></span><br>
      <?/*<span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=21"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=21"?"<b>":"")?>&raquo;&raquo; PoziLock<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=21"?"</b>":"")?></a></span><br>*/?>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=20"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=20"?"<b>":"")?>&raquo;&raquo; PoziSquare Driv<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=20"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=27"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=27"?"<b>":"")?>&raquo;&raquo; Torq-Set<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=27"?"</b>":"")?></a></span><br>
      <span class="text26" style="padding-left: 35px;"><a href="licensee_downloads.php?id=26"><?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=26"?"<b>":"")?>&raquo;&raquo; Tri-Wing<?=(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?id=26"?"</b>":"")?></a></span><br>
<?
      } else {
        foreach ($DOCUMENT_CATEGORIES["L"][$cid]['categories'] as $sid=>$sdata) {
          echo '<span class="text26" style="padding-left: 35px;'.(end(explode("/", $_SERVER['REQUEST_URI']))=="licensee_downloads.php?cat=".$cid."&subcat=".$sid?"font-weight: bold;":"").'"><a href="licensee_downloads.php?cat='.$cid.'&subcat='.$sid.'">&raquo;&raquo; '.$sdata['name'].'</a></span><br>';
        }
      }
      echo '<br>';
    }
  }
?>
<? if ($page=="my_account.php") $page="licensee_downloads.php"; ?>
<?=($page=="licensee_downloads.php"||$page=="my_account.php"?'<span class="text26" style="padding-left: 27px;'.(end(explode("/", $_SERVER['REQUEST_URI']))=="my_account.php"?"font-weight: bold;":"").'"><a href="my_account.php">Edit Licensee Profile</a></span><br>':'')?>
<? if ( ($page=="resource_library.php" && ($cat=="2"||$id))  ) { ?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
  <tr>
    <td width="291" height="581" align="left" valign="top" class="bg_library_chest">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
      <tr>
        <td width="291" height="54" colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td width="27" rowspan="12">&nbsp;</td>
        <td width="4" rowspan="7"><img src="images/transparent.gif" border="0" width="4" height="1" alt=""></td>
        <td width="207" height="30" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_phillips_square_driv','','images/chest_phillips_square_driv2.jpg',1)" href="<?=$page?>?id=23">
        <img id="chest_phillips_square_driv" border="0" src="images/chest_phillips_square_driv<?=($uri==$page."?id=23"?'2':'1')?>.jpg" width="207" height="24" alt=""></a></td>
        <td width="6" rowspan="7"><img src="images/transparent.gif" border="0" width="6" height="1" alt=""></td>
        <td width="47" rowspan="12">&nbsp;</td>
      </tr>
      <tr>
        <td width="207" height="30" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_phillips_ii','','images/chest_phillips_ii2.jpg',1)" href="<?=$page?>?id=28">
        <img id="chest_phillips_ii" border="0" src="images/chest_phillips_ii<?=($uri==$page."?id=28"?'2':'1')?>.jpg" width="207" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="207" height="30" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_hexstix','','images/chest_hexstix2.jpg',1)" href="<?=$page?>?id=25">
        <img id="chest_hexstix" border="0" src="images/chest_hexstix<?=($uri==$page."?id=25"?'2':'1')?>.jpg" width="207" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="207" height="30" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_mortorq_super','','images/chest_mortorq_super2.jpg',1)" href="<?=$page?>?id=24">
        <img id="chest_mortorq_super" border="0" src="images/chest_mortorq_super<?=($uri==$page."?id=24"?'2':'1')?>.jpg" width="207" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="207" height="30" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_pozisquare_driv','','images/chest_pozisquare_driv2.jpg',1)" href="<?=$page?>?id=20">
        <img id="chest_pozisquare_driv" border="0" src="images/chest_pozisquare_driv<?=($uri==$page."?id=20"?'2':'1')?>.jpg" width="207" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="207" height="75" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_pozidriv','','images/chest_pozidriv2.jpg',1)" href="<?=$page?>?id=22">
        <img id="chest_pozidriv" border="0" src="images/chest_pozidriv<?=($uri==$page."?id=22"?'2':'1')?>.jpg" width="207" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="207" height="31" valign="top"><?/*<a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_pozilock','','images/chest_pozilock2.jpg',1)" href="<?=$page?>?id=21">
        <img id="chest_pozilock" border="0" src="images/chest_pozilock<?=($uri==$page."?id=21"?'2':'1')?>.jpg" width="207" height="24" alt=""></a>*/?></td>
      </tr>
      <tr>
        <td width="217" height="31" colspan="3" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_mortorq','','images/chest_mortorq2.jpg',1)" href="<?=$page?>?id=30">
        <img id="chest_mortorq" border="0" src="images/chest_mortorq<?=($uri==$page."?id=30"?'2':'1')?>.jpg" width="217" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="217" height="30" colspan="3" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_acr_torq-set','','images/chest_acr_torq-set2.jpg',1)" href="<?=$page?>?id=31">
        <img id="chest_acr_torq-set" border="0" src="images/chest_acr_torq-set<?=($uri==$page."?id=31"?'2':'1')?>.jpg" width="217" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="217" height="30" colspan="3" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_acr_phillips','','images/chest_acr_phillips2.jpg',1)" href="<?=$page?>?id=29">
        <img id="chest_acr_phillips" border="0" src="images/chest_acr_phillips<?=($uri==$page."?id=29"?'2':'1')?>.jpg" width="217" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="217" height="30" colspan="3" valign="top"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_torq_set','','images/chest_torq_set2.jpg',1)" href="<?=$page?>?id=27">
        <img id="chest_torq_set" border="0" src="images/chest_torq_set<?=($uri==$page."?id=27"?'2':'1')?>.jpg" width="217" height="24" alt=""></a></td>
      </tr>
      <tr>
        <td width="217" height="25" colspan="3"><a onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('chest_tri_wing','','images/chest_tri_wing2.jpg',1)" href="<?=$page?>?id=26">
        <img id="chest_tri_wing" border="0" src="images/chest_tri_wing<?=($uri==$page."?id=26"?'2':'1')?>.jpg" width="217" height="24" alt=""></a></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<? } ?>
</div>
<? } elseif ($page!="news.php"&&$page!="news_release.php"&&$page!="events.php") { ?>
<div id="wizard1"<?=($_COOKIE['openWizard']=="1"?' style="display: none;"':'')?>>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
  <tr>
    <td width="246" height="144" class="wizard_bg2" valign="top">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="30" rowspan="2">&nbsp;</td>
          <td width="216" height="61">&nbsp;</td>
        </tr>
        <tr>
          <td width="216" align="left" valign="top" class="text18">Learn which Phillips Drive<br>
          System can best address your<br>
          fastening challenges. <span class="text19"><a href="javascript:;" class="blue clkOpenWizard">OPEN</a></span></td>
        </tr>
        </table>
    </td>
  </tr>
</table>
</div>
<div id="wizard2"<?=($_COOKIE['openWizard']=="1"?'':' style="display: none;"')?>>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
  <tr>
    <td width="246" height="437" class="wizard_bg1" valign="top">
      <form method="POST" action="wizard.php" id="frmWizard" class="form1">
      <input type="hidden" name="Do" value="Submit">
	  <input type="hidden" name="v" value="<?=(isset($_POST['v'])?$_POST['v']:$_GET['v'])?>">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="25" rowspan="4">&nbsp;</td>
          <td width="221">
            <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
              <tr>
                <td width="5" rowspan="3">&nbsp;</td>
                <td height="61">&nbsp;</td>
              </tr>
              <tr>
                <td width="216" align="left" height="39" valign="top" colspan="2">
                <select size="1" name="industry" class="formfield2 wizardChange">
                <option value="">Select your industry:</option>
                <? foreach (get_industries() as $industry) { ?>
                <option value="<?=$industry['id']?>"<?=((isset($_POST['industry'])?$_POST['industry']:$pieces['wizardIndustry'])==$industry['id']?' selected':'')?>><?=$industry['name']?></option>
                <? } ?>
                </select></td>
              </tr>
              <tr>
                <td width="216" class="text17" colspan="2" align="left" height="38" valign="top">My most critical needs<br>
                or challenges are:</td>
              </tr>              
            </table></td>
        </tr>
        <tr>
          <td width="221">
            <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
              <tr>
                <td width="18" align="left" height="25"><input type="checkbox" value="1" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(1, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="25">Reducing Cam-out</td>
              </tr>
              <tr>
                <td width="18" align="left" height="25"><input type="checkbox" value="2" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(2, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="25">Maximizing Torque</td>
              </tr>
              <tr>
                <td width="18" align="left" height="24"><input type="checkbox" value="3" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(3, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="24">Off-angle Driving</td>
              </tr>
              <tr>
                <td width="18" align="left" height="23"><input type="checkbox" value="4" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(4, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="23">Stick-fit (non-magnetic)</td>
              </tr>
              <tr>
                <td width="18" align="left" height="24"><input type="checkbox" value="5" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(5, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="24">Driver Compatibility</td>
              </tr>
              <tr>
                <td width="18" align="left" height="24"><input type="checkbox" value="6" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(6, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="24">Low Head Height</td>
              </tr>
              <tr>
                <td width="18" align="left" height="24"><input type="checkbox" value="7" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(7, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="24">Tamper Resistance</td>
              </tr>
              <tr>
                <td width="18" align="left" height="24"><input type="checkbox" value="8" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(8, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="24">Ease of Disassembly</td>
              </tr>
              <tr>
                <td width="18" align="left" height="24"><input type="checkbox" value="9" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(9, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="24">Weight Reduction</td>
              </tr>
              <tr>
                <td width="18" align="left" height="24"><input type="checkbox" value="10" name="challenge[]" class="wizardChange"<?=(is_array($_POST['challenge'])&&in_array(10, $_POST['challenge'])?' checked':'')?>></td>
                <td width="203" class="text25" align="left" height="24">Global Acceptance</td>
              </tr>              
            </table></td>
        </tr>
        <tr>
          <td height="5"><img src="images/transparent.gif" height="5" width="1" alt="" border="0"></td>
        </tr>
        <tr>
          <td align="right">
            <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
              <tr>
                <td height="30" align="left" valign="top" class="text19" width="151"><?=(count($_POST['challenge'])||$_POST['industry']!=""?'<a href="wizard.php" class="blue">RESET WIZARD</a>':'')?></td>
                <td height="30" align="right" valign="top" class="text19" style="padding-top: 1px; padding-right: 7px;"><a href="javascript:;" class="blue clkCloseWizard">CLOSE</a></td>
                <td width="18" valign="bottom"><a href="javascript:;" class="clkCloseWizard"><img src="images/transparent.gif" height="15" width="18" alt="" border="0"></a></td>
                <td width="7"><img src="images/transparent.gif" height="5" width="7" alt="" border="0"></td>
              </tr>
            </table></td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
</table>
</div>
<? } ?>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
    <tr>
      <td width="70" class="shadow_left" rowspan="9">&nbsp;</td>
      <td width="980" colspan="5" class="white1"><img border="0" src="images/transparent.gif" width="1" height="15" alt=""></td>
      <td width="70" class="shadow_right" rowspan="9">&nbsp;</td>
    </tr>
    <tr>
      <td width="20" rowspan="3" class="white1"><img border="0" src="images/transparent.gif" width="20" height="1" alt=""></td>
      <td width="53" height="19" class="white1"><a href="http://www.phillips-screw.com"><img border="0" src="images/logo_top.jpg" width="53" height="19" alt=""></a></td>
      <td width="889" height="19" colspan="2" align="right" valign="top" class="white1"><span class="text1">
        <a href="http://www.phillips-screw.com" class="footer"><?=($page=="http://www.phillips-screw.com"?'<b>':'')?>HOME</a><?=($page=="http://www.phillips-screw.com"?'</b>':'')?> |
        <a href="aviation_fasteners.php" class="footer"><?=($page=="aviation_fasteners.php"?'<b>':'')?>AEROSPACE<?=($page=="aviation_fasteners.php"?'</b>':'')?></a> | 
        <a href="automotive_fasteners.php" class="footer"><?=($page=="automotive_fasteners.php"?'<b>':'')?>AUTOMOTIVE<?=($page=="automotive_fasteners.php"?'</b>':'')?></a> |
        <a href="diy_trade.php" class="footer"><?=($page=="diy_trade.php"?'<b>':'')?>DIY AND TRADE<?=($page=="diy_trade.php"?'</b>':'')?></a> | 
        <a href="micro_fasteners.php" class="footer"><?=($page=="micro_fasteners.php"?'<b>':'')?>ELECTRONICS<?=($page=="micro_fasteners.php"?'</b>':'')?></a> | 
        <a href="industrial_fasteners.php" class="footer"><?=($page=="industrial_fasteners.php"?'<b>':'')?>INDUSTRIAL<?=($page=="industrial_fasteners.php"?'</b>':'')?></a> | 
        <a href="marine_fasteners.php" class="footer"><?=($page=="marine_fasteners.php"?'<b>':'')?>MARINE<?=($page=="marine_fasteners.php"?'</b>':'')?></a> | 
        <a href="military_fasteners.php" class="footer"><?=($page=="military_fasteners.php"?'<b>':'')?>MILITARY<?=($page=="military_fasteners.php"?'</b>':'')?></a> | 
        <a href="wrentham_tool_group.php" class="footer"><?=($page=="wrentham_tool_group.php"?'<b>':'')?>WRENTHAM TOOL GROUP<?=($page=="wrentham_tool_group.php"?'</b>':'')?></a> | 
        <a href="about_us.php" class="footer"><?=($page=="about_us.php"?'<b>':'')?>ABOUT US<?=($page=="about_us.php"?'</b>':'')?></a></span></td>
      <td width="17" rowspan="3" class="white1"><img border="0" src="images/transparent.gif" width="17" height="19" alt=""></td>
    </tr>
    <tr>
      <td width="53" height="55" class="white1" valign="top"><a href="http://www.phillips-screw.com"><img border="0" src="images/logo_left_new.jpg" width="53" height="55" alt=""></a></td>
      <td width="416" height="55" class="white1" valign="top" align="left"><a href="http://www.phillips-screw.com"><img border="0" src="images/logo_right_new.jpg" width="216" height="55" alt=""></a></td>
      <td width="473" align="right" valign="top" class="white1" rowspan="2">
      <form method="POST" action="search.php" class="form1">
      <input type="hidden" name="Do" value="Search">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="140" valign="top" align="right"><img src="images/search.jpg" border="0" width="60" height="17" alt=""></td>
          <td width="158" valign="top">
          <input type="text" name="search" class="formfield1"></td>
          <td width="27" valign="top">
          <input type="image" src="images/go.jpg" alt=""></td>
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
      <td width="469" height="29" class="white1" valign="top" colspan="2" align="left"><h1>Innovation in fastener technology</h1></td>
    </tr>
    <tr>
      <td width="980" class="blue2" colspan="5" height="26" align="left"><div id="nav1"><script language="JavaScript" type="text/javascript" src="<?=$pieces['section']?>"></script></div>
     </td>
    </tr>
    <tr>
      <td width="980" class="white1" colspan="5"><?=$pieces['body']?></td>
    </tr>
    <tr>
      <td width="980" colspan="5" class="white1"><img border="0" src="images/transparent.gif" width="1" height="12" alt=""></td>
    </tr>
    <tr>
      <td width="980" colspan="5" align="center" valign="top" height="59" class="white1">
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
      <td width="980" colspan="5" align="center" valign="top" height="20" class="white1">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
      <tr>
        <td width="471" class="text4" align="left">&#169; 2011 PHILLIPS SCREW COMPANY. <a href="http://www.phillips-screw.com" style="color: #80777e;">FASTENER TECHNOLOGY</a> | ALL RIGHTS RESERVED.</td>
        <td width="473" class="text4" align="right">One Van de Graaff Drive | Burlington, MA 01803 | +1 781-224-9750</td>
      </tr>
    </table>
      </td>
    </tr>
    <tr>
      <td width="1120" colspan="7"><img src="images/shadow_footer.png" border="0" width="1120" height="71" alt=""></td>
    </tr>
    </table>
</div>
<form class="form" method="post" id="frmBrochureDownload" action="resource_library.php" target="_blank" style="margin: 0px; padding: 0px;">
<input type="hidden" name="Do" id="inputBrochureDownloadDo">
<input type="hidden" name="id" id="inputBrochureDownloadId">
</form>
</body>
</html>