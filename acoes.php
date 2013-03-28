<?php
switch($_REQUEST["acao_adm"])
{
	case 'materia':
	case 'interna':
		require("componentes/interna.php");
	break;
	
	case 'pagina':
		require("componentes/pagina.php");
	break;

	case 'contato':
		require("componentes/contato.php");
	break;
	
	default:
		require("componentes/home.php");
	break;
}
?>