<?php
ob_start();
session_name("adm");
session_start("adm");
require("../../inc/tudo_03.php");
extract($_REQUEST);

?>

<html>
<head>
<meta http-equiv="Content-Language" content="pt-br">
<title><?=$nome_site?> :: Utilitário de Códigos</title>
<link rel="stylesheet" type="text/css" href="../../inc/painel_formatacao.css" media="screen" />
</head>
<body>

<?php
//aviso("icone_info.gif","ESCOLHER IMAGENS","$campo_nome Aqui você poderá visualizar todas suas imagens disponíveis. Para ...");


switch($cod_util)
{
case 'mostra':
break;

//==========================================================================================================

default:
aviso("","LISTAGEM DE CÓDIGOS","Veja abaixo a lista de códigos utlizados nos produtos.");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
<?php
$valor_codigo = array("***************-CATEGORIAS","01-uniforme","02-armas","03-equipamentos","04-diversos-04","***************-TAMANHOS","00-Único","01-PP","02-P","03-M","04-G","05-GG","06-6","07-8","08-10","09-12","10-14","11-16","12-18","13-24","14-25","15-26","16-27","17-28","18-29","19-30","20-31","21-32","22-33","23-34","24-35","25-36","26-37","27-38","28-39","30-40","31-41","32-42","33-43","34-44","35-45","36-46","37-M1","38-M2","39-M3","40-A1","41-A2","42-A3","43-8oz","44-10oz","45-12oz","46-14oz","47-16oz","48-18oz","***************-CORES","00-","01-Branco","02-Preto","03-Vermelho","04-Bordô","05-Cinza","06-Marrom","07-Bege","08-Verde escuro","09-Verde claro","10-Verde jade","11-Azul marinho","12-Azul turquesa","13-Lilás","14-Roxo","15-Pink","16-Rosa","17-Laranja","18-Amarelo","19-Preto c/ bege","20-Incolor","21-Preto c/ Br","22-Preto c/ Am","23-Preto c/ Vr","24-Branco c/ Preto");
foreach ($valor_codigo as $value) {
//zebrado
if($bgcolor == "#eeeeee")
{$bgcolor = "#ffffff";}
else
{$bgcolor = "#eeeeee";}
//zebrado termina
$cod = explode("-", $value);
echo "<tr onMouseover=\"this.bgColor='#cccccc';\" onMouseout=\"this.bgColor='".$bgcolor."';\" bgcolor=\"".$bgcolor."\">";
echo "<td><b>".$cod[1]."</b></td>";
echo "<td>".$cod[0]."</td>";
echo "</tr>";
}
?>
</table>
<?php

break;

//==========================================================================================================
}
?>
