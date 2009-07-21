<?php
/*
 * Linha.class.php
 * 28/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class ILinha extends IComponenteBase {
	
var $stWidth;
var $stHeight;

function ILinha() {
	parent::IComponenteBase();
	$this->stWidth = '';
	$this->stHeight = '';
}

function setWidth($valor) { $this->stWidth = $valor; }
function setHeight($valor) { $this->stHeight = $valor; }
function setAlign($valor) { $this->stAlign = $valor; }

function getWidth() { return $this->stWidth; }
function getHeight() { return $this->stHeight; }
function getAlign() { return $this->stAlign; }

function addComponente($obComponente) {
	$this->arComponente[] = $obComponente;
}

function montaHtml() {
	$stHtml = '<tr';
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getWidth())) {
		$stHtml .= ' width=' . $this->getWidth();
	}
	if (strlen($this->getHeight())) {
		$stHtml .= ' height=' . $this->getHeight();
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
		$stHtml .= "\n        " . $obComponente->getHtml();
	}
	$stHtml .= "\n    " . '</tr>';
	$this->stHtml = $stHtml; 
}

}

?>