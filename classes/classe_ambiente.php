<?php


class Ambiente extends Executa
{
	private $id;
	private $nome; 
	private $url;
	private $tipo_menu;
	private $botao;
	private $pai_id;
	private $ver;
	private $ordem;
	
	private $ids;
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
		,url
		,tipo_menu
		,botao
		,pai_id
		,ver
		,ordem
		";
		
		$q .= "FROM ".$this->prefixo."_tbl_ambiente
		WHERE 
		1=1  
		";
		
		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->url) ? "AND url = '".$this->url."' " : " ";
		$q .= !empty($this->tipo_menu) ? "AND tipo_menu = '".$this->tipo_menu."' " : " ";
		$q .= !empty($this->botao) ? "AND botao = '".$this->botao."' " : " ";
		$q .= !empty($this->pai_id) ? "AND pai_id = '".$this->pai_id."' " : " ";
		$q .= !empty($this->ver) ? "AND ver = '".$this->ver."' " : " ";
 		
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY id DESC ";
		
		$q .= !empty($this->limite) ? " LIMIT 0, ".$this->limite." " : " ";
		
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
	
	public function selecionar_permissao()
	{
		$q = "
		
		SELECT id,nome,ver,
		(
		
		SELECT ambiente_id
		FROM ".$this->prefixo."_tbl_permissao
		WHERE usuario_id = ".$_REQUEST["_usuario_id"]."
		AND ambiente_id = ".$this->prefixo."_tbl_ambiente.id
		
		) AS tem_alguma
		FROM ".$this->prefixo."_tbl_ambiente
		ORDER BY 'nome' ASC
 
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
	
	
	public function selecionar_menu()
	{
		$q = "				

		SELECT 
		ordem,
		ver,
		pai_id,
		url,
		id,
		nome,
		tipo_menu,
		botao 
		FROM ".$this->prefixo."_tbl_ambiente 
		WHERE id IN(".$this->ids.") ";
		$q .= !empty($this->ver) ? "AND ver = '".$this->ver."' " : " ";
		$q .= !empty($this->ordenador) ? " ORDER BY ".$this->ordenador."" : " ORDER BY nome ";

		$this->sql = $q;
		$stmt = $this->executar();
		//DIE($q);
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
		
		INSERT INTO ".$this->prefixo."_tbl_ambiente
		(
		
		nome,
		url,
		tipo_menu,
		botao,
		pai_id,
		ver,
		ordem
		
		)
		VALUES 
		(
		
		'".$this->nome."'
		,'".$this->url."'
		,'".$this->tipo_menu."'
		,'".$this->botao."'
		,'".$this->pai_id."'
		,'".$this->ver."'
		,'".$this->ordem."'
		
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
		
		UPDATE ".$this->prefixo."_tbl_ambiente SET 
		
		nome = '".$this->nome."'
		,url = '".$this->url."'
		,tipo_menu = '".$this->tipo_menu."'
		,botao = '".$this->botao."'
		,pai_id = '".$this->pai_id."'
		,ver = '".$this->ver."'
		,ordem = '".$this->ordem."'
		
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

		DELETE FROM ".$this->prefixo."_tbl_ambiente WHERE id='".$this->id."'";
		
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
		
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_ambiente ORDER BY id DESC LIMIT 1
		
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


	public function selecionar_parente()
	{
		$q = "				

		SELECT
		id as id_parente
		,nome 
		,url
		,tipo_menu
		,botao
		,pai_id
		,ver 
		FROM ".$this->prefixo."_tbl_ambiente 
		WHERE pai_id = '".$this->id."'
		";

		
		//Envia a string de consulta
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

}
?>