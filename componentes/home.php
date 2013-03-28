<?php
	ob_start(); 
	session_name("user");
	session_start("user");
	ini_set('display_errors', E_ALL);

	include ("inc/includes.php");

	$o_configuracao = new Configuracao;
	$o_ajudante = new Ajudante;

	$template = $o_ajudante->template("templates/home.html");

	$o_monta_produto = new Monta_produto;
	$o_monta_produto->set('limite_inicio', 0);
	$o_monta_produto->set('limite', 5);
	$o_monta_produto->set('estado','a');
	$o_monta_produto->set('ordenador','ordem, data desc');
	$servico_lista = $o_monta_produto->lista();

	$descricao = $servico_lista;

	$lista = array(
		"[descricao]" => $descricao
		,"[url_virtual]" => $url_virtual
	);

	$home = strtr($template,$lista);
	$corpo_html = $home;

	unset($o_configuracao);
	unset($o_ajudante);
?>