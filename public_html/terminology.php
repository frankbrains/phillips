<?
include("functions/include.php");

$start = (isset($_POST['start'])?$_POST['start']:0);
$rpp = 20;

$results = search_terminology(array("start"=>$start, "rpp"=>$rpp));
$terms = $results['results'];
$total = $results['total'];

$replace['PAGINATOR'] = ceil(($start+1)/$rpp);
$replace['PREV_ARROW'] = ($start>0?'<div style="float:left"><a href="javascript:;" class="pagPrev"><img border="0" src="images/arrow2.png" width="11" height="12" alt=""></a></div>':'');
$replace['NEXT_ARROW'] = ($total>$rpp && $start+$rpp<$total?'<div style="float:right"><a href="javascript:;" class="pagNext"><img border="0" src="images/arrow1.png" width="11" height="12" alt=""></a></div>':'');
$replace['PAGINATOR_LABEL'] = ($total>$rpp?"PAGE ":"");

$replace['TERMINOLOGY_TABLE'] .= '
<script language="JavaScript" type="text/javascript">
$().ready(function() {
  $(".pagPrev").click(function() {
    $("#inputStart").val("'.($start-$rpp<0?0:$start-$rpp).'");
    $("#frmTerminology").submit();
  });
  $(".pagNext").click(function() {
    $("#inputStart").val("'.($start+$rpp>$total?$total-$rpp:$start+$rpp).'");
    $("#frmTerminology").submit();
  });
});
</script>
<form method="post" action="terminology.php" id="frmTerminology" style="margin: 0px; padding: 0px;">
<input type="hidden" name="start" id="inputStart" value="'.$start.'">
<input type="hidden" name="rpp" id="inputRpp" value="'.$rpp.'">
</form>';

$replace['TERMINOLOGY_TABLE'] .= '    
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">';

if (count($terms)) {
  $wizTerms = false;
  $otherTerms = false;

  $replace['TERMINOLOGY_TABLE'] .= '
            <tr>
              <td width="650" class="text21" style="padding-bottom: 10px;" align="left" height="24" valign="top" colspan="2">TERMINOLOGY REFERENCE GUIDE</td>
            </tr>';
  
  for($i=0;$i<count($terms);$i++) {
    if ( (!$wizTerms && !$otherTerms) || (!$otherTerms && !$terms[$i]['wizard']) ) {
      if ($terms[$i]['wizard']) $wizTerms = true;
      if (!$terms[$i]['wizard']) {
        if ($wizTerms) {
          $replace['TERMINOLOGY_TABLE'] .= '
            <tr>
              <td width="650" colspan="2"><img border="0" src="images/transparent.gif" width="1" height="40" alt=""></td>
            </tr>';
        }
        $otherTerms = true;
      }
      
      $replace['TERMINOLOGY_TABLE'] .= '
            <tr>
              <td width="142" align="left" valign="top" class="text22">'.($terms[$i]['wizard']?'Wizard':'Other').' Terms</td>
              <td width="508" align="left" valign="top" class="text22">Definition</td>
            </tr>
            <tr>
              <td width="650" colspan="2" class="gray2"><img border="0" src="images/transparent.gif" width="1" height="5" alt=""></td>
            </tr>';
    }
    $replace['TERMINOLOGY_TABLE'] .= '
            <tr>
              <td width="142" align="left" valign="top" class="text28"><b>'.$terms[$i]['term'].'</b></td>
              <td width="508" align="left" valign="top" class="text28">'.$terms[$i]['definition'].'</td>
            </tr>
            <tr>
              <td width="650" class="gray2" colspan="2"><img border="0" src="images/transparent.gif" width="1" height="1" alt=""></td>
            </tr>';
  }
} else {
  $replace['TERMINOLOGY_TABLE'] .= '
            <tr>
              <td width="21" height="25"><img src="images/transparent.gif" border="0" width="21" height="1" alt=""></td>
              <td colspan="3" class="text24"><span style="color: #ff0000;">There are no matches found.</span></td>
            </tr>';
}

$replace['TERMINOLOGY_TABLE'] .= '
  </table>';

include("template.php"); ?>