<?php
$o_ambiente= new Ambiente;
$id = $_REQUEST['id'];

if($_REQUEST['_pai_id'] == '')
{
	$pai_id = 0;
}
else
{
	$pai_id = $_REQUEST['_pai_id'];
}

echo $o_ajudante->sub_menu_gc("NOVO,EDITAR | EXCLUIR","msg=5&acao_adm=ambiente_adm&acao=nova&layout=form,acao_adm=ambiente_adm&layout=lista&msg=2","SISTEMA AMBIENTES");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST["acao"])
{
	case 'nova':
		$o_ajudante->barrado(11);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(11);
		$o_ambiente->set('nome', $_REQUEST['_nome']);
		$o_ambiente->set('url', $_REQUEST['_url']);
		$o_ambiente->set('tipo_menu', $_REQUEST['_tipo_menu']);
		$o_ambiente->set('botao', $_REQUEST['_botao']);
		$o_ambiente->set('pai_id', $_REQUEST['_pai_id']);
		$o_ambiente->set('ver', $_REQUEST['_ver']);
		$o_ambiente->set('ordem', $_REQUEST['_ordem']);
		$r = $o_ambiente->inserir();

		$o_auditoria->set('acao_descricao', "Inserção de novo ambiente: ".$_REQUEST['_nome'].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=ambiente_adm&acao=&layout=lista&msg=7");
	break;

	case 'editar':
		$o_ajudante->barrado(12);

		$acao = "editado";
		$o_ambiente->set('id', $_REQUEST['id']);
		$rs = $o_ambiente->selecionar();
		foreach($rs as $l)
		{
			?>
			<script language="javascript">
				window.onload = function()
				{
					ajaxHTML('div_sistema_ambiente','../inc/busca_ajax.php?quero=<?=$l["pai_id"]?>&id=<?=$l["id"]?>&parametro=<?=$l["tipo_menu"]?>&tipo=sistema_ambiente');
				}
			</script>
			<?php
		}
	break;

	case 'editado':
		$o_ajudante->barrado(12);
		$o_ambiente->set('nome',$_REQUEST['_nome']);
		$o_ambiente->set('url',$_REQUEST['_url']);
		$o_ambiente->set('tipo_menu',$_REQUEST['_tipo_menu']);
		$o_ambiente->set('botao',$_REQUEST['_botao']);
		$o_ambiente->set('pai_id',$_REQUEST['_pai_id']);
		$o_ambiente->set('ver',$_REQUEST['_ver']);
		$o_ambiente->set('ordem',$_REQUEST['_ordem']);
		$o_ambiente->set('id', $_REQUEST['id']);
		$rs = $o_ambiente->editar();

		$o_auditoria->set('acao_descricao',"Edição do ambiente: ".$_REQUEST['_nome'].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=ambiente_adm&layout=lista&id=".$_REQUEST['id']."&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(123);
		$o_ambiente->set('id',$_REQUEST['id']);
		if($res = $o_ambiente->selecionar())
		{
			foreach($res as $l)
			{
				switch($l['tipo_menu'])
				{
					case 'n':
						$res = $o_ambiente->excluir();
						$o_auditoria->set('acao_descricao',"Exclusão do ambiente: ".$_REQUEST['id'].".");
						$o_auditoria->inserir();
						header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=ambiente_adm&msg=8&layout=lista");
					break;

					case 'f':
						if($res_neto = $o_ambiente->selecionar_parente())
						{
							echo $o_ajudante->mensagem(45);
							echo "Ambiente(s) Neto(s) relacionado(s):<br /><br />";
							foreach($res_neto as $linha)
							{
								echo "Clique para excluir: <a href=\"javascript:confirma('".$_SERVER['PHP_SELF']."?id=".$linha["id_parente"]."&acao=excluir&acao_adm=ambiente_adm','".$linha["nome"]."')\"> [".$linha['id_parente']."] ".$linha["nome"]."</a><br />";
							}
						}
						else
						{
							$res = $o_ambiente->excluir();
							$o_auditoria->set('acao_descricao',"Exclusão do ambiente: ".$_REQUEST['id'].".");
							$o_auditoria->inserir();
							header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=ambiente_adm&msg=8&layout=lista");
						}
					break;

					case 'p':
						if($res_filho = $o_ambiente->selecionar_parente())
						{
							echo $o_ajudante->mensagem(45);
							echo "Ambiente(s) Filho(s) relacionado(s):<br /><br />";
							foreach($res_filho as $linha)
							{
								echo "Clique para excluir: <a href=\"javascript:confirma('".$_SERVER['PHP_SELF']."?id=".$linha["id_parente"]."&acao=excluir&acao_adm=ambiente_adm','".$linha["nome"]."')\"> [".$linha['id_parente']."] ".$linha["nome"]."</a><br />";
							}
						}
						else
						{
							$res = $o_ambiente->excluir();
							$o_auditoria->set('acao_descricao',"Exclusão do ambiente: ".$_REQUEST['id'].".");
							$o_auditoria->inserir();
							header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=ambiente_adm&msg=8&layout=lista");
						}
					break;
				}//fim do switch tipo_menu
			}
		}
	break;

	default:
		echo "";
	break;
}

switch($_REQUEST['layout'])
{
	case 'form': 
		?>
		<form name="formularios" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<strong>Ambiente: </strong>
		<input tabindex="1" maxlength="50" name="_nome" type="text" value="<?=$l['nome']?>" size="40"><?php echo $o_ajudante->ajuda("Digite nome completo do ambiente. Número máximo de caracteres 50. Não usar acentos, espaços nem ç.");?>
		<hr class="linha-cinza">

		<strong>Botão:</strong>
		<input tabindex="2" maxlength="50" id="_botao" name="_botao" type="text" value="<?=$l['botao']?>" size="40"><?php echo $o_ajudante->ajuda("Digite nome do ambiente. Número máximo de caracteres 50.");?>
		<hr>

		<strong>Endereço:</strong>
		<input tabindex="3" maxlength="150" name="_url" type="text" value="<?=$l['url']?>" size="40"><?php echo $o_ajudante->ajuda("Digite o endereço do ambiente. Número máximo de caracteres 150.");?>
		<hr class="linha-cinza">

		<strong>Ver:</strong>
		<input type="radio" value="s" <?php if ($l['ver'] == "s") echo "checked";?> name="_ver" /> sim
		<input type="radio" value="n" <?php if ($l['ver'] == "n") echo "checked";?> name="_ver" /> não
		<?php echo $o_ajudante->ajuda("Selecione se o menu estará disponível ou não.");?>
		<hr>

		<strong>Ordem:</strong>
		<?php 
		$array = array ("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",);
		echo $o_ajudante->drop_varios($array, "_ordem", $l['ordem'], "", "", "");
		?>
		<hr class="linha-cinza">

		<strong>Tipo de menu:</strong>
		<input type="radio" onclick="javascript:ajaxHTML(document.getElementById('div_sistema_ambiente').id,'../inc/busca_ajax.php?tipo=sistema_ambiente&parametro='+this.value);" value="p" <?php if ($l['tipo_menu'] == "p") echo "checked";?> name="_tipo_menu" id="_tipo_menu" /> Pai
		<input type="radio" onclick="javascript:ajaxHTML(document.getElementById('div_sistema_ambiente').id,'../inc/busca_ajax.php?tipo=sistema_ambiente&parametro='+this.value);" value="f" <?php if ($l['tipo_menu'] == "f") echo "checked";?> name="_tipo_menu" id="_tipo_menu" /> Filho
		<input type="radio" onclick="javascript:ajaxHTML(document.getElementById('div_sistema_ambiente').id,'../inc/busca_ajax.php?tipo=sistema_ambiente&parametro='+this.value);" value="n" <?php if ($l['tipo_menu'] == "n") echo "checked";?> name="_tipo_menu" id="_tipo_menu" /> Neto
		<?php echo $o_ajudante->ajuda("Selecione se será um menu Pai, Filho ou Neto.");?>
		<hr>

		<div id="div_sistema_ambiente"></div>

		<strong>&nbsp;</strong>
		<input name="image" type="image"  onClick="return checa_campos('sistema_ambiente');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao == "editado")
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.formularios.reset();"><img  alt="Desfazer" src="../imagens/gc/btn_cancelar.png"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?msg=3&id=<?=$l["id"]?>&acao=excluir&acao_adm=ambiente_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>

		<input type="hidden" name="acao_adm" value="ambiente_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="id" value="<?=$l["id"]?>">

		</form>
		<?php
	break;

	case 'lista':
		if($rs = $o_ambiente->selecionar())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>AMBIENTE</b></th>
						<th><b>NOME DO BOTÃO</b></th>
						<th><b>ENDEREÇO</b></th>
						<th><b>VER</b></th>
						<th><b>ORDEM</b></th>
						<th><b>TIPO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>AMBIENTE</b></th>
						<th><b>NOME DO BOTÃO</b></th>
						<th><b>ENDEREÇO</b></th>
						<th><b>VER</b></th>
						<th><b>ORDEM</b></th>
						<th><b>TIPO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$o_ambiente = new Ambiente;
				if($rs = $o_ambiente->selecionar())
				{
					foreach($rs as $l)
					{
						if($l["tipo_menu"] == "p"){$l["tipo_menu"] = "pai";}
						if($l["tipo_menu"] == "f"){$l["tipo_menu"] = "filho";}
						if($l["tipo_menu"] == "n"){$l["tipo_menu"] = "neto";}

						if($l["ver"] == "s"){$l["ver"] = "sim";}
						if($l["ver"] == "n"){$l["ver"] = "não";}

						if($zebrado == "zebrado-01"){$zebrado = "zebrado-02";} else {$zebrado = "zebrado-01";}
						echo "<tr class=\"".$zebrado."\">";

						echo "<td>".$l["nome"]." [".$l['id']."]</td>";
						echo "<td>".$l['botao']."</td>";
						echo "<td>".$l['url']."</td>";
						echo "<td align=\"center\">".$l['ver']."</td>";
						echo "<td align=\"center\">".$l['ordem']."</td>";
						echo "<td align=\"center\">".$l['tipo_menu']."</td>";
						echo "<td align=\"center\"><a href='index.php?msg=3&id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
						echo "<td align=\"center\"><a href=javascript:confirma('index.php?id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["nome"]."');><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
						echo "</tr>";
					}
				}
				unset($o_ambiente);
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
unset($o_ambiente);
?>