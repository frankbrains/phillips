<?
include("functions/include.php");
session_start();
$uid = check_session($_SESSION);
$login = get_user($_SESSION['user_id']);
verify_privileges($login, array($SITEADMIN_UTID));

$message= ($_GET['message']!=""?$_GET['message']:"");
$id = ($_POST['id']?$_POST['id']:$_GET['id']);
if (!$id) {
  $add = 1;
}

if (isset($_POST['Do']) && ($_POST['Do']=="Add" || $_POST['Do']=="Update") ) {
  $go = true;
  $required = array("type", "category", "description");
  if ($_POST['type']=="R") {
    if ($_POST['category']=="1") array_push($required, "language");
    if ($_POST['category']=="2") array_push($required, "unit", "drawing_number");    
    if ($_POST['category']=="3") array_push($required, "name", "url");    
  } elseif ($_POST['type']=="L") {
    if ($_POST['category']=="1") array_push($required, "language");
    if ($_POST['category']=="2") {
      if ($_POST['subcategory']=="1") array_push($required, "language");
      if ($_POST['subcategory']=="2") array_push($required, "format");
      if ($_POST['subcategory']=="3"||$_POST['subcategory']=="4") array_push($required, "language");
      if ($_POST['subcategory']=="5") array_push($required, "format");
    }
  }
  if ( ($_POST['type']=="L"&&$_POST['category']!="2") || ($_POST['type']=="R"&&$_POST['category']=="2") ) array_push($required, "page_id");
  if (count($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['category']]['categories'])) array_push($required, "subcategory");
  if (count($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['category']]['categories'][$_POST['subcategory']]['categories'])) array_push($required, "subcategory2");

  if (!filled_out($_POST, $required)) {
    $go = false;
    $message = "Please fill in all required fields.";
  }

  if ($_POST['type']!="R" || $_POST['category']!="3") {
    if ($add && $_FILES['file']['error']==4) {
      $go = false;
      $message .= ($message!=""?"<br>":"")."You must select a file to upload.";
    }
  }

/*  
  if (is_array($_FILES['file']) && $_FILES['file']['error']===0) {
    $ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], "."));
    if (strtolower($ext) != ".pdf") {
      $go = false;
      $message .= ($message!=""?"<br>":"")."Please only upload PDF files.";
    }
  }
*/

  if (is_array($_FILES['thumbnail']) && $_FILES['thumbnail']['error']===0) {
    $ext = substr($_FILES['thumbnail']['name'], strrpos($_FILES['thumbnail']['name'], "."));
    if (strtolower($ext)!=".jpg"&&strtolower($ext)!=".gif"&&strtolower($ext)!=".png") {
      $go = false;
      $message .= ($message!=""?"<br>":"")."Please only upload image files as thumbnails.";
    }
  }

  if ($go) {
    foreach (array_keys($_FILES) as $fileKey) $_POST[$fileKey] = $_FILES[$fileKey];
    if (headstandard_save($_POST)) {
      header("Location: admin_documents.php?message=".urlencode("The document was ".($_POST['Do']=="Add"?"added":"updated")." successfully."));exit;
    } else {
      $message = "An error occurred.  Please try again.";    
    }
  }

  $edit = 1;
}
if (isset($_POST['Do']) && $_POST['Do']=="Edit") {
  $edit = 1;

	$headstandards = search_headstandards(array('id'=>$id));
  $_POST = $headstandards['results'][0];
}

list($header,$footer) = get_backend_pieces();
?>

<?eval_mixed($header);?>
<script language="JavaScript" type="text/javascript">
function update_categories() {
  var ot = $("#oldType").val();
  var oc = $("#oldCat").val();
  var os = $("#oldSub").val();
  var t = $("input:radio[name=type]:checked").val();
  var c = $("#category :selected").val();
  var s = $("#subcategory :selected").val();
  var s2 = $("#subcategory2 :selected").val();
  if (t != "") {
    $.getJSON("options.php",
        {f: "documentCategories", type: t },
        function(j){        
          var options = "";
          for (var i = 0; i < j.length; i++) {
            options += "<option value=\"" + j[i].optionValue + "\"" + (j[i].optionValue==c&&ot==t?" selected=\"selected\"":"")+">" + j[i].optionDisplay + "</option>";
          }                  
          $("#category").html(options);
          $("#tbody_category").show();
      });        
  }  
  if (t != "" && c != "") {
    $.getJSON("options.php",
        {f: "documentSubcategories", type: t, category: c },
        function(j){        
          var options = "";
          for (var i = 0; i < j.length; i++) {
            options += "<option value=\"" + j[i].optionValue + "\"" + (j[i].optionValue==s&&ot==t&&oc==c?" selected=\"selected\"":"")+">" + j[i].optionDisplay + "</option>";
          }                  
          $("#subcategory").html(options);
          if (options!="") $("#tbody_subcategory").show();
          else $("#tbody_subcategory").hide();
      });
  }
  if (t != "" && c != "" && s!="") {
    $.getJSON("options.php",
        {f: "documentSubcategories2", type: t, category: c, subcategory: s },
        function(j){        
          var options = "";
          for (var i = 0; i < j.length; i++) {
            options += "<option value=\"" + j[i].optionValue + "\"" + (j[i].optionValue==s2&&ot==t&&oc==c&&os==s?" selected=\"selected\"":"")+">" + j[i].optionDisplay + "</option>";
          }                  
          $("#subcategory2").html(options);
          if (options!="") $("#tbody_subcategory2").show();
          else $("#tbody_subcategory2").hide();
      });  
  }  
  $("#oldType").val(t);
  $("#oldCat").val(c);
  $("#oldSub").val(s);
}

$().ready(function() {
  $(".chgType").change(function() {
    update_categories();
    var t = $("input:radio[name=type]:checked").val();
    var c = $("#category :selected").val();
    var s = $("#subcategory :selected").val();
    var s2 = $("#subcategory2 :selected").val();
    $("#tbody_format").hide();
    $("#tbody_language").hide();
    $("#tbody_unit").hide();
    $("#tbody_drawing_number").hide();
    $("#tbody_product").hide();
    $("#tbody_file").hide();
    $("#tbody_url").hide();
    $("#tbody_name").hide();
    if (t=="R" && c=="1") {
      $("#tbody_language").show();
      $("#tbody_file").show();
    } else if (t=="R" && c=="2") {
      $("#tbody_drawing_number").show();
      $("#tbody_product").show();    
      $("#tbody_unit").show();  
      $("#tbody_file").show();
    } else if (t=="R" && c=="3") {
      $("#tbody_file").hide();
      $("#tbody_name").show();
      $("#tbody_url").show();
    } else if (t=="L" && c=="2" && s=="1") {
      $("#tbody_language").show();
      $("#tbody_file").show();
    } else if (t=="L" && c=="2" && s=="2") {
      $("#tbody_format").show();
      $("#tbody_file").show();
    } else if (t=="L" && c=="2" && (s=="3"||s=="4")) {
      $("#tbody_language").show();
      $("#tbody_file").show();
    } else if (t=="L" && c=="2" && s=="5") {
      $("#tbody_format").show();
      $("#tbody_file").show();
    } else if (t=="L" && c=="1") {
      $("#tbody_language").show();
      $("#tbody_product").show();
      $("#tbody_file").show();
    }
  });
});
</script>
<table border="0" align="center" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr><td align="center" class="text2"><b>Document Library</b></td></tr>
  <tr><td><img src="images/transparent.gif" width="1" height="20" border="0" alt=""></td></tr>
  <tr>
    <td align="left" class="text10">
        <form method="post" action="admin_document_edit.php" name="Document" enctype="multipart/form-data">
        <input type="hidden" name="Do" value="<?=($edit?"Update":"Add")?>">
        <?=($edit?'<input type="hidden" name="id" value="'.$id.'">':'')?>
        Required fields are marked with an asterisk *<br><br>
<? if ($message!="") { ?>
      <font color="#ff0000"><?=$message?><br><br>
<? } ?>

        <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td align="left" class="text10" width="130" valign="top">Type: *</td>
            <td align="left" class="text10" valign="top">            
            <? foreach ($DOCUMENT_TYPES as $did=>$dname) { ?>
            <input type="radio" class="chgType" name="type" value="<?=$did?>"<?=($_POST['type']==$did?" checked":"")?>> <?=$dname?>&nbsp;&nbsp;
            <? } ?><input type="hidden" id="oldType" name="oldType" value="<?=$_POST['type']?>"></td>
          </tr>
          <tbody id="tbody_category"<?=($_POST['type']!=""?'':' style="display: none;"')?>>
          <tr>
            <td align="left" class="text10" width="130" valign="top">Category: *</td>
            <td align="left" class="text10" valign="top">
              <select id="category" name="category" class="formfield4 chgType">
              <option value=""></option>
<?
  foreach ($DOCUMENT_CATEGORIES[$_POST['type']] as $cid=>$cdata) { 
    if ($cdata['visibleAdmin']===false) continue;
?>
              <option value="<?=$cid?>"<?=($_POST['category']==$cid?" selected":"")?>><?=$cdata['name']?></option>
<? } ?>
              </select>
              <input type="hidden" id="oldCat" name="oldCat" value="<?=$_POST['category']?>">
            </td>
          </tr>
          </tbody>
          <tbody id="tbody_subcategory"<?=($_POST['type']!=""&&$_POST['category']!=""&&count($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['category']]['categories'])?'':' style="display: none;"')?>>
          <tr>
            <td align="left" class="text10" width="130" valign="top">Subcategory: *</td>
            <td align="left" class="text10" valign="top">
              <select id="subcategory" name="subcategory" class="formfield4 chgType">
              <option value=""></option>
<?
  foreach ($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['category']]['categories'] as $sid=>$sdata) {
    if ($sdata['visibleAdmin']===false) continue;
?>
              <option value="<?=$sid?>"<?=($_POST['subcategory']==$sid?" selected":"")?>><?=$sdata['name']?></option>
<? } ?>
              </select>
              <input type="hidden" id="oldSub" name="oldSub" value="<?=$_POST['subcategory']?>">
            </td>
          </tr>          
          </tbody>
          <tbody id="tbody_subcategory2"<?=($_POST['type']!=""&&$_POST['category']!=""&&$_POST['subcategory']!=""&&count($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['category']]['categories'][$_POST['subcategory']]['categories'])?'':' style="display: none;"')?>>
          <tr>
            <td align="left" class="text10" width="130" valign="top">Subcategory 2: *</td>
            <td align="left" class="text10" valign="top">
              <select id="subcategory2" name="subcategory2" class="formfield4 chgType">
              <option value=""></option>
<?
  foreach ($DOCUMENT_CATEGORIES[$_POST['type']][$_POST['category']]['categories'][$_POST['subcategory']]['categories'] as $sid=>$sdata) {
    if ($sdata['visibleAdmin']===false) continue;
?>
              <option value="<?=$sid?>"<?=($_POST['subcategory2']==$sid?" selected":"")?>><?=$sdata['name']?></option>
<? } ?>
              </select>
            </td>
          </tr>          
          </tbody>          
          <tbody id="tbody_product"<?=( ($_POST['type']=="L"&&$_POST['category']!="1")||($_POST['type']=="R" && $_POST['category']!="2") ?' style="display:none;"':'')?>>
          <tr>
            <td align="left" class="text10" width="130" valign="top">Product: *</td>
            <td align="left" class="text10" valign="top">
              <select name="page_id" class="formfield4">
              <option value=""></option>
<? foreach (get_products() as $row) { ?>
              <option value="<?=$row['id']?>"<?=($_POST['page_id']==$row['id']?' selected':'')?>><?=$row['product_name']?></option>
<? } ?>                
            </select></td>
          </tr>
          </tbody>
          <tbody id="tbody_name"<?=($_POST['type']=="R"&&$_POST['category']=="3"?"":' style="display: none;"')?>>
          <tr>
            <td align="left" class="text10" valign="top">Name: *</td>
            <td align="left" class="text1" valign="top"><input type="text" class="formfield4" name="name" value="<?=$_POST['name']?>"></td>
          </tr>
          </tbody>                    
          <tr>
            <td align="left" class="text10" valign="top">Description: *</td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" name="description" value="<?=$_POST['description']?>"></td>
          </tr>
          <tbody id="tbody_language"<?=( ($_POST['type']=="R"&&$_POST['category']=="1")||($_POST['type']=="L" && ($_POST['category']=="1"||($_POST['category']=="2" && ($_POST['subcategory']=="1"||$_POST['subcategory']=="3"||$_POST['subcategory']=="4"))))?'':' style="display:none;"')?>>
          <tr>
            <td align="left" class="text10" valign="top">Language: *</td>
            <td align="left" class="text10" valign="top"><select class="formfield4" name="language">
            <option value=""></option>
            <? foreach ($DOCUMENT_LANGUAGES as $y=>$z) { ?>
            <option value="<?=$y?>"<?=($_POST['language']==$y?' selected':'')?>><?=$z?></option>
            <? } ?>
            </select></td>
          </tr>
          </tbody>
          <tbody id="tbody_format"<?=($_POST['type']=="L" && $_POST['category']=="2"&& ($_POST['subcategory']=="2"||$_POST['subcategory']=="5")?'':' style="display:none;"')?>>
          <tr>
            <td align="left" class="text10" valign="top">Format: *</td>
            <td align="left" class="text10" valign="top"><select class="formfield4" name="format">
            <option value=""></option>
            <? foreach ($DOCUMENT_FORMATS as $y=>$z) { ?>
            <option value="<?=$y?>"<?=($_POST['format']==$y?' selected':'')?>><?=$z?></option>
            <? } ?>
            </select></td>
          </tr>          
          </tbody>
          <tbody id="tbody_unit"<?=($_POST['type']=="R" && $_POST['category']=="2"?'':' style="display: none;"')?>>
          <tr>
            <td align="left" class="text10" valign="top">Unit: *</td>
            <td align="left" class="text10" valign="top"><select class="formfield4" name="unit">
            <option value=""></option>
            <? foreach ($HEAD_UNITS as $y=>$z) { ?>
            <option value="<?=$y?>"<?=($_POST['unit']==$y?' selected':'')?>><?=$z?></option>
            <? } ?>
            </select></td>
          </tr>
          </tbody>
          <tbody id="tbody_drawing_number"<?=($_POST['type']=="R" && $_POST['category']=="2"?'':' style="display: none;"')?>>
          <tr>
            <td align="left" class="text10" valign="top">Drawing Number: *</td>
            <td align="left" class="text10" valign="top"><input type="text" class="formfield4" name="drawing_number" value="<?=$_POST['drawing_number']?>"></td>
          </tr>
          </tbody>
          <tbody id="tbody_url"<?=($_POST['type']=="R"&&$_POST['category']=="3"?"":' style="display: none;"')?>>
          <tr>
            <td align="left" class="text10" valign="top">URL: *</td>
            <td align="left" class="text1" valign="top"><input type="text" class="formfield4" name="url" value="<?=$_POST['url']?>"></td>
          </tr>
          </tbody>        
          <tbody id="tbody_file"<?=($_POST['type']=="R"&&$_POST['category']=="3"?' style="display: none;"':'')?>>
          <tr>
            <td align="left" class="text10" valign="top">File: *</td>
            <td align="left" class="text1" valign="top"><?=($_POST['file']!=""?'<a target="_blank" href="'.$upload_url.$_POST['file'].'">'.end(explode("/", $_POST['file']))."</a><br>":"")?><input type="file" class="formfield4" name="file"></td>
          </tr>
          </tbody>
          <tr>
            <td align="left" class="text10" valign="top">Thumbnail JPG:</td>
            <td align="left" class="text1" valign="top"><?=($_POST['thumbnail']!=""?'<a target="_blank" href="'.$upload_url.$_POST['thumbnail'].'">'.end(explode("/", $_POST['thumbnail']))."</a><br>":"")?><input type="file" class="formfield4" name="thumbnail"></td>
          </tr>
          <tr>
            <td colspan="2" align="center" class="text10">
              <br><input type="submit" name="submitit" value="<?=($add?'Submit':'Update')?>" class="formbutton1"></td>
          </tr>
        </table>
        </form></td>
  </tr>
</table>
<? eval_mixed($footer); ?>