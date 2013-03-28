<?php
class Ajudante
{
	private $paramentro;

	function __constructor()
	{}

	function set($prop, $value)
	{
		$this->$prop = $value;
	}

	function trata_input($entrada)
	{
		if (get_magic_quotes_gpc())
		{
			$saida = stripslashes(trim($entrada));	 
		}
		else
		{
			$saida = trim($entrada);
		} 
		return $saida;
	}

	//função para codificar numeros enviados por url
	function codifica_numero($entrada,$codifica="s")
	{
		$saida = str_replace('0','CSXBLP',$entrada);
		$saida = str_replace('1','SYZRYE',$saida);
		$saida = str_replace('2','XUTBRY',$saida);
		$saida = str_replace('3','DAORIO',$saida);
		$saida = str_replace('4','RXSXWD',$saida);
		$saida = str_replace('5','YJXDTH',$saida);
		$saida = str_replace('6','OZQQTQ',$saida);
		$saida = str_replace('7','CQXSBS',$saida);
		$saida = str_replace('8','AORRTS',$saida);
		$saida = str_replace('9','TXEFQR',$saida);

		$codifica == "n"? $saida=$entrada : "";
		return $saida;
	}

	function decodifica_numero($entrada,$decodifica="n")
	{
		$saida = str_replace('CSXBLP','0',$entrada);
		$saida = str_replace('SYZRYE','1',$saida);
		$saida = str_replace('XUTBRY','2',$saida);
		$saida = str_replace('DAORIO','3',$saida);
		$saida = str_replace('RXSXWD','4',$saida);
		$saida = str_replace('YJXDTH','5',$saida);
		$saida = str_replace('OZQQTQ','6',$saida);
		$saida = str_replace('CQXSBS','7',$saida);
		$saida = str_replace('AORRTS','8',$saida);
		$saida = str_replace('TXEFQR','9',$saida);

		$decodifica == "n"? $saida=$entrada : "";
		return $saida;
	}

	function codifica_texto($entrada)
	{
		$saida = $entrada;
		switch(rand(1, 3))
		{
			case 1:
				$saida = str_replace('a','6L0808',$saida);
				$saida = str_replace('b','10X0FK',$saida);
				$saida = str_replace('c','R9HZ17',$saida);
				$saida = str_replace('d','8TR874',$saida);
				$saida = str_replace('e','1O8045',$saida);
				$saida = str_replace('f','JYD997',$saida);
				$saida = str_replace('g','VAK9P0',$saida);
				$saida = str_replace('h','KKAFIA',$saida);
				$saida = str_replace('i','KD7H48',$saida);
				$saida = str_replace('j','7VCIV0',$saida);
				$saida = str_replace('k','R579T7',$saida);
				$saida = str_replace('l','DZ001O',$saida);
				$saida = str_replace('m','31Z42N',$saida);
				$saida = str_replace('n','I6TF9H',$saida);
				$saida = str_replace('o','G5H869',$saida);
				$saida = str_replace('p','B5W410',$saida);
				$saida = str_replace('q','0Q3677',$saida);
				$saida = str_replace('r','1415I5',$saida);
				$saida = str_replace('s','50BSGP',$saida);
				$saida = str_replace('t','2C323M',$saida);
				$saida = str_replace('u','MQ0TYI',$saida);
				$saida = str_replace('v','E22IX7',$saida);
				$saida = str_replace('x','P01557',$saida);
				$saida = str_replace('y','P00557',$saida);
				$saida = str_replace('z','66P57Y',$saida);
				$saida = str_replace(' ','QBW8WL',$saida);

				$randomico = 1;
			break;

			case 2:
				$saida = str_replace('a','5CBW48',$saida);
				$saida = str_replace('b','234Z4Z',$saida);
				$saida = str_replace('c','283R4H',$saida);
				$saida = str_replace('d','UN6GED',$saida);
				$saida = str_replace('e','47FTE0',$saida);
				$saida = str_replace('f','8Z53P8',$saida);
				$saida = str_replace('g','8I2L5C',$saida);
				$saida = str_replace('h','KH6F04',$saida);
				$saida = str_replace('i','S0QE10',$saida);
				$saida = str_replace('j','S0MLZI',$saida);
				$saida = str_replace('k','S5BQS5',$saida);
				$saida = str_replace('l','PC7U2F',$saida);
				$saida = str_replace('m','RT2OYL',$saida);
				$saida = str_replace('n','711A5V',$saida);
				$saida = str_replace('o','230TOL',$saida);
				$saida = str_replace('p','09M8SY',$saida);
				$saida = str_replace('q','391933',$saida);
				$saida = str_replace('r','BEM0KG',$saida);
				$saida = str_replace('s','ONHW1V',$saida);
				$saida = str_replace('t','Q6Y34P',$saida);
				$saida = str_replace('u','6R22OS',$saida);
				$saida = str_replace('v','5D5546',$saida);
				$saida = str_replace('x','5F7946',$saida);
				$saida = str_replace('y','N3D3I2',$saida);
				$saida = str_replace('z','7VOO45',$saida);
				$saida = str_replace(' ','GD3OS0',$saida);

				$randomico = 2;
			break;

			case 3:
				$saida = str_replace('a','1O8KVE',$saida);
				$saida = str_replace('b','15ER0K',$saida);
				$saida = str_replace('c','B82V15',$saida);
				$saida = str_replace('d','65GIXK',$saida);
				$saida = str_replace('e','CROE43',$saida);
				$saida = str_replace('f','G8E411',$saida);
				$saida = str_replace('g','KV0N8D',$saida);
				$saida = str_replace('h','Z50UX3',$saida);
				$saida = str_replace('i','U7O41J',$saida);
				$saida = str_replace('j','D321W3',$saida);
				$saida = str_replace('k','Y06UY8',$saida);
				$saida = str_replace('l','NA51S9',$saida);
				$saida = str_replace('m','67G2BH',$saida);
				$saida = str_replace('n','7H66HY',$saida);
				$saida = str_replace('o','T92MG0',$saida);
				$saida = str_replace('p','63AOG4',$saida);
				$saida = str_replace('q','7RS5FE',$saida);
				$saida = str_replace('r','161GL0',$saida);
				$saida = str_replace('s','6OCV71',$saida);
				$saida = str_replace('t','S31TNP',$saida);
				$saida = str_replace('u','C6825B',$saida);
				$saida = str_replace('v','F59UHO',$saida);
				$saida = str_replace('x','87W5MS',$saida);
				$saida = str_replace('y','J1IA46',$saida);
				$saida = str_replace('z','6O74E8',$saida);
				$saida = str_replace(' ','Z992W5',$saida);

				$randomico = 3;
			break;
		}
		return $saida."08XX8XX7XXZZ0".$randomico;
	}

	function decodifica_texto($entrada)
	{
		$separa = explode("08XX8XX7XXZZ0",$entrada);
		$saida = $separa[0];
		switch($separa[1])
		{
			case 1:
				$saida = str_replace('6L0808','a',$saida);
				$saida = str_replace('10X0FK','b',$saida);
				$saida = str_replace('R9HZ17','c',$saida);
				$saida = str_replace('8TR874','d',$saida);
				$saida = str_replace('1O8045','e',$saida);
				$saida = str_replace('JYD997','f',$saida);
				$saida = str_replace('VAK9P0','g',$saida);
				$saida = str_replace('KKAFIA','h',$saida);
				$saida = str_replace('KD7H48','i',$saida);
				$saida = str_replace('7VCIV0','j',$saida);
				$saida = str_replace('R579T7','k',$saida);
				$saida = str_replace('DZ001O','l',$saida);
				$saida = str_replace('31Z42N','m',$saida);
				$saida = str_replace('I6TF9H','n',$saida);
				$saida = str_replace('G5H869','o',$saida);
				$saida = str_replace('B5W410','p',$saida);
				$saida = str_replace('0Q3677','q',$saida);
				$saida = str_replace('1415I5','r',$saida);
				$saida = str_replace('50BSGP','s',$saida);
				$saida = str_replace('2C323M','t',$saida);
				$saida = str_replace('MQ0TYI','u',$saida);
				$saida = str_replace('E22IX7','v',$saida);
				$saida = str_replace('P01557','x',$saida);
				$saida = str_replace('P00557','y',$saida);
				$saida = str_replace('66P57Y','z',$saida);
				$saida = str_replace('QBW8WL',' ',$saida);
			break;

			case 2:
				$saida = str_replace('5CBW48','a',$saida);
				$saida = str_replace('234Z4Z','b',$saida);
				$saida = str_replace('283R4H','c',$saida);
				$saida = str_replace('UN6GED','d',$saida);
				$saida = str_replace('47FTE0','e',$saida);
				$saida = str_replace('8Z53P8','f',$saida);
				$saida = str_replace('8I2L5C','g',$saida);
				$saida = str_replace('KH6F04','h',$saida);
				$saida = str_replace('S0QE10','i',$saida);
				$saida = str_replace('S0MLZI','j',$saida);
				$saida = str_replace('S5BQS5','k',$saida);
				$saida = str_replace('PC7U2F','l',$saida);
				$saida = str_replace('RT2OYL','m',$saida);
				$saida = str_replace('711A5V','n',$saida);
				$saida = str_replace('230TOL','o',$saida);
				$saida = str_replace('09M8SY','p',$saida);
				$saida = str_replace('391933','q',$saida);
				$saida = str_replace('BEM0KG','r',$saida);
				$saida = str_replace('ONHW1V','s',$saida);
				$saida = str_replace('Q6Y34P','t',$saida);
				$saida = str_replace('6R22OS','u',$saida);
				$saida = str_replace('5D5546','v',$saida);
				$saida = str_replace('5F7946','x',$saida);
				$saida = str_replace('N3D3I2','y',$saida);
				$saida = str_replace('7VOO45','z',$saida);
				$saida = str_replace('GD3OS0',' ',$saida);
			break;

			case 3:
				$saida = str_replace('1O8KVE','a',$saida);
				$saida = str_replace('15ER0K','b',$saida);
				$saida = str_replace('B82V15','c',$saida);
				$saida = str_replace('65GIXK','d',$saida);
				$saida = str_replace('CROE43','e',$saida);
				$saida = str_replace('G8E411','f',$saida);
				$saida = str_replace('KV0N8D','g',$saida);
				$saida = str_replace('Z50UX3','h',$saida);
				$saida = str_replace('U7O41J','i',$saida);
				$saida = str_replace('D321W3','j',$saida);
				$saida = str_replace('Y06UY8','k',$saida);
				$saida = str_replace('NA51S9','l',$saida);
				$saida = str_replace('67G2BH','m',$saida);
				$saida = str_replace('7H66HY','n',$saida);
				$saida = str_replace('T92MG0','o',$saida);
				$saida = str_replace('63AOG4','p',$saida);
				$saida = str_replace('7RS5FE','q',$saida);
				$saida = str_replace('161GL0','r',$saida);
				$saida = str_replace('6OCV71','s',$saida);
				$saida = str_replace('S31TNP','t',$saida);
				$saida = str_replace('C6825B','u',$saida);
				$saida = str_replace('F59UHO','v',$saida);
				$saida = str_replace('87W5MS','x',$saida);
				$saida = str_replace('J1IA46','y',$saida);
				$saida = str_replace('6O74E8','z',$saida);
				$saida = str_replace('Z992W5',' ',$saida);
			break;
		}
		return $saida;
	}

	function html_header($titulo,$css,$js,$css_body="corpo-")
	{
		return $resultado = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<title>".$titulo."</title>
		<script type=\"text/javascript\" charset=\"utf-8\" src=\"../gc/pagina/m/js/jquery.js\"></script>
		<link href=\"".$css."\" rel=\"stylesheet\" type=\"text/css\">
		<script src=\"".$js."\"></script>
		</head>
		<body class=\"".$css_body."\">";
	}

	function html_header_02($titulo,$css,$js,$css_body="corpo-2", $acao_adm)
	{
		$o_configuracao = new Configuracao;
		
		return $resultado = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<title>".$titulo."</title>
		<link href=\"".$css."\" rel=\"stylesheet\" type=\"text/css\">

		<style type=\"text/css\" title=\"currentStyle\">
			@import \"".$o_configuracao->url_virtual()."gc/pagina/m/css/demo_page.css\";
			@import \"".$o_configuracao->url_virtual()."gc/pagina/m/css/demo_table_jui.css\";
			@import \"".$o_configuracao->url_virtual()."gc/pagina/themes/smoothness/jquery-ui-1.8.4.custom.css\";
			@import \"".$o_configuracao->url_virtual()."gc/pagina/media/css/TableTools_JUI.css\";
		</style>

		<script type=\"text/javascript\" charset=\"utf-8\" src=\"".$o_configuracao->url_virtual()."gc/pagina/m/js/jquery.js\"></script>
		<script type=\"text/javascript\" charset=\"utf-8\" src=\"".$o_configuracao->url_virtual()."gc/pagina/m/js/jquery.dataTables.js\"></script>
		<script type=\"text/javascript\" charset=\"utf-8\" src=\"".$o_configuracao->url_virtual()."gc/pagina/media/js/ZeroClipboard.js\"></script>
		<script type=\"text/javascript\" charset=\"utf-8\" src=\"".$o_configuracao->url_virtual()."gc/pagina/media/js/TableTools.js\"></script>

		<script type=\"text/javascript\" src=\"".$o_configuracao->url_virtual()."inc/fancybox/jquery.mousewheel-3.0.4.pack.js\"></script>
		<script type=\"text/javascript\" src=\"".$o_configuracao->url_virtual()."inc/fancybox/jquery.fancybox-1.3.4.pack.js\"></script>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"".$o_configuracao->url_virtual()."inc/fancybox/jquery.fancybox-1.3.4.css\" media=\"screen\" />

		<script src=\"".$js."\"></script>

		<script type=\"text/javascript\" charset=\"utf-8\">
		$(document).ready( function () {
			var oTable = $('#example').dataTable( {
				\"bJQueryUI\": true,
				\"bProcessing\": true,
				\"bServerSide\": false,
				\"iDisplayLength\": 20,  
				\"sPaginationType\": \"full_numbers\"
			} );
		} );
	</script>
		</head>
		<body class=\"".$css_body."\">";
	}

	function html_footer()
	{
		return $resultado = "
		</body>
		</html>";
	}

	function ftp_02($ftp_server,$ftp_user_name,$ftp_user_pass,$arquivo_destino)
	{
		$conn_id = ftp_connect($ftp_server); 

		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

		// check connection
		if ((!$conn_id) || (!$login_result))
		{ 
			echo $this->aviso("msg_erro","Erro","Erro ao tentar se conectar a ".$ftp_server." pelo usuário ".$ftp_user_name.".");
			exit; 
		}
		else
		{
			// upload the file
			$upload = ftp_put($conn_id, $arquivo_destino."/".$_FILES['arquivo']['name'], $_FILES['arquivo']['tmp_name'], FTP_BINARY); 
			if (!$upload)
			{ 
				echo $this->aviso("msg_erro","Status do envio do arquivo","O envio da imagem ".$_FILES['arquivo']['name']." falhou!");
			}
			else
			{
				echo $this->aviso("msg_sucesso","Status do envio do arquivo","O arquivo <b> ".$_FILES['arquivo']['name']." </b> foi enviado com sucesso.");
			}
			ftp_close($conn_id); 
		}
	}

	function trata_texto_01($string)
	{
		$string = trim($string); 
		// Remove os acentos 
		$string = str_replace("$","-", $string); 
		$string = str_replace("%","-", $string); 
		$string = str_replace("~","-", $string); 
		$string = str_replace("^","-", $string); 
		$string = str_replace("º","-", $string); 
		$string = str_replace("º","-", $string); 
		$string = str_replace(" ","-", $string); 
		$string = str_replace("ª","-", $string);
		$string = str_replace(" & ", "-", $string);
		$string = str_replace("&", "-", $string);
		$string = str_replace("'", "-", $string); 
		$string = str_replace("\"", "-", $string); 
		$string = str_replace("<", "-", $string); 
		$string = str_replace(">", "-", $string); 
		$string = str_replace("À", "a", $string); 
		$string = str_replace("Á", "a", $string); 
		$string = str_replace("Â", "a", $string); 
		$string = str_replace("Ã", "a", $string); 
		$string = str_replace("Ä", "a", $string); 
		$string = str_replace("Å", "a", $string); 
		$string = str_replace("Æ", "ae", $string); 
		$string = str_replace("Ç", "c", $string); 
		$string = str_replace("È", "e", $string); 
		$string = str_replace("É", "e", $string); 
		$string = str_replace("Ê", "e", $string); 
		$string = str_replace("Ë", "e", $string); 
		$string = str_replace("Ì", "i", $string); 
		$string = str_replace("Í", "i", $string); 
		$string = str_replace("Î", "i", $string); 
		$string = str_replace("Ï", "i", $string); 
		$string = str_replace("Ð", "d", $string); 
		$string = str_replace("Ñ", "n", $string); 
		$string = str_replace("Ò", "o", $string); 
		$string = str_replace("Ó", "o", $string); 
		$string = str_replace("Ô", "o", $string); 
		$string = str_replace("Õ", "o", $string); 
		$string = str_replace("Ö", "o", $string); 
		$string = str_replace("Ø", "o", $string); 
		$string = str_replace("Ù", "o", $string); 
		$string = str_replace("Ú", "u", $string); 
		$string = str_replace("Û", "u", $string); 
		$string = str_replace("Ü", "u", $string); 
		$string = str_replace("Ý", "y", $string); 
		$string = str_replace("Þ", "a", $string); 
		$string = str_replace("ß", "b", $string); 
		$string = str_replace("à", "a", $string); 
		$string = str_replace("á", "a", $string); 
		$string = str_replace("â", "a", $string); 
		$string = str_replace("ã", "a", $string); 
		$string = str_replace("ä", "a", $string); 
		$string = str_replace("å", "a", $string); 
		$string = str_replace("æ", "ae", $string); 
		$string = str_replace("ç", "c", $string); 
		$string = str_replace("è", "e", $string); 
		$string = str_replace("é", "e", $string); 
		$string = str_replace("ê", "e", $string); 
		$string = str_replace("ë", "e", $string); 
		$string = str_replace("ì", "i", $string); 
		$string = str_replace("í", "i", $string); 
		$string = str_replace("î", "i", $string); 
		$string = str_replace("ï", "i", $string); 
		$string = str_replace("ð", "o", $string); 
		$string = str_replace("ñ", "n", $string); 
		$string = str_replace("ò", "o", $string); 
		$string = str_replace("ó", "o", $string); 
		$string = str_replace("ô", "o", $string); 
		$string = str_replace("õ", "o", $string); 
		$string = str_replace("ö", "o", $string); 
		$string = str_replace("ø", "o", $string); 
		$string = str_replace("ù", "u", $string); 
		$string = str_replace("ú", "u", $string); 
		$string = str_replace("û", "u", $string); 
		$string = str_replace("ü", "u", $string); 
		$string = str_replace("ý", "y", $string); 
		$string = str_replace("þ", "p", $string); 
		$string = str_replace("ÿ", "y", $string);
		return $string;
	}
	
	function trata_texto_01_url_amigavel($string)
	{
		$string = trim($string); 
		// Remove os acentos 
		$string = str_replace(",","_", $string); 
		$string = str_replace(".","_", $string); 
		$string = str_replace("|","_", $string); 
		$string = str_replace("+","_", $string); 
		$string = str_replace("$","_", $string); 
		$string = str_replace("%","_", $string); 
		$string = str_replace("~","_", $string); 
		$string = str_replace("^","_", $string); 
		$string = str_replace("º","_", $string); 
		$string = str_replace("º","_", $string); 
		$string = str_replace(" ","_", $string); 
		$string = str_replace("ª","_", $string);
		$string = str_replace(" & ", "_", $string);
		$string = str_replace("&", "_", $string);
		$string = str_replace("'", "_", $string); 
		$string = str_replace("\"", "_", $string); 
		$string = str_replace("<", "_", $string); 
		$string = str_replace(">", "_", $string); 
		$string = str_replace("__", "_", $string); 
		$string = str_replace("___", "_", $string); 
		$string = str_replace("À", "a", $string); 
		$string = str_replace("Á", "a", $string); 
		$string = str_replace("Â", "a", $string); 
		$string = str_replace("Ã", "a", $string); 
		$string = str_replace("Ä", "a", $string); 
		$string = str_replace("Å", "a", $string); 
		$string = str_replace("Æ", "ae", $string); 
		$string = str_replace("Ç", "c", $string); 
		$string = str_replace("È", "e", $string); 
		$string = str_replace("É", "e", $string); 
		$string = str_replace("Ê", "e", $string); 
		$string = str_replace("Ë", "e", $string); 
		$string = str_replace("Ì", "i", $string); 
		$string = str_replace("Í", "i", $string); 
		$string = str_replace("Î", "i", $string); 
		$string = str_replace("Ï", "i", $string); 
		$string = str_replace("Ð", "d", $string); 
		$string = str_replace("Ñ", "n", $string); 
		$string = str_replace("Ò", "o", $string); 
		$string = str_replace("Ó", "o", $string); 
		$string = str_replace("Ô", "o", $string); 
		$string = str_replace("Õ", "o", $string); 
		$string = str_replace("Ö", "o", $string); 
		$string = str_replace("Ø", "o", $string); 
		$string = str_replace("Ù", "o", $string); 
		$string = str_replace("Ú", "u", $string); 
		$string = str_replace("Û", "u", $string); 
		$string = str_replace("Ü", "u", $string); 
		$string = str_replace("Ý", "y", $string); 
		$string = str_replace("Þ", "a", $string); 
		$string = str_replace("ß", "b", $string); 
		$string = str_replace("à", "a", $string); 
		$string = str_replace("á", "a", $string); 
		$string = str_replace("â", "a", $string); 
		$string = str_replace("ã", "a", $string); 
		$string = str_replace("ä", "a", $string); 
		$string = str_replace("å", "a", $string); 
		$string = str_replace("æ", "ae", $string); 
		$string = str_replace("ç", "c", $string); 
		$string = str_replace("è", "e", $string); 
		$string = str_replace("é", "e", $string); 
		$string = str_replace("ê", "e", $string); 
		$string = str_replace("ë", "e", $string); 
		$string = str_replace("ì", "i", $string); 
		$string = str_replace("í", "i", $string); 
		$string = str_replace("î", "i", $string); 
		$string = str_replace("ï", "i", $string); 
		$string = str_replace("ð", "o", $string); 
		$string = str_replace("ñ", "n", $string); 
		$string = str_replace("ò", "o", $string); 
		$string = str_replace("ó", "o", $string); 
		$string = str_replace("ô", "o", $string); 
		$string = str_replace("õ", "o", $string); 
		$string = str_replace("ö", "o", $string); 
		$string = str_replace("ø", "o", $string); 
		$string = str_replace("ù", "u", $string); 
		$string = str_replace("ú", "u", $string); 
		$string = str_replace("û", "u", $string); 
		$string = str_replace("ü", "u", $string); 
		$string = str_replace("ý", "y", $string); 
		$string = str_replace("þ", "p", $string); 
		$string = str_replace("ÿ", "y", $string);
		return $string;
	}

	function ajuda($texto_ajuda)
	{
		?>
		&nbsp;&nbsp;<a class=ajuda href="#"><img src='../imagens/gc/btn_ajuda.png' align='absmiddle'><span><?=$texto_ajuda?></span></a>
		<?php
	}

	function menu_pc($btns,$links,$alvo,$separador,$acao)
	{
		$btns_titulos = explode(",", $btns);
		$btns_links = explode(",", $links);
		$alvo = explode(",", $alvo);
		$number = count($btns_titulos);
		$x = 0;
		while ($x < $number)
		{
			if(($x+1) >= $number)
			{
				$separador = "";
			}
			else
			{
				$separador = " ".$separador." ";
			}
			if($alvo[$x] == "pop")
			{
				$m = "<a href='#' onclick=\"window.open('".$btns_links[$x]."','','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=300,height=300')\">".$btns_titulos[$x]."</a>  ".$separador."";
			}
			else
			{
				$m .=  " <a href='".$btns_links[$x]."' target='".$alvo[$x]."'>".$btns_titulos[$x]."</a>  ".$separador;
			}
			$x++;
		}
		return $m;
	}

	function drop_varios($array, $nome, $quero, $onclick, $option, $class)
	{
		sort($array);
		$resultado = "<select class='".$class."' name=\"".$nome."\" id=\"".$nome."\" size=\"1\" onchange=\"".$onclick."\">";
		$resultado .= $option;
		foreach ($array as $e)
		{
			$e = trim($e);
			if ($e == $quero)
			{
				$selecionar =" selected ";
			}
			else
			{
				$selecionar=" ";
			}
			$resultado .= "<option".$selecionar."value='".$e."'>".$e."</option>\n";
		} 
		$resultado .= "</select>";
		return $resultado;
	}

	function barrado($ambiente)
	{
		//número 3 abaixo é nome de ambiente
		if(in_array($ambiente,$_SESSION['grupo_ambientes']))
		{
			//echo "pode entrar";
		}
		else
		{
			$msg = $this->mensagem(74);
			die($msg);
		}
	}

	function template($nome_aquivo)
	{
		
		if (!file_exists($nome_aquivo))//verifica se arquivo existe
		{
			$resultado = "arquivo ".$nome_aquivo." não existe";
		}
		else
		{
			$file_array = file($nome_aquivo);//poe texto do arquivo em um array
			$resultado = implode("", $file_array);//achata array
			if (empty($resultado))
			{
				$resultado = "arquivo ".$nome_aquivo." vazio.";
			}
		}
		return $resultado;
	}

	function email_html($titulo,$mensagem,$de,$para,$template)
	{
		//$quebra_linha = "\r\n";
		$quebra_linha = "\n";//linux
		$cabecalho = "From: ".$de.$quebra_linha;
		$cabecalho .= "BCC: ".$de.$quebra_linha;
		$cabecalho .= "MIME-Version: 1.0".$quebra_linha;
		$cabecalho .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
		//$cabecalho = "From: ".$de.$quebra_linha;
		$cabecalho .= "Reply-To: ".$de.$quebra_linha;

		$o_configuracao = new Configuracao;
		$cabecalho .= "BCC: ".$o_configuracao->email_envio_copia().$quebra_linha;

		$msg = $this->template($template);
		$msg = str_replace("[email_contato]",$de,$msg);
		$msg = str_replace("[site_titulo]",$o_configuracao->site_nome(),$msg);
		$msg = str_replace("[site_url]",$o_configuracao->url_virtual(),$msg);
		$msg = str_replace("[corpo]",$mensagem,$msg);
		
		if(!mail($para, $titulo, $msg, $cabecalho ,"-r".$de)){ // Se for Postfix
			$cabecalho .= "Return-Path: " . $para . $de; // Se "não for Postfix"
			if(mail($para, $titulo, $msg, $cabecalho ))
			{
				$msg = true;
			}
			else
			{
				$msg = false;
			}
		}
		else
		{
			$msg = true;
		}

		return  $msg;
	}

	function email_html_2($titulo,$mensagem,$de,$para,$comcopiaoculta,$template)
	{
		$comcopia = '';
		//$comcopiaoculta = $cco;

		if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
		elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
		else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
		
		/* Montando o cabeçalho da mensagem */
		$headers = "MIME-Version: 1.0".$quebra_linha;
		$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
		$headers .= "From: ".$de.$quebra_linha;
		$headers .= "CC: ".$de.$quebra_linha;
		$headers .= "Return-Path: " . $de . $quebra_linha;
		if(strlen($comcopia) > 0) $headers .= "Cc: ".$comcopia.$quebra_linha;
		if(strlen($comcopiaoculta) > 0) $headers .= "Bcc: ".$comcopiaoculta.$quebra_linha;
		$headers .= "Reply-To: ".$de.$quebra_linha;

		$msg = $this->template($template);

		if(mail($para,$titulo,$msg,$headers, "-r" .$de))
		{
			$resultado = true;
		}
		else
		{
			$resultado = false;
		}
		return  $resultado;
	}

	function envia_senha($usuario_id)
	{
		$o_configuracao = new Configuracao;
		$o_usuario = new Usuario;

		//cria nova senha
		$nova_senha = rand(000000,999999);

		//Altera a senha
		$o_usuario->set('senha',$this->cria_senha($nova_senha));
		$o_usuario->set('id',$usuario_id);
		$o_usuario->editar_senha();
		if($rs = $o_usuario->selecionar())
		{
			foreach($rs as $l)
			{
				$msg = "<br />Um envio de senha foi solicitado para o site da ".$o_configuracao->site_nome().".<br /> Abaixo seguem os dados:\n<br /><br /><b>Seu e-mail</b>: ".$l["email"]."\n<br /><b>Sua nova senha</b>: ".$nova_senha."\n\n<br /><br />A senha acima foi gerada pelo administrador do sistema.<br /><br />Para acessar o site agora clique no link:  <a href=\"".$o_configuracao->url_virtual().">aqui</a> e utilize os dados acima para se identificar.";
				$this->email_html("".$o_configuracao->site_nome()." - Envio de senha",$msg,$o_configuracao->email_contato(),$l["email"],"../templates/template_mailing.htm");
			}
		}

		return $mensagem;
		unset($o_configuracao);
		unset($o_usuario);
	}

	function cria_senha($senha)
	{
		$senha = trim($senha);
		$senha = str_replace(" ", "", $senha);
		$senha = strtolower($senha);
		$senha = str_replace("ç", "c", $senha);
		$senha = str_replace("ó", "o", $senha);
		$senha = str_replace("í", "i", $senha);
		$senha = str_replace("ã", "a", $senha);
		$senha = str_replace("õ", "o", $senha);
		$senha = str_replace("â", "a", $senha);
		$senha = sha1($senha);

		return $senha;
	}

	function btn_img($texto,$link,$btn,$pop)
	{
		if($pop == "1")
		{
			$tipo_link = "javascript:abre_janela('$link','geral','scrollbars=yes,width=300,height=300')";
		}
		else
		{
			$tipo_link = $link;
		}
		$btn = "&nbsp;&nbsp;<a class=ajuda href=\"".$tipo_link."\"><img src=\"../imagens/gc/".$btn."\" align=\"absmiddle\"><span>".$texto."</span></a>";
		return $btn;
	}

	function pop_up($title, $pic, $thumbnail, $texto_sem_imagem)
	{
		$size = GetImageSize($pic);
		$width = $size[0];
		$height = $size[1];
		$monta_pop =  "<a href=\"#\" onClick=\"window.open('";
		$monta_pop .= "../utilitarios/imagem_pop.php?z=".$pic."&width=".$width."&height=".$height."&title=".$title."','imagem_pop','width=".$width.",height=".$height.",directories=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,resizable=no,left=0,top=0,screenx=50,screeny=50');return false\">";
		if($thumbnail != "" && $thumbnail != "none")
		{
			$monta_pop .= "<img src=\"".$thumbnail."\" alt=\"Clique para ampliar: ".$title."\"></a> ";
		}
		else
		{
			$monta_pop .= $texto_sem_imagem."</a>";
		}
		return $monta_pop;
	}

	function mensagem_02($id=0,$tipo="t",$titulo="",$corpo="",$classe="msg_neutra",$fonte_tamanho="20",$fonte_cor_fundo="ffffff",$fonte_cor="069",$img="")
	{
		$o_mensagem = new Mensagem;
		$o_mensagem->set('id',$id);
		if($rs = $o_mensagem->selecionar())
		{
			foreach ($rs as $l)
			{
				$mensagem = strtoupper($l["nome"])." - ".$l["corpo"];
			
			}
		}

		unset($o_mensagem);
		return $mensagem;
	}

	function mensagem($id=0,$tipo="t",$titulo="",$corpo="",$classe="msg_neutra",$fonte_tamanho="20",$fonte_cor_fundo="ffffff",$fonte_cor="069",$img="")
	{
		$o_configuracao = new Configuracao;
		$url_virtual = $o_configuracao->url_virtual();
		if($id==0)
		{
			if($tipo == "t")
			{
				$mensagem = "
				<div class=\"".$classe."\">
				<span>
				<h1>".$titulo."</h1>
				<h2>".$img.$corpo."</h2>
				</span>
				</div>";
			}
			if($tipo == "f")
			{
				$mensagem = "
				<div class=\"".$classe."\">
				<h1>".$titulo."</h1>
				<h2>".$corpo."</h2>
				</div>";
			}
			else
			{
				$mensagem = "
				<div class=\"".$classe."\">
				<span>
				<img title=\"".$titulo."\" alt=\"".$l["nome"]."\" src=\"".$url_virtual."utilitarios/dtr.php?fonte_cor_fundo=".$fonte_cor_fundo."&fonte_tamanho=".$fonte_tamanho."&fonte_cor=".$fonte_cor."&text=".$titulo." &nbsp;\" />
				<br />
				<br />
				<h2>
				".$img.$corpo."
				</h2>
				</span>
				</div>";
			}
		}
		else
		{
			$o_mensagem = new Mensagem;
			$o_mensagem->set('id',$id);
			if($rs = $o_mensagem->selecionar())
			{
				foreach ($rs as $l)
				{
					if($tipo == "t")
					{
						$mensagem = "
						<div class=\"".$l["tipo"]."\">
						<span>
						<h1>".$l["nome"]."</h1>
						<h2>".nl2br($l["corpo"])."</h2>
						</span>
						</div>";
					}
					if ($tipo == "index")
					{
						$mensagem = "<div class=\"msg_index\">".nl2br($l["corpo"])."</div>";
					}
					else
					{
						$mensagem = "
						<div class=\"".$classe."\">
						<span>
						<img title=\"".$l["nome"]."\" alt=\"".$l["nome"]."\" src=\"../utilitarios/dtr.php?fonte_cor_fundo=".$fonte_cor_fundo."&fonte_tamanho=".$fonte_tamanho."&fonte_cor=".$fonte_cor."&text=".$l["nome"]." &nbsp;\" />
						<h2>
						".$l["corpo"]."
						</h2>
						</span>
						</div>";
						$mensagem .= "<br />";
					}
				}
			}
		}
		unset($o_mensagem);
		return $mensagem;
	}

	function imagem_ajax($title,$pic,$thumbnail,$div_mostra="div_mostra_imagem")
	{
		$size = GetImageSize($pic);
		$width = $size[0];
		$height = $size[1];
		//$monta_pop = "<a href=\"javascript:ajaxHTML(document.getElementById('".$div_mostra."').id,'../inc/busca_ajax.php?div=".$div_mostra."&altura=600&tipo=mostra_imagem&parametro=".$pic."');\"><img id=\"imagem_ilustra\" src=\"".$thumbnail."\" alt=\"Clique para ampliar: ".$title."\"></a>";
		$monta_pop = "<a href=\"".$pic."\" rel=\"lightbox\" title=\"".$title."\"><img id=\"imagem_ilustra\" src=\"".$thumbnail."\" alt=\"Clique para ampliar: ".$title."\"></a>";
		return $monta_pop;
	}

	function editar($alt,$link)
	{
		if($_SESSION["usuario_usuario"])
		{
			//$btn =  "<a href=\"".$link."\"><img title=\"".$alt."\" alt=\"".$alt."\" src=\"../imagens/site/btn_editar.png\"><a>";
			$btn =  "<a title=\"".$alt."\" href=\"".$link."\">[ e ]</a>";
		}
		else
		{
			$btn = "";
		}
		return $btn;
	}

	function sub_menu_gc($btns,$links,$area)
	{
		$sub_menu_gc = "
		<div id=\"conteudo_sub_menu\" class=\"conteudo_sub_menu\">
		<strong>".$area.": </strong>";

		$z = 1;
		$btns_titulos = explode(",", $btns);
		$btns_links = explode(",", $links);
		for ($x = 0; $x < count($btns_titulos); $x++)
		{
			if(count($btns_titulos) <= $z)
			{
				$separador = "";
			}
			else
			{
				$separador = " | ";
			}
			$sub_menu_gc .= "<a href='".$_SERVER["PHP_SELF"]."?".$btns_links[$x]."'>".$btns_titulos[$x]."</a>".$separador;
			$z++;
		}
		$sub_menu_gc .= "
		</div>
		";
		return $sub_menu_gc;
	}

	function informativo()
	{
		$form_informativo = "<form name=\"informativo\" method=\"post\" onSubmit=\"return abre_info()\" >
		Receba nosso informativo <input name=\"_info_email\" type=\"text\" id=\"_info_email\" onFocus=\"value=''\" value=\"seu email\" size=\"22\" maxlength=\"80\">
		<input name=\"ok\" type=\"submit\" onClick=\"informativo.info.value='inserido'\" value=\"Assinar\" title=\"Assinar\">
		<input name=\"info\" type=\"hidden\">
		</form>";
		return $form_informativo;
	}

	function data_hora()
	{
		return date("d/m/Y H:i:s");
	}

	function trata_data($data)
	{
		$array_data = explode("/", $data);
		$data_tratada = "".$array_data[2]."-".$array_data[1]."-".$array_data[0];
		return $data_tratada;
	}

	function data()
	{
		$mes = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
		$numero_mes = (date("m"))-1;
		return (date("d"))." de ". $mes[$numero_mes] ." de ". (date("Y")) ." - ". (date("H:i"))."Hs";
	}

	function codifica($entrada)
	{
		$entrada = str_replace(0,"ZNEWDEF",$entrada);
		$entrada = str_replace(1,"OJKFGT",$entrada);
		$entrada = str_replace(2,"MSX",$entrada);
		$entrada = str_replace(3,"YTAFGT",$entrada);
		$entrada = str_replace(4,"IGWFTTGJK",$entrada);
		$entrada = str_replace(5,"BUQOKIUJ",$entrada);
		$entrada = str_replace(6,"CZD",$entrada);
		$entrada = str_replace(7,"HXPYTGYEYJY",$entrada);
		$entrada = str_replace(8,"FYYR",$entrada);
		$entrada = str_replace(9,"VWLEFGUGRF",$entrada);
		return $entrada;
	}

	function decodifica($entrada)
	{
		$entrada = str_replace("ZNEWDEF",0,$entrada);
		$entrada = str_replace("OJKFGT",1,$entrada);
		$entrada = str_replace("MSX",2,$entrada);
		$entrada = str_replace("YTAFGT",3,$entrada);
		$entrada = str_replace("IGWFTTGJK",4,$entrada);
		$entrada = str_replace("BUQOKIUJ",5,$entrada);
		$entrada = str_replace("CZD",6,$entrada);
		$entrada = str_replace("HXPYTGYEYJY",7,$entrada);
		$entrada = str_replace("FYYR",8,$entrada);
		$entrada = str_replace("VWLEFGUGRF",9,$entrada);
		return $entrada;
	}

	function verifica_email($email)
	{ 
		$mail_correcto = 0; 
		//verifico umas coisas 
		if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@"))
		{
			if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," ")))
			{
				//vejo se tem caracter . 
				if (substr_count($email,".")>= 1)
				{
					//obtenho a terminação do dominio 
					$term_dom = substr(strrchr ($email, '.'),1); 
					//verifico que a terminação do dominio seja correcta 
					if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) )
					{
						//verifico que o de antes do dominio seja correcto 
						$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
						$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
						if ($caracter_ult != "@" && $caracter_ult != ".")
						{
							$mail_correcto = 1; 
						}
					}
				}
			}
		}
		if ($mail_correcto) 
			return 1; 
		else
			return 0; 
	}

	//verifica se usuário tá logado
	function verifica_logado()
	{
		if($_SESSION["acesso"] != "sim")
		{
			//Redireciona para página de login
			header("Location: login.php?_destino=".$_SERVER['REQUEST_URI']);exit;
		}
	}
}
?>