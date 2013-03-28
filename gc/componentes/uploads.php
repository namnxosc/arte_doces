<?php
ob_start();
session_name("adm");
session_start("adm");
require_once("../../inc/includes.php");
/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
	/**
	 * Save the file to the specified path
	 * @return boolean TRUE on success
	 */
	function save($path) {    
		$input = fopen("php://input", "r");
		$temp = tmpfile();
		$realSize = stream_copy_to_stream($input, $temp);
		fclose($input);
		
		if ($realSize != $this->getSize()){            
			return false;
		}
		
		$target = fopen($path, "w");        
		fseek($temp, 0, SEEK_SET);
		stream_copy_to_stream($temp, $target);
		fclose($target);
		
		return true;
	}
	function getName() {
		return $_GET['qqfile'];
	}
	function getSize() {
		if (isset($_SERVER["CONTENT_LENGTH"])){
			return (int)$_SERVER["CONTENT_LENGTH"];            
		} else {
			throw new Exception('Getting content length is not supported.');
		}      
	}   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
	/**
	 * Save the file to the specified path
	 * @return boolean TRUE on success
	 */
	function save($path) {
		if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
			return false;
		}
		return true;
	}
	function getName() {
		return $_FILES['qqfile']['name'];
	}
	function getSize() {
		return $_FILES['qqfile']['size'];
	}
}

class qqFileUploader {
	private $allowedExtensions = array();
	private $sizeLimit = 10485760;
	private $file;

	function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){        
		$allowedExtensions = array_map("strtolower", $allowedExtensions);
			
		$this->allowedExtensions = $allowedExtensions;        
		$this->sizeLimit = $sizeLimit;
		
		$this->checkServerSettings();       

		if (isset($_GET['qqfile'])) {
			$this->file = new qqUploadedFileXhr();
		} elseif (isset($_FILES['qqfile'])) {
			$this->file = new qqUploadedFileForm();
		} else {
			$this->file = false; 
		}
	}
	
	private function checkServerSettings(){        
		$postSize = $this->toBytes(ini_get('post_max_size'));
		$uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
		
		if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
			$size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
			die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
		}        
	}
	
	private function toBytes($str){
		$val = trim($str);
		$last = strtolower($str[strlen($str)-1]);
		switch($last) {
			//case 'g': $val *= 10240;
			//case 'm': $val *= 1024;
			//case 'k': $val *= 1024;        
			case 'g': $val *= 10240000;
			case 'm': $val *= 10240000;
			case 'k': $val *= 10240000;        
		}
		return $val;
	}
	
	/**
	 * Returns array('success'=>true) or array('error'=>'error message')
	 */
	function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
		
		if (!is_writable($uploadDirectory)){
			return array('error' => "Server error. Upload directory isn't writable.");
		}
		
		if (!$this->file){
			return array('error' => 'No files were uploaded.');
		}
		
		$size = $this->file->getSize();
		
		if ($size == 0) {
			return array('error' => 'File is empty');
		}
		if ($size > $this->sizeLimit) {
			return array('error' => 'File is too large');
		}

		if($_REQUEST['album'] == 'album_02' || $_REQUEST['album'] == 'album_lookbook')
		{
			$id_album = $_SESSION['id_album_uploads_02'];
		}
		elseif($_REQUEST['album'] == 'album_01')
		{
			$id_album = $_SESSION['id_album_uploads'];
		}
		elseif($_REQUEST['album'] == 'album_iframe')
		{
			$id_album = $_SESSION['id_album_uploads_iframe'];
		}
		elseif($_REQUEST['album'] == 'album_03')
		{
			$id_album = $_SESSION['id_album_uploads_03'];
		}
		elseif($_REQUEST['album'] == 'album_04')
		{
			$id_album = $_SESSION['id_album_uploads_04'];
		}
		$pathinfo = "";
		$pathinfo = pathinfo($this->file->getName());
		$filename = $pathinfo['filename'].$id_album;
		//$filename = md5(uniqid());
		
		$ext = $pathinfo['extension'];
		
		$ext = (string)$ext;
		
		if($ext == "jpeg" || $ext == "JPEG" || $ext == "jpg" || $ext == "JPG")
		{
			$ext = "jpg";
		}

		if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
			$these = implode(', ', $this->allowedExtensions);
			return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
		}
		
		
		
		$filename = $this->carateres_especiais($filename);//.date("YmdGis");
		$_SESSION["uploads".$_SESSION['usuario_numero'].""] .= $filename.'.'.$ext.","; 

		if(!$replaceOldFile){
			/// don't overwrite previous files that were uploaded
			while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
				$filename .= rand(10000, 999999);
			}
		}
		
		if($_SESSION['destaque_uploads'])
		{
			$destaque=$_SESSION['destaque_uploads'];
		
		}
		else
		{
			$destaque='s';
		
		}
		
		
		
		$o_imagem = new Imagem;
		$o_imagem->set('nome', $filename.'.'. $ext);
		$o_imagem->set('id_album',$id_album);
		$o_imagem->set('descricao',"Foto da galeria dos produtos.");
		$o_imagem->set('destaque',$destaque);
		$o_imagem->set('estado',"a");
		$r = $o_imagem->inserir();
		unset($o_imagem);

		if ($this->file->save($uploadDirectory . $filename. '.' . $ext)){
			return array('success'=>true);
		} else {
			return array('error'=> 'Could not save uploaded file.' .
				'The upload was cancelled, or server error encountered');
		}
	}    
	
	function carateres_especiais($nome){
	  $n_n = str_replace(" ","_",$nome);   
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
	  
	  return $n_n;
	}
}

// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array();
// max file size in bytes
$sizeLimit = 10 * 1024 * 1024;

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
//$result = $uploader->handleUpload('uploads/');
if($_SESSION['rota_upload_imagem'])
{
	$result = $uploader->handleUpload($_SESSION['rota_upload_imagem']);
}
else
{	
	$result = $uploader->handleUpload('../../imagens/produtos/');
}
// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
