<?php
/**
* IParagrafo.class.php
* 2008-04-22
* */

class IParagrafo extends IComponenteBase {

private $chAlign; // L left; R right; C center; J justify

function IParagrafo($stId=null, $chAlign='J') {
	parent::IComponenteBase();
	$this->setTag('p');
	$this->setAlign($chAlign);
}

function setAlign($chAlign) {
	$this->chAlign = strtoupper($chAlign);
}

function getAlign() {
	return $this->chAlign;
}

function montaHtml() {
	$stHtml = '<' . $this->getTag();
	if ($this->getId()) { $stHtml .= ' id="' . $this->getId() . '"'; }
	if ($this->getCss()) { $stHtml .= ' class="' . $this->getCss() . '"'; }
	if ($this->getStyle()) { $stHtml .= ' style="' . $this->getStyle() . '"'; }
	if ($this->getAlign()) {
		switch($this->getAlign()) {
			case 'L':
				$stAlign = 'left';
			break;
			case 'R':
				$stAlign = 'right';
			break;
			default:
				$stAlign = 'justify';
			break;
			
		}
		$stHtml .= ' align="' . $stAlign . '"';
	}
	$stHtml .= '>';
	
	foreach ($this->arComponente as $obComponente) {
		$obComponente->montaHtml();
		$stHtml .= $obComponente->getHtml();		
	}
	
	$stHtml .= '</' . $this->getTag() . '>' . "\n";
	$this->stHtml = $stHtml;	
}

}
?>