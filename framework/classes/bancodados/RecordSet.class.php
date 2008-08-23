<?php
/**
* RecordSet.class.php
* 05/01/2008
* 
* $Id: $
*/

class RecordSet {

var $arResultados;
var $inLinhas;
var $inColunas;
var $inPosicao;

function RecordSet() {

	$this->arResultados = array();
	$this->inLinhas = 0;
	$this->inColunas = 0;
	$this->inPosicao = null;

}

/**
* @param 	roConsulta: executada em obConexao->executaSQL(stSQL)
* @return 	void
* */
function setResultados($roConsulta) {

	while ($ln = mysql_fetch_assoc($roConsulta)) {
		$this->addRegistro($ln);
		$this->inLinhas = $this->inLinhas + 1;
	}

	if (count($this->getLinhas()) > 0) {
		$this->inColunas = count($this->getRegistro(0));
	}

}

function setPosicao($integer) { $this->inPosicao = $integer; }
function setProximo() {	$this->setPosicao( $this->getPosicao() + 1 ); }

function addRegistro($registro) { $this->arResultados[] = $registro; }

/**
* @param 	void
* @return 	Array: Conteúdo do Recordset
* @desc 	Retorna um Array com os Elementos do Recordset
* */
function getResultados() { return $this->arResultados; }
function getLinhas() { return $this->inLinhas; }
function getColunas() { return $this->inColunas; }
function getPosicao() { return $this->inPosicao; }

function getRegistro() {

	if ( isset($this->arResultados[$this->getPosicao()]) ) {
		$retorno = $this->arResultados[$this->getPosicao()];
		$this->setProximo();
	}
	else {
		$this->setPosicao(0);
		$retorno = false;
	}

	return $retorno;

}

function getValor($stCampo) {
	if (isset($this->arResultados[$this->getPosicao()][$stCampo])) {
		return $this->arResultados[$this->getPosicao()][$stCampo];
	} else {
		return null;
	}
}

}
?>
