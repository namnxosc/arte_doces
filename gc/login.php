<?php
ob_start();
session_name("adm");
session_start("adm");

require_once("../inc/classe_configuracao.php");
require_once("../inc/classe_conexao.php");
require_once("../inc/classe_executa.php");
require_once("../classes/classe_usuario.php");
require_once("../classes/classe_mensagem.php");
require_once("../classes/classe_auditoria.php");
require_once("../classes/classe_usuario_ambiente.php");
require_once("../inc/classe_ajudante.php");

$o_usuario = new Usuario;
$o_auditoria = new Auditoria;
$o_ajudante = new Ajudante();
$o_configuracao = new Configuracao;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<link rel="stylesheet" type="text/css" href="../inc/css/formatacao_gc.css" media="screen" />

<title><?=$o_configuracao->site_nome()?> : Sistema de Gest�o</title>
</head>

<body>
<?php
ini_set('display_errors', E_ALL);

switch($_REQUEST["acao_logar"])
{
	case 'sair':
		$o_usuario->set('data_acesso',date("Y/m/d H:i:s"));
		$o_usuario->set('id',$_SESSION["usuario_numero"]);

		$rs = $o_usuario->editar_data_acesso();

		$o_auditoria->set('acao_descricao',"Saiu do sistema: ".$_SESSION["usuario_numero"].".");
		$o_auditoria->inserir();

		$_SESSION = array(); //limpa as vari�veis de sess�o
		session_destroy();

		header("Location: index.php");
		ob_end_flush();
	break;


	case 'envia_senha':
		if(trim($_POST['email']) != "")
		{
			$o_usuario->set('email',$o_ajudante->trata_input($_POST['email']));
			if(!$rs = $o_usuario->selecionar())
			{
				//usu�rio n�o existe
				header("Location: login.php?p=c");
			}
			else
			{
				foreach($rs as $l)
				{
					//echo $l["id"];
					$o_ajudante->envia_senha($l["id"]);
				}
			}
		}
		else
		{
			echo $o_ajudante->mensagem(52);
		}
	break;


	case 'logado':
		//trata dados do usu�rio
		$nome = htmlspecialchars($o_ajudante->trata_input($_POST['_nome']));
		$senha = htmlspecialchars($o_ajudante->trata_input($_POST['_senha']));

		if(!(empty($nome) AND ($senha)))
		{
			 //busca usu�rio cuso tipo � igual aos dados enviados e tipo = 1 (administrador)
			$o_usuario->set('login',$nome);
			$o_usuario->set('senha',$senha);
			//$o_usuario->set('estado','a');

			if($rs = $o_usuario->selecionar_usuario_pessoa())
			{
				//usu�rio existe - registra as informa��es na sess�o
				
				foreach($rs as $linha)
				{
					$_SESSION["usuario_numero"] = $linha["usuario_id"];
					$_SESSION["usuario_usuario"] = $linha["usuario_nome"];
					$_SESSION["usuario_tipo_id"] = $linha["id"];
					$_SESSION["usuario_adm_tipo"] = $linha["tipo_nome"];
					$_SESSION["usuario_data_hora"] = $linha["data_acesso"];
					$_SESSION["acesso"] = "sim";
				}

				//insere todas permiss�es em vari�vel de sess�o
				$o_usuario_ambiente = new Usuario_ambiente;
				$o_usuario_ambiente->set('id_usuario_tipo',$_SESSION["usuario_tipo_id"]);
				if($rs = $o_usuario_ambiente->selecionar())
				{
					foreach($rs as $l)
					{
						$grupo_ambientes[] = $l['id_ambiente'];
					}
				}
				$_SESSION['grupo_ambientes'] = $grupo_ambientes;

				//print_r($_SESSION['grupo_ambientes']);
				
				$o_auditoria->set('acao_descricao',"Acessou o sistema.");
				$o_auditoria->inserir();

				header("Location: index.php");
				exit();
			}
			else
			{
				header("Location: login.php?p=a"); 
				exit();
			}
		}
		else
		{
			echo "Favor digitar corretamente usu�rio e senha.";
		}
	break;


	default:
		switch($_REQUEST['p'])
		{
			case "a":
				$msg = "N�o foi poss�vel o acesso ao Gestor de Conte�do. Os dados que voc� ingressou est�o incorretos ou seu usu�rio encontra-se off-line. Tente novamente, ou entre em contato com seu webmaster <a href=\"mailto:?Subject=Problema%20no%20Acesso%20-%20Painel%20de%20Controle%20:%20$nome_site&body=Digite%20aqui%20o%20problema...\">clicando aqui</a>.";
			break;

			case "b":
				$msg = "Entre com seus dados abaixo para ter acesso ao Painel de Controle do $nome_site";
			break;

			case "c":
				$msg = "Este e-mail n�o existe no nosso banco de dados. Clique no endere�o de e-mail a seguir para entrar em contato: <a href='mailto:".$o_configuracao->email_contato()."?subject=Senha Perdida&Body=Favor enviar minha senha. Meus dados para contato s�o: (favor enviar nome, telefone e e-mail.'>".$o_configuracao->email_contato()."</a>.";
			break;

			default:
				$msg = "Entre com seus dados abaixo para ter acesso ao Gestor de Conte�do.";
			break;
		}

		?>
		<div id="caixa-login">
			<div>
				<span>
					<img src="../imagens/gc/login_logo.png" alt="logo" />
				</span>
				<span>
					<h1>IDENTIFICA&Ccedil;&Atilde;O</h1>
					<?=$msg?>
					<br />
					<br />
					<form name="formulario_logar" method="post" action="<?=$_SERVER['PHP_SELF']?>?acao_logar=logado&url_02=<?=$url_01?>">
						<strong>Nome</strong><input name="_nome" id="_nome" size="20">
						<hr />
						<strong>senha</strong><input type="password" size="20" value name="_senha">
						<hr />
						<strong>&nbsp;</strong><input  type="image" src="../imagens/gc/btn_entrar.gif" alt="entrar" onclick="return checa_campos('login');" width="86" height="20" />
					</form>

					<p>Se n&atilde;o se recorda da senha, preencha o campo abaixo com o e-mail usado seu no cadastro, que o sistema lhe enviar&aacute; sua senha.</p>
					<form name="form_senha_perdida" method="post" action="<?=$_SERVER['PHP_SELF']?>?acao_logar=envia_senha">
						<strong>E-mail:</strong> <input type="text" size="20" name="email">
						<hr />
						<strong>&nbsp;</strong><input type="image" src="../imagens/gc/btn_recuperar.gif" alt="recuperar senha" width="86" height="20" />
					</form>
				</span>
			</div>
		</div>
		<?php
	break;
}
?>
</body>
</html>