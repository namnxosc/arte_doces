<?php
require_once("../inc/classe_ajudante.php");
require_once("../classes/classe_info.php");

$o_ajudante = new Ajudante();
$o_configuracao = new Configuracao;

echo $o_ajudante->html_header($o_configuracao->site_nome(),$o_configuracao->url_virtual()."inc/formatacao.css",$o_configuracao->url_virtual()."inc/java_script.js");

echo "<a href=\"javascript:window.close()\"><img src=\"$z\" width=\"$width\" height=\"$height\" alt=\"Clique para fechar\" border=\"0\"></a>";

?>
<script type="text/javascript">
<!--
window.focus();
//-->
</script>
<?php
echo $o_ajudante->html_footer();
?>