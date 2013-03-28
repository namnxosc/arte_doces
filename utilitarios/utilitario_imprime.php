<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Imprimir</title>

<script language="javascript">

function pega_mostra(){
document.getElementById('conteudo').innerHTML  =  window.opener.document.getElementById('container').innerHTML; 
}

</script>
<style type="text/css">
<!--
#conteudo{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
}

#conteudo img{
float:left;
}

-->
</style>
</head>

<body>

<div  id="conteudo"></div>

<p align="center">
<a href="#" onClick="window.print()">imprimir</a>
<a href="#" onClick="window.close()">fechar</a>
</p>

</body>
</html>


