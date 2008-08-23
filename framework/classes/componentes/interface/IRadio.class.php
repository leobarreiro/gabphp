<?php
/*
 * Radio.class.php
 * 29/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IInput.class.php');
include_once (GBA_PATH_CLA_INT . 'ITexto.class.php');

class IRadio extends IInput {
	
var $boSelected;
var $boTxtAntes;
var $obTexto;

function IRadio() {
	parent::iInput();
	$this->stType = 'radio';
	$this->stValue = '1';
	$this->boSelected = false;
	$this->obTexto = new ITexto;
	$this->boTxtAntes = false;
}

function setSelected($bool) { $this->boSelected = $bool; }

function getSelected() { return $this->boSelected; }

function montaHtml() {
		
	$stHtml = '<input';
	if (strlen($this->getNome())) { $stHtml .= ' name="' . $this->getNome() . '"'; }
	if (strlen($this->getId())) { $stHtml .= ' id="' . $this->getId() . '"'; }
	if (strlen($this->getType())) { $stHtml .= ' type="' . $this->getType() . '"'; }
	if ($this->getSelected()) { $stHtml .= ' selected checked'; }
	if (strlen($this->getValue())) { $stHtml .= ' value="' . $this->getValue() . '"'; }
	if (strlen($this->getCss())) { $stHtml .= ' class="' . $this->getCss() . '"'; }
	if (strlen($this->getStyle())) { $stHtml .= ' style="' . $this->getStyle() . '"'; }
	
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
		
	$stHtml .= ' />';
	
	$this->obTexto->montaHtml();
	if ($this->boTxtAntes){ $stHtml = $this->obTexto->getHtml() . "&nbsp;" . $stHtml; }
	else { $stHtml = $stHtml . "&nbsp;" . $this->obTexto->getHtml(); }
	
	$this->stHtml = $stHtml;
	
}


}

?>