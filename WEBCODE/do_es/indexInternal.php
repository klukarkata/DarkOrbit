 <?php require_once('Connections/DO.php'); ?>
<?php
if (!isset($_SESSION)) {
  @session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {  
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_POST'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
}
?>
<?php
$colname_Cuenta = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Cuenta = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_DO, $DO);
$query_Cuenta = sprintf("SELECT * FROM cuentas WHERE usuario = '%s'", $colname_Cuenta);
$Cuenta = mysql_query($query_Cuenta, $DO) or die(mysql_error());
$row_Cuenta = mysql_fetch_assoc($Cuenta);
$totalRows_Cuenta = mysql_num_rows($Cuenta);
// Variables de sesion
$_SESSION['MM_servidor'] = $row_Cuenta['servidor'];
$_SESSION['MM_rango'] = $row_Cuenta['rango'];
$colname_Servidores = "-1";
if (isset($row_Cuenta['servidor'])) {
  $colname_Servidores = (get_magic_quotes_gpc()) ? $row_Cuenta['servidor'] : addslashes($row_Cuenta['servidor']);
}
mysql_select_db($database_DO, $DO);
$query_Servidores = sprintf("SELECT * FROM servidores WHERE id = %s", $colname_Servidores);
$Servidores = mysql_query($query_Servidores, $DO) or die(mysql_error());
$row_Servidores = mysql_fetch_assoc($Servidores);
$totalRows_Servidores = mysql_num_rows($Servidores);

$colname_Rangos = "-1";
if (isset($row_Cuenta['rango'])) {
  $colname_Rangos = (get_magic_quotes_gpc()) ? $row_Cuenta['rango'] : addslashes($row_Cuenta['rango']);
}
mysql_select_db($database_DO, $DO);
$query_Rangos = sprintf("SELECT * FROM rangos WHERE id = %s", $colname_Rangos);
$Rangos = mysql_query($query_Rangos, $DO) or die(mysql_error());
$row_Rangos = mysql_fetch_assoc($Rangos);
$totalRows_Rangos = mysql_num_rows($Rangos);

$colname_Mapas = "-1";
if (isset($row_Cuenta['mapa'])) {
  $colname_Mapas = (get_magic_quotes_gpc()) ? $row_Cuenta['mapa'] : addslashes($row_Cuenta['mapa']);
}
mysql_select_db($database_DO, $DO);
$query_Mapas = sprintf("SELECT * FROM mapas WHERE mapid = %s", $colname_Mapas);
$Mapas = mysql_query($query_Mapas, $DO) or die(mysql_error());
$row_Mapa = mysql_fetch_assoc($Mapas);
$totalRows_Mapas = mysql_num_rows($Mapas);

$ip = $_SERVER['REMOTE_ADDR'];
$fechaActual = date('Y-m-d');
$updateSQL = sprintf("UPDATE cuentas SET lastIP=%s,ultimaConexion=%s WHERE id=%s",
                       GetSQLValueString($ip, "text"),
                       GetSQLValueString($fechaActual, "text"),
                       GetSQLValueString($row_Cuenta['id'], "int"));
  mysql_select_db($database_DO, $DO);
  $Result1 = mysql_query($updateSQL, $DO) or die(mysql_error());
  
//Sistema de TOP 10 Ranking
mysql_select_db($database_DO, $DO);
function mostrarRanking()
{
    $result = mysql_query("SELECT * FROM cuentas ORDER BY honor DESC LIMIT 0, 10");
    $nombre = "undefined";
    $honor = 0;
    $pos = 0;
    while($rs = mysql_fetch_array($result))
    {    
        if($rs[32] == 21)continue;
        $pos += 1;
        if($rs[1] != null)$nombre = $rs[1];
        if($rs[33] != null)$honor = $rs[33];
        echo "<tr>";
        echo "<td>$pos.</td>";
        echo "<td class='table_ranking_center fliess10px-gelb'><b>$nombre</b></td>";
        echo "<td class='table_ranking_right'>$honor </td>";
        echo "</tr>";
    }
}
?>
<?php 
//Otras variables
if($row_Cuenta['premium'] == 0){
$premium = "No";
}else{
$premium = "Si";
}
//EMPRESAS
if($row_Cuenta['empresa'])
$titulo_empresa = "";
switch($row_Cuenta['empresa'])
{
    case 1:
        $titulo_empresa = "MMO";
    break;
    case 2:
        $titulo_empresa = "EIC";
    break;
    case 3:
        $titulo_empresa = "VRU";
    break;
}
?>
<?php

function r($hp , $DO, $O) {
    if ($hp <= 0) {
        $updateSQL = sprintf("UPDATE cuentas SET hp=1000,escudo=1000 WHERE id=$O");
        $Result1 = mysql_query($updateSQL, $DO) or die('No login, :/"');
        echo "<script type=\"text/javascript\">
           location.href = 'indexInternal.es?action=internalDock&rsucces';
       </script>";
        exit;
    } else {
        echo "<script type=\"text/javascript\">
           location.href = 'indexInternal.es?action=internalDock&rfail';
       </script>";
        exit;
    }
    

    
}
    if (!isset($_GET['action']))
    {
        $_GET['action'] = null;
    }
                  switch($_GET['action']) {
                    case 'internalDock':
                        include("internalDock.php");
                        break;
                    case 'internalMapRevolution':
                        include("internalMapRevolution.php");
                        break;
                    case 'internalDockEquipment':
                        include("internalDockEquipment.php");
                        break;
                    case 'internalPilotSheet':
                        include("internalPilotSheet.php");
                        break;
                    case 'internalHandel':
                        include("internalHandel.php");
                        break;
                    case 'internalClan':
                        include("internalClan2.php");
                        break;
                        case 'internalreparing':
                        r(number_format($row_Cuenta['hp'], 0, ",", ".") , $DO , $row_Cuenta['id']);
                        echo $row_Cuenta['hp'];
                        break;
                    default:

?>
<?php include("includes/head.tpl"); ?>
<?php include("includes/variables.php"); ?>

    <style type="text/css" media="screen">    @import "css/darkorbit.css"; </style>
    <link rel="stylesheet" media="all" href="css/internalStart.css" />
    <link rel="stylesheet" media="all" href="css/window.css" />
    <link rel="stylesheet" media="all" href="css/window_alert.css" />
    <script language="javascript">
    var CDN = "<?php echo $SERVIDOR; ?>";
    </script>
    <script type="text/javascript" src="js/prototype.js"></script>
    <script type="text/javascript" src="js/scriptaculous.js"></script>
    <script type="text/javascript" src="js/do_extensions.js"></script>
    <script type="text/javascript" src="js/window.js"></script>
    <script type="text/javascript" src="js/tooltip.js"></script>
    <script type="text/javascript" src="js/tooltipPilotSheet.js"></script>
    <script type="text/javascript" src="js/livepipe.js"></script>
    <script type="text/javascript" src="js/scrollbar.js"></script>
    <script type="text/javascript" src="js/scroller.js"></script>
    <script type="text/javascript" src="js/customSelect.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="js/custom-form-elements.js"></script>
    <script type="text/javascript" src="js/jquery.flashembed.js"></script>
    <script type="text/javascript" src="js/doExtensions.js"></script>
    <script src="js/function.js" type="text/javascript"></script>
    <script type="text/javascript">jQuery.noConflict();</script>



    <script type="text/javascript">
        // remote scripting library
        // (c) copyright 2005 modernmethod, inc
        
        var sajax_debug_mode = false;
        var sajax_request_type = "POST";
        var sajax_target_id = "";
        var sajax_failure_redirect = "";

        function sajax_debug(text) {
            if (sajax_debug_mode)
                alert(text);
        }

         function sajax_init_object() {
             sajax_debug("sajax_init_object() called..")

             var A;

             var msxmlhttp = new Array(
                'Msxml2.XMLHTTP.5.0',
                'Msxml2.XMLHTTP.4.0',
                'Msxml2.XMLHTTP.3.0',
                'Msxml2.XMLHTTP',
                'Microsoft.XMLHTTP');
            for (var i = 0; i < msxmlhttp.length; i++) {
                try {
                    A = new ActiveXObject(msxmlhttp[i]);
                } catch (e) {
                    A = null;
                }
            }

            if(!A && typeof XMLHttpRequest != "undefined")
                A = new XMLHttpRequest();
            if (!A)
                sajax_debug("Could not create connection object.");
            return A;
        }

        var sajax_requests = new Array();

        function sajax_cancel() {
            for (var i = 0; i < sajax_requests.length; i++)
                sajax_requests[i].abort();
        }

        function sajax_do_call(func_name, args) {
            var i, x, n;
            var uri;
            var post_data;
            var target_id;

            sajax_debug("in sajax_do_call().." + sajax_request_type + "/" + sajax_target_id);
            target_id = sajax_target_id;
            if (typeof(sajax_request_type) == "undefined" || sajax_request_type == "")
                sajax_request_type = "GET";

            uri = "/sajaxAPI.php?sid=<?php echo session_id(); ?>";
            if (sajax_request_type == "GET") {

                if (uri.indexOf("?") == -1)
                    uri += "?rs=" + escape(func_name);
                else
                    uri += "&rs=" + escape(func_name);
                uri += "&rst=" + escape(sajax_target_id);
                uri += "&rsrnd=" + new Date().getTime();

                for (i = 0; i < args.length-1; i++)
                    uri += "&rsargs[]=" + escape(args[i]);

                post_data = null;
            }
            else if (sajax_request_type == "POST") {
                post_data = "rs=" + escape(func_name);
                post_data += "&rst=" + escape(sajax_target_id);
                post_data += "&rsrnd=" + new Date().getTime();

                for (i = 0; i < args.length-1; i++)
                    post_data = post_data + "&rsargs[]=" + escape(args[i]);
            }
            else {
                alert("Illegal request type: " + sajax_request_type);
            }

            x = sajax_init_object();
            if (x == null) {
                if (sajax_failure_redirect != "") {
                    location.href = sajax_failure_redirect;
                    return false;
                } else {
                    sajax_debug("NULL sajax object for user agent:\n" + navigator.userAgent);
                    return false;
                }
            } else {
                x.open(sajax_request_type, uri, true);
                // window.open(uri);

                sajax_requests[sajax_requests.length] = x;

                if (sajax_request_type == "POST") {
                    x.setRequestHeader("Method", "POST " + uri + " HTTP/1.1");
                    x.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                }

                x.onreadystatechange = function() {
                    if (x.readyState != 4)
                        return;

                    sajax_debug("received " + x.responseText);

                    var status;
                    var data;
                    var txt = x.responseText.replace(/^\s*|\s*$/g,"");
                    status = txt.charAt(0);
                    data = txt.substring(2);

                    if (status == "") {
                        // let's just assume this is a pre-response bailout and let it slide for now
                    } else if (status == "-")
                        alert("Error: " + data);
                    else {
                        if (target_id != "")
                            document.getElementById(target_id).innerHTML = eval(data);
                        else {
                            try {
                                var callback;
                                var extra_data = false;
                                if (typeof args[args.length-1] == "object") {
                                    callback = args[args.length-1].callback;
                                    extra_data = args[args.length-1].extra_data;
                                } else {
                                    callback = args[args.length-1];
                                }
                                callback(eval(data), extra_data);
                            } catch (e) {
                                sajax_debug("Caught error " + e + ": Could not eval " + data );
                            }
                        }
                    }
                }
            }

            sajax_debug(func_name + " uri = " + uri + "/post = " + post_data);
            x.send(post_data);
            sajax_debug(func_name + " waiting..");
            delete x;
            return true;
        }

        
        // wrapper for searchUser
        function x_searchUser() {
            sajax_do_call("searchUser",
                x_searchUser.arguments);
        }

        
        // wrapper for getInstances
        function x_getInstances() {
            sajax_do_call("getInstances",
                x_getInstances.arguments);
        }

        
        // wrapper for updateAutoUpdate
        function x_updateAutoUpdate() {
            sajax_do_call("updateAutoUpdate",
                x_updateAutoUpdate.arguments);
        }

        
        // wrapper for changeBookmarkStatus
        function x_changeBookmarkStatus() {
            sajax_do_call("changeBookmarkStatus",
                x_changeBookmarkStatus.arguments);
        }

        
        // wrapper for closeNewsUpdate
        function x_closeNewsUpdate() {
            sajax_do_call("closeNewsUpdate",
                x_closeNewsUpdate.arguments);
        }

        
        // wrapper for closeGuestLayer
        function x_closeGuestLayer() {
            sajax_do_call("closeGuestLayer",
                x_closeGuestLayer.arguments);
        }

        
        // wrapper for changeCash_UK
        function x_changeCash_UK() {
            sajax_do_call("changeCash_UK",
                x_changeCash_UK.arguments);
        }

        </script>
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


    <script src="js/function.js" type="text/javascript"></script>
    <script src="js/base.js" type="text/javascript"></script>

    <script language="javascript">

    var SID='dosid=<?php echo session_id(); ?>';
    var rid = '13036c83bdd87b41f0fe2635a21c4544';
    var errorMsg = 'Por favor, ¡desactiva tu bloqueador de popups!';
    var windowSpacemap = null;

            var playerWantsOldClient = false;
    
    
    var determinedClientResolution = {id: '1', width: 1024, height: 576};

    function openFlashClient(resolution, factionID)
    {
        try {
            if (typeof(window.opener) == 'object' && window.opener.thisIsReal) {
                window.opener.focus();
                return;
            }
        } catch (e) {}

        if(playerWantsOldClient) {
            // open client in old-fashioned way...
            var map = 'internalMap';
        } else {
            // open new client with determined resolution
            resolution = determinedClientResolution;
            var map = 'internalMapRevolution';
        }

        factionString = '';
        if (factionID >= 1 && factionID <= 3) {
            factionString = '&factionID='+factionID;
        }

        var offset = {width: 0, height: 0};

        if(windowSpacemap == null || windowSpacemap.closed) {
            // if there no window with name "windowSpacemap" or its closed, it would be reloaded
            url = 'indexInternal.es?action=' + map + '&' + SID + factionString;
            windowSpacemap = window.open('', 'spacemap', 'width=' + (resolution.width + offset.width) + ',height=' + (resolution.height + offset.height) + ',menubar=no,location=no,status=yes,toolbar=no');
            // if location empty, then load client
            if (windowSpacemap.location.search.length == 0) {
                    // load spacemap (url)
                    windowSpacemap.location = url;
            }
        }
        // focus the spacemap / get it in front
        windowSpacemap.focus();

        //alert('PopUp-Size: ' + String(resolution.width + offset.width) + 'x' + String(resolution.height + offset.height));

        if (!windowSpacemap) {
            alert(translate(errorMsg));
        }
        try {
            windowSpacemap.thisIsReal = true;
            window.opener = windowSpacemap;
        } catch (e) {}
    }
    

    
    function switchOldClientUsage(boolValue)
    {
        playerWantsOldClient = boolValue;
        xajax_saveOldClientUsage((boolValue ? 1 : 0));
    }
    

    
    
    function openMiniMap(wdt, hgt, factionID) {
        // this function is now used as a hook
        // for the old client...
        openFlashClient({id: '-1', width: wdt, height: hgt}, factionID);
    }
    
    </script><script type="text/javascript">if (top.location.host != self.location.host) top.location = self.location;</script><!-- affiliateHeadTag -->

</head>
<body onLoad=""  style="background: #000000 url(do_img/global/background.jpg) no-repeat center top;">

<!-- seitenabdecker -->
<div id="busy_layer"></div>
<!-- seitenabdecker -->



<script type="text/javascript">

function showHelp() {
    showBusyLayer();
    width_x = document.body.offsetWidth;
    container_x = $("helpLayer").getWidth();
    $("helpLayer").style.left = ((width_x/2) - (container_x/2))+"px";
    $("helpLayer").style.top = "150px";
    $("helpLayer").style.display = "block";

}

</script>

<div id="helpLayer" style="position:absolute;width:480px;display:none;z-index:10;" class="fliess11px-grey">
    <div id="popup_standard_headcontainer">
        <div id="popup_standard_headline"><img src="do_img/global/Ayuda_text.gif"></div>
        <div id="popup_standard_close"><a href="javascript:void(0);" onClick="closeLayer('helpLayer');" onFocus="this.blur();"><img src="do_img/global/popups/popup_middle_close.jpg"></a></div>
    </div>
    <div id="popup_standard_content">
        <div id="popup_info_sign_bg" style="background-image:url(do_img/global/popups/infopopup_bg_help.png);">
            <p>
                <strong>¡Hola, piloto espacial!</strong><br />
<br />
Tu viaje en DarkOrbit te lleva a través de galaxias desconocidas llenas de misterios y peligros. La primera norma: ¡No te asustes!<br />
                <br />
Aquí recibes ayuda:
          <ul style="margin:20px 0px;">
                    <li style="margin-left:20px;list-style-type:disc;">La información más importante se encuentra en la <a href=" http://help.bigpoint.com/?project=darkorbit&lang=es_ES&aid=0&aip= " target="_blank" onFocus="this.blur()" style="text-decoration:underline">ayuda</a>. </li>
                    <li style="margin-left:20px;list-style-type:disc;">Encontrarás explicaciones y consejos para facilitarte la entrada en el nuevo cliente del juego en nuestra <a href="http://help.bigpoint.com/?project=darkorbit&site=space_map_new&lang=es" target="_blank" style="text-decoration:underline">guía sobre el nuevo cliente</a>.</li>
          </ul>
                ¿No encuentras ninguna respuesta para tus preguntas? Entonces contacta con nuestro <a href="indexInternal.es?action=support&back=internalStart" target="_blank" onFocus="this.blur()" style="text-decoration:underline">soporte</a>.<br />
                <br />
¡Mucha suerte!
                <br style="margin-bottom: 30px;" />
                
            </p>
        </div>
    </div>
    <div id="popup_standard_content_additionalInfo">

    </div>
    <div id="popup_standard_footercontainer">
        <div id="popup_standard_singleButton">
            <table border="0" cellpadding="0" cellspacing="0" align="center" onClick="closeLayer('helpLayer');">
            <tr>
                <td class="button_resizable_1"></td>
                <td class="button_resizable_2"><img src="do_img/global/ok_text.gif"></td>
                <td class="button_resizable_3"></td>
            </tr>
            </table>
        </div>
    </div>
    <br class="clearMe" />
</div>
<style>

#news {
    position:absolute;
    left:0px;
    top:50px;
    background-position:0 0px;
    text-align:left;
    z-index:10000;
    border:2px solid white;}
#news_head {
    width:680px;height:40px;
    background-image:url(do_img/global/popups/popup2_top_bg.jpg);
    text-align:right;
}
#news_head_date {
    float: left;
    margin: 6px 0 0 10px;
}
#news_content {
    background-image:url(do_img/global/popups/popup2_mid_bg.jpg);
    padding: 20px 35px;
    width: 610px;
    background-repeat: repeat-y;
    height:460px;
    overflow: auto;
}
#news_content li {
    list-style-type: disc;
    margin-left: 15px;
}
* html #news_content {
    width:610px;
}
#news_bottom {
    width:680px;height:49px;
    background-image:url(do_img/global/popups/popup2_bottom_bg.jpg);
    padding-top:15px;
    vertical-align:top;
}
#news_but_close {
    width:160px;height:19px;
    margin:auto;
    text-align:center;
    line-height:19px;
    background-image:url(do_img/global/popups/popup2_button_bg.png);
}


</style>

<div id="news" style="width:680px;display:none;">

    <div id="news_benefitPremium" class="news_container" style="display: none;">
        <div id="news_head">
            <div id="news_head_date" class="fliess11px-weiss">Noticias del 15.04.2011</div>
            <a id="closeButton" href="javascript:void(0);" onClick="closeNews('benefitPremium');" onFocus="this.blur()"><img src="do_img/global/popups/popup2_closebutton.jpg" width="30" height="29"></a>
        </div>


        <div id="news_content" class="fliess11px-weiss">
            <h3>Diversión con ventajas Premium: ¡Todo en uno!</h3>
            <br />
            <p>¿Ya eres jugador Premium? Si la respuesta es no, deberías suscribirte a uno de los paquetes ya: Con ellos disfrutarás de muchos privilegios y siempre le llevarás la delantera a tus enemigos.
<br><br>
Hazte ahora con las innumerables <span class="breakingNewsHighlightBlue"><b>ventajas Premium</b></span>:
<br><br>
<p></p><ul>
<li><span class="breakingNewsHighlightBlue"><b>Desconexión en 5 segundos.</b></span></li>
<li><span class="breakingNewsHighlightBlue"><b>500 unidades más de espacio de carga.</b></span></li>
<li><span class="breakingNewsHighlightBlue"><b>5% de descuento en todos los artículos de Uridium.</b></span></li>
<li><span class="breakingNewsHighlightBlue"><b>Reparación de nave gratuita.</b></span></li>
<li><span class="breakingNewsHighlightBlue"><b>Reparación de VANTS un 50% más barata.</b></span></li>
<li><span class="breakingNewsHighlightBlue"><b>Refinamiento de recursos automático.</b></span></li>
<li><span class="breakingNewsHighlightBlue"><b>Robots de reparación el doble de efectivos.</b></span></li>
<li><span class="breakingNewsHighlightBlue"><b>Acceso a todas las ventajas de la CPU de radar.</b></span></li>
<li><span class="breakingNewsHighlightBlue"><b>Tiempo de carga de misiles reducido a la mitad.</b></span></li>
</ul>
<br>
Hazte ahora jugador Premium: con el <span class="breakingNewsHighlightBlue"><b>paquete de plata durante 6 meses</b></span> o el <span class="breakingNewsHighlightBlue"><b>paquete de oro durante todo un año</b></span>.
<br><br>
Para dirigirte a los paquetes Premium, haz clic en el menú en "Uridium" y luego en "Al área de pagos".
<br><br></p>
            <br />
            <b><a href="indexInternal.es?action=internalPayment">>> Continuar</a></b>        </div>

        <div id="news_bottom" class="fliess11px">

            <div style="float:left;margin-left:16px;"><a href="javascript: showNews('hangarRedesign');"><img src="do_img/global/popups/popup2_but_backward.jpg" width="42" height="20"></a></div>                        <div id="news_but_close"><a href="javascript:void(0);" onClick="closeNews('benefitPremium');" style="display:block;" onFocus="this.blur();"><strong>Cerrar</strong></a></div>


        </div>
    </div>
    <div id="news_hangarRedesign" class="news_container" style="display: none;">
        <div id="news_head">
            <div id="news_head_date" class="fliess11px-weiss">Noticias del 19.05.2011</div>
            <a id="closeButton" href="javascript:void(0);" onClick="closeNews('hangarRedesign');" onFocus="this.blur()"><img src="do_img/global/popups/popup2_closebutton.jpg" width="30" height="29"></a>
        </div>


        <div id="news_content" class="fliess11px-weiss">
            <h3>Tu nuevo hangar: ¡Ahora mejorado!</h3>
            <br />
            <p>Desde ahora, ¡encontrarás en el hangar un montón de <span class="breakingNewsHighlightBlue"><b>magníficas novedades</b></span>! Tanto la <span class="breakingNewsHighlightBlue"><b>tienda</b></span> como la <span class="breakingNewsHighlightBlue"><b>pantalla de equipamiento</b></span> tienen ahora un nuevo e impecable aspecto:
<br><br>
<ul>
<li>Aún más bonito: La <span class="breakingNewsHighlightBlue"><b>nueva apariencia</b></span> hace que los menús tengan ahora más estilo y sean más claros.</li>
<li>Aún más funcional: Descubre <span class="breakingNewsHighlightBlue"><b>nuevas funciones</b></span>, como el nuevo inventario y la nueva posibilidad de filtrar los objetos.</li>
<li>Aún más sencillo: Un <span class="breakingNewsHighlightBlue"><b>manejo mejorado</b></span>, por ejemplo, la función de arrastrar y soltar.</li>
</ul>
<br>
En el futuro, te moverás mucho más rápido en la tienda y en la zona de equipamiento y podrás pasar el tiempo que te ahorres... ¡en el campo de batalla!
<br><br>
Encontrarás todas las novedades <span class="breakingNewsHighlightBlue"><b>desde ahora mismo en el hangar</b></span>.</p>
            <br />
      </div>

        <div id="news_bottom" class="fliess11px">

            <div style="float:left;margin-left:16px;"><a href="javascript: showNews('petSystem');"><img src="do_img/global/popups/popup2_but_backward.jpg" width="42" height="20"></a></div>            <div style="float:right;margin-right:16px;"><a href="javascript: showNews('benefitPremium');"><img src="do_img/global/popups/popup2_but_forward.jpg" width="42" height="20"></a></div>            <div id="news_but_close"><a href="javascript:void(0);" onClick="closeNews('hangarRedesign');" style="display:block;" onFocus="this.blur();"><strong>Cerrar</strong></a></div>


        </div>
    </div>
    <div id="news_petSystem" class="news_container" style="display: none;">
        <div id="news_head">
            <div id="news_head_date" class="fliess11px-weiss">Noticias del 18.05.2011</div>
            <a id="closeButton" href="javascript:void(0);" onClick="closeNews('petSystem');" onFocus="this.blur()"><img src="do_img/global/popups/popup2_closebutton.jpg" width="30" height="29"></a>
        </div>


        <div id="news_content" class="fliess11px-weiss">
            <h3>P.E.T. 10: Tu fiel acompañante</h3>
            <br />
            <p>La revolución en el mercado espacial: La <span class="breakingNewsHighlightBlue"><b>P.E.T. 10</b></span> es independiente y funcional, tanto que te resultará de una gran ayuda. Estará a tu lado durante la batalla y realizará por ti las tareas más engorrosas.<br><br>
Hazte con <span class="breakingNewsHighlightBlue"><b>tu P.E.T. 10 en el hangar</b></span> y disfruta de las siguientes funciones:<br><br>
<img src="do_img/global/layer/petLaunch/pet.png" width="406" height="154" style="margin:10px;" /><br><br><ol>
<li>Equípala con <span class="breakingNewsHighlightBlue"><b>distintas habilidades</b></span>: detección de enemigos, recogida de cajas o proyectil kamikaze.</li>
<li><span class="breakingNewsHighlightBlue"><b>Protocolo de IA</b></span> para un mayor rendimiento: mejor blindaje, más capacidad de carga y más potencia en los láseres.</li>
<li>Tu P.E.T. 10 acumulará puntos de experiencia, <span class="breakingNewsHighlightBlue"><b>subirá de nivel</b></span> y será posible equiparla de mil formas distintas. </li></ol><br><br>
La P.E.T. 10 es <span class="breakingNewsHighlightBlue"><b>la última novedad en cuanto a ayudantes</b></span> de pilotos espaciales. Siempre te echará una mano, te apoyará en la batalla e irá aprendiendo progresivamente.<br><br>
<span class="breakingNewsHighlightBlue"><b>Consíguela ahora en el hangar</b></span>: No te pierdas la P.E.T. 10.<br>
            <br></p>
            <br />
      </div>

        <div id="news_bottom" class="fliess11px">

            <div style="float:left;margin-left:16px;"><a href="javascript: showNews('vengeanceSkillDesigns');"><img src="do_img/global/popups/popup2_but_backward.jpg" width="42" height="20"></a></div>            <div style="float:right;margin-right:16px;"><a href="javascript: showNews('hangarRedesign');"><img src="do_img/global/popups/popup2_but_forward.jpg" width="42" height="20"></a></div>            <div id="news_but_close"><a href="javascript:void(0);" onClick="closeNews('petSystem');" style="display:block;" onFocus="this.blur();"><strong>Cerrar</strong></a></div>


        </div>
    </div>
    <div id="news_vengeanceSkillDesigns" class="news_container" style="display: none;">
        <div id="news_head">
            <div id="news_head_date" class="fliess11px-weiss">Noticias del 23.06.2011</div>
            <a id="closeButton" href="javascript:void(0);" onClick="closeNews('vengeanceSkillDesigns');" onFocus="this.blur()"><img src="do_img/global/popups/popup2_closebutton.jpg" width="30" height="29"></a>
        </div>


        <div id="news_content" class="fliess11px-weiss">
            <h3>3 nuevos diseños para tu Vengeance Starfighter</h3>
            <br />
            <p>¿Necesita tu Vengeance Starfighter un nuevo aspecto? En el hangar y en la página del Uridium, encontrarás ahora <span class="breakingNewsHighlightBlue"><b>3 nuevos diseños</b></span> para esta nave y, además, <span class="breakingNewsHighlightBlue"><b>por primera vez</b></span> tendrás a tu disposición también un <span class="breakingNewsHighlightBlue"><b>diseño de habilidad de Vengeance</b></span>.
<br><br>
Cada diseño te proporciona increíbles ventajas:
<br><br>
<ul>
<li><span class="breakingNewsHighlightBlue"><b>Diseño "Adept"</b></span>: Te proporciona un bono del 10% en todos los puntos de experiencia conseguidos.</li>
<li><span class="breakingNewsHighlightBlue"><b>Diseño "Corsair"</b></span>: Te proporciona un bono del 10% en todos los puntos de honor conseguidos.</li>
<li><span class="breakingNewsHighlightBlue"><b>Diseño "Lightning"</b></span>: Con él, causarás un 5 % más de daños. Este diseño proporciona, además, un aspecto completamente nuevo y la habilidad del postquemador. Úsalo para conseguir una propulsión turbo en tu nave.</li>
</ul>
<br>
¡Hazte ahora con los nuevos diseños! Con ellos, conseguirás una ventaja adicional en la batalla o aprovéchate de ellos para avanzar más rápido en el juego.
<br><br>
<span class="breakingNewsHighlightBlue"><b>Puedes conseguir los tres diseños en el hangar o en la página de Uridium</b></span>.
<br><br></p>
            <br />
            <b><a href="indexInternal.es?action=internalDock&tpl=internalDockShipModel">>> Continuar</a></b>        </div>

        <div id="news_bottom" class="fliess11px">

            <div style="float:left;margin-left:16px;"><a href="javascript: showNews('goliathDesignJade');"><img src="do_img/global/popups/popup2_but_backward.jpg" width="42" height="20"></a></div>            <div style="float:right;margin-right:16px;"><a href="javascript: showNews('petSystem');"><img src="do_img/global/popups/popup2_but_forward.jpg" width="42" height="20"></a></div>            <div id="news_but_close"><a href="javascript:void(0);" onClick="closeNews('vengeanceSkillDesigns');" style="display:block;" onFocus="this.blur();"><strong>Cerrar</strong></a></div>


        </div>
    </div>
    <div id="news_goliathDesignJade" class="news_container" style="display: none;">
        <div id="news_head">
            <div id="news_head_date" class="fliess11px-weiss">Noticias del 20.07.2011</div>
            <a id="closeButton" href="javascript:void(0);" onClick="closeNews('goliathDesignJade');" onFocus="this.blur()"><img src="do_img/global/popups/popup2_closebutton.jpg" width="30" height="29"></a>
        </div>


        <div id="news_content" class="fliess11px-weiss">
            <h3>¡Hola, piloto espacial!</h3>
            <br />
            <p>Como no hay dos sin tres, además de los diseños azul y naranja, ¡tenemos ahora el fantástico <span class="breakingNewsHighlightBlue"><b>diseño Jade verde para tu Goliath</b></span>!
        <br>
        <br>
        Los pilotos con diseños azules y naranjas también lo notarán, ya que se han modificado y ahora tienen un aspecto infinitamente mejorado... ¡también los que ya llevan un tiempo volando por el espacio!<br>
        <br>
        Lo mejor es que te hagas con los 3 diseños de golpe para tu Goliath porque:<br>
        <br>
        <span class="breakingNewsHighlightBlue"><b>Si los compras en un paquete, ¡te llevarás los 3 con un descuento del 33%!</b></span>
        <br>
        <br>
        Los que tengan el bonito diseño Amber o el Sapphire y quieran conseguir toda la colección, tendrán que adquirir los otros por separado.<br<br>
        Aquí te proporcionamos un par de sugerencias y consejos tácticos:<br><br>
        <ol>

        <li>Asocia el color con el diseño de tu empresa.</li>
        <li>Lleva el diseño Jade verde, por ejemplo, en el día de San Patricio; el diseño Amber naranja, en Halloween, o el diseño Sapphire azul el día de tu cumpleaños...
        <li>¿Y si creas un poco de confusión? Solo tienes que ponerte el color de otra empresa...</li>
        </ol>
        <br>
        <br>
        Desde ahora no te quedará mas remedio: Ándate con ojo y aségurate de si el que se esconde tras el diseño es amigo o enemigo... ¡o terminarás muy mal!
        Al comprar uno de los diseños, mantendrás el antiguo y podrás recurrir a él siempre que quieras en el área de equipamiento.<br>
        <br>
        ¡Aprovecha la oportunidad y elige tu color!</p>
            <br />
            <b><a href="indexInternal.es?action=internalDock&tpl=internalDockShipModel">>> Continuar</a></b>        </div>

        <div id="news_bottom" class="fliess11px">

            <div style="float:left;margin-left:16px;"><a href="javascript: showNews('piratesLaunchBattleray');"><img src="do_img/global/popups/popup2_but_backward.jpg" width="42" height="20"></a></div>            <div style="float:right;margin-right:16px;"><a href="javascript: showNews('vengeanceSkillDesigns');"><img src="do_img/global/popups/popup2_but_forward.jpg" width="42" height="20"></a></div>            <div id="news_but_close"><a href="javascript:void(0);" onClick="closeNews('goliathDesignJade');" style="display:block;" onFocus="this.blur();"><strong>Cerrar</strong></a></div>


        </div>
    </div>
    <div id="news_piratesLaunchBattleray" class="news_container" style="display: none;">
        <div id="news_head">
            <div id="news_head_date" class="fliess11px-weiss">Noticias del 10.08.2011</div>
            <a id="closeButton" href="javascript:void(0);" onClick="closeNews('piratesLaunchBattleray');" onFocus="this.blur()"><img src="do_img/global/popups/popup2_closebutton.jpg" width="30" height="29"></a>
        </div>


        <div id="news_content" class="fliess11px-weiss">
            <h3>¡Los Reapers se rinden! ¿O no?</h3>
            <br />
            <p>Los Reapers se están retirando de nuestros sectores. No sabemos lo que has hecho junto al resto de pilotos, pero ha funcionado. Buen trabajo. Pensamos que todos los pilotos espaciales tienen más que merecido tomarse un descanso...
<br><br>
Un momento...
<br><br>
¿Qué es eso? Oh no, no pinta nada bien.<br><br>
Parece que los piratas han extraído hace poco piezas de metal de los cascos de nuestras naves deterioradas o rotas. Se han llevado todo para poder construir una nueva base con estas piezas. Los Reapers ahora pueden usar nuestra tecnología de teleportación contra nosotros e incluso modificarla.<br><br>
Las puertas que utilizan funcionan solo en una dirección. Si penetras en su espacio, primero debes encontrar una puerta con la que poder regresar. Las puertas que conducen a su zona se encuentran en el sector 4-5. Si eres capaz de encontrar una salida allí, irás a parar al sector 4-4.<br><br>
Atención, se ha avistado una nueva nave espacial perteneciente a los piratas:
<br><br>
<span class="breakingNewsHighlightBlue"><b>Nave nodriza, código: "Battleray"</b></span>
<br><br>
<img id="breakingnews_image" src="do_img/global/layer/pirates/ship_5_text.png" width="444" height="133">
<br><br>
La Battleray es la nave más grande y potente de la flota de los Reapers. Actúa como refuerzo para el resto del ejército y como plataforma de partida para naves menores como el Interceptor.<br><br>
La Battleray puede enviar Interceptores en oleadas. Además, también es capaz de repararlos.
    Cuando los Interceptores la están defendiendo, la Battleray usa su energía y es prácticamente invulnerable.<br><br>
Lucha en equipo contra la Battleray. Solo así tendrás alguna oportunidad.<br><br></p>
            <br />
      </div>

        <div id="news_bottom" class="fliess11px">

            <div style="float:left;margin-left:16px;"><a href="javascript: showNews('pirateBooty');"><img src="do_img/global/popups/popup2_but_backward.jpg" width="42" height="20"></a></div>            <div style="float:right;margin-right:16px;"><a href="javascript: showNews('goliathDesignJade');"><img src="do_img/global/popups/popup2_but_forward.jpg" width="42" height="20"></a></div>            <div id="news_but_close"><a href="javascript:void(0);" onClick="closeNews('piratesLaunchBattleray');" style="display:block;" onFocus="this.blur();"><strong>Cerrar</strong></a></div>


        </div>
    </div>
    <div id="news_pirateBooty" class="news_container" style="display: none;">
        <div id="news_head">
            <div id="news_head_date" class="fliess11px-weiss">Noticias del 12.08.2011</div>
            <a id="closeButton" href="javascript:void(0);" onClick="closeNews('pirateBooty');" onFocus="this.blur()"><img src="do_img/global/popups/popup2_closebutton.jpg" width="30" height="29"></a>
        </div>


        <div id="news_content" class="fliess11px-weiss">
            <h3>Edición especial: ¡Los piratas abandonan valiosas cajas de carga en su huida!</h3>
            <br />
            <p>Los piratas han retrocedido hasta su sector y hemos recuperado el control de nuestro sistema estelar.
  <br />
  <br />
  <ul>
  <li>Como los piratas han tenido que retirarse a toda velocidad, en su huida han perdido <span class="breakingNewsHighlightBlue"><b>valiosos cofres con tesoros</b></span>. A diferencia de lo que ocurre con las cajas de carga normales, las cajas de los piratas se abren con una llave que solo puedes conseguir en el hangar.</li>

  <li>Los primeros pilotos que han conseguido abrir las cajas nos han informado sobre su valioso contenido. Parece ser que algunos han descubierto un <span class="breakingNewsHighlightBlue"><b>nuevo láser</b> dentro de las cajas</span>.</li>
</ul>
<br />
Ayúdanos a recoger las cajas de los piratas para impedir que recuperen los valiosos objetos que se esconden en ellas.
  <br /><br />
Los NPC normales tampoco han mostrado recelo alguno a la hora de enfrentarse a los piratas y también quieren hacerse con las cajas. Si destruyes a estos NPC, te asegurarás de que el llamado botín pirata no caiga en las manos equivocadas.<br /></p>
            <br />
            <b><a href="indexInternal.es?action=internalDock&tpl=internalDock&tpl=internalDockSpecials">>> Continuar</a></b>        </div>

        <div id="news_bottom" class="fliess11px">

                        <div style="float:right;margin-right:16px;"><a href="javascript: showNews('piratesLaunchBattleray');"><img src="do_img/global/popups/popup2_but_forward.jpg" width="42" height="20"></a></div>            <div id="news_but_close"><a href="javascript:void(0);" onClick="closeNews('pirateBooty');" style="display:block;" onFocus="this.blur();"><strong>Cerrar</strong></a></div>


        </div>
    </div>

</div>

<script>
var SID='dosid=<?php echo session_id(); ?>';


var win = window;
width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
container_x = $("news").style.width.substr(0, $("news").style.width.length-2);
$("news").style.left = ((width_x/2) - (container_x/2)) - 100 +"px";
$("news").style.top = "50px";

function showNews(newsID) {
    $$('.news_container').each(function(e) { e.hide() } );
    $("news").show();
    $("news_" + newsID).show();
    showBusyLayer();
}
function closeNews(newsID) {
    $("news").hide();
    hideBusyLayer();
}


</script>
                                           <script type="text/javascript">

function openExternal (address) {
    var external = window.open(address.replace(/\+/g,"%2B"), "paymentglobal", "width=840,height=680,left=100,top=200");
    external.focus();
}

</script>
<div id="percentBoosterEvent" class="fliess11px-weiss" style="display:none;position:absolute;z-index:20;width:480px;height:600px;background-image:url(do_img/global/actions/50_percent.jpg);">
    <div id="percentBoosterEvent_layer_close" onClick="closeLayer('percentBoosterEvent')"></div>
    <div id="percentBoosterEvent_layer_content" onClick="closeLayer('percentBoosterEvent')">
    <strong>¡Bienvenid@! a DO Piloto espacial.</strong><br /><br />
CADA DIA QUE TE ENTRES EN DO RECIBE EN EL JUEGO:<br />
<ul>
<li>50% más de puntos de experiencia.</li>
<li>50% más de puntos de honor.</li>
<li>50% más de créditos</li>
<li>50% más de uridium</li>
<li>Y un 50% más de jackpot para desbloquear fantásticos premios*</li>
</ul><br />
*Nota: Por cada 1 de jackpot recibes 1000 de uridium</div>
</div>


<script>

showBusyLayer();
Element.Center($('percentBoosterEvent'), $('main'), 35);
$("percentBoosterEvent").show();

function schliessen(layerID) {
    $(layerID).hide();
    hideBusyLayer();
}

</script>                                                   <!-- affiliateStartTag -->
<!-- Login Tag (209) --> 

<table style="border-collapse:collapse;margin:0 auto;">
<tr>
    <td style="vertical-align:top;text-align:left;">


    <div id="topnav">
        <div class="fliess11px-gelb">
          <div id="header_container" style="width:860px; height:230px;">
              
</div>
                                                <a href="javascript:void(0)" onClick="window.blur(); window.focus(); openMiniMap(820,653,0);"><div class="button-map"><br /></div></a>                                    </div>
      </div>

<?php
$onuser = include("usuariosonline.php");

?>

<script type='text/javascript'>
function onFailFlashembed() {
    var inner_html = '<div class="flashFailHead">Instala el Adobe Flash Player</div>\n\
    <div class="flashFailHeadText">Para jugar a DarkOrbit, necesitas el Flash Player más actual. ¡Solo tienes que instalarlo y empezar a jugar!\n\
    <div class="flashFailHeadLink" style="cursor: pointer">Descárgate aquí el Flash Player gratis: <a href=\"http://www.adobe.com/go/getflashplayer\" style=\"text-decoration: underline; color:#A0A0A0;\">Descargar Flash Player<\/a> </div></div>';
    
    document.getElementById('header_container').innerHTML = inner_html;
}

function expressInstallCallback(info) {
        // possible values for info: loadTimeOut|Cancelled|Failed
        onFailFlashembed();
}
jQuery(document).ready(
    function(){
        
             flashembed("header_container", {"src": "swf_global/header.swf?lang=es&langCode=es","version": [10,0],"expressInstall": "swf_global/expressInstall.swf","width": 860,"height": 229,"wmode": "opaque","id": "flashHeader","onFail": function(){onFailFlashembed();}}, {"cdn": "<?php echo $SERVIDOR; ?>","nosid": "1","isGuestUser": "","navPoint": 1,"uid": "<?php formatoUID($row_Cuenta['id']); ?>","rank": 3436,"lvl": "<?php echo $row_Cuenta['nivel']; ?>","xp": "<?php echo number_format($row_Cuenta['experiencia'], 0, ",", "."); ?>","cred": "<?php echo number_format($row_Cuenta['creditos'], 0, ",", "."); ?>","xcred": "<?php echo number_format($row_Cuenta['uridium'], 0, ",", "."); ?>","jackpot": "<?php echo number_format($row_Cuenta['jackpot'], 2, ",", "."); ?>","premium": "<?php echo $row_Cuenta['premium']; ?>","aid": "0","ship_id": "<?php echo $row_Cuenta['gfx']; ?>","repair": "0","eventItemEnabled": "","supporturl": "indexInternal.es%3Faction%3Dsupport%26back%3DinternalStart","ouser": "<?php echo $onuser; ?>","uridium_highlighted": "","serverdesc": "España 1","server_code": 1,"lang": "es","coBrandImgUrl": "","coBrandHref": "","customSkinURL": "swf_global/skin/defecto.png"});
        
    }
);
</script>







<script>

function showPopup(id) {
    showBusyLayer();

    var win = window;
    width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
    container_x = document.getElementById(id).style.width.substr(0,document.getElementById(id).style.width.length-2);
    document.getElementById(id).style.left = ((width_x/2) - (container_x/2))+"px";
    document.getElementById(id).style.top = "100px";
    document.getElementById(id).style.display = 'block';
}

function closePopup(id) {
    hideBusyLayer();
    document.getElementById(id).style.display = 'none';
}

function changeTeaser(show, hide) {
    $(show+'_teaser').style.backgroundImage = 'url(do_img/global/left/button_active.png)';
    $(show).style.display = "block";
    $(hide+'_teaser').style.backgroundImage = 'url(do_img/global/left/button_normal.png)';
    $(hide).style.display = "none";
}
function changeCompetitionTab(type, numberOfTabs) {
    $$('.competitionContent').each(Element.hide);
    $('competitionContent_' + type).show();
}



</script>



<div id="content">
    <!-- Navigation -->
    <div id="nav" style="text-align:right;">

        
                    
            
            

            
            

            



 <?php
//Crear una array con las distintas imagenes
$imagenes[0]='do_img/global/teaser/left_start_01.jpg';
$imagenes[1]='do_img/global/teaser/left_start_02.jpg';
$imagenes[2]='do_img/global/teaser/left_start_03.jpg';
$imagenes[3]='do_img/global/teaser/left_start_04.jpg';
$imagenes[4]='do_img/global/teaser/left_start_05.jpg';
$imagenes[5]='do_img/global/teaser/left_start_06.jpg';
$imagenes[6]='do_img/global/teaser/left_start_07.jpg';
$imagenes[7]='do_img/global/teaser/left_start_08.jpg';
$imagenes[8]='do_img/global/teaser/left_start_09.jpg';
$imagenes[9]='do_img/global/teaser/left_start_10.jpg';
$imagenes[10]='do_img/global/teaser/left_start_11.jpg';
// Elegimos un valor entre 0 y 10
$i=rand(0,10);
?>     
<div id="teaser_left" style="background-image: url(<?php echo $imagenes[$i];?>);"></div>
        </div>
        <!-- Ende Navigation -->
        <!-- Content -->
        <div id="mainContentStart" class="fliess11px-gelb" style="background-image: url(do_img/global/bg_start.jpg);">
          <div id="breakingNewsContainer" style="background-image: url(do_img/global/events/benefitPremium.gif);">
            <div class="breakingNewsTitleContainer">
              <div class="breakingNewsTitle">--- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! --- Diversión con ventajas Premium: ¡Todo en uno! ---</div>
            </div>
          </div>
          <input name="hidden" type="hidden" id="currentIconID" value="pirateBooty" />
          <div id="breakingNewsContainerFrame" onClick="showNews('pirateBooty');"></div>
          <div id="breakingNewsIconContainer">
            <div class="breakingNewsIcon" id="breakingNewsIcon1" onMouseOver="breakingNews.over(1);" onMouseOut="breakingNews.out();" onClick="showNews('benefitPremium');" style="margin-right: 8px; background-image: url(do_img/global/events/icons/benefitPremium.gif);"></div>
            <div class="breakingNewsIcon" id="breakingNewsIcon2" onMouseOver="breakingNews.over(2);" onMouseOut="breakingNews.out();" onClick="showNews('hangarRedesign');" style="margin-right: 8px; background-image: url(do_img/global/events/icons/hangarRedesign.gif);"></div>
            <div class="breakingNewsIcon" id="breakingNewsIcon3" onMouseOver="breakingNews.over(3);" onMouseOut="breakingNews.out();" onClick="showNews('petSystem');" style="margin-right: 8px; background-image: url(do_img/global/events/icons/petSystem.gif);"></div>
            <div class="breakingNewsIcon" id="breakingNewsIcon4" onMouseOver="breakingNews.over(4);" onMouseOut="breakingNews.out();" onClick="showNews('vengeanceSkillDesigns');" style="margin-right: 8px; background-image: url(do_img/global/events/icons/vengeanceSkillDesigns.gif);"></div>
            <div class="breakingNewsIcon" id="breakingNewsIcon5" onMouseOver="breakingNews.over(5);" onMouseOut="breakingNews.out();" onClick="showNews('goliathDesignJade');" style="margin-right: 8px; background-image: url(do_img/global/events/icons/goliathDesignJade.gif);"></div>
            <div class="breakingNewsIcon" id="breakingNewsIcon6" onMouseOver="breakingNews.over(6);" onMouseOut="breakingNews.out();" onClick="showNews('piratesLaunchBattleray');" style="margin-right: 8px; background-image: url(do_img/global/events/icons/piratesLaunchBattleray.gif);"></div>
            <div class="breakingNewsIcon" id="breakingNewsIcon7" onMouseOver="breakingNews.over(7);" onMouseOut="breakingNews.out();" onClick="showNews('pirateBooty');" style="margin-right: 8px; background-image: url(do_img/global/events/icons/pirateBooty.gif);"></div>
          </div>
          <script type="text/javascript">
            var breakingNews = new BreakingNews();
            breakingNews.setMaxIconID(7);
            breakingNews.setKeys(new Array('benefitPremium', 'hangarRedesign', 'petSystem', 'vengeanceSkillDesigns', 'goliathDesignJade', 'piratesLaunchBattleray', 'pirateBooty'));
            breakingNews.setImages(new Array('benefitPremium.gif', 'hangarRedesign.gif', 'petSystem.gif', 'vengeanceSkillDesigns.gif', 'goliathDesignJade.gif', 'piratesLaunchBattleray.gif', 'pirateBooty.gif'));
            breakingNews.setTitles(new Array('Diversión con ventajas Premium: ¡Todo en uno!', 'Tu nuevo hangar: ¡Ahora mejorado!', 'P.E.T. 10: Tu fiel acompañante', '3 nuevos diseños para tu Vengeance Starfighter', '¡Hola, piloto espacial!', '¡Los Reapers se rinden! ¿O no?', 'Edición especial: ¡Los piratas abandonan valiosas cajas de carga en su huida!'));
            breakingNews.setLinks(new Array('action=internalPayment', '', '', 'action=internalDock&tpl=internalDockShipModel', 'action=internalDock&tpl=internalDockShipModel', '', 'action=internalDock&tpl=internalDock&tpl=internalDockSpecials'));
            breakingNews.setDurations(new Array('5', '5', '5', '7', '5', '5', '5'));
            breakingNews.init();
            breakingNews.start();
            </script>
          <table id="mainContentTable">
            <tr>
              <td id="mainContentTable_left"><br /></td>
              <td id="mainContentTable_center"></td>
              <td id="mainContentTable_right"><br /></td>
            </tr>
            <tr>
              <td id="startRow1"><br /></td>
              <td id="cell_news"></td>
              <td id="cell_userInfo"><div class="userInfo_left fliess10px-white">Usuario:</div>
                  <div class="userInfo_right"><?php echo htmlentities($row_Cuenta['usuario']); ?></div>
                <br class="clearMe" />
                  <div class="userInfo_left fliess10px-white">Servidor:</div>
                <div class="userInfo_right"><?php echo htmlentities($row_Servidores['nombre']); ?></div>
                <br class="clearMe" />
                  <div class="userInfo_left fliess10px-white">Rango:</div>
                <div class="userInfo_right"><img src="do_img/global/ranks/rank_<?php echo $row_Cuenta['rango']; ?>.gif" style="vertical-align: baseline;"> <?php echo htmlentities($row_Rangos['nombre']); ?></div>
                <br class="clearMe" />
                  <div class="userInfo_left fliess10px-white">Premium:</div>
                <div class="userInfo_right"><?php echo $premium; ?></div>
                <br class="clearMe" />
                  <div class="userInfo_left fliess10px-white">Nivel:</div>
                <div class="userInfo_right"><?php echo $row_Cuenta['nivel']; ?></div>
                <br class="clearMe" />
                  <div class="userInfo_left fliess10px-white">Empresa:</div>
                <div class="userInfo_right"><?php echo $titulo_empresa ?></div>
                <br class="clearMe" />
                  <div class="userInfo_left fliess10px-white">Posición actual:</div>
                <div class="userInfo_right"><?php echo $row_Mapa['name']; ?></div>
                <br class="clearMe" />
                  <div class="userInfo_left fliess10px-white">Usuario desde:</div>
                <div class="userInfo_right"><?php echo $row_Cuenta['fecha_creacion']; ?></div>
                <br class="clearMe" />
                  <div class="userInfo_center"><a href="indexInternal.es?action=internalUserDataChange" onFocus="this.blur()"><u>Cambiar datos de usuario</u></a> | <a href="doLogout.php?doLogout=true">Logout</a> </div></td>
            </tr>
            <tr>
              <td><br /></td>
              <td><div id="div_ranking">
                  <table id="table_ranking" class="fliess10px-white">
                    <tr>
                        <?php mostrarRanking(); ?>
                    <tr>
                      <td colspan="3" class="hof_center"></td>
                    </tr>
                  </table>
              </div></td>
              <td><table id="table_history" class="fliess10px-white">
                  <tr>
                    <td><div id="text_history" class="fliess10px-white scrollbars">
                      <p>
                          <?php echo $fechaActual; ?>  <?php echo date('H:i'); ?>
                          <br />
                        Hi, Welcome to Darkorbit by neor1326<br />
                        Visit Developer Zone <a href="http://mycom69.tk">MYCOM69 DEV</a><br />
                        <br />
                    </div></td>
                  </tr>
                  <tr>
                    <td class="history_center"><a href="indexInternal.es?action=internalHistory" onFocus="this.blur()" class="fliess10px-gelb"><u>Diario completo</u></a></td>
                  </tr>
              </table></td>
            </tr>
          </table>
        </div>
        <!-- Ende Content -->
</div></td>
    <td style="vertical-align:top;" rowspan="2" width="160px"></td>
</tr>
<tr>
    <td style="text-align:left;">&nbsp;</td>
</tr>
</table>



<script>
</script>



</body>
</html>
<?php
                        break;
             }
          ?>
<?php
mysql_free_result($Cuenta);
mysql_free_result($Servidores);
mysql_free_result($Rangos);
mysql_free_result($Mapas);
?> 