<?php
$o_empresa = new Empresa;
$o_menu_site = new Menu_site;

echo $o_ajudante->sub_menu_gc("","","CONTEUDO EMPRESA");

echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	case 'nova':
		$o_ajudante->barrado(224);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(224);

		$o_empresa->set('titulo',$_REQUEST['_titulo']);
		$o_empresa->set('email',$_REQUEST['_email']);
		$o_empresa->set('endereco',$_REQUEST['_endereco']);
		$o_empresa->set('numero',$_REQUEST['_numero']);
		$o_empresa->set('uf',$_REQUEST['_uf']);
		$o_empresa->set('cidade',$_REQUEST['_cidade']);
		$o_empresa->set('estado',$_REQUEST['estado']);
		$o_empresa->set('cep',$_REQUEST['_cep']);
		$o_empresa->set('mapa',$_REQUEST['_mapa']);
		$o_empresa->inserir();
		
		$rs = $o_empresa->selecionar();
		foreach($rs as $linha)
		{
			$id = $linha['id'];
		}
		
		$o_auditoria->set('acao_descricao',"Inserção de nova Empresa: ".$_REQUEST["_titulo"].".");
		$o_auditoria->inserir();
		
		echo "<script>ajax_pagina('empresa_contato','editar_id_empresa', '".$id."', '', '', '', '', '', '', '', 'resultado', 'ajax_gc_adm', 'false');<scrip>";
		
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=empresa_adm&layout=lista&msg=7");

	break;

	case 'editar':
		$o_ajudante->barrado(224);
		$acao = "editado";

		$o_empresa->set('id',$_REQUEST['id']);
		if($rs = $o_empresa->selecionar())
		{
		foreach($rs as $l)
		{}
		}
	break;

	case 'editado':
		$o_ajudante->barrado(224);
		$o_empresa->set('id',$_REQUEST['id']);
		$o_empresa->set('titulo',$_REQUEST['_titulo']);
		$o_empresa->set('email',$_REQUEST['_email']);
		$o_empresa->set('endereco',$_REQUEST['_endereco']);
		$o_empresa->set('numero',$_REQUEST['_numero']);
		$o_empresa->set('uf',$_REQUEST['_uf']);
		$o_empresa->set('cidade',$_REQUEST['_cidade']);
		$o_empresa->set('estado',$_REQUEST['estado']);
		$o_empresa->set('cep',$_REQUEST['_cep']);
		$o_empresa->set('mapa',$_REQUEST['_mapa']);
		$rs = $o_empresa->editar();

		$o_auditoria->set('acao_descricao',"Edição da empresa: ".$_REQUEST['_titulo'].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=empresa_adm&layout=lista&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(224);
		
		$o_empresa->set('id',$_REQUEST['id']);		
		$o_empresa->excluir();
		header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=empresa_adm&msg=8");
	break;

	default:
	break;
}


switch($_REQUEST['layout'])
{
	case 'form': 
		?>
		<script type="text/javascript">
			
			window.onload = carrega_contatos; 
			
			function carrega_contatos(){
				id = queryString("id");
				ajax_pagina('empresa_contato','selecionar', id, '', '', '', '', '', '', '', 'resultado', 'ajax_gc_adm', 'false');
			}
			
			function queryString(parameter) {  
              var loc = location.search.substring(1, location.search.length);   
              var param_value = false;   
              var params = loc.split("&");   
              for (i=0; i<params.length;i++) {   
                  param_name = params[i].substring(0,params[i].indexOf('='));   
                  if (param_name == parameter) {                                          
                      param_value = params[i].substring(params[i].indexOf('=')+1)   
                  }   
              }   
              if (param_value) {
                  return param_value;
              }   
              else {   
                  return false;   
              }   
			}
			
		</script>
		
		<form name="form" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<strong>Nome</strong>
		<input name="_titulo" maxlength="150" type="text" id="_titulo" value="<?=$l["titulo"]?>" size="30">
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<hr>
		
		<strong>E-mail</strong>
		<input name="_email" maxlength="150" type="text" id="_email" value="<?=$l["email"]?>" size="30">
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<hr>
		
		<strong>Endereço</strong>
		<input name="_endereco" maxlength="150" type="text" id="_endereco" value="<?=$l["endereco"]?>" size="30">
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<hr>
		
		<strong>Número</strong>
		<input name="_numero" maxlength="150" type="text" id="_numero" value="<?=$l["numero"]?>" size="30">
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<hr>
		
		<strong>Cep</strong>
		<input name="_cep" maxlength="150" type="text" id="_cep" value="<?=$l["cep"]?>" size="30">
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<hr>
		
		<strong>UF</strong>
		<input name="_uf" maxlength="150" type="text" id="_uf" value="<?=$l["endereco"]?>" size="30">
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<hr>
		
		<strong>Cidade</strong>
		<input name="_cidade" maxlength="150" type="text" id="_cidade" value="<?=$l["cidade"]?>" size="30">
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<hr>
		
		<strong>Mapa</strong>
		<textarea name="_mapa" id="_mapa"><?=$l["mapa"]?></textarea>
		<?php echo $o_ajudante->ajuda("Cole aqui o Iframe do mapa.");?>
		<hr>
		
		<strong>Contatos</strong>
		<input name="_ddd" maxlength="150" type="text" id="_ddd" value="DDD" size="5" onclick="this.value=''" />
		<input name="_numero_telefone" maxlength="150" type="text" id="_numero_telefone" value="Número" size="30" onclick="this.value=''" />
		<select name="_tipo" id="_tipo">
			<option value="Telefone">Telefone</option>
			<option value="Celular">Celular</option>
			<option value="Fax">Fax</option>
			<option value="">Vazio</option>
		</select>
		<img align="absmiddle" src="../imagens/gc/btn_novo.gif" onclick="ajax_pagina('empresa_contato','novo', _ddd.value, _numero_telefone.value, _tipo.value, '', '', '', '', '', 'resultado', 'ajax_gc_adm', 'false');" />
		<?php echo $o_ajudante->ajuda("Digite um título para sua nova página. Máximo 150 caracteres.");?>
		<div id='resultado'></div>
		<hr>
		
		<strong>Estado</strong>
		<input type="radio"  value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="estado"> on-line 
		<input type="radio"  value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="estado"> off-line
		<?php echo $o_ajudante->ajuda("Escolha se esta Página aparecerá no site.");?><hr>

		<strong>&nbsp;</strong>
		<input name="image" type="image" alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		<?php
		if($acao == "inserido")
		{
			echo "";
		}
		else
		{
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.form.reset();"><img alt="Desfazer" src="../imagens/gc/btn_cancelar.png"></a>
			<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?id=<?=$l["id"]?>&acao=excluir&acao_adm=empresa_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>-->
			<?php
		}
		?>
		<input type="hidden" name="acao_adm" value="empresa_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="id" value="<?=$l["id"]?>">
		</form>
		<?php
	break;

	case 'lista':
	
		if($_REQUEST['buscar'])
		{
			$o_empresa->set('termo_busca',$_REQUEST['txt_nome']);
		}
		else
		{
			$o_empresa->set('limite',40);
			$o_empresa->set('ordenador',"titulo");
		}
		if($rs = $o_empresa->selecionar())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>EMPRESA</b></th>
						<th><b>ENDEREÇO</b></th>
						<th><b>NÚMERO</b></th>
						<th><b>EDITAR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>EMPRESA</b></th>
						<th><b>ENDEREÇO</b></th>
						<th><b>NÚMERO</b></th>
						<th><b>EDITAR</b></th>
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

				echo "<td>".$l["titulo"]."</td>";
				echo "<td>".$l["endereco"]."</td>";			
				echo "<td>".$l["numero"]."</td>";			
				echo "<td align=\"center\"><a href='index.php?msg=3&id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
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