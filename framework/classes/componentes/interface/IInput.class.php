<?php
/*
 * Input.class.php
 * 28/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class IInput extends IComponenteBase {
	
var $inSize;
var $inMaxLength;
var $stValue;
var $stType;
var $boReadOnly;

function IInput($stNomeId='', $stValor='', $inSize=0, $inMaxLength=0) {
	parent::IComponenteBase();
	if (strlen($stNomeId)) {
		$this->stNome = $stNomeId;
		$this->stId = $stNomeId;
	}
	$this->inSize = $inSize;
	$this->inMaxLength = $inMaxLength;
	$this->stValue = $stValor;
	$this->stType = 'text';
	$this->boReadOnly = false;
}

function setSize($string) { $this->inSize = $string; }
function setMaxLength($string) { $this->inMaxLength = $string; }
function setValue($string) { $this->stValue = $string; }
function setReadOnly($boolean) { $this->boReadOnly = $boolean; }

function getSize() { return $this->inSize; }
function getMaxLength() { return $this->inMaxLength; }
function getValue() { return $this->stValue; }
function getReadOnly() { return $this->boReadOnly; }

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
		$stHtml .= ' size="' . $this->getSize() . '"';
	}
	if ( $this->getMaxLength() > 0 ) {
		$stHtml .= ' maxlength="' . $this->getMaxLength() . '"';
	}
	if (strlen($this->getValue())) {
		$stHtml .= ' value="' . $this->getValue() . '"';
	}
	if (strlen($this->getCss())) {
		$stHtml .= ' class="' . $this->getCss() . '"';
	}
	if ($this->getReadOnly()) {
		$stHtml .= ' readonly="yes"';
	}
	if (strlen($this->getStyle())) {
		$stHtml .= ' style="' . $this->getStyle() . '"';
	}
	if (strlen($this->getTitle())) {
		$stHtml .= ' title="' . $this->getTitle() . '"';
	}
	
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
		
	$stHtml .= ' />';
	$this->stHtml = $stHtml; 
}

}

?>