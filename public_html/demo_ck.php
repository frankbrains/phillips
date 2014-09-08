<?php
include("functions/include.php");
session_start();
check_session($_SESSION);

$message = ($_POST['message']!=""?$_POST['message']:$_GET['message']);

if (isset($_POST['Do'])) {
  if ($_POST['Do']=="ChangePage") {
    $page = get_page($_POST['page'], $_POST['revision']);
  } elseif ($_POST['Do']=="Add") { 
    if (trim($_POST['newfilename']) == "") { $message = "You must enter a name for the new file."; }
    else {
      if (!create_site_file($_POST['newfilename'])) { $message = "Sorry, unable to create the new site file."; }
      elseif (!insert_cms_page($_POST)) {$message = "Sorry, failed to insert {$_POST['newfilename']} into the CMS database."; }
      else {
        $_POST['page'] = $_POST['newfilename']; $page = $_POST['newfilename'];
        $message = "The {$page} page has been created.";
        header("Location: ".$_SERVER['PHP_SELF']."?message=$message"); exit;
      }
    }
  } elseif ($_POST['Do']=="Update") {
    if (update_cms_page($_POST)) {
      $message = "The page was updated successfully.";
      header("Location: admin_cms.php?message=".urlencode($message));
      exit;
    } else {
      $message = "There was an error updating the page.";
      $page = $_POST;
    }
  } elseif ($_POST['Do']=="Delete") {
      if (delete_cms_page($_POST)) {
        $message = "The page was deleted successfully.";
        header("Location: admin_cms.php?message=".urlencode($message));
        exit;
      } else {
        $message = "There was an error deleting the page.";
        $page = $_POST;
      }
  }
}

$archived_pages = get_cms_archives($_POST);
list($header,$footer) = get_backend_pieces();
?>

<?eval_mixed($header);?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function change_page(resetsubcat) {
<? if (count($archived_pages) > 0) { ?>
  if (resetsubcat == 1) { document.CMS.revision.selectedIndex = -1; }
<? } ?>
  document.CMS.Do.value = "ChangePage";
  document.CMS.submit();
}
function verifydelete() {
  if (confirm('Are you sure you want to delete this page and all revisions of it.  This cannot be undone.')) {
    document.CMS.Do.value = "Delete";
    document.CMS.submit();
  } else {
    return false;
  }
}

function verifysubmit() {
  if (confirm('Changes will be made live on the site immediately.  Are you sure you want to continue?')) {
    if (document.CMS.page[document.CMS.page.selectedIndex].value == "_ADDNEW_") { document.CMS.Do.value = "Add"; }
    else { document.CMS.Do.value = "Update"; }    
    document.CMS.submit();
  }
}

function page_preview() {
  var p = document.Preview;
  var c = document.CMS;

  p.template.value = c.template[c.template.selectedIndex].value;
  p.pagetitle.value = c.pagetitle.value;
  p.description.value = c.description.value;
  p.keywords.value = c.keywords.value;
  p.body.value = CKEDITOR.instances.body.getData();
  
  if (testIsValidObject(c.aerospace_enable)) {
    p.aerospace_enable.value = (c.aerospace_enable.checked?1:0);
    p.aerospace_apps.value = CKEDITOR.instances.aerospace_apps.getData();
  }
  
  if (testIsValidObject(c.automotive_enable)) {
    p.automotive_enable.value = (c.automotive_enable.checked?1:0);
    p.automotive_apps.value = CKEDITOR.instances.automotive_apps.getData();
  }
  
  if (testIsValidObject(c.diytrade_enable)) {
    p.diytrade_enable.value = (c.diytrade_enable.checked?1:0);
    p.diytrade_apps.value = CKEDITOR.instances.diytrade_apps.getData();
  }
  
  if (testIsValidObject(c.electronics_enable)) {
    p.electronics_enable.value = (c.electronics_enable.checked?1:0);
    p.electronics_apps.value = CKEDITOR.instances.electronics_apps.getData();
  }
  
  if (testIsValidObject(c.industrial_enable)) {
    p.industrial_enable.value = (c.industrial_enable.checked?1:0);
    p.industrial_apps.value = CKEDITOR.instances.industrial_apps.getData();
  }
  
  if (testIsValidObject(c.marine_enable)) {
    p.marine_enable.value = (c.marine_enable.checked?1:0);
    p.marine_apps.value = CKEDITOR.instances.marine_apps.getData();
  }
  
  if (testIsValidObject(c.military_enable)) {
    p.military_enable.value = (c.military_enable.checked?1:0);
    p.military_apps.value = CKEDITOR.instances.military_apps.getData();
  }
  
  p.submit();
}


function testIsValidObject(objToTest) {
  if (null == objToTest) {
    return false;
  }
  if ("undefined" == typeof(objToTest) ) {
    return false;
  }
  return true;

}

$().ready(function() {
  $("#aerospace_enable").click(function() {
    if ($("#aerospace_enable").is(":checked")) { $("#tbody_aerospace").show(); }
    else $("#tbody_aerospace").hide();
  });
  $("#automotive_enable").click(function() {
    if ($("#automotive_enable").is(":checked")) { $("#tbody_automotive").show(); }
    else $("#tbody_automotive").hide();
  });
  $("#diytrade_enable").click(function() {
    if ($("#diytrade_enable").is(":checked")) { $("#tbody_diytrade").show(); }
    else $("#tbody_diytrade").hide();  
  });
  $("#electronics_enable").click(function() {
    if ($("#electronics_enable").is(":checked")) { $("#tbody_electronics").show(); }
    else $("#tbody_electronics").hide();
  });
  $("#industrial_enable").click(function() {
    if ($("#industrial_enable").is(":checked")) { $("#tbody_industrial").show(); }
    else $("#tbody_industrial").hide();
  });
  $("#marine_enable").click(function() {
    if ($("#marine_enable").is(":checked")) { $("#tbody_marine").show(); }
    else $("#tbody_marine").hide();
  });
  $("#military_enable").click(function() {
    if ($("#military_enable").is(":checked")) { $("#tbody_military").show(); }
    else $("#tbody_military").hide();
  });
});
-->
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr>
    <td class="text3"><b>CMS</b></td>
  </tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td>
      <form method="post" action="admin_cms.php" class="form1" name="CMS">
      <input type="hidden" name="Do">
      <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse">
<? if ($message!="") { ?>
        <tr>
          <td colspan="2" class="text6"><font color="#ff0000"><?=$message?></font></td>
        </tr>
<? } ?>
        <tr>
          <td class="text6" width="110"><b>File Name: *</b></td>
	        <td align="left">
            
            
	    <select name="page" class="formfield3" onchange="change_page(1)">      
      <option value=""></option>
<option value='_ADDNEW_'<?=($_POST['page']=="_ADDNEW_"?' selected':'')?>>-- Add a New Page --</option>
<?
  foreach(get_pages() as $p) {
    if (!$p['editable']) continue;
?>
<option value="<?=$p['id']?>"<?=($_POST['page']==$p['id']?" selected":"")?>><?=$p['filename']?></option>
<? } ?>
            </select>
<? if (count($archived_pages) > 0) { ?>
&nbsp;&nbsp;<select class="formfield3" name=revision onChange="change_page(0);">
<option value=''>-- current version --</option>
<? foreach ($archived_pages as $p) { ?>
<option value='<?=$p['timestamp']?>'<?=($p['timestamp']==$_POST['revision']?" selected":"")?>><?=date("M j, Y g:i:sa", strtotime($p['timestamp']))?></option>
<? } ?></select>
<? } ?>   </td>
        </tr>        
<? if ($_POST['page']!="") { ?>        
<?
if ((!defined($page)&&!isset($_POST['page'])) || $_POST['page'] == "_ADDNEW_" ) {
?>

 
        <tr>
          <td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td>
        </tr>
        <tr>
          <td class="text6"><b>New File Name: *</b></td>
          <td>
            <input class="formfield3" type="text" name="newfilename" value="<?=$_POST['newfilename']?>"></td>
        </tr>
<?
}
?>  
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tr>
          <td class="text6"><b>Template:</b></td>
          <td>
            <select name="template">
            <option value=""></option>
            <? foreach ($CMS_TEMPLATES as $tid=>$tval) { ?>
            <option value="<?=$tid?>"<?=($page['template']==$tid?" selected":"")?>><?=$tval?></option>
            <? } ?>
            </select></td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>        
        <tr>
          <td class="text6"><b>Page Title:</b></td>
          <td>
            <input type="text" name="pagetitle" value="<?=$page['pagetitle']?>" class="formfield3"></td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tr>
          <td class="text6"><b>Description:</b></td>
          <td>
            <input type="text" name="description" value="<?=$page['description']?>" class="formfield3"></td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tr>
          <td class="text6"><b>Keywords:</b></td>
          <td>
            <input type="text" name="keywords" value="<?=$page['keywords']?>" class="formfield3"></td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tr>
          <td class="text6" valign="top"><b>Body Content:</b></td>
          <td><textarea id="body" name="body"><?=$page['body']?></textarea></td>
        </tr>
<? if ($page['is_product']) { ?>        
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tr>
          <td class="text6"></td>
          <td class="text6"><input type="checkbox" name="aerospace_enable" id="aerospace_enable" value="1"<?=($page['aerospace_enable']=="1"?" checked":"")?>> Enable Aerospace Applications</td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tbody id="tbody_aerospace"<?=($page['aerospace_enable']=="1"?'':' style="display: none;"')?>>
        <tr>
          <td class="text6"></td>
          <td class="text6"><textarea id="aerospace_apps" name="aerospace_apps"><?=$page['aerospace_apps']?></textarea></td>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        </tbody>
        <tr>
          <td class="text6"></td>
          <td class="text6"><input type="checkbox" name="automotive_enable" id="automotive_enable" value="1"<?=($page['automotive_enable']=="1"?" checked":"")?>> Enable Automotive Applications</td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tbody id="tbody_automotive"<?=($page['automotive_enable']=="1"?'':' style="display: none;"')?>>
        <tr>
          <td class="text6"></td>
          <td class="text6"><textarea id="automotive_apps" name="automotive_apps"><?=$page['automotive_apps']?></textarea></td>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        </tbody>
        <tr>
          <td class="text6"></td>
          <td class="text6"><input type="checkbox" name="diytrade_enable" id="diytrade_enable" value="1"<?=($page['diytrade_enable']=="1"?" checked":"")?>> Enable DIY &amp; Trade Applications</td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tbody id="tbody_diytrade"<?=($page['diytrade_enable']=="1"?'':' style="display: none;"')?>>
        <tr>
          <td class="text6"></td>
          <td class="text6"><textarea id="diytrade_apps" name="diytrade_apps"><?=$page['diytrade_apps']?></textarea></td>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        </tbody>        
        <tr>
          <td class="text6"></td>
          <td class="text6"><input type="checkbox" name="electronics_enable" id="electronics_enable" value="1"<?=($page['electronics_enable']=="1"?" checked":"")?>> Enable Electronics Applications</td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tbody id="tbody_electronics"<?=($page['electronics_enable']=="1"?'':' style="display: none;"')?>>
        <tr>
          <td class="text6"></td>
          <td class="text6"><textarea id="electronics_apps" name="electronics_apps"><?=$page['electronics_apps']?></textarea></td>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        </tbody>
        <tr>
          <td class="text6"></td>
          <td class="text6"><input type="checkbox" name="industrial_enable" id="industrial_enable" value="1"<?=($page['industrial_enable']=="1"?" checked":"")?>> Enable Industrial Applications</td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tbody id="tbody_industrial"<?=($page['industrial_enable']=="1"?'':' style="display: none;"')?>>
        <tr>
          <td class="text6"></td>
          <td class="text6"><textarea id="industrial_apps" name="industrial_apps"><?=$page['industrial_apps']?></textarea></td>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        </tbody>        
        <tr>
          <td class="text6"></td>
          <td class="text6"><input type="checkbox" name="marine_enable" id="marine_enable" value="1"<?=($page['marine_enable']=="1"?" checked":"")?>> Enable Marine Applications</td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        <tbody id="tbody_marine"<?=($page['marine_enable']=="1"?'':' style="display: none;"')?>>
        <tr>
          <td class="text6"></td>
          <td class="text6"><textarea id="marine_apps" name="marine_apps"><?=$page['marine_apps']?></textarea></td>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        </tbody>        
        <tr>
          <td class="text6"></td>
          <td class="text6"><input type="checkbox" name="military_enable" id="military_enable" value="1"<?=($page['military_enable']=="1"?" checked":"")?>> Enable Military Applications</td>
        </tr>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>        
        <tbody id="tbody_military"<?=($page['military_enable']=="1"?'':' style="display: none;"')?>>
        <tr>
          <td class="text6"></td>
          <td class="text6"><textarea id="military_apps" name="military_apps"><?=$page['military_apps']?></textarea></td>
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="2" border="0" alt=""></td></tr>
        </tbody>

<? } ?>        
        <tr><td><img src="images/transparent.gif" width="1" height="10" border="0" alt=""></td></tr>
        <tr>
          <td colspan="2" align="center">
          <input type="button" value="Submit Changes" class="formbutton1" onclick="return verifysubmit()">&nbsp;&nbsp;
          <input type="button" value="Delete this Page" class="formbutton1" onclick="return verifydelete()">&nbsp;&nbsp;
          <input type="button" value="Preview Changes" class="formbutton1" onclick="page_preview()"></td>
        </tr>
        <tr><td><img src="images/transparent.gif" width="1" height="50" border="0" alt=""></td></tr>
<? } ?>        
      </table>
      </form>
    </td>
  </tr>
</table>
<form method="post" action="template.php" target="_blank" name="Preview">
<input type="hidden" name="preview" value="1">
<input type="hidden" name="template">
<input type="hidden" name="pagetitle">
<input type="hidden" name="description">
<input type="hidden" name="keywords">
<input type="hidden" name="body">
<input type="hidden" name="aerospace_enable">
<input type="hidden" name="aerospace_apps">
<input type="hidden" name="automotive_enable">
<input type="hidden" name="automotive_apps">
<input type="hidden" name="diytrade_enable">
<input type="hidden" name="diytrade_apps">
<input type="hidden" name="electronics_enable">
<input type="hidden" name="electronics_apps">
<input type="hidden" name="industrial_enable">
<input type="hidden" name="industrial_apps">
<input type="hidden" name="marine_enable">
<input type="hidden" name="marine_apps">
<input type="hidden" name="military_enable">
<input type="hidden" name="military_apps">
</form>

<script>
  
	CKEDITOR.replace( 'editor11');
</script>


<? if ($_POST['page']!="") { ?>        
<!--<script language="JavaScript" type="text/javascript">
window.onload = function() {
  var editor = CKEDITOR.replace('body', {customConfig: "../ckeditor_config.js"});
  CKFinder.setupCKEditor( editor, '/ckfinder/' );
<? if ($page['is_product']) { ?>  
  var aerospace_editor = CKEDITOR.replace('aerospace_apps', {customConfig: "../ckeditor_config_applications.js"});
  CKFinder.setupCKEditor( aerospace_editor, '/ckfinder/' );
  var automotive_editor = CKEDITOR.replace('automotive_apps', {customConfig: "../ckeditor_config_applications.js"});
  CKFinder.setupCKEditor( automotive_editor, '/ckfinder/' );
  var diytrade_editor = CKEDITOR.replace('diytrade_apps', {customConfig: "../ckeditor_config_applications.js"});
  CKFinder.setupCKEditor( diytrade_editor, '/ckfinder/' );
  var electronics_editor = CKEDITOR.replace('electronics_apps', {customConfig: "../ckeditor_config_applications.js"});
  CKFinder.setupCKEditor( electronics_editor, '/ckfinder/' );
  var industrial_editor = CKEDITOR.replace('industrial_apps', {customConfig: "../ckeditor_config_applications.js"});
  CKFinder.setupCKEditor( industrial_editor, '/ckfinder/' );
  var marine_editor = CKEDITOR.replace('marine_apps', {customConfig: "../ckeditor_config_applications.js"});
  CKFinder.setupCKEditor( marine_editor, '/ckfinder/' );
  var military_editor = CKEDITOR.replace('military_apps', {customConfig: "../ckeditor_config_applications.js"});
  CKFinder.setupCKEditor( military_editor, '/ckfinder/' ); 
<? } ?>
};
</script>-->
<? } ?>  
<?eval_mixed($footer);?>