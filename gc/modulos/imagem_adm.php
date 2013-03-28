<?php
//a fazer
$o_imagem = new Imagem;
echo $o_ajudante->sub_menu_gc("NOVA,EDITAR | EXCLUIR","msg=5&acao_adm=imagem_adm&acao=nova&layout=form,msg=6&acao_adm=imagem_adm&layout=lista&msg=2","ILUSTRAR IMAGENS");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	case 'nova':
	$o_ajudante->barrado(36);
	$acao = "inserido";
	break;


	case 'inserido':
		$o_ajudante->barrado(36);
		if (!$_REQUEST['_album_id'])
		{
			alerta("Favor retornar e escolher um albúm.");
		}
		else
		{
			$o_imagem->set('nome',$_REQUEST['_nome']);
			$o_imagem->set('id_album',$_REQUEST['_album_id']);
			$o_imagem->set('descricao',$_REQUEST['_descricao']);
			$o_imagem->set('destaque',$_REQUEST['_destaque']);
			$o_imagem->set('estado',$_REQUEST['_estado']);
			$r = $o_imagem->inserir();
			$o_auditoria->set('acao_descricao',"Inserção de nova Imagem: <b>".$_REQUEST['_nome']."</b>.");
			$o_auditoria->inserir();
			header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=imagem_adm&layout=lista&msg=7");
		}
	break;


	case 'editar':
		$o_ajudante->barrado(35);
		$acao = "editado";
		$o_imagem->set('id',$_REQUEST['_id']);
		$rs = $o_imagem->selecionar();
		foreach($rs as $l)
		{}
	break;


	case 'editado':
		$o_ajudante->barrado(35);
		$o_imagem->set('id_album',$_REQUEST['_album_id']);
		$o_imagem->set('destaque',$_REQUEST['_destaque']);
		$o_imagem->set('descricao',$_REQUEST['_descricao']);
		$o_imagem->set('nome',$_REQUEST['_nome']);
		$o_imagem->set('estado',$_REQUEST['_estado']);
		$o_imagem->set('id',$_REQUEST['_id']);

		$rs = $o_imagem->editar();
		$o_auditoria->set('acao_descricao',"Edição da imagem: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=imagem_adm&layout=lista&id=".$id."&msg=1");
	break;


	case 'excluir':
		$o_ajudante->barrado(30);
		$o_imagem->set('id',$_REQUEST['_id']);
		$rs = $o_imagem->excluir();

		$o_auditoria->set('acao_descricao',"Exclusão da imagem: ".$_REQUEST['id'].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=imagem_adm&msg=8&layout=lista");
	break;

	case 'json';
		echo '{ "aaData": [
			["Tridenteeeeee","Internet Explorer 4.0","Win 95+","4","X"],
			["Trident","Internet Explorer 5.0","Win 95+","5","C"],
			["Tasman","Internet Explorer 5.2","Mac OS 8-X","1","C"],
			["Misc","NetFront 3.1","Embedded devices","-","C"],
			["Misc","NetFront 3.4","Embedded devices","-","A"],
			["Misc","Dillo 0.8","Embedded devices","-","X"],
			["Misc","Links","Text only","-","X"],
			["Misc","Lynx","Text only","-","X"],
			["Misc","IE Mobile","Windows Mobile 6","-","C"],
			["Misc","PSP browser","PSP","-","C"],
			["Other browsers","All others","-","-","U"]
		] }';
		exit;
		die();
	break;

	default:
	break;
}


switch($_REQUEST['layout'])
{

	case 'form': 
		?>
		<form name="formulario_imagem" id="formulario_imagem" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<strong>Album</strong>
		<select name="_album_id" size="1">
		<option value="">Selecione um Álbum</option>
		<?php
		$o_album = new Album;
		$o_album->set('ordenador','nome');
		$rs = $o_album->selecionar();
		foreach($rs as $linha)
		{ 
		?>
			<option value="<?=$linha["id"]?>" <?php if ($l["id_album"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
		<?php
		}
		?>
		</select>
		<?php echo $o_ajudante->btn_img("Clique aqui para inserir um novo Álbum.","index.php?msg=5&acao_adm=album_adm&acao=nova&layout=form","btn_novo.png","0");?>
		<?php
		unset($o_album);
		echo $o_ajudante->ajuda("Escolha um &Aacute;lbum.");
		?>
		<hr>

		<strong>Imagem</strong>
		<input name="_nome" id="_nome" type="text" size="30" readonly="readonly" value="<?=$l["nome"]?>" />
		<?php if($acao != "inserido"){echo $o_ajudante->btn_img("Clique para visualizar sua imagem atual.","javascript:abre_janela_02('../utilitarios/visualiza_util.php?acao_visualiza=visualiza_img&img_endereco=imagens/galeria/".$l["nome"]."','img_util','scrollbars=yes,resizable=yes,width=450,height=300');","btn_visualizar.png","0");}?>
		<?php echo $o_ajudante->btn_img("Clique para visualizar as imagens que voc&ecirc; j&aacute; tem.","javascript:abre_janela_02('../utilitarios/img_util.php?campo_nome=_nome&img_util=mostra&img_util_endereco=galeria','img_util','scrollbars=yes,resizable=yes,width=450,height=300');","btn_ver.png","0");?>
		<?php echo $o_ajudante->btn_img("Clique para deletar uma imagem.","javascript:abre_janela_02('../utilitarios/img_util.php?img_util=img_deleta_02&img_util_endereco=galeria','img_util','scrollbars=yes,resizable=yes,width=450,height=300');","btn_deleta.png","0");?>
		<?php echo $o_ajudante->btn_img("Clique para enviar uma nova imagem.","javascript:abre_janela_02('../utilitarios/img_util.php?formulario=formulario_imagem&campo_nome=_nome&pasta_destino=galeria&img_util=img_procura','img_util','scrollbars=yes,resizable=yes,width=450,height=300');","btn_envia.png","0");?>
		<?php echo $o_ajudante->ajuda("Escolha a imagem. Lembre-se que a extensão da imagem deve estar em letras minúsculas. Exemplo: .jpg");?>
		<hr>

		<strong>Descri&ccedil;&atilde;o</strong>
		<textarea rows="5" name="_descricao" cols="33"><?=$l["descricao"]?></textarea>
		<?php echo $o_ajudante->ajuda("Breve descri&ccedil;&atilde;o da imagem. Máximo 250 caracteres.");?>
		<hr>

		<strong>Destaque</strong>
		<input type="radio"  value="s" <?php if ($l["destaque"] == "s") echo "checked";?> name="_destaque"> sim 
		<input type="radio"  value="n" <?php if ($l["destaque"] == "n") echo "checked";?> name="_destaque"> n&atilde;o
		<?php echo $o_ajudante->ajuda("Escolha se esta imagem será a principal imagem do seu album.");?>
		<hr>

		<strong>Estado</strong>
		<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado"> on-line 
		<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado"> off-line 
		<?php echo $o_ajudante->ajuda("Escolha se esta Imagem aparecerá no site.");?>
		<hr>

		<strong> </strong>
		<input name="image" type="image"  onClick="return checa_campos('ilustrar_imagem');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao != "inserido")
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.formulario_imagem.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?msg=6&id=<?=$l["id"]?>&acao=excluir&acao_adm=imagem_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>
		<input type="hidden" name="acao_adm" value="imagem_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="_id" value="<?=$l["id"]?>">
		</form>
		<?php
	break;

	case 'lista':

		$o_imagem->set('limite',1);
		$o_imagem->set('ordenador',"nome_album");
		if($rs = $o_imagem->selecionar_album_imagem())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>ALBUM</b></th>
						<th><b>NOME DA IMAGEM</b></th>
						<th><b>DESCRIÇÃO</b></th>
						<th><b>DESTAQUE</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>ALBUM</b></th>
						<th><b>NOME DA IMAGEM</b></th>
						<th><b>DESCRIÇÃO</b></th>
						<th><b>DESTAQUE</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$o_imagem = new Imagem;
				$o_imagem->set('ordenador',"nome_album");
				if($rs = $o_imagem->selecionar_album_imagem())
				{
					foreach($rs as $l)
					{
						if($l['id'] != 1)
						{
							if($l["destaque"] == "s"){$l["destaque"] = "sim";}else{$l["destaque"] = "não";}
							if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}

							echo "<tr>";
							echo "<td><a target='_blank' href='../utilitarios/visualiza_util.php?acao_visualiza=visualiza_album&id_album=".$l["id_album"]."'>".$l["nome_album"]." [".$l["id_album"]."]</a></td>";
							if($l['id_album_tipo'] == 1)
							{
								$pasta = "produtos";
							}
							else
							{
								$pasta = "galeria";
							}
							
							echo "<td><a target='_blank' href='../utilitarios/visualiza_util.php?acao_visualiza=visualiza_img&img_endereco=".$pasta."/".$l["nome"]."'>".$l["nome"]."</a></td>";
							echo "<td>".$l['descricao']."</td>";
							echo "<td align=\"center\">".$l['destaque']."</td>";
							echo "<td align=\"center\">".$l['estado']."</td>";
							echo "<td align=\"center\"><a href='index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
							echo "<td align=\"center\"><a href=javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["nome"]."');><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
							echo "</tr>";
						}
					}
				}
				unset($o_imagem);
				?>
				</tbody>
			</table>
			<br/><br/><br/>
			<?php
		}
		else
		{
			echo $o_ajudante->mensagem(14);
		}
	break;


default:
break;
}
?>