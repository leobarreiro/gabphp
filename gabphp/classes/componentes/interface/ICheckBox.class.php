<?php
/*
 * CheckBox.class.php
 * 29/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IInput.class.php');
include_once (GBA_PATH_CLA_INT . 'ITexto.class.php');

class ICheckBox extends IInput {

var $boChecked;
var $boTxtAntes;
var $obTexto;

function ICheckBox($stNome='') {
	parent::IInput();	
	$this->stNome = $stNome;
	$this->stId = $stNome;
	$this->stType = 'checkbox';
	$this->stValue = '1';
	$this->boChecked = false;
	$this->boTxtAntes = false;
	$this->obTexto = new ITexto;
}

function setChecked($bool) { $this->boChecked = $bool; }

function getChecked() { return $this->boChecked; }

function montaHtml() {
		
	$stHtml = '<input';
	if (strlen($this->getNome())) { $stHtml .= ' name="' . $this->getNome() . '"'; }
	if (strlen($this->getId())) { $stHtml .= ' id="' . $this->getId() . '"'; }
	if (strlen($this->getType())) { $stHtml .= ' type="' . $this->getType() . '"'; }
	if ($this->boChecked) { $stHtml .= ' checked'; }
	if (strlen($this->getValue())) { $stHtml .= ' value="' . $this->getValue() . '"'; }
	if (strlen($this->getCss())) { $stHtml .= ' class="' . $this->getCss() . '"'; }
	if (strlen($this->getStyle())) {
		$stHtml .= ' style="' . $this->getStyle() . '"';
	}
	if (strlen($this->getTitle())) {
		$stHtml .= ' title="' . $this->getTitle() . '"';
	}
	
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