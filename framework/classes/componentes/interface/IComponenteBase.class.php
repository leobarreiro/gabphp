<?php
/*
* IComponenteBase.class.php
* 28/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');

class IComponenteBase {

var $stTag;
var $stNome;
var $stId;
var $stType;
var $obEvento;
var $arComponente; // array de Objetos contidos
var $stCss;
var $stStyle;
var $stTitle;
var $stHtml;


function IComponenteBase() {
	$this->stCss = '';
	$this->stStyle = '';
	$this->stHtml = '';
	$this->obEvento = new IEvento;
	$this->arComponente = array();
}

function setTag($string) { $this->stTag = $string; }
function setNome($valor) { $this->stNome = $valor; }
function setId($valor) { $this->stId = $valor; }
function setNomeId($string) { $this->stNome = $string; $this->stId = $string; }
function setType($valor) { $this->stType = $valor; }
function setCss($valor) { $this->stCss = $valor; }
function setStyle($valor) { $this->stStyle = $valor; }
function setTitle($stTitle) { $this->stTitle = $stTitle; }

function getTag() { return $this->stTag; }
function getNome() { return $this->stNome; }
function getId() { return $this->stId; }
function getType() { return $this->stType; }
function getCss() { return $this->stCss; }
function getStyle() { return $this->stStyle; }
function getTitle() { return $this->stTitle; }

function addComponente($mixedComponente) {
	if (is_object($mixedComponente)) {
		$this->arComponente[] = $mixedComponente;	
	} elseif (is_array($mixedComponente)) {
		foreach ($mixedComponente as $obComponente) {
			$this->arComponente[] = $obComponente;
		}
	}	
}

// Metodo Base para Implementacao Especialista
function montaHtml() {
	$stHtml = "\n" . '<' . $this->getTag();
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getCss())) {
		$stHtml .= ' class="' . $this->getCss() . '"';
	}
	if (strlen($this->getStyle())) {
		$stHtml .= ' style="' . $this->getStyle() . '"';
	}
	if (strlen($this->getTitle())) {
		$stHtml .= ' title="' . $this->getTitle() . '"';
	}	
	
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
	
	$stHtml .= '>';
	
	foreach ($this->arComponente as $obComponente) {
		$obComponente->montaHtml();
		$stHtml .= $obComponente->getHtml();
	}
		
	$stHtml .= '</' . $this->getTag() . '>';
	$this->stHtml = $stHtml; 
}

// Metodo Padrao para imprimir HTML
function getHtml() { return $this->stHtml; }

function show() {
	$this->montaHtml(); 
	echo $this->stHtml;
}


}
?>