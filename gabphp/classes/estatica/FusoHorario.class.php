<?
/*
* FusoHorario.class.php
* Classe FusoHorario
* Trabalha com horario local e horario do servidor
*/
class FusoHorario {

var $dataLocal;
var $horaLocal;
var $dataServ;
var $timeStampLocal;
var $timeStampServ;
var $formatoData;
var $formatoHora;
var $fuso;

function fusoHorario() {
	$this->fuso = 0;
	$diaServ = (int) date("d");
	$mesServ = (int) date("m");
	$anoServ = (int) date("Y");
	$horaServ = (int) date("H");
	$minutoServ = (int) date("i");
	$segundoServ = (int) date("s");
	
	$this->formatoData = "d/m/Y";
	$this->formatoHora = "H:i:s";
	
	$this->timeStampServ = mktime($horaServ, $minutoServ, $segundoServ, $mesServ, $diaServ, $anoServ);
	$this->dataServ = date($this->formatoData, $this->timeStampServ);
	$this->timeStampLocal = $this->timeStampServ + $this->fuso;
	$this->dataLocal = date($this->formatoData, $this->timeStampLocal);
}

function setFormatoData($valor) {
	$this->formatoData = $valor;
}

function setFormatoHora($valor) {
	$this->formatoHora = $valor;
}

function setTimeStampServ($valor) {
	$this->timeStampServ = $valor;
}

function setTimeStampLocal($valor) {
	$this->timeStampLocal = $valor;
}

function setFuso($valor) {
	$fuso = 60 * 60 * $valor;
	$this->fuso = $fuso;
}

function getTimeStampLocal() {
	return $this->timeStampLocal;
}

function getDataLocal() {
	return $this->dataLocal;
}

function getHoraLocal() {
	return $this->horaLocal;
}
	
function calculaDataHoraLocal() {
		$fuso = $this->fuso;
		$formato = $this->formatoData;
		$timeLocal = $this->timeStampServ + $fuso;
		$this->timeLocal = $timeLocal;
		$this->dataLocal = date($this->formatoData, $timeLocal);
		$this->horaLocal = date($this->formatoHora, $timeLocal);
	}	


}
?>