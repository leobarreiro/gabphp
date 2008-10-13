<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe Estatica de Depuracao e Usos Diversos
    * Data de Criacao: 16/11/2007
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/
class Sistema {

// Metodo para depuracao
	
function phpDebug($var, $die=false) {
	$echoError = (defined('GBA_ERRORS') && GBA_ERRORS > 0) ? true : false;
	if ($echoError) {
		echo "<pre align='left' width=500>\n";
		if (GBA_ERRORS > 100) {
			var_dump($var);	
		} else {
			print_r($var);	
		}		
		echo "</pre>\n";
		if ($die) {
			die;				
		}
	}
}

// Metodos de formatacao de datas e horas

function formataDataHora($date) {
	$retorno = '';
	if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00' || strlen($date) == 0) 	{
		$retorno = '';
	} else {
		// DateTime 
		if (strpos($date, ' ')) {
			$cj = explode(' ', $date);
			$cjDt = explode('-', $cj[0]);
			$retorno = $cjDt[2] . '/' . $cjDt[1] . '/' . $cjDt[0] . ' ' . substr($cj[1], 0, 5) . 'h';
			unset ($cj, $cjDt);
		}
		// Date
		else {
			$cjDt = explode('-', $date);
			$retorno = $cjDt[2] . '/' . $cjDt[1] . '/' . $cjDt[0];
			unset ($cjDt);
		}
	}
	return $retorno;
}

function formataDateTime($var) {
	$arNums = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	$stDateTime = '';
	for($x=0; $x<strlen($var); $x++) {
		if (in_array($var[$x], $arNums)) {
			$stDateTime .= $var[$x];
		}
	}
	// data : ddmmaaaa (8) caracteres
	// data : ddmmaa   (6) caracteres 
	if (strlen($stDateTime) == 6) {
		$dia = substr($stDateTime, 0, 2);
		$mes = substr($stDateTime, 2, 2);
		$ano = substr($stDateTime, 4, 2);
		$ano = '20'.$ano;
		$stRetorno = $ano . '-' . $mes . '-' . $dia;
	} elseif (strlen($stDateTime) == 8) {
		$dia = substr($stDateTime, 0, 2);
		$mes = substr($stDateTime, 2, 2);
		$ano = substr($stDateTime, 4, 4);
		$stRetorno = $ano . '-' . $mes . '-' . $dia;		
	} else {
		$stRetorno = '';
	}
	
	//TODO: implementar datetime (com hora) 

	return $stRetorno;
}

function formataTime($var) {
	$arNums = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	$stTime = '';
	for($x=0; $x<strlen($var); $x++) {
		if (in_array($var[$x], $arNums)) {
			$stTime .= $var[$x];
		}
	}
	// hora : hhmmss (6) caracteres
	// hora : hhmm   (4) caracteres 
	if (strlen($stTime) == 6) {
		$hor = substr($stTime, 0, 2);
		$min = substr($stTime, 2, 2);
		$seg = substr($stTime, 4, 2);
		$stRetorno = $hor . ':' . $min . ':' . $seg;
	} elseif (strlen($stTime) == 4) {
		$hor = substr($stTime, 0, 2);
		$min = substr($stTime, 2, 2);
		$seg = '00';
		$stRetorno = $hor . ':' . $min . ':' . $seg;		
	} else {
		$stRetorno = '';
	}
	return $stRetorno;	
}


// Metodos para Formatacao de Numeros

function formataNumeroParaBD($stNumLatino) {
	$stNumSql = str_replace('.', '', $stNumLatino);
	$stNumSql = str_replace(',', '.', $stNumSql);
	return $stNumSql;	
}

function formataNumeroParaLeitura($flNumSql) {
	$flNumLatino = number_format($flNumSql, 2, ',', '.');
	return $flNumLatino;
}


// Metodos para formatacao de textos

function getTagsHtml() { return array('font', 'b', 'i', 'u', 'center'); }

function getCores() { return array('vermelho', 'verde', 'azul', 'preto', 'amarelo', 'laranja', 'ciano'); }

function getColors() { return array('red', 'green', 'blue', 'black', 'yellow', 'orange', 'cyan'); }

function getCaracteres($stTipo) {
	if ($stTipo == 'negado') {
		$arRetorno = array('\'', '"', '<', '>', '&'); 
	} else { // aceito
		$arRetorno = array('&quot;', '&quot;', '&lt;', '&gt;', '&amp;');
	}
	return $arRetorno;
}

function traduzTagsHtml($stTexto, $boPar=true) {
	
	$arCaracteresNegados = Sistema::getCaracteres('negado');
	$arcaracteresAceitos = Sistema::getCaracteres('aceito');
	
	$stTexto = str_replace($arCaracteresNegados, $arcaracteresAceitos, $stTexto);

	$arSignificado 	= Sistema::getTagsHtml();
	$arCorPortugues = Sistema::getCores();
	$arColorCss		= Sistema::getColors();
	
	$arTagOriginal = array();
	$arTagTraducao = array();
	
	foreach ($arSignificado as $stTag) {
		// abre tags
		$arTagOriginal[] = '[' . $stTag . ']';
		$arTagTraducao[] = '<' . $stTag . '>';
		// fecha tags
		$arTagOriginal[] = '[/' . $stTag . ']';
		$arTagTraducao[] = '</' . $stTag . '>';
		
		for ($y=0; $y<count($arCorPortugues); $y++) {
			// abre tags
			$arTagOriginal[] = '[' . $stTag . ' ' . $arCorPortugues[$y] . ']';
			$arTagTraducao[] = '<' . $stTag . ' style="color:' . $arColorCss[$y] . '">';
		}
	}
	// Traduz as tags de formata��o
	$stTexto = str_replace($arTagOriginal, $arTagTraducao, $stTexto);
	
	// Coloca os par�grafos
	if ($boPar) {
		$stTexto = "<p>" . $stTexto . "</p>"; // inicial
		$stTexto = str_replace("\n", "</p><p>", $stTexto); // intermediarios
	}

	
	return $stTexto;
		
}

// Metodos Matematicos

function geraNumeroAleatorio($inLength=30) {
	for ($i = 1; $i <= $inLength; $i++) {
		if ($i == 1) $randnum = rand(0, 9);
		else $randnum .= rand(0, 9);
	}
	return $randnum;
}

function dataServ()
{
	$obFuso = new FusoHorario;
	$obFuso->setFuso(GBA_FUSO_HORARIO);
	$obFuso->setFormatoData("d/m/y H:i");
	$obFuso->calculaDataHoraLocal();
	$stDataHora = $obFuso->getDataLocal() . 'h.';
	$arDiaSemana = array(0=>'Domingo', 1=>'Segunda', 2=>'Ter&ccedil;a', 3=>'Quarta', 4=>'Quinta', 5=>'Sexta', 6=>'S&aacute;bado');
	$obFuso->setFormatoData("w");
	$obFuso->calculaDataHoraLocal();
	$stDiaSemana = $arDiaSemana[$obFuso->getDataLocal()];
	return $stDiaSemana . ', ' . $stDataHora;
}


}
?>