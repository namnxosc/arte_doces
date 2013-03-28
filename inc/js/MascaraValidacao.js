// JavaScript Document
//adiciona mascara de cnpj
function MascaraCNPJ(cnpj){
		if(mascaraInteiro(cnpj)==false){
				event.returnValue = false;
		}       
		return formataCampo(cnpj, '00.000.000/0000-00', event);
}

function MascaraMoeda(moeda){
		if(mascaraInteiro(moeda)==false){
				event.returnValue = false;
		}       
		return formataCampo(moeda, '000.000.000,00', event);
}

function MascaraPorcentagem(num){
		if(mascaraInteiro(num)==false){
				event.returnValue = false;
		}       
		return formataCampo(num, '0.00', event);
}

//adiciona mascara de cep
function MascaraCep(cep){
				if(mascaraInteiro(cep)==false){
				event.returnValue = false;
		}       
		return formataCampo(cep, '00.000-000', event);
}

//adiciona mascara de data
function MascaraData(data){
		if(mascaraInteiro(data)==false){
				event.returnValue = false;
		}       
		return formataCampo(data, '00/00/0000', event);
}

//adiciona mascara ao telefone
function MascaraTelefone(tel){  
		if(mascaraInteiro(tel)==false){
				event.returnValue = false;
		}       
		return formataCampo(tel, '(00) 0000-0000', event);
}

//adiciona mascara ao CPF
function MascaraCPF(cpf){
		if(mascaraInteiro(cpf)==false){
				event.returnValue = false;
		}       
		return formataCampo(cpf, '000.000.000-00', event);
}

//valida telefone
function ValidaTelefone(tel){
	if((tel.value)!='')
	{
		exp = /\(\d{2}\)\ \d{4}\-\d{4}/
		if(!exp.test(tel.value))
			alert('Numero de Telefone Invalido!');
	}
}

function ValidaPorcentagem(num){
	if((num.value)!='')
	{
		exp = /0\.\d{0,2}/
		if(!exp.test(num.value))
		{
			$("#_comissao").focus();
			$("#_comissao").val("");
			alert('Valor Invalido! O valor deve estar entre 0.00 e 0.99');
		}
	}
}

//valida CEP
function ValidaCep(cep){
	if((cep.value)!='')
	{
		exp = /\d{2}\.\d{3}\-\d{3}/
		if(!exp.test(cep.value))
		{
			$("#_endereco").val("");
			$("#_numero").val("");
			$("#_complemento").val("");
			$("#_bairro").val("");
			$("#_cidade").val("");
			$("#_uf").val("");_cep
			alert('Numero de CEP Invalido!');
		}
		else
		{
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#_cep").val(), function()
			{
				if(resultadoCEP["resultado"] && resultadoCEP["bairro"] != "")
				{
					$("#_endereco").val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));
					$("#_bairro").val(unescape(resultadoCEP["bairro"]));
					$("#_cidade").val(unescape(resultadoCEP["cidade"]));
					$("#_uf").val(unescape(resultadoCEP["uf"]));
					$("#_numero").focus();
					alert("Endereço encontrado!");
				}
				else
				{
					$("#_endereco").val("");
					$("#_numero").val("");
					$("#_complemento").val("");
					$("#_bairro").val("");
					$("#_cidade").val("");
					$("#_uf").val("");
					alert("Endereço não encontrado! Por favor digite endereço, bairro, UF e cidade.");
					return false;
				}
			});
		}
	}
}

//valida data
function ValidaData(data)
{
		exp = /\d{2}\/\d{2}\/\d{4}/
		if(!exp.test(data.value))
		{
			alert('Data Invalida!');
			data.select();          
		}
}

//valida o CPF digitado
function ValidarCPF(Objcpf){
	if((Objcpf.value)!='')
	{
		var cpf = Objcpf.value;
		exp = /\.|\-/g
		cpf = cpf.toString().replace( exp, "" ); 
		var digitoDigitado = eval(cpf.charAt(9)+cpf.charAt(10));
		var soma1=0, soma2=0;
		var vlr =11;

		for(i=0;i<9;i++){
				soma1+=eval(cpf.charAt(i)*(vlr-1));
				soma2+=eval(cpf.charAt(i)*vlr);
				vlr--;
		}
		soma1 = (((soma1*10)%11)==10 ? 0:((soma1*10)%11));
		soma2=(((soma2+(2*soma1))*10)%11);

		var digitoGerado=(soma1*10)+soma2;
		if(digitoGerado!=digitoDigitado)        
				alert('CPF Invalido!');
	}
	else
	{
		alert('Por favor digite um CPF!');
	}
}

//valida numero inteiro com mascara
function mascaraInteiro()
{
	if (event.keyCode < 48 || event.keyCode > 57){
			event.returnValue = false;
			return false;
	}
	return true;		
}

//valida o CNPJ digitado
function ValidarCNPJ(ObjCnpj){
		var cnpj = ObjCnpj.value;
		var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
		var dig1= new Number;
		var dig2= new Number;
		
		exp = /\.|\-|\//g
		cnpj = cnpj.toString().replace( exp, "" ); 
		var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));
				
		for(i = 0; i<valida.length; i++){
				dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);  
				dig2 += cnpj.charAt(i)*valida[i];       
		}
		dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
		dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));
		
		if(((dig1*10)+dig2) != digito)  
				alert('CNPJ Invalido!');
				
}

//formata de forma generica os campos 	return formataCampo(moeda, '000.000.000,00', event);
function formataCampo(campo, Mascara, evento) 
{
	var boleanoMascara; 

	var Digitato = evento.keyCode;
	exp = /\-|\.|\/|\(|\)| /g
	campoSoNumeros = campo.value.toString().replace( exp, "" ); 

	var posicaoCampo = 0;    
	var NovoValorCampo="";
	var TamanhoMascara = campoSoNumeros.length;; 

	if (Digitato != 8) 
	{ // backspace 
		for(i=0; i<= TamanhoMascara; i++) 
		{ 
			boleanoMascara  = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".") || (Mascara.charAt(i) == "/")) 
			boleanoMascara  = boleanoMascara || ((Mascara.charAt(i) == "(") || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " ")) 
			if (boleanoMascara) 
			{ 
				NovoValorCampo += Mascara.charAt(i); 
				TamanhoMascara++;
			}
			else
			{ 
				NovoValorCampo += campoSoNumeros.charAt(posicaoCampo); 
				posicaoCampo++; 
			}
		}
		campo.value = NovoValorCampo;
		return true; 
	}
	else 
	{ 
			return true; 
	}
}