<?php
//a fazer
$o_quiz = new Quiz;
echo $o_ajudante->sub_menu_gc("NOVO,EDITAR | EXCLUIR","msg=5&acao_adm=quiz_adm&acao=nova&layout=form,acao_adm=quiz_adm&layout=lista&msg=2","QUIZ");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	case 'nova':
	$o_ajudante->barrado(215);
	$acao = "inserido";
	break;


	case 'inserido':
		$o_ajudante->barrado(215);
		if (!$_REQUEST['_id_projeto'])
		{
			alerta("Favor retornar e escolher um projeto.");
		}
		else
		{
			$o_quiz->set('nome',$_REQUEST['_nome']);
			$o_quiz->set('descricao',$_REQUEST['_descricao']);
			$o_quiz->set('id_projeto',$_REQUEST['_id_projeto']);
			$o_quiz->set('data_hora', date("Y-m-d H:i:s"));
			$o_quiz->set('estado',$_REQUEST['_estado']);
			$o_quiz->set('id_album',$_REQUEST['_id_album']);
			$r = $o_quiz->inserir();
			$o_auditoria->set('acao_descricao',"Inserção de nova Quiz: <b>".$_REQUEST['_nome']."</b>.");
			$o_auditoria->inserir();
			header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=quiz_adm&layout=lista&msg=7");
		}
	break;


	case 'editar':
		$o_ajudante->barrado(215);
		$acao = "editado";
		$o_quiz->set('id',$_REQUEST['_id']);
		$rs = $o_quiz->selecionar();
		foreach($rs as $l)
		{}
	break;


	case 'editado':
		$o_ajudante->barrado(215);
		$o_quiz->set('id_projeto',$_REQUEST['_id_projeto']);
		$o_quiz->set('nome',$_REQUEST['_nome']);
		$o_quiz->set('descricao',$_REQUEST['_descricao']);
		$o_quiz->set('estado',$_REQUEST['_estado']);
		$o_quiz->set('id_album',$_REQUEST['_id_album']);
		$o_quiz->set('id',$_REQUEST['_id']);

		if($rs = $o_quiz->editar())
		{
			$o_auditoria->set('acao_descricao',"Edição do Quiz: ".$_REQUEST["_nome"].".");
			$o_auditoria->inserir();
			header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=quiz_adm&layout=lista&id=".$id."&msg=1");
		}
		else
		{
			die('Erro: ao tentar editar o quiz.');
		}
	break;


	case 'excluir':
		$o_ajudante->barrado(215);
		$o_quiz->set('id',$_REQUEST['_id']);
		$rs = $o_quiz->excluir();

		$o_auditoria->set('acao_descricao',"Exclusão do Quiz: ".$_REQUEST['id'].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=quiz_adm&msg=8&layout=lista");
	break;

	default:
	break;
}


switch($_REQUEST['layout'])
{

	case 'form': 
		?>
		<form name="form" id="form" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<strong>Projeto</strong>
		<select name="_id_projeto" id="_id_projeto" size="1">
		<option value="">Selecione um Projeto</option>
		<?php
		$o_projeto = new Projeto;
		$o_projeto->set('ordenador','nome');
		$rs = $o_projeto->selecionar();
		foreach($rs as $linha)
		{ 
		?>
			<option value="<?=$linha["id"]?>" <?php if ($l["id_projeto"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
		<?php
		}
		?>
		</select>
		<?php echo "<a id=\"add\" class=\"ajuda\" href=\"javascript:popup_geral('projeto','novo_projeto');\"><img src=\"../imagens/gc/btn_novo.png\" align=\"absmiddle\" ><span>Clique aqui para adicionar um novo Projeto.</span></a>"; ?>
		
		<?php
		unset($o_projeto);
		echo $o_ajudante->ajuda("Escolha Quiz.");
		?>
		<hr>

		<strong>Quiz</strong>
		<input name="_nome" type="text" value="<?=$l["nome"]?>" size="30" maxlength="100">
		<?php echo $o_ajudante->ajuda("Inserir nome desejado para o Quiz. Ex.: campeonatos, festas, produtos, etc. Máximo 100 caracteres.");?>
		<hr>
		
		<strong>Descrição:</strong>
		<textarea name="_descricao" id="_descricao" onkeyup="if(this.value.length >= 900){this.value = this.value.substring(0, 900)} else {document.getElementById('contador_03').innerHTML = (900 - this.value.length); }" cols="80" rows="3"><?=$l['descricao']?></textarea>
		<br /><strong></strong>Ainda lhe restam <b id="contador_03">900</b> caracteres.
		<hr>

		<strong>Album</strong>
		<select name="_id_album" size="1">
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
		
		<strong>Estado</strong>
		<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado"> on-line 
		<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado"> off-line 
		<?php echo $o_ajudante->ajuda("Escolha se este Quiz aparecerá no site.");?>
		<hr>

		<strong> </strong>
		<input name="image" type="image"  onClick="return checa_campos('quiz_quiz');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao != "inserido")
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.formulario_quiz.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?msg=6&id=<?=$l["id"]?>&acao=excluir&acao_adm=quiz_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>
		<input type="hidden" name="acao_adm" value="quiz_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="_id" value="<?=$l["id"]?>">
		</form>
		<script type="text/javascript">
			tinyMCE.init({
				// General options
				mode : "textareas",
				theme : "advanced",
				plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

				// Theme options
				theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				// Example content CSS (should be your site CSS)
				content_css : "css/content.css",

				// Drop lists for link/image/media/template dialogs
				template_external_list_url : "lists/template_list.js",
				external_link_list_url : "lists/link_list.js",
				external_image_list_url : "lists/image_list.js",
				media_external_list_url : "lists/media_list.js",

				// Style formats
				style_formats : [
					{title : 'Bold text', inline : 'b'},
					{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
					{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
					{title : 'Example 1', inline : 'span', classes : 'example1'},
					{title : 'Example 2', inline : 'span', classes : 'example2'},
					{title : 'Table styles'},
					{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
				],

				// Replace values for the template plugin
				template_replace_values : {
					username : "Some User",
					staffid : "991234"
				}
			});
		</script>
		<!-- /TinyMCE -->
		<?php
	break;

	case 'lista':

		$o_quiz->set('limite',1);
		$o_quiz->set('ordenador',"nome");
		if($rs = $o_quiz->selecionar_projeto_quiz())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>NOME DO QUIZ</b></th>
						<th><b>PROJETO</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>NOME DO QUIZ</b></th>
						<th><b>PROJETO</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$o_quiz = new Quiz;
				$o_quiz->set('ordenador',"nome");
				if($rs = $o_quiz->selecionar_projeto_quiz())
				{
					foreach($rs as $l)
					{
						
						if($l["destaque"] == "s"){$l["destaque"] = "sim";}else{$l["destaque"] = "não";}
						if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}

						echo "<tr>";
						echo "<td>".$l["nome"]."</td>";
						echo "<td>".$l["nome_projeto"]."</td>";
						echo "<td align=\"center\">".$l['estado']."</td>";
						echo "<td align=\"center\"><a href=\"index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."\"><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
						echo "<td align=\"center\"><a href=\"javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["nome"]."');\"><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
						echo "</tr>";
					}
				}
				unset($o_quiz);
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