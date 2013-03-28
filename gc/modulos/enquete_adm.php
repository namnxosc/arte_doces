<?php
$o_enquete = new Enquete;

echo $o_ajudante->sub_menu_gc("EDITAR | EXCLUIR","acao_adm=quiz_adm&layout=lista&msg=2","ENQUETE");
echo $o_ajudante->mensagem($_REQUEST['msg']);

switch($_REQUEST['layout'])
{
	case 'lista':
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

		<input type="hidden" name="acao_adm" value="enquete_adm">
		<input type="hidden" name="layout" value="lista">
		<input type="hidden" name="msg" value="4">
		</form><br />

		<?php
		if(($_REQUEST['_id_projeto'] != "") && ($_REQUEST['_id_quiz'] != ""))
		{
			$o_enquete = new Enquete;
			$o_enquete->set('id_projeto',$_REQUEST['_id_projeto']);
			$o_enquete->set('id_quiz',$_REQUEST['_id_quiz']);
			$o_enquete->set('group_by','id_email');
			if($rs = $o_enquete->selecionar_respostas())
			{
				?>
				<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
					<thead>
						<tr>
							<th><b>E-MAIL</b></th>
							<th><b>RESPOSTAS</b></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><b>E-MAIL</b></th>
							<th><b>RESPOSTAS</b></th>
						</tr>
					</tfoot>
					<tbody>
						<?php
						foreach($rs as $l)
						{
							echo "<tr>";
							echo "<td>".$l['email']."</td>";
							echo "<td><a href=\"javascript:ver_enquete('".$_REQUEST['_id_projeto']."', '".$_REQUEST['_id_quiz']."', '".$l['id_email']."');\">ver respostas</a></td>";
							echo "</tr>";
						}
						?>
					</tbody>
				</table>
				<?php
			}
			else
			{
				echo $o_ajudante->mensagem(188)."<br />";
			}
			unset($o_enquete);
		}
	break;

	default:
		echo "";
	break;
}
unset($o_enquete);
?>