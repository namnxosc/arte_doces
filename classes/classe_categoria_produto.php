<?php

class Categoria_produto extends Executa
{
	private $id;
	private $id_produto;
	private $id_categoria;
	private $estado;
	
	private $limite;
	private $ordenador;
	private $termo_busca;
	
	private $busca;			
	private $q;			
	private $prefixo;
	private $not_in;
	
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
		,id_produto 
		,id_categoria
		";
		
		$q .= "FROM ".$this->prefixo."_tbl_categoria_produto
		WHERE 
		1=1  
		";
		
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->id_produto) ? "AND id_produto = '".$this->id_produto."' " : " ";
		$q .= !empty($this->id_categoria) ? "AND id_categoria = '".$this->id_categoria."' " : " ";
 		
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
	
	public function selecionar_categoria_produto()
	{		
		$q = "
		
		SELECT 
		id
		, nome
		,(
			SELECT ".$this->prefixo."_tbl_categoria_produto.id
			FROM ".$this->prefixo."_tbl_categoria_produto
			WHERE id_produto = ".$this->id_produto."
			AND ".$this->prefixo."_tbl_categoria_produto.id_categoria = ".$this->prefixo."_tbl_categoria.id  LIMIT 0,1
		) AS tem_alguma 

		FROM ".$this->prefixo."_tbl_categoria
		WHERE 
		1=1 
		";
		//die($q);
		//$q .= !empty($this->ver) ? "AND ver = '".$this->ver."' " : " ";
 		$q .= !empty($this->estado) ? "AND estado = '".$this->estado."' " : " ";
 		$q .= !empty($this->not_in) ? "AND id NOT IN (".$this->not_in.") " : " ";
		
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY ".$this->prefixo."_tbl_categoria.id DESC ";
		
		$this->sql = $q;
		$stmt = $this->executar();
		//die($q);
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
	
	//seleciona os dados do assunto
	public function selecionar_categoria_produto_02()
	{
		$q = "
		SELECT
		".$this->prefixo."_tbl_categoria_produto.id 
		,".$this->prefixo."_tbl_categoria_produto.id_produto 
		,".$this->prefixo."_tbl_categoria_produto.id_categoria 
		
		,".$this->prefixo."_tbl_categoria.nome 
		,".$this->prefixo."_tbl_categoria.estado
		,".$this->prefixo."_tbl_categoria.ordem
		
		";

		$q .= "FROM ".$this->prefixo."_tbl_categoria_produto 

		INNER JOIN ".$this->prefixo."_tbl_categoria
		ON ".$this->prefixo."_tbl_categoria_produto.id_categoria = ".$this->prefixo."_tbl_categoria.id

		WHERE 
		1=1  
		";

		$q .= !empty($this->id) ? "AND ".$this->prefixo."_tbl_categoria_produto.id = '".$this->id."' " : " ";
		$q .= !empty($this->id_produto) ? "AND ".$this->prefixo."_tbl_categoria_produto.id_produto = '".$this->id_produto."' " : " ";
		$q .= !empty($this->id_categoria) ? "AND ".$this->prefixo."_tbl_categoria_produto.id_categoria = '".$this->id_categoria."' " : " ";

		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador." ".$this->DESC_ASC."" : " ORDER BY id DESC ";
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
	
	public function selecionar_categoria_produto_produto()
	{
		$q = "
		SELECT
		".$this->prefixo."_tbl_categoria_produto.id 
		,".$this->prefixo."_tbl_categoria_produto.id_produto 
		,".$this->prefixo."_tbl_categoria_produto.id_categoria 
		
		,".$this->prefixo."_tbl_produto.id as id_produto 
		,".$this->prefixo."_tbl_produto.nome 
		,".$this->prefixo."_tbl_produto.estado
		,".$this->prefixo."_tbl_produto.id_album
		,".$this->prefixo."_tbl_produto.id_album_02
		,".$this->prefixo."_tbl_produto.ordem
		";

		$q .= "FROM ".$this->prefixo."_tbl_categoria_produto 

		INNER JOIN ".$this->prefixo."_tbl_produto
		ON ".$this->prefixo."_tbl_categoria_produto.id_produto = ".$this->prefixo."_tbl_produto.id

		WHERE 
		1=1  
		";

		$q .= !empty($this->id) ? "AND ".$this->prefixo."_tbl_categoria_produto.id = '".$this->id."' " : " ";
		$q .= !empty($this->id_produto) ? "AND ".$this->prefixo."_tbl_categoria_produto.id_produto = '".$this->id_produto."' " : " ";
		$q .= !empty($this->id_categoria) ? "AND ".$this->prefixo."_tbl_categoria_produto.id_categoria = '".$this->id_categoria."' " : " ";
		
		$q .= !empty($this->estado) ? "AND ".$this->prefixo."_tbl_produto.estado = '".$this->estado."' " : " ";

		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador." ".$this->DESC_ASC."" : " ORDER BY id DESC ";
		$q .= !empty($this->limite) ? " LIMIT 0, ".$this->limite." " : " ";

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
	
	public function inserir()
	{
		$q = "
		
		INSERT INTO ".$this->prefixo."_tbl_categoria_produto
		(
		
		id_produto,
		id_categoria
		)
		VALUES 
		(
		
		'".$this->id_produto."'
		,'".$this->id_categoria."'
		)";
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
	
	public function editar()
	{
		$q = "
		
		UPDATE ".$this->prefixo."_tbl_categoria_produto SET 
		
		id_produto = '".$this->id_produto."'
		,id_categoria = '".$this->id_categoria."'
		
		WHERE id='".$this->id."'
		
		";
		
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
	
	public function excluir()
	{
		$q = "				

		DELETE FROM ".$this->prefixo."_tbl_categoria_produto WHERE id_produto='".$this->id_produto."'";
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

	
	public function ultimo_id()
	{
		$q = "
		
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_categoria_produto ORDER BY id DESC LIMIT 1
		
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