<script language="javascript">
$(function()
{
	data_picker('data_01');
	data_picker('data_02');
});
</script>

<?php
$o_usuario = new Usuario;
$o_configuracao = new Configuracao;

echo $o_ajudante->sub_menu_gc("NOVO,EDITAR | EXCLUIR","msg=5&acao_adm=usuario_adm&acao=novo&layout=form,acao_adm=usuario_adm&layout=lista&msg=2","SISTEMA USUÁRIOS",$acao);
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST["acao"])
{
	case 'novo':
		$o_ajudante->barrado(9);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(9);

		$o_usuario->set('login',trim($_REQUEST['_login']));
		if($rs = $o_usuario->selecionar())
		{
				echo $o_ajudante->mensagem(44);
		}
		else
		{
			$o_usuario->set('nome',$_REQUEST['_nome']);
			$o_usuario->set('sobrenome',$_REQUEST['_sobrenome']);
			$o_usuario->set('cpf',$_REQUEST['cpf']);
			$o_usuario->set('email',$_REQUEST['_email']);
			$o_usuario->set('cep',$_REQUEST['_cep']);
			$o_usuario->set('endereco',$_REQUEST['_endereco']);
			$o_usuario->set('numero',$_REQUEST['_numero']);
			$o_usuario->set('complemento',$_REQUEST['_complemento']);
			$o_usuario->set('bairro',$_REQUEST['_bairro']);
			$o_usuario->set('uf',$_REQUEST['_uf']);
			$o_usuario->set('cidade',$_REQUEST['_cidade']);
			$o_usuario->set('telefone',$_REQUEST['_telefone']);
			$o_usuario->set('celular',$_REQUEST['_celular']);
			$o_usuario->set('fax',$_REQUEST['_fax']);
			$o_usuario->set('login',$_REQUEST['_login']);
			$o_usuario->set('senha',$o_ajudante->cria_senha($_POST["_senha"]));
			$o_usuario->set('data_hora',date("Y/m/d H:i:s"));
			$o_usuario->set('tipo','f');
			$o_usuario->set('estado',$_REQUEST['_estado']);
			$o_usuario->set('id_usuario_tipo',$_REQUEST['_usuario_tipo_id']);
			$o_usuario->set('id_usuario_02',$_SESSION['usuario_numero']);
			$r = $o_usuario->inserir();

			$o_auditoria->set('acao_descricao',"Inserção de novo usuário: ".$_REQUEST["_nome"].".");
			$o_auditoria->inserir();

			//envia e-mail para usuário cadastrado
			$mensagem = "Um novo usuário foi criado para ".$o_configuracao->site_nome()." com os seguintes dados:\n<br /><br /><b>Nome de usuário</b>: ".$_REQUEST["_login"]."\n<br /><b>Senha</b>: ".$_REQUEST["_senha"]."\n\n<br /><br />Para acessar o sistema agora clique <a href=\"".$o_configuracao->url_virtual()."gc\">aqui</a> e utilize os dados acima para se identificar. <br /><br />A senha acima foi gerada pelo administrador do sistema. Se desejar alterá-la, acesse o site clicando <a href=\"".$o_configuracao->url_virtual()."gc\">aqui</a> depois escolha o link 'Alterar Senha', assim poderá modificá-la para uma que desejar.";
			$o_ajudante->email_html($o_configuracao->site_nome()." - Seu novo usuário foi criado",$mensagem,$o_configuracao->email_contato(),$_REQUEST['_email'],"../templates/template_mailing.htm");

			//envia mensagem para o admin do site
			$mensagem = "Um novo usuário foi criado para ".$o_configuracao->site_nome()." com os seguintes dados:\n<br />Nome de usuário: ".$_REQUEST["_nome"]."\n<br />Senha: ".$_REQUEST["_senha"]."\n\n.";
			$o_ajudante->email_html($o_configuracao->site_nome()." - Novo usuário criado",$mensagem,$o_configuracao->email_contato(),$o_configuracao->email_contato(),"../templates/template_mailing.htm");

			header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=usuario_adm&msg=7");
		}
	break;

	case 'editar':
		$acao = "editado";
		$o_ajudante->barrado(5);
		$o_usuario->set('id',$_REQUEST['_id']);
		$rs = $o_usuario->selecionar();
		foreach($rs as $l)
		{}
	break;

	case 'editado':
		$o_ajudante->barrado(5);
		$o_usuario->set('nome',$_REQUEST['_nome']);
		$o_usuario->set('sobrenome',$_REQUEST['_sobrenome']);
		$o_usuario->set('cpf',$_REQUEST['cpf']);
		$o_usuario->set('email',$_REQUEST['_email']);
		$o_usuario->set('cep',$_REQUEST['_cep']);
		$o_usuario->set('endereco',$_REQUEST['_endereco']);
		$o_usuario->set('numero',$_REQUEST['_numero']);
		$o_usuario->set('complemento',$_REQUEST['_complemento']);
		$o_usuario->set('bairro',$_REQUEST['_bairro']);
		$o_usuario->set('uf',$_REQUEST['_uf']);
		$o_usuario->set('cidade',$_REQUEST['_cidade']);
		$o_usuario->set('telefone',$_REQUEST['_telefone']);
		$o_usuario->set('celular',$_REQUEST['_celular']);
		$o_usuario->set('fax',$_REQUEST['_fax']);
		$o_usuario->set('login',$_REQUEST['_login']);
		$o_usuario->set('senha',$_REQUEST['_senha']);
		$o_usuario->set('tipo','f');
		$o_usuario->set('estado',$_REQUEST['_estado']);
		$o_usuario->set('id_usuario_tipo',$_REQUEST['_usuario_tipo_id']);
		$o_usuario->set('id',$_REQUEST["_id"]);
		$r = $o_usuario->editar();

		$o_auditoria->set('acao_descricao',"Edição do usuário: ".$_REQUEST["_nome"].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=usuario_adm&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(44);
		$o_usuario->set('id',$_REQUEST['_id']);
		$rs = $o_usuario->excluir();

		$o_auditoria->set('acao_descricao',"Exclusão do Usuário: ".$_REQUEST['_id'].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=usuario_adm&msg=8");
	break;

	case 'status':
		$o_ajudante->barrado(5);
		$o_usuario->set('id',$_REQUEST['_id']);
		if($r = $o_usuario->selecionar())
		{
			foreach($r as $linha)
			{
				if($_REQUEST['u_s'] == 'on-line')
				{
					$estado_user = 'i';
				}
				elseif($_REQUEST['u_s'] == 'off-line')
				{
					$estado_user = 'a';
				}
				$o_usuario->set('estado',$estado_user);
				$o_usuario->set('id',$linha['id']);
				$r = $o_usuario->editar_estado();
			}
			$o_auditoria->set('acao_descricao',"Edição do usuário: ".$_REQUEST["_nome"].".");
			$o_auditoria->inserir();
			header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=usuario_adm&msg=1");
		}
	break;

	case 'envia_senha':
		$o_ajudante->barrado(5);
		echo $o_ajudante->envia_senha($_REQUEST['_id']);
		$o_auditoria->set('acao_descricao',"Envio de senha para usuário: ".$_REQUEST["_id"].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?layout=lista&acao_adm=usuario_adm&msg=55");
	break;

	default:
	break;
}

switch($_REQUEST['layout'])
{
	case 'form': 
		?>
		<form name="form_usuario" class="formularios" id="form_usuario" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return CheckRequiredFields();"> 
			<strong>Nome:</strong>
			<input name="_nome" value="<?=$l['nome']?>" tabindex="1" maxlength="150" id="_nome" type="text" size="30">
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Digite o nome. Máximo 150 caracteres.");?>
			<hr>

			<strong>Sobrenome:</strong>
			<input name="_sobrenome" value="<?=$l['sobrenome']?>" tabindex="2" maxlength="150" id="_sobrenome" type="text" size="30">
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Digite o sobrenome. Máximo 150 caracteres.");?>
			<hr>

			<strong>CPF:</strong>
			<input name="cpf" value="<?=$l['cpf']?>" tabindex="3" maxlength="14" id="cpf" type="text" size="30" onBlur="ValidarCPF(form_usuario.cpf);" onKeyPress="MascaraCPF(form_usuario.cpf);"/>
			<?php echo $o_ajudante->ajuda("Digite o CPF. Digite apenas números.");?>
			<hr>

			<strong>E-mail:</strong>
			<input name="_email" type="text" id="_email" tabindex="4" value="<?=$l["email"]?>" size="30" maxlength="50"> 
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Digite o e-mail. Máximo 50 caracteres.");?>
			<hr >

			<strong>CEP:</strong>
			<input name="_cep" type="text" id="_cep" size="30" value="<?=$l["cep"]?>" onKeyPress="MascaraCep(form_usuario._cep);" maxlength="10" onBlur="ValidaCep(form_usuario._cep); " tabindex="5"/>
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Digite o CEP. Digite apenas números e logo o sistema buscará o endereço completo.");?>
			<hr >

			<strong>Endere&ccedil;o:</strong>
			<input type="text" name="_endereco" id="_endereco" value="<?=$l["endereco"]?>" size="30" tabindex="6"/>
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Logradouro.");?>
			<hr >

			<strong>N&uacute;mero:</strong>
			<td><input type="text" id="_numero" name="_numero" value="<?=$l["numero"]?>" size="30" tabindex="7"/>
			<?php echo $o_ajudante->ajuda("Digite o número.");?>
			<hr >

			<strong>Complemento:</strong>
			<input name="_complemento" type="text" id="_complemento" value="<?=$l["complemento"]?>" tabindex="8" value="<?=$l["complemento"]?>" size="30" maxlength="15"> 
			<?php echo $o_ajudante->ajuda("Digite o complemento.");?>
			<hr >

			<strong>Bairro:</strong>
			<input type="text" id="_bairro" name="_bairro" value="<?=$l["bairro"]?>" size="30" tabindex="9"/>
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Bairro.");?>
			<hr >

			<strong>UF:</strong>
			<input type="text" name="_uf" id="_uf" size="30" value="<?=$l["uf"]?>" tabindex="10"/>
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("UF.");?>
			<hr >

			<strong>Cidade:</strong>
			<td><input type="text" name="_cidade" id="_cidade" size="30" value="<?=$l["cidade"]?>" tabindex="11"/>
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Cidade.");?>
			<hr >

			<strong>Telefone: </strong>
			<input name="_telefone" tabindex="12" type="text" id="_telefone" value="<?=$l["telefone"]?>" size="30" onKeyPress="MascaraTelefone(form_usuario._telefone);" onBlur="ValidaTelefone(form_usuario._telefone);" maxlength="14">
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Digite o número de telefone para contato.  Ex.: (xx)xxxx-xxxx");?>
			<hr >

			<strong>Celular: </strong>
			<input name="_celular" tabindex="13" type="text" id="_celular" value="<?=$l["celular"]?>" size="30" onKeyPress="MascaraTelefone(form_usuario._celular);" onBlur="ValidaTelefone(form_usuario._celular);" maxlength="14">
			<?php echo $o_ajudante->ajuda("Digite o número de celular.  Ex.: (xx)xxxx-xxxx");?>
			<hr >

			<strong>Fax: </strong>
			<input name="_fax" tabindex="14" type="text" id="_fax" value="<?=$l["fax"]?>" size="30" onKeyPress="MascaraTelefone(form_usuario._fax);" onBlur="ValidaTelefone(form_usuario._fax);" maxlength="14">
			<?php echo $o_ajudante->ajuda("Digite o número do fax.");?>
			<hr >

			<strong>Perfil:</strong>
			<select name="_usuario_tipo_id" size="1" tabindex="15">
			<option value="">Selecione um Perfil</option>
			<?php
			$o_usuario_tipo = new Usuario_tipo;
			if($_SESSION["usuario_tipo_id"] == 1)
			{
				$readonly = "";
			}
			else
			{
				$readonly = "readonly";
				$o_usuario_tipo->set("id",2);
			}
			$o_usuario_tipo->set("estado",'a');
			$o_usuario_tipo->set("ordenador",'nome');
			$rs = $o_usuario_tipo->selecionar();
			foreach($rs as $linha)
			{
				?>
				<option value="<?=$linha["id"]?>" <?=$readonly?> <?php if ($l["id_usuario_tipo"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
				<?php
			}
			unset($o_usuario_tipo);
			?>
			</select>
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Selecione um perfil.");?>
			<hr>

			<strong>Login: </strong>
			<input name="_login" tabindex="16" <?php if ($acao == "editado") echo " readonly=\"readonly\"";?> type="text" id="_login" value="<?=$l["login"]?>" size="30" maxlength="15"> 
			<span class="requerido">*</span> 
			<?php echo $o_ajudante->ajuda("Nome de usuário utilizado no acesso ao sistema. Use um nome sem espaços de até 15 caracteres.");?>
			<hr >

			<strong>Senha: </strong>
			<input name="_senha" <?php if ($acao == "editado") echo " readonly=\"readonly\"";?> type="password" id="_senha" tabindex="17" value="<?=$l["senha"]?>" size="30" maxlength="15"> 
			<span class="requerido">*</span>
			<?php echo $o_ajudante->ajuda("Crie uma senha de até 15 caracteres. Não utilize espaços, ç, acentos, letras maiúsculas.");?>
			<hr >

			<strong>Confirmar Senha: </strong>
			<input name="_senha_re" <?php if ($acao == "editado") echo " readonly=\"readonly\"";?> tabindex="18" type="password" id="_senha_re" value="<?=$l["senha"]?>" size="30" maxlength="15"> 
			<span class="requerido">*</span> 
			<?php echo $o_ajudante->ajuda("Digite exatamente o mesmo que foi digitado no campo Senha.");?>
			<hr >

			<strong>Estado: </strong>
			<input type="radio" value="a" <?php if ($l["estado"] == "a") echo "checked";?> name="_estado"> on-line 
			<input type="radio" value="i" <?php if ($l["estado"] == "i") echo "checked";?> name="_estado"> off-line 
			<span class="requerido">*</span> 
			<?php echo $o_ajudante->ajuda("Selecione se o usuário estará disponível.");?>
			<hr >

			<strong>&nbsp;</strong>
			<input name="image" type="image"  onClick="return checa_campos('sistema_usuario');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png"> 
			<?php
			if($acao == "editado")
			{
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.form_usuario.reset();"><img  alt="Desfazer" src="../imagens/gc/btn_cancelar.png"></a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:confirma('index.php?_id=<?=$l["id"]?>&acao=excluir&acao_adm=usuario_adm','<?=$l["nome"]?>')"><img src="../imagens/gc/btn_excluir.png" border="0"></a>
				<?php
			}
			?>
			<hr >

			<input type="hidden" name="acao_adm" value="usuario_adm">
			<input type="hidden" name="acao" value="<?=$acao?>">
			<input type="hidden" name="_id" value="<?=$l["id"]?>">
			<input type="hidden" name="msg" value="1">
		</form>
		<?php
	break;

	case 'lista':
		?>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
			<thead>
				<tr>
					<th><b>NOME</b></th>
					<th><b>SOBRENOME</b></th>
					<th><b>CPF</b></th>
					<th><b>EMAIL</b></th>
					<th><b>PERFIL</b></th>
					<th><b>ESTADO</b></th>
					<th><b>ENVIAR SENHA</b></th>
					<th><b>EDITAR</b></th>
					<th><b>EXCLUIR</b></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><b>NOME</b></th>
					<th><b>SOBRENOME</b></th>
					<th><b>CPF</b></th>
					<th><b>EMAIL</b></th>
					<th><b>PERFIL</b></th>
					<th><b>ESTADO</b></th>
					<th><b>ENVIAR SENHA</b></th>
					<th><b>EDITAR</b></th>
					<th><b>EXCLUIR</b></th>
				</tr>
			</tfoot>
			<tbody>
				<?php
				$o_usuario = new Usuario;
				if($_SESSION['usuario_tipo_id'] != 1)
				{
					$o_usuario->set('id_usuario_tipo',2);
				}
				$o_usuario->set('ordenador',"nome");
				if($rs = $o_usuario->selecionar())
				{
					foreach($rs as $l)
					{
						if($l["estado"] == "i"){$l["estado"] = "off-line";}else{$l["estado"] = "on-line";}

						echo "<tr>";
						echo "<td>".$l['nome']."</td>";
						echo "<td>".$l['sobrenome']."</td>";
						echo "<td align=\"center\">".$l['cpf']."</td>";
						echo "<td>".$l['email']."</td>";
						echo "<td align=\"center\">".$l['usuario_tipo_nome']."</td>";

						echo "<td><a href='index.php?u_s=".$l["estado"]."&_id=".$l["id"]."&acao=status&acao_adm=usuario_adm'>".$l["estado"]."</a></td>";
						echo "<td align=\"center\"><a href='index.php?_id=".$l["id"]."&acao=envia_senha&acao_adm=usuario_adm'><img src=\"../imagens/gc/mail_01.png\" width=\"32\" heigth=\"30\" title=\"enviar senha\" /></a></td>";
						echo "<td align=\"center\"><a href='index.php?msg=3&_id=".$l["id"]."&acao=editar&layout=form&acao_adm=".$_REQUEST["acao_adm"]."'><img src=\"../imagens/gc/edit.png\" title=\"editar\" /></a></td>";
						if(($l['id_usuario_tipo'] == 1) || ($l['id'] == $_SESSION['usuario_numero']))
						{
							echo "<td align=\"center\"><img src=\"../imagens/gc/cancel_02.png\" title=\"Usuário não pode ser excluido!\" /></td>";
						}
						else
						{
							echo "<td align=\"center\"><a href=javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["nome"]."');><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
						}
						echo "</tr>";
					}
				}
				unset($o_usuario);
				?>
			</tbody>
		</table>
		<br/><br/><br/>
		<?php
	break;

	default:
		echo "";
	break;
}

unset($o_usuario);
unset($o_configuracao);
?>