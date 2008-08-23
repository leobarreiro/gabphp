/**
* PhpGB Framework 
* See news and latest version in: http://phpgb.cielnews.com
* Creation Date: 2008-04-20
* This script has been extracted from Oracle tutorial
* http://www.oracle.com/technology/pub/articles/oracle_php_cookbook/ullman-ajax.html
* Adapted from phpGB by leobba
*/



/*
* example to use the ajax validator:
* <input name="email" type="text" size="30" maxlength="60" onchange="sendRequest('validateMail.php', 'email='+this.form.email.value, 'email_label')" />
* <span id="email_label"></span>
*/ 

// Creates a new Request Object

function createRequestObject() {
	var ro;
	if (navigator.appName == "Microsoft Internet Explorer") {
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		ro = new XMLHttpRequest();
	}
	return ro;
}

// Called in sendRequest Function
 
function handleResponse(http, innerHTMLField) {
	if (innerHTMLField) {
		if (http.readyState == 4) {
			document.getElementById(innerHTMLField).innerHTML = http.responseText;
		}	
	} else {
		alert(http.responseText);
	}
}

// Called in event to html object

function sendRequest(url, stringSending, innerHTMLField) {
	var http = createRequestObject();
	http.open('get', urlVars + '?' + encodeURIComponent(stringSending));
	http.onreadystatechange = handleResponse(http, innerHTMLField);
	http.send(null);
}
