<?
include("functions/include.php");
if (!session_id()) session_start();

$user = array();
if ($_SESSION['authenticated']&&$_SESSION['user_id']) $user = get_user($_SESSION['user_id']);

$page = end(explode("/", $_SERVER['SCRIPT_NAME']));
$uri = end(explode("/", $_SERVER['REQUEST_URI']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<head>
<title>Phillips Screw Timeline</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
.text1 { color: #FFFFFF; font-size: 34px; font-weight: normal; font-family: Impact; }
.active { color: #488ecb }
.clkSlide { cursor: pointer }
.slideImageHolder { position:relative; overflow:hidden; width: 500px; height:375px; }
</style>
<script language="JavaScript" type="text/javascript" src="jquery-1.4.4.min.js"></script>
<script language="JavaScript" type="text/javascript" src="jquery.cycle.all.min.js"></script>
<script type="text/javascript">
<!--
var currentSlide = 0;
var timelineEdges = 296;
var slideWidth = 96;
var imageWidth = 500;

tlSlides = new Array();
<? for ($i=0;$i<count($timeline);$i++) { ?>
tlSlides[<?=$i?>] = new Object();
tlSlides[<?=$i?>] = new Slide("<?=$timeline[$i]['year']?>", "<?=$timeline[$i]['image']?>");
<? } ?>

function Slide(label, src) {
  this.label = label;
  this.src = src;
}

function showSlide(x) {  
  //alert(currentSlide+"\n"+x+"\n"+(currentSlide-x));
  var leftCss = timelineEdges - (slideWidth*x);  
  var speed = (Math.abs(currentSlide-x)>2?300:200);
  
  //$("#slideImageHolder").animate({ height: 0 }, 100);
  //$("#slideImageHolder").html('<img border="0" src="'+tlSlides[x].src+'" width="500" height="375" alt="">');
  //$("#slideImageHolder").animate({ height: 375 }, 100);
  
  //$("#timeline").animate({ left: leftCss }, speed);
  $('.slideImageHolder').cycle(x, (currentSlide>x?"scrollRight":"scrollLeft"));
  $("#timeline").css({ left: leftCss });
  
  if (x==0) $("#clkPrev").hide();
  else $("#clkPrev").show();
  
  if (x<tlSlides.length-1) $("#clkNext").show();
  else $("#clkNext").hide();
  
  $("#div_date"+currentSlide).removeClass("active");
  currentSlide = x;
  $("#div_date"+currentSlide).addClass("active"); 
}

$(document).ready(function() {
  $(".closePopup").click(function() {
    window.parent.cbox_close();
  });
  
  $('.slideImageHolder').cycle({
		fx: 'scrollLeft', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
    timeout: 0
	});
  
  $('.clkSlide').click(function() {
    showSlide($(this).attr("rel")*1);
  });
  
  $('#clkNext').click(function() {
    if (currentSlide<tlSlides.length-1) showSlide(currentSlide+1);    
  });
  
  $('#clkPrev').click(function() {
    if (currentSlide>0) showSlide(currentSlide-1);
  });  
    
  var pos = $("#timelineHolder").offset();
  $("#timelineOverlay").css({top: pos.top-7, left: pos.left+timelineEdges+2});
  showSlide(currentSlide);
});

-->
</script>
</head>

<body style="margin: 0px; padding: 0px; background-color: #333333;">

<div align="center">
  <center>
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
      <tr>
        <td align="center" valign="top" height="100">&nbsp;</td>
        <td align="right" valign="top" height="100">
          <div style="margin-top: 10px;"><a class="blue closePopup" href="javascript:;"><img src="images/close-window.png" border="0" width="60" height="18" alt=""></a></div></td>
        <td align="center" valign="top" height="100">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center" valign="top" height="430">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse">
          <tr>
            <td height="20"><img src="images/transparent.gif" height="20" width="1" alt="" border="0"></td>
          </tr>
          <tr>
            <td height="375" valign="top" align="center"><div class="slideImageHolder">
<? for ($i=0;$i<count($timeline);$i++) { ?>
<img src="<?=$timeline[$i]['image']?>" width="500" height="375" border="0" alt="">
<? } ?>
            </div></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td width="37" align="left" height="54"><a href="javascript:;"><img id="clkPrev" border="0" src="images/tl/arrow_left.jpg" width="30" height="30" alt=""></a></td>
        <td width="686" height="54">            
        <div id="timelineHolder" style="position: relative; width: 686px; overflow: hidden; z-index: 1; background-color: #231f20;">
        <div id="timeline" style="position: relative;">
        <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse; z-index: 1;">
          <tr id="timelineRow">
<? for($i=0;$i<count($timeline);$i++) { ?>
            <td align="center" style="background: url(<?=($i==0?'images/tl/scrollbar_bg2.jpg':($i<count($timeline)-1?'images/tl/scrollbar_bg1.jpg':'images/tl/scrollbar_bg3.jpg'))?>) no-repeat <?=($i==0?'right bottom':($i<count($timeline)-1?'center;':'left bottom'))?>"><div class="clkSlide" rel="<?=$i?>" style="width: 96px; height: 78px;"><div id="div_date<?=$i?>" class="text1" style="padding-top: 7px;"><?=$timeline[$i]['year']?></div></div></td>
<? } ?>                
          </tr>
        </table></div>
        </div>
        <div id="timelineOverlay" style="top: 550px; height: 93px; width: 94px; z-index: 2; position: absolute; background-image: url(images/tl/highlight.png);"></div>
        </td>
        <td width="37" align="right" height="54"><a href="javascript:;"><img id="clkNext" border="0" src="images/tl/arrow_right.jpg" width="30" height="30" alt=""></a></td>
      </tr>
    </table>
  </center>
</div>

</body>

</html>