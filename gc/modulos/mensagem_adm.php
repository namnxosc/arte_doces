<?php
//a fazer
$o_mensagem = new Mensagem;

echo $o_ajudante->sub_menu_gc("NOVA,EDITAR | EXCLUIR","msg=5&acao_adm=mensagem_adm&acao=nova&layout=form,acao_adm=mensagem_adm&layout=lista&msg=2","CONTEUDO MENSAGENS");

echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	
	case 'nova':
		$o_ajudante->barrado(156);
		$acao = "inserido";
	break;

	
	case 'inserido':
		$o_ajudante->barrado(156);
		$o_mensagem->set('nome',trim($_REQUEST['_nome']));
		$o_mensagem->set('corpo',trim($_REQUEST['_corpo']));
		$o_mensagem->set('tipo',$_REQUEST['_tipo']);
		$o_mensagem->inserir();

		$o_auditoria->set('acao_descricao',"Inserção de novo mensagem: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
		
		header("Location: index.php?acao_adm=mensagem_adm&layout=lista&msg=7");
		ob_end_flush();
	
	break;
	

	case 'editar':
		$o_ajudante->barrado(154);
		$acao = "editado";
		
		$o_mensagem->set('id',$_REQUEST['_id']);
		$rs = $o_mensagem->selecionar();
		foreach($rs as $l)
		{
			
		}
	
	break;


	case 'editado':
		$o_ajudante->barrado(154);
		$o_mensagem->set('nome',trim($_REQUEST['_nome']));
		$o_mensagem->set('corpo',trim($_REQUEST['_corpo']));
		$o_mensagem->set('tipo',$_REQUEST['_tipo']);
		$o_mensagem->set('id',$_REQUEST['_id']);

		$o_mensagem->editar();
		
		$o_auditoria->set('acao_descricao',"Edição de mensagem: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
	
		header("Location: index.php?acao_adm=mensagem_adm&layout=lista&msg=1");
		ob_end_flush();
	
	break;
	


	case 'excluir':
		$o_ajudante->barrado(155);
		$o_mensagem->set('id',$_REQUEST['_id']);
		$rs = $o_mensagem->excluir();

		$o_auditoria->set('acao_descricao',"Exclusão do mensagem ".$_REQUEST['_id'].".");
		$o_auditoria->inserir();
			
		header("Location: index.php?acao_adm=mensagem_adm&msg=8&layout=lista");
		ob_end_flush();
	
	break;
	
	default:
	break;
}


switch($_REQUEST['layout'])
{
	case 'form': 
		?>
		<form name="form" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		
		
		<strong>Mensagem</strong>
		<input name="_nome" type="text" value="<?=$l["nome"]?>" size="30" maxlength="100">
		<?php echo $o_ajudante->ajuda("Inserir nome desejado para a mensagem. Máximo 50 caracteres. Atenção, mensagens entre corchetes não devem ser editadas!");?>
		<hr>

		<strong>Corpo</strong>
		<textarea name="_corpo" cols="80" onkeyup="if(this.value.length >= 900){this.value = this.value.substring(0, 900)} else {document.getElementById('contador').innerHTML = (900 - this.value.length); }" rows="20"><?=$l["corpo"]?>
		</textarea>
		<?php echo $o_ajudante->ajuda("Inserir corpo da mensagem. Máximo 900 caracteres.");?>
		<br />Ainda lhe restam <b id="contador">900</b> caracteres.
		<hr>

		<strong>Tipo</strong>
		<select name="_tipo" size="1">
			<option value="">Escolha uma categoria</option>
			<option value="msg_neutra" <?php if ($l['tipo'] == "msg_neutra") echo "selected";?>/>Neutra</option>
			<option value="msg_sucesso" <?php if ($l['tipo'] == "msg_sucesso") echo "selected";?>/>Sucesso</option>
			<option value="msg_aviso" <?php if ($l['tipo'] == "msg_aviso") echo "selected";?>/>Aviso</option>
			<option value="msg_erro" <?php if ($l['tipo'] == "msg_erro") echo "selected";?>/>Erro</option>
			<option value="msg_index" <?php if ($l['tipo'] == "index") echo "selected";?>/>Index</option>
		</select>
		<?php echo $o_ajudante->ajuda("Selecione uma categoria.");?>
		<hr>
		
		<strong> </strong>
		<input name="image" type="image"  onClick="return checa_campos('conteudo_mensagem');" alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png" />
		<?php
		if($acao != "inserido")
		{
		?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.form.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?msg=6&_id=<?=$l["id"]?>&acao=excluir&acao_adm=mensagem_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
		<?php
		}
		?>
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="acao_adm" value="mensagem_adm">
		<input type="hidden" name="_id" value="<?=$l["id"]?>">

		</form>
		<?php
	break;
	
	
	
	case 'lista':
	
	?>
	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
	 
	Buscar no título ou corpo da mensagem
	<input name="txt_nome" value="<?=$_REQUEST['txt_nome']?>" type="text" size="30" />
	<input type="submit" name="buscar" class="botao_input" id="buscar" value="Buscar" />
	<input type="hidden" name="layout" value="lista">
	<input type="hidden" name="acao_adm" value="mensagem_adm">
	<input type="hidden" name="msg" value="4">    
	</form><br /><br />
	
	<?php
	
	if($_REQUEST['buscar'])
	{
		$o_mensagem->set('ordenador',"nome");
		$o_mensagem->set('termo_busca',$_REQUEST['txt_nome']);
	}
	else
	{
		$o_mensagem->set('limite','');
		$o_mensagem->set('ordenador',"nome");
	}
	
	$rs = $o_mensagem->selecionar();

	if($rs)
	{
	
	?>
	
	<table width=100% border="0" cellpadding="6" cellspacing="0">
	<tr class="linhatabela04">
	
	<td><a href="index.php?acao_adm=mensagem_adm&layout=lista&msg=2&ordenador=paginas.titulo">MENSAGEM</a></td>
	<td>TIPO</td>
	<td>EDITAR</td>
	<td>EXCLUIR</td>
	
	</tr>
	<tr>
	
	<td><?php echo $o_ajudante->ajuda("Nome da Mensagem.");?></td>
	<td><?php echo $o_ajudante->ajuda("Tipo da Mensagem.");?></td>
	<td><?php echo $o_ajudante->ajuda("Clique em um dos links para editar.");?></td>
	<td><?php echo $o_ajudante->ajuda("Clique em um dos links para excluir.");?></td>
	</tr>
	
	<?php
	
	foreach($rs as $l)
	{	
		if($l['tipo'] == "msg_neutra"){$l['tipo']= "neutra";}
		if($l['tipo'] == "msg_sucesso"){$l['tipo']= "sucesso";}
		if($l['tipo'] == "msg_aviso"){$l['tipo']= "aviso";}
		if($l['tipo'] == "msg_erro"){$l['tipo']= "erro";}
		if($l['tipo'] == "msg_index"){$l['tipo']= "index";}
		//zebrado
		if($zebrado == "zebrado-01"){$zebrado = "zebrado-02";} else {$zebrado = "zebrado-01";}
		
		echo "<tr class=\"".$zebrado."\">";
		echo "<td><a title=\"editar\" href=\"".$_SERVER['PHP_SELF']."?acao=editar&msg=3&acao_adm=mensagem_adm&_id=".$l["id"]."&layout=form\">".$l["nome"]."</a> [".$l["id"]."]</td>";
		echo "<td>".$l["tipo"]."</td>";
		echo "<td><a href='".$_SERVER['PHP_SELF']."?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=mensagem_adm'>editar</a><br></td>";
		echo "<td><a href=\"javascript:confirma('".$_SERVER['PHP_SELF']."?msg=1&_id=".$l["id"]."&acao=excluir&acao_adm=mensagem_adm','".$l["nome"]."')\">excluir</a></td>";
		echo "</tr>";
	}
	
	?>
	
	</tr>
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
unset($o_mensagem);
?>

