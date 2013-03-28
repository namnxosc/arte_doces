<?php
//a fazer
$o_backup = new backup;
$o_configuracao=new Configuracao;
$o_alditoria=new Auditoria;
$usuario = $o_configuracao->usuario();
$senha = $o_configuracao->senha();
$dbname = $o_configuracao->banco_dados();
echo $o_ajudante->sub_menu_gc("NOVO,LISTA","msg=167&acao_adm=backup_adm&acao=novo&layout=form,msg=2&acao_adm=backup_adm&layout=lista","GERAR BACKUP");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['acao'])
{
	case 'novo':
		$acao='gerar_novo_backup';
	break;

	case 'gerar_novo_backup':
		$o_ajudante->barrado(209);
		$o_auditoria->set('acao_descricao',"Cria��o de backup do sistema feito por usuario ".$_REQUEST['_usuario_nome']."[".$_SESSION["usuario_numero"]."].");
		$o_auditoria->inserir();
		$o_backup->set('id_usuario',$_SESSION["usuario_numero"]);
		$o_backup->set('data_hora',date("Y-m-d H:i:s"));
		$arquivo="backup_".$dbname.date("_Y_m_d_H_i_s").".sql";
		$o_backup->set('arquivo',$arquivo);
		if($o_backup->inserir())
		{
			// dados de conex�o com o banco de dados a ser backupeado

			//die($o_configuracao->backup_path()."backup_".$dbname.date("_Y_m_d").".sql");exit;
			// conectando ao banco
			mysql_connect($o_configuracao->host(),$usuario,$senha) or die(mysql_error());
			mysql_select_db($dbname) or die(mysql_error());

			// gerando um arquivo sql. Como?
			// a fun��o fopen, abre um arquivo, que no meu caso, ser� chamado como: nomedobanco.sql
			// note que eu estou concatenando dinamicamente o nome do banco com a extens�o .sql.
			$back = fopen($o_configuracao->backup_path().$arquivo,"w");

			// aqui, listo todas as tabelas daquele banco selecionado acima
			$res = mysql_list_tables($dbname) or die(mysql_error());
			//Em seguida, vamos, verificar quais s�o as tabelas daquela base, lista-las, e em um la�o for, vamos mostrar cada uma delas, e resgatar as fun��es de cria��o da tabela, para serem gravadas no arquivo sql mais adiante.

			// resgato cada uma das tabelas, num loop
			while ($row = mysql_fetch_row($res)) 
			{
				$table = $row[0]; 
			// usando a fun��o SHOW CREATE TABLE do mysql, exibo as fun��es de cria��o da tabela, 
			// exportando tamb�m isso, para nosso arquivo de backup
				$res2 = mysql_query("SHOW CREATE TABLE $table");
			// digo que o comando acima deve ser feito em cada uma das tabelas

				while ( $lin = mysql_fetch_row($res2))
				{ 
					// instru��es que ser�o gravadas no arquivo de backup
					fwrite($back,"\n#\n# Cria��o da Tabela : $table\n#\n\n");
					fwrite($back,"$lin[1] ;\n\n#\n# Dados a serem inclu�dos na tabela\n#\n\n");

					//Teremos ent�o de pegar os dados que est�o dentro de cada campo de cada tabela, e abri-los tamb�m para serem gravados no nosso arquivo de backup.
					// seleciono todos os dados de cada tabela pega no while acima
					// e depois gravo no arquivo .sql, usando comandos de insert
					$res3 = mysql_query("SELECT * FROM $table");
					while($r=mysql_fetch_row($res3))
					{ 
						$sql="INSERT INTO $table VALUES (";
						//Agora vamos pegar cada dado do campo de cada tabela, e executar tarefas como, quebra de linha, substitui��o de aspas, espa�os em branco, etc. Deixando o arquivo confi�vel para ser importado em outro banco de dados.

						// este la�o ir� executar os comandos acima, gerando o arquivo ao final, 
						// na fun��o fwrite (gravar um arquivo)
						// este la�o tamb�m ir� substituir as aspas duplas, simples e campos vazios
						// por aspas simples, colocando espa�os e quebras de linha ao final de cada registro, etc
						// deixando o arquivo pronto para ser importado em outro banco

						 for($j=0; $j<mysql_num_fields($res3);$j++)
						{
							if(!isset($r[$j]))
								$sql .= " '',";
							elseif($r[$j] != "")
								$sql .= " '".addslashes($r[$j])."',";
							else
								$sql .= " '',";
						}
						$sql = ereg_replace(",$", "", $sql);
						$sql .= ");\n";

						fwrite($back,$sql);
					}
				}
			}

			//E finalmente, vamos fechar (internamente, no servidor) o arquivo que geramos, dando um nome para o mesmo, e gerando o arquivo que ser� ent�o disponibilizado para download.
			// fechar o arquivo que foi gravado

			fclose($back);
			// gerando o arquivo para download, com o nome do banco e extens�o sql.
			ob_end_clean();
			// reabra a saida 
			ob_start(); 
			Header("Content-type: application/sql");
			Header("Content-Disposition: attachment; filename=$arquivo");
			// l� e exibe o conte�do do arquivo gerado
			readfile($o_configuracao->backup_path().$arquivo);
			exit;
		}
		else
		{
			die("Erro ao inserir");exit;
		}
	break;

	case 'download':
		$o_ajudante->barrado(209);
		$arquivo=$_REQUEST['_file'];

		// gerando o arquivo para download, com o nome do banco e extens�o sql.
		ob_end_clean();
		// reabra a saida 
		ob_start(); 
		Header("Content-type: application/sql");
		Header("Content-Disposition: attachment; filename=$arquivo");
		// l� e exibe o conte�do do arquivo gerado
		readfile($o_configuracao->backup_path().$arquivo);
		exit;
	break;

	case 'excluir':
		$o_ajudante->barrado(209);
		$o_backup->set('id',$_REQUEST['_id']);
		$o_backup->excluir();
		unlink($o_configuracao->backup_path().$_REQUEST['_file']);
		$o_auditoria->set('acao_descricao',"Exclus�o de registro de backup:".$_REQUEST['_usuario_nome']."[".$_SESSION["usuario_numero"]."].");
		$o_auditoria->inserir();
		header("Location:index.php?acao_adm=backup_adm&layout=lista");
	break;

	default:
	break;
}


switch($_REQUEST['layout'])
{
	case 'form': 
		?>
		<form name="form" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">
			
			<strong></strong>
			<input  type="submit"  alt="Gerar backup" value="Gerar backup">
			<input type="hidden" name="acao" value="<?=$acao?>">
			<input type="hidden" name="acao_adm" value="backup_adm">
			</form>
		<?php
	break;

	case 'lista':
		$o_backup->set('limite',1);
		$o_backup->set('ordenador',"data_hora");
		if($rs = $o_backup->selecionar_backup_usuario())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>ARQUIVO</b></th>
						<th><b>USUARIO</b></th>
						<th><b>HORA</b></th>
						<th><b>DATA </b></th>
						<th><b>FAZER DOWNLOAD </b></th>
						<th><b>EXCLUIR </b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>ARQUIVO</b></th>
						<th><b>USUARIO</b></th>
						<th><b>HORA</b></th>
						<th><b>DATA </b></th>
						<th><b>FAZER DOWNLOAD </b></th>
						<th><b>EXCLUIR </b></th>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$o_backup = new Backup;
				$o_backup->set('ordenador',"data_hora");
				if($rs = $o_backup->selecionar_backup_usuario())
				{
					foreach($rs as $l)
					{
						echo "<tr>";
						echo "<td>".$l['arquivo']."</td>";
						echo "<td>".$l['usuario_nome']."</td>";
						echo "<td>".$l['hora']."</td>";
						echo "<td>".$l['data']."</td>";
						echo "<td align=\"center\"><a href=\"index.php?acao_adm=backup_adm&acao=download&_file=".$l["arquivo"]."\">download</a></td>";
						echo "<td align=\"center\"><a href=\"javascript:confirma('index.php?_id=".$l["id"]."&acao=excluir&acao_adm=backup_adm&_file=".$l["arquivo"]."','".$l["usuario_nome"]."')\"><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
						echo "</tr>";
					}
				}
				unset($o_backup);
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