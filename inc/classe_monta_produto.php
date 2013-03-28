<?php
class Monta_produto
{
	private $limite;
	private $limite_inicio;
	private $termo_busca;
	private $categoria_id;
	private $produto_id;
	private $estado;
	private $desc_asc;
	private $pagina_ajax;
	private $busca_produto;
	private $botao_home;
	private $tipo_botao_home;
	private $tipo_botao_home_value;
	private $altura;
	private $in_busca;
	private $player_mp3;
	private $id_musica;
	private $pagina;
	private $chamada_pai;
	private $ajax;

	function __constructor()
	{
		//
	}

	function set($prop, $value)
	{
		$this->$prop = $value;
	}

	function lista()
	{
		$o_produto = new Produto;
		$o_ajudante = new Ajudante;
		$o_configuracao = new Configuracao;

		$url_virtual = $o_configuracao->url_virtual();
		$url_fisico = $o_configuracao->url_fisico();
		
		$o_produto->set('limite', $this->limite);
		$o_produto->set('limite_inicio', $this->limite_inicio);
		$o_produto->set('estado', 'a');
		$o_produto->set('termo_busca',$this->termo_busca);
		$o_produto->set('ordenador', $this->ordenador);
		$o_produto->set('DESC_ASC', $this->desc_asc);
		if($rs = $o_produto->selecionar_produto_complemento())
		{
			$total_produtos = $rs->rowCount();
			$limite_palabras_p = 10;	// Materia pequena
			$limite_palabras_m = 15;	// Materia mediana
			$limite_palabras_g = 20;	// Materia grande
			$limite_palabras_c = 25;	// Materia completa
			foreach($rs as $l)
			{
				$o_ilustra = new Ilustra;
				$corpo_tratado = "";

				if($l['estilo'] == 'p')
				{
					$tipo_col = "col2";
					$span = "span_inf_p";
					$largura = 256;
					$corpo = $l['corpo'];
					$corpo_array = explode(" ", $corpo);
					$count_palabras = count($corpo_array);
					if($count_palabras > $limite_palabras_p)
					{
						for($i=0;$i<$limite_palabras_p ; $i++)
						{
							$corpo_tratado .= $corpo_array[$i]." ";
						}
						$corpo_tratado = $corpo_tratado;
					}
					else
					{
						$corpo_tratado = $corpo;
					}
					$tamanhio_sombra = "sombra_01";
				}
				elseif($l['estilo'] == 'm')
				{
					$tipo_col = "col3";
					$span = "span_inf_m";
					$largura = 531;
					$corpo = $l['corpo'];
					$corpo_array = explode(" ", $corpo);
					$count_palabras = count($corpo_array);
					if($count_palabras > $limite_palabras_m)
					{
						for($i=0;$i<$limite_palabras_m ; $i++)
						{
							$corpo_tratado .= $corpo_array[$i]." ";
						}
						$corpo_tratado = $corpo_tratado;
					}
					else
					{
						$corpo_tratado = $corpo;
					}
					$tamanhio_sombra = "sombra_02";
				}
				elseif($l['estilo'] == 'g')
				{
					$tipo_col = "col4";
					$span = "span_inf_g";
					$largura = 808;
					$corpo = $l['corpo'];
					$corpo_array = explode(" ", $corpo);
					$count_palabras = count($corpo_array);
					if($count_palabras > $limite_palabras_g)
					{
						for($i=0;$i<$limite_palabras_g ; $i++)
						{
							$corpo_tratado .= $corpo_array[$i]." ";
						}
						$corpo_tratado = $corpo_tratado;
					}
					else
					{
						$corpo_tratado = $corpo;
					}
					$tamanhio_sombra = "sombra_03";
				}
				elseif($l['estilo'] == 'c')
				{
					$tipo_col = "col5";
					$span = "span_inf_c";
					$largura = 1084;
					$corpo = $l['corpo'];
					$corpo_array = explode(" ", $corpo);
					$count_palabras = count($corpo_array);
					if($count_palabras > $limite_palabras_c)
					{
						for($i=0;$i<$limite_palabras_c ; $i++)
						{
							$corpo_tratado .= $corpo_array[$i]." ";
						}
						$corpo_tratado = $corpo_tratado;
					}
					else
					{
						$corpo_tratado = $corpo;
					}
					$tamanhio_sombra = "sombra_04";
				}

				/* Monta as categorias(tags) nos produtos(materias)*/
				$tag_categoria = "";
				$o_categoria_produto = new Categoria_produto;
				$o_categoria_produto->set('id_produto', $l['id']);
				if($rs_01 = $o_categoria_produto->selecionar_categoria_produto_02())
				{
					foreach($rs_01 as $l_01)
					{
						$data_option_value = $o_ajudante->trata_texto_01($l_01['nome']);
						$tag_categoria .= "".$data_option_value." ";
					}
					$tag_categoria = substr($tag_categoria, 0, -1);
				}
				else
				{
					$tag_categoria = "";
				}
				unset($o_categoria_produto);
				/*Fim tags*/

				$acao_click = "5";
				$link_img = "";
				$nome_imagem = "";
				$img = "";
				
				
				//$url_detalhe = $url_virtual."site/materia.php?acao_materia=detalhe&id=".$l['id']."";
				$url_detalhe = $url_virtual."interna/".$l['chamada_categoria']."/".$l['chamada_produto']."";
				$o_ilustra->set('limite',1);				
								
				if($l["id_album"] == 0 || $l["id_album"] == "")
				{
					$l["id_album"] = 1;
				}
				$o_ilustra->set('album_id',$l["id_album"]);
				$o_ilustra->set('largura',$largura);
				$o_ilustra->set('pasta','produtos');				
				$o_ilustra->set('separador','');				
				$o_ilustra->set('acao_click',$acao_click);
				$o_ilustra->set('url',$url_detalhe);
				$o_ilustra->set('div_ilustra','div_mostra_imagem');				
				$img = $o_ilustra->galeria();				
				
				//seleciona o nome da imagem
				$o_imagem = new Imagem;
				$o_imagem->set('id_album',$l['id_album']);
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
			

				//Pega Template
				$conteudo = $o_ajudante->template("".$url_fisico."templates/produto_destaque.html");
				if($l["preco"] != 0)
				{
					if($l["desconto"] != 0)
					{
						$preco = " 
						De <b class=\"cortado\">R$ ".number_format($l['preco'], 2, ',', ' ')."</b><br />
						Por R$ ".number_format($o_ajudante->desconto($l['preco'],$l["desconto"]), 2,',',' ');
					}
					else
					{
						$preco = "<b>R$ ".number_format($l['preco'], 2,',',' ')."</b>";
					}
				}
				
				
				$lista = array(
				"[url_virtual]" => $url_virtual,
				"[class]" => "element ".$tag_assunto." ".$tag_categoria." box ".$tipo_col."  ",
				"[span]" => $span,
				"[imagem]" => $img,
				"[nome]" => $l["nome"],
				"[descricao]" => strip_tags($corpo_tratado),
				"[tipo]" => $l["tipo"],
				"[preco]" => $preco,
				"[categoria_id]" => $_REQUEST["_categoria_id"],
				"[id]" => $l["id"],
				"[complemento_id]" => $l["complemento_id"],
				"[nome]" => $l["nome"],
				"[url]" => $url_detalhe,
				"[tamanhio_sombra]" => $tamanhio_sombra,
				"[imagem_url]" => $url_virtual."imagens/galeria/".$nome_imagem,
				);
				$resultado .= strtr($conteudo,$lista);
				unset($lista);
				unset($o_ilustra);
			}//fecha foreach
		}
		else
		{
			//$resultado = $o_ajudante->mensagem(14);
			$resultado = false;
		}//fecha busca por produto
		// PAGINAÇÃO PARTE 2 FIM 

		return $resultado;
		unset($o_produto);
		unset($o_menu_produto);
		unset($o_ajudante);
		unset($o_configuracao);
	}

	function lista_02()
	{
		$o_produto = new Produto;
		$o_ajudante = new Ajudante;
		$o_configuracao = new Configuracao;

		$url_virtual = $o_configuracao->url_virtual();
		$url_fisico = $o_configuracao->url_fisico();
		
		$limite_palabras_p = 20;	// Materia pequena
		$limite_palabras_g = 20;	// Materia grande
		$acao_click = 5;

		$o_produto->set('limite', $this->total_registros_pagina);
		$o_produto->set('estado', 'a');
		$o_produto->set('limite_inicio', $array_paginacao['limite_inicio']);
		$o_produto->set('termo_busca',$this->termo_busca);
		$o_produto->set('categoria_id', $this->categoria_id);
		$o_produto->set('ordenador', $this->ordenador);
		$o_produto->set('DESC_ASC', $this->desc_asc);
		if($rs = $o_produto->selecionar_produto_complemento_04())
		{
			$total_produtos = $rs->rowCount();

			foreach($rs as $l)
			{
				$o_ilustra = new Ilustra;

				$class = "element Comportamento   box col2";
				
				$tamanhio_sombra = "sombra_01";
				
				$conteudo = $o_ajudante->template("".$url_fisico."templates/produto_destaque_02.html");				
				
				$url_detalhe = $url_virtual."materia/".$l["chamada_categoria"]."/".$l['chamada_produto']."";
				
				$o_ilustra->set('album_id',$l["id_album"]);
				$o_ilustra->set('largura','256');
				//$o_ilustra->set('altura','146');
				$o_ilustra->set('separador','');
				$o_ilustra->set('limite','1');
				$o_ilustra->set('pasta','produtos');
				$o_ilustra->set('acao_click',$acao_click);
				$o_ilustra->set('url',$url_detalhe);
				$o_ilustra->set('div_ilustra','div_mostra_imagem');

				//seleciona o nome da imagem
				$o_imagem = new Imagem;
				$o_imagem->set('id_album',$l['id_album']);
				$o_imagem->set('limite',1);
				if($res_imagem = $o_imagem->selecionar())
				{
					foreach($res_imagem as $l_imagem)
					{
						$nome_imagem = $l_imagem['nome'];
					}
				}
				unset($o_imagem);
				
				if($l["preco"] != 0)
				{
					if($l["desconto"] != 0)
					{
						$preco = " 
						De <b class=\"cortado\">R$ ".number_format($l['preco'], 2, ',', ' ')."</b><br />
						Por R$ ".number_format($o_ajudante->desconto($l['preco'],$l["desconto"]), 2,',',' ');
					}
					else
					{
						$preco = "<b>R$ ".number_format($l['preco'], 2,',',' ')."</b>";
					}
				}
				
				//Limita tamanho do texto
				$nome = strlen($l["nome"]);
				if($nome > 20)
				{
					$nome = substr($l["nome"],0,20) . " ..";
				}
				else
				{
					$nome = $l['nome'];
				}
				
				$link_detalhes = $url_virtual."materia/".$l["chamada_categoria"]."/".$l["chamada_produto"]."";
				$lista = array(
					"[url_virtual]" => $url_virtual,
					"[class]" => $class,
					"[imagem]" => $o_ilustra->galeria(),
					"[tipo]" => $l["tipo"],
					"[preco]" => $preco,
					"[categoria_id]" => $_REQUEST["_categoria_id"],
					"[id]" => $l["id"],
					"[complemento_id]" => $l["complemento_id"],
					"[nome]" => $l["nome"],
					"[descricao]" => strip_tags($l['corpo']),
					"[url]" => $url_detalhe,
					"[tamanhio_sombra]" => $tamanhio_sombra,
					"[imagem_url]" => $url_virtual."imagens/galeria/".$nome_imagem,
					"[link_detalhes]" => $link_detalhes,
				);
				$resultado .= strtr($conteudo,$lista);
				unset($o_ilustra);
				unset($lista);
					
			
			}//fecha foreach
		}
		else
		{
			$resultado .= $o_ajudante->mensagem(14);
			$resultado = false;
		}//fecha busca por produto

		// PAGINAÇÃO PARTE 2 FIM 
		
		return $resultado;
		unset($o_produto);
		unset($o_menu_produto);
		unset($o_ilustra);
		unset($o_ajudante);
		unset($o_configuracao);
	}
	
	function monta_imagem($id_complemento)
	{
		$o_ilustra = new Ilustra;
		$o_produto_complemento = new Produto_complemento;
		$o_produto_complemento->set("id",$id_complemento);
		//$o_produto_complemento->set("estado","a");
		if($rs = $o_produto_complemento->selecionar())
		{
			foreach($rs as $linha)
			{
				if($linha["id_album"] != 0)
				{
					$o_ilustra->set('album_id',$linha["id_album"]);
					$o_ilustra->set('largura','50');
					$o_ilustra->set('altura','50');
					$o_ilustra->set('separador',' ');
					$o_ilustra->set('url','asd.php');
					$o_ilustra->set('acao_click','3');
					$o_ilustra->set('div_ilustra','div_mostra_imagem');
					$o_ilustra->set('limite','1');
					$resultado .= $o_ilustra->galeria()."";
				}
			}
		}
		else
		{
			echo "asd<br>";
		}
		return $resultado;
		unset($o_produto_complemento);
		unset($o_ilustra);
	}
	
	function monta_produto_complemento()
	{
		if($this->id_produto)
		{
			$o_produto_complemento = new Produto_complemento;
			$o_produto_complemento->set('id_produto', $this->id_produto);
			$o_produto_complemento->set('ordenador', 'id asc');
			if($rs = $o_produto_complemento->selecionar())
			{
				$resultado = "";
				$cont = 0;
				$id_img = "";
				foreach($rs as $l)
				{
					if($l["id_imagem"] != "" || $l["id_imagem"] != 0)
					{
						$id_img .= $l['id_imagem'].",";
						$o_ilustra = new Ilustra;
						$o_ilustra->set('album_id',$l["id_album"]);
						$o_ilustra->set('id_imagem',$l["id_imagem"]);
						$o_ilustra->set('largura','80');
						$o_ilustra->set('altura','80');
						$o_ilustra->set('separador',' ');
						$o_ilustra->set('acao_click','8');
						$o_ilustra->set('limite','1');
						$img = $o_ilustra->galeria();
						unset($o_ilustra);
						
						$resultado .= "
								<div class=\"listagem_imagens_form\">
									<a title=\"Eliminar Imagem\" href=\"javascript:ajax_pagina('lista_produto_complemento','excluir', '".$l['id']."', '".$this->id_produto."', '".$l['id_imagem']."', '', '', '', '', '', 'div_ajax_resultado_03', 'ajax_gc_adm', 'false');\"><img src=\"../imagens/site/resp-errada.png\" /></a><br/>
									".$img."<br/>
									<label>Nome:</label>
									<input id=\"cmp_lookbook_".$cont."\" name=\"cmp_lookbook_[]\" type=\"text\" size=\"30\" maxlength=\"50\" value=\"".$l['tipo']."\" />
									<input id=\"cmp_lookbook_id_".$cont."\" name=\"cmp_lookbook_id_[]\" type=\"hidden\" size=\"30\" maxlength=\"50\" value=\"".$l['id']."\" />
								</div>					
						";
						
						$cont++;				
					}
				}
				$id_img = substr($id_img, 0, -1);
				$_SESSION['ids_img_lookbook'] = $id_img;
			}
			unset($o_produto_complemento);
			return $resultado;
		}
		else
		{
			$_SESSION['ids_img_lookbook'] = "";
			return false;
		}
	}
}
?>