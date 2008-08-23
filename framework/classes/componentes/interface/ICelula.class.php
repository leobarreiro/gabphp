<?php
/*
 * Celula.class.php
 * 28/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class ICelula extends IComponenteBase {
	
var $stWidth;
var $stHeight;
var $stAlign;
var $stValign;
var $inColspan;
var $inRowspan;

function ICelula($stWidth='', $stAlign='left', $stValign='top') {
	parent::IComponenteBase();
	$this->stWidth = $stWidth;
	$this->stAlign = $stAlign;
	$this->stValign = $stValign;
}

function setWidth($string) { $this->stWidth = $string; }
function setHeight($string) { $this->stHeight = $string; }
function setColspan($integer) { $this->inColspan = $integer; }
function setRowspan($integer) { $this->inRowspan = $integer; }
function setAlign($string) { $this->stAlign = $string; }
function setValign($string) { $this->stValign = $string; }

function getWidth() { return $this->stWidth; }
function getHeight() { return $this->stHeight; }
function getColspan() { return $this->inColspan; }
function getRowspan() { return $this->inRowspan; }
function getAlign() { return $this->stAlign; }
function getValign() { return $this->stValign; }

function montaHtml() {
	$stHtml = '<td';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getAlign())) {
		$stHtml .= ' align="' . $this->getAlign() . '"';
	}
	if (strlen($this->getValign())) {
		$stHtml .= ' valign="' . $this->getValign() . '"';
	}
	if (strlen($this->getWidth())) {
		$stHtml .= ' width="' . $this->getWidth() . '"';
	}
	if (strlen($this->getHeight())) {
		$stHtml .= ' height="' . $this->getHeight() . '"';
	}
	if ( $this->getColspan() > 0 ) {
		$stHtml .= ' colspan=' . $this->getColspan();
	}
	if ( $this->getRowspan() > 0 ) {
		$stHtml .= ' rowspan=' . $this->getRowspan();
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
		
	$stHtml .= '</td>';
	$this->stHtml = $stHtml; 
}

}

?>