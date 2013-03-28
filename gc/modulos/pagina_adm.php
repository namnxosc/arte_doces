<?php
$o_pagina = new Pagina;
$o_menu_site = new Menu_site;

echo $o_ajudante->sub_menu_gc("NOVA","msg=5&acao_adm=pagina_adm&acao=nova&layout=form","CONTEUDO PÁGINAS");

echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	case 'nova':
		$o_ajudante->barrado(224);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(224);

		$o_pagina->set('nome',$_REQUEST['_nome']);
		$o_pagina->set('corpo',$_REQUEST['_corpo']);
		$o_pagina->set('data',date("Y-m-d"));
		$o_pagina->set('formatacao',$_REQUEST['formatacao']);
		$o_pagina->set('ordem',$_REQUEST['ordem']);
		$o_pagina->set('destaque',$_REQUEST['destaque']);
		$o_pagina->set('olho',$_REQUEST['olho']);
		$o_pagina->set('estado',$_REQUEST['estado']);
		$o_pagina->set('idioma',$_REQUEST['_idioma']);
		$o_pagina->set('id_album',$_REQUEST['_id_album']);
		$o_pagina->set('curtir_face',$_REQUEST['_curtir_face']);
		$o_pagina->set('curtir_pinit',$_REQUEST['_curtir_pinit']);
		$o_pagina->set('google_maps',$_REQUEST['_google_maps']);
		
		$r = $o_pagina->inserir();

		//recupera o ultimo id inserido
		$r_u = $o_pagina->ultimo_id();
		foreach($r_u as $l)
		{}

		//insere vínculo
		$o_pagina = new Pagina;
		$chamada_nome = $o_ajudante->trata_texto_01_url_amigavel($_REQUEST['_nome']);
		$chamada_nome = strtolower($chamada_nome);
		$o_pagina->set('chamado', str_replace(" ", "_", $chamada_nome));
		$o_pagina->set('id',$l['id']);
		$r = $o_pagina->editar_chamado();

		$o_auditoria->set('acao_descricao',"Inserção de nova página: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?id=".$_SESSION['campo_pagina_id']."&acao_adm=pagina_adm&layout=lista&msg=7");

	break;

	case 'editar':
		$o_ajudante->barrado(224);
		$acao = "editado";

		$o_pagina->set('id',$_REQUEST['id']);
		if($rs = $o_pagina->selecionar())
		{
		foreach($rs as $l)
		{}
		}
	break;

	case 'editado':
		$o_ajudante->barrado(224);
		$o_pagina->set('nome',$_REQUEST['_nome']);
		$o_pagina->set('corpo',$_REQUEST['_corpo']);
		$o_pagina->set('data',date("Y-m-d"));
		$o_pagina->set('formatacao',$_REQUEST['formatacao']);
		$o_pagina->set('ordem',$_REQUEST['ordem']);
		$o_pagina->set('destaque',$_REQUEST['destaque']);
		$o_pagina->set('olho',$_REQUEST['olho']);
		$o_pagina->set('estado',$_REQUEST['estado']);
		$o_pagina->set('idioma',$_REQUEST['_idioma']);
		$o_pagina->set('id_album',$_REQUEST['_id_album']);
		$o_pagina->set('curtir_face',$_REQUEST['_curtir_face']);
		$o_pagina->set('curtir_pinit',$_REQUEST['_curtir_pinit']);
		$o_pagina->set('google_maps',$_REQUEST['_google_maps']);
		$o_pagina->set('id',$_REQUEST['id']);
		$rs = $o_pagina->editar();

		//edita vínculo
		$o_pagina = new Pagina;
		$chamada_nome = $o_ajudante->trata_texto_01_url_amigavel($_REQUEST['_nome']);
		$chamada_nome = strtolower($chamada_nome);
		$o_pagina->set('chamado', str_replace(" ", "_", $chamada_nome));
		$o_pagina->set('id',$_REQUEST['id']);
		$r = $o_pagina->editar_chamado();

		$o_auditoria->set('acao_descricao',"Edição da página: ".$_REQUEST['_nome'].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=pagina_adm&layout=lista&cmp_pagina_id=".$cmp_pagina_id."&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(224);
		
		$o_pagina->set('id',$_REQUEST['id']);		
		if($res = $o_pagina->selecionar())
		{
			$o_menu_site->set('id_pagina',$_REQUEST['id']);
			if($rs_menu = $o_menu_site->selecionar())
			{
				echo $o_ajudante->mensagem(45);
				echo "Lista de menu(s) relacionado(s):<br /><br />";
				foreach($rs_menu as $l)
				{
					echo "Clique para excluir o link: <a href=\"javascript:confirma('".$_SERVER['PHP_SELF']."?_id=".$l["id"]."&acao=excluir&acao_adm=menu_site_adm','".$l["nome"]."')\">".$l["nome"]."</a><br />";		
				}
			}
			else
			{
				$o_pagina->excluir();
				header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=pagina_adm&msg=8");
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
		<strong>Nome</strong>
		<input name="_nome" maxlength="150" type="text" id="_nome" value="<?=$l["nome"]?>" size="30">
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<hr>

		<strong>Texto</strong>
		<textarea rows="20" name="_corpo" cols="80" id="_corpo"><?=$l["corpo"]?></textarea>
		<?php echo $o_ajudante->ajuda("Digite seu texto diretamente no campo ou copie e cole de qualquer outro formato de texto previamente criado. Para criar um link dentro de seu texto basta digitar o caminho completo. Ex.: http://www.seulink.com.br.");?><hr>

		<strong>Plugin do Facebook</strong>
		<input type="radio"  value="s" <?php if ($l["curtir_face"] == "s") echo "checked";?> name="_curtir_face"> sim
		<input type="radio"  value="n" <?php if ($l["curtir_face"] == "n") echo "checked";?> name="_curtir_face"> não
		<?php echo $o_ajudante->ajuda("Escolha se esta Página terá o curtir e os comentarios do facebook.");?><hr>
		
		<strong>Google Maps</strong>
		<input type="radio"  value="s" <?php if ($l["google_maps"] == "s") echo "checked";?> name="_google_maps"> sim 
		<input type="radio"  value="n" <?php if ($l["google_maps"] == "n") echo "checked";?> name="_google_maps"> não
		<?php echo $o_ajudante->ajuda("Escolha se esta Página terá o mini mapa do Google.");?><hr>
		
		<strong>Estado</strong>
		<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="estado"> on-line 
		<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="estado"> off-line
		<?php echo $o_ajudante->ajuda("Escolha se esta Página aparecerá no site.");?><hr>

		<strong>&nbsp;</strong>
		<input name="image" type="image"  onClick="return checa_campos('conteudo_pagina');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao == "inserido")
		{
			echo "";
		}
		else
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.form.reset();"><img alt="Desfazer" src="../imagens/gc/btn_cancelar.png"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?id=<?=$l["id"]?>&acao=excluir&acao_adm=pagina_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>
		<input type="hidden" name="acao_adm" value="pagina_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="id" value="<?=$l["id"]?>">
		</form>
		<?php
	break;

	case 'lista':
	
		if($_REQUEST['buscar'])
		{
			$o_pagina->set('termo_busca',$_REQUEST['txt_nome']);
		}
		else
		{
			$o_pagina->set('limite',40);
			$o_pagina->set('ordenador',"nome");
		}
		if($rs = $o_pagina->selecionar())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>NOME DA PÁGINA</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>NOME DA PÁGINA</b></th>
						<th><b>ESTADO</b></th>
						<th><b>EDITAR</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>

			<?php
			foreach($rs as $l)
			{
				if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}
				if($l["nome"] == NULL){$l["nome"] = "vazio";}

				//zebrado
				if($zebrado == "zebrado-01"){$zebrado = "zebrado-02";} else {$zebrado = "zebrado-01";}
				echo "<tr class=\"".$zebrado."\">";

				echo "<td>".$l["nome"]." [".$l["id"]."]</td>";
				echo "<td>".$l["estado"]."</td>";				
				echo "<td align=\"center\"><a href='index.php?msg=3&id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
				echo "<td align=\"center\"><a href=javascript:confirma('index.php?id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".str_replace(' ', '_', $l["nome"])."');><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
				echo "</tr>";
			}
			?>
			</tr>
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