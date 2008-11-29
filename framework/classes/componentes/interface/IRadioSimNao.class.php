<?php
/*
 * IRadioSimNao.class.php
 * 22/11/2008
 * 
*/
require_once(GBA_PATH_CLA_INT . 'IRadio.class.php');

class IRadioSimNao extends IComponenteBase {
	
var $inSelected; // Qual esta selecionado? 1=sim 0=nao
var $boTxtAntes;
var $radioSim;
var $radioNao;

function IRadioSimNao() {

	$this->radioSim = new IRadio;
	$this->radioSim->setNome('opcao');
	$this->radioSim->setValue('1');
	$this->radioSim->obTexto->setValue('Sim');

	$this->radioNao = new IRadio;
	$this->radioNao->setNome('opcao');
	$this->radioNao->setValue('0');
	$this->radioNao->obTexto->setValue('N&atilde;o');
	
}

function setSelected($inSel) {
	if ($inSel == 1) {
		$this->radioSim->setSelected(true);
		$this->radioNao->setSelected(false);
	} else {
		$this->radioNao->setSelected(true);
		$this->radioSim->setSelected(false);
	}
}

function getSelected() { return $this->boSelected; }

function montaHtml() {

	$stHtml = '';
	
	$this->radioSim->montaHtml();
	$stHtml .= $this->radioSim->getHtml();
	
	$stHtml .= "&nbsp;&nbsp;";
	
	$this->radioNao->montaHtml();
	$stHtml .= $this->radioNao->getHtml();
	
	$this->stHtml = $stHtml;
	
}


}

?>