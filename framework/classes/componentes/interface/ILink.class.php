<?php
/*
 * Link.class.php
 * 02/01/2008
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class ILink extends IComponenteBase {

var $stTexto;
var $stHref;
var $stTarget;
var $obEvento;

function ILink($stText=null, $stHref=null, $stTarget='_self') {
	parent::IComponenteBase();
	$this->stTexto = $stText;
	$this->stHref = $stHref;
	$this->stTarget = $stTarget;
}

function setTexto($string) { $this->stTexto = $string; }
function setHref($string) { $this->stHref = $string; }
function setTarget($string) { $this->stTarget = $string; }

function getTexto() { return $this->stTexto; }
function getHref() { return $this->stHref; }
function getTarget() { return $this->stTarget; }

function montaHtml() {
	$stHtml = '<a';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getTarget())) {
		$stHtml .= ' target="' . $this->getTarget() . '"';
	}
	if (strlen($this->getHref())) {
		$stHtml .= ' href="' . $this->getHref() . '"';
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
		
	$stHtml .= '>' . $this->getTexto() . '</a>';
	
	$this->stHtml = $stHtml; 
}

}

?>