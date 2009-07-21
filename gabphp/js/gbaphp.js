/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Funções Javascript, DOM, Ajax
    * Data de Criação: 05/07/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: gbaphp.js 47 2008-07-05 06:15:17Z leobba $
    *     
    * Casos de uso : 
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
}

function verificaEstadoAjax() {
	if (obHttp.readyState==4) {
		txtHttp = unescape(obHttp.responseText);
		if (txtHttp.length > 0) {
			try {
				document.getElementById(stAreaDom).innerHTML = txtHttp;
			} catch(e) {
				alert(stAreaDom);
				alert(e.message);
			}
		} else {
			alert('Cabeção');
		}
	}
	return true;
}

function controleAjax(stPrograma, stAcao, stCpDom, inId) {
	obHttp = getHTTPObject();
	if (obHttp) {
		var stUrl = stPrograma + "?" + "acao=" + stAcao + "&cpDom=" + stCpDom + "&id=" + inId;
		obHttp.open("GET", stUrl, true);
		obHttp.onreadystatechange = verificaEstadoAjax;
		obHttp.send(null);
	}
}
