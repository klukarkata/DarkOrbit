<?php
// #########################################################################
// Cargando configuración


// #########################################################################
// #########################################################################
// VARIABLES
$HOST = "127.0.0.1";
$DHOST = "$HOST/do_es";
$SERVIDOR = "http://$HOST/do_es/";
$remote_ip = $_SERVER['REMOTE_ADDR'];
$fp = @fsockopen($HOST, "8080", $errno, $errstr, 1);

	if($fp){
		$online = "online";
		$online_txt = "<span style=\"color: #006600\"'>ON</span>";
		fclose($fp);
	} else {
		$online = "offline";
		$online_txt = "<span style=\"color: #990000\"'>OFF</span>";
	}
	
function formatoUID($c) 
{
	printf("%012d",  $c);
}

?>
