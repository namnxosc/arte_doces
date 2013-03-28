<?php
$o_album = new Album;
$o_imagem = new Imagem;

echo $o_ajudante->sub_menu_gc("NOVO,EDITAR | EXCLUIR","msg=5&acao_adm=album_adm&acao=nova&layout=form,acao_adm=album_adm&layout=lista&msg=2","ILUSTRAR ALBUM");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	case 'nova':
		$o_ajudante->barrado(26);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(26);
		$o_album->set('nome',$_REQUEST['_nome']);
		$o_album->set('estado',$_REQUEST['_estado']);
		$o_album->set('id_album_tipo',$_REQUEST['_id_album_tipo']);
		$o_album->inserir();

		$o_auditoria->set('acao_descricao',"Inserção de novo Album: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=album_adm&layout=lista&msg=7");
	break;

	case 'editar':
		$o_ajudante->barrado(17);
		$acao = "editado";
		
		$o_album->set('id',$_REQUEST['_id']);
		$rs = $o_album->selecionar();
		foreach($rs as $l)
		{}
	break;

	case 'editado':
		$o_ajudante->barrado(17);
		$o_album->set('nome',$_REQUEST['_nome']);
		$o_album->set('estado',$_REQUEST['_estado']);
		$o_album->set('id_album_tipo',$_REQUEST['_id_album_tipo']);
		$o_album->set('id',$_REQUEST['_id']);

		$o_album->editar();
		$o_auditoria->set('acao_descricao',"Edição do Album: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=album_adm&layout=lista&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(32);
		$o_album->set('id',$_REQUEST['_id']);
		$rs = $o_album->selecionar();
		if($rs)
		{
			$o_imagem->set('id_album', $_REQUEST['_id']);
			$res = $o_imagem->selecionar();
			if($res)
			{
				echo $o_ajudante->mensagem(45);
				foreach($res as $l)
				{
					echo "Clique para excluir: <a href=\"javascript:confirma('".$_SERVER['PHP_SELF']."?_id=".$l["id"]."&acao=excluir&acao_adm=imagem_adm','".$l["nome"]."')\">".$l["nome"]."</a><br />";
				}
			}
			else
			{
				$rs = $o_album->excluir();
				$o_auditoria->set('acao_descricao',"Exclusão do Album: ".$_REQUEST['_id'].".");
				$o_auditoria->inserir();
				header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=album_adm&msg=8&layout=lista");
			}
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
			<strong>Tipo</strong>
			<select name="_id_album_tipo" size="1">
			<option value="">Selecione o tipo Álbum</option>
			<?php
			$o_album_tipo = new Album_tipo;
			$rs = $o_album_tipo->selecionar();
			foreach($rs as $linha)
			{ 
			?>
				<option value="<?=$linha["id"]?>" <?php if ($l["id_album_tipo"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
			<?php
			}
			unset($o_album_tipo);
			?>
			</select>
			<?php echo $o_ajudante->ajuda("Escolha o tipo do &Aacute;lbum para ilustrar este &Aacute;lbum.");?>
			<hr>
			
			<strong>Album</strong>
			<input name="_nome" type="text" value="<?=$l["nome"]?>" size="30" maxlength="100">
			<?php echo $o_ajudante->ajuda("Inserir nome desejado para o Álbum. Ex.: campeonatos, festas, produtos, etc. Máximo 100 caracteres.");?>
			<hr>

			<strong>Estado</strong>
			<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado"> on-line 
			<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado"> off-line 
			<?php echo $o_ajudante->ajuda("Escolha se este Álbum aparecerá no site.");?>
			<hr>

			<strong> </strong>
			<input name="image" type="image"  onClick="return checa_campos('ilustrar_album');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
			<?php
			if($acao != "inserido")
			{
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.form.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?_id=<?=$l["id"]?>&acao=excluir&acao_adm=album_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
				<?php
			}
			?>
			<input type="hidden" name="acao" value="<?=$acao?>">
			<input type="hidden" name="acao_adm" value="album_adm">
			<input type="hidden" name="_id" value="<?=$l["id"]?>">
		</form>
		<?php
	break;


	case 'lista':
		if($rs = $o_album->selecionar())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>ALBUM</b></th>
						<th><b>AMBIENTE</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				<thead>
				<tfoot>
					<tr>
						<th><b>ALBUM</b></th>
						<th><b>AMBIENTE</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				<tfoot>
				<tbody>
				<?php
				foreach($rs as $l)
				{
					if($l['id'] != 1)
					{
						if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}

						echo "<tr>";
						$o_imagem->set('id_album', $l['id']);
						if($res = $o_imagem->selecionar())
						{
							echo "<td><a target=\"_blank\" href=\"../utilitarios/visualiza_util.php?acao_visualiza=visualiza_album&id_album=".$l["id"]."\">".$l["nome"]."</a></td>";
						}
						else
						{
							echo "<td>".$l["nome"]."</td>";
						}
						echo "<td>".$l["estado"]."</td>";
						echo "<td>".$l["nome_tipo"]."</td>";
						echo "<td align=\"center\"><a href='index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
						echo "<td align=\"center\"><a href=\"javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=album_adm','".$l["nome"]."')\"><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
						echo "</tr>";
					}
				}
				?>
				</tbody>
			</table>
			<div class="spacer"></div>
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
unset($o_album);
unset($o_imagem);
?>