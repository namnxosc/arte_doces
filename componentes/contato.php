<?php
	ob_start(); 
	session_name("user");
	session_start("user");
	ini_set('display_errors', E_ALL);

	if(!$_SESSION["idioma"])
	{
		$_SESSION["idioma"] = "br";
	}

	include ("inc/includes.php");

	$o_empresa = new Empresa;
	$o_empresa_contato = new Empresa_contato;
	$o_configuracao = new Configuracao;
	$o_ajudante = new Ajudante;
	
	$url_fisico = $o_configuracao->url_fisico();
	$url_virtual = $o_configuracao->url_virtual();
	
	$contato_js = "";
	
	switch($_REQUEST['acao'])
	{
		case 'enviar':
			if(trim($_REQUEST['_nome']) != "" && trim($_REQUEST['_nome']) != 'nome' && trim($_REQUEST['_email']) != "" && trim($_REQUEST['_email']) != "email")
			{
				$mensagem_mail = "Ol&aacute; <b>".$_REQUEST['_nome']."</b>. Seu mensagem foi enviado com sucesso.<br/><br/>";
						
				$mensagem_mail .= "NOME COMPLETO: <b>".$_REQUEST['_nome']."</b>.<br/>";
				$mensagem_mail .= "EMAIL: <b>".$_REQUEST['_email']."</b>.<br/>";
				$mensagem_mail .= "MENSAGEM: <b>".$_REQUEST['_mensagem']."</b>.<br/><br/>";
				if($o_ajudante->email_html("Notificação - ".$o_configuracao->site_nome(),$mensagem_mail,$o_configuracao->email_contato(),$_REQUEST['_email'],"templates/template_mailing.htm"))
				{
					$texto = "email enviado com sucesso!";
					$contato_js = '
					<script language="javascript"  type="text/javascript" >
						$(window).load(function() {						
							alert("Formul\u00e1rio enviado com sucesso.");
						});							
					</script>';
				}
				else
				{
					$contato_js = '
					<script language="javascript"  type="text/javascript" >
						$(window).load(function() {						
							alert("Envio de mensagem falhou tente mais tarde.");
						});							
					</script>';
				}
			}
		break;
	}
	
	$o_empresa->set('estado','a');
	if($rs = $o_empresa->selecionar())
	{
		foreach($rs as $linha)
		{
			$mapa = $linha['mapa'];
			$titulo = $linha['titulo'];
			$email = $linha['email'];
			$endereco = $linha['endereco'].", ";
			$numero = $linha['numero'];
			$cep = $linha['cep']." - ";
			$cidade = $linha['cidade']." - ";
			$uf = $linha['uf'];
		}
		
		$o_empresa_contato->set('id_empresa',1);
		$r = $o_empresa_contato->selecionar();
		foreach($r as $l)
		{
			if($l['tipo'] != "")
			{
				$contatos .= "<p>(".$l['ddd'].") ".$l['numero']." - ".$l['tipo']." </p>";
			}
			else
			{
				$contatos .= "<p>(".$l['ddd'].") ".$l['numero']."</p>";
			}
		}
	}
	else
	{
		$contatos = "";
	}
	
	
	$lista = array(
	"[url_virtual]" => $url_virtual,
	"[mapa]" => $mapa,
	"[titulo]" => $titulo,
	"[email]" => $email,
	"[endereco]" => $endereco,
	"[numero]" => $numero,
	"[cep]" => $cep,
	"[cidade]" => $cidade,
	"[uf]" => $uf,
	"[contatos]" => $contatos,
	"[action]" => $url_virtual."contato/enviar",
	"[contato_js]" => $contato_js
	);

	//inicializa o template para administrar as páginas
	$template = $o_ajudante->template("".$url_fisico."templates/contato.html");

	$conteudo = strtr($template,$lista);
	unset($lista);
	
	$corpo_html = $conteudo;

	unset($o_configuracao);
	unset($o_ajudante);
?>