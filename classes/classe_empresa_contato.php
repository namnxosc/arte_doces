<?php
class Empresa_contato extends Executa
{
	private $id;
	private $id_empresa; 
	private $ddd; 
	private $numero;
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
		,id_empresa 
		,ddd
		,numero
		,tipo
		";

		$q .= "FROM ".$this->prefixo."_tbl_empresa_contato
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND numero LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->id_empresa) ? "AND id_empresa = '".$this->id_empresa."' " : " ";

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
	
	public function selecionar_2()
	{
		$q = "
		SELECT
		id 
		,id_empresa 
		,ddd
		,numero
		,tipo
		";

		$q .= "FROM ".$this->prefixo."_tbl_empresa_contato
		WHERE 
		id_empresa = '".$this->id_empresa."'
		";

		$q .= !empty($this->termo_busca) ? "AND numero LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";

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
		INSERT INTO ".$this->prefixo."_tbl_empresa_contato
		(
		id_empresa 
		,ddd
		,numero
		,tipo
		)
		VALUES 
		(
		'".$this->id_empresa."',
		'".$this->ddd."',
		'".$this->numero."',
		'".$this->tipo."'
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
		UPDATE ".$this->prefixo."_tbl_empresa_contato SET 
		id_empresa = '".$this->id_empresa."', 
		ddd = '".$this->ddd."', 
		numero = '".$this->numero."',
		tipo = '".$this->tipo."'

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
		DELETE FROM ".$this->prefixo."_tbl_empresa_contato WHERE id='".$this->id."'";

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
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_empresa_contato ORDER BY id DESC LIMIT 1
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