<?php
$_REQUEST['nome'] = "nome do aluno";
$_REQUEST["livro"] = "222";
$_REQUEST["titulo_monografia"] = "titulo da monografia é este";
$_REQUEST["media_final"] = "2,3";
$_REQUEST["certificado_registro"] = "2,3";
$_REQUEST["folhas"] = "2,3,3,4";
$_REQUEST["dia"] = "2";
$_REQUEST["mes"] = "3";
$_REQUEST["ano"] = "2010";

switch ($_REQUEST['opcao'])
{
	case 'lista_notas_por_grade_curricular':
	
	break;	
	
	default:
	
	function geraFolhaRespostaPdf($pdf,$l_alunos='',$tutores='',$materia='',$doc_vazio=1){

	//$pdf->ezImage('../imagens/site/entrada.jpg',0,'','none','center','');
	
		
			$data = array(
				array('num'=>1,'Conteudo'=>"<b>". $_REQUEST['nome'].'</b>')
			);
			
			$pdf->ezTable($data
						  ,array('Conteudo'=>'')
						  ,''
						  ,array('showHeadings'=>0
								 ,'shaded'=>0
								 ,'justification'=>'center'
								 ,'xOrientation'=>'center'
								 ,'rowGap'=>4
								 ,'colGap'=>4
								 ,'cols'=>array(
												'Conteudo'=>array(
																  'justification'=>'center'
																  )
												)
								 ,'width'=>700
								 )
						  );
			
			$pdf->ezText('',10);//espaçamento
			
	//consulta
	/*
	$resultado = DB_ExecuteSelect_exibe_erro('w08dnn0027.grupoprima.dbo.seavi_certificado_notas_por_gradeCurricular', $p);
	$x = 0;
	while($nt = DB_fetchArray($resultado))
	{
		$data[$x] = array('disciplina'=>'ss'
						  ,'carga_horaria'=>$nt["materiaNome"]
						  ,'frequencia'=>$nt["qtd_disciplinas"]
						  ,'grau'=>$nt["alunoNome"]
						  ,'resultado_final'=>'sem nota'
						  ,'professor'=>'professor ddd'
						  ,'titulacao'=>'bilbo'
						  ,'type'=>'hobbit');
		$x++;
	}
			
	 
			$pdf->ezTable($data,'','',array('showHeadings'=>1,'shaded'=>1,'width'=>700),'');
			*/

			$pdf->ezText('',10);//espaçamento
			
			$data = array(
						  array(
								'bloco_01'=>'<b>Média final</b> (sem monografia): '.$_REQUEST["media_final"].''
								,'bloco_02'=>'<b>Titulo da monografia</b>: '.$_REQUEST["titulo_monografia"].''
								)
						  );

			$pdf->ezTable($data,'','',array('showHeadings'=>0,'shaded'=>0,'showLines'=>1,'width'=>700),'');
			
			$pdf->ezText('',100);//espaçamento
			
			$data = array(
 array('bloco_01'=>'<b>Sistemas de Avaliação</b>
Grau 0 (zero) a 10 (dez)
Grau mínimo por disciplina: 7 (sete)
Frequencia mínima: 75% por disciplina','bloco_02'=>'Curso de Pós-Graduação Lato Sensu
certificado registrado sob Nº '.$_REQUEST["certificado_registro"].' 
LIVRO '.$_REQUEST["livro"].' FLS '.$_REQUEST["folhas"].' EM '.$_REQUEST["dia"].'/'.$_REQUEST["mes"].'/'.$_REQUEST["ano"].'
________________________________
SECRETÁRIO(A) GERAL')
);

			$pdf->ezTable(
						  $data
						  ,''
						  ,''
						  ,array(
								 'showHeadings'=>0
								 ,'shaded'=>0
								 ,'showLines'=>0
								 ,'width'=>700
								 )
						  ,''
						  );

			$pdf->ezText('',20);

			$data = array(
						  array(
								'Conteudo'=>'UNIDERP

UNIVERSIDADE PARA DESENVOLVIMENTO DO ESTADO E DA REGIÃO DO PANTANAL')
						  );

			$pdf->ezTable(
						  $data
						  ,''
						  ,''
						  ,array(
								 'showHeadings'=>0
								 ,'shaded'=>0
								 ,'showLines'=>0
								 ,'justification'=>'center'
								 ,'xOrientation'=>'center'
								 ,'rowGap'=>4
								 ,'colGap'=>4
								 ,'cols'=>array(
												'Conteudo'=>array(
																  'justification'=>'center'
																  )
												)
								 ,'width'=>700
								 )
						  );
			
			$pdf->ezNewPage();
			$pdf->ezText('',150);

			
			
			$pdf->ezText('          Certificamos que <b>{nome}</b>, portadora do R.G. n.º <b>{rg}</b>, concluiu o Curso de Pós-Graduação Lato Sensu em <b>{curso}</b>, na área de Direito, aprovado pela Resolução n.º <b>{conepe}</b>, Resolução n.º e Resolução nº <b>{cne}</b>, realizado no período compreendido entre <b>{duracao}</b>, com carga horária de  horas de atividades teóricas e práticas',15, array('spacing'=>2));
			
			
			/*
			$data = array(
			array(
				  'num'=>1
				  ,'Conteudo'=>'          Certificamos que <b>{nome}</b>, portadora do R.G. n.º <b>{rg}</b>, concluiu o Curso de Pós-Graduação Lato Sensu em <b>{curso}</b>, na área de Direito, aprovado pela Resolução n.º <b>{conepe}</b>, Resolução n.º e Resolução nº <b>{cne}</b>, realizado no período compreendido entre <b>{duracao}</b>, com carga horária de  horas de atividades teóricas e práticas.'
				  )
			);

			$pdf->ezTable(
						  $data
						  ,array('Conteudo'=>'')
						  ,''
						  ,array(
								 'showHeadings'=>0
								 ,'fontSize' => 15
								 ,'shaded'=>0
								 ,'showLines'=>0
								 ,'justification'=>'center'
								 ,'xOrientation'=>'center'
								 ,'rowGap'=>4,'colGap'=>4
								 ,'cols'=>array(
												'Conteudo'=>array(
																  'justification'=>'full'
																  )
												)
								 ,'width'=>700
								 )
						  );
			
			*/
			
			


			
			$data = array(
						  array(
								'num'=>1
								,'Conteudo'=>'Campo Grande - MS, <b>{data}</b>.'
								)
						  );

			$pdf->ezTable(
						  $data
						  ,array('Conteudo'=>'')
						  ,''
						  ,array(
								 'showHeadings'=>0
								 ,'fontSize' => 15
								 ,'shaded'=>0
								 ,'showLines'=>0
								 ,'justification'=>'center'
								 ,'xOrientation'=>'center'
								 ,'rowGap'=>4,'colGap'=>4
								 ,'cols'=>array(
												'Conteudo'=>array(
																  'justification'=>'center'
																  )
												),'width'=>700
								 )
						  );
			
			$pdf->ezText('',10);
			$pdf->ezText('',10);

			$data = array(
			array(
				  'bloco_01'=>'________________________________________
<b>Profa. Dra. Elizabeth Teresa Brunini Sbardelini</b>
Pró-Reitora de Pesquisa e 
Pós-Graduação ',
				  'bloco_02'=>'________________________________________
<b>Nome do aluno</b>
Acadêmico',
				  'bloco_03'=>'________________________________________
<b>Prof. Dr. Guilherme Marback Neto</b>
Reitor'
				  )
			);
			
			$pdf->ezTable(
						  $data
						  ,''
						  ,''
						  ,array('cols'=>array(
												'bloco_01'=>array('justification'=>'center'),
												'bloco_02'=>array('justification'=>'center'),
												'bloco_03'=>array('justification'=>'center')
												),
								 'showHeadings'=>0
								 ,'shaded'=>0
								 ,'showLines'=>0
								 ,'justification'=>'center'
								 ,'xOrientation'=>'center'
								 ,'width'=>700
								 )
						  );

/*
			$data = array(
			array('num'=>1,'name'=>'gandalf','type'=>'wizard')
			,array('num'=>2,'name'=>'bilbo','type'=>'hobbit','url'=>'http://www.ros.co.nz/pdf/')
			,array('num'=>3,'name'=>'frodo','type'=>'hobbit')
			,array('num'=>4,'name'=>'saruman','type'=>'bad	dude','url'=>'http://sourceforge.net/projects/pdf-php')
			,array('num'=>5,'name'=>'sauron','type'=>'really bad dude')
			);


			$cols = array(
						  'num'=>"number a a a a a a a a a a a a a a a\nmore" ,
						  'name'=>'Name',
						  'type'=>'Type'
						  );
			
			$pdf->ezTable($data,$cols,'',
						  array('xPos'=>90,
								'xOrientation'=>'right',
								'width'=>300,
								'cols'=>array('num'=>array('justification'=>'center'),'name'=>array('width'=>100))
								)
						  );
*/

// put a line top and bottom on all the pages
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0,0,0,1);
$pdf->line(20,40,708,40);
$pdf->line(20,822,578,822);
$pdf->addText(50,34,6,'http://ros.co.nz/pdf - http://www.sourceforge.net/projects/pdf-php');
$pdf->restoreState();
$pdf->closeObject();
// note that object can be told to appear on just odd or even pages by changing 'all' to 'odd'
// or 'even'.
$pdf->addObject($all,'odd');


}
	
		include ('gera_pdf_01.php');
		$pdf = new Cezpdf('a4','landscape');//define o tamanho da folha e se é landscape ou portrait 
		$pdf -> ezSetMargins(20,20,70,70);//margens
		$pdf->selectFont('fonte/trebuc.ttf'); //seta a fonte

		geraFolhaRespostaPdf($pdf);//gera a folha vazia
		

		$pdf->ezStream();

	break;
		
}
			
		
?>