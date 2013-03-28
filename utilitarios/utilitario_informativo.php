<?php
ob_start();
session_name("user");
session_start("user");

require_once("../inc/classe_ajudante.php");
require_once("../classes/classe_info.php");
require_once("../classes/classe_info_mensagem.php");
require_once("../classes/classe_auditoria.php");

$o_auditoria = new Auditoria();
$o_ajudante = new Ajudante();
$o_configuracao = new Configuracao;
$o_info = new Info;
$o_info_mensagem = new Info_mensagem;

echo $o_ajudante->html_header($o_configuracao->site_nome(),$o_configuracao->url_virtual()."inc/formatacao.css",$o_configuracao->url_virtual()."inc/java_script.js");

?>
<div class="quadro-geral">
<?php

switch($_REQUEST["info"])
{

	case 'info':
		echo $o_ajudante->mensagem(100);
	break;


	case 'inserir':
		echo $o_ajudante->mensagem(98);
		?>
		<form action="utilitario_informativo.php?info=inserido" method="post">
		E-mail
		<input type="text" name="_info_email" size="18">
		<input type="submit"  value="Cadastrar" border="0">
		</form>
		<br />
		<?
		echo $o_ajudante->mensagem(112);
	break;


	case 'inserido':
		if(!$o_ajudante->verifica_email($_REQUEST["_info_email"]))
		{
			$mensagem = $o_ajudante->mensagem(106);
			$mensagem_tratada = str_replace('[info_email]',$_REQUEST['_info_email'],$mensagem);
			echo $mensagem_tratada;
			//echo $o_ajudante->mensagem(0,"t","Erro!","O endereço de e-mail ".$_REQUEST["_info_email"]." é inválido. <a href=\"javascript:history.back()\">Clique aqui para tentar novamente.</a>","i"); 
		}
		else
		{
			//verifica se ja existe
			$o_info->set('email',$_REQUEST['_info_email']);
			if($rs = $o_info->selecionar())
			{
				$mensagem = $o_ajudante->mensagem(107);
				$mensagem_tratada = str_replace('[info_email]',$_REQUEST['_info_email'],$mensagem);
				echo $mensagem_tratada;
				//echo $o_ajudante->mensagem(0,"t","E-mail cadastrado","O e-mail <strong>".$_REQUEST['_info_email']."</strong> ja esta cadastrado em nossa lista.","i");
			}
			else
			{
				$o_info->set('nome','Visitante');
				$o_info->set('email',$_REQUEST['_info_email']);
				$o_info->set('estado','a');
				$o_info->set('id_info_categoria',1);
				if($r = $o_info->inserir())
				{
					$mensagem = $o_ajudante->mensagem(108);
					$mensagem_tratada = str_replace('[info_email]',$_REQUEST['_info_email'],$mensagem);
					echo $mensagem_tratada;
					//echo $o_ajudante->mensagem(0,"t","Sucesso","O e-mail <strong>".$_REQUEST['_info_email']."</strong> foi cadstrado corretamente. Agradecemos sua atencao!","i");
					$o_auditoria->set('acao_descricao',"Inserção de novo email na Info: ".$_REQUEST["_info_email"].".");
					$o_auditoria->inserir();
				}
				else
				{
					echo $o_ajudante->mensagem(85);
				}
			}
		}
	break;


	case 'sair':
		echo $o_ajudante->mensagem(88);
		?>
		<form method="post" action="utilitario_informativo.php?info=saido">
		Email  <input type="text" name="_info_email" size="18"> 
		<input type="submit"  value="Sair" >
		</form>
		<?php
	break;


	case 'saido':
		//verifica se ja existe
		$o_info->set('email',$_REQUEST['_info_email']);
		if($rs = $o_info->selecionar())
		{
			foreach($rs as $l)
			{
				$n = $rs->rowCount();
				if($n > 0)
				{
					$o_info->set('id',$_REQUEST['_id']);
					$rs = $o_info->excluir();
					$o_auditoria->set('acao_descricao',"Exclusao do email da info ".$_REQUEST['_info_email'].".");
					$o_auditoria->inserir();
					$mensagem = $o_ajudante->mensagem(109);
					$mensagem_tratada = str_replace('[info_email]',$_REQUEST['_info_email'],$mensagem);
					echo $mensagem_tratada;
					//echo $o_ajudante->mensagem(0,"t","E-mail removido","O e-mail <strong>".$_REQUEST['_info_email']."</strong> foi removido com sucesso de nossa lista.","i");
				}
			}
		}
		else
		{
			$mensagem = $o_ajudante->mensagem(110);
			$mensagem_tratada = str_replace('[info_email]',$_REQUEST['_info_email'],$mensagem);
			echo $mensagem_tratada;
			//echo $o_ajudante->mensagem(0,"t","Usuario Nao Removido","Nao foi possivel encontrar <strong>".$_REQUEST['_info_email']."</strong>. Seu e-mail nao deve estar em nossa lista. Por favor <a href=\"javascript:history.go(-1)\">tente novamente</a>. Ou entre em contato conosco");
		}
		//echo $mensagem_tratada;
	break;


	case 'arquivo_lista':
		echo $o_ajudante->mensagem(89);
		$o_info_mensagem->set('estado','a');
		$rs = $o_info_mensagem->selecionar();
		foreach($rs as $l)
		{
			echo $l["data"]." - <a href=\"utilitario_informativo.php?info=mensagem&_id=".$l["id"]."\">".$l["nome"]."</a><br />\n";
		}
	break;


	case 'mensagem':
		$o_info_mensagem->set('id',$_REQUEST['_id']);
		$rs = $o_info_mensagem->selecionar();
		foreach($rs as $l)
		{
			echo $o_ajudante->mensagem(0,"t",$l["nome"],$l["data"]."<br />".$l["corpo"],"msg_neutra");
		}
	break;


	default:
		echo $o_ajudante->mensagem(87);
		echo "Escolha um item abaixo.";
	break;
}
?>
<br>
<hr class="linha-1">
<p>

<a href="utilitario_informativo.php?info=inserir">Cadastrar-se</a> | 
<a href="utilitario_informativo.php?info=sair">Sair da Lista</a> | 
<a href="utilitario_informativo.php?info=arquivo_lista">Mensagens</a>
<br>
<br>

<p class="centralizar"><input type="submit" onClick="javascript:window.close();" value="Fechar esta Janela" ></p>
</div>
</body>
</html>