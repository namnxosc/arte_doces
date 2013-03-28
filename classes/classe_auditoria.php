<?php

class Auditoria extends Executa
{
	private $id;
	private $nome; 
	private $usuario_id; 
	private $data_01;
	private $data_02;
	
	
	private $acao_descricao;
	
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
	
	public function selecionar()
	{
		$q = "				

		SELECT
		 DATE_FORMAT(data_hora, '%d/%m/%Y %H:%i:%s') AS data_hora,
		 usuario_id,
		 nome,
		 acao,
		 ip,
		 partida,
		 id 
		 FROM ".$this->prefixo."_tbl_auditoria 
 
		";
		
		$q .= !empty($this->data_01) ? " WHERE 	data_hora BETWEEN '".$this->data_01." 00:00:00' AND '".$this->data_02." 23:59:59' " : " ";

		$q .= " ORDER BY id DESC ";

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
		INSERT INTO ".$this->prefixo."_tbl_auditoria
		(
			nome,
			data_hora,
			ip,
			acao,
			partida,
			usuario_id
		)
		VALUES
		(
			'".$_SESSION["usuario_usuario"]."',
			'".date("y-m-d h:i:s")."',
			'".$_SERVER['REMOTE_ADDR']."',
			'".str_replace("'", "&#39;", $this->acao_descricao)."',
			'".$_SERVER['HTTP_REFERER']."',
			'".$_SESSION["usuario_numero"]."'
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
	
	public function msg()
	{
		$msg = "<div style=\"background-color:#eee; display:block; border:1px solid #999; padding:6px;\"><b>DADOS DE AUDITORIA</b>:<br>";
		$msg .= "<b>Usuário</b>: ".$_SESSION["usuario_usuario"]." [".$_SESSION["usuario_numero"]."]<br>";
		$msg .= "<b>Ação</b>: ".$this->acao_descricao."<br>";
		$msg .= "<b>Data-Hora</b>: ".date("d-m-Y H:i:s")."<br>";
		$msg .= "<b>IP</b>: ".$_SERVER['REMOTE_ADDR']."<br>";
		$msg .= "<b>Endereço de onde partiu interação</b>: ".$_SERVER['HTTP_REFERER']."<br>";
		$msg .= "</div>";
		return $msg;
	}
	
	public function editar()
	{
		$q = "
		
		UPDATE ".$this->prefixo."_tbl_pessoa SET 
		nome = '".$this->nome."'
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

		DELETE FROM ".$this->prefixo."_tbl_auditoria WHERE id='".$this->id."'";
		
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
	
	public function ultimo_id()
	{
		$q = "
		
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_pessoa ORDER BY id DESC LIMIT 1
		
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