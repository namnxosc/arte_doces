<?php
ob_start(); 
session_name("user");
session_start("user");

ini_set('display_errors', E_ALL);

header("Content-Type: text/html; charset=ISO-8859-1");
setlocale(LC_CTYPE,"pt_BR");

include ("../inc/includes.php");

$o_ajudante = new Ajudante;
$o_configuracao = new Configuracao;

$url_virtual = $o_configuracao->url_virtual();


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns="http://www.w3.org/1999/xhtml"> 

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="<?=$url_virtual?>inc/js/jquery.js"></script>
<script type="text/javascript" src="<?=$url_virtual?>inc/js/java_script.js"></script> 

<script type="text/javascript" src="<?=$url_virtual?>plugins/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?=$url_virtual?>plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link   type="text/css"	rel="stylesheet"  href="<?=$url_virtual?>plugins/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=$url_virtual?>inc/css/formatacao_popup.css" >
</head>
<body>
<?php


switch($_REQUEST['acao_adm'])
{
	case 'newsletter':
	
		$action = "popup_pagina.php";
		
		switch($_REQUEST['acao'])
		{
			case 'enviar':
				$o_usuario = new Usuario;
				$o_usuario->set('email',trim($_REQUEST['_email']));
				$o_usuario->set('nome',$_REQUEST['_nome']);
				$o_usuario->set('data_hora',date("Y/m/d H:i:s"));
				$o_usuario->set('estado','a');		
				$o_usuario->set('id_usuario_tipo',3);
				if($r = $o_usuario->inserir())
				{
					echo "<div class=\"div_centro\"><p>Cadastro enviado com sucesso.</p></div>";
					//header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=cliente_adm&msg=7");
						?>
						<script language="javascript"  type="text/javascript" >
							$(window).load(function() {						
								setTimeout("parent.$.fancybox.close();",10000);	
							});							
						</script>
						<?php
				}
				else
				{
					die ("Erro ao tentar cadastrar newsletter. Por favor entre em contato com o administrador do sistema.");
				}
				unset($o_usuario);
				
			break;
			
			default:
				$template = $o_ajudante->template("../templates/newsletter.html");
				$lista = array(
					"[action]" => "".$action.""
				);
				echo $conteudo = strtr($template,$lista);
			break;
		}
	break;
	
	default:
		$lista = "Sem registros!";
		echo $conteudo = $lista;
	break;
}
/*
//inicializa o template geral do site
$o_html = new Html;
$o_html->set('formatacao',''.$url_virtual.'inc/css/formatacao_popup.css');
$o_html->set('corpo',$conteudo);
echo  $o_html->codigo_html_02();
unset($o_html);
*/
?>
<input type="hidden" id="url_virtual" value="<?=$url_virtual?>">
</body>
</html>