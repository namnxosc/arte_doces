<?php

class Template
{
    private $senha; // Senha do usuário para conexão ao banco de dados
    private $db; // Nome do banco de dados a ser utilizado

    function set($prop, $value)
	{
        $this->$prop = $value;
    }

    function __construct()
	{

    }

	function template_resultado()
	{
		if (!file_exists($this->nome_aquivo))//verifica se arquivo existe
		{
			$resultado = "Arquivo ".$this->nome_aquivo." não existe.";
		}
		else
		{
			$file_array = file($this->nome_aquivo);//poe texto do arquivo em um array
			$resultado = implode("", $file_array);//achata array

			if (empty($resultado))
			{
				$resultado = "Arquivo ".$this->nome_aquivo." vazio.";
			}
		}
		return $resultado;
	}
   
}
?>