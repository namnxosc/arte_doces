<?php
// Configura o tipo de imagem para gif
header("Content-type: image/gif");
//Configura o tamanho da fonte
$tamanhofonte = 18;
//A fonte deve ser True Type e deve estar no mesmo diretório do script
$fonte = 'La Bamba.ttf';
// O texto que será usado para criar a imagem
$texto = 'Olá mundo!';

// Criando a imagem
$tamanho = imagettfbbox($tamanhofonte, 0, $fonte, $texto);
$largura = $tamanho[2] + $tamanho[0] + 8;
$altura = abs($tamanho[1]) + abs($tamanho[7]);

$imagem = imagecreate($largura, $altura);

$corPreta = imagecolorallocate($imagem, 255, 255, 255);
imagecolortransparent($imagem, $corPreta);

// Criando as cores
$branco = imagecolorallocate($imagem, 0, 0, 17);
$preto = imagecolorallocate($imagem, 0, 0, 0);

//Adicionando o Texto na imagem
imagefttext($imagem, $tamanhofonte, 0, 0, abs($tamanho[5]), $preto, $fonte, $texto);

// Gera a imagem
imagegif($imagem); // Destrói os recursos alocados pela imagem
imagedestroy($imagem);
?>

<?php
  header("Content-type: image/jpeg");
  $im = imagecreatetruecolor(400, 70);
  $white = imagecolorallocate($im, 255, 255, 255);
  $black = imagecolorallocate($im, 0, 0, 0);
  $foto = imagecreatefromjpeg('nctg.jpg');
  $ifx = imagesx($foto);
  $ify = imagesy($foto);
  imagecopyresampled($im, $foto, 0, 0, 0, 0, $ifx, $ify, $ifx, $ify);
  imagettftext($im, 22, 0, 250, 45, $white, "Action-Man.ttf",  'Contato');
  imagejpeg($im);
  imagedestroy($im,'',100);
?>