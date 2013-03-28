<?php
class Imagem extends Executa
{
	private $id;
	private $nome; 
	private $estado;
	private $id_album;
	private $descricao;
	private $destaque;
	private $url;
	
	private $limite;
	private $ordenador;
	private $termo_busca;
	private $criterio_sql;
	
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
		id 
		,nome 
		,estado
		,id_album 
		,descricao
		,destaque
		,url
		";
		
		$q .= "FROM ".$this->prefixo."_tbl_imagem 
		WHERE 
		1=1  
		";
		
		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->id_album) ? "AND id_album = '".$this->id_album."' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->estado) ? "AND estado = '".$this->estado."' " : " ";
		$q .= !empty($this->destaque) ? "AND destaque = '".$this->destaque."' " : " ";
		$q .= !empty($this->criterio_sql) ? "AND ".$this->criterio_sql." " : " ";
 		
		//$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY id DESC ";
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY destaque DESC";
		
		$q .= !empty($this->limite) ? " LIMIT 0, ".$this->limite." " : " ";
	//echo $q."<br/>";
	
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
	
	
	public function selecionar_album_imagem()
	{
		$q = "				

		SELECT
		".$this->prefixo."_tbl_imagem.id 
		,".$this->prefixo."_tbl_imagem.nome 
		,".$this->prefixo."_tbl_imagem.estado
		,".$this->prefixo."_tbl_imagem.id_album 
		,".$this->prefixo."_tbl_imagem.descricao
		,".$this->prefixo."_tbl_imagem.destaque
		,".$this->prefixo."_tbl_album.nome AS nome_album
		,".$this->prefixo."_tbl_album.id_album_tipo
		";
		
		$q .= "FROM ".$this->prefixo."_tbl_imagem 
		
		INNER JOIN ".$this->prefixo."_tbl_album
		ON ".$this->prefixo."_tbl_imagem.id_album = ".$this->prefixo."_tbl_album.id
		
		WHERE 
		1=1 
		";
		
		$q .= !empty($this->termo_busca) ? "AND (".$this->prefixo."_tbl_imagem.nome LIKE '%".$this->termo_busca."%' OR ".$this->prefixo."_tbl_album.nome LIKE '%".$this->termo_busca."%') " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->estado) ? "AND status = '".$this->estado."' " : " ";
 		
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY ".$this->prefixo."_tbl_imagem.id DESC ";
		
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
		
		INSERT INTO ".$this->prefixo."_tbl_imagem
		(
		
		id_album,
		descricao,
		destaque,
		nome,
		estado,
		url
		
		)
		VALUES 
		(
		
		'".$this->id_album."',
		'".$this->descricao."',
		'".$this->destaque."',
		'".$this->nome."',
		'".$this->estado."',
		'".$this->url."'		
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
		
		UPDATE ".$this->prefixo."_tbl_imagem SET 
		
		id_album = '".$this->id_album."', 
		destaque = '".$this->destaque."', 
		descricao = '".$this->descricao."', 
		nome = '".$this->nome."', 
		estado = '".$this->estado."'
		
		WHERE id='".$this->id."'
		
		";
		
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
	
	public function editar_url()
	{
		$q = "
		
		UPDATE ".$this->prefixo."_tbl_imagem SET 
		
		url = '".$this->url."'
		
		WHERE id='".$this->id."'
		
		";
		
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
	
	public function excluir()
	{
		$q = "				

		DELETE FROM ".$this->prefixo."_tbl_imagem WHERE id='".$this->id."'";
		
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
		
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_imagem ORDER BY id DESC LIMIT 1
		
		";
		
		//Envia a string de consulta
		parent::set("sql",$q);
		
		//verifica se houve um retorno maior que 0
		if(parent::query()->rowCount() > 0)
		{
			return parent::query();
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