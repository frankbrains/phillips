<?
include("functions/include.php");

$id = (isset($_POST['id'])?$_POST['id']:$_GET['id']);
if ($id) {
  $news = search_news(array("id"=>$id));
  if (count($news['results'])) {
    $replace['NEWS_RELEASE'] = '
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
          <tr>
            <td width="630" class="text8" align="left" valign="top">'.$news['results'][0]['title'].'</td>
          </tr>
          <tr>
            <td width="630"><img border="0" src="images/transparent.gif" width="1" height="14" alt=""></td>
          </tr>
          <tr>
            <td width="630" class="text19" align="left" valign="top" height="30">RELEASE DATE '.date("m/d/Y", strtotime($news['results'][0]['date'])).'</td>
          </tr>
          <tr>
            <td width="630" class="text9" align="left" valign="top">'.$news['results'][0]['summary'].'</td>
          </tr>
        </table>';  
  }
}
?>
<? include("template.php"); ?>
