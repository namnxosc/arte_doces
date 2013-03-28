<?php
   $arquivo = $_GET["arquivo"];
   if(isset($arquivo) && file_exists($arquivo))
   { // faz o teste se a variavel nуo esta vazia e se o arquivo realmente existe
      switch(strtolower(substr(strrchr(basename($arquivo),"."),1)))
	  { // verifica a extensуo do arquivo para pegar o tipo
         case "pdf": $tipo="application/pdf"; break;
         case "exe": $tipo="application/octet-stream"; break;
         case "zip": $tipo="application/zip"; break;
         case "doc": $tipo="application/msword"; break;
         case "xls": $tipo="application/vnd.ms-excel"; break;
         case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
         case "gif": $tipo="image/gif"; break;
         case "png": $tipo="image/png"; break;
         case "jpg": $tipo="image/jpg"; break;
         case "mp3": $tipo="audio/mpeg"; break;
         case "php": // deixar vazio por seuranчa
         case "htm": // deixar vazio por seuranчa
         case "html": // deixar vazio por seuranчa
      }
      header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
      header("Content-Length: ".filesize($arquivo)); // informa o tamanho do arquivo ao navegador
      header("Content-Disposition: attachment; filename=".basename($arquivo)); // informa ao navegador que щ tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
      readfile($arquivo); // lъ o arquivo
      exit; // aborta pѓs-aчѕes
	  
   }
   else
   {		
		require_once("../inc/classe_configuracao.php");
		require_once("../inc/classe_conexao.php");
		require_once("../inc/classe_executa.php");
		require_once("../inc/classe_ajudante.php");
		require_once("../inc/classe_html.php");
		require_once("../inc/classe_template.php");
		require_once("../inc/classe_menu.php");
		require_once("../classes/classe_botao.php");
		require_once("../classes/classe_linkador.php");

		$o_ajudante = new Ajudante;
		echo $o_ajudante->mensagem('Este arquivo estс indisponэvel no momento. Favor entrar em contato para normalizaчуo do serviчo. Vocъ serс redirecionado para Home em 10 segundos.','Arquivo inexistente');
		
		header('Refresh: 5; url=../'.$_GET['portal'].'/index.php'); 
   }
?>