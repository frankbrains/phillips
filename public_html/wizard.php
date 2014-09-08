<?
include("functions/include.php");

$v = (isset($_POST['v'])?$_POST['v']:$_GET['v']);

$allProducts = search_wizard(array());

$challenges = false;
if (count($_POST['challenge'])) {
  $challenges = true;
  foreach ($_POST['challenge'] as $chal) {
    $data = $_POST;
    $data['challenge'] = $chal;
    $results[$chal] = search_wizard($data);
  }
} else {
  $results = search_wizard($_POST);
}

if ($_POST['industry']!="") $industry = get_industries(array("id"=>$_POST['industry']));
$chalText = "";
if (count($_POST['challenge'])) {  
  for ($i=0;$i<count($_POST['challenge']);$i++) {
    $challenge = get_critical_needs(array("id"=>$_POST['challenge'][$i]));
    $chalText .= ($chalText!=""?' <span style="font-size: 17px; color: #000000;">+</span> ':'').$challenge[0]['name'];
  }
}

$TEMPLATE['body'] = '
<script language="JavaScript" type="text/javascript">
<!--
$().ready(function() {
  $(".clkWizardPage").click(function() {
    var pg = $(this).attr("id").substr(6);
    document.location = pg;
  });
});
-->
</script>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
    <tr>
      <td width="980" height="1114" align="left" valign="top" class="bg2_acr_phillips">
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
        <tr>
          <td width="285" rowspan="2" class="text26" valign="top" style="padding-left: 20px; padding-top: 30px;"><a href="terminology.php">Definition of Terms</a></td>
          <td width="655" height="'.($v=="2"?"38":"32").'" valign="bottom" align="right">&nbsp;</td>
          <td width="40" height="32" rowspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="655" valign="top">
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
            <tr>
              <td width="655" class="text27" style="padding-bottom: 10px;" align="left" valign="top">'.($v=="2"?"PHILLIPS DRIVE SYSTEMS<br>INNOVATION IN FASTENER TECHNOLOGY":(trim($_POST['industry'])==""?'PHILLIPS SCREW ':'').'DRIVE SYSTEMS'.($_POST['industry']!=""?' FOR '.strtoupper($industry[0]['name']):'')).'</td>
			</tr>
			'.($v=="2"?'
            <tr>
              <td width="655" class="text9" align="left" valign="top">
				In 1937, the Cadillac Division of General Motors began assembling their vehicles with the new Phillips cruciform screw system. 
				Since that time, and consistently for the last 75 years, Phillips has introduced many of the world’s most technologically advanced 
				threaded-fastener drive systems. With recent innovations including our HEXSTIX<sup><span style="font-size: 12px">&#174;</span></sup> and MORTORQ<sup><span style="font-size: 12px">&#174;</span></sup> SUPER Drive Systems, look to Phillips for innovative drive systems solutions 
				designed to meet the highest manufacturing standards and deliver cost-effective productivity.</td>
            </tr>			
            ':'').'
			<tr>
              <td width="655" class="text31" style="padding-bottom: 15px;">'.(count($_POST['challenge'])?'<span>SEARCH RESULTS FOR '.strtoupper($chalText).'</span>':'').'</td>
            </tr>';

if (!count($allProducts)) {
  $TEMPLATE['body'] .= '
            <tr>
              <td width="655" class="text13" align="left" valign="top"><span class="text14">No matches found.</span></td>
            </tr>';
} elseif (count($allProducts)) {
  $pos = 0;
  for($i=0;$i<count($allProducts);$i++) {
    $match = false;
    if (!$challenges) {
      for($z=0;$z<count($results);$z++) if ($results[$z]['id']==$allProducts[$i]['id']) $match = true;
    } else {
      $foundAll = true;
      foreach ($_POST['challenge'] as $chal) {
        $foundChal = false;
        foreach ($results[$chal] as $check) { if ($check['id']==$allProducts[$i]['id']) $foundChal = true; }
        if (!$foundChal) $foundAll = false;
      }
      if ($foundAll) $match = true;
    }
    ++$pos;
    $TEMPLATE['body'] .= ($pos==1?'
            <tr>
              <td width="655" align="left" valign="top">  
              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
                <tr>':'').'
                  <td width="157" height="157">
                    <div style="'.($match?'cursor: pointer; ':'').'height: 157px;" class="'.($match?'clkWizardPage':'overlaywizard').'" id="wizard'.$allProducts[$i]['filename'].'">'.($allProducts[$i]['wizardImage']!=""?'<img src="'.$allProducts[$i]['wizardImage'].'" alt="" height="157" width="157" border="0">':$allProducts[$i]['product_name']).'</div></td>
                  '.($pos<4?'<td width="9"><img src="images/transparent.gif" height="1" width="9" alt="" border="0"></td>':'').
                  ($pos==4?'
                </tr>
                <tr>
                  <td><img src="images/transparent.gif" height="9" width="1" alt="" border="0"></td>
                </tr>
              </table>
              </td>
            </tr>':'');
    if ($pos==4) $pos = 0;
  }
  if ($pos!=0) {
    $TEMPLATE['body'] .= '    
                </tr>
                <tr>
                  <td><img src="images/transparent.gif" height="9" width="1" alt="" border="0"></td>
                </tr>                
              </table>
              </td>
            </tr>';    
  }
}
$TEMPLATE['body'] .= '
          </table><br><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
<tr>
<td align="left" width="37"><img src="images/plane.png" border="0" width="27" height="29" alt=""></td>
<td align="left" class="text9">Drive Systems for Aerospace and Military applications</td>
</tr>
</table></td>
      </tr>
    </table></td>
  </tr>
</table>';


?>
<? include("template.php"); ?>