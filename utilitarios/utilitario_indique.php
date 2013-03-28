<?php
ob_start();
session_name("user");
session_start("user");

include ("../inc/includes.php");

$o_valida = new Valida();
$o_auditoria = new Auditoria();
$o_ajudante = new Ajudante();
$o_configuracao = new Configuracao;
//$o_info = new Info;
//$o_info_mensagem = new Info_mensagem;


switch($_REQUEST["acao"])
{
case "enviar":
	$rmt_nome = trim($_REQUEST["rmt_nome"]); 
	$rmt_email = trim($_REQUEST["rmt_email"]); 
	$dest_nome = trim($_REQUEST["dest_nome"]); 
	$dest_email = trim($_REQUEST["dest_email"]); 
	if($rmt_nome == "" || $rmt_email == "" || $dest_nome == "" || $dest_email == "")
	{ 
		header("Location: ".$_SERVER['PHP_SELF']."?msg=1");
		exit(); 
	}
	else
	{
		$o_valida->set('email',$rmt_email);
		if(!$o_valida->email())
		{ 
			$o_valida->set('email',$dest_email);
			if(!$o_valida->email())
			{
				header("Location: ".$_SERVER['PHP_SELF']."?msg=2"); 
				exit(); 
			}
		}
		else
		{
			$mensagem = "<html><body>Oi ".$dest_nome.",<br>Acessei esse site e achei interessante:<a href=\"".$_REQUEST["pagina"]."\">".$_REQUEST["pagina"]."</a><br>Atenciosamente ".$rmt_nome.".<br>E-mail: ".$rmt_email."</body></html>";
			$de = $o_configuracao->email_contato();
			$quebra_linha = "\r\n";
			$cabecalho = "From: ".$de.$quebra_linha;
			$cabecalho .= "MIME-Version: 1.0".$quebra_linha;
			$cabecalho .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
			$cabecalho .= "Reply-To: ".$de.$quebra_linha;
			
			if(mail($dest_email,"Site Indicado por ".$rmt_nome."",$mensagem,$cabecalho))
			{
				$mensagem = $o_ajudante->mensagem(113);
				$mensagem_tratada = str_replace('[dest_nome] - [dest_email]',$dest_nome." - ".$dest_email,$mensagem);
				$msg = $mensagem_tratada;
			}
			else
			{
				$msg = $o_ajudante->mensagem(96);
			}
		}
	}
	unset($o_valida);
	
	//Pega Template
	$conteudo = $o_ajudante->template("../templates/utilitario_indique_form.html");
	$lista = array(
		"[mensagem]" => "",
		"[msg]" => "".$msg."",
		"[pagina]" => "".urldecode($_REQUEST["pagina"])."",
		"[id]" => "".$_REQUEST['produto_id'].""
	);
	$resultado = strtr($conteudo,$lista);
break;


default:
	switch($_REQUEST["msg"])
	{
		case "1":
			$msg = $o_ajudante->mensagem(94);
		break;
		
		case "2":
			$msg = $o_ajudante->mensagem(97);
		break;
		
		default:
			$msg = $o_ajudante->mensagem(99);
		break;
	}

		//Pega Template
		$conteudo = $o_ajudante->template("../templates/utilitario_indique_form.html");
		$lista = array(
			"[mensagem]" => "",
			"[msg]" => "".$msg."",
			"[pagina]" => "".urldecode($_REQUEST["pagina"])."",
			"[id]" => "".$_REQUEST['produto_id'].""
		);
		$resultado = strtr($conteudo,$lista);
break;	
}

//inicializa o template geral do site
$o_html = new Html;
$o_html->set('corpo',$resultado);
echo  $o_html->codigo_html_02();
unset($o_html);
?>