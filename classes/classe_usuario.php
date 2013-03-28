<?php
class Usuario extends Executa
{
	private $id;
	private $nome; 
	private $sobrenome; 
	private $nome_contato; 
	private $cpf; 
	private $ie; 
	private $email;
	private $cep;
	private $endereco;
	private $numero;
	private $complemento;
	private $bairro;
	private $uf;
	private $cidade;
	private $telefone;
	private $celular;
	private $fax;
	private $login;
	private $senha;
	private $data_acesso;
	private $data_hora;
	private $termo;
	private $tipo;
	private $estado;
	private $sexo;
	private $id_usuario_tipo;
	private $usuarios_tipo;
	private $id_usuario_02;
	private $filtro_busca;
	private $busca;

	private $not_in;
	private $limite;
	private $ordenador;
	private $termo_busca;

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
		,sobrenome
		,nome_contato
		,cpf 
		,ie 
		,email 
		,cep 
		,endereco 
		,numero 
		,complemento 
		,bairro 
		,uf 
		,cidade 
		,telefone 
		,celular 
		,fax 
		,login 
		,senha 
		,data_acesso 
		,data_hora 
		,termo 
		,tipo 
		,estado
		,id_usuario_02 
		,id_usuario_tipo 
		,(SELECT nome FROM ".$this->prefixo."_tbl_usuario_tipo WHERE id = ".$this->prefixo."_tbl_usuario.id_usuario_tipo ) AS usuario_tipo_nome
		,(SELECT a.nome FROM ".$this->prefixo."_tbl_usuario a WHERE a.id = ".$this->prefixo."_tbl_usuario.id_usuario_02 AND a.id_usuario_tipo <> 2 limit 0,1) AS usuario_nome
		"; 

		$q .= "FROM ".$this->prefixo."_tbl_usuario 
		WHERE 
		1=1  
		";

		$q .= !empty($this->termo_busca) ? "AND nome LIKE '%".$this->termo_busca."%' or cpf LIKE '%".$this->termo_busca."%' " : " ";
		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->nome) ? "AND nome = '".$this->nome."' " : " ";
		$q .= !empty($this->sobrenome) ? "AND sobrenome = '".$this->sobrenome."' " : " ";
		$q .= !empty($this->nome_contato) ? "AND nome_contato = '".$this->nome_contato."' " : " ";
		$q .= !empty($this->cpf) ? "AND cpf = '".$this->cpf."' " : " ";
		$q .= !empty($this->ie) ? "AND ie = '".$this->ie."' " : " ";
		$q .= !empty($this->email) ? "AND email = '".$this->email."' " : " ";
		$q .= !empty($this->cep) ? "AND cep = '".$this->cep."' " : " ";
		$q .= !empty($this->endereco) ? "AND endereco = '".$this->endereco."' " : " ";
		$q .= !empty($this->numero) ? "AND numero = '".$this->numero."' " : " ";
		$q .= !empty($this->complemento) ? "AND complemento = '".$this->complemento."' " : " ";
		$q .= !empty($this->bairro) ? "AND bairro = '".$this->bairro."' " : " ";
		$q .= !empty($this->uf) ? "AND uf = '".$this->uf."' " : " ";
		$q .= !empty($this->cidade) ? "AND cidade = '".$this->cidade."' " : " ";
		$q .= !empty($this->telefone) ? "AND telefone = '".$this->telefone."' " : " ";
		$q .= !empty($this->celular) ? "AND celular = '".$this->celular."' " : " ";
		$q .= !empty($this->fax) ? "AND fax = '".$this->fax."' " : " ";
		$q .= !empty($this->login) ? "AND login = '".$this->login."' " : " ";
		$q .= !empty($this->senha) ? "AND senha = '".$this->senha."' " : " ";
		$q .= !empty($this->data_acesso) ? "AND data_acesso = '".$this->data_acesso."' " : " ";
		$q .= !empty($this->data_hora) ? "AND data_hora = '".$this->data_hora."' " : " ";
		$q .= !empty($this->termo) ? "AND termo= '".$this->termo."' " : " ";
		$q .= !empty($this->tipo) ? "AND tipo= '".$this->tipo."' " : " ";
		$q .= !empty($this->estado) ? "AND estado= '".$this->estado."' " : " ";
		$q .= !empty($this->id_usuario_tipo) ? "AND id_usuario_tipo = '".$this->id_usuario_tipo."' " : " ";
		$q .= !empty($this->id_usuario_02) ? "AND id_usuario_02 = '".$this->id_usuario_02."' " : " ";
		$q .= !empty($this->not_in) ? "AND id_usuario_tipo NOT IN('".$this->not_in."') " : " ";
		$q .= !empty($this->usuarios_tipo) ? "AND id_usuario_tipo IN (".$this->usuarios_tipo.") " : " ";
		$q .= !empty($this->filtro_busca) ? "AND ".$this->filtro_busca." LIKE '%".$this->busca."%'": " ";

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

	public function selecionar_02()
	{
		$q = "
		SELECT 
		id 
		,nome 
		,sobrenome
		,nome_contato
		,cpf 
		,ie 
		,email 
		,cep 
		,endereco 
		,numero 
		,complemento 
		,bairro 
		,uf 
		,cidade 
		,telefone 
		,celular 
		,fax 
		,login 
		,senha 
		,data_acesso 
		,data_hora 
		,termo 
		,tipo 
		,estado 
		,sexo	
		,id_usuario_tipo 
		,id_usuario_02 
		"; 

		$q .= "FROM ".$this->prefixo."_tbl_usuario 
		WHERE 
		1=1  
		";

		$q .= !empty($this->id) ? "AND id = '".$this->id."' " : " ";
		$q .= !empty($this->id_usuario_02) ? "AND id_usuario_02 = '".$this->id_usuario_02."' " : " ";
		$q .= !empty($this->not_in) ? "AND id_usuario_tipo NOT IN('".$this->not_in."') " : " ";

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

	public function selecionar_usuario_pessoa()
	{
		$q = "
		SELECT 
		DATE_FORMAT(data_acesso,'%d/%m/%Y %T') AS data_acesso,
		".$this->prefixo."_tbl_usuario.id AS usuario_id,
		".$this->prefixo."_tbl_usuario.nome AS usuario_nome,
		".$this->prefixo."_tbl_usuario.email AS usuario_email,
		".$this->prefixo."_tbl_usuario_tipo.id,
		".$this->prefixo."_tbl_usuario.id_pessoa,
		".$this->prefixo."_tbl_usuario_tipo.nome AS tipo_nome

		FROM 
		".$this->prefixo."_tbl_usuario

		INNER JOIN ".$this->prefixo."_tbl_usuario_tipo
		ON ".$this->prefixo."_tbl_usuario_tipo.id = ".$this->prefixo."_tbl_usuario.id_usuario_tipo

		WHERE 
		
		senha ='".sha1($this->senha)."' ";
		
		$q .= !empty($this->login) ? " AND ".$this->prefixo."_tbl_usuario.login = '".$this->login."' " : " ";
		$q .= !empty($this->nome) ? " AND ".$this->prefixo."_tbl_usuario.nome = '".$this->nome."' " : " ";
		$q .= !empty($this->id_usuario_tipo) ? " AND ".$this->prefixo."_tbl_usuario_tipo.id = '".$this->id_usuario_tipo."' " : " ";
		$q .= !empty($this->email) ? " AND email = '".$this->email."' " : " ";
		$q .= "AND ".$this->prefixo."_tbl_usuario.estado = 'a'
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

	public function selecionar_03()
	{
		$q = "
		SELECT 
		".$this->prefixo."_tbl_usuario.id
		,".$this->prefixo."_tbl_usuario.nome
		,".$this->prefixo."_tbl_usuario.senha
		,".$this->prefixo."_tbl_usuario.email
		,".$this->prefixo."_tbl_usuario.estado
		,".$this->prefixo."_tbl_usuario.data_acesso
		,".$this->prefixo."_tbl_usuario.data_hora
		,".$this->prefixo."_tbl_usuario.id_usuario_tipo
		"; 

		$q .= "FROM ".$this->prefixo."_tbl_usuario 

		WHERE 
		1=1  
		";

		$q .= !empty($this->id) ? "AND ".$this->prefixo."_tbl_usuario.id = '".$this->id."' " : " ";
		$q .= !empty($this->nome) ? "AND ".$this->prefixo."_tbl_usuario.nome = '".$this->nome."' " : " ";
		$q .= !empty($this->email) ? "AND ".$this->prefixo."_tbl_usuario.email = '".$this->email."' " : " ";
		$q .= !empty($this->cpf) ? "AND ".$this->prefixo."_tbl_pessoa_dado.cpf = '".$this->cpf."' " : " ";
		$q .= !empty($this->senha) ? "AND ".$this->prefixo."_tbl_usuario.senha = '".$this->senha."' " : " ";
		$q .= !empty($this->estado) ? "AND ".$this->prefixo."_tbl_usuario.estado= '".$this->estado."' " : " ";
		$q .= !empty($this->data_acesso) ? "AND ".$this->prefixo."_tbl_usuario.data_acesso = '".$this->data_acesso."' " : " ";
		$q .= !empty($this->data_hora) ? "AND ".$this->prefixo."_tbl_usuario.data_hora = '".$this->data_hora."' " : " ";
		$q .= !empty($this->id_usuario_tipo) ? "AND ".$this->prefixo."_tbl_usuario.id_usuario_tipo = '".$this->id_usuario_tipo."' " : " "; 
		$q .= !empty($this->tipo) ? "AND ".$this->prefixo."_tbl_usuario.tipo = '".$this->tipo."' " : " "; 

		$q .= !empty($this->ordenador) ? "ORDER BY ".$this->ordenador."" : " ORDER BY ".$this->prefixo."_tbl_usuario.id DESC ";
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

	public function total_user()
	{
		$q = "
		SELECT COUNT(".$this->prefixo."_tbl_usuario.id) as total 
		";

		$q .= " FROM ".$this->prefixo."_tbl_usuario

		WHERE 
		1=1  
		";

		$q .= !empty($this->id) ? "AND ".$this->prefixo."_tbl_usuario.id = '".$this->id."' " : " ";
		$q .= !empty($this->id_usuario_tipo) ? "AND ".$this->prefixo."_tbl_usuario.id_usuario_tipo = '".$this->id_usuario_tipo."' " : " "; 
		$q .= !empty($this->tipo) ? "AND ".$this->prefixo."_tbl_usuario.tipo = '".$this->tipo."' " : " "; 

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
		INSERT INTO ".$this->prefixo."_tbl_usuario
		(
		nome,
		sobrenome,
		nome_contato,
		cpf,
		ie,
		email,
		cep,
		endereco,
		numero,
		complemento,
		bairro,
		uf,
		cidade,
		telefone,
		celular,
		fax,
		login,
		senha,
		data_hora,
		termo,
		tipo,
		estado,
		sexo,
		id_usuario_tipo,
		id_usuario_02,
		uid,
		data_ts,
		ativo
		)
		VALUES 
		(
		'".ucwords($this->nome)."',
		'".ucwords($this->sobrenome)."',
		'".ucwords($this->nome_contato)."',
		'".$this->cpf."',
		'".$this->ie."',
		'".$this->email."',
		'".$this->cep."',
		'".$this->endereco."',
		'".$this->numero."',
		'".$this->complemento."',
		'".$this->bairro."',
		'".$this->uf."',
		'".$this->cidade."',
		'".$this->telefone."',
		'".$this->celular."',
		'".$this->fax."',
		'".$this->login."',
		'".$this->senha."',
		'".$this->data_hora."',
		'".$this->termo."',
		'".$this->tipo."',
		'".$this->estado."',
		'".$this->sexo."',	
		'".$this->id_usuario_tipo."',
		'".$this->id_usuario_02."',
		'".$this->uid."',
		'".$this->data_ts."',
		'".$this->ativo."'
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
		UPDATE ".$this->prefixo."_tbl_usuario SET 

		nome = '".ucwords($this->nome)."',
		sobrenome = '".ucwords($this->sobrenome)."',
		nome_contato = '".ucwords($this->nome_contato)."',
		cpf = '".$this->cpf."',
		ie = '".$this->ie."',
		email = '".$this->email."',
		cep = '".$this->cep."',
		endereco = '".$this->endereco."',
		numero = '".$this->numero."',
		complemento = '".$this->complemento."',
		bairro = '".$this->bairro."',
		uf = '".$this->uf."',
		cidade = '".$this->cidade."',
		telefone = '".$this->telefone."',
		celular = '".$this->celular."',
		fax = '".$this->fax."',
		login = '".$this->login."',
		termo = '".$this->termo."',
		tipo = '".$this->tipo."',
		estado = '".$this->estado."',
		sexo = '".$this->sexo."',
		id_usuario_tipo = '".$this->id_usuario_tipo."' ";
		
		$q .= !empty($this->id_usuario_02) ? ", id_usuario_02 = '".$this->id_usuario_02."' " : " "; 
		$q .= !empty($this->senha) ? ", senha = '".$this->senha."' " : " "; 

		$q .= "
		WHERE id ='".$this->id."'
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

	public function editar_02()
	{
		$q = "
		UPDATE ".$this->prefixo."_tbl_usuario SET 

		cpf = '".$this->cpf."',
		ie = '".$this->ie."',
		cep = '".$this->cep."',
		endereco = '".$this->endereco."',
		numero = '".$this->numero."',
		complemento = '".$this->complemento."',
		bairro = '".$this->bairro."',
		uf = '".$this->uf."',
		cidade = '".$this->cidade."',
		email = '".$this->email."',
		telefone = '".$this->telefone."',
		celular = '".$this->celular."',
		fax = '".$this->fax."' 

		WHERE id ='".$this->id."'
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

	public function editar_03()
	{
		$q = "
		UPDATE ".$this->prefixo."_tbl_usuario SET 

		id_usuario_02 = '".$this->id_usuario_02."'

		WHERE id ='".$this->id."'
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

	public function editar_estado()
	{
		$q = "
		UPDATE ".$this->prefixo."_tbl_usuario SET 
		estado = '".$this->estado."'
		WHERE id ='".$this->id."'
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

	public function editar_senha()
	{
		$q = "
		UPDATE ".$this->prefixo."_tbl_usuario SET 
		senha = '".$this->senha."'
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

	public function editar_data_acesso()
	{
		$q = "
		UPDATE ".$this->prefixo."_tbl_usuario SET 
		data_acesso = '".$this->data_acesso."'
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
		DELETE FROM ".$this->prefixo."_tbl_usuario WHERE id='".$this->id."'";
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
		SELECT LAST_INSERT_ID(id) AS id  FROM ".$this->prefixo."_tbl_usuario ORDER BY id DESC LIMIT 1
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