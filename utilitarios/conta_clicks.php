<?php
	ob_start();
	
	require_once("../classes/classe_publicidade.php");
	
	$o_publicidade = new Publicidade;
	$o_publicidade->set('id',$_REQUEST['publicidade_id']);
	$rs = $o_publicidade->selecionar();
	
	$l=mysql_fetch_array($rs);
	
	$l["clicks"] = $l["clicks"] + 1;
	
	//atualiza número de clicks
	
	$o_publicidade->set('clicks',$l["clicks"]);
	$o_publicidade->set('id',$_REQUEST['publicidade_id']);
	$rs = $o_publicidade->editar_clicks();
	
	header("Location: ".$l["url"]."");
	ob_end_flush();

?>