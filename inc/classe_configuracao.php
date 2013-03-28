<?php
//print_r($_SERVER);
class Configuracao
{
	public function __construct()
	{
		$configuracao = Array();
	}

	public function ftp_server()
	{
		$configuracao["ftp_server"] = "ftp.shoppinggarden.com.br";
		return $configuracao["ftp_server"];
	}

	public function ftp_senha()
	{
		//$configuracao["ftp_senha"] = "shg2228";
		$configuracao["ftp_senha"] = "m1u2d3a4r5";
		return $configuracao["ftp_senha"];
	}

	public function ftp_usuario()
	{
		$configuracao["ftp_usuario"] = "shoppin";
		return $configuracao["ftp_usuario"];
	}

	public function ftp_endereco()
	{
		//$configuracao["ftp_endereco"] = "/scorpionmusic/Web/imagens/";
		$configuracao["ftp_endereco"] = "public_html/arte_doces/imagens/";
		return $configuracao["ftp_endereco"];
	}
	
	public function url_fisico()
	{
		//$configuracao["url_fisico"] = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
		//$configuracao["url_fisico"] = $_SERVER['DOCUMENT_ROOT']."/arte_doces/";
		$configuracao["url_fisico"] = $_SERVER['DOCUMENT_ROOT']."/arte_doces/";
		$configuracao["url_fisico"] = "/Applications/XAMPP/xamppfiles/htdocs/arte_doces/";
		//$configuracao["host"] = "mysql.iwi.com.br";
		return $configuracao["url_fisico"];
	}

	public function url_virtual()
	{
		//$configuracao["url_virtual"] = "http://".$_SERVER['HTTP_HOST']."/arte_doces/";
		$configuracao["url_virtual"] = "http://".$_SERVER['HTTP_HOST']."/arte_doces/";
		return $configuracao["url_virtual"];
	}

	public function host()
	{
		//$configuracao["host"] = "dbmy0057.whservidor.com";
		$configuracao["host"] = "localhost";
		return $configuracao["host"];
	}

	public function backup_path()
	{
		$configuracao["backup_path"] = $_SERVER['DOCUMENT_ROOT']."/arte_doces/imagens/backup/";
		return $configuracao["backup_path"];
	}

	public function banco_dados()
	{
		$configuracao["banco_dados"] = "arte_doces";
		//$configuracao["banco_dados"] = "hm2_01";
		return $configuracao["banco_dados"];
	}

	public function usuario()
	{
		$configuracao["usuario"] = "root";
		//$configuracao["usuario"] = "hm2";
		return $configuracao["usuario"];
	}

	public function senha()
	{
		$configuracao["senha"] = "";
		return $configuracao["senha"];
	}

	public function prefixo()
	{
		$configuracao["prefixo"] = "arte_doces";
		return $configuracao["prefixo"];
	}

	public function desenvolvedor()
	{
		$configuracao["desenvolvedor"] = "Kraken Digital";
		return $configuracao["desenvolvedor"];
	}

	public function desenvolvedor_email()
	{
		$configuracao["desenvolvedor_email"] = "alain.camacho@hm2.com.br";
		return $configuracao["desenvolvedor_email"];
	}

	public function desenvolvedor_site()
	{
		$configuracao["desenvolvedor_site"] = "hm2.com.br";
		return $configuracao["desenvolvedor_site"];
	}

	public function site_nome()
	{
		$configuracao["site_nome"] = "SHOPPING GARDEN";
		return $configuracao["site_nome"];
	}

	public function email_contato()
	{
		$configuracao["email_contato"] = "garden@shoppinggarden.com.br";   // email de contato
		//$configuracao["email_contato"] = "ton@agenciaguapa.com.br";   // email de contato
		return $configuracao["email_contato"];
	}
	
	public function email_envio_copia()
	{
		$configuracao["email_envio_copia"] = "alain.mcf@gmail.com";   
		return $configuracao["email_envio_copia"];
	}

	public function site_descricao()
	{
		$configuracao["site_descricao"] = "";
		return $configuracao["site_descricao"];
	}

	public function site_slogan()
	{
		$configuracao["site_slogan"] = "";
		return $configuracao["site_slogan"];
	}

	public function site_palavra_chave()
	{
		$configuracao["site_palavra_chave"] = "ilustracoes ilustracoes desenhos desenhista websites web sites web design grafico grafico design grafico paginas paginas";
		return $configuracao["site_palavra_chave"];
	}

	public function site_titulo()
	{
		$configuracao["site_titulo"] = "Shopping Garden";
		return $configuracao["site_titulo"];
	}

	public function site_autor()
	{
		$configuracao["site_autor"] = "Desenvolvido por HM2 : www.hm2.com.br - alain.camacho@hm2.com.br - designer programador : Alain Camacho";
		return $configuracao["site_autor"];
	}
}
?>