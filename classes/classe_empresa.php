<?php
class Empresa extends Executa
{
	private $id;
	private $titulo; 
	private $email; 
	private $endereco;
	private $numero;
	private $uf;
	private $cidade;
	private $id_empresa;
	private $ddd;
	private $tipo;
	private $estado;
	private $cep;
	private $mapa;

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
		,titulo 
		,email
		,endereco
		,numero
		,uf
		,cidade
		,estado
		,cep
		,mapa
		";

		$q .= "FROM ".$this->prefixo."_tbl_empresa
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND titulo LIKE '%".$this->termo_busca."%' " : " ";;
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->estado) ? "AND estado = '".$this->estado."' " : " ";

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
		INSERT INTO ".$this->prefixo."_tbl_empresa
		(
		titulo 
		,email
		,endereco
		,numero
		,uf
		,cidade
		,estado
		,cep
		,mapa
		)
		VALUES 
		(
		'".$this->titulo."',
		'".$this->email."',
		'".$this->endereco."',
		'".$this->numero."',
		'".$this->uf."',
		'".$this->cidade."',
		'".$this->estado."',
		'".$this->cep."',
		'".$this->mapa."'
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
		UPDATE ".$this->prefixo."_tbl_empresa SET 
		titulo = '".$this->titulo."', 
		email = '".$this->email."', 
		endereco = '".$this->endereco."',
		numero = '".$this->numero."',
		uf = '".$this->uf."',
		cidade = '".$this->cidade."',
		estado = '".$this->estado."',
		cep = '".$this->cep."',
		mapa = '".$this->mapa."'

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
		DELETE FROM ".$this->prefixo."_tbl_empresa WHERE id='".$this->id."'";

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
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_empresa ORDER BY id DESC LIMIT 1
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