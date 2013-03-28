<?php
ob_start();
//descobre extensão
$t_img = strlen($_GET['img']);
$t_img = $t_img - 3;
$imagem = substr($_GET['img'], $t_img,3);

switch($imagem)
{
	case "jpg":
	case "JPG":
	header("Content-type: image/jpeg");
	$im = imagecreatefromjpeg($_GET['img']);
	break;

	case "gif":
	case "GIF":
	header("Content-type: image/gif");
	$im = imagecreatefromgif($_GET['img']);
	break;

	case "png":
	case "PNG":
	header("Content-type: image/x-png");
	$im = imagecreatefrompng($_GET['img']);
	break;

	default:
	header("Content-type: image/jpeg");
	break;
}

$largura = imagesx($im);
$altura = imagesy($im);

$nova_altura = $_REQUEST['altura'];

if($_REQUEST['largura'])
{
	$nova_largura = $_REQUEST['largura'];
}
else
{
	$nova_largura = ($largura*$nova_altura)/$altura;
}

if($nova_altura != "")
{}
else
{
	$nova_altura = ceil(($nova_largura / $largura) * $altura);
}

if(!$_GET['qualidade']){$qualidade = 100;} else {$qualidade = $_GET['qualidade'];}

$nova = imagecreatetruecolor($nova_largura,$nova_altura);
//imagecopyresized($nova,$im,0,0,0,0,$largurad,$alturad,$largurao,$alturao);
imagecopyresampled($nova, $im, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura, $altura);
imagejpeg($nova, null, $qualidade);
imagedestroy($nova);
imagedestroy($im);
?>