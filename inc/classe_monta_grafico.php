<?php
class Monta_grafico
{
	private $vars;
	private $l_vars;
	private $label;
	private $contador;
	private $nome_pergunta;
	private $id_resposta;
	private $id_pergunta;

	function __constructor()
	{
	}

	function set($prop, $value)
	{
		$this->$prop = $value;
	}

	/*Função que recebe parametros para montar grafico de barras*/
	function monta_grafico_barra()
	{
		$grafico = "
					<script type=\"text/javascript\">
						$(function()
						{
							".$this->vars."
							var ticks = ['Respostas'];
							var plot".$this->contador." = $.jqplot('chart".$this->contador."', [".$this->l_vars."], 
							{
								title:'<b>".$this->contador.") ".$this->nome_pergunta."</b><br />',
								seriesDefaults:
								{
									renderer:$.jqplot.BarRenderer,
									showMarker:true,
									pointLabels: { show:true } 
								},
								series:[".$this->label."],
								legend:
								{
									show: true,
									placement: 'outsideGrid',
									location: 'e'
								},
								axes: 
								{
									xaxis: 
									{
										renderer: $.jqplot.CategoryAxisRenderer,
										ticks: ticks
									},
									yaxis: 
									{
										pad: 1.05,
										tickOptions: {formatString: '%d'}
									}
								}
							});
						});
					</script>
					";

		$grafico .= "<br /><div id='chart".$this->contador."' style='height:300px; width:500px;margin-left:5px;'></div>";

		return $grafico;
	}
}
?>