<?php
$o_projeto = new Projeto;

echo $o_ajudante->sub_menu_gc("NOVO,EDITAR | EXCLUIR","msg=5&acao_adm=projeto_adm&acao=novo&layout=form,acao_adm=projeto_adm&layout=lista&msg=2","Projeto",$acao);
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST["acao"])
{
	case 'novo':
		$o_ajudante->barrado(190);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(190);
		$o_projeto->set('nome',$_REQUEST['_nome']);
		$o_projeto->set('url',$_REQUEST['_url']);
		$o_projeto->set('data',date("Y/m/d H:i:s"));
		$o_projeto->set('estado',$_REQUEST['_estado']);
		$r = $o_projeto->inserir();

		$o_auditoria->set('acao_descricao',"Inserção de novo Projeto: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=projeto_adm&msg=7");
	break;

	case 'editar':
		$acao = "editado";
		$o_ajudante->barrado(188);
		$o_projeto->set('id',$_REQUEST['_id']);
		$rs = $o_projeto->selecionar();
		foreach($rs as $l)
		{}
	break;

	case 'editado':
		$o_ajudante->barrado(188);
		$o_projeto->set('nome',$_REQUEST['_nome']);
		$o_projeto->set('url',$_REQUEST['_url']);
		$o_projeto->set('estado',$_REQUEST['_estado']);
		$o_projeto->set('id',$_REQUEST["_id"]);
		$r = $o_projeto->editar();

		$o_auditoria->set('acao_descricao',"Edição do Projeto: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=projeto_adm&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(189);
		$o_projeto->set('id',$_REQUEST['_id']);
		$rs = $o_projeto->excluir();
		$o_auditoria->set('acao_descricao',"Exclusão da Projeto: ".$_REQUEST['_id'].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=projeto_adm&msg=8");
	break;

	default:
	break;
}

switch($_REQUEST['layout'])
{
	case 'form': 
		?>
		<form name="form_empresa" class="formularios" id="form_empresa" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return CheckRequiredFields();"> 
			<strong>Nome:</strong>
			<input name="_nome" value="<?=$l['nome']?>" tabindex="1" maxlength="150" id="_nome" type="text" size="40">
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Digite a nome do Projeto. Máximo 150 caracteres.");?>
			<hr>

			<strong>Url:</strong>
			<input name="_url" value="<?=$l['url']?>" tabindex="1" maxlength="150" id="_url" type="text" size="40">
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Digite a URL do Projeto. Máximo 150 caracteres.");?>
			<hr>

			<strong>Estado: </strong>
			<input type="radio" value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado"> on-line 
			<input type="radio" value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado"> off-line 
			<span class="requerido">*</span> 
			<?php echo $o_ajudante->ajuda("Selecione se o Projeto estará disponível.");?>
			<hr >

			<strong>&nbsp;</strong>
			<input name="image" type="image"  onClick="return checa_campos('projeto');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png"> 
			<?php
			if($acao == "editado")
			{
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.form_empresa.reset();"><img  alt="Desfazer" src="../imagens/gc/btn_cancelar.png"></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?_id=<?=$l["id"]?>&acao=excluir&acao_adm=projeto_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
				<?php
			}
			?>
			<hr >

			<input type="hidden" name="acao_adm" value="projeto_adm">
			<input type="hidden" name="acao" value="<?=$acao?>">
			<input type="hidden" name="_id" value="<?=$l["id"]?>">
			<input type="hidden" name="msg" value="1">
		</form>
		<?php
	break;

	case 'lista':
		$o_projeto->set('limite',1);
		$o_projeto->set('ordenador',"nome");
		if($rs = $o_projeto->selecionar())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>NOME DO PROJETO</b></th>
						<th><b>URL</b></th>
						<th><b>DATA</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>NOME DO PROJETO</b></th>
						<th><b>URL</b></th>
						<th><b>DATA</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
					<?php
					$o_projeto = new Projeto;
					$o_projeto->set('ordenador',"nome");
					if($rs = $o_projeto->selecionar())
					{
						foreach($rs as $l)
						{
							if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}

							echo "<tr>";
							echo "<td>".$l['nome']."</td>";
							echo "<td><a href=".$l['url']." target=\"_blank\">".$l['url']."</a></td>";
							echo "<td>".$l['data']."</td>";
							echo "<td align=\"center\">".$l['estado']."</td>";
							echo "<td align=\"center\"><a href='index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";

							$o_email = new Email;
							$o_email->set('id_projeto', $l['id']);
							if($res = $o_email->selecionar())
							{
								echo "<td align=\"center\"><img src=\"../imagens/gc/cancel_02.png\" title=\"Projeto não pode ser excluido!\" /></td>";
							}
							else
							{
								echo "<td align=\"center\"><a href=\"javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["nome"]."');\"><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
							}
							unset($o_email);

							echo "</tr>";
						}
					}
					unset($o_projeto);
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
		echo "";
	break;
}
unset($o_projeto);
?>