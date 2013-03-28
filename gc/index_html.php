<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 

<Meta http-equiv="Pragma" content="no-cache"> 
<Meta name="RATING" content="General"> 

<title><?=$site_titulo?></title> 
	<style type="text/css" title="currentStyle">
		@import "../plugins/tables/m/css/demo_page.css";
		@import "../plugins/tables/m/css/demo_table_jui.css";
		@import "../plugins/tables/themes/smoothness/jquery-ui-1.8.4.custom.css";
		@import "../plugins/tables/media/css/TableTools_JUI.css";
	</style>

	<script type="text/javascript" charset="utf-8" src="../plugins/tables/m/js/jquery.js"></script>
	<script type="text/javascript" charset="utf-8" src="../plugins/tables/m/js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf-8" src="../plugins/tables/media/js/ZeroClipboard.js"></script>
	<script type="text/javascript" charset="utf-8" src="../plugins/tables/media/js/TableTools.js"></script>

<script src="../inc/js/fileuploader.js" type="text/javascript"></script>
	
	<!--<script src="componentes/jquery.fileupload.js" type="text/javascript"></script>-->
	<script src="../inc/js/jquery.blockUI.js" type="text/javascript"></script>

	<script type="text/javascript" src="../plugins/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="../plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../plugins/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

	<script src="../plugins/graficos/jquery.charts.js"></script> 

	<!--Dados estadisticos-->
		<link class="include" rel="stylesheet" type="text/css" href="../plugins/chars/jquery.jqplot.min.css" />
		<link rel="stylesheet" type="text/css" href="../plugins/chars/examples/examples.min.css" />
		<link type="text/css" rel="stylesheet" href="../plugins/chars/examples/syntaxhighlighter/styles/shCoreDefault.min.css" />
		<link type="text/css" rel="stylesheet" href="../plugins/chars/examples/syntaxhighlighter/styles/shThemejqPlot.min.css" />

		<!-- Don't touch this! -->
		<script class="include" type="text/javascript" src="../plugins/chars/jquery.jqplot.min.js"></script>
		<script type="text/javascript" src="../plugins/chars/examples/syntaxhighlighter/scripts/shCore.min.js"></script>
		<script type="text/javascript" src="../plugins/chars/examples/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
		<script type="text/javascript" src="../plugins/chars/examples/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
		<!-- End Don't touch this! -->

		<!-- Additional plugins go here -->
		<script class="include" language="javascript" type="text/javascript" src="../plugins/chars/plugins/jqplot.barRenderer.min.js"></script>
		<script class="include" language="javascript" type="text/javascript" src="../plugins/chars/plugins/jqplot.categoryAxisRenderer.min.js"></script>
		<script class="include" language="javascript" type="text/javascript" src="../plugins/chars/plugins/jqplot.pointLabels.min.js"></script>

		<script class="include" language="javascript" type="text/javascript" src="../plugins/chars/plugins/jqplot.dateAxisRenderer.min.js"></script>
		<script class="include" language="javascript" type="text/javascript" src="../plugins/chars/plugins/jqplot.canvasTextRenderer.min.js"></script>
		<script class="include" language="javascript" type="text/javascript" src="../plugins/chars/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
		<script class="include" language="javascript" type="text/javascript" src="../plugins/chars/plugins/jqplot.categoryAxisRenderer.min.js"></script>
		<script class="include" language="javascript" type="text/javascript" src="../plugins/chars/plugins/jqplot.barRenderer.min.js"></script>
		<!-- End additional plugins -->
	<!--fim Dados estadisticos-->

	<!--Mascara de Validação-->
	<script language="JavaScript" type="text/javascript" src="../inc/js/MascaraValidacao.js"></script>

	<!-- Areas de texto  -->
	<script type="text/javascript" src="../plugins/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

	<script src="../inc/js/java_script.js"></script> 
	
	<link href="../inc/css/formatacao_gc.css" rel="stylesheet" type="text/css">

	<?php 
		if($_REQUEST['layout'] == 'lista' || $_REQUEST['layout'] == 'lista_arquivo' || $_REQUEST['layout'] == 'exportar' || $_REQUEST['layout'] == 'historico')
		{
			if($_REQUEST['json'])
			{
				$id_empresa = $_REQUEST['json'];
				$tipo = $_REQUEST['json_nome'];
				$url="&empresa=".$id_empresa."&dado=".$tipo;
			}
			else
			{
				$url="";
			}
			if($_REQUEST['display'])
			{
				$display = $_REQUEST['display'];
			}
			else
			{
				$display = 50; 
			}

			if($_REQUEST['acao_adm'] == 'relatorio_adm')
			{
				$sDom = "";
			}
			else
			{
				$sDom = "
					\"sDom\": '<\"H\"Tfr>t<\"F\"ip>',
						\"oTableTools\": {
							\"aButtons\": [\"xls\"]
						},
						\"sDom\": '<\"H\"Tfr>bFilter<\"F\"ip>'
				";
			}

			?>
			<script type="text/javascript" charset="utf-8">
				//var url_virtual="http://www.hm2.com.br/clientes/king/";
				var url_virtual="localhost/clientes/king/";
				
				$(document).ready( function () {
					var oTable = $('#example').dataTable( {
						"bJQueryUI": true,
						"bProcessing": true,
						"bServerSide": false,
						"iDisplayLength": <?=$display?>,  
						"sPaginationType": "full_numbers",

						<?=$sDom?>
					} );
				} );
			</script>
			<?php
		}
		if($_REQUEST['layout'] == 'form' || $_REQUEST['layout'] == 'form_materia' || $_REQUEST['layout'] == 'form_produto')
		{
			?>
			<script type="text/javascript">
			

	   
			tinyMCE.init({
				// General options
				mode : "exact",
				theme : "advanced",
				elements : "_corpo,_corpo_blog",
				plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

				// Theme options
				theme_advanced_buttons1 : "save|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontsizeselect,|,image,|,undo,redo,|,code,fullscreen,|,forecolor,backcolor",
				theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,print,fullscreen",
				//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				// Example content CSS (should be your site CSS)
				content_css : "css/content.css",

				// Drop lists for link/image/media/template dialogs
				template_external_list_url : "lists/template_list.js",
				external_link_list_url : "lists/link_list.js",
				external_image_list_url : "lists/image_list.js",
				media_external_list_url : "lists/media_list.js",

				// Style formats
				style_formats : [
					{title : 'Bold text', inline : 'b'},
					{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
					{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
					{title : 'Example 1', inline : 'span', classes : 'example1'},
					{title : 'Example 2', inline : 'span', classes : 'example2'},
					{title : 'Table styles'},
					{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
				],

				// Replace values for the template plugin
				template_replace_values : {
					username : "Some User",
					staffid : "991234"
				}
			});
		</script>
		<?php
		}
	?>
</head> 

<body> 
	<div id="topo" class="topo"><img src="../imagens/gc/topo_logo.png" width="50" height="50" alt="" />
		<div id="esquerda">Bem vindo ao Gestor de Conteúdo, <?=$_SESSION["usuario_usuario"]?> (<?=$_SESSION["usuario_adm_tipo"]?> - <?=$_SESSION["usuario_numero"]?>) - Último acesso: <?=$_SESSION["usuario_data_hora"]?> 		</div>
		<div id="direita"><?=$menu_gc?></div>
	</div>

	<div id="topo_menu" class="topo_menu">
		<?=$a_01?><img src="../imagens/gc/menu_logo.png" width="160" height="112" alt="<?=$a_titulo?>" /><?=$a_02?>
		<span>
			<div id="menu"><?=$menu_geral?></div>
		</span>
	</div>

	<div id="topo_menu" class="topo_menu_sombra"></div>

	<div id="conteudo_borda" class="conteudo_borda"><!-- abre  conteudo_borda-->
		<div id="conteudo" class="conteudo"><!-- abre  conteudo-->
			<div id="conteudo_dentro" class="conteudo_dentro"><!-- abre  conteudo_dentro-->
			<?php require("acoes.php");?>
			</div><!-- fecha  conteudo_dentro-->
		</div><!-- fecha  conteudo-->
	</div><!-- fecha  conteudo_borda-->

	<div id="rodape" class="rodape">
		<div id="rodape_dentro" class="rodape_dentro"></div>
	</div>
	<div id="ajax_notificacoes" style="visibility:hidden"></div>
	<input type="hidden" id="url_virtual" value="<?=$url_virtual?>"/>
</body> 
</html>