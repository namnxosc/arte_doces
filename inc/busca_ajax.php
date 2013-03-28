<?php
ob_start();
session_name("adm");
session_start("adm");

header("Content-Type: text/html; charset=ISO-8859-1");
setlocale(LC_CTYPE,"pt_BR");

//echo '<link href="../inc/formatacao_gc.css" rel="stylesheet" type="text/css">';

require_once("../inc/includes.php");

$o_configuracao = new Configuracao;
$o_ajudante = new Ajudante();

$parametro = $_REQUEST['parametro'];

function link_fechar()
{
	return $link = "<a href=\"#\" onclick=\"ajaxHTML('div_detalhe_clip_".$_REQUEST['cmp_clipping_id']."','inc/busca_ajax.php?')\">fechar</a>";
}

switch( $_REQUEST['tipo'] )
{
	case 'email_exporta':
		$texto .= '<strong>Quiz:</strong>';
		$texto .= '<select name="_id_quiz" id="_id_quiz" size="1">';
		$texto .= '<option value="0">Escolha um quiz  </option>';

		$o_quiz = new Quiz;
		$o_quiz->set('id_projeto',$_REQUEST['parametro']);
		$o_quiz->set('estado','a');
		if($rs = $o_quiz->selecionar())
		{
			foreach($rs as $l)
			{
				if($l['id'] == $_REQUEST['quero'])
				{
					$texto .= '<option value="'.$l["id"].'" selected>'.$l["nome"].'</option>';
				}
				else
				{
					$texto .= '<option value="'.$l["id"].'">'.$l["nome"].'</option>';
				}
			}
		}
		$texto .= '</select>';
		//$texto .= $o_ajudante->ajuda("Escolha se este categoria de produto aparecerá no site.");
		$texto .= '<hr>';
		unset($o_quiz);
	break;

	case 'sistema_ambiente':
		$o_ambiente = new Ambiente;
		switch($_REQUEST['parametro'])
		{
			case 'n':
				$texto .= '<strong>Pai:</strong>';
				$texto .= '<select name="_pai_id" size="1">';
				$texto .= '<option value=\"\">Selecione um botão</option>';
				$o_ambiente->set('tipo_menu', 'f');
				$res_filho = $o_ambiente->selecionar();
				foreach($res_filho as $linha)
				{
					if($linha['id'] == $_REQUEST['quero'])
					{
					//aqui falta recuperar o pai_id
					$texto .= '<option value="'.$linha["id"].'" selected>'.$linha["nome"].'</option>';
					}
					else
					{
						$texto .= '<option value="'.$linha["id"].'">'.$linha["nome"].'</option>';
					}
				}
				$texto .= '</select>';
				$texto .= '<hr>';
			break;

			case 'f':
				$texto .= '<strong>Pai:</strong>';
				$texto .= '<select name="_pai_id" size="1">';
				$texto .= '<option value=\"\">Selecione um botão</option>';
				$o_ambiente->set('tipo_menu', 'p');
				$res_pai = $o_ambiente->selecionar();
				foreach($res_pai as $l)
				{
					if($l['id'] == $_REQUEST['quero'])
					{
					//aqui falta recuperar o pai_id
					$texto .= '<option value="'.$l["id"].'" selected>'.$l["nome"].'</option>';
					}
					else
					{
						$texto .= '<option value="'.$l["id"].'">'.$l["nome"].'</option>';
					}
				}
				$texto .= '</select>';
				$texto .= '<hr>';
			break;

			case 'p':
			break;
		} 
		$texto .= '</select>';
		unset($o_ambiente);
	break;

	case 'sistema_usuario_ambiente';
		if($_REQUEST['parametro'] != ""){
			$texto = "
				<table width=100% border=\"0\" cellpadding=\"6\" cellspacing=\"0\">
				<tr class=\"linhatabela04\"><td>AMBIENTES:</td></tr>
				<tr>
					<td>";
						//$texto .= $o_ajudante->ajuda("Mostra ambientes habilitados para os Perfis de Usuario.");
						$texto .= "
					</td>
				</tr>
				<tr>";

			$o_usuario_ambiente = new Usuario_ambiente;
			$o_usuario_ambiente->set('id_usuario_tipo', $_REQUEST['parametro']);
			//$o_usuario_ambiente->set('ver', 'p');
			$o_usuario_ambiente->set('ordenador', 'nome');

			if($rs = $o_usuario_ambiente->selecionar_usuario_ambiente())
			{
				$n = $rs->rowCount();
				$n = $n / 2+1;
				$n = round($n);
				
				$x = 1;
				$texto .= "
				<table width=\"100%\" border=\"0\">
				  <tr>
					<td width=\"50%\">
				";
				$cont=0;
				foreach($rs as $linha)
				{
					if($x == $n)
					{
						$texto .= "</td><td width=\"50%\">";
					}
					else
					{
						$texto .= "";
					}
					if($linha["tem_alguma"] != '') 
					{
						$checado= " checked=\"checked\" ";
					}
					else
					{
						$checado= "  ";
					}	
					$texto .= "<input ".$checado." class=\"limpo\" name=\"cmp_ambiente_id[]\" type=\"checkbox\" id=\"cmp_ambiente_id".$cont."\" value=\"".$linha["id"]." \"  />  <label for=\"cmp_ambiente_id".$cont."\">".$linha["nome"]." [".$linha["id"]."]</label><br>";
					$x++;
					$cont++;
				}
				$texto .= " </tr>
							</table>";
			}
			$texto .= " </tr>
			</table>
			<br>
			<input name=\"image\" type=\"image\"  alt=\"Salvar alterações\" src=\"../imagens/gc/btn_cadastrar.png\">

			<input type=\"hidden\" name=\"_id_usuario_tipo\" value=\"".$_REQUEST['parametro']."\">
			<input type=\"hidden\" name=\"acao_adm\" value=\"usuario_ambiente_adm\">
			<input type=\"hidden\" name=\"acao\" value=\"inserido\">";
			unset($o_ambiente);
			unset($o_usuario_ambiente);
		}
		else
		{
			$texto = "";
		}
	break;

	case 'mostra_imagem':
		$texto = "";
		$texto = "
		<a class=\"centralizar\" href=\"javascript:ajaxHTML(document.getElementById('".$_REQUEST["div"]."').id,'../inc/busca_ajax.php');\">
		fechar
		<br />
		<img alt=\"Fechar\" title=\"Fechar\" src=\"../utilitarios/thumbnail.php?altura=".$_REQUEST["altura"]."&largura=".$_REQUEST["altura"]."&img=".$_REQUEST["parametro"]."\">
		</a>
		<br />
		<br />";
	break;

	case 'lista_imagens':
		if($_REQUEST['parametro'])
		{
			if($_REQUEST['_album'] == 'lookbook')
			{
				$click = '6_lookbook';
			}
			else
			{
				$click = '6';
			}
			$o_monta_site = new Monta_site;
			$o_monta_site->set('id_album', $_REQUEST['parametro']);
			$o_monta_site->set('x', 80);
			$o_monta_site->set('y', 80);
			$o_monta_site->set('click', $click);
			$o_monta_site->set('pasta', 'produtos');
			$o_monta_site->set('div_imagem', $_REQUEST['div']);
			$o_monta_site->set('ordenador', "nome asc");
			
			$texto = $o_monta_site->ilustra_imagem();
			unset($o_monta_site);
		}
		else
		{
			$texto = "vazio";
		}
	break;
	
	default:
		$texto = "";
	break;
}
echo $texto;
?>