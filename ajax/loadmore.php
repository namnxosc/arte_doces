<?php
ob_start(); 
session_name("user");
session_start("user");

ini_set('display_errors', E_ALL);

header("Content-Type: text/html; charset=ISO-8859-1");
setlocale(LC_CTYPE,"pt_BR");

include ("../inc/includes.php");

$mostrar_div = 5;

$limite_inicio_ajax = ($_GET['limite_01']*$mostrar_div)-$mostrar_div;
	
$o_monta_produto = new Monta_produto;
$o_monta_produto->set('limite_inicio', $limite_inicio_ajax);
$o_monta_produto->set('limite', $mostrar_div);
$o_monta_produto->set('estado','a');
$o_monta_produto->set('ordenador','ordem, data desc');
if($servico_lista = $o_monta_produto->lista())
{
	
	echo $servico_lista;

}
else
{
	echo "sem_registros";
}
unset($o_monta_produto);


?>