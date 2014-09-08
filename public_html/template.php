<?
include("functions/include.php");
if (!session_id()) session_start();
$settings = get_settings();

if ($_POST['preview']) {
  $pieces = $_POST;
} else {
  $pieces = get_page_pieces($_SERVER);
  if (isset($TEMPLATE['body'])) {
    $pieces['body'] .= $TEMPLATE['body'];
  }
}

$replace['TIMELINE_POPUP_LINK'] = '<a rel="popupTimeline" href="timeline.php">Launch timeline</a>';

$industries = array("aerospace"=>"Aerospace", "automotive"=>"Automotive", "diytrade"=>"DIY &amp; Trade", "electronics"=>"Electronics", "industrial"=>"Industrial", "marine"=>"Marine", "military"=>"Military");
$replace['PRODUCT_APPLICATIONS'] = '<script language="JavaScript" type="text/javascript">
$().ready(function() {
  $("#sel_productApplications").change(function() {
    var thisIndustry = $(this).val();
    $(".productApplications").each(function() {
      $(this).hide();
    });
    $("#tbody_application"+thisIndustry).show();
  });
});
</script>
<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
  <tr>
    <td rowspan="2" width="20">&nbsp;</td>
    <td align="left" class="text15" valign="top">
      <div style="padding-bottom: 5px;">APPLICATIONS</div>
      <select name="sel_productApplications" id="sel_productApplications">
      <option value="">Select Application</option>';
foreach ($industries as $industry=>$industryLabel)
  if ($pieces[$industry.'_enable']=="1") $replace['PRODUCT_APPLICATIONS'] .= '<option value="'.$industry.'">'.$industryLabel.'</option>';
  $replace['PRODUCT_APPLICATIONS'] .= '  
      </select>    
    </td>
    <td width="5">&nbsp;</td>
    <td valign="top" align="left">
      <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">';
foreach ($industries as $industry=>$industryLabel) {
  $replace['PRODUCT_APPLICATIONS'] .= '
        <tbody class="productApplications" id="tbody_application'.$industry.'" style="display: none;">
        <tr>
          <td>'.$pieces[$industry.'_apps'].'</td>
        </tr>
        </tbody>';
}
$replace['PRODUCT_APPLICATIONS'] .= '
      </table></td>
  </tr>
</table>';

if (isset($replace) && count($replace)>0) {
  foreach (array_keys($replace) as $key) {
    if (preg_match('/{'.$key.'}/', $pieces['body'])) {
      $pieces['body'] = preg_replace('/{'.$key.'}/', $replace[$key], $pieces['body']);
    }
  }  
}
include($pieces['template']);
?>