<?php
	ob_start(); 
	session_name("user");
	session_start("user");
	ini_set('display_errors', E_ALL);

	if(!$_SESSION["idioma"])
	{
		$_SESSION["idioma"] = "br";
	}

	include ("inc/includes.php");

	$o_produto = new Produto;
	$o_ilustra = new Ilustra;
	$o_ajudante = new Ajudante;
	$o_configuracao = new Configuracao;
	$o_monta_produto = new Monta_produto;

	$url_fisico = $o_configuracao->url_fisico();
	$url_virtual = $o_configuracao->url_virtual();

	if(isset($_REQUEST['id']) && trim($_REQUEST['id']) != "")
	{
	
		$o_produto = new Produto;
		$o_produto->set('chamada_produto',$_REQUEST['id']);
		if($rs = $o_produto->selecionar())
		{
			foreach($rs as $linha)
			{
				$produto_id = $linha["id"];
				$id_categoria = $linha["categoria_id"];
				$produto_titulo = $linha["nome"];
				$produto_corpo = $linha["corpo"];
				$id_album = $linha["id_album"];
				
				//Monta o conteudo do blog
				$o_produto_materia = new Produto_materia;
				$o_produto_materia->set('id_produto', $produto_id);
				$o_produto_materia->set('ordenador', 'id');
				if($rs_pm = $o_produto_materia->selecionar())
				{
					$lista_blog = "";
					foreach($rs_pm as $l_pm)
					{
						$img_pm = "";
						$o_ilustra = new Ilustra;
						$o_ilustra->set('album_id',$l_pm["id_album"]);
						$o_ilustra->set('url','');
						$o_ilustra->set('pasta','produtos');
						$o_ilustra->set('acao_click','13_materia');
						$o_ilustra->set('ordenador','id');
						$img_pm = $o_ilustra->galeria();
						unset($o_ilustra);

						$lista_blog .= "<div class=\"div_blog\">";
						if(trim($l_pm['corpo']) != "")
						{
							$lista_blog .= "<div class=>".$l_pm['corpo']."</div>";
						}

						if(trim($img_pm) != "")
						{
							$lista_blog .= "<span>".$img_pm."</span>";
						}
						$lista_blog .= "</div>";
					}
					$conteudo_blog = "".$lista_blog."";
				}
				else
				{
					$conteudo_blog = "";
				}		
			}

			//seleciona o nome da imagem
			$o_imagem = new Imagem;
			$o_imagem->set('id_album',$id_album);
			$o_imagem->set('limite',1);
			if($res_imagem = $o_imagem->selecionar())
			{
				foreach($res_imagem as $l_imagem)
				{
					$nome_imagem = $l_imagem['nome'];
				}
			}
			unset($o_imagem);
			//unset($o_ilustra);
			
			//$url_materia = $url_virtual.substr($_SERVER['REQUEST_URI'], 1);
			$url_materia_curtir = substr($_SERVER['REQUEST_URI'], 1);

			$url_materia = "".$url_virtual."materia/".$_REQUEST['acao']."/".$_REQUEST['id'];			
			
			//Pega Template
			$conteudo = $o_ajudante->template("".$url_fisico."templates/interna_detalhe.html");

			$lista = array(
			"[id]" => $_REQUEST["id"],
			"[conteudo_blog]" => $conteudo_blog,
			"[produto_titulo]" => $produto_titulo,
			"[produto_corpo]" => $produto_corpo,
			"[server]" => $_SERVER['PHP_SELF'],
			"[server_name]" => $_SERVER['SERVER_NAME'],
			"[query_string]" => $_SERVER['QUERY_STRING'],
			"[action]" => $_SERVER['PHP_SELF'],
			"[url_materia]" => $url_materia,
			"[url_materia_curtir]" => $url_materia_curtir,
			"[imagem_url]" => $url_virtual."imagens/produtos/".$nome_imagem
			);

			$servico_lista .= strtr($conteudo,$lista);
			unset($lista);
		}
		//inicializa o template para administrar as páginas
		$template = $o_ajudante->template("".$url_fisico."templates/interna.html");
	}
	else
	{
		if(isset($_REQUEST['acao']))
		{
			$o_categoria = new Categoria;
			$o_categoria->set('chamada_categoria', $_REQUEST['acao']);
			$o_categoria->set('limite', 1);
			if($rs = $o_categoria->selecionar())
			{
				foreach($rs as $l)
				{
					$id_categoria = $l['id'];
				}
			}
			else
			{
				$id_categoria = "";
			}
			unset($o_categoria);
		}
		else
		{
			$id_categoria = "";
		}
			
		if($id_categoria > 0)
		{
			$o_monta_produto->set('categoria_id',$id_categoria );
			$o_monta_produto->set('estado','a');
			$lista_categoria = $o_monta_produto->lista_02();			
		}
		else
		{
			$lista_categoria = "Sem registros...";
		}
		
		$servico_lista .= $lista_categoria;
		//inicializa o template para administrar as páginas
		$template = $o_ajudante->template("".$url_fisico."templates/categoria_materia.html");
	}	

	//troca as variáveis
	$array = array(
		"[lista]" => $servico_lista
	);

	$conteudo = strtr($template,$array);
	unset($array);

	$title_face_fb = $produto_titulo;
	$url_face_fb = $url_materia;
	$image_face_fb = $url_virtual."imagens/produtos/".$nome_imagem;
	
	$corpo_html = $conteudo;

	unset($o_configuracao);
	unset($o_ajudante);
?>