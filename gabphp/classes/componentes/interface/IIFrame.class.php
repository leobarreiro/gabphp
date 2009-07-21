<?php
/*
 * IFrame.class.php
 * 06/01/2008
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class IIFrame extends IComponenteBase {
	
var $stPagina;
var $stFrameBorder;
var $stHeight;
var $stWidth;
var $stScrolling;
var $stMarginHeight;
var $stMarginWidth;
var $obEvento;

function IIFrame() {
	
	parent::IComponenteBase();
	
	$this->stPagina;
	$this->stFrameBorder;
	$this->stHeight;
	$this->stWidth;
	$this->stScrolling;
	$this->stMarginHeight;
	$this->stMarginWidth;
		
}

function setPagina($string) { $this->stPagina = $string; }
function setFrameBorder($string) { $this->stFrameBorder = $string; }
function setHeight($string) { $this->stHeight = $string; }
function setWidth($string) { $this->stWidth = $string; }
function setScrolling($string) { $this->stScrolling = $string; }
function setMarginHeight($string) { $this->stMarginHeight = $string; }
function setMarginWidth($string) { $this->stMarginWidth = $string; }

function getPagina() { return $this->stPagina; }
function getFrameBorder() { return $this->stFrameBorder; }
function getHeight() { return $this->stHeight; }
function getWidth() { return $this->stWidth; }
function getScrolling() { return $this->stScrolling; }
function getMarginHeight() { return $this->stMarginHeight; }
function getMarginWidth() { return $this->stMarginWidth; }


function montaHtml() {
	$stHtml = '<iframe';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getPagina())) {
		$stHtml .= ' src="' . $this->getPagina() . '"';
	}
	if (strlen($this->getFrameBorder())) {
		$stHtml .= ' FrameBorder="' . $this->getFrameBorder() . '"';
	}
	if (strlen($this->getHeight())) {
		$stHtml .= ' Height="' . $this->getHeight() . '"';
	}
	if (strlen($this->getWidth())) {
		$stHtml .= ' Width="' . $this->getWidth() . '"';
	}
	if (strlen($this->getScrolling())) {
		$stHtml .= ' Scrolling="' . $this->getScrolling() . '"';
	}
	if (strlen($this->getMarginHeight())) {
		$stHtml .= ' MarginHeight="' . $this->getMarginHeight() . '"';
	}
	if (strlen($this->getMarginWidth())) {
		$stHtml .= ' MarginWidth="' . $this->getMarginWidth() . '"';
	}
	
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
	
	$stHtml .= '>';
	$stHtml .= '</iframe>';
	$this->stHtml = $stHtml;
	 
}


}

?>