<?php require_once('Connections/DO.php'); ?>
<?php include('includes/variables.php'); ?>
<?php include('includes/head.tpl'); ?>
<?php
// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $loginUsername = $_POST['signup_username'];
  $LoginRS__query = "SELECT usuario FROM cuentas WHERE usuario='" . $loginUsername . "'";
  mysql_select_db($database_DO, $DO);
  $LoginRS=mysql_query($LoginRS__query, $DO) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //Lista de errores
  if($loginFoundUser){
    $error_usuario = "El nombre de usuario ya esta cogido.";
  $error = "true";
  }
  if($_POST['signup_username'] == ""){
     $error_usuario = "El nombre de usuario esta vacio.";
  $error = "true";
  }
  if(strlen($_POST['signup_username'])<4){
    $error_usuario = "El nombre de usuario debe tener entre 4 y 20 caracteres.";
  $error = "true";
  }
   if(strlen($_POST['signup_username'])>20){
    $error_usuario = "El nombre de usuario debe tener entre 4 y 20 caracteres.";
  $error = "true";
  }
  if($_POST['signup_password'] == ""){
     $error_contraseña = "La contraseña esta vacia.";
  $error = "true";
  }
  if($_POST['signup_passwordRepeat'] == ""){
     $error_rcontraseña = "La contraseña esta vacia.";
  $error = "true";
  }
   if(strlen($_POST['signup_password'])<4){
    $error_contraseña = "Las contraseñas deben tener entre 4 y 20 caracteres.";
  $error = "true";
  }
   if(strlen($_POST['signup_password'])>20){
    $error_contraseña = "Las contraseñas deben tener entre 4 y 20 caracteres.";
  $error = "true";
  }
   if($_POST['signup_password'] != $_POST['signup_passwordRepeat']){
     $error_contraseña = "Las contraseñas no coinciden.";
  $error = "true";
  }
   if($_POST['signup_email'] == ""){
    $error_email = "El email esta vacio.";
  $error = "true";
  }
  if (!mb_eregi("^[^@]{1,64}@[^@]{1,255}$", $_POST['signup_email'])) 
  {
    $error_email = "Tu email parece ser incorrecto. Por favor, facilita una dirección de email válida.";
  $error = "true";
  }
  if(empty($_POST['signup_termsAndCondition'])){
     $error_tos = "Debes aceptar los terminos y condiciones de uso.";
  $error = "true";
  }
}



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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "signup_signup")) {
if(isset($error) == "true"){
}else{
  $fecha_nacimiento = $_POST['signup_birthdayDay'].$_POST['signup_birthdayMonth'].$_POST['signup_birthdayYear'];
  $insertSQL = sprintf("INSERT INTO cuentas (usuario, password, email, servidor, fecha_nacimiento, pais, fecha_creacion) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['signup_username'], "text"),
                       GetSQLValueString(md5($_POST['signup_password']), "text"),
                       GetSQLValueString($_POST['signup_email'], "text"),
                       GetSQLValueString($_POST['signup_servidor'], "int"),
                       GetSQLValueString($fecha_nacimiento, "text"),
                       GetSQLValueString($_POST['signup_pais'], "text"),
             GetSQLValueString($_POST['fecha_creacion'], "text"));
             

  mysql_select_db($database_DO, $DO);
  $Result1 = mysql_query($insertSQL, $DO) or die(mysql_error());
  $query_Cuenta = sprintf("SELECT * FROM cuentas WHERE usuario = '%s'", $_POST['signup_username']);
  $Cuenta = mysql_query($query_Cuenta, $DO) or die(mysql_error());
  $row_Cuenta = mysql_fetch_assoc($Cuenta);
  
  $insertSQL2 = sprintf("INSERT INTO settings (userID) VALUES (%s)",
             GetSQLValueString($row_Cuenta['id'], "int"));
             
  $Result2 = mysql_query($insertSQL2, $DO) or die(mysql_error());
  $insertGoTo = null;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo '<script language="javascript">window.location="index.php"</script>;';
}
}
?>
<style type="text/css" media="screen">    @import "css/darkorbit.css"; </style>
<style type="text/css" media="screen">    @import "css/do_registration.css"; </style>

<script src="js/function.js" type="text/javascript"></script>
<script>


function choose(welche) {
        document.registerform.firma.value = welche;
        document.forms['registerform'].submit();
}


</script>

<script type="text/javascript">if (top.location.host != self.location.host) top.location = self.location;</script><!-- affiliateHeadTag -->

</head>

<body>

<!-- affiliateStartTag -->


    <div class="reg_main">
        <div class="reg_bg">
            <script type="text/javascript" language="javascript" src="http://sharedservices.l3.cdn.bigpoint.net/shared/js/bigpoint_base.js"></script><div style="position: relative;" class="signup_container">
<table class="signup">
<tr>
<td>
<table class="signup signup_left">
<tr>
<td colspan="2" class="signup_label label_description">
<b>¡Maniobras de caza cargadas de acción y emocionantes misiones te esperan en DarkOrbit!</b><br><br><b>DarkOrbit no es el típico juego de batallas espaciales.</b><br>DarkOrbit es un juego multijugador cargado de acción en tiempo real.<br><br>¡Estás al servicio de tu empresa, piloto espacial!<br><br><ul><li>Enfréntate en la guerra de empresas: Tierra, Marte y Venus</li><li>Elige tu nave espacial: 10 naves configurables</li><li>Peligrosas batallas espaciales: lucha solo o en alianza</li><li>Recopila valiosas materias primas</li><li>Equípate: gran armamento y gran arsenal</li><li>Persigue a tus adversarios por el espacio</li></ul><br>Asciende en tu empresa y conquista nuevos sectores en galaxias desconocidas. En DarkOrbit no paras de experimentar <b>acción</b>, un juego emocionante contra <b>miles de adversarios reales.</b> Y tienes cada mes la posibilidad de ganar <b>¡10.000 euros!</b><br><br><b>¡Arranca el motor, piloto espacial!</b></td>
</tr>
</table>
</td>
<td>
<form name="signup_signup" action="<?php echo $editFormAction; ?>" method="POST">
  <input type="hidden" name="locale" value="es" />
  <table class="signup signup_right">
<tr>
<td class="signup_label label_username">
Usuario</td>
<td>
<input type="text" id="signup_username" maxlength="20" name="signup_username" value="" class="input_text"/><br />
<?php if (isset($error_usuario)) { echo $error_usuario; } ?></td>
</tr>
<tr>
<td class="signup_label label_password">
Contraseña</td>
<td>
<input type="password" maxlength="20" name="signup_password" class="input_text"/>
<br /><?php if (isset($error_contraseña)) { echo $error_contraseña; } ?></td>
</tr>
<tr>
<td class="signup_label label_passwordRepeat">
Confirmar contraseña</td>
<td>
<input type="password" maxlength="20" name="signup_passwordRepeat" class="input_text"/><br /><?php if (isset($error_rcontraseña)) { echo $error_rcontraseña; } ?></td>
</tr>
<tr>
<td class="signup_label label_email">
E-Mail</td>
<td>
<input type="text" name="signup_email" class="input_textLong" /><br /><?php if (isset($error_email)) { echo $error_email; } ?></td>
</tr>
<tr>
<td class="signup_label label_instances">
Servidor de juego</td>
<td>
<select name="signup_servidor" class="input_selectInstance" id="signup_servidor" tabindex="32767" onChange="changeInstance(this.value);" >
  <option value="1">España 1</option>
</select></td>
</tr>
<tr>
<td class="signup_label label_birthday">
Fecha de nacimiento</td>
<td>
<select name="signup_birthdayDay" class="input_selectDay">
<option value="01-" selected="selected">01</option>
<option value="02-">02</option>
<option value="03-">03</option>
<option value="04-">04</option>
<option value="05-">05</option>
<option value="06-">06</option>
<option value="07-">07</option>
<option value="08-">08</option>
<option value="09-">09</option>
<option value="10-">10</option>
<option value="11-">11</option>
<option value="12-">12</option>
<option value="13-">13</option>
<option value="14-">14</option>
<option value="15-">15</option>
<option value="16-">16</option>
<option value="17-">17</option>
<option value="18-">18</option>
<option value="19-">19</option>
<option value="20-">20</option>
<option value="21-">21</option>
<option value="22-">22</option>
<option value="23-">23</option>
<option value="24-">24</option>
<option value="25-">25</option>
<option value="26-">26</option>
<option value="27-">27</option>
<option value="28-">28</option>
<option value="29-">29</option>
<option value="30-">30</option>
<option value="31-">31</option>
</select>.<select name="signup_birthdayMonth" class="input_selectMonth">
<option value="01-" selected="selected">01</option>
<option value="02-">02</option>
<option value="03-">03</option>
<option value="04-">04</option>
<option value="05-">05</option>
<option value="06-">06</option>
<option value="07-">07</option>
<option value="08-">08</option>
<option value="09-">09</option>
<option value="10-">10</option>
<option value="11-">11</option>
<option value="12-">12</option>
</select>.<select name="signup_birthdayYear" class="input_selectYear">
<option value="2011">2011</option>
<option value="2010">2010</option>
<option value="2009">2009</option>
<option value="2008">2008</option>
<option value="2007">2007</option>
<option value="2006">2006</option>
<option value="2005">2005</option>
<option value="2004">2004</option>
<option value="2003">2003</option>
<option value="2002">2002</option>
<option value="2001">2001</option>
<option value="2000">2000</option>
<option value="1999">1999</option>
<option value="1998">1998</option>
<option value="1997">1997</option>
<option value="1996">1996</option>
<option value="1995">1995</option>
<option value="1994">1994</option>
<option value="1993">1993</option>
<option value="1992">1992</option>
<option value="1991">1991</option>
<option value="1990">1990</option>
<option value="1989">1989</option>
<option value="1988">1988</option>
<option value="1987">1987</option>
<option value="1986">1986</option>
<option value="1985">1985</option>
<option value="1984">1984</option>
<option value="1983">1983</option>
<option value="1982">1982</option>
<option value="1981">1981</option>
<option value="1980">1980</option>
<option value="1979">1979</option>
<option value="1978">1978</option>
<option value="1977">1977</option>
<option value="1976">1976</option>
<option value="1975">1975</option>
<option value="1974">1974</option>
<option value="1973">1973</option>
<option value="1972">1972</option>
<option value="1971">1971</option>
<option value="1970" selected="selected">1970</option>
<option value="1969">1969</option>
<option value="1968">1968</option>
<option value="1967">1967</option>
<option value="1966">1966</option>
<option value="1965">1965</option>
<option value="1964">1964</option>
<option value="1963">1963</option>
<option value="1962">1962</option>
<option value="1961">1961</option>
<option value="1960">1960</option>
<option value="1959">1959</option>
<option value="1958">1958</option>
<option value="1957">1957</option>
<option value="1956">1956</option>
<option value="1955">1955</option>
<option value="1954">1954</option>
<option value="1953">1953</option>
<option value="1952">1952</option>
<option value="1951">1951</option>
<option value="1950">1950</option>
<option value="1949">1949</option>
<option value="1948">1948</option>
<option value="1947">1947</option>
<option value="1946">1946</option>
<option value="1945">1945</option>
<option value="1944">1944</option>
<option value="1943">1943</option>
<option value="1942">1942</option>
<option value="1941">1941</option>
<option value="1940">1940</option>
<option value="1939">1939</option>
<option value="1938">1938</option>
<option value="1937">1937</option>
<option value="1936">1936</option>
<option value="1935">1935</option>
<option value="1934">1934</option>
<option value="1933">1933</option>
<option value="1932">1932</option>
<option value="1931">1931</option>
<option value="1930">1930</option>
<option value="1929">1929</option>
<option value="1928">1928</option>
<option value="1927">1927</option>
<option value="1926">1926</option>
<option value="1925">1925</option>
<option value="1924">1924</option>
<option value="1923">1923</option>
<option value="1922">1922</option>
<option value="1921">1921</option>
<option value="1920">1920</option>
<option value="1919">1919</option>
<option value="1918">1918</option>
<option value="1917">1917</option>
<option value="1916">1916</option>
<option value="1915">1915</option>
<option value="1914">1914</option>
<option value="1913">1913</option>
<option value="1912">1912</option>
</select></td>
</tr>
<tr>
<td class="signup_label label_country">
País</td>
<td>
<select id="signup_pais" name="signup_pais" onChange="loadProvinces(this.value);" class="input_selectCountry" >
<option value="Alemania">Alemania</option>
<option value="Argentina">Argentina</option>
<option value="Brasil">Brasil</option>
<option value="Chile">Chile</option>
<option value="Colombia">Colombia</option>
<option value="Ecuador">Ecuador</option>
<option value="España" selected="selected">España</option>
<option value="Estados Unidos">Estados Unidos</option>
<option value="Francia">Francia</option>
<option value="Italia">Italia</option>
<option value="México">México</option>
<option value="Perú">Perú</option>
<option value="Portugal">Portugal</option>
<option value="Venezuela">Venezuela</option>
</select></td>
</tr>
<input type="hidden" id="signup_winnings" name="signup_winnings" value="0" /><tr>
<td colspan="2">
<table class="signup signup_input">
    <tr>
        <td class="align_checkbox">
            <div class="">
                <input name="signup_termsAndCondition" type="checkbox" class="input_checkbox " value="1"  />
            </div>        </td>
        <td class="signup_label label_checkbox">
            <a class="signup_link" href="info.php?action=info&amp;subAction=termsOfUse" target="_blank" style="text-decoration:underline">
    Acepto los TOS</a>.        </td>
    </tr>
</table><br /><?php if (isset($error_tos)) { echo $error_tos; } ?></td>
</tr>
<tr>
<td class="align_buttonRegister">
<input type="button" name="signup_button_back" id="signup_button_back" value="Atrás" class="input_button signup_back" onClick="location.href='index.php'"/></td>
<td class="align_buttonRegister">
<input type="submit" name="signup_submit" id="signup_submit" value="Registrarse" class="input_button signup_submit"  /></td>
</tr>
</table>
<input type="hidden" name="lang" value="es" />
<input type="hidden" name="MM_insert" value="signup_signup">
<input name="fecha_creacion" type="hidden" id="fecha_creacion" value="<?php echo date('d-m-Y'); ?>" />
</form>
</td>
</tr>
</table>

<div id="attentionLayer" style="visibility: hidden;" class="signup_attentionLayer">
  <div class="signup_attentionHeader">
    <a href="javascript: closeAttentionLayer();" class="signup_attentionClose"></a>
    <span class="signup_attentionTitle" >Atención</span>
  </div>
  <div class="singup_attentionMessages signup_attentionMessages">
    <p class="singup_attentionMessage signup_attentionMessage">Queremos informarte que los usuarios que viven en los siguientes estados no pueden participar en los concursos con premios en efectivo: Arkansas, Arizona, Connecticut, Florida, Delaware, Indiana, Iowa, Illinois, Luisiana, Maryland, Montana, Nebraska, Dakota del Sur, Carolina del Sur, Tennessee y Vermont. Esta limitación también se aplica a los usuarios que residen en una zona donde la participación en concursos con premios en efectivo está prohibida por la ley.</p><br />
  <table class="signup signup_input"><tr><td class="align_checkbox"><div class=""><input type="checkbox" id="signup_attentionCheck" name="signup_attentionCheck" value="1" class="input_checkbox" onChange="BPJS.$('signup_winnings').value = this.value; closeAttentionLayer();" /></div></td><td class="signup_label label_attentionCheck">Information read and accepted</td></tr></table>  </div>
</div>
<script language="javscript" type="text/javascript">
//<![CDATA[
function closeAttentionLayer() {
  document.getElementById('attentionLayer').style.visibility = 'hidden';}//]]>
</script>

<div id="infoLayer" class="signup_infoLayer" style="visibility: hidden">
  <div id="infoMessage" class="singup_infoMessages signup_infoMessages"></div>
</div>
<script language="javscript" type="text/javascript">
//<![CDATA[
function closeInfoLayer() {
  document.getElementById('infoLayer').style.visibility = 'hidden';}//]]>
</script>

</div>
        </div>
    </div>
    <div class="reg_foot"></div>

<script>
</script>

<!-- affiliateEndTag -->
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="https://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="1" height="1"><param name="allowScriptAccess" value="always" /><param name="movie" value="http://bpid.bigpoint.net/bpid.swf" /><param name="FlashVars" value="plv=%2FGameAPI.php%3Faction%3Dcore.bpid%26bpid%3D" /><param name="wmode" value="transparent" /><embed src="http://bpid.bigpoint.net/bpid.swf" width="1" height="1" allowScriptAccess="always" swLiveConnect="true" type="application/x-shockwave-flash" FlashVars="plv=%2FGameAPI.php%3Faction%3Dcore.bpid%26bpid%3D" wmode="transparent" /></object>
<script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_gat._anonymizeIp']);_gaq.push(['_setDomainName', 'none']);_gaq.push(['_setAllowLinker', true]);_gaq.push(['_setAllowHash', false]);_gaq.push(['_setCustomVar', 1, 'aid', '0', 2]);_gaq.push(['_setCustomVar', 2, 'aip', '', 2]);_gaq.push(['_setCustomVar', 3, 'ait', '', 2]);_gaq.push(['_setCustomVar', 4, 'areaID', 'external.signup', 2]);_gaq.push(['_setAccount', 'UA-1848713-1']);_gaq.push(['_trackPageview', '/index.es?action=externalSignup&areaID=external.signup']);_gaq.push(['_setAccount', 'UA-17685913-1']);_gaq.push(['_trackPageview', '/index.es?action=externalSignup&areaID=external.signup']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = 'http://www.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>

</body>
</html>