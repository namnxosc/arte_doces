<?php

class Menu_site extends Executa
{
	private $id;	
	private $nome;	
	private $ordem;	
	private $pagina_interna;	
	private $id_pagina;
	private $tipo_link;	
	private $url;
	private $funcao_popup;
	private $estado;
	private $id_menu_ambiente;
	private $id_album;
	private $tipo;

	private $limite;
	private $ordenador;
	private $termo_busca;

	private $busca;
	private $q;
	private $prefixo;

	function __construct()
	{
		parent::__construct();
		$this->prefixo = $this->prefixo();
	}

	function __destruct()
	{
	}

	public function selecionar()
	{
		$q = "
		SELECT 
		id
		,nome
		,ordem
		,pagina_interna
		,id_pagina
		,tipo_link
		,url
		,funcao_popup
		,estado
		,id_menu_ambiente
		,(SELECT m.nome FROM ".$this->prefixo."_tbl_menu_ambiente m WHERE m.id = ".$this->prefixo."_tbl_menu.id_menu_ambiente limit 0, 1) as nome_menu_ambiente
		,id_album
		,tipo
		,(SELECT p.nome FROM ".$this->prefixo."_tbl_pagina p WHERE p.id = ".$this->prefixo."_tbl_menu.id_pagina limit 0, 1) as nome_pagina
		";

		$q .= "FROM ".$this->prefixo."_tbl_menu 
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->url) ? "AND url = '".$this->url."' " : " ";
		$q .= !empty($this->id_pagina) ? "AND id_pagina = '".$this->id_pagina."' " : " ";
		$q .= !empty($this->estado) ? "AND estado = '".$this->estado."' " : " ";
		$q .= !empty($this->id_menu_ambiente) ? "AND id_menu_ambiente = '".$this->id_menu_ambiente."' " : " ";
		$q .= !empty($this->id_album) ? "AND id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->tipo) ? "AND tipo = '".$this->tipo."' " : " ";
		$q .= !empty($this->pagina_interna) ? "AND pagina_interna = '".$this->pagina_interna."' " : " ";
		$q .= !empty($this->tipo_link) ? "AND tipo_link = '".$this->tipo_link."' " : " ";

		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY id DESC ";
		$q .= !empty($this->limite) ? " LIMIT 0, ".$this->limite." " : " ";
//die($q);
		//Envia a string de consulta
		$this->sql = $q;
		$stmt = $this->executar();

		//verifica se houve um retorno maior que 0
		if($stmt->rowCount() > 0)
		{
			return $stmt;
		}
		else
		{
			return false;
		}
	}

	public function inserir()
	{
		$q = "
		INSERT INTO ".$this->prefixo."_tbl_menu 
		(
		nome,
		ordem,
		pagina_interna,
		id_pagina,
		tipo_link,
		url,
		funcao_popup,
		estado,
		id_menu_ambiente,
		id_album,
		tipo
		)
		VALUES 
		(
		'".$this->nome."'
		,'".$this->ordem."'
		,'".$this->pagina_interna."'
		,'".$this->id_pagina."'
		,'".$this->tipo_link."'
		,'".$this->url."'
		,'".$this->funcao_popup."'
		,'".$this->estado."'
		,'".$this->id_menu_ambiente."'
		,'".$this->id_album."'
		,'".$this->tipo."'
		)";

		//Envia a string de consulta
		$this->sql = $q;
		$stmt = $this->executar();

		//verifica se houve um retorno maior que 0
		if($stmt->rowCount() > 0)
		{
			return $stmt;
		}
		else
		{
			return false;
		}
	}

	public function editar()
	{
		$q = "
		UPDATE ".$this->prefixo."_tbl_menu SET 
		nome = '".$this->nome."'
		,ordem = '".$this->ordem."'
		,pagina_interna = '".$this->pagina_interna."'
		,id_pagina = '".$this->id_pagina."'		
		,tipo_link = '".$this->tipo_link."'
		,url = '".$this->url."'		
		,funcao_popup = '".$this->funcao_popup."'
		,estado = '".$this->estado."'
		,id_menu_ambiente = '".$this->id_menu_ambiente."'
		,id_album = '".$this->id_album."'
		,tipo = '".$this->tipo."'
		
		
		WHERE id='".$this->id."'
		";

		//Envia a string de consulta
		$this->sql = $q;
		$stmt = $this->executar();

		//verifica se houve um retorno maior que 0
		if($stmt->rowCount() > 0)
		{
			return $stmt;
		}
		else
		{
			return false;
		}
	}

	public function excluir()
	{
		$q = "
		DELETE FROM ".$this->prefixo."_tbl_menu WHERE id='".$this->id."'";

		//Envia a string de consulta
		$this->sql = $q;
		$stmt = $this->executar();

		//verifica se houve um retorno maior que 0
		if($stmt->rowCount() > 0)
		{
			return $stmt;
		}
		else
		{
			return false;
		}
	}

	public function ultimo_id()
	{
		$q = "
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_menu ORDER BY id DESC LIMIT 1
		";

		//Envia a string de consulta
		$this->sql = $q;
		$stmt = $this->executar();

		//verifica se houve um retorno maior que 0
		if($stmt->rowCount() > 0)
		{
			return $stmt;
		}
		else
		{
			return false;
		}
	}

	function set($prop, $value)
	{
		$this->$prop = $value;
	}
}
?>