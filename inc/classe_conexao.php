<?php
class Conexao extends Configuracao 
{
	private $db_tipo; // Tipo de banco
	private $host; // Host (Servidor) que executa o banco de dados
	private $usuario; // Usuário que se conecta ao servidor de banco de dados
	private $senha; // Senha do usuário para conexão ao banco de dados
	private $db; // Nome do banco de dados a ser utilizado

	function set($prop, $value)
	{
		$this->$prop = $value;
	}

	function __construct()
	{
        parent::__construct();
        $this->db_tipo = "mysql";
        $this->host = $this->host();
        $this->usuario = $this->usuario();
        $this->senha = $this->senha();
        $this->db = $this->banco_dados();
    }
	
	function __destruct()
	{
 
    }

	# Metodo para criar a conexao com Banco de Dados.
	protected function conectar()
	{
		try
		{
			// Recebe Nome de Fonte de Dados
			$dsn = $this->db_tipo.":host=".$this->host.";dbname=".$this->db."";
			// Passa os parametros para realizar a conexao.
			$con = new PDO($dsn, $this->usuario, $this->senha);
			// Retorna a conexao.
			return $con;
		}
		catch ( PDOException $ex  )
		{
			echo $ex->getMessage();
            // Mensagem de erro do PDOException: $ex->getMessage()
            print("<h2>Erro: Falha interna. Contate o desenvolvedor do sistema.</h2> ". $ex->getMessage() );
            return false;
        }
    }# end function
   
}
?>