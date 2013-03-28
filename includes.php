<?php
ini_set('display_errors', E_ALL);

if($_SERVER['SERVER_NAME'] == "localhost")
{
	$c = "/Applications/XAMPP/xamppfiles/htdocs/oportunidade/";
}
else
{
	//$c = "/home/krakendigital/public_html/clientes/oportunidade/";
	$c = "/var/www/vhosts/agenciaguapa.com.br/httpdocs/clientes/oportunidade/";
}

//****
require_once($c."inc/classe_configuracao.php");
require_once($c."inc/classe_conexao.php");
require_once($c."inc/classe_executa.php");
require_once($c."inc/classe_ajudante.php");

//Album e Imagens
require_once($c."classes/classe_album.php");
require_once($c."classes/classe_album_tipo.php");
require_once($c."classes/classe_imagem.php");

//Arquivos
require_once($c."classes/classe_arquivo.php");
require_once($c."inc/classe_arquivo_envio.php");

//Excel
require_once($c."inc/excel/Excel.read.php");
require_once($c."inc/excel/XLSX.read.php");

//Grafico
require_once($c."inc/classe_monta_grafico.php");

//Auditoria
require_once($c."classes/classe_auditoria.php");

//Mensagens
require_once($c."classes/classe_mensagem.php");

//Mensagens
require_once($c."classes/classe_email.php");

//Menus
require_once($c."classes/classe_menu_site.php");
require_once($c."classes/classe_menu_ambiente.php");
require_once($c."inc/classe_menu.php");
require_once($c."inc/classe_menu_gc.php");
require_once($c."inc/classe_menu_produto.php");

//Site
require_once($c."inc/classe_monta_site.php");

//Usuarios
require_once($c."classes/classe_usuario.php");
require_once($c."classes/classe_usuario_ambiente.php");
require_once($c."classes/classe_usuario_tipo.php");
require_once($c."classes/classe_ambiente.php");

//Utilidades em Geral
require_once($c."inc/classe_html.php");
require_once($c."inc/classe_ilustra.php");
require_once($c."inc/classe_template.php");

//Backup
require_once($c."classes/classe_backup.php");

//Pagina
require_once($c."classes/classe_pagina.php");
require_once($c."classes/classe_pagina_tipo.php");
require_once($c."classes/classe_pagina_estilo.php");

//Categoria
require_once($c."classes/classe_categoria.php");
require_once($c."classes/classe_categoria_produto.php");

//Produto
require_once($c."classes/classe_produto.php");
require_once($c."classes/classe_produto_materia.php");
require_once($c."inc/classe_monta_produto.php");
require_once($c."classes/classe_produto_tipo.php");

//Empresa
require_once($c."classes/classe_empresa.php");
require_once($c."classes/classe_empresa_contato.php");

//Enquete
require_once($c."classes/classe_pergunta.php");
require_once($c."classes/classe_pergunta_questao.php");

//Apoiadores
require_once($c."classes/classe_apoiadores.php");

//Css frond end
require_once($c."classes/classe_css.php");

//Rezise Image //Leandro
require_once($c."inc/classe_resize_img.php");
?>