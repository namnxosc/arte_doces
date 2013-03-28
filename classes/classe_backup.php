<?php

class Backup extends Executa
{
	private $id;
	private $id_usuario; 
	private $data_hora; 
	private $arquivo; 
	
	private $limite;
	private $ordenador;
	private $termo_busca;
			
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
		,data_hora
		,id_usuario
		,arquivo
		
		";
				
		$q .= "FROM ".$this->prefixo."_tbl_backup 
		WHERE 
		1=1  
		";
		
		$q .= !empty($this->termo_busca) ? "AND data_horaLIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->data_hora) ? "AND data_hora= '".$this->data_hora."' " : " ";
		$q .= !empty($this->id_usuario) ? "AND id_usuario= '".$this->id_usuario."' " : " ";
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
	
	
	public function selecionar_backup_usuario()
	{
		$q = "				

		SELECT
		".$this->prefixo."_tbl_backup.id 
		,".$this->prefixo."_tbl_backup.data_hora
		,DATE_FORMAT(".$this->prefixo."_tbl_backup.data_hora, '%d/%m/%Y') AS data
		,DATE_FORMAT(".$this->prefixo."_tbl_backup.data_hora, '%k:%i:%s') as hora
		,".$this->prefixo."_tbl_backup.data_hora
		,".$this->prefixo."_tbl_backup.id_usuario
		,".$this->prefixo."_tbl_backup.arquivo
		,".$this->prefixo."_tbl_usuario.nome AS usuario_nome
		";
				
		$q .= "FROM ".$this->prefixo."_tbl_backup 
		INNER JOIN  ".$this->prefixo."_tbl_usuario ON
		".$this->prefixo."_tbl_backup.id_usuario=".$this->prefixo."_tbl_usuario.id
		
		WHERE 
		1=1  
		";
		
		$q .= !empty($this->termo_busca) ? "AND ".$this->prefixo."_tbl_backup.data_hora LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->data_hora) ? "AND ".$this->prefixo."_tbl_backup.data_hora= '".$this->data_hora."' " : " ";
		$q .= !empty($this->id_usuario) ? "AND ".$this->prefixo."_tbl_backup.id_usuario= '".$this->id_usuario."' " : " ";
		$q .= !empty($this->id) ? "AND ".$this->prefixo."_tbl_backup.id = '".$this->id."' " : " ";
 		
		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY ".$this->prefixo."_tbl_backup.id DESC ";
		
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
		
		INSERT INTO ".$this->prefixo."_tbl_backup
		(
		
		data_hora
		,id_usuario
		,arquivo
		
		)
		VALUES 
		(
		
		'".$this->data_hora."'
		,'".$this->id_usuario."'
		,'".$this->arquivo."'
		
		)";
		
		$this->sql = $q;
		$stmt = $this->executar();
		//die($q);exit;
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
		
		UPDATE ".$this->prefixo."_tbl_backup SET 
		
		data_hora= '".$this->data_hora."'
		,id_usuario= '".$this->id_usuario."'
		,arquivo= '".$this->arquivo."'
		
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

		DELETE FROM ".$this->prefixo."_tbl_backup WHERE id='".$this->id."'";
		//die($q);exit;
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