<?php
$o_usuario = new Usuario;

echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST["acao"])
{
	case 'atualizado':
		$o_ajudante->barrado(212);
		if ((!$_REQUEST['adm_senha']) AND (!$_REQUEST['re_adm_senha']))
		{
			header("Location: index.php?acao_adm=senha_adm&msg=24");
			ob_end_flush();
		}
		elseif (!$_REQUEST['adm_senha'])
		{
			header("Location: index.php?acao_adm=senha_adm&msg=26");
			ob_end_flush();
		}
		elseif (!$_REQUEST['re_adm_senha'])
		{
			header("Location: index.php?acao_adm=senha_adm&msg=26");
			ob_end_flush();
		}
		elseif ($_REQUEST['re_adm_senha']!=$_REQUEST['adm_senha'])
		{
			header("Location: index.php?acao_adm=senha_adm&msg=11");
			ob_end_flush();
		}
		else
		{
			//descobre o e-mail do usuário
			$o_usuario->set('id',$_SESSION["usuario_numero"]);
			$rs = $o_usuario->selecionar();
			foreach($rs as $l)
			{}
			$o_usuario->set('senha',$o_ajudante->cria_senha($_REQUEST['re_adm_senha']));
			$r = $o_usuario->editar_senha();

			$o_auditoria->set('acao_descricao',"Edição de usuário: ".$_REQUEST["_nome"].".");
			$o_auditoria->inserir();

			$mensagem = "Sua senha foi alterada para:\n<br /><br /><b>Senha</b>: ".$_REQUEST['re_adm_senha']."\n\n<br /><br />";

			$o_ajudante->email_html("Nome site - Alteração de senha",$mensagem,$email_contato,$l["email"],"../templates/template_email_geral.html");

			$_SESSION = array(); //limpa as variáveis de sessão
			session_destroy();

			header("Location: index.php");
			ob_end_flush();
		}
	break;

	default:
		$o_usuario->set('email',$_SESSION["email_usuario"]);
		$o_usuario->set('senha',$_SESSION["senha_usuario"]);
		$rs = $o_usuario->selecionar();
		foreach($rs as $l)
		{}
		?>
		<form class="formularios" action="index.php?acao=atualizado" method="post">
		<strong>Nova senha</strong>
		<input name="adm_senha" type="password" size="15" maxlength="10"> 
		<?php echo $o_ajudante->ajuda("Digite a nova senha desejada. Não mais que 10 caracteres.");?></td>
		<hr />

		<strong>Re-digitar nova senha</strong>
		<input name="re_adm_senha" type="password" size="15" maxlength="10"> 
		<?php echo $o_ajudante->ajuda("Redigitar a nova senha.");?>
		<hr />

		<strong>&nbsp;</strong>
		<input name="image" type="image"  alt="Salvar altera&ccedil;&otilde;es" src="../imagens/gc/btn_cadastrar.png"></td>
		<input type="hidden" name="acao_adm" value="senha_adm">
		</form>
		<?php
	break;
}
?>