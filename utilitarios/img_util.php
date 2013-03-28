<?php
ob_start();
session_name("adm");
session_start("adm");

require_once("../inc/includes.php");


$o_ajudante = new Ajudante();
$o_arquivo_envio = new Arquivo_envio();
$o_imagem = new Imagem;
$o_album = new Album;
$o_arquivo = new Arquivo;
$o_ilustra = new Ilustra;
$o_configuracao = new Configuracao;

echo $o_ajudante->html_header($o_configuracao->site_nome(),$o_configuracao->url_virtual()."inc/formatacao_gc.css",$o_configuracao->url_virtual()."inc/java_script.js");

switch($_REQUEST["img_util"])
{
	case 'mostra':
		echo $o_ajudante->mensagem(76)."<br />";
		//echo $o_ajudante->mensagem($_REQUEST['msg']);
		?>
		<form name="form_img">
			<?php
			if($_REQUEST["img_util_endereco"] != "nada")
			{
				$PATH = "../imagens/".$_REQUEST["img_util_endereco"];
				$dir = dir($PATH);
				$dir->rewind();

				$x = 0;
				while($file = $dir->read())
				{
					if(!file_exists($file))
					{
						if($file != ".gitignore")
						{
							echo "<img src='thumbnail.php?qualidade=50&altura=40&largura=40&largura=40&img=".$PATH."/".$file."'>";
							echo $file;
							echo "</td></tr><tr><td>";
							?>
							<a href="#" onClick="passa_valor_01('<?=$file?>','<?=$_REQUEST["campo_nome"];?>');window.close();"><img src="../imagens/gc/btn_ok_02.gif" border="0"></a>
							<hr size="1" noshade></td>
							<br />
							<?
							++$x;
						}
					}
				}
				$dir->close();
			}
			?>
			<p align="center"><input type="image" class="limpo" src="../imagens/gc/btn_fechar.gif" alt="Fechar" onClick="window.close();"></a></p>
		</form>
		<?php
		$_SESSION["form_campo_global"] = "sites_clientes/$usuario_nome_site/imagens/"; //registra na sessão o nome do caminho da imagam
	break;


	
	case 'mostra_album_publico':
	
		echo $o_ajudante->mensagem(76)."<br />";
		//echo $o_ajudante->mensagem($_REQUEST['msg']);
		?>
		<script type="text/javascript">
		function busca_categoria(obj)
		{
				
			//alert(obj.options[obj.selectedIndex].value);
			location.href='img_util.php?campo_nome=_conteiner_album_imagem&img_util=mostra_album_publico&img_util_endereco=galeria&categoria='+obj.options[obj.selectedIndex].value;
		}
		
		</script>
		
		<form name="form_img">
		<table width="100%" border="0" cellspacing="0" cellpadding="6">
		<tr>
			<td>
				Busca po categoria: <select name="_combo_album_publico" id="_combo_album_publico" onchange="busca_categoria(this)"><option value="">todas as categorias</option>
				<?php
				$o_album=new Album;
				$o_album->set('id_tipo','1');
				if($r=$o_album->selecionar())
			    {
					foreach($r as $l)
					{
						if($_REQUEST['categoria']==$l['id'])
						{
							echo'<option value='.$l['id'].' selected="selected">'.$l['nome'].'</option>';
						}
						else
						{
							echo'<option value='.$l['id'].'>'.$l['nome'].'</option>';
						}
					}
			    }
				?>
				
				</select>
			</td>
		</tr>
			<?php
		
						
						$_imagem=new Imagem;
						$_imagem->set('id_tipo',1);		
						if($_REQUEST['categoria'])
						{
							$_imagem->set('id_album',$_REQUEST['categoria']);		
						}
						if($r=$_imagem->selecionar_album_imagem_02())
						{
							foreach($r as $l)
							{
								
								echo "<tr><td><img src='thumbnail.php?qualidade=50&altura=40&largura=40&largura=40&img=../imagens/".$_REQUEST['img_util_endereco']."/".$l['nome']."'>";
								echo $file;
								echo "</td></tr><tr><td>";
								
								echo '<a href="#" onClick="passa_valor_fancybox(\''.$l['nome'].'\',\''.$_REQUEST["campo_nome"].'\');parent.$.fancybox.close();"><img src="../imagens/gc/btn_ok_02.gif" border="0"></a>
								<hr size="1" noshade><br /></td></tr>';
							}
						}
						else
						{
						  echo $o_ajudante->mensagem(134)."<br />";
						}
			
			?>
			<p align="center"><input type="image" class="limpo" src="../imagens/gc/btn_fechar.gif" alt="Fechar" onclick="parent.$.fancybox.close();"></a></p>
		</form>
		<?php
		$_SESSION["form_campo_global"] = "sites_clientes/$usuario_nome_site/imagens/"; //registra na sessão o nome do caminho da imagam
	
	break;
	
	
	
	case 'mostra_flash':
		echo $o_ajudante->mensagem(65)."<br />";
		?>
		<form name="form_img">
			<?php
			if($_REQUEST["img_util_endereco"] != "nada")
			{
				$PATH = "../imagens/".$_REQUEST["img_util_endereco"]."";
				$dir = dir($PATH);
				$dir->rewind();
				$x = 0;
				while($file = $dir->read())
				{
					if(!file_exists($file))
					{
						echo $o_ajudante->monta_flash($arquivo=$file,$titulo,$corpo);
						echo"<br />";
						echo $file;
						echo "</td></tr><tr><td>";
						?>
						<a href="#" onClick="passa_valor_01('<?=$file?>','<?=$_REQUEST["campo_nome"];?>');window.close();"><img src="../imagens/gc/btn_ok_02.gif" border="0"></a>
						<hr size="1" noshade></td>
						<br />
						<?
						++$x;
					}
				}
				$dir->close();
			}
			?>
			<p align="center"><input type="image" class="limpo" src="../imagens/gc/btn_fechar.gif" alt="Fechar" onClick="window.close();"></a></p>
		</form>
		<?php
		$_SESSION["form_campo_global"] = "sites_clientes/$usuario_nome_site/imagens/"; //registra na sessão o nome do caminho da imagam
	break;


	case 'mostra_pdf':
		echo $o_ajudante->mensagem(119)."<br />";
		?>
		<form name="form_img">
			<?php
			if($_REQUEST["img_util_endereco"] != "nada")
			{
				$PATH = "../imagens/".$_REQUEST["img_util_endereco"]."";
				$dir = dir($PATH);
				$dir->rewind();
				$x = 0;
				while($file = $dir->read())
				{
					if(!file_exists($file))
					{
						echo "<img width=\"50\" height=\"50\" src=\"../imagens/site/pdf_02.gif\">";
						echo $file;
						echo "</td></tr><tr><td>";
						?>
						<a href="#" onClick="passa_valor_01('<?=$file?>','<?=$_REQUEST["campo_nome"];?>');window.close();"><img src="../imagens/gc/btn_ok_02.gif" border="0"></a>
						<hr size="1" noshade></td>
						<br />
						<?
						++$x;
					}
				}
				$dir->close();
			}
			?>
			<p align="center"><input type="image" class="limpo" src="../imagens/gc/btn_fechar.gif" alt="Fechar" onClick="window.close();"></a></p>
		</form>
		<?php
		$_SESSION["form_campo_global"] = "sites_clientes/$usuario_nome_site/imagens/"; //registra na sessão o nome do caminho da imagam
	break;


	case 'mostra_02':
		echo $o_ajudante->mensagem(67)."<br />";
		?>
		<form name="form_img">
			<?php
			if($_REQUEST["img_util_endereco"] != "nada")
			{
				$PATH = "../imagens/".$_REQUEST["img_util_endereco"];
				$dir = dir($PATH);
				$dir->rewind();
				
				$x = 0;
				while($file=$dir->read())
				{
					if(!file_exists($file))
					{
						echo "<a href=\"".$PATH."/".$file."\" titlle=\"Clique para ver a imagem\"> ".$file." </a>";
						
						?>
						<a href="#" onClick="passa_valor_01('<?=$file?>','<?=$_REQUEST["campo_nome"];?>');window.close();"><img align="absmiddle" src="../imagens/gc/btn_ok_02.gif" border="0"></a>
						<?
						
						echo "<hr>";
						++$x;
					}
				}
				$dir->close();
			}
			?>
			<p align="center"><INPUT TYPE="SUBMIT" value="FECHAR ESTA JANELA" onClick="window.close();"></p>
		</form>
		<?php
		$_SESSION["form_campo_global"] = "sites_clientes/$usuario_nome_site/imagens/"; //registra na sessão o nome do caminho da imagam
	break;


	case 'img_procura':
		echo $o_ajudante->mensagem(12)."<br />";
		?>
		<form method="post" action="<?=$_SERVER['PHP_SELF']?>?img_util=img_envia" enctype="multipart/form-data">
		<input type="file" name="arquivo" size="25"/>
		<input type="hidden" name="img_util" value="img_envia">
		<input type="hidden" name="MAX_FILE_SIZE" value="83886080">
		<input type="hidden" name="pasta_destino" value="<?=$_REQUEST["pasta_destino"]?>">
		<input type="hidden" name="campo_nome" value="<?=$_REQUEST["campo_nome"]?>">
		<input type="hidden" name="formulario" value="<?=$_REQUEST["formulario"]?>">
		<input type="submit" name="submit" value="Enviar" /> 
		</form>
		
		<?php
	break;


	case 'img_envia':
		$o_arquivo_envio->set('ftp_server',$o_configuracao->ftp_server());
		$o_arquivo_envio->set('ftp_usuario',$o_configuracao->ftp_usuario());
		$o_arquivo_envio->set('ftp_senha',$o_configuracao->ftp_senha());
		$o_arquivo_envio->set('destino',$o_configuracao->ftp_endereco().$_REQUEST["pasta_destino"]);
		$o_arquivo_envio->upload_ftp();
		?>
		<script LANGUAGE="JAVASCRIPT">
			function img_nome_passa()
			{
				window.opener.document.<?=$_REQUEST['formulario']?>.<?=$_REQUEST['campo_nome']?>.value = "<?=$_FILES['arquivo']['name']?>";
			}
		</script>
		<input type="image" class="limpo" src="../imagens/gc/btn_fechar.gif" alt="FECHAR E CONTINUAR EDITANDO" onClick="img_nome_passa();window.close();">
		<?php
	break;


	case 'img_deleta':
		echo $o_ajudante->mensagem(66)."<br />";
		?>
		<script language="JavaScript">
			function confirma_submit(mensagem)
			{
				var mensagem;
				var agree=confirm(mensagem);
				if (agree)
					return true ;
				else
					return false ;
			}
		</script>
		<table width="100%" border="0" cellspacing="0" cellpadding="6">
		<?php
			
			$PATH = "../imagens/".$_REQUEST["img_util_endereco"]."";
			$PATH_02 = "/imagens/".$_REQUEST["img_util_endereco"]."";
			$dir = dir("$PATH");
			$dir->rewind();
			while($file=$dir->read())
			{
				if(!file_exists($file))
				{
				?>
					<tr> 
					<td height="100" bgcolor="#eeeeee" background="<?=$PATH."/".$file;?>">&nbsp;</td>
					<td rowspan="2" align="center">
					<a onClick="return confirma_submit('Você está certo de que quer deletar esta imagem?')" href="<?=$_SERVER[PHP_SELF];?>?img_util=img_deletada&arquivo_del=<?=$PATH_02."/".$file;?>"><img align="absmiddle" src="../imagens/gc/btn_ok_02.gif" border="0"></a>
					</td>

					<tr> 
					<td bgcolor="#eeeeee"><?=$file;?></td>
					<tr> 
					<td colspan="3" width="30%" ><hr size="1" noshade></td>
					</tr>
				<?php
				++$x;
				}
			}
			$dir->close();
		?>
		</table>
		<p align="center"> <a href="javascript:window.close();"><img src="../imagens/gc/btn_fechar.gif" border="0" alt="fechar esta janela"></a></p>
		<?php
	break;


	case 'img_deleta_02':
		echo $o_ajudante->mensagem(93)."<br />";
		?>
		<script LANGUAGE="JavaScript">
			function confirma_submit(mensagem)
			{
				var mensagem;
				var agree=confirm(mensagem);
				if (agree)
					return true ;
				else
					return false ;
			}
		</script>
		<?php
		$usuario_nome_site = $_SESSION["usuario_nome_site"];

		$PATH = "../imagens/".$_REQUEST["img_util_endereco"]."";
		$PATH_02 = "/imagens/".$_REQUEST["img_util_endereco"]."";
		$dir = dir($PATH);
		$dir->rewind();

		while($file=$dir->read())
		{
			if(!file_exists($file))
			{
				if($_REQUEST["img_util_endereco"] == 'galeria')
				{
					if($file != ".gitignore")
					{
						echo "<tr><td><img src='thumbnail.php?qualidade=50&altura=40&largura=40&img=".$PATH."/".$file."'>";
					}
				}
				elseif($_REQUEST["img_util_endereco"] == 'flashes')
				{
					echo $o_ajudante->monta_flash($arquivo=$file,$titulo,$corpo);
					echo"<br />";
				}
				else{
					echo "<tr><td><img width=\"50\" height=\"50\" src=\"../imagens/site/pdf_02.gif\">";
				}
				if($file != ".gitignore")
				{
					echo $file;

					echo "</td></tr><tr><td>";
					?>
						<a onClick="return confirma_submit('Você está certo de que quer deletar este arquivo?')" href="<?=$_SERVER[PHP_SELF];?>?img_util=img_deletada&img_util_endereco=<?=$_REQUEST["img_util_endereco"];?>&arquivo_del=<?=$PATH_02."/".$file;?>"><img align="absmiddle" src="../imagens/gc/btn_ok_02.gif" border="0"></a>
						<hr size="1" noshade></td>
						<br />
					<?php
					++$x;
				}
			}
		}
		$dir->close();
		?>
		<p align="center"> <a href="javascript:window.close();"><img src="../imagens/gc/btn_fechar.gif" border="0" alt="fechar esta janela"></a></p>
		<?php
	break;


	case 'img_deletada':
		$arquivo_del = $_REQUEST['arquivo_del'];
		$arquivo = $arquivo_del;
		$arquivo_tratado = str_replace('/imagens/flashes/','', $arquivo);
		$arquivo_tratado = str_replace('/imagens/galeria/','', $arquivo_tratado);
		$arquivo_tratado = str_replace('/imagens/arquivos/','', $arquivo_tratado);
		$arquivo_del = "Web/clientes/bells".$arquivo_del;
		//$arquivo_del = "Web".$arquivo_del;
		$o_configuracao = new Configuracao;
		$conn_id = ftp_connect($o_configuracao->ftp_server());
		if($conn_id)
		{
			$login_result = ftp_login($conn_id, $o_configuracao->ftp_usuario(),$o_configuracao->ftp_senha());
			if ((!$conn_id) || (!$login_result))
			{ 
				echo "erro";
				// login com nome de usuário e senha
			}
			else
			{
				// tenta excluir $file
				if($_REQUEST["img_util_endereco"] =='galeria')
				{
					$o_imagem->set('nome',$arquivo_tratado);
					if($res = $o_imagem->selecionar())
					{
						$eliminar_arquivo = 'nao';
					}
					else
					{
						$eliminar_arquivo = 'sim';
					}
					unset($o_imagem);
				}
				elseif($_REQUEST["img_util_endereco"] =='flashes')
				{
					$o_flash->set('nome',$arquivo_tratado);
					if($res = $o_flash->selecionar())
					{
						$eliminar_arquivo = 'nao';
					}
					else
					{
						$eliminar_arquivo = 'sim';
					}
					unset($o_flash);
				}
				else
				{
					$o_arquivo->set('nome',$arquivo_tratado);
					if($res = $o_arquivo->selecionar())
					{
						$eliminar_arquivo = 'nao';
					}
					else
					{
						$eliminar_arquivo = 'sim';
					}
					unset($o_arquivo);
				}
				if($eliminar_arquivo == 'nao')
				{
					echo $o_ajudante->mensagem(59)."<br />";
					echo '<a href="#" onClick="window.close();"><img src="../imagens/gc/btn_fechar.gif"><a/><br />';
				}
				else
				{
					$deletado = ftp_delete($conn_id, $arquivo_del);
					if ($deletado)
					{
						$mensagem = $o_ajudante->mensagem(105);
						$mensagem_tratada = str_replace('[arquivo]',$arquivo_tratado,$mensagem);
						echo $mensagem_tratada."<br />";
						//echo $o_ajudante->mensagem(0,"t","ARQUIVO EXCLUÍDO","O arquivo ".$arquivo_tratado." foi excluído com sucesso. <a href=\"javascript:history.back();\">Clique para deletar outra</a>")."<br />";
					}
					else
					{
						$mensagem = $o_ajudante->mensagem(104);
						$mensagem_tratada = str_replace('[arquivo]',$arquivo_tratado,$mensagem);
						echo $mensagem_tratada."<br />";
						//echo $o_ajudante->mensagem(0,"t","ERRO!","Não foi possível excluir o arquivo ".$arquivo_tratado.".")."<br />";
					}
					// fecha a conexão
					ftp_close($conn_id);
				}
			}
		}
		else
		{
			echo "erro";
		}
		unset($o_configuracao);
	break;


	case 'ver_album':
		echo $o_ajudante->mensagem(17);
		$o_ilustra->set('album_id',$_REQUEST["id_album"]);
		$o_ilustra->set('largura','200');
		$o_ilustra->set('separador','<br /> ');
		$o_ilustra->set('url','');
		$o_ilustra->set('acao_click','1');
		$o_ilustra->set('div_ilustra','div_mostra_imagem');
		echo $o_ilustra->galeria();
		
	break;
	
	case 'musica_procura':
		if($_REQUEST['msg'] == '')
		{
			echo $o_ajudante->mensagem(177)."<br />";
		}
		else
		{
			echo $o_ajudante->mensagem($_REQUEST['msg'])."<br />";
		}
		?>
		<form method="post" action="<?=$_SERVER['PHP_SELF']?>?img_util=musica_envia" enctype="multipart/form-data">
		<input type="file" name="arquivo" size="25"/>
		<input type="hidden" name="img_util" value="musica_envia">
		<input type="hidden" name="MAX_FILE_SIZE" value="103886080">
		<input type="hidden" name="pasta_destino" value="<?=$_REQUEST["pasta_destino"]?>">
		<input type="hidden" name="campo_nome" value="<?=$_REQUEST["campo_nome"]?>">
		<input type="hidden" name="formulario" value="<?=$_REQUEST["formulario"]?>">
		<input type="submit" name="submit" value="Enviar" /> 
		</form>
		
		<?php
	break;
	
	case 'musica_envia':
		$extensao = substr($_FILES['arquivo']['name'], -3);

		if($extensao == 'mp3')
		{
			$o_arquivo_envio->set('ftp_server',$o_configuracao->ftp_server());
			$o_arquivo_envio->set('ftp_usuario',$o_configuracao->ftp_usuario());
			$o_arquivo_envio->set('ftp_senha',$o_configuracao->ftp_senha());
			$o_arquivo_envio->set('destino',$o_configuracao->ftp_endereco().$_REQUEST["pasta_destino"]);
			$o_arquivo_envio->upload_ftp();
			?>
			<script LANGUAGE="JAVASCRIPT">
				function img_nome_passa()
				{
					window.opener.document.<?=$_REQUEST['formulario']?>.<?=$_REQUEST['campo_nome']?>.value = "<?=$_FILES['arquivo']['name']?>";
				}
			</script>
			<input type="image" class="limpo" src="../imagens/gc/btn_fechar.gif" alt="FECHAR E CONTINUAR EDITANDO" onClick="img_nome_passa();window.close();">
			<?php
		}
		else
		{
			
			header('Location: img_util.php?formulario=formulario_musica&campo_nome=_arquivo&pasta_destino=mp3&img_util=musica_procura&msg=178');
		}
	break;

	/*
	case 'ver_album':
		$o_imagem = new Imagem();
		$o_imagem ->set('id_album',$_REQUEST['id_album']);
		$o_imagem ->set('estado','a');
		if($rs = $o_imagem->selecionar())
		{
		
		//die($qi);
			foreach($rs as $li)
			{
				if($li["nome"] == "")
				{
					$imagem = "";
				}
				else
				{
					$imagem .= "".popup_simples($li["nome"], "../imagens/galeria/".$li["nome"], "thumbnail.php?altura=120&img=../imagens/galeria/".$li["nome"], "clique para ver".$li["nome"])."";
				}
			}
		}
		else
		{
			//nao foi possível realizar a consulta à tabela de imagens!
		}
	break;
	*/

	default:
	break;
}
echo $o_ajudante->html_footer();
unset($o_arquivo_envio);
?>
