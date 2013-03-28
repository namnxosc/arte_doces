<?php
$o_usuario_tipo = new Usuario_tipo;

echo $o_ajudante->sub_menu_gc("NOVO,EDITAR | EXCLUIR","msg=5&acao_adm=usuario_tipo_adm&acao=novo&layout=form,acao_adm=usuario_tipo_adm&layout=lista&msg=2","SISTEMA USUÁRIO TIPO");

echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST["acao"])
{
	case 'novo':
		$o_ajudante->barrado(140);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(140);
		$o_usuario_tipo->set('nome',$_REQUEST['_nome']);
		$r = $o_usuario_tipo->inserir();

		$o_auditoria->set('acao_descricao',"Inserção de novo tipo de usuário: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=usuario_tipo_adm&acao=&layout=lista&msg=7");
	break;

	case 'editar':
		$o_ajudante->barrado(138);
		$acao = "editado";

		$o_usuario_tipo->set('id',$_REQUEST['_id']);
		$rs = $o_usuario_tipo->selecionar();
		foreach($rs as $l)
		{}
	break;

	case 'editado':
		$o_ajudante->barrado(138);

		$o_usuario_tipo->set('nome',$_REQUEST['_nome']);
		$o_usuario_tipo->set('id',$_REQUEST['_id']);

		$rs = $o_usuario_tipo->editar();

		$o_auditoria->set('acao_descricao',"Edição do tipo de usuário: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=usuario_tipo_adm&layout=lista&cmp_pessoa_tipo_id=".$cmp_tipo_id."&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(139);
		$o_usuario_tipo->set('id',$_REQUEST['_id']);

		if($rs = $o_usuario_tipo->selecionar())
		{
			$o_usuario = new Usuario;
			$o_usuario->set('id_usuario_tipo', $_REQUEST['_id']);
			if($res = $o_usuario->selecionar())
			{
				echo $o_ajudante->mensagem(45);
				echo "Lista de Usuário(s) relacionado(s):<br /><br />";
				foreach($res as $l)
				{
					echo "Clique para excluir: <a href=\"javascript:confirma('".$_SERVER['PHP_SELF']."?_id=".$l["id"]."&acao=excluir&acao_adm=usuario_adm','".$l["nome"]."')\">".$l["nome"]."</a><br />";
				}
			}
			else
			{
				$rs = $o_usuario_tipo->excluir();
				$o_auditoria->set('acao_descricao',"Exclusão do tipo de usuário: ".$_REQUEST['_id'].".");
				$o_auditoria->inserir();
				header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=usuario_tipo_adm&msg=8&layout=lista");
			}
		}
	break;

	default:
	break;
}

switch($_REQUEST["layout"])
{
	case 'form': 
		?>
		<form name="formulario" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<strong>Tipo:</strong>
		<input tabindex="1" maxlength="100" name="_nome" type="text" value="<?=$l['nome']?>" size="40">
		<span class="requerido">*</span>
		<?php echo $o_ajudante->ajuda("Inserir nome desejado para o tipo de usuário. Número máximo de caracteres 100.");?>
		<hr>

		<strong>&nbsp;</strong>
		<input name="image" type="image"  onClick="return checa_campos('sistema_usuario_tipo');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">

		<?php
		if($acao != "inserido")
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:document.formulario.reset();"><img  alt="Desfazer" src="../imagens/gc//btn_cancelar.png"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?_id=<?=$l["id"]?>&acao=excluir&acao_adm=usuario_tipo_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>

		<input type="hidden" name="acao_adm" value="usuario_tipo_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="_id" value="<?=$l["id"]?>">
		</form>

		<?php
	break;


	case 'lista':
		$o_usuario_tipo->set('limite',1);
		if($rs = $o_usuario_tipo->selecionar())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>TIPO DE USUÁRIO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>TIPO DE USUÁRIO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$o_usuario_tipo = new Usuario_tipo;
				if($rs = $o_usuario_tipo->selecionar())
				{
					foreach($rs as $l)
					{
						if($zebrado == "zebrado-01"){$zebrado = "zebrado-02";} else {$zebrado = "zebrado-01";}
						echo "<tr class=\"".$zebrado."\">";
						echo "<td>".$l['nome']."</td>";
						echo "<td align=\"center\"><a href='index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
						echo "<td align=\"center\"><a href=javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["nome"]."');><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
						echo "</tr>";
					}
				}
				unset($o_usuario_tipo);
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
		echo "";
	break;
}
unset($o_usuario_tipo);
?>