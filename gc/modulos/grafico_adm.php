<?php
echo $o_ajudante->sub_menu_gc("AMBIENTE DE GRÁFICOS","acao_adm=grafico_adm&layout=lista&msg=2","Gráficos");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['layout'])
{
	case 'lista':
		$o_ajudante->barrado(217);
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
		<input name="image" type="image"  onClick="return checa_campos('email_exportar');"  alt="Salvar alterações" src="../imagens/gc/btn_selecionar.png">

		<input type="hidden" name="acao_adm" value="grafico_adm">
		<input type="hidden" name="layout" value="lista">
		<input type="hidden" name="msg" value="4">
		</form>
		<hr>

		<?php
		if(($_REQUEST['_id_projeto'] != "") && ($_REQUEST['_id_quiz'] != ""))
		{
			$o_pergunta = new Pergunta;
			$o_pergunta->set('id_quiz', $_REQUEST['_id_quiz']);
			$o_pergunta->set('estado', 'a');
			if($r_p = $o_pergunta->selecionar())
			{
				$cont = 1;
				?>
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
					<thead>
						<tr>
							<th><b>PERGUNTAS E RESPOSTAS</b></th>
							<th><b>GRÁFICO</b></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><b>PERGUNTAS E RESPOSTAS</b></th>
							<th><b>GRÁFICO</b></th>
						</tr>
					</tfoot>
					<tbody>
						<?
						foreach($r_p as $l_p)
						{
							$cont_02 = 1;
							echo "<tr>";
							echo "<td><b>".$cont.") ".$l_p['pergunta']."</b><br /><br />";

							//Inicializando variaveis
							$label = "";
							$l_vars = "";
							$vars = "";

							//Verifica se Perguntas possuem respostas.
							$o_resposta = new Resposta;
							$o_resposta->set('id_pergunta', $l_p['id']);
							if($r_r = $o_resposta->selecionar())
							{
								$quantidade_respostas = $r_r->rowCount();
								foreach($r_r as $l_r)
								{
									$cont_respostas = 0;
									$array[$cont_02] = "";

									//Mostra no lado esquerdo da tabela as respostas da Pergunta.
									echo "<b>".$cont.".".$cont_02.") </b> ".$l_r['resposta']."<br />";

									$o_enquete = new Enquete;
									$o_enquete->set('id_resposta', $l_r['id']);
									if($res_enquete = $o_enquete->selecionar())
									{
										$cont_respostas = $res_enquete->rowCount();
									}
									unset($o_enquete);

									$array[$cont_02] .= $cont_respostas.",";
									$label .= "{label:'<b>".$cont.".".$cont_02.") </b>".$l_r['resposta']."'},"; 
									$cont_02 ++;
								}

								//Montamos as barras do grafico.
								for($j=1; $j <= $quantidade_respostas; $j++)
								{
									$vars .= "var s".$l_p['id'].$j."=[".substr($array[$j], 0, -1)."];";
									$l_vars .= "s".$l_p['id'].$j.",";
								}

								//Tratamento nos labels e l_vars.
								$label = substr($label, 0, -1);
								$l_vars = substr($l_vars, 0, -1);

								//Total de participantes que respoderam a Pergunta
								$o_enquete = new Enquete;
								$o_enquete->set('id_pergunta', $l_p['id']);
								if($res = $o_enquete->total_participante())
								{
									$partipante = $res->rowCount();
									echo "<br /><b>Número de participantes: </b>".$partipante;
								}
								else
								{
									echo "<br /><b>Número de participantes: </b>0";
								}
								unset($o_enquete);

								//Nessa parte montar o gráfico de acordo a tabela Enquete.
								$o_monta_grafico = new Monta_grafico;
								$o_monta_grafico->set('vars', $vars);
								$o_monta_grafico->set('l_vars', $l_vars);
								$o_monta_grafico->set('label', $label);
								$o_monta_grafico->set('contador', $cont);
								$o_monta_grafico->set('nome_pergunta', $l_p['pergunta']);
								echo "<td align=\"center\">".$o_monta_grafico->monta_grafico_barra()."<br />";
								unset($o_monta_grafico);
							}
							else
							{
								echo "<td>Pergunta sem respostas cadastradas no Sistema!</td>";
							}
							echo "</td></tr>";
							$cont ++;
							unset($o_resposta);
						}
						?>
					</tbody>
				</table>
				<?php
			}
			else
			{
				echo $o_ajudante->mensagem(187)."<br />";
			}
			unset($o_pergunta);
		}
	break;
}
?>