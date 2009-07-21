<?php
/*
 * Texto.class.php
 * 28/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class ITexto extends IComponenteBase {
	
var $stValue;
var $boBold;
var $boItalic;
var $obEvento;

function ITexto($string='') {
	parent::IComponenteBase();
	$this->stValue = $string;
	$this->boBold = false;
	$this->boItalic = false;
}

function setValue($valor) { $this->stValue = $valor; }
function setBold($boolean) { $this->boBold = $boolean; }
function setItalic($boolean) { $this->boItalic = $boolean; }

function getValue() { return $this->stValue; }
function getBold() { return $this->boBold; }
function getItalic() { return $this->boItalic; }

function montaHtml() {
	
	$stHtml = '';
	if ($this->getBold()) {
		$stHtml .= '<b';
		if (strlen($this->getCss())) {
			$stHtml .= ' class="' . $this->getCss() . '"';
		}
		if (strlen($this->getStyle())) {
			$stHtml .= ' class="' . $this->getStyle() . '"';
		}
		if (strlen($this->getId())) {
			$stHtml .= ' id="' . $this->getId() . '"';
		}
		$stHtml .= '>';
	} 
	if ($this->getItalic()) {
		$stHtml .= '<i';
		if (strlen($this->getCss())) {
			$stHtml .= ' class="' . $this->getCss() . '"';
		}
		if (strlen($this->getStyle())) {
			$stHtml .= ' class="' . $this->getStyle() . '"';
		}
		if (strlen($this->getId())) {
			$stHtml .= ' id="' . $this->getId() . '"';
		}
		$stHtml .= '>';
	}
	
	$stHtml .= $this->stValue;
	
	if ($this->getBold()) {
		$stHtml .= '</b>';
	} 
	if ($this->getItalic()) {
		$stHtml .= '</i>';
	}
	
	$this->stHtml = $stHtml;
	
}

}

?>