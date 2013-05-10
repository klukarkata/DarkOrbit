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
  echo "<p>Espere por favor...</p>";
  exit;
}
?>
<?php
if (isset( $_SERVER['PHP_POST']))
{
  $editFormAction = $_SERVER['PHP_POST'];
}
else
{
  $editFormAction = null;
}
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cambiarEmpresaMMO")) {
  $updateSQL = sprintf("UPDATE cuentas SET empresa=%s WHERE id=%s",
                       GetSQLValueString($_POST['empresaMMO'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_DO, $DO);
  $Result1 = mysql_query($updateSQL, $DO) or die(mysql_error());

  $updateGoTo = "indexInternal.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  @header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cambiarEmpresaEIC")) {
  $updateSQL2 = sprintf("UPDATE cuentas SET empresa=%s WHERE id=%s",
                       GetSQLValueString($_POST['empresaEIC'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_DO, $DO);
  $Result2 = mysql_query($updateSQL2, $DO) or die(mysql_error());

  $updateGoTo = "indexInternal.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  @header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cambiarEmpresaVRU")) {
  $updateSQL3 = sprintf("UPDATE cuentas SET empresa=%s WHERE id=%s",
                       GetSQLValueString($_POST['empresaVRU'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_DO, $DO);
  $Result3 = mysql_query($updateSQL3, $DO) or die(mysql_error());

  $updateGoTo = "indexInternal.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  @header(sprintf("Location: %s", $updateGoTo));
}

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
if(empty($row_Cuenta['empresa']) || $row_Cuenta['empresa'] == ""){
  }else{
  echo "<script>window.location='indexInternal.php'</script>";
  }
?>
<?php include("includes/head.tpl"); ?>
<?php include("includes/variables.php"); ?>
    <style type="text/css" media="screen">  @import "css/darkorbit.css"; </style>
    <link rel="stylesheet" media="all" href="css/internalCompanyChoose.css" />
        
    <script src="js/function.js" type="text/javascript"></script>
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

            uri = "/sajaxAPI.php?sid=33c7d82f5d06f7acfe1bde79fdc71455";
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
xajax.config.requestURI = "/xajaxAPI.php?sid=33c7d82f5d06f7acfe1bde79fdc71455";
xajax.config.statusMessages = false;
xajax.config.waitCursor = true;
xajax.config.version = "xajax 0.5";
xajax.config.legacy = false;
xajax.config.defaultMode = "asynchronous";
xajax.config.defaultMethod = "POST";
/* ]]> */
</script>
<script type="text/javascript" src="http://darkorbit.l3.cdn.bigpoint.net/js/xajax_js/xajax_core.js?__cv=7d18ea9cdeb1f1b391cff64cb943d300" charset="UTF-8"></script>
<script type="text/javascript" charset="UTF-8">
/* <![CDATA[ */
window.setTimeout(
 function() {
  var scriptExists = false;
  try { if (xajax.isLoaded) scriptExists = true; }
  catch (e) {}
  if (!scriptExists) {
   alert("Error: the xajax Javascript component could not be included. Perhaps the URL is incorrect?\nURL: http://darkorbit.l3.cdn.bigpoint.net/js/xajax_js/xajax_core.js?__cv=7d18ea9cdeb1f1b391cff64cb943d300");
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


    <script type="text/javascript" src="http://darkorbit.l3.cdn.bigpoint.net/js/scriptaculous/prototype.js?__cv=b96240995f0075a55546ed3038010100"></script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="SHORTCUT ICON" href="favicon.ico"  type="image/x-icon">
    
    <script language="javascript">

    var SID='dosid=33c7d82f5d06f7acfe1bde79fdc71455';
    var rid = 'e702228c39cd5228cd1dbac892b60c45';
    var errorMsg = 'Por favor, ¡desactiva tu bloqueador de popups!';
    var windowSpacemap = null;

            var playerWantsOldClient = false;
    
    
    var determinedClientResolution = {id: '4', width: 1280, height: 900};

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
    

    
    
    function checkResolution()
    {
        var clientWidth = window.screen.width;
        var clientHeight = window.screen.height;

        var resolutions = {'0' : {id : '0', width : 820, height : 600},'1' : {id : '1', width : 1024, height : 576},'2' : {id : '2', width : 1024, height : 720},'3' : {id : '3', width : 1280, height : 720},'4' : {id : '4', width : 1280, height : 900},'5' : {id : '5', width : 750, height : 600}};

        var setResId = 4;
        var setResWidth = 1280;
        var setResHeight = 900;
        // AID-related size-offset
        var offset = {width: 0, height: 0};
        // Default-screen-related size-offset
        var staticOffset = {width: 0, height: 100};

        // find best resolution
        var fallbackResId = '0';
        var resId = -1;
        var h = -1;
        var w = -1;
        var possibleResolutions = '';


        for(var rid in resolutions) {
            var res = resolutions[rid];
            var totalHeight = res.height + offset.height + staticOffset.height
            var totalWidth = res.width + offset.width + staticOffset.width
            if(totalHeight <= clientHeight && totalWidth <= clientWidth) {
                // this resolution would fit on the clients screen
                if(res.width > w || (res.width >= w && res.height > h)) {
                    resId = rid;
                    h = res.height;
                    w = res.width;
                    if (possibleResolutions == '') {
                        possibleResolutions += rid;
                    } else {
                        possibleResolutions += ','+rid;
                    }
                }
            }
        }

        if(resId != -1) {
            if(setResId != -1 && resolutions[setResId].height < h) {
                // users setting is smaller than optimum, but fits anyway...
                resId = setResId;
            }
        } else {
            // resolution too small or something
            // else went wrong - use fallback
            resId = fallbackResId;
        }
        determinedClientResolution = resolutions[resId];

        //alert('Detected resolution: ' + String(clientWidth) + 'x' + String(clientHeight) + ' --- determined resolution: ' + String(determinedClientResolution.width) + 'x' + String(determinedClientResolution.height));
        xajax_saveTempResolution(String(resId), possibleResolutions);
    }
    checkResolution();
    
    
    
    function openMiniMap(wdt, hgt, factionID) {
        // this function is now used as a hook
        // for the old client...
        openFlashClient({id: '-1', width: wdt, height: hgt}, factionID);
    }
    
    </script>
<script type="text/javascript">if (top.location.host != self.location.host) top.location = self.location;</script><!-- affiliateHeadTag -->
<link rel="meta" href="http://int14.darkorbit.bigpoint.com/sharedpages/icra/labels.php" type="application/rdf+xml" title="ICRA labels" />
<meta http-equiv="pics-Label" content='(pics-1.1 "http://www.icra.org/pics/vocabularyv03/" l gen true for "http://int14.darkorbit.bigpoint.com" r (n 0 s 0 v 0 l 1 oa 0 ob 0 oc 0 od 1 oe 0 of 0 og 0 oh 0 c 1))' />

</head>
<body>

<!-- affiliateStartTag -->
<!-- Login Tag (-1) --> 


<script type="text/javascript">

function changeImage(divID) {
    for(i=1;i<=3;i++) {
        if (i == divID) {
            $("logo_"+i).style.backgroundImage = 'url(do_img/global/companyChoose/logo_'+i+'_active.gif)';
            $("text_"+i).style.color = '#FFFFFF';
        } else {
            $("logo_"+i).style.backgroundImage = '';
            $("text_"+i).style.color = '#909090';
        }
    }
}

function closeAll() {
    for(i=1;i<=3;i++) {
        $("logo_"+i).style.backgroundImage = '';
        $("text_"+i).style.color = '#909090';
    }
}

function showFirstEntry(factionID) {
    openMiniMap(820,653,factionID);
}

</script>

<div id="container_main" class="fliess10px-weiss">

    <div id="headline">SELECCIONA TU EMPRESA</div>
<form action="<?php echo $editFormAction; ?>" method="POST" name="cambiarEmpresaMMO" id="cambiarEmpresaMMO">
    <a href="<?php echo $editFormAction; ?>" onFocus="this.blur();">
    <div id="company_1" onMouseOver="changeImage(1);" onMouseOut="closeAll();">
        <div id="logo_1" onMouseOver="changeImage(1);">
          
        </div>
        <div id="text_1" class="faction_info">La Mars-Mining-Operation se encarga de explotar los recursos de energía del universo. Los beneficios lo son todo.<br /><br /> ¿Eres tan poco escrupuloso como tu empresa? Entonces, este es tu sitio. Sigue tu objetivo y entra en los anales de la historia del universo.</div>
        <div id="button_1" class="font_choose"><input type="image" src="do_img/global/companyChoose/seleccionar.png"/>
        </div>
        <input name="empresaMMO" type="hidden" id="empresaMMO" value="1" />
    <input name="id" type="hidden" value="<?php echo $row_Cuenta['id']; ?>" />
    <input type="hidden" name="MM_update" value="cambiarEmpresaMMO" />
    </div>
    </a>
</form>
<form method="post" name="cambiarEmpresaEIC" id="cambiarEmpresaEIC">
    <a href="<?php echo $editFormAction; ?>" onFocus="this.blur();">
    <div id="company_2" onMouseOver="changeImage(2);" onMouseOut="closeAll();">
        <div id="logo_2" onMouseOver="changeImage(2);"></div>
        <div id="text_2" class="faction_info">Aquí gobierna el hombre. Como piloto para la Earth-Industries-Corporation formas parte de una comunidad. <br /><br /> Se te conceden ciertos privilegios, pero debes luchar por el objetivo de tu empresa. En equipo serás el mejor piloto espacial de todos los tiempos.</div>
        <div id="button_2" class="font_choose"><input type="image" src="do_img/global/companyChoose/seleccionar.png"/></div>
    <input name="empresaEIC" type="hidden" id="empresaEIC" value="2" />
    <input name="id" type="hidden" value="<?php echo $row_Cuenta['id']; ?>" />
    <input type="hidden" name="MM_update" value="cambiarEmpresaEIC" />
    </div>
    </a>
</form>
<form method="post" name="cambiarEmpresaVRU" id="cambiarEmpresaVRU">
    <a href="<?php echo $editFormAction; ?>" onFocus="this.blur();">
    <div id="company_3" onMouseOver="changeImage(3);" onMouseOut="closeAll();">
        <div id="logo_3" onMouseOver="changeImage(3);"></div>
        <div id="text_3" class="faction_info">La Venus Resource Unlimited se preocupa por su gente. Asimismo, se encargan de proteger la galaxia y los habitantes que viven en ella. <br /><br />Trabaja duro y consigue ocupar un lugar en los anales de la historia como un glorioso piloto espacial.</div>
        <div id="button_3" class="font_choose"><input type="image" src="do_img/global/companyChoose/seleccionar.png"/></div>
    <input name="empresaVRU" type="hidden" id="empresaVRU" value="3" />
    <input name="id" type="hidden" value="<?php echo $row_Cuenta['id']; ?>" />
    <input type="hidden" name="MM_update" value="cambiarEmpresaVRU" />
    </div>
    </a>
  </form>
</div>

<!-- affiliateEndTag -->
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="https://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="1" height="1"><param name="allowScriptAccess" value="always" /><param name="movie" value="http://bpid.bigpoint.net/bpid.swf" /><param name="FlashVars" value="plv=%2FGameAPI.php%3Faction%3Dcore.bpid%26bpid%3D" /><param name="wmode" value="transparent" /><embed src="http://bpid.bigpoint.net/bpid.swf" width="1" height="1" allowScriptAccess="always" swLiveConnect="true" type="application/x-shockwave-flash" FlashVars="plv=%2FGameAPI.php%3Faction%3Dcore.bpid%26bpid%3D" wmode="transparent" /></object>
<script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_gat._anonymizeIp']);_gaq.push(['_setDomainName', 'none']);_gaq.push(['_setAllowLinker', true]);_gaq.push(['_setAllowHash', false]);_gaq.push(['_setCustomVar', 1, 'aid', '0', 2]);_gaq.push(['_setCustomVar', 2, 'aip', '', 2]);_gaq.push(['_setCustomVar', 3, 'ait', '', 2]);_gaq.push(['_setCustomVar', 4, 'areaID', 'internal.companyChoose', 2]);_gaq.push(['_setAccount', 'UA-1848713-1']);_gaq.push(['_trackPageview', '/indexInternal.es?action=internalCompanyChoose&areaID=internal.companyChoose']);_gaq.push(['_setAccount', 'UA-17685913-1']);_gaq.push(['_trackPageview', '/indexInternal.es?action=internalCompanyChoose&areaID=internal.companyChoose']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = 'http://www.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>

</body>
</html>
<?php
mysql_free_result($Cuenta);
?> 