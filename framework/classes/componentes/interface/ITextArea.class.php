<?php
/*
 * TextArea.class.php
 * 06/01/2008
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');

class ITextArea extends IComponenteBase {
	
var $inCols;
var $inRows;
var $stValue;
var $obEvento;

function ITextArea($stIdNome='') {
	parent::IComponenteBase();
	$this->inCols = 0;
	$this->inRows = 0;
	$this->stValue = '';
	$this->stType = 'textarea';
	if (strlen($stIdNome) > 0) {
		$this->setNomeId($stIdNome);
	}
}

function setCols($integer) { $this->inCols = $integer; }
function setRows($integer) { $this->inRows = $integer; }
function setValue($valor) { $this->stValue = $valor; }

function getCols() { return $this->inCols; }
function getRows() { return $this->inRows; }
function getValue() { return $this->stValue; }

function montaHtml() {
	$stHtml = '<textarea';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if ( $this->getCols() > 0 ) {
		$stHtml .= ' cols=' . $this->getCols();
	}
	if ( $this->getRows() > 0 ) {
		$stHtml .= ' rows=' . $this->getRows();
	}
	if (strlen($this->getCss())) {
		$stHtml .= ' class="' . $this->getCss() . '"';
	}
	if (strlen($this->getStyle())) {
		$stHtml .= ' style="' . $this->getStyle() . '"';
	}
	
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
		
	$stHtml .= '>';
	
	if (strlen($this->getValue())) {
		$stHtml .= $this->getValue();
	}
	
	$stHtml .= '</textarea>';
	$this->stHtml = $stHtml;
	 
}

}

?>