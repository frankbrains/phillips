<?
include("functions/include.php");

$events = search_events($_POST);
if (count($events['results'])) {
  $replace['EVENTS_TABLE'] = '
          <table width="676" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
            <tr>
              <td width="676" colspan="3"><img border="0" src="images/transparent.gif" width="1" height="13" alt=""></td>
            </tr>
            <tr>
              <td width="676" colspan="3" class="text24" style="padding-left: 10px; padding-right: 30px;">Innovation revolves around Phillips Screw. So we 
              attend many of the world\'s important industry events and trade 
              shows. Here is where we will be in the coming months.<br>
              <br></td>
            </tr>';
  for($i=0;$i<count($events['results']);$i++) {
    $replace['EVENTS_TABLE'] .= '
            <tr>
              <td '.($i%2==0?' class="white1"':'').' style="padding: 5px; font-weight: bold;"><span class="text24">
              '.($events['results'][$i]['url']!=''?'<a target="_blank" class="black" href="'.(preg_match("/:\/\//", $events['results'][$i]['url'])?'':'http://').$events['results'][$i]['url'].'">':'').$events['results'][$i]['title'].($events['results'][$i]['url']!=''?'</a>':'').'</span></td>
              <td '.($i%2==0?' class="white1"':'').'><span class="text24">'.$events['results'][$i]['location'].'</span></td>
              <td '.($i%2==0?' class="white1"':'').'><span class="text24">'.date("m/d/Y", strtotime($events['results'][$i]['start_date'])).'-'.date("m/d/Y", strtotime($events['results'][$i]['end_date'])).'</span></td>
            </tr>';
  }
  $replace['EVENTS_TABLE'] .= '
          </table>';
}
?>
<? include("template.php"); ?>