<?php
//a fazer
$o_pergunta = new Pergunta;
echo $o_ajudante->sub_menu_gc("NOVA,EDITAR | EXCLUIR","msg=5&acao_adm=pergunta_adm&acao=nova&layout=form,msg=6&acao_adm=pergunta_adm&layout=lista&msg=2","PERGUNTA");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	case 'nova':
	$o_ajudante->barrado(216);
	$acao = "inserido";
	break;


	case 'inserido':
		$o_ajudante->barrado(216);
		if (!$_REQUEST['_id_quiz'])
		{
			alerta("Favor retornar e escolher um Pergunta.");
		}
		else
		{
			$o_pergunta->set('pergunta',$_REQUEST['_nome']);
			$o_pergunta->set('id_quiz',$_REQUEST['_id_quiz']);
			$o_pergunta->set('estado',$_REQUEST['_estado']);
			if($o_pergunta->inserir())
			{
				if($rs = $o_pergunta->selecionar())
				{
					foreach($rs as $l )
					{
						$id_pergunta = $l['id'];
					}
					if($id_pergunta > 0)
					{
						for($i=0; $i<$_REQUEST['_numero_campos_resposta']; $i++)
						{
							$o_resposta = new Resposta;
							
							$o_resposta->set('resposta',trim($_REQUEST['_resposta_f'][$i])); 
							$o_resposta->set('tipo',trim($_REQUEST['_tipo_f'][$i])); 
							$o_resposta->set('id_pergunta',$id_pergunta);
							$o_resposta->set('estado', 'a');
							$o_resposta->inserir();

							$o_auditoria->set('acao_descricao',"Inserção da Resposta ".$_REQUEST["_tipo"]." para produto: ".$_REQUEST["_resposta_f"][$i]." .");
							$o_auditoria->inserir();
							
							unset($o_produto_complemento);
						}
					}
				}
			}
			$o_auditoria->set('acao_descricao',"Inserção de nova Pergunta: <b>".$_REQUEST['_nome']."</b>.");
			$o_auditoria->inserir();
			header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=pergunta_adm&layout=lista&msg=7");
		}
	break;


	case 'editar':
		$o_ajudante->barrado(216);
		$acao = "editado";
		$o_pergunta->set('id',$_REQUEST['_id']);
		if($rs = $o_pergunta->selecionar())
		{
			foreach($rs as $l)
			{}
		}
		else
		{
			die("Erro: ao tentar editar um item");
		}
	break;


	case 'editado':
		$o_ajudante->barrado(216);
		$o_pergunta->set('id_quiz',$_REQUEST['_id_quiz']);
		$o_pergunta->set('pergunta',$_REQUEST['_nome']);
		$o_pergunta->set('estado',$_REQUEST['_estado']);
		$o_pergunta->set('id',$_REQUEST['_id']);

		$rs = $o_pergunta->editar();
		
		if($_REQUEST['_id'] > 0)
		{
			for($i=0; $i<$_REQUEST['_numero_campos_resposta']; $i++)
			{
				$o_resposta = new Resposta;
				
				$o_resposta->set('resposta',trim($_REQUEST['_resposta_f'][$i])); 
				$o_resposta->set('tipo',trim($_REQUEST['_tipo_f'][$i])); 
				$o_resposta->set('id_pergunta',$_REQUEST['_id']);
				$o_resposta->set('estado', 'a');
				$o_resposta->inserir();

				$o_auditoria->set('acao_descricao',"Inserção da Resposta ".$_REQUEST["_tipo"]." para produto: ".$_REQUEST["_resposta_f"][$i]." .");
				$o_auditoria->inserir();
				
				unset($o_produto_complemento);
			}
		}
		$o_auditoria->set('acao_descricao',"Edição do Pergunta: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=pergunta_adm&layout=lista&id=".$id."&msg=1");
	break;


	case 'excluir':
		$o_ajudante->barrado(216);
		$o_pergunta->set('id',$_REQUEST['_id']);
		$rs = $o_pergunta->excluir();

		$o_auditoria->set('acao_descricao',"Exclusão do Pergunta: ".$_REQUEST['id'].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=pergunta_adm&msg=8&layout=lista");
	break;

	default:
	break;
}


switch($_REQUEST['layout'])
{

	case 'form': 
		?>
		<form name="form" id="form" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<strong>Quiz</strong>
		<select name="_id_quiz" id="_id_quiz" size="1">
		<option value="">Selecione um Quiz</option>
		<?php
		$o_quiz = new Quiz;
		$o_quiz->set('ordenador','nome');
		$rs = $o_quiz->selecionar();
		foreach($rs as $linha)
		{ 
		?>
			<option value="<?=$linha["id"]?>" <?php if ($l["id_quiz"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
		<?php
		}
		?>
		</select>
		<?php
		unset($o_quiz);
		echo $o_ajudante->ajuda("Escolha o Quiz.");
		?>
		<hr>

		<strong>Pergunta</strong>
		<textarea name="_nome" id="_nome" cols="55"  rows="4" tabindex="2" onkeyup="if(this.value.length >= 250){this.value = this.value.substring(0, 250)} else {document.getElementById('contador').innerHTML = (250 - this.value.length); }"><?=$l["pergunta"]?></textarea>
		<span class="requerido">*</span>
		<?php echo $o_ajudante->ajuda("Digite a Pergunta desejada para o Quiz. Máximo 250 caracteres.");?>
		<br /><strong> </strong>Ainda lhe restam <b id="contador">250</b> caracteres.
		<hr>
		
		<strong>Resposta</strong>
		<input name="_resposta" id="_resposta" type="text" maxlength="150" value="<?=$l['resposta']?>" size="60" />
		<input name="imp_resposta" id="imp_resposta" type="button" value=" Add " onclick="javascript:adicionaCampo_Resposta();" alt="Salvar altera&ccedil;&otilde;es" src="../imagens/site/btn_cadastrar.png" id="_enviar_form_pergunta" />  
		<hr>
		<input type="hidden" name="_numero_campos_resposta" id="_numero_campos_resposta" value="0" />

		<strong>Tipo Resposta</strong>
		<input type="radio"  value="1" checked <?php if ($l["tipo"] == "1") echo "checked";?> name="_tipo"> Seleção
		<input type="radio"  value="2" <?php if ($l["tipo"] == "2") echo "checked";?> name="_tipo"> Descrição
		<?php echo $o_ajudante->ajuda("Escolha o tipo de resposta.");?>
		<hr>
		
		<?php
		if($acao == "editado")
		{
			$o_monta_site = new Monta_site;
			$o_monta_site->set('id_pergunta', $l['id']);
			$resposta_lista = $o_monta_site->monta_resposta_lista();
			unset($o_monta_site);
		}
		else
		{
			$resposta_lista = "";
		}		
		?>
		
		<strong></strong>
		<div id="div_block_respostas">
			<div id="div_respostas_ajax"><?=$resposta_lista?></div>
			<div id="div_respostas"></div>
		</div>
		<hr>
		

		<strong>Estado</strong>
		<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado"> on-line 
		<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado"> off-line 
		<?php echo $o_ajudante->ajuda("Escolha se esta Resposta aparecerá no site.");?>
		<hr>

		<strong> </strong>
		<input name="image" type="image"  onClick="return checa_campos('quiz_pergunta');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao != "inserido")
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.formulario_pergunta.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?msg=6&id=<?=$l["id"]?>&acao=excluir&acao_adm=pergunta_adm','<?=$l["pergunta"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>
		<input type="hidden" name="acao_adm" value="pergunta_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="_id" value="<?=$l["id"]?>">
		</form>
		<?php
	break;

	case 'lista':

		$o_pergunta->set('limite',1);
		$o_pergunta->set('ordenador',"pergunta");
		if($rs = $o_pergunta->selecionar_quiz_pergunta())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>PERGUNTA</b></th>
						<th><b>QUIZ</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>PERGUNTA</b></th>
						<th><b>QUIZ</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$o_pergunta = new Pergunta;
				$o_pergunta->set('ordenador',"pergunta");
				if($rs = $o_pergunta->selecionar_quiz_pergunta())
				{
					foreach($rs as $l)
					{
						if($l["destaque"] == "s"){$l["destaque"] = "sim";}else{$l["destaque"] = "não";}
						if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}

						echo "<tr>";
						echo "<td>".$l["pergunta"]."</td>";
						echo "<td>".$l["nome_quiz"]."</td>";
						echo "<td align=\"center\">".$l['estado']."</td>";
						echo "<td align=\"center\"><a href=\"index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."\"><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
						echo "<td align=\"center\"><a href=\"javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["pergunta"]."');\"><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
						echo "</tr>";
					}
				}
				unset($o_pergunta);
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