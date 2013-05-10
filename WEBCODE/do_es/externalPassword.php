<?php include("includes/head.tpl"); ?>
<?php include("includes/variables.php"); ?>
<style type="text/css" media="screen">    @import "css/darkorbit.css"; </style>
<style type="text/css" media="screen">    @import "css/do_password.css"; </style>
<script src="js/function.js" type="text/javascript"></script>
<script>


function choose(welche) {
        document.registerform.firma.value = welche;
        document.forms['registerform'].submit();
}


</script>
</head>

<body>



<script>

function showInfo() {
	var win = window;
	width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
	container_x = document.getElementById("infoPopUpContainer").style.width.substr(0,document.getElementById("infoPopUpContainer").style.width.length-2);
	document.getElementById("infoPopUpContainer").style.left = ((width_x/2) - (container_x/2))+"px";
	document.getElementById("infoPopUpContainer").style.top = "230px";
	document.getElementById("infoPopUpContainer").style.display = "block";
}

function closeAll() {
    document.getElementById("infoPopUpContainer").style.display = "none";
    hideBusyLayer();
}

</script>



    <div class="reg_main">
        <div class="reg_bg">
            <div style="position: relative;"><table class="signup">
<tr>
<td>
<table class="signup signup_left">
<tr>
<td colspan="2" class="signup_label label_description">
<b>¿Datos de acceso olvidados?</b><br><br>¿Eres un miembro registrado, pero has perdido u olvidado los datos de acceso?<br><br>Introduce aquí tu <b>nombre de usuario o email</b> y te enviaremos tu contraseña de nuevo. Si tienes más preguntas, puedes contactar en cualquier momento con nuestro soporte.</td>
</tr>
<tr>
<td class="align_buttonRegister">
<input type="button" value="Atrás" class="input_button signup_back" onclick="location.href='index.php'"/></a></td>
</tr>
</table>
</td>
<td>
<form name="signup_signup" action="index.php?action=externalPassword" method="post">
<table class="signup signup_right">
<tr>
<td class="signup_label label_userData">
Nombre de usuario o email</td>
</tr>
<tr>
<td>
<input type="text" name="signup_userDataSearch" value="" class="input_textLong" /></td>
</tr>
<tr>
<td class="align_buttonRegister">
<input type="submit" name="signup_submit" value="Solicitar" class="input_button signup_submit" /></td>
</tr>
</table>
</form>
</td>
</tr>
</table></div>
        </div>
    </div>
    <div class="reg_foot"></div>
</body>
</html>