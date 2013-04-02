	function sem_conteudo(ss)
	{
		if(ss.length > 0) { return false; }
		return true;
	}

	//Fila de conexões
	fila=[]
	ifila=0

	//Carrega via XMLHTTP a url recebida e coloca seu valor
	//no objeto com o id recebido
	function ajaxHTML(id,url)
	{
		//Carregando...
		document.getElementById(id).innerHTML="<span>Carregando...</span>"
		//Adiciona à fila
		fila[fila.length]=[id,url]
		//Se não há conexões pendentes, executa
		if((ifila+1)==fila.length)
		{
			ajaxRun();
		}
	}

	//Executa a próxima conexão da fila
	function ajaxRun()
	{
		//Tenta criar o objeto xmlHTTP
		try{
			xmlhttp = new XMLHttpRequest();
		}catch(ee){
			try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}catch(e){
				try{
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}catch(E){
					xmlhttp = false;
				}
			}
		}

		//Abre a conexão
		xmlhttp.open("GET",fila[ifila][1],true);
		//Função para tratamento do retorno
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4)
			{
				//Mostra o HTML recebido
				retorno=unescape(xmlhttp.responseText.replace(/\+/g," "))
				document.getElementById(fila[ifila][0]).innerHTML=retorno
				//Roda o próximo
				ifila++
				if(ifila<fila.length)setTimeout("ajaxRun()",20)
			}
		}
		//Executa
		xmlhttp.send(null)
	}

	function passa_valor_01(valor,campo)
	{
	window.opener.document.getElementById(campo).value = valor;
	}

	function confirma(pagina_deleta,registro)
	{
		if (confirm("Tem certeza de que deseja deletar :\n"+registro+" ?"))
		location.href = pagina_deleta;
	}

	function confirma_02(pagina_deleta,registro)
	{
		if (confirm("Tem certeza de que deseja realizar esta ação?"))
		location.href = pagina_deleta;
	}

	//gestor de conteudo
	function confirmar(mensagem) 
	{
		var agree=confirm(mensagem);
		if (agree)
			return true ;
		else
			return false ;
	}

	function abre_janela(theURL,winName,features) 
	{
		window.open(theURL,winName,features);
	}

	function abre_janela_02(theURL,winName,features)
	{
		window.open(theURL,winName,features);
	}
	//termina gestor de conteúdo

	var timer;

	function clickButtonBarra(id)
	{
		if (timer != undefined) return;
		var tamanhoC = document.getElementById("container").offsetHeight;
		elem = document.getElementsByTagName("A");
		for(i=0;i<elem.length;i++)
		{
			if (elem[i].className == "botaoBarraAtiva")
				elem[i].className = "botaoBarra";
			if (elem[i].className == "botaoBarra")
				tamanhoC -= elem[i].offsetHeight;
		}

		var inc = Math.round(tamanhoC / 10);

		itemClicado = document.getElementById(id);
		itemClicado.className = "botaoBarraAtiva";

		barra = "";
		elem = document.getElementsByTagName("DIV");
		for(i=0;i<elem.length;i++)
		{
			if ((elem[i].id.substring(0,8) == "Conteudo") && (elem[i].style.display == "block"))
				barra = elem[i].id;
		}

		if(barra!="" && barra == ("Conteudo" + id)) return;
		timer = setTimeout("timerResizeBarra('"+"Conteudo" + id +"','"+barra+"',0,"+tamanhoC+","+tamanhoC+",10,"+inc+")",10);
	}

	function timerResizeBarra(barraAtiva, barraInativa, alturaAtiva, alturaInativa, tamanhoC, tempo, inc)
	{
		b1 = document.getElementById(barraAtiva);

		if ((alturaAtiva + inc) <= tamanhoC)
		{
			b1.style.height = alturaAtiva + inc;

			if (barraInativa != ""){
				b2 = document.getElementById(barraInativa);
				b2.style.height = alturaInativa - inc;
			}

			if (tamanhoC == alturaInativa){
				if (b1.style.display != "block")
					b1.style.display = "block";
				if ((barraInativa != "") && (b2.style.overflow != "hidden"))
					b2.style.overflow = "hidden";
			}
			timer = setTimeout("timerResizeBarra('"+barraAtiva+"','"+barraInativa+"',"+(alturaAtiva + inc)+","+(alturaInativa - inc)+","+tamanhoC+","+tempo+","+inc+")",tempo);
		}
		else
		{
			b1.style.height = tamanhoC;
			if (barraInativa != ""){
				b2 = document.getElementById(barraInativa);
				b2.style.height = 0;
				b2.style.display = "none";
			}

			b1.style.overflow = "auto";

			clearTimeout(timer);
			timer = undefined;
		}
	}

	window.onload = function()
	{
		elem = document.getElementsByTagName("A");
		for(i=0;i<elem.length;i++){
			if (elem[i].className == "botaoBarra"){
				clickButtonBarra(elem[i].id);
				return;
			}
		}
		// Preloading de imagens
		preloader();
	}

	window.onresize = function()
	{
		if (navigator.appName.indexOf("Microsoft") != -1){
			tamanhoC = document.body.offsetHeight-4;
		}else{
			tamanhoC = window.innerHeight;
		}

		elem = document.getElementsByTagName("A");
		for(i=0;i<elem.length;i++){
			if ((elem[i].className == "botaoBarra") || (elem[i].className == "botaoBarraAtiva"))
				tamanhoC -= elem[i].offsetHeight;
		}

		elem = document.getElementsByTagName("DIV");
		for(i=0;i<elem.length;i++){
			if ((elem[i].id.substring(0,8) == "Conteudo") && (elem[i].style.display == "block")){
				elem[i].style.height = tamanhoC;
				return;
			}
		}
	}

	function preloader()
	{
		/*img1 = new Image();
		img1.src = "bnt_01.jpg";
		img2 = new Image();
		img2.src = "bnt_02.jpg";
		img3 = new Image();
		img3.src = "bnt_03.jpg";
		img4 = new Image();
		img4.src = "bnt_04.jpg";
		img5 = new Image();
		img5.src = "fundo.jpg";*/
	} 

///////////////////////////////TROCA DE IMAGENS////////////////////////////////////////////

var fadeimages=new Array()
fadeimages[0]=["http://heroi.ig.com.br//images/stories/imgs/fullmetal_hqheroi_capaprinc.jpg", "http://heroi.ig.com.br/index.php?option=com_content&amp;task=view&amp;id=2198&amp;Itemid=20&amp;catid=75",""]
fadeimages[1]=["http://heroi.ig.com.br//images/stories/imgs/comunidades-capa.jpg", "http://heroi.ig.com.br/index.php?option=com_content&amp;task=view&amp;id=2181&amp;Itemid=20&amp;catid=75",""]
fadeimages[2]=["http://heroi.ig.com.br//images/stories/imgs/star-wars-force-unleashed_capa.jpg", "http://heroi.ig.com.br/index.php?option=com_content&amp;task=view&amp;id=2175&amp;Itemid=20&amp;catid=75",""]
fadeimages[3]=["http://heroi.ig.com.br//images/stories/imgs/halo3-capa.jpg", "http://heroi.ig.com.br/index.php?option=com_content&amp;task=view&amp;id=2168&amp;Itemid=20&amp;catid=75",""]

var fadebgcolor="white"

var fadearray=new Array()
var fadeclear=new Array()

var dom=(document.getElementById)
var iebrowser=document.all

function fadeshow(theimages, fadewidth, fadeheight, borderwidth, delay, pause, displayorder)
{
this.pausecheck=pause
this.mouseovercheck=0
this.delay=delay
this.degree=20
this.curimageindex=0
this.nextimageindex=1
fadearray[fadearray.length]=this
this.slideshowid=fadearray.length-1
this.canvasbase="canvas"+this.slideshowid
this.curcanvas=this.canvasbase+"_0"
if (typeof displayorder!="undefined")
theimages.sort(function() {return 0.5 - Math.random();})
this.theimages=theimages
this.imageborder=parseInt(borderwidth)
this.postimages=new Array()
for (p=0;p<theimages.length;p++){
this.postimages[p]=new Image()
this.postimages[p].src=theimages[p][0]
}

var fadewidth=fadewidth+this.imageborder*2
var fadeheight=fadeheight+this.imageborder*2

if (iebrowser&&dom||dom) //if IE5+ or modern browsers (ie: Firefox)
document.write('<div id="master'+this.slideshowid+'" style="position:relative;width:'+fadewidth+'px;height:'+fadeheight+'px;overflow:hidden;"><div id="'+this.canvasbase+'_0" style="position:absolute;width:'+fadewidth+'px;height:'+fadeheight+'px;top:0;left:0;filter:progid:DXImageTransform.Microsoft.alpha(opacity=10);-moz-opacity:10;-khtml-opacity:10;background-color:'+fadebgcolor+'"></div><div id="'+this.canvasbase+'_1" style="position:absolute;width:'+fadewidth+'px;height:'+fadeheight+'px;top:0;left:0;filter:progid:DXImageTransform.Microsoft.alpha(opacity=10);-moz-opacity:10;background-color:'+fadebgcolor+'"></div></div>')
else
document.write('<div><img name="defaultslide'+this.slideshowid+'" src="'+this.postimages[0].src+'"></div>')

if (iebrowser&&dom||dom) //if IE5+ or modern browsers such as Firefox
this.startit()
else{
this.curimageindex++
setInterval("fadearray["+this.slideshowid+"].rotateimage()", this.delay)
}
}

function fadepic(obj){
if (obj.degree<100){
obj.degree+=10
if (obj.tempobj.filters&&obj.tempobj.filters[0]){
if (typeof obj.tempobj.filters[0].opacity=="number") //if IE6+
obj.tempobj.filters[0].opacity=obj.degree
else //else if IE5.5-
obj.tempobj.style.filter="alpha(opacity="+obj.degree+")"
}
else if (obj.tempobj.style.MozOpacity)
obj.tempobj.style.MozOpacity=obj.degree/101
else if (obj.tempobj.style.KhtmlOpacity)
obj.tempobj.style.KhtmlOpacity=obj.degree/100
}
else{
clearInterval(fadeclear[obj.slideshowid])
obj.nextcanvas=(obj.curcanvas==obj.canvasbase+"_0")? obj.canvasbase+"_0" : obj.canvasbase+"_1"
obj.tempobj=iebrowser? iebrowser[obj.nextcanvas] : document.getElementById(obj.nextcanvas)
obj.populateslide(obj.tempobj, obj.nextimageindex)
obj.nextimageindex=(obj.nextimageindex<obj.postimages.length-1)? obj.nextimageindex+1 : 0
setTimeout("fadearray["+obj.slideshowid+"].rotateimage()", obj.delay)
}
}

fadeshow.prototype.populateslide=function(picobj, picindex){
var slideHTML=""
if (this.theimages[picindex][1]!="") //if associated link exists for image
slideHTML='<a href="'+this.theimages[picindex][1]+'" target="'+this.theimages[picindex][2]+'">'
slideHTML+='<img src="'+this.postimages[picindex].src+'" border="'+this.imageborder+'px">'
if (this.theimages[picindex][1]!="") //if associated link exists for image
slideHTML+='</a>'
picobj.innerHTML=slideHTML
}


fadeshow.prototype.rotateimage=function(){
if (this.pausecheck==1)
var cacheobj=this
if (this.mouseovercheck==1)
setTimeout(function(){cacheobj.rotateimage()}, 100)
else if (iebrowser&&dom||dom){
this.resetit()
var crossobj=this.tempobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
crossobj.style.zIndex++
fadeclear[this.slideshowid]=setInterval("fadepic(fadearray["+this.slideshowid+"])",50)
this.curcanvas=(this.curcanvas==this.canvasbase+"_0")? this.canvasbase+"_1" : this.canvasbase+"_0"
}
else{
var ns4imgobj=document.images['defaultslide'+this.slideshowid]
ns4imgobj.src=this.postimages[this.curimageindex].src
}
this.curimageindex=(this.curimageindex<this.postimages.length-1)? this.curimageindex+1 : 0
}

fadeshow.prototype.resetit=function(){
this.degree=10
var crossobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
if (crossobj.filters&&crossobj.filters[0]){
if (typeof crossobj.filters[0].opacity=="number") //if IE6+
crossobj.filters(0).opacity=this.degree
else //else if IE5.5-
crossobj.style.filter="alpha(opacity="+this.degree+")"
}
else if (crossobj.style.MozOpacity)
crossobj.style.MozOpacity=this.degree/101
else if (crossobj.style.KhtmlOpacity)
crossobj.style.KhtmlOpacity=obj.degree/100
}


fadeshow.prototype.startit=function(){
var crossobj=iebrowser? iebrowser[this.curcanvas] : document.getElementById(this.curcanvas)
this.populateslide(crossobj, this.curimageindex)
if (this.pausecheck==1){ //IF SLIDESHOW SHOULD PAUSE ONMOUSEOVER
var cacheobj=this
var crossobjcontainer=iebrowser? iebrowser["master"+this.slideshowid] : document.getElementById("master"+this.slideshowid)
crossobjcontainer.onmouseover=function(){cacheobj.mouseovercheck=1}
crossobjcontainer.onmouseout=function(){cacheobj.mouseovercheck=0}
}
this.rotateimage()
}


////////////////////////////////////LINK IMG//////////////////////////////////


function high(which2){
theobject=which2
highlighting=setInterval("highlightit(theobject)",50)
}
function low(which2){
clearInterval(highlighting)
which2.filters.alpha.opacity=20
}
function highlightit(cur2){
if (cur2.filters.alpha.opacity<100)
cur2.filters.alpha.opacity+=5
else if (window.highlighting)
clearInterval(highlighting)
}

	function abre_info()
	{
		window.open('../utilitarios/utilitario_informativo.php?_info_email='+document.informativo._info_email.value+'&info='+document.informativo.info.value,'newsletter','width=350,height=350');
	}

	function abre_janela(nome_janela,alvo_janela)
	{
	window.open(nome_janela,alvo_janela,'width=500,height=500');
	}

	function checa_campos(pagina)
	{
		var mensagem_erro = new String();
		switch(pagina)
		{
			//==================================================CONTATO==================================================
			case "envia_senha":
				if(sem_conteudo(document.form_senha_perdida.email.value) || document.form_senha_perdida.email.value == 'Insira seu e-mail'){ mensagem_erro += "\n\n- Por favor digite seu e-mail de cadastro.";}
			break;

			//==================================================CATEGORIA==================================================
			case "categoria":
				if(sem_conteudo(document.formulario_categoria._nome.value)){ mensagem_erro += "\n\n- Por favor digite o nome da categoria.";}
				if(NoneWithCheck(document.formulario_categoria._estado)){ mensagem_erro += "\n\n- Por favor selecione um estado."; }
			break;

			case "produto_materia":
				var cmp_categoria = $("input[name='cmp_categoria_id[]']").serializeArray(); 
				if(sem_conteudo(document.form._nome.value)){ mensagem_erro += "\n\n- Por favor digite um nome.";} 
				if (cmp_categoria.length == 0) { mensagem_erro += "\n\n- Por favor selecione pelo menos uma categoria do produto."; }
				if($("input[name='_destaque_materia']:checked").val() == "v")
				{}
				else
				{
					if(NoneWithCheck(document.form._estilo)){ mensagem_erro += "\n\n- Por favor selecione a largura do destaque da matéria."; }
				}
				
				if(NoneWithCheck(document.form._estado)){ mensagem_erro += "\n\n- Por favor selecione um estado."; }
			break;
			
			case "menu_site":
			
				if(sem_conteudo(document.form._id_menu_ambiente.value)){ mensagem_erro += "\n\n- Por favor selecione o ambiente."; }
				if(sem_conteudo(document.form._nome.value)){ mensagem_erro += "\n\n- Por favor digite um nome."; }
				if(NoneWithCheck(document.form._pagina_interna)){ mensagem_erro += "\n\n- Por favor selecione o tipo de menu."; }
				if(NoneWithCheck(document.form._estado)){ mensagem_erro += "\n\n- Por favor selecione um estado."; }
			break;
			
			//==================================================EDITA ALBUM==================================================
			case "edita_album":
				if(sem_conteudo(document.form_album._nome.value)){ mensagem_erro += "\n\n- Por favor digite um nome.";} 
			break;
			
			//==================================================BLOG ALBUM==================================================
			case "blog_album":
				if(sem_conteudo(document.form._nome.value)){ mensagem_erro += "\n\n- Por favor digite um nome.";} 
			break;
			
			case "conteudo_pagina":
				if(sem_conteudo(document.form._nome.value)){ mensagem_erro += "\n\n- Por favor digite um nome.";}				
				if(sem_conteudo(document.form._corpo.value)) { mensagem_erro += "\n\n- Por favor digite o texto da página."; }				
				if(WithoutCheck(document.form.estado.value)) { mensagem_erro += "\n\n- Por favor selecione um estado."; }
			 break;
			 
			//==================================================ILUSTRAR==================================================
			case "ilustrar_imagem":
				if(sem_conteudo(document.formulario_imagem._nome.value)){ mensagem_erro += "\n\n- Por favor selecione uma imagem."; }
				if(sem_conteudo(document.formulario_imagem._descricao.value)){ mensagem_erro += "\n\n- Por favor digite uma descrição.";}
			break;

			case "ilustrar_album":
				if(sem_conteudo(document.form._id_album_tipo.value)){ mensagem_erro += "\n\n- Por favor selecione o tipo de álbum."; }
				if(sem_conteudo(document.form._nome.value)){ mensagem_erro += "\n\n- Por favor digite um nome.";}
			break;

			//==================================================SISTEMA==================================================
			case "sistema_permissao":
				if(sem_conteudo(document.formulario_usuarios_permissoes.cmp_usuario_nome.value)){ mensagem_erro += "\n\n- Por favor selecione um usuário."; }
			break;

			case "sistema_ambiente":
				if(sem_conteudo(document.formularios._nome.value)){ mensagem_erro += "\n\n- Por favor digite o nome completo do ambiente.";}
				if(sem_conteudo(document.formularios._botao.value)) { mensagem_erro += "\n\n- Por favor digite um nome."; }
				if(sem_conteudo(document.formularios._url.value)) { mensagem_erro += "\n\n- Por favor digite um endereço."; }
			break;

			case "sistema_usuario":
				if(sem_conteudo(document.form_usuario._nome.value)){ mensagem_erro += "\n\n- Por favor digite um nome."; }
				if(sem_conteudo(document.form_usuario._sobrenome.value)){ mensagem_erro += "\n\n- Por favor digite um sobrenome."; }
				if(sem_conteudo(document.form_usuario._email.value)){ mensagem_erro += "\n\n- Por favor digite um e-mail.";}
				if(sem_conteudo(document.form_usuario._cep.value)){ mensagem_erro += "\n\n- Por favor digite um CEP.";}
				if(sem_conteudo(document.form_usuario._endereco.value)){ mensagem_erro += "\n\n- Por favor digite um endereço.";}
				if(sem_conteudo(document.form_usuario._bairro.value)){ mensagem_erro += "\n\n- Por favor digite um bairro.";}
				if(sem_conteudo(document.form_usuario._telefone.value)){ mensagem_erro += "\n\n- Por favor digite um telefone.";}
				if(document.form_usuario._usuario_tipo_id.value == ""){ mensagem_erro += "\n\n- Por favor selecione o perfil do usuario.";}
				if(sem_conteudo(document.form_usuario._senha.value)){ mensagem_erro += "\n\n- Por favor digite uma senha.";}
				if(sem_conteudo(document.form_usuario._senha_re.value)){ mensagem_erro += "\n\n- Por favor digite a senha novamente.";}
				if(NoneWithCheck(document.form_usuario._estado)) { mensagem_erro += "\n\n- Por favor selecione um estado."; }
				if((document.form_usuario._email.value)!='')
				{
					if(!checkMail(document.form_usuario._email.value)){ mensagem_erro += "\n\n- Por favor digite um e-mail válido!";};
				}
				if(((document.form_usuario._senha_re.value)!='')&&((document.form_usuario._senha.value)!=''))
				{
					if(ChecaSenha(document.form_usuario._senha.value,document.form_usuario._senha_re.value)){ mensagem_erro += "\n\n- Senhas diferentes! Por favor confirme sua senha corretamente."; }
				}
			break;

			case "sistema_usuario_tipo":
				if(sem_conteudo(document.formulario._nome.value)){ mensagem_erro += "\n\n- Por favor digite um tipo.";}
			break;
			
			case "valida_contato":
				if(sem_conteudo(document.formulario_contato._nome.value) || document.formulario_contato._nome.value == "nome"){ mensagem_erro += "\n\n- Por favor digite um nome.";}
				if(sem_conteudo(document.formulario_contato._email.value) || document.formulario_contato._email.value == "email"){ mensagem_erro += "\n\n- Por favor digite um email.";}
			break;

			//==================================================GC==================================================
			//não esta funcionando?
			case "login":
				if(sem_conteudo(document.formulario_de_logar.nome_usuario.value)){ mensagem_erro += "\n\n- Por favor digite o nome do usuário."; }
				if(sem_conteudo(document.formulario_de_logar.senha_usuario.value)){ mensagem_erro += "\n\n- Por favor digite a senha do usuário."; }
			break;

			case "ambiente":
				if(sem_conteudo(document.formulario.cmp_ambiente_nome.value)){ mensagem_erro += "\n\n- Por favor digite o nome do ambiente."; }
			break;

			case "permissoes":
				if(sem_conteudo(document.formulario.cmp_usuario_id.value)){ mensagem_erro += "\n\n- Por favor digite o nome do ambiente."; }
			break;

			//-----------------------------------------------------------------
			case "login_recupera":
				if(sem_conteudo(document.form_senha_perdida.usuario_senha_perdida.value)){ mensagem_erro += "\n\n- Por favor digite o nome do usuário."; }
			break;

			//-----------------------------------------------------------------------------
			default:
				alert('falta validação');
		} 

		// Junta mensagens de erro.
		if(mensagem_erro.length > 2)
		{
			alert('AVISO:' + mensagem_erro);
			return false;
		}
		return true;

	} // fim da função de checar campos


//////////////// FUNÇÕES GERAIS DE VALIDAÇÃO ///////////////////////////////////
	function sem_conteudo(ss)
	{
		if(ss.length > 0) { return false; }
		return true;
	}

	function checa_nome(ss)
	{
		var quebra = ss.split(" ");
		if(quebra.length > 1) { return false; }
		return true;
	}

	function checa_cep(ss)
	{
		var quebra = ss.split("");
		if(quebra.length > 7) { return false; }
		return true;
	}

	function nivel_senha()
	{
		senha = document.getElementById("_senha").value;
		forca = 0;
		mostra = document.getElementById("mostra");
		if((senha.length >= 4) && (senha.length <= 7)){
			forca += 10;
		}else if(senha.length>7){
			forca += 25;
		}
		if(senha.match(/[a-z]+/)){
			forca += 10;
		}
		if(senha.match(/[A-Z]+/)){
			forca += 20;
		}
		if(senha.match(/\d+/)){
			forca += 20;
		}
		if(senha.match(/\W+/)){
			forca += 25;
		}
		return mostra_res();
	}

	function mostra_res(){
		if(forca < 30){
			mostra.innerHTML = '<tr><td bgcolor="yellow" width="'+forca+'"></td><td>Fraca </td></tr>';;
		}else if((forca >= 30) && (forca < 60)){
			mostra.innerHTML = '<tr><td bgcolor="yellow" width="'+forca+'"></td><td>Justa </td></tr>';;
		}else if((forca >= 60) && (forca < 85)){
			mostra.innerHTML = '<tr><td bgcolor="blue" width="'+forca+'"></td><td>Forte </td></tr>';
		}else{
			mostra.innerHTML = '<tr><td bgcolor="green" width="'+forca+'"></td><td>Excelente </td></tr>';
		}
	}

	function valida_email(ss)
	{  
	  if ((ss.length > 0) && ((ss.indexOf("@") > 1) && (ss.indexOf('.') > 1)))
	  {
		return false;
	  }
	  return true;
	}

	function ChecaSenha(ss,sss)
	{
		if(ss == sss) { return false; }
		return true;
	}

	function NoneWithContent(ss)
	{
		for(var i = 0; i < ss.length; i++)
		{
			if(ss[i].value.length > 0) { return false; }
		}
		return true;
	}

	function NoneWithCheck(ss)
	{
		for(var i = 0; i < ss.length; i++)
		{
			if(ss[i].checked)
			{ 
				return false;
			}
		}
		return true;
	}

	//função que valida se o check do produto foi clicado em produto.php
	function NoneWithCheck_02(ss)
	{
		var contador = ss.length;
		if(contador > 1)
		{
			for(var i = 0; i < ss.length; i++)
			{
				if(ss[i].checked)
				{ 
					return false;
				}
			}
		return true;
		}
		else
		{
			if(ss.checked)
			{
				return false;
			}
			return true;
		}
	}

	function WithoutCheck(ss)
	{
		if(ss.checked)
		{
			return false;
		}
		
		return true;
	}

	function WithoutSelectionValue(ss) 
	{
		for(var i = 0; i < ss.length; i++) 
		{
			if(ss[i].selected) 
			{
				if(ss[i].value.length) { return false; }
			}
		}
		return true;
	}

//////////////// FUNÇÕES POPUP ///////////////////////////////////

	function fancy_img(obj)
	{
		$.fancybox({
			'href'          	: obj,    
			'overlayShow'		: false,
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
		});
	}

	function popup_()
	{
		classe = 1;
		fancy_function("popup.php?acao_popup=seleciona_endereco&classe="+classe);
	}
	
	function popup_geral(acao_adm, acao)
	{
		x_popup_pagina = 981;
		y_popup_pagina = 755;
		switch (acao_adm)
		{
			case "produtos":
				switch(acao)
				{
					case  "busca":
						//fancy_function("../utilitarios/busca_produtos.php?acao_busca_produto=buscado");
						fancy_function("popup.php?acao_popup=seleciona_endereco&classe=1");
					break;
				}
			break;
			
			case "menu_rodape":
				//fancy_function("../utilitarios/busca_produtos.php?acao_busca_produto=buscado");
				fancy_function("popup.php?acao_popup="+acao_adm+"&acao="+acao+"");
			break;
			
			case "outros":
				fancy_function("../gc/modulos/ajax_adm.php?acao="+acao+"",400,300,"iframe");
			break;
			
			case "album":
				fancy_function("../gc/modulos/ajax_adm.php?acao="+acao+"",800,600,"iframe");
			break;
			
			case "projeto":
				fancy_function("../gc/modulos/ajax_adm.php?acao="+acao+"",400,300,"iframe");
			break;
			
			case "blog":
				fancy_function("../gc/modulos/ajax_adm.php?acao="+acao+"",800,600,"iframe");			
			break;
		}
	}

	function popup_url(endereco)
	{
		fancy_function(endereco);
	}

	function fancy_function(url,largura,altura,tipo)
	{					
		
		$.fancybox({		
			'href'              :url,   
			'autoScale'         :false,	
			'autoDimensions	'	:true,
			'centerOnScroll'    :false,
			'transitionIn'		:'fade',
			'transitionOut'		:'fade',
			'easingIn'          :'swing',
			'easingOut'         :'swing',
			'type'				: tipo,
			'width'             :largura,
			'height'		    :altura,
			'overlayColor'      :'#666666',
			'overlayOpacity': 0.8		
		});
		
		$.fancybox.center;
	}

	function fecha_popup(pag)
	{
		parent.$.fancybox.close();
		window.location = pag;
	}

	function passa(campo1, campo2){ 

		if(campo1.value.length >= 5){
			campo2.focus();
		}
	}
//-->

////////////////////// FUNÇÕES DE MASCARA E BLOQUEIO////////////////////////////////////
	//Funções de Validação
	function checkMail(mail)
	{
		var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
		if(typeof(mail) == "string")
		{
			if(er.test(mail))
			{
				return true;
			}
		}
		else if(typeof(mail) == "object")
		{
			if(er.test(mail.value))
			{
				return true; 
			}
		}
		else
		{
			return false;
		}
	}

	function createUploader(album, diretorio, div)
	{
		var url_virtual = $("#url_virtual").val();
		var uploader = new qq.FileUploader({
			element: document.getElementById(diretorio),
			//action: url_virtual+'gc/componentes/uploads.php?album='+album,
			action: 'componentes/uploads.php?album='+album,
			params: {},

			// validation    
			// ex. ['jpg', 'jpeg', 'png', 'gif'] or []
			allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],        
			sizeLimit: 1024003434, // max size   
			minSizeLimit: 1, // min size

			debug: true,

			// events
			// you can return false to abort submit
			onSubmit: function(id, fileName){},
			onProgress: function(id, fileName, loaded, total){},
			onComplete: function(id, fileName, responseJSON){
				ajax_pagina('upload_imagens','lista', album, '', '', '', '', '', '', '', div, 'ajax_gc_adm', 'false');
			},
			onCancel: function(id, fileName){},

			messages: {
				// error messages, see qq.FileUploaderBasic for content            
			},
			showMessage: function(message){ alert(message); }  
		});
	}

	function createUploader_02(album, diretorio, div)
	{
		var uploader = new qq.FileUploader({
			element: document.getElementById(diretorio),
			action: '../componentes/uploads.php?album='+album,
			params: {},

			// validation    
			// ex. ['jpg', 'jpeg', 'png', 'gif'] or []
			allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],        
			sizeLimit: 1024003434, // max size   
			minSizeLimit: 1, // min size

			debug: true,

			// events
			// you can return false to abort submit
			onSubmit: function(id, fileName){},
			onProgress: function(id, fileName, loaded, total){},
			onComplete: function(id, fileName, responseJSON){
				ajax_pagina('upload_imagens','lista_iframe', album, '', '', '', '', '', '', '', div,'ajax_gc_adm', 'false');
			},
			onCancel: function(id, fileName){},

			messages: {
				// error messages, see qq.FileUploaderBasic for content            
			},
			showMessage: function(message){ alert(message); }  
		});
	}

	function compara_campos(nome_campo, nome_color, campo_numero)
	{
		var valida = true;

		var arr_nome = document.getElementsByName(nome_campo);
		if(arr_nome.length > 0)
		{
			for(var i=0; i<$('#'+campo_numero).val(); i++)
			{
				if(arr_nome[i].value)
				{
					if(arr_nome[i].value == nome_color)
					{
						valida = false;
						break;
					}
				}
			}
		}

		return valida;
	}

	function adicionaCampo_Resposta()
	{
		if($.trim($('#_nome').val()) != "")
		{
			var cont_campos = parseInt($('#_numero_campos_resposta').val());
			var resposta = $.trim($('#_resposta').val());
			//var tipo = $.trim($('#_tipo').val());
			var tipo = $("input[name='_tipo']:checked").val();

			if($.trim($('#_resposta').val()) != "")
			{
				if(compara_campos('_resposta_f[]', resposta, '_numero_campos_resposta'))
				{
					if(tipo == "1")
					{
						tipo_resposta = "Seleção";
					}
					else
					{
						tipo_resposta = "Descrição";
					}
					cont_campos = cont_campos + 1;
					var input = '';
					input += '<div class="itens">';
					input += '<label>'+resposta+' </label>';
					input += '<label> ('+tipo_resposta+')</label>';
					input += '<input name="_resposta_f[]" type="hidden" value="'+resposta+'" size="30" maxlength="50"/>';
					input += '<input name="_tipo_f[]" type="hidden" value="'+tipo+'" size="30" maxlength="50"/>';
					input += '<a href="#" class="del" onclick="javascript:removeCampo(\'_numero_campos_resposta\');"><img src="../imagens/site/resp-errada.png" align="absmiddle" ></a>';
					input += '</div>';

					$('#_numero_campos_resposta').val(cont_campos);
					$("#div_respostas").append(input);
					$('#_resposta').val("");
				}
				else
				{
					alert("A resposta "+resposta+" já foi inserido, por favor digite outra resposta.");
					$('#_resposta').val("");
					$('#_resposta').focus();
				}
			}
			else
			{
			}
		}
		else
		{
			alert("Por favor digite a Pergunta");
		}
	}


var mask = 
{
	money: function() 
	{
		var el = this
		,exec = function(v)
		{
			v = v.replace(/\D/g,"");
			v = new String(Number(v));
			var len = v.length;
			if (1== len)
			v = v.replace(/(\d)/,"0.0$1");
			else if (2 == len)
			v = v.replace(/(\d)/,"0.$1");
			else if (len > 2) 
			{
				v = v.replace(/(\d{2})$/,'.$1');
			}
		return v;
		};

		setTimeout(function(){
		el.value = exec(el.value);
		},1);
	}
}

	function data_picker(data)
	{
		$("#"+data).datepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: [
		'Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'
		],
		dayNamesMin: [
		'D','S','T','Q','Q','S','S','D'
		],
		dayNamesShort: [
		'Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'
		],
		monthNames: [
		'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro',
		'Outubro','Novembro','Dezembro'
		],
		monthNamesShort: [
		'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
		'Out','Nov','Dez'
		],
		nextText: 'Próximo',
		prevText: 'Anterior'

		});
	}

	function jav()
	{
		var date = new Date();
		//var newDate = new Date( date.getFullYear(), date.getMonth(1), 0 );
		var newDate = new Date( date.getFullYear(), 1, 0 );
		alert( newDate.getDate() );
	}

	function mensagens()
	{
		$.growlUI('Notificação', 'Tem pedidos pendentes para dar baixa!', 10000);
	}

	function ajax_pagina(acao_adm, acao, parametro, parametro_02, parametro_03, parametro_04, parametro_05, parametro_06, parametro_07, parametro_08, div, ambiente, animar) //13
	{
		var url_virtual = $("#url_virtual").val();
		var msg_confirma = true;
		url=ambiente+".php?acao_adm="+acao_adm+"&acao="+acao+"&parametro="+parametro;//url da página
		var nivel = ""; 
		switch (acao_adm)
		{
			case "respostas":
				switch(acao)
				{
					case "excluir":
						if(!confirmar("Tem certeza de que deseja excluir este item?")){
							msg_confirma = false;
						}
						
						url = url+"&id_pergunta="+parametro_02+"&_div="+div;
					break;
				}
			break;

			case "upload_imagens":
				switch(acao)
				{
					case "lista":
						url = url+"&_div="+div;
					break;
					case "lista_iframe":
						url = url_virtual+"gc/"+url+"&_div="+div;
						//url = url+"&_div="+div;
					break;
				}
			break;

			case "play_musica":
				switch(acao)
				{
					case "play":
						url = url+"&_div="+div;
					break;
				}
			break;

			case "lista_fotos":
				switch (acao)
				{
					case "excluir":
						if(!confirmar("Tem certeza de que deseja excluir esta imagem?")){
							msg_confirma = false;
						}
						url = url+"&_id_album="+parametro_02+"&_album="+parametro_03+"&_div="+div;
					break;
					
					case "excluir_grupo":
						if(!confirmar("Tem certeza de que deseja excluir esta(s) imagem(ns)?")){
							msg_confirma = false;
						}
						url = url+"&_id_album="+parametro_02+"&_album="+parametro_03+"&_div="+div;
					break;
				}
			break;
			
			case "lista_fotos_iframe":
				switch (acao)
				{
					case "lista":
						url = url_virtual+"gc/"+url+"&_div="+div;
						//nivel = "../";
					break;
					
					case "excluir":
						if(!confirmar("Tem certeza de que deseja excluir esta imagem?")){
							msg_confirma = false;
						}
						url = url_virtual+"gc/"+url+"&_id_album="+parametro_02+"&_div="+div;
					break;
				}
			break;
			
			case "materia_blog":
			switch(acao)
			{
				case "excluir":
					if(!confirmar("Tem certeza de que deseja excluir este item?")){
						msg_confirma = false;
					}
					url = url+"&_id_produto="+parametro_02+"&_div="+div;
				break;
			}
			
			case "empresa_contato":
			
				url = url+"&parametro="+parametro+"&parametro_02="+parametro_02+"&parametro_03="+parametro_03;
				
			break;
		break;
		}

		if(msg_confirma)
		{
			cont=document.getElementById(div);
			if(cont)
			{
				ajax_msg_site_adm(url,cont,"<img src=\""+url_virtual+"imagens/site/loading_02.gif\" />", animar);
			}
			//else{alert('no_div')}
		}
		else{
			//alert('hubo um erro na consulta');
		}
	}

	function ajax_msg_site_adm(url,cont,loading, animar)
	{
		function obterObjRequisicao()
		{
			if(window.XMLHttpRequest)
			{
				return new XMLHttpRequest();
			}
			else if(window.ActiveXObject)
			{
			  return new ActiveXObject("Microsoft.XMLHTTP");
			}
			return null;
		}

		var http = obterObjRequisicao();
		if(loading)
		{
			if(animar == "true")
			{
				$.blockUI({ css: { 
					message: 'just',
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .4, 
					color: '#fff' 
				} }); 
			}
			else
			{
				//$.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });
				cont.innerHTML=loading;
			}
			
		}
		if(http)
		{
			http.onreadystatechange = processar;
			http.open("GET", url, true);
			http.send(null);
		}
		function processar()
		{
			/*if(loading==1)
			{
				cont.innerHTML="Loading |readst="+http.readyState+" | status "+http.status;
			}*/

			if(http.readyState == 4)
			{ 
				if(http.status == 200)
				{
					var bb = true;
					cont.innerHTML=http.responseText;
					var text = http.responseText;
					if(text.match(/.*atualizado.*/i))
					{
						refresh_carrinho(text);
					}
					if(text.match(/.*email_enviado_sucesso.*/i))
					{
						alert("Email enviado com sucesso!");
						bb = false;
					}
					if(text.match(/.*data_modificado.*/i))
					{
						alert("Data modificado com sucesso!");
						bb = false;
					}
					if(text.match(/.*campo_valida.*/i))
					{
						var campo_data = text.split(" ");
						mostra_cont = false;
						$("#div_valida").html('<b style=\"color:#A41000;\">Nome não disponivel.</b> Por favor digite outro nome.'); 
						$("#_nome").focus();
						
					}
					if(animar == "true")
					{
						setTimeout($.unblockUI, 0);
					}
					if(bb)
					{
						
					}
				}
			}
		}
		return false;
	}

function refresh_carrinho(row)
{
	var quebra=row.split("-");
	var num_rows = parseInt($('#table_carrinho tr').length) - 3;
	
	var peso_row = parseInt(quebra[1]);
	var custo_row = parseFloat(quebra[2]);
	var row = quebra[3];
	
	var peso_total = 0;
	var custo_total = 0;
	
	var bb = false;
	
	for(var i=1; i<=num_rows ; i++)
	{
		if(i != row)
		{
			for(var j=4; j<7; j++)
			{
				if(j == 4)
				{
					peso_total = peso_total + parseInt($("tr:eq("+i+") td:eq("+j+")").html());
				}
				else
				{
					custo_total = custo_total + moeda2float($.trim($("tr:eq("+i+") td:eq("+j+")").html()));
				}
				//alert($("tr:eq("+i+") td:eq("+j+")").html());
				j++;
			}
		}
		else
		{
			$("tr:eq("+row+") td:eq(4)").html(peso_row);
			$("tr:eq("+row+") td:eq(6)").html(float2moeda(custo_row));
		}
		bb = true;
	}
	
	if(bb)
	{
		peso_total = (peso_total + peso_row)/1000;
		custo_total = custo_total + custo_row;
		$('#peso_total').val(peso_total);
		$('#preco_total').val(custo_total);
		num_rows = num_rows + 1;
		$("tr:eq("+num_rows+") td:eq(2)").html('0');
		num_rows = num_rows + 1;
		$("tr:eq("+num_rows+") td:eq(2)").html(float2moeda(custo_total));
		
	}
	
	//alert($('#table_carrinho tr').length);
	/*$("tr:eq(2) td:eq(2)").css("color", "red");
	alert($("tr:eq(2) td:eq(2)").html());*/
	return false;

}

	function refresh_frete(row)
	{
		var quebra=row.split("-");
		var num_rows = parseInt($('#table_carrinho tr').length) - 3;
		var custo_frete = parseFloat(quebra[1]);
		var custo_total = 0;
		var bb = false;

		for(var i=1; i<=num_rows ; i++)
		{
			custo_total = custo_total + moeda2float($.trim($("tr:eq("+i+") td:eq(6)").html()));
			bb = true;
		}

		if(bb)
		{
			custo_total = custo_total + custo_frete;
			$('#preco_total').val(custo_total);
			num_rows = num_rows + 1;
			$("tr:eq("+num_rows+") td:eq(2)").html(float2moeda(custo_frete));
			num_rows = num_rows + 1;
			$("tr:eq("+num_rows+") td:eq(2)").html(float2moeda(custo_total));
			$("#cep_01").val('');
			$("#cep_02").val('');
		}
		return false;
	}

	function moeda2float(moeda)
	{
		moeda = moeda.replace(".","");
		moeda = moeda.replace(",",".");
		return parseFloat(moeda);
	}

	function float2moeda(num) 
	{
		x = 0;
		if(num<0) {
		  num = Math.abs(num);
		  x = 1;
		}
		if(isNaN(num)) num = "0";
		  cents = Math.floor((num*100+0.5)%100);

		num = Math.floor((num*100+0.5)/100).toString();

		if(cents < 10) cents = "0" + cents;
			for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
				num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3));
				ret = num + ',' + cents;
		if (x == 1) ret = ' - ' + ret;return ret;
	}

	function ver_enquete(id_projeto, id_quiz, id_email)
	{
		fancy_function("../gc/modulos/ajax_adm.php?acao=ver_enquete&dados="+id_projeto+"_"+id_quiz+"_"+id_email+"",600,450,"iframe");
	}

	function produto_agrupa()
	{
		ajaxHTML(document.getElementById('div_produto_agrupa').id,'../inc/busca_ajax.php?tipo=produto_agrupa&parametro='+$("#_id_sub_categoria").val());
	}

	//Verifica se a URL é valida
	function checkWeb(web)
	{
		var er = new RegExp(/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/);
		if(typeof(web) == "string")
		{
			if(er.test(web))
			{
				return true;
			}
		}
		else if(typeof(web) == "object")
		{
			if(er.test(web.value))
			{
				return true; 
			}
		}
		else
		{
			return false;
		}
	}
	
	function for_radio(id)
	{
		if(id != "")
		{
			$('#check_'+id).attr('checked', true); 
		}
	}
	
	function jqCheckAll(name, flag)
	{ 
		if (flag == 0)
		{
			//$("form#" + id + " INPUT[name=" + name + "][type='checkbox']").attr('checked', false);
			$('[name='+name+']').attr('checked', false);
		}
		else
		{
			//$("form#" + id + " INPUT[name=" + name + "][type='checkbox']").attr('checked', true);		
			$('[name='+name+']').attr('checked', true);
		}
	}

	function apagar_imagens(id_album, name, div) {         
		var ids_imgs = [];
		var cont = 0;
		$('[name='+name+']:checked').each(function() {
			ids_imgs.push($(this).val());
			cont++;
		});
		
		if($.trim(ids_imgs) != "")
		{
			ajax_pagina('lista_fotos','excluir_grupo', ''+ids_imgs+'', ''+id_album+'', '', '', '', '', '', '', ''+div+'', 'ajax_gc_adm', 'false');
		}
		else
		{
			alert('Por favor, selecione pelo menos um item')
		}
	}

	function valida_nome(novo_nome, nome_atual, tabela)
	{
		if(novo_nome.length > 2 && novo_nome.length < 300)
		{
			if(novo_nome != nome_atual)
			{
				ajax_pagina('valida_campo', ''+tabela+'', ''+novo_nome+'', '', '', '', '', '', '', '', 'div_valida', 'ajax_gc_adm', 'false');
			}
		}
	}
	
	function adiciona_blog()
	{
		var mensagem = "";
		var campos_validados = true;
		var cont_campos = parseInt($('#_numero_campos_blog').val());
		
		/*if($("#_nome_blog").val() == "")
		{
			var mensagem = "Por favor digite o Título.";
			campos_validados = false;
		}*/
		
		if($("#_id_album_blog").val() == "")
		{
			var mensagem = "Por favor selecione um Album.";
			campos_validados = false;
		}
		
		if(!campos_validados)
		{
			alert(mensagem);
		}
		else
		{
			var url_virtual = $("#url_virtual").val();
			
			cont_campos = cont_campos + 1;
			
			var id_album = $("#_id_album_blog").val();		
			var nome_album = $("#_id_album_blog option:selected").text();
			var title = $("#_nome_blog").val();
			//var descricao = $("textarea#_corpo_blog").val();
			var descricao = tinyMCE.get('_corpo_blog').getContent();
			
			var input = '';
			input += '<div class="blog_materia">';
			
			//input += '<b>Título: </b><input name="_nome_blog_js[]" type="text" value="'+title+'" size="30" maxlength="50" />';
			input += '<a href="#" class="del materia_del" onclick="javascript:removeCampo(\'_numero_campos_blog\');"><img src="'+url_virtual+'imagens/site/resp-errada.png" align="absmiddle" ></a><br><br>';
			input += '<b>Álbum: '+nome_album+'&nbsp;</b>';
			input += '<input type="hidden" name="_id_album_blog_js[]" value="'+id_album+'">';
			input += '<a id="add" class="ajuda" href="javascript:popup_geral_02(\'album_popup\',\'editar_album\', \''+id_album+'_'+nome_album+'\');"><img src="'+url_virtual+'imagens/gc/btn_editor.gif" align="absmiddle" ><span>Clique aqui para editar o Album.</span></a><br>';		
			input += '<b>Descrição: </b><textarea name="_corpo_blog_js[]" cols="80" rows="4">'+descricao+'</textarea><br/><br/>';
			
			input += '<br/></div>';
			
			
			
			$("#div_blog_novo").append(input);
			$('#_numero_campos_blog').val(cont_campos);	
			$("#_nome_blog").val("");
			$("textarea#_corpo_blog").val("");
			
			$('#_id_album_blog option:eq(0)').attr('selected', 'selected')
			
		}
	}
	
	function url_blog(url, id_imagem)
	{
		if($.trim(url) != "")
		{	
			var url_virtual = $("#url_virtual").val();
			//ajax_pagina('edita_imagem_url', 'edita', ''+id_imagem+'', ''+url+'', '', '', '', '', '', '', 'div_valida', 'ajax_gc_adm', 'false');
			$.ajax({
			url: url_virtual+"gc/ajax_gc_adm.php",
			data: {acao_adm: "edita_imagem_url", acao: "edita", id: id_imagem, url: url},
			cache: false,
			success: function(html)
			{
				if(html.match(/.*sem_registros.*/i))
				{
					
				}
				else
				{	
					
				}
			}
			});		
		}
	}
	
	function popup_geral_02(acao_adm, acao, parametro)
	{
		var url_virtual = $("#url_virtual").val();
		
		x_popup_pagina = 981;
		y_popup_pagina = 755;
		switch (acao_adm)
		{		
			case "blog":
				fancy_function("../gc/modulos/ajax_adm.php?acao="+acao+"",800,600,"iframe");			
			break;
			
			case "newsletter":
				fancy_function(""+url_virtual+"ajax/popup_pagina.php?acao_adm="+acao_adm+"",x_popup_pagina,y_popup_pagina,"iframe");
			break;
			
			case "album_popup":
				fancy_function(""+url_virtual+"gc/modulos/ajax_adm.php?acao_adm="+acao_adm+"&acao="+acao+"&parametro="+parametro+"",x_popup_pagina,y_popup_pagina,"iframe");
			break;
		}
	}
	
	function removeCampo(campo_numero) 
	{
		var cont_campos = $('#'+campo_numero).val();
		$('.del').live('click', function(){
			$(this).parent().remove();
			cont_campos = cont_campos - 1;
			calcula_valores();
			$('#'+campo_numero).val(cont_campos);
			return false;
		});
	}

	function removeCampo_popup() 
	{
		$('.del').live('click', function(){
			$(this).parent().remove();
			return false;
		});
	}
	
	function plugin_masonry(div)
	{
		$('#'+div).masonry({
				itemSelector: '.box',
				columnWidth: 2,
				isAnimated: !Modernizr.csstransitions,
				isFitWidth: true
		});
	}
	
	function filtro_menu(value) 
	{
		
		if(value != "*")
		{			
			$('div.element').not('div.'+value+'').fadeOut('slow', function() {
				 $("div.element").not('div.'+value+'').removeClass('box');
			});
		}
		
		if(value == "*")
		{
			$("div.element").addClass('box');
			$("div.element").fadeIn();
		}
		else
		{
			$("div.element"+"."+value).addClass('box');
			//$("div."+value).fadeIn(100);
			$("div.element"+"."+value).fadeIn();
		}
		
		setInterval(function() {
			$('#scroll_infinito').masonry( 'reloadItems' );
			plugin_masonry('scroll_infinito');
		}, 500);  
		
		return false;
	}

	
	function popup_menu(acao_adm)
	{
		x_popup_pagina = 600;
		y_popup_pagina = 400;
		
		var url_virtual = $("#url_virtual").val();
		
		switch (acao_adm)
		{					
			case "newsletter":
				x_popup_pagina = 499;
				y_popup_pagina = 282;
				fancy_function(""+url_virtual+"ajax/popup_pagina.php?acao_adm="+acao_adm+"",x_popup_pagina,y_popup_pagina,"iframe");
			break;			
		}
		
	}
	 
	$(document).ready(function ()
	{
		
		
		//MENU DE PRODUTOS FILTRO MASONRY
		$('.filtro_menu').click(function () {
			$this = $(this);
			
			if ($this.hasClass('active')) 
			{
				$('.filtro_menu').removeClass('active');
				filtro_menu('*')
			}
			else
			{
				
				$('.filtro_menu').removeClass('active');
				$this.addClass('active');
				value = $this.attr('data-option-value');
				filtro_menu(value)
			}
		});
		
		//MENU FUNCAO POPUP
		$('.popup').click(function ()
		{
			$this = $(this);
			var acao_adm = $this.attr('data-option-value');
			popup_menu(acao_adm);
		});
		
		 
	});