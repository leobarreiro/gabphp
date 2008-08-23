<?php
/*
 * Tabela.class.php
 * 28/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'ILinha.class.php');

class ITabela extends IComponenteBase {
	
var $stAlign;
var $stWidth;
var $stHeight;
var $stCellPadding;
var $stCellSpacing;

function ITabela() {
	parent::IComponenteBase();
	$this->stAlign = '';
	$this->stWidth = '';
	$this->stHeight = '';
	$this->stCellPadding = '';
	$this->stCellSpacing = '';
}

function setAlign($string) { $this->stAlign = $string; }
function setWidth($string) { $this->stWidth = $string; }
function setHeight($string) { $this->stHeight = $string; }
function setCellPadding($string) { $this->stCellPadding = $string; }
function setCellSpacing($string) { $this->stCellSpacing = $string; }

function getAlign() { return $this->stAlign; }
function getWidth() { return $this->stWidth; }
function getHeight() { return $this->stHeight; }
function getCellPadding() { return $this->stCellPadding; }
function getCellSpacing() { return $this->stCellSpacing; }

function addCelula($obCelula, $boNovaLinha=false, $stIdNovaLinha='', $stCssNovaLinha='') {
	
	if ($boNovaLinha) {
		$obLinha = new ILinha;
		if (strlen($stIdNovaLinha)) {
			$obLinha->setNomeId($stIdNovaLinha);
		}
		if (strlen($stCssNovaLinha)) {
			$obLinha->setCss($stCssNovaLinha);
		}
		$obLinha->addComponente($obCelula);
		$this->addComponente($obLinha);
	} else {
		$arLinha = $this->arComponente;
		$obUltimaLinha = $arLinha[count($arLinha)-1];
		$obUltimaLinha->addComponente($obCelula);
		$arLinha[count($arLinha)-1] = $obUltimaLinha;
		$this->arComponente = $arLinha;
	}

}


function novaLinha($stNomeId='', $stCss='') {	
	$obLinha = new ILinha;
	if (strlen($stId)) {
		$obLinha->setNomeId($stNomeId);
	}
	if (strlen($stCss)) {
		$obLinha->setCss($stCss);
	}
	$this->arComponente[] = $obLinha;	
}


function montaHtml() {
	$stHtml = "\n" . '<table';

	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getAlign())) {
		$stHtml .= ' align=' . $this->getAlign();
	}
	if (strlen($this->getCellPadding())) {
		$stHtml .= ' cellpadding=' . $this->getCellPadding();
	}
	if (strlen($this->getCellSpacing())) {
		$stHtml .= ' cellspacing=' . $this->getCellSpacing();
	}
	if (strlen($this->getWidth())) {
		$stHtml .= ' width=' . $this->getWidth();
	}
	if (strlen($this->getHeight())) {
		$stHtml .= ' height=' . $this->getHeight();
	}
	if (strlen($this->getStyle())) {
		$stHtml .= ' style="' . $this->getStyle() . '"';
	}
	if (strlen($this->getCss())) {
		$stHtml .= ' class="' . $this->Css() . '"';
	}
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
	
	$stHtml .= '>' . "\n";
	
	foreach ($this->arComponente as $obComponente) {
		$obComponente->montaHtml();
		$stHtml .= "    " . $obComponente->getHtml() . "\n";
	}
		
	$stHtml .= '</table>' . "\n";
	$this->stHtml = $stHtml; 
}


}

?>