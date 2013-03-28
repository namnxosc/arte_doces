<?php
class Arquivo extends Executa
{
	private $id;
	private $nome; 
	private $data;
	private $quantidade;
	private $id_projeto;

	private $limite;
	private $ordenador;
	private $termo_busca;
	private $termo_busca_alfabetica;

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
		id,
		nome,
		DATE_FORMAT(data,'%d/%m/%Y %H:%i:%s') AS data,
		quantidade,
		id_projeto
		";

		$q .= "FROM ".$this->prefixo."_tbl_arquivo
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->termo_busca_alfabetica) ? "AND nome LIKE '".$this->termo_busca_alfabetica."%' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->data) ? "AND data = '".$this->data."' " : " ";
		$q .= !empty($this->quantidade) ? "AND quantidade = '".$this->quantidade."' " : " ";
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
		".$this->prefixo."_tbl_arquivo.id,
		".$this->prefixo."_tbl_arquivo.nome,
		DATE_FORMAT(".$this->prefixo."_tbl_arquivo.data,'%d/%m/%Y %H:%i:%s') AS data,
		".$this->prefixo."_tbl_arquivo.id_projeto,
		".$this->prefixo."_tbl_arquivo.quantidade,
		".$this->prefixo."_tbl_projeto.nome AS nome_projeto
		";

		$q .= "FROM ".$this->prefixo."_tbl_arquivo 

		INNER JOIN ".$this->prefixo."_tbl_projeto
		ON ".$this->prefixo."_tbl_arquivo.id_projeto = ".$this->prefixo."_tbl_projeto.id

		WHERE 
		1=1 
		";

		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->termo_busca_alfabetica) ? "AND nome LIKE '".$this->termo_busca_alfabetica."%' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->data) ? "AND data= '".$this->data."' " : " ";
		$q .= !empty($this->quantidade) ? "AND quantidade= '".$this->quantidade."' " : " ";
		$q .= !empty($this->id_projeto) ? "AND id_projeto= '".$this->id_projeto."' " : " ";

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
		INSERT INTO ".$this->prefixo."_tbl_arquivo
		(
		nome,
		data,
		quantidade,
		id_projeto
		) 
		VALUES 
		(
		'".$this->nome."',
		'".$this->data."',
		'".$this->quantidade."',
		'".$this->id_projeto."'
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
		UPDATE ".$this->prefixo."_tbl_arquivo SET

		nome = '".$this->nome."'
		,data = '".$this->data."'
		,quantidade = '".$this->quantidade."'
		,id_projeto = '".$this->id_projeto."'

		WHERE id='".$this->id."'
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

	public function excluir()
	{
		$q = "
		DELETE FROM ".$this->prefixo."_tbl_arquivo WHERE id='".$this->id."'";

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
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_arquivo ORDER BY id DESC LIMIT 1
		";

		//Envia a string de consulta
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