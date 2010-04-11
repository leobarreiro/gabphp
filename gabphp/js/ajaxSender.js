/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Objeto AjaxSender
    * Validar campos de formulário e enviar mensagem via POST com Ajax
    * Data de Criação: 11/04/2010
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

function AjaxSender()
{
	this.required           = new Array();
	this.namedField         = new Array();
	this.warning            = new Array();
	this.typeField	 		= new Array();
	this.warningField       = "instructions";
	this.styleWarning       = "warning-validate-field";
	this.styleClear         = "clear-validate-field";
	this.warningInstruction = "O campo '<b>[errorField]</b>' deve ser informado.";
	this.defaultInstruction = "Preencha o formulário abaixo para entrar em contato conosco. Brevemente estaremos respondendo sua mensagem.";
	this.waitInstruction 	= "Aguarde, enviando a mensagem.";
	this.messageToSend      = "ok=0";
	this.imgSend 			= null;
	this.imgSrcWait 		= "img/ajax-loader.gif";
	this.imgSrcOriginal 	= "";
	this.imgOnClick 		= "";
	this.formMessage        = null;
	this.url                = "";
	this.prepared 			= false;
	
	// Metodos
	
	this.init = function(f, img)
	{
		var required 			= new Array();
		var typeField 			= new Array();
		var namedField 			= new Array();
		var warning 			= new Array();
		this.formMessage 		= f;
		this.url 				= f.action;
		for (var i=0; i<f.elements.length; i++)
		{
			if (f.elements[i].title.indexOf("*") >= 0)
			{
				required[required.length] 		= f.elements[i].name;
				typeField[typeField.length] 	= f.elements[i].className;
				namedField[namedField.length] 	= f.elements[i].title;
				warning[warning.length] 		= f.elements[i].name + "field";
			}
		}
		this.required 		= required;
		this.typeField 		= typeField;
		this.namedField 	= namedField;
		this.warning 		= warning;
		this.imgSend 		= img;
		this.imgSrcOriginal = img.src;
		return true;
	}
	
	this.createHttpObject = function()
	{
		if (navigator.appName == "Microsoft Internet Explorer")
		{
			return new ActiveXObject("Microsoft.http");
		}
		else
		{
			return new XMLHttpRequest();
		}
	}
	
	this.validateRegex = function validateType(type, value)
	{
		var regex = null;
		if (type == "email") {
			//regex = /^(\w+[\+\.\w-]{1,60})*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/;
			regex = /^([A-Za-zÁáéíóúãõâêôàç._]{2,})+(\w{0,})+([@]{1})+(\w{2,})+([.]{1,})+([a-zA-Z]{2,3})+(((\.{1})+([a-zA-Z]{2})){0,1})$/;
		}
		else if (type == "name") {
			regex = /^([A-Za-zÁáéíóúãõâêôàç]{2,})+\s+([A-Za-zÁáéíóúãõâêôàç]{2,})/;
		}
		else if (type == "subject") {
			//regex = /^([A-Za-zçõ]{1,60})*$/;
			regex = /([A-Za-z]{1,})+([áéíóúãõâêôàç]{0,})+([A-Za-z]{1,})+(\s{0,})/;
		}
		else if (type == "message") {
			//regex = /^([A-Za-z]{1,60})*$/;
			regex = /([A-Za-z]{2,})/;
		}
		else {
			return true;
		}
		return regex.test(value);
	}
	
	this.prepare = function()
	{
		// limpar estilos
		for (var n=0; n < this.warning.length; n++)
		{
			document.getElementById(this.warning[n]).setAttribute("class", this.styleClear);
		}
	
		// verificar campos obrigatorios
		try
		{
			for (var n=0; n < this.required.length; n++)
			{
				if (!(this.validateRegex(this.typeField[n], document.getElementById(this.required[n]).value)))
				{
					//alert(this.typeField[n] + " -> " + document.getElementById(this.required[n]).value);
					document.getElementById(this.warning[n]).setAttribute("class", this.styleWarning);
					document.getElementById(this.required[n]).focus();
					var warningMessage = this.warningInstruction.replace("[errorField]", this.namedField[n]);
					document.getElementById(this.warningField).innerHTML = warningMessage;
					this.prepared = false;
					return false;
				}
			}
		}
		catch(e)
		{
			this.errorReport(e);
			this.prepared = false;
			return false;
		}
		// concatenar campos para mensagem
		for (var n=0; n< this.formMessage.elements.length; n++)
		{
			this.messageToSend += "&" + this.formMessage.elements[n].name + "=" + this.formMessage.elements[n].value;
		}
		this.prepared = true;
		return true;
	}
	
	// Enviar Mensagem
	this.send = function()
	{
		if (this.prepared)
		{
			try
			{
				document.getElementById(this.warningField).innerHTML = this.waitInstruction;
				this.imgSend.src = this.imgSrcWait;
				http = this.createHttpObject();
				http.open("POST", this.url, true);
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.setRequestHeader("Content-length", this.messageToSend.length);
				http.setRequestHeader("Connection", "close");
				http.onreadystatechange = function()
				{
					if (http.readyState == 4 && http.status == 200)
					{
						ajaxSend.formMessage.reset();
						ajaxSend.imgSend.src = ajaxSend.imgSrcOriginal;
						document.getElementById(ajaxSend.warningField).innerHTML = http.responseText;
					}
				}
				http.send(this.messageToSend);
				return true;
			}
			catch(e)
			{
				this.errorReport(e);
				return false;
			}
		}
		else
		{
			this.imgSend.src = this.imgSrcOriginal;
			return false;
		}
	}
	
	this.errorReport = function(e)
	{
		alert("(" + e.name + ") " + e.message);
	}
}

function ajaxSendFormValidate(f, img)
{
	try
	{
		ajaxSend.init(f, img);
		ajaxSend.prepare();
		ajaxSend.send();
	}
	catch(e)
	{
		alert(e.message);
	}
}

ajaxSend = new AjaxSender();