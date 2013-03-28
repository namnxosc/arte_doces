<?php
class Executa extends Conexao
{
	public $sql; // String da consulta SQL a ser executada
	public $con; //  Recebe a conexao com banco.

	public function __construct()
	{
		parent::__construct();
		# Recebe a conexao da classe PDOConnection.
		$this->con = $this->conectar();
	}

	public function __destruct()
	{
		//fecha conexão
		$this->con = null;
	}

	function set($prop, $value)
	{
		$this->$prop = $value;
	}

	protected function executar()
	{
		$o_ajudante = new Ajudante;
		try
		{
			// prepara a query - Prepare Statement
			$stmt = $this->con->prepare($this->sql);
			// executa a query preparada
			$stmt->execute();
			// retorna o resultado da query
			return $stmt;
		# Excecoes de erro do db
		}
		catch (PDOException $ex)
		{
            echo $ex->getMessage();
			
			//mensagem mais amigável
			$o_ajudante->mensagem(0,"t","titulo","corpo","msg_erro");
			//envio de e-mail para administrador do site
			return false;
		}
	}

	function erro($erro)
	{
		echo $erro;
	}
}
?>