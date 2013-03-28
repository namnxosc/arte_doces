<?php
ob_start();
session_name("adm");
session_start("adm");

/*require_once("../inc/classe_ajudante.php");
require_once("../classes/classe_imagem.php");
require_once("../classes/classe_mensagem.php");
require_once("../inc/classe_ilustra.php");*/
require_once("../inc/includes.php");

$o_ajudante = new Ajudante();
$o_configuracao = new Configuracao;
$o_ilustra = new Ilustra;

$url_virtual = $o_configuracao->url_virtual();
echo $o_ajudante->html_header($o_configuracao->site_nome(),$o_configuracao->url_virtual()."inc/formatacao_gc.css",$o_configuracao->url_virtual()."inc/java_script.js");

switch($_REQUEST["acao_visualiza"])
{
	case 'visualiza_album':
		echo $o_ajudante->mensagem(17);
		//echo $o_ajudante->ilustra($_REQUEST["id_album"],200,"<br />");
		$o_ilustra->set('album_id',$_REQUEST["id_album"]);
		$o_ilustra->set('largura','200');
		$o_ilustra->set('altura','200');
		$o_ilustra->set('separador','<br /> ');
		$o_ilustra->set('url','');
		$o_ilustra->set('acao_click','1');
		$o_ilustra->set('div_ilustra','div_mostra_imagem');
		echo $o_ilustra->galeria();
	break;


	case 'visualiza_img':
		echo $o_ajudante->mensagem(120);
		if($_REQUEST['pasta'] != "")
		{
			?>
			<img src="<?=$url_virtual?>imagens/<?=$_REQUEST["pasta"]?>/<?=$_REQUEST["img_endereco"]?>" border="0"><br>
			Endereço da imagem: [ <?=$_REQUEST["img_endereco"]?> ]
			<?php
		}
		else
		{
			?>
			<img src="<?=$url_virtual?>imagens/<?=$_REQUEST["img_endereco"]?>" border="0"><br>
			Endereço da imagem: [ <?=$_REQUEST["img_endereco"]?> ]
			<?php
		}
	break;


	default:
		echo "nada";
	break;
}
?>
<p align="center"><input type="button" value="Fechar" onClick="window.close();"</p>

<?php
echo $o_ajudante->html_footer();
unset($o_ilustra);
?>