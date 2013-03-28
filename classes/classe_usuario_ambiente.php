<?php

class Usuario_ambiente extends Executa
{
	private $id;
	private $id_usuario_tipo;
	private $id_ambiente;
	
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
		,id_usuario_tipo 
		,id_ambiente
		";
		
		$q .= "FROM ".$this->prefixo."_tbl_usuario_ambiente
		WHERE 
		1=1  
		";
		
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->id_usuario_tipo) ? "AND id_usuario_tipo = '".$this->id_usuario_tipo."' " : " ";
		$q .= !empty($this->id_ambiente) ? "AND id_ambiente = '".$this->id_ambiente."' " : " ";
 		
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
	
	public function selecionar_usuario_ambiente()
	{		
		$q = "
		
		SELECT 
		id,
		nome,
		ver,
		(
		SELECT ".$this->prefixo."_tbl_usuario_ambiente.id
		FROM ".$this->prefixo."_tbl_usuario_ambiente
		WHERE id_usuario_tipo = ".$this->id_usuario_tipo."
		AND ".$this->prefixo."_tbl_usuario_ambiente.id_ambiente = ".$this->prefixo."_tbl_ambiente.id  LIMIT 0,1
		) AS tem_alguma 

		FROM ".$this->prefixo."_tbl_ambiente
		WHERE 
		1=1 
		";
		
		//$q .= !empty($this->ver) ? "AND ver = '".$this->ver."' " : " ";
 		
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY ".$this->prefixo."_tbl_ambiente.id DESC ";
		
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
	
	public function inserir()
	{
		$q = "
		
		INSERT INTO ".$this->prefixo."_tbl_usuario_ambiente
		(
		
		id_usuario_tipo,
		id_ambiente
		)
		VALUES 
		(
		
		'".$this->id_usuario_tipo."'
		,'".$this->id_ambiente."'
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
		
		UPDATE ".$this->prefixo."_tbl_usuario_ambiente SET 
		
		id_usuario_tipo = '".$this->id_usuario_tipo."'
		,id_ambiente = '".$this->id_ambiente."'
		
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

		DELETE FROM ".$this->prefixo."_tbl_usuario_ambiente WHERE id_usuario_tipo='".$this->id_usuario_tipo."'";
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
		
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_usuario_ambiente ORDER BY id DESC LIMIT 1
		
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