<?php
class Produto_materia extends Executa
{
	private $id;
	private $nome; 
	private $corpo;
	private $id_album;
	private $id_produto;
	private $criterio;
	
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
		,corpo
		,id_album
		,(SELECT a.nome FROM  ".$this->prefixo."_tbl_album a
			WHERE ".$this->prefixo."_tbl_produto_materia.id_album = a.id limit 0,1) AS nome_album
		,id_produto
		";
		
		$q .= "FROM ".$this->prefixo."_tbl_produto_materia 
		WHERE 
		1=1  
		";
		
		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->corpo) ? "AND corpo = '".$this->corpo."' " : " ";
		$q .= !empty($this->id_album) ? "AND id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->id_produto) ? "AND id_produto = '".$this->id_produto."' " : " ";
		$q .= !empty($this->criterio) ? "AND ".$this->criterio." " : " ";
 		
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY id DESC ";
		
		$q .= !empty($this->limite) ? " LIMIT 0, ".$this->limite." " : " ";
		
		$this->sql = $q;
		$stmt = $this->executar();
		//echo ($q);

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
		
		INSERT INTO ".$this->prefixo."_tbl_produto_materia
		(
		
		nome,
		corpo,
		id_album,
		id_produto
		
		)
		VALUES 
		(
		
		'".$this->nome."',
		'".$this->corpo."',
		'".$this->id_album."',
		'".$this->id_produto."'
		
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
		
		UPDATE ".$this->prefixo."_tbl_produto_materia SET 
		
		nome = '".$this->nome."', 
		corpo = '".$this->corpo."' ";
		
		$q .= !empty($this->id_produto) ? " ,id_produto = '".$this->id_produto."' " : " ";
		
		$q .= "
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

		DELETE FROM ".$this->prefixo."_tbl_produto_materia WHERE id='".$this->id."'";
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
		
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_produto_materia ORDER BY id DESC LIMIT 1
		
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