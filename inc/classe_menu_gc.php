<?php
class Menu_gc
{
	private $paramentro;

	function __constructor()
	{
		//
	}

	function set($prop, $value)
	{
		$this->$prop = $value;
	}

	function menu_gestor()
	{
		$o_ambiente = new Ambiente;
		$o_ambiente->set('ver', "s");
		$o_ambiente->set('ordenador', " ordem ASC");
		for($i = 0; $i < count($_SESSION['grupo_ambientes']); $i++)
		{
			$ids .= $_SESSION['grupo_ambientes'][$i].",";
		}

		//tira ultima virgula
		$ids = substr($ids,0, -1);

		$o_ambiente->set('ids',$ids);
		$rs = $o_ambiente->selecionar_menu();

		$menu_pai = array();
		$menu_filho = array();
		$menu_neto = array();
		if($rs)
		{
			foreach($rs as $linha)
			{
				//inicia variável de ids de ambientes e diz quantas posições vai ter de acordo com a quantidade de linhas
				switch($linha['tipo_menu'])
				{
					case "p":
						array_push($menu_pai,$linha["url"] . "|" . $linha["botao"] . "|" . $linha["pai_id"] . "|" . $linha["id"]);
					break;

					case "f":
						array_push($menu_filho,$linha["url"] . "|" . $linha["botao"] . "|" . $linha["pai_id"] . "|" . $linha["id"]);
					break;

					case "n":
						array_push($menu_neto,$linha["url"] . "|" . $linha["botao"] . "|" . $linha["pai_id"] . "|" . $linha["id"]);

					break;

					default:
					break;   
				}
			}
		}

		$menu = "";

		for ($x = 0; $x < count($menu_pai); $x++)
		{
			$menu_pai_itens = explode("|",$menu_pai[$x]);

			$menu .= "<ul class=\"topmenu\">";
			$menu .= "<li><a href=\"" . $menu_pai_itens[0] ."\">" . $menu_pai_itens[1] . " | </a>";
			$menu .= "<ul>\n";

			for ($z = 0; $z < count($menu_filho); $z++)
			{
				$menu_filho_itens = explode("|",$menu_filho[$z]);

				if ($menu_pai_itens[3] == $menu_filho_itens[2])
				{
					$menu .= "   <li class=\"sub\"><a href=\"" . $menu_filho_itens[0] . "\">" . $menu_filho_itens[1] . "</a>\n";
					if(count($menu_neto) > 0)
					{
						$menu .= "<ul>\n";
					}

					for ($y = 0; $y < count($menu_neto); $y++)
					{
						$menu_neto_itens = explode("|", $menu_neto[$y]);
						if ($menu_filho_itens[3] == $menu_neto_itens[2])
						{
							$menu .= "<li><a href=\"" . $menu_neto_itens[0] . "\">" . $menu_neto_itens[1] ."</a></li>\n";
						}
					}

					if(count($menu_neto) > 0)
					{
						$menu .= "</ul>\n";
					}
					$menu .= "   </li>\n";
				}
			}
			$menu .= "</ul></li></ul>\n";
		}
	return $menu;
	}
}
?>