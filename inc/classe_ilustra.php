<?php

class Ilustra
{
	private $album_id;
	private $miniatura;
	private $largura; 
	private $altura; 
	private $separador;
	private $url;
	private $titulo;
	private $div_ilustra;
	private $limite;
	private $acao_click; //url tipo: 1 = pop, 2 = outra página, 3 = sem link
	private $classe;
	private $pasta;
	private $destaque;
	private $div_imagem;
	private $img_erro;
	private $ordenador;
	private $id_imagem;
	private $not_in;

	function __construct()
	{
	}

	function __destruct()
	{
	}

	function set($prop, $value)
	{
		$this->$prop = $value;
	}

	function galeria()
	{ 
		$o_configuracao = new Configuracao;
		$url_virtual = $o_configuracao->url_virtual();
		$url_fisico = $o_configuracao->url_fisico();
		
		if(trim($this->pasta) == '')
		{
			$pasta_destino = "galeria";
		}
		else
		{
			$pasta_destino = $this->pasta;
		}
		if(trim($this->nivel) == '')
		{
			$nivel = "";
		}
		else
		{
			$nivel = "../";
		}
		
		if($this->album_id > 0)
		{
			$o_ajudante = new Ajudante;
			$o_album = new Album;
			$o_album->set('id',$this->album_id);
			$o_album->set('criterio', "(estado = 'a' or estado = 'x')");
			//$o_album->set('nome',$this->album_nome);

			//Se o album esta on-line
			if($res = $o_album->selecionar())
			{
				foreach($res as $l_alb)
				{
					if($l_alb['id_album_tipo'] == '1' || $l_alb['id_album_tipo'] == '4')
					{
						$pasta_destino = "produtos";
					}
				}
				
				$imagem = "";
				$o_imagem = new Imagem;
				$o_imagem->set('id_album',$this->album_id);
				$o_imagem->set('estado','a');
				
				if($this->id_imagem != "")
				{
					$o_imagem->set('id',$this->id_imagem);
				}
				
				if($this->not_in != "")
				{
					$o_imagem->set('criterio_sql', " id NOT IN (".$this->not_in.")");
				}
				
				if($this->destaque != "")
				{
					$o_imagem->set('destaque',$this->destaque);
				}
				
				if($this->ordenador != "")
				{
					$o_imagem->set('ordenador',$this->ordenador);
				}
				if($this->limite != "")
				{
					$limite = $o_imagem->set('limite',$this->limite);
				}
				if($rs = $o_imagem->selecionar())
				{
					$x = 0;
					$cont = 0;
					foreach($rs as $li)
					{
						if(trim($li["nome"]) == "")
						{
							$imagem .= "";
						}
						else
						{
							if(file_exists($url_fisico."imagens/".$pasta_destino."/".$li["nome"]))
							{
								if($this->miniatura == 'sim')
								{
									if($x == 0)
									{
										$larg = $this->largura;
										$alt = $this->altura;
									}
									else
									{
										$larg = 40;
										$alt = 40;
									}
									//$x ++;
								}
								else
								{
									$larg = $this->largura;
									$alt = $this->altura;
								}
								if(trim($this->classe) == "")
								{
									$c = "";
								}
								else
								{
									$c = " class=\"".$this->classe."\"";
								}
								switch($this->acao_click)
								{
									case "1"://LINK
										$imagem .= "
										<a alt=\"".$li["descricao"]."\" title=\"".$li["descricao"]."\" href=\"".$this->url."\">
										<img src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."\">
										</a>";
									break;

									case "2"://THUMBNAIL
										$imagem .= "<img src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."\">";
									break;
									
									case "3"://IMG
										$l = getimagesize("".$url_virtual."imagens/".$pasta_destino."/".$li["nome"]."");
										$imagem .= "<img alt=\"".$li["descricao"]."\" title=\"".$li["descricao"]."\" src=\"".$url_virtual."imagens/".$pasta_destino."/".$li["nome"]."\" width=\"".$l[0]."px\" height=\"".$l[1]."px\">";
									break;
									
									case "4":
										$l = getimagesize("".$url_virtual."imagens/".$pasta_destino."/".$li["nome"]."");
										$imagem .= "<img alt=\"".$li["descricao"]."\" title=\"".$li["descricao"]."\" src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$l[0]."&altura=".$l[1]."&img=../imagens/".$pasta_destino."/".$li["nome"]."\">";
									break;
									
									case "5":
										if($alt > 0)
										{
											$imagem .= "
													<a href=\"".$this->url."\" >
														<img alt=\"".$li["nome"]."\" src=\"".$url_virtual."imagens/".$pasta_destino."/".$li["nome"]."\" width=\"".$larg."px\" height=\"".$alt."px\" />
													</a>";
										}
										else
										{
											$imagem .= "
													<a href=\"".$this->url."\" >
														<img alt=\"".$li["nome"]."\" src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."\" />
													</a>";
										}
									break;
									
									case "6"://Alan
										$imagem .= "<div class=\"listagem_imagens\"><img ".$c." alt=\"".$li["descricao"]."\" title=\"".$li["descricao"]."\" src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."\"><a title=\"Eliminar Imagem\" href=\"javascript:ajax_pagina('lista_fotos','excluir', '".$li['id']."', '".$li["id_album"]."', '', '', '', '', '', '', '".$this->div_imagem."', 'ajax_gc_adm', 'false');\">
												<img src=\"".$url_virtual."imagens/site/resp-errada.png\" /></a><input class=\"limpo\" name=\"cmp_".$this->album_id."_img\" type=\"checkbox\" id=\"cmp_".$this->album_id."_img".$cont."\" value=\"".$li["id"]." \"  /></div>
										".$separador;
									break;

									
									case "15":
										if($_SESSION['upload_blog'] == 's')
										{
											$class = "";
											$campo_url = "
												<b>URL: </b>
												<input type=\"text\" name=\"_url_blog\" value=\"".$li["url"]."\" size=\"60\" maxlength=\"300\" onblur=\"javascrit: url_blog(this.value, '".$li['id']."');\"/>
												";
										}
										else
										{
											$class = "listagem_imagens";
											$campo_url = "";
										}
										
										$imagem .= "<div class=\"".$class."\"><img ".$c." alt=\"".$li["descricao"]."\" title=\"".$li["descricao"]."\" src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."\"><a title=\"Eliminar Imagem\" href=\"javascript:ajax_pagina('lista_fotos_iframe','excluir', '".$li['id']."', '".$li["id_album"]."', '', '', '', '', '', '', '".$this->div_imagem."', 'ajax_gc_adm', 'false');\">
												<img src=\"".$url_virtual."imagens/site/resp-errada.png\" /></a>
												".$campo_url."
												</div>
										".$separador;
									break;
									
									case "13_materia":			
											$imagem .= "<div class=\"materia_blog\">";
											$l = getimagesize("".$url_virtual."imagens/".$pasta_destino."/".$li["nome"]."");
											$larg = $l[0];
											$alt = $l[1];
											
											if(trim($li['url']) != "" && trim($li['url']) != "#")
											{
												if(preg_match("/^(http:\/\/)?(www\.)?king55.com.br[\/]?/",$li['url']))
												{
													$target = "";
												}
												else
												{
													$target = "target=\"_blank\"";
												}
												
												$url = $li['url'];
												
												if(substr($li["nome"], -3) == "gif")
												{
													$imagem .= "
													<a alt=\"\" title=\"\" href=\"".$url."\" ".$target.">
													<img alt='' title='' src='".$url_virtual."imagens/".$pasta_destino."/".$li["nome"]."' width=\"".$larg."px\" height=\"".$alt."px\">		
													</a>";
													
												}
												else
												{
													$imagem .= "
													<a alt=\"\" title=\"\" href=\"".$url."\" ".$target.">
													<img alt='".$li["descricao"]."' title='".$li["descricao"]."' src='".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."'>
													</a>";
												}
											}
											else
											{
												if(substr($li["nome"], -3) == "gif")
												{
													$imagem .= "												
													<img alt='".$li["descricao"]."' title='".$li["descricao"]."' src='".$url_virtual."imagens/".$pasta_destino."/".$li["nome"]."' width=\"".$larg."px\" height=\"".$alt."px\">												
													";
												}
												else
												{
													$imagem .= "												
													<img alt='".$li["descricao"]."' title='".$li["descricao"]."' src='".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."'>												
													";
												}
											}
											
											$imagem .= "</div>";
									break;

									case "15"://Iframe
										if($_SESSION['upload_blog'] == 's')
										{
											$class = "";
											$campo_url = "
												<b>URL: </b>
												<input type=\"text\" name=\"_url_blog\" value=\"".$li["url"]."\" size=\"60\" maxlength=\"300\" onblur=\"javascrit: url_blog(this.value, '".$li['id']."');\"/>
												";
										}
										else
										{
											$class = "listagem_imagens";
											$campo_url = "";
										}
										
										$imagem .= "<div class=\"".$class."\"><img ".$c." alt=\"".$li["descricao"]."\" title=\"".$li["descricao"]."\" src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."\"><a title=\"Eliminar Imagem\" href=\"javascript:ajax_pagina('lista_fotos_iframe','excluir', '".$li['id']."', '".$li["id_album"]."', '', '', '', '', '', '', '".$this->div_imagem."', 'ajax_gc_adm', 'false');\">
												<img src=\"".$url_virtual."imagens/site/resp-errada.png\" /></a>
												".$campo_url."
												</div>
										".$separador;
									break;
									
									case "15_blog"://Iframe
										$imagem .= "<div class=\"listagem_imagens\"><img ".$c." alt=\"".$li["descricao"]."\" title=\"".$li["descricao"]."\" src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/".$li["nome"]."\"><a title=\"Eliminar Imagem\" href=\"javascript:ajax_pagina('lista_fotos_iframe','excluir', '".$li['id']."', '".$li["id_album"]."', '', '', '', '', '', '', '".$this->div_imagem."', 'ajax_gc_adm', 'false');\">
												<img src=\"".$url_virtual."imagens/site/resp-errada.png\" /></a>
												</div>
										".$separador;
									break;
									
									default:
										$imagem .= "<img alt=\"".$li["descricao"]."\" title=\"".$li["descricao"]."\" src=\"".$url_virtual."utilitarios/thumbnail.php?largura=".$l_a."&altura=".$l_a."&img=../imagens/".$pasta_destino."/".$li["nome"]."\">";
									break;
									//$l = getimagesize("../imagens/".$pasta_destino."/".$li["nome"]."");
								}
							}
							else
							{
								$larg = $this->largura;
								$alt = $larg;
								$imagem .= "<img alt='Sem imagem' title='Sem imagem' src='".$url_virtual."utilitarios/thumbnail.php?largura=".$larg."&altura=".$alt."&img=../imagens/".$pasta_destino."/sem_imagem.png'>";
								//$imagem = "Esta imagem não existe.";
							}
						}
						$cont++;
					}
				}
			}
		}
		unset($o_ajudante);
		unset($o_imagem);
		unset($o_album);
		return $imagem;
	}
}
?>