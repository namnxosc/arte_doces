<?php
$campo_nome = $_REQUEST["campo_nome"];
echo "Utilitario para edi��o de textos.<br /><br />";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Cross-Browser Rich Text Editor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<meta name="PageURL" content="http://www.kevinroth.com/rte/demo.htm" />
	<meta name="PageTitle" content="Cross-Browser Rich Text Editor" />
	<script language="JavaScript" type="text/javascript" src="html2xhtml.js"></script>
	<!-- To decrease bandwidth, use richtext_compressed.js instead of richtext.js //-->
	<script language="JavaScript" type="text/javascript" src="richtext_compressed.js"></script>
</head>
<body>

<!-- START Demo Code -->
<form name="RTEDemo" action="demo.htm" method="post" onSubmit="return submitForm();">
<script language="JavaScript" type="text/javascript">
<!--
function submitForm() {
	//make sure hidden and iframe values are in sync before submitting form
	//to sync only 1 rte, use updateRTE(rte)
	//to sync all rtes, use updateRTEs
	updateRTE('rte1');
	//updateRTEs();
//alert("rte1 = " + document.RTEDemo.rte1.value);
	window.opener.document.form._<?=$campo_nome?>.value = document.RTEDemo.rte1.value;
	
		window.close();
	//change the following line to true to submit form
	return false;
}

//Usage: initRTE(imagesPath, includesPath, cssFile, genXHTML)
initRTE("images/", "", "", true);
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>

<script language="JavaScript" type="text/javascript">
<!--
//Usage: writeRichText(fieldname, html, width, height, buttons, readOnly)
writeRichText('rte1', window.opener.document.form._<?=$campo_nome?>.value, 750, 400, true, false);
//-->
</script>
<p>Clique finalizar edi��o do seu texto:
  <input type="submit" name="submit" value="Enviar Dados e Fechar janela">
  <input type="submit" name="submit2" onClick="window.close();" value="Cancelar">
</p>
</form>
<!-- END Demo Code -->

</body>
</html>
