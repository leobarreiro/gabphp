/**
 * Site Oficial
 * http://cielnews.com
 * Arquivo Javascript
 * 
 * Data de Criação: 06/09/2008

 * @author Leopoldo Braga Barreiro
 * 
 * @version 2008
 * 
 * $Id: $
 * 
*/

// Cria um Objeto Ajax

function getHTTPObject() {

	if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else {
		if (window.ActiveXObject) {
			var prefixes = ["MSXML2", "Microsoft", "MSXML", "MSXML3"];
			for (var i = 0; i < prefixes.length; i++) {
				try {
					return new ActiveXObject(prefixes[i] + ".XMLHTTP");
				} catch (e) {}
			}
		}
	}
	return false;
}

function realizaReq() {

	var url = this.url + '?' + this.dados;
	document.getElementById(this.campo).innerHTML = '<div class="aviso">Atualizando...</div>';
	
	xmlHttp = new getHTTPObject();
	xmlHttp.open("GET", url, true);
	
	campoHtml = this.campo;
	
	xmlHttp.onreadystatechange=function() {
		if (xmlHttp.readyState==4) {
			var txt = unescape(xmlHttp.responseText);
			document.getElementById(campoHtml).innerHTML = txt;
		}
	}
	xmlHttp.send(null);
}

/**
 * Cria uma Requisicao para Envio
 * @param String URL
 * @param String Dados passados por parametro
 * @param String ID Campo a atualizar
*/

function RequisicaoAjax(url, dadosParam, campoHtml) {

	this.url = url;
	this.dados = dadosParam;
	this.campo = campoHtml;
	this.realizaRequisicao = realizaReq;

}
