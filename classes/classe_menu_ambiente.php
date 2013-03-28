<?php
class Menu_ambiente extends Executa
{
	private $id;
	private $nome; 
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
		";
		
		$q .= "FROM ".$this->prefixo."_tbl_menu_ambiente 
		WHERE 
		1=1  
		";
		
		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->criterio) ? "AND ".$this->criterio." " : " ";
 		
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
	
	public function inserir()
	{
		$q = "
		
		INSERT INTO ".$this->prefixo."_tbl_menu_ambiente
		(
		
		nome
		
		)
		VALUES 
		(
		
		'".$this->nome."'
		
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
		
		UPDATE ".$this->prefixo."_tbl_menu_ambiente SET 
		
		nome = '".$this->nome."'
		
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

	//Edita o nome ou o estado, só um deles
	public function editar_nome()
	{
		$q = "
		
		UPDATE ".$this->prefixo."_tbl_menu_ambiente SET ";
		
		$q .= !empty($this->nome) ? " nome = '".$this->nome."' " : " ";
		
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

		DELETE FROM ".$this->prefixo."_tbl_menu_ambiente WHERE id='".$this->id."'";
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
		
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_menu_ambiente ORDER BY id DESC LIMIT 1
		
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