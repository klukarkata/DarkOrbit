<?php require_once('Connections/DO.php'); ?>
<?php
mysql_select_db($database_DO, $DO);
$query_Cuentas = "SELECT * FROM cuentas";
$Cuentas = mysql_query($query_Cuentas, $DO) or die(mysql_error());
$row_Cuentas = mysql_fetch_assoc($Cuentas);
$totalRows_Cuentas = mysql_num_rows($Cuentas);
?>
<?php include("includes/head.tpl"); ?>
<?php include("includes/variables.php"); ?>
<?php if ((isset($_GET['action'])) &&($_GET['action']=="error_login")){
include("includes/error_login.php");
}else{
}
?>

        <style type="text/css" media="screen">    @import "css/darkorbit.css"; </style>
        <style type="text/css" media="screen">    @import "css/externalHome.css"; </style>
                        
        <script src="js/function.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/prototype.js"></script>
        <script type="text/javascript" src="js/scriptaculous.js"></script>
		<script type="text/javascript" src="js/builder.js"></script>
		<script type="text/javascript" src="js/effects.js"></script>
		<script type="text/javascript" src="js/dragdrop.js"></script>
		<script type="text/javascript" src="js/controls.js"></script>
		<script type="text/javascript" src="js/slider.js"></script>
		<script type="text/javascript" src="js/sound.js"></script>


        <script type="text/javascript">
        var SID ='dosid=189c60b52cda3ed085f5c7c9ac8d6ee6';
        var CDN = '<?php echo $SERVIDOR; ?>';
        var current_item = "div_flashtrailer";
        var current_button = "but_trailer";

        var items = new Array('div_flashtrailer', 'div_ingame', 'div_gewinne', 'div_infos');
        var buttons = new Array('but_trailer', 'but_ingame', 'but_gewinne', 'but_infos');
        </script>

        <script type="text/javascript" src="js/externalHome.js"></script>
       <script type="text/javascript">if (top.location.host != self.location.host) top.location = self.location;</script><!-- affiliateHeadTag -->
<link rel="meta" href="sharedpages/icra/labels.php.rdf" type="application/rdf+xml" title="ICRA labels">
<meta http-equiv="pics-Label" content="(pics-1.1 &quot;http://www.icra.org/pics/vocabularyv03/&quot; l gen true for &quot;http://es3.darkorbit.bigpoint.com&quot; r (n 0 s 0 v 0 l 1 oa 0 ob 0 oc 0 od 1 oe 0 of 0 og 0 oh 0 c 1))">
    <script type="text/javascript">

    var imageList = new Array();
    imageList[0] = '<?php echo $SERVIDOR; ?>do_img/global/intro/but_register_1.png';
    imageList[1] = '<?php echo $SERVIDOR; ?>do_img/global/intro/loader_anim.gif';
    imageList[2] = '<?php echo $SERVIDOR; ?>do_img/global/intro/bg_alert.png';
    imageList[3] = '<?php echo $SERVIDOR; ?>do_img/global/intro/bg_choose_instance.png';
    imageList[4] = '<?php echo $SERVIDOR; ?>do_img/global/intro/but_reg_1.png';
    imageList[5] = '<?php echo $SERVIDOR; ?>do_img/global/intro/but_log_1.png';
    imageList[6] = '<?php echo $SERVIDOR; ?>do_img/global/intro/but_lang_1.png';
    imageList[7] = '<?php echo $SERVIDOR; ?>do_img/global/intro/but_box_std_1.png';
    imageList[8] = '<?php echo $SERVIDOR; ?>do_img/global/intro/but_box_std_2.png';
    imageList[9] = '<?php echo $SERVIDOR; ?>do_img/global/intro/but_std_1.png';
    preloadImgExternal();
    </script>

    <style type="text/css">.fb_hidden{position:absolute;top:-10000px;z-index:10001}
.fb_reset{background:none;border-spacing:0;border:0;color:#000;cursor:auto;direction:ltr;font-family:"lucida grande", tahoma, verdana, arial, sans-serif;font-size: 11px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;line-height:1;margin:0;overflow:visible;padding:0;text-align:left;text-decoration:none;text-indent:0;text-shadow:none;text-transform:none;visibility:visible;white-space:normal;word-spacing:normal}
.fb_link img{border:none}
.fb_dialog{background:rgba(82, 82, 82, .7);position:absolute;top:-10000px;z-index:10001}
.fb_dialog_advanced{padding:10px;-moz-border-radius:8px;-webkit-border-radius:8px}
.fb_dialog_content{background:#fff;color:#333}
.fb_dialog_close_icon{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 0 transparent;_background-image:url(http://static.ak.fbcdn.net/rsrc.php/v1/yL/r/s816eWC-2sl.gif);cursor:pointer;display:block;height:15px;position:absolute;right:18px;top:17px;width:15px;top:8px\9;right:7px\9}
.fb_dialog_mobile .fb_dialog_close_icon{top:5px;left:5px;right:auto}
.fb_dialog_close_icon:hover{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -15px transparent;_background-image:url(http://static.ak.fbcdn.net/rsrc.php/v1/yL/r/s816eWC-2sl.gif)}
.fb_dialog_close_icon:active{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -30px transparent;_background-image:url(http://static.ak.fbcdn.net/rsrc.php/v1/yL/r/s816eWC-2sl.gif)}
.fb_dialog_loader{background-color:#f2f2f2;border:1px solid #606060;font-size: 24px;padding:20px}
.fb_dialog_top_left,
.fb_dialog_top_right,
.fb_dialog_bottom_left,
.fb_dialog_bottom_right{height:10px;width:10px;overflow:hidden;position:absolute}
.fb_dialog_top_left{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/ye/r/8YeTNIlTZjm.png) no-repeat 0 0;left:-10px;top:-10px}
.fb_dialog_top_right{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/ye/r/8YeTNIlTZjm.png) no-repeat 0 -10px;right:-10px;top:-10px}
.fb_dialog_bottom_left{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/ye/r/8YeTNIlTZjm.png) no-repeat 0 -20px;bottom:-10px;left:-10px}
.fb_dialog_bottom_right{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/ye/r/8YeTNIlTZjm.png) no-repeat 0 -30px;right:-10px;bottom:-10px}
.fb_dialog_vert_left,
.fb_dialog_vert_right,
.fb_dialog_horiz_top,
.fb_dialog_horiz_bottom{position:absolute;background:#525252;filter:alpha(opacity=70);opacity:.7}
.fb_dialog_vert_left,
.fb_dialog_vert_right{width:10px;height:100%}
.fb_dialog_vert_left{margin-left:-10px}
.fb_dialog_vert_right{right:0;margin-right:-10px}
.fb_dialog_horiz_top,
.fb_dialog_horiz_bottom{width:100%;height:10px}
.fb_dialog_horiz_top{margin-top:-10px}
.fb_dialog_horiz_bottom{bottom:0;margin-bottom:-10px}
.fb_dialog_iframe{line-height:0}
.fb_dialog_content .dialog_title{background:#6d84b4;border:1px solid #3b5998;color:#fff;font-size: 14px;font-weight:bold;margin:0}
.fb_dialog_content .dialog_title > span{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/yd/r/Cou7n-nqK52.gif)
no-repeat 5px 50%;float:left;padding:5px 0 7px 26px}
.fb_dialog.fb_dialog_mobile.loading{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/yO/r/_j03izEX40U.gif)
white no-repeat 50% 180px;left:0;min-width:100%;min-height:640px;position:absolute;top:0;z-index:10001}
.fb_dialog.fb_dialog_mobile.loading iframe{visibility:hidden}
.fb_dialog_content .dialog_header{-webkit-box-shadow:white 0 1px 1px -1px inset;background:-webkit-gradient(linear, 0 0, 0 100%, from(#738ABA), to(#2C4987));border-bottom:1px solid;border-color:#1d4088;color:#fff;font:14px Helvetica, sans-serif;font-weight:bold;text-overflow:ellipsis;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0;vertical-align:middle
white-space:nowrap}
.fb_dialog_content .dialog_header table{height:43px;width:100%
}
.fb_dialog_content .dialog_header td.header_left{font-size: 12px;padding-left:4px;width:80px
}
.fb_dialog_content .dialog_header td.header_right{font-size: 12px;padding-right:4px;width:80px
}
.fb_dialog_content .touchable_button{background:-webkit-gradient(linear, 0 0, 0 100%, from(#4966A6),
color-stop(0.5, #355492), to(#2A4887));border:1px solid #29447e;border-radius:3px;-webkit-background-clip:padding-box;-webkit-box-shadow:rgba(0, 0, 0, .117188) 0 1px 1px inset,
rgba(255, 255, 255, .167969) 0 1px 0;display:inline-block;margin-top:3px;max-width:85px;min-width:64px;line-height:18px;padding:4px 12px;position:relative}
.fb_dialog_content .dialog_header .touchable_button input{border:none;background:none;color:#fff;font:12px Helvetica, sans-serif;font-weight:bold;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}
.fb_dialog_content .dialog_header .header_center{font-size: 16px;line-height:18px;text-align:center}
.fb_dialog_content .dialog_content{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/y9/r/jKEcVPZFk-2.gif) no-repeat 50% 50%;border:1px solid #555;border-bottom:0;border-top:0;height:150px}
.fb_dialog_content .dialog_footer{background:#f2f2f2;border:1px solid #555;border-top-color:#ccc;height:40px}
#fb_dialog_loader_close{float:left}
.fb_dialog.fb_dialog_mobile .fb_dialog_close_button{text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}
.fb_dialog.fb_dialog_mobile .fb_dialog_close_icon{visibility:hidden}
.fb_iframe_widget{position:relative;display:-moz-inline-block;display:inline-block}
.fb_iframe_widget iframe{position:relative;vertical-align:text-bottom}
.fb_iframe_widget span{position:relative}
.fb_hide_iframes iframe{position:relative;left:-10000px}
.fb_iframe_widget_loader{position:relative;display:inline-block}
.fb_iframe_widget_loader iframe{min-height:32px;z-index:2;zoom:1}
.fb_iframe_widget_loader .FB_Loader{background:url(http://static.ak.fbcdn.net/rsrc.php/v1/y9/r/jKEcVPZFk-2.gif) no-repeat;height:32px;width:32px;margin-left:-16px;position:absolute;left:50%;z-index:4}
.fb_button_simple,
.fb_button_simple_rtl{background-image:url(http://static.ak.fbcdn.net/rsrc.php/v1/yH/r/eIpbnVKI9lR.png);background-repeat:no-repeat;cursor:pointer;outline:none;text-decoration:none}
.fb_button_simple_rtl{background-position:right 0}
.fb_button_simple .fb_button_text{margin:0 0 0 20px;padding-bottom:1px}
.fb_button_simple_rtl .fb_button_text{margin:0 10px 0 0}
a.fb_button_simple:hover .fb_button_text,
a.fb_button_simple_rtl:hover .fb_button_text,
.fb_button_simple:hover .fb_button_text,
.fb_button_simple_rtl:hover .fb_button_text{text-decoration:underline}
.fb_button,
.fb_button_rtl{background:#29447e url(http://static.ak.fbcdn.net/rsrc.php/v1/yL/r/FGFbc80dUKj.png);background-repeat:no-repeat;cursor:pointer;display:inline-block;padding:0 0 0 1px;text-decoration:none;outline:none}
.fb_button .fb_button_text,
.fb_button_rtl .fb_button_text{background:#5f78ab url(http://static.ak.fbcdn.net/rsrc.php/v1/yL/r/FGFbc80dUKj.png);border-top:solid 1px #879ac0;border-bottom:solid 1px #1a356e;color:#fff;display:block;font-family:"lucida grande",tahoma,verdana,arial,sans-serif;font-weight:bold;padding:2px 6px 3px 6px;margin:1px 1px 0 21px;text-shadow:none}
a.fb_button,
a.fb_button_rtl,
.fb_button,
.fb_button_rtl{text-decoration:none}
a.fb_button:active .fb_button_text,
a.fb_button_rtl:active .fb_button_text,
.fb_button:active .fb_button_text,
.fb_button_rtl:active .fb_button_text{border-bottom:solid 1px #29447e;border-top:solid 1px #45619d;background:#4f6aa3;text-shadow:none}
.fb_button_xlarge,
.fb_button_xlarge_rtl{background-position:left -60px;font-size: 24px;line-height:30px}
.fb_button_xlarge .fb_button_text{padding:3px 8px 3px 12px;margin-left:38px}
a.fb_button_xlarge:active{background-position:left -99px}
.fb_button_xlarge_rtl{background-position:right -268px}
.fb_button_xlarge_rtl .fb_button_text{padding:3px 8px 3px 12px;margin-right:39px}
a.fb_button_xlarge_rtl:active{background-position:right -307px}
.fb_button_large,
.fb_button_large_rtl{background-position:left -138px;font-size: 13px;line-height:16px}
.fb_button_large .fb_button_text{margin-left:24px;padding:2px 6px 4px 6px}
a.fb_button_large:active{background-position:left -163px}
.fb_button_large_rtl{background-position:right -346px}
.fb_button_large_rtl .fb_button_text{margin-right:25px}
a.fb_button_large_rtl:active{background-position:right -371px}
.fb_button_medium,
.fb_button_medium_rtl{background-position:left -188px;font-size: 11px;line-height:14px}
a.fb_button_medium:active{background-position:left -210px}
.fb_button_medium_rtl{background-position:right -396px}
.fb_button_text_rtl,
.fb_button_medium_rtl .fb_button_text{padding:2px 6px 3px 6px;margin-right:22px}
a.fb_button_medium_rtl:active{background-position:right -418px}
.fb_button_small,
.fb_button_small_rtl{background-position:left -232px;font-size: 10px;line-height:10px}
.fb_button_small .fb_button_text{padding:2px 6px 3px;margin-left:17px}
a.fb_button_small:active,
.fb_button_small:active{background-position:left -250px}
.fb_button_small_rtl{background-position:right -440px}
.fb_button_small_rtl .fb_button_text{padding:2px 6px;margin-right:18px}
a.fb_button_small_rtl:active{background-position:right -458px}
.fb_share_count_wrapper{position:relative;float:left}
.fb_share_count{background:#b0b9ec none repeat scroll 0 0;color:#333;font-family:"lucida grande", tahoma, verdana, arial, sans-serif;text-align:center}
.fb_share_count_inner{background:#e8ebf2;display:block}
.fb_share_count_right{margin-left:-1px;display:inline-block}
.fb_share_count_right .fb_share_count_inner{border-top:solid 1px #e8ebf2;border-bottom:solid 1px #b0b9ec;margin:1px 1px 0 1px;font-size: 10px;line-height:10px;padding:2px 6px 3px;font-weight:bold}
.fb_share_count_top{display:block;letter-spacing:-1px;line-height:34px;margin-bottom:7px;font-size: 22px;border:solid 1px #b0b9ec}
.fb_share_count_nub_top{border:none;display:block;position:absolute;left:7px;top:35px;margin:0;padding:0;width:6px;height:7px;background-repeat:no-repeat;background-image:url(http://static.ak.fbcdn.net/rsrc.php/v1/yU/r/bSOHtKbCGYI.png)}
.fb_share_count_nub_right{border:none;display:inline-block;padding:0;width:5px;height:10px;background-repeat:no-repeat;background-image:url(http://static.ak.fbcdn.net/rsrc.php/v1/yX/r/i_oIVTKMYsL.png);vertical-align:top;background-position:right 5px;z-index:10;left:2px;margin:0 2px 0 0;position:relative}
.fb_share_no_count{display:none}
.fb_share_size_Small .fb_share_count_right .fb_share_count_inner{font-size: 10px}
.fb_share_size_Medium .fb_share_count_right .fb_share_count_inner{font-size: 11px;padding:2px 6px 3px;letter-spacing:-1px;line-height:14px}
.fb_share_size_Large .fb_share_count_right .fb_share_count_inner{font-size: 13px;line-height:16px;padding:2px 6px 4px;font-weight:normal;letter-spacing:-1px}
.fb_share_count_hidden .fb_share_count_nub_top,
.fb_share_count_hidden .fb_share_count_top,
.fb_share_count_hidden .fb_share_count_nub_right,
.fb_share_count_hidden .fb_share_count_right{visibility:hidden}
.fb_connect_bar_container div,
.fb_connect_bar_container span,
.fb_connect_bar_container a,
.fb_connect_bar_container img,
.fb_connect_bar_container strong{background:none;border-spacing:0;border:0;direction:ltr;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:1;margin:0;overflow:visible;padding:0;text-align:left;text-decoration:none;text-indent:0;text-shadow:none;text-transform:none;visibility:visible;white-space:normal;word-spacing:normal;vertical-align:baseline}
.fb_connect_bar_container{position:fixed;left:0 !important;right:0 !important;height:42px !important;padding:0 25px !important;margin:0 !important;vertical-align:middle !important;border-bottom:1px solid #333 !important;background:#3b5998 !important;z-index:99999999 !important;overflow:hidden !important}
.fb_connect_bar_container_ie6{position:absolute;top:expression(document.compatMode=="CSS1Compat"? document.documentElement.scrollTop+"px":body.scrollTop+"px")}
.fb_connect_bar{position:relative;margin:auto;height:100%;width:100%;padding:6px 0 0 0 !important;background:none;color:#fff !important;font-family:"lucida grande", tahoma, verdana, arial, sans-serif !important;font-size: 13px !important;font-style:normal !important;font-variant:normal !important;font-weight:normal !important;letter-spacing:normal !important;line-height:1 !important;text-decoration:none !important;text-indent:0 !important;text-shadow:none !important;text-transform:none !important;white-space:normal !important;word-spacing:normal !important}
.fb_connect_bar a:hover{color:#fff}
.fb_connect_bar .fb_profile img{height:30px;width:30px;vertical-align:middle;margin:0 6px 5px 0}
.fb_connect_bar div a,
.fb_connect_bar span,
.fb_connect_bar span a{color:#bac6da;font-size: 11px;text-decoration:none}
.fb_connect_bar .fb_buttons{float:right;margin-top:7px}
.fb_edge_widget_with_comment{position:relative;*z-index:1000}
.fb_edge_widget_with_comment span.fb_edge_comment_widget{position:absolute}
.fb_edge_widget_with_comment span.fb_edge_comment_widget iframe.fb_ltr{left:-4px}
.fb_edge_widget_with_comment span.fb_edge_comment_widget iframe.fb_rtl{left:2px}
.fb_edge_widget_with_comment span.fb_send_button_form_widget{left:0;z-index:1}
.fb_edge_widget_with_comment span.fb_send_button_form_widget .FB_Loader{left:0;top:1px;margin-top:6px;margin-left:0;background-position:50% 50%;background-color:#fff;height:150px;width:394px;border:1px #666 solid;border-bottom:2px solid #283e6c;z-index:1}
.fb_edge_widget_with_comment span.fb_send_button_form_widget.dark .FB_Loader{background-color:#000;border-bottom:2px solid #ccc}
.fb_edge_widget_with_comment span.fb_send_button_form_widget.siderender
.FB_Loader{margin-top:0}
#fb_social_bar_container{position:fixed;left:0;right:0;height:34px;padding:0 25px;z-index:999999999}
.fb_social_bar_iframe{position:relative;float:right;opacity:0;-moz-opacity:0;filter:alpha(opacity=0)}
.fb_social_bar_iframe_bottom_ie6{bottom:auto;top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)))}
.fb_social_bar_iframe_top_ie6{bottom:auto;top:expression(eval(document.documentElement.scrollTop-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)))}
</style></head>
<body>


<div>

<!-- affiliateStartTag -->


<!-- Footer -->

<div id="footerfirst">
        <div id="footer_text" class="fliessfooter">
    
        <div id="footer" class="fliessfooter">
            <div class="footer_left"> © Bigpoint- Todos los derechos reservados - ELIEAZ - elieaz@mail.ru
            </div>
            <br class="clearMe">
          </div>
    </div>
  </div>

<!-- Footer -->
<!-- Infoblock -->
<div id="infofirst">
    <div id="div_infos" style="visibility:hidden;">
        <div id="infos" class="fliess10px-white"><strong>¡DarkOrbit te fascinará!</strong><br>DarkOrbit:
 ¡El shooter de acción de los juegos de navegador! Experimenta la 
grandeza infinita del espacio. En DarkOrbit lucharás solo o con aliados 
en sectores lejanos. Descubre nuevos mundos y ve a la caza de 
misteriosos alienígenas.<br>neor1326 not edited these files or Created, so it is not responsible for the editing of these files.</div>
    </div>
</div>
<!-- Infoblock -->

<div id="teaserfirst" class="fliesstext"><div id="teasertext">DARKORBIT –  El gran juego de acción entre los juegos de navegador<br><br><ul><li>Juega ya y enfréntate a miles de jugadores.</li><li>DarkOrbit es un juego espacial lleno de acción y diversión</li><li>Juegos de navegador: ¡Sin descargas, ni instalaciones!</li></ul></div></div>

<!-- seitenabdecker -->
<div id="busy_layer" style="visibility: hidden;"></div>
<!-- seitenabdecker -->

<div id="alertBox" class="fliesstext"></div>





<div id="main">

<div id="loginForm_default_container">
    <form id="loginForm_default" method="POST" action="doLogin.php" name="loginForm_default">
        <div id="loginForm_default_link_forgot_password_container">
            <a id="loginForm_default_link_forgot" href="externalPassword.php">¿Contraseña olvidada?</a>
        </div>
        <div id="loginForm_default_label_username_container">
            <label id="loginForm_default_label_username" for="loginForm_default_input_username">Usuario</label>
        </div>
        <div id="loginForm_default_input_username_container">
            <input id="loginForm_default_input_username" class="loginForm_default_input" name="loginForm_default_username" type="text">
        </div>
        <div id="loginForm_default_label_password_container">
            <label id="loginForm_default_label_password" for="loginForm_default_input_password">Contraseña</label>
        </div>
        <div id="loginForm_default_input_password_container">
            <input id="loginForm_default_input_password" class="loginForm_default_input" name="loginForm_default_password" type="password">
        </div>
                
                
        <div id="loginForm_default_loginButton_container">
            <input value="Entrar" id="loginForm_default_loginButton" class="loginForm_default_button" name="loginForm_default_login_submit" type="submit">
        </div>
        <div id="loginForm_default_signupButton_container">
            <input value="Registrarse" id="loginForm_default_signupButton" class="loginForm_default_button" name="loginForm_default_signup_submit" onClick="window.location='externalSignup.php'; return false;" type="submit">
        </div>
      </form>

    <div class="layout2">

                <div style="clear:both"></div>
    </div>
</div>


<div style="position:absolute;left:318px;top:188px;"><img src="index_files/bg_star_anim_01.gif" alt="" height="13" width="13"></div>
<div style="position:absolute;left:529px;top:178px;"><img src="index_files/bg_star_anim_02.gif" alt="" height="13" width="13"></div>
<div style="position:absolute;left:494px;top:500px;"><img src="index_files/bg_star_anim_03.gif" alt="" height="13" width="13"></div>
<div style="position:absolute;left:362px;top:262px;"><img src="index_files/bg_star_anim_04.gif" alt="" height="13" width="13"></div>
<div style="position:absolute;left:396px;top:334px;"><img src="index_files/bg_star_anim_05.gif" alt="" height="13" width="13"></div>
<div style="position:absolute;left:448px;top:161px;"><img src="index_files/bg_claim.png" alt="" width="381"></div>
    <!-- Partner -->
    <div id="partner"><span class="branding"><img id="PartnerCobrandLogo" src="index_files/0_22_2.png"></span></div>
    <!-- Partner -->

    <!-- Info-Bar -->
    <div id="infobar">
        <div id="online" class="fliesstext">Ahora online: <?php include("usuariosonline.php"); ?></div>
        <div id="register" class="fliesstext">Registrados: <?php echo $totalRows_Cuentas ?> </div>
		<div id="register" class="fliesstext">Estado del servidor: <img src='do_img/global/intro/<?php echo $online; ?>.png' alt='<?php echo $online; ?>'  title="<?php echo $online; ?>" border='0'><b><?php echo $online_txt; ?></b>: <a href='http://mycom69.tk/'>DEV FORUM</a></div>
        <br class="clearMe">
    </div>
    <!-- Info-Bar -->

    <!-- Left -->
    <div id="left">

        
        <a href="externalSignup.php" onMouseOver="changePic('div_register','http://localhost/do_es/do_img/global/intro/but_register_1.png')" onMouseOut="changePic('div_register','http://localhost/do_es/do_img/global/intro/but_register_0.png')" class="verweis"><div id="div_register" style="background-image: url(&quot;http://localhost/do_es/do_img/global/intro/but_register_0.png&quot;);"></div></a>

        <div id="div_login" class="fliesstext">
            <div id="login">CONEXIÓN</div>
            <div id="langbar" onMouseOver="showLang();" onMouseOut="hideLang();" style="z-index:1;">
                <div id="but_lang" class="fliesstext" onMouseOver="changePic('but_lang','http://localhost/do_es/do_img/global/intro/but_lang_1.png');" onMouseOut="changePic('but_lang','http://localhost/do_es/do_img/global/intro/but_lang_0.png')" style="display:block;">
                    <div style="float:left;width:167px;margin-left:10px;line-height:21px;"><a href="#">Idioma: </a></div>
                    <div style="float:left;margin-top:-3px;"><img src="index_files/es.png"></div>
					
                    <br class="clearMe">
                </div>
                <div id="choose_lang" style="display:none;z-index:10" onMouseOut="hideLang();">
                                               <div class="select_lang" style="background-image:url(http://localhost/do_es/do_img/global/flaggen/es.png);"><a href="index.php?lang=es" onFocus="this.blur()" style="display: block;">Español</a></div>
											   <div class="select_lang" style="background-image:url(http://localhost/do_es/do_img/global/flaggen/fr.png);"><a href="index.php?lang=es" onFocus="this.blur()" style="display: block;">Français</a></div>
              </div>
            </div>

        </div>

        
    
    </div>
    <!-- Left -->

    <!-- Right -->
    <div id="right">

        <div id="teaser_nav_top" class="fliesstext">
            <div id="but_trailer" class="mm_box_std"><a href="javascript:void(0);" onFocus="this.blur()" onClick="show_preview('div_flashtrailer','but_trailer');">Tráiler</a></div>
            <div id="but_ingame" class="mm_box_std"><a href="javascript:void(0);" onFocus="this.blur()" onClick="show_preview('div_ingame','but_ingame');">Video Ingame</a></div>
            <div id="but_gewinne" class="mm_box_active"><a href="javascript:void(0);" onFocus="this.blur()" onClick="show_preview('div_gewinne','but_gewinne');">Premios</a></div>
            <br class="clearMe">
        </div>
        <div id="box">
            <div id="div_flashtrailer" style="visibility: hidden;">
                <embed src="index_files/trailer.swf" flashvars="ordner=http://<?php echo $HOST; ?>/do_es/index_files/trailer_do.f4v&amp;imgPath=http://<?php echo $HOST; ?>/do_es/index_files/trailer_sample.png&amp;cdn=http://<?php echo $HOST; ?>%2F&amp;allowedScriptAccess=always&amp;allowNetworking=true&amp;wmode=opaque&amp;sid=189c60b52cda3ed085f5c7c9ac8d6ee6&amp;lang=es" play="true" loop="true" menu="false" quality="best" name="trailer" allowscriptaccess="always" allownetworking="true" swliveconnect="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="opaque" height="160" width="426">
            </div>
            <div id="div_ingame" style="visibility: hidden;">
                <embed src="index_files/trailer.swf" flashvars="ordner=http://<?php echo $HOST; ?>/do_es/index_files/ingame.flv&amp;imgPath=http://<?php echo $HOST; ?>/do_es/index_files/ingame_sample.jpg&amp;cdn=http://<?php echo $HOST; ?>%2F&amp;allowedScriptAccess=always&amp;allowNetworking=true&amp;wmode=opaque&amp;sid=189c60b52cda3ed085f5c7c9ac8d6ee6&amp;lang=es" play="true" loop="true" menu="false" quality="best" name="ingame" allowscriptaccess="always" allownetworking="true" swliveconnect="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="opaque" height="160" width="426">
            </div>
            <div id="div_gewinne" style="visibility: visible; background-image: url(&quot;http://localhost/do_es/do_img/global/intro/prizes_1.png&quot;);">
                                <div id="prizes" class="fliess10px-white">Oportunidad de ganar:<br>Una
 vez al mes tienes la posibilidad de ganar el Jackpot de un máximo de 
0 euros..</div>
          </div>
      </div>
        <div id="teaser_nav_bottom" class="fliesstext">
            <div id="but_infos" class="mm_box_std"><a href="javascript:void(0);" onFocus="this.blur()" onClick="show_preview('div_infos','but_infos');">Info</a></div>
                                    <br class="clearMe">
        </div>
    </div>
    <!-- Right -->
</div>

<br class="clearMe">

<!-- affiliateEndTag -->
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="https://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" height="1" width="1"><param name="allowScriptAccess" value="always"><param name="movie" value="http://bpid.bigpoint.net/bpid.swf"><param name="FlashVars" value="plv=%2FGameAPI.php%3Faction%3Dcore.bpid%26bpid%3D"><param name="wmode" value="transparent"><embed src="index_files/bpid.swf" allowscriptaccess="always" swliveconnect="true" type="application/x-shockwave-flash" flashvars="plv=%2FGameAPI.php%3Faction%3Dcore.bpid%26bpid%3D" wmode="transparent" height="1" width="1"></object>
<script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_gat._anonymizeIp']);_gaq.push(['_setDomainName', 'none']);_gaq.push(['_setAllowLinker', true]);_gaq.push(['_setAllowHash', false]);_gaq.push(['_setCustomVar', 1, 'aid', '0', 2]);_gaq.push(['_setCustomVar', 2, 'aip', '', 2]);_gaq.push(['_setCustomVar', 3, 'ait', '', 2]);_gaq.push(['_setCustomVar', 4, 'areaID', 'external.home', 2]);_gaq.push(['_setAccount', 'UA-1848713-1']);_gaq.push(['_trackPageview', '/index.es?areaID=external.home']);_gaq.push(['_setAccount', 'UA-17685913-1']);_gaq.push(['_trackPageview', '/index.es?areaID=external.home']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = 'http://www.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>


</div>

<div class="gl_overlay" id="facebookSessionRequest" style="display:none">
</div>

<div class=" fb_reset" id="fb-root"><script async="" src="index_files/all.js"></script>
<div style="position: absolute; top: -10000px; height: 0pt; width: 0pt;"></div></div>



</body></html>
<?php
mysql_free_result($Cuentas);
?>
