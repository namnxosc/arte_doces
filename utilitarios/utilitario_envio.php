<?php
ob_start();
session_name("user");
session_start("user");

include ("../inc/includes.php");

$o_valida = new Valida();
$o_auditoria = new Auditoria();
$o_ajudante = new Ajudante();
$o_configuracao = new Configuracao;
$o_info = new Info;
$o_produto_envio = new Produto_envio;


switch($_REQUEST["acao"])
{
	case "enviar":
		
		$rmt_nome = $_REQUEST["rmt_nome"];
		$rmt_email = $_REQUEST["rmt_email"];
		
				if($_REQUEST["_receber_info"])
				{
					$o_info->set("email",$rmt_email);
					if(!($rs = $o_info->selecionar()))
					{
						$o_info->set("nome",$rmt_nome);
						$o_info->set("email",$rmt_email);
						$o_info->set("id_info_categoria","1");
						$o_info->set("estado","a");
						$o_info->inserir();

						$o_auditoria->set('acao_descricao',"Novo usuário deseja receber informações: ".$rmt_email.".");
						$o_auditoria->inserir();
					}
				}

				//Ingressa ao banco o produto desejado pelo usuário.
				$o_produto_envio->set("email",$rmt_email);
				$o_produto_envio->set("id_produto",$_REQUEST['produto_id']);
				$o_produto_envio->set("id_produto_complemento",$_REQUEST['complemento_id']);
				if(!($rs = $o_produto_envio->selecionar()))
				{
					$o_produto_envio->set("nome",$rmt_nome);
					$o_produto_envio->set("enviado","n");
					$o_produto_envio->set("data",date("Y-m-d H:i:s"));
					$o_produto_envio->inserir();

					$o_auditoria->set('acao_descricao',"Novo usuário deseja produto faltante: ".$rmt_email.".");
					$o_auditoria->inserir();
					$msg = $o_ajudante->mensagem(127);
				}
				else
				{
					$msg = $o_ajudante->mensagem(128);
				}
		unset($o_valida);
		
	//Pega Template
	$conteudo = $o_ajudante->template("../templates/utilitario_envio_form.html");
	$lista = array(
		"[mensagem]" => "",
		"[msg]" => "".$msg."",
		"[rmt_nome]" => "",
		"[rmt_email]" => "",
		"[pagina]" => "".urldecode($_REQUEST["pagina"])."",
		"[id]" => "".$_REQUEST['produto_id'].""
	);
	$resultado = strtr($conteudo,$lista);

	break;


	default:
		if ($_SESSION["acesso"] != "sim")
		{
			$rmt_nome = trim($_REQUEST["rmt_nome"]); 
			$rmt_email = trim($_REQUEST["rmt_email"]); 
		}
		else
		{
			$o_pessoa_dado = new Pessoa_dado;
			$o_pessoa_dado->set('id_usuario',$_SESSION["usuario_numero"]);
			$rs = $o_pessoa_dado->selecionar_02();
			if($rs)
			{
				foreach($rs as $l)
				{
				
				$rmt_nome = trim($l['nome']);
				$rmt_email = trim($l['email']);
				
				}
			}
		}
	
		switch($_REQUEST["msg"])
		{
			case "1":
				$msg = $o_ajudante->mensagem(125)."<br />";
			break;

			case "2":
				$msg = $o_ajudante->mensagem(126)."<br />";
			break;

			default:
				$msg = $o_ajudante->mensagem(124)."<br />";
			break;
		}

		//Pega Template
		$conteudo = $o_ajudante->template("../templates/utilitario_envio_form.html");
		$lista = array(
			"[complemento_id]" => "".$_REQUEST["complemento_id"]."",
			"[rmt_nome]" => "".$rmt_nome."",
			"[rmt_email]" => "".$rmt_email."",
			"[msg]" => "".$msg."",
			"[pagina]" => "".urldecode($_REQUEST["pagina"])."",
			"[id]" => "".$_REQUEST["id"].""
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