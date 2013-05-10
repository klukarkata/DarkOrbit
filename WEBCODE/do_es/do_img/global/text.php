<?php
$size = $_GET['s']; //Tamaño de la letra
$inclinacion = "0"; // Inclinacion del texto
$x = 0; // Mover texto a la derecha o izquierda
$y = $size; // Mover texto arriba o abajo
$text = $_GET['t'];
$px = strlen(".$text.")*$size;
$px2 = ($px)/2;

$im = @imagecreate($px, $size)//$im = @imagecreate(($px-$px2)+120, $size+7)
    or die("Error!");
// Ponemos el fondo transparente 

$transparente = imagecolorallocatealpha($im, 0, 0, 0, 127);//$transparente = imagecolorallocate($im, 255, 255, 255);
imagecolortransparent($im, $transparente);

//Titulos de naves
switch($_GET['t']) 
{
	case 'ship_10_name':
		$text = 'GOLIATH';
		break;
	case 'ship_10_short':
		$text = 'CRUCERO DE BATALLA';
		break;
	case 'ship_9_name':
		$text = 'BIGBOY';
		break;
	case 'ship_9_short':
		$text = 'CRUCERO DE BATALLA';
		break;
	case 'ship_8_name':
		$text = 'VENGEANCE';
		break;
	case 'ship_8_short':
		$text = 'STARFIGHTER';
		break;
	case 'ship_7_name':
		$text = 'NOSTROMO';
		break;
	case 'ship_7_short':
		$text = 'STARFIGHTER';
		break;
	case 'ship_6_name':
		$text = 'PIRANHA';
		break;
	case 'ship_6_short':
		$text = 'STARFIGHTER';
		break;
	case 'ship_5_name':
		$text = 'LIBERATOR';
		break;
	case 'ship_5_short':
		$text = 'STARFIGHTER';
		break;
	case 'ship_4_name':
		$text = 'DEFCOM';
		break;
	case 'ship_4_short':
		$text = 'STARFIGHTER';
		break;
	case 'ship_3_name':
		$text = 'LEONOV';
		break;
	case 'ship_3_short':
		$text = 'STARJET';
		break;
	case 'ship_2_name':
		$text = 'YAMATO';
		break;
	case 'ship_2_short':
		$text = 'STARJET';
		break;
	case 'ship_1_name':
		$text = 'PHOENIX';
		break;
	case 'ship_1_short':
		$text = 'STARJET';
		break;
	default:
		$text = $_GET['t'];
		break;
}

// Lista de fuentes para el texto:
switch($_GET['f']) {
                    case 'ship_title':
						$fuente = 'fonts/EurostileTHea.ttf'; // Fuente para el texto
						break;
					case 'ship_name':
						$fuente = 'fonts/EurostileTHeaCon.ttf';
						break;
					default:
						//Fuente por defecto
						$fuente = 'fonts/EurostileT.ttf';
						break;
	}

// Lista de colores disponibles:
switch($_GET['uc']) {
                    case 1:
					//Blanco
						$text_color = imagecolorallocate($im, 255, 255, 255);
						break;
					default:
						//Negro por defecto
						$text_color = imagecolorallocate($im, 0, 0, 0);
						break;
	}

imagesavealpha($im, true);
imagettftext($im, $size, $inclinacion, $x, $y, $text_color, $fuente, $text);
header("Content-type: image/png");
header ("Content-Length: " . $size);
imagepng($im);
imagedestroy($im);
?>