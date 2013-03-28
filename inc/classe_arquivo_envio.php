<?php

class Arquivo_envio
{

	private $ftp_server;
	private $ftp_usuario;
	private $ftp_senha;
	private $destino;
	
	private $arquivo;
	private $permitidos;
	private $tamanho_arquivo;
	private $retorno;
	private $novo_nome;
	
	function __construct()
	{
	}

	function __destruct()
	{
	}
	
	function set($prop, $value)
	{
		$this->$prop = $value;
	}

	function upload()
	{
		if (isset($this->arquivo) && $this->arquivo["name"] != "")
		{
			
			//verifica se o arquivo é permitido
			$p = $this->permitidos;
			$p2 = explode(",",$this->permitidos);

			$temp = explode(".",strtolower($this->arquivo['name']));

			$temp2 = end($temp);
			//if (!in_array(end(explode(".", strtolower($this->arquivo['name']))), $p2))
			if(!in_array($temp2,$p2))
			{ 
				$msg = "Erro|Não é permitido o envio de arquivos neste formato: '.".$temp2."'. Favor enviar um outro nas seguintes extensões: ".$p."";
			}
			else
			{
				if ($this->arquivo["size"] > 1024 * 1024)
				{
					$tamanho = round(($this->arquivo["size"] / 1024 / 1024), 2);
					$med = "MB";
				}
				else if ($this->arquivo["size"] > 1024)
				{
					$tamanho = round(($this->arquivo["size"] / 1024), 2);
					$med = "KB";
				}
				else
				{
					$tamanho = $this->arquivo["size"];
					$med = "Bytes";
				}

				/* tamanho máximo do arquivo em bytes: */

				if($this->arquivo["size"] > $this->tamanho_arquivo)
				{
					$msg =  "Erro|Seu arquivo possui: ".$tamanho." ".$med.". Arquivos maiores que ".round(($this->tamanho_arquivo / 1024 / 1024), 2)." MB não são permitidos.\n";
				}
				else
				{
					/* diretório destino do upload */
					if (is_file($this->arquivo["tmp_name"]))
					{
						//renomeia arquivo

						//trata nome
						$n_n = str_replace(" ","_",$this->arquivo["name"]);
						$n_n = str_replace("-","_",$n_n);
						$n_n = str_replace("á","a",$n_n);
						$n_n = str_replace("é","e",$n_n);
						$n_n = str_replace("í","i",$n_n);
						$n_n = str_replace("ó","o",$n_n);
						$n_n = str_replace("ú","u",$n_n);
						$n_n = str_replace("ç","c",$n_n);
						$n_n = str_replace("ã","a",$n_n);
						$n_n = str_replace("â","a",$n_n);
						$n_n = str_replace("õ","o",$n_n);
						$n_n = str_replace("!","",$n_n);
						$n_n = str_replace("?","",$n_n);
						$n_n = str_replace(":","",$n_n);
						$n_n = str_replace("[","",$n_n);
						$n_n = str_replace("]","",$n_n);
						$n_n = str_replace("(","",$n_n);
						$n_n = str_replace(")","",$n_n);

						if($novo_nome == "")
						{
							$novo_nome = rand(00000000,99999999)."_".strtolower($n_n);
						}
						else
						{
							$novo_nome = $novo_nome."_".$this->arquivo["name"];
						}

						$d = $this->destino.$novo_nome;

						if(move_uploaded_file($this->arquivo["tmp_name"], $d))
						{
							$msg = "Sucesso|Arquivo '".$this->arquivo["name"]."' enviado com sucesso.|".$novo_nome;
						}
						else
						{
							$msg = "Erro|Erro ao enviar arquivo '".$this->arquivo["name"]."'".'';
						}
					}
				}
			}
		}
		else
		{
			$msg = "Erro|Favor postar um arquivo.";
		}

		if($retorno == "n")
		{
			$msg = "0";
		}

		return $msg;
	}

	function upload_ftp()
	{
		$o_ajudante = new Ajudante;
		if($conn_id = ftp_connect($this->ftp_server))
		{
			// login 
			$login_resultado = ftp_login($conn_id, $this->ftp_usuario, $this->ftp_senha); 
		}
		else
		{
			echo "erro";
		}
		// check connection
		if ((!$conn_id) || (!$login_resultado))
		{
			$mensagem = $o_ajudante->mensagem(116);
			$mensagem_tratada = str_replace('[server]',$this->ftp_server,$mensagem);
			$mensagem_tratada = str_replace('[usuario]',$this->ftp_usuario,$mensagem_tratada);
			echo $mensagem_tratada."<br />";
			//echo $o_ajudante->mensagem(0,"t","Erro","Erro ao tentar se conectar a ".$this->ftp_server." pelo usuário ".$this->ftp_usuario.".","msg_erro");
			exit; 
		}
		else
		{
			// upload the file
			$upload = ftp_put($conn_id, $this->destino."/".$_FILES['arquivo']['name'], $_FILES['arquivo']['tmp_name'], FTP_BINARY); 
		
			if (!$upload)
			{ 
				$mensagem = $o_ajudante->mensagem(115);
				$mensagem_tratada = str_replace('[arquivo][name]',$_FILES['arquivo']['name'],$mensagem);
				echo $mensagem_tratada."<br />";
				//echo $o_ajudante->mensagem(0,"t","Erro","Status do envio do arquivo: O envio da imagem ".$_FILES['arquivo']['name']." falhou!")."<br />";
			}
			else
			{
				$mensagem = $o_ajudante->mensagem(114);
				$mensagem_tratada = str_replace('[arquivo][name]',$_FILES['arquivo']['name'],$mensagem);
				echo $mensagem_tratada."<br />";
				//echo $o_ajudante->mensagem(0,"t","SUCESSO!","Status de envio do arquivo: O arquivo <b> ".$_FILES['arquivo']['name']." </b> foi enviado com sucesso!")."<br />";
			}
			
			ftp_close($conn_id); 
		}
	}
}
?>
