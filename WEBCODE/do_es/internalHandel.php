<?php require_once('Connections/DO.php'); ?>
<?php
if (!isset($_SESSION)) {
  @session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
?>
<?php
/**
TIENDA POR XXCRACKXX
**/
if ($_GET['subAction'] == "buy") 
{
	$ID = $_GET['bazarID'];
	$MAX = $_GET['amount'];
	$uris = $row_Cuenta['uridium'];
	switch($ID)
	{
		case 1:
			$mun1 = split("\\|", $row_Cuenta['mun1']);
			$MCB_25 = $mun1[1] + 1000;
			$tradeMUN1 = "$mun1[0]|$MCB_25|$mun1[2]|$mun1[3]|$mun1[4]|$mun1[5]";
			$precio = $uris - 500;
			if($uris < $precio || $precio <= 0)
			{
				echo "<script>alert('¡No tienes suficientes uridiums!')</script>";
			}else{
			$updateMUN1 = sprintf("UPDATE cuentas SET uridium=%s,mun1=%s WHERE id=%s",
					GetSQLValueString($precio, "int"),
                    GetSQLValueString($tradeMUN1, "text"),
                    GetSQLValueString($row_Cuenta['id'], "int"));
			mysql_query($updateMUN1, $DO) or die(mysql_error());
			}
		break;
	
	}
  //echo "<script>alert('Se han añadido $MAX cantidades.')</script>";
}

?>

<?php include("includes/head.tpl"); ?>
<?php include("includes/variables.php"); ?>
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <style type="text/css" media="screen">    @import "css/darkorbit.css"; </style>
	<style type="text/css" media="screen">    @import "css/includeSkinNavbar.css"; </style>
    <link rel="stylesheet" media="all" href="css/window.css" />
    <link rel="stylesheet" media="all" href="css/window_alert.css" />
	<link rel="stylesheet" media="all" href="css/internalHandel.css">
	<link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
	<link type="text/css" href="css/scrollbar_dark.css" rel="stylesheet" media="all">
            <script language="javascript">
    var CDN = "<?php echo $SERVIDOR; ?>";
    </script>
    <script type="text/javascript" src="js/jquery_002.js"></script>
    <script type="text/javascript" src="js/jquery_004.js"></script>
    <script type="text/javascript" src="js/custom-form-elements.js"></script><style type="text/css">input.styled { display: none; } select.styled { position: relative; width: 60px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>
    <script type="text/javascript" src="js/jquery_003.js"></script>
    <script type="text/javascript" src="js/jquery_007.js"></script>
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
	<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="js/custom-form-elements.js"></script>
    <script type="text/javascript" src="js/jquery.flashembed.js"></script>
    <script type="text/javascript" src="js/doExtensions.js"></script>
	<script src="js/function.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/builder.js"></script>
	<script type="text/javascript" src="js/effects.js"></script>
	<script type="text/javascript" src="js/dragdrop.js"></script>
	<script type="text/javascript" src="js/controls.js"></script>
	<script type="text/javascript" src="js/slider.js"></script>
	<script type="text/javascript" src="js/sound.js"></script>
	<script type="text/javascript" src="js/feedBackForm.js"></script>
	<script type="text/javascript" src="js/jquery.livequery.js" id="liveQuery"></script>
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
xajax_nanoTechFactoryShowApis = function() { return xajax.request( { xjxfun: 'nanoTechFactoryShowApis' }, { parameters: arguments } ); };
xajax_handleImageUpload = function() { return xajax.request( { xjxfun: 'handleImageUpload' }, { parameters: arguments } ); };
xajax_pilotSheet = function() { return xajax.request( { xjxfun: 'pilotSheet' }, { parameters: arguments } ); };
xajax_achievement = function() { return xajax.request( { xjxfun: 'achievement' }, { parameters: arguments } ); };
xajax_pilotInvite = function() { return xajax.request( { xjxfun: 'pilotInvite' }, { parameters: arguments } ); };
xajax_pilotInviteIncentives = function() { return xajax.request( { xjxfun: 'pilotInviteIncentives' }, { parameters: arguments } ); };
xajax_externalPPP = function() { return xajax.request( { xjxfun: 'externalPPP' }, { parameters: arguments } ); };
xajax_socialInviteDispatch = function() { return xajax.request( { xjxfun: 'socialInviteDispatch' }, { parameters: arguments } ); };
xajax_tooltipAjaxHandler = function() { return xajax.request( { xjxfun: 'tooltipAjaxHandler' }, { parameters: arguments } ); };
xajax_showHelpNeverAgain = function() { return xajax.request( { xjxfun: 'showHelpNeverAgain' }, { parameters: arguments } ); };
xajax_loadUserInfo = function() { return xajax.request( { xjxfun: 'loadUserInfo' }, { parameters: arguments } ); };
xajax_switchHangar = function() { return xajax.request( { xjxfun: 'switchHangar' }, { parameters: arguments } ); };
xajax_loadHangarInfo = function() { return xajax.request( { xjxfun: 'loadHangarInfo' }, { parameters: arguments } ); };
xajax_setHangarSelected = function() { return xajax.request( { xjxfun: 'setHangarSelected' }, { parameters: arguments } ); };
xajax_changeHangarName = function() { return xajax.request( { xjxfun: 'changeHangarName' }, { parameters: arguments } ); };
xajax_feedbackForm = function() { return xajax.request( { xjxfun: 'feedbackForm' }, { parameters: arguments } ); };
xajax_setFeedBackForm = function() { return xajax.request( { xjxfun: 'setFeedBackForm' }, { parameters: arguments } ); };
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

<!-- CODIGO HTML -->

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

<table style="border-collapse:collapse;margin:0 auto;">
<tr>
    <td style="vertical-align:top;text-align:left;">


    <div id="topnav">
        <div class="fliess11px-gelb">
          <div id="header_container" style="width:860px; height:230px;">
              
</div>
                                                <a href="javascript:void(0)" onClick="window.blur(); window.focus(); openMiniMap(820,653,0);"><div class="button-map"><br /></div></a>                                    </div>
      </div>


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
        /**
         * Apply jScrollpane to history log table
         * if the element is available.
         */
        var tableHistory            = jQuery('#table_history'),
            isTableHistoryPresent   = 0 < tableHistory.length,
            historyContainer;

        if (isTableHistoryPresent) {
            historyContainer    = tableHistory.find('#text_history');
            historyContainer.jScrollPane({
                showArrows : true
            });
        };

jQuery(document).ready(
    function(){
        
	         flashembed("header_container", {"src": "swf_global/header.swf?lang=es&langCode=es","version": [10,0],"expressInstall": "swf_global/expressInstall.swf","width": 860,"height": 229,"wmode": "opaque","id": "flashHeader","onFail": function(){onFailFlashembed();}}, {"cdn": "<?php echo $SERVIDOR; ?>","nosid": "1","isGuestUser": "","navPoint": 1,"uid": "<?php formatoUID($row_Cuenta['id']); ?>","rank": 3436,"lvl": "<?php echo $row_Cuenta['nivel']; ?>","xp": "<?php echo number_format($row_Cuenta['experiencia'], 0, ",", "."); ?>","cred": "<?php echo number_format($row_Cuenta['creditos'], 0, ",", "."); ?>","xcred": "<?php echo number_format($row_Cuenta['uridium'], 0, ",", "."); ?>","jackpot": "<?php echo number_format($row_Cuenta['jackpot'], 2, ",", "."); ?>","premium": "<?php echo $row_Cuenta['premium']; ?>","aid": "0","ship_id": <?php echo $row_Cuenta['gfx']; ?>,"repair": "0","eventItemEnabled": "","supporturl": "indexInternal.es%3Faction%3Dsupport%26back%3DinternalStart","ouser": <?php include("usuariosonline.php"); ?>,"uridium_highlighted": "","serverdesc": "España 1","server_code": 1,"lang": "es","coBrandImgUrl": "","coBrandHref": "","customSkinURL": "swf_global/skin/defecto.png"});
        
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
        <div id="nav"><style type="text/css" media="screen">    @import "css/subnav2.css"; </style>    
</div>
        <!-- Content -->
		<meta charset="iso-8859-1">
    <div id="mainContentAuktion" class="fliess11px-weiss">

            <div id="div_counter"><strong>TIENDA TODO EN UNO</strong></div>

            <div id="div_info"><strong>Atención: </strong>  Los uridiums o creditos que ofrezcas se cargan inmediatamente a tu cuenta y no se te devuelven.</div>
            <div tabindex="0" id="div_bazar_items" class="scroll-pane fliess10px-white jspScrollable">

                <table width="450" cellspacing="0" cellpadding="0" class="fliess10px-white" border="0">
                
                <b id="BATTERY_2"></b>
                <form name="compra_1" action="" method="post" onsubmit="document.getElementById('sbmt_1').style.display='none';document.getElementById('wait_1').style.display='inline';">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="1">
                <tr>
                    <td class="trade_img"><img src="do_img/global/items/ammunition/laser/mcb-25_63x63.png" width="63" height="63" alt=""></td>
                    <td class="trade_item">¡Las mejores municiones láser en el mercado! Duplican los daños del láser por disparo (1000 Unidades).</td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>500 U.</strong></span>
							<div id="sbmt_1">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=1&amount=1000" class="trade_buy_button_submit" onclick="$('sbmt_1').style.display='none';$('wait1').style.display='block';"><img src="do_img/global/trade/btn_buy.gif" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait1" class="trade_buy_button_wait" style="display:none;"><img src="do_img/global/trade/btn_wait.gif" width="102" height="18"></a></div>
                    </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BATTERY_5"></b>
                <form name="auktion_45" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_2').style.display='none';document.getElementById('wait_2').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="45">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BATTERY_5.png?__cv=0665c3f7e4614d679369d77011c2c900" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="2mJdz">Munición especial absorbente de escudo. (1000 Unidades)<br>Mayor pujador<span class="userInfoName" title="_CzarnaWdowa_: Haz clic para ver los detalles"> _CzarnaWdowa_</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>1.000 U.</strong></span>
                                                    <a href="JavaScript:void(0)" class="trade_buy_button" onclick="showQuantityManager('battery4');"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_2" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_2">
                            <a id="bid_lnk_2" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=45&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_2').attr('href',jQuery('#bid_lnk_2').attr('href')+'&amount='+jQuery('#bid_amount_2').val());document.getElementById('sbmt_2').style.display='none';document.getElementById('wait_2').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_2" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BATTERY_3"></b>
                <form name="auktion_37" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_3').style.display='none';document.getElementById('wait_3').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="37">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BATTERY_3.png?__cv=386dd5328b039cc7594c36f8875af400" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="2mJdz">¡La mejor munición láser del mercado! Triplican los daños del láser por disparo (1000 Unidades)<br>Mayor pujador<span class="userInfoName" title="_CzarnaWdowa_: Haz clic para ver los detalles"> _CzarnaWdowa_</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>1.000 U.</strong></span>
                                                    <a href="JavaScript:void(0)" class="trade_buy_button" onclick="showQuantityManager('battery2');"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_3" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_3">
                            <a id="bid_lnk_3" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=37&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_3').attr('href',jQuery('#bid_lnk_3').attr('href')+'&amount='+jQuery('#bid_amount_3').val());document.getElementById('sbmt_3').style.display='none';document.getElementById('wait_3').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_3" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>

                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="SPECIAL_181"></b>
                <form name="auktion_72" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_24').style.display='none';document.getElementById('wait_24').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="72">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/SPECIAL_181.png?__cv=753ac1eddb627166b371ce6add2a4800" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="1pb9U">Se necesita para generar puntos de investigación. (3 Unidades)<br>Mayor pujador<span class="userInfoName" title="1_?t???G??_1: Haz clic para ver los detalles"> 1_?t???G??_1</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>900 U.</strong></span>
                                                    <a href="JavaScript:void(0)" class="trade_buy_button" onclick="showQuantityManager('logfiles');"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_24" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_24">
                            <a id="bid_lnk_24" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=72&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_24').attr('href',jQuery('#bid_lnk_24').attr('href')+'&amount='+jQuery('#bid_amount_24').val());document.getElementById('sbmt_24').style.display='none';document.getElementById('wait_24').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_24" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
  
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="SPECIAL_51"></b>
                <form name="auktion_34" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_29').style.display='none';document.getElementById('wait_29').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="34">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/SPECIAL_51.png?__cv=91a4e76a48d01b32a818d9d66e5c4600" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="3BL6C">Tu nave resultará invisible a los enemigos hasta tu primer ataque.<br>Mayor pujador<span class="userInfoName" title="alsherhan: Haz clic para ver los detalles"> alsherhan</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>500 U.</strong></span>
                                                    <div id="sbmt29">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=34&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt29').style.display='none';$('wait29').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait29" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_29" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_29">
                            <a id="bid_lnk_29" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=34&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_29').attr('href',jQuery('#bid_lnk_29').attr('href')+'&amount='+jQuery('#bid_amount_29').val());document.getElementById('sbmt_29').style.display='none';document.getElementById('wait_29').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_29" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>

                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="LASER_3"></b>
                <form name="auktion_11" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_39').style.display='none';document.getElementById('wait_39').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="11">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/LASER_3.png?__cv=6dd9a7e61a884a67bad3c40ebdf90900" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="6A3fv">Láser potente. Ocasiona 100 daños máx. por disparo.<br>Mayor pujador<span class="userInfoName" title="ghostmdk: Haz clic para ver los detalles"> ghostmdk</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>5.000 U.</strong></span>
                                                    <div id="sbmt39">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=11&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt39').style.display='none';$('wait39').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait39" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_39" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_39">
                            <a id="bid_lnk_39" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=11&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_39').attr('href',jQuery('#bid_lnk_39').attr('href')+'&amount='+jQuery('#bid_amount_39').val());document.getElementById('sbmt_39').style.display='none';document.getElementById('wait_39').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_39" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="LASER_4"></b>
                <form name="auktion_18" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_40').style.display='none';document.getElementById('wait_40').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="18">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/LASER_4.png?__cv=c1b37291be60d8d4d7bd256f76277100" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="4yZOc">Un láser muy potente. Ocasiona un máximo de 150 daños por disparo.<br>Mayor pujador<span class="userInfoName" title="-ShameLeSs-: Haz clic para ver los detalles"> -ShameLeSs-</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt40">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=18&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt40').style.display='none';$('wait40').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait40" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_40" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_40">
                            <a id="bid_lnk_40" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=18&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_40').attr('href',jQuery('#bid_lnk_40').attr('href')+'&amount='+jQuery('#bid_amount_40').val());document.getElementById('sbmt_40').style.display='none';document.getElementById('wait_40').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_40" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="ROCKET_5"></b>
                <form name="auktion_83" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_41').style.display='none';document.getElementById('wait_41').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="83">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/ROCKET_5.png?__cv=76d8717ab3944fcda7d3d250bc286200" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="4TWwb">Causa unos daños de un máximo de 6.000 PV por disparo. Sin embargo, a causa de la alta carga, también tiene una reducida probabilidad de acierto.<br /> Puedes combinarlo con excelentes resultados con el "sistema de precisión de objetivo" de la tecnofábrica. (50 Unidades)<br>Mayor pujador<span class="userInfoName" title="…»•??ô??Hìde•«…: Haz clic para ver los detalles"> …»•??ô??Hìde•«…</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>350 U.</strong></span>
                                                    <div id="sbmt41">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=83&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt41').style.display='none';$('wait41').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait41" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_41" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_41">
                            <a id="bid_lnk_41" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=83&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_41').attr('href',jQuery('#bid_lnk_41').attr('href')+'&amount='+jQuery('#bid_amount_41').val());document.getElementById('sbmt_41').style.display='none';document.getElementById('wait_41').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_41" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="ROCKET_11"></b>
                <form name="auktion_36" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_42').style.display='none';document.getElementById('wait_42').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="36">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/ROCKET_11.png?__cv=084100df3c5bed4eea0af67e4c4bfd00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="5pnPb">Mina de proximidad, 20% de daño al explotar. (50 Unidades)<br>Mayor pujador<span class="userInfoName" title="Deuce.cz: Haz clic para ver los detalles"> Deuce.cz</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>5.000 U.</strong></span>
                                                    <a href="JavaScript:void(0)" class="trade_buy_button" onclick="showQuantityManager('mine');"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_42" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_42">
                            <a id="bid_lnk_42" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=36&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_42').attr('href',jQuery('#bid_lnk_42').attr('href')+'&amount='+jQuery('#bid_amount_42').val());document.getElementById('sbmt_42').style.display='none';document.getElementById('wait_42').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_42" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="ROCKET_3"></b>
                <form name="auktion_12" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_43').style.display='none';document.getElementById('wait_43').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="12">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/ROCKET_3.png?__cv=4913b7d593e9d812b05c4f3eaaf40100" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="680iC">Misil de largo alcance. Ocasiona un máximo de 4.000 puntos de daño por disparo. (50 Unidades)<br>Mayor pujador<span class="userInfoName" title="....biencutza....: Haz clic para ver los detalles"> ....biencutz...</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>250 U.</strong></span>
                                                    <a href="JavaScript:void(0)" class="trade_buy_button" onclick="showQuantityManager('rocket');"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_43" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_43">
                            <a id="bid_lnk_43" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=12&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_43').attr('href',jQuery('#bid_lnk_43').attr('href')+'&amount='+jQuery('#bid_amount_43').val());document.getElementById('sbmt_43').style.display='none';document.getElementById('wait_43').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_43" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="ORE_4"></b>
                <form name="auktion_13" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_44').style.display='none';document.getElementById('wait_44').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="13">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/ORE_4.png?__cv=b05e4955b7cc2298d5ce88f17b33fa00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="680iC">Necesario para la refinación de Promerium en la nave y en el Skylab. (10 Unidades)<br>Mayor pujador<span class="userInfoName" title="....biencutza....: Haz clic para ver los detalles"> ....biencutz...</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100 U.</strong></span>
                                                    <a href="JavaScript:void(0)" class="trade_buy_button" onclick="showQuantityManager('ore');"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_44" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_44">
                            <a id="bid_lnk_44" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=13&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_44').attr('href',jQuery('#bid_lnk_44').attr('href')+'&amount='+jQuery('#bid_amount_44').val());document.getElementById('sbmt_44').style.display='none';document.getElementById('wait_44').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_44" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="SHIP_8"></b>
                <form name="auktion_16" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_45').style.display='none';document.getElementById('wait_45').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="16">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/SHIP_8.png?__cv=f0ccf762bd1439d5c8dae3a7ff410200" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="5X3fb">El mejor caza estelar. Con esta nave espacial ya no tendrás miedo a (casi) nada.<br>Mayor pujador<span class="userInfoName" title="~†DarkstaR†~: Haz clic para ver los detalles"> ~†DarkstaR†~</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>30.000 U.</strong></span>
                                                    <div id="sbmt45">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=16&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt45').style.display='none';$('wait45').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait45" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_45" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_45">
                            <a id="bid_lnk_45" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=16&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_45').attr('href',jQuery('#bid_lnk_45').attr('href')+'&amount='+jQuery('#bid_amount_45').val());document.getElementById('sbmt_45').style.display='none';document.getElementById('wait_45').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_45" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="SHIP_10"></b>
                <form name="auktion_17" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_46').style.display='none';document.getElementById('wait_46').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="17">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/SHIP_10.png?__cv=273a3fb5a75d49ac6924d693b81db300" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="HYQR">El último crucero de batalla, según los pilotos expertos la única y verdadera nave espacial.<br>Mayor pujador<span class="userInfoName" title="...gishin...: Haz clic para ver los detalles"> ...gishin...</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>80.000 U.</strong></span>
                                                    <div id="sbmt46">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=17&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt46').style.display='none';$('wait46').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait46" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_46" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_46">
                            <a id="bid_lnk_46" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=17&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_46').attr('href',jQuery('#bid_lnk_46').attr('href')+'&amount='+jQuery('#bid_amount_46').val());document.getElementById('sbmt_46').style.display='none';document.getElementById('wait_46').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_46" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="SHIP_3"></b>
                <form name="auktion_15" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_47').style.display='none';document.getElementById('wait_47').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="15">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/SHIP_3.png?__cv=4c6b67c03378b27346dee2a640f98000" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="3Wxol">El mejor modelo de la clase Star-Jet. Pequeña, manejable y mortal.<br>Mayor pujador<span class="userInfoName" title="foxmajor: Haz clic para ver los detalles"> foxmajor</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>15.000 U.</strong></span>
                                                    <div id="sbmt47">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=15&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt47').style.display='none';$('wait47').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait47" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_47" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_47">
                            <a id="bid_lnk_47" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=15&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_47').attr('href',jQuery('#bid_lnk_47').attr('href')+'&amount='+jQuery('#bid_amount_47').val());document.getElementById('sbmt_47').style.display='none';document.getElementById('wait_47').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_47" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BOOSTER_8"></b>
                <form name="auktion_70" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_48').style.display='none';document.getElementById('wait_48').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="70">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BOOSTER_8.png?__cv=47b6ea9bf6ca878e2d0a05206a844200" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="ELZ9">El potenciador de puntos de vida aumenta los puntos de vida de tu nave un 10%. El potenciador está activo durante 10 horas a partir de la compra.<br>Mayor pujador<span class="userInfoName" title="™*??TSUMOTÖ*™E†S™: Haz clic para ver los detalles"> ™*??TSUMOTÖ*...</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt48">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=70&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt48').style.display='none';$('wait48').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait48" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_48" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_48">
                            <a id="bid_lnk_48" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=70&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_48').attr('href',jQuery('#bid_lnk_48').attr('href')+'&amount='+jQuery('#bid_amount_48').val());document.getElementById('sbmt_48').style.display='none';document.getElementById('wait_48').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_48" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BOOSTER_3"></b>
                <form name="auktion_65" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_49').style.display='none';document.getElementById('wait_49').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="65">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BOOSTER_3.png?__cv=828a8826c2ade101dd89f7685838bf00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="4tLRr">Te proporciona un bono de 10 % por todos los daños que causes. El potenciador está activo durante 10 horas a partir de la compra.<br>Mayor pujador<span class="userInfoName" title="RTbben: Haz clic para ver los detalles"> RTbben</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt49">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=65&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt49').style.display='none';$('wait49').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait49" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_49" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_49">
                            <a id="bid_lnk_49" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=65&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_49').attr('href',jQuery('#bid_lnk_49').attr('href')+'&amount='+jQuery('#bid_amount_49').val());document.getElementById('sbmt_49').style.display='none';document.getElementById('wait_49').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_49" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BOOSTER_2"></b>
                <form name="auktion_64" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_50').style.display='none';document.getElementById('wait_50').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="64">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BOOSTER_2.png?__cv=3ee83a0c5fe740d37b6ce43f5de52700" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="4tLRr">Te proporciona un bono de 10 % al recopilar puntos de honor. El potenciador está activo durante 10 horas a partir de la compra.<br>Mayor pujador<span class="userInfoName" title="RTbben: Haz clic para ver los detalles"> RTbben</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt50">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=64&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt50').style.display='none';$('wait50').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait50" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_50" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_50">
                            <a id="bid_lnk_50" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=64&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_50').attr('href',jQuery('#bid_lnk_50').attr('href')+'&amount='+jQuery('#bid_amount_50').val());document.getElementById('sbmt_50').style.display='none';document.getElementById('wait_50').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_50" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BOOSTER_4"></b>
                <form name="auktion_66" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_51').style.display='none';document.getElementById('wait_51').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="66">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BOOSTER_4.png?__cv=19b79bc86d16810b1f7f717bfdd9c100" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="4tLRr">El potenciador de escudo aumenta el valor máximo de escudo de una nave un 25%. El potenciador está activo durante 10 horas a partir de la compra.<br>Mayor pujador<span class="userInfoName" title="RTbben: Haz clic para ver los detalles"> RTbben</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt51">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=66&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt51').style.display='none';$('wait51').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait51" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_51" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_51">
                            <a id="bid_lnk_51" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=66&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_51').attr('href',jQuery('#bid_lnk_51').attr('href')+'&amount='+jQuery('#bid_amount_51').val());document.getElementById('sbmt_51').style.display='none';document.getElementById('wait_51').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_51" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BOOSTER_1"></b>
                <form name="auktion_63" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_52').style.display='none';document.getElementById('wait_52').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="63">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BOOSTER_1.png?__cv=b4c1e49fae44dec93d9cf5dfa8fbff00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="69E">Te proporciona un bono de 10 % al recopilar puntos de experiencia. El potenciador está activo durante 10 horas a partir de la compra.<br>Mayor pujador<span class="userInfoName" title="kahn-der-titan: Haz clic para ver los detalles"> kahn-der-titan</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt52">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=63&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt52').style.display='none';$('wait52').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait52" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_52" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_52">
                            <a id="bid_lnk_52" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=63&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_52').attr('href',jQuery('#bid_lnk_52').attr('href')+'&amount='+jQuery('#bid_amount_52').val());document.getElementById('sbmt_52').style.display='none';document.getElementById('wait_52').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_52" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BOOSTER_5"></b>
                <form name="auktion_67" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_53').style.display='none';document.getElementById('wait_53').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="67">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BOOSTER_5.png?__cv=edc977033c5a5ce30972f56698fb2c00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="3j91b">El potenciador de reparación aumenta la velocidad de reparación de tu nave un 10%. El potenciador está activo durante 10 horas a partir de la compra.<br>Mayor pujador<span class="userInfoName" title="°°°DARK°°QUEEN°°°SK: Haz clic para ver los detalles"> °°°DARK°°QUE...</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt53">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=67&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt53').style.display='none';$('wait53').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait53" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_53" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_53">
                            <a id="bid_lnk_53" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=67&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_53').attr('href',jQuery('#bid_lnk_53').attr('href')+'&amount='+jQuery('#bid_amount_53').val());document.getElementById('sbmt_53').style.display='none';document.getElementById('wait_53').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_53" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BOOSTER_6"></b>
                <form name="auktion_68" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_54').style.display='none';document.getElementById('wait_54').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="68">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BOOSTER_6.png?__cv=113ad4bfc1ec016969637a8cdc41c000" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="4tLRr">El potenciador de regeneración de escudo aumenta la velocidad de regeneración del escudo un 25%. El potenciador está activo durante 10 horas a partir de la compra.<br>Mayor pujador<span class="userInfoName" title="RTbben: Haz clic para ver los detalles"> RTbben</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt54">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=68&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt54').style.display='none';$('wait54').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait54" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_54" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_54">
                            <a id="bid_lnk_54" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=68&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_54').attr('href',jQuery('#bid_lnk_54').attr('href')+'&amount='+jQuery('#bid_amount_54').val());document.getElementById('sbmt_54').style.display='none';document.getElementById('wait_54').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_54" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="BOOSTER_7"></b>
                <form name="auktion_69" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_55').style.display='none';document.getElementById('wait_55').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="69">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/BOOSTER_7.png?__cv=2aa10266eee2a0aa3c4f677fe9559d00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="4tLRr">El potenciador de recursos aumenta el número de los recursos de las cajas de carga de NPC recopiladas en un 25%. El potenciador está activo durante 10 horas a partir de la compra.<br>Mayor pujador<span class="userInfoName" title="RTbben: Haz clic para ver los detalles"> RTbben</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>10.000 U.</strong></span>
                                                    <div id="sbmt55">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=69&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt55').style.display='none';$('wait55').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait55" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_55" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_55">
                            <a id="bid_lnk_55" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=69&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_55').attr('href',jQuery('#bid_lnk_55').attr('href')+'&amount='+jQuery('#bid_amount_55').val());document.getElementById('sbmt_55').style.display='none';document.getElementById('wait_55').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_55" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="ROCKETLAUNCHER_12"></b>
                <form name="auktion_74" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_56').style.display='none';document.getElementById('wait_56').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="74">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/ROCKETLAUNCHER_12.png?__cv=484145370dc287b015ac727ec82b0500" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="5id1K">El "maestro de la recarga".<br />Versión extendida del Hellstorm Launcher 1. Un único misil puede ayudar a decidir el resultado de la batalla. 5 misiles unidos pueden concluir una batalla antes de que haya comenzado. La fuerza de destrucción del lanzamisiles eleva el ataque con misiles a una nueva dimensión. Lamentablemente, esta arma tan avanzada solo se puede equipar con misiles especiales.<br>Mayor pujador<span class="userInfoName" title="canea: Haz clic para ver los detalles"> canea</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>15.000 U.</strong></span>
                                                    <div id="sbmt56">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=74&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt56').style.display='none';$('wait56').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait56" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_56" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_56">
                            <a id="bid_lnk_56" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=74&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_56').attr('href',jQuery('#bid_lnk_56').attr('href')+'&amount='+jQuery('#bid_amount_56').val());document.getElementById('sbmt_56').style.display='none';document.getElementById('wait_56').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_56" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_53"></b>
                <form name="auktion_62" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_57').style.display='none';document.getElementById('wait_57').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="62">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_53.png?__cv=3365860a7968f85fe30e8d5dab8c8800" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="67YFm">Un diseño especial para la Goliath. Solo puede usarse cuando se tiene una Goliath.<br>Mayor pujador<span class="userInfoName" title="¦¦¦PSPPST?SBSST36¦¦¦: Haz clic para ver los detalles"> ¦¦¦PSPPST?SB...</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>40.000 U.</strong></span>
                                                    <div id="sbmt57">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=62&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt57').style.display='none';$('wait57').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait57" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_57" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_57">
                            <a id="bid_lnk_57" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=62&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_57').attr('href',jQuery('#bid_lnk_57').attr('href')+'&amount='+jQuery('#bid_amount_57').val());document.getElementById('sbmt_57').style.display='none';document.getElementById('wait_57').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_57" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_16"></b>
                <form name="auktion_96" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_58').style.display='none';document.getElementById('wait_58').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="96">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_16.png?__cv=25a119d1a7577671039686e5b2137c00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="5n4oX">¿Quieres más puntos de experiencia? ¡Con el diseño Adept recibes un magnífico bono del 10% en todos los PE que consigas!<br><br>Este gran diseño hará que tus enemigos se mueran de envidia...<br>Mayor pujador<span class="userInfoName" title="[™KillerFalcon]: Haz clic para ver los detalles"> [™KillerFalcon]</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100.000 U.</strong></span>
                                                    <div id="sbmt58">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=96&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt58').style.display='none';$('wait58').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait58" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_58" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_58">
                            <a id="bid_lnk_58" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=96&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_58').attr('href',jQuery('#bid_lnk_58').attr('href')+'&amount='+jQuery('#bid_amount_58').val());document.getElementById('sbmt_58').style.display='none';document.getElementById('wait_58').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_58" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_62"></b>
                <form name="auktion_87" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_59').style.display='none';document.getElementById('wait_59').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="87">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_62.png?__cv=238c9ccd4cc314029cc052ff46ba3100" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="0">Gracias a tu apariencia teñida de un violento rojo, infundirás temor en tus enemigos. Usa el diseño "Exalted" y consigue un 10% extra en los PH conseguidos.<br>Mayor pujador<span class="userInfoName" title="slipkno963: Haz clic para ver los detalles"> slipkno963</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100.000 U.</strong></span>
                                                    <div id="sbmt59">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=87&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt59').style.display='none';$('wait59').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait59" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_59" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_59">
                            <a id="bid_lnk_59" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=87&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_59').attr('href',jQuery('#bid_lnk_59').attr('href')+'&amount='+jQuery('#bid_amount_59').val());document.getElementById('sbmt_59').style.display='none';document.getElementById('wait_59').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_59" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_61"></b>
                <form name="auktion_86" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_60').style.display='none';document.getElementById('wait_60').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="86">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_61.png?__cv=760b84c97520e2dbcbd45f85ee2c7300" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="0">Un diseño blanco reluciente. Recibes un bono del 10% en todos los PE conseguidos mientras uses este diseño.<br>Mayor pujador<span class="userInfoName" title="slipkno963: Haz clic para ver los detalles"> slipkno963</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100.000 U.</strong></span>
                                                    <div id="sbmt60">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=86&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt60').style.display='none';$('wait60').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait60" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_60" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_60">
                            <a id="bid_lnk_60" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=86&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_60').attr('href',jQuery('#bid_lnk_60').attr('href')+'&amount='+jQuery('#bid_amount_60').val());document.getElementById('sbmt_60').style.display='none';document.getElementById('wait_60').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_60" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_56"></b>
                <form name="auktion_73" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_61').style.display='none';document.getElementById('wait_61').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="73">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_56.png?__cv=8c9cf47ee25da69f22c256c5e1326400" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="0">El 5% de daños extra que causa el Enforcer Goliath lo convierte en un diseño exclusivo para la batalla. No puede faltar en ningún clan. Su fuerza braquial marca una nueva pauta en el transcurso de cualquier guerra y aterroriza a los alienígenas y clanes enemigos.<br>Mayor pujador<span class="userInfoName" title="slipkno963: Haz clic para ver los detalles"> slipkno963</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100.000 U.</strong></span>
                                                    <div id="sbmt61">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=73&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt61').style.display='none';$('wait61').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait61" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_61" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_61">
                            <a id="bid_lnk_61" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=73&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_61').attr('href',jQuery('#bid_lnk_61').attr('href')+'&amount='+jQuery('#bid_amount_61').val());document.getElementById('sbmt_61').style.display='none';document.getElementById('wait_61').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_61" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_60"></b>
                <form name="auktion_81" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_62').style.display='none';document.getElementById('wait_62').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="81">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_60.png?__cv=73124aefaf90098a48c5988e9e5d8600" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="0">Con un 10% más de potencia de escudo, el diseño de escudo, Avenger, es un gran respaldo en cada batalla. En los pequeños y grandes combates, tus adversarios y los repugnantes alienígenas se tirarán de los pelos.<br>Mayor pujador<span class="userInfoName" title="slipkno963: Haz clic para ver los detalles"> slipkno963</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100.000 U.</strong></span>
                                                    <div id="sbmt62">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=81&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt62').style.display='none';$('wait62').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait62" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_62" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_62">
                            <a id="bid_lnk_62" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=81&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_62').attr('href',jQuery('#bid_lnk_62').attr('href')+'&amount='+jQuery('#bid_amount_62').val());document.getElementById('sbmt_62').style.display='none';document.getElementById('wait_62').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_62" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_59"></b>
                <form name="auktion_77" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_63').style.display='none';document.getElementById('wait_63').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="77">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_59.png?__cv=81bcf0cf468e9a2e1a21aeabcfdf3b00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="5KKUo">Con un 10% más de potencia de escudo, el Bastión es un gran respaldo en cada batalla. En los pequeños y grandes combates, tus adversarios se tirarán de los pelos. Incluso los repugnantes alienígenas no lo tendrán nada fácil.<br>Mayor pujador<span class="userInfoName" title="avnisalan: Haz clic para ver los detalles"> avnisalan</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100.000 U.</strong></span>
                                                    <div id="sbmt63">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=77&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt63').style.display='none';$('wait63').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait63" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_63" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_63">
                            <a id="bid_lnk_63" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=77&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_63').attr('href',jQuery('#bid_lnk_63').attr('href')+'&amount='+jQuery('#bid_amount_63').val());document.getElementById('sbmt_63').style.display='none';document.getElementById('wait_63').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_63" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_58"></b>
                <form name="auktion_75" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_64').style.display='none';document.getElementById('wait_64').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="75">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_58.png?__cv=b70c5422d557fabd187b56e2e2bbeb00" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="6GivD">Con un 5% extra de daños, el diseño Revenge puede dar el golpe decisivo en la batalla. Adecuado para tus incursiones de venganza sobre clanes enemigos y para acabar con los crueles alienígenas.<br>Mayor pujador<span class="userInfoName" title="(timoros): Haz clic para ver los detalles"> (timoros)</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100.000 U.</strong></span>
                                                    <div id="sbmt64">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=75&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt64').style.display='none';$('wait64').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait64" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_64" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_64">
                            <a id="bid_lnk_64" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=75&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_64').attr('href',jQuery('#bid_lnk_64').attr('href')+'&amount='+jQuery('#bid_amount_64').val());document.getElementById('sbmt_64').style.display='none';document.getElementById('wait_64').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_64" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                
                <b id="MODEL_17"></b>
                <form name="auktion_97" action="indexInternal.es" method="post" onsubmit="document.getElementById('sbmt_65').style.display='none';document.getElementById('wait_65').style.display='inline';"><input type="hidden" name="reloadToken" value="4a0a59e30afca6cce7e55423d420ac21">
                <input type="hidden" name="action" value="internalHandel">
                <input type="hidden" name="subAction" value="bid">
                <input type="hidden" name="bazarID" value="97">
                <tr>
                    <td class="trade_img"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/MODEL_17.png?__cv=53bc801fa8ce31198f62fee89f0eb900" width="63" height="63" alt=""></td>
                    <td class="trade_item" showUser="6I8rV">¡Honor, a quien le corresponde! El fantástico diseño Corsair te ofrece un bono del 10% en todos los puntos de honor ganados.<br><br>Así todos sabrán lo honorable que puedes llegar a ser.<br>Mayor pujador<span class="userInfoName" title="..-Kowboy-..: Haz clic para ver los detalles"> ..-Kowboy-..</span></td>
                    <td class="trade_buy">
                        <span class="trade_buy_price fliess11px-gelb"><strong>100.000 U.</strong></span>
                                                    <div id="sbmt65">
                                <a href="indexInternal.es?action=internalHandel&subAction=buy&bazarID=97&reloadToken=4a0a59e30afca6cce7e55423d420ac21" class="trade_buy_button_submit" onclick="$('sbmt65').style.display='none';$('wait65').style.display='block';"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_sofortkauf.gif?__cv=ddad42508d94bb93f036df1466e2cd00" width="102" height="18" alt="Comprar ahora"></a></div>
                                <div id="wait65" class="trade_buy_button_wait" style="display:none;"><img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/b_bitte_warten_handel.jpg?__cv=e6b193da2abec7cf4aeb4ee51299ab00" width="102" height="18"></a></div>
                                            </td>
                    <td class="trade_bid">
                        <input id="bid_amount_65" type="text" name="amount" class="trade_bid_price fliess11px-gelb"><br>
                        <div id="sbmt_65">
                            <a id="bid_lnk_65" href="indexInternal.es?action=internalHandel&subAction=bid&bazarID=97&reloadToken=4a0a59e30afca6cce7e55423d420ac21" onclick="jQuery('#bid_lnk_65').attr('href',jQuery('#bid_lnk_65').attr('href')+'&amount='+jQuery('#bid_amount_65').val());document.getElementById('sbmt_65').style.display='none';document.getElementById('wait_65').style.display='inline';">
                                <img src="http://darkorbit-22.ah.bpcdn.net/do_img/es/handel/b_bieten.gif?__cv=f15d0c9eec953296ef81578f132c8900" class="trade_bid_button_submit">
                            </a>
                        </div>
                        <img id="wait_65" class="trade_bid_button_wait" src="http://darkorbit-22.ah.bpcdn.net/do_img/global/trade/b_bieten_wait.gif?__cv=0755c137dcb3d0a7767084afe6af1200">
                                            </td>
                </tr>
                </form>
                <tr>
                    <td colspan="5" class="trade_separator_horizontal"></td>
                </tr>
                                </table>
            </div>
			</div>
        </div>
		</div>
        <!-- Ende Content -->
    </div>

    <script>
        jQuery(document).ready(function(){
            misc.initialiseScrollBar();
            jQuery('#liveQuery').remove();
        });
    </script>

	<script type="text/javascript" id="sourcecode">
    jQuery(function()
    {
        jQuery('#teamCredits_text').jScrollPane({autoReinitialise: true, showArrows: true});
    });
	</script>

</body>
</html>
