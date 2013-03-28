<?php
	include('../inc/includes.php');
	
	$o_ajudante = new Ajudante;
	
	// Seleciona um projeto pro o envio de emails
	$o_projeto = new Projeto;
	$o_projeto->set('estado', 'a');	//ativo
	$o_projeto->set('limite', 1);
	if($rs = $o_projeto->selecionar())
	{
		foreach($rs as $l)
		{
			$o_mail_marketing = new Mail_marketing;
			$o_mail_marketing->set('id_projeto', $l['id']);
			$o_mail_marketing->set('estado', 'a');				//ativo
			$o_mail_marketing->limite('limite', 30);			//limite de envio de email 30
			if($rs = $o_mail_marketing->selecionar())
			{
				$cont = 0;
				foreach($rs_m as $l_m)
				{
					$o_mail_marketing = new Mail_marketing;
					$o_mail_marketing->set('estado', 'e');		//enviado
					$o_mail_marketing->set('id', $l_m['id']);
					if($o_mail_marketing->editar_estado())
					{
						$o_ajudante->email_html($l['assunto'],$l['mensagem'],$l['remetente'],$l_m['email'],"../templates/template_geral.html");
						$o_auditoria->set('acao_descricao',"Envio de Email Marketing <b>".$l['nome']."</b> para <b>".$l_m['nome']." - ".$l_m['email']."</b>.");
						$o_auditoria->inserir();
					}
					if($cont%10 == 0)
					{
						sleep(1);
					}
					$cont++;
				}
			}
		}
	}
?>