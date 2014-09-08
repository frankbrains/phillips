<?
include("functions/include.php");

$news = search_news($_POST);
if (count($news['results'])) {
  $replace['NEWS_TABLE'] = '
          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
            <tr>
              <td colspan="2"><img border="0" src="images/transparent.gif" width="1" height="13" alt=""></td>
            </tr>';
  for($i=0;$i<count($news['results']);$i++) {
    $replace['NEWS_TABLE'] .= '
            <tr>
              <td width="521"'.($i%2==0?' class="white1"':'').' style="padding: 5px; font-weight: bold;"><span class="text24">
              <a class="black" href="news_release.php?id='.$news['results'][$i]['id'].'">'.$news['results'][$i]['title'].'</a></span></td>
              <td width="135"'.($i%2==0?' class="white1"':'').'><span class="text24">'.date("m/d/Y", strtotime($news['results'][$i]['date'])).'</span></td>
            </tr>';
  }
  $replace['NEWS_TABLE'] .= '
          </table>';
}
?>
<? include("template.php"); ?>
