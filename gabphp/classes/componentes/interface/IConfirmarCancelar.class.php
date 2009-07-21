<?php
/*
* Componente ConfirmarCancelar.class.php
* 01/01/2008
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'ITabela.class.php');
include_once (GBA_PATH_CLA_INT . 'ILinha.class.php');
include_once (GBA_PATH_CLA_INT . 'ICelula.class.php');
include_once (GBA_PATH_CLA_INT . 'ISelect.class.php');
include_once (GBA_PATH_CLA_INT . 'ITexto.class.php');

class IConfirmarCancelar extends IComponenteBase {
	
var $obBotaoOk;
var $obBotaoCanc;
var $obTexto;

function IConfirmarCancelar() {
	
	$this->obBotaoOk = new IInput;
	$this->obBotaoOk->setType('submit');
	$this->obBotaoOk->setNome('confirmar');
	$this->obBotaoOk->setValue('Confirmar');
	
	
	$this->obTexto = new ITexto;
	$this->obTexto->setValue('&nbsp;');
	
	$this->obBotaoCanc = new IInput;
	$this->obBotaoCanc->setNome('cancelar');
	$this->obBotaoCanc->setType('button');
	$this->obBotaoCanc->setValue('Cancelar');
	$this->obBotaoCanc->obEvento->setOnClick('this.form.reset();');
			
}
	

function montaHtml() {

	$stHtml = '';
	
	$this->obBotaoOk->montaHtml();
	$stHtml .= $this->obBotaoOk->getHtml();
	
	$this->obTexto->montaHtml();
	$stHtml .= $this->obTexto->getHtml();
	
	$this->obBotaoCanc->montaHtml();
	$stHtml .= $this->obBotaoCanc->getHtml();
	
	$this->stHtml = $stHtml;	
	
}

	
}

?>