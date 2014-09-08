<?
//!!DO NOT MODIFY!!
//this is the include file used in all non-function files

include("config.php");
session_start();

include_once($path."/functions/definitions.php");
include_once($path."/functions/functions_connect.php");
include_once($path."/functions/functions_cms.php");
include_once($path."/functions/functions_general.php");
include_once($path."/functions/functions_database.php");
include_once($path."/functions/functions_email.php");
include_once($path."/functions/functions_events.php");
include_once($path."/functions/functions_headstandards.php");
include_once($path."/functions/functions_news.php");
include_once($path."/functions/functions_terminology.php");
include_once($path."/functions/classes/Image.class.inc.php");
include_once($path."/functions/classes/Mailer.class.inc.php");
?>