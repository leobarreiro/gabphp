<?php
/*
* Body.class.php
* 20/04/2008 
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class IBody extends IComponenteBase {

public function IBody() {
	parent::IComponenteBase();
	$this->setTag('body');
}

public function montaHtml() {
	
	$stHtml = '<' . $this->getTag();
	
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getCss())) {
		$stHtml .= ' class="' . $this->getStyle() . '"';
	}
	if (strlen($this->getStyle())) {
		$stHtml .= ' style="' . $this->getCss() . '"';
	}
	
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
	
	$stHtml .= '>' . "\n";
	
	foreach ($this->arComponente as $obComponente) {
		$obComponente->montaHtml();
		$stHtml .= $obComponente->getHtml() . "\n";
	}
	
	$stHtml .= '</' . $this->getTag() . '>';
	

	$this->stHtml = $stHtml;
	
}

}

?>