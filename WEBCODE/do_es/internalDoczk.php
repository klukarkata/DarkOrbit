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
    <link rel="stylesheet" media="all" href="css/internalDock.css" />
    <link rel="stylesheet" media="all" href="css/window.css" />
    <link rel="stylesheet" media="all" href="css/window_alert.css" />
    
            <script language="javascript">
    var CDN = "<?php echo $SERVIDOR; ?>";
	window.name = "do_webpage";
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

            uri = "/sajaxAPI.php?sid=5237cd13d7d948e038d18251458785f0";
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
xajax.config.requestURI = "/xajaxAPI.php?sid=5237cd13d7d948e038d18251458785f0";
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

    var SID='dosid=5237cd13d7d948e038d18251458785f0';
    var rid = '58e9ac17e8ccfce7f00934a5733c93ed';
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
<!-- affiliateStartTag -->


<table style="border-collapse:collapse;margin:0 auto;">
<tr>
    <td style="vertical-align:top;text-align:left;">


    <div id="topnav">
        <div class="fliess11px-gelb">
                                                
            <div id="header_container" style="width:860px; height:230px;">            </div>
                                                <a href="javascript:void(0)" onClick="window.blur(); window.focus(); openMiniMap(820,653,0);"><div class="button-map"><br /></div></a>                                    </div>
            </div>


<script type='text/javascript'>
function onFailFlashembed() {
    var inner_html = '<div class="flashFailHead">Instala el Adobe Flash Player</div>\n\
    <div class="flashFailHeadText">Para jugar a DarkOrbit, necesitas el Flash Player más actual. ¡Solo tienes que instalarlo y empezar a jugar!\n\
    <div class="flashFailHeadLink" style="cursor: pointer">Descárgate aquí el Flash Player gratis: <a href=\"http://www.adobe.com/go/getflashplayer\" style=\"text-decoration: underline; color:#A0A0A0;\">Descargar Flash Player<\/a> </div></div>';

    if(!document.getElementById('flashHeader')){
        document.getElementById('header_container').innerHTML = inner_html;
        document.getElementById('equipment_container').innerHTML = "";
        document.getElementById('materialiser').innerHTML = "";
    }

    if(document.getElementById('inventory')){
        document.getElementById('equipment_container').innerHTML = inner_html;
    }

    if(document.getElementById('flashGG')){
        document.getElementById('materialiser').innerHTML = inner_html;
        jQuery('#materialiser').css('margin-left', 110);
        jQuery('#materialiser').css('margin-top', 40);
    }
}

function expressInstallCallback(info) {
        // possible values for info: loadTimeOut|Cancelled|Failed
        onFailFlashembed();
}
jQuery(document).ready(
    function(){
        
	         flashembed("header_container", {"src": "swf_global/header.swf?lang=es&langCode=es","version": [10,0],"expressInstall": "swf_global/expressInstall.swf","width": 860,"height": 229,"wmode": "opaque","id": "flashHeader","onFail": function(){onFailFlashembed();}}, {"cdn": "<?php echo $SERVIDOR; ?>","nosid": "1","isGuestUser": "","navPoint": 1,"uid": "<?php formatoUID($row_Cuenta['id']); ?>","rank": 3436,"lvl": "<?php echo $row_Cuenta['nivel']; ?>","xp": "<?php echo number_format($row_Cuenta['experiencia'], 0, ",", "."); ?>","cred": "<?php echo number_format($row_Cuenta['creditos'], 0, ",", "."); ?>","xcred": "<?php echo number_format($row_Cuenta['uridium'], 0, ",", "."); ?>","jackpot": "<?php echo number_format($row_Cuenta['jackpot'], 2, ",", "."); ?>","premium": "<?php echo $row_Cuenta['premium']; ?>","aid": "0","ship_id": <?php echo $row_Cuenta['gfx']; ?>,"repair": "0","eventItemEnabled": "","supporturl": "indexInternal.es%3Faction%3Dsupport%26back%3DinternalStart","ouser": <?php include("usuariosonline.php"); ?>,"uridium_highlighted": "","serverdesc": "España 1","server_code": 1,"lang": "es","coBrandImgUrl": "","coBrandHref": "","customSkinURL": "swf_global/skin/defecto.png"});
        
    }
);
</script>


<script>


function changeView(category) {
    if (category == "ship") {
        jQuery('#infoBox_ship').css('display', 'block');
        jQuery('#infoBox_shipView').css('display', 'block');
        jQuery('#infoBox_drones').css('display', 'none');
        jQuery('#infoBox_droneView').css('display', 'none');
        jQuery('#nav_drones').css('display', 'none');
        jQuery('#infoBox_pet').css('display', 'none');
        jQuery('#infoBox_petView').css('display', 'none');
        if (jQuery('#repair_pet').length != 0) {
            jQuery('#repair_pet').css('display', 'none');
        }
        if (jQuery('#repair_ship').length != 0) {
            jQuery('#repair_ship').css('display', 'block');
        }
        jQuery('#overview_button_ship').attr('class', 'overview_button_active  fliess10px-gelb');
        jQuery('#overview_button_drones').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_button_pet').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_container').css('backgroundImage', 'url(do_img/global/hangar/overview/bg_ship.jpg)');
    } else if (category == "drone"){
        jQuery('#infoBox_ship').css('display', 'none');
        jQuery('#infoBox_shipView').css('display', 'none');
        jQuery('#infoBox_drones').css('display', 'block');
        jQuery('#infoBox_droneView').css('display', 'block');
        jQuery('#nav_drones').css('display', 'block');
        jQuery('#infoBox_pet').css('display', 'none');
        jQuery('#infoBox_petView').css('display', 'none');
        if (jQuery('#repair_pet').length != 0) {
            jQuery('#repair_pet').css('display', 'none');
        }
        if (jQuery('#repair_ship').length != 0) {
            jQuery('#repair_ship').css('display', 'none');
        }
        jQuery('#overview_button_ship').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_button_drones').attr('class', 'overview_button_active  fliess10px-gelb');
        jQuery('#overview_button_pet').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_container').css('backgroundImage', 'url(do_img/global/hangar/overview/bg_drone.jpg)');
    } else {
        jQuery('#infoBox_ship').css('display', 'none');
        jQuery('#infoBox_shipView').css('display', 'none');
        jQuery('#infoBox_drones').css('display', 'none');
        jQuery('#infoBox_droneView').css('display', 'none');
        jQuery('#infoBox_pet').css('display', 'block');
        jQuery('#infoBox_petView').css('display', 'block');
        if (jQuery('#repair_pet').length != 0) {
        jQuery('#repair_pet').css('display', 'block');
        }
        if (jQuery('#repair_ship').length != 0) {
        jQuery('#repair_ship').css('display', 'none');
        }
        jQuery('#nav_drones').css('display', 'none');
        jQuery('#overview_button_ship').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_button_drones').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_button_pet').attr('class', 'overview_button_active  fliess10px-gelb');
        jQuery('#overview_container').css('backgroundImage', ' url(do_img/global/hangar/overview/bg_pet.jpg)');
    }
}

function clearDroneView (howmuch) {
    for(i = 1; i <= howmuch; i++) {
        $('drone_'+i).style.display      = 'none';
    }
    $('droneView_start').style.display = 'none';
    $('droneView_middle').style.display = 'none';
    $('droneView_end').style.display = 'none';

}

var droneView = 1;
var maxDroneView = 2;

function changeDroneView(nextView, maxView) {
    clearDroneView(maxView);
    $('droneView_middle').style.display      = 'block';

    if (nextView == "next" && droneView+1 < maxView) {
        droneView = droneView + 1;
        $('drone_'+(droneView)).style.display      = 'block';
        //$('droneView_middle').style.display      = 'block';
    } else if (nextView == 'next' && droneView+1 >= maxView) {
        droneView = droneView+1;
        $('drone_'+droneView).style.display      = 'block';
        //$('droneView_end').style.display      = 'block';
    } else if (nextView == 'previous' && droneView-1 > 1) {
        droneView = droneView - 1;
        $('drone_'+droneView).style.display      = 'block';
        //$('droneView_middle').style.display      = 'block';
    } else {
        droneView = 1;
        $('drone_'+droneView).style.display      = 'block';
        //$('droneView_start').style.display      = 'block';
    }
}

jQuery(document).ready(function() {
    function toggleDroneNavigation(page) {
        if (page > maxDroneView) {
            return;
        }

        droneView = page;

        if (page == 1) {
            jQuery('#dronePrev').css( 'backgroundPosition', '0px 0px');
            jQuery('#droneNext').css( 'backgroundPosition', '-25px 25px');
        } else if(page > 1 && page < maxDroneView) {
            jQuery('#dronePrev').css( 'backgroundPosition', '-25px 0px');
            jQuery('#droneNext').css( 'backgroundPosition', '-25px 25px');
        } else if (page == maxDroneView) {
            jQuery('#dronePrev').css( 'backgroundPosition', '-25px 0px');
            jQuery('#droneNext').css( 'backgroundPosition', '0px 25px');
        }

        for (i = 1; i <= maxDroneView; i++) {
            jQuery('#drone_' + i).css( 'display', 'none');
        }

        jQuery('#drone_' + page).css( 'display', 'block');

    }

    toggleDroneNavigation(1);

    jQuery('#dronePrev').mouseover(function() {
        if (droneView > 1) {
            jQuery('#dronePrev').css( 'backgroundPosition', '-50px 0px');
        }
    }).mouseout(function() {
        if (droneView > 1) {
            jQuery('#dronePrev').css( 'backgroundPosition', '-25px 0px');
        }
    }).click(function() {
        if (droneView > 1) {
            toggleDroneNavigation(droneView - 1);
        }
    });

    jQuery('#droneNext').mouseover(function() {
        if (droneView < maxDroneView) {
            jQuery('#droneNext').css( 'backgroundPosition', '-50px 25px');
        }
    }).mouseout(function() {
        if (droneView < maxDroneView) {
            jQuery('#droneNext').css( 'backgroundPosition', '-25px 25px');
        }
    }).click(function() {
        if (droneView < maxDroneView) {
            toggleDroneNavigation(droneView + 1);
        }
    });


});

</script>

<div style="display:none;">
    <img src="do_img/global/resumen_text_black.gif" />
    <img src="do_img/global/resumen_text_white.gif" />
    <img src="do_img/global/equipamiento_text_black.gif" />
    <img src="do_img/global/equipamiento_text_white.gif" />
    <img src="do_img/global/tienda_text_black.gif" />
    <img src="do_img/global/tienda_text_white.gif" /></div>

<div id="dock_content">
    <style type="text/css" media="screen">    @import "http://darkorbit.l3.cdn.bigpoint.net/css/cdn/includeNavigation.css?__cv=95893d4b719626148a6ccf11c71e4c00";</style>
<style  type="text/css">

.tabLabelOverviewActive {
    background-image: url(do_img/global/resumen_text_black.gif);
}
.tabLabelOverviewInActive {
    background-image: url(do_img/global/resumen_text_white.gif);
}
.tabLabelEquipmentActive {
    background-image: url(do_img/global/equipamiento_text_black.gif);
}
.tabLabelEquipmentInActive {
    background-image: url(do_img/global/equipamiento_text_white.gif);
}
.tabLabelShopActive {
    background-image: url(do_img/global/tienda_text_black.gif);
}
.tabLabelShopInActive {
    background-image: url(do_img/global/tienda_text_white.gif);
}

</style>
<script type="text/javascript">

function setActiveTab(category) {
    if (category == "internalDockEquipment2") {
         $('tabButton2').className = 'tabButtonActive';
         $('tabLabel2').className = 'tabLabelActive tabLabelEquipmentActive';

         $('tabButton1').className = 'tabButtonInActive';
         $('tabLabel1').className = 'tabLabelInActive tabLabelOverviewInActive';

         $('tabButton3').className = 'tabButtonInActive';
         $('tabLabel3').className = 'tabLabelInActive tabLabelShopInActive';
    } else if (category == "internalDockEquipment") {
         $('tabButton2').className = 'tabButtonActive';
         $('tabLabel2').className = 'tabLabelActive tabLabelEquipmentActive';

         $('tabButton1').className = 'tabButtonInActive';
         $('tabLabel1').className = 'tabLabelInActive tabLabelOverviewInActive';

         $('tabButton3').className = 'tabButtonInActive';
         $('tabLabel3').className = 'tabLabelInActive tabLabelShopInActive';
    } else if (category == "internalDock") {
         $('tabButton1').className = 'tabButtonActive';
         $('tabLabel1').className = 'tabLabelActive tabLabelOverviewActive';

         $('tabButton2').className = 'tabButtonInActive';
         $('tabLabel2').className = 'tabLabelInActive  tabLabelEquipmentInActive';

         $('tabButton3').className = 'tabButtonInActive';
         $('tabLabel3').className = 'tabLabelInActive tabLabelShopInActive';
    } else {
         $('tabButton3').className = 'tabButtonActive';
         $('tabLabel3').className = 'tabLabelActive tabLabelShopActive';

         $('tabButton2').className = 'tabButtonInActive';
         $('tabLabel2').className = 'tabLabelInActive  tabLabelEquipmentInActive';

         $('tabButton1').className = 'tabButtonInActive';
         $('tabLabel1').className = 'tabLabelInActive  tabLabelOverviewInActive';
    }
}

</script>

<div id="subNav_container">
    <div id="tabButton1" class="tabButtonInActive"
        onmouseover="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
        onmouseout="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
        onclick="redirect('?action=internalDock');"
        style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel1" class="tabLabelInActive tabLabelOverviewInActive"></div>
    </div>
    <div id="tabButton2" class="tabButtonInActive"
        onmouseover="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
        onmouseout="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
        onclick="redirect('?action=internalDockEquipment');"
        style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel2" class="tabLabelInActive tabLabelEquipmentInActive"></div>
    </div>
    <div id="tabButton3" class="tabButtonInActive"
        onmouseover="buttonHandler.toggleButtons('tabButton3', 'tabButton', 'tabLabel3', 'tabLabel')"
        onmouseout="buttonHandler.toggleButtons('tabButton3', 'tabButton', 'tabLabel3', 'tabLabel')"
        onclick="redirect('?action=internalDockShips');"
        style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel3" class="tabLabelInActive tabLabelShopInActive"></div>
    </div>
</div>
<script type="text/javascript">
    setActiveTab('internalDock');
</script>
<br><br>
    <div id="dock_container">
        <div id="overview_container" class="overview_image">
            <div id="overview_navigation" class="overview_seperator">
                <div class="overview_button_active fliess10px-gelb" id="overview_button_ship" onClick="changeView('ship');"><div style="background-image:  url(do_img/global/nave_text_white.gif); background-repeat: no-repeat;width: 94px; height: 23px;margin: 7px 30px;"></div></div>
                <div class="overview_button_inactive fliess10px-weiss" id="overview_button_drones" onClick="changeView('drone');"><div style="background-image:  url(do_img/global/vants_text_white.gif); background-repeat: no-repeat;width: 94px; height: 23px;margin: 7px 25px;"></div></div>
                <div class="overview_button_inactive fliess10px-weiss" id="overview_button_pet" onClick="changeView('pet');"><div style="background-image:  url(do_img/global/pet_text_white.gif); background-repeat: no-repeat;width: 94px; height: 23px;margin: 7px 30px;"></div></div>
                <br class="clearMe" />
            </div>
            <div id="overview_background">
                <div id="overview_content">
                    <div class="infoBox infoBox_ship fliess10px-weiss" id="infoBox_ship">
                        <table class="overview_table" cellpadding="1" cellspacing="0">
                            <tr class="overview_line_highlight">
                                <td class="labels">Puntos de vida</td>
                                <td class="values"><?php echo number_format($row_Cuenta['hp'], 0, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td class="labels">PV máx.</td>
                                <td class="values"><?php echo number_format(($row_Cuenta['hpMax'])*2, 0, ",", "."); ?></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Bonos de reparación</td>
                                <td class="values"><?php echo $row_Cuenta['bono_reparacion']; ?></td>
                            </tr>
                            <tr>
                                <td class="labels">Bonos de teleportación</td>
                                <td class="values"><?php echo $row_Cuenta['bono_teleportacion']; ?></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Llaves de botín</td>
                                <td class="values"><?php echo $row_Cuenta['llaves']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockLaser">Láser</a></td>
                                <td class="values">31</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockAmmo">Munición láser</a></td>
                                <?php
									$municionLaser = 0;
									$mun1 = split("\\|", $row_Cuenta['mun1']);
									$municionLaser = $mun1[0]+$mun1[1]+$mun1[2]+$mun1[3]+$mun1[4]+$mun1[5];
									//number_format($municionLaser, 0, ",", ".");
								?>
								<td class="values"><?php echo number_format($municionLaser, 0, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockAmmo">Misiles</a></td>
                                 <?php
									$municionMisil = 0;
									$mun2 = split("\\|", $row_Cuenta['mun2']);
									$municionMisil = $mun2[0]+$mun2[1]+$mun2[2]+$mun2[3]+$mun2[4]+$mun2[5]+$mun2[6]+$mun2[7]+$mun2[8]+$mun2[9]+$mun2[10]+
									$mun2[11]+$mun2[12]+$mun2[13];
								?>
								<td class="values"><?php echo number_format($municionMisil, 0, ",", "."); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Generadores de motor</a></td>
                                <td class="values">0</td>
                            </tr>
                            <tr>
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Velocidad máx.</a></td>
                                <td class="values"><?php echo $row_Cuenta['vel']; ?></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Generadores de escudo</a></td>
                                <td class="values">15</td>
                            </tr>
                            <tr>
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Reparto de daños</a></td>
                                <td class="values">&nbsp;</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Escudo/Casco</a></td>
                                <td class="values">80/20</td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockDrones">VANTS</a></td>
                                <td class="values">&nbsp;</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onFocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockDrones">Flax/Iris</a></td>
                                <td class="values">0/8</td>
                            </tr>
                        </table>
                    </div>

                    <div class="infoBox infoBox_ship fliess10px-weiss" id="infoBox_shipView">
                        <div class="shipNotation" id="shipNotation">
                            <img id="shipName" src="do_img/global/text.esg?l=es&s=17&t=ship_<?php echo $row_Cuenta['nave']; ?>_name&uc=1&f=ship_name"><br />
                                                            <img id="shipTitle" class="shipTitle" src="do_img/global/text.esg?l=es&s=12&t=ship_<?php echo $row_Cuenta['nave']; ?>_short&uc=1&cs=1&f=ship_title">
                                                        <br class="clearMe" />
                        </div>
                        <div id="shipVideo" style="width:368px; height:207px;">
                            <div></div>
                        </div>
                    </div>
                                        <div class="infoBox infoBox_drones fliess10px-weiss" id="infoBox_drones" style="display: none;">
                                                <div id="drone_1" style="display: block">
                            <table class="overview_table" cellpadding="1" cellspacing="0">
                                                                                                                    <tr class="overview_line_highlight">
                                    <td class="labels">1. Iris</td>
                                    <td class="values">Nivel 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Daños</td>
                                    <td class="values">0%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Puntos</td>
                                    <td class="values">1600</td>
                                </tr>
                                <tr>
                                    <td class="labels">Siguiente nivel</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                    <tr class="overview_line_highlight">
                                    <td class="labels">2. Iris</td>
                                    <td class="values">Nivel 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Daños</td>
                                    <td class="values">0%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Puntos</td>
                                    <td class="values">1600</td>
                                </tr>
                                <tr>
                                    <td class="labels">Siguiente nivel</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                    <tr class="overview_line_highlight">
                                    <td class="labels">3. Iris</td>
                                    <td class="values">Nivel 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Daños</td>
                                    <td class="values">0%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Puntos</td>
                                    <td class="values">1600</td>
                                </tr>
                                <tr>
                                    <td class="labels">Siguiente nivel</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                    <tr class="overview_line_highlight">
                                    <td class="labels">4. Iris</td>
                                    <td class="values">Nivel 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Daños</td>
                                    <td class="values">0%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Puntos</td>
                                    <td class="values">1600</td>
                                </tr>
                                <tr>
                                    <td class="labels">Siguiente nivel</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                        </table>
                        </div>
                                            <div id="drone_2" style="display: none">
                        <table class="overview_table" cellpadding="1" cellspacing="0">
                                                                                                                <tr	class="overview_line_highlight">
                                <td class="labels">5. Iris</td>
                                <td class="values">Nivel 6</td>
                            </tr>
                            <tr>
                                <td class="labels">Daños</td>
                                <td class="values">0%</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Puntos</td>
                                <td class="values">1600</td>
                            </tr>
                            <tr>
                                <td class="labels">Siguiente nivel</td>
                                <td class="values"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                                                                                                                <tr	class="overview_line_highlight">
                                <td class="labels">6. Iris</td>
                                <td class="values">Nivel 6</td>
                            </tr>
                            <tr>
                                <td class="labels">Daños</td>
                                <td class="values">0%</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Puntos</td>
                                <td class="values">1600</td>
                            </tr>
                            <tr>
                                <td class="labels">Siguiente nivel</td>
                                <td class="values"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                                                                                                                <tr	class="overview_line_highlight">
                                <td class="labels">7. Iris</td>
                                <td class="values">Nivel 6</td>
                            </tr>
                            <tr>
                                <td class="labels">Daños</td>
                                <td class="values">0%</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Puntos</td>
                                <td class="values">1600</td>
                            </tr>
                            <tr>
                                <td class="labels">Siguiente nivel</td>
                                <td class="values"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                                                                                                                <tr	class="overview_line_highlight">
                                <td class="labels">8. Iris</td>
                                <td class="values">Nivel 6</td>
                            </tr>
                            <tr>
                                <td class="labels">Daños</td>
                                <td class="values">0%</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Puntos</td>
                                <td class="values">1600</td>
                            </tr>
                            <tr>
                                <td class="labels">Siguiente nivel</td>
                                <td class="values"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                                                    </table>
                    </div>
                    <div id="drone_3" style="display: none">
                        <table class="overview_table" cellpadding="1" cellspacing="0">
                                                    </table>
                    </div>
                    <div id="nav_drones" style="display: none;">
                        
                        <div id="droneView_middle" class="label labelNextDrones fliess10px-gelb">
                            <div style="width: 25px; height: 25px; background-image: url(http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/drone_navigation.png?__cv=041f2616a9426f89f0d6801caac86400); backgound-repeat: no-repeat;background-position: 0px 0px;position: absolute; top: -15px; left: 190px;" id="dronePrev"></div>
                            <div style="width: 25px; height: 25px; background-image: url(http://darkorbit.l3.cdn.bigpoint.net/do_img/global/hangar/overview/drone_navigation.png?__cv=041f2616a9426f89f0d6801caac86400); backgound-repeat: no-repeat;background-position: 0px 25px;position: absolute; top: -15px; left: 220px;" id="droneNext"></div>
                        </div>

                        <!--
                        <div id="droneView_start" class="label labelNextDrones fliess10px-gelb" style="display: block; width: 235px">
                            <div onclick="changeDroneView('next',2);" style="float: right">Siguientes VANTS</div>
                        </div>
                        <div id="droneView_middle" class="label labelNextDrones fliess10px-gelb" style="display: none; width: 235px">
                            <div onclick="changeDroneView('previous',2);" style="float: left;">Anteriores VANTS</div>
                            <div onclick="changeDroneView('next',2);" style="float: right;">Siguientes VANTS</div>
                        </div>
                        <div id="droneView_end" class="label labelNextDrones fliess10px-gelb" style="display: none; width: 235px">
                            <div onclick="changeDroneView('previous',2);" style="float: left">Anteriores VANTS</div>
                        </div>
                        -->
                                            </div>
                    <div style="display: none;" class="infoBox infoBox_ship fliess10px-weiss" id="infoBox_droneView">
                                            <div class="droneNotation" id="droneNotation">
                                <img id="droneName" src="do_img/global/text.esg?l=es&s=17&t=Iris&uc=1&f=ship_name"><br />
                                                            <img id="droneTitle" class="droneTitle" src="do_img/global/text.esg?l=es&s=12&t=VANT de batalla&uc=1&cs=1&f=ship_title">
                                                        <br class="clearMe" />
                        </div>
                        <div id="droneVideo" style="width:362px; height:208px;">
                            <div></div>
                        </div>
                                        </div>
                </div>
                <div class="infoBox infoBox_pet fliess10px-weiss" id="infoBox_pet" style="display: none;">
                                            <div id="noPetMessage">Por el momento, no tienes ninguna P.E.T.</div>
                                    </div>
                <div class="infoBox infoBox_ship fliess10px-weiss" id="infoBox_petView">                                    </div>
            </div>
        </div>
    </div>
 </div>
<script type="text/javascript">

jQuery(document).ready(
    function(){
        
            flashembed("shipVideo", {"src": "http://<?php echo $HOST; ?>/do_img/global/hangar/model<?php echo $row_Cuenta['gfx']; ?>.swf?__cv=2645f2c4e21105317d4d2f2172d80300","version": [10,0],"width": 253,"height": 206,"wmode": "transparent"}, {"lang": "es","sid": "5237cd13d7d948e038d18251458785f0"});

            

            flashembed("droneVideo", {"src": "http://<?php echo $HOST; ?>/do_img/global/videoPlayer.swf?__cv=f592d069f70a0c15a0f104be73a21700","version": [10,0],"width": 253,"height": 208,"wmode": "transparent"}, {"videoUrl": "/do_img/global/hangar/drones/drone_iris-6.flv","videoHost": "http://<?php echo $HOST; ?>","videoHash": "eafafa57934eff2323b78c35cdf10700"});
        
    },
    function expressInstallCallback() {
       var container;
       if(jQuery('#infoBox_ship').css('display') != 'none'){
           container = 'shipVideo';
       }else if(jQuery('#infoBox_drones').css('display') != 'none'){
           container = 'droneVideo';
       }else if(jQuery('#infoBox_pet').css('display') != 'none'){
           container = 'petVideo';
       }
            // possible values for info: loadTimeOut|Cancelled|Failed
            jQuery("#"+container).html("You need version 10.0 to view this content");
    }
);

</script>    </td>
    <td style="vertical-align:top;" rowspan="2" width="160px">
                <!-- notrans --><div id="banner-right"><!-- affiliateBanner: banner enabled --><script type="text/javascript" src="http://adin-www.bigpoint.net/adxx.php?pid=6&source=country%3DES%26areaID%3Dinternal.trade%26aid%3D0%26acm%3D%26acr%3D22%26aip%3D%26gameID%3D22%26uid%3D4837490%26locale%3Des&sign=VjHCT0xObM%2FQf%2BT9MeePkRs3YrhTZSnv5Jzo0FEr"></script></div><!-- end notrans -->            </td>
</tr>
<tr>
    <td style="text-align:left;">&nbsp;</td>
</tr>
</table>



<script>
</script>

<!-- affiliateEndTag -->
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="https://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="1" height="1"><param name="allowScriptAccess" value="always" /><param name="movie" value="http://bpid.bigpoint.net/bpid.swf" /><param name="FlashVars" value="plv=%2FGameAPI.php%3Faction%3Dcore.bpid%26bpid%3D" /><param name="wmode" value="transparent" /><embed src="http://bpid.bigpoint.net/bpid.swf" width="1" height="1" allowScriptAccess="always" swLiveConnect="true" type="application/x-shockwave-flash" FlashVars="plv=%2FGameAPI.php%3Faction%3Dcore.bpid%26bpid%3D" wmode="transparent" /></object>
<script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_gat._anonymizeIp']);_gaq.push(['_setDomainName', 'none']);_gaq.push(['_setAllowLinker', true]);_gaq.push(['_setAllowHash', false]);_gaq.push(['_setCustomVar', 1, 'aid', '0', 2]);_gaq.push(['_setCustomVar', 2, 'aip', '', 2]);_gaq.push(['_setCustomVar', 3, 'ait', '', 2]);_gaq.push(['_setCustomVar', 4, 'areaID', 'internal.trade', 2]);_gaq.push(['_setAccount', 'UA-1848713-1']);_gaq.push(['_trackPageview', '/indexInternal.es?action=internalDock&areaID=internal.trade']);_gaq.push(['_setAccount', 'UA-17685913-1']);_gaq.push(['_trackPageview', '/indexInternal.es?action=internalDock&areaID=internal.trade']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = 'http://www.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>



</body>
</html>