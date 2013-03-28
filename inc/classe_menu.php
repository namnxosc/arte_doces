<?php
class Menu
{
	private $local;
	private $separador;
	private $id_menu_ambiente;
	private $pag_atual;
	
	function set($prop, $value)
	{
		$this->$prop = $value;
	}
	
	function __constructor()
	{
	
	}
	
	function __destruct()
	{
		
	}
	
	function menu_principal()
	{
		$o_configuracao = new Configuracao;		
				
		$o_menu_site = new Menu_site;
		$o_menu_site->set('estado', 'a');
		$o_menu_site->set('id_menu_ambiente', $this->id_menu_ambiente);
		$o_menu_site->set('ordenador', 'ordem');
		if($rs = $o_menu_site->selecionar())
		{
			$menu = "<ul>";
			foreach($rs as $l)
			{
				$url_virtual = $o_configuracao->url_virtual();
				if($l['pagina_interna'] == 'p')
				{
					if($l['id_pagina'] > 0 )
					{
						$class = "";
						$o_pagina = new Pagina;
						$o_pagina->set('id', $l['id_pagina']);
						$o_pagina->set('estado', 'a');
						if($rs = $o_pagina->selecionar())
						{
							foreach($rs as $l_p)
							{
								$chamado = $l_p['chamado'];
								$link = "pagina/".$chamado;
							}
						}
						else
						{
							$link = "";
						}
					}
					else
					{
						$link = "";
					}
					
					$link = $url_virtual.$link;
				}
				elseif($l['pagina_interna'] == 'l')
				{
					$class = "";
					$link = $l['url'];
				}
				else
				{
					$class = "";
					$url_virtual = "";
					$link = $l['url'];
				}
				
				if ($chamado == $_REQUEST['acao'])
				{
					$classe = " active_01";
					$class .= $classe;
				}
				else
				{
					$classe = "";
				}
				
				$menu .= "<li>";
				$menu .= "<a href=\"".$link."\" class=\"".$class."\" target=\"".$l["tipo_link"]."\">".$l["nome"]."</a>";
				$menu .= "</li>";
			}
			$menu .= "</ul>";
		}
		return $menu;
	}
	
	function menu_direito()
	{
		$o_ajudante = new Ajudante;		
		$o_configuracao = new Configuracao;		
		$url_virtual = $o_configuracao->url_virtual();
		
		$o_menu_site = new Menu_site;
		$o_menu_site->set('estado', 'a');
		$o_menu_site->set('id_menu_ambiente', $this->id_menu_ambiente);
		$o_menu_site->set('ordenador', 'ordem');
		if($rs = $o_menu_site->selecionar())
		{
			foreach($rs as $l)
			{
				
				if($l['pagina_interna'] == 'p') //Pagina
				{
					if($l['id_pagina'] > 0 )
					{
						$class = "";
						$o_pagina = new Pagina;
						$o_pagina->set('id', $l['id_pagina']);
						$o_pagina->set('estado', 'a');
						if($rs = $o_pagina->selecionar())
						{
							foreach($rs as $l_p)
							{
								$chamado = $l_p['chamado'];
								$link = $url_virtual.$chamado;
							}
						}
						else
						{
							$link = "";
						}
					}
					else
					{
						$link = "";
					}
				}
				elseif($l['pagina_interna'] == 'l') //LINK
				{
					$class = "";
					$link = $l['url'];

				}
				else // FUNCAO POPUP
				{
					$class = "popup";
					$link = $l['url'];
					$data_option_value = strtolower($o_ajudante->trata_texto_01_url_amigavel($l['nome']));
				}
				
				if($l["tipo"] == 't')
				{
					$nome = $l['nome'];
				}
				else
				{
					if($l['id_album'] > 0)
					{
						$o_imagem = new Imagem;
						$o_imagem->set('id_album', $l['id_album']);
						if($rs_i = $o_imagem->selecionar())
						{
							foreach($rs_i as $l_i)
							{
								$nome = "<img title=\"".$l["nome"]."\" alt=\"".$l["nome"]."\" src=\"".$url_virtual."imagens/galeria/".$l_i["nome"]."\">";
							}
						}
						else
						{
							$nome = $l['nome'];
						}
						
					}
					else
					{
						$nome = $l['nome'];
					}
				}
				
				if ($chamado == $_REQUEST['acao'])
				{
					$classe = " active_01";
					$class .= $classe;
				}
				else
				{
					$classe = "";
				}
				
				$menu .= "<a href=\"".$link."\" class=\"".$class."\" data-option-value=\"".$data_option_value."\" target=\"".$l["tipo_link"]."\">".$nome."</a>";
			}
		}
		return $menu;
		
	}
	
	

}
?>