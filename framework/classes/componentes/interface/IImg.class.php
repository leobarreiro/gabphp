<?php
/*
* 27/01/2008
* Img.class.php
*/

// <img id="logoLogin" src="GBA_URL_SISTEMAImages/logo.png">

include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class IImg extends IComponenteBase {

var $stSrc;
var $stAlt;

function IImg($stSrc='', $stAlt='') {
	
	parent::IComponenteBase();
	$this->stId = '';
	$this->stCss = '';
	$this->stStyle = '';
	$this->stSrc = $stSrc;
	$this->stAlt = $stAlt;
	
}

function setSrc($stSrc) { $this->stSrc = $stSrc; }
function setAlt($stAlt) { $this->stAlt = $stAlt; }

function getSrc() { return $this->stSrc; }
function getAlt() { return $this->stAlt; }

function montaHtml() {
	
	$stHtml = '<img ';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getCss())) {
		$stHtml .= ' class=' . $this->getCss();
	}
	if (strlen($this->getSrc())) {
		$stHtml .= ' src="' . $this->getSrc() . '"'; 
	}
	if (strlen($this->getStyle())) {
		$stHtml .= ' style="' . $this->getStyle() . '"';
	}
	if (strlen($this->getTitle())) {
		$stHtml .= ' title="' . $this->getTitle() . '"';
	}

	$stHtml .= ' alt="' . $this->getAlt() . '"';
	
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();

	$stHtml .= ' />';
	
	$this->stHtml = $stHtml;
	 
}


}

?>