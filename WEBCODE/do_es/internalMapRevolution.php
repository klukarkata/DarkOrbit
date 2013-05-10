<?php require_once('Connections/DO.php'); ?>
<?php
if (!isset($_SESSION)) {
  @session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

$MM_restrictGoTo = "index.php";
function redireccionar($pagina)
{
  echo "<p>Espere por favor...</p>";
  echo "<script>window.location = '$pagina' </script>";
}
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_POST'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  redireccionar($MM_restrictGoTo);
  exit;
 }

?>
<?php include("includes/head.tpl"); ?>
<?php include("includes/variables.php"); ?>
    <style type="text/css" media="screen">    @import "css/darkorbit.css"; </style>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="js/function.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.4.4.js"></script>
<script type="text/javascript" src="js/jquery.flashembed.js"></script>

<script type="text/javascript" charset="UTF-8">
/* <![CDATA[ */
try { if (undefined == xajax.config) xajax.config = {}; } catch (e) { xajax = {}; xajax.config = {}; };
xajax.config.requestURI = "/xajaxAPI.php?sid=<?php echo session_id(); ?>";
xajax.config.statusMessages = false;
xajax.config.waitCursor = true;
xajax.config.version = "xajax 0.5";
xajax.config.legacy = false;
xajax.config.defaultMode = "asynchronous";
xajax.config.defaultMethod = "POST";
/* ]]> */
</script>
<script type="text/javascript" src="js/xajax_core.js" charset="UTF-8"></script>
<script type="text/javascript" charset="UTF-8">
/* <![CDATA[ */
window.setTimeout(
 function() {
  var scriptExists = false;
  try { if (xajax.isLoaded) scriptExists = true; }
  catch (e) {}
  if (!scriptExists) {
   alert("Error: the xajax Javascript component could not be included. Perhaps the URL is incorrect?\nURL: js/xajax_core.js");
  }
 }, 2000);
/* ]]> */
</script>

<script type='text/javascript' charset='UTF-8'>
/* <![CDATA[ */
xajax_showQuestDetails = function() { return xajax.request( { xjxfun: 'showQuestDetails' }, { parameters: arguments } ); };
xajax_acceptQuest = function() { return xajax.request( { xjxfun: 'acceptQuest' }, { parameters: arguments } ); };
xajax_abortQuest = function() { return xajax.request( { xjxfun: 'abortQuest' }, { parameters: arguments } ); };
xajax_disableTradeLayer = function() { return xajax.request( { xjxfun: 'disableTradeLayer' }, { parameters: arguments } ); };
xajax_saveTempResolution = function() { return xajax.request( { xjxfun: 'saveTempResolution' }, { parameters: arguments } ); };
xajax_clientResolutionChanged = function() { return xajax.request( { xjxfun: 'clientResolutionChanged' }, { parameters: arguments } ); };
xajax_saveOldClientUsage = function() { return xajax.request( { xjxfun: 'saveOldClientUsage' }, { parameters: arguments } ); };
xajax_buySkylabRobot = function() { return xajax.request( { xjxfun: 'buySkylabRobot' }, { parameters: arguments } ); };
xajax_skillTreePurchaseSkillReset = function() { return xajax.request( { xjxfun: 'skillTreePurchaseSkillReset' }, { parameters: arguments } ); };
xajax_skillTreePurchaseLevelUp = function() { return xajax.request( { xjxfun: 'skillTreePurchaseLevelUp' }, { parameters: arguments } ); };
xajax_nanoTechFactoryShowBuff = function() { return xajax.request( { xjxfun: 'nanoTechFactoryShowBuff' }, { parameters: arguments } ); };
xajax_pilotSheet = function() { return xajax.request( { xjxfun: 'pilotSheet' }, { parameters: arguments } ); };
xajax_pilotInvite = function() { return xajax.request( { xjxfun: 'pilotInvite' }, { parameters: arguments } ); };
xajax_pilotInviteIncentives = function() { return xajax.request( { xjxfun: 'pilotInviteIncentives' }, { parameters: arguments } ); };
xajax_tooltipAjaxHandler = function() { return xajax.request( { xjxfun: 'tooltipAjaxHandler' }, { parameters: arguments } ); };
/* ]]> */
</script>



</head>

    <body>
    <div id="container" style="width: {px"></div>

        <iframe src="indexInternal.es?action=internalMapRevolution&dontShow=1" name="reloader" width="0" height="0" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe>





<script type='text/javascript'>
function onFailFlashembed() {
    var inner_html = '<div class="flashFailHead">Instala el Adobe Flash Player</div>\n\
    <div class="flashFailHeadText">Para jugar a DarkOrbit, necesitas el Flash Player m�s actual. �Solo tienes que instalarlo y empezar a jugar!\n\
    <div class="flashFailHeadLink" style="cursor: pointer">Desc�rgate aqu� el Flash Player gratis: <a href=\"http://www.adobe.com/go/getflashplayer\" style=\"text-decoration: underline; color:#A0A0A0;\">Descargar Flash Player<\/a> </div></div>';

    document.getElementById('container').innerHTML = inner_html;
}

function expressInstallCallback(info) {
        // possible values for info: loadTimeOut|Cancelled|Failed
        onFailFlashembed();
}

jQuery(document).ready(
    function(){
        
        flashembed("container", {"src": "spacemap/main.swf","version": [10,0],"expressInstall": "swf_global/expressInstall.swf","width": 1024,"height": 576,"wmode": "window","bgcolor": "#000000","id": "main"}, {"lang": "es","userID": <?php echo $row_Cuenta['id']; ?>,"factionID": "<?php echo $row_Cuenta['empresa']; ?>","sessionID": "<?php echo session_id(); ?>","basePath": "spacemap","pid": 563,"resolutionID": 1,"boardLink": "<?php echo $SERVIDOR; ?>","helpLink": "<?php echo $SERVIDOR; ?>","loadingClaim": "LOADING...\nDark Orbit\nBy ELIEAZ","chatHost": "<?php echo $HOST; ?>","cdn": "<?php echo $SERVIDOR; ?>","useHash": 1,"host": "<?php echo $HOST; ?>","gameXmlHash": "060b9c86992a12a6d343395f64852876","resourcesXmlHash": "4f5d6e23ebb06278f110ba358dde28ec","profileXmlHash": "18287bc38698431e80f7cca05e6df2ca","autoStartEnabled": 0,"mapID": <?php echo $row_Cuenta['mapa']; ?>,"supportedResolutions": "0,1","logConfig": "0,300,4,5","instantLogEnabled": 1,"doubleClickAttackEnabled": 1,"allowChat": 1});
	    
    }
);
</script>

<style>
    #container {
        color: #FFFFFF;
        background : #000000;
	}
</style>

</body>
</html>
