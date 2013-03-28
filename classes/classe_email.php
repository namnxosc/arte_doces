<?php
class Email extends Executa
{
	private $id;
	private $nome; 
	private $email;
	private $data;
	private $tipo;
	private $id_projeto;

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
		,email
		,DATE_FORMAT(data,'%d/%m/%Y %H:%i:%s') AS data
		,tipo
		,id_projeto
		,(SELECT nome FROM ".$this->prefixo."_tbl_projeto WHERE id = ".$this->prefixo."_tbl_email.id_projeto) AS nome_projeto 
		";

		$q .= "FROM ".$this->prefixo."_tbl_email 

		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->email) ? "AND email = '".$this->email."' " : " ";
		$q .= !empty($this->data) ? "AND data = '".$this->data."' " : " ";
		$q .= !empty($this->tipo) ? "AND tipo = '".$this->tipo."' " : " ";
		$q .= !empty($this->id_projeto) ? "AND id_projeto = '".$this->id_projeto."' " : " ";

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

	public function selecionar_02()
	{
		$q = "
		SELECT 
		".$this->prefixo."_tbl_email.id,
		".$this->prefixo."_tbl_email.nome,
		".$this->prefixo."_tbl_email.email,
		DATE_FORMAT(".$this->prefixo."_tbl_projeto.data,'%d/%m/%Y %H:%i:%s') AS data,
		".$this->prefixo."_tbl_email.tipo,
		".$this->prefixo."_tbl_email.id_projeto,
		".$this->prefixo."_tbl_projeto.nome as nome_projeto,
		".$this->prefixo."_tbl_projeto.url
		";

		$q .= " FROM ".$this->prefixo."_tbl_email 

		INNER JOIN ".$this->prefixo."_tbl_projeto 
		ON ".$this->prefixo."_tbl_email.id_projeto = ".$this->prefixo."_tbl_projeto.id 

		WHERE 
		1=1  
		"; 

		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->email) ? "AND email = '".$this->email."' " : " ";
		$q .= !empty($this->data) ? "AND data= '".$this->data."' " : " ";
		$q .= !empty($this->tipo) ? "AND tipo = '".$this->tipo."' " : " ";
		$q .= !empty($this->id_projeto) ? "AND id_projeto = '".$this->id_projeto."' " : " ";

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

	public function inserir()
	{
		$q = "
		INSERT INTO ".$this->prefixo."_tbl_email
		(
		nome 
		,email
		,data
		,tipo
		,id_projeto
		)

		VALUES 
		(
		'".ucwords($this->nome)."',
		'".$this->email."',
		'".$this->data."',
		'".$this->tipo."',
		'".$this->id_projeto."'
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
		UPDATE ".$this->prefixo."_tbl_email SET 

		nome = '".ucwords($this->nome)."', 
		email = '".$this->email."',
		tipo = '".$this->tipo."',
		id_projeto = '".$this->id_projeto."'

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
		$q = "DELETE FROM ".$this->prefixo."_tbl_email WHERE id='".$this->id."'";

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
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_email ORDER BY id DESC LIMIT 1
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