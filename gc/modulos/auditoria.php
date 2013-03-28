<?php
$o_auditoria = new Auditoria;

switch($_REQUEST["acao"])
{
	case 'excluir':
		$o_ajudante->barrado(22);

		$o_auditoria->set('id',$_REQUEST['id']);
		$rs = $o_auditoria->excluir();

		$o_auditoria->set('acao_descricao',"Exclusão ação Auditoria: ".$_REQUEST['id'].".");
		$o_auditoria->inserir();

		header("Location: ".$_SERVER['PHP_SELF']."?acao_adm=auditoria&layout=lista&msg=8");
	break;

	default:
		echo "";
	break;
}

switch($_REQUEST['layout'])
{
	default:
		echo $o_ajudante->sub_menu_gc("","","SISTEMA AUDITORIA");
		echo $o_ajudante->mensagem($_REQUEST['msg']);
		$o_ajudante->barrado(22);

		if($rs = $o_auditoria->selecionar())
		{
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
				<thead>
					<tr>
						<th><b>DATA/HORA</b></th>
						<th><b>NOME</b></th>
						<th><b>IP</b></th>
						<th><b>AÇÃO</b></th>
						<th><b>PÁGINA DE ONDE PARTIU A AÇÃO</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th><b>DATA/HORA</b></th>
						<th><b>NOME</b></th>
						<th><b>IP</b></th>
						<th><b>AÇÃO</b></th>
						<th><b>PÁGINA DE ONDE PARTIU A AÇÃO</b></th>
						<th><b>EXCLUIR</b></th>
					</tr>
				</tfoot>
				<tbody>
				<?php
					if($rs = $o_auditoria->selecionar())
					{
						foreach($rs as $l)
						{
							echo "<tr>";
							echo "<td>".$l['data_hora']."</td>";
							echo "<td>".$l['nome']."</td>";
							echo "<td>".$l['ip']."</td>";
							echo "<td>".$l['acao']."</td>";
							echo "<td>".$l['partida']."</td>";
							echo "<td align=\"center\"><a href=javascript:confirma_02('index.php?id=".$l["id"]."&acao=excluir&acao_adm=".$_REQUEST["acao_adm"]."','".$l["acao_adm"]."');><img src=\"../imagens/gc/cancel.png\" title=\"excluir\" /></a></td>";
							echo "</tr>";
						}
					}
				?>
				</tbody>
			</table>
			<br/><br/>
			<?php
		}
		else
		{
			echo $o_ajudante->mensagem(14);
		}
	break;
}
unset($o_auditoria);
?>