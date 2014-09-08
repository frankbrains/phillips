<?
include("functions/include.php");

if (isset($_POST['Do']) && $_POST['Do']=="Search") {
  $results = search_pages($_POST);

  if (!count($results)) {
    $replace['SEARCH_RESULTS'] = '<span class="text1">No matches found.</span>';
  } elseif (count($results)) {  
    $replace['SEARCH_RESULTS'] = '
    <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
      <tr><td><img src="images/transparent.gif" height="20" width="1" alt="" border="0"></td></tr>
      <tr>
        <td>
          <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
            <tr>
              <td colspan="2" class="text1">Matching pages:</td>
            </tr>';
    
    for($i=0;$i<count($results);$i++) {
      $replace['SEARCH_RESULTS'] .= '
            <tr><td colspan="2"><img src="images/transparent.gif" width="1" height="5" alt="" border="0"></td></tr>
            <tr>
              <td class="text10" valign="top">'.($i+1).'.&nbsp;&nbsp;</td>
              <td class="text10" valign="top">
              <a href="'.$results[$i]["filename"].'">'.$results[$i]["filename"].'</a> - '.$results[$i]["pagetitle"].'</td>
            </tr>';
    }
    $replace['SEARCH_RESULTS'] .= '
          </table></td>
      </tr>
      <tr><td><img src="images/transparent.gif" height="50" width="1" alt="" border="0"></td></tr>
    </table>';    
  }
  
} 

include("template.php");
?>