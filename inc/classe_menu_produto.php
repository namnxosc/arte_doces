<?php

class Menu_produto
{
	private $paramentro;
	private $id_portal;
	private $select_pai;
	private $home;
	
	function __constructor()
	{
		//
	}
	
	function set($prop, $value)
	{
      $this->$prop = $value;
	}

	

	function menu_produto($tipo="",$quero="")
	{
		$o_ajudante = new Ajudante;
		$o_categoria = new Categoria;
		$o_configuracao = new Configuracao;
		
		$url_virtual = $o_configuracao->url_virtual();
		$o_categoria->set('ordenador', 'ordem');
		$o_categoria->set('estado', 'a');
		$rs = $o_categoria->selecionar();

		if($rs)
		{
			if($tipo == "drop")
			{
				$menu .= "<select name=\"produto_id_categoria_sup\" id=\"produto_id_categoria_sup\">";
				$menu .= "<option value=\"0\">Escolha um departamento</option>";
			}
			else
			{
				$menu .= "<ul class=\"\">";
			}

			$x = 1;
			foreach($rs as $linha)
			{
				if($quero == $linha['id'])
				{
					$selected = " selected ";
				}
				else
				{
					$selected = "";
				}
				
				if($x >= $num_linhas){$separador = "";}else{$separador = " | ";}

				
				if($tipo == "drop")
				{
					$menu .= "<option ".$selected." value=\"".$linha['id']."\">".$linha['nome']."</option>";
				}
				else
				{	
					if ($linha['chamada_categoria'] == $_REQUEST['acao'])
					{
						$class = "active";
					}
					else
					{
						$class = "";
					}
				
					$data_option_value = $o_ajudante->trata_texto_01($linha['nome']);			
					
					$class_menu = "class=\"menu_produto_ajax\"";
					if($this->home)
					{
						$menu .= "<li >".$primeiro_li."<a class=\"filtro_menu\" href=\"#\" data-option-value=\"".$data_option_value."\" >".strtoupper($linha['nome'])."</a></li>";
					}
					else
					{
						$menu .= "<li >".$primeiro_li."<a class=\"filtro_menu ".$class."\" href=\"".$url_virtual."materia/".$linha['chamada_categoria']."\" data-option-value=\"".$data_option_value."\" >".strtoupper($linha['nome'])."</a></li>";
					}
				}
			$x ++;
			}

			if($tipo == "drop")
			{
				$menu .= "</select>";
			}
			else
			{
				$menu .= "</ul>";
			}
		}
		else
		{
		$menu .= "sem produtos";
		}
	
		return $menu;
		unset($o_ajudante);
	}
	
	function menu_produto_02()
	{
		$o_configuracao = new Configuracao;
		
		$url_virtual = $o_configuracao->url_virtual();
		
		$o_categoria = new Categoria;
		$o_categoria->set('ordenador', 'ordem');
		$o_categoria->set('criterio_sql', ' id NOT IN (17,24)');// NOT IN LOOKBOOK AND MATERIA
		$o_categoria->set('estado', 'a');
		
		$pai = array();
		$filho = array();

		if($rs = $o_categoria->selecionar())
		{
			foreach($rs as $linha)
			{
				if ($linha['pai_id'] == 0)
				{
					//array_push($pai,$linha["nome"] . "|" . $linha["id"] . "|" . $linha["pai_id"]);
					array_push($pai,$linha["nome"] . "|" . $linha["id"] . "|" . $linha["pai_id"]. "|" . $linha["chamada_categoria"]. "|" . $linha["chamada_categoria_pai"]);
				}
				else
				{
					//array_push($filho,$linha["nome"] . "|" . $linha["id"] . "|" . $linha["pai_id"]);
					array_push($filho,$linha["nome"] . "|" . $linha["id"] . "|" . $linha["pai_id"]. "|" . $linha["chamada_categoria"]. "|" . $linha["chamada_categoria_pai"]);
				}	
			}
		}
		else
		{
			$menu .= "sem categorias";
		}
		$menu .= "<dl>";
		for ($x = 0; $x < count($pai); $x++)
		{
			$pai_itens = explode("|",$pai[$x]);
			
			//$menu .= "<dt><a href=\"".$url_virtual."produto.php?pai_id=".$pai_itens[1]."\">".$pai_itens[0]."</a></dt>";
			$menu .= "<dt><a href=\"".$url_virtual."produto/".$pai_itens[3]."\">".$pai_itens[0]."</a></dt>";
			$menu .= "<dd ";
			//if($this->select_pai != "" && $this->select_pai == $pai_itens[1])
			if(trim($_REQUEST['pai_id']) != "" && $_REQUEST['pai_id'] == $pai_itens[3])
			{
				$menu .= " class=\"select\"";
			}
			$menu .= " ><ul>";

			for ($z = 0; $z < count($filho); $z++)
			{
				$filho_itens = explode("|",$filho[$z]);
				
				//if ($pai_itens[1] == $filho_itens[2])
				if ($pai_itens[3] == $filho_itens[4])
                {
					//if($filho_itens[1] == $_REQUEST['_categoria_id'])
					if($filho_itens[3] == $_REQUEST['_categoria_id'])
					{
						$class = "class=\"active\"";
					}
					else
					{
						$class = "";
					}
					//$menu .= "<li ".$class."><a href=\"".$url_virtual."produto.php?_categoria_id=" . $filho_itens[1] . "&pai_id=" . $pai_itens[1] . "\">" . $filho_itens[0] . "</a></li>";
					$menu .= "<li ".$class."><a href=\"".$url_virtual."produto/".$pai_itens[3]."/".$filho_itens[3]."\">" . $filho_itens[0] . "</a></li>";
				}
			}
			$menu .= "</ul></dd>";
			
			//$menu .= "	<hr>\n";
		}
		$menu .= " </dl>";
		return $menu;
	}

}

?>