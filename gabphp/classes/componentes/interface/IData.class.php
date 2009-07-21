<?php
/*
 * Data.class.php
 * 29/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IInput.class.php');

class IData extends IInput {

function IData() {
	parent::IInput();
	$this->inSize = 10;
	$this->inMaxLength = 10;
	$this->stType = 'text';
	$this->stId = 'data';
	$this->obEvento->setOnKeyDown("solo_numeros(this)");
	$this->obEvento->setOnKeyUp("fecha(this)");
	//$this->obEvento->setOnKeyUp("mascaraData('" . $this->getId() . "')");
	$this->obEvento->setOnBlur("fecha(this)");
}

function setId($string) { 
	$this->stId = $string; 
	$this->obEvento->setOnKeyUp("mascaraData('" . $this->getId() . "')");
}
function setSize($valor) { $this->inSize = $valor; }
function setMaxLength($valor) { $this->inMaxLength = $valor; }
function setValue($valor) { $this->stValue = $valor; }

function getSize() { return $this->inSize; }
function getMaxLength() { return $this->inMaxLength; }
function getValue() { return $this->stValue; }

function montaHtml() {
	$stHtml = '<input';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getType())) {
		$stHtml .= ' type="' . $this->getType() . '"';
	}
	if ( $this->getSize() > 0 ) {
		$stHtml .= ' size=' . $this->getSize();
	}
	if ( $this->getMaxLength() > 0 ) {
		$stHtml .= ' maxlength=' . $this->getMaxLength();
	}
	if (strlen($this->getValue())) {
		$stHtml .= ' value="' . $this->getValue() . '"';
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
	$this->stHtml = $stHtml; 
}

}

?>