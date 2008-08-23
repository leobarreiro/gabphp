<?php
/*
 * Formulario.class.php
 * 29/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');

class IFormulario extends IComponenteBase {
	
var $stAction;
var $stMethod;
var $stEncoding;
var $stTarget;
var $arComponente; // array de Objetos contidos
var $obEvento;

function IFormulario() {
	parent::IComponenteBase();
	$this->stAction = '';
	$this->stMethod = 'post';
	$this->stEncoding = '';	
}

function setAction($valor) { $this->stAction = $valor; }
function setMethod($valor) { $this->stMethod = strtolower($valor); }
function setEncoding($valor) { $this->stEncoding = $valor; }
function setTarget($valor) { $this->stTarget = $valor; }

function getAction() { return $this->stAction; }
function getMethod() { return $this->stMethod; }
function getEncoding() { return $this->stEncoding; }
function getTarget() { return $this->stTarget; }

function addComponente($obComponente) {
	$this->arComponente[] = $obComponente;
}

function montaHtml() {
	$stHtml = "\n" . '<form';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getAction())) {
		$stHtml .= ' action="' . $this->getAction() . '"';
	}
	if (strlen($this->getMethod())) {
		$stHtml .= ' method="' . $this->getMethod() . '"';
	}
	if (strlen($this->getTarget())) {
		$stHtml .= ' target="' . $this->getTarget() . '"';
	}
	if (strlen($this->getEncoding())) {
		$stHtml .= ' enctype="' . $this->getEncoding() . '"';
	}
		
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
	
	$stHtml .= '>';
	
	foreach ($this->arComponente as $obComponente) {
		$obComponente->montaHtml();
		$stHtml .= "\n" . $obComponente->getHtml();
	}
		
	$stHtml .= '</form>' . "\n";
	$this->stHtml = $stHtml; 
}

}

?>