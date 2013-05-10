<?
//Variables de conexion
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "do_es";

// El tiempo en segundos que ha de pasar
// para que un usuario se elimine

$tiempo_conexion  = 200; 


$timestamp=time();
$desconexion=$timestamp-$tiempo_conexion;

//Insertamos el valor para el usuario 
$db = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());

mysql_select_db($dbname) or die("Error al conectar a la base de datos.");
$Sql ="INSERT INTO useronline VALUES('$timestamp','$_SERVER[REMOTE_ADDR]')";
$result = mysql_query( $Sql ) or die("No se puede ejecutar la consulta: ".mysql_error());

//Borramos los usuarios cuyo $tiempo_conexion han sobrepasado.
$Sql ="DELETE FROM useronline WHERE timestamp<$desconexion";
$result = mysql_query( $Sql ) or die("No se puede ejecutar la consulta: ".mysql_error());

//Seleccionamos los usuarios que hay online en este momento
$Sql ="SELECT DISTINCT ip FROM useronline";
$result = mysql_query( $Sql ) or die("No se puede ejecutar la consulta: ".mysql_error());
$Usuarios = mysql_num_rows($result);
echo $Usuarios;

?>