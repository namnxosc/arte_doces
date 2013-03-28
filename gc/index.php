<?php
ob_start();
session_name("adm");
session_start("adm");

if(!$_SESSION["idioma"])
{
	$_SESSION["idioma"] = "br";
}

//para debug
if(!$_SESSION["codifica"])
{
	$_SESSION["codifica"] = "n";
}

require_once("../inc/includes.php");

$o_configuracao = new Configuracao;
$o_auditoria = new Auditoria;
$o_ajudante = new Ajudante();
$o_menu_gc = new Menu_gc();

$menu_geral = $o_menu_gc->menu_gestor();


$site_titulo = $o_configuracao->site_titulo();
$url_virtual = $o_configuracao->url_virtual();


if($_SESSION["acesso"] != "sim")
{
	header("Location: login.php");
	ob_end_flush();
}
else
{
	//aqui começa conteúdo
	if($_SERVER['QUERY_STRING'])
	{
		$a_01 = "<a href=\"".$_SERVER['PHP_SELF']."\">";
		$a_02 = "</a>";
		$a_titulo = "Voltar &agrave; P&aacute;gina Principal";
		$principal_endereco = "index.php,";
		$principal = "P&aacute;gina Principal,";
		$principal_target = "_self,";
	}
	else
	{
		$principal_endereco = "";
		$principal = "";
		$principal_target = "";
	}

	$menu_gc = $o_ajudante->menu_pc($principal."Alterar Senha,Auditoria,Sair",$principal_endereco."index.php?acao_adm=senha_adm&msg=23,index.php?msg=13&acao_adm=auditoria&layout=lista,index.php?acao_adm=sair",$principal_target ."_self,_self,_self","|",$acao);

	$site_nome = $o_configuracao->site_nome();

	$o_configuracao->desenvolvedor_site();
	$o_configuracao->desenvolvedor();
	$o_configuracao->desenvolvedor_email();
}//fecha else de conteúdo

require_once("index_html.php");

$o_ajudante = NULL;
unset($o_ajudante);
?>