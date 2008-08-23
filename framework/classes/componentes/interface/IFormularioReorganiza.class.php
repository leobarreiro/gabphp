<?php
/*
* FormularioReorganiza.class.php
* 02/01/2008
* Cria um Formulario que reorganiza a consulta feita ao banco
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'IFormulario.class.php');
include_once (GBA_PATH_CLA_INT . 'IInput.class.php');

class IFormularioReorganiza extends IComponenteBase {

var $obFormulario;
var $arValores; // _POST, _GET, _REQUEST, _SESSION

function setValores($array) { $this->arValores = $array; }

function getValores() { return $this->arValores; }

function getChaves() {
	$arChaves = array_keys($this->arValores);
	return $arChaves;
}

function addCampo($stNome, $mixedValor) {
	$this->arValores[$stNome] = $mixedValor;	
}

function IFormularioReorganiza() {

	$this->obFormulario = new IFormulario;
	$this->arInput = array();
	
	$this->obFormulario->setNome('organiza');
	$this->obFormulario->setAction(substr($_SERVER['SCRIPT_NAME'], (strrpos($_SERVER['SCRIPT_NAME'], '/')+1)));
	$this->obFormulario->setMethod('post');
	$this->obFormulario->setTarget('_self');
	
}

function montaHtml() {
	
	if (!isset($this->arValores['ordemSql'])) {
		$obInput = new IInput;
		$obInput->setType('hidden');
		$obInput->setNome('ordemSql');
		$obInput->setValue('');
		$this->obFormulario->addComponente($obInput);	
	}
	
	$chaves = array_keys($this->arValores);
	foreach ($chaves as $item) {
		$campo = $this->arValores[$item];
		if (is_array($campo)) {
			foreach ($campo as $valor) {
				$obInput = new IInput;
				$obInput->setType('hidden');
				$obInput->setNome($item . '[]');
				$obInput->setValue($valor);
				$this->obFormulario->addComponente($obInput);
			}
		} else {
			$obInput = new IInput;
			$obInput->setType('hidden');
			$obInput->setNome($item);
			$obInput->setValue($this->arValores[$item]);
			$this->obFormulario->addComponente($obInput);
		}
	}
	
	$this->obFormulario->montaHtml();
	$this->stHtml = $this->obFormulario->getHtml();
	
}


}

?>