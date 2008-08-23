<?php
/*
* Script.class.php
* 27/01/2008
*/

include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');

class IScript extends IComponenteBase {

var $stLanguage;
var $stType;
var $stSrc;
var $arFuncao; // conjunto de expressoes (funcoes ou expressoes javascript)

function IScript($stSrc='') {
	
	parent::IComponenteBase();
	$this->stSrc = $stSrc;
	$this->stLanguage = 'Javascript';
	$this->stType = 'text/javascript';
	$this->arFuncao = array();
}

function setLanguage($stLanguage) { $this->stLanguage = $stLanguage; }
function setType($stType) { $this->stType = $stType; }
function setSrc($stSrc) { $this->stSrc = $stSrc; }

function addFuncao($stFuncao) { $this->arFuncao[] = $stFuncao; }

function getLanguage() { return $this->stLanguage; }
function getType() { return $this->stType; }
function getSrc() { return $this->stSrc; }


function montaHtml() {
	
	$stHtml = "\n\n<script ";
	if (strlen($this->getType())) {
		$stHtml .= ' type="' . $this->getType() . '"';
	}
	if (strlen($this->getLanguage())) {
		$stHtml .= ' language="' . $this->getLanguage() . '"';
	}
	if (strlen($this->getSrc())) {
		$stHtml .= ' src="' . $this->getSrc() . '"'; 
	}
	$stHtml .= "><!--\n";
	
	foreach ($this->arFuncao as $stFuncao) {		
		$stHtml .= "\n";
		$stHtml .= $stFuncao;
		$stHtml .= "\n";
	}
	
	$stHtml .= "\n--></script>\n\n";
		
	$this->stHtml = $stHtml;
	 
}


}

?>