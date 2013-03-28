<?php 
	ob_start(); 
	session_name("user");
	session_start("user");

	ini_set('display_errors', E_ALL);

	$title_face_fb = "";
	$url_face_fb = "";
	$description_face_fb = "";
	$image_face_fb = "";
	
	include ("inc/includes.php");
	include ("acoes.php");

	//inicializa o template geral do site
	$o_html = new Html;
	$o_html->set('title_face_fb',$title_face_fb);
	$o_html->set('url_face_fb',$url_face_fb);
	$o_html->set('description_face_fb',$description_face_fb);
	$o_html->set('image_face_fb',$image_face_fb);
	$o_html->set('corpo',$corpo_html);
	$o_html->set('home',$home);	
	echo $o_html->codigo_html();

	unset($o_html);
	unset($o_ajudante);
	unset($o_configuracao);
?>