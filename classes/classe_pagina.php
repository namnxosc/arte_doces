<?php

class Pagina extends Executa
{
	private $id;
	private $id_album; 
	private $idioma; 
	private $nome; 
	private $estado;
	private $corpo;
	private $formatacao;
	private $destaque;
	private $olho;
	private $data;
	private $chamado;
	private $curtir_face;
	private $curtir_pinit;
	private $google_maps;

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
	
	public function selecionar()
	{
		$q = "

		SELECT
		".$this->prefixo."_tbl_pagina.id 
		,".$this->prefixo."_tbl_pagina.id_album 
		,".$this->prefixo."_tbl_pagina.idioma 
		,".$this->prefixo."_tbl_pagina.ordem 
		,".$this->prefixo."_tbl_pagina.nome 
		,".$this->prefixo."_tbl_pagina.estado
		,".$this->prefixo."_tbl_pagina.corpo
		,".$this->prefixo."_tbl_pagina.formatacao
		,".$this->prefixo."_tbl_pagina.olho
		,".$this->prefixo."_tbl_pagina.destaque
		,".$this->prefixo."_tbl_pagina.chamado
		,".$this->prefixo."_tbl_pagina.curtir_face
		,".$this->prefixo."_tbl_pagina.curtir_pinit
		,".$this->prefixo."_tbl_pagina.google_maps
		";

		$q .= !empty($this->busca) ? ",(SELECT id FROM ".$this->prefixo."_tbl_linkador WHERE link_id = concat('index.php?acao=paginas&pagina_id=',".$this->prefixo."_tbl_pagina.id) limit 0, 1) as n_id" : " ";
		$q .= !empty($this->busca) ? ",(SELECT nome FROM ".$this->prefixo."_tbl_linkador WHERE link_id = concat('index.php?acao=paginas&pagina_id=',".$this->prefixo."_tbl_pagina.id) limit 0, 1) as n_nome" : " ";
		$q .= !empty($this->busca) ? ",(SELECT id FROM ".$this->prefixo."_tbl_botao where id = n_id  limit 0, 1 )as b_id" : " ";
		
		$q .= !empty($this->busca) ? ",(SELECT id FROM ".$this->prefixo."_tbl_linkador_link WHERE link = 'index.php?acao=paginas&pagina_id='".$this->prefixo."_tbl_pagina.id) limit 0, 1) as link_id" : " ";
		
		$q .= "FROM ".$this->prefixo."_tbl_pagina 
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND (nome LIKE '%".$this->termo_busca."%' OR corpo LIKE '%".$this->termo_busca."%') " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->idioma) ? "AND idioma = '".$this->idioma."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->estado) ? "AND estado = '".$this->estado."' " : " ";
		$q .= !empty($this->destaque) ? "AND destaque = '".$this->destaque."' " : " ";
		$q .= !empty($this->chamado) ? "AND chamado = '".$this->chamado."' " : " ";
 		$q .= !empty($this->corpo) ? "AND corpo = '".$this->corpo."' " : " ";
		$q .= !empty($this->id_album) ? "AND id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->acesso_pag) ? "AND acesso_pag = '".$this->acesso_pag."' " : " ";
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY id DESC ";
		
		$q .= !empty($this->limite) ? " LIMIT 0, ".$this->limite." " : " ";
		//echo $q."<br>";
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
	
	public function selecionar_02()
	{
		$q = "				

		SELECT
		".$this->prefixo."_tbl_pagina.id
		,".$this->prefixo."_tbl_pagina.nome
		,".$this->prefixo."_tbl_pagina.corpo
		,".$this->prefixo."_tbl_pagina.ordem
		,".$this->prefixo."_tbl_pagina.formatacao
		,".$this->prefixo."_tbl_pagina.estado
		,".$this->prefixo."_tbl_pagina.destaque
		,".$this->prefixo."_tbl_pagina.olho
		,".$this->prefixo."_tbl_pagina.idioma
		,".$this->prefixo."_tbl_pagina.id_album
		,".$this->prefixo."_tbl_pagina.chamado
		,".$this->prefixo."_tbl_pagina.curtir_face
		,".$this->prefixo."_tbl_pagina.curtir_pinit
		,".$this->prefixo."_tbl_pagina.google_maps
		";

		$link_tratado = "index.php?acao=paginas&pagina_id=".$this->prefixo."_tbl_pagina.id";
		
		$q .= !empty($this->busca) ?",(SELECT id FROM ".$this->prefixo."_tbl_linkador_link WHERE link =".$link_tratado." limit 0, 1) as link_id" : " ";

		$q .= "FROM ".$this->prefixo."_tbl_pagina 
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND (nome LIKE '%".$this->termo_busca."%' OR corpo LIKE '%".$this->termo_busca."%') " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->corpo) ? "AND corpo = '".$this->corpo."' " : " ";
		$q .= !empty($this->idioma) ? "AND idioma = '".$this->idioma."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->estado) ? "AND estado = '".$this->estado."' " : " ";
		$q .= !empty($this->destaque) ? "AND destaque = '".$this->destaque."' " : " ";
		$q .= !empty($this->link_id) ? "AND link_id = '".$this->link_id."' " : " ";
		$q .= !empty($this->id_album) ? "AND id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->chamado) ? "AND chamado = '".$this->chamado."' " : " ";
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY id DESC ";
		
		$q .= !empty($this->limite) ? " LIMIT 0, ".$this->limite." " : " ";
		
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
	
	public function selecionar_busca()
	{
		
		$q = "
		(
		 SELECT 
		 1 AS s,
		 id,
		 corpo,
		 1 AS outro_id,
		 titulo 
		 FROM ".$this->prefixo."_tbl_noticia 
		 WHERE 
		 (titulo LIKE '%".$this->termo_busca."%' OR 
		 corpo LIKE '%".$this->termo_busca."%')
		 AND estado = 'a'
		 )
		UNION
		(
		 SELECT 
		 2 AS s,
		 id,
		 corpo,
		 (SELECT botao_id FROM ".$this->prefixo."_tbl_linkador WHERE nome = ".$this->prefixo."_tbl_pagina.nome LIMIT 0,1) AS outro_id,
		 nome AS titulo
		 FROM ".$this->prefixo."_tbl_pagina 
		 WHERE 
		 (nome LIKE '%".$this->termo_busca."%' OR 
		 corpo LIKE '%".$this->termo_busca."%')
		 AND estado = 'a'		 
		 )

		";
		
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->corpo) ? "AND corpo = '".$this->corpo."' " : " ";
		$q .= !empty($this->titulo) ? "AND titulo = '".$this->titulo."' " : " ";
		
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador." ".$this->asc_desc." " : " ORDER BY titulo ";
		//$q .= !empty($this->ordenador) ? "ORDER BY nome";
		
		empty($this->limite_inicio) ? $limite_inicio_02 = "0" : $limite_inicio_02 = $this->limite_inicio;
		$q .= !empty($this->limite) ? " LIMIT ".$limite_inicio_02.", ".$this->limite." " : " ";
		//echo $q;
		
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
		
		INSERT INTO ".$this->prefixo."_tbl_pagina
		(
		
		nome,
		corpo,
		data,
		formatacao,
		ordem,
		destaque,
		olho,
		estado,
		idioma,
		id_album,
		curtir_face,
		curtir_pinit,
		google_maps
		
		)
		VALUES 
		(
		
		'".$this->nome."',
		'".$this->corpo."',
		'".$this->data."',
		'".$this->formatacao."',
		'".$this->ordem."',
		'".$this->destaque."',
		'".$this->olho."',
		'".$this->estado."',
		'".$this->idioma."',
		'".$this->id_album."',
		'".$this->curtir_face."',
		'".$this->curtir_pinit."',
		'".$this->google_maps."'
		)";

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
		
		UPDATE ".$this->prefixo."_tbl_pagina SET 
		
		nome = '".$this->nome."', 
		corpo = '".$this->corpo."', 
		formatacao = '".$this->formatacao."', 
		ordem = '".$this->ordem."', 
		destaque = '".$this->destaque."',
		olho = '".$this->olho."',
		idioma = '".$this->idioma."',
		estado = '".$this->estado."',
		id_album = '".$this->id_album."',
		data = '".$this->data."',
		curtir_face = '".$this->curtir_face."',
		curtir_pinit = '".$this->curtir_pinit."',
		google_maps = '".$this->google_maps."'

		WHERE id='".$this->id."'
		
		";
		//die($q);
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
	
	public function editar_chamado()
	{
		$q = "
		
		UPDATE ".$this->prefixo."_tbl_pagina SET 
		
		chamado = '".$this->chamado."'
		
		WHERE id='".$this->id."'
		
		";
		//die($q);
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

		DELETE FROM ".$this->prefixo."_tbl_pagina WHERE id='".$this->id."'";
		
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
		
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_pagina ORDER BY id DESC LIMIT 1
		
		";

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