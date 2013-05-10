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
?>
<?php 
//Otras variables
if($row_Cuenta['premium'] == 0){
$premium = "No";
}else{
$premium = "Si";
}
?>

<?php include("includes/head.tpl"); ?>
<?php include("includes/variables.php"); ?>

    <style type="text/css" media="screen">    @import "css/darkorbit.css"; </style>
    <link rel="stylesheet" media="all" href="css/internalStart.css" />
    <link rel="stylesheet" media="all" href="css/window.css" />
    <link rel="stylesheet" media="all" href="css/window_alert.css" />
	<link rel="stylesheet" media="all" href="css/internalClan.css" />
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
    <div id="nav" style="text-align:right;">
	<div id="teaser_left" style="background-image: url='do_img/global/teaser/nav_sub_bg.jpg';"></div>
</div>



<div id="mainContentClan1" style="background-image: url='do_img/global/clan/bg_main_noMember.jpg';">
<div id="inner-cont">
Coucou chou!<br/>
HEO
</div>

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
