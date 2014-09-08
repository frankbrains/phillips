<?
include("functions/include.php");

$id = (isset($_POST['id'])?$_POST['id']:$_GET['id']);
$cat = (isset($_POST['cat'])?$_POST['cat']:$_GET['cat']);

$start = (isset($_POST['start'])?$_POST['start']:0);
$rpp = 25;
$heads = array();
$total = 0;
$title = "";
$intro = "";

if (isset($_POST['Do']) && $_POST['Do']=="Download") {
  $heads = search_headstandards(array("id"=>$_POST['id']));
  header("Location: ".$upload_url.$heads['results'][0]['file']);
  exit;
}

if ($cat=="1") {
  $results = search_headstandards(array("start"=>$start, "rpp"=>$rpp, "type"=>"R", "cat"=>$cat, "sort"=>"hso.type,hso.category,hso.subcategory,hso.subcategory2,hso.display_order"));
  $title = $DOCUMENT_CATEGORIES["R"][$cat]['title'];
  $intro = "The Phillips Screw Company delivers unparralelled fastener and assembly solutions to a wide range of industries. In addition to providing an overview of Phillips Screw, our market-specific brochures include detailed information on the leading drive systems available for the specific industry. Simply click on the title below to launch the download process.";
  $heads = $results['results'];
  $total = $results['total'];
} elseif ($cat=="2") {
  $title = "PRECISE HEAD STANDARDS FOR PRECISION ENGINEERING"; 
  $intro = "Whether you’re exploring options for optimum assembly efficiencies or specifying fasteners for final manufacturing, Phillips’ comprehensive library of Head Standards is an invaluable engineering resource. Detailed head standards drawings are available for most commonly used fasteners. Best of all, the drawings can be quickly and easily imported into your CAD/CAM product engineering designs.<br><br>Finding the right drawing(s) for your specific application is fast and easy. Simply choose the drive system \"drawer\" from the Head Standards tool chest to the left. Hover over each listing to display a preview of that drawing. When you find the drawing you want, just click to launch the download process. It’s that simple.";
} elseif ($cat=="3") {
  $title = "PHILLIPS SCREW COMPANY VIDEO LIBRARY"; 
  $intro = "See and hear what product and assembly engineers have to say about the performance of Phillips Drive Systems in some of the most demanding environments. Simply select the video you want to watch and sit back to enjoy the show.<br><br>";  
  $results = search_headstandards(array("start"=>$start, "rpp"=>$rpp, "type"=>"R", "cat"=>$cat, "sort"=>"hso.type,hso.category,hso.subcategory,hso.subcategory2,hso.display_order"));
  $heads = $results['results'];
  $total = $results['total'];
} elseif ($cat=="4") {
  $title = $DOCUMENT_CATEGORIES["R"][$cat]['title'];
  $intro = "Want to know more about one of our drive systems? No problem. Phillips Screw Company Drive System Data Sheets include a wealth of detailed information such as comparative data, torque charts, head sizes, applications, and more. Simply click on the title below to launch the download process. It couldn't be easier.<br><br>";  
  $results = search_headstandards(array("start"=>$start, "rpp"=>$rpp, "type"=>"R", "cat"=>$cat, "sort"=>"hso.type,hso.category,hso.subcategory,hso.subcategory2,hso.display_order"));
  $heads = $results['results'];
  $total = $results['total'];  
} elseif ($id) {
  $pages = search_pages(array("id"=>$id));
  $page = $pages[0];
  $title = strtoupper($page['product_name']).' HEAD STANDARDS';
  $results = search_headstandards(array("page_id"=>$id, "start"=>$start, "rpp"=>$rpp, "type"=>"R", "sort"=>"hso.type,hso.category,hso.subcategory,hso.subcategory2,hso.display_order"));
  $heads = $results['results'];
  $total = $results['total'];
} else {
  $title = "THE SUPPORT YOU EXPECT FROM THE LEADER IN FASTENING SOLUTIONS."; 
  $intro = "Welcome. We hope you find our public Resource Library to a valuable archive of important Phillips Screw Company literature and Head Standards drawings. The materials offered are available for free. We request only your name and email address in order to initiate the download process.<br><br>Phillips Screw offers market specific brochures created especially for each industry we serve, including an overview of available drive systems. Want more information about a particular drive system? Then select one of our many drive system data sheets. Phillips' data sheets include available torque charts, size tables, comparative data and more.<br><br>Product designers and assembly engineers may be more interested in our detailed Head Standards drawings. They are available for many commonly used fasteners. Best of all, the drawings can be easily imported into your CAD/CAM product engineering designs.";
}
 
$replace['PAGINATOR'] = ($total>$rpp?ceil(($start+1)/$rpp):"");
$replace['PREV_ARROW'] = ($start>0?'<div style="float:left"><a href="javascript:;" class="pagPrev"><img border="0" src="images/arrow2.png" width="11" height="12" alt=""></a></div>':'');
$replace['NEXT_ARROW'] = ($total>$rpp && $start+$rpp<$total?'<div style="float:right"><a href="javascript:;" class="pagNext"><img border="0" src="images/arrow1.png" width="11" height="12" alt=""></a></div>':'');
$replace['PAGINATOR_LABEL'] = ($total>$rpp?"PAGE ":"");


$replace['HEAD_STANDARDS_TABLE'] .= '
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
  $(".closePopup").live("click", function() {
    window.parent.cbox_close();
  });  
});
</script>
<form method="post" action="resource_library.php" id="frmLibrary" style="margin: 0px; padding: 0px;">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="cat" value="'.$cat.'">
<input type="hidden" name="start" id="inputStart" value="'.$start.'">
<input type="hidden" name="rpp" id="inputRpp" value="'.$rpp.'">
</form>';

if (count($heads)) {
  $replace['HEAD_STANDARDS_TABLE'] .= '  
<script language="JavaScript" type="text/javascript">
$().ready(function() {';  
  for($i=0;$i<count($heads);$i++) {
    $youtube_id = "";
    if ($cat=="3") {      
      if (preg_match("/\?v=([^&]+)/", $heads[$i]['url'], $matches)) {
        $youtube_id = $matches[1];
      } elseif (preg_match("/\/([^\/]+)$/", $heads[$i]['url'], $matches)) {
        $youtube_id = $matches[1];
      }
    }
    $replace['HEAD_STANDARDS_TABLE'] .= ($heads[$i]['file']!=""||($heads[$i]['type']=="R"&&$heads[$i]['category']=="3"&&$heads[$i]['url']!="")?'  
  $(".rowHeadShowPreview'.$i.'").click(function() {
    '.($cat=="3"?'
      $.colorbox({iframe:false, height:421, width:641, scrolling:false, html:"<div style=\\"text-align: right; height: 30px;\\"><a class=\\"blue closePopup\\" href=\\"javascript:;\\"><img src=\\"images/close-window.png\\" border=\\"0\\" width=\\"60\\" height=\\"18\\" alt=\\"\\"></a></div><div style=\\"height: 390px;\\"><iframe width=\\"640\\" height=\\"390\\" src=\\"http://www.youtube.com/embed/'.$youtube_id.'?rel=0\\" frameborder=\\"0\\" allowfullscreen></iframe></div>"});
    ':'
    if ($.cookie("rlreg")!="1") {
      $.colorbox({iframe:false, height:586, width:392, scrolling:false, href:"register.php?id='.$heads[$i]['id'].'"});  
    } else {
      filedl('.$heads[$i]['id'].');
    }').'
  });':'').($heads[$i]['thumbnail']!=""?'
  $(".rowHeadShowPreview'.$i.'").simpletip({
    content: \'<div style="background: #45e40d; padding: 5px;"><img src="'.preg_replace("/'/", "\\'", $upload_url.$heads[$i]['thumbnail']).'" border="0" alt=""></div>\',
    fixed: false
  });':'');
  }
  $replace['HEAD_STANDARDS_TABLE'] .= '
});
</script>';  
}

$replace['HEAD_STANDARDS_TABLE'] .= '    
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
    <tr>
      <td width="650" class="text21" style="padding-bottom: 10px;" align="left" height="24" valign="top">'.$title.'</td>
    </tr>';
if ($intro!="") {
  $replace['HEAD_STANDARDS_TABLE'] .= '    
    <tr>
      <td width="650" class="text9" align="left" height="52" valign="top">'.$intro.'</td>
    </tr>';
}

$replace['HEAD_STANDARDS_TABLE'] .= '
    <tr>
      <td width="650">
        <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">';

if ($id) {
  $replace['HEAD_STANDARDS_TABLE'] .= '
          <tr>
            <td width="21" height="48" class="white1"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
            <td width="416" align="left" height="48" class="white1"><b><span class="text24">Drawing Description</span></b></td>
            <td width="72" align="left" height="48" class="white1"><b><span class="text24">Unit</span></b></td>
            <td width="139" align="left" height="48" class="white1"><b><span class="text24">Drawing Number</span></b></td>
          </tr>';

  if (count($heads)) {
    for($i=0;$i<count($heads);$i++) {    
      $replace['HEAD_STANDARDS_TABLE'] .= '
          <tr style="cursor: pointer;">
            <td width="21" style="padding-top: 5px; padding-bottom: 5px;"'.($i%2!=0?' class="white1"':'').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
            <td width="416" align="left" style="padding-top: 5px; padding-bottom: 5px;" class="rowHeadShowPreview'.$i.($i%2!=0?' white1':'').'"><span class="text24">'.$heads[$i]['description'].'</span></td>
            <td width="72" align="left" style="padding-top: 5px; padding-bottom: 5px;"class="rowHeadShowPreview'.$i.($i%2!=0?' white1':'').'"><span class="text24">'.$HEAD_UNITS[$heads[$i]['unit']].'</span></td>
            <td width="139" align="left" style="padding-top: 5px; padding-bottom: 5px;"class="rowHeadShowPreview'.$i.($i%2!=0?' white1':'').'"><span class="text24">'.$heads[$i]['drawing_number'].'</span></td>
          </tr>';
    }
  } else {
    $replace['HEAD_STANDARDS_TABLE'] .= '
          <tr>
            <td width="21"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
            <td colspan="3" class="text24"><span style="color: #ff0000;">There are no matches found.</span></td>
          </tr>';
  }
} else {
  if (count($heads)) {
    if ($cat=="3") {
      for($i=0;$i<count($heads);$i++) {    
        $replace['HEAD_STANDARDS_TABLE'] .= '
            <tr style="cursor: pointer;">
              <td width="21" style="padding-top: 5px; padding-bottom: 5px;" '.($i%2!=0?'':' class="white1"').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
              <td width="627" align="left" style="padding-top: 5px; padding-bottom: 5px;" class="rowHeadShowPreview'.$i.($i%2!=0?'':' white1').'"><span class="text24"><b>'.$heads[$i]['name'].'</b><br>'.$heads[$i]['description'].'</span></td>
            </tr>';
      }    
    } else {
      $subcat = "";
      $oldSubcat = "";
      $catCount = 0;
      $printedHead = false;
      for($i=0;$i<count($heads);$i++) {    
        $subcat = $DOCUMENT_CATEGORIES['R'][$heads[$i]['category']]['categories'][$heads[$i]['subcategory']]['name'];
        if (!$printedHead && !count($DOCUMENT_CATEGORIES['R'][$heads[$i]['category']]['categories'])) {
          $printedHead = true;
          $replace['HEAD_STANDARDS_TABLE'] .= '
            <tr>
              <td width="21" height="48"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
              <td width="416" align="left" height="48"><b><span class="text24">'.$DOCUMENT_CATEGORIES['R'][$heads[$i]['category']]['name'].'</span></b></td>
              <td width="72" align="left" height="48"><b><span class="text24">Language</span></b></td>
              <td width="139" align="left" height="48"><b><span class="text24">File Name</span></b></td>
            </tr>'; 
        }
        if ($subcat != $oldSubcat) {          
          $replace['HEAD_STANDARDS_TABLE'] .= '
            <tr>
              <td width="21" height="48"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
              <td width="416" align="left" height="48"><b><span class="text24">'.$subcat.'</span></b></td>
              <td width="72" align="left" height="48"><b><span class="text24">Language</span></b></td>
              <td width="139" align="left" height="48"><b><span class="text24">File Name</span></b></td>
            </tr>';      
          $oldSubcat = $subcat;
          $catCount = 0;
        }
        $replace['HEAD_STANDARDS_TABLE'] .= '
            <tr style="cursor: pointer;">
              <td width="21" style="padding-top: 5px; padding-bottom: 5px;" '.($catCount%2!=0?'':' class="white1"').'><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
              <td width="416" align="left" style="padding-top: 5px; padding-bottom: 5px;" class="rowHeadShowPreview'.$i.($catCount%2!=0?'':' white1').'"><span class="text24">'.$heads[$i]['description'].'</span></td>
              <td width="72" align="left" style="padding-top: 5px; padding-bottom: 5px;" class="rowHeadShowPreview'.$i.($catCount%2!=0?'':' white1').'"><span class="text24">'.$DOCUMENT_LANGUAGES[$heads[$i]['language']].'</span></td>
              <td width="139" align="left" style="padding-top: 5px; padding-bottom: 5px;" class="rowHeadShowPreview'.$i.($catCount%2!=0?'':' white1').'"><span class="text24">'.end(explode("/", $heads[$i]['file'])).'</span></td>
            </tr>';
        ++$catCount; 
      }
    }
  }
}
$replace['HEAD_STANDARDS_TABLE'] .= '
        </table>
      </td>
    </tr>
  </table>';

?>
<? include("template.php"); ?>