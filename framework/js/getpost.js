function mascaraData(idCampo) {
	var nums = new Array(10);
	nums[0] = '0';
	nums[1] = '1';
	nums[2] = '2';
	nums[3] = '3';
	nums[4] = '4';
	nums[5] = '5';
	nums[6] = '6';
	nums[7] = '7';
	nums[8] = '8';
	nums[9] = '9';
	var data = document.getElementById(idCampo).value;
	var ultCaracter = data.substring((data.length - 1), data.length);
	var nro = false;
	for (w=0; w<10; w++) {
		if (ultCaracter == nums[w]) {
			nro = true;
			break;
		}
	}
	if (nro == false) {
		document.getElementById(idCampo).value = data.substring(0, (data.length - 1));
		return true;
	}
	
	if (data.length == 2) {
		data = data + '/';
		document.getElementById(idCampo).value = data;
		return true;              
	}
	if (data.length == 5) {
		data = data + '/';
		document.getElementById(idCampo).value = data;
		return true;
	}
}
/*
TODO: A função solo_numeros deve cair em Desuso com a implementação de componentes em todas as páginas
*/
function solo_numeros(input) {
	nums = new Array(10);
	nums[0] = '0';
	nums[1] = '1';
	nums[2] = '2';
	nums[3] = '3';
	nums[4] = '4';
	nums[5] = '5';
	nums[6] = '6';
	nums[7] = '7';
	nums[8] = '8';
	nums[9] = '9';
	var valor = input.value;
	var x = valor.length;
	var nuevovalor = '';
	for (q=0; q<x; ++q) {
		var caracter = valor.substring(q,(q+1));
		for (w=0; w<10; w++) {
			if (caracter == nums[w]) {
				nuevovalor = nuevovalor+''+caracter;
				break;
			}
		}
	}
	input.value = nuevovalor;
}
// 07/02/2005
function doctel(input) {
	//elimina las rayas del número
	var valor = input.value;
	while(valor.lastIndexOf("-")>=0){valor = valor.replace("-","");}
	while(valor.lastIndexOf(")")>=0){valor = valor.replace(")","");}
	while(valor.lastIndexOf("(")>=0){valor = valor.replace("(","");}
	//formatea el número nuevo
	var ancho = valor.length;
	if (ancho==5){var dos=valor.substring(0,1);var uno=valor.substring(1,5);valor=dos+"-"+uno;}
	if (ancho==6){var dos=valor.substring(0,2);var uno=valor.substring(2,6);valor=dos+"-"+uno;}
	if (ancho==7){var dos=valor.substring(0,3);var uno=valor.substring(3,7);valor=dos+"-"+uno;}
	if (ancho==8){var dos=valor.substring(0,4);var uno=valor.substring(4,8);valor=dos+"-"+uno;}
	if (ancho==9){var tres=valor.substring(0,1);var dos=valor.substring(1,5);var uno=valor.substring(5,9);valor=tres+")"+dos+"-"+uno;}
	if (ancho==10){var tres=valor.substring(0,2);var dos=valor.substring(2,6);var uno=valor.substring(6,10);valor="("+tres+")"+dos+"-"+uno;}
	//inputa al campo HTML el nuevo valor
	input.value = valor;
	//return autoTab(input, 13);
}
function doccpf(input) {
	//elimina los puntos del número
	var valor = input.value;
	while(valor.lastIndexOf(".")>0){valor=valor.replace(".","");}
	//elimina las barras del número
	while(valor.lastIndexOf("/")>0){valor=valor.replace("/","");}
	//formatea el número nuevo
	var ancho = valor.length;
	if (ancho==3){var dos=valor.substring(0,1);var uno=valor.substring(1,3);valor=dos+"/"+uno;}
	if (ancho==4){var decenas=valor.substring(0,2);var uno=valor.substring(2,4);valor=decenas+"/"+uno;}
	if (ancho==5){var dos=valor.substring(0,3);var uno=valor.substring(3,5);valor=dos+"/"+uno;}
	if (ancho==6){var tres=valor.substring(0,1);var dos=valor.substring(1,4);var uno=valor.substring(4,6);valor=tres+"."+dos+"/"+uno;}
	if (ancho==7){var tres=valor.substring(0,2);var dos=valor.substring(2,5);var uno=valor.substring(5,7);valor=tres+"."+dos+"/"+uno;}
	if (ancho==8){var tres=valor.substring(0,3);var dos=valor.substring(3,6);var uno=valor.substring(6,8);valor=tres+"."+dos+"/"+uno;}
	if (ancho==9){var cuatro=valor.substring(0,1);var tres=valor.substring(1,4);var dos=valor.substring(4,7);var uno=valor.substring(7,9);valor=cuatro+"."+tres+"."+dos+"/"+uno;}
	if (ancho==10){var cuatro=valor.substring(0,2);var tres=valor.substring(2,5);var dos=valor.substring(5,8);var uno=valor.substring(8,10);valor=cuatro+"."+tres+"."+dos+"/"+uno;}
	if (ancho==11){var cuatro=valor.substring(0,3);var tres=valor.substring(3,6);var dos=valor.substring(6,9);var uno=valor.substring(9,11);valor=cuatro+"."+tres+"."+dos+"/"+uno;}
	//inputa al campo HTML el nuevo valor
	input.value=valor;
	//autoTab(input, 19);
}
function doccnpj(input) {
	//elimina los puntos del número
	var valor = input.value;
	while(valor.lastIndexOf(".")>0){valor=valor.replace(".","");}
	//elimina las barras del número
	while(valor.lastIndexOf("/")>0){valor=valor.replace("/","");}
	//elimina las rayas del número
	while(valor.lastIndexOf("-")>0){valor=valor.replace("-","");}
	//formatea el número nuevo
	var ancho = valor.length;
	if (ancho==3){var dos=valor.substring(0,1);var uno=valor.substring(1,3);valor=dos+"-"+uno;}
	if (ancho==4){var dos=valor.substring(0,2);var uno=valor.substring(2,4);valor=valor=dos+"-"+uno;}
	if (ancho==5){var dos=valor.substring(0,3);var uno=valor.substring(3,5);valor=valor=dos+"-"+uno;}
	if (ancho==6){var dos=valor.substring(0,4);var uno=valor.substring(4,6);valor=valor=dos+"-"+uno;}
	if (ancho==7){var tres=valor.substring(0,1);var dos=valor.substring(1,5);var uno=valor.substring(5,7);valor=tres+"/"+dos+"-"+uno;}
	if (ancho==8){var tres=valor.substring(0,2);var dos=valor.substring(2,6);var uno=valor.substring(6,8);valor=tres+"/"+dos+"-"+uno;}
	if (ancho==9){var tres=valor.substring(0,3);var dos=valor.substring(3,7);var uno=valor.substring(7,9);valor=tres+"/"+dos+"-"+uno;}
	if (ancho==10){var cuatro=valor.substring(0,1);var tres=valor.substring(1,4);var dos=valor.substring(4,8);var uno=valor.substring(8,10);valor=cuatro+"."+tres+"/"+dos+"-"+uno;}
	if (ancho==11){var cuatro=valor.substring(0,2);var tres=valor.substring(2,5);var dos=valor.substring(5,9);var uno=valor.substring(9,11);valor=cuatro+"."+tres+"/"+dos+"-"+uno;}
	if (ancho==12){var cuatro=valor.substring(0,3);var tres=valor.substring(3,6);var dos=valor.substring(6,10);var uno=valor.substring(10,12);valor=cuatro+"."+tres+"/"+dos+"-"+uno;}
	if (ancho==13){var cinco=valor.substring(0,1);var cuatro=valor.substring(1,4);var tres=valor.substring(4,7);var dos=valor.substring(7,11);var uno=valor.substring(11,13);valor=cinco+"."+cuatro+"."+tres+"/"+dos+"-"+uno;}
	if (ancho==14){var cinco=valor.substring(0,2);var cuatro=valor.substring(2,5);var tres=valor.substring(5,8);var dos=valor.substring(8,12);var uno=valor.substring(12,14);valor=cinco+"."+cuatro+"."+tres+"/"+dos+"-"+uno;}
	//inputa al campo HTML el nuevo valor
	input.value=valor;
	//autoTab(input, 18);
}
// modificada 04/02/2005
//ahora trabaja con puntos entre centenas, millares y millones
function reales(input) {
	//elimina los puntos del número
	var valor = input.value;
	while(valor.lastIndexOf(".")>=0){valor=valor.replace(".","");}
	//elimina las comas del número
	while(valor.lastIndexOf(",")>0){valor=valor.replace(",","");}
	//formatea el número nuevo
	var ancho = valor.length;
	if (ancho==3){var unidades=valor.substring(0,1);var centavos=valor.substring(1,3);valor=unidades+","+centavos;}
	if (ancho==4){var decenas=valor.substring(0,2);var centavos=valor.substring(2,4);valor=decenas+","+centavos;}
	if (ancho==5){var centenas=valor.substring(0,3);var centavos=valor.substring(3,5);valor=centenas+","+centavos;}
	if (ancho==6){var millares=valor.substring(0,1);var centenas=valor.substring(1,4);var centavos=valor.substring(4,6);valor=millares+"."+centenas+","+centavos;}
	if (ancho==7){var millares=valor.substring(0,2);var centenas=valor.substring(2,5);var centavos=valor.substring(5,7);valor=millares+"."+centenas+","+centavos;}
	if (ancho==8){var millares=valor.substring(0,3);var centenas=valor.substring(3,6);var centavos=valor.substring(6,8);valor=millares+"."+centenas+","+centavos;}
	if (ancho==9){var millones=valor.substring(0,1);var millares=valor.substring(1,4);var centenas=valor.substring(4,7);var centavos=valor.substring(7,9);valor=millones+"."+millares+"."+centenas+","+centavos;}
	if (ancho==10){var millones=valor.substring(0,2);var millares=valor.substring(2,5);var centenas=valor.substring(5,8);var centavos=valor.substring(8,10);valor=millones+"."+millares+"."+centenas+","+centavos;}
	if (ancho==11){var millones=valor.substring(0,3);var millares=valor.substring(3,6);var centenas=valor.substring(6,9);var centavos=valor.substring(9,11);valor=millones+"."+millares+"."+centenas+","+centavos;}
	//inputa al campo HTML el nuevo valor
	input.value = valor;
	//autoTab(input, 14);
}
//funcion hora
function hora(input) {
	var valor = input.value;
	var valor = valor.replace(":","");
	var ancho = valor.length;
	if (ancho > 2) {
		var antes_punto = valor.substring(0,(ancho-2));
		var ancho2 = antes_punto.length;
		var despues_punto = valor.substring((ancho-2),ancho);
		var nuevo_valor = antes_punto+":"+despues_punto;
		if (nuevo_valor != ':') {
			input.value=nuevo_valor;
		}
	}
	//return autoTab(input, 5);
}
//funcion fecha
//30/12/2004
function fecha(input) {
	var valor = input.value;
	var barra = valor.lastIndexOf("/");
	while (barra>0) {
		valor = valor.replace("/","");
		barra = valor.lastIndexOf("/");
	}
	var ancho = valor.length;
	if (ancho==4) {
		var dia = valor.substring(0,2);
		var mes = valor.substring(2,4);
		var nuevo_valor = dia+'/'+mes;
		input.value = nuevo_valor;
	}
	if (ancho==5) {
		var dia = valor.substring(0,2);
		var mes = valor.substring(2,4);
		var anho = valor.substring(4,5);
		var nuevo_valor = dia+'/'+mes+'/'+anho;
		input.value = nuevo_valor;
	}
	if (ancho==8) {
		var dia = valor.substring(0,2);
		var mes = valor.substring(2,4);
		var anho = valor.substring(4,8);
		var nuevo_valor = dia+'/'+mes+'/'+anho;
		input.value = nuevo_valor;
	}
	//return autoTab(input, 10);
}
// revisada 2/05/2005
// ahora funciona con cualquier navegador
// autoTab(input, 14);
function autoTab(input, len) {
	if (input.value.length==len || input.value.length>len) {
		var todo=input.form.elements.length;
		for (z=0;z<todo;++z) {
			if (input.form.elements[z].name == input.name) {
				ind=z+1;
				break;
			}
		}
		if (input.form.elements[ind]) {
			input.form.elements[ind].focus();
		}
	}
}

function openWindow(lugar, wdt, hgt) {
	var height = screen.availHeight;
	var width = screen.availWidth;
	// WinWidth y WinHeight son las variables que definen el tamaño de la ventanilla
	var iniX = (width/2)-(wdt/2)
	var iniY = (height/2)-(hgt/2)
	winStats='toolbar=no,location=no,directories=no,menubar=no,status=no,'
	winStats+='resizable=yes,scrollbars=yes,width='+wdt+',height='+hgt+''
	if (navigator.appName.indexOf("Microsoft") >= 0) {
		winStats+=',left='+iniX+',top='+iniY+''
	}
	else {
		winStats+=',screenX='+iniX+',screenY='+iniY+''
	}
	window.open(lugar, "adwindow", winStats);
}
// 27/01/2007
// Possibilita Imprimir Documentos
function ImprimeDocum() {
	if (document.organiza) {
		var altura = 400;
		var largura = 650;
		var tgt = 'PagImpr';
		var height = screen.availHeight;
		var width = screen.availWidth;
		var iniX = (width/2) - (largura/2);
		var iniY = (height/2) - (altura/2);
		var targetAtual = document.organiza.target;
		
		var wSt='toolbar=no,location=no,directories=no,menubar=no,status=no,';
		wSt+='resizable=yes,scrollbars=yes,width='+largura+',height='+altura+'';
		if (navigator.appName.indexOf("Microsoft") >= 0) {
			wSt+=',left='+iniX+',top='+iniY+'';
		} else {
			wSt+=',screenX='+iniX+',screenY='+iniY+'';
		}
		var janela = window.open('', tgt, wSt);
		if (janela) {
			document.organiza.target = tgt;
			document.organiza.sbImprDocum.value = '1';
			document.organiza.submit();
			document.organiza.target = targetAtual;
			document.organiza.sbImprDocum.value = '0';
		} else {
			alert(janela);
		}
	} else {
		alert('Página sem suporte a Impressão');
	}
}
// Recupera coordenadas X e Y do Mouse
//(c) 1999-2001 Zone Web

function getMouseXY(e) {
	if (IE) { //para IE
		tempX = event.clientX + document.body.scrollLeft;
		tempY = event.clientY + document.body.scrollTop;
	} else { //para netscape
		tempX = e.pageX;
		tempY = e.pageY;
	}
	if (tempX < 0) {
		tempX = 0;
	}
	if (tempY < 0) {
		tempY = 0;
	}
	return true;
}

function GetCoordMouse() {
	alert('X: '+tempX+' Y: '+tempY);
}
function GetCoordX() {
	return tempX;
}
function GetCoordY() {
	return tempY;
}

var IE = document.all?true:false;
if (!IE) {
	document.captureEvents(Event.MOUSEMOVE)
}

document.onmousemove = getMouseXY;

var tempX = 0;
var tempY = 0;

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

// Organização de Resultados em Formato Excel
function ReOrganizaConsulta(opcao) {
	if (document.organiza) {
		if (opcao.length > 0) {
			document.organiza.ordemSql.value=opcao;
			document.organiza.submit();
		}
	}
	else {
		alert('Sem Formulário para Reorganizar a Consulta!');
	}
}