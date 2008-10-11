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

/**
 * @param MixedElement (Array, String, integer)
 */
function setSelecionado($mixedValor) {
    if (is_array($mixedValor)) {
        $this->arSelecionado = $mixedValor;
    } else {
        $arSelecionados = $this->arSelecionado;
        $arSelecionados[] = $mixedValor;
        $this->arSelecionado = $arSelecionados;
    }    
}

function getMultiple() { return $this->boMultiple; }
function getOpcao() { return $this->arOpcao; }
function getSize() { return $this->inSize; }
function getSelecionado() { return $this->arSelecionado; }

function addOpcao($stValor, $stLabel) {
    $arOpcoes = $this->arOpcao;
    $arOpcoes[$stValor] = $stLabel;
    $this->arOpcao = $arOpcoes;
    unset($arOpcoes);
}

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
    
    $arOpcao = $this->arOpcao;
	foreach ($arOpcao as $stValor=>$stLabel) {
		$stOpcao = '<option';
		$stOpcao .= ' value="' . $stValor . '"';
		if (in_array($stValor, $this->arSelecionado)) {
			$stOpcao .= ' selected';
		}
		$stOpcao .= '>';
		$stOpcao .= $stLabel;
		$stOpcao .= '</option>';
		$stHtml .= $stOpcao;
		unset($stOpcao);
	}
	$stHtml .= '</select>';
	
	$this->stHtml = $stHtml; 
}


}

?>