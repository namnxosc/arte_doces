<?php
class Produto extends Executa
{
	private $id;
	private $nome; 
	private $corpo;
	private $data;
	private $estado;
	private $ordem;
	private $estilo;
	private $id_album;
	private $id_album_02;
	private $id_album_03;
	private $id_album_04;
	private $criterio;
	private $chamada_produto;
	private $url;

	private $limite;
	private $ordenador;
	private $termo_busca;
	private $in_busca;
	private $not_in;

	private $DESC_ASC;

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
		,estado
		,ordem
		,estilo
		,id_album
		,id_album_02
		,id_album_03
		,id_album_04
		,chamada_produto
		,url
		";

		$q .= "FROM ".$this->prefixo."_tbl_produto 
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' OR corpo LIKE '%".$this->termo_busca."%' OR palavra_chave LIKE '%".$this->termo_busca."%'": " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->in_busca) ? " AND id IN (".$this->in_busca.") " : " ";
		$q .= !empty($this->estado) ? "AND estado = '".$this->estado."' " : " ";
		$q .= !empty($this->ordem) ? "AND ordem = '".$this->ordem."' " : " ";
		$q .= !empty($this->estilo) ? "AND estilo = '".$this->estilo."' " : " ";
		$q .= !empty($this->id_album) ? "AND id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->id_album_02) ? "AND id_album_02 = '".$this->id_album_02."' " : " ";
		$q .= !empty($this->id_album_03) ? "AND id_album_03 = '".$this->id_album_03."' " : " ";
		$q .= !empty($this->id_album_04) ? "AND id_album_04 = '".$this->id_album_04."' " : " ";
		$q .= !empty($this->chamada_produto) ? "AND chamada_produto = '".$this->chamada_produto."' " : " ";
		$q .= !empty($this->criterio) ? "AND ".$this->criterio." " : " ";
		
		$q .= !empty($this->not_in) ? "AND id NOT IN(".$this->not_in.") " : " ";

		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY id DESC ";
		empty($this->limite_inicio) ? $limite_inicio_02 = "0" : $limite_inicio_02 = $this->limite_inicio;
		$q .= !empty($this->limite) ? " LIMIT ".$limite_inicio_02.", ".$this->limite." " : " ";
//echo ($q);echo "<br/>";//die();

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

	public function selecionar_produto_complemento()
	{
		$q = "

		SELECT DISTINCT 
		".$this->prefixo."_tbl_produto.id 
		,".$this->prefixo."_tbl_produto.nome 
		,".$this->prefixo."_tbl_produto.corpo
		,".$this->prefixo."_tbl_produto.ordem
		,".$this->prefixo."_tbl_produto.id_album
		,".$this->prefixo."_tbl_produto.id_album_02
		,".$this->prefixo."_tbl_produto.id_album_03
		,".$this->prefixo."_tbl_produto.id_album_04
		,".$this->prefixo."_tbl_produto.estilo
		,".$this->prefixo."_tbl_produto.chamada_produto
		,".$this->prefixo."_tbl_produto.url
		,(SELECT a.id FROM  ".$this->prefixo."_tbl_categoria a
			INNER JOIN ".$this->prefixo."_tbl_categoria_produto 
			ON ".$this->prefixo."_tbl_categoria_produto.id_categoria = a.id
			WHERE ".$this->prefixo."_tbl_categoria_produto.id_produto = ".$this->prefixo."_tbl_produto.id limit 0,1) AS id_categoria
	
		
		,(SELECT ab.chamada_categoria FROM  ".$this->prefixo."_tbl_categoria ab
			INNER JOIN ".$this->prefixo."_tbl_categoria_produto 
			ON ".$this->prefixo."_tbl_categoria_produto.id_categoria = ab.id
			WHERE ".$this->prefixo."_tbl_categoria_produto.id_produto = ".$this->prefixo."_tbl_produto.id limit 0,1) AS chamada_categoria
			
		,(SELECT b.estado FROM  ".$this->prefixo."_tbl_categoria b
			INNER JOIN ".$this->prefixo."_tbl_categoria_produto 
			ON ".$this->prefixo."_tbl_categoria_produto.id_categoria = b.id
			WHERE ".$this->prefixo."_tbl_categoria_produto.id_produto = ".$this->prefixo."_tbl_produto.id limit 0,1) AS estado_categoria
		";

		$q .= "FROM ".$this->prefixo."_tbl_produto 

		INNER JOIN ".$this->prefixo."_tbl_categoria_produto
		ON ".$this->prefixo."_tbl_categoria_produto.id_produto = ".$this->prefixo."_tbl_produto.id
		
		INNER JOIN ".$this->prefixo."_tbl_categoria
		ON ".$this->prefixo."_tbl_categoria.id = ".$this->prefixo."_tbl_categoria_produto.id_categoria

		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND (".$this->prefixo."_tbl_produto.nome LIKE '%".$this->termo_busca."%' OR corpo LIKE '%".$this->termo_busca."%' OR palavra_chave LIKE '%".$this->termo_busca."%')": " ";
		$q .= !empty($this->nome) ? "AND ".$this->prefixo."_tbl_produto.nome = '".$this->nome."' " : " ";
		$q .= !empty($this->corpo) ? "AND corpo = '".$this->corpo."' " : " ";
		$q .= !empty($this->id) ? "AND ".$this->prefixo."_tbl_produto.id = '".$this->id."' " : " ";
		$q .= !empty($this->estado) ? "AND ".$this->prefixo."_tbl_produto.estado = '".$this->estado."' " : " ";
		$q .= !empty($this->ordem) ? "AND ".$this->prefixo."_tbl_produto.ordem = '".$this->ordem."' " : " ";
		$q .= !empty($this->id_album) ? "AND ".$this->prefixo."_tbl_produto.id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->id_album_02) ? "AND ".$this->prefixo."_tbl_produto.id_album_02 = '".$this->id_album_02."' " : " ";
		$q .= !empty($this->id_album_03) ? "AND ".$this->prefixo."_tbl_produto.id_album_03 = '".$this->id_album_03."' " : " ";
		$q .= !empty($this->id_album_04) ? "AND ".$this->prefixo."_tbl_produto.id_album_04 = '".$this->id_album_04."' " : " ";
		$q .= !empty($this->estilo) ? "AND ".$this->prefixo."_tbl_produto.estilo = '".$this->estilo."' " : " ";
		$q .= !empty($this->chamada_produto) ? "AND ".$this->prefixo."_tbl_produto.chamada_produto = '".$this->chamada_produto."' " : " ";
		$q .= !empty($this->categoria_id) ? "AND ".$this->prefixo."_tbl_categoria.id = '".$this->categoria_id."' " : " ";
		$q .= !empty($this->in_busca) ? " AND ".$this->prefixo."_tbl_produto.id IN (".$this->in_busca.") " : " ";
		$q .= !empty($this->categoria_estado) ? "AND categoria_estado = '".$this->categoria_estado."' " : " ";

		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador." ".$this->DESC_ASC."" : " ORDER BY id DESC ";
		empty($this->limite_inicio) ? $limite_inicio_02 = "0" : $limite_inicio_02 = $this->limite_inicio;
		$q .= !empty($this->limite) ? " LIMIT ".$limite_inicio_02.", ".$this->limite." " : " ";

		//echo "<pre>".$q."</pre>";
		//die($q);
		//echo $q;die('');
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
	
	public function selecionar_produto_complemento_04()
	{
		$q = "

		SELECT
		".$this->prefixo."_tbl_produto.id 
		,".$this->prefixo."_tbl_produto.nome 
		,".$this->prefixo."_tbl_produto.corpo
		,".$this->prefixo."_tbl_produto.ordem
		,".$this->prefixo."_tbl_produto.id_album
		,".$this->prefixo."_tbl_produto.id_album_02
		,".$this->prefixo."_tbl_produto.estilo
		,".$this->prefixo."_tbl_produto.chamada_produto
		,".$this->prefixo."_tbl_produto.url
		,".$this->prefixo."_tbl_categoria.id as id_categoria
		,".$this->prefixo."_tbl_categoria.estado as estado_categoria
		,".$this->prefixo."_tbl_categoria.chamada_categoria
		";

		$q .= "FROM ".$this->prefixo."_tbl_produto 

		INNER  JOIN ".$this->prefixo."_tbl_categoria_produto
		ON ".$this->prefixo."_tbl_categoria_produto.id_produto = ".$this->prefixo."_tbl_produto.id
		
		INNER  JOIN ".$this->prefixo."_tbl_categoria
		ON ".$this->prefixo."_tbl_categoria.id = ".$this->prefixo."_tbl_categoria_produto.id_categoria

		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND (".$this->prefixo."_tbl_produto.nome LIKE '%".$this->termo_busca."%' OR corpo LIKE '%".$this->termo_busca."%' OR palavra_chave LIKE '%".$this->termo_busca."%')": " ";
		$q .= !empty($this->nome) ? "AND ".$this->prefixo."_tbl_produto.nome = '".$this->nome."' " : " ";
		$q .= !empty($this->corpo) ? "AND corpo = '".$this->corpo."' " : " ";
		$q .= !empty($this->id) ? "AND ".$this->prefixo."_tbl_produto.id = '".$this->id."' " : " ";
		$q .= !empty($this->estado) ? "AND ".$this->prefixo."_tbl_produto.estado = '".$this->estado."' " : " ";
		$q .= !empty($this->ordem) ? "AND ".$this->prefixo."_tbl_produto.ordem = '".$this->ordem."' " : " ";
		$q .= !empty($this->id_album) ? "AND ".$this->prefixo."_tbl_produto.id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->id_album_02) ? "AND ".$this->prefixo."_tbl_produto.id_album_02 = '".$this->id_album_02."' " : " ";
		$q .= !empty($this->estilo) ? "AND ".$this->prefixo."_tbl_produto.estilo = '".$this->estilo."' " : " ";
		$q .= !empty($this->chamada_produto) ? "AND ".$this->prefixo."_tbl_produto.chamada_produto = '".$this->chamada_produto."' " : " ";
		$q .= !empty($this->categoria_id) ? "AND ".$this->prefixo."_tbl_categoria.id = '".$this->categoria_id."' " : " ";
		$q .= !empty($this->in_busca) ? " AND ".$this->prefixo."_tbl_produto.id IN (".$this->in_busca.") " : " ";
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador." ".$this->DESC_ASC."" : " ORDER BY ".$this->prefixo."_tbl_produto.id DESC ";
		$q .= !empty($this->categoria_estado) ? "AND categoria_estado = '".$this->categoria_estado."' " : " ";
		empty($this->limite_inicio) ? $limite_inicio_02 = "0" : $limite_inicio_02 = $this->limite_inicio;
		$q .= !empty($this->limite) ? " LIMIT ".$limite_inicio_02.", ".$this->limite." " : " ";

		//echo "<pre>".$q."</pre>";
		//echo $q."<br>";die();
		$this->sql = $q;
		$stmt = $this->executar();
		//echo $q;
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
		INSERT INTO ".$this->prefixo."_tbl_produto
		(
		nome
		,data
		,corpo
		,estado
		,ordem
		,estilo
		,id_album
		,id_album_02
		,id_album_03
		,id_album_04
		,chamada_produto
		,url
		)
		VALUES 
		(
		'".$this->nome."' 
		,'".$this->data."' 
		,'".addslashes($this->corpo)."'
		,'".$this->estado."'
		,'".$this->ordem."'
		,'".$this->estilo."'
		,'".$this->id_album."'
		,'".$this->id_album_02."'
		,'".$this->id_album_03."'
		,'".$this->id_album_04."'
		,'".$this->chamada_produto."'
		,'".$this->url."'
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
		UPDATE ".$this->prefixo."_tbl_produto SET 
		nome = '".$this->nome."' 
		,corpo = '".addslashes($this->corpo)."'
		,data = '".$this->data."'
		,estado = '".$this->estado."'
		,ordem = '".$this->ordem."'
		,estilo = '".$this->estilo."'
		,id_album = '".$this->id_album."'
		,id_album_02 = '".$this->id_album_02."'
		,id_album_03 = '".$this->id_album_03."'
		,id_album_04 = '".$this->id_album_04."'
		,chamada_produto = '".$this->chamada_produto."'
		,url = '".$this->url."'


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

	public function editar_02()
	{
		$q = "
		UPDATE ".$this->prefixo."_tbl_produto SET 
		avaliacao = '".$this->avaliacao."'
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
	
	public function editar_album()
	{
		$q = "
		UPDATE ".$this->prefixo."_tbl_produto SET ";
		
		$q .= !empty($this->id_album) ? " id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->id_album_02) ? " id_album_02 = '".$this->id_album_02."' " : " ";
		$q .= !empty($this->id_album_03) ? " id_album_03 = '".$this->id_album_03."' " : " ";
		$q .= !empty($this->id_album_04) ? " id_album_04 = '".$this->id_album_04."' " : " ";
		
		$q .= "
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
		DELETE FROM ".$this->prefixo."_tbl_produto WHERE id='".$this->id."'";

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
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_produto ORDER BY id DESC LIMIT 1
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