<?php
$o_email= new Email;

echo $o_ajudante->sub_menu_gc("LISTA DE ARQUIVOS,IMPORTAR,EXPORTAR,NOVO,LISTA DE E-MAILS","msg=185&acao_adm=email_adm&acao=novo&layout=lista_arquivo,acao_adm=email_adm&layout=importar&msg=182,acao_adm=email_adm&layout=exportar&msg=184,acao_adm=email_adm&layout=form&msg=5&acao=novo,acao_adm=email_adm&layout=lista&msg=186","emails");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST["acao"])
{
	case 'novo':
		$o_ajudante->barrado(213);
		$acao = "inserido";
	break;

	case 'inserido':
		$o_ajudante->barrado(213);
		$o_email->set('email', $_REQUEST['_email']);
		$o_email->set('data',date("Y/m/d H:i:s"));
		$o_email->set('tipo', 'm');
		$o_email->set('id_projeto', $_REQUEST['_id_projeto']);
		$r = $o_email->inserir();

		$o_auditoria->set('acao_descricao', "Inserção de novo E-mail: ".$_REQUEST['_nome'].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=email_adm&acao=&layout=lista&msg=7");
	break;

	case 'editar':
		$o_ajudante->barrado(213);
		$acao = "editado";
		$o_email->set('id', $_REQUEST['id']);
		$rs = $o_email->selecionar();
		foreach($rs as $l)
		{}
	break;

	case 'editado':
		$o_ajudante->barrado(213);
		$o_email->set('nome',$_REQUEST['_nome']);
		$o_email->set('email',$_REQUEST['_email']);
		$o_email->set('tipo', 'm');
		$o_email->set('id_projeto',$_REQUEST['_id_projeto']);
		$o_email->set('id', $_REQUEST['id']);
		$rs = $o_email->editar();

		$o_auditoria->set('acao_descricao',"Edição do E-mail : ".$_REQUEST['_nome'].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=email_adm&layout=lista&id=".$_REQUEST['id']."&msg=1");
	break;

	case 'excluir':
		$o_ajudante->barrado(213);

		$o_email->set('id',$_REQUEST['id']);
		$rs = $o_email->excluir();

		$o_auditoria->set('acao_descricao',"Exclusão do E-mail: ".$_REQUEST['id'].".");
		$o_auditoria->inserir();
		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=email_adm&msg=8&layout=lista");
	break;

	case 'importar':
		$o_ajudante->barrado(213);

		$o_arquivo_envio = new Arquivo_envio;
		$o_arquivo_envio->set("arquivo",$_FILES['file_csv']);
		$o_arquivo_envio->set("permitidos","xls,xlsx");
		$o_arquivo_envio->set("tamanho_arquivo",2222222222);
		$o_arquivo_envio->set("destino","../imagens/importados/");
		$msg_final = explode("|",$o_arquivo_envio->upload());

		//Se o arquivo não subiu.
		if($msg_final[0] == "Erro")
		{
			die($o_ajudante->mensagem(0, "t", $msg_final[0], $msg_final[1], 'msg_erro'));
		}

		else
		{
			$path = "../imagens/importados/".$msg_final[2];
			if(file_exists($path))
			{
				$sucesso = 0;
				$importados = 0;

				$extensao = substr($path, -4);
				switch ($extensao)
				{
					case 'xlsx':
						$xlsx = new SimpleXLSX($path);
						list($num_cols, $num_rows) = $xlsx->dimension();

						foreach( $xlsx->rows() as $r )
						{
							for( $i=0; $i < $num_cols; $i++ )
							{
								$email = trim($r[$i]);
								if($o_ajudante->verifica_email($email))
								{
									//Verifica se o email já existe no banco
									$o_email = new Email;
									$o_email->set('email',$email);
									$o_email->set('id_projeto',$_REQUEST['_id_projeto']);
									if(!$res = $o_email->selecionar())
									{
										$o_email->set('data',date("Y/m/d H:i:s"));
										$o_email->set('tipo','a');
										$o_email->inserir();
										$importados ++;
									}
									unset($o_email);
								}
							}
						}
						unset($xlsx);
					break;

					case '.xls':
						$excel = new Spreadsheet_Excel_Reader();
						$excel->setOutputEncoding('CPa25a');
						$excel->read($path);

						while( $r <= $excel->sheets[0]['numRows'])
						{
							$y=1;
							$row="";
							while($y <= $excel->sheets[0]['numCols'])
							{
								$cell = isset($excel->sheets[0]['cells'][$r][$y]) ? $excel->sheets[0]['cells'][$r][$y] : '';
								$email = trim($cell);
								if($o_ajudante->verifica_email($email))
								{
									//Verifica se o email já existe no banco
									$o_email = new Email;
									$o_email->set('email',$email);
									$o_email->set('id_projeto',$_REQUEST['_id_projeto']);
									if(!$res = $o_email->selecionar())
									{
										$o_email->set('data',date("Y/m/d H:i:s"));
										$o_email->set('tipo','a');
										$o_email->inserir();
										$importados ++;
									}
									unset($o_email);
								}
								$y++;
							}
							$r++;
						}
						unset($excel);
					break;
				}

				if($importados != 0)
				{
					$o_auditoria->set('acao_descricao',"Arquivo de E-mails importado para o projeto ".$_REQUEST['_id_projeto'].".");
					$o_auditoria->inserir();

					$o_arquivo = new Arquivo;
					$o_arquivo->set('nome', $msg_final[2]);
					$o_arquivo->set('data',date("Y/m/d H:i:s"));
					$o_arquivo->set('id_projeto',$_REQUEST['_id_projeto']);
					$o_arquivo->set('quantidade', $importados);
					$o_arquivo->inserir();
					unset($o_arquivo);

					header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=email_adm&layout=lista_arquivo&msg=179");
				}
				else
				{
					$o_auditoria->set('acao_descricao',"Erro ao importar arquivo, e-mails já existem no banco.");
					$o_auditoria->inserir();
					header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=email_adm&layout=importar&msg=178");
				}
			}
			else
			{
				header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=email_adm&layout=importar&msg=180");
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
		<strong>E-mail:</strong>
		<input tabindex="1" maxlength="50" name="_email" type="text" value="<?=$l['email']?>" size="40">
		<span class="requerido">*</span> 
		<?php echo $o_ajudante->ajuda("Número máximo de caracteres 50.");?>
		<hr>

		<strong>Projeto:</strong>
		<select name="_id_projeto" size="1">
		<option value="">Escolha um projeto</option>
		<?php
		$o_projeto = new Projeto;
		$o_projeto->set('estado','a');
		$rs = $o_projeto->selecionar();
		foreach($rs as $linha)
		{
			?>
				<option value="<?=$linha["id"]?>" <?php if ($l["id_projeto"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
			<?php
		}
		?>
		</select>
		<?php 
		unset($o_projeto);
		echo $o_ajudante->ajuda("Selecione um projeto.");?>
		<hr>

		<strong>&nbsp;</strong>
		<input name="image" type="image"  onClick="return checa_campos('email_novo');"  alt="Salvar alterações" src="../imagens/gc/btn_cadastrar.png">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:document.formularios.reset();"><img src="../imagens/gc/btn_cancelar.png" border="0"></a>

		<input type="hidden" name="acao_adm" value="email_adm">
		<input type="hidden" name="acao" value="<?=$acao?>">
		<input type="hidden" name="id" value="<?=$l["id"]?>">
		</form>
		<?php
	break;

	case 'lista':
		$o_email->set('limite',1);
		if($rs = $o_email->selecionar())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>PROJETO</b></th>
						<th><b>E-MAIL</b></th>
						<th><b>DATA</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>PROJETO</b></th>
						<th><b>E-MAIL</b></th>
						<th><b>DATA</b></th>
					</tr>
				</tfoot>
				<tbody>
					<?php
					$o_email = new Email;
					if($_REQUEST["_id_projeto"] != "")
					{
						$o_email->set('id_projeto', $_REQUEST["_id_projeto"]);
					}
					if($rs = $o_email->selecionar())
					{
						foreach($rs as $l)
						{
							echo "<tr>";
							echo "<td><a href='index.php?msg=4&_id_projeto=".$l["id_projeto"]."&layout=lista&acao_adm=".$_REQUEST["acao_adm"]."'>".$l['nome_projeto']."</a></td>";
							echo "<td>".$l['email']."</td>";
							echo "<td align=\"center\">".$l['data']."</td>";
							echo "</tr>";
						}
					}
					unset($o_email);
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

	case 'exportar':
		if($_REQUEST["_id_quiz"] != "")
		{
			?>
			<script language="javascript">
				window.onload = function()
				{
					ajaxHTML('div_email_exporta','../inc/busca_ajax.php?quero=<?=$_REQUEST["_id_quiz"]?>&parametro=<?=$_REQUEST["_id_projeto"]?>&tipo=email_exporta');
				}
			</script>
			<?
		}
		?>

		<form name="formularios" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<strong>Projeto:</strong>
		<select name="_id_projeto" size="1" onchange="javascript:ajaxHTML(document.getElementById('div_email_exporta').id,'../inc/busca_ajax.php?tipo=email_exporta&parametro='+this.value);">
		<option value="">Escolha um projeto</option>
		<?php
		$o_projeto = new Projeto;
		$o_projeto->set('estado','a');
		$rs = $o_projeto->selecionar();
		foreach($rs as $linha)
		{
			?>
				<option value="<?=$linha["id"]?>" <?php if ($_REQUEST["_id_projeto"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
			<?php
		}
		?>
		</select>
		<?php 
		unset($o_projeto);
		echo $o_ajudante->ajuda("Selecione um Projeto.");?>
		<hr>

		<div id="div_email_exporta"></div>

		<strong>&nbsp;</strong>
		<input name="image" type="image"  onClick="return checa_campos('email_exportar');"  alt="Salvar alterações" src="../imagens/gc/btn_export.png">

		<input type="hidden" name="acao_adm" value="email_adm">
		<input type="hidden" name="layout" value="exportar">
		<input type="hidden" name="msg" value="4">
		</form><hr>

		<?php
		if(($_REQUEST['_id_projeto'] != "") && ($_REQUEST['_id_quiz'] != ""))
		{
			$o_email = new Email;
			$o_email->set('id_projeto',$_REQUEST['_id_projeto']);
			if($rs = $o_email->selecionar_02())
			{
				?>
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
					<thead>
						<tr>
							<th><b>E-MAIL</b></th>
							<th><b>LINK</b></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><b>E-MAIL</b></th>
							<th><b>LINK</b></th>
						</tr>
					</tfoot>
					<tbody>
						<?
						foreach($rs as $l)
						{
							echo "<tr>";
							echo "<td><a href='index.php?msg=4&_id_projeto=".$l["id_projeto"]."&layout=lista&acao_adm=".$_REQUEST["acao_adm"]."'>".$l['email']."</a></td>";
							echo "<td>".$l['url']."/quiz/".$_REQUEST['_id_projeto']."/".$_REQUEST['_id_quiz']."/".$l['id']."</td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
				<?php
			}
			else
			{
				echo $o_ajudante->mensagem(183)."<br />";
			}
			unset($o_email);
		}
	break;

	case 'lista_arquivo':
		$o_arquivo = new Arquivo;
		if($rs = $o_arquivo->selecionar_02())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>PROJETO</b></th>
						<th><b>NOME ARQUIVO</b></th>
						<th><b>DATA IMPORTAÇÃO</b></th>
						<th><b>E-MAILS IMPORTADOS</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>PROJETO</b></th>
						<th><b>NOME ARQUIVO</b></th>
						<th><b>DATA IMPORTAÇÃO</b></th>
						<th><b>E-MAILS IMPORTADOS</b></th>
					</tr>
				</tfoot>
				<tbody>
					<?php
					foreach($rs as $l)
					{
						echo "<tr>";
						echo "<td>".$l['nome_projeto']."</td>";
						echo "<td>".$l['nome']."</td>";
						echo "<td align=\"center\">".$l['data']."</td>";
						echo "<td align=\"center\">".$l['quantidade']."</td>";
						echo "</tr>";
					}
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
		unset($o_arquivo);
	break;

	case 'importar':
		?>
		<form name="formularios" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
			<strong>Arquivo:</strong>
			<input id="file_csv" name="file_csv" type="file" size="60"/>
			<hr />

			<strong>Projeto:</strong>
			<select name="_id_projeto" size="1">
			<option value="">Escolha um projeto</option>
			<?php
			$o_projeto = new Projeto;
			$o_projeto->set('estado','a');
			$rs = $o_projeto->selecionar();
			foreach($rs as $linha)
			{
				?>
					<option value="<?=$linha["id"]?>" <?php if ($l["id_projeto"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
				<?php
			}
			?>
			</select>
			<?php 
			unset($o_projeto);
			echo $o_ajudante->ajuda("Selecione um projeto.");?>
			<hr>

			<strong>&nbsp;</strong>
			<input name="image" type="image"  onClick="return checa_campos('email_importar');"  alt="Salvar alterações" src="../imagens/gc/btn_importar.png">
			<input type="hidden" name="acao_adm" value="email_adm">
			<input type="hidden" name="acao" value="importar">
			<input type="hidden" name="id" value="<?=$l["id"]?>">
		</form>
		<?
	break;

	default:
		echo "";
	break;
}
unset($o_email);
?>