<?php
$o_categoria = new Categoria;

echo $o_ajudante->sub_menu_gc("NOVA","msg=5&acao_adm=categoria_adm&acao=nova&layout=form","CATEGORIA");

echo $o_ajudante->mensagem($_REQUEST['msg']);
switch($_REQUEST['acao'])
{
	case 'nova':
		$o_ajudante->barrado(221);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(221);

		$o_categoria->set('nome',trim($_REQUEST['_nome']));
		$o_categoria->set('descricao',trim($_REQUEST['_descricao']));
		$o_categoria->set('estado',$_REQUEST['_estado']);
		$o_categoria->set('tipo_menu',$_REQUEST['_tipo_menu']);
		$o_categoria->set('data_hora',date("Y-m-d H:i:s"));
		$o_categoria->set('ordem', $_REQUEST['_ordem']);
		$chamada_nome = $o_ajudante->trata_texto_01_url_amigavel($_REQUEST['_nome']);
		$chamada_nome = strtolower($chamada_nome);
		$o_categoria->set('chamada_categoria', str_replace(" ", "_", $chamada_nome));
		$r = $o_categoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=categoria_adm&layout=lista&msg=7");
	break;

	case 'editar':
		$o_ajudante->barrado(221);
		$acao = "editado";

		$o_categoria->set('id',$_REQUEST['_id']);
		$rs = $o_categoria->selecionar();
		foreach($rs as $l)
		{
		}
		unset($o_categoria);
	break;

	case 'editado':
		$o_ajudante->barrado(221);
		$o_imagem = new Imagem;
		$o_imagem->set('destaque','s');
		$o_imagem->set('descricao','Imagem da categoria '.$_REQUEST['_nome_img']);
		$o_imagem->set('nome',$_REQUEST['_nome_img']);
		$o_imagem->set('estado','a');
		$o_imagem->set('id',$_REQUEST['_id_imagem']);
		$o_imagem->set('id_album',$_REQUEST['_id_album']);
		$o_imagem->editar();
		unset($o_imagem);

		$o_categoria->set('nome',trim($_REQUEST['_nome']));
		$o_categoria->set('descricao',$_REQUEST['_descricao']);
		$o_categoria->set('estado',$_REQUEST['_estado']);
		$o_categoria->set('id',$_REQUEST['_id']);
		$o_categoria->set('id_album',$_REQUEST['_id_album']);
		$o_categoria->set('id_album_02',$_REQUEST['_id_album_02']);
		$o_categoria->set('tipo_menu',$_REQUEST['_tipo_menu']);
		$o_categoria->set('ordem',$_REQUEST['_ordem']);
		$chamada_nome = $o_ajudante->trata_texto_01_url_amigavel($_REQUEST['_nome']);
		$chamada_nome = strtolower($chamada_nome);
		$o_categoria->set('chamada_categoria', str_replace(" ", "_", $chamada_nome));
		$rs = $o_categoria->editar();

		$o_auditoria->set('acao_descricao',"Edição da categoria para produtos: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=categoria_adm&layout=lista&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(221);
		$o_categoria->set('id',$_REQUEST['_id']);
		if($rs = $o_categoria->selecionar())
		{			
			$rs = $o_categoria->excluir();
			$o_auditoria->set('acao_descricao',"Exclusão de categoria: ".$_REQUEST['_id'].".");
			$o_auditoria->inserir();
			header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=categoria_adm&msg=8");			
		}
	break;

	default:
	break;
}


switch($_REQUEST['layout'])
{
	case 'form':
		?>
		<form name="formulario_categoria" id="formulario_categoria" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		
		<strong>Nome Categoria</strong>
		<input name="_nome" id="_nome" type="text" value="<?= $l["nome"]?>" size="30" maxlength="100"  onblur="javascript:valida_nome_categoria(this.value, '<?=$l['nome']?>', 'categoria');">
		<span class="requerido">*</span>
		<?php echo $o_ajudante->ajuda("Inserir nome desejado para a categoria. Máximo 100 caracteres.");?>
		<div id="div_valida"></div>
		<hr>

		<strong>Descrição</strong>
		<textarea name="_descricao" id="_descricao" onkeyup="if(this.value.length >= 2000){this.value = this.value.substring(0, 2000)} else {document.getElementById('contador').innerHTML = (2000 - this.value.length); }" cols="80" rows="6">
		<?=$l["descricao"]?>
		</textarea>
		<?php echo $o_ajudante->ajuda("Inserir descrição para o produto.");?>
		<br /><strong></strong>Ainda lhe restam <b id="contador">2000</b> caracteres.
		<hr>

		<strong>Ordem</strong>
		<?php 
		$array = array ("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",);
		echo $o_ajudante->drop_varios($array, "_ordem", $l['ordem'], "", "", "");
		?>
		<hr class="linha-cinza">

		<strong>Estado</strong>
		<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado"> on-line 
		<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado"> Off-line 
		<span class="requerido">*</span>
		<?php echo $o_ajudante->ajuda("Escolha se este categoria de produto aparecerá no site.");?>
		<hr>

		<strong> </strong>
		<input name="image" type="image"  onClick="return checa_campos('categoria');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao != "inserido")
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.formulario_categoria.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?msg=6&_id=<?=$l["id"]?>&acao=excluir&acao_adm=categoria_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>

		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="acao_adm" value="categoria_adm">
		<input type="hidden" name="_id" value="<?=$l["id"]?>">

		</form>
		<?php
	break;

	case 'lista':
		$o_categoria->set('limite',1);
		if($rs = $o_categoria->selecionar())
		{
		?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>CATEGORIA</b></th>
						<th><b>ORDEM</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>CATEGORIA</b></th>
						<th><b>ORDEM</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
					<?
					$o_categoria = new Categoria;
					$o_categoria->set('ordenador',"nome");
					if($rs = $o_categoria->selecionar())
					{
						foreach($rs as $l)
						{						
							if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}
							if($zebrado == "zebrado-01"){$zebrado = "zebrado-02";} else {$zebrado = "zebrado-01";}
							echo "<tr class=\"".$zebrado."\">";
						
							echo "<td><a title='editar' href='index.php?acao=editar&msg=3&acao_adm=".$_REQUEST["acao_adm"]."&_id=".$l["id"]."&layout=form'>".$l["nome"]."</a></td>";
							
							echo "<td align=\"center\">".$l['ordem']."</td>";
							echo "<td align=\"center\">".$l['estado']."</td>";
							echo "<td align=\"center\"><a href='index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
							echo "<td align=\"center\"><a href=javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".str_replace(' ', '_', $l["nome"])."');><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
						}
					}
					unset($o_categoria);
					?>
				</tbody>
			</table>
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
unset($o_produto);
unset($o_categoria);
?>