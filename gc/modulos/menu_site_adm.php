<?php
//a fazer
$o_menu_site = new Menu_site;
echo $o_ajudante->sub_menu_gc("NOVA,EDITAR | EXCLUIR","msg=5&acao_adm=menu_site_adm&acao=nova&layout=form,msg=6&acao_adm=menu_site_adm&layout=lista&msg=2","MENU SITE");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	case 'nova':
		$o_ajudante->barrado(220);
		$acao = "inserido";
	break;


	case 'inserido':
		$o_ajudante->barrado(220);
		$o_menu_site->set('nome',$_REQUEST['_nome']);
		$o_menu_site->set('ordem',$_REQUEST['_ordem']);
		$o_menu_site->set('pagina_interna',$_REQUEST['_pagina_interna']);
		$o_menu_site->set('id_pagina',$_REQUEST['_id_pagina']);
		$o_menu_site->set('tipo_link',$_REQUEST['_tipo_link']);
		$o_menu_site->set('url',$_REQUEST['_url']);
		$o_menu_site->set('funcao_popup',$_REQUEST['_funcao_popup']);
		$o_menu_site->set('estado',$_REQUEST['_estado']);
		$o_menu_site->set('id_menu_ambiente',$_REQUEST['_id_menu_ambiente']);
		$o_menu_site->set('id_album',$_REQUEST['_id_album']);
		$o_menu_site->set('tipo',$_REQUEST['_tipo']);
		if($o_menu_site->inserir())
		{
			$o_auditoria->set('acao_descricao',"Inserção de novo Menu: <b>".$_REQUEST['_nome']."</b>.");
			$o_auditoria->inserir();
			header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=menu_site_adm&layout=lista&msg=7");
		}
		die('Não foi possivel registrar o menu, contate com o administrador do sistema "menu_site->inserir()" ');
		
	
	break;


	case 'editar':
		$o_ajudante->barrado(220);
		$acao = "editado";
		$o_menu_site->set('id',$_REQUEST['_id']);
		if($rs = $o_menu_site->selecionar())
		{
			foreach($rs as $l)
			{
				?>
				<script language="javascript">
					$(document).ready(function (){
						var tipo_menu = "<?=$l['pagina_interna']?>";
						if(tipo_menu == "p")
						{
							$("#link_pagina").show();
							$("#link_url").hide();
							$("#link_funcao").hide();
						}
						else if(tipo_menu == "l")
						{
							$("#link_pagina").hide();
							$("#link_url").show();
							$("#link_funcao").hide();
						}
						else
						{
							$("#link_pagina").hide();
							$("#link_url").hide();
							$("#link_funcao").show();
						}
						
						
						var tipo_botao = "<?=$l['tipo']?>";
						if(tipo_botao == "i")
						{
							$("#tipo_botao").show();
						}
						else if(tipo_botao == "t")
						{
							$("#tipo_botao").hide();
						}
					
					});					
				</script>
				<?php				
			}
		}
		else
		{
			die("Erro: ao tentar editar um item");
		}
	break;


	case 'editado':
		$o_ajudante->barrado(220);
		$o_menu_site->set('nome',$_REQUEST['_nome']);
		$o_menu_site->set('ordem',$_REQUEST['_ordem']);
		$o_menu_site->set('pagina_interna',$_REQUEST['_pagina_interna']);
		$o_menu_site->set('id_pagina',$_REQUEST['_id_pagina']);
		$o_menu_site->set('tipo_link',$_REQUEST['_tipo_link']);
		$o_menu_site->set('url',$_REQUEST['_url']);
		$o_menu_site->set('funcao_popup',$_REQUEST['_funcao_popup']);
		$o_menu_site->set('estado',$_REQUEST['_estado']);
		$o_menu_site->set('id_menu_ambiente',$_REQUEST['_id_menu_ambiente']);
		$o_menu_site->set('id_album',$_REQUEST['_id_album']);
		$o_menu_site->set('tipo',$_REQUEST['_tipo']);
		$o_menu_site->set('id',$_REQUEST['_id']);

		$rs = $o_menu_site->editar();

		$o_auditoria->set('acao_descricao',"Edição do Menu: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=menu_site_adm&layout=lista&id=".$id."&msg=1");
	break;


	case 'excluir':
		$o_ajudante->barrado(220);
		$o_menu_site->set('id',$_REQUEST['_id']);
		$rs = $o_menu_site->excluir();

		$o_auditoria->set('acao_descricao',"Exclusão do Menu: ".$_REQUEST['id'].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=menu_site_adm&msg=8&layout=lista");
	break;

	default:
	break;
}


switch($_REQUEST['layout'])
{

	case 'form': 
		?>
		<form name="form" id="form" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">

		<strong>Menu Ambiente</strong>
		<select name="_id_menu_ambiente" id="_id_menu_ambiente" size="1">
		<option value="">Selecione um Ambiente</option>
		<?php
		$o_menu_ambiente = new Menu_ambiente;
		$o_menu_ambiente->set('ordenador','nome');
		$rs = $o_menu_ambiente->selecionar();
		foreach($rs as $linha)
		{ 
		?>
			<option value="<?=$linha["id"]?>" <?php if ($l["id_menu_ambiente"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
		<?php
		}
		?>
		</select>
		<?php
		unset($o_menu_ambiente);
		echo $o_ajudante->ajuda("Escolha o ambiente do Menu.");
		?>
		<hr>
		
		<strong>Nome</strong>
		<input name="_nome" id="_nome" type="text" maxlength="150" value="<?=$l['nome']?>" size="60" />
		<span class="requerido">*</span>
		<?php echo $o_ajudante->ajuda("Digite a Pergunta desejada para o Menu. Máximo 50 caracteres.");?>
		<hr>
		
		<strong>Tipo</strong>
		<input type="radio" value="t" <?php if ($l["tipo"] == "t") echo "checked";?> name="_tipo" class="_tipo"> texto 
		<input type="radio" value="i" <?php if ($l["tipo"] == "i") echo "checked";?> name="_tipo" class="_tipo"> imagem 
		<?php echo $o_ajudante->ajuda("Escolha o tipo de botão.");?>
		<hr>
		
		<div id="tipo_botao" style="display:none;">
			<strong>Album</strong>
			<select name="_id_album" size="1">
			<option value="">Selecione um Álbum</option>
			<?php
			$o_album = new Album;
			$o_album->set('ordenador','nome');
			$o_album->set('id_album_tipo','2');
			$rs = $o_album->selecionar();
			foreach($rs as $linha)
			{ 
			?>
				<option value="<?=$linha["id"]?>" <?php if ($l["id_album"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
			<?php
			}
			?>
			</select>
			<?php
			unset($o_album);
			echo $o_ajudante->ajuda("Escolha um &Aacute;lbum.");
			?>
			<hr>
		</div>
		
		<script>
			$("._tipo").click(function() {
				var tipo_botao = $(this).val();
				if(tipo_botao == "i")
				{
					$("#tipo_botao").show();
				}
				else if(tipo_botao == "t")
				{
					$("#tipo_botao").hide();
				}
			});
		</script>
		
		<strong>Tipo de Menu</strong>
		<input type="radio"  value="p" <?php if ($l["pagina_interna"] == "p") echo "checked";?> name="_pagina_interna" class="_pagina_interna"> Página
		<input type="radio"  value="l" <?php if ($l["pagina_interna"] == "l") echo "checked";?> name="_pagina_interna" class="_pagina_interna"> Link
		<input type="radio"  value="f" <?php if ($l["pagina_interna"] == "f") echo "checked";?> name="_pagina_interna" class="_pagina_interna"> Função Popup
		<?php echo $o_ajudante->ajuda("Escolha o tipo de link pra o Menu.");?>
		<hr>

		<div id="link_pagina" style="display:none;">
			<strong>Página</strong>
			<select name="_id_pagina" id="_id_pagina" size="1">
			<option value="">Selecione uma Página</option>
			<?php
			$o_pagina = new Pagina;
			$o_pagina->set('ordenador','nome');
			$rs = $o_pagina->selecionar();
			foreach($rs as $linha)
			{ 
			?>
				<option value="<?=$linha["id"]?>" <?php if ($l["id_pagina"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
			<?php
			}
			?>
			</select>
			<?php
			unset($o_pagina);
			echo $o_ajudante->ajuda("Escolha o Quiz.");
			?>
			<hr>
		</div>
		
		<div id="link_url" style="display:none;">
			<strong>Url</strong>
			<input name="_url" id="_url" type="text" maxlength="150" value="<?=$l['url']?>" size="60" />
			<?php echo $o_ajudante->ajuda("Digite a Url desejada para o Menu. Máximo 250 caracteres.");?>
			<hr>	
		</div>
		
		<div id="link_funcao" style="display:none;">
			<strong>Popup</strong>
			<input name="_funcao_popup" id="_funcao_popup" readonly type="text" maxlength="150" value="<?=$l['funcao_popup']?>" size="60" />
			<?php echo $o_ajudante->ajuda("Digite a Funcao Popup desejada para o Menu. Máximo 250 caracteres.");?>
			<hr>
		</div>
	
		<script>
			$("._pagina_interna").click(function() {
				var tipo_menu = $(this).val();
				if(tipo_menu == "p")
				{
					$("#link_pagina").show();
					$("#link_url").hide();
					$("#link_funcao").hide();
				}
				else if(tipo_menu == "l")
				{
					$("#link_pagina").hide();
					$("#link_url").show();
					$("#link_funcao").hide();
				}
				else
				{
					$("#link_pagina").hide();
					$("#link_url").hide();
					$("#link_funcao").show();
				}
			});
		</script>
		
		<strong>Ordem:</strong>
		<?php 
		$array = array ("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l",);
		echo $o_ajudante->drop_varios($array, "_ordem", $l['ordem'], "", "", "");
		echo $o_ajudante->ajuda("Selecione a ordem do menu.");
		?>
		<hr>
		
		<strong>Abrir em:</strong>
		<select name="_tipo_link" id="_tipo_link">
			<option value="_self" <?if($l['tipo_link'] == "_self") echo"selected";?>>Mesma janela</option>
			<option value="_blank" <?if($l['tipo_link'] == "_blank") echo"selected";?>>Nova janela</option>			
		</select>
		<hr>		
	

		<strong>Estado</strong>
		<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado"> on-line 
		<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado"> off-line 
		<?php echo $o_ajudante->ajuda("Escolha se esta Resposta aparecerá no site.");?>
		<hr>

		<strong> </strong>
		<input name="image" type="image"  onClick="return checa_campos('menu_site');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao != "inserido")
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.formulario_menu_site.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?msg=6&id=<?=$l["id"]?>&acao=excluir&acao_adm=menu_site_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
			<?php
		}
		?>
		<input type="hidden" name="acao_adm" value="menu_site_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="_id" value="<?=$l["id"]?>">
		</form>
		<?php
	break;

	case 'lista':
	
		?>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
			<thead>
				<tr>
					<th><b>NOME</b></th>
					<th><b>ORDEM</b></th>
					<th><b>AMBIENTE</b></th>
					<th><b>ESTADO</b></th>
					<th><b>EDITAR</b></th>
					<th><b>EXCLUIR</b></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><b>NOME</b></th>
					<th><b>ORDEM</b></th>
					<th><b>AMBIENTE</b></th>
					<th><b>ESTADO</b></th>
					<th><b>EDITAR</b></th>
					<th><b>EXCLUIR</b></th>
				</tr>
			</tfoot>
			<tbody>
			<?php
			$o_menu_site = new Menu_site;
			$o_menu_site->set('ordenador',"ordem");
			if($rs = $o_menu_site->selecionar())
			{
				foreach($rs as $l)
				{
					if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}

					echo "<tr>";
					echo "<td>".$l["nome"]."</td>";
					echo "<td>".$l["ordem"]."</td>";
					echo "<td>".$l["nome_menu_ambiente"]."</td>";
					echo "<td align=\"center\">".$l['estado']."</td>";
					echo "<td align=\"center\"><a href=\"index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."\"><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
					echo "<td align=\"center\"><a href=\"javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["pergunta"]."');\"><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
					echo "</tr>";
				}
			}
			unset($o_menu_site);
			?>
			</tbody>
		</table>
		<br/><br/><br/>
		<?php

	break;


default:
break;
}
?>