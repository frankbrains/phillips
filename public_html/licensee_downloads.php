<?
include("functions/include.php");
$uid = check_session($_SESSION);
$login = get_user($_SESSION['user_id']);
verify_privileges($login, array($LICENSEE_UTID));

$id = (isset($_POST['id'])?$_POST['id']:$_GET['id']);
$cat = (isset($_POST['cat'])?$_POST['cat']:$_GET['cat']);
$subcat = (isset($_POST['subcat'])?$_POST['subcat']:$_GET['subcat']);
if (!$id &&!$cat) $cat=2;

$start = (isset($_POST['start'])?$_POST['start']:0);
$rpp = 23;

if (isset($_POST['Do']) && $_POST['Do']=="Download") {
  $heads = search_headstandards(array("id"=>$_POST['id']));
  header("Location: ".$upload_url.$heads['results'][0]['file']);
  exit;
}

$total = 0;
$allow = false;
if ($id) {
  $pages = search_pages(array("id"=>$id));
  $page = $pages[0];
  if (user_access_drivesystem($_SESSION['user_id'], $id)) {
    //$results = search_headstandards(array("page_id"=>$id, "start"=>$start, "cat"=>"", "rpp"=>$rpp, "type"=>"L", "sort"=>"display_order"));
    $results = search_headstandards_licensee_techsupport(array("page_id"=>$id, "start"=>$start, "rpp"=>$rpp, "sort"=>"hso.type,hso.category,hso.subcategory,hso.subcategory2,hso.display_order"));
    $heads = $results['results'];
    $total = $results['total'];
    $allow = true;
  } else {
    $heads = array();
  }
  $title = $page['product_name']." TECHNICAL MANUALS"; 
  $intro = "Roll over each listing to activate an image of the file. When you find the material you need, simply click to launch the PDF download.";
} elseif ($cat||$subcat) {  
  if ($cat=="1") {
    $title = "TECHNICAL MANUALS";
    $intro = "The most comprehensive information available for your licensed drive systems is right here for your convenience. Each Phillips Screw Company Drive System Technical Manual is an invaluable engineering resource that includes detailed sections for Head, Driver Bit, Gage, Quality, and Punch Standards. Simply select the Technical Manual to launch the download process. It's that simple.";

    $fields = array("description", "file");
    
  } elseif ($cat=="2") {    
    $title = "WELCOME. HOW MAY WE ASSIST YOU?";
    $intro = "Since our inception, the Phillips Screw Company name has been synonymous with high-quality fasteners and drive systems around the globe. From industry and aerospace to Main Street's retail consumers, Phillips Screw Company is at the center of fastener design innovation, manufacturing excellence, and product consistency. Worldwide recognition of our brand name is indisputable and provides a powerful endorsement for our valued business partners.<br><br>Here in Phillips Screw Company's secure Licensee Resources library, you will find a wealth of detailed engineering information, as well as an abundance of marketing support materials and guidelines. Best of all, everything is here at your fingertips and ready for immediate download.<br><br>Not familiar with a specific term used in our website? Turn to our Definition of Terms glossary for an explanation.<br><br>Last, so that we may better serve you and the enigneering needs of your company, be sure to periodically update your licensee profile.  Be assured that your information is securely protected and for the use of the Phillips Screw Company exclusively.";    
    if ($subcat=="1") {
      $title = "BRAND GUIDELINES";
      $intro = "Phillips Screw Company provides a wide variety of logos to support the marketing efforts of our licensed manufacturing partners. They are available in both vector (Adobe Illustrator) and low-resolution (RGB JPEG) formats. All logo(s) must be used in accordance with our 2011 Brand Guidelines. Simply roll over each listing to activate an image of the file. Then click on the link to download the PDF.";
      $results = search_headstandards(array("cat"=>$cat, "subcat"=>$subcat, "start"=>$start, "rpp"=>$rpp, "type"=>"L", "sort"=>"type,category,subcategory,subcategory2,hso.display_order"));
      $heads = $results['results'];
      $total = $results['total'];      
      
    } elseif ($subcat=="2") {
      $title = "LOGOS";
      $intro = "Phillips Screw Company provides a wide variety of logos to support the marketing efforts of our licensed manufacturing partners. They are available in both vector (Adobe Illustrator) and low-resolutino (RGB JPEG) formats. All logo(s) must be used in accordance with our 2011 Brand Guidelines. Simply roll over each listing to activate an image of the file. Then click on the link to download the PDF.";      
      $results = search_headstandards(array("cat"=>$cat, "subcat"=>$subcat, "start"=>$start, "rpp"=>$rpp, "type"=>"L", "sort"=>"type,category,subcategory,subcategory2,hso.display_order"));
      $heads = $results['results'];
      $total = $results['total'];      
      
    } elseif ($subcat=="3") {
      $title = "BROCHURES";
      $intro = "Phillips Screw Company Overview Brochures are available to support licensee marketing efforts, including many industry-specific versions. The low-resolution PDFs available below download quickly and are perfect for including in email communications. (High-resolution, printer-ready files of these colorful, informative trifold brochures are also available upon request.) Simply roll over each listing to activate a small picture of the file, then click to launch the download process.";
      $results = search_headstandards(array("cat"=>"1", "subcat"=>"", "start"=>$start, "rpp"=>$rpp, "type"=>"R", "sort"=>"type,category,subcategory,subcategory2,hso.display_order"));
      $heads = $results['results'];
      $total = $results['total'];      
      
    } elseif ($subcat=="4") {
      $title = "DATA SHEETS";
      $intro = "Want to know more about one of our drive systems? No problem. Phillips Screw Company Drive System Data Sheets include a wealth of detailed information such as comparative data, torque charts, head sizes, applications, and more. Simply click on the title below to launch the download process. It couldn't be easier. ";
      $results = search_headstandards(array("cat"=>"4", "subcat"=>"", "start"=>$start, "rpp"=>$rpp, "type"=>"R", "sort"=>"type,category,subcategory,subcategory2,hso.display_order"));
      $heads = $results['results'];
      $total = $results['total'];      
      
    } elseif ($subcat=="5") {
      $title = "DRIVE SYSTEM IMAGES";
      $intro = "Professionally created 3D renderings of all Phillips Drive Systems are available in low-resolution (RGB) and high-resolution (CMYK) formats. Our RGB files are perfect for online applications, as well as in Word, Excel and PowerPoint. Our CMYK files are ideal for full-color printing applications that require high-resolution images. The compressed (Zipped) files must be downloaded, saved, and un-Zipped to be viewable and usable. Simply roll over each listing to activate a picture of the file, then click on the appropriate link to launch the download.";
      $results = search_headstandards(array("cat"=>$cat, "subcat"=>$subcat, "start"=>$start, "rpp"=>$rpp, "type"=>"L", "sort"=>"type,category,subcategory,subcategory2,hso.display_order"));
      $heads = $results['results'];
      $total = $results['total'];      
      
    }
    
  }
}

$replace['PAGINATOR'] = ($total>$rpp?ceil(($start+1)/$rpp):"");
$replace['PREV_ARROW'] = ($start>0?'<div style="float:left"><a href="javascript:;" class="pagPrev"><img border="0" src="images/arrow2.png" width="11" height="12" alt=""></a></div>':'');
$replace['NEXT_ARROW'] = ($total>$rpp && $start+$rpp<$total?'<div style="float:right"><a href="javascript:;" class="pagNext"><img border="0" src="images/arrow1.png" width="11" height="12" alt=""></a></div>':'');
$replace['PAGINATOR_LABEL'] = ($total>$rpp?"PAGE ":"");

$replace['LICENSEE_DOWNLOADS_TABLE'] .= '
<script language="JavaScript" type="text/javascript">
$().ready(function() {
  $(".pagPrev").click(function() {
    $("#inputStart").val("'.($start-$rpp<0?0:$start-$rpp).'");
    $("#frmLibrary").submit();
  });
  $(".pagNext").click(function() {
    $("#inputStart").val("'.($start+$rpp>$total?$total-$rpp:$start+$rpp).'");
    $("#frmLibrary").submit();
  });
});
</script>
<form method="post" action="licensee_downloads.php" id="frmLibrary" style="margin: 0px; padding: 0px;">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="start" id="inputStart" value="'.$start.'">
<input type="hidden" name="rpp" id="inputRpp" value="'.$rpp.'">
</form>
<form method="post" action="licensee_downloads.php" target="_blank" id="frmDownload" style="margin: 0px; padding: 0px;">
<input type="hidden" name="Do" id="inputDo" value="">
<input type="hidden" name="id" id="inputId">
</form>';

if (count($heads)) {
  $replace['LICENSEE_DOWNLOADS_TABLE'] .= '  
<script language="JavaScript" type="text/javascript">
function colorbox_close() {
  $.colorbox.close();
}

function filedl(id) {
  $("#inputId").val(id);
  $("#inputDo").val("Download");
  $("#frmDownload").submit();
}

$().ready(function() {';  
  for($i=0;$i<count($heads);$i++) {
    $replace['LICENSEE_DOWNLOADS_TABLE'] .= '  
  $(".rowHeadShowPreview'.$i.'").click(function() {
      '.($id?'$.colorbox({iframe:false, height:547, width:392, scrolling:false, href:"register2.php?fid='.$heads[$i]['id'].'"});':'filedl('.$heads[$i]['id'].');').'
  });
  '.($heads[$i]['thumbnail']!=""?'
  $(".rowHeadShowPreview'.$i.'").simpletip({  
    content: \'<div style="background: #45e40d; padding: 5px;"><img src="'.$upload_url.$heads[$i]['thumbnail'].'" border="0" alt=""></div>\',
    fixed: false
  });':'');
  }
  $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
});
</script>';  
}

$replace['LICENSEE_DOWNLOADS_TABLE'] .= '    
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
    <tr>
      <td width="650" class="text21" style="padding-bottom: 10px;" align="left" valign="top">'.$title.'</td>
    </tr>'.($intro!=""?'
    <tr>
      <td width="650" class="text9" align="left" height="52" valign="top">'.$intro.'<br><br></td>
    </tr>':'').'
    <tr>
      <td width="650">';

if ($id) {
  if (count($heads)) {
    $techSupport = false;
    $headStds = false;      
    
    for($i=0;$i<count($heads);$i++) {      
      if ($heads[$i]['type']=="R") continue; 
      if ( (!$techSupport && !$headStds) || (!$headStds && $heads[$i]['type']=="R") ) {
        $rowPointer = 0;
        if ($heads[$i]['type']=="L") $techSupport = true;
        if ($heads[$i]['type']=="R") {
          if ($techSupport) {
            $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
                  </table></td>
              </tr>
              <tr>
                <td width="650"><img border="0" src="images/transparent.gif" width="1" height="40" alt=""></td>
              </tr>
              </table>';
          }
          $headStds = true;
        }
        $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
              <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
              <!--
              <tr>
                <td align="left" valign="top" class="text22">'.($heads[$i]['type']=="L"?'Technical Support':'Head Standards').'</td>
              </tr>
              <tr>
                <td class="gray2"><img border="0" src="images/transparent.gif" width="1" height="5" alt=""></td>
              </tr>
              -->
              <tr>
                <td>
                  <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">'.
                  ($heads[$i]['type']=="L"?'
                    <tr>
                      <td width="21" height="48"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
                      <td width="500" align="left" height="48"><b><span class="text24">Technical Manual</span></b></td>
                      <td width="127" align="left" height="48"><b><span class="text24">File Name</span></b></td>
                    </tr>':
                  ($heads[$i]['type']=="R"?'
                    <tr>
                      <td width="21" height="48"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
                      <td width="428" align="left" height="48"><b><span class="text24">Head Standard</span></b></td>
                      <td width="72" align="left" height="48"><b><span class="text24">Unit</span></b></td>
                      <td width="127" align="left" height="48"><b><span class="text24">File Name</span></b></td>
                    </tr>':''));
      }
    
      $replace['LICENSEE_DOWNLOADS_TABLE'] .= ($heads[$i]['type']=="L"?'
                  <tr style="cursor: pointer;">
                    <td width="21" height="25"'.($rowPointer%2!=0?'':' class="white1""').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
                    <td width="500" align="left" height="25" class="rowHeadShowPreview'.$i.($rowPointer%2!=0?'':' white1').'"><span class="text24">'.$heads[$i]['description'].'</span></td>
                    <td width="127" align="left" height="25" class="rowHeadShowPreview'.$i.($rowPointer%2!=0?'':' white1').'"><span class="text24">'.($heads[$i]['file']!=""?end(explode("/", $heads[$i]['file'])):"N/A").'</span></td>
                  </tr>':(
      $heads[$i]['type']=="R"?'
                  <tr style="cursor: pointer;">
                    <td width="21" height="25"'.($rowPointer%2!=0?'':' class="white1"').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
                    <td width="428" align="left" height="25" class="rowHeadShowPreview'.$i.($rowPointer%2!=0?'':' white1').'"><span class="text24">'.$heads[$i]['description'].'</span></td>
                    <td width="72" align="left" height="25" class="rowHeadShowPreview'.$i.($rowPointer%2!=0?'':' white1').'"><span class="text24">'.($heads[$i]['unit']!=""?$HEAD_UNITS[$heads[$i]['unit']]:"N/A").'</span></td>
                    <td width="127" align="left" height="25" class="rowHeadShowPreview'.$i.($rowPointer%2!=0?'':' white1').'"><span class="text24">'.($heads[$i]['file']!=""?end(explode("/", $heads[$i]['file'])):"N/A").'</span></td>
                  </tr>':""));
      $rowPointer++;
    }
    $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
                  </table>
                </td>
              </tr>
              </table>';
  } else {
    $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
      <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
        <tr>
          <td width="21" height="25"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
          <td class="text24"><span style="color: #ff0000;">'.($allow?'There are no matches found.':'You are not licensed for this drive system').'</span></td>
        </tr>
      </table>';
  }
} else {
  if (count($heads)) {
    $replace['LICENSEE_DOWNLOADS_TABLE'] .= '<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">';
    if ($subcat=="1") {   
      $replace['LICENSEE_DOWNLOADS_TABLE'] .= '      
      <tr>
        <td width="21" height="48"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
        <td width="527" align="left" height="48"><b><span class="text24">Description</span></b></td>
        <td width="12">&nbsp;</td>
        <td width="88" align="left" height="48"><b><span class="text24">Language</span></b></td>
      </tr>';
      
      for($i=0;$i<count($heads);$i++) {        
        $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
        <tr style="cursor: pointer;">        
          <td width="21" height="25"'.($i%2!=0?'':' class="white1"').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
          <td width="527" align="left" height="25" class="rowHeadShowPreview'.$i.($i%2!=0?'':' white1').'"><span class="text24">'.$heads[$i]['description'].'</span></td>
          <td width="12"'.($i%2!=0?'':' class="white1"').'>&nbsp;</td>
          <td width="88" align="left" height="25" class="rowHeadShowPreview'.$i.($i%2!=0?'':' white1').'"><span class="text24">'.$DOCUMENT_LANGUAGES[$heads[$i]['language']].'</span></td>
        </tr>';
      }
    } elseif ($subcat=="2") {
      $subcat2 = "";
      $oldsubcat2 = "";
      $catCount = 0;
      for($i=0;$i<count($heads);$i++) {        
      //print_r($heads[$i]);exit;
        $subcat2 = $DOCUMENT_CATEGORIES['L'][$heads[$i]['category']]['categories'][$heads[$i]['subcategory']]['categories'][$heads[$i]['subcategory2']]['name'];
        if ($subcat2 != $oldsubcat2) {
      
          $replace['LICENSEE_DOWNLOADS_TABLE'] .= '      
          <tr>
            <td width="21" height="48"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
            <td width="527" align="left" height="48"><b><span class="text24">'.$subcat2.'</span></b></td>
            <td width="12">&nbsp;</td>
            <td width="88" align="left" height="48"><b><span class="text24">Format</span></b></td>
          </tr>';
          $oldsubcat2 = $subcat2;
          $catCount = 0;
        }
      
        $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
        <tr style="cursor: pointer;">        
          <td width="21" height="25"'.($catCount%2!=0?'':' class="white1"').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
          <td width="527" align="left" height="25" class="rowHeadShowPreview'.$i.($catCount%2!=0?'':' white1').'"><span class="text24">'.$heads[$i]['description'].'</span></td>
          <td width="12"'.($catCount%2!=0?'':' class="white1"').'>&nbsp;</td>
          <td width="88" align="left" height="25" class="rowHeadShowPreview'.$i.($catCount%2!=0?'':' white1').'"><span class="text24">'.$DOCUMENT_FORMATS[$heads[$i]['format']].'</span></td>
        </tr>';
        ++$catCount; 
      }      
      
    } elseif ($subcat=="3"||$subcat=="4") {
      $replace['LICENSEE_DOWNLOADS_TABLE'] .= '      
      <tr>
        <td width="21" height="48"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
        <td width="527" align="left" height="48"><b><span class="text24">Description</span></b></td>
        <td width="12">&nbsp;</td>
        <td width="88" align="left" height="48"><b><span class="text24">Language</span></b></td>
      </tr>';
      
      for($i=0;$i<count($heads);$i++) {        
        $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
        <tr style="cursor: pointer;">        
          <td width="21" height="25"'.($i%2!=0?'':' class="white1"').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
          <td width="527" align="left" height="25" class="rowHeadShowPreview'.$i.($i%2!=0?'':' white1').'"><span class="text24">'.$heads[$i]['description'].'</span></td>
          <td width="12"'.($i%2!=0?'':' class="white1"').'>&nbsp;</td>
          <td width="88" align="left" height="25" class="rowHeadShowPreview'.$i.($i%2!=0?'':' white1').'"><span class="text24">'.$DOCUMENT_LANGUAGES[$heads[$i]['language']].'</span></td>
        </tr>';
      }        
    } elseif ($subcat=="5") {
      $replace['LICENSEE_DOWNLOADS_TABLE'] .= '      
      <tr>
        <td width="21" height="48"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
        <td width="527" align="left" height="48"><b><span class="text24">Description</span></b></td>
        <td width="12">&nbsp;</td>
        <td width="88" align="left" height="48"><b><span class="text24">Format</span></b></td>
      </tr>';
      
      for($i=0;$i<count($heads);$i++) {        
        $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
        <tr style="cursor: pointer;">        
          <td width="21" height="25"'.($i%2!=0?'':' class="white1"').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
          <td width="527" align="left" height="25" class="rowHeadShowPreview'.$i.($i%2!=0?'':' white1').'"><span class="text24">'.$heads[$i]['description'].'</span></td>
          <td width="12"'.($i%2!=0?'':' class="white1"').'>&nbsp;</td>
          <td width="88" align="left" height="25" class="rowHeadShowPreview'.$i.($i%2!=0?'':' white1').'"><span class="text24">'.$DOCUMENT_FORMATS[$heads[$i]['format']].'</span></td>
        </tr>';
      }    
    }
    $replace['LICENSEE_DOWNLOADS_TABLE'] .= '</table>';
  } else {
    if ($subcat) {
      $replace['LICENSEE_DOWNLOADS_TABLE'] .= '
        <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
        <tr>
          <td width="21" height="25"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
          <td colspan="3" class="text24"><span style="color: #ff0000;">There are no matches found.</span></td>
        </tr>
        </table>';
    }
  }
}
$replace['LICENSEE_DOWNLOADS_TABLE'] .= '
      </td>
    </tr>
  </table>';

?>
<? include("template.php"); ?>