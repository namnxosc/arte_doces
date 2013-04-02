<?php
//a fazer
$o_produto = new Produto;
$o_auditoria = new Auditoria;

echo $o_ajudante->sub_menu_gc("NOVO","msg=5&acao_adm=materia_adm&acao=nova&layout=form","materia");

echo $o_ajudante->mensagem($_REQUEST['msg']);
switch($_REQUEST['acao'])
{
	case 'nova':
		$o_ajudante->barrado(222);
		$acao = "inserido";

		$o_album = new Album;
		$o_album->set('estado', 'x');
		$date = date('Y-m-d', strtotime('-1 day'));
		$o_album->set('criterio', 'DATE_FORMAT(data_hora, \'%Y-%m-%d\') <= \''.$date.'\'');
		if($rs = $o_album->selecionar())
		{
			foreach($rs as $l_album)
			{
				$o_imagem = new Imagem;
				$o_imagem->set('id_album', $l_album['id']);
				if($rs = $o_imagem->selecionar())
				{
					foreach($rs as $l_imagem)
					{
						$file = "../imagens/produtos/".$l_imagem['nome'];//trocar o endere�o
						if(file_exists($file))
						{
							unlink($file); 
						}
						$o_imagem->set('id',$l_imagem['id']);
						$o_imagem->excluir();
					}
				}
				unset($o_imagem);
				$o_album->set('id',$l_album['id']);
				$rs = $o_album->excluir();
			}
		}
		unset($o_album);

		for($i=0; $i<1; $i++)
		{
			$o_album = new Album;
			$o_album->set('nome', date("Y-m-d H:i:s"));
			$o_album->set('estado', 'x');
			$o_album->set('data_hora', date("Y-m-d H:i:s"));
			$o_album->set('id_album_tipo', '1');
			if($o_album->inserir())
			{
				if($rs = $o_album->selecionar())
				{
					foreach($rs as $l_album)
					{
						switch ($i)
						{
							case '0':
								$id_album = $l_album['id'];
								$_SESSION['id_album_uploads'] = $id_album;
							break;

						}
					}
				}
			}
			unset($o_album);
		}
		
		unset($o_album);
	break;

	case 'inserido':
		

		$o_ajudante->barrado(222);

		if(!isset($_REQUEST['_ordem']))
		{
			$_REQUEST['_ordem'] = 'z';
		}
		
		$o_produto->set('nome',$_REQUEST['_nome']);
		$o_produto->set('corpo',trim($_REQUEST['_corpo']));
		$o_produto->set('data',date("Y-m-d H:i:s"));
		$o_produto->set('estilo',$_REQUEST['_estilo']);
		$o_produto->set('estado',$_REQUEST['_estado']);
		$o_produto->set('ordem', $_REQUEST['_ordem']);
		$o_produto->set('id_album',$_REQUEST['_id_album']);
		$chamada_nome = $o_ajudante->trata_texto_01_url_amigavel($_REQUEST['_nome']);
		$chamada_nome = strtolower($chamada_nome);
		$o_produto->set('chamada_produto', str_replace(" ", "_", $chamada_nome));
		
		if($o_produto->inserir())
		{
			if($rs = $o_produto->selecionar())
			{
				foreach($rs as $l)
				{
					$id_produto = $l["id"];
				}			

				//insere todos os blogs criados
				$num_02 = count($_REQUEST['_id_album_blog_js']);
				for($i = 0; $i<$num_02; $i++)
				{				
					$o_produto_materia = new Produto_materia;
					$o_produto_materia->set('nome',$_REQUEST['_nome_blog_js'][$i]);
					$o_produto_materia->set('corpo',$_REQUEST['_corpo_blog_js'][$i]);
					$o_produto_materia->set('id_album',$_REQUEST['_id_album_blog_js'][$i]);
					$o_produto_materia->set('id_produto',$id_produto);
					if($o_produto_materia->inserir())
					{}else
					{
						die("Erro ao tentar inserir um registro na categoria");
					}
					
					$o_album = new Album;
					$o_album->set('estado', 'a');
					$o_album->set('id', $_REQUEST['_id_album_blog_js'][$i]);
					$o_album->editar_nome();
					unset($o_album);
					
					unset($o_produto_materia);
				}
				
				//insere todas as categorias selecionadas anteriormente
				$num = count($_REQUEST['cmp_categoria_id']);
				for($i = 0; $i<$num; $i++)
				{
					$o_categoria_produto = new Categoria_produto;
					$o_categoria_produto->set('id_categoria',$_REQUEST['cmp_categoria_id'][$i]);
					$o_categoria_produto->set('id_produto',$id_produto);
					if($r = $o_categoria_produto->inserir())
					{}else
					{
						die("Error ao tentar inserir a categoria_produto");
					}
					unset($o_categoria_produto);
				}
				

				$o_auditoria->set('acao_descricao',"Inser��o de uma nova materia: ".$_REQUEST["_nome"].".");
				if($o_auditoria->inserir())
				{}else
				{
					die("Erro ao tentar inserir um registro na categoria");
				}

				$o_album = new Album;
				$o_album->set('estado', 'a');
				$o_album->set('nome', 'Album da mat�ria '.$_REQUEST['_nome']);
				$o_album->set('id_album_tipo', '1');
				$o_album->set('id', $_REQUEST['_id_album']);
				$o_album->editar();
				unset($o_album);

				header("Location: ".$_SERVER['PHP_SELF']."?msg=5&acao_adm=materia_adm&layout=lista");
			}
			else
			{
				die ("Error ao tentar selecionar a materia criada");
			}
		}
		else
		{
			die ("Error ao tentar inserir o produto");
		}
		ob_end_flush();
	break;

	case 'editar':
		$o_ajudante->barrado(222);
		$acao = "editado";

		$o_produto->set('id',$_REQUEST['_id']);
		$o_produto->set('tipo_produto','m');
		$o_produto->set('limite',1);
		if($rs = $o_produto->selecionar())
		{
			foreach($rs as $l)
			{
				?>
				<script language="javascript">
					$(window).load(function() {
						ajaxHTML('div_ajax_resultado','../inc/busca_ajax.php?combo=1&quero=&tipo=lista_imagens&parametro=<?=$l['id_album']?>&div=div_ajax_resultado');
					});
				</script>
				<?php
			}
			
			$id_album = $l['id_album'];
			$_SESSION['id_album_uploads'] = $id_album;
			
			$o_monta_site = new Monta_site;
			$o_monta_site->set('id_produto', $l['id']);
			if($div_blog_lista = $o_monta_site->monta_lista_blog())
			{
				
			}
			else
			{
				$div_blog_lista = "";
			}
			
		}
		else
		{
			die("Erro ao tentar selecionar produto selecionar_produto_complemento_02 ");
		}
	break;


	case 'editado':
		
		$o_ajudante->barrado(222);
		$id_produto = $_REQUEST['_id'];

		if(!isset($_REQUEST['_ordem']))
		{
			$_REQUEST['_ordem'] = 'z';
		}
		
		$o_produto->set('nome',$_REQUEST['_nome']);
		$o_produto->set('corpo',trim($_REQUEST['_corpo']));
		$o_produto->set('data',date("Y-m-d H:i:s"));
		$o_produto->set('estado',$_REQUEST['_estado']);
		$o_produto->set('estilo',$_REQUEST['_estilo']);
		
		$o_produto->set('ordem', $_REQUEST['_ordem']);
		$o_produto->set('id_album',$_REQUEST['_id_album']);
		$o_produto->set('id',$_REQUEST['_id']);
		$chamada_nome = $o_ajudante->trata_texto_01_url_amigavel($_REQUEST['_nome']);
		$chamada_nome = strtolower($chamada_nome);
		$o_produto->set('chamada_produto', str_replace(" ", "_", $chamada_nome));
		
		if($rs = $o_produto->editar())
		{
			
			$o_categoria_produto = new Categoria_produto;
			//deleta o categorias do produto selecionado
			$o_categoria_produto->set('id_produto', $_REQUEST['_id']);
			$o_categoria_produto->excluir();
			
			//insere todas as categorias selecionadas anteriormente
			$num = count($_REQUEST['cmp_categoria_id']);
			for($i = 0; $i<$num; $i++)
			{
				$o_categoria_produto->set('id_categoria',$_REQUEST['cmp_categoria_id'][$i]);
				$o_categoria_produto->set('id_produto',$_REQUEST['_id']);
				if($r = $o_categoria_produto->inserir())
				{}else
				{
					die("Error ao tentar inserir a categoria_produto");
				}
			}
			
			$num_02 = count($_REQUEST['_id_produto_materia_']);
			for($i = 0; $i<$num_02; $i++)
			{				
				$o_produto_materia = new Produto_materia;
				$o_produto_materia->set('nome',$_REQUEST['_nome_blog_'][$i]);
				$o_produto_materia->set('corpo',$_REQUEST['_corpo_blog_'][$i]);
				$o_produto_materia->set('id_produto',$_REQUEST['_id']);
				$o_produto_materia->set('id',$_REQUEST['_id_produto_materia_'][$i]);
				$o_produto_materia->editar();
				
				$o_album = new Album;
				$o_album->set('estado', 'a');
				$o_album->set('id', $_REQUEST['_id_album_blog_'][$i]);
				$o_album->editar_nome();
				unset($o_album);
				
				unset($o_produto_materia);
			}
			
			//insere todos os assuntos selecionados anteriormente
			$num_02 = count($_REQUEST['_id_album_blog_js']);
			for($i = 0; $i<$num_02; $i++)
			{				
				$o_produto_materia = new Produto_materia;
				$o_produto_materia->set('nome',$_REQUEST['_nome_blog_js'][$i]);
				$o_produto_materia->set('corpo',addslashes($_REQUEST['_corpo_blog_js'][$i]));
				$o_produto_materia->set('id_album',$_REQUEST['_id_album_blog_js'][$i]);
				$o_produto_materia->set('id_produto',$_REQUEST['_id']);
				if($o_produto_materia->inserir())
				{}else
				{
					die("Erro ao tentar inserir um registro na categoria");
				}
				
				$o_album = new Album;
				$o_album->set('estado', 'a');
				$o_album->set('id', $_REQUEST['_id_album_blog_js'][$i]);
				$o_album->editar_nome();
				unset($o_album);
				
				unset($o_produto_materia);
			}

			$o_auditoria->set('acao_descricao',"Edi��o da mat�ria: ".$_REQUEST["_nome"].".");
			$o_auditoria->inserir();

			header("Location: index.php?acao_adm=materia_adm&layout=lista&msg=1");
		}
		else
		{
			die("Erro ao tentar editar mat�ria");
		}
	break;

	case 'excluir':
		$o_ajudante->barrado(222);
		$o_produto->set('id',$_REQUEST['_id']);
		if($rs = $o_produto->selecionar())
		{
			foreach($rs as $l)
			{
				if($l['id_album'] > 0)
				{
					$o_imagem = new Imagem;
					$o_imagem->set('id_album', $l['id_album']);
					if($rs_img = $o_imagem->selecionar())
					{
						foreach($rs_img as $l_img)
						{
							if(file_exists("../imagens/produtos/".$l_img["nome"]))
							{
								unlink("../imagens/produtos/".$l_img['nome']);
							}
							
							$o_imagem->set('id', $l_img['id']);
							if($rs_i = $o_imagem->selecionar())
							{
								foreach($rs_i as $l_i)
								{
								}
							}
							$o_imagem->excluir();
						}
					}
					unset($o_imagem);
				}

				if($l['id_album_02'] > 0)
				{
					$o_imagem = new Imagem;
					$o_imagem->set('id_album', $l['id_album_02']);
					if($rs_img = $o_imagem->selecionar())
					{
						foreach($rs_img as $l_img)
						{
							if(file_exists("../imagens/produtos/".$l_img["nome"]))
							{
								unlink("../imagens/produtos/".$l_img['nome']);
							}
						
							$o_imagem->set('id', $l_img['id']);
							if($rs_i = $o_imagem->selecionar())
							{
								foreach($rs_i as $l_i)
								{
								}
							}
							$o_imagem->excluir();
						}
					}
					unset($o_imagem);
				}

				if($l['id_album_03'] > 0)
				{
					$o_imagem = new Imagem;
					$o_imagem->set('id_album', $l['id_album_03']);
					if($rs_img = $o_imagem->selecionar())
					{
						foreach($rs_img as $l_img)
						{
							if(file_exists("../imagens/produtos/".$l_img["nome"]))
							{
								unlink("../imagens/produtos/".$l_img['nome']);
							}

							$o_imagem->set('id', $l_img['id']);
							if($rs_i = $o_imagem->selecionar())
							{
								foreach($rs_i as $l_i)
								{
								}
							}
							$o_imagem->excluir();
						}
					}
					unset($o_imagem);
				}

				if($l['id_album_04'] > 0)
				{
					$o_imagem = new Imagem;
					$o_imagem->set('id_album', $l['id_album_04']);
					if($rs_img = $o_imagem->selecionar())
					{
						foreach($rs_img as $l_img)
						{
							if(file_exists("../imagens/produtos/".$l_img["nome"]))
							{
								unlink("../imagens/produtos/".$l_img['nome']);
							}
							$o_imagem->set('id', $l_img['id']);
							if($rs_i = $o_imagem->selecionar())
							{
								foreach($rs_i as $l_i)
								{
								}
							}
							$o_imagem->excluir();
						}
					}
					unset($o_imagem);
				}

				$rs = $o_produto->excluir();

				$o_categoria_produto = new Categoria_produto;
				$o_categoria_produto->set('id_produto', $_REQUEST['_id']);
				$o_categoria_produto->excluir();
				unset($o_categoria_produto);

				$o_auditoria->set('acao_descricao',"Exclus�o da Mat�ria: ".$_REQUEST['_id'].".");
				$o_auditoria->inserir();
				header("Location: index.php?acao_adm=materia_adm&msg=8&layout=lista");
			}
		}
		else
		{
			die("Erro ao tentar excluir Mat�ria.");
		}
	break;

	default:
	break;
}


switch($_REQUEST['layout'])
{
	case 'form': 
		?>
		<form name="form" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<strong>Nome da Materia</strong>
		<input name="_nome" id="_nome" type="text" value="<?=$l["nome"]?>" size="50" maxlength="150" tabindex="1" onblur="javascript:valida_nome(this.value, '<?=$l['nome']?>', 'produto');">
		<span class="requerido">*</span>
		<?php echo $o_ajudante->ajuda("Inserir nome desejado para a Materia. Ex.: campeonatos, festas, produtos, etc. M�ximo 100 caracteres.");?>
		<div id="div_valida"></div>
		<hr>

		<strong>Descri��o</strong>
		<textarea name="_corpo" id="_corpo"  cols="80" rows="6" tabindex="2"><?=$l["corpo"]?></textarea>
		<br/><br/>
		<hr>
		
		<strong>Categoria</strong>
		<?php
		if($acao == "editado")
		{
			$o_categoria_produto = new Categoria_produto;
			$o_categoria_produto->set('id_produto', $l['id']);
		}
		else
		{
			$o_categoria_produto = new Categoria;
		}
		
		$o_categoria_produto->set('estado','a');
		$o_categoria_produto->set('ordenador', 'ordem');
		$o_categoria_produto->set('not_in', '23');
		if($acao == "editado")
		{
			$rs = $o_categoria_produto->selecionar_categoria_produto();
		}
		else
		{
			$rs = $o_categoria_produto->selecionar();
		}
		if($rs)
		{
			$n = $rs->rowCount();
			$n = $n / 2+1;
			$n = round($n);
			
			$x = 1;
			$texto_02 = "
			<table width=\"30%\" border=\"0\">
			  <tr>
				<td width=\"50%\">
			";
			$cont=0;
			foreach($rs as $linha)
			{ 
				if($x == $n)
				{
					$texto_02 .= "</td><td width=\"50%\">";
				}
				else
				{
					$texto_02 .= "";
				}
				if($linha["tem_alguma"] != '') 
				{
					$checado= " checked=\"checked\" ";
				}
				else
				{
					$checado= "  ";
				}	
				$texto_02 .= "<input ".$checado." class=\"limpo\" name=\"cmp_categoria_id[]\" type=\"checkbox\" id=\"cmp_categoria_id".$cont."\" value=\"".$linha["id"]." \"  />  <label for=\"cmp_categoria_id".$cont."\">".$linha["nome"]."</b></label><br>";
				$x++;
				$cont++;
			}
			$texto_02 .= "</tr>
						</table>
						<span class=\"requerido\">*</span>
			";
		}
		echo $texto_02;
		?>
		<strong></strong>
		<?php
		unset($o_categoria_produto);
		echo $o_ajudante->ajuda("Escolha as categorias.");?>
		<br /><br /><hr>
	
		<strong>Ordem:</strong>
		<?php 
		$array = array ("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",);
		echo $o_ajudante->drop_varios($array, "_ordem", $l['ordem'], "", "", "");
		echo $o_ajudante->ajuda("Selecione a ordem da mat�ria.");
		?>
		<hr>
		
		<strong></strong><h2>BLOG</h2>
		
		<strong>Imagem Interna</strong>
		<select name="_id_album_blog" id="_id_album_blog" tabindex="3" size="1">
		<option value="">Selecione um �lbum</option>
		<?php
		$o_album = new Album;
		$o_album->set('id_album_tipo','4');
		if($rs_alb_blog = $o_album->selecionar())
		{
			foreach($rs_alb_blog as $l_alb)
			{
				echo "<option value=\"".$l_alb["id"]."\" >".$l_alb["nome"]."</option>";
			}
		}
		?>
		</select>
		<a id="add" class="ajuda" href="javascript:popup_geral('blog','novo_blog');"><img src="../imagens/gc/btn_novo.png" align="absmiddle" >
		<span>Clique aqui para adicionar novo Album.</span></a>
		<?php
		unset($o_album);
		?>
		<hr>
		
		<strong>Descri��o</strong>
		<textarea name="_corpo_blog" id="_corpo_blog" tabindex="4" cols="80" rows="6">
		</textarea>
		<br/>

		<strong></strong>
		<input type="button" value="Adicionar" tabindex="5" onclick="javascript:adiciona_blog();">
		<br/><br/>
		
		<div id="div_blog">
			<div id="div_blog_lista"><?=$div_blog_lista?></div>
			<div id="div_blog_novo"></div>
		</div>
		<input name="_numero_campos_blog" id="_numero_campos_blog" type="hidden" value="0" size="10" maxlength="10"/>
		<hr>
		
		<div id="div_carrega_imagem">
			<input type="hidden" name="_id_album" id="_id_album" value="<?=$id_album?>">
			<strong>Imagem em destaque (vis�vel na home)</strong><br />
			<div id="file-uploader-demo1">
				<noscript>
					<input tabindex="6"  name="_arquivo" id="_arquivo" type="file">
					<input type="file" name="img[]" class="multi" accept="jpeg|jpg|png|gif" />
					<input type="submit" name="upload" value="Upload" />
				</noscript>
			</div>
			<strong></strong>
			<input type="button" name="_on" value=" todas " onclick="jqCheckAll('cmp_<?=$id_album?>_img', 1);"/>
			<input type="button" name="_off" value=" nenhuma " onclick="jqCheckAll('cmp_<?=$id_album?>_img', 0);"/>
			<input type="button" name="_exc" value=" excluir " onclick="javascript:apagar_imagens('<?=$id_album?>', 'cmp_<?=$id_album?>_img','div_ajax_resultado');"/>
			<hr class="hr_invisible">
		</div>

		<strong></strong>
		<div id="div_ajax_resultado"></div>
		<hr>

	

		<strong>Largura do destaque na home</strong>
		<input type="radio"  value="p" <?php if ($l["estilo"] == "p") echo "checked";?> name="_estilo" id="check_p" tabindex="7" > <img src="../imagens/site/img_menor.png" onclick="javasrcipt: for_radio('p');" />
		<input type="radio"  value="m" <?php if ($l["estilo"] == "m") echo "checked";?> name="_estilo" id="check_m" tabindex="8"> <img src="../imagens/site/img_mediano.png" onclick="javasrcipt: for_radio('m');"/> 
		
		<span class="requerido">*</span>
		<?php echo $o_ajudante->ajuda("Escolha o tamanho do box da imagem na home.");?>
		<hr>

		<script language="javascript">
				$(window).load(function() {
					createUploader('album_01', 'file-uploader-demo1','div_ajax_resultado');
					
				});
			/*	$("#arquivo").fileUpload({
		      'uploader': '../gc/componentes/uploader.swf',
		      'cancelImg': '../gc/componentes/cancel.png',
		      'folder': '../gc/componentes/upload',
		      'script': '../gc/componentes/uploads.php?id_album=' + <?= $id_album?>,
		      'fileDesc': 'Image Files',
		      'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
		      'multi': true,
		      'auto': true,
		      'scriptData' : {'variavel':'alguma-variavel-de-controle'}
		      
		   });*/
		</script> 


		<strong>Estado</strong>
		<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado" tabindex="11"> on-line 
		<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado" tabindex="12"> off-line 
		<span class="requerido">*</span>
		<?php echo $o_ajudante->ajuda("Escolha se esta Materia est� dispon�vel.");?>
		<hr>

		<strong> </strong>
		<input name="image" type="image"  onClick="return checa_campos('produto_materia');"  alt="Salvar altera��es" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao != "inserido")
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.form.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?msg=6&_id=<?=$l["id"]?>&acao=excluir&acao_adm=materia_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>

		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="id_album_" value="<?=$_REQUEST['id_album']?>">
		<input type="hidden" name="acao_adm" value="materia_adm">
		<input type="hidden" name="_id" value="<?=$l["id"]?>">
		</form>
		<?php
	break;

	case 'lista':
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>MAT�RIA</b></th>
						<th><b>CATEGORIA</b></th>
						<th><b>IMAGEM</b></th>
						<th><b>ORDEM</b></th>
						<th><b>ESTADO</b></th>
						
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>MAT�RIA</b></th>
						<th><b>CATEGORIA</b></th>
						<th><b>IMAGEM</b></th>
						
						<th><b>ORDEM</b></th>
						<th><b>ESTADO</b></th>
						
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
					<?php 
					$o_produto = new Produto;
					$o_produto->set('ordenador',"nome");
					if($rs = $o_produto->selecionar())
					{
						foreach($rs as $l)
						{
							$o_ilustra = new Ilustra;
							$o_ilustra->set('album_id',$l['id_album']);
							$o_ilustra->set('largura','40');
							$o_ilustra->set('altura','40');
							$o_ilustra->set('limite','1');
							$o_ilustra->set('pasta','produtos');
							$o_ilustra->set('acao_click', '1');
							$o_ilustra->set('separador',' ');
							$imagem = $o_ilustra->galeria();

							if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}
							if($l["na_home"] == "s"){$l["na_home"] = "sim";}else{$l["na_home"] = "n�o";}
							
							echo "<tr>";
							echo "<td>".$l['nome']."</td>";
							$nome_assunto = "";
							
							
							$nome_categoria = "";
							$o_categoria_produto = new Categoria_produto;
							$o_categoria_produto->set('id_produto', $l['id']);
							if($rs_02 = $o_categoria_produto->selecionar_categoria_produto_02())
							{
								foreach($rs_02 as $l_02)
								{
									$nome_categoria .= $l_02['nome']." - ";
								}
								$nome_categoria = substr($nome_categoria, 0, -2);
							}
							else
							{
								$nome_categoria = "";
							}
							unset($o_categoria_produto);
							echo "<td>".$nome_categoria."</td>";
							
							echo "<td align=\"center\">".$imagem."</td>";

							echo "<td align=\"center\">".$l['ordem']."</td>";
							echo "<td align=\"center\">".$l['estado']."</td>";
							
							echo "<td align=\"center\"><a href='index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";							
							echo "<td align=\"center\"><a href=javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".str_replace(' ', '_', $l["nome"])."');><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
							
							echo "</tr>";
							unset($o_ilustra);
						}
					}
					unset($o_produto);
					?>
				</tbody>
			</table>
			<br/><br/><br/>
			<?php
	break;

	default:
	break;
}
unset($o_produto);
unset($o_usuario_produto);
unset($o_categoria_produto);
?>