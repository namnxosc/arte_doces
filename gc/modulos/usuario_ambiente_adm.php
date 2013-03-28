<?php
$o_usuario_ambiente = new Usuario_ambiente;

//área de acesso somente a administradores
if($_SESSION["usuario_adm_tipo"] == "c")
{
	echo $o_ajudante->barrado(181);
}
else
{
	echo "";
}

echo $o_ajudante->sub_menu_gc("","","SISTEMA USUARIO AMBIENTES ");
echo $o_ajudante->mensagem(41);

switch($_REQUEST['acao'])
{
	case 'inserido':
		echo $o_ajudante->barrado(181);

		//deleta todas as permissões
		$o_usuario_ambiente->set('id_usuario_tipo', $_REQUEST['_id_usuario_tipo']);
		$rs = $o_usuario_ambiente->excluir();

		//insere todas permissões selecionadas anteriormente
		$num = count($_REQUEST['cmp_ambiente_id']);
		for($i = 0; $i<$num; $i++)
		{
			$o_usuario_ambiente->set('id_ambiente',$_REQUEST['cmp_ambiente_id'][$i]);
			$o_usuario_ambiente->set('id_usuario_tipo',$_REQUEST['_id_usuario_tipo']);
			$r = $o_usuario_ambiente->inserir();
			$o_auditoria->set('acao_descricao',"Inserção de nova permissão: Ambiente: ".$_REQUEST['cmp_ambiente_id'][$i]." - Usuario Tipo: ".$_REQUEST['_id_usuario_tipo'].".");
			$o_auditoria->inserir();
		}
		header("Location: ".$_SERVER['PHP_SELF']."?msg=41&acao_adm=usuario_ambiente_adm&acao=criado&_id_usuario_tipo=".$_REQUEST['_id_usuario_tipo']."");
	break;

	case 'criado':
		echo $o_ajudante->barrado(181);
		?>
		<script language="javascript">
			window.onload = function()
			{
				ajaxHTML('div_sistema_usuario_ambiente','../inc/busca_ajax.php?acao=listar&parametro=<?=$_REQUEST["_id_usuario_tipo"]?>&tipo=sistema_usuario_ambiente');
			}
		</script>
		<?php
	break;

	default:
		echo $o_ajudante->barrado(181);
	break;
}

?>
<form name="formulario_usuario_ambientes" id="formulario_usuario_ambientes" class="formularios" action="<?=$_SERVER['PHP_SELF']?>" method="post">

	Perfil de Usuario
	<select name="_usuario_tipo_id" size="1" onchange="javascript:ajaxHTML(document.getElementById('div_sistema_usuario_ambiente').id,'../inc/busca_ajax.php?tipo=sistema_usuario_ambiente&parametro='+this.value);">
	<option value="">Selecione um perfil</option>
	<?php
	$o_usuario_tipo = new Usuario_tipo;
	$o_usuario_tipo->set('ordenador','nome');
	$rs = $o_usuario_tipo->selecionar();
	foreach($rs as $linha)
	{ 
	?>
		<option value="<?=$linha["id"]?>" <?php if ($_REQUEST["_id_usuario_tipo"] == $linha["id"]) echo "selected" ;?>><?=$linha["nome"]?></option>
	<?php
	}
	?>
	</select>
	<?php echo $o_ajudante->ajuda("Escolha um Perfil.");
	unset($o_usuario_tipo);
	?>
	<hr>
</form>
<br>

<form name="formulario_ambiente_usuario" id="formulario_ambiente_usuario" action="<?=$_SERVER['modulos/PHP_SELF']?>" method="post">
	<div id="div_sistema_usuario_ambiente"></div>
</form>