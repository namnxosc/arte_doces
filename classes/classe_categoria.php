<?php
class Categoria extends Executa
{
	private $id;
	private $nome; 
	private $descricao; 
	private $estado;
	private $data_hora;
	private $ordem;
	private $pai_id;
	private $not_in;
	private $chamada_categoria;
	private $criterio_sql;

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
		,descricao
		,estado
		,data_hora
		,ordem
		,chamada_categoria
		";

		$q .= "FROM ".$this->prefixo."_tbl_categoria 
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->descricao) ? "AND descricao = '".$this->descricao."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->estado) ? "AND estado = '".$this->estado."' " : " ";
		$q .= !empty($this->data_hora) ? "AND data_hora = '".$this->data_hora."' " : " ";
		$q .= !empty($this->ordem) ? "AND ordem = '".$this->ordem."' " : " ";
		$q .= !empty($this->chamada_categoria) ? "AND chamada_categoria = '".$this->chamada_categoria."' " : " ";
		$q .= !empty($this->criterio_sql) ? " AND ".$this->criterio_sql." " : " ";
		
		$q .= !empty($this->not_in) ? "AND id NOT IN (".$this->not_in.") " : " ";

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
		INSERT INTO ".$this->prefixo."_tbl_categoria
		(
		nome,
		descricao,
		estado,
		data_hora,
		ordem,
		chamada_categoria
		)
		VALUES 
		(
		'".$this->nome."',
		'".$this->descricao."',
		'".$this->estado."',
		'".$this->data_hora."',
		'".$this->ordem."',
		'".$this->chamada_categoria."'
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
		UPDATE ".$this->prefixo."_tbl_categoria SET 
		nome = '".$this->nome."', 
		descricao = '".$this->descricao."', 
		estado = '".$this->estado."',
		ordem = '".$this->ordem."',
		chamada_categoria = '".$this->chamada_categoria."'

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
		DELETE FROM ".$this->prefixo."_tbl_categoria WHERE id='".$this->id."'";

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
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_categoria ORDER BY id DESC LIMIT 1
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