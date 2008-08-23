<?php
/*
 * Select.class.php
 * 29/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IInput.class.php');
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');

class ISelect extends IComponenteBase {
	
var $inSize;
var $boMultiple;
var $arOpcao;
var $arSelecionado;
var $obEvento;

function ISelect($stNome='') {
	parent::IComponenteBase();
	$this->stNome = $stNome;
	$this->stId = $stNome;
	$this->arOpcao = array();
	$this->arSelecionado = array();
	$this->boMultiple = false;
	$this->obEvento = new IEvento;
}

function setMultiple($bool) { $this->boMultiple = $bool; }
function setSize($inValor) { $this->inSize = $inValor; }
function setOpcao( $arMatriz ) { $this->arOpcao = $arMatriz; }
function setSelecionado($arValor) { $this->arSelecionado = $arValor; }

function getMultiple() { return $this->boMultiple; }
function getOpcao() { return $this->arOpcao; }
function getSize() { return $this->inSize; }
function getSelecionado() { return $this->arSelecionado; }

function addOpcao($arOpt) { $this->arOpcao[] = $arOpt; }

function montaHtml() {
	$stHtml = '<select';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if ($this->getSize() > 0) {
		$stHtml .= ' size=' . $this->getSize();
	}
	if ($this->getMultiple()) {
		$stHtml .= ' multiple';
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
	foreach ($this->arOpcao as $stOptValor => $stOptTexto) {
		$stOpcao = '<option';
		$stOpcao .= ' value="' . $stOptValor . '"';
		if (in_array($stOptValor, $this->arSelecionado)) {
			$stOpcao .= ' selected';
		}
		$stOpcao .= '>';
		$stOpcao .= $stOptTexto;
		$stOpcao .= '</option>';
		$stHtml .= $stOpcao;
		unset($stOpcao);
	}
	$stHtml .= '</select>';
	
	$this->stHtml = $stHtml; 
}


}

?>