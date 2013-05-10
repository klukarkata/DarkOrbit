<?php require_once('../Connections/DO.php'); ?>
<?php include("../includes/variables.php"); ?>
<?php
if (!isset($_SESSION)) {
  @session_start();
}
//params={"nr":1}
//$hangar = 'params=eyJuciI6MX0=&action=init';
//params=eyJwYXJhbXMiOnsiaGkiOjMxMjkyN30sIml0ZW1JZCI6IjEzNDUxMzc2IiwicXVhbnRpdHkiOjEs%0AImFjdGlvbiI6InNlbGwifQ%3D%3D&action=sell
$hangar = 'params=eyJuciI6MX0%3D&action=init';
$seguir = "true";
$accion = "login";
//$hangar = 'params=eyJwYXJhbXMiOnsiaGkiOjMxMjkyN30sImZyb20iOnsiY29uZmlnSWQiOjEsInRhcmdldCI6Imlu%0AdmVudG9yeSIsIml0ZW1zIjpbIjEzNDUxMzc2Il19LCJhY3Rpb24iOiJtb3ZlIiwidG8iOnsic2xv%0AdHNldCI6Imxhc2VycyIsImNvbmZpZ0lkIjoxLCJ0YXJnZXQiOiJzaGlwIn19&action=move';
function enviar($datos)
{
	echo base64_encode($datos);
}
function error()
{
	$str = '{"isError":1, "error":{"message":"Has solicitado realizar una accion con muy poco tiempo de diferencia respecto a la accion anterior. Por favor, intentalo de nuevo!"}}';
	enviar($str);
}
if($seguir == "true")
{
	echo $hangar;	
}else
{
	error();
}
?>