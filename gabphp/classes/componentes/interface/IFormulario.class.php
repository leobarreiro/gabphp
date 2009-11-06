<?php
/*
 * Formulario.class.php
 * 29/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');
include_once (GBA_PATH_CLA_INT . 'ITabela.class.php');
include_once (GBA_PATH_CLA_INT . 'ILinha.class.php');
include_once (GBA_PATH_CLA_INT . 'ICelula.class.php');

class IFormulario extends IComponenteBase {
	
var $stAction;
var $stMethod;
var $stEncoding;
var $stTarget;
var $arComponente; // array de Objetos contidos
var $obEvento;
var $boTabelaAtiva;
var $obTabela;
var $arComponenteTabela;

function IFormulario() {
	parent::IComponenteBase();
	$this->stAction = '';
	$this->stMethod = 'post';
	$this->stEncoding = '';
	$this->boTabelaAtiva = false;	
}

function setAction($valor) { $this->stAction = $valor; }
function setMethod($valor) { $this->stMethod = strtolower($valor); }
function setEncoding($valor) { $this->stEncoding = $valor; }
function setTarget($valor) { $this->stTarget = $valor; }

function getAction() { return $this->stAction; }
function getMethod() { return $this->stMethod; }
function getEncoding() { return $this->stEncoding; }
function getTarget() { return $this->stTarget; }

function addComponente($obComponente) {
	$this->arComponente[] = $obComponente;
}

function ativaTabela() {
	$this->boTabelaAtiva = true;
	$this->obTabela = new ITabela();
	$this->obTabela->setAlign('center');
	$this->arComponenteTabela = array();
}

function addComponenteTabela($stLabel, $obMixed, $arWidth=null) {
	
	$arComponenteTabela = $this->arComponenteTabela;
	$arComponenteTabela[] = array($stLabel, $obMixed, $arWidth);
	
	$obTabela = $this->obTabela;
	if (!is_array($arWidth)) {
		$arWidth = array('25%', '75%');
	}
	
	if (strlen($stLabel) > 0) {
		
		$obCelulaLabel = new ICelula($arWidth[0]);
		$obCelulaLabel->addComponente(new ITexto($stLabel));
		$obTabela->addCelula($obCelulaLabel, true); 
		// TODO: Tratar estilo CSS alternado entre linhas aqui.
		
		$obCelulaMixed = new ICelula($arWidth[1]);
		$obCelulaMixed->addComponente($obMixed);
		$obTabela->addCelula($obCelulaMixed, false);
		
	}
	else {
		
		$obCelulaMixed = new ICelula('100%');
		$obCelulaMixed->addComponente($obMixed);
		$obCelulaMixed->setColspan(2);
		$obCelulaMixed->setAlign('center');
		$obTabela->addCelula($obCelulaMixed, true);
		
	}
	
	$this->obTabela = $obTabela;
	
}

function montaHtml() {
	$stHtml = "\n" . '<form';
	if (strlen($this->getNome())) {
		$stHtml .= ' name="' . $this->getNome() . '"';
	}
	if (strlen($this->getId())) {
		$stHtml .= ' id="' . $this->getId() . '"';
	}
	if (strlen($this->getAction())) {
		$stHtml .= ' action="' . $this->getAction() . '"';
	}
	if (strlen($this->getMethod())) {
		$stHtml .= ' method="' . $this->getMethod() . '"';
	}
	if (strlen($this->getTarget())) {
		$stHtml .= ' target="' . $this->getTarget() . '"';
	}
	if (strlen($this->getEncoding())) {
		$stHtml .= ' enctype="' . $this->getEncoding() . '"';
	}
		
	$this->obEvento->montaHtml();
	$stHtml .= $this->obEvento->getHtml();
	
	$stHtml .= '>';
	
	foreach ($this->arComponente as $obComponente) {
		$obComponente->montaHtml();
		$stHtml .= "\n" . $obComponente->getHtml();
	}
	
	if ($this->boTabelaAtiva === true) {
		
		$this->obTabela->montaHtml();
		$stHtml .= "\n" . $this->obTabela->getHtml();
		
	}
		
	$stHtml .= '</form>' . "\n";
	$this->stHtml = $stHtml; 
}

}

?>