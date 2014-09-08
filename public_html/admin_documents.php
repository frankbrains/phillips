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
  if (delete_headstandard($_POST['id'])) {
    $message = "The head standard was deleted successfully.";
  } else {
    $message = "An error occurred.  Please try again.";
  }
  unset($_POST['id']);
} elseif (isset($_POST['Do']) && $_POST['Do']=="MoveUp") {
  if (moveup_headstandard($_POST)) {
    $message = "The head standard was moved up successfully.";
  } else {
    $message = "An error occurred.  Please try again.";
  }
  unset($_POST['id']);
} elseif (isset($_POST['Do']) && $_POST['Do']=="MoveDown") {
  if (movedown_headstandard($_POST)) {
    $message = "The head standard was moved down successfully.";
  } else {
    $message = "An error occurred.  Please try again.";
  }
  unset($_POST['id']);
}


list($header,$footer) = get_backend_pieces();
?>

<?eval_mixed($header);?>
<script language="JavaScript" type="text/javascript">
<!--
$().ready(function() {
  $(".editHead").click(function() {
    $("#inputEditId").val($(this).attr("rel"));
    $("#frmEdit").submit();
  });

  $(".deleteHead").click(function() {
    if (confirm("Are you sure you want to delete this head standard?")) {
      $("#inputHeadsId").val($(this).attr("rel"));
      $("#inputHeadsDo").val("Delete");
      $("#frmHeads").submit();
    }
  });
  
  $(".moveUp").click(function() {
    $("#inputHeadsId").val($(this).attr("rel"));
    $("#inputHeadsDo").val("MoveUp");
    $("#frmHeads").submit();  
  });

  $(".moveDown").click(function() {
    $("#inputHeadsId").val($(this).attr("rel"));
    $("#inputHeadsDo").val("MoveDown");
    $("#frmHeads").submit();    
  });
  
  $(".updateSearch").change(function() {
    $("#frmHeads").submit();
  });
});
-->
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr><td align="center" class="text3"><b>Document Library</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text9" width="805">
      <a href="admin_document_edit.php">Add a new document</a><br><br>
      <form method="post" action="admin_documents.php" name="Heads" class="form" id="frmHeads">
      <input type="hidden" name="Do" id="inputHeadsDo" value="Search">
      <input type="hidden" name="id" id="inputHeadsId" value="">
<? if ($message!="") { ?>
      <font color="#ff0000"><?=$message?></font><br>
<? } ?>
      <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
        <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="10" border="0" alt=""></td></tr>
        <tr>
          <td class="text6">Type:&nbsp;</td>
          <td class="text6"><select class="formfield3 updateSearch" name="type">
          <option value=""></option>
          <? foreach($DOCUMENT_TYPES as $tid=>$tval) { ?>
          <option value="<?=$tid?>"<?=($_POST['type']==$tid?' selected':'')?>><?=$tval?></option>
          <? } ?>
          </select></td>
        </tr>
        <? if ($_POST['type']!="") { ?>
        <tr>
          <td class="text6">Category:&nbsp;</td>
          <td class="text6"><select class="formfield3 updateSearch" name="cat">
          <option value=""></option>
          <? foreach($DOCUMENT_CATEGORIES[$_POST['type']] as $tid=>$tval) { ?>
          <option value="<?=$tid?>"<?=($_POST['cat']==$tid?' selected':'')?>><?=$tval['name']?></option>
          <? } ?>
          </select></td>
        </tr>        
        <? }?>
        <? if ($_POST['type']!="" && $_POST['cat']!="" && count($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['cat']]['categories'])) { ?>
        <tr>
          <td class="text6">Subcategory:&nbsp;</td>
          <td class="text6"><select class="formfield3 updateSearch" name="subcat">
          <option value=""></option>
          <? foreach($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['cat']]['categories'] as $tid=>$tdata) { ?>
          <option value="<?=$tid?>"<?=($_POST['subcat']==$tid?' selected':'')?>><?=$tdata['name']?></option>
          <? } ?>
          </select></td>
        </tr>        
        <? }?>
        <? if ($_POST['type']!="" && $_POST['cat']!="" && count($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['cat']]['categories'][$_POST['subcat']]['categories'])) { ?>
        <tr>
          <td class="text6">Subcategory 2:&nbsp;</td>
          <td class="text6"><select class="formfield3 updateSearch" name="subcat2">
          <option value=""></option>
          <? foreach($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['cat']]['categories'][$_POST['subcat']]['categories'] as $tid=>$tdata) { ?>
          <option value="<?=$tid?>"<?=($_POST['subcat2']==$tid?' selected':'')?>><?=$tdata['name']?></option>
          <? } ?>
          </select></td>
        </tr>        
        <? }?>
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
      </form>
    </td>
  </tr>
  <tr><td><img src="images/transparent.gif" width="1" height="30" border="0" alt=""></td></tr>
  <tr>
    <td class="text9">
<?
  $enableMove = false;
  if ($_POST['type']!="") {
    if ($_POST['cat']!="") {      
      if (!count($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['cat']]['categories'])) {
        if ($_POST['type']=="R" && $_POST['cat']=="2") {
          if ($_POST['page_id']) $enableMove = true;
        } else {
          $enableMove = true;
        }
      }
      else {
        if ($_POST['subcat']!="") {        
          if (!count($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['cat']]['categories'][$_POST['subcat']]['categories'])) $enableMove = true;
          else {
            if ($_POST['subcat2']!="") $enableMove = true;
          }
        }
      }
    }
  }
  
  $data = $_POST;
  if ($enableMove) $data['sort'] = 'hso.display_order ASC';
  if ($data['cat']=="") unset($data['cat']);
  if ($data['subcat']=="") unset($data['subcat']);
  if ($data['subcat2']=="") unset($data['subcat2']);
  $results = search_headstandards($data);
  $heads = $results['results'];
  if (!count($heads)) {
?>
    <span style="color: #ff0000;">Sorry, no matching head standards were found.</span><br><br><br><br>
<?
  } else {
?>
      <table class="striped sortable" border="0" cellspacing="0" cellpadding="2" style="border-collapse: collapse;">
        <thead>
        <tr>
          <th align="left" class="text6 sort-alpha"><b>File name</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6 sort-alpha"><b>Type</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6 sort-alpha"><b>Description</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
<?/*          <th align="left" class="text6 sort-alpha"><b>Unit</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>
          <th align="left" class="text6 sort-alpha"><b>Drawing Number</b></td>
          <th align="left" class="text6" width="15">&nbsp;</td>          
*/?>          
          <th align="left" class="text6">&nbsp;</td>
        </tr>
        </thead>
        <tbody>
<?
  $count = 0;
  foreach ($heads as $h) {
    ++$count;
?>
        <tr>
          <td valign="top" align="left" class="text6" style="line-height: 20px;"><?
          if ($h['type']=="R"&&$h['category']=="3") {
            echo '<a href="'.$h['url'].'" target="_blank">YouTube video</a>';
          } else {
            echo end(explode("/", $h['file']));
          }?></td>
          <td valign="top" align="left" class="text6" width="15" style="line-height: 20px;">&nbsp;</td>
          <td valign="top" align="left" class="text6" style="line-height: 20px;"><?=$DOCUMENT_TYPES[$h['type']]?></td>
          <td valign="top" align="left" class="text6" width="15" style="line-height: 20px;">&nbsp;</td>
          <td valign="top" align="left" class="text6" style="line-height: 20px;"><?=($h['file']!=""?'<a target="_blank" href="'.$upload_url.$h['file'].'">':'').$h['description'].($h['file']!=""?'</a>':'')?></td>
          <td valign="top" align="left" class="text6" width="15" style="line-height: 20px;">&nbsp;</td>
<?/*          <td valign="top" align="left" class="text6" style="line-height: 20px;"><?=$HEAD_UNITS[$h['unit']]?></td>
          <td valign="top" align="left" class="text6" width="15" style="line-height: 20px;">&nbsp;</td>
          <td valign="top" align="left" class="text6" style="line-height: 20px;"><?=$h['drawing_number']?></td>
          <td valign="top" align="left" class="text6" width="15" style="line-height: 20px;">&nbsp;</td>
*/?>          
          <td <?=($enableMove?'width="130" ':'')?>valign="top" align="left" class="text6" style="line-height: 20px;"><a class="gray editHead" href="javascript:;" rel="<?=$h['id']?>">Edit</a>&nbsp;|&nbsp;<a class="gray deleteHead" href="javascript:;" rel="<?=$h['id']?>">Delete</a><?=($enableMove?'&nbsp;|&nbsp;'.($count>1?'<a class="gray moveUp" href="javascript:;" rel="'.$h['id'].'"><img alt="Move up" src="images/up_arrow.gif" border="0" alt=""></a>':'').($count<count($heads)?'<a class="gray moveDown" href="javascript:;" rel="'.$h['id'].'"><img alt="Move down" src="images/down_arrow.gif" alt="" border="0"></a>':''):'')?></td>
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
<form method="post" action="admin_document_edit.php" name="Edit" id="frmEdit">
<input type="hidden" name="Do" value="Edit">
<input type="hidden" name="id" id="inputEditId">
</form>
<? eval_mixed($footer); ?>