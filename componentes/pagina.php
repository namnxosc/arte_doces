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

	$o_ilustra = new Ilustra;
	$o_ajudante = new Ajudante;
	$o_configuracao = new Configuracao;

	$url_fisico = $o_configuracao->url_fisico();
	$url_virtual = $o_configuracao->url_virtual();

	if(trim($_REQUEST['acao']) == "")
	{
		header("Location: ".$url_virtual."");
	}
	
	$o_pagina = new Pagina;
	$o_pagina->set('chamado',$_REQUEST['acao']);
	if($rs = $o_pagina->selecionar())
	{
		foreach($rs as $linha)
		{
			$pagina_titulo = $linha['nome'];
			$pagina_corpo = $linha['corpo'];
			$id_album = $linha['id_album'];
		}

		$conteudo_direito = "";
		
		if($linha['curtir_face'] == "s" || $linha['google_maps'] == "s")
		{
			
			if($linha['curtir_face'] == "s")
			{
				$url_materia = $url_virtual.substr($_SERVER['REQUEST_URI'], 1);
				$url_materia_curtir = substr($_SERVER['REQUEST_URI'], 1);
				
				$conteudo_direito .= '
							<div class="fb-like" data-href="'.$url_materia.'" data-send="false" data-width="230" data-show-faces="true" show-faces="true" border_color="#fff;"></div>	
							<div class="fb-comments" data-href="'.$url_materia.'" data-width="230" data-num-posts="5" ></div>';
			}
			
			if($linha['google_maps'] == 's')
			{
				$o_empresa = new Empresa;
				$o_empresa->set('id', '1');
				if($rs_emp = $o_empresa->selecionar())
				{
					foreach($rs_emp as $l_emp)
					{
						$google_maps = $l_emp['mapa'];
						$id_empresa = $l_emp['id'];
						$email = $l_emp['email'];
						$google_maps = "<iframe width=\"232\" height=\"200\" frameborder".preg_replace('/.*frameborder(.*)?<br \/>(.*)/','$1',$google_maps);
					}
					
					$o_empresa_contato = new Empresa_contato;
					$o_empresa_contato->set('id_empresa', $id_empresa);
					if($rs_emp_c = $o_empresa_contato->selecionar())
					{
						$telefone = "";
						foreach($rs_emp_c as $l_emp_c)
						{
							if(trim($l_emp_c['tipo']) != "" )
							{
								$tipo = " - ".$l_emp_c['tipo'];
							}
							else
							{
								$tipo = "";
							}
							
							$telefone .= "<p>(".$l_emp_c['ddd'].") ".$l_emp_c['numero'].$tipo."</p>";
						}
					}					
				}
				else
				{
					$google_maps = "";
					$telefone = "";
					$email = "";
				}
				
				//Pega Template
				$conteudo = $o_ajudante->template("".$url_fisico."templates/contato_map.html");

				$lista = array(
				"[google_maps]" => $google_maps,
				"[telefone]" => $telefone,
				"[email]" => $email,
				);	
				
				$conteudo = strtr($conteudo,$lista);
				$conteudo_direito .= $conteudo;
			}
			
			//Pega Template
			$conteudo = $o_ajudante->template("".$url_fisico."templates/pagina_detalhe_compartilhar.html");

			$lista = array(
			"[pagina_titulo]" => $pagina_titulo,
			"[pagina_corpo]" => $pagina_corpo,
			"[conteudo_direito]" => $conteudo_direito		
			);			
		}
		else
		{
			//Pega Template
			$conteudo = $o_ajudante->template("".$url_fisico."templates/pagina_detalhe.html");

			$lista = array(
			"[pagina_titulo]" => $pagina_titulo,
			"[pagina_corpo]" => $pagina_corpo
			);
			
		}
		$servico_lista .= strtr($conteudo,$lista);
		unset($lista);
		
	}

	//inicializa o template para administrar as páginas
	$template = $o_ajudante->template("".$url_fisico."templates/pagina.html");

	//troca as variáveis
	$array = array(
		"[lista]" => $servico_lista
	);

	$conteudo = strtr($template,$array);
	unset($array);
	
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

	$image_face_fb = $url_virtual."imagens/galeria/".$nome_imagem;

	$title_face_fb = $pagina_titulo;
	$url_face_fb = $url_virtual."pagina/".$_REQUEST['id'];
	$description_face_fb = "";
	$image_face_fb = $image_face_fb;
	
	$corpo_html = $conteudo;

	unset($o_configuracao);
	unset($o_ajudante);
?>